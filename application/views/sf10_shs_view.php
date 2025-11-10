<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SF10-SHS | Permanent Record</title>
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
  <table class="no-border" style="margin-bottom: 10px;">
    <tr>
        <td style="width: 110px; text-align: center;">
            <img src="<?= base_url('assets/images/deped2.png'); ?>" alt="Logo Left" style="width: 90px;">
        </td>
        <td colspan="3" class="center">
            <div style="font-size: 11px;">REPUBLIC OF THE PHILIPPINES<br>DEPARTMENT OF EDUCATION</div>
            <div style="font-size: 15px; font-weight: bold;">SENIOR HIGH SCHOOL STUDENT PERMANENT RECORD</div>
        </td>
        <td style="width: 110px; text-align: center;">
            <img src="<?= base_url('assets/images/deped1.png'); ?>" alt="Logo Right" style="width: 100px;">
            <div style="font-size: 10px;">FORM 137-SHS</div>
        </td>
    </tr>
</table>

<!-- LEARNER'S INFORMATION -->
<table border="1" style="width:100%; border-collapse: collapse; font-size: 10.5px;">
    <tr>
        <td colspan="5" class="highlight-section">LEARNER'S INFORMATION</td>
    </tr>
    <tr>
        <td style="width: 25%;">LAST NAME: <strong><?= $profile->LastName; ?></strong></td>
        <td style="width: 25%;">FIRST NAME: <strong><?= $profile->FirstName; ?></strong></td>
        <td style="width: 25%;">MIDDLE NAME: <strong><?= $profile->MiddleName; ?></strong></td>
        <td style="width: 15%;">LRN: <strong><?= $profile->LRN; ?></strong></td>
        <td style="width: 10%;">Sex: <strong><?= $profile->Sex; ?></strong></td>
    </tr>
    <tr>
        <td colspan="2">Date of Birth (MM/DD/YYYY): <strong><?= $profile->BirthDate; ?></strong></td>
        <td colspan="2">Date of SHS Admission (MM/DD/YYYY): <strong></strong></td>
        <td></td>
    </tr>
</table>

<!-- ELIGIBILITY -->
<table border="1" style="width:100%; border-collapse: collapse; font-size: 10.5px; margin-top: 8px;">
    <tr>
        <td colspan="5" class="highlight-section">ELIGIBILITY FOR SHS ENROLMENT</td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="checkbox" <?= $profile->eligibility == 'High School Completer' ? 'checked' : ''; ?>> High School Completer*
            &nbsp;&nbsp; Gen. Ave: <strong><?= $profile->elemAve; ?></strong>
        </td>
        <td>
            <input type="checkbox" <?= $profile->eligibility == 'Junior High School Completer' ? 'checked' : ''; ?>> Junior High School Completer
            &nbsp;&nbsp; Gen. Ave: <strong><?= $profile->jhsAve; ?></strong>
        </td>
        <td colspan="2">Date of Graduation/Completion (MM/DD/YYYY): <strong></strong></td>
    </tr>
    <tr>
        <td colspan="3">Name of School: <strong><?= $profile->Elementary; ?></strong></td>
        <td colspan="2">School Address: <strong><?= $profile->ElemAddress; ?></strong></td>
    </tr>
    <tr>
        <td colspan="5">
            <input type="checkbox" <?= $profile->eligibility == 'PEPT' ? 'checked' : ''; ?>> PEPT Passer**
            &nbsp;&nbsp; Rating: <strong><?= $profile->peptRating; ?></strong>
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" <?= $profile->eligibility == 'ALS' ? 'checked' : ''; ?>> ALS A&E Passer***
            &nbsp;&nbsp; Rating: <strong><?= $profile->alsRating; ?></strong>
            &nbsp;&nbsp;&nbsp;
            <input type="checkbox" <?= !in_array($profile->eligibility, ['PEPT', 'ALS', 'High School Completer', 'Junior High School Completer']) ? 'checked' : ''; ?>> Others (Pls. Specify): <strong><?= $profile->eligibility; ?></strong>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            Date of Examination/Assessment (MM/DD/YYYY): <strong><?= $profile->peptExamDate; ?></strong>
            &nbsp;&nbsp; Name and Address of Community Learning Center: <strong><?= $profile->alsTestingCenter; ?></strong>
        </td>
    </tr>
    <tr>
        <td colspan="5" style="font-size: 9.5px;">
            <em>
                *High School Completers are students who graduated from secondary school under the old curriculum<br>
                **PEPT - Philippine Educational Placement Test for JHS<br>
                ***ALS A&E - Alternative Learning System Accreditation and Equivalency Test for JHS
            </em>
        </td>
    </tr>
