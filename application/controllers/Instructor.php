<?php
class Instructor extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('InstructorModel');
		$this->load->model('SettingsModel');

		if ($this->session->userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}

	function facultyLoad()
	{
		if ($this->session->userdata('level') === 'Admin') {
			$id = $this->input->get('id');
		} elseif ($this->session->userdata('level') === 'HR Admin') {
			$id = $this->input->get('id');
		} else {
			//$id=$this->session->userdata('fName').' '.$this->session->userdata('lName');
			$id = $this->session->userdata('username');
		}

		$sem = $this->session->userdata('semester');
		$sy = $this->session->userdata('sy');
		$result['data'] = $this->InstructorModel->facultyLoad($id, $sy);
		$this->load->view('faculty_load', $result);
	}


	function subjectsMasterlist()
	{
		// Determine the ID based on user level
		if ($this->session->userdata('level') === 'Teacher') {
			$id = $this->session->userdata('username');
		} else {
			$id = $this->input->get('id');
		}

		// Retrieve other parameters
		$section = $this->input->get('section');
		$yearLevel = $this->input->get('yearLevel');

		$sy = $this->session->userdata('sy');

		// Fetch the masterlist data

		$result['data'] = $this->InstructorModel->facultyMasterlist($id, $sy, $section, $yearLevel);


		// Load the view with the data
		$this->load->view('masterlist_by_subject', $result);
	}

	// public function subjectGrades()
	// {
	//     if ($this->session->userdata('level') === 'Teacher') {
	//         $id = $this->session->userdata('username');
	//     } else {
	//         $id = $this->input->get('id');
	//     }

	//     $subjectcode = $this->input->get('subjectcode');
	//     $section     = $this->input->get('section');
	//     $strand      = $this->input->get('strand');
	//     $sem         = $this->session->userdata('semester');
	//     $sy          = $this->session->userdata('sy');

	//     $result['data'] = $this->InstructorModel->subjectGrades($id, $sy, $section, $subjectcode);
	//     $result['grade'] = $this->Common->get_subject_enrollees($sy, $section, $subjectcode, $strand);
	//     $result['g'] = $this->Common->three_cond_row('registration', 'SY', $sy, 'Section', $section, 'SubjectCode', $subjectcode);
	//     $result['grades'] = $this->Common->get_subject_grade_records($sy, $section, $subjectcode, $strand);

	//     $setting = $this->db->get_where('srms_settings_o', ['settingsID' => 1])->row();
	//     $result['preschoolGradeType'] = $setting->preschoolGrade;
	//     $result['isPreschool'] = in_array($result['g']->YearLevel, ['Kinder', 'Kinder 1', 'Kinder 2', 'Preschool']);

	// 	date_default_timezone_set('Asia/Manila');

	// $lockSchedule = $this->SettingsModel->get_lock_schedule($sy);
	// $result['lockSchedule'] = $lockSchedule;


	// 	$now = date('Y-m-d H:i:s');
	// $lockSchedule = $this->SettingsModel->get_lock_schedule($sy);
	// $result['lock'] = [
	//     'prelim_locked'   => ($lockSchedule && $now > $lockSchedule->prelim),
	//     'midterm_locked'  => ($lockSchedule && $now > $lockSchedule->midterm),
	//     'prefinal_locked' => ($lockSchedule && $now > $lockSchedule->prefinal),
	//     'final_locked'    => ($lockSchedule && $now > $lockSchedule->final),
	// ];

	//     $this->load->view('subject_grades', $result);
	// }

	public function subjectGrades()
{
    // 1) Resolve instructor ID
    $id = ($this->session->userdata('level') === 'Teacher')
        ? $this->session->userdata('username')
        : $this->input->get('id');

    // 2) Inputs / session context
    $subjectcode = $this->input->get('subjectcode');   // may be truncated if & not encoded
    $Description = $this->input->get('Description');
    if ($Description === null || $Description === '') {
        $Description = $this->input->get('description');
    }
    $section = $this->input->get('section');
    $strand  = $this->input->get('strand');
    $sem     = $this->session->userdata('semester');
    $sy      = $this->session->userdata('sy');

    // 3) Try fetching by the raw (possibly truncated) SubjectCode first
    $g = $this->Common->three_cond_row('registration', 'SY', $sy, 'Section', $section, 'SubjectCode', $subjectcode);

    // If not found but we have a Description, try recovering via Description
    if (!$g && $Description) {
        $g = $this->Common->three_cond_row('registration', 'SY', $sy, 'Section', $section, 'Description', $Description);
    }

    // 3a) Canonicalize values from registration row if available
    $resolvedSubjectCode = $g->SubjectCode ?? $subjectcode ?? '';
    $resolvedDescription = $g->Description ?? $Description ?? '';
    $resolvedYearLevel   = $g->YearLevel   ?? ($this->input->get('yearlevel') ?? '');

    // 3b) Fetch data using the resolved (canonical) values
    $result['data']   = $this->InstructorModel->subjectGrades($id, $sy, $section, $resolvedSubjectCode, $resolvedDescription);
    $rawEnrollees     = $this->Common->get_subject_enrollees($sy, $section, $resolvedSubjectCode, $strand);
    [$filteredEnrollees, $duplicateStudents] = $this->_split_student_duplicates($rawEnrollees);
    $result['grade']             = $filteredEnrollees;
    $result['duplicateStudents'] = $duplicateStudents;
    $result['g']      = $g; // keep the canonical registration row for the view/logic
    $result['grades'] = $this->Common->get_subject_grade_records($sy, $section, $resolvedSubjectCode, $strand);

    // 3c) Expose resolved values to the view (use these for display)
    $result['resolvedSubjectCode'] = $resolvedSubjectCode;
    $result['resolvedDescription'] = $resolvedDescription;
    $result['resolvedYearLevel']   = $resolvedYearLevel;

    // 4) Settings (guard against null)
    $setting = $this->db->get_where('srms_settings_o', ['settingsID' => 1])->row();
    $result['preschoolGradeType'] = $setting ? $setting->preschoolGrade : null;

    // 5) Determine YearLevel safely + preschool bucket
    $yearLevelParam = $this->input->get('yearlevel');
    $yearLevel = $resolvedYearLevel ?: ($yearLevelParam ?: null);

    $preschoolBuckets = ['Kinder','Kinder 1','Kinder 2','Preschool','Nursery','Prekinder'];
    $result['isPreschool'] = $yearLevel ? in_array($yearLevel, $preschoolBuckets, true) : false;

    // 6) Grade lock schedule (time-based)
    date_default_timezone_set('Asia/Manila');
    $now = date('Y-m-d H:i:s');

    $lockSchedule = $this->SettingsModel->get_lock_schedule($sy); // might be null
    $result['lockSchedule'] = $lockSchedule;

    $result['lock'] = [
        'prelim_locked'   => ($lockSchedule && $now > $lockSchedule->prelim),
        'midterm_locked'  => ($lockSchedule && $now > $lockSchedule->midterm),
        'prefinal_locked' => ($lockSchedule && $now > $lockSchedule->prefinal),
        'final_locked'    => ($lockSchedule && $now > $lockSchedule->final),
    ];

    // 7) Grading period filter (default to all 4)
    $periodMap = [
        '1' => ['key' => 'prelim',   'num' => 'PGrade',      'let' => 'l_p',  'label' => '1st Grading', 'lock' => 'prelim_locked'],
        '2' => ['key' => 'midterm',  'num' => 'MGrade',      'let' => 'l_m',  'label' => '2nd Grading', 'lock' => 'midterm_locked'],
        '3' => ['key' => 'prefinal', 'num' => 'PFinalGrade', 'let' => 'l_pf', 'label' => '3rd Grading', 'lock' => 'prefinal_locked'],
        '4' => ['key' => 'final',    'num' => 'FGrade',      'let' => 'l_f',  'label' => '4th Grading', 'lock' => 'final_locked'],
    ];

    $raw = $this->input->get('periods');
    if (is_array($raw)) {
        $picked = $raw;
    } elseif (is_string($raw) && strlen(trim($raw))) {
        $picked = array_map('trim', explode(',', $raw));
    } else {
        $picked = ['1','2','3','4']; // default: show all
    }
    $picked = array_values(array_intersect(['1','2','3','4'], $picked));

    $selectedPeriods = [];
    foreach ($picked as $p) {
        if (isset($periodMap[$p])) {
            $selectedPeriods[] = array_merge($periodMap[$p], ['id' => $p]);
        }
    }
    if (!$selectedPeriods) {
        $selectedPeriods = [
            array_merge($periodMap['1'], ['id'=>'1']),
            array_merge($periodMap['2'], ['id'=>'2']),
            array_merge($periodMap['3'], ['id'=>'3']),
            array_merge($periodMap['4'], ['id'=>'4']),
        ];
    }
    $result['selectedPeriods'] = $selectedPeriods;
    $result['allPeriods']      = $periodMap;

    // 8) Subject-level lock from grades_lock_subject (override schedule) — use resolved values
    $lockRow = $this->db
        ->where('SY',          $sy)
        ->where('SubjectCode', $resolvedSubjectCode)
        ->where('Description', $resolvedDescription)
        ->where('Section',     $section)
        ->where('YearLevel',   $resolvedYearLevel)
        ->get('grades_lock_subject')
        ->row();

    if ($lockRow) {
        $result['lock']['prelim_locked']   = ((int)$lockRow->lock_prelim   === 1);
        $result['lock']['midterm_locked']  = ((int)$lockRow->lock_midterm  === 1);
        $result['lock']['prefinal_locked'] = ((int)$lockRow->lock_prefinal === 1);
        $result['lock']['final_locked']    = ((int)$lockRow->lock_final    === 1);
    }
    $result['lockRow'] = $lockRow;

    // 9) Load view
    $this->load->view('subject_grades', $result);
}

    private function _split_student_duplicates($rows)
    {
        if (!is_array($rows)) {
            if (empty($rows)) {
                return [[], []];
            }
            $rows = [$rows];
        }

        $unique = [];
        $dupes  = [];
        $seen   = [];

        foreach ($rows as $row) {
            $sn = '';
            if (is_object($row) && isset($row->StudentNumber)) {
                $sn = trim((string)$row->StudentNumber);
            } elseif (is_array($row) && isset($row['StudentNumber'])) {
                $sn = trim((string)$row['StudentNumber']);
            }

            if ($sn === '') {
                $unique[] = $row;
                continue;
            }

            if (!isset($seen[$sn])) {
                $seen[$sn] = true;
                $unique[] = $row;
            } else {
                $dupes[] = $row;
            }
        }

        return [$unique, $dupes];
    }


	function gradingSheets()
	{
		$instructor = $this->session->userdata('fName') . '' . $this->session->userdata('lName');
		$sem = $this->session->userdata('semester');
		$sy = $this->session->userdata('sy');

		$result['data'] = $this->InstructorModel->gradingSheets($id, $sy, $sem);
		$this->load->view('grading_sheets', $result);
	}



	
	function uploadGrades()
	{
		$this->load->view('grades_upload');

		if ($this->input->post('upload')) {
			$data = [];

			// Check if a file is selected
			if (!empty($_FILES['file']['name'])) {
				// Set upload preferences
				$config = [
					'upload_path'   => 'upload/grades/',
					'allowed_types' => 'csv',
					'max_size'      => 10000, // in kb
					'file_name'     => $_FILES['file']['name']
				];

				// Load upload library
				$this->load->library('upload', $config);

				// Perform file upload
				if ($this->upload->do_upload('file')) {
					// Get file data and read file
					$filePath = $this->upload->data('full_path');
					$importDataArr = [];

					if (($file = fopen($filePath, "r")) !== FALSE) {
						while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
							$importDataArr[] = $filedata;
						}
						fclose($file);
					}

					// Insert import data, skipping the header row
					foreach ($importDataArr as $index => $userdata) {
						if ($index > 0) {
							$this->InstructorModel->gradessUploading($userdata);
						}
					}
					$this->session->set_flashdata('success', 'Uploaded Successfully.');
				} else {
					$data['response'] = '<div class="alert alert-warning text-center">Upload Failed: ' . $this->upload->display_errors() . '</div>';
				}
			} else {
				$data['response'] = '<div class="alert alert-warning text-center">No file selected.</div>';
			}
		}
	}







