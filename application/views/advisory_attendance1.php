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
                <div class="card-box table-responsive">
                    <h3 class="mb-2">Advisory Class Attendance</h3>

                 <form method="post" class="form-inline mb-3" action="<?= base_url('Masterlist/advisoryAttendance'); ?>">
    <label class="mr-2">From:</label>
    <input type="date" name="from" value="<?= isset($_POST['from']) ? $_POST['from'] : date('Y-m-d'); ?>" class="form-control mr-2" required>
    <label class="mr-2">To:</label>
    <input type="date" name="to" value="<?= isset($_POST['to']) ? $_POST['to'] : date('Y-m-d'); ?>" class="form-control mr-2" required>
    <button type="submit" class="btn btn-primary">Load</button>
</form>


                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                    <?php elseif ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                    <?php endif; ?>
<form method="post" action="<?= base_url('Masterlist/advisoryAttendance'); ?>">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th rowspan="2">Student Name</th>
                <?php foreach ($dates as $date): ?>
                    <th colspan="2" class="text-center"><?= date('M d', strtotime($date)); ?></th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($dates as $date): ?>
                    <th class="text-center">AM</th>
                    <th class="text-center">PM</th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <?php $studentNumber = $student->StudentNumber; ?>
                <tr>
                    <td><?= $student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName; ?></td>
                    <?php foreach ($dates as $date): ?>
                        <?php foreach (['AM', 'PM'] as $period): ?>
                            <?php
                                $status = $existing[$date][$period][$studentNumber]['status'] ?? '';
                                $remarks = $existing[$date][$period][$studentNumber]['remarks'] ?? '';
                            ?>
                      <td class="text-center">
    <div class="btn-group btn-group-toggle mb-1" data-toggle="buttons">
        <label class="btn btn-outline-success btn-sm <?= ($status === 'Present') ? 'active' : '' ?>">
            <input type="radio" name="attendance[<?= $date ?>][<?= $period ?>][<?= $studentNumber ?>]" value="Present" <?= ($status === 'Present') ? 'checked' : '' ?>> ✔
        </label>
        <label class="btn btn-outline-danger btn-sm <?= ($status === 'Absent') ? 'active' : '' ?>">
            <input type="radio" name="attendance[<?= $date ?>][<?= $period ?>][<?= $studentNumber ?>]" value="Absent" <?= ($status === 'Absent') ? 'checked' : '' ?>> ✘
        </label>
        <label class="btn btn-outline-warning btn-sm <?= ($status === 'Excused') ? 'active' : '' ?>">
            <input type="radio" name="attendance[<?= $date ?>][<?= $period ?>][<?= $studentNumber ?>]" value="Excused" <?= ($status === 'Excused') ? 'checked' : '' ?>> E
        </label>
    </div>

    <input type="text"
           class="form-control form-control-sm mt-1"
           name="remarks[<?= $date ?>][<?= $period ?>][<?= $studentNumber ?>]"
           id="remarks-<?= $date ?>-<?= $period ?>-<?= $studentNumber ?>"
           placeholder="Enter remarks"
           value="<?= $remarks ?>">
</td>

                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-right mt-3">
        <input type="submit" name="submit_attendance" value="Save Attendance" class="btn btn-success" />
    </div>
</form>

                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
</div>

<!-- <script>
$(document).ready(function () {
    $('input[type=radio]').on('change', function () {
        const matches = $(this).attr('name').match(/\[(.*?)\]\[(.*?)\]\[(.*?)\]/);
        if (!matches) return;
        const [_, date, period, student] = matches;
        const isExcused = $(this).val() === 'Excused';
        $('#remarks-' + date + '-' + period + '-' + student).toggle(isExcused);
    });

    $('input[type=radio]:checked').each(function () {
        const matches = $(this).attr('name').match(/\[(.*?)\]\[(.*?)\]\[(.*?)\]/);
        if (matches && $(this).val() === 'Excused') {
            const [_, date, period, student] = matches;
            $('#remarks-' + date + '-' + period + '-' + student).show();
        }
    });
});
</script> -->


<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
