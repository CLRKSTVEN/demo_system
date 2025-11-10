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

                    <!-- Alerts -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0"></ol>
                                </div>
                                <div class="clearfix"></div>

                                <?php if ($msg = $this->session->flashdata('success')): ?>
                                    <?= '<br /><div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>' . $msg . '</div>'; ?>
                                <?php endif; ?>

                                <?php
                                $dangerMsg = $this->session->flashdata('danger');
                                if (!$dangerMsg) {
                                    $dangerMsg = $this->session->flashdata('error');
                                }
                                ?>
                                <?php if (!empty($dangerMsg)): ?>
                                    <?= '<br /><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>' . $dangerMsg . '</div>'; ?>
                                <?php endif; ?>

                                <?php if ($msg = $this->session->flashdata('warning')): ?>
                                    <?= '<br /><div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>' . $msg . '</div>'; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <?php
                    // ===== Settings & preschool / letter-grade logic =====
                    $setting = $this->db->get_where('srms_settings_o', ['settingsID' => 1])->row();
                    $preschoolBuckets = ['Kinder', 'Kinder 1', 'Kinder 2', 'Preschool', 'Nursery', 'Prekinder'];
                    $yearLevel = isset($g) && isset($g->YearLevel) ? $g->YearLevel : (isset($yearLevel) ? $yearLevel : null);
                    $isPreschool = isset($isPreschool) ? (bool)$isPreschool : ($yearLevel ? in_array($yearLevel, $preschoolBuckets, true) : false);
                    $useLetter = $isPreschool && $setting && $setting->preschoolGrade === 'Letter';

                    // ===== Period map =====
                    $allPeriods = [
                        '1' => ['key' => 'prelim',   'num' => 'PGrade',      'let' => 'l_p',  'label' => '1st Grading', 'lock' => 'prelim_locked'],
                        '2' => ['key' => 'midterm',  'num' => 'MGrade',      'let' => 'l_m',  'label' => '2nd Grading', 'lock' => 'midterm_locked'],
                        '3' => ['key' => 'prefinal', 'num' => 'PFinalGrade', 'let' => 'l_pf', 'label' => '3rd Grading', 'lock' => 'prefinal_locked'],
                        '4' => ['key' => 'final',    'num' => 'FGrade',      'let' => 'l_f',  'label' => '4th Grading', 'lock' => 'final_locked'],
                    ];

                    // ===== Helpers =====
                    function norm_sex($val)
                    {
                        $s = ucfirst(strtolower((string)$val));
                        return ($s === 'Male' || $s === 'Female') ? $s : 'Others';
                    }

                    $val_nonzero = function ($v) {
                        if ($v === null) return false;
                        if (is_string($v)) {
                            $t = trim($v);
                            if ($t === '') return false;
                            return is_numeric($t) ? (float)$t > 0 : true;
                        }
                        if (is_numeric($v)) return (float)$v > 0;
                        return !empty($v);
                    };

                    // ===== Progressive visibility =====
                    $show = ['1' => true, '2' => false, '3' => false, '4' => false];
                    if (!empty($grades)) {
                        $anyP = $anyM = $anyPF = false;
                        foreach ($grades as $r) {
                            if ($useLetter) {
                                if (!$anyP  && $val_nonzero($r->l_p  ?? null)) $anyP  = true;
                                if (!$anyM  && $val_nonzero($r->l_m  ?? null)) $anyM  = true;
                                if (!$anyPF && $val_nonzero($r->l_pf ?? null)) $anyPF = true;
                            } else {
                                if (!$anyP  && $val_nonzero($r->PGrade      ?? null)) $anyP  = true;
                                if (!$anyM  && $val_nonzero($r->MGrade      ?? null)) $anyM  = true;
                                if (!$anyPF && $val_nonzero($r->PFinalGrade ?? null)) $anyPF = true;
                            }
                            if ($anyP && $anyM && $anyPF) break;
                        }
                        if ($anyP) {
                            $show['2'] = true;
                            if ($anyM) {
                                $show['3'] = true;
                                if ($anyPF) {
                                    $show['4'] = true;
                                }
                            }
                        }
                    }
                    $selectedPeriods = [];
                    foreach (['1', '2', '3', '4'] as $pid) {
                        if ($show[$pid]) $selectedPeriods[] = array_merge($allPeriods[$pid], ['id' => $pid]);
                    }

                    // Lock schedule (default values)
                    date_default_timezone_set('Asia/Manila');
                    $now = date('Y-m-d H:i:s');
                    $lock = ['prelim_locked' => false, 'midterm_locked' => false, 'prefinal_locked' => false, 'final_locked' => false];
                    if (isset($lockSchedule) && $lockSchedule) {
                        $lock['prelim_locked']   = $now > ($lockSchedule->prelim   ?? '2100-01-01 00:00:00');
                        $lock['midterm_locked']  = $now > ($lockSchedule->midterm  ?? '2100-01-01 00:00:00');
                        $lock['prefinal_locked'] = $now > ($lockSchedule->prefinal ?? '2100-01-01 00:00:00');
                        $lock['final_locked']    = $now > ($lockSchedule->final    ?? '2100-01-01 00:00:00');
                    }

                    // If controller provided subject-level lockRow, override
                    if (isset($lockRow) && $lockRow) {
                        $lock['prelim_locked']   = !empty($lockRow->lock_prelim);
                        $lock['midterm_locked']  = !empty($lockRow->lock_midterm);
                        $lock['prefinal_locked'] = !empty($lockRow->lock_prefinal);
                        $lock['final_locked']    = !empty($lockRow->lock_final);
                    }

                    $sexStyleMap = [
                        'Male'   => 'bg-primary text-white',
                        'Female' => 'bg-danger text-white',
                        'Others' => 'bg-secondary text-white',
                    ];
                    $colspan = 3 + count($selectedPeriods) + (($useLetter || count($selectedPeriods) !== 4) ? 0 : 1);
                    ?>

                    <!-- Locking status badges -->
                    <?php if (!empty($selectedPeriods)): ?>
                        <div class="alert alert-info">
                            <strong>Locking Status:</strong>
                            <div class="d-flex flex-wrap mt-2">
                                <?php foreach ($selectedPeriods as $p): ?>
                                    <span class="badge badge-<?= !empty($lock[$p['lock']]) ? 'danger' : 'success'; ?> mr-2 mb-1">
                                        <?= $p['label']; ?>: <?= !empty($lock[$p['lock']]) ? 'Locked' : 'Open'; ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!$grades) { ?>
                        <!-- ===============================
                         INPUT GRADES (no existing rows)
                         =============================== -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Input Grades</h4>
                                        <table>
                                            <tr>
                                                <td>Subject Code</td>
                                                <td>: <?= html_escape($resolvedSubjectCode ?? $this->input->get('subjectcode')); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td>: <?= html_escape($resolvedDescription ?? ($this->input->get('description') ?: $this->input->get('Description'))); ?></td>
                                            </tr>

                                            <tr>
                                                <td>Section</td>
                                                <td>: <?= html_escape($this->input->get('section')); ?></td>
                                            </tr>
                                        </table><br />

                                        <?php
                                        $groupedInput = ['Male' => [], 'Female' => [], 'Others' => []];
                                        foreach ($grade as $row) {
                                            $stud = $this->Common->one_cond_row('studeprofile', 'StudentNumber', $row->StudentNumber);
                                            $sex  = norm_sex($stud->Sex ?? '');
                                            $groupedInput[$sex][] = ['row' => $row, 'stud' => $stud];
                                        }
                                        ?>

                                        <?= form_open('Ren/inputGrade', ['class' => 'parsley-examples']); ?>
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Student Name</th>
                                                        <th>Student No.</th>
                                                        <?php foreach ($selectedPeriods as $p): ?>
                                                            <th class="text-center"><?= $p['label']; ?></th>
                                                        <?php endforeach; ?>
                                                        <?php if (!$useLetter && count($selectedPeriods) === 4): ?>
                                                            <th class="text-center">Average</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (['Male', 'Female', 'Others'] as $SEX): ?>
                                                        <?php if (!empty($groupedInput[$SEX])): ?>
                                                            <tr>
                                                                <td colspan="<?= $colspan; ?>"
                                                                    class="text-center font-weight-bold <?= $sexStyleMap[$SEX] ?? 'bg-secondary text-white'; ?>">
                                                                    <?= strtoupper($SEX); ?>
                                                                </td>
                                                            </tr>
                                                            <?php $c = 1;
                                                            foreach ($groupedInput[$SEX] as $item):
                                                                $row  = $item['row'];
                                                                $stud = $item['stud'];
                                                                $adviser = $this->Common->three_cond_row(
                                                                    'semesterstude',
                                                                    'StudentNumber',
                                                                    $row->StudentNumber,
                                                                    'SY',
                                                                    $this->session->sy,
                                                                    'YearLevel',
                                                                    $g->YearLevel
                                                                );
                                                            ?>
                                                                <tr>
                                                                    <th><?= $c++; ?></th>
                                                                    <td>
                                                                        <?= html_escape($stud->LastName); ?>, <?= html_escape($stud->FirstName); ?>
                                                                        <?= $stud->MiddleName ? ' ' . html_escape(substr($stud->MiddleName, 0, 1)) . '.' : '' ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= html_escape($row->StudentNumber); ?>
                                                                        <input type="hidden" name="StudentNumber[]" value="<?= html_escape($row->StudentNumber); ?>">

                                                                        <!-- Use the canonical values -->
                                                                        <input type="hidden" name="SubjectCode" value="<?= html_escape($resolvedSubjectCode ?? ($g->SubjectCode ?? '')); ?>">
                                                                        <input type="hidden" name="description" value="<?= html_escape($resolvedDescription ?? ($g->Description ?? '')); ?>">

                                                                        <input type="hidden" name="section" value="<?= html_escape($this->input->get('section')); ?>">
                                                                        <input type="hidden" name="SY" value="<?= html_escape($this->session->userdata('sy')); ?>">
                                                                        <input type="hidden" name="Sem" value="<?= html_escape($this->session->userdata('semester')); ?>">

                                                                        <input type="hidden" name="Instructor" value="<?= isset($g->Instructor) ? html_escape($g->Instructor) : '' ?>">

                                                                        <!-- Single scalar strand (match controller) -->
                                                                        <input type="hidden" name="strand" value="<?= html_escape($this->input->get('strand')); ?>">

                                                                        <!-- Use canonical YearLevel as well -->
                                                                        <input type="hidden" name="YearLevel" value="<?= html_escape($resolvedYearLevel ?? ($row->YearLevel ?? ($g->YearLevel ?? ''))); ?>">

                                                                        <!-- If you don’t use subComponent, still pass an empty string to satisfy NOT NULL -->
                                                                        <input type="hidden" name="subComponent" value="<?= isset($g->subComponent) ? html_escape($g->subComponent) : '' ?>">

                                                                        <?php foreach ($selectedPeriods as $p): ?>
                                                                    <td class="text-center">
                                                                        <?php if ($useLetter): ?>
                                                                            <input style="width:70%" type="text" name="<?= $p['let']; ?>[]" <?= !empty($lock[$p['lock']]) ? 'disabled' : '' ?>>
                                                                        <?php else: ?>
                                                                            <input style="width:70%" type="text" name="<?= $p['num']; ?>[]" <?= !empty($lock[$p['lock']]) ? 'disabled' : '' ?>>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                <?php endforeach; ?>
                                                                <?php if (!$useLetter && count($selectedPeriods) === 4): ?>
                                                                    <td class="text-center"><input style="width:70%" type="text" name="Average[]" readonly></td>
                                                                <?php endif; ?>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group text-right mb-0">
                                            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>
                        <!-- =====================================
                         REPORT OF GRADES (with existing rows)
                         ===================================== -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <div class="float-left">
                                            <h4 class="m-t-0 header-title mb-1"><b>Report of Grades</b><br />
                                                <span class="badge badge-purple mb-1">
                                                    <b><?= html_escape($grades[0]->SY . ' ' . $grades[0]->Sem); ?></b>
                                                </span>
                                                <?php $ins = $this->Common->one_cond_row('staff', 'IDNumber', $grades[0]->Instructor); ?>
                                            </h4>
                                            <table>
                                                <tr>
                                                    <td>Subject Code</td>
                                                    <td>: <?= html_escape($grades[0]->SubjectCode); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Description</td>
                                                    <td>: <?= html_escape($grades[0]->Description); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Section</td>
                                                    <td>: <?= html_escape($grades[0]->Section); ?></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <?php
                                        $groupedGrades = ['Male' => [], 'Female' => [], 'Others' => []];
                                        foreach ($grades as $row) {
                                            $sex = norm_sex($row->Sex ?? '');
                                            $groupedGrades[$sex][] = $row;
                                        }
                                        ?>

                                        <?= form_open('Ren/updateGrade', ['class' => 'parsley-examples']); ?>
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Student Name</th>
                                                    <th>Student No.</th>
                                                    <?php foreach ($selectedPeriods as $p): ?>
                                                        <th class="text-center"><?= $p['label']; ?></th>
                                                    <?php endforeach; ?>
                                                    <?php if (!$useLetter && count($selectedPeriods) === 4): ?>
                                                        <th class="text-center">Average</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach (['Male', 'Female', 'Others'] as $SEX): ?>
                                                    <?php if (!empty($groupedGrades[$SEX])): ?>
                                                        <tr>
                                                            <td colspan="<?= $colspan; ?>"
                                                                class="text-center font-weight-bold <?= $sexStyleMap[$SEX] ?? 'bg-secondary text-white'; ?>">
                                                                <?= strtoupper($SEX); ?>
                                                            </td>
                                                        </tr>
                                                        <?php $c = 1;
                                                        foreach ($groupedGrades[$SEX] as $row):
                                                            $adviser = $this->Common->three_cond_row(
                                                                'semesterstude',
                                                                'StudentNumber',
                                                                $row->StudentNumber,
                                                                'SY',
                                                                $this->session->sy,
                                                                'YearLevel',
                                                                $g->YearLevel
                                                            );
                                                        ?>
                                                            <tr>
                                                                <th><?= $c++; ?></th>
                                                                <td>
                                                                    <?= html_escape($row->LastName); ?>, <?= html_escape($row->FirstName); ?>
                                                                    <?= $row->MiddleName ? html_escape(substr($row->MiddleName, 0, 1)) . '.' : '' ?>
                                                                </td>
                                                                <td>
                                                                    <?= html_escape($row->StudentNumber); ?>
                                                                    <input type="hidden" name="StudentNumber[]" value="<?= html_escape($row->StudentNumber); ?>">
                                                                    <input type="hidden" name="SubjectCode" value="<?= html_escape($resolvedSubjectCode ?? ($g->SubjectCode ?? '')); ?>">
                                                                    <input type="hidden" name="description" value="<?= html_escape($this->input->get('description') ?: $this->input->get('Description')); ?>">
                                                                    <input type="hidden" name="section" value="<?= html_escape($this->input->get('section')); ?>">
                                                                    <input type="hidden" name="SY" value="<?= html_escape($this->session->sy); ?>">
                                                                    <input type="hidden" name="YearLevel" value="<?= isset($g->YearLevel) ? html_escape($g->YearLevel) : ''; ?>">
                                                                    <input type="hidden" name="Instructor" value="<?= isset($g->Instructor) ? html_escape($g->Instructor) : ''; ?>">
                                                                    <input type="hidden" name="adviser[]" value="<?= isset($adviser->IDNumber) ? html_escape($adviser->IDNumber) : ''; ?>">
                                                                    <input type="hidden" name="gradeID[]" value="<?= html_escape($row->gradeID); ?>">
                                                                    <input type="hidden" name="strand" value="<?= html_escape($this->input->get('strand')); ?>">
                                                                    <input type="hidden" name="ins" value="<?= isset($g->Instructor) ? html_escape($g->Instructor) : ''; ?>">
                                                                </td>
                                                                <?php foreach ($selectedPeriods as $p): ?>
                                                                    <?php $isLocked = !empty($lock[$p['lock']]); ?>
                                                                    <td class="text-center">
                                                                        <?php if ($useLetter): ?>
                                                                            <input type="text" style="width:70%" class="text-center <?= $isLocked ? 'locked-input' : '' ?>"
                                                                                name="<?= $p['let']; ?>[]"
                                                                                value="<?= isset($row->{$p['let']}) ? html_escape($row->{$p['let']}) : '' ?>"
                                                                                <?= $isLocked ? 'readonly' : '' ?>
                                                                                title="<?= $isLocked ? 'Locked by registrar' : '' ?>">
                                                                        <?php else: ?>
                                                                            <input type="text" style="width:70%" class="text-center <?= $isLocked ? 'locked-input' : '' ?>"
                                                                                name="<?= $p['num']; ?>[]"
                                                                                value="<?= isset($row->{$p['num']}) ? html_escape($row->{$p['num']}) : '' ?>"
                                                                                <?= $isLocked ? 'readonly' : '' ?>
                                                                                title="<?= $isLocked ? 'Locked by registrar' : '' ?>">
                                                                        <?php endif; ?>
                                                                    </td>
                                                                <?php endforeach; ?>
                                                                <?php if (!$useLetter && count($selectedPeriods) === 4): ?>
                                                                    <td class="text-center"><?= isset($row->Average) ? number_format($row->Average) : ''; ?></td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <div class="form-group text-right mt-3">
                                            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">Update</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>

        <?php include('includes/themecustomizer.php'); ?>
        <style>
            .locked-input {
                background: #f8d7da;
                /* light red */
                border-color: #f5c2c7;
                cursor: not-allowed;
            }
        </style>

        <!-- Vendor js -->
        <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>
    </div>
</body>

</html>
