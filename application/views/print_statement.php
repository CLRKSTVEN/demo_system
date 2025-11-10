<!DOCTYPE html>
<html>
<head>
    <title>Student Statement Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 30px;
            color: #000;
        }

        .header img {
            width: 100%;
        }

        .school-info {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        h3 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #444;
            padding: 5px;
            text-align: center;
        }

        th {
            background: #eee;
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
        }

        .balance-box {
            text-align: right;
            margin-top: 5px;
            font-size: 15px;
        }

        .balance-box span {
            color: #d9534f;
            font-weight: bold;
            font-size: 16px;
        }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="header">
    <?php if ($school): ?>
        <img src="<?= base_url('upload/banners/' . $school->letterhead_web); ?>" alt="Letterhead">
    <?php endif; ?>
</div>

<div class="school-info">
    <h3><?= $school->SchoolName ?? '' ?></h3>
    <p><?= $school->SchoolAddress ?? '' ?></p>
</div>

<!-- Section: Student Account -->
<div class="section-title">📑 Student Account</div>
<table>
    <thead>
    <tr>
        <th>Account ID</th>
        <th>Description</th>
        <th>Amount</th>
        <th>SY</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalFees = $currentBalance = 0;
    foreach ($data as $row):
        $totalFees += $row->FeesAmount;
        $currentBalance = $row->CurrentBalance;
        $TotalPayments = $row->TotalPayments;
    ?>
    <tr>
        <td><?= $row->AccountID ?></td>
        <td><?= $row->FeesDesc ?></td>
        <td><?= number_format($row->FeesAmount, 2) ?></td>
        <td><?= $row->SY ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="2" class="text-right">Total</th>
        <th><?= number_format($totalFees, 2) ?></th>
        <th></th>
    </tr>
    </tfoot>
</table>

<div class="balance-box">
    📌 Total Payment: <span><?= number_format($TotalPayments, 2) ?></span></br>
    📌 Remaining Balance: <span><?= number_format($currentBalance, 2) ?></span>
</div>

<!-- Section: Additional + Discount -->
<div class="section-title">➕🎁 Additional Fees and Discounts</div>
<table>
    <thead>
    <tr>
        <th>Description</th>
        <th>Amount</th>
        <th>Type</th>
        <th>SY</th>
    </tr>
    </thead>
    <tbody>
    <?php $totalAdjustments = 0; ?>
    <?php foreach ($data1 as $row): $totalAdjustments += $row->add_amount; ?>
    <tr>
        <td><?= $row->add_desc ?></td>
        <td><?= number_format($row->add_amount, 2) ?></td>
        <td>Additional</td>
        <td><?= $row->SY ?></td>
    </tr>
    <?php endforeach; ?>
    <?php foreach ($data2 as $row): $totalAdjustments += $row->discount_amount; ?>
    <tr>
        <td><?= $row->discount_desc ?></td>
        <td><?= number_format($row->discount_amount, 2) ?></td>
        <td>Discount</td>
        <td><?= $row->SY ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th class="text-right" colspan="1">Total</th>
        <th><?= number_format($totalAdjustments, 2) ?></th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>

<!-- Section: Payment History -->
<div class="section-title">💵 Payment History</div>
<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>OR Number</th>
        <th>Amount</th>
        <th>Type</th>
        <th>SY</th>
    </tr>
    </thead>
    <tbody>
    <?php $paymentTotal = 0;
    foreach ($data3 as $row): $paymentTotal += $row->Amount; ?>
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
        <th><?= number_format($paymentTotal, 2) ?></th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>

<script> window.print(); </script>

</body>
</html>
