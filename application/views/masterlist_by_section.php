<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>

	<!-- Begin page -->
	<div id="wrapper">

		<!-- Topbar Start -->
		<?php include('includes/top-nav-bar.php'); ?>
		<!-- end Topbar -->

		<!-- ========== Left Sidebar Start ========== -->
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
									MASTERLIST BY SECTION <br />
									<span class="badge badge-purple mb-3">SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?></span>
								</h4>
							</div>
						</div>
					</div>

					<!-- Form Filters -->
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">
									<form method="GET" class="form-inline">
										<div class="form-group">
											<select id="yearLevel" name="yearLevel" class="form-control" required>
												<option value="">Select Year Level</option>
												<?php foreach ($section as $row): ?>
													<option value="<?= $row->YearLevel; ?>"><?= $row->YearLevel; ?></option>
												<?php endforeach; ?>
											</select>&nbsp;

											<select id="section" name="section" class="form-control" required>
												<option value="">Select Section</option>
											</select>&nbsp;

											<input type="submit" name="submit" class="btn btn-info" value="Submit">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Results Table -->
					<div class="row">
						<?php if (isset($_GET["submit"])): ?>
							<div class="col-12">
								<div class="card">
									<div class="card-body">
										<div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-3">
											<div>
												<h4 class="header-title mb-2">
													<b><?= $_GET['yearLevel']; ?>: <?= $_GET['section']; ?></b><br />
													<span class="badge badge-primary">SY <?= $this->session->userdata('semester'); ?> <?= $this->session->userdata('sy'); ?></span>
												</h4>
											</div>
											<div class="mt-3 mt-md-0">
												<a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light">
													<i class="fa fa-print"></i> Print
												</a>
											</div>
										</div>

										<?= $this->session->flashdata('msg'); ?>

										<div class="table-responsive">
											<?php
											$is_shs = isset($_GET['submit']) && in_array($_GET['yearLevel'], ['Grade 11', 'Grade 12']);
											?>

											<table class="table table-bordered table-striped">
												<thead class="thead-light">
													<tr>
														<th>No.</th>
														<th>Last Name</th>
														<th>First Name</th>
														<th>Middle Name</th>
														<th>Student No.</th>
														<th>LRN</th>
														<th>Sex</th>
														<?php if ($is_shs): ?>
															<th>Track</th>
															<th>Strand</th>
														<?php endif; ?>

														<th>Adviser</th>
													</tr>
												</thead>

												<!-- Male Students -->
												<?php
												$male = array_filter($data, fn($row) => strtoupper($row->Sex) === 'MALE');
												$female = array_filter($data, fn($row) => strtoupper($row->Sex) === 'FEMALE');

												usort($male, fn($a, $b) => strcmp($a->LastName . $a->FirstName, $b->LastName . $b->FirstName));
												usort($female, fn($a, $b) => strcmp($a->LastName . $a->FirstName, $b->LastName . $b->FirstName));

												$i = 1;
												?>
												<tr class="bg-primary text-white text-center">
													<td colspan="10" class="font-weight-bold">MALE</td>
												</tr>
												<?php foreach ($male as $row): ?>
													<tr>
														<td><?= $i++; ?></td>
														<td><?= $row->LastName; ?></td>
														<td><?= $row->FirstName; ?></td>
														<td><?= $row->MiddleName; ?></td>
														<td><?= $row->StudentNumber; ?></td>
														<td><?= $row->LRN; ?></td>
														<td><?= $row->Sex; ?></td>
														<?php if ($is_shs): ?>
															<td><?= $row->Track ?? ''; ?></td>
															<td><?= $row->Qualification ?? ''; ?></td>
														<?php endif; ?>


														<td><?= $row->Adviser; ?></td>
													</tr>
												<?php endforeach; ?>

												<!-- Female Students -->
												<tr class="bg-pink text-white text-center">
													<td colspan="10" class="font-weight-bold">FEMALE</td>
												</tr>
												<?php foreach ($female as $row): ?>
													<tr>
														<td><?= $i++; ?></td>
														<td><?= $row->LastName; ?></td>
														<td><?= $row->FirstName; ?></td>
														<td><?= $row->MiddleName; ?></td>
														<td><?= $row->StudentNumber; ?></td>
														<td><?= $row->LRN; ?></td>
														<td><?= $row->Sex; ?></td>
														<?php if ($is_shs): ?>
															<td><?= $row->Track ?? ''; ?></td>
															<td><?= $row->Qualification ?? ''; ?></td>
														<?php endif; ?>


														<td><?= $row->Adviser; ?></td>
													</tr>
												<?php endforeach; ?>

											</table>
										</div>

									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>

				</div> <!-- container-fluid -->
			</div> <!-- content -->

			<!-- Footer Start -->
			<?php include('includes/footer.php'); ?>
			<!-- end Footer -->
		</div>

	</div> <!-- END wrapper -->

	<!-- Right Sidebar -->
	<?php include('includes/themecustomizer.php'); ?>

	<!-- Vendor JS -->
	<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>
	<script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>
	<script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>
	<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

	<!-- Datatable JS -->
	<script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
	<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

	<!-- Dynamic Section Loader -->
	<script>
		$(document).ready(function() {
			$('#yearLevel').change(function() {
				var yearLevel = $(this).val();
				if (yearLevel) {
					$.ajax({
						url: '<?= base_url("Masterlist/getSectionsByYearLevel"); ?>',
						type: 'GET',
						data: {
							yearLevel: yearLevel
						},
						dataType: 'json',
						success: function(data) {
							$('#section').empty().append('<option value="">Select Section</option>');
							$.each(data, function(index, value) {
								$('#section').append('<option value="' + value.Section + '">' + value.Section + '</option>');
							});
						}
					});
				} else {
					$('#section').empty().append('<option value="">Select Section</option>');
				}
			});
		});
	</script>


</body>

</html>