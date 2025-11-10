<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/wcm.ico">
    
    <link href="<?= base_url(); ?>/assets/css/sf9.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="wrap" style="margin-bottom:30px;">


    <table class="wb special">
        <tr>
            <th colspan="8" class="tdnb head">Department of Education<br />Republic of the Philippines</th>
        </tr>
        <tr>
            <th colspan="8" class="tdnb"><span class="head2">Learner Permanent Record for Elementary School (SF10-ES)</span><br /><span class="sb">(Formerly Form 137)</span></th>
        </tr>
        <tr>
            <td colspan="8" class="heading">LEARNER'S PERSONAL INFORMATION</td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr>
            <td class="tdnb">LAST NAME:</td>
            <td class="tdbbs"><?= $stud->LastName; ?></td>
            <td class="tdnb">FIRST NAME:</td>
            <td class="tdbbs"><?= $stud->FirstName; ?></td>
            <td class="tdnb">NAME EXTN. (Jr,I,II)</td>
            <td class="tdbbs">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?= $stud->nameExt; ?></td>
            <td class="tdnb">MIDDLE NAME:</td>
            <td class="tdbbs"><?= $stud->MiddleName; ?></td>
        </tr>
        <tr>
            <td class="tdnb">Learner Reference Number (LRN): </td>
            <td colspan="2" class="tdbbs"><?= $stud->LRN; ?></td>
            <td class="tdnb">Birthdate (mm/dd/yyyy):</td>
            <td colspan="2" class="tdbbs"><?= $stud->BirthDate; ?></td>
            <td class="tdnb">Sex</td>
            <td class="tdbbs"><?= $stud->Sex; ?></td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8" class="heading font16">ELIGIBILITY FOR ELEMENTARY SCHOOL ENROLMENT</td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr style="border:1px solid #222; border-bottom:0">
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr style="border:1px solid #222; border-bottom:0; border-top:0">
            <td colspan="2" class="tdnb">Credential Presented for Grade 1:</td>
            <td colspan="2" class="tdnb"><input type="checkbox" name="" id=""> &nbsp; Kinder Progress Report</td>
            <td colspan="2" class="tdnb"><input type="checkbox" name="" id=""> &nbsp; ECCD Checklist</td>
            <td colspan="2" class="tdnb"><input type="checkbox" name="" id=""> &nbsp; Kindergarten Certificate of Completion</td>
        </tr>
        <tr style="border:1px solid #222; border-bottom:0; border-top:0">
            <td class="tdnb">Name of School:</td>
            <td class="tdbbs"><?= $prin->SchoolName; ?></td>
            <td class="tdnb">School ID:</td>
            <td class="tdbbs"></td>
            <td class="tdnb">Address of School:</td>
            <td colspan="3" class="tdbbs"><?= $prin->SchoolAddress; ?></td>
        </tr>
        <tr style="border:1px solid #222; border-top:0">
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">Other Credential Presented</td>
        </tr>
        <tr>
            <td class="tdnb"><span style="padding-left:50px">&nbsp;</span><input type="checkbox" name="" id=""> &nbsp; PEPT Passer  Rating:</td>
            <td class="tdnb"></td>
            <td colspan="2" class="tdnb">Date of Examination/Assessment (mm/dd/yyyy):</td>
            <td colspan="2" class="tdnb"></td>
            <td class="tdnb"><input type="checkbox" name="" id=""> &nbsp;  Others (Pls. Specify):</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td class="tdnb"><span style="padding-left:50px">&nbsp;</span>Name and Address of Testing Center:</td>
            <td colspan="3" class="tdbbs"></td>
            <td class="tdnb">Remark:</td>
            <td colspan="3" class="tdbbs"></td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8" class="heading">SCHOLASTIC RECORD</td>
        </tr>
        <tr>
            <td colspan="8">
                <?php foreach($semesterstude as $row){ ?>
                <div class="width49">
                    <table style="margin-top:5px">
                        <tr>
                            <td class="tdnb">School:</td>
                            <td colspan="4" class="tdbbs"></td>
                            <td class="tdnb">School ID:</td>
                            <td class="tdbbs"></td>
                        </tr>
                        <tr>
                            <td class="tdnb">District:</td>
                            <td class="tdbbs"></td>
                            <td class="tdnb">Division</td>
                            <td class="tdbbs" colspan="2"></td>
                            <td class="tdnb">Region: </td>
                            <td class="tdbbs"></td>
                        </tr>
                        <tr>
                            <td class="tdnb">Classified as Grade:</td>
                            <td class="tdbbs"></td>
                            <td class="tdnb">Section:</td>
                            <td class="tdbbs" colspan="2"></td>
                            <td class="tdnb">School Year: </td>
                            <td class="tdbbs"></td>
                        </tr>
                        <tr>
                            <td class="tdnb">Name of Adviser/Teacher:</td>
                            <td colspan="4" class="tdbbs"></td>
                            <td class="tdnb">Signature:</td>
                            <td class="tdbbs"></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="tdnb">&nbsp;</td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="text-center"><strong>LEARNING AREAS</strong></td>
                            <td colspan="4" class="text-center"><strong>Quarterly Rating</strong></td>
                            <td rowspan="2" class="text-center"><strong>Final Rating</strong></td>
                            <td rowspan="2" class="text-center"><strong>Remarks</strong></td>
                        </tr>
                        <tr>
                            <td><strong>1</strong></td>
                            <td><strong>2</strong></td>
                            <td><strong>3</strong></td>
                            <td><strong>4</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Mother Tongue</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table style="margin-top:10px; margin-bottom:5px">
                        <tr>
                            <td><strong>Remedial Classes</strong></td>
                            <td colspan="2"><strong>Conducted from:</strong></td>
                            <td colspan="2"><strong>to</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center"><strong>Learning Areas</strong></td>
                            <td class="text-center"><strong>Final Rating</strong></td>
                            <td class="text-center"><strong>Remedial Class Mark</strong></td>
                            <td class="text-center"><strong>Recomputed Final Grade</strong></td>
                            <td class="text-center"><strong>Remarks</strong></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <?php } ?>
            </td>
        </tr>
    </table>


    <div class="blocker"></div>
    <p style="margin-top:20px">For Transfer Out /Elementary School Completer Only</p>
    <div class="twrap" style="margin-bottom:20px">
        <p class="pwbc">CERTIFICATION</p>
        <div class="divtwrap">
    <table>
        <tr>
            <td>I CERTIFY that this is a true record of</td>
            <td class="tdbbs" colspan="2"></td>
            <td>with LRN</td>
            <td class="tdbbs" colspan="2"></td>
            <td>and that he/she is eligible for addmision to Grade</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td>School Name:</td>
            <td class="tdbbs"></td>
            <td>School ID</td>
            <td class="tdbbs"></td>
            <td>Division:</td>
            <td class="tdbbs"></td>
            <td>Last School Year Attended:</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Date</td>
            <td></td>
            <td>Signature of Principal/School Head over Printed Name</td>
            <td></td>
            <td></td>
            <td></td>
            <td>(Affix School Seal here)</td>
        </tr>
    </table>
    </div></div>

    <div class="blocker"></div>
    <div class="twrap" style="margin-bottom:20px">
        <p class="pwbc">CERTIFICATION</p>
        <div class="divtwrap">
    <table>
        <tr>
            <td>I CERTIFY that this is a true record of</td>
            <td class="tdbbs" colspan="2"></td>
            <td>with LRN</td>
            <td class="tdbbs" colspan="2"></td>
            <td>and that he/she is eligible for addmision to Grade</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td>School Name:</td>
            <td class="tdbbs"></td>
            <td>School ID</td>
            <td class="tdbbs"></td>
            <td>Division:</td>
            <td class="tdbbs"></td>
            <td>Last School Year Attended:</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Date</td>
            <td></td>
            <td>Signature of Principal/School Head over Printed Name</td>
            <td></td>
            <td></td>
            <td></td>
            <td>(Affix School Seal here)</td>
        </tr>
    </table>
    </div></div>

    <div class="blocker"></div>
    <div class="twrap">
        <p class="pwbc">CERTIFICATION</p>
        <div class="divtwrap">
    <table>
        <tr>
            <td>I CERTIFY that this is a true record of</td>
            <td class="tdbbs" colspan="2"></td>
            <td>with LRN</td>
            <td class="tdbbs" colspan="2"></td>
            <td>and that he/she is eligible for addmision to Grade</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td>School Name:</td>
            <td class="tdbbs"></td>
            <td>School ID</td>
            <td class="tdbbs"></td>
            <td>Division:</td>
            <td class="tdbbs"></td>
            <td>Last School Year Attended:</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Date</td>
            <td></td>
            <td>Signature of Principal/School Head over Printed Name</td>
            <td></td>
            <td></td>
            <td></td>
            <td>(Affix School Seal here)</td>
        </tr>
    </table>
    </div></div>

    <p style="font-style:italic;"><span style="text-align:left;">May add Certification Box if needed</span><span style="float:right">SFRT Revised 2017</span></p>

</div>





</body>
</html>