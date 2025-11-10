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
                                <!-- <h4 class="page-title">School Information</h4> -->
                                <?php echo $this->session->flashdata('msg'); ?>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- end page title -->

                    <div class="col-xl-12 col-sm-6 ">
                        <!-- Portlet card -->
                        <div class="card">
                            <div class="card-header bg-primary py-3 text-white">
                                <div class="card-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                    <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                    <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                </div>
                                <h5 class="card-title mb-0 text-white">School Information</h5>
                            </div>
                            <div id="cardCollpase2" class="collapse show">
                                <div class="card-body">
                                    <form role="form" method="post" enctype="multipart/form-data">
                                        <!-- general form elements -->
                                        <div class="card-body">
                                            <div class="row">

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="form-group">
                                                        <label for="lastName">School Name </label>
                                                        <input type="text" class="form-control" name="SchoolName" value="<?php echo $data[0]->SchoolName; ?>" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>School Address </label>
                                                        <input type="text" class="form-control" name="SchoolAddress" value="<?php echo $data[0]->SchoolAddress; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>School Slogan </label>
                                                        <input type="text" class="form-control" name="slogan" value="<?php echo $data[0]->slogan; ?>">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>School Head</label>
                                                        <input type="text" class="form-control" name="SchoolHead" value="<?php echo $data[0]->SchoolHead; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>School Head Position </label>
                                                        <input type="text" class="form-control" name="sHeadPosition" value="<?php echo $data[0]->sHeadPosition; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Registrar</label>
                                                        <input type="text" class="form-control" name="RegistrarJHS" value="<?php echo $data[0]->RegistrarJHS; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Property Custodian </label>
                                                        <input type="text" class="form-control" name="PropertyCustodian" value="<?php echo $data[0]->PropertyCustodian; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Principal</label>
                                                        <input type="text" class="form-control" name="principalJHS" value="<?php echo $data[0]->principalJHS; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Finance Officer </label>
                                                        <input type="text" class="form-control" name="financeOfficer" value="<?php echo $data[0]->financeOfficer; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Allow Viewing of Grades?</label>
                                                        <select class="form-control" name="viewGrades">
                                                            <option><?php echo $data[0]->viewGrades; ?></option>
                                                            <option>Yes</option>
                                                            <option>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Active SY </label>
                                                        <input type="text" class="form-control" name="active_sy" value="<?php echo $data[0]->active_sy; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <h4>Dragonpay Credentials</h4>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Merchant ID</label>
                                                        <input type="text" class="form-control" name="dragonpay_merchantid" value="<?php echo $data[0]->dragonpay_merchantid; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Dragonpay Password </label>
                                                        <input type="text" class="form-control" name="dragonpay_password" value="<?php echo $data[0]->dragonpay_password; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Dragonpay URL </label>
                                                        <input type="text" class="form-control" name="dragonpay_url" value="<?php echo $data[0]->dragonpay_url; ?>">
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="submit" name="submit" class="btn btn-info" value="Update">
                                                </div>
                                            </div>

                                        </div><!-- /.box -->

                                </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- end card-->

                </div>
                <!-- end col -->


            </div>

            </form>
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


    <!-- Right Sidebar -->
    <?php include('includes/themecustomizer.php'); ?>
    <!-- /Right-bar -->


    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Chat app -->
    <script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>

    <!-- Todo app -->
    <script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>

    <!--Morris Chart-->
    <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>

    <!-- Sparkline charts -->
    <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Dashboard init JS -->
    <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

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

    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="<?= base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
</body>

</html>