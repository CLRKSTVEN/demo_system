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
                                <h4 class="page-title">MASTERLIST BY TRACK <br />
                                    <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></b></a></li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" class="form-inline">
                                        <div class="form-group">
                                            <select name="track" id="track" class="form-control">
                                                <option value="">Select Track</option>
                                                <?php
                                                foreach ($track as $row) {
                                                    echo '<option value="' . $row->track . '">' . $row->track . '</option>';
                                                }
                                                ?>
                                            </select>&nbsp
                                            <select name="strand" id="strand" class="form-control">
                                                <option value="">Select Strand</option>
                                            </select>&nbsp

                                            <select name="gradelevel" class="form-control">
                                                <option>Grade 11</option>
                                                <option>Grade 12</option>
                                            </select>&nbsp

                                        </div>
                                        <input type="submit" name="submit" class="btn btn-info" value="submit">

                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- end page title -->
                    <div class="row">
                        <?php
                        if (isset($_GET["submit"])) {
                        ?>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <div class="float-left">
                                            <h4 class="m-t-0 header-title mb-1"><b>MASTERLIST BY TRACK</b><br />
                                                <span class="badge badge-primary mb-1">SY <?php echo $this->session->userdata('semester'); ?> <?php echo $this->session->userdata('sy'); ?> </span>
                                            </h4>
                                            <table>
                                                <tr>
                                                    <td>Track</td>
                                                    <td> : <strong><?php echo $_GET['track']; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Strand</td>
                                                    <td> : <strong><?php echo $_GET['strand']; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Grade Level</td>
                                                    <td> : <strong><?php echo $_GET['gradelevel']; ?></strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="float-right">
                                            <div class="d-print-none">
                                                <div class="float-right">
                                                    <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i> Print</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo $this->session->flashdata('msg'); ?>

                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Student Name</th>
                                                    <th>LRN</th>
                                                    <th>Section</th>
                                                    <th>Adviser</th>

                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php
                                                $i = 1;
                                                foreach ($data as $row) {
                                                    echo "<tr>";
                                                    echo "<td>" . $i++ . "</td>";
                                                    echo "<td>" . $row->StudeName . "</td>";
                                                ?>
                                                    <td><?php echo $row->LRN; ?></a></td>

                                            <?php

                                                    echo "<td>" . $row->Section . "</td>";
                                                    echo "<td>" . $row->Adviser . "</td>";
                                                    echo "</tr>";
                                                }
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
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        $(document).ready(function() {
            $('#course').change(function() {
                var course = $('#course').val();
                if (course != '') {
                    $.ajax({
                        url: "<?php echo base_url(); ?>page/fetch_yearlevel",
                        method: "POST",
                        data: {
                            course: course
                        },
                        success: function(data) {
                            $('#yearlevel').html(data);
                        }
                    })
                }
            });
        });
        $(document).ready(function() {
            $('#track').change(function() {
                var track = $('#track').val();
                if (track != '') {
                    $.ajax({
                        url: "<?php echo base_url(); ?>Settings/fetchStrand",
                        method: "POST",
                        data: {
                            track: track
                        },
                        success: function(data) {
                            $('#strand').html(data);
                        }
                    })
                }
            });
        });
    </script>
</body>

</html>