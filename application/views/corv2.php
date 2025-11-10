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

        <div class="cert">
            <h4>TO WHOM IT MAY CONCERN</h4>
            <p>This is to certify that <b><?= $stud->FirstName; ?> <?=$stud->MiddleName; ?> <?= $stud->LastName; ?></b> is currently enrolled as a <b><?= $sem_stud->YearLevel; ?></b> student of this institution for the School Year <b><?= $sem_stud->SY; ?></b>.</p>
            <p>This certifition is issued for whatever legal purpose this may serve him/her best.</p>
            <p>Issued this day, <?= date('F d Y'); ?> at <b><?= $setting->SchoolName; ?></b>, <?= $setting->SchoolAddress; ?></p>
        </div>



        <div class="registrar">
            <h3><?= $setting->RegistrarJHS; ?>
                <span class="text">Registrar</span>
            </h3>
        </div>
        <div class="cert">
        <p>Valid with school's dry seal</p>
        </div>
        
    </div>

    
</body>
</html>