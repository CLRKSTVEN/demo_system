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
                                <h4 class="page-title">STUDENTS WITH PENDING ACCOUNTS PAYABLE</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" class="form-inline">
                                        <div class="form-group">
                                            <select class="form-control" name="course" id="course" data-toggle="select2">
                                                <option>Select Course</option>
                                                <?php
                                                foreach ($course as $row) {
                                                    echo '<option value="' . $row->CourseDescription . '">' . $row->CourseDescription . '</option>';
                                                }
                                                ?>
                                                </optgroup>
                                            </select>&nbsp
                                        </div>
                                        <div class="form-group">
                                            <select name="yearlevel" class="form-control" data-toggle="select2">
                                                <option>Select Year Level</option>
                                                <option value="">Select Grade Level</option>
                                                <option value="Grade 01">Grade 1</option>
                                                <option value="Grade 02">Grade 2</option>
                                                <option value="Grade 03">Grade 3</option>
                                                <option value="Grade 04">Grade 4</option>
                                                <option value="Grade 05">Grade 5</option>
                                                <option value="Grade 06">Grade 6</option>
                                                <option value="Grade 07">Grade 7</option>
                                                <option value="Grade 08">Grade 8</option>
                                                <option value="Grade 09">Grade 9</option>
                                                <option value="Grade 10">Grade 10</option>
                                                <option value="Grade 11">Grade 11</option>
                                                <option value="Grade 12">Grade 12</option>
                                            </select>&nbsp
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end page title -->
                    <div class="row">
                        <?php
                        if (isset($_GET["submit"])) {
                        ?>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <div class="float-left">
                                            <h4 class="m-t-0 header-title mb-1"><b>STUDENTS WITH ACCOUNT BALANCE</b><br />
                                                <span class="badge badge-purple mb-1">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                            </h4>

                                            <table>
                                                <tr>
                                                    <td>Course</td>
                                                    <td>: <?php echo $_GET['course']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Year Level</td>
                                                    <td>: <?php echo $_GET['yearlevel']; ?> </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="float-right">
                                            <div class="d-print-none">
                                                <div class="float-right">
                                                    <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>
                                                    <!-- <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a> -->
                                                </div>
                                            </div>

                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Year Level</th>
                                                    <th>Course</th>
                                                    <th style="text-align:center">Total Acct.</th>
                                                    <th style="text-align:center">Discount</th>
                                                    <th style="text-align:center">Payments</th>
                                                    <th style="text-align:center">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php
                                                $i = 1;
                                                foreach ($data as $row) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row->StudentName . "</td>";
                                                ?>
                                                    <td><?php echo $row->YearLevel; ?></a></td>
                                                    <td><?php echo $row->Course; ?></td>
                                                    <td style="text-align:right">
                                                        <!-- <a href="<?= base_url(); ?>Accounting/studentStatement?id=<?php echo $row->StudentNumber; ?>"> -->
                                                        <?php echo $row->AcctTotal; ?>
                                                        <!-- </a> -->
                                                    </td>
                                                    <td style="text-align:right"><?php echo $row->Discount; ?></td>
                                                    <td style="text-align:right">
                                                        <!-- <a href="<?= base_url(); ?>page/studepayments?studentno=<?php echo $row->StudentNumber; ?>&sem=<?php echo $this->session->userdata('semester'); ?>&sy=<?php echo $this->session->userdata('sy'); ?>"> -->
                                                        <?php echo $row->TotalPayments; ?>
                                                        <!-- </a> -->
                                                    </td>
                                                    <td style="text-align:right"><?php echo $row->CurrentBalance; ?></td>
                                            <?php
                                                    echo "</tr>";
                                                }
                                            }
                                            ?>
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

</body>

</html>