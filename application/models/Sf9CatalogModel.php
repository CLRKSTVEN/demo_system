<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sf9CatalogModel extends CI_Model
{
    public function template_for_student($course, $yearLevel, $strand = null)
    {
        return [
            'First Semester'  => $this->template_for($course, $yearLevel, 'First Semester', $strand),
            'Second Semester' => $this->template_for($course, $yearLevel, 'Second Semester', $strand),
        ];
    }

   public function template_for($course, $yearLevel, $semester, $strand = null)
{
    $buckets = ['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]];
    $fields = $this->db->list_fields('subjects');
    $hasDisplayOrderCamel = in_array('displayOrder', $fields, true);
    $hasDisplayOrderSnake = in_array('display_order', $fields, true);

    $this->db->select('subjectCode, description, course, yearLevel, sem, strand, subCategory');
    $this->db->from('subjects');
    $this->db->group_start()
        ->where('course', $course)
        ->or_where('course IS NULL', null, false)
        ->or_where('course = ""', null, false)
    ->group_end();

    $this->db->where('yearLevel', $yearLevel);
    $this->db->where('sem', $semester);
    $this->db->group_start()
        ->where('strand', $strand)
        ->or_where('strand IS NULL', null, false)
        ->or_where('strand = ""', null, false)
    ->group_end();
    if ($hasDisplayOrderCamel) {
        $this->db->order_by('displayOrder', 'ASC');
    } elseif ($hasDisplayOrderSnake) {
        $this->db->order_by('display_order', 'ASC');
    }
    $this->db->order_by('description', 'ASC');

    $rows = $this->db->get()->result();

    foreach ($rows as $r) {
        $cat  = $this->map_category($r->subCategory ?? '');
        $buckets[$cat][] = (object)[
            'code' => (string)($r->subjectCode ?? ''),
            'desc' => (string)($r->description ?? ''),
        ];
    }
    return $buckets;
}


    private function map_category($subCategory)
    {
        $s = strtoupper((string)$subCategory);
        if ($s === '') return 'Specialized Subject';
        if (strpos($s,'CORE') !== false)    return 'Core Subjects';
        if (strpos($s,'APPLIED') !== false) return 'Applied Subject/s';
        return 'Specialized Subject';
    }
}
