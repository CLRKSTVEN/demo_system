<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shs_report extends CI_Controller
{
    public function rlpd($studentNumber = null)
    {
        if (!$studentNumber) show_404();
        $this->load->database(); // in case DB isn't autoloaded

        // SY from query or session
        $sy = $this->input->get('sy', true) ?: (string)$this->session->userdata('sy');

        // Basic records (safe fallbacks if tables/fields vary)
        $stud     = $this->db->get_where('studeprofile', ['StudentNumber' => $studentNumber])->row();
        $sem_stud = $this->db->get_where('semesterstude', ['StudentNumber' => $studentNumber, 'SY' => $sy])->row();
        $cur_stud = $sem_stud;

        // Principal (optional)
        $prin = (object)['SchoolHead' => ''];
        if ($this->db->table_exists('srms_settings_o') && $this->db->field_exists('SchoolHead','srms_settings_o')) {
            $row = $this->db->select('SchoolHead')->limit(1)->get('srms_settings_o')->row();
            if ($row) $prin->SchoolHead = $row->SchoolHead;
        }

       // Grades for SHS (two-sem structure) — no JOINs, only columns that exist in `grades`
$this->db->select("
    g.SubjectCode,
    g.Description,
    g.PGrade, g.MGrade, g.Average,
    g.Sem AS semester
");
$this->db->from('grades g');
$this->db->where('g.StudentNumber', $studentNumber);
$this->db->where('g.SY', $sy);
$this->db->where_in('g.Sem', [
    'First Semester','Second Semester','1st Sem','2nd Sem','1st Semester','2nd Semester'
]);
// order: first sem then second sem then by description
$this->db->order_by("FIELD(g.Sem,
    'First Semester','1st Sem','1st Semester',
    'Second Semester','2nd Sem','2nd Semester'
)", "", false);
$this->db->order_by('g.Description','ASC');

$rows = $this->db->get()->result();

// If no SHS-style semester rows were found (e.g., JHS data), fall back to all grades for the SY
if (empty($rows)) {
    $this->db->reset_query();
    $this->db->select("
        SubjectCode,
        Description,
        PGrade, MGrade, Average,
        Sem AS semester,
        subComponent
    ");
    $this->db->from('grades');
    $this->db->where('StudentNumber', $studentNumber);
    $this->db->where('SY', $sy);
    $this->db->order_by('Description','ASC');
    $rows = $this->db->get()->result();
}

        // Deportment exclusions (optional)
        $deported_codes = [];
        $yl = $sem_stud->YearLevel ?? $stud->YearLevel ?? '';
        if ($this->db->table_exists('subject_deportment')) {
            $r = $this->db->select('subjectCode')->from('subject_deportment')->where('yearLevel', $yl)->get()->result();
            $deported_codes = array_values(array_unique(array_map(fn($x)=>(string)$x->subjectCode, $r)));
        }

        // Load the SHS view you saved earlier
        $this->load->view('shs_rlpd', [
            'selected_sy'    => $sy,
            'stud'           => $stud,
            'sem_stud'       => $sem_stud,
            'cur_stud'       => $cur_stud,
            'prin'           => $prin,
            'data'           => $rows,
            'deported_codes' => $deported_codes,
        ]);
    }
}
