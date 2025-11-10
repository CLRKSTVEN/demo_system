<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SHS Report Card — Grade 11 HUMSS</title>
  <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico'); ?>">
  <link href="<?= base_url('assets/css/ren.css'); ?>" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/css/reportcard.css'); ?>" rel="stylesheet">
</head>
<body>
<style>
  .template-badge{
    position:absolute;
    top:0.35in;
    right:0.55in;
    background:#111;
    color:#fff;
    border-radius:999px;
    padding:6px 12px;
    font: 700 11px/1 Arial, Helvetica, sans-serif;
    letter-spacing:.35px;
    z-index: 6;
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
  }
  @media print {
    .template-badge{
      background:#000;
      box-shadow:none;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>

<button class="toolbar-print no-print" onclick="window.print()">Print SF9</button>

<?php
  $selected_sy = isset($selected_sy) ? $selected_sy : (string) ($this->session->userdata('sy'));
  $yl   = isset($sem_stud->YearLevel) ? $sem_stud->YearLevel : (isset($stud->YearLevel) ? $stud->YearLevel : '—');
  $sec  = isset($sem_stud->Section)   ? $sem_stud->Section   : (isset($stud->Section)   ? $stud->Section   : '—');
  $dept = isset($sem_stud->Course)    ? $sem_stud->Course    : (isset($stud->Course)    ? $stud->Course    : '—');

  $adviser_name = isset($sem_stud->Adviser) ? $sem_stud->Adviser : '';
  $schoolHead   = isset($prin->SchoolHead) ? $prin->SchoolHead : '';

  if (!function_exists('numeric_remark')) {
    function numeric_remark($g){
      if (!is_numeric($g) || $g<=0) return '';
      if ($g>=90) return 'Outstanding';
      if ($g>=85) return 'Very Satisfactory';
      if ($g>=80) return 'Satisfactory';
      if ($g>=75) return 'Fairly Satisfactory';
      return 'Did Not Meet Expectations';
    }
  }
  if (!function_exists('fmt_grade_half_up')) {
    function fmt_grade_half_up($v){
      if ($v === '' || !is_numeric($v) || (float)$v <= 0) return '';
      $n = (float)$v;
      $int = (int) floor($n);
      $frac = $n - $int;
      return (string) ($frac >= 0.5 ? $int + 1 : $int);
    }
  }
  if (!function_exists('safe_textarea')) {
    function safe_textarea($s) {
      $s = (string)$s;
      if ($s === '') return '';
      return nl2br(htmlspecialchars($s, ENT_QUOTES, 'UTF-8'));
    }
  }

  $tpl = (isset($template_subjects) && is_array($template_subjects))
       ? $template_subjects
       : ['First Semester'=>['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]],
          'Second Semester'=>['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]]];

  $rows = is_array(isset($data) ? $data : []) ? $data : [];

  $norm = function($s){ return strtolower(trim(preg_replace('/\s+/', ' ', (string)$s))); };

  $byDesc = [];
  foreach ($rows as $r){
    $d = $norm(isset($r->Description) ? $r->Description : '');
    if ($d !== '' && !isset($byDesc[$d])) $byDesc[$d] = $r;
  }
  $byCode = (isset($gradeIndex) && is_array($gradeIndex)) ? $gradeIndex : [];

  $attachGrade = function($tplItem) use ($byCode, $byDesc, $norm){
    $code = (string)($tplItem->code ?? '');
    $desc = (string)($tplItem->desc ?? '');

    $g = null;
    if ($code !== '' && isset($byCode[$code])) $g = $byCode[$code];
    if (!$g && $desc !== '') {
      $nd = $norm($desc);
      if (isset($byDesc[$nd])) $g = $byDesc[$nd];
      if (!$g) {
        foreach ($byDesc as $bd => $row) {
          if ($bd !== '' && (strpos($bd, $nd) !== false || strpos($nd, $bd) !== false)) { $g = $row; break; }
        }
      }
    }

    if ($g) {
      $q1   = isset($g->PGrade)  ? $g->PGrade  : (isset($g->Q1) ? $g->Q1 : '');
      $q2   = isset($g->MGrade)  ? $g->MGrade  : (isset($g->Q2) ? $g->Q2 : '');
      $fin  = isset($g->Average) ? $g->Average : '';
      $codeF = isset($g->SubjectCode) ? (string)$g->SubjectCode : (isset($g->subjectCode) ? (string)$g->subjectCode : $code);
      $descF = isset($g->Description) ? (string)$g->Description : $desc;
      return (object)[ 'desc'=>$descF, 'q1'=>$q1, 'q2'=>$q2, 'fin'=>$fin, 'code'=>$codeF ];
    }
    return (object)[ 'desc'=>$desc, 'q1'=>'', 'q2'=>'', 'fin'=>'', 'code'=>$code ];
  };

  $buckets = [
    'First Semester'  => ['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]],
    'Second Semester' => ['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]],
  ];
  foreach (['First Semester','Second Semester'] as $SEM) {
    if (!isset($tpl[$SEM]) || !is_array($tpl[$SEM])) continue;
    foreach (['Core Subjects','Applied Subject/s','Specialized Subject'] as $CAT) {
      $list = isset($tpl[$SEM][$CAT]) && is_array($tpl[$SEM][$CAT]) ? $tpl[$SEM][$CAT] : [];
      foreach ($list as $tplItem) { $buckets[$SEM][$CAT][] = $attachGrade($tplItem); }
    }
  }

  $semester_general_average = [
    'First Semester'  => ['grade' => '', 'remark' => ''],
    'Second Semester' => ['grade' => '', 'remark' => ''],
  ];

  foreach (array_keys($semester_general_average) as $SEM) {
    $sum = 0.0;
    $cnt = 0;

    if (!empty($buckets[$SEM])) {
      foreach ($buckets[$SEM] as $items) {
        foreach ($items as $it) {
          $code = isset($it->code) ? (string)$it->code : '';
          if ($code !== '' && in_array($code, $deported_codes, true)) {
            continue;
          }
          $fin = isset($it->fin) ? (float)$it->fin : 0.0;
          if ($fin > 0) {
            $sum += $fin;
            $cnt++;
          }
        }
      }
    }

    if ($cnt > 0) {
      $avg = $sum / $cnt;
      $semester_general_average[$SEM]['grade']  = fmt_grade_half_up($avg);
      $semester_general_average[$SEM]['remark'] = numeric_remark($avg);
    }
  }

  $LRN        = isset($stud->LRN) ? $stud->LRN : '';
  $firstName  = isset($stud->FirstName) ? $stud->FirstName : '';
  $middleName = isset($stud->MiddleName) ? $stud->MiddleName : '';
  $lastName   = isset($stud->LastName) ? $stud->LastName : '';
  $age        = isset($stud->Age) ? $stud->Age : '';
  $sex        = isset($stud->Sex) ? $stud->Sex : '';
  $SY         = $selected_sy;
  $section    = isset($sem_stud->Section) ? $sem_stud->Section : '';
  $gradeLevel = isset($sem_stud->YearLevel) ? $sem_stud->YearLevel : (isset($stud->YearLevel) ? $stud->YearLevel : '');
 // Track (Academic / TVL / etc.) pulled from semesterstude → fallback to stud → else blank
$track = '';
if (!empty($sem_stud->Track)) {
    $track = (string)$sem_stud->Track;
} elseif (!empty($stud->Track)) {
    $track = (string)$stud->Track;
}

// Specialization/Strand pulled from semesterstude first, then fallback candidates
$spec = '';
if (!empty($sem_stud->strand)) {
    $spec = (string)$sem_stud->strand;
} elseif (!empty($sem_stud->Qualification)) {
    $spec = (string)$sem_stud->Qualification;
} elseif (!empty($sem_stud->Track)) {
    $spec = (string)$sem_stud->Track;   // last resort: reuse Track if that’s all you have
}


  $principalNameSafe = isset($principalName) ? $principalName : (isset($schoolHead) ? $schoolHead : 'School Principal IV');
  $adviserNameSafe   = !empty($adviser_name) ? $adviser_name : 'Class Adviser';

  $schoolNameSafe    = isset($schoolName) ? $schoolName : 'CRISPIN E. ROJAS NATIONAL HIGH SCHOOL';
  $schoolAddrSafe    = isset($schoolAddress) ? $schoolAddress : 'LAMBAJON, BAGANGA, DAVAO ORIENTAL';
  $schoolEmailSafe   = isset($schoolEmail) ? $schoolEmail : 'crispinerojasnhs.baganganorth@deped.gov.ph';

  $months = isset($months) && is_array($months) ? $months : ['JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER','JANUARY','FEBRUARY','MARCH'];
  $days_of_school = isset($days_of_school) && is_array($days_of_school) ? $days_of_school : [];
  $days_present   = isset($days_present)   && is_array($days_present)   ? $days_present   : [];
?>

<div class="paper page-1">
  <div class="wrap">
<?php
  $badge_grade = 'GRADE ' . (is_numeric($yl ?? null) ? intval($yl) : '12');
  $badge_track = 'HUMSS';
  $badge_text  = strtoupper($badge_grade . ' • ' . $badge_track);
?>
<div class="template-badge no-print"><?= htmlspecialchars($badge_text, ENT_QUOTES, 'UTF-8'); ?></div>

    <div class="topwrap">
      <p class="pleft">
        <b>REPORT ON LEARNING PROGRESS AND DEVELOPMENT</b><br>
        LRN: <b><?= htmlspecialchars($LRN, ENT_QUOTES, 'UTF-8'); ?></b>
      </p>
      <p class="pright">
        Curriculum: <b>K to 12 Basic Education</b><br>
        Department: <b><?= htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></b>
      </p>
    </div>

    <div class="topwrap2">
      <p class="pleft">
        Student Name
        <span><?= htmlspecialchars(($lastName ? $lastName : '').', '.($firstName ? $firstName : '').' '.($middleName ? $middleName : ''), ENT_QUOTES, 'UTF-8'); ?></span><br>
        Level/Section
        <span><?= htmlspecialchars($yl, ENT_QUOTES, 'UTF-8'); ?> / <?= htmlspecialchars($sec, ENT_QUOTES, 'UTF-8'); ?></span>
      </p>
      <p class="pright">
        Student No.: <span><?= htmlspecialchars(isset($stud->StudentNumber)?$stud->StudentNumber:'', ENT_QUOTES, 'UTF-8'); ?></span><br>
        Sex: <span><?= htmlspecialchars($sex, ENT_QUOTES, 'UTF-8'); ?></span>
        School Year <span><?= htmlspecialchars($SY ?: '—', ENT_QUOTES, 'UTF-8'); ?></span>
      </p>
    </div>

    <div class="shs-wrap">
      <table class="tb-shs">
        <colgroup>
          <col class="subjects"><col class="q"><col class="q"><col class="final"><col class="remarks">
        </colgroup>
        <tr><th colspan="5" class="titlebig">First Semester (HUMSS)</th></tr>
        <tr>
          <th>Subjects</th>
          <th colspan="2">Quarter</th>
          <th>Semester<br>Final Grade</th>
          <th>Remarks</th>
        </tr>
        <tr><th></th><th>1</th><th>2</th><th></th><th></th></tr>

        <?php $cats = ['Core Subjects','Applied Subject/s','Specialized Subject']; $printedFirst=false; ?>
        <?php foreach ($cats as $CAT): ?>
          <?php if (empty($buckets['First Semester'][$CAT])) continue; $printedFirst=true; ?>
          <tr><td class="cat" colspan="5"><?= $CAT; ?></td></tr>
          <?php foreach ($buckets['First Semester'][$CAT] as $it): ?>
            <?php $q1=fmt_grade_half_up($it->q1); $q2=fmt_grade_half_up($it->q2); $fin=fmt_grade_half_up($it->fin); ?>
            <tr>
              <td><?= htmlspecialchars($it->desc, ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="text-center"><?= $q1; ?></td>
              <td class="text-center"><?= $q2; ?></td>
              <td class="text-center"><?= $fin; ?></td>
              <td class="text-center"><?= htmlspecialchars(numeric_remark($fin), ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>

        <?php if (!$printedFirst): ?>
          <tr><td colspan="5" class="text-center" style="font-style:italic;">No subjects encoded for First Semester.</td></tr>
        <?php endif; ?>

        <tr>
          <td style="text-align:right;font-weight:700">General Average for the Semester</td>
          <td></td><td></td>
          <td class="text-center"><?= htmlspecialchars($semester_general_average['First Semester']['grade'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td class="text-center"><?= htmlspecialchars($semester_general_average['First Semester']['remark'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
      </table>

      <table class="tb-shs">
        <colgroup>
          <col class="subjects"><col class="q"><col class="q"><col class="final"><col class="remarks">
        </colgroup>
        <tr><th colspan="5" class="titlebig">Second Semester (HUMSS)</th></tr>
        <tr>
          <th>Subjects</th>
          <th colspan="2">Quarter</th>
          <th>Semester<br>Final Grade</th>
          <th>Remarks</th>
        </tr>
        <tr><th></th><th>1</th><th>2</th><th></th><th></th></tr>

        <?php $printedSecond=false; foreach ($cats as $CAT): ?>
          <?php if (empty($buckets['Second Semester'][$CAT])) continue; $printedSecond=true; ?>
          <tr><td class="cat" colspan="5"><?= $CAT; ?></td></tr>
          <?php foreach ($buckets['Second Semester'][$CAT] as $it): ?>
            <?php $q1=fmt_grade_half_up($it->q1); $q2=fmt_grade_half_up($it->q2); $fin=fmt_grade_half_up($it->fin); ?>
            <tr>
              <td><?= htmlspecialchars($it->desc, ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="text-center"><?= $q1; ?></td>
              <td class="text-center"><?= $q2; ?></td>
              <td class="text-center"><?= $fin; ?></td>
              <td class="text-center"><?= htmlspecialchars(numeric_remark($fin), ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>

        <?php if (!$printedSecond): ?>
          <tr><td colspan="5" class="text-center" style="font-style:italic;">No subjects encoded for Second Semester.</td></tr>
        <?php endif; ?>

        <tr>
          <td style="text-align:right;font-weight:700">General Average for the Semester</td>
          <td></td><td></td>
          <td class="text-center"><?= htmlspecialchars($semester_general_average['Second Semester']['grade'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td class="text-center"><?= htmlspecialchars($semester_general_average['Second Semester']['remark'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
      </table>
    </div>

    <div class="desc-grid">
      <table class="tb-desc">
        <tr><th colspan="3">Descriptors</th></tr>
        <tr><td>OUTSTANDING</td><td>90–100</td><td>Passed</td></tr>
        <tr><td>VERY SATISFACTORILY</td><td>85–89</td><td>Passed</td></tr>
        <tr><td>SATISFACTORILY</td><td>80–84</td><td>Passed</td></tr>
        <tr><td>FAIRLY SATISFACTORILY</td><td>75–79</td><td>Passed</td></tr>
        <tr><td>DID NOT MEET EXPECTATIONS</td><td>Below 75</td><td>Failed</td></tr>
      </table>
      <table class="tb-desc">
        <tr><th colspan="3">Descriptors</th></tr>
        <tr><td>OUTSTANDING</td><td>90–100</td><td>Passed</td></tr>
        <tr><td>VERY SATISFACTORILY</td><td>85–89</td><td>Passed</td></tr>
        <tr><td>SATISFACTORILY</td><td>80–84</td><td>Passed</td></tr>
        <tr><td>FAIRLY SATISFACTORILY</td><td>75–79</td><td>Passed</td></tr>
        <tr><td>DID NOT MEET EXPECTATIONS</td><td>Below 75</td><td>Failed</td></tr>
      </table>
    </div>

  </div>
</div>

<div class="page-break"></div>

<div class="paper page-2sheet">
  <div class="page-2">
    <div>
      <div class="block">
        <h3 class="title">REPORT ON ATTENDANCE</h3>
        <table class="att">
          <tr>
            <th style="width:30%">Month</th>
            <th style="width:23%">No. of<br>School Days</th>
            <th style="width:23%">No. of Days<br>Present</th>
            <th>No. of Days<br>Absent</th>
          </tr>
          <?php
            $tot_sd = 0; $tot_pr = 0; $tot_ab = 0;
            foreach($months as $m){
              $sd = isset($days_of_school[$m]) && is_numeric($days_of_school[$m]) ? floatval($days_of_school[$m]) : 0.0;
              $pr = isset($days_present[$m])   && is_numeric($days_present[$m])   ? floatval($days_present[$m])   : 0.0;
              $ab = ($sd>0 && $pr>=0) ? max(0, $sd - $pr) : 0.0;
              $tot_sd += $sd; $tot_pr += $pr; $tot_ab += $ab;
              echo '<tr>';
              echo '<td>'.$m.'</td>';
              echo '<td>'.($sd>0 ? rtrim(rtrim(number_format($sd,2),'0'),'.') : '').'</td>';
              echo '<td>'.($pr>0 ? rtrim(rtrim(number_format($pr,2),'0'),'.') : '').'</td>';
              echo '<td>'.($ab>0 ? rtrim(rtrim(number_format($ab,2),'0'),'.') : '').'</td>';
              echo '</tr>';
            }
          ?>
          <tr>
            <td class="title">TOTAL</td>
            <td><?= ($tot_sd>0 ? rtrim(rtrim(number_format($tot_sd,2),'0'),'.') : '') ?></td>
            <td><?= ($tot_pr>0 ? rtrim(rtrim(number_format($tot_pr,2),'0'),'.') : '') ?></td>
            <td><?= ($tot_ab>0 ? rtrim(rtrim(number_format($tot_ab,2),'0'),'.') : '') ?></td>
          </tr>
        </table>

        <table class="nb mt12">
          <tr>
            <td style="width:28%" class="pad6">Reported by:</td>
            <td class="pad6 h-center">
              <span class="signline"><?= htmlspecialchars($adviserNameSafe, ENT_QUOTES, 'UTF-8'); ?></span><br>
              <span class="small" style="display:block">Signature over Printed Name of Class Adviser</span>
            </td>
          </tr>
        </table>

        <div class="mt12 small">
          <b>To the Parent/Guardian:</b><br>
          Please carefully read the comments below on your child's performance. Sign on the space provided
          to signify that you have received this. We encourage you to consult with the Class Adviser for any concern.
        </div>

        <table class="mt8">
          <tr>
            <th style="width:18%">QUARTER</th>
            <th>COMMENTS</th>
            <th style="width:26%">SIGNATURE</th>
          </tr>
          <tr><td>FIRST</td><td><?= isset($narrative) ? safe_textarea($narrative->FirstQuarter ?? '') : '' ?></td><td></td></tr>
          <tr><td>SECOND</td><td><?= isset($narrative) ? safe_textarea($narrative->SecondQuarter ?? '') : '' ?></td><td></td></tr>
          <tr><td>THIRD</td><td><?= isset($narrative) ? safe_textarea($narrative->ThirdQuarter ?? '') : '' ?></td><td></td></tr>
          <tr><td>FOURTH</td><td><?= isset($narrative) ? safe_textarea($narrative->FourthQuarter ?? '') : '' ?></td><td></td></tr>
        </table>
      </div>
    </div>

    <div class="seal-bg">
      <?php $bg = !empty($rcSealUrl) ? $rcSealUrl : $schoolLogoSafe; ?>
      <?php if (!empty($bg)): ?><img class="bg" src="<?= htmlspecialchars($bg, ENT_QUOTES, 'UTF-8'); ?>" alt="Seal"><?php endif; ?>
      <div class="seal-content">
        <?php $badge = !empty($rcSealUrl) ? $rcSealUrl : $schoolLogoSafe; ?>
        <?php if (!empty($badge)): ?><img class="rc-badge" src="<?= htmlspecialchars($badge, ENT_QUOTES, 'UTF-8'); ?>" alt="Seal"><?php endif; ?>

        <div class="deped-hdr">
          <div class="rep">Republic of the Philippines</div>
          <div class="dept">Department of Education</div>
          <div class="region">REGION XI</div>
          <div class="region">SCHOOLS DIVISION OF DAVAO ORIENTAL</div>
        </div>

        <div class="sheet-title">DepEd School Form 9 (Grade 11 HUMSS)</div>

        <table class="nb" style="margin-bottom:6px">
          <tr>
            <td style="width:12%">Name:</td>
            <td style="width:25%"><div class="small">(First Name)</div><div class="uline-lg"><?= htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?></div></td>
            <td style="width:25%"><div class="small">(Middle Name)</div><div class="uline-lg"><?= htmlspecialchars($middleName, ENT_QUOTES, 'UTF-8'); ?></div></td>
            <td><div class="small">(Last Name)</div><div class="uline-lg"><?= htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8'); ?></div></td>
          </tr>
        </table>

        <div class="two-col" style="margin-bottom:6px">
          <div>
            <div>LRN: <span class="uline-sm"><?= htmlspecialchars($LRN, ENT_QUOTES, 'UTF-8'); ?></span></div>
            <div>Age: <span class="uline-sm"><?= htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?></span></div>
            <div>Grade Level: <span class="uline-sm"><?= htmlspecialchars($gradeLevel, ENT_QUOTES, 'UTF-8'); ?></span></div>
          <div>Track: <span class="uline-lg"><?= htmlspecialchars($track, ENT_QUOTES, 'UTF-8'); ?></span></div>
<div>Specialization: <span class="uline-lg"><?= htmlspecialchars($spec, ENT_QUOTES, 'UTF-8'); ?></span></div>

          </div>
          <div>
            <div>School Year: <span class="uline-sm"><?= htmlspecialchars($SY, ENT_QUOTES, 'UTF-8'); ?></span></div>
            <div>Sex: <span class="uline-sm"><?= htmlspecialchars($sex, ENT_QUOTES, 'UTF-8'); ?></span></div>
            <div>Section: <span class="uline-sm"><?= htmlspecialchars($section, ENT_QUOTES, 'UTF-8'); ?></span></div>
          </div>
        </div>

        <div class="box mb8">
          <div class="small"><b>Dear Parent:</b></div>
          <div class="small">
            This report card shows the ability and progress of your child has made in the different learning areas as well as
            his/her core values. The school welcomes you should you desire to know more about your child's progress.
          </div>
        </div>

        <div class="two-col">
          <div class="h-center">
            <div class="uline-lg"><?= htmlspecialchars($principalNameSafe, ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="small">School Principal IV</div>
          </div>
          <div class="h-center">
            <div class="uline-lg"><?= htmlspecialchars($adviserNameSafe, ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="small">Class Adviser</div>
          </div>
        </div>

        <div class="box mt12">
          <div class="title h-center">CERTIFICATE OF TRANSFER</div>
          <div class="grid-2 mt8">
            <div>Admitted to Grade: <span class="uline-sm"></span></div>
            <div>Section: <span class="uline-sm"></span></div>
            <div>Eligibility for Admission to Grade: <span class="uline-lg"></span></div>
            <div>Approved: <span class="uline-lg"><?= htmlspecialchars($principalNameSafe, ENT_QUOTES, 'UTF-8'); ?></span></div>
          </div>
          <div class="two-col mt12">
            <div class="h-center">
              <div class="uline-lg"><?= htmlspecialchars($principalNameSafe, ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="small">School Principal</div>
            </div>
            <div class="h-center">
              <div class="uline-lg"><?= htmlspecialchars($adviserNameSafe, ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="small">Class Adviser</div>
            </div>
          </div>
        </div>

        <div class="box mt12">
          <div class="title">CANCELLATION OF ELIGIBILITY TO TRANSFER</div>
          <div class="grid-2 mt8">
            <div>Admitted in: <span class="uline-lg"></span></div>
            <div>Date: <span class="uline-sm"></span></div>
          </div>
          <div class="h-center mt12">
            <div class="uline-lg"><?= htmlspecialchars($principalNameSafe, ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="small">School Principal</div>
          </div>
        </div>

        <div class="school-info mt16 school-info-row">
          <?php $infoLogo = !empty($rcLeftUrl) ? $rcLeftUrl : (!empty($rcRightUrl) ? $rcRightUrl : $rcSealUrl); ?>
          <?php if (!empty($infoLogo)): ?>
            <img class="badge" src="<?= htmlspecialchars($infoLogo, ENT_QUOTES, 'UTF-8'); ?>" alt="School Logo">
          <?php endif; ?>
          <div class="lines">
            <div><b>Name of School:</b> <?= htmlspecialchars($schoolNameSafe, ENT_QUOTES, 'UTF-8'); ?></div>
            <div><b>Address:</b> <?= htmlspecialchars($schoolAddrSafe, ENT_QUOTES, 'UTF-8'); ?></div>
            <div><b>Email Address:</b> <?= htmlspecialchars($schoolEmailSafe, ENT_QUOTES, 'UTF-8'); ?></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</body>
</html>
