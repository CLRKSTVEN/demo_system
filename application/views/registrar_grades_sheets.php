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
              <div class="page-title-box">
                <div class="clearfix"></div>
              </div>
            </div>
          </div>

          <?php
          // Safe htmlspecialchars
          function h($val)
          {
            return htmlspecialchars($val ?? '', ENT_QUOTES, 'UTF-8');
          }

          // Normalize sex to Male / Female / Others
          function norm_sex($val)
          {
            $s = ucfirst(strtolower((string)$val));
            return ($s === 'Male' || $s === 'Female') ? $s : 'Others';
          }

          // Preschool year level detector
          function yl_is_preschool($yl)
          {
            $yl = trim((string)$yl);
            $set = ['Kinder', 'Kinder 1', 'Kinder 2', 'Preschool', 'Nursery', 'Prekinder'];
            return in_array($yl, $set, true);
          }

          // Senior High (Grade 11/12 only => 2 periods)
          $allSeniorHigh = true;
          foreach ($data as $row) {
            if (($row->YearLevel ?? '') !== 'Grade 11' && ($row->YearLevel ?? '') !== 'Grade 12') {
              $allSeniorHigh = false;
              break;
            }
          }

          // Is this section all preschool? (hide Average if true)
          $allPreschool = !empty($data);
          if ($allPreschool) {
            foreach ($data as $row) {
              if (!yl_is_preschool($row->YearLevel ?? '')) {
                $allPreschool = false;
                break;
              }
            }
          }

          // Letter-grade converter (for settings-based Letter mode if you use it)
          function getLetterGrade($grade)
          {
            if ($grade === null || $grade === '') return '';
            if ($grade >= 90) return 'A';
            if ($grade >= 85) return 'B+';
            if ($grade >= 80) return 'B';
            if ($grade >= 75) return 'C';
            return 'F';
          }

          // First row context
          $firstRow    = $data[0] ?? null;
          $SubjectCode = $firstRow->SubjectCode ?? $this->input->get('SubjectCode');
          $Description = $firstRow->Description ?? '';
          $Section     = $firstRow->Section ?? $this->input->get('Section');
          $YearLevel   = $firstRow->YearLevel ?? '';
          $sy          = $this->session->userdata('sy');

          // Lock badge text
          function yesno($v)
          {
            return $v ? 'Locked' : 'Open';
          }

          // Group records by sex: Male / Female / Others
          $bySex = ['Male' => [], 'Female' => [], 'Others' => []];
          foreach ($data as $r) {
            $bySex[norm_sex($r->Sex ?? '')][] = $r;
          }

          // Sex header row styling
          $sexStyleMap = [
            'Male'   => 'bg-primary text-white',
            'Female' => 'bg-danger text-white',
            'Others' => 'bg-secondary text-white',
          ];

          // ===== NEW: Half-up rounder where .50 rounds DOWN, > .50 rounds UP
          function round_half_custom($v)
          {
            if ($v === null || $v === '') return null;
            $v = (float)$v;
            $floor = floor($v);
            $frac  = $v - $floor;
            if ($frac > 0.5) return (int)ceil($v); // strictly greater than .5 → up
            return (int)$floor;                     // .50 and below → down
          }

          // Table header renderer (periods)
          function render_header($allSeniorHigh, $hideAverage)
          {
            echo '<thead><tr>';
            echo '<th>NO.</th>';
            echo '<th>STUDENT NAME</th>';
            echo '<th class="text-center">1st Grading</th>';
            echo '<th class="text-center">2nd Grading</th>';
            if (!$allSeniorHigh) {
              echo '<th class="text-center">3rd Grading</th>';
              echo '<th class="text-center">4th Grading</th>';
            }
            if (!$hideAverage) {
              echo '<th class="text-center">Average</th>';
            }
            echo '</tr></thead>';
          }

          // Build a stable key so duplicates can be detected without mutating the source data
          function student_row_key($row)
          {
            $candidates = [
              'StudentNumber',
              'studentNumber',
              'LRN',
              'lrn',
              'StudentID',
              'studentID',
              'student_id',
              'Student_Id',
              'student_Id'
            ];
            foreach ($candidates as $field) {
              if (isset($row->$field)) {
                $val = trim((string)$row->$field);
                if ($val !== '') {
                  return strtolower($val);
                }
              }
            }
            $last = strtoupper(trim($row->LastName ?? ''));
            $first = strtoupper(trim($row->FirstName ?? ''));
            $middle = strtoupper(trim($row->MiddleName ?? ''));
            if ($last !== '' || $first !== '' || $middle !== '') {
              return $last . '|' . $first . '|' . $middle;
            }
            return null;
          }

          // Count unique students per list (helps label counts match visible rows)
          function unique_student_count($list)
          {
            $seen = [];
            $count = 0;
            foreach ($list as $row) {
              $key = student_row_key($row);
              if ($key === null) {
                $count++;
                continue;
              }
              if (isset($seen[$key])) {
                continue;
              }
              $seen[$key] = true;
              $count++;
            }
            return $count;
          }

          // Determine how much usable grade data a row contains (higher score => prefer this row)
          function student_row_score($row)
          {
            $fields = [
              'l_p',
              'l_m',
              'l_pf',
              'l_f',
              'l_average',
              'PGrade',
              'MGrade',
              'PFinalGrade',
              'FGrade',
              'Average'
            ];
            $nonEmpty = 0;
            $nonZero = 0;
            foreach ($fields as $field) {
              if (property_exists($row, $field)) {
                $val = $row->$field;
                if (is_string($val)) {
                  $val = trim($val);
                }
                if ($val === null || $val === '') {
                  continue;
                }
                $nonEmpty++;
                if (is_numeric($val)) {
                  if ((float)$val != 0.0) {
                    $nonZero++;
                  }
                } else {
                  $nonZero++;
                }
              }
            }
            return ($nonZero * 100) + $nonEmpty;
          }

          // Row renderer respecting preschool (force l_*) and SHS periods
          function render_rows($list, $gradeDisplay, $allSeniorHigh, $hideAverage)
          {
            $i = 1;
            $bestIndexByKey = [];
            foreach ($list as $idx => $row) {
              $key = student_row_key($row);
              if ($key === null) {
                continue;
              }
              $score = student_row_score($row);
              if (!isset($bestIndexByKey[$key]) || $score > $bestIndexByKey[$key]['score']) {
                $bestIndexByKey[$key] = [
                  'score' => $score,
                  'index' => $idx
                ];
              }
            }
            foreach ($list as $idx => $row) {
              $key = student_row_key($row);
              $shouldHide = false;
              if ($key !== null && isset($bestIndexByKey[$key]) && $bestIndexByKey[$key]['index'] !== $idx) {
                $shouldHide = true;
              }
              $name = trim(($row->LastName ?? '') . ', ' . ($row->FirstName ?? '') . ' ' . ($row->MiddleName ?? ''));
              $useLetterByYL = yl_is_preschool($row->YearLevel ?? '');

              $rowAttrs = '';
              if ($shouldHide) {
                $rowAttrs = ' class="duplicate-row" style="display:none !important;"';
                if ($key !== null) {
                  $rowAttrs .= ' data-duplicate-key="' . h($key) . '"';
                }
              }

              echo '<tr' . $rowAttrs . '>';
              echo '<td>' . ($shouldHide ? '' : ($i++)) . '</td>';
              echo '<td>' . h($name) . '</td>';

              if ($useLetterByYL) {
                // Force LETTER columns for preschool year levels (use l_* from DB)
                echo '<td class="text-center">' . h($row->l_p ?? '') . '</td>';
                echo '<td class="text-center">' . h($row->l_m ?? '') . '</td>';
                if (!$allSeniorHigh) {
                  echo '<td class="text-center">' . h($row->l_pf ?? '') . '</td>';
                  echo '<td class="text-center">' . h($row->l_f ?? '') . '</td>';
                }
                if (!$hideAverage) {
                  echo '<td class="text-center">' . h($row->l_average ?? '') . '</td>';
                }
              } else if ($gradeDisplay === 'Letter') {
                // Settings-based Letter mode (non-preschool)
                echo '<td class="text-center">' . getLetterGrade($row->PGrade) . '</td>';
                echo '<td class="text-center">' . getLetterGrade($row->MGrade) . '</td>';
                if (!$allSeniorHigh) {
                  echo '<td class="text-center">' . getLetterGrade($row->PFinalGrade) . '</td>';
                  echo '<td class="text-center">' . getLetterGrade($row->FGrade) . '</td>';
                }
                if (!$hideAverage) {
                  echo '<td class="text-center">' . getLetterGrade($row->Average) . '</td>';
                }
              } else {
                // Numeric mode (non-preschool)
                echo '<td class="text-center">' . ($row->PGrade === null ? '' : number_format((float)$row->PGrade, 2)) . '</td>';
                echo '<td class="text-center">' . ($row->MGrade === null ? '' : number_format((float)$row->MGrade, 2)) . '</td>';
                if (!$allSeniorHigh) {
                  echo '<td class="text-center">' . ($row->PFinalGrade === null ? '' : number_format((float)$row->PFinalGrade, 2)) . '</td>';
                  echo '<td class="text-center">' . ($row->FGrade === null ? '' : number_format((float)$row->FGrade, 2)) . '</td>';
                }
                if (!$hideAverage) {
                  // NEW: carry both raw (2-decimal) and rounded (custom) values with data-*
                  $avgRaw = ($row->Average === null ? '' : number_format((float)$row->Average, 2));
                  $avgRnd = ($row->Average === null ? '' : round_half_custom((float)$row->Average));
                  // Default display is ROUNDED
                  echo '<td class="text-center avg-cell" data-raw="' . h($avgRaw) . '" data-round="' . h($avgRnd) . '">' . h($avgRnd) . '</td>';
                }
              }

              echo '</tr>';
            }
          }

          // Compute colspan for the sex header divider row
          $periodCount = $allSeniorHigh ? 2 : 4;   // 1st,2nd or 1st..4th
          $colspan = 2 /* No., Name */ + $periodCount + ($allPreschool ? 0 : 1); // +Average only if NOT preschool
          ?>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body table-responsive">

                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                      <h4 class="m-t-0 header-title mb-1">
                        <strong>REPORT OF GRADES</strong><br />
                        <span class="badge badge-purple mb-1">SY <?= h($sy) ?></span>
                      </h4>
                      <table>
                        <tr>
                          <td>Subject Code</td>
                          <td>: <b><?= h($SubjectCode) ?></b></td>
                        </tr>
                        <tr>
                          <td>Description</td>
                          <td>: <b><?= h($Description) ?></b></td>
                        </tr>
                        <tr>
                          <td>Section</td>
                          <td>: <b><?= h($Section) ?></b></td>
                        </tr>
                        <tr>
                          <td>Teacher</td>
                          <td>: <b><?= isset($data[0]->Instructor) ? h($data[0]->Instructor) : '' ?></b></td>
                        </tr>
                      </table>
                    </div>

                    <div class="d-print-none">
                      <div class="float-right">
                        <!-- NEW: Average display toggle buttons -->
                        <div class="btn-group mr-1" role="group" aria-label="Average display">
                          <button id="btnAvgRounded" type="button" class="btn btn-outline-secondary btn-sm active" title="Show rounded averages">Rounded</button>
                          <button id="btnAvgExact" type="button" class="btn btn-outline-secondary btn-sm" title="Show exact (2-decimal) averages">Exact</button>
                        </div>

                        <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light">
                          <i class="fa fa-print"></i>
                        </a>
                      </div>
                    </div>
                  </div>

                  <!-- Scope badges -->
                  <div class="mb-2">
                    <span class="badge badge-dark mr-1">SY <?= h($sy) ?></span>
                    <span class="badge badge-info mr-1"><?= h($SubjectCode) ?></span>
                    <span class="badge badge-purple mr-1"><?= h($Section) ?></span>
                    <span class="badge badge-primary"><?= h($YearLevel) ?></span>
                  </div>

                  <!-- Lock status badges -->
                  <div class="mb-3">
                    <span class="badge badge-<?= !empty($locks->lock_prelim)  ? 'danger' : 'success' ?> mr-1" id="b-prelim">
                      1st Grading: <?= yesno(!empty($locks->lock_prelim)) ?>
                    </span>
                    <span class="badge badge-<?= !empty($locks->lock_midterm) ? 'danger' : 'success' ?> mr-1" id="b-midterm">
                      2nd Grading: <?= yesno(!empty($locks->lock_midterm)) ?>
                    </span>
                    <?php if (!$allSeniorHigh): ?>
                      <span class="badge badge-<?= !empty($locks->lock_prefinal) ? 'danger' : 'success' ?> mr-1" id="b-prefinal">
                        3rd Grading: <?= yesno(!empty($locks->lock_prefinal)) ?>
                      </span>
                      <span class="badge badge-<?= !empty($locks->lock_final)   ? 'danger' : 'success' ?> mr-1" id="b-final">
                        4th Grading: <?= yesno(!empty($locks->lock_final)) ?>
                      </span>
                    <?php endif; ?>
                  </div>

                  <!-- Lock/Unlock Controls -->
                  <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                      <strong>Grade Lock Controls</strong>
                    </div>
                    <div class="card-body text-center">
                      <div class="btn-toolbar justify-content-center flex-wrap" role="toolbar">
                        <!-- 1st -->
                        <div class="btn-group mr-2 mb-2" role="group">
                          <button class="btn btn-sm btn-<?= !empty($locks->lock_prelim) ? 'danger' : 'success' ?> lock-btn"
                            data-period="prelim"
                            data-action="<?= !empty($locks->lock_prelim) ? 'unlock' : 'lock' ?>">
                            <i class="fa <?= !empty($locks->lock_prelim) ? 'fa-unlock' : 'fa-lock' ?>"></i>
                            1st Grading <?= !empty($locks->lock_prelim) ? '(Unlock)' : '(Lock)' ?>
                          </button>
                        </div>
                        <!-- 2nd -->
                        <div class="btn-group mr-2 mb-2" role="group">
                          <button class="btn btn-sm btn-<?= !empty($locks->lock_midterm) ? 'danger' : 'success' ?> lock-btn"
                            data-period="midterm"
                            data-action="<?= !empty($locks->lock_midterm) ? 'unlock' : 'lock' ?>">
                            <i class="fa <?= !empty($locks->lock_midterm) ? 'fa-unlock' : 'fa-lock' ?>"></i>
                            2nd Grading <?= !empty($locks->lock_midterm) ? '(Unlock)' : '(Lock)' ?>
                          </button>
                        </div>
                        <?php if (!$allSeniorHigh): ?>
                          <!-- 3rd -->
                          <div class="btn-group mr-2 mb-2" role="group">
                            <button class="btn btn-sm btn-<?= !empty($locks->lock_prefinal) ? 'danger' : 'success' ?> lock-btn"
                              data-period="prefinal"
                              data-action="<?= !empty($locks->lock_prefinal) ? 'unlock' : 'lock' ?>">
                              <i class="fa <?= !empty($locks->lock_prefinal) ? 'fa-unlock' : 'fa-lock' ?>"></i>
                              3rd Grading <?= !empty($locks->lock_prefinal) ? '(Unlock)' : '(Lock)' ?>
                            </button>
                          </div>
                          <!-- 4th -->
                          <div class="btn-group mr-2 mb-2" role="group">
                            <button class="btn btn-sm btn-<?= !empty($locks->lock_final) ? 'danger' : 'success' ?> lock-btn"
                              data-period="final"
                              data-action="<?= !empty($locks->lock_final) ? 'unlock' : 'lock' ?>">
                              <i class="fa <?= !empty($locks->lock_final) ? 'fa-unlock' : 'fa-lock' ?>"></i>
                              4th Grading <?= !empty($locks->lock_final) ? '(Unlock)' : '(Lock)' ?>
                            </button>
                          </div>
                        <?php endif; ?>

                        <!-- All -->
                        <div class="btn-group mb-2" role="group">
                          <button class="btn btn-sm btn-danger lock-btn mr-1" data-period="all" data-action="lock">
                            <i class="fa fa-lock"></i> Lock ALL
                          </button>
                          <button class="btn btn-sm btn-success lock-btn" data-period="all" data-action="unlock">
                            <i class="fa fa-unlock"></i> Unlock ALL
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?= $this->session->flashdata('msg'); ?>

                  <!-- ====== Group: Male ====== -->
                  <?php if (!empty($bySex['Male'])): ?>
                    <div class="mt-3">
                      <table class="table">
                        <tr>
                          <td colspan="<?= $colspan; ?>" class="text-center font-weight-bold <?= $sexStyleMap['Male']; ?>">
                            MALE (<?= unique_student_count($bySex['Male']); ?>)
                          </td>
                        </tr>
                        <?php render_header($allSeniorHigh, $allPreschool); ?>
                        <tbody>
                          <?php render_rows($bySex['Male'], $gradeDisplay, $allSeniorHigh, $allPreschool); ?>
                        </tbody>
                      </table>
                    </div>
                  <?php endif; ?>

                  <!-- ====== Group: Female ====== -->
                  <?php if (!empty($bySex['Female'])): ?>
                    <div class="mt-3">
                      <table class="table">
                        <tr>
                          <td colspan="<?= $colspan; ?>" class="text-center font-weight-bold <?= $sexStyleMap['Female']; ?>">
                            FEMALE (<?= unique_student_count($bySex['Female']); ?>)
                          </td>
                        </tr>
                        <?php render_header($allSeniorHigh, $allPreschool); ?>
                        <tbody>
                          <?php render_rows($bySex['Female'], $gradeDisplay, $allSeniorHigh, $allPreschool); ?>
                        </tbody>
                      </table>
                    </div>
                  <?php endif; ?>

                  <!-- ====== Group: Others/Unspecified ====== -->
                  <?php if (!empty($bySex['Others'])): ?>
                    <div class="mt-3">
                      <table class="table">
                        <tr>
                          <td colspan="<?= $colspan; ?>" class="text-center font-weight-bold <?= $sexStyleMap['Others']; ?>">
                            OTHERS (<?= unique_student_count($bySex['Others']); ?>)
                          </td>
                        </tr>
                        <?php render_header($allSeniorHigh, $allPreschool); ?>
                        <tbody>
                          <?php render_rows($bySex['Others'], $gradeDisplay, $allSeniorHigh, $allPreschool); ?>
                        </tbody>
                      </table>
                    </div>
                  <?php endif; ?>

                  <!-- Hidden context for AJAX -->
                  <input type="hidden" id="ctx-SubjectCode" value="<?= h($SubjectCode) ?>">
                  <input type="hidden" id="ctx-Description" value="<?= h($Description) ?>">
                  <input type="hidden" id="ctx-Section" value="<?= h($Section) ?>">
                  <input type="hidden" id="ctx-YearLevel" value="<?= h($YearLevel) ?>">

                </div>
              </div>
            </div>
          </div>

        </div><!-- container-fluid -->
      </div><!-- content -->

      <?php include('includes/footer.php'); ?>
    </div><!-- content-page -->
  </div><!-- wrapper -->

  <?php include('includes/themecustomizer.php'); ?>

  <!-- Vendor and App scripts -->
  <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

  <script>
    (function($) {
      function toast(msg) {
        if (window.$ && $.NotificationApp && $.NotificationApp.send) {
          $.NotificationApp.send("Success", msg, "top-right", "rgba(0,0,0,0.2)", "success");
        } else {
          alert(msg);
        }
      }

      function updateBadges(locks) {
        const map = [{
            id: '#b-prelim',
            val: locks.lock_prelim,
            open: '1st Grading: Open',
            lock: '1st Grading: Locked'
          },
          {
            id: '#b-midterm',
            val: locks.lock_midterm,
            open: '2nd Grading: Open',
            lock: '2nd Grading: Locked'
          },
          {
            id: '#b-prefinal',
            val: locks.lock_prefinal,
            open: '3rd Grading: Open',
            lock: '3rd Grading: Locked'
          },
          {
            id: '#b-final',
            val: locks.lock_final,
            open: '4th Grading: Open',
            lock: '4th Grading: Locked'
          },
        ];
        map.forEach(m => {
          const $b = $(m.id);
          if (!$b.length) return;
          $b.removeClass('badge-success badge-danger')
            .addClass(m.val ? 'badge-danger' : 'badge-success')
            .text(m.val ? m.lock : m.open);
        });
      }

      $('.lock-btn').on('click', function() {
        const period = $(this).data('period');
        const action = $(this).data('action');

        $.post('<?= base_url('Masterlist/toggleLock'); ?>', {
            SubjectCode: $('#ctx-SubjectCode').val(),
            Description: $('#ctx-Description').val(),
            Section: $('#ctx-Section').val(),
            YearLevel: $('#ctx-YearLevel').val(),
            period: period,
            action: action,
            '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
          })
          .done(function(resp) {
            if (resp && resp.ok) {
              updateBadges(resp.locks);
              toast((action === 'lock' ? 'Locked ' : 'Unlocked ') + period.toUpperCase() + ' successfully.');
              setTimeout(function() {
                location.reload();
              }, 0);
            } else {
              alert('Failed to toggle lock.');
            }
          })
          .fail(function() {
            alert('Server error while toggling lock.');
          });
      });

      // ---- Average display toggle (Rounded default) ----
      const AVG_MODE_KEY = 'avgMode'; // 'rounded' | 'exact'

      function applyAvgMode(mode) {
        const rounded = (mode !== 'exact'); // default rounded
        $('.avg-cell').each(function() {
          const raw = $(this).data('raw');
          const rnd = $(this).data('round');
          $(this).text(rounded ? (rnd ?? '') : (raw ?? ''));
        });
        // Button states
        $('#btnAvgRounded').toggleClass('active', rounded);
        $('#btnAvgExact').toggleClass('active', !rounded);
        // Persist
        try {
          localStorage.setItem(AVG_MODE_KEY, rounded ? 'rounded' : 'exact');
        } catch (e) {}
      }

      let startMode = 'rounded';
      try {
        const saved = localStorage.getItem(AVG_MODE_KEY);
        if (saved === 'exact' || saved === 'rounded') startMode = saved;
      } catch (e) {}
      applyAvgMode(startMode);

      $('#btnAvgRounded').on('click', function() {
        applyAvgMode('rounded');
      });
      $('#btnAvgExact').on('click', function() {
        applyAvgMode('exact');
      });

    })(jQuery);
  </script>

</body>

</html>
