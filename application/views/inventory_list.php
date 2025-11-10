<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SRMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">

    <!-- Plugins css-->
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

    <!-- third party css -->
    <link href="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/custombox/custombox.min.css" rel="stylesheet" type="text/css">

</head>

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
                                <!-- <h4 class="page-title">Inventory List</h4> -->
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="#custom-modal" class="btn btn-primary waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a"><button class="btn btn-primary">Add New Item</button></a></li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <h4 class="m-t-0 header-title mb-4">
                                    PROPERTY INVENTORY
                                </h4>

                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Control No.</th>
                                            <th>ICS No.</th>
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
                                            echo "<td>" . $row->ICSNo . "</td>";
                                            echo "<td>" . $row->itemName . "</td>";
                                            echo "<td>" . $row->description . "</td>";
                                            echo "<td>" . $row->brand . "</td>";
                                            echo "<td>" . $row->model . "</td>";
                                            echo "<td>" . $row->serialNo . "</td>";
                                            echo "<td>" . $row->qty . "</td>";

                                        ?>
                                            <td><a href="<?= base_url(); ?>Page/inventoryAccountable?accountable=<?php echo $row->accountable; ?>"><?php echo $row->accountable; ?></a></td>
                                        <?php
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body table-responsive">
                                            <h4 class="m-t-0 header-title mb-4">
                                                ITEM SUMMARY
                                            </h4>

                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
            <!-- Modal -->
            <div id="custom-modal" class="modal-demo">
                <button type="button" class="close" onclick="Custombox.modal.close();">
                    <span>&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="custom-modal-title">New Item</h4>
                <div class="custom-modal-text">
                    <form class="form-horizontal" method="post">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Control No.</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="ctrlNo" required>
                            </div>


                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Item Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="itemName" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Description</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="description" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword5" class="col-md-3 col-form-label">Qty</label>
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="qty">
                            </div>

                            <label for="inputPassword5" class="col-md-1 col-form-label">Unit</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="unit">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword5" class="col-md-3 col-form-label">Brand</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="brand">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword5" class="col-md-3 col-form-label">Acquire Date</label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="acquiredDate">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword5" class="col-md-3 col-form-label">Serial No.</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="serialNo">
                            </div>

                            <label for="inputPassword5" class="col-md-2 col-form-label">Condition</label>
                            <div class="col-md-3">
                                <select class="form-control" name="itemCondition" required>

                                    <option>Good</option>
                                    <option>Defective</option>
                                </select>
                            </div>

                        </div>



                        <div class="form-group row">
                            <label for="inputPassword5" class="col-md-3 col-form-label">Category</label>
                            <div class="col-md-9">
                                <select class="form-control" name="Category" required>

                                    <?php
                                    foreach ($data2 as $row) {
                                    ?>
                                        <option value="<?php echo $row->Category; ?>"><?php echo $row->Category; ?></option>


                                    <?php }

                                    ?>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword5" class="col-md-3 col-form-label">Office</label>
                            <div class="col-md-9">
                                <select class="form-control" name="office" required>

                                    <?php
                                    foreach ($data3 as $row) {
                                    ?>
                                        <option value="<?php echo $row->office; ?>"><?php echo $row->office; ?></option>


                                    <?php }

                                    ?>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword5" class="col-md-3 col-form-label">Accountable</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="accountable">
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-md-9">
                                <input type="submit" name="submit" class="btn btn-info waves-effect waves-light" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script src="<?= base_url(); ?>assets/libs/custombox/custombox.min.js"></script>

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

</body>

</html>