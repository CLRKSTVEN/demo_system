<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f6f9; font-size: 13px; color: #212529; }
        .sy-header { background: #003d80; color: #fff; padding: 8px 15px; margin: 20px 0 10px; border-radius: 3px; font-size: 13px; }
        .section-title { font-size: 13px; font-weight: bold; padding: 6px 12px; margin-top: 20px; border-radius: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; background-color: #fff; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: center; }
        th { background-color: #f1f3f5; font-weight: 600; }
        .summary-box { margin-top: 15px; text-align: right; font-size: 13px; background: #fff3cd; padding: 10px; border-left: 5px solid #ffc107; border-radius: 4px; }
        .summary-box span { font-weight: bold; color: #b02a37; }
        .container-fluid { padding: 15px 20px; }
        .top-margin { margin-top: 20px; }
        .header-title { font-size: 16px; }
        .input-group .form-control { font-size: 13px; }
        .btn-primary { font-size: 13px; padding: 4px 10px; }
        @media print {
            .no-print, .no-print * { display: none !important; }
            .d-print-block { display: block !important; }
            body { background-color: #fff; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .summary-box { border-left: 5px solid #ffc107; background: #fff3cd; }
            .section-title { font-size: 14px; font-weight: bold; }
            .print-header img { width: 100%; }
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

                    <!-- Printable Letterhead -->
                    <div class="print-header text-center d-none d-print-block mb-3">
                        <?php if ($school): ?>
                            <img src="<?= base_url('upload/banners/' . $school->letterhead_web); ?>" alt="Letterhead">
                        <?php endif; ?> <h4>Student Statement of Account</h4>
                    </div>

                    <div class="row top-margin">
                        <div class="col-md-8">
                            <h4 class="header-title"><i class="fe-file-text"></i> Student Statement of Account</h4>
                        </div>
                        <div class="col-md-4 text-end no-print">
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

                                    <button class="btn btn-primary" type="submit">View</button>

                                    <?php if (!empty($selectedSY)): ?>
                                        <button type="button" class="btn btn-info no-print" onclick="window.print()">
                                            <i class="bi bi-printer"></i> Print
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php if (!$selectedSY): ?>
                        <div class="alert alert-info mt-4">📅 Please select a School Year to view your account statement.</div>
                    <?php elseif (!$data): ?>
                        <div class="alert alert-warning mt-4">⚠️ No records found for the selected School Year.</div>
                    <?php else: ?>

                        <div class="sy-header">
                            📅 Selected School Year: <strong><?= $selectedSY ?></strong>
                        </div>

                        <!-- Accounts -->
                        <div class="section-title">📑 Student Accounts</div>
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalFees = 0;
                                $totalPayments = 0;
                                $currentBalance = 0;
                                foreach ($data as $row):
                                    $totalFees += $row->FeesAmount;
                                    $totalPayments = $row->TotalPayments ?? $totalPayments;
                                    $currentBalance = $row->CurrentBalance ?? $currentBalance;
                                ?>
                                    <tr>
                                        <td colspan="2" class="text-left"><?= $row->FeesDesc ?></td>
                                        <td><?= number_format($row->FeesAmount, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th><?= number_format($totalFees, 2) ?></th>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Additional Fees -->
                        <?php
                        // >>> ADDED: ensure $totalAdd is defined before used in the condition
                        $totalAdd = 0;
                        if (!empty($data1)) {
                            foreach ($data1 as $row) { $totalAdd += $row->add_amount; }
                        }
                        ?>

                        <?php if (!empty($data1) && $totalAdd > 0): ?>
                            <div class="section-title">➕ Additional Fees</div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data1 as $row): ?>
                                        <tr>
                                            <td class="text-left"><?= $row->add_desc ?></td>
                                            <td><?= number_format($row->add_amount, 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total Additional</th>
                                        <th><?= number_format($totalAdd, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php endif; ?>

                        <!-- Discounts -->
                        <?php
                        $totalDiscount = 0;
                        if (!empty($data2)) {
                            foreach ($data2 as $row) { $totalDiscount += $row->discount_amount; }
                        }
                        if (!empty($data2) && $totalDiscount > 0): ?>
                            <div class="section-title">💸 Discounts</div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data2 as $row): ?>
                                        <tr>
                                            <td class="text-left"><?= $row->discount_desc ?></td>
                                            <td><?= number_format($row->discount_amount, 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total Discount</th>
                                        <th><?= number_format($totalDiscount, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php endif; ?>

                        <!-- Monthly Payment Schedule -->
                        <div class="section-title">📆 Monthly Payment Schedule</div>
                        <table>
                            <thead>
                                <tr>
                                    <th style="text-align:left">Due Month</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($monthlySchedule)): ?>
                                    <?php foreach ($monthlySchedule as $mp): ?>
                                        <?php $displayStatus = ($mp->amount == 0) ? 'Paid' : ($mp->status ?? 'Pending'); ?>
                                        <tr>
                                            <td style="text-align:left"><?= date('F Y', strtotime($mp->month_due)) ?></td>
                                            <td>₱<?= number_format($mp->amount, 2) ?></td>
                                            <td>
                                                <span class="badge <?= $displayStatus === 'Paid' ? 'bg-success' : 'bg-warning' ?>">
                                                    <?= $displayStatus ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3">No monthly payment schedule found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Payments -->
                        <div class="section-title">💵 Payment History</div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>O.R. Number</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalPay = 0; ?>
                                    <?php if (!empty($data3)): ?>
                                        <?php foreach ($data3 as $row): ?>
                                            <?php
                                            // >>> ADDED: extra safety if model/controller misses filtering
                                            if (isset($row->ORStatus) && strcasecmp((string)$row->ORStatus, 'Valid') !== 0) {
                                                continue; // skip void/non-valid
                                            }
                                            $totalPay += (float)$row->Amount;
                                            ?>
                                            <tr>
                                                <td class="text-start"><?= $row->description ?></td>
                                                <td><?= date('M d, Y', strtotime($row->PDate)) ?></td>
                                                <td><?= $row->ORNumber ?></td>
                                                <td class="text-success">₱<?= number_format($row->Amount, 2) ?></td>
                                                <td><span class="badge bg-secondary"><?= $row->PaymentType ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-muted">No payment records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">Total:</td>
                                        <td class="text-success">
                                            ₱<?= number_format(($studentTotalPay ?? $totalPay), 2) // >>> CHANGED: valid-only total ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                      <!-- Final Summary -->
<div class="summary-box">
    💵 Total Payments:
    <span><?= number_format(($studentTotalPay ?? $totalPay), 2) ?></span><br>
    📌 Remaining Balance:
    <span><?= number_format(($studentComputedBalance ?? (($totalFees + $totalAdd) - ($totalPay + $totalDiscount))), 2) ?></span>
    <br><br>

  <?php if (!empty($showOnlinePayments) && $showOnlinePayments): ?>
    <a href="<?= base_url('OnlinePayment?studentno=' . $this->session->userdata('StudentNumber')); ?>"
       class="btn btn-info no-print">
        <i class="mdi mdi-credit-card-outline"></i> Pay Now via Dragonpay
    </a>
<?php endif; ?>

</div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
        <br><br><br>

        <?php include('includes/footer.php'); ?>
    </div>
    </div>

    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>
    <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
</body>
</html>
