<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">

                <!-- Start Content -->
                <div class="container-fluid">
                    <!-- Start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- End page title -->
                    <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <!-- <div class="panel-heading">
                                                    <h4>Invoice</h4>
                                                </div> -->
                                    <div class="card-body">
                                        <div class="clearfix">
                    <!-- Table Section -->
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Settings ID</th>
                                <th>School Name</th>
                                <th>School Address</th>
                                <th>School Head</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $row->settingsID; ?></td>
                                    <td><?= $row->SchoolName; ?></td>
                                    <td><?= $row->SchoolAddress; ?></td>
                                    <td><?= $row->SchoolHead; ?></td>
                                    <td style="text-align: center;">
                                    <a href="<?= base_url('Page/updateSuperAdmin?settingsID=' . $row->settingsID); ?>" 
                                    class="btn btn-primary waves-effect waves-light btn-sm"><i class="mdi mdi-pencil"></i>Edit</a>
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
                </div>
                <!-- End container-fluid -->

            </div>
            <!-- End content -->

            <!-- Footer Start -->
            <?php include('includes/footer.php'); ?>
            <!-- End Footer -->

        </div>
        <!-- End content-page -->

    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <?php include('includes/themecustomizer.php'); ?>
    <!-- /Right-bar -->

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- Datatables js -->
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

</body>

</html>