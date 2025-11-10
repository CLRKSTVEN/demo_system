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

                                    <?= form_open_multipart('Library/ebook_new'); ?>

                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label for="userName">Title<span class="text-danger">*</span></label>
                                                <input type="text" name="title" parsley-trigger="change" required placeholder="Title" class="form-control" id="userName">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="text">Author<span class="text-danger">*</span></label>
                                                <select class="form-control" data-toggle="select2" name="author">
                                                    <option>Select</option>
                                                    <?php foreach($ebook_author as $row){ ?>
                                                    <option value="<?= $row->authorID; ?>"><?= $row->FirstName.' '.$row->MiddleName.' '.$row->LastName; ?></option>
                                                    <?php } ?>
                                                    
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="text">ISBN</label>
                                                <input  type="text" placeholder="ISBN" class="form-control" name="isbn">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="text">Publication Date</label>
                                                <input  type="date" placeholder="Publication Date" class="form-control" name="pub_date">
                                            </div>
                                        </div>  

                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="text">File<span class="text-danger">*</span></label>
                                                <input  type="file" required placeholder="File" class="form-control" name="file_image">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="text">Cover Image</label>
                                                <input  type="file"  placeholder="Cover Image" class="form-control" name="cover_image">
                                            </div>

                                            

                                            <div class="form-group col-lg-4">
                                                            <label for="text">Genre</label>
                                                                <!-- <?php $arg=array(
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
                                                                ); ?> -->
                                                                <select class="form-control" name="genre">
                                                                    <option>Select</option>
                                                                    <?php foreach($ebook_cat as $row){?>
                                                                    <option value="<?= $row->catID; ?>"><?= $row->Category; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                        </div>

                                        </div>  

                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label for="emailADescriptionddress">Description</label>
                                                <textarea class="form-control" rows="5" id="example-textarea" name="description"></textarea>
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

    <!-- Plugins Js -->
    <script src="<?= base_url(); ?>assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/switchery/switchery.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    <!-- Init js-->
    <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    

</body>




</html>