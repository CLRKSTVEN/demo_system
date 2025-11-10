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
                                        <?php if ($this->session->userdata('level') === 'Student') : ?>
                                            <div class="profile-user-img">
                                                <img src="<?= base_url(); ?>upload/profile/<?php echo $this->session->userdata('avatar') ? $this->session->userdata('avatar') : 'default-avatar.jpg'; ?>" alt="" class="avatar-lg rounded-circle">
                                            </div>
                                        <?php else : ?>
                                            <div class="profile-user-img">
                                                <img src="<?= base_url(); ?>upload/profile/<?php echo isset($result['avatar']) ? $result['avatar'] : 'default-avatar.jpg'; ?>" alt="" class="avatar-lg rounded-circle">
                                            </div>
                                        <?php endif; ?>
                                        <div class="">
                                            <h4 class="mt-5 font-18 ellipsis"><?php echo $data[0]->FirstName . ' ' . $data[0]->MiddleName . ' ' . $data[0]->LastName; ?></h4>
                                            <p class="font-13" style="text-transform: uppercase;">
                                                <?php echo $data[0]->Sitio . ' ' . $data[0]->Brgy . ', ' . $data[0]->City . ', ' . $data[0]->Province; ?>
                                            </p>
                                        </div>


                                    </div>

                                    <div class="col-sm-6">
                                        <div class="text-right">

                                            <?php if ($this->session->userdata('level') !== 'Student') : ?>
                                                <?php if ($this->session->userdata('level') === 'Admin') : ?>
                                                    <a href="<?= base_url(); ?>Page/updateStudeProfile?StudentNumber=<?= $data[0]->StudentNumber; ?>" class="btn btn-success text-white waves-effect waves-light">
                                                        <b><i class="far fa-edit mr-1"></i><span> Edit Profile</span></b>
                                                    </a>
                                                <?php elseif ($this->session->userdata('level') === 'Registrar' || $this->session->userdata('level') === 'Teacher') : ?>

                                                    <a href="<?= base_url(); ?>Page/updateStudeProfile?StudentNumber=<?= $data[0]->StudentNumber; ?>" class="btn btn-success text-white waves-effect waves-light">
                                                        <b><i class="mdi mdi-account-settings-variant mr-1"></i> Edit Profile</b>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>



                                            <?php if ($this->session->userdata('level') === 'Student') : ?>

                                            <?php else : ?>

                                                <!-- <a href=<?= base_url(); ?>stude_grades.php?view=<?php echo $data[0]->StudentNumber; ?> target="_blank">
                                                    <button type="button" class="btn btn-success waves-effect waves-light">Complete Grades</button>
                                                </a> -->

                                                <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#editStudentNumberModal">
                                                    Edit Student Number
                                                </button>

                                                <!-- <a href="<?= base_url(); ?>page/enrollmentAcceptance?id=<?php echo $data[0]->StudentNumber; ?>&FName=<?php echo $data[0]->FirstName; ?>&MName=<?php echo $data[0]->MiddleName; ?>&LName=<?php echo $data[0]->LastName; ?>&Course=&YearLevel=&sem=&sy=">
                                                    <button type="button" class="btn btn-success waves-effect waves-light">Enroll</button>
                                                </a> -->
                                            <?php endif; ?>
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
                                        <li class="nav-item"><a class="nav-link <?php if ($this->input->post('grade') == "") {
                                                                                    echo ' active ';
                                                                                } ?>" data-toggle="tab" href="#aboutme">About</a></li>

                                        <?php if ($this->session->userdata('level') !== 'Student') : ?>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#requirements">Submitted Requirements</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->session->userdata('level') !== 'Student') : ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if ($this->input->post('grade') != "") {
                                                                        echo ' active ';
                                                                    } ?>" data-toggle="tab" href="#grades">Grades</a>
                                            </li>
                                        <?php endif; ?>

                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#accounthistory">Account History</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#enrollmenthistory">Enrollment History</a></li>
                                        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#requesthistory">Request</a></li> -->
                                    </ul>

                                    <div class="tab-content m-0 p-4">

                                        <div id="aboutme" class="tab-pane <?php if ($this->input->post('grade') == "") {
                                                                                echo ' active ';
                                                                            } ?>">
                                            <div class="profile-desk">
                                                <h4 class="mt-1 font-18 ellipsis">Student's Information</h4>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <!--<h5 class="mt-4">Official Information</h5>-->
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Student No.</th>
                                                                    <td>
                                                                        <?php echo $data[0]->StudentNumber; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Birth Date</th>
                                                                    <td>
                                                                        <?php echo $data[0]->BirthDate; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Age</th>
                                                                    <td>
                                                                        <?php echo $data[0]->Age; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Sex</th>
                                                                    <td>
                                                                        <?php echo $data[0]->Sex; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Civil Status</th>
                                                                    <td>
                                                                        <?php echo $data[0]->CivilStatus; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Mobile No.</th>
                                                                    <td>
                                                                        <?php echo $data[0]->MobileNumber; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Email</th>
                                                                    <td>
                                                                        <?php echo $data[0]->EmailAddress; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <!--<h5 class="mt-4">Contact Person</h5>-->
                                                        <table class="table table-condensed mb-0">

                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Father</th>
                                                                    <td>
                                                                        <?php echo $data[0]->Father; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Occupation</th>
                                                                    <td>
                                                                        <?php echo $data[0]->FOccupation; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Mother</th>
                                                                    <td>
                                                                        <?php echo $data[0]->Mother; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Occupation</th>
                                                                    <td>
                                                                        <?php echo $data[0]->MOccupation; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Guardian</th>
                                                                    <td>
                                                                        <?php echo $data[0]->Guardian; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Contact No.</th>
                                                                    <td>
                                                                        <?php echo $data[0]->GuardianContact; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Address</th>
                                                                    <td>
                                                                        <?php echo $data[0]->GuardianAddress; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div> <!-- end profile-desk -->
                                        </div> <!-- about-me -->

                                        <div id="requirements" class="tab-pane">
                                            <h4 class="mt-1 font-18 ellipsis">Submitted Requirements</h4>

                                            <table class="table mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Requirement</th>
                                                        <th>Status</th>
                                                        <th>Submitted On</th>
                                                        <th>Remarks</th>
                                                        <th>File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data2 as $index => $req): ?>
                                                        <tr>
                                                            <td><?= $req->name ?></td>
                                                            <td>
                                                                <?php
                                                                if ($req->date_submitted) {
                                                                    echo $req->is_verified
                                                                        ? '<span style="color: green;">Verified</span>'
                                                                        : '<span style="color: orange;">Pending</span>';
                                                                } else {
                                                                    echo '<a href="#" class="text-danger" data-toggle="modal" data-target="#manualVerifyModal' . $index . '">Not Submitted</a>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?= $req->date_submitted ?? '—' ?></td>
                                                            <td><?= $req->comment ?></td>
                                                            <td>
                                                                <?php if ($req->file_path): ?>
                                                                    <a href="<?= base_url($req->file_path) ?>" class="btn btn-primary btn-sm" target="_blank">
                                                                        <i class="fa fa-eye"></i> View
                                                                    </a>
                                                                <?php else: ?>
                                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#uploadModal<?= $index ?>">
                                                                        <i class="fa fa-upload"></i> Upload
                                                                    </button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>

                                                        <!-- Upload Modal -->
                                                        <?php if (!$req->file_path): ?>
                                                            <div class="modal fade" id="uploadModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel<?= $index ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                                    <form action="<?= base_url('Student/upload_requirement') ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="requirement_id" value="<?= $req->req_id ?>">
                                                                        <input type="hidden" name="StudentNumber" value="<?= $this->input->get('id'); ?>">

                                                                        <div class="modal-content">
                                                                            <div class="modal-header p-2">
                                                                                <h6 class="modal-title" id="uploadModalLabel<?= $index ?>">Upload Requirement</h6>
                                                                                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close" style="font-size: 1rem;">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body p-2">
                                                                                <p class="mb-1"><strong><?= $req->name ?></strong></p>
                                                                                <div class="form-group mb-2">
                                                                                    <input type="file" name="requirement_file" class="form-control form-control-sm" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer p-2">
                                                                                <button type="submit" class="btn btn-success btn-sm">✔ Upload</button>
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">✖ Cancel</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <!-- Manual Verify Modal -->
                                                        <?php if (!$req->date_submitted): ?>
                                                            <div class="modal fade" id="manualVerifyModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="manualVerifyLabel<?= $index ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                                    <form action="<?= base_url('Student/manual_verify') ?>" method="post">
                                                                        <input type="hidden" name="requirement_id" value="<?= $req->req_id ?>">
                                                                        <input type="hidden" name="StudentNumber" value="<?= $this->input->get('id'); ?>">

                                                                        <div class="modal-content">
                                                                            <div class="modal-header p-2">
                                                                                <h6 class="modal-title" id="manualVerifyLabel<?= $index ?>">Verify Requirement</h6>
                                                                                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close" style="font-size: 1rem;">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body p-2">
                                                                                <p class="mb-1"><strong><?= $req->name ?></strong></p>
                                                                                <div class="form-group mb-2">
                                                                                    <input type="text" class="form-control form-control-sm" name="comment" placeholder="Remarks (e.g., Submitted hard copy)" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer p-2">
                                                                                <button type="submit" class="btn btn-success btn-sm">✔ Verify</button>
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">✖ Cancel</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Grades -->
                                        <div id="grades" class="tab-pane <?php if ($this->input->post('grade') != "") {
                                                                                echo ' active ';
                                                                            } ?>">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="page-title-box">
                                                        <?php $grade = $this->Common->one_cond_gb('semesterstude', 'StudentNumber', $this->input->get('id'), 'SY', 'SY', 'ASC'); ?>

                                                        <h4 class="page-title mt-1 font-18 ellipsis">Grades
                                                            <span class="badge badge-secondary mb-0">
                                                                <?php if ($this->input->post('grade') == "") { ?>
                                                                    <?php
                                                                    echo $this->session->userdata('sy');
                                                                    $sy = $this->session->userdata('sy');
                                                                    ?>
                                                                <?php } else { ?>
                                                                    <?php
                                                                    echo $this->input->post('grade');
                                                                    $sy = $this->input->post('grade');
                                                                    ?>
                                                                <?php } ?>
                                                            </span>

                                                         <?php
