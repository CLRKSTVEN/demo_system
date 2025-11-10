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
                        <div class="col-12">
                            <div class="page-title-box">
                                
                                        <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="m-t-0 header-title mb-4">
                                        New Entry

                                    </h4>

                                    <?= form_open_multipart('Library/ebook_edit'); ?>

                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label for="userName">Title<span class="text-danger">*</span></label>
                                                <input type="text" name="title" parsley-trigger="change" required placeholder="Title" class="form-control" id="userName" value="<?= $ebook->title; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="text">Author</label>
                                                <select class="form-control" data-toggle="select2" name="author">
                                                    <option>Select</option>
                                                    <?php foreach($ebook_author as $row){ ?>
                                                    <option <?php if($row->authorID == $ebook->author){echo " selected ";} ?> value="<?= $row->authorID; ?>"><?= $row->FirstName.' '.$row->MiddleName.' '.$row->LastName; ?></option>
                                                    <?php } ?>
                                                    
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="text">ISBN</label>
                                                <input  type="text" required placeholder="ISBN" class="form-control" name="isbn" value="<?= $ebook->isbn; ?>">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="text">Publication Date</label>
                                                <input  type="date" required placeholder="Publication Date" class="form-control" name="pub_date" value="<?= $ebook->pub_date; ?>">
                                            </div>
                                        </div>  

                                        <div class="row">
                                            

                                            <div class="form-group col-lg-12">
                                                            <label for="text">Genre</label>
                                                                <?php $arg=array(
                                                                    '1'=>'Biography & Memoir',
                                                                    '2'=>'Fiction & Literature',
                                                                    '3'=>'Nonfiction',
                                                                    '4'=>'Business & Finance',
                                                                    '5'=>'Periodicals',
                                                                    '6'=>'Comics, Graphic Novels, & Manga',
                                                                    '7'=>'Kids',
                                                                    '8'=>'Romans',
                                                                    '9'=>'Science Fiction & Fantasy',
                                                                    '10'=>'Mystery & Suspense',
                                                                    '11'=>'Young Adult - YA',
                                                                ); ?>
                                                                <select class="form-control" name="genre">
                                                                    <?php foreach($arg as $key=>$row){?>
                                                                    <option <?php if($key == $ebook->genre){echo " selected ";} ?> value="<?= $key; ?>"><?= $row; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                        </div>

                                        </div>  
                                        <input type="hidden" value="<?= $ebook->id; ?>" name="id">

                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label for="emailADescriptionddress">Description</label>
                                                <textarea class="form-control" rows="5" id="example-textarea" name="description"><?= $ebook->description; ?></textarea>
                                            </div>
                                        </div>

                                            <div class="form-group text-right mb-0">

                                                <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light mr-1" name="submit">
                                            </div>

                                        </form>
                                    


                                </div>
                            </div>


                        </div>
                    </div>



                </div>

            </div>
            <!-- end col -->


        </div>
        <!-- End row -->

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

</body>




</html>