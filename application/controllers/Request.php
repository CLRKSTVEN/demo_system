<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('RequestModel');
        $this->load->library('user_agent');
        $this->load->library('session');
    }

    // Admin view
    public function index()
    {
        $data['requests'] = $this->RequestModel->get_all_requests();
        $this->load->view('request', $data);
    }

    // Student view
    public function my_requests()
    {
        $studentNumber = $this->session->userdata('username');
        $data['requests'] = $this->RequestModel->get_requests_by_student($studentNumber);
        $data['doc_types'] = $this->RequestModel->get_active_document_types();
        $this->load->view('my_requests', $data);
    }

   
    public function submit_request()
    {
        $data = [
            'StudentNumber' => $this->session->userdata('username'),
            'document_type' => $this->input->post('document_type'),
            'purpose'       => $this->input->post('purpose'),
            'status'        => 'Pending'
        ];

        $this->RequestModel->insert_request($data);
        $this->session->set_flashdata('msg', 'Document request submitted.');
       redirect($this->agent->referrer());

    }

   public function update_status($id)
{
    $status = $this->input->post('status');
    $remarks = $this->input->post('remarks');
    $by = $this->session->userdata('IDNumber');

    // Update main request
    $updateData = [
        'status' => $status,
        'remarks' => $remarks,
        'processed_by' => $by,
        'released_date' => date('Y-m-d H:i:s')
    ];
    $this->RequestModel->update_status($id, $updateData);

    // Log the change
    $logData = [
        'request_id' => $id,
        'status' => $status,
        'remarks' => $remarks,
        'updated_by' => $by
    ];
    $this->RequestModel->log_status_change($logData);

    $this->session->set_flashdata('msg', '<div class="alert alert-success">Request status updated and logged.</div>');
    redirect('request');
}

// List all document types
public function document_types()
{
    $data['types'] = $this->RequestModel->get_all_document_types();
    $this->load->view('request_doc_type', $data);
}

// Save new type
public function save_document_type()
{
    $data = [
        'document_name' => $this->input->post('document_name'),
        'description' => $this->input->post('description'),
        'is_active' => $this->input->post('is_active') ? 1 : 0
    ];
    $this->RequestModel->insert_document_type($data);
    $this->session->set_flashdata('msg', 'Document type added.');
    redirect($this->agent->referrer());
}

// Update existing type
public function update_document_type($id)
{
    $data = [
        'document_name' => $this->input->post('document_name'),
        'description' => $this->input->post('description'),
        'is_active' => $this->input->post('is_active') ? 1 : 0
    ];
    $this->RequestModel->update_document_type($id, $data);
    $this->session->set_flashdata('msg', 'Document type updated.');
    redirect($this->agent->referrer());
}

// Delete type
public function delete_document_type($id)
{
    $this->RequestModel->delete_document_type($id);
    $this->session->set_flashdata('msg', 'Document type deleted.');
   redirect($this->agent->referrer());
}


}
