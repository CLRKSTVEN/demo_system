<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Messages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MessageModel');
        $this->load->model('UserModel');
        $this->load->helper('form');
        $this->load->library('session');

        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
    }

    public function inbox()
    {
        $data['messages'] = $this->MessageModel->getInbox($this->session->userdata('username'));
        $this->load->view('message_inbox', $data);
    }

    public function compose()
    {
        $data['users'] = $this->UserModel->getAllUsersExcept($this->session->userdata('username'));
        $this->load->view('message_compose', $data);
    }

    public function send()
    {
        $this->MessageModel->sendMessage($this->input->post());
        redirect('messages/inbox');
    }

    public function view($id)
    {
        $this->MessageModel->markAsRead($id);
        $data['message'] = $this->MessageModel->getMessage($id);
        $this->load->view('message_view', $data);
    }
}
