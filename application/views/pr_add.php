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
                                <!-- <h4 class="page-title">Purchase Request</h4> -->
                                <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#addModal">
                                    + Add New
                                </button>

                                <?php if ($this->session->userdata('level') === 'BAC') : ?>


                                    <a href="<?= base_url(); ?>BAC/printPR?actID=<?php echo $actID; ?>" target="_blank">
                                        <div class="btn btn-outline-primary ms-2">
                                            <i data-feather="printer"></i> Print PR
                                        </div>
                                    </a>

                                    <a href="<?= base_url(); ?>BAC/printPR?actID=<?php echo $actID; ?>" target="_blank">
                                        <div class="btn btn-outline-primary ms-2">
                                            <i data-feather="printer"></i> Print PR
                                        </div>
                                    </a>
                                <?php endif; ?>

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
                                    <h6>Purchase Request</h6>
                                    <?php
                                    $CI = &get_instance();
                                    $act_title = $CI->input->get('act_title') ?? '';
                                    ?>
                                    <h3><?php echo htmlspecialchars($act_title, ENT_QUOTES, 'UTF-8'); ?></h3>


                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Lot</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Qty</th>
                                                <th>Estimated Cost</th>
                                                <th>Total Amount</th>
                                                <th style="text-align: center;">Manage</th>
                                            </tr>
                                        </thead>
                                        <?php $grand_total = 0; // initialize grand total 
                                        ?>
                                        <tbody>
                                            <?php if (!empty($pr)): ?>
                                                <?php foreach ($pr as $row): ?>
                                                    <?php
                                                    $qty = $row->qty ?? 0;
                                                    $est_cost = $row->est_cost ?? 0;
                                                    $total_amount = $qty * $est_cost;
                                                    $grand_total += $total_amount;
                                                    ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row->lot ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($row->item_description ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($row->unit ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($qty, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= number_format($est_cost, 2) ?></td>
                                                        <td><?= number_format($total_amount, 2) ?></td>
                                                        <td style="text-align: center;">
                                                            <button
                                                                class="btn btn-sm btn-primary edit-btn"
                                                                data-id="<?= $row->prID ?>"
                                                                data-lot="<?= htmlspecialchars($row->lot ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                                data-description="<?= htmlspecialchars($row->item_description ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                                data-unit="<?= htmlspecialchars($row->unit ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                                data-qty="<?= $qty ?>"
                                                                data-est="<?= $est_cost ?>">Edit</button>
                                                            <a href="<?= site_url('BAC/deletePR/' . $row->prID . '?actID=' . $actID) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7">No PR records found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-end" style="text-align:right;"><strong>Grand Total:</strong></td>
                                                <td><strong><?= number_format($grand_total, 2) ?></strong></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>

                                    </table>


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

    <!-- Add New Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="<?= site_url('BAC/PR?actID=' . $actID) ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New PR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>


                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="actID" value="<?= htmlspecialchars($actID ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="act_title" value="<?php echo htmlspecialchars($this->input->get('act_title'), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="save" value="1">

                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label>Lot</label>
                                <select name="lot" class="form-control">
                                    <option value=""></option>
                                    <option value="Lot 1">Lot 1</option>
                                    <option value="Lot 2">Lot 2</option>
                                    <option value="Lot 3">Lot 3</option>
                                    <option value="Lot 4">Lot 4</option>
                                    <option value="Lot 5">Lot 5</option>
                                    <option value="Lot 6">Lot 6</option>
                                    <option value="Lot 7">Lot 7</option>
                                    <option value="Lot 8">Lot 8</option>
                                </select>

                            </div>
                            <div class="col-md-8 mb-2">
                                <label>Description</label>
                                <input type="text" name="item_description" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label>Unit</label>
                                <input type="text" name="unit" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Qty</label>
                                <input type="number" name="qty" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Estimated Cost</label>
                                <input type="number" name="est_cost" class="form-control" step="0.01" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="<?= site_url('BAC/updatePR') ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit PR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="prID" id="edit-prID">
                        <input type="hidden" name="actID" value="<?= htmlspecialchars($actID ?? '', ENT_QUOTES, 'UTF-8') ?>">

                        <div class="mb-2">
                            <label>Lot</label>
                            <input type="text" name="lot" id="edit-lot" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Description</label>
                            <input type="text" name="item_description" id="edit-description" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Unit</label>
                            <input type="text" name="unit" id="edit-unit" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Qty</label>
                            <input type="number" name="qty" id="edit-qty" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Estimated Cost</label>
                            <input type="number" name="est_cost" id="edit-est" class="form-control" step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('edit-prID').value = this.dataset.id;
                    document.getElementById('edit-lot').value = this.dataset.lot;
                    document.getElementById('edit-description').value = this.dataset.description;
                    document.getElementById('edit-unit').value = this.dataset.unit;
                    document.getElementById('edit-qty').value = this.dataset.qty;
                    document.getElementById('edit-est').value = this.dataset.est;
                    new bootstrap.Modal(document.getElementById('editModal')).show();
                });
            });
        });
    </script>



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