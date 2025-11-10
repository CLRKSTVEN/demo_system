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
        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show mt-2">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= $this->session->flashdata('success'); ?>
          </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('danger')): ?>
          <div class="alert alert-danger alert-dismissible fade show mt-2">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= $this->session->flashdata('danger'); ?>
          </div>
        <?php endif; ?>

        <?php
        // ===== Settings & letter-grade logic =====
        // Expect $setting passed from controller
        $preschoolBuckets = ['Kinder','Kinder 1','Kinder 2','Preschool'];

        // Try to infer YearLevel (from existing grades first, else students)
        $anyYL = null;
        if (!empty($grades)) {
          // $grades might be array of rows or map of StudentNumber=>row; get first object
          $tmpFirst = null;
          if (is_array($grades)) {
            foreach ($grades as $gRow) { if (is_object($gRow)) { $tmpFirst = $gRow; break; } }
          }
          $anyYL = $tmpFirst->YearLevel ?? null;
        } elseif (!empty($students)) {
          $anyYL = $students[0]->YearLevel ?? null;
        }
        $isPreschool = $anyYL ? in_array($anyYL, $preschoolBuckets, true) : false;
        $useLetter   = $isPreschool && !empty($setting) && ($setting->preschoolGrade === 'Letter');

        // ===== Periods map =====
        $allPeriods = [
          '1' => ['key'=>'prelim',   'num'=>'PGrade',      'let'=>'l_p',  'label'=>'1st Grading'],
          '2' => ['key'=>'midterm',  'num'=>'MGrade',      'let'=>'l_m',  'label'=>'2nd Grading'],
          '3' => ['key'=>'prefinal', 'num'=>'PFinalGrade', 'let'=>'l_pf', 'label'=>'3rd Grading'],
          '4' => ['key'=>'final',    'num'=>'FGrade',      'let'=>'l_f',  'label'=>'4th Grading'],
        ];

        // ===== Helpers (no $this inside closures in views) =====
        $CI =& get_instance();
        $__profileCache = [];
        $__getProfile = function($sn) use (&$__profileCache, $CI) {
          if (!$sn) return null;
          if (!array_key_exists($sn, $__profileCache)) {
            $__profileCache[$sn] = $CI->Common->one_cond_row('studeprofile', 'StudentNumber', $sn);
          }
          return $__profileCache[$sn];
        };
        $sexOf = function($row) use ($__getProfile) {
          $sex = $row->Sex ?? null;
          if (!$sex) { $p = $__getProfile($row->StudentNumber ?? null); $sex = $p->Sex ?? ''; }
          $s = ucfirst(strtolower((string)$sex));
          return in_array($s,['Male','Female']) ? $s : 'Others';
        };
        $nameOf = function($row) use ($__getProfile) {
          $p  = $__getProfile($row->StudentNumber ?? null);
          $ln = $row->LastName   ?? ($p->LastName   ?? '');
          $fn = $row->FirstName  ?? ($p->FirstName  ?? '');
          $mn = $row->MiddleName ?? ($p->MiddleName ?? '');
          $mn_i = $mn ? ' '.substr($mn,0,1).'.' : '';
          return [$ln,$fn,$mn_i];
        };
        // Value non-zero check (numbers >0, or non-empty text for letter grades)
        $val_nonzero = function($v) {
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
        // Default: only 1st grading if no existing grade rows
        $show = ['1'=>true, '2'=>false, '3'=>false, '4'=>false];

        // Build a simple list of grade objects for checking
        $gradeList = [];
        if (!empty($grades)) {
          foreach ($grades as $g) { if (is_object($g)) $gradeList[] = $g; }
        }

        if (!empty($gradeList)) {
          $anyP = $anyM = $anyPF = false;
          foreach ($gradeList as $r) {
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

        // Build selected periods (in order)
        $selectedPeriods = [];
        foreach (['1','2','3','4'] as $pid) {
          if ($show[$pid]) $selectedPeriods[] = array_merge($allPeriods[$pid], ['id'=>$pid]);
        }

        // Sex group header styles
        $sexStyleMap = [
          'Male'   => 'bg-primary text-white',
          'Female' => 'bg-danger text-white',
          'Others' => 'bg-secondary text-white',
        ];

        // Table colspan: No., Name, StudentNo + periods (+ Average if numeric & 4 periods visible)
        $colspan = 3 + count($selectedPeriods) + (($useLetter || count($selectedPeriods)!==4) ? 0 : 1);
        ?>

        <!-- Toolbar -->
        <div class="card shadow-sm border-0 mb-3 d-print-none">
          <div class="card-body py-2">
            <form method="get" id="gradingFilterForm" class="form-inline">
              <input type="hidden" name="SubjectCode" value="<?= html_escape($filters['SubjectCode']); ?>">
              <input type="hidden" name="Description" value="<?= html_escape($filters['Description']); ?>">
              <input type="hidden" name="Instructor"  value="<?= html_escape($filters['Instructor']); ?>">
              <input type="hidden" name="Section"     value="<?= html_escape($filters['Section']); ?>">

              <span class="mr-2 small text-muted text-uppercase font-weight-bold">Show grading</span>

              <div class="input-group input-group-sm mr-2 mb-2">
                <div class="input-group-prepend"><span class="input-group-text">From</span></div>
                <select class="custom-select" name="from" id="fromSelect">
                  <?php foreach(['1','2','3','4'] as $pid): ?>
                    <option value="<?= $pid ?>" <?= !empty($show[$pid]) && $pid==='1' ? 'selected' : '' ?>><?= $allPeriods[$pid]['label'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="input-group input-group-sm mr-2 mb-2">
                <div class="input-group-prepend"><span class="input-group-text">To</span></div>
                <select class="custom-select" name="to" id="toSelect">
                  <?php foreach(['1','2','3','4'] as $pid): ?>
                    <option value="<?= $pid ?>" <?= end($selectedPeriods)['id'] === $pid ? 'selected' : '' ?>><?= $allPeriods[$pid]['label'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <button class="btn btn-primary btn-sm mr-2 mb-2" type="submit"><i class="fa fa-filter"></i> Apply</button>

              <div class="btn-group btn-group-sm mr-2 mb-2">
                <button type="button" class="btn btn-outline-secondary" data-range="1-2">1–2</button>
                <button type="button" class="btn btn-outline-secondary" data-range="3-4">3–4</button>
                <button type="button" class="btn btn-outline-secondary" data-range="1-4">1–4</button>
              </div>

              <button type="button" class="btn btn-dark btn-sm mb-2" onclick="window.print()"><i class="fa fa-print"></i> Print</button>

              <span class="badge badge-light border ml-2 mb-2">
                Showing:
                <strong class="text-primary"><?= $allPeriods[$selectedPeriods[0]['id']]['label']; ?></strong>
                →
                <strong class="text-primary"><?= $allPeriods[end($selectedPeriods)['id']]['label']; ?></strong>
              </span>
            </form>
          </div>
        </div>

        <script>
          (function(){
            var f=document.getElementById('gradingFilterForm'); if(!f) return;
            var a=document.getElementById('fromSelect'), b=document.getElementById('toSelect');
            function clamp(){ var x=+a.value, y=+b.value; if(x>y){ var t=a.value; a.value=b.value; b.value=t; } }
            a.addEventListener('change',clamp); b.addEventListener('change',clamp);
            f.querySelectorAll('[data-range]').forEach(function(btn){
              btn.addEventListener('click',function(){
                var r=(btn.getAttribute('data-range')||'1-4').split('-');
                a.value=r[0]; b.value=r[1]; clamp(); f.submit();
              });
            });
          })();
        </script>

        <?php if (empty($gradeList)) : ?>
          <!-- ================= INSERT (no existing grades) ================= -->
          <div class="card">
            <div class="card-body">
              <h4 class="header-title mb-3">Registrar: Input Grades</h4>

              <!-- Class Information -->
              <div class="card mb-3">
                <div class="card-body">
                  <h4 class="header-title mb-3">Class Information</h4>
                  <table class="table table-borderless mb-0">
                    <tr><th style="width:150px;">Subject Code</th><td><?= html_escape($filters['SubjectCode']); ?></td></tr>
                    <tr><th>Description</th><td><?= html_escape($filters['Description']); ?></td></tr>
                    <tr><th>Teacher</th><td><?= html_escape($filters['Instructor']); ?></td></tr>
                    <tr><th>Section</th><td><?= html_escape($filters['Section']); ?></td></tr>
                  </table>
                </div>
              </div>

              <?php
              // Group students (enrolled) by sex
              $grouped = ['Male'=>[],'Female'=>[],'Others'=>[]];
              foreach ($students as $s) {
                $row = (object)[
                  'StudentNumber' => $s->StudentNumber ?? null,
                  'FirstName'     => $s->FirstName  ?? null,
                  'MiddleName'    => $s->MiddleName ?? null,
                  'LastName'      => $s->LastName   ?? null,
                  'Sex'           => $s->Sex        ?? null,
                  'YearLevel'     => $s->YearLevel  ?? null,
                  'strand'        => $s->strand     ?? null,
                ];
                $grouped[$sexOf($row)][] = $row;
              }
              ?>

              <?= form_open('Masterlist/saveRegistrarGrades'); ?>
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Student Name</th>
                      <th>Student No.</th>
                      <?php foreach($selectedPeriods as $p): ?>
                        <th class="text-center"><?= $p['label']; ?></th>
                      <?php endforeach; ?>
                      <?php if(!$useLetter && count($selectedPeriods)===4): ?>
                        <th class="text-center">Average</th>
                      <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach(['Male','Female','Others'] as $SEX): if(empty($grouped[$SEX])) continue; ?>
                      <tr>
                        <td colspan="<?= $colspan; ?>" class="text-center font-weight-bold <?= $sexStyleMap[$SEX]; ?>">
                          <?= strtoupper($SEX); ?>
                        </td>
                      </tr>
                      <?php $i=1; foreach($grouped[$SEX] as $row): ?>
                        <?php list($ln,$fn,$mn_i) = $nameOf($row); ?>
                        <tr>
                          <th><?= $i++; ?></th>
                          <td><?= html_escape($ln); ?>, <?= html_escape($fn); ?><?= html_escape($mn_i); ?></td>
                          <td>
                            <?= html_escape($row->StudentNumber); ?>
                            <input type="hidden" name="StudentNumber[]" value="<?= html_escape($row->StudentNumber); ?>">
                            <input type="hidden" name="SubjectCode"    value="<?= html_escape($filters['SubjectCode']); ?>">
                            <input type="hidden" name="description"    value="<?= html_escape($filters['Description']); ?>">
                            <input type="hidden" name="section"        value="<?= html_escape($filters['Section']); ?>">
                            <input type="hidden" name="SY"             value="<?= html_escape($filters['SY']); ?>">
                            <input type="hidden" name="Instructor"     value="<?= html_escape($filters['Instructor']); ?>">
                            <input type="hidden" name="strand[]"       value="<?= html_escape($row->strand ?? ''); ?>">
                            <input type="hidden" name="YearLevel"      value="<?= html_escape($row->YearLevel ?? $anyYL); ?>">
                          </td>

                          <?php foreach($selectedPeriods as $p): ?>
                            <td class="text-center">
                              <?php if($useLetter): ?>
                                <input type="text" class="text-center" style="width:70%" name="<?= $p['let']; ?>[]">
                              <?php else: ?>
                                <input type="text" class="text-center" style="width:70%" name="<?= $p['num']; ?>[]">
                              <?php endif; ?>
                            </td>
                          <?php endforeach; ?>

                          <?php if(!$useLetter && count($selectedPeriods)===4): ?>
                            <td class="text-center"><input type="text" class="text-center" style="width:70%" name="Average[]" readonly></td>
                          <?php endif; ?>
                        </tr>
                      <?php endforeach; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <div class="text-right mt-3">
                <button class="btn btn-primary" type="submit">Save</button>
              </div>
              </form>
            </div>
          </div>

        <?php else: ?>
          <!-- ================= UPDATE (existing grades) ================= -->
          <div class="card">
            <div class="card-body">
              <h4 class="header-title mb-3">Registrar: Update Grades</h4>

              <!-- Class Information -->
              <div class="card mb-3">
                <div class="card-body">
                  <h4 class="header-title mb-3">Class Information</h4>
                  <table class="table table-borderless mb-0">
                    <tr><th style="width:150px;">Subject Code</th><td><?= html_escape($filters['SubjectCode']); ?></td></tr>
                    <tr><th>Description</th><td><?= html_escape($filters['Description']); ?></td></tr>
                    <tr><th>Teacher</th><td><?= html_escape($filters['Instructor']); ?></td></tr>
                    <tr><th>Section</th><td><?= html_escape($filters['Section']); ?></td></tr>
                  </table>
                </div>
              </div>

              <?php
              // Group existing grade rows by sex
              $grouped = ['Male'=>[],'Female'=>[],'Others'=>[]];
              foreach($gradeList as $grow){ $grouped[$sexOf($grow)][] = $grow; }
              ?>

              <?= form_open('Masterlist/updateRegistrarGrades'); ?>
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Student Name</th>
                      <th>Student No.</th>
                      <?php foreach($selectedPeriods as $p): ?>
                        <th class="text-center"><?= $p['label']; ?></th>
                      <?php endforeach; ?>
                      <?php if(!$useLetter && count($selectedPeriods)===4): ?>
                        <th class="text-center">Average</th>
                      <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach(['Male','Female','Others'] as $SEX): if(empty($grouped[$SEX])) continue; ?>
                      <tr>
                        <td colspan="<?= $colspan; ?>" class="text-center font-weight-bold <?= $sexStyleMap[$SEX]; ?>">
                          <?= strtoupper($SEX); ?>
                        </td>
                      </tr>
                      <?php $i=1; foreach($grouped[$SEX] as $row): ?>
                        <?php list($ln,$fn,$mn_i) = $nameOf($row); ?>
                        <tr>
                          <th><?= $i++; ?></th>
                          <td><?= html_escape($ln); ?>, <?= html_escape($fn); ?><?= html_escape($mn_i); ?></td>
                          <td>
                            <?= html_escape($row->StudentNumber); ?>
                            <input type="hidden" name="StudentNumber[]" value="<?= html_escape($row->StudentNumber); ?>">
                            <input type="hidden" name="SubjectCode"    value="<?= html_escape($filters['SubjectCode']); ?>">
                            <input type="hidden" name="description"    value="<?= html_escape($filters['Description']); ?>">
                            <input type="hidden" name="section"        value="<?= html_escape($filters['Section']); ?>">
                            <input type="hidden" name="SY"             value="<?= html_escape($filters['SY']); ?>">
                            <input type="hidden" name="gradeID[]"      value="<?= html_escape($row->gradeID); ?>">
                          </td>

                          <?php foreach($selectedPeriods as $p): ?>
                            <td class="text-center">
                              <?php if($useLetter): ?>
                                <input type="text" style="width:70%" class="text-center"
                                       name="<?= $p['let']; ?>[]"
                                       value="<?= html_escape($row->{$p['let']} ?? ''); ?>">
                              <?php else: ?>
                                <input type="text" style="width:70%" class="text-center"
                                       name="<?= $p['num']; ?>[]"
                                       value="<?= html_escape($row->{$p['num']} ?? ''); ?>">
                              <?php endif; ?>
                            </td>
                          <?php endforeach; ?>

                          <?php if(!$useLetter && count($selectedPeriods)===4): ?>
                            <td class="text-center"><?= isset($row->Average) ? number_format($row->Average) : ''; ?></td>
                          <?php endif; ?>
                        </tr>
                      <?php endforeach; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <div class="text-right mt-3">
                <button class="btn btn-primary" type="submit">Update</button>
              </div>
              </form>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>

    <?php include('includes/footer.php'); ?>
  </div>

  <?php include('includes/themecustomizer.php'); ?>

  <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</div>
</body>
</html>
