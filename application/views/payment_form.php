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
								<h4 class="page-title">Payment Form<br />
									<span class="badge badge-primary mb-3">SY <?php echo $this->session->userdata('sy'); ?></span>

								</h4>
								<?php echo $this->session->flashdata('msg'); ?>
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
							<div class="card card-info">



								<form role="form" method="post" enctype="multipart/form-data">

									<!-- general form elements -->
									<div class="card-body">

										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label for="lastName">Student No. <span style="color:red">*</span></label>
													<input type="text" class="form-control" name="StudentNumber" value="<?php echo $_GET['StudentNumber']; ?>" readonly required>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label>First Name <span style="color:red">*</span></label>
													<input type="text" class="form-control" name="FirstName" value="<?php echo $_GET['FirstName']; ?>" readonly required>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Middle Name</label>
													<input type="text" class="form-control" name="MiddleName" value="<?php echo $_GET['MiddleName']; ?>" readonly required>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Last Name <span style="color:red">*</span></label>
													<input type="text" class="form-control" name="LastName" value="<?php echo $_GET['LastName']; ?>" readonly required>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label>Grade Level <span style="color:red">*</span></label></label>

													<select name="YearLevel" class="form-control" required>
														<option value="">Select Grade Level</option>
														<option value="Grade 1">Grade 1</option>
														<option value="Grade 2">Grade 2</option>
														<option value="Grade 3">Grade 3</option>
														<option value="Grade 4">Grade 4</option>
														<option value="Grade 5">Grade 5</option>
														<option value="Grade 6">Grade 6</option>
														<option value="Grade 7">Grade 7</option>
														<option value="Grade 8">Grade 8</option>
														<option value="Grade 9">Grade 9</option>
														<option value="Grade 10">Grade 10</option>
														<option value="Grade 11">Grade 11</option>
														<option value="Grade 12">Grade 12</option>
													</select>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group">
													<label>Amount Paid <span style="color:red">*</span></label></label>
													<input type="text" class="form-control" name="Amount" value="<?php echo $_GET['Amount']; ?>" readonly required>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group">
													<label>Payment For <span style="color:red">*</span></label></label>
													<input type="text" class="form-control" name="description" value="<?php echo $_GET['description']; ?>" required>
												</div>
											</div>
										</div>

										<div class="row">

											<div class="col-lg-4">
												<div class="form-group">
													<label>O.R. No. <span style="color:red">*</span></label>
													<!--temporarily disabled due to some ORs has -A<input type="text" class="form-control" name="ORNumber" value="<?php echo $row->ORNumber + 1; ?>" required > -->
													<input type="text" class="form-control" name="ORNumber" value="" required>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group">
													<label>Payment Type <span style="color:red">*</span></label>
													<select name="PaymentType" class="form-control" required>
														<option value=""></option>
														<option value="Cash">Cash</option>
														<option value="Check">Check</option>
														<option value="Online - Bank Deposit">Online - Bank Deposit</option>
														<option value="Online - Mobile/Internet Banking">Online - Mobile/Internet Banking</option>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label>Bank/Payment Center<span style="color:red">*</span></label>
													<input type="text" class="form-control" name="Bank" value="" required>
												</div>
											</div>
										</div>

										<!-- Hidden Controls -->
										<input type="hidden" name="opID" value="<?php echo $_GET['opID']; ?>" required />
										<input type="hidden" class="form-control" name="Course" value="<?php echo $_GET['Course']; ?>" readonly required>
										<input type="hidden" class="form-control" name="SY" value="<?php echo $_GET['sy']; ?>" readonly required>

										<div class="row">
											<div class="col-lg-12">
												<input type="submit" name="submit" class="btn btn-info" value="Accept Payment">
											</div>
										</div>

									</div><!-- /.box -->

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


</body>

</html>