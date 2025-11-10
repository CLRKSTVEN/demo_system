<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

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
                                    <span class="badge badge-purple mb-3">
                                        SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?>
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
</style>

<div class="mb-3 no-print">
    <?= form_open('Masterlist/consol'); ?>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Grading</label>
            <select class="form-control" name="grading" required>
                <option value="">Select Grading</option>
                <option value="PGrade"      <?= set_select('grading', 'PGrade'); ?>>1st Grading</option>
                <option value="MGrade"      <?= set_select('grading', 'MGrade'); ?>>2nd Grading</option>
                <option value="PFinalGrade" <?= set_select('grading', 'PFinalGrade'); ?>>3rd Grading</option>
                <option value="FGrade"      <?= set_select('grading', 'FGrade'); ?>>4th Grading</option>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label>Grade Level</label>
            <select class="form-control" name="grade_level" id="grade_level" required>
                <option value="">Select Grade Level</option>
                <?php if (!empty($grade_level)): foreach ($grade_level as $row): ?>
                    <option value="<?= $row->YearLevel; ?>" <?= set_select('grade_level', $row->YearLevel, (isset($gl) && $gl == $row->YearLevel)); ?>>
                        <?= $row->YearLevel; ?>
                    </option>
                <?php endforeach; endif; ?>
            </select>
        </div>

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
                <?php endforeach; endif; ?>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label>Report Version</label>
            <select class="form-control" name="version" required>
                <option value="">Select Version</option>
                <option value="1" <?= set_select('version', '1', (isset($ver) && (int)$ver === 1)); ?>>Version 1 - Sort by Sex</option>
                <option value="2" <?= set_select('version', '2', (isset($ver) && (int)$ver === 2)); ?>>Version 2 - Sort by Average</option>
                <option value="3" <?= set_select('version', '3', (isset($ver) && (int)$ver === 3)); ?>>Version 3 - Sort by Lastname</option>
            </select>
        </div>

        <div class="form-group col-md-1 d-flex align-items-end">
            <button type="submit" name="submit" value="Submit" class="btn btn-primary w-100">Submit</button>
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
                                    ?>

                                    <!-- Header Summary -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="mb-1">Consolidated Report of Grades (<?= $grading_label; ?> Grading)</h5>
                                            <div style="font-size:14px">
                                                <?= isset($gl) ? $gl : ''; ?><?= isset($sec) ? ', ' . $sec : ''; ?><br>
                                                <?= $this->session->userdata('sy'); ?>
                                            </div>
                                        </div>
                                        <div class="d-print-none">
                                            <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </div>
                                    </div>

                                 <!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Fullname</th>
                <?php if (!empty($ver) && (int)$ver === 1): ?>
                    <th>Sex</th>
                <?php endif; ?>

                <?php if (!empty($sub)): foreach ($sub as $r): ?>
                    <th><?= htmlspecialchars((string)$r->Description); ?></th>
                <?php endforeach; endif; ?>

                <th>Average</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if (!empty($grade)):
                foreach ($grade as $srow):
            ?>
            <tr>
                <td><?= $count++; ?></td>
                <td style="text-align:left">
                    <?= ($srow->LastName ?? '') . ', ' . ($srow->FirstName ?? ''); ?>
                </td>

                <?php if (!empty($ver) && (int)$ver === 1): ?>
                    <td><?= $srow->Sex ?? ''; ?></td>
                <?php endif; ?>

                <?php if (!empty($sub)): foreach ($sub as $r):
                    $sg = $this->Common->three_cond_row(
                        'grades',
                        'StudentNumber', $srow->StudentNumber,
                        'YearLevel',     $gl,
                        'SubjectCode',   $r->SubjectCode
                    );
                    $gval = ($sg && isset($sg->$grading_code)) ? $sg->$grading_code : '';
                ?>
                    <td>
                        <?= ($gval !== null && $gval !== '') ? number_format((float)$gval, 0) : ''; ?>
                    </td>
                <?php endforeach; endif; ?>

                <td>
                    <?= isset($srow->Average) && $srow->Average !== '' ? number_format((float)$srow->Average, 0) : ''; ?>
                </td>
            </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
</div>


                                <?php else: ?>
                                    <div class="alert alert-info mb-0">
                                        Select **Grading**, **Grade Level**, **Section**, and **Version**, then click <strong>Submit</strong> to generate the report.
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

    <!-- Datatables init -->


    <script>
(function(){
  // Map from controller: { "Grade 7": ["A","B"], "Grade 8": ["C"] }
  const OWNED = <?= $owned_map_json ?? '{}' ?>;

  const glSel  = document.getElementById('grade_level');
  const secSel = document.getElementById('section');

  // Previously submitted (to retain after submit)
  const prevGL  = <?= json_encode($gl ?? '') ?>;
  const prevSec = <?= json_encode($sec ?? '') ?>;

  // Build Grade Level options
  const gls = Object.keys(OWNED);
  glSel.innerHTML = '<option value="">Select Grade Level</option>' +
    gls.map(yl => `<option value="${yl}">${yl}</option>`).join('');

  // Preselect GL if previously chosen & still owned
  if (prevGL && OWNED[prevGL]) glSel.value = prevGL;

  // Build Section options for a given GL
  function buildSections(yl) {
    const list = OWNED[yl] || [];
    secSel.innerHTML = '<option value="">Select Section</option>' +
      list.map(s => `<option value="${s}">${s}</option>`).join('');
    if (yl === prevGL && list.includes(prevSec)) secSel.value = prevSec;
  }

  // Initial sections
  buildSections(glSel.value);

  // On GL change → rebuild sections
  glSel.addEventListener('change', () => buildSections(glSel.value));
})();
</script>

    <script>
        $(function () {
            if ($('#datatable').length) {
                $('#datatable').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                    responsive: true,
                    pageLength: 50
                });
            }

            // GradeLevel -> Section dynamic filter
            const gradeLevelSelect = document.getElementById('grade_level');
            const sectionSelect    = document.getElementById('section');
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
                filterSections(); // run on load to honor retained values
            }
        });
    </script>

    <style>
        .print-only { display: none; }
        @media print { .print-only { display: block !important; } }
    </style>

</div><!-- /wrapper -->
</body>
</html>
