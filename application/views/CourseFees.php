<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>
    <div id="wrapper">
        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->
        <!-- Left Sidebar Start -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Left Sidebar End -->





        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">

                            <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $this->session->flashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php elseif ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $this->session->flashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php endif; ?>
                                <h4 class="page-title">
                                     <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#copyFeesModal" style="float: right; margin-right: 10px;">Copy Fees</button>

                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Add New</button>

                                </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item">
                                            <a href="#">
                                                <span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></span>
                                            </a>
                                        </li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    

                    <!-- Filter Form by Year Level -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="<?php echo base_url('Accounting/CourseFees'); ?>">
                                        <div class="form-group row">
                                            <div class="col-md-6 d-flex align-items-center">
                                                <label for="" class="mr-3">Select Year Level:</label>
                                                <select class="form-control" name="yearLevelFilter" id="yearLevelFilter">
                                                    <option value="">All Year Levels</option>
                                                    <?php foreach ($year_levels as $level) { ?>
                                                        <option value="<?= $level->YearLevel; ?>" <?= isset($_POST['yearLevelFilter']) && $_POST['yearLevelFilter'] == $level->YearLevel ? 'selected' : ''; ?>><?= $level->YearLevel; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-center">
                                                <button type="submit" class="btn btn-primary ml-2">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Fees Table -->
                    <div class="row">
                        <div class="col-md-12">
                          
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Year Level</th>
                                                    <th>Course</th>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th style="text-align:center;">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $row) { ?>
                                                    <tr>
                                                        <td><?= $row->YearLevel; ?></td>
                                                        <td><?= $row->Course; ?></td>
                                                        <td><?= $row->Description; ?></td>
                                                        <td style="text-align: right;"><?= number_format($row->Amount, 2); ?></td>
                                                        <td style="text-align:center;">
                                                            <a href="<?= base_url('Accounting/updateCourseFees?feesid=' . $row->feesid); ?>"
                                                                class="btn btn-primary btn-sm">Edit</a>
                                                            <a href="#" onclick="setDeleteUrl('<?= base_url('Accounting/Deletefees?feesid=' . $row->feesid); ?>')"
                                                                data-toggle="modal" data-target="#confirmationModal"
                                                                class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Table -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Summary by Year Level</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Year Level</th>
                                                    <th style="text-align: center;">Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($selected_year !== 'All'): ?>
                                                    <tr>
                                                        <td><?= $selected_year; ?></td>
                                                        <td style="text-align: right;"><?= number_format($selected_year_total, 2); ?></td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php if (!empty($year_level_totals)): ?>
                                                        <?php foreach ($year_level_totals as $row): ?>
                                                            <tr>
                                                                <td><?= $row['YearLevel']; ?></td>
                                                                <td style="text-align: right;"><?= number_format($row['total_amount'], 2); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="2" class="text-center">No data available</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTables Initialization Script -->
                    <script>
                        $(document).ready(function() {
                            $('#datatable').DataTable({
                                responsive: true,
                                autoWidth: false, // Disable automatic column width
                                paging: true, // Enable pagination
                                searching: true, // Enable search bar
                                lengthChange: true // Allow changing number of rows displayed
                            });
                        });
                    </script>




                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Delete Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <div class="circle-with-stroke d-inline-flex justify-content-center align-items-center">
                                            <span class="h1 text-danger">!</span>
                                        </div>
                                        <p class="mt-3">Are you sure you want to delete this data?</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="#" id="deleteButton" class="btn btn-danger" onclick="deleteData()">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .circle-with-stroke {
                            width: 100px;
                            height: 100px;
                            border: 4px solid #dc3545;
                            border-radius: 50%;
                        }
                    </style>

                    <script>
                        function setDeleteUrl(url) {
                            document.getElementById('deleteButton').href = url;
                        }

                        function deleteData() {
                            // This will now correctly delete the selected item
                        }
                    </script>

                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">Add New</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="<?php echo base_url('Accounting/CourseFees'); ?>">
                                        <div class="form-row align-items-center">
                                            <input type="hidden" name="SY" class="form-control" value="<?php echo $this->session->userdata('sy'); ?>" readonly required />

                                            <div class="col-md-6 mb-3">
                                                <label for="Course">Course</label>
                                                <select class="form-control select2" id="Course" name="Course" required>
                                                    <option disabled selected>Select Course</option>
                                                    <?php foreach ($course as $row) { ?>
                                                        <option value="<?php echo $row->CourseDescription; ?>">
                                                            <?php echo $row->CourseDescription; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="YearLevel">Grade Level</label>
                                                <select class="form-control" id="YearLevel" name="YearLevel" required>
                                                    <option disabled selected>Select Grade Level</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="Description">Description</label>
                                                <input type="text" class="form-control" id="Description" name="Description" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="Amount">Amount</label>
                                                <input type="number" class="form-control" id="Amount" name="Amount" required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <input type="submit" name="save" value="Save Data" class="btn btn-primary waves-effect waves-light" />
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>

                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </div>


    </div>
    </div>
    </div>



<!-- Copy Fees Modal -->
<div class="modal fade" id="copyFeesModal" tabindex="-1" role="dialog" aria-labelledby="copyFeesModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
<form action="<?= base_url('Accounting/copyFeesBySY') ?>" method="post">
          <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="copyFeesModalLabel">Copy Fees to New School Year</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="from_sy">From School Year</label>
            <select name="from_sy" class="form-control" required>
              <option value="">Select From SY</option>
              <?php foreach ($available_sy as $sy): ?>
                <option value="<?= $sy->SY ?>"><?= $sy->SY ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="to_sy">To School Year</label>
            <input type="text" name="to_sy" class="form-control" placeholder="e.g. 2025-2026" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Copy Fees</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
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


    <!-- Select2 JS -->
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        $(document).ready(function() {
            $('#Course').change(function() {
                const CourseDescription = $(this).val();

                // Send AJAX request to fetch year levels/majors
                $.ajax({
                    url: '<?php echo base_url("Accounting/getMajorsByCourse"); ?>',
                    type: 'POST',
                    data: {
                        CourseDescription: CourseDescription
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#YearLevel').empty().append('<option disabled selected>Select Grade Level</option>');

                        // Populate the YearLevel dropdown
                        $.each(data, function(index, major) {
                            $('#YearLevel').append('<option value="' + major.Major + '">' + major.Major + '</option>');
                        });
                    },
                    error: function() {
                        alert('Failed to fetch data. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>