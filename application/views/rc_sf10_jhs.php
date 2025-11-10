<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
    
    <link href="<?= base_url(); ?>/assets/css/sf9.css" rel="stylesheet" type="text/css" />
    <style>
        @media print {
            *{
                margin:0; 
                padding:0;
            }

            body{
                font-family: "Times New Roman", Times, serif;
                font-size:16px;
                line-height:1.7em;
            }

            .link {
                display: none;
            }
            .wrap{
                width:100%;
                margin:0;
                background-color:#fff;
            }
            .wrap table td, 
            .wrap table th{
                padding:3px 10px;
                
            }
            .head{
                line-height:1.2em;
                padding-bottom:10px !important;
            }
            .sb{
                padding-bottom:10px;
            }

        }
    </style>
</head>
<body>

<div class="wrap" style="margin-bottom:30px;">


    <table class="wb special">
        <tr>
            <th colspan="8" class="tdnb head">Department of Education<br />Republic of the Philippines</th>
        </tr>
        <tr>
            <th colspan="8" class="tdnb"><span class="head2">Learner Permanent Record for Junior High School (SF10-JHS)</span><br /><span class="sb">(Formerly Form 137)</span></th>
        </tr>
        <tr>
            <td colspan="8" class="heading">LEARNER'S INFORMATION</td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr>
            <td class="tdnb">LAST NAME:</td>
            <td class="tdbbs"><?= str_replace(' ', '&nbsp', $stud->LastName); ?></td>
            <td class="tdnb">FIRST&nbsp;NAME:</td>
            <td class="tdbbs"><?= str_replace(' ', '&nbsp', $stud->FirstName); ?></td>
            <td class="tdnb">NAME&nbsp;EXTN.&nbsp;(Jr,I,II)</td>
            <td class="tdbbs">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?= $stud->nameExt; ?></td>
            <td class="tdnb">MIDDLE&nbsp;NAME:</td>
            <td class="tdbbs"><?= $stud->MiddleName; ?></td>
        </tr>
        <tr>
            <td class="tdnb">Learner&nbsp;Reference&nbsp;Number&nbsp;(LRN): </td>
            <td colspan="2" class="tdbbs"><?= $stud->LRN; ?></td>
            <td class="tdnb" colspan="2">Birthdate&nbsp;(mm/dd/yyyy):</td>
            <td class="tdbbs"><?php $date = DateTime::createFromFormat('Y-m-d', $stud->BirthDate); echo $date->format('m/d/Y'); ?></td>
            <td class="tdnb">Sex</td>
            <td class="tdbbs"><?= $stud->Sex; ?></td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8" class="heading font16">ELIGIBILITY FOR JUNIOR HIGH SCHOOL ENROLMENT</td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr style="border:1px solid #222; border-bottom:0">
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr style="border:1px solid #222; border-bottom:0; border-top:0">
            <td colspan="2" class="tdnb"><input type="checkbox" checked name="" id="">&nbsp;Elementary School Completer</td>
            <td colspan="2" class="tdnb"><input type="checkbox" name="" id="">&nbsp;ECCD&nbsp;Checklist <input style="float:right; margin-top:2px" type="checkbox" name="" id=""></td>
            <td colspan="2" class="tdnb">Kindergarten&nbsp;Certificate&nbsp;of&nbsp;Completion</td>
            <td colspan="2" class="tdnb"></td>
        </tr>
        <tr style="border:1px solid #222; border-bottom:0; border-top:0">
            <td class="tdnb" colspan="2">Name of School:&nbsp;<u><?= str_replace(' ', '&nbsp', $stud->Elementary); ?></u></td>
            <td class="tdnb">School ID:</td>
            <td class="tdbbs"></td>
            <td class="tdnb">Address of School:</td>
            <td colspan="3" class="tdbbs"><?= $stud->ElemAddress; ?></td>
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
            <td class="tdnb"><span style="padding-left:50px">&nbsp;</span><input type="checkbox" name="" id="">&nbsp; PEPT Passer  Rating:</td>
            <td class="tdbbs"></td>
            <td class="tdnb" colspan="2"><input type="checkbox" name="" id="">&nbsp;ALS&nbsp;A&nbsp;&&nbsp;E&nbsp;Passer&nbsp;&nbsp;&nbsp;&nbsp;Rating</td>
            <td class="tdbbs"></td>
            <td colspan="2" class="tdnb"><input type="checkbox" name="" id="">&nbsp;&nbsp;Others&nbsp;(Pls.&nbsp;Specify):</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td colspan="3" class="tdnb"><span style="padding-left:50px">&nbsp;</span>Date&nbsp;of&nbsp;Examination/Assessment(mm/dd/yyyy):</td>
            <td class="tdbbs"></td>
            <td colspan="3" class="tdnb">Name and Address of Testing Center:</td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="8" class="heading">SCHOLASTIC RECORD</td>
        </tr>
        <tr>
            <td colspan="8" class="tdnb" style="padding:20px 0 20px 0">
                <?php 
                    foreach($semesterstude as $row){ 
                        $sub = $this->Common->four_cond('registration', 'SY', $row->SY,'YearLevel',$row->YearLevel,'Section',$row->Section,'StudentNumber',$this->uri->segment(3));
                        $staff = $this->Common->one_cond_row('staff','IDNumber',$row->IDNumber);
                ?>
                <div class="with100">
                    <table style="margin-top:5px; border:1px solid #222">
                        <tr>
                            <td class="tdnb">School:</td>
                            <td colspan="4" class="tdbbs"><?= $prin->SchoolName; ?></td>
                            <td class="tdnb"></td>
                            <td class="tdnb">School ID:</td>
                            <td class="tdbbs"><?= $prin->SchoolIDJHS; ?></td>
                        </tr>
                        <tr>
                            <td class="tdnb">District:</td>
                            <td class="tdbbs"><?= $prin->district; ?></td>
                            <td class="tdnb"></td>
                            <td class="tdnb">Division</td>
                            <td class="tdbbs" colspan="2"><?= $prin->Division; ?></td>
                            <td class="tdnb">Region: </td>
                            <td class="tdbbs"><?= $prin->Region; ?></td>
                        </tr>
                        <tr>
                            <td class="tdnb">Classified as Grade:</td>
                            <td class="tdbbs"><?= $row->YearLevel; ?></td>
                            <td class="tdnb"></td>
                            <td class="tdnb">Section:</td>
                            <td class="tdbbs" colspan="2"><?= $row->Section; ?></td>
                            <td class="tdnb">School Year: </td>
                            <td class="tdbbs"><?= $row->SY; ?></td>
                        </tr>
                        <tr>
                            <td class="tdnb">Name of Adviser/Teacher:</td>
                            <td colspan="4" class="tdbbs"><?php if(!empty($staff)){echo $staff->FirstName.' '.$staff->MiddleName.' '.$staff->LastName; } ?></td>
                            <td class="tdnb"></td>
                            <td class="tdnb">Signature:</td>
                            <td class="tdbbs"></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="tdnb">&nbsp;</td>
                        </tr>
                        <tr>
                            <td rowspan="2" colspan="2" class="text-center"><strong>LEARNING AREAS</strong></td>
                            <td colspan="4" class="text-center"><strong>Quarterly Rating</strong></td>
                            <td rowspan="2" class="text-center"><strong>Final Rating</strong></td>
                            <td rowspan="2" class="text-center"><strong>Remarks</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center"><strong>1</strong></td>
                            <td class="text-center"><strong>2</strong></td>
                            <td class="text-center"><strong>3</strong></td>
                            <td class="text-center"><strong>4</strong></td>
                        </tr>
                        <?php 
                            foreach($sub as $srow){
                            $grade = $this->Common->three_cond_row('grades','StudentNumber',$this->uri->segment(3),'SY',$srow->SY,'SubjectCode',$srow->SubjectCode);
                            if($srow->SubjectCode != 'Dep 8'){
                        ?>
                        <tr>
                            <td colspan="2"><?= $srow->Description; ?></td>
                            <td class="text-center" style="width:8%"><?php if(!empty($grade)){echo number_format($grade->PGrade);} ?></td>
                            <td class="text-center" style="width:8%"><?php if(!empty($grade)){echo number_format($grade->MGrade);} ?></td>
                            <td class="text-center" style="width:8%"><?php if(!empty($grade)){echo number_format($grade->PFinalGrade);} ?></td>
                            <td class="text-center" style="width:8%"><?php if(!empty($grade)){echo number_format($grade->FGrade);} ?></td>
                            <td class="text-center"><?php if(!empty($grade)){if($grade->Average > 50){echo number_format($grade->Average); }} ?></td>
                            <td></td>
                        </tr>
                        <?php }} ?>
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
    <div class="twrap">
        <p class="pwbc">CERTIFICATION</p>
        <div class="divtwrap">
    <table>
        <tr>
            <td><?= str_replace(' ', '&nbsp', 'I CERTIFY that this is a true record of'); ?></td>
            <td class="tdbbs" colspan="2"><?= str_replace(' ', '&nbsp', $stud->FirstName.' '.$stud->MiddleName.' '.$stud->LastName); ?> </td>
            <td>with&nbsp;LRN</td>
            <td class="tdbbs"><?= $stud->LRN; ?></td>
            <td colspan="2"><?= str_replace(' ', '&nbsp', 'and that he / she is eligible for addmision to Grade'); ?></td>
            <td class="tdbbs"></td>
        </tr>
        <tr>
            <td>School Name:</td>
            <td class="tdbbs"><?= str_replace(' ','&nbsp', $prin->SchoolName); ?></td>
            <td>School&nbsp;ID</td>
            <td class="tdbbs"><?= $prin->SchoolIDJHS; ?></td>
            <td>Division:</td>
            <td class="tdbbs"><?= $prin->Division; ?></td>
            <td><?= str_replace(' ', '&nbsp', 'Last School Year Attended:'); ?></td>
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
            <td>Date</td>
            <td colspan="4"><?= str_replace(' ', '&nbsp', 'Signature of Principal/School Head over Printed Name'); ?></td>
            <td></td>
            <td></td>
            <td><?= str_replace(' ', '&nbsp', '(Affix School Seal here)'); ?></td>
        </tr>
    </table>
    </div></div>

    <p style="font-style:italic;"><span style="text-align:left;">May add Certification Box if needed</span><span style="float:right">SFRT Revised 2017</span></p>

</div>





</body>
</html>