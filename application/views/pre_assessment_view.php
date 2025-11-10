<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/libs/select2/select2.min.css">
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            font-size: 13px;
            background: #f4f6f9;
        }
        .header-box {
            background: #003d80;
            color: #fff;
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .header-box strong {
            color: #ffc107;
        }
        .section-title {
            background: #dee2e6;
            padding: 8px 12px;
            font-weight: bold;
            margin-top: 25px;
            border-radius: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background-color: #f1f3f5;
            font-weight: 600;
        }
        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
            .d-print-block {
                display: block !important;
            }
            body {
                background-color: #fff;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .header-box {
                background-color: #003d80 !important;
                color: #fff !important;
            }
            .section-title {
                background-color: #dee2e6 !important;
            }
        }
    </style>
</head>

<body>
<div id="wrapper">
    <?php include('includes/top-nav-bar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div class="content-page">
        <div class="content">
            <br>
            <div class="container-fluid">
<br>
                <!-- Printable Letterhead -->
                <div class="print-header text-center d-none d-print-block mb-3">
                    <?php if (!empty($letterhead[0]->letterhead_web)): ?>
                        <img src="<?= base_url('upload/banners/' . $letterhead[0]->letterhead_web); ?>" alt="Letterhead" style="width:100%;">
                    <?php endif; ?>
                    <h4>Pre-Assessment Summary</h4>
                </div>

                <!-- Form -->
                <form method="post" action="<?= base_url('Page/pre_assessment') ?>" class="form-row align-items-end mb-4 no-print">
                    <div class="col-md-3">
                        <label><strong>Select Student (optional)</strong></label>
                        <select name="studentSelect" class="form-control select2">
                            <option value="">-- Choose from list --</option>
                            <?php foreach ($students as $s): 
                                $fullname = $s->LastName . ', ' . $s->FirstName . ' ' . $s->MiddleName;
                            ?>
                                <option value="<?= $fullname ?>" <?= ($studentSelect == $fullname) ? 'selected' : '' ?>>
                                    <?= $fullname ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label><strong>Or Enter Name Manually</strong></label>
                        <input type="text" name="studentInput" class="form-control" value="<?= $studentInput ?? '' ?>" placeholder="e.g. Juan Dela Cruz">
                    </div>
                    <div class="col-md-3">
                        <label><strong>Select Year Level</strong></label>
                        <select name="yearLevel" class="form-control" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($yearLevels as $level): ?>
                                <option value="<?= $level ?>" <?= ($selectedLevel == $level) ? 'selected' : '' ?>><?= $level ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label><strong>&nbsp;</strong></label>
                        <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
                    </div>
                </form>

                <!-- Print Button -->
                <div class="no-print mb-3">
                    <button onclick="window.print()" class="btn btn-success"><i class="bi bi-printer"></i> Print</button>
                </div>

                <?php if (isset($fees)): ?>
                    <!-- Student Info Header -->
                    <div class="header-box">
                        👤 Student Name: <strong><?= $studentName ?: 'N/A' ?></strong><br>
                        📘 Year Level: <strong><?= $selectedLevel ?></strong>
                    </div>

                    <!-- Fee Table -->
                    <div class="section-title">📋 Applicable Fees</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; foreach ($fees as $f): $total += $f->Amount; ?>
                                <tr>
                                    <td><?= $f->Description ?></td>
                                    <td>₱<?= number_format($f->Amount, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>₱<?= number_format($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>

</body>
</html>
