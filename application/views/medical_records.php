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
                                <h4 class="page-title">STUDENTS' MEDICAL RECORDS</h4>
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
                                            <!-- <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> -->
                                            <thead>
                                                <tr>
                                                    <th>Case No.</th>
                                                    <th>Date</th>
                                                    <th>Complaint</th>
                                                    <th>Pain Tolerance</th>
                                                    <th>Temperature</th>
                                                    <th>Blood Pressure</th>
                                                    <th>Medication</th>
                                                    <th>Other Details</th>
                                                  

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $row) {
                                                    echo "<tr>";
                                                   
                                                    echo "<td>" . $row->caseNo . "</td>";
                                                    echo "<td>" . $row->incidentDate . "</td>";
                                                    echo "<td>" . $row->complaint . "</td>";
                                                    echo "<td>" . $row->painTolerance . "</td>";
                                                    echo "<td>" . $row->temperature . "</td>";
                                                    echo "<td>" . $row->bp . "</td>";
                                                    echo "<td>" . $row->medication . "</td>";
                                                    echo "<td>" . $row->otherDetails . "</td>";
                                                   
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    <?php } else { ?>

                                    
<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <div class="mb-3">
    <a href="<?= base_url('Page/medRecords?filter=student'); ?>" class="btn btn-outline-primary <?= (!$isStaff) ? 'active' : ''; ?>">Student Records</a>
    <a href="<?= base_url('Page/medRecords?filter=staff'); ?>" class="btn btn-outline-secondary <?= ($isStaff) ? 'active' : ''; ?>">Staff Records</a>
</div>

    <thead>
        <tr>
            <th>Name</th>
            <th>ID / Student No.</th>
            <th>Case No.</th>
            <th>Date</th>
            <th>Complaint</th>
            <th>Pain Tolerance</th>
            <th>Temperature</th>
            <th>Blood Pressure</th>
            <th>Medication</th>
            <th>Other Details</th>
            <th>Notes</th>
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
        echo $stud ? $stud->LastName . ', ' . $stud->FirstName . ' ' . $stud->MiddleName : 'N/A';
    } else {
        // For staff, StudentNumber holds the IDNumber
        $staff = $this->db->get_where('staff', ['IDNumber' => $row->StudentNumber])->row();
        echo $staff ? $staff->LastName . ', ' . $staff->FirstName : 'N/A';
    }
    ?>
</td>
<td><?= $row->StudentNumber; ?></td>
                <td><?= sprintf('%06d', $row->caseNo); ?></td>
<td data-order="<?= htmlspecialchars($row->incidentDate) ?>">
  <?= htmlspecialchars($row->incidentDate) ?>
</td>
                <td><?= $row->complaint; ?></td>
                <td><?= $row->painTolerance; ?></td>
                <td><?= $row->temperature; ?></td>
                <td><?= $row->bp; ?></td>
                <td><?= $row->medication; ?></td>
                <td><?= $row->otherDetails; ?></td>
                <td><?= $row->otherNotes; ?></td>
                <td style="text-align:center">
                    <a href="<?= base_url('Page/updateMedRecords?id=' . $row->mrID); ?>" class="text-info"><i class="mdi mdi-email-edit"></i> Update</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?= base_url('Page/deleteMedRec?id=' . $row->mrID); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="text-danger"><i class="mdi mdi-delete-circle-outline"></i> Delete</a>
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
                    <h5 class="modal-title" id="myLargeModalLabel">Medical Records</h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
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
                                <label for="inputCity" class="col-form-label">Case No.</label>
                                <input type="text" class="form-control" name="caseNo">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4" class="col-form-label">Date</label>
                                <input type="date" class="form-control" name="incidentDate">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4" class="col-form-label">Temperature</label>
                                <input type="text" class="form-control" name="temperature">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4" class="col-form-label">BP</label>
                                <input type="text" class="form-control" name="bp">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-9">
                                <label for="inputAddress" class="col-form-label">Major Complaint</label>
                                <input type="text" class="form-control" name="complaint">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputAddress" class="col-form-label">Pain Tolerance (1 to 10)</label>
                                <input type="number" min=0 max=10 class="form-control" name="painTolerance">
                            </div>
                        </div>




                        <div class="form-group">
                            <label for="inputAddress" class="col-form-label">Medication</label>
                            <input type="text" class="form-control" name="medication">
                        </div>

                        <div class="form-group">
                            <label for="inputAddress" class="col-form-label">Other Details</label>
                            <input type="text" class="form-control" name="otherDetails">
                        </div>

                        <div class="form-group">
                            <label for="inputAddress" class="col-form-label">Notes</label>
                            <input type="text" class="form-control" name="otherNotes">
                        </div>

                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    </form>
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
<script>
  $(function () {
    // If the table might already be auto-initialized by a shared script,
    // grab the instance and set order; otherwise initialize with options.
    var $tbl = $('#datatable-buttons');

    if ($.fn.dataTable.isDataTable($tbl)) {
      $tbl.DataTable().order([3,'desc']).draw();
    } else {
      $tbl.DataTable({
        order: [[3,'desc']],
        orderMulti: false
      });
    }
  });
</script>


</body>

</html>