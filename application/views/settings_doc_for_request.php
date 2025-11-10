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
								<h4 class="page-title">

									<!-- <a href="#">
										<button type="button" class="btn btn-info waves-effect waves-light"> <i class="fas fa-plus-square mr-1"></i> <span>Add New</span> </button>

									</a> -->

									<a href="#" data-toggle="modal" data-target="#addDoc" class="btn btn-primary w-lg" data-backdrop="static" data-keyboard="false">Add New</a>
								</h4>
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

							<?php if ($this->session->flashdata('success')) : ?>

								<?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>'
									. $this->session->flashdata('success') .
									'</div>';
								?>
							<?php endif; ?>

							<?php if ($this->session->flashdata('danger')) : ?>
								<?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>'
									. $this->session->flashdata('danger') .
									'</div>';
								?>
							<?php endif;  ?>

							<div class="card">
								<div class="card-body table-responsive">
									<h4 class="m-t-0 header-title mb-4"><b>List of Documents Available for Request</b></h4>

									<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										<thead>
											<tr>
												<th style="text-align: center;">Document Name</th>
												<th style="text-align: center;">Manage</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$i = 1;
											foreach ($data as $row) {
												echo "<tr>";
												echo "<td>" . $row->docName . "</td>";

											?>
												<td style="text-align:center">
													<a href="<?= base_url(); ?>Settings/del?id=<?= $row->id; ?>" class="text-danger"><i class=" mdi mdi-xbox-controller-view"></i> Delete</button></a>

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


<div class="modal fade" id="addDoc" tabindex="-1" role="dialog" aria-labelledby="forgotModalLabel" style="color:black">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="forgotModalLabel">Add New</h4>
			</div>
			<div class="modal-body">

				<form id="updateRequest" enctype='multipart/form-data' method="post">

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label class="text-muted">Document (e.g. Certification, Report Card, etc...) <span style="color:red">*</span></label>
								<input type="text" name="docName" id="reqStatus" class="form-control" required>
							</div>
						</div>
					</div>


					<div class="row">
						<div class="col-12">
							<input type="submit" name="submit" class="btn btn-info float-md-right" value="Submit">
						</div>
						<!-- /.col -->
					</div>
				</form>

			</div>

		</div>
	</div>
</div>


</html>