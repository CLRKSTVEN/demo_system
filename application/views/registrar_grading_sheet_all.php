<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
    <link href="<?= base_url(); ?>assets/css/renren.css" rel="stylesheet" type="text/css" />

    <title>Grading Sheets</title>

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: verdana, Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.7em;
        }

        .wrap {
            width: 80%;
            margin: auto;
            margin-top: 30px;
        }

        .banner {
            width: 100%;
            margin-bottom: 40px;
        }

        .wrap p {
            text-align: justify;
        }

        .corhead {
            text-align: center;
            margin-bottom: 30px;
        }

        .cor {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cor,
        .cor th {
            border-bottom: 1px solid #000;
            padding: 12px 0;
        }

        .cor th {
            text-align: left;
        }

        .cor .des {
            border-bottom: 5px solid #1a34fc;
        }

        .cor td {
            padding: 12px 0;
        }

        .label {
            font-weight: normal;
        }

        .stud_sign,
        .adviser {
            width: 50%;
            text-align: center;
            float: left;
        }

        .stud_sign span {
            font-weight: normal;
            display: block;
        }

        .registrar h3 {
            font-size: 16px;
        }

        .registrar {
            margin-bottom: 30px;
        }

        .registrar span {
            font-weight: normal;
            display: block;
        }

        .adviser h4 {
            border-top: 1px solid #000;
        }

        .cert p {
            font-size: 16px;
            line-height: 1.7em;
            margin-bottom: 20px;
        }

        .cert h4 {
            margin-bottom: 35px;
        }

        .registrar {
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .renren {
            background-color: #2f353f;
            padding: 20px 100px;
        }

        .custom-select {
            border: 1px solid red;
        }

        .gm {
            background-color: #3bc0c3;
            padding: 3px 15px;
            border: 1px solid #3bc0c3;
            cursor: pointer;
            color: #fff;
            border-radius: 5px;
        }


        .studProf {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 80px;
        }

        .studProf,
        .studProf th,
        .studProf td {
            padding: 8px 10px;
        }

        .dr {
            width: 100%;
            border-collapse: collapse;
            border: 3px solid #eaeaea;
        }

        .dr,
        .dr th,
        .dr td {
            padding: 8px 10px;
        }

        .dsp {
            margin-bottom: 80px;
        }

        .signature {
            border-top: 1px solid #222;
            display: inline-block;
            margin-right: 100px;
            text-align: center !important;
            margin-top: 50px;
            width: 25%;
        }

        .twrap {
            width: 60%;
            margin: auto;
            margin-bottom: 50px;
        }

        .twrap table {
            width: 100%;
            border-collapse: collapse;
        }

        .twrap td {
            border: 1px solid #222;
            padding: 2px 10px;
        }

        .text-center {
            text-align: center;
        }

        .theading {
            font-weight: bold;
        }

        .borderless {
            border: 0 !important;
        }

        .bb {
            border-top: 0 !important;
            border-left: 0 !important;
            border-right: 0 !important;
        }

        .gh {
            margin: 50px 0 10px 0;
            text-align: center;
        }

        .gsh {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .bblue {
            border-bottom: 3px solid #0a10ff !important;
        }

        .mtop {
            padding-top: 20px !important;
        }

        .signright {
            float: left;
            width: 50%;
            margin-top: 30px;
        }

        .signright .sl2 {
            margin-left: 150px;
            display: inline-block;
            margin-top: 50px;
        }

        .signright .sl2 span {
            display: block;
            text-align: center;

        }

        .conswrap {
            width: 90%;
            margin: auto;
        }

        .cons,
        .cons td,
        .cons th {
            border: 1px solid #222;
            text-align: center;
        }

        .cons td,
        .cons th {
            padding: 5px 10px;
        }

        .cons {
            border-collapse: collapse;
            margin-top: 30px;
            width: 100%;
            margin-bottom: 50px;
        }

        .cons th {
            font-weight: normal;
        }

        .blocker {
            clear: both !important
        }


        @page {
            size: A4;
            margin: 10mm 25mm 10mm 27mm;
            padding: 0 !important;
        }


        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
                line-height: 1.2em;
                font-size: 16px;
            }

            .wrap {
                margin: auto;
                width: 100%;
            }

            .cor {
                margin-bottom: 50px;
            }

            .cor,
            th,
            td {
                padding: 3px 0;
            }

            .renren {
                display: none;
            }

            .wrap h1 {
                font-size: 40px;
            }

            .wrap p {
                text-align: justify;
                font-size: 20px !important;
            }

            .studProf {
                margin-bottom: 30px;
            }

            .studProf td,
            .studProf th {
                padding: 5px 0;
                font-size: 16px;
            }

            .signature {
                width: 20%;
            }



        }
    </style>
</head>

<body>

    <div class="twrap">
        <img class="print-only" src="<?= base_url(); ?>upload/banners/<?= $so->letterhead_web; ?>" alt="mySRMS Portal" width="100%">


        <h1 class="gh">GRADING SHEET</h1>




        <?php
        function getLetterGrade($grade)
        {
            if ($grade === null || $grade === '') return '';
            if ($grade >= 90) return 'A';
            if ($grade >= 85) return 'B+';
            if ($grade >= 80) return 'B';
            if ($grade >= 75) return 'C';
            return 'F';
        }
        ?>

        <table>
            <tr>
                <td class="borderless">Subject Code: </td>
                <td class="bb"><?= $grade->SubjectCode; ?></td>
                <td class="borderless">Sem./SY:</td>
                <td class="bb"><?= $grade->SY; ?></td>
            </tr>
            <tr>
                <td class="borderless">Description</td>
                <td class="bb"><?= $grade->Description; ?></td>
                <td class="borderless">Section</td>
                <td class="bb"><?= $grade->Section; ?></td>
            </tr>
            <tr>
                <td class="borderless">&nbsp;</td>
                <td class="borderless"></td>
                <td class="borderless"></td>
                <td class="borderless"></td>
            </tr>
            <tr>
                <td class="theading bblue">LRN</td>
                <td class="theading bblue">Student Name</td>
                <td class="theading text-center bblue">1</td>
                <td class="theading text-center bblue">2</td>
                <td class="theading text-center bblue">3</td>
                <td class="theading text-center bblue">4</td>
                <td class="theading text-center bblue">Ave.</td>
                <td class="theading text-center bblue">Remarks</td>
            </tr>
            <tr>
                <td><b>FEMALE</b></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
            $fs = $this->Common->two_join_four_cond('grades', 'studeprofile', 'a.StudentNumber, b.StudentNumber, a.SY, a.Sem, b.FirstName, b.MiddleName, b.LastName,a.Instructor,a.SubjectCode,a.Description,a.Section,a.adviser,a.gradeID,a.PGrade, a.MGrade, a.PFinalGrade, a.FGrade, a.Average,  a.firstStat, a.secondStat, a.thirdStat, a.fourthStat, a.YearLevel, b.Sex, b.LRN', 'a.StudentNumber = b.StudentNumber', 'SY', $grade->SY, 'Section', $grade->Section, 'SubjectCode', $grade->SubjectCode, 'Sex', 'Female', 'LastName', 'ASC');
            $ms = $this->Common->two_join_four_cond('grades', 'studeprofile', 'a.StudentNumber, b.StudentNumber, a.SY, a.Sem, b.FirstName, b.MiddleName, b.LastName,a.Instructor,a.SubjectCode,a.Description,a.Section,a.adviser,a.gradeID,a.PGrade, a.MGrade, a.PFinalGrade, a.FGrade, a.Average,  a.firstStat, a.secondStat, a.thirdStat, a.fourthStat, a.YearLevel, b.Sex, b.LRN', 'a.StudentNumber = b.StudentNumber', 'SY', $grade->SY, 'Section', $grade->Section, 'SubjectCode', $grade->SubjectCode, 'Sex', 'Male', 'LastName', 'ASC');
            foreach ($fs as $row) {
            ?>
                <tr>
                    <td><?= $row->LRN; ?></td>
                    <td><?= $row->LastName; ?>, <?= $row->FirstName; ?> <?php if ($row->MiddleName != '') {
                                                                            echo substr($row->MiddleName, 0, 1) . '. ';
                                                                        } ?></td>
                    <?php if ($gradeDisplay === 'Letter'): ?>
                        <td class="text-center"><?= getLetterGrade($row->PGrade); ?></td>
                        <td class="text-center"><?= getLetterGrade($row->MGrade); ?></td>
                        <td class="text-center"><?= getLetterGrade($row->PFinalGrade); ?></td>
                        <td class="text-center"><?= getLetterGrade($row->FGrade); ?></td>
                        <td class="text-center"><?= getLetterGrade($row->Average); ?></td>
                        <td class="text-center"><?= (getLetterGrade($row->Average) === 'F') ? 'Failed' : 'Passed'; ?></td>
                    <?php else: ?>
                        <td class="text-center"><?= number_format($row->PGrade, 2); ?></td>
                        <td class="text-center"><?= number_format($row->MGrade, 2); ?></td>
                        <td class="text-center"><?= number_format($row->PFinalGrade, 2); ?></td>
                        <td class="text-center"><?= number_format($row->FGrade, 2); ?></td>
                        <td class="text-center"><?= number_format($row->Average, 2); ?></td>
                        <td class="text-center"><?= ($row->Average <= 74.4) ? 'Failed' : 'Passed'; ?></td>
                    <?php endif; ?>
                </tr>
            <?php } ?>

            <tr>
                <td class="mtop"><b>MALE</b></td>
                <td class="mtop"></td>
                <td class="mtop"></td>
                <td class="mtop"></td>
            </tr>

            <?php foreach ($ms as $row) {
            ?>
                <tr>
                    <td><?= $row->LRN; ?></td>
                    <td><?= $row->LastName; ?>, <?= $row->FirstName; ?> <?php if ($row->MiddleName != '') {
                                                                            echo substr($row->MiddleName, 0, 1) . '. ';
                                                                        } ?></td>
                    <?php if ($gradeDisplay === 'Letter'): ?>
                        <td class="text-center"><?= getLetterGrade($row->PGrade); ?></td>
                        <td class="text-center"><?= getLetterGrade($row->MGrade); ?></td>
                        <td class="text-center"><?= getLetterGrade($row->PFinalGrade); ?></td>
                        <td class="text-center"><?= getLetterGrade($row->FGrade); ?></td>
                        <td class="text-center"><?= getLetterGrade($row->Average); ?></td>
                        <td class="text-center"><?= (getLetterGrade($row->Average) === 'F') ? 'Failed' : 'Passed'; ?></td>
                    <?php else: ?>
                        <td class="text-center"><?= number_format($row->PGrade, 2); ?></td>
                        <td class="text-center"><?= number_format($row->MGrade, 2); ?></td>
                        <td class="text-center"><?= number_format($row->PFinalGrade, 2); ?></td>
                        <td class="text-center"><?= number_format($row->FGrade, 2); ?></td>
                        <td class="text-center"><?= number_format($row->Average, 2); ?></td>
                        <td class="text-center"><?= ($row->Average <= 74.4) ? 'Failed' : 'Passed'; ?></td>
                    <?php endif; ?>
                </tr>
            <?php } ?>

        </table>


        <div class="signright">
            <p class="sl1">Submitted by: </p>
            <p class="sl2"><b>LAILA NEGRADAS GALIMBA</b><span>Teacher</span></p>
        </div>

        <div class="signright">
            <p class="sl1">Received/Checked by: </p>
            <p class="sl2">_______________________________</p>
        </div>

        <div class="blocker"></div>


    </div>



</body>

</html>