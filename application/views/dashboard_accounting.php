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
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">ACCOUNTING DASHBOARD<br />
                                    <!-- Clickable Badge -->
                                    <span class="badge badge-purple mb-1"
                                        data-toggle="modal"
                                        data-target="#semesterSyModal"
                                        data-toggle="tooltip"
                                        title="Click to change School Year"
                                        style="cursor:pointer;">
                                        SY <?php echo $this->session->userdata('sy'); ?>
                                    </span>

                                    <span class="badge badge-info mb-1"
                                        data-toggle="modal"
                                        data-target="#semesterSyModal"
                                        data-toggle="tooltip"
                                        title="Click to change School Year"
                                        style="cursor:pointer;">
                                        Switch School Year
                                    </span>


                                    <!-- Modal -->
                                    <div class="modal fade" id="semesterSyModal" tabindex="-1" role="dialog" aria-labelledby="semesterSyModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form id="semesterSyForm" method="post" action="<?= base_url('Page/updateSemesterSy') ?>">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="semesterSyModalLabel">Update School Year</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="sy">School Year</label>
                                                            <input type="text" class="form-control" id="sy" name="sy" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>

                                <hr style="border: 0; height: 4px; background: linear-gradient(to right, #4285F4 50%, #DB4437 16%, #F4B400 17%, #0F9D58 17%);" />

                                <?php if ($this->session->flashdata('success')) : ?>

                                    <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>'
                                        . $this->session->flashdata('success') .
                                        '</div>';
                                    ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body widget-style-2">
                                    <div class="media">
                                        <div class="media-body align-self-center">
                                            <h2 class="my-0"><span data-plugin="counterup"><?php echo $data4[0]->Studecount; ?></span></h2>
                                            <p class="mb-0"><a href="<?= base_url(); ?>Page/proof_payment_view">For Payment Verification</a></p>
                                            </a>
                                        </div>
                                        <i class="mdi mdi-cash-marker text-pink bg-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body widget-style-2">
                                    <div class="media">
                                        <div class="media-body align-self-center">
                                            <h2 class="my-0"><span data-plugin="counterup"><?php echo number_format($data7[0]->StudeCount); ?></span></h2>
                                            <p class="mb-0"><a href="<?= base_url(); ?>Page/profileList">Students' Profile</a></p>
                                        </div>
                                        <i class="mdi mdi-layers-plus text-info bg-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Collection Summary -->
                    <!-- <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header py-3 bg-transparent">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h5 class="header-title mb-0">Collection Summary</h5>
										<span class="badge badge-primary mb-0"><?php echo $this->session->userdata('semester'); ?> SY <?php echo $this->session->userdata('sy'); ?></span>
                                    </div>
                                    <div id="cardCollpase1" class="collapse show">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
													<div class="row text-center mt-4 mb-4">
                                                         <table class="table mb-0">
														
														<tr>
															<td style="text-align:left;">Today</td><td style="text-align:right;"><button type="button" class="btn btn-success btn-xs waves-effect waves-light"> <?php echo number_format($data12[0]->Amount, 2); ?></button></td>
														</tr>
														<tr>
															<td style="text-align:left;">This Month</td><td style="text-align:right;"><button type="button" class="btn btn-danger btn-xs waves-effect waves-light"> <?php echo number_format($data13[0]->Amount, 2); ?></button></td>
														</tr>

														<tr>
															<td style="text-align:left;">This Year</td><td style="text-align:right;"><button type="button" class="btn btn-dark btn-xs waves-effect waves-light"> <?php echo number_format($data14[0]->Amount, 2); ?></button></td>
														</tr>
                                                        </table>
														
                                                    </div>	
                                                </div>
												<div class="col-lg-1">
												
												</div>
												<div class="col-lg-5">
													
													<div class="row text-center mt-4 mb-4">
                                                        <table class="table mb-0">
														  
														  <?php
                                                            foreach ($data11 as $row) {
                                                            ?>
														  <tr>
															<td style="text-align:left;">
															  <?php echo $row->CollectionSource; ?>
															  
															</td>
															<td style="text-align:right">
																<button type="button" class="btn btn-secondary btn-xs waves-effect waves-light"> <?php echo number_format($row->Amount, 2); ?></button>
															</td>
														  </tr>
																<?php } ?>	
														  
														</table> 
													</div>		
                                                </div>
                                            </div>

                                        </div>
                                    </div>
									</div>
                                </div> -->
                    <!-- end card-->

                    <!-- </div>
                          <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header py-3 bg-transparent">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase3" role="button" aria-expanded="false" aria-controls="cardCollpase3"><i class="mdi mdi-minus"></i></a>
                                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h5 class="header-title mb-2"> Document Request Tracking</h5>
                                    </div>
                                    <div id="cardCollpase3" class="collapse show">
                                        <div class="card-body">
                                            <div class="table-responsive">
											<?php echo $this->session->flashdata('msg'); ?>
                                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
														 
														 <thead>
														  <tr>
															<th style="text-align:left">Tracking No.</th>
															<th style="text-align:center">Requested By</th>
															<th style="text-align:center">Document Name</th>
															<th style="text-align:center">Purpose</th>
															<th style="text-align:center">Date Requested</th>
														  </tr>
														  </thead>
														  <tbody>
															<?php
                                                            $i = 1;
                                                            foreach ($data19 as $row) {
                                                                echo "<tr>";
                                                            ?>
															
															  <td>
															  <a href="<?= base_url(); ?>Page/studentRequestStat?trackingNo=<?php echo $row->trackingNo; ?>"><button type="button" class="btn btn-primary btn-xs"><?php echo $row->trackingNo; ?>
															  
															  </button></a></td>
															  <?php
                                                                echo "<td>" . $row->FirstName . ' ' . $row->LastName . "</td>";
                                                                echo "<td>" . $row->docName . "</td>";
                                                                echo "<td>" . $row->purpose . "</td>";
                                                                echo "<td>" . $row->dateReq . ' ' . $row->timeReq . "</td>";
                                                                echo "</tr>";
                                                            }

                                                                ?>
														</table> 
															<a href="<?= base_url(); ?>Page/closedDocRequest">
																<button type="button" class="btn btn-info float-right waves-effect waves-light"> <i class="fas fa-door-closed mr-1"></i> <span>Closed Request</span> </button>
                                            </div>			</a>
                                        </div>
                                    </div>
                                </div>
                                end card -->

                </div>
            </div>

        </div>


    </div>
    <!-- end col -->


    </div>
    <!-- End row -->

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

    <script src="<?= base_url(); ?>assets/libs/fullcalendar/fullcalendar.min.js"></script>

    <!-- Calendar init -->
    <script src="<?= base_url(); ?>assets/js/pages/calendar.init.js"></script>

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

    <script src="<?= base_url(); ?>assets/libs/jquery-ui/jquery-ui.min.js"></script>
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

    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

</body>

</html>