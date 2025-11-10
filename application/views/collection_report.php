<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    /* Styling for the tables */
    .separated-table {
        margin-bottom: 30px;
        /* Adds space between tables */
        border-collapse: separate;
        /* Ensures borders are spaced out */
        border-spacing: 0 15px;
        /* Adds space between rows */
    }

    .separated-table th,
    .separated-table td {
        padding: 10px;
        border: 1px solid #ddd;
        /* Adds border around each cell */
    }

    .separated-table th {
        background-color: #f2f2f2;
        /* Adds background color for headers */
    }

    .table-section {
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ccc;
    }

    h4 {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
        /* Adds a separator under headings */
    }
</style>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->

        <!-- Lef Side bar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- Start Page Content here -->
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
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Collection Report Section -->
                    <div class="row table-section">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <a href="<?= base_url(); ?>Accounting/PrintcollectionReport/" target="_blank" class="btn btn-secondary waves-effect waves-light btn-sm" style="float: right;">
                                        Print Collection Report
                                    </a>
                                    <h4 class="m-t-0 header-title mb-4"><b>Collection Report</b><br />
                                        <span class="badge badge-purple mb-3"><b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></span>
                                    </h4>

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap separated-table">
                                        <thead>
                                            <tr>
                                                <th>Payment Date</th>
                                                <th>O.R. No.</th>
                                                <th>Student No.</th>
                                                <th>Payor</th>
                                                <th style="text-align:center;">Amount</th>
                                                <th>Description</th>
                                                <th>Payment Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($collection_data as $row): ?>
                                                <tr>
                                                    <td><?= $row->PDate; ?></td>
                                                    <td><?= $row->ORNumber; ?></td>
                                                    <td><?= $row->StudentNumber; ?></td>
                                                    <td><?= $row->Payor; ?></td>
                                                    <td style="text-align:right"><?= $row->Amount; ?></td>
                                                    <td><?= $row->Description; ?></td>
                                                    <td><?= $row->PaymentType; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Yearly Collection Summary Section -->
                    <div class="row table-section">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4>Collection Summary Per Year</h4>
                                    <!-- <table class="table table-bordered separated-table"> -->
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th style="text-align: right;">Total Collections</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($yearly_data as $year): ?>
                                                <tr>
                                                    <td><?= $year->Year; ?></td>
                                                    <td style="text-align: right;">
                                                        <?= number_format($year->TotalAmount, 2); ?>

                                                    </td>
                                                    <td style="text-align: center;">
                                                        <a href="<?= base_url('Accounting/PrintYearReport/') . $year->Year; ?>" target="_blank">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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