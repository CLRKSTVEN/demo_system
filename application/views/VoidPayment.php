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
                        <div class="col-md-12">
                            <div class="page-title-box">

                                <h4 class="page-title">
                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Void Payment</button>

                                </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="#"></a></li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                                <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>


                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <!-- Card Header -->


                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="clearfix">



                                        <!-- Payment Table -->
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>OR Number</th>
                                                                <th>Name</th>
                                                                <th>Description</th>
                                                                <th style="text-align: right;">Amount</th>
                                                                <th style="text-align: center;">O.R. Status</th>
                                                                <th style="text-align: center;">Date</th>
                                                                <th style="text-align: center;">Reason/s</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($data as $row) { ?>

                                                                <tr>
                                                                    <td><?= $row->ORNumber; ?></td>
                                                                    <td><?= $row->FirstName; ?> <?= $row->MiddleName; ?> <?= $row->LastName; ?></td>
                                                                    <td><?= $row->description; ?></td>
                                                                    <td style="text-align: right;"><?= number_format($row->Amount, 2); ?></td>
                                                                    <td style="text-align: center;"><?= $row->ORStatus; ?></td>
                                                                    <td style="text-align: center;"><?= $row->PDate; ?></td>
                                                                    <td><?= $row->Reasons; ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>






                                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Void Payments</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="<?php echo base_url('Accounting/VoidPayment'); ?>">

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="ORNumber">ORNumber</label>
                                                                    <select class="form-control select2" id="StudentNumber" name="ORNumber" required data-minimum-results-for-search="Infinity">
    <option disabled selected></option>
    <?php foreach ($prof as $row) { ?>
        <option value="<?php echo $row->ORNumber; ?>">
            <?php echo $row->ORNumber; ?>
        </option>
    <?php } ?>
</select>

                                                                </div>

                                                            </div>


                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="StudentNumber">Student Name</label>
                                                                    <input type="text" name="StudentNumber" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-4 mb-3">
                                                                    <label for="description">Description</label>
                                                                    <input type="text" name="description" class="form-control" readonly>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label for="amount">Amount</label>
                                                                    <input type="text" name="amount" class="form-control" readonly>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label for="pDate">Date Paid</label>
                                                                    <input type="text" name="pDate" class="form-control" readonly>
                                                                </div>
                                                            </div>




                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="Reasons">Reasons for Voiding</label>
                                                                    <textarea name="Reasons" id="Reasons" class="form-control" rows="4" placeholder="Enter reasons for voiding..."></textarea>
                                                                </div>
                                                            </div>



                                                            <input type="hidden" name="ORStatus" value="Void">

                                                            <input type="hidden" name="cashier" class="form-control" readonly>


                                                            <div class="modal-footer">
                                                                <input type="submit" name="save" value="Void" class="btn btn-primary waves-effect waves-light" />
                                                            </div>
                                                        </form>

                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        </div>







                                    </div>
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
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

    <!-- Select2 JS -->
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
    <script>
        $(document).ready(function() {
         $(document).ready(function() {
    $('#StudentNumber').select2({
        placeholder: 'Search ORNumber...',
        minimumInputLength: 1, // Show options only after typing 1 character
        width: '100%'
    });
            });

            $('#StudentNumber').on('select2:select', function(e) {
                var ORNumber = $(this).val();
                if (ORNumber) {
                    $.ajax({
                        url: '<?= base_url("Accounting/getPaymentDetails") ?>',
                        type: 'GET',
                        data: {
                            ORNumber: ORNumber
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response) {
                                // Populate the form fields with the fetched data
                                var fullName = `${response.FirstName} ${response.MiddleName} ${response.LastName}`;
                                $('input[name="StudentNumber"]').val(fullName);
                                $('input[name="description"]').val(response.description);
                                $('input[name="amount"]').val(parseFloat(response.Amount).toFixed(2));
                                $('input[name="pDate"]').val(response.PDate);
                                $('input[name="cashier"]').val(response.Cashier); // Populate cashier's name
                            } else {
                                alert('No payment details found for this OR Number.');
                            }
                        },
                        error: function() {
                            alert('Error fetching payment details.');
                        }
                    });
                }
            });


            function formatOption(option) {
                if (!option.id) {
                    return option.text;
                }

                var studentNumber = $(option.element).data('studentNumber');
                var name = $(option.element).data('name');
                var description = $(option.element).data('description');
                var amount = $(option.element).data('amount');
                var orStatus = $(option.element).data('orStatus');
                var pDate = $(option.element).data('pDate');

                var display = `
            <div>
                <strong>OR Number:</strong> ${option.text}<br/>
                ${name ? `<strong>Name:</strong> ${name}<br/>` : ''}
                ${description ? `<strong>Description:</strong> ${description}<br/>` : ''}
                ${amount ? `<strong>Amount:</strong> ${amount}<br/>` : ''}
                ${orStatus ? `<strong>O.R. Status:</strong> ${orStatus}<br/>` : ''}
                ${pDate ? `<strong>Date:</strong> ${pDate}<br/>` : ''}
            </div>
        `;
                return $(display);
            }
        });
    </script>



</body>

</html>