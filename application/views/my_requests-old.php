<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/head.php'); ?>
</head>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Flash Messages -->
                    <?php if ($this->session->flashdata('msg')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('msg'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4>My Document Requests</h4>
                        </div>
                    </div>

                    <!-- Document Request Form -->
                    <form method="post" action="<?= base_url('request/submit_request') ?>">
                        <div class="form-group">
                            <label>Document Type</label>
                            <select name="document_type" required class="form-control">
                                <option value="">Select</option>
                                <option>Certificate of Enrollment</option>
                                <option>Transcript of Records</option>
                                <option>Good Moral</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Purpose</label>
                            <textarea name="purpose" class="form-control" required></textarea>
                        </div>
                        <button class="btn btn-primary mt-2" type="submit">Submit Request</button>
                    </form>

                    <hr>

                    <!-- Document Requests Table in Card -->
                    <div class="card mt-4">
                        <div class="card-header bg-info text-white">
                            <strong>Document Request History</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Document</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($requests)): ?>
                                        <?php foreach ($requests as $r): ?>
                                            <tr>
                                                <td><?= $r->document_type ?></td>
                                                <td><?= $r->purpose ?></td>
                                                <td><?= $r->status ?></td>
                                                <td><?= $r->request_date ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No document requests found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div> <!-- /.container-fluid -->
            </div> <!-- /.content -->
        </div> <!-- /.content-page -->

        <?php include('includes/footer.php'); ?>
    </div> <!-- /#wrapper -->

    <!-- Only Core JS -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
</body>

</html>
