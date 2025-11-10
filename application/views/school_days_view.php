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
                                <h4 class="page-title">Manage Days of School</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item">
                                            <a href="#">
                                                <span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></span>
                                            </a>
                                        </li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $this->session->flashdata('msg'); ?>
                            <div class="card">
                                <div class="card-body">

                                    <form method="post" action="<?= base_url('SchoolDays/insert') ?>">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <input type="text" name="SY" class="form-control" value="<?= $this->session->userdata('sy'); ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="month" class="form-control" required>
                                                    <?php 
                                                    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                                    foreach ($months as $m): ?>
                                                        <option value="<?= $m ?>"><?= $m ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="year" class="form-control" required>
                                                    <?php
                                                    $currentYear = date('Y');
                                                    for ($y = $currentYear - 5; $y <= $currentYear + 5; $y++): ?>
                                                        <option value="<?= $y ?>"><?= $y ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="days_count" class="form-control" placeholder="Days Count" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-success">Add</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>SY</th>
                                                    <th>Month</th>
                                                    <th>Year</th>
                                                    <th>Days</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $d): ?>
                                                    <tr>
                                                        <form method="post" action="<?= base_url('SchoolDays/update/'.$d->id) ?>">
                                                            <td><input type="text" name="SY" class="form-control" value="<?= $d->SY ?>" required></td>
                                                            <td>
                                                                <select name="month" class="form-control" required>
                                                                    <?php foreach ($months as $m): ?>
                                                                        <option value="<?= $m ?>" <?= $d->month == $m ? 'selected' : '' ?>><?= $m ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="year" class="form-control" required>
                                                                    <?php
                                                                    for ($y = $currentYear - 5; $y <= $currentYear + 5; $y++): ?>
                                                                        <option value="<?= $y ?>" <?= $d->year == $y ? 'selected' : '' ?>><?= $y ?></option>
                                                                    <?php endfor; ?>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="days_count" class="form-control" value="<?= $d->days_count ?>" required></td>
                                                            <td>
                                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                                <a href="<?= base_url('SchoolDays/delete/'.$d->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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

        <!-- Scripts -->
        <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    </body>
</html>
