<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">BORROW</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><span class="badge badge-purple">SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?></span></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Flash Messages -->
                    <?= $this->session->flashdata('message'); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="borrow_id" value="<?= isset($borrow) ? $borrow->bookID : ''; ?>">

    <div class="form-row">
        <div class="col-lg-12">
            <label>BOOKS</label>
            <select id="bookSelect" class="select2 form-control" disabled>
                <option value="">Select</option>
                <?php foreach ($book as $row) : ?>
                    <option value="<?= $row->BookNo . '|' . $row->Title . '|' . $row->Author; ?>"
                        <?= isset($borrow) && $borrow->bookNo == $row->BookNo ? 'selected' : ''; ?>>
                        <?= $row->BookNo . ' ' . $row->Title . ' By ' . $row->Author; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>



    <div class="form-row">
        <div class="col-lg-6">
            <label>STUDENT</label>
            <select id="studentSelect" class="select2 form-control">
                <option value="">Select</option>
                <?php foreach ($stude as $row) : ?>
                    <option value="<?= $row->StudentNumber . '|' . $row->FirstName . '|' . $row->MiddleName . '|' . $row->LastName; ?>"
                        <?= isset($borrow) && $borrow->StudentNumber == $row->StudentNumber ? 'selected' : ''; ?>>
                        <?= $row->StudentNumber . ' ' . $row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-lg-3">
            <label for="borrow_date">BORROW DATE</label>
            <input type="date" class="form-control" id="borrow_date" name="borrow_date" value="<?= isset($borrow) ? $borrow->borrow_date : ''; ?>" required>
        </div>  

        <div class="col-lg-3">
            <label for="return_date">RETURN DATE</label>
            <input type="date" class="form-control" id="return_date" name="return_date" value="<?= isset($borrow) ? $borrow->return_date : ''; ?>" required>
        </div>  
    </div>

    <input type="hidden" id="selectedStudentNumber" name="StudentNumber" value="<?= isset($borrow) ? $borrow->StudentNumber : ''; ?>">
    <input type="hidden" id="selectedName" name="name" value="<?= isset($borrow) ? $borrow->name : ''; ?>">

    <div class="modal-footer">
        <input type="submit" name="update" value="UPDATE" class="btn btn-primary">
    </div>
</form>

                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

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
