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
                                <h4 class="page-title">Update Item</h4>
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
                            <div class="card">
                                <div class="card-header bg-warning py-3 text-white">
                                    <h5 class="card-title mb-0 text-white">Edit Item</h5>
                                </div>
                                <div id="cardCollpase3" class="collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="modal-body">
                                                    <?php foreach ($item as $item) { ?>
                                                    <form method="post" class="parsley-examples" action="<?php echo base_url('Page/updateInventory'); ?>">
                                                    <input type="hidden" name="itemID" value="<?php echo $item->itemID; ?>" />
                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-3 mb-3">
                                                                    <label>Control No.</label>
                                                                    <input type="text" class="form-control" name="ctrlNo" value="<?php echo $item->ctrlNo; ?>" required>
                                                                </div>

                                                                <div class="col-md-9 mb-3">
                                                                    <label>Item Name</label>
                                                                    <input type="text" class="form-control" name="itemName" value="<?php echo $item->itemName; ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-12 mb-3">
                                                                    <label>Description</label>
                                                                    <textarea class="form-control" rows="5" id="example-textarea" name="description"><?php echo $item->description; ?></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-5 mb-3">
                                                                    <label>Serial No.</label>
                                                                    <input type="text" class="form-control" name="serialNo" value="<?php echo $item->serialNo; ?>">
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label>Model</label>
                                                                    <input type="text" class="form-control" name="model" value="<?php echo $item->model; ?>">
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label>Qty</label>
                                                                    <input type="number" class="form-control" name="qty" value="<?php echo $item->qty; ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-3 mb-3">
                                                                    <label>Unit</label>
                                                                    <input type="text" class="form-control" name="unit" value="<?php echo $item->unit; ?>">
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label for="brand">Brand</label>
                                                                    <select class="form-control select2" id="brand" name="brand" required>
                                                                        <option disabled>Select Brand</option>
                                                                        <?php foreach ($data5 as $row) { ?>
                                                                            <option value="<?php echo $row->brand; ?>" <?php echo ($item->brand == $row->brand) ? 'selected' : ''; ?>>
                                                                                <?php echo $row->brand; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label>Acquire Date</label>
                                                                    <input type="date" class="form-control" name="acquiredDate" value="<?php echo $item->acquiredDate; ?>">
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label>Condition</label>
                                                                    <select class="form-control" name="itemCondition" required>
                                                                        <option value="Good" <?php echo ($item->itemCondition == 'Good') ? 'selected' : ''; ?>>Good</option>
                                                                        <option value="Defective" <?php echo ($item->itemCondition == 'Defective') ? 'selected' : ''; ?>>Defective</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="itemCategory">Category</label>
                                                                    <select class="form-control select2" id="itemCategory" name="itemCategory" required>
                                                                        <option disabled>Select Category</option>
                                                                        <?php foreach ($data2 as $row) { ?>
                                                                            <option value="<?php echo $row->Category; ?>" <?php echo ($item->itemCategory == $row->Category) ? 'selected' : ''; ?>>
                                                                                <?php echo $row->Category; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="itemSubCategory">Sub Category</label>
                                                                    <select class="form-control" id="itemSubCategory" name="itemSubCategory" required>
                                                                        <option disabled>Select Subcategory</option>
                                                                        <?php foreach ($subcategories as $subcat) { ?>
                                                                            <option value="<?php echo $subcat; ?>" <?php echo ($item->itemSubCategory == $subcat) ? 'selected' : ''; ?>>
                                                                                <?php echo $subcat; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-row align-items-center">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="office">Office</label>
                                                                    <select class="form-control select2" id="office" name="office" required>
                                                                        <option disabled>Select Office</option>
                                                                        <?php foreach ($data3 as $row) { ?>
                                                                            <option value="<?php echo $row->office; ?>" <?php echo ($item->office == $row->office) ? 'selected' : ''; ?>>
                                                                                <?php echo $row->office; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                <label for="accountable">Accountable</label>
                                                                    <select class="form-control select2" id="accountable" name="accountable" disabled>
                                                                        <option disabled>Select Accountable</option>
                                                                        <?php foreach ($data4 as $row) { ?>
                                                                            <option value="<?php echo $row->IDNumber; ?>" <?php echo ($item->accountable == $row->IDNumber) ? 'selected' : ''; ?>>
                                                                                <?php echo $row->FirstName; ?> <?php echo $row->MiddleName; ?> <?php echo $row->LastName; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>

                                                                    </div>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <input type="submit" name="update" value="Update Data" class="btn btn-warning waves-effect waves-light" />
                                                            </div>
                                                        </form>
                                                        <?php } ?>  
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

    <!-- Plugin js-->
    <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>

    <!-- Validation init js-->
    <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>

    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>


<script>
    $(document).ready(function () {
        var selectedCategory = $('#itemCategory').val(); // Get the selected category
        var existingSubcategory = "<?php echo $item->itemSubCategory; ?>"; // Preselected subcategory

        // Fetch subcategories if a category is already selected (for updates)
        if (selectedCategory) {
            fetchSubcategories(selectedCategory, existingSubcategory);
        }

        // When the category is changed
        $('#itemCategory').change(function () {
            var selectedCategory = $(this).val(); // Get new category
            if (selectedCategory) {
                fetchSubcategories(selectedCategory, null); // Fetch without a preselected subcategory
            }
        });

        // Function to fetch subcategories via AJAX
        function fetchSubcategories(category, preselectedSubcategory) {
            $.ajax({
                url: '<?php echo base_url("Page/getSubcategories"); ?>', // Backend function
                method: 'POST',
                data: { category: category },
                dataType: 'json',
                success: function (response) {
                    var subcategoryDropdown = $('#itemSubCategory');
                    subcategoryDropdown.empty(); // Clear previous options
                    subcategoryDropdown.append('<option disabled>Select Subcategory</option>');

                    if (response.subcategories) {
                        // Append options
                        response.subcategories.forEach(function (subcategory) {
                            var isSelected = subcategory === preselectedSubcategory ? 'selected' : '';
                            subcategoryDropdown.append('<option value="' + subcategory + '" ' + isSelected + '>' + subcategory + '</option>');
                        });
                    } else {
                        alert('No subcategories found.');
                    }
                },
                error: function () {
                    alert('Error fetching subcategories.');
                }
            });
        }
    });
</script>

</body>

</html>