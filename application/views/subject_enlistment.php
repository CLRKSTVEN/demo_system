<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<?php
// ---------- Null-safe escaper ----------
if (!function_exists('e')) {
    function e($v) { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
}
?>

<body>

    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

<?php
$sy = $this->session->userdata('sy');
$sn = $this->input->post('StudentNumber', true);
if (!$sn) { $sn = $this->input->get('StudentNumber', true); }

$stud = null;
$st   = null;
$sub  = [];
$conds = [];
$strandValue = null;
$isSHS = false;

if (!$sy || !$sn) {
    echo '<div class="alert alert-danger">Missing required data (SY or StudentNumber). Please go back and try again.</div>';
} else {
    $stud = $this->Common->one_cond_row('studeprofile','StudentNumber',$sn);
    $st   = $this->Common->two_cond_row('semesterstude','StudentNumber',$sn,'SY',$sy);

    if ($st) {
        // SHS strand source could be Qualification or Track
        if (!empty($st->Qualification))      $strandValue = trim($st->Qualification);
        elseif (!empty($st->Track))          $strandValue = trim($st->Track);

        $isSHS = (strcasecmp($st->Course ?? '', 'Senior High School') === 0);

        // Build filters to show "regular" subjects
        $conds = [
            'YearLevel' => $st->YearLevel,
            'SY'        => $sy
        ];
        if (!empty($st->Section)) $conds['Section'] = trim($st->Section);
        if ($isSHS && !empty($strandValue)) $conds['strand'] = $strandValue;

        // Fetch displayed subjects
        if (isset($conds['Section']) && isset($conds['strand'])) {
            $sub = $this->Common->four_cond('semsubjects','YearLevel',$conds['YearLevel'],'Section',$conds['Section'],'SY',$conds['SY'],'strand',$conds['strand']);
        } elseif (isset($conds['Section'])) {
            $sub = $this->Common->three_cond('semsubjects','YearLevel',$conds['YearLevel'],'Section',$conds['Section'],'SY',$conds['SY']);
        } elseif (isset($conds['strand'])) {
            $sub = $this->Common->three_cond('semsubjects','YearLevel',$conds['YearLevel'],'SY',$conds['SY'],'strand',$conds['strand']);
        } else {
            $sub = $this->Common->two_cond('semsubjects','YearLevel',$conds['YearLevel'],'SY',$conds['SY']);
        }

        if (!$sub) {
            echo '<div class="alert alert-info">No subjects matched for YearLevel '.e($st->YearLevel).' / Section '.e($st->Section).' / SY '.e($sy).($strandValue ? ' / Strand '.e($strandValue) : '').'.</div>';
        }
    } else {
        echo '<div class="alert alert-warning">No active semester record found for this student in SY '.e($sy).'.</div>';
    }
}

/* ------- Build Irregular pool (availableIrreg) ------- */
/* Already-listed subject codes (to exclude in modal) */
$existingCodes = [];
if (!empty($sub)) {
    foreach ($sub as $r) {
        if (!empty($r->SubjectCode)) $existingCodes[] = trim($r->SubjectCode);
    }
}

/* Pull ALL semsubjects for the current SY (no limits on YearLevel/Section/strand) */
$pool = [];
if (!empty($sy)) {
    if (method_exists($this->Common, 'one_cond')) {
        // prefer your common helper if available
        $pool = $this->Common->one_cond('semsubjects','SY',$sy);
    } else {
        // fallback using CI query builder (works inside a view, too)
        $CI = isset($this) ? $this : get_instance();
        $pool = $CI->db->where('SY', $sy)->get('semsubjects')->result();
    }
} else {
    // if SY is missing, show absolutely everything (ultimate no-limit)
    if (method_exists($this->Common, 'all')) {
        $pool = $this->Common->all('semsubjects');
    } else {
        $CI = isset($this) ? $this : get_instance();
        $pool = $CI->db->get('semsubjects')->result();
    }
}

/* Deduplicate by SubjectCode+Section+Semester to avoid identical dup rows from DB */
$_seen = [];
$availableIrreg = [];
if (!empty($pool)) {
    foreach ($pool as $rr) {
        $code = trim($rr->SubjectCode ?? '');
        if ($code === '' || in_array($code, $existingCodes, true)) continue;

        $semCol = isset($rr->Sem) ? $rr->Sem : (isset($rr->Semester) ? $rr->Semester : '');
        $key = $code.'|'.trim($rr->Section ?? '').'|'.trim($semCol ?? '');
        if (isset($_seen[$key])) continue;
        $_seen[$key] = true;

        $availableIrreg[] = $rr;
    }
}

$existingCodesJson = json_encode($existingCodes ?? []);

?>

<?php $att = array('class' => 'parsley-examples'); ?>
<?= form_open('Ren/subject_lists', $att); ?>

<?php if (!empty($sub)) : ?>
    <?php foreach($sub as $row):
        $staff = $this->Common->one_cond_row('staff','IDNumber',$row->IDNumber);
        $semCol = isset($row->Sem) ? $row->Sem : (isset($row->Semester) ? $row->Semester : '');
    ?>
        <input type="hidden" name="StudentNumber[]" value="<?= e($sn); ?>">
        <input type="hidden" name="SubjectCode[]"  value="<?= e($row->SubjectCode ?? ''); ?>">
        <input type="hidden" name="Description[]"  value="<?= e($row->Description ?? ''); ?>">
        <input type="hidden" name="Section[]"      value="<?= e($row->Section ?? ''); ?>">
        <input type="hidden" name="SchedTime[]"    value="<?= e($row->SchedTime ?? ''); ?>">
        <input type="hidden" name="Room[]"         value="<?= e($row->Room ?? ''); ?>">
        <input type="hidden" name="Instructor[]"   value="<?= e($staff ? ($staff->FirstName.' '.$staff->LastName) : ''); ?>">
        <input type="hidden" name="SY[]"           value="<?= e($sy); ?>">
        <input type="hidden" name="Course[]"       value="<?= e($row->Course ?? ''); ?>">
        <input type="hidden" name="YearLevel[]"    value="<?= e($row->YearLevel ?? ''); ?>">
        <input type="hidden" name="Sem[]"          value="<?= e($semCol); ?>">
        <input type="hidden" name="strand[]"       value="<?= e($strandValue ?? ''); ?>">
        <input type="hidden" name="IDNumber[]"     value="<?= e($row->IDNumber ?? ''); ?>">
    <?php endforeach; ?>
<?php endif; ?>

<!-- Page header: Submit + Add Irregular -->
<div class="row">
    <div class="col-md-12">
        <div class="page-title-box">
            <h4 class="page-title d-flex align-items-center">
                <input class="btn btn-info waves-effect waves-light mr-2" type="submit" value="Submit">
                <button type="button" id="btnAddIrreg" class="btn btn-outline-primary waves-effect" data-toggle="modal" data-target="#irregModal">
                    <i class="ion ion-ios-add-circle-outline mr-1"></i> Add Subject (Irregular)
                </button>
            </h4>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<!-- dynamic hidden inputs from modal go here -->
<div id="dynamicHiddenInputs"></div>

</form>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-responsive">

                <h4 class="m-t-0 header-title mb-4">
                    <?php
                        $studName = $stud ? trim(($stud->FirstName ?? '').' '.($stud->MiddleName ?? '').' '.($stud->LastName ?? '')) : 'Unknown Student';
                    ?>
                    <?= e($studName); ?> - <?= e($sn); ?>
                </h4>

                <?php echo $this->session->flashdata('msg'); ?>

                <table class="table mb-0" id="subjectMainTable">
                    <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Description</th>
                        <th>Class Schedules</th>
                        <th>Room</th>
                        <th>Section</th>
                        <?php if ($isSHS) { ?><th>Semester</th><?php } ?>
                        <th>Teacher</th>
                        <th style="width:90px;">Origin</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($sub)) : ?>
                        <?php foreach($sub as $row):
                            $staff = $this->Common->one_cond_row('staff','IDNumber',$row->IDNumber);
                            $semCol = isset($row->Sem) ? $row->Sem : (isset($row->Semester) ? $row->Semester : '');
                        ?>
                            <tr>
                                <td><?= e($row->SubjectCode ?? ''); ?></td>
                                <td><?= e($row->Description ?? ''); ?></td>
                                <td><?= e($row->SchedTime ?? ''); ?></td>
                                <td><?= e($row->Room ?? ''); ?></td>
                                <td><?= e($row->Section ?? ''); ?></td>
                                <?php if ($isSHS) { ?><td><?= e($semCol); ?></td><?php } ?>
                                <td><?= e($staff ? ($staff->FirstName.' '.$staff->LastName) : ''); ?></td>
                                <td><span class="badge badge-secondary">listed</span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

                </div>
            </div>

            <!-- Irregular Subject Picker Modal -->
            <div class="modal fade" id="irregModal" tabindex="-1" role="dialog" aria-labelledby="irregModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="irregModalLabel">Add Subject for Irregular Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                    <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered w-100" id="irregTable">
  <thead>
    <tr class="modalFont">
      <th style="width:40px;"><input type="checkbox" id="irregCheckAll"></th>
      <th>Subject Code</th>
      <th>Description</th>
      <th>Schedule</th>
      <th>Room</th>
      <th>Section</th>
      <th>YearLevel</th>
      <th>Course</th>
      <th>Strand</th>
      <th>Semester</th>
      <th>Teacher</th>
    </tr >
  </thead>
  <tbody>
    <?php if (!empty($availableIrreg)) : ?>
      <?php foreach ($availableIrreg as $row):
            $staffRow = $this->Common->one_cond_row('staff','IDNumber',$row->IDNumber);
            $semCol   = isset($row->Sem) ? $row->Sem : (isset($row->Semester) ? $row->Semester : '');
            $teacher  = $staffRow ? ($staffRow->FirstName.' '.$staffRow->LastName) : '';
      ?>
      <tr class="modalFont"
        data-code="<?= e($row->SubjectCode ?? ''); ?>"
        data-desc="<?= e($row->Description ?? ''); ?>"
        data-sched="<?= e($row->SchedTime ?? ''); ?>"
        data-room="<?= e($row->Room ?? ''); ?>"
        data-section="<?= e($row->Section ?? ''); ?>"
        data-sem="<?= e($semCol); ?>"
        data-teacher="<?= e($teacher); ?>"
        data-idnumber="<?= e($row->IDNumber ?? ''); ?>"
        data-course="<?= e($row->Course ?? ''); ?>"
        data-yl="<?= e($row->YearLevel ?? ''); ?>"
        data-strand="<?= e($row->strand ?? ''); ?>"
      >
        <td><input type="checkbox" class="irreg-cb"></td>
        <td><?= e($row->SubjectCode ?? ''); ?></td>
        <td><?= e($row->Description ?? ''); ?></td>
        <td><?= e($row->SchedTime ?? ''); ?></td>
        <td><?= e($row->Room ?? ''); ?></td>
        <td><?= e($row->Section ?? ''); ?></td>
        <td><?= e($row->YearLevel ?? ''); ?></td>
        <td><?= e($row->Course ?? ''); ?></td>
        <td><?= e($row->strand ?? ''); ?></td>
        <td><?= e($semCol); ?></td>
        <td><?= e($teacher); ?></td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="11" class="text-center text-muted">No subjects found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" id="btnAddSelectedIrreg" class="btn btn-primary">
                      <i class="ion ion-md-add mr-1"></i> Add Selected
                    </button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <!-- Datatable libs (optional) -->
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

    <!-- Parsley -->
    <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>

    <!-- If you use your page inits -->
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-advanced.init.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>

    <style>
        #subjectMainTable td, #subjectMainTable th { vertical-align: middle; }
        .modal .dataTables_wrapper .row { margin: 0; }

        .modalFont {
            font-size: 12px;
        }
    </style>

    <script>
    (function() {
        // Existing codes (prevent duplicates)
        const existingCodes = new Set(<?= $existingCodesJson ?: '[]' ?>);

        // Init modal table (optional)
        if ($('#irregTable').length && $.fn.DataTable) {
            $('#irregTable').DataTable({
                pageLength: 10,
                order: [[1,'asc']],
                responsive: true
            });
        }

        // Check-all
        $('#irregCheckAll').on('change', function(){
            const checked = this.checked;
            $('#irregTable').find('tbody .irreg-cb').prop('checked', checked);
        });

        // Add selected irregulars
        $('#btnAddSelectedIrreg').on('click', function(){
            const $rows = $('#irregTable tbody tr');
            let addedCount = 0;

            $rows.each(function(){
                const $tr = $(this);
                const cb  = $tr.find('.irreg-cb').get(0);
                if (!cb || !cb.checked) return;

                const code = ($tr.data('code') || '').toString();
                if (!code || existingCodes.has(code)) {
                    $tr.remove();
                    return;
                }

                const desc     = $tr.data('desc')     || '';
                const sched    = $tr.data('sched')    || '';
                const room     = $tr.data('room')     || '';
                const section  = $tr.data('section')  || '';
                const sem      = $tr.data('sem')      || '';
                const teacher  = $tr.data('teacher')  || '';
                const idnumber = $tr.data('idnumber') || '';
                const course   = $tr.data('course')   || '';
                const yl       = $tr.data('yl')       || '';

                const hasSHS = <?= $isSHS ? 'true' : 'false'; ?>;
                const semCell = hasSHS ? `<td>${sem}</td>` : '';

                // Visible row
                $('#subjectMainTable tbody').append(
                    `<tr class="added-irreg">
                        <td>${code}</td>
                        <td>${desc}</td>
                        <td>${sched}</td>
                        <td>${room}</td>
                        <td>${section}</td>
                        ${semCell}
                        <td>${teacher}</td>
                        <td><span class="badge badge-info">added</span></td>
                    </tr>`
                );

                // Hidden inputs for POST arrays
             const hid = [
  {name: 'StudentNumber[]', val: <?= json_encode($sn ?? ''); ?>},
  {name: 'SubjectCode[]',  val: code},
  {name: 'Description[]',  val: desc},
  {name: 'Section[]',      val: section},
  {name: 'SchedTime[]',    val: sched},
  {name: 'Room[]',         val: room},
  {name: 'Instructor[]',   val: teacher},
  {name: 'SY[]',           val: <?= json_encode($sy ?? ''); ?>},
  {name: 'Course[]',       val: course},
  {name: 'YearLevel[]',    val: yl},
  {name: 'Sem[]',          val: sem},
  {name: 'strand[]',       val: $tr.data('strand') || ''},   // ▼ ensure strand posts too
  {name: 'IDNumber[]',     val: idnumber}
];


                const wrap = document.createElement('div');
                wrap.className = 'irreg-hidden';
                hid.forEach(h => {
                    const input = document.createElement('input');
                    input.type  = 'hidden';
                    input.name  = h.name;
                    input.value = h.val;
                    wrap.appendChild(input);
                });
                document.getElementById('dynamicHiddenInputs').appendChild(wrap);

                existingCodes.add(code);
                $tr.remove();
                addedCount++;
            });

            if (addedCount > 0) {
                $('#irregModal').modal('hide');
            } else if (window.toastr) {
                toastr.info('No new subjects were selected.');
            }
        });

    })();
    </script>

</body>
</html>
