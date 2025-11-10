<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Head section -->
<link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

<style>


 .select2-container--default .select2-selection--single {
        height: 35px; /* taller dropdown */
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 8px 12px;
        font-size: 14px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        color: #495057;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
        top: 0px;
        right: 8px;
    }

    /* Make the form row align better vertically */
    .select2-container {
        width: 100% !important;
    }

        .print-only {
        display: none;
    }


    @media print {

        .print-only {
            display: block;
            margin-bottom: 20px;
        }

        /* Set the paper size and margins for printing */
        @page {
            size: A4;
            margin: 0.5in;
        }

        /* Hide elements that should not appear in print */
        .d-print-none {
            display: none;
        }

        /* Ensure the background is white and remove any unnecessary margins */
        body {
            background-color: #ffffff;
            /* White background */
            margin: 0;
            padding: 0;
        }

        /* Style the table for printing */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            /* Black border for clarity */
            padding: 8px;
            /* Add some padding for better readability */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            /* Light gray background for headers */
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
            /* Alternate row color for better readability */
        }

        h4 {
            margin: 0 0 20px 0;
            /* Adjust margin for the header */
        }

        /* Hide any non-essential content */
        .float-right {
            display: none;
        }

        #upper {
            border: none;
            padding: 0;
            margin: 0;
        }

        #upper tr {
            padding: 0px;
            margin: 0px;
        }
    }
</style>

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
                                <h4 class="page-title">STUDENTS' ACCOUNTS<br />
                                    <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                </h4>


                                <!-- Search Box -->
                                <form action="<?php echo base_url('Accounting/SearchStudeAccounts'); ?>" method="POST">
                                    <div class="row mb-6">
                                        <div class="col-md-6">
                                             <select name="StudentNumber" id="StudentNumber" class="form-control select2">
                                <option value="">Select Student</option>
                                <?php foreach ($stude as $stude) { ?>
                                    <option value="<?= $stude->StudentNumber; ?>"><?=$stude->StudentNumber; ?> <?=$stude->FirstName; ?> <?=$stude->MiddleName; ?> 
                                    <?=$stude->LastName; ?></option>
                                <?php } ?>
                            </select>  
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>




                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>

                                <!-- Display Flash Messages -->
                                <?php if ($this->session->flashdata('msg')): ?>
                                    <div class="alert">
                                        <?php echo $this->session->flashdata('msg'); ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>


                    <!-- end page title -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">


                                  <?php if (!empty($data)) : ?>
    <table class="table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Student No.</th>
                <th>Year Level</th>
                <th style="text-align:right">Total Acct.</th>
                <th style="text-align:right">Discount</th>
                <th style="text-align:right">Payments</th>
                <th style="text-align:right">Balance</th>
                <th style="text-align:center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $row['StudentName']; ?></td>
                    <td><?= $row['StudentNumber']; ?></td>
                    <td><?= $row['YearLevel']; ?></td>
                    <td style="text-align:right"><?= number_format($row['AcctTotal'], 2); ?></td>
                    <td style="text-align:right"><?= number_format($row['Discount'], 2); ?></td>
                    <td style="text-align:right"><?= number_format($row['TotalPayments'], 2); ?></td>
                    <td style="text-align:right"><?= number_format($row['CurrentBalance'], 2); ?></td>
                    <td style="text-align:center">
                        <a href="<?= base_url('Page/state_Account_Accounting?id=' . $row['StudentNumber']); ?>" class="text-secondary mx-1" data-toggle="tooltip" title="Statement of Account">
                            <i class="fas fa-file-invoice fa-md"></i>
                        </a>
                        <a href="<?= base_url('Accounting/addFeesToStudentAccount/' . $row['StudentNumber']); ?>" class="text-primary mx-1" data-toggle="tooltip" title="Add fees">
                            <i class="fas fa-plus-circle fa-md"></i>
                        </a>
                        <a href="<?= base_url('Accounting/editStudentAccount/' . $row['AccountID']); ?>" class="text-success mx-1" data-toggle="tooltip" title="Add discount">
                            <i class="fas fa-percent fa-md"></i>
                        </a>
                        <a href="<?= base_url('Accounting/deleteStudentAccount/' . $row['StudentNumber']); ?>" class="text-danger mx-1" onclick="return confirm('Are you sure you want to delete this account?');" data-toggle="tooltip" title="Delete student account">
                            <i class="fas fa-trash-alt fa-md"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-warning">No student account data found for the selected student.</div>
<?php endif; ?>
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

        <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

        <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>

</body>

</html>