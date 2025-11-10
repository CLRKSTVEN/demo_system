<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    

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
    <!-- <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script> -->
    <!-- <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script> -->
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
    <!-- <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script> -->

    <!-- Datatables init -->
    <!-- <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script> -->

    <!-- Select2 JS -->
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f6f9;
            font-size: 13px;
            color: #212529;
        }

        .sy-header {
            background: #003d80;
            color: #fff;
            padding: 8px 15px;
            margin: 20px 0 10px;
            border-radius: 3px;
            font-size: 13px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            padding: 6px 12px;
            margin-top: 20px;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: center;
        }

        th {
            background-color: #f1f3f5;
            font-weight: 600;
        }

        .summary-box {
            margin-top: 15px;
            text-align: right;
            font-size: 13px;
            background: #fff3cd;
            padding: 10px;
            border-left: 5px solid #ffc107;
            border-radius: 4px;
        }

        .summary-box span {
            font-weight: bold;
            color: #b02a37;
        }

        .container-fluid {
            padding: 15px 20px;
        }

        .top-margin {
            margin-top: 20px;
        }

        .header-title {
            font-size: 16px;
        }

        .input-group .form-control {
            font-size: 13px;
        }

        .btn-primary {
            font-size: 13px;
            padding: 4px 10px;
        }

        @media print {
            .no-print, .no-print * {
                display: none !important;
            }

            .d-print-block {
                display: block !important;
            }

            body {
                background-color: #fff;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .summary-box {
                border-left: 5px solid #ffc107;
                background: #fff3cd;
            }

            .section-title {
                font-size: 14px;
                font-weight: bold;
            }
             .print-header img {
            width: 100%;
        }
        }
    </style>
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
                              <?php if ($this->session->flashdata('msg')): ?>
                                <div class="alert alert-success">
                                    <?= $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?= $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            <h4 class="page-title">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#multiPaymentModal" style="float: right;">
                                    <i class="fa fa-plus"></i> Add Multiple Payments
                                </button>
                            </h4>
                          
                        </div>
                    </div>
                </div>

                <!-- Grouped Table by OR Number with Collapse -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title">Grouped Payments by O.R. Number</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>O.R. Number</th>
                                                <th>Student No.</th>
                                                <th>Student Name</th>
                                                <th>Payment Date</th>
                                                <th>Total Amount</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $orGroups = [];
                                            foreach ($data as $row) {
                                                $orGroups[$row->ORNumber]['entries'][] = $row;
                                            }
                                            foreach ($orGroups as $orNumber => $group) {
                                                if (count($group['entries']) < 2) continue;
                                                $first = $group['entries'][0];
                                                $total = array_sum(array_column($group['entries'], 'Amount'));
                                            ?>
                                                <tr data-toggle="collapse" data-target="#details<?= $orNumber; ?>" class="accordion-toggle">
                                                    <td><?= $orNumber; ?></td>
                                                    <td><?= $first->StudentNumber; ?></td>
                                                    <td><?= $first->LastName; ?>, <?= $first->FirstName; ?> <?= $first->MiddleName; ?></td>
                                                    <td><?= $first->PDate; ?></td>
                                                    <td style="text-align:right;"><?= number_format($total, 2); ?></td>
                                                    <td><button class="btn btn-sm btn-info">View</button></td>
                                                </tr>
                                                <tr class="collapse" id="details<?= $orNumber; ?>">
                                                    <td colspan="6">
                                                        <table class="table table-sm table-bordered mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Description</th>
                                                                    <th>Amount</th>
                                                                    <th>Manage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                               <?php foreach ($group['entries'] as $entry): ?>
                                                                <tr>
                                                                    <td><?= $entry->description; ?></td>
                                                                    <td style="text-align:right;">₱<?= number_format($entry->Amount, 2); ?></td>
                                                                    <td>
                                                                       <a href="<?= base_url('Page/deleteSinglePayment/' . $entry->ID . '/' . $entry->StudentNumber . '/' . $entry->ORNumber); ?>"
                                                                        class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure you want to delete this payment item?');">
                                                                        Delete
                                                                        </a>

                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
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

           <!-- Modal -->
<div class="modal fade" id="multiPaymentModal" tabindex="-1" role="dialog" aria-labelledby="multiPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="multiPaymentModalLabel">Add Multiple Payments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('Page/MultiPayment'); ?>">
                    <div class="form-group">
                        <label for="StudentNumber">Student Name</label>
                        <select class="form-control select2" name="StudentNumber" id="StudentNumber" required>
                            <option disabled selected>Select a student</option>
                            <?php foreach ($prof as $row): ?>
                                <option value="<?= $row->StudentNumber; ?>">
                                    <?= $row->LastName; ?>, <?= $row->FirstName; ?> <?= $row->MiddleName; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" name="Course" id="Course">

                    <div class="form-row">
                        <div class="col-md-4">
                            <label>Payment Type</label>
                            <select class="form-control" name="PaymentType">
                                <option value="Cash">Cash</option>
                                <option value="Check">Check</option>
                            </select>
                        </div>
                      <div class="col-md-4">
    <label>O.R. Number</label>
    <?php
        // If orDisplay == 1, prefill with suggestion; else blank.
        $prefillOR = (!empty($orDisplay) && (int)$orDisplay === 1)
            ? ($newORSuggestion ?? '')
            : '';
    ?>
    <input type="text"
           class="form-control"
           name="ORNumber"
           id="ORNumberField"
           value="<?= htmlspecialchars($prefillOR, ENT_QUOTES, 'UTF-8'); ?>"
           placeholder="<?= ((int)$orDisplay === 1) ? '' : 'Enter O.R. Number'; ?>"
           required>
</div>

                        <div class="col-md-4">
                            <label>Date</label>
                            <input type="date" class="form-control" name="PDate" required>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label><strong>Total Amount to Distribute</strong></label>
                     <input type="number" id="totalDistribute" step="any" class="form-control" placeholder="e.g. 1000">

                    </div>
<div class="form-group d-flex justify-content-between px-2 py-2 rounded bg-light border">
    <div>
        <label class="mb-0"><strong>Total Assigned:</strong></label>
        <span id="assignedTotal" class="text-primary ml-1">0.00</span>
    </div>
    <div>
        <label class="mb-0"><strong>Remaining Balance:</strong></label>
        <span id="remainingBalance" class="text-danger ml-1">0.00</span>
    </div>
</div>


                    <div class="form-group">
                        <label>Multiple Payment Entries</label>
               <table class="table table-bordered" id="multiPaymentsTable">
    <thead>
        <tr>
            <th>Description</th>
            <th>Amount</th>
            <th>
<button type="button" id="addRowBtn" class="btn btn-success btn-sm" onclick="addPaymentRow()">Add</button>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <select name="description[]" class="form-control select2 description-select" required>
                    <option value="">Select description</option>
                </select>
            </td>
            <td>
                <input type="number" name="Amount[]" step="any" class="form-control amount-field" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
            </td>
        </tr>
    </tbody>
</table>


                    </div>

                    <p class="mt-3 font-weight-bold">For Check Payment:</p>
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

                    <input type="hidden" name="SY" value="<?= $SY; ?>">
                    <input type="hidden" name="Cashier" value="<?= $this->session->userdata('username'); ?>">
                    <input type="hidden" name="CollectionSource" value="Student's Account">
                    <input type="hidden" name="ORStatus" value="Valid">

                    <div class="modal-footer">
                        <input type="submit" name="save_multiple" class="btn btn-primary" value="Save Payments">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <?php include('includes/footer.php'); ?>
</div>
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
$(document).ready(function () {
    $('.select2').select2();

    $('#StudentNumber').on('change', function () {
        const studentNumber = $(this).val();

        // Fetch and populate Course
        $.ajax({
            url: '<?= base_url("Accounting/getStudentCourse") ?>',
            type: 'GET',
            data: { studentNumber },
            dataType: 'json',
            success: function (res) {
                $('#Course').val(res.course || '');
            }
        });

        // Fetch and store descriptions
        populateDescriptions(studentNumber);
    });

    // When modal opens
    $('#multiPaymentModal').on('shown.bs.modal', function () {
        const studentNumber = $('#StudentNumber').val();
        if (studentNumber) {
            populateDescriptions(studentNumber);
        }
        calculateDistributedAmounts(); // ensure total assigned and remaining are updated
    });

    // Listen to changes
    $(document).on('change', '.description-select', function () {
        updateAllDescriptionDropdowns();
        calculateDistributedAmounts();
    });

    $('#totalDistribute').on('input', function () {
        calculateDistributedAmounts();
    });
});

// Add new row
function addPaymentRow() {
    const remaining = parseFloat($('#remainingBalance').text());
    if (remaining <= 0) return;

    const row = `
        <tr>
            <td>
                <select name="description[]" class="form-control select2 description-select" required>
                    <option value="">Select description</option>
                </select>
            </td>
            <td>
                <input type="number" name="Amount[]" step="any" class="form-control amount-field" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button>
            </td>
        </tr>
    `;
    $('#multiPaymentsTable tbody').append(row);
    $('.select2').select2(); // Re-init
    updateAllDescriptionDropdowns();
    calculateDistributedAmounts();
}


// Remove row
function removeRow(btn) {
    $(btn).closest('tr').remove();
    updateAllDescriptionDropdowns();
    calculateDistributedAmounts();
}

// Store globally
let allDescriptions = [];

// Fetch from server
function populateDescriptions(studentNumber) {
    $.ajax({
        url: '<?= base_url("Accounting/getDescriptionsByStudent") ?>',
        type: 'GET',
        data: { studentNumber },
        dataType: 'json',
        success: function (data) {
            allDescriptions = data;
            updateAllDescriptionDropdowns();
            calculateDistributedAmounts();
        },
        error: function () {
            alert('Error loading descriptions.');
        }
    });
}

// Update dropdowns with available descriptions
function updateAllDescriptionDropdowns() {
    const selectedValues = [];

    $('.description-select').each(function () {
        const val = $(this).val();
        if (val) selectedValues.push(val);
    });

    $('.description-select').each(function () {
        const $select = $(this);
        const currentVal = $select.val();
        $select.empty().append('<option value="">Select description</option>');

        allDescriptions.forEach(item => {
            if (!selectedValues.includes(item.Description) || item.Description === currentVal) {
                const option = `<option value="${item.Description}" data-amount="${item.Amount}">${item.Description}</option>`;
                $select.append(option);
            }
        });

        $select.val(currentVal).trigger('change.select2');
    });
}

// Main distribution logic
function calculateDistributedAmounts() {
    let totalInput = parseFloat($('#totalDistribute').val());
    let hasTotal = !isNaN(totalInput);
    let remaining = hasTotal ? totalInput : 0;
    let assigned = 0;

    $('.description-select').each(function () {
        const $row = $(this).closest('tr');
        const $amountField = $row.find('.amount-field');
        const selectedOption = $(this).find('option:selected');
        const maxAmount = parseFloat(selectedOption.data('amount')) || 0;

        let assign = 0;
        if (hasTotal) {
            if (remaining > 0) {
                assign = Math.min(maxAmount, remaining);
                remaining -= assign;
            } else {
                assign = 0;
            }
        } else {
            assign = maxAmount;
        }

        $amountField.val(assign.toFixed(2));
        assigned += assign;
    });

   if (!hasTotal) {
    // Don't auto-fill the field if user hasn't inputted anything
    remaining = 0;
}

    $('#assignedTotal').text(assigned.toFixed(2));
    $('#remainingBalance').text((parseFloat($('#totalDistribute').val()) - assigned).toFixed(2));

    // ✅ Disable Add button if no remaining balance
    if (remaining <= 0) {
        $('#addRowBtn').prop('disabled', true).addClass('btn-secondary').removeClass('btn-success');
    } else {
        $('#addRowBtn').prop('disabled', false).addClass('btn-success').removeClass('btn-secondary');
    }
}

</script>





</body>
</html>
