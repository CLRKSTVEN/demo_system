<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<!-- Add Bootstrap CSS if not already in head.php -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
                                <h4 class="page-title">For Verification of Payments Made Online <br />
                                    <span class="badge badge-primary mb-3">SY <?php echo $this->session->userdata('sy'); ?></span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Student No.</th>
                                                <th>File</th>
                                                <th>Amount Paid</th>
                                                <th>Payment For</th>
                                                <th>Applicable SY</th>
                                                <th>Date Uploaded</th>
                                                <th>Note</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data1 as $row) { ?>
                                                <tr>
                                                    <td><?= $row->LastName ?></td>
                                                    <td><?= $row->FirstName ?></td>
                                                    <td><?= $row->StudentNumber ?></td>
                                                    <td>
                                                        <button
                                                            type="button"
                                                            class="btn btn-info btn-xs viewFileBtn"
                                                            data-file="<?= base_url('upload/payments/' . $row->depositAttachment); ?>">
                                                            View
                                                        </button>

                                                    </td>
                                                    <td><?= number_format($row->amountPaid, 2) ?></td>
                                                    <td><?= $row->payment_for ?></td>
                                                    <td><?= $row->sem . ' ' . $row->sy ?></td>
                                                    <td><?= $row->date_uploaded ?></td>
                                                    <td><?= $row->note ?></td>
                                                    <td>
                                                        <button
                                                            type="button"
                                                            class="btn btn-info btn-xs openPaymentModal"
                                                            data-studnumber="<?= $row->StudentNumber ?>"
                                                            data-fname="<?= $row->FirstName ?>"
                                                            data-mname="<?= $row->MiddleName ?>"
                                                            data-lname="<?= $row->LastName ?>"
                                                            data-course="<?= $row->Course ?>"
                                                            data-amount="<?= $row->amountPaid ?>"
                                                            data-desc="<?= $row->payment_for ?>"
                                                            data-sem="<?= $row->sem ?>"
                                                            data-sy="<?= $row->sy ?>"
                                                            data-opid="<?= $row->opID ?>">
                                                            Accept Payment
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-xs openDenyModal"
                                                            data-opid="<?= $row->opID ?>"
                                                            data-studnumber="<?= $row->StudentNumber ?>"
                                                            data-fname="<?= $row->FirstName ?>"
                                                            data-lname="<?= $row->LastName ?>">
                                                            Deny Payment
                                                        </button>

                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/themecustomizer.php'); ?>


    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="post" action="<?= base_url('Page/acceeptOnlinePayment'); ?>">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Accept Payment</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="opID" id="opID">
                        <input type="hidden" name="StudentNumber" id="StudentNumber">

                        <div class="form-group col-md-4">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="FirstName" id="FirstName" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="MiddleName" id="MiddleName" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="LastName" id="LastName" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Amount Paid</label>
                            <input type="text" class="form-control" name="Amount" id="Amount" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Payment For</label>
                            <input type="text" class="form-control" name="description" id="description">
                        </div>

                        <div class="form-group col-md-4">
                            <label>School Year</label>
                            <input type="text" class="form-control" name="sy" id="sy" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>O.R. No. / Ref. No.<span style="color:red">*</span></label>
                            <input type="text" class="form-control" name="ORNumber" value="<?= isset($nextOR) ? $nextOR : ''; ?>" required>

                        </div>


                        <div class="form-group col-md-4">
                            <label>Payment Type <span style="color:red">*</span></label>
                            <select name="PaymentType" class="form-control" required>
                                <option value=""></option>
                                <option value="Cash">Cash</option>
                                <option value="Check">Check</option>
                                <option value="Online - Bank Deposit">Online - Bank Deposit</option>
                                <option value="Online - Mobile/Internet Banking">Online - Mobile/Internet Banking</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Bank/Payment Center <span style="color:red">*</span></label>
                            <input type="text" class="form-control" name="Bank" value="" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Confirm Accept</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Deny Payment Modal -->
    <div class="modal fade" id="denyPaymentModal" tabindex="-1" role="dialog" aria-labelledby="denyPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="post" action="<?= base_url('Page/denyOnlinePayment'); ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="denyPaymentModalLabel">Deny Payment</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="opID" id="denyOpID">
                        <input type="hidden" name="StudentNumber" id="denyStudentNumber">



                        <div class="form-group col-md-8">
                            <label>Reason for Denial <span style="color:red">*</span></label>
                            <textarea class="form-control" name="denyReason" id="denyReason" required></textarea>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Date Denied</label>
                            <input type="text" class="form-control" name="deniedDate" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Confirm Denial</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- View File Modal -->
    <div class="modal fade" id="viewFileModal" tabindex="-1" role="dialog" aria-labelledby="viewFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Attachment</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="fileFrame" src="" style="width: 100%; height: 80vh;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            // Open Accept Payment Modal
            $('.openPaymentModal').on('click', function() {
                $('#StudentNumber').val($(this).data('studnumber'));
                $('#FirstName').val($(this).data('fname'));
                $('#MiddleName').val($(this).data('mname'));
                $('#LastName').val($(this).data('lname'));
                $('#Amount').val($(this).data('amount'));
                $('#description').val($(this).data('desc'));
                $('#sy').val($(this).data('sy'));
                $('#opID').val($(this).data('opid'));
                $('#paymentModal').modal('show');
            });

            // Open Deny Payment Modal
            $('.openDenyModal').on('click', function() {
                $('#denyOpID').val($(this).data('opid'));
                $('#denyStudentNumber').val($(this).data('studnumber'));
                $('#denyFirstName').val($(this).data('fname'));
                $('#denyLastName').val($(this).data('lname'));
                $('#denyPaymentModal').modal('show');
            });
        });


        // Show file in modal
        $('.viewFileBtn').on('click', function() {
            var fileUrl = $(this).data('file');
            $('#fileFrame').attr('src', fileUrl);
            $('#viewFileModal').modal('show');
        });
    </script>


</body>

</html>