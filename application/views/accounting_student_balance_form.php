<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Payment Form</title>
    <?php include('includes/head.php'); ?>
</head>

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
                                <h4 class="page-title">PAYABLE BALANCE</h4>
                                <br>
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

                    <!-- Payment Form -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                <form method="post" action="<?php echo base_url('Accounting/savePayment2'); ?>">
                                <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" id="FirstName" name="FirstName" value="<?php echo $data[0]->FirstName; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Middle Name</label>
                                                <input type="text" class="form-control" id="MiddleName" name="MiddleName" value="<?php echo $data[0]->MiddleName; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" id="LastName" name="LastName" value="<?php echo $data[0]->LastName; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="SY">School Year</label>
                                                <input type="text" class="form-control" id="SY" name="SY" value="<?php echo $data[0]->SY; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="PaymentType">Payment Type</label>
                                                <select class="form-control" id="PaymentType" name="PaymentType" required>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Check">Check</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="description">Description</label>
                                                <input type="text" class="form-control" id="description" name="description" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="Amount">Payable Balance</label>
                                                <input type="number" class="form-control" id="Amount" name="Amount" value="<?php echo $data[0]->CurrentBalance; ?>" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="ORNumber">O.R Number</label>
                                                <input type="text" class="form-control" id="ORNumber" name="ORNumber" value="<?php echo $newORSuggestion; ?>" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="PDate">Date</label>
                                                <input type="date" class="form-control" id="PDate" name="PDate" value="<?= date('Y-m-d'); ?>" required>
                                            </div>
                                        </div>

                                        <hr>
                                        <p>For Check Payment:</p>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="CheckNumber">Check Number</label>
                                                <input type="number" class="form-control" id="CheckNumber" name="CheckNumber">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="Bank">Bank</label>
                                                <input type="text" class="form-control" id="Bank" name="Bank">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="hidden" name="StudentNumber" value="<?php echo $data[0]->StudentNumber; ?>" />
                                            <input type="hidden" name="Course" value="<?php echo $data[0]->Course; ?>" />
                                            <input type="hidden" name="Cashier" value="<?= $this->session->userdata('username'); ?>" />
                                            <input type="hidden" name="CollectionSource" value="Student's Account" />
                                            <input type="hidden" name="ORStatus" value="Valid" />
                                        </div>

                                        <button type="submit" name="save" class="btn btn-primary">Save Payment</button>
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

    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

</body>

</html>
