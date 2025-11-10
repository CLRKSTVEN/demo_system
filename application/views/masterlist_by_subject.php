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
                                <!-- <h4 class="page-title">Masterlist By Subject</h4> -->
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="float-left">
                                        <h4 class="m-t-0 header-title mb-1"><b>CLASS LIST</b><br />
                                            <span class="badge badge-purple mb-1">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                        </h4>

                                        <table>
                                            <tr>
                                                <td>Subject Code</td>
                                                <td>: <strong><?php echo $_GET['subjectcode']; ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td>: <strong><?php echo $_GET['description']; ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Section</td>
                                                <td>: <strong><?php echo $_GET['section']; ?></strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="float-right">
                                        <div class="d-print-none">
                                            <div class="float-right">
                                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i> Print</a>
                                            </div>
                                        </div>
                                    </div>
<?php
// Prepare groups
$groupedData = [
    'Male'   => [],
    'Female' => [],
    'Others' => [],   // catch-all
];

foreach ($data as $row) {
    // normalize
    $raw   = isset($row->Sex) ? (string)$row->Sex : '';
    $upper = function_exists('mb_strtoupper') ? mb_strtoupper(trim($raw), 'UTF-8') : strtoupper(trim($raw));

    // map to buckets
    if ($upper === 'MALE' || $upper === 'M') {
        $key = 'Male';
    } elseif ($upper === 'FEMALE' || $upper === 'F') {
        $key = 'Female';
    } else {
        $key = 'Others';
    }

    $groupedData[$key][] = $row;
}
?>
 
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Student Name</th>
                                                <th>Student No.</th>
                                                <!-- <th>Course</th> -->
                                                <th>Year Level</th>
                                                <th>Mobile Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach (['Male', 'Female'] as $sex):
                                                $count = count($groupedData[$sex]);
                                                if ($count > 0): ?>
                                                    <tr class="table-primary">
                                                        <td colspan="5"><strong><?= strtoupper($sex) . " ({$count})"; ?></strong></td>
                                                    </tr>
                                                    <?php foreach ($groupedData[$sex] as $row): ?>
                                                        <tr>
                                                            <td><?= $i++; ?></td>
                                                            <td><?= $row->StudentName; ?></td>
                                                            <td><?= $row->StudentNumber; ?></td>
                                                            <!-- <td><?= $row->Course; ?></td> -->
                                                            <td><?= $row->YearLevel; ?></td>
                                                            <td><?= $row->MobileNumber; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                            <?php endif;
                                            endforeach;
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

    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

</body>

</html>