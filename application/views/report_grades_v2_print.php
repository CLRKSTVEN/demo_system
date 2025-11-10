<?php if (!function_exists('h')){ function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
$fullName = trim(($stud['LastName'] ?? '').', '.($stud['FirstName'] ?? '').(empty($stud['MiddleName']) ? '' : ' '.strtoupper(substr($stud['MiddleName'],0,1)).'.'));

$letterheadUrl = '';
$raw = trim((string)($settings['letterhead_web'] ?? ''));
if ($raw !== '') {
  $fname = basename(str_replace('\\','/',$raw));
  $fname = preg_replace('/[^A-Za-z0-9._-]/', '', $fname);
  if ($fname !== '') $letterheadUrl = base_url('upload/banners/'.$fname);
}
$registrar = isset($settings['RegistrarJHS']) ? (string)$settings['RegistrarJHS'] : '';
$regPos    = 'Registrar';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Report of Student Grade</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
:root{ --page-w:210mm; --page-h:297mm; --pad-v:14mm; --pad-h:12mm; }
@media screen { html, body { background:#eef1f5; }
  .sheet { width:var(--page-w); min-height:var(--page-h); margin:16px auto; background:#fff; box-shadow:0 12px 28px rgba(0,0,0,.12); padding:var(--pad-v) var(--pad-h); } }
@media print { @page { size:A4; margin:0; }
  .sheet { width:var(--page-w); min-height:var(--page-h); margin:0 auto!important; box-shadow:none!important; padding:var(--pad-v) var(--pad-h); page-break-after:always; } }
html,body{ font-family:Arial, Helvetica, sans-serif; color:#000; } body{ font-size:12px; }
.letterhead img{ max-width:100%; height:auto; display:block; }
.center{ text-align:center; } .title{ font-weight:700; letter-spacing:.2px; } .subtle{ color:#222; }
.meta{ width:100%; margin:8px 0 10px; } .meta td{ border:none; padding:2px 0; font-size:12px; }
table{ width:100%; border-collapse:collapse; table-layout: fixed; }
th, td{ border:1px solid #2d2d2d; padding:4px 6px; font-size:11.2px; line-height:1.22; }
th{ background:#f4f6f9; font-weight:700; }
col.c-code { width:100px; } col.c-desc { width:auto; } col.c-term { width:58px; }
col.c-pref { width:62px; } col.c-avg  { width:64px; } col.c-rmk  { width:110px; }
.center-txt { text-align:center; }
.signs { width:100%; margin-top:32px; } .signs td{ border:none; font-size:12px; } .sign-pad{ padding-top:36px; text-align:center; }
</style>
</head>
<body>
<div class="sheet">

  <div class="letterhead">
    <?php if ($letterheadUrl): ?>
      <img src="<?= h($letterheadUrl) ?>" alt="Letterhead">
    <?php else: ?>
      <div class="center" style="font-weight:bold">LETTERHEAD</div>
    <?php endif; ?>
  </div>
  <br><br>

  <div class="center">
    <div class="title" style="font-size:15px;">REPORT OF STUDENT GRADE</div>
    <div class="subtle" style="margin-top:2px;">SY <?= h($sy ?: '') ?></div>
  </div>
  <br>

  <table class="meta">
    <tr><td><b>STUDENT NAME:</b> <?= h($fullName) ?></td></tr>
    <tr><td><b>STUDENT NUMBER:</b> <?= h($stud['StudentNumber'] ?? '') ?></td></tr>
    <tr><td><b>COURSE / YEAR:</b> <?= h(($stud['Course'] ?? '').' / '.($stud['YearLevel'] ?? '')) ?></td></tr>
  </table>

  <table>
    <colgroup>
      <col class="c-code"><col class="c-desc">
      <col class="c-term"><!-- Prelim -->
      <col class="c-term"><!-- Midterm -->
      <col class="c-pref"><!-- Semi-Finals -->
      <col class="c-term"><!-- Finals -->
      <col class="c-avg"><!-- Average -->
      <col class="c-rmk"><!-- Remarks -->
    </colgroup>
    <thead>
      <tr>
        <th>COURSE CODE</th>
        <th>DESCRIPTION</th>
        <th>PRELIM</th>
        <th>MID-TERM</th>
        <th>SEMI-FINALS</th>
        <th>FINALS</th>
        <th>AVERAGE</th>
        <th>REMARKS</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($rows)): foreach ($rows as $r):
        $vals=[]; foreach(['PGrade','MGrade','PFinalGrade','FGrade'] as $k){ if(is_numeric($r[$k])) $vals[]=(float)$r[$k]; }
        $avg = $vals ? array_sum($vals)/count($vals) : (is_numeric($r['Average'] ?? null) ? (float)$r['Average'] : null);
      ?>
      <tr>
        <td><?= h($r['SubjectCode']) ?></td>
        <td><?= h($r['Description']) ?></td>
        <td class="center-txt"><?= is_numeric($r['PGrade'])      ? number_format((float)$r['PGrade'],1)      : '' ?></td>
        <td class="center-txt"><?= is_numeric($r['MGrade'])      ? number_format((float)$r['MGrade'],1)      : '' ?></td>
        <td class="center-txt"><?= is_numeric($r['PFinalGrade']) ? number_format((float)$r['PFinalGrade'],1) : '' ?></td>
        <td class="center-txt"><?= is_numeric($r['FGrade'])      ? number_format((float)$r['FGrade'],1)      : '' ?></td>
        <td class="center-txt"><?= $avg!==null ? number_format((float)$avg,1) : '' ?></td>
        <td></td>
      </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="8" class="center">This student does not have any grades yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <table class="signs">
    <tr>
      <td style="width:50%;"></td>
      <td style="width:50%;">
        <div><b>Certified Correct:</b></div>
        <div class="sign-pad">
          <div style="text-transform:uppercase; font-weight:700;"><?= h($registrar) ?></div>
          <div><?= h($regPos) ?></div>
        </div>
      </td>
    </tr>
  </table>

</div>
</body>
</html>
