<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8" />
<?php include('includes/title.php'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Responsive bootstrap 4 admin template" name="description" />
<link href="<?= base_url(); ?>assets/css/renren.css" rel="stylesheet" type="text/css" />
<meta content="Coderthemes" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">

<body>


    <div class="wrap">
        <img class="print-only" src="<?= base_url(); ?>upload/banners/<?php echo $letterhead[0]->letterhead_web; ?>" alt="mySRMS Portal" width="100%">
        <div class="corhead">
            <h1>CERTIFICATE OF ENROLLMENT</h1>
        </div>

        <table class="cor">
            <tr>
                <th class="label">Student No.:</th>
                <th><?= $this->uri->segment(3); ?></th>
                <th class="label">Department</th>
                <th colspan="3"><?= $sem_stud->Course; ?></th>
            </tr>
            <tr>
                <th class="label">Student Name.:</th>
                <th><?= $stud->FirstName; ?> <?= $stud->MiddleName; ?> <?= $stud->LastName; ?></th>
                <th class="label">Grade Level:</th>
                <th><?= $sem_stud->YearLevel; ?></th>
                <th class="label">SY:</th>
                <th><?= $this->uri->segment(4); ?></th>
            </tr>
            <tr class="des">
                <th>Subject Code</th>
                <th>Description</th>
                <th colspan="2">Class Schedule</th>
                <?php if($sem_stud->Course == 'Senior High School'){?>
                <th>Semester</th>
                <?php } ?>
                <th colspan="2">Teacher</th>
                
            </tr>

            <?php foreach ($subject as $row) { ?>
                <tr>
                    <td><?= $row->SubjectCode; ?></td>
                    <td><?= $row->Description; ?></td>
                    <td colspan="2"><?= $row->SchedTime; ?></td>
                    <?php if($sem_stud->Course == 'Senior High School'){?>
                    <td><?= $row->Sem; ?></td>
                    <?php } ?>
                    <td colspan="2"><?= $row->Instructor; ?></td>
                </tr>
            <?php } ?>

        </table>

        <div class="stud_sign">
            <h3><?= strtoupper($stud->FirstName); ?> <?php if ($stud->MiddleName != '') {
                                                echo strtoupper(substr($stud->MiddleName, 0, 1)) . '. ';
                                            } ?> <?= strtoupper($stud->LastName); ?>
                <span>Student's Signature</span>
            </h3>

        </div>
        <?php $ad = $this->Common->one_cond_row('staff', 'IDNumber', $sem_stud->IDNumber); ?>

        <div class="adviser">
            <h3><?= strtoupper($ad->FirstName); ?> <?php if ($ad->MiddleName != '') {
                                            echo strtoupper(substr($ad->MiddleName, 0, 1)) . '. ';
                                        } ?> <?= strtoupper($ad->LastName); ?><br />
                <span style="font-weight:normal;">Class Adviser</span>
            </h3>
            
        </div>
    </div>


</body>

</html>