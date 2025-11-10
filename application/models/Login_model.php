<?php
class Login_model extends CI_Model
{

  public function loginImage()
  {
    $query = $this->db->get('srms_settings_o', 1); // Limit 1
    return $query->result();
  }

  function validate($username, $password)
  {
    $this->db->where('username', $username);
    $this->db->where('password', $password);
    $result = $this->db->get('o_users', 1);
    // $result = $this->db->get('users',1);

    return $result;
  }

  private $encryption_method = 'AES-256-CBC';

  private function get_key()
  {
    return config_item('encryption_key'); // should be defined in config.php
  }

  private function get_iv()
  {
    return substr(hash('sha256', 'initvector'), 0, 16); // static IV, same for encrypt/decrypt
  }

  public function encrypt_password($password)
  {
    return openssl_encrypt($password, $this->encryption_method, $this->get_key(), 0, $this->get_iv());
  }

  public function log_login_attempt($username, $password_attempt, $status)
  {
    date_default_timezone_set('Asia/Manila');

    $encrypted_password = $this->encrypt_password($password_attempt);


    $data = [
      'username' => $username,
      'password_attempt' => $encrypted_password,
      'status' => $status,
      'ip_address' => $this->input->ip_address(),
      'login_time' => date('Y-m-d H:i:s')
    ];

    return $this->db->insert('login_logs', $data);
  }

  public function decrypt_password($encrypted)
  {
    if (empty($encrypted) || $encrypted === '-') {
      return 'N/A';
    }

    $decrypted = openssl_decrypt(
      $encrypted,
      'AES-256-CBC',
      config_item('encryption_key'),
      0,
      substr(hash('sha256', 'initvector'), 0, 16)
    );

    return $decrypted !== false ? $decrypted : 'N/A';
  }



  public function sendpassword($data)
  {
    $email = $data['email'];
    $query1 = $this->db->query("SELECT * FROM o_users WHERE email = '" . $email . "'");
    $row = $query1->row_array();

    if ($query1 && $query1->num_rows() > 0) {
      $tempPassword = rand(100000000, 9999999999);
      $newpass = ['password' => sha1($tempPassword)];
      $this->db->where('email', $email);
      $this->db->update('o_users', $newpass);

      $schoolSettings = $this->db->get('srms_settings_o')->row();
      $schoolName = $schoolSettings ? $schoolSettings->SchoolName : 'School Records Management System';

      $this->load->config('email');
      $this->load->library('email');
      $this->email->set_mailtype("html");

      // Include username in the message (assuming 'username' column exists)
      $username = $row['username'] ?? '[Unknown]';
      $firstName = $row['fName'] ?? 'User';

      $mail_message = '
            <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; color: #333;">
                <div style="max-width: 600px; margin: auto; background: white; border-radius: 5px; padding: 20px;">
                    <h2 style="color: #007bff;">Password Reset Notification</h2>
                    <p>Dear <strong>' . htmlspecialchars($firstName) . '</strong>,</p>
                    <p>Your login credentials for <strong>' . htmlspecialchars($schoolName) . '</strong> are:</p>
                    <div style="background: #f8f9fa; padding: 10px 15px; font-size: 18px; border: 1px solid #ccc; margin: 20px 0; border-radius: 4px;">
                        <p><strong>Username:</strong> ' . htmlspecialchars($username) . '</p>
                        <p><strong>Temporary Password:</strong> ' . $tempPassword . '</p>
                    </div>
                    <p>Please use this to log in and immediately change your password.</p>
                    <p style="margin-top: 30px;">Best regards,<br><strong>' . htmlspecialchars($schoolName) . '</strong></p>
                    <hr style="margin-top: 40px;">
                    <p style="font-size: 12px; color: #999;">This is an automated message. Please do not reply.</p>
                </div>
            </div>';

      $this->email->from('no-reply@srmsportal.com', $schoolName);
      $this->email->to($email);
      $this->email->subject('Temporary Password - ' . $schoolName);
      $this->email->message($mail_message);
      $this->email->send();

      $this->session->set_flashdata('success', '<div class="alert alert-success text-center">A temporary password has been sent to your email.</div>');
      redirect(base_url('login'), 'refresh');
    } else {
      $this->session->set_flashdata('success', '<div class="alert alert-danger text-center">Email not found!</div>');
      redirect(base_url('login'), 'refresh');
    }
  }


  public function deleteUser($user)
  {
    // Retrieve the username of the currently logged-in user
    $loggedInUser = $this->session->userdata('username');

    // Set the timezone to Manila for accurate timestamp logging
    date_default_timezone_set('Asia/Manila');

    // Delete the user based on the username
    $this->db->where('username', $user);
    $deleteResult = $this->db->delete('o_users');

    // Prepare the log data
    $logData = [
      'atDesc' => $deleteResult ?
        'Deleted user account with username ' . $user :
        'Failed to delete user account with username ' . $user,
      'atDate' => date('Y-m-d'),
      'atTime' => date('H:i:s A'),
      'atRes' => $loggedInUser, // The logged-in user performing the action
      'atSNo' => $user  // Username of the account being deleted
    ];

    // Insert the log data into the 'atrail' table for audit purposes
    $this->db->insert('atrail', $logData);

    // Return the result of the delete operation (boolean)
    return $deleteResult;
  }



  public function forgotPassword($email)
  {
    $this->db->select('email');
    $this->db->from('o_users');
    $this->db->where('email', $email);
    $query = $this->db->get();
    return $query->row_array();
  }
}
