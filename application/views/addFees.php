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
                                <!-- <h4 class="page-title">CREATE STUDENT’S ACCOUNT</h4> -->
                                <br>
                                <a href="#">
                                    <!-- <span class="badge badge-purple mb-3"><b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b> -->
                                </a>
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
                                    <h4 class="m-t-0 header-title mb-4"><b>Add Fees</b></h4>
                                    <div class="container">
    <p>Add Fees for <?= $studentAccount->StudentNumber . ' ' . $studentAccount->FirstName . ' ' . $studentAccount->MiddleName . ' ' . $studentAccount->LastName ?>
    </p>
    <?php echo $this->session->flashdata('msg'); ?>
    

    <form method="post" action="<?php echo base_url('Accounting/saveNewFees'); ?>">
    <input type="hidden" name="StudentNumber" value="<?php echo $studentAccount->StudentNumber; ?>">
    <input type="hidden" name="SY" value="<?php echo $studentAccount->SY; ?>">
    
    <div class="form-group">
        <label for="FeesDesc">Fee Description:</label>
        <input type="text" class="form-control" name="FeesDesc" required>
    </div>

    <div class="form-group">
        <label for="FeesAmount">Amount:</label>
        <input type="number"  step="any" class="form-control" name="FeesAmount" required>
    </div>

    <button type="submit" class="btn btn-primary">Add Fees</button>
    <a href="<?php echo base_url('Accounting/studeAccounts'); ?>" class="btn btn-secondary">Cancel</a>
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
