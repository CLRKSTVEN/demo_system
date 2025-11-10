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

            <!-- Page Title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
                            Enrollment Form <br />
                            <span class="badge badge-purple mb-3">
                                SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?>
                            </span>
                        </h4>
                        <?= $this->session->flashdata('msg'); ?>
                        <div class="clearfix"></div>
                        <hr class="border-top border-primary" style="border-width: 3px;" />
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="card-body">

                                <!-- Student Info -->
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Student No. <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" name="StudentNumber" value="<?= $_GET['id']; ?>" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>First Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" name="FName" value="<?= $_GET['FName']; ?>" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input type="text" class="form-control" name="MName" value="<?= $_GET['MName']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Last Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" name="LName" value="<?= $_GET['LName']; ?>" readonly required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enrollment Info -->
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Department <span style="color:red">*</span></label>
                                            <select name="Course" id="course" class="form-control" required>
                                                <option value="<?= $_GET['Course']; ?>"><?= $_GET['Course']; ?></option>
                                                <?php foreach ($course as $row): ?>
                                                    <option value="<?= $row->CourseDescription; ?>"><?= $row->CourseDescription; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Grade Level <span style="color:red">*</span></label>
                                            <select name="YearLevel" id="yearlevel" class="form-control" required>
                                                <option value="<?= $_GET['YearLevel']; ?>"><?= $_GET['YearLevel']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Section <span style="color:red">*</span></label>
                                            <select name="Section" id="section" class="form-control" required>
                                                <option value="">Select Section</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="hidden" name="IDNumber" id="AdviserID" class="form-control" readonly>
                                        <label>Adviser</label>
                                        <input type="text" name="Adviser" id="AdviserName" class="form-control" readonly>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Strand</label>
                                            <select name="Qualification" id="strand" class="form-control">
                                                <option value="<?= $_GET['strand']; ?>"><?= $_GET['strand']; ?></option>
                                                <?php foreach ($track as $s): ?>
                                                    <option value="<?= $s->strand; ?>"><?= $s->strand; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Other Details -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Balik Aral? <span style="color:red">*</span></label>
                                            <select name="BalikAral" class="form-control" required>
                                                <option value="No Data">No Data</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Indigenous People Member? <span style="color:red">*</span></label>
                                            <select name="IP" class="form-control" required>
                                                <option value="No Data">No Data</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>4Ps Beneficiary?</label>
                                            <select name="FourPs" class="form-control" required>
                                                <option value="No Data">No Data</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Repeater? <span style="color:red">*</span></label>
                                            <select name="Repeater" class="form-control" required>
                                                <option value="No Data">No Data</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Transferee? <span style="color:red">*</span></label>
                                            <select name="Transferee" class="form-control" required>
                                                <option value="No Data">No Data</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>School Year <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" value="<?= $this->session->userdata('sy'); ?>" readonly name="SY" required />
                                        </div>
                                    </div>
                                </div>

                                <!-- Enrollment Status -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Status <span style="color:red">*</span></label>
                                            <select name="Status" class="form-control" required>
                                                <option value="">Select</option>
                                                <option>Old</option>
                                                <option>New</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="submit" name="submit" class="btn btn-info" value="Process Enrollment">
                                    </div>
                                </div>

                            </div> <!-- /.card-body -->
                        </form>
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->

        </div> <!-- /.container-fluid -->
    </div> <!-- /.content -->
</div> <!-- /.content-page -->




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
	<script type="text/javascript">
		$(document).ready(function() {
			$('#course').change(function() {
				var course = $('#course').val();
				if (course != '') {
					$.ajax({
						url: "<?php echo base_url(); ?>page/fetch_yearlevel",
						method: "POST",
						data: {
							course: course
						},
						success: function(data) {
							$('#yearlevel').html(data);
						}
					})
				}
			});
		});
		$(document).ready(function() {
			$('#track').change(function() {
				var track = $('#track').val();
				if (track != '') {
					$.ajax({
						url: "<?php echo base_url(); ?>Settings/fetchStrand",
						method: "POST",
						data: {
							track: track
						},
						success: function(data) {
							$('#strand').html(data);
						}
					})
				}
			});
		});
	</script>
<script type="text/javascript">
$(document).ready(function () {
    var yearlevel = "<?php echo $_GET['YearLevel']; ?>";
    var course = "<?php echo $_GET['Course']; ?>";

    // Load Section options based on yearlevel
    if (yearlevel !== '') {
        $.ajax({
            url: "<?php echo base_url(); ?>page/fetch_section",
            method: "POST",
            data: { yearlevel: yearlevel },
            success: function (data) {
                $('#section').html('<option value="">Select Section</option>' + data);
            }
        });
    }

    // When a section is selected, fetch adviser info
    $('#section').change(function () {
        var section = $(this).val();

        if (section !== '') {
            // Fetch Adviser ID
            $.ajax({
                url: "<?php echo base_url(); ?>page/fetch_adviser_id",
                method: "POST",
                data: { section: section, yearlevel: yearlevel },
                success: function (data) {
                    $('#AdviserID').val(data.trim());
                }
            });

            // Fetch Adviser Name
            $.ajax({
                url: "<?php echo base_url(); ?>page/fetch_adviser_name",
                method: "POST",
                data: { section: section, yearlevel: yearlevel },
                success: function (data) {
                    $('#AdviserName').val(data.trim());
                }
            });
        } else {
            $('#AdviserID').val('');
            $('#AdviserName').val('');
        }
    });
});
</script>

</body>

</html>