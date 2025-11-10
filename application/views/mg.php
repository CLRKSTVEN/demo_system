<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>


<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar --> <!-- ========== Left Sidebar Start ========== -->

        <!-- Lef Side bar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">

                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg"><i class=" fas fa-user-plus mr-1"></i> Search Student</button>
                                <div class="clearfix"></div>
                                <?php if ($this->session->flashdata('success')) : ?>

                                    <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>'
                                        . $this->session->flashdata('success') .
                                        '</div>';
                                    ?>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('danger')) : ?>
                                    <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>'
                                        . $this->session->flashdata('danger') .
                                        '</div>';
                                    ?>
                                <?php endif;  ?>
                            </div>
                        </div>
                    </div>
                    <hr style="border: 0; height: 4px; background: linear-gradient(to right, #4285F4 50%, #DB4437 16%, #F4B400 17%, #0F9D58 17%);" />
                    <?php if ($this->input->post('sn') != '') { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <div class="float-left">

                                            <h4 class="m-t-0 header-title mb-1"><b><?= $stud->LastName; ?>, <?= $stud->FirstName; ?> <?= $stud->MiddleName; ?></b>
                                                <br />
                                                <span class="badge badge-primary mb-1"> <b><?= $stud->StudentNumber; ?></b></span>
                                                <span class="badge badge-purple mb-1"> <b><?php echo $grades[0]->SY . ' ' . $grades[0]->Sem; ?></b></span>
                                                <?php $ins = $this->Common->one_cond_row('staff', 'IDNumber', $g->Instructor); ?>

                                            </h4>

                                        </div>
                                        <div class="float-right">
                                            <div class="d-print-none">
                                                <div class="float-right">
                                                    <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>
                                                </div>
                                            </div>
                                        </div>



                                        <?php $att = array('class' => 'parsley-examples'); ?>
                                        <?= form_open('Ren/update_batch_studgrade', $att); ?>
                                        <input type="hidden" name="id" value="<?= $stud->StudentNumber; ?>">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Description</th>
                                                    <th>Teacher</th>
                                                    <th style="text-align: center;">1st Grading</th>
                                                    <th style="text-align: center;">2nd Grading</th>
                                                    <th style="text-align: center;">3rd Grading</th>
                                                    <th style="text-align: center;">4th Grading</th>
                                                    <th style="text-align: center;">Average</th>
                                                </tr>
                                            </thead>
                                            </thead>
                                            <tbody>
                                                <?php $c = 1;
                                                foreach ($grades as $row) {
                                                    $s = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $row->StudentNumber);
                                                    $adviser = $this->Common->three_cond_row('semesterstude', 'StudentNumber', $row->StudentNumber, 'SY', $this->session->sy, 'YearLevel', $g->YearLevel);

                                                ?>
                                                    <tr>
                                                        <th><?= $c++; ?></th>
                                                        <td><?= $row->Description; ?>
                                                            <input type="hidden" name="gradeID[]" value="<?= $row->gradeID; ?>">
                                                        </td>
                                                        <td><?= $row->Instructor; ?></td>
                                                        <td class="text-center"><input type="text" style="width:70%" class="text-center" name="PGrade[<?php echo $row->gradeID; ?>]" value="<?php echo $row->PGrade; ?>"></td>
                                                        <td class="text-center"><input type="text" style="width:70%" class="text-center" name="MGrade[<?php echo $row->gradeID; ?>]" value="<?php echo $row->MGrade; ?>"></td>
                                                        <td class="text-center"><input type="text" style="width:70%" class="text-center" name="PFinalGrade[<?php echo $row->gradeID; ?>]" value="<?php echo $row->PFinalGrade; ?>"></td>
                                                        <td class="text-center"><input type="text" style="width:70%" class="text-center" name="FGrade[<?php echo $row->gradeID; ?>]" value="<?php echo $row->FGrade; ?>"></td>
                                                        <td class="text-center"><?= number_format($row->Average, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                        </table>
                                        <div class="form-group text-right mb-0">
                                            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                                                Update
                                            </button>
                                        </div>
                                        <?= form_close(); ?>


                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>





                </div>

                <!-- end container-fluid -->

            </div>
            <!-- end content -->



            <!-- Footer Start -->
            <?php include('includes/footer.php'); ?>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Search Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">


                    <?php $att = array('class' => 'parsley-examples'); ?>
                    <?= form_open('Page/modify_grades', $att); ?>
                    <!-- general form elements -->
                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Fullname <span style="color:red">*</span> </label>
                                    <select class="form-control" data-toggle="select2" name="sn">
                                        <option>Select</option>
                                        <?php
                                        foreach ($studs as $row) {
                                            //$stud_reg = $this->Common->two_cond_count_row('registration','StudentNumber',$row->StudentNumber,'SY',$this->session->sy);
                                            //$stud = $this->Common->one_cond_row('studeprofile','StudentNumber',$row->StudentNumber);

                                        ?>
                                            <option value="<?= $row->StudentNumber; ?>"><?= $row->LastName; ?>, <?= $row->FirstName; ?> <?= $row->MiddleName; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <input type="submit" name="submit" class="btn btn-info" value="Submit"> </span>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>

        </form>





    </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>


    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <!-- Required datatable js -->
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Responsive examples -->

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

    <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>
    <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>


</body>

</html>