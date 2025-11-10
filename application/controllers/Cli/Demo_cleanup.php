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
    public function __construct()
    {
        parent::__construct();

        if (!$this->input->is_cli_request()) {
            show_error('This controller can only be executed from the command line.', 403);
        }

        $this->load->library('Demo_rotation_service');
    }

    /**
     * @param string|null $database_name Optional override to clean a specific database.
     * @return void
     */
    public function run($database_name = NULL)
    {
        $config = $this->demo_rotation_service->get_config();
        $databases = $config['databases'];

        if (empty($databases)) {
            $this->log_line('No demo databases configured; aborting cleanup.');
            return;
        }

        if ($database_name === NULL) {
            $database_name = $this->demo_rotation_service->determine_previous_database();
            $this->log_line('No override supplied. Cleaning previous-day database: ' . $database_name);
        } else {
            if (!in_array($database_name, $databases, TRUE)) {
                $this->log_line('Database "' . $database_name . '" is not part of the demo rotation. Aborting.');
                return;
            }
            $this->log_line('Manual override request received. Cleaning database: ' . $database_name);
        }

        $this->demo_rotation_service->cleanup($database_name, function ($message) {
            $this->log_line($message);
        });
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
