<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubjectDeportment extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SubjectDeportmentModel');
        $this->load->model('SubjectModel');
        $this->load->library('session');
        $this->load->helper(['url','security']);
    }

    // Load the CRUD page
    public function index()
    {
        // List each concrete subject row (id, code, desc, yearLevel)
        $data['subjects']    = $this->SubjectModel->get_all_subjects();
        // No separate yearLevel select anymore
        $data['deportments'] = $this->SubjectDeportmentModel->get_all_deportments();

        $this->load->view('subject_deportment_view', $data);
    }

    // Add Deportment (one row only, based on concrete subject id)
    public function add()
    {
        $subject_id = (int) $this->input->post('subject_id', true);
        if (!$subject_id) {
            $this->session->set_flashdata('danger', 'Please select a subject.');
            redirect('SubjectDeportment');
        }

        $sub = $this->SubjectModel->get_by_id($subject_id);
        if (!$sub) {
            $this->session->set_flashdata('danger', 'Selected subject not found.');
            redirect('SubjectDeportment');
        }

        // Build the row to insert
        $data = [
            'subjectCode' => (string) $sub->subjectCode,
            'description' => (string) $sub->description,
            'yearLevel'   => (string) $sub->yearLevel,
        ];

        // Prevent duplicate (same subjectCode + yearLevel)
        if ($this->SubjectDeportmentModel->exists($data['subjectCode'], $data['yearLevel'])) {
            $this->session->set_flashdata('danger', 'Deportment already exists for this Subject & Year Level.');
            redirect('SubjectDeportment');
        }

        $this->SubjectDeportmentModel->insert_deportment($data);
        $this->session->set_flashdata('success', 'Subject Deportment added successfully!');
        redirect('SubjectDeportment');
    }

    // Delete Deportment
    public function delete($id)
    {
        $this->SubjectDeportmentModel->delete_deportment((int)$id);
        $this->session->set_flashdata('danger', 'Subject Deportment deleted successfully!');
        redirect('SubjectDeportment');
    }
}
