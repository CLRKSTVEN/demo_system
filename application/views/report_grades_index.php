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

        <div class="row">
          <div class="col-md-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
              <h4 class="page-title mb-0">Report of Grades (Basic Ed)</h4>
              <span class="badge badge-primary">Registrar</span>
            </div>
          </div>
        </div>

        <div class="card shadow-sm">
          <div class="card-body">
            <?php if (!function_exists('h')){ function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } } ?>
            <form method="post" autocomplete="off">
              <?php if (!empty($csrf_name) && !empty($csrf_hash)): ?>
                <input type="hidden" name="<?= h($csrf_name) ?>" value="<?= h($csrf_hash) ?>">
              <?php endif; ?>

              <div class="form-row align-items-end">
                <div class="col-md-9 mb-2">
                  <label class="mb-1 text-muted small">Student</label>
                  <select name="student" class="form-control select2" required>
                    <option value="">— Select Student —</option>
                    <?php if (!empty($students)) : ?>
                      <?php foreach ($students as $s):
                        $name = trim(($s['LastName']??'').', '.($s['FirstName']??'').(empty($s['MiddleName'])?'':' '.strtoupper(substr($s['MiddleName'],0,1)).'.'));
                        $sel  = (!empty($student_selected) && $student_selected === $s['StudentNumber']) ? 'selected' : '';
                      ?>
                        <option value="<?= h($s['StudentNumber']??'') ?>" <?= $sel ?>>
                          <?= h(($s['StudentNumber']??'').' — '.$name.' — '.($s['Course']??'').(
                                !empty($s['YearLevel']) ? ' / '.$s['YearLevel'] : '')) ?>
                        </option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                </div>
                <div class="col-md-3 mb-2">
                  <button type="submit" class="btn btn-primary btn-block">
                    <i class="mdi mdi-magnify mr-1"></i> Load
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <?php if (!empty($selected) && !empty($stud)): ?>
          <div class="mt-3">
            <?php
              $fullName = trim(($stud['LastName']??'').', '.($stud['FirstName']??'').(empty($stud['MiddleName'])?'':' '.strtoupper(substr($stud['MiddleName'],0,1)).'.'));
            ?>
            <div class="card border-0 shadow-sm mb-2">
              <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                <div class="mb-2">
                  <div class="h5 mb-1"><?= h($fullName) ?></div>
                  <div class="text-muted small">Student No.: <b><?= h($stud['StudentNumber'] ?? '') ?></b></div>
                </div>
                <div class="mb-2">
                  <div class="text-muted small">Course / Year</div>
                  <div><b><?= h($stud['Course'] ?? '') ?></b> / <b><?= h($stud['YearLevel'] ?? '') ?></b></div>
                </div>
                <div class="mb-2">
                  <div class="text-muted small">School Year</div>
                  <div><span class="badge badge-light border"><?= h($sy ?? '') ?></span></div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <a class="card shadow-sm hover-card d-block"
                   href="<?= site_url('ReportGrades/v1?student='.urlencode((string)($student_selected ?? ''))) ?>"
                   target="_blank" rel="noopener">
                  <div class="card-body d-flex align-items-center">
                    <div class="icon bg-primary text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                      <i class="mdi mdi-file-document-outline"></i>
                    </div>
                    <div>
                      <div class="h5 mb-1">Report of Grades — V1</div>
                      <div class="text-muted small">Certificate style · General Average</div>
                    </div>
                  </div>
                </a>
              </div>

              <div class="col-md-6">
                <a class="card shadow-sm hover-card d-block"
                   href="<?= site_url('ReportGrades/v2?student='.urlencode((string)($student_selected ?? ''))) ?>"
                   target="_blank" rel="noopener">
                  <div class="card-body d-flex align-items-center">
                    <div class="icon bg-info text-white rounded-circle mr-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                      <i class="mdi mdi-table"></i>
                    </div>
                    <div>
                      <div class="h5 mb-1">Report of Grades — V2</div>
                      <div class="text-muted small">Prelim / Midterm / Semi-Finals / Finals + Average</div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
    <?php include('includes/footer.php'); ?>
  </div>
</div>

<style>
  .hover-card { transition: transform .12s ease, box-shadow .12s ease; cursor:pointer; }
  .hover-card:hover { transform: translateY(-2px); box-shadow:0 .5rem 1rem rgba(0,0,0,.08)!important; }
</style>

<link rel="stylesheet" href="<?= base_url(); ?>assets/libs/select2/select2.min.css">
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
<script>
$(function(){
  $('.select2').select2({ width:'100%' });
});
</script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>
</html>
