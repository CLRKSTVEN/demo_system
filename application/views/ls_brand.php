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
                        <h4 class="page-title">
                        <!-- <a href="<?= base_url(); ?>Accounting/Addexpenses">    
                        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fas fa-stream mr-1"></i> <span>Add New</span> </button>
                        </a> -->
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Add New</button>

                        </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb p-0 m-0">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        <!-- <span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span></b> -->
                                    </a>
                                </li>
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
                        <div class="card-body">
                            <div class="clearfix">

                                <div class="float-left">
                                    <h5 style="text-transform:uppercase">
                                        <strong>BRANDS</strong>
                                      
                                      
                                    </h5>
                                </div>

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                            <tr>
                                                <!-- <th>Year Level</th> -->
                                                <th>Brand Name</th>
                                               
                                                <th style="text-align:center">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $row) { ?>
                                            <tr>
                                            <td><?= $row->brand; ?></td>
                                               
                                               
                                                <td style="text-align: center;">
                                                    <!-- <a href="<?= base_url('Settings/updateTrack_strand?trackID=' . $row->trackID); ?>" class="btn btn-primary waves-effect waves-light btn-sm">
                                                        <i class="mdi mdi-pencil"></i>Edit
                                                    </a> -->

                                                    <button type="button" class="btn btn-primary waves-effect waves-light btn-sm" 
                                                            onclick="editProgram('<?= $row->brandID; ?>', '<?= $row->brand; ?>')" 
                                                            data-toggle="modal" data-target="#editModal">
                                                        <i class="mdi mdi-pencil"></i>Edit
                                                    </button>

                                                    <a href="#" onclick="setDeleteUrl('<?= base_url('Settings/DeleteBrand?brandID=' . $row->brandID); ?>')" data-toggle="modal" data-target="#confirmationModal"  class="btn btn-danger waves-effect waves-light btn-sm">
                                                    <i class="ion ion-ios-alert"></i> Delete
                                                    </a>

                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- Update Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Update Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('Settings/updateBrand'); ?>">
                   <!-- Hidden input for brandID -->
                        <input type="hidden" id="BrandID" name="brandID">

                        <!-- Text input for brandName -->
                        <div class="col-md-12 mb-3">
                            <label for="brandName">Brand Name</label>
                            <input type="text" class="form-control" id="brandName" name="brand" required>
                        </div>

                        
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="update" value="Update Data" class="btn btn-primary waves-effect waves-light" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function editProgram(BrandID, brand) {
    document.getElementById('BrandID').value = BrandID;  // Hidden input
    document.getElementById('brandName').value = brand;  // Brand Name input
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
                <a href="#" id="deleteButton" class="btn btn-danger" onclick="deleteData()">Delete</a>
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
    function setDeleteUrl(url) {
        document.getElementById('deleteButton').href = url;
    }

    function deleteData() {
        // This will now correctly delete the selected item
    }
</script>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add New</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('Settings/brand'); ?>">
                    <div class="form-row align-items-center">
                        <div class="col-md-12 mb-3">
                            <label for="CourseCode">Brand Name</label>
                            <input type="text" class="form-control" id="brand" name="brand" required>
                        </div>
                      
                    </div>
                   
                    <div class="modal-footer">
                        <input type="submit" name="save" value="Save Data" class="btn btn-primary waves-effect waves-light" />
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                    </div>


        </div>
    </div>
</div>



                

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