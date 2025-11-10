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
                        <?php 
                            $sn=$this->uri->segment(3);
                            $stud = $this->Common->one_cond_row('studeprofile','StudentNumber',$sn);
                            $st = $this->Common->two_cond_row('semesterstude','StudentNumber',$sn,'SY',$this->session->sy);
                            $sub = $this->Common->four_cond('registration','YearLevel',$st->YearLevel,'Section',$st->Section,'SY',$this->session->sy,'StudentNumber',$this->uri->segment(3));
                        ?>
<!-- renren -->
                       

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-title-box">
                                    
                                    <h4 class="page-title">
                                        <!-- <button type="button" class="btn btn-info waves-effect waves-light"> <i class=" fas fa-user-plus mr-1"></i> <span>Save</span> </button> -->
                                        
                                    </h4>
                                 
                                    <div class="clearfix"></div> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Add Subject</h4>

                                        <?php $att = array('class' => 'parsley-examples'); ?>
                                            <?= form_open('Ren/enlist_sub_insert', $att); ?>

                                            <div class="form-group">
                                                <label for="userName">Subject Discription<span class="text-danger">*</span></label>
                                                <select class="form-control" required name="sub">
                                                                    <option></option>
                                                                    <?php 
                                                                    $subject = $this->Common->three_cond_ob('semsubjects', 'SY', $this->session->sy, 'YearLevel', $st->YearLevel, 'strand',$st->Qualification,'SubjectCode','ASC');
                                                                    foreach($subject as $row){ ?>
                                                                        <option value="<?= $row->subjectid; ?>"><?= $row->Description; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                            </div>
                                            <input type="hidden" value="<?= $this->uri->segment('3')?>" name="stud_id">
                                            <input type="hidden" value="<?= $this->uri->segment('4')?>" name="sy">
                                            

                                            <div class="form-group text-right mb-0">
                                            <button type="submit" class="btn btn-primary float-left">Submit</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            
                        </div>
                        <!-- end row -->
		
                        <!-- end page title -->
						<div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                    <h4 class="m-t-0 header-title mb-4"><?= $stud->FirstName; ?> <?= $stud->MiddleName; ?> <?= $stud->LastName; ?> - <?= $sn; ?> </h4>
                                        
										<?php echo $this->session->flashdata('msg'); ?>

										<table class="table mb-0">
											<thead>
                                            <tr>
												<th>Subject Code</th>
												<th>Description</th>
                                                <th>Class Schedules</th>
                                                <th>Room</th>
												<th>Section</th>
                                                <?php if($st->Course == 'Senior High School'){ ?>
                                                <th>Semester</th>
                                                <?php } ?>
                                                <th>Teacher</th>
                                                <th>Action</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($sub as $row){ //$staff = $this->Common->one_cond_row('staff','IDNumber',$row->Instructor); ?>
                                            <tr>
                                                <td><?= $row->SubjectCode; ?></td>
                                                <td><?= $row->Description; ?></td>
                                                <td><?= $row->SchedTime; ?></td>
                                                <td><?= $row->Room; ?></td>
                                                <td><?= $row->Section; ?></td>
                                                <?php if($st->Course == 'Senior High School'){ ?>
                                                <td><?= $row->Sem; ?></td>
                                                <?php } ?>
                                                <td><?php // $staff->FirstName.' '.$staff->LastName; ?></td>
                                                <td><a href="<?= base_url(); ?>Ren/delete_subject_enlist/<?= $this->uri->segment(3); ?>/<?= $this->uri->segment(4); ?>/<?= $row->regnumber; ?>" onclick="return confirm('Are you sure you want to delete this subject?');" class="btn btn-sm btn-danger tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Delete"><i class="fas fa-times"></i></a></td>
                                            </tr>
                                            <?php } ?>
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