<?php
class Student extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->helper('url');
    $this->load->model('StudentModel');
    $this->load->library('session');
    $this->load->library('user_agent');

    if ($this->session->userdata('logged_in') !== TRUE) {
      redirect('login');
    }
  }

  public function upload_requirement()
  {
    $studentNumber = $this->input->post('StudentNumber');
    $requirementId = $this->input->post('requirement_id');

    if (!empty($_FILES['requirement_file']['name'])) {
      $config['upload_path'] = './upload/requirements/';
      $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
      $config['max_size'] = 2048;
      $config['file_name'] = time() . '_' . $_FILES['requirement_file']['name'];

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('requirement_file')) {
        $uploadData = $this->upload->data();
        $filePath = 'upload/requirements/' . $uploadData['file_name'];

        // Build data array
        $data = [
          'StudentNumber'  => $studentNumber,
          'requirement_id' => $requirementId,
          'date_submitted' => date('Y-m-d'),
          'file_path'      => $filePath,
          'is_verified'    => 1,
          'verified_by'    => $this->session->userdata('username'),
          'verified_at'    => date('Y-m-d H:i:s'),
          // 'comment'        => 'Uploaded via portal and auto-verified'
          'comment' => 'Uploaded by ' . $this->session->userdata('username')

        ];

        // Check if already exists
        $existing = $this->db->get_where('student_requirements', [
          'StudentNumber' => $studentNumber,
          'requirement_id' => $requirementId
        ])->row();

        if ($existing) {
          $this->db->where('id', $existing->id);
          $this->db->update('student_requirements', $data);
        } else {
          $this->db->insert('student_requirements', $data);
        }

        $this->session->set_flashdata('success', 'Requirement uploaded successfully.');
      } else {
        $this->session->set_flashdata('danger', $this->upload->display_errors());
      }
    } else {
      $this->session->set_flashdata('danger', 'No file selected.');
    }

    redirect($this->agent->referrer());
    // 🔄 Use the working method for viewing student profile
    // redirect('Student/studentsprofile?id=' . $studentNumber);
  }


  public function viewSpecialNeedsList($sy = null)
  {
    $sy = $sy ?? $this->session->userdata('sy');

    $this->db->select('sp.LastName, sp.FirstName, sp.MiddleName, sp.StudentNumber, ss.YearLevel, ss.Section, sp.specialneeds');
    $this->db->from('studeprofile sp');
    $this->db->join('semesterstude ss', 'ss.StudentNumber = sp.StudentNumber');
    $this->db->where('ss.SY', $sy);
    $this->db->where('sp.with_specialneeds', 'Yes');
    $query = $this->db->get();

    $result['students'] = $query->result();
    $result['sy'] = $sy;

    $this->load->view('stude_with_special_needs', $result);
  }


  function index()
  {

    if ($this->session->userdata('level') === 'Student') {
      $this->load->view('account_tracking');
    } else {
      echo "Access Denied";
    }
  }

  function downloads()
  {
    $this->load->view('download_resources');
  }

  public function student_requirements()
  {
    // Get StudentNumber from session (assuming it's stored as 'username' or 'student_number')
    $studentNumber = $this->session->userdata('username'); // or 'student_number', adjust as needed

    if (!$studentNumber) {
      show_error('You must be logged in as a student to view this page.', 403);
    }

    $this->load->model('StudentModel');
    $data['student'] = $this->StudentModel->get_student_by_number($studentNumber);
    $data['requirements'] = $this->StudentModel->getStudentRequirements($studentNumber);

    $this->load->view('requirements_view', $data);
  }

  public function manual_verify()
  {
    // Load the necessary model
    $this->load->model('StudentModel');

    // Get POST data
    $requirement_id = $this->input->post('requirement_id', TRUE); // Get the requirement id
    $comment = $this->input->post('comment', TRUE); // Get the comment
    $student_number = $this->input->post('StudentNumber', TRUE); // Get the selected student's number

    // Check if the required data is provided
    if ($requirement_id && $comment !== null && $student_number) {
      // Prepare insert data
      $data = [
        'StudentNumber'  => $student_number,                    // Use the selected student's StudentNumber
        'requirement_id' => $requirement_id,                     // The id of the requirement being verified
        'date_submitted' => date('Y-m-d H:i:s'),                 // Current timestamp for when it's submitted
        'is_verified'    => 1,                                   // Mark as verified
        'comment'        => $comment,                            // Save the comment
        'verified_by'    => $this->session->userdata('username'), // Store the username of who verified it
        'verified_at'    => date('Y-m-d H:i:s')                  // Current timestamp for when it's verified
      ];

      // Insert the data into the student_requirements table
      $inserted = $this->db->insert('student_requirements', $data);

      // Check if the insert was successful and set flash message accordingly
      if ($inserted) {
        $this->session->set_flashdata('success', 'Requirement successfully verified.');
      } else {
        $this->session->set_flashdata('error', 'Failed to insert verification data.');
      }
    } else {
      // Flash message if the required data is missing
      $this->session->set_flashdata('error', 'Missing required data.');
    }

    // Redirect back to the previous page (student profile or the previous page)
    redirect($_SERVER['HTTP_REFERER']);
  }



  public function submit_requirement()
  {
    $this->load->model('StudentModel');

    $studentNumber = $this->input->post('student_number');
    $requirementId = $this->input->post('requirement_id');
    $file = $_FILES['document'];

    $config['upload_path'] = './upload/requirements/';
    $config['allowed_types'] = 'pdf|jpg|png';
    $config['max_size'] = 2048;
    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('document')) {
      $error = $this->upload->display_errors();
      echo "Upload error: " . $error;
    } else {
      $uploadData = $this->upload->data();

      $data = [
        'StudentNumber' => $studentNumber,
        'requirement_id' => $requirementId,
        'date_submitted' => date('Y-m-d'),
        'file_path' => 'upload/requirements/' . $uploadData['file_name'],
        'is_verified' => 0
      ];

      $this->StudentModel->submitRequirement($data);
      redirect('Student/student_requirements/' . $studentNumber);
    }
  }

  public function update_student_ages()
  {

    // Get all students with BirthDate
    $students = $this->db->get('studeprofile')->result();
    $updated_count = 0;

    foreach ($students as $student) {
      if (!empty($student->BirthDate)) {
        $birthDate = new DateTime($student->BirthDate);
        $today = new DateTime('today');
        $age = $birthDate->diff($today)->y;

        // Update the Age field
        $this->db->where('StudentNumber', $student->StudentNumber);
        $this->db->update('studeprofile', ['Age' => $age]);

        $updated_count++;
      }
    }

    // Set flash message
    $this->session->set_flashdata('success', "$updated_count student age(s) updated successfully.");

    $this->load->view('grades_landing_page');
  }



  public function req_list()
  {
    $data['req'] = $this->StudentModel->req_list();
    $this->load->view('req_list', $data);
  }

  public function pending_uploads()
  {
    $data['pending'] = $this->StudentModel->getPendingRequirements();
    $this->load->view('req_pending_uploads_view', $data);
  }
  public function approved_uploads()
  {
    $this->load->model('StudentModel');
    $data['pending'] = $this->StudentModel->approved_uploads();
    $this->load->view('req_pending_uploads_view_approved', $data);
  }

  public function approve_upload($id)
  {

    $verifier = $this->session->userdata('username') ?? 'Registrar';

    $this->StudentModel->approveRequirement($id, $verifier);

    $this->session->set_flashdata('success', 'Document approved successfully.');
    redirect('student/pending_uploads');
  }

  public function view_list_not_enrolled()
  {
    $enrolledSY = $this->input->post('enrolled_during');
    $notEnrolledSY = $this->input->post('not_during');

    // Use the already-loaded model
    $data['students'] = $this->StudentModel->getPreviouslyButNotCurrentlyEnrolled($enrolledSY, $notEnrolledSY);

    // Load the view
    $this->load->view('view_list_not_enrolled', $data);
  }

  public function compute_general_averages()
  {
    $this->load->database();
    $sy = $this->session->userdata('sy');

    if (!$sy) {
      $this->session->set_flashdata('error', 'School Year not set in session.');
      redirect('dashboard'); // Change to your actual route
      return;
    }

    $students = $this->db
      ->select('StudentNumber, YearLevel')
      ->from('semesterstude')
      ->where('SY', $sy)
      ->where('Status', 'Enrolled')
      ->get()
      ->result();

    $updatedCount = 0;

    foreach ($students as $student) {
      $studentNumber = $student->StudentNumber;
      $yearLevel = $student->YearLevel;

      if (in_array($yearLevel, ['Grade 11', 'Grade 12'])) {
        $query = $this->db
          ->select('AVG((PGrade + MGrade) / 2) AS gen_avg')
          ->from('grades')
          ->where('StudentNumber', $studentNumber)
          ->get();
      } else {
        $query = $this->db
          ->select('AVG((PGrade + MGrade + PFinalGrade + FGrade) / 4) AS gen_avg')
          ->from('grades')
          ->where('StudentNumber', $studentNumber)
          ->get();
      }

      $result = $query->row();

      if ($result && $result->gen_avg !== null) {
        $generalAverage = round($result->gen_avg, 2);

        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $sy);
        $this->db->update('semesterstude', ['gen_average' => $generalAverage]);

        $updatedCount++;
      }
    }

    // Set flash message and redirect
    $this->session->set_flashdata('success', $updatedCount . ' general averages updated for SY: ' . $sy);
    redirect('Page/grades_updated');
  }
}
