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
                                <!-- <h4 class="page-title">My Document Requests <br /> -->
                                    <!-- <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span> -->
                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Request Form -->
                   <h4 class="header-title mb-3"><strong>Submit Document Request</strong></h4>
<form method="post" action="<?= base_url('request/submit_request') ?>">
    <div class="form-group">
        <label for="document_type">Document Type</label>
        <select name="document_type" id="document_type" class="form-control" required>
            <option value="">-- Select Document --</option>
            <?php foreach ($doc_types as $dt): ?>
                <option value="<?= $dt->document_name ?>"><?= $dt->document_name ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="purpose">Purpose</label>
        <textarea name="purpose" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit Request</button>
</form>


                    <hr>

                    <!-- Document Requests Table in Card -->
                    <div class="card mt-4">
                        <div class="card-header bg-info text-white">
                            <strong>Document Request History</strong>
                        </div>
                        <div class="card-body">
                             <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
        <tr>
            <th>Document</th>
            <th>Purpose</th>
            <th>Status</th>
            <th>View Movement</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requests as $r): ?>
        <tr>
            <td><?= $r->document_type ?></td>
            <td><?= $r->purpose ?></td>
            <td><span class="badge badge-info"><?= $r->status ?></span></td>
            <td>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#movementModal<?= $r->id ?>">Track</button>

                <!-- Modal -->
                <div class="modal fade" id="movementModal<?= $r->id ?>" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Request Movement - <?= $r->document_type ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Updated By</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $logs = $this->RequestModel->get_logs_by_request($r->id); 
                                if (!empty($logs)):
                                    foreach ($logs as $log): ?>
                                        <tr>
                                            <td><?= $log->status ?></td>
                                            <td><?= $log->remarks ?></td>
                                            <td><?= $log->updated_by ?></td>
                                            <td><?= date('M d, Y h:i A', strtotime($log->updated_at)) ?></td>
                                        </tr>
                                    <?php endforeach; 
                                else: ?>
                                    <tr><td colspan="4" class="text-center">No history available.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
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