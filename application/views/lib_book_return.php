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


                    <?php if ($this->session->flashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('message'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-title-box">
                                <h4 class="page-title">
                                    <a href="<?= base_url(); ?>Library/borrow_add">
                                        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fas fa-stream mr-1"></i> <span>Add New</span> </button>
                                    </a>
                                    </h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb p-0 m-0">
                                            <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span></b></a></li> -->
                                        </ol>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- start row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <!-- <div class="panel-heading">
                                                    <h4>Invoice</h4>
                                                </div> -->
                                    <div class="card-body">
                                        <div class="clearfix">
										
										  <div class="float-left">
                                                <h5 style="text-transform:uppercase"><strong>CIRCULATIONS - RETURNED BOOKS</strong>
												<!-- <br /><span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span> -->
												</h5>
                                            </div>
                                            <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                    <th>Book No</th>
                                                    <th>Title</th>
                                                    <th>Author</th>
                                                    <th>Student's Name</th>
                                                    <th>Borrowed Date</th>
                                                    <th>Return Date</th>
                                                    <th>Penalty</th>

                                            
                                                        
                                                        <!-- <th style="text-align:center">Manage</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
    <?php foreach ($data as $row) { 
    ?>
        <tr>
            <td><?= $row->bookNo; ?></td>
            <td><?= $row->title; ?></td>
            <td><?= $row->author; ?></td>
            <td><?= $row->name; ?></td>
            <td><?= $row->borrow_date; ?></td>
            <td><?= $row->return_date; ?></td>
            <td><?= number_format($row->penalty_paid, 2); ?></td>
            <!-- <td style="text-align:center">
                <a href="<?= base_url('Library/update_borrow?bookID=' . $row->bookID); ?>" 
                   class="btn btn-primary waves-effect waves-light btn-sm">
                    <i class="mdi mdi-pencil"></i> Edit
                </a>

                <button class="btn btn-success btn-sm" data-toggle="modal" 
                    data-target="#receiveModal" 
                    onclick="setReceiveData('<?= $row->bookID; ?>', '<?= $row->bookNo; ?>', <?= number_format($row->penalty_paid, 2); ?>)">
                    <i class="mdi mdi-check"></i> Receive
                </button>
            </td> -->
        </tr>
    <?php } ?> 
</tbody>

                                                </table>  
                                        </div>
                                        <hr>


                                    </div>
                                </div>

                            </div>

                        </div>

						</div>
						</div>	
                    </div>


                   <!-- Receive Confirmation Modal -->
<div class="modal fade" id="receiveModal" tabindex="-1" role="dialog" aria-labelledby="receiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiveModalLabel">Confirm Book Return</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Library/receiveBook'); ?>" method="post">
                <div class="modal-body">
                    <p>Are you sure you want to receive this book?</p>
                    <p><strong>Penalty to be paid: </strong>₱<span id="penaltyAmount"></span></p>

                    <input type="hidden" name="bookID" id="bookID">
                    <input type="hidden" name="bookNo" id="bookNo">
                    <input type="hidden" name="penalty_paid" id="penaltyPaid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function setReceiveData(bookID, bookNo, penalty) {
    document.getElementById("bookID").value = bookID;
    document.getElementById("bookNo").value = bookNo;
    document.getElementById("penaltyPaid").value = penalty;
    document.getElementById("penaltyAmount").innerText = penalty.toFixed(2);
}
</script>



                    <!-- end container-fluid -->
                      <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="circle-with-stroke d-inline-flex justify-content-center align-items-center">
                                <span class="h1 text-danger">!</span>
                            </div>
                            <p class="mt-3">Are you sure you want to delete this data?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="<?= base_url('Library/Delete_other_settings?bookID=' . $row->bookID); ?>'); ?>" class="btn btn-danger" onclick="deleteData()">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .circle-with-stroke {
                width: 100px;
                height: 100px;
                border: 4px solid #dc3545;
                border-radius: 50%;
            }
        </style>

        <script>
            var deleteUrl = "";

            function setDeleteUrl(url) {
                deleteUrl = url;
            }

            function deleteData() {
                // Proceed with deletion
                window.location.href = deleteUrl;
            }
        </script>


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
		<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!-- Responsive examples -->
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

        <!-- Datatables init -->
        <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
		
		
    </body>
</html>