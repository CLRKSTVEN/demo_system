<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<?php
// Safe HTML helper to avoid PHP 8.1 null warnings
if (!function_exists('h')) {
    function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
}
?>

<body>
<div id="wrapper">
    <?php include('includes/top-nav-bar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <style>
        /* Light touch to make the header stand out a bit */
        .sub-hero {
            background: linear-gradient(135deg, #e0f2ff 0%, #cfeaff 50%, #b9e1ff 100%);
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 16px;
            border: 1px solid rgba(0,0,0,.06);
        }
    </style>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Online Enrollees for Admission</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb p-0 m-0">
                                    <li class="breadcrumb-item">
                                        Currently login to <b>SY <?= h($this->session->userdata('sy')) ?> <?= h($this->session->userdata('semester')) ?></b>
                                    </li>
                                </ol>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <!-- Flash Message -->
                <?php if ($this->session->flashdata('msg')): ?>
                    <div class="row">
                        <div class="col-12">
                            <?= $this->session->flashdata('msg'); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="sub-hero">
                            Review and accept students whose online enrollment status is <b>For Validation</b>.
                        </div>

                        <div class="card">
                            <div class="card-body table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Course</th>
                                        <th>Year Level</th>
                                        <th>SY</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($data) && is_array($data)): ?>
                                        <?php foreach ($data as $row): ?>
                                            <tr>
                                                <td><?= h($row->LastName) ?></td>
                                                <td><?= h($row->FirstName) ?></td>
                                                <td><?= h($row->MiddleName) ?></td>
                                                <td><?= h($row->Course) ?></td>
                                                <td><?= h($row->YearLevel) ?></td>
                                                <td><?= h($row->SY) ?></td>
                                                <td class="col-sm-.5" style="text-align:center; white-space: nowrap;">
                                                    <a
                                                        href="<?= base_url(); ?>page/enrollmentAcceptance?id=<?= h($row->StudentNumber) ?>
                                                            &FName=<?= rawurlencode($row->FirstName ?? '') ?>
                                                            &MName=<?= rawurlencode($row->MiddleName ?? '') ?>
                                                            &LName=<?= rawurlencode($row->LastName ?? '') ?>
                                                            &Course=<?= rawurlencode($row->Course ?? '') ?>
                                                            &YearLevel=<?= rawurlencode($row->YearLevel ?? '') ?>
                                                            &sy=<?= rawurlencode($row->SY ?? '') ?>
                                                            &strand=<?= rawurlencode($row->strand ?? '') ?>"
                                                        class="btn btn-primary btn-xs">
                                                        Enroll
                                                    </a>
                                                    <a href="<?= base_url(); ?>studentsprofile?id=<?= h($row->StudentNumber) ?>" class="btn btn-warning btn-xs">
                                                        Profile
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div> <!-- content -->

        <?php include('includes/footer.php'); ?>
    </div> <!-- content-page -->
</div> <!-- wrapper -->

<?php include('includes/themecustomizer.php'); ?>

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
