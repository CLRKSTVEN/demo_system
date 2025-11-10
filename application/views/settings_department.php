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
								<h4 class="page-title">Courses</h4>
								<div class="page-title-right">
									<ol class="breadcrumb p-0 m-0">
										<li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li>
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

							<div class="card card-info">
								<div class="card-header">
									<h3 class="card-title"> Add Course </h3>
								</div>
								<!-- /.card-header -->
								<!-- form start -->
								<form class="form-horizontal" method="POST">
									<div class="card-body">
										<div class="form-group row">
											<label for="inputEmail3" class="col-md-4 col-form-label">Course Code</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="CourseCode" placeholder="BS IT" required>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputEmail3" class="col-md-4 col-form-label">Course</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="CourseDescription" placeholder="Bachelor of Science in Information Technology" required>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputEmail3" class="col-md-4 col-form-label">Major</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="Major" placeholder="">
											</div>
										</div>
										<div class="form-group row">
											<label for="inputEmail3" class="col-md-4 col-form-label">Duration</label>
											<div class="col-md-8">
												<select class="form-control" name="Duration">
													<option value=""></option>
													<option value="1 Year">1 Year</option>
													<option value="2 Years">2 Years</option>
													<option value="3 Years">3 Years</option>
													<option value="4 Years">4 Years</option>
													<option value="5 Years">5 Years</option>
												</select>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-12">
												<input type="submit" name="submit" class="btn btn-info float-right" value="Save">
											</div>
										</div>
									</div>
									<!-- /.card-body -->

									<!-- /.card-footer -->
								</form>

							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title"> Added Courses </h3>
								</div>


								<table class="table">

									<thead>
										<tr>
											<th>Course</th>
											<th>Major</th>
											<th style="text-align:center;">Action</th>
										</tr>
									</thead>
									<tbody>


										<?php
										$i = 1;
										foreach ($data as $row) {
											echo "<tr>";
											echo "<td>" . $row->CourseDescription . "</td>";
											echo "<td>" . $row->Major . "</td>";
										?>
											<td style="text-align:center;">
												<!--<a href=<?= base_url(); ?>page/studentsprofile><button type="button" class="btn btn-success btn-xs">Update</button></a>-->
												<a href="<?= base_url(); ?>Settings/deleteCourse?id=<?php echo $row->courseid; ?>"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
											</td>
										<?php
											echo "</tr>";
										}
										?>
									</tbody>

								</table>
							</div>
						</div>
					</div>
					<!-- /.row (main row) -->
				</div><!-- /.container-fluid -->
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