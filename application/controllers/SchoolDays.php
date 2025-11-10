<?php
class SchoolDays extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SchoolDays_model');
    }

    public function index()
    {
        $data['data'] = $this->SchoolDays_model->getAll();
        $this->load->view('school_days_view', $data);
    }

    public function insert()
    {
        $this->SchoolDays_model->insert($this->input->post());
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Entry added successfully.</div>');
        redirect('SchoolDays');
    }

    public function update($id)
    {
        $this->SchoolDays_model->update($id, $this->input->post());
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Updated successfully.</div>');
        redirect('SchoolDays');
    }

    public function delete($id)
    {
        $this->SchoolDays_model->delete($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-danger">Deleted successfully.</div>');
        redirect('SchoolDays');
    }
}