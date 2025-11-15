<?php
class Ren_model extends CI_Model
{

    public function profile_insert()
    {

        $data = array(
            'StudentNumber' => $this->input->post('StudentNumber'),
            'FirstName' => strtoupper($this->input->post('FirstName')),
            'MiddleName' => strtoupper($this->input->post('MiddleName')),
            'LastName' => strtoupper($this->input->post('LastName')),
            'Sex' => $this->input->post('Sex'),
            'CivilStatus' => $this->input->post('CivilStatus'),
            'BirthPlace' => $this->input->post('BirthPlace'),
            'Citizenship' => $this->input->post('Citizenship'),
            'Religion' => $this->input->post('Religion'),
            'BloodType' => $this->input->post('BloodType'),
            'TelNumber' => $this->input->post('TelNumber'),
            'MobileNumber' => $this->input->post('MobileNumber'),
            'BirthDate' => $this->input->post('BirthDate'),
            'Guardian' => $this->input->post('Guardian'),
            'GuardianContact' => $this->input->post('GuardianContact'),
            'GuardianAddress' => $this->input->post('GuardianAddress'),
            'GuardianRelationship' => $this->input->post('GuardianRelationship'),
            'GuardianTelNo' => $this->input->post('GuardianTelNo'),
            'EmailAddress' => $this->input->post('EmailAddress'),
            'Father' => $this->input->post('Father'),
            'FOccupation' => $this->input->post('FOccupation'),
            'Mother' => $this->input->post('Mother'),
            'MOccupation' => $this->input->post('MOccupation'),
            'Age' => $this->input->post('Age'),
            'Ethnicity' => $this->input->post('Ethnicity'),
            'Province' => $this->input->post('Province'),
            'City' => $this->input->post('City'),
            'Brgy' => $this->input->post('Brgy'),
            'Sitio' => $this->input->post('Sitio'),
            'guardianOccupation' => $this->input->post('guardianOccupation'),
            'nameExt' => $this->input->post('nameExt'),
            'LRN' => $this->input->post('LRN'),
            'ParentsMonthly' => $this->input->post('ParentsMonthly'),
            'Notes' => $this->input->post('Notes'),
            'Elementary' => $this->input->post('Elementary'),
            'Encoder' => $this->session->userdata('username')
        );

        return $this->db->insert('studeprofile', $data);
    }


    public function profile_update()
    {

        $data = array(
            'StudentNumber' => $this->input->post('StudentNumber'),
            'FirstName' => $this->input->post('FirstName'),
            'MiddleName' => $this->input->post('MiddleName'),
            'LastName' => $this->input->post('LastName'),
            'Sex' => $this->input->post('Sex'),
            'CivilStatus' => $this->input->post('CivilStatus'),
            'BirthPlace' => $this->input->post('BirthPlace'),
            'Citizenship' => $this->input->post('Citizenship'),
            'Religion' => $this->input->post('Religion'),
            'BloodType' => $this->input->post('BloodType'),
            'TelNumber' => $this->input->post('TelNumber'),
            'MobileNumber' => $this->input->post('MobileNumber'),
            'BirthDate' => $this->input->post('BirthDate'),
            'Guardian' => $this->input->post('Guardian'),
            'GuardianContact' => $this->input->post('GuardianContact'),
            'GuardianAddress' => $this->input->post('GuardianAddress'),
            'GuardianRelationship' => $this->input->post('GuardianRelationship'),
            'GuardianTelNo' => $this->input->post('GuardianTelNo'),
            'EmailAddress' => $this->input->post('EmailAddress'),
            'Father' => $this->input->post('Father'),
            'FOccupation' => $this->input->post('FOccupation'),
            'Mother' => $this->input->post('Mother'),
            'MOccupation' => $this->input->post('MOccupation'),
            'Age' => $this->input->post('Age'),
            'Ethnicity' => $this->input->post('Ethnicity'),
            'Province' => $this->input->post('Province'),
            'City' => $this->input->post('City'),
            'Brgy' => $this->input->post('Brgy'),
            'Sitio' => $this->input->post('Sitio'),
            'guardianOccupation' => $this->input->post('guardianOccupation'),
            'nameExt' => $this->input->post('nameExt'),
            'LRN' => $this->input->post('LRN'),
            'ParentsMonthly' => $this->input->post('ParentsMonthly'),
            'Notes' => $this->input->post('Notes'),
            'Elementary' => $this->input->post('Elementary'),
            'Encoder' => $this->session->userdata('username')

        );

        $this->db->where('StudentNumber', $this->input->get('id'));
        return $this->db->update('studeprofile', $data);
    }

