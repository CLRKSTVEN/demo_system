<?php
class SubjectModel extends CI_Model
{
    public function get_subjects_ordered()
    {
        $this->db->from('subjects');
        $this->db->order_by('YearLevel', 'ASC');
        $this->db->order_by('Semester', 'ASC');
        $this->db->order_by('Course', 'ASC');
        $this->db->order_by('displayOrder', 'ASC');
        return $this->db->get()->result();
    }

    public function updateSubjectOrder($id, $order, $year, $sem, $strand)
    {
        $this->db->where('id', $id);
        $this->db->where('YearLevel', $year);
        $this->db->where('Semester', $sem);
        $this->db->where('Course', $strand);
        $this->db->update('subjects', ['displayOrder' => $order]);
    }

    public function course()
    {
        return $this->db->get('course_table')->result();
    }

    public function get_strands()
    {
        return $this->db->select('strand')->distinct()
                        ->from('subjects')
                        ->where("strand != ''")
                        ->get()->result();
    }

    // Use each concrete subject row in dropdown (no "distinct" by code)
    public function get_all_subjects()
    {
        $this->db->select('id, subjectCode, description, yearLevel');
        $this->db->from('subjects');
        $this->db->order_by('yearLevel', 'ASC');
        $this->db->order_by('subjectCode', 'ASC');
        $this->db->order_by('id', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('subjects', ['id' => (int)$id])->row();
    }

    // Keeping your existing method if needed elsewhere
    public function get_all_yearLevel()
    {
        $this->db->distinct();
        $this->db->select('yearLevel');
        $this->db->order_by('yearLevel', 'ASC');
        return $this->db->get('subjects')->result();
    }
}
