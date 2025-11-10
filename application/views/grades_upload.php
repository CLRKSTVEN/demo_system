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
                                <!-- <h4 class="page-title">Faculty Load</h4> -->
                                <a href="<?= base_url(); ?>resources/Grades_Uploading_Template.xlsx">
                                    <button type=" button" class="btn btn-info">Download Grades Template</button>
                                </a>

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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="m-t-0 header-title mb-4"><b>Upload Grades</b><br />
                                        <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>

                                    </h4>
                                    <?php if ($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success">
                                            <?php echo $this->session->flashdata('success'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (isset($response)): ?>
                                        <div class="alert alert-warning text-center">
                                            <?php echo $response; ?>
                                        </div>
                                    <?php endif; ?>



                                    <form class="parsley-examples" method='post' enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-3 col-form-label">Subject Code</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="subjectCode" name="subjectCode" readonly required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-3 col-form-label">Description</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="description" name="description" readonly required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-3 col-form-label">Section</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="section" name="section" readonly required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-3 col-form-label">Grading Period</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="period" required>
                                                    <option></option>
                                                    <option>1st</option>
                                                    <option>2nd</option>
                                                    <option>3rd</option>
                                                    <option>4th</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="inputPassword3" class="col-md-3 col-form-label">File</label>
                                            <div class="col-md-9">
                                                <input type='file' class="form-control" name='file' required>
                                            </div>
                                        </div>


                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-md-9">
                                                <input type='submit' value='Upload' class="btn btn-info float-right" name='upload'>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const params = new URLSearchParams(window.location.search);

                                            const subjectCode = params.get('subjectcode');
                                            const description = params.get('description');
                                            const section = params.get('section');

                                            if (subjectCode) {
                                                document.getElementById('subjectCode').value = subjectCode;
                                            }
                                            if (description) {
                                                document.getElementById('description').value = description;
                                            }
                                            if (section) {
                                                document.getElementById('section').value = section;
                                            }
                                        });
                                    </script>


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

    <!--Morris Chart-->
    <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>

    <!-- Sparkline charts -->
    <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Dashboard init JS -->
    <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <!-- Plugin js-->
    <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>
    <!-- Validation init js-->
    <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>

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