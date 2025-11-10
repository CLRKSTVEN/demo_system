<?php
class ProficiencyModel extends CI_Model
{
    public function getStudentsBySection($sy, $section)
    {
        return $this->db->select('sp.StudentNumber, sp.FirstName, sp.LastName')
            ->from('semesterstude ss')
            ->join('studeprofile sp', 'ss.StudentNumber = sp.StudentNumber')
            ->where('ss.SY', $sy)
            ->where('ss.Section', $section)
            ->get()->result();
    }

    public function getSubjectsByStudent($studentNumber, $sy)
    {
        return $this->db->where('StudentNumber', $studentNumber)
            ->where('SY', $sy)
            ->get('registration')->result();
    }

    public function saveProficiency($data)
    {
        return $this->db->insert('proficiency_tracker', $data);
    }

    public function getProficiencyRecords($studentNumber, $sy)
    {
        return $this->db->where('StudentNumber', $studentNumber)
            ->where('SY', $sy)
            ->get('proficiency_tracker')->result();
    }
}
