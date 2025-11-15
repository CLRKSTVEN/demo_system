<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Expose CSRF to JS if enabled -->
<meta name="csrf-token-name" content="<?= $this->security->get_csrf_token_name(); ?>">
<meta name="csrf-token-hash" content="<?= $this->security->get_csrf_hash(); ?>">

<body>
    <div id="wrapper">

        <!-- Topbar -->
        <?php include('includes/top-nav-bar.php'); ?>

        <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <div class="float-left">
                                    <h5 class="m-0" style="text-transform:uppercase">
                                        <strong>CONSOLIDATED REPORT OF GRADES</strong><br>
                                        <?php
                                        // Figure out current grading code -> which lock field to inspect
                                        $grading_code  = $this->input->post('grading'); // PGrade / MGrade / PFinalGrade / FGrade
                                        $period_field  = null;
                                        switch ($grading_code) {
                                            case 'PGrade':
                                                $period_field = 'lock_prelim';
                                                break;
                                            case 'MGrade':
                                                $period_field = 'lock_midterm';
                                                break;
                                            case 'PFinalGrade':
                                                $period_field = 'lock_prefinal';
                                                break;
                                            case 'FGrade':
                                                $period_field = 'lock_final';
                                                break;
                                        }
                                        // Compute if ANY subject is locked for this grading
                                        $anyLockedThisPeriod = false;
                                        if ($period_field && !empty($sub)) {
                                            foreach ($sub as $r) {
                                                $code  = $r->SubjectCode ?? '';
                                                $locks = $locks_map[$code] ?? null;
                                                if ($locks && !empty($locks->{$period_field})) {
                                                    $anyLockedThisPeriod = true;
                                                    break;
                                                }
                                            }
                                        }
                                        $semBadgeClass = $anyLockedThisPeriod ? 'badge-danger' : 'badge-success';
                                        ?>

                                        <span class="badge badge-purple mb-3">
                                            SY <?= $this->session->userdata('sy'); ?>
                                        </span>
                                        <span id="semester-lock-state" class="badge <?= $semBadgeClass; ?> mb-3 ml-1" title="<?= $anyLockedThisPeriod ? 'Some subjects locked for this grading' : 'All subjects open for this grading'; ?>">
                                            <?= $this->session->userdata('semester'); ?>
                                        </span>

                                    </h5>
                                </div>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="#"></a></li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Title -->

                    <!-- Main Card -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Filter Form -->
                                    <style>
                                        @media print {
                                            .no-print {
                                                display: none !important;
                                            }
                                        }

                                        .print-only {
                                            display: none;
                                        }

                                        @media print {
                                            .print-only {
                                                display: block !important;
                                            }
                                        }

                                        .dt-buttons {
                                            display: none !important;
                                        }

                                        .subject-th {
                                            min-width: 140px;
                                        }

                                        .d-none {
                                            display: none !important;
                                        }

                                        .subject-th .d-flex.flex-column {
                                            gap: 6px;
                                        }

                                        .lock-pills {
                                            display: flex;
                                            align-items: center;
                                            gap: 6px;
                                            white-space: nowrap;
                                        }

                                        @media (max-width: 640px) {
                                            .lock-pills {
                                                flex-wrap: wrap;
                                                white-space: normal;
                                            }
                                        }

                                        .lock-pill {
                                            display: inline-flex;
                                            align-items: center;
                                            justify-content: center;
                                            height: 22px;
                                            padding: 0 8px;
                                            border: 1px solid #444;
                                            border-radius: 9999px;
                                            font-size: 11px;
                                            line-height: 1;
                                            margin: 0;
                                        }

                                        .lock-pill.open {
                                            background: #e9f7ef;
                                        }

                                        .lock-pill.locked {
                                            background: #fdecea;
                                        }

                                        .lock-mini {
                                            display: inline-flex !important;
                                            align-items: center;
                                            justify-content: center;
                                            width: 22px;
                                            height: 22px;
                                            padding: 0 !important;
                                            border: 1px solid #bbb;
                                            border-radius: 9999px;
                                            background: #fff;
                                            line-height: 1;
                                            vertical-align: middle;
                                        }

                                        .lock-pills .fa,
                                        .lock-mini .fa {
                                            color: #000 !important;
                                            font-size: 12px;
                                        }

                                        .lock-pill,
                                        .lock-mini,
                                        .lock-mini .fa {
                                            cursor: pointer !important;
                                            user-select: none;
                                        }

                                        .lock-pill:hover {
                                            filter: brightness(0.95);
                                        }

                                        .lock-mini:hover {
                                            box-shadow: 0 0 0 1px rgba(0, 0, 0, .15) inset;
                                        }

                                        .subject-th .lock-pills {
                                            margin-top: 2px;
                                        }
                                    </style>

                                    <div class="mb-3 no-print">
                                        <?= form_open('Masterlist/consol'); ?>
                                        <div class="form-row">

                                            <!-- Grading -->
                                            <div class="form-group col-md-3">
                                                <label>Grading</label>
                                                <select class="form-control" name="grading" required>
                                                    <option value="">Select Grading</option>
                                                    <option value="PGrade" <?= set_select('grading', 'PGrade'); ?>>1st Grading</option>
                                                    <option value="MGrade" <?= set_select('grading', 'MGrade'); ?>>2nd Grading</option>
                                                    <option value="PFinalGrade" <?= set_select('grading', 'PFinalGrade'); ?>>3rd Grading</option>
                                                    <option value="FGrade" <?= set_select('grading', 'FGrade'); ?>>4th Grading</option>
                                                </select>
                                            </div>

                                            <!-- Grade Level -->
                                            <div class="form-group col-md-3">
                                                <label>Grade Level</label>
                                                <select class="form-control" name="grade_level" id="grade_level" required>
                                                    <option value="">Select Grade Level</option>
                                                    <?php if (!empty($grade_level)): foreach ($grade_level as $row): ?>
                                                            <option value="<?= $row->YearLevel; ?>" <?= set_select('grade_level', $row->YearLevel, (isset($gl) && $gl == $row->YearLevel)); ?>>
                                                                <?= $row->YearLevel; ?>
                                                            </option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>

                                            <!-- Section -->
                                            <div class="form-group col-md-3">
                                                <label>Section</label>
                                                <select class="form-control" name="section" id="section" required>
                                                    <option value="">Select Section</option>
                                                    <?php if (!empty($section)): foreach ($section as $row): ?>
                                                            <option value="<?= $row->Section; ?>"
                                                                data-grade_level="<?= $row->YearLevel; ?>"
                                                                <?= set_select('section', $row->Section, (isset($sec) && $sec == $row->Section)); ?>>
                                                                <?= $row->Section; ?>
                                                            </option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>

                                            <!-- Report Version -->
                                            <div class="form-group col-md-2">
                                                <label>Report Version</label>
                                                <select class="form-control" name="version" required>
                                                    <option value="">Select Version</option>
                                                    <option value="1" <?= set_select('version', '1', (isset($ver) && (int)$ver === 1)); ?>>Version 1 - Sort by Sex</option>
                                                    <option value="2" <?= set_select('version', '2', (isset($ver) && (int)$ver === 2)); ?>>Version 2 - Sort by Average</option>
                                                    <option value="3" <?= set_select('version', '3', (isset($ver) && (int)$ver === 3)); ?>>Version 3 - Sort by Lastname</option>
                                                </select>
                                            </div>

                                            <!-- Submit -->
                                            <div class="form-group col-md-1 d-flex align-items-end">
                                                <button type="submit" name="submit" value="Submit" class="btn btn-primary w-100">Submit</button>
                                            </div>
                                        </div>

                                        <!-- SHS Strand -->
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>Strand (SHS)</label>
                                                <select class="form-control" name="strand" id="strand">
                                                    <option value="">Select Strand</option>
                                                    <?php if (!empty($strand_options)): foreach ($strand_options as $s): ?>
                                                            <option value="<?= htmlspecialchars($s->strand, ENT_QUOTES, 'UTF-8'); ?>"
                                                                <?= set_select('strand', $s->strand, (isset($strand) && $strand === $s->strand)); ?>>
                                                                <?= htmlspecialchars($s->strand, ENT_QUOTES, 'UTF-8'); ?>
                                                            </option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <?= form_close(); ?>
                                    </div>
                                    <!-- /Filter Form -->

                                    <?php if ($this->input->post('submit')): ?>
                                        <!-- Letterhead (print only) -->
                                        <?php if (isset($so->letterhead_web) && $so->letterhead_web): ?>
                                            <img class="print-only mb-2" src="<?= base_url('upload/banners/' . $so->letterhead_web); ?>" alt="mySRMS Portal" width="100%">
                                        <?php endif; ?>

                                        <?php
                                        $grade_map = [
                                            'PGrade'      => '1st',
                                            'MGrade'      => '2nd',
                                            'PFinalGrade' => '3rd',
                                            'FGrade'      => '4th'
                                        ];
                                        $grading_code  = $this->input->post('grading');
                                        $grading_label = $grade_map[$grading_code] ?? '';
                                        $is_shs_flag   = !empty($is_shs);

                                        if (!function_exists('norm_sex')) {
                                            function norm_sex($val)
                                            {
                                                $s = ucfirst(strtolower((string)$val));
                                                return ($s === 'Male' || $s === 'Female') ? $s : 'Others';
                                            }
                                        }
                                        $sexStyleMap = [
                                            'Male'   => 'bg-primary text-white',
                                            'Female' => 'bg-danger text-white',
                                            'Others' => 'bg-secondary text-white',
                                        ];

                                        $subjectsCnt  = !empty($sub) ? count($sub) : 0;
                                        // EXACTLY match THEAD: #, Fullname, [subjects...], Average, Equivalent
                                        $colspan      = 2 + $subjectsCnt + 2;

                                        $grouped = ['Male' => [], 'Female' => [], 'Others' => []];
                                        if (!empty($grade)) {
                                            foreach ($grade as $srow) {
                                                $sex = norm_sex($srow->Sex ?? '');
                                                $grouped[$sex][] = $srow;
                                            }
                                        }

                                        function subj_id($code)
                                        {
                                            $c = (string)$code;
                                            $c = preg_replace('/[^A-Za-z0-9_-]/', '_', $c);
                                            return $c ?: 'subj';
                                        }
                                        ?>

                                        <!-- Header Summary -->
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="mb-1">Consolidated Report of Grades (<?= $grading_label; ?> Grading)</h5>
                                                <div style="font-size:14px">
                                                    <?= isset($gl) ? $gl : ''; ?><?= isset($sec) ? ', ' . $sec : ''; ?>
                                                    <?php if ($is_shs_flag && !empty($strand)): ?>
                                                        , <?= htmlspecialchars($strand, ENT_QUOTES, 'UTF-8'); ?>
                                                    <?php endif; ?><br>
                                                    <?= $this->session->userdata('sy'); ?>
                                                </div>
                                            </div>

                                            <!-- Export + Print -->
                                            <div class="d-print-none">
                                                <div class="btn-group" role="group" aria-label="Export">
                                                    <a href="javascript:window.print()" class="btn btn-dark" title="Print">
                                                        <i class="fa fa-print"></i>
                                                    </a>

                                                    <!-- Export dropdown -->
                                                    <div class="btn-group ml-1">
                                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Export">
                                                            <i class="fa fa-download"></i> Export
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" id="btnExportExcel">
                                                                <i class="fa fa-file-excel-o mr-1"></i> Excel
                                                            </a>
                                                            <a class="dropdown-item" href="#" id="btnExportPDF">
                                                                <i class="fa fa-file-pdf-o mr-1"></i> PDF
                                                            </a>
                                                            <a class="dropdown-item" href="#" id="btnExportCSV">
                                                                <i class="fa fa-file-text-o mr-1"></i> CSV
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($is_shs_flag && empty($strand)): ?>
                                            <div class="alert alert-warning">
                                                For <strong>SHS (Grade 11/12)</strong>, please select a <strong>Strand</strong> to generate the report.
                                            </div>
                                        <?php else: ?>

                                            <?php if (empty($sub)): ?>
                                                <div class="alert alert-info">No subjects found for the selected filters.</div>
                                            <?php endif; ?>

                                            <!-- ===== Hidden context for locking AJAX ===== -->
                                            <input type="hidden" id="ctx-Section" value="<?= htmlspecialchars($sec ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" id="ctx-YearLevel" value="<?= htmlspecialchars($gl ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" id="ctx-SY" value="<?= htmlspecialchars($this->session->userdata('sy') ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                                            <div class="table-responsive">
                                                <!-- Visible table (has group divider rows with colspan) -->
                                                <table id="consol-table" class="table table-bordered" style="border-collapse:collapse;border-spacing:0;width:100%;">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fullname</th>

                                                            <?php if (!empty($sub)): foreach ($sub as $r): ?>
                                                                    <?php
                                                                    $code = $r->SubjectCode ?? '';
                                                                    $desc = $sub_desc_map[$code] ?? ($r->Description ?? '');
                                                                    $sid  = subj_id($code);
                                                                    $locks = $locks_map[$code] ?? null;

                                                                    $pre = !empty($locks->lock_prelim);
                                                                    $mid = !empty($locks->lock_midterm);
                                                                    $preF = !empty($locks->lock_prefinal);
                                                                    $fin = !empty($locks->lock_final);
                                                                    ?>
                                                                    <th class="subject-th">
                                                                        <div class="d-flex flex-column">
                                                                            <div class="font-weight-bold" title="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>">
                                                                                <?= htmlspecialchars($desc ?: $code, ENT_QUOTES, 'UTF-8'); ?>
                                                                            </div>
                                                                            <!-- Lock pills (no-print) -->
                                                                            <div class="lock-pills no-print" data-code="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>" data-desc="<?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?>" data-sid="<?= $sid; ?>">
                                                                                <span class="lock-pill <?= $pre ? 'locked' : 'open'; ?>" id="lk-<?= $sid; ?>-prelim" data-period="prelim" data-next="<?= $pre ? 'unlock' : 'lock'; ?>" title="1st Grading: <?= $pre ? 'Locked' : 'Open'; ?>">1st</span>
                                                                                <span class="lock-pill <?= $mid ? 'locked' : 'open'; ?>" id="lk-<?= $sid; ?>-midterm" data-period="midterm" data-next="<?= $mid ? 'unlock' : 'lock'; ?>" title="2nd Grading: <?= $mid ? 'Locked' : 'Open'; ?>">2nd</span>
                                                                                <?php if (!$is_shs_flag): ?>
                                                                                    <span class="lock-pill <?= $preF ? 'locked' : 'open'; ?>" id="lk-<?= $sid; ?>-prefinal" data-period="prefinal" data-next="<?= $preF ? 'unlock' : 'lock'; ?>" title="3rd Grading: <?= $preF ? 'Locked' : 'Open'; ?>">3rd</span>
                                                                                    <span class="lock-pill <?= $fin ? 'locked' : 'open'; ?>" id="lk-<?= $sid; ?>-final" data-period="final" data-next="<?= $fin ? 'unlock' : 'lock'; ?>" title="4th Grading: <?= $fin ? 'Locked' : 'Open'; ?>">4th</span>
                                                                                <?php endif; ?>
                                                                                <a href="#" class="badge badge-outline-danger lock-sub-all lock-mini" data-period="all" data-action="lock" title="Lock ALL periods for this subject"><i class="fa fa-lock"></i></a>
                                                                                <a href="#" class="badge badge-outline-success lock-sub-all lock-mini" data-period="all" data-action="unlock" title="Unlock ALL periods for this subject"><i class="fa fa-unlock"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                            <?php endforeach;
                                                            endif; ?>

                                                            <th>Average</th>
                                                            <th>Equivalent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $count = 1;
                                                        foreach (['Male', 'Female', 'Others'] as $SEX):
                                                            if (empty($grouped[$SEX])) continue; ?>
                                                            <tr class="sex-divider">
                                                                <td colspan="<?= (int)$colspan; ?>" class="text-center font-weight-bold <?= $sexStyleMap[$SEX] ?? 'bg-secondary text-white'; ?>">
                                                                    <?= strtoupper($SEX); ?>
                                                                </td>
                                                            </tr>

                                                            <?php foreach ($grouped[$SEX] as $srow): ?>
                                                                <tr>
                                                                    <td><?= $count++; ?></td>
                                                                    <td style="text-align:left">
                                                                        <?= htmlspecialchars(($srow->LastName ?? '') . ', ' . ($srow->FirstName ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                                                    </td>

                                                                    <?php
                                                                    $sum = 0.0;
                                                                    $cnt = 0;

                                                                    if (!empty($sub)):
                                                                        foreach ($sub as $r):
                                                                            if (!empty($is_shs_flag) && $is_shs_flag && !empty($strand)) {
                                                                                $sg = $this->db->where([
                                                                                    'StudentNumber' => $srow->StudentNumber,
                                                                                    'YearLevel'     => $gl,
                                                                                    'SubjectCode'   => $r->SubjectCode,
                                                                                    'SY'            => $this->session->userdata('sy'),
                                                                                    'strand'        => $strand,
                                                                                ])->get('grades')->row();
                                                                            } else {
                                                                                $sg = $this->Common->three_cond_row(
                                                                                    'grades',
                                                                                    'StudentNumber',
                                                                                    $srow->StudentNumber,
                                                                                    'YearLevel',
                                                                                    $gl,
                                                                                    'SubjectCode',
                                                                                    $r->SubjectCode
                                                                                );
                                                                            }

                                                                            $raw = null;
                                                                            if ($sg && isset($sg->$grading_code) && $sg->$grading_code !== '' && $sg->$grading_code !== null) {
                                                                                $raw = (float) $sg->$grading_code;
                                                                            }

                                                                            if ($raw !== null && $raw > 0) {
                                                                                $sum += $raw;
                                                                                $cnt++;
                                                                            }
                                                                    ?>
                                                                            <td><?= ($raw !== null) ? number_format($raw, 0) : ''; ?></td>
                                                                    <?php endforeach;
                                                                    endif;

                                                                    if ($cnt > 0) {
                                                                        $avgExact = $sum / $cnt;
                                                                        $avg2dp   = number_format($avgExact, 2, '.', '');
                                                                        $avgEq    = (string) round($avgExact, 0, PHP_ROUND_HALF_UP);
                                                                    } else {
                                                                        $avg2dp = '';
                                                                        $avgEq  = '';
                                                                    }
                                                                    ?>
                                                                    <td><?= $avg2dp; ?></td>
                                                                    <td><?= $avgEq;   ?></td>
                                                                </tr>
                                                        <?php endforeach;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>

                                                <!-- Hidden export table will be injected here via JS -->
                                            </div>
                                        <?php endif; // SHS guard 
                                        ?>
                                    <?php else: ?>
                                        <div class="alert alert-info mb-0">
                                            Select <strong>Grading</strong>, <strong>Grade Level</strong>, <strong>Section</strong>, and <strong>Version</strong>
                                            <?= isset($gl) && in_array(strtolower($gl), ['grade 11', 'grade 12']) ? ', plus <strong>Strand</strong>' : ''; ?>
                                            , then click <strong>Submit</strong> to generate the report.
                                        </div>
                                    <?php endif; ?>

                                </div><!-- /card-body -->
                            </div><!-- /card -->
                        </div><!-- /col -->
                    </div><!-- /row -->

                </div><!-- /container-fluid -->

                <!-- Footer -->
                <?php include('includes/footer.php'); ?>
            </div><!-- /content -->
        </div><!-- /content-page -->

        <!-- Right Sidebar -->
        <?php include('includes/themecustomizer.php'); ?>

        <!-- Vendor js -->
        <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

        <!-- Datatables & Buttons -->
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

        <!-- Optional utilities -->
        <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script>
            $(function() {
                // ---------- GradeLevel -> Section filter (existing) ----------
                const gradeLevelSelect = document.getElementById('grade_level');
                const sectionSelect = document.getElementById('section');
                if (gradeLevelSelect && sectionSelect) {
                    const filterSections = () => {
                        const selected = gradeLevelSelect.value;
                        const opts = sectionSelect.options;
                        for (let i = 0; i < opts.length; i++) {
                            const o = opts[i];
                            const gl = o.getAttribute('data-grade_level');
                            if (!gl) continue;
                            o.style.display = (!selected || selected === gl) ? 'block' : 'none';
                        }
                        const sel = sectionSelect.options[sectionSelect.selectedIndex];
                        if (sel && sel.style.display === 'none') sectionSelect.value = '';
                    };
                    gradeLevelSelect.addEventListener('change', filterSections);
                    filterSections();
                }

                // ---------- Helpers ----------
                const glSel = document.getElementById('grade_level');
                const secSel = document.getElementById('section');
                const strSel = document.getElementById('strand');

                function isShs(val) {
                    val = (val || '').toLowerCase().trim();
                    return /(grade\s*11|g11|^11$|grade\s*12|g12|^12$)/.test(val);
                }

                function csrfPayload() {
                    const metaName = document.querySelector('meta[name="csrf-token-name"]');
                    const metaHash = document.querySelector('meta[name="csrf-token-hash"]');
                    if (metaName && metaHash) {
                        const n = metaName.getAttribute('content');
                        const h = metaHash.getAttribute('content');
                        if (n && h) {
                            const p = {};
                            p[n] = h;
                            return p;
                        }
                    }
                    return {};
                }

                function setCsrfFrom(resp) {
                    if (resp && resp.csrf) {
                        const n = Object.keys(resp.csrf)[0];
                        const h = resp.csrf[n];
                        $('meta[name="csrf-token-name"]').attr('content', n);
                        $('meta[name="csrf-token-hash"]').attr('content', h);
                    }
                }

                function toast(msg, type) {
                    if (window.$ && $.NotificationApp && $.NotificationApp.send) {
                        $.NotificationApp.send(type === 'error' ? "Error" : "Success", msg, "top-right", "rgba(0,0,0,0.2)", type === 'error' ? "danger" : "success");
                    } else {
                        alert(msg);
                    }
                }

                // ---------- Show/Hide Strand field for SHS ----------
                function toggleShsFields() {
                    if (!glSel || !strSel) return;
                    const on = isShs(glSel.value);
                    const grp = strSel.closest('.form-group');
                    if (grp) grp.style.display = on ? 'block' : 'none';
                    strSel.required = !!on;
                    if (!on) {
                        strSel.value = '';
                        strSel.innerHTML = '<option value="">Select Strand</option>';
                    }
                }

                // ---------- Strand: AJAX load from semsubjects ----------
                function populateStrands() {
                    if (!glSel || !strSel) return;

                    const glVal = glSel.value || '';
                    if (!isShs(glVal)) { // only for SHS
                        strSel.innerHTML = '<option value="">Select Strand</option>';
                        return;
                    }

                    const payload = Object.assign({
                        yearLevel: glVal,
                        section: secSel ? (secSel.value || '') : ''
                    }, csrfPayload());

                    $.post("<?= base_url('Masterlist/strandsByYearLevel'); ?>", payload)
                        .done(function(resp) {
                            setCsrfFrom(resp);
                            let html = '<option value="">Select Strand</option>';
                            const prev = $(strSel).val() || <?= json_encode($strand ?? ''); ?>;
                            (resp && resp.strands ? resp.strands : []).forEach(function(s) {
                                const esc = $('<div/>').text(s).html();
                                const sel = (prev === s) ? ' selected' : '';
                                html += `<option value="${esc}"${sel}>${esc}</option>`;
                            });
                            strSel.innerHTML = html;
                        })
                        .fail(function() {
                            strSel.innerHTML = '<option value="">Select Strand</option>';
                        });
                }

                // Wire up SHS/strand behavior
                if (glSel) glSel.addEventListener('change', function() {
                    toggleShsFields();
                    populateStrands();
                });
                if (secSel) secSel.addEventListener('change', function() {
                    populateStrands();
                });
                toggleShsFields();
                populateStrands();

                // ---------- Auto-reload helper (debounced) [NEW ADDED] ----------
                let _reloadTimer = null;

                function queuePageReload(delayMs = 0) {
                    if (_reloadTimer) return;
                    if (delayMs <= 0) {
                        // Reload on the next frame so the toast can fire, but no visible delay
                        return requestAnimationFrame(function() {
                            window.location.reload();
                        });
                    }
                    _reloadTimer = setTimeout(function() {
                        window.location.reload();
                    }, delayMs);
                }

                // ---------- Per-subject locking handlers ----------
                function updateSubjectBadges(sid, locks, isShs) {
                    const map = [{
                            id: '#lk-' + sid + '-prelim',
                            val: locks.lock_prelim,
                            title: '1st Grading: '
                        },
                        {
                            id: '#lk-' + sid + '-midterm',
                            val: locks.lock_midterm,
                            title: '2nd Grading: '
                        }
                    ];
                    if (!isShs) {
                        map.push({
                            id: '#lk-' + sid + '-prefinal',
                            val: locks.lock_prefinal,
                            title: '3rd Grading: '
                        }, {
                            id: '#lk-' + sid + '-final',
                            val: locks.lock_final,
                            title: '4th Grading: '
                        });
                    }
                    map.forEach(m => {
                        const $b = $(m.id);
                        if (!$b.length) return;
                        const locked = !!m.val;
                        $b.removeClass('open locked').addClass(locked ? 'locked' : 'open');
                        $b.attr('data-next', locked ? 'unlock' : 'lock');
                        $b.attr('title', m.title + (locked ? 'Locked' : 'Open'));
                    });
                }
                window.updateSubjectBadges = updateSubjectBadges;

                function postToggle(code, desc, period, action, sid) {
                    const payload = Object.assign({
                        SubjectCode: code,
                        Description: desc,
                        Section: $('#ctx-Section').val(),
                        YearLevel: $('#ctx-YearLevel').val(),
                        period: period,
                        action: action
                    }, csrfPayload());

                    return $.post("<?= base_url('Masterlist/toggleLock'); ?>", payload)
                        .done(function(resp) {
                            if (resp && resp.ok && resp.locks) {
                                const isShsCtx = /(grade\s*11|grade\s*12|^11$|^12$)/i.test($('#ctx-YearLevel').val());
                                updateSubjectBadges(sid, resp.locks, isShsCtx);
                                toast((action === 'lock' ? 'Locked ' : 'Unlocked ') + (period === 'all' ? 'ALL periods' : period) + ' for ' + code + '.', 'success');

                                // Auto-reload shortly after successful toggle [NEW ADDED]
                                queuePageReload(0);
                            } else {
                                toast('Failed to toggle lock for ' + code + '.', 'error');
                            }
                        })
                        .fail(function() {
                            toast('Server error while toggling lock for ' + code + '.', 'error');
                        });
                }

                $(document).on('click', '.lock-pill', function() {
                    const $wrap = $(this).closest('.lock-pills');
                    const code = $wrap.data('code');
                    const desc = $wrap.data('desc') || '';
                    const sid = $wrap.data('sid');
                    const period = $(this).data('period');
                    const action = $(this).attr('data-next');
                    postToggle(code, desc, period, action, sid);
                });

                $(document).on('click', '.lock-sub-all', function(e) {
                    e.preventDefault();
                    const $wrap = $(this).closest('.lock-pills');
                    const code = $wrap.data('code');
                    const desc = $wrap.data('desc') || '';
                    const sid = $wrap.data('sid');
                    const period = $(this).data('period');
                    const action = $(this).data('action');
                    postToggle(code, desc, period, action, sid);
                });

                // ---------- Semester badge recompute after lock changes ----------
                var CURRENT_PERIOD = (function() {
                    var g = <?= json_encode($grading_code ?? ''); ?>;
                    if (g === 'PGrade') return 'prelim';
                    if (g === 'MGrade') return 'midterm';
                    if (g === 'PFinalGrade') return 'prefinal';
                    if (g === 'FGrade') return 'final';
                    return null;
                })();

                function recomputeSemesterBadge() {
                    if (!CURRENT_PERIOD) return;
                    var anyLocked = $('.lock-pill[data-period="' + CURRENT_PERIOD + '"]').toArray()
                        .some(function(el) {
                            return el.classList.contains('locked');
                        });

                    var $sem = $('#semester-lock-state');
                    if (!$sem.length) return;
                    $sem.removeClass('badge-success badge-danger')
                        .addClass(anyLocked ? 'badge-danger' : 'badge-success')
                        .attr('title', anyLocked ? 'Some subjects locked for this grading' : 'All subjects open for this grading');
                }

                recomputeSemesterBadge();

                var _updateSubjectBadges = window.updateSubjectBadges;
                window.updateSubjectBadges = function(sid, locks, isShs) {
                    if (typeof _updateSubjectBadges === 'function') {
                        _updateSubjectBadges(sid, locks, isShs);
                    }
                    recomputeSemesterBadge();
                };
            });
        </script>

        <?php if ($this->input->post('submit')): ?>
            <!-- Export-only script (runs only when table exists after submit) -->
            <script>
                $(function() {
                    var exportTitle = <?= json_encode(
                                            'Consolidated Report of Grades (' . ($grading_label ?? '') . ')'
                                                . (isset($gl) && $gl ? ' ' . $gl : '')
                                                . (isset($sec) && $sec ? ', ' . $sec : '')
                                                . ((!empty($is_shs) && !empty($strand)) ? ', ' . $strand : '')
                                                . ' - SY ' . ($this->session->userdata('sy') ?? '')
                                        ); ?>;

                    var exportFilename = <?= json_encode(
                                                'Conso_' . ($grading_label ?? '')
                                                    . '_' . preg_replace('/\s+/', '', ($gl ?? ''))
                                                    . (isset($sec) && $sec ? '_' . preg_replace('/\s+/', '', $sec) : '')
                                                    . ((!empty($is_shs) && !empty($strand)) ? '_' . preg_replace('/\s+/', '', $strand) : '')
                                                    . '_' . ($this->session->userdata('sy') ?? '')
                                            ); ?>;

                    var $src = $('#consol-table');
                    if (!$src.length) return;

                    var $clone = $src.clone();
                    $clone.attr('id', 'consol-table-export').addClass('d-none');

                    $clone.find('tbody tr').filter(function() {
                        var $tds = $(this).children('td');
                        return $(this).hasClass('sex-divider') || ($tds.length === 1 && $tds.attr('colspan'));
                    }).remove();

                    $src.after($clone);

                    if (typeof $.fn.dataTable === 'undefined') {
                        console.error('DataTables core not loaded.');
                        return;
                    }
                    if (typeof $.fn.dataTable.Buttons === 'undefined') {
                        console.error('DataTables Buttons not loaded.');
                        return;
                    }
                    if (typeof JSZip === 'undefined') {
                        console.warn('JSZip not loaded (Excel export will be disabled).');
                    }
                    if (typeof pdfMake === 'undefined') {
                        console.warn('pdfMake not loaded (PDF export will be disabled).');
                    }

                    window.dtExport = $clone.DataTable({
                        paging: false,
                        ordering: false,
                        info: false,
                        searching: false,
                        dom: 'Bfrtip',
                        buttons: (function() {
                            var arr = [];
                            arr.push({
                                extend: 'csvHtml5',
                                title: exportTitle,
                                filename: exportFilename
                            });
                            if (typeof JSZip !== 'undefined') {
                                arr.push({
                                    extend: 'excelHtml5',
                                    title: exportTitle,
                                    filename: exportFilename
                                });
                            }
                            if (typeof pdfMake !== 'undefined') {
                                arr.push({
                                    extend: 'pdfHtml5',
                                    title: exportTitle,
                                    filename: exportFilename,
                                    orientation: 'landscape',
                                    pageSize: 'A4',
                                    customize: function(doc) {
                                        if (doc.styles && doc.styles.tableHeader) {
                                            doc.styles.tableHeader.alignment = 'left';
                                        }
                                        doc.defaultStyle = doc.defaultStyle || {};
                                        doc.defaultStyle.fontSize = 9;
                                    }
                                });
                            }
                            return arr;
                        })()
                    });

                    $('#btnExportExcel').on('click', function(e) {
                        e.preventDefault();
                        var b = dtExport.button('.buttons-excel');
                        if (b.any()) b.trigger();
                        else alert('Excel export unavailable. (JSZip not loaded?)');
                    });
                    $('#btnExportPDF').on('click', function(e) {
                        e.preventDefault();
                        var b = dtExport.button('.buttons-pdf');
                        if (b.any()) b.trigger();
                        else alert('PDF export unavailable. (pdfMake not loaded?)');
                    });
                    $('#btnExportCSV').on - click = null;
                    $('#btnExportCSV').on('click', function(e) {
                        e.preventDefault();
                        var b = dtExport.button('.buttons-csv');
                        if (b.any()) b.trigger();
                        else alert('CSV export unavailable.');
                    });

                    console.log('Export DT ready. thead cols=', $('#consol-table-export thead th').length, 'buttons=', dtExport.buttons().count());
                });
            </script>
        <?php endif; ?>

    </div><!-- /wrapper -->


</body>

</html>