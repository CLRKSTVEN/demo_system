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
                                <h4 class="page-title">STUDENTS' MEDICAL INFORMATION</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <?php if ($this->session->userdata('level') === 'Student') {
                                        } else { ?>

                                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">+ Add New</button>
                                        <?php }  ?>
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


                                    <?php if ($this->session->userdata('level') === 'Student') { ?>

                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                               
                                                <th>Height</th>
                                                <th>Weight</th>
                                                <th>Blood Type</th>
                                                <th>Vision</th>
                                                <th>Allergies Drug</th>
                                                <th>Allergies Food</th>
                                                <th>Eye Color</th>
                                                <th>Hair Color</th>
                                                <th>Special Physical Needs</th>
                                                <th>Special Dietary Needs</th>
                                                <th>Respiratory Problems</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                               
                                                echo "<td>" . $row->height . "</td>";
                                                echo "<td>" . $row->weight . "</td>";
                                                echo "<td>" . $row->bloodType . "</td>";
                                                echo "<td>" . $row->vision . "</td>";
                                                echo "<td>" . $row->allergiesDrugs . "</td>";
                                                echo "<td>" . $row->allergiesFood . "</td>";
                                                echo "<td>" . $row->eyeColor . "</td>";
                                                echo "<td>" . $row->hairColor . "</td>";
                                                echo "<td>" . $row->specialPhyNeeds . "</td>";
                                                echo "<td>" . $row->specialDieNeeds . "</td>";
                                                echo "<td>" . $row->respiratoryProblems . "</td>";
                                         
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                      <?php } else { ?> 
                                            
<!-- Medical Info Table -->
<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
    <div class="mb-3">
    <a href="<?= base_url('Page/medInfo?filter=student'); ?>" class="btn btn-outline-primary <?= (!$isStaff) ? 'active' : ''; ?>">Student Records</a>
    <a href="<?= base_url('Page/medInfo?filter=staff'); ?>" class="btn btn-outline-secondary <?= ($isStaff) ? 'active' : ''; ?>">Staff Records</a>
</div>

    <thead>
        <tr>
            <th>Name</th>
            <th>Account No.</th>
            <th>Height</th>
            <th>Weight</th>
            <th>Blood Type</th>
            <th>Vision</th>
            <th>Allergies (Drug)</th>
            <th>Allergies (Food)</th>
            <th>Eye Color</th>
            <th>Hair Color</th>
            <th>Special Physical Needs</th>
            <th>Special Dietary Needs</th>
            <th>Respiratory Problems</th>
            <th style="text-align:center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td>
                    <?php
                    if ($row->AcctGroup === 'Student') {
                        $stud = $this->db->get_where('studeprofile', ['StudentNumber' => $row->StudentNumber])->row();
                        echo $stud ? $stud->LastName . ', ' . $stud->FirstName : 'N/A';
                    } else {
                        $staff = $this->db->get_where('staff', ['IDNumber' => $row->IDNumber])->row();
                        echo $staff ? $staff->LastName . ', ' . $staff->FirstName : 'N/A';
                    }
                    ?>
                </td>
                <td><?= $row->AcctGroup === 'Student' ? $row->StudentNumber : $row->IDNumber; ?></td>
                <td><?= $row->height; ?></td>
                <td><?= $row->weight; ?></td>
                <td><?= $row->bloodType; ?></td>
                <td><?= $row->vision; ?></td>
                <td><?= $row->allergiesDrugs; ?></td>
                <td><?= $row->allergiesFood; ?></td>
                <td><?= $row->eyeColor; ?></td>
                <td><?= $row->hairColor; ?></td>
                <td><?= $row->specialPhyNeeds; ?></td>
                <td><?= $row->specialDieNeeds; ?></td>
                <td><?= $row->respiratoryProblems; ?></td>
                <td style="text-align:center">
                    <a href="<?= base_url('Page/updateMedInfo?id=' . $row->medID); ?>" class="text-info">
                        <i class="mdi mdi-email-edit"></i> Update
                    </a>&nbsp;&nbsp;
                    <a href="<?= base_url('Page/deleteMedInfo?id=' . $row->medID); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="text-danger">
                        <i class="mdi mdi-delete-circle-outline"></i> Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

                                        <?php }  ?>
                                        
                                    
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


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Medical Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- Form row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                        <form method="post">
                          <div class="form-group">
                        <label class="col-form-label">Account Type</label>
                        <select class="form-control" name="AcctGroup" id="acctGroupSelect" required>
                            <option value="">-- Select --</option>
                            <option value="Student">Student</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>

                    <!-- Student Dropdown -->
                    <div class="form-group" id="studentSelect" style="display:none;">
                        <label class="col-form-label">Student Name</label>
                        <select class="form-control" name="StudentNumber" data-toggle="select2">
                            <option value="">-- Select Student --</option>
                            <?php foreach ($students as $row): ?>
                                <option value="<?= $row->StudentNumber; ?>">
                                    <?= $row->StudentNumber . ' - ' . $row->LastName . ', ' . $row->FirstName; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Staff Dropdown -->
                    <div class="form-group" id="staffSelect" style="display:none;">
                        <label class="col-form-label">Staff Name</label>
<select class="form-control" name="IDNumber" data-toggle="select2">
                                <option value="">-- Select Staff --</option>
                      <?php foreach ($data1 as $st): ?>
                        <option value="<?= $st->IDNumber; ?>">
                            <?= $st->IDNumber . ' - ' . $st->LastName . ', ' . $st->FirstName; ?>
                        </option>
                    <?php endforeach; ?>

                        </select>
                    </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="inputCity" class="col-form-label">Height</label>
                                                <input type="text" class="form-control" name="height">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputPassword4" class="col-form-label">Weight</label>
                                                <input type="text" class="form-control" name="weight">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputPassword4" class="col-form-label">Blood Type</label>
                                                <input type="text" class="form-control" name="bloodType">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputZip" class="col-form-label">Vision</label>
                                                <input type="text" class="form-control" name="vision">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity" class="col-form-label">Food Allergies</label>
                                                <input type="text" class="form-control" name="allergiesFood">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4" class="col-form-label">Drugs Allergies</label>
                                                <input type="text" class="form-control" name="allergiesDrugs">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity" class="col-form-label">Special Physical Needs</label>
                                                <input type="text" class="form-control" name="specialPhyNeeds">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4" class="col-form-label">Special Dietary Needs</label>
                                                <input type="text" class="form-control" name="specialDieNeeds">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity" class="col-form-label">Eye Color</label>
                                                <input type="text" class="form-control" name="eyeColor">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4" class="col-form-label">Hair Color</label>
                                                <input type="text" class="form-control" name="hairColor">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAddress" class="col-form-label">Respiratory Problems</label>
                                            <input type="text" class="form-control" name="respiratoryProblems">
                                        </div>

                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <?php include('includes/footer_plugins.php'); ?>

        <script>
    document.getElementById('acctGroupSelect').addEventListener('change', function () {
        const group = this.value;
        document.getElementById('studentSelect').style.display = (group === 'Student') ? 'block' : 'none';
        document.getElementById('staffSelect').style.display = (group === 'Staff') ? 'block' : 'none';
    });
</script>
</body>

</html>