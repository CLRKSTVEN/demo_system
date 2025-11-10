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
                <h4 class="page-title">Change Login Page Image</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li>
                  </ol>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>

          <!-- end page title -->
          <div class="row">
            <div class="col-md-12">
              <div class="card card-info">
                <h4 class="m-t-0 header-title mb-4"><?php echo $this->session->flashdata('msg'); ?></h4>

                <form role="form" action="<?php echo ('uploadloginFormImage'); ?>" enctype='multipart/form-data' method="POST">
                  <input type="hidden" class="form-control" name="StudentNumber" value="<?php echo $this->session->userdata('username'); ?>" readonly required>
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-8 form-group">
                        <label>Login Image</label>
                        <input type="file" class="form-control" name="nonoy" required>
                        <p>Limit the size to <span style="color:red; font-weight:bold">2MB only</span>. The recommended size is <span style="color:red; font-weight:bold">787px by 663px</span>.</p>
                      </div>

                    </div>
                    <input type="submit" name="submit" class="btn btn-info" value="Upload">
                  </div>




                  <div class="card-footer">


                  </div>
                </form>

                <form role="form" action="<?php echo ('uploadloginLogo'); ?>" enctype='multipart/form-data' method="POST">
                  <input type="hidden" class="form-control" name="StudentNumber" value="<?php echo $this->session->userdata('username'); ?>" readonly required>
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-8 form-group">
                        <label>Login Logo</label>
                        <input type="file" class="form-control" name="nonoy" required>
                        <!-- <p>Limit the size to <span style="color:red; font-weight:bold">2MB only</span>.  The recommended size is <span style="color:red; font-weight:bold">787px by 663px</span>.</p> -->
                      </div>

                    </div>
                    <input type="submit" name="submit" class="btn btn-info" value="Upload">
                  </div>




                  <div class="card-footer">


                  </div>
                </form>
                <form role="form" action="<?php echo ('uploadletterhead'); ?>" enctype='multipart/form-data' method="POST">
                  <input type="hidden" class="form-control" name="StudentNumber" value="<?php echo $this->session->userdata('username'); ?>" readonly required>
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-8 form-group">
                        <label>Letter Head</label>
                        <input type="file" class="form-control" name="nonoy" required>
                        <!-- <p>Limit the size to <span style="color:red; font-weight:bold">2MB only</span>.  The recommended size is <span style="color:red; font-weight:bold">787px by 663px</span>.</p> -->
                      </div>

                    </div>
                    <input type="submit" name="submit" class="btn btn-info" value="Upload">
                  </div>




                  <div class="card-footer">


                  </div>
                </form>
                <!-- ===== Report Card Branding (SF9) – LEFT / RIGHT / SEAL ===== -->
                <form role="form" action="<?= site_url('shs_report/rc_upload/left'); ?>" enctype="multipart/form-data" method="POST">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-8 form-group">
                        <label>Report Card Logo (Left)</label>
                        <input type="file" class="form-control" name="nonoy" required>
                        <small class="text-muted">PNG/JPG/GIF/WebP. Prints ~85–90px tall.</small>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-info" value="Upload Left Logo">
                  </div>
                </form>
                <!-- 
<form role="form" action="<?= site_url('shs_report/rc_upload/right'); ?>" enctype="multipart/form-data" method="POST">
  <div class="card-body">
    <div class="row">
      <div class="col-md-8 form-group">
        <label>Report Card Logo (Right)</label>
        <input type="file" class="form-control" name="nonoy" required>
      </div>
    </div>
    <input type="submit" class="btn btn-info" value="Upload Right Logo">
  </div>
</form> -->

                <form role="form" action="<?= site_url('shs_report/rc_upload/seal'); ?>" enctype="multipart/form-data" method="POST">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-8 form-group">
                        <label>Report Card Seal (Watermark & Top Badge)</label>
                        <input type="file" class="form-control" name="nonoy" required>
                        <small class="text-muted">Prefer transparent PNG ≥ 1200px for crisp watermark.</small>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-info" value="Upload Seal">
                  </div>
                </form>
                <!-- ===== /Report Card Branding ===== -->

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