<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/a.ico">
    
    <link href="<?= base_url(); ?>/assets/css/ren.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="wrap">
    <!-- <img class="banner" src="<?= base_url(); ?>/assets/images/#.jpg" alt=""> -->
    <img class="print-only" src="<?= base_url(); ?>upload/banners/<?php echo $letterhead[0]->letterhead_web; ?>" alt="mySRMS Portal" width="100%">

    <div class="topwrap">
        <p class="pleft">
            <b>FORM 138 - REPORT CARD</b><br />
            LRN: <b><?= $stud->LRN; ?></b>

        </p>
        <p class="pright">
            Curriculum: <b>K to 12 Basic Education</b><br />
            Department: <b>Senior High School</b>

        </p>
        <div class="blocker"></div>
    </div>

    <div class="topwrap2">
        <p class="pleft">
            Student Name <span><?= $stud->LastName; ?>, <?= $stud->FirstName; ?> <?= $stud->MiddleName; ?></span><br />
            Level/Section <span><?= $sem_stud->YearLevel; ?> / <?= $sem_stud->Section; ?></span>

        </p>
        <p class="pright">
            Student No.:<span><?= $stud->StudentNumber; ?></span><br />
            Sex: <span><?= $stud->Sex; ?></span> School Year <span><?= $sem_stud->SY; ?></span>

        </p>
        <div class="blocker"></div>
    </div>

    <?php  if(!empty($shs)){ ?>
<table class='tb1'>
    <tr>
        <th style="text-align:left;">LEARNING AREAS</th>
        <th colspan="2">QUARTER</th>
        <th rowspan="2">SEMESTER</br>FINAL</th>
    </tr>
    <tr>
        <th style="text-align:left;">FIRST SEMESTER</th>
        <th>1st</th>
        <th>2nd</th>
    </tr>
    <?php 
        //$arg = array('Araling Panlipunan 1','English 1','Edukasyong Pagpapakatao 1','Filipino','Music Arts Physical Education Health 1');
        foreach($shs as $row){
    ?>
    <tr>
        <td><?= $row->Description; ?></td>
        <td style='text-align:center'><?php if($row->PGrade != 0){echo $row->PGrade;} ?></td>
        <td style='text-align:center'><?php if($row->MGrade != 0){echo $row->MGrade;} ?></td>
        <td style='text-align:center'><?php if($row->PFinalGrade != 0){echo $row->PFinalGrade;} ?></td>
    </tr>

  
   <?php } ?>
    <tr>
        <td style="text-align:left; font-weight:bold">GENERAL AVERAGE</td>
        <td style='text-align:center'></td>
        <td style='text-align:center'></td>
        <td style='text-align:center'></td>
    </tr>
</table>

<?php } ?>

<?php if(!empty($shs2)){ ?>
<table class='tb1'>
    <tr>
        <th style="text-align:left;">LEARNING AREAS</th>
        <th colspan="2">QUARTER</th>
        <th rowspan="2">SEMESTER</br>FINAL</th>
    </tr>
    <tr>
        <th style="text-align:left;">SECOND SEMESTER</th>
        <th>1st</th>
        <th>2nd</th>
    </tr>
    <?php 
        //$arg = array('Araling Panlipunan 1','English 1','Edukasyong Pagpapakatao 1','Filipino','Music Arts Physical Education Health 1');
        foreach($shs2 as $row){
    ?>
    <tr>
        <td><?= $row->Description; ?></td>
        <td style='text-align:center'><?php if($row->PGrade != 0){echo $row->PGrade;} ?></td>
        <td style='text-align:center'><?php if($row->MGrade != 0){echo $row->MGrade;} ?></td>
        <td style='text-align:center'><?php if($row->PFinalGrade != 0){echo $row->PFinalGrade;} ?></td>
    </tr>

  
   <?php } ?>
    <tr>
        <td style="text-align:left; font-weight:bold">GENERAL AVERAGE</td>
        <td style='text-align:center'></td>
        <td style='text-align:center'></td>
        <td style='text-align:center'></td>
    </tr>
</table>
<div></div>
<?php } ?>



<div class="bwrap">
    <table class="tb2">
        <tr>
            <th></th>
            <th>Aug</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dec</th>
            <th>Jan</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Apr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Total</th>
        </tr>
        <?php $arg = array('Days of School','Days Present','Times Tardy'); foreach($arg as $row){?>
        <tr>
            <td><?= $row; ?></td>
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
        <?php } ?>
        
    </table>

</div>

<div class="bwrap">
    <table class="tb3">
    <?php $arg = array('Eligible for transfer & admission','Has advanced credit in','Lack credits in','Date:'); foreach($arg as $row){?>
        <tr>
            <td style="width:40%;"><?= $row; ?></td>
            <td style="border-bottom:1px solid #000"></td>
        </tr>
        <?php } ?>
    </table>

</div>
<div class="blocker"></div>

<table class="tb4">
    <tr>
        <td style="width:20%; border-spacing:0 !important">Cancellation of Transfer Eligibily</td>
        <td class="thborder"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Had been admitted to</td>
        <td class="thborder"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Date:</td>
        <td class="thborder"></td>
        <td style="text-align:center;"><b><?= $cur_stud->Adviser; ?> </b></td>
        <td style="text-align:center"><b><?= $prin->SchoolHead; ?></b></td>
    </tr>
    <tr>
        <td>School Principal</td>
        <td class="thborder"></td>
        <td class="text-center"><span class="ad_sign">Class Adviser</span></td>
        <td class="text-center"><span class="ad_sign">Principal</span></td>
    </tr>
</table>
    



    </div>

</body>
</html>