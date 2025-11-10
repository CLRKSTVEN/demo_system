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

    <!-- <div class="renren">
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
   </div> -->
            
    <div class="wrap">
        <!-- <img class="banner" src="http://localhost/srms-wcm-bed//assets/images/s.jpg" alt=""> -->
        <img class="banner" src="<?=base_url();?>upload/banners/<?= $setting->letterhead_web; ?>" alt="">
        <div class="corhead">
            <h1>CLEARANCE</h1>
        </div>

        <div class="cert">
            <p>TO WHOM IT MAY CONCERN</p>
            <p>This is to certify that <b><?= $student->FirstName; ?> <?=$student->MiddleName; ?> <?= $student->LastName; ?>, </b> <?= !empty($sem_stud->YearLevel) ? $sem_stud->YearLevel : ''; ?> student is a bonafide student of this institution during SY <?= !empty($sem_stud->SY) ? $sem_stud->SY : ''; ?>, That he/she is already cleared with all his/her obligation/accountability as per record of this institution. </p>

        </div>

        <table class="cor">
            
            <tr class="des" style="border-top:1px solid #999">
                <th>CODE</th>
                <th>DESCRIPTION</th>
                <th colspan="2">TEACHER</th>
                <th colspan="2">SIGNATURE</th>
            </tr>

            <?php foreach($subject as $row){?>
            <tr>
                <td><?= $row->SubjectCode; ?></td>
                <td><?= $row->Description; ?></td>
                <td colspan="2"><?= $row->Instructor; ?></td>
                <td colspan="2" style="border-bottom:1px solid #999"></td>
            </tr>
            <?php } ?>

        </table>

        <p class="signature">Library In-charge</p>
        <p class="signature">Property Custodian</p>
        <p class="signature">Guidance Counselor</p>
        <p class="signature">Cashier</p>
        <p class="signature">Registrar</p>
        <p class="signature" style="margin-bottom:50px">Noted:</p>
        


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