<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<style>
    /* Print Styling */
    @media print {

        body,
        .card,
        .table {
            background-color: white;
            color: black;
            width: 100%;
            line-height: 1.5;
            /* Increased line-height for readability */
            font-family: Arial, sans-serif;
            /* Use a cleaner font */
        }

        .table {
            border-collapse: collapse;
            /* Collapse borders for a cleaner look */
            width: 100%;
            margin-top: 20px;
            /* Space above the table */
        }

        .table th,
        .table td {
            font-size: 12px;
            /* Font size for table */
            padding: 10px;
            /* Padding for table cells */
            border: 1px solid #ddd;
            /* Light border for cells */
            text-align: center;
            /* Centered text */
        }

        .table th {
            background-color: #f7f7f7;
            /* Light background for header */
            font-weight: bold;
            /* Bold header text */
        }

        .card-header {
            background-color: white;
            /* White background for card header */
            color: black;
            border: none;
            text-align: center;
            /* Centered title */
            padding: 15px;
            /* Padding for header */
        }

        @page {
            size: A4;
            margin: 0.5in;
            /* Page margins */
        }

        .print-only {
            display: block !important;
            margin: 15px 0;
            /* Margin for print-only elements */
            font-size: 15px;
            /* Font size */
            text-align: center;
            /* Centered text */
        }

        /* Hide elements not needed during print */
        .no-print,
        .btn,
        .card-footer {
            display: none !important;
            /* Hide buttons and footers */
        }

        /* Additional styling for print */
        h4 {
            margin-bottom: 20px;
            /* Space below heading */
            text-align: center;
            /* Centered heading */
            font-size: 24px;
            /* Increased font size for PAYMENT HISTORY */
            font-weight: bold;
            /* Bold text */
        }

        strong {
            display: none;
            /* Hide strong tags */
        }

        /* Total row styling */
        .total-row {
            border: none;
            font-weight: bold;
            /* Bold text */
            background-color: #e8f5e9;
            /* Light green background for total */
            border: none;
            /* Remove border */
        }

        /* Additional spacing */
        .mb-3 {
            margin-bottom: 15px;
            /* Margin below elements */
        }

        /* Style for the total payments row */
        .total-payments {
            border: none;
        }
    }

    /* Default styling */
    .float-right {
        float: right;
        /* Float right utility */
    }

    img {
        display: none;
        /* Hide images */
    }

    .print-only {
        display: none;
        /* Hide print-only elements */
    }
</style>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->

        <!-- Left Sidebar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">

                <!-- Start Content -->
                <div class="container-fluid">

                

                    <!-- Start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title" id="print-only">DISCOUNT HISTORY <br />
                                    <span class="badge badge-purple mb-1"><b><?php echo $this->session->userdata('semester'); ?> SY <?php echo $this->session->userdata('sy'); ?> </b></span>
                                    
                                </h4>

                                
                                <div class="page-title-right">
                                    
                                    <ol class="breadcrumb p-0 m-0"></ol>
                                    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- End page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <img class="print-only" src="<?= base_url(); ?>upload/banners/<?php echo $letterhead[0]->letterhead_web; ?>" alt="mySRMS Portal" width="100%">

                            <div class="card">
                                <div class="card-header">
                                    <b class="print-only">DISCOUNT HISTORY</b>

                                    <!-- Add Discount Button -->
<!-- <button class="btn btn-primary" data-toggle="modal" data-target="#addDiscountModal">Add Discount</button> -->

<script>
    function editDiscount(disID, desc, amount) {
        document.getElementById("discount-id").value = disID;
        document.getElementById("discount-desc").value = desc;
        document.getElementById("discount-amount").value = amount;
        $('#editDiscountModal').modal('show');
    }
</script>


<br>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


                                </div>
                                <div class="card-body table-responsive">
                                    <!-- <div class="mb-3 no-print">
                                        <button class="btn btn-secondary waves-effect waves-light btn-sm" style="float: right;" onclick="window.print()">Print</button>
                                    </div> -->

                                    <table>
                                        <tr>
                                            <td>Student Name</td>
                                            <td>: <b><?php echo isset($data[0]) ? htmlspecialchars($data[0]->StudentName) : 'N/A'; ?></b></td>
                                        </tr>
                                        <!-- <tr>
                                            <td>Grade Level</td>
                                            <td>: <b><?php echo isset($data[0]) ? htmlspecialchars($data[0]->YearLevel) : 'N/A'; ?></b></td>
                                        </tr> -->
                                    </table>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Discount Description</th>
                                                <th>Discount Amount</th>
                                                <th>Manage</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (empty($data)): ?>
    <tr>
        <td colspan="4" style="text-align: center;">No records found</td>
    </tr>
<?php else: ?>
    <?php
    $totalAmount = 0;
    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row->discount_desc) . "</td>";
        echo "<td>" . htmlspecialchars($row->discount_amount) . "</td>";
        echo "<td>
                <button class='btn btn-sm btn-warning' onclick='editDiscount($row->disID, \"" . addslashes($row->discount_desc) . "\", $row->discount_amount)'>Edit</button>
                <a href='" . base_url('Page/deleteDiscount/' . $row->disID) . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
              </td>";
        echo "</tr>";

        $totalAmount += (float)$row->discount_amount;
    }
    ?>
    <tr class="total-row">
        <td class="total-payments">Total Payments:</td>
        <td colspan="3" class="total-payments" style="text-align: left;">
            <?php echo number_format($totalAmount, 2); ?>
        </td>
    </tr>
<?php endif; ?>

</tbody>

                                    </table>
                                </div>
                                <!-- /.card-body -->

                            </div><!-- /.card -->
                        </div><!-- /.col-md-12 -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->

            </div><!-- /.content -->
























            <!-- Add Discount Modal -->
<div id="addDiscountModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Discount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('Page/addDiscount'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="studentno" value="<?php echo $data[0]->StudentNumber ; ?>">
                    <input type="hidden" name="sy" value="<?php echo $data[0]->SY ; ?>">
                    
                    <div class="form-group">
                        <label>Discount Description:</label>
                        <input type="text" name="discount_desc" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Discount Amount:</label>
                        <input type="number" name="discount_amount" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Discount</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Discount Modal -->
<div id="editDiscountModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Discount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-form" action="<?php echo base_url('Page/updateDiscount'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="disID" id="discount-id">
                    <input type="hidden" name="studentno" value="<?php echo $data[0]->StudentNumber ; ?>">
                    <input type="hidden" name="sy" value="<?php echo $data[0]->SY ; ?>">
                    <div class="form-group">
                        <label>Discount Description:</label>
                        <input type="text" name="discount_desc" id="discount-desc" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Discount Amount:</label>
                        <input type="number" name="discount_amount" id="discount-amount" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Discount</button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div><!-- /.content-page -->

        <!-- Footer Start -->
        <?php include('includes/footer.php'); ?>
        <!-- end Footer -->

    </div><!-- END wrapper -->

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