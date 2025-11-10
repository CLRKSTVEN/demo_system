<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
</head>
<?php include('includes/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>

                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Update Payments</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Update Payment Form -->
                                    <!-- <h2>Update Payment</h2> -->
                                    <form method="post" action="<?= base_url('Accounting/updatePayment/' . $payment->ID); ?>">
    <div class="form-group row">
        <div class="col-md-3 mb-3">
            <label for="StudentNumber">Student Number</label>
            <input type="text" class="form-control" name="StudentNumber" value="<?= $payment->StudentNumber; ?>" readonly>
        </div>
        <div class="col-md-9 mb-3">
            <label for="StudentName">Student Name</label>
            <input type="text" class="form-control" value="<?= $payment->FirstName . ' ' . $payment->MiddleName . ' ' . $payment->LastName; ?>" readonly>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-md-3 mb-3">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" value="<?= $payment->description; ?>" required>
        </div>
        <div class="col-md-3 mb-3">
            <label for="Amount">Amount</label>
            <input type="number" class="form-control" name="Amount" value="<?= $payment->Amount; ?>" required>
        </div>
        <div class="col-md-3 mb-3">
            <label for="ORNumber">O.R Number</label>
            <input type="text" class="form-control" name="ORNumber" value="<?= $payment->ORNumber; ?>">
        </div>
        <div class="col-md-3 mb-3">
            <label for="PDate">Payment Date</label>
            <input type="date" class="form-control" name="PDate" value="<?= $payment->PDate; ?>" >
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-md-4 mb-3">
            <label for="CheckNumber">Check Number</label>
            <input type="text" class="form-control" name="CheckNumber" value="<?= $payment->CheckNumber; ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="Bank">Bank</label>
            <input type="text" class="form-control" name="Bank" value="<?= $payment->Bank; ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label for="PaymentType">Payment Type</label>
            <select class="form-control" name="PaymentType">
                <option value="Cash" <?= $payment->PaymentType == 'Cash' ? 'selected' : ''; ?>>Cash</option>
                <option value="Check" <?= $payment->PaymentType == 'Check' ? 'selected' : ''; ?>>Check</option>
            </select>
        </div>
    </div>
    
    <div class="modal-footer">
                                            <input type="submit" name="update" value="Save Data" class="btn btn-primary waves-effect waves-light" />
                                        </div>
</form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
        <?php include('includes/themecustomizer.php'); ?>
    </div>

    <!-- Vendor JS -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <!-- Additional JavaScript and Plugins -->
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
