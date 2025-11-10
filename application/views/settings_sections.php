<!DOCTYPE html>
<html lang="en">
    <head>
    <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    </head>

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

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title-box">
                            <h4 class="page-title">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addNewModal" style="float: right;">Add New</button>
                            </h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb p-0 m-0">
                                    <li class="breadcrumb-item">
                                        <a href="#"></a>
                                    </li>
                                </ol>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <!-- start row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left">
                                        <h5 style="text-transform:uppercase">
                                            <strong>SECTIONS</strong>
                                            <br /><span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span>
                                        </h5>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Year Level</th>
                                                    <th>Section</th>
                                                    <th>Adviser</th>
                                                    <th style="text-align:center">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?= $row->YearLevel; ?></td>
                                                    <td><?= $row->Section; ?></td>
                                                    <td><?= $row->FirstName; ?> <?= $row->MiddleName; ?> <?= $row->LastName; ?></td>
                                                    <td style="text-align:center">
                                                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm" onclick="editProgram('<?= $row->sectionID; ?>', '<?= $row->Section; ?>')" data-toggle="modal" data-target="#editModal">
                                                            <i class="mdi mdi-pencil"></i>Edit
                                                        </button>

                                                        <a href="#" onclick="setDeleteUrl('<?= base_url('Settings/DeleteSections?sectionID=' . $row->sectionID); ?>')" data-toggle="modal" data-target="#confirmationModal" class="btn btn-danger waves-effect waves-light btn-sm">
                                                            <i class="ion ion-ios-alert"></i> Delete
                                                        </a>
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

                <!-- Update Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Update Section</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url('Settings/updateSection'); ?>">
                                    <input type="hidden" name="sectionID" id="sectionID">
                                    <input type="hidden" id="SY" name="SY" class="form-control" value="<?php echo $this->session->userdata('sy'); ?>" required />
                                    <div class="form-row align-items-center">
                                        <div class="col-md-12 mb-3">
                                            <label for="Section">Section</label>
                                            <input type="text" class="form-control" id="editSection" name="Section" required>
                                        </div>
                                    </div>

                                    <div class="form-row align-items-center">
                                    <div class="col-md-12 mb-3">
    <label for="IDNumber">Adviser</label>
    <select name="IDNumber" id="IDNumber" class="form-control select2">
        <option value="">Select Adviser</option>
        <?php foreach ($advisers as $adviser) { ?>
            <option value="<?= $adviser->IDNumber; ?>" <?= (isset($data->IDNumber) && $data->IDNumber == $adviser->IDNumber) ? 'selected' : ''; ?>>
                <?= $adviser->FirstName; ?> <?= $adviser->MiddleName; ?> <?= $adviser->LastName; ?>
            </option>
        <?php } ?>
    </select>  
</div>

                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" name="update" value="Update Data" class="btn btn-primary waves-effect waves-light" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function editProgram(sectionID, Section, IDNumber) {
                        document.getElementById('sectionID').value = sectionID;
                        document.getElementById('editSection').value = Section;
                        document.getElementById('IDNumber').value = IDNumber;


                    }
                </script>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Delete Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <div class="circle-with-stroke d-inline-flex justify-content-center align-items-center">
                                        <span class="h1 text-danger">!</span>
                                    </div>
                                    <p class="mt-3">Are you sure you want to delete this data?</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="#" id="deleteButton" class="btn btn-danger" onclick="deleteData()">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .circle-with-stroke {
                        width: 100px;
                        height: 100px;
                        border: 4px solid #dc3545;
                        border-radius: 50%;
                    }
                </style>

                <script>
                    function setDeleteUrl(url) {
                        document.getElementById('deleteButton').href = url;
                    }

                    function deleteData() {
                        // This will now correctly delete the selected item
                    }
                </script>

                <!-- Add New Modal -->
                <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addNewModalLabel">Add New</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url('Settings/Sections'); ?>">
                                    <input type="hidden" name="SY" class="form-control" value="<?php echo $this->session->userdata('sy'); ?>" readonly required />
                                    
                                    <div class="form-row align-items-center">
                                        <div class="col-md-3 mb-3">
                                            <label for="Section">Section</label>
                                            <input type="text" class="form-control" id="newSection" name="Section" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="IDNumber">Adviser</label>
                                            <select name="IDNumber" id="IDNumber" class="form-control select2">
                                                <option value="">Select Adviser</option>
                                                <?php foreach ($staff as $level) { ?>
                                                    <option value="<?= $level->IDNumber; ?>"><?=$level->FirstName; ?> <?=$level->MiddleName; ?> <?=$level->LastName; ?></option>
                                                <?php } ?>
                                            </select>  
                                         </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="YearLevel">Year Level</label>
                                            <input type="text" class="form-control" id="YearLevel" name="YearLevel" required>
                                        </div>
                                        <!-- <div class="col-md-2 mb-3">
                                            <label for="Sem">Semester</label>
                                            <input type="text" class="form-control" id="Sem" name="Sem" required>
                                        </div> -->
                                    </div>
                                   
                                    <div class="modal-footer">
                                        <input type="submit" name="save" value="Save Data" class="btn btn-primary waves-effect waves-light" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- container-fluid -->

        </div>
        <!-- content -->
    </div>
</div>

                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
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