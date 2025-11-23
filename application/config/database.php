<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group  = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'      => '',

    // =========================
    // LOCAL (XAMPP) — ACTIVE
    // =========================
    'hostname' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'database' => 'ihmamati_srms',

    // =========================
    // CPANEL (COMMENTED; UNCOMMENT ON DEPLOY)
    // =========================
    // 'hostname' => 'localhost',                 // cPanel MySQL host is usually 'localhost'
    // 'username' => 'srmsportal_demo1',         // cPanel DB user
    // 'password' => 'moth34board',              // cPanel DB password
    // 'database' => 'srmsportal_demo1',         // cPanel DB name (prefix if your cPanel uses one)

    'dbdriver'  => 'mysqli',
    'dbprefix'  => '',
    'pconnect'  => FALSE,
    'db_debug'  => (ENVIRONMENT !== 'production'),
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => 'utf8',                      // you can switch to 'utf8mb4' if your schema supports it
    'dbcollat'  => 'utf8_general_ci',           // or 'utf8mb4_general_ci'
    'swap_pre'  => '',
    'encrypt'   => FALSE,
    'compress'  => FALSE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries' => TRUE
);
