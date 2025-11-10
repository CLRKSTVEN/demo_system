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
                    <select class="form-control" name="stud" data-toggle="select2">
                        <option value=""></option>
                        <?php
                        foreach ($studs as $row) {
                            $stud = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $row->StudentNumber);
                        ?>
                            <option value="<?= $stud->StudentNumber; ?>"><?= $stud->LastName; ?>, <?= $stud->FirstName; ?> <?php if ($stud->MiddleName != "") {
                                                                                                                                echo mb_substr($stud->MiddleName, 0, 1) . '.';
                                                                                                                            }  ?> </option>
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
            <img class="banner" src="<?= base_url(); ?>upload/banners/<?= $setting->letterhead_web; ?>" alt="">
            <div class="corhead">
                <h1>STUDENT PROFILE</h1>
            </div>

            <table class="studProf">
                <tr>
                    <th colspan="6"><b>BASIC INFORMATION :</b></th>
                </tr>
                <tr>
                    <td class="text-right">LRN :</td>
                    <td colspan="5" class="text-left border-bottom"><?= $student->LRN; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Complete Name :</td>
                    <td colspan="5" class="text-left border-bottom"><?= $student->FirstName; ?> <?= $student->MiddleName; ?> <?= $student->LastName; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Mailing Address :</td>
                    <td colspan="5" class="text-left border-bottom"><?= $student->Sitio; ?>, <?= $student->Brgy; ?>, <?= $student->City; ?>, <?= $student->Province; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Birth Date :</td>
                    <td class="text-left border-bottom"><?= $student->BirthDate; ?></td>
                    <td class="text-right">Age :</td>
                    <td class="text-left border-bottom"><?= $student->Age; ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right">Birth Place :</td>
                    <td colspan="5" class="text-left border-bottom"><?= $student->Sitio; ?>, <?= $student->Brgy; ?>, <?= $student->City; ?>, <?= $student->Province; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Sex :</td>
                    <td class="text-left border-bottom"><?= $student->Sex; ?></td>
                    <td class="text-right">Citizenship :</td>
                    <td colspan="3" class="text-left border-bottom"><?= $student->Citizenship; ?></td>
                </tr>

                <tr>
                    <th colspan="6"><b>CONTACT DETAILS</b></th>
                </tr>

                <tr>
                    <td class="text-right">Landline No. :</td>
                    <td class="text-left border-bottom"><?= $student->TelNumber; ?></td>
                    <td class="text-right">Mobile No. :</td>
                    <td colspan="2" class="text-left border-bottom"><?= $student->MobileNumber; ?></td>
                    <td class="text-right">E-mail Address :</td>
                    <td colspan="2" class="text-left border-bottom"><?= $student->EmailAddress; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Religion :</td>
                    <td class="text-left border-bottom" colspan="5"><?= $student->Religion; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Last School Attended :</td>
                    <td class="text-left border-bottom" colspan="5"><?= $student->Elementary; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Address :</td>
                    <td class="text-left border-bottom" colspan="5"><?= $student->ElemAddress; ?></td>
                </tr>

                <tr>
                    <th colspan="6"><b>PARENTS/GUARDIAN INFORMATION</b></th>
                </tr>
                <tr>
                    <td class="text-right">Father's Name :</td>
                    <td class="text-left border-bottom"><?= $student->Father; ?></td>
                    <td class="text-right">Occupation :</td>
                    <td class="text-left border-bottom"><?= $student->FOccupation; ?></td>
                    <td class="text-right">Contact No. :</td>
                    <td class="text-left border-bottom"><?= $student->fContactNo; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Mother's Name :</td>
                    <td class="text-left border-bottom"><?= $student->Mother; ?></td>
                    <td class="text-right">Occupation :</td>
                    <td class="text-left border-bottom"><?= $student->MOccupation; ?></td>
                    <td class="text-right">Contact No. :</td>
                    <td class="text-left border-bottom"><?= $student->mContactNo; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Guardian's :</td>
                    <td class="text-left border-bottom"><?= $student->Guardian; ?></td>
                    <td class="text-right">Relationship :</td>
                    <td class="text-left border-bottom"><?= $student->GuardianRelationship; ?></td>
                    <td class="text-right">Contact No. :</td>
                    <td class="text-left border-bottom"><?= $student->GuardianContact; ?></td>
                </tr>
                <tr>
                    <th colspan="6"><b>OTHER INFO</b></th>
                </tr>
                <tr>
                    <td class="text-right">Department :</td>
                    <td class="text-left border-bottom"><?= $student->Course; ?></td>
                    <td class="text-right">Grade Level :</td>
                    <td class="text-left border-bottom"><?= !empty($sem_stud->YearLevel) ? $sem_stud->YearLevel : ''; ?></td>
                    <td class="text-right">Section :</td>
                    <td class="text-left border-bottom"><?= !empty($sem_stud->Section) ? $sem_stud->Section : ''; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Track and Strand :</td>
                    <td class="text-left border-bottom" colspan="5"><?= !empty($sem_stud->Qualification) ? $sem_stud->Qualification : ''; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Adviser :</td>
                    <td class="text-left border-bottom" colspan="5"><?= !empty($sem_stud->Adviser) ? $sem_stud->Adviser : ''; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Student's Classification/Scholarship :</td>
                    <td class="text-left border-bottom" colspan="5"><?= $student->Scholarship; ?></td>
                </tr>
            </table>

            <p style='text-indent: 50px; text-align:justify'>I hereby certify that the above information given are true and correct to the best of my knowledge and I allow the SCHOOL to use my child's details to create and/or update his/her learner profile
                in the School Records Management System and in the Learner information System. The information herein shall be treated as confidential in compliance with Data Privacy Act of 2012.
            </p>

            <p style="margin-top:40px; text-align:center; width:400px"><b><?= strtoupper($student->Guardian); ?></b>
                <span style="display:block; border-top:1px solid #eee">Signature Over Printed Name of Parent/Guardian</span>
            </p>

            <p style="margin-top:50px">Noted by:</p>

            <p style="margin-top:10px; text-align:center; width:400px; margin-bottom:60px"><b><?= $setting->RegistrarJHS; ?></b><span style="display:block; border-top:1px solid #eee">Registrar</span></p>





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