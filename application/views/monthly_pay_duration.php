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

                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="page-title-box d-flex justify-content-between">
                            <h4 class="page-title">Monthly Payment Duration</h4>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMonthModal">Add New</button>
                        </div>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                        <?php elseif ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Duration Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                          <table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th>Month Range</th>
            <th>Duration Count</th>
            <th style="text-align:center;">Manage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
             <td><?= $row->start_month . ' - ' . $row->end_month; ?></td>
                <td><?= $row->month_count; ?></td>

                <td style="text-align:center;">
                    <a href="<?= base_url('Accounting/DeleteBatch?batch_id=' . $row->batch_id); ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Delete all months from <?= $row->start_month ?> to <?= $row->end_month ?>?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($data)): ?>
            <tr><td colspan="3" class="text-center">No records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

                        </div>
                    </div>
                </div>

                <!-- Add Month Modal -->
                <div class="modal fade" id="addMonthModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="<?= base_url('Accounting/save_monthly_duration') ?>" method="post" onsubmit="return prepareMonths();">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Monthly Duration</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body row">
                                  <div class="col-md-6">
    <label>From (Month, Year)</label>
    <input type="month" id="fromMonthYear" class="form-control" required>
</div>
<div class="col-md-6">
    <label>To (Month, Year)</label>
    <input type="month" id="toMonthYear" class="form-control" required>
</div>

                                </div>

                                <!-- Hidden inputs for generated months -->
                                <div id="hiddenInputsContainer"></div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- JavaScript to generate hidden inputs -->
               <script>
function prepareMonths() {
    const from = document.getElementById('fromMonthYear').value; // format: "2025-05"
    const to = document.getElementById('toMonthYear').value;
    const container = document.getElementById('hiddenInputsContainer');

    if (!from || !to) {
        alert("Please select both start and end dates.");
        return false;
    }

    const [fromYear, fromMonth] = from.split('-').map(Number);
    const [toYear, toMonth] = to.split('-').map(Number);

    if (fromYear > toYear || (fromYear === toYear && fromMonth > toMonth)) {
        alert("Start month must not be later than end month.");
        return false;
    }

    container.innerHTML = ''; // Clear previous

    const monthNames = [ '', 'January', 'February', 'March', 'April', 'May', 'June',
                         'July', 'August', 'September', 'October', 'November', 'December' ];

    let currentYear = fromYear;
    let currentMonth = fromMonth;

    while (currentYear < toYear || (currentYear === toYear && currentMonth <= toMonth)) {
        const label = monthNames[currentMonth] + ' ' + currentYear;

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'months[]';
        input.value = label;
        container.appendChild(input);

        // Move to next month
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }
    }

    return true;
}
</script>


            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</div>

<!-- JS Scripts -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#datatable').DataTable();
    });
</script>
</body>
</html>
