<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar --> <!-- ========== Left Sidebar Start ========== -->

        <!-- Lef Side bar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">
                                    <!-- Add Requirement Button -->
                                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addRequirementModal">
                                        <i class="fa fa-plus"></i> Add Requirement
                                    </button>
                                </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- end page title -->
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body table-responsive">
                                    <!--<h4 class="m-t-0 header-title mb-4"><b>REQUEST SUBMISSION</b></h4>-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3 class="mb-4">Requirement Lists</h3>

                                            <?php if ($this->session->flashdata('success')) : ?>

                                                <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>'
                                                    . $this->session->flashdata('success') .
                                                    '</div>';
                                                ?>
                                            <?php endif; ?>

                                            <?php if ($this->session->flashdata('danger')) : ?>
                                                <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>'
                                                    . $this->session->flashdata('danger') .
                                                    '</div>';
                                                ?>
                                            <?php endif;  ?>

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped align-middle">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>Document</th>
                                                            <th>Description</th>
                                                            <th style="text-align: center;">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($req as $item): ?>
                                                            <tr>
                                                                <td><?= $item->name ?></td>
                                                                <td><?= $item->description ?></td>
                                                                <td style="text-align: center;">
                                                                    <!-- Edit Button triggers modal -->
                                                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal<?= $item->id ?>">
                                                                        <i class="fa fa-edit"></i> Edit
                                                                    </button>

                                                                    <!-- Delete Button -->
                                                                    <a href="<?= base_url('Page/deleteRequirement/' . $item->id); ?>"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="return confirm('Are you sure you want to delete this requirement?');">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </a>
                                                                </td>
                                                            </tr>

                                                            <!-- Edit Modal -->
                                                            <div class="modal fade" id="editModal<?= $item->id ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $item->id ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <form action="<?= base_url('Page/updateRequirement') ?>" method="post">
                                                                        <input type="hidden" name="id" value="<?= $item->id ?>">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editModalLabel<?= $item->id ?>">Edit Requirement</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="name<?= $item->id ?>">Document Name</label>
                                                                                    <input type="text" class="form-control" name="name" value="<?= $item->name ?>" required>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="description<?= $item->id ?>">Description</label>
                                                                                    <textarea class="form-control" name="description" rows="3" required><?= $item->description ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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

                            </div>
                        </div>
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

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

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


    <!-- Add Requirement Modal -->
    <div class="modal fade" id="addRequirementModal" tabindex="-1" role="dialog" aria-labelledby="addRequirementModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="<?= base_url('Page/addRequirement') ?>" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRequirementModalLabel">Add Requirement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reqName">Name</label>
                            <input type="text" name="name" id="reqName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="reqDesc">Description</label>
                            <textarea name="description" id="reqDesc" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



</body>

</html>