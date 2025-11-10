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
                                <h4 class="page-title">TEACHER'S DASHBOARD <br />
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

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card widget-style-1 bg-info">
                                <div class="card-body">
                                    <a href="<?= base_url(); ?>Instructor/facultyLoad">
                                        <div class="my-4 text-white">
                                            <i class="mdi mdi-file-document-box-check"></i>

                                            <h2 class="my-0 text-white"><span data-plugin="counterup">
                                                    <?php
                                                    if (!$data) {
                                                        //the value is null
                                                        echo "0.00";
                                                    } else {
                                                        echo $data[0]->subjectCounts;
                                                    } ?>
                                                </span></h2>
                                            <div>Faculty Load</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-xl-3 col-sm-6">
                            <div class="card widget-style-1 bg-success">
                                <div class="card-body">

                                    <div class="my-4 text-white">
                                        <i class="mdi mdi-file-document"></i>
                                        <h2 class="my-0 text-white"><span data-plugin="counterup">
                                                <?php
                                                if (!$data1) {
                                                    //the value is null
                                                    echo "0.00";
                                                } else {
                                                    echo $data1[0]->subjectCounts;
                                                } ?>
                                            </span></h2>
                                        <div>Grading Sheets</div>
                                    </div></a>
                                </div>
                            </div>
                        </div> -->

                    </div>

                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header py-3 bg-transparent">
                                <div class="card-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                    <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                                    <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                </div>
                                <h5 class="header-title mb-0">Faculty Load</h5>
                                <!-- <small> SY <?php echo $this->session->userdata('sy'); ?></small> -->
                            </div>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Description</th>
                                                        <th>Strand</th>
                                                        <th style="text-align: center">Section</th>
                                                        <th style="text-align: center">Class Sched</th>
                                                        <th style="text-align: center">Room</th>
                                                        <th style="text-align: center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($data2 as $row) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row->SubjectCode . "</td>";
                                                        echo "<td style='text-align:left'>" . (!empty($row->Description) ? $row->Description : '') . "</td>";
                                                        echo "<td style='text-align:left'>" . (!empty($row->strand) ? $row->strand : '') . "</td>";
                                                        echo "<td style='text-align:center'>" . (!empty($row->Section) ? $row->Section : '') . "</td>";
                                                        echo "<td style='text-align:center'>" . (!empty($row->SchedTime) ? $row->SchedTime : '') . "</td>";
                                                        echo "<td style='text-align:center'>" . (!empty($row->Room) ? $row->Room : '') . "</td>";

                                                    ?>
                                                        <td style="text-align: center">
                                                            <!-- <a href="<?= base_url(); ?>Instructor/subjectsMasterlist?subjectcode=<?php echo $row->SubjectCode; ?>&description=<?php echo $row->Description; ?>&section=<?php echo $row->Section; ?>&id=<?php echo $row->Instructor; ?>"><button type="button" class="btn btn-info btn-xs">Masterlist</button></a> -->
                                                            <a href="<?= base_url(); ?>Instructor/subjectsMasterlist?subjectcode=<?php echo $row->SubjectCode; ?>&description=<?php echo $row->Description; ?>&section=<?php echo $row->Section; ?>&yearLevel=<?php echo $row->YearLevel; ?>&strand=<?php echo $row->strand; ?>&ins=<?php echo $row->IDNumber; ?>"><button type="button" class="btn btn-info btn-xs">Masterlist</button></a>
                                                            <a href="<?= base_url(); ?>Instructor/subjectGrades?subjectcode=<?php echo $row->SubjectCode; ?>&description=<?php echo $row->Description; ?>&section=<?php echo $row->Section; ?>&strand=<?php echo $row->strand; ?>&ins=<?php echo $row->IDNumber; ?>"><button type="button" class="btn btn-success btn-xs">Grades</button></a>
                                                            <!-- <a href="<?= base_url(); ?>Instructor/uploadGrades?subjectcode=<?php echo $row->SubjectCode; ?>&description=<?php echo $row->Description; ?>&section=<?php echo $row->Section; ?>"><button type="button" class="btn btn-primary btn-xs">Upload Grades</button></a> -->
                                                        </td>
                                                    <?php
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
                    </div>
                    <!-- end card-->

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