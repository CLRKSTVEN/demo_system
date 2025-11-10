<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CLI utility that truncates demo databases so each rotation starts with a clean slate.
 *
 * Usage examples:
 *   php index.php cli/demo_cleanup run         # Cleans the database used yesterday.
 *   php index.php cli/demo_cleanup run demo_a  # Forces cleanup for a specific DB.
 */
class Demo_cleanup extends CI_Controller
{
	/**
	 * @var array{databases:array, timezone:string, cutover_time:string, preserve_tables:array, preserve_rows:array}
	 */
	private $demo_rotation_config = array();

	public function __construct()
	{
		parent::__construct();

		if (!$this->input->is_cli_request()) {
			show_error('This controller can only be executed from the command line.', 403);
		}

		$this->load->database();
		$this->demo_rotation_config = $this->load_demo_rotation_config();
	}

	/**
	 * @param string|null $database_name Optional override to clean a specific database.
	 * @return void
	 */
	public function run($database_name = NULL)
	{
		$databases = $this->demo_rotation_config['databases'];
		if (empty($databases)) {
			$this->log_line('No demo databases configured; aborting cleanup.');
			return;
		}

		if ($database_name === NULL) {
			$database_name = $this->determine_previous_database();
			$this->log_line('No override supplied. Cleaning previous-day database: ' . $database_name);
		} else {
			if (!in_array($database_name, $databases, TRUE)) {
				$this->log_line('Database "' . $database_name . '" is not part of the demo rotation. Aborting.');
				return;
			}
			$this->log_line('Manual override request received. Cleaning database: ' . $database_name);
		}

		$this->cleanup_database($database_name);
	}

	/**
	 * Determine which database should be cleaned (the one that was active yesterday).
	 *
	 * @return string
	 */
	private function determine_previous_database()
	{
		$databases = $this->demo_rotation_config['databases'];
		$count = count($databases);
		$timezone = $this->demo_rotation_config['timezone'];
		$cutover_offset_seconds = $this->get_cutover_offset_seconds();

		try {
			$timezone_object = new DateTimeZone($timezone);
			$day_index = $this->calculate_day_index($timezone_object, $cutover_offset_seconds);
		} catch (Exception $e) {
			$this->log_line('Failed to use configured timezone (' . $timezone . '); falling back to server time.');
			$timezone_object = new DateTimeZone(date_default_timezone_get());
			$day_index = $this->calculate_day_index($timezone_object, 0);
		}

		$previous_index = ($day_index + $count - 1) % $count;

		return $databases[$previous_index];
	}

	/**
	 * Truncate every table except those explicitly preserved.
	 *
	 * @param string $database_name
	 * @param array $preserve_tables
	 * @return void
	 */
	private function cleanup_database($database_name)
	{
		$preserve_tables = isset($this->demo_rotation_config['preserve_tables']) && is_array($this->demo_rotation_config['preserve_tables'])
			? $this->demo_rotation_config['preserve_tables']
			: array();

		$preserve_lookup = array_map('strtolower', $preserve_tables);
		$preserve_lookup = array_unique($preserve_lookup);

		$partial_preserve_rules = $this->normalize_partial_preserve_rules(
			isset($this->demo_rotation_config['preserve_rows']) ? $this->demo_rotation_config['preserve_rows'] : array()
		);

		$db = $this->connect_to_database($database_name);
		if (!$db) {
			$this->log_line('Unable to connect to database "' . $database_name . '". Aborting cleanup.');
			return;
		}

		$tables = $db->list_tables();
		if (empty($tables)) {
			$this->log_line('No tables found in ' . $database_name . '; nothing to clean.');
			return;
		}

		$db->query('SET FOREIGN_KEY_CHECKS = 0');
		foreach ($tables as $table) {
			$table_key = strtolower($table);

			if (in_array($table_key, $preserve_lookup, TRUE)) {
				$this->log_line('Skipping preserved table: ' . $table);
				continue;
			}

			if (isset($partial_preserve_rules[$table_key])) {
				$this->delete_rows_except($db, $table, $partial_preserve_rules[$table_key]);
				$this->log_line('Deleted non-preserved rows from: ' . $table);
				continue;
			}

			$db->truncate($table);
			$this->log_line('Truncated table: ' . $table);
		}
		$db->query('SET FOREIGN_KEY_CHECKS = 1');

		$this->log_line('Cleanup complete for database: ' . $database_name);
	}

