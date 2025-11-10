<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row mt-4 mb-2">
                        <div class="col-md-12">
                            <h4 class="mb-3">📊 <strong>Collection Report</strong></h4>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="get" action="<?= base_url('Accounting/collectionReportByDate'); ?>" class="form-inline">
                                <label class="mr-2 font-weight-bold">From:</label>
                                <input type="date" name="fromDate" class="form-control mr-3" value="<?= $fromDate; ?>" required>

                                <label class="mr-2 font-weight-bold">To:</label>
                                <input type="date" name="toDate" class="form-control mr-3" value="<?= $toDate; ?>" required>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Table Results -->
                    <div class="card">
                        <div class="card-body">
                            <?php if (!empty($collection)) { ?>
                                <div class="table-responsive">
                                    <div class="mb-3">
                                        <button class="btn btn-outline-success btn-sm" onclick="exportToExcel('collectionTable')">
                                            <i class="fa fa-file-excel"></i> Export to Excel
                                        </button>
                                        <!-- <button onclick="printReport()" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-print"></i> Print
                                        </button> -->
                                    </div>
                                    <div id="print-area">
                                        <table id="collectionTable" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Student Name</th>
                                                    <th>Description</th>
                                                    <th class="text-right">Amount</th>
                                                    <th>O.R. No.</th>
                                                    <th>Payment Type</th>
                                                    <th>Cashier</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $grandTotal = 0;
                                                foreach ($collection as $row) {
                                                    $grandTotal += $row->Amount;
                                                ?>
                                                    <tr>
                                                        <td><?= date('M d, Y', strtotime($row->PDate)); ?></td>
                                                        <td><?= $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName; ?></td>
                                                        <td><?= $row->description; ?></td>
                                                        <td class="text-right"><?= number_format($row->Amount, 2); ?></td>
                                                        <td><?= $row->ORNumber; ?></td>
                                                        <td><?= $row->PaymentType; ?></td>
                                                        <td><?= $row->Cashier; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="bg-light font-weight-bold">
                                                    <td colspan="3" class="text-right">Total Collection:</td>
                                                    <td class="text-right text-success"><?= number_format($grandTotal, 2); ?></td>
                                                    <td colspan="3"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                            <?php } else { ?>
                                <div class="alert alert-info text-center mb-0">
                                    No records found for the selected date range.
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/themecustomizer.php'); ?>

    <!-- Scripts -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                ordering: false,
                responsive: true
            });
        });
    </script>

    <script>
        function exportToExcel(tableID) {
            var wb = XLSX.utils.book_new();
            var tableElement = document.getElementById(tableID);
            var ws = XLSX.utils.table_to_sheet(tableElement);
            XLSX.utils.book_append_sheet(wb, ws, "Collection Report");
            XLSX.writeFile(wb, 'Collection_Report_<?= date("Ymd_His"); ?>.xlsx');
        }

        function printReport() {
            var printContents = document.getElementById('print-area').innerHTML;
            var win = window.open('', '', 'height=700,width=900');
            win.document.write('<html><head><title>Print Report</title>');
            win.document.write('<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">');
            win.document.write('</head><body >');
            win.document.write(printContents);
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }
    </script>

</body>

</html>