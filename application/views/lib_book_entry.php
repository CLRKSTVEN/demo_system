<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('includes/top-nav-bar.php'); ?>
        <!-- end Topbar -->
        <!-- ========== Left Sidebar Start ========== -->

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
                                <!-- <h4 class="page-title">BOOKS ENTRY</h4> -->
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item">
                                            <a href="#">
                                                <!-- <span class="badge badge-purple mb-3">Currently login to
                                                    <b>SY <?php echo $this->session->userdata('sy'); ?>
                                                        <?php echo $this->session->userdata('semester'); ?></b>
                                                </span> -->
                                            </a>
                                        </li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                    <div class="col-xl-12 col-sm-6 ">
                                <!-- Portlet card -->
                                <div class="card">
                                    <div class="card-header bg-info py-3 text-white">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase3" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                            <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h5 class="card-title mb-0 text-white">Books Entry</h5>
                                    </div>
                                    <div id="cardCollpase3" class="collapse show">
                                        <div class="card-body">
                                            
                                        <form role="form" method="post" class="parsley-examples"  enctype="multipart/form-data">
                                        <!-- general form elements -->
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <input type="hidden" class="form-control"
                                                        value="<?php echo $settings[0]->settingsID; ?>"
                                                        name="settingsID" required>
                                                    <div class="form-group">
                                                        <label for="lastName">Book No. <span
                                                                style="color:red">*</span></label>
                                                        <input type="text" class="form-control" name="BookNo" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <label>Title <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" name="Title" value=""
                                                            required>
                                                    </div>
                                                </div>
                                            </div>

											<div class="row">
    <input type="hidden" class="form-control" name="AuthorNum" value="">

    <div class="col-lg-6">
        <div class="form-group">
            <label>Author</label>
            <select data-toggle="select2" name="Author" class="select2">
                <option value="">Select</option>
                <?php foreach ($auth as $Author) : ?>
                    <option value="<?= $Author->FirstName . ' ' . $Author->MiddleName . ' ' . $Author->LastName; ?>">
                        <?= $Author->FirstName . ' ' . $Author->MiddleName . ' ' . $Author->LastName; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="lastName">Co-Authors</label>
            <select data-toggle="select2" name="coAuthors" class="select2">
                <option value="">Select</option>
                <?php foreach ($auth as $Author) : ?>
                    <option value="<?= $Author->FirstName . ' ' . $Author->MiddleName . ' ' . $Author->LastName; ?>">
                        <?= $Author->FirstName . ' ' . $Author->MiddleName . ' ' . $Author->LastName; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>


                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Publisher <span style="color:red">*</span></label>
                                                        <select name="Publisher" id="course" class="form-control" required>
                                                            <?php
                                                            foreach ($publisher as $row) {
                                                            ?>
                                                            <option value="<?php echo $row->publisher; ?>">
                                                                <?php echo $row->publisher; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="lastName">Subject</label>
                                                        <input type="text" class="form-control" name="Subject">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="lastName">Year Published</label>
                                                        <input type="number" class="form-control" name="YPublished"
                                                            pattern="/^-?\d+\.?\d*$/"
                                                            onKeyPress="if(this.value.length==4) return false;">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>ISBN</label>
                                                        <input type="text" class="form-control" name="ISBN" value="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Edition</label>
                                                        <input type="text" class="form-control" name="Edition" value="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Call Number</label>
                                                        <input type="text" name="CallNum" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Category <span style="color:red">*</span></label>
                                                        <select name="Category" id="course" class="form-control" required>
                                                            <?php
                                                            foreach ($data as $row) {
                                                            ?>
                                                            <option value="<?php echo $row->Category; ?>">
                                                                <?php echo $row->Category; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Location <span style="color:red">*</span></label>
                                                        <select name="Location" id="course" class="form-control" required>
                                                            <?php
                                                            foreach ($location as $row) {
                                                            ?>
                                                            <option value="<?php echo $row->location; ?>">
                                                                <?php echo $row->location; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Dewey No. </label>
                                                        <input type="text" class="form-control" name="DeweyNum" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Accession No. </label>
                                                        <input type="text" class="form-control" name="AccNo" value="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Purchase Price </label>
                                                        <input type="number" class="form-control" name="Price" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" name="stat" value="Available" hidden>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="submit" name="submit" class="btn btn-info float-right"
                                                        value="Save">
                                                </div>
                                            </div>

                                        </div><!-- /.box -->

                                    </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-->

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
    </script>

</body>

</html>