	/**
	 * Build an isolated connection to the target database.
	 *
	 * @param string $database_name
	 * @return CI_DB_query_builder|false
	 */
	private function connect_to_database($database_name)
	{
		$base_db = $this->db;
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

		return $this->load->database($db_config, TRUE);
	}

	/**
	 * Load the shared demo rotation config.
	 *
	 * @return array
	 */
	private function load_demo_rotation_config()
	{
		$defaults = array(
			'databases' => array('demo_a', 'demo_b'),
			'timezone' => 'Asia/Manila',
			'cutover_time' => '00:00',
			'preserve_tables' => array(),
			'preserve_rows' => array(),
		);

		$config_path = APPPATH . 'config/demo_rotation.php';
		if (file_exists($config_path)) {
			$custom_config = include $config_path;
			if (is_array($custom_config)) {
				$defaults = array_merge($defaults, $custom_config);
			}
		}

		if (empty($defaults['databases'])) {
			$defaults['databases'] = array('demo_a', 'demo_b');
		}

		if (!isset($defaults['preserve_tables']) || !is_array($defaults['preserve_tables'])) {
			$defaults['preserve_tables'] = array();
		}

		if (empty($defaults['cutover_time']) || !is_string($defaults['cutover_time'])) {
			$defaults['cutover_time'] = '00:00';
		}

		if (!isset($defaults['preserve_rows']) || !is_array($defaults['preserve_rows'])) {
			$defaults['preserve_rows'] = array();
		}

		return $defaults;
	}

	/**
	 * Translate the configured cutover time (HH:MM) into seconds from midnight.
	 *
	 * @return int
	 */
	private function get_cutover_offset_seconds()
	{
		$cutover_time = isset($this->demo_rotation_config['cutover_time']) ? $this->demo_rotation_config['cutover_time'] : '00:00';

		if (is_string($cutover_time) && preg_match('/^([01]?\d|2[0-3]):([0-5]\d)$/', $cutover_time, $matches)) {
			return ((int) $matches[1] * 3600) + ((int) $matches[2] * 60);
		}

		return 0;
	}

	/**
	 * Determine the day index (0-365) based on timezone and cutover offset.
	 *
	 * @param DateTimeZone $timezone
	 * @param int $cutover_offset_seconds
	 * @return int
	 */
	private function calculate_day_index(DateTimeZone $timezone, $cutover_offset_seconds)
	{
		$now = new DateTime('now', $timezone);
		$reference_timestamp = $now->getTimestamp() - (int) $cutover_offset_seconds;
		$reference_time = new DateTime('@' . $reference_timestamp);
		$reference_time->setTimezone($timezone);
		return (int) $reference_time->format('z');
	}

	/**
	 * Normalize partial-preserve rules into a predictable structure.
	 *
	 * @param array $rules
	 * @return array
	 */
	private function normalize_partial_preserve_rules($rules)
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

	/**
	 * Delete every row that does not match the preserved conditions.
	 *
	 * @param CI_DB_query_builder $db
	 * @param string $table
	 * @param array $conditions
	 * @return void
	 */
	private function delete_rows_except($db, $table, array $conditions)
	{
		if (empty($conditions)) {
			$this->log_line('No valid preserve conditions for table: ' . $table . '. Skipping deletion.');
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
			$this->log_line('No valid preserve conditions for table: ' . $table . '. Skipping deletion.');
			return;
		}

		$where_clause = implode(' AND ', $where_parts);
		$table_sql = $db->protect_identifiers($table);

		$db->query("DELETE FROM {$table_sql} WHERE NOT ({$where_clause})");
	}

	/**
	 * Allowlist operators for preserve rules.
	 *
	 * @param string $operator
	 * @return string
	 */
	private function sanitize_operator($operator)
	{
		$allowed = array('=', '!=', '<>', 'LIKE');
		$operator = strtoupper($operator);
		return in_array($operator, $allowed, TRUE) ? $operator : '=';
	}

	/**
	 * Simple stdout logging helper.
	 *
	 * @param string $message
	 * @return void
	 */
	private function log_line($message)
	{
		echo '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
	}
}
