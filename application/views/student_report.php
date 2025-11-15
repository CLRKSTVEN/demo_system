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
                                <h4 class="page-title">


                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12 col-sm-6 ">
                            <!-- Portlet card -->
                            <div class="card">
                                <div class="card-header bg-info py-3 text-white">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                        <a data-toggle="collapse" href="#cardCollpase3" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                        <!-- <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a> -->
                                    </div>
                                    <h5 class="card-title mb-0 text-white">Students' Reports</h5>
                                </div>
                                <div id="cardCollpase3" class="collapse show">
                                    <div class="card-body">
                                        <?php echo $this->session->flashdata('msg'); ?>
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Student No.</th>
                                                    <th>LRN</th>
                                                    <th style="text-align:center; width:240px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $seenStudents = [];
                                                foreach ($data as $row) {
                                                    if (isset($seenStudents[$row->StudentNumber])) {
                                                        continue;
                                                    }
                                                    $seenStudents[$row->StudentNumber] = true;
                                                ?>
                                                    <tr>
                                                        <td><?= $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName; ?></td>
                                                        <td><?= $row->StudentNumber; ?></td>
                                                        <td><?= $row->LRN; ?></td>
                                                        <td>
                                                            <a href="<?= base_url(); ?>Ren/goodmoral/<?= $row->StudentNumber; ?>" target="_blank" class="btn btn-success btn-sm mr-1 tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Good Moral Character"><i class="far fa-hand-point-left "></i></a>
                                                            <a href="<?= base_url(); ?>Ren/clearance/<?= $row->StudentNumber; ?>" target="_blank" class="btn btn-purple btn-sm mr-1 tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Certificate of Enrollment"><i class="fas fa-file-alt"></i></a>
                                                            <a href="<?= base_url(); ?>Ren/report_card/<?= $row->StudentNumber; ?>"
                                                                target="_blank"
                                                                class="btn btn-success btn-sm mr-1 tooltips"
                                                                data-placement="top"
                                                                data-toggle="tooltip"
                                                                data-original-title="Report Card">
                                                                <i class="fa fa-file-alt"></i>
                                                            </a>

                                                            <a href="<?= base_url(); ?>Ren/clear/<?= $row->StudentNumber; ?>" target="_blank" class="btn btn-primary btn-sm mr-1 tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Clearance"><i class="fas fa-folder-open"></i></a>
                                                            <a href="<?= base_url(); ?>Ren/stud_prof/<?= $row->StudentNumber; ?>" target="_blank" class="btn btn-info btn-sm mr-1 tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Student Profile"><i class="fas fa-user-friends"></i></a>
                                                            <a href="<?= base_url(); ?>Ren/stud_register_enrollment/<?= $row->StudentNumber; ?>" target="_blank" class="btn btn-warning btn-sm mr-1 tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Registration Form / Enrollment Form"><i class="fab fa-wpforms "></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end card-->

                        </div>
                        <!-- end col -->
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

    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

</body>

</html>
