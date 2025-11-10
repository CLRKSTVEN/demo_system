<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?= base_url(); ?>assets/libs/summernote/summernote-bs4.css" rel="stylesheet" type="text/css" />

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

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Compose Mail</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <!-- <li class="breadcrumb-item"><a href="#">Velonic</a></li>
                                        <li class="breadcrumb-item"><a href="#">Charts</a></li>
                                        <li class="breadcrumb-item active">Compose Mail</li> -->
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- end page title -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <!-- Flash Message Here -->
                            <?php if ($this->session->flashdata('success')) : ?>

                                <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>'
                                    . $this->session->flashdata('success') .
                                    '</div>';
                                ?>
                            <?php endif; ?>

                            <?php if ($this->session->flashdata('danger')) : ?>
                                <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>'
                                    . $this->session->flashdata('danger') .
                                    '</div>';
                                ?>
                            <?php endif;  ?>

                            <form method="post" action="<?= base_url('EmailBlast/sendEmail') ?>" class="bg-white p-4 rounded shadow-sm mt-4">
                                <?php if (!empty($student)): ?>
                                    <div class="mb-3">
                                        <label class="form-label">To</label>
                                        <input type="text" class="form-control" value="<?= $student->StudentNumber ?> - <?= $student->FirstName ?> <?= $student->LastName ?>" readonly>
                                        <input type="hidden" class="form-control" name="EmailAddress" value="<?= $student->EmailAddress ?>">
                                        <input type="hidden" name="student_id" value="<?= $student->StudentNumber ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="mb-3">
                                        <label class="form-label">To (Select Student)</label>
                                        <select id="student-select" name="student_id" class="form-control" required style="width: 100%;">
                                            <option value="">Search Student...</option>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea id="summernote" name="message" class="form-control" required></textarea>

                                </div>
                                <button type="submit" class="btn btn-primary">Send Email</button>
                            </form>
                        </div>
                        <!-- card-body -->
                    </div>
                    <!-- card -->



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

    <!--Summernote js-->
    <script src="<?= base_url(); ?>assets/libs/summernote/summernote-bs4.min.js"></script>

    <!-- Init js -->
    <script src="<?= base_url(); ?>assets/js/pages/form-summernote.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                placeholder: 'Type your email message here...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });
    </script>

</body>

</html>