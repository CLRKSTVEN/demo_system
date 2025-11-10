<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">UPDATE MEDICAL INFORMATION</h4>
                                <div class="page-title-right"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <?php if ($this->session->flashdata('success')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?= $this->session->flashdata('success'); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <?php $info = $med; ?>
                                    <form method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Account Group</label>
                                                <input type="text" class="form-control" name="AcctGroup" value="<?= $info->AcctGroup ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-6">

                                                <label class="col-form-label">
                                                    <?= ($info->AcctGroup === 'Student') ? 'Student Name' : 'Staff Name'; ?>
                                                </label>
                                                <input type="text" class="form-control" value="<?= $info->displayName ?>" readonly>

                                                </div>

                                        </div>

                                        <!-- <div class="form-row">
                                            <?php if ($info->AcctGroup === 'Student'): ?>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Student Number</label>
                                                    <input type="text" class="form-control" name="StudentNumber" value="<?= $info->StudentNumber ?>" readonly>
                                                </div>
                                            <?php else: ?>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label">Staff ID Number</label>
                                                    <input type="text" class="form-control" name="IDNumber" value="<?= $info->IDNumber ?>" readonly>
                                                </div>
                                            <?php endif; ?>
                                        </div> -->

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Height</label>
                                                <input type="text" class="form-control" name="height" value="<?= $info->height ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Weight</label>
                                                <input type="text" class="form-control" name="weight" value="<?= $info->weight ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Blood Type</label>
                                                <input type="text" class="form-control" name="bloodType" value="<?= $info->bloodType ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label">Vision</label>
                                                <input type="text" class="form-control" name="vision" value="<?= $info->vision ?>">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Food Allergies</label>
                                                <input type="text" class="form-control" name="allergiesFood" value="<?= $info->allergiesFood ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Drug Allergies</label>
                                                <input type="text" class="form-control" name="allergiesDrugs" value="<?= $info->allergiesDrugs ?>">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Special Physical Needs</label>
                                                <input type="text" class="form-control" name="specialPhyNeeds" value="<?= $info->specialPhyNeeds ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Special Dietary Needs</label>
                                                <input type="text" class="form-control" name="specialDieNeeds" value="<?= $info->specialDieNeeds ?>">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Eye Color</label>
                                                <input type="text" class="form-control" name="eyeColor" value="<?= $info->eyeColor ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label">Hair Color</label>
                                                <input type="text" class="form-control" name="hairColor" value="<?= $info->hairColor ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Respiratory Problems</label>
                                            <input type="text" class="form-control" name="respiratoryProblems" value="<?= $info->respiratoryProblems ?>">
                                        </div>

                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
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

    <!-- JS dependencies -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
