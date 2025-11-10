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


      <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('danger')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('danger'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

        <!-- Page Title -->
        <div class="row">
          <div class="col-md-12">
            <div class="page-title-box d-flex justify-content-between align-items-center">
              <h4 class="page-title mb-0">Subjects</h4>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                <i class="fas fa-plus-circle mr-1"></i> Add New
              </button>
            </div>
          </div>
        </div>

        <?php $semesterOrder = ['First Semester', 'Second Semester', 'Summer', 'N/A']; ?>

        <!-- Grouped Subjects -->
        <div id="accordion" class="mt-3">
          <?php if (!empty($groupedSubjects)): ?>
            <?php foreach ($groupedSubjects as $yearLevelKey => $semesters): ?>
              <?php $collapseId = 'collapse_' . md5($yearLevelKey); ?>
              <div class="card mb-3 shadow-sm">
                <div class="card-header bg-primary text-white">
                  <h5 class="mb-0 d-flex align-items-center">
                    <button class="btn btn-link text-white p-0 mr-2" data-toggle="collapse" data-target="#<?= $collapseId; ?>">
                      <i class="fas fa-chevron-down"></i>
                    </button>
                    <?= htmlspecialchars(strtoupper($yearLevelKey), ENT_QUOTES, 'UTF-8'); ?>
                  </h5>
                </div>
                <div id="<?= $collapseId; ?>" class="collapse" data-parent="#accordion">
                  <div class="card-body">

                    <?php foreach ($semesterOrder as $semLabel): ?>
                      <?php
                        $subjectsByStrand = $semesters[$semLabel] ?? [];

                        if (in_array($semLabel, ['First Semester', 'Second Semester'], true) && !empty($semesters['Both Semesters'])) {
                          foreach ($semesters['Both Semesters'] as $strandKey => $bothSubjects) {
                            if (empty($bothSubjects)) {
                              continue;
                            }
                            $existing = $subjectsByStrand[$strandKey] ?? [];
                            $subjectsByStrand[$strandKey] = array_merge($existing, $bothSubjects);
                          }
                        }
                      ?>
                      <?php if (!empty($subjectsByStrand)): ?>
                        <?php foreach ($subjectsByStrand as $strandLabel => $subjects): ?>
                          <h6 class="mb-2">
                            📘 <strong>Semester:</strong> <?= htmlspecialchars($semLabel, ENT_QUOTES, 'UTF-8'); ?>
                            &nbsp;|&nbsp; <strong>Strand:</strong> <?= htmlspecialchars($strandLabel, ENT_QUOTES, 'UTF-8'); ?>
                          </h6>

                          <div class="table-responsive mb-4">
                            <table class="table table-bordered table-striped mb-0">
                          <thead class="thead-dark">
  <tr>
    <th style="width:26%;">Code</th>
    <th style="width:38%;">Description</th>
    <th style="width:12%;">Program</th>
    <th style="width:16%;">Subcategory</th>
    <th style="width:8%;" class="text-center">Manage</th>
  </tr>
</thead>

                              <tbody class="sortable"
                                     data-yearlevel="<?= htmlspecialchars($yearLevelKey, ENT_QUOTES, 'UTF-8'); ?>"
                                     data-sem="<?= htmlspecialchars($semLabel, ENT_QUOTES, 'UTF-8'); ?>"
                                     data-strand="<?= htmlspecialchars($strandLabel, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php foreach ($subjects as $row): ?>
                                  <tr data-id="<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>"
                                      data-original-sem="<?= htmlspecialchars($row->sem ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                   <td>
  <i class="fas fa-grip-vertical drag-handle mr-2" title="Drag to reorder"></i>
  <?= htmlspecialchars($row->subjectCode, ENT_QUOTES, 'UTF-8'); ?>
</td>
<td><?= htmlspecialchars($row->description, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?= htmlspecialchars($row->course, ENT_QUOTES, 'UTF-8'); ?></td>
<td><?= htmlspecialchars($row->subCategory ?? 'None', ENT_QUOTES, 'UTF-8'); ?></td>
<td class="text-center">
                                      <button
                                        type="button"
                                        class="btn btn-info btn-sm"
                                      onclick="editSubject(
  '<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>',
  '<?= htmlspecialchars($row->subjectCode, ENT_QUOTES, 'UTF-8'); ?>',
  '<?= htmlspecialchars($row->description, ENT_QUOTES, 'UTF-8'); ?>',
  '<?= htmlspecialchars($row->yearLevel, ENT_QUOTES, 'UTF-8'); ?>',
  '<?= htmlspecialchars($row->course, ENT_QUOTES, 'UTF-8'); ?>',
  '<?= htmlspecialchars($row->sem ?? '', ENT_QUOTES, 'UTF-8'); ?>',
  '<?= htmlspecialchars($row->strand ?? '', ENT_QUOTES, 'UTF-8'); ?>',
  '<?= htmlspecialchars($row->subCategory ?? 'None', ENT_QUOTES, 'UTF-8'); ?>'
)"
>
                                        <i class="mdi mdi-square-edit-outline"></i> Edit
                                      </button>

                                      <a href="#"
                                         class="btn btn-danger btn-sm"
                                         data-toggle="modal"
                                         data-target="#confirmDeleteModal"
                                         onclick="setDeleteUrl('<?= base_url('Settings/Deletesubject?id=' . urlencode($row->id)); ?>')">
                                         Delete
                                      </a>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>

                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="alert alert-info">No subjects found.</div>
          <?php endif; ?>
        </div>

      </div>
    </div>

    <?php include('includes/footer.php'); ?>
  </div>
</div>

<!-- Styles for drag handle -->
<style>
  .drag-handle { cursor: move; }
</style>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="<?= base_url('Settings/Subjects'); ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add New Subject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

        <div class="modal-body">
          <div class="form-row">
            <div class="col-md-8 mb-3">
              <label for="Course">Program</label>
              <select class="form-control select2" id="Course" name="course" required>
                <option disabled selected>Select Program</option>
                <?php foreach ($course as $row): ?>
                  <option value="<?= htmlspecialchars($row->CourseDescription, ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars($row->CourseDescription, ENT_QUOTES, 'UTF-8'); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="YearLevel">Grade Level</label>
              <select class="form-control select2" id="YearLevel" name="yearLevel" required>
                <option disabled selected>Select Grade Level</option>
              </select>
            </div>
          </div>
<div class="form-row">
  <div class="col-md-4 mb-3">
    <label for="addSem">Semester</label>
    <select class="form-control" id="addSem" name="sem" disabled>
      <option disabled selected>Select Semester</option>
      <option value="First Semester">First Semester</option>
      <option value="Second Semester">Second Semester</option>
      <option value="Both Semesters">Both Semesters</option>
    </select>
  </div>

  <div class="col-md-4 mb-3">
    <label for="addStrand">Strand</label>
    <?php $strandList = $this->Common->no_cond('track_strand'); ?>
    <select class="form-control select2" id="addStrand" name="strand" disabled>
      <option disabled selected>Select Strand</option>
      <?php foreach ($strandList as $s): ?>
        <option value="<?= htmlspecialchars($s->strand, ENT_QUOTES, 'UTF-8'); ?>">
          <?= htmlspecialchars($s->strand, ENT_QUOTES, 'UTF-8'); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-4 mb-3">
    <label for="addSubCat">Subcategory (optional)</label>
    <select class="form-control select2" id="addSubCat" name="subCategory" disabled>
      <option value="None" selected>None</option>
      <option value="Core Subjects">Core Subjects</option>
      <option value="Applied Subject/s">Applied Subject/s</option>
      <option value="Specialized Subject">Specialized Subject</option>
    </select>
  </div>
</div>

          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="subjectCode">Subject Code</label>
              <input type="text" class="form-control" id="subjectCode" name="subjectCode" required>
            </div>
            <div class="col-md-8 mb-3">
              <label for="description">Description</label>
              <input type="text" class="form-control" id="description" name="description" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="submit" name="save" value="Submit" class="btn btn-primary" />
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="<?= base_url('Settings/updatesubjects'); ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Update Subject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="editid" name="id">

          <div class="form-row">
            <div class="col-md-8 mb-3">
              <label for="editCourse">Program</label>
              <select class="form-control select2" id="editCourse" name="course" required>
                <option disabled selected>Select Program</option>
                <?php foreach ($course as $row): ?>
                  <option value="<?= htmlspecialchars($row->CourseDescription, ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars($row->CourseDescription, ENT_QUOTES, 'UTF-8'); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="editYearLevel">Grade Level</label>
              <select class="form-control select2" id="editYearLevel" name="yearLevel" required>
                <option disabled selected>Select Grade Level</option>
              </select>
            </div>
          </div>

        <div class="form-row">
  <div class="col-md-4 mb-3">
    <label for="editSem">Semester</label>
    <select class="form-control" id="editSem" name="sem" disabled>
      <option disabled selected>Select Semester</option>
      <option value="First Semester">First Semester</option>
      <option value="Second Semester">Second Semester</option>
      <option value="Both Semesters">Both Semesters</option>
    </select>
  </div>

  <div class="col-md-4 mb-3">
    <label for="editStrand">Strand</label>
    <?php $strandList2 = $this->Common->no_cond('track_strand'); ?>
    <select class="form-control select2" id="editStrand" name="strand" disabled>
      <option disabled selected>Select Strand</option>
      <?php foreach ($strandList2 as $s): ?>
        <option value="<?= htmlspecialchars($s->strand, ENT_QUOTES, 'UTF-8'); ?>">
          <?= htmlspecialchars($s->strand, ENT_QUOTES, 'UTF-8'); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-4 mb-3">
    <label for="editSubCat">Subcategory (optional)</label>
    <select class="form-control select2" id="editSubCat" name="subCategory" disabled>
      <option value="None">None</option>
      <option value="Core Subjects">Core Subjects</option>
      <option value="Applied Subject/s">Applied Subject/s</option>
      <option value="Specialized Subject">Specialized Subject</option>
    </select>
  </div>
</div>


          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="editSubjectCode">Subject Code</label>
              <input type="text" class="form-control" id="editSubjectCode" name="subjectCode" required>
            </div>
            <div class="col-md-8 mb-3">
              <label for="editDescription">Description</label>
              <input type="text" class="form-control" id="editDescription" name="description" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="submit" name="update" value="Update Data" class="btn btn-primary" />
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Confirmation -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteLabel">Delete Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body text-center">
        <div class="d-inline-flex justify-content-center align-items-center"
             style="width:100px;height:100px;border:4px solid #dc3545;border-radius:50%;">
          <span class="h1 text-danger mb-0">!</span>
        </div>
        <p class="mt-3 mb-0">Are you sure you want to delete this subject?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="#" id="deleteButton" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<!-- Vendor / Plugins -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<!-- If your template doesn't already include these, keep them; otherwise you can remove duplicates -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<script>
(function ($) {
  "use strict";

  // ---------- Utilities ----------
  function setAddShsRequired(on) {
    $('#addSem, #addStrand').prop('required', on).prop('disabled', !on);
  }
  function setEditShsRequired(on) {
    $('#editSem, #editStrand').prop('required', on).prop('disabled', !on);
  }
function toggleSHS(containerId, courseVal, mode) {
  const isSHS = (courseVal === 'Senior High School');
  $('#' + containerId).toggle(isSHS);
  (mode === 'add') ? setAddShsRequired(isSHS) : setEditShsRequired(isSHS);

  // handle subCategory enable/disable (never required)
  const $sub = (mode === 'add') ? $('#addSubCat') : $('#editSubCat');
  $sub.prop('disabled', !isSHS).trigger('change.select2');
  if (!isSHS) $sub.val('None').trigger('change');
}

  // Normalize "Grade 07" == "GRADE 7" == "grade7"
  function normLevel(s) {
    return (s || '').toString().trim().toLowerCase()
      .replace(/\s+/g, '')
      .replace(/^grade/, '')
      .replace(/^0+/, '');
  }

  // Load grade levels (aka majors) for a course and preselect
  function loadGradeLevels($select, course, selected) {
    return $.ajax({
      url: '<?= base_url("Accounting/getMajorsByCourse"); ?>',
      type: 'POST',
      data: { CourseDescription: course },
      dataType: 'json'
    }).then(function (data) {
      $select.empty().append('<option disabled selected>Select Grade Level</option>');
      const target = normLevel(selected);
      let matched = false;

      $.each(data || [], function (_, m) {
        const val = (m.Major || '').trim();
        const isMatch = target && normLevel(val) === target;
        $select.append('<option value="' + $('<div>').text(val).html() + '"' + (isMatch ? ' selected' : '') + '>' +
                       $('<div>').text(val).html() + '</option>');
        if (isMatch) matched = true;
      });

      if (!matched) {
        const $first = $select.find('option:not([disabled])').first();
        if ($first.length) $first.prop('selected', true);
      }
    });
  }

  // ---------- Edit Subject (opens modal) ----------
window.editSubject = function (id, subjectCode, description, yearLevel, course, sem, strand, subCategory) {
    $('#editid').val(id);
    $('#editSubjectCode').val(subjectCode);
    $('#editDescription').val(description);
    $('#editCourse').val(course).trigger('change.select2'); // DO NOT trigger 'change' (would reload twice)

    toggleSHS('editseniorHighDiv', course, 'edit');

  loadGradeLevels($('#editYearLevel'), course, yearLevel).done(function () {
  if (course === 'Senior High School') {
    $('#editSem').val(sem || 'First Semester');
    $('#editStrand').val(strand || '').trigger('change.select2');
    $('#editSubCat').val(subCategory || 'None').trigger('change');
  } else {
    setEditShsRequired(false);
    $('#editSem').val('');
    $('#editStrand').val('').trigger('change.select2');
    $('#editSubCat').val('None').trigger('change');
  }
  $('#editModal').modal('show');
}).fail(function () {
  alert('Failed to load grade levels.');
});

  };

  // ---------- Delete ----------
  window.setDeleteUrl = function (url) {
    $('#deleteButton').attr('href', url);
  };

  // ---------- Ready ----------
  $(function () {
    // Select2
    $('.select2').select2({ width: '100%' });

    // ADD: Course change -> toggle SHS & load year levels
    $('#Course').on('change', function () {
      const cv = $(this).val();
      toggleSHS('seniorHighDiv', cv, 'add');
      loadGradeLevels($('#YearLevel'), cv, null);
    });

    // EDIT: When user manually changes Program in the modal
    $('#editCourse').on('change', function () {
      const cv = $(this).val();
      toggleSHS('editseniorHighDiv', cv, 'edit');
      loadGradeLevels($('#editYearLevel'), cv, null).fail(function () {
        alert('Failed to load grade levels.');
      });
    });

    // Guard on Edit submit
    $('#editModal form').on('submit', function (e) {
      const course = $('#editCourse').val();
      const isSHS = (course === 'Senior High School');
      setEditShsRequired(isSHS);

      if (!$('#editYearLevel').val()) {
        e.preventDefault();
        alert('Please select Grade Level.');
        return;
      }
      if (isSHS && (!$('#editSem').val() || !$('#editStrand').val())) {
        e.preventDefault();
        alert('Please select Semester and Strand.');
        return;
      }
    });

    // jQuery UI Sortable -> send order as [{id, displayOrder, sem}]
    $('.sortable').sortable({
      handle: '.drag-handle',
      update: function () {
        const $tb = $(this);
        const payload = [];
        $tb.children('tr').each(function (idx) {
          const rowSem = $(this).data('originalSem') || $tb.data('sem');
          payload.push({
            id: $(this).data('id'),
            displayOrder: idx + 1,
            sem: rowSem
          });
        });

        $.post('<?= base_url('Settings/updateDisplayOrder'); ?>', {
          order: payload,
          yearLevel: $tb.data('yearlevel'),
          sem: $tb.data('sem'),
          strand: $tb.data('strand')
        }).done(function (res) {
          let j = {};
          try { j = JSON.parse(res); } catch (e) {}
          if (!j || j.status !== 'success') {
            alert("Unable to save new order" + (j && j.message ? (": " + j.message) : '.'));
          }
        }).fail(function () {
          alert("Error saving new order.");
        });
      }
    });
  });
})(jQuery);
</script>
</body>
</html>
