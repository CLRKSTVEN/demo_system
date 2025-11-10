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

        @page {
            size: A4;
            margin: 0.5in;
        }

        body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px; /* Reduce padding */
            text-align: left;
            line-height: 1; /* Single-line spacing */
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h4 {
            margin: 0 0 10px 0; /* Adjust margin for the header */
        }

        .d-print-none {
            display: none;
        }
    }
</style>


<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <!-- Letterhead is hidden on display and only visible on printing -->
        <img class="print-only" src="<?= base_url(); ?>upload/banners/<?php echo $letterhead[0]->letterhead_web; ?>" alt="mySRMS Portal" width="100%">

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title"></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="#"></a></li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

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
                                    <strong>PAYMENT REPORT</strong>
                                </div>
                                
                                <div class="card-body">
                                    <div class="clearfix">
                                    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Student No.</th>
                <th>Description</th>
                <th>Amount</th>
                <th style="text-align:center">O.R. No.</th>
                <th style="text-align:center">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) { ?>
            <tr>
                <td><?= $row->LastName; ?>, <?= $row->FirstName; ?> <?= $row->MiddleName; ?></td>
                <td><?= $row->StudentNumber; ?></td>
                <td><?= $row->description; ?></td>
                <td style="text-align:right"><?= number_format($row->Amount, 2); ?></td>
                <td style="text-align:center"><?= $row->ORNumber; ?></td>
                <td style="text-align:center"><?= $row->PDate; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Summary Section -->
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
        <?php include('includes/themecustomizer.php'); ?>
    </div>

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
