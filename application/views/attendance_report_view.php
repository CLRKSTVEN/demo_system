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
                    <!-- <a href="<?= base_url('Masterlist/sf2_report') ?>" target="_blank" class="btn btn-primary mb-3">
    <i class="fa fa-print"></i> Generate SF 2 (Printable)
</a> -->




                    <!-- Trigger Button -->
                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#sf2FilterModal">
                        <i class="fa fa-print"></i> Generate SF 2 (Printable)
                    </button>

                    <!-- Filter Modal -->
                    <div class="modal fade" id="sf2FilterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="<?= base_url('Masterlist/sf2_report') ?>" method="get" target="_blank">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Select Month and Year</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="month">Month</label>
                                            <select name="month" id="month" class="form-control" required>
                                                <?php foreach (range(1, 12) as $m): ?>
                                                    <option value="<?= $m ?>"><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="year">Year</label>
                                            <select name="year" id="year" class="form-control" required>
                                                <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                                    <option value="<?= $y ?>"><?= $y ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Generate Report</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <h3 class="mb-3">Advisory Attendance Report - SY <?= $sy ?></h3>

                    <?php
                    $groupedStudents = ['Male' => [], 'Female' => [], 'Unknown' => []];
                    foreach ($students as $student) {
                        $sex = ucfirst(trim(strtolower($student->Sex)));
                        $groupedStudents[$sex === 'Male' || $sex === 'Female' ? $sex : 'Unknown'][] = $student;
                    }

                    $chunks = $attendance['chunks'];
                    $records = $attendance['records'];
                    ?>

                    <?php foreach ($chunks as $i => $weekDates): ?>
                        <div class="card mb-3">
                            <div class="card-header" data-toggle="collapse" href="#week<?= $i ?>" style="cursor:pointer;">
                                <strong>Week <?= $i + 1 ?></strong> (<?= $weekDates[0] . ' to ' . end($weekDates) ?>)
                            </div>
                            <div class="collapse" id="week<?= $i ?>">
                                <div class="card-body table-responsive">
                                    <?php foreach (['Male', 'Female', 'Unknown'] as $sex): ?>
                                        <?php if (!empty($groupedStudents[$sex])): ?>
                                            <h5 class="mt-3"><?= strtoupper($sex) ?></h5>
                                            <table class="table table-bordered table-sm text-center">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th rowspan="2">Student Name</th>
                                                        <?php foreach ($weekDates as $date): ?>
                                                            <th colspan="2">
                                                                <?= date('l', strtotime($date)) ?><br>
                                                                <small><?= $date ?></small>
                                                            </th>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($weekDates as $_): ?>
                                                            <th>AM</th>
                                                            <th>PM</th>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($groupedStudents[$sex] as $student): ?>
                                                        <tr>
                                                            <td class="text-left">
                                                                <?= $student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName ?>
                                                            </td>
                                                            <?php foreach ($weekDates as $date): ?>
                                                                <?php
                                                                $am = $records[$student->StudentNumber][$date]['AM'] ?? '';
                                                                $pm = $records[$student->StudentNumber][$date]['PM'] ?? '';
                                                                ?>
                                                                <td>
                                                                    <?php if ($am === '1'): ?>
                                                                        <span class="text-success">✔</span>
                                                                    <?php elseif ($am === '0'): ?>
                                                                        <span class="text-danger">✘</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($pm === '1'): ?>
                                                                        <span class="text-success">✔</span>
                                                                    <?php elseif ($pm === '0'): ?>
                                                                        <span class="text-danger">✘</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            <?php endforeach; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>

                                            </table>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>

    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>

</html>