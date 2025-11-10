<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>
    <div id="wrapper">

        <!-- Topbar -->
        <?php include('includes/top-nav-bar.php'); ?>

        <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>

        <!-- Content Page -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Title and SY -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4 class="mt-2"><?= $title; ?></h4>
                            <span class="badge badge-info">SY <?= $sy ?> <?= $sem ?></span>
                        </div>
                    </div>

                    <!-- Student Table -->
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Student No.</th>
                                        <th>LRN</th>
                                        <th>Section</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($students as $row): ?>
                                        <tr>
                                            <td class="text-center"><?= $i++; ?></td>
                                            <td><?= strtoupper($row->LastName); ?></td>
                                            <td><?= strtoupper($row->FirstName); ?></td>
                                            <td><?= strtoupper($row->MiddleName); ?></td>
                                            <td><?= $row->StudentNumber; ?></td>
                                            <td><?= $row->LRN; ?></td>
                                            <td><?= $row->Section; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <!-- Back Button -->
                            <!-- <a href="<?= base_url('Page/masterlistByCourseFiltered?course=' . urlencode($course)); ?>" class="btn btn-secondary mt-3">
                                ← Back to Course Summary
                            </a> -->
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <?php include('includes/footer.php'); ?>
        </div>

    </div>

    <!-- Theme Customizer -->
    <?php include('includes/themecustomizer.php'); ?>

    <!-- Scripts -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
