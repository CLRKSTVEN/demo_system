<?php
class Page extends CI_Controller
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
		$this->load->model('ToDoModel');
		$this->load->model('Login_model');
		$this->load->model('EmailBlast_model');
		$this->load->library('user_agent');


		if ($this->session->userdata('logged_in') !== TRUE) {
			redirect('login');
		}

		$this->grade_display = $this->SettingsModel->get_grade_display();
	}

	public function updateSemesterSy()
	{
		$sy = $this->input->post('sy');

		$this->session->set_userdata('sy', $sy);

		// Add flash message
		$this->session->set_flashdata('success', '<div class="alert alert-success">School Year successfully changed to ' . htmlspecialchars($sy) . '.</div>');

		redirect($this->agent->referrer());
	}


	function index()
	{
		//Allowing access to admin only
		if ($this->session->userdata('level') === 'Admin') {

			$this->load->view('dashboard_admin');
		} else {
			echo "Access Denied";
		}
	}


	public function some_method()
	{
		$data['grade_display'] = $this->grade_display;
		$this->load->view('your_view', $data);
	}


	function success($text)
	{
		$m = '<div class="alert alert-success text-center"><b>' . $text . '</b></div>';
		return $m;
	}

	function danger($text)
	{
		$m = '<div class="alert alert-danger text-center"><b>' . $text . '</b></div>';
		return $m;
	}

	function admin()
	{
		//Allowing access to Admin only
		if ($this->session->userdata('level') === 'Admin') {
			$sy = $this->session->userdata('sy');
			// $sem = $this->session->userdata('semester');
			$Semester = $this->session->userdata('semester');
			$SY = $this->session->userdata('sy');
			//$date=date('Y-m-d');
			$result['data'] = $this->StudentModel->enrolledJHS($sy);
			$result['data1'] = $this->StudentModel->enrolledSHS($sy);
			$result['shs2'] = $this->StudentModel->preschool($sy);
			$result['data2'] = $this->StudentModel->enrolledElem($sy);
			$result['data3'] = $this->StudentModel->onlineEnrollees($sy);
			$result['data4'] = $this->StudentModel->forPaymentVerCount($sy);
			$result['data5'] = $this->StudentModel->teachersCount();
			$result['data6'] = $this->StudentModel->forValidationCounts($SY);
			$result['data7'] = $this->StudentModel->totalProfile();
			$result['data8'] = $this->StudentModel->CourseCount($sy);
			$result['data9'] = $this->StudentModel->SexCount1($sy);
			$result['data10'] = $this->StudentModel->dailyEnrollStat();

			$result['data18'] = $this->SettingsModel->getSchoolInformation();

			$this->load->view('dashboard_admin', $result);
		} else {
			echo "Access Denied";
		}
	}

	function bac()
	{
		if ($this->session->userdata('level') === 'BAC') {
			$sy = $this->session->userdata('sy');
			// $sem = $this->session->userdata('semester');
			$Semester = $this->session->userdata('semester');
			$SY = $this->session->userdata('sy');


			$result['data18'] = $this->SettingsModel->getSchoolInformation();

			$this->load->view('dashboard_bac', $result);
		} else {
			echo "Access Denied";
		}
	}

	function a_officer()
	{
		if ($this->session->userdata('level') === 'Academic Officer') {
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');
			$Semester = $this->session->userdata('semester');
			$SY = $this->session->userdata('sy');
			//$date=date('Y-m-d');
			$result['data'] = $this->StudentModel->enrolledJHS($sy);
			$result['data1'] = $this->StudentModel->enrolledSHS($sy);
			$result['shs2'] = $this->StudentModel->enrolledSHS2($sy);
			$result['data2'] = $this->StudentModel->enrolledElem($sy);
			$result['data3'] = $this->StudentModel->onlineEnrollees($sy);
			$result['data4'] = $this->StudentModel->forPaymentVerCount($sy);
			$result['data5'] = $this->StudentModel->teachersCount();
			$result['data6'] = $this->StudentModel->forValidationCounts($SY);
			$result['data7'] = $this->StudentModel->totalProfile();
			$result['data8'] = $this->StudentModel->CourseCount($sy);
			$result['data9'] = $this->StudentModel->SexCount1($sy);
			$result['data10'] = $this->StudentModel->dailyEnrollStat();
			// $result['data11'] = $this->StudentModel->paymentSummary($sy);
			// $result['data12'] = $this->StudentModel->collectionToday();
			// $result['data13'] = $this->StudentModel->collectionMonth();
			// $result['data14'] = $this->StudentModel->YearlyCollections();
			// $result['data15'] = $this->StudentModel->religionCount1($sy);
			// $result['data16'] = $this->StudentModel->ethnicityCount($sy);
			// $result['data17'] = $this->StudentModel->cityCount($sy);
			$result['data18'] = $this->SettingsModel->getSchoolInfo();
			$result['data19'] = $this->StudentModel->studeRequestList();

			$this->load->view('dashboard_a_officer', $result);
		} else {
			echo "Access Denied";
		}
	}

	public function encoder()
	{
		if ($this->session->userdata('level') === 'Encoder') {
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');
			$username = $this->session->userdata('username'); // Get current encoder

			$result['data18'] = $this->SettingsModel->getSchoolInfo();
			$result['profileCount'] = $this->StudentModel->countProfilesByEncoder($username);

			$this->load->view('dashboard_encoder', $result);
		} else {
			echo "Access Denied";
		}
	}


	function cashier()
	{
		if ($this->session->userdata('level') === 'Cashier') {
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');

			$result['data18'] = $this->SettingsModel->getSchoolInfo();

			$this->load->view('dashboard_cashier', $result);
		} else {
			echo "Access Denied";
		}
	}
	function p_custodian()
	{
		if ($this->session->userdata('level') === 'Property Custodian') {

			$result['data18'] = $this->SettingsModel->getSchoolInfo();
			$result['count'] = $this->StudentModel->countItemsByCategory('Machinery and Equipment'); // Get the count
			$result['count1'] = $this->StudentModel->countItemsByCategory('Transportation Equipment'); // Get the count
			$result['count2'] = $this->StudentModel->countItemsByCategory('Furniture Fixtures and Books'); // Get the count
			$result['count3'] = $this->StudentModel->countItemsByCategory('OTHERS'); // Get the count


			$this->load->view('dashboard_p_custodian', $result);
		} else {
			echo "Access Denied";
		}
	}


	function s_principal()
	{
		if ($this->session->userdata('level') === 'Principal') {
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');
			$Semester = $this->session->userdata('semester');
			$SY = $this->session->userdata('sy');
			//$date=date('Y-m-d');
			$result['data'] = $this->StudentModel->enrolledJHS($sy);
			$result['data1'] = $this->StudentModel->enrolledSHS($sy);
			$result['shs2'] = $this->StudentModel->enrolledSHS2($sy);
			$result['data2'] = $this->StudentModel->enrolledElem($sy);
			$result['data3'] = $this->StudentModel->onlineEnrollees($sy);
			$result['data4'] = $this->StudentModel->forPaymentVerCount($sy);
			$result['data5'] = $this->StudentModel->teachersCount();
			$result['data6'] = $this->StudentModel->forValidationCounts($SY);
			$result['data7'] = $this->StudentModel->totalProfile();
			$result['data8'] = $this->StudentModel->CourseCount($sy);
			$result['data9'] = $this->StudentModel->SexCount1($sy);
			$result['data10'] = $this->StudentModel->dailyEnrollStat();
			// $result['data11']=$this->StudentModel->paymentSummary($sy);
			// $result['data12']=$this->StudentModel->collectionToday();
			// $result['data13']=$this->StudentModel->collectionMonth();
			// $result['data14']=$this->StudentModel->YearlyCollections();
			// $result['data15']=$this->StudentModel->religionCount1($sy);
			// $result['data16']=$this->StudentModel->ethnicityCount($sy);
			// $result['data17']=$this->StudentModel->cityCount($sy);
			$result['data18'] = $this->SettingsModel->getSchoolInfo();
			$result['data19'] = $this->StudentModel->studeRequestList();

			$this->load->view('dashboard_principal', $result);
		} else {
			echo "Access Denied";
		}
	}


	function hr()
	{

		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$Semester = $this->session->userdata('semester');
		$SY = $this->session->userdata('sy');
		$result['data5'] = $this->StudentModel->teachersCount();

		$this->load->view('dashboard_hr', $result);
	}

	function superAdmin()
	{
		//Allowing access to Accounting only
		if ($this->session->userdata('level') === 'Super Admin') {
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');
			$Semester = $this->session->userdata('semester');
			$SY = $this->session->userdata('sy');
			$result['data'] = $this->StudentModel->enrolledFirst($sy, $sem);
			$result['data1'] = $this->StudentModel->enrolledSecond($sy, $sem);
			$result['data2'] = $this->StudentModel->enrolledThird($sy, $sem);
			$result['data3'] = $this->StudentModel->enrolledFourth($sy, $sem);
			//$result['data4']=$this->StudentModel->forPaymentVerCount($sy,$sem);
			$result['data5'] = $this->StudentModel->teachersCount();
			//$result['data6']=$this->StudentModel->forValidationCounts($Semester,$SY);
			$result['data7'] = $this->StudentModel->totalProfile();
			$result['data8'] = $this->StudentModel->CourseCount($sy);
			$result['data9'] = $this->StudentModel->SexCount1($sy);
			$result['data10'] = $this->StudentModel->dailyEnrollStat();
			$result['data11'] = $this->StudentModel->paymentSummary($sem, $sy);
			$result['data12'] = $this->StudentModel->collectionToday();
			$result['data13'] = $this->StudentModel->collectionMonth();
			$result['data14'] = $this->StudentModel->YearlyCollections();
			$result['data15'] = $this->StudentModel->religionCount1($sy);
			$result['data16'] = $this->StudentModel->ethnicityCount($sem, $sy);
			$result['data17'] = $this->StudentModel->cityCount($sem, $sy);
			$result['data18'] = $this->SettingsModel->getSchoolInformation();
			$result['data19'] = $this->StudentModel->studeRequestList();

			$this->load->view('dashboard_sadmin', $result);
		} else {
			echo "Access Denied";
		}
	}
	function accounting()
	{
		if ($this->session->userdata('level') === 'Accounting') {
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');
			$Semester = $this->session->userdata('semester');
			$SY = $this->session->userdata('sy');
			$result['data'] = $this->StudentModel->enrolledFirst($sy, $sem);
			$result['data1'] = $this->StudentModel->enrolledSecond($sy, $sem);
			$result['data2'] = $this->StudentModel->enrolledThird($sy, $sem);
			$result['data3'] = $this->StudentModel->enrolledFourth($sy, $sem);
			$result['data4'] = $this->StudentModel->forPaymentVerCount($sy, $sem);
			//$result['data5']=$this->StudentModel->teachersCount();
			//$result['data6']=$this->StudentModel->forValidationCounts($Semester,$SY);
			$result['data7'] = $this->StudentModel->totalProfile();
			$result['data8'] = $this->StudentModel->CourseCount($sy);
			$result['data9'] = $this->StudentModel->SexCount1($sy);
			$result['data10'] = $this->StudentModel->dailyEnrollStat();
			$result['data11'] = $this->StudentModel->paymentSummary($sem, $sy);
			$result['data12'] = $this->StudentModel->collectionToday();
			$result['data13'] = $this->StudentModel->collectionMonth();
			$result['data14'] = $this->StudentModel->YearlyCollections();
			$result['data15'] = $this->StudentModel->religionCount1($sy);
			$result['data16'] = $this->StudentModel->ethnicityCount($sem, $sy);
			$result['data17'] = $this->StudentModel->cityCount($sem, $sy);
			$result['data19'] = $this->StudentModel->studeRequestList();

			$this->load->view('dashboard_accounting', $result);
		} elseif ($this->session->userdata('level') === 'Admin') {
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');
			$Semester = $this->session->userdata('semester');
			$SY = $this->session->userdata('sy');
			$result['data'] = $this->StudentModel->enrolledFirst($sy, $sem);
			$result['data1'] = $this->StudentModel->enrolledSecond($sy, $sem);
			$result['data2'] = $this->StudentModel->enrolledThird($sy, $sem);
			$result['data3'] = $this->StudentModel->enrolledFourth($sy, $sem);
			$result['data4'] = $this->StudentModel->forPaymentVerCount($sy, $sem);
			//$result['data5']=$this->StudentModel->teachersCount();
			//$result['data6']=$this->StudentModel->forValidationCounts($Semester,$SY);
			$result['data7'] = $this->StudentModel->totalProfile();
			$result['data8'] = $this->StudentModel->CourseCount($sy);
			$result['data9'] = $this->StudentModel->SexCount1($sy);
			$result['data10'] = $this->StudentModel->dailyEnrollStat();
			$result['data11'] = $this->StudentModel->paymentSummary($sem, $sy);
			$result['data12'] = $this->StudentModel->collectionToday();
			$result['data13'] = $this->StudentModel->collectionMonth();
			$result['data14'] = $this->StudentModel->YearlyCollections();
			$result['data15'] = $this->StudentModel->religionCount1($sy);
			$result['data16'] = $this->StudentModel->ethnicityCount($sem, $sy);
			$result['data17'] = $this->StudentModel->cityCount($sem, $sy);

			$this->load->view('dashboard_accounting', $result);
		} else {
			echo "Access Denied";
		}
	}
	function registrar()
	{
		$username = $this->session->userdata('username');
		$sy = $this->session->userdata('sy');
		$SY = $this->session->userdata('sy');
		$result['data'] = $this->StudentModel->enrolledJHS($sy);
		$result['data1'] = $this->StudentModel->enrolledSHS($sy);
		$result['shs2'] = $this->StudentModel->preschool($sy);
		$result['data2'] = $this->StudentModel->enrolledElem($sy);
		$result['data3'] = $this->StudentModel->onlineEnrollees($sy);
		$result['data4'] = $this->ToDoModel->pendingTask($username);
		$result['data6'] = $this->StudentModel->forValidationCounts($SY);
		$result['data7'] = $this->StudentModel->totalProfile();
		$result['data8'] = $this->StudentModel->CourseCount($sy);
		$result['data9'] = $this->StudentModel->SexCount1($sy);
		$result['data10'] = $this->StudentModel->dailyEnrollStat();
		$result['data18'] = $this->StudentModel->totalEnrolled($sy);


		$this->load->view('dashboard_registrar', $result);
	}

	function teacher()
	{
		//Allowing access to Instructor only
		if ($this->session->userdata('level') === 'Teacher') {
			$instructor = $this->session->userdata('fName') . ' ' . $this->session->userdata('lName');


			$id = $this->session->userdata('username');
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');
			$result['data'] = $this->StudentModel->facultyLoadCounts($id, $sy);
			$result['data1'] = $this->StudentModel->facultyGrades($instructor, $sy);
			$result['data2'] = $this->InstructorModel->facultyLoad($id, $sy);
			$this->load->view('dashboard_teacher', $result);
		} else {
			echo "Access Denied";
		}
	}

	function adviser()
	{
		//Allowing access to Instructor only
		if ($this->session->userdata('level') === 'Teacher/Adviser') {
			$instructor = $this->session->userdata('fName') . ' ' . $this->session->userdata('lName');

			$id = $this->session->userdata('IDNumber');
			$sy = $this->session->userdata('sy');
			$sem = $this->session->userdata('semester');
			$result['data'] = $this->StudentModel->facultyLoadCounts($id, $sy);
			$result['data1'] = $this->StudentModel->facultyGrades($instructor, $sy);
			$result['data2'] = $this->InstructorModel->facultyLoad($id, $sy);
			$this->load->view('dashboard_teacher', $result);
		} else {
			echo "Access Denied";
		}
	}


	function library()
	{
		//Allowing access to Accounting only
		if ($this->session->userdata('level') === 'Librarian') {
			$data['total_title_count'] = $this->LibraryModel->getTotalTitleCount();
			$data['total_books'] = $this->LibraryModel->getTotalBooks();
			$data['total_cat'] = $this->LibraryModel->getTotalCategories();
			$this->load->view('dashboard_library', $data);
		} elseif ($this->session->userdata('level') === 'Admin') {
			$data['total_title_count'] = $this->LibraryModel->getTotalTitleCount();
			$data['total_books'] = $this->LibraryModel->getTotalBooks();
			$data['total_cat'] = $this->LibraryModel->getTotalCategories();
			$this->load->view('dashboard_library', $data);
		} else {
			echo "Access Denied";
		}
	}

	function proof_payment()
	{
		//Allowing access to Stuent only
		if ($this->session->userdata('level') === 'Student') {
			$id = $this->session->userdata('username');
			$result1['data1'] = $this->StudentModel->UploadedPayments($id);
			$result1['data'] = $this->StudentModel->getSemesterfromOE($id);
			$this->load->view('upload_payments', $result1);

			//$this->load->view('upload_payments');
		} else {
			echo "Access Denied";
		}
	}

	public function addRequirement()
	{
		$name = $this->input->post('name');
		$description = $this->input->post('description');

		$data = [
			'name' => $name,
			'description' => $description,
			'is_active' => '1'
		];

		$this->db->insert('requirements', $data);

		$this->session->set_flashdata('success', 'Requirement added successfully!');
		redirect('Student/req_list'); // or your current page
	}

	public function updateRequirement()
	{
		$id = $this->input->post('id');
		$data = [
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description')
		];

		$this->db->where('id', $id);
		$this->db->update('requirements', $data);

		$this->session->set_flashdata('success', 'Requirement updated successfully.');
		redirect('Student/req_list'); // Replace with your actual view page
	}

	public function deleteRequirement($id)
	{
		// Optional: Check if the record exists
		$requirement = $this->db->get_where('requirements', ['id' => $id])->row();

		if ($requirement) {
			$this->db->delete('requirements', ['id' => $id]);
			$this->session->set_flashdata('success', 'Requirement deleted successfully.');
		} else {
			$this->session->set_flashdata('error', 'Requirement not found.');
		}

		redirect('Student/req_list'); // Replace 'yourViewPage' with the actual method or route
	}


	public function proof_payment_view()
	{
		// $sem = $this->session->userdata('semester');
		$sy = $this->session->userdata('sy');

		$data['data1'] = $this->StudentModel->UploadedPaymentsAdmin($sy);
		// $data['data4'] = $this->StudentModel->forPaymentVerCount($sy);
		$data['paymentCount'] = $this->StudentModel->forPaymentVerCount($sy);

		// Get the latest ORNumber based on the latest ID in paymentsaccounts table
		$lastPayment = $this->db->order_by('ID', 'DESC')->limit(1)->get('paymentsaccounts')->row();

		// Default ORNumber if table is empty
		$lastOR = $lastPayment ? $lastPayment->ORNumber : 0;

		// Handle numeric OR numbers
		$data['nextOR'] = is_numeric($lastOR) ? $lastOR + 1 : $lastOR;

		// Load the view with all merged data
		$this->load->view('proof_payments', $data);
	}

	public function acceeptOnlinePayment()
	{
		// Get form input
		$studentNumber = $this->input->post('StudentNumber');
		$cashier = $this->session->userdata('username');
		$opID = $this->input->post('id');
		$data = [
			'StudentNumber'     => $studentNumber,
			'PDate'             => date('Y-m-d'),
			'Amount'            => $this->input->post('Amount'),
			'description'       => $this->input->post('description'),
			'PaymentType'       => $this->input->post('PaymentType'),
			'SY'                => $this->input->post('sy'),
			'CollectionSource'  => "Student's Account",
			'ORStatus'            => 'Valid',
			'ORNumber'          => $this->input->post('ORNumber'),
			'Cashier'           => $cashier,
			'settingsID'        => 1
		];

		// Start transaction
		$this->db->trans_start();

		// Insert into paymentsaccounts
		$this->db->insert('paymentsaccounts', $data);

		// Update depositStat in online_payments
		$this->db->where('id', $opID);
		$this->db->update('online_payments', ['status' => 'Verified']);

		// Complete transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			// Handle error
			$this->session->set_flashdata('danger', 'Payment processing failed. Please try again.');
		} else {
			$this->session->set_flashdata('success', 'Payment accepted and recorded successfully.');
		}

		redirect('Page/proof_payment_view');
	}

	public function denyOnlinePayment()
	{
		// Get form input
		$opID = $this->input->post('opID');
		$studentNumber = $this->input->post('StudentNumber');
		$denyReason = $this->input->post('denyReason');
		$deniedDate = $this->input->post('deniedDate');

		// Update depositStat in online_payments
		$this->db->where('opID', $opID);
		$this->db->update('online_payments', ['depositStat' => 'Denied']);

		// Insert into online_pay_deny
		$denyData = [
			'opID' => $opID,
			'StudentNumber' => $studentNumber,
			'denyReason' => $denyReason,
			'deniedDate' => $deniedDate
		];

		$this->db->insert('online_pay_deny', $denyData);

		// Set flash message and redirect
		$this->session->set_flashdata('success', 'Payment denied successfully.');
		redirect('Page/proof_payment_view');
	}


	function onlinePaymentsAll()
	{
		$result1['data1'] = $this->StudentModel->onlinePaymentsAll();
		$this->load->view('onlinePaymentsAll', $result1);
	}

	// For Enrollment (list of online enrollees pending validation)
	public function forValidation()
	{
		// Optional filters coming from POST (not used yet, but wired for future)
		$courseVal    = $this->input->post('course', TRUE);
		$yearlevelVal = $this->input->post('yearlevel', TRUE);
		$SY           = $this->session->userdata('sy');

		$result['data']         = $this->StudentModel->forValidation($SY);
		$result['course']       = $this->StudentModel->getCourse();
		$result['courseVal']    = $courseVal;
		$result['yearlevelVal'] = $yearlevelVal;

		$this->load->view('online_enrollees_for_validation', $result);
	}

	function personnel()
	{
		//Allowing access to Personnel only
		if ($this->session->userdata('level') === 'Personnel') {
			$this->load->view('dashboard_view');
		} else {
			echo "Access Denied";
		}
	}


	// function student()
	// {
	// 	//Allowing access to Stuent only
	// 	if ($this->session->userdata('level') === 'Student') {
	// 		$id = $this->session->userdata('username');
	// 		$sem = $this->session->userdata('semester');
	// 		$sy = $this->session->userdata('sy');

	// 		$result['data'] = $this->StudentModel->announcement();
	// 		$result['data1'] = $this->StudentModel->studeEnrollStat($id, $sy);
	// 		$result['data2'] = $this->StudentModel->studeBalance($id, $sy);
	// 		$result['data3'] = $this->StudentModel->semStudeCount($id);
	// 		$result['data4'] = $this->StudentModel->studeTotalSubjects($id, $sem, $sy);
	// 		$result['unreadCount'] = $this->EmailBlast_model->countUnreadMessages($id);

	// 		$this->load->view('dashboard_student', $result);
	// 	} else {
	// 		echo "Access Denied";
	// 	}
	// }



	public function student()
{
    // Allowing access to Student only
    if ($this->session->userdata('level') !== 'Student') {
        echo "Access Denied";
        return;
    }

    $id  = trim((string)$this->session->userdata('username'));   // StudentNumber
    $sem = $this->session->userdata('semester');
    $sy  = trim((string)$this->session->userdata('sy'));

    // Load model that contains isOverdueCandidate() and month helpers
    $this->load->model('AccountingModel', 'acct');

    // Flag: is this student in overdue_candidates for the current SY?
    $isFlagged = $this->acct->isOverdueCandidate($id, $sy);

    // Build month text if flagged
    $overdueMonthsText = '';
    if ($isFlagged) {
        $labels = $this->acct->getOverdueMonthLabelsForStudent($id, $sy); // e.g. ["June 2025","July 2025"]
        if (!empty($labels)) {
            $maxShow = 6;
            $overdueMonthsText = (count($labels) > $maxShow)
                ? implode(', ', array_slice($labels, 0, $maxShow)) . ' …'
                : implode(', ', $labels);
        }
    }

    // Prepare dashboard data (keep overdueMonthsText!)
    $result = [
        'isFlagged'         => $isFlagged,
        'overdueMonthsText' => $overdueMonthsText,
        'data'              => $this->StudentModel->announcement(),
        'data1'             => $this->StudentModel->studeEnrollStat($id, $sy),
        'data2'             => $this->StudentModel->studeBalance($id, $sy),
        'data3'             => $this->StudentModel->semStudeCount($id),
        'data4'             => $this->StudentModel->studeTotalSubjects($id, $sem, $sy),
        'unreadCount'       => $this->EmailBlast_model->countUnreadMessages($id),
    ];

    $this->load->view('dashboard_student', $result);
}

	function studeEnrollHistory()
	{
		$id = $this->session->userdata('username');
		$result['data'] = $this->StudentModel->admissionHistory($id);
		$this->load->view('stude_enroll_history', $result);
	}


// public function state_Account()
// {
//     $id      = trim((string)$this->session->userdata('username'));
//     $sy      = $this->input->get('sy');                      // SY selected in dropdown
//     $currSY  = trim((string)$this->session->userdata('sy')); // current SY in session

//     // Sidebar / overdue flag
//     $this->load->model('AccountingModel', 'acct');
//     $isFlagged = false;
//     if ($id !== '' && $currSY !== '') {
//         $isFlagged = $this->acct->isOverdueCandidate($id, $currSY);
//     }
//     $result['isFlagged'] = $isFlagged;

//     $result['syOptions']  = $this->StudentModel->getSYOptions($id);
//     $result['selectedSY'] = $sy;

//     if ($sy) {
//         $result['data']             = $this->StudentModel->statementAcct($id, $sy);   // fees
//         $result['data1']            = $this->StudentModel->statementAcct1($id, $sy);  // additional
//         $result['data2']            = $this->StudentModel->statementAcct2($id, $sy);  // discounts
//         $paymentsRaw                = $this->StudentModel->statementAcct3($id, $sy);  // payments (may include voids)
//         $result['letterhead']       = $this->SettingsModel->getSchoolInformation();
//         $result['school']           = !empty($result['letterhead']) ? $result['letterhead'][0] : null;
//         $result['monthlySchedule']  = $this->StudentModel->getMonthlySchedule($id, $sy);

//         // >>> ADDED: Filter out voids here (keeps your existing model untouched)
//         $result['data3'] = array_values(array_filter((array)$paymentsRaw, function($p) {
//             // accept only ORStatus == 'Valid' (tolerate missing field = treat as Valid)
//             return !isset($p->ORStatus) || strcasecmp((string)$p->ORStatus, 'Valid') === 0;
//         }));

//         // >>> ADDED: Compute clean totals from the lists we actually display
//         $totalFees = 0.0;
//         foreach ((array)$result['data'] as $r) { $totalFees += (float)($r->FeesAmount ?? 0); }

//         $totalAdd = 0.0;
//         foreach ((array)$result['data1'] as $r) { $totalAdd += (float)($r->add_amount ?? 0); }

//         $totalDiscount = 0.0;
//         foreach ((array)$result['data2'] as $r) { $totalDiscount += (float)($r->discount_amount ?? 0); }

//         $studentTotalPay = 0.0; // strictly Valid rows
//         foreach ((array)$result['data3'] as $r) { $studentTotalPay += (float)($r->Amount ?? 0); }

//         $studentComputedBalance = ($totalFees + $totalAdd) - ($studentTotalPay + $totalDiscount);
//         if ($studentComputedBalance < 0) { $studentComputedBalance = 0.0; }

//         // >>> ADDED: pass clean totals to view; leaves your other vars intact
//         $result['studentTotalPay']        = $studentTotalPay;
//         $result['studentComputedBalance'] = $studentComputedBalance;

//     } else {
//         $result['data'] = $result['data1'] = $result['data2'] = $result['data3'] = $result['monthlySchedule'] = [];
//         $result['letterhead'] = [];
//         $result['school']     = null;
//         // >>> ADDED defaults so the view never notices
//         $result['studentTotalPay']        = 0.0;
//         $result['studentComputedBalance'] = 0.0;
//     }

//     $this->load->view('account_statement', $result);
// }





