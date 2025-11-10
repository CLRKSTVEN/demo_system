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
                                <form class="form-inline mb-1" method="post" action="<?= base_url('Masterlist/studeGradesView') ?>">
                                    <label for="sy" class="mr-2">SY</label>
                                    <select id="sy" name="sy" class="form-control mr-2" style="width: 200px;">

                                        <?php foreach ($school_years as $row): ?>
                                            <option value="<?= $row->SY ?>" <?= ($row->SY == $selected_sy) ? 'selected' : '' ?>>
                                                <?= $row->SY ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-primary">View</button>
                                </form>


                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="float-left">
                                        <h4 class="m-t-0 header-title mb-1"><b>REPORT OF GRADES</b><br />
                                            <span class="badge badge-primary mb-1">SY <?= $selected_sy ?></span>

                                        </h4>
                                        <?php $gradesDisplay = isset($data1->gradesDisplay) ? $data1->gradesDisplay : 'Letter'; ?>

                                        <?php if ($data1->viewGrades === "Yes") { ?>


                                            <?php if (!$data) {
                                                echo "No Records Found ";
                                            } else { ?>

                                                <table>
                                                    <tr>
                                                        <td>Student Number</td>
                                                        <td> : <strong><?php echo $data[0]->StudentNumber; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Student Name</td>
                                                        <td> : <strong><?php echo $data[0]->FirstName . ' ' . $data[0]->MiddleName . ' ' . $data[0]->LastName; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Grade Level</td>
                                                        <td> : <strong><?php echo $data[0]->YearLevel; ?></strong></td>
                                                    </tr>
                                                </table>
                                    </div>

                                    <!-- Print -->
                                    <!-- <div class="float-right">
                                        <div class="d-print-none">
                                            <div class="float-right">
                                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i> Print</a>
                                            </div>
                                        </div>
                                    </div> -->

                                    <?php
                                                $yearLevel = isset($data[0]->YearLevel) ? $data[0]->YearLevel : '';
                                                $hideSecondSemester = ($yearLevel === "Grade 11" || $yearLevel === "Grade 12");
                                    ?>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Subject Code</th>
                                                <th>Description</th>
                                                <th>Teacher</th>
                                                <th style="text-align:center">1st Grading</th>
                                                <th style="text-align:center">2nd Grading</th>
                                                <?php if (!$hideSecondSemester): ?>
                                                    <th style="text-align:center">3rd Grading</th>
                                                    <th style="text-align:center">4th Grading</th>
                                                <?php endif; ?>
                                                <th style="text-align:center">Average</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php if ($data1->gradeDisplay === "Letter") { ?>

                                                <?php foreach ($data as $row): ?>

                                                    <tr>
                                                        <td><?= $row->SubjectCode ?></td>
                                                        <td><?= $row->Description ?></td>
                                                        <td><?= $row->Instructor ?></td>

                                                        <!-- PGrade -->
                                                        <td style="text-align:center" class="<?= $row->PGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                            <?= $row->l_p ?>
                                                        </td>


                                                        <!-- MGrade -->
                                                        <td style="text-align:center" class="<?= $row->MGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                            <?= $row->l_m ?>
                                                        </td>

                                                        <?php if (!$hideSecondSemester): ?>
                                                            <!-- PFinalGrade -->
                                                            <td style="text-align:center" class="<?= $row->PFinalGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                                <?= $row->l_pf ?>
                                                            </td>

                                                            <!-- FGrade -->
                                                            <td style="text-align:center" class="<?= $row->FGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                                <?= $row->l_f ?>
                                                            </td>
                                                        <?php endif; ?>

                                                        <!-- Average -->
                                                        <td style="text-align:center" class="<?= $row->Average < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                            <?= $row->l_average ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                        </tbody>
                                        <?php  } else {

                                                    foreach ($data as $row): ?>

                                            <tr>
                                                <td><?= $row->SubjectCode ?></td>
                                                <td><?= $row->Description ?></td>
                                                <td><?= $row->Instructor ?></td>

                                                <!-- PGrade -->
                                                <td style="text-align:center" class="<?= $row->PGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                    <?= number_format($row->PGrade, 2) ?>
                                                </td>

                                                <!-- MGrade -->
                                                <td style="text-align:center" class="<?= $row->MGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                    <?= number_format($row->MGrade, 2) ?>
                                                </td>

                                                <?php if (!$hideSecondSemester): ?>
                                                    <!-- PFinalGrade -->
                                                    <td style="text-align:center" class="<?= $row->PFinalGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                        <?= number_format($row->PFinalGrade, 2) ?>
                                                    </td>

                                                    <!-- FGrade -->
                                                    <td style="text-align:center" class="<?= $row->FGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                        <?= number_format($row->FGrade, 2) ?>
                                                    </td>
                                                <?php endif; ?>

                                                <!-- Average -->
                                                <td style="text-align:center" class="<?= $row->Average < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                    <?= number_format($row->Average, 2) ?>
                                                </td>
                                            </tr>

                                    <?php endforeach;
                                                }
                                    ?>

                                    </table>


                                <?php } ?>

                            <?php } else { ?>
                                <p style="font-size: 24px; color: red;">VIEWING OF GRADES IS NOT AVAILABLE AT THIS TIME.</p>
                            <?php } ?>


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

    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

</body>

</html>