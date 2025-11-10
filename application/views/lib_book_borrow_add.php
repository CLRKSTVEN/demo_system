
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
                                    <h4 class="page-title">BORROW</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span></b></a></li>
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
					 
                        <!-- end page title -->
						<div class="row">
                            <div class="col-md-12">
							<?php echo $this->session->flashdata('msg'); ?>
                                <div class="card">
                                    <div class="card-body table-responsive">
                                      
                                    <form role="form" method="post" enctype="multipart/form-data">
    <div class="card-body"> 
        <div class="form-row">
        <div class="col-lg-12">
            <label>BOOKS</label>
            <select id="bookSelect" data-toggle="select2" name="Author" class="select2" class="form-control">
    <?php if (!empty($book)) : ?>
        <option value="">Select</option>
        <?php foreach ($book as $row) : ?>
            <option value="<?= $row->BookNo . '|' . $row->Title . '|' . $row->Author; ?>">
                <?= $row->BookNo . ' ' . $row->Title . ' By ' . $row->Author; ?>
            </option>
        <?php endforeach; ?>
    <?php else : ?>
        <option value="" disabled> Currently not Available</option>
    <?php endif; ?>
</select>

        </div>
    </div>


    <!-- Hidden input to store selected values -->
<input type="hidden" id="selectedBookNo" name="bookNo">
<input type="hidden" id="selectedTitle" name="title">
<input type="hidden" id="selectedAuthor" name="author">


<div class="form-row">
    <div class="col-lg-6">
        <label>STUDENT</label>
        <select id="studentSelect" data-toggle="select2" name="coAuthors" class="select2">
            <option value="">Select</option>
            <?php foreach ($stude as $row) : ?>
                <option value="<?= $row->StudentNumber . '|' . $row->FirstName . '|' . $row->MiddleName . '|' . $row->LastName; ?>">
                    <?= $row->StudentNumber . ' ' . $row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="col-lg-3">
    <label for="borrow_date">BORROW DATE<span style="color:red">*</span></label>
    <input type="date" class="form-control" id="borrow_date" name="borrow_date" required>
</div>	

<div class="col-lg-3">
    <label for="return_date">RETURN DATE<span style="color:red">*</span></label>
    <input type="date" class="form-control" id="return_date" name="return_date" required>
</div>	

<!-- Hidden input to store no_days -->
<input type="hidden" id="no_days" value="<?= $no_days; ?>">

</div>

<input type="hidden" id="selectedStudentNumber" name="StudentNumber">
<input type="hidden" id="selectedName" name="name">

        <!-- <div class="form-row mt-3">
            <div class="col-lg-6">
                <label for="no_days">Book Borrowing days limit<span style="color:red">*</span></label>
                <input type="number" class="form-control" name="no_days" required>
            </div>	

            <div class="col-lg-6">
                <label for="penalty">Penalty Amount <span style="color:red">*</span></label>
                <input type="number" class="form-control" name="penalty" step="0.01" required>
            </div>	
        </div> -->
    </div>

    <div class="modal-footer">
        <input type="submit" name="save" value="SUBMIT" class="btn btn-primary waves-effect waves-light">
    </div>
</form>
						</div>
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

    <!-- Morris Chart -->
    <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>

    <!-- Sparkline charts -->
    <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Dashboard init JS -->
    <script src="<?= base_url(); ?>assets/js/pages/dashboard.js"></script>

    <!-- Select2 JS -->
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

      <!-- Plugin js-->
      <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>

<!-- Validation init js-->
<script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>



    <!-- Initialize Select2 -->
    <script>
    $(document).ready(function() {
        $('.select2').select2();
    });


    $(document).ready(function () {
        $('.select2').select2();

        $('#bookSelect').on('change', function () {
            var selectedValue = $(this).val();
            if (selectedValue) {
                var parts = selectedValue.split('|');
                $('#selectedBookNo').val(parts[0]);
                $('#selectedTitle').val(parts[1]);
                $('#selectedAuthor').val(parts[2]);
            } else {
                $('#selectedBookNo').val('');
                $('#selectedTitle').val('');
                $('#selectedAuthor').val('');
            }
        });
    });

    $('#studentSelect').on('change', function () {
            var selectedValue = $(this).val();
            if (selectedValue) {
                var parts = selectedValue.split('|');
                $('#selectedStudentNumber').val(parts[0]);
                $('#selectedName').val(parts[1] + ' ' + parts[2] + ' ' + parts[3]); // Combine names
            } else {
                $('#selectedStudentNumber').val('');
                $('#selectedName').val('');
            }
        });

        $(document).ready(function () {
        $('#borrow_date').on('change', function () {
            var borrowDate = new Date($(this).val()); // Get borrow date
            var noDays = parseInt($('#no_days').val()); // Get no_days from hidden input

            if (!isNaN(noDays) && borrowDate) {
                borrowDate.setDate(borrowDate.getDate() + noDays); // Add no_days to borrow date

                var returnDate = borrowDate.toISOString().split('T')[0]; // Format date as YYYY-MM-DD
                $('#return_date').val(returnDate); // Set return date
            } else {
                $('#return_date').val('');
            }
        });
    });
    </script>

</body>

</html>
