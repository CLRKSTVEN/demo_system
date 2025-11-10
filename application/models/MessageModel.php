<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class MessageModel extends CI_Model
{
    public function getInbox($user_id)
    {
        return $this->db->where('receiver_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->get('messages')
            ->result();
    }

    public function sendMessage($data)
    {
        $this->db->insert('messages', [
            'sender_id' => $this->session->userdata('username'),
            'receiver_id' => $data['receiver_id'],
            'subject' => $data['subject'],
            'body' => $data['body'],
        ]);
    }

    public function getMessage($id)
    {
        return $this->db->where('id', $id)->get('messages')->row();
    }

    public function markAsRead($id)
    {
        $this->db->where('id', $id)->update('messages', ['is_read' => 1]);
    }
}