</table>


   <?php foreach ($academic_records as $group => $records): ?>
<table border="1" style="width: 100%; border-collapse: collapse; font-size: 10.5px; margin-bottom: 15px;">
    <tr class="highlight-section">
        <td colspan="8">SCHOLASTIC RECORD</td>
    </tr>
    <tr>
        <td colspan="2">School: <?= $school_info->SchoolName; ?></td>
        <td>School ID: <?= isset($school_info->SchoolIDSHS) ? $school_info->SchoolIDSHS : ''; ?></td>

        <td>Grade Level: <?= explode(' - ', $group)[1]; ?></td>
        <td>SY: <?= explode(' - ', $group)[0]; ?></td>
        <td>Semester: <?= $records[0]->Sem ?? ''; ?></td>

        <td colspan="2">Section: <?= $records[0]->Section; ?></td>
    </tr>
    <tr>
        <th>Track/Strand:</th>
        <td colspan="7"><?= ($records[0]->track ?? '') . ' / ' . ($records[0]->strand ?? ''); ?></td>

    </tr>
    <tr style="background-color: #d9d9d9;">
        <th rowspan="2">Subject Type<br>(Core, Applied, Specialized)</th>
        <th colspan="3" rowspan="2">SUBJECTS</th>
        <th colspan="2">Quarter</th>
        <th rowspan="2">SEM FINAL GRADE</th>
        <th rowspan="2">ACTION TAKEN</th>
    </tr>
   <tr style="background-color: #d9d9d9;">
    <!-- <th style="width: 12%;">Subject Type</th> -->
    <!-- <th colspan="3" style="width: 33%;">Subjects</th> -->
    <th style="width: 10%;">1</th>
    <th style="width: 10%;">2</th>
    <!-- <th style="width: 15%;">Sem Final Grade</th> -->
    <!-- <th style="width: 10%;">Action Taken</th> -->
</tr>

<?php
$total = 0; $count = 0;
foreach ($records as $r):
    $final = $r->Average;
    $remark = ($final >= 75) ? 'PASSED' : 'FAILED';
    $total += $final;
    $count++;
?>
<tr>
    <td><?= !empty($r->subComponent) ? strtoupper($r->subComponent) : ''; ?></td>
    <td colspan="3"><?= $r->Description; ?></td>
    <td style="text-align: center;"><?= $r->PGrade ?? ''; ?></td>
    <td style="text-align: center;"><?= $r->MGrade ?? ''; ?></td>
    <td style="text-align: center;"><?= number_format($final, 0); ?></td>
    <td style="text-align: center;"><?= $remark; ?></td>
</tr>
<?php endforeach; ?>

<tr>
    <td colspan="6" style="text-align:right;"><strong>General Ave. for the Semester</strong></td>
    <td style="text-align: center;"><strong><?= ($count > 0) ? number_format($total / $count, 2) : ''; ?></strong></td>
    <td></td>
</tr>

</table>

<!-- REMARKS and SIGNATURES -->
<table style="width: 100%; font-size: 10.5px; margin-bottom: 5px;">
    <tr>
        <td style="width: 33%;">REMARKS<br><br>Prepared by<br><br>_________________________<br><small>Signature of Adviser over Printed Name</small></td>
        <td style="width: 34%;">Certified True and Correct:<br><br><br>_________________________<br><small>Signature of Authorized Person, Designation</small></td>
        <td style="width: 33%;">Date Checked (MM/DD/YYYY): ____________________</td>
    </tr>
</table>

