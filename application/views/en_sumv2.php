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
                                <a href="<?= base_url(); ?>Ren/enrollment_summary" class="btn btn-primary">ENROLLMENT SUMMARY V1</a>
                                <a href="<?= base_url(); ?>Ren/enrollment_summaryv2" class="btn btn-info">ENROLLMENT SUMMARY V2</a>
                                <a href="<?= base_url(); ?>Ren/enrollment_summaryv3" class="btn btn-purple">ENROLLMENT SUMMARY V3</a>
                                <br /><br />
                                <h4 class="page-title">ENROLLMENT SUMMARY v2<br />
                                    <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                </h4>
                                <div class="page-title-right">
                                    <div class="page-title-right">

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr style="border: 0; height: 4px; background: linear-gradient(to right, #4285F4 50%, #DB4437 16%, #F4B400 17%, #0F9D58 17%);" />
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">


                                <?php echo $this->session->flashdata('msg'); ?>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center">Female</th>
                                            <th class="text-center">Male</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                        <?php
                                        foreach ($es as $row) {
                                            $section = $this->Common->one_cond_gb('semesterstude', 'YearLevel', $row->YearLevel, 'Section', 'Section', 'ASC');
                                        ?>
                                            <?php
                                            $cfsum = 0;
                                            $cmsum = 0;
                                            $tsum = 0;
                                            foreach ($section as $srow) {
                                                $cf = $this->Common->two_join_four_cond_count('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Section,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'a.Section', $srow->Section, 'SY', $this->session->sy, 'Sex', 'Female', 'a.YearLevel', $srow->YearLevel);
                                                $cm = $this->Common->two_join_four_cond_count('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Section,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'a.Section', $srow->Section, 'SY', $this->session->sy, 'Sex', 'Male', 'a.YearLevel', $srow->YearLevel);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <p><?= $srow->Section; ?></p>
                                                    </td>
                                                    <td class="text-center"><?= $cf->num_rows(); ?></td>
                                                    <td class="text-center"><?= $cm->num_rows(); ?></td>
                                                    <td class="text-center"><?= $cf->num_rows() + $cm->num_rows(); ?><?php $t = $cf->num_rows() + $cm->num_rows(); ?></td>
                                                </tr>
                                                <?php
                                                $cfsum += $cf->num_rows();
                                                $cmsum += $cm->num_rows();
                                                $tsum += $t;
                                                ?>

                                            <?php } ?>

                                            <tr style="background-color:#eee;">
                                                <td><b><?= $row->YearLevel; ?></b></td>
                                                <td class="text-center"><b><?= $cfsum; ?></b></td>
                                                <td class="text-center"><b><?= $cmsum; ?></b></td>
                                                <td class="text-center"><b><?= $tsum; ?></b></td>
                                            </tr>
                                        <?php } ?>

                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>



                            </div><!-- /.box-body -->

                        </div>



                    </div>
                    <!-- End row -->

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