// Instructor.php
public function consol_teacher()
{
    $gl      = trim((string)$this->input->post('grade_level'));
    $grading = trim((string)$this->input->post('grading'));
    $section = trim((string)$this->input->post('section'));
    $ver     = (int)$this->input->post('version');
    $sy      = (string)$this->session->userdata('sy');

    $result['ver'] = $ver ?: 2;
    $result['gl']  = $gl;
    $result['sec'] = $section;
    $result['data'] = "Grading Sheets";

    // ✅ SUBJECTS: keep your original behavior — show ALL subjects for GL + SY
    $result['sub'] = $this->Common->two_cond_gb(
        'grades', 'YearLevel', $gl, 'SY', $sy, 'SubjectCode', 'SubjectCode', 'asc'
    );

    // Students according to version (same as yours)
    if ($ver === 1) {
        $result['grade'] = $this->Common->cons($gl, $section, $sy);
    } elseif ($ver === 3) {
        $result['grade'] = $this->Common->consv3($gl, $section, $sy);
    } else {
        $result['grade'] = $this->Common->consv2($gl, $section, $sy);
    }

    $result['so'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);

    // 🔒 Build teacher-owned YearLevel→Sections map (for dropdowns in JS)
    $teacherID = trim((string)$this->session->userdata('IDNumber'));
    $this->db->select('YearLevel, Section');
    $this->db->from('sections');
    $this->db->where('SY', $sy);
    $this->db->where('IDNumber', $teacherID);
    $this->db->order_by('YearLevel', 'ASC');
    $this->db->order_by('Section', 'ASC');
    $teacherRows = $this->db->get()->result();

    $owned = []; // ['Grade 7' => ['A','B'], 'Grade 8' => ['C']]
    foreach ($teacherRows as $r) {
        $yl = (string)$r->YearLevel;
        $sc = (string)$r->Section;
        if (!isset($owned[$yl])) $owned[$yl] = [];
        if (!in_array($sc, $owned[$yl], true)) $owned[$yl][] = $sc;
    }
    $result['owned_map_json'] = json_encode($owned, JSON_UNESCAPED_UNICODE);

    // 🚧 Guard against tampered POST: if submitted GL/Section not owned, null them
    if ($this->input->post('submit')) {
        $okGL = array_key_exists($gl, $owned);
        $okSec = $okGL ? in_array($section, $owned[$gl] ?? [], true) : false;
        if (!$okGL || !$okSec) {
            $result['gl'] = '';
            $result['sec'] = '';
            $result['grade'] = [];
            $result['sub'] = [];
            $result['tamper_msg'] = 'Selected Grade Level / Section is not assigned to you.';
        }
    }

    // ⬇️ Use your same view (e.g., consolidated_subject_ranking / consol_report)
    $this->load->view('consolidated_subject_ranking', $result);
}






}
