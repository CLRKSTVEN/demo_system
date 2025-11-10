<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f6f9;
            font-size: 13px;
            color: #212529;
        }
        .sy-header {
            background: #003d80;
            color: #fff;
            padding: 8px 15px;
            margin: 20px 0 10px;
            border-radius: 3px;
            font-size: 13px;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            padding: 6px 12px;
            margin-top: 20px;
            border-radius: 3px;
            background: #eef2f7;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; background-color: #fff; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: center; }
        th { background-color: #f1f3f5; font-weight: 600; }
        .summary-box {
            margin-top: 15px; text-align: right; font-size: 13px;
            background: #fff3cd; padding: 15px; border-left: 15px solid #ffc107; border-radius: 4px;
        }
        .summary-box h5 {
            margin: 0 0 8px 0; font-size: 16px; border-bottom: 1px dashed #ffc107;
            color: #b02a37; padding-bottom: 6px;
        }
        .container-fluid { padding: 15px 20px; }
        .btn-print { position: relative; }
        .no-print-inline { display: inline-block; }
        @media print {
            .no-print, .no-print * { display: none !important; }
            .no-print-inline { display: none !important; }
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
            <div class="container-fluid position-relative">

                <!-- Screen controls (Print • Email • Recalculate Monthly • Recalculate Account) -->
                <div class="d-flex align-items-center flex-wrap gap-2 mb-3 no-print">
                  <button class="btn btn-success btn-sm" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                  </button>

                  <?php if (!empty($student) && !empty($student->StudentNumber)): ?>
                    <a href="<?= base_url('page/emailStudentAccount?id=' . $student->StudentNumber) ?>" class="btn btn-info btn-sm">
                      <i class="bi bi-envelope-fill"></i> Email Statement
                    </a>

                    <form
                      action="<?= base_url('Page/recalcMonthlySchedule'); ?>"
                      method="post"
                      class="d-inline-block m-0"
                      onsubmit="return confirm('Recalculate monthly schedule for this student? This will overwrite amounts for all PENDING rows for the current SY, and set all to Paid if Remaining Balance is 0.');"
                    >
                      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                             value="<?= $this->security->get_csrf_hash(); ?>">
                      <input type="hidden" name="studentNumber" value="<?= htmlspecialchars($student->StudentNumber, ENT_QUOTES, 'UTF-8'); ?>">
                      <input type="hidden" name="sy" value="<?= htmlspecialchars($selectedSY, ENT_QUOTES, 'UTF-8'); ?>">
                      <input type="hidden" name="remainingBalance" value="<?= htmlspecialchars(number_format($computedBalance, 2, '.', ''), ENT_QUOTES, 'UTF-8'); ?>">
                      <button class="btn btn-warning btn-sm" type="submit">
                        <i class="bi bi-arrow-clockwise"></i> Recalculate Monthly Schedule
                      </button>
                    </form>

                    <!-- NEW: Per-student Recalculate Account (adds missing fees + recomputes totals/payments/discounts/balance) -->
                    <form
                      action="<?= site_url('Accounting/recalcAccount'); ?>"
                      method="post"
                      class="d-inline-block m-0"
                      onsubmit="return confirm('Recalculate the account for Student <?= htmlspecialchars($student->StudentNumber, ENT_QUOTES, 'UTF-8'); ?> for SY <?= htmlspecialchars($selectedSY ?? '', ENT_QUOTES, 'UTF-8'); ?>?\n\nThis will add any missing fees from the master fees table and recompute Total Fees, Additional, Discounts, Payments, and Balance. Proceed?');"
                    >
                      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                             value="<?= $this->security->get_csrf_hash(); ?>">
                      <input type="hidden" name="studentNumber" value="<?= htmlspecialchars($student->StudentNumber, ENT_QUOTES, 'UTF-8'); ?>">
                      <input type="hidden" name="sy" value="<?= htmlspecialchars($selectedSY ?? $this->session->userdata('sy'), ENT_QUOTES, 'UTF-8'); ?>">
                      <button class="btn btn-primary btn-sm" type="submit">
                        <i class="bi bi-calculator"></i> Recalculate Account
                      </button>
                    </form>
                  <?php endif; ?>
                </div>

                <!-- Flash message -->
                <?php if ($this->session->flashdata('msg')): ?>
                    <div class="alert alert-<?= $this->session->flashdata('msg_type') ?: 'info' ?> alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('msg') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- =================== Header / Meta =================== -->
                <div class="sy-header">
                    📌 Student Number: <strong><?= htmlspecialchars($student->StudentNumber ?? '', ENT_QUOTES, 'UTF-8') ?></strong><br>
                    🙍 Student Name: <strong>
                        <?= htmlspecialchars(($student->FirstName ?? '') . ' ' . ($student->MiddleName ?? '') . ' ' . ($student->LastName ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </strong><br>
                    📅 School Year: <strong><?= htmlspecialchars($selectedSY ?? '', ENT_QUOTES, 'UTF-8') ?></strong><br>
                    📚 Year Level: <strong><?= htmlspecialchars($yearLevel ?? 'Not Set', ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <?php
                // Normalize lists from controller
                $listAccounts   = $data  ?? [];
                $listAdditional = $data1 ?? [];
                $listDiscounts  = $data2 ?? [];
                $listPayments   = $data3 ?? [];

                // Totals passed from controller
                $totalFees       = isset($totalFees) ? (float)$totalFees : 0.0;
                $totalAdd        = isset($totalAdd) ? (float)$totalAdd : 0.0;
                $totalDiscount   = isset($totalDiscount) ? (float)$totalDiscount : 0.0;
                $totalPay        = isset($totalPay) ? (float)$totalPay : 0.0;
                $computedBalance = isset($computedBalance) ? (float)$computedBalance : 0.0;

                // helpers to guess PKs so we can post them back
                $get_additional_pk = function($row) {
                    return $row->id ?? $row->add_id ?? $row->addID ?? $row->AddID ?? null;
                };
                $get_discount_pk = function($row) {
                    return $row->id ?? $row->discount_id ?? $row->disc_id ?? $row->discountID ?? $row->DiscountID ?? null;
                };
                ?>

                <!-- =================== Student Accounts =================== -->
                <div class="section-title">📑 Student Accounts</div>
                <table>
                    <thead>
                    <tr>
                        <th colspan="2" style="text-align:left">Description</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($listAccounts)): ?>
                        <?php foreach ($listAccounts as $row): ?>
                            <tr>
                                <td colspan="2" style="text-align:left"><?= htmlspecialchars($row->FeesDesc, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= number_format((float)$row->FeesAmount, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3">No records.</td></tr>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:left">Total</th>
                        <th><?= number_format($totalFees, 2) ?></th>
                    </tr>
                    </tfoot>
                </table>

                <!-- =================== Additional Fees (with Delete) =================== -->
              <?php if (!empty($listAdditional)) : ?>
  <div class="section-title">➕ Additional Fees</div>
  <table>
    <thead>
      <tr>
        <th style="text-align:left">Description</th>
        <th>Amount</th>
        <th class="no-print">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($listAdditional as $row): ?>
        <?php $aid = $row->adID ?? null; ?>
        <tr>
          <td style="text-align:left"><?= htmlspecialchars($row->add_desc, ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= number_format((float)$row->add_amount, 2) ?></td>
          <td class="no-print">
            <?php if ($aid !== null && !empty($student->StudentNumber) && !empty($selectedSY)): ?>
              <form action="<?= base_url('Page/deleteAdditional'); ?>" method="post" class="d-inline"
                    onsubmit="return confirm('Delete this additional fee?');">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="rec_id" value="<?= htmlspecialchars($aid, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="studentNumber" value="<?= htmlspecialchars($student->StudentNumber, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="sy" value="<?= htmlspecialchars($selectedSY, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </form>
            <?php else: ?>
              <span class="text-muted">–</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th style="text-align:left">Total Additional</th>
        <th><?= number_format($totalAdd, 2) ?></th>
        <th class="no-print"></th>
      </tr>
    </tfoot>
  </table>
<?php endif; ?>


                <!-- =================== Discounts (with Delete) =================== -->
              <?php if (!empty($listDiscounts)) : ?>
  <div class="section-title">💸 Discounts</div>
  <table>
    <thead>
      <tr>
        <th style="text-align:left">Description</th>
        <th>Amount</th>
        <th class="no-print">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($listDiscounts as $row): ?>
        <?php $did = $row->disID ?? null; ?>
        <tr>
          <td style="text-align:left"><?= htmlspecialchars($row->discount_desc, ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= number_format((float)$row->discount_amount, 2) ?></td>
          <td class="no-print">
            <?php if ($did !== null && !empty($student->StudentNumber) && !empty($selectedSY)): ?>
              <form action="<?= base_url('Page/deleteDiscountSOA'); ?>" method="post" class="d-inline"
                    onsubmit="return confirm('Delete this discount?');">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="rec_id" value="<?= htmlspecialchars($did, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="studentNumber" value="<?= htmlspecialchars($student->StudentNumber, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="sy" value="<?= htmlspecialchars($selectedSY, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </form>
            <?php else: ?>
              <span class="text-muted">–</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th style="text-align:left">Total Discount</th>
        <th><?= number_format($totalDiscount, 2) ?></th>
        <th class="no-print"></th>
      </tr>
    </tfoot>
  </table>
<?php endif; ?>


                <!-- =================== Monthly Payment Schedule =================== -->
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
                            <?php $displayStatus = ((float)$mp->amount == 0.0) ? 'Paid' : ($mp->status ?? 'Pending'); ?>
                            <tr>
                                <td style="text-align:left"><?= date('F Y', strtotime($mp->month_due)) ?></td>
                                <td>₱<?= number_format((float)$mp->amount, 2) ?></td>
                                <td>
                                    <span class="badge <?= $displayStatus === 'Paid' ? 'bg-success' : 'bg-warning' ?>">
                                        <?= htmlspecialchars($displayStatus, ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3">No monthly payment schedule found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                <!-- =================== Payment History (VALID only) =================== -->
                <div class="section-title">💵 Payment History</div>
                <table class="table table-bordered table-sm text-center">
                    <thead>
                    <tr>
                        <th style="text-align:left">Description</th>
                        <th>Date</th>
                        <th>O.R. Number</th>
                        <th>Amount</th>
                        <th>Type</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($listPayments)): ?>
                        <?php foreach ($listPayments as $row): ?>
                            <tr>
                                <td class="text-start" style="text-align:left">
                                    <?= htmlspecialchars($row->description, ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td><?= date('M d, Y', strtotime($row->PDate)) ?></td>
                                <td><?= htmlspecialchars($row->ORNumber, ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="text-success">₱<?= number_format((float)$row->Amount, 2) ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($row->PaymentType, ENT_QUOTES, 'UTF-8') ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No payment records found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="text-end" style="text-align:left">Total:</td>
                        <td class="text-success">₱<?= number_format($totalPay, 2) ?></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>

            <!-- =================== Account Summary =================== -->
<div class="summary-box">
  <h5><i class="bi bi-cash-stack"></i> Account Summary</h5>
  <div>
    <div><strong>💰 Total Fees:</strong>
      <span style="font-weight:bold;">₱<?= number_format($totalFees, 2) ?></span>
    </div>

    <?php if (!empty($listAdditional)): ?>
      <div><strong>➕ Additional Fees:</strong>
        <span style="font-weight:bold;">₱<?= number_format($totalAdd, 2) ?></span>
      </div>
    <?php endif; ?>

    <?php if (!empty($listDiscounts)): ?>
      <div><strong>💸 Discounts:</strong>
        <span style="font-weight:bold;">- ₱<?= number_format($totalDiscount, 2) ?></span>
      </div>
    <?php endif; ?>

    <div><strong>💵 Total Payments:</strong>
      <span style="font-weight:bold;">₱<?= number_format($totalPay, 2) ?></span>
    </div>

    <?php
      $displayBalance = ($totalFees + $totalAdd) - ($totalDiscount + $totalPay);
    ?>

    <div><strong>📌 Remaining Balance:</strong>
      <span style="color:#dc3545; font-weight:bold;">
        ₱<?= number_format($displayBalance, 2) ?>
      </span>
    </div>
  </div>
</div>

            </div> <!-- /.container-fluid -->
        </div> <!-- /.content -->
        <br><br><br>
        <?php include('includes/footer.php'); ?>
    </div>
</div>

<!-- Vendor/Lib scripts (keep your existing bundle) -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<!-- DataTables (optional if you use them) -->
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
</body>
</html>
