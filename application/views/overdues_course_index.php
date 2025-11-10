

<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
  /* Artistic styling */
  body {
    background:
      radial-gradient(1200px 600px at 10% 0%, rgba(0,61,128,0.08), transparent 60%),
      radial-gradient(900px 500px at 100% 0%, rgba(255,193,7,0.08), transparent 60%),
      #f7f8fb;
  }
  .hero-card {
    background: linear-gradient(135deg, #ffffff 0%, #f9fbff 100%);
    border: 0;
    border-radius: 18px;
    box-shadow: 0 12px 24px rgba(0,0,0,0.06);
    overflow: hidden;
  }
  .hero-head {
    background: linear-gradient(90deg, #003d80, #0069d9);
    color: #fff;
    padding: 16px 20px;
    display: flex; align-items: center; gap: 10px;
  }
  .hero-head .icon {
    background: rgba(255,255,255,0.15);
    width: 36px; height: 36px; border-radius: 10px;
    display: grid; place-items: center;
    font-size: 18px;
  }
  .filter-bar {
    display: grid;
    grid-template-columns: repeat(4, minmax(160px, 1fr)) auto;
    gap: 10px;
    padding: 14px 16px;
  }
  .filter-bar .form-control, .filter-bar select {
    border-radius: 10px !important;
  }
  .btn-gradient {
    background: linear-gradient(90deg, #ff7a18, #ffb800);
    border: none; color: #212529;
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(255,184,0,0.35);
    transition: transform .05s ease-in-out;
  }
  .btn-gradient:active { transform: translateY(1px); }
  .badge {
    border-radius: 10px;
    padding: 6px 10px;
    font-weight: 600;
    letter-spacing: .2px;
  }
  .badge-success { background: #2ecc71; }
  .badge-warning { background: #f39c12; color: #212529; }
  .badge-secondary { background: #95a5a6; }
  .empty-state {
    padding: 28px;
    color: #6c757d;
    display: flex; align-items: center; gap: 12px;
  }
  .empty-state .dot {
    width: 10px; height: 10px; border-radius: 50%;
    background: #ffc107; box-shadow: 0 0 0 6px rgba(255,193,7,.15);
  }
  .table thead th {
    background: #f0f5ff;
    border-top: 0;
  }
  .totals-row th { background: #fffbe6; }
</style>

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
    <div class="container-fluid">

      <div class="card hero-card mt-2">
        <div class="hero-head">
          <div class="icon"><i class="mdi mdi-alert-circle"></i></div>
          <div>
            <div style="font-size:16px;font-weight:700;letter-spacing:.3px;">Overdues by Course & Year Level</div>
            <div style="opacity:.9">School Year: <strong><?= htmlspecialchars($sy, ENT_QUOTES); ?></strong></div>
          </div>
        </div>
  <form class="filter-bar" method="get" action="<?= base_url('Overdues'); ?>" id="filterForm">
    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($sy, ENT_QUOTES); ?>" readonly title="School Year">

    <select name="course" id="course" class="form-control form-control-sm" required>
      <option value="">— Select Course —</option>
      <?php foreach ($courses as $c): $cv=(string)$c->CourseDescription; ?>
        <option value="<?= htmlspecialchars($cv, ENT_QUOTES); ?>" <?= ($course===$cv?'selected':''); ?>>
          <?= htmlspecialchars($cv, ENT_QUOTES); ?>
        </option>
      <?php endforeach; ?>
    </select>

    <select name="yearLevel" id="yearLevel" class="form-control form-control-sm" required <?= $course===''?'disabled':''; ?>>
      <option value=""><?= $course===''?'— Select Course first —':'— Select Year Level —'; ?></option>
      <?php if (!empty($yearLevels)): foreach ($yearLevels as $yl): $ylv=(string)$yl->YearLevel; ?>
        <option value="<?= htmlspecialchars($ylv, ENT_QUOTES); ?>" <?= ($yearLevel===$ylv?'selected':''); ?>>
          <?= htmlspecialchars($ylv, ENT_QUOTES); ?>
        </option>
      <?php endforeach; endif; ?>
    </select>

    <input type="month" name="month" id="month" class="form-control form-control-sm"
           value="<?= htmlspecialchars($month, ENT_QUOTES); ?>" required>

    <div>
      <button class="btn btn-gradient btn-sm" type="submit" id="btnFilter" disabled>
        <i class="mdi mdi-filter-outline"></i> Filter
      </button>

      <?php if ($hasAll): ?>
        <a class="btn btn-outline-secondary btn-sm ml-1"
           href="<?= base_url('Overdues/export_csv?course=' . urlencode($course) . '&yearLevel=' . urlencode($yearLevel) . '&month=' . urlencode($month)); ?>">
          Export CSV
        </a>
      <?php endif; ?>

      <?php if ($hasAll && !empty($list)): ?>
        <!-- This button submits the hidden POST form below (no nesting issues) -->
        <button type="submit" class="btn btn-success btn-sm ml-1" form="saveForm">
          <i class="mdi mdi-content-save-outline"></i> Deactivate students account
        </button>
      <?php endif; ?>
    </div>
  </form>
  <!-- /GET FILTER FORM -->
</div>

<?php if ($hasAll && !empty($list)): ?>
  <!-- HIDDEN POST FORM (must be OUTSIDE the GET form to avoid nested form issues) -->
  <form id="saveForm" method="post" action="<?= site_url('Overdues/save_batch'); ?>" style="display:none;">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="course" value="<?= htmlspecialchars($course, ENT_QUOTES); ?>">
    <input type="hidden" name="yearLevel" value="<?= htmlspecialchars($yearLevel, ENT_QUOTES); ?>">
    <input type="hidden" name="month" value="<?= htmlspecialchars($month, ENT_QUOTES); ?>">
  </form>
<?php endif; ?>
      </div>

      <?php if ($this->session->flashdata('msg')): ?>
        <div class="alert alert-<?= $this->session->flashdata('msg_type') ?: 'info' ?> mt-3">
          <?= $this->session->flashdata('msg'); ?>
        </div>
      <?php endif; ?>

      <?php if (!$hasAll): ?>
        <div class="card mt-3">
          <div class="empty-state">
            <span class="dot"></span>
            <p class="mb-0">Pick a <strong>Course</strong>, then a <strong>Year Level</strong>, and a <strong>Month</strong>. The table will appear once all are set.</p>
          </div>
        </div>
      <?php else: ?>

      <div class="card mt-3 mb-5">
        <div class="card-body">
          <h5 class="card-title mb-3">
            Students — <?= htmlspecialchars($course, ENT_QUOTES); ?> • <?= htmlspecialchars($yearLevel, ENT_QUOTES); ?>
            • Month: <?= htmlspecialchars($month, ENT_QUOTES); ?>
          </h5>

          <div class="table-responsive">
            <table id="overduesList" class="table table-bordered table-sm">
            <thead>
  <tr>
    <th style="width:60px;text-align:center">#</th> <!-- NEW -->
    <th>Student #</th>
    <th>Name</th>
    <th>Course</th>
    <th>Year</th>
    <th class="text-right">Schedule Due</th>
    <th style="text-align: center">Status</th>
  </tr>
</thead>
             <tbody>
<?php
  $i = 1; // NEW: row counter
  $totalDue = 0.0;
  foreach ($list as $r):
    $name = trim(($r->FirstName?:'').' '.($r->MiddleName?:'').' '.($r->LastName?:''));
    $totalDue += (float)$r->schedule_due;
?>
  <tr>
    <td style="text-align:center;"><?= $i++; ?></td> <!-- NEW -->
    <td><?= htmlspecialchars($r->StudentNumber, ENT_QUOTES); ?></td>
    <td><?= htmlspecialchars($name, ENT_QUOTES); ?></td>
    <td><?= htmlspecialchars($r->Course ?: '', ENT_QUOTES); ?></td>
    <td><?= htmlspecialchars($r->YearLevel ?: '', ENT_QUOTES); ?></td>
    <td class="text-right">₱<?= number_format((float)$r->schedule_due, 2); ?></td>
    <td style="text-align: center"><span class="badge badge-warning">Pending</span></td>
  </tr>
<?php endforeach; ?>
</tbody>
              <!-- <tfoot>
                <tr class="totals-row">
                  <th colspan="4" class="text-right">Totals</th>
                  <th class="text-right">₱<?= number_format($totalDue, 2); ?></th>
                  <th class="text-right">₱<?= number_format($totalPay, 2); ?></th>
                  <th></th>
                </tr>
              </tfoot> -->
            </table>
          </div>

        </div>
      </div>

      <?php endif; ?>

    </div>
  </div>
  <?php include('includes/footer.php'); ?>
</div>

<!-- DataTables -->
<script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<!-- or your jQuery path -->

<script>
  (function() {
    const $form      = $('#filterForm');
    const $course    = $('#course');
    const $yearLevel = $('#yearLevel');
    const $month     = $('#month');
    const $btnFilter = $('#btnFilter');

    // Prevent accidental submit via Enter while selecting
    $form.on('keydown', function(e) {
      if (e.key === 'Enter') { e.preventDefault(); }
    });

    function updateButtonState() {
      const ok = $course.val() && $yearLevel.val() && $month.val();
      $btnFilter.prop('disabled', !ok);
    }

    function loadYearLevels(courseVal) {
      $yearLevel.prop('disabled', true).html('<option value="">— Loading… —</option>');

      // Use site_url so CI includes index.php if configured
      $.getJSON('<?= site_url('Overdues/yearlevels'); ?>', { course: courseVal })
        .done(function(levels) {
          const uniq = Array.from(new Set((levels || []).filter(Boolean))).sort();
          if (uniq.length === 0) {
            $yearLevel.html('<option value="">— No Year Levels found —</option>');
          } else {
            let opts = '<option value="">— Select Year Level —</option>';
            uniq.forEach(function(v) {
              const safe = $('<div>').text(v).html();
              opts += '<option value="'+safe+'">'+safe+'</option>';
            });
            $yearLevel.html(opts);
          }
          $yearLevel.prop('disabled', false);
          updateButtonState();
        })
        .fail(function() {
          $yearLevel.html('<option value="">— Error loading —</option>').prop('disabled', false);
          updateButtonState();
        });
    }

    // When course changes, fetch Year Levels (no page reload needed)
    $course.on('change', function() {
      const courseVal = $(this).val();
      if (!courseVal) {
        $yearLevel.html('<option value="">— Select Course first —</option>').prop('disabled', true);
        updateButtonState();
        return;
      }
      loadYearLevels(courseVal);
    });

    $yearLevel.on('change', updateButtonState);
    $month.on('change', updateButtonState);

    // If page loads with Course preselected but no Year Levels yet, fetch them now.
    if ($course.val() && (!$yearLevel.val() || $yearLevel.find('option').length <= 1)) {
      loadYearLevels($course.val());
    }

    // Initial button state
    updateButtonState();

    <?php if ($hasAll): ?>
      $('#overduesList').DataTable({ pageLength: 25, order: [[6,'asc']] });
    <?php endif; ?>
  })();
</script>

</body>
</html>
