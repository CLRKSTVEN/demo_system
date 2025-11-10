<!DOCTYPE html>
<html lang="en">

<head>
    <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" />
    <?php include('includes/head.php'); ?>
</head>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Flash Messages -->
                    <?php if ($this->session->flashdata('msg')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('msg'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Add New Button -->
                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target=".bs-example-modal-lg">Add New</button>
                        </div>
                    </div>
<!-- Date Range Filter -->
<form class="mb-3" method="get" action="<?= base_url('Accounting/Payment'); ?>">
  <div class="card">
    <div class="card-body py-2">
      <div class="form-row align-items-end">
        <div class="col-sm-12 col-md-3">
          <label class="mb-1">From</label>
          <input type="date" name="from" class="form-control"
                 value="<?= htmlspecialchars($from ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="col-sm-12 col-md-3">
          <label class="mb-1">To</label>
          <input type="date" name="to" class="form-control"
                 value="<?= htmlspecialchars($to ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="col-sm-12 col-md-6">
          <div class="d-flex mt-3 mt-md-0">
            <button type="submit" class="btn btn-primary mr-2">Filter</button>
            <a class="btn btn-light border" href="<?= base_url('Accounting/Payment'); ?>">Reset</a>
          </div>
        </div>
      </div>

      <!-- Small status line -->
      <div class="mt-2 small text-muted">
        Showing payments from <strong><?= htmlspecialchars($from); ?></strong>
        to <strong><?= htmlspecialchars($to); ?></strong>
        — Total: <strong>₱<?= number_format($grandTotal ?? 0, 2); ?></strong>
      </div>
    </div>
  </div>
</form>

                    <!-- Payments Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <strong>PAYMENTS - ACCOUNTS</strong>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                           <thead>
                                            <tr>
                                                <th>Student No.</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-center">Txn Ref</th>
                                                <th class="text-center">O.R. No.</th>
                                                <th class="text-center">Payment Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (!empty($data)) { foreach ($data as $row) { ?>
                                                <tr>
                                                <td><?= $row->StudentNumber; ?></td>
                                                <td><?= $row->LastName; ?>, <?= $row->FirstName; ?> <?= $row->MiddleName; ?></td>
                                                <td><?= $row->description; ?></td>
                                                <td class="text-right">₱<?= number_format($row->Amount, 2); ?></td>
                                                <td class="text-center"><code><?= htmlspecialchars($row->transaction_ref ?? ''); ?></code></td>
                                                <td class="text-center"><?= htmlspecialchars($row->ORNumber ?? ''); ?></td>
                                                <td class="text-center"><?= htmlspecialchars($row->PDate ?? ''); ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('Accounting/updatePayment/' . $row->ID); ?>" class="btn btn-warning btn-sm">Update</a>
                                                </td>
                                                </tr>
                                            <?php } } else { ?>
                                                <tr>
                                                <td colspan="8" class="text-center">No payments found for the selected date.</td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Table -->
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <strong>SUMMARY</strong>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($groupedPayments)) { ?>
                                                <?php foreach ($groupedPayments as $description => $totalAmount) { ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($description); ?></td>
                                                        <td class="text-success">₱<?= number_format($totalAmount, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="2" class="text-center">No summary data available.</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Form: Add New -->
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="post" action="<?= base_url('Accounting/Payment'); ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                        
                                    </div>
                                    <div class="alert alert-info py-2">
  <small><strong>Note:</strong> A unique <em>Transaction Reference</em> will be generated automatically upon saving.</small>
</div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="StudentNumber">Student</label>
                                            <select class="form-control select2" id="StudentNumber" name="StudentNumber" required>
                                                <option disabled selected>Select a student</option>
                                                <?php foreach ($prof as $row) { ?>
                                                    <option value="<?= $row->StudentNumber; ?>">
                                                        <?= $row->LastName; ?>, <?= $row->FirstName; ?> <?= $row->MiddleName; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <input type="hidden" id="Course" name="Course" class="form-control" readonly>

                                        <div class="form-row">
                                            <div class="col-md-3">
                                                <label>Payment Type</label>
                                                <select class="form-control" name="PaymentType">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Check">Check</option>
                                                </select>
                                            </div>
                                            <div class="col-md-9">
                                                <label>Description</label>
                                                <input type="text" class="form-control" name="description" required>
                                            </div>
                                        </div>

                                        <div class="form-row mt-3">
                                            <div class="col-md-4">
                                                <label>Amount</label>
                                                <input type="number" class="form-control" step="any" name="Amount" required>
                                            </div>
                                       <div class="col-md-4">
    <label>O.R Number</label>
    <?php
        // If orDisplay == 1, prefill suggestion; else keep it blank.
        $prefillOR = (!empty($orDisplay) && (int)$orDisplay === 1)
            ? ($newORSuggestion ?? '')
            : '';
    ?>
    <input type="text"
           class="form-control"
           name="ORNumber"
           value="<?= htmlspecialchars($prefillOR, ENT_QUOTES, 'UTF-8'); ?>"
           placeholder="<?= ((int)$orDisplay === 1) ? '' : 'Enter O.R Number'; ?>"
           required>
</div>

                                            <div class="col-md-4">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="PDate" value="" required>
                                            </div>
                                        </div>

                                        <hr>
                                        <p>For Check Payment:</p>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label>Check Number</label>
                                                <input type="number" class="form-control" name="CheckNumber">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Bank</label>
                                                <input type="text" class="form-control" name="Bank">
                                            </div>
                                        </div>

                                        <input type="hidden" name="SY" value="<?= $this->session->userdata('sy'); ?>" />
                                        <input type="hidden" name="Cashier" value="<?= $this->session->userdata('username'); ?>" />
                                        <input type="hidden" name="CollectionSource" value="Student's Account" />
                                        <input type="hidden" name="ORStatus" value="Valid" />
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" name="save" class="btn btn-primary" value="Save Data" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div> <!-- /.container-fluid -->
            </div> <!-- /.content -->
        </div> <!-- /.content-page -->

        <?php include('includes/footer.php'); ?>
    </div> <!-- /#wrapper -->

     <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>


    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

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


    <!-- Datatables init -->

    <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>
    <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#StudentNumber').on('change', function() {
                var studentNumber = $(this).val();
                if (studentNumber) {
                    $.ajax({
                        url: '<?= base_url("Accounting/getStudentCourse") ?>',
                        type: 'GET',
                        data: {
                            studentNumber: studentNumber
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#Course').val(response.course || 'No course found');
                        },
                        error: function() {
                            alert('Error fetching course data.');
                        }
                    });
                } else {
                    $('#Course').val('');
                }
            });

            $('#datatable').DataTable({
                responsive: true,
                ordering: false
            });
        });
    </script>
</body>

</html>