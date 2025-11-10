<?php
defined('BASEPATH') or exit('No direct script access allowed');


$active_group = 'default';
$query_builder = TRUE;

// Load the demo rotation config so switching logic can be reused elsewhere.
$demo_rotation_defaults = array(
    'databases' => array('demo_a', 'demo_b'),
    'timezone' => 'Asia/Manila',
    'cutover_time' => '00:00',
);
$demo_rotation_config = $demo_rotation_defaults;
$demo_rotation_config_path = defined('APPPATH') ? APPPATH . 'config/demo_rotation.php' : null;
if ($demo_rotation_config_path && file_exists($demo_rotation_config_path)) {
    $custom_demo_rotation = include $demo_rotation_config_path;
    if (is_array($custom_demo_rotation)) {
        $demo_rotation_config = array_merge($demo_rotation_config, $custom_demo_rotation);
    }
}

// Rotate between the demo databases based on the configured cutover time.
$demo_databases = !empty($demo_rotation_config['databases']) ? $demo_rotation_config['databases'] : $demo_rotation_defaults['databases'];
$active_demo_database = reset($demo_databases);
$timezone = !empty($demo_rotation_config['timezone']) ? $demo_rotation_config['timezone'] : $demo_rotation_defaults['timezone'];
$cutover_time = isset($demo_rotation_config['cutover_time']) ? $demo_rotation_config['cutover_time'] : $demo_rotation_defaults['cutover_time'];
$cutover_offset_seconds = 0;
if (is_string($cutover_time) && preg_match('/^([01]?\d|2[0-3]):([0-5]\d)$/', $cutover_time, $matches)) {
    $cutover_offset_seconds = ((int) $matches[1] * 3600) + ((int) $matches[2] * 60);
}

if (!empty($demo_databases)) {
    try {
        $timezone_object = new DateTimeZone($timezone);
        $current_time = new DateTime('now', $timezone_object);
        $reference_timestamp = $current_time->getTimestamp() - $cutover_offset_seconds;
        $reference_time = new DateTime('@' . $reference_timestamp);
        $reference_time->setTimezone($timezone_object);
        $day_index = (int) $reference_time->format('z'); // 0-365, resets every year.
        $active_demo_database = $demo_databases[$day_index % count($demo_databases)];
    } catch (Exception $e) {
        // Fall back to the first database if the date/time calculation fails.
    }
}

$db['default'] = array(
    'dsn'   => '',
    // WCM AWS Connection
    // 'hostname' => 'srms-db-new.ce0mhjgkvjuk.ap-southeast-2.rds.amazonaws.com',
    // 'username' => 'admin',
    // 'password' => 'Wcm-softtech2024',
    // 'database' => 'srmsportal_vmcbed',
    // 'database' => 'ihmamati_srms',

    // GLC Online Connection
    // 'hostname' => '198.23.58.128',
    // 'password' => 'moth34board',
    // 'database' => 'wcmanilasrms_bed',
    // 'database' => 'srmsportal_vmcbed',


    // GLC Local Connection
    'hostname' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    // 'database' => 'srmsportal_glcbed',
    // 'database' => 'srmsportal_bnhs1',
    // 'database' => 'srmsportal_bnhs',
    // 'database' => 'srmsportal_glcbed',
    // 'database' => 'srmsportal_bostones',
    'database' => $active_demo_database,
    
    // 'database' => 'srmsportal_cernhs',
    // 'database' => 'srmsportal_tyrn',
    // 'database' => 'ihmamati_srms',
    // 'database' => 'srmsportal_demo1',
    // 'database' => 'wcmanilasrms_bed',



    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
