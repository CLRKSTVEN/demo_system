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
                                <h4 class="page-title">REGISTRAR'S DASHBOARD <br />
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
                                        <li class="breadcrumb-item">
                                            <!-- <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span> -->
                                        </li>
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
                        <div class="col-md-6 col-xl-3">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-info rounded-circle">
                                            <i class="ion-md-contacts avatar-title font-26 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <?php $count = isset($data7[0]->StudeCount) ? $data7[0]->StudeCount : 0; ?>
                                        <div class="text-right">
                                            <h3 class="my-0 font-weight-bold">
                                                <span data-plugin="counterup"><?= $count; ?></span>
                                            </h3>
                                            <p class="mb-0 mt-1 text-truncate">
                                                <?php if ($count > 0): ?>
                                                    <a href="<?= base_url('Page/profileList'); ?>">Students' Profile</a>
                                                <?php else: ?>
                                                    Total Students' Profile
                                                <?php endif; ?>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-warning rounded-circle">
                                            <i class="ion-md-contacts avatar-title font-26 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <?php $count = isset($data6[0]->StudeCount) ? $data6[0]->StudeCount : 0; ?>

                                        <div class="text-right">
                                            <h3 class="my-0 font-weight-bold">
                                                <span data-plugin="counterup"><?= $count; ?></span>
                                            </h3>
                                            <p class="mb-0 mt-1 text-truncate">
                                                <?php if ($count > 0): ?>
                                                    <a href="<?= base_url('Page/forValidation'); ?>">For Admission</a>
                                                <?php else: ?>
                                                    For Admission
                                                <?php endif; ?>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-primary rounded-circle">
                                            <i class="ion-md-eye avatar-title font-26 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <?php $count = isset($data18[0]->StudeCount) ? $data18[0]->StudeCount : 0; ?>
                                        <div class="text-right">
                                            <h3 class="my-0 font-weight-bold">
                                                <span data-plugin="counterup"><?= $count; ?></span>
                                            </h3>
                                            <p class="mb-0 mt-1 text-truncate">
                                                <?php if ($count > 0): ?>
                                                    <a href="<?= base_url('Masterlist/bySY'); ?>">Enrolled</a>
                                                <?php else: ?>
                                                    Enrolled
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-secondary rounded-circle">
                                            <i class=" ion ion-md-business avatar-title font-26 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <?php $count = isset($data4[0]->pendingCount) ? $data4[0]->pendingCount : 0; ?>
                                        <div class="text-right">
                                            <h3 class="my-0 font-weight-bold">
                                                <span data-plugin="counterup"><?= $count; ?></span>
                                            </h3>
                                            <p class="mb-0 mt-1 text-truncate">
                                                <?php if ($count > 0): ?>
                                                    <a href="<?= base_url('ToDo/pendingList'); ?>">Pending Task</a>
                                                <?php else: ?>
                                                    Pending Task
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->
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
                                            <a href="#" class="my-0 text-white">
                                                <!-- <a href="<?= base_url(); ?>Masterlist/byDepartment?sy=<?php echo $row->SY; ?>&department=<?php echo $row->Course; ?>" class="my-0 text-white"> -->
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
                                            <a href="#" class="my-0 text-white">
                                                <!-- <a href="<?= base_url(); ?>Masterlist/byDepartment?sy=<?php echo $row->SY; ?>&department=<?php echo $row->Course; ?>" class="my-0 text-white"> -->
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
                                            <a href="#" class="my-0 text-white">
                                                <!-- <a href="<?= base_url(); ?>Masterlist/byDepartment?sy=<?php echo $row->SY; ?>&department=<?php echo $row->Course; ?>&sem=<?php echo $row->Semester; ?>" class="my-0 text-white"> -->
                                                <p class="mb-0">Senior High School.</p>
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
                                            <a href="#" class="my-0 text-white">
                                                <!-- <a href="<?= base_url(); ?>Masterlist/byDepartment?sy=<?php echo $row->SY; ?>&department=<?php echo $row->Course; ?>&sem=<?php echo $row->Semester; ?>" class="my-0 text-white"> -->
                                                <p class="mb-0">Preschool</p>
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