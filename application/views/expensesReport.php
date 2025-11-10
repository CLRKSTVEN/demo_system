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
                        <h4 class="page-title">
                        <!-- <a href="<?= base_url(); ?>Accounting/Addexpenses">    
                        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fas fa-stream mr-1"></i> <span>Add New</span> </button>
                        </a> -->
                            <!-- EXPENSES REPORT -->
                        </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb p-0 m-0">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        <!-- <span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span></b> -->
                                    </a>
                                </li>
                            </ol>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>





            <!-- start row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header bg-info py-3 text-white">
                        <!-- <h5>EXPENSES REPORT</h5> -->
                    <strong>EXPENSES REPORT</strong></div>
                        <div class="card-body">
                            <div class="clearfix">

                        <!-- Start Form Section -->
<div class="row mb-3">
    <!-- Dropdown to select Category -->
    <div class="col-lg-3">
        <label for="selectCategory">Select Category:</label>
        <select id="selectCategory" class="form-control">
            <option value="">All Categories</option>
            <?php
            // Assuming $categories is an array of categories fetched from the database
            foreach ($categories as $Category) {
                echo '<option value="' . $Category . '">' . $Category . '</option>';
            }
            ?>
        </select>
    </div>

    <!-- Textbox to filter data based on Expense Date range -->
    <div class="col-lg-3">
        <label for="filterFromDate">From:</label>
        <input type="date" id="filterFromDate" class="form-control">
    </div>

    <div class="col-lg-3">
        <label for="filterToDate">To:</label>
        <input type="date" id="filterToDate" class="form-control">
    </div>
</div>
<!-- End Form Section -->


                                

                             <!-- Existing Expenses Table -->
<div class="table-responsive">
    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Description</th>
                <th>Responsible</th>
                <th>Expense Date</th>
                <th>Category</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) { ?>
            <tr>
                <td><?= $row->Description; ?></td>
                <td><?= $row->Responsible; ?></td>
                <td><?= $row->ExpenseDate; ?></td>
                <td><?= $row->Category; ?></td>
                <td><?= $row->Amount; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Summary Table -->
<div class="table-responsive mt-4">
    <table id="summaryTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Description</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="summaryDescription">No data available</td>
                <td id="summaryTotal"><a href="#" id="summaryTotalLink">0.00</a></td>


            </tr>
        </tbody>
    </table>
</div>
</div>

</div>


</div>
</div>
</div>


 

                

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
		
		<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
    // Function to filter the table and update the summary based on the selected category and date range
    function filterTable() {
        var selectedCategory = document.getElementById('selectCategory').value;
        var filterFromDate = document.getElementById('filterFromDate').value;
        var filterToDate = document.getElementById('filterToDate').value;
        var rows = document.querySelectorAll('#datatable tbody tr');
        var totalAmount = 0;
        var description = '';

        rows.forEach(function (row) {
            var rowCategory = row.cells[3].textContent.trim();
            var rowDate = row.cells[2].textContent.trim();
            var rowAmount = parseFloat(row.cells[4].textContent.trim().replace(/,/g, '')); // Assuming Amount is formatted with commas

            // Show/hide rows based on the selected category and date range
            var categoryMatch = selectedCategory === '' || selectedCategory === rowCategory;
            var fromDateMatch = filterFromDate === '' || new Date(rowDate) >= new Date(filterFromDate);
            var toDateMatch = filterToDate === '' || new Date(rowDate) <= new Date(filterToDate);

            if (categoryMatch && fromDateMatch && toDateMatch) {
                row.style.display = '';
                totalAmount += rowAmount;
            } else {
                row.style.display = 'none';
            }
        });

        // Update summary
        var summaryTotalLink = document.getElementById('summaryTotalLink');
        if (totalAmount > 0) {
            var fromDateFormatted = filterFromDate ? new Date(filterFromDate).toLocaleDateString() : '';
            var toDateFormatted = filterToDate ? new Date(filterToDate).toLocaleDateString() : '';
            description = fromDateFormatted + ' - ' + toDateFormatted;
            document.getElementById('summaryDescription').textContent = 'Expenses from ' + description;
            summaryTotalLink.textContent = totalAmount.toFixed(2);

            // Update the href of the link
            summaryTotalLink.href = "<?= base_url('Accounting/expenseSGenerate'); ?>" + 
                        "?category=" + encodeURIComponent(selectedCategory) + 
                        "&from=" + encodeURIComponent(filterFromDate) + 
                        "&to=" + encodeURIComponent(filterToDate);

            summaryTotalLink.style.pointerEvents = 'auto'; // Enable clicking
        } else {
            document.getElementById('summaryDescription').textContent = 'No data available';
            summaryTotalLink.textContent = '0.00';
            summaryTotalLink.href = "#"; // Disable the link if no data
            summaryTotalLink.style.pointerEvents = 'none'; // Disable clicking
        }
    }

    // Add event listeners to filter inputs
    document.getElementById('selectCategory').addEventListener('change', filterTable);
    document.getElementById('filterFromDate').addEventListener('change', filterTable);
    document.getElementById('filterToDate').addEventListener('change', filterTable);
});
</script>

    </body>
</html>