    public function user_insert()
    {

        date_default_timezone_set('Asia/Manila'); # add your city to set local time zone
        $now = date('H:i:s A');

        $AdmissionDate = date("Y-m-d");
        $Password = sha1($this->input->post('BirthDate'));
        $Encoder = $this->session->userdata('username');

        $data = array(
            'username' => $this->input->post('StudentNumber'),
            'password' => $Password,
            'position' => 'Student',
            'fName' => $this->input->post('FirstName'),
            'mName' => $this->input->post('MiddleName'),
            'lName' => $this->input->post('LastName'),
            'email' => $this->input->post('EmailAddress'),
            'avatar' => 'avatar.png',
            'acctStat' => 'Active',
            'dateCreated' => $AdmissionDate,
            'IDNumber' => $this->input->post('StudentNumber')
        );

        return $this->db->insert('o_users', $data);
    }

    // Ren_model.php

    public function atrail_insert($desc, $resource = 'reg', $studno = null)
    {
        date_default_timezone_set('Asia/Manila');

        // Prefer explicit studno, else session studentNumber/username, else placeholder
        $rawSNo =
            ($studno ?: (
                $this->session->userdata('studentNumber')
                ?? $this->session->userdata('StudentNumber')
                ?? $this->session->userdata('username')
                ?? ''
            ));

        // Ensure NOT NULL; if still empty, use a constant placeholder
        if ($rawSNo === '' || $rawSNo === null) {
            $rawSNo = 'SYSTEM'; // or 'UNKNOWN'
        }

        // If you really need hashing, only hash when non-empty:
        // $atSNo = sha1($rawSNo);
        // If your atrail.atSNo stores plain text, keep it raw:
        $atSNo = $rawSNo;

        $data = [
            'atDesc' => (string)$desc,
            'atDate' => date('Y-m-d'),
            // choose either 24h or 12h, not both:
            'atTime' => date('h:i:s A'), // e.g., 02:55:02 PM
            'atRes'  => (string)$resource,
            'atSNo'  => $atSNo,          // guaranteed non-null now
        ];

        $this->db->insert('atrail', $data);
    }


    public function enroll_insert()
    {


        $data = array(
            'StudentNumber' => $this->input->post('StudentNumber'),
            'Course' => $this->input->post('Course'),
            'YearLevel' => $this->input->post('YearLevel'),
            'Status' => 'Enrolled',
            // 'Semester' => $this->input->post('Semester'),
            'SY' => $this->input->post('SY'),
            'Section' => $this->input->post('Section'),
            'StudeStatus' => $this->input->post('StudeStatus'),
            //'Scholarship' => $this->input->post('Scholarship'), 
            //'YearLevelStat' => $this->input->post('YearLevelStat'), 
            //'Major' => $this->input->post('Major'), 
            'Track' => $this->input->post('Track'),
            'Qualification' => $this->input->post('Qualification'),
            'BalikAral' => $this->input->post('BalikAral'),
            'IP' => $this->input->post('IP'),
            'FourPs' => $this->input->post('FourPs'),
            'Repeater' => $this->input->post('Repeater'),
            'Transferee' => $this->input->post('Transferee'),
            'EnrolledDate' => date("Y-m-d"),
            'Adviser' => $this->input->post('Adviser'),
            'IDNumber' => $this->input->post('IDNumber'),
        );

        return $this->db->insert('semesterstude', $data);
    }

    public function online_enrollment_update()
    {

        $data = array(
            'enrolStatus' => 'Verified'
        );

        $this->db->where('StudentNumber', $this->input->post('StudentNumber'));
        $this->db->where('SY', $this->input->post('SY'));
        return $this->db->update('online_enrollment', $data);
    }

    public function enlistment_insert()
    {
        $SubjectCode = implode(',', $this->input->post('SubjectCode'));
        $sc = explode(',', $SubjectCode);

        for ($i = 0; $i < count($sc); $i++) {
            $pda1 = $this->input->post('pda' . $i . '1');
            $pda2 = $this->input->post('pda' . $i . '2');
            $pda3 = $this->input->post('pda' . $i . '3');

            $item = array(
                'SubjectCode' => $SubjectCode,
                'Description' => $this->input->post('Description'),
                'Section' => $this->input->post('Section'),
                'SchedTime' => $this->input->post('SchedTime'),
            );

            $this->db->insert('registration', $item);
        }
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch('registration', $data);
    }

