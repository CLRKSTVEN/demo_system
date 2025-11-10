<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportGrades extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url','form']);
        $this->load->library('session');
        // Optional guard:
        // if ($this->session->userdata('position') !== 'Registrar') { show_error('Forbidden', 403); }
    }

    /* ====================== INDEX (picker + V1/V2 buttons) ====================== */
    public function index()
    {
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        $data['students'] = $this->list_students();   // basic (you can switch to AJAX)
        $data['selected'] = false;
        $data['stud']     = [];
        $data['sy']       = (string)$this->session->userdata('sy');
        $data['student_selected'] = '';

        if ($this->input->method() === 'post') {
            $student = trim((string)$this->input->post('student', true));
            if ($student !== '') {
                [$stud] = $this->build_payload($student, $this->session->userdata('sy'), false); // header preview only
                $data['selected']         = true;
                $data['stud']             = $stud;
                $data['student_selected'] = $student;
            }
        }
        $this->load->view('report_grades_index', $data);
    }

    /* AJAX Select2 (optional) */
    public function search_students()
    {
        $this->output->set_content_type('application/json');
        $q = trim((string)$this->input->get('q', true));
        $this->db->select('StudentNumber, LastName, FirstName, MiddleName, Course');
        $this->db->from('studeprofile');
        if ($q !== '') {
            $this->db->group_start()
                ->like('StudentNumber', $q)
                ->or_like('LastName', $q)
                ->or_like('FirstName', $q)
                ->group_end();
        }
        $this->db->order_by('LastName','ASC')->limit(30);
        $rows = $this->db->get()->result_array();

        $results = [];
        foreach ($rows as $r) {
            $name = trim(($r['LastName']??'').', '.($r['FirstName']??'').(empty($r['MiddleName'])?'':' '.strtoupper($r['MiddleName'][0]).'.'));
            $results[] = [
                'id'   => $r['StudentNumber'],
                'text' => ($r['StudentNumber'] ?? '').' — '.$name.' — '.($r['Course'] ?? '')
            ];
        }
        echo json_encode(['results' => $results]);
    }

    /* ====================== PRINT VIEWS ====================== */

    /**
     * V1: Certificate style — REGISTRATION rows + overlay Average (if any)
     * URL: /ReportGrades/v1?student=20250036
     * Uses SY from session strictly.
     */
    public function v1()
    {
        $student = trim((string)$this->input->get('student', true));
        if ($student === '') { show_error('Missing student', 400); }

        $syStrict = (string)$this->session->userdata('sy');
        if ($syStrict === '') { show_error('Session SY not set', 400); }

        // Build: include grades overlay (we will display only Average in the view)
        [$stud, $rows, $syResolved, $settings, $gpa] = $this->build_payload($student, $syStrict, true);

        $data = compact('stud','rows','syResolved','settings','gpa');
        $data['sy'] = $syResolved;
        $this->load->view('report_grades_v1_print', $data);
    }

    /**
     * V2: Tabular — REGISTRATION rows + overlay all period grades
     * URL: /ReportGrades/v2?student=20250036
     * Uses SY from session strictly.
     */
    public function v2()
    {
        $student = trim((string)$this->input->get('student', true));
        if ($student === '') { show_error('Missing student', 400); }

        $syStrict = (string)$this->session->userdata('sy');
        if ($syStrict === '') { show_error('Session SY not set', 400); }

        // Build: include grades overlay (view will show PGrade..Average)
        [$stud, $rows, $syResolved, $settings] = $this->build_payload($student, $syStrict, true);

        $data = compact('stud','rows','syResolved','settings');
        $data['sy'] = $syResolved;
        $this->load->view('report_grades_v2_print', $data);
    }

    /**
     * Build payload (BED):
     * - Header: studeprofile (+ latest semesterstude for target SY if any)
     * - REGISTRATION rows for StudentNumber + target SY (always display these!)
     * - Optional overlay from GRADES by (StudentNumber + SY + SubjectCode)
     * - Settings
     *
     * Returns:
     *   [$stud, $rows, $syResolved, $settings, $gpa?]
     */
  private function build_payload($student, $sy, $withGrades = true)
{
    // -------- Normalizers --------
    $studentNorm = $this->normalize_id($student);
    $syNorm      = $this->normalize_sy($sy);

    // 1) Student header
    $stud = $this->db->select('StudentNumber, FirstName, MiddleName, LastName, Course')
        ->from('studeprofile')
        ->where("REPLACE(UPPER(TRIM(StudentNumber)),' ','') =", $studentNorm)
        ->get()->row_array() ?: [];

    // 2) Enrich Course/Year/Major from semesterstude (prefer same SY if exists)
    $semRows = $this->db->select('Course, YearLevel, Major, SY, semstudentid')
        ->from('semesterstude')
        ->where("REPLACE(UPPER(TRIM(StudentNumber)),' ','') =", $studentNorm)
        ->order_by('SY','DESC')->order_by('semstudentid','DESC')
        ->get()->result_array();

    $bestSem = null;
    foreach ($semRows as $r) {
        if ($this->normalize_sy($r['SY'] ?? '') === $syNorm) { $bestSem = $r; break; }
    }
    if ($bestSem) {
        if (!empty($bestSem['Course']))    $stud['Course']    = $bestSem['Course'];
        if (!empty($bestSem['YearLevel'])) $stud['YearLevel'] = $bestSem['YearLevel'];
        if (!empty($bestSem['Major']))     $stud['Major']     = $bestSem['Major'];
    } else {
        $stud['YearLevel'] = $stud['YearLevel'] ?? '';
        $stud['Major']     = $stud['Major'] ?? '';
    }

    // 3) Try to pull REGISTRATION rows (preferred source of subjects)
    $this->db->reset_query();
    $regRows = $this->db->select('regnumber, SubjectCode, Description, Section, Course AS RegCourse, YearLevel AS RegYearLevel, SY')
        ->from('registration')
        ->where("REPLACE(UPPER(TRIM(StudentNumber)),' ','') =", $studentNorm)
        ->where($this->sql_norm_sy('SY')." =", $syNorm, false)
        ->order_by('regnumber','DESC')->order_by('Description','ASC')
        ->get()->result_array();

    // Fill Course/Year if profile blank
    if ($regRows) {
        if (empty($stud['Course']))    $stud['Course']    = $regRows[0]['RegCourse']    ?? ($stud['Course'] ?? '');
        if (empty($stud['YearLevel'])) $stud['YearLevel'] = $regRows[0]['RegYearLevel'] ?? ($stud['YearLevel'] ?? '');
    }

    // Build base rows (registration-first)
    $rows = [];
    foreach ($regRows as $r) {
        $rows[] = [
            'SubjectCode' => (string)($r['SubjectCode'] ?? ''),
            'Description' => (string)($r['Description'] ?? ''),
            'Section'     => (string)($r['Section'] ?? ''),
            'SY'          => $sy,
            'PGrade'      => null,
            'MGrade'      => null,
            'PFinalGrade' => null,
            'FGrade'      => null,
            'Average'     => null,
        ];
    }

    // 3b) FALLBACK: if no registration rows, derive subjects from GRADES and (optionally) subject master
    if (!$rows) {
        // Pull latest grade row per normalized SubjectCode
        $this->db->reset_query();
        $gradeRowsBase = $this->db->select('gradeID, SubjectCode, SY, PGrade, MGrade, PFinalGrade, FGrade, Average')
            ->from('grades')
            ->where("REPLACE(UPPER(TRIM(StudentNumber)),' ','') =", $studentNorm)
            ->where($this->sql_norm_sy('SY')." =", $syNorm, false)
            ->order_by('gradeID','DESC')
            ->get()->result_array();

        $latestByCode = [];
        foreach ($gradeRowsBase as $g) {
            $k = $this->normalize_code($g['SubjectCode'] ?? '');
            if ($k === '') continue;
            if (!isset($latestByCode[$k])) $latestByCode[$k] = $g; // keep newest
        }

        if ($latestByCode) {
            // Try to map descriptions from master subjects (if table exists)
            $descMap = [];
            if ($this->db->table_exists('subjects')) {
                $subs = $this->db->select('subjectCode, description')->from('subjects')->get()->result_array();
                foreach ($subs as $srow) {
                    $descMap[$this->normalize_code($srow['subjectCode'] ?? '')] = (string)($srow['description'] ?? '');
                }
            }
            foreach ($latestByCode as $k => $g) {
                $origCode = (string)($g['SubjectCode'] ?? '');
                $desc     = $descMap[$k] ?? ''; // leave blank if unknown
                $rows[] = [
                    'SubjectCode' => $origCode,
                    'Description' => $desc,
                    'Section'     => '',
                    'SY'          => $sy,
                    'PGrade'      => null,
                    'MGrade'      => null,
                    'PFinalGrade' => null,
                    'FGrade'      => null,
                    'Average'     => null,
                ];
            }
        }
    }

    // 4) Overlay grades on whatever rows we have (registration-first or grade-derived)
    if ($withGrades && $rows) {
        $codesNorm = [];
        foreach ($rows as $x) {
            $nk = $this->normalize_code($x['SubjectCode']);
            if ($nk !== '') $codesNorm[$nk] = true;
        }

        $this->db->reset_query();
        $gradeRows = $this->db->select('gradeID, SubjectCode, SY, PGrade, MGrade, PFinalGrade, FGrade, Average')
            ->from('grades')
            ->where("REPLACE(UPPER(TRIM(StudentNumber)),' ','') =", $studentNorm)
            ->where($this->sql_norm_sy('SY')." =", $syNorm, false)
            ->order_by('gradeID','DESC')
            ->get()->result_array();

        $gmap = [];
        foreach ($gradeRows as $g) {
            $key = $this->normalize_code($g['SubjectCode'] ?? '');
            if ($key === '') continue;
            if (!isset($gmap[$key])) $gmap[$key] = $g; // latest only
        }

        foreach ($rows as &$row) {
            $k = $this->normalize_code($row['SubjectCode']);
            if (isset($gmap[$k])) {
                $g = $gmap[$k];
                $row['PGrade']      = $this->norm_grade($g['PGrade']      ?? null);
                $row['MGrade']      = $this->norm_grade($g['MGrade']      ?? null);
                $row['PFinalGrade'] = $this->norm_grade($g['PFinalGrade'] ?? null);
                $row['FGrade']      = $this->norm_grade($g['FGrade']      ?? null);
                $row['Average']     = $this->norm_grade($g['Average']     ?? null);
            }
        }
        unset($row);
    }

    // 5) Settings
    $settings = $this->db->from('srms_settings_o')->order_by('settingsID','ASC')->get()->row_array() ?: [];

    // 6) GPA (V1)
    $sum = 0; $cnt = 0;
    foreach ($rows as $r) {
        if (is_numeric($r['Average'])) { $sum += (float)$r['Average']; $cnt++; }
    }
    $gpa = $cnt ? ($sum / $cnt) : null;

    return [$stud, $rows, (string)$sy, $settings, $gpa];
}



    /* ====================== UTILITIES ====================== */

    private function list_students()
    {
        $rows = $this->db->select('StudentNumber, FirstName, MiddleName, LastName, Course')
            ->from('studeprofile')
            ->order_by('LastName','ASC')->order_by('FirstName','ASC')
            ->limit(200)
            ->get()->result_array();

        $sy = (string)$this->session->userdata('sy');
        $yearMap = [];
        if ($sy !== '') {
            $syNorm = $this->normalize_sy($sy);
            $yrRows = $this->db->select('StudentNumber, YearLevel, semstudentid, SY')
                ->from('semesterstude')
                ->where("REPLACE(UPPER(TRIM(SY)),' ','') =", $syNorm)
                ->order_by('StudentNumber','ASC')
                ->order_by('semstudentid','DESC')
                ->get()->result_array();
            foreach ($yrRows as $r) {
                if (!isset($yearMap[$r['StudentNumber']])) {
                    $yearMap[$r['StudentNumber']] = $r['YearLevel'];
                }
            }
        }
        foreach ($rows as &$r) { $r['YearLevel'] = $yearMap[$r['StudentNumber']] ?? ''; }
        unset($r);
        return $rows;
    }

  private function normalize_id($s){
    $s = (string)$s;
    $s = str_replace(["\xC2\xA0"], ' ', $s); // NBSP -> space
    $s = preg_replace('/\s+/', '', $s);      // remove all spaces
    return strtoupper(trim($s));
}
private function normalize_sy($s){
    $s = (string)$s;
    $s = str_replace(["\xC2\xA0"], ' ', $s);
    $s = str_replace(["-", "–", "—"], '', $s);
    $s = preg_replace('/\s+/', '', $s);
    return strtoupper(trim($s));
}
private function normalize_code($s){
    $s = (string)$s;
    $s = str_replace(["\xC2\xA0"], ' ', $s);
    $s = str_replace(["-", "–", "—"], '', $s);
    $s = preg_replace('/\s+/', '', $s);
    return strtoupper(trim($s));
}
private function sql_norm_sy($col = 'SY'){
    return "UPPER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM($col),' ',''),'-',''),'–',''),'—',''),CHAR(160),''))";
}
private function norm_grade($v){
    if ($v === null || $v === '' || !is_numeric($v)) return null;
    $v = (float)$v;
    return $v >= 0 ? $v : null;
}


}
