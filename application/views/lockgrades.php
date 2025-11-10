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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Grade Lock Schedule</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item">
                                            <span class="badge badge-purple mb-3">
                                                SY <b><?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?></b>
                                            </span>
                                        </li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <?= $this->session->flashdata('msg'); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            function format_datetime_local($dt)
                            {
                                return $dt ? date('Y-m-d\TH:i', strtotime($dt)) : '';
                            }
                            ?>
                            <form method="post" action="<?= base_url('Settings/save_lockgrades') ?>">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label>Prelim Lock Date & Time</label>
                                                <input type="datetime-local" name="prelim" class="form-control" value="<?= format_datetime_local($lock->prelim ?? '') ?>" >
                                            </div>
                                            <div class="col-md-3">
                                                <label>Midterm Lock Date & Time</label>
                                                <input type="datetime-local" name="midterm" class="form-control" value="<?= format_datetime_local($lock->midterm ?? '') ?>" >
                                            </div>
                                            <div class="col-md-3">
                                                <label>PreFinal Lock Date & Time</label>
                                                <input type="datetime-local" name="prefinal" class="form-control" value="<?= format_datetime_local($lock->prefinal ?? '') ?>" >
                                            </div>
                                            <div class="col-md-3">
                                                <label>Final Lock Date & Time</label>
                                                <input type="datetime-local" name="final" class="form-control" value="<?= format_datetime_local($lock->final ?? '') ?>" >
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success">Save Schedule</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
