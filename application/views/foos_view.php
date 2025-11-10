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
         <style>
            .hover-container {
                position: relative;
                display: inline-block;
            }

            .hover-image {
                display: block;
            }

            .hover-link {
                position: absolute;
                bottom: 0; /* Adjust as needed */
                left: 0; /* Adjust as needed */
                background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
                color: white;
                padding: 10px 5px;
                width:100%;
                border-radius:0;
                border:0;
                text-decoration: none;
                display: none; /* Hide link by default */
            }

            .hover-container:hover .hover-link {
                display: block; /* Show link on hover */
            }
         </style>

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">
                                    <a href="<?= base_url(); ?>Library/ebook_new">
                                        <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fas fa-stream mr-1"></i> <span>Add New</span> </button>
                                    </a>
                                    <h4>
                                        <div class="page-title-right">
                                            <ol class="breadcrumb p-0 m-0">
                                                <!-- <li class="breadcrumb-item"><a href="#"><span class="badge badge-purple mb-3">Currently login to <b>SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span></b></a></li> -->
                                            </ol>
                                        </div>
                                        <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <?php
                                        // Define alert types and their respective classes
                                        $alert_types = [
                                            'success' => 'success',
                                            'danger'  => 'danger',
                                        ];

                                        foreach ($alert_types as $type => $class) {
                                            $message = $this->session->flashdata($type);
                                            if ($message) {
                                                echo '<div class="alert alert-' . htmlspecialchars($class) . ' alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>' .
                                                        htmlspecialchars($message) .
                                                    '</div>';
                                            }
                                        }
                    ?>


                        <div class="row">

                          

                            <?php
                                if( ! empty( $foos ) )
                                foreach($foos as $row){ 
                                $author = $this->Common->one_cond_row('libauthors','authorID',$row->author);
                            ?>
                            <div class="col-sm-6 col-xl-2">

                                <!-- Simple card -->
                                <div class="card">
                                    <div class="hover-container">
                                        <a href="<?= base_url(); ?>upload/ebook/<?= $row->file_path; ?>" target="_blank"><img class="card-img-top img-fluid hover-image" src="<?= base_url(); ?>upload/ebook/<?= $row->cover_image; ?>" alt="Card image cap"></a>
                                        <a href="#" class="btn btn-primary btn-xs waves-effect waves-light hover-link renrenguapo" data-toggle="modal" data-target=".cover_image" data-id="<?= $row->id; ?>">Edit Cover Photo</a>
                                    </div>
                                    
                                    <div class="card-body">
                                        <h5>
                                            <a href="<?= base_url(); ?>upload/ebook/<?= $row->file_path; ?>" target="_blank" class="text-danger"><?= $row->title; ?></a><br />
                                            <span style="font-size:14px"><?= $author->FirstName.' '.$author->MiddleName.' '.$author->LastName; ?></span>
                                        </h5>
                                        <!-- <p class="card-text"><?= substr_replace($row->description, "...", 50);; ?></p> -->
                                        <a href="<?= base_url(); ?>Library/ebook_edit/<?= $row->id; ?>" class="btn btn-primary mr-1  btn-sm renrenguapo" data-id="<?= $row->id; ?>" data-toggle="modal" data-target=".file_attach"><i class="fas fa-paperclip tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit File Attachment"></i></a>
                                        <a href="<?= base_url(); ?>Library/ebook_edit/<?= $row->id; ?>" class="btn btn-success mr-1  btn-sm"><i class="fas fa-pencil-alt tooltips" data-placement="top" data-toggle="tooltip" data-original-title="Edit"></i></a>
                                        
                                        <a onclick="return confirm('Are you sure?')" href="<?= base_url(); ?>Library/ebook_delete/<?= $row->id; ?>" class="btn btn-danger mr-1  btn-sm"><i class="fas fa-times" data-placement="top" data-toggle="tooltip" data-original-title="Edit"></i></a>
                                    </div>
                                </div>

                            </div>
                            <!-- end col -->
                        <?php } ?>
                            

                        </div>
                        <!-- end row -->
                         

                      <?php echo $pagination_links; ?>
                        
                        



                </div>

            </div>
            <!-- end col -->


        </div>
        <!-- End row -->

    </div>
    <!-- end container-fluid -->

    </div>
    <!-- end content -->

                                        <div class="modal fade file_attach" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabel">Edit File</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <?php 
                                                                    $attributes = array('class' => 'parsley-examples');
                                                                    echo form_open_multipart('Library/ebook_file_update', $attributes);
                                                                ?>
                                                                    
                                                                    
                                                                    <div class="form-group row">
                                                                        <label for="hori-pass1" class="col-md-4 col-form-label">Select JPG File<span class="text-danger">*</span></label>
                                                                        <div class="col-md-7">
                                                                            <input id="myInput" type="file"  name="file_image"  required class="form-control">
                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" id="id" name="id" value="">

                                                                
                                                                    
                                                                    <div class="form-group row mb-0">
                                                                        <div class="col-md-8 offset-md-4">
                                                                            <button type="submit" class="btn btn-success waves-effect waves-light mr-1">
                                                                                Submit
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->

                                        <div class="modal fade cover_image" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabel">Update Cover Image</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                            <?php 
                                                                    $attributes = array('class' => 'parsley-examples');
                                                                    echo form_open_multipart('Library/ebook_cover_update', $attributes);
                                                                ?>
                                                                    
                                                                    
                                                                    <div class="form-group row">
                                                                        <label for="hori-pass1" class="col-md-4 col-form-label">Select JPG File<span class="text-danger">*</span></label>
                                                                        <div class="col-md-7">
                                                                            <input id="myInput" type="file"  name="cover_image"  required class="form-control">
                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" id="id" name="id" value="">
                                                                    
                                                                    <div class="form-group row mb-0">
                                                                        <div class="col-md-8 offset-md-4">
                                                                            <button type="submit" class="btn btn-success waves-effect waves-light mr-1">
                                                                                Submit
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->


                                        



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

    <script src="<?= base_url(); ?>assets/libs/fullcalendar/fullcalendar.min.js"></script>

    <!-- Calendar init -->
    <script src="<?= base_url(); ?>assets/js/pages/calendar.init.js"></script>

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

    <script src="<?= base_url(); ?>assets/libs/jquery-ui/jquery-ui.min.js"></script>
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

    <script type="text/javascript">
                                            $(document).on("click", ".renrenguapo", function () {
                                                var myBookId = $(this).data('id');
                                                $(".modal-body #id").val( myBookId );

                                                var itemid = $(this).data('item');
                                                $(".modal-body #item").val( itemid );

                                                var jobid = $(this).data('job');
                                                $(".modal-body #job").val( jobid );

                                                var appid = $(this).data('appid');
                                                $(".modal-body #appid").val( appid );

                                                });
                                        </script>

</body>




</html>