public function state_Account()
{
    $id     = trim((string)$this->session->userdata('username'));
    $sy     = $this->input->get('sy');
    $currSY = trim((string)$this->session->userdata('sy'));

    // Sidebar / overdue flag
    $this->load->model('AccountingModel', 'acct');
    $result['isFlagged'] = ($id !== '' && $currSY !== '') ? $this->acct->isOverdueCandidate($id, $currSY) : false;

    // Always load school info & compute flag ONCE
    $result['letterhead'] = $this->SettingsModel->getSchoolInformation();
    $result['school']     = !empty($result['letterhead']) ? $result['letterhead'][0] : null;

    // SAFELY derive the toggle (default 0 if missing)
    $showOnline = 0;
    if (!empty($result['school']) && isset($result['school']->show_online_payments)) {
        $showOnline = (int)$result['school']->show_online_payments;
    }
    // If you have a dedicated getter, you could do:
    // $showOnline = (int)($this->SettingsModel->getSetting('show_online_payments') ?? $showOnline);

    $result['showOnlinePayments'] = ($showOnline === 1);

    // SY dropdown + selected
    $result['syOptions']  = $this->StudentModel->getSYOptions($id);
    $result['selectedSY'] = $sy;

    if ($sy) {
        $result['data']            = $this->StudentModel->statementAcct($id, $sy);   // fees
        $result['data1']           = $this->StudentModel->statementAcct1($id, $sy);  // additional
        $result['data2']           = $this->StudentModel->statementAcct2($id, $sy);  // discounts
        $paymentsRaw               = $this->StudentModel->statementAcct3($id, $sy);  // payments (may include voids)
        $result['monthlySchedule'] = $this->StudentModel->getMonthlySchedule($id, $sy);

        // Keep only Valid payments
        $result['data3'] = array_values(array_filter((array)$paymentsRaw, function($p) {
            return !isset($p->ORStatus) || strcasecmp((string)$p->ORStatus, 'Valid') === 0;
        }));

        // Clean totals
        $totalFees = 0.0;
        foreach ((array)$result['data'] as $r) { $totalFees += (float)($r->FeesAmount ?? 0); }

        $totalAdd = 0.0;
        foreach ((array)$result['data1'] as $r) { $totalAdd += (float)($r->add_amount ?? 0); }

        $totalDiscount = 0.0;
        foreach ((array)$result['data2'] as $r) { $totalDiscount += (float)($r->discount_amount ?? 0); }

        $studentTotalPay = 0.0;
        foreach ((array)$result['data3'] as $r) { $studentTotalPay += (float)($r->Amount ?? 0); }

        $studentComputedBalance = ($totalFees + $totalAdd) - ($studentTotalPay + $totalDiscount);
        if ($studentComputedBalance < 0) { $studentComputedBalance = 0.0; }

        $result['studentTotalPay']        = $studentTotalPay;
        $result['studentComputedBalance'] = $studentComputedBalance;

    } else {
        // No SY chosen yet – return safe empties
        $result['data'] = $result['data1'] = $result['data2'] = $result['data3'] = $result['monthlySchedule'] = [];
        $result['studentTotalPay']        = 0.0;
        $result['studentComputedBalance'] = 0.0;
    }

    $this->load->view('account_statement', $result);
}





	public function pre_assessment()
	{
		$data['yearLevels'] = $this->StudentModel->subjects();
		$data['selectedLevel'] = $this->input->post('yearLevel');
		$data['studentSelect'] = $this->input->post('studentSelect');
		$data['studentInput'] = $this->input->post('studentInput');

		// Determine which student name to use
		$data['studentName'] = !empty($data['studentSelect']) ? $data['studentSelect'] : $data['studentInput'];

		if ($this->input->post()) {
			$yearLevel = $data['selectedLevel'];
			$data['fees'] = $this->db->get_where('fees', ['YearLevel' => $yearLevel])->result();
		}

		$data['students'] = $this->StudentModel->get_all_students(); // Load this list
		$data['letterhead'] = $this->SettingsModel->getSchoolInformation();

		$this->load->view('pre_assessment_view', $data);
	}


	public function pre_assessment_form()
	{
		$data['courses'] = $this->db->get('course_table')->result();
		$this->load->view('pre_assessment_form', $data);
	}




	public function state_Account_Accounting()
{
    $studentNumber = $this->input->get('id'); // Get StudentNumber from GET
    if (!$studentNumber) { show_404(); }

    $sy       = $this->session->userdata('sy');        // Get current SY from session
    $semester = $this->session->userdata('semester');  // kept if you need later

    // school / student
    $result['selectedSY'] = $sy;
    $result['school']     = $this->SettingsModel->getSchoolInformation();
    $result['school']     = !empty($result['school']) ? $result['school'][0] : null;

    $this->db->where('StudentNumber', $studentNumber);
    $result['student'] = $this->db->get('studeprofile')->row();

    // data sets
    $result['data']            = $this->StudentModel->statementAcct($studentNumber, $sy);   // fees
    $result['data1']           = $this->StudentModel->statementAcct1($studentNumber, $sy);  // additional
    $result['data2']           = $this->StudentModel->statementAcct2($studentNumber, $sy);  // discounts
    $result['data3']           = $this->StudentModel->statementAcct3($studentNumber, $sy);  // payments (Valid ONLY)
    $result['monthlySchedule'] = $this->StudentModel->getMonthlySchedule($studentNumber, $sy);

    // year level (fallback)
    $yearLevel = (isset($result['data'][0]) && !empty($result['data'][0]->YearLevel))
        ? $result['data'][0]->YearLevel : 'Not Set';
    $result['yearLevel'] = $yearLevel;

    // -------- Totals computed ONLY from what will be displayed --------
    $totalFees = 0.0;
    foreach ($result['data'] as $r) { $totalFees += (float) ($r->FeesAmount ?? 0); }

    $totalAdd = 0.0;
    foreach ($result['data1'] as $r) { $totalAdd += (float) ($r->add_amount ?? 0); }

    $totalDiscount = 0.0;
    foreach ($result['data2'] as $r) { $totalDiscount += (float) ($r->discount_amount ?? 0); }

    $totalPay = 0.0; // sum of VALID payments only
    foreach ($result['data3'] as $r) { $totalPay += (float) ($r->Amount ?? 0); }

    $computedBalance = ($totalFees + $totalAdd) - ($totalPay + $totalDiscount);
    if ($computedBalance < 0) { $computedBalance = 0.0; }

    // pass totals to view
    $result['totalFees']       = $totalFees;
    $result['totalAdd']        = $totalAdd;
    $result['totalDiscount']   = $totalDiscount;
    $result['totalPay']        = $totalPay;           // use this for all "Total Payments"
    $result['computedBalance'] = $computedBalance;    // use this for "Remaining Balance"

    $this->load->view('account_statement_Accounting', $result);
}





