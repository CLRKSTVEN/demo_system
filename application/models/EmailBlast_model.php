<?php
class EmailBlast_model extends CI_Model
{
    public function getSchoolSettings()
    {
        $query = $this->db->get('srms_settings_o');
        if ($query->num_rows() > 0) {
            return $query->row(); // returns SchoolName and letterhead_web
        }
        return (object)[
            'SchoolName' => 'School Records Management System',
            'letterhead_web' => ''
        ];
    }

    public function getStudentByNumber($studentNumber)
    {
        return $this->db
            ->select('FirstName, LastName, EmailAddress, p_email')
            ->get_where('studeprofile', ['StudentNumber' => $studentNumber])
            ->row();
    }

    public function markEmailAsSeen($logId)
    {
        return $this->db->update('email_logs', ['seen' => 'seen'], ['id' => $logId]);
    }


    public function getSenderName($username)
    {
        $user = $this->db
            ->select('fName, lName')
            ->get_where('o_users', ['username' => $username])
            ->row();
        return $user ? $user->fName . ' ' . $user->lName : 'Unknown';
    }

    public function logEmail($data)
    {
        return $this->db->insert('email_logs', $data);
    }

    public function getUnreadEmails($studentNumber)
    {
        return $this->db
            ->where('StudentNumber', $studentNumber)
            ->where('seen', 'unseen')
            ->order_by('sent_at', 'DESC')
            ->get('email_logs')
            ->result();
    }

    public function countUnreadMessages($studentNumber)
    {
        return $this->db
            ->where('StudentNumber', $studentNumber)
            ->where('seen', 'unseen')
            ->count_all_results('email_logs');
    }

    // Get all messages for the student
    public function getAllMessages($studentNumber)
    {
        return $this->db
            ->where('StudentNumber', $studentNumber)
            ->order_by('sent_at', 'DESC')
            ->get('email_logs')
            ->result();
    }

    // Get single message by ID
    public function getMessageById($id, $studentNumber)
    {
        return $this->db
            ->where('id', $id)
            ->where('StudentNumber', $studentNumber)
            ->get('email_logs')
            ->row();
    }

    // Mark as seen
    public function markMessageAsSeen($id)
    {
        return $this->db
            ->update('email_logs', ['seen' => 'seen'], ['id' => $id]);
    }
}
