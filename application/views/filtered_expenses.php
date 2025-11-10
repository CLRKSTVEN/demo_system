<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    /* For screen display, hide the letterhead */
    .print-only {
        display: none;
    }

    /* For print media, show the letterhead */
    @media print {
        .print-only {
            display: block;
            margin-bottom: 20px;
        }

        /* Set the paper size and margins for printing */
        @page {
            size: A4;
            margin: 0.5in;
        }

        /* Ensure the background is white and remove any unnecessary margins */
        body {
            background-color: #ffffff; /* White background */
            margin: 0;
            padding: 0;
        }

        /* Style the table for printing */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000; /* Black border for clarity */
            padding: 8px; /* Add some padding for better readability */
            text-align: left;
        }

        th {
            background-color: #f2f2f2; /* Light gray background for headers */
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternate row color for better readability */
        }

        h4 {
            margin: 0 0 20px 0; /* Adjust margin for the header */
        }

        /* Hide any non-essential content */
        .d-print-none {
            display: none;
        }
    }

</style>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <img class="print-only" src="<?= base_url(); ?>upload/banners/<?php echo $letterhead[0]->letterhead_web; ?>" alt="mySRMS Portal" width="100%">


        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Expenses Report</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><span class="badge badge-purple">Category: <?= htmlspecialchars($category); ?></span></li>
                                        <li class="breadcrumb-item"><span class="badge badge-purple">Date Range: <?= htmlspecialchars($fromDate); ?> to <?= htmlspecialchars($toDate); ?></span></li>
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
                                <div class="card-header bg-info py-3 text-white">
                                    <div class="d-print-none">
                                        <div class="float-right">
                                            <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light mr-1">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <strong>EXPENSES REPORT</strong>
                                </div>
                                
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="table-responsive">
                                            <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Responsible</th>
                                                <th>Expense Date</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php if (!empty($result)) {
                                                foreach ($result as $row) { ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row->Description); ?></td>
                                                    <td><?= htmlspecialchars($row->Responsible); ?></td>
                                                    <td><?= htmlspecialchars($row->ExpenseDate); ?></td>
                                                    <td><?= htmlspecialchars($row->Category); ?></td>
                                                    <td><?= htmlspecialchars($row->Amount); ?></td>
                                                </tr>
                                            <?php } } else { ?>
                                                <tr>
                                                    <td colspan="5">No expenses found for the selected criteria.</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

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
    
    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <!-- Required datatable js -->
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

</body>
</html>