public function recalcMonthlySchedule()
{
    if ($this->input->method() !== 'post') { show_error('Invalid method', 405); }

    $studentNumber    = $this->input->post('studentNumber');
    $sy               = $this->input->post('sy');
    $remainingBalance = (float) $this->input->post('remainingBalance'); // from view's computedBalance

    if (!$studentNumber || !$sy) { show_404(); }

    $this->db->trans_start();

    // If remaining balance is zero: mark ALL rows paid with amount 0.00
    if ($remainingBalance <= 0.0) {
        $this->db->where('StudentNumber', $studentNumber)
                 ->where('SY', $sy)
                 ->update('monthly_payment_schedule', [
                     'amount' => 0.00,
                     'status' => 'Paid',
                 ]);

        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('msg', 'Recalculation failed.');
            $this->session->set_flashdata('msg_type', 'danger');
        } else {
            $this->session->set_flashdata('msg', 'All schedule entries marked as Paid (₱0.00).');
            $this->session->set_flashdata('msg_type', 'success');
        }
        return redirect('Page/state_Account_Accounting?id='.$studentNumber);
    }

    // Otherwise: distribute remaining balance ONLY across PENDING rows (keep PAID rows as-is)
    $pending = $this->db->from('monthly_payment_schedule')
        ->where('StudentNumber', $studentNumber)
        ->where('SY', $sy)
        ->where('status !=', 'Paid')         // only pending-like rows
        ->order_by('month_due', 'ASC')
        ->get()->result();

    $n = count($pending);
    if ($n === 0) {
        $this->db->trans_complete();
        $this->session->set_flashdata('msg', 'No pending schedule rows to update.');
        $this->session->set_flashdata('msg_type', 'warning');
        return redirect('Page/state_Account_Accounting?id='.$studentNumber);
    }

    // Even split with 2-dec rounding; push any remainder to the last row
    $per       = floor(($remainingBalance / $n) * 100) / 100;  // truncate to 2dp
    $allocated = $per * $n;
    $remainder = round($remainingBalance - $allocated, 2);     // 0.00..0.01 precision fix

    foreach ($pending as $i => $row) {
        $amount = ($i === $n - 1) ? ($per + $remainder) : $per;
        $amount = max(0, round($amount, 2));

        $this->db->where('monID', $row->monID)
                 ->update('monthly_payment_schedule', [
                     'amount' => $amount,
                     'status' => $amount == 0.00 ? 'Paid' : 'Pending',
                 ]);
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === false) {
        $this->session->set_flashdata('msg', 'Recalculation failed.');
        $this->session->set_flashdata('msg_type', 'danger');
    } else {
        $this->session->set_flashdata('msg', 'Pending schedule re-distributed from Remaining Balance.');
        $this->session->set_flashdata('msg_type', 'success');
    }

    return redirect('Page/state_Account_Accounting?id='.$studentNumber);
}


	public function emailStudentAccount()
	{
		$studentNumber = $this->input->get('id');
		$sy = $this->session->userdata('sy');

		// Load student and school data
		$student = $this->db->where('StudentNumber', $studentNumber)->get('studeprofile')->row();
		$school = $this->SettingsModel->getSchoolInformation();
		$school = !empty($school) ? $school[0] : null;

		if (!$student || (empty($student->EmailAddress) && empty($student->p_email))) {
			$this->session->set_flashdata('msg', 'No recipient email found (student or parent).');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		// Load account data
		$fees       = $this->StudentModel->statementAcct($studentNumber, $sy);
		$additional = $this->StudentModel->statementAcct1($studentNumber, $sy);
		$discounts  = $this->StudentModel->statementAcct2($studentNumber, $sy);
		$payments   = $this->StudentModel->statementAcct3($studentNumber, $sy);

		$totalFees     = array_sum(array_column($fees, 'FeesAmount'));
		$totalAdd      = array_sum(array_column($additional, 'add_amount'));
		$totalDiscount = array_sum(array_column($discounts, 'discount_amount'));
		$totalPay      = array_sum(array_column($payments, 'Amount'));
		$balance       = ($totalFees + $totalAdd) - ($totalPay + $totalDiscount);

		// Compose email body
		$body = '<h2 style="color:#2b6cb0;">Statement of Account</h2>';
		$body .= '<p>Hello <strong>' . $student->FirstName . '</strong>,<br>Here is your account summary for SY <strong>' . $sy . '</strong>.</p>';

		// FEES
		$body .= '<h4 style="margin-top: 30px; color: #2b6cb0;">Fees</h4>';
		$body .= '<table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size: 14px;">';
		$body .= '<thead><tr style="background-color:#041188; color:white;"><th style="border:1px solid #ddd;">Fee Description</th><th style="border:1px solid #ddd;text-align:right;">Amount</th></tr></thead><tbody>';
		$zebra = false;
		foreach ($fees as $f) {
			$style = $zebra ? 'background-color:#f9f9f9;' : '';
			$body .= "<tr style='{$style}'><td style='border:1px solid #ddd;'>{$f->FeesDesc}</td><td style='border:1px solid #ddd; text-align:right;'>" . number_format($f->FeesAmount, 2) . "</td></tr>";
			$zebra = !$zebra;
		}
		$body .= "<tr style='background-color:#d9edf7;'><td style='border:1px solid #ddd;'><strong>Total Fees</strong></td><td style='border:1px solid #ddd; text-align:right;'><strong>" . number_format($totalFees, 2) . "</strong></td></tr>";
		$body .= '</tbody></table>';

		// ADDITIONAL FEES
		if (!empty($additional)) {
			$body .= '<h4 style="margin-top: 30px; color: #2b6cb0;">Additional Fees</h4>';
			$body .= '<table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size: 14px;">';
			$body .= '<thead><tr style="background-color:#041188; color:white;"><th style="border:1px solid #ddd;">Description</th><th style="border:1px solid #ddd;text-align:right;">Amount</th></tr></thead><tbody>';
			$zebra = false;
			foreach ($additional as $a) {
				$style = $zebra ? 'background-color:#f9f9f9;' : '';
				$body .= "<tr style='{$style}'><td style='border:1px solid #ddd;'>{$a->add_desc}</td><td style='border:1px solid #ddd; text-align:right;'>" . number_format($a->add_amount, 2) . "</td></tr>";
				$zebra = !$zebra;
			}
			$body .= "<tr style='background-color:#d9edf7;'><td style='border:1px solid #ddd;'><strong>Total Additional Fees</strong></td><td style='border:1px solid #ddd; text-align:right;'><strong>" . number_format($totalAdd, 2) . "</strong></td></tr>";
			$body .= '</tbody></table>';
		}

		// DISCOUNTS
		if (!empty($discounts)) {
			$body .= '<h4 style="margin-top: 30px; color: #2b6cb0;">Discounts</h4>';
			$body .= '<table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size: 14px;">';
			$body .= '<thead><tr style="background-color:#041188; color:white;"><th style="border:1px solid #ddd;">Discount Description</th><th style="border:1px solid #ddd;text-align:right;">Amount</th></tr></thead><tbody>';
			$zebra = false;
			foreach ($discounts as $d) {
				$style = $zebra ? 'background-color:#f9f9f9;' : '';
				$body .= "<tr style='{$style}'><td style='border:1px solid #ddd;'>{$d->discount_desc}</td><td style='border:1px solid #ddd; text-align:right; color:green;'>-" . number_format($d->discount_amount, 2) . "</td></tr>";
				$zebra = !$zebra;
			}
			$body .= "<tr style='background-color:#d9edf7;'><td style='border:1px solid #ddd;'><strong>Total Discounts</strong></td><td style='border:1px solid #ddd; text-align:right; color:green;'><strong>-" . number_format($totalDiscount, 2) . "</strong></td></tr>";
			$body .= '</tbody></table>';
		}

		// PAYMENTS
		if (!empty($payments)) {
			$body .= '<h4 style="margin-top: 30px; color: #2b6cb0;">Payments</h4>';
			$body .= '<table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size: 14px;">';
			$body .= '<thead><tr style="background-color:#041188; color:white;"><th style="border:1px solid #ddd;">Payment Details</th><th style="border:1px solid #ddd;text-align:right;">Amount</th></tr></thead><tbody>';
			$zebra = false;
			foreach ($payments as $p) {
				$style = $zebra ? 'background-color:#f9f9f9;' : '';
				$body .= "<tr style='{$style}'><td style='border:1px solid #ddd;'>Payment ({$p->description} - {$p->ORNumber})</td><td style='border:1px solid #ddd; text-align:right; color:red;'>-" . number_format($p->Amount, 2) . "</td></tr>";
				$zebra = !$zebra;
			}
			$body .= "<tr style='background-color:#d9edf7;'><td style='border:1px solid #ddd;'><strong>Total Payments</strong></td><td style='border:1px solid #ddd; text-align:right; color:red;'><strong>-" . number_format($totalPay, 2) . "</strong></td></tr>";
			$body .= '</tbody></table>';
		}

		// BALANCE
		$body .= "<h3 style='margin-top: 40px; text-align:right; color:#2b6cb0;'>Current Balance: <span style='font-weight:bold;'>" . number_format($balance, 2) . "</span></h3>";
		$body .= '<p style="margin-top: 30px;">Thank you!<br>' . htmlspecialchars($school->SchoolName) . ' </p>';

		// Prepare recipients
		$recipients = [];
		if (!empty($student->EmailAddress)) $recipients[] = $student->EmailAddress;
		if (!empty($student->p_email))      $recipients[] = $student->p_email;

		// Send Email
		$this->load->library('email');
		$this->email->from('noreply@srmsportal.com', $school->SchoolName);
		$this->email->to($recipients);
		$this->email->subject('Statement of Account - ' . $school->SchoolName);
		$this->email->set_mailtype('html');
		$this->email->message($body);

		if ($this->email->send()) {
			$this->session->set_flashdata('msg', 'Email successfully sent to student and parent.');
		} else {
			$this->session->set_flashdata('msg', 'Failed to send email. Please check email configuration.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}


	public function print_statement()
	{
		$id = $this->session->userdata('username');
		$sy = $this->input->get('sy');

		$data['letterhead'] = $this->SettingsModel->getSchoolInformation();
		$data['school'] = !empty($data['letterhead']) ? $data['letterhead'][0] : null;
		$data['data'] = $this->StudentModel->statementAcct($id, $sy);
		$data['data1'] = $this->StudentModel->statementAcct1($id, $sy);
		$data['data2'] = $this->StudentModel->statementAcct2($id, $sy);
		$data['data3'] = $this->StudentModel->statementAcct3($id, $sy);

		$this->load->view('print_statement', $data);
	}



	//stude account - Student Access
	function studeaccount()
	{
		if ($this->session->userdata('level') === 'Student') {
			$id = $this->session->userdata('username');
			$result['data'] = $this->StudentModel->studeaccountById($id);
			$this->load->view('account_tracking', $result);
		} else {
			$id = $this->input->get('id');
			$result['data'] = $this->StudentModel->studeaccountById($id);
			$this->load->view('account_tracking', $result);
		}
	}

	//stude account - Admin Access
	function studeaccountAdmin()
	{
		$id = $this->input->get('id');
		$result['data'] = $this->StudentModel->studeaccountById($id);
		$this->load->view('account_tracking_admin', $result);
	}

	function studepayments()
	{
		$result['letterhead'] = $this->Login_model->loginImage();

		$studentno = $this->input->get('studentno');
		$sem = $this->input->get('sem');
		$sy = $this->input->get('sy');
		$result['data'] = $this->StudentModel->studepayments($studentno, $sem, $sy);
		$this->load->view('stude_payments', $result);
	}



	function getOR()
	{
		$query = $this->db->query("select * from paymentsaccounts order by ID desc limit 1");
		return $query->result();
	}

	function UploadedPayments($id)
	{
		$query = $this->db->query("select * from online_payments where StudentNumber='" . $id . "'");
		return $query->result();
	}

	function UploadedPaymentsAdmin($id)
	{
		$query = $this->db->query("select * from online_payments op join studeprofile p on op.StudentNumber=p.StudentNumber where p.StudentNumber='" . $id . "' and op.depositStat='For Verification'");
		return $query->result();
	}

	function studegrades()
	{
		$this->load->view('student_grades');
	}

	function bdayToday()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['data'] = $this->StudentModel->birthdayCelebs($sem, $sy);
		$this->load->view('bday_today', $result);
	}

	//Masterlist by Sex
	function listBySex()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$sex = $this->input->get('sex');
		$result['data'] = $this->StudentModel->sexList($sy, $sex);
		$this->load->view('masterlist_by_sex', $result);
	}
	function bdayMonth()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$result['data'] = $this->StudentModel->birthdayMonths($sem, $sy);
		$this->load->view('bday_months', $result);
	}
	//online enrollment
	public function enrollment()
	{
		$schoolInfo = $this->SettingsModel->getSchoolInformation();
		$result['letterhead'] = $schoolInfo;
		$result['schoolType'] = $schoolInfo[0]->schoolType ?? '';

		// Get user session data
		$studentNumber = $this->session->userdata('username');
		$email         = $this->session->userdata('email');
		$currentSY     = $this->session->userdata('sy');

		// 1) Already enrolled in semesterstude for CURRENT SY?
		$enroll_row = $this->db
			->where('StudentNumber', $studentNumber)
			->where('SY', $currentSY)
			->get('semesterstude')
			->row();

		// 2) Existing online_enrollment submission for CURRENT SY (for showing "For Validation" state & editing)
		$online_row = $this->db->get_where('online_enrollment', [
			'StudentNumber' => $studentNumber,
			'SY'            => $currentSY
		])->row();

		// If form was submitted (create or update)
		if ($this->input->post('enroll')) {

			// If already enrolled to semesterstude, still block (they're already official)
			if ($enroll_row) {
				$this->session->set_flashdata(
					'msg',
					'<div class="alert alert-danger text-center"><b>You are currently enrolled in this semester.</b></div>'
				);
				redirect('Page/enrollment');
				return;
			}

			// Get submitted form data (XSS filtered)
			$StudentNumber = $this->input->post('StudentNumber', TRUE);
			$Course        = $this->input->post('Course', TRUE);
			$YearLevel     = $this->input->post('YearLevel', TRUE);
			$SY            = $this->input->post('SY', TRUE);
			$strand        = $this->input->post('strand', TRUE);

			$data = [
				'StudentNumber'   => $StudentNumber,
				'Course'          => $Course,
				'YearLevel'       => $YearLevel,
				'SY'              => $SY,
				'enrolStatus'     => 'For Validation',
				'downPaymentStat' => 'Unpaid',
				'strand'          => $strand
			];

			// If there is already a row in online_enrollment for this SY, UPDATE instead of blocking
			$exists = $this->db->get_where('online_enrollment', [
				'StudentNumber' => $StudentNumber,
				'SY'            => $SY
			])->row();

			if ($exists) {
				$this->db->where('StudentNumber', $StudentNumber)
					->where('SY', $SY)
					->update('online_enrollment', $data);

				$msgHtml = '<div class="alert alert-success text-center"><b>Your submission has been updated and is queued for validation.</b></div>';
			} else {
				$this->db->insert('online_enrollment', $data);
				$msgHtml = '<div class="alert alert-success text-center"><b>Your data has been successfully submitted for validation.</b></div>';
			}

			// Prepare email — get student name from profile (first row only)
			$profileRows = $this->StudentModel->displayrecordsById($studentNumber);
			$firstRow    = is_array($profileRows) && !empty($profileRows) ? $profileRows[0] : null;
			$fname       = $firstRow ? $firstRow->FirstName : 'Student';

			// Send email notification (optional on update)
			$this->load->config('email');
			$this->load->library('email');

			$mail_message  = "Dear {$fname},<br><br>";
			$mail_message .= "Your enrollment data has been " . ($exists ? "updated" : "submitted") . " for validation.<br>";
			$mail_message .= "Course/Department: <b>{$Course}</b><br>";
			if (!empty($strand)) $mail_message .= "Strand: <b>{$strand}</b><br>";
			$mail_message .= "Year Level: <b>{$YearLevel}</b><br>";
			$mail_message .= "School Year: <b>{$SY}</b><br>";
			$mail_message .= "Status: <b>For Validation</b><br><br>";
			$mail_message .= "You will be notified once validated.<br><br>Thanks & Regards,<br>SRMS - Online";

			$this->email->from('no-reply@srmsportal.com', 'SRMS Online Team');
			$this->email->to($email);
			$this->email->subject('Enrollment');
			$this->email->message($mail_message);
			@$this->email->send(); // ignore failure

			$this->session->set_flashdata('msg', $msgHtml);
			redirect('Page/enrollment');
			return;
		}

		// Load data for the form / enrolled view
		$courseVal              = $this->input->post('course', TRUE);
		$yearlevelVal           = $this->input->post('yearlevel', TRUE);
		$result['data']         = $this->StudentModel->displayrecordsById($studentNumber);
		$result['course']       = $this->StudentModel->getCourse();
		$result['track']        = $this->SettingsModel->strandList();
		$result['courseVal']    = $courseVal;
		$result['yearlevelVal'] = $yearlevelVal;

		// pass statuses to the view
		$result['enrolled']     = $enroll_row ? true : false; // enrolled in semesterstude
		$result['enroll_row']   = $enroll_row;
		$result['online_row']   = $online_row;                // existing online_enrollment row (if any)

		$this->load->view('enrollment_form', $result);
	}



	//final processing of enrollment
	public function enrollmentAcceptance()
	{
		$courseVal = $this->input->post('course');
		$yearlevelVal = $this->input->post('yearlevel');
		$result = [
			'course' => $this->StudentModel->getCourse(),
			'track' => $this->SettingsModel->strandList(),
			'courseVal' => $courseVal,
			'yearlevelVal' => $yearlevelVal
		];

		if ($this->input->post('submit')) {
			$data = [
				'StudentNumber'  => $this->input->post('StudentNumber'),
				'Course'         => $this->input->post('Course'),
				'YearLevel'      => $this->input->post('YearLevel'),
				'Status'         => 'Enrolled',
				'StudeStatus'         => $this->input->post('Status'),
				'Adviser'         => $this->input->post('Adviser'),
				'IDNumber'         => $this->input->post('IDNumber'),
				'Track'          => "",
				'Qualification'  => $this->input->post('Qualification'),
				'Semester'       => $this->input->post('Semester'),
				'SY'             => $this->input->post('SY'),
				'Section'        => $this->input->post('Section'),
				'BalikAral'      => $this->input->post('BalikAral'),
				'IP'             => $this->input->post('IP'),
				'FourPs'         => $this->input->post('FourPs'),
				'Repeater'       => $this->input->post('Repeater'),
				'Transferee'     => $this->input->post('Transferee'),
				'EnrolledDate'   => date("Y-m-d")
			];

			$exists = $this->db->get_where('semesterstude', [
				'StudentNumber' => $data['StudentNumber'],
				'SY'            => $data['SY']
			])->num_rows();

			if ($exists) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>The selected student is currently enrolled!</b></div>');
				redirect('Page/profileList');
			} else {
				$this->db->insert('semesterstude', $data);
				$this->db->update('online_enrollment', ['enrolStatus' => 'Verified'], [
					'StudentNumber' => $data['StudentNumber'],
					'SY'            => $data['SY']
				]);

				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>The enrollment details have been successfully processed.</b></div>');
				redirect('Masterlist/enrolledList');
			}
		}

		$this->load->view('enrollment_form_final', $result);
	}




	// function enroll()
	// {
	// 	//get data from the form
	// 	$StudentNumber = $this->input->post('StudentNumber');
	// 	$Semester = $this->input->post('Semester') ?? '';
	// 	$SY = $this->input->post('SY');

	// 	$EnrolledDate = date("Y-m-d");
	// 	//check if record exist
	// 	$que = $this->Common->three_cond_count_row('semesterstude', 'StudentNumber', $StudentNumber, 'Semester', $Semester, 'SY', $SY);
	// 	$this->Ren_model->online_enrollment_update();
	// 	$row = $que->num_rows();
	// 	if ($row) {
	// 		$this->session->set_flashdata('msg', $this->danger('The selected student is currently enrolled!'));
	// 		redirect('Masterlist/enrolledList');
	// 	} else {
	// 		$this->Ren_model->enroll_insert();
	// 		$this->Ren_model->online_enrollment_update();
	// 		$this->session->set_flashdata('msg', $this->success('Enrollment details have been processed successfully.'));
	// 		redirect('Masterlist/enrolledList');
	// 	}
	// }

	public function enroll()
	{
		// get data from the form
		$StudentNumber = $this->input->post('StudentNumber');
		$SY            = $this->input->post('SY');
		$EnrolledDate  = date("Y-m-d");

		// check if record exists (by StudentNumber and SY only)
		$que = $this->Common->two_cond_count_row(
			'semesterstude',
			'StudentNumber',
			$StudentNumber,
			'SY',
			$SY
		);

		if ($que->num_rows()) {
			$this->session->set_flashdata('msg', $this->danger('The selected student is currently enrolled!'));
			redirect('Masterlist/enrolledList');
		} else {
			$this->Ren_model->enroll_insert();
			$this->Ren_model->online_enrollment_update();
			$this->session->set_flashdata('msg', $this->success('Enrollment details have been processed successfully.'));
			redirect('Masterlist/enrolledList');
		}
	}


	//Fetch Year Level depending on the selected department
	function fetch_yearlevel()
	{

		if ($this->input->post('course')) {
			$output = '<option value=""></option>';
			$yearlevel = $this->StudentModel->getYearLevel($this->input->post('course'));
			foreach ($yearlevel as $row) {
				$output .= '<option value ="' . $row->Major . '">' . $row->Major . '</option>';
			}
			echo $output;
		}
	}


	public function fetch_section()
	{
		if ($this->input->post('yearlevel')) {
			$output = '<option value=""></option>';
			$sections = $this->StudentModel->getSectionsByYearLevel($this->input->post('yearlevel'));
			foreach ($sections as $row) {
				$output .= '<option value="' . $row->Section . '">' . $row->Section . '</option>';
			}
			echo $output;
		}
	}
	public function fetch_adviser_id()
	{
		$section = $this->input->post('section');
		$yearLevel = $this->input->post('yearlevel'); // Get year level from request
		$schoolYear = $this->session->userdata('sy'); // Get SY from session

		if ($section && $yearLevel && $schoolYear) {
			$adviserID = $this->StudentModel->getAdviserByCriteria($section, $yearLevel, $schoolYear);

			log_message('debug', 'Adviser ID: ' . print_r($adviserID, true)); // Debugging

			if (!empty($adviserID)) {
				echo htmlspecialchars($adviserID->IDNumber, ENT_QUOTES);
			} else {
				echo ''; // Return empty if no adviser found
			}
		}
	}

	public function fetch_adviser_name()
	{
		$section = $this->input->post('section');
		$yearLevel = $this->input->post('yearlevel'); // Get year level from request
		// $schoolYear = $this->session->userdata('sy'); // Get SY from session

		if ($section && $yearLevel) {
			$adviserID = $this->StudentModel->getAdviserByCriteria($section, $yearLevel);

			if (!empty($adviserID)) {
				$staff = $this->StudentModel->getStaffByID($adviserID->IDNumber);
				if (!empty($staff)) {
					$fullName = htmlspecialchars($staff->FirstName, ENT_QUOTES) . ' ' .
						htmlspecialchars($staff->MiddleName, ENT_QUOTES) . ' ' .
						htmlspecialchars($staff->LastName, ENT_QUOTES);
					echo $fullName;
				} else {
					echo 'Adviser not found';
				}
			} else {
				echo 'No Adviser found for the selected criteria';
			}
		}
	}






	public function fetchStrand()
	{
		if ($this->input->post('track')) {
			$output = '<option value="">Select Strand</option>'; // Set default option
			$strand = $this->StudentModel->getStrand($this->input->post('track')); // Fetch strands based on track
			foreach ($strand as $row) {
				$output .= '<option value ="' . $row->strand . '">' . $row->strand . '</option>'; // Append each strand
			}
			echo $output; // Output the options
		}
	}



	//update online enrollees
	public function update_online_enrollees()
	{
		$id = $this->input->get('id');
		$this->StudentModel->updateEnrollees($id);
		redirect("Page/admin");
	}


	public function UpdateStudeNo()
	{
		$originalStudentNumber = $this->input->post('originalStudentNumber');
		$newStudentNumber = $this->input->post('studentNumber');

		if ($originalStudentNumber && $newStudentNumber) {
			$this->StudentModel->updateStudentNumber($originalStudentNumber, $newStudentNumber);

			$this->session->set_flashdata('success', '<div class="alert alert-success text-center"><b>Student number updated successfully.</b></div>');
			redirect("Page/studentsprofile?id=" . urlencode($newStudentNumber));
		} else {
			$this->session->set_flashdata('danger', '<div class="alert alert-danger text-center"><b>Failed to update student number. Please try again.</b></div>');
			redirect($_SERVER['HTTP_REFERER']); // Redirect back to the previous page
		}
	}


	// public function UpdateStudeNo()
	// {
	// 	$originalStudentNumber = $this->input->post('originalStudentNumber');
	// 	$newStudentNumber = $this->input->post('studentNumber');

	// 	if ($originalStudentNumber && $newStudentNumber) {
	// 		$this->StudentModel->updateStudentNumber($originalStudentNumber, $newStudentNumber);
	// 		redirect("Page/studentsprofile?id=" . urlencode($newStudentNumber));
	// 	} else {
	// 		// Handle error if necessary
	// 	}
	// }

	public function studentsprofile()
	{
		$userLevel = $this->session->userdata('level');
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');

		if ($userLevel === 'Student') {
			$id = $this->session->userdata('username');
		} else {
			$id = $this->input->get('id');
		}

		$studeno = $id;
		$studentNumber = $id;

		// Load common data
		$result['data'] = $this->StudentModel->displayrecordsById($id);
		$result['data1'] = $this->StudentModel->profilepic($id);


		$result['data2'] = $this->StudentModel->getStudentRequirements($studentNumber);

		// Check for grade filter
		$grade = $this->input->post('grade');
		if (empty($grade)) {
			$result['data3'] = $this->StudentModel->studeGrades($studeno, $sy);
		} else {
			$result['data3'] = $this->StudentModel->studeGrades($studeno, $grade);
		}

		$result['data4'] = $this->StudentModel->studeaccountById($id);
		$result['data5'] = $this->StudentModel->admissionHistory($id);
		$result['data6'] = $this->StudentModel->studerequest($id);

		if ($userLevel !== 'Student') {
			$result['data7'] = $this->SettingsModel->getSchoolInfo();
		}

		$this->load->view('profile_page', $result);
	}

	public function sendGradesToEmail()
	{
		$studentNumber = $this->input->get('id');
		$sy = $this->session->userdata('sy');

		$student = $this->db->where('StudentNumber', $studentNumber)->get('studeprofile')->row();
		$school = $this->SettingsModel->getSchoolInformation();
		$school = !empty($school) ? $school[0] : null;

		if (!$student || (empty($student->EmailAddress) && empty($student->p_email))) {
			$this->session->set_flashdata('error', 'Student or parent email not found.');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		// Load grades
		$grades = $this->StudentModel->studeGrades($studentNumber, $sy);

		// Compose email body
		$body = '<h2 style="color:#2b6cb0;">Student Grades</h2>';
		$body .= '<p>Hi <strong>' . $student->FirstName . '</strong>,<br>Below are your grades for School Year <strong>' . $sy . '</strong>.</p>';
		$body .= '<table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size: 14px;">';
		$body .= '<thead><tr style="background-color:#041188; color:white;">
                <th style="border:1px solid #ddd;">Subject Code</th>
                <th style="border:1px solid #ddd;">Description</th>
                <th style="border:1px solid #ddd;">Teacher</th>
                <th style="border:1px solid #ddd;text-align:center;">1st</th>
                <th style="border:1px solid #ddd;text-align:center;">2nd</th>
                <th style="border:1px solid #ddd;text-align:center;">3rd</th>
                <th style="border:1px solid #ddd;text-align:center;">4th</th>
                <th style="border:1px solid #ddd;text-align:center;">Average</th>
              </tr></thead><tbody>';

		$zebra = false;
		foreach ($grades as $g) {
			$style = $zebra ? 'background-color:#f9f9f9;' : '';
			$body .= "<tr style='{$style}'>
            <td style='border:1px solid #ddd;'>{$g->SubjectCode}</td>
            <td style='border:1px solid #ddd;'>{$g->Description}</td>
            <td style='border:1px solid #ddd;'>{$g->Instructor}</td>
            <td style='border:1px solid #ddd;text-align:center;'>" . number_format($g->PGrade, 2) . "</td>
            <td style='border:1px solid #ddd;text-align:center;'>" . number_format($g->MGrade, 2) . "</td>
            <td style='border:1px solid #ddd;text-align:center;'>" . number_format($g->PFinalGrade, 2) . "</td>
            <td style='border:1px solid #ddd;text-align:center;'>" . number_format($g->FGrade, 2) . "</td>
            <td style='border:1px solid #ddd;text-align:center;'><strong>" . number_format($g->Average, 2) . "</strong></td>
        </tr>";
			$zebra = !$zebra;
		}

		$body .= '</tbody></table>';
		$body .= '<p>Thank you!<br>' . htmlspecialchars($school->SchoolName) . ' </p>';

		// Prepare recipients
		$recipients = [];
		if (!empty($student->EmailAddress)) $recipients[] = $student->EmailAddress;
		if (!empty($student->p_email)) $recipients[] = $student->p_email;

		// Send Email
		$this->load->library('email');
		$this->email->from('noreply@srmsportal.com', $school->SchoolName);
		$this->email->to($recipients);
		$this->email->subject('Your Grades - SY ' . $sy);
		$this->email->message($body);

		if ($this->email->send()) {
			$this->session->set_flashdata('success', 'Grades emailed successfully to student and parent.');
		} else {
			$this->session->set_flashdata('success', 'Failed to send email. Please check configuration.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}



	//Staff Profile
	function staffprofile()
	{
		if ($this->session->userdata('level') === 'Admin') {
			$id = $this->input->get('id');
		} elseif ($this->session->userdata('level') === 'HR Admin') {
			$id = $this->input->get('id');
		} else {
			$id = $this->session->userdata('username');
		}

		$result['data'] = $this->StudentModel->staffProfile($id);

		$result['data1'] = $this->StudentModel->profilepic($id);
		$result['data2'] = $this->PersonnelModel->family($id);
		$result['data3'] = $this->PersonnelModel->education($id);
		$result['data4'] = $this->PersonnelModel->cs($id);
		$result['data5'] = $this->PersonnelModel->trainings($id);
		$result['data6'] = $this->PersonnelModel->viewfiles($id);
		$this->load->view('profile_page_staff', $result);
	}

	public function del_201($param)
	{
		$result['img'] = $this->PersonnelModel->get_single_table_by_id("hris_files", 'fileID', $param);
		$filename = $result['img']['fileName'];
		$id = $result['img']['fileID'];
		$this->PersonnelModel->delete_group($param, $filename, '201files', "hris_files");
		$this->session->set_flashdata('danger', ' 201 File deleted successfully!');
		redirect(base_url() . 'Page/staffprofile?id=' . $id);
	}

	function notification_error()
	{
		$this->load->view('notification_error');
	}

	function uploadrequirements()
	{
		$id = $this->session->userdata('username');
		$result['data'] = $this->StudentModel->requirements($id);
		$this->load->view('upload_requirements', $result);
	}

	public function upload()
	{
		$config['upload_path'] = './upload/requirements/';
		$config['allowed_types'] = 'pdf|jpeg|jpg|png';
		$config['max_size'] = 5120;
		//$config['max_width'] = 1500;
		//$config['max_height'] = 1500;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('nonoy')) {
			$msg = array('error' => $this->upload->display_errors());

			$this->load->view('uploadrequirements', $msg);
		} else {
			$data = array('image_metadata' => $this->upload->data());
			//get data from the form
			$StudentNumber = $this->input->post('StudentNumber');
			//$filename=$this->input->post('nonoy');
			$filename = $this->upload->data('file_name');
			$docName = $this->input->post('docName');
			$date = date("Y-m-d");
			$que = $this->db->query("insert into online_requirements (StudentNumber, fileAttachment, dateUploaded, docName ) values('$StudentNumber','$filename','$date','$docName')");
			$this->session->set_flashdata('success', 'One (1) file uploaded successfully.');
			redirect('Page/uploadrequirements');
		}
	}




	// public function uploadPayments()
	// {
	// 	$config['upload_path'] = './upload/payments';
	// 	$config['allowed_types'] = '*';
	// 	$config['max_size'] = 5120;
	// 	//$config['max_width'] = 1500;
	// 	//$config['max_height'] = 1500;

	// 	$this->load->library('upload', $config);

	// 	if (!$this->upload->do_upload('nonoy')) {
	// 		$msg = array('error' => $this->upload->display_errors());

	// 		$this->load->view('upload_payments', $msg);
	// 	} else {
	// 		$data = array('image_metadata' => $this->upload->data());
	// 		$StudentNumber = $this->input->post('StudentNumber');
	// 		$filename = $this->upload->data('file_name');
	// 		$amountPaid = $this->input->post('amountPaid');
	// 		$depositStat = $this->input->post('depositStat');
	// 		$sem = $this->input->post('sem');
	// 		$sy = $this->input->post('sy');
	// 		$date = date("Y-m-d");
	// 		$payment_for = $this->input->post('payment_for');
	// 		$note = $this->input->post('note');

	// 		$que = $this->db->query("insert into online_payments values('','$StudentNumber','$filename','$amountPaid','$depositStat','$sem','$sy','$date','$payment_for','$note')");

	// 		$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Uploaded Succesfully!</b></div>');
	// 		//$this->load->view('upload_payments');

	// 		$id = $this->input->post('StudentNumber');
	// 		$fname = $this->session->userdata('fname');
	// 		$email = $this->session->userdata('email');

	// 		$result1['data1'] = $this->StudentModel->UploadedPayments($id);
	// 		$result1['data'] = $this->StudentModel->getSemesterfromOE($id);
	// 		//$this->load->view('upload_payments',$result1);
	// 		redirect('Page/proof_payment');

	//Email Notification
	//$this->load->config('email');
	//$this->load->library('email');
	//$mail_message = 'Dear ' . $fname . ',' . "\r\n"; 
	//$mail_message .= '<br><br>Thank you for the payment you made with the following details:' . "\r\n"; 
	//$mail_message .= '<br>Amount Paid: <b>' . $amountPaid . '</b>' ."\r\n";
	//$mail_message .= '<br>Payment For: <b>' . $payment_for . '</b>'."\r\n";
	//$mail_message .= '<br>Applicable Sem/SY: <b>' . $sem . ', '. $sy .'</b>'."\r\n";
	//$mail_message .= '<br>Date Uploaded: <b>' . $date . '</b>' . "\r\n";
	//$mail_message .= '<br>Note: <b>' . $note . '</b>' . "\r\n";
	//$mail_message .= '<br><br>Your payment has to be manually reviewed. You will be notified once verified.' ."\r\n";
	//$mail_message .= '<br><br>Thanks & Regards,';
	//$mail_message .= '<br>SRMS - Online';

	//$this->email->from('no-reply@lxeinfotechsolutions.com', 'SRMS Online Team')
	//	->to($email)
	//	->subject('Payment Uploaded')
	//	->message($mail_message);
	//	$this->email->send();
	// 	}
	// }

	//Profile List
	function profileList()
	{
		$result['data'] = $this->StudentModel->getProfile();

		$this->load->view('profile_list', $result);
	}

	function profileListEncoder()
	{
		$username = $this->session->userdata('username');
		$result['data'] = $this->StudentModel->getProfileEncoder($username);
		$this->load->view('profile_list_encoder', $result);
	}

	//Profile List for Enrollment
	function profileForEnrollment()
	{
		$result['data'] = $this->StudentModel->getProfile();
		$this->load->view('profile_list_for_enrollment', $result);
	}
	//Contact Directory
	function studeDirectory()
	{
		$result['data'] = $this->StudentModel->getProfile();
		$this->load->view('contact_directory', $result);
	}

	function fetch_major()
	{

		if ($this->input->post('course')) {
			$output = '<option value=""></option>';
			$yearlevel = $this->StudentModel->getMajor($this->input->post('course'));
			foreach ($yearlevel as $row) {
				$output .= '<option value ="' . $row->Major . '">' . $row->Major . '</option>';
			}
			echo $output;
		}
	}
	function changepassword()
	{
		$this->load->view('change_pass');
	}

	function update_password()
	{

		$this->form_validation->set_rules('currentpassword', 'Current Password', 'required|trim|callback__validate_currentpassword');
		$this->form_validation->set_rules('newpassword', 'New Password', 'required|trim|min_length[8]|alpha_numeric');
		$this->form_validation->set_rules('cnewpassword', 'Confirm New Password', 'required|trim|matches[newpassword]');

		$this->form_validation->set_message('required', "Please fill-up the form completely!");
		if ($this->form_validation->run()) {

			$username = $this->session->userdata('username');
			$newpass = sha1($this->input->post('newpassword'));
			if ($this->StudentModel->reset_userpassword($username, $newpass)) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Succesfully changed password</div>');
				$this->load->view('change_pass');
			} else {
				echo "Error";
			}
		} else {
			$this->session->set_flashdata('msg', '');
			$this->load->view('change_pass');
		}
	}

	function _validate_currentpassword()
	{
		$username = $this->session->userdata('username');
		$currentpass = sha1($this->input->post('currentpassword'));
		if ($this->StudentModel->is_current_password($username, $currentpass)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_validate_currentpassword', 'Your current password is incorrect!');
			return FALSE;
		}
	}

	public function acceeptPayment()
	{
		$sy = $this->session->userdata('sy');
		$opID = $this->input->post('opID'); // Ensure opID is captured
		$data = [
			'data'  => $this->StudentModel->getOR(),
			'data4' => $this->StudentModel->forPaymentVerCount($sy)
		];

		$this->load->view('payment_form', $data);

		if ($this->input->post('submit')) {
			// Retrieve form data
			$paymentData = [
				'StudentNumber'      => $this->input->post('StudentNumber'),
				'Course'            => $this->input->post('Course'),
				'PDate'             => date("Y-m-d"),
				'ORNumber'          => $this->input->post('ORNumber'),
				'Amount'            => $this->input->post('Amount'),
				'description'       => $this->input->post('description'),
				'PaymentType'       => $this->input->post('PaymentType'),
				'CheckNumber'       => '',
				'SY'                => $this->input->post('SY'),
				'CollectionSource'  => "Student's Account",
				'Bank'              => $this->input->post('Bank'),
				'ORStatus'          => 'Valid',
				'Cashier'           => $this->session->userdata('username'),
				'YearLevel'         => $this->input->post('YearLevel'),
				'settingsID'        => '1'
			];

			// Check for duplicate ORNumber
			if ($this->db->where('ORNumber', $paymentData['ORNumber'])->count_all_results('paymentsaccounts') > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Duplicate O.R. Number</b></div>');
				redirect('Page/acceeptPayment');
			}

			// Insert payment details
			$this->db->insert('paymentsaccounts', $paymentData);

			// Update online_enrollment status
			$this->db->where([
				'StudentNumber' => $paymentData['StudentNumber'],
				'SY'            => $paymentData['SY']
			])->update('online_enrollment', ['downPaymentStat' => 'Paid', 'downPayment' => $paymentData['Amount']]);

			// Ensure opID is valid before updating online_payments
			if (!empty($opID)) {
				$this->db->where('opID', $opID)->update('online_payments', ['depositStat' => 'Verified']);
			}

			// Success message
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>The payment details have been processed successfully.</b></div>');
			redirect('Page/proof_payment_view');
		}
	}
function profileEntry()
{
    // Load necessary data from SettingsModel
    $data['ethnicity'] = $this->SettingsModel->get_ethnicity();
    $data['religion'] = $this->SettingsModel->get_religion();
    $data['prevschool'] = $this->SettingsModel->get_prevschool();
    $data['provinces'] = $this->StudentModel->get_provinces();
    $data['addressData'] = $this->StudentModel->get_address_data();

    // Auto-generate the Student Number
    $data['autoStudentNumber'] = $this->StudentModel->generate_student_number();

    // Pass the data to the view
    $this->load->view('profile_form', $data);

    // Process form submission
    if ($this->input->post('submit')) {
        // Get and format data from the form
        $data = [
            'StudentNumber' => $data['autoStudentNumber'], // Use the auto-generated student number
            'LRN' => $this->input->post('LRN'),
            'FirstName' => strtoupper($this->input->post('FirstName')),
            'MiddleName' => strtoupper($this->input->post('MiddleName')),
            'LastName' => strtoupper($this->input->post('LastName')),
            'nameExt' => $this->input->post('nameExt'),
            'Sex' => $this->input->post('Sex'),
            'CivilStatus' => $this->input->post('CivilStatus'),
            'Citizenship' => $this->input->post('Citizenship'),
            'BloodType' => $this->input->post('BloodType'),
            'Religion' => $this->input->post('Religion'),
            'BirthPlace' => $this->input->post('BirthPlace'),
            'BirthDate' => $this->input->post('BirthDate'),
            'Age' => $this->input->post('Age'),
            'Ethnicity' => $this->input->post('Ethnicity'),
            'Elementary' => $this->input->post('Elementary'),
            'TelNumber' => $this->input->post('TelNumber'),
            'MobileNumber' => $this->input->post('MobileNumber'),
            'EmailAddress' => $this->input->post('EmailAddress'),
            'Province' => $this->input->post('Province'),
            'City' => $this->input->post('City'),
            'Brgy' => $this->input->post('Brgy'),
            'Sitio' => $this->input->post('Sitio'),
            'Guardian' => $this->input->post('Guardian'),
            'GuardianContact' => $this->input->post('GuardianContact'),
            'GuardianAddress' => $this->input->post('GuardianAddress'),
            'GuardianRelationship' => $this->input->post('GuardianRelationship'),
            'GuardianTelNo' => $this->input->post('GuardianTelNo'),
            'guardianOccupation' => $this->input->post('guardianOccupation'),
            'Father' => $this->input->post('Father'),
            'FOccupation' => $this->input->post('FOccupation'),
            'fContactNo' => $this->input->post('fContactNo'),
            'mContactNo' => $this->input->post('mContactNo'),
            'Mother' => $this->input->post('Mother'),
            'MOccupation' => $this->input->post('MOccupation'),
            'Notes' => $this->input->post('Notes'),
            'with_specialneeds' => $this->input->post('with_specialneeds'),
            'specialneeds' => $this->input->post('specialneeds'),
            'p_email' => $this->input->post('p_email'),
        ];

        $completeName = $data['FirstName'] . ' ' . $data['LastName'];
        $Encoder = $this->session->userdata('username');
        $Password = sha1($data['BirthDate']);
        $now = date('H:i:s A');

        // Check if StudentNumber already exists
        $exists = $this->db->where('StudentNumber', $data['StudentNumber'])->count_all_results('studeprofile');

        // Also check if a record with the same FirstName and LastName exists
        $existsByName = $this->db->where('FirstName', $data['FirstName'])
                                 ->where('LastName', $data['LastName'])
                                 ->count_all_results('studeprofile');

        // If either exists, set error message and redirect
        if ($exists || $existsByName) {
            $this->session->set_flashdata('danger', 'Student Number or Name already exists.');
            redirect('Page/profileEntry');
        } else {
            // Save profile to the database
            $this->db->insert('studeprofile', array_merge($data, [
                'Encoder' => $Encoder,
                'EmailAddress' => $data['EmailAddress'],
            ]));

            // Insert user into o_users table for login credentials
            $this->db->insert('o_users', [
                'username' => $data['StudentNumber'],
                'password' => $Password,
                'position' => 'Student',
                'fName' => $data['FirstName'],
                'mName' => $data['MiddleName'],
                'lName' => $data['LastName'],
                'email' => $data['EmailAddress'],
                'avatar' => 'avatar.png',
                'acctStat' => 'active',
                'dateCreated' => date("Y-m-d"),
                'IDNumber' => $data['StudentNumber'],
            ]);

            // Log to the activity trail with the student's full name
            $this->db->insert('atrail', [
                'atDesc' => 'Created profile and user account for ' . $completeName,
                'atDate' => date("Y-m-d"),
                'atTime' => $now,
                'atRes' => $Encoder,
                'atSNo' => $data['StudentNumber'],
            ]);

            // Prepare email content for student
            $this->load->config('email');
            $this->load->library('email');
            $this->load->model('SettingsModel');

            $schoolInfo = $this->SettingsModel->getSchoolInfo();
            $schoolName = $schoolInfo->SchoolName ?? 'Your School';
            $portalUrl = base_url();
            $studentEmail = $data['EmailAddress'];
            $parentEmail = $data['p_email'];

            $mail_message = "
                <div style='font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                        <h2 style='color: #2c3e50;'>$schoolName</h2>
                        <p style='font-size: 14px; color: #666;'>Welcome to $schoolName!</p>
                    </div>

                    <p>Dear <strong>{$data['FirstName']}</strong>,</p>
                    <p>Your student profile has been successfully created. Below are your login credentials:</p>

                    <table style='width: 100%; border-collapse: collapse; margin-top: 15px;'>
                        <tr style='background-color: #f2f2f2;'>
                            <td style='padding: 10px; border: 1px solid #ddd;'><strong>Username</strong></td>
                            <td style='padding: 10px; border: 1px solid #ddd;'>{$data['StudentNumber']}</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border: 1px solid #ddd;'><strong>Password</strong></td>
                            <td style='padding: 10px; border: 1px solid #ddd;'>{$data['BirthDate']}</td>
                        </tr>
                    </table>

                    <p style='margin-top: 20px;'>To access your student dashboard, please visit the portal below:</p>
                    <p><a href='$portalUrl' target='_blank' style='color: #2c3e50; font-weight: bold;'>$portalUrl</a></p>

                    <p style='margin-top: 30px;'>Thank you and welcome aboard!</p>
                    <p style='font-size: 13px; color: #777;'>If you encounter any issues, please contact the registrar or school IT support.</p>
                    <p style='margin-top: 20px;'>Sincerely,<br><strong>$schoolName</strong></p>
                </div>";

            // Send email to student and CC to parent (if provided)
            $this->email->set_mailtype('html');
            $this->email->from('no-reply@srmsportal.com', $schoolName);
            $this->email->to($studentEmail);

            if (!empty($parentEmail)) {
                $this->email->cc($parentEmail);
            }

            $this->email->subject('Welcome to ' . $schoolName);
            $this->email->message($mail_message);
            $this->email->send();

            // Set success message and redirect
            $this->session->set_flashdata('success', 'Student profile created successfully.');
            redirect('Page/profileEntry');
        }
    }
}



	public function personnelEntry()
	{
		$this->load->view('hr_personnel_profile_form');

		if ($this->input->post('submit')) {
			$input = $this->input->post(NULL, TRUE);

			// Get latest settings record
			$settings = $this->db->order_by('settingsID', 'DESC')->get('srms_settings_o')->row();
			$settingsID = $settings ? $settings->settingsID : 1;
			$schoolName = $settings ? $settings->SchoolName : 'SRMS Online';

			$data = [
				'IDNumber'        => $input['IDNumber'],
				'prefix'          => $input['prefix'],
				'FirstName'       => strtoupper($input['FirstName']),
				'MiddleName'      => strtoupper($input['MiddleName']),
				'LastName'        => strtoupper($input['LastName']),
				'NameExtn'        => $input['NameExtn'],
				'empPosition'     => $input['empPosition'],
				'Department'      => $input['Department'],
				'MaritalStatus'   => $input['MaritalStatus'],
				'empStatus'       => $input['empStatus'],
				'BirthDate'       => $input['BirthDate'],
				'BirthPlace'      => $input['BirthPlace'],
				'Sex'             => $input['Sex'],
				'height'          => $input['height'],
				'weight'          => $input['weight'],
				'bloodType'       => $input['bloodType'],
				'gsis'            => $input['gsis'],
				'pagibig'         => $input['pagibig'],
				'philHealth'      => $input['philHealth'],
				'sssNo'           => $input['sssNo'],
				'tinNo'           => $input['tinNo'],
				'dateHired'       => $input['dateHired'],
				'resHouseNo'      => $input['resHouseNo'],
				'resStreet'       => $input['resStreet'],
				'resVillage'      => $input['resVillage'],
				'resBarangay'     => $input['resBarangay'],
				'resCity'         => $input['resCity'],
				'resProvince'     => $input['resProvince'],
				'resZipCode'      => $input['resZipCode'],
				'empTelNo'        => $input['empTelNo'],
				'empMobile'       => $input['empMobile'],
				'empEmail'        => $input['empEmail'],
				'settingsID'      => $settingsID
			];

			date_default_timezone_set('Asia/Manila');
			$now = date('H:i:s A');
			$date = date("Y-m-d");
			$Password = sha1($data['BirthDate']);
			$Encoder = $this->session->userdata('username');

			// Duplicate ID check
			if ($this->db->where('IDNumber', $data['IDNumber'])->get('staff')->num_rows() > 0) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Employee Number is already in use.</b></div>');
				redirect('Page/personnelEntry');
			}

			// Save to staff table
			$this->db->insert('staff', $data);

			// o_users table entry
			$userData = [
				'username'     => $data['IDNumber'],
				'IDNumber'     => $data['IDNumber'],
				'password'     => $Password,
				'position'     => 'Teacher',
				'fName'        => $data['FirstName'],
				'mName'        => $data['MiddleName'],
				'lName'        => $data['LastName'],
				'email'        => $input['empEmail'],
				'avatar'       => 'avatar.png',
				'acctStat'     => 'active',
				'dateCreated'  => $date
			];
			$this->db->insert('o_users', $userData);

			// Audit trail
			$this->db->insert('atrail', [
				'atDesc'   => 'Created Personnel Profile and User Account',
				'atDate'   => $date,
				'atTime'   => $now,
				'atRes'    => $Encoder,
				'atSNo'    => $data['IDNumber']
			]);

			// Send email notification
			$this->load->config('email');
			$this->load->library('email');

			$loginURL = base_url('login'); // Replace 'login' with your actual login route if different

			$mail_message = '
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    .email-container {
      font-family: Arial, sans-serif;
      max-width: 600px;
      margin: auto;
      border: 1px solid #dddddd;
      padding: 20px;
      border-radius: 10px;
      background-color: #f9f9f9;
    }
    .email-header {
      text-align: center;
      background-color: #007bff;
      padding: 10px;
      color: white;
      border-radius: 10px 10px 0 0;
    }
    .email-body {
      margin-top: 20px;
    }
    .email-footer {
      margin-top: 30px;
      font-size: 12px;
      color: #777;
      text-align: center;
    }
    .credentials {
      background: #fff;
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 5px;
    }
    .login-button {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #007bff;
      color: #ffffff !important;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      <h2>' . $schoolName . '</h2>
    </div>
    <div class="email-body">
      <p>Dear <strong>' . $data['FirstName'] . '</strong>,</p>
      <p>We’re pleased to inform you that your personnel profile has been successfully created in the SRMS (School Records Management System).</p>
      
      <p>Please find your login credentials below:</p>
      <div class="credentials">
        <p><strong>Username:</strong> ' . $data['IDNumber'] . '</p>
        <p><strong>Password:</strong> ' . $data['BirthDate'] . '</p>
      </div>

      <a href="' . $loginURL . '" class="login-button">Login Now</a>

      <p style="margin-top:20px;">You may now log in and access your account. Please make sure to keep your credentials confidential.</p>
      <p>Thank you and welcome aboard!</p>

      <p>Best regards,<br>
      <strong>SRMS Online Team</strong></p>
    </div>
    <div class="email-footer">
      This is an automated message. Please do not reply directly to this email.
    </div>
  </div>
</body>
</html>
';


			$this->email->from('no-reply@srmsportal.com', 'SRMS Online Team');
			$this->email->to($input['empEmail']);
			$this->email->subject('Account Created');
			$this->email->message($mail_message);
			$this->email->send();

			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Personnel profile has been saved successfully.</b></div>');
			redirect('Page/personnelEntry');
		}
	}




	//Update Personnel Profile
	public function updatePersonnelProfile()
	{
		if ($this->session->userdata('level') === 'Admin' || $this->session->userdata('level') === 'HR Admin') {
			$id = $this->input->get('id');
		} else {
			$id = $this->session->userdata('IDNumber');
		}

		$result['data'] = $this->StudentModel->staffProfile($id);
		$this->load->view('hr_personnel_profile_update_form', $result);

		if ($this->input->post('submit')) {
			$OldIDNumber = $this->input->post('OldIDNumber');
			$IDNumber = $this->input->post('IDNumber');

			// Collect staff data
			$staff_data = [
				'IDNumber' => $IDNumber,
				'prefix' => $this->input->post('prefix'),
				'FirstName' => strtoupper($this->input->post('FirstName')),
				'MiddleName' => strtoupper($this->input->post('MiddleName')),
				'LastName' => strtoupper($this->input->post('LastName')),
				'NameExtn' => $this->input->post('NameExtn'),
				'empPosition' => $this->input->post('empPosition'),
				'Department' => $this->input->post('Department'),
				'empStatus' => $this->input->post('empStatus'),
				'BirthDate' => $this->input->post('BirthDate'),
				'BirthPlace' => $this->input->post('BirthPlace'),
				'Sex' => $this->input->post('Sex'),
				'height' => $this->input->post('height'),
				'weight' => $this->input->post('weight'),
				'bloodType' => $this->input->post('bloodType'),
				'gsis' => $this->input->post('gsis'),
				'pagibig' => $this->input->post('pagibig'),
				'philHealth' => $this->input->post('philHealth'),
				'sssNo' => $this->input->post('sssNo'),
				'tinNo' => $this->input->post('tinNo'),
				'resHouseNo' => $this->input->post('resHouseNo'),
				'resStreet' => $this->input->post('resStreet'),
				'resVillage' => $this->input->post('resVillage'),
				'resBarangay' => $this->input->post('resBarangay'),
				'resZipCode' => $this->input->post('resZipCode'),
				'resCity' => $this->input->post('resCity'),
				'resProvince' => $this->input->post('resProvince'),
				'perHouseNo' => $this->input->post('resHouseNo'),
				'perStreet' => $this->input->post('resStreet'),
				'perVillage' => $this->input->post('resVillage'),
				'perBarangay' => $this->input->post('resBarangay'),
				'perZipCode' => $this->input->post('resZipCode'),
				'perCity' => $this->input->post('resCity'),
				'perProvince' => $this->input->post('resProvince'),
				'empTelNo' => $this->input->post('empTelNo'),
				'empMobile' => $this->input->post('empMobile'),
				'empEmail' => $this->input->post('empEmail'),
				'dateHired' => $this->input->post('dateHired')
			];

			// Collect user data
			$user_data = [
				'fName' => strtoupper($this->input->post('FirstName')),
				'mName' => strtoupper($this->input->post('MiddleName')),
				'lName' => strtoupper($this->input->post('LastName')),
				'email' => $this->input->post('empEmail'),
				'username' => $IDNumber,
				'IDNumber' => $IDNumber
			];

			// Collect audit trail data
			date_default_timezone_set('Asia/Manila');
			$date = date('Y-m-d');
			$time = date('H:i:s A');
			$encoder = $this->session->userdata('username');

			$trail_data = [
				'atDesc' => 'Updated Personnel Profile',
				'atDate' => $date,
				'atTime' => $time,
				'atRes' => $encoder,
				'atSNo' => $OldIDNumber
			];

			// Perform all updates inside a transaction
			$this->db->trans_start();

			// Update staff and user information
			$this->db->where('IDNumber', $OldIDNumber)->update('staff', $staff_data);
			$this->db->where('IDNumber', $OldIDNumber)->update('o_users', $user_data);

			// Insert audit trail
			$this->db->insert('atrail', $trail_data);

			// Update other tables that use IDNumber
			$tables_to_update = ['semsubjects', 'semesterstude', 'registration', 'hris_files', 'sections'];
			foreach ($tables_to_update as $table) {
				$this->db->where('IDNumber', $OldIDNumber)->update($table, ['IDNumber' => $IDNumber]);
			}

			// Update grades table where adviser = OldIDNumber
			$this->db->where('adviser', $OldIDNumber)->update('grades', ['adviser' => $IDNumber]);

			$this->db->trans_complete();

			// Flash message
			if ($this->db->trans_status() === FALSE) {
				$this->session->set_flashdata('error', 'Update failed!');
			} else {
				$this->session->set_flashdata('success', 'Updated Successfully!');
			}

			// Redirect
			redirect(base_url() . 'Page/staffprofile?id=' . $IDNumber);
		}
	}




	//Change Profile Pic
	function changeDP()
	{
		$this->load->view('upload_profile_pic');
	}

	public function uploadProfPic()
	{
		$config['upload_path'] = './upload/profile/';
		$config['allowed_types'] = 'jpg|gif|png';
		$config['max_size'] = 2048;
		//$config['max_width'] = 1500;
		//$config['max_height'] = 1500;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('nonoy')) {
			$msg = array('error' => $this->upload->display_errors());

			$this->load->view('upload_profile_pic', $msg);
		} else {
			$data = array('image_metadata' => $this->upload->data());
			//get data from the form
			$username = $this->session->userdata('username');
			//$filename=$this->input->post('nonoy');
			$filename = $this->upload->data('file_name');

			$que = $this->db->query("update o_users set avatar='$filename' where username='$username'");
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Uploaded Succesfully!</b></div>');
			$this->load->view('upload_profile_pic');
		}
	}

	public function userAccounts()
	{
		// Load the user accounts data and pass it to the view
		$result['data'] = $this->StudentModel->userAccounts();
		$this->load->view('user_accounts', $result);

		// Check if the form has been submitted
		if ($this->input->post('submit')) {
			// Sanitize and retrieve data from the form
			$username = $this->input->post('username', TRUE); // TRUE for XSS filtering
			$IDNumber = $this->input->post('IDNumber', TRUE);
			$password = sha1($this->input->post('password')); // Consider using a more secure hashing method
			$acctLevel = $this->input->post('acctLevel', TRUE);
			$fName = $this->input->post('fName', TRUE);
			$mName = $this->input->post('mName', TRUE);
			$lName = $this->input->post('lName', TRUE);
			$completeName = $fName . ' ' . $lName;
			$email = $this->input->post('email', TRUE);
			$dateCreated = date("Y-m-d");

			// Use query builder to check if the username already exists
			$this->db->where('username', $username);
			$query = $this->db->get('o_users');

			if ($query->num_rows() > 0) {
				// Set flash message and redirect if username exists
				$this->session->set_flashdata('danger', '<div class="alert alert-danger text-center"><b>The username is already taken. Please choose a different one.</b></div>');
				redirect('Page/userAccounts');
			} else {
				// Prepare data for insertion
				$data = array(
					'username' => $username,
					'password' => $password,
					'position' => $acctLevel,
					'fName' => $fName,
					'mName' => $mName,
					'lName' => $lName,
					'email' => $email,
					'avatar' => 'avatar.png',
					'acctStat' => 'active',
					'dateCreated' => $dateCreated,
					'IDNumber' => $IDNumber
				);

				// Insert data into the database
				$this->db->insert('o_users', $data);

				// Set success flash message and redirect
				$this->session->set_flashdata('success', '<div class="alert alert-success text-center"><b>New account has been created successfully.</b></div>');
				redirect('Page/userAccounts');
			}
		}
	}

	public function updateUserInfo()
	{
		if ($this->input->post('submitEdit')) {
			$username   = $this->input->post('username');
			$acctLevel  = $this->input->post('acctLevel');
			$email      = $this->input->post('email');

			if ($username && $acctLevel && $email) {
				$data = array(
					'position' => $acctLevel,
					'email' => $email
				);

				$this->db->where('username', $username);
				$this->db->update('o_users', $data);

				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('success', 'Account info updated successfully.');
				} else {
					$this->session->set_flashdata('danger', 'Update failed. No changes or user not found.');
				}
			} else {
				$this->session->set_flashdata('danger', 'Invalid input values.');
			}
		}

		redirect('Page/userAccounts');
	}



	public function create_stude_accts()
	{
		$success = $this->StudentModel->insert_students();

		if ($success) {
			$this->session->set_flashdata('success', 'Students have been inserted successfully!');
		} else {
			$this->session->set_flashdata('danger', 'There was an error inserting students. Please try again.');
		}

		redirect('Page/userAccounts');
	}

	public function create_teacher_accts()
	{
		$success = $this->StudentModel->insert_teachers();

		if ($success) {
			$this->session->set_flashdata('success', 'Personnel accounts have been inserted successfully!');
		} else {
			$this->session->set_flashdata('danger', 'There was an error inserting record. Please try again.');
		}

		redirect('Page/userAccounts');
	}

	public function activate_all_accounts()
	{
		// Update accounts to 'active' regardless of the current case of 'acctStat'
		$this->db->set('acctStat', 'active');
		$this->db->where('LOWER(acctStat) !=', 'active'); // Compare using LOWER() to ensure case insensitivity
		$success = $this->db->update('o_users');

		if ($success) {
			$this->session->set_flashdata('success', 'Accounts have been updated to active successfully!');
		} else {
			$this->session->set_flashdata('danger', 'There was an error updating accounts. Please try again.');
		}

		redirect('Page/userAccounts');
	}


	public function changeUserStat()
	{
		$u = $this->input->get('u'); // Username of the account to be updated
		$t = $this->input->get('t'); // Action type (Activate or Deactivate)
		$id = $this->session->userdata('username'); // Current user's username
		date_default_timezone_set('Asia/Manila');
		$now = date('H:i:s A'); // Current time
		$date = date("Y-m-d"); // Current date

		// Determine the new status based on the value of $t
		if ($t == 'Activate') {
			$newStatus = 'active';
		} else {
			$newStatus = 'inactive';
		}

		// Update the user account status
		$this->db->query("UPDATE o_users SET acctStat = '$newStatus' WHERE username = ?", array($u));

		// Insert a trail record
		$this->db->query(
			"INSERT INTO atrail (atrailID, atDesc, atDate, atTime, atRes, atSNo) VALUES (?, ?, ?, ?, ?, ?)",
			array(
				'',
				($newStatus == 'Active' ? 'Activated user account' : 'Deactivated user account'),
				$date,
				$now,
				$id,
				$u
			)
		);

		// Set a success flash message
		$this->session->set_flashdata('success', '<div class="alert alert-success text-center"><b>The selected account has been ' . strtolower($newStatus) . 'd successfully.</b></div>');

		// Redirect to the user accounts page
		redirect('Page/userAccounts');
	}


	public function resetPass()
	{
		$u = $this->input->get('u'); // Username to reset
		$id = $this->session->userdata('username'); // Resetter username

		// Use your getSchoolName() function
		$schoolName = $this->SettingsModel->getSchoolName();
		$loginURL = base_url('login'); // Since portal_url is not fetched, use base_url fallback

		// Generate 12-character random password
		$password = bin2hex(random_bytes(6));
		$hashedPassword = sha1($password);

		date_default_timezone_set('Asia/Manila');
		$now = date('H:i:s A');
		$date = date('Y-m-d');

		// Fetch user email
		$user = $this->db->get_where('o_users', ['username' => $u])->row();
		if (!$user || empty($user->email)) {
			$this->session->set_flashdata('danger', '<div class="alert alert-danger text-center"><b>Email not found for the selected user.</b></div>');
			redirect('Page/userAccounts');
			return;
		}

		// Update password
		$this->db->where('username', $u);
		$this->db->update('o_users', ['password' => $hashedPassword]);

		// Audit log
		$this->db->insert('atrail', [
			'atrailID' => '',
			'atDesc' => 'Password reset',
			'atDate' => $date,
			'atTime' => $now,
			'atRes' => $id,
			'atSNo' => $u
		]);

		// Send email
		$this->load->config('email');
		$this->load->library('email');
		$this->email->set_mailtype("html");

		$mail_message = '
<div style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; border-radius: 6px; padding: 30px;">
        <h2 style="color: #2b6cb0;">Password Reset Notification</h2>
        <p>Dear <strong>' . htmlspecialchars($user->fName) . '</strong>,</p>

        <p>Your password has been successfully reset in the School Records Management System (SRMS).</p>

        <p><strong>Here are your new login credentials:</strong></p>
        <table style="width: 100%; max-width: 400px; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px; background: #f1f1f1; border: 1px solid #ccc;"><strong>Username</strong></td>
                <td style="padding: 8px; border: 1px solid #ccc;">' . htmlspecialchars($u) . '</td>
            </tr>
            <tr>
                <td style="padding: 8px; background: #f1f1f1; border: 1px solid #ccc;"><strong>New Password</strong></td>
                <td style="padding: 8px; border: 1px solid #ccc;">' . $password . '</td>
            </tr>
        </table>

        <p>You may log in using the button below:</p>
        <p>
            <a href="' . htmlspecialchars($loginURL) . '" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;">
                Login Now
            </a>
        </p>

        <p style="margin-top: 30px;">Best regards,<br><strong>' . htmlspecialchars($schoolName) . ' SRMS Team</strong></p>
        <hr style="margin-top: 40px;">
        <p style="font-size: 12px; color: #999;">This is an automated message from the School Records Management System. Please do not reply.</p>
    </div>
</div>';


		$this->email->from('no-reply@srmsportal.com', $schoolName);
		$this->email->to($user->email);
		$this->email->subject('Your Password Has Been Reset');
		$this->email->message($mail_message);
		@$this->email->send();

		// Flash message and redirect
		$this->session->set_flashdata('success', '<div class="alert alert-success text-center"><b>Password reset successfully. New password sent via email.<br><br>New Password: <span style="color: red;">' . $password . '</span></b></div>');
		redirect('Page/userAccounts');
	}



	// function updateStudeProfile()
	// {
	// 	$StudentNumber = ($this->session->userdata('level') === 'Student')
	// 		? $this->session->userdata('username')
	// 		: $this->input->get('StudentNumber');

	// 	$result['data'] = $this->StudentModel->displayrecordsById($StudentNumber);
	// 	$result['ethnicity'] = $this->SettingsModel->get_ethnicity();
	// 	$result['religion'] = $this->SettingsModel->get_religion();
	// 	$result['prevschool'] = $this->SettingsModel->get_prevschool();

	// 	// Debug the data
	// 	log_message('debug', print_r($result, true));

	// 	$this->load->view('profile_form_update', $result);


	// 	if ($this->input->post('submit')) {
	// 		// Retrieve form data
	// 		$data = [

	// 			'StudentNumber'       => $this->input->post('StudentNumber'),
	// 			'LRN'       => $this->input->post('LRN'),
	// 			'FirstName'          => $this->input->post('FirstName'),
	// 			'MiddleName'         => $this->input->post('MiddleName'),
	// 			'LastName'           => $this->input->post('LastName'),
	// 			'nameExt'            => $this->input->post('nameExt'),
	// 			'Sex'                => $this->input->post('Sex'),
	// 			'CivilStatus'        => $this->input->post('CivilStatus'),
	// 			'Religion'           => $this->input->post('Religion'),
	// 			'Ethnicity'          => $this->input->post('Ethnicity'),
	// 			'Elementary'          => $this->input->post('Elementary'),
	// 			'MobileNumber'       => $this->input->post('MobileNumber'),
	// 			'BirthDate'          => $this->input->post('BirthDate'),
	// 			'BirthPlace'         => $this->input->post('BirthPlace'),
	// 			'Age'                => $this->input->post('Age'),
	// 			'BloodType'                => $this->input->post('BloodType'),
	// 			// Parents
	// 			'Father'             => $this->input->post('Father'),
	// 			'FOccupation'        => $this->input->post('FOccupation'),
	// 			'Mother'             => $this->input->post('Mother'),
	// 			'MOccupation'        => $this->input->post('MOccupation'),
	// 			'ParentsMonthly'        => $this->input->post('ParentsMonthly'),
	// 			// Guardian Info
	// 			'Guardian'           => $this->input->post('Guardian'),
	// 			'GuardianContact'    => $this->input->post('GuardianContact'),
	// 			'GuardianRelationship' => $this->input->post('GuardianRelationship'),
	// 			'GuardianAddress'    => $this->input->post('GuardianAddress'),
	// 			// Address
	// 			'Sitio'              => $this->input->post('Sitio'),
	// 			'Brgy'               => $this->input->post('Brgy'),
	// 			'City'               => $this->input->post('City'),
	// 			'Province'           => $this->input->post('Province'),
	// 			'EmailAddress'       => $this->input->post('EmailAddress'),

	// 			'Notes'       => $this->input->post('Notes'),
	// 			'with_specialneeds'       => $this->input->post('with_specialneeds'),
	// 			'specialneeds'       => $this->input->post('specialneeds'),
	// 			'p_email'       => $this->input->post('p_email'),

	// 		];

	// 		$Encoder = $this->session->userdata('username');
	// 		$updatedDate = date("Y-m-d");
	// 		$updatedTime = date("h:i:s A");

	// 		// Update profile
	// 		$this->db->where('StudentNumber', $this->input->post('OldStudentNumber'));
	// 		$this->db->update('studeprofile', array_merge($data, ['Encoder' => $Encoder]));


	// 		// Insert audit trail
	// 		$this->db->insert('atrail', [
	// 			'atDesc'        => 'Updated Profile',
	// 			'atDate'   => $updatedDate,
	// 			'atTime'   => $updatedTime,
	// 			'atRes'       => $Encoder,
	// 			'atSNo' => $data['StudentNumber']
	// 		]);

	// 		$this->session->set_flashdata('success', '<div class="alert alert-success text-center"><b>Updated successfully.</b></div>');
	// 		redirect('Page/studentsprofile?id=' . $this->input->post('StudentNumber'));
	// 	}
	// }


	public function updateStudeProfile()
	{
		$StudentNumber = ($this->session->userdata('level') === 'Student')
			? $this->session->userdata('username')
			: $this->input->get('StudentNumber', true);

		$result['data']       = $this->StudentModel->displayrecordsById($StudentNumber);
		$result['ethnicity']  = $this->SettingsModel->get_ethnicity();
		$result['religion']   = $this->SettingsModel->get_religion();
		$result['prevschool'] = $this->SettingsModel->get_prevschool();

		// Debug the data
		log_message('debug', print_r($result, true));

		$this->load->view('profile_form_update', $result);

		if ($this->input->post('submit')) {
			// Gather form inputs
			$data = [
				'StudentNumber'        => $this->input->post('StudentNumber', true),
				'LRN'                  => $this->input->post('LRN', true),
				'FirstName'            => $this->input->post('FirstName', true),
				'MiddleName'           => $this->input->post('MiddleName', true),
				'LastName'             => $this->input->post('LastName', true),
				'nameExt'              => $this->input->post('nameExt', true),
				'Sex'                  => $this->input->post('Sex', true),
				'CivilStatus'          => $this->input->post('CivilStatus', true),
				'Religion'             => $this->input->post('Religion', true),
				'Ethnicity'            => $this->input->post('Ethnicity', true),
				'Elementary'           => $this->input->post('Elementary', true),
				'MobileNumber'         => $this->input->post('MobileNumber', true),
				'BirthDate'            => $this->input->post('BirthDate', true),
				'BirthPlace'           => $this->input->post('BirthPlace', true),
				'Age'                  => $this->input->post('Age', true),
				'BloodType'            => $this->input->post('BloodType', true),
				// Parents
				'Father'               => $this->input->post('Father', true),
				'FOccupation'          => $this->input->post('FOccupation', true),
				'Mother'               => $this->input->post('Mother', true),
				'MOccupation'          => $this->input->post('MOccupation', true),
				'ParentsMonthly'       => $this->input->post('ParentsMonthly', true),
				// Guardian
				'Guardian'             => $this->input->post('Guardian', true),
				'GuardianContact'      => $this->input->post('GuardianContact', true),
				'GuardianRelationship' => $this->input->post('GuardianRelationship', true),
				'GuardianAddress'      => $this->input->post('GuardianAddress', true),
				// Address
				'Sitio'                => $this->input->post('Sitio', true),
				'Brgy'                 => $this->input->post('Brgy', true),
				'City'                 => $this->input->post('City', true),
				'Province'             => $this->input->post('Province', true),
				'EmailAddress'         => $this->input->post('EmailAddress', true),
				// Extras
				'Notes'                => $this->input->post('Notes', true),
				'with_specialneeds'    => $this->input->post('with_specialneeds', true),
				'specialneeds'         => $this->input->post('specialneeds', true),
				'p_email'              => $this->input->post('p_email', true),
			];

			$oldStudentNumber = $this->input->post('OldStudentNumber', true);
			$Encoder          = $this->session->userdata('username');
			$updatedDate      = date("Y-m-d");
			$updatedTime      = date("h:i:s A");

			// Begin transaction
			$this->db->trans_start();

			// 1) Update studeprofile
			$this->db->where('StudentNumber', $oldStudentNumber);
			$this->db->update('studeprofile', array_merge($data, ['Encoder' => $Encoder]));

			// 2) Update o_users (map to fName/mName/lName/email) where username = OldStudentNumber
			$userUpdate = [
				'fName' => $data['FirstName'],
				'mName' => $data['MiddleName'],
				'lName' => $data['LastName'],
				'email' => $data['EmailAddress'],
			];
			$this->db->where('username', $oldStudentNumber);
			$this->db->update('o_users', $userUpdate);

			// 3) Insert audit trail
			$this->db->insert('atrail', [
				'atDesc' => 'Updated Profile',
				'atDate' => $updatedDate,
				'atTime' => $updatedTime,
				'atRes'  => $Encoder,
				'atSNo'  => $data['StudentNumber']
			]);

			$this->db->trans_complete();

			if ($this->db->trans_status() === false) {
				// Rollback happened
				log_message('error', 'updateStudeProfile(): DB transaction failed for StudentNumber ' . $oldStudentNumber);
				$this->session->set_flashdata('failed', '<div class="alert alert-danger text-center"><b>Update failed.</b> Please try again.</div>');
				redirect('Page/studentsprofile?id=' . $oldStudentNumber);
				return;
			}

			// Success
			$this->session->set_flashdata('success', '<div class="alert alert-success text-center"><b>Updated successfully.</b></div>');
			redirect('Page/studentsprofile?id=' . $this->input->post('StudentNumber', true));
		}
	}


	function masterlistByCourse()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$sy = $this->session->userdata('sy');
		$course = $this->input->get('course');
		$result['data'] = $this->StudentModel->byCourse($course, $sy, $sem);
		//$result['data1']=$this->StudentModel->CourseYLCounts($course, $sy, $sem);
		//$result['data2']=$this->StudentModel->SectionCounts($course, $sy, $sem);
		$this->load->view('masterlist_by_course', $result);
	}
	function masterlistByCourseFiltered()
	{
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');
		$sy = $this->session->userdata('sy');
		$course = $this->input->get('course');
		$result['course'] = $this->StudentModel->getCourse();
		$result['data'] = $this->StudentModel->byCourse($course, $sy);
		$this->load->view('masterlist_by_course_filtered', $result);
	}


	public function masterlistByCourseYearLevel()
	{
		$course = $this->input->get('course');
		$yearlevel = $this->input->get('yearlevel');
		$sy = $this->session->userdata('sy');
		$sem = $this->session->userdata('semester');

		$result['title'] = 'Students in ' . $course . ' - ' . $yearlevel;
		$result['students'] = $this->StudentModel->getByCourseAndYearLevel($course, $yearlevel, $sy);
		$result['course'] = $course;
		$result['yearlevel'] = $yearlevel;
		$result['sy'] = $sy;
		$result['sem'] = $sem;

		$this->load->view('masterlist_by_course_yearlevel', $result);
	}


	public function announcement()
	{
		$data['data'] = $this->StudentModel->announcement();
		$this->load->view('announcement', $data);
	}

	public function uploadAnnouncement()
	{
		$config['upload_path'] = './upload/announcements/';  // Ensure this path exists and is writable
		$config['allowed_types'] = 'jpg|png|gif';
		$config['max_size'] = 5120;  // Max size in KB (5 MB)

		// Load upload library with the configuration
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('nonoy')) {
			// If upload fails, set error flash message
			$this->session->set_flashdata('error', 'Data cannot be saved');
			$data['data'] = $this->StudentModel->announcement();
			$data['error'] = $this->upload->display_errors();
			$this->load->view('announcement', $data);
		} else {
			// File successfully uploaded
			$file_data = $this->upload->data();
			$filename = $file_data['file_name'];

			// Retrieve other form data
			$title = $this->input->post('title');
			$encoder = $this->session->userdata('username');
			$datePosted = date("Y-m-d");

			// Prepare data for insertion
			$announcement_data = [
				'datePosted' => $datePosted,
				'title' => $title,
				'announcement' => $filename,
				'author' => $encoder
			];

			// Insert data into the 'announcement' table
			if ($this->db->insert('announcement', $announcement_data)) {
				// Set a success flash message
				$this->session->set_flashdata('success', 'Data have saved successfully');
				redirect(base_url() . 'Page/announcement');
			} else {
				// Set error flash message
				$this->session->set_flashdata('error', 'Data cannot be saved');
				$data['data'] = $this->StudentModel->announcement();
				$this->load->view('announcement', $data);
			}
		}
	}


	//Requirements
	function uploadedRequirements()
	{
		$id = $this->input->get('id');
		$result['data'] = $this->StudentModel->requirements($id);
		$this->load->view('uploaded_requirements', $result);
	}

	//Announcements
	function viewAnnouncement()
	{
		$result['data'] = $this->StudentModel->announcement();
		$this->load->view('announcement_view', $result);
	}
	//Delete Announcement
	// public function deleteAnnouncement()
	// {
	// 	$id = $this->input->get('id');
	// 	$this->StudentModel->deleteAnnouncement($id);
	// 	redirect("Page/announcement");
	// }

	public function deleteAnnouncement($param)
	{
		$result['img'] = $this->PersonnelModel->get_single_table_by_id("announcement", 'aID', $param);
		$filename = $result['img']['announcement'];
		$id = $result['img']['aID'];
		$this->PersonnelModel->delete_announcement($param, $filename, 'announcements', "announcement");
		$this->session->set_flashdata('danger', ' Deleted successfully!');
		redirect(base_url() . 'Page/announcement');
	}



	//Request
	public function submitRequest()
	{
		if ($this->session->userdata('level') === 'Student') {
			$id = $this->session->userdata('username');
		} else {
			$id = $this->input->get('id');
		};

		$result['data'] = $this->StudentModel->studerequest($id);
		$result['data2'] = $this->StudentModel->getTrackingNo();
		$result['data3'] = $this->SettingsModel->getDocReq();
		$this->load->view('request_submit', $result);

		if ($this->input->post('submit')) {
			if ($this->session->userdata('level') === 'Student') {
				$fname = $this->session->userdata('fname');
			} else {
				$fname = $this->input->post('fname');
			}

			$config['upload_path'] = './upload/reqDocs/';
			$config['allowed_types'] = '*';
			$config['max_size'] = 5120;
			//$config['max_width'] = 1500;
			//$config['max_height'] = 1500;

			$this->load->library('upload', $config);
			$this->upload->do_upload('nonoy');
			$data = array('image_metadata' => $this->upload->data());
			$filename = $this->upload->data('file_name');

			$email = $this->input->post('email');
			$StudentNumber = $this->input->post('StudentNumber');
			$docName = $this->input->post('docName');
			$purpose = $this->input->post('purpose');
			$trackingNo = $this->input->post('trackingNo');
			$pReference = $this->input->post('pReference');
			$trackingNo = $this->input->post('trackingNo');

			$dateReq = date("Y-m-d");
			date_default_timezone_set('Asia/Manila'); # add your city to set local time zone
			$now = date('H:i:s A');

			//check if record exist
			$que = $this->db->query("select * from stude_request where trackingNo='" . $trackingNo . "'");
			$row = $que->num_rows();
			if ($row) {
				//redirect('Page/notification_error');
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Tracking No. is in use.</b></div>');
				redirect('Page/profileList');
			} else {

				$que = $this->db->query("insert into stude_request values('$trackingNo','$docName','$purpose','$dateReq','$now','$StudentNumber','Open','$pReference','$filename')");
				$que = $this->db->query("insert into stude_request_stat values('','$StudentNumber','request submitted','$StudentNumber','$dateReq','$now','$trackingNo','Open','$filename','On Process')");
				$que = $this->db->query("insert into atrail values('','Requested a Document','$dateReq','$now','$id','$id')");
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Your request has been submitted.</b></div>');

				//Email Notification
				$this->load->config('email');
				$this->load->library('email');
				$mail_message = 'Dear ' . $fname . ',' . "\r\n";
				$mail_message .= '<br><br>Your request with tracking number <b>' . $trackingNo . ' </b>has been submitted.' . "\r\n";
				$mail_message .= '<br><br>Login to your portal to check the status of your request.' . "\r\n";

				$mail_message .= '<br><br>Thanks & Regards,';
				$mail_message .= '<br>SRMS - Online';

				$this->email->from('no-reply@softtechservices.net', 'SRMS Online Team')
					->to($email)
					->subject('Online Request')
					->message($mail_message);
				$this->email->send();
				if ($this->session->userdata('level') === 'Student') {
					$this->session->set_flashdata('success', 'Posted successfully!');
					redirect(base_url() . 'Page/studentRequestStat?trackingNo=' . $trackingNo);
				} else {
					redirect('Page/allRequest');
				}
			}
		}
	}

	function studentRequestStat()
	{
		$id = $this->input->get('trackingNo');
		$result['data'] = $this->StudentModel->studerequestTracking($id);
		$this->load->view('stude_request_status', $result);
		$user = $this->session->userdata('username');

		if ($this->input->post('submit')) {
			$config['upload_path'] = './upload/reqDocs/';
			$config['allowed_types'] = 'jpg|pdf|png';
			$config['max_size'] = 5120;
			//$config['max_width'] = 1500;
			//$config['max_height'] = 1500;

			$this->load->library('upload', $config);


			$this->upload->do_upload('nonoy');
			$data = array('image_metadata' => $this->upload->data());
			$filename = $this->upload->data('file_name');

			$StudentNumber = $this->input->post('StudentNumber');
			$trackingNo = $this->input->post('trackingNo');
			$reqStatus = $this->input->post('reqStatus');
			$reqStat = $this->input->post('reqStat');

			$dateReq = date("Y-m-d");
			date_default_timezone_set('Asia/Manila'); # add your city to set local time zone
			$now = date('H:i:s A');

			$que = $this->db->query("update stude_request set reqStat='$reqStat' where trackingNo='$trackingNo'");
			$que = $this->db->query("insert into stude_request_stat values('','$StudentNumber','$reqStatus','$user','$dateReq','$now','$trackingNo','$reqStat','$filename','$reqStat')");
			$this->session->set_flashdata('success', 'Posted successfully!');
			redirect(base_url() . 'Page/studentRequestStat?trackingNo=' . $trackingNo);
		}
	}

	public function lockScreen()
	{
		$this->load->view('lock-screen');
	}

	// bulk creation of user accounts for teachers
	public function bulk_accts()
	{
		// for teacher
		$query = $this->db->query("insert into users (username, password, position, fName, mName, lName, avatar, acctStat, dateCreated, IDNumber) select IDNumber, 'c615b7c8eed143e6771121658cb1b50bea300928','Teacher',FirstName, MiddleName, LastName,'avatar.png','active','2023-10-03',IDNumber from staff");
	}



	//delete student's profile
	public function deleteProfile()
	{
		$id = $this->input->get('id');
		$username = $this->session->userdata('username');

		date_default_timezone_set('Asia/Manila');
		$now = date('H:i:s A');
		$date = date("Y-m-d");

		$this->db->where('StudentNumber', $id)->delete('studeprofile');
		$this->db->where('username', $id)->delete('o_users');
		$data = [
			'atDesc' => "Deleted profile of student: $id ",
			'atDate' => $date,
			'atTime' => $now,
			'atRes' => $username,
			'atSNo' => $id
		];
		$this->db->insert('atrail', $data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Student profile has been successfully deleted.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');

		redirect('Page/profileList');
	}

	//delete student's profile
	public function deletePersonnel()
	{
		$id = $this->input->get('id');
		$username = $this->session->userdata('username');

		date_default_timezone_set('Asia/Manila');
		$now = date('H:i:s A');
		$date = date("Y-m-d");

		$this->db->where('IDNumber', $id)->delete('staff');
		$this->db->where('username', $id)->delete('o_users');

		$data = [
			'atDesc' => "Deleted profile of personnel: $id ",
			'atDate' => $date,
			'atTime' => $now,
			'atRes' => $username,
			'atSNo' => $id
		];
		$this->db->insert('atrail', $data);
		$this->session->set_flashdata('msg', 'Staff profile has been successfully deleted.');
		redirect('Page/employeeList');
	}


	//delete student's enrollment
	public function deleteEnrollment()
	{
		$id = $this->input->get('id');
		$query = $this->db->query("delete from semesterstude where semstudentid='" . $id . "'");
		$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>Deleted successfully.</b></div>');
		redirect('Masterlist/enrolledList');
	}

	//update enrollment
	// function updateEnrollment()
	// {
	// 	$id = $this->input->get('id');
	// 	$semester = $this->session->userdata('semester');
	// 	$sy = $this->session->userdata('sy');
	// 	$courseVal = $this->input->post('course');
	// 	$yearlevelVal = $this->input->post('yearlevel');
	// 	$result['course'] = $this->StudentModel->getCourse();
	// 	$result['section'] = $this->StudentModel->getSection();
	// 	$result['courseVal'] = $courseVal;
	// 	$result['data'] = $this->StudentModel->masterlistAll2($id, $sy);
	// 	$result['yearlevelVal'] = $yearlevelVal;

	// 	$result['track'] = $this->SettingsModel->getTrack();
	// 	$result['strand'] = $this->SettingsModel->getStrand1();

	// 	$this->load->view('enrollment_form_update', $result);
	// 	if ($this->input->post('submit')) {
	// 		//get data from the form
	// 		$semstudentid = $this->input->post('semstudentid');
	// 		$StudentNumber = $this->input->post('StudentNumber');
	// 		$FName = $this->input->post('FName');
	// 		$MName = $this->input->post('MName');
	// 		$LName = $this->input->post('LName');
	// 		$Course = $this->input->post('Course');
	// 		$YearLevel = $this->input->post('YearLevel');
	// 		$StudeStatus = $this->input->post('StudeStatus');
	// 		$Track = $this->input->post('Track');
	// 		$Qualification = $this->input->post('Qualification');
	// 		$Semester = $this->input->post('Semester');
	// 		$SY = $this->input->post('SY');
	// 		$Section = $this->input->post('Section');
	// 		$IDNumber = $this->input->post('IDNumber');
	// 		$Adviser = $this->input->post('Adviser');

	// 		$BalikAral = $this->input->post('BalikAral');
	// 		$IP = $this->input->post('IP');
	// 		$FourPs = $this->input->post('FourPs');
	// 		$Repeater = $this->input->post('Repeater');
	// 		$Transferee = $this->input->post('Transferee');
	// 		$Semester = $this->input->post('Semester');
	// 		$EnrolledDate = date("Y-m-d");

	// 		//save enrollment
	// 		//$que=$this->db->query("update semesterstude set Course='$Course',YearLevel='$YearLevel',Section='$Section',YearLevelStat='$YearLevelStat',Major='$Major' where semstudentid='$id'");
	// 		$que = $this->db->query("update semesterstude set Course='$Course',YearLevel='$YearLevel',Section='$Section',IDNumber='$IDNumber',Adviser='$Adviser',Track='$Track',Qualification='$Qualification',BalikAral='$BalikAral',IP='$IP',FourPs='$FourPs',Repeater='$Repeater',Transferee='$Transferee',Semester='$Semester',StudeStatus='$StudeStatus' where semstudentid='$id'");
	// 		$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Enrollment details have been updated successfully. </b></div>');


	// 		//Email Notification
	// 		$this->load->config('email');
	// 		$this->load->library('email');
	// 		$mail_message = 'Dear ' . $FName . ',' . "\r\n";
	// 		$mail_message .= '<br><br>Your enrollment details have been updated.' . "\r\n";
	// 		$mail_message .= '<br>Course: <b>' . $Course . '</b>' . "\r\n";
	// 		$mail_message .= '<br>Year Level: <b>' . $YearLevel . '</b>' . "\r\n";
	// 		$mail_message .= '<br>Section: <b>' . $Section . '</b>' . "\r\n";
	// 		$mail_message .= '<br>Sem/SY: <b>' . $Semester . ', ' . $SY . '</b>' . "\r\n";
	// 		$mail_message .= '<br>Status: <b>Validated</b>' . "\r\n";

	// 		$mail_message .= '<br><br>Thanks & Regards,';
	// 		$mail_message .= '<br>SRMS - Online';

	// 		$this->email->from('no-reply@lxeinfotechsolutions.com', 'SRMS Online Team')
	// 			->to($email)
	// 			->subject('Enrollment')
	// 			->message($mail_message);
	// 		$this->email->send();

	// 		//redirect('Masterlist/masterlistAll');
	// 		redirect('Masterlist/enrolledList');
	// 	}
	// }


	public function updateEnrollment()
	{
		$id = $this->input->get('id');
		$sy = $this->session->userdata('sy');

		if ($this->input->post('submit')) {
			// Get form data
			$FName        = $this->input->post('FName');
			$Course       = $this->input->post('Course');
			$YearLevel    = $this->input->post('YearLevel');
			$Section      = $this->input->post('Section');
			$IDNumber     = $this->input->post('IDNumber');
			$Adviser      = $this->input->post('Adviser');
			$Track        = $this->input->post('Track');
			$Qualification = $this->input->post('Qualification');
			$BalikAral    = $this->input->post('BalikAral');
			$IP           = $this->input->post('IP');
			$FourPs       = $this->input->post('FourPs');
			$Repeater     = $this->input->post('Repeater');
			$Transferee   = $this->input->post('Transferee');
			$Semester     = $this->input->post('Semester');
			$SY           = $this->input->post('SY');
			$StudeStatus  = $this->input->post('StudeStatus');
			$email        = $this->input->post('Email');

			// Update database
			$this->db->where('semstudentid', $id);
			$this->db->update('semesterstude', [
				'Course'        => $Course,
				'YearLevel'     => $YearLevel,
				'Section'       => $Section,
				'IDNumber'      => $IDNumber,
				'Adviser'       => $Adviser,
				'Track'         => $Track,
				'Qualification' => $Qualification,
				'BalikAral'     => $BalikAral,
				'IP'            => $IP,
				'FourPs'        => $FourPs,
				'Repeater'      => $Repeater,
				'Transferee'    => $Transferee,
				'Semester'      => $Semester,
				'StudeStatus'   => $StudeStatus
			]);

			$this->session->set_flashdata('success', '<div class="alert alert-success text-center"><b>Student enrollment information has been updated successfully.</b></div>');

			// Send Email Notification
			if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$this->load->config('email');
				$this->load->library('email');

				$mail_message = 'Dear ' . $FName . ',<br><br>';
				$mail_message .= 'Your enrollment details have been updated.<br>';
				$mail_message .= 'Course: <b>' . $Course . '</b><br>';
				$mail_message .= 'Year Level: <b>' . $YearLevel . '</b><br>';
				$mail_message .= 'Section: <b>' . $Section . '</b><br>';
				$mail_message .= 'Sem/SY: <b>' . $Semester . ', ' . $SY . '</b><br>';
				$mail_message .= 'Status: <b>Validated</b><br><br>';
				$mail_message .= 'Thanks & Regards,<br>SRMS - Online';

				$this->email->from('no-reply@srmsportal.com', 'SRMS Online Team');
				$this->email->to($email);
				$this->email->subject('Enrollment');
				$this->email->message($mail_message);
				$this->email->send();
			}

			// Conditional redirection
			$userlevel = $this->session->userdata('level');
			if ($userlevel === 'Registrar') {
				$result['course'] = $this->StudentModel->getCourse();
				$result['section'] = $this->StudentModel->getSection();
				$result['courseVal'] = $Course;
				$result['yearlevelVal'] = $YearLevel;
				$result['track'] = $this->SettingsModel->getTrack();
				$result['strand'] = $this->SettingsModel->getStrand1();
				$result['data'] = $this->StudentModel->masterlistAll2($id, $sy);

				// $this->load->view('enrollment_form_update', $result);
				redirect('Masterlist/enrolledList');
			} else {
				redirect('Masterlist/advisoryClass');
			}
		} else {
			// Initial load of form
			$courseVal = $this->input->post('course');
			$yearlevelVal = $this->input->post('yearlevel');

			$result['course'] = $this->StudentModel->getCourse();
			$result['section'] = $this->StudentModel->getSection();
			$result['courseVal'] = $courseVal;
			$result['data'] = $this->StudentModel->masterlistAll2($id, $sy);
			$result['yearlevelVal'] = $yearlevelVal;
			$result['track'] = $this->SettingsModel->getTrack();
			$result['strand'] = $this->SettingsModel->getStrand1();

			$this->load->view('enrollment_form_update', $result);
		}
	}





	//Employee List (All)  
	function employeelist()
	{
		$result['data'] = $this->PersonnelModel->displaypersonnel();
		$result['data1'] = $this->PersonnelModel->personnelCounts();
		$result['data2'] = $this->PersonnelModel->departmentcounts();
		$this->load->view('hr_personnel_list', $result);
	}
	//Employee List By Department
	function employeelistDepartment()
	{
		$department = $this->input->get('department');
		$result['data'] = $this->PersonnelModel->employeelistDepartment($department);
		$this->load->view('hr_personnel_list_department', $result);
	}

	//Employee List By Position
	function employeelistPosition()
	{
		$position = $this->input->get('position');
		$result['data'] = $this->PersonnelModel->employeelistPosition($position);
		$this->load->view('hr_personnel_list_position', $result);
	}

	public function upload201files()
	{
		$this->load->view('hr_201files_upload');
	}
	public function process201Upload()
	{
		$config['upload_path'] = './upload/201files/';
		$config['allowed_types'] = 'jpg|pdf|png';
		$config['max_size'] = 5120;
		//$config['max_width'] = 1500;
		//$config['max_height'] = 1500;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('nonoy')) {
			$msg = array('error' => $this->upload->display_errors());

			$this->load->view('upload201Files', $msg);
		} else {
			$data = array('image_metadata' => $this->upload->data());
			//get data from the form
			$IDNumber = $this->input->post('IDNumber');
			//$filename=$this->input->post('nonoy');
			$filename = $this->upload->data('file_name');
			$docName = $this->input->post('docName');
			$date = date("Y-m-d");
			$que = $this->db->query("insert into hris_files values('','$IDNumber','$docName','$filename','$date')");
			$this->session->set_flashdata('success', 'Uploaded Succesfully!');
			redirect(base_url() . 'Page/staffprofile?id=' . $IDNumber);
		}
	}

	function viewfilesAll()
	{
		$result['data'] = $this->PersonnelModel->viewfilesAll();
		$this->load->view('hr_201files', $result);
	}

	function hr_files_individual()
	{
		$id = $this->input->get('id');
		$result['data'] = $this->PersonnelModel->viewfiles($id);
		$this->load->view('hr_files_individual', $result);
	}

	function closedDocRequest()
	{
		$result['data'] = $this->StudentModel->closedDocRequest();
		$this->load->view('request_closed', $result);
	}

	function openRequest()
	{
		$result['data'] = $this->StudentModel->openRequest();
		$this->load->view('request_open', $result);
	}

	function guidance()
	{
		//Allowing access to Admin only
		if ($this->session->userdata('level') === 'Guidance') {
			$result['data1'] = $this->StudentModel->incidentsCounts();
			$result['data2'] = $this->StudentModel->counsellingCounts();
			$result['data18'] = $this->SettingsModel->getSchoolInfo();
			$this->load->view('dashboard_guidance', $result);
		} else {
			echo "Access Denied";
		}
	}

	function medical()
	{
		//Allowing access to Admin only
		if ($this->session->userdata('level') === 'School Nurse') {
			$result['data1'] = $this->StudentModel->medInfoCounts();
			$result['data2'] = $this->StudentModel->medRecordsCounts();
			$result['data18'] = $this->SettingsModel->getSchoolInfo();
			$this->load->view('dashboard_nurse', $result);
		} else {
			echo "Access Denied";
		}
	}



	public function medRecords()
	{
		$this->load->model('StudentModel');

		// Student user
		if ($this->session->userdata('level') === 'Student') {
			$id = $this->session->userdata('username');
			$result['data'] = $this->StudentModel->medRecords_stude($id);
			$this->load->view('medical_records', $result);
			return;
		}

		// Admin or Staff view
		$filter = $this->input->get('filter') ?? 'student';

		if ($filter === 'staff') {
			$result['data'] = $this->StudentModel->medRecords_staff();
			$result['isStaff'] = true;
		} else {
			$result['data'] = $this->StudentModel->medRecords();
			$result['isStaff'] = false;
		}

		$result['students'] = $this->StudentModel->searchStudents();
		$result['data1'] = $this->StudentModel->searchStaff();
		$this->load->view('medical_records', $result);

		// Handle form submission
		if ($this->input->post('submit')) {
			$acctGroup = $this->input->post('AcctGroup');

			// Use IDNumber if staff, StudentNumber if student
			$studentNumber = ($acctGroup === 'Staff')
				? $this->input->post('IDNumber')
				: $this->input->post('StudentNumber');

			$data = [
				'AcctGroup' => $acctGroup,
				'StudentNumber' => $studentNumber,
				'caseNo'        => $this->input->post('caseNo'),
				'incidentDate'  => $this->input->post('incidentDate'),
				'temperature'   => $this->input->post('temperature'),
				'bp'            => $this->input->post('bp'),
				'complaint'     => $this->input->post('complaint'),
				'painTolerance' => $this->input->post('painTolerance'),
				'medication'    => $this->input->post('medication'),
				'otherDetails'  => $this->input->post('otherDetails'),
				'otherNotes'    => $this->input->post('otherNotes'),
			];

			$this->db->insert('medical_records', $data);
			$this->session->set_flashdata('success', 'Medical record added successfully.');
			redirect('Page/medRecords');
		}
	}

	public function deleteMedRec()
	{
		$id = $this->input->get('id');
		$que = $this->db->query("delete from medical_records where mrID='" . $id . "'");
		$this->session->set_flashdata('success', 'Deleted successfully.');
		redirect("Page/medRecords");
	}

	public function updateMedRecords()
	{
		$id = $this->input->get('id');

		$record = $this->db->get_where('medical_records', ['mrID' => $id])->row();

		if (!$record) {
			$this->session->set_flashdata('danger', 'Medical record not found.');
			redirect('Page/medRecords');
			return;
		}

		// Display full name based on AcctGroup using StudentNumber for both
		if ($record->AcctGroup === 'Student') {
			$profile = $this->db->get_where('studeprofile', ['StudentNumber' => $record->StudentNumber])->row();
		} else {
			$profile = $this->db->get_where('staff', ['IDNumber' => $record->StudentNumber])->row(); // ✅ use StudentNumber as staff ID
		}

		$record->displayName = $profile ? $profile->FirstName . ' ' . $profile->LastName : '';

		if ($this->input->post('submit')) {

			$update = [
				'caseNo'        => $this->input->post('caseNo'),
				'incidentDate'  => $this->input->post('incidentDate'),
				'temperature'   => $this->input->post('temperature'),
				'bp'            => $this->input->post('bp'),
				'complaint'     => $this->input->post('complaint'),
				'painTolerance' => $this->input->post('painTolerance'),
				'medication'    => $this->input->post('medication'),
				'otherDetails'  => $this->input->post('otherDetails'),
				'otherNotes'    => $this->input->post('otherNotes'),
			];

			$this->db->where('mrID', $id);
			$this->db->update('medical_records', $update);

			$this->session->set_flashdata('success', 'Medical record updated successfully.');
			redirect('Page/medRecords');
			return;
		}

		$data['record'] = $record;
		$this->load->view('medical_records_update', $data);
	}



	public function medInfo()
	{
		$this->load->model('StudentModel');

		// For student user
		if ($this->session->userdata('level') === 'Student') {
			$id = $this->session->userdata('username');
			$result['data'] = $this->StudentModel->medInfo_stude($id);
			$this->load->view('medical_info', $result);
			return;
		}

		// Determine filter
		$filter = $this->input->get('filter') ?? 'student';

		if ($filter === 'staff') {
			$result['data'] = $this->StudentModel->medInfo_staff();
			$result['isStaff'] = true;
		} else {
			$result['data'] = $this->StudentModel->medInfo();
			$result['isStaff'] = false;
		}

		// These two lines are important
		$result['students'] = $this->StudentModel->searchStudents();
		$result['data1'] = $this->StudentModel->searchStaff();
		$this->load->view('medical_info', $result);

		// Handle form submission
		if ($this->input->post('submit')) {
			$acctGroup = $this->input->post('AcctGroup');

			// Use IDNumber if staff, StudentNumber if student
			$studentNumber = ($acctGroup === 'Staff')
				? $this->input->post('IDNumber')
				: $this->input->post('StudentNumber');

			$data = [
				'AcctGroup' => $acctGroup,
				'StudentNumber' => $studentNumber,
				'height' => $this->input->post('height'),
				'weight' => $this->input->post('weight'),
				'bloodType' => $this->input->post('bloodType'),
				'vision' => $this->input->post('vision'),
				'allergiesDrugs' => $this->input->post('allergiesDrugs'),
				'allergiesFood' => $this->input->post('allergiesFood'),
				'eyeColor' => $this->input->post('eyeColor'),
				'hairColor' => $this->input->post('hairColor'),
				'specialPhyNeeds' => $this->input->post('specialPhyNeeds'),
				'specialDieNeeds' => $this->input->post('specialDieNeeds'),
				'respiratoryProblems' => $this->input->post('respiratoryProblems'),
			];

			$this->db->insert('medical_info', $data);
			$this->session->set_flashdata('success', 'Medical info added successfully.');
			redirect('Page/medInfo');
		}
	}


	public function deleteMedInfo()
	{
		$id = $this->input->get('id');
		$que = $this->db->query("delete from medical_info where medID='" . $id . "'");
		$this->session->set_flashdata('success', ' Deleted successfully.');
		redirect("Page/medInfo");
	}
	public function updateMedInfo()
	{
		$id = $this->input->get('id');

		$med = $this->db->get_where('medical_info', ['medID' => $id])->row();

		if (!$med) {
			$this->session->set_flashdata('danger', 'Medical record not found.');
			redirect('Page/medInfo');
			return;
		}

		// ✅ Display full name using only StudentNumber
		if ($med->AcctGroup === 'Student') {
			$profile = $this->db->get_where('studeprofile', ['StudentNumber' => $med->StudentNumber])->row();
		} else {
			$profile = $this->db->get_where('staff', ['IDNumber' => $med->StudentNumber])->row(); // ✅ match IDNumber to StudentNumber
		}

		$med->displayName = $profile ? $profile->FirstName . ' ' . $profile->LastName : '';

		// ✅ Handle update
		if ($this->input->post('submit')) {
			$acctGroup = $this->input->post('AcctGroup');

			$updateData = [
				'AcctGroup' => $acctGroup,
				'height' => $this->input->post('height'),
				'weight' => $this->input->post('weight'),
				'bloodType' => $this->input->post('bloodType'),
				'vision' => $this->input->post('vision'),
				'allergiesDrugs' => $this->input->post('allergiesDrugs'),
				'allergiesFood' => $this->input->post('allergiesFood'),
				'eyeColor' => $this->input->post('eyeColor'),
				'hairColor' => $this->input->post('hairColor'),
				'specialPhyNeeds' => $this->input->post('specialPhyNeeds'),
				'specialDieNeeds' => $this->input->post('specialDieNeeds'),
				'respiratoryProblems' => $this->input->post('respiratoryProblems'),
			];

			$this->db->where('medID', $id);
			$this->db->update('medical_info', $updateData);

			$this->session->set_flashdata('success', 'Medical info updated successfully.');
			redirect('Page/medInfo');
		}

		$this->load->model('StudentModel');
		$result['med'] = $med;
		$result['students'] = $this->StudentModel->searchStudents();
		$result['staff'] = $this->StudentModel->searchStaff();
		$this->load->view('medical_info_update', $result);
	}


	public function incidents()
	{
		$this->load->model('StudentModel');

		// Student View
		if ($this->session->userdata('level') === 'Student') {
			$id = $this->session->userdata('username');
			$result['data'] = $this->StudentModel->incidents_stude($id);
			$this->load->view('guidance_incidents', $result);
			return;
		}

		// Determine which filter (student or staff)
		$filter = $this->input->get('filter') ?? 'student';

		if ($filter === 'staff') {
			$result['data'] = $this->StudentModel->incidents_staff();
			$result['isStaff'] = true;
		} else {
			$result['data'] = $this->StudentModel->incidents();
			$result['isStaff'] = false;
		}

		$result['students'] = $this->StudentModel->searchStudents();
		$result['staff'] = $this->StudentModel->searchStaff();

		$this->load->view('guidance_incidents', $result);

		// Handle Submission
		if ($this->input->post('submit')) {
			$sem           = $this->session->userdata('semester');
			$sy            = $this->session->userdata('sy');
			$AcctGroup     = $this->input->post('AcctGroup');

			// ✅ Use only one field: StudentNumber (store staff ID or student number)
			$StudentNumber = ($AcctGroup === 'Staff')
				? $this->input->post('IDNumber')
				: $this->input->post('StudentNumber');

			$data = [
				'StudentNumber' => $StudentNumber ?? '',
				'caseNo'        => $this->input->post('caseNo'),
				'incidentDate'  => $this->input->post('incidentDate'),
				'incPlace'      => $this->input->post('incPlace'),
				'offenseLevel'  => $this->input->post('offenseLevel'),
				'offense'       => $this->input->post('offense'),
				'sanction'      => $this->input->post('sanction'),
				'actionTaken'   => $this->input->post('actionTaken'),
				'sem'           => $sem ?? '',
				'sy'            => $sy ?? '',
				'AcctGroup'     => $AcctGroup ?? '',
			];

			$this->db->insert('guidance_incidents', $data);
			$this->session->set_flashdata('success', 'Incident added successfully.');
			redirect('Page/incidents');
		}
	}


	public function updateIncidents()
	{
		$id = $this->input->get('id');

		// Fetch either student or staff incident depending on which is not null
		$incident = $this->db->get_where('guidance_incidents', ['incID' => $id])->row();

		if (!$incident) {
			$this->session->set_flashdata('danger', 'Incident record not found.');
			redirect('Page/incidents');
			return;
		}

		if ($this->input->post('submit')) {
			$AcctGroup = $this->input->post('AcctGroup');

			$data = [
				'caseNo'        => $this->input->post('caseNo'),
				'incidentDate'  => $this->input->post('incidentDate'),
				'incPlace'      => $this->input->post('incPlace'),
				'offenseLevel'  => $this->input->post('offenseLevel'),
				'offense'       => $this->input->post('offense'),
				'sanction'      => $this->input->post('sanction'),
				'actionTaken'   => $this->input->post('actionTaken'),
				'AcctGroup'     => $AcctGroup,
			];

			$this->db->where('incID', $id);
			$this->db->update('guidance_incidents', $data);

			$this->session->set_flashdata('success', 'Updated successfully.');
			redirect('Page/incidents');
		}

		$result['incident'] = $incident;
		$this->load->view('guidance_incidents_update', $result);
	}



	public function deleteIncident()
	{
		$id = $this->input->get('id');
		$que = $this->db->query("delete from guidance_incidents where incID='" . $id . "'");
		$this->session->set_flashdata('success', ' Deleted successfully.');
		redirect("Page/incidents");
	}

	public function counselling()
	{
		$this->load->model('StudentModel');

		// Student View
		if ($this->session->userdata('level') === 'Student') {
			$id = $this->session->userdata('username');
			$result['data'] = $this->StudentModel->counselling_stude($id);
			$this->load->view('guidance_counselling', $result);
			return;
		}

		// Filter toggle (student or staff)
		$filter = $this->input->get('filter') ?? 'student';

		if ($filter === 'staff') {
			$result['data'] = $this->StudentModel->counselling_staff();
			$result['isStaff'] = true;
		} else {
			$result['data'] = $this->StudentModel->counselling();
			$result['isStaff'] = false;
		}

		$result['students'] = $this->StudentModel->searchStudents();
		$result['data2'] = $this->StudentModel->searchStaff();

		$this->load->view('guidance_counselling', $result);

		// Handle Submission
		if ($this->input->post('submit')) {
			// $sem            = $this->session->userdata('semester');
			$sy             = $this->session->userdata('sy');
			$AcctGroup      = $this->input->post('AcctGroup');

			// ✅ Unified StudentNumber logic
			$StudentNumber = ($AcctGroup === 'Staff')
				? $this->input->post('IDNumber')
				: $this->input->post('StudentNumber');

			$data = [
				'StudentNumber'  => $StudentNumber,
				'recordNo'       => $this->input->post('recordNo'),
				'recordDate'     => $this->input->post('recordDate'),
				'details'        => $this->input->post('details'),
				'actionPlan'     => $this->input->post('actionPlan'),
				'returnSchedule' => $this->input->post('returnSchedule'),
				// 'sem'            => $sem,
				'sy'             => $sy,
				'AcctGroup'      => $AcctGroup,
			];

			$this->db->insert('guidance_counselling', $data);
			$this->session->set_flashdata('success', 'Counselling record added successfully.');
			redirect('Page/counselling');
		}
	}


	public function updateCounselling()
	{
		$id = $this->input->get('id');

		$counselling = $this->db->get_where('guidance_counselling', ['id' => $id])->row();

		if (!$counselling) {
			$this->session->set_flashdata('danger', 'Record not found.');
			redirect('Page/counselling');
			return;
		}

		if ($this->input->post('submit')) {
			$acctGroup = $this->input->post('AcctGroup');


			$updateData = [
				'AcctGroup'        => $acctGroup,

				'recordNo'         => $this->input->post('recordNo'),
				'recordDate'       => $this->input->post('recordDate'),
				'details'          => $this->input->post('details'),
				'actionPlan'       => $this->input->post('actionPlan'),
				'returnSchedule'   => $this->input->post('returnSchedule'),
			];

			$this->db->where('id', $id);
			$this->db->update('guidance_counselling', $updateData);

			$this->session->set_flashdata('success', 'Counselling record updated successfully.');
			redirect('Page/counselling');
		}

		$result['counselling'] = $counselling;
		$this->load->view('guidance_counselling_update', $result);
	}


	public function deleteCounselling()
	{
		$id = $this->input->get('id');
		$que = $this->db->query("delete from guidance_counselling where id='" . $id . "'");
		$this->session->set_flashdata('success', ' Deleted successfully.');
		redirect("Page/counselling");
	}

	public function get_provinces()
	{
		$provinces = $this->StudentModel->get_provinces();
		echo json_encode($provinces);
	}

	public function get_cities()
	{
		$province = $this->input->post('province');
		$cities = $this->StudentModel->get_cities($province);
		echo json_encode($cities);
	}

	public function get_barangays()
	{
		$city = $this->input->post('city');
		$barangays = $this->StudentModel->get_barangays($city);
		echo json_encode($barangays);
	}

	function inventoryList()
	{
		// Load necessary data
		$data = [
			'data' => $this->StudentModel->getInventory(),
			'data1' => $this->StudentModel->inventorySummary(),
			'data2' => $this->StudentModel->getInventoryCategory(),
			'data3' => $this->StudentModel->getOffice(),
			'data4' => $this->StudentModel->getStaff(),
		];

		// Load the view with data
		$this->load->view('inventory_list1', $data);
	}


	public function updateInventory()
	{
		// Get the itemID from the URL (use get if it's a query string)
		$itemID = $this->input->get('itemID');

		// Fetch the item details using the itemID
		$data['item'] = $this->StudentModel->display_itemsById($itemID);
		$data['data1'] = $this->StudentModel->inventorySummary();
		$data['data2'] = $this->StudentModel->getInventoryCategory();
		$data['data3'] = $this->StudentModel->getOffice();
		$data['data4'] = $this->StudentModel->getStaff();
		$data['data5'] = $this->StudentModel->getBrand();

		// Load the view with the fetched data
		$this->load->view('inventory_update_form', $data);

		// Check if the form is submitted (using 'update' as the submit button name)
		if ($this->input->post('update')) {
			// Get POST data from the form
			$ctrlNo = $this->input->post('ctrlNo');
			$itemName = $this->input->post('itemName');
			$description = $this->input->post('description');
			$qty = $this->input->post('qty');
			$unit = $this->input->post('unit');
			$brand = $this->input->post('brand');
			$serialNo = $this->input->post('serialNo');
			$itemCondition = $this->input->post('itemCondition');
			$accountable = $this->input->post('accountable');
			$acquiredDate = $this->input->post('acquiredDate');
			$itemCategory = $this->input->post('itemCategory');
			$itemSubCategory = $this->input->post('itemSubCategory');
			$model = $this->input->post('model');
			$office = $this->input->post('office');

			// Prepare the data array for updating
			$updatedData = array(
				'ctrlNo' => $ctrlNo,
				'itemName' => $itemName,
				'description' => $description,
				'qty' => $qty,
				'unit' => $unit,
				'brand' => $brand,
				'serialNo' => $serialNo,
				'itemCondition' => $itemCondition,
				'accountable' => $accountable,
				'acquiredDate' => $acquiredDate,
				'itemCategory' => $itemCategory,
				'itemSubCategory' => $itemSubCategory,
				'model' => $model,
				'office' => $office
			);

			// Assuming $itemID is passed to this controller method (you might need to get this from the URL or form)
			$itemID = $this->input->post('itemID'); // or from the URL if you are using URI segments

			// Call the model function to update the item
			$this->StudentModel->updateItem($itemID, $updatedData);

			// Set a flash message to notify the user of the successful update
			$this->session->set_flashdata('inventory', 'Record updated successfully');

			// Redirect to the inventory list page
			redirect("Page/inventoryList");
		}
	}

	function inventoryList1()
	{
		// Load necessary data
		$data = [
			'data' => $this->StudentModel->getInventory(),
			'data1' => $this->StudentModel->inventorySummary(),
			'data2' => $this->StudentModel->getInventoryCategory(),
			'data3' => $this->StudentModel->getOffice(),
			'data4' => $this->StudentModel->getStaff(),
			'data5' => $this->StudentModel->getBrand(),
		];

		// Load the view with data
		$this->load->view('inventory_Form', $data);

		// Check if form is submitted
		if ($this->input->post('submit')) {
			// Collect form data
			$formData = [
				'ctrlNo' => $this->input->post('ctrlNo'),
				'itemName' => $this->input->post('itemName'),
				'description' => $this->input->post('description'),
				'qty' => $this->input->post('qty'),
				'unit' => $this->input->post('unit'),
				'brand' => $this->input->post('brand') ?: '',
				'serialNo' => $this->input->post('serialNo'),
				'itemCondition' => $this->input->post('itemCondition'),
				// 'accountable' => $this->input->post('accountable'),
				'IDNumber' => $this->input->post('accountable'),
				'acquiredDate' => $this->input->post('acquiredDate'),
				'itemCategory' => $this->input->post('itemCategory'),
				'itemSubCategory' => $this->input->post('itemSubCategory'),
				'model' => $this->input->post('model'),
				'office' => $this->input->post('office'),

			];

			// Insert data into the database
			$this->db->insert('ls_items', array_merge($formData, ['settingsID' => 1]));

			// Set flash message and redirect
			$this->session->set_flashdata('success', 'Item successfully added!');
			redirect('Page/inventoryList');
		}
	}


	function inventoryAccountable()
	{
		$accountable = $this->input->get('accountable');
		$result['data'] = $this->StudentModel->getInventoryAccountable($accountable);
		$result['data1'] = $this->StudentModel->inventorySummaryAccountable($accountable);
		$this->load->view('inventory_list_accountable', $result);
	}




	public function getSubcategories()
	{
		$category = $this->input->post('category');

		// Query to get subcategories for the selected category
		$this->db->select('Sub_category');
		$this->db->from('ls_categories');
		$this->db->where('Category', $category);
		$this->db->order_by('Sub_category', 'ASC');

		$query = $this->db->get();
		$subcategories = $query->result_array();

		// Return the subcategories as a JSON response
		if ($subcategories) {
			$result = array_column($subcategories, 'Sub_category');
			echo json_encode(['subcategories' => $result]);
		} else {
			echo json_encode(['subcategories' => null]);
		}
	}


	function DashboardinventoryList()
	{
		// Load all inventory data
		$allData = $this->StudentModel->getInventory();

		// Filter the data to show only items with itemCategory "Machinery and Equipment"
		$filteredData = array_filter($allData, function ($item) {
			return $item->itemCategory === "Machinery and Equipment";
		});

		// Prepare the filtered data to pass to the view
		$data = [
			'data' => $filteredData,
		];

		// Load the view with the filtered data
		$this->load->view('dashboard_p_custodianForm', $data);
	}

	function DashboardinventoryList1()
	{
		// Load all inventory data
		$allData = $this->StudentModel->getInventory();

		// Filter the data to show only items with itemCategory "Machinery and Equipment"
		$filteredData = array_filter($allData, function ($item) {
			return $item->itemCategory === "Transportation Equipment";
		});

		// Prepare the filtered data to pass to the view
		$data = [
			'data' => $filteredData,
		];

		// Load the view with the filtered data
		$this->load->view('dashboard_p_custodianForm1', $data);
	}

	function DashboardinventoryList2()
	{
		// Load all inventory data
		$allData = $this->StudentModel->getInventory();

		// Filter the data to show only items with itemCategory "Machinery and Equipment"
		$filteredData = array_filter($allData, function ($item) {
			return $item->itemCategory === "Furniture Fixtures and Books";
		});

		// Prepare the filtered data to pass to the view
		$data = [
			'data' => $filteredData,
		];

		// Load the view with the filtered data
		$this->load->view('dashboard_p_custodianForm2', $data);
	}

	function DashboardinventoryList3()
	{
		// Load all inventory data
		$allData = $this->StudentModel->getInventory();

		// Filter the data to show only items with itemCategory "Machinery and Equipment"
		$filteredData = array_filter($allData, function ($item) {
			return $item->itemCategory === "OTHERS";
		});

		// Prepare the filtered data to pass to the view
		$data = [
			'data' => $filteredData,
		];

		// Load the view with the filtered data
		$this->load->view('dashboard_p_custodianForm3', $data);
	}

	function Accountable()
	{
		// Get the IDNumber of the logged-in user
		$idNumber = $this->session->userdata('IDNumber');

		// Fetch inventory data based on the IDNumber
		$data['data'] = $this->StudentModel->getInventoryByUserID($idNumber);

		// Load the view with the filtered data
		$this->load->view('Accountable', $data);
	}

	function modify_grades()
	{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
		$this->form_validation->set_rules('FirstName', 'First Name', 'required');

		if ($this->form_validation->run() == FALSE) {

			$page = "mg";

			if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
				show_404();
			}

			$data['title'] = "New Profile";
			$data['studs'] = $this->Common->two_join_one_cond_gb('grades', 'studeprofile', 'StudentNumber,FirstName,MiddleName,LastName,SY', 'StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');

			$data['stud_register'] = $this->Common->one_cond_gb('grades', 'SY', $this->session->sy, 'StudentNumber', 'StudentNumber', 'ASC');

			$data['grades'] = $this->Common->two_cond('grades', 'SY', $this->session->sy, 'StudentNumber', $this->input->post('sn'));
			$data['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->input->post('sn'));
			$data['g'] = $this->Common->two_cond_row('registration', 'SY', $this->session->sy, 'StudentNumber', $this->input->post('sn'));



			$this->load->view($page, $data);
		} else {
			$this->Ren_model->profile_insert();
			$this->Ren_model->user_insert();
			$this->Ren_model->atrail_insert("Created Student's Profile and User Account");
			$this->session->set_flashdata('success', 'Profile has been saved successfully.');
			redirect(base_url() . 'Ren/profileEntry');
		}
	}

	function modify_gradesv2()
	{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
		$this->form_validation->set_rules('FirstName', 'First Name', 'required');

		if ($this->form_validation->run() == FALSE) {

			$page = "mgv2";

			if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
				show_404();
			}

			$data['title'] = "New Profile";
			$data['studs'] = $this->Common->two_join_one_cond_gb('grades', 'studeprofile', 'StudentNumber,FirstName,MiddleName,LastName,SY', 'StudentNumber', 'SY', $this->session->sy, 'LastName', 'ASC');

			$data['stud_register'] = $this->Common->one_cond_gb('grades', 'SY', $this->session->sy, 'StudentNumber', 'StudentNumber', 'ASC');

			$data['grades'] = $this->Common->two_cond('grades', 'SY', $this->session->sy, 'StudentNumber', $this->uri->segment(3));
			$data['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->uri->segment(3));
			$data['g'] = $this->Common->two_cond_row('registration', 'SY', $this->session->sy, 'StudentNumber', $this->uri->segment(3));



			$this->load->view($page, $data);
		} else {
			$this->Ren_model->profile_insert();
			$this->Ren_model->user_insert();
			$this->Ren_model->atrail_insert("Created Student's Profile and User Account");
			$this->session->set_flashdata('success', 'Profile has been saved successfully.');
			redirect(base_url() . 'Ren/profileEntry');
		}
	}

	function mg_update()
	{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
		$this->form_validation->set_rules('FirstName', 'First Name', 'required');

		if ($this->form_validation->run() == FALSE) {

			$page = "mg_update";

			if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
				show_404();
			}

			$data['title'] = "New Profile";
			//$data['grade'] = $this->Common->two_cond('grades','StudentNumber',$this->input->post('sn'), 'SY', $this->session->sy);
			//$result['grades'] = $this->Common->two_join_three_condv2('grades', 'studeprofile', 'a.StudentNumber, b.StudentNumber, a.SY, a.Sem, b.FirstName, b.MiddleName, b.LastName,a.Instructor,a.SubjectCode,a.Description,a.Section,a.adviser,a.gradeID,a.PGrade, a.MGrade, a.PFinalGrade, a.FGrade, a.Average,  a.firstStat, a.secondStat, a.thirdStat, a.fourthStat, a.YearLevel, b.Sex', 'a.StudentNumber = b.StudentNumber', 'SY', $this->session->sy, 'Section', $section, 'SubjectCode', $subjectcode, "CASE WHEN b.Sex = 'Male' THEN 0 WHEN b.Sex = 'Female' THEN 1 ELSE 2 END", 'ASC', 'LastName', 'ASC');

			$data['grades'] = $this->Common->two_cond('grades', 'SY', $this->session->sy, 'StudentNumber', $this->input->post('sn'));
			$data['stud'] = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $this->input->post('sn'));
			$data['g'] = $this->Common->two_cond_row('registration', 'SY', $this->session->sy, 'StudentNumber', $this->input->post('sn'));


			$this->load->view($page, $data);
		} else {
			$this->Ren_model->profile_insert();
			$this->Ren_model->user_insert();
			$this->Ren_model->atrail_insert("Created Student's Profile and User Account");
			$this->session->set_flashdata('success', 'Profile has been saved successfully.');
			redirect(base_url() . 'Ren/profileEntry');
		}
	}

	function ren()
	{
		$data['title'] = "renre";
		$data['records'] = $this->Common->one_cond('grades', 'StudentNumber', '2012139', 'YearLevel', 'Grade 12');
		$this->load->view('ren', $data);
	}

	public function update_grades()
	{
		// Retrieve school year from session
		$sy = $this->session->userdata('sy');

		// SQL query to update l_p, l_m, l_pf, l_f, Average, and l_average
		$sql = "
		UPDATE grades
		SET 
			l_p = CASE
				WHEN PGrade BETWEEN 70 AND 74.44 THEN 'B'
				WHEN PGrade BETWEEN 74.45 AND 81.44 THEN 'D'
				WHEN PGrade BETWEEN 81.45 AND 88.44 THEN 'AP'
				WHEN PGrade BETWEEN 88.45 AND 94.44 THEN 'P'
				WHEN PGrade BETWEEN 94.45 AND 100 THEN 'A'
				ELSE l_p
			END,
			l_m = CASE
				WHEN MGrade BETWEEN 70 AND 74.44 THEN 'B'
				WHEN MGrade BETWEEN 74.45 AND 81.44 THEN 'D'
				WHEN MGrade BETWEEN 81.45 AND 88.44 THEN 'AP'
				WHEN MGrade BETWEEN 88.45 AND 94.44 THEN 'P'
				WHEN MGrade BETWEEN 94.45 AND 100 THEN 'A'
				ELSE l_m
			END,
			l_pf = CASE
				WHEN PFinalGrade BETWEEN 70 AND 74.44 THEN 'B'
				WHEN PFinalGrade BETWEEN 74.45 AND 81.44 THEN 'D'
				WHEN PFinalGrade BETWEEN 81.45 AND 88.44 THEN 'AP'
				WHEN PFinalGrade BETWEEN 88.45 AND 94.44 THEN 'P'
				WHEN PFinalGrade BETWEEN 94.45 AND 100 THEN 'A'
				ELSE l_pf
			END,
			l_f = CASE
				WHEN FGrade BETWEEN 70 AND 74.44 THEN 'B'
				WHEN FGrade BETWEEN 74.45 AND 81.44 THEN 'D'
				WHEN FGrade BETWEEN 81.45 AND 88.44 THEN 'AP'
				WHEN FGrade BETWEEN 88.45 AND 94.44 THEN 'P'
				WHEN FGrade BETWEEN 94.45 AND 100 THEN 'A'
				ELSE l_f
			END,
			Average = CASE 
				WHEN YearLevel IN ('Grade 11', 'Grade 12') THEN (PGrade + MGrade) / 2
				ELSE (PGrade + MGrade + PFinalGrade + FGrade) / 4
			END,
			l_average = CASE
				WHEN 
					(CASE 
						WHEN YearLevel IN ('Grade 11', 'Grade 12') THEN (PGrade + MGrade) / 2
						ELSE (PGrade + MGrade + PFinalGrade + FGrade) / 4
					END) BETWEEN 70 AND 74.44 THEN 'B'
				WHEN 
					(CASE 
						WHEN YearLevel IN ('Grade 11', 'Grade 12') THEN (PGrade + MGrade) / 2
						ELSE (PGrade + MGrade + PFinalGrade + FGrade) / 4
					END) BETWEEN 74.45 AND 81.44 THEN 'D'
				WHEN 
					(CASE 
						WHEN YearLevel IN ('Grade 11', 'Grade 12') THEN (PGrade + MGrade) / 2
						ELSE (PGrade + MGrade + PFinalGrade + FGrade) / 4
					END) BETWEEN 81.45 AND 88.44 THEN 'AP'
				WHEN 
					(CASE 
						WHEN YearLevel IN ('Grade 11', 'Grade 12') THEN (PGrade + MGrade) / 2
						ELSE (PGrade + MGrade + PFinalGrade + FGrade) / 4
					END) BETWEEN 88.45 AND 94.44 THEN 'P'
				WHEN 
					(CASE 
						WHEN YearLevel IN ('Grade 11', 'Grade 12') THEN (PGrade + MGrade) / 2
						ELSE (PGrade + MGrade + PFinalGrade + FGrade) / 4
					END) BETWEEN 94.45 AND 100 THEN 'A'
				ELSE l_average
			END
		WHERE sy = ?;
	";
		// Execute the query
		$result = $this->db->query($sql, [$sy]);
		// Set flashdata message
		if ($result) {
			$this->session->set_flashdata('success', 'Grades updated successfully!');
		} else {
			$this->session->set_flashdata('success', 'Failed to update grades.');
		}

		// Redirect to landing page
		redirect('Page/grades_updated');
	}

	public function grades_updated()
	{
		$this->load->view('grades_landing_page');
	}


	public function studeAdditional()
	{
		$result['letterhead'] = $this->Login_model->loginImage();
		$studentno = $this->input->get('studentno');
		$sem = $this->input->get('sem');
		$sy = $this->input->get('sy');
		$result['data'] = $this->StudentModel->studeAdditional($studentno, $sem, $sy);
		$this->load->view('stude_addFees', $result);
	}


	public function addFees()
	{
		$studentNumber = $this->input->post('studentno');
		$addAmount = $this->input->post('add_amount');
		$schoolYear = $this->input->post('sy');

		// Prepare data for additional fees insertion
		$data = array(
			'StudentNumber' => $studentNumber,
			'add_desc' => $this->input->post('add_desc'),
			'add_amount' => $addAmount,
			'SY' => $schoolYear
		);

		// Insert the additional fee record
		if ($this->StudentModel->insertAddFees($data)) {
			// 🔹 Directly update AddFees and CurrentBalance using SQL (prevents overwrite issue)
			$this->db->where('StudentNumber', $studentNumber);
			$this->db->where('SY', $schoolYear);
			$this->db->set('AddFees', 'AddFees + ' . (float)$addAmount, FALSE); // Adds to existing AddFees
			$this->db->set('CurrentBalance', 'CurrentBalance + ' . (float)$addAmount, FALSE); // Adds to balance
			$this->db->update('studeaccount');

			$this->session->set_flashdata('success', 'Additional fee added successfully!');
		} else {
			$this->session->set_flashdata('error', 'Failed to add additional fee.');
		}

		redirect('Page/studeAdditional?studentno=' . $studentNumber . '&sy=' . $schoolYear);
	}



	public function updateFees()
	{
		$adID = $this->input->post('adID');
		$studentNumber = $this->input->post('studentno');
		$newAddAmount = $this->input->post('add_amount');
		$schoolYear = $this->input->post('sy');

		// Fetch the old additional fee amount
		$this->db->where('adID', $adID);
		$oldAddData = $this->db->get('studeadditional')->row();

		if ($oldAddData) {
			$oldAddAmount = $oldAddData->add_amount;
			$feeDifference = $newAddAmount - $oldAddAmount; // Calculate change in fee

			// ✅ Update the `studeadditional` table with the new values
			$data = array(
				'StudentNumber' => $studentNumber,
				'add_desc' => $this->input->post('add_desc'),
				'add_amount' => $newAddAmount, // Save the new fee amount
				'SY' => $schoolYear
			);

			if ($this->StudentModel->editAddfees($adID, $data)) {
				// 🔹 Recalculate the total `AddFees` from `studeadditional`
				$this->db->select_sum('add_amount');
				$this->db->where('StudentNumber', $studentNumber);
				$this->db->where('SY', $schoolYear);
				$newTotalAddFees = $this->db->get('studeadditional')->row()->add_amount;

				// 🔹 Fetch current student balance
				$this->db->where('StudentNumber', $studentNumber);
				$this->db->where('SY', $schoolYear);
				$account = $this->db->get('studeaccount')->row();

				if ($account) {
					// ✅ Adjust `CurrentBalance` based on increase/decrease in `AddFees`
					$newBalance = $account->CurrentBalance + $feeDifference;

					// 🔹 Update the student account with the correct `AddFees` and `CurrentBalance`
					$updateData = array(
						'AddFees' => $newTotalAddFees,
						'CurrentBalance' => $newBalance
					);

					$this->StudentModel->updateStudentAccount($studentNumber, $schoolYear, $updateData);
				}

				$this->session->set_flashdata('success', 'Additional fee updated successfully!');
			} else {
				$this->session->set_flashdata('error', 'Failed to update additional fee.');
			}
		}

		redirect('Page/studeAdditional?studentno=' . $studentNumber . '&sy=' . $schoolYear);
	}


	public function deleteFees($adID)
	{
		// Fetch the additional fee details before deletion
		$this->db->where('adID', $adID);
		$addData = $this->db->get('studeadditional')->row();

		if ($addData) {
			$studentNumber = $addData->StudentNumber;
			$addAmount = $addData->add_amount;
			$schoolYear = $addData->SY;

			// 🔹 Get the total sum of remaining additional fees *excluding* the one being deleted
			$this->db->select_sum('add_amount');
			$this->db->where('StudentNumber', $studentNumber);
			$this->db->where('SY', $schoolYear);
			$this->db->where('adID !=', $adID); // Exclude the deleted one
			$remainingFees = $this->db->get('studeadditional')->row()->add_amount ?? 0;

			// 🔹 Fetch current student balance from `studeaccount`
			$this->db->where('StudentNumber', $studentNumber);
			$this->db->where('SY', $schoolYear);
			$account = $this->db->get('studeaccount')->row();

			if ($account) {
				// Deduct only the specific amount being deleted
				$newTotalAddFees = max(0, $remainingFees); // Update to remaining total, not zero
				$newBalance = $account->CurrentBalance - $addAmount; // Deduct from balance

				// Update the student account with the new `AddFees` and `CurrentBalance`
				$updateData = array(
					'AddFees' => $newTotalAddFees,
					'CurrentBalance' => $newBalance
				);

				$this->StudentModel->updateStudentAccount($studentNumber, $schoolYear, $updateData);
			}

			// Delete the additional fee record
			if ($this->StudentModel->removeAddFees($adID)) {
				$this->session->set_flashdata('success', 'Additional fee deleted successfully!');
			} else {
				$this->session->set_flashdata('error', 'Failed to delete additional fee.');
			}
		} else {
			$this->session->set_flashdata('error', 'Additional fee record not found.');
		}

		redirect('Page/studeAdditional?studentno=' . $studentNumber . '&sy=' . $schoolYear);
	}

	public function studentsForm()
	{
		$semstudentid = $this->input->get('id'); // fetch from URL

		// get the StudentNumber based on semstudentid
		$student = $this->db->get_where('semesterstude', ['semstudentid' => $semstudentid])->row();

		if ($student) {
			$studentNumber = $student->StudentNumber;
			$result['letterhead'] = $this->Login_model->loginImage();
			$result['data'] = $this->StudentModel->studentDetails($studentNumber);
			$this->load->view('studentsForm', $result);
		}
	}


	public function studentsForm1()
	{
		$semstudentid = $this->input->get('id'); // fetch from URL

		// get the StudentNumber based on semstudentid
		$student = $this->db->get_where('semesterstude', ['semstudentid' => $semstudentid])->row();

		if ($student) {
			$studentNumber = $student->StudentNumber;
			$result['letterhead'] = $this->Login_model->loginImage();
			$result['data'] = $this->StudentModel->studentDetails($studentNumber);
			$this->load->view('studentsForm1', $result);
		}
	}


	public function studentsForm2()
	{
		$semstudentid = $this->input->get('id'); // fetch from URL

		// get the StudentNumber based on semstudentid
		$student = $this->db->get_where('semesterstude', ['semstudentid' => $semstudentid])->row();

		if ($student) {
			$studentNumber = $student->StudentNumber;
			$result['letterhead'] = $this->Login_model->loginImage();
			$result['data'] = $this->StudentModel->studentDetails($studentNumber);
			$this->load->view('studentsForm2', $result);
		}
	}

	public function studentsForm3()
	{
		$semstudentid = $this->input->get('id'); // fetch from URL

		// get the StudentNumber based on semstudentid
		$student = $this->db->get_where('semesterstude', ['semstudentid' => $semstudentid])->row();

		if ($student) {
			$studentNumber = $student->StudentNumber;
			$result['letterhead'] = $this->Login_model->loginImage();
			$result['data'] = $this->StudentModel->studentDetails($studentNumber);
			$this->load->view('studentsForm3', $result);
		}
	}

	public function studentsForm4()
	{
		$semstudentid = $this->input->get('id'); // fetch from URL

		// get the StudentNumber based on semstudentid
		$student = $this->db->get_where('semesterstude', ['semstudentid' => $semstudentid])->row();

		if ($student) {
			$studentNumber = $student->StudentNumber;
			$result['letterhead'] = $this->Login_model->loginImage();
			$result['data'] = $this->StudentModel->studentDetails($studentNumber);
			$this->load->view('studentsForm4', $result);
		}
	}


	// public function studentsForm()
	// {

	// 	$result['letterhead'] = $this->Login_model->loginImage();
	// 	$result['letterhead'] = $this->StudentModel->studentDetails();
	// 	$this->load->view('studentsForm', $result);
	// }

	// public function studentsForm1()
	// {
	// 	$result['letterhead'] = $this->Login_model->loginImage();
	// 	$this->load->view('studentsForm1', $result);
	// }

	// public function studentsForm2()
	// {
	// 	$result['letterhead'] = $this->Login_model->loginImage();
	// 	$this->load->view('studentsForm2', $result);
	// }

	// public function studentsForm3()
	// {
	// 	$result['letterhead'] = $this->Login_model->loginImage();
	// 	$this->load->view('studentsForm3', $result);
	// }

	// public function studentsForm4()
	// {
	// 	$result['letterhead'] = $this->Login_model->loginImage();
	// 	$this->load->view('studentsForm4', $result);
	// }






	public function studeDiscounts()
	{
		$result['letterhead'] = $this->Login_model->loginImage();
		$studentno = $this->input->get('studentno');
		$sem = $this->input->get('sem');
		$sy = $this->input->get('sy');
		$result['data'] = $this->StudentModel->studeDiscount($studentno, $sem, $sy);
		$this->load->view('stude_discount', $result);
	}

	public function addDiscount()
	{
		$studentNumber = $this->input->post('studentno');
		$discountAmount = $this->input->post('discount_amount');
		$schoolYear = $this->input->post('sy');

		// Prepare data for discount insertion
		$data = array(
			'StudentNumber' => $studentNumber,
			'discount_desc' => $this->input->post('discount_desc'),
			'discount_amount' => $discountAmount,
			'SY' => $schoolYear
		);

		// Insert the discount record
		if ($this->StudentModel->insertDiscount($data)) {
			// Fetch current discount and balance from studeaccount
			$this->db->where('StudentNumber', $studentNumber);
			$this->db->where('SY', $schoolYear);
			$account = $this->db->get('studeaccount')->row();

			if ($account) {
				$newDiscount = $account->Discount + $discountAmount;
				$newBalance = $account->CurrentBalance - $discountAmount;

				// Update the student account with the new discount and balance
				$updateData = array(
					'Discount' => $newDiscount,
					'CurrentBalance' => $newBalance
				);

				$this->StudentModel->updateStudentAccount($studentNumber, $schoolYear, $updateData);
			}

			$this->session->set_flashdata('success', 'Discount added successfully!');
		} else {
			$this->session->set_flashdata('error', 'Failed to add discount.');
		}

		redirect('Page/studeDiscounts?studentno=' . $studentNumber . '&sy=' . $schoolYear);
	}


	public function updateDiscount()
	{
		$disID = $this->input->post('disID');
		$studentNumber = $this->input->post('studentno');
		$newDiscountAmount = $this->input->post('discount_amount');
		$schoolYear = $this->input->post('sy');

		// Fetch the old discount amount
		$this->db->where('disID', $disID); // Correct column name
		$oldDiscountData = $this->db->get('studediscount')->row();

		if ($oldDiscountData) {
			$oldDiscountAmount = $oldDiscountData->discount_amount;
			$discountDifference = $newDiscountAmount - $oldDiscountAmount;

			// Fetch current discount and balance from studeaccount
			$this->db->where('StudentNumber', $studentNumber);
			$this->db->where('SY', $schoolYear);
			$account = $this->db->get('studeaccount')->row();

			if ($account) {
				$newTotalDiscount = $account->Discount + $discountDifference;
				$newBalance = $account->CurrentBalance - $discountDifference;

				// Update the student account with the new discount and balance
				$updateData = array(
					'Discount' => $newTotalDiscount,
					'CurrentBalance' => $newBalance
				);

				$this->StudentModel->updateStudentAccount($studentNumber, $schoolYear, $updateData);
			}
		}

		// Prepare data for discount update
		$data = array(
			'StudentNumber' => $studentNumber,
			'discount_desc' => $this->input->post('discount_desc'),
			'discount_amount' => $newDiscountAmount,
			'SY' => $schoolYear
		);

		if ($this->StudentModel->editDiscount($disID, $data)) {
			$this->session->set_flashdata('success', 'Discount updated successfully!');
		} else {
			$this->session->set_flashdata('error', 'Failed to update discount.');
		}

		redirect('Page/studeDiscounts?studentno=' . $studentNumber . '&sy=' . $schoolYear);
	}



	public function deleteDiscount($disID)
	{
		// Fetch the discount details before deletion
		$this->db->where('disID', $disID);
		$discountData = $this->db->get('studediscount')->row();

		if ($discountData) {
			$studentNumber = $discountData->StudentNumber;
			$discountAmount = $discountData->discount_amount;
			$schoolYear = $discountData->SY;

			// Fetch current discount and balance from studeaccount
			$this->db->where('StudentNumber', $studentNumber);
			$this->db->where('SY', $schoolYear);
			$account = $this->db->get('studeaccount')->row();

			if ($account) {
				$newTotalDiscount = max(0, $account->Discount - $discountAmount); // Prevent negative discount
				$newBalance = $account->CurrentBalance + $discountAmount;

				// Update the student account with the new discount and balance
				$updateData = array(
					'Discount' => $newTotalDiscount,
					'CurrentBalance' => $newBalance
				);

				$this->StudentModel->updateStudentAccount($studentNumber, $schoolYear, $updateData);
			}
		} else {
			$this->session->set_flashdata('error', 'Discount record not found.');
			redirect('Page/studeDiscounts?studentno=' . $this->input->post('studentno') . '&sy=' . $this->input->post('sy'));
			return;
		}

		// Delete the discount record
		if ($this->StudentModel->removeDiscount($disID)) {
			$this->session->set_flashdata('success', 'Discount deleted successfully!');
		} else {
			$this->session->set_flashdata('error', 'Failed to delete discount.');
		}

		redirect('Page/studeDiscounts?studentno=' . $studentNumber . '&sy=' . $schoolYear);
	}








	function school_info()
	{
		//Allowing access to Accounting only
		if ($this->session->userdata('level') === 'Super Admin') {
			$result['data'] = $this->SettingsModel->getSchoolInformation();
			$this->load->view('schoolInfo', $result);
		} else {
			echo "Access Denied";
		}
	}

	public function updateSuperAdmin()
	{
		$settingsID = $this->input->get('settingsID');
		$result['data'] = $this->SettingsModel->getSuperAdminbyId($settingsID);
		$this->load->view('update_Superadmin', $result);

		if ($this->input->post('update')) {
			// File upload for schoolLogo
			$schoolLogo = $this->uploadImage('schoolLogo');

			// File upload for letterHead
			$letterHead = $this->uploadImage('letterHead');

			// Collecting form data
			$data = array(
				'SchoolName' => $this->input->post('SchoolName'),
				'SchoolAddress' => $this->input->post('SchoolAddress'),
				'SchoolHead' => $this->input->post('SchoolHead'),
				'sHeadPosition' => $this->input->post('sHeadPosition'),
				'RegistrarSHS' => $this->input->post('RegistrarSHS'),
				'RegistrarJHS' => $this->input->post('RegistrarJHS'),
				'GuidanceSHS' => $this->input->post('GuidanceSHS'),
				'GuidanceJHS' => $this->input->post('GuidanceJHS'),
				'financeOfficer' => $this->input->post('financeOfficer'),
				'DBName' => $this->input->post('DBName'),
				'schoolLogo' => $schoolLogo, // Save filename
				'letterHead' => $letterHead, // Save filename
				'PropertyCustodian' => $this->input->post('PropertyCustodian'),
			);

			$this->SettingsModel->updateSuperAdmin($settingsID, $data);
			$this->session->set_flashdata('msg', 'Record updated successfully');
			redirect('Page/superAdmin');
		}
	}

	/**
	 * Uploads an image and returns the filename.
	 */
	private function uploadImage($fieldName)
	{
		$config['upload_path'] = './assets/images/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = 2048; // 2MB
		$config['encrypt_name'] = TRUE; // Encrypt filename for uniqueness

		$this->load->library('upload', $config);

		if ($this->upload->do_upload($fieldName)) {
			$uploadData = $this->upload->data();
			return $uploadData['file_name']; // Return the filename
		} else {
			// If no file was uploaded, keep the existing value
			return $this->input->post($fieldName . '_existing');
		}
	}





	public function system_setting()
	{
		$this->load->model('SettingsModel');

		// Fetch existing settings from the database
		$result['data'] = $this->SettingsModel->getSchoolInformation();
		$result['settings'] = $this->SettingsModel->get_settings();

		// Handle form submission for updating settings
		if ($this->input->post()) {
			$this->form_validation->set_rules('schoolType', 'School Type', 'required');
			$this->form_validation->set_rules('gradeDisplay', 'Grade Display', 'required');

			if ($this->form_validation->run()) {
				$updateData = array(
					'schoolType' => $this->input->post('schoolType'),
					'gradeDisplay' => $this->input->post('gradeDisplay')
				);

				$this->SettingsModel->update_settings($updateData);
				$this->session->set_flashdata('success', 'Settings updated successfully.');
				redirect('Page/system_setting'); // Reload page to show changes
			} else {
				$this->session->set_flashdata('error', 'Validation failed. Please check your input.');
			}
		}

		$this->load->view('system_setting', $result);
	}


	public function system_setting_update()
{
    // Only allow POST + AJAX
    if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['ok' => false, 'msg' => 'Invalid request']));
    }

    $field = $this->input->post('field', true);
    $value = $this->input->post('value', true);

    $this->load->model('SettingsModel');
    $ok = $this->SettingsModel->update_setting_field($field, $value);

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['ok' => (bool)$ok]));
}


	// public function system_setting_update()
	// {
	// 	$field = $this->input->post('field');
	// 	$value = $this->input->post('value');

	// 	if ($field && $value) {
	// 		$this->load->model('SettingsModel');
	// 		$updateData = [$field => $value];

	// 		if ($this->SettingsModel->update_settings($updateData)) {
	// 			echo "success";
	// 		} else {
	// 			echo "error";
	// 		}
	// 	} else {
	// 		echo "error";
	// 	}
	// }



	public function MultiPayment()
	{
		$this->load->model('SettingsModel');

		$Sem = $this->session->userdata('semester');
		$SY  = $this->session->userdata('sy');

		$today       = date('Y-m-d');
		$allPayments = $this->SettingsModel->Payment($SY);

		// Filter only today's payments
		$payments = array_filter($allPayments, function ($row) use ($today) {
			return date('Y-m-d', strtotime($row->PDate)) === $today;
		});

		if ($this->input->get('fromDate') && $this->input->get('toDate')) {
			$fromDate = $this->input->get('fromDate');
			$toDate   = $this->input->get('toDate');
			$payments = array_filter($payments, function ($row) use ($fromDate, $toDate) {
				$paymentDate = strtotime($row->PDate);
				return $paymentDate >= strtotime($fromDate) && $paymentDate <= strtotime($toDate);
			});
		}

		$lastOR           = $this->SettingsModel->getLastORNumber();
		$nextORSuggestion = $this->generateNextOR($lastOR);

		$data = [
			'data'             => $payments,
			'prof'             => $this->SettingsModel->semesterstude(),
			'newORSuggestion'  => $nextORSuggestion,
			'SY'               => $SY,
			'groupedPayments'  => $this->groupPayments($payments),
			// ✅ pass the flag to the view
			'orDisplay'        => $this->SettingsModel->getOrDisplayFlag(),
		];

		if ($this->input->post('save_multiple')) {
			$customOR = $this->input->post('ORNumber');
			$this->saveMultiplePayments($SY, $customOR);
			redirect('Page/MultiPayment');
			return;
		}

		$this->load->view('multi_payment', $data);
	}


	private function generateNextOR($lastOR)
	{
		return (string)(intval($lastOR) + 1);
	}

	private function groupPayments($payments)
	{
		$grouped = [];
		foreach ($payments as $row) {
			if (!isset($grouped[$row->description])) {
				$grouped[$row->description] = 0;
			}
			$grouped[$row->description] += $row->Amount;
		}
		return $grouped;
	}

	private function saveMultiplePayments($SY, $customOR)
	{
		$this->load->model('SettingsModel');

		// if ($this->SettingsModel->isORNumberExists($customOR)) {
		//     $this->session->set_flashdata('error', 'The O.R. number already exists. Please enter a unique O.R. number.');
		//     redirect('Page/MultiPayment');
		//     return;
		// }

		$studentNumber = $this->input->post('StudentNumber');
		$pdate = $this->input->post('PDate');
		$descriptions = $this->input->post('description');
		$amounts = $this->input->post('Amount');
		$paymentType = $this->input->post('PaymentType');
		$checkNumber = $this->input->post('CheckNumber');
		$bank = $this->input->post('Bank');
		$course = $this->input->post('Course');
		$source = $this->input->post('CollectionSource');

		// ✅ Get Year Level for feesrecords matching
		$yearLevel = $this->SettingsModel->getYearLevel($studentNumber, $SY);

		$totalInsertedAmount = 0;

		foreach ($descriptions as $index => $desc) {
			$amount = (float)$amounts[$index];
			$totalInsertedAmount += $amount;

			// Insert into paymentsaccounts
			// Insert into paymentsaccounts
			$data = [
				'StudentNumber' => $studentNumber,
				'PaymentType' => $paymentType,
				'description' => $desc,
				'Amount' => $amount,
				'ORNumber' => $customOR,
				'PDate' => $pdate,
				'CheckNumber' => $checkNumber,
				'Bank' => $bank,
				'Cashier' => $this->session->userdata('username'),
				'CollectionSource' => $source,
				'ORStatus' => 'Valid',
				'Course' => $course,
				'SY' => $SY
			];

			$this->SettingsModel->insertpaymentsaccounts($data);

			// ✅ Update feesrecords using the same data
			$this->db->where('StudentNumber', $data['StudentNumber']);
			$this->db->where('Description', $data['description']);
			$this->db->where('SY', $data['SY']);
			$this->db->where('Course', $data['Course']);
			// Optionally: if you also want to match YearLevel
			// $this->db->where('YearLevel', $data['YearLevel']);

			$feeRecord = $this->db->get('feesrecords')->row();

			if ($feeRecord) {
				$currentPaid = is_numeric($feeRecord->amount_Paid) ? floatval($feeRecord->amount_Paid) : 0;
				$updatedPaid = $currentPaid + $data['Amount'];
				$updatedAmount = max(floatval($feeRecord->Amount) - $data['Amount'], 0);

				$this->db->where('feesid', $feeRecord->feesid);
				$this->db->update('feesrecords', [
					'amount_Paid' => $updatedPaid,
					'Amount' => $updatedAmount
				]);
			}
		}

		// Update account balance and monthly schedule
		$acctTotal = $this->SettingsModel->getAcctTotal($studentNumber, $SY);
		$discount = $this->SettingsModel->getDiscount($studentNumber, $SY);
		$totalPayments = $this->SettingsModel->getTotalPayments1($studentNumber, $SY);

		$newBalance = max($acctTotal - ($discount + $totalPayments), 0);
		$this->SettingsModel->updateStudentAccount($studentNumber, $totalPayments, $newBalance, $SY);

		// Monthly Schedule update or generate
		if (!$this->SettingsModel->checkMonthlyScheduleExists($studentNumber, $SY)) {
			$monthSet = $this->SettingsModel->getMonthlyDuration();
			$numMonths = count($monthSet);
			$remainingBalance = max($acctTotal - $discount - $totalInsertedAmount, 0);
			$monthlyAmount = round($remainingBalance / $numMonths, 2);

			foreach ($monthSet as $month) {
				$dueDate = $month->durationOrder;

				$this->SettingsModel->insertMonthlySchedule([
					'StudentNumber' => $studentNumber,
					'SY' => $SY,
					'month_due' => $dueDate,
					'amount' => $monthlyAmount,
					'status' => 'Pending'
				]);
			}
		} else {
			$this->SettingsModel->applyLatestPaymentToMonthlySchedule($studentNumber, $SY, $totalInsertedAmount, $pdate);
		}

		$this->session->set_flashdata('msg', 'Multiple payments added successfully.');
		redirect('Page/MultiPayment');
	}







	// public function massUpdateMonthlySchedule()
	// {
	//     $this->load->model('SettingsModel');

	//     $SY = $this->session->userdata('sy'); // ✅ Use session-stored SY

	//     $studentsWithPayments = $this->SettingsModel->getStudentsWithPayments($SY);

	//     foreach ($studentsWithPayments as $student) {
	//         $studentNumber = $student->StudentNumber;

	//         // Skip if monthly schedule already exists
	//         if ($this->SettingsModel->checkMonthlyScheduleExists($studentNumber, $SY)) continue;

	//         // Fetch payments sorted by date
	//         $payments = $this->SettingsModel->getPaymentsByStudent($studentNumber, $SY);
	//         if (count($payments) < 1) continue;

	//         // First payment is downpayment, exclude it
	//         array_shift($payments);

	//         $totalApplied = 0;
	//         foreach ($payments as $p) {
	//             $totalApplied += $p->Amount;
	//         }

	//         // Get tuition info
	//         $acctTotal = $this->SettingsModel->getAcctTotal($studentNumber, $SY);
	//         $discount = $this->SettingsModel->getDiscount($studentNumber, $SY);
	//         $totalPayments = $this->SettingsModel->getTotalPayments1($studentNumber, $SY);

	//         // Balance after discount and payment
	//         $remainingBalance = max($acctTotal - $discount - $totalPayments, 0);

	//         // Generate monthly
	//         $monthSet = $this->SettingsModel->getMonthlyDuration();
	//         $numMonths = count($monthSet);
	//         $monthlyAmount = round($remainingBalance / $numMonths, 2);

	//         foreach ($monthSet as $month) {
	//             $dueMonthName = date('F', mktime(0, 0, 0, $month->month_number, 1));
	//             $dueDate = date('Y-m-d', strtotime($dueMonthName . " " . date('Y')));

	//             $this->SettingsModel->insertMonthlySchedule([
	//                 'StudentNumber' => $studentNumber,
	//                 'SY' => $SY,
	//                 'month_due' => $dueDate,
	//                 'amount' => $monthlyAmount,
	//                 'status' => 'Pending'
	//             ]);
	//         }

	//         // Apply existing payments (excluding first) to monthly dues
	//         if ($totalApplied > 0) {
	//             $lastPaymentDate = end($payments)->PDate ?? date('Y-m-d');
	//             $this->SettingsModel->applyLatestPaymentToMonthlySchedule($studentNumber, $SY, $totalApplied, $lastPaymentDate);
	//         }
	//     }

	//     $this->session->set_flashdata('msg', 'Mass monthly schedule update completed.');
	//      redirect('Accounting/studeAccounts');
	// }

	public function massUpdateMonthlySchedule()
	{
		$this->load->model('SettingsModel');
		$SY = $this->session->userdata('sy');

		if (empty($SY)) {
			$this->session->set_flashdata('error', 'No active school year found. Cannot proceed.');
			redirect('Accounting/studeAccounts');
			return;
		}

		$studentsWithPayments = $this->SettingsModel->getStudentsWithPayments($SY);
		$updatedCount = 0;

		foreach ($studentsWithPayments as $student) {
			$studentNumber = $student->StudentNumber;

			// Skip if monthly schedule already exists
			if ($this->SettingsModel->checkMonthlyScheduleExists($studentNumber, $SY)) {
				continue;
			}

			// Get all payments
			$payments = $this->SettingsModel->getPaymentsByStudent($studentNumber, $SY);
			if (empty($payments)) continue;

			// Group payments by ORNumber
			$orGrouped = [];
			foreach ($payments as $p) {
				if (!isset($orGrouped[$p->ORNumber])) {
					$orGrouped[$p->ORNumber] = [
						'total' => 0,
						'PDate' => $p->PDate
					];
				}
				$orGrouped[$p->ORNumber]['total'] += $p->Amount;
			}

			// Sort by earliest payment date
			uasort($orGrouped, function ($a, $b) {
				return strtotime($a['PDate']) - strtotime($b['PDate']);
			});

			// Split into Down Payment and Remaining
			$downPayment = 0;
			$otherPayments = 0;
			$count = 0;
			foreach ($orGrouped as $group) {
				if ($count === 0) {
					$downPayment = $group['total'];
				} else {
					$otherPayments += $group['total'];
				}
				$count++;
			}

			// Calculate remaining balance after all payments
			$acctTotal = $this->SettingsModel->getAcctTotal($studentNumber, $SY);
			$discount = $this->SettingsModel->getDiscount($studentNumber, $SY);
			$remainingBalance = max($acctTotal - $discount - $downPayment - $otherPayments, 0);

			// Get month slots
			$monthSet = $this->SettingsModel->getMonthlyDuration(); // now contains durationOrder
			$numMonths = count($monthSet);

			if ($numMonths > 0 && $remainingBalance > 0) {
				$monthlyAmount = round($remainingBalance / $numMonths, 2);

				foreach ($monthSet as $month) {
					$dueDate = $month->durationOrder; // already a valid YYYY-MM-DD

					$this->SettingsModel->insertMonthlySchedule([
						'StudentNumber' => $studentNumber,
						'SY' => $SY,
						'month_due' => $dueDate,
						'amount' => $monthlyAmount,
						'status' => 'Pending'
					]);
				}

				$updatedCount++;
			}
		}

		if ($updatedCount > 0) {
			$this->session->set_flashdata('msg', "$updatedCount student account(s) were successfully updated with monthly schedules.");
		} else {
			$this->session->set_flashdata('info', 'No student account needed an update. All schedules are already set or no payments found.');
		}

		redirect('Accounting/studeAccounts');
	}

	public function deleteSinglePayment($id, $StudentNumber, $OR)
	{
		date_default_timezone_set('Asia/Manila');

		$payment = $this->db->get_where('paymentsaccounts', ['ID' => $id])->row();

		if (!$payment) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Payment not found. Please try again.</div>');
			redirect('Page/MultiPayment'); // Redirect to grouped view
			return;
		}

		$SY = $payment->SY;

		// Delete only that specific entry
		$this->db->where('ID', $id);
		if ($this->db->delete('paymentsaccounts')) {
			$username = $this->session->userdata('username');
			$auditData = [
				'atDesc' => 'Deleted partial payment (' . $payment->description . ') with O.R. No.: ' . $OR,
				'atDate' => date('Y-m-d'),
				'atTime' => date('H:i:s'),
				'atRes' => $username ?: 'Unknown User',
				'atSNo' => $StudentNumber
			];
			$this->db->insert('atrail', $auditData);

			// Recalculate totals
			$acctTotal = $this->SettingsModel->getAcctTotal($StudentNumber, $SY);
			$discount = $this->SettingsModel->getDiscount($StudentNumber, $SY);
			$newTotalPayments = $this->SettingsModel->calculateTotalPayments($StudentNumber, $SY);
			$newBalance = $acctTotal - ($discount + $newTotalPayments);
			$this->SettingsModel->updateStudentAccount($StudentNumber, $newTotalPayments, $newBalance, $SY);

			$this->session->set_flashdata('msg', '<div class="alert alert-success">Single payment item deleted successfully.</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Failed to delete the payment item. Please try again.</div>');
		}

		redirect('Page/MultiPayment'); // Back to grouped view
	}




	public function discountReports()
	{
		$sy = $this->session->userdata('sy');

		$data['discounts'] = $this->db->select('discount_desc, COUNT(*) as count')
			->from('studediscount')
			->where('SY', $sy)
			->group_by('discount_desc')
			->get()->result();

		$this->load->view('accounting_discount_report', $data);
	}

	public function discountDetails()
	{
		$desc = $this->input->get('desc');
		$sy = $this->session->userdata('sy');

		$this->db->select('d.*, s.LastName, s.FirstName, s.MiddleName, s.Sex, s.Course, r.YearLevel')
			->from('studediscount d')
			->join('studeprofile s', 's.StudentNumber = d.StudentNumber', 'left')
			->join('registration r', 'r.StudentNumber = d.StudentNumber')
			->where('d.discount_desc', $desc)
			->where('d.SY', $sy)
			->group_by('d.StudentNumber')
			->order_by('s.LastName, s.Sex'); // alphabetical by LastName

		$data['students'] = $this->db->get()->result();
		$data['desc'] = $desc;
		$data['sy'] = $sy;
		$data['letterhead'] = $this->SettingsModel->getSchoolInformation();

		$this->load->view('accounting_discount_students', $data);
	}


	public function saveNarrative()
	{
		$this->load->database();

		$data = [
			'StudentNumber'   => $this->input->post('StudentNumber'),
			'YearLevel'       => $this->input->post('YearLevel'),
			'Section'         => $this->input->post('Section'),
			'SY'              => $this->input->post('SY'),
			'FirstQuarter'    => $this->input->post('FirstQuarter'),
			'SecondQuarter'   => $this->input->post('SecondQuarter'),
			'ThirdQuarter'    => $this->input->post('ThirdQuarter'),
			'FourthQuarter'   => $this->input->post('FourthQuarter'),
		];

		// Update if exists, insert if not
		$this->db->where([
			'StudentNumber' => $data['StudentNumber'],
			'SY' => $data['SY']
		]);
		$existing = $this->db->get('narrative')->row();

		if ($existing) {
			$this->db->where('narrativeID', $existing->narrativeID);
			$this->db->update('narrative', $data);
			$this->session->set_flashdata('success', 'Narrative updated.');
		} else {
			$this->db->insert('narrative', $data);
			$this->session->set_flashdata('success', 'Narrative saved.');
		}

		redirect('Masterlist/advisoryClass');
	}


	function sbm_action_plan()
	{
		$data['title'] = "Action Plan";

		$_SESSION['sbm_fy'] = $this->input->post('fy');


		$data['data'] = $this->Common->two_cond('sgod_action_plan', 'school_id', $this->session->username, 'fy', $_SESSION['sbm_fy']);
		$this->load->view('templates/head');
		echo '<body> <div id="wrapper">';
		$this->load->view('includes/top-nav-bar');
		$this->load->view('includes/sidebar');
		$this->load->view('sbm_action_plan', $data);
	}

	function sbm_district_tech()
	{
		$data['title'] = "Technical Assisstance Provision Form";


		$data['data'] = $this->Common->one_cond('sbm_tech', 'district', $this->session->c_id);
		$this->load->view('templates/head');
		echo '<body> <div id="wrapper">';
		$this->load->view('includes/top-nav-bar');
		$this->load->view('includes/sidebar');
		$this->load->view('sbm_district_tech', $data);
	}

	function sbm_district_tech_admin()
	{



		$data['data'] = $this->Common->one_cond('sbm_tech', 'district', $this->uri->segment(3));
		$d = $this->Common->one_cond_row('district', 'id', $this->uri->segment(3));
		$data['title'] = "Technical Assisstance Provision - " . $d->discription;
		$this->load->view('templates/head');
		echo '<body> <div id="wrapper">';
		$this->load->view('includes/top-nav-bar');
		$this->load->view('includes/sidebar');
		$this->load->view('sbm_district_tech', $data);
	}

	function sbm_district_tech_new()
	{
		$data['title'] = "Technical Assisstance Provision Form";


		if ($this->input->post('submit')) {
			$this->SGODModel->sbm_tech_insert();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_district_tech');
		}

		$this->load->view('templates/head');
		echo '<body> <div id="wrapper">';
		$this->load->view('includes/top-nav-bar');
		$this->load->view('includes/sidebar');
		$this->load->view('sbm_district_tech_new', $data);
	}

	function sbm_district_tech_edit()
	{
		$data['title'] = "Technical Assisstance Provision Form";

		$data['data'] = $this->Common->one_cond_row('sbm_tech', 'id', $this->uri->segment(3));

		if ($this->input->post('submit')) {
			$this->SGODModel->sbm_tech_update();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_district_tech');
		}

		$this->load->view('templates/head');
		echo '<body> <div id="wrapper">';
		$this->load->view('includes/top-nav-bar');
		$this->load->view('includes/sidebar');
		$this->load->view('sbm_district_tech_update', $data);
	}

	function sbm_action_plan_new()
	{
		$data['title'] = "Action Plan";


		if ($this->input->post('submit')) {
			$this->SGODModel->action_plan_insert();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_action_plan');
		}

		$this->load->view('templates/head');
		echo '<body> <div id="wrapper">';
		$this->load->view('includes/top-nav-bar');
		$this->load->view('includes/sidebar');
		$this->load->view('sbm_action_plan_new', $data);
	}

	function sbm_action_plan_edit()
	{
		$data['title'] = "Action Plan";

		$data['data'] = $this->Common->one_cond_row('sgod_action_plan', 'id', $this->uri->segment(3));


		if ($this->input->post('submit')) {
			$this->SGODModel->action_plan_update();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_action_plan');
		}

		$this->load->view('templates/head');
		echo '<body> <div id="wrapper">';
		$this->load->view('includes/top-nav-bar');
		$this->load->view('includes/sidebar');
		$this->load->view('sbm_action_plan_update', $data);
	}

	function sbm_action_plan_del()
	{
		$this->Common->delete('sgod_action_plan', 'id', 3);
		$this->session->set_flashdata('danger', 'Saved successfully.');
		redirect(base_url() . 'Page/sbm_action_plan');
	}

	function sbm_district_tech_del()
	{
		$this->Common->delete('sbm_tech', 'id', 3);
		$this->session->set_flashdata('danger', 'Saved successfully.');
		redirect(base_url() . 'Page/sbm_district_tech');
	}

	function sbm_action_plan_pview()
	{

		$data['school'] = $this->Common->one_cond_row('schools', 'schoolID', $this->session->username);
		$data['data'] = $this->Common->two_cond('sgod_action_plan', 'fy', $_SESSION['sbm_fy'], 'school_id', $this->session->username);

		$this->load->view('sbm_action_plan_pview', $data);
	}

	function sbm_checklist()
	{
		$ap = $this->Common->two_cond_count_row('sgod_action_plan', 'school_id', $this->session->username, 'fy', $_SESSION['sbm_fy']);
		if ($ap->num_rows() <= 0) {
			redirect(base_url() . 'Page/sbm_action_plan');
		}

		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$result['sbm'] = $this->Common->no_cond('sbm_indicator');
		$result['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');
		//$school = $this->Common->one_cond_row('schools', 'schoolID', $this->session->username);
		//$result['district'] = $this->Common->one_cond_row('district', 'discription', $school->district);

		$result['sbmc'] = $this->Common->two_cond_row('sbm', 'school_id', $this->session->username, 'fy', $_SESSION['sbm_fy']);
		$sbm = $this->Common->two_cond_count_row('sbm', 'school_id', $this->session->username, 'fy', $_SESSION['sbm_fy']);

		if ($sbm->num_rows() <= 0) {

			if ($this->input->post('submit')) {
				$this->SGODModel->sbm_cecklist_insert();
				$this->session->set_flashdata('success', 'Saved successfully.');
				redirect(base_url() . 'Page/sbm_checklist');
			}
			$this->load->view('sbm_form', $result);
		} else {

			$this->load->view('sbm_form_edit', $result);
		}
	}

	function sbm_checklist_final()
	{
		$this->SGODModel->sbm_cecklist_lock_unloc(1);
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/sbm_checklist');
	}

	function sbm_checklist_unlock()
	{
		$this->SGODModel->sbm_cecklist_lock_unloc(0);
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/checklist_district/' . $this->uri->segment(4));
	}

	function checklist_district()
	{

		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$result['sbm'] = $this->Common->no_cond('sbm_indicator');
		$result['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

		$school = $this->Common->one_cond_row('schools', 'schoolID', $this->uri->segment(3));
		$result['district'] = $this->Common->one_cond_row('district', 'discription', $school->district);


		$result['sbmc'] = $this->Common->two_cond_row('sbm', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);
		$sbm = $this->Common->two_cond_count_row('sbm', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);

		$this->load->view('sbm_form_edit', $result);
	}

	function sbm_checklist_edit()
	{
		$this->SGODModel->sbm_cecklist_update();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/sbm_checklist');
	}

	public function delete_sbm()
	{
		$this->Common->del('sbm_indicator', 'id', $this->uri->segment(3));
		$this->Page_model->insert_at('Deleted SBM Principles', $this->uri->segment(3));
		$this->session->set_flashdata('danger', 'Deleted successfully!');
		redirect('Page/sbm');
	}

	public function delete_sbm_sub()
	{
		$this->Common->del('sbm_sub_indicator', 'id', $this->uri->segment(3));
		$this->Page_model->insert_at('Deleted SBM Indicator', $this->uri->segment(3));
		$this->session->set_flashdata('danger', 'Deleted successfully!');
		redirect('Page/sbm_sub');
	}

	function sbm_district_list()
	{
		$_SESSION['sbm_fy'] = $this->input->post('fy');
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$district = $this->Common->one_cond_row('district', 'id', $this->session->c_id);
		$result['school'] = $this->Common->one_cond('schools', 'district', $district->discription);
		$result['sbmc'] = $this->Common->one_cond_row('sbm', 'school_id', $this->session->username);

		if ($this->session->position === 'smme') {
			redirect(base_url() . 'Page/sbm_districts');
		}


		// if ($this->input->post('submit')) {
		// 	$this->SGODModel->sbm_sub_insert();
		// 	$this->session->set_flashdata('success', 'Saved successfully.');
		// 	redirect(base_url() . 'Page/sbm_sub');
		// }

		$this->load->view('sbm_district', $result);
	}

	function sbm_schoo_list_admin()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$district = $this->Common->one_cond_row('district', 'id', $this->uri->segment(3));
		$result['school'] = $this->Common->one_cond('schools', 'district', $district->discription);
		$result['sbmc'] = $this->Common->one_cond_row('sbm', 'school_id', $this->session->username);


		if ($this->input->post('submit')) {
			$this->SGODModel->sbm_sub_insert();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_sub');
		}


		$this->load->view('sbm_district', $result);
	}



	function sbm_district_list_admin()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$district = $this->Common->one_cond_row('district', 'id', $this->uri->segment(3));
		//$result['school']=$this->Common->one_cond('schools','district',$district->discription);
		$result['school'] = $this->Common->one_cond('sbm_submitted', 'district_id', $this->uri->segment(3));

		if ($this->input->post('submit')) {
			$this->SGODModel->sbm_sub_insert();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_sub');
		}


		$this->load->view('sbm_district_admin', $result);
	}

	function sbm_district_list_admin_not()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$district = $this->Common->one_cond_row('district', 'id', $this->uri->segment(3));
		//$result['school']=$this->Common->one_cond('schools','district',$district->discription);
		$result['school'] = $this->Common->one_cond('sbm_submitted', 'district_id', $this->uri->segment(3));

		if ($this->input->post('submit')) {
			$this->SGODModel->sbm_sub_insert();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_sub');
		}


		$this->load->view('sbm_district_admin', $result);
	}

	function sbm_admin()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$district = $this->Common->one_cond_row('district', 'id', $this->session->c_id);
		$result['school'] = $this->Common->no_cond('schools');
		$result['sbmc'] = $this->Common->one_cond_row('sbm', 'school_id', $this->session->username);

		if ($this->input->post('submit')) {
			$this->SGODModel->sbm_sub_insert();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_sub');
		}

		$this->load->view('sbm_admin', $result);
	}

	function sbm_districts()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM - DISTRICT LIST";
		$district = $this->Common->one_cond_row('district', 'id', $this->session->c_id);
		$result['school'] = $this->Common->no_cond('schools');
		$result['sbmc'] = $this->Common->one_cond_row('sbm', 'school_id', $this->session->username);

		$result['district'] = $this->Common->no_cond('district');

		$this->load->view('sbm_district_list', $result);
	}

	function sbm_checklist_district()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$result['sbm'] = $this->Common->no_cond('sbm_indicator');
		$result['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

		$sbm = $this->Common->one_cond_count_row('sbm', 'school_id', $this->uri->segment(3));
		$result['sbmc'] = $this->Common->one_cond_row('sbm', 'school_id', $this->uri->segment(3));

		$result['sbmcr'] = $this->Common->one_cond_row('sbm_remark', 'school_id', $this->uri->segment(3));
		$sbmr = $this->Common->one_cond_count_row('sbm_remark', 'school_id', $this->uri->segment(3));


		if ($sbm->num_rows() <= 0) {
			$this->load->view('sbm_form', $result);
		} else {

			if ($sbmr->num_rows() <= 0) {

				$this->load->view('sbm_district_form', $result);
			} else {

				$this->load->view('sbm_district_form_edit', $result);
			}
		}


		if ($this->input->post('submit')) {
			$this->SGODModel->sbm_cecklist_district_insert();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/sbm_checklist');
		}
	}

	function tapr_form_district()
	{

		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$result['sbm'] = $this->Common->no_cond('sbm_indicator');
		$result['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

		if ($this->session->position == 'smme') {
			$sbm = $this->Common->two_cond_count_row('sbm_remark_admin', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);
		} else {
			$sbm = $this->Common->two_cond_count_row('sbm_remark', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);
		}

		//$result['sbmc'] = $this->Common->two_cond_row('sbm','school_id',$this->uri->segment(3),'fy',date('Y'));
		$result['sbm_ta'] = $this->Common->two_cond_row('sbm_ta', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);
		$result['sbm_remark'] = $this->Common->two_cond_row('sbm_remark', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);
		$result['sbm_remark_admin'] = $this->Common->two_cond_row('sbm_remark_admin', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);
		$result['sbmc'] = $this->Common->two_cond_row('sbm_ta', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);
		$result['sbmc_count'] = $this->Common->two_cond_count_row('sbm_ta', 'school_id', $this->uri->segment(3), 'fy', $_SESSION['sbm_fy']);
		if ($sbm->num_rows() <= 0) {

			if ($this->input->post('submit')) {
				$this->SGODModel->sbm_ta_insert();
				$this->session->set_flashdata('success', 'Saved successfully.');
				redirect(base_url() . 'Page/tapr_form');
			}

			if ($this->session->position == 'smme') {
				$this->load->view('sbm_ta_admin', $result);
			} else {
				$this->load->view('sbm_ta_district', $result);
			}
		} else {
			if ($this->session->position == 'smme') {
				$this->load->view('sbm_ta_admin_update', $result);
			} else {
				$this->load->view('sbm_ta_district_update', $result);
			}
		}
	}



	function tapr_district()
	{
		$this->SGODModel->sbm_cecklist_district_insert();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/tapr_form_district/' . $this->input->post('school_id'));
	}

	function tapr_admin()
	{
		$this->SGODModel->sbm_cecklist_admin_insert();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/tapr_form_district/' . $this->input->post('school_id'));
	}

	function tapr_district_update()
	{
		$this->SGODModel->sbm_checklist_district_update();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/tapr_form_district/' . $this->input->post('school_id'));
	}

	function tapr_admin_update()
	{
		$this->SGODModel->sbm_checklist_admin_update();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/tapr_form_district/' . $this->input->post('school_id'));
	}

	function sbm_d_update()
	{
		$this->SGODModel->sbm_checklist_district_update();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/sbm_checklist_district/' . $this->input->post('school_id'));
	}

	function sbm_list()
	{
		$_SESSION['sbm_fy'] = $this->input->post('fy');
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$result['sbm'] = $this->Common->no_cond('sbm_indicator');
		$result['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

		$sbm = $this->Common->one_cond_count_row('sbm', 'school_id', $this->uri->segment(3));
		$result['sbmc'] = $this->Common->one_cond_row('sbm', 'school_id', $this->uri->segment(3));

		$result['sbmcr'] = $this->Common->one_cond_row('sbm_remark', 'school_id', $this->uri->segment(3));
		$sbmr = $this->Common->one_cond_count_row('sbm_remark', 'school_id', $this->uri->segment(3));


		$this->load->view('sbm_list', $result);
	}

	function sbm_rate_list()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$result['sbm'] = $this->Common->one_cond('sbm', $this->uri->segment(3), $this->uri->segment(4));


		$this->load->view('sbm_rate_list', $result);
	}

	function tapr_form()
	{
		$ap = $this->Common->two_cond_count_row('sbm', 'school_id', $this->session->username, 'fy', $_SESSION['sbm_fy']);
		if ($ap->num_rows() <= 0) {
			redirect(base_url() . 'Page/sbm_checklist');
		}

		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$result['sbm'] = $this->Common->no_cond('sbm_indicator');
		$result['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

		//$school = $this->Common->one_cond_row('schools', 'schoolID', $this->session->username);
		//$result['district'] = $this->Common->one_cond_row('district', 'discription', $school->district);

		$sbm = $this->Common->two_cond_count_row('sbm_ta', 'school_id', $this->session->username, 'fy', $_SESSION['sbm_fy']);
		$result['sbmc'] = $this->Common->two_cond_row('sbm_ta', 'school_id', $this->session->username, 'fy', $_SESSION['sbm_fy']);
		if ($sbm->num_rows() <= 0) {

			if ($this->input->post('submit')) {
				$this->SGODModel->sbm_ta_insert();
				$this->session->set_flashdata('success', 'Saved successfully.');
				redirect(base_url() . 'Page/tapr_form');
			}
			$this->load->view('sbm_ta', $result);
		} else {

			$this->load->view('sbm_ta_update', $result);
		}
	}

	function sbm_ta_final()
	{
		$this->SGODModel->sbm_ta_lock_unloc(1);
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/tapr_form');
	}

	function sbm_ta_unlock()
	{
		$this->SGODModel->sbm_ta_lock_unloc(0);
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/tapr_form_district/' . $this->uri->segment(4));
	}

	function ta_form_edit()
	{
		$this->SGODModel->sbm_ta_update();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Page/tapr_form');
	}

	function tapr_form_new()
	{
		$data['title'] = "TECHNICAL ASSISSTANCE PROVISION REPORT FORM";


		if ($this->input->post('submit')) {
			$this->SGODModel->tapr_insert();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/tapr_form');
		}

		$data['indicator'] = $this->Common->no_cond('sbm_indicator');

		$this->load->view('templates/head');
		$this->load->view('templates/header');
		$this->load->view('sbm_tapr_new', $data);
	}

	function tapr_form_edit()
	{
		$data['title'] = "TECHNICAL ASSISSTANCE PROVISION REPORT FORM";

		$data['data'] = $this->Common->one_cond_row('sgod_sbm_tapr', 'id', $this->uri->segment(3));


		if ($this->input->post('submit')) {
			$this->SGODModel->tapr_update();
			$this->session->set_flashdata('success', 'Saved successfully.');
			redirect(base_url() . 'Page/tapr_form');
		}

		$data['indicator'] = $this->Common->no_cond('sbm_indicator');

		$this->load->view('templates/head');
		$this->load->view('templates/header');
		$this->load->view('sbm_tapr_update', $data);
	}
	function tapr_form_del()
	{
		$this->Common->delete('sgod_sbm_tapr', 'id', 3);
		$this->session->set_flashdata('danger', 'Saved successfully.');
		redirect(base_url() . 'Page/tapr_form');
	}

	function lv()
	{
		$data['title'] = "Action Plan";
		$data['acc_name'] = $this->Common->no_cond('sgod_liq_acc_name');

		$data['data'] = $this->Common->one_cond('sgod_action_plan', 'school_id', $this->session->username);
		$this->load->view('templates/head');
		$this->load->view('templates/header');
		$this->load->view('lv', $data);
	}

	function baseline()
	{
		if (!isset($this->session->bmi_sy)) {
			redirect(base_url() . 'Sbfp/sbfp_bmi');
		}
		$result['title'] = "BASELINE WEIGHING";
		$result['sbf'] = $this->Common->two_join_four_cond('semester_sbfp', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.SY', $this->session->bmi_sy, 'a.Section', $this->session->bmi_Section, 'a.YearLevel', $this->session->bmi_YearLevel, 'a.w_group', 'Baseline', 'LastName', 'ASC');


		$this->load->view('bw', $result);
	}

	function baseline_dn()
	{
		$id =  (int)$this->session->bmi_school_id;

		$result['title'] = "BASELINE WEIGHING";
		$result['sbf'] = $this->Common->two_join_five_cond('semester_sbfp', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $id, 'a.SY', $this->session->bmi_sy, 'a.Section', $this->session->bmi_Section, 'a.YearLevel', $this->session->bmi_YearLevel, 'a.w_group', 'Baseline', 'LastName', 'ASC');


		$this->load->view('bw', $result);
	}

	function baseline2nd_dn()
	{
		$id =  (int)$this->session->bmi_school_id;

		$result['title'] = "BASELINE WEIGHING";
		$result['sbf'] = $this->Common->two_join_five_cond('semester_sbfp', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $id, 'a.SY', $this->session->bmi_sy, 'a.Section', $this->session->bmi_Section, 'a.YearLevel', $this->session->bmi_YearLevel, 'a.w_group', '2nd', 'LastName', 'ASC');


		$this->load->view('bw2nd', $result);
	}

	function baseline3nd_dn()
	{
		$id =  (int)$this->session->bmi_school_id;

		$result['title'] = "BASELINE WEIGHING";
		$result['sbf'] = $this->Common->two_join_five_cond('semester_sbfp', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $id, 'a.SY', $this->session->bmi_sy, 'a.Section', $this->session->bmi_Section, 'a.YearLevel', $this->session->bmi_YearLevel, 'a.w_group', '3rd', 'LastName', 'ASC');


		$this->load->view('bw3rd', $result);
	}

	function baseline2nd()
	{
		if (!isset($this->session->bmi_sy)) {
			redirect(base_url() . 'Sbfp/sbfp_bmi');
		}
		$result['title'] = "BASELINE WEIGHING";
		$result['sbf'] = $this->Common->two_join_five_cond('semester_sbfp', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $this->session->c_id, 'a.SY', $this->session->bmi_sy, 'a.Section', $this->session->bmi_Section, 'a.YearLevel', $this->session->bmi_YearLevel, 'a.w_group', '2nd', 'LastName', 'ASC');


		$this->load->view('bw2nd', $result);
	}

	function baseline3nd()
	{
		if (!isset($this->session->bmi_sy)) {
			redirect(base_url() . 'Sbfp/sbfp_bmi');
		}
		$result['title'] = "BASELINE WEIGHING";
		$result['sbf'] = $this->Common->two_join_five_cond('semester_sbfp', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $this->session->c_id, 'a.SY', $this->session->bmi_sy, 'a.Section', $this->session->bmi_Section, 'a.YearLevel', $this->session->bmi_YearLevel, 'a.w_group', '3rd', 'LastName', 'ASC');


		$this->load->view('bw3rd', $result);
	}

	function sbfp_form1()
	{
		if (!isset($this->session->bmi_sy)) {
			redirect(base_url() . 'Sbfp/sbfp_bmi');
		}
		$result['title'] = "Master List Beneficiaries for School-Based Feeding Program SBFP(SY date)";
		$result['sbf'] = $this->Common->four_cond('semesterstude', 'schoolID', $this->session->c_id, 'SY', $this->session->bmi_sy, 'Section', $this->session->bmi_Section, 'YearLevel', $this->session->bmi_YearLevel);


		$this->load->view('sbfp_form1', $result);
	}

	function sbfp_form2()
	{
		$result['title'] = "Master List Beneficiaries for School-Based Feeding Program SBFP(SY date)";
		//$result['data'] = $this->Common->one_cond_select_gb('');

		//$result['sbf'] = $this->Common->four_cond('semesterstude', 'schoolID', $this->session->c_id, 'SY', $this->session->bmi_sy, 'Section', $this->session->bmi_Section, 'YearLevel', $this->session->bmi_YearLevel);

		$this->load->view('sbfp_form2', $result);
	}

	function sbfp_form3()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		$result['sbf'] = $this->Common->four_cond('semesterstude', 'schoolID', $this->session->c_id, 'SY', $this->session->bmi_sy, 'Section', $this->session->bmi_Section, 'YearLevel', $this->session->bmi_YearLevel);

		$this->load->view('sbfp_form3', $result);
	}

	function sbfp_sf8()
	{


		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
		if ($this->session->d_id == 0) {
			$result['school'] = $this->Common->no_cond_group_ob('schools', 'schoolID', 'schoolName', 'ASC');
		} else {
			$district = $this->Common->one_cond_row('district', 'id', $this->session->d_id);
			$result['school'] = $this->Common->one_cond_group_ob('schools', 'district', $district->discription, 'schoolID', 'schoolName', 'ASC');
		}

		if ($this->session->sp == 0) {
			$result['sy'] = $this->Common->one_cond_group('semesterstude', 'schoolID', $this->session->c_id, 'SY');
			$result['yl'] = $this->Common->one_cond_group('semesterstude', 'schoolID', $this->session->c_id, 'YearLevel');
			$result['section'] = $this->Common->one_cond_group('semesterstude', 'schoolID', $this->session->c_id, 'Section');
			$result['track'] = $this->Common->one_cond_group('semesterstude', 'schoolID', $this->session->c_id, 'Track');
		} else {
			$result['sy'] = $this->Common->no_cond_group('semesterstude', 'SY');
			$result['yl'] = $this->Common->no_cond_group('semesterstude', 'YearLevel');
			$result['section'] = $this->Common->no_cond_group('semesterstude', 'Section');
			$result['track'] = $this->Common->no_cond_group('semesterstude', 'Track');
		}

		$this->load->view('templates/head');
		$this->load->view('templates/header');
		$this->load->view('sbfp_sf8', $result);
		$this->load->view('templates/footer');
	}

	function sbfp_sf8_dn()
	{

		$id =  (int)$this->session->bmi_school_id;

		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";


		$result['sy'] = $this->Common->one_cond_group('semesterstude', 'schoolID', $id, 'SY');
		$result['yl'] = $this->Common->one_cond_group('semesterstude', 'schoolID', $id, 'YearLevel');
		$result['section'] = $this->Common->one_cond_group('semesterstude', 'schoolID', $id, 'Section');
		$result['track'] = $this->Common->one_cond_group('semesterstude', 'schoolID', $id, 'Track');


		$this->load->view('templates/head');
		$this->load->view('templates/header');
		$this->load->view('sbfp_sf8_dn', $result);
		$this->load->view('templates/footer');
	}

	function sbfp_sf8_report()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";

		$sy = $this->input->post('sy');
		$yl = $this->input->post('YearLevel');
		$sec = $this->input->post('Section');
		$track = $this->input->post('track');
		$sid = $this->input->post('schoolID');

		//$result['sbfp'] = $this->Common->five_cond('semesterstude', 'schoolID', $this->session->c_id,'SY',$sy,'YearLevel',$yl,'Section',$sec,'Track',$track);
		if ($this->session->sp == 0) {
			$result['sbfp'] = $this->Common->two_join_five_cond('semesterstude', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $this->session->c_id, 'a.SY', $sy, 'a.YearLevel', $yl, 'a.Section', $sec, 'a.Track', $track, 'b.LastName', 'ASC');
		} else {
			$result['sbfp'] = $this->Common->two_join_five_cond('semesterstude', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $sid, 'a.SY', $sy, 'a.YearLevel', $yl, 'a.Section', $sec, 'a.Track', $track, 'b.LastName', 'ASC');
		}

		$this->load->view('sbfp_sf8_report', $result);
	}

	function sbfp_sf8_report_dn()
	{
		$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";

		$id =  (int)$this->session->bmi_school_id;

		$sy = $this->input->post('sy');
		$yl = $this->input->post('YearLevel');
		$sec = $this->input->post('Section');
		$track = $this->input->post('track');
		$sid = $this->input->post('schoolID');

		//$result['sbfp'] = $this->Common->five_cond('semesterstude', 'schoolID', $this->session->c_id,'SY',$sy,'YearLevel',$yl,'Section',$sec,'Track',$track);
		if ($this->session->sp == 0) {
			$result['sbfp'] = $this->Common->two_join_five_cond('semesterstude', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $sid, 'a.SY', $sy, 'a.YearLevel', $yl, 'a.Section', $sec, 'a.Track', $track, 'b.LastName', 'ASC');
		} else {
			$result['sbfp'] = $this->Common->two_join_five_cond('semesterstude', 'studeprofile', '*', 'a.StudentNumber=b.StudentNumber', 'a.schoolID', $id, 'a.SY', $sy, 'a.YearLevel', $yl, 'a.Section', $sec, 'a.Track', $track, 'b.LastName', 'ASC');
		}

		$this->load->view('sbfp_sf8_report', $result);
	}















	public function save_grades()
{
    $this->load->model('Ren_model');
    $this->load->model('Common');
    $this->load->library('form_validation');

    $this->form_validation->set_error_delimiters(
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>',
        '</div>'
    );
    $this->form_validation->set_rules('sn', 'Student', 'required');

    $page = "mg_save";
    if (!file_exists(APPPATH . 'views/' . $page . '.php')) show_404();

    $data['title'] = "Solo Save Grades";

    // Session vars
    $sy        = $this->session->sy ?: $this->session->userdata('sy') ?: $this->session->userdata('SY');
    $sem       = $this->session->userdata('semester') ?: $this->session->userdata('Semester') ?: '';
    $userLevel = (string)$this->session->userdata('level');
    $userID    = (string)$this->session->userdata('IDNumber'); // username/IDNumber

    // Build student list by role
    if (strcasecmp($userLevel, 'Teacher') === 0 && $userID !== '') {
        $data['studs'] = $this->Ren_model->get_students_with_registration_for_teacher_subjects($sy, $userID);
    } elseif (strcasecmp($userLevel, 'Adviser') === 0 && $userID !== '') {
        // Students under this adviser (semesterstude.Adviser == userID)
        $data['studs'] = $this->Ren_model->get_students_for_adviser($sy, $userID);
    } else {
        // Registrar / others → no restriction
        $data['studs'] = $this->Ren_model->get_students_with_registration($sy);
    }

    // First load—show picker
    if ($this->form_validation->run() === FALSE) {
        $this->load->view($page, $data);
        return;
    }

    // When a student is selected
    $sn      = $this->input->post('sn', TRUE);
    $grading = strtolower($this->input->post('grading', TRUE) ?: 'all');

    $data['stud']    = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $sn);
    $data['grading'] = $grading;
    $data['role']    = strtolower($userLevel); // 'teacher' | 'adviser' | 'registrar'
    $data['userID']  = $userID;

    // Get the rowset with any existing grades attached
    if (strcasecmp($userLevel, 'Teacher') === 0 && $userID !== '') {
        $data['reg_rows'] = $this->Ren_model->rows_with_grades_for_teacher($sy, $sn, $userID);
    } else {
        // Adviser & Registrar see all subjects
        $data['reg_rows'] = $this->Ren_model->rows_with_grades_all($sy, $sn);
    }

    $this->load->view($page, $data);
}


	/**
	 * Insert grades from registration (no updates).
	 * Skips duplicates by (StudentNumber, SubjectCode, SY, Semester).
	 */
	private function norm_grade($v)
	{
		// treat empty / non-numeric as 0; keep numbers as float or int
		return is_numeric($v) ? (float)$v : 0;
	}





	private function norm_grade_val($v)
	{
		return is_numeric($v) ? (float)$v : 0;
	}

	public function save_batch_studgrade()
{
    $this->load->model('Ren_model');

    $sn       = $this->input->post('id', TRUE);
    $grading  = strtolower($this->input->post('grading', TRUE) ?: 'all');

    $regIDs      = $this->input->post('regID');
    $SubjectCode = $this->input->post('SubjectCode');
    $Description = $this->input->post('Description');
    $Instructor  = $this->input->post('Instructor');
    $SY          = $this->input->post('SY');
    $YearLevel   = $this->input->post('YearLevel');
    $Section     = $this->input->post('Section');

    // NEW: adviser & strand (aligned by $i indexes)
    $Adviser     = $this->input->post('Adviser');
    $Strand      = $this->input->post('Strand');

    $PGrade      = $this->input->post('PGrade');
    $MGrade      = $this->input->post('MGrade');
    $PFinalGrade = $this->input->post('PFinalGrade');
    $FGrade      = $this->input->post('FGrade');

    if (empty($regIDs) || !is_array($regIDs)) {
        $this->session->set_flashdata('danger', 'Nothing to save.');
        redirect('Page/save_grades'); return;
    }

    // Role → mode
    $role = strtolower((string)$this->session->userdata('level')); // teacher | adviser | registrar
    $mode = ($role === 'registrar') ? 'force' : 'fill';

    $rows = [];
    foreach ($regIDs as $i => $rid) {
        // Fetch existing row to compute “intent” correctly
        $exist = $this->Ren_model->get_existing_grade_row(
            $sn,
            $SubjectCode[$i] ?? '',
            $SY[$i] ?? ($this->session->sy ?? ''),
            $Section[$i] ?? ''
        );

        // Current values (if needed)
        $curP  = is_object($exist) ? (float)$exist->PGrade      : 0.0;
        $curM  = is_object($exist) ? (float)$exist->MGrade      : 0.0;
        $curPF = is_object($exist) ? (float)$exist->PFinalGrade : 0.0;
        $curF  = is_object($exist) ? (float)$exist->FGrade      : 0.0;

        // Raw user inputs; treat "" as NULL (no intent)
        $rawP  = (isset($PGrade[$rid])      && $PGrade[$rid]      !== '') ? (float)$PGrade[$rid]      : null;
        $rawM  = (isset($MGrade[$rid])      && $MGrade[$rid]      !== '') ? (float)$MGrade[$rid]      : null;
        $rawPF = (isset($PFinalGrade[$rid]) && $PFinalGrade[$rid] !== '') ? (float)$PFinalGrade[$rid] : null;
        $rawF  = (isset($FGrade[$rid])      && $FGrade[$rid]      !== '') ? (float)$FGrade[$rid]      : null;

        // Limit to selected grading window
        if ($grading !== 'all') {
            if ($grading !== 'first')  $rawP  = null;
            if ($grading !== 'second') $rawM  = null;
            if ($grading !== 'third')  $rawPF = null;
            if ($grading !== 'fourth') $rawF  = null;
        }

        // Apply role rules at the controller (absolute intent):
        // registrar overwrites; teacher/adviser only fill zeros
        $P  = ($mode === 'force') ? $rawP  : (($rawP  !== null && $curP  == 0.0) ? $rawP  : null);
        $M  = ($mode === 'force') ? $rawM  : (($rawM  !== null && $curM  == 0.0) ? $rawM  : null);
        $PF = ($mode === 'force') ? $rawPF : (($rawPF !== null && $curPF == 0.0) ? $rawPF : null);
        $F  = ($mode === 'force') ? $rawF  : (($rawF  !== null && $curF  == 0.0) ? $rawF  : null);

        // Build the payload: pass NULL for untouched cells
        $rows[] = [
            'StudentNumber' => $sn,
            'SubjectCode'   => $SubjectCode[$i] ?? '',
            'Description'   => $Description[$i] ?? '',
            'Instructor'    => $Instructor[$i] ?? '',
            'SY'            => $SY[$i] ?? ($this->session->sy ?? ''),
            'YearLevel'     => $YearLevel[$i] ?? '',
            'Section'       => $Section[$i] ?? '',
            'adviser'       => $Adviser[$i] ?? '',
            'strand'        => $Strand[$i] ?? '',

            'PGrade'        => $P,
            'MGrade'        => $M,
            'PFinalGrade'   => $PF,
            'FGrade'        => $F,
        ];
    }

    // Absolute upsert (model method; add to Ren_model if not yet present)
    $result = $this->Ren_model->upsert_grades_absolute($rows, $mode);

    // Audit trail (optional)
    if (method_exists($this->Ren_model, 'atrail_insert')) {
        $this->Ren_model->atrail_insert(
            "Solo save ({$grading}) by {$role}: {$result['inserted']} inserted, {$result['updated']} updated, {$result['unchanged']} unchanged",
            'grades',
            $sn
        );
    }

    // Clean, non-confusing message
    $msg = "Saved. Inserted: {$result['inserted']}, Updated: {$result['updated']}";
    if (!empty($result['unchanged'])) $msg .= ", Unchanged: {$result['unchanged']}";
    $this->session->set_flashdata('success', $msg);
    redirect('Page/save_grades');
}