<!-- REMEDIAL CLASSES -->
<div style="margin-top: 5px;">REMEDIAL CLASSES conducted from (MM/DD/YYYY): __________ to __________</div>
<table border="1" style="width: 100%; border-collapse: collapse; font-size: 10.5px;">
    <tr style="background-color: #d9d9d9;">
        <th style="width: 15%;">Subject Type</th>
        <th style="width: 35%;">Subjects</th>
        <th style="width: 10%;">SEM FINAL GRADE</th>
        <th style="width: 15%;">REMEDIAL CLASS MARK</th>
        <th style="width: 15%;">RECOMPUTED FINAL GRADE</th>
        <th style="width: 10%;">ACTION TAKEN</th>
    </tr>
    <tr><td colspan="6" style="height: 25px;"></td></tr>
    <tr><td colspan="6" style="height: 25px;"></td></tr>
</table>

<!-- REMEDIAL SIGNATURE FOOTER -->
<table style="width: 100%; font-size: 10.5px; margin-top: 5px;">
    <tr>
        <td style="width: 60%;">Name of Teacher/Adviser: ____________________________</td>
        <td>Signature: _____________________</td>
    </tr>
    <tr>
        <td colspan="2">
            School: ________________________ &nbsp;&nbsp;&nbsp;
            School ID: ____________ &nbsp;&nbsp;&nbsp;
            Grade Level: ____________ &nbsp;&nbsp;&nbsp;
            SY: ____________ &nbsp;&nbsp;&nbsp;
            Sem: ____________
        </td>
    </tr>
</table>
<br>
<?php endforeach; ?>


    <div class="highlight-section"></div>
    <!-- <p>I CERTIFY that this is a true record of <?= $profile->LastName . ', ' . $profile->FirstName . ' ' . $profile->MiddleName; ?> with LRN <?= $profile->LRN; ?> and that he/she is eligible for admission to Grade ______</p> -->
    <!-- <p>Name of School: <?= $school_info->SchoolName; ?> &nbsp;&nbsp;&nbsp; School ID: <?= $school_info->SchoolIDJHS; ?> &nbsp;&nbsp;&nbsp; Last School Year Attended:  </p> -->

    <br>
<!-- FINAL CERTIFICATION SECTION (MATCHED TO IMAGE) -->
<table border="1" style="width: 100%; font-size: 10.5px; border-collapse: collapse; margin-top: 1px;">
    <tr style="border-right: none; border-bottom: none;">
        <!-- LEFT: TRACK / AWARDS / CERTIFICATION -->
        <td style="width: 75%; padding: 8px; vertical-align: top;">
            <div>Track/Strand Accomplished: ____________________________________________</div>
            <div>Awards/Honors Received: _______________________________________________</div>
            <div style="margin-top: 10px;">Certified by:</div>

            <table style="width: 100%; margin-top: 15px; border: none;">
                <tr>
                    <td style="text-align: center; border: none;">
                        ___________________________<br>
                        <small>Signature of School Head over Printed Name</small>
                    </td>
                    <td style="text-align: center; border: none;">
                        ___________________________<br>
                        <small>Date</small>
                    </td>
                </tr>
            </table>

            <!-- Nested box for NOTE and REMARKS -->
            <div style="border: 1px solid #000; margin-top: 15px; padding: 6px;">
                <strong>NOTE:</strong><br>
                This permanent record or a photocopy of this permanent record that bears the seal of the school and the original signature in ink of the School Head shall be considered valid for all legal purposes. Any erasure or alteration made on this copy should be validated by the School Head.<br><br>
                If the student transfers to another school, the originating school should produce one (1) certified true copy of this permanent record for safekeeping. The receiving school shall continue filling up the original form.<br><br>
                Upon graduation, the school from which the student graduated should keep the original form and produce one (1) certified true copy for the Division Office.<br><br>
                <strong>REMARKS:</strong> (Please indicate the purpose for which this permanent record will be used)
            </div>

            <div style="margin-top: 10px;">Date Issued (MM/DD/YYYY): ___________________________</div>
        </td>

        <!-- RIGHT: SEAL BOX -->
        <td style="width: 25%; text-align: center; vertical-align: top; padding: 8px;">
            <strong>Place School Seal Here:</strong>
            <div style="border: none; height: 200px; margin-top: 20px;"></div>
        </td>
    </tr>
</table>

</body>
</html>
