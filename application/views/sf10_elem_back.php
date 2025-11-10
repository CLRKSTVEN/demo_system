<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SF10-ES | Permanent Record (Back Page)</title>
    <style>
        @media print {
            @page {
                size: legal portrait;
                margin: 5px;
            }
            body {
                margin: 5px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .highlight-section {
                background-color: #d2cba3 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10.5px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        td, th {
            border: 1px solid #000;
            padding: 4px;
        }
        .gray-bg { background: #d9d9d9; }
        .highlight-section {
            background-color: #d2cba3;
            font-weight: bold;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
        }
        .sf10-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .sf10-col {
            width: 49%;
        }
        .certification-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 8px;
        }
        .cert-title {
            background: #d9d9d9;
            text-align: center;
            font-weight: bold;
        }
        .cert-label {
            font-weight: bold;
        }
        .underline {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: 180px;
        }
        .small-note {
            font-size: 9px;
            font-style: italic;
        }
    </style>
</head>
<body>

<?php
$record_chunks = array_chunk(array_slice($academic_records, 2), 2, true);
foreach ($record_chunks as $record_pair):
?>
<div class="sf10-row">
    <?php foreach ($record_pair as $group => $records): 
        $sy = explode(' - ', $group)[0];
        $gradeLevel = explode(' - ', $group)[1];
        $total = 0; $count = 0;
    ?>
    <div class="sf10-col">
        <table>
            <tr class="gray-bg">
                <td colspan="8" class="highlight-section">SCHOLASTIC RECORD</td>
            </tr>
            <tr>
                <td colspan="8">School: <?= $records[0]->schoolName ?? 'N/A'; ?> &nbsp;&nbsp;
                    School ID: <?= $records[0]->schoolID ?? 'N/A'; ?> &nbsp;&nbsp;
                    District: <?= $records[0]->district ?? 'N/A'; ?><br>
                    Division: <?= $records[0]->division ?? 'N/A'; ?> &nbsp;&nbsp;
                    Region: <?= $records[0]->region ?? 'N/A'; ?>
                </td>
            </tr>
            <tr>
                <td colspan="4">Classified as Grade: <?= $gradeLevel; ?> &nbsp;&nbsp; Section: <?= $records[0]->Section; ?></td>
                <td colspan="4">School Year: <?= $sy; ?> &nbsp;&nbsp; Name of Adviser/Teacher: <?= $records[0]->adviser; ?></td>
            </tr>
            <tr><td colspan="8">Signature: ______________________</td></tr>
            <tr>
                <th colspan="2">LEARNING AREAS</th>
                <th>1</th><th>2</th><th>3</th><th>4</th>
                <th>Final Rating</th><th>Remarks</th>
            </tr>
            <?php foreach ($records as $r): 
                $final = $r->Average;
                $remark = ($final >= 75) ? 'PASSED' : 'FAILED';
                $total += $final; $count++;
            ?>
            <tr>
                <td colspan="2"><?= $r->Description; ?></td>
                <td><?= $r->PGrade; ?></td>
                <td><?= $r->MGrade; ?></td>
                <td><?= $r->PFinalGrade; ?></td>
                <td><?= $r->FGrade; ?></td>
                <td><?= number_format($final, 0); ?></td>
                <td><?= $remark; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5" class="center bold">General Average</td>
                <td><strong><?= number_format($total / $count, 2); ?></strong></td>
                <td colspan="2"></td>
            </tr>
        </table>

        <div>Remedial Classes Conducted from (mm/dd/yyyy): __________ to __________</div>
        <table>
            <tr>
                <th>Learning Areas</th><th>Final Rating</th><th>Remedial Class Mark</th>
                <th>Recomputed Final Grade</th><th>Remarks</th>
            </tr>
            <tr><td colspan="5" style="height:30px;"></td></tr>
            <tr><td colspan="5" style="height:30px;"></td></tr>
        </table>
    </div>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>


<!-- CERTIFICATION SECTION -->
<br><br>
<?php for ($i = 1; $i <= 3; $i++): ?>
<div class="certification-box">
    <div class="highlight-section">CERTIFICATION</div>
    <p><span class="cert-label">I CERTIFY</span> that this is a true record of <span class="underline"></span> 
        with LRN <span class="underline"><?= $profile->LRN; ?></span> and that he/she is eligible for admission to Grade 
        <span class="underline"></span>.</p>
    <p>School Name: <span class="underline"></span> &nbsp;&nbsp;
       School ID: <span class="underline"></span> &nbsp;&nbsp;
       Division: <span class="underline"></span> &nbsp;&nbsp;
       Last School Year Attended: <span class="underline"></span></p>
    <br><br>
    <table style="width:100%; border:none;">
        <tr>
            <td style="width: 50%; text-align: center; border-top: none; border-left: none; border-right: none;">
                _________________________<br>
                Date
            </td>
            <td style="width: 50%; text-align: center; border-top: none; border-left: none; border-right: none;">
                _________________________<br>
                Signature of Principal/School Head over Printed Name
            </td>
        </tr>
    </table>
    <p style="text-align:right; margin-right:40px;">(Affix School Seal here)</p>
</div>
<?php endfor; ?>
<p class="small-note">May add Certification Box if needed &nbsp;&nbsp;&nbsp;&nbsp; SFRT Revised 2017</p>

<!-- BACK BUTTON -->
<div style="text-align:right; margin-top:10px;">
    <a href="<?= base_url("Sf10/sf10_elem/$studentNumber?page=1"); ?>" class="btn btn-secondary">Back</a>
</div>

</body>
</html>
