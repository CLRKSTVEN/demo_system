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
                                    <!-- <h4 class="page-title">BOOK DETAILS</h4> -->
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span></b></a></li> -->
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- start row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <!-- <div class="panel-heading">
                                                    <h4>Invoice</h4>
                                                </div> -->
                                    <div class="card-body">
                                        <div class="clearfix">
										
										  <div class="float-left">
                                                <h5 style="text-transform:uppercase"><strong><?php echo $data[0]->Title; ?></strong><!--<img src="assets/images/logo-dark.png" height="18" alt="moltran">-->
												<br /><small><span class="badge badge-purple mb-3"><?php echo $data[0]->BookNo; ?></span></small>
												</h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="float-left mt-12">
                                                   <table class="table">
													<tr>
														<td>Author</td><td><?php echo $data[0]->Author; ?></td>
													</tr>
													<tr>
														<td>Co-Authors</td><td><?php echo $data[0]->coAuthors; ?></td>
													</tr>
													<tr>
														<td>Publisher</td><td><?php echo $data[0]->Publisher; ?></td>
													</tr>
													<tr>
														<td>Year Published</td><td><?php echo $data[0]->YPublished; ?></td>
													</tr>
													<tr>
														<td>Subject</td><td><?php echo $data[0]->Subject; ?></td>
													</tr>
													<tr>
														<td>ISBN</td><td><?php echo $data[0]->ISBN; ?></td>
													</tr>
													<tr>
														<td>Edition</td><td><?php echo $data[0]->Edition; ?></td>
													</tr>
													
												   </table>
                                                </div>
                                                
                                            </div>
											<div class="col-md-6">
												                                                <div class="float-left mt-12">
                                                   <table class="table">
											
													<tr>
														<td>CallNum</td><td><?php echo $data[0]->CallNum; ?></td>
													</tr>
													<tr>
														<td>Category</td><td><?php echo $data[0]->Category; ?></td>
													</tr>
													<tr>
														<td>Location</td><td><?php echo $data[0]->Location; ?></td>
													</tr>
													<tr>
														<td>Dewey No.</td><td><?php echo $data[0]->DeweyNum; ?></td>
													</tr>
													<tr>
														<td>Accession No.</td><td><?php echo $data[0]->AccNo; ?></td>
													</tr>
													<tr>
														<td>Entry Date</td><td><?php echo $data[0]->EntryDate; ?></td>
													</tr>
												   </table>
                                                </div>
											</div>
                                        </div>
                                        <hr>
                                        <div class="d-print-none">
                                            <div class="float-right">
                                                <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>
                                                <!-- <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

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