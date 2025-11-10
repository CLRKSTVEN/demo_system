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
                                    <h4 class="page-title">FTE Records</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></b></a></li>
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
						
						 <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
										<form method="GET" class="form-inline"> 							               
										    <div class="form-group">
											   <select class="form-control" name="course" id="course" data-toggle="select2">
												<option>Select Course</option>
												<?php
											foreach ($course as $row) {
												echo '<option value="' . $row->CourseDescription . '">' . $row->CourseDescription . '</option>';
											}
											?>
												</optgroup>
											</select>
											 <select class="form-control" name="yearlevel" id="course" data-toggle="select2">
												<option>Select Year Level</option>
												<option value="1st">1st</option>
												<option value="2nd">2nd</option>
												<option value="3rd">3rd</option>
												<option value="4th">4th</option>
											</select>
											</div>
											
											<button type="submit" name="submit" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</div>
						</div>
								
								
                        <!-- end page title -->
						<div class="row">
						 <?php
							if(isset($_GET["submit"])) {
							?>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <h4 class="m-t-0 header-title mb-4"><b>FTE Records</b></h4>
											<table>
											<tr>
												<td>Course</td><td>: <b><?php echo $_GET['course']; ?></b></td>
											</tr>
											<tr>
												<td>Curriculur Year</td><td>: <b><?php echo $this->session->userdata('semester');?>, SY <?php echo $this->session->userdata('sy');?></b></td>
											</tr>
											<tr>
												<td>Year Level</td><td>: <b><?php echo $data[0]->YearLevel; ?></b></td>
											</tr>
											</table>
											<table class="table">
											<thead>
                                            <tr>
												<th>STUDENT NAME</th>
												<th style="text-align:center">LEC UNITS</th>
												<th style="text-align:center">LAB UNITS</th>
											</tr>
                                        </thead>
                                        <tbody>
										

										<?php
										  $i=1;
										  foreach($data as $row)
										  {
										  echo "<tr>";
										  echo "<td>".$row->LastName.', '.$row->FirstName.' '.$row->MiddleName."</td>";
										  echo "<td style='text-align:center'>".$row->LecUnit."</td>";
										  echo "<td style='text-align:center'>".$row->LabUnit."</td>";

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
							<?php } ?>
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