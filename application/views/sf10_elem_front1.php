<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SF10-ES | Permanent Record</title>
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
        .no-border td, .no-border th {
            border: none;
            padding: 2px;
        }
        .center { text-align: center; }
        .bold { font-weight: bold; }
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
    </style>
</head>
<body>

<!-- HEADER -->
<table class="no-border">
    <tr>
        <td style="width: 100px;" class="center">
            <img src="<?= base_url('assets/images/deped2.png'); ?>" alt="Left Logo" style="width: 80px;">
        </td>
        <td colspan="3" class="center">
            <div>Republic of the Philippines<br>Department of Education</div>
            <div class="bold" style="font-size: 14px;">Learner Permanent Academic Record for Elementary School (SF10-ES)</div>
            <div><em>(Formerly Form 137)</em></div>
        </td>
        <td style="width: 100px;" class="center">
            <img src="<?= base_url('assets/images/deped1.png'); ?>" alt="Right Logo" style="width: 90px;">
        </td>
    </tr>
</table>

<!-- LEARNER INFO -->
<table>
    <tr class="gray-bg">
        <td colspan="5" class="highlight-section">LEARNER'S INFORMATION</td>
    </tr>
    <tr>
        <td>LAST NAME: <?= $profile->LastName; ?></td>
        <td>FIRST NAME: <?= $profile->FirstName; ?></td>
        <td>NAME EXT.: <?= $profile->nameExt; ?></td>
        <td>MIDDLE NAME: <?= $profile->MiddleName; ?></td>
        <td rowspan="2">Sex: <?= $profile->Sex; ?><br>Birthdate: <?= $profile->BirthDate; ?></td>
    </tr>
    <tr>
        <td colspan="4">Learner Reference Number (LRN): <?= $profile->LRN; ?></td>
    </tr>
</table>

<!-- ELIGIBILITY -->
<table>
    <tr class="gray-bg">
        <td colspan="5" class="highlight-section">ELIGIBILITY FOR ELEMENTARY SCHOOL ENROLMENT</td>
    </tr>
    <tr>
        <td colspan="5">
            <input type="checkbox" <?= $profile->eligibility == 'Kindergarten Certificate of Completion' ? 'checked' : ''; ?>> Kindergarten Certificate of Completion
            &nbsp;&nbsp;&nbsp; 
            <input type="checkbox" <?= $profile->eligibility == 'PEPT' ? 'checked' : ''; ?>> PEPT Passer - Rating: <?= $profile->peptRating; ?>
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" <?= !in_array($profile->eligibility, ['PEPT','Kindergarten Certificate of Completion']) ? 'checked' : ''; ?>> Others: <?= $profile->eligibility; ?>
        </td>
    </tr>
    <tr>
        <td colspan="5">Name of School: <?= $profile->Elementary; ?> &nbsp;&nbsp; School ID: <?= $profile->elemSchoolID; ?> &nbsp;&nbsp; Address: <?= $profile->ElemAddress; ?></td>
    </tr>
    <tr>
        <td colspan="5">Date of Examination: <?= $profile->peptExamDate; ?> &nbsp;&nbsp; Testing Center: <?= $profile->alsTestingCenter; ?></td>
    </tr>
</table>

<!-- SCHOLASTIC RECORDS (2 per row) -->
<?php
$record_chunks = array_chunk($academic_records, 2, true);
foreach ($record_chunks as $chunk_index => $record_pair):
    if ($chunk_index > 0) break; // Only front page (2 tables max)
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

<!-- PAGE NAVIGATION -->
<div style="text-align:right; margin-top:10px;">
    <a href="<?= base_url("Sf10/sf10_elem/$studentNumber?page=2"); ?>" class="btn btn-primary">Next</a>
</div>

</body>
</html>
