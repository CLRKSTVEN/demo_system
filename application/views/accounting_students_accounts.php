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

        <img class="print-only" src="<?= base_url(); ?>upload/banners/<?php echo $letterhead[0]->letterhead_web; ?>" alt="mySRMS Portal" width="100%">


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
                    <div class="d-print-none">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="GET">
                                            <div class="row g-2 align-items-center">
                                                <!-- Grade Level Dropdown -->
                                                <div class="col-md-4">
                                                    <select name="yearlevel" id="yearlevel" class="form-control">
                                                        <option value="">Select Grade Level</option>
                                                        <?php foreach ($level as $row): ?>
                                                            <option value="<?= $row->Major; ?>"><?= $row->Major; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- View Button -->
                                                <div class="col-md-2">
                                                    <button type="submit" name="submit" class="btn btn-primary w-100">View</button>
                                                </div>

                                                <div class="col-md-2">
                                                    <a href="<?= base_url(); ?>Accounting/AddstudeAccounts" class="btn btn-info w-100">
                                                        <i class="fas fa-stream mr-1"></i> Add New
                                                    </a>
                                                </div>


                                                <!-- Include Font Awesome -->
                                                <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-bars me-2"></i> Actions
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li>
                                                            <a class="dropdown-item" href="<?= base_url(); ?>Accounting/calculateDiscounts">
                                                                <i class="fas fa-percent me-2 text-success"></i> Calculate Total Discounts
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="<?= base_url(); ?>Accounting/calculateAddFees">
                                                                <i class="fas fa-plus-circle me-2 text-primary"></i> Calculate Additional Fees
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="<?= base_url(); ?>Accounting/getTotalPayments">
                                                                <i class="fas fa-money-bill-wave me-2 text-info"></i> Calculate Payments
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="<?= base_url(); ?>Accounting/calculateBalance">
                                                                <i class="fas fa-balance-scale me-2 text-warning"></i> Calculate Balance
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= base_url('Page/massUpdateMonthlySchedule') ?>"
                                                                class="dropdown-item"
                                                                onclick="return confirm('Are you sure you want to auto-generate monthly schedules for all students with partial payments?');">
                                                                <i class="fas fa-cogs me-2 text-secondary"></i> Generate Monthly Schedules (Mass)
                                                            </a>
                                                        </li>

                                                          <li>
                                                          <a href="<?= base_url('Accounting/massUpdateFeesRecords') ?>" class="dropdown-item" onclick="return confirm('Proceed with mass update of missing feesrecords?')">
                                                            🔄 Mass Update Fees Records
                                                        </a>

                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Include Bootstrap Bundle JS -->
                                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


                                            </div>


                                        </form>

                                        <script>
                                            document.getElementById('course')?.addEventListener('change', function() {
                                                const course = this.value;

                                                if (course) {
                                                    fetch('<?= base_url('Accounting/studeAccounts'); ?>?course=' + course)
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            const yearLevelSelect = document.getElementById('yearlevel');
                                                            yearLevelSelect.innerHTML = '<option value="">Select Grade Level</option>';

                                                            data.forEach(level => {
                                                                const option = document.createElement('option');
                                                                option.value = level.Major;
                                                                option.textContent = level.Major;
                                                                yearLevelSelect.appendChild(option);
                                                            });
                                                        })
                                                        .catch(error => console.error('Error fetching levels:', error));
                                                } else {
                                                    document.getElementById('yearlevel').innerHTML = '<option value="">Select Grade Level</option>';
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <!-- end page title -->
                    <div class="row">
                        <?php if (isset($_GET["submit"])) { ?>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="m-t-0 header-title mb-4"><b>Students' Accounts</b></h4>

                                        <div class="mb-3">
                                            <table>
                                                <tr>
                                                    <td style="border: none;">Year Level</td>
                                                    <td style="border: none;">: <b><?php echo $_GET['yearlevel']; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: none;">SY</td>
                                                    <td style="border: none;">: <b><?php echo $this->session->userdata('semester'); ?> <?php echo $this->session->userdata('sy'); ?></b></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover" id="studentAccountsTable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Name</th>
                                                        <th>Student No.</th>
                                                        <th>Year Level</th>
                                                        <th class="text-end">Total Acct.</th>
                                                        <th class="text-end">Discount</th>
                                                        <th class="text-end">Payments</th>
                                                        <th class="text-end">Balance</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $counter = 1;
                                                    foreach ($data as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $counter++; ?></td>
                                                            <td><?php echo $row->StudentName; ?></td>
                                                            <td><?php echo $row->StudentNumber; ?></td>
                                                            <td><?php echo $row->YearLevel; ?></td>
                                                            <td class="text-end">

                                                                <?= $row->AcctTotal; ?>

                                                            </td>
                                                            <td class="text-end"><?= $row->Discount; ?></td>
                                                            <td class="text-end">

                                                                <?= $row->TotalPayments; ?>

                                                            </td>
                                                            <td class="text-end"><?= $row->CurrentBalance; ?></td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url('Page/state_Account_Accounting?id=' . $row->StudentNumber); ?>" class="text-secondary mx-1" data-toggle="tooltip" title="Statement of Account">
                                                                    <i class="fas fa-file-invoice fa-md"></i>
                                                                </a>

                                                                <a href="<?= base_url('Accounting/addFeesToStudentAccount/' . $row->StudentNumber); ?>" class="text-primary mx-1" data-toggle="tooltip" title="Add fees">
                                                                    <i class="fas fa-plus-circle fa-md"></i>
                                                                </a>
                                                                <a href="<?= base_url('Accounting/editStudentAccount/' . $row->AccountID); ?>" class="text-success mx-1" data-toggle="tooltip" title="Add discount">
                                                                    <i class="fas fa-percent fa-md"></i>
                                                                </a>
                                                                <a href="<?= base_url('Accounting/deleteStudentAccount/' . $row->StudentNumber); ?>" class="text-danger mx-1" onclick="return confirm('Are you sure you want to delete this account?');" data-toggle="tooltip" title="Delete student account">
                                                                    <i class="fas fa-trash-alt fa-md"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive -->

                                        <!-- Export to CSV Button -->
                                        <div class="text-end mt-3">
                                            <button class="btn btn-success" onclick="exportTableToCSV('student_accounts.csv')">
                                                <i class="fas fa-file-csv"></i> Export to CSV
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- JavaScript for CSV Export -->
                    <script>
                        function downloadCSV(csv, filename) {
                            const csvFile = new Blob([csv], {
                                type: "text/csv"
                            });
                            const downloadLink = document.createElement("a");
                            downloadLink.download = filename;
                            downloadLink.href = window.URL.createObjectURL(csvFile);
                            downloadLink.style.display = "none";
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                        }

                        function exportTableToCSV(filename) {
                            const rows = document.querySelectorAll("#studentAccountsTable tr");
                            let csv = [];

                            rows.forEach(row => {
                                const cols = row.querySelectorAll("td, th");
                                let rowData = [];
                                cols.forEach(col => {
                                    // Remove links and get plain text
                                    let text = col.innerText.replace(/\n/g, " ").replace(/,/g, " ").trim();
                                    rowData.push('"' + text + '"');
                                });
                                csv.push(rowData.join(","));
                            });

                            downloadCSV(csv.join("\n"), filename);
                        }
                    </script>


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
        <!-- Vendor js -->
        <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

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