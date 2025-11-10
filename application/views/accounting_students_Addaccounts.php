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
                            <h4 class="page-title">CREATE STUDENT’S ACCOUNT</h4>
                            <br>
                            <span class="badge badge-purple mb-3"><b>SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?></b></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <!-- Flash Message / Dynamic Alert -->
                <div class="row">
                    <div class="col-md-12" id="dynamic-alert-area">
                        <?= $this->session->flashdata('msg'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <form role="form" method="post">

                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-lg-12">
                                                <label>Student Name <span style="color:red">*</span></label>
                                                <select class="form-control" id="studentNumberSelect" name="StudentNumber">
                                                    <option>Select</option>
                                                    <?php foreach ($studentsWithoutAccounts as $student): ?>
                                                        <?php $fullName = "{$student->StudentNumber} {$student->FirstName} {$student->MiddleName} {$student->LastName}"; ?>
                                                        <option value="<?= $student->StudentNumber; ?>"><?= $fullName; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <input type="hidden" name="SY" value="<?= $this->session->userdata('sy'); ?>" readonly required />

                                            <div class="col-lg-12 mt-4">
                                                <label for="feesTable">Applicable Fees:</label>
                                                <table class="table table-bordered" id="feesTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Description</th>
                                                        <th class="right-align">Amount</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="feesTableBody"></tbody>
                                                    <tfoot>
                                                    <tr><th>Total</th><th id="totalAmount" class="right-align">0.00</th></tr>
                                                    <tr><th>Amount Paid</th><th id="amountPaid" class="right-align">0.00</th></tr>
                                                    <tr><th>Current Balance</th><th id="currentBalance" class="right-align">0.00</th></tr>
                                                    </tfoot>
                                                </table>
                                                <input type="hidden" name="AmountPaid" id="hiddenAmountPaid" />
                                                <input type="hidden" name="CurrentBalance" id="hiddenCurrentBalance" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                       <input type="submit" name="add" value="Save" class="btn btn-primary">

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

<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

<script type="text/javascript">
const BASE_URL = '<?= base_url(); ?>';

$(document).ready(function () {
    $('#studentNumberSelect').select2({ placeholder: "Select a student", allowClear: true });

    $('#studentNumberSelect').change(function () {
        const studentNumber = $(this).val();
        if (studentNumber) {
            $.ajax({
                url: BASE_URL + 'Accounting/getStudentDetailsWithFees',
                type: 'POST',
                data: { StudentNumber: studentNumber, SY: '<?= $this->session->userdata("sy"); ?>' },
                dataType: 'json',
                success: function (response) {
                    const feesTableBody = $('#feesTableBody');
                    feesTableBody.empty();
                    let totalAmount = 0;

                    if (response.fees && response.fees.length > 0) {
                        response.fees.forEach(function (fee) {
                            feesTableBody.append(`<tr><td>${fee.Description}</td><td class="right-align">${formatNumber(fee.Amount)}</td></tr>`);
                            totalAmount += parseFloat(fee.Amount);
                        });
                    }

                    $('#totalAmount').text(formatNumber(totalAmount));
                    const amountPaid = parseFloat(response.amountPaid || 0);
                    const currentBalance = totalAmount - amountPaid;

                    $('#amountPaid').text(formatNumber(amountPaid));
                    $('#currentBalance').text(formatNumber(currentBalance));
                    $('#hiddenAmountPaid').val(amountPaid);
                    $('#hiddenCurrentBalance').val(currentBalance);

                    // Show alert if previous balances exist
                    if (response.balances && response.balances.length > 0) {
                        let balanceHtml = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h5 class="alert-heading">Outstanding Balances Detected</h5>
                                <p>The following balances must be settled before proceeding:</p>
                                <ul style="padding-left: 20px;">`;

                        response.balances.forEach(function (b) {
                            balanceHtml += `
                                <li style="margin-bottom: 5px;">
                                    SY ${b.SY}: 
                                    <a href="${BASE_URL}Accounting/viewStudentBalanceForm/${response.studentDetails.StudentNumber}/${b.SY}" 
                                        style="text-decoration: underline; color: #ffc107; font-weight: bold;">
                                        ₱${formatNumber(b.Balance)}
                                    </a>
                                </li>`;
                        });

                        balanceHtml += `
                                </ul>
                                <hr class="my-2">
                                <p class="mb-0">Please settle balances through the cashier or accounting office.</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;

                        $('#dynamic-alert-area').html(balanceHtml);
                        $('#submitBtn').prop('disabled', true); // Optional: disable submit
                    } else {
                        $('#dynamic-alert-area').html('');
                        $('#submitBtn').prop('disabled', false);
                    }
                },
                error: function () {
                    alert('Error retrieving student details.');
                    $('#feesTableBody').empty();
                }
            });
        } else {
            $('#feesTableBody').empty();
            $('#totalAmount, #amountPaid, #currentBalance').text('0.00');
            $('#dynamic-alert-area').html('');
        }
    });

    function formatNumber(num) {
        return parseFloat(num).toFixed(2);
    }
});
</script>

</body>
</html>
