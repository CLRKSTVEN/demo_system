<?php
class Proficiency extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProficiencyModel');
    }

    public function index()
    {
        $sy = $this->session->userdata('sy');
        $section = $this->input->get('section');
        $data['students'] = $this->ProficiencyModel->getStudentsBySection($sy, $section);
        $this->load->view('proficiency_list', $data);
    }

    public function view($studentNumber)
    {
        $sy = $this->session->userdata('sy');
        $data['student'] = $studentNumber;
        $data['subjects'] = $this->ProficiencyModel->getSubjectsByStudent($studentNumber, $sy);
        $data['records'] = $this->ProficiencyModel->getProficiencyRecords($studentNumber, $sy);
        $this->load->view('proficiency_view', $data);
    }

    public function save()
    {
        $data = $this->input->post(); // expects: StudentNumber, SubjectCode, Quarter, Score, ProficiencyLevel
        $data['SY'] = $this->session->userdata('sy');
        $this->ProficiencyModel->saveProficiency($data);
        redirect('Proficiency/view/' . $data['StudentNumber']);
    }
}
