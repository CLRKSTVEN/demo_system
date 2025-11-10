<?php
class SubjectDeportmentModel extends CI_Model
{
    private $table = 'subject_deportment'; // adjust if your table name differs

    public function get_all_deportments()
    {
        $this->db->from($this->table);
        $this->db->order_by('yearLevel', 'ASC');
        $this->db->order_by('subjectCode', 'ASC');
        return $this->db->get()->result();
    }

    public function insert_deportment($data)
    {
        // $data expected: subjectCode, description, yearLevel
        return $this->db->insert($this->table, $data);
    }

    public function delete_deportment($id)
    {
        $this->db->where('id', (int)$id);
        return $this->db->delete($this->table);
    }

    public function exists($subjectCode, $yearLevel)
    {
        return $this->db->from($this->table)
                        ->where('subjectCode', $subjectCode)
                        ->where('yearLevel', $yearLevel)
                        ->count_all_results() > 0;
    }


      public function get_codes_by_yearlevel($yearLevel)
    {
        if (!$yearLevel) return [];
        $rows = $this->db->select('subjectCode')
                         ->from($this->table)
                         ->where('yearLevel', $yearLevel)
                         ->get()->result();
        return array_values(array_unique(array_map(function($r){ return (string)$r->subjectCode; }, $rows)));
    }
}
