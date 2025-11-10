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
                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show shadow-lg mt-3 p-3" role="alert" id="flash-success" style="font-size: 1.2rem; font-weight: 500;">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <?php echo $this->session->flashdata('success'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="font-size: 1.5rem;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <script>
                                        // Auto-dismiss after 5 seconds
                                        setTimeout(function() {
                                            let alert = document.getElementById('flash-success');
                                            if (alert) {
                                                alert.classList.remove('show');
                                                alert.classList.add('fade');
                                                setTimeout(() => alert.remove(), 500); // Fully remove after fade
                                            }
                                        }, 5000);
                                    </script>
                                <?php endif; ?>

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

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- Required datatable js -->
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

</body>

</html>