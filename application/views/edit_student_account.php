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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <br>
                                <a href="#"></a>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"></li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                <h4 class="m-t-0 header-title mb-4"><b>Add Discount</b></h4>
                                    <div class="container">
    <p>Add Discount for <?= $studentAccount->StudentNumber . ' ' . $studentAccount->FirstName . ' ' . $studentAccount->MiddleName . ' ' . $studentAccount->LastName ?>
    </p>
                                    <form method="post" action="<?= base_url('Accounting/updateStudentAccount') ?>">
                                        <input type="hidden" name="AccountID" value="<?= $studentAccount->AccountID ?>">

                                      

                                        <div class="form-row align-items-center">

                                        <div class="col-md-12">
                                                <label>Discount Description</label>
                                                <input type="text" class="form-control" name="discount_desc" required>
                                            </div>

                                            <div class="col-md-12">
                                                <label>Discount</label>
                                                <input type="number" step="any" class="form-control" name="discount_amount" id="discountAmount">
                                            </div>
                                          
                                          
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">ADD</button>
                                            <a href="<?= base_url('Accounting/studeAccounts') ?>" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include('includes/footer.php'); ?>
                </div>

                <?php include('includes/themecustomizer.php'); ?>
            </div>

            <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
            <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
            <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
            <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
            <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
        </div>
    </body>
</html>
