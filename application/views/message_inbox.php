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
                                <!-- <h4 class="page-title">Submit Request</h4> -->
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li> -->
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
                                    <!--<h4 class="m-t-0 header-title mb-4"><b>REQUEST SUBMISSION</b></h4>-->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3 class="mb-4">📥 Inbox</h3>

                                            <?php if ($this->session->flashdata('success')): ?>
                                                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                                            <?php endif; ?>

                                            <div class="mb-4">

                                                <div class="container mt-4">

                                                    <div class="list-group">
                                                        <?php foreach ($messages as $msg): ?>
                                                            <a href="<?= site_url('messages/view/' . $msg->id) ?>"
                                                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
               <?= ($msg->is_read == 0) ? 'fw-bold' : ''; ?>">

                                                                <div class="d-flex flex-column">
                                                                    <div class="d-flex align-items-center mb-1">
                                                                        <span class="me-2 badge <?= ($msg->is_read == 0) ? 'bg-primary' : 'bg-secondary'; ?>">
                                                                            <?= ($msg->is_read == 0) ? 'New' : 'Read'; ?>
                                                                        </span>
                                                                        <span><?= $msg->subject ?></span>
                                                                    </div>
                                                                    <small class="text-muted">From: <?= $msg->sender_id ?> • <?= date('M d, Y h:i A', strtotime($msg->created_at)) ?></small>
                                                                </div>

                                                                <div>
                                                                    <i class="bi bi-chevron-right"></i> <!-- Optional right arrow icon -->
                                                                </div>

                                                            </a>
                                                        <?php endforeach; ?>

                                                        <?php if (empty($messages)): ?>
                                                            <div class="text-center text-muted mt-4">
                                                                No messages found.
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>


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

    <!-- Script to hide completed tasks -->
    <script>
        let completedVisible = true;

        function toggleCompletedTasks() {
            const completedTasks = document.querySelectorAll('.completed-task');
            const toggleBtn = document.getElementById('toggle-completed-btn');

            completedTasks.forEach(task => {
                task.style.display = completedVisible ? 'none' : '';
            });

            // Toggle button text
            toggleBtn.textContent = completedVisible ? 'Show All Completed Tasks' : 'Hide All Completed Tasks';

            // Flip the flag
            completedVisible = !completedVisible;
        }
    </script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>




</body>

</html>