<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model
{
    public function getAllUsersExcept($user_id)
    {
        return $this->db->where('username !=', $user_id)->get('o_users')->result();
    }
}
