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
                    <div class="col-12">
                        <div class="card-box table-responsive">
                            <h3 class="mb-2">Advisory Class Attendance</h3>
                            <?php
                                date_default_timezone_set('Asia/Manila');
                                $currentDate = date('F d, Y');
                                $currentPeriod = date('A');
                            ?>
                            <p class="mb-3 text-muted" style="font-size: 16px;">
                                <strong>Date:</strong> <?= $currentDate; ?> &nbsp; | &nbsp;
                                <strong>Period:</strong> <?= $currentPeriod; ?>
                            </p>

                            <?php if ($this->session->flashdata('success')) : ?>
                                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                            <?php endif; ?>

                            <?php
                            // ✅ Normalize and group students properly by sex
                            $groupedStudents = ['Male' => [], 'Female' => []];
                            foreach ($students as $student) {
                                if (isset($student->Sex)) {
                                    $normalizedSex = ucfirst(strtolower($student->Sex));
                                    if ($normalizedSex === 'M') $normalizedSex = 'Male';
                                    if ($normalizedSex === 'F') $normalizedSex = 'Female';

                                    if (isset($groupedStudents[$normalizedSex])) {
                                        $groupedStudents[$normalizedSex][] = $student;
                                    }
                                }
                            }
                            ?>

                            <form method="post" action="<?= base_url('Masterlist/advisoryAttendance'); ?>">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Year</th>
                                            <th>Section</th>
                                            <th style="text-align: center;">Attendance (<?= $currentPeriod ?>)</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (['Male', 'Female'] as $sex): ?>
                                            <?php if (!empty($groupedStudents[$sex])): ?>
                                                <tr class="table-primary">
                                                    <td colspan="5"><strong><?= strtoupper($sex); ?></strong></td>
                                                </tr>
                                                <?php foreach ($groupedStudents[$sex] as $student): 
                                                    $studentNumber = $student->StudentNumber;
                                                    $status = $existing[$studentNumber]['status'] ?? '';
                                                    $remarks = $existing[$studentNumber]['remarks'] ?? '';
                                                ?>
                                                    <tr>
                                                        <td><?= $student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName; ?></td>
                                                        <td><?= $student->YearLevel; ?></td>
                                                        <td><?= $student->Section; ?></td>
                                                        <td style="text-align: center;">
                                                           <div class="btn-group btn-group-toggle" data-toggle="buttons">
    <label class="btn btn-outline-success <?= ($status === 'Present') ? 'active' : '' ?>">
        <input type="radio" name="attendance[<?= $studentNumber ?>]" value="Present" autocomplete="off" <?= ($status === 'Present') ? 'checked' : '' ?> > Present
    </label>
    <label class="btn btn-outline-danger <?= ($status === 'Absent') ? 'active' : '' ?>">
        <input type="radio" name="attendance[<?= $studentNumber ?>]" value="Absent" autocomplete="off" <?= ($status === 'Absent') ? 'checked' : '' ?> > Absent
    </label>
    <label class="btn btn-outline-warning <?= ($status === 'Excused') ? 'active' : '' ?>">
        <input type="radio" name="attendance[<?= $studentNumber ?>]" value="Excused" autocomplete="off" <?= ($status === 'Excused') ? 'checked' : '' ?> > Excused
    </label>
</div>

                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control remarks-field"
                                                                name="remarks[<?= $studentNumber ?>]"
                                                                id="remarks-<?= $studentNumber ?>"
                                                                placeholder="Enter remarks"
                                                                value="<?= $remarks ?>"
                                                                style="<?= ($status === 'Excused') ? '' : 'display:none;' ?>">
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <div class="text-right">
                                   <input type="submit" name="submit_attendance" value="Save Attendance" class="btn btn-success" />

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
</div>

<!-- Scripts -->

<script>
function toggleRemarks(studentNumber, show) {
    const field = document.getElementById('remarks-' + studentNumber);
    if (field) field.style.display = show ? 'block' : 'none';
}

// Auto-toggle on load if "Excused" is preselected
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type=radio]').forEach(radio => {
        radio.addEventListener('change', function() {
            const studentNumber = this.name.match(/\[(.*?)\]/)[1];
            const show = this.value === 'Excused';
            toggleRemarks(studentNumber, show);
        });

        $(function () {
    $('.btn-group-toggle .btn input[type=radio]').on('change', function () {
        const studentNumber = $(this).attr('name').match(/\[(.*?)\]/)[1];
        const isExcused = $(this).val() === 'Excused';
        $('#remarks-' + studentNumber).toggle(isExcused);
    });
});
        if (radio.checked && radio.value === 'Excused') {
            const studentNumber = radio.name.match(/\[(.*?)\]/)[1];
            toggleRemarks(studentNumber, true);
        }
    });
});
</script>

<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
