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
                                <h4 class="page-title"><?php echo $data18[0]->SchoolName; ?><br />
                                    <small class="text-muted"><?php echo $data18[0]->SchoolAddress; ?></small>
                                </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li>
                                    </ol>
                                </div>

                                <div class="clearfix"></div>

                                <hr style="border: 0; height: 4px; background: linear-gradient(to right, #4285F4 50%, #DB4437 16%, #F4B400 17%, #0F9D58 17%);" />
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
                                            <h2 class="my-0"><span data-plugin="counterup"><?php echo $data6[0]->StudeCount; ?></span></h2>
                                            <p class="mb-0"><a href="<?= base_url(); ?>Page/forValidation">For Admission</a></p>
                                        </div>
                                        <i class=" mdi mdi-briefcase-plus-outline text-purple bg-light"></i>
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

                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-pink">
                                <div class="card-body widget-style-2">
                                    <div class="text-white media">
                                        <div class="media-body align-self-center">
                                            <h2 class="my-0 text-white"><span data-plugin="counterup">
                                                    <?php
                                                    foreach ($data2 as $row) {
                                                    ?>
                                                        <h3><?php echo $row->StudeCount; ?></h3>

                                                    <?php } ?>
                                                </span></h2>
                                            <a href="<?= base_url(); ?>Masterlist/byDepartment?sy=<?php echo $row->SY; ?>&department=<?php echo $row->Course; ?>" class="my-0 text-white">
                                                <p class="mb-0">Elementary</p>
                                            </a>
                                        </div>
                                        <i class="mdi mdi-account-multiple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-purple">
                                <div class="card-body widget-style-2">
                                    <div class="text-white media">
                                        <div class="media-body align-self-center">
                                            <h2 class="my-0 text-white"><span data-plugin="counterup">
                                                    <?php
                                                    foreach ($data as $row) {
                                                    ?>
                                                        <h3><?php echo $row->StudeCount; ?></h3>

                                                    <?php } ?>
                                                </span></h2>
                                            <a href="<?= base_url(); ?>Masterlist/byDepartment?sy=<?php echo $row->SY; ?>&department=<?php echo $row->Course; ?>" class="my-0 text-white">
                                                <p class="mb-0">Junior High School</p>
                                            </a>
                                        </div>
                                        <i class="mdi mdi-account-multiple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-info">
                                <div class="card-body widget-style-2">
                                    <div class="text-white media">
                                        <div class="media-body align-self-center">
                                            <h2 class="my-0 text-white"><span data-plugin="counterup">

                                                    <?php
                                                    foreach ($data1 as $row) {
                                                    ?>
                                                        <h3><?php echo $row->StudeCount; ?></h3>

                                                    <?php } ?>

                                                </span></h2>
                                            <a href="<?= base_url(); ?>Masterlist/byDepartmentSHS?sy=<?php echo $row->SY; ?>&department=<?php echo $row->Course; ?>&sem=<?php echo $row->Semester; ?>" class="my-0 text-white">
                                                <p class="mb-0">SHS - 1st Sem.</p>
                                            </a>
                                        </div>
                                        <i class="mdi mdi-account-multiple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-primary">
                                <div class="card-body widget-style-2">
                                    <div class="text-white media">
                                        <div class="media-body align-self-center">
                                            <h2 class="my-0 text-white"><span data-plugin="counterup">
                                                    <?php
                                                    foreach ($shs2 as $row) {
                                                    ?>
                                                        <h3><?php echo $row->StudeCount; ?></h3>

                                                    <?php } ?>
                                                </span></h2>
                                            <a href="<?= base_url(); ?>Masterlist/byDepartmentSHS2?sy=<?php echo $row->SY; ?>&department=<?php echo $row->Course; ?>&sem=<?php echo $row->Semester; ?>" class="my-0 text-white">
                                                <p class="mb-0">SHS - 2nd Sem.</p>
                                            </a>
                                        </div>
                                        <i class="mdi mdi-account-multiple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Enrollment Summary -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header py-3 bg-transparent">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                        <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                                        <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                    </div>
                                    <h5 class="header-title mb-0">Enrollment Summary</h5>
                                    <span class="badge badge-primary mb-3"><?php echo $this->session->userdata('semester'); ?> SY <?php echo $this->session->userdata('sy'); ?></span>

                                </div>
                                <div id="cardCollpase1" class="collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row text-center mt-4 mb-4">

                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:left">Course</th>
                                                                <th style="text-align:center">Enrollees</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($data8 as $row) {
                                                            ?>
                                                                <tr>
                                                                    <td style="text-align:left;"><a href="<?= base_url(); ?>Page/masterlistByCourseFiltered?course=<?php echo $row->Course; ?>&submit=submit">
                                                                            <?php echo $row->Course; ?>
                                                                        </a>
                                                                    </td>
                                                                    <td style="text-align:center">
                                                                        <a href="<?= base_url(); ?>Page/masterlistByCourseFiltered?course=<?php echo $row->Course; ?>&submit=submit">
                                                                            <button type="button" class="btn btn-primary btn-xs waves-effect waves-light"> <?php echo $row->Counts; ?></button>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>


                                                </div>


                                            </div>

                                            <div class="col-lg-1">

                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row text-center mt-4 mb-4">

                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:left">Sex</th>
                                                                <th style="text-align:center">Counts</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($data9 as $row) {
                                                            ?>
                                                                <tr>
                                                                    <td style="text-align:left;">

                                                                        <?php echo $row->Sex; ?>

                                                                    </td>
                                                                    <td style="text-align:center">
                                                                        <a href="<?= base_url(); ?>Page/listBySex?sex=<?php echo $row->Sex; ?>">
                                                                            <button type="button" class="btn btn-success btn-xs waves-effect waves-light"> <?php echo $row->sexCount; ?></button>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                </div>

                                                <div class="row text-center mt-4 mb-4">
                                                    <h5 class="header-title mb-0">Today's Enrollees </h5>

                                                    <table class="table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:left">Status</th>
                                                                <th style="text-align:center">Counts</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($data10 as $row) {
                                                            ?>
                                                                <tr>
                                                                    <td style="text-align:left;">
                                                                        <?php echo $row->Status; ?>

                                                                    </td>
                                                                    <td style="text-align:center">
                                                                        <a href="<?= base_url(); ?>Masterlist/dailyEnrollees?date=<?php echo date("Y-m-d"); ?>&submit=submit">
                                                                            <button type="button" class="btn btn-danger btn-xs waves-effect waves-light"> <?php echo $row->Counts; ?></button>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card-->

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
															<td style="text-align:left;">Today</td><td style="text-align:right;"><button type="button" class="btn btn-success btn-xs waves-effect waves-light"> <?php echo $data12[0]->Amount; ?></button></td>
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
                                </div>
                               

                        </div> -->


                    <!-- <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header py-3 bg-transparent">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h5 class="header-title mb-0">Enrollees by Religion</h5>
										<span class="badge badge-primary mb-3"><?php echo $this->session->userdata('semester'); ?> SY <?php echo $this->session->userdata('sy'); ?></span>
                                    </div>
                                    <div id="cardCollpase1" class="collapse show">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                       <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
														 
														 <thead>
														  <tr>
															<th style="text-align:left">Religion</th>
															<th style="text-align:center">Counts</th>
														  </tr>
														  </thead>
														  <tbody>
														  <?php
                                                            foreach ($data15 as $row) {
                                                            ?>
														  <tr>
															<td style="text-align:left;">
															  <?php echo $row->Religion; ?>
															  
															</td>
															<td style="text-align:center">
																<a href="<?= base_url(); ?>Masterlist/studeReligion?religion=<?php echo $row->Religion; ?>">
																	<button type="button" class="btn btn-info btn-xs waves-effect waves-light"> <?php echo $row->religionCount; ?></button>
																</a>
															</td>
														 
																<?php } ?>	
																 </tr>
														  </tbody>
														</table> 

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end card-->

                </div>
                <!-- end col -->
                <!-- 
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header py-3 bg-transparent">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h5 class="header-title mb-0"> Enrollees by City/Municipality</h5>
										<span class="badge badge-primary mb-3"><?php echo $this->session->userdata('semester'); ?> SY <?php echo $this->session->userdata('sy'); ?></span>
                                    </div>
                                    <div id="cardCollpase2" class="collapse show">
                                        <div class="card-body">
                                           <div class="row">
                                                <div class="col-md-12">
                                                       <table id="key-datatable" class="table dt-responsive nowrap">
														 <thead>
														  <tr>
															<th style="text-align:left">City/Mun.</th>
															<th style="text-align:center">Counts</th>
														  </tr>
														  </thead>
														  <tbody>
														  <?php
                                                            foreach ($data17 as $row) {
                                                            ?>
														  <tr>
															<td style="text-align:left;">
															  <?php echo $row->city; ?>
															  
															</td>
															<td style="text-align:center">
																<a href="<?= base_url(); ?>Masterlist/cityList?city=<?php echo $row->city; ?>">
																	<button type="button" class="btn btn-success btn-xs waves-effect waves-light"> <?php echo $row->Counts; ?></button>
																<a href="<?= base_url(); ?>Masterlist/studeReligion?city=<?php echo $row->city; ?>">
															</td>
														  </tr>
																<?php } ?>	
														  </tbody>
														</table> 

                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </div>                               
							   <div class="card">
                                    <div class="card-header py-3 bg-transparent">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h5 class="header-title mb-0"> Enrollees by Ethnicity</h5>
										<span class="badge badge-primary mb-3"><?php echo $this->session->userdata('semester'); ?> SY <?php echo $this->session->userdata('sy'); ?></span>
                                    </div>
                                    <div id="cardCollpase2" class="collapse show">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
													<div class="row text-center mt-4">
                                                       <table class="table mb-0">
														  <thead>
														  <tr>
															<th style="text-align:left">Ethnicity</th>
															<th style="text-align:center">Counts</th>
														  </tr>
														  </thead>
														  <tbody>
														  <?php
                                                            foreach ($data16 as $row) {
                                                            ?>
														  <tr>
															<td style="text-align:left;">
															  <?php echo $row->Ethnicity; ?>
															  
															</td>
															<td style="text-align:center">
																<a href="<?= base_url(); ?>Masterlist/ethnicityList?ethnicity=<?php echo $row->Ethnicity; ?>">
																	<button type="button" class="btn btn-success btn-xs waves-effect waves-light"> <?php echo $row->Counts; ?></button>
																</a>
															</td>
														  </tr>
																<?php } ?>	
														  </tbody>
														</table> 

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                              


                            </div>

                        </div> -->

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

                                                            </button></a>
                                                    </td>
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
                                    </div> </a>
                                </div>
                            </div>
                        </div>
                        <!-- end card-->

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