<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>

    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Advisory Class -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h3 class="mb-4">Advisory Class</h3>

                                    <?php if ($this->session->flashdata('success')) : ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <?= $this->session->flashdata('success'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->flashdata('danger')) : ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <?= $this->session->flashdata('danger'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    // Normalize and group by Sex
                                    $groupedStudents = ['Male' => [], 'Female' => [], 'Unknown' => []];

                                    foreach ($students as $student) {
                                        $sex = ucfirst(trim(strtolower($student->Sex)));
                                        if (in_array($sex, ['Male', 'Female'])) {
                                            $groupedStudents[$sex][] = $student;
                                        } else {
                                            $groupedStudents['Unknown'][] = $student;
                                        }
                                    }
                                    ?>

                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Student Number</th>
                                                <th>Name</th>
                                                <th>Year</th>
                                                <th>Section</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <!-- Inside tbody -->
                                        <tbody>
                                            <?php foreach (['Male', 'Female', 'Unknown'] as $sex): ?>
                                                <?php if (count($groupedStudents[$sex]) > 0): ?>
                                                    <tr class="table-primary">
                                                        <td colspan="5"><strong><?= strtoupper($sex) . " (" . count($groupedStudents[$sex]) . ")"; ?></strong></td>
                                                    </tr>
                                                    <?php foreach ($groupedStudents[$sex] as $student): ?>
                                                        <tr>
                                                            <td><?= $student->StudentNumber; ?></td>
                                                            <td><?= $student->LastName . ', ' . $student->FirstName . ' ' . $student->MiddleName; ?></td>
                                                            <td><?= $student->YearLevel; ?></td>
                                                            <td><?= $student->Section; ?></td>
                                                            <td class="text-nowrap">
                                                                <!-- View Profile -->
                                                                <a href="<?= base_url(); ?>page/studentsprofile?id=<?= $student->StudentNumber; ?>"
                                                                    class="btn btn-info btn-sm tooltips"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="View Profile">
                                                                    <i class="fas fa-user"></i>
                                                                </a>

                                                                <!-- Edit Enrollment -->
                                                                <a href="<?= base_url(); ?>Page/updateEnrollment?id=<?= $student->semstudentid; ?>"
                                                                    class="btn btn-success btn-sm tooltips"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Edit Enrollment">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>

                                                                <!-- Narrative -->
                                                                <a href="#"
                                                                    class="btn btn-warning btn-sm tooltips"
                                                                    data-toggle="modal"
                                                                    data-placement="top"
                                                                    title="Narrative"
                                                                    data-target="#narrativeModal<?= $student->StudentNumber; ?>">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </a>
                                                                <!-- Report Dropdown -->
                                                                <?php if (isset($student) && !empty($student)): ?>
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fas fa-file-alt"></i> Reports
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">

                                                                            <?php $course = strtolower(trim((string)($student->Course ?? ''))); ?>

                                                                            <a class="dropdown-item" href="<?= base_url("Ren/goodmoral/{$student->StudentNumber}") ?>" target="_blank">
                                                                                <i class="far fa-hand-point-left"></i> Good Moral
                                                                            </a>

                                                                            <a class="dropdown-item" href="<?= base_url("Ren/clearance/{$student->StudentNumber}") ?>" target="_blank">
                                                                                <i class="fas fa-file-alt"></i> Certificate of Enrollment
                                                                            </a>

                                                                            <a class="dropdown-item" href="<?= base_url("Ren/report_card/{$student->StudentNumber}") ?>" target="_blank">
                                                                                <i class="fas fa-file-alt"></i> Report Card (JHS)
                                                                            </a>

                                                                            <?php if (in_array($course, ['junior high school', 'senior high school'], true)): ?>
                                                                                <a class="dropdown-item" href="<?= base_url("Shs_report/rlpd/{$student->StudentNumber}") ?>" target="_blank">
                                                                                    <i class="fas fa-file-alt text-warning"></i> Report Card (SHS)
                                                                                </a>
                                                                            <?php endif; ?>

                                                                            <a class="dropdown-item" href="<?= base_url("Ren/clear/{$student->StudentNumber}") ?>" target="_blank">
                                                                                <i class="fas fa-folder-open"></i> Clearance
                                                                            </a>

                                                                            <a class="dropdown-item" href="<?= base_url("Ren/stud_prof/{$student->StudentNumber}") ?>" target="_blank">
                                                                                <i class="fas fa-user-friends"></i> Student Profile
                                                                            </a>

                                                                            <a class="dropdown-item" href="<?= base_url("Ren/stud_register_enrollment/{$student->StudentNumber}") ?>" target="_blank">
                                                                                <i class="fab fa-wpforms"></i> Registration Form
                                                                            </a>

                                                                            <?php if ($course === 'elementary'): ?>
                                                                                <a class="dropdown-item" href="<?= base_url("Ren/rc_sf9_es/{$student->StudentNumber}") ?>" target="_blank">
                                                                                    <i class="fas fa-file-alt"></i> SF9 - ES
                                                                                </a>
                                                                                <a class="dropdown-item" href="<?= base_url("sf10/sf10_elem/{$student->StudentNumber}") ?>" target="_blank">
                                                                                    <i class="fas fa-file-alt"></i> SF10 - ES
                                                                                </a>
                                                                            <?php elseif ($course === 'junior high school'): ?>
                                                                                <a class="dropdown-item" href="<?= base_url("Ren/rc_sf9_js/{$student->StudentNumber}") ?>" target="_blank">
                                                                                    <i class="fas fa-file-alt"></i> SF9 - JHS
                                                                                </a>
                                                                                <a class="dropdown-item" href="<?= base_url("sf10/index/{$student->StudentNumber}") ?>" target="_blank">
                                                                                    <i class="fas fa-file-alt"></i> SF10 - JHS
                                                                                </a>
                                                                            <?php elseif ($course === 'senior high school'): ?>
                                                                                <a class="dropdown-item" href="<?= base_url("Ren/rc_sf9_js/{$student->StudentNumber}") ?>" target="_blank">
                                                                                    <i class="fas fa-file-alt"></i> SF9 - SHS
                                                                                </a>
                                                                                <a class="dropdown-item" href="<?= base_url("sf10/sf10_shs/{$student->StudentNumber}") ?>" target="_blank">
                                                                                    <i class="fas fa-file-alt"></i> SF10 - SHS
                                                                                </a>
                                                                            <?php endif; ?>

                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>


                                                            </td>



                                                        </tr>

                                                        <?php $narr = $narratives[$student->StudentNumber] ?? null; ?>

                                                        <!-- ✅ Narrative Modal Per Student -->
                                                        <div class="modal fade" id="narrativeModal<?= $student->StudentNumber; ?>" tabindex="-1" role="dialog" aria-labelledby="narrativeModalLabel<?= $student->StudentNumber; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <form method="post" action="<?= base_url('Page/saveNarrative'); ?>">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="narrativeModalLabel<?= $student->StudentNumber; ?>">
                                                                                Narrative for <?= $student->LastName . ', ' . $student->FirstName; ?>
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <!-- Hidden Fields -->
                                                                            <input type="hidden" name="StudentNumber" value="<?= $student->StudentNumber; ?>">
                                                                            <input type="hidden" name="YearLevel" value="<?= $student->YearLevel; ?>">
                                                                            <input type="hidden" name="Section" value="<?= $student->Section; ?>">
                                                                            <input type="hidden" name="SY" value="<?= $this->session->userdata('sy'); ?>">

                                                                            <!-- Textareas with prefilled data -->
                                                                            <div class="form-group">
                                                                                <label>First Quarter</label>
                                                                                <textarea class="form-control" name="FirstQuarter" rows="2"><?= $narr->FirstQuarter ?? ''; ?></textarea>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label>Second Quarter</label>
                                                                                <textarea class="form-control" name="SecondQuarter" rows="2"><?= $narr->SecondQuarter ?? ''; ?></textarea>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label>Third Quarter</label>
                                                                                <textarea class="form-control" name="ThirdQuarter" rows="2"><?= $narr->ThirdQuarter ?? ''; ?></textarea>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label>Fourth Quarter</label>
                                                                                <textarea class="form-control" name="FourthQuarter" rows="2"><?= $narr->FourthQuarter ?? ''; ?></textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-primary">Save Narrative</button>
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->

                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Section -->
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
                                                <td style="text-align: center;"><?= $summary['transferee'] ?? 0; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryListByAdviser/transferee') ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View List</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Repeaters</td>
                                                <td style="text-align: center;"><?= $summary['repeater'] ?? 0; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryListByAdviser/repeater') ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View List</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Balik-Aral</td>
                                                <td style="text-align: center;"><?= $summary['balik_aral'] ?? 0; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryListByAdviser/balik_aral') ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View List</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>IPs</td>
                                                <td style="text-align: center;"><?= $summary['ip'] ?? 0; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryListByAdviser/ip') ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View List</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4Ps Beneficiaries</td>
                                                <td style="text-align: center;"><?= $summary['4ps'] ?? 0; ?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?= base_url('Masterlist/viewCategoryListByAdviser/4ps') ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View List</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Age Distribution Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="m-0 header-title">Age Distribution</h4>
                                        <a href="<?= site_url('Student/update_student_ages'); ?>" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Click to recalculate student ages for all students in the school, not just your section.">
                                            <i class="fas fa-calculator"></i> Calculate Age
                                        </a>
                                    </div>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Age</th>
                                                <th style="text-align: center;">Count</th>
                                                <th style="text-align: center;">View List</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($age_summary as $age_data): ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $age_data['Age']; ?></td>
                                                    <td style="text-align: center;"><?= $age_data['count']; ?></td>
                                                    <td style="text-align: center;">
                                                        <a href="<?= site_url('Masterlist/viewAgeList/' . $age_data['Age']); ?>" class="btn btn-info btn-sm">
                                                            <i class="fa fa-eye"></i> View List
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>

    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>


    <!-- Datatables init -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</body>

</html>