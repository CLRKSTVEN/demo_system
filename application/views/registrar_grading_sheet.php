<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
  <link href="<?= base_url(); ?>assets/css/renren.css" rel="stylesheet" type="text/css" />
  <title>Grading Sheet Report</title>

  <style>
    /* --- Reset-ish --- */
    * { box-sizing: border-box; }
    html, body { margin:0; padding:0; color:#000; font-family: Verdana, Arial, sans-serif; font-size:13px; line-height:1.5; }

    /* --- Wrapper & Headings --- */
    .twrap { width: 95%; margin: 28px auto; }
    img.print-only { width: 100%; margin-bottom: 18px; display:block; }
    .gh { text-align:center; font-size: 22px; font-weight: 700; margin: 10px 0 4px; letter-spacing:.3px; }
    .gsh { text-align:center; font-size: 14px; margin: 0 0 16px; font-style: italic; color:#333; }

    /* --- Tables --- */
    table { width:100%; border-collapse: collapse; margin-bottom: 16px; }
    th, td { padding: 8px 10px; border: 1px solid #222; }
    th { background:#f4f6fa; font-weight: 700; }
    .thead-slim th { padding: 6px 8px; }
    .borderless { border:none !important; }
    .bb { border-left:none !important; border-right:none !important; border-top:none !important; border-bottom:1px solid #000 !important; }
    .bblue { border-bottom: 3px solid #175fe6 !important; }

    /* --- Section Bands --- */
    .band { background: #202a44; color:#fff; font-weight:700; text-align:center; }
    .band.male   { background:#1f5ba1; }
    .band.female { background:#9f2f4f; }
    .band.empty  { background:#6c757d; }

    /* --- Utilities --- */
    .mt-md { margin-top:20px; }
    .mb-sm { margin-bottom:12px; }
    .text-center { text-align:center; }
    .text-right  { text-align:right; }
    .muted { color:#666; }
    .nowrap { white-space:nowrap; }

    /* --- Signature blocks --- */
    .signs { display:flex; justify-content:space-between; gap:24px; margin-top:34px; }
    .sign { flex:1; min-width:240px; }
    .sign .lbl { margin-bottom:40px; }
    .sign .line { border-top:1px solid #000; padding-top:4px; text-align:center; }
    .sign small { display:block; color:#444; }

    /* --- Zebra rows for readability --- */
    .zebra tbody tr:nth-child(odd)  { background:#fafbff; }
    .zebra tbody tr:nth-child(even) { background:#fff; }

    /* --- Print --- */
    @media print {
      @page { size: A4 portrait; margin: 16mm 12mm; }
      html, body { width:100%; height:100%; font-size:12pt; }
      .twrap { width:100%; margin:0 auto; }
      .no-print { display:none !important; }
      .page-break { page-break-before: always; }
    }
  </style>
</head>

<body>
<div class="twrap">
  <!-- Letterhead -->
  <?php if (!empty($so->letterhead_web)): ?>
    <img class="print-only" src="<?= base_url(); ?>upload/banners/<?= $so->letterhead_web; ?>" alt="Letterhead">
  <?php endif; ?>

  <!-- Title -->
  <h1 class="gh">GRADING SHEET</h1>
  <p class="gsh">
    <?= ucfirst(($period ?? '1st') === 'all' ? 'All Grading Periods' : ($period ?? '1st') . ' Grading'); ?>
    <span class="muted">• <?= html_escape($grade->SY); ?></span>
  </p>

  <?php
  // Helpers
  function getGradeValue($row, $period) {
      if ($period == '1st') return $row->PGrade;
      if ($period == '2nd') return $row->MGrade;
      if ($period == '3rd') return $row->PFinalGrade;
      if ($period == '4th') return $row->FGrade;
      return $row->Average; // 'all' => not used directly per-cell, we render all columns
  }
  function getLetterGrade($grade) {
      if ($grade === null || $grade === '') return '';
      if ($grade >= 90) return 'A';
      if ($grade >= 85) return 'B+';
      if ($grade >= 80) return 'B';
      if ($grade >= 75) return 'C';
      return 'F';
  }
  $isAll = ($period ?? '1st') === 'all';
  // Columns: LRN | Student Name | (periods...) | Remarks
  $colspan = $isAll ? 2 + 5 + 1 : 2 + 1 + 1;
  ?>

  <!-- Subject Header -->
  <table class="thead-slim">
    <tr>
      <td class="borderless nowrap">Subject Code</td>
      <td class="bb"><?= html_escape($grade->SubjectCode); ?></td>
      <td class="borderless nowrap">Sem./SY</td>
      <td class="bb"><?= html_escape($grade->SY); ?></td>
    </tr>
    <tr>
      <td class="borderless nowrap">Description</td>
      <td class="bb"><?= html_escape($grade->Description); ?></td>
      <td class="borderless nowrap">Section</td>
      <td class="bb"><?= html_escape($grade->Section); ?></td>
    </tr>
  </table>

  <!-- Table Header -->
  <table>
    <thead>
      <tr>
        <th class="bblue">LRN</th>
        <th class="bblue">Student Name</th>
        <?php if ($isAll): ?>
          <th class="text-center bblue">1</th>
          <th class="text-center bblue">2</th>
          <th class="text-center bblue">3</th>
          <th class="text-center bblue">4</th>
          <th class="text-center bblue">Ave.</th>
        <?php else: ?>
          <th class="text-center bblue"><?= ucfirst($period); ?> Grading</th>
        <?php endif; ?>
        <th class="text-center bblue">Remarks</th>
      </tr>
    </thead>
  </table>

  <?php
  // Renderer for a group (Male or Female)
  $render_group = function($label, $rows, $bandClass) use ($isAll, $gradeDisplay, $period) {
      if (empty($rows)) return;
      ?>
      <table class="zebra">
        <tr>
          <td colspan="<?= $isAll ? 8 : 4; ?>" class="band <?= $bandClass; ?>"><?= strtoupper($label); ?> (<?= count($rows); ?>)</td>
        </tr>
        <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td style="width:140px;"><?= html_escape($row->LRN); ?></td>
            <td>
              <?= html_escape($row->LastName); ?>, <?= html_escape($row->FirstName); ?>
              <?= ($row->MiddleName != '') ? ' ' . html_escape(substr($row->MiddleName, 0, 1)) . '.' : ''; ?>
            </td>

            <?php if ($isAll): ?>
              <?php if ($gradeDisplay === 'Letter'): ?>
                <?php
                  $g1 = getLetterGrade($row->PGrade);
                  $g2 = getLetterGrade($row->MGrade);
                  $g3 = getLetterGrade($row->PFinalGrade);
                  $g4 = getLetterGrade($row->FGrade);
                  $ga = getLetterGrade($row->Average);
                ?>
                <td class="text-center"><?= $g1; ?></td>
                <td class="text-center"><?= $g2; ?></td>
                <td class="text-center"><?= $g3; ?></td>
                <td class="text-center"><?= $g4; ?></td>
                <td class="text-center"><?= $ga; ?></td>
                <td class="text-center"><?= ($ga === 'F') ? 'Failed' : 'Passed'; ?></td>
              <?php else: ?>
                <td class="text-center"><?= is_numeric($row->PGrade)      ? number_format($row->PGrade, 2)      : ''; ?></td>
                <td class="text-center"><?= is_numeric($row->MGrade)      ? number_format($row->MGrade, 2)      : ''; ?></td>
                <td class="text-center"><?= is_numeric($row->PFinalGrade) ? number_format($row->PFinalGrade, 2) : ''; ?></td>
                <td class="text-center"><?= is_numeric($row->FGrade)      ? number_format($row->FGrade, 2)      : ''; ?></td>
                <td class="text-center"><?= is_numeric($row->Average)     ? number_format($row->Average, 2)     : ''; ?></td>
                <td class="text-center"><?= (is_numeric($row->Average) && $row->Average <= 74.4) ? 'Failed' : 'Passed'; ?></td>
              <?php endif; ?>

            <?php else: ?>
              <?php
                $value = getGradeValue($row, $period);
                if ($gradeDisplay === 'Letter') {
                    $letter = getLetterGrade($value);
                }
              ?>
              <?php if ($gradeDisplay === 'Letter'): ?>
                <td class="text-center"><?= $letter; ?></td>
                <td class="text-center"><?= ($letter === 'F') ? 'Failed' : 'Passed'; ?></td>
              <?php else: ?>
                <td class="text-center"><?= is_numeric($value) ? number_format($value, 2) : ''; ?></td>
                <td class="text-center"><?= (is_numeric($value) && $value <= 74.4) ? 'Failed' : 'Passed'; ?></td>
              <?php endif; ?>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php
  };
  ?>

  <!-- Order: MALE first, then FEMALE -->
  <?php $render_group('Male',   $ms ?? [], 'male'); ?>
  <?php $render_group('Female', $fs ?? [], 'female'); ?>

  <!-- Signatures -->
  <div class="signs">
    <div class="sign">
      <div class="lbl">Submitted by:</div>
      <div class="line">
        <strong><?= !empty($grade->Instructor) ? strtoupper(html_escape($grade->Instructor)) : '_____________________________' ?></strong>
        <small>Teacher</small>
      </div>
    </div>
    <div class="sign">
      <div class="lbl">Received/Checked by:</div>
      <div class="line">
        <strong>&nbsp;</strong>
        <small>Signature over Printed Name</small>
      </div>
    </div>
  </div>

  <p class="muted mb-sm" style="margin-top:18px;">
    <small>Generated by SRMS • <?= date('F d, Y h:i A'); ?></small>
  </p>
</div>
</body>
</html>
