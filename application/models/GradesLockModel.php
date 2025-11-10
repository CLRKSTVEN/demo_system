<?php defined('BASEPATH') OR exit('No direct script access allowed');

class GradesLockModel extends CI_Model
{
    private function scopeWhere($sy, $code, $section, $yearLevel) {
        $this->db->where([
            'SY'         => $sy,
            'SubjectCode'=> $code,
            'Section'    => $section,
            'YearLevel'  => $yearLevel,
        ]);
    }

    public function get_or_create($sy, $code, $desc, $section, $yearLevel, $username=null)
    {
        $this->scopeWhere($sy,$code,$section,$yearLevel);
        $row = $this->db->get('grades_lock_subject')->row();
        if ($row) return $row;

        $this->db->insert('grades_lock_subject', [
            'SY'          => $sy,
            'SubjectCode' => $code,
            'Description' => $desc,
            'Section'     => $section,
            'YearLevel'   => $yearLevel,
            'locked_by'   => $username
        ]);

        $this->scopeWhere($sy,$code,$section,$yearLevel);
        return $this->db->get('grades_lock_subject')->row();
    }

    public function get($sy, $code, $section, $yearLevel)
    {
        $this->scopeWhere($sy,$code,$section,$yearLevel);
        return $this->db->get('grades_lock_subject')->row();
    }

    public function set_lock($sy, $code, $desc, $section, $yearLevel, $period, $lock, $username)
    {
        $row = $this->get_or_create($sy,$code,$desc,$section,$yearLevel,$username);

        if ($period === 'all') {
            $data = [
                'lock_prelim'   => $lock,
                'lock_midterm'  => $lock,
                'lock_prefinal' => $lock,
                'lock_final'    => $lock,
                'locked_by'     => $username
            ];
        } else {
            $col = 'lock_' . $period;
            $data = [$col => $lock, 'locked_by' => $username];
        }

        $this->scopeWhere($sy,$code,$section,$yearLevel);
        $this->db->update('grades_lock_subject', $data);

        return $this->get($sy,$code,$section,$yearLevel);
    }
}
