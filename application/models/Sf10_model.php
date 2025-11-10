<?php
class Sf10_model extends CI_Model {

    // Get the student's profile information
    public function get_student_profile($studentNumber) {
        return $this->db->get_where('studeprofile', ['StudentNumber' => $studentNumber])->row();
    }

    // Get academic records for JHS (Grade 7 - Grade 10)
    public function get_academic_records_grouped($studentNumber) {
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where_in('YearLevel', ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10']);
        $this->db->order_by('SY', 'ASC');
        $this->db->order_by('YearLevel', 'ASC');
        $this->db->order_by('SubjectCode', 'ASC');
        $query = $this->db->get('grades')->result();

        $grouped = [];
        foreach ($query as $row) {
            $key = $row->SY . ' - ' . $row->YearLevel;
            $grouped[$key][] = $row;
        }

        return $grouped;
    }

    // Get academic records for SHS (Grade 11 and Grade 12)
    public function get_academic_shs_grouped($studentNumber) {
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where_in('YearLevel', ['Grade 11', 'Grade 12']);
        $this->db->order_by('SY', 'ASC');
        $this->db->order_by('YearLevel', 'ASC');
        $this->db->order_by('SubjectCode', 'ASC');
        $query = $this->db->get('grades')->result();

        $grouped = [];
        foreach ($query as $row) {
            $key = $row->SY . ' - ' . $row->YearLevel;
            $grouped[$key][] = $row;
        }

        return $grouped;
    }

    // Get attendance record for the student (JHS, Elem, SHS)
    public function get_attendance($studentNumber) {
        return $this->db->get_where('stude_attendance', ['StudentNumber' => $studentNumber])->row();
    }

    // Get school information (shared between JHS, Elem, and SHS)
public function get_school_info() {
    return $this->db->select('SchoolName, SchoolIDJHS, SchoolIDSHS, district, Division, Region')
                    ->from('srms_settings_o')
                    ->get()
                    ->row();
}


    // Get specialized subjects for SHS (Track/Strand specific)
    public function get_specialized_subjects($studentNumber) {
        // Query specialized subjects for SHS, assuming they are in the 'grades' table and identified by 'track' and 'strand'
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where_in('YearLevel', ['Grade 11', 'Grade 12']);
        $this->db->where('track !=', '');
        $this->db->where('strand !=', '');
        $query = $this->db->get('grades')->result();

        return $query;
    }

    // Get academic records for Elementary (Grade 01 - Grade 06)
    public function get_academic_elem_grouped($studentNumber) {
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where_in('YearLevel', ['Grade 01', 'Grade 02', 'Grade 03', 'Grade 04', 'Grade 05', 'Grade 06']);
        $this->db->order_by('SY', 'ASC');
        $this->db->order_by('YearLevel', 'ASC');
        $this->db->order_by('SubjectCode', 'ASC');
        $query = $this->db->get('grades')->result();

        $grouped = [];
        foreach ($query as $row) {
            $key = $row->SY . ' - ' . $row->YearLevel;
            $grouped[$key][] = $row;
        }

        return $grouped;
    }
}
