<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- App css -->

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
                                    <?php if ($this->session->flashdata('success')) : ?>

                                        <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>'
                                            . $this->session->flashdata('success') .
                                            '</div>';
                                        ?>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('danger')) : ?>
                                        <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>'
                                            . $this->session->flashdata('danger') .
                                            '</div>';
                                        ?>
                                    <?php endif;  ?>


                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Student No.</th>
                                                <th>File</th>
                                                <th>Amount Paid</th>
                                                <th>Reference No.</th>
                                                <th>Payment For</th>
                                                <th>Applicable SY</th>
                                                <th>Date Uploaded</th>

                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data1 as $row) { ?>
                                                <tr>
                                                    <td><?= $row->LastName . ', ' . $row->FirstName ?></td>
                                                    <td><?= $row->StudentNumber ?></td>
                                                    <td>

                                                        <?php if (!empty($row->depositAttachment)): ?>
                                                            <button
                                                                type="button"
                                                                class="btn btn-info btn-xs viewFileBtn"
                                                                data-file="<?= base_url('upload/payments/' . $row->depositAttachment); ?>">
                                                                View
                                                            </button>
                                                        <?php endif; ?>

                                                    </td>
                                                    <td><?= number_format($row->amount, 2) ?></td>
                                                    <td><?= $row->refNo ?></td>
                                                    <td><?= $row->description ?></td>
                                                    <td><?= $row->sem . ' ' . $row->sy ?></td>
                                                    <td><?= $row->created_at ?></td>

                                                    <td>
                                                        <button
                                                            type="button"
                                                            class="btn btn-info btn-xs openPaymentModal"
                                                            data-studnumber="<?= $row->StudentNumber ?>"
                                                            data-fname="<?= $row->FirstName ?>"
                                                            data-mname="<?= $row->MiddleName ?>"
                                                            data-lname="<?= $row->LastName ?>"
                                                            data-course="<?= $row->Course ?>"
                                                            data-amount="<?= $row->amount ?>"
                                                            data-desc="<?= $row->description ?>"
                                                            data-sem="<?= $row->sem ?>"
                                                            data-sy="<?= $row->sy ?>"
                                                            data-opid="<?= $row->id ?>">
                                                            Accept Payment
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-xs openDenyModal"
                                                            data-opid="<?= $row->id ?>"
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
    <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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

    <div id="denyPaymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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


    <script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Chat app -->
    <script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>

    <!-- Todo app -->
    <script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>

    <!--Morris Chart-->
    <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>

    <!-- Sparkline charts -->
    <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Dashboard init JS -->
    <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <!-- Required datatable js -->
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>

    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

    <script>
        $(document).on('click', '.openPaymentModal', function() {
            console.log('Opening Accept Modal...');
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

        $(document).on('click', '.openDenyModal', function() {
            console.log('Opening Deny Modal...');
            $('#denyOpID').val($(this).data('opid'));
            $('#denyStudentNumber').val($(this).data('studnumber'));
            $('#denyPaymentModal').modal('show');
        });



        // Show file in modal
        // Show file in modal
        $(document).on('click', '.viewFileBtn', function() {
            var fileUrl = $(this).data('file');
            $('#fileFrame').attr('src', fileUrl); // Correct ID
            $('#viewFileModal').modal('show');
        });
    </script>


</body>

</html>