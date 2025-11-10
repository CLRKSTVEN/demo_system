
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
			Q4A= ~~ ((Date.now() - Bday) / (31557600000));
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
                                    <h4 class="page-title">Personnel Profile Form</h4>
                                   <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span></b></a></li>
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
												<div class="form-group">
													<label for="lastName">Employee No. <span style="color:red">*</span></label>
													<input type="text" class="form-control" name="IDNumber" required >
												</div>	
										</div>
										<div class="col-lg-3">
												<div class="form-group">
													<label for="lastName">Prefix <span style="color:red">*</span></label>
													<select name="prefix" class="form-control">
														<option>Mr.</option>
														<option>Ms.</option>
														<option>Mrs.</option>
													</select>
												</div>	
										</div>											
									</div>
									
									<div class="row">
										<div class="col-lg-3">
												<div class="form-group">
													<label>First Name <span style="color:red">*</span></label>
													<input type="text" class="form-control" name="FirstName" value="" required >
												</div>	
										</div>	
										<div class="col-lg-3">
											<div class="form-group">
											<label>Middle Name</label>
											 <input type="text" class="form-control" name="MiddleName" value="" >
											</div>
										</div>  
										<div class="col-lg-3">
											<div class="form-group">
											<label>Last Name <span style="color:red">*</span></label>
											 <input type="text" class="form-control" name="LastName" value="" required >
                                        </div>
										</div>
										<div class="col-lg-3">
												<div class="form-group">
													<label for="lastName">Name Extn.</label>
													<input type="text" class="form-control" name="NameExtn" >
												</div>	
										</div>	
									</div>	
									
									<div class="row">
										
										<div class="col-lg-3">
												<div class="form-group">
													<label>Sex <span style="color:red">*</span></label>
													<select name="Sex" class="form-control" required>
														<option value=""></option>
														<option value="Female">Female</option>
														<option value="Male">Male</option>
													</select>
												</div>
										</div> 
										<div class="col-lg-3">
											<div class="form-group">
											<label>Birth Date <span style="color:red">*</span></label>
											 <input type="date" name="BirthDate" class="form-control" id="bday" onchange="submitBday()" required >
											</div>
										</div>  
										<div class="col-lg-1">
											<div class="form-group">
											<label>Age </label>
											  <input type="text" name="age" id="resultBday" class="form-control" value="0" readonly>
											</div>
										</div>

										<div class="col-lg-5">
											<div class="form-group">
												<label>Birth Place</label>
													 <input type="text" class="form-control" name="BirthPlace" value="" >
											</div>
										</div>										
											
									</div>
									
									<div class="row">
									<div class="col-lg-3">
												<div class="form-group">
													<label>Civil Status <span style="color:red">*</span></label>
													 <select name="MaritalStatus" class="form-control" required>
													 <option value="Single">Single</option>
														<option value="Married">Married</option>
													</select>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<label>Height (in meter)</label>
													<input type="text" class="form-control" name="height" value="" >
												</div>
											</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Weight (in kg)</label>
											 <input type="text" class="form-control" name="weight" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Blood Type</label>
											 <input type="text" class="form-control" name="bloodType" value="" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
											<label>Telephone No.</label>
											 <input type="text" class="form-control" name="empTelNo" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Mobile No.</label>
											 <input type="text" class="form-control" name="empMobile" value="" >
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
											<label>E-mail <span style="color:red">*</span></label>
											 <input type="email" class="form-control" name="empEmail" value="" required >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
											<label>Facebook Link</label>
											 <input type="text" class="form-control" name="fb" value="" >
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
											<label>Skype</label>
											 <input type="text" class="form-control" name="skype" value="" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
											<label>Citizenship</label>
											 <input type="text" class="form-control" name="citizenship" value="Filipino" >
											</div>
										</div>
										<div class="col-lg-3">
												<div class="form-group">
													<label>Dual Citizen?</label>
													 <select class="form-control" name="dualCitizenship">
													 <option>Select</option>
														<option>No Data</option>
														<option>No</option>
														<option>Yes</option>
													 </select>
													 
												</div>
										</div>
										<div class="col-lg-3">
												<div class="form-group">
													<label>Citizen Type</label>
													 <select class="form-control" name="citizenshipType">
														<option></option>
														<option>By Birth</option>
														<option>By Naturalization</option>
													 </select>
													 
												</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Country</label>
											 <input type="text" class="form-control" name="citizenshipCountry" value="" >
											</div>
										</div>
									</div>
									
									<div class="row">
										<h5>Official Information</h5>	<hr />
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
											<label>Current Position</label>
											 <input type="text" class="form-control" name="empPosition" value="" >
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
											<label>Department</label>
											 <input type="text" class="form-control" name="Department" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Agency Code</label>
											 <input type="text" class="form-control" name="agencyCode" value="" >
											</div>
										</div>
									</div>
									<div class="row">
										
										<div class="col-lg-3">
											<div class="form-group">
											<label>Employment Status</label>
											 <input type="text" class="form-control" name="empStatus" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Date Hired</label>
											 <input type="date" class="form-control" name="dateHired" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Expected Retirement Year</label>
											 <input type="text" class="form-control" name="retYear" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>PhilHeatlth No.</label>
											 <input type="text" class="form-control" name="philHealth" value="" >
											</div>
										</div>
										
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
											<label>GSIS</label>
											 <input type="text" class="form-control" name="gsis" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>PAGIBIG</label>
											 <input type="text" class="form-control" name="pagibig" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>SSS No.</label>
											 <input type="text" class="form-control" name="sssNo" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>TIN</label>
											 <input type="text" class="form-control" name="tinNo" value="" >
											</div>
										</div>
									</div>
									
									<div class="row">
										<h5>Contact Person in Case of Emergency</h5>
									</div>
									
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
											<label>Contact Name</label>
											 <input type="text" class="form-control" name="contactName" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label>Relationship</label>
												<input type="text" class="form-control" name="contactRel" value="" >
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Email</label>
												<input type="email" class="form-control" name="contactEmail" value="" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<label>Contact No.</label>
												<input type="text" class="form-control" name="contactNo" value="" >
											</div>
										</div>
										<div class="col-lg-9">
											<div class="form-group">
												<label>Address</label>
												<input type="text" class="form-control" name="contactAddress" value="" >
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
												<input type="text" class="form-control" name="resHouseNo" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label>Street</label>
												<input type="text" class="form-control" name="resStreet" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label>Village</label>
												<input type="text" class="form-control" name="resVillage" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label>Barangay</label>
												<input type="text" class="form-control" name="resBarangay" value="" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<label>Zip Code</label>
												<input type="text" class="form-control" name="resZipCode" value="" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label>City</label>
												<input type="text" class="form-control" name="resCity" value="" >
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Province</label>
												<input type="text" class="form-control" name="resProvince" value="" >
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12">
											<input type="submit" name="submit" class="btn btn-info" value="Save Profile">
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
		

		
    </body>
</html>