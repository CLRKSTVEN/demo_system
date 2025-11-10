<?php
class BAC extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('BACModel');
        $this->load->model('SettingsModel');

        // Optional: Block access if not logged in
        if (!$this->session->userdata('username')) {
            redirect('login'); // change to your login page
        }
    }

    public function updateActivity()
    {
        $actID = $this->input->get('actID');
        $data['activities'] = $this->SettingsModel->getActById($actID);

        $this->load->view('activity_update', $data);

        if ($this->input->post('submit')) {
            $updateData = array(
                'act_title' => $this->input->post('act_title'),
                'act_date' => $this->input->post('act_date'),
                'prog_owner' => $this->input->post('prog_owner'),
                'prog_owner_position' => $this->input->post('prog_owner_position'),
                'section' => $this->input->post('section'),
                'fundSource' => $this->input->post('fundSource'),
                'prNo' => $this->input->post('prNo'),
                'actID' => $actID,
            );

            $this->db->where('actID', $actID);
            $this->db->update('ls_activities', $updateData);

            $this->session->set_flashdata('message', 'Updated successfully');
            redirect("BAC/activity_list");
        }
    }

    public function deletePR($prID)
    {
        $actID = $this->input->get('actID');
        $this->BACModel->deletePR($prID);
        redirect("BAC/PR?actID={$actID}");
    }

    public function updatePR()
    {
        $formData = array(
            'lot' => $this->input->post('lot'),
            'item_description' => $this->input->post('item_description'),
            'unit' => $this->input->post('unit'),
            'qty' => $this->input->post('qty'),
            'est_cost' => $this->input->post('est_cost')
        );
        $prID = $this->input->post('prID');
        $actID = $this->input->post('actID');

        $this->BACModel->updatePR($prID, $formData);
        redirect("BAC/PR?actID={$actID}");
    }


    public function PR()
    {
        $user_id = $this->session->userdata('username');
        $actID = $this->input->get('actID');
        $act_title = $this->input->get('act_title');
        $user_level = $this->session->userdata('level');

        if ($this->input->post('save')) {
            $formData = array(
                'lot' => $this->input->post('lot'),
                'item_description' => $this->input->post('item_description'),
                'unit' => $this->input->post('unit'),
                'qty' => $this->input->post('qty'),
                'est_cost' => $this->input->post('est_cost'),
                'fundCluster' => $this->input->post('fundCluster'),
                'prNo' => $this->input->post('prNo'),
                'actID' => $this->input->post('actID'),
                'purpose' => $this->input->post('act_title'),
                'proc_date' => date('Y-m-d'),
                'requested_by' => $user_id,
                'proc_section' => $this->input->post('section'),
            );

            if (!empty($formData['actID'])) {
                $this->BACModel->insertPR($formData);

                date_default_timezone_set('Asia/Manila');
                $bac_tracking_data = array(
                    'actID' => $formData['actID'],
                    'proc_date' => date('Y-m-d'),
                    'proc_time' => date('H:i:s'),
                    'proc_by' => $user_id,
                    'act_status' => 'PR Encoded',
                );
                $this->BACModel->insertTracking($bac_tracking_data);

                redirect("BAC/PR?actID={$formData['actID']}");
            } else {
                show_error('Invalid activity ID.');
            }
        }

        // Only runs if not redirected
        $data['activities'] = $this->BACModel->getActById($actID);
        $data['act'] = $this->BACModel->getActivity($actID);

        if ($user_level === 'BAC Secretariat') {
            $data['pr'] = $this->BACModel->PRListAll($actID);
        } else {
            $data['pr'] = $this->BACModel->PRList($actID, $user_id);
        }

        $data['actID'] = $actID;
        $data['act_title'] = $act_title;

        $this->load->view('pr_add', $data);
    }




    public function deleteActivity($actID)
    {
        try {
            $this->db->where('actID', $actID);
            if ($this->db->delete('ls_activities')) {
                $this->session->set_flashdata('message', 'Activity deleted successfully');
            } else {
                $this->session->set_flashdata('message', 'Failed to delete activity');
            }
        } catch (Exception $e) {
            // Log the error message for debugging
            log_message('message', 'Delete Activity Error: ' . $e->getMessage());

            // Set a user-friendly error message
            $this->session->set_flashdata('message', 'Unable to delete this activity because it is linked to other records.');
        }

        redirect('BAC/activity_list');
    }

    public function addActivity()
    {
        // Set timezone to Manila
        date_default_timezone_set('Asia/Manila');
        $current_year = date('Y');
        $current_month = date('m'); // Numeric month (e.g., 03 for March)

        // Fetch the latest PR number from the database
        $latest_pr = $this->db->select('prNo')
            ->from('ls_activities')
            ->where('prNo LIKE', "$current_year-$current_month-%") // Get only PRs from the current year & month
            ->order_by('actID', 'DESC') // Sort by latest
            ->limit(1)
            ->get()
            ->row();

        // Default new PR number
        $new_pr_no = '';

        if ($latest_pr && !empty($latest_pr->prNo)) {
            // Extract the last 4-digit number
            if (preg_match('/(\d{4})$/', $latest_pr->prNo, $matches)) {
                $last_number = intval($matches[1]) + 1; // Increment the number
                $new_number = str_pad($last_number, 4, '0', STR_PAD_LEFT); // Ensure 4-digit format
            } else {
                $new_number = '0001'; // Start fresh if format is unexpected
            }
        } else {
            $new_number = '0001'; // If no previous PR exists for this month, start from 0001
        }

        // Construct new PR number
        $new_pr_no = "$current_year-$current_month-$new_number";

        // Load the view with the generated PR number
        $this->load->view('activity_add', ['prNo' => $new_pr_no]);

        if ($this->input->post('submit')) {
            // Get form input values
            $act_title = $this->input->post('act_title');
            $act_date = $this->input->post('act_date');
            $prog_owner = $this->input->post('prog_owner');
            $prog_owner_position = $this->input->post('prog_owner_position');
            $section = $this->input->post('section');
            $fundSource = $this->input->post('fundSource');
            $actStatus = $this->input->post('actStatus');
            $user_id = $this->session->userdata('username');

            // Check if user provided a PR number
            $user_input_pr_no = $this->input->post('prNo');
            if (empty($user_input_pr_no)) {
                $user_input_pr_no = $new_pr_no; // Use generated PR number if none provided
            } else {
                $user_input_pr_no = $this->db->escape_str($user_input_pr_no); // Sanitize input
            }

            // Prepare data for insertion into ls_activities
            $data = array(
                'act_title' => $act_title,
                'act_description' => '',
                'act_date' => $act_date,
                'prog_owner' => $prog_owner,
                'prog_owner_position' => $prog_owner_position,
                'section' => $section,
                'fundSource' => $fundSource,
                'actStatus' => $actStatus,
                'prNo' => $user_input_pr_no,
                'user_id' => $user_id,
                'settingsID' => '1'
            );

            // Insert the activity into ls_activities
            if ($this->db->insert('ls_activities', $data)) {
                // Get the actID of the newly inserted activity
                $actID = $this->db->insert_id();

                // Get the current date and time
                $current_date = date('Y-m-d'); // Current date
                $current_time = date('H:i:s'); // Current time

                // Prepare data for insertion into bac_tracking
                $bac_tracking_data = array(
                    'actID' => $actID,
                    'proc_date' => $current_date,
                    'proc_time' => $current_time,
                    'proc_by' => $user_id,
                    'act_status' => 'Activity Encoded',
                );

                // Insert the tracking data into bac_tracking
                if ($this->db->insert('bac_tracking', $bac_tracking_data)) {
                    $this->session->set_flashdata('success', 'Activity added and tracked successfully!');
                    redirect('BAC/activity_list');
                } else {
                    $this->session->set_flashdata('error', 'There was an error adding the activity tracking data. Please try again.');
                    redirect('BAC/activity_list');
                }
            } else {
                $this->session->set_flashdata('error', 'There was an error adding the activity. Please try again.');
                redirect('BAC/activity_list');
            }
        }
    }

    public function printPR()
    {
        $user_id = $this->session->userdata('username');
        $actID = $this->input->get('actID');
        $user_level = $this->session->userdata('level');
        $data['activities'] = $this->BACModel->getActById($actID);
        $data['letterhead'] = $this->BACModel->getSchoolInfo();
        // $data['user'] = $this->BACModel->getJoinedData();
        $data['settings'] = $this->BACModel->loginImage();
        $data['act'] = $this->BACModel->getActivity($actID);
        if ($user_level === 'BAC') {
            $data['pr'] = $this->BACModel->PRListAll($actID);
        } else {
            $data['pr'] = $this->BACModel->PRList($actID, $user_id);
        }

        $data['actID'] = $actID;

        $this->load->view('pr_print', $data);
    }

    function activity_list()
    {
        $user_id = $this->session->userdata('username');
        $level = $this->session->userdata('level');

        if ($level === 'Teacher') {
            $result['data'] = $this->BACModel->activityList($user_id);
        } else {
            $result['data'] = $this->BACModel->activityListAll();
        }

        $this->load->view('activity_list', $result);
    }
}
