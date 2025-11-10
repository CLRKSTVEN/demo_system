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
                        <div class="col-sm-12">
                            <div class="profile-bg-picture" style="background-image:url('<?= base_url(); ?>assets/images/bg-profile.jpg')">
                                <span class="picture-bg-overlay"></span>
                                <!-- overlay -->
                            </div>
                            <!-- meta -->
                            <div class="profile-user-box">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="profile-user-img"><img src="<?= base_url(); ?>upload/profile/<?php echo $data1[0]->avatar; ?>" alt="" class="avatar-lg rounded-circle"></div>
                                        <div class="">
                                            <h4 class="mt-5 font-18 ellipsis"><?php echo $data->FirstName . ' ' . $data->MiddleName . ' ' . $data->LastName . ' ' . $data->NameExtn; ?></h4>
                                            <p class="font-13"> <?php echo $data->empPosition; ?><br>
                                           <small><?php echo $data->resStreet . ' ' . $data->resVillage . ' ' . $data->resBarangay . ', ' . $data->resCity . ', ' . $data->resProvince; ?></small></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-right">
                                            <a href="<?= base_url(); ?>page/updatePersonnelProfile?id=<?php echo $data->IDNumber; ?>">
                                                <button type="button" class="btn btn-success waves-effect waves-light"> <i class="far fa-edit mr-1"></i> <span>Edit Profile</span> </button>
                                            </a>

                                            <a href="<?= base_url(); ?>page/upload201files?id=<?php echo $data->IDNumber; ?>">
                                                <button type="button" class="btn btn-info waves-effect waves-light"> <i class="fas fa-cloud-upload-alt mr-1"></i> <span>Upload 201 Files</span> </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ meta -->
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="card p-0">
                                <div class="card-body p-0">

                                    <?php if ($this->session->flashdata('success')) : ?>

                                        <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>'
                                            . $this->session->flashdata('success') .
                                            '</div>';
                                        ?>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('danger')) : ?>
                                        <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>'
                                            . $this->session->flashdata('danger') .
                                            '</div>';
                                        ?>
                                    <?php endif;  ?>

                                    <ul class=" nav nav-tabs tabs-bordered nav-justified">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#aboutme">About</a></li>
                                        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#family">Family</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#education">Education</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cs">Civil Service</a></li>
											<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#trainings">Trainings</a></li> -->
                                        <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#work">Work Experience</a></li>-->
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#file201">201 Files</a></li>
                                    </ul>

                                    <div class="tab-content m-0 p-4">

                                        <div id="aboutme" class="tab-pane active">
                                            <div class="profile-desk">
                                                <!--<h5 class="text-uppercase font-weight-bold"><?php echo $data->FirstName . ' ' . $data->MiddleName . ' ' . $data->LastName; ?></h5>
                                                    <div class="designation mb-4"><?php echo $data->empPosition; ?></div>
                                                    <p class="text-muted">
                                                        I have 10 years of experience designing for the web, and specialize in the areas of user interface design, interaction design, visual design and prototyping. I’ve worked with notable startups including Pearl Street Software.
                                                    </p> -->

                                                <h5 class="mt-4">Official Information</h5>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <!--<h5 class="mt-4">Official Information</h5>-->
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Employee No.</th>
                                                                    <td>
                                                                        <?php echo $data->IDNumber; ?>
                                                                    </td>
                                                                </tr>
                                                                <!-- <tr>
                                                                    <th scope="row">Job Title</th>
                                                                    <td>
                                                                        <?php echo $data->jobTitle; ?>
                                                                    </td>
                                                                </tr> -->

                                                                <tr>
                                                                    <th scope="row">Position</th>
                                                                    <td>
                                                                        <?php echo $data->empPosition; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Emp. Status</th>
                                                                    <td>
                                                                        <?php echo $data->empStatus; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Department</th>
                                                                    <td>
                                                                        <?php echo $data->Department; ?>
                                                                    </td>
                                                                </tr>

                                                            </tbody>

                                                        </table>
                                                    </div>


                                                    <div class="col-sm-4">
                                                        <!--<h5 class="mt-4">Contact Person</h5>-->
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>

                                                                <tr>
                                                                    <th scope="row">Date Hired</th>
                                                                    <td>
                                                                        <?php echo $data->dateHired; ?>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th scope="row">TIN</th>
                                                                    <td>
                                                                        <?php echo $data->tinNo; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">GSIS BP No.</th>
                                                                    <td>
                                                                        <?php echo $data->gsis; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <!--<h5 class="mt-4">Contact Person</h5>-->
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>

                                                                <tr>
                                                                    <th scope="row">PAG-IBIG No.</th>
                                                                    <td>
                                                                        <?php echo $data->pagibig; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">SSS</th>
                                                                    <td>
                                                                        <?php echo $data->sssNo; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">PhilHealth No.</th>
                                                                    <td>
                                                                        <?php echo $data->philHealth; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>

                                                <h5 class="mt-4">Personal Information</h5>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <!--<h5 class="mt-4">Official Information</h5>-->
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Gender</th>
                                                                    <td>
                                                                        <?php echo $data->Sex; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Birth Date</th>
                                                                    <td>
                                                                        <?php echo $data->BirthDate; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Birth Place</th>
                                                                    <td>
                                                                        <?php echo $data->BirthPlace; ?>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <div class="col-sm-4">
                                                        <!--<h5 class="mt-4">Contact Person</h5>-->
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Blood Type</th>
                                                                    <td>
                                                                        <?php echo $data->bloodType; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Marital Status</th>
                                                                    <td>
                                                                        <?php echo $data->MaritalStatus; ?>
                                                                    </td>
                                                                </tr>


                                                            </tbody>

                                                        </table>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <!--<h5 class="mt-4">Contact Person</h5>-->
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>


                                                                <tr>
                                                                    <th scope="row">Height</th>
                                                                    <td>
                                                                        <?php echo $data->height; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Weight</th>
                                                                    <td>
                                                                        <?php echo $data->weight; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h5 class="mt-4">Contact Information</h5>
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Contact No.</th>
                                                                    <td>
                                                                        <?php echo $data->empMobile; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Official Email</th>
                                                                    <td>
                                                                        <?php echo $data->empEmail; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Address</th>
                                                                    <td class="ng-binding"><?php echo $data->resStreet . ' ' . $data->resVillage . ' ' . $data->resBarangay . ', ' . $data->resCity . ', ' . $data->resProvince; ?></td>
                                                                </tr>



                                                            </tbody>

                                                        </table>
                                                    </div>


                                                    <div class="col-sm-6">
                                                    </div>
                                                </div>

                                            </div> <!-- end profile-desk -->
                                        </div> <!-- about-me -->

                                        <!-- Family -->
                                        <div id="family" class="tab-pane">

                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Name</th>
                                                        <th style="text-align: center;">Relationship</th>
                                                        <th style="text-align: center;">Birth Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($data2 as $row) {
                                                        echo "<tr>";
                                                        echo "<td style='text-align:center'>" . $row->fullName . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->relationship . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->bDate . "</td>";

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                            </table>
                                            <br />
                                            <button type="button" class="btn btn-primary btn-xs">Add</button></a>

                                        </div>

                                        <!-- Education -->
                                        <div id="education" class="tab-pane">

                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Level</th>
                                                        <th style="text-align: center;">School Name</th>
                                                        <th style="text-align: center;">Course</th>
                                                        <th style="text-align: center;">Year Started</th>
                                                        <th style="text-align: center;">Year Graduated</th>
                                                        <th style="text-align: center;">Scholarship</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($data3 as $row) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row->level . "</td>";
                                                        echo "<td>" . $row->schoolName . "</td>";
                                                        echo "<td>" . $row->course . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->yearStarted . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->yearGraduated . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->scholarship . "</td>";

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                            </table>
                                            <br />
                                            <button type="button" class="btn btn-primary btn-xs">Add</button></a>
                                        </div>

                                        <!-- Civil Service -->
                                        <div id="cs" class="tab-pane">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Title</th>
                                                        <th style="text-align: center;">Rating</th>
                                                        <th style="text-align: center;">Date of Exam</th>
                                                        <th style="text-align: center;">Place of Exam</th>
                                                        <th style="text-align: center;">License No.</th>
                                                        <th style="text-align: center;">Validity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($data4 as $row) {
                                                        echo "<tr>";
                                                        echo "<td style='text-align:center'>" . $row->licenseTitle . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->rating . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->examDate . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->examPlace . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->licenseNo . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->validity . "</td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                            </table>
                                            <br />
                                            <button type="button" class="btn btn-primary btn-xs">Add</button></a>
                                        </div>
                                        <!-- Trainings -->
                                        <div id="trainings" class="tab-pane">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Training Title</th>
                                                        <th style="text-align: center;">Date Started</th>
                                                        <th style="text-align: center;">Date Finished</th>
                                                        <th style="text-align: center;">Hours</th>
                                                        <th style="text-align: center;">Type</th>
                                                        <th style="text-align: center;">Conducted By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($data5 as $row) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row->trainingTitle . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->dateStarted . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->dateFinished . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->noHours . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->ldType . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->sponsor . "</td>";

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                            </table>
                                            <br />
                                            <button type="button" class="btn btn-primary btn-xs">Add</button></a>

                                        </div>
                                        <!-- Work Experience -->
                                        <div id="work" class="tab-pane">
                                            <table id="example4" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Company Name</th>
                                                        <th>Designation</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>

                                            <br />
                                            <button type="button" class="btn btn-primary btn-xs">Add</button></a>

                                        </div>
                                        <!-- 201 Files -->
                                        <div id="file201" class="tab-pane">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Document Name</th>
                                                        <th style="text-align: center;">Date Uploaded</th>
                                                        <th style="text-align: center;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($data6 as $row) {
                                                        echo "<tr>";
                                                        echo "<td >" . $row->docName . "</td>";
                                                        echo "<td style='text-align:center'>" . $row->dateUploaded . "</td>";
                                                    ?>
                                                        <td style='text-align:center'>
                                                            <a href="<?= base_url(); ?>upload/201files/<?php echo $row->fileName; ?>" target="_blank" class="text-success"><i class="mdi mdi-file-document-box-check-outline"></i>View</a>
                                                            <a href="<?= base_url(); ?>Page/del_201/<?php echo $row->fileID; ?>" class="text-danger"><i class="mdi mdi-file-document-box-check-outline"></i>Delete</a>

                                                        </td>


                                                    <?php
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                    </div>
                    <!-- end row -->

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

</body>

</html>