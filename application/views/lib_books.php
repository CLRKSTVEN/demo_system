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
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">
                                    <a href="<?= base_url(); ?>Library/booksEntry">
                                        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fas fa-stream mr-1"></i> <span>Add New</span> </button>
                                    </a>
                                    <h4>
                                        <div class="page-title-right">
                                            <ol class="breadcrumb p-0 m-0">
                                                <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                                            </ol>
                                        </div>
                                        <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="m-t-0 header-title mb-4">
                                        BOOKS MASTERLIST

                                    </h4>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Book No.</th>
                                                <th>Author</th>
                                                <th>Co-Authors</th>
                                                <th>ISBN</th>
                                                <th>Status</th>
                                                <th style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $row->Title . "</td>";
                                                echo "<td>" . $row->BookNo . "</td>";
                                                echo "<td>" . $row->Author . "</td>";
                                                echo "<td>" . $row->coAuthors . "</td>";
                                                echo "<td>" . $row->ISBN . "</td>";
                                                echo "<td>" . $row->stat . "</td>";
                                            ?>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url(); ?>Library/bookDetails?id=<?php echo $row->BookID; ?>">
                                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                                            <i class="fas fa-stream"></i> <span>View Details</span>
                                                        </button>
                                                    </a>
                                                    <a href="<?= base_url(); ?>Library/updateBooks?id=<?php echo $row->BookID; ?>">
                                                        <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                                            <i class="far fa-edit"></i> <span>Update</span>
                                                        </button>
                                                    </a>
                                                    <!-- Delete Button with Form -->
                                                    <form action="<?= base_url(); ?>Library/deleteBook" method="post" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?php echo $row->BookID; ?>" />
                                                        <button type="submit" class="btn btn-danger btn-xs waves-effect waves-light">
                                                            <i class="far fa-trash-alt"></i> <span>Delete</span>
                                                        </button>


                                                    </form>

                                                    <!-- JavaScript for confirmation -->
                                                    <script>
                                                        document.querySelectorAll('form').forEach(form => {
                                                            form.addEventListener('submit', function(event) {
                                                                if (!confirm('Are you sure you want to delete this book?')) {
                                                                    event.preventDefault();
                                                                }
                                                            });
                                                        });
                                                    </script>

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
                    </div>



                </div>

            </div>
            <!-- end col -->


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

    <script src="<?= base_url(); ?>assets/libs/fullcalendar/fullcalendar.min.js"></script>

    <!-- Calendar init -->
    <script src="<?= base_url(); ?>assets/js/pages/calendar.init.js"></script>

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

    <script src="<?= base_url(); ?>assets/libs/jquery-ui/jquery-ui.min.js"></script>
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