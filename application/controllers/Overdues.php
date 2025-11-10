<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Overdues extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');

        $this->load->database();
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'form_validation']);
        $this->load->model('AccountingModel', 'acct');
        $this->load->model('SettingsModel', 'settings');
    }

    public function index()
    {
        $sy        = $this->session->userdata('sy');

        // Filters
        $course    = trim((string)$this->input->get('course'));     // CourseDescription
        $yearLevel = trim((string)$this->input->get('yearLevel'));
        $month     = $this->input->get('month'); // YYYY-MM

        // Options
        $courses    = $this->acct->getAllCourses();
        // YearLevels will be filled dynamically via AJAX; still populate on reload if course is already chosen
        $yearLevels = ($course !== '') ? $this->acct->getYearLevelsForCourse($sy, $course) : [];

        $hasAll = ($course !== '' && $yearLevel !== '' && !empty($month));

        $list = [];
        if ($hasAll) {
            $list = $this->acct->getMonthStatusPerStudent($sy, $month, $course, $yearLevel);
        }

        $school = $this->settings->getSchoolInformation();
        $school = !empty($school) ? $school[0] : null;

        $data = [
            'sy'         => $sy,
            'courses'    => $courses,
            'yearLevels' => $yearLevels,
            'course'     => $course,
            'yearLevel'  => $yearLevel,
            'month'      => $month ?: '',
            'hasAll'     => $hasAll,
            'list'       => $list,
            'school'     => $school,
        ];

        $this->load->view('overdues_course_index', $data);
    }

    /** AJAX: return distinct Year Levels for a Course in current SY (JSON) */
   public function yearlevels()
{
    // NOTE: don't block non-AJAX so dropdowns can populate reliably
    $sy     = $this->session->userdata('sy');
    $course = trim((string)$this->input->get('course'));

    $options = [];
    if ($course !== '') {
        $levels = $this->acct->getYearLevelsForCourse($sy, $course);
        foreach ($levels as $l) {
            if (!empty($l->YearLevel)) {
                $options[] = (string)$l->YearLevel;
            }
        }
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($options));
}


    /** Optional CSV export */
    public function export_csv()
    {
        $sy        = $this->session->userdata('sy');
        $course    = trim((string)$this->input->get('course'));
        $yearLevel = trim((string)$this->input->get('yearLevel'));
        $month     = $this->input->get('month');

        if ($course === '' || $yearLevel === '' || empty($month)) {
            $this->session->set_flashdata('msg_type', 'warning');
            $this->session->set_flashdata('msg', 'Select Course, Year Level, and Month before exporting.');
            return redirect('Overdues');
        }

        $rows = $this->acct->getMonthStatusPerStudent($sy, $month, $course, $yearLevel);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=overdues_'.$sy.'_'.preg_replace('/\s+/', '_', $course).'_'.$yearLevel.'_'.$month.'.csv');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['StudentNumber', 'Full Name', 'Course', 'Year Level', 'SY', 'Month', 'Schedule Due', 'Payments (Month)', 'Status']);
        foreach ($rows as $r) {
            $name = trim(($r->FirstName?:'').' '.($r->MiddleName?:'').' '.($r->LastName?:''));
            fputcsv($out, [
                $r->StudentNumber,
                $name,
                $r->Course,
                $r->YearLevel,
                $sy,
                $month,
                number_format((float)$r->schedule_due, 2, '.', ''),
                number_format((float)$r->payments_month, 2, '.', ''),
                $r->month_status,
            ]);
        }
        fclose($out);
        exit;
    }





//     /** Save currently filtered list to overdue_candidates */
// public function save_batch()
// {
//     // CSRF is handled by CI if enabled; we’ll still read inputs safely
//     $sy        = $this->session->userdata('sy');
//     $course    = trim((string)$this->input->post('course'));
//     $yearLevel = trim((string)$this->input->post('yearLevel'));
//     $month     = $this->input->post('month');

//     if ($course === '' || $yearLevel === '' || empty($month)) {
//         $this->session->set_flashdata('msg_type', 'warning');
//         $this->session->set_flashdata('msg', 'Please select Course, Year Level, and Month before saving.');
//         return redirect('Overdues');
//     }

//     // If you track usernames:
//     $createdBy = $this->session->userdata('username') ?: null;

//     $affected = $this->acct->saveOverdueCandidates($sy, $month, $course, $yearLevel, $createdBy);

//     $this->session->set_flashdata('msg_type', 'success');
//     $this->session->set_flashdata('msg', "Student account have been deactivated.");
//     return redirect('Overdues?course='.rawurlencode($course).'&yearLevel='.rawurlencode($yearLevel).'&month='.rawurlencode($month));
// }




public function save_batch()
{
    $sy        = $this->session->userdata('sy');
    $course    = trim((string)$this->input->post('course'));
    $yearLevel = trim((string)$this->input->post('yearLevel'));
    $month     = $this->input->post('month');

    if ($course === '' || $yearLevel === '' || empty($month)) {
        $this->session->set_flashdata('msg_type', 'warning');
        $this->session->set_flashdata('msg', 'Please select Course, Year Level, and Month before saving.');
        return redirect('Overdues');
    }

    $createdBy = $this->session->userdata('username') ?: null;

    // 1) Save or update the candidate rows (snapshot)
    $affectedSave = $this->acct->saveOverdueCandidates($sy, $month, $course, $yearLevel, $createdBy);

    // 2) Immediately sync their amounts from monthly_payment_schedule (linking)
    $affectedSync = $this->acct->syncOverdueForFilters($sy, $month, $course, $yearLevel);

    $totalAffected = (int)$affectedSave + (int)$affectedSync;

    $this->session->set_flashdata('msg_type', 'success');
    $this->session->set_flashdata(
        'msg',
        "Student account have been deactivated."
    );

    return redirect('Overdues?course='.rawurlencode($course).'&yearLevel='.rawurlencode($yearLevel).'&month='.rawurlencode($month));
}


}
