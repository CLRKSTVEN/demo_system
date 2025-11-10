<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

                	<?php if($this->session->flashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('msg'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title"> <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg"><i class=" fas fa-user-plus mr-1"></i> Enroll New</button></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <form class="form-inline mb-1" method="post" action="<?= base_url('Masterlist/enrolledList') ?>">
                                            <label for="sy" class="mr-2">SY</label>
                                            <select id="sy" name="sy" class="form-control mr-2" style="width: 200px;">
                                                <?php foreach ($school_years as $row): ?>
                                                    <option value="<?= $row->SY ?>" <?= ($row->SY == $selected_sy) ? 'selected' : '' ?>>
                                                        <?= $row->SY ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </form>

                                    </ol>
                                </div>
                                <div class="clearfix"></div>

                                <hr style="border: 0; height: 4px; background: linear-gradient(to right, #4285F4 50%, #DB4437 16%, #F4B400 17%, #0F9D58 17%);" />
                            </div>
                        </div>
                    </div>

                    <!-- end page title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="m-t-0 header-title mb-4">List of Enrolled Students <br /><span class="badge badge-purple mb-3"><b>SY <?= isset($selected_sy) ? $selected_sy : $this->session->userdata('sy'); ?>
                                            </b></span></h4>
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
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Student No.</th>
                                                <th>LRN</th>
                                                <th>Year Level</th>
                                                <th>Section</th>
                                                <th style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php
                                            $i = 1;
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName . "</td>";
                                            ?>
                                                <td><?php echo $row->StudentNumber; ?></a></td>
                                                <td><?php echo $row->LRN; ?></a></td>
                                                <td><?php echo $row->YearLevel; ?></td>
                                                <td><?php echo $row->Section; ?></td>
                                                <td style="text-align:center">



                                                    <?php if ($schoolType != 'Public'): ?>
                                                        <a href="<?= base_url(); ?>Page/studentsForm?id=<?= $row->semstudentid; ?>"
                                                            target="_blank"
                                                            class="btn btn-primary btn-xs"
                                                            data-toggle="tooltip"
                                                            title="Registration Form">
                                                            <i class="fa fa-file-text"></i>
                                                        </a>

                                                        <a href="<?= base_url(); ?>Page/studentsForm1?id=<?= $row->semstudentid; ?>"
                                                            target="_blank"
                                                            class="btn btn-info btn-xs"
                                                            data-toggle="tooltip"
                                                            title="Re-Admission Form">
                                                            <i class="fa fa-repeat"></i>
                                                        </a>

                                                        <a href="<?= base_url(); ?>Page/studentsForm2?id=<?= $row->semstudentid; ?>"
                                                            target="_blank"
                                                            class="btn btn-success btn-xs"
                                                            data-toggle="tooltip"
                                                            title="Enrollment / Payment Agreement">
                                                            <i class="fa fa-handshake-o"></i>
                                                        </a>

                                                        <a href="<?= base_url(); ?>Page/studentsForm3?id=<?= $row->semstudentid; ?>"
                                                            target="_blank"
                                                            class="btn btn-warning btn-xs"
                                                            data-toggle="tooltip"
                                                            title="Scholarship Agreement">
                                                            <i class="fa fa-graduation-cap"></i>
                                                        </a>

                                                        <a href="<?= base_url(); ?>Page/studentsForm4?id=<?= $row->semstudentid; ?>"
                                                            target="_blank"
                                                            class="btn btn-dark btn-xs"
                                                            data-toggle="tooltip"
                                                            title="ID Request Form">
                                                            <i class="fa fa-id-card"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="<?= base_url(); ?>Page/updateEnrollment?id=<?= $row->semstudentid; ?>"
                                                        class="btn btn-secondary btn-xs"
                                                        data-toggle="tooltip"
                                                        title="Update Enrollment">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a href="#"
                                                        onclick="setDeleteUrl('<?= base_url('Page/deleteEnrollment?id=' . $row->semstudentid); ?>')"
                                                        data-toggle="modal"
                                                        data-target="#confirmationModal"
                                                        class="btn btn-danger btn-xs"
                                                        data-toggle="tooltip"
                                                        title="Delete Enrollment">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

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

                    <script>
                        $(function() {
                            $('[data-toggle="tooltip"]').tooltip()
                        });
                    </script>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="m-t-0 header-title mb-4">Summary</h4>

                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="text-align: center;">Counts</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Transferees</td>
                                                <td style="text-align: center;"><?= $summary['transferee']; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryList/transferee') ?>" class="btn btn-primary btn-sm">View List</a>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Repeaters</td>
                                                <td style="text-align: center;"><?= $summary['repeater']; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryList/repeater') ?>" class="btn btn-primary btn-sm">View List</a>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Balik-Aral</td>
                                                <td style="text-align: center;"><?= $summary['balik_aral']; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryList/balik_aral') ?>" class="btn btn-primary btn-sm">View List</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>IPs</td>
                                                <td style="text-align: center;"><?= $summary['ip']; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryList/ip') ?>" class="btn btn-primary btn-sm">View List</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4Ps Beneficiaries</td>
                                                <td style="text-align: center;"><?= $summary['4ps']; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryList/4ps') ?>" class="btn btn-primary btn-sm">View List</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Students With Special Needs</td>
                                                <td style="text-align: center;">
                                                    <?= isset($specialNeedsCount->StudeCount) ? $specialNeedsCount->StudeCount : 0 ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Student/viewSpecialNeedsList/' . $selected_sy) ?>" class="btn btn-primary btn-sm" target="_blank">View List</a>

                                                </td>
                                            </tr>

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


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Enrollment Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">


                    <?php $att = array('class' => 'parsley-examples'); ?>
                    <?= form_open('Page/enroll', $att); ?>
                    <!-- general form elements -->
                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Student Name</label>
                                    <select class="form-control" data-toggle="select2" name="StudentNumber">
                                        <option>Select</option>
                                        <?php foreach ($stud as $row) {
                                            $check = $this->Common->two_cond_count_row('semesterstude', 'StudentNumber', $row->StudentNumber, 'SY', $this->session->sy);
                                            if ($check->num_rows() == 0) {
                                        ?>
                                                <option value="<?= $row->StudentNumber; ?>"><?= $row->LastName; ?>, <?= $row->FirstName; ?> <?= $row->MiddleName; ?> </option>
                                        <?php }
                                        }  ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Department </label>
                                    <select name="Course" id="course" class="form-control" required>
                                        <option value="">Select Department</option>
                                        <?php
                                        foreach ($course as $row) {
                                            echo '<option value="' . $row->CourseDescription . '">' . $row->CourseDescription . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Grade Level </label>
                                    <select name="YearLevel" id="yearlevel" class="form-control" required>
                                        <option value="">Select Grade Level</option>
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Section </label>
                                    <select name="Section" id="section" class="form-control" required>
                                        <option value="">Select Section</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <input type="hidden" name="IDNumber" id="AdviserID" class="form-control" readonly>

                                <label>Adviser</label>
                                <input type="text" name="Adviser" id="AdviserName" class="form-control" readonly>
                            </div>
                        </div>


                    </div>



                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Track</label>
                                <select name="Track" id="track" class="form-control">
                                    <option value="">Select Track</option>
                                    <?php foreach ($t as $row) { ?>
                                        <option value="<?= $row->track; ?>"><?= $row->track; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Strand</label>
                                <select name="Qualification" id="strand" class="form-control">
                                    <option value="">Select Strand</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Balik Aral?</label>
                                <select name="BalikAral" id="yearlevel" class="form-control" required>
                                    <!-- <option value="">Select</option> -->
                                    <option value="No Data">No Data</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Indigenous People Member?</label>
                                <select name="IP" id="yearlevel" class="form-control" required>
                                    <!-- <option value="">Select</option> -->
                                    <option value="No Data">No Data</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>4Ps Benefeciary?</label>
                                <select name="FourPs" id="yearlevel" class="form-control" required>
                                    <!-- <option value="">Select</option> -->
                                    <option value="No Data">No Data</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Repeater?</label>
                                <select name="Repeater" class="form-control" required>
                                    <!-- <option value="">Select</option> -->
                                    <option value="No Data">No Data</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Transferee?</label>
                                <select name="Transferee" class="form-control" required>
                                    <!-- <option value="">Select</option> -->
                                    <option value="No Data">No Data</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="StudeStatus" id="StudeStatus" class="form-control" required>
                                    <option value="">Select</option>
                                    <option>Old</option>
                                    <option>New</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" value="<?php echo $this->session->userdata('sy'); ?>" readonly name="SY" required />

                    </div>

                    <!-- <p style="color:green"><b>Note:  Leave the Semester empty for Elementary and Junior High School.  The SY is required and it depends on the options you chose from the login form.</b></p> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" name="submit" class="btn btn-info" value="Process Enrollment"> </span>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#course').change(function() {
                var course = $('#course').val();
                if (course != '') {
                    $.ajax({
                        url: "<?php echo base_url(); ?>page/fetch_yearlevel",
                        method: "POST",
                        data: {
                            course: course
                        },
                        success: function(data) {
                            $('#yearlevel').html(data);
                        }
                    });
                }
            });

            $('#yearlevel').change(function() {
                var yearlevel = $('#yearlevel').val();
                if (yearlevel != '') {
                    $.ajax({
                        url: "<?php echo base_url(); ?>page/fetch_section",
                        method: "POST",
                        data: {
                            yearlevel: yearlevel
                        },
                        success: function(data) {
                            $('#section').html(data);
                        }
                    });
                }
            });

            $(document).ready(function() {
                $('#section').change(function() {
                    var section = $('#section').val();
                    var yearlevel = $('#yearlevel').val(); // Get the selected year level

                    if (section !== '' && yearlevel !== '') { // Ensure both values are present
                        // Fetch Adviser ID
                        $.ajax({
                            url: "<?php echo base_url(); ?>page/fetch_adviser_id",
                            method: "POST",
                            data: {
                                section: section,
                                yearlevel: yearlevel
                            }, // Send both params
                            success: function(data) {
                                console.log("Adviser ID Response:", data); // Debug log
                                $('#AdviserID').val(data.trim()); // Populate Adviser ID
                            }
                        });

                        // Fetch Adviser Name
                        $.ajax({
                            url: "<?php echo base_url(); ?>page/fetch_adviser_name",
                            method: "POST",
                            data: {
                                section: section,
                                yearlevel: yearlevel
                            }, // Send both params
                            success: function(data) {
                                console.log("Adviser Name Response:", data); // Debug log
                                $('#AdviserName').val(data.trim()); // Populate Adviser Name
                            }
                        });
                    } else {
                        $('#AdviserID').val(''); // Clear Adviser ID field
                        $('#AdviserName').val(''); // Clear Adviser Name field
                    }
                });
            });

            $('#track').change(function() {
                var track = $(this).val(); // Get the selected track value
                if (track != '') {
                    // Clear the Strand dropdown
                    $('#strand').html('<option value="">Select Strand</option>'); // Reset to default option

                    $.ajax({
                        url: "<?php echo base_url(); ?>Settings/fetchStrand", // Make sure this URL is correct
                        method: "POST",
                        data: {
                            track: track
                        },
                        success: function(data) {
                            $('#strand').html(data); // Populate strands based on the response
                        },
                        error: function() {
                            // Handle any errors that occur during the AJAX request
                            $('#strand').html('<option value="">Error loading strands</option>');
                        }
                    });
                } else {
                    // Reset Strand dropdown if no Track is selected
                    $('#strand').html('<option value="">Select Strand</option>');
                }
            });
        });
    </script>


</body>

</html>