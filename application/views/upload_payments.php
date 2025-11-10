<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>
	<div id="wrapper">
		<?php include('includes/top-nav-bar.php'); ?>
		<?php include('includes/sidebar.php'); ?>

		<div class="content-page">
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">
							<div class="page-title-box">
								<h4 class="page-title">Upload Proof of Payment</h4>
								<div class="page-title-right">
									<ol class="breadcrumb p-0 m-0"></ol>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Upload form -->
						<div class="col-md-6">
							<div class="card card-info">
								<?php echo $this->session->flashdata('msg'); ?>
								<div class="card-body">
									<form action="<?= base_url('OnlinePayment/uploadPayments'); ?>" class="form-horizontal" enctype="multipart/form-data" method="POST">
										<!-- required table fields -->
										<input type="hidden" name="StudentNumber" value="<?= $this->session->userdata('username'); ?>" required>
										<input type="hidden" name="status" value="For Verification">
										<!-- optional but in table -->
										<?php if ($this->session->userdata('email')): ?>
											<input type="hidden" name="email" value="<?= $this->session->userdata('email'); ?>">
										<?php endif; ?>

										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Proof (Attachment)</label>
											<div class="col-sm-8">
												<input type="file" class="form-control" name="depositAttachment" accept=".jpg,.jpeg,.png,.pdf" required>
												<small class="text-muted">Allowed: JPG/PNG/PDF</small>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Amount</label>
											<div class="col-sm-8">
												<input type="number" class="form-control"
													name="amount" step="0.01" min="0" required
													onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46">

											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Payment For</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="description" placeholder="e.g. Tuition Fee" required>
											</div>
										</div>

										<!-- <div class="form-group row">
											<label class="col-sm-4 col-form-label">Semester</label>
											<div class="col-sm-8">
												<select name="sem" class="form-control" required>
													<option value="<?= $this->session->userdata('semester'); ?>">
														<?= $this->session->userdata('semester'); ?>
													</option>
												</select>
											</div>
										</div> -->

										<div class="form-group row">
											<label class="col-sm-4 col-form-label">School Year</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="sy" value="<?= $this->session->userdata('sy'); ?>" readonly required>
											</div>
										</div>

										<button type="submit" name="submit" class="btn btn-info float-right">Upload</button>
									</form>
								</div>
							</div>
						</div>

						<!-- Summary table -->
						<div class="col-md-6">
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">Summary of All Payments Made Online</h3>
								</div>
								<div class="table-responsive">
									<table class="table mb-0">
										<thead>
											<tr>
												<th>Payment For</th>
												<th>Amount</th>
												<th>Sem / SY</th>
												<th>Status</th>
												<th>Attachment</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($data1 as $row): ?>
												<tr>
													<td><?= htmlspecialchars($row->description); ?></td>
													<td><?= number_format((float)$row->amount, 2); ?></td>
													<td><?= htmlspecialchars($row->sem . ' ' . $row->sy); ?></td>
													<td><?= htmlspecialchars($row->status); ?></td>
													<td>
														<?php if (!empty($row->depositAttachment)): ?>
															<a href="<?= base_url('upload/payments/' . $row->depositAttachment); ?>" target="_blank" class="btn btn-success btn-xs">View</a>
														<?php endif; ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
								<div class="p-2 text-muted small">
									<?php /* optionally show created_at */ ?>
								</div>
							</div>
						</div>
					</div> <!-- /row -->
				</div> <!-- /container-fluid -->
			</div> <!-- /content -->
			<?php include('includes/footer.php'); ?>
		</div> <!-- /content-page -->
	</div> <!-- /wrapper -->

	<?php include('includes/themecustomizer.php'); ?>

	<script src="<?= base_url('assets/js/vendor.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/app.min.js'); ?>"></script>
</body>

</html>