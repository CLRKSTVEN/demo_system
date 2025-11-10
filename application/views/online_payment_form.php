<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

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
            <div class="content">

                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <h4 class="page-title m-0"></h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <li class="breadcrumb-item">
                                                <span class="badge badge-primary" style="font-size:.95rem;padding:.5rem .75rem;">
                                                    Currently logged in to
                                                    <b>SY <?= html_escape($this->session->userdata('sy')); ?></b>
                                                    &nbsp;|&nbsp;
                                                    <b><?= html_escape($this->session->userdata('semester')); ?></b>
                                                </span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <hr style="border:0;height:2px;background:linear-gradient(to right,#4285F4 60%,#FBBC05 80%,#34A853 100%);border-radius:1px;margin:16px 0;" />
                            </div>
                        </div>
                    </div>

                    <?php
                    // Resolve student number (controller passes $studentNumber; also fallback to session keys)
                    $level             = (string) $this->session->userdata('level');
                    $sessStudentNo1    = (string) $this->session->userdata('studentNumber'); // your controller uses this
                    $sessStudentNo2    = (string) $this->session->userdata('username');      // some views use this
                    $prefillStudentNo  = isset($studentNumber) && $studentNumber ? (string)$studentNumber
                        : ($sessStudentNo1 ?: $sessStudentNo2);
                    $readonly          = ($level === 'Student') ? 'readonly' : '';
                    $hasStudentNo      = ($prefillStudentNo !== '' && $prefillStudentNo !== null);

                    $sy   = (string) $this->session->userdata('sy');
                    $sem  = (string) $this->session->userdata('semester');

                    // History from controller, ensure it’s an array
                    $history = isset($history) && is_array($history) ? $history : [];
                    ?>

                    <!-- Content -->
                    <div class="row">
                        <!-- LEFT: 6-cols Payment Form -->
                        <div class="col-lg-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h5 class="mb-0">Pay Tuition via Dragonpay</h5>
                                        <a href="<?= base_url('Page/studeaccount'); ?>" class="btn btn-outline-secondary btn-sm">
                                            <i class="mdi mdi-arrow-left"></i> Back
                                        </a>
                                    </div>

                                    <?php if ($this->session->flashdata('msg')): ?>
                                        <div class="alert alert-info"><?= $this->session->flashdata('msg'); ?></div>
                                    <?php endif; ?>

                                    <form method="post" action="<?= base_url('OnlinePayment/initiate'); ?>" target="_blank" autocomplete="off">
                                        <?php if ($this->security->get_csrf_token_name()): ?>
                                            <input type="hidden"
                                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                                value="<?= $this->security->get_csrf_hash(); ?>">
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label class="form-label">Student Number</label>
                                            <input type="text"
                                                class="form-control"
                                                name="studentNumber"
                                                value="<?= html_escape($prefillStudentNo); ?>"
                                                <?= $readonly; ?> <?= ($level === 'Student') ? '' : 'required'; ?>
                                                placeholder="Enter Student Number">
                                            <?php if ($level === 'Student'): ?>
                                                <small class="form-text text-muted">This is tied to your logged-in account.</small>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Amount (PHP)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₱</span>
                                                </div>
                                                <input type="number"
                                                    class="form-control"
                                                    name="amount"
                                                    step="0.01" min="1" required
                                                    placeholder="0.00">
                                            </div>
                                            <small class="form-text text-muted">
                                                Enter the amount you wish to pay now. You’ll pick a channel on Dragonpay next.
                                            </small>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4">
                                            <button type="submit" class="btn btn-success">
                                                <i class="mdi mdi-credit-card-outline mr-1"></i> Pay via Dragonpay
                                            </button>


                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="text-muted small mt-2">
                                Having issues? Try refreshing the page or contact the cashier for assistance.
                            </div>
                        </div>

                        <!-- RIGHT: 6-cols Online Payment History -->
                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <h5 class="mb-0">
                                            Online Payment History
                                            <small class="text-muted">
                                                (SY <?= html_escape($sy); ?> • <?= html_escape($sem); ?>)
                                            </small>
                                        </h5>
                                        <?php if ($hasStudentNo): ?>
                                            <span class="badge badge-light">Student: <b><?= html_escape($prefillStudentNo); ?></b></span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!$hasStudentNo): ?>
                                        <div class="alert alert-warning mb-0">
                                            Enter a Student Number to see payment history for the current term.
                                        </div>
                                    <?php elseif (empty($history)): ?>
                                        <div class="alert alert-secondary mb-0">
                                            No online payments found for the current term.
                                        </div>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center" style="width:120px;">Date</th>
                                                        <th>Ref No</th>
                                                        <th>Description</th>
                                                        <th class="text-right" style="width:120px;">Amount</th>
                                                        <th class="text-center" style="width:120px;">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $badge = function ($s) {
                                                        $s = strtolower((string)$s);
                                                        if ($s === 'paid' || $s === 'success') return 'badge-success';
                                                        if ($s === 'pending' || $s === 'processing') return 'badge-warning';
                                                        if ($s === 'failed' || $s === 'cancelled' || $s === 'canceled') return 'badge-danger';
                                                        return 'badge-secondary';
                                                    };
                                                    foreach ($history as $h):
                                                    ?>
                                                        <tr>
                                                            <td class="text-center">
                                                                <?= $h->created_at ? date('Y-m-d', strtotime($h->created_at)) : ''; ?>
                                                            </td>
                                                            <td><?= html_escape($h->refNo); ?></td>
                                                            <td><?= html_escape($h->description); ?></td>
                                                            <td class="text-right">₱<?= number_format((float)$h->amount, 2); ?></td>
                                                            <td class="text-center">
                                                                <span class="badge <?= $badge($h->status); ?>">
                                                                    <?= ucfirst((string)$h->status); ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div> <!-- /.row -->

                </div> <!-- container-fluid -->
            </div> <!-- content -->

            <!-- Footer -->
            <?php include('includes/footer.php'); ?>
            <!-- end Footer -->

        </div> <!-- content-page -->

    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <?php include('includes/themecustomizer.php'); ?>
    <!-- /Right-bar -->

    <!-- Vendor JS and page scripts to match theme -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>

    <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>

    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>

</html>