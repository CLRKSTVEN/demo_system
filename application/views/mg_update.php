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
                                    
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
		
                        <!-- end page title -->
						<div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body table-responsive">
                                            <div class="float-left">

                                                <h4 class="m-t-0 header-title mb-1"><b><?= $stud->LastName; ?>, <?= $stud->FirstName; ?> <?= $stud->MiddleName; ?></b>
                                                    <br />
                                                    <span class="badge badge-primary mb-1"> <b><?= $stud->StudentNumber; ?></b></span>
                                                    <span class="badge badge-purple mb-1"> <b><?php echo $grades[0]->SY . ' ' . $grades[0]->Sem; ?></b></span>
                                                    <?php $ins = $this->Common->one_cond_row('staff', 'IDNumber', $g->Instructor); ?>

                                                </h4>

                                            </div>
                                            <div class="float-right">
                                                <div class="d-print-none">
                                                    <div class="float-right">
                                                        <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php $att = array('class' => 'parsley-examples'); ?>
                                            <?= form_open('Ren/updateGrade', $att); ?>

                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Description</th>
                                                        <th>Teacher</th>
                                                        <th style="text-align: center;">1st Grading</th>
                                                        <th style="text-align: center;">2nd Grading</th>
                                                        <th style="text-align: center;">3rd Grading</th>
                                                        <th style="text-align: center;">4th Grading</th>
                                                        <th style="text-align: center;">Average</th>
                                                    </tr>
                                                </thead>
                                                </thead>
                                                <tbody>
                                                    <?php $c = 1;
                                                    foreach ($grades as $row) {
                                                        $s = $this->Common->one_cond_row('studeprofile','StudentNumber',$row->StudentNumber);
                                                        $adviser = $this->Common->three_cond_row('semesterstude', 'StudentNumber', $row->StudentNumber, 'SY', $this->session->sy, 'YearLevel', $g->YearLevel);

                                                    ?>
                                                        <tr>
                                                            <th><?= $c++; ?></th>
                                                            <td><?= $row->SubjectCode; ?>
                                                                <input type="hidden" name="StudentNumber[]" value="<?= $row->StudentNumber; ?>">
                                                                <input type="hidden" name="SubjectCode" value="<?= $this->input->get('subjectcode'); ?>">
                                                                <input type="hidden" name="description" value="<?= $this->input->get('description'); ?>">
                                                                <input type="hidden" name="section" value="<?= $this->input->get('section'); ?>">
                                                                <input type="hidden" name="SY" value="<?= $this->session->sy; ?>">
                                                                <input type="hidden" name="Instructor" value="<?= $g->Instructor; ?>">
                                                                <input type="hidden" name="adviser[]" value="<?= $adviser->IDNumber; ?>">
                                                                <input type="hidden" name="gradeID[]" value="<?= $row->gradeID; ?>">
                                                            </td>
                                                            <td><?= $row->Instructor; ?></td>
                                                            <td class="text-center"><input type="text" style="width:70%" class="text-center" <?php if ($row->firstStat == 'Closed') {
                                                                                                                                                    echo 'disabled';
                                                                                                                                                } ?> value="<?= $row->PGrade; ?>" name="PGrade[]"></td>
                                                           
                                                            <td class="text-center"><input type="text" style="width:70%" class="text-center" <?php if ($row->secondStat == 'Closed') {
                                                                                                                                                    echo 'disabled';
                                                                                                                                                } ?> value="<?= $row->MGrade; ?>" name="MGrade[]"></td>
                                                                                                                                            
                                                            <td class="text-center"><input type="<?php if($row->MGrade != 0){echo "text";}else{echo 'hidden';}?>" style="width:70%" class="text-center" <?php if ($row->thirdStat == 'Closed') {
                                                                                                                                                    echo 'disabled';
                                                                                                                                                } ?> value="<?= $row->PFinalGrade; ?>" name="PFinalGrade[]"></td>
                                                                                                                                                
                                                                                                                                                    
                                                            <td class="text-center">  <input type="<?php if($row->PFinalGrade != 0){echo 'text';}else{echo 'hidden';}?>" style="width:70%" class="text-center" <?php if ($row->fourthStat == 'Closed') {
                                                                                                                                                    echo 'disabled';
                                                                                                                                                } ?> value="<?= $row->FGrade; ?>" name="FGrade[]"></td>
                                                            
                                                            <td class="text-center"><?= $row->Average; ?></td>

                                                        </tr>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                            <div class="form-group text-right mb-0">
                                                <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                                                    Update
                                                </button>
                                            </div>
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

        
     

        <!-- Vendor js -->
        <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
        

        <!-- App js -->
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

        <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

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

        <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
        <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>
        <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>


    </body>
</html>