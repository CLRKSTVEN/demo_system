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
                                <h4 class="page-title">COUNSELLING</h4>
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
                                                    <th>Counselling No.</th>
                                                    <th>Date</th>
                                                    <th>Counselling Details</th>
                                                    <th>Action Taken</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($data as $row) {
                                                    echo "<tr>";

                                                    // echo "<td>" . $row->recordNo . "</td>";
                                                    echo "<td>" . sprintf('%06d',$row->recordNo)  . "</td>";
                                                    echo "<td>" . $row->recordDate . "</td>";
                                                    echo "<td>" . $row->details . "</td>";
                                                    echo "<td>" . $row->actionPlan . "</td>";
                                                ?>

                                                <?php
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    <?php } else { ?>


                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <div class="mb-3">
                                            <a href="<?= base_url('Page/counselling?filter=student'); ?>" class="btn btn-outline-primary <?= (!$isStaff) ? 'active' : ''; ?>">Student Counselling</a>
                                            <a href="<?= base_url('Page/counselling?filter=staff'); ?>" class="btn btn-outline-secondary <?= ($isStaff) ? 'active' : ''; ?>">Staff Counselling</a>
                                        </div>

                                     <thead>
                                            <tr>
                                                <th>Counselling No.</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Counselling Details</th>
                                                <th>Action Taken</th>
                                                <th>Return Schedule</th>
                                                <th style="text-align:center">Action</th> <!-- ADD THIS LINE -->
                                            </tr>
                                        </thead>

                                            <tbody>
                                            <?php foreach ($data as $row): ?>
                                                <tr>
                                                    <td><?= sprintf('%06d', $row->recordNo); ?></td>
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
                                                    <td><?= $row->recordDate; ?></td>
                                                    <!-- <td>
                                                        <span class="badge badge-<?= $row->AcctGroup === 'Staff' ? 'info' : 'success'; ?>">
                                                            <?= $row->AcctGroup; ?>
                                                        </span>
                                                    </td>
                                                   -->
                                                    <td><?= $row->details; ?></td>
                                                    <td><?= $row->actionPlan; ?></td>
                                                    <td><?= $row->returnSchedule; ?></td>
                                                    <td style="text-align:center">
                                                       <a href="<?= base_url(); ?>Page/updateCounselling?id=<?php echo $row->id; ?>" class="text-info"><i class="mdi mdi-email-edit "></i>Update</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a href="<?= base_url(); ?>Page/deleteCounselling?id=<?php echo $row->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="text-danger"><i class="mdi mdi-delete-circle-outline"></i>Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;

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
                <h5 class="modal-title">Counselling</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="post">

                    <!-- Select Account Group -->
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
                            <?php foreach ($data2 as $st): ?>
                                <option value="<?= $st->IDNumber; ?>">
                                    <?= $st->IDNumber . ' - ' . $st->LastName . ', ' . $st->FirstName; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Counselling No.</label>
                            <input type="text" class="form-control" name="recordNo" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Counselling Date</label>
                            <input type="date" class="form-control" name="recordDate" required>
                        </div>
                         <div class="form-group col-md-4">
                        <label>Return Schedule</label>
                        <input type="date" class="form-control" name="returnSchedule" >
                    </div>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Details</label>
                        <input type="text" class="form-control" name="details" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Action Taken</label>
                        <input type="text" class="form-control" name="actionPlan" required>
                    </div>

                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
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
    var isStudent = <?= json_encode($this->session->userdata('level') === 'Student'); ?>;
    var dateColIndex = isStudent ? 1 : 2;

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