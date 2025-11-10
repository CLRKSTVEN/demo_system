<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shs_report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
    }
    public function logo($field = 'schoolLogo')
    {
        $whitelist = array('schoolLogo', 'letterHead', 'depedLogo');
        if (!in_array($field, $whitelist, true)) show_404();

        $row = $this->db->get_where('srms_settings', array('settingsID' => 1))->row();
        if (!$row || empty($row->$field)) show_404();

        $blob = $row->$field;
        $mime = 'image/png';
        if (function_exists('finfo_open')) {
            $fi = finfo_open(FILEINFO_MIME_TYPE);
            if ($fi) {
                $det = finfo_buffer($fi, $blob);
                if ($det) $mime = $det;
                finfo_close($fi);
            }
        }
        $this->output->set_content_type($mime)
            ->set_header('Cache-Control: public, max-age=86400')
            ->set_output($blob);
    }
    private function _branding_urls()
    {
        $row = $this->db->get_where('srms_settings', ['settingsID' => 1])->row();

        $ctl = strtolower(__CLASS__);
        $logo_url  = site_url("$ctl/logo/schoolLogo");
        $deped_url = site_url("$ctl/logo/depedLogo");

        $letterhead_url = '';
        if ($row) {
            $fname = trim((string)($row->letterhead_web ?? ''));
            if ($fname !== '') {
                $abs = FCPATH . 'upload/banners/' . $fname;
                if (is_file($abs)) {
                    $letterhead_url = base_url('upload/banners/' . rawurlencode($fname));
                }
            }
            if ($letterhead_url === '' && !empty($row->letterHead)) {
                $letterhead_url = site_url("$ctl/logo/letterHead");
            }
        }
        return [
            'school_logo_url' => $logo_url,
            'deped_logo_url'  => $deped_url,
            'letterhead_url'  => $letterhead_url,
        ];
    }

