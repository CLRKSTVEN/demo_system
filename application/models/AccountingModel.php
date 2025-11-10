<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AccountingModel extends CI_Model
{
    /** Distinct course list (from course_table.CourseDescription) */
  public function getAllCourses()
{
    // DISTINCT TRIM() to collapse duplicates like "BSIT" and "BSIT "
    $sql = "
        SELECT DISTINCT TRIM(CourseDescription) AS CourseDescription
        FROM course_table
        WHERE CourseDescription IS NOT NULL
          AND TRIM(CourseDescription) <> ''
        ORDER BY CourseDescription ASC
    ";
    return $this->db->query($sql)->result();
}

/** Distinct Year Levels (normalized) for a given SY + Course */
public function getYearLevelsForCourse($sy, $courseDesc)
{
    // DISTINCT TRIM() to avoid dupes like "1st Year" vs "1st Year "
    $sql = "
        SELECT DISTINCT TRIM(YearLevel) AS YearLevel
        FROM semesterstude
        WHERE SY = ?
          AND Course = ?
          AND YearLevel IS NOT NULL
          AND TRIM(YearLevel) <> ''
        ORDER BY YearLevel ASC
    ";
    return $this->db->query($sql, [$sy, $courseDesc])->result();
}

    /**
     * One row per student for selected SY, Course, YearLevel and Month (YYYY-MM).
     * (Same logic as before, but without Major.)
     */
public function getMonthStatusPerStudent($sy, $yyyymm, $courseDesc, $yearLevel)
{
    $start = date('Y-m-01', strtotime($yyyymm . '-01'));
    $end   = date('Y-m-t',  strtotime($start));

    $this->db->select("
        ss.StudentNumber,
        ss.Course,
        ss.YearLevel,
        sp.FirstName, sp.MiddleName, sp.LastName,
        SUM(mps.amount) AS schedule_due
    ", false);

    $this->db->from('semesterstude ss');

    // Filters
    $this->db->where('ss.SY', $sy);
    $this->db->where('ss.Course', $courseDesc);
    $this->db->where('ss.YearLevel', $yearLevel);

    // Names
    $this->db->join(
        'studeprofile sp',
        'sp.StudentNumber = ss.StudentNumber',
        'left',
        false
    );

    // Monthly schedule
    $this->db->join(
        'monthly_payment_schedule mps',
        'mps.StudentNumber = ss.StudentNumber
         AND mps.SY = ss.SY
         AND mps.month_due BETWEEN '.$this->db->escape($start).' AND '.$this->db->escape($end),
        'inner',
        false
    );

    // Still owing this month
    $this->db->where('COALESCE(mps.amount,0) > 0', null, false);
    $this->db->where('(mps.status = "Pending" OR mps.status IS NULL)', null, false);

    $this->db->group_by('ss.StudentNumber, ss.Course, ss.YearLevel, sp.FirstName, sp.MiddleName, sp.LastName');
    $this->db->order_by('ss.StudentNumber', 'ASC');

    $rows = $this->db->get()->result();

    foreach ($rows as $r) {
        $r->month_status   = 'Pending';
        $r->payments_month = 0;
    }
    return $rows;
}





/**
 * Save the currently displayed pending list into overdue_candidates.
 * We recompute the list server-side for the given filters to ensure integrity.
 * Upsert on (SY, Month, StudentNumber).
 */
public function saveOverdueCandidates($sy, $yyyymm, $courseDesc, $yearLevel, $createdBy = null)
{
    // get the same rows the page shows
    $rows = $this->getMonthStatusPerStudent($sy, $yyyymm, $courseDesc, $yearLevel);
    if (empty($rows)) return 0;

    $monthDate = date('Y-m-01', strtotime($yyyymm . '-01'));

    // Build a single INSERT ... ON DUPLICATE KEY UPDATE
    $values = [];
    $params = [];
    foreach ($rows as $r) {
        $values[] = "(?,?,?,?,?,?,?,NOW(),NOW())";
        $params[] = $sy;
        $params[] = $monthDate;
        $params[] = $r->StudentNumber;
        $params[] = $r->Course ?: '';
        $params[] = $r->YearLevel ?: '';
        $params[] = number_format((float)$r->schedule_due, 2, '.', '');
        $params[] = $createdBy; // may be null
    }

    $sql = "
        INSERT INTO overdue_candidates
            (SY, Month, StudentNumber, Course, YearLevel, Amount, created_by, created_at, updated_at)
        VALUES " . implode(',', $values) . "
        ON DUPLICATE KEY UPDATE
            Course = VALUES(Course),
            YearLevel = VALUES(YearLevel),
            Amount = VALUES(Amount),
            updated_at = NOW()
    ";

    $this->db->query($sql, $params);
    return $this->db->affected_rows(); // counts inserted + updated rows
}




public function isOverdueCandidate($studentNumber, $sy)
{
    $studentNumber = trim((string)$studentNumber);
    $sy            = trim((string)$sy);
    if ($studentNumber === '' || $sy === '') return false;

    $sql = "
        SELECT 1
        FROM overdue_candidates
        WHERE SY = ?
          AND LOWER(TRIM(StudentNumber)) = LOWER(TRIM(?))
          AND Amount > 0
        LIMIT 1
    ";
    $q = $this->db->query($sql, [$sy, $studentNumber]);
    return ($q && $q->num_rows() > 0);
}


public function getOverdueMonthsForStudent($studentNumber, $sy)
{
    $studentNumber = trim((string)$studentNumber);
    $sy            = trim((string)$sy);
    if ($studentNumber === '' || $sy === '') return [];

    $sql = "
        SELECT DISTINCT Month
        FROM overdue_candidates
        WHERE SY = ?
          AND LOWER(TRIM(StudentNumber)) = LOWER(TRIM(?))
          AND Amount > 0
        ORDER BY Month ASC
    ";
    return $this->db->query($sql, [$sy, $studentNumber])->result();
}


public function getOverdueMonthLabelsForStudent($studentNumber, $sy)
{
    $rows = $this->getOverdueMonthsForStudent($studentNumber, $sy);
    $labels = [];
    foreach ($rows as $r) {
        $ts = strtotime($r->Month);
        if ($ts) $labels[] = date('F Y', $ts);
    }
    return $labels;
}



















// ==== LIVE pending total for a student+SY+month (first day) from monthly_payment_schedule
public function liveMonthPendingAmount($studentNumber, $sy, $monthFirst)
{
    if (!$studentNumber || !$sy || !$monthFirst) return 0.0;

    $sql = "
        SELECT COALESCE(SUM(CASE
            WHEN (m.status IS NULL OR m.status = 'Pending') THEN COALESCE(m.amount,0)
            ELSE 0
        END), 0) AS total_pending
        FROM monthly_payment_schedule m
        WHERE m.StudentNumber = ?
          AND m.SY            = ?
          AND DATE_FORMAT(m.month_due, '%Y-%m-01') = DATE_FORMAT(?, '%Y-%m-01')
    ";
    $row = $this->db->query($sql, [$studentNumber, $sy, $monthFirst])->row();
    return (float)($row->total_pending ?? 0);
}

/**
 * Sync ONE overdue_candidates row to the current value in monthly_payment_schedule.
 * - If total > 0 -> update Amount
 * - If total == 0 -> delete row from overdue_candidates
 * Returns affected rows (update/delete).
 */
public function syncOverdueRow($sy, $studentNumber, $monthFirst)
{
    $total = $this->liveMonthPendingAmount($studentNumber, $sy, $monthFirst);

    if ($total > 0) {
        $this->db->where('SY', $sy)
                 ->where('Month', $monthFirst)
                 ->where('StudentNumber', $studentNumber)
                 ->update('overdue_candidates', [
                     'Amount'     => number_format($total, 2, '.', ''),
                     'updated_at' => date('Y-m-d H:i:s'),
                 ]);
        return $this->db->affected_rows();
    } else {
        // fully paid now; remove the snapshot
        $this->db->delete('overdue_candidates', [
            'SY'            => $sy,
            'Month'         => $monthFirst,
            'StudentNumber' => $studentNumber
        ]);
        return $this->db->affected_rows();
    }
}

/**
 * Batch sync for a filter you already use on your Overdues page (SY + Course + YearLevel + Month).
 * It:
 *  - Finds overdue_candidates for that SY + Month (monthFirst).
 *  - Optionally narrows by Course/YearLevel via semesterstude (same semester roster you filter on).
 *  - Recomputes live totals from monthly_payment_schedule and updates/deletes rows accordingly.
 */
public function syncOverdueForFilters($sy, $yyyymm, $courseDesc, $yearLevel)
{
    $monthFirst = date('Y-m-01', strtotime($yyyymm . '-01'));
    $params = [$sy, $monthFirst, $courseDesc, $yearLevel];

    $sql = "
        SELECT oc.StudentNumber, oc.SY, oc.Month
        FROM overdue_candidates oc
        INNER JOIN semesterstude ss
            ON ss.StudentNumber = oc.StudentNumber
           AND ss.SY = oc.SY
        WHERE oc.SY = ?
          AND oc.Month = ?
          AND ss.Course = ?
          AND ss.YearLevel = ?
    ";
    $rows = $this->db->query($sql, $params)->result();
    $affected = 0;
    foreach ($rows as $r) {
        $affected += $this->syncOverdueRow($r->SY, $r->StudentNumber, $r->Month);
    }
    return $affected;
}

/**
 * Optional: sync ALL existing overdue_candidates for a given student+SY (used on login/dashboard).
 * Good when you want to be sure the flag is fresh without touching monthly_payment_schedule writes.
 */
public function syncOverdueForStudentSY($studentNumber, $sy)
{
    $q = $this->db->select('Month')
                  ->from('overdue_candidates')
                  ->where('SY', $sy)
                  ->where('LOWER(TRIM(StudentNumber)) =', strtolower(trim($studentNumber)))
                  ->get();
    $rows = $q->result();
    $affected = 0;
    foreach ($rows as $r) {
        $affected += $this->syncOverdueRow($sy, $studentNumber, $r->Month);
    }
    return $affected;
}











/**
 * Mirror a single candidate row (SY + StudentNumber + Month) from
 * monthly_payment_schedule. Month is a date like 'YYYY-MM-01'.
 * Returns affected rows (0/1).
 */
public function syncCandidateFromSchedule($studentNumber, $sy, $monthDate)
{
    $studentNumber = trim((string)$studentNumber);
    $sy            = trim((string)$sy);
    $monthDate     = trim((string)$monthDate);
    if ($studentNumber === '' || $sy === '' || $monthDate === '') return 0;

    // Calculate month window
    $start = date('Y-m-01', strtotime($monthDate));
    $end   = date('Y-m-t',  strtotime($start));

    // Sum current 'amount' (remaining) for this month from monthly_payment_schedule
    $sumRow = $this->db->select('COALESCE(SUM(amount),0) AS amt', false)
        ->from('monthly_payment_schedule')
        ->where('StudentNumber', $studentNumber)
        ->where('SY', $sy)
        ->where('month_due >=', $start)
        ->where('month_due <=', $end)
        ->get()->row();

    $newAmount = (float)($sumRow ? $sumRow->amt : 0);

    // Update the candidate row if it exists
    $this->db->where('SY', $sy)
             ->where('StudentNumber', $studentNumber)
             ->where('Month', $start) // we store Month as the 1st of the month
             ->update('overdue_candidates', [
                 'Amount'     => number_format($newAmount, 2, '.', ''),
                 'updated_at' => date('Y-m-d H:i:s'),
             ]);

    return $this->db->affected_rows();
}

/**
 * Find all candidate months for a student+SY and sync each one
 * from monthly_payment_schedule. Returns total updated rows.
 */
public function syncAllCandidatesForStudentSY($studentNumber, $sy)
{
    $studentNumber = trim((string)$studentNumber);
    $sy            = trim((string)$sy);
    if ($studentNumber === '' || $sy === '') return 0;

    $rows = $this->db->select('Month')
        ->from('overdue_candidates')
        ->where('SY', $sy)
        ->where('StudentNumber', $studentNumber)
        ->get()->result();

    $updated = 0;
    foreach ($rows as $r) {
        $updated += (int) $this->syncCandidateFromSchedule($studentNumber, $sy, $r->Month);
    }
    return $updated;
}





















 public function getAnchorStudeAccountRow($student, $sy)
    {
        return $this->db->where('StudentNumber', $student)
                        ->where('SY', $sy)
                        ->order_by('AccountID','ASC')
                        ->limit(1)->get('studeaccount')->row();
    }

    // if no studeaccount exists yet, try to infer course/yearlevel
    public function inferAnchorRow($student, $sy)
    {
        // 1) semesterstude (preferred)
        $q = $this->db->select('Course as Course, YearLevel as YearLevel, Semester as Sem, Section, "Enrolled" as Status, 1 as settingsID', FALSE)
                      ->where('StudentNumber', $student)
                      ->where('SY', $sy)
                      ->limit(1)->get('semesterstude');
        if ($q->num_rows()) return $q->row();

        // 2) last known semesterstude (any SY)
        $q = $this->db->select('Course, YearLevel, Semester as Sem, Section, "Enrolled" as Status, 1 as settingsID', FALSE)
                      ->where('StudentNumber', $student)
                      ->order_by('semstudentid','DESC')->limit(1)
                      ->get('semesterstude');
        if ($q->num_rows()) return $q->row();

        // 3) fallback minimal (only Course not guaranteed)
        return (object)[
            'Course'     => '',
            'YearLevel'  => '',
            'Sem'        => '',
            'Section'    => '',
            'Status'     => 'Enrolled',
            'settingsID' => 1,
        ];
    }

    // ——— fee catalog ———
    public function getFeesByCYLSY($course, $yearLevel, $sy)
    {
        return $this->db->where('Course', $course)
                        ->where('YearLevel', $yearLevel)
                        ->where('SY', $sy)
                        ->order_by('Description','ASC')
                        ->get('fees')->result();
    }

    // does a studeaccount fee row already exist?
    public function findStudeAcctFeeRow($student, $sy, $desc)
    {
        return $this->db->where('StudentNumber', $student)
                        ->where('SY', $sy)
                        ->where('FeesDesc', $desc)
                        ->limit(1)->get('studeaccount')->row();
    }

    // sums
    public function sumBaseFees($student, $sy)
    {
        $q = $this->db->select_sum('FeesAmount', 't')->get_where('studeaccount', [
            'StudentNumber' => $student, 'SY' => $sy
        ]);
        return (float)($q->row()->t ?? 0);
    }

    public function sumAdditional($student, $sy)
    {
        $q = $this->db->select_sum('add_amount', 't')->get_where('studeadditional', [
            'StudentNumber' => $student, 'SY' => $sy
        ]);
        return (float)($q->row()->t ?? 0);
    }

    public function sumDiscounts($student, $sy)
    {
        $q = $this->db->select_sum('discount_amount', 't')->get_where('studediscount', [
            'StudentNumber' => $student, 'SY' => $sy
        ]);
        return (float)($q->row()->t ?? 0);
    }

    public function sumPayments($student, $sy)
    {
        // ignore void/cancelled ORs if you use those statuses
        $this->db->select_sum('Amount', 't')
                 ->where('StudentNumber', $student)
                 ->where('SY', $sy)
                 ->group_start()
                   ->where('ORStatus =', '')
                   ->or_where('ORStatus IS NULL', NULL, FALSE)
                   ->or_where_not_in('ORStatus', ['VOID','Void','CANCELLED','Cancelled'])
                 ->group_end();
        $q = $this->db->get('paymentsaccounts');
        return (float)($q->row()->t ?? 0);
    }













}
