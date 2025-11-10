<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sf10 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sf10_model');
    }

    public function index($studentNumber = null) {
        if (!$studentNumber) show_404();

        $data['profile'] = $this->Sf10_model->get_student_profile($studentNumber);
        $data['academic_records'] = $this->Sf10_model->get_academic_records_grouped($studentNumber);
        $data['attendance'] = $this->Sf10_model->get_attendance($studentNumber);
        $data['school_info'] = $this->Sf10_model->get_school_info();

        $this->load->view('sf10_view', $data);
    }



public function sf10_elem($studentNumber = null)
{
    if (!$studentNumber) show_404();

    $page = $this->input->get('page') ?? 1;

    $data['profile'] = $this->Sf10_model->get_student_profile($studentNumber);
    $data['academic_records'] = $this->Sf10_model->get_academic_elem_grouped($studentNumber);
    $data['attendance'] = $this->Sf10_model->get_attendance($studentNumber);
    $data['school_info'] = $this->Sf10_model->get_school_info();
    $data['studentNumber'] = $studentNumber;

    if ($page == 2) {
        $this->load->view('sf10_elem_back', $data);
    } else {
        $this->load->view('sf10_elem_front', $data);
    }
}


    public function sf10_shs($studentNumber = null) {
        if (!$studentNumber) show_404();

        // Fetch SHS specific data
        $data['profile'] = $this->Sf10_model->get_student_profile($studentNumber);
        $data['academic_records'] = $this->Sf10_model->get_academic_shs_grouped($studentNumber);
        $data['attendance'] = $this->Sf10_model->get_attendance($studentNumber);
        $data['school_info'] = $this->Sf10_model->get_school_info();

        // Fetch specialized subjects for SHS
        $data['specialized_subjects'] = $this->Sf10_model->get_specialized_subjects($studentNumber);

        // Load the SF10-SHS view
        $this->load->view('sf10_shs_view', $data);
    }


}
