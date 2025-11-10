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
		<?php $stud = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $data[0]->StudentNumber); ?>

		<div class="content-page">
			<div class="content">

				<!-- Start Content-->
				<div class="container-fluid">

					<!-- start page title -->
					<div class="row">

						<div class="col-md-12">
							<div class="page-title-box">
								<h4 class="page-title">ENROLLMENT FORM UPDATE <br />
									<span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
								</h4>
								<?php echo $this->session->flashdata('msg'); ?>
								<div class="page-title-right">
									<ol class="breadcrumb p-0 m-0">
										<!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
									</ol>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

					<!-- end page title -->
					<div class="row">
						<div class="col-md-12">
							<div class="card card-info">


								<form role="form" method="post" enctype="multipart/form-data">
									<!-- general form elements -->
									<div class="card-body">
										<div class="row">
											<input type="hidden" value="<?php echo $data[0]->semstudentid; ?>" name="semstudentid">
											<div class="col-lg-4">
												<div class="form-group">
													<label>Student No.</label>
													<input type="text" class="form-control" name="StudentNumber" value="<?php echo $data[0]->StudentNumber; ?>" readonly required>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label>First Name</label>
													<input type="text" class="form-control" name="FName" value="<?= $stud->FirstName; ?>" readonly required>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Middle Name</label>
													<input type="text" class="form-control" name="MName" value="<?= $stud->MiddleName; ?>" readonly required>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Last Name</label>
													<input type="text" class="form-control" name="LName" value="<?= $stud->LastName; ?>" readonly required>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label>Department</label>
													<select name="Course" id="course" class="form-control" required>
														<option value="<?php echo $data[0]->Course; ?>"><?php echo $data[0]->Course; ?></option>
														<?php
														foreach ($course as $row) {
															echo '<option value="' . $row->CourseDescription . '">' . $row->CourseDescription . '</option>';
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Grade Level</label>
													<select name="YearLevel" id="yearlevel" class="form-control" required>
														<option value="<?php echo $data[0]->YearLevel; ?>"><?php echo $data[0]->YearLevel; ?></option>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Section </label>
													<select name="Section" id="section" class="form-control" required>
														<option value="<?php echo $data[0]->Section; ?>"><?php echo $data[0]->Section; ?></option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-4">
												<input type="hidden" name="IDNumber" id="AdviserID" value="<?php echo $data[0]->IDNumber; ?>" class="form-control" readonly>
												<div class="form-group">
													<label>Adviser Name</label>
													<input type="text" name="Adviser" id="AdviserName" class="form-control" value="<?php echo $data[0]->Adviser; ?>" readonly>
												</div>

											</div>

											<div class="col-lg-2">
												<div class="form-group">
													<label>Status</label>
													<select name="StudeStatus" id="yearlevel" class="form-control" required>
														<option value="<?php echo $data[0]->StudeStatus; ?>"><?php echo $data[0]->StudeStatus; ?></option>
														<option>Old</option>
														<option>New</option>
													</select>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<label>Track</label>

													<select name="Track" id="track" class="form-control">
														<option value="<?php echo $data[0]->Track; ?>"><?php echo $data[0]->Track; ?></option>
														<?php
														foreach ($track as $row) {
														?>
															<option value="<?= $row->track; ?>"><?= $row->track; ?></option>
														<?php } ?>
													</select>

												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<label>Strand</label>
													<select name="Qualification" id="strand" class="form-control">
														<option value="<?php echo $data[0]->Qualification; ?>"><?php echo $data[0]->Qualification; ?></option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label>Balik Aral?</label>
													<select name="BalikAral" id="yearlevel" class="form-control" required>
														<option value="<?php echo $data[0]->BalikAral; ?>"><?php echo $data[0]->BalikAral; ?></option>
														<option value="No Data">No Data</option>
														<option value="Yes">Yes</option>
														<option value="No">No</option>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Indigenous People Member?</label>
													<select name="IP" id="yearlevel" class="form-control" required>
														<option value="<?php echo $data[0]->IP; ?>"><?php echo $data[0]->IP; ?></option>
														<option value="No Data">No Data</option>
														<option value="Yes">Yes</option>
														<option value="No">No</option>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>4Ps Benefeciary?</label>
													<select name="FourPs" id="yearlevel" class="form-control" required>
														<option value="<?php echo $data[0]->FourPs; ?>"><?php echo $data[0]->FourPs; ?></option>
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
													<label>Repeater?</label>
													<select name="Repeater" class="form-control" required>
														<option value="<?php echo $data[0]->Repeater; ?>"><?php echo $data[0]->Repeater; ?></option>
														<option value="No Data">No Data</option>
														<option value="Yes">Yes</option>
														<option value="No">No</option>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Transferee?</label>
													<select name="Transferee" class="form-control" required>
														<option value="<?php echo $data[0]->Transferee; ?>"><?php echo $data[0]->Transferee; ?></option>
														<option value="No Data">No Data</option>
														<option value="Yes">Yes</option>
														<option value="No">No</option>
													</select>
												</div>
											</div>

											<!-- <div class="col-lg-2">
												<div class="form-group">
													<label>Semester</label>
													<select name="Semester" class="form-control">
														<option value="<?php echo $data[0]->Semester; ?>"><?php echo $data[0]->Semester; ?></option>
														<option value=""></option>
														<option value="1st Sem.">1st Sem.</option>
														<option value="2nd Sem.">2nd Sem.</option>
														<option value="Summer">Summer</option>
													</select>
												</div>
										</div>	 -->
											<div class="col-lg-4">
												<div class="form-group">
													<label>School Year</label>
													<input type="text" class="form-control" value="<?php echo $this->session->userdata('sy'); ?>" readonly name="SY" required />
												</div>
											</div>
										</div>

										<!-- <p style="color:green"><b>Note:  Leave the Semester empty for Elementary and Junior High School.  The SY is required and it depends on the options you chose from the login form.</b></p> -->
										<div class="row">
											<div class="col-lg-12">
												<input type="submit" name="submit" class="btn btn-info" value="Update Enrollment"> </span>
											</div>
										</div>
									</div>
							</div><!-- /.box -->
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
					});
				}
			});

			$('#yearlevel').change(function() {
				var yearlevel = $('#yearlevel').val();
				if (yearlevel != '') {
					$.ajax({
						url: "<?php echo base_url(); ?>page/fetch_section",
						method: "POST",
						data: {
							yearlevel: yearlevel
						},
						success: function(data) {
							$('#section').html(data);
						}
					});
				}
			});

			$(document).ready(function() {
				$('#section').change(function() {
					var section = $('#section').val();
					var yearlevel = $('#yearlevel').val(); // Get the selected year level

					if (section !== '' && yearlevel !== '') { // Ensure both values are present
						// Fetch Adviser ID
						$.ajax({
							url: "<?php echo base_url(); ?>page/fetch_adviser_id",
							method: "POST",
							data: {
								section: section,
								yearlevel: yearlevel
							}, // Send both params
							success: function(data) {
								console.log("Adviser ID Response:", data); // Debug log
								$('#AdviserID').val(data.trim()); // Populate Adviser ID
							}
						});

						// Fetch Adviser Name
						$.ajax({
							url: "<?php echo base_url(); ?>page/fetch_adviser_name",
							method: "POST",
							data: {
								section: section,
								yearlevel: yearlevel
							}, // Send both params
							success: function(data) {
								console.log("Adviser Name Response:", data); // Debug log
								$('#AdviserName').val(data.trim()); // Populate Adviser Name
							}
						});
					} else {
						$('#AdviserID').val(''); // Clear Adviser ID field
						$('#AdviserName').val(''); // Clear Adviser Name field
					}
				});
			});

			$('#track').change(function() {
				var track = $(this).val(); // Get the selected track value
				if (track != '') {
					// Clear the Strand dropdown
					$('#strand').html('<option value="">Select Strand</option>'); // Reset to default option

					$.ajax({
						url: "<?php echo base_url(); ?>Settings/fetchStrand", // Make sure this URL is correct
						method: "POST",
						data: {
							track: track
						},
						success: function(data) {
							$('#strand').html(data); // Populate strands based on the response
						},
						error: function() {
							// Handle any errors that occur during the AJAX request
							$('#strand').html('<option value="">Error loading strands</option>');
						}
					});
				} else {
					// Reset Strand dropdown if no Track is selected
					$('#strand').html('<option value="">Select Strand</option>');
				}
			});
		});
	</script>

</body>

</html>