<?php
class Masterlist extends CI_Controller
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
		$this->load->model('GradesLockModel');


		if ($this->session->userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}
	//Masterlist by Grade Level
	function masterlistAll()
	{
		$semester = $this->session->userdata('semester');
		$sy = $this->session->userdata('sy');
		$result['data'] = $this->StudentModel->masterlistAll($semester, $sy);
		$this->load->view('masterlist_all', $result);
	}

	//Masterlist by Grade Level
	function byGradeYL()
	{
		$yearlevel = $this->input->get('yearlevel');
		$semester = $this->session->userdata('semester');
		$sy = $this->session->userdata('sy');
		$result['data'] = $this->StudentModel->byGradeLevel($yearlevel, $semester, $sy);
		$result['data1'] = $this->StudentModel->byGradeLevelCount($yearlevel, $semester, $sy);
		$this->load->view('masterlist_by_gradelevel', $result);

		if ($this->input->post('submit')) {
			$yearlevel = $this->input->get('yearlevel');
			$semester = $this->input->get('semester');
			$sy = $this->session->userdata('sy');
			$result['data'] = $this->StudentModel->byGradeLevel($yearlevel, $semester, $sy);
			$result['data1'] = $this->StudentModel->byGradeLevelCount($yearlevel, $semester, $sy);
			$this->load->view('masterlist_by_gradelevel', $result);
		}
	}

	function trackMasterList()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$trackVal = $this->input->get('track');
		$strandVal = $this->input->get('strand');
		$gradelevel = $this->input->get('gradelevel');
		$result['track'] = $this->SettingsModel->getTrack();
		$result['data'] = $this->StudentModel->byTrack($sy, $trackVal, $strandVal, $gradelevel);
		$result['trackVal'] = $trackVal;
		$result['strandVal'] = $strandVal;
		$this->load->view('masterlist_by_track', $result);
	}

	function signupList()
	{
		$result['data'] = $this->StudentModel->bySignup();
		$this->load->view('masterlist_by_signup', $result);
	}
	//Masterlist by Grade Level
	function byGradeLevel()
	{
		$yearlevel = $this->input->get('yearlevel');
		// $semester = $this->input->get('semester'); 
		$sy = $this->session->userdata('sy');
		$result['data'] = $this->StudentModel->byGradeLevel($yearlevel, $sy);
		$this->load->view('masterlist_by_gradelevel', $result);

		if ($this->input->post('submit')) {
			$yearlevel = $this->input->get('yearlevel');
			$semester = $this->input->get('semester');
			$sy = $this->session->userdata('sy');
			$result['data'] = $this->StudentModel->byGradeLevel($yearlevel, $semester, $sy);
			$this->load->view('masterlist_by_gradelevel', $result);
		}
	}


	function bySection()
	{
		$section = $this->input->get('section');
		$YearLevel = $this->input->get('yearLevel');
		$sy = $this->session->userdata('sy');

		// Fetch data for the specified section
		$result['data'] = $this->StudentModel->bySection($section, $YearLevel, $sy);
		$result['section'] = $this->StudentModel->getSections();

		// Check for form submission
		if ($this->input->post('submit')) {
			$section = $this->input->get('section');
			$YearLevel = $this->input->get('yearlevel');
			$result['data'] = $this->StudentModel->bySection($section, $YearLevel, $sy);
		}

		// Load the view
		$this->load->view('masterlist_by_section', $result);
	}


	public function getSectionsByYearLevel()
	{
		$yearLevel = $this->input->get('yearLevel');
		$sections = $this->StudentModel->getSectionsByYearLevel($yearLevel);
		echo json_encode($sections);
	}


	public function enrolledList()
	{
		$sy = $this->input->post('sy') ?? $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');

		$result['data'] = $this->StudentModel->bySY($sy, $sem);
		$result['school_years'] = $this->StudentModel->getSchoolYearsWithEnrolledStudents();
		$result['selected_sy'] = $sy;

		// Other data
		$result['course'] = $this->StudentModel->getCourse();
		$result['track'] = $this->SettingsModel->getTrack();
		$result['strand'] = $this->SettingsModel->getStrand1();
		$result['stud'] = $this->Common->getStudeProfiles();
		$result['t'] = $this->SettingsModel->track();
		$result['s'] = $this->SettingsModel->strand();
		$schoolInfo = $this->SettingsModel->getSchoolInformation();
		$result['letterhead'] = $schoolInfo;
		$result['schoolType'] = $schoolInfo[0]->schoolType ?? ''; // Add this line



		// ✅ FIXED: assign to $result not $data
		$result['specialNeedsCount'] = $this->StudentModel->countWithSpecialNeeds($sy);

		// Summary counts
		$result['summary'] = [
			'transferee' => $this->StudentModel->countByCategory('transferee', $sy),
			'repeater' => $this->StudentModel->countByCategory('repeater', $sy),
			'balik_aral' => $this->StudentModel->countByCategory('balik_aral', $sy),
			'ip' => $this->StudentModel->countByCategory('ip', $sy),
			'4ps' => $this->StudentModel->countByCategory('4ps', $sy),
		];

		$this->load->view('enrolled_list', $result);
	}

	public function viewCategoryList($category)
	{
		$sy = $this->session->userdata('sy');

		$data['category'] = ucfirst(str_replace('_', ' ', $category));
		$data['students'] = $this->StudentModel->getStudentsByCategory($category, $sy);

		$this->load->view('stude_category_list', $data);
	}

	public function viewCategoryListByAdviser($category)
	{
		$sy = $this->session->userdata('sy');
		$adviserId = $this->session->userdata('username');

		$data['category'] = ucfirst(str_replace('_', ' ', $category));
		$data['students'] = $this->StudentModel->getStudentsByCategoryByAdviser($category, $sy, $adviserId);

		$this->load->view('stude_category_list', $data);
	}

	public function exportCategoryList($category)
	{
		$sy = $this->session->userdata('sy');
		$students = $this->StudentModel->getStudentsByCategory($category, $sy);

		// Set headers for download
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename="' . $category . '_students.csv"');

		$output = fopen('php://output', 'w');

		// Output the column headers
		fputcsv($output, ['LRN', 'Name', 'Grade', 'Section']);

		// Output student data
		foreach ($students as $s) {
			$name = $s->LastName . ', ' . $s->FirstName . ' ' . $s->MiddleName;
			fputcsv($output, [$s->StudentNumber, $name, $s->YearLevel, $s->Section]);
		}

		fclose($output);
		exit;
	}



	public function advisoryClass()
	{
		$this->load->model('StudentModel');

		$adviserId = $this->session->userdata('username');
		$sy = $this->session->userdata('sy');

		// Fetch students under this adviser's section for the current SY
		$students = $this->StudentModel->getAdvisoryClass($adviserId, $sy);
		$data['students'] = $students;

		// Summary counts
		$data['summary'] = [
			'transferee'   => $this->StudentModel->countByCategoryByAdviser('transferee', $sy, $adviserId),
			'repeater'     => $this->StudentModel->countByCategoryByAdviser('repeater', $sy, $adviserId),
			'balik_aral'   => $this->StudentModel->countByCategoryByAdviser('balik_aral', $sy, $adviserId),
			'ip'           => $this->StudentModel->countByCategoryByAdviser('ip', $sy, $adviserId),
			'4ps'          => $this->StudentModel->countByCategoryByAdviser('4ps', $sy, $adviserId),
		];

		// Age grouping
		$data['age_summary'] = $this->StudentModel->countByAgeCategoryByAdviser($sy, $adviserId);

		// Load narrative data per student
		$narratives = [];
		foreach ($students as $student) {
			$narrative = $this->StudentModel->getNarrative($student->StudentNumber, $sy);
			if ($narrative) {
				$narratives[$student->StudentNumber] = $narrative;
			}
		}
		$data['narratives'] = $narratives;

		// Pass to view
		$this->load->view('advisory_class', $data);
	}


	public function viewAgeList($age)
	{
		$this->load->model('StudentModel');
		$adviserId = $this->session->userdata('username');
		$sy = $this->session->userdata('sy');

		// Fetch the students for this age
		$data['students'] = $this->StudentModel->getStudentsByAge($adviserId, $sy, $age);

		// Pass the age variable to the view so it can be used in the view
		$data['age'] = $age;

		// Load the view to display the students
		$this->load->view('students_by_age', $data);
	}



	public function exportAgeList($age)
	{
		$this->load->model('StudentModel'); // ensure model is loaded

		$adviserId = $this->session->userdata('username');
		$sy        = $this->session->userdata('sy');

		// If you want “age as of June 1 of the starting SY”, uncomment next 2 lines:
		// $startYear = (int)substr((string)$sy, 0, 4);
		// $students  = $this->StudentModel->getStudentsByAgelist((int)$age, $sy, $adviserId, "{$startYear}-06-01");

		$students = $this->StudentModel->getStudentsByAgelist((int)$age, $sy, $adviserId);

		// Set headers for download (with UTF-8 for Excel friendliness)
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename="students_age_' . (int)$age . '_SY_' . preg_replace('/\s+/', '_', (string)$sy) . '.csv"');
		// Optional BOM for Excel on Windows:
		echo "\xEF\xBB\xBF";

		$out = fopen('php://output', 'w');

		// Choose LRN if present, else StudentNumber
		fputcsv($out, ['LRN/Student No.', 'Name', 'Grade', 'Section', 'Age']);

		foreach ($students as $s) {
			$lrnOrStudNo = $s->LRN ?: $s->StudentNumber;
			$mid         = trim((string)$s->MiddleName) !== '' ? ' ' . mb_substr($s->MiddleName, 0, 1) . '.' : '';
			$name        = "{$s->LastName}, {$s->FirstName}{$mid}";
			fputcsv($out, [$lrnOrStudNo, $name, $s->YearLevel, $s->Section, $s->Age]);
		}

		fclose($out);
		exit;
	}



	function bySY()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$yearLevel = $this->input->get('year_level'); // Get year level filter if set

		if ($yearLevel) {
			$result['data'] = $this->StudentModel->bySYandYearLevel($sy, $yearLevel);
		} else {
			$result['data'] = $this->StudentModel->bySY($sy);
		}

		$result['year_level_summary'] = $this->StudentModel->countByYearLevel($sy);

		$this->load->view('masterlist_by_sy', $result);

		if ($this->input->post('submit')) {
			$sy = $this->input->get('sy');
			$result['data'] = $this->StudentModel->bySY($sy);
			$result['year_level_summary'] = $this->StudentModel->countByYearLevel($sy);
			$this->load->view('masterlist_by_sy', $result);
		}
	}



	//Masterlist Daily Enrollment
	function dailyEnrollees()
	{
		$date = $this->input->get('date');
		$result['data'] = $this->StudentModel->byDate($date);
		$result['data1'] = $this->StudentModel->byDateCourseSum($date);
		$this->load->view('masterlist_daily_enrollees', $result);

		if ($this->input->post('submit')) {
			$date = $this->input->get('date');
			$result['data'] = $this->StudentModel->byDate($date);
			$result['data1'] = $this->StudentModel->byDateCourseSum($date);
			$this->load->view('masterlist_daily_enrollees', $result);
		}
	}

	//Masterlist by Course
	function byCourse()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$course = $this->input->get('course');
		$result['data'] = $this->StudentModel->byCourse($course, $sy, $sem);
		$this->load->view('masterlist_by_course', $result);

		if ($this->input->post('submit')) {
			$sy = $this->session->userdata('sy');
			$department = $this->input->get('department');
			$result['data'] = $this->StudentModel->byDepartment($department, $sy);
			$this->load->view('masterlist_by_department', $result);
		}
	}

	//Masterlist by Department
	function byDepartment()
	{
		$sy = $this->session->userdata('sy');
		$department = $this->input->get('department');
		$result['data'] = $this->StudentModel->byDepartment($department, $sy);
		$result['data1'] = $this->StudentModel->bySectionCount($department, $sy);
		//$result['data2']=$this->StudentModel->byYearLevelCount($department, $sy);
		$this->load->view('masterlist_by_department', $result);

		if ($this->input->post('submit')) {
			$sy = $this->session->userdata('sy');
			$department = $this->input->get('department');
			$result['data'] = $this->StudentModel->byDepartment($department, $sy);
			$this->load->view('masterlist_by_department', $result);
		}
	}

	//Masterlist by Department
	function byDepartmentSHS()
	{
		$sy = $this->session->userdata('sy');
		$department = $this->input->get('department');
		$result['data'] = $this->StudentModel->byDepartmentSHS($department, $sy);
		$result['data1'] = $this->StudentModel->bySectionCount($department, $sy);
		//$result['data2']=$this->StudentModel->byYearLevelCount($department, $sy);
		$this->load->view('masterlist_by_department', $result);

		if ($this->input->post('submit')) {
			$sy = $this->session->userdata('sy');
			$department = $this->input->get('department');
			$result['data'] = $this->StudentModel->byDepartmentSHS($department, $sy);
			$this->load->view('masterlist_by_department', $result);
		}
	}

	//Masterlist by Department
	function byDepartmentSHS2()
	{
		$sy = $this->session->userdata('sy');
		$department = $this->input->get('department');
		$result['data'] = $this->StudentModel->byDepartmentSHS2($department, $sy);
		$result['data1'] = $this->StudentModel->bySectionCount($department, $sy);
		//$result['data2']=$this->StudentModel->byYearLevelCount($department, $sy);
		$this->load->view('masterlist_by_department', $result);

		if ($this->input->post('submit')) {
			$sy = $this->session->userdata('sy');
			$department = $this->input->get('department');
			$result['data'] = $this->StudentModel->byDepartmentSHS2($department, $sy);
			$this->load->view('masterlist_by_department', $result);
		}
	}

	//Masterlist by Enrolled Online
	function byEnrolledOnline()
	{
		$sy = $this->session->userdata('sy');
		$department = $this->input->get('department');
		$result['data'] = $this->StudentModel->byEnrolledOnline($department, $sy);
		$this->load->view('masterlist_by_oe', $result);

		if ($this->input->post('submit')) {
			$sy = $this->session->userdata('sy');
			$department = $this->input->get('department');
			$result['data'] = $this->StudentModel->byEnrolledOnline($department, $sy);
			$this->load->view('masterlist_by_oe', $result);
		}
	}

	//Masterlist for Payment Acceptance
	function forPaymentAcceptance()
	{
		$result['data'] = $this->StudentModel->byEnrolledOnline();
		$this->load->view('masterlist_by_op_verification', $result);

		if ($this->input->post('submit')) {
			$result['data'] = $this->StudentModel->byEnrolledOnline();
			$this->load->view('masterlist_by_op_verification', $result);
		}
	}

	function studeReligion()
	{
		$sy = $this->session->userdata('sy');
		$religion = $this->input->get('religion');

		// Get the list of religions (you can create a function to fetch distinct religions if needed)
		$religions = $this->StudentModel->getReligions();

		// Get the student list based on the selected religion
		$result['data'] = $this->StudentModel->religionList($sy, $religion);
		$result['religions'] = $religions; // Pass the religions to the view

		// Load the view
		$this->load->view('masterlist_by_religion', $result);
	}

	public function studeEthnicity()
	{
		$sy = $this->session->userdata('sy');
		$ethnicity = $this->input->get('ethnicity');

		// Get list of distinct ethnicities
		$ethnicities = $this->StudentModel->getEthnicities();

		// Get filtered list of students by ethnicity
		$result['data'] = $this->StudentModel->ethnicityLists($sy, $ethnicity);
		$result['ethnicities'] = $ethnicities; // Pass ethnicities to view

		// Load the view
		$this->load->view('masterlist_by_ethnicity', $result);
	}



	//Masterlist by City
	function cityList()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$city = $this->input->get('city');
		$result['data'] = $this->StudentModel->cityList($sy, $city);
		$this->load->view('masterlist_by_city', $result);
	}
	//Masterlist by Ethnicity
	function ethnicityList()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$ethnicity = $this->input->get('ethnicity');
		$result['data'] = $this->StudentModel->ethnicityList($sy, $ethnicity);
		$this->load->view('masterlist_by_ethnicity', $result);
	}
	//Masterlist of Teachers
	function teachers()
	{
		$result['data'] = $this->StudentModel->teachers();
		$this->load->view('masterlist_teachers', $result);
	}

	//Masterlist by Enrolled Online
	function byEnrolledOnlineSem()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['data'] = $this->StudentModel->byEnrolledOnlineSem($sy);
		$this->load->view('masterlist_by_oe', $result);
	}
	function byEnrolledOnlineAll()
	{
		$sy = $this->session->userdata('sy');
		$result['data'] = $this->StudentModel->byEnrolledOnlineAll($sy);
		$this->load->view('masterlist_by_oe_all', $result);
	}

	function studeGrades()
	{
		$studeno = $this->input->get('studeno');
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		// $result['data']=$this->StudentModel->studeGrades($studeno, $sem, $sy);
		$result['data'] = $this->StudentModel->instructor();
		$this->load->view('stude_grades', $result);
	}

	// function studeGradesView()
	// {
	// 	if ($this->session->userdata('level') === 'Student') {
	// 		$studeno = $this->session->userdata('username');
	// 		$sy = $this->session->userdata('sy');
	// 		$sem = $this->session->userdata('semester');
	// 		$result['data'] = $this->StudentModel->studeGrades($studeno, $sy);
	// 		$result['data1'] = $this->SettingsModel->getSchoolInfo();

	// 		$this->load->view('stude_grades_view', $result);
	// 	} else {
	// 		$studeno = $this->input->get('studeno');
	// 		$sy = $this->session->userdata('sy');
	// 		$sem = $this->session->userdata('semester');
	// 		$result['data'] = $this->StudentModel->studeGrades($studeno, $sem, $sy);
	// 		$result['data1'] = $this->SettingsModel->getSchoolInfo();
	// 		$this->load->view('stude_grades_view', $result);
	// 	}
	// }

	public function studeGradesView()
	{
		if ($this->session->userdata('level') === 'Student') {
			$studeno = $this->session->userdata('username');
			$sy = $this->input->post('sy') ?? $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');

			$result['data'] = $this->StudentModel->studeGrades($studeno, $sy);
			$result['school_years'] = $this->StudentModel->getStudentSchoolYears($studeno);
			$result['selected_sy'] = $sy;
			$result['data1'] = $this->SettingsModel->getSchoolInfo();

			$this->load->view('stude_grades_view', $result);
		} else {
			// Admin or other role logic (optional update if needed)
			$studeno = $this->input->get('studeno');
			$sy = $this->input->post('sy') ?? $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');

			$result['data'] = $this->StudentModel->studeGrades($studeno, $sy);
			$result['school_years'] = $this->StudentModel->getStudentSchoolYears($studeno);
			$result['selected_sy'] = $sy;
			$result['data1'] = $this->SettingsModel->getSchoolInfo();

			$this->load->view('stude_grades_view', $result);
		}
	}

	public function COR()
	{
		if ($this->session->userdata('level') === 'Student') {
			$studeno = $this->session->userdata('username');
			$sy = $this->input->post('sy') ?? $this->session->userdata('sy');
			$result['school_years'] = $this->StudentModel->getRegisteredSchoolYears($studeno);
			$result['selected_sy'] = $sy;
			$result['data'] = $this->StudentModel->studeCOR($studeno, $sy);
			$this->load->view('stude_cor', $result);
		} else {
			$studeno = $this->input->get('studeno');
			$sy = $this->input->post('sy') ?? $this->session->userdata('sy');
			$result['school_years'] = $this->StudentModel->getRegisteredSchoolYears($studeno);
			$result['selected_sy'] = $sy;
			$result['data'] = $this->StudentModel->studeCOR($studeno, $sy);
			$this->load->view('stude_cor', $result);
		}
	}


	public function slotsMonitoring()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['data'] = $this->StudentModel->slotsMonitoring($sy);
		$this->load->view('registrar_slots_monitoring', $result);
	}

	public function subjectMasterlist()
	{
		$subjectcode = $this->input->get('subjectcode');
		$section = $this->input->get('section');
		$sy = $this->session->userdata('sy');
		// $sem = $this->session->userdata('semester');
		$result['data'] = $this->StudentModel->subjectMasterlist($sy, $subjectcode, $section);
		$this->load->view('registrar_subject_masterlist', $result);
	}

	public function crossEnrollees()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['data'] = $this->StudentModel->crossEnrollees($sem, $sy);
		$this->load->view('registrar_cross_enrollees', $result);
	}

	public function fteRecords()
	{
		$course = $this->input->get('course');
		$yearlevel = $this->input->get('yearlevel');
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['course'] = $this->StudentModel->getCourse();
		$result['data'] = $this->StudentModel->fteRecords($sem, $sy, $course, $yearlevel);
		$this->load->view('registrar_fte_records', $result);
	}

	public function subregistration()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['data'] = $this->StudentModel->slotsMonitoring($sy);
		$this->load->view('registrar_subjects', $result);
	}

	public function grades()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['data'] = $this->StudentModel->grades($sy);
		$this->load->view('registrar_grades', $result);
	}

	// public function gradeSheets()
	// {
	// 	$SubjectCode = $this->input->get('SubjectCode');
	// 	$Description = $this->input->get('Description');
	// 	//$Instructor = $this->input->get('Instructor'); 
	// 	$Section = $this->input->get('Section');
	// 	$sy = $this->session->userdata('sy');
	// 	$sem = $this->session->userdata('semester');
	// 	$result['data'] = $this->StudentModel->gradeSheets($sy, $SubjectCode, $Description, $Section);
	// 	$this->load->view('registrar_grades_sheets', $result);
	// }


	// public function grades_sheets_pv()
	// {
	// 	$result['data'] = "Grading Sheets";
	// 	$result['grade'] = $this->Common->one_cond_row('grades', 'gradeID', $this->uri->segment(3));
	// 	$result['so'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
	// 	$this->load->view('registrar_grading_sheet', $result);
	// }

	// public function grades_sheets_all()
	// {
	// 	$result['data'] = "Grading Sheets";
	// 	$result['grade'] = $this->Common->one_cond_row('grades', 'gradeID', $this->uri->segment(3));
	// 	$result['so'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
	// 	$this->load->view('registrar_grading_sheet_all', $result);
	// }

	// public function consol()
	// {
	//     $gl      = $this->input->post('grade_level');
	//     $grading = $this->input->post('grading');
	//     $section = $this->input->post('section');
	//     $ver     = $this->input->post('version');
	//     $sy      = (string) $this->session->userdata('sy');

	//     // SHS controls (no semester)
	//     $strand = (string) $this->input->post('strand');
	//     $is_shs = in_array((string)$gl, ['Grade 11','Grade 12'], true);

	//     $result['ver']     = $ver;
	//     $result['gl']      = $gl;
	//     $result['sec']     = $section;
	//     $result['strand']  = $strand;
	//     $result['is_shs']  = $is_shs;

	//     $result['data'] = "Grading Sheets";

	//     // SUBJECT LIST
	//     if ($is_shs && $strand) {
	//         // SHS subjects by YearLevel + SY + Strand (no Sem)
	//         $result['sub'] = $this->db->select('SubjectCode, Description')
	//             ->from('grades')
	//             ->where([
	//                 'YearLevel' => $gl,
	//                 'SY'        => $sy,
	//                 'strand'    => $strand,
	//             ])
	//             ->group_by(['SubjectCode','Description'])
	//             ->order_by('SubjectCode', 'ASC')
	//             ->get()->result();
	//     } else {
	//         // Default (non-SHS or no strand yet)
	//         $result['sub'] = $this->Common->two_cond_gb(
	//             'grades', 'YearLevel', $gl, 'SY', $sy, 'SubjectCode', 'SubjectCode', 'asc'
	//         );
	//     }

	//     // pick the list of students according to version
	//     if ((int)$ver === 1) {
	//         $result['grade'] = $this->Common->cons($gl, $section, $sy);     // by Sex then LastName
	//     } elseif ((int)$ver === 3) {
	//         $result['grade'] = $this->Common->consv3($gl, $section, $sy);   // by LastName
	//     } else {
	//         $result['grade'] = $this->Common->consv2($gl, $section, $sy);   // by Average
	//     }

	//     // OPTIONAL: For SHS + strand, keep only students with at least one matching grade row
	//     if ($is_shs && $strand && !empty($result['grade'])) {
	//         $filtered = [];
	//         foreach ($result['grade'] as $row) {
	//             $exists = $this->db->select('gradeID')
	//                 ->from('grades')
	//                 ->where([
	//                     'StudentNumber' => $row->StudentNumber,
	//                     'YearLevel'     => $gl,
	//                     'SY'            => $sy,
	//                     'strand'        => $strand,
	//                 ])
	//                 ->limit(1)->get()->row();
	//             if ($exists) $filtered[] = $row;
	//         }
	//         $result['grade'] = $filtered;
	//     }

	//     $result['so'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);

	//     // dropdowns
	//     $result['section'] = $this->Common->one_cond_gb('grades', 'SY', $sy, 'Section', 'Section', 'ASC');
	//     $result['grade_level'] = $this->Common->one_cond_gb('grades', 'SY', $sy, 'YearLevel', 'YearLevel', 'ASC');

	//     // Strand options (post-submit render; AJAX also used pre-submit)
	//     if ($is_shs) {
	//         $result['strand_options'] = $this->db->select('strand')
	//             ->from('grades')
	//             ->where(['SY' => $sy, 'YearLevel' => $gl])
	//             ->where("strand <> ''")
	//             ->group_by('strand')
	//             ->order_by('strand', 'ASC')
	//             ->get()->result();
	//     } else {
	//         $result['strand_options'] = [];
	//     }

	//     $this->load->view('consol_report', $result);
	// }



















	public function consol()
	{
		$gl      = $this->input->post('grade_level');
		$grading = $this->input->post('grading');
		$section = $this->input->post('section');
		$ver     = $this->input->post('version');
		$sy      = (string) $this->session->userdata('sy');

		// SHS controls (no semester)
		$strand = (string) $this->input->post('strand');
		$is_shs = in_array((string)$gl, ['Grade 11', 'Grade 12'], true);

		$result['ver']     = $ver;
		$result['gl']      = $gl;
		$result['sec']     = $section;
		$result['strand']  = $strand;
		$result['is_shs']  = $is_shs;

		$result['data'] = "Grading Sheets";

		// SUBJECT LIST
		if ($is_shs && $strand) {
			$result['sub'] = $this->db->select('SubjectCode, Description')
				->from('grades')
				->where([
					'YearLevel' => $gl,
					'SY'        => $sy,
					'strand'    => $strand,
				])
				->group_by(['SubjectCode', 'Description'])
				->order_by('SubjectCode', 'ASC')
				->get()->result();
		} else {
			$result['sub'] = $this->Common->two_cond_gb(
				'grades',
				'YearLevel',
				$gl,
				'SY',
				$sy,
				'SubjectCode',
				'SubjectCode',
				'asc'
			);
		}

		// pick the list of students according to version
		if ((int)$ver === 1) {
			$result['grade'] = $this->Common->cons($gl, $section, $sy);     // by Sex then LastName
		} elseif ((int)$ver === 3) {
			$result['grade'] = $this->Common->consv3($gl, $section, $sy);   // by LastName
		} else {
			$result['grade'] = $this->Common->consv2($gl, $section, $sy);   // by Average
		}

		// OPTIONAL: For SHS + strand, keep only students with at least one matching grade row
		if ($is_shs && $strand && !empty($result['grade'])) {
			$filtered = [];
			foreach ($result['grade'] as $row) {
				$exists = $this->db->select('gradeID')
					->from('grades')
					->where([
						'StudentNumber' => $row->StudentNumber,
						'YearLevel'     => $gl,
						'SY'            => $sy,
						'strand'        => $strand,
					])
					->limit(1)->get()->row();
				if ($exists) $filtered[] = $row;
			}
			$result['grade'] = $filtered;
		}

		$result['so'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);

		// dropdowns
		$result['section'] = $this->Common->one_cond_gb('grades', 'SY', $sy, 'Section', 'Section', 'ASC');
		$result['grade_level'] = $this->Common->one_cond_gb('grades', 'SY', $sy, 'YearLevel', 'YearLevel', 'ASC');

		// Strand options (SHS) — source from semsubjects
		if ($is_shs) {
			$this->db->select('strand')
				->from('semsubjects')
				->where(['SY' => $sy, 'YearLevel' => $gl])
				->where("strand <> ''");

			// optional: if you want to scope strands to the chosen section too, uncomment:
			// if (!empty($section)) $this->db->where('Section', $section);

			$result['strand_options'] = $this->db
				->group_by('strand')
				->order_by('strand', 'ASC')
				->get()->result();
		} else {
			$result['strand_options'] = [];
		}


		// ===== NEW: per-subject locks (no changes to your existing lock endpoints) =====
		$result['locks_map']    = [];
		$result['sub_desc_map'] = [];

		// Load once; harmless if already autoloaded
		$this->load->model('GradesLockModel');

		if (!empty($result['sub'])) {
			foreach ($result['sub'] as $s) {
				$code = $s->SubjectCode ?? '';
				if ($code === '') continue;

				// Prefer canonical Description from registration (SY + Section + SubjectCode)
				$desc = '';
				$reg  = $this->Common->three_cond_row('registration', 'SY', $sy, 'Section', $section, 'SubjectCode', $code);
				if ($reg && !empty($reg->Description)) {
					$desc = (string) $reg->Description;
				} elseif (!empty($s->Description)) {
					$desc = (string) $s->Description;
				}

				$result['sub_desc_map'][$code] = $desc;

				// Create/Fetch lock row for this subject in this class context
				$result['locks_map'][$code] = $this->GradesLockModel->get_or_create(
					$sy,
					$code,
					$desc,
					$section,
					$gl,
					$this->session->userdata('username')
				);
			}
		}
		// ==============================================================================

		$this->load->view('consol_report', $result);
	}




	public function strandsByYearLevel()
	{
		if (!$this->input->is_ajax_request()) show_404();

		$sy        = (string) $this->session->userdata('sy');
		$yearLevel = (string) $this->input->post('yearLevel'); // e.g., "Grade 11"
		$section   = (string) $this->input->post('section');   // optional

		$this->db->select('strand')
			->from('semsubjects')
			->where('SY', $sy)
			->where('YearLevel', $yearLevel)
			->where("strand <> ''");
		// If you want strands narrowed by the selected Section too, keep this line:
		if ($section !== '') $this->db->where('Section', $section);

		$rows = $this->db->group_by('strand')->order_by('strand', 'ASC')->get()->result();

		$strands = [];
		foreach ($rows as $r) $strands[] = (string)$r->strand;

		// Hand back a fresh CSRF token (CI often rotates)
		$csrf = [
			$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
		];

		$this->output->set_content_type('application/json')
			->set_output(json_encode(['ok' => true, 'strands' => $strands, 'csrf' => $csrf]));
	}





	public function get_strands()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		$gl = (string) $this->input->post('grade_level');
		$sy = (string) $this->session->userdata('sy');

		if ($gl === '' || $sy === '') {
			$this->output->set_content_type('application/json')
				->set_output(json_encode([]));
			return;
		}

		$rows = $this->db->select('strand')
			->from('grades')
			->where(['SY' => $sy, 'YearLevel' => $gl])
			->where("strand <> ''")
			->group_by('strand')
			->order_by('strand', 'ASC')
			->get()->result_array();

		$this->output->set_content_type('application/json')
			->set_output(json_encode($rows));
	}




	public function viewing_grades()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['data'] = $this->SettingsModel->grade_view($sy);
		$this->load->view('viewing_grades', $result);
	}


	// public function encodeGrades()
	// {
	// 	$filters = [
	// 		'SubjectCode' => $this->input->get('SubjectCode'),
	// 		'Description' => urldecode($this->input->get('Description')),
	// 		'Instructor' => urldecode($this->input->get('Instructor')),
	// 		'Section' => $this->input->get('Section'),
	// 		'SY' => $this->session->userdata('sy')
	// 	];

	// 	$this->load->model('StudentModel');

	// 	$data['students'] = $this->StudentModel->get_students_by_registration($filters);
	// 	$data['grades'] = $this->StudentModel->get_existing_grades($filters);
	// 	$data['filters'] = $filters;

	// 	$this->load->view('registrar_grades_add', $data);
	// }




	public function add_grades()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');

		$result['stude'] = $this->SettingsModel->get_Yearlevels();
		$result['courses'] = $this->SettingsModel->get_distinct('Course');
		$result['yearlevels'] = $this->SettingsModel->get_distinct('YearLevel');
		$result['sections'] = $this->SettingsModel->get_distinct('Section');
		$result['advisers'] = $this->SettingsModel->get_distinct('Adviser');
		$result['subjects'] = $this->SettingsModel->get_subjects1();

		$this->load->view('registrar_grades_add', $result);
	}

	public function fetch_students()
	{
		$filters = $this->input->post();
		$this->load->model('StudentModel');

		// Fetch filtered students and their grades
		$students = $this->StudentModel->get_filtered_students($filters);
		$grades = $this->StudentModel->get_existing_grades($filters);

		// Start creating the table
		$data = '';
		if ($students) {
			$data .= '<table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>PGrade</th>
                    <th>MGrade</th>
                    <th>PFinalGrade</th>
                    <th>FGrade</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>';

			foreach ($students as $student) {
				$grade = isset($grades[$student->StudentNumber]) ? $grades[$student->StudentNumber] : null;
				$data .= '<tr data-student="' . $student->StudentNumber . '">
                <td>' . $student->FirstName . ' ' . $student->MiddleName . ' ' . $student->LastName . '</td>
                <td><input type="text" class="form-control PGrade" value="' . ($grade ? $grade->PGrade : '') . '" /></td>
                <td><input type="text" class="form-control MGrade" value="' . ($grade ? $grade->MGrade : '') . '" /></td>
                <td><input type="text" class="form-control PFinalGrade" value="' . ($grade ? $grade->PFinalGrade : '') . '" /></td>
                <td><input type="text" class="form-control FGrade" value="' . ($grade ? $grade->FGrade : '') . '" /></td>
                <td><input type="text" class="form-control Average" value="' . ($grade ? $grade->Average : '') . '" /></td>
            </tr>';
			}

			$data .= '</tbody></table>';
		} else {
			$data = 'No students found for the selected filters.';
		}

		echo $data;
	}

	public function save_grades()
	{
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		// Get JSON input from AJAX
		$json = file_get_contents('php://input');
		$data = json_decode($json, true);

		if (!isset($data['grades']) || !is_array($data['grades'])) {
			echo json_encode(['status' => 'error', 'message' => 'No valid grades data received']);
			return;
		}

		$grades = $data['grades'];
		$errors = [];

		foreach ($grades as $g) {
			// Basic validation
			if (empty($g['StudentNumber']) || empty($g['SubjectCode']) || empty($g['SY'])) {
				$errors[] = "Missing key fields for student: " . json_encode($g);
				continue;
			}

			// WHERE clause to check existing record
			$where = [
				'StudentNumber' => $g['StudentNumber'],
				'SubjectCode' => $g['SubjectCode'],
				'Section' => $g['Section'],
				'Instructor' => $g['Instructor'],
				'SY' => $g['SY']
			];

			// Data to insert/update
			$gradeData = [
				'StudentNumber' => $g['StudentNumber'],
				'SubjectCode' => $g['SubjectCode'],
				'Section' => $g['Section'],
				'Instructor' => $g['Instructor'],
				'SY' => $g['SY'],
				'PGrade' => $g['PGrade'],
				'MGrade' => $g['MGrade'],
				'PFinalGrade' => $g['PFinalGrade'],
				'FGrade' => $g['FGrade'],
				'Average' => $g['Average']
			];

			// Check if it exists
			$existing = $this->db->get_where('grades', $where)->row();

			if ($existing) {
				$this->db->where($where);
				if (!$this->db->update('grades', $gradeData)) {
					$errors[] = "Update failed for " . $g['StudentNumber'];
				}
			} else {
				if (!$this->db->insert('grades', $gradeData)) {
					$errors[] = "Insert failed for " . $g['StudentNumber'];
				}
			}
		}

		if (!empty($errors)) {
			echo json_encode(['status' => 'error', 'message' => $errors]);
		} else {
			echo json_encode(['status' => 'success']);
		}
	}




	// public function gradeSheets()
	// {
	// 	$SubjectCode = $this->input->get('SubjectCode');
	// 	// $Description = $this->input->get('Description');
	// 	$Section = $this->input->get('Section');
	// 	$sy = $this->session->userdata('sy');
	// 	$sem = $this->session->userdata('semester');

	// 	// Load data
	// 	$result['data'] = $this->StudentModel->gradeSheets($sy, $SubjectCode, $Section);

	// 	// Fetch grade display setting (assume you have a function in your model for this)
	// 	$result['gradeDisplay'] = $this->StudentModel->getGradeDisplay(); // Returns 'Numeric' or 'Letter'

	// 	$this->load->view('registrar_grades_sheets', $result);
	// }



	public function gradeSheets()
	{
		// Session + inputs
		$sy      = (string) $this->session->userdata('sy');
		$section = $this->input->get('Section', true);

		// Raw GET (may be truncated if & not encoded)
		$subjectcode = $this->input->get('SubjectCode', true);
		$Description = $this->input->get('Description', true);
		if ($Description === null || $Description === '') {
			$Description = $this->input->get('description', true);
		}

		// Try to find the canonical registration row:
		// 1) first by the raw SubjectCode (even if truncated),
		// 2) else by Description (which is usually safe),
		// 3) else last resort: take any row for SY+Section and pick its code/desc.
		$g = null;
		if ($subjectcode) {
			$g = $this->Common->three_cond_row('registration', 'SY', $sy, 'Section', $section, 'SubjectCode', $subjectcode);
		}
		if (!$g && $Description) {
			$g = $this->Common->three_cond_row('registration', 'SY', $sy, 'Section', $section, 'Description', $Description);
		}
		if (!$g) {
			$g = $this->db->where('SY', $sy)->where('Section', $section)->limit(1)->get('registration')->row();
		}

		// Canonicalized values (prefer the DB row if found)
		$resolvedSubjectCode = $g->SubjectCode ?? $subjectcode ?? '';
		$resolvedDescription = $g->Description ?? $Description ?? '';
		$resolvedYearLevel   = $g->YearLevel   ?? '';

		// Now fetch using canonical values
		$result['data']         = $this->StudentModel->gradeSheets($sy, $resolvedSubjectCode, $section);
		$result['gradeDisplay'] = $this->StudentModel->getGradeDisplay();

		// Locks: pass canonical values so per-subject locks match exactly
		$result['locks'] = $this->GradesLockModel->get_or_create(
			$sy,
			$resolvedSubjectCode,
			$resolvedDescription,
			$section,
			$resolvedYearLevel,
			$this->session->userdata('username')
		);

		// Expose to the view (optional but handy to print header/info)
		$result['resolvedSubjectCode'] = $resolvedSubjectCode;
		$result['resolvedDescription'] = $resolvedDescription;
		$result['resolvedYearLevel']   = $resolvedYearLevel;

		$this->load->view('registrar_grades_sheets', $result);
	}


	public function toggleLock()
	{
		if ($this->input->method() !== 'post') {
			show_error('Invalid request method', 405);
		}

		$sy        = $this->session->userdata('sy');
		$code      = $this->input->post('SubjectCode', true);
		$desc      = $this->input->post('Description', true);
		$section   = $this->input->post('Section', true);
		$yearLevel = $this->input->post('YearLevel', true);
		$period    = $this->input->post('period', true);
		$action    = $this->input->post('action', true);
		$username  = $this->session->userdata('username') ?? 'system';

		$allowed = ['prelim', 'midterm', 'prefinal', 'final', 'all'];
		if (!in_array($period, $allowed, true)) {
			show_error('Bad period', 400);
		}

		$lock = ($action === 'lock') ? 1 : 0;

		$row = $this->GradesLockModel->set_lock(
			$sy,
			$code,
			$desc,
			$section,
			$yearLevel,
			$period,
			$lock,
			$username
		);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(['ok' => true, 'locks' => $row]));
	}



	// Controller: e.g., Registrar.php or Masterlist.php
	public function grades_sheets_pv()
	{
		$gradeID = $this->uri->segment(3);
		$period = $this->input->get('period') ?? '1st';

		$grade = $this->Common->one_cond_row('grades', 'gradeID', $gradeID);
		$so = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);

		$gradeDisplay = $so->gradeDisplay ?? 'Numeric';

		// FEMALE students
		$fs = $this->Common->two_join_four_cond(
			'grades',
			'studeprofile',
			'a.StudentNumber, b.StudentNumber, a.SY, a.Sem, b.FirstName, b.MiddleName, b.LastName,
         a.Instructor, a.SubjectCode, a.Description, a.Section, a.adviser, a.gradeID,
         a.PGrade, a.MGrade, a.PFinalGrade, a.FGrade, a.Average,
         a.firstStat, a.secondStat, a.thirdStat, a.fourthStat, a.YearLevel, b.Sex, b.LRN',
			'a.StudentNumber = b.StudentNumber',
			'SY',
			$grade->SY,
			'Section',
			$grade->Section,
			'SubjectCode',
			$grade->SubjectCode,
			'Sex',
			'Female',
			'LastName',
			'ASC'
		);

		// MALE students
		$ms = $this->Common->two_join_four_cond(
			'grades',
			'studeprofile',
			'a.StudentNumber, b.StudentNumber, a.SY, a.Sem, b.FirstName, b.MiddleName, b.LastName,
         a.Instructor, a.SubjectCode, a.Description, a.Section, a.adviser, a.gradeID,
         a.PGrade, a.MGrade, a.PFinalGrade, a.FGrade, a.Average,
         a.firstStat, a.secondStat, a.thirdStat, a.fourthStat, a.YearLevel, b.Sex, b.LRN',
			'a.StudentNumber = b.StudentNumber',
			'SY',
			$grade->SY,
			'Section',
			$grade->Section,
			'SubjectCode',
			$grade->SubjectCode,
			'Sex',
			'Male',
			'LastName',
			'ASC'
		);

		$result = [
			'data' => 'Grading Sheets',
			'grade' => $grade,
			'so' => $so,
			'gradeDisplay' => $gradeDisplay,
			'period' => $period,
			'fs' => $fs,
			'ms' => $ms,
		];

		$this->load->view('registrar_grading_sheet', $result);
	}



	// public function grades_sheets_pv()
	// {
	// 	$result['data'] = "Grading Sheets";
	// 	$result['grade'] = $this->Common->one_cond_row('grades', 'gradeID', $this->uri->segment(3));
	// 	$result['so'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
	// 	$result['gradeDisplay'] = $result['so']->gradeDisplay ?? 'Numeric'; // pass gradeDisplay directly
	// 	$this->load->view('registrar_grading_sheet', $result);
	// }


	public function grades_sheets_all()
	{
		$result['data'] = "Grading Sheets";
		$result['grade'] = $this->Common->one_cond_row('grades', 'gradeID', $this->uri->segment(3));
		$result['so'] = $this->Common->one_cond_row('srms_settings_o', 'settingsID', 1);
		$result['gradeDisplay'] = $result['so']->gradeDisplay ?? 'Numeric'; // pass gradeDisplay directly
		$this->load->view('registrar_grading_sheet_all', $result);
	}


	// 	public function advisoryAttendance()
	// {
	//     date_default_timezone_set('Asia/Manila');
	//     $this->load->model('StudentModel');

	//     $adviserId = $this->session->userdata('username');
	//     $sy = $this->session->userdata('sy');
	//     $period = date('A'); // AM or PM
	//     $today = date('Y-m-d');

	//     $data['students'] = $this->StudentModel->getAdvisoryClass($adviserId, $sy);
	//     $data['existing'] = $this->StudentModel->getTodayAttendance($adviserId, $sy, $period, $today);

	//     if ($this->input->post('submit_attendance')) {
	//         $attendanceInput = $this->input->post('attendance');
	//         $remarksInput = $this->input->post('remarks');

	//         $attendanceData = [];

	//         foreach ($attendanceInput as $studentNumber => $status) {
	//             if (empty($studentNumber) || empty($status)) continue;

	//             $remarks = isset($remarksInput[$studentNumber]) ? trim($remarksInput[$studentNumber]) : null;
	//             $attendanceValue = ($status === 'Present') ? 1 : 0;

	//             $attendanceData[] = [
	//                 'StudentNumber'   => $studentNumber,
	//                 'SY'              => $sy,
	//                 'Period'          => $period,
	//                 'attendance'      => $attendanceValue,
	//                 'remarks'         => ($status === 'Excused') ? $remarks : '',
	//                 'date_recorded'   => $today,
	//                 'IDNumber'        => $adviserId
	//             ];
	//         }

	//         if (!empty($attendanceData)) {
	//             $result = $this->StudentModel->saveAttendance($attendanceData);

	//             if ($result) {
	//                 $this->session->set_flashdata('success', 'Attendance saved successfully for ' . $period);
	//             } else {
	//                 $this->session->set_flashdata('error', 'Database insert failed. Please check logs.');
	//             }
	//         } else {
	//             $this->session->set_flashdata('error', 'No valid attendance data submitted.');
	//         }

	//         redirect('Masterlist/advisoryAttendance');
	//     }

	//     $this->load->view('advisory_attendance', $data);
	// }



	public function attendanceReport()
	{
		$this->load->model('StudentModel');

		$adviserId = $this->session->userdata('username');
		$sy = $this->session->userdata('sy');

		$data['sy'] = $sy;
		$data['students'] = $this->StudentModel->getAdvisoryClass($adviserId, $sy);
		$data['attendance'] = $this->StudentModel->getAttendanceGrouped($adviserId, $sy); // actual dates grouped per week

		$this->load->view('attendance_report_view', $data);
	}


	// public function sf2_report()
	// {
	//     $this->load->model('StudentModel');

	//     $adviserId = $this->session->userdata('username'); // Assuming this is the IDNumber
	//     $sy = $this->session->userdata('sy');

	//     $students = $this->StudentModel->getAdvisoryClass($adviserId, $sy);
	//     $attendance = $this->StudentModel->getAttendanceGrouped($adviserId, $sy);
	//     $schoolinfo = $this->StudentModel->getSchoolSettings();
	//     $sectioninfo = $this->StudentModel->getSectionByAdviser($adviserId, $sy);

	//     // ✅ Get teacher name from staff table
	//     $teacher = $this->StudentModel->getByID($adviserId);
	//     $teacherName = $teacher 
	//         ? $teacher->FirstName . ' ' . $teacher->MiddleName . ' ' . $teacher->LastName . ' ' . $teacher->NameExtn 
	//         : '';

	//     $data = [
	//         'sy' => $sy,
	//         'students' => $students,
	//         'attendance' => $attendance,
	//         'schoolinfo' => $schoolinfo,
	//         'sectioninfo' => $sectioninfo,
	//         'teacherName' => trim($teacherName)
	//     ];

	//     $this->load->view('sf2_print', $data);
	// }




	// public function advisoryAttendance()
	// {
	// 	date_default_timezone_set('Asia/Manila');
	// 	$this->load->model('StudentModel');

	// 	$adviserId = $this->session->userdata('username');
	// 	$sy = $this->session->userdata('sy');
	// 	$period = date('A'); // AM or PM
	// 	$today = date('Y-m-d');

	// 	$data['students'] = $this->StudentModel->getAdvisoryClass($adviserId, $sy);
	// 	$data['existing'] = $this->StudentModel->getTodayAttendance($adviserId, $sy, $period, $today);

	// 	if ($this->input->post('submit_attendance')) {
	// 		$attendanceInput = $this->input->post('attendance');
	// 		$remarksInput = $this->input->post('remarks');

	// 		$attendanceData = [];

	// 		foreach ($attendanceInput as $studentNumber => $status) {
	// 			if (empty($studentNumber) || empty($status)) continue;

	// 			$remarks = isset($remarksInput[$studentNumber]) ? trim($remarksInput[$studentNumber]) : null;
	// 			$attendanceValue = ($status === 'Present') ? 1 : 0;

	// 			$attendanceData[] = [
	// 				'StudentNumber'   => $studentNumber,
	// 				'SY'              => $sy,
	// 				'Period'          => $period,
	// 				'attendance'      => $attendanceValue,
	// 				'remarks'         => ($status === 'Excused') ? $remarks : '',
	// 				'date_recorded'   => $today,
	// 				'IDNumber'        => $adviserId
	// 			];
	// 		}

	// 		if (!empty($attendanceData)) {
	// 			$result = $this->StudentModel->saveAttendance($attendanceData);

	// 			if ($result) {
	// 				$this->session->set_flashdata('success', 'Attendance saved successfully for ' . $period);
	// 			} else {
	// 				$this->session->set_flashdata('error', 'Database insert failed. Please check logs.');
	// 			}
	// 		} else {
	// 			$this->session->set_flashdata('error', 'No valid attendance data submitted.');
	// 		}

	// 		redirect('Masterlist/advisoryAttendance');
	// 	}

	// 	$this->load->view('advisory_attendance', $data);
	// }


	public function advisoryAttendance()
	{
		date_default_timezone_set('Asia/Manila');
		$this->load->model('StudentModel');

		$adviserId = $this->session->userdata('username');
		$sy = $this->session->userdata('sy');

		$from = $this->input->post('from') ?? date('Y-m-d');
		$to = $this->input->post('to') ?? date('Y-m-d');

		// Get all dates in range
		$range = [];
		$current = strtotime($from);
		$end = strtotime($to);
		while ($current <= $end) {
			$range[] = date('Y-m-d', $current);
			$current = strtotime('+1 day', $current);
		}

		$data['students'] = $this->StudentModel->getAdvisoryClass($adviserId, $sy);
		$data['dates'] = $range;

		// Fetch existing attendance for both AM and PM
		$data['existing'] = [];
		foreach ($range as $date) {
			foreach (['AM', 'PM'] as $period) {
				$data['existing'][$date][$period] = $this->StudentModel->getTodayAttendance($adviserId, $sy, $period, $date);
			}
		}

		if ($this->input->post('submit_attendance')) {
			$attendanceInput = $this->input->post('attendance'); // [date][period][StudentNumber] => status
			$remarksInput = $this->input->post('remarks');       // [date][period][StudentNumber] => remarks

			$attendanceData = [];

			foreach ($attendanceInput as $date => $periods) {
				foreach ($periods as $period => $students) {
					foreach ($students as $studentNumber => $status) {
						if (empty($studentNumber) || empty($status)) continue;

						$remarks = isset($remarksInput[$date][$period][$studentNumber]) ? trim($remarksInput[$date][$period][$studentNumber]) : null;
						$attendanceValue = ($status === 'Present') ? 1 : 0;

						$attendanceData[] = [
							'StudentNumber'   => $studentNumber,
							'SY'              => $sy,
							'Period'          => $period,
							'attendance'      => $attendanceValue,
							'remarks'         => ($status === 'Excused') ? $remarks : '',
							'date_recorded'   => $date,
							'IDNumber'        => $adviserId
						];
					}
				}
			}

			if (!empty($attendanceData)) {
				$this->StudentModel->saveAttendance($attendanceData);
				$this->session->set_flashdata('success', 'Attendance saved successfully for selected dates and periods.');
			} else {
				$this->session->set_flashdata('error', 'No valid attendance data submitted.');
			}

			redirect('Masterlist/advisoryAttendance');
		}

		$this->load->view('advisory_attendance1', $data);
	}







	// public function sf2_report()
	// {
	//     $this->load->model('StudentModel');

	//     $adviserId = $this->session->userdata('username'); // Assuming this is the IDNumber
	//     $sy = $this->session->userdata('sy');

	//     $students = $this->StudentModel->getAdvisoryClass($adviserId, $sy);
	//     $attendance = $this->StudentModel->getAttendanceGrouped($adviserId, $sy);
	//     $schoolinfo = $this->StudentModel->getSchoolSettings();
	//     $sectioninfo = $this->StudentModel->getSectionByAdviser($adviserId, $sy);

	//     // ✅ Get teacher name from staff table
	//     $teacher = $this->StudentModel->getByID($adviserId);
	//     $teacherName = $teacher 
	//         ? $teacher->FirstName . ' ' . $teacher->MiddleName . ' ' . $teacher->LastName . ' ' . $teacher->NameExtn 
	//         : '';

	//     $data = [
	//         'sy' => $sy,
	//         'students' => $students,
	//         'attendance' => $attendance,
	//         'schoolinfo' => $schoolinfo,
	//         'sectioninfo' => $sectioninfo,
	//         'teacherName' => trim($teacherName)
	//     ];

	//     $this->load->view('sf2_print', $data);
	// }



	public function sf2_report()
	{
		$this->load->model('StudentModel');

		$adviserId = $this->session->userdata('username');
		$sy = $this->session->userdata('sy');

		$month = $this->input->get('month');
		$year = $this->input->get('year');

		$students = $this->StudentModel->getAdvisoryClass($adviserId, $sy);
		$attendance = $this->StudentModel->getAttendanceGrouped($adviserId, $sy, $month, $year); // Pass to model
		$schoolinfo = $this->StudentModel->getSchoolSettings();
		$sectioninfo = $this->StudentModel->getSectionByAdviser($adviserId, $sy);

		$teacher = $this->StudentModel->getByID($adviserId);
		$teacherName = $teacher
			? $teacher->FirstName . ' ' . $teacher->MiddleName . ' ' . $teacher->LastName . ' ' . $teacher->NameExtn
			: '';

		$data = [
			'sy' => $sy,
			'students' => $students,
			'attendance' => $attendance,
			'schoolinfo' => $schoolinfo,
			'sectioninfo' => $sectioninfo,
			'teacherName' => trim($teacherName),
			'month' => $month,
			'year' => $year
		];

		$this->load->view('sf2_print', $data);
	}
























	// Add/replace these methods in Masterlist controller

	public function encodeGrades()
	{
		$filters = [
			'SubjectCode' => $this->input->get('SubjectCode'),
			'Description' => urldecode($this->input->get('Description')),
			'Instructor'  => urldecode($this->input->get('Instructor')),
			'Section'     => $this->input->get('Section'),
			'SY'          => $this->session->userdata('sy'),   // ✅ will now be applied
		];

		$this->load->model('StudentModel');

		// Enrolled (no grade yet)
		$data['students'] = $this->StudentModel->get_students_by_registration($filters);
		// Existing grades (joined with studeprofile for names/sex)
		$data['grades']   = $this->StudentModel->get_existing_grades($filters);
		$data['filters']  = $filters;

		// Needed for preschool letter-grade switch
		$data['setting'] = $this->db->get_where('srms_settings_o', ['settingsID' => 1])->row();

		$this->load->view('registrar_grades_add', $data);
	}


	public function saveRegistrarGrades()
	{
		// Expect arrays
		$studentNumbers = (array) $this->input->post('StudentNumber');
		$strandArr      = (array) $this->input->post('strand');
		$sy             = (string) $this->input->post('SY');
		$section        = (string) $this->input->post('section');
		$subjectCode    = (string) $this->input->post('SubjectCode');
		$description    = (string) $this->input->post('description');
		$instructor     = (string) $this->input->post('Instructor');
		$yearLevel      = (string) $this->input->post('YearLevel'); // same for all on insert in your view

		// Period arrays (may be missing depending on progressive mode)
		$PGradeArr      = (array) $this->input->post('PGrade');
		$MGradeArr      = (array) $this->input->post('MGrade');
		$PFinalArr      = (array) $this->input->post('PFinalGrade');
		$FGradeArr      = (array) $this->input->post('FGrade');

		// Letter arrays (preschool mode)
		$lpArr          = (array) $this->input->post('l_p');
		$lmArr          = (array) $this->input->post('l_m');
		$lpfArr         = (array) $this->input->post('l_pf');
		$lfArr          = (array) $this->input->post('l_f');

		$rows = [];
		$count = count($studentNumbers);

		// Helpers
		$num = function ($arr, $i) {
			if (!isset($arr[$i])) return 0;                // default to 0 to avoid NOT NULL
			$v = trim((string)$arr[$i]);
			if ($v === '') return 0;
			return is_numeric($v) ? 0 + $v : 0;
		};
		$let = function ($arr, $i) {
			if (!isset($arr[$i])) return '';
			return trim((string)$arr[$i]);
		};
		$avgOrNull = function ($p, $m, $pf, $f) {
			// only compute when all > 0; else NULL
			if ($p > 0 && $m > 0 && $pf > 0 && $f > 0) {
				return round(($p + $m + $pf + $f) / 4, 2);
			}
			return null;
		};

		for ($i = 0; $i < $count; $i++) {
			$sn = $studentNumbers[$i] ?? '';
			if ($sn === '') continue;

			$p  = $num($PGradeArr, $i);
			$m  = $num($MGradeArr, $i);        // will be 0 when not provided
			$pf = $num($PFinalArr, $i);
			$f  = $num($FGradeArr, $i);

			$lp = $let($lpArr, $i);
			$lm = $let($lmArr, $i);
			$lpf = $let($lpfArr, $i);
			$lf = $let($lfArr, $i);

			$avg = $avgOrNull($p, $m, $pf, $f);

			$rows[] = [
				'StudentNumber' => $sn,
				'YearLevel'     => (string)$yearLevel,
				'strand'        => (string)($strandArr[$i] ?? ''),
				'SubjectCode'   => $subjectCode,
				'Description'   => $description,
				'Section'       => $section,
				'Instructor'    => $instructor,
				'SY'            => $sy,

				// numeric
				'PGrade'        => $p,
				'MGrade'        => $m,
				'PFinalGrade'   => $pf,
				'FGrade'        => $f,
				'Average'       => $avg,   // NULL allowed; if NOT NULL in DB, change to 0

				// letter slots (okay to be empty even if not used)
				'l_p'           => $lp,
				'l_m'           => $lm,
				'l_pf'          => $lpf,
				'l_f'           => $lf,
			];
		}

		if (!empty($rows)) {
			$this->db->insert_batch('grades', $rows);
			$this->session->set_flashdata('success', 'Grades saved.');
		} else {
			$this->session->set_flashdata('danger', 'No rows to save.');
		}

		// redirect back to encoder with same filters
		$q = http_build_query([
			'SubjectCode' => $subjectCode,
			'Description' => $description,
			'Instructor'  => $instructor,
			'Section'     => $section,
		]);
		redirect('Masterlist/encodeGrades?' . $q);
	}

	public function updateRegistrarGrades()
	{
		$gradeIDs       = (array) $this->input->post('gradeID');
		$studentNumbers = (array) $this->input->post('StudentNumber');

		$subjectCode    = (string) $this->input->post('SubjectCode');
		$description    = (string) $this->input->post('description');
		$section        = (string) $this->input->post('section');
		$sy             = (string) $this->input->post('SY');

		$PGradeArr      = (array) $this->input->post('PGrade');
		$MGradeArr      = (array) $this->input->post('MGrade');
		$PFinalArr      = (array) $this->input->post('PFinalGrade');
		$FGradeArr      = (array) $this->input->post('FGrade');

		$lpArr          = (array) $this->input->post('l_p');
		$lmArr          = (array) $this->input->post('l_m');
		$lpfArr         = (array) $this->input->post('l_pf');
		$lfArr          = (array) $this->input->post('l_f');

		$num = function ($arr, $i) {
			if (!isset($arr[$i])) return 0;      // default to 0 to avoid NOT NULL
			$v = trim((string)$arr[$i]);
			if ($v === '') return 0;
			return is_numeric($v) ? 0 + $v : 0;
		};
		$let = function ($arr, $i) {
			if (!isset($arr[$i])) return '';
			return trim((string)$arr[$i]);
		};
		$avgOrNull = function ($p, $m, $pf, $f) {
			if ($p > 0 && $m > 0 && $pf > 0 && $f > 0) {
				return round(($p + $m + $pf + $f) / 4, 2);
			}
			return null;
		};

		$count = count($gradeIDs);
		$updates = [];

		for ($i = 0; $i < $count; $i++) {
			$gid = $gradeIDs[$i] ?? '';
			if ($gid === '') continue;

			$p  = $num($PGradeArr, $i);
			$m  = $num($MGradeArr, $i);
			$pf = $num($PFinalArr, $i);
			$f  = $num($FGradeArr, $i);

			$lp = $let($lpArr, $i);
			$lm = $let($lmArr, $i);
			$lpf = $let($lpfArr, $i);
			$lf = $let($lfArr, $i);

			$avg = $avgOrNull($p, $m, $pf, $f);

			$updates[] = [
				'gradeID'      => $gid,
				'PGrade'       => $p,
				'MGrade'       => $m,
				'PFinalGrade'  => $pf,
				'FGrade'       => $f,
				'Average'      => $avg,
				'l_p'          => $lp,
				'l_m'          => $lm,
				'l_pf'         => $lpf,
				'l_f'          => $lf,
			];
		}

		if (!empty($updates)) {
			$this->db->update_batch('grades', $updates, 'gradeID');
			$this->session->set_flashdata('success', 'Grades updated.');
		} else {
			$this->session->set_flashdata('danger', 'No rows to update.');
		}

		// redirect back to encoder with same filters
		$q = http_build_query([
			'SubjectCode' => $subjectCode,
			'Description' => $description,
			'Instructor'  => $this->input->get_post('Instructor') ?: '', // optional
			'Section'     => $section,
		]);
		redirect('Masterlist/encodeGrades?' . $q);
	}
}
