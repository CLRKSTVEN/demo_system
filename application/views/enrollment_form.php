<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<?php
// Safe HTML helper (prevents PHP 8.1 null warnings)
if (!function_exists('h')) {
    function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
}
?>

<body>
<div id="wrapper">
    <?php include('includes/top-nav-bar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <style>
      /* ===== Light Blue Gradient Theme ===== */
      :root{
        --primary-50:#e8f6ff;
        --primary-100:#dff3ff;
        --primary-200:#cfeaff;
        --primary-300:#b9e1ff;
        --primary-400:#93c5fd; /* light blue */
        --primary-500:#60a5fa; /* sky/blue mid */
        --primary-600:#38bdf8; /* accent */
        --shadow-rgb: 56,189,248; /* matches --primary-600 */
      }

      .hero-box {
        background: linear-gradient(135deg, var(--primary-400) 0%, var(--primary-500) 50%, var(--primary-600) 100%);
        color: #09324d;
        border-radius: 18px;
        padding: 24px 28px;
        box-shadow: 0 12px 30px rgba(var(--shadow-rgb), .25);
      }

      .hero-badge {
        background: rgba(255,255,255,.35);
        border: 1px solid rgba(255,255,255,.55);
        backdrop-filter: blur(6px);
        border-radius: 999px;
        padding: 6px 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color:#063049;
      }

      .glass-card {
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 16px !important;
        box-shadow: 0 10px 24px rgba(9, 64, 97, .08);
        overflow: hidden;
        background: #fff;
      }

      .card-head {
        padding: 18px 22px;
        border-bottom: 1px dashed rgba(0,0,0,.08);
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
      }

      .form-label { font-weight: 600; color: #26475e; }

      .form-control, .form-select, select.form-control {
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,.12);
        padding: 10px 12px;
        transition: box-shadow .2s ease, border-color .2s ease, background-color .2s ease;
        background-color: #fff;
      }

      .form-control:focus, .form-select:focus, select.form-control:focus {
        border-color: var(--primary-600);
        box-shadow: 0 0 0 .2rem rgba(var(--shadow-rgb), .20);
      }

      .btn-gradient {
        background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
        border: none; color: #032436; font-weight: 800;
        border-radius: 12px; padding: 10px 18px;
        box-shadow: 0 8px 18px rgba(var(--shadow-rgb), .25);
      }
      .btn-gradient:hover { filter: brightness(1.05); }

      .keyline { border-top: 1px dashed rgba(0,0,0,.1); margin: 16px 0; }
      .mini-help { font-size: .85rem; color: #4a6a80; }

      .icon-chip {
        width: 40px; height: 40px; border-radius: 12px;
        display: inline-flex; align-items: center; justify-content: center;
        background: rgba(var(--shadow-rgb), .12); color: var(--primary-600);
      }

      .alert svg, .alert i { margin-right: 6px; }
    </style>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <?php
                // ===== Prefetch context =====
                $CI = &get_instance();

                $studentNumber = $this->session->userdata('username');
                $currentSY     = $this->session->userdata('sy');

                // Current SY submission in online_enrollment
                if (!isset($online_row)) {
                    $online_row = $CI->db->get_where('online_enrollment', [
                        'StudentNumber' => $studentNumber,
                        'SY'            => $currentSY
                    ])->row();
                }

                // Already enrolled in this SY (semesterstude)
                if (!isset($enroll_row)) {
                    $enroll_row = $CI->db
                        ->where('StudentNumber', $studentNumber)
                        ->where('SY', $currentSY)
                        ->get('semesterstude')
                        ->row();
                    $enrolled = $enroll_row ? true : false;
                }

                // Find most recent past record (not current SY)
                $last_row = $CI->db
                    ->where('StudentNumber', $studentNumber)
                    ->where('SY !=', $currentSY)
                    ->order_by('EnrolledDate', 'DESC')
                    ->order_by('semstudentid', 'DESC')
                    ->limit(1)
                    ->get('semesterstude')
                    ->row();

                // Compute suggested next course/year
                $autoCourse = '';
                $autoYear   = '';
                $autoStrandRequired = false;

                $parseGrade = function($yearLevel) {
                    if (preg_match('/Grade\s*0?(\d+)/i', (string)$yearLevel, $m)) {
                        return (int)$m[1];
                    }
                    return null;
                };

                if ($last_row) {
                    $prevCourse = trim((string)($last_row->Course ?? ''));
                    $prevYear   = trim((string)($last_row->YearLevel ?? ''));
                    $gradeN     = $parseGrade($prevYear);

                    if (!is_null($gradeN)) {
                        if ($gradeN >= 1 && $gradeN <= 5) {
                            $autoCourse = 'Elementary';
                            $autoYear   = 'Grade ' . ($gradeN + 1);
                        } elseif ($gradeN == 6) {
                            $autoCourse = 'Junior High School';
                            $autoYear   = 'Grade 7';
                        } elseif ($gradeN >= 7 && $gradeN <= 9) {
                            $autoCourse = 'Junior High School';
                            $autoYear   = 'Grade ' . ($gradeN + 1);
                        } elseif ($gradeN == 10) {
                            $autoCourse = 'Senior High School';
                            $autoYear   = 'Grade 11';
                            $autoStrandRequired = true;
                        } elseif ($gradeN == 11) {
                            $autoCourse = 'Senior High School';
                            $autoYear   = 'Grade 12';
                            $autoStrandRequired = true;
                        } else {
                            $autoCourse = '';
                            $autoYear   = '';
                        }
                    } else {
                        // College-style progression
                        $normalized = strtolower($prevYear);
                        $map = [
                            'first year'  => ['course' => $prevCourse ?: 'College', 'year' => 'Second Year'],
                            'second year' => ['course' => $prevCourse ?: 'College', 'year' => 'Third Year'],
                            'third year'  => ['course' => $prevCourse ?: 'College', 'year' => 'Fourth Year'],
                            'fourth year' => ['course' => $prevCourse ?: 'College', 'year' => 'Fourth Year'],
                        ];
                        if (isset($map[$normalized])) {
                            $autoCourse = $map[$normalized]['course'];
                            $autoYear   = $map[$normalized]['year'];
                        }
                    }
                }

                // Online enrollment prefill (if present)
                $oeCourse   = $online_row->Course       ?? '';
                $oeYear     = $online_row->YearLevel    ?? '';
                $oeStrand   = $online_row->strand       ?? '';
                $oeStatus   = $online_row->enrolStatus  ?? 'For Validation';
                $hasOnline  = !empty($online_row);
                ?>

                <script>
                    // Pass PHP suggestions/prefill to JS
                    window.__AUTO_PREFILL__ = {
                        course: <?= json_encode($autoCourse) ?>,
                        year:   <?= json_encode($autoYear) ?>,
                        strandRequired: <?= $autoStrandRequired ? 'true' : 'false' ?>
                    };
                    window.__ONLINE_PREFILL__ = {
                        has: <?= $hasOnline ? 'true' : 'false' ?>,
                        course: <?= json_encode($oeCourse) ?>,
                        year: <?= json_encode($oeYear) ?>,
                        strand: <?= json_encode($oeStrand) ?>,
                        status: <?= json_encode($oeStatus) ?>
                    };
                </script>

                <div class="row">
                    <div class="col-md-12">
                        <div class="hero-box mb-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <h3 class="mb-1" style="font-weight:800; letter-spacing:.2px;">
                                        <i class="mdi mdi-school-outline mr-2"></i> Enrollment Form
                                    </h3>
                                    <div class="mini-help">
                                        Please review your program and year level before submitting your enrollment.
                                    </div>
                                </div>
                                <div class="hero-badge">
                                    <i class="mdi mdi-calendar"></i>
                                    <span>SY <?= h($this->session->userdata('sy')) ?> <?= h($this->session->userdata('semester')) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FLASH MESSAGE -->
                <?php if ($this->session->flashdata('msg')): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->session->flashdata('msg'); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card glass-card">

                            <?php if (!empty($enrolled) && $enrolled && !empty($enroll_row)): ?>

                                <!-- (A) Already Enrolled -->
                                <div class="card-head">
                                    <span class="icon-chip"><i class="mdi mdi-check-all"></i></span>
                                    <div>
                                        <div class="h5 mb-0" style="font-weight:800">You are currently enrolled</div>
                                        <div class="mini-help">Here are your enrollment details for this school year.</div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <i class="mdi mdi-check-circle-outline"></i>
                                        <div><b>Enrollment active.</b> You may print related forms below.</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card mb-3" style="border-radius:14px;">
                                                <div class="card-body">
                                                    <h5 class="mb-3"><i class="mdi mdi-clipboard-text-outline mr-1"></i> Enrollment Details</h5>
                                                    <table class="table table-sm table-striped mb-0">
                                                        <tr>
                                                            <th style="width:220px;">Student Number</th>
                                                            <td><?= h($enroll_row->StudentNumber ?? '') ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Course/Department</th>
                                                            <td><?= h($enroll_row->Course ?? '') ?></td>
                                                        </tr>
                                                        <?php if (!empty($enroll_row->strand)): ?>
                                                            <tr>
                                                                <th>Strand (SHS)</th>
                                                                <td><?= h($enroll_row->strand ?? '') ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                        <tr>
                                                            <th>Year Level</th>
                                                            <td><?= h($enroll_row->YearLevel ?? '') ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Section</th>
                                                            <td><?= h($enroll_row->Section ?? '') ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>School Year</th>
                                                            <td><?= h($enroll_row->SY ?? '') ?></td>
                                                        </tr>
                                                    </table>

                                                    <div class="keyline"></div>

                                                    <div class="d-flex flex-wrap gap-2">
                                                        <?php if (isset($schoolType) && $schoolType != 'Public'): ?>
                                                            <a href="<?= base_url(); ?>Page/studentsForm?id=<?= h($enroll_row->semstudentid ?? '') ?>"
                                                               target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="fa fa-file-text"></i> Registration Form
                                                            </a>
                                                            <a href="<?= base_url(); ?>Page/studentsForm1?id=<?= h($enroll_row->semstudentid ?? '') ?>"
                                                               target="_blank" class="btn btn-info btn-sm">
                                                                <i class="fa fa-repeat"></i> Re-Admission Form
                                                            </a>
                                                            <a href="<?= base_url(); ?>Page/studentsForm2?id=<?= h($enroll_row->semstudentid ?? '') ?>"
                                                               target="_blank" class="btn btn-success btn-sm">
                                                                <i class="fa fa-handshake-o"></i> Enrollment / Payment Agreement
                                                            </a>
                                                            <a href="<?= base_url(); ?>Page/studentsForm3?id=<?= h($enroll_row->semstudentid ?? '') ?>"
                                                               target="_blank" class="btn btn-warning btn-sm">
                                                                <i class="fa fa-graduation-cap"></i> Scholarship Agreement
                                                            </a>
                                                            <a href="<?= base_url(); ?>Page/studentsForm4?id=<?= h($enroll_row->semstudentid ?? '') ?>"
                                                               target="_blank" class="btn btn-dark btn-sm">
                                                                <i class="fa fa-id-card"></i> ID Request Form
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php elseif (!empty($online_row)): ?>

                                <!-- (B) Submitted in online_enrollment -->
                                <div class="card-head">
                                    <span class="icon-chip"><i class="mdi mdi-clipboard-check-outline"></i></span>
                                    <div>
                                        <div class="h5 mb-0" style="font-weight:800">Submission received</div>
                                        <div class="mini-help">
                                            Status: <b><?= h($online_row->enrolStatus ?? 'For Validation') ?></b>. You can review or edit your details below.
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="mdi mdi-information-outline"></i>
                                        <div><b>Your enrollment is queued for validation.</b> If you need to change details, click “Edit Submission”.</div>
                                    </div>

                                    <div class="mb-2">
                                        <button class="btn btn-gradient" type="button" id="toggleEditBtn">
                                            <i class="mdi mdi-pencil"></i> Edit Submission
                                        </button>
                                    </div>

                                    <!-- Collapsible edit form -->
                                    <div id="editFormWrap" style="display:none;">
                                        <?php foreach ($data as $student): ?>
                                            <form role="form" method="post" enctype="multipart/form-data" class="px-3 pb-3" autocomplete="off">
                                                <!-- Hidden Inputs -->
                                                <input type="hidden" name="StudentNumber" value="<?= h($this->session->userdata('username')) ?>">
                                                <input type="hidden" name="requirements" value="">
                                                <input type="hidden" name="FName" value="<?= h($student->FirstName ?? '') ?>" readonly>
                                                <input type="hidden" name="MName" value="<?= h($student->MiddleName ?? '') ?>" readonly>
                                                <input type="hidden" name="LName" value="<?= h($student->LastName ?? '') ?>" readonly>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Department <span style="color:red">*</span></label>
                                                            <select name="Course" class="form-control js-course" required>
                                                                <option value="">Select Department</option>
                                                                <?php foreach ($course as $c):
                                                                    $val = $c->CourseDescription ?? '';
                                                                    $shouldSelect = $oeCourse !== '' ? (strcasecmp($oeCourse, $val) === 0)
                                                                                                     : ((isset($autoCourse) && $autoCourse !== '' && strcasecmp($autoCourse, $val) === 0));
                                                                    ?>
                                                                    <option value="<?= h($val) ?>" <?= $shouldSelect ? 'selected' : '' ?>><?= h($val) ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="mini-help mt-1"><i class="mdi mdi-information-outline"></i> Pre-filled from your submitted data.</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Year Level</label>
                                                            <!-- NOT required (user can change/clear) -->
                                                            <select name="YearLevel" class="form-control js-yearlevel">
                                                                <option value="">Select Year Level</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Strand -->
                                                    <div class="col-md-6 js-strand-container" style="display:none;">
                                                        <div class="form-group">
                                                            <label class="form-label">Strand (SHS)</label>
                                                            <select name="strand" class="form-control js-strand">
                                                                <option value="">Select</option>
                                                                <?php foreach ($track as $s): ?>
                                                                    <?php $sval = $s->strand ?? ''; ?>
                                                                    <option value="<?= h($sval) ?>" <?= ($oeStrand !== '' && strcasecmp($oeStrand, $sval) === 0) ? 'selected' : '' ?>>
                                                                        <?= h($sval) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="mini-help mt-1">Visible for Senior High School only.</div>
                                                        </div>
                                                    </div>

                                                    <!-- SY -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">School Year</label>
                                                            <input type="text" class="form-control" name="SY" value="<?= h($this->session->userdata('sy')) ?>" readonly required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" name="enroll" value="submit" class="btn btn-gradient">
                                                        <i class="mdi mdi-content-save"></i> Save Changes
                                                    </button>
                                                    <button type="button" class="btn btn-light ml-2" id="cancelEditBtn">Cancel</button>
                                                </div>
                                            </form>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                            <?php else: ?>

                                <!-- (C) New submission -->
                                <div class="card-head">
                                    <span class="icon-chip"><i class="mdi mdi-form-select"></i></span>
                                    <div>
                                        <div class="h5 mb-0" style="font-weight:800">Process your enrollment</div>
                                        <div class="mini-help">We’ve pre-filled details based on your last record, if available.</div>
                                    </div>
                                </div>

                                <?php foreach ($data as $student): ?>
                                    <form role="form" method="post" enctype="multipart/form-data" class="px-3 pb-3" autocomplete="off">
                                        <!-- Hidden Inputs -->
                                        <input type="hidden" name="StudentNumber" value="<?= h($this->session->userdata('username')) ?>">
                                        <input type="hidden" name="requirements" value="">
                                        <input type="hidden" name="FName" value="<?= h($student->FirstName ?? '') ?>" readonly>
                                        <input type="hidden" name="MName" value="<?= h($student->MiddleName ?? '') ?>" readonly>
                                        <input type="hidden" name="LName" value="<?= h($student->LastName ?? '') ?>" readonly>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Department <span style="color:red">*</span></label>
                                                    <select name="Course" class="form-control js-course" required>
                                                        <option value="">Select Department</option>
                                                        <?php foreach ($course as $c):
                                                            $val = $c->CourseDescription ?? '';
                                                            $selected = (isset($autoCourse) && $autoCourse !== '' && strcasecmp($autoCourse, $val) === 0) ? 'selected' : '';
                                                            ?>
                                                            <option value="<?= h($val) ?>" <?= $selected ?>><?= h($val) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="mini-help mt-1"><i class="mdi mdi-information-outline"></i> Auto-suggested based on your last enrollment.</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Year Level</label>
                                                    <!-- NOT required (user can change/clear) -->
                                                    <select name="YearLevel" class="form-control js-yearlevel">
                                                        <option value="">Select Year Level</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Strand -->
                                            <div class="col-md-6 js-strand-container" style="display:none;">
                                                <div class="form-group">
                                                    <label class="form-label">Strand (SHS)</label>
                                                    <select name="strand" class="form-control js-strand">
                                                        <option value="">Select</option>
                                                        <?php foreach ($track as $s): ?>
                                                            <option value="<?= h($s->strand ?? '') ?>"><?= h($s->strand ?? '') ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="mini-help mt-1">Visible for Senior High School only.</div>
                                                </div>
                                            </div>

                                            <!-- SY -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">School Year</label>
                                                    <input type="text" class="form-control" name="SY" value="<?= h($this->session->userdata('sy')) ?>" readonly required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="enroll" value="submit" class="btn btn-gradient">
                                                <i class="mdi mdi-send mr-1"></i> Process Enrollment
                                            </button>
                                        </div>
                                    </form>
                                <?php endforeach; ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </div>
</div>

<!-- Scripts (vendor) -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>
<script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>
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
<script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

<!-- Prefill + AJAX (numeric year matching for 01..09) -->
<script type="text/javascript">
(function(){
  function norm(s){ return (s||'').toString().toLowerCase().replace(/\s+/g,'').trim(); }
  function firstNumber(s){
      const m=(s||'').toString().match(/(\d+)/);
      return m ? parseInt(m[1],10) : null; // numeric compare ignores leading zeros (7 == 07)
  }
  function textOrVal($opt){ return ($opt.val() || $opt.text()); }

  function selectYearOption($yearSel, target){
      if(!target){ return; }
      const tNum  = firstNumber(target);      // e.g., "Grade 07" -> 7
      const tNorm = norm(target);
      let chosen=null;

      $yearSel.find('option').each(function(){
         const $o=$(this);
         const vText=textOrVal($o);
         const vNum = firstNumber(vText);
         const vNorm=norm(vText);

         // 1) Numeric match (handles 7 vs 07)
         if (tNum!==null && vNum!==null && tNum===vNum){ chosen=$o; return false; }
         // 2) Exact normalized text match
         if (vNorm===tNorm){ chosen=$o; return false; }
         // 3) Fallback: "grade07" contained in option text
         if (tNum!==null && vNorm.indexOf('grade'+('0'+tNum).slice(-2))>=0){ chosen=$o; return false; }
      });

      if (chosen){ $yearSel.val(chosen.val()); }
  }

  // Course change handler per-form (class-based; no duplicate IDs)
  $(document).on('change','.js-course', function(){
     var $form=$(this).closest('form');
     var course=$(this).val();
     var $year=$form.find('.js-yearlevel');
     var $strandWrap=$form.find('.js-strand-container');
     var $strand=$form.find('.js-strand');

     if(course){
        $.post("<?= base_url(); ?>page/fetch_yearlevel", {course:course}, function(html){
            $year.html(html);

            // Prefer existing online submission's year; else auto-suggested next year
            var targetYear = (window.__ONLINE_PREFILL__ && window.__ONLINE_PREFILL__.has && window.__ONLINE_PREFILL__.year)
                               ? window.__ONLINE_PREFILL__.year
                               : (window.__AUTO_PREFILL__ ? window.__AUTO_PREFILL__.year : '');
            selectYearOption($year, targetYear);
        });
     }else{
        $year.html('<option value="">Select Year Level</option>');
     }

     var isSHS = (course||'').toLowerCase()==='senior high school';
     if(isSHS){
        $strandWrap.show();
        if(window.__ONLINE_PREFILL__ && window.__ONLINE_PREFILL__.strand){
          $strand.val(window.__ONLINE_PREFILL__.strand);
        }
     }else{
        $strandWrap.hide();
        $strand.val('');
     }
  });

  // Prefill a specific form with suggested/enrolled data
  function prefillForm($form){
     var pref = (window.__ONLINE_PREFILL__ && window.__ONLINE_PREFILL__.has) ? window.__ONLINE_PREFILL__ : window.__AUTO_PREFILL__;
     if(!pref){ return; }
     var $course=$form.find('.js-course');
     var $strandWrap=$form.find('.js-strand-container');
     var $strand=$form.find('.js-strand');

     if(pref.course){
        var matched=false;
        $course.find('option').each(function(){
           var $o=$(this);
           var v=$o.val(), t=$o.text();
           if (norm(v)===norm(pref.course) || norm(t)===norm(pref.course)){
             $course.val($o.val());
             matched=true;
             return false;
           }
        });
        if(matched){ $course.trigger('change'); } // loads year options then auto-selects suggested year
     }
     if (pref.strandRequired || (pref.course && pref.course.toLowerCase()==='senior high school')){
        $strandWrap.show();
        if(pref.strand){ $strand.val(pref.strand); }
     }
  }

  // Prefill any visible forms now
  $('.glass-card form:visible').each(function(){ prefillForm($(this)); });

  // Edit toggle behavior
  $('#toggleEditBtn').on('click', function(){
     var $wrap = $('#editFormWrap');
     $wrap.slideToggle(160);
     var $form = $wrap.find('form');
     if ($form.length){ prefillForm($form); }
  });

  $('#cancelEditBtn').on('click', function(){
     $('#editFormWrap').slideUp(160);
  });

  // Plain JS safety: show/hide Strand per form on course change (class-based)
  document.addEventListener('change', function(e){
    if (e.target && e.target.classList && e.target.classList.contains('js-course')) {
      var form = e.target.closest('form');
      if(!form) return;
      var strandWrap = form.querySelector('.js-strand-container');
      var strandSel  = form.querySelector('.js-strand');
      if ((e.target.value || '').toLowerCase() === 'senior high school') {
        if (strandWrap) strandWrap.style.display = 'block';
      } else {
        if (strandWrap) strandWrap.style.display = 'none';
        if (strandSel)  strandSel.value = '';
      }
    }
  });
})();
</script>

</body>
</html>
