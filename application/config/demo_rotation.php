<?php
defined('BASEPATH') or exit('No direct script access allowed');

return array(
    'databases' => array('demo_a', 'demo_b'),
    'timezone' => 'Asia/Manila',
    'cutover_time' => '00:00',
    'preserve_tables' => array(
        'srms_settings_o',
        'track_strand',
        'settings_ethnicity',
        'settings_religion',
        'days_of_school',
        'settings_address',
    ),
    'preserve_rows' => array(
        'o_users' => array(
            array('column' => 'position', 'value' => 'Admin'),
        ),
    ),
);