    public function ebook_insert($file, $file2)
    {


        $data = array(
            'title' => $this->input->post('title'),
            'author' => $this->input->post('author'),
            'isbn' => $this->input->post('isbn'),
            'pub_date' => $this->input->post('pub_date'),
            'genre' => $this->input->post('genre'),
            'description' => $this->input->post('description'),
            'file_path' => $file,
            'cover_image' => $file2
        );

        return $this->db->insert('ebooks', $data);
    }

    public function ebook_update()
    {


        $data = array(
            'title' => $this->input->post('title'),
            'author' => $this->input->post('author'),
            'isbn' => $this->input->post('isbn'),
            'pub_date' => $this->input->post('pub_date'),
            'genre' => $this->input->post('genre'),
            'description' => $this->input->post('description')
        );

        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('ebooks', $data);
    }

    public function ebook_cover_update($file)
    {


        $data = array(
            'cover_image' => $file
        );


        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('ebooks', $data);
    }

    public function ebook_file_update($file)
    {


        $data = array(
            'file_path' => $file
        );


        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('ebooks', $data);
    }


    //common delete function

    public function delete($table, $col_id, $segment)
    {
        $id = $this->uri->segment($segment);
        $this->db->where($col_id, $id);
        $this->db->delete($table);
        return true;
    }

    function delete_ebook($table, $col, $segment, $attach)
    {
        $this->db->where($col, $segment);
        unlink("upload/ebook/" . $attach);
        $this->db->delete($table);
    }

    public function tcd($table, $col, $val, $col2, $val2)
    { // two cond delete
        $this->db->where($col, $val);
        $this->db->where($col2, $val2);
        $this->db->delete($table);
        return true;
    }

    public function del($table, $col, $val)
    { // one cond delete
        $this->db->where($col, $val);
        $this->db->delete($table);
        return true;
    }

    public function get_foos($page)
    {
        // First count all foos
        $count = $this->db->count_all('ebooks');

        // Create the pagination links
        //$this->load->library('pagination');
        //$this->load->helper('url');

        $paging_conf = [
            'uri_segment'      => 3,
            'per_page'         => 2,
            'total_rows'       => $count,
            'base_url'         => site_url('Library/page'),
            'first_url'        => site_url('Library/page/1'),
            'use_page_numbers' => TRUE,
            'attributes'       => ['class' => 'number'],
            'prev_link'        => 'Previous',
            'next_link'        => 'Next',

            // Custom classes for pagination links
            'prev_tag_open'    => '<ul>',
            'prev_tag_close'   => '</ul>',
            'prev_tag_open'    => '<li class="page-item prev-item">',
            'prev_tag_close'   => '</li>',
            'next_tag_open'    => '<li class="page-item next-item">',
            'next_tag_close'   => '</li>',
        ];



        $this->pagination->initialize($paging_conf);

        // Create the paging buttons for the view
        $this->load->vars('pagination_links', $this->pagination->create_links());

        // The pagination offset
        $offset = $page * $paging_conf['per_page'] - $paging_conf['per_page'];

        // Get our set of foos
        $query = $this->db->get('ebooks', $paging_conf['per_page'], $offset);

        // Make sure we have foos
        if ($query->num_rows() > 0)
            return $query->result();

        // Else return default
        return NULL;
    }


    // public function insert_grades($data)
    // {
    //     return $this->db->insert_batch('grades', $data);
    // }

    public function insert_grades($rows)
    {
        $result = [
            'inserted'   => 0,
            'duplicates' => [],
            'error'      => null,
        ];

        if (empty($rows) || !is_array($rows)) {
            return $result;
        }

        $insertable = [];
        $seenKeys   = [];

        foreach ($rows as $row) {
            $sn      = trim((string)($row['StudentNumber'] ?? ''));
            $sc      = trim((string)($row['SubjectCode'] ?? ''));
            $sy      = trim((string)($row['SY'] ?? ''));
            $section = trim((string)($row['Section'] ?? ''));

            if ($sn === '' || $sc === '' || $sy === '' || $section === '') {
                continue; // skip incomplete rows
            }

            $key = $sn . '|' . $sc . '|' . $sy . '|' . $section;
            if (isset($seenKeys[$key])) {
                $result['duplicates'][] = $row;
                continue;
            }
            $seenKeys[$key] = true;

            $exists = $this->db->where([
                'StudentNumber' => $sn,
                'SubjectCode'   => $sc,
                'SY'            => $sy,
                'Section'       => $section,
            ])->count_all_results('grades');

            if ($exists) {
                $result['duplicates'][] = $row;
                continue;
            }

            $insertable[] = $row;
        }

        if (empty($insertable)) {
            return $result;
        }

        $oldDebug = $this->db->db_debug;
        $this->db->db_debug = false;

        $this->db->insert_batch('grades', $insertable);
        $error    = $this->db->error();
        $affected = $this->db->affected_rows();

        $this->db->db_debug = $oldDebug;

        if (!empty($error['code'])) {
            log_message('error', 'insert_grades error: ' . $error['message']);
            $result['error'] = $error['message'];
        } else {
            $result['inserted'] = $affected;
        }

        return $result;
    }

