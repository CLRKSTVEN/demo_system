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
                                        <h4 class="m-t-0 header-title mb-1"><b>PAYMENT HISTORY</b><br />
                                            <span class="badge badge-primary mb-1">SY <?php echo $this->session->userdata('sy'); ?></span>
                                        </h4>
                                    </div>

                                    <div style="text-align: right;">
                                        <p><span style="font-size: 1.5em; font-weight: bold;"><?php echo isset($data[0]) ? htmlspecialchars($data[0]->StudentName) : 'N/A'; ?></span></p>
                                    </div>



                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Payment Date</th>
                                                <th>O.R. Number</th>
                                                <th>Amount Paid</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($data)): ?>
                                                <tr>
                                                    <td colspan="4" style="text-align: center;">No records found</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php
                                                $totalAmount = 0;
                                                foreach ($data as $row) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($row->PDate) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row->ORNumber) . "</td>";

                                                    // Sanitize the Amount
                                                    $amount = preg_replace('/[^\d.]/', '', $row->Amount); // Remove non-numeric characters
                                                    echo "<td>" . number_format((float)$amount, 2) . "</td>"; // Format the amount
                                                    echo "<td>" . htmlspecialchars($row->description) . "</td>";
                                                    echo "</tr>";

                                                    // Add sanitized amount to total
                                                    $totalAmount += (float)$amount; // Convert to float
                                                }
                                                ?>
                                                <tr class="total-row table-success">
                                                    <td colspan="2" class="text-end"><strong>Total Payments:</strong></td>
                                                    <td class="text-end" colspan="2"><strong><?php echo number_format($totalAmount, 2); ?></strong></td>
                                                </tr>

                                            <?php endif; ?>
                                        </tbody>
                                    </table>




                                </div>
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