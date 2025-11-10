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
                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo $this->session->flashdata('success'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo $this->session->flashdata('error'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
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

                    <!-- Button to Open Modal for Announcement Posting -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#announcementModal">
                                Post New Announcement
                            </button>
                        </div>
                    </div>

                    <!-- Modal for Announcement Posting -->
                    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="announcementModalLabel"><b>Announcement Posting</b></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="form-horizontal" action="<?php echo ('uploadAnnouncement'); ?>" enctype='multipart/form-data' method="POST">
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label">Title</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="title" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label">Attach Image for Announcement</label>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control" name="nonoy" required>
                                                <p style="color:red; text-align:justify">Note: Maximum image size should be: <span style="font-weight: bold">width=900px, height=600px, and resolution=100px</span>. The acceptable formats are jpg, png and gif.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" name="submit" class="btn btn-info" value="Save">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Announcements Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="header-title"><b>Announcement List</b></h4>
                                    <span class="badge badge-purple">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                    <br><br>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Date Posted</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                            ?>
                                                <td><a href="<?= base_url(); ?>upload/announcements/<?php echo $row->announcement; ?>" target="_blank"><?php echo $row->title; ?></a></td>
                                                <td><?php echo $row->datePosted; ?></td>
                                                <td>
                                                    <!-- <a href="<?= base_url(); ?>Page/deleteAnnouncement/<?php echo $row->aID; ?>" class="text-danger"><i class="mdi mdi-file-document-box-check-outline"></i> Delete</a> -->

                                                    <a href="<?= base_url(); ?>Page/deleteAnnouncement/<?php echo $row->aID; ?>"
                                                        class="text-danger"
                                                        onclick="return confirm('Are you sure you want to delete this announcement?');">
                                                        <i class="mdi mdi-file-document-box-check-outline"></i> Delete
                                                    </a>

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

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- Required datatable js -->
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

</body>

</html>