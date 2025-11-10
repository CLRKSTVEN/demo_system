<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<head>
    <style>
        @media print {
            body * { visibility: hidden; }
            .card, .card * {
                visibility: visible;
            }
            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table thead th {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 1;
        }

        .accordion-button::after {
            content: "\f078";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            float: right;
            margin-left: 10px;
        }

        .accordion-button.collapsed::after {
            content: "\f077";
        }

        .top-margin {
    margin-top: 30px;
}

        
    </style>
</head>
<body>
<div id="wrapper">
    <?php include('includes/top-nav-bar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row mb-3 align-items-center top-margin">

                    
    </br>
                    <div class="col-md-8">
                        <h4 class="header-title"><i class="fe-file-text"></i> Student Statement of Account</h4>
                    </div>
                    <div class="col-md-4">
                        <form method="get" action="">
                            <div class="input-group">
                                <select name="sy" class="form-control" onchange="this.form.submit()">
                                    <option value="">📆 Select School Year</option>
                                    <?php foreach ($syOptions as $option): ?>
                                        <option value="<?= $option->SY ?>" <?= ($selectedSY == $option->SY) ? 'selected' : '' ?>>
                                            <?= $option->SY ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">View</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                

                <?php if (!$selectedSY): ?>
                    <div class="alert alert-info">📅 Please select a School Year to view your account statement.</div>
                <?php elseif (!$data): ?>
                    <div class="alert alert-warning">⚠️ No records found for the selected School Year.</div>
                <?php else: ?>

                <div id="accordion">

                    <!-- Stude Accounts -->
                    <div class="card mb-2">
                        <div class="card-header">

                        <a href="<?= base_url('Page/print_statement?sy=' . $selectedSY); ?>" target="_blank" class="btn btn-success float-right">
    🖨️ Print Report
</a>

                            <h5>
                                <button class="btn btn-link accordion-button" data-toggle="collapse" data-target="#accountDetails" aria-expanded="true">
                                    📑 Student Accounts (<?= count($data) ?>)
                                </button>
                            </h5>
                        </div>
                        <div id="accountDetails" class="collapse show" data-parent="#accordion">
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-sm stude-table">
    <thead>
    <tr>
        <th>AccountID</th>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalFees = $totalPayments = $currentBalance = 0;
    foreach ($data as $row):
        $totalFees += $row->FeesAmount;
        $totalPayments = $row->TotalPayments; // assumed to be same for all rows
        $currentBalance = $row->CurrentBalance; // assumed to be same for all rows
    ?>
        <tr>
            <td><?= $row->AccountID ?></td>
            <td><?= $row->FeesDesc ?></td>
            <td><?= number_format($row->FeesAmount, 2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="2" class="text-right">Total Amount</th>
        <th><?= number_format($totalFees, 2) ?></th>
    </tr>
    </tfoot>
</table>

<!-- Display summary below the table -->
<div style="text-align: right; margin-top: 10px;">
    <p><strong>💵 Total Payments:</strong> <?= number_format($totalPayments, 2) ?></p>
    <p><strong>📌 Current Balance:</strong> <?= number_format($currentBalance, 2) ?></p>
</div>

                            </div>
                        </div>
                    </div>

                    <!-- Additional Fees -->
                    <div class="card mb-2">
                        <div class="card-header">
                            <h5>
                                <button class="btn btn-link accordion-button collapsed" data-toggle="collapse" data-target="#additionalFees">
                                    ➕ Additional Fees (<?= count($data1) ?>)
                                </button>
                            </h5>
                        </div>
                        <div id="additionalFees" class="collapse" data-parent="#accordion">
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-sm stude-table">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>School Year</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalAdd = 0;
                                    foreach ($data1 as $row):
                                        $totalAdd += $row->add_amount;
                                    ?>
                                        <tr>
                                            <td><?= $row->add_desc ?></td>
                                            <td><?= number_format($row->add_amount, 2) ?></td>
                                            <td><?= $row->SY ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-right">Total</th>
                                        <th><?= number_format($totalAdd, 2) ?></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Discounts -->
                    <div class="card mb-2">
                        <div class="card-header">
                            <h5>
                                <button class="btn btn-link accordion-button collapsed" data-toggle="collapse" data-target="#discounts">
                                    🎁 Discounts (<?= count($data2) ?>)
                                </button>
                            </h5>
                        </div>
                        <div id="discounts" class="collapse" data-parent="#accordion">
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-sm stude-table">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>School Year</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalDiscount = 0;
                                    foreach ($data2 as $row):
                                        $totalDiscount += $row->discount_amount;
                                    ?>
                                        <tr>
                                            <td><?= $row->discount_desc ?></td>
                                            <td><?= number_format($row->discount_amount, 2) ?></td>
                                            <td><?= $row->SY ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-right">Total</th>
                                        <th><?= number_format($totalDiscount, 2) ?></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payments -->
                    <div class="card">
                        <div class="card-header">
                            <h5>
                                <button class="btn btn-link accordion-button collapsed" data-toggle="collapse" data-target="#payments">
                                    💵 Payments (<?= count($data3) ?>)
                                </button>
                            </h5>
                        </div>
                        <div id="payments" class="collapse" data-parent="#accordion">
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-sm stude-table">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>OR Number</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>School Year</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalPay = 0;
                                    foreach ($data3 as $row):
                                        $totalPay += $row->Amount;
                                    ?>
                                        <tr>
                                            <td><?= $row->PDate ?></td>
                                            <td><?= $row->ORNumber ?></td>
                                            <td><?= number_format($row->Amount, 2) ?></td>
                                            <td><?= $row->PaymentType ?></td>
                                            <td><?= $row->SY ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Total</th>
                                        <th><?= number_format($totalPay, 2) ?></th>
                                        <th colspan="2"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</div>

<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {
    $('.stude-table').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print'],
        paging: false,
        ordering: false,
        info: false
    });
});
</script>
</body>
</html>
