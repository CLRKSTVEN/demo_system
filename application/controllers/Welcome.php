<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->database();
		$query = $this->db->query('SELECT DATABASE() AS db');
		$db_name = ($query && $query->num_rows() > 0) ? $query->row()->db : 'unknown';

		log_message('debug', 'Active demo DB: ' . $db_name);

		echo '<div style="background:#fff3cd;color:#856404;padding:10px;text-align:center;font-weight:bold;">';
		echo 'Active Demo Database: ' . htmlspecialchars($db_name, ENT_QUOTES, 'UTF-8');
		echo '</div>';

		$this->load->view('hris_home', array('active_demo_db' => $db_name));
	}
}
