<?php
class SubjectManager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SubjectModel');
    }

    public function index()
    {
        $result['course'] = $this->SubjectModel->course();
        $result['strands'] = $this->SubjectModel->get_strands();

        $allSubjects = $this->SubjectModel->get_subjects_ordered();
        $groupedSubjects = [];

        foreach ($allSubjects as $subject) {
            $grade = strtoupper(trim($subject->YearLevel));
            $sem = $subject->Semester ?: 'N/A';
            $strand = $subject->Course ?: 'N/A';

            // Only group by semester for SHS strands
            if (!in_array(strtolower($subject->Course), ['abm', 'humss', 'stem', 'gas', 'tvl'])) {
                $sem = 'N/A';
            }

            $groupedSubjects[$grade][$sem][$strand][] = $subject;
        }

        uksort($groupedSubjects, function ($a, $b) {
            return intval(filter_var($a, FILTER_SANITIZE_NUMBER_INT)) <=> intval(filter_var($b, FILTER_SANITIZE_NUMBER_INT));
        });

        $result['groupedSubjects'] = $groupedSubjects;
        $this->load->view('subjects', $result);
    }

    public function updateDisplayOrder()
    {
        $sortedIds = $this->input->post('sorted_ids');
        $yearLevel = $this->input->post('yearLevel');
        $sem = $this->input->post('sem');
        $strand = $this->input->post('strand');

        if (!empty($sortedIds)) {
            foreach ($sortedIds as $order => $id) {
                $this->SubjectModel->updateSubjectOrder($id, $order + 1, $yearLevel, $sem, $strand);
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No IDs received']);
        }
    }
}

