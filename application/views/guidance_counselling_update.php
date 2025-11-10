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
                                    <h4 class="page-title">COUNSELLING</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">+ Add New</button> -->
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
						<div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <h4 class="m-t-0 header-title mb-4">
											<!--<a href="<?= base_url(); ?>Page/profileEntry">
											<button type="button" class="btn btn-info waves-effect waves-light"> <i class=" fas fa-user-plus mr-1"></i> <span>Add New</span> </button>
											</a>-->
										</h4>
										<?php if($this->session->flashdata('success')) : ?>

                                                <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>'
                                                        .$this->session->flashdata('success'). 
                                                    '</div>'; 
                                                ?>
                                                <?php endif; ?>

                                                <?php if($this->session->flashdata('danger')) : ?>
                                                <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>'
                                                        .$this->session->flashdata('danger'). 
                                                    '</div>'; 
                                                ?>
                                                <?php endif;  ?>


                                                <form method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Report Against</label>
                        <select class="form-control" id="reportTypeSelector" name="AcctGroup">
                            <option value="Student" <?= $counselling->AcctGroup == 'Student' ? 'selected' : ''; ?>>Student</option>
                            <option value="Staff" <?= $counselling->AcctGroup == 'Staff' ? 'selected' : ''; ?>>Staff</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4" id="studentField" style="<?= ($counselling->AcctGroup == 'Student') ? '' : 'display:none;'; ?>">
                       <label>Student Name</label>
    <?php
        $stud = $this->db->get_where('studeprofile', ['StudentNumber' => $counselling->StudentNumber])->row();
        $fullName = $stud ? $stud->FirstName . ' ' . $stud->LastName : '';
    ?>
    <input type="text" class="form-control" value="<?= $fullName ?>" readonly>
                    </div>

                    <div class="form-group col-md-4" id="staffField" style="<?= ($counselling->AcctGroup == 'Staff') ? '' : 'display:none;'; ?>">
                       <label>Staff Name</label>
   <?php
$staff = $this->db->get_where('staff', ['IDNumber' => $counselling->StudentNumber])->row();
$staffName = $staff ? $staff->FirstName . ' ' . $staff->LastName : '';
?>
<input type="text" class="form-control" value="<?= $staffName ?>" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Record No.</label>
                        <input type="text" class="form-control" name="recordNo" value="<?= $counselling->recordNo; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Date</label>
                        <input type="date" class="form-control" name="recordDate" value="<?= $counselling->recordDate; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Return Schedule</label>
                        <input type="date" class="form-control" name="returnSchedule" value="<?= $counselling->returnSchedule; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Details</label>
                    <textarea name="details" class="form-control" rows="4"><?= $counselling->details; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Action Plan</label>
                    <textarea name="actionPlan" class="form-control" rows="3"><?= $counselling->actionPlan; ?></textarea>
                </div>

                <input type="submit" name="submit" value="Update Counselling Record" class="btn btn-primary">
            </form>
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

        
        <!-- Right Sidebar -->
			<?php include('includes/themecustomizer.php'); ?>
        <!-- /Right-bar -->


<?php include('includes/footer_plugins.php'); ?>           

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
</body>
</html>