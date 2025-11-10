<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<?php
// ===== Safe esc helper to avoid "Passing null to htmlspecialchars()" warnings
if (!function_exists('esc')) {
    function esc($v) { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
}

// Normalize flags/values so the view never notices undefined vars.
$isFlagged         = isset($isFlagged) ? (bool)$isFlagged : false;
$overdueMonthsText = isset($overdueMonthsText) ? (string)$overdueMonthsText : '';
$currSY            = (string)($this->session->userdata('sy') ?? '');
$studId            = (string)($this->session->userdata('username') ?? '');
$semesterLabel     = (string)($this->session->userdata('semester') ?? '');
$soaUrl            = site_url('Page/state_Account') . '?id=' . rawurlencode($studId) . '&sy=' . rawurlencode($currSY);
?>

<body>

  <!-- Begin page -->
  <div id="wrapper">

    <!-- Topbar Start -->
    <?php include('includes/top-nav-bar.php'); ?>
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    <?php include('includes/sidebar.php'); ?>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">

      <?php if ($isFlagged): ?>
        <!-- ===== Deactivation Notice (block dashboard) ===== -->
        <div class="content">
          <div class="container-fluid">

            <div class="page-title-box">
              <h4 class="page-title">STUDENT'S DASHBOARD</h4>
              <div class="clearfix"></div>
              <hr style="border: 0; height: 4px; background: linear-gradient(to right, #4285F4 50%, #DB4437 16%, #F4B400 17%, #0F9D58 17%);" />
            </div>

            <div class="alert alert-danger mt-3" role="alert" style="font-size:15px;">
              <strong>Notice:</strong>
              Your account has been deactivated due to overdue payment in the selected School Year
              (SY <?= esc($currSY); ?>)
              <?php if ($overdueMonthsText !== ''): ?>
                for the month<?= (strpos($overdueMonthsText, ',') !== false ? 's' : '') ?>:
                <strong><?= esc($overdueMonthsText); ?></strong>.
              <?php else: ?>
                .
              <?php endif; ?>
            </div>

            <div class="card mt-3">
              <div class="card-body">
                Please refer to your
                <a href="<?= $soaUrl; ?>" class="alert-link">Statement of Account</a>
                to view your payable balances for SY <strong><?= esc($currSY); ?></strong> to reactivate your account.
                <div class="mt-2">
                  <a href="<?= $soaUrl; ?>" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-file-document-outline"></i> Open Statement of Account
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Footer Start -->
        <?php include('includes/footer.php'); ?>
        <!-- end Footer -->

      <?php else: ?>
        <!-- ===== Normal Dashboard (shown when NOT deactivated) ===== -->
        <div class="content">
          <!-- Start Content-->
          <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
              <div class="col-12">
                <div class="page-title-box">
                  <h4 class="page-title">STUDENT'S DASHBOARD</h4>
                  <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                      <li class="breadcrumb-item">
                        <a href="#">
                          Currently login to <b>SY <?= esc($currSY); ?> <?= esc($semesterLabel); ?></b>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="#">
                          Status:
                          <span style="color:red;"><b>
                            <?php
                              // $data1 = studeEnrollStat($id, $sy)
                              if (empty($data1)) {
                                echo 'Not Enrolled';
                              } else {
                                echo esc($data1[0]->Status ?? '');
                              }
                            ?></b></span>
                        </a>
                      </li>
                    </ol>
                  </div>
                  <div class="clearfix"></div>

                  <hr style="border: 0; height: 4px; background: linear-gradient(to right, #4285F4 50%, #DB4437 16%, #F4B400 17%, #0F9D58 17%);" />
                </div>
              </div>
            </div>
            <!-- end page title -->

            <div class="row">
              <div class="col-sm-6 col-xl-3">
                <div class="card bg-primary">
                  <div class="card-body text-center">
                    <div class="h2 mt-2 text-white">
                      <a href="<?= base_url('EmailBlast/inbox'); ?>" class="text-white"><?= (int)($unreadCount ?? 0); ?></a>
                    </div>
                    <span class="mb-2 text-white">
                      <a href="<?= base_url('EmailBlast/inbox'); ?>" class="text-white">Unread Messages</a>
                    </span>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-xl-3">
                <div class="card bg-success">
                  <div class="card-body text-center">
                    <a href="<?= base_url('Masterlist/COR'); ?>">
                      <div class="h2 mt-2 text-white">
                        <?php
                          // $data4 = studeTotalSubjects($id, $sem, $sy)
                          if (empty($data4)) {
                            echo '0';
                          } else {
                            echo esc($data4[0]->subjectCounts ?? '0');
                          }
                        ?>
                      </div>
                      <span class="mb-2 text-white">Enrolled Subjects</span>
                    </a>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-xl-3">
                <div class="card bg-warning">
                  <div class="card-body text-center">
                    <a href="<?= base_url('Page/studeEnrollHistory'); ?>">
                      <div class="h2 mt-2 text-white">
                        <?php
                          // $data3 = semStudeCount($id)
                          if (empty($data3)) {
                            echo '0';
                          } else {
                            echo esc($data3[0]->SemesterCounts ?? '0');
                          }
                        ?>
                      </div>
                      <span class="mb-2 text-white">Total Semesters/SY Enrolled</span>
                    </a>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-xl-3">
                <div class="card bg-purple">
                  <div class="card-body text-center">
                    <div class="h2 mt-2 text-white">
                      <?php
                        // $data2 = studeBalance($id, $sy)
                        if (empty($data2)) {
                          echo '0.00';
                        } else {
                          echo number_format((float)($data2[0]->CurrentBalance ?? 0), 2);
                        }
                      ?>
                    </div>
                    <span class="mb-2 text-white">Current Balance</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Announcements -->
            <div class="row">
              <div class="col-md-12">
                <?php if (!empty($data)): ?>
                  <?php foreach ($data as $row): ?>
                    <div class="card">
                      <div class="card-header py-3 bg-transparent">
                        <div class="card-widgets">
                          <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                          <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                          <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h5 class="header-title mb-0">Announcement</h5>
                      </div>
                      <div id="cardCollpase1" class="collapse show">
                        <div class="card-body">
                          <img
                            src="<?= base_url('upload/announcements/' . esc($row->announcement ?? '')); ?>"
                            class="img-fluid" alt="Announcement"
                            style="width:100%;height:100%;">
                        </div>
                        <div class="card-footer">_</div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="card">
                    <div class="card-body">
                      <em>No announcements available.</em>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>

          </div><!-- container -->
        </div><!-- content -->

        <!-- Footer Start -->
        <?php include('includes/footer.php'); ?>
        <!-- end Footer -->
      <?php endif; ?>

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
  <script src="<?= base_url(); ?>assets/js/pages/calendar.init.js"></script>

  <script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>
  <script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>

  <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>

  <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

  <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>

  <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

  <script src="<?= base_url(); ?>assets/libs/jquery-ui/jquery-ui.min.js"></script>
  <!-- Datatables -->
  <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

</body>
</html>
