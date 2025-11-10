<?php include('includes/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">UPDATE MEDICAL RECORDS</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php if ($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?= $this->session->flashdata('success'); ?>
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        </div>
                                    <?php endif; ?>

                                    <form method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                               <label class="col-form-label"><?= ($record->AcctGroup === 'Student') ? 'Student Name' : 'Staff Name'; ?></label>

<input type="text" class="form-control" value="<?= $record->displayName ?>" readonly>

                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Case No.</label>
                                                <input type="text" class="form-control" name="caseNo" value="<?= $record->caseNo ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Date</label>
                                                <input type="date" class="form-control" name="incidentDate" value="<?= $record->incidentDate ?>">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Temperature</label>
                                                <input type="text" class="form-control" name="temperature" value="<?= $record->temperature ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">BP</label>
                                                <input type="text" class="form-control" name="bp" value="<?= $record->bp ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Pain Tolerance (1-10)</label>
                                                <input type="number" class="form-control" name="painTolerance" min="0" max="10" value="<?= $record->painTolerance ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Major Complaint</label>
                                            <input type="text" class="form-control" name="complaint" value="<?= $record->complaint ?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Medication</label>
                                            <input type="text" class="form-control" name="medication" value="<?= $record->medication ?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Other Details</label>
                                            <input type="text" class="form-control" name="otherDetails" value="<?= $record->otherDetails ?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Notes</label>
                                            <input type="text" class="form-control" name="otherNotes" value="<?= $record->otherNotes ?>">
                                        </div>

                                        <input type="submit" name="submit" class="btn btn-primary" value="Update Record">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <?php include('includes/themecustomizer.php'); ?>

    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