private function _template_from_subjects(string $yearLevel, ?string $strand): array
{
    // Map "1/First/first semester" → "First Semester", etc.
    $mapSem = function($s){
        $s = strtolower(trim((string)$s));
        if ($s === '1' || strpos($s,'first') !== false)  return 'First Semester';
        if ($s === '2' || strpos($s,'second') !== false) return 'Second Semester';
        if ($s === 'first semester')  return 'First Semester';
        if ($s === 'second semester') return 'Second Semester';
        return ''; // ignore invalid/empty
    };
    // Normalize category into the 3 buckets used in the view
    $mapCat = function($s){
        $s = strtolower(trim((string)$s));
        if ($s==='applied' || $s==='applied subjects' || $s==='applied subject/s')
            return 'Applied Subject/s';
        if (strpos($s,'special') === 0)
            return 'Specialized Subject';
        return 'Core Subjects';
    };

    $tpl = [
        'First Semester'  => ['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]],
        'Second Semester' => ['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]],
    ];

    // Pull subjects you manage in Settings → Subjects
    $this->db->reset_query();
    $this->db->from('subjects');
    $this->db->where('yearLevel', $yearLevel);

    // Keep exact-strand matches or records with blank strand
    if ($strand !== null && $strand !== '') {
        $this->db->group_start()
                 ->where('strand', $strand)
                 ->or_where('strand', '')
                 ->or_where('strand IS NULL', null, false)
                 ->group_end();
    }

    // Order: sem → category → your optional display order → description
    $this->db->order_by('sem', 'ASC');
    $this->db->order_by('subCategory', 'ASC');
    // If you have a displayOrder column, uncomment the next line:
    // $this->db->order_by('displayOrder', 'ASC');
    $this->db->order_by('description', 'ASC');

    $rows = $this->db->get()->result();

    foreach ($rows as $r) {
        $sem = $mapSem($r->sem ?? '');
        if ($sem === '') continue;

        $cat  = $mapCat($r->subCategory ?? '');
        $desc = (string)($r->description ?? '');
        $code = (string)($r->subjectCode ?? '');

        $tpl[$sem][$cat][] = (object)[
            'desc' => $desc,
            'code' => $code,
        ];
    }
    return $tpl;
}



    public function rlpd($studentNumber = null)
    {
        if (!$studentNumber) show_404();

        $sy = $this->input->get('sy', true) ?: (string)$this->session->userdata('sy');
        $stud     = $this->db->get_where('studeprofile', array('StudentNumber' => $studentNumber))->row();
        $sem_stud = $this->db->get_where('semesterstude', array('StudentNumber' => $studentNumber, 'SY' => $sy))->row();
        $cur_stud = $sem_stud;
        $prin     = $this->db->get_where('srms_settings_o', array('settingsID' => 1))->row();
$schoolName    = !empty($prin->SchoolName)    ? (string)$prin->SchoolName    : 'CRISPIN E. ROJAS NATIONAL HIGH SCHOOL';
$schoolAddress = !empty($prin->SchoolAddress) ? (string)$prin->SchoolAddress : 'LAMBAJON, BAGANGA, DAVAO ORIENTAL';
$schoolEmail   = !empty($prin->SchoolEmail)   ? (string)$prin->SchoolEmail   : 'crispinerojasnhs.baganganorth@deped.gov.ph';
$principalName = !empty($prin->SchoolHead)    ? (string)$prin->SchoolHead    : 'School Principal IV';

        $courseName = '';
        if ($sem_stud && !empty($sem_stud->Course))      $courseName = $sem_stud->Course;
        elseif ($stud && !empty($stud->Course))          $courseName = $stud->Course;

        $track = !empty($sem_stud->Track) ? (string)$sem_stud->Track : '';
        $this->db->reset_query();
        $this->db->select("
            g.SubjectCode, g.Description,
            g.PGrade, g.MGrade, g.Average,
            g.Sem AS semester,
            g.subComponent
        ");
        $this->db->from('grades g');
        $this->db->where('g.StudentNumber', $studentNumber);
        $this->db->where('g.SY', $sy);
        $this->db->where_in('g.Sem', array(
            'First Semester','Second Semester','1st Sem','2nd Sem','1st Semester','2nd Semester'
        ));
        $this->db->order_by("FIELD(g.Sem,
            'First Semester','1st Sem','1st Semester',
            'Second Semester','2nd Sem','2nd Semester'
        )", "", false);
        $this->db->order_by('g.Description', 'ASC');
        $rows = $this->db->get()->result();

        if (empty($rows)) {
            $this->db->reset_query();
            $this->db->select("
                SubjectCode, Description,
                PGrade, MGrade, Average,
                Sem AS semester,
                subComponent
            ");
            $this->db->from('grades');
            $this->db->where('StudentNumber', $studentNumber);
            $this->db->where('SY', $sy);
            $this->db->order_by('Description', 'ASC');
            $rows = $this->db->get()->result();
        }
        $gradeIndex = array();
        foreach ($rows as $g) {
            $code = isset($g->SubjectCode) ? $g->SubjectCode : (isset($g->subjectCode) ? $g->subjectCode : null);
            if ($code) $gradeIndex[(string)$code] = $g;
        }
        $deported_codes = array();
        if ($sem_stud && !empty($sem_stud->YearLevel)) {
            if (!isset($this->SubjectDeportmentModel)) $this->load->model('SubjectDeportmentModel');
            if (method_exists($this->SubjectDeportmentModel, 'get_codes_by_yearlevel')) {
                $deported_codes = $this->SubjectDeportmentModel->get_codes_by_yearlevel($sem_stud->YearLevel);
            } else {
                $q = $this->db->select('subjectCode')->from('subject_deportment')
                              ->where('yearLevel', $sem_stud->YearLevel)->get()->result();
                $tmp = array();
                foreach ($q as $r) { $tmp[] = (string)$r->subjectCode; }
                $deported_codes = array_values(array_unique($tmp));
            }
        }
        $template_subjects = array();
        $form_blocked = false;

        $yl_raw  = (string)($sem_stud->YearLevel ?? '');
        $yl_norm = $this->normalize_year_level($yl_raw);
        $looks_shs = (stripos((string)$courseName, 'senior high') !== false) || in_array($yl_norm, array(11,12), true);

        $str = null;
        if (!empty($sem_stud->strand))             $str = (string)$sem_stud->strand;
        elseif (!empty($sem_stud->Qualification))  $str = (string)$sem_stud->Qualification;
        elseif (!empty($sem_stud->Track))          $str = (string)$sem_stud->Track;

    if ($looks_shs) {
    $this->load->model('Sf9CatalogModel');
    $template_subjects = $this->Sf9CatalogModel->template_for_student($courseName, $yl_raw, $str);
    if (!is_array($template_subjects) || empty($template_subjects)) {
        $template_subjects = $this->_template_from_subjects($yl_raw, $str);
    }
} else {
    $form_blocked = true;
}

// $view = 'shs_rlpd';

// $yl_norm = $this->normalize_year_level($yl_raw);

// $major_blob = strtolower(trim(
//     ($courseName ?: '') . ' ' .
//     ($str ?: '') . ' ' .
//     ($track ?: '')
// ));

// $is_humss = (strpos($major_blob, 'humss') !== false)
//          || (strpos($major_blob, 'humanities and social sciences') !== false);

// if ($yl_norm === 11 && $is_humss) {
//     $view = 'g11_humss_rlpd';
// }

// $is_css = (
//     strpos($major_blob, 'computer system servicing') !== false ||
//     strpos($major_blob, 'ict') !== false ||
//     strpos($major_blob, ' css ') !== false ||
//     substr($major_blob, -3) === 'css' ||
//     strpos($major_blob, '(css)') !== false
// );

// if ($yl_norm === 12 && $is_css) {
//     $view = 'g12_css_rlpd';
// }

// $is_tvl   = (stripos($track, 'technical') !== false) || (stripos($track, 'tvl') !== false);

// if ($is_tvl && strpos($strand_s, 'cookery') !== false) {
//     $view = 'cookery_rlpd';
// }
$view = 'shs_rlpd';
$yl_norm = $this->normalize_year_level($yl_raw);

$blob_raw = trim(($courseName ?: '') . ' ' . ($str ?: '') . ' ' . ($track ?: ''));
$blob_norm = strtolower(preg_replace('/[^a-z0-9]+/i', ' ', $blob_raw));
$blob_norm = ' ' . trim($blob_norm) . ' '; 

$strand_s = strtolower((string)($str ?? ''));

$is_humss = (
    preg_match('/\bhumss\b/i', $blob_norm) ||
    strpos($blob_norm, 'humanities and social sciences') !== false ||
    strpos($blob_norm, 'humanities  social sciences') !== false 
);
if ($yl_norm === 11 && $is_humss) {
    $view = 'g11_humss_rlpd';
}

$is_ict = (
    preg_match('/\bict\b/i', $blob_norm) ||
    strpos($blob_norm, 'information and communication') !== false ||
    strpos($blob_norm, 'information  communication') !== false
);

if ($yl_norm === 11 && $is_ict) {
    $view = 'g11_ict_rlpd';
}

$is_css = (
    strpos($blob_norm, 'computer system servicing') !== false ||
    preg_match('/\bcss\b/i', $blob_norm)
);

if ($yl_norm === 12 && $is_css) {
    $view = 'g12_css_rlpd';
}

if ($yl_norm === 12 && $is_ict && !$is_css) {
    $view = 'g12_ict_rlpd';
}

$is_tvl = (stripos($track, 'technical') !== false) || (stripos($track, 'tvl') !== false);
if ($is_tvl && strpos(strtolower($strand_s), 'cookery') !== false) {
    $view = 'cookery_rlpd';
}



        $yl_for_filter  = $sem_stud && !empty($sem_stud->YearLevel) ? (string)$sem_stud->YearLevel : (isset($stud->YearLevel) ? (string)$stud->YearLevel : '');
        $sec_for_filter = $sem_stud && !empty($sem_stud->Section)   ? (string)$sem_stud->Section   : (isset($stud->Section)   ? (string)$stud->Section   : '');
        $this->db->reset_query();
        $narrative = $this->db->select('*')
            ->from('narrative')
            ->where('StudentNumber', $studentNumber)
            ->where('SY', $sy)
            ->group_start()
                ->where('YearLevel', $yl_for_filter)
                ->or_where('YearLevel', (string)$yl_for_filter)
            ->group_end()
            ->group_start()
                ->where('Section', $sec_for_filter)
                ->or_where('Section', (string)$sec_for_filter)
            ->group_end()
            ->order_by('narrativeID', 'DESC')
            ->limit(1)
            ->get()
            ->row();
        $att = $this->_attendance_from_advisory($studentNumber, $sy);
        $branding = $this->_branding_urls();
        $rc = $this->_rc_branding_urls();
        $this->load->view($view, array(
            'selected_sy'       => $sy,
            'stud'              => $stud,
            'sem_stud'          => $sem_stud,
            'cur_stud'          => $cur_stud,
            'prin'              => $prin,
            'data'              => $rows,
            'deported_codes'    => $deported_codes,
            'template_subjects' => $template_subjects,
            'form_blocked'      => $form_blocked,
            'gradeIndex'        => $gradeIndex,
            'rcLeftUrl'         => $rc['rcLeftUrl'],
            'rcRightUrl'        => $rc['rcRightUrl'],
            'rcSealUrl'         => $rc['rcSealUrl'],
            'schoolLogoSafe'    => $branding['school_logo_url'],
            'letterheadUrl'     => $branding['letterhead_url'],
            'depedLogoUrl'      => $branding['deped_logo_url'],
            'narrative'         => $narrative ?: null, 
            'months'            => $att['months'],
            'days_of_school'    => $att['school_days'],
            'days_present'      => $att['present_days'],
            'schoolName'    => $schoolName,
'schoolAddress' => $schoolAddress,
'schoolEmail'   => $schoolEmail,
'principalName' => $principalName,

        ));
    }


    private function normalize_year_level($yl)
    {
        $s = trim((string)$yl);
        if ($s === '') return null;
        if (preg_match('/(\d{1,2})/', $s, $m)) {
            $n = (int)$m[1];
            return ($n >= 1 && $n <= 12) ? $n : null;
        }
        return null;
    }


    private function _rc_branding_urls()
    {
        $row = $this->db->get_where('rc_branding', ['is_active' => 1])->row();
        $mk = function($fname){
            if (!$fname) return '';
            $abs = FCPATH . 'upload/banners/' . $fname;
            return is_file($abs) ? base_url('upload/banners/' . rawurlencode($fname)) : '';
        };
        return [
            'rcLeftUrl'  => $row ? $mk($row->rc_logo_left_web)  : '',
            'rcRightUrl' => $row ? $mk($row->rc_logo_right_web) : '',
            'rcSealUrl'  => $row ? $mk($row->rc_seal_web)       : '',
        ];
    }
    public function rc_upload($slot = 'left')
    {
        $map = ['left'=>'rc_logo_left_web','right'=>'rc_logo_right_web','seal'=>'rc_seal_web'];
        if (!isset($map[$slot])) show_404();

        $config = [
            'upload_path'   => './upload/banners/',
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size'      => 15000,
        ];
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('nonoy')) {
            $this->session->set_flashdata('msg',
                '<div class="alert alert-danger text-center"><b>' .
                htmlspecialchars($this->upload->display_errors('', ''), ENT_QUOTES, 'UTF-8') .
                '</b></div>');
            redirect('Settings/loginFormBanner');
            return;
        }

        $fn = $this->upload->data('file_name');
        $row = $this->db->get_where('rc_branding', ['is_active'=>1])->row();
        if (!$row) { $this->db->insert('rc_branding', ['is_active'=>1]); }
        $this->db->where('is_active', 1)->update('rc_branding', [$map[$slot] => $fn]);
        $this->session->set_flashdata('msg',
            '<div class="alert alert-success text-center"><b>Uploaded '.ucfirst($slot).' image.</b></div>');
        redirect('Settings/loginFormBanner');
    }
  private function _attendance_from_advisory(string $studentNumber, string $sy): array
{
    $months_ordered = ['JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER','JANUARY','FEBRUARY','MARCH'];
    $allowed = array_flip($months_ordered);
    $school_days  = array_fill_keys($months_ordered, 0);
    $present_days = array_fill_keys($months_ordered, 0.0);

    $this->db->reset_query();
    $res = $this->db->select('attendance, Period, date_recorded')
        ->from('advisory_attendance')
        ->where('StudentNumber', $studentNumber)
        ->where('SY', $sy)
        ->order_by('date_recorded', 'ASC')
        ->get()
        ->result();
    if (empty($res)) {
        $classdays = $this->_school_days_from_classdays($sy);
        if (!empty($classdays)) {
            foreach ($classdays as $mon => $cnt) {
                if (isset($school_days[$mon])) $school_days[$mon] = (int)$cnt;
            }
        }
        return [
            'months'       => $months_ordered,
            'school_days'  => $school_days,
            'present_days' => $present_days,
        ];
    }
    $byDate = [];
    foreach ($res as $r) {
        $ts = strtotime((string)$r->date_recorded);
        if (!$ts) continue;
        $date = date('Y-m-d', $ts);

        $period = strtoupper(trim((string)$r->Period));
        if ($period === '') $period = 'ALL';

        $att = is_numeric($r->attendance) ? (int)$r->attendance : 0;
        if (!isset($byDate[$date])) $byDate[$date] = [];
        $byDate[$date][] = ['period' => $period, 'att' => $att];
    }
    foreach ($byDate as $date => $rows) {
        $ts = strtotime($date);
        if (!$ts) continue;
        $mon = strtoupper(date('F', $ts));
        if (!isset($allowed[$mon])) continue;

        $perPeriod = [];
        foreach ($rows as $row) {
            $p = $row['period'];
            if (!isset($perPeriod[$p])) $perPeriod[$p] = 0;
            $perPeriod[$p] = max($perPeriod[$p], (int)$row['att']);
        }
        $numPeriods = max(1, count($perPeriod));
        $weight = ($numPeriods > 1) ? (1.0 / $numPeriods) : 1.0;

        $presentForDate = 0.0;
        foreach ($perPeriod as $p => $val) {
            $presentForDate += ($val ? 1.0 : 0.0) * $weight;
        }
        if ($presentForDate > 1.0) $presentForDate = 1.0;
        $school_days[$mon] += 1;
        $present_days[$mon] = (float)$present_days[$mon] + $presentForDate;
    }
    $classdays = $this->_school_days_from_classdays($sy);
    if (!empty($classdays)) {
        foreach ($classdays as $mon => $cnt) {
            if (isset($school_days[$mon])) $school_days[$mon] = (int)$cnt;
        }
    }
    return [
        'months'       => $months_ordered,
        'school_days'  => $school_days,
        'present_days' => $present_days,
    ];
}

    private function _school_days_from_classdays(string $sy): array
{
    $map = [
        'JUNE'      => 'jun',
        'JULY'      => 'jul',
        'AUGUST'    => 'aug',
        'SEPTEMBER' => 'sep',
        'OCTOBER'   => 'oct',
        'NOVEMBER'  => 'nov',
        'DECEMBER'  => 'december',
        'JANUARY'   => 'jan',
        'FEBRUARY'  => 'feb',
        'MARCH'     => 'mar',
    ];

    $norm = static function($s){
        return strtolower(preg_replace('/\s+/', '', (string)$s));
    };
    $sy_norm = $norm($sy);

    // exact normalized match
    $this->db->reset_query();
    $this->db->from('classdays');
    $this->db->where("REPLACE(LOWER(SY), ' ', '') =", $sy_norm, false);
    $rows = $this->db->get()->result();

    // loose LIKE fallback
    if (!$rows) {
        $this->db->reset_query();
        $this->db->from('classdays');
        $this->db->like('SY', trim($sy), 'both');
        $rows = $this->db->get()->result();
    }

    // final fallback: most recent row
    if (!$rows) {
        $this->db->reset_query();
        $rows = $this->db->order_by('classID', 'DESC')->limit(1)->get('classdays')->result();
    }

    if (!$rows) return [];

    // merge (max per month handles per-semester duplicates)
    $out = array_fill_keys(array_keys($map), 0);
    foreach ($rows as $r) {
        foreach ($map as $month => $col) {
            if (property_exists($r, $col)) {
                $val = (int)($r->$col ?? 0);
                if ($val > $out[$month]) $out[$month] = $val;
            }
        }
    }
    return $out;
}

}
