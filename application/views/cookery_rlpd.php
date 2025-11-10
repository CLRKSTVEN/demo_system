<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SHS SF9 — TVL: Cookery</title>
<link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico'); ?>">
<link href="<?= base_url('assets/css/ren.css'); ?>" rel="stylesheet" type="text/css" />
<style>
:root{ --ink:#111; --muted:#444; --grid:#000; --shade:#f7f7f7; --fs:12.25px; }
  *{ box-sizing:border-box; }
  body{ font-family:Arial, Helvetica, sans-serif; color:var(--ink); font-size:var(--fs); margin:16px; }
  .wrap{ max-width:1120px; margin:0 auto; }
  .topwrap,.topwrap2{ display:flex; justify-content:space-between; margin-bottom:10px; }
  .topwrap .pleft,.topwrap .pright,.topwrap2 .pleft,.topwrap2 .pright{ width:49%; }
  .topwrap2 span{ display:inline-block; min-width:220px; border-bottom:1px solid #000; padding:1px 6px; margin-left:6px; }
.shs-wrap{
  display:grid;
  grid-template-columns: 1fr 1fr;
  gap: 22px;
  align-items: start;
  margin-top: 8px;
}
  .tb-shs{ width:100%; border-collapse:collapse; table-layout:fixed; }
  .tb-shs th,.tb-shs td{ border:1px solid var(--grid); padding:6px; font-size:var(--fs); vertical-align:middle; word-wrap:break-word; }
  .tb-shs th{ text-align:center; }
  .tb-shs .cat{ font-weight:700; background:var(--shade); }
  .titlebig{ font-weight:700; margin:6px 0 8px 0; text-align:center; }
  .text-center{ text-align:center; }
.desc-grid{ display:grid; grid-template-columns: 1fr 1fr; gap:18px; margin-top:10px; }
  .tb-desc{ width:100%; border-collapse:collapse; }
  .tb-desc th,.tb-desc td{ border:1px solid var(--grid); padding:6px; font-size:var(--fs); }
  .tb-desc th{ text-align:left; background:var(--shade); }
.tb4{ width:100%; border-collapse:collapse; margin-top:8px; }
  .tb4 td{ padding:6px; font-size:var(--fs); vertical-align:top; }
  .tb4 .thborder{ border-bottom:1px solid #000; }
  .ad_sign{ display:inline-block; margin-top:3px; color:var(--muted); }
  .print-only{ display:block; }
  .page-break{ page-break-before:always; margin-top:16px; }
  .block{ border:1px solid #000; padding:8px; }
  .block h3{ margin:0 0 8px 0; font-size:13px; text-align:center; }
  .nb td, .nb th{ border:none !important; }
  .pad6{ padding:6px; }
  .mt8{ margin-top:8px; } .mt12{ margin-top:12px; } .mt16{ margin-top:16px; } .mb8{ margin-bottom:8px; }
  .h-center{ text-align:center; }
  .title{ font-weight:700; }
  .small{ font-size:12px; }
  .signline{ border-bottom:1px solid #000; display:inline-block; min-width:260px; padding:2px 6px; }

  table{ width:100%; border-collapse:collapse; }
  th, td{ border:1px solid #000; padding:6px; vertical-align:middle; }
  th{ text-align:center; }

  .deped-hdr{ text-align:center; line-height:1.25; }
  .deped-hdr .rep{ font-size:12px; }
  .deped-hdr .dept{ font-weight:700; font-size:14px; }
  .deped-hdr .region{ font-size:12px; }
  .sheet-title{ text-align:center; font-weight:700; font-size:14px; margin:6px 0 10px 0; }

  .two-col{ display:grid; grid-template-columns: 1fr 1fr; grid-column-gap:10px; }
  .uline{ border-bottom:1px solid #000; padding:1px 6px; min-width:160px; display:inline-block; }
  .uline-sm{ border-bottom:1px solid #000; padding:1px 6px; min-width:120px; display:inline-block; }
  .uline-lg{ border-bottom:1px solid #000; padding:1px 6px; min-width:240px; display:inline-block; }

  .box{ border:1px solid #000; padding:8px; }
  .grid-2{ display:grid; grid-template-columns: 1fr 1fr; gap:10px; }

  .school-info{ font-size:11.5px; margin-top:8px; }
  .seal-bg{ position:relative; }
  .seal-bg img.bg{ position:absolute; right:10px; top:20px; width:46%; opacity:.08; z-index:0; }
  .seal-content{ position:relative; z-index:1; }

  @media print{
    body{ margin:0; }
    .shs-wrap{ gap:12px; }
  }
.toolbar-print.no-print{
  position: fixed; right: 16px; bottom: 16px; z-index: 9999;
  background:#111; color:#fff; border-radius:999px; padding:10px 16px;
  box-shadow: 0 8px 24px rgba(0,0,0,.25); cursor:pointer; user-select:none;
  font: 600 14px/1 Arial, Helvetica, sans-serif;
}
.toolbar-print.no-print:hover{ opacity:.9 }

:root{ --ink:#111; --muted:#444; --grid:#000; --shade:#f7f7f7; --fs:11.5px; }
body{ background:#f0f2f5; } 
.paper{
  width: 14in;
  min-height: 8.5in;  
  margin: 18px auto;
  background:#fff;
  box-shadow: 0 1px 3px rgba(0,0,0,.08), 0 20px 40px rgba(0,0,0,.12);
  padding: 0.45in;
}

.wrap{ max-width: unset; margin:0; }
.page-break{ page-break-before: always; height: 0; margin: 0; }
@page { size: legal landscape; margin: 0.5in; }
.print-only{ display:none; }
@media print{
  body{ background:#fff; margin:0; }
  .paper{ box-shadow:none; margin:0; height:8.5in; width:14in; padding:0.5in; }
  .no-print{ display:none !important; }
  .print-only{ display:block; }
  .shs-wrap{ gap:22px; }
  :root{ --fs: 12.1px; }
}

.tb-shs{
  table-layout: auto;   
}
.tb-shs th,
.tb-shs td{
  word-break: keep-all;   
  overflow-wrap: normal;
  white-space: normal;
  line-height: 1.25;
}

.tb-shs td:first-child{ text-align: left; }

.tb-shs col.subjects { width: 56% !important; }
.tb-shs col.q        { width: 8%  !important; }
.tb-shs col.final    { width: 16% !important; }
.tb-shs col.remarks  { width: 12% !important; }

:root{ --fs: 12.75px; }
.paper{ padding: 0.4in; } 
.shs-wrap{ gap: 22px; }     
.titlebig{ margin: 8px 0 8px; }

.tb-desc th, .tb-desc td,
.tb4 td,
.block, .box{
  padding: 9px 10px;
  line-height: 1.35;
}
.page-2 table th,
.page-2 table td{
  padding: 9px 10px;
  line-height: 1.35;
}
@media print{
  :root{ --fs: 12.25px; } 
  .tb-shs th, .tb-shs td{ padding: 8px 9px !important; line-height: 1.32; }
  .tb-desc th, .tb-desc td, .tb4 td, .block, .box{ padding: 8px 9px; line-height: 1.32; }
  .shs-wrap{ gap: 18px; }
}
.page-2{
  height: 100%;
  display: grid;
  grid-template-columns: 1.05fr 0.95fr; 
  gap: 24px;
  align-items: start;
}
.seal-bg{ height: 100%; display:flex; }
.seal-content{ width:100%; display:flex; flex-direction:column; }

.paper { width: 14in; padding: 0.45in; }
.paper > .wrap{ width: 100% !important; max-width: none !important; margin: 0 !important; }

.shs-wrap{ width: 100% !important; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
.shs-wrap > * { min-width: 0 !important; }

@page { size: legal landscape; margin: 0; }
@media print {
  html, body { margin:0 !important; padding:0 !important; background:#fff !important; }
  .paper { box-sizing: border-box; width: 14in; height: 8.5in; padding: 0.5in; margin: 0 !important; box-shadow: none !important; page-break-after: always; overflow: hidden; }
  .paper:last-of-type { page-break-after: auto; }
  .page-break { break-before: page; height: 0 !important; margin: 0 !important; padding: 0 !important; border: 0 !important; }
  :root { --fs: 12px; }
  .tb-shs th, .tb-shs td, .tb-desc th, .tb-desc td, .tb4 td, .block, .box, .page-2 table th, .page-2 table td { padding: 7px 8px !important; line-height: 1.28 !important; }
  .tb-shs, .tb-desc, .block, .box, .page-2 { break-inside: avoid; }
  .shs-wrap { gap: 16px !important; }
}
</style>
</head>
<body>
<button class="toolbar-print no-print" onclick="window.print()">Print SF9</button>

<?php if (isset($form_blocked) && $form_blocked): ?>
  <div style="background:#fff3cd;color:#856404;border:1px solid #ffeeba;padding:8px;margin:10px 16px;border-radius:4px;">
    This SHS SF9 form is aligned for <b>Senior High School</b> students. The selected student’s Course/Program does not match SHS.
    You can still view this page, but subject lines will use the static fallback. Use the JHS/Elementary SF9 if applicable.
  </div>
<?php endif; ?>

<?php
  // ------- Header / identity -------
  $selected_sy = isset($selected_sy) ? $selected_sy
               : (isset($sem_stud->SY) ? $sem_stud->SY
               : (isset($currentSY) ? $currentSY
               : (string) ($this->session->userdata('sy'))));

  $yl   = isset($sem_stud->YearLevel) ? $sem_stud->YearLevel : (isset($stud->YearLevel) ? $stud->YearLevel : '—');
  $sec  = isset($sem_stud->Section)   ? $sem_stud->Section   : (isset($stud->Section)   ? $stud->Section   : '—');
  $dept = isset($cur_stud->Course)    ? $cur_stud->Course    : (isset($sem_stud->Course)? $sem_stud->Course: '—');

  $adviser_name = isset($cur_stud->Adviser) ? $cur_stud->Adviser : (isset($sem_stud->Adviser) ? $sem_stud->Adviser : '');
  $schoolHead   = isset($prin->SchoolHead) ? $prin->SchoolHead : '';

  // Deportment codes (optional)
  $deported_codes = (isset($deported_codes) && is_array($deported_codes)) ? $deported_codes : [];
  if (!is_array($deported_codes)) $deported_codes = [];

  // Helpers
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
  $fmt = function($v){
    $s = (string)$v;
    if ($s === '' || !is_numeric($s) || floatval($s) <= 0) return '';
    $n = floatval($s);
    return floor($n)==$n ? (string)intval($n) : number_format($n,2);
  };

  /* ---------------- DYNAMIC SUBJECTS (code/desc binding with `$gradeIndex`) ---------------- */
  $default_tpl = [
    'First Semester' => [
      'Core Subjects' => [
        // sensible generic fallback in case controller didn’t pass template
        'Contemporary Philippine Arts from the Region',
        'Introduction to the Philosophy of the Human Person',
        'Physical Science',
        'Physical Education and Health 3',
        'Understanding Culture, Society and Politics',
      ],
      'Applied Subject/s' => ['Practical Research 2'],
      'Specialized Subject' => ['Cookery'],
    ],
    'Second Semester' => [
      'Core Subjects' => [
        'Personality Development',
        'Physical Education and Health 4',
        'Media and Information Literacy',
        'Pagbasa at Pagsusuri ng Iba’t Ibang Teksto Tungo sa Pananaliksik',
      ],
      'Applied Subject/s' => ['Entrepreneurship','Inquiries, Investigations and Immersion'],
      'Specialized Subject' => ['Cookery'],
    ],
  ];
  $tpl = (isset($template_subjects) && is_array($template_subjects) && !empty($template_subjects))
       ? $template_subjects
       : $default_tpl;

  $rows = is_array(isset($data) ? $data : []) ? $data : [];
  $norm = function($s){ return strtolower(trim(preg_replace('/\s+/', ' ', (string)$s))); };

  // Indexes
  $byDesc = [];
  foreach ($rows as $r){
    $d = $norm(isset($r->Description) ? $r->Description : '');
    if ($d !== '' && !isset($byDesc[$d])) $byDesc[$d] = $r;
  }
  $byCode = (isset($gradeIndex) && is_array($gradeIndex)) ? $gradeIndex : [];

  // Attach grade helper
  $attachGrade = function($item) use ($byCode, $byDesc, $norm){
    $tplDesc = ''; $tplCode = '';
    if (is_object($item)) {
      $tplDesc = (string)($item->desc ?? $item->description ?? '');
      $tplCode = (string)($item->code ?? $item->subjectCode ?? '');
    } else {
      $tplDesc = (string)$item;
    }

    $g = null;
    if ($tplCode !== '' && isset($byCode[$tplCode])) $g = $byCode[$tplCode];                 // 1) code
    if (!$g && $tplDesc !== '') { $nd = $norm($tplDesc); if (isset($byDesc[$nd])) $g = $byDesc[$nd]; } // 2) exact desc
    if (!$g && $tplDesc !== '') {                                                      // 3) fuzzy
      $nd = $norm($tplDesc);
      foreach ($byDesc as $bd => $row) {
        if ($bd!=='' && (strpos($bd,$nd)!==false || strpos($nd,$bd)!==false)) { $g=$row; break; }
      }
    }

    if ($g) {
      $q1   = isset($g->PGrade)  ? $g->PGrade  : (isset($g->Q1) ? $g->Q1 : '');
      $q2   = isset($g->MGrade)  ? $g->MGrade  : (isset($g->Q2) ? $g->Q2 : '');
      $fin  = isset($g->Average) ? $g->Average : '';
      $code = isset($g->SubjectCode) ? (string)$g->SubjectCode : (isset($g->subjectCode) ? (string)$g->subjectCode : $tplCode);
      $desc = isset($g->Description) ? (string)$g->Description : $tplDesc;
      return (object)[ 'desc'=>$desc, 'q1'=>$q1, 'q2'=>$q2, 'fin'=>$fin, 'code'=>$code ];
    }
    return (object)[ 'desc'=>$tplDesc, 'q1'=>'', 'q2'=>'', 'fin'=>'', 'code'=>$tplCode ];
  };

  // Build buckets
  $buckets = [
    'First Semester'  => ['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]],
    'Second Semester' => ['Core Subjects'=>[], 'Applied Subject/s'=>[], 'Specialized Subject'=>[]],
  ];
  foreach (['First Semester','Second Semester'] as $SEM) {
    foreach (['Core Subjects','Applied Subject/s','Specialized Subject'] as $CAT) {
      $list = isset($tpl[$SEM][$CAT]) && is_array($tpl[$SEM][$CAT]) ? $tpl[$SEM][$CAT] : [];
      foreach ($list as $item) { $buckets[$SEM][$CAT][] = $attachGrade($item); }
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
  /* ---------------- /DYNAMIC SUBJECTS ---------------- */

  // Student/School
  $LRN        = isset($stud->LRN) ? $stud->LRN : '';
  $firstName  = isset($stud->FirstName) ? $stud->FirstName : '';
  $middleName = isset($stud->MiddleName) ? $stud->MiddleName : '';
  $lastName   = isset($stud->LastName) ? $stud->LastName : '';
  $age        = isset($stud->Age) ? $stud->Age : '';
  $sex        = isset($stud->Sex) ? $stud->Sex : '';
  $SY         = isset($selected_sy) ? $selected_sy : (isset($sem_stud->SY) ? $sem_stud->SY : '');
  $section    = isset($sem_stud->Section) ? $sem_stud->Section : '';
  $gradeLevel = isset($sem_stud->YearLevel) ? $sem_stud->YearLevel : (isset($stud->YearLevel) ? $stud->YearLevel : '');

  // TVL: Cookery labels (use these in page-2 block)
  $track = 'TECHNICAL VOCATIONAL LIVELIHOOD (TVL)';
  $spec  = 'COOKERY';

  $principalNameSafe = isset($principalName) ? $principalName : (isset($schoolHead) ? $schoolHead : 'School Principal IV');
  $adviserNameSafe   = isset($adviserName) ? $adviserName : ($adviser_name ? $adviser_name : 'Class Adviser');

  $schoolNameSafe    = isset($schoolName) ? $schoolName : 'CRISPIN E. ROJAS NATIONAL HIGH SCHOOL';
  $schoolAddrSafe    = isset($schoolAddress) ? $schoolAddress : 'LAMBAJON, BAGANGA, DAVAO ORIENTAL';
  $schoolEmailSafe   = isset($schoolEmail) ? $schoolEmail : 'crispinerojasnhs.baganganorth@deped.gov.ph';
  $schoolLogoSafe    = isset($schoolLogo) ? $schoolLogo : '';

  $months = isset($months) && is_array($months) ? $months : ['JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER','JANUARY','FEBRUARY','MARCH'];
  $days_of_school = isset($days_of_school) && is_array($days_of_school) ? $days_of_school : [];
  $days_present   = isset($days_present)   && is_array($days_present)   ? $days_present   : [];
?>

<div class="paper page-1">
  <div class="wrap">

   <?php if (!empty($letterheadUrl)) : ?>
  <img class="print-only" src="<?= htmlspecialchars($letterheadUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="Letterhead" width="100%">
<?php endif; ?>


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
      <!-- FIRST SEM -->
      <table class="tb-shs">
        <colgroup>
          <col class="subjects"><col class="q"><col class="q"><col class="final"><col class="remarks">
        </colgroup>
        <tr><th colspan="5" class="titlebig">First Semester</th></tr>
        <tr>
          <th>Subjects</th>
          <th colspan="2">Quarter</th>
          <th>Semester<br>Final Grade</th>
          <th>Remarks</th>
        </tr>
        <tr><th></th><th>1</th><th>2</th><th></th><th></th></tr>

        <?php foreach (['Core Subjects','Applied Subject/s','Specialized Subject'] as $CAT): ?>
          <tr><td class="cat" colspan="5"><?= $CAT; ?></td></tr>
          <?php foreach ($buckets['First Semester'][$CAT] as $it): ?>
            <tr>
              <td><?= htmlspecialchars($it->desc, ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="text-center"><?= $fmt($it->q1); ?></td>
              <td class="text-center"><?= $fmt($it->q2); ?></td>
              <td class="text-center"><?= $fmt($it->fin); ?></td>
              <td class="text-center"><?= htmlspecialchars(numeric_remark($it->fin), ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>

        <tr>
          <td style="text-align:right;font-weight:700">General Average for the Semester</td>
          <td></td><td></td>
          <td class="text-center"><?= htmlspecialchars($semester_general_average['First Semester']['grade'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td class="text-center"><?= htmlspecialchars($semester_general_average['First Semester']['remark'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
      </table>

      <!-- SECOND SEM -->
      <table class="tb-shs">
        <colgroup>
          <col class="subjects"><col class="q"><col class="q"><col class="final"><col class="remarks">
        </colgroup>
        <tr><th colspan="5" class="titlebig">Second Semester</th></tr>
        <tr>
          <th>Subjects</th>
          <th colspan="2">Quarter</th>
          <th>Semester<br>Final Grade</th>
          <th>Remarks</th>
        </tr>
        <tr><th></th><th>1</th><th>2</th><th></th><th></th></tr>

        <?php foreach (['Core Subjects','Applied Subject/s','Specialized Subject'] as $CAT): ?>
          <tr><td class="cat" colspan="5"><?= $CAT; ?></td></tr>
          <?php foreach ($buckets['Second Semester'][$CAT] as $it): ?>
            <tr>
              <td><?= htmlspecialchars($it->desc, ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="text-center"><?= $fmt($it->q1); ?></td>
              <td class="text-center"><?= $fmt($it->q2); ?></td>
              <td class="text-center"><?= $fmt($it->fin); ?></td>
              <td class="text-center"><?= htmlspecialchars(numeric_remark($it->fin), ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>

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

  </div><!-- /.wrap -->
</div><!-- /.paper -->

<div class="page-break"></div>

<div class="paper page-2sheet">
  <div class="page-2">
    <div>
      <div class="block">
        <h3 class="title">REPORT ON ATTENDANCE</h3>
        <table>
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
          <tr><td>FIRST</td><td></td><td></td></tr>
          <tr><td>SECOND</td><td></td><td></td></tr>
          <tr><td>THIRD</td><td></td><td></td></tr>
          <tr><td>FOURTH</td><td></td><td></td></tr>
        </table>
      </div>
    </div>

    <div class="seal-bg">
      <?php if ($schoolLogoSafe){ ?>
        <img class="bg" src="<?= htmlspecialchars($schoolLogoSafe, ENT_QUOTES, 'UTF-8'); ?>" alt="Seal">
      <?php } ?>

      <div class="seal-content">
        <div class="deped-hdr">
          <div class="rep">Republic of the Philippines</div>
          <div class="dept">Department of Education</div>
          <div class="region">REGION XI</div>
          <div class="region">SCHOOLS DIVISION OF DAVAO ORIENTAL</div>
        </div>

        <div class="sheet-title">DepEd School Form 9 (Senior High School)</div>

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
            <div>Approved: <span class="uline-lg"></span></div>
          </div>
          <div class="two-col mt12">
            <div class="h-center">
              <div class="uline-lg"></div>
              <div class="small">School Principal</div>
            </div>
            <div class="h-center">
              <div class="uline-lg"></div>
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
            <div class="uline-lg"></div>
            <div class="small">School Principal</div>
          </div>
        </div>

        <div class="school-info mt16">
          <div><b>Name of School:</b> <?= htmlspecialchars($schoolNameSafe, ENT_QUOTES, 'UTF-8'); ?></div>
          <div><b>Address:</b> <?= htmlspecialchars($schoolAddrSafe, ENT_QUOTES, 'UTF-8'); ?></div>
          <div><b>Email Address:</b> <?= htmlspecialchars($schoolEmailSafe, ENT_QUOTES, 'UTF-8'); ?></div>
        </div>

      </div>
    </div>
  </div>
</div>

</body>
</html>
