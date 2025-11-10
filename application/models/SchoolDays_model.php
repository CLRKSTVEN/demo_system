<?php
class SchoolDays_model extends CI_Model
{
    private $table = 'days_of_school';

   public function getAll()
{
    $this->db->order_by('year ASC', false);
    $this->db->order_by('FIELD(month, "June","July","August","September","October","November","December","January","February","March")', '', false);
    return $this->db->get($this->table)->result();
}


    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
