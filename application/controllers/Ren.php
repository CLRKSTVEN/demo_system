<?php
class Ren extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('url', 'form');
        $this->load->library('form_validation');
        $this->load->model('StudentModel');
        $this->load->model('SettingsModel');
        $this->load->model('PersonnelModel');
        $this->load->model('InstructorModel');
        $this->load->model('LibraryModel');
        $this->load->model('Login_model');
        $this->load->model('Common');


        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
    }


    //     function report_card()
    //     {
    //         $result['title'] = "Report Card";
    //         $result['letterhead'] = $this->Login_model->loginImage();
    //         $result['data'] = $this->Common->two_cond_gb('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy, 'SubjectCode', 'SubjectCode', 'ASC');
    //         $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
    //         $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
    //         $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
    //         // Add this line after fetching $result['cur_stud']
    // $result['is_preschool'] = in_array($result['cur_stud']->YearLevel, ['Preschool', 'Kinder', 'Kinder 1', 'Kinder 2']);

    //         $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


    //         $this->load->view('report_card', $result);
    //     }


  public function report_card()
{
    $studentNumber = $this->uri->segment(3);

    // 1) Resolve SY: ?sy=, 4th segment, or session
    $sy = $this->input->get('sy', true);
    if (!$sy) {
        $segSy = $this->uri->segment(4);
        $sy = $segSy ? $segSy : (string) $this->session->userdata('sy');
    }

    // 2) Load settings FIRST (so we can read preschoolGrade safely)
    $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');

    // 3) Header/meta
    $result['title']      = "Report Card";
    $result['letterhead'] = $this->Login_model->loginImage();

    // 4) Grades for the selected SY
    $result['data'] = $this->Common->two_cond_gb(
        'grades', 'StudentNumber', $studentNumber,
        'SY', $sy, 'SubjectCode', 'SubjectCode', 'ASC'
    );

    // 5) Student profile
    $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $studentNumber);

    // 6) Get YearLevel/Section *for that SY*
    $sem = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $studentNumber, 'SY', $sy);
    if (!$sem) {
        // fallback if no row in semesterstude
        $sem = $this->Common->two_cond_row('registration', 'StudentNumber', $studentNumber, 'SY', $sy);
    }
    $result['sem_stud'] = $sem;
    $result['cur_stud'] = $sem; // keep compatibility with your view

    // 7) Preschool / grade type logic based on the SY-specific YearLevel
    $yl = $sem->YearLevel ?? ($result['stud']->YearLevel ?? null);
    $result['is_preschool']       = in_array($yl, ['Preschool','Kinder','Kinder 1','Kinder 2'], true);
    $result['preschoolGradeType'] = strtolower($result['prin']->preschoolGrade ?? 'numeric');

    // 8) Narrative remarks (only if we have level/section for this SY)
    $result['narrative'] = null;
    if ($sem && !empty($sem->YearLevel) && !empty($sem->Section)) {
        $result['narrative'] = $this->Common->four_cond_row(
            'narrative',
            'StudentNumber', $studentNumber,
            'SY',           $sy,
            'YearLevel',    $sem->YearLevel,
            'Section',      $sem->Section
        );
    }

    // 9) Attendance/day counts for the selected SY
    // Ordered months + days of school
    $this->db->select('month, year, days_count');
    $this->db->where('SY', $sy);
    $this->db->order_by("STR_TO_DATE(CONCAT(month, ' ', year), '%M %Y')");
    $school_days = $this->db->get('days_of_school')->result();

    $months = [];
    $days_of_school = [];
    foreach ($school_days as $row) {
        $months[] = $row->month;
        $days_of_school[$row->month] = (int) $row->days_count;
    }

    // Attendance logs for the SY
    $this->db->select('date_recorded, Period, attendance, remarks');
    $this->db->from('advisory_attendance');
    $this->db->where('StudentNumber', $studentNumber);
    $this->db->where('SY', $sy);
    $attendanceLogs = $this->db->get()->result();

    $days_present = [];
    $times_tardy  = [];

    foreach ($attendanceLogs as $log) {
        $month = date('F', strtotime($log->date_recorded));
        if (!isset($days_present[$month])) $days_present[$month] = 0;
        if (!isset($times_tardy[$month]))  $times_tardy[$month]  = 0;

        if ((int)$log->attendance === 1) {
            $days_present[$month] += 0.5; // AM/PM = 0.5
        }
        if (stripos((string)$log->remarks, 'tardy') !== false ||
            stripos((string)$log->remarks, 'late')  !== false) {
            $times_tardy[$month]++;
        }
    }

    $result['months']          = $months;
    $result['days_of_school']  = $days_of_school;
    $result['days_present']    = $days_present;
    $result['times_tardy']     = $times_tardy;

    
    
    // >>> NEW: load the deported subject codes for this Year Level
    $this->load->model('SubjectDeportmentModel');
    $result['deported_codes'] = $this->SubjectDeportmentModel->get_codes_by_yearlevel($yl);
    // <<<


    $result['selected_sy'] = $sy;

    $this->load->view('report_card', $result);
}


    function report_card_jhs()
    {
        $result['title'] = "Report Card";
        $result['letterhead'] = $this->Login_model->loginImage();
        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


        $this->load->view('report_cardv2', $result);
    }

    function report_card_deped()
    {
        $result['title'] = "Report Card";

        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


        $this->load->view('report_card_deped', $result);
    }

    function report_card_depedp2()
    {
        $result['title'] = "Report Card";

        $result['data'] = $this->Common->two_cond_gb('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy, 'SubjectCode', 'SubjectCode', 'ASC');

        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


        $this->load->view('report_card_depedp2', $result);
    }

    function rc_sf9_es()
    {
        $studentNumber = $this->uri->segment(3);
        $sy = $this->session->userdata('sy');

        $result['title'] = "Report Card";

        // Dynamic sem grades
        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', $studentNumber, 'SY', $sy, 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', $studentNumber, 'SY', $sy, 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $studentNumber);
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $studentNumber, 'SY', $sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $studentNumber, 'SY', $sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');

        // Days of School
        $this->db->select('month, year, days_count');
        $this->db->where('SY', $sy);
        $this->db->order_by("STR_TO_DATE(CONCAT(month, ' ', year), '%M %Y')");
        $school_days = $this->db->get('days_of_school')->result();

        $months = [];
        $days_of_school = [];
        foreach ($school_days as $row) {
            $months[] = $row->month;
            $days_of_school[$row->month] = (int)$row->days_count;
        }

        $this->db->select('date_recorded, Period, attendance, remarks');
        $this->db->from('advisory_attendance');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $sy);
        $attendanceLogs = $this->db->get()->result();

        $days_present = [];
        foreach ($attendanceLogs as $log) {
            $month = date('F', strtotime($log->date_recorded));
            if (!isset($days_present[$month])) $days_present[$month] = 0;
            if ($log->attendance == 1) $days_present[$month] += 0.5;
        }

        // Derive days absent = school days - days present
        $days_absent = [];
        foreach ($months as $m) {
            $days_absent[$m] = isset($days_of_school[$m]) ? ($days_of_school[$m] - ($days_present[$m] ?? 0)) : 0;
        }

        $result['months'] = $months;
        $result['days_of_school'] = $days_of_school;
        $result['days_present'] = $days_present;
        $result['days_absent'] = $days_absent;

        $this->load->view('rc_sf9_es', $result);
    }

    function rc_sf9_esv2()
    {
        $result['title'] = "Report Card";

        $result['data'] = $this->Common->two_cond_gb('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy, 'SubjectCode', 'SubjectCode', 'ASC');


        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


        $this->load->view('rc_sf9p2', $result);
    }

    // function rc_sf9_js()
    // {
    //     $result['title'] = "Report Card";

    //     $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
    //     $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

    //     $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
    //     $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
    //     $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
    //     $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


    //     $this->load->view('rc_sf9_js', $result);
    // }

    public function rc_sf9_js()
    {
        $studentNumber = $this->uri->segment(3);
        $sy = $this->session->userdata('sy');

        $result['title'] = "Report Card";

        // Dynamic sem grades
        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', $studentNumber, 'SY', $sy, 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', $studentNumber, 'SY', $sy, 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $studentNumber);
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $studentNumber, 'SY', $sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $studentNumber, 'SY', $sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');

        // Days of School
        $this->db->select('month, year, days_count');
        $this->db->where('SY', $sy);
        $this->db->order_by("STR_TO_DATE(CONCAT(month, ' ', year), '%M %Y')");
        $school_days = $this->db->get('days_of_school')->result();

        $months = [];
        $days_of_school = [];
        foreach ($school_days as $row) {
            $months[] = $row->month;
            $days_of_school[$row->month] = (int)$row->days_count;
        }

        $this->db->select('date_recorded, Period, attendance, remarks');
        $this->db->from('advisory_attendance');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $sy);
        $attendanceLogs = $this->db->get()->result();

        $days_present = [];
        foreach ($attendanceLogs as $log) {
            $month = date('F', strtotime($log->date_recorded));
            if (!isset($days_present[$month])) $days_present[$month] = 0;
            if ($log->attendance == 1) $days_present[$month] += 0.5;
        }

        // Derive days absent = school days - days present
        $days_absent = [];
        foreach ($months as $m) {
            $days_absent[$m] = isset($days_of_school[$m]) ? ($days_of_school[$m] - ($days_present[$m] ?? 0)) : 0;
        }

        $result['months'] = $months;
        $result['days_of_school'] = $days_of_school;
        $result['days_present'] = $days_present;
        $result['days_absent'] = $days_absent;

        $this->load->view('rc_sf9_js', $result);
    }


    function rc_sf9_jsp2()
    {
        $result['title'] = "Report Card";

        $result['data'] = $this->Common->two_cond_gb('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy, 'SubjectCode', 'SubjectCode', 'ASC');


        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


        $this->load->view('rc_sf9_jsp2', $result);
    }

    function rc_sf9_ss()
    {
        $result['title'] = "Report Card";

        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


        $this->load->view('rc_sf9_ss', $result);
    }

    function rc_sf9_ssp2()
    {
        $result['title'] = "Report Card";

        $result['data'] = $this->Common->two_cond_gb('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy, 'SubjectCode', 'SubjectCode', 'ASC');


        $result['shs'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'First Semester', 'SubjectCode', 'SubjectCode', 'ASC');
        $result['shs2'] = $this->Common->three_cond_gb('grades', 'StudentNumber', 20231444, 'SY', "2023-2024", 'Sem', 'Second Semester', 'SubjectCode', 'SubjectCode', 'ASC');

        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['sem_stud'] = $this->Common->two_cond_row('grades', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['cur_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');


        $this->load->view('rc_sf9_ssp2', $result);
    }

    function rc_sf10()
    {
        $result['title'] = "Report Card";
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');
        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['semesterstude'] = $this->Common->one_cond_gb('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', 'SY', 'ASC');

        $this->load->view('rc_sf10', $result);
    }

    function rc_sf10_jhs()
    {
        $result['title'] = "Report Card";
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');
        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['semesterstude'] = $this->Common->two_cond_gb('semesterstude', 'StudentNumber', $this->uri->segment(3), 'Course', 'Junior High School', 'YearLevel', 'SY', 'ASC');


        $result['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->input->post('stud'), 'SY', $this->session->sy);
        $result['student'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->input->post('stud'));
        $result['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
$result['studs'] = $this->Common->two_join_one_cond(
    'semesterstude',
    'studeprofile',
    'b.StudentNumber, b.FirstName, b.MiddleName, b.LastName, a.SY, a.YearLevel',
    'b.StudentNumber = a.StudentNumber',
    ['a.SY' => $this->session->sy, 'a.Course' => 'Junior High School'],
    'b.StudentNumber',
    'b.LastName',
    'ASC'
);


        $this->load->view('rc_sf10_jhs', $result);
    }

    function rc_sf10_jsh()
    {
        $result['title'] = "Report Card";
        $result['prin'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', '1');
        $result['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $result['semesterstude'] = $this->Common->two_cond_gb('semesterstude', 'StudentNumber', $this->uri->segment(3), 'Course', 'Junior High School', 'YearLevel', 'SY', 'ASC');

        $this->load->view('rc_sf10_jhs', $result);
    }

    function enrollment_summary()
    {
        $result['es'] = $this->Common->two_join_two_cond_gb('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'Status', 'Enrolled', 'SY', $this->session->sy, 'YearLevel', 'YearLevel', 'ASC');
        $this->load->view('en_sum', $result);
    }

    function enrollment_summaryv2()
    {
        $result['es'] = $this->Common->no_cond_gb('semesterstude', 'YearLevel', 'YearLevel', 'ASC');
        $this->load->view('en_sumv2', $result);
    }

    function enrollment_summaryv3()
    {
        $result['es'] = $this->Common->one_cond_gb('semesterstude', 'SY', $this->session->sy, 'Course', 'Course', 'ASC');
        $this->load->view('en_sumv3', $result);
    }


    function profileEntry()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('FirstName', 'First Name', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "profile_form";

            if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New Profile";
            $data['religion'] = $this->Common->no_cond('settings_religion');
            $data['ethnicity'] = $this->Common->no_cond('settings_ethnicity');
            $data['brgy'] = $this->Common->no_cond('settings_address');
            $data['province'] = $this->Common->no_cond_gb('settings_address', 'Province', 'Province', 'ASC');
            $data['city'] = $this->Common->no_cond_gb('settings_address', 'City', 'City', 'ASC');
            $data['prevschool'] = $this->Common->no_cond('prevschool');


            $this->load->view($page, $data);
        } else {
            $this->Ren_model->profile_insert();
            $this->Ren_model->user_insert();
            $this->Ren_model->atrail_insert("Created Student's Profile and User Account");
            $this->session->set_flashdata('success', 'Profile has been saved successfully.');
            redirect(base_url() . 'Ren/profileEntry');
        }
    }

    function updateStudeProfile()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('FirstName', 'First Name', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "profile_form_update";

            if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Update Profile";
            $data['religion'] = $this->Common->no_cond('settings_religion');
            $data['ethnicity'] = $this->Common->no_cond('settings_ethnicity');
            $data['brgy'] = $this->Common->no_cond('settings_address');
            $data['province'] = $this->Common->no_cond_gb('settings_address', 'Province', 'Province', 'ASC');
            $data['city'] = $this->Common->no_cond_gb('settings_address', 'City', 'City', 'ASC');
            $data['prevschool'] = $this->Common->no_cond('prevschool');
            $data['data'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->input->get('id'));


            $this->load->view($page, $data);
        } else {
            $this->Ren_model->profile_update();
            $this->Ren_model->atrail_insert("Updated Profile");
            $this->session->set_flashdata('success', 'Updated successfully.');
            redirect(base_url() . 'page/studentsprofile?id=' . $this->input->get('id'));
        }
    }


    function sub_enlist()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('FirstName', 'First Name', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "enlistment";

            if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New Profile";
            $data['stud'] = $this->Common->two_join_one_cond_not_gb('semesterstude', 'studeprofile', 'StudentNumber,FirstName,MiddleName,LastName,SY', 'StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');
            $data['stud_register'] = $this->Common->one_cond_gb('registration', 'SY', $this->session->sy, 'StudentNumber', 'StudentNumber', 'ASC');


            $this->load->view($page, $data);
        } else {
            $this->Ren_model->profile_insert();
            $this->Ren_model->user_insert();
            $this->Ren_model->atrail_insert("Created Student's Profile and User Account");
            $this->session->set_flashdata('success', 'Profile has been saved successfully.');
            redirect(base_url() . 'Ren/profileEntry');
        }
    }

    public function deleteReg($studentNumber, $sy)
    {

        $deleteSuccess = $this->StudentModel->deleteRegistration($studentNumber, $sy);

        if ($deleteSuccess) {

            $this->session->set_flashdata('msg', '<div class="alert alert-success">Enrollment deleted successfully.</div>');
        } else {

            $this->session->set_flashdata('error', 'Error deleting enrollment. Please try again.');
        }

        redirect(base_url() . 'Ren/sub_enlist');
    }


    function subject_list()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('FirstName', 'First Name', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "subject_enlistment";

            if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New Profile";
            //$data['stud'] = $this->Common->two_cond('semesterstude', 'SY', $this->session->sy, 'Semester', $this->session->semester);


            $this->load->view($page, $data);
        } else {
            $this->Ren_model->enlistment_insert();
            $this->session->set_flashdata('success', 'Profile has been saved successfully.');
            redirect(base_url() . 'Ren/profileEntry');
        }
    }

    function subject_list_update()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('FirstName', 'First Name', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "subject_enlistment_update";

            if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New Profile";
            //$data['stud'] = $this->Common->two_cond('semesterstude', 'SY', $this->session->sy, 'Semester', $this->session->semester);


            $this->load->view($page, $data);
        } else {
            $this->Ren_model->enlistment_insert();
            $this->session->set_flashdata('success', 'Profile has been saved successfully.');
            redirect(base_url() . 'Ren/profileEntry');
        }
    }

    public function subject_lists()
    {
        // Retrieve form data
        $StudentNumber = $this->input->post('StudentNumber');
        $subjectCodes = $this->input->post('SubjectCode');
        $descriptions = $this->input->post('Description');
        $sections = $this->input->post('Section');
        $schedTimes = $this->input->post('SchedTime');
        $Room = $this->input->post('Room');
        $Instructor = $this->input->post('Instructor');
        $Sem = $this->input->post('Sem');
        $SY = $this->input->post('SY');
        $Course = $this->input->post('Course');
        $YearLevel = $this->input->post('YearLevel');
        $strand = $this->input->post('strand');
        $IDNumber = $this->input->post('IDNumber');

        if (
            $StudentNumber && $subjectCodes && $descriptions && $sections && $schedTimes &&
            $Room && $Instructor && $Sem && $SY && $Course && $YearLevel
        ) {
            $data = [];
            foreach ($subjectCodes as $index => $code) {
                $data[] = [
                    'SubjectCode' => $code,
                    'Description' => $descriptions[$index],
                    'Section' => $sections[$index],
                    'SchedTime' => $schedTimes[$index],
                    'StudentNumber' => $StudentNumber[$index],
                    'Room' => $Room[$index],
                    'Instructor' => $Instructor[$index],
                    'Sem' => $Sem[$index],
                    'SY' => $SY[$index],
                    'Course' => $Course[$index],
                    'YearLevel' => $YearLevel[$index],
                    'strand' => $strand[$index],
                    'IDNumber' => $IDNumber[$index]
                ];
            }

            // Insert data into the database
            $this->Ren_model->insert_batch($data);

            // Redirect or display success message
            redirect(base_url() . 'Ren/sub_enlist');
        } else {
            // Handle the case where no data is posted
            show_error('No data posted');
        }
    }

    function cor()
    {
        $page = "cor";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "CERTIFICATE OF ENROLLMENT";
        $data['subject'] = $this->Common->two_cond('registration', 'StudentNumber', $this->uri->segment('3'), 'SY', $this->session->sy, 'Semester', $this->session->semester);
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment('3'), 'SY', $this->session->sy, 'Semester', $this->session->semester);
        $data['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment('3'));
        $data['letterhead'] = $this->Login_model->loginImage();

        $this->load->view($page, $data);
    }

    function corv2()
    {
        $page = "corv2";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "CERTIFICATE OF ENROLLMENT";
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment('3'), 'SY', $this->session->sy, 'Semester', $this->session->semester);
        $data['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment('3'));
        $data['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
        $data['letterhead'] = $this->Login_model->loginImage();

        $this->load->view($page, $data);
    }

    // public function inputGrade()
    // {
    //     $pgrades = $this->input->post('PGrade');
    //     $mgrades = $this->input->post('MGrade');
    //     $p_final_grades = $this->input->post('PFinalGrade');
    //     $f_grades = $this->input->post('FGrade');
    //     $student_no = $this->input->post('StudentNumber');
    //     $adviser = $this->input->post('adviser');
    //     $strand = $this->input->post('strand');

    //     $data = [];
    //     for ($i = 0; $i < count($pgrades); $i++) {
    //         $data[] = [
    //             'StudentNumber' => $student_no[$i],
    //             'adviser' => $adviser[$i],
    //             'description' => $this->input->post('description'),
    //             'section' => $this->input->post('section'),
    //             'SY' => $this->input->post('SY'),
    //             'Instructor' => $this->input->post('Instructor'),
    //             'SubjectCode' => $this->input->post('SubjectCode'),
    //             'PGrade' => $pgrades[$i],
    //             'MGrade' => $mgrades[$i],
    //             'PFinalGrade' => $p_final_grades[$i],
    //             'FGrade' => $f_grades[$i],
    //             'strand' => $strand[$i],
    //             'YearLevel' => $this->input->post('YearLevel'),
    //         ];
    //     }

    //     if ($this->Ren_model->insert_grades($data)) {
    //         $this->session->set_flashdata('success', 'Grades added successfully!');
    //     } else {
    //         $this->session->set_flashdata('error', 'Failed to add grades.');
    //     }

    //     redirect(base_url() . 'Instructor/subjectGrades?subjectcode=' . $this->input->post('SubjectCode') . '&description=' . $this->input->post('description') . '&section=' . $this->input->post('section') . '&strand=' . $this->input->post('strands') . '&ins=' . $this->input->post('ins'));
    // }


    // public function updateGrade()
    // {
    //     $pgrades = $this->input->post('PGrade');
    //     $mgrades = $this->input->post('MGrade');
    //     $p_final_grades = $this->input->post('PFinalGrade');
    //     $f_grades = $this->input->post('FGrade');
    //     $student_no = $this->input->post('StudentNumber');
    //     $adviser = $this->input->post('adviser');
    //     $gradeID = $this->input->post('gradeID');

    //     $data = [];
    //     for ($i = 0; $i < count($pgrades); $i++) {
    //         $data[] = [
    //             'StudentNumber' => $student_no[$i],
    //             'adviser' => $adviser[$i],
    //             'description' => $this->input->post('description'),
    //             'section' => $this->input->post('section'),
    //             'SY' => $this->input->post('SY'),
    //             'Instructor' => $this->input->post('Instructor'),
    //             'SubjectCode' => $this->input->post('SubjectCode'),
    //             'PGrade' => $pgrades[$i],
    //             'MGrade' => $mgrades[$i],
    //             'PFinalGrade' => $p_final_grades[$i],
    //             'FGrade' => $f_grades[$i],
    //             'gradeID' => $gradeID[$i],
    //         ];
    //     }

    //     if ($this->Ren_model->update_grades($data)) {
    //         $this->session->set_flashdata('success', 'Grades update successfully!');
    //     } else {
    //         $this->session->set_flashdata('error', 'Failed to update grades.');
    //     }

    //     redirect(base_url() . 'Instructor/subjectGrades?subjectcode=' . $this->input->post('SubjectCode') . '&description=' . $this->input->post('description') . '&section=' . $this->input->post('section') . '&strand=' . $this->input->post('strand') . '&ins=' . $this->input->post('ins'));
    // }


    // public function inputGrade()
    // {
    //     $yearLevel = $this->input->post('YearLevel');
    //     $setting = $this->db->get_where('srms_settings_o', ['settingsID' => 1])->row();
    //     $isPreschool = in_array($yearLevel, ['Kinder', 'Kinder 1', 'Kinder 2', 'Preschool']) && $setting->preschoolGrade == 'Letter';

    //     $student_no = $this->input->post('StudentNumber') ?? [];
    //     $adviser = $this->input->post('adviser') ?? [];
    //     $strand = $this->input->post('strand') ?? [];

    //     $pgrades = $this->input->post('PGrade') ?? [];
    //     $mgrades = $this->input->post('MGrade') ?? [];
    //     $p_final_grades = $this->input->post('PFinalGrade') ?? [];
    //     $f_grades = $this->input->post('FGrade') ?? [];

    //     $l_p = $this->input->post('l_p') ?? [];
    //     $l_m = $this->input->post('l_m') ?? [];
    //     $l_pf = $this->input->post('l_pf') ?? [];
    //     $l_f = $this->input->post('l_f') ?? [];

    //     $data = [];
    //     for ($i = 0; $i < count($student_no); $i++) {
    //         $record = [
    //             'StudentNumber' => $student_no[$i],
    //             'adviser' => $adviser[$i] ?? '',
    //             'description' => $this->input->post('description'),
    //             'section' => $this->input->post('section'),
    //             'SY' => $this->input->post('SY'),
    //             'Instructor' => $this->input->post('Instructor'),
    //             'SubjectCode' => $this->input->post('SubjectCode'),
    //             'strand' => $strand[$i] ?? '',
    //             'YearLevel' => $yearLevel,
    //         ];

    //         if ($isPreschool) {
    //             $record['l_p'] = $l_p[$i] ?? '';
    //             $record['l_m'] = $l_m[$i] ?? '';
    //             $record['l_pf'] = $l_pf[$i] ?? '';
    //             $record['l_f'] = $l_f[$i] ?? '';
    //             $record['PGrade'] = 0;
    //             $record['MGrade'] = 0;
    //             $record['PFinalGrade'] = 0;
    //             $record['FGrade'] = 0;
    //             $record['Average'] = 0;
    //         } else {
    //             $record['PGrade'] = floatval($pgrades[$i] ?? 0);
    //             $record['MGrade'] = floatval($mgrades[$i] ?? 0);
    //             $record['PFinalGrade'] = floatval($p_final_grades[$i] ?? 0);
    //             $record['FGrade'] = floatval($f_grades[$i] ?? 0);
    //             $record['Average'] = number_format(($record['PGrade'] + $record['MGrade'] + $record['PFinalGrade'] + $record['FGrade']) / 4, 2);
    //         }

    //         $data[] = $record;
    //     }

    //     if ($this->Ren_model->insert_grades($data)) {
    //         $this->session->set_flashdata('success', 'Grades added successfully!');
    //     } else {
    //         $this->session->set_flashdata('error', 'Failed to add grades.');
    //     }

    //     redirect(base_url() . 'Instructor/subjectGrades?subjectcode=' . $this->input->post('SubjectCode') . '&description=' . $this->input->post('description') . '&section=' . $this->input->post('section') . '&strand=' . $this->input->post('strands') . '&ins=' . $this->input->post('ins'));
    // }


    // public function updateGrade()
    // {
    //     $yearLevel = $this->input->post('YearLevel');
    //     $setting = $this->db->get_where('srms_settings_o', ['settingsID' => 1])->row();
    //     $isPreschool = in_array($yearLevel, ['Kinder', 'Kinder 1', 'Kinder 2', 'Preschool']) && $setting->preschoolGrade == 'Letter';

    //     $student_no = $this->input->post('StudentNumber') ?? [];
    //     $adviser = $this->input->post('adviser') ?? [];
    //     $gradeID = $this->input->post('gradeID') ?? [];

    //     $pgrades = $this->input->post('PGrade') ?? [];
    //     $mgrades = $this->input->post('MGrade') ?? [];
    //     $p_final_grades = $this->input->post('PFinalGrade') ?? [];
    //     $f_grades = $this->input->post('FGrade') ?? [];

    //     $l_p = $this->input->post('l_p') ?? [];
    //     $l_m = $this->input->post('l_m') ?? [];
    //     $l_pf = $this->input->post('l_pf') ?? [];
    //     $l_f = $this->input->post('l_f') ?? [];

    //     for ($i = 0; $i < count($student_no); $i++) {
    //         $record = [
    //             'StudentNumber' => $student_no[$i],
    //             'adviser' => $adviser[$i] ?? '',
    //             'description' => $this->input->post('description'),
    //             'section' => $this->input->post('section'),
    //             'SY' => $this->input->post('SY'),
    //             'Instructor' => $this->input->post('Instructor'),
    //             'SubjectCode' => $this->input->post('SubjectCode'),
    //         ];

    //         if ($isPreschool) {
    //             $record['l_p'] = $l_p[$i] ?? '';
    //             $record['l_m'] = $l_m[$i] ?? '';
    //             $record['l_pf'] = $l_pf[$i] ?? '';
    //             $record['l_f'] = $l_f[$i] ?? '';
    //             $record['PGrade'] = 0;
    //             $record['MGrade'] = 0;
    //             $record['PFinalGrade'] = 0;
    //             $record['FGrade'] = 0;
    //             $record['Average'] = 0;
    //         } else {
    //             $record['PGrade'] = floatval($pgrades[$i] ?? 0);
    //             $record['MGrade'] = floatval($mgrades[$i] ?? 0);
    //             $record['PFinalGrade'] = floatval($p_final_grades[$i] ?? 0);
    //             $record['FGrade'] = floatval($f_grades[$i] ?? 0);
    //             $record['Average'] = number_format(($record['PGrade'] + $record['MGrade'] + $record['PFinalGrade'] + $record['FGrade']) / 4, 2);
    //         }

    //         $this->db->where('gradeID', $gradeID[$i]);
    //         $this->db->update('grades', $record);
    //     }

    //     $this->session->set_flashdata('success', 'Grades updated successfully!');
    //     redirect(base_url() . 'Instructor/subjectGrades?subjectcode=' . $this->input->post('SubjectCode') . '&description=' . $this->input->post('description') . '&section=' . $this->input->post('section') . '&strand=' . $this->input->post('strand') . '&ins=' . $this->input->post('ins'));
    // }



  public function inputGrade()
{
    $yearLevel   = $this->input->post('YearLevel');
    $setting     = $this->db->get_where('srms_settings_o', ['settingsID' => 1])->row();

    // ✅ include Nursery, Prekinder
    $isPreschool = in_array($yearLevel, ['Kinder','Kinder 1','Kinder 2','Preschool','Nursery','Prekinder'], true)
                   && $setting && $setting->preschoolGrade === 'Letter';

    $student_no = $this->input->post('StudentNumber') ?? [];
    $adviser    = $this->input->post('adviser') ?? [];
    $strandVal  = $this->input->post('strand');
    $sem        = $this->input->post('Sem') ?: $this->session->userdata('semester');

    $pgrades    = $this->input->post('PGrade') ?? [];
    $mgrades    = $this->input->post('MGrade') ?? [];
    $p_finals   = $this->input->post('PFinalGrade') ?? [];
    $f_grades   = $this->input->post('FGrade') ?? [];

    $l_p  = $this->input->post('l_p')  ?? [];
    $l_m  = $this->input->post('l_m')  ?? [];
    $l_pf = $this->input->post('l_pf') ?? [];
    $l_f  = $this->input->post('l_f')  ?? [];

    $subComponent = (string) ($this->input->post('subComponent') ?? '');

    // helper to normalize letters
    $norm = function($v) {
        $t = strtoupper(trim((string)$v));
        return $t; // keep as-is; your policy may be A/B/C/D/E etc.
    };

    // simple most-frequent letter (mode) when all 4 present; else ''
    $letter_average = function($a,$b,$c,$d) {
        $vals = array_filter([$a,$b,$c,$d], fn($x)=>$x!=='' && $x!==null);
        if (count($vals) < 4) return '';
        $freq = array_count_values($vals);
        arsort($freq);
        $top = array_keys($freq);
        // tie-break: return '' to avoid disputes; adjust if you want other policy
        $firstCount = reset($freq);
        $ties = array_filter($freq, fn($n)=>$n===$firstCount);
        return (count($ties)===1) ? $top[0] : '';
    };

    $data = [];
    for ($i = 0; $i < count($student_no); $i++) {
        // normalize letters first
        $L1 = $norm($l_p[$i]  ?? '');
        $L2 = $norm($l_m[$i]  ?? '');
        $L3 = $norm($l_pf[$i] ?? '');
        $L4 = $norm($l_f[$i]  ?? '');
        $LA = $letter_average($L1,$L2,$L3,$L4);

        $record = [
            'StudentNumber' => $student_no[$i],
            'adviser'       => $adviser[$i] ?? '',
            'Description'   => $this->input->post('description'),
            'Section'       => $this->input->post('section'),
            'SY'            => $this->input->post('SY'),
            'Instructor'    => $this->input->post('Instructor'),
            'SubjectCode'   => $this->input->post('SubjectCode'),
            'strand'        => $strandVal ?: '',
            'YearLevel'     => $yearLevel ?: '',
            'subComponent'  => $subComponent,

            // ✅ ALWAYS include these 5 columns (avoid NOT NULL issues)
            'l_p'        => $isPreschool ? $L1 : '',
            'l_m'        => $isPreschool ? $L2 : '',
            'l_pf'       => $isPreschool ? $L3 : '',
            'l_f'        => $isPreschool ? $L4 : '',
            'l_average'  => $isPreschool ? $LA : '',
        ];

        if ($isPreschool) {
            // zero out numeric fields for letter grading
            $record['PGrade']      = 0;
            $record['MGrade']      = 0;
            $record['PFinalGrade'] = 0;
            $record['FGrade']      = 0;
            $record['Average']     = 0;
        } else {
            // numeric grading path
            $record['PGrade']      = (float) ($pgrades[$i]   ?? 0);
            $record['MGrade']      = (float) ($mgrades[$i]   ?? 0);
            $record['PFinalGrade'] = (float) ($p_finals[$i]  ?? 0);
            $record['FGrade']      = (float) ($f_grades[$i]  ?? 0);
            $record['Average']     = round(($record['PGrade'] + $record['MGrade'] + $record['PFinalGrade'] + $record['FGrade']) / 4, 2);
        }

        $data[] = $record;
    }

    $insertResult = !empty($data)
        ? $this->Ren_model->insert_grades($data)
        : ['inserted' => 0, 'duplicates' => [], 'error' => 'No grade rows to save.'];

    $duplicateNote = '';
    if (!empty($insertResult['duplicates'])) {
        $dupeIds = [];
        foreach ($insertResult['duplicates'] as $dupRow) {
            $candidate = trim((string)($dupRow['StudentNumber'] ?? ''));
            if ($candidate !== '') {
                $dupeIds[$candidate] = true;
            }
        }
        if (!empty($dupeIds)) {
            $duplicateNote = 'Skipped duplicate students: ' . implode(', ', array_keys($dupeIds)) . '.';
        } else {
            $duplicateNote = 'Some students already have saved grades and were skipped.';
        }
    }

    if (!empty($insertResult['error'])) {
        $this->session->set_flashdata('danger', 'Unable to save grades: ' . $insertResult['error']);
        if ($duplicateNote !== '') {
            $this->session->set_flashdata('warning', $duplicateNote);
        }
    } elseif ($insertResult['inserted'] > 0) {
        $savedMsg = ($insertResult['inserted'] === 1)
            ? '1 grade was saved successfully.'
            : $insertResult['inserted'] . ' grades were saved successfully.';
        $this->session->set_flashdata('success', $savedMsg);
        if ($duplicateNote !== '') {
            $this->session->set_flashdata('warning', $duplicateNote);
        }
    } else {
        $fallback = $duplicateNote !== '' ? $duplicateNote : 'No new grades were saved.';
        $this->session->set_flashdata('warning', $fallback);
    }

    $sc = urlencode((string)$this->input->post('SubjectCode'));
    $ds = urlencode((string)$this->input->post('description'));
    $sec= urlencode((string)$this->input->post('section'));
    $st = urlencode((string)$strandVal);
    $ins= urlencode((string)$this->input->post('Instructor'));

    redirect(base_url("Instructor/subjectGrades?subjectcode={$sc}&description={$ds}&section={$sec}&strand={$st}&ins={$ins}"));
}



public function updateGrade()
{
    $yearLevel   = $this->input->post('YearLevel');
    $setting     = $this->db->get_where('srms_settings_o', ['settingsID' => 1])->row();

    // ✅ include Nursery, Prekinder
    $isPreschool = in_array($yearLevel, ['Kinder','Kinder 1','Kinder 2','Preschool','Nursery','Prekinder'], true)
                   && $setting && $setting->preschoolGrade === 'Letter';

    $student_no = $this->input->post('StudentNumber') ?? [];
    $adviser    = $this->input->post('adviser') ?? [];
    $gradeID    = $this->input->post('gradeID') ?? [];
    $strandVal  = $this->input->post('strand');
    $sem        = $this->input->post('Sem') ?: $this->session->userdata('semester');
    $subComponent = (string) ($this->input->post('subComponent') ?? '');

    $pgrades    = $this->input->post('PGrade') ?? [];
    $mgrades    = $this->input->post('MGrade') ?? [];
    $p_finals   = $this->input->post('PFinalGrade') ?? [];
    $f_grades   = $this->input->post('FGrade') ?? [];

    $l_p  = $this->input->post('l_p') ?? [];
    $l_m  = $this->input->post('l_m') ?? [];
    $l_pf = $this->input->post('l_pf') ?? [];
    $l_f  = $this->input->post('l_f') ?? [];

    $norm = function($v){ return strtoupper(trim((string)$v)); };
    $letter_average = function($a,$b,$c,$d){
        $vals = array_filter([$a,$b,$c,$d], fn($x)=>$x!=='' && $x!==null);
        if (count($vals) < 4) return '';
        $freq = array_count_values($vals);
        arsort($freq);
        $top = array_keys($freq);
        $firstCount = reset($freq);
        $ties = array_filter($freq, fn($n)=>$n===$firstCount);
        return (count($ties)===1) ? $top[0] : '';
    };

    for ($i = 0; $i < count($student_no); $i++) {
        $L1 = $norm($l_p[$i]  ?? '');
        $L2 = $norm($l_m[$i]  ?? '');
        $L3 = $norm($l_pf[$i] ?? '');
        $L4 = $norm($l_f[$i]  ?? '');
        $LA = $letter_average($L1,$L2,$L3,$L4);

        $record = [
            'StudentNumber' => $student_no[$i],
            'adviser'       => $adviser[$i] ?? '',
            'Description'   => $this->input->post('description'),
            'Section'       => $this->input->post('section'),
            'SY'            => $this->input->post('SY'),
            'Instructor'    => $this->input->post('Instructor'),
            'SubjectCode'   => $this->input->post('SubjectCode'),
            'strand'        => $strandVal ?: '',
            'YearLevel'     => $yearLevel ?: '',
            'subComponent'  => $subComponent,

            // ✅ ALWAYS include l_* fields
            'l_p'        => $isPreschool ? $L1 : '',
            'l_m'        => $isPreschool ? $L2 : '',
            'l_pf'       => $isPreschool ? $L3 : '',
            'l_f'        => $isPreschool ? $L4 : '',
            'l_average'  => $isPreschool ? $LA : '',
        ];

        if ($isPreschool) {
            $record['PGrade']=0; $record['MGrade']=0; $record['PFinalGrade']=0; $record['FGrade']=0; $record['Average']=0;
        } else {
            $record['PGrade']      = (float) ($pgrades[$i]   ?? 0);
            $record['MGrade']      = (float) ($mgrades[$i]   ?? 0);
            $record['PFinalGrade'] = (float) ($p_finals[$i]  ?? 0);
            $record['FGrade']      = (float) ($f_grades[$i]  ?? 0);
            $record['Average']     = round(($record['PGrade'] + $record['MGrade'] + $record['PFinalGrade'] + $record['FGrade']) / 4, 2);
        }

        $this->db->where('gradeID', $gradeID[$i]);
        $this->db->update('grades', $record);
    }

    $this->session->set_flashdata('success', 'Grades updated successfully!');

    $sc = urlencode((string)$this->input->post('SubjectCode'));
    $ds = urlencode((string)$this->input->post('description'));
    $sec= urlencode((string)$this->input->post('section'));
    $st = urlencode((string)$strandVal);
    $ins= urlencode((string)$this->input->post('Instructor'));

    redirect(base_url("Instructor/subjectGrades?subjectcode={$sc}&description={$ds}&section={$sec}&strand={$st}&ins={$ins}"));
}





    function good_moral()
    {
        $page = "cgmc";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Certificate Of Good Moral Character";
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->input->post('stud'), 'SY', $this->session->sy);
        $data['student'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->input->post('stud'));
        $data['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
        $data['studs'] = $this->Common->two_join_one_cond_not_gb('semesterstude', 'studeprofile', 'a.StudentNumber,b.StudentNumber,FirstName,MiddleName,LastName,SY', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');

        $this->load->view($page, $data);
    }



    function clearance()
    {
        $page = "cc";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "CERTIFICATE OF Good Moral Character";
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $data['student'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $data['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
        $data['studs'] = $this->Common->two_join_one_cond_not_gb('semesterstude', 'studeprofile', 'a.StudentNumber,b.StudentNumber,FirstName,MiddleName,LastName,SY', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');

        $this->load->view($page, $data);
    }

    function clear()
    {
        $page = "c";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "CERTIFICATE OF Good Moral Character";
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $data['student'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $data['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
        $data['studs'] = $this->Common->two_join_one_cond_not_gb('semesterstude', 'studeprofile', 'a.StudentNumber,b.StudentNumber,FirstName,MiddleName,LastName,SY', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');
        $data['subject'] = $this->Common->two_cond('registration', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);


        $this->load->view($page, $data);
    }

    function stud_prof()
    {
        $page = "stud_prof";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "CERTIFICATE OF Good Moral Character";
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $data['student'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $data['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
        $data['studs'] = $this->Common->two_join_one_cond_not_gb('semesterstude', 'studeprofile', 'a.StudentNumber,b.StudentNumber,FirstName,MiddleName,LastName,SY', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');
        $data['subject'] = $this->Common->two_cond('registration', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $data['req'] = $this->Common->one_cond_row('stude_requirements', 'StudentNumber', $this->uri->segment(3));


        $this->load->view($page, $data);
    }

    function stud_register_enrollment()
    {
        $page = "stud_register_enrollment";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "CERTIFICATE OF Good Moral Character";
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $data['student'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $data['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
        $data['studs'] = $this->Common->two_join_one_cond_not_gb('semesterstude', 'studeprofile', 'a.StudentNumber,b.StudentNumber,FirstName,MiddleName,LastName,SY', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');
        $data['subject'] = $this->Common->two_cond('registration', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);


        $this->load->view($page, $data);
    }

    function sf10_jhs()
    {
        $page = "cgmc";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "SF10";
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->input->post('stud'), 'SY', $this->session->sy);
        $data['student'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->input->post('stud'));
        $data['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
        $data['studs'] = $this->Common->two_join_one_cond_not_gb('semesterstude', 'studeprofile', 'a.StudentNumber,b.StudentNumber,FirstName,MiddleName,LastName,SY', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');

        $this->load->view($page, $data);
    }


    public function updateGraderen()
    {
        $this->form_validation->set_rules('PGrade[]', '1st Grading', 'required|numeric');
        $this->form_validation->set_rules('MGrade[]', '2nd Grading', 'required|numeric');
        $this->form_validation->set_rules('PFinalGrade[]', '3rd Grading', 'numeric');
        $this->form_validation->set_rules('FGrade[]', '4th Grading', 'numeric');

        if ($this->form_validation->run() === FALSE) {
            $data['grades'] = $this->getGrades();
            $this->load->view('mg', $data);
        } else {
            $studentNumbers = $this->input->post('StudentNumber');
            $PGrades = $this->input->post('PGrade');
            $MGrades = $this->input->post('MGrade');
            $PFinalGrades = $this->input->post('PFinalGrade');
            $FGrades = $this->input->post('FGrade');
            $gradeIDs = $this->input->post('gradeID');

            foreach ($studentNumbers as $index => $studentNumber) {
                $data = array(
                    'PGrade' => $PGrades[$index],
                    'MGrade' => $MGrades[$index],
                    'PFinalGrade' => $PFinalGrades[$index],
                    'FGrade' => $FGrades[$index]
                );

                $this->Common->updateGrade($data, $gradeIDs[$index]);
            }

            $this->session->set_flashdata('message', 'Grades updated successfully!');
            redirect('Page/modify_grades');
        }
    }

    public function getGrades()
    {
        return $this->Common->getGrades();
    }


    public function update_batch()
    {

        $ids = $this->input->post('ids');
        $PGrade = $this->input->post('PGrade');
        $MGrade = $this->input->post('MGrade');
        $PFinalGrade = $this->input->post('PFinalGrade');
        $FGrade = $this->input->post('FGrade');

        $data = [];
        foreach ($ids as $id) {
            $data[] = [
                'gradeID' => $id,
                'PGrade' => $PGrade[$id],
                'MGrade' => $MGrade[$id],
                'PFinalGrade' => $PFinalGrade[$id],
                'FGrade' => $FGrade[$id]
            ];
        }
        if ($this->Ren_model->update_batchren($data)) {
            redirect('Page/ren');
        } else {
            echo "Error updating records.";
        }
    }


    public function update_batch_studgrade()
    {
        $ids = $this->input->post('gradeID');
        $PGrade = $this->input->post('PGrade');
        $MGrade = $this->input->post('MGrade');
        $PFinalGrade = $this->input->post('PFinalGrade');
        $FGrade = $this->input->post('FGrade');

        $data = [];
        foreach ($ids as $id) {
            $data[] = [
                'gradeID' => $id,
                'PGrade' => $PGrade[$id],
                'MGrade' => $MGrade[$id],
                'PFinalGrade' => $PFinalGrade[$id],
                'FGrade' => $FGrade[$id]
            ];
        }

        $this->db->update_batch('grades', $data, 'gradeID');

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Successfully Updated.');
            redirect('Page/modify_gradesv2/' . $this->input->post('id'));
        } else {
            $this->session->set_flashdata('danger', 'Error updating records or no changes were made.');
            redirect('Page/modify_gradesv2/' . $this->input->post('id'));
        }
    }

    public function delete_subject_enlist()
    {
        $this->Common->delete('registration', 'regnumber', 5);
        $this->session->set_flashdata('danger', ' User account was deleted.');
        redirect("Ren/subject_list_update/" . $this->uri->segment(3) . '/' . $this->uri->segment(4));
    }

    public function enlist_sub_insert()
    {
        $sub = $this->Common->one_cond_row('semsubjects', 'subjectid', $this->input->post('sub'));

        $insert_data = array(
            'SubjectCode' => $sub->SubjectCode,
            'Description' => $sub->Description,
            'Section' => $sub->Section,
            //'Instructor' => $sub->subject_name,   
            'Sem' => $sub->Semester,
            'SY' => $sub->SY,
            'StudentNumber' => $this->input->post('stud_id'),
            'YearLevel' => $sub->YearLevel,
            'settingsID ' => 1,
        );

        $this->Ren_model->insert_enlist_sub($insert_data);
        $this->session->set_flashdata('success', 'Successfully Added.');
        redirect("Ren/subject_list_update/" . $this->input->post('stud_id') . '/' . $this->input->post('sy'));
    }

    function stud_reports()
    {
        $result['data'] = $this->Ren_model->getProfile();
        $this->load->view('student_report', $result);
    }


    function goodmoral()
    {
        $page = "cgmcv2";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Certificate Of Good Moral Character";
        $data['sem_stud'] = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->uri->segment(3), 'SY', $this->session->sy);
        $data['student'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
        $data['setting'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
        $data['studs'] = $this->Common->two_join_one_cond_not_gb('semesterstude', 'studeprofile', 'a.StudentNumber,b.StudentNumber,FirstName,MiddleName,LastName,SY', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');

        $this->load->view($page, $data);
    }
}
