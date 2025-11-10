<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>SRMS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="Responsive bootstrap 4 admin template" name="description" />
	<meta content="Coderthemes" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">

	<!-- Plugins css-->
	<link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

	<!-- App css -->
	<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
	<link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
	<link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />


	<script type="text/javascript">
		function submitBday() {

			var Bdate = document.getElementById('bday').value;
			var Bday = +new Date(Bdate);
			Q4A = ~~((Date.now() - Bday) / (31557600000));
			var theBday = document.getElementById('resultBday');
			theBday.value = Q4A;
		}
	</script>

</head>

<body>

<?php
	if (!isset($provinces)) {
		$CI =& get_instance();
		$CI->load->model('StudentModel');
		$provinces = $CI->StudentModel->get_provinces();
	}
?>`r`n`r`n<!-- Begin page -->
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
								<!-- <h4 class="page-title">Update Student's Profile</h4> -->
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
							<?php echo $this->session->flashdata('msg'); ?>
							<div class="card">
								<div class="card-body table-responsive">
									<h4 class="m-t-0 header-title mb-4"><b>Update Student's Profile</b></h4>


									<form role="form" method="post" enctype="multipart/form-data" class="parsley-examples">
										<?php foreach ($data as $student) { ?>
											<!-- general form elements -->
											<div class="card-body">
												<div class="row">
													<h5>Personal Information</h5>
												</div>
												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<label for="lastName">Student No. <span style="color:red">*</span></label>
															<input type="text" class="form-control" name="StudentNumber" required readonly value='<?= $student->StudentNumber; ?>'>
															<input type="hidden" class="form-control" name="OldStudentNumber" required value='<?= $student->StudentNumber; ?>'>
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label for="lastName">LRN</label>
															<input type="text" class="form-control" name="LRN" value='<?= $student->LRN; ?>'>
														</div>
													</div>

												</div>
												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<label>First Name <span style="color:red">*</span></label>
															<input type="text" class="form-control" name="FirstName" value="<?= $student->FirstName; ?>" required>
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label>Middle Name</label>
															<input type="text" class="form-control" name="MiddleName" value="<?= $student->MiddleName; ?>">
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label>Last Name <span style="color:red">*</span></label>
															<input type="text" class="form-control" name="LastName" value="<?= $student->LastName; ?>" required>
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label for="lastName">Name Extn.</label>
															<input type="text" class="form-control" name="nameExt" value="<?= $student->nameExt; ?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<label>Sex </label>
															<select name="Sex" class="form-control" required>
																<option value="Male" <?php echo $student->Sex === 'Male' ? 'selected' : ''; ?>>Male</option>
																<option value="Female" <?php echo $student->Sex === 'Female' ? 'selected' : ''; ?>>Female</option>
															</select>
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label>Civil Status</label>
															<select name="CivilStatus" class="form-control">
																<option value="Single" <?php echo $student->CivilStatus === 'Single' ? 'selected' : ''; ?>>Single</option>
																<option value="Married" <?php echo $student->CivilStatus === 'Married' ? 'selected' : ''; ?>>Married</option>
															</select>
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label>Citizenship</label>
															<input type="text" class="form-control" name="Citizenship" value="<?= $student->Citizenship; ?>">
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label>Blood Type</label>
															<?php
															$bloodTypes = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];
															$selectedBloodType = isset($student->BloodType) ? $student->BloodType : "";
															?>

															<select class="form-control" name="BloodType">
																<option value="">-- Select Blood Type --</option>
																<?php foreach ($bloodTypes as $type): ?>
																	<option value="<?= $type ?>" <?= ($selectedBloodType == $type) ? 'selected' : '' ?>><?= $type ?></option>
																<?php endforeach; ?>
															</select>

														</div>
													</div>
												</div>
												<div class="row">



													<div class="col-lg-8">
														<div class="form-group">
															<label>Birth Place</label>
															<input type="text" class="form-control" name="BirthPlace" value="<?= $student->BirthPlace; ?>">
														</div>
													</div>

													<div class="col-lg-3">
														<div class="form-group">
															<label>Birth Date </label>
															<input type="date" name="BirthDate" class="form-control" id="bday" onchange="submitBday()" value='<?= $student->BirthDate; ?>'>
														</div>
													</div>
													<div class="col-lg-1">
														<div class="form-group">
															<label>Age</label>
															<input type="text" name="Age" id="resultBday" class="form-control" readonly value="<?= $student->Age; ?>" />
														</div>
													</div>

												</div>







												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<label>Ethnicity</label>
															<select class="form-control" name="Ethnicity">
																<option disabled selected>Select Ethnicity</option>
																<?php foreach ($ethnicity as $row) { ?>
																	<option value="<?= $row->ethnicity; ?>"
																		<?php echo ($student->Ethnicity == $row->ethnicity) ? 'selected' : ''; ?>>
																		<?= $row->ethnicity; ?>
																	</option>
																<?php } ?>
															</select>



														</div>
													</div>



													<div class="col-lg-3">
														<div class="form-group">
															<label>Religion</label>
															<select class="form-control" name="Religion">
																<option disabled selected>Select Religion</option>
																<?php foreach ($religion as $row) { ?>
																	<option value="<?= $row->religion; ?>"
																		<?php echo ($student->Religion == $row->religion) ? 'selected' : ''; ?>>
																		<?= $row->religion; ?>
																	</option>
																<?php } ?>
															</select>

														</div>
													</div>



													<div class="col-lg-6">
														<div class="form-group">
															<label>Last School Attended</label>
															<select class="form-control" name="Elementary">
																<option disabled selected>Select Last School Attended</option>
																<?php foreach ($prevschool as $row) { ?>
																	<option value="<?= $row->School; ?>"
																		<?php echo ($student->Elementary == $row->School) ? 'selected' : ''; ?>>
																		<?= $row->School; ?>
																	</option>
																<?php } ?>
															</select>


														</div>
													</div>





												</div>




												<div class="row">
													<h5>Contact Information</h5>
												</div>
												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<label>Telephone No.</label>
															<input type="text" class="form-control" name="TelNumber" value="<?= $student->TelNumber; ?>">
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label>Mobile No.</label>
															<input type="text" class="form-control" name="MobileNumber" value="<?= $student->MobileNumber; ?>">
														</div>
													</div>
													<div class="col-lg-6">
														<div class="form-group">
															<label>E-mail </label>
															<input type="email" class="form-control" name="EmailAddress" value="<?= $student->EmailAddress; ?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-3">
														<div class="form-group">
															<label>Present Address</label>
															<select id="province" name="Province" class="form-control">
																<option value="<?= $student->Province; ?>"><?= $student->Province; ?></option>
																<?php foreach ($provinces as $province): ?>
																	<option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
																<?php endforeach; ?>

															</select>
														</div>
													</div>

													<div class="col-lg-3">
														<div class="form-group">
															<label for="city">City/Municipality</label>
															<select id="city" name="City" class="form-control" disabled>
																<option value="<?= $student->City; ?>"><?= $student->City; ?></option>
															</select>
														</div>
													</div>

													<div class="col-lg-3">
														<div class="form-group">
															<label for="barangay">Barangay</label>
															<select id="barangay" name="Brgy" class="form-control" disabled>
																<option value="<?= $student->Brgy; ?>"><?= $student->Brgy; ?></option>
															</select>
														</div>
													</div>
													<div class="col-lg-3">
														<div class="form-group">
															<label><span class="text-muted">_</span></label>
															<input type="text" class="form-control" name="Sitio" placeholder="Street/Sub" value="<?= $student->Sitio; ?>">
														</div>
													</div>



												</div>
												<div class="row">
													<h5>Parents/Guardian Information</h5>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="form-group">
															<label>Guardian</label>
															<input type="text" class="form-control" name="Guardian" value="<?= $student->Guardian; ?>">
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Relationship to Guardian </label>
															<input type="text" class="form-control" name="GuardianRelationship" value="<?= $student->GuardianRelationship; ?>">
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Guardian Address </label>
															<input type="text" class="form-control" name="GuardianAddress" value="<?= $student->GuardianAddress; ?>">
														</div>
													</div>

												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="form-group">
															<label>Guardian Contact No.</label>
															<input type="text" class="form-control" name="GuardianContact" value="<?= $student->GuardianContact; ?>">
														</div>
													</div>

													<div class="col-lg-4">
														<div class="form-group">
															<label>Guardian Tel. No.</label>
															<input type="text" class="form-control" name="GuardianTelNo" value="<?= $student->GuardianTelNo; ?>">
														</div>
													</div>

													<div class="col-lg-4">
														<div class="form-group">
															<label>Guardian Occupation</label>
															<input type="text" class="form-control" name="guardianOccupation" value="<?= $student->guardianOccupation; ?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="form-group">
															<label>Father's Name</label>
															<input type="text" class="form-control" name="Father" value="<?= $student->Father; ?>">
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Father's Occupation</label>
															<input type="text" class="form-control" name="FOccupation" value="<?= $student->FOccupation; ?>">
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Mobile No.</label>
															<input type="text" class="form-control" name="FMobileNo" value="<?= $student->fContactNo; ?>">
														</div>
													</div>


												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="form-group">
															<label>Mother</label>
															<input type="text" class="form-control" name="Mother" value="<?= $student->Mother; ?>">
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Mother's Occupation</label>
															<input type="text" class="form-control" name="MOccupation" value="<?= $student->MOccupation; ?>">
														</div>
													</div>
													<div class="col-lg-4">
														<div class="form-group">
															<label>Mobile No.</label>
															<input type="text" class="form-control" name="MMobileNo" value="<?= $student->mContactNo; ?>">
														</div>
													</div>

												</div>
												<div class="row">
													<div class="col-lg-8">
														<div class="form-group">
															<label>Parent's E-mail</label>
															<input type="email" class="form-control" name="p_email" value="<?= $student->p_email; ?>">
														</div>
													</div>

												</div>
												<div class="row">
													<div class="col-lg-2">
														<div class="form-group">
															<label>With Special Needs?</label><select class="form-control" name="with_specialneeds">
																<option value="<?= $student->with_specialneeds; ?>"><?= $student->with_specialneeds; ?></option>
																<option value="Yes">Yes</option>
																<option value="No">No</option>
															</select>
														</div>
													</div>
													<div class="col-lg-10">
														<div class="form-group">
															<label>Special Needs</label>
															<input type="text" class="form-control" name="specialneeds" value="<?= $student->specialneeds; ?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-12">
														<div class="form-group">
															<label>Notes</label>
															<textarea class="form-control" rows="5" id="example-textarea" name="Notes"><?= $student->Notes; ?></textarea>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<input type="submit" name="submit" class="btn btn-info" value="Update Profile">
													</div>
												</div>

											</div><!-- /.box -->

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


	<!-- Vendor js -->
	<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

	<!-- Plugin js-->
	<script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>

	<!-- Validation init js-->
	<script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>

	<!-- App js -->
	<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

	<!-- Select2 JS -->
	<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

	<!-- App js -->
	<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

	<!-- Initialize Select2 -->
	<script>
		$(document).ready(function() {
			// Enable Select2 if you're using it
			$('.select2').select2();

			var selectedProvince = "<?= $student->Province ?>";
			var selectedCity = "<?= $student->City ?>";
			var selectedBrgy = "<?= $student->Brgy ?>";

			// Load all provinces
			$.ajax({
				url: '<?php echo site_url('Page/get_provinces'); ?>',
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					$('#province').html('<option value="">Select Province</option>');
					$.each(data, function(index, province) {
						var selected = (province.id == selectedProvince) ? 'selected' : '';
						$('#province').append('<option value="' + province.id + '" ' + selected + '>' + province.name + '</option>');
					});

					// If province is already selected, load cities
					if (selectedProvince) {
						$('#city').prop('disabled', false);
						$.ajax({
							url: '<?php echo site_url('Page/get_cities'); ?>',
							type: 'POST',
							dataType: 'json',
							data: {
								province: selectedProvince
							},
							success: function(data) {
								$('#city').html('<option value="">Select City/Municipality</option>');
								$.each(data, function(index, city) {
									var selected = (city.id == selectedCity) ? 'selected' : '';
									$('#city').append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
								});

								// If city is already selected, load barangays
								if (selectedCity) {
									$('#barangay').prop('disabled', false);
									$.ajax({
										url: '<?php echo site_url('Page/get_barangays'); ?>',
										type: 'POST',
										dataType: 'json',
										data: {
											city: selectedCity
										},
										success: function(data) {
											$('#barangay').html('<option value="">Select Barangay</option>');
											$.each(data, function(index, barangay) {
												var selected = (barangay.id == selectedBrgy) ? 'selected' : '';
												$('#barangay').append('<option value="' + barangay.id + '" ' + selected + '>' + barangay.name + '</option>');
											});
										},
										error: function(xhr, status, error) {
											console.error("Barangay AJAX Error: ", status, error);
										}
									});
								}
							},
							error: function(xhr, status, error) {
								console.error("City AJAX Error: ", status, error);
							}
						});
					}
				},
				error: function(xhr, status, error) {
					console.error("Province AJAX Error: ", status, error);
				}
			});

			// Province on change
			$('#province').change(function() {
				var province = $(this).val();
				$('#city').prop('disabled', province == '');
				$('#barangay').prop('disabled', true).html('<option value="">Select Barangay</option>');

				if (province) {
					$.ajax({
						url: '<?php echo site_url('Page/get_cities'); ?>',
						type: 'POST',
						dataType: 'json',
						data: {
							province: province
						},
						success: function(data) {
							$('#city').html('<option value="">Select City/Municipality</option>');
							$.each(data, function(index, city) {
								$('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("City Load Error: ", status, error);
						}
					});
				}
			});

			// City on change
			$('#city').change(function() {
				var city = $(this).val();
				$('#barangay').prop('disabled', city == '');

				if (city) {
					$.ajax({
						url: '<?php echo site_url('Page/get_barangays'); ?>',
						type: 'POST',
						dataType: 'json',
						data: {
							city: city
						},
						success: function(data) {
							$('#barangay').html('<option value="">Select Barangay</option>');
							$.each(data, function(index, barangay) {
								$('#barangay').append('<option value="' + barangay.id + '">' + barangay.name + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("Barangay Load Error: ", status, error);
						}
					});
				}
			});
		});
	</script>



</body>

</html>

