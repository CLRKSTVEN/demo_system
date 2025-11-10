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
                                <h4 class="page-title">MASTERLIST BY COURSE <br />
                                    <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
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
                                            </select>
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
                                            <h4 class="m-t-0 header-title mb-4"><b><?php echo $_GET['course']; ?></b><br />
                                                <span class="badge badge-primary mb-3"><?php echo $this->session->userdata('semester'); ?> <?php echo $this->session->userdata('sy'); ?> </span>
                                            </h4>
                                        </div>
                                        <div class="float-right">
                                            <div class="d-print-none">
                                                <div class="float-right">
                                                    <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i> Print</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo $this->session->flashdata('msg'); ?>

                                        <div class="table-responsive">
                                            <?php
                                            // Separate and sort students by gender
                                            $males = [];
                                            $females = [];

                                            foreach ($data as $row) {
                                                if (strtolower($row->Sex) === 'male') {
                                                    $males[] = $row;
                                                } elseif (strtolower($row->Sex) === 'female') {
                                                    $females[] = $row;
                                                }
                                            }

                                            // Sort alphabetically by LastName then FirstName
                                            usort($males, fn($a, $b) => strcmp($a->LastName . $a->FirstName, $b->LastName . $b->FirstName));
                                            usort($females, fn($a, $b) => strcmp($a->LastName . $a->FirstName, $b->LastName . $b->FirstName));


                                            $yearLevelSummary = [];
                                            foreach (array_merge($males, $females) as $student) {
                                                $yl = $student->YearLevel;
                                                if (!isset($yearLevelSummary[$yl])) {
                                                    $yearLevelSummary[$yl] = 0;
                                                }
                                                $yearLevelSummary[$yl]++;
                                            }

                                            // Sort Year Levels
                                            uksort($yearLevelSummary, fn($a, $b) => strcmp($a, $b));
                                            $i = 1;
                                            ?>

                                            <!-- Male Section -->
                                            <table class="table table-bordered table-striped">
                                                <tr class="bg-primary text-white text-center">
                                                    <td colspan="8" class="font-weight-bold">MALE</td>
                                                </tr>
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Last Name</th>
                                                        <th>First Name</th>
                                                        <th>Middle Name</th>
                                                        <th>Student No.</th>
                                                        <th>LRN</th>
                                                        <th>Year Level</th>
                                                        <th>Section</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($males as $row): ?>
                                                        <tr>
                                                            <td><?= $i++; ?></td>
                                                            <td><?= $row->LastName; ?></td>
                                                            <td><?= $row->FirstName; ?></td>
                                                            <td><?= $row->MiddleName; ?></td>
                                                            <td><?= $row->StudentNumber; ?></td>
                                                            <td><?= $row->LRN; ?></td>
                                                            <td><?= $row->YearLevel; ?></td>
                                                            <td><?= $row->Section; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>

                                                <!-- Female Section -->
                                                <tr class="bg-pink text-white text-center">
                                                    <td colspan="8" class="font-weight-bold">FEMALE</td>
                                                </tr>
                                                <?php $i = 1; ?>
                                                <tbody>
                                                    <?php foreach ($females as $row): ?>
                                                        <tr>
                                                            <td><?= $i++; ?></td>
                                                            <td><?= $row->LastName; ?></td>
                                                            <td><?= $row->FirstName; ?></td>
                                                            <td><?= $row->MiddleName; ?></td>
                                                            <td><?= $row->StudentNumber; ?></td>
                                                            <td><?= $row->LRN; ?></td>
                                                            <td><?= $row->YearLevel; ?></td>
                                                            <td><?= $row->Section; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                            <!-- Summary Section -->
                                            <hr>
                                            <h5 class="mt-12"><strong>Summary by Year Level:</strong></h5>
                                            <ul class="list-group col-md-12">
                                                <?php foreach ($yearLevelSummary as $yl => $count): ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong><?= $yl; ?></strong>
                                                        <a href="<?= base_url('Page/masterlistByCourseYearLevel?course=' . urlencode($_GET['course']) . '&yearlevel=' . urlencode($yl)); ?>" class="badge badge-success badge-pill" target="_blank">
                                                            <?= $count; ?> student(s)
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>


                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>


                </div>
            <?php } ?>
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