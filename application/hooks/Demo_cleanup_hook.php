<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Demo_cleanup_hook
{
    public function ensure_cleanup()
    {
        if (is_cli()) {
            return;
        }

        $CI =& get_instance();
        $CI->load->library('Demo_rotation_service');
        $CI->demo_rotation_service->auto_cleanup_if_needed();
    }
}
