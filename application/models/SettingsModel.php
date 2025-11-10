<?php
class SettingsModel extends CI_Model
{

 public function getOrDisplayFlag()
    {
        $row = $this->db->select('orDisplay')
                        ->from('srms_settings_o')
                        ->limit(1)
                        ->get()
                        ->row();
        return (int)($row->orDisplay ?? 0);
    }

    function getStrand1()
    {
        $query = $this->db->query("select * from track_strand group by track order by track");
        return $query->result();
    }

    //Get Track and Display on the combo box
    function getTrack()
    {
        $this->db->select('track');
        $this->db->distinct();
        $this->db->order_by('track', 'ASC');
        $query = $this->db->get('track_strand');
        return $query->result();
    }

    function getStrand($trackVal)
    {
        $this->db->select('track,strand');
        $this->db->where('track', $trackVal);
        $this->db->distinct();
        $this->db->order_by('track', 'ASC');
        $query = $this->db->get('track_strand');
        return $query->result();
    }

    public function strandList()
    {
        $this->db->order_by('strand');
        $query = $this->db->get('track_strand');
        return $query->result();
    }



    //Get Track List
    function getTrackList()
    {
        $query = $this->db->query("select * from track_strand order by track");
        return $query->result();
    }

    public function getSchoolInfo1()
    {
        // Load the database library if not autoloaded
        $this->load->database();

        // Execute the query and return the result
        $query = $this->db->get('srms_settings_o', 1);
        return $query->result();
    }

    public function getSchoolInfo()
    {
        $this->load->database();
        $query = $this->db->get('srms_settings_o', 1);
        return $query->row(); // 🔁 this returns a single object, not an array
    }

    function getDocReq()
    {
        $query = $this->db->query("select * from settings_doc_req order by docName");
        return $query->result();
    }


    //Get Section List
    function getSectionList()
    {
        $query = $this->db->query("select * from sections order by Section");
        return $query->result();
    }





    public function get_ethnicity()
    {
        $query = $this->db->get('settings_ethnicity');
        return $query->result();
    }

    public function insertethnicity($data)
    {
        $this->db->insert('settings_ethnicity', $data);
    }

    public function getethnicitybyId($id)
    {
        $query = $this->db->query("SELECT * FROM settings_ethnicity WHERE id = '" . $id . "'");
        return $query->result();
    }

    public function updateethnicity($id, $ethnicity)
    {
        $data = array(
            'ethnicity' => $ethnicity,

        );
        $this->db->where('id', $id);
        $this->db->update('settings_ethnicity', $data);
    }

    public function Delete_ethnicity($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('settings_ethnicity');
    }




    public function get_religion()
    {
        $query = $this->db->get('settings_religion');
        return $query->result();
    }

    public function insertreligion($data)
    {
        $this->db->insert('settings_religion', $data);
    }

    public function getreligionbyId($id)
    {
        $query = $this->db->query("SELECT * FROM settings_religion WHERE id = '" . $id . "'");
        return $query->result();
    }

    public function updatereligion($id, $religion)
    {
        $data = array(
            'religion' => $religion,

        );
        $this->db->where('id', $id);
        $this->db->update('settings_religion', $data);
    }

    public function Delete_religion($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('settings_religion');
    }



    // for prevschool

    public function get_prevschool()
    {
        $query = $this->db->get('prevschool');
        return $query->result();
    }

    public function displayrecordsById($StudentNumber)
    {
        $this->db->where('StudentNumber', $StudentNumber); // Adjust based on your ID field
        $query = $this->db->get('studeprofile'); // Replace 'students' with your actual table name
        return $query->row(); // Ensure this returns a single row as an object
    }


    // public function get_prevschool1() {
    //     $this->db->select('sp.*, ps.School');
    //     $this->db->from('studeprofile sp');
    //     $this->db->join('prevschool ps', 'sp.Elementary = ps.School', 'left'); // Use 'inner' or 'left' as needed
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // public function get_prevschool1() {
    //     $this->db->select('School');  // Select the needed fields
    //     $this->db->from('prevschool');
    //     $query = $this->db->get();
    //     return $query->result(); // All schools are fetched from 'prevschool'
    // }


    public function insertprevschool($data)
    {
        $this->db->insert('prevschool', $data);
    }

    public function getprevschoolbyId($schoolID)
    {
        $query = $this->db->query("SELECT * FROM prevschool WHERE schoolID = '" . $schoolID . "'");
        return $query->result();
    }

    public function updateprevschool($schoolID, $School, $Address)
    {
        $data = array(
            'School' => $School,
            'Address' => $Address,


        );
        $this->db->where('schoolID', $schoolID);
        $this->db->update('prevschool', $data);
    }

    public function Delete_prevschool($schoolID)
    {
        $this->db->where('schoolID', $schoolID);
        $this->db->delete('prevschool');
    }



    public function insertTrack_strand($data)
    {
        $this->db->insert('track_strand', $data);
    }

    public function get_track_strand()
    {
        $query = $this->db->get('track_strand');
        return $query->result();
    }

    public function get_track_strandbyId($trackID)
    {
        $query = $this->db->query("SELECT * FROM track_strand WHERE trackID = '" . $trackID . "'");
        return $query->result();
    }


    public function updatetrack_strand($trackID, $track, $strand)
    {
        $data = array(
            'track' => $track,
            'strand' => $strand,


        );
        $this->db->where('trackID', $trackID);
        $this->db->update('track_strand', $data);
    }


    public function Delete_track_strand($trackID)
    {
        $this->db->where('trackID', $trackID);
        $this->db->delete('track_strand');
    }



    public function insertprogram($data)
    {
        $this->db->insert('course_table', $data);
    }


    public function update_program($courseid, $CourseCode, $CourseDescription, $Major)
    {
        $data = array(
            'CourseCode' => $CourseCode,
            'CourseDescription' => $CourseDescription,
            'Major' => $Major,


        );
        $this->db->where('courseid', $courseid);
        $this->db->update('course_table', $data);
    }


    public function get_programbyId($courseid)
    {
        $query = $this->db->query("SELECT * FROM course_table WHERE courseid = '" . $courseid . "'");
        return $query->result();
    }


    public function Delete_program($courseid)
    {
        $this->db->where('courseid', $courseid);
        $this->db->delete('course_table');
    }


    public function get_subjects()
    {
        $query = $this->db->get('subjects');
        return $query->result();
    }

    public function get_staff()
    {
        $query = $this->db->get('staff');
        return $query->result();
    }

