<?php defined('BASEPATH') or exit('No direct script access allowed');

class OnlineSettings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('level') !== 'Super Admin') {
            show_error('Access Denied', 403);
        }

        $this->load->model('SrmsSettingsModel');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');

        $this->load->vars([
            'online_settings' => $this->SrmsSettingsModel->get_setting()
        ]);
    }

    public function index()
    {
        $data['online_settings'] = $this->SrmsSettingsModel->get_setting();
        $this->load->view('online_settings', $data);
    }

    public function OnlinePaymentSettings()
    {
        $data['online_settings'] = $this->SrmsSettingsModel->get_setting();
        $this->load->view('online_settings_details', $data);
    }

    public function save()
    {
        $show = $this->input->post('show_online_payments') ? 1 : 0;
        $this->SrmsSettingsModel->update_toggle($show);
        $this->session->set_flashdata('success', 'Online Payments visibility updated.');
        redirect('OnlineSettings');
    }
}
