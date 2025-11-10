<!-- Adviser View -->
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
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title-box d-flex justify-content-between">
                            <h4 class="page-title">Sections / Advisers</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Add New</button>
                        </div>
                        <span class="badge badge-purple mb-3">SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?></span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Year Level</th>
                                        <th>Section</th>
                                        <th>Adviser</th>
                                        <th style="text-align:center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $row): ?>
                                    <tr>
                                        <td><?= $row->YearLevel; ?></td>
                                        <td><?= $row->Section; ?></td>
                                        <td><?= $row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName; ?></td>
                                        <td style="text-align:center">
                                            <button class="btn btn-sm btn-primary" onclick="editProgram('<?= $row->sectionID; ?>', '<?= $row->IDNumber; ?>', '<?= $row->Section; ?>')" data-toggle="modal" data-target="#editModal">
                                                <i class="mdi mdi-pencil"></i> Edit
                                            </button>
                                            <a href="#" onclick="setDeleteUrl('<?= base_url('Settings/Deleteadviser?sectionID=' . $row->sectionID); ?>')" data-toggle="modal" data-target="#confirmationModal" class="btn btn-sm btn-danger">
                                                <i class="mdi mdi-delete"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Modal -->
                <div class="modal fade bs-example-modal-lg">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="post" action="<?= base_url('Settings/SectionAdviser'); ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Adviser</h5>
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                            <label>Year Level</label>
                                            <select name="YearLevel" class="form-control select2">
                                                <?php foreach ($Major as $level): ?>
                                                    <option value="<?= $level->Major; ?>"><?= $level->Major; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Section</label>
                                            <input type="text" name="Section" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Adviser</label>
                                            <select name="IDNumber" class="form-control select2">
                                                <option value="">Select Adviser</option>
                                                <?php foreach ($staff as $level): ?>
                                                    <option value="<?= $level->IDNumber; ?>"><?= $level->FirstName . ' ' . $level->MiddleName . ' ' . $level->LastName; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" name="save" value="Save Data" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="post" action="<?= base_url('Settings/updateAdviser'); ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Adviser</h5>
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="sectionID" id="sectionID">
                                    <div class="form-group">
                                        <label>Section</label>
                                        <input type="text" name="Section" id="Section" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Adviser</label>
                                        <select name="IDNumber" id="IDNumber" class="form-control select2">
                                            <option value="">Select Adviser</option>
                                            <?php foreach ($staff as $level): ?>
                                                <option value="<?= $level->IDNumber; ?>"><?= $level->FirstName . ' ' . $level->MiddleName . ' ' . $level->LastName; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" name="update" value="Update Data" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation -->
                <div class="modal fade" id="confirmationModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Confirm Delete</h5></div>
                            <div class="modal-body">
                                Are you sure you want to delete this record?
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a id="deleteButton" href="#" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scripts -->
                <script>
                    function editProgram(sectionID, IDNumber, section) {
                        $('#sectionID').val(sectionID);
                        $('#Section').val(section);
                        $('#IDNumber').val(IDNumber).trigger('change');
                    }

                    function setDeleteUrl(url) {
                        document.getElementById('deleteButton').href = url;
                    }

                    $(document).ready(function() {
                        $('.select2').select2();
                    });
                </script>

            </div>
        </div>
    </div>
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
		       <!-- Select2 JS -->
               <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

<!-- App js -->
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<!-- Initialize Select2 -->
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
		
    </body>
</html>