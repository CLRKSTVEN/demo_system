<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Report</title>

    <!-- External Select2 CSS -->
    <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body and Card Styling */
    body {
        font-family: Arial, sans-serif;
        color: #333;
        background-color: white;
        padding: 20px;
    }

    .card {
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .card-header {
        font-size: 1.5rem;
        font-weight: bold;
        background-color: #17a2b8;
        color: white;
        padding: 10px;
        text-align: center;
    }

    /* Single-Spacing for Table */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 0.9rem;
        line-height: 1.2;  /* Ensures single-spacing */
    }

    .table th, .table td {
        padding: 6px 10px;  /* Adjust padding for tighter spacing */
        text-align: left;
        border: 1px solid #ddd;
        white-space: nowrap;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    /* Date range styling */
    p {
        text-align: center;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    /* Print Styling */
    @media print {
        body, .card, .table {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: white;
        }

        .card-header {
            background-color: white;
            color: black;
            border: none;
            font-size: 1.2rem;
        }

        .table th, .table td {
            font-size: 12px;
            line-height: 1.2;  /* Single-spacing in print */
            padding: 4px 8px;  /* Reduced padding for print */
        }

        @page {
            size: A4;
            margin: 0.5in;
        }

        .no-print, .btn {
            display: none !important;
        }

        .print-only {
            display: block !important;
        }

        p {
            text-align: center;
            font-size: 12px;
        }

        table {
            width: 60%;
            margin: 0 auto;
        }
    }

    /* Button Styling */
    .btn {
        padding: 8px 15px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #218838;
    }

    .float-right {
        float: right;
    }

    </style>
</head>
<body>

    <!-- Payment Report Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              
                <div class="card-body print-area" id="paymentTable">
                    <!-- Letterhead (visible only when printing) -->
                    <img class="print-only" src="<?= base_url(); ?>upload/banners/<?php echo $letterhead[0]->letterhead_web; ?>" alt="mySRMS Portal" width="100%">

                    <div class="clearfix">
                        <div class="table-responsive">
                        <div class="card-header bg-info py-3 text-white">
                    <strong>COLLECTION SUMMARY REPORT</strong>
                <p>From: <strong><?= date('F j, Y', strtotime($fromDate)); ?> to <?= date('F j, Y', strtotime($toDate)); ?></strong></p>
                    <!-- Print Button for Payment Report -->
                    <!-- <button class="btn btn-secondary float-right no-print" onclick="window.print()">Print Summary Report</button> -->

                </div>
                <!-- <p>From: <strong><?= date('F j, Y', strtotime($fromDate)); ?> to <?= date('F j, Y', strtotime($toDate)); ?></strong></p> -->
                <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: center;">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($groupedPayments)) { ?>
                    <?php foreach ($groupedPayments as $description => $totalAmount) { ?>
                        <tr>
                            <td><?= $description; ?></td>
                            <td style="text-align: right;"><?= number_format($totalAmount, 2); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="2" class="text-center">No summary data available for the selected date range.</td>
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

    <!-- External Select2 JS (if needed in your project) -->
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

</body>
</html>
