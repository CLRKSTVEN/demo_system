<!DOCTYPE html>
<html lang="en">

<head>
    <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
</head>

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
                                <h4 class="page-title">

                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="#"></a></li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-6">
                            <!-- Portlet card -->
                            <div class="card">
                                <div class="card-header bg-info py-3 text-white">
                                    <h5 class="card-title mb-0 text-white">+Add New</h5>
                                </div>
                                <div id="cardCollpase3" class="collapse show">
                                    <div class="card-body">
                                        <!-- Content Here -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="modal-body">
                                                        <form method="post" class="parsley-examples" action="<?php echo base_url('Page/inventoryList1'); ?>">

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-3 mb-3">
                                                                    <label>Control No.</label>
                                                                    <input type="text" class="form-control" name="ctrlNo" required>
                                                                </div>

                                                                <div class="col-md-9 mb-3">
                                                                    <label>Item Name</label>
                                                                    <input type="text" class="form-control" name="itemName" required>
                                                                </div>
                                                            </div>


                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-12 mb-3">
                                                                    <label>Description</label>
                                                                    <textarea class="form-control" rows="5" id="example-textarea" name="description"></textarea>
                                                                </div>
                                                            </div>



                                                            <div class="form-row align-items-center">

                                                                <div class="col-md-5 mb-3">
                                                                    <label>Serial No.</label>
                                                                    <input type="text" class="form-control" name="serialNo">
                                                                </div>


                                                                <div class="col-md-4 mb-3">
                                                                    <label>Model</label>
                                                                    <input type="text" class="form-control" name="model" >
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label>Qty</label>
                                                                    <input type="number" class="form-control" name="qty" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-3 mb-3">
                                                                    <label>Unit</label>
                                                                    <input type="text" class="form-control" name="unit">
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label for="brand">Brand</label>
                                                                    <select class="form-control select2" id="brand" name="brand" >
                                                                        <option disabled selected>Select Brand</option>
                                                                        <?php foreach ($data5 as $row) { ?>
                                                                            <option value="<?php echo $row->brand; ?>">
                                                                                <?php echo $row->brand; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label>Acquire Date</label>
                                                                    <input type="date" class="form-control" name="acquiredDate">
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label>Condition</label>
                                                                    <select class="form-control" name="itemCondition" required>
                                                                        <option>Good</option>
                                                                        <option>Defective</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        
                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="itemCategory">Category</label>
                                                                    <select class="form-control select2" id="itemCategory" name="itemCategory" required>
                                                                        <option disabled selected>Select Category</option>
                                                                        <?php foreach ($data2 as $row) { ?>
                                                                            <option value="<?php echo $row->Category; ?>">
                                                                                <?php echo $row->Category; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <!-- Subcategory Input -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="itemSubCategory">Sub Category</label>
                                                                    <select class="form-control" id="itemSubCategory" name="itemSubCategory" required>
                                                                        <option disabled selected>Select Subcategory</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- </div> -->


                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="Category">Office</label>
                                                                    <select class="form-control select2" id="office" name="office" required>
                                                                        <option disabled selected>Select Office</option>
                                                                        <?php foreach ($data3 as $row) { ?>
                                                                            <option value="<?php echo $row->office; ?>">
                                                                                <?php echo $row->office; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="Category">Accountable</label>
                                                                    <select class="form-control select2" id="accountable" name="accountable" required>
                                                                        <option disabled selected>Select Accountable</option>
                                                                        <?php foreach ($data4 as $row) { ?>
                                                                            <option value="<?php echo $row->IDNumber; ?>">
                                                                                <?php echo $row->FirstName; ?> <?php echo $row->MiddleName; ?> <?php echo $row->LastName; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <input type="submit" name="submit" value="Save Data" class="btn btn-primary waves-effect waves-light" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>

    <?php include('includes/themecustomizer.php'); ?>
    </div>

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

    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

    <!-- Select2 JS -->
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>


    <script>
        $(document).ready(function() {
            // When category is selected
            $('#itemCategory').change(function() {
                var selectedCategory = $(this).val();

                if (selectedCategory) {
                    // Make an AJAX request to fetch the subcategories
                    $.ajax({
                        url: '<?php echo base_url("Page/getSubcategories"); ?>', // Create this controller function
                        method: 'POST',
                        data: {
                            category: selectedCategory
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.subcategories) {
                                var subcategoryDropdown = $('#itemSubCategory');
                                subcategoryDropdown.empty(); // Clear previous options
                                subcategoryDropdown.append('<option disabled selected>Select Subcategory</option>');

                                // Append new options
                                response.subcategories.forEach(function(subcategory) {
                                    subcategoryDropdown.append('<option value="' + subcategory + '">' + subcategory + '</option>');
                                });
                            } else {
                                alert('No subcategories found');
                            }
                        },
                        error: function() {
                            alert('Error fetching subcategories');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>