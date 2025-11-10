<!doctype html>
<html lang="en">
<?php /* If you use a layout, you can include it:
   // include('includes/head.php');
*/ ?>

<head>
    <meta charset="utf-8">
    <title>Payment Cancelled</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
</head>

<body class="container py-5">

    <div class="text-center mb-4">
        <h2 class="mb-2 text-danger">Payment Cancelled</h2>
        <p class="text-muted">Your payment did not proceed. You can try again anytime.</p>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Transaction ID (txnid)</div>
                <div class="col-md-8"><?= html_escape($txnid ?? ''); ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold">Status</div>
                <div class="col-md-8">
                    <span class="badge bg-secondary"><?= html_escape($status ?? 'CANCELLED'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="<?= base_url(); ?>">Back to Dashboard</a>
        <a class="btn btn-outline-danger" href="<?= base_url('OnlinePayment'); ?>">Try payment again</a>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>