    public function get_Major()
    {
        $this->db->distinct();
        $this->db->select('Major');
        $this->db->from('course_table');
        $this->db->order_by('Major');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_year_levels()
    {
        $this->db->distinct();
        $this->db->select('yearLevel');
        $query = $this->db->get('subjects');
        return $query->result();
    }

    public function get_subjects_by_year($yearLevel)
    {
        $this->db->where('yearLevel', $yearLevel);  // Add a where clause to filter by yearLevel
        $query = $this->db->get('subjects');
        return $query->result();  // Return the result as an array of objects
    }



    public function insertsubjects($data)
    {
        $this->db->insert('subjects', $data);
    }


    // public function update_subject($id, $subjectCode, $description, $yearLevel, $course, $sem, $strand, $subCategory)
    // {
    //     $data = array(
    //         'subjectCode'  => $subjectCode,
    //         'description'  => $description,
    //         'yearLevel'    => $yearLevel,
    //         'course'       => $course,
    //         'sem'          => $sem,
    //         'strand'       => $strand,
    //         'subCategory'  => $subCategory
    //     );

    //     $this->db->where('id', $id);
    //     return $this->db->update('subjects', $data);
    // }


    public function get_subjectbyId($id)
    {
        $query = $this->db->query("SELECT * FROM subjects WHERE id = '" . $id . "'");
        return $query->result();
    }


    public function Delete_subjects($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('subjects');
    }

    public function get_Yearlevels()
    {
        $this->db->distinct();
        $this->db->select('YearLevel');
        $query = $this->db->get('semsubjects');
        return $query->result();
    }

    // public function get_subjects_by_yearlevel($YearLevel) {
    //     $this->db->select("semsubjects.*, CONCAT(staff.FirstName, ' ', staff.MiddleName, ' ', staff.LastName) AS Fullname");
    //     $this->db->from('semsubjects');
    //     $this->db->join('staff', 'semsubjects.IDNumber = staff.IDNumber', 'left');
    //     $this->db->where('semsubjects.YearLevel', $YearLevel);
    //     $query = $this->db->get();

    //     return $query->result();
    // }

    // public function get_subjects_by_yearlevel($YearLevel) {
    //     $this->db->select("subjects.*, CONCAT(staff.FirstName, ' ', staff.MiddleName, ' ', staff.LastName) AS Fullname");
    //     $this->db->from('subjects');
    //     $this->db->join('staff', 'subjects.id = staff.IDNumber', 'left');
    //     $this->db->where('subjects.YearLevel', $YearLevel);
    //     $query = $this->db->get();

    //     return $query->result();
    // }



    // public function get_classProgram() {
    // 	$query = $this->db->get('semsubjects'); 
    // 	return $query->result();
    // }


    // public function get_classProgram() {
    //     $this->db->select("semsubjects.*, CONCAT(staff.FirstName, ' ', staff.MiddleName, ' ', staff.LastName) AS Fullname");
    //     $this->db->from('semsubjects');
    //     $this->db->join('staff', 'semsubjects.IDNumber = staff.IDNumber', 'left'); // Left join to include all semsubjects even if no matching staff
    //     $query = $this->db->get();
    //     return $query->result();
    // }


   public function get_subjects_by_yearlevel($YearLevel, $sy, $withTeacher = false)
{
    $this->db->select("semsubjects.*, CONCAT(staff.FirstName, ' ', staff.MiddleName, ' ', staff.LastName) AS Fullname");
    $this->db->from('semsubjects');
    $this->db->join('staff', 'semsubjects.IDNumber = staff.IDNumber', 'left');
    $this->db->where('semsubjects.YearLevel', $YearLevel);
    $this->db->where('semsubjects.SY', $sy);
    $this->onlyWithTeacher($withTeacher);  
    $this->db->order_by('semsubjects.SubjectCode', 'ASC');
    return $this->db->get()->result();
}

   public function get_classProgram($sy, $withTeacher = false)
{
    $this->db->select("semsubjects.*, CONCAT(staff.FirstName, ' ', staff.MiddleName, ' ', staff.LastName) AS Fullname");
    $this->db->from('semsubjects');
    $this->db->join('staff', 'semsubjects.IDNumber = staff.IDNumber', 'left');
    $this->db->where('semsubjects.SY', $sy);
    $this->onlyWithTeacher($withTeacher); 
    $this->db->order_by('semsubjects.SubjectCode', 'ASC');
    return $this->db->get()->result();
}



public function get_subjects_by_yearlevel_strand_semester_section($YearLevel, $Strand, $Semester, $Section, $sy, $withTeacher = false)
{
    $this->db->select("semsubjects.*, CONCAT(staff.FirstName, ' ', staff.MiddleName, ' ', staff.LastName) AS Fullname");
    $this->db->from('semsubjects');
    $this->db->join('staff', 'semsubjects.IDNumber = staff.IDNumber', 'left');
    $this->db->where('semsubjects.YearLevel', $YearLevel);
    $this->db->where('semsubjects.Strand', $Strand);
    $this->db->where('semsubjects.Semester', $Semester);
    if (!empty($Section)) {
        $this->db->where('semsubjects.Section', $Section);
    }
    $this->db->where('semsubjects.SY', $sy);
    $this->onlyWithTeacher($withTeacher);                 // <-- NEW
    $this->db->order_by('semsubjects.SubjectCode', 'ASC');
    return $this->db->get()->result();
}

public function get_subjects_by_yearlevel_section($YearLevel, $Section, $sy, $withTeacher = false)
{
    $this->db->select("semsubjects.*, CONCAT(staff.FirstName, ' ', staff.MiddleName, ' ', staff.LastName) AS Fullname");
    $this->db->from('semsubjects');
    $this->db->join('staff', 'semsubjects.IDNumber = staff.IDNumber', 'left');
    $this->db->where('semsubjects.YearLevel', $YearLevel);
    if (!empty($Section)) {
        $this->db->where('semsubjects.Section', $Section);
    }
    $this->db->where('semsubjects.SY', $sy);
    $this->onlyWithTeacher($withTeacher);                 // <-- NEW
    $this->db->order_by('semsubjects.SubjectCode', 'ASC');
    return $this->db->get()->result();
}



private function onlyWithTeacher($withTeacher)
{
    if ($withTeacher) {
        $this->db->where('semsubjects.IDNumber IS NOT NULL', null, false)
                 ->where('semsubjects.IDNumber !=', '0')
                 ->where("LENGTH(TRIM(semsubjects.IDNumber)) > 0", null, false);

        $this->db->where('staff.IDNumber IS NOT NULL', null, false);
    }
}




public function get_all_sections($sy)
{
    $this->db->distinct();
    $this->db->select('Section');
    $this->db->from('semsubjects');
    $this->db->where('SY', $sy);
    $this->db->where('Section !=', '');
    $this->db->order_by('Section', 'ASC');
    return $this->db->get()->result();
}












    public function insertclass($data)
    {
        return $this->db->insert('semsubjects', $data);
    }






    // public function update_class($subjectid, $SubjectCode, $Description, $Section, $SchedTime, $IDNumber, $SY, $Course, $YearLevel)
    // {
    //     $data = array(
    //         'subjectid' => $subjectid,
    //         'SubjectCode' => $SubjectCode,
    //         'Description' => $Description,
    //         'Section' => $Section,
    //         'SchedTime' => $SchedTime,
    //         'IDNumber' => $IDNumber,
    //         'SY' => $SY,
    //         'YearLevel' => $YearLevel,

    //     );
    //     $this->db->where('subjectid', $subjectid);
    //     $this->db->update('semsubjects', $data);
    // }



    public function update_class($subjectid, $SubjectCode, $Description, $Section, $SchedTime, $IDNumber, $SY, $Course, $YearLevel)
    {
        // Update class program in semsubjects
        $data = array(
            'subjectid' => $subjectid,
            'SubjectCode' => $SubjectCode,
            'Description' => $Description,
            'Section' => $Section,
            'SchedTime' => $SchedTime,
            'IDNumber' => $IDNumber,
            'SY' => $SY,
            'YearLevel' => $YearLevel
        );

        $this->db->where('subjectid', $subjectid);
        $this->db->update('semsubjects', $data);

        // Update registration table where SubjectCode, Description, Section, SY match
        $updateReg = array(
            'IDNumber' => $IDNumber,
            'SchedTime' => $SchedTime,
            'Instructor' => '',
        );

        $this->db->where('SubjectCode', $SubjectCode);
        $this->db->where('Description', $Description);
        $this->db->where('Section', $Section);
        $this->db->where('SY', $SY);
        $this->db->update('registration', $updateReg);
    }
























    public function get_classbyId($subjectid)
    {
        $query = $this->db->query("SELECT * FROM semsubjects WHERE subjectid = '" . $subjectid . "'");
        return $query->result();
    }

    public function Delete_class($subjectid)
    {
        $this->db->where('subjectid', $subjectid);
        $this->db->delete('semsubjects');
    }


public function get_Adviser()
{
    $this->db->select('sections.*, staff.*');
    $this->db->from('sections');
    $this->db->join('staff', 'staff.IDNumber = sections.IDNumber', 'left');
    $this->db->where('sections.SY', $this->session->userdata('sy')); // filter by SY

    $query = $this->db->get();
    return $query->result();
}






    public function insertadviser($data)
    {
        $this->db->insert('sections', $data);
    }

    public function update_Adviser($sectionID, $Section, $IDNumber)
    {
        $data = array(
            'Section' => $Section,
            'IDNumber' => $IDNumber
        );
        $this->db->where('sectionID', $sectionID);
        $this->db->update('sections', $data);
    }



    public function get_adviserbyId($sectionID)
    {
        $query = $this->db->query("SELECT * FROM sections WHERE sections = '" . $sectionID . "'");
        return $query->result();
    }



    public function Delete_adviser($sectionID)
    {
        $this->db->where('sectionID', $sectionID);
        $this->db->delete('sections');
    }



    public function update_Section($sectionID, $Section, $IDNumber)
    {
        $data = array(
            'Section' => $Section,
            'IDNumber' => $IDNumber,

        );
        $this->db->where('sectionID', $sectionID);
        $this->db->update('sections', $data);
    }

    public function Delete_section($sectionID)
    {
        $this->db->where('sectionID', $sectionID);
        $this->db->delete('sections');
    }







    public function get_expenses()
    {
        $query = $this->db->get('expenses');
        return $query->result();
    }

    public function expenses()
    {
        $query = $this->db->get('expenses');
        return $query->result();
    }

    public function insertexpenses($data)
    {
        return $this->db->insert('expenses', $data);
    }



    public function getexpensesbyId($expensesid)
    {
        $query = $this->db->query("SELECT * FROM expenses WHERE expensesid = '" . $expensesid . "'");
        return $query->result();
    }

    public function updateexpenses($expensesid, $Description, $Amount, $Responsible, $ExpenseDate, $Category)
    {
        $data = array(
            'Description' => $Description,
            'Amount' => $Amount,
            'Responsible' => $Responsible,
            'ExpenseDate' => $ExpenseDate,
            'Category' => $Category,



        );
        $this->db->where('expensesid', $expensesid);
        $this->db->update('expenses', $data);
    }

    public function Delete_expenses($expensesid)
    {
        $this->db->where('expensesid', $expensesid);
        $this->db->delete('expenses');
    }


    public function get_expensesCategory()
    {
        $query = $this->db->get('expensescategory');
        return $query->result();
    }

    public function insertexpensesCategory($data)
    {
        return $this->db->insert('expensescategory', $data);
    }

    public function getexpensescategorybyId($categoryID)
    {
        $query = $this->db->query("SELECT * FROM expensescategory WHERE categoryID = '" . $categoryID . "'");
        return $query->result();
    }

    public function updateexpensescategory($categoryID, $Category)
    {
        $data = array(
            'Category' => $Category,
        );
        $this->db->where('categoryID', $categoryID);
        $this->db->update('expensescategory', $data);
    }

    public function Delete_expensescategory($categoryID)
    {
        $this->db->where('categoryID', $categoryID);
        $this->db->delete('expensescategory');
    }


    public function get_categories()
    {
        $this->db->distinct();
        $this->db->select('Category');
        $this->db->from('expenses');
        $query = $this->db->get();
        return $query->result_array(); // Fetches categories as an array
    }


    public function getDescriptionCategories()
    {
        $this->db->distinct();
        $this->db->select('description');
        $query = $this->db->get('paymentsaccounts');
        return $query->result_array();
    }


    public function Payment($SY)
    {
        $this->db->select('paymentsaccounts.*, studeprofile.*');
        $this->db->from('paymentsaccounts');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber');
        $this->db->where('paymentsaccounts.SY', $SY); // Filter by SY
        $this->db->where('paymentsaccounts.CollectionSource', "Student's Account"); // Filter by CollectionSource
        $this->db->where('paymentsaccounts.ORStatus', "Valid");
        $this->db->order_by('studeprofile.LastName', 'ASC');
        $query = $this->db->get();
        return $query->result(); // Return the filtered data
    }


    public function getTodaysPayments($SY, $today)
    {
        $this->db->select('paymentsaccounts.*, studeprofile.*');
        $this->db->from('paymentsaccounts');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber');
        $this->db->where('paymentsaccounts.SY', $SY);
        $this->db->where('paymentsaccounts.CollectionSource', "Student's Account");
        $this->db->where('paymentsaccounts.ORStatus', "Valid");
        $this->db->where('DATE(paymentsaccounts.PDate)', $today); // Filter by today
        $this->db->order_by('studeprofile.LastName', 'ASC');
        return $this->db->get()->result();
    }




    public function services($SY)
    {
        $this->db->select('paymentsaccounts.*, studeprofile.FirstName, studeprofile.MiddleName, studeprofile.LastName');
        $this->db->from('paymentsaccounts');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber', 'left');
        $this->db->where('paymentsaccounts.SY', $SY);
        $this->db->where('paymentsaccounts.CollectionSource', 'Services');
        $query = $this->db->get();
        return $query->result();
    }




    public function void($SY)
    {
        $this->db->select('voidreceipts.ORNumber, voidreceipts.description, voidreceipts.Amount, voidreceipts.voidDate as PDate, voidreceipts.Reasons, studeprofile.FirstName, studeprofile.MiddleName, studeprofile.LastName, paymentsaccounts.ORStatus'); // Added ORStatus
        $this->db->from('voidreceipts');
        $this->db->join('paymentsaccounts', 'paymentsaccounts.ID = voidreceipts.ID');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber');
        $this->db->where('paymentsaccounts.SY', $SY);
        $this->db->where('paymentsaccounts.ORStatus', 'Void');
        $query = $this->db->get();
        return $query->result();
    }




    public function Paymentlist($SY)
    {
        $this->db->select('description, SUM(amount) as total_amount, CollectionSource');
        $this->db->from('paymentsaccounts');
        $this->db->where('SY', $SY); // Apply the SY filter
        $this->db->group_by(['description', 'CollectionSource']); // Group by description and CollectionSource
        $query = $this->db->get();
        return $query->result_array(); // Return as an array for easier handling
    }




    // public function getSummaryData($fromDate, $toDate) {
    //     $this->db->select('description, SUM(amount) as total_amount');
    //     $this->db->from('paymentsaccounts');
    //     $this->db->where('Pdate >=', $fromDate);
    //     $this->db->where('Pdate <=', $toDate);
    //     $this->db->group_by(['description', 'CollectionSource']); // Group by description and CollectionSource
    //     $query = $this->db->get();

    //     return $query->result_array();
    // }









    public function getCollectionReport($description, $collectionSource)
    {
        $this->db->select('paymentsaccounts.*, studeprofile.*');
        $this->db->from('paymentsaccounts');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber');
        $this->db->where('paymentsaccounts.CollectionSource', "Student's Account"); // Filter by CollectionSource
        $this->db->where('paymentsaccounts.ORStatus', "Valid");
        // Apply filters for both description and CollectionSource
        if ($description) {
            $this->db->where('paymentsaccounts.description', $description); // Filter by description
        }

        if ($collectionSource) {
            $this->db->where('paymentsaccounts.CollectionSource', $collectionSource); // Filter by CollectionSource
        }

        $query = $this->db->get();
        return $query->result();
    }



    public function semesterstude()
    {
        $query = $this->db->query("
        SELECT semesterstude.*, studeprofile.*
        FROM semesterstude
        JOIN studeprofile ON semesterstude.StudentNumber = studeprofile.StudentNumber
        GROUP BY semesterstude.StudentNumber
        ORDER BY LastName
    ");
        return $query->result();
    }

    public function getStudentCourse($studentNumber)
    {
        $query = $this->db->select('course')
            ->from('semesterstude')
            ->where('StudentNumber', $studentNumber)
            ->get();

        return $query->row(); // Return a single row with the course
    }


    public function getStudentDetails($studentNumber)
    {
        return $this->db
            ->select('Course, YearLevel')
            ->where('StudentNumber', $studentNumber)
            ->order_by('semstudentid', 'DESC')
            ->limit(1)
            ->get('semesterstude')
            ->row();
    }



    public function getFeeDescriptionsByFilter($course, $yearlevel, $sy)
    {
        return $this->db
            ->select('Description, Amount')
            ->from('feesrecords')
            ->where('Course', $course)
            ->where('YearLevel', $yearlevel)
            ->where('SY', $sy)
            ->where('Amount >', 0) // ✅ exclude zero amount
            ->group_by('Description')
            ->get()
            ->result();
    }



    // public function getFeeDescriptionsByFilter($course, $yearlevel, $sy)
    // {
    //     return $this->db
    //         ->select('Description, Amount')
    //         ->from('feesrecords')
    //         ->where('Course', $course)
    //         ->where('YearLevel', $yearlevel)
    //         ->where('SY', $sy)
    //         ->group_by('Description')
    //         ->get()
    //         ->result();
    // }


    // public function getAcctTotalRow($studentNumber, $sy)
    // {
    //     return $this->db
    //         ->select('AcctTotal')
    //         ->where('StudentNumber', $studentNumber)
    //         ->where('SY', $sy)
    //         ->get('studeaccount')
    //         ->row();
    // }


    public function getAvailableSY()
    {
        return $this->db->distinct()->select('SY')->from('fees')->order_by('SY', 'DESC')->get()->result();
    }



    public function studeaccount()
    {
        $query = $this->db->query("
        SELECT studeaccount.*, studeprofile.*
        FROM studeaccount
        JOIN studeprofile ON studeaccount.StudentNumber = studeprofile.StudentNumber
        GROUP BY studeaccount.StudentNumber
        ORDER BY LastName
    ");
        return $query->result();
    }









    function studeAcc()
    {
        $this->db->distinct();
        $this->db->select('Course');
        $this->db->from('coursefees');
        $this->db->order_by('Course');

        $query = $this->db->get();
        return $query->result();
    }



    function service_descriptions()
    {
        $this->db->select('description');
        $this->db->from('service_descriptions');
        $this->db->order_by('description');

        $query = $this->db->get();
        return $query->result();
    }




    // public function studeAcc() {
    // 	// $query = $this->db->get('studeaccount'); 
    //     $query = $this->db->query("SELECT * FROM studeaccount");
    // 	return $query->result();
    // }

    public function courseTable()
    {
        $query = $this->db->query("SELECT DISTINCT courseid, CourseCode, CourseDescription, Major FROM course_table");
        return $query->result();
    }






    public function user($id)
    {
        $this->db->select('*');
        $this->db->from('o_users');
        $this->db->where('IDNumber', $id);
        $query = $this->db->get();
        return $query->result();
    }


    public function getCollectionReportByDate($from, $to)
    {
        $this->db->select('p.PDate, p.ORNumber, p.Amount, p.description, p.PaymentType, p.Cashier, 
                           s.LastName, s.FirstName, s.MiddleName');
        $this->db->from('paymentsaccounts p');
        $this->db->join('studeprofile s', 's.StudentNumber = p.StudentNumber');
        $this->db->where('p.PDate >=', $from . ' 00:00:00');
        $this->db->where('p.PDate <=', $to . ' 23:59:59');
        $this->db->order_by('p.PDate', 'ASC');
        return $this->db->get()->result();
    }



    public function getLastORNumber()
    {
        $this->db->select('ORNumber');
        $this->db->from('paymentsaccounts');
        $this->db->order_by('ID', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->ORNumber;
        }
        return '1'; // Default starting OR number if no records found
    }



    //     public function getLastORNumber()
    // {
    //     $this->db->select('ID');
    //     $this->db->from('paymentsaccounts');
    //     $this->db->order_by('ID', 'DESC');
    //     $this->db->limit(1);
    //     $query = $this->db->get();

    //     if ($query->num_rows() > 0) {
    //         $lastID = $query->row()->ID;
    //         return $lastID + 1; // Generate next OR based on last ID
    //     }

    //     return 1; // Start at 1 if no records yet
    // }









    // public function getStudentDetails($studentNumber)
    // {
    //     $this->db->select('Course, YearLevel');
    //     $this->db->from('studeaccount'); 
    //     $this->db->where('StudentNumber', $studentNumber);
    //     $query = $this->db->get();

    //     if ($query->num_rows() > 0) {
    //         return $query->row(); // Return the row containing Course and YearLevel
    //     } else {
    //         return null; // Handle this case as needed
    //     }
    // }





    public function CourseFees()
    {
        $query = $this->db->get('fees');
        return $query->result();
    }

    public function updateCourseFeesbyId($feesid)
    {
        $query = $this->db->query("SELECT * FROM fees WHERE feesid = '" . $feesid . "'");
        return $query->result();
    }


    public function getYearLevels()
    {
        // Fetch distinct YearLevel from the fees table
        $this->db->select('YearLevel');
        $this->db->distinct();
        $query = $this->db->get('fees');
        return $query->result();
    }

    // public function getFeesByYearLevel($yearLevel)
    // {
    //     // Fetch fees data based on selected YearLevel
    //     $this->db->where('YearLevel', $yearLevel);
    //     $query = $this->db->get('fees');
    //     return $query->result();
    // }


    public function getFeesByYearLevel($yearLevel)
    {
        // Fetch fees data based on selected YearLevel
        $this->db->where('YearLevel', $yearLevel);
        $query = $this->db->get('fees');
        return $query->result();
    }

    public function getTotalFeesByYearLevel($yearLevel)
    {
        // Get total amount for a specific year level
        $this->db->select_sum('Amount');
        $this->db->where('YearLevel', $yearLevel);
        $query = $this->db->get('fees');
        return $query->row()->Amount;
    }

    public function getTotalFees()
    {
        // Get total amount for all year levels
        $this->db->select_sum('Amount');
        $query = $this->db->get('fees');
        return $query->row()->Amount;
    }



    public function updateFees($feesid, $YearLevel, $Course, $Description, $Amount)
    {
        $data = array(
            'YearLevel' => $YearLevel,
            'Course' => $Course,
            'Description' => $Description,
            'Amount' => $Amount
        );
        $this->db->where('feesid', $feesid);
        $this->db->update('fees', $data);
    }

    public function Deletefees($feesid)
    {
        $this->db->where('feesid', $feesid);
        $this->db->delete('fees');
    }

    public function insertfees($data)
    {
        return $this->db->insert('fees', $data);
    }


    public function getDistinctCourses()
    {
        $this->db->select('DISTINCT(Course)');
        $this->db->from('fees');
        $query = $this->db->get();
        return $query->result();
    }

    public function getDistinctYearLevels()
    {
        $this->db->select('DISTINCT(YearLevel)');
        $this->db->from('fees');
        $query = $this->db->get();
        return $query->result();
    }


    public function get_brand()
    {
        $query = $this->db->get('ls_brands');
        return $query->result();
    }

    public function get_brandbyID($brandID)
    {
        $query = $this->db->query("SELECT * FROM ls_brands WHERE brandID = '" . $brandID . "'");
        return $query->result();
    }

    public function insertBrand($data)
    {
        $this->db->insert('ls_brands', $data);
    }

    public function update_brand($brandID, $brand)
    {
        $data = array(
            'brand' => $brand,
        );
        $this->db->where('brandID', $brandID);
        $this->db->update('ls_brands', $data);
    }

    public function Delete_brand($brandID)
    {
        $this->db->where('brandID', $brandID);
        $this->db->delete('ls_brands');
    }

    public function get_category()
    {
        $query = $this->db->get('ls_categories');
        return $query->result();
    }

    public function get_categorybyID($CatNo)
    {
        $query = $this->db->query("SELECT * FROM ls_categories WHERE CatNo = '" . $CatNo . "'");
        return $query->result();
    }

    public function insertCategory($data)
    {
        $this->db->insert('ls_categories', $data);
    }

    public function update_category($CatNo, $Category, $Sub_category)
    {
        $data = array(
            'Category' => $Category,
            'Sub_category' => $Sub_category,
        );
        $this->db->where('CatNo', $CatNo);
        $this->db->update('ls_categories', $data);
    }

    public function Delete_category($CatNo)
    {
        $this->db->where('CatNo', $CatNo);
        $this->db->delete('ls_categories');
    }


    public function get_office()
    {
        $query = $this->db->get('ls_office');
        return $query->result();
    }

    public function get_officebyID($officeID)
    {
        $query = $this->db->query("SELECT * FROM ls_office WHERE officeID = '" . $officeID . "'");
        return $query->result();
    }

    public function insertOffice($data)
    {
        $this->db->insert('ls_office', $data);
    }

    public function update_office($officeID, $office)
    {
        $data = array(
            'office' => $office,
        );
        $this->db->where('officeID', $officeID);
        $this->db->update('ls_office', $data);
    }

    public function Delete_office($officeID)
    {
        $this->db->where('officeID', $officeID);
        $this->db->delete('ls_office');
    }

    public function getSchoolName()
    {
        $query = $this->db->get('srms_settings_o');
        if ($query->num_rows() > 0) {
            return $query->row()->SchoolName;
        }
        return 'School Records Management System'; // fallback
    }

    function course()
    {
        $this->db->distinct();
        $this->db->select('CourseDescription');
        $this->db->from('course_table');
        $this->db->order_by('CourseDescription');

        $query = $this->db->get();
        return $query->result();
    }


    public function getMajorsByCourse($CourseDescription)
    {
        $this->db->select('Major');
        $this->db->from('course_table');
        $this->db->where('CourseDescription', $CourseDescription);
        $query = $this->db->get();

        return $query->result(); // Return the result as an array
    }

    public function get_strands()
    {
        $this->db->distinct();
        $this->db->select('strand');
        $query = $this->db->get('subjects');
        return $query->result();
    }

    public function get_subjects_by_year_and_strand($yearLevel, $strand)
    {
        $this->db->where('yearLevel', $yearLevel);
        if (!empty($strand)) {
            $this->db->where('strand', $strand);
        }
        $query = $this->db->get('subjects');
        return $query->result();
    }


    public function getStrandsByYear($yearLevel)
    {
        $this->db->distinct();
        $this->db->select('strand');
        $this->db->where('yearLevel', $yearLevel);
        $query = $this->db->get('subjects');
        return $query->result();
    }

    public function get_subjects_by_yearlevel_strand_semester($YearLevel, $Strand, $Semester, $sy)
    {
        $this->db->select("semsubjects.*, CONCAT(staff.FirstName, ' ', staff.MiddleName, ' ', staff.LastName) AS Fullname");
        $this->db->from('semsubjects');
        $this->db->join('staff', 'semsubjects.IDNumber = staff.IDNumber', 'left');
        $this->db->where('semsubjects.YearLevel', $YearLevel);
        $this->db->where('semsubjects.Strand', $Strand);
        $this->db->where('semsubjects.Semester', $Semester);
        $this->db->where('semsubjects.SY', $sy);
        $this->db->order_by('semsubjects.SubjectCode', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }






    // Get fees data based on selected YearLevel and SY
    public function getFeesByYearLevelAndSY($yearLevel, $SY)
    {
        $this->db->where('YearLevel', $yearLevel);
        $this->db->where('SY', $SY); // Filter by logged-in SY
        $query = $this->db->get('fees');
        return $query->result();
    }

    // Get total amount for a specific year level and SY
    public function getTotalFeesByYearLevelAndSY($yearLevel, $SY)
    {
        $this->db->select_sum('Amount');
        $this->db->where('YearLevel', $yearLevel);
        $this->db->where('SY', $SY); // Filter by logged-in SY
        $query = $this->db->get('fees');
        return $query->row()->Amount;
    }

    // Get fees data for the logged-in SY (all year levels)
    public function getCourseFeesBySY($SY)
    {
        $this->db->where('SY', $SY); // Filter by logged-in SY
        $query = $this->db->get('fees');
        return $query->result();
    }

    public function getprofile()
    {
        $this->db->where('*'); // Filter by logged-in SY
        $this->db->Distinct(); // Filter by logged-in SY
        $query = $this->db->get('studeprofile');
        return $query->result();
    }

    // Get total amount for all year levels for the logged-in SY
    public function getTotalFeesBySY($SY)
    {
        $this->db->select_sum('Amount');
        $this->db->where('SY', $SY); // Filter by logged-in SY
        $query = $this->db->get('fees');
        return $query->row()->Amount;
    }


    function track()
    {
        $this->db->distinct();
        $this->db->select('track');
        $this->db->from('track_strand');
        $this->db->order_by('track');

        $query = $this->db->get();
        return $query->result();
    }

    function strand()
    {
        $this->db->distinct();
        $this->db->select('strand');
        $this->db->from('track_strand');
        $this->db->order_by('strand');

        $query = $this->db->get();
        return $query->result();
    }

    function GetSub()
    {
        $this->db->distinct();
        $this->db->select('subjectCode');
        $this->db->from('subjects');
        $this->db->order_by('subjectCode');
        $query = $this->db->get();
        return $query->result();
    }


    function GetSub1()
    {
        $this->db->distinct();
        $this->db->select('description');
        $this->db->from('subjects');
        $this->db->order_by('description');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSub2()
    {
        $this->db->distinct();
        $this->db->select('course');
        $this->db->from('subjects');
        $this->db->order_by('course');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSub3()
    {
        $this->db->distinct();
        $this->db->select('yearLevel');
        $this->db->from('subjects');
        $this->db->order_by('yearLevel');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSection()
    {
        $this->db->distinct();
        $this->db->select('Section');
        $this->db->from('sections');
        $this->db->order_by('Section');
        $query = $this->db->get();
        return $query->result();
    }

        function GetStrandSub()
    {
        $this->db->distinct();
        $this->db->select('strand');
        $this->db->from('subjects');
        $this->db->order_by('strand');
        $query = $this->db->get();
        return $query->result();
    }


    // public function get_subjects_by_yearlevel1($yearLevel)
    // {
    //     $this->db->distinct();  // Ensures unique rows
    //     $this->db->select('subjects.SubjectCode, subjects.Description, sections.Section');
    //     $this->db->from('subjects');
    //     $this->db->join('sections', 'subjects.yearLevel = sections.YearLevel', 'left');
    //     $this->db->where('subjects.yearLevel', $yearLevel);
    //     $this->db->group_by(['subjects.SubjectCode', 'subjects.Description']); // Group by SubjectCode and Description
    //     $query = $this->db->get();
    //     return $query->result();
    // }
public function get_subject($id)
{
    return $this->db->where('id', $id)->get('subjects')->row();
}

public function update_subject($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('subjects', $data);
}

public function update_related_tables($oldCode, $newCode, $newDesc)
{
    // semsubjects
    $this->db->where('SubjectCode', $oldCode)
             ->update('semsubjects', [
                 'SubjectCode' => $newCode,
                 'Description' => $newDesc
             ]);

    // registration
    $this->db->where('SubjectCode', $oldCode)
             ->update('registration', [
                 'SubjectCode' => $newCode,
                 'Description' => $newDesc
             ]);

    // grades
    $this->db->where('SubjectCode', $oldCode)
             ->update('grades', [
                 'SubjectCode' => $newCode,
                 'Description' => $newDesc
             ]);
}





    // public function get_subjects_by_yearlevel1($yearLevel)
    // {
    //     $this->db->select('subjectCode, description'); // Corrected: use a single string
    //     $this->db->from('subjects');
    //     $this->db->where('yearLevel', $yearLevel); // No need for 'subjects.' prefix
    //     $query = $this->db->get();
    //     return $query->result();
    // }



    public function get_subjects_by_yearlevel1($yearLevel)
    {
        $this->db->select('subjectCode, description');
        $this->db->from('subjects');
        $this->db->where('yearLevel', $yearLevel);
        $this->db->order_by('subjectCode', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_subjects_by_yearlevel4($strand)
    {
        $this->db->select('subjectCode, description');
        $this->db->from('subjects');
        $this->db->where('strand', $strand);
        $this->db->order_by('subjectCode', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_subjects_by_yearlevel3($sem)
    {
        $this->db->select('subjectCode, description');
        $this->db->from('subjects');
        $this->db->where('sem', $sem);
        $this->db->order_by('subjectCode', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    public function get_subjects_by_yearlevel_strand_sem($yearLevel, $strand, $sem)
    {
        $this->db->select('subjectCode, description, id, Adviser');
        $this->db->from('subjects');
        $this->db->where('yearLevel', $yearLevel);
        $this->db->where('strand', $strand);
        $this->db->where('sem', $sem);
        $this->db->order_by('subjectCode', 'ASC');

        $query = $this->db->get();

        // Log the query for debugging
        log_message('debug', 'SQL Query: ' . $this->db->last_query());

        return $query->result();
    }



    // public function get_payment()
    // {
    //     // First, get ORNumbers from the 'voidreceipts' table
    //     $voided_ORNumbers = $this->db->select('ORNumber')
    //         ->from('voidreceipts')
    //         ->get()
    //         ->result_array();

    //     // Extract ORNumbers into an array
    //     $voided_ORNumbers = array_column($voided_ORNumbers, 'ORNumber');

    //     // Now query 'paymentsaccounts' for records from the last 7 days excluding voided ORNumbers
    //     $this->db->select('*');
    //     $this->db->from('paymentsaccounts');
    //     $this->db->where('pDate >=', date('Y-m-d', strtotime('-7 days')));

    //     // Exclude ORNumbers found in voidreceipts
    //     if (!empty($voided_ORNumbers)) {
    //         $this->db->where_not_in('ORNumber', $voided_ORNumbers);
    //     }

    //     $query = $this->db->get();
    //     return $query->result();
    // }



    public function get_payment()
    {
        // First, get ORNumbers from the 'voidreceipts' table
        $voided_ORNumbers = $this->db->select('ORNumber')
            ->from('voidreceipts')
            ->get()
            ->result_array();

        // Extract ORNumbers into an array
        $voided_ORNumbers = array_column($voided_ORNumbers, 'ORNumber');

        // Query 'paymentsaccounts' excluding voided ORNumbers
        $this->db->select('*');
        $this->db->from('paymentsaccounts');

        // Exclude voided ORNumbers
        if (!empty($voided_ORNumbers)) {
            $this->db->where_not_in('ORNumber', $voided_ORNumbers);
        }

        $query = $this->db->get();
        return $query->result();
    }



    public function get_payment1()
    {
        $this->db->select('Cashier');
        $this->db->from('paymentsaccounts');
        $query = $this->db->get();
        return $query->row(); // Return a single record as an object
    }


    // public function getPaymentDetailsByORNumber($ORNumber)
    // {
    //     $this->db->select('*');
    //     $this->db->from('paymentsaccounts');
    //     $this->db->where('ORNumber', $ORNumber);
    //     $query = $this->db->get();

    //     return $query->row();
    // }

    public function getPaymentDetailsByORNumber($ORNumber)
    {
        $this->db->select('paymentsaccounts.*, studeprofile.FirstName, studeprofile.MiddleName, studeprofile.LastName');
        $this->db->from('paymentsaccounts');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber');
        $this->db->where('paymentsaccounts.ORNumber', $ORNumber);
        $query = $this->db->get();

        return $query->row();
    }




    public function getPaymentById($id)
    {
        $this->db->select('paymentsaccounts.*, studeprofile.FirstName, studeprofile.MiddleName, studeprofile.LastName');
        $this->db->from('paymentsaccounts');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber');
        $this->db->where('paymentsaccounts.ID', $id);
        $query = $this->db->get();

        return $query->row();
    }






    public function updatePayment($id, $description, $customOR, $PDate, $Amount, $CheckNumber, $Bank, $PaymentType)
    {
        $data = array(
            'description' => $description,
            'ORNumber' => $customOR,
            'PDate' => $PDate,
            'Amount' => $Amount,
            'CheckNumber' => $CheckNumber,
            'Bank' => $Bank,
            'PaymentType' => $PaymentType,



        );
        $this->db->where('id', $id);
        $this->db->update('paymentsaccounts', $data);
    }









    public function get_sections_by_yearlevel($yearLevel)
    {
        $this->db->select('Section');
        $this->db->from('sections');
        $this->db->where('YearLevel', $yearLevel);
        $this->db->order_by('Section', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getTotalFeesGroupedByYearLevel($SY)
    {
        $this->db->select('YearLevel, SUM(Amount) as total_amount');
        $this->db->from('fees');
        $this->db->where('SY', $SY);
        $this->db->group_by('YearLevel');
        $query = $this->db->get();
        return $query->result_array();
    }




    public function checkClassExists($yearLevel, $subjectCode, $section, $SY)
    {
        $this->db->where('YearLevel', $yearLevel);
        $this->db->where('SubjectCode', $subjectCode);
        $this->db->where('Section', $section);
        $this->db->where('SY', $SY);
        $query = $this->db->get('semsubjects');

        // Log the generated SQL query to debug if it's working correctly
        log_message('debug', 'SQL Query: ' . $this->db->last_query());

        return $query->num_rows() > 0; // Returns true if a record exists
    }


    // In the SettingsModel
    public function checkClassExistsWithStrandSemester($yearLevel, $subjectCode, $section, $SY, $strand, $Semester)
    {
        $this->db->where('YearLevel', $yearLevel);
        $this->db->where('SubjectCode', $subjectCode);
        $this->db->where('Section', $section);
        $this->db->where('SY', $SY);

        // Check for Grade 11 and Grade 12
        if ($yearLevel === 'Grade 11' || $yearLevel === 'Grade 12') {
            $this->db->where('strand', $strand);
            $this->db->where('Semester', $Semester);
        }

        $query = $this->db->get('semsubjects');

        // Log the generated SQL query to debug if it's working correctly
        log_message('debug', 'SQL Query: ' . $this->db->last_query());

        return $query->num_rows() > 0; // Returns true if a record exists
    }




    public function get_subjects_by_yearlevel2($yearLevel)
    {
        $this->db->where('YearLevel', $yearLevel);
        $this->db->order_by('SubjectCode', 'ASC'); // Sort by Subject Code
        return $this->db->get('subjects')->result();
    }



    // Get the current TotalPayments for a student
    public function getTotalPayments($studentNumber)
    {
        $this->db->select('TotalPayments');
        $this->db->from('studeaccount'); // Ensure this table exists
        $this->db->where('StudentNumber', $studentNumber);
        $query = $this->db->get();
        $result = $query->row();

        return $result ? $result->TotalPayments : 0;
    }

    // Update the TotalPayments for a student
    public function updateTotalPayments($studentNumber, $newTotal)
    {
        $this->db->set('TotalPayments', $newTotal);
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->update('studeaccount');
    }



    public function insertpaymentsaccounts($data)
    {
        return $this->db->insert('paymentsaccounts', $data);
    }


    public function updateORStatus($ORNumber, $ORStatus, $voidData = [])
    {
        // Update the ORStatus in paymentsaccounts
        $this->db->set('ORStatus', $ORStatus);
        $this->db->where('ORNumber', $ORNumber);
        $updateResult = $this->db->update('paymentsaccounts');

        if ($updateResult) {
            // Ensure 'ID' is provided
            if (!isset($voidData['ID'])) {
                // Handle missing ID, possibly log an error
                log_message('error', 'ID is missing in voidData when inserting into voidreceipts.');
                return false;
            }

            // Prepare data for insertion into voidreceipts
            $voidReceiptData = [
                'ID' => $voidData['ID'],
                'ORNumber' => $ORNumber,
                'Amount' => $voidData['amount'],
                'PaymentDate' => $voidData['pDate'],
                'Description' => $voidData['description'],
                'VoidDate' => $voidData['voidDate'],
                'Cashier' => $voidData['cashier'],
                'Reasons' => $voidData['Reasons'],
                'VoidedBy' => $voidData['voidedBy'] ?? null // insert voidedBy
            ];


            // Insert into voidreceipts table
            $insertResult = $this->db->insert('voidreceipts', $voidReceiptData);

            if (!$insertResult) {
                // Handle insertion error, possibly log
                log_message('error', 'Failed to insert into voidreceipts: ' . $this->db->error()['message']);
                return false;
            }
        }

        return $updateResult;
    }


    public function get_all_voided()
    {
        $this->db->select('voidreceipts.ORNumber, voidreceipts.description, voidreceipts.Amount, voidreceipts.voidDate as PDate, voidreceipts.Reasons, voidreceipts.VoidedBy, studeprofile.FirstName, studeprofile.MiddleName, studeprofile.LastName, paymentsaccounts.ORStatus');
        $this->db->from('voidreceipts');
        $this->db->join('paymentsaccounts', 'paymentsaccounts.ID = voidreceipts.ID');
        $this->db->join('studeprofile', 'studeprofile.StudentNumber = paymentsaccounts.StudentNumber');
        $this->db->where('paymentsaccounts.ORStatus', 'Void');
        $query = $this->db->get();
        return $query->result();
    }




    // public function getTotalPayments1($studentNumber, $SY) {
    //     $this->db->select('SUM(Amount) as TotalPayments');
    //     $this->db->from('paymentsaccounts');
    //     $this->db->where('StudentNumber', $studentNumber);
    //     $this->db->where('SY', $SY);

    //     // Include only "Student's Account" and explicitly exclude "Services"
    //     $this->db->group_start();
    //     $this->db->where('CollectionSource', "Student's Account");
    //     $this->db->or_where('CollectionSource IS NULL'); // Handle potential null values
    //     $this->db->group_end();

    //     $result = $this->db->get()->row();

    //     return $result->TotalPayments ?? 0;
    // }


    // public function getAmountPaid1($studentNumber, $SY) {
    //     $this->db->select_sum('Amount'); // Assuming 'Amount' is the column name for payment amount
    //     $this->db->where('StudentNumber', $studentNumber);
    //     $this->db->where('SY', $SY);  // Ensure it matches the current SY
    // 	$this->db->where('CollectionSource !=', 'Services'); // Tyrone
    //     $query = $this->db->get('paymentsaccounts'); // Replace with your actual payments table name
    //     return $query->row()->Amount ?? 0; // Return the sum or 0 if no payments found
    // }


    // public function getTotalPayments1($studentNumber, $SY) {
    //     $this->db->select_sum('Amount'); // Assuming 'Amount' is the column name for payment amount
    //     $this->db->where('StudentNumber', $studentNumber);
    //     $this->db->where('SY', $SY);  
    //     $this->db->where('CollectionSource !=', 'Services'); // Exclude 'Services' payments
    //     $query = $this->db->get('paymentsaccounts');
    //     return $query->row()->Amount ?? 0; // Return the sum or 0 if no payments found
    // }


    public function getTotalPayments1($studentNumber, $SY)
    {
        $this->db->select_sum('Amount', 'TotalAmount');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $SY);
        $this->db->where('CollectionSource !=', 'Services');
        $this->db->where('ORStatus !=', 'Void');
        $query = $this->db->get('paymentsaccounts');

        // Ensure it returns 0 if no result is found
        return (float) ($query->row()->TotalAmount ?? 0);
    }


    public function calculateTotalPayments($studentNumber, $SY)
    {
        $this->db->select_sum('Amount');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $SY);
        $query = $this->db->get('paymentsaccounts');

        if ($query->num_rows() > 0) {
            return (float)$query->row()->Amount; // Return the sum of payments
        }

        return 0; // Return 0 if no payments exist
    }



    public function getCurrentBalance($studentNumber, $SY)
    {
        $this->db->select('CurrentBalance');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $SY);
        return (float) ($this->db->get('studeaccount')->row()->CurrentBalance ?? 0);
    }

    public function getDiscount($studentNumber, $SY)
    {
        $this->db->select('Discount');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $SY);
        return (float) ($this->db->get('studeaccount')->row()->Discount ?? 0);
    }

    public function getAcctTotal($studentNumber, $SY)
    {
        $this->db->select('AcctTotal');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $SY);

        $result = $this->db->get('studeaccount')->row();

        // Ensure it returns 0 if no result is found
        return (float) ($result->AcctTotal ?? 0);
    }

    public function updateStudentAccount($studentNumber, $newTotalPayments, $newBalance, $SY)
    {
        $data = [
            'TotalPayments' => $newTotalPayments,
            'CurrentBalance' => $newBalance
        ];

        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $SY);

        $success = $this->db->update('studeaccount', $data);

        if (!$success) {
            log_message('error', "Failed to update studeaccount for Student {$studentNumber}, SY {$SY}");
            return false;
        }

        return true;
    }



    public function isORNumberExists($ORNumber)
    {
        $this->db->where('ORNumber', $ORNumber);
        $query = $this->db->get('paymentsaccounts');
        return $query->num_rows() > 0;
    }



public function getTrackStrandsByYearLevel($yearLevel)
{
    // Pull the digits (e.g., "Grade 11" -> "11")
    $n = preg_replace('/\D+/', '', (string)$yearLevel);

    $this->db->select('DISTINCT TRIM(strand) AS strand', false);
    $this->db->from('subjects');

    if ($n === '11' || $n === '12') {
        // Match any stored variant that contains 11/12
        $this->db->like('yearLevel', $n);
    } else {
        $this->db->where('yearLevel', $yearLevel);
    }

    $this->db->where("TRIM(strand) <>", "");
    $this->db->order_by('strand', 'ASC');

    return $this->db->get()->result(); // objects with ->strand
}

    public function getSemByYearLevel($yearLevel)
    {
        $this->db->distinct(); // Add DISTINCT clause
        $this->db->select('sem');
        $this->db->from('subjects');
        $this->db->where('yearLevel', $yearLevel);
        $this->db->order_by('sem', 'ASC');
        $query = $this->db->get();

        // Return only if there are results
        return $query->num_rows() > 0 ? $query->result() : [];
    }


    public function getFilteredSubjects($filters)
    {
        $this->db->select('*');
        $this->db->from('subjects');
        if (isset($filters['yearLevel'])) {
            $this->db->where('yearLevel', $filters['yearLevel']);
        }
        if (isset($filters['strand'])) {
            $this->db->where('strand', $filters['strand']);
        }
        if (isset($filters['sem'])) {
            $this->db->where('sem', $filters['sem']);
        }
        $query = $this->db->get();
        return $query->result();
    }



    public function updateTrackStrand($trackID, $yearLevel, $sem, $track, $strand)
    {
        $data = array(
            'yearLevel' => $yearLevel,
            'sem' => $sem,
            'track' => $track,
            'strand' => $strand
        );
        $this->db->where('trackID', $trackID);
        $this->db->update('track_strand_table', $data); // Replace 'track_strand_table' with your table name
    }


    public function grade_view($sy)
    {
        $this->db->select('*');
        $this->db->from('registration');
        $this->db->where('SY', $sy); // Filter by School Year
$this->db->group_by(['SubjectCode', 'Description']);
        $query = $this->db->get();
        return $query->result();
    }




    function getSchoolInformation()
    {
        $query = $this->db->query("select * from srms_settings_o");
        return $query->result();
    }

    public function checkMonthlyScheduleExists($studentNumber, $sy)
    {
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $sy);
        $query = $this->db->get('monthly_payment_schedule');
        return $query->num_rows() > 0;
    }

    public function insertMonthlySchedule($data)
    {
        $this->db->insert('monthly_payment_schedule', $data);
    }


    public function getSuperAdminbyId($settingsID)
    {
        $query = $this->db->query("SELECT * FROM srms_settings_o WHERE settingsID = '" . $settingsID . "'");
        return $query->result();
    }


    public function updateSuperAdmin($settingsID, $data)
    {
        $this->db->where('settingsID', $settingsID);
        $this->db->update('srms_settings_o', $data);
    }


    public function get_settings()
    {
        return $this->db->get('srms_settings_o')->row_array();
    }

    public function update_settings($data)
    {
        return $this->db->update('srms_settings_o', $data);
    }


    public function get_grade_display()
    {
        $query = $this->db->get('srms_settings_o');
        if ($query->num_rows() > 0) {
            return $query->row()->gradeDisplay;
        }
        return 'Numeric'; // default fallback
    }

    
public function update_setting_field($field, $value)
{
    $allowedFields = ['schoolType', 'gradeDisplay', 'preschoolGrade'];
    if (!in_array($field, $allowedFields, true)) {
        return false;
    }

    // Small whitelist for values
    $allowedValues = [
        'schoolType'     => ['Public', 'Private'],
        'gradeDisplay'   => ['Numeric', 'Letter'],
        'preschoolGrade' => ['Numeric', 'Letter'],
    ];
    if (!in_array($value, $allowedValues[$field], true)) {
        return false;
    }

    $this->db->where('settingsID', 1);
    return $this->db->update('srms_settings_o', [$field => $value]);
}



    // public function updateMonthlyScheduleWithPayments($studentNumber, $sy)
    // {
    //     // Get all monthly schedule entries for the student and SY
    //     $this->db->where('StudentNumber', $studentNumber);
    //     $this->db->where('SY', $sy);
    //     $schedules = $this->db->get('monthly_payment_schedule')->result();

    //     foreach ($schedules as $row) {
    //         $monthStart = date('Y-m-01', strtotime($row->month_due));
    //         $monthEnd = date('Y-m-t', strtotime($row->month_due));

    //         // Get total payments made in this month
    //         $this->db->select_sum('Amount');
    //         $this->db->from('paymentsaccounts');
    //         $this->db->where('StudentNumber', $studentNumber);
    //         $this->db->where('SY', $sy);
    //         $this->db->where("PDate >=", $monthStart);
    //         $this->db->where("PDate <=", $monthEnd);
    //         $paidAmount = $this->db->get()->row()->Amount ?? 0;

    //         // Calculate new remaining amount and status
    //         $newAmount = max($row->amount - $paidAmount, 0);
    //         $newStatus = ($newAmount <= 0) ? 'Paid' : 'Pending';

    //         // Update the monthly_payment_schedule row
    //         $this->db->where('monID', $row->monID);
    //         $this->db->update('monthly_payment_schedule', [
    //             'amount' => $newAmount,
    //             'status' => $newStatus
    //         ]);
    //     }
    // }
    // public function applyLatestPaymentToMonthlySchedule($studentNumber, $sy, $latestAmount, $latestPDate)
    // {
    //     $this->db->where('StudentNumber', $studentNumber);
    //     $this->db->where('SY', $sy);
    //     $this->db->order_by('month_due', 'asc');
    //     $schedules = $this->db->get('monthly_payment_schedule')->result();

    //     if (!$schedules) return;

    //     $remaining = $latestAmount; // ✅ Always start from only the incoming payment

    //     foreach ($schedules as $row) {
    //         if ($remaining <= 0) break;

    //         $monID = $row->monID;
    //         $amountDue = (float)$row->amount;

    //         if ($amountDue <= 0 || $row->status == 'Paid') continue; // ✅ Skip already paid months

    //         if ($remaining >= $amountDue) {
    //             $this->db->where('monID', $monID);
    //             $this->db->update('monthly_payment_schedule', [
    //                 'amount' => 0,
    //                 'status' => 'Paid'
    //             ]);
    //             $remaining -= $amountDue;
    //         } else {
    //             $this->db->where('monID', $monID);
    //             $this->db->update('monthly_payment_schedule', [
    //                 'amount' => $amountDue - $remaining,
    //                 'status' => 'Pending'
    //             ]);
    //             $remaining = 0;
    //         }
    //     }
    // }


    public function get_all_durations()
    {
        return $this->db->order_by('durationDate', 'ASC')->get('monthly_payment_schedule_set')->result();
    }
    public function get_grouped_durations()
    {
        $query = $this->db->query("
        SELECT 
            MIN(durationOrder) AS start_order,
            MAX(durationOrder) AS end_order,
            COUNT(*) AS month_count,
            batch_id
        FROM monthly_payment_schedule_set
        GROUP BY batch_id
        ORDER BY MIN(durationOrder)
    ");

        $results = $query->result();

        // Convert dates to "Month Year" format for display
        foreach ($results as &$row) {
            $row->start_month = date('F Y', strtotime($row->start_order));
            $row->end_month = date('F Y', strtotime($row->end_order));
        }

        return $results;
    }




    public function getMonthlyDuration()
    {
        return $this->db->select('durationOrder')
            ->order_by('durationOrder', 'ASC')
            ->get('monthly_payment_schedule_set')
            ->result();
    }






    public function getExistingORForToday($studentNumber, $date)
    {
        $this->db->select('ORNumber');
        $this->db->from('paymentsaccounts');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('PDate', $date);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->ORNumber;
        }
        return false;
    }


    public function getStudentsWithPayments($SY)
    {
        $this->db->select('DISTINCT(StudentNumber)', FALSE);
        $this->db->from('paymentsaccounts');
        $this->db->where('SY', $SY);
        $this->db->order_by('StudentNumber', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }


    public function getPaymentsByStudent($studentNumber, $SY)
    {
        $this->db->from('paymentsaccounts');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $SY);
        $this->db->order_by('PDate', 'ASC'); // Earliest to latest
        $query = $this->db->get();

        return $query->result();
    }


    public function getFirstPaymentAmount($studentNumber, $sy)
    {
        return $this->db
            ->select('Amount')
            ->where('StudentNumber', $studentNumber)
            ->where('SY', $sy)
            ->order_by('PDate', 'ASC')
            ->limit(1)
            ->get('paymentsaccounts')
            ->row()
            ->Amount ?? 0;
    }



    public function get_grouped_durations_assesment()
    {
        $this->db->order_by('durationOrder', 'ASC');
        return $this->db->get('monthly_payment_schedule_set')->result();
    }



    public function getYearLevel($studentNumber, $SY)
    {
        $this->db->select('YearLevel');
        $this->db->where('StudentNumber', $studentNumber);
        $this->db->where('SY', $SY);
        $query = $this->db->get('registration');
        $result = $query->row();
        return $result ? $result->YearLevel : '';
    }



    public function get_active_settings()
    {
        $this->db->limit(1);
        return $this->db->get('srms_settings_o')->row(); // Assumes table `settings` has `preschoolGrade` column
    }


    // Get all service descriptions
    public function getServiceDescriptions()
    {
        return $this->db->get('service_descriptions')->result();
    }

    // Insert new description
    public function insertServiceDescription($data)
    {
        return $this->db->insert('service_descriptions', $data);
    }

    // Update description
    public function updateServiceDescription($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('service_descriptions', $data);
    }

    // Delete description
    public function deleteServiceDescription($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('service_descriptions');
    }

    // Get single record by ID
    public function getServiceDescriptionById($id)
    {
        return $this->db->get_where('service_descriptions', ['id' => $id])->row();
    }




public function get_lock_schedule($sy)
{
    return $this->db->get_where('grade_lock_schedule', [
        'SY' => $sy
    ])->row();
}


public function save_lock_schedule($data)
{
    $existing = $this->db->get_where('grade_lock_schedule', [
        'SY' => $data['SY']
    ])->row();

    if ($existing) {
$this->db->where('schedID', $existing->schedID)->update('grade_lock_schedule', $data);
    } else {
        $this->db->insert('grade_lock_schedule', $data);
    }
}






















public function isTxnRefExists(string $ref): bool
{
    return (bool) $this->db->select('1', false)
        ->from('paymentsaccounts')
        ->where('transaction_ref', $ref)
        ->limit(1)->get()->num_rows();
}

/**
 * Return next daily sequence for the given date.
 * Implementation A (simple): COUNT existing rows for that date.
 * Implementation B (safer): read MAX(seq) from a separate counter table.
 * Below is Implementation A for simplicity.
 */
public function getNextTxnSeqForDate(string $dateYmd): int
{
    // Count rows sharing same date on PDate (or created_at if you have)
    $cnt = (int) $this->db->from('paymentsaccounts')
        ->where('PDate', $dateYmd)
        ->count_all_results();
    // Next is count+1
    return $cnt + 1;
}




























// Count how many payments exist for a student & SY
public function countPaymentsForSY($studentNumber, $sy)
{
    return (int)$this->db->where('StudentNumber', $studentNumber)
        ->where('SY', $sy)
        ->count_all_results('paymentsaccounts');
}

/**
 * Re-distribute the remaining balance evenly across existing monthly_payment_schedule rows.
 * This does not create new rows; it uses what's already in the table for that student+SY.
 * Any month with new 0 becomes 'Paid'; others 'Pending'.
 */
// public function redistributeMonthlyScheduleEvenly($studentNumber, $sy, $remainingBalance)
// {
//     // Get months for this student/SY ordered ascending
//     $months = $this->db->select('monID, month_due')
//         ->from('monthly_payment_schedule')
//         ->where('StudentNumber', $studentNumber)
//         ->where('SY', $sy)
//         ->order_by('month_due', 'ASC')
//         ->get()->result();

//     if (empty($months)) return;

//     $n = count($months);
//     if ($remainingBalance <= 0) {
//         // mark all as paid (0)
//         foreach ($months as $m) {
//             $this->db->where('monID', $m->monID)->update('monthly_payment_schedule', [
//                 'amount' => 0,
//                 'status' => 'Paid'
//             ]);
//         }
//         return;
//     }

//     // Even split, rounded to cents; put rounding remainder on last month
//     $base = floor(($remainingBalance / $n) * 100) / 100.0;
//     $sum  = 0.0;
//     foreach ($months as $idx => $m) {
//         $val = ($idx === $n - 1) ? round($remainingBalance - $sum, 2) : $base;
//         $sum += $val;
//         $this->db->where('monID', $m->monID)->update('monthly_payment_schedule', [
//             'amount' => $val,
//             'status' => $val <= 0 ? 'Paid' : 'Pending'
//         ]);
//     }
// }

/**
 * Add back (increase) the amount due for the specific month of $pdate (YYYY-MM-DD).
 * If “giveBack” is 0, no-op. This only affects that one month.
 */
// public function addBackToMonth($studentNumber, $sy, $pdate, $giveBack)
// {
//     $giveBack = (float)$giveBack;
//     if ($giveBack <= 0) return;

//     $firstOfMonth = date('Y-m-01', strtotime($pdate));
//     $lastOfMonth  = date('Y-m-t',  strtotime($pdate));

//     // Find the month row for this month
//     $row = $this->db->select('monID, amount')
//         ->from('monthly_payment_schedule')
//         ->where('StudentNumber', $studentNumber)
//         ->where('SY', $sy)
//         ->where('month_due >=', $firstOfMonth)
//         ->where('month_due <=', $lastOfMonth)
//         ->limit(1)
//         ->get()->row();

//     if (!$row) return;

//     $newAmount = round(((float)$row->amount + $giveBack), 2);

//     $this->db->where('monID', $row->monID)->update('monthly_payment_schedule', [
//         'amount' => $newAmount,
//         'status' => ($newAmount <= 0 ? 'Paid' : 'Pending')
//     ]);
// }

public function getPaymentsByDateRange($sy, $from, $to)
{
    // Adjust the SELECT/JOINs to match your current getTodaysPayments()
    $this->db->select('pa.*, sp.StudentNumber, sp.LastName, sp.FirstName, sp.MiddleName');
    $this->db->from('paymentsaccounts pa');
    $this->db->join('studeprofile sp', 'sp.StudentNumber = pa.StudentNumber', 'left');
    $this->db->where('pa.SY', $sy);
    $this->db->where('pa.PDate >=', $from);
    $this->db->where('pa.PDate <=', $to);
    $this->db->order_by('pa.PDate', 'ASC');
    $this->db->order_by('pa.ID', 'DESC');
    return $this->db->get()->result();
}












/**
 * Deduct an amount from the schedule starting at PDate's month forward.
 * Greedy consume: zero-out months, mark Paid when amount reaches 0.
 */
public function applyLatestPaymentToMonthlySchedule($studentNumber, $SY, $amount, $PDate)
{
    if ($amount <= 0) return 0;

    $anchor = date('Y-m-01', strtotime($PDate));

    $rows = $this->db->select('*')
        ->from('monthly_payment_schedule')
        ->where('StudentNumber', $studentNumber)
        ->where('SY', $SY)
        ->where('month_due >=', $anchor)
        ->order_by('month_due', 'ASC')
        ->get()->result();

    $affected = 0;
    foreach ($rows as $r) {
        $due = (float)$r->amount;

        // already paid or zero? skip
        if ($due <= 0) {
            if ($r->status !== 'Paid') {
                $this->db->where('monID', $r->monID)->update('monthly_payment_schedule', ['status' => 'Paid']);
                $affected++;
            }
            continue;
        }

        if ($amount >= $due) {
            // fully cover this month
            $this->db->where('monID', $r->monID)->update('monthly_payment_schedule', [
                'amount' => 0.00,
                'status' => 'Paid'
            ]);
            $amount -= $due;
            $affected++;
        } else {
            // partially cover this month
            $newAmt = round($due - $amount, 2);
            $this->db->where('monID', $r->monID)->update('monthly_payment_schedule', [
                'amount' => $newAmt,
                'status' => ($newAmt <= 0 ? 'Paid' : 'Pending')
            ]);
            $affected++;
            $amount = 0;
            break;
        }
    }

    // If there is still leftover amount after last month, nothing else to consume.
    return $affected;
}

/**
 * Add back (refund) to the month of PDate only.
 * Increase 'amount' and set status to Pending.
 */
public function addBackToMonth($studentNumber, $SY, $PDate, $amountToAddBack)
{
    if ($amountToAddBack <= 0) return 0;

    $monthStart = date('Y-m-01', strtotime($PDate));
    $row = $this->db->select('*')
        ->from('monthly_payment_schedule')
        ->where('StudentNumber', $studentNumber)
        ->where('SY', $SY)
        ->where('month_due', $monthStart)
        ->get()->row();

    if (!$row) return 0;

    $newAmt = round(((float)$row->amount) + $amountToAddBack, 2);

    $this->db->where('monID', $row->monID)->update('monthly_payment_schedule', [
        'amount' => $newAmt,
        'status' => ($newAmt <= 0 ? 'Paid' : 'Pending')
    ]);

    return 1;
}

/**
 * Even redistribution helper (you already call this elsewhere).
 * Ensures all pending months are evenly set from a remaining balance.
 */
public function redistributeMonthlyScheduleEvenly($studentNumber, $SY, $remaining)
{
    $rows = $this->db->select('*')
        ->from('monthly_payment_schedule')
        ->where('StudentNumber', $studentNumber)
        ->where('SY', $SY)
        ->order_by('month_due', 'ASC')
        ->get()->result();

    if (!$rows) return 0;

    $n = count($rows);
    if ($n == 0) return 0;

    $per = round($remaining / $n, 2);
    $affected = 0;

    foreach ($rows as $r) {
        $status = ($per <= 0 ? 'Paid' : 'Pending');
        $this->db->where('monID', $r->monID)->update('monthly_payment_schedule', [
            'amount' => max($per, 0.00),
            'status' => $status
        ]);
        $affected++;
    }
    return $affected;
}




























public function applyPaymentOldestFirst($studentNumber, $SY, $amount)
{
    if ($amount <= 0) return 0;

    $rows = $this->db->select('*')
        ->from('monthly_payment_schedule')
        ->where('StudentNumber', $studentNumber)
        ->where('SY', $SY)
        ->order_by('month_due', 'ASC')
        ->get()->result();

    $affected = 0;

    foreach ($rows as $r) {
        if ($amount <= 0) break;

        $due = (float)$r->amount;

        // If zero but not marked Paid, fix status; else skip
        if ($due <= 0) {
            if ($r->status !== 'Paid') {
                $this->db->where('monID', $r->monID)
                         ->update('monthly_payment_schedule', ['status' => 'Paid']);
                $affected++;
            }
            continue;
        }

        if ($amount >= $due) {
            // fully cover this month
            $this->db->where('monID', $r->monID)->update('monthly_payment_schedule', [
                'amount' => 0.00,
                'status' => 'Paid'
            ]);
            $amount -= $due;
            $affected++;
        } else {
            // partially cover this month
            $newAmt = round($due - $amount, 2);
            $this->db->where('monID', $r->monID)->update('monthly_payment_schedule', [
                'amount' => $newAmt,
                'status' => ($newAmt <= 0 ? 'Paid' : 'Pending')
            ]);
            $amount = 0;
            $affected++;
            break;
        }
    }

    return $affected;
}

/**
 * Add back (refund) to the OLDEST month only (increase amount, mark Pending).
 * Example: month was 200 Pending; reduce payment by 300 -> month becomes 500 Pending.
 */
public function addBackOldestFirst($studentNumber, $SY, $amountToAddBack)
{
    if ($amountToAddBack <= 0) return 0;

    $row = $this->db->select('*')
        ->from('monthly_payment_schedule')
        ->where('StudentNumber', $studentNumber)
        ->where('SY', $SY)
        ->order_by('month_due', 'ASC')
        ->limit(1)
        ->get()->row();

    if (!$row) return 0;

    $newAmt = round(((float)$row->amount) + $amountToAddBack, 2);

    $this->db->where('monID', $row->monID)->update('monthly_payment_schedule', [
        'amount' => $newAmt,
        'status' => ($newAmt <= 0 ? 'Paid' : 'Pending')
    ]);

    return 1;
}







public function txnRefExists($ref)
{
    return $this->db->select('1', false)
        ->from('paymentsaccounts')
        ->where('transaction_ref', $ref)
        ->limit(1)
        ->get()->num_rows() > 0;
}





// --- Add these helpers ---

public function getDistinctYearLevelsForSY($sy)
{
    // Pull only non-empty, non-zero YearLevels present for the active SY
    return $this->db->select('YearLevel')
        ->from('semsubjects')
        ->where('SY', $sy)
        ->where('YearLevel !=', '')
        ->where('YearLevel !=', '0')
        ->group_by('YearLevel')
        ->order_by('YearLevel', 'ASC')
        ->get()->result();
}

public function getSectionsByYearLevelSY($yearLevel, $sy)
{
    $this->db->select('Section')
        ->from('semsubjects')
        ->where('SY', $sy);

    if ($yearLevel !== '') {
        $this->db->where('YearLevel', $yearLevel);
    }

    return $this->db->where('Section !=', '')
        ->where('Section !=', '0')
        ->group_by('Section')
        ->order_by('Section', 'ASC')
        ->get()->result();
}

public function getStrandsByYearLevelSY($yearLevel, $sy)
{
    return $this->db->select('Strand')
        ->from('semsubjects')
        ->where('SY', $sy)
        ->where('YearLevel', $yearLevel)
        ->where('Strand !=', '')
        ->where('Strand !=', '0')
        ->group_by('Strand')
        ->order_by('Strand', 'ASC')
        ->get()->result();
}


}
