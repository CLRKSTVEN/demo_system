<?php
defined('BASEPATH') or exit('No direct script access allowed');


$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
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
	'database' => 'srmsportal_bnhs',
	// 'database' => 'srmsportal_glcbed',
	// 'database' => 'srmsportal_bostones',

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
