<?php
// Safely extract attendance records and chunks
$attendanceData = isset($attendance['records']) && is_array($attendance['records']) ? $attendance['records'] : [];
$dateChunks = isset($attendance['chunks']) && is_array($attendance['chunks']) ? $attendance['chunks'] : [];

// Safely merge dates (only if $dateChunks is not empty)
$allDates = !empty($dateChunks) ? array_merge(...$dateChunks) : [];

// Build day labels (e.g., M, T, W)
$dayLabels = [];
foreach ($allDates as $date) {
    $dayLabels[] = strtoupper(date('D', strtotime($date)))[0];
}

// Group students by sex, with checks
$groupedStudents = ['Male' => [], 'Female' => []];
if (!empty($students) && is_array($students)) {
    foreach ($students as $stude) {
        $sex = ucfirst(strtolower($stude->Sex));
        $groupedStudents[$sex][] = $stude;
    }
}

// Safely access school and section info
$school = !empty($schoolinfo) && isset($schoolinfo[0]) ? $schoolinfo[0] : (object)[];
$sectionInfo = !empty($sectioninfo) && isset($sectioninfo[0]) ? $sectioninfo[0] : (object)[];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>SF2 - Daily Attendance Report of Learners</title>
  <style>
    @page { size: A4 landscape; margin: 10mm; }
    @media print {
      .page-break { page-break-before: always; }
    }
    body { font-family: Arial, sans-serif; font-size: 9px; margin: 0; padding: 0; }
    .container { padding: 10mm; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 2px; text-align: center; }
    .info-table td { text-align: left; padding: 3px 5px; }
    .guidelines, .codes, .summary { display: inline-block; vertical-align: top; font-size: 9px; box-sizing: border-box; }
    .guidelines { width: 42%; padding-right: 10px; }
    .codes { width: 30%; border: 1px solid #000; padding: 5px; }
    .summary { width: 26%; }
    .summary-table { width: 100%; font-size: 9px; }
    .summary-table td, .summary-table th { border: 1px solid #000; padding: 3px; text-align: center; }
    .footer-cert { margin-top: 10px; }
    .footer-sign { display: flex; justify-content: space-between; margin-top: 10px; }
    .footer-sign div { width: 48%; text-align: center; }
    .page-footer { margin-top: 10px; font-size: 9px; }
    .logo { width: 60px; height: auto; }
    .info-table input {
      border: 1px solid black;
      padding: 2px;
      width: 100%;
      box-sizing: border-box;
    }
  </style>
</head>
<body>
<div class="container">
  <table class="info-header">
    <tr>
      <td rowspan="2" class="logo-left">
        <img src="<?= base_url('assets/images/deped.png') ?>" width="60">
      </td>
      <td colspan="5" class="title-block">
        School Form 2 (SF2) Daily Attendance Report of Learners<br>
        <span class="subtitle">(This replaces Form 1, Form 2 & STS Form 4 - Absenteeism and Dropout Profile)</span>
      </td>
    </tr>
    <tr>
      <td>School ID: <span style="border:1px solid black; padding:2px 5px;"> <?= $school->SchoolIDJHS ?> </span></td>
      <td>School Year: <span style="border:1px solid black; padding:2px 5px;"> <?= $sy ?> </span></td>
<?php
$monthName = date("F", mktime(0, 0, 0, $month, 10)); // Converts 1 to "January"
?>
<td>Report for the Month of: 
    <span style="border:1px solid black; padding:2px 15px;">
        <?= $monthName . ', ' . $year ?>
    </span>
</td>
    </tr>
    <tr>
      <td colspan="3">Name of School: <span style="border:1px solid black; padding:2px 5px;"> <?= $school->SchoolName ?> </span></td>
      <td colspan="2">Grade Level: <span style="border:1px solid black; padding:2px 5px;"> <?= $sectionInfo->YearLevel ?> </span> Section: <span style="border:1px solid black; padding:2px 5px;"> <?= $sectionInfo->Section ?> </span></td>
    </tr>
  </table>
  <table>
    <tr>
      <th rowspan="2">LEARNER'S NAME<br>(Last Name, First Name, Middle Name)</th>
      <?php foreach ($allDates as $date): ?>
        <th colspan="2"><?= date('j', strtotime($date)) ?></th>
      <?php endforeach; ?>
      <th colspan="2">Total for the Month</th>
      <th rowspan="2">REMARKS</th>
    </tr>
    <tr>
      <?php foreach ($allDates as $date): ?>
        <th>AM</th><th>PM</th>
      <?php endforeach; ?>
      <th>ABSENT</th><th>TARDY</th>
    </tr>

   <?php foreach (["Male", "Female"] as $sex): ?>
  <?php
    // Initialize counters
    $totalsPerDay = [];
    $absentTotal = 0;
    $tardyTotal = 0;

    foreach ($allDates as $d) {
        $totalsPerDay[$d]['AM'] = 0;
        $totalsPerDay[$d]['PM'] = 0;
        $totalsPerDay[$d]['AM_absent'] = 0;
        $totalsPerDay[$d]['PM_absent'] = 0;
    }
  ?>
  <?php foreach ($groupedStudents[$sex] as $stude): ?>
    <?php
      $name = "$stude->LastName, $stude->FirstName $stude->MiddleName";
      $studNo = $stude->StudentNumber;
      $absent = 0;
      $tardy = 0; // Set to 0 unless you're tracking late
    ?>
    <tr>
      <td style="text-align: left;"> <?= $name ?> </td>
      <?php foreach ($allDates as $d): ?>
        <?php
          $am = $attendanceData[$studNo][$d]['AM'] ?? null;
          $pm = $attendanceData[$studNo][$d]['PM'] ?? null;
          $mark_am = ($am === '1') ? '✔' : '✘';
          $mark_pm = ($pm === '1') ? '✔' : '✘';

          if ($am === '1') $totalsPerDay[$d]['AM']++;
          else {
            $absent += 0.5;
            $totalsPerDay[$d]['AM_absent']++;
          }

          if ($pm === '1') $totalsPerDay[$d]['PM']++;
          else {
            $absent += 0.5;
            $totalsPerDay[$d]['PM_absent']++;
          }
        ?>
        <td><?= $mark_am ?></td>
        <td><?= $mark_pm ?></td>
      <?php endforeach; ?>
      <td><?= $absent ?></td>
      <td><?= $tardy ?></td>
      <td></td>
    </tr>
    <?php $absentTotal += $absent; ?>
    <?php $tardyTotal += $tardy; ?>
  <?php endforeach; ?>

  <!-- TOTAL ROW for group (e.g., Male or Female) -->
  <tr style="font-weight:bold;">
    <td style="text-align:right;"><?= strtoupper($sex) ?> | TOTAL Per Day</td>
    <?php foreach ($allDates as $d): ?>
      <td><?= $totalsPerDay[$d]['AM'] ?></td>
      <td><?= $totalsPerDay[$d]['PM'] ?></td>
    <?php endforeach; ?>
    <td><?= $absentTotal ?></td>
    <td><?= $tardyTotal ?></td>
    <td></td>
  </tr>

  <?php
    foreach ($allDates as $d) {
        $combinedTotal[$d]['AM'] = ($combinedTotal[$d]['AM'] ?? 0) + $totalsPerDay[$d]['AM'];
        $combinedTotal[$d]['PM'] = ($combinedTotal[$d]['PM'] ?? 0) + $totalsPerDay[$d]['PM'];
        $combinedTotal[$d]['AM_absent'] = ($combinedTotal[$d]['AM_absent'] ?? 0) + $totalsPerDay[$d]['AM_absent'];
        $combinedTotal[$d]['PM_absent'] = ($combinedTotal[$d]['PM_absent'] ?? 0) + $totalsPerDay[$d]['PM_absent'];
    }
    $combinedAbsentTotal = ($combinedAbsentTotal ?? 0) + $absentTotal;
    $combinedTardyTotal = ($combinedTardyTotal ?? 0) + $tardyTotal;
  ?>
  <tr class="page-break"></tr>
<?php endforeach; ?>

<!-- COMBINED TOTAL ROW -->
<tr style="font-weight:bold;">
  <td style="text-align:right;">COMBINED TOTAL PER DAY</td>
  <?php foreach ($allDates as $d): ?>
    <td><?= $combinedTotal[$d]['AM'] ?? 0 ?></td>
    <td><?= $combinedTotal[$d]['PM'] ?? 0 ?></td>
  <?php endforeach; ?>
  <td><?= $combinedAbsentTotal ?></td>
  <td><?= $combinedTardyTotal ?></td>
  <td></td>
</tr>

  </table>

  <div class="page-break"></div>
<div style="margin-top: 10px;">
  <div class="guidelines">
    <strong>GUIDELINES:</strong>
    <ol>
      <li>The attendance shall be accomplished daily. Refer to the codes for checking learners’ attendance.</li>
      <li>Dates shall be written in the columns after Learner’s Name.</li>
      <li>To compute the following:
        <br>a. Percentage of Enrolment =
        <br><center>Registered Learners as of end of the month<br>
        Enrolment as of 1st Friday of the school year</center>
        <br><center>× 100</center>
        <br>b. Average Daily Attendance =
        <br><center>Total Daily Attendance<br>
        Number of School Days in reporting month</center>
        <br>c. Percentage of Attendance for the month =
        <br><center>Average daily attendance<br>
        Registered Learners as of end of the month</center>
        <br><center>× 100</center>
      </li>
      <li>Every end of the month, the class adviser shall submit this form to the office of the principal for recording of summary table into School Form 4. Once signed by the principal, this form should be returned to the adviser.</li>
      <li>The adviser will provide necessary interventions including but not limited to home visitation to learners who were absent for 5 consecutive days and/or those at risk of dropping out.</li>
      <li>Attendance performance of learners will be reflected in Form 137 and Form 138 every grading period.<br><i>* Beginning of School Year cut-off report is every 1st Friday of the School Year</i></li>
    </ol>
  </div>
   <div class="codes" style="text-align: left; font-size: 10px;">
    <p><strong>1. CODES FOR CHECKING ATTENDANCE Month:</strong><br>
    (blank) - Present; (x)- Absent; Tardy (half shaded = Upper for 
    <br>Late Comer, Lower for Cutting Classes)</p>

    <p><strong>2. REASONS/CAUSES FOR DROPPING OUT</strong></p>
    <p><strong>a. Domestic-Related Factors</strong><br>
    a.1. Had to take care of siblings<br>
    a.2. Early marriage/pregnancy<br>
    a.3. Parents' attitude toward schooling<br>
    a.4. Family problems</p>

    <p><strong>b. Individual-Related Factors</strong><br>
    b.1. Illness<br>
    b.2. Overage<br>
    b.3. Death<br>
    b.4. Drug Abuse<br>
    b.5. Poor academic performance<br>
    b.6. Lack of interest/Distractions<br>
    b.7. Hunger/Malnutrition</p>

    <p><strong>c. School-Related Factors</strong><br>
    c.1. Teacher Factor<br>
    c.2. Physical condition of classroom<br>
    c.3. Peer influence</p>

    <p><strong>d. Geographic/Environmental</strong><br>
    d.1. Distance between home and school<br>
    d.2. Armed conflict (incl. Tribal wars & clan feuds)<br>
    d.3. Calamities/Disasters</p>

    <p><strong>e. Financial-Related</strong><br>
    e.1. Child labor, work</p>

    <p><strong>f. Others</strong> (Specify)</p>
  </div>

<div class="summary">
  <table class="summary-table" style="border-collapse: collapse; width: 100%; font-size: 9px;">
    <tr>
      <th rowspan="2" style="border: 1px solid #000; text-align: left; padding: 4px;">Month: __________</th>
      <th rowspan="2" style="border: 1px solid #000; text-align: center;">No. of Days of Classes:</th>
      <th colspan="3" style="border: 1px solid #000; text-align: center;">Summary</th>
    </tr>
    <tr>
      <th style="border: 1px solid #000; text-align: center;">M</th>
      <th style="border: 1px solid #000; text-align: center;">F</th>
      <th style="border: 1px solid #000; text-align: center;">TOTAL</th>
    </tr>
    <!-- Table rows -->
    <tr>
      <td style="border: 1px solid #000; padding-left: 4px;"><i>* Enrolment as of (1st Friday of June)</i></td>
      <td style="border: 1px solid #000;"></td>
      <td style="border: 1px solid #000;"></td><td style="border: 1px solid #000;"></td><td style="border: 1px solid #000;"></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;"><i>Late Enrollment <b>during the month</b><br>(beyond cut-off)</i></td>
      <td style="border: 1px solid #000;"></td>
      <td style="border: 1px solid #000;"></td><td style="border: 1px solid #000;"></td><td style="border: 1px solid #000;"></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;"><b>Registered Learners as of end of the month</b></td>
      <td style="border: 1px solid #000;"></td>
      <td style="border: 1px solid #000; text-align: center;"><?= count($groupedStudents['Male']) ?></td>
      <td style="border: 1px solid #000; text-align: center;"><?= count($groupedStudents['Female']) ?></td>
      <td style="border: 1px solid #000; text-align: center;"><?= count($groupedStudents['Male']) + count($groupedStudents['Female']) ?></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;"><b>Percentage of Enrolment as of end of the month</b></td>
      <td style="border: 1px solid #000;"></td><td colspan="3" style="border: 1px solid #000;"></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;">Average Daily Attendance</td>
      <td style="border: 1px solid #000;"></td><td colspan="3" style="border: 1px solid #000;"></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;"><b>Percentage of Attendance for the month</b></td>
      <td style="border: 1px solid #000;"></td><td colspan="3" style="border: 1px solid #000;"></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;">Number of students absent for 5 consecutive days:</td>
      <td style="border: 1px solid #000;"></td><td colspan="3" style="border: 1px solid #000;"></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;">Drop out</td>
      <td style="border: 1px solid #000;"></td><td colspan="3" style="border: 1px solid #000;"></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;">Transferred out</td>
      <td style="border: 1px solid #000;"></td><td colspan="3" style="border: 1px solid #000;"></td>
    </tr>
    <tr>
      <td style="border: 1px solid #000;">Transferred in</td>
      <td style="border: 1px solid #000;"></td><td colspan="3" style="border: 1px solid #000;"></td>
    </tr>
  </table>

<div style="margin-top: 10px; font-size: 9px;">
  <p style="margin-bottom: 20px;">I certify that this is a true and correct report.</p>
  <div style="display: flex; justify-content: space-between; margin-top: 30px;">
    <div style="text-align: center; width: 45%;">
        <strong><?= $teacherName ?></strong>
      _________________________<br>
      <span style="font-size: 9px;">(Signature of Teacher over Printed Name)</span><br>
      
    </div>
    <div style="text-align: center; width: 45%;">
      _________________________<br>
      <span style="font-size: 9px;">(Signature of School Head over Printed Name)</span>
    </div>
  </div>
</div>


</div>


</div>
<div class="page-footer">School Form 2 : Page ___ of ___</div>
</body>
</html>
