<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>SRMS | Online Registration</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		
		<!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
		
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
    <body data-layout="horizontal">

				<!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
					<div class="col-md-12">
						<div class="card">
						<img src="<?= base_url(); ?>assets/images/header.png" width="100%" class="img-responsive"> <br />
				<form method="post">
					<div class="col-sm-12">
						<h1><?php echo $this->session->flashdata('msg'); ?></h1>
						<div class="row">
							<div class="col-sm-3 form-group">
								<label>Student Type<span style="color:red;">*</span></label>
								<select class="form-control" name="StudentType"  required>
								<option></option>
								<option>New</option>
								<option>Transferee</option>
							</select>
							</div>
							<div class="col-sm-3 form-group">
								<label>Grade Level to Enroll<span style="color:red;">*</span></label>
								<select class="form-control" name="YearLevelToEnroll"  required>
								<option></option>
								<option>Grade 7</option>
								<option>Grade 8</option>
								<option>Grade 9</option>
								<option>Grade 10</option>
								<option>Grade 11</option>
								<option>Grade 12</option>
							</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3 form-group">
								<label>First Name <span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="fname" required style="text-transform: uppercase;">
							</div>	
							<div class="col-sm-3 form-group">
								<label>Middle Name</label>
								<input type="text" placeholder="" class="form-control" name="mname" style="text-transform: uppercase;">
							</div>	
							<div class="col-sm-3 form-group">
								<label>Last Name <span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="lname" required style="text-transform: uppercase;">
							</div>
							<div class="col-sm-3 form-group">
								<label>Name Extn. </label>
								<input type="text" placeholder="e.g. Jr., Sr." class="form-control" name="nameExt" style="text-transform: uppercase;">
							</div>								
						</div>

						<div class="row">
							<div class="col-sm-3 form-group">
								<label>PSA Birth Certificate No.</label>
								<input type="text" placeholder="" class="form-control" name="contactno">
							</div>
							<div class="col-sm-3 form-group">
								<label>Sex<span style="color:red;">*</span></label>
								<select class="form-control" name="sex"  required>
								<option></option>
								<option>Female</option>
								<option>Male</option>
							</select>
							</div>

							<div class="col-sm-2 form-group">
								<label>Birth Date<span style="color:red;">*</span></label>
								<input type="date" name="bdate" class="form-control" id="bday" onchange="submitBday()" required >
							</div>	
							<div class="col-sm-1 form-group">
								<label>Age<span style="color:red;">*</span></label>
								<input type="text" name="Age" id="resultBday" class="form-control" readonly />
							</div>
							<div class="col-sm-3 form-group">
								<label>Contact No.</label>
								<input type="text" placeholder="" class="form-control" name="contactno">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3 form-group">
								<label>Belonging to Indigenous Peoples<span style="color:red;">*</span></label>
								<select class="form-control" name="Belong_IP"  required>
								<option></option>
								<option>Yes</option>
								<option>No</option>
							</select>
							</div>
							<div class="col-sm-3 form-group">
								<label>If Yes, please specify</label>
								<input type="text" placeholder="" class="form-control" name="IPSpecify">
							</div>
							<div class="col-sm-3 form-group">
								<label>Mother Tongue<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" required name="MTongue">
							</div>
							<div class="col-sm-3 form-group">
								<label>Religion<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" required name="Religion ">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3 form-group">
								<label>Do you have special education needs?<span style="color:red;">*</span></label>
								<select class="form-control" name="SpecEducNeed"  required>
								<option></option>
								<option>Yes</option>
								<option>No</option>
							</select>
							</div>
							<div class="col-sm-3 form-group">
								<label>If Yes, please specify</label>
								<input type="text" placeholder="" class="form-control" name="SENSpecify">
							</div>
							<div class="col-sm-3 form-group">
								<label>Do you have any assistive technology devices?<span style="color:red;">*</span></label>
								<select class="form-control" name="DeviceAvailable"  required>
								<option></option>
								<option>Yes</option>
								<option>No</option>
							</select>
							</div>
							<div class="col-sm-3 form-group">
								<label>If Yes, please specify</label>
								<input type="text" placeholder="" class="form-control" name="DASpecify">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3 form-group">
								<label>Father's Name<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="Father" required>
							</div>	
											<div class="col-lg-3">
											<div class="form-group">
											<label>Highest Educ. Attainment<span style="color:red">*</span></label>
											 <select name="FHEA" class="form-control" required>
												<option value=""></option>
												<option value="Elementary Gradudate">Elementary Graduate</option>
												<option value="High School Graduate">High School Graduate</option>
												<option value="College Graduate">College Graduate</option>
												<option value="Vocational">Vocational</option>
												<option value="MA/Doctorate Degree">MA/Doctorate Degree</option>
												<option value="Did not attend school">Did not attend school</option>
												<option value="Others">Others</option>
											</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Employment Status<span style="color:red">*</span></label>
											 <select name="FEmpStat" class="form-control" required>
												<option value=""></option>
												<option value="Full time">Full time</option>
												<option value="Part time">Part time</option>
												<option value="Self-employed">Self-employed</option>
												<option value="Unemployed due to community quarantine">Unemployed due to community quarantine</option>
												<option value="Not working">Not working</option>
												
											</select>
											</div>
										</div>
									<div class="col-sm-3 form-group">
										<label>Contact Nos.</label>
										<input type="text" placeholder="" class="form-control" name="FMobileNo" >
									</div>										
						</div>
						<div class="row">
							<div class="col-sm-3 form-group">
								<label>Mother's Name<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="Mother" required>
							</div>	
								<div class="col-lg-3">
											<div class="form-group">
											<label>Highest Educ. Attainment<span style="color:red">*</span></label>
											 <select name="MHEA" class="form-control" required>
												<option value=""></option>
												<option value="Elementary Gradudate">Elementary Graduate</option>
												<option value="High School Graduate">High School Graduate</option>
												<option value="College Graduate">College Graduate</option>
												<option value="Vocational">Vocational</option>
												<option value="MA/Doctorate Degree">MA/Doctorate Degree</option>
												<option value="Did not attend school">Did not attend school</option>
												<option value="Others">Others</option>
											</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Employment Status<span style="color:red">*</span></label>
											 <select name="MEmpStat" class="form-control" required>
												<option value=""></option>
												<option value="Full time">Full time</option>
												<option value="Part time">Part time</option>
												<option value="Self-employed">Self-employed</option>
												<option value="Unemployed due to community quarantine">Unemployed due to community quarantine</option>
												<option value="Not working">Not working</option>
												
											</select>
											</div>
										</div>
									<div class="col-sm-3 form-group">
										<label>Contact Nos.</label>
										<input type="text" placeholder="" class="form-control" name="MMobileNo" >
									</div>	
						</div>						
						<div class="row">
							<hr />
							
							<div class="col-sm-3 form-group">
								<label>Sitio<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="Brgy" required>
							</div>							
							<div class="col-sm-3 form-group">
								<label>Barangay<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="Brgy" required>
							</div>	
	
							<div class="col-sm-3 form-group">
								<label>City/Municipality<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="City" required>
							</div>
							<div class="col-sm-3 form-group">
								<label>Province<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="Province" required>
							</div>
							
						</div>
						<div class="row">
							<hr />
							<div class="col-sm-4 form-group">
								<label>E-mail Address<span style="color:red;">*</span></label>
								<input type="text" placeholder="" class="form-control" name="email" required>
							</div>
							<div class="col-sm-4 form-group">
								<label>LRN <span style="color:red;">* This will serve as your username.</span></label>
								<input type="text" placeholder="" class="form-control" name="lrn" required>
							</div>
							
								<div class="col-sm-4 form-group">
								<label>Password <span style="color:red;">*</span></label>
								<input type="password" placeholder="" class="form-control" name="pass" required>
							</div>
						</div>
						<p style="color:red;">Privacy Notice: The Department of Education (DepEd) respects your right to privacy per RA 10173 (Data Privacy Act of 2012), its Implementing Rules and Regulations, and other issuance of the National Privacy Commission ("Privacy Laws").  By submitting this form, you consent the processing of your Personal Data to identify how DepEd can cater to its students/prospected students' needs.</p>

					<input type="submit" name="register" class="btn btn-lg btn-info" value="Create My Account">					
					</div>
				</form>
					</div>
				
				</div>
				</div>
				</div>
			</div>

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?= base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>