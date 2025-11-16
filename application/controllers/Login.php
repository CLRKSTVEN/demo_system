<?php
class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->model('Login_model');
        $this->load->model('SettingsModel');
        $this->load->library("session");
        $this->load->helper('url');
    }

    function index()
    {
        $settings = $this->Login_model->loginImage(); // returns an array of result objects
        $result['data'] = $settings;

        $systemType = null;

        if (!empty($settings)) {
            $result['active_sy'] = $settings[0]->active_sy;

            // Safely read systemType if the column exists
            $systemType = isset($settings[0]->systemType) ? $settings[0]->systemType : null;
        } else {
            $result['active_sy'] = null; // or set a default fallback
        }

        $result['systemType'] = $systemType;

        // If this is a DEMO system, load demo accounts for the dropdown
        if ($systemType === 'demo') {
            $result['demo_accounts'] = $this->Login_model->get_demo_accounts();
        } else {
            $result['demo_accounts'] = []; // always define to avoid undefined variable in view
        }

        $this->load->view('home_page', $result);
    }



    function registration()
    {
        if ($this->input->post('register')) {
            $lrn = $this->input->post('lrn');
            $fname = strtoupper($this->input->post('fname'));
            $mname = strtoupper($this->input->post('mname'));
            $lname = strtoupper($this->input->post('lname'));
            $sex = $this->input->post('sex');
            $bdate = $this->input->post('bdate');
            $contactno = $this->input->post('contactno');
            $Father = $this->input->post('Father');
            $FOccupation = $this->input->post('FOccupation');
            $Mother = $this->input->post('Mother');
            $MOccupation = $this->input->post('MOccupation');
            $Brgy = $this->input->post('Brgy');
            $City = $this->input->post('City');
            $Province = $this->input->post('Province');
            $nameExt = $this->input->post('nameExt');
            $PSANo = $this->input->post('PSANo');
            $Age = $this->input->post('Age');
            $Belong_IP = $this->input->post('Belong_IP');
            $IPSpecify = $this->input->post('IPSpecify');
            $MTongue = $this->input->post('MTongue');
            $Religion = $this->input->post('Religion');
            $SpecEducNeed = $this->input->post('SpecEducNeed');
            $SENSpecify = $this->input->post('SENSpecify');
            $DeviceAvailable = $this->input->post('DeviceAvailable');
            $DASpecify = $this->input->post('DASpecify');
            $FHEA = $this->input->post('FHEA');
            $FEmpStat = $this->input->post('FEmpStat');
            $FMobileNo = $this->input->post('FMobileNo');
            $MHEA = $this->input->post('MHEA');
            $MEmpStat = $this->input->post('MEmpStat');
            $MMobileNo = $this->input->post('MMobileNo');
            $houseNo = $this->input->post('houseNo');
            $sitio = $this->input->post('sitio');
            $region = $this->input->post('region');
            $StudentType = $this->input->post('StudentType');
            $YearLevelToEnroll = $this->input->post('YearLevelToEnroll');

            $email = $this->input->post('email');
            $date = date('Y-m-d');
            $pass = $this->input->post('pass');
            $h_upass = sha1($pass);

            $que = $this->db->query("select * from users where username='" . $lrn . "'");
            $row = $que->num_rows();
            if ($row) {

                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>This account already exists.</b></div>');
            } else {
                $que = $this->db->query("insert into users values('$lrn','$h_upass','Student','$fname','$mname','$lname','$email','avatar.png','active','$date','$lrn')");
                $que1 = $this->db->query("insert into studeprofile values('$lrn','$fname','$mname','$lname','$sex','Single','','Filipino','','','','$contactno','','','','','','$lrn','$bdate','$date','$date','','$contactno','','','','','','','','$email','$Father','$FOccupation','$Mother','$MOccupation','','','','','','','','$Province','$City','$Brgy','','1','','','','','','','','','','','','','','','','','$Belong_IP','$IPSpecify','$MTongue','$SpecEducNeed','$SENSpecify','$DeviceAvailable','$DASpecify','$FHEA','$FEmpStat','','$FMobileNo','$MHEA','$MEmpStat','','$MMobileNo','','','','','$PSANo','$lrn')");
                $que = $this->db->query("insert into studentsignup values('','$lrn','$fname','$mname','$lname','$StudentType','$YearLevelToEnroll','$date')");
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Your account has been created successfully.</b></div>');
                redirect('Login');
            }
        }
        $this->load->view('registration_form', @$data);
    }



    public function auth()
    {
        $username      = $this->input->post('username', TRUE);
        $raw_password  = $this->input->post('password', TRUE); // keep raw password for logging
        $password      = sha1($raw_password); // still used for authentication
        $sy            = $this->input->post('sy', TRUE);
        $semester      = $this->input->post('semester', TRUE);

        $validate = $this->Login_model->validate($username, $password);

        if ($validate->num_rows() > 0) {
            $data = $validate->row_array();
            $acctStat = $data['acctStat'];

            if ($acctStat === 'active') {
                // ✅ Log success with encrypted raw password
                $this->Login_model->log_login_attempt($username, $raw_password, 'success');

                // Set session data
                $this->session->set_userdata([
                    'username'   => $data['username'],
                    'fname'      => $data['fName'],
                    'mname'      => $data['mName'],
                    'lname'      => $data['lName'],
                    'avatar'     => $data['avatar'],
                    'email'      => $data['email'],
                    'level'      => $data['position'],
                    'IDNumber'   => $data['IDNumber'],
                    'sy'         => $sy,
                    'semester'   => $semester,
                    'logged_in'  => TRUE
                ]);

                // Redirect based on user level
                switch ($data['position']) {
                    case 'Admin':
                        redirect('page/admin');
                        break;
                    case 'Registrar':
                        redirect('page/registrar');
                        break;
                    case 'Super Admin':
                        redirect('page/superAdmin');
                        break;
                    case 'Academic Officer':
                        redirect('page/a_officer');
                        break;
                    case 'Student':
                        redirect('page/student');
                        break;
                    case 'Accounting':
                        redirect('page/accounting');
                        break;
                    case 'Teacher':
                        redirect('page/Teacher');
                        break;
                    case 'Teacher/Adviser':
                        redirect('page/adviser');
                        break;
                    case 'HR Admin':
                        redirect('page/hr');
                        break;
                    case 'Guidance':
                        redirect('page/guidance');
                        break;
                    case 'School Nurse':
                        redirect('page/medical');
                        break;
                    case 'Property Custodian':
                        redirect('page/p_custodian');
                        break;
                    case 'Librarian':
                        redirect('page/library');
                        break;
                    case 'BAC':
                        redirect('page/bac');
                        break;
                    case 'Encoder':
                        redirect('page/encoder');
                        break;
                    case 'Cashier':
                        redirect('page/cashier');
                        break;
                    case 'Principal':
                        redirect('page/s_principal');
                        break;
                    default:
                        $this->session->set_flashdata('danger', 'Unauthorized access.');
                        redirect('login');
                }
            } else {
                // ❌ Log failed due to inactive account
                $this->Login_model->log_login_attempt($username, $raw_password, 'failed');
                $this->session->set_flashdata('danger', 'Your account is not active. Please contact support.');
                redirect('login');
            }
        } else {
            // ❌ Log failed due to invalid credentials
            $this->Login_model->log_login_attempt($username, $raw_password, 'failed');
            $this->session->set_flashdata('danger', 'The username or password is incorrect!');
            redirect('login');
        }
    }


    public function deleteUser($user)
    {
        // Attempt to delete the user
        $deleteSuccess = $this->Login_model->deleteUser($user);

        // Check the outcome of the delete operation and set the appropriate flash message
        if ($deleteSuccess) {
            $this->session->set_flashdata('success', '<div class="alert alert-success">User account deleted successfully.</div>');
        } else {
            $this->session->set_flashdata('error', '<div class="alert alert-danger">Error deleting enrollment. Please try again.</div>');
        }

        // Redirect back to the user accounts page
        redirect(base_url('Page/userAccounts'));
    }


    public function logout()
    {
        $this->load->model('Login_model');

        // Get username before destroying session
        $username = $this->session->userdata('username');

        // Log logout activity (if user was logged in)
        if ($username) {
            date_default_timezone_set('Asia/Manila'); // Ensure correct timezone

            $this->Login_model->log_login_attempt($username, '-', 'logout');
        }

        // Destroy session
        $this->session->sess_destroy();
        redirect('login');
    }

    public function forgot_pass()
    {
        $email = $this->input->post('email');
        $findemail = $this->Login_model->forgotPassword($email);

        if ($findemail) {
            $this->Login_model->sendpassword($findemail);
            $this->session->set_flashdata('success', 'A password reset email has been sent to your email address.');
        } else {
            $this->session->set_flashdata('success', 'Email not found!');
        }

        redirect(base_url() . 'login', 'refresh');
    }
}
