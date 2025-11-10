<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->

        <!-- Left Sidebar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- Start Page Content -->
        <div class="content-page">
            <div class="content">

                <!-- Start Content -->
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Form to filter by enrollment year -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h3 class="mb-4">Not Enrolled List</h3>

                                    <!-- Form to submit enrollment filters -->
                                    <form name="enrollment-form" action="" method="post">
                                        <div class="form-inline">
                                            <!-- Enrolled During -->
                                            <div class="form-group mb-2">
                                                <label for="enrolled_during" class="mr-2">Was Enrolled During: </label>
                                                <input type="text" id="enrolled_during" name="enrolled_during" class="form-control" required placeholder="e.g. 2023-2024" style="width: 200px; height: 40px;">
                                            </div>

                                            <!-- But Not During -->
                                            <div class="form-group mb-2 ml-3">
                                                <label for="not_during" class="mr-2">But Not During:</label>
                                                <input type="text" id="not_during" name="not_during" class="form-control" required placeholder="e.g. 2024-2025" style="width: 200px; height: 40px;">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="form-group mb-2 ml-3">
                                                <button class="btn btn-info" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Display the results -->
                                    <h4>Students Enrolled in <?= $this->input->post('enrolled_during'); ?> but Not in <?= $this->input->post('not_during'); ?></h4>

                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Student Number</th>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>School Year</th>
                                                <th>YearLevel</th>
                                                <th>Section</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($students)): ?>
                                                <?php
                                                // Initialize an array to count the students per grade level
                                                $gradeLevelCounts = [];
                                                ?>
                                                <?php foreach ($students as $student): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($student->StudentNumber); ?></td>
                                                        <td><?= htmlspecialchars($student->LastName); ?></td>
                                                        <td><?= htmlspecialchars($student->FirstName); ?></td>
                                                        <td><?= htmlspecialchars($student->MiddleName); ?></td>
                                                        <td><?= htmlspecialchars($student->SY); ?></td>
                                                        <td><?= htmlspecialchars($student->YearLevel); ?></td>
                                                        <td><?= htmlspecialchars($student->Section); ?></td>
                                                    </tr>
                                                    <?php
                                                    // Count the students per grade level
                                                    if (isset($gradeLevelCounts[$student->YearLevel])) {
                                                        $gradeLevelCounts[$student->YearLevel]++;
                                                    } else {
                                                        $gradeLevelCounts[$student->YearLevel] = 1;
                                                    }
                                                    ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7">No matching students found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>

                                    <!-- Summary of student counts per grade level -->
                                    <h5 class="mt-5">Summary by Grade Level:</h5>
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Grade Level</th>
                                                <th>Number of Students</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Safely handle undefined or empty arrays
                                            if (!empty($gradeLevelCounts) && is_array($gradeLevelCounts)) {
                                                // Sort the grade levels numerically
                                                ksort($gradeLevelCounts);
                                                foreach ($gradeLevelCounts as $gradeLevel => $count): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($gradeLevel); ?></td>
                                                        <td><?= $count; ?></td>
                                                    </tr>
                                            <?php endforeach;
                                            }
                                            // If empty, output nothing (no error, no row)
                                            ?>
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer Start -->
        <?php include('includes/footer.php'); ?>
        <!-- end Footer -->

    </div>
    <!-- End Page content -->

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

</body>

</html>