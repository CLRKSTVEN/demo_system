<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SF10-JHS | Permanent Record</title>
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
                color-adjust: exact;
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
        }

        td, th {
            border: 1px solid #000;
            padding: 4px;
        }

        .no-border td, .no-border th {
            border: none;
            padding: 2px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 100px;
        }

        .header-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .sub-header {
            font-size: 10.5px;
            text-align: center;
        }

        .section-title {
            background: #d9d9d9;
            font-weight: bold;
            padding-left: 5px;
        }

        .gray-bg {
            background: #d9d9d9;
        }

        .highlight-section {
            background-color: #d2cba3;
            font-weight: bold;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <table class="no-border">
        <tr>
            <td style="width: 100px; text-align: center;">
                <img src="<?= base_url('assets/images/deped2.png'); ?>" alt="Left Logo" style="width: 80px;">
            </td>
            <td colspan="3" class="center">
                <div class="sub-header">Republic of the Philippines<br>Department of Education</div>
                <div class="header-title">Learner Permanent Academic Record for Junior High School (SF10-JHS)</div>
                <div class="sub-header"><em>(Formerly Form 137)</em></div>
            </td>
            <td style="width: 100px; text-align: center;">
                <img src="<?= base_url('assets/images/deped1.png'); ?>" alt="Right Logo" style="width: 90px;">
            </td>
        </tr>
    </table>
    <table>
        <tr class="gray-bg">
            <td colspan="5" class="highlight-section">LEARNER'S INFORMATION</td>
        </tr>
        <tr>
            <td>LAST NAME: <?= $profile->LastName; ?></td>
            <td>FIRST NAME: <?= $profile->FirstName; ?></td>
            <td>NAME EXT.: <?= $profile->nameExt; ?></td>
            <td>MIDDLE NAME: <?= $profile->MiddleName; ?></td>
            <td rowspan="2">Sex: <?= $profile->Sex; ?><br><br>Birthdate: <?= $profile->BirthDate; ?></td>
        </tr>
        <tr>
            <td colspan="4">Learner Reference Number (LRN): <?= $profile->LRN; ?></td>
        </tr>
    </table>

    <table>
        <tr class="gray-bg">
            <td colspan="5" class="highlight-section">ELIGIBILITY FOR JHS ENROLMENT</td>
        </tr>
        <tr>
            <td colspan="5">
                <input type="checkbox" <?= $profile->eligibility == 'Elementary School Completer' ? 'checked' : ''; ?>> Elementary School Completer &nbsp;&nbsp;&nbsp; General Average: <?= $profile->elemAve; ?> &nbsp;&nbsp;&nbsp; Citation (if Any): __________
            </td>
        </tr>
        <tr>
            <td colspan="5">Name of Elementary School: <?= $profile->Elementary; ?> &nbsp;&nbsp;&nbsp; School ID: <?= $profile->elemSchoolID; ?> &nbsp;&nbsp;&nbsp; Address of School: <?= $profile->ElemAddress; ?></td>
        </tr>
        <tr>
            <td colspan="5">
                Other Credential Presented:
                <input type="checkbox" <?= $profile->eligibility == 'PEPT' ? 'checked' : ''; ?>> PEPT Passer &nbsp; Rating: <?= $profile->peptRating; ?> &nbsp;
                <input type="checkbox" <?= $profile->eligibility == 'ALS' ? 'checked' : ''; ?>> ALS A & E Passer &nbsp; Rating: <?= $profile->alsRating; ?> &nbsp;
                <input type="checkbox" <?= !in_array($profile->eligibility, ['PEPT','ALS','Elementary School Completer']) ? 'checked' : ''; ?>> Others: <?= $profile->eligibility; ?>
            </td>
        </tr>
        <tr>
            <td colspan="5">Date of Examination: <?= $profile->peptExamDate; ?> &nbsp;&nbsp; Testing Center: <?= $profile->alsTestingCenter; ?></td>
        </tr>
    </table>

    <?php foreach ($academic_records as $group => $records): ?>
    <table>
        <tr class="gray-bg">
            <td colspan="8" class="highlight-section">SCHOLASTIC RECORD</td>
        </tr>
        <tr>
            <td colspan="2">School: <?= $school_info->SchoolName; ?></td>
            <td>School ID: <?= $school_info->SchoolIDJHS; ?></td>
            <td>District: <?= $school_info->district; ?></td>
            <td>Division: <?= $school_info->Division; ?></td>
            <td>Region: <?= $school_info->Region; ?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Classified as Grade: <?= explode(' - ', $group)[1]; ?></td>
            <td>Section: <?= $records[0]->Section; ?></td>
            <td>School Year: <?= explode(' - ', $group)[0]; ?></td>
            <td colspan="3">Name of Adviser/Teacher: <?= $records[0]->adviser; ?></td>
            <td colspan="2">Signature: __________________</td>
        </tr>
        <tr>
            <th rowspan="2">LEARNING AREAS</th>
            <th colspan="4">Quarterly Rating</th>
            <th rowspan="2">FINAL RATING</th>
            <th rowspan="2" style="border-right: none;">REMARKS</th>
            <th rowspan="2" style="border-left: none;"></th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
        </tr>
        <?php $total = 0; $count = 0; foreach ($records as $r): $final = $r->Average; $remark = ($final >= 75) ? 'PASSED' : 'FAILED'; $total += $final; $count++; ?>
        <tr>
            <td style="text-align:left"><?= $r->Description; ?></td>
            <td><?= $r->PGrade; ?></td>
            <td><?= $r->MGrade; ?></td>
            <td><?= $r->PFinalGrade; ?></td>
            <td><?= $r->FGrade; ?></td>
            <td><?= number_format($final, 0); ?></td>
            <td style="border-right: none;"><?= $remark; ?></td>
            <td style="border-left: none;"></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5" style="text-align:right;"><strong>General Average</strong></td>
            <td><strong><?= ($count > 0) ? number_format($total / $count, 2) : ''; ?></strong></td>
            <td colspan="2"></td>
        </tr>
    </table>

    <div style="margin-top:5px;">Remedial Classes Conducted from (mm/dd/yyyy): __________ to __________</div>
    <table>
        <thead>
            <tr>
                <th>Learning Areas</th>
                <th>Final Rating</th>
                <th>Remedial Class Mark</th>
                <th>Recomputed Final Grade</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="5" style="height:30px;"></td></tr>
            <tr><td colspan="5" style="height:30px;"></td></tr>
        </tbody>
    </table>
    <br>
    <?php endforeach; ?>

    <div class="highlight-section">CERTIFICATION</div>
    <p>I CERTIFY that this is a true record of <?= $profile->LastName . ', ' . $profile->FirstName . ' ' . $profile->MiddleName; ?> with LRN <?= $profile->LRN; ?> and that he/she is eligible for admission to Grade ______</p>
    <p>Name of School: <?= $school_info->SchoolName; ?> &nbsp;&nbsp;&nbsp; School ID: <?= $school_info->SchoolIDJHS; ?> &nbsp;&nbsp;&nbsp; Last School Year Attended:  </p>

    <br>
    <table class="no-border">
        <tr>
            <td>Date: __________________</td>
            <td class="center">Signature of Principal/School Head over Printed Name</td>
            <td>(Affix School Seal Here)</td>
        </tr>
    </table>
</body>
</html>