    public function update_grades($data)
    {
        return $this->db->update_batch('grades', $data, 'gradeID');
    }

    public function batch_update_grades($update_data)
    {
        // Update the grades in the database
        $this->db->update_batch('grades', $update_data, 'gradeID'); // 'id' is the primary key
    }

    public function update_batchren($data)
    {
        return $this->db->update_batch('grades', $data, 'gradeID');
    }

    public function update_batch_stud($data)
    {
        return $this->db->update_batch('grades', $data, 'gradeID');
    }


    public function insert_enlist_sub($data)
    {
        $this->db->insert('registration', $data);
    }

    public function getProfile()
    {
        $sy = $this->session->userdata('sy');

        return $this->db
            ->select('studeprofile.*, semesterstude.*')
            ->from('studeprofile')
            ->join('semesterstude', 'studeprofile.StudentNumber = semesterstude.StudentNumber', 'left')
            ->where('semesterstude.SY', $sy)
            ->order_by('studeprofile.LastName', 'ASC')
            ->get()
            ->result();
    }

// Ren_model.php

// students with registration for a given SY (for the picker)
// Ren_model.php

    /**
     * All students with registration in a given SY (no filter)
     */
    public function get_students_with_registration($sy)
    {
        $this->db->select('DISTINCT r.StudentNumber, s.LastName, s.FirstName, s.MiddleName', false);
        $this->db->from('registration r');
        $this->db->join('studeprofile s', 's.StudentNumber = r.StudentNumber', 'left');
        $this->db->where('r.SY', $sy);
        $this->db->order_by('s.LastName', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Only students handled by a specific teacher (as recorded in semesterstude) for the given SY.
     * Matching key: semesterstude.IDNumber = $teacherID and semesterstude.SY = $sy
     */
    // Ren_model.php

    /**
     * Students taught by a teacher this SY, inferred from semsubjects,
     * by matching semsubjects <-> registration on SY + SubjectCode + Description
     * and Section when semsubjects.Section is set.
     */
    public function get_students_with_registration_for_teacher_subjects($sy, $teacherID)
    {
        $teacherID = trim((string)$teacherID);

        $this->db->select('DISTINCT r.StudentNumber, s.LastName, s.FirstName, s.MiddleName', false);
        $this->db->from('registration r');
        $this->db->join('studeprofile s', 's.StudentNumber = r.StudentNumber', 'left');

        // Join to semsubjects (teacher’s load)
        // Match on SY + SubjectCode + Description, and Section if semsubjects.Section is not empty
        $this->db->join(
            'semsubjects ss',
            "ss.SY = r.SY
         AND TRIM(ss.SubjectCode) = TRIM(r.SubjectCode)
         AND TRIM(ss.Description) = TRIM(r.Description)
         AND (ss.Section IS NULL OR ss.Section = '' OR TRIM(ss.Section) = TRIM(r.Section))",
            'inner'
        );

        $this->db->where('r.SY', $sy);
        $this->db->where('ss.SY', $sy);
        $this->db->where('ss.IDNumber', $teacherID);

        $this->db->order_by('s.LastName', 'ASC');
        return $this->db->get()->result();
    }


    // all registration rows for a student in SY (adjust column names if different)
    public function get_registration_rows($sy, $studentNumber)
    {
        $this->db->select('
        regnumber AS regID,          /* <-- alias regnumber to regID */
        StudentNumber,
        SubjectCode,
        Description,
        Instructor,
        SY,
        Sem AS Semester,             /* <-- keep alias for view/controller */
        YearLevel,
        Section
    ', false);
        $this->db->from('registration');
        $this->db->where('SY', $sy);
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->order_by('Description', 'ASC');
        return $this->db->get()->result();
    }

    // batch insert grades but skip duplicates (StudentNumber, SubjectCode, SY, Semester)
    // Remove Semester from duplicate check
    public function insert_grades_batch_skip_dupes(array $rows)
    {
        if (empty($rows)) return 0;
        $insertable = [];

        foreach ($rows as $r) {
            if (empty($r['StudentNumber']) || empty($r['SubjectCode']) || empty($r['SY'])) {
                continue; // skip incomplete keys
            }

            // Only check StudentNumber + SubjectCode + SY
            $exists = $this->db->where([
                'StudentNumber' => $r['StudentNumber'],
                'SubjectCode'   => $r['SubjectCode'],
                'SY'            => $r['SY'],
            ])->count_all_results('grades');

            if ($exists == 0) $insertable[] = $r;
        }

        if (empty($insertable)) return 0;
        $this->db->insert_batch('grades', $insertable);
        return $this->db->affected_rows();
    }






    // Ren_model.php
    public function get_existing_grade_row($sn, $sc, $sy, $section)
    {
        $sn      = trim((string)$sn);
        $sc      = trim((string)$sc);
        $sy      = trim((string)$sy);
        $section = trim((string)$section);

        return $this->db
            ->limit(1)
            ->get_where('grades', [
                'StudentNumber' => $sn,
                'SubjectCode'   => $sc,
                'SY'            => $sy,
                'Section'       => $section,
            ])->row();
    }

    /**
     * Insert when no grades row. Update when existing row has all zero/null grades.
     * Skips any row that already has non-zero data.
     * Returns ['inserted'=>X, 'updated'=>Y, 'skipped'=>Z]
     */
    public function upsert_grades_for_pending(array $rows, $forceUpdate = false)
    {
        $res = ['inserted' => 0, 'updated' => 0, 'skipped' => 0];

        foreach ($rows as $r) {
            $sn      = $r['StudentNumber'] ?? '';
            $sc      = $r['SubjectCode']   ?? '';
            $sy      = $r['SY']            ?? '';
            $section = $r['Section']       ?? '';

            if ($sn === '' || $sc === '' || $sy === '') {
                $res['skipped']++;
                continue;
            }

            $exist = $this->get_existing_grade_row($sn, $sc, $sy, $section);

            if (!$exist) {
                $this->db->insert('grades', $r);
                $res['inserted'] += ($this->db->affected_rows() > 0) ? 1 : 0;
            } else {
                $allZero = (float)($exist->PGrade ?? 0) == 0.0
                    && (float)($exist->MGrade ?? 0) == 0.0
                    && (float)($exist->PFinalGrade ?? 0) == 0.0
                    && (float)($exist->FGrade ?? 0) == 0.0;

                if ($forceUpdate || $allZero) {
                    $upd = [
                        'PGrade'      => $r['PGrade'],
                        'MGrade'      => $r['MGrade'],
                        'PFinalGrade' => $r['PFinalGrade'],
                        'FGrade'      => $r['FGrade'],
                        'Average'     => $r['Average'],
                        'Instructor'  => $r['Instructor'] ?? $exist->Instructor,
                        'Description' => $r['Description'] ?? $exist->Description,
                        'YearLevel'   => $r['YearLevel']   ?? $exist->YearLevel,
                        'Section'     => $r['Section']     ?? $exist->Section,
                        'adviser'     => $r['adviser']     ?? $exist->adviser,
                        'strand'      => $r['strand']      ?? $exist->strand,
                    ];
                    $this->db->where('gradeID', $exist->gradeID)->update('grades', $upd);
                    $res['updated'] += ($this->db->affected_rows() > 0) ? 1 : 0;
                } else {
                    $res['skipped']++;
                }
            }
        }
        return $res;
    }

    public function get_registration_rows_pending_for_grading($sy, $studentNumber, $grading = 'all')
    {
        $this->db->select("
        r.regnumber AS regID,
        r.StudentNumber,
        r.SubjectCode,
        r.Description,
        r.Instructor,
        r.SY,
        r.YearLevel,
        r.Section,
        COALESCE(sec.IDNumber, '') AS adviser,
        COALESCE(r.strand, '')     AS strand
    ", false);

        $this->db->from('registration r');

        // Join sections by YearLevel + Section + SY (no Sem)
        $this->db->join(
            'sections sec',
            'sec.YearLevel = r.YearLevel AND ' .
                'sec.Section   = r.Section   AND ' .
                'sec.SY        = r.SY',
            'left'
        );

        // Join grades to check pending/zeros
        $this->db->join(
            'grades g',
            'g.StudentNumber = r.StudentNumber AND ' .
                'g.SubjectCode   = r.SubjectCode   AND ' .
                'g.SY            = r.SY            AND ' .
                'g.Section       = r.Section',
            'left'
        );

        $this->db->where('r.SY', $sy);
        $this->db->where('r.StudentNumber', $studentNumber);

        if ($grading === 'first') {
            $this->db->group_start()
                ->where('g.gradeID IS NULL', null, false)
                ->or_where('COALESCE(g.PGrade,0)=0', null, false)
                ->group_end();
        } elseif ($grading === 'second') {
            $this->db->group_start()
                ->where('g.gradeID IS NULL', null, false)
                ->or_where('COALESCE(g.MGrade,0)=0', null, false)
                ->group_end();
        } elseif ($grading === 'third') {
            $this->db->group_start()
                ->where('g.gradeID IS NULL', null, false)
                ->or_where('COALESCE(g.PFinalGrade,0)=0', null, false)
                ->group_end();
        } elseif ($grading === 'fourth') {
            $this->db->group_start()
                ->where('g.gradeID IS NULL', null, false)
                ->or_where('COALESCE(g.FGrade,0)=0', null, false)
                ->group_end();
        } else { // all
            $this->db->group_start()
                ->where('g.gradeID IS NULL', null, false)
                ->or_group_start()
                ->where('COALESCE(g.PGrade,0)=0',      null, false)
                ->where('COALESCE(g.MGrade,0)=0',      null, false)
                ->where('COALESCE(g.PFinalGrade,0)=0', null, false)
                ->where('COALESCE(g.FGrade,0)=0',      null, false)
                ->group_end()
                ->group_end();
        }

        $this->db->order_by('r.Description', 'ASC');
        return $this->db->get()->result();
    }



    public function check_if_student_has_grades($studentNumber, $sy, $grading)
    {
        // Check if the student already has grades for the selected grading period
        $this->db->select('gradeID');
        $this->db->from('grades');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $sy);

        if ($grading === 'first') {
            $this->db->where('PGrade !=', 0);  // Check for Prelim grades
        } elseif ($grading === 'second') {
            $this->db->where('MGrade !=', 0);  // Check for Midterm grades
        } elseif ($grading === 'third') {
            $this->db->where('PFinalGrade !=', 0);  // Check for PreFinal grades
        } elseif ($grading === 'fourth') {
            $this->db->where('FGrade !=', 0);  // Check for Final grades
        }

        $query = $this->db->get();

        // Return true if grades exist for the selected period, false otherwise
        return $query->num_rows() > 0;
    }


    public function get_registration_rows_pending($sy, $studentNumber)
    {
        $this->db->select("
        r.regnumber AS regID,
        r.StudentNumber,
        r.SubjectCode,
        r.Description,
        r.Instructor,
        r.SY,
        r.YearLevel,
        r.Section,
        COALESCE(sec.IDNumber, '') AS adviser,
        COALESCE(r.strand, '')     AS strand
    ", false);

        $this->db->from('registration r');

        // Join sections by YearLevel + Section + SY (no Sem)
        $this->db->join(
            'sections sec',
            'sec.YearLevel = r.YearLevel AND ' .
                'sec.Section   = r.Section   AND ' .
                'sec.SY        = r.SY',
            'left'
        );

        // Left join to grades to find pending/all-zero
        $this->db->join(
            'grades g',
            'g.StudentNumber = r.StudentNumber AND ' .
                'g.SubjectCode   = r.SubjectCode   AND ' .
                'g.SY            = r.SY            AND ' .
                'g.Section       = r.Section',
            'left'
        );

        $this->db->where('r.SY', $sy);
        $this->db->where('r.StudentNumber', $studentNumber);

        $this->db->group_start();
        $this->db->where('g.gradeID IS NULL', null, false);
        $this->db->or_group_start();
        $this->db->where('COALESCE(g.PGrade,0)=0',      null, false);
        $this->db->where('COALESCE(g.MGrade,0)=0',      null, false);
        $this->db->where('COALESCE(g.PFinalGrade,0)=0', null, false);
        $this->db->where('COALESCE(g.FGrade,0)=0',      null, false);
        $this->db->group_end();
        $this->db->group_end();

        $this->db->order_by('r.Description', 'ASC');
        return $this->db->get()->result();
    }





    // Students under adviser (semesterstude.Adviser = adviserID)
    public function get_students_for_adviser($sy, $adviserID)
    {
        $this->db->select('DISTINCT r.StudentNumber, s.LastName, s.FirstName, s.MiddleName', false);
        $this->db->from('registration r');
        $this->db->join('studeprofile s', 's.StudentNumber = r.StudentNumber', 'left');
        $this->db->join('semesterstude ss', 'ss.StudentNumber = r.StudentNumber AND ss.SY = r.SY', 'left');
        $this->db->where('r.SY', $sy);
        $this->db->where('ss.Adviser', $adviserID);
        $this->db->order_by('s.LastName', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * All subjects for a student with current grades (if any)
     * Used by Adviser/Registrar
     */
    public function rows_with_grades_all($sy, $studentNumber)
    {
        $this->db->select("
        r.regnumber   AS regID,
        r.StudentNumber,
        r.SubjectCode,
        r.Description,
        r.Instructor,
        r.SY,
        r.YearLevel,
        r.Section,
        COALESCE(sec.IDNumber,'') AS adviser,
        COALESCE(r.strand,'')     AS strand,
        g.gradeID,
        COALESCE(g.PGrade,0)      AS PGrade,
        COALESCE(g.MGrade,0)      AS MGrade,
        COALESCE(g.PFinalGrade,0) AS PFinalGrade,
        COALESCE(g.FGrade,0)      AS FGrade,
        COALESCE(g.Average,0)     AS Average
    ", false);
        $this->db->from('registration r');
        $this->db->join(
            'sections sec',
            'sec.YearLevel = r.YearLevel AND sec.Section = r.Section AND sec.SY = r.SY',
            'left'
        );
        $this->db->join(
            'grades g',
            'g.StudentNumber = r.StudentNumber AND g.SubjectCode = r.SubjectCode AND g.SY = r.SY AND g.Section = r.Section',
            'left'
        );
        $this->db->where('r.SY', $sy);
        $this->db->where('r.StudentNumber', $studentNumber);
        $this->db->order_by('r.Description', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Only the teacher's subjects for that student, with current grades (if any)
     */
    public function rows_with_grades_for_teacher($sy, $studentNumber, $teacherID)
    {
        $this->db->select("
        r.regnumber   AS regID,
        r.StudentNumber,
        r.SubjectCode,
        r.Description,
        r.Instructor,
        r.SY,
        r.YearLevel,
        r.Section,
        COALESCE(sec.IDNumber,'') AS adviser,
        COALESCE(r.strand,'')     AS strand,
        g.gradeID,
        COALESCE(g.PGrade,0)      AS PGrade,
        COALESCE(g.MGrade,0)      AS MGrade,
        COALESCE(g.PFinalGrade,0) AS PFinalGrade,
        COALESCE(g.FGrade,0)      AS FGrade,
        COALESCE(g.Average,0)     AS Average
    ", false);

        $this->db->from('registration r');
        // tie to teacher load
        $this->db->join(
            'semsubjects ss',
            "ss.SY = r.SY
         AND TRIM(ss.SubjectCode) = TRIM(r.SubjectCode)
         AND TRIM(ss.Description) = TRIM(r.Description)
         AND (ss.Section IS NULL OR ss.Section = '' OR TRIM(ss.Section) = TRIM(r.Section))",
            'inner'
        );
        $this->db->join(
            'sections sec',
            'sec.YearLevel = r.YearLevel AND sec.Section = r.Section AND sec.SY = r.SY',
            'left'
        );
        $this->db->join(
            'grades g',
            'g.StudentNumber = r.StudentNumber AND g.SubjectCode = r.SubjectCode AND g.SY = r.SY AND g.Section = r.Section',
            'left'
        );

        $this->db->where('r.SY', $sy);
        $this->db->where('r.StudentNumber', $studentNumber);
        $this->db->where('ss.IDNumber', $teacherID);

        $this->db->order_by('r.Description', 'ASC');
        return $this->db->get()->result();
    }




    public function upsert_grades_absolute(array $rows, string $mode = 'fill')
    {
        // $mode: 'force' (registrar) | 'fill' (teacher/adviser)
        $res = ['inserted' => 0, 'updated' => 0, 'unchanged' => 0];

        foreach ($rows as $r) {
            $sn      = trim((string)($r['StudentNumber'] ?? ''));
            $sc      = trim((string)($r['SubjectCode']   ?? ''));
            $sy      = trim((string)($r['SY']            ?? ''));
            $section = trim((string)($r['Section']       ?? ''));

            if ($sn === '' || $sc === '' || $sy === '') {
                $res['unchanged']++;
                continue;
            }

            $exist = $this->get_existing_grade_row($sn, $sc, $sy, $section);

            // Normalize incoming cell intents: NULL means "no change".
            $inP  = array_key_exists('PGrade',      $r) ? $r['PGrade']      : null;
            $inM  = array_key_exists('MGrade',      $r) ? $r['MGrade']      : null;
            $inPF = array_key_exists('PFinalGrade', $r) ? $r['PFinalGrade'] : null;
            $inF  = array_key_exists('FGrade',      $r) ? $r['FGrade']      : null;

            if (!$exist) {
                // INSERT: build a new row; untouched cells default to 0
                $row = [
                    'StudentNumber' => $sn,
                    'SubjectCode'   => $sc,
                    'Description'   => $r['Description'] ?? '',
                    'Instructor'    => $r['Instructor']  ?? '',
                    'Section'       => $section,
                    'PGrade'        => is_null($inP)  ? 0 : (float)$inP,
                    'MGrade'        => is_null($inM)  ? 0 : (float)$inM,
                    'PFinalGrade'   => is_null($inPF) ? 0 : (float)$inPF,
                    'FGrade'        => is_null($inF)  ? 0 : (float)$inF,
                    'Average'       => 0, // compute below
                    'Sem'           => '', // set if you use it
                    'SY'            => $sy,
                    'YearLevel'     => $r['YearLevel'] ?? '',
                    'adviser'       => $r['adviser']   ?? '',
                    'strand'        => $r['strand']    ?? '',
                ];

                // Compute Average from non-zero parts (or leave 0 if none)
                $parts = [];
                if ($row['PGrade']      > 0) $parts[] = $row['PGrade'];
                if ($row['MGrade']      > 0) $parts[] = $row['MGrade'];
                if ($row['PFinalGrade'] > 0) $parts[] = $row['PFinalGrade'];
                if ($row['FGrade']      > 0) $parts[] = $row['FGrade'];
                $row['Average'] = count($parts) ? round(array_sum($parts) / count($parts), 2) : 0;

                // Only insert when at least one intended cell is present (or force mode allows zero-fill insert)
                $hasIntent = ($inP !== null) || ($inM !== null) || ($inPF !== null) || ($inF !== null);
                if ($hasIntent) {
                    $this->db->insert('grades', $row);
                    $res['inserted'] += ($this->db->affected_rows() > 0) ? 1 : 0;
                } else {
                    $res['unchanged']++;
                }
                continue;
            }

            // UPDATE path: compute which cells to change
            $upd = [];

            // Pull current values
            $curP  = (float)($exist->PGrade      ?? 0);
            $curM  = (float)($exist->MGrade      ?? 0);
            $curPF = (float)($exist->PFinalGrade ?? 0);
            $curF  = (float)($exist->FGrade      ?? 0);

            // Apply per mode
            if (!is_null($inP)) {
                if ($mode === 'force' || $curP  == 0.0) $upd['PGrade']      = (float)$inP;
            }
            if (!is_null($inM)) {
                if ($mode === 'force' || $curM  == 0.0) $upd['MGrade']      = (float)$inM;
            }
            if (!is_null($inPF)) {
                if ($mode === 'force' || $curPF == 0.0) $upd['PFinalGrade'] = (float)$inPF;
            }
            if (!is_null($inF)) {
                if ($mode === 'force' || $curF  == 0.0) $upd['FGrade']      = (float)$inF;
            }

            // Also refresh meta if provided
            foreach (['Instructor', 'Description', 'YearLevel', 'Section', 'adviser', 'strand'] as $k) {
                if (isset($r[$k]) && $r[$k] !== '') $upd[$k] = $r[$k];
            }

            if (!empty($upd)) {
                // Recompute Average based on the would-be new state
                $newP  = array_key_exists('PGrade',      $upd) ? (float)$upd['PGrade']      : $curP;
                $newM  = array_key_exists('MGrade',      $upd) ? (float)$upd['MGrade']      : $curM;
                $newPF = array_key_exists('PFinalGrade', $upd) ? (float)$upd['PFinalGrade'] : $curPF;
                $newF  = array_key_exists('FGrade',      $upd) ? (float)$upd['FGrade']      : $curF;

                $parts = [];
                if ($newP  > 0) $parts[] = $newP;
                if ($newM  > 0) $parts[] = $newM;
                if ($newPF > 0) $parts[] = $newPF;
                if ($newF  > 0) $parts[] = $newF;

                $upd['Average'] = count($parts) ? round(array_sum($parts) / count($parts), 2) : 0;

                $this->db->where('gradeID', $exist->gradeID)->update('grades', $upd);
                $res['updated'] += ($this->db->affected_rows() > 0) ? 1 : 0;
            } else {
                // No applicable change (e.g., teacher tried to overwrite a non-zero cell)
                $res['unchanged']++;
            }
        }

        return $res;
    }
}
