<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['enable_hooks'] = TRUE;

$hook['pre_controller'][] = array(
    'class'    => 'MaintenanceMode',
    'function' => 'check_maintenance',
    'filename' => 'MaintenanceMode.php',
    'filepath' => 'hooks',
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'Demo_cleanup_hook',
    'function' => 'ensure_cleanup',
    'filename' => 'Demo_cleanup_hook.php',
    'filepath' => 'hooks',
);
