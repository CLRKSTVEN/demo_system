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
                            <h4 class="page-title">INCIDENTS UPDATE</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <?php if($this->session->flashdata('success')) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= $this->session->flashdata('success'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <?php if($this->session->flashdata('danger')) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= $this->session->flashdata('danger'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <form method="post">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">Report Against</label>
                                            <select class="form-control" id="reportTypeSelector" name="AcctGroup">
                                                <option value="Student" <?= $incident->AcctGroup == 'Student' ? 'selected' : ''; ?>>Student</option>
                                                <option value="Staff" <?= $incident->AcctGroup == 'Staff' ? 'selected' : ''; ?>>Staff</option>
                                            </select>
                                        </div>

                            <div class="form-group col-md-4" id="studentField" style="<?= ($incident->AcctGroup == 'Student') ? '' : 'display:none;'; ?>">
    <label class="col-form-label">Student Name</label>
    <?php
        $stud = $this->db->get_where('studeprofile', ['StudentNumber' => $incident->StudentNumber])->row();
        $studName = $stud ? $stud->FirstName . ' ' . $stud->LastName : '';
    ?>
    <input type="text" class="form-control" value="<?= $studName ?>" readonly>
</div>

<div class="form-group col-md-4" id="staffField" style="<?= ($incident->AcctGroup == 'Staff') ? '' : 'display:none;'; ?>">
    <label class="col-form-label">Staff Name</label>
   <?php
$staff = $this->db->get_where('staff', ['IDNumber' => $incident->StudentNumber])->row();
$staffName = $staff ? $staff->FirstName . ' ' . $staff->LastName : '';
?>
<input type="text" class="form-control" value="<?= $staffName ?>" readonly>
</div>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">Case No.</label>
                                            <input type="text" class="form-control" name="caseNo" value="<?= $incident->caseNo; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">Date</label>
                                            <input type="date" class="form-control" name="incidentDate" value="<?= $incident->incidentDate; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">Place</label>
                                            <input type="text" class="form-control" name="incPlace" value="<?= $incident->incPlace; ?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">Offense Level</label>
                                            <select class="form-control" name="offenseLevel">
                                                <option value="Minor Offense" <?= $incident->offenseLevel == 'Minor Offense' ? 'selected' : ''; ?>>Minor Offense</option>
                                                <option value="Major Offense" <?= $incident->offenseLevel == 'Major Offense' ? 'selected' : ''; ?>>Major Offense</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label class="col-form-label">Offense</label>
                                            <input type="text" class="form-control" name="offense" value="<?= $incident->offense; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Sanction</label>
                                        <input type="text" class="form-control" name="sanction" value="<?= $incident->sanction; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Action Taken</label>
                                        <input type="text" class="form-control" name="actionTaken" value="<?= $incident->actionTaken; ?>">
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
    <?php include('includes/themecustomizer.php'); ?>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const selector = document.getElementById('reportTypeSelector');
        const studentField = document.getElementById('studentField');
        const staffField = document.getElementById('staffField');

        selector.addEventListener('change', function () {
            if (this.value === 'Student') {
                studentField.style.display = 'block';
                staffField.style.display = 'none';
            } else if (this.value === 'Staff') {
                studentField.style.display = 'none';
                staffField.style.display = 'block';
            }
        });
    });
    </script>

    
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

        <!-- Responsive examples -->
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

        <!-- Datatables init -->
        <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
		
        <script src="<?php echo base_url()?>assets/js/sweetalert.min.js"></script>

        <!-- Plugins Js -->
        <script src="<?= base_url(); ?>assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/switchery/switchery.min.js"></script>

        <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>



        <!-- Init js-->
        <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>

</body>
</html>
