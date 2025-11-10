<?php
class Accounting extends CI_Controller
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
        $this->load->model('AccountingModel');

        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
    }

    function getTotalPayments()
    {
        $sy = $this->session->userdata('sy');

        // Select TotalPayments for each student
        $this->db->select('StudentNumber, SUM(Amount) AS TotalPayments');
        $this->db->from('paymentsaccounts');
        $this->db->where('SY', $sy);
        $this->db->where('ORStatus', 'Valid');
        $this->db->group_by('StudentNumber');
        $paymentQuery = $this->db->get();

        if ($paymentQuery->num_rows() > 0) {
            foreach ($paymentQuery->result() as $paymentRow) {
                // Get account details for calculations
                $this->db->select('totalFees, addFees, Discount');
                $this->db->from('studeaccount');
                $this->db->where('StudentNumber', $paymentRow->StudentNumber);
                $this->db->where('SY', $sy);
                $accountQuery = $this->db->get();

                if ($accountQuery->num_rows() > 0) {
                    $accountRow = $accountQuery->row();

                    // Calculate CurrentBalance
                    $totalPayments = $paymentRow->TotalPayments;
                    $totalFees = $accountRow->totalFees;
                    $addFees = $accountRow->addFees;
                    $discount = $accountRow->Discount;

                    $currentBalance = ($totalFees + $addFees) - $discount - $totalPayments;

                    // Update studeaccount for each student
                    $this->db->set('TotalPayments', $totalPayments);
                    $this->db->set('CurrentBalance', $currentBalance);
                    $this->db->where('StudentNumber', $paymentRow->StudentNumber);
                    $this->db->where('SY', $sy);
                    $this->db->update('studeaccount');
                }
            }

            // Check for updates
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Update successful!</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-info">Update successful!</div>');
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-warning">No payments found for the specified school year.</div>');
        }

        // Redirect or load a view to display the message
        redirect('Accounting/studeAccounts'); // Adjust this to your needs
    }

    function calculateBalance()
    {
        $sy = $this->session->userdata('sy');

        // Ensure we have the school year to filter by
        if (!$sy) {
            $this->session->set_flashdata('msg', '<div class="alert alert-warning">School year is missing.</div>');
            redirect('Accounting/studeAccounts');
        }

        // Perform batch update to directly calculate CurrentBalance in the query
        // $this->db->set('CurrentBalance', 'AcctTotal + addFees - (Discount + TotalPayments)', false);
        $this->db->set('CurrentBalance', 'AcctTotal  - (Discount + TotalPayments)', false);
        $this->db->where('SY', $sy);
        $this->db->update('studeaccount');

        // Check if any rows were updated
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Update successful!</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-info">No changes made!</div>');
        }

        // Redirect or load a view to display the message
        redirect('Accounting/studeAccounts'); // Adjust this to your needs
    }







    function calculateDiscounts()
    {
        $sy = $this->session->userdata('sy');
        $this->db->select('StudentNumber, SUM(discount_amount) AS TotalDiscounts');
        $this->db->from('studediscount');
        $this->db->where('SY', $sy);
        $this->db->group_by('StudentNumber');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                // Step 2: Update studeaccount for each student
                $this->db->set('Discount', $row->TotalDiscounts);
                $this->db->where('StudentNumber', $row->StudentNumber);
                $this->db->where('SY',  $sy);
                $this->db->update('studeaccount');
            }

            // Check for updates
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Update successful!</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Update successful!</div>');
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-success">No records found for the specified school year.</div>');
        }

        // Redirect or load a view here to display the message
        redirect('Accounting/studeAccounts'); // Adjust this to your needs
    }

    function calculateAddFees()
    {
        // Get the school year from session data
        $sy = $this->session->userdata('sy');

        // Start transaction
        $this->db->trans_start();

        // Step 1: Sum additional fees by student number
        $this->db->select('StudentNumber, SUM(add_amount) AS Additional');
        $this->db->from('studeadditional');
        $this->db->where('SY', $sy);
        $this->db->group_by('StudentNumber');
        $query = $this->db->get();

        // Check if there are any records returned
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                // Step 2: Update the addFees for each student
                $this->db->set('addFees', $row->Additional);
                $this->db->where('StudentNumber', $row->StudentNumber);
                $this->db->where('SY', $sy);
                $this->db->update('studeaccount');

                // Step 3: Get the current TotalFees for the student
                $this->db->select('TotalFees');
                $this->db->from('studeaccount');
                $this->db->where('StudentNumber', $row->StudentNumber);
                $this->db->where('SY', $sy);
                $totalFeesQuery = $this->db->get();
                $totalFees = ($totalFeesQuery->num_rows() > 0) ? $totalFeesQuery->row()->TotalFees : 0;

                // Step 4: Calculate the new AcctTotal
                $newAcctTotal = $row->Additional + $totalFees;

                // Step 5: Update the AcctTotal for the student
                $this->db->set('AcctTotal', $newAcctTotal);
                $this->db->where('StudentNumber', $row->StudentNumber);
                $this->db->where('SY', $sy);
                $this->db->update('studeaccount');
            }

            // Step 6: Check if any records were updated
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Update successful!</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-info">Update successful!</div>');
            }
        } else {
            // No additional fees found for the specified school year
            $this->session->set_flashdata('msg', '<div class="alert alert-warning">No records found for the specified school year.</div>');
        }

        // Complete transaction
        $this->db->trans_complete();

        // Check for transaction errors
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">An error occurred while updating records.</div>');
        }

        // Redirect to the accounts page
        redirect('Accounting/studeAccounts'); // Adjust this path as needed
    }





    function denyPayment()
    {
        $this->load->view('payment_deny');

        if ($this->input->post('submit')) {
            //get data from the form

            $opID = $this->input->post('opID');
            $email = $this->input->get('email');
            $FirstName = $this->input->get('FirstName');
            $amount = $this->input->get('amount');
            $StudentNumber = $this->input->post('StudentNumber');
            $denyReason = $this->input->post('denyReason');
            $deniedDate = date("Y-m-d");
            $text1 = "Denied Payment";
            $transDescription = $result = $text1 . ' - ' . $opID . ' ' . $denyReason;

            $Encoder = $this->session->userdata('username');
            //check if record exist
            $que = $this->db->query("select * from online_pay_deny where opID='" . $opID . "'");
            $row = $que->num_rows();
            if ($row) {
                //redirect('Page/notification_error');
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"><b>This payment was already denied.</b></div>');
                redirect('Page/proof_payment_view');
            } else {
                //save profile
                $que = $this->db->query("insert into online_pay_deny values('','$opID','$StudentNumber','$denyReason','$deniedDate')");
                //update online payment table
                $que = $this->db->query("update online_payments set depositStat='Denied' where opID='$opID'");
                //Save to audit trail
                $que = $this->db->query("insert into atrail values('','$transDescription','$deniedDate','','$Encoder','$StudentNumber')");
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><b>Denied successfully.</b></div>');

                //Email Notification
                $this->load->config('email');
                $this->load->library('email');
                $mail_message = 'Dear ' . $FirstName . ',' . "\r\n";
                $mail_message .= '<br><br>The payment you submitted has been denied.' . "\r\n";
                $mail_message .= '<br>Reason: <b>' . $denyReason . '</b>' . "\r\n";
                $mail_message .= '<br>Amount: <b>' . $amount . '</b>' . "\r\n";
                $mail_message .= '<br>Denied Date: <b>' . $deniedDate . '</b>' . "\r\n";

                $mail_message .= '<br><br>Thanks & Regards,';
                $mail_message .= '<br>SRMS - Online';

                $this->email->from('no-reply@lxeinfotechsolutions.com', 'SRMS Online Team')
                    ->to($email)
                    ->subject('Payment Denied')
                    ->message($mail_message);
                $this->email->send();

                redirect('Page/proof_payment_view');
            }
        }
    }

    public function collectionReport()
    {
        $SY = $this->session->userdata('sy');
        $this->load->model('StudentModel');
        $result = $this->StudentModel->collectionReportAll($SY);
        $this->load->view('collection_report', $result);
    }










    public function PrintYearReport($year)
    {
        $this->load->model('StudentModel');
        // Fetch data for the selected year
        $collection_data = $this->StudentModel->getReportByYear($year);

        // Calculate total amount and group by month
        $total_amount = 0;
        $monthly_summary = [];
        if (!empty($collection_data)) {
            foreach ($collection_data as $row) {
                // Assuming Amount is already formatted in getReportByYear
                $amount = floatval(str_replace(',', '', $row->Amount));
                $total_amount += $amount;

                // Get the month from the payment date
                $month = date('F', strtotime($row->PDate));

                // Initialize or add to the month's total
                if (!isset($monthly_summary[$month])) {
                    $monthly_summary[$month] = 0;
                }
                $monthly_summary[$month] += $amount;
            }
        }

        // Set up data to pass to the view
        $result = [
            'collection_data' => $collection_data, // Pass the collection data
            'selected_year' => $year, // Pass the selected year
            'total_amount' => $total_amount, // Pass the total amount
            'monthly_summary' => $monthly_summary, // Pass the monthly summary
            'letterhead' => $this->Login_model->loginImage() // Assuming this method returns the letterhead data
        ];

        // Load the view with the data
        $this->load->view('collectionYear', $result);
    }



    public function PrintMonthReport($year, $month)
    {
        $this->load->model('StudentModel');

        // Convert the month string and year to a DateTime object and format it
        $date = DateTime::createFromFormat('Y-m', "$year-$month");
        $formatted_month = $date->format('F, Y'); // Format to "September, 2024"

        // Fetch data for the selected month
        $collection_data = $this->StudentModel->getReportByMonth($year, $month);

        // Calculate the total amount from the collection data
        $total_amount = 0;
        foreach ($collection_data as $data) {
            $amount = (float) $data->Amount; // Cast to float
            $total_amount += $amount; // Safe addition
        }

        // Set up data to pass to the view
        $result = [
            'collection_data' => $collection_data, // Pass the collection data
            'selected_month' => $formatted_month, // Pass the formatted month
            'total_amount' => number_format($total_amount, 2), // Format total amount
            'letterhead' => $this->Login_model->loginImage() // Assuming this method returns the letterhead data
        ];

        // Load the view with the data
        $this->load->view('collectionMonth', $result);
    }




    public function PrintcollectionReport()
    {
        $SY = $this->session->userdata('sy');

        $this->load->model('StudentModel');
        $result = $this->StudentModel->collectionReportAll($SY);
        $result['letterhead'] = $this->Login_model->loginImage();
        $this->load->view('collection_reportPrint', $result);
    }


    function collectionYear()
    {
        $year = $this->input->get('year');
        $result['data'] = $this->StudentModel->collectionYear($year);
        $result['data1'] = $this->StudentModel->collectionTotalYear($year);
        $this->load->view('collection_year', $result);

        if ($this->input->post('submit')) {
            $year = $this->input->get('year');
            $result['data'] = $this->StudentModel->collectionYear($year);
            $result['data1'] = $this->StudentModel->collectionTotalYear($year);
            $this->load->view('collection_year', $result);
        }
    }


    public function studeAccounts()
    {
        $sem = $this->session->userdata('semester');
        $sy = $this->session->userdata('sy');
        // $course = $this->input->get('course'); 
        $yearlevel = $this->input->get('yearlevel');

        // Load course and year level data
        $result['course'] = $this->StudentModel->getCourse();
        $result['stude'] = $this->StudentModel->getprofile();
        $result['level'] = $this->StudentModel->getLevel();
        $result['data'] = $this->StudentModel->studeAccounts($sy, $yearlevel);
        $result['letterhead'] = $this->Login_model->loginImage();

        if ($this->input->post('submit')) {
            // Trim spaces from the student number
            $studentNumber = trim($this->input->post('StudentNumber'));

            // Retrieve student details based on the selected StudentNumber
            $studentDetails = $this->StudentModel->getStudentDetails($studentNumber);

            if ($studentDetails) {
                $selectedYearLevel = $studentDetails->YearLevel;
                $descriptions = $this->StudentModel->getDescriptionsByYearLevel($selectedYearLevel);

                $totalFees = 0;

                // Calculate total fees
                foreach ($descriptions as $description) {
                    $totalFees += $description->Amount;
                }

                // Insert each fee along with the total fees
                foreach ($descriptions as $description) {
                    $data = array(
                        'StudentNumber' => $studentNumber,
                        'Course' => $studentDetails->Course,
                        'YearLevel' => $studentDetails->YearLevel,
                        'Section' => $studentDetails->Section,
                        'Status' => $studentDetails->Status,
                        'SY' => $this->input->post('SY'),
                        'FeesDesc' => $description->Description,
                        'FeesAmount' => $description->Amount,
                        'TotalFees' => $totalFees,
                        'AcctTotal' => $totalFees,
                        'CurrentBalance' => $totalFees
                    );
                    $this->StudentModel->insertstudeAccount($data);
                }

                // Set success flashdata
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Data saved successfully!</div>');
            } else {
                // Set error flashdata
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Student details not found.</div>');
            }

            // Redirect to avoid resubmission
            redirect('Accounting/studeAccounts');
        }

        // Load the view with the data
        $this->load->view('accounting_students_accounts', $result);
    }




    public function SearchStudeAccounts()
    {
        $sy = $this->session->userdata('sy');
        $sem = $this->session->userdata('semester'); // optional, can be NULL

        $studentNumber = $this->input->post('StudentNumber');

        // Model now handles optional sem
        $result['data'] = $this->StudentModel->SearchStudeAccounts($studentNumber, $sy, $sem);

        $result['stude'] = $this->StudentModel->getprofile();

        $this->load->view('accounting_students_accountsv2', $result);
    }





    public function editStudentAccount($accountID)
    {
        // Get the current details of the student account
        $data['studentAccount'] = $this->StudentModel->getAccountDetails($accountID);
        $data['students'] = $this->StudentModel->getAllStudents(); // Add this method in your model
        // Check if student account exists
        if (!$data['studentAccount']) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Student account not found.</div>');
            redirect('Accounting/studeAccounts');
        }

        // Load the edit view
        $this->load->view('edit_student_account', $data);
    }


    public function updateStudentAccount()
    {
        $accountID = $this->input->post('AccountID');
        $SY = $this->session->userdata('sy');
        $existingAccount = $this->StudentModel->getAccountDetails($accountID);
        $discountAmount = (float) $this->input->post('discount_amount');
        $discountDescription = $this->input->post('discount_desc');

        if ($existingAccount) {
            // Add the discount record
            $discountData = array(
                'StudentNumber'    => $existingAccount->StudentNumber,
                'discount_desc'    => $discountDescription,
                'discount_amount'  => $discountAmount,
                'SY'               => $SY,
            );
            $this->StudentModel->addDiscount($discountData);

            // Update the account fields
            $updatedDiscount = $existingAccount->Discount + $discountAmount;
            $updatedCurrentBalance = $existingAccount->CurrentBalance - $discountAmount;

            $updateData = array(
                'Discount'       => $updatedDiscount,
                'CurrentBalance' => $updatedCurrentBalance,
            );

            $this->StudentModel->updateStudentAccountFields($existingAccount->StudentNumber, $SY, $updateData);

            // Add audit trail record
            $username = $this->session->userdata('username');
            $auditData = [
                'atDesc' => 'Updated discount for Student Number: ' . $existingAccount->StudentNumber,
                'atDate' => date('Y-m-d'),
                'atTime' => date('H:i:s'),
                'atRes'  => $username ? $username : 'Unknown User',
                'atSNo'  => $existingAccount->StudentNumber
            ];

            $this->db->insert('atrail', $auditData);

            $this->session->set_flashdata('msg', '<div class="alert alert-success">Account updated successfully!</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Account not found.</div>');
        }

        redirect('Accounting/studeAccounts');
    }





    public function deleteStudentAccount($StudentNumber)
    {
        // Get the current SY from the session
        $SY = $this->session->userdata('sy');

        // Fetch the account details for audit purposes
        $accountDetails = $this->StudentModel->getAccountDetailsByStudentNumber($StudentNumber, $SY);

        if ($accountDetails) {
            // Attempt to delete the student account for the current SY
            if ($this->StudentModel->deleteStudentAccount($StudentNumber, $SY)) {
                // Add audit trail record
                $username = $this->session->userdata('username');
                $auditData = [
                    'atDesc' => 'Deleted student account for Student Number: ' . $StudentNumber . ' (SY: ' . $SY . ')',
                    'atDate' => date('Y-m-d'),
                    'atTime' => date('H:i:s'),
                    'atRes'  => $username ? $username : 'Unknown User',
                    'atSNo'  => $StudentNumber
                ];

                $this->db->insert('atrail', $auditData);

                // Set success message if deletion is successful
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Account deleted successfully!</div>');
            } else {
                // Set error message if deletion fails
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Failed to delete the account. Please try again.</div>');
            }
        } else {
            // Set error message if account details are not found
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Account not found for the given student number and SY.</div>');
        }

        // Redirect to the student accounts page
        redirect('Accounting/studeAccounts');
    }







    // public function deleteStudentAccount($StudentNumber)
    // {
    //     // Get the current SY from the session
    //     $SY = $this->session->userdata('sy');

    //     // Attempt to delete the student account for the current SY
    //     if ($this->StudentModel->deleteStudentAccount($StudentNumber, $SY)) {
    //         // Set success message if deletion is successful
    //         $this->session->set_flashdata('msg', '<div class="alert alert-success">Account deleted successfully!</div>');
    //     } else {
    //         // Set error message if deletion fails
    //         $this->session->set_flashdata('msg', '<div class="alert alert-danger">Failed to delete the account. Please try again.</div>');
    //     }

    //     // Redirect to the student accounts page
    //     redirect('Accounting/studeAccounts');
    // }







    //work for tom




    public function deletePayment($id, $StudentNumber, $OR)
    {
        date_default_timezone_set('Asia/Manila');

        // Fetch the payment details before deletion
        $this->db->where('ID', $id);
        $payment = $this->db->get('paymentsaccounts')->row();

        if (!$payment) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Payment not found. Please try again.</div>');
            redirect('Accounting/Payment');
            return;
        }

        $deletedAmount = (float)$payment->Amount;
        $SY = $payment->SY;

        // Delete the payment
        $this->db->where('ID', $id);
        if ($this->db->delete('paymentsaccounts')) {

            $username = $this->session->userdata('username');
            $auditData = [
                'atDesc' => 'Deleted payment with O.R. No.: ' . $OR,
                'atDate' => date('Y-m-d'),
                'atTime' => date('H:i:s'),
                'atRes' => $username ? $username : 'Unknown User',
                'atSNo' => $StudentNumber
            ];

            $this->db->insert('atrail', $auditData);

            // Fetch account details
            $acctTotal = $this->SettingsModel->getAcctTotal($StudentNumber, $SY);
            $discount = $this->SettingsModel->getDiscount($StudentNumber, $SY);

            // Recalculate total payments and balance
            $newTotalPayments = $this->SettingsModel->calculateTotalPayments($StudentNumber, $SY);
            $newBalance = $acctTotal - ($discount + $newTotalPayments);

            // Update the student's account
            $this->SettingsModel->updateStudentAccount($StudentNumber, $newTotalPayments, $newBalance, $SY);

            $this->session->set_flashdata('msg', '<div class="alert alert-success">Payment deleted successfully, and account updated!</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Failed to delete the payment. Please try again.</div>');
        }
        redirect('Accounting/Payment');
    }


    function calculateStudentBalance($StudentNumber)
    {
        $sy = $this->session->userdata('sy');

        // Select TotalPayments for the specific student
        $this->db->select('StudentNumber, SUM(Amount) AS TotalPayments');
        $this->db->from('paymentsaccounts');
        $this->db->where('SY', $sy);
        $this->db->where('ORStatus', 'Valid');
        $this->db->where('StudentNumber', $StudentNumber); // Filter by specific student
        $this->db->group_by('StudentNumber');
        $paymentQuery = $this->db->get();

        if ($paymentQuery->num_rows() > 0) {
            $paymentRow = $paymentQuery->row();

            // Get account details for calculations
            $this->db->select('totalFees, addFees, Discount');
            $this->db->from('studeaccount');
            $this->db->where('StudentNumber', $paymentRow->StudentNumber);
            $this->db->where('SY', $sy);
            $accountQuery = $this->db->get();

            if ($accountQuery->num_rows() > 0) {
                $accountRow = $accountQuery->row();

                // Calculate CurrentBalance
                $totalPayments = $paymentRow->TotalPayments;
                $totalFees = $accountRow->totalFees;
                $addFees = $accountRow->addFees;
                $discount = $accountRow->Discount;

                $currentBalance = ($totalFees + $addFees) - $discount - $totalPayments;

                // Update studeaccount for the specific student
                $this->db->set('TotalPayments', $totalPayments);
                $this->db->set('CurrentBalance', $currentBalance);
                $this->db->where('StudentNumber', $paymentRow->StudentNumber);
                $this->db->where('SY', $sy);
                $this->db->update('studeaccount');
            }
        }
    }






    public function addFeesToStudentAccount($studentNumber)
    {
        $SY = $this->session->userdata('sy');
        $data['studentAccount'] = $this->StudentModel->getAccountDetailsByStudentNumberAndSY($studentNumber, $SY);

        if (!$data['studentAccount']) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Student account not found.</div>');
            redirect('Accounting/studeAccounts');
            return;
        }
        $this->load->view('addFees', $data);
    }

    public function saveNewFees()
    {
        $sy = $this->session->userdata('sy');
        $studentNumber = $this->input->post('StudentNumber');
        $newFeeDescription = $this->input->post('FeesDesc');
        $newFeeAmount = (float) $this->input->post('FeesAmount');

        $additionalData = array(
            'StudentNumber' => $studentNumber,
            'add_desc'      => $newFeeDescription,
            'add_amount'    => $newFeeAmount,
            'SY'            => $sy,
        );
        $this->StudentModel->insertIntoStudeAdditional($additionalData);

        $username = $this->session->userdata('username');
        $auditData = [
            'atDesc' => 'Add fees for Student Number: ' . $studentNumber,
            'atDate' => date('Y-m-d'),
            'atTime' => date('H:i:s'),
            'atRes'  => $username ? $username : 'Unknown User',
            'atSNo'  => $studentNumber
        ];

        $this->db->insert('atrail', $auditData);




        $studentAccount = $this->StudentModel->getAccountDetailsByStudentNumberAndSY($studentNumber, $sy);

        if ($studentAccount) {
            $updatedAcctTotal = $studentAccount->AcctTotal + $newFeeAmount;
            $updatedCurrentBalance = $studentAccount->CurrentBalance + $newFeeAmount;
            $updateData = array(
                'AcctTotal'      => $updatedAcctTotal,
                'CurrentBalance' => $updatedCurrentBalance
            );
            $this->StudentModel->updateStudentAccount($studentNumber, $sy, $updateData);
        }
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Account updated successfully!</div>');
        redirect('Accounting/studeAccounts');
    }


















    // Fetch course table data as JSON
    public function get_course_table()
    {
        $courses = $this->StudentModel->get_course_table();
        echo json_encode($courses);
    }

    // Fetch levels based on the selected course
    public function getLevelsByCourse()
    {
        $course = $this->input->post('course');
        if ($course) {
            $levels = $this->StudentModel->getLevelsByCourse($course);
            echo json_encode($levels);
        } else {
            echo json_encode([]); // Return an empty array if no course selected
        }
    }










    // public function AddstudeAccounts()
    // {
    //     $currentSY = $this->session->userdata('sy');
    //     $result['studentsWithoutAccounts'] = $this->StudentModel->getStudentsWithoutAccounts($currentSY);

    //     if ($this->input->post('save')) {
    //         $studentNumber = trim($this->input->post('StudentNumber'));
    //         $amountPaid = floatval($this->input->post('AmountPaid'));
    //         $currentBalance = floatval($this->input->post('CurrentBalance'));

    //         $studentDetails = $this->StudentModel->getStudentDetails($studentNumber, $currentSY);


    //         if ($studentDetails) {
    //             $existingAccount = $this->StudentModel->checkExistingAccount($studentNumber, $currentSY);
    //             if ($existingAccount) {
    //                 $this->session->set_flashdata('msg', '<div class="alert alert-danger">Account already exists for the current SY.</div>');
    //                 redirect('Accounting/studeAccounts');
    //             }

    //             $descriptions = $this->StudentModel->getDescriptionsByYearLevelAndSY($studentDetails->YearLevel, $currentSY);

    //             foreach ($descriptions as $description) {
    //                 $data = array(
    //                     'StudentNumber'   => $studentNumber,
    //                     'Course'          => $studentDetails->Course,
    //                     'YearLevel'       => $studentDetails->YearLevel,
    //                     'Section'         => $studentDetails->Section,
    //                     'Status'          => $studentDetails->Status,
    //                     'SY'              => $currentSY,
    //                     'FeesDesc'        => $description->Description,
    //                     'FeesAmount'      => $description->Amount,
    //                     'TotalFees'       => array_sum(array_column($descriptions, 'Amount')),
    //                     'AcctTotal'       => array_sum(array_column($descriptions, 'Amount')),
    //                     'TotalPayments'   => $amountPaid,
    //                     'CurrentBalance'  => $currentBalance
    //                 );

    //                 $this->StudentModel->insertstudeAccount($data);
    //             }

    //             // History log: Record account creation
    //             $username = $this->session->userdata('username');
    //             $auditData = [
    //                 'atDesc' => 'Created student account for Student Number: ' . $studentNumber,
    //                 'atDate' => date('Y-m-d'),
    //                 'atTime' => date('H:i:s'),
    //                 'atRes'  => $username ? $username : 'Unknown User',
    //                 'atSNo'  => $studentNumber
    //             ];

    //             $this->db->insert('atrail', $auditData);

    //             $this->session->set_flashdata('msg', '<div class="alert alert-success">Data entered successfully!</div>');
    //             redirect('Accounting/studeAccounts');
    //         } else {
    //             $this->session->set_flashdata('msg', '<div class="alert alert-danger">Student details not found.</div>');
    //             redirect('Accounting/studeAccounts');
    //         }
    //     }

    //     $this->load->view('accounting_students_Addaccounts', $result);
    // }




    // public function AddstudeAccounts()
    // {
    //     $currentSY = $this->session->userdata('sy');
    //     $result['studentsWithoutAccounts'] = $this->StudentModel->getStudentsWithoutAccounts($currentSY);

    //     if ($this->input->post('add')) {

    //         $studentNumber = trim($this->input->post('StudentNumber'));
    //         $amountPaid = floatval($this->input->post('AmountPaid'));
    //         $currentBalance = floatval($this->input->post('CurrentBalance'));

    //         $studentDetails = $this->StudentModel->getStudentDetails($studentNumber, $currentSY);

    //         if ($studentDetails) {
    //             // ✅ Check for any existing unpaid balance across all school years
    //             $balances = $this->StudentModel->getOutstandingBalancesPerSY($studentNumber);

    //             if (!empty($balances)) {
    //                 $balanceMsg = '
    //                 <div class="alert alert-danger" role="alert">
    //                     <h5 class="alert-heading">Outstanding Balances Detected</h5>
    //                     <p>The following balances must be settled before proceeding:</p>
    //                     <ul style="padding-left: 20px; margin-bottom: 0;">';

    //                 foreach ($balances as $b) {
    //                     $balanceMsg .= '<li style="margin-bottom: 5px;">
    //                         SY ' . $b->SY . ': 
    //                         <a href="' . base_url('Accounting/viewStudentBalanceForm/' . $studentNumber . '/' . $b->SY) . '" 
    //                             style="text-decoration: underline; color: #ffc107; font-weight: bold;">
    //                             ₱' . number_format($b->Balance, 2) . '
    //                         </a>
    //                     </li>';
    //                 }

    //                 $balanceMsg .= '</ul>
    //                     <hr style="margin-top: 10px; margin-bottom: 5px;">
    //                     <p class="mb-0">Please settle balances through the cashier or accounting office.</p>
    //                 </div>';



    //                 $this->session->set_flashdata('msg', '<div class="alert alert-danger">' . $balanceMsg . '</div>');
    //                 redirect('Accounting/studeAccounts');
    //             }

    //             // ✅ Check if account already exists for current SY
    //             $existingAccount = $this->StudentModel->checkExistingAccount($studentNumber, $currentSY);
    //             if ($existingAccount) {
    //                 $this->session->set_flashdata('msg', '<div class="alert alert-danger">Account already exists for the current SY.</div>');
    //                 redirect('Accounting/studeAccounts');
    //             }

    //             // ✅ Get applicable fee descriptions
    //             $descriptions = $this->StudentModel->getDescriptionsByYearLevelAndSY($studentDetails->YearLevel, $currentSY);

    //             foreach ($descriptions as $description) {
    //                 $data = array(
    //                     'StudentNumber'   => $studentNumber,
    //                     'Course'          => $studentDetails->Course,
    //                     'YearLevel'       => $studentDetails->YearLevel,
    //                     'Section'         => $studentDetails->Section,
    //                     'Status'          => $studentDetails->Status,
    //                     'SY'              => $currentSY,
    //                     'FeesDesc'        => $description->Description,
    //                     'FeesAmount'      => $description->Amount,
    //                     'TotalFees'       => array_sum(array_column($descriptions, 'Amount')),
    //                     'AcctTotal'       => array_sum(array_column($descriptions, 'Amount')),
    //                     'TotalPayments'   => $amountPaid,
    //                     'CurrentBalance'  => $currentBalance
    //                 );

    //                 $this->StudentModel->insertstudeAccount($data);
    //             }

    //             // ✅ Audit trail log
    //             $username = $this->session->userdata('username');
    //             $auditData = [
    //                 'atDesc' => 'Created student account for Student Number: ' . $studentNumber,
    //                 'atDate' => date('Y-m-d'),
    //                 'atTime' => date('H:i:s'),
    //                 'atRes'  => $username ? $username : 'Unknown User',
    //                 'atSNo'  => $studentNumber
    //             ];
    //             $this->db->insert('atrail', $auditData);

    //             $this->session->set_flashdata('msg', '<div class="alert alert-success">Data entered successfully!</div>');
    //             redirect('Accounting/studeAccounts');
    //         } else {
    //             $this->session->set_flashdata('msg', '<div class="alert alert-danger">Student details not found.</div>');
    //             redirect('Accounting/studeAccounts');
    //         }
    //     }

    //     $this->load->view('accounting_students_Addaccounts', $result);
    // }






    public function AddstudeAccounts()
    {
        $currentSY = $this->session->userdata('sy');
        $result['studentsWithoutAccounts'] = $this->StudentModel->getStudentsWithoutAccounts($currentSY);

        if ($this->input->post('add')) {

            $studentNumber = trim($this->input->post('StudentNumber'));
            $amountPaid = floatval($this->input->post('AmountPaid'));
            $currentBalance = floatval($this->input->post('CurrentBalance'));

            $studentDetails = $this->StudentModel->getStudentDetails($studentNumber, $currentSY);

            if ($studentDetails) {
                // ✅ Check for any existing unpaid balance across all school years
                $balances = $this->StudentModel->getOutstandingBalancesPerSY($studentNumber);

                if (!empty($balances)) {
                    $balanceMsg = '
                <div class="alert alert-danger" role="alert">
                    <h5 class="alert-heading">Outstanding Balances Detected</h5>
                    <p>The following balances must be settled before proceeding:</p>
                    <ul style="padding-left: 20px; margin-bottom: 0;">';

                    foreach ($balances as $b) {
                        $balanceMsg .= '<li style="margin-bottom: 5px;">
                        SY ' . $b->SY . ': 
                        <a href="' . base_url('Accounting/viewStudentBalanceForm/' . $studentNumber . '/' . $b->SY) . '" 
                            style="text-decoration: underline; color: #ffc107; font-weight: bold;">
                            ₱' . number_format($b->Balance, 2) . '
                        </a>
                    </li>';
                    }

                    $balanceMsg .= '</ul>
                    <hr style="margin-top: 10px; margin-bottom: 5px;">
                    <p class="mb-0">Please settle balances through the cashier or accounting office.</p>
                </div>';

                    $this->session->set_flashdata('msg', '<div class="alert alert-danger">' . $balanceMsg . '</div>');
                    redirect('Accounting/studeAccounts');
                }

                // ✅ Check if account already exists for current SY
                $existingAccount = $this->StudentModel->checkExistingAccount($studentNumber, $currentSY);
                if ($existingAccount) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger">Account already exists for the current SY.</div>');
                    redirect('Accounting/studeAccounts');
                }

                // ✅ Get applicable fee descriptions
                $descriptions = $this->StudentModel->getDescriptionsByYearLevelAndSY($studentDetails->YearLevel, $currentSY);

                foreach ($descriptions as $description) {
                    // Save to studeaccount
                    $data = array(
                        'StudentNumber'   => $studentNumber,
                        'Course'          => $studentDetails->Course,
                        'YearLevel'       => $studentDetails->YearLevel,
                        'Section'         => $studentDetails->Section,
                        'Status'          => $studentDetails->Status,
                        'SY'              => $currentSY,
                        'FeesDesc'        => $description->Description,
                        'FeesAmount'      => $description->Amount,
                        'TotalFees'       => array_sum(array_column($descriptions, 'Amount')),
                        'AcctTotal'       => array_sum(array_column($descriptions, 'Amount')),
                        'TotalPayments'   => $amountPaid,
                        'CurrentBalance'  => $currentBalance
                    );

                    $this->StudentModel->insertstudeAccount($data);

                    // Save to feesrecords
                    $feesRecord = array(
                        'Description'    => $description->Description,
                        'StudentNumber'  => $studentNumber,
                        'Amount'         => $description->Amount,
                        'Course'         => $studentDetails->Course,
                        'Major'          => $studentDetails->Major,
                        'YearLevel'      => $studentDetails->YearLevel,
                        'SY'             => $currentSY
                    );

                    $this->db->insert('feesrecords', $feesRecord);
                }

                // ✅ Audit trail log
                $username = $this->session->userdata('username');
                $auditData = [
                    'atDesc' => 'Created student account for Student Number: ' . $studentNumber,
                    'atDate' => date('Y-m-d'),
                    'atTime' => date('H:i:s'),
                    'atRes'  => $username ? $username : 'Unknown User',
                    'atSNo'  => $studentNumber
                ];
                $this->db->insert('atrail', $auditData);

                $this->session->set_flashdata('msg', '<div class="alert alert-success">Data entered successfully!</div>');
                redirect('Accounting/studeAccounts');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Student details not found.</div>');
                redirect('Accounting/studeAccounts');
            }
        }

        $this->load->view('accounting_students_Addaccounts', $result);
    }











    public function massUpdateFeesRecords()
    {
        $this->load->model('StudentModel');

        $currentSY = $this->session->userdata('sy');
        $studeAccounts = $this->StudentModel->getStudeAccountsBySY($currentSY);

        $insertedCount = 0;
        foreach ($studeAccounts as $account) {
            // Check if this (student, description, SY) already exists in feesrecords
            $exists = $this->StudentModel->checkFeesRecordExists(
                $account->StudentNumber,
                $account->FeesDesc,
                $currentSY
            );

            if (!$exists) {
                // Insert to feesrecords
                $data = array(
                    'Description'    => $account->FeesDesc,
                    'StudentNumber'  => $account->StudentNumber,
                    'Amount'         => $account->FeesAmount,
                    'Course'         => $account->Course,
                    'YearLevel'      => $account->YearLevel,
                    'SY'             => $currentSY
                );

                $this->db->insert('feesrecords', $data);
                $insertedCount++;
            }
        }

        $this->session->set_flashdata('msg', "<div class='alert alert-success'>Mass update complete. Inserted <strong>$insertedCount</strong> missing feesrecords.</div>");
        redirect('Accounting/studeAccounts');
    }











    // public function viewStudentBalanceForm($studentNumber, $sy)
    // {

    //     $lastOR = $this->SettingsModel->getLastORNumber();
    //     $nextORSuggestion = $this->generateNextOR($lastOR);


    //     $data['data'] = $this->StudentModel->getStudentBalanceDetails($studentNumber, $sy);

    //     if (!$data['data']) {
    //         show_404();
    //     }

    //     $this->load->view('accounting_student_balance_form', $data);
    // }




    public function viewStudentBalanceForm($studentNumber, $sy)
    {
        // Get the student balance details
        $data['data'] = $this->StudentModel->getStudentBalanceDetails($studentNumber, $sy);

        // Check if data exists, if not, show 404
        if (!$data['data']) {
            show_404();
        }

        // Get the last OR number and generate the next one
        $lastOR = $this->SettingsModel->getLastORNumber();
        $nextORSuggestion = $this->generateNextOR2($lastOR);

        // Prepare the data for the view
        $data['newORSuggestion'] = $nextORSuggestion;
        $data['prof'] = $this->SettingsModel->semesterstude();
        $data['SY'] = $sy;

        // Load the view
        $this->load->view('accounting_student_balance_form', $data);
    }

    // Generate the next OR number based on the last one
    private function generateNextOR2($lastOR)
    {
        $nextNumericPart = intval($lastOR) + 1; // Increment the numeric part
        return (string)$nextNumericPart; // Return the new OR number as a string
    }

    public function groupPayments2($payments)
    {
        $grouped = [];
        foreach ($payments as $row) {
            // Ensure 'description' exists in the row before processing
            if (isset($row->description)) {
                if (!isset($grouped[$row->description])) {
                    $grouped[$row->description] = 0;
                }
                $grouped[$row->description] += $row->Amount;
            } else {
                // Handle case where description is missing, e.g., log or default value
                log_message('error', 'Missing description for payment: ' . json_encode($row));
            }
        }
        return $grouped;
    }

    public function savePayment2()
    {
        $SY = $this->input->post('SY');
        $studentNumber = $this->input->post('StudentNumber');
        $amount = (float)$this->input->post('Amount');
        $customOR = $this->input->post('ORNumber');

        // Fetch account details before inserting the payment
        $totalPaymentsBefore = $this->SettingsModel->getTotalPayments1($studentNumber, $SY);
        $acctTotal = $this->SettingsModel->getAcctTotal($studentNumber, $SY);
        $discount = $this->SettingsModel->getDiscount($studentNumber, $SY);

        // Calculate new values
        $newTotalPayments = $totalPaymentsBefore + $amount;
        $newBalance = max($acctTotal - ($discount + $newTotalPayments), 0);

        // Insert the payment
        $data = [
            'StudentNumber' => $studentNumber,
            'PaymentType' => $this->input->post('PaymentType'),
            'description' => $this->input->post('description'),
            'Amount' => $amount,
            'ORNumber' => $customOR,
            'PDate' => $this->input->post('PDate'),
            'CheckNumber' => $this->input->post('CheckNumber'),
            'Bank' => $this->input->post('Bank'),
            'Cashier' => $this->session->userdata('username'),
            'CollectionSource' => $this->input->post('CollectionSource'),
            'ORStatus' => 'Valid',
            'Course' => $this->input->post('Course'),
            'SY' => $SY
        ];

        // Insert the payment record into the database
        $this->SettingsModel->insertpaymentsaccounts($data);

        // Update the student's account with the new balance and total payments
        $this->SettingsModel->updateStudentAccount($studentNumber, $newTotalPayments, $newBalance, $SY);

        $this->session->set_flashdata('msg', 'Payment added successfully.');
        redirect('Accounting/Payment');
    }




    // public function getStudentDetailsWithFees()
    // {
    //     $studentNumber = $this->input->post('StudentNumber');
    //     $currentSY = $this->session->userdata('sy');  // Get logged-in SY

    //     $studentDetails = $this->StudentModel->getStudentDetails($studentNumber);

    //     if ($studentDetails) {
    //         $yearLevel = $studentDetails->YearLevel;
    //         // Fetch fees by YearLevel and current SY only
    //         $fees = $this->StudentModel->getDescriptionsByYearLevelAndSY($yearLevel, $currentSY);
    //         // Fetch the amount paid for the student
    //         $amountPaid = $this->StudentModel->getAmountPaid($studentNumber);

    //         // Combine student details, fees, and amount paid into one response
    //         $response = [
    //             'studentDetails' => $studentDetails,
    //             'fees' => $fees,
    //             'amountPaid' => $amountPaid // Add amount paid to response
    //         ];

    //         echo json_encode($response);
    //     } else {
    //         echo json_encode(['error' => 'Student not found']);
    //     }
    // }



    public function getStudentDetailsWithFees()
    {
        $studentNumber = $this->input->post('StudentNumber');
        $SY = $this->input->post('SY');

        $studentDetails = $this->StudentModel->getStudentDetails($studentNumber, $SY);
        $fees = $this->StudentModel->getDescriptionsByYearLevelAndSY($studentDetails->YearLevel, $SY);
        $amountPaid = $this->StudentModel->getAmountPaid($studentNumber, $SY); // Optional
        $balances = $this->StudentModel->getOutstandingBalancesPerSY($studentNumber);

        if ($studentDetails) {
            echo json_encode([
                'studentDetails' => $studentDetails,
                'fees' => $fees,
                'amountPaid' => $amountPaid,
                'balances' => $balances
            ]);
        } else {
            echo json_encode(['error' => 'Student not found.']);
        }
    }






    function studeAccountsWithBalance()
    {
        $sem = $this->session->userdata('semester');
        $sy = $this->session->userdata('sy');
        $course = $this->input->get('course');
        $yearlevel = $this->input->get('yearlevel');
        $result['course'] = $this->StudentModel->getCourse();
        $result['data'] = $this->StudentModel->studeAccountsWithBalance($sy, $course, $yearlevel);
        $this->load->view('accounting_students_with_balance', $result);
        if ($this->input->post('submit')) {
            $sem = $this->session->userdata('semester');
            $sy = $this->session->userdata('sy');
            $course = $this->input->get('course');
            $yearlevel = $this->input->get('yearlevel');
            $result['course'] = $this->StudentModel->getCourse();
            $result['data'] = $this->StudentModel->studeAccountsWithBalance($sem, $sy, $course, $yearlevel);
            $this->load->view('accounting_students_with_balance', $result);
        }
    }

    function accountingStudeReports()
    {
        $result['data'] = $this->StudentModel->getProfile();
        $this->load->view('accounting_stude_reports', $result);
    }

    function studentStatement()
    {
        $result['letterhead'] = $this->Login_model->loginImage();

        $sem = $this->session->userdata('semester');
        $sy = $this->session->userdata('sy');
        $id = $this->input->get('id');
        $result['data'] = $this->StudentModel->studentStatement($id, $sy);
        $result['data1'] = $this->SettingsModel->getSchoolInformation();
        $this->load->view('accounting_stude_account', $result);
    }


    public function sendStatementEmail()
    {
        $studentNumber = $this->input->get('id');
        $semester = $this->session->userdata('semester');
        $sy = $this->session->userdata('sy');

        $data = $this->StudentModel->studentStatement($studentNumber, $sy);
        $school = $this->SettingsModel->getSchoolInformation();
        $schoolName = $school[0]->SchoolName ?? 'School';
        $schoolAddress = $school[0]->SchoolAddress ?? '';

        if (empty($data)) {
            $this->session->set_flashdata('danger', 'No student record found.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $email = $data[0]->EmailAddress;
        if (empty($email)) {
            $this->session->set_flashdata('danger', 'Student has no email address on record.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $body = '
        <div style="font-family: Arial, sans-serif; color: #333;">
            <h2 style="color: #2b6cb0;">Statement of Account</h2>
            <p>Dear <strong>' . htmlspecialchars($data[0]->FirstName) . '</strong>,</p>
            <p>Here is your Statement of Account for <strong>SY ' . htmlspecialchars($sy) . '</strong> at <strong>' . htmlspecialchars($schoolName) . '</strong>.</p>
            <p>
                <strong>Student Number:</strong> ' . $data[0]->StudentNumber . '<br>
                <strong>Name:</strong> ' . $data[0]->LastName . ', ' . $data[0]->FirstName . ' ' . $data[0]->MiddleName . '<br>
                <strong>Year Level:</strong> ' . $data[0]->YearLevel . '
            </p>
        
            <h4 style="color: #2b6cb0;">Account Summary</h4>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 10px; border: 1px solid #ccc; text-align: left;">Description</th>
                        <th style="padding: 10px; border: 1px solid #ccc; text-align: right;">Amount (PHP)</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data as $row) {
            $body .= '<tr>
                <td style="padding: 8px; border: 1px solid #eee;">' . $row->FeesDesc . '</td>
                <td style="padding: 8px; border: 1px solid #eee; text-align: right;">' . number_format($row->FeesAmount, 2) . '</td>
            </tr>';
        }

        $body .= '
                    <tr style="background-color: #fcfcfc;">
                        <td style="padding: 8px; border: 1px solid #ccc;"><strong>Additional Fees</strong></td>
                        <td style="padding: 8px; border: 1px solid #ccc; text-align: right;">' . number_format($data[0]->addFees, 2) . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ccc;"><strong>Total Account</strong></td>
                        <td style="padding: 8px; border: 1px solid #ccc; text-align: right;">' . number_format($data[0]->AcctTotal, 2) . '</td>
                    </tr>
                    <tr style="background-color: #fcfcfc;">
                        <td style="padding: 8px; border: 1px solid #ccc;"><strong>Total Discount</strong></td>
                        <td style="padding: 8px; border: 1px solid #ccc; text-align: right;">' . number_format($data[0]->Discount, 2) . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ccc;"><strong>Total Payments</strong></td>
                        <td style="padding: 8px; border: 1px solid #ccc; text-align: right;">' . number_format($data[0]->TotalPayments, 2) . '</td>
                    </tr>
                    <tr style="background-color: #e9f5ff;">
                        <td style="padding: 10px; border: 1px solid #ccc;"><strong>Current Balance</strong></td>
                        <td style="padding: 10px; border: 1px solid #ccc; text-align: right;"><strong>' . number_format($data[0]->CurrentBalance, 2) . '</strong></td>
                    </tr>
                </tbody>
            </table>
        
            <p style="margin-top: 20px;">If you have any questions or concerns, please contact the accounting office.</p>
            <p>
                <strong>' . $schoolName . '</strong><br>
                ' . $schoolAddress . '
            </p>
        </div>';


        // Send Email
        $this->load->config('email');
        $this->load->library('email');
        $this->email->set_mailtype("html");

        $this->email->from('no-reply@srmsportal.com', $schoolName);
        $this->email->to($email);
        $this->email->subject('Your Statement of Account - SY ' . $sy);
        $this->email->message($body);

        if ($this->email->send()) {
            $this->session->set_flashdata('msg', 'Statement of Account emailed successfully.');
        } else {
            $this->session->set_flashdata('msg', 'Failed to send email. Please check email configuration.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }


    public function expenses()
    {
        $data['data'] = $this->SettingsModel->expenses();
        $data['data1'] = $this->SettingsModel->get_expensesCategory();

        $this->load->view('expenses', $data);

        if ($this->input->post('save')) {
            $data = array(
                'Description' => $this->input->post('Description'),
                'Amount' => $this->input->post('Amount'),
                'Responsible' => $this->input->post('Responsible'),
                'ExpenseDate' => $this->input->post('ExpenseDate'),
                'Category' => $this->input->post('Category')
            );
            $this->SettingsModel->insertexpenses($data);

            // Redirect back to the expenses page after saving
            redirect('Accounting/expenses');
        }
    }


    public function updateexpenses()
    {
        $expensesid = $this->input->get('expensesid');
        $result['data'] = $this->SettingsModel->getexpensesbyId($expensesid);
        $data['data1'] = $this->SettingsModel->get_expensesCategory();

        // Merge both result and data1 arrays and pass them to the view
        $this->load->view('updateexpenses', array_merge($result, $data));

        if ($this->input->post('update')) {

            $Description = $this->input->post('Description');
            $Amount = $this->input->post('Amount');
            $Responsible = $this->input->post('Responsible');
            $ExpenseDate = $this->input->post('ExpenseDate');
            $Category = $this->input->post('Category');

            $this->SettingsModel->updateexpenses($expensesid, $Description, $Amount, $Responsible, $ExpenseDate, $Category);
            $this->session->set_flashdata('expenses', 'Record updated successfully');
            redirect("Accounting/expenses");
        }
    }



    public function Deleteexpenses()
    {
        $expensesid = $this->input->get('expensesid');
        if ($expensesid) {
            $this->SettingsModel->Delete_expenses($expensesid);
            $this->session->set_flashdata('expenses', 'Record deleted successfully');
        } else {
            $this->session->set_flashdata('expenses', 'Error deleting record');
        }

        redirect("Accounting/expenses");
    }


    public function expensescategory()
    {
        $data['data'] = $this->SettingsModel->get_expensesCategory();
        $this->load->view('expensescategory', $data);

        if ($this->input->post('save')) {
            $data = array(
                'Category' => $this->input->post('Category'),
            );
            $this->SettingsModel->insertexpensesCategory($data);

            // Redirect back to the expenses category page after saving
            redirect('Accounting/expensescategory');
        }
    }

    public function updateexpensescategory()
    {
        $categoryID = $this->input->get('categoryID');
        $result['data'] = $this->SettingsModel->getexpensescategorybyId($categoryID);
        $this->load->view('updateexpensescategory', $result);

        if ($this->input->post('update')) {

            $Category = $this->input->post('Category');


            $this->SettingsModel->updateexpensescategory($categoryID, $Category);
            $this->session->set_flashdata('expenses', 'Record updated successfully');
            redirect("Accounting/expensescategory");
        }
    }


    public function Deleteexpensescategory()
    {
        $categoryID = $this->input->get('categoryID');
        if ($categoryID) {
            $this->SettingsModel->Delete_expensescategory($categoryID);
            $this->session->set_flashdata('expensescategory', 'Record deleted successfully');
        } else {
            $this->session->set_flashdata('expensescategory', 'Error deleting record');
        }

        redirect("Accounting/expensescategory");
    }



    public function expensesReport()
    {
        $this->load->model('SettingsModel');

        $data['data'] = $this->SettingsModel->get_expenses();
        $data['categories'] = $this->SettingsModel->get_categories(); // Fetch categories


        // Convert categories array to a simpler format if needed
        $data['categories'] = array_column($data['categories'], 'Category');

        $this->load->view('expensesReport', $data);
    }


    public function expenseSGenerate()
    {

        $data['letterhead'] = $this->Login_model->loginImage();
        // Get parameters from the URL
        $category = $this->input->get('category');
        $fromDate = $this->input->get('from');
        $toDate = $this->input->get('to');

        // Load the database library if it's not already loaded
        $this->load->database();

        // Fetch data from the database based on the passed parameters
        $this->db->select('*');
        $this->db->from('expenses');
        if ($category) {
            $this->db->where('Category', $category);
        }
        if ($fromDate && $toDate) {
            $this->db->where('ExpenseDate >=', $fromDate);
            $this->db->where('ExpenseDate <=', $toDate);
        }
        $query = $this->db->get();
        $result = $query->result();

        // Pass the data to the view
        $data['category'] = $category;
        $data['fromDate'] = $fromDate;
        $data['toDate'] = $toDate;
        $data['result'] = $result;

        // Load the view and pass the data
        $this->load->view('filtered_expenses', $data);
    }


    public function PaymentGenerate()
    {
        // Get parameters from the URL
        $description = $this->input->get('description');
        $fromDate = $this->input->get('from');
        $toDate = $this->input->get('to');

        // Load the database library if it's not already loaded
        $this->load->database();

        // Fetch data from the database based on the passed parameters
        $this->db->select('paymentsaccounts.*, studeprofile.*');
        $this->db->from('paymentsaccounts');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber');
        if ($description) {
            $this->db->where('description', $description);
        }
        if ($fromDate && $toDate) {
            $this->db->where('Pdate >=', $fromDate);
            $this->db->where('Pdate <=', $toDate);
        }
        $query = $this->db->get();
        $result = $query->result();

        // Pass the data to the view
        $data['description'] = $description;
        $data['fromDate'] = $fromDate;
        $data['toDate'] = $toDate;
        $data['result'] = $result;

        // Load the view and pass the data
        $this->load->view('filtered_payment', $data);
    }


    // public function Payment()
    // {
    //     $Sem = $this->session->userdata('semester');
    //     $SY = $this->session->userdata('sy');
    //     $id = $this->session->userdata('IDNumber');
    //     $this->load->model('SettingsModel');

    //     $today = date('Y-m-d');
    //     $allPayments = $this->SettingsModel->Payment($SY, $Sem);

    //     $payments = array_filter($allPayments, function ($row) use ($today) {
    //         return date('Y-m-d', strtotime($row->PDate)) === $today;
    //     });

    //     $lastOR = $this->SettingsModel->getLastORNumber();
    //     $nextORSuggestion = $this->generateNextOR($lastOR);

    //     $data = [
    //         'data' => $payments,
    //         'prof' => $this->SettingsModel->semesterstude(),
    //         'newORSuggestion' => $nextORSuggestion,
    //         'SY' => $SY,
    //         'groupedPayments' => $this->groupPayments($payments)
    //     ];

    //     if ($this->input->post('save')) {
    //         $customOR = $this->input->post('ORNumber'); 
    //         $this->savePayment($SY, $customOR);
    //         redirect('Accounting/Payment');
    //     }

    //     $this->load->view('payment', $data);
    // }

  public function Payment()
{
    date_default_timezone_set('Asia/Manila');

    $SY    = $this->session->userdata('sy');
    $today = date('Y-m-d');

    // --- read range (GET), default to today..today ---
    $from = $this->input->get('from') ?: $today;
    $to   = $this->input->get('to')   ?: $today;

    // normalize/validate (YYYY-MM-DD only)
    $from = date('Y-m-d', strtotime($from));
    $to   = date('Y-m-d', strtotime($to));

    // swap if user inverted dates
    if (strtotime($from) > strtotime($to)) {
        [$from, $to] = [$to, $from];
    }

    $this->load->model('SettingsModel');

    // NEW: use a range query instead of "today only"
    $payments = $this->SettingsModel->getPaymentsByDateRange($SY, $from, $to);

    $lastOR            = $this->SettingsModel->getLastORNumber();
    $nextORSuggestion  = $this->generateNextOR($lastOR);

    // (optional) quick grand total for the header
    $grandTotal = 0.00;
    foreach ($payments as $p) {
        $grandTotal += (float)($p->Amount ?? 0);
    }

    $data = [
        'data'             => $payments,
        'prof'             => $this->SettingsModel->semesterstude(),
        'newORSuggestion'  => $nextORSuggestion,
        'SY'               => $SY,
        'groupedPayments'  => $this->groupPayments($payments),
        'orDisplay'        => $this->SettingsModel->getOrDisplayFlag(),
        // pass the selected/normalized range + total to the view
        'from'             => $from,
        'to'               => $to,
        'grandTotal'       => $grandTotal,
    ];

    if ($this->input->post('save')) {
        $customOR = $this->input->post('ORNumber');
        $this->savePayment($SY, $customOR);
        redirect('Accounting/Payment');
        return;
    }

    $this->load->view('payment', $data);
}



    private function generateNextOR($lastOR)
    {
        $nextNumericPart = intval($lastOR) + 1;

        return (string)$nextNumericPart;
    }



    private function groupPayments($payments)
    {
        $grouped = [];

        foreach ($payments as $payment) {
            $desc = $payment->description;
            if (!isset($grouped[$desc])) {
                $grouped[$desc] = 0;
            }
            $grouped[$desc] += $payment->Amount;
        }

        return $grouped;
    }










// private function savePayment($SY, $customOR)
// {
//     // Validate OR first (as you already do)
//     if ($this->SettingsModel->isORNumberExists($customOR)) {
//         $this->session->set_flashdata('error', 'The O.R. number already exists. Please enter a unique O.R. number.');
//         redirect('Accounting/Payment');
//         return;
//     }

//     $studentNumber = $this->input->post('StudentNumber');
//     $amount        = (float)$this->input->post('Amount');
//     $pdate         = $this->input->post('PDate');

//     // Generate transaction ref (system)
//     $txnRef = $this->makeTxnRefWithRetry($pdate);

//     // Fetch balances BEFORE payment
//     $acctTotal           = $this->SettingsModel->getAcctTotal($studentNumber, $SY);
//     $discount            = $this->SettingsModel->getDiscount($studentNumber, $SY);
//     $totalPaymentsBefore = $this->SettingsModel->getTotalPayments1($studentNumber, $SY);
//     $newTotalPayments    = $totalPaymentsBefore + $amount;
//     $newBalance          = max($acctTotal - ($discount + $newTotalPayments), 0);

//     // Start DB transaction — atomic insert + updates
//     $this->db->trans_begin();

//     try {
//         // Insert payment with transaction_ref
//         $data = [
//             'transaction_ref' => $txnRef,
//             'StudentNumber'   => $studentNumber,
//             'PaymentType'     => $this->input->post('PaymentType'),
//             'description'     => $this->input->post('description'),
//             'Amount'          => $amount,
//             'ORNumber'        => $customOR,
//             'PDate'           => $pdate,
//             'CheckNumber'     => $this->input->post('CheckNumber'),
//             'Bank'            => $this->input->post('Bank'),
//             'Cashier'         => $this->session->userdata('username'),
//             'CollectionSource'=> $this->input->post('CollectionSource'),
//             'ORStatus'        => 'Valid',
//             'Course'          => $this->input->post('Course'),
//             'SY'              => $SY
//         ];

//         $this->SettingsModel->insertpaymentsaccounts($data);

//         // Update student account totals
//         $this->SettingsModel->updateStudentAccount($studentNumber, $newTotalPayments, $newBalance, $SY);

//         // Monthly schedule (your existing logic)
//         $exists = $this->SettingsModel->checkMonthlyScheduleExists($studentNumber, $SY);
//         if (!$exists) {
//             $monthSet  = $this->SettingsModel->getMonthlyDuration(); // [{durationOrder:'YYYY-MM-DD'}, ...]
//             $numMonths = count($monthSet);
//             if ($numMonths > 0) {
//                 $remainingBalance = max($acctTotal - $discount - $amount, 0);
//                 $monthlyAmount    = round($remainingBalance / $numMonths, 2);
//                 foreach ($monthSet as $month) {
//                     $this->SettingsModel->insertMonthlySchedule([
//                         'StudentNumber' => $studentNumber,
//                         'SY'            => $SY,
//                         'month_due'     => $month->durationOrder,
//                         'amount'        => $monthlyAmount,
//                         'status'        => 'Pending'
//                     ]);
//                 }
//             }
//         } else {
//             // This will modify monthly_payment_schedule amounts/statuses for this student/SY
//             $this->SettingsModel->applyLatestPaymentToMonthlySchedule($studentNumber, $SY, $amount, $pdate);
//         }

//         // 2b) Keep overdue_candidates in sync with the live monthly schedule
//         //     (only updates existing candidate rows for this student+SY)
//         $synced = $this->AccountingModel->syncAllCandidatesForStudentSY($studentNumber, $SY);

//         // Commit
//         if ($this->db->trans_status() === FALSE) {
//             throw new Exception('Transaction failed.');
//         }
//         $this->db->trans_commit();

//         $msg = 'Payment added successfully. Txn Ref: <strong>' . htmlspecialchars($txnRef, ENT_QUOTES) . '</strong>';
       
//         $this->session->set_flashdata('msg', $msg);

//     } catch (\Throwable $e) {
//         $this->db->trans_rollback();
//         $this->session->set_flashdata('error', 'Unable to save payment. ' . $e->getMessage());
//     }

//     redirect('Accounting/Payment');
// }






private function savePayment($SY, $customOR)
{
    // Validate OR first (as you already do)
    if ($this->SettingsModel->isORNumberExists($customOR)) {
        $this->session->set_flashdata('error', 'The O.R. number already exists. Please enter a unique O.R. number.');
        redirect('Accounting/Payment');
        return;
    }

    $studentNumber = $this->input->post('StudentNumber');
    $amount        = (float)$this->input->post('Amount');
    $pdate         = $this->input->post('PDate');

    // Generate transaction ref (system)
    $txnRef = $this->makeTxnRefWithRetry($pdate);

    // Fetch balances BEFORE payment
    $acctTotal           = $this->SettingsModel->getAcctTotal($studentNumber, $SY);
    $discount            = $this->SettingsModel->getDiscount($studentNumber, $SY);
    $totalPaymentsBefore = $this->SettingsModel->getTotalPayments1($studentNumber, $SY);

    $newTotalPayments = $totalPaymentsBefore + $amount;
    $newBalance       = max($acctTotal - ($discount + $newTotalPayments), 0);

    // Start DB transaction — atomic insert + updates
    $this->db->trans_begin();

    try {
        // Insert payment with transaction_ref
        $data = [
            'transaction_ref'  => $txnRef,
            'StudentNumber'    => $studentNumber,
            'PaymentType'      => $this->input->post('PaymentType'),
            'description'      => $this->input->post('description'),
            'Amount'           => $amount,
            'ORNumber'         => $customOR,
            'PDate'            => $pdate,
            'CheckNumber'      => $this->input->post('CheckNumber'),
            'Bank'             => $this->input->post('Bank'),
            'Cashier'          => $this->session->userdata('username'),
            'CollectionSource' => $this->input->post('CollectionSource'),
            'ORStatus'         => 'Valid',
            'Course'           => $this->input->post('Course'),
            'SY'               => $SY
        ];

        $this->SettingsModel->insertpaymentsaccounts($data);

        // Update student account totals
        $this->SettingsModel->updateStudentAccount($studentNumber, $newTotalPayments, $newBalance, $SY);

        /**
         * MONTHLY SCHEDULE
         * Rule: always apply payments to the OLDEST unpaid month(s) first.
         */
        $exists = $this->SettingsModel->checkMonthlyScheduleExists($studentNumber, $SY);

        if (!$exists) {
            // Generate a fresh schedule from the *remaining* balance after this payment.
            // Distribute $newBalance evenly across the configured months (oldest → newest).
            $monthSet  = $this->SettingsModel->getMonthlyDuration(); // e.g., [{durationOrder:'YYYY-MM-DD'}, ...]
            $numMonths = is_array($monthSet) ? count($monthSet) : 0;

            if ($numMonths > 0) {
                // Even split with remainder distribution (to keep sum exactly = $newBalance)
                $per   = ($numMonths > 0) ? round($newBalance / $numMonths, 2) : 0.00;
                $total = round($per * $numMonths, 2);
                $diff  = round($newBalance - $total, 2);     // could be small +/- due to rounding
                $cents = (int)round($diff * 100);            // number of cents to distribute (can be negative)

                foreach ($monthSet as $i => $month) {
                    $amt = $per;

                    // Distribute residual cents to earliest months
                    if ($cents !== 0) {
                        if ($cents > 0) {
                            $amt  = round($amt + 0.01, 2);
                            $cents--;
                        } elseif ($cents < 0) {
                            $amt  = round($amt - 0.01, 2);
                            $cents++;
                        }
                    }

                    $status = ($amt <= 0.0) ? 'Paid' : 'Pending';

                    $this->SettingsModel->insertMonthlySchedule([
                        'StudentNumber' => $studentNumber,
                        'SY'            => $SY,
                        'month_due'     => $month->durationOrder,
                        'amount'        => max($amt, 0.00),
                        'status'        => $status
                    ]);
                }
            }
            // Note: no need to "apply" the just-saved payment here since
            // we already computed $newBalance (after payment) and split that.
        } else {
            // Schedule already exists → consume this payment oldest-first (ignore PDate)
            $this->SettingsModel->applyPaymentOldestFirst($studentNumber, $SY, $amount);
        }

        // 2b) Keep overdue_candidates in sync with the live monthly schedule
        //     (only updates existing candidate rows for this student+SY)
        $this->load->model('AccountingModel', 'acct');
        if (method_exists($this->acct, 'syncAllCandidatesForStudentSY')) {
            $synced = $this->acct->syncAllCandidatesForStudentSY($studentNumber, $SY);
        }

        // Commit
        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Transaction failed.');
        }
        $this->db->trans_commit();

        $msg = 'Payment added successfully. Txn Ref: <strong>' . htmlspecialchars($txnRef, ENT_QUOTES) . '</strong>';
        $this->session->set_flashdata('msg', $msg);

    } catch (\Throwable $e) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('error', 'Unable to save payment. ' . $e->getMessage());
    }

    redirect('Accounting/Payment');
}





















    private function makeTxnRef(string $dateYmd = null): string
{
    // Format: TRX-YYYYMMDD-#### (daily sequence)
    $today = $dateYmd ?: date('Y-m-d');
    $yyyymmdd = date('Ymd', strtotime($today));
    $seq = $this->SettingsModel->getNextTxnSeqForDate($today); // e.g., returns 1,2,3...

    return sprintf('TRX-%s-%04d', $yyyymmdd, $seq);
}

private function makeTxnRefWithRetry($pdate, $prefix = 'PAY')
{
    $sy  = $this->session->userdata('sy') ?: 'NA';
    $sem = $this->session->userdata('semester') ?: 'NA';
    $yyyymmdd = date('Ymd', strtotime($pdate ?: 'now'));

    // Try a few times in the extremely unlikely event of a collision
    for ($i = 0; $i < 5; $i++) {
        // random 8 hex chars; tie to microtime to further reduce chance
        $rand = strtoupper(bin2hex(random_bytes(4)));
        $ref  = sprintf('%s-%s-%s-%s-%s', $prefix, $yyyymmdd, $sy, $sem, $rand);

        if (!$this->SettingsModel->txnRefExists($ref)) {
            return $ref;
        }
    }
  return sprintf(
        '%s-%s-%s-%s-%s',
        $prefix,
        $yyyymmdd,
        $sy,
        $sem,
        strtoupper(bin2hex(random_bytes(6)))
    );
}


    // public function getDescriptionsByStudent()
    // {
    //     $studentNumber = $this->input->get('studentNumber');
    //     $SY = $this->session->userdata('sy');

    //     $this->load->model('SettingsModel');

    //     $student = $this->SettingsModel->getStudentDetails($studentNumber); // should return Course, YearLevel

    //     if ($student) {
    //         $course = $student->Course;
    //         $yearlevel = $student->YearLevel;

    //         $descriptions = $this->SettingsModel->getFeeDescriptionsByFilter($course, $yearlevel, $SY);
    //         echo json_encode($descriptions);
    //     } else {
    //         echo json_encode([]);
    //     }
    // }


    public function getDescriptionsByStudent()
    {
        $studentNumber = $this->input->get('studentNumber');
        $SY = $this->session->userdata('sy');

        $this->load->model('SettingsModel');
        $student = $this->SettingsModel->getStudentDetails($studentNumber);

        if ($student) {
            $course = $student->Course;
            $yearlevel = $student->YearLevel;

            $descriptions = $this->SettingsModel->getFeeDescriptionsByFilter($course, $yearlevel, $SY);
            echo json_encode($descriptions);
        } else {
            echo json_encode([]);
        }
    }









    
//     public function updatePayment($id)
// {
//     $this->load->model('SettingsModel');

//     $payment = $this->SettingsModel->getPaymentById($id);
//     if (!$payment) {
//         $this->session->set_flashdata('error', 'Payment not found.');
//         redirect('Accounting/Payment');
//         return;
//     }

//     $SY            = $this->session->userdata('sy');
//     $studentNumber = $payment->StudentNumber;

//     if ($this->input->post('update')) {
//         $customOR = $this->input->post('ORNumber');
//         if ($customOR != $payment->ORNumber && $this->SettingsModel->isORNumberExists($customOR)) {
//             $this->session->set_flashdata('error', 'The O.R. number already exists. Please enter a unique O.R. number.');
//             redirect("Accounting/updatePayment/$id");
//             return;
//         }

//         $description    = $this->input->post('description');
//         $PDate          = $this->input->post('PDate');   // month anchor
//         $newAmount      = (float)$this->input->post('Amount');
//         $CheckNumber    = $this->input->post('CheckNumber');
//         $Bank           = $this->input->post('Bank');
//         $PaymentType    = $this->input->post('PaymentType');

//         $previousAmount = (float)$payment->Amount;
//         $delta          = $newAmount - $previousAmount;

//         // Start transaction
//         $this->db->trans_begin();

//         try {
//             // 1) Update payment record
//             $this->SettingsModel->updatePayment($id, $description, $PDate, $newAmount, $CheckNumber, $Bank, $PaymentType);

//             // 2) Recompute totals + update studeaccount
//             $totalPayments = $this->SettingsModel->getTotalPayments1($studentNumber, $SY);
//             $accountTotal  = $this->SettingsModel->getAcctTotal($studentNumber, $SY);
//             $discount      = $this->SettingsModel->getDiscount($studentNumber, $SY);

//             $amountTotal = $discount + $totalPayments;
//             $newBalance  = max($accountTotal - $amountTotal, 0);

//             $this->SettingsModel->updateStudentAccount($studentNumber, $totalPayments, $newBalance, $SY);

//             // 3) Adjust monthly_payment_schedule based on rules
//             $countPayments = $this->SettingsModel->countPaymentsForSY($studentNumber, $SY);

//             if ($countPayments <= 1) {
//                 // Only one payment for this SY: re-distribute evenly
//                 $remaining = max($accountTotal - $discount - $totalPayments, 0);
//                 $this->SettingsModel->redistributeMonthlyScheduleEvenly($studentNumber, $SY, $remaining);

//                 // Sync ALL candidate months for this student/SY
//                 $this->load->model('AccountingModel', 'acct');
//                 $synced = $this->acct->syncAllCandidatesForStudentSY($studentNumber, $SY);

//             } else {
//                 // Multiple payments – apply delta rules
//                 $this->load->model('AccountingModel', 'acct');

//                 if ($delta < 0) {
//                     // Decrease: add back the absolute delta to the month of PDate only
//                     $this->SettingsModel->addBackToMonth($studentNumber, $SY, $PDate, abs($delta));

//                     // Sync that specific candidate month (if exists)
//                     $monthStart = date('Y-m-01', strtotime($PDate));
//                     $synced     = $this->acct->syncCandidateFromSchedule($studentNumber, $SY, $monthStart);

//                 } elseif ($delta > 0) {
//                     // Increase: treat extra as a new payment starting from PDate forward
//                     $this->SettingsModel->applyLatestPaymentToMonthlySchedule($studentNumber, $SY, $delta, $PDate);

//                     // We don't know which months were affected; safest is to sync all candidates for this student/SY
//                     $synced = $this->acct->syncAllCandidatesForStudentSY($studentNumber, $SY);
//                 } else {
//                     $synced = 0; // no schedule change
//                 }
//             }

//             if ($this->db->trans_status() === FALSE) {
//                 throw new Exception('Transaction failed.');
//             }
//             $this->db->trans_commit();

//             $msg = 'Payment updated successfully.';
//             if (!empty($synced)) {
//                 $msg .= ' Updated ' . (int)$synced . ' overdue month(s).';
//             }
//             $this->session->set_flashdata('msg', $msg);

//         } catch (\Throwable $e) {
//             $this->db->trans_rollback();
//             $this->session->set_flashdata('error', 'Unable to update payment. ' . $e->getMessage());
//         }

//         redirect("Accounting/Payment");
//         return;
//     }

//     // Load the update form view
//     $data = [
//         'payment' => $payment,
//         'prof'    => $this->SettingsModel->semesterstude(),
//         'SY'      => $SY,
//     ];

//     $this->load->view('update_payment', $data);
// }






















public function updatePayment($id)
{
    $this->load->model('SettingsModel');

    $payment = $this->SettingsModel->getPaymentById($id);
    if (!$payment) {
        $this->session->set_flashdata('error', 'Payment not found.');
        redirect('Accounting/Payment');
        return;
    }

    $SY            = $this->session->userdata('sy');
    $studentNumber = $payment->StudentNumber;

    if ($this->input->post('update')) {
        $customOR = $this->input->post('ORNumber');
        if ($customOR != $payment->ORNumber && $this->SettingsModel->isORNumberExists($customOR)) {
            $this->session->set_flashdata('error', 'The O.R. number already exists. Please enter a unique O.R. number.');
            redirect("Accounting/updatePayment/$id");
            return;
        }

        $description    = $this->input->post('description');
        $PDate          = $this->input->post('PDate');   // kept but not used to anchor schedule
        $newAmount      = (float)$this->input->post('Amount');
        $CheckNumber    = $this->input->post('CheckNumber');
        $Bank           = $this->input->post('Bank');
        $PaymentType    = $this->input->post('PaymentType');

        $previousAmount = (float)$payment->Amount;
        $delta          = $newAmount - $previousAmount; // + add more, - reduce

        // Start transaction
        $this->db->trans_begin();

        try {
            // 1) Update payment row
            $this->SettingsModel->updatePayment($id, $description, $customOR, $PDate, $newAmount, $CheckNumber, $Bank, $PaymentType);

            // 2) Recompute totals + update studeaccount
            $totalPayments = $this->SettingsModel->getTotalPayments1($studentNumber, $SY);
            $accountTotal  = $this->SettingsModel->getAcctTotal($studentNumber, $SY);
            $discount      = $this->SettingsModel->getDiscount($studentNumber, $SY);

            $amountTotal = $discount + $totalPayments;
            $newBalance  = max($accountTotal - $amountTotal, 0);

            $this->SettingsModel->updateStudentAccount($studentNumber, $totalPayments, $newBalance, $SY);

            // 3) MONTHLY SCHEDULE — OLDEST-FIRST (no PDate anchoring)
            $synced = 0;
            $this->load->model('AccountingModel', 'acct');

            if ($delta > 0) {
                // Increased payment: consume oldest unpaid months first
                $this->SettingsModel->applyPaymentOldestFirst($studentNumber, $SY, $delta);
                if (method_exists($this->acct, 'syncAllCandidatesForStudentSY')) {
                    $synced = (int)$this->acct->syncAllCandidatesForStudentSY($studentNumber, $SY);
                }
            } elseif ($delta < 0) {
                // Decreased payment: add back to the OLDEST month
                $this->SettingsModel->addBackOldestFirst($studentNumber, $SY, abs($delta));
                if (method_exists($this->acct, 'syncAllCandidatesForStudentSY')) {
                    $synced = (int)$this->acct->syncAllCandidatesForStudentSY($studentNumber, $SY);
                }
            }

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed.');
            }
            $this->db->trans_commit();

            $msg = 'Payment updated successfully.';
            if (!empty($synced)) {
                $msg .= ' Updated ' . (int)$synced . ' overdue month(s).';
            }
            $this->session->set_flashdata('msg', $msg);

        } catch (\Throwable $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Unable to update payment. ' . $e->getMessage());
        }

        redirect("Accounting/Payment");
        return;
    }

    // Load the update form view
    $data = [
        'payment' => $payment,
        'prof'    => $this->SettingsModel->semesterstude(),
        'SY'      => $SY,
    ];

    $this->load->view('update_payment', $data);
}



    public function collectionReportByDate()
    {
        $this->load->model('SettingsModel');

        // Default to today's date if not provided
        $fromDate = $this->input->get('fromDate') ?: date('Y-m-d');
        $toDate   = $this->input->get('toDate')   ?: date('Y-m-d');

        $data['fromDate'] = $fromDate;
        $data['toDate'] = $toDate;
        $data['collection'] = $this->SettingsModel->getCollectionReportByDate($fromDate, $toDate);

        $this->load->view('collection_report_date', $data);
    }



    // public function updatePayment()
    // {
    //     $expensesid = $this->input->get('expensesid');
    //     $result['data'] = $this->SettingsModel->getexpensesbyId($expensesid);
    //     $data['data1'] = $this->SettingsModel->get_expensesCategory();

    //     // Merge both result and data1 arrays and pass them to the view
    //     $this->load->view('updateexpenses', array_merge($result, $data));

    //     if ($this->input->post('update')) {

    //         $description = $this->input->post('description');
    //         $Amount = $this->input->post('Amount');
    //         $CheckNumber = $this->input->post('CheckNumber');
    //         $Bank = $this->input->post('Bank');
    //         $PaymentType = $this->input->post('PaymentType');

    //         $this->SettingsModel->updateexpenses($expensesid, $description, $Amount, $CheckNumber, $Bank, $PaymentType);
    //         $this->session->set_flashdata('expenses', 'Record updated successfully');
    //         redirect("Accounting/expenses");
    //     }
    // }



























    public function getStudentCourse()
    {
        $studentNumber = $this->input->get('studentNumber');
        $this->load->model('SettingsModel');
        $student = $this->SettingsModel->getStudentCourse($studentNumber);

        if ($student) {
            echo json_encode(['course' => $student->course]);
        } else {
            echo json_encode(['course' => null]);
        }
    }


    // public function getStudentCourse()
    // {
    //     $studentNumber = $this->input->get('studentNumber');
    //     $SY = $this->session->userdata('sy');

    //     $student = $this->SettingsModel->getStudentDetails($studentNumber);
    //     $account = $this->SettingsModel->getAcctTotalRow($studentNumber, $SY); // new function to be added below

    //     echo json_encode([
    //         'course' => $student ? $student->Course : '',
    //         'acctTotal' => $account ? $account->AcctTotal : 0
    //     ]);
    // }




    public function printPayments()
    {
        $fromDate = $this->input->get('fromDate');
        $toDate = $this->input->get('toDate');

        $SY = $this->session->userdata('sy');
        $Sem = $this->session->userdata('semester');

        $this->load->model('SettingsModel');

        // Fetch all payment data for SY and Semester
        $data['letterhead'] = $this->Login_model->loginImage();

        $payments = $this->SettingsModel->Payment($SY, $Sem);

        // Filter payments by date
        $filteredPayments = array_filter($payments, function ($row) use ($fromDate, $toDate) {
            $paymentDate = strtotime($row->PDate);
            return $paymentDate >= strtotime($fromDate) && $paymentDate <= strtotime($toDate);
        });

        // Calculate the total amount
        $totalAmount = 0;
        foreach ($filteredPayments as $payment) {
            $totalAmount += $payment->Amount;
        }

        // Pass filtered payments, total amount, and dates to the view
        $data['data'] = $filteredPayments;
        $data['fromDate'] = $fromDate;
        $data['toDate'] = $toDate;
        $data['totalAmount'] = $totalAmount;  // Pass the total amount to the view

        // Load a view for printing
        $this->load->view('PaymentReport', $data);
    }


    public function SummaryPrint()
    {
        $fromDate = $this->input->get('fromDate');
        $toDate = $this->input->get('toDate');

        $SY = $this->session->userdata('sy');
        $Sem = $this->session->userdata('semester');

        $this->load->model('SettingsModel');

        // Fetch all payment data for SY and Semester
        $data['letterhead'] = $this->Login_model->loginImage();

        $payments = $this->SettingsModel->Payment($SY, $Sem);

        // Filter payments by date
        $filteredPayments = array_filter($payments, function ($row) use ($fromDate, $toDate) {
            $paymentDate = strtotime($row->PDate);
            return $paymentDate >= strtotime($fromDate) && $paymentDate <= strtotime($toDate);
        });

        // Group by description and sum the amounts
        $groupedPayments = [];
        foreach ($filteredPayments as $row) {
            if (!isset($groupedPayments[$row->description])) {
                $groupedPayments[$row->description] = 0;
            }
            $groupedPayments[$row->description] += $row->Amount;
        }

        // Pass grouped payments and dates to the view
        $data['groupedPayments'] = $groupedPayments;
        $data['fromDate'] = $fromDate;
        $data['toDate'] = $toDate;

        // Load a view for printing
        $this->load->view('SummaryReport', $data);
    }






























    public function services()
    {
        $SY = $this->session->userdata('sy');
        $id = $this->session->userdata('IDNumber');

        $data['data'] = $this->SettingsModel->services($SY);

        $filteredData = array_filter($data['data'], function ($row) {
            return $row->CollectionSource === 'Services';
        });

        $data['data'] = $filteredData ?: [];

        $data['prof'] = $this->SettingsModel->semesterstude();
        $data['categories'] = $this->SettingsModel->getDescriptionCategories();
        $data['data1'] = $this->SettingsModel->Paymentlist($SY);
        $data['data2'] = $this->SettingsModel->studeAcc();
        $data['description'] = $this->SettingsModel->service_descriptions();
        $data['data4'] = $this->SettingsModel->user($id);

        $lastOR = $this->SettingsModel->getLastORNumber();
        $nextORSuggestion = $this->generateNextOR1($lastOR);
        $data['newORSuggestion'] = $nextORSuggestion;

        if ($this->input->get('fromDate') && $this->input->get('toDate')) {
            $fromDate = $this->input->get('fromDate');
            $toDate = $this->input->get('toDate');

            $filteredData = array_filter($data['data'], function ($row) use ($fromDate, $toDate) {
                $paymentDate = strtotime($row->PDate);
                return $paymentDate >= strtotime($fromDate) && $paymentDate <= strtotime($toDate);
            });

            $data['data'] = $filteredData;
        }

        $summaryData = [];
        foreach ($data['data'] as $row) {
            if (!isset($summaryData[$row->description])) {
                $summaryData[$row->description] = [
                    'description' => $row->description,
                    'total_amount' => 0,
                ];
            }
            $summaryData[$row->description]['total_amount'] += $row->Amount;
        }
        $data['summary'] = array_values($summaryData);

        if ($this->input->post('save')) {
            $this->saveServicePayment($SY);
            $this->session->set_flashdata('success', 'Service payment saved successfully.');
            redirect('Accounting/services');
        }


        $this->load->view('services', $data);
    }

    private function generateNextOR1($lastOR)
    {
        $nextNumericPart = intval($lastOR) + 1; // Increment the numeric part
        return (string)$nextNumericPart; // Return the new OR number as a string
    }

    private function saveServicePayment($SY)
    {
        $studentNumber = $this->input->post('StudentNumber');
        $manualPayor   = $this->input->post('ManualPayor');
        $paymentType   = $this->input->post('PaymentType');
        $orNumber      = $this->input->post('ORNumber');
        $pDate         = $this->input->post('PDate');
        $checkNumber   = $this->input->post('CheckNumber');
        $bank          = $this->input->post('Bank');
        $cashier       = $this->session->userdata('username');
        $course        = $this->input->post('Course');

        $descriptions  = $this->input->post('description'); // array
        $amounts       = $this->input->post('amount');      // array

        if (is_array($descriptions) && is_array($amounts)) {
            foreach ($descriptions as $index => $desc) {
                $amount = isset($amounts[$index]) && is_numeric($amounts[$index]) ? floatval($amounts[$index]) : 0;

                if (trim($desc) === '' || $amount <= 0) continue; // Skip empty or zero entries

                $data = [
                    'StudentNumber'     => $studentNumber ?: '',
                    'manualPayor'       => $manualPayor ?: '',
                    'PaymentType'       => $paymentType,
                    'description'       => $desc,
                    'Amount'            => $amount,
                    'ORNumber'          => $orNumber,
                    'PDate'             => $pDate,
                    'CheckNumber'       => $checkNumber,
                    'Bank'              => $bank,
                    'Cashier'           => $cashier,
                    'CollectionSource'  => 'Services',
                    'ORStatus'          => 'Valid',
                    'Course'            => $course,
                    'SY'                => $SY,
                ];

                $this->SettingsModel->insertpaymentsaccounts($data);
            }
        }
    }







    public function manageDescriptions()
    {
        $data['descriptions'] = $this->SettingsModel->getServiceDescriptions();
        $this->load->view('services_description_manage', $data);
    }

    public function addDescription()
    {
        $description = $this->input->post('description');
        $this->SettingsModel->insertServiceDescription(['description' => $description]);
        redirect('Accounting/manageDescriptions');
    }

    public function updateDescription()
    {
        $id = $this->input->post('id');
        $description = $this->input->post('description');
        $this->SettingsModel->updateServiceDescription($id, ['description' => $description]);
        redirect('Accounting/manageDescriptions');
    }

    public function deleteDescription($id)
    {
        $this->SettingsModel->deleteServiceDescription($id);
        redirect('Accounting/manageDescriptions');
    }





























    public function VoidPayment()
    {
        // Retrieve session data
        $Sem = $this->session->userdata('semester');
        $SY = $this->session->userdata('sy');
        $id = $this->session->userdata('IDNumber');

        // Load the model
        $this->load->model('SettingsModel');

        $data['prof'] = $this->SettingsModel->get_payment();

        $role = $this->session->userdata('position');
        if ($role === 'Admin') {
            $data['data'] = $this->SettingsModel->get_all_voided();
        } else {
            $data['data'] = $this->SettingsModel->void($SY);
        }

        $data['data1'] = $this->SettingsModel->get_payment1();

        // Handle form submission
        if ($this->input->post('save')) {
            $ORStatus = $this->input->post('ORStatus');
            $ORNumber = $this->input->post('ORNumber');

            // Retrieve additional form data
            $Amount = $this->input->post('amount');
            $PaymentDate = $this->input->post('pDate');
            $Description = $this->input->post('description');
            $Cashier = $this->input->post('cashier');
            $voidDate = date('Y-m-d H:i:s');
            $Reasons = $this->input->post('Reasons');

            $payment = $this->SettingsModel->getPaymentDetailsByORNumber($ORNumber);
            if ($payment) {
                $ID = $payment->ID;
                $voidedBy = $this->session->userdata('username');

                $this->SettingsModel->updateORStatus($ORNumber, $ORStatus, [
                    'ID' => $ID,
                    'amount' => $Amount,
                    'pDate' => $PaymentDate,
                    'description' => $Description,
                    'voidDate' => $voidDate,
                    'cashier' => $Cashier,
                    'Reasons' => $Reasons,
                    'voidedBy' => $voidedBy
                ]);

                $this->session->set_flashdata('success', 'Payment voided successfully.');
            } else {
                $this->session->set_flashdata('error', 'Payment not found for the selected OR Number.');
            }

            redirect('Accounting/VoidPayment'); // stop here
        }

        // This only runs when the form is not submitted
        $this->load->view('VoidPayment', $data);
    }




    public function getPaymentDetails()
    {
        $ORNumber = $this->input->get('ORNumber');
        $this->load->model('SettingsModel');

        $paymentDetails = $this->SettingsModel->getPaymentDetailsByORNumber($ORNumber);

        echo json_encode($paymentDetails);
    }














































    public function printServices()
    {
        // Fetch semester and school year from session
        $Sem = $this->session->userdata('semester');
        $SY = $this->session->userdata('sy');

        // Load necessary model
        $this->load->model('SettingsModel');

        // Fetch the letterhead
        $data['letterhead'] = $this->Login_model->loginImage();

        // Fetch services data for the specified school year and semester
        $data['data'] = $this->SettingsModel->services($SY, $Sem);

        // Filter the data for 'Services' collection source
        $filteredData = array_filter($data['data'], function ($row) {
            return $row->CollectionSource === 'Services';
        });

        $data['data'] = $filteredData ?: [];

        // Check if date filtering is applied
        if ($this->input->get('fromDate') && $this->input->get('toDate')) {
            $fromDate = $this->input->get('fromDate');
            $toDate = $this->input->get('toDate');

            // Filter data based on date range
            $filteredData = array_filter($data['data'], function ($row) use ($fromDate, $toDate) {
                $paymentDate = strtotime($row->PDate);
                return $paymentDate >= strtotime($fromDate) && $paymentDate <= strtotime($toDate);
            });

            $data['data'] = $filteredData;
        }

        // Pass the filtered data to the print view
        $data['fromDate'] = $this->input->get('fromDate');
        $data['toDate'] = $this->input->get('toDate');
        $this->load->view('print_services', $data);
    }

    public function printSummary()
    {
        // Fetch semester and school year from session
        $Sem = $this->session->userdata('semester');
        $SY = $this->session->userdata('sy');

        // Load necessary model
        $this->load->model('SettingsModel');

        // Fetch the letterhead
        $data['letterhead'] = $this->Login_model->loginImage();

        // Fetch summary data for the specified school year and semester
        $data['summary'] = $this->SettingsModel->services($SY, $Sem);

        // Check if date filtering is applied
        if ($this->input->get('fromDate') && $this->input->get('toDate')) {
            $fromDate = $this->input->get('fromDate');
            $toDate = $this->input->get('toDate');

            // Filter the summary data based on date range
            $filteredData = array_filter($data['summary'], function ($row) use ($fromDate, $toDate) {
                // Assuming there's a date field in summary called PDate
                $summaryDate = strtotime($row->PDate);
                return $summaryDate >= strtotime($fromDate) && $summaryDate <= strtotime($toDate);
            });

            $data['summary'] = $filteredData ?: [];
        }

        // Group by description and sum the amounts
        $groupedSummary = [];
        foreach ($data['summary'] as $row) {
            if (!isset($groupedSummary[$row->description])) {
                $groupedSummary[$row->description] = 0;
            }
            $groupedSummary[$row->description] += $row->Amount;
        }

        // Prepare the data for the view
        $data['groupedSummary'] = $groupedSummary;
        $data['fromDate'] = $this->input->get('fromDate');
        $data['toDate'] = $this->input->get('toDate');

        // Load the view and pass the grouped data
        $this->load->view('print_summary', $data);
    }





    public function paymentList()
    {
        $description = $this->input->get('description');
        $collectionSource = $this->input->get('CollectionSource');

        // Pass both parameters to the model
        $data['data'] = $this->SettingsModel->getCollectionReport($description, $collectionSource);
        $data['letterhead'] = $this->Login_model->loginImage(); // Ensure this data is assigned to $data

        // Load the view with the filtered data
        $this->load->view('paymentList', $data);
    }




    public function paymentAdd()
    {
        $Sem = $this->session->userdata('semester');
        $SY = $this->session->userdata('sy');
        $data['data'] = $this->SettingsModel->Payment($SY, $Sem);
    }


    // Last work 09-04-2024


    // public function CourseFees()
    // {
    //     // Get the logged-in SY from session data
    //     $SY = $this->session->userdata('sy');

    //     // Fetch all YearLevels for dropdown filter
    //     $data['year_levels'] = $this->SettingsModel->getYearLevels();

    //     // Initialize variables
    //     $data['selected_year'] = 'All';
    //     $data['data'] = [];
    //     $data['total_amount'] = 0;

    //     // Check if a YearLevel is selected
    //     if ($this->input->post('yearLevelFilter')) {
    //         $yearLevel = $this->input->post('yearLevelFilter');

    //         // Get fees filtered by selected YearLevel and SY
    //         $data['data'] = $this->SettingsModel->getFeesByYearLevelAndSY($yearLevel, $SY);
    //         $data['selected_year'] = $yearLevel;

    //         // Get total fees for the selected year level
    //         $data['total_amount'] = $this->SettingsModel->getTotalFeesByYearLevelAndSY($yearLevel, $SY);
    //     } else {
    //         // If no specific YearLevel is selected, get all fees grouped by YearLevel for the SY
    //         $data['year_level_totals'] = $this->SettingsModel->getTotalFeesGroupedByYearLevel($SY);
    //     }

    //     // Load the view with the data
    //     $this->load->view('CourseFees', $data);

    //     // Handle form submission to save fees
    //     if ($this->input->post('save')) {
    //         $data = array(
    //             'YearLevel' => $this->input->post('YearLevel'),
    //             'Course' => $this->input->post('Course'),
    //             'Description' => $this->input->post('Description'),
    //             'Amount' => $this->input->post('Amount'),
    //             'SY' => $SY, // Save the fee for the logged-in SY
    //         );

    //         $this->SettingsModel->insertFees($data);
    //         redirect('Accounting/CourseFees');
    //     }
    // }

    public function CourseFees()
    {
        $SY = $this->session->userdata('sy');
        $data['year_levels'] = $this->SettingsModel->getYearLevels();
        $data['course'] = $this->SettingsModel->course();

        // Initialize variables
        $data['total_amount'] = 0;
        $data['selected_year'] = 'All';
        $data['selected_year_total'] = 0; // Store total for selected year level

        // If a YearLevel is selected, filter fees by YearLevel and SY
        if ($this->input->post('yearLevelFilter')) {
            $yearLevel = $this->input->post('yearLevelFilter');
            $data['data'] = $this->SettingsModel->getFeesByYearLevelAndSY($yearLevel, $SY);
            $data['selected_year'] = $yearLevel;

            // Calculate total for the selected year level
            $data['selected_year_total'] = $this->SettingsModel->getTotalFeesByYearLevelAndSY($yearLevel, $SY);
        } else {
            // If no YearLevel selected, show all fees for the logged-in SY
            $data['year_level_totals'] = $this->SettingsModel->getTotalFeesGroupedByYearLevel($SY);
            $data['data'] = $this->SettingsModel->getCourseFeesBySY($SY);

            // Get the total amount for the logged-in SY
            $data['total_amount'] = $this->SettingsModel->getTotalFeesBySY($SY);
            $data['available_sy'] = $this->SettingsModel->getAvailableSY(); // <-- Add this

        }

        // Load the view with data
        $this->load->view('CourseFees', $data);

        // Handle form submission for saving fees
        if ($this->input->post('save')) {
            $data = array(
                'YearLevel' => $this->input->post('YearLevel'),
                'Course' => $this->input->post('Course'),
                'Description' => $this->input->post('Description'),
                'Amount' => $this->input->post('Amount'),
                'SY' => $SY,
            );
            $this->SettingsModel->insertfees($data);
            redirect('Accounting/CourseFees');
        }
    }


    // public function copyFeesBySY()
    // {
    //     $from_sy = $this->input->post('from_sy');
    //     $to_sy = $this->input->post('to_sy');

    //     if ($from_sy && $to_sy && $from_sy !== $to_sy) {
    //         $this->db->query("
    //             INSERT INTO fees (Description, Amount, Course, Major, YearLevel, SY)
    //             SELECT Description, Amount, Course, Major, YearLevel, ?
    //             FROM fees
    //             WHERE SY = ?
    //         ", [$to_sy, $from_sy]);

    //         $this->session->set_flashdata('success', "Fees successfully copied from $from_sy to $to_sy.");
    //     } else {
    //         $this->session->set_flashdata('error', "Invalid School Year selection.");
    //     }

    //     redirect('Accounting/CourseFees');
    // }



    public function copyFeesBySY()
    {
        $from_sy = $this->input->post('from_sy');
        $to_sy = $this->input->post('to_sy');

        if ($from_sy && $to_sy && $from_sy !== $to_sy) {
            $sql = "
            INSERT INTO fees (Description, Amount, Course, Major, YearLevel, SY)
            SELECT f.Description, f.Amount, f.Course, f.Major, f.YearLevel, ?
            FROM fees f
            WHERE f.SY = ?
            AND NOT EXISTS (
                SELECT 1 FROM fees f2
                WHERE f2.SY = ?
                AND f2.Description = f.Description
                AND f2.Amount = f.Amount
                AND f2.Course = f.Course
                AND IFNULL(f2.Major, '') = IFNULL(f.Major, '')
                AND f2.YearLevel = f.YearLevel
            )
        ";

            $this->db->query($sql, [$to_sy, $from_sy, $to_sy]);
            $this->session->set_flashdata('success', "Fees copied from $from_sy to $to_sy, excluding existing entries.");
        } else {
            $this->session->set_flashdata('error', "Invalid School Year selection.");
        }

        redirect('Accounting/CourseFees');
    }






    public function getMajorsByCourse()
    {
        $CourseDescription = $this->input->post('CourseDescription');
        if (!$CourseDescription) {
            echo json_encode([]); // Return empty array if no input
            return;
        }

        $majors = $this->SettingsModel->getMajorsByCourse($CourseDescription);
        echo json_encode($majors); // Send the result back as JSON
    }




    public function updateCourseFees()
    {
        $feesid = $this->input->get('feesid');
        $result['data'] = $this->SettingsModel->updateCourseFeesbyId($feesid);

        // Merge both result and data1 arrays and pass them to the view
        $this->load->view('updateCourseFees', $result);


        if ($this->input->post('update')) {

            $YearLevel = $this->input->post('YearLevel');
            $Course = $this->input->post('Course');
            $Description = $this->input->post('Description');
            $Amount = $this->input->post('Amount');

            $this->SettingsModel->updateFees($feesid, $YearLevel, $Course, $Description, $Amount);
            $this->session->set_flashdata('expenses', 'Record updated successfully');
            redirect("Accounting/CourseFees");
        }
    }



    public function Deletefees()
    {
        $feesid = $this->input->get('feesid');
        if ($feesid) {
            $this->SettingsModel->Deletefees($feesid);
            $this->session->set_flashdata('expenses', 'Record deleted successfully');
        } else {
            $this->session->set_flashdata('expenses', 'Error deleting record');
        }

        redirect("Accounting/CourseFees");
    }


    public function monthly_pay_duration()
    {
        $result['data'] = $this->SettingsModel->get_grouped_durations();
        $this->load->view('monthly_pay_duration', $result);
    }

    public function save_monthly_duration()
    {
        $existing = $this->db->count_all('monthly_payment_schedule_set');
        if ($existing > 0) {
            $this->session->set_flashdata('error', 'Monthly duration has already been set.');
            redirect('Accounting/monthly_pay_duration');
            return;
        }

        $months = $this->input->post('months');

        if (!empty($months)) {
            $batch_id = uniqid('batch_');
            foreach ($months as $month) {
                // Convert "Month YYYY" (e.g., "June 2025") to "2025-06-01"
                $parts = explode(' ', $month); // ['June', '2025']
                if (count($parts) == 2) {
                    $monthName = $parts[0];
                    $year = $parts[1];
                    $monthNum = date('m', strtotime($monthName));
                    $durationOrder = $year . '-' . $monthNum . '-01'; // YYYY-MM-01

                    $this->db->insert('monthly_payment_schedule_set', [
                        'durationDate' => $month,
                        'durationOrder' => $durationOrder,
                        'batch_id' => $batch_id
                    ]);
                }
            }

            $this->session->set_flashdata('success', 'Monthly duration saved.');
        } else {
            $this->session->set_flashdata('error', 'No months submitted.');
        }

        redirect('Accounting/monthly_pay_duration');
    }



    public function DeleteBatch()
    {
        $batch_id = $this->input->get('batch_id');
        $this->db->where('batch_id', $batch_id)->delete('monthly_payment_schedule_set');
        $this->session->set_flashdata('success', 'Batch deleted.');
        redirect('Accounting/monthly_pay_duration');
    }


    // Helper
    private function get_months_between($from, $to)
    {
        $start = DateTime::createFromFormat('!F', $from);
        $end = DateTime::createFromFormat('!F', $to);
        $months = [];

        while ($start <= $end) {
            $months[] = $start->format('F');
            $start->modify('+1 month');
        }

        return $months;
    }











    public function recalcAccount()
{
    if (!$this->input->post()) { show_404(); }

    $student = trim($this->input->post('studentNumber', TRUE));
    $sy      = trim($this->input->post('sy', TRUE));

    if ($student === '' || $sy === '') { show_404(); }

    $this->load->database();
    $this->load->model('AccountingModel');   // new model below
    $this->db->trans_begin();

    try {
        // 1) Read an anchor row to get Course/YearLevel/Sem/Section/Status
        $anchor = $this->AccountingModel->getAnchorStudeAccountRow($student, $sy);

        if (!$anchor) {
            // If studeaccount has no row yet, we still need course/yearlevel to seed rows.
            // Try to infer from semesterstude first; fallback to stedeprofile minimal.
            $anchor = $this->AccountingModel->inferAnchorRow($student, $sy);
            if (!$anchor) {
                throw new Exception('Cannot infer Course/YearLevel for this student/SY.');
            }
        }

        $course     = $anchor->Course;
        $yearLevel  = $anchor->YearLevel;
        $semester   = $anchor->Sem ?: ($this->session->userdata('semester') ?: '');
        $section    = $anchor->Section ?: '';
        $status     = $anchor->Status ?: 'Enrolled';
        $settingsID = (int)($anchor->settingsID ?? 1);

        // 2) Expected fees from `fees` table (e.g., Tuition + Miscellaneous)
        $expectedFees = $this->AccountingModel->getFeesByCYLSY($course, $yearLevel, $sy);

        // 3) Upsert missing fee rows into studeaccount
        $inserted = 0; $updated = 0; $skipped = 0;
        foreach ($expectedFees as $f) {
            $exists = $this->AccountingModel->findStudeAcctFeeRow($student, $sy, $f->Description);
            $row = [
                'StudentNumber' => $student,
                'Course'        => $course,
                'YearLevel'     => $yearLevel,
                'Status'        => $status,
                'OldAccount'    => 0,
                'FeesDesc'      => $f->Description,    // e.g., Tuition, Miscellaneous
                'FeesAmount'    => (float)$f->Amount,
                'Sem'           => $semester,
                'SY'            => $sy,
                'Section'       => $section,
                'settingsID'    => $settingsID,
            ];
            if ($exists) {
                // keep per-row amount in sync with master fees
                $this->db->where('AccountID', $exists->AccountID)->update('studeaccount', [
                    'FeesAmount' => $row['FeesAmount'],
                    'Course'     => $row['Course'],
                    'YearLevel'  => $row['YearLevel'],
                    'Sem'        => $row['Sem'],
                    'Section'    => $row['Section'],
                    'Status'     => $row['Status'],
                ]);
                $updated++;
            } else {
                $this->db->insert('studeaccount', $row);
                $inserted++;
            }
        }

        // 4) Recompute totals
        $baseTotal       = $this->AccountingModel->sumBaseFees($student, $sy);                 // studeaccount sum(FeesAmount)
        $additionalTotal = $this->AccountingModel->sumAdditional($student, $sy);               // studeadditional
        $discountTotal   = $this->AccountingModel->sumDiscounts($student, $sy);                // studediscount
        $paymentsTotal   = $this->AccountingModel->sumPayments($student, $sy);                 // paymentsaccounts (non-void)
        $totalFees       = $baseTotal + $additionalTotal;
        $acctTotal       = $totalFees - $discountTotal;
        $currentBalance  = $acctTotal - $paymentsTotal;

        // 5) Push aggregates into ALL studeaccount rows for the student/SY
        $this->db->where('StudentNumber', $student)
                 ->where('SY', $sy)
                 ->update('studeaccount', [
                     'addFees'       => $additionalTotal,
                     'TotalFees'     => $totalFees,
                     'Discount'      => $discountTotal,
                     'AcctTotal'     => $acctTotal,
                     'TotalPayments' => $paymentsTotal,
                     'CurrentBalance'=> $currentBalance,
                 ]);

        if ($this->db->trans_status() === FALSE) {
            throw new Exception('DB error while saving.');
        }

        $this->db->trans_commit();
        $this->session->set_flashdata('success', sprintf(
            'Recalculated. Base: %s | Addl: %s | Discount: %s | Payments: %s | Balance: %s. Inserted: %d, Updated: %d.',
            number_format($baseTotal, 2), number_format($additionalTotal, 2),
            number_format($discountTotal, 2), number_format($paymentsTotal, 2),
            number_format($currentBalance, 2), $inserted, $updated
        ));
    } catch (Exception $e) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('danger', 'Recalculation failed: '.$e->getMessage());
    }

    // redirect back to the account view
    redirect('Page/state_Account_Accounting?id='.$student);
}










}
