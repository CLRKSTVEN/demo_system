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
                                    <a href="<?= base_url(); ?>Page/inventoryList1">
                                        <button type="button" class="btn btn-primary waves-effect waves-light">Add New</button>
                                    </a>

                                    <a href="#">
                                        <button type="button" class="btn btn-secondary waves-effect waves-light">Bulk Upload</button>
                                    </a>

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

                    <!-- start row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="clearfix">

                                        <div class="float-left">
                                            <h5 style="text-transform:uppercase">
                                                <strong>INVENTORY</strong>


                                            </h5>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Control No.</th>
                                                        <!-- <th>ICS No.</th> -->
                                                        <th>Item Name</th>
                                                        <th>Description</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Serial No.</th>
                                                        <th>Qty</th>
                                                        <th>Accountable</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($data as $row) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row->ctrlNo . "</td>";
                                                        // echo "<td>" . $row->ICSNo . "</td>";
                                                        echo "<td>" . $row->itemName . "</td>";
                                                        echo "<td>" . $row->description . "</td>";
                                                        echo "<td>" . $row->brand . "</td>";
                                                        echo "<td>" . $row->model . "</td>";
                                                        echo "<td>" . $row->serialNo . "</td>";
                                                        echo "<td>" . $row->qty . "</td>";

                                                        // Display the full name instead of IDNumber
                                                        echo "<td><a href=\"" . base_url() . "Page/inventoryAccountable?accountable=" . $row->accountable . "\">";
                                                        echo $row->FirstName . " " . $row->MiddleName . " " . $row->LastName; // Display full name
                                                        echo "</a></td>";

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Summary Table -->
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th style="text-align:center">Counts</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data1 as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $row->itemName . "</td>";
                                                echo "<td style='text-align:center;'>" . $row->itemCount . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">New Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php echo base_url('Page/inventoryList'); ?>">

                            <div class="form-row align-items-center">
                                <div class="col-md-3 mb-3">
                                    <label>Control No.</label>
                                    <input type="text" class="form-control" name="ctrlNo" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Item Name</label>
                                    <input type="text" class="form-control" name="itemName" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>ICS No.</label>
                                    <input type="text" class="form-control" name="ICSNo">
                                </div>
                            </div>

                            <div class="form-row align-items-center">
                                <div class="col-md-5 mb-3">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="description" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Model</label>
                                    <input type="text" class="form-control" name="model" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Oty</label>
                                    <input type="number" class="form-control" name="qty">
                                </div>
                            </div>

                            <div class="form-row align-items-center">
                                <div class="col-md-3 mb-3">
                                    <label>Unit</label>
                                    <input type="text" class="form-control" name="unit">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Brand</label>
                                    <input type="text" class="form-control" name="brand">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Acquire Date</label>
                                    <input type="date" class="form-control" name="acquiredDate">
                                </div>
                            </div>

                            <div class="form-row align-items-center">
                                <div class="col-md-6 mb-3">
                                    <label>Serial No.</label>
                                    <input type="text" class="form-control" name="serialNo">
                                </div>

                                <div class="col-md-6 mb-3">
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
                            </div>

                            <div class="col-md-12 mb-3">
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


                            <div class="modal-footer">
                                <input type="submit" name="submit" value="Save Data" class="btn btn-primary waves-effect waves-light" />
                            </div>
                        </form>

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
    </script>




</body>

</html>