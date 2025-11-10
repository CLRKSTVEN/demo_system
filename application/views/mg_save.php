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

                <!-- Header + Launch modal -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="page-title mb-0"><?= isset($title) ? htmlspecialchars($title, ENT_QUOTES) : 'Solo Save Grades'; ?></h4>
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-student-modal-lg">
                                <i class="fas fa-user-plus mr-1"></i> Search Student
                            </button>
                        </div>

                        <!-- Flash messages -->
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?= $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('danger')): ?>
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?= $this->session->flashdata('danger'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <hr style="border:0;height:4px;background:linear-gradient(to right,#4285F4 50%,#DB4437 16%,#F4B400 17%,#0F9D58 17%)" />

                <?php
                // Normalize guard vars
                $grading = isset($grading) ? strtolower($grading) : 'all';
                $role    = isset($role) ? strtolower($role) : '';
                $hasSelection = !empty($stud) && isset($reg_rows) && is_array($reg_rows);
                ?>

                <?php if ($hasSelection): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">

                                    <!-- Student header -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h4 class="m-0">
                                                <b><?= htmlspecialchars($stud->LastName, ENT_QUOTES); ?>, <?= htmlspecialchars($stud->FirstName, ENT_QUOTES); ?> <?= htmlspecialchars($stud->MiddleName, ENT_QUOTES); ?></b>
                                            </h4>
                                            <div class="mt-1">
                                                <span class="badge badge-primary mr-1">
                                                    <b><?= htmlspecialchars($stud->StudentNumber, ENT_QUOTES); ?></b>
                                                </span>
                                                <?php $bSY = $reg_rows[0]->SY ?? ''; ?>
                                                <span class="badge badge-purple"><b><?= htmlspecialchars($bSY, ENT_QUOTES); ?></b></span>
                                                <?php if ($role === 'teacher'): ?>
                                                    <span class="badge badge-info ml-1" title="Teacher scope">Teacher</span>
                                                <?php elseif ($role === 'adviser'): ?>
                                                    <span class="badge badge-warning ml-1" title="Adviser scope">Adviser</span>
                                                <?php elseif ($role === 'registrar'): ?>
                                                    <span class="badge badge-success ml-1" title="Registrar scope">Registrar</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="d-print-none">
                                            <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <?php
                                    $show_first  = ($grading==='all' || $grading==='first');
                                    $show_second = ($grading==='all' || $grading==='second');
                                    $show_third  = ($grading==='all' || $grading==='third');
                                    $show_fourth = ($grading==='all' || $grading==='fourth');
                                    $isRegistrar = ($role === 'registrar');
                                    ?>

                                    <?php $att = ['class' => 'parsley-examples']; ?>
                                    <?= form_open('Page/save_batch_studgrade', $att); ?>
                                    <input type="hidden" name="grading" value="<?= htmlspecialchars($grading, ENT_QUOTES) ?>">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($stud->StudentNumber, ENT_QUOTES); ?>">

                                    <table class="table table-sm table-bordered mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width:56px;">No.</th>
                                                <th>Description</th>
                                                <th>Teacher</th>
                                                <?php if ($show_first):  ?><th class="text-center" style="width:140px;">1st Grading</th><?php endif; ?>
                                                <?php if ($show_second): ?><th class="text-center" style="width:140px;">2nd Grading</th><?php endif; ?>
                                                <?php if ($show_third):  ?><th class="text-center" style="width:140px;">3rd Grading</th><?php endif; ?>
                                                <?php if ($show_fourth): ?><th class="text-center" style="width:140px;">4th Grading</th><?php endif; ?>
                                                <th class="text-center" style="width:120px;">Average</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $c=1; foreach ($reg_rows as $r): ?>
                                            <?php
                                            // Current values
                                            $p  = (float)($r->PGrade ?? 0);
                                            $m  = (float)($r->MGrade ?? 0);
                                            $pf = (float)($r->PFinalGrade ?? 0);
                                            $f  = (float)($r->FGrade ?? 0);
                                            $avg= (float)($r->Average ?? 0);

                                            // Permissions per cell
                                            $can_fill_p  = $isRegistrar || ($p  == 0.0);
                                            $can_fill_m  = $isRegistrar || ($m  == 0.0);
                                            $can_fill_pf = $isRegistrar || ($pf == 0.0);
                                            $can_fill_f  = $isRegistrar || ($f  == 0.0);

                                            // Helpers
                                            $desc   = htmlspecialchars($r->Description, ENT_QUOTES);
                                            $scode  = htmlspecialchars($r->SubjectCode, ENT_QUOTES);
                                            $instr  = htmlspecialchars($r->Instructor, ENT_QUOTES);
                                            $rsy    = htmlspecialchars($r->SY, ENT_QUOTES);
                                            $ylev   = htmlspecialchars($r->YearLevel, ENT_QUOTES);
                                            $sect   = htmlspecialchars($r->Section, ENT_QUOTES);
                                            $adv    = htmlspecialchars($r->adviser ?? '', ENT_QUOTES);
                                            $strnd  = htmlspecialchars($r->strand  ?? '', ENT_QUOTES);
                                            ?>
                                            <tr>
                                                <th><?= $c++; ?></th>
                                                <td>
                                                    <?= $desc ?>
                                                    <input type="hidden" name="regID[]"       value="<?= (int)$r->regID; ?>">
                                                    <input type="hidden" name="SubjectCode[]" value="<?= $scode; ?>">
                                                    <input type="hidden" name="Description[]" value="<?= $desc; ?>">
                                                    <input type="hidden" name="Instructor[]"  value="<?= $instr; ?>">
                                                    <input type="hidden" name="SY[]"          value="<?= $rsy; ?>">
                                                    <input type="hidden" name="YearLevel[]"   value="<?= $ylev; ?>">
                                                    <input type="hidden" name="Section[]"     value="<?= $sect; ?>">
                                                    <input type="hidden" name="Adviser[]"     value="<?= $adv; ?>">
                                                    <input type="hidden" name="Strand[]"      value="<?= $strnd; ?>">
                                                </td>
                                                <td><?= $instr; ?></td>

                                                <?php if ($show_first): ?>
                                                    <td class="text-center align-middle">
                                                        <?php if ($can_fill_p): ?>
                                                            <input type="number" step="0.01" min="0" class="form-control form-control-sm text-center"
                                                                name="PGrade[<?= (int)$r->regID; ?>]" value="<?= $isRegistrar && $p>0 ? number_format($p,2,'.','') : '' ?>">
                                                        <?php else: ?>
                                                            <span title="Locked"><?= number_format($p,2) ?> <i class="fa fa-lock text-muted"></i></span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>

                                                <?php if ($show_second): ?>
                                                    <td class="text-center align-middle">
                                                        <?php if ($can_fill_m): ?>
                                                            <input type="number" step="0.01" min="0" class="form-control form-control-sm text-center"
                                                                name="MGrade[<?= (int)$r->regID; ?>]" value="<?= $isRegistrar && $m>0 ? number_format($m,2,'.','') : '' ?>">
                                                        <?php else: ?>
                                                            <span title="Locked"><?= number_format($m,2) ?> <i class="fa fa-lock text-muted"></i></span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>

                                                <?php if ($show_third): ?>
                                                    <td class="text-center align-middle">
                                                        <?php if ($can_fill_pf): ?>
                                                            <input type="number" step="0.01" min="0" class="form-control form-control-sm text-center"
                                                                name="PFinalGrade[<?= (int)$r->regID; ?>]" value="<?= $isRegistrar && $pf>0 ? number_format($pf,2,'.','') : '' ?>">
                                                        <?php else: ?>
                                                            <span title="Locked"><?= number_format($pf,2) ?> <i class="fa fa-lock text-muted"></i></span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>

                                                <?php if ($show_fourth): ?>
                                                    <td class="text-center align-middle">
                                                        <?php if ($can_fill_f): ?>
                                                            <input type="number" step="0.01" min="0" class="form-control form-control-sm text-center"
                                                                name="FGrade[<?= (int)$r->regID; ?>]" value="<?= $isRegistrar && $f>0 ? number_format($f,2,'.','') : '' ?>">
                                                        <?php else: ?>
                                                            <span title="Locked"><?= number_format($f,2) ?> <i class="fa fa-lock text-muted"></i></span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>

                                                <td class="text-center align-middle">
                                                    <?= ($avg > 0) ? number_format($avg, 2) : '—' ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <div class="form-group text-right mb-0 mt-3">
                                        <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                                            <?= $isRegistrar ? 'Save / Update Grades' : 'Save Grades' ?>
                                        </button>
                                    </div>

                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Empty state -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                Use <b>Search Student</b> to select a learner and proceed with manual encoding.
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div> <!-- /.container-fluid -->
        </div> <!-- /.content -->

        <?php include('includes/footer.php'); ?>
    </div> <!-- /.content-page -->
</div> <!-- /#wrapper -->

<!-- Student picker modal -->
<div class="modal fade bs-student-modal-lg" tabindex="-1" role="dialog" aria-labelledby="studentPickerLabel" style="display:none" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="studentPickerLabel">Search Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <?php $att = ['class' => 'parsley-examples']; ?>
            <?= form_open('Page/save_grades', $att); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Fullname <span class="text-danger">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="sn" required>
                                <option value="">Select</option>
                                <?php if (!empty($studs)) foreach ($studs as $row): ?>
                                    <option value="<?= htmlspecialchars($row->StudentNumber, ENT_QUOTES); ?>">
                                        <?= htmlspecialchars($row->LastName, ENT_QUOTES); ?>, <?= htmlspecialchars($row->FirstName, ENT_QUOTES); ?> <?= htmlspecialchars($row->MiddleName, ENT_QUOTES); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label>Which grading?</label>
                      <select class="form-control" name="grading">
                        <option value="all"   <?= ($grading==='all')?'selected':''; ?>>All gradings</option>
                        <option value="first" <?= ($grading==='first')?'selected':''; ?>>1st Grading</option>
                        <option value="second"<?= ($grading==='second')?'selected':''; ?>>2nd Grading</option>
                        <option value="third" <?= ($grading==='third')?'selected':''; ?>>3rd Grading</option>
                        <option value="fourth"<?= ($grading==='fourth')?'selected':''; ?>>4th Grading</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row"><div class="col-lg-12">
                    <input type="submit" name="submit" class="btn btn-info" value="Submit">
                </div></div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>

<script>
(function(){
  // Initialize Select2 inside modal properly
  $('.select2').select2({ width: '100%' });
})();
</script>
</body>
</html>
