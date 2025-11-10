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
                                <!-- <h4 class="page-title">Subject Masterlist</h4> -->
                                <div class="page-title-right">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <!-- <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li> -->
                                        </ol>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="float-left">
                                        <h4 class="m-t-0 header-title mb-1"><strong>CLASS LIST</strong>
                                            <br /><span class="badge badge-purple mb-1">SY <?php echo $this->session->userdata('sy'); ?></span></b>
                                        </h4>
                                        <table border="1" cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td><strong>Grade Level</strong></td>
                                                <td>: <b><?php echo isset($data[0]->YearLevel) ? htmlspecialchars($data[0]->YearLevel, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></b></td>
                                            </tr>

                                            <tr>
                                                <td><strong>Subject Code</strong></td>
                                                <td>: <b><?php echo isset($data[0]->SubjectCode) ? htmlspecialchars($data[0]->SubjectCode, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></b></td>
                                            </tr>

                                            <tr>
                                                <td><strong>Description</strong></td>
                                                <td>: <b><?php echo isset($data[0]->Description) ? htmlspecialchars($data[0]->Description, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Section</strong></td>
                                                <td>: <b><?php echo isset($data[0]->Section) ? htmlspecialchars($data[0]->Section, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Teacher</strong></td>
                                                <td>: <b><?php echo isset($data[0]->Instructor) ? htmlspecialchars($data[0]->Instructor, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Class Schedule</strong></td>
                                                <td>: <b><?php echo isset($data[0]->SchedTime) ? htmlspecialchars($data[0]->SchedTime, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></b></td>
                                            </tr>
                                            <?php if (isset($data[0]->LabTime) && !empty($data[0]->LabTime)): ?>
                                                <tr>
                                                    <td><strong>Lab Time</strong></td>
                                                    <td>: <b><?php echo htmlspecialchars($data[0]->LabTime, ENT_QUOTES, 'UTF-8'); ?></b></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>

                                    </div>

                                    <div class="float-right">
                                        <div class="d-print-none">
                                            <div class="float-right">
                                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i> Print</a>
                                            </div>
                                        </div>
                                    </div>

                                    <br />

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width:5px;">No.</th>
                                                <th style='text-align:center;'>STUDENT NO.</th>
                                                <th style='text-align:center;'>LRN</th>
                                                <th>STUDENT NAME</th>
                                                <!-- <th style='text-align:center;'>COURSE</th> -->
                                                <!-- <th style='text-align:center;'>YEAR LEVEL</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $i++ . "</td>";
                                                echo "<td style='text-align:center;'>" . $row->StudentNumber . "</td>";
                                                echo "<td style='text-align:center;'>" . $row->LRN . "</td>";
                                                echo "<td>" . $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName . "</td>";
                                                //   echo "<td style='text-align:center;'>".$row->Course."</td>";
                                                //   echo "<td style='text-align:center;'>".$row->YearLevel."</td>";

                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>

                                    </table>


                                </div>
                            </div>

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