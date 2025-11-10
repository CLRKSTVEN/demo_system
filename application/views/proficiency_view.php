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


</head>

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
									<?php $this->load->view('includes/header'); ?>
									<div class="container mt-4">
										<h3 class="mb-3">Learning Proficiency Tracker</h3>

										<div class="alert alert-info">
											<strong>Student:</strong> <?= $student ?><br>
											<strong>School Year:</strong> <?= $this->session->userdata('sy') ?>
										</div>

										<?php foreach ($subjects as $subject): ?>
											<div class="card mb-4">
												<div class="card-header bg-primary text-white">
													<?= $subject->Description ?> (<?= $subject->SubjectCode ?>)
												</div>
												<div class="card-body">

													<form action="<?= base_url('Proficiency/save') ?>" method="post" class="mb-3">
														<input type="hidden" name="StudentNumber" value="<?= $student ?>">
														<input type="hidden" name="SubjectCode" value="<?= $subject->SubjectCode ?>">

														<div class="row">
															<div class="col-md-2">
																<label>Quarter</label>
																<select name="Quarter" class="form-control" required>
																	<option value="">Select</option>
																	<option value="1">1st</option>
																	<option value="2">2nd</option>
																	<option value="3">3rd</option>
																	<option value="4">4th</option>
																</select>
															</div>

															<div class="col-md-2">
																<label>Score</label>
																<input type="number" name="Score" step="0.01" class="form-control" required>
															</div>

															<div class="col-md-4">
																<label>Proficiency Level</label>
																<select name="ProficiencyLevel" class="form-control" required>
																	<option value="">Select</option>
																	<option>Beginning</option>
																	<option>Developing</option>
																	<option>Approaching Proficiency</option>
																	<option>Proficient</option>
																	<option>Advanced</option>
																</select>
															</div>

															<div class="col-md-4">
																<label>Remarks</label>
																<input type="text" name="Remarks" class="form-control">
															</div>
														</div>

														<div class="text-right mt-2">
															<button type="submit" class="btn btn-success">
																<i class="bi bi-save"></i> Save Record
															</button>
														</div>
													</form>

													<?php
													$sub_records = array_filter($records, function ($r) use ($subject) {
														return $r->SubjectCode == $subject->SubjectCode;
													});
													?>

													<?php if (!empty($sub_records)): ?>
														<h6>Recorded Proficiency</h6>
														<table class="table table-bordered table-sm">
															<thead class="thead-light">
																<tr>
																	<th>Quarter</th>
																	<th>Score</th>
																	<th>Proficiency Level</th>
																	<th>Remarks</th>
																	<th>Date Recorded</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($sub_records as $rec): ?>
																	<tr>
																		<td><?= $rec->Quarter ?></td>
																		<td><?= $rec->Score ?></td>
																		<td><?= $rec->ProficiencyLevel ?></td>
																		<td><?= $rec->Remarks ?></td>
																		<td><?= date('M d, Y', strtotime($rec->DateRecorded)) ?></td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													<?php else: ?>
														<div class="text-muted">No records yet for this subject.</div>
													<?php endif; ?>
												</div>
											</div>
										<?php endforeach; ?>
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