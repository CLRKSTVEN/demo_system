<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    /* Styling for the tables */
    .separated-table {
        margin-bottom: 30px;
        /* Adds space between tables */
        border-collapse: separate;
        /* Ensures borders are spaced out */
        border-spacing: 0 15px;
        /* Adds space between rows */
    }

    .separated-table th,
    .separated-table td {
        padding: 10px;
        border: 1px solid #ddd;
        /* Adds border around each cell */
    }

    .separated-table th {
        background-color: #f2f2f2;
        /* Adds background color for headers */
    }

    .table-section {
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ccc;
    }

    h4 {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
        /* Adds a separator under headings */
    }
</style>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->

        <!-- Lef Side bar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Collection Report Section -->
                    <div class="row table-section">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                   <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">Add Description</button>

                                       <h4>Manage Service Descriptions</h4>

                                        <span class="badge badge-purple mb-3"><b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></span>
                                    </h4>

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap separated-table">
                                        <thead>
                                               <tr>
                <th>Description</th>
                <th width="100">Actions</th>
            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($descriptions as $desc): ?>
                <tr>
                    <td><?= $desc->description; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $desc->id; ?>">Edit</button>
                        <a href="<?= base_url('Accounting/deleteDescription/' . $desc->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this item?');">Delete</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?= $desc->id; ?>" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <form method="post" action="<?= base_url('Accounting/updateDescription'); ?>">
                      <input type="hidden" name="id" value="<?= $desc->id; ?>">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Description</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <input type="text" name="description" class="form-control" value="<?= $desc->description; ?>" required>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Save</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

             <!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('Accounting/addDescription'); ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Description</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="text" name="description" class="form-control" placeholder="Enter new description" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>
    </form>
  </div>
</div>

                  

                </div>
                <!-- end container-fluid -->

            </div>
            <!-- end content -->

            <!-- Footer Start -->
            <?php include('includes/footer.php'); ?>
            <!-- end Footer -->

        </div>

    </div>
    <!-- END wrapper -->


    <!-- Right Sidebar -->
    <?php include('includes/themecustomizer.php'); ?>
    <!-- /Right-bar -->


    <!-- Vendor js -->
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

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

</body>

</html>