<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Demo_rotation_service
{
    protected $CI;
    protected $config = array();
    protected $state_path;

    public function __construct()
    {
        $this->CI =& get_instance();

        if (!isset($this->CI->db)) {
            $this->CI->load->database();
        }

        $this->config = $this->load_config();
        $this->state_path = APPPATH . 'cache/demo_rotation_state.json';
    }

    public function get_config()
    {
        return $this->config;
    }

    public function determine_previous_database()
    {
        $context = $this->get_day_context();
        $databases = $this->config['databases'];
        $count = count($databases);
        $previous_index = ($context['day_index'] + $count - 1) % $count;
        return $databases[$previous_index];
    }

    public function cleanup($database_name, $logger = null)
    {
        if (empty($database_name)) {
            $this->log($logger, 'No database specified for cleanup.');
            return FALSE;
        }

        $databases = $this->config['databases'];
        if (!in_array($database_name, $databases, TRUE)) {
            $this->log($logger, 'Database "' . $database_name . '" is not part of the demo rotation. Aborting cleanup.');
            return FALSE;
        }

        $preserve_tables = isset($this->config['preserve_tables']) && is_array($this->config['preserve_tables']) ? $this->config['preserve_tables'] : array();
        $preserve_lookup = array_map('strtolower', $preserve_tables);
        $preserve_lookup = array_unique($preserve_lookup);
        $partial_rules = $this->normalize_partial_preserve_rules(isset($this->config['preserve_rows']) ? $this->config['preserve_rows'] : array());

        $db = $this->connect_to_database($database_name);
        if (!$db) {
            $this->log($logger, 'Unable to connect to database "' . $database_name . '". Aborting cleanup.');
            return FALSE;
        }

        $tables = $db->list_tables();
        if (empty($tables)) {
            $this->log($logger, 'No tables found in ' . $database_name . '; nothing to clean.');
            return TRUE;
        }

        $db->query('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($tables as $table) {
            $table_key = strtolower($table);

            if (in_array($table_key, $preserve_lookup, TRUE)) {
                $this->log($logger, 'Skipping preserved table: ' . $table);
                continue;
            }

            if (isset($partial_rules[$table_key])) {
                $this->delete_rows_except($db, $table, $partial_rules[$table_key]);
                $this->log($logger, 'Deleted non-preserved rows from: ' . $table);
                continue;
            }

            $db->truncate($table);
            $this->log($logger, 'Truncated table: ' . $table);
        }

        $db->query('SET FOREIGN_KEY_CHECKS = 1');
        $this->log($logger, 'Cleanup complete for database: ' . $database_name);

        return TRUE;
    }

    public function auto_cleanup_if_needed()
    {
        if (empty($this->config['auto_cleanup'])) {
            return;
        }

        $context = $this->get_day_context();
        if (!$this->has_passed_cutover($context['now'], $context['timezone'])) {
            return;
        }

        $state = $this->read_state();
        if (isset($state['last_cleanup_day']) && $state['last_cleanup_day'] === $context['day_index']) {
            return;
        }

        $target = $this->determine_previous_database();
        $success = $this->cleanup($target, function ($message) {
            log_message('info', '[demo-auto-cleanup] ' . $message);
        });

        if ($success) {
            $state['last_cleanup_day'] = $context['day_index'];
            $state['last_cleanup_time'] = date('c');
            $state['last_cleanup_target'] = $target;
            $this->write_state($state);
        }
    }

    protected function load_config()
    {
        $defaults = array(
            'databases' => array('demo_a', 'demo_b'),
            'timezone' => 'Asia/Manila',
            'cutover_time' => '00:00',
            'auto_cleanup' => FALSE,
            'auto_cleanup_grace_minutes' => 5,
            'preserve_tables' => array(),
            'preserve_rows' => array(),
        );

        $path = APPPATH . 'config/demo_rotation.php';
        if (file_exists($path)) {
            $custom = include $path;
            if (is_array($custom)) {
                $defaults = array_merge($defaults, $custom);
            }
        }

        if (empty($defaults['databases'])) {
            $defaults['databases'] = array('demo_a', 'demo_b');
        }

        if (!is_array($defaults['preserve_tables'])) {
            $defaults['preserve_tables'] = array();
        }

        if (!is_array($defaults['preserve_rows'])) {
            $defaults['preserve_rows'] = array();
        }

        return $defaults;
    }

    protected function get_day_context()
    {
        $timezone = new DateTimeZone($this->config['timezone']);
        $cutover_offset_seconds = $this->get_cutover_offset_seconds();
        $now = new DateTime('now', $timezone);
        $reference_timestamp = $now->getTimestamp() - $cutover_offset_seconds;
        $reference_time = new DateTime('@' . $reference_timestamp);
        $reference_time->setTimezone($timezone);

        return array(
            'timezone' => $timezone,
            'now' => $now,
            'day_index' => (int) $reference_time->format('z'),
        );
    }

    protected function get_cutover_offset_seconds()
    {
        $cutover = isset($this->config['cutover_time']) ? $this->config['cutover_time'] : '00:00';
        if (is_string($cutover) && preg_match('/^([01]?\d|2[0-3]):([0-5]\d)$/', $cutover, $matches)) {
            return ((int) $matches[1] * 3600) + ((int) $matches[2] * 60);
        }

        return 0;
    }

    protected function has_passed_cutover(DateTime $now, DateTimeZone $timezone)
    {
        $cutover_time = isset($this->config['cutover_time']) ? $this->config['cutover_time'] : '00:00';
        $cutover = DateTime::createFromFormat('Y-m-d H:i', $now->format('Y-m-d') . ' ' . $cutover_time, $timezone);

        if (!$cutover) {
            return TRUE;
        }

        if ($now < $cutover) {
            return FALSE;
        }

        $grace = (int) $this->config['auto_cleanup_grace_minutes'];
        if ($grace > 0) {
            $cutover->modify('+' . $grace . ' minutes');
        }

        return $now >= $cutover;
    }

    protected function connect_to_database($database_name)
    {
        $base_db = $this->CI->db;
        if (!$base_db) {
            return FALSE;
        }

        $db_config = array(
            'dsn' => isset($base_db->dsn) ? $base_db->dsn : '',
            'hostname' => $base_db->hostname,
            'username' => $base_db->username,
            'password' => $base_db->password,
            'database' => $database_name,
            'dbdriver' => $base_db->dbdriver,
            'dbprefix' => $base_db->dbprefix,
            'pconnect' => FALSE,
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => isset($base_db->cachedir) ? $base_db->cachedir : '',
            'char_set' => $base_db->char_set,
            'dbcollat' => $base_db->dbcollat,
            'swap_pre' => $base_db->swap_pre,
            'encrypt' => $base_db->encrypt,
            'compress' => $base_db->compress,
            'stricton' => $base_db->stricton,
            'failover' => $base_db->failover,
            'save_queries' => $base_db->save_queries,
        );

        return $this->CI->load->database($db_config, TRUE);
    }

    protected function normalize_partial_preserve_rules($rules)
    {
        if (!is_array($rules)) {
            return array();
        }

        $normalized = array();

        foreach ($rules as $table => $conditions) {
            if (!is_array($conditions)) {
                continue;
            }

            $table_key = strtolower($table);

            foreach ($conditions as $condition) {
                if (!is_array($condition)) {
                    continue;
                }

                $column = isset($condition['column']) ? trim($condition['column']) : '';
                if ($column === '' || !array_key_exists('value', $condition)) {
                    continue;
                }

                $normalized[$table_key][] = array(
                    'column' => $column,
                    'value' => $condition['value'],
                    'operator' => isset($condition['operator']) ? strtoupper(trim($condition['operator'])) : '=',
                );
            }

            if (empty($normalized[$table_key])) {
                unset($normalized[$table_key]);
            }
        }

        return $normalized;
    }

    protected function delete_rows_except($db, $table, array $conditions)
    {
        if (empty($conditions)) {
            return;
        }

        $where_parts = array();
        foreach ($conditions as $condition) {
            $column = $db->protect_identifiers($condition['column']);
            $operator = $this->sanitize_operator(isset($condition['operator']) ? $condition['operator'] : '=');
            $value = $db->escape($condition['value']);
            $where_parts[] = "{$column} {$operator} {$value}";
        }

        if (empty($where_parts)) {
            return;
        }

        $where_clause = implode(' AND ', $where_parts);
        $table_sql = $db->protect_identifiers($table);

        $db->query("DELETE FROM {$table_sql} WHERE NOT ({$where_clause})");
    }

    protected function sanitize_operator($operator)
    {
        $allowed = array('=', '!=', '<>', 'LIKE');
        $operator = strtoupper($operator);
        return in_array($operator, $allowed, TRUE) ? $operator : '=';
    }

    protected function read_state()
    {
        if (!file_exists($this->state_path)) {
            return array();
        }

        $raw = file_get_contents($this->state_path);
        $decoded = json_decode($raw, TRUE);
        return is_array($decoded) ? $decoded : array();
    }

    protected function write_state(array $state)
    {
        if (!is_dir(dirname($this->state_path))) {
            mkdir(dirname($this->state_path), 0755, TRUE);
        }

        file_put_contents($this->state_path, json_encode($state));
    }

    protected function log($logger, $message)
    {
        if ($logger && is_callable($logger)) {
            call_user_func($logger, $message);
        } else {
            log_message('info', $message);
        }
    }
}
