<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<style>.toolbar-sticky {
    position: sticky; 
    top: 64px; 
    z-index: 1100;
    background: #fff; 
    padding-bottom: .5rem;
}
.dataTables_wrapper {
    position: relative;
    overflow: visible;
    margin-top: .25rem;
}
.fixedHeader-floating, 
.fixedHeader-locked {
    z-index: 1000;
}
</style>
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
            <div class="page-title-box toolbar-sticky">
                <h4 class="page-title">
                    <?php if ($this->session->userdata('level') === 'Admin') : ?>
                        <a href="<?= base_url(); ?>Ren/profileEntry">
                            <button type="button" class="btn btn-info waves-effect waves-light">
                                <i class=" fas fa-user-plus mr-1"></i> <span>Add New</span>
                            </button>
                        </a>
                        <a href="<?= base_url(); ?>FileUploader">
                            <button type="button" class="btn btn-success waves-effect waves-light">
                                <i class=" fas fa-user-plus mr-1"></i> <span>Bulk Upload</span>
                            </button>
                        </a>
                        <a href="<?= base_url(); ?>resources/StudentProfile.xlsx">
                            <button type="button" class="btn btn-secondary waves-effect waves-light">
                                <i class=" fas fa-cloud-download-alt  mr-1"></i> <span>Download Template</span>
                            </button>
                        </a>

                    <?php elseif ($this->session->userdata('level') === 'Registrar') : ?>

                        <a href="<?= base_url(); ?>Page/profileEntry">
                            <button type="button" class="btn btn-info waves-effect waves-light">
                                <i class=" fas fa-user-plus mr-1"></i> <span>Add New</span>
                            </button>
                        </a>

                    <?php elseif ($this->session->userdata('level') === 'Teacher') : ?>

                        <a href="<?= base_url(); ?>Page/profileEntry">
                            <button type="button" class="btn btn-info waves-effect waves-light">
                                <i class=" fas fa-user-plus mr-1"></i> <span>Add New</span>
                            </button>
                        </a>
                        <!-- <a href="<?= base_url(); ?>FileUploader">
                            <button type="button" class="btn btn-success waves-effect waves-light">
                                <i class=" fas fa-user-plus mr-1"></i> <span>Bulk Upload</span>
                            </button>
                        </a> -->

                        <!-- <a href="<?= base_url(); ?>resources/StudentProfile.xlsx">
                            <button type="button" class="btn btn-secondary waves-effect waves-light">
                                <i class=" fas fa-cloud-download-alt  mr-1"></i> <span>Download Template</span>
                            </button>
                        </a> -->

                    <?php elseif ($this->session->userdata('level') === 'Accounting') : ?>

                    <?php endif; ?>


                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12 col-sm-6 ">
                            <!-- Portlet card -->
                            <div class="card">
                                <div class="card-header bg-info py-3 text-white">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                        <a data-toggle="collapse" href="#cardCollpase3" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                        <!-- <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a> -->
                                    </div>
                                    <!-- <h5 class="card-title mb-0 text-white">Profile List</h5> -->
                                </div>
                                <div id="cardCollpase3" class="collapse show">
                                    <div class="card-body">
                                        <?php echo $this->session->flashdata('msg'); ?>
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Student No.</th>
                                                    <th>LRN</th>
                                                    <th>Sex</th>
                                                    <th style="width:110px">B-Date</th>
                                                    <th>Birth Place</th>
                                                    <th>Religion</th>
                                                    <th style="text-align:center; width:240px">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($data as $row) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName . "</td>";
                                                    echo "<td>" . $row->StudentNumber . "</td>";
                                                    echo "<td>" . $row->LRN . "</td>";
                                                    echo "<td>" . $row->Sex . "</td>";
                                                    echo "<td>" . $row->BirthDate . "</td>";
                                                    echo "<td>" . $row->BirthPlace . "</td>";
                                                    echo "<td>" . $row->Religion . "</td>";
                                                ?>

                                                    <td style="text-align:center">
                                                        <?php if ($this->session->userdata('level') === 'Accounting') : ?>
                                                            <!-- <button type="button" class="btn btn-warning btn-xs">View Profile</button>
                                                        <button type="button" class="btn btn-danger btn-xs">Delete</button> -->
                                                        <?php elseif ($this->session->userdata('level') === 'Admin') : ?>
                                                            <a href="<?= base_url(); ?>page/studentsprofile?id=<?php echo $row->StudentNumber; ?>" class="text-info"><i class="mdi mdi-file-document-box-check-outline"></i>View Profile</a>
                                                            <a href="<?= base_url(); ?>page/deleteProfile?id=<?php echo $row->StudentNumber; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this record?')"><i class="mdi mdi-file-document-box-check-outline"></i>Delete</a>


                                                        <?php elseif ($this->session->userdata('level') === 'Registrar') : ?>
                                                            <a href="<?= base_url(); ?>EmailBlast/view?id=<?php echo $row->StudentNumber; ?>" class="text-success"><i class="mdi mdi-file-document-box-check-outline"></i>Send Email</a>
                                                            <a href="<?= base_url(); ?>page/studentsprofile?id=<?= trim($row->StudentNumber); ?>" class="text-info"><i class="mdi mdi-file-document-box-check-outline"></i>View Profile</a>
                                                            <a href="<?= base_url(); ?>page/deleteProfile?id=<?php echo $row->StudentNumber; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this record?')"><i class="mdi mdi-file-document-box-check-outline"></i>Delete</a>

                                                        <?php elseif ($this->session->userdata('level') === 'Teacher') : ?>
                                                            <a href="<?= base_url(); ?>EmailBlast/view?id=<?php echo $row->StudentNumber; ?>" class="text-success"><i class="mdi mdi-file-document-box-check-outline"></i>Send Email</a>
                                                            <a href="<?= base_url(); ?>page/studentsprofile?id=<?= trim($row->StudentNumber); ?>" class="text-info"><i class="mdi mdi-file-document-box-check-outline"></i>View Profile</a>
                                                            <!-- <a href="<?= base_url(); ?>page/deleteProfile?id=<?php echo $row->StudentNumber; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this record?')"><i class="mdi mdi-file-document-box-check-outline"></i>Delete</a> -->
                                                        <?php endif; ?>


                                                    </td>
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


    <script>
        // Wait until the DOM is fully loaded
        $(document).ready(function() {
            // Auto-dismiss alert after 5 seconds
            setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 5000); // 5000 = 5 seconds
        });
    </script>


</body>

</html>