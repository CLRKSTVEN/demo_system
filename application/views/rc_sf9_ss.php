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

<div class="link">
    <a href="<?= base_url(); ?>Ren/rc_sf9_ssp2/<?= $this->uri->segment(3); ?>">Page 2</a>
</div>


<div class="wrap">


    <div class="cleft">
        <div class="tw">
        <table class="wb">
            <tr>
                <th colspan="13" class="tdnb" style="padding-bottom:30px">Attendance Record</th>
            </tr>
            <tr>
                <th></th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>No. of School Days</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td>No. of Days Present</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td>No. of Times Absent</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <th colspan="13" class="tdnb p30tb">PARENT/GUARDIAN'S SIGNATURE</td>
            </tr>
            <tr>
                <td class="tdnb">1<sup>st</sup> Quarter</td>
                <td colspan="9" class="tdbbs"></td>
                <td class="tdnb"></td>
                <td class="tdnb"></td>
                <td class="tdnb"></td>
            </tr>
            <tr>
                <td class="tdnb">2<sup>nd</sup>  Quarter</td>
                <td colspan="9" class="tdbbs"></td>
                <td class="tdnb"></td>
                <td class="tdnb"></td>
                <td class="tdnb"></td>
            </tr>
            <tr>
                <td class="tdnb">3<sup>rd</sup>  Quarter</td>
                <td colspan="9" class="tdbbs"></td>
                <td class="tdnb"></td>
                <td class="tdnb"></td>
                <td class="tdnb"></td>
            </tr>
            <tr>
                <td class="tdnb">4<sup>th</sup>  Quarter</td>
                <td colspan="9" class="tdbbs"></td>
                <td class="tdnb"></td>
                <td class="tdnb"></td>
                <td class="tdnb"></td>
            </tr>
        </table>
        <table>
        <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" style="padding:10px 0">Certificate of Transfer</th>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td>Admitted Grade</td>
                <td class="tdbb"><?= $cur_stud->Course; ?></td>
                <td>Section</td>
                <td class="tdbb" colspan="4"><?= $sem_stud->Section; ?></td>
            </tr>

            <tr>
                <td>Eligible for Admission to Grade</td>
                <td colspan="5" class="tdbb">dsDSA </td>
            </tr>
            <tr>
                <td colspan="6">Approved:</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="tdbb">&nbsp;</td>
                <td colspan="2"></td>
                <td colspan="2" class="tdbb"></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">Head Teacher/Principal</td>
                <td colspan="2"></td>
                <td colspan="2" class="text-center">Teacher</td>
            </tr>
            <tr>
                <td colspan="6" class="text-center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" class="text-center">Cancellation of Eligibility to Transfer</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>Admitted in</td>
                <td colspan="5" class="tdbb"></td>
            </tr>
            <tr>
                <td>Date:</td>
                <td colspan="2" class="tdbb"></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2" class="tdbb">&nbsp;</td>
            </tr>
            
            <tr>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2" class="text-center">Principal</td>
            </tr>
        </table>
        </div>

    </div>

    <div class="cright">
        <div class="tw">
        <table>
            <tr>
                <th colspan="6">DIVISION OF </th>
            </tr>
            <tr>
                <td colspan="6" class="text-center" style="padding-bottom:20px;">Division </td>
            </tr>
            <tr>
                <th colspan="6">LEARNER'S PROGRESS REPORT CARD</th>
            </tr>
            <tr>
                <td colspan="6" class="text-center" style="padding-bottom:20px;">School </td>
            </tr>
            <tr>
                <td>Name:</td>
                <td class="tdbb text-center"><?= $stud->LastName; ?></td>
                <td colspan="2" class="tdbb text-center"><?= $stud->FirstName; ?></td>
                <td colspan="2" class="tdbb text-center"><?= $stud->MiddleName; ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="text-center">LastName</td>
                <td colspan="2" class="text-center">FirstName</td>
                <td colspan="2" class="text-center">MiddleName</td>
            </tr>
            <tr>
                <td>Age:</td>
                <td class="tdbb"><?= $stud->Age; ?></td>
                <td class="tdbb"></td>
                <td>Sex:</td>
                <td class="tdbb" colspan="2"><?= $stud->Sex; ?></td>
            </tr>
            <tr>
                <td>Grade:</td>
                <td class="tdbb"><?= $cur_stud->Course; ?></td>
                <td>Section:</td>
                <td class="tdbb" colspan="3"><?= $sem_stud->Section; ?></td>
                
            </tr>
            <tr>
                <td>Curriculum:</td>
                <td class="tdbb" colspan="4"></td>
            </tr>
            <tr>
                <td>School Year:</td>
                <td class="tdbb" colspan="4"><?= $this->session->sy; ?></td>
            </tr>
            <tr>
                <td>Track/Strand:</td>
                <td class="tdbb" colspan="4"></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">
                    <p>Dear Parent/Guardian,</p>
                    <p class="indent50">This report shows the ability and the progress your child has made in the different learning areas as well as his/her progress in core values.</p>
                    <p class="indent50">The school welcomes you should you desire to know more about your child's progress.</p>
                </td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="3"></td>
                <td colspan="3" class="tdbb">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="3" class="text-center">Adviser</td>
            </tr>
            <tr>
                <td colspan="3" class="tdbb"></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">Head Teacher/Principal</td>
                <td colspan="3"></td>
            </tr>
            
            
        </table>
        </div>

    </div>


    <div class="blocker"></div>

</div>





</body>
</html>