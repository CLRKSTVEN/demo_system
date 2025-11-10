
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
                                    <h4 class="page-title">UPDATE CLASS PROGRAM</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span></b></a></li>
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
					 
                        <!-- end page title -->
						<div class="row">
                            <div class="col-md-12">
							<?php echo $this->session->flashdata('msg'); ?>
                                <div class="card">
                                    <div class="card-body table-responsive">
                                    <form role="form" method="post" enctype="multipart/form-data">
                                            <?php foreach ($data as $row) { ?>
                                                <div class="form-row align-items-center">
                                                    <input type="hidden" name="subjectid" value="<?php echo $row->subjectid; ?>" />
                                                    <input type="hidden" class="form-control" name="SY" value="<?php echo $row->SY; ?>">

                                                    <div class="col-md-2 mb-3">
                                                        <label for="YearLevel">Year Level</label>
                                                        <input type="text" class="form-control" id="YearLevel" name="YearLevel" readonly value="<?php echo $row->YearLevel; ?>">
                                                    </div>


                                                    <div class="col-md-6 mb-3">
                                            <label for="IDNumber">Teacher</label>
                                            <select name="IDNumber" id="IDNumber" class="form-control select2" required>
                                                <option value="">Select Teacher</option>
                                                <?php foreach ($staff as $level) { ?>
                                                    <option value="<?= $level->IDNumber; ?>" <?php echo ($row->IDNumber == $level->IDNumber) ? 'selected' : ''; ?>>
                                                        <?= $level->FirstName; ?> <?= $level->MiddleName; ?> <?= $level->LastName; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="Section">Section</label>
                                                        <input type="text" class="form-control" id="Section" name="Section" readonly value="<?php echo $row->Section; ?>" required>
                                                    </div>


                                                    <div class="col-md-2 mb-3">
                                                        <label for="SubjectCode">Course Code</label>
                                                        <input type="text" class="form-control" id="SubjectCode" name="SubjectCode" readonly value="<?php echo $row->SubjectCode; ?>" required>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <label for="Description">Description</label>
                                                        <input type="text" class="form-control" id="Description" name="Description" readonly value="<?php echo $row->Description; ?>" required>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="Semester">Schedule</label>
                                                        <input type="text" class="form-control" id="SchedTime" name="SchedTime" value="<?php echo $row->SchedTime; ?>">
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-row align-items-center">
                                                  
                                                   
                                                 
                                                </div>
                                                
                                                <!-- <div class="form-row align-items-center">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="Course">Course</label>
                                                        <input type="text" class="form-control" id="Course" name="Course" value="<?php echo $row->Course; ?>">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="YearLevel">Year Level</label>
                                                        <input type="text" class="form-control" id="YearLevel" name="YearLevel" value="<?php echo $row->YearLevel; ?>">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="SubjectStatus">Subject Status</label>
                                                        <select name="SubjectStatus" id="SubjectStatus" class="form-control">
                                                            <option value="Open" <?php echo ($row->SubjectStatus == 'Open') ? 'selected' : ''; ?>>Open</option>
                                                            <option value="Close" <?php echo ($row->SubjectStatus == 'Close') ? 'selected' : ''; ?>>Close</option>
                                                        </select>
                                                    </div>
                                                </div> -->

                                                <div class="modal-footer">
                                                    <input type="submit" name="update" value="Save Data" class="btn btn-primary waves-effect waves-light" />
                                                </div>
                                            <?php } ?>
                                        </form>
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

        <!-- Include the Select2 JS file at the bottom of your body -->
        <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2(); // Initialize Select2
    });
</script>
		
    </body>
</html>