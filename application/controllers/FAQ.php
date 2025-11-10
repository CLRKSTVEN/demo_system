<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FAQ extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load any required models if needed
        // $this->load->model('Faq_model');
    }

    public function index()
    {
        // Load the FAQ view
        $this->load->view('faq');
    }
}
