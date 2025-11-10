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

	<!-- third party css -->
	<link href="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url(); ?>assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
								<!-- <h4 class="page-title">Personnel Profile Update Form</h4> -->
								<div class="page-title-right">
									<ol class="breadcrumb p-0 m-0">
										<li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li>
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
									<!-- <h4 class="m-t-0 header-title mb-4"><b>Heading Here</b></h4>-->
									<form role="form" method="post" enctype="multipart/form-data">
										<!-- general form elements -->
										<div class="card-body">
											<div class="row">
												<h5>Personal Information</h5>
											</div>
											<div class="row">
												<div class="col-lg-3">
													<input type="hidden" class="form-control" name="OldIDNumber" value="<?php echo $data->IDNumber; ?>" required readonly>
													<div class="form-group">
														<label for="lastName">Employee No. </label>
														<input type="text" class="form-control" name="IDNumber" value="<?php echo $data->IDNumber; ?>" required>
													</div>
												</div>
												<!-- <div class="col-lg-3">
												<div class="form-group">
													<label for="lastName">Prefix </label>
													<select name="prefix" class="form-control">
														<option><?php echo $data->prefix; ?></option>
														<option>Mr.</option>
														<option>Ms.</option>
														<option>Mrs.</option>
													</select>
												</div>	
										</div>											 -->
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="form-group">
														<label>First Name </label>
														<input type="text" class="form-control" name="FirstName" value="<?php echo $data->FirstName; ?>" required>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Middle Name</label>
														<input type="text" class="form-control" name="MiddleName" value="<?php echo $data->MiddleName; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Last Name </label>
														<input type="text" class="form-control" name="LastName" value="<?php echo $data->LastName; ?>" required>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label for="lastName">Name Extn.</label>
														<input type="text" class="form-control" name="NameExtn" value="<?php echo $data->NameExtn; ?>">
													</div>
												</div>
											</div>

											<div class="row">

												<div class="col-lg-3">
													<div class="form-group">
														<label>Sex </label>
														<select name="Sex" class="form-control">
															<option value="<?php echo $data->Sex; ?>"><?php echo $data->Sex; ?></option>
															<option value="Female">Female</option>
															<option value="Male">Male</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Birth Date </label>
														<input type="date" name="BirthDate" class="form-control" id="bday" value="<?php echo $data->BirthDate; ?>" onchange="submitBday()" required>
													</div>
												</div>

												<div class="col-lg-6">
													<div class="form-group">
														<label>Birth Place</label>
														<input type="text" class="form-control" name="BirthPlace" value="<?php echo $data->BirthPlace; ?>">
													</div>
												</div>

											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="form-group">
														<label>Civil Status </label>
														<select name="MaritalStatus" class="form-control">
															<option><?php echo $data->MaritalStatus; ?></option>
															<option value="Single">Single</option>
															<option value="Married">Married</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Height</label>
														<input type="text" class="form-control" name="height" value="<?php echo $data->height; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Weight</label>
														<input type="text" class="form-control" name="weight" value="<?php echo $data->weight; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Blood Type</label>
														<input type="text" class="form-control" name="bloodType" value="<?php echo $data->bloodType; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<!-- <div class="col-lg-3">
											<div class="form-group">
											<label>Telephone No.</label>
											 <input type="text" class="form-control" name="empTelNo" value="<?php echo $data->empTelNo; ?>" >
											</div>
										</div> -->
												<div class="col-lg-3">
													<div class="form-group">
														<label>Mobile No.</label>
														<input type="text" class="form-control" name="empMobile" value="<?php echo $data->empMobile; ?>">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label>E-mail</label>
														<input type="email" class="form-control" name="empEmail" value="<?php echo $data->empEmail; ?>">
													</div>
												</div>
											</div>

											<div class="row">
												<h5>Official Information</h5>
												<hr />
											</div>
											<div class="row">
												<div class="col-lg-6">
													<div class="form-group">
														<label>Current Position</label>
														<input type="text" class="form-control" name="empPosition" value="<?php echo $data->empPosition; ?>">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label>Department</label>
														<input type="text" class="form-control" name="Department" value="<?php echo $data->Department; ?>">
													</div>
												</div>

											</div>
											<div class="row">

												<div class="col-lg-3">
													<div class="form-group">
														<label>Employment Status</label>
														<input type="text" class="form-control" name="empStatus" value="<?php echo $data->empStatus; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Date Hired</label>
														<input type="date" class="form-control" name="dateHired" value="<?php echo $data->dateHired; ?>">
													</div>
												</div>

												<div class="col-lg-3">
													<div class="form-group">
														<label>PhilHeatlth No.</label>
														<input type="text" class="form-control" name="philHealth" value="<?php echo $data->philHealth; ?>">
													</div>
												</div>

												<div class="col-lg-3">
													<div class="form-group">
														<label>TIN</label>
														<input type="text" class="form-control" name="tinNo" value="<?php echo $data->tinNo; ?>">
													</div>
												</div>

											</div>
											<div class="row">
												<div class="col-lg-3">
													<div class="form-group">
														<label>GSIS</label>
														<input type="text" class="form-control" name="gsis" value="<?php echo $data->gsis; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>PAGIBIG</label>
														<input type="text" class="form-control" name="pagibig" value="<?php echo $data->pagibig; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>SSS No.</label>
														<input type="text" class="form-control" name="sssNo" value="<?php echo $data->sssNo; ?>">
													</div>
												</div>

											</div>


											<div class="row">
												<h5>Personnel Address</h5>
											</div>
											<div class="row">
												<div class="col-lg-3">
													<div class="form-group">
														<label>House No.</label>
														<input type="text" class="form-control" name="resHouseNo" value="<?php echo $data->resHouseNo; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Street</label>
														<input type="text" class="form-control" name="resStreet" value="<?php echo $data->resStreet; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Village</label>
														<input type="text" class="form-control" name="resVillage" value="<?php echo $data->resVillage; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Barangay</label>
														<input type="text" class="form-control" name="resBarangay" value="<?php echo $data->resBarangay; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-3">
													<div class="form-group">
														<label>Zip Code</label>
														<input type="text" class="form-control" name="resZipCode" value="<?php echo $data->resZipCode; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>City</label>
														<input type="text" class="form-control" name="resCity" value="<?php echo $data->resCity; ?>">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label>Province</label>
														<input type="text" class="form-control" name="resProvince" value="<?php echo $data->resProvince; ?>">
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

	<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

	<!-- Sweet alert init js-->
	<script src="<?= base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
</body>

</html>