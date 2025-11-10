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
                                    <a href="<?= base_url(); ?>Page/personnelEntry">
                                        <button type="button" class="btn btn-info waves-effect waves-light"> <i class=" fas fa-user-plus mr-1"></i> <span>Add New</span> </button>
                                    </a>

                                    <a href="<?= base_url(); ?>FileUploader/teachers">
                                        <button type="button" class="btn btn-success waves-effect waves-light"> <i class=" fas fa-user-plus mr-1"></i> <span>Bulk Upload</span> </button>
                                    </a>

                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <a href="<?= base_url(); ?>resources/TeachersProfile.xlsx">
                                            <button type="button" class="btn btn-primary waves-effect waves-light"> <i class=" fas fa-download  mr-1"></i> <span>Download the Template Here</span> </button>
                                        </a>
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
                                    <h4 class="m-t-0 header-title mb-4">FACULTY AND STAFF</h4>
                                    <?php if ($this->session->flashdata('msg')): ?>
                                        <div class="alert alert-success">
                                            <?php echo $this->session->flashdata('msg'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Last Name</th>
                                                <th style="text-align: center;">First Name</th>
                                                <th style="text-align: center;">Middle Name</th>
                                                <th style="text-align: center;">Employee No.</th>
                                                <th style="text-align: center;">Position</th>
                                                <th style="text-align: center;">Department</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $row->LastName . "</td>";
                                                echo "<td>" . $row->FirstName . "</td>";
                                                echo "<td>" . $row->MiddleName . "</td>";
                                                echo "<td>" . $row->IDNumber . "</td>";
                                                echo "<td>" . $row->empPosition . "</td>";
                                                echo "<td>" . $row->Department . "</td>";

                                            ?>

                                                <td style="text-align: center;">
                                                    <a href="<?= base_url(); ?>page/staffprofile?id=<?php echo $row->IDNumber; ?>">
                                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light"> <i class="fas fa-tv  mr-1"></i> <span>View</span> </button>
                                                    </a>

                                                    <a href="<?= base_url(); ?>page/deletePersonnel?id=<?php echo $row->IDNumber; ?>" onclick="return confirm('Are you sure you want to delete this personnel?');">
                                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light"><i class="far fa-trash-alt"></i> <span>Delete</span></button>
                                                    </a>
                                                <?php
                                                echo "</tr>";
                                            }
                                                ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                        </div><!-- /.box-body -->

                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-6 ">
                            <!-- Portlet card -->
                            <div class="card">
                                <div class="card-header bg-primary py-3 text-white">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                        <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                        <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                    </div>
                                    <h5 class="card-title mb-0 text-white">Summary By Position</h5>
                                </div>
                                <div id="cardCollpase2" class="collapse show">
                                    <div class="card-body">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Position</th>
                                                    <th style="text-align: center;">Counts</th>
                                                    <th style="text-align: center;">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($data1 as $row) {
                                                    echo "<tr>";
                                                ?>
                                                    <td><a href="<?= base_url(); ?>Page/employeelistPosition?position=<?php echo $row->empPosition; ?>"><?php echo $row->empPosition; ?></a></td>
                                                    <td style="text-align: center;"><a href="<?= base_url(); ?>Page/employeelistPosition?position=<?php echo $row->empPosition; ?>"><?php echo $row->Counts; ?></a></td>
                                                    <td style="text-align: center;"><a href="<?= base_url(); ?>Page/employeelistPosition?position=<?php echo $row->empPosition; ?>">View</a></td>
                                                <?php


                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end card-->

                        </div>
                        <!-- end col -->

                        <div class="col-md-6 col-sm-6 ">
                            <!-- Portlet card -->
                            <div class="card">
                                <div class="card-header bg-info py-3 text-white">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                        <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                        <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                    </div>
                                    <h5 class="card-title mb-0 text-white">Summary By Department</h5>
                                </div>
                                <div id="cardCollpase2" class="collapse show">
                                    <div class="card-body">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Department/Section/Division</th>
                                                    <th style="text-align: center;">Counts</th>
                                                    <th style="text-align: center;">Manage</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($data2 as $row) {
                                                    echo "<tr>";
                                                ?>

                                                    <td><a href="<?= base_url(); ?>Page/employeelistDepartment?department=<?php echo $row->department; ?>"><?php echo $row->department; ?></a></td>
                                                    <td style="text-align: center;"><a href="<?= base_url(); ?>Page/employeelistDepartment?department=<?php echo $row->department; ?>"><?php echo $row->Counts; ?></a></td>
                                                    <td style="text-align: center;"><a href="<?= base_url(); ?>Page/employeelistDepartment?department=<?php echo $row->department; ?>">View</a></td>
                                                <?php
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end card-->

                        </div>
                        <!-- end col -->

                    </div>



                </div>
                <!-- End row -->

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