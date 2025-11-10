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
    <a href="<?= base_url(); ?>Ren/rc_sf9_esv2/<?= $this->uri->segment(3); ?>">Page 2</a>
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
    <?php foreach ($months as $month): ?>
        <th><?= date('M', strtotime($month)); ?></th>
    <?php endforeach; ?>
    <th>Total</th>
</tr>
<tr>
    <td>No. of School Days</td>
    <?php $total = 0; foreach ($months as $month): $val = $days_of_school[$month] ?? 0; $total += $val; ?>
        <td><?= $val ?: ''; ?></td>
    <?php endforeach; ?>
    <td><?= $total ?: ''; ?></td>
</tr>
<tr>
    <td>No. of Days Present</td>
    <?php $total = 0; foreach ($months as $month): $val = $days_present[$month] ?? 0; $total += $val; ?>
        <td><?= $val ?: ''; ?></td>
    <?php endforeach; ?>
    <td><?= $total ?: ''; ?></td>
</tr>
<tr>
    <td>No. of Times Absent</td>
    <?php $total = 0; foreach ($months as $month): $val = $days_absent[$month] ?? 0; $total += $val; ?>
        <td><?= $val ?: ''; ?></td>
    <?php endforeach; ?>
    <td><?= $total ?: ''; ?></td>
</tr>
            <tr>
                <th colspan="13" class="tdnb" style="padding:50px 0">PARENT/GUARDIAN'S SIGNATURE</td>
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
        </div>

    </div>

    <div class="cright">
        <div class="tw">
        <table>
            <tr>
                <th colspan="6">LEARNER'S PROGRESS REPORT CARD</th>
            </tr>
            <tr>
                <td colspan="6" class="text-center" style="padding-bottom:20px;">School Year <?= $this->session->sy; ?></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td colspan="5" class="tdbb"><?= $stud->LastName; ?>, <?= $stud->FirstName; ?> <?= $stud->MiddleName; ?></td>
            </tr>
            <tr>
                <td>Age:</td>
                <td class="tdbb"><?= $stud->Age; ?></td>
                <td class="tdbb"></td>
                <td class="tdbb"></td>
                <td>Sex:</td>
                <td class="tdbb"><?= $stud->Sex; ?></td>
            </tr>
            <tr>
                <td>Grade:</td>
                <td class="tdbb"><?= $cur_stud->Course; ?></td>
                <td>Section:</td>
                <td class="tdbb"><?= $sem_stud->Section; ?></td>
                <td>LRN:</td>
                <td class="tdbb"><?= $stud->LRN; ?></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">
                    <p>Dear Parent,</p>
                    <p class="indent50">This report shows the ability and the progress your child has made in the different learning areas as well as his/her progress in core values,</p>
                    <p class="indent50">The school welcomes you should you desire to know more about your child's progress.</p>
                </td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="3"></td>
                <td colspan="3" class="tdbb text-center"><?= $cur_stud->Adviser; ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-center"></td>
                <td colspan="3" class="text-center">Teacher</td>
            </tr>
            <tr>
                <td colspan="3" class="tdbb text-center"><?= $prin->principalPre; ?></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">Head Teacher/Principal</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" class="ct">Certificate of Transfer</th>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>

            <tr>
                <td>Admitted Grade</td>
                <td class="tdbb"><?= $cur_stud->Course; ?></td>
                <td>Section</td>
                <td class="tdbb"><?= $sem_stud->Section; ?></td>
                <td>Room</td>
                <td class="tdbb"></td>
            </tr>

            <tr>
                <td colspan="2">Eligible for Admission to Grade</td>
                <td colspan="4" class="tdbb"></td>
            </tr>
            <tr>
                <td colspan="6">Approved:</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="tdbb text-center"><?= $prin->principalPre; ?></td>
                <td colspan="2"></td>
                <td colspan="2" class="tdbb text-center"><?= $cur_stud->Adviser; ?></td>
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
                <td colspan="2" class="tdbb text-center"><?= $prin->principalPre; ?></td>
            </tr>
            
            <tr>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td colspan="2" class="text-center">Principal</td>
            </tr>
            
        </table>
        </div>

    </div>


    <div class="blocker"></div>

</div>





</body>
</html>