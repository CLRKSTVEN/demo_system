<!DOCTYPE html>
<html lang="en">
        <meta charset="utf-8" />
        <?php include('includes/title.php'); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <link href="<?= base_url(); ?>assets/css/renren.css" rel="stylesheet" type="text/css" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App css -->
        <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
        <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
<body style="background:#fff">

    <div class="renren">
            <?= form_open(); ?>
                
                <div class="form-group row mb-0">
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <select class="form-control" name="stud"  data-toggle="select2">
                                                                <option value=""></option>
                                                                    <?php 
                                                                        foreach($studs as $row){
                                                                        $stud = $this->Common->one_cond_row('studeprofile','StudentNumber',$row->StudentNumber);
                                                                    ?>
                                                                    <option value="<?= $stud->StudentNumber; ?>"><?= $stud->LastName; ?>, <?= $stud->FirstName; ?> <?php if($stud->MiddleName != ""){echo mb_substr($stud->MiddleName, 0, 1).'.';}  ?> </option>
                                                                    <?php } ?>
                                                            </select>
                                                                
                                                           
                                                        </div>
                                                    </div>
                                                    <input type="submit" value="Submit" name="submit" class="gm">
                                                </div>

                                                
            </form>
   </div>
            

   <?php if($this->input->post('submit')) {?>
    <div class="wrap">
        <!-- <img class="banner" src="http://localhost/srms-wcm-bed//assets/images/s.jpg" alt=""> -->
        <img class="banner" src="<?=base_url();?>upload/banners/<?= $setting->letterhead_web; ?>" alt="">
        <div class="corhead">
            <h1>CERTIFICATION</h1>
        </div>

        <div class="cert">
            <h4>TO WHOM IT MAY CONCERN</h4>
            <p>This is to certify that <b><?= $student->FirstName; ?> <?=$student->MiddleName; ?> <?= $student->LastName; ?> (<?= $student->LRN; ?>) </b> is currently enrolled as a <b><?= $sem_stud->YearLevel; ?></b> student of this institution for the School Year <b><?= $sem_stud->SY; ?></b>.</p>
            <p>This certifies further that the above mentrioned name is of good moral character and has not infiringed nor violated any of the school policies and regulations during her stay in this institution.</p>
            <p>This certifition is issued for whatever legal purpose this may serve him/her best.</p>
            <p>Issued this day, <?= date('F d Y'); ?> at <b><?= $setting->SchoolName; ?></b>, <?= $setting->SchoolAddress; ?>.</p>
        </div>

        <div class="registrar">
            <h3>
            <span>Certifified by:</span>
        </h3>
        </div>

        <div class="registrar">
            <p><b><?= $setting->RegistrarJHS; ?></b>
            <span>Registrar</span>
        </p>
        </div>

        <div class="registrar">
            <p><b><?= $setting->SchoolHead; ?></b>
            <span>Principal</span>
            </p>
        </div>

    <?php } ?>

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
        
        <!-- App js -->
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

        <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
        

        <!-- Datatables init -->
        <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

        <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
        <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>
        <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>


    
</body>
</html>