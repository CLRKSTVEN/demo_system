<?php if (!function_exists('h')){ function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
$fullName = trim(($stud['LastName']??'').', '.($stud['FirstName']??'').(empty($stud['MiddleName'])?'':' '.strtoupper($stud['MiddleName'][0]).'.'));
$major = trim((string)($stud['Major'] ?? ''));

$letterheadUrl = '';
$raw = trim((string)($settings['letterhead_web'] ?? ''));
if ($raw !== '') {
  $fname = basename(str_replace('\\','/',$raw));
  $fname = preg_replace('/[^A-Za-z0-9._-]/', '', $fname);
  if ($fname !== '') $letterheadUrl = base_url('upload/banners/'.$fname);
}
$registrar  = isset($settings['RegistrarJHS']) ? (string)$settings['RegistrarJHS'] : '';
$regPos     = 'Registrar';
$schoolAddr = isset($settings['SchoolAddress']) ? (string)$settings['SchoolAddress'] : '';
$issuedOn   = date('l, F j, Y');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Certificate of Grades</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
:root{ --page-w:210mm; --page-h:297mm; --pad-v:14mm; --pad-h:12mm; }
@media screen { html,body{ background:#eef1f5; }
  .sheet{ width:var(--page-w); min-height:var(--page-h); margin:16px auto; background:#fff; box-shadow:0 12px 28px rgba(0,0,0,.12); padding:var(--pad-v) var(--pad-h); } }
@media print { @page { size:A4; margin:0; }
  .sheet{ width:var(--page-w); min-height:var(--page-h); margin:0 auto!important; box-shadow:none!important; padding:var(--pad-v) var(--pad-h); page-break-after:always; } }
html,body{ font-family:Arial, Helvetica, sans-serif; color:#000; } body{ font-size:12px; }
.letterhead img{ max-width:100%; height:auto; display:block; }
.center{text-align:center;} .title{ font-weight:700; letter-spacing:.2px; } .heading{ margin:8px 0 6px; }
.blurb{ font-size:12px; line-height:1.45; text-align:justify; margin:8px 0 10px; }
table{ width:100%; border-collapse:collapse; table-layout:fixed; }
th,td{ border:1px solid #2d2d2d; padding:5px 6px; font-size:11.3px; line-height:1.23; }
th{ background:#f4f6f9; font-weight:700; }
.w-subj{ width:120px; } .w-grd{ width:90px; text-align:center; } .w-rmk{ width:160px; }
.gpa-row td{ background:#dff1ff; color:#0b3d91; font-weight:700; -webkit-print-color-adjust:exact; print-color-adjust:exact; }
.gpa-label{ text-align:right; border-left:4px solid #0b57d0; padding-left:6px; }
@media print{ .gpa-row td{ background:#cfe3ff!important; } .gpa-label{ border-left-color:#000!important; } }
.signs{ width:100%; margin-top:32px; } .signs td{ border:none; font-size:12px; } .sign-pad{ padding-top:36px; text-align:center; }
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

  <div class="center heading">
    <div class="title" style="font-size:13px;">OFFICE OF THE REGISTRAR</div>
    <div class="title" style="font-size:17px; margin-top:3px; text-decoration:underline;">CERTIFICATE OF GRADES</div>
  </div>
  <br><br>

  <div class="blurb"><b>TO WHOM IT MAY CONCERN:</b></div>
  <div class="blurb">
    This is to certify as per records on file, <b><?= h(strtoupper($fullName)) ?></b> is enrolled as
    <b><?= h($stud['YearLevel'] ?? '') ?> Year</b> student in the program
    <b><?= h($stud['Course'] ?? '') ?></b><?= $major !== '' ? ', major in <b>'.h($major).'</b>' : '' ?>,
    took the following subjects during the School Year <b><?= h($sy ?? '') ?></b>:
  </div>

  <table>
    <thead>
      <tr>
        <th class="w-subj">SUBJECT</th>
        <th>TITLE/DESCRIPTION</th>
        <th class="w-grd">GRADES</th>
        <th class="w-rmk">REMARKS</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($rows)): foreach ($rows as $r): ?>
        <tr>
          <td><?= h($r['SubjectCode']) ?></td>
          <td><?= h($r['Description']) ?></td>
          <td class="w-grd"><?= is_numeric($r['Average']) ? number_format((float)$r['Average'], 1) : '' ?></td>
          <td></td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="4" class="center">This student does not have any grades yet.</td></tr>
      <?php endif; ?>
      <tr class="gpa-row">
        <td class="gpa-label" colspan="2">GENERAL AVERAGE</td>
        <td class="w-grd"><?= isset($gpa) && $gpa !== null ? number_format((float)$gpa,2) : '' ?></td>
        <td></td>
      </tr>
    </tbody>
  </table>

  <div class="blurb">This certification is issued upon the request of the above-mentioned name for whatever legal purpose/purposes it may serve him/her best.</div>
  <div class="blurb">Issued this <b><?= h($issuedOn) ?></b> at <?= h($schoolAddr) ?>.</div>

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
