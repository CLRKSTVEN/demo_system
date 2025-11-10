<?php
class BACModel extends CI_Model
{
    public function insertPR($data)
    {
        return $this->db->insert('proc_pr', $data);
    }

    public function loginImage()
    {
        $query = $this->db->get('srms_settings_o', 1); // Limit 1
        return $query->result();
    }

    function activityList($user_id)
    {
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('actID', 'DESC');
        $query = $this->db->get('ls_activities');
        return $query->result();
    }

    function activityListAll()
    {
        $this->db->select('*');
        $this->db->order_by('actID', 'DESC');
        $query = $this->db->get('ls_activities');
        return $query->result();
    }

    //Get School Information
    function getSchoolInfo()
    {
        $query = $this->db->query("select * from srms_settings_o limit 1");
        return $query->result();
    }

    function user_details($user_id)
    {
        $this->db->select('*');
        $this->db->where('username', $user_id);
        $query = $this->db->get('o_users');
        return $query->result();
    }

    public function getActById($actID)
    {
        $this->db->where('actID', $actID);
        $query = $this->db->get('ls_activities');
        return $query->result();
    }

    public function getbacHistory($actID)
    {
        $this->db->select('*'); // You can specify columns if needed
        $this->db->from('ls_activities');
        $this->db->join('bac_tracking', 'bac_tracking.actID = ls_activities.actID', 'left'); // Use 'left' join or 'inner' depending on your needs
        $this->db->where('ls_activities.actID', $actID);
        $query = $this->db->get();
        return $query->result();
    }

    function activity_port()
    {
        $this->db->select('*');
        $this->db->from('ls_activities');
        $this->db->where('actStatus', 'For Action'); // Add condition to filter by actStatus
        $query = $this->db->get();
        return $query->result();
    }


    public function updateActivityStatus($actID, $status)
    {
        $this->db->where('actID', $actID);
        return $this->db->update('ls_activities', ['actStatus' => $status]);
    }




    function PRList($actID, $user_id)
    {
        $this->db->select('*');
        $this->db->from('ls_activities');
        $this->db->join('proc_pr', 'ls_activities.actID = proc_pr.actID', 'left');
        $this->db->where('ls_activities.actID', $actID);
        $this->db->where('ls_activities.user_id', $user_id);
        $this->db->order_by('proc_pr.lot', 'ASC'); // Order by 'lot' instead of grouping
        $this->db->order_by('ls_activities.actID', 'DESC');
        $this->db->group_by('proc_pr.item_description');

        $query = $this->db->get();
        return $query->result();
    }

    function PRListAll($actID)
    {
        $this->db->select('*');
        $this->db->from('ls_activities');
        $this->db->join('proc_pr', 'ls_activities.actID = proc_pr.actID', 'left');
        $this->db->where('ls_activities.actID', $actID);
        $this->db->order_by('proc_pr.lot', 'ASC'); // Order by 'lot' instead of grouping
        $this->db->order_by('ls_activities.actID', 'DESC');
        $this->db->group_by('proc_pr.item_description');

        $query = $this->db->get();
        return $query->result();
    }

    function PRListAllreq($actID, $lot = null)
    {
        $this->db->select('*');
        $this->db->from('ls_activities');
        $this->db->join('proc_pr', 'ls_activities.actID = proc_pr.actID', 'left');
        $this->db->join('proc_rfq', 'ls_activities.actID = proc_rfq.actID', 'left');
        $this->db->order_by('proc_rfq.rfq_lot_no', 'ASC');
        $this->db->order_by('proc_pr.lot', 'ASC');
        $this->db->order_by('ls_activities.actID', 'DESC');
        $this->db->group_by('proc_pr.item_description');

        $this->db->where('ls_activities.actID', $actID);

        // Add condition for lot only if it's provided
        if (!empty($lot) && $lot !== 'N/A') {
            $this->db->where('proc_pr.lot', $lot);
        }

        $query = $this->db->get();
        return $query->result();
    }






    public function savePrintData($data)
    {
        // Try to insert the data
        $this->db->insert('proc_rfq', $data);

        // Check if the insert was successful
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            // Log error details for debugging
            log_message('error', 'Insert failed: ' . $this->db->last_query());  // Log the last executed query
            return false;
        }
    }


    public function getPRbyID($prID)
    {
        $query = $this->db->query("SELECT * FROM  proc_pr WHERE prID = '" . $prID . "'");
        return $query->result();
    }


    public function updatePR($prID, $data)
    {
        $this->db->where('prID', $prID);
        $this->db->update('proc_pr', $data); // Replace with your actual table name
    }



    public function deletePR($prID)
    {
        $this->db->where('prID', $prID);
        return $this->db->delete('proc_pr');  // Returns TRUE on success, FALSE on failure
    }

    public function getPRbyID1($prID)
    {
        return $this->db->get_where('proc_pr', ['prID' => $prID])->row();
    }

    // Profile

    public function getuserById($IDNumber)
    {
        $this->db->where('IDNumber', $IDNumber);
        $query = $this->db->get('o_users');
        return $query->result();
    }

    public function updateUser($IDNumber, $userData)
    {
        // Set the condition to identify the user
        $this->db->where('IDNumber', $IDNumber);

        // Perform the update
        if ($this->db->update('o_users', $userData)) {
            return $this->db->affected_rows();
        } else {
            // Log error message
            log_message('error', 'Failed to update user: ' . $this->db->last_query());
            return false; // Update failed
        }
    }

    function getUsers()
    {
        $this->db->select('*');
        $query = $this->db->get('o_users');
        return $query->result();
    }


    function getActivity($actID)
    {
        // Select the required fields for a specific activity by actID
        $this->db->select('fundSource, prNo, act_title, section');
        $this->db->where('actID', $actID); // Filter by actID
        $query = $this->db->get('ls_activities');

        return $query->result(); // Return the activity objects
    }

    public function updateAttachment($prID, $data)
    {
        $this->db->where('prID', $prID);
        return $this->db->update('proc_pr', $data);
    }


    function proc_rfq($actID)
    {
        // Select the required fields for a specific activity by actID
        $this->db->select('*');
        $this->db->where('actID', $actID); // Filter by actID
        $query = $this->db->get('proc_rfq');

        return $query->result(); // Return the activity objects
    }

    public function insertTracking($trackingData)
    {
        $this->db->insert('bac_tracking', $trackingData);
    }
}
