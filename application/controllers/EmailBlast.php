<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmailBlast extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('EmailBlast_model');
    $this->load->library('email');
    $this->load->helper('url'); // for base_url
  }

  public function view()
  {
    $studentNumber = $this->input->get('id');

    $data = [];

    if (!empty($studentNumber)) {
      $this->db->where('StudentNumber', $studentNumber);
      $query = $this->db->get('studeprofile');

      if ($query->num_rows() > 0) {
        $data['student'] = $query->row(); // student profile object
      } else {
        $data['student'] = null; // student not found
      }
    }

    $this->load->view('email_form', $data);
  }

  public function sendEmail()
  {
    $subject        = $this->input->post('subject');
    $messageBody    = $this->input->post('message');
    $studentNumber  = $this->input->post('student_id');
    $email          = $this->input->post('EmailAddress');

    // Fetch school settings
    $settings = $this->EmailBlast_model->getSchoolSettings();
    $schoolName = $settings->SchoolName;
    $letterheadWeb = $settings->letterhead_web;

    // Get student details
    $student = $this->EmailBlast_model->getStudentByNumber($studentNumber);
    if (!$student || (empty($student->EmailAddress) && empty($student->p_email))) {
      $this->session->set_flashdata('error', 'No email address found for the selected student or parent.');
      redirect('EmailBlast/view');
      return;
    }

    $studentEmail = $student->EmailAddress;
    $parentEmail  = $student->p_email;
    $name         = $student->FirstName . ' ' . $student->LastName;

    // Get sender info
    $senderUsername = $this->session->userdata('username');
    $senderName     = $this->EmailBlast_model->getSenderName($senderUsername);

    // Prepare HTML email content
    $html_message = "
    <html><body>
        <div style='max-width:600px;margin:auto;background:#f9f9f9;padding:20px;border-radius:8px;'>
            " . (!empty($letterheadWeb) ? "<img src='" . base_url('upload/banners/' . $letterheadWeb) . "' style='max-width:100%;margin-bottom:20px;'>" : "") . "
            <div>$messageBody</div>
            <p style='font-size:12px;color:#777;'>$schoolName</p>
        </div>
    </body></html>";

    date_default_timezone_set('Asia/Manila');

    $sentTo = [];

    // ✅ Send to student and log it
    if (!empty($studentEmail)) {
      $this->email->clear();
      $this->email->from('no-reply@srmsportal.com', $schoolName);
      $this->email->to($studentEmail);
      $this->email->subject($subject);
      $this->email->set_mailtype("html");
      $this->email->message($html_message);

      if ($this->email->send()) {
        $this->EmailBlast_model->logEmail([
          'StudentNumber'  => $studentNumber,
          'email_address'  => $studentEmail,
          'subject'        => $subject,
          'message'        => $messageBody,
          'sent_by'        => $senderName,
          'sent_at'        => date('Y-m-d H:i:s'),
          'seen'           => 'unseen'
        ]);
        $sentTo[] = $studentEmail;
      }
    }

    // ✅ Send to parent but do NOT log
    if (!empty($parentEmail)) {
      $this->email->clear();
      $this->email->from('no-reply@srmsportal.com', $schoolName);
      $this->email->to($parentEmail);
      $this->email->subject($subject);
      $this->email->set_mailtype("html");
      $this->email->message($html_message);
      if ($this->email->send()) {
        $sentTo[] = $parentEmail;
      }
    }

    // Feedback
    if (!empty($sentTo)) {
      $this->session->set_flashdata('success', "Email successfully sent to: " . implode(', ', $sentTo));
    } else {
      $this->session->set_flashdata('danger', "Failed to send email to both student and parent.");
    }

    redirect('EmailBlast/view?id=' . $studentNumber);
  }


  public function inbox()
  {
    if ($this->session->userdata('level') === 'Student') {
      $studentNumber = $this->session->userdata('username');
      $data['messages'] = $this->EmailBlast_model->getAllMessages($studentNumber);
      $this->load->view('email_inbox', $data);
    } else {
      echo "Access Denied";
    }
  }

  public function viewMessage($id)
  {
    if ($this->session->userdata('level') === 'Student') {
      $studentNumber = $this->session->userdata('username');
      $message = $this->EmailBlast_model->getMessageById($id, $studentNumber);
      if ($message) {
        $this->EmailBlast_model->markMessageAsSeen($id); // Mark as read
        $data['message'] = $message;
        $this->load->view('email_view_message', $data);
      } else {
        echo "Message not found.";
      }
    } else {
      echo "Access Denied";
    }
  }
}