// --- Delete ONE "Additional Fee" row (studeadditional by adID) ---
public function deleteAdditional()
{
    if (!$this->input->post()) { show_404(); }

    $studentNumber = $this->input->post('studentNumber', TRUE);
    $sy            = $this->input->post('sy', TRUE);
    $recId         = $this->input->post('rec_id', TRUE); // must be adID

    if (!$studentNumber || !$sy || !$recId) { show_404(); }

    // Fetch exact row by adID
    $row = $this->db->where('adID', $recId)->limit(1)->get('studeadditional')->row();

    if (!$row) {
        $this->session->set_flashdata('msg', 'Record not found or already deleted (Additional).');
        $this->session->set_flashdata('msg_type', 'warning');
        return redirect('Page/state_Account_Accounting?id=' . urlencode($studentNumber));
    }

    // Safety: ensure record belongs to same StudentNumber + SY
    if ((string)$row->StudentNumber !== (string)$studentNumber || (string)$row->SY !== (string)$sy) {
        $this->session->set_flashdata('msg', 'Mismatch: record does not belong to this student/SY.');
        $this->session->set_flashdata('msg_type', 'danger');
        return redirect('Page/state_Account_Accounting?id=' . urlencode($studentNumber));
    }

    // Delete
    $this->db->where('adID', $recId)->limit(1)->delete('studeadditional');

    $this->session->set_flashdata('msg', 'Additional fee deleted.');
    $this->session->set_flashdata('msg_type', 'success');
    return redirect('Page/state_Account_Accounting?id=' . urlencode($studentNumber));
}
// --- Delete ONE "Discount" row (studediscount by disID) ---
public function deleteDiscountSOA()
{
    if (!$this->input->post()) { show_404(); }

    $studentNumber = $this->input->post('studentNumber', TRUE);
    $sy            = $this->input->post('sy', TRUE);
    $recId         = $this->input->post('rec_id', TRUE); // must be disID

    if (!$studentNumber || !$sy || !$recId) { show_404(); }

    // Fetch exact row by disID
    $row = $this->db->where('disID', $recId)->limit(1)->get('studediscount')->row();

    if (!$row) {
        $this->session->set_flashdata('msg', 'Record not found or already deleted (Discount).');
        $this->session->set_flashdata('msg_type', 'warning');
        return redirect('Page/state_Account_Accounting?id=' . urlencode($studentNumber));
    }

    // Safety: ensure record belongs to same StudentNumber + SY
    if ((string)$row->StudentNumber !== (string)$studentNumber || (string)$row->SY !== (string)$sy) {
        $this->session->set_flashdata('msg', 'Mismatch: record does not belong to this student/SY.');
        $this->session->set_flashdata('msg_type', 'danger');
        return redirect('Page/state_Account_Accounting?id=' . urlencode($studentNumber));
    }

    // Delete
    $this->db->where('disID', $recId)->limit(1)->delete('studediscount');

    $this->session->set_flashdata('msg', 'Discount deleted.');
    $this->session->set_flashdata('msg_type', 'success');
    return redirect('Page/state_Account_Accounting?id=' . urlencode($studentNumber));
}



}
