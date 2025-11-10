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
                                <h4 class="page-title">ENROLLMENT SUMMARY v3<br />
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
                                        $tcm = $this->Common->two_join_two_cond_count('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Course,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'Sex', 'Male');
                                        $tcf = $this->Common->two_join_two_cond_count('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Course,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'SY', $this->session->sy, 'Sex', 'Female');

                                        ?>
                                        <tr>
                                            <td></td>
                                            <td class="text-center"><?= $tcf->num_rows(); ?></td>
                                            <td class="text-center"><?= $tcm->num_rows(); ?></td>
                                            <td class="text-center"><?= $tcm->num_rows() + $tcf->num_rows(); ?></td>
                                        </tr>
                                        <?php
                                        foreach ($es as $row) {
                                            $course = $this->Common->one_cond_gb('semesterstude', 'Course', $row->Course, 'YearLevel', 'YearLevel', 'ASC');
                                            $cf = $this->Common->two_join_three_cond_count('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Course,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'a.Course', $row->Course, 'SY', $this->session->sy, 'Sex', 'Female');
                                            $cm = $this->Common->two_join_three_cond_count('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Course,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'a.Course', $row->Course, 'SY', $this->session->sy, 'Sex', 'Male');
                                        ?>
                                            <tr style="background-color:#eee">
                                                <td><b><?= $row->Course; ?></b></td>
                                                <td class="text-center"><b><?= $cf->num_rows(); ?></b></td>
                                                <td class="text-center"><b><?= $cm->num_rows(); ?></b></td>
                                                <td class="text-center"><b><?= $cf->num_rows() + $cm->num_rows(); ?></b><?php $total = $cf->num_rows() + $cm->num_rows(); ?></td>
                                            </tr>
                                            <?php
                                            foreach ($course as $crow) {
                                                $ccf = $this->Common->two_join_three_cond_count('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'a.YearLevel', $crow->YearLevel, 'SY', $this->session->sy, 'Sex', 'Female');
                                                $ccm = $this->Common->two_join_three_cond_count('semesterstude', 'studeprofile', 'a.StudentNumber,a.YearLevel,a.Status,a.SY,b.Sex,b.StudentNumber', 'a.StudentNumber=b.StudentNumber', 'a.YearLevel', $crow->YearLevel, 'SY', $this->session->sy, 'Sex', 'Male');
                                            ?>

                                                <tr>
                                                    <td><?= $crow->YearLevel; ?></td>
                                                    <td class="text-center"><?= $ccf->num_rows(); ?></td>
                                                    <td class="text-center"><?= $ccm->num_rows(); ?></td>
                                                    <td class="text-center"><?= $ccf->num_rows() + $ccm->num_rows(); ?></td>
                                                </tr>

                                        <?php }
                                        } ?>
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