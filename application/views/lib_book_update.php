
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
                                    <!-- <h4 class="page-title">BOOKS ENTRY</h4> -->
                                   <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span></b></a></li> -->
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
                                       <h4 class="m-t-0 header-title mb-4"><b>Book Entry</b>
									   <span class="badge badge-purple mb-3">Library Module</span></h4>
										<form role="form" method="post" enctype="multipart/form-data">
							<!-- general form elements -->
 						        <div class="card-body">
									
									<div class="row">
									
										<div class="col-lg-3">
												<div class="form-group">
												<input type="hidden" class="form-control" value="<?php echo $settings[0]->settingsID; ?>" name="settingsID" required >
													<label for="lastName">Book No. <span style="color:red">*</span></label>
													<input type="text" class="form-control" value="<?php echo $data[0]->BookNo; ?>" name="BookNo" required >
												</div>	
										</div>	
										<div class="col-lg-9">
												<div class="form-group">
													<label>Title <span style="color:red">*</span></label>
													<input type="text" class="form-control" name="Title" value="<?php echo $data[0]->Title; ?>" required >
												</div>	
										</div>
									</div>
									
									<div class="row">
										<input type="hidden" class="form-control" name="AuthorNum" value="<?php echo $data[0]->AuthorNum; ?>" >										
										<div class="col-lg-6">
											<div class="form-group">
											<label>Author </label>
											 <input type="text" class="form-control" name="Author"value="<?php echo $data[0]->Author; ?>" >
                                        </div>
										</div>
										<div class="col-lg-6">
												<div class="form-group">
													<label for="lastName">Co-Authors</label>
													<input type="text" class="form-control" name="coAuthors" value="<?php echo $data[0]->coAuthors; ?>" >
												</div>	
										</div>	
									</div>	
									
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
											<label>Publisher</label>
											 <select name="Publisher" id="course" class="form-control" >
															 <option value="<?php echo $data[0]->Publisher; ?>"><?php echo $data[0]->Publisher; ?></option>
															 <?php
																foreach ($publisher as $row) {
																?>
																<option value="<?php echo $row->publisher; ?>"><?php echo $row->publisher; ?></option>
																
																<?php
																}
																?>
															</select>
											</div>
										</div>
										<div class="col-lg-3">
												<div class="form-group">
													<label for="lastName">Subject</label>
													<input type="text" class="form-control" name="Subject" value="<?php echo $data[0]->Subject; ?>" >
												</div>	
										</div>	
										<div class="col-lg-3">
												<div class="form-group">
													<label for="lastName">Year Published</label>
													<input type="number" class="form-control" name="YPublished" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;">
												</div>	
										</div>	  
										
									</div>
									
									<div class="row">
										
										<div class="col-lg-3">
												<div class="form-group">
													<label>ISBN</label>
													<input type="text" class="form-control" name="ISBN" value="<?php echo $data[0]->ISBN; ?>" >
												</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Edition</label>
											 <input type="text" class="form-control" name="Edition" value="<?php echo $data[0]->Edition; ?>" >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Call Number</label>
											<input type="text" name="CallNum" class="form-control" value="<?php echo $data[0]->CallNum; ?>" >
											</div>
										</div>  
										<div class="col-lg-3">
												<div class="form-group">
													<label>Category</label>
													<select name="Category" id="course" class="form-control" >
															 <option value="<?php echo $data[0]->Category; ?>"><?php echo $data[0]->Category; ?></option>
															 <?php
																foreach ($category as $row) {
																?>
																<option value="<?php echo $row->Category; ?>"><?php echo $row->Category; ?></option>
																
																<?php
																}
																?>
															</select>
												</div>
											</div> 
										
									</div>
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<label>Location</label>
													 <select name="Location" id="course" class="form-control" >
															 <option value="<?php echo $data[0]->Location; ?>"><?php echo $data[0]->Location; ?></option>
															 <?php
																foreach ($location as $row) {
																?>
																<option value="<?php echo $row->location; ?>"><?php echo $row->location; ?></option>
																
																<?php
																}
																?>
															</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Dewey No. </label>
											 <input type="text" class="form-control" name="DeweyNum" value="<?php echo $data[0]->DeweyNum; ?>"  >
											</div>
										</div>
 
										<div class="col-lg-3">
											<div class="form-group">
											<label>Accession No. </label>
											 <input type="text" class="form-control" name="AccNo" value="<?php echo $data[0]->AccNo; ?>"  >
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
											<label>Purchase Price </label>
											 <input type="number" class="form-control" name="Price" value="<?php echo $data[0]->Price; ?>"  >
											</div>
										</div>	
									</div>
							
									<div class="row">
										<div class="col-lg-12">
											<input type="submit" name="submit" class="btn btn-info float-right" value="Update">
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