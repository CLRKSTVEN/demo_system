<?php
class InstructorModel extends CI_Model
{

    public function facultyLoad($id, $sy)
    {
        // Load the database library if not already loaded
        $this->load->database();

        // Use the Query Builder class to build the query
        $this->db->select('*');
        $this->db->from('semsubjects s');
        $this->db->join('staff sf', 's.IDNumber = sf.IDNumber');
        $this->db->where('s.IDNumber', $id);
        $this->db->where('s.SY', $sy);
        $this->db->order_by('s.SubjectCode');

        // Execute the query and return the result
        $query = $this->db->get();
        return $query->result();
    }
 
    public function facultyMasterlist($id, $sy, $section, $yearLevel)
    {
        $this->load->database();

        $this->db->select('p.StudentNumber, CONCAT(p.LastName, ", ", p.FirstName) AS StudentName, MID(p.MiddleName, 1) AS MiddleName, p.Sex, r.Course, r.YearLevel, r.Section, p.MobileNumber');
        $this->db->from('studeprofile p');
        $this->db->join('registration r', 'p.StudentNumber = r.StudentNumber');
        $this->db->where('r.IDNumber', $id);
        $this->db->where('r.SY', $sy);
        $this->db->where('r.Section', $section);
        $this->db->where('r.YearLevel', $yearLevel);

        $strand = $this->input->get('strand');
        if (!empty($strand)) {
            $this->db->where('r.strand', $strand);
        }

        $this->db->group_by('p.StudentNumber');

// Replace your sex ORDER BY with this:
$this->db->order_by("
  CASE
    WHEN UPPER(TRIM(COALESCE(p.Sex, ''))) = 'MALE'   THEN 0
    WHEN UPPER(TRIM(COALESCE(p.Sex, ''))) = 'FEMALE' THEN 1
    ELSE 2
  END
", 'ASC', FALSE);
        $this->db->order_by('p.LastName', 'ASC');
        $this->db->order_by('p.FirstName', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

public function subjectGrades($id, $sy, $section, $subjectcode, $Description)
{
    $this->load->database();

    $this->db->select([
        'g.gradeID',
        'p.StudentNumber',
        'CONCAT(p.LastName, ", ", p.FirstName) AS StudentName',
        'MID(p.MiddleName, 1) AS MiddleName',
        'p.Sex',

        'g.SubjectCode',
        'g.Description',
        'g.Instructor',
        'g.Section',

        // numeric grades
        'g.PGrade','g.MGrade','g.PFinalGrade','g.FGrade','g.Average',

        // ✅ letter grades (needed by the view)
        'g.l_p','g.l_m','g.l_pf','g.l_f','g.l_average',

        'g.Sem','g.SY'
    ]);
    $this->db->from('studeprofile p');
    $this->db->join('grades g', 'p.StudentNumber = g.StudentNumber', 'inner');

    $this->db->where('g.SubjectCode', $subjectcode);
    $this->db->where('g.Description', $Description);
    $this->db->where('g.SY', $sy);
    $this->db->where('g.Section', $section);
    $this->db->where('g.Instructor', $id);

    // Sort males first, then females, then others; then by name
    $this->db->order_by("CASE WHEN p.Sex = 'Male' THEN 0 WHEN p.Sex = 'Female' THEN 1 ELSE 2 END", 'ASC');
    $this->db->order_by('p.LastName', 'ASC');
    $this->db->order_by('p.FirstName', 'ASC');

    return $this->db->get()->result();
}




    public function gradingSheets($instructor, $sy, $sem)
    {
        // Load the database library if not already loaded
        $this->load->database();

        // Use the Query Builder class to build the query
        $this->db->select('*');
        $this->db->from('grades');
        $this->db->where('Instructor', $instructor);
        $this->db->where('Semester', $sem);
        $this->db->where('SY', $sy);
        $this->db->group_by(['SubjectCode', 'Section']);

        // Execute the query and return the result
        $query = $this->db->get();
        return $query->result();
    }

    public function gradessUploading($record)
    {
        if (!empty($record)) {

            // Get input values from the form
            $period = $this->input->post('period');
            $subjectCode = $this->input->post('subjectCode');
            $description = $this->input->post('description');
            $section = $this->input->post('section');
            $id = $this->session->userdata('fname') . ' ' . $this->session->userdata('lname');
            $sy = $this->session->userdata('sy');

            // Initialize the newGrades array
            $newGrades = array(
                "StudentNumber" => trim($record[0]),
                "SubjectCode" => trim($subjectCode),
                "Description" => trim($description),
                "Section" => trim($section),
                "Instructor" => trim($id),
                "SY" => trim($sy),
            );

            // Set the grade key based on the period
            switch ($period) {
                case '1st':
                    $newGrades["PGrade"] = trim($record[2]);
                    // Perform insert for '1st' period
                    $this->db->insert('grades', $newGrades);
                    break;
                case '2nd':
                    $newGrades["MGrade"] = trim($record[2]);
                    // Perform update for '2nd' period
                    $this->updateGrade($newGrades);
                    break;
                case '3rd':
                    $newGrades["PFinalGrade"] = trim($record[2]);
                    // Perform update for '3rd' period
                    $this->updateGrade($newGrades);
                    break;
                case '4th':
                    $newGrades["FGrade"] = trim($record[2]);
                    // Perform update for '4th' period
                    $this->updateGrade($newGrades);
                    break;
                default:
                    // Handle unexpected period values if necessary
                    break;
            }
        }
    }

    private function updateGrade($newGrades)
    {
        // Assuming StudentNumber, SubjectCode, and SY uniquely identify a record
        $this->db->where('StudentNumber', $newGrades['StudentNumber']);
        $this->db->where('SubjectCode', $newGrades['SubjectCode']);
        $this->db->where('SY', $newGrades['SY']);

        // Update the existing record with the new grade information
        $this->db->update('grades', $newGrades);
    }




     private function _semester_variants($sem)
    {
        $s = strtolower(trim((string)$sem));

        // Default to "any" if session value is empty
        if ($s === '' || $s === 'all' || $s === 'any') {
            return []; // no filter
        }

        // Heuristics
        $is_first  = (strpos($s, '1') !== false) || (strpos($s, 'first') !== false);
        $is_second = (strpos($s, '2') !== false) || (strpos($s, 'second') !== false);

        if ($is_first && !$is_second) {
            return [
                'First Semester','FIRST SEMESTER','first semester',
                'First Sem','FIRST SEM','first sem',
                '1st Semester','1ST SEMESTER','1st semester',
                '1st Sem','1ST SEM','1st sem',
                'Sem 1','Semester 1','1'
            ];
        }
        if ($is_second && !$is_first) {
            return [
                'Second Semester','SECOND SEMESTER','second semester',
                'Second Sem','SECOND SEM','second sem',
                '2nd Semester','2ND SEMESTER','2nd semester',
                '2nd Sem','2ND SEM','2nd sem',
                'Sem 2','Semester 2','2'
            ];
        }

        // Fallback: try both if ambiguous
        return [
            // first
            'First Semester','first semester','First Sem','first sem','1st Semester','1st semester','1st Sem','1st sem','Sem 1','Semester 1','1',
            // second
            'Second Semester','second semester','Second Sem','second sem','2nd Semester','2nd semester','2nd Sem','2nd sem','Sem 2','Semester 2','2',
        ];
    }

    /** Common semester where clause—applies tolerant WHERE only when variants found. */
    private function _apply_semester_filter($sem)
    {
        $variants = $this->_semester_variants($sem);
        if (!empty($variants)) {
            $this->db->group_start();
            $this->db->where_in('Semester', $variants);
            // plus a forgiving LIKE in case of uncommon wording
            $kw = (strpos(strtolower($variants[0]), 'first') !== false || strpos($variants[0], '1') !== false) ? 'first' : 'second';
            $this->db->or_like('Semester', $kw, 'both');
            $this->db->group_end();
        }
        // if empty variants → no filter (accept any semester)
    }

    /** Natural order for YearLevel (Grade 7..12 → 1st Yr..4th Yr fallback → else alpha) */
  private function _order_by_yearlevel()
{
    $this->db->order_by("
        CASE
          WHEN YearLevel LIKE 'Grade 7%'  THEN 7
          WHEN YearLevel LIKE 'Grade 8%'  THEN 8
          WHEN YearLevel LIKE 'Grade 9%'  THEN 9
          WHEN YearLevel LIKE 'Grade 10%' THEN 10
          WHEN YearLevel LIKE 'Grade 11%' THEN 11
          WHEN YearLevel LIKE 'Grade 12%' THEN 12
          WHEN YearLevel LIKE '1st%'      THEN 13
          WHEN YearLevel LIKE '2nd%'      THEN 14
          WHEN YearLevel LIKE '3rd%'      THEN 15
          WHEN YearLevel LIKE '4th%'      THEN 16
          ELSE 99
        END
    ", '', false);  // ✅ use empty string, not null
}


    /** Sections handled uniformly for JHS/SHS; no strand constraint */
    public function get_instructor_sections($idNumber, $sy, $sem)
    {
        $this->db->distinct();
        $this->db->select('Section, YearLevel');
        $this->db->from('semsubjects');
        $this->db->where('IDNumber', $idNumber);
        $this->db->where('SY', $sy);

        // Tolerant semester filter (handles "First Semester" vs "1st Semester", etc.)
        $this->_apply_semester_filter($sem);

        // Require non-null, non-empty Section
        $this->db->where('Section IS NOT NULL', null, false);
        $this->db->where("TRIM(Section) <>", '');

        // Nice ordering: by YearLevel (natural) then Section
        $this->_order_by_yearlevel();
        $this->db->order_by('Section', 'ASC');

        return $this->db->get()->result();
    }

    /** Subjects handled uniformly for JHS/SHS; no strand constraint */
    public function get_instructor_subjects($idNumber, $sy, $sem)
    {
        $this->db->distinct();
        $this->db->select('Section, SubjectCode, Description');
        $this->db->from('semsubjects');
        $this->db->where('IDNumber', $idNumber);
        $this->db->where('SY', $sy);

        // Tolerant semester filter
        $this->_apply_semester_filter($sem);

        // Require non-null, non-empty fields
        $this->db->where('Section IS NOT NULL', null, false);
        $this->db->where("TRIM(Section) <>", '');
        $this->db->where('SubjectCode IS NOT NULL', null, false);
        $this->db->where("TRIM(SubjectCode) <>", '');

        // Order: YearLevel natural → Section → SubjectCode
        $this->_order_by_yearlevel();
        $this->db->order_by('Section', 'ASC');
        $this->db->order_by('SubjectCode', 'ASC');

        return $this->db->get()->result();
    }





    /**
 * Rank students for a given subject/section by the selected basis.
 *
 * @param string  $idNumber        Instructor ID (username) to match against grades.IDNumber or grades.Instructor (if $useInstructor)
 * @param string  $sy              School Year (e.g., '2025-2026')
 * @param string  $sem             Semester (not strictly used here; ranking is by SY/Section/SubjectCode; keep for signature parity)
 * @param string  $section         Section label (exact string used in grades.Section)
 * @param string  $subjectcode     Subject code (grades.SubjectCode)
 * @param string  $description     Subject description (grades.Description), may be empty
 * @param string  $basis           One of: Average|PGrade|MGrade|PFinalGrade|FGrade
 * @param int     $top_n           0 for all; otherwise LIMIT N
 * @param boolean $useInstructor   If true, filter by instructor
 * @param boolean $useDescription  If true and $description not empty, filter by Description too
 * @return array  of stdClass rows compatible with your view
 */
public function subjectGradesRanking(
    $idNumber,
    $sy,
    $sem,
    $section,
    $subjectcode,
    $description,
    $basis = 'Average',
    $top_n = 0,
    $useInstructor = true,
    $useDescription = true
) {
    // Ensure valid basis
    $basis = in_array($basis, ['Average','PGrade','MGrade','PFinalGrade','FGrade'], true) ? $basis : 'Average';

    // Compute Average from available quarters when g.Average is null
    $avgExpr = "
        CASE
          WHEN ( (g.PGrade IS NOT NULL) + (g.MGrade IS NOT NULL) + (g.PFinalGrade IS NOT NULL) + (g.FGrade IS NOT NULL) ) > 0
          THEN (
            COALESCE(g.PGrade,0) + COALESCE(g.MGrade,0) + COALESCE(g.PFinalGrade,0) + COALESCE(g.FGrade,0)
          ) / NULLIF(
            ( (g.PGrade IS NOT NULL) + (g.MGrade IS NOT NULL) + (g.PFinalGrade IS NOT NULL) + (g.FGrade IS NOT NULL) )
          ,0)
          ELSE NULL
        END
    ";

    // Score based on basis
    $scoreExpr = ($basis === 'Average')
        ? "COALESCE(g.Average, $avgExpr)"
        : "g.$basis";

    // SELECT
    $this->db->select("
        g.StudentNumber,
        sp.FirstName,
        sp.MiddleName,
        sp.LastName,
        CONCAT(sp.LastName, ', ', sp.FirstName) AS StudentName,
        g.PGrade,
        g.MGrade,
        g.PFinalGrade,
        g.FGrade,
        COALESCE(g.Average, $avgExpr) AS Average,
        $scoreExpr AS Score
    ", false);

    $this->db->from('grades AS g');
    $this->db->join('studeprofile AS sp', 'sp.StudentNumber = g.StudentNumber', 'left');

    // Join semsubjects to access the teacher IDNumber (no description join to avoid over-filtering)
    $this->db->join('semsubjects AS ss',
        "ss.SY = g.SY AND ss.Section = g.Section AND ss.SubjectCode = g.SubjectCode",
        'left'
    );

    // Base filters
    $this->db->where('g.SY', $sy);
    $this->db->where('g.Section', $section);
    $this->db->where('g.SubjectCode', $subjectcode);

    // Optional Description (exact match only when explicitly requested)
    if ($useDescription && $description !== '') {
        $this->db->where('g.Description', $description);
    }

    // Instructor filter:
    //  - Prefer ss.IDNumber (official mapping in semsubjects)
    //  - Also allow g.Instructor to equal the id (some data sets store ID/name there)
    if ($useInstructor && $idNumber !== '') {
        $this->db->group_start()
                 ->where('ss.IDNumber', $idNumber)
                 ->or_where('g.Instructor', $idNumber)
                 ->group_end();
    }

    // If you want to also respect semester here, uncomment this tolerant filter block:
    // (Only if you already added _apply_semester_filter() helper in this model)
    /*
    if (method_exists($this, '_apply_semester_filter')) {
        $this->_apply_semester_filter($sem);
    }
    */

    // Group & Order
    $this->db->group_by([
        'g.StudentNumber',
        'sp.FirstName',
        'sp.MiddleName',
        'sp.LastName',
        'g.PGrade',
        'g.MGrade',
        'g.PFinalGrade',
        'g.FGrade',
        'g.Average'
    ]);

    $this->db->order_by('Score', 'DESC');
    $this->db->order_by('Average', 'DESC');
    $this->db->order_by('sp.LastName', 'ASC');
    $this->db->order_by('sp.FirstName', 'ASC');

    if ((int)$top_n > 0) {
        $this->db->limit((int)$top_n);
    }

    return $this->db->get()->result();
}


}
