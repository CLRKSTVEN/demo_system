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
								<!-- <h4 class="page-title">Learners With Special Needs</h4> -->
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
							<div class="card card-success">
								<div class="card-header">
									<h5 class="card-title">LEARNERS WITH SPECIAL NEEDS <br />
										<span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
									</h5>
								</div>


								<table class="table table-bordered mt-3">
									<thead class="thead-dark">
										<tr>
											<th>#</th>
											<th>Student Number</th>
											<th>Full Name</th>
											<th>Year Level</th>
											<th>Section</th>
											<th>Special Needs</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($students)): ?>
											<?php $i = 1;
											foreach ($students as $s): ?>
												<tr>
													<td><?= $i++ ?></td>
													<td><?= $s->StudentNumber ?></td>
													<td><?= $s->LastName . ', ' . $s->FirstName . ' ' . $s->MiddleName ?></td>
													<td><?= $s->YearLevel ?></td>
													<td><?= $s->Section ?></td>
													<td><?= $s->specialneeds ?></td>
												</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr>
												<td colspan="5" class="text-center">No data found.</td>
											</tr>
										<?php endif; ?>
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