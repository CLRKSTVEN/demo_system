<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<style>
    @media print {
        .no-print {
            display: none !important;
        }

        .letterhead {
            display: block !important;
        }

        .card, .content-page, .content, .page-title-box {
            box-shadow: none !important;
            border: none !important;
        }

        body {
            font-size: 13px;
        }

        table th, table td {
            font-size: 13px;
        }

        hr {
            margin: 10px 0;
        }
    }

    .letterhead {
        display: none;
        text-align: center;
        margin-bottom: 15px;
    }

    .letterhead img {
        max-width: 100%;
        height: auto;
    }

    .letterhead h5, .letterhead p {
        margin: 5px 0;
        line-height: 1.4;
    }

    .table th, .table td {
        vertical-align: middle;
        text-align: left;
    }

    .table th {
        background-color: #f2f2f2;
    }
</style>

<body>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page Title (Visible only on screen) -->
                    <div class="row no-print">
                        <div class="col-md-12">
                            <div class="page-title-box d-flex justify-content-between align-items-center">
                              
                                    <!-- <a href="<?= base_url('Page/discountReports'); ?>" class="btn btn-secondary btn-sm">← Back</a> -->
                                    <button onclick="window.print()" class="btn btn-primary btn-sm">🖨 Print</button>
                                </div>
                            </div>
                        </div>

                    <!-- Letterhead (Print only) -->
                    <div class="letterhead">
                        <img src="<?= base_url('upload/banners/' . $letterhead[0]->letterhead_web); ?>" alt="Letterhead">
                        <hr>
                      
                    </div>

                    <!-- Report Table -->
                    <div class="card">
                        <div class="card-body table-responsive">
                         <!-- Report Header -->
<h5><strong>DISCOUNT BENEFICIARIES REPORT</strong></h5>
<p class="text-muted font-1 mb-0">
    School Year: <strong><?= $sy; ?></strong> |
    Discount Type: <strong><?= $desc; ?></strong>
</p>

<?php
// Group by gender
$males = [];
$females = [];

foreach ($students as $s) {
    if (strtolower($s->Sex) === 'male') {
        $males[] = $s;
    } elseif (strtolower($s->Sex) === 'female') {
        $females[] = $s;
    }
}

usort($males, function($a, $b) {
    return strcmp($a->LastName . $a->FirstName, $b->LastName . $b->FirstName);
});
usort($females, function($a, $b) {
    return strcmp($a->LastName . $a->FirstName, $b->LastName . $b->FirstName);
});
?>


<table class="table table-bordered mt-3">
    <thead class="thead-light">
        <tr>
            <th style="width: 30%;">Student Name</th>
            <th style="width: 20%;">Student Number</th>
            <th style="width: 20%;">Year Level</th>
            <th style="width: 30%;">Discount Amount</th>
        </tr>
    </thead>

    <!-- MALE -->
    <tbody>
        <tr class="bg-primary text-white text-center">
            <td colspan="4" class="font-weight-bold">MALE</td>
        </tr>
        <?php foreach ($males as $s): ?>
        <tr>
            <td><?= $s->LastName . ', ' . $s->FirstName . ' ' . $s->MiddleName; ?></td>
            <td><?= $s->StudentNumber; ?></td>
            <td><?= $s->YearLevel; ?></td>
            <td>₱ <?= number_format((float)$s->discount_amount, 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

    <!-- FEMALE -->
    <tbody>
        <tr class="text-white text-center" style="background:#e83e8c;">
            <td colspan="4" class="font-weight-bold">FEMALE</td>
        </tr>
        <?php foreach ($females as $s): ?>
        <tr>
            <td><?= $s->LastName . ', ' . $s->FirstName . ' ' . $s->MiddleName; ?></td>
            <td><?= $s->StudentNumber; ?></td>
            <td><?= $s->YearLevel; ?></td>
            <td>₱ <?= number_format((float)$s->discount_amount, 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

                        </div>
                    </div>

                </div> <!-- /.container-fluid -->
            </div> <!-- /.content -->

            <?php include('includes/footer.php'); ?>
        </div> <!-- /.content-page -->

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div> <!-- /#wrapper -->

    <!-- Right Sidebar -->
    <?php include('includes/themecustomizer.php'); ?>

    <!-- Scripts (no DataTables) -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
