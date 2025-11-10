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
                                <h4 class="page-title">INCIDENTS</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <?php if ($this->session->userdata('level') === 'Student') {
                                        } else { ?>

                                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".addnew">+ Add New</button>
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
                                                <th>Case No.</th>
                                                <th>Date</th>
                                                <th>Place</th>
                                                <!-- <th>Quarter</th> -->
                                                <th>Offense Level</th>
                                                <th>Offense</th>
                                                <th>Sanction</th>
                                                <th>Action Taken</th>
                                                <th>Sem./SY</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                               
                                                // echo "<td>" . $row->caseNo . "</td>";
                                                echo "<td>" . sprintf('%06d',$row->caseNo)  . "</td>";
                                                echo "<td>" . $row->incidentDate . "</td>";
                                                echo "<td>" . $row->incPlace . "</td>";
                                                //   echo "<td>".$row->quarter."</td>";
                                                echo "<td>" . $row->offenseLevel . "</td>";
                                                echo "<td>" . $row->offense . "</td>";
                                                echo "<td>" . $row->sanction . "</td>";
                                                echo "<td>" . $row->actionTaken . "</td>";
                                                echo "<td>" . $row->sem . ' ' . $row->sy . "</td>";
                                           
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                    <?php } else { ?>
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                             
                                        <div class="mb-3">
                                            <a href="<?= base_url('Page/incidents?filter=student'); ?>" class="btn btn-outline-primary <?= (!$isStaff) ? 'active' : ''; ?>">Student Incidents</a>
                                            <a href="<?= base_url('Page/incidents?filter=staff'); ?>" class="btn btn-outline-secondary <?= ($isStaff) ? 'active' : ''; ?>">Staff Incidents</a>
                                        </div>

                                                                                
                                                                            <thead>
                                            <tr>
                                                <th>Person Involved</th>
                                                <th><?= $isStaff ? 'Employee No.' : 'Student No.'; ?></th>
                                                <th>Case No.</th>
                                                <th>Date</th>
                                                <th>Place</th>
                                                <th>Offense Level</th>
                                                <th>Offense</th>
                                                <th>Sanction</th>
                                                <th>Action Taken</th>
                                                <th>Sem./SY</th>
                                                <th style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($data as $row): ?>
                                            <tr>
                                                <td><?= $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName; ?></td>
                                                <td><?= $isStaff ? $row->IDNumber : $row->StudentNumber; ?></td>
                                                <td><?= sprintf('%06d', $row->caseNo); ?></td>
                                                <td><?= $row->incidentDate; ?></td>
                                                <td><?= $row->incPlace; ?></td>
                                                <td><?= $row->offenseLevel; ?></td>
                                                <td><?= $row->offense; ?></td>
                                                <td><?= $row->sanction; ?></td>
                                                <td><?= $row->actionTaken; ?></td>
                                                <td><?= $row->sem . ' ' . $row->sy; ?></td>
                                                <td style="text-align:center">
                                                    <a href="<?= base_url(); ?>Page/updateIncidents?id=<?= $row->incID; ?>" class="text-info"><i class="mdi mdi-email-edit"></i> Update</a>&nbsp;&nbsp;
                                                    <a href="<?= base_url(); ?>Page/deleteIncident?id=<?= $row->incID; ?>" onclick="return confirm('Are you sure?');" class="text-danger"><i class="mdi mdi-delete-circle-outline"></i> Delete</a>
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
    <div class="modal fade bs-example-modal-lg addnew" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Incidents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="post">
                    <div class="form-group">
    <label class="col-form-label">Report Against</label>
    <select class="form-control" id="reportTypeSelector" name="AcctGroup">
        <option value="">Select Type</option>
        <option value="Student">Student</option>
        <option value="Staff">Staff</option>
    </select>
</div>

<div class="form-group" id="studentSelectGroup" style="display:none;">
    <label class="col-form-label">Student Name</label>
    <select class="form-control" name="StudentNumber" id="studentSelect" data-toggle="select2">
        <option value="">Select Student</option>
        <?php foreach ($students as $row): ?>
            <option value="<?= $row->StudentNumber; ?>">
                <?= $row->StudentNumber . ' - ' . $row->LastName . ', ' . $row->FirstName; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group" id="staffSelectGroup" style="display:none;">
    <label class="col-form-label">Staff Name</label>
    <select class="form-control" name="IDNumber" id="staffSelect" data-toggle="select2">
        <option value="">Select Staff</option>
        <?php foreach ($staff as $row): ?>
            <option value="<?= $row->IDNumber; ?>">
                <?= $row->IDNumber . ' - ' . $row->LastName . ', ' . $row->FirstName; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputCity" class="col-form-label">Case No.</label>
                                <input type="text" class="form-control" name="caseNo">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="col-form-label">Date</label>
                                <input type="date" class="form-control" name="incidentDate">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="col-form-label">Place</label>
                                <input type="text" class="form-control" name="incPlace">
                            </div>

                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputPassword4" class="col-form-label">Offense Level</label>
                                <select class="form-control" name="offenseLevel">
                                    <option></option>
                                    <option>Minor Offense</option>
                                    <option>Major Offense</option>
                                </select>
                            </div>
                            <div class="form-group col-md-9">
                                <label for="inputAddress" class="col-form-label">Offense</label>
                                <input type="text" class="form-control" name="offense">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="col-form-label">Sanction</label>
                            <input type="text" class="form-control" name="sanction">
                        </div>


                        <div class="form-group">
                            <label for="inputAddress" class="col-form-label">Action Taken</label>
                            <input type="text" class="form-control" name="actionTaken">
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
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    const selector = document.getElementById('reportTypeSelector');
    const studentGroup = document.getElementById('studentSelectGroup');
    const staffGroup = document.getElementById('staffSelectGroup');
    const studentSelect = document.getElementById('studentSelect');
    const staffSelect = document.getElementById('staffSelect');

    selector.addEventListener('change', function () {
        const selected = this.value;
        if (selected === 'Student') {
            studentGroup.style.display = 'block';
            staffGroup.style.display = 'none';
            staffSelect.value = '';
        } else if (selected === 'Staff') {
            staffGroup.style.display = 'block';
            studentGroup.style.display = 'none';
            studentSelect.value = '';
        } else {
            studentGroup.style.display = 'none';
            staffGroup.style.display = 'none';
            studentSelect.value = '';
            staffSelect.value = '';
        }
    });
});
</script>
<script>
  $(function () {
    var isStudent = <?= json_encode($this->session->userdata('level') === 'Student'); ?>;
    var dateColIndex = isStudent ? 1 : 3;

    var $tbl = $('#datatable-buttons');
    if ($.fn.dataTable.isDataTable($tbl)) {
      $tbl.DataTable().order([dateColIndex, 'desc']).draw();
    } else {
      $tbl.DataTable({
        order: [[dateColIndex, 'desc']],
        orderMulti: false
      });
    }
  });
</script>

</body>

</html>