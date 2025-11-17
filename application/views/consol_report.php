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

                                        $grading_code  = $this->input->post('grading');
                                        $is_all_grading = ($grading_code === 'ALL');
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
                                            case 'ALL':
                                                $period_field = '__ALL__';
                                                break;
                                        }

                                        $anyLockedThisPeriod = false;
                                        if ($period_field && !empty($sub)) {
                                            foreach ($sub as $r) {
                                                $code  = $r->SubjectCode ?? '';
                                                $locks = $locks_map[$code] ?? null;
                                                if (!$locks) {
                                                    continue;
                                                }
                                                if ($period_field === '__ALL__') {
                                                    if (!empty($locks->lock_prelim) || !empty($locks->lock_midterm) || !empty($locks->lock_prefinal) || !empty($locks->lock_final)) {
                                                        $anyLockedThisPeriod = true;
                                                        break;
                                                    }
                                                } elseif (!empty($locks->{$period_field})) {
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
                                        <span id="semester-lock-state" class="badge <?= $semBadgeClass; ?> mb-3 ml-1" title="<?= $anyLockedThisPeriod ? 'Locked grading(s)' : 'Open grading(s)'; ?>">
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

                                    <style>
                                        @page {

                                            size: A4 portrait;
                                            margin: 0.10in;
                                        }

                                        .print-only {
                                            display: none;
                                        }

                                        .dt-buttons {
                                            display: none !important;
                                        }

                                        .d-none {
                                            display: none !important;
                                        }



                                        #consol-table {
                                            position: relative;

                                            border-collapse: collapse;
                                            border-spacing: 0;
                                            width: 100%;
                                        }

                                        #consol-table thead th {
                                            position: sticky;
                                            top: 0;
                                            background: #eef2f7;
                                            z-index: 7;
                                        }

                                        .subject-th {
                                            min-width: 120px;
                                            font-size: 11px;
                                        }

                                        .subject-th .d-flex.flex-column {
                                            gap: 6px;
                                        }

                                        .subject-th .font-weight-bold {
                                            font-size: 11px;
                                        }

                                        .grade-cell {
                                            min-width: 80px;
                                            text-align: center;
                                            font-size: 11px;
                                        }

                                        .col-average,
                                        .col-equivalent {
                                            text-align: center;
                                            min-width: 90px;
                                            font-size: 11px;
                                        }

                                        .sticky-left {
                                            position: sticky;
                                            background: #fff;
                                            z-index: 5;
                                        }

                                        .thead-light .sticky-left {
                                            background: #eef2f7;
                                            z-index: 6;
                                        }

                                        .sticky-left-1 {
                                            left: 0;
                                            min-width: 55px;
                                        }

                                        .sticky-left-2 {
                                            left: 60px;
                                            min-width: 230px;
                                            font-size: 11px;
                                        }

                                        .col-fullname {
                                            min-width: 230px;
                                            font-size: 11px;
                                        }



                                        .grade-chip {
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            border: 1px solid #e9ecef;
                                            border-radius: 4px;
                                            padding: 2px 6px;
                                            font-size: 11px;
                                            line-height: 1.2;
                                            margin-bottom: 2px;
                                            background: #fff;
                                        }

                                        .grade-chip--plain {
                                            border: none;
                                            background: transparent;
                                            padding: 0;
                                            justify-content: center;
                                            font-size: 12px;
                                        }

                                        .grade-chip span {
                                            font-weight: 600;
                                            margin-right: 6px;
                                            text-transform: uppercase;
                                        }

                                        .grade-chip--plain span {
                                            display: none;
                                        }

                                        .grade-chip strong {
                                            font-weight: 600;
                                            display: block;
                                            text-align: center;
                                        }

                                        .grade-chip--plain strong {
                                            font-size: 11px;
                                        }

                                        .lock-pills {
                                            display: flex;
                                            flex-wrap: wrap;
                                            gap: 6px;
                                            white-space: normal;
                                        }

                                        .lock-period {
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 4px;
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
                                            cursor: pointer;
                                            user-select: none;
                                            background: #fff;
                                        }

                                        .lock-pill.open {
                                            background: #e9f7ef;
                                        }

                                        .lock-pill.locked {
                                            background: #fdecea;
                                        }

                                        .lock-icon-btn {
                                            display: inline-flex;
                                            align-items: center;
                                            justify-content: center;
                                            width: 22px;
                                            height: 22px;
                                            border: 1px solid #bbb;
                                            border-radius: 50%;
                                            font-size: 11px;
                                            background: #fff;
                                            cursor: pointer;
                                        }

                                        .lock-icon-btn.lock-btn.active {
                                            background: #fdecea;
                                            border-color: #f5b5b5;
                                        }

                                        .lock-icon-btn.unlock-btn.active {
                                            background: #e9f7ef;
                                            border-color: #9ccfa8;
                                        }

                                        .subject-th .lock-pills {
                                            margin-top: 2px;
                                        }


                                        @media print {


                                            .navbar-custom,
                                            .left-side-menu,
                                            .right-bar,
                                            .right-bar-toggle,
                                            .footer,
                                            .no-print,
                                            .d-print-none {
                                                display: none !important;
                                            }

                                            #wrapper {
                                                padding-top: 0 !important;
                                            }

                                            .content-page {
                                                margin-left: 0 !important;
                                            }

                                            .content-page .content,
                                            .container-fluid,
                                            .card,
                                            .card-body {
                                                margin: 0 !important;
                                                padding: 0 !important;
                                            }

                                            .table-responsive {
                                                overflow: visible !important;
                                                width: 100% !important;
                                            }


                                            #consol-table {
                                                width: 100% !important;
                                                table-layout: auto !important;
                                            }

                                            #consol-table thead th,
                                            .sticky-left {
                                                position: static !important;

                                            }

                                            #consol-table th,
                                            #consol-table td {
                                                font-size: 11px;

                                                padding: 2px 3px;
                                                white-space: normal;
                                            }

                                            html,
                                            body {
                                                width: 100%;
                                                margin: 0;
                                                padding: 0;
                                                zoom: 0.95;

                                                -webkit-print-color-adjust: exact;
                                                font-size: 11px;
                                            }

                                            .print-only {
                                                display: block !important;
                                            }

                                            .print-letterhead {
                                                display: block !important;
                                                margin: 0 auto 8px;
                                                width: 80%;
                                                max-height: 110px;
                                                object-fit: contain;
                                            }



                                            .sticky-left-2,
                                            .col-fullname {
                                                min-width: 160px !important;

                                                font-size: 10.5px !important;
                                            }

                                            .subject-th {
                                                min-width: 70px !important;

                                                font-size: 10.5px !important;
                                            }

                                            .grade-cell {
                                                min-width: 35px !important;

                                                font-size: 10.5px !important;
                                                padding: 1px 2px !important;
                                            }

                                            .col-average,
                                            .col-equivalent {
                                                min-width: 55px !important;
                                                font-size: 10.5px !important;
                                            }
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
                                                    <option value="PGrade" <?= set_select('grading', 'PGrade'); ?>>1st</option>
                                                    <option value="MGrade" <?= set_select('grading', 'MGrade'); ?>>2nd</option>
                                                    <option value="PFinalGrade" <?= set_select('grading', 'PFinalGrade'); ?>>3rd</option>
                                                    <option value="FGrade" <?= set_select('grading', 'FGrade'); ?>>4th</option>
                                                    <option value="ALL" <?= set_select('grading', 'ALL'); ?>>All Grading</option>
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

                                    <?php $visiblePeriodSlugsForJs = []; ?>
                                    <?php if ($this->input->post('submit')): ?>
                                        <!-- Letterhead (print only) -->
                                        <?php if (isset($so->letterhead_web) && $so->letterhead_web): ?>
                                            <img class="print-only print-letterhead mb-2"
                                                src="<?= base_url('upload/banners/' . $so->letterhead_web); ?>"
                                                alt="mySRMS Portal">
                                        <?php endif; ?>


                                        <?php
                                        $grading_meta = [
                                            'PGrade'      => ['label' => '1st', 'slug' => 'prelim', 'lock_field' => 'lock_prelim'],
                                            'MGrade'      => ['label' => '2nd', 'slug' => 'midterm', 'lock_field' => 'lock_midterm'],
                                            'PFinalGrade' => ['label' => '3rd', 'slug' => 'prefinal', 'lock_field' => 'lock_prefinal'],
                                            'FGrade'      => ['label' => '4th', 'slug' => 'final', 'lock_field' => 'lock_final'],
                                        ];
                                        $grade_map = [
                                            'PGrade'      => '1st',
                                            'MGrade'      => '2nd',
                                            'PFinalGrade' => '3rd',
                                            'FGrade'      => '4th',
                                            'ALL'         => 'All',
                                        ];
                                        $grading_code    = $this->input->post('grading');
                                        $is_all_grading  = ($grading_code === 'ALL');
                                        $grading_label   = $grade_map[$grading_code] ?? '';
                                        $is_shs_flag     = !empty($is_shs);
                                        $period_keys_for_level = $is_shs_flag ? ['PGrade', 'MGrade'] : array_keys($grading_meta);
                                        $visible_period_keys = $is_all_grading ? $period_keys_for_level : (in_array($grading_code, $period_keys_for_level, true) ? [$grading_code] : []);
                                        if (empty($visible_period_keys) && !empty($period_keys_for_level)) {
                                            $visible_period_keys = [$period_keys_for_level[0]];
                                        }
                                        $visiblePeriodSlugsForJs = [];
                                        foreach ($visible_period_keys as $key) {
                                            if (isset($grading_meta[$key])) {
                                                $visiblePeriodSlugsForJs[] = $grading_meta[$key]['slug'];
                                            }
                                        }
                                        $visiblePeriodCount = count($visible_period_keys);
                                        $show_chip_labels = $visiblePeriodCount > 1;

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
                                        if (!function_exists('short_subject_label')) {
                                            /**
                                             * Trim long subject names so they don't mess up the column width.
                                             * Applies to both Grade School and High School as per client spec.
                                             */
                                            function short_subject_label($desc)
                                            {
                                                $orig  = (string) $desc;
                                                $lower = strtolower(trim($orig));

                                                // Map of "contains" → short label
                                                $map = [
                                                    'araling panlipunan'                         => 'Aral Pan',
                                                    'edukasyong pantahanan at pangkabuhayan'     => 'E.P.P.',
                                                    'mathematics'                                => 'Math',
                                                    'tech. & livelihood ed'                      => 'T.L.E.',
                                                    'technology and livelihood education'        => 'T.L.E.', // fallback wording
                                                ];

                                                foreach ($map as $needle => $short) {
                                                    if (strpos($lower, $needle) !== false) {
                                                        return $short;
                                                    }
                                                }

                                                // Default: return original if no mapping
                                                return $orig;
                                            }
                                        }

                                        $subjectsCnt  = !empty($sub) ? count($sub) : 0;

                                        $subjectsCnt  = !empty($sub) ? count($sub) : 0;

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
                                                <?php
                                                $grading_text = '';
                                                if (!empty($grading_label)) {
                                                    $grading_text = ($grading_label === 'All') ? 'All Gradings' : ($grading_label . ' Grading');
                                                }
                                                ?>
                                                <h5 class="mb-1">Consolidated Report of Grades<?= $grading_text ? ' (' . $grading_text . ')' : ''; ?></h5>
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
                                                            <th class="sticky-left sticky-left-1">#</th>
                                                            <th class="sticky-left sticky-left-2 col-fullname">Fullname</th>

                                                            <?php if (!empty($sub)): foreach ($sub as $r): ?>
                                                                    <?php
                                                                    $code      = $r->SubjectCode ?? '';
                                                                    $fullDesc  = $sub_desc_map[$code] ?? ($r->Description ?? '');
                                                                    $display   = short_subject_label($fullDesc ?: $code); // << use short label
                                                                    $sid       = subj_id($code);
                                                                    $locks     = $locks_map[$code] ?? (object)[];
                                                                    ?>
                                                                    <th class="subject-th">
                                                                        <div class="d-flex flex-column">
                                                                            <!-- Show short label, keep full description in the tooltip -->
                                                                            <div class="font-weight-bold"
                                                                                title="<?= htmlspecialchars($fullDesc ?: $code, ENT_QUOTES, 'UTF-8'); ?>">
                                                                                <?= htmlspecialchars($display, ENT_QUOTES, 'UTF-8'); ?>
                                                                            </div>
                                                                            <!-- Lock pills (no-print) -->
                                                                            <?php if (!$is_all_grading): ?>
                                                                                <div class="lock-pills no-print"
                                                                                    data-code="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8'); ?>"
                                                                                    data-desc="<?= htmlspecialchars($fullDesc, ENT_QUOTES, 'UTF-8'); ?>"
                                                                                    data-sid="<?= $sid; ?>">
                                                                                    <?php foreach ($visible_period_keys as $period_key):
                                                                                        if (empty($grading_meta[$period_key])) {
                                                                                            continue;
                                                                                        }
                                                                                        $meta       = $grading_meta[$period_key];
                                                                                        $slug       = $meta['slug'];
                                                                                        $lock_field = $meta['lock_field'];
                                                                                        $isLocked   = !empty($locks->{$lock_field});
                                                                                        $wrapId     = 'lk-wrap-' . $sid . '-' . $slug;
                                                                                    ?>
                                                                                        <div class="lock-period" id="<?= $wrapId; ?>">
                                                                                            <span class="lock-pill <?= $isLocked ? 'locked' : 'open'; ?>"
                                                                                                id="lk-<?= $sid; ?>-<?= $slug; ?>"
                                                                                                data-period="<?= $slug; ?>"
                                                                                                data-next="<?= $isLocked ? 'unlock' : 'lock'; ?>"
                                                                                                title="<?= $meta['label']; ?>: <?= $isLocked ? 'Locked' : 'Open'; ?>">
                                                                                                <?= $meta['label']; ?>
                                                                                            </span>
                                                                                            <span class="lock-icon-btn lock-btn <?= $isLocked ? 'active' : ''; ?>"
                                                                                                data-period="<?= $slug; ?>" data-action="lock"
                                                                                                title="Lock <?= $meta['label']; ?> grading">
                                                                                                <i class="fa fa-lock"></i>
                                                                                            </span>
                                                                                            <span class="lock-icon-btn unlock-btn <?= $isLocked ? '' : 'active'; ?>"
                                                                                                data-period="<?= $slug; ?>" data-action="unlock"
                                                                                                title="Unlock <?= $meta['label']; ?> grading">
                                                                                                <i class="fa fa-unlock"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    <?php endforeach; ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </th>
                                                            <?php endforeach;
                                                            endif; ?>


                                                            <th class="col-average">Average</th>
                                                            <th class="col-equivalent">Equivalent</th>
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
                                                                    <td class="sticky-left sticky-left-1"><?= $count++; ?></td>
                                                                    <td class="sticky-left sticky-left-2 col-fullname" style="text-align:left">
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
                                                                                $sg = $this->db->where([
                                                                                    'StudentNumber' => $srow->StudentNumber,
                                                                                    'YearLevel'     => $gl,
                                                                                    'SubjectCode'   => $r->SubjectCode,
                                                                                    'SY'            => $this->session->userdata('sy'),
                                                                                    'Section'       => $sec, // optional, but safer
                                                                                ])->get('grades')->row();
                                                                            }

                                                                            $gradeChips = [];
                                                                            $chipSum = 0.0;
                                                                            $chipCount = 0;
                                                                            if ($sg && !empty($visible_period_keys)) {
                                                                                foreach ($visible_period_keys as $period_key) {
                                                                                    if (empty($grading_meta[$period_key])) {
                                                                                        continue;
                                                                                    }
                                                                                    $fieldName = $period_key;
                                                                                    $val = $sg->$fieldName ?? null;
                                                                                    if ($val === '' || $val === null) {
                                                                                        continue;
                                                                                    }
                                                                                    $numVal = (float) $val;
                                                                                    $gradeChips[] = [
                                                                                        'label' => $grading_meta[$period_key]['label'],
                                                                                        'value' => $numVal,
                                                                                    ];
                                                                                    if ($numVal > 0) {
                                                                                        $chipSum += $numVal;
                                                                                        $chipCount++;
                                                                                    }
                                                                                }
                                                                            }

                                                                            $raw = null;
                                                                            if ($chipCount > 0) {
                                                                                if ($is_all_grading) {
                                                                                    if ($sg && isset($sg->FGrade) && $sg->FGrade !== '' && $sg->FGrade !== null) {
                                                                                        $raw = (float) $sg->FGrade;
                                                                                    } else {
                                                                                        $raw = $chipSum / $chipCount;
                                                                                    }
                                                                                } else {
                                                                                    $raw = $chipSum / $chipCount;
                                                                                }
                                                                            }

                                                                            if ($raw !== null && $raw > 0) {
                                                                                $sum += $raw;
                                                                                $cnt++;
                                                                            }
                                                                    ?>
                                                                            <td class="grade-cell">
                                                                                <?php if (!empty($gradeChips)): ?>
                                                                                    <?php foreach ($gradeChips as $chip): ?>
                                                                                        <div class="grade-chip<?= $show_chip_labels ? '' : ' grade-chip--plain'; ?>">
                                                                                            <?php if ($show_chip_labels): ?>
                                                                                                <span><?= $chip['label']; ?></span>
                                                                                            <?php endif; ?>
                                                                                            <strong><?= number_format($chip['value'], 0); ?></strong>
                                                                                        </div>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            </td>
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
                                                                    <td class="col-average"><?= $avg2dp; ?></td>
                                                                    <td class="col-equivalent"><?= $avgEq;   ?></td>
                                                                </tr>
                                                        <?php endforeach;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>

                                                <!-- Hidden export table will be injected here via JS -->
                                            </div>
                                        <?php endif;
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


                function populateStrands() {
                    if (!glSel || !strSel) return;

                    const glVal = glSel.value || '';
                    if (!isShs(glVal)) {
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


                if (glSel) glSel.addEventListener('change', function() {
                    toggleShsFields();
                    populateStrands();
                });
                if (secSel) secSel.addEventListener('change', function() {
                    populateStrands();
                });
                toggleShsFields();
                populateStrands();


                let _reloadTimer = null;

                function queuePageReload(delayMs = 0) {
                    if (_reloadTimer) return;
                    if (delayMs <= 0) {

                        return requestAnimationFrame(function() {
                            window.location.reload();
                        });
                    }
                    _reloadTimer = setTimeout(function() {
                        window.location.reload();
                    }, delayMs);
                }


                function updateSubjectBadges(sid, locks, isShs) {
                    const map = [{
                            id: '#lk-' + sid + '-prelim',
                            val: locks.lock_prelim,
                            title: '1st Grading: ',
                            slug: 'prelim'
                        },
                        {
                            id: '#lk-' + sid + '-midterm',
                            val: locks.lock_midterm,
                            title: '2nd Grading: ',
                            slug: 'midterm'
                        }
                    ];
                    if (!isShs) {
                        map.push({
                            id: '#lk-' + sid + '-prefinal',
                            val: locks.lock_prefinal,
                            title: '3rd Grading: ',
                            slug: 'prefinal'
                        }, {
                            id: '#lk-' + sid + '-final',
                            val: locks.lock_final,
                            title: '4th Grading: ',
                            slug: 'final'
                        });
                    }
                    map.forEach(m => {
                        const $b = $(m.id);
                        if (!$b.length) return;
                        const locked = !!m.val;
                        $b.removeClass('open locked').addClass(locked ? 'locked' : 'open');
                        $b.attr('data-next', locked ? 'unlock' : 'lock');
                        $b.attr('title', m.title + (locked ? 'Locked' : 'Open'));

                        const $wrap = $('#lk-wrap-' + sid + '-' + m.slug);
                        if ($wrap.length) {
                            $wrap.find('.lock-icon-btn.lock-btn').toggleClass('active', locked);
                            $wrap.find('.lock-icon-btn.unlock-btn').toggleClass('active', !locked);
                        }
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

                $(document).on('click', '.lock-icon-btn', function(e) {
                    e.preventDefault();
                    const $wrap = $(this).closest('.lock-pills');
                    const code = $wrap.data('code');
                    const desc = $wrap.data('desc') || '';
                    const sid = $wrap.data('sid');
                    const period = $(this).data('period');
                    const action = $(this).data('action');
                    postToggle(code, desc, period, action, sid);
                });


                var CURRENT_PERIODS = <?= json_encode($visiblePeriodSlugsForJs); ?> || [];

                function recomputeSemesterBadge() {
                    if (!CURRENT_PERIODS.length) return;
                    var anyLocked = CURRENT_PERIODS.some(function(periodSlug) {
                        return $('.lock-pill[data-period="' + periodSlug + '"]').toArray()
                            .some(function(el) {
                                return el.classList.contains('locked');
                            });
                    });

                    var $sem = $('#semester-lock-state');
                    if (!$sem.length) return;
                    $sem.removeClass('badge-success badge-danger')
                        .addClass(anyLocked ? 'badge-danger' : 'badge-success')
                        .attr('title', anyLocked ? 'Locked grading(s)' : 'Open grading(s)');
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
                    $clone.attr('id', 'consol-table-export').removeClass('table-bordered').addClass('d-none');
                    // Simplify subject headers for export: use only the short label text
                    $clone.find('thead th.subject-th').each(function() {
                        var $th = $(this);
                        // Get the inner short label (what you already show on screen)
                        var label = $.trim($th.find('.font-weight-bold').text());
                        if (!label) {
                            label = $.trim($th.text());
                        }
                        // Replace header content with plain text label for clean export
                        $th.text(label);
                    });

                    $clone.find('tbody tr').filter(function() {
                        var $tds = $(this).children('td');
                        return $(this).hasClass('sex-divider') ||
                            ($tds.length === 1 && $tds.attr('colspan'));
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
                                    orientation: 'portrait',
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


                    $('#btnExportExcel').off('click').on('click', function(e) {
                        e.preventDefault();
                        if (!window.dtExport) return;
                        var b = dtExport.button('.buttons-excel');
                        if (b.any()) b.trigger();
                        else alert('Excel export unavailable. (JSZip not loaded?)');
                    });

                    $('#btnExportPDF').off('click').on('click', function(e) {
                        e.preventDefault();
                        if (!window.dtExport) return;
                        var b = dtExport.button('.buttons-pdf');
                        if (b.any()) b.trigger();
                        else alert('PDF export unavailable. (pdfMake not loaded?)');
                    });

                    $('#btnExportCSV').off('click').on('click', function(e) {
                        e.preventDefault();
                        if (!window.dtExport) return;
                        var b = dtExport.button('.buttons-csv');
                        if (b.any()) b.trigger();
                        else alert('CSV export unavailable.');
                    });

                    console.log(
                        'Export DT ready. thead cols=',
                        $('#consol-table-export thead th').length,
                        'buttons=',
                        dtExport.buttons().count()
                    );
                });
            </script>
        <?php endif; ?>

    </div><!-- /wrapper -->


</body>

</html>