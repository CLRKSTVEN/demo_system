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

                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg"><i class=" fas fa-user-plus mr-1"></i> Add Student</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- end page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="header-title mb-4">Subject Enlistment<br>
                                        <span class="badge badge-purple mb-3"><b>SY <?= $this->session->sy; ?> <?= $this->session->semester; ?></b></span>
                                    </h4>


                                    <?php echo $this->session->flashdata('msg'); ?>

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Student No.</th>
                                                <th>LRN</th>
                                                <th>Year Level</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($stud_register as $row) {
                                                $studs = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $row->StudentNumber);
                                            ?>
                                                <tr>
                                                    <td><?= $studs->LastName; ?>, <?= $studs->FirstName; ?> <?php if (!empty($studs->MiddleName)) {
                                                                                                                echo substr($studs->MiddleName, 0, 1) . '.';
                                                                                                            }  ?> </td>
                                                    <td><?= $studs->StudentNumber; ?></td>
                                                    <td><?= $studs->LRN; ?></td>
                                                    <td><?= $row->YearLevel; ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url(); ?>Ren/cor/<?= $studs->StudentNumber; ?>/<?= $row->SY; ?>" target="_blank"><i class="mdi mdi-folder-edit-outline text-success tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Certificate of Enrollment"></i></a> &nbsp; &nbsp;
                                                        <a href="<?= base_url(); ?>Ren/corv2/<?= $studs->StudentNumber; ?>/<?= $row->SY; ?>" target="_blank"><i class="mdi mdi-folder-edit-outline text-primary tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Certificate of Enrollment V2"></i></a>&nbsp; &nbsp;
                                                        <a href="<?= base_url(); ?>Ren/subject_list_update/<?= $studs->StudentNumber; ?>/<?= $row->SY; ?>"><i class="mdi mdi-folder-edit-outline text-success tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Update/Delete Enlistment"></i></a>
                                                        <a href="<?= base_url(); ?>Ren/deleteReg/<?= $studs->StudentNumber; ?>/<?= $row->SY; ?>" onclick="return confirm('Are you sure you want to delete this enrollment?');"><i class="mdi mdi-folder-edit-outline text-danger tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Delete Enrollment"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


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
                    <?= form_open('Ren/subject_list', $att); ?>
                    <!-- general form elements -->
                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Fullname <span style="color:red">*</span> </label>
                                    <select class="form-control" data-toggle="select2" name="StudentNumber">
                                        <option>Select</option>
                                        <?php
                                        foreach ($stud as $row) {
                                            $stud_reg = $this->Common->two_cond_count_row('registration', 'StudentNumber', $row->StudentNumber, 'SY', $this->session->sy);
                                            //$prof = $this->Common->one_cond_row('studeprofile','StudentNumber',$row->StudentNumber);

                                            if ($stud_reg->num_rows() <= 0) {
                                        ?>
                                                <option value="<?= $row->StudentNumber; ?>"><?= $row->LastName; ?>, <?= $row->FirstName; ?> <?= $row->MiddleName; ?></option>
                                        <?php }
                                        } ?>
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