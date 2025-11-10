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
                                <h4 class="page-title">GRADING SHEETS <br />
                                    <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                </h4>
                                <div class="page-title-right">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <!-- <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li> -->
                                        </ol>
                                    </div>
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
                                    <!--<h4 class="m-t-0 header-title mb-4">
											Grades Monitoring
										</h4>-->
                                    <?php echo $this->session->flashdata('msg'); ?>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Subject Code</th>
                                                <th style="text-align: center;">Description</th>
                                                <th style="text-align: center;">Teacher</th>
                                                <th style="text-align: center;">Section</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $row->SubjectCode . "</td>";
                                                echo "<td>" . $row->Description . "</td>";
                                                echo "<td>" . $row->Instructor . "</td>";
                                                echo "<td>" . $row->Section . "</td>";
                                            ?>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url(); ?>Masterlist/gradeSheets?SubjectCode=<?php echo $row->SubjectCode; ?>&Description=<?php echo $row->Description; ?>&Section=<?php echo $row->Section; ?>&SY=<?php echo $row->SY; ?>">
                                                        <button type="button" class="btn btn-success btn-xs waves-effect waves-light"> View Grades</button>
                                                    </a>



                                                    <!-- Trigger Modal Button -->
<button type="button" class="btn btn-info btn-xs waves-effect waves-light" data-toggle="modal" data-target="#printModal<?= $row->gradeID; ?>">
    Print View
</button>

                                                    <!-- <a href="grades_sheets_pv/<?= $row->gradeID; ?>" class="btn btn-success btn-xs waves-effect waves-light">Print View</a> -->
                                                    <!-- <a href="grades_sheets_all/<?= $row->gradeID; ?>" class="btn btn-success btn-xs waves-effect waves-light">Print View v2</a> -->
                                                </td>




                                                <!-- Grading Period Modal -->
<div class="modal fade" id="printModal<?= $row->gradeID; ?>" tabindex="-1" role="dialog" aria-labelledby="printModalLabel<?= $row->gradeID; ?>" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title" id="printModalLabel<?= $row->gradeID; ?>">Select Grading Period</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="font-size: 20px;">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
<form method="get" action="<?= base_url('Masterlist/grades_sheets_pv/' . $row->gradeID); ?>">
          <select class="form-control mb-3" name="period" required>
            <option value="1st">1st Grading</option>
            <option value="2nd">2nd Grading</option>
            <option value="3rd">3rd Grading</option>
            <option value="4th">4th Grading</option>
            <option value="all">All Periods</option>
          </select>
          <button type="submit" class="btn btn-success btn-sm">Print</button>
        </form>
      </div>
    </div>
  </div>
</div>

                                            <?php
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                        </div><!-- /.box-body -->

                    </div>



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