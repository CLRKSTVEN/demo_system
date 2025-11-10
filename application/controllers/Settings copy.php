<?php
class Settings extends CI_Controller
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
		$this->load->model('Login_model');
		$this->load->library('user_agent');

		if ($this->session->userdata('logged_in') !== TRUE) {
			redirect('login');
		}
	}


	public function view_logs()
	{
		$this->load->model('Login_model');
		$data['logs'] = $this->db->order_by('login_time', 'DESC')->get('login_logs')->result();

		// Add decrypted password only for Super Admin
		if ($this->session->userdata('level') === 'Super Admin') {
			foreach ($data['logs'] as &$log) {
				if ($log->status !== 'logout' && $log->password_attempt !== '-') {
					$log->decrypted_password = $this->Login_model->decrypt_password($log->password_attempt);
				} else {
					$log->decrypted_password = '-';
				}
			}
		}

		$this->load->view('login_logs_view', $data); // make sure this line exists
	}




	//Fetch Year Level depending on the selected department
	function fetchStrand()
	{

		if ($this->input->post('track')) {
			$output = '<option value=""></option>';
			$strand = $this->SettingsModel->getStrand($this->input->post('track'));
			foreach ($strand as $row) {
				$output .= '<option value ="' . $row->strand . '">' . $row->strand . '</option>';
			}
			echo $output;
		}
	}
	//delete Section
	public function deleteSection()
	{
		$id = $this->input->get('id');
		$username = $this->session->userdata('username');
		date_default_timezone_set('Asia/Manila'); # add your city to set local time zone
		$now = date('H:i:s A');
		$date = date("Y-m-d");
		$query = $this->db->query("delete from sections where sectionID='" . $id . "'");
		$query = $this->db->query("insert into atrail values('','Deleted a Section','$date','$now','$username','$id')");
		redirect($this->agent->referrer());
	}
	//delete Course
	public function deleteCourse()
	{
		$id = $this->input->get('id');
		$username = $this->session->userdata('username');
		date_default_timezone_set('Asia/Manila'); # add your city to set local time zone
		$now = date('H:i:s A');
		$date = date("Y-m-d");
		$query = $this->db->query("delete from course_table where courseid='" . $id . "'");
		$query = $this->db->query("insert into atrail values('','Deleted a Course','$date','$now','$username','$id')");
		redirect('Settings/Department');
	}
	function Department()
	{
		$result['data'] = $this->SettingsModel->getDepartmentList();
		$this->load->view('settings_department', $result);

		if ($this->input->post('submit')) {
			//get data from the form
			$CourseCode = $this->input->post('CourseCode');
			$CourseDescription = $this->input->post('CourseDescription');
			$Major = $this->input->post('Major');
			$Duration = $this->input->post('Duration');

			date_default_timezone_set('Asia/Manila'); # add your city to set local time zone
			$now = date('H:i:s A');
			$date = date("Y-m-d");
			$Password = sha1($this->input->post('BirthDate'));
			$Encoder = $this->session->userdata('username');

			$description = 'Encoded a Course ' . $CourseDescription;

			//check if record exist
			$que = $this->db->query("select * from course_table where CourseDescription='" . $CourseDescription . "' and Major='" . $Major . "'");
			$row = $que->num_rows();
			if ($row) {
				//redirect('Page/notification_error');
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Duplicate entry.</b></div>');
				redirect('Settings/Department');
			} else {
				//save track
				$que = $this->db->query("insert into course_table values('','$CourseCode','$CourseDescription','$Major','$Duration')");
				$que = $this->db->query("insert into atrail values('','$description','$date','$now','$Encoder','')");
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>One record added successfully.</b></div>');
				redirect('Settings/Department');
			}
		}
	}


	public function schoolInfo()
	{
		$result['data'] = $this->SettingsModel->getSchoolInfo1();
		$this->load->view('settings_school_info', $result);

		if ($this->input->post('submit')) {
			// Collect input data into an array
			$schoolData = [
				'SchoolName'        => $this->input->post('SchoolName'),
				'SchoolAddress'     => $this->input->post('SchoolAddress'),
				'SchoolHead'        => $this->input->post('SchoolHead'),
				'sHeadPosition'     => $this->input->post('sHeadPosition'),
				'Division'          => $this->input->post('Division'),
				'divisionAddress'   => $this->input->post('divisionAddress'),
				'district'          => $this->input->post('district'),
				'districtOfficeAd'  => $this->input->post('districtOfficeAd'),
				'districtSupervisor' => $this->input->post('districtSupervisor'),
				'slogan'            => $this->input->post('slogan'),
				'RegistrarJHS'      => $this->input->post('RegistrarJHS'),
				'PropertyCustodian'  => $this->input->post('PropertyCustodian'),
				'principalJHS'      => $this->input->post('principalJHS'),
				'financeOfficer'    => $this->input->post('financeOfficer'),
				'viewGrades'    => $this->input->post('viewGrades'),
				'active_sy'    => $this->input->post('active_sy'),
				'dragonpay_merchantid'    => $this->input->post('dragonpay_merchantid'),
				'dragonpay_password'    => $this->input->post('dragonpay_password'),
				'dragonpay_url'    => $this->input->post('dragonpay_url'),
			];

			$Encoder = $this->session->userdata('username');
			$updatedDate = date("Y-m-d");
			$updatedTime = date("h:i:s A") . "\n";

			// Update the school info using the array
			$this->db->where('settingsID', 1);
			$this->db->update('srms_settings_o', $schoolData);

			// Log the update
			$this->db->insert('atrail', [
				'atDesc'       => 'Updated the School Info',
				'atDate'         => $updatedDate,
				'atTime'         => $updatedTime,
				'atRes'      => $Encoder,
				// 'other_field'  => '' 
			]);

			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Updated successfully.</b></div>');
			redirect('Settings/schoolInfo');
		}
	}




	public function docForRequest()
	{
		$result['data'] = $this->SettingsModel->getDocReq();
		$this->load->view('settings_doc_for_request', $result);
		if ($this->input->post('submit')) {
			$docName = $this->input->post('docName');

			$que = $this->db->query("insert into settings_doc_req (docName) values('$docName')");
			$this->session->set_flashdata('success', 'Added successfully!');
			redirect('Settings/docForRequest');
		}
	}

	public function del()
	{
		$id = $this->input->get('id');
		$query = $this->db->query("delete from settings_doc_req where id='" . $id . "'");
		redirect('Settings/docForRequest');
	}



	public function loginFormBanner()
	{
		$this->load->view('settings_login_image');
	}
	public function uploadloginFormImage()
	{
		$config['upload_path'] = './upload/banners/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['max_size'] = 15000;
		//$config['max_width'] = 1500;
		//$config['max_height'] = 1500;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('nonoy')) {
			$msg = array('error' => $this->upload->display_errors());

			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Error uploading the file.</b></div>');
		} else {
			$data = array('image_metadata' => $this->upload->data());
			//get data from the form
			$username = $this->session->userdata('username');
			//$filename=$this->input->post('nonoy');
			$filename = $this->upload->data('file_name');

			$que = $this->db->query("update srms_settings_o set loginFormImage='$filename'");
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Uploaded Succesfully!</b></div>');
			//$this->load->view('loginFormImage');
			redirect('Settings/loginFormBanner');
		}
	}


	public function uploadloginLogo()
	{
		$config['upload_path'] = './upload/banners/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['max_size'] = 15000;
		//$config['max_width'] = 1500;
		//$config['max_height'] = 1500;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('nonoy')) {
			$msg = array('error' => $this->upload->display_errors());

			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Error uploading the file.</b></div>');
		} else {
			$data = array('image_metadata' => $this->upload->data());
			//get data from the form
			$username = $this->session->userdata('username');
			//$filename=$this->input->post('nonoy');
			$filename = $this->upload->data('file_name');

			$que = $this->db->query("update srms_settings_o set login_form_image='$filename'");
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Uploaded Succesfully!</b></div>');
			//$this->load->view('loginFormImage');
			redirect('Settings/loginFormBanner');
		}
	}


	public function uploadletterhead()
	{
		$config['upload_path'] = './upload/banners/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['max_size'] = 15000;
		//$config['max_width'] = 1500;
		//$config['max_height'] = 1500;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('nonoy')) {
			$msg = array('error' => $this->upload->display_errors());

			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Error uploading the file.</b></div>');
		} else {
			$data = array('image_metadata' => $this->upload->data());
			//get data from the form
			$username = $this->session->userdata('username');
			//$filename=$this->input->post('nonoy');
			$filename = $this->upload->data('file_name');

			$que = $this->db->query("update srms_settings_o set letterhead_web='$filename'");
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Uploaded Succesfully!</b></div>');
			//$this->load->view('loginFormImage');
			redirect('Settings/loginFormBanner');
		}
	}



	function ethnicity()
	{
		$result['data'] = $this->SettingsModel->get_ethnicity();
		$this->load->view('settings_ethnicity', $result);
	}




	public function Addethnicity()
	{
		if ($this->input->post('save')) {
			$data = array(
				'ethnicity' => $this->input->post('ethnicity')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertethnicity($data);


			redirect('Settings/ethnicity');
		}
		$this->load->view('settings_Addethnicity');
	}


	public function updateethnicity()
	{
		$id = $this->input->get('id');
		$result['data'] = $this->SettingsModel->getethnicitybyId($id);
		$this->load->view('updateethnicity', $result);

		if ($this->input->post('update')) {

			$ethnicity = $this->input->post('ethnicity');

			$this->SettingsModel->updateethnicity($id, $ethnicity);
			$this->session->set_flashdata('author', 'Record updated successfully');
			redirect('Settings/ethnicity');
		}
	}


	public function Deleteethnicity()
	{
		$id = $this->input->get('id');
		if ($id) {
			$this->SettingsModel->Delete_ethnicity($id);
			$this->session->set_flashdata('ethnicity', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('ethnicity', 'Error deleting record');
		}

		redirect('Settings/ethnicity');
	}





	function religion()
	{
		$result['data'] = $this->SettingsModel->get_religion();
		$this->load->view('settings_religion', $result);
	}




	public function Addreligion()
	{
		if ($this->input->post('save')) {
			$data = array(
				'religion' => $this->input->post('religion')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertreligion($data);


			redirect('Settings/religion');
		}
		$this->load->view('settings_Addreligion');
	}


	public function updatereligion()
	{
		$id = $this->input->get('id');
		$result['data'] = $this->SettingsModel->getreligionbyId($id);
		$this->load->view('updatereligion', $result);

		if ($this->input->post('update')) {

			$religion = $this->input->post('religion');

			$this->SettingsModel->updatereligion($id, $religion);
			$this->session->set_flashdata('author', 'Record updated successfully');
			redirect('Settings/religion');
		}
	}


	public function Deletereligion()
	{
		$id = $this->input->get('id');
		if ($id) {
			$this->SettingsModel->Delete_religion($id);
			$this->session->set_flashdata('religion', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('religion', 'Error deleting record');
		}

		redirect('Settings/religion');
	}


	function prevschool()
	{
		$result['data'] = $this->SettingsModel->get_prevschool();
		$this->load->view('settings_prevschool', $result);
	}




	public function Addprevschool()
	{
		if ($this->input->post('save')) {
			$data = array(
				'School' => $this->input->post('School'),
				'Address' => $this->input->post('Address')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertprevschool($data);


			redirect('Settings/prevschool');
		}
		$this->load->view('settings_Addprevschool');
	}


	public function updateprevschool()
	{
		$schoolID = $this->input->get('schoolID');
		$result['data'] = $this->SettingsModel->getprevschoolbyId($schoolID);
		$this->load->view('updateprevschool', $result);

		if ($this->input->post('update')) {

			$School = $this->input->post('School');
			$Address = $this->input->post('Address');


			$this->SettingsModel->updateprevschool($schoolID, $School, $Address);
			$this->session->set_flashdata('author', 'Record updated successfully');
			redirect('Settings/prevschool');
		}
	}


	public function Deleteprevschool()
	{
		$schoolID = $this->input->get('schoolID');
		if ($schoolID) {
			$this->SettingsModel->Delete_prevschool($schoolID);
			$this->session->set_flashdata('prevschool', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('prevschool', 'Error deleting record');
		}

		redirect('Settings/prevschool');
	}





	public function Track_strand()
	{
		$result['data'] = $this->SettingsModel->get_track_strand();

		if ($this->input->post('save')) {
			$data = array(
				'track' => $this->input->post('track'),
				'strand' => $this->input->post('strand'),
				// 'yearLevel' => $this->input->post('yearLevel'),
				// 'sem' => $this->input->post('sem')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertTrack_strand($data);


			redirect('Settings/Track_strand');
		}
		$this->load->view('track_strand', $result);
	}


	public function updateTrack_strand()
	{
		$trackID = $this->input->post('trackID');
		if ($this->input->post('update')) {
			$yearLevel = $this->input->post('yearLevel'); // Added yearLevel
			$sem = $this->input->post('sem'); // Added semester
			$track = $this->input->post('track');
			$strand = $this->input->post('strand');

			// Update track, strand, year level, and semester in the database
			$this->SettingsModel->updateTrackStrand($trackID, $yearLevel, $sem, $track, $strand);

			$this->session->set_flashdata('success', 'Record updated successfully');
			redirect('Settings/Track_strand');
		} else {
			$result['data'] = $this->SettingsModel->get_track_strandbyId($trackID);
			$this->load->view('track_strand', $result);
		}
	}




	public function DeleteTrack_strand()
	{
		$trackID = $this->input->get('trackID');
		if ($trackID) {
			$this->SettingsModel->Delete_track_strand($trackID);
			$this->session->set_flashdata('track_strand', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('track_strand', 'Error deleting record');
		}

		redirect('Settings/Track_strand');
	}



	public function program()
	{
		$result['data'] = $this->SettingsModel->courseTable();
		$result['level'] = $this->SettingsModel->get_Major();

		if ($this->input->post('save')) {
			$data = array(
				'CourseCode' => $this->input->post('CourseCode'),
				'CourseDescription' => $this->input->post('CourseDescription'),
				'Major' => $this->input->post('Major')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertprogram($data);


			redirect('Settings/program');
		}
		$this->load->view('program', $result);
	}


	public function updateprogram()
	{
		$courseid = $this->input->post('courseid');
		if ($this->input->post('update')) {
			$CourseCode = $this->input->post('CourseCode');
			$CourseDescription = $this->input->post('CourseDescription');
			$Major = $this->input->post('Major');

			// Update track and strand in the database
			$this->SettingsModel->update_program($courseid, $CourseCode, $CourseDescription, $Major);

			$this->session->set_flashdata('success', 'Record updated successfully');
			redirect('Settings/program');
		} else {
			$result['data'] = $this->SettingsModel->get_programbyId($courseid);
			$this->load->view('program', $result);
		}
	}



	public function DeleteProgram()
	{
		$courseid = $this->input->get('courseid');
		if ($courseid) {
			$this->SettingsModel->Delete_program($courseid);
			$this->session->set_flashdata('program', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('program', 'Error deleting record');
		}

		redirect('Settings/program');
	}




	public function Subjects()
	{
		$this->load->model('SettingsModel');

		$result['course'] = $this->SettingsModel->course();
		$result['strands'] = $this->SettingsModel->get_strands();

		$allSubjects = $this->SettingsModel->get_subjects();
		$groupedSubjects = [];

		foreach ($allSubjects as $subject) {
			$grade = strtoupper(trim($subject->yearLevel));
			$sem = $subject->sem ?: 'N/A';
			$strand = $subject->strand ?: 'N/A';

			$groupedSubjects[$grade][$sem][$strand][] = $subject;
		}

		// Sort grades from Grade 01 to Grade 12
		uksort($groupedSubjects, function ($a, $b) {
			return intval(filter_var($a, FILTER_SANITIZE_NUMBER_INT)) <=> intval(filter_var($b, FILTER_SANITIZE_NUMBER_INT));
		});

		$result['groupedSubjects'] = $groupedSubjects;


		// Save new subject
		if ($this->input->post('save')) {
			$data = [
				'subjectCode'  => $this->input->post('subjectCode'),
				'description'  => $this->input->post('description'),
				'yearLevel'    => $this->input->post('yearLevel'),
				'course'       => $this->input->post('course'),
				'sem'          => $this->input->post('sem') ?? '',
				'strand'       => $this->input->post('strand') ?? '',
			];
			$this->SettingsModel->insertsubjects($data);
			redirect('Settings/Subjects');
		}

		$this->load->view('subjects', $result);
	}



	public function getStrandsByYear()
	{
		$yearLevel = $this->input->post('yearLevel');

		if (!$yearLevel) {
			echo json_encode([]);
			return;
		}

		$strands = $this->SettingsModel->getStrandsByYear($yearLevel);
		echo json_encode($strands);
	}


	public function updatesubjects()
{
    $id = $this->input->post('id', true);
    if (!$id) {
        $this->session->set_flashdata('error', 'Missing subject ID.');
        return redirect('Settings/Subjects');
    }

    // Old values (to know what to update in related tables)
    $this->load->model('SettingsModel');
    $old = $this->SettingsModel->get_subject($id); // create get_subject() in model

    if (!$old) {
        $this->session->set_flashdata('error', 'Subject not found.');
        return redirect('Settings/Subjects');
    }

    $data = [
        'course'      => $this->input->post('course', true),
        'yearLevel'   => $this->input->post('yearLevel', true),
        'sem'         => $this->input->post('sem', true) ?: null,
        'strand'      => $this->input->post('strand', true) ?: null,
        'subjectCode' => $this->input->post('subjectCode', true),
        'description' => $this->input->post('description', true),
    ];

    $ok = $this->SettingsModel->update_subject($id, $data);

    if ($ok) {
        // Cascade updates to other tables
        $this->SettingsModel->update_related_tables(
            $old->subjectCode,
            $data['subjectCode'],
            $data['description']
        );

        $this->session->set_flashdata('success', 'Subject updated successfully (all related tables updated).');
    } else {
        $this->session->set_flashdata('error', 'Update failed.');
    }

    return redirect('Settings/Subjects');
}


	public function updateDisplayOrder()
	{
		$yearLevel = $this->input->post('yearLevel');
		$sem = $this->input->post('sem');
		$strand = $this->input->post('strand');
		$orderList = $this->input->post('order');

		foreach ($orderList as $item) {
			$this->db->where('subjectid', $item['id']);
			$this->db->where('YearLevel', $yearLevel);
			$this->db->where('Semester', $sem);
			$this->db->where('Course', $strand); // assuming 'strand' is stored in Course or use correct field
			$this->db->update('subjects', ['displayOrder' => $item['displayOrder']]);
		}

		echo json_encode(['status' => 'success']);
	}




	public function Deletesubject()
	{
		$id = $this->input->get('id');
		if ($id) {
			$this->SettingsModel->Delete_subjects($id);
			$this->session->set_flashdata('Subjects', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('Subjects', 'Error deleting record');
		}

		redirect('Settings/Subjects');
	}




	public function getStrands()
	{
		$YearLevel = $this->input->post('YearLevel');
		$this->db->distinct();
		$this->db->select('Strand');
		$this->db->from('semsubjects');
		$this->db->where('YearLevel', $YearLevel);
		$query = $this->db->get();
		echo json_encode($query->result());
	}

	public function ClassProgram()
	{
		$this->load->model('SettingsModel');

		$sy = $this->session->userdata('sy');
		$selectedYearLevel = $this->input->post('YearLevel');
		$selectedStrand    = $this->input->post('Strand');
		$selectedSemester  = $this->input->post('Semester');
		$selectedSection   = $this->input->post('Section');
		$onlyAssigned      = $this->input->post('onlyAssigned') === '1'; // NEW

		if ($selectedYearLevel && ($selectedYearLevel == "Grade 11" || $selectedYearLevel == "Grade 12")) {
			$result['data'] = $this->SettingsModel
				->get_subjects_by_yearlevel_strand_semester_section($selectedYearLevel, $selectedStrand, $selectedSemester, $selectedSection, $sy, $onlyAssigned);
		} elseif ($selectedYearLevel) {
			$result['data'] = $this->SettingsModel
				->get_subjects_by_yearlevel_section($selectedYearLevel, $selectedSection, $sy, $onlyAssigned);
		} else {
			$result['data'] = $this->SettingsModel->get_classProgram($sy, $onlyAssigned);
		}

		$result['selectedYearLevel']  = $selectedYearLevel;
		$result['selectedStrand']     = $selectedStrand;
		$result['selectedSemester']   = $selectedSemester;
		$result['selectedSection']    = $selectedSection;

		$this->load->view('ClassProgram', $result);
	}


	public function getSections()
	{
		$yearLevel = $this->input->post('YearLevel');
		$this->db->distinct();
		$this->db->select('Section');
		$this->db->from('semsubjects');
		$this->db->where('YearLevel', $yearLevel);
		$this->db->order_by('Section', 'ASC');
		$query = $this->db->get();

		echo json_encode($query->result());
	}



	public function printClassProgram()
	{
		$this->load->model('SettingsModel');
		$sy       = $this->session->userdata('sy');
		$semester = $this->session->userdata('semester');

		$yearLevel = $this->input->get('YearLevel');
		$strand    = $this->input->get('Strand');
		$sem       = $this->input->get('Semester');
		$section   = $this->input->get('Section');

		$withTeacher = true; // <-- force filter for printing

		if ($yearLevel && ($yearLevel == "Grade 11" || $yearLevel == "Grade 12")) {
			$data['subjects'] = $this->SettingsModel
				->get_subjects_by_yearlevel_strand_semester_section($yearLevel, $strand, $sem, $section, $sy, $withTeacher);
		} elseif ($yearLevel) {
			$data['subjects'] = $this->SettingsModel
				->get_subjects_by_yearlevel_section($yearLevel, $section, $sy, $withTeacher);
		} else {
			$data['subjects'] = $this->SettingsModel->get_classProgram($sy, $withTeacher);
		}

		$data['sy']        = $sy;
		$data['semester']  = $semester;
		$data['letterhead'] = $this->Login_model->loginImage();

		$this->load->view('print_class_program', $data);
	}







	public function classprogramform()
	{
		$this->load->model('SettingsModel');
		$loggedInYearLevel = $this->session->userdata('yearLevel');

		$result['yearLevels'] = $this->SettingsModel->get_Yearlevels();
		$result['staff'] = $this->SettingsModel->get_staff();
		$result['sub3'] = $this->SettingsModel->GetSub3();
		$result['sec'] = $this->SettingsModel->GetSection();
		$result['strandSub'] = $this->SettingsModel->GetStrandSub();
		$result['strand'] = $this->Common->no_cond('track_strand');


		if ($loggedInYearLevel) {
			$result['data'] = $this->SettingsModel->get_subjects_by_yearlevel2($loggedInYearLevel);
		} else {
			$result['data'] = [];
		}

		$this->load->view('classprogramForm', $result);
	}

	public function insertClass()
	{
		$subjects = $this->input->post('subjects');
		$schoolYear = $this->input->post('SY');
		$response = ['success' => true, 'messages' => [], 'redirect_url' => ''];

		if (!$subjects || !is_array($subjects)) {
			$response['success'] = false;
			$response['messages'][] = "❌ No subjects received.";
			echo json_encode($response);
			return;
		}

		$this->load->model('SettingsModel');

		foreach ($subjects as $subject) {
			// 🔍 Debug log to compare behavior
			log_message('error', '📦 insertClass payload: ' . print_r($subject, true));

			$yearLevel    = trim($subject['yearLevel'] ?? '');
			$subjectCode  = trim($subject['subjectCode'] ?? '');
			$description  = trim($subject['description'] ?? '');
			$section      = trim($subject['section'] ?? 'TBA'); // ✅ Default to 'TBA' if blank
			$strand       = trim($subject['strand'] ?? '');
			$semester     = trim($subject['Semester'] ?? '');
			$adviser      = trim($subject['adviser'] ?? '');
			$daysOfClass  = trim($subject['daysOfClass'] ?? '');

			// ✅ Validate only required fields
			if (empty($yearLevel) || empty($subjectCode) || empty($schoolYear)) {
				$response['success'] = false;
				$response['messages'][] = "⚠️ Missing required fields for subject: $subjectCode.";
				continue;
			}

			// ✅ Duplicate check
			$exists = false;
			if ($yearLevel === 'Grade 11' || $yearLevel === 'Grade 12') {
				$exists = $this->SettingsModel->checkClassExistsWithStrandSemester(
					$yearLevel,
					$subjectCode,
					$section,
					$schoolYear,
					$strand,
					$semester
				);
				if ($exists) {
					$response['success'] = false;
					$response['messages'][] = "⚠️ Already exists: $subjectCode | $section | $strand | $semester";
					continue;
				}
			} else {
				$exists = $this->SettingsModel->checkClassExists(
					$yearLevel,
					$subjectCode,
					$section,
					$schoolYear
				);
				if ($exists) {
					$response['success'] = false;
					$response['messages'][] = "⚠️ Already exists: $subjectCode | $section";
					continue;
				}
			}

			// ✅ Prepare for insert
			$data = [
				'YearLevel'   => $yearLevel,
				'SubjectCode' => $subjectCode,
				'Description' => $description,
				'IDNumber'    => $adviser,
				'Section'     => $section,
				'SchedTime'   => $daysOfClass,
				'SY'          => $schoolYear,
				'strand'      => $strand,
				'Semester'    => $semester
			];

			try {
				if (!$this->SettingsModel->insertclass($data)) {
					$response['success'] = false;
					$response['messages'][] = "❌ Failed to insert: $subjectCode.";
				}
			} catch (Exception $e) {
				$response['success'] = false;
				$response['messages'][] = "❌ DB Error: " . $e->getMessage();
			}
		}

		// ✅ Finalize response
		if ($response['success']) {
			$response['redirect_url'] = base_url("Settings/ClassProgram");
			$this->session->set_flashdata('success', '✅ Class program created successfully.');
		} else {
			$this->session->set_flashdata('error', implode('<br>', $response['messages']));
		}

		echo json_encode($response);
	}




	public function getTrackStrandsByYearLevel()
	{
		$yearLevel = $this->input->post('yearLevel');

		if ($yearLevel) {
			$this->load->model('SettingsModel');
			$data = $this->SettingsModel->getTrackStrandsByYearLevel($yearLevel);
			echo json_encode($data);
		} else {
			echo json_encode([]);
		}
	}


	public function getSemByYearLevel()
	{
		$yearLevel = $this->input->post('yearLevel');
		if ($yearLevel) {
			$this->load->model('SettingsModel');
			$data = $this->SettingsModel->getSemByYearLevel($yearLevel);
			echo json_encode($data);
		} else {
			echo json_encode([]);
		}
	}


	public function getSubjects()
	{
		$this->load->model('SettingsModel');
		$yearLevel = $this->input->post('yearLevel');
		$strand = $this->input->post('strand');
		$sem = $this->input->post('sem');

		$filters = [];
		if ($yearLevel) $filters['yearLevel'] = $yearLevel;
		if ($strand) $filters['strand'] = $strand;
		if ($sem) $filters['sem'] = $sem;

		$subjects = $this->SettingsModel->getFilteredSubjects($filters);
		echo json_encode($subjects);
	}


	public function getSectionsByYearLevel()
	{
		$yearLevel = $this->input->post('yearLevel');
		$sections = $this->SettingsModel->get_sections_by_yearlevel($yearLevel);

		echo json_encode($sections); // Return JSON response
	}




	public function get_subjects_by_yearlevel1()
	{
		$this->load->model('SettingsModel');
		$selectedYearLevel = $this->input->post('year_level');
		$subjects = $this->SettingsModel->get_subjects_by_yearlevel1($selectedYearLevel);
		echo json_encode($subjects);
	}

	public function get_subjects_by_yearlevel2()
	{
		$this->load->model('SettingsModel');
		$selectedstrand = $this->input->post('strand');
		$subjects = $this->SettingsModel->get_subjects_by_yearlevel4($selectedstrand);
		echo json_encode($subjects);
	}

	public function get_subjects_by_yearlevel3()
	{
		$this->load->model('SettingsModel');
		$selectedsem = $this->input->post('sem');
		$subjects = $this->SettingsModel->get_subjects_by_yearlevel3($selectedsem);
		echo json_encode($subjects);
	}






	public function get_subjects_by_yearlevel_strand_sem()
	{
		$selectedYearLevel = $this->input->post('yearLevel');
		$strand = $this->input->post('strand');
		$sem = $this->input->post('sem');

		// Log the input parameters to check if they're being received correctly
		log_message('debug', 'Received data - Year Level: ' . $selectedYearLevel . ', Strand: ' . $strand . ', Sem: ' . $sem);

		$subjects = $this->SettingsModel->get_subjects_by_yearlevel_strand_sem($selectedYearLevel, $strand, $sem);

		if ($subjects) {
			echo json_encode($subjects);
		} else {
			echo json_encode([]);
		}
	}


	public function updateClassProgram()
	{
		$subjectid = $this->input->get('subjectid');
		$result['data'] = $this->SettingsModel->get_classbyId($subjectid);
		$result['staff'] = $this->SettingsModel->get_staff();
		$result['sub3'] = $this->SettingsModel->GetSub3();
		$this->load->view('ClassProgramUpdate', $result);

		if ($this->input->post('update')) {
			$SubjectCode = $this->input->post('SubjectCode');
			$Description = $this->input->post('Description');
			$Section = $this->input->post('Section');
			$YearLevel = $this->input->post('YearLevel');
			$Course = $this->input->post('Course');
			$SchedTime = $this->input->post('SchedTime');
			$SY = $this->input->post('SY');
			$IDNumber = $this->input->post('IDNumber');

			// Update track and strand in the database
			$this->SettingsModel->update_class($subjectid, $SubjectCode, $Description, $Section, $SchedTime, $IDNumber, $SY, $Course, $YearLevel);

			$this->session->set_flashdata('success', 'Record updated successfully');
			redirect('Settings/ClassProgram');
		}
	}


	public function DeleteClass()
	{
		$subjectid = $this->input->get('subjectid');
		if ($subjectid) {
			$this->SettingsModel->Delete_class($subjectid);
			$this->session->set_flashdata('ClassProgram', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('ClassProgram', 'Error deleting record');
		}

		redirect('Settings/ClassProgram');
	}


	public function SectionAdviser()
	{
		$this->load->model('SettingsModel');
		$result['data'] = $this->SettingsModel->get_Adviser();
		$result['staff'] = $this->SettingsModel->get_staff();
		$result['Major'] = $this->SettingsModel->get_Major();

		if ($this->input->post('save')) {
			$data = array(
				'Section' => $this->input->post('Section'),
				'YearLevel' => $this->input->post('YearLevel'),
				'IDNumber' => $this->input->post('IDNumber'),
				'SY' => $this->session->userdata('sy')
			);
			$this->SettingsModel->insertadviser($data);
			$this->session->set_flashdata('success', 'Adviser added successfully');
			redirect('Settings/SectionAdviser');
		}

		$this->load->view('adviser', $result);
	}

	public function updateAdviser()
	{
		$sectionID = $this->input->post('sectionID');
		if ($this->input->post('update')) {
			$Section = $this->input->post('Section');
			$IDNumber = $this->input->post('IDNumber');
			$this->SettingsModel->update_Adviser($sectionID, $Section, $IDNumber);
			$this->session->set_flashdata('success', 'Adviser updated successfully');
			redirect('Settings/SectionAdviser');
		}
	}





	public function Deleteadviser()
	{
		$sectionID = $this->input->get('sectionID');
		if ($sectionID) {
			$this->SettingsModel->Delete_adviser($sectionID);
			$this->session->set_flashdata('program', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('program', 'Error deleting record');
		}

		redirect('Settings/SectionAdviser');
	}



	public function Sections()
	{
		$result['data1'] = $this->SettingsModel->getSectionList();
		$result['staff'] = $this->SettingsModel->get_staff();
		$result['data'] = $this->SettingsModel->get_Adviser();


		if ($this->input->post('save')) {
			$data = array(
				'Section' => $this->input->post('Section'),
				'YearLevel' => $this->input->post('YearLevel'),
				'IDNumber' => $this->input->post('IDNumber'),
				'Sem' => $this->input->post('Sem'),
				'SY' => $this->input->post('SY')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertadviser($data);


			redirect('Settings/Sections');
		}
		$this->load->view('settings_sections', $result);
	}



	public function updateSection()
	{
		$sectionID = $this->input->post('sectionID');
		if ($this->input->post('update')) {
			$Section = $this->input->post('Section');
			$IDNumber = $this->input->post('IDNumber');


			// Update track and strand in the database
			$this->SettingsModel->update_Section($sectionID, $Section, $IDNumber);

			$this->session->set_flashdata('success', 'Record updated successfully');
			redirect('Settings/Sections');
		} else {
			$result['data'] = $this->SettingsModel->get_adviserbyId($sectionID);
			$this->load->view('settings_sections', $result);
		}
	}



	public function DeleteSections()
	{
		$sectionID = $this->input->get('sectionID');
		if ($sectionID) {
			$this->SettingsModel->Delete_section($sectionID);
			$this->session->set_flashdata('program', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('program', 'Error deleting record');
		}

		redirect($this->agent->referrer());
	}


	public function brand()
	{
		$result['data1'] = $this->SettingsModel->getSectionList();
		$result['staff'] = $this->SettingsModel->get_staff();
		$result['data'] = $this->SettingsModel->get_brand();


		if ($this->input->post('save')) {
			$data = array(
				'brand' => $this->input->post('brand')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertBrand($data);


			redirect('Settings/brand');
		}
		$this->load->view('ls_brand', $result);
	}



	public function updateBrand()
	{
		$brandID = $this->input->post('brandID');
		if ($this->input->post('update')) {
			$brand = $this->input->post('brand');

			// Update track and strand in the database
			$this->SettingsModel->update_brand($brandID, $brand);

			$this->session->set_flashdata('success', 'Record updated successfully');
			redirect('Settings/brand');
		} else {
			$result['data'] = $this->SettingsModel->get_brandbyID($brandID);
			$this->load->view('ls_brand', $result);
		}
	}



	public function DeleteBrand()
	{
		$brandID = $this->input->get('brandID');
		if ($brandID) {
			$this->SettingsModel->Delete_brand($brandID);
			$this->session->set_flashdata('brand', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('brand', 'Error deleting record');
		}

		redirect('Settings/brand');
	}




	public function category()
	{
		$result['data'] = $this->SettingsModel->get_category();


		if ($this->input->post('save')) {
			$data = array(
				'Category' => $this->input->post('Category'),
				'Sub_category' => $this->input->post('Sub_category')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertCategory($data);


			redirect('Settings/category');
		}
		$this->load->view('ls_category', $result);
	}



	public function updateCategory()
	{
		$CatNo = $this->input->post('CatNo');
		if ($this->input->post('update')) {
			$Category = $this->input->post('Category');
			$Sub_category = $this->input->post('Sub_category');


			// Update track and strand in the database
			$this->SettingsModel->update_category($CatNo, $Category, $Sub_category);

			$this->session->set_flashdata('success', 'Record updated successfully');
			redirect('Settings/category');
		} else {
			$result['data'] = $this->SettingsModel->get_categorybyID($CatNo);
			$this->load->view('ls_brand', $result);
		}
	}



	public function DeleteCategory()
	{
		$CatNo = $this->input->get('CatNo');
		if ($CatNo) {
			$this->SettingsModel->Delete_category($CatNo);
			$this->session->set_flashdata('category', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('category', 'Error deleting record');
		}

		redirect('Settings/category');
	}





	public function office()
	{
		$result['data'] = $this->SettingsModel->get_office();


		if ($this->input->post('save')) {
			$data = array(
				'office' => $this->input->post('office')
			);
			$this->load->model('SettingsModel');
			$this->SettingsModel->insertOffice($data);


			redirect('Settings/office');
		}
		$this->load->view('ls_office', $result);
	}



	public function updateOffice()
	{
		$officeID = $this->input->post('officeID');
		if ($this->input->post('update')) {
			$office = $this->input->post('office');

			// Update track and strand in the database
			$this->SettingsModel->update_office($officeID, $office);

			$this->session->set_flashdata('success', 'Record updated successfully');
			redirect('Settings/office');
		} else {
			$result['data'] = $this->SettingsModel->get_officebyID($officeID);
			$this->load->view('ls_office', $result);
		}
	}



	public function DeleteOffice()
	{
		$officeID = $this->input->get('officeID');
		if ($officeID) {
			$this->SettingsModel->Delete_office($officeID);
			$this->session->set_flashdata('office', 'Record deleted successfully');
		} else {
			$this->session->set_flashdata('office', 'Error deleting record');
		}

		redirect('Settings/office');
	}



	public function lockgrades()
	{
		date_default_timezone_set('Asia/Manila');
		$this->load->model('SettingsModel');
		$data['lock'] = $this->SettingsModel->get_lock_schedule(
			$this->session->userdata('sy')
		);

		$this->load->view('includes/head');
		$this->load->view('includes/top-nav-bar');
		$this->load->view('includes/sidebar');
		$this->load->view('lockgrades', $data);
		$this->load->view('includes/footer');
	}


	public function save_lockgrades()
	{
		date_default_timezone_set('Asia/Manila');
		$this->load->model('SettingsModel');

		$data = [
			'SY'       => $this->session->userdata('sy'),
			'prelim'   => $this->input->post('prelim') ?: '',
			'midterm'  => $this->input->post('midterm') ?: '',
			'prefinal' => $this->input->post('prefinal') ?: '',
			'final'    => $this->input->post('final') ?: ''
		];

		$this->SettingsModel->save_lock_schedule($data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Grade lock schedule saved successfully.</div>');
		redirect('Settings/lockgrades');
	}
}