// Normalize selected SY from POST or fallback to session
$sy = $this->input->post('grade');
$sy = ($sy !== null && $sy !== '') ? $sy : (string) $this->session->userdata('sy');

// Fetch the current sem record for that SY (used for course-based actions)
$cs = $this->Common->two_cond_row('semesterstude', 'StudentNumber', $this->input->get('id'), 'SY', $sy);
?>



                                                            <?php if (!empty($cs)) { ?>
                                                               <div class="btn-group">
  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Actions
  </button>
  <div class="dropdown-menu">
    <?php if ($cs && $cs->Course == 'Elementary') { ?>
      <a class="dropdown-item" href="<?= base_url('Ren/report_card/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">
        <i class="fa fa-file-alt text-success"></i> Report Card
      </a>
      <a class="dropdown-item" href="<?= base_url('Ren/rc_sf9_es/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">SF9 - ES</a>
      <a class="dropdown-item" href="<?= base_url('Ren/rc_sf10/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">SF10</a>

    <?php } elseif ($cs && $cs->Course == 'Junior High School') { ?>
      <a class="dropdown-item" href="<?= base_url('Ren/report_card/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">
        <i class="fa fa-file-alt text-success"></i> Report Card
      </a>
      <a class="dropdown-item" href="<?= base_url('Ren/rc_sf9_js/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">SF9 - JHS</a>
      <a class="dropdown-item" href="<?= base_url('Ren/rc_sf10_jhs/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">SF10</a>
   <a class="dropdown-item" href="<?= base_url('Shs_report/rlpd/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">
    <i class="fa fa-file-alt text-warning"></i> Report Card (SHS)
  </a>
    <?php } elseif ($cs && $cs->Course == 'Senior High School') { ?>
      <a class="dropdown-item" href="<?= base_url('Ren/report_card/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">
        <i class="fa fa-file-alt text-success"></i> Report Card
      </a>
      <a class="dropdown-item" href="<?= base_url('Shs_report/rlpd/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">
    <i class="fa fa-file-alt text-warning"></i> Report Card (SHS)
  </a>
      <a class="dropdown-item" href="<?= base_url('Ren/rc_sf9_shs/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">SF9 - SHS</a>
      <a class="dropdown-item" href="<?= base_url('Ren/rc_sf10_shs/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">SF10</a>

    <?php } elseif ($cs && $cs->Course == 'Preschool') { ?>
      <a class="dropdown-item" href="<?= base_url('Ren/report_card/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">
        <i class="fa fa-file-alt text-success"></i> Report Card
      </a>
      <a class="dropdown-item" href="<?= base_url('Ren/rc_sf9_es/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">SF9 - ES</a>
      <a class="dropdown-item" href="<?= base_url('Ren/rc_sf10/' . $data[0]->StudentNumber) . '?sy=' . urlencode($sy); ?>" target="_blank">SF10</a>
    <?php } ?>

    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-info" href="<?= base_url('Page/sendGradesToEmail?id=' . $data[0]->StudentNumber . '&sy=' . urlencode($sy)); ?>">
      <i class="fa fa-envelope"></i> Email Grades
    </a>
  </div>
</div>

                                                            <?php } ?>


                                                        </h4>

                                                        <div class="page-title-right">
                                                            <?= form_open('Page/studentsprofile?id=' . $this->input->get('id')); ?>
                                                            <div class="row float-right col-6">

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <select name="grade" class="form-control">
                                                                            <option value="" selected disabled>Select School Year</option>
                                                                            <?php foreach ($grade as $row) { ?>
                                                                                <option value="<?= $row->SY; ?>"><?= $row->SY; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <input type="submit" class="form-control btn-success" name="submit" value="Submit">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            </form>
                                                        </div>


                                                        <div class="clearfix"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>

                                                        <th>Subject Code</th>
                                                        <th>Description</th>
                                                        <th>Teacher</th>
                                                        <th style="text-align:center">1st</th>
                                                        <th style="text-align:center">2nd</th>
                                                        <th style="text-align:center">3rd</th>
                                                        <th style="text-align:center">4th</th>
                                                        <th style="text-align:center">Ave</th>
                                                        <!-- <th>Semester</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <?php
                                                    if ($data7->gradeDisplay === "Letter") {
                                                        $i = 1;
                                                        foreach ($data3 as $row) { ?>
                                                            <tr>
                                                                <td><?= $row->SubjectCode; ?></td>
                                                                <td><?= $row->Description; ?></td>
                                                                <td><?= $row->Instructor; ?></td>
                                                                <td style='text-align:center'><?= $row->l_p; ?></td>
                                                                <td style='text-align:center'><?= $row->l_m; ?></td>
                                                                <td style='text-align:center'><?= $row->l_pf; ?></td>
                                                                <td style='text-align:center'><?= $row->l_f; ?></td>
                                                                <td style='text-align:center'><?= $row->l_average; ?></td>

                                                            </tr>
                                                            <?php
                                                            $gd = $this->Common->two_cond_ne('grades', 'StudentNumber', $this->input->get('id'), 'SY', $row->SY, 'subComponent', '');
                                                            if ($row->subComponent != '') {
                                                                foreach ($gd as $grow) {
                                                            ?>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><?= $grow->subComponent; ?></td>
                                                                        <td><?= $grow->Instructor; ?></td>
                                                                        <td style='text-align:center'><?= $grow->PGrade; ?></td>
                                                                        <td style='text-align:center'><?= $grow->MGrade; ?></td>
                                                                        <td style='text-align:center'><?= $grow->PFinalGrade; ?></td>
                                                                        <td style='text-align:center'><?= $grow->FGrade; ?></td>
                                                                        <td style='text-align:center'><?= $grow->Average; ?></td>

                                                                    </tr>
                                                            <?php }
                                                            }
                                                        }
                                                    } else {
                                                        $i = 1;
                                                        foreach ($data3 as $row) { ?>
                                                            <tr>
                                                                <td><?= $row->SubjectCode; ?></td>
                                                                <td><?= $row->Description; ?></td>
                                                                <td><?= $row->Instructor; ?></td>


                                                                <td style="text-align:center" class="<?= $row->PGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                                    <?= number_format($row->PGrade, 2)  ?>
                                                                </td>
                                                                <td style="text-align:center" class="<?= $row->MGrade < 74.5 ? 'bg-danger text-white' : '' ?>">

                                                                    <?= number_format($row->MGrade, 2)  ?>
                                                                </td>
                                                                <td style="text-align:center" class="<?= $row->PFinalGrade < 74.5 ? 'bg-danger text-white' : '' ?>">

                                                                    <?= number_format($row->PFinalGrade, 2)  ?>
                                                                </td>
                                                                <td style="text-align:center" class="<?= $row->FGrade < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                                    <?= number_format($row->FGrade, 2)  ?>

                                                                </td>
                                                                <td style="text-align:center" class="<?= $row->Average < 74.5 ? 'bg-danger text-white' : '' ?>">
                                                                    <?= number_format($row->Average, 2)  ?>
                                                                </td>

                                                            </tr>
                                                            <?php
                                                            $gd = $this->Common->two_cond_ne('grades', 'StudentNumber', $this->input->get('id'), 'SY', $row->SY, 'subComponent', '');
                                                            if ($row->subComponent != '') {
                                                                foreach ($gd as $grow) {
                                                            ?>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><?= $grow->subComponent; ?></td>
                                                                        <td><?= $grow->Instructor; ?></td>
                                                                        <td style='text-align:center'><?= $grow->PGrade; ?></td>
                                                                        <td style='text-align:center'><?= $grow->MGrade; ?></td>
                                                                        <td style='text-align:center'><?= $grow->PFinalGrade; ?></td>
                                                                        <td style='text-align:center'><?= $grow->FGrade; ?></td>
                                                                        <td style='text-align:center'><?= $grow->Average; ?></td>

                                                                    </tr>

                                                    <?php }
                                                            }
                                                        }
                                                    }

                                                    ?>
                                                </tbody>

                                            </table>

                                        </div>

                                        <!-- settings -->
                                        <div id="accounthistory" class="tab-pane">
                                            <h4 class="mt-1 font-18 ellipsis">Account History</h4>
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <tr>
                                                    <th style="text-align: center">Semester, SY</th>
                                                    <th style="text-align: center">Total Account</th>
                                                    <th style="text-align: center">Discount</th>
                                                    <th style="text-align: center">Total Payments</th>
                                                    <th style="text-align: center">Balance</th>
                                                </tr>
                                                <?php
                                                foreach ($data4 as $row) {
                                                    echo "<tr>";
                                                    echo "<td style='text-align: center'>" . $row->Semester . "</td>";
                                                    echo "<td style='text-align: center'>" . $row->AcctTotal . "</td>";
                                                    echo "<td style='text-align: center'>" . number_format($row->Discount, 2) . "</td>";
                                                ?>
                                                    <td style="text-align: center"><a href="studepayments?studentno=<?php echo $row->StudentNumber; ?>&sy=<?php echo $row->SY; ?>&sem=<?php echo $row->Sem; ?>"><button type="button" class="btn btn-primary"><?php echo $row->TotalPayments; ?></button></a></td>
                                                <?php
                                                    echo "<td style='text-align: center'>" . $row->CurrentBalance . "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </table>
                                        </div>

                                        <!-- profile -->
                                        <div id="enrollmenthistory" class="tab-pane">
                                            <h4 class="mt-1 font-18 ellipsis">Enrollment History</h4>
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>SY</th>
                                                        <th>Course</th>
                                                        <th>Year Level</th>

                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <?php
                                                    $i = 1;
                                                    foreach ($data5 as $row) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row->SY . "</td>";
                                                        echo "<td>" . $row->Course . "</td>";
                                                        echo "<td>" . $row->YearLevel . "</td>";

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                            </table>
                                        </div>
                                        <!-- request -->
                                        <div id="requesthistory" class="tab-pane">
                                            <h4 class="mt-1 font-18 ellipsis">Document Request History</h4>






                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Document Requested</th>
                                                        <th>Date</th>
                                                        <th>Tracking No.</th>
                                                        <th>Status</th>
                                                        <th>Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <?php
                                                    $i = 1;
                                                    foreach ($data6 as $row) {

                                                        if (!$data6) {
                                                            echo "No Records Found ";
                                                        } else {

                                                            echo "<tr>";
                                                            echo "<td>" . $row->docName . "</td>";
                                                            echo "<td>" . $row->dateReq . ', SY ' . $row->timeReq . "</td>";
                                                            echo "<td>" . $row->trackingNo  . "</td>";
                                                            echo "<td>" . $row->reqStat  . "</td>";
                                                        }
                                                    ?>

                                                        <td>
                                                            <a href="<?= base_url(); ?>Page/studentRequestStat?trackingNo=<?= $row->trackingNo; ?>" class="text-primary"><i class="mdi mdi-file-document-box-check-outline"></i>Track</a>
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

        <!-- end container-fluid -->

    </div>
    <!-- end content -->

    <!-- Edit Student Number Modal -->
    <div id="editStudentNumberModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editStudentNumberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentNumberModalLabel">Edit Student Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo base_url('Page/UpdateStudeNo'); ?>">
                        <!-- Hidden field with the original StudentNumber -->
                        <input type="hidden" name="originalStudentNumber" id="originalStudentNumber" value="<?php echo $data[0]->StudentNumber; ?>">
                        <div class="form-group">
                            <label for="studentNumber">Student Number</label>
                            <input type="text" class="form-control" id="studentNumber" name="studentNumber" value="<?php echo $data[0]->StudentNumber; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
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