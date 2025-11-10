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

        <!-- Flash -->
        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <!-- Page title -->
        <div class="row">
          <div class="col-md-12">
            <div class="page-title-box">
              <h4 class="page-title">
                <a href="<?= base_url(); ?>Settings/classprogramform">
                  <button type="button" class="btn btn-info waves-effect waves-light">
                    <i class="fas fa-stream mr-1"></i> <span>Add New</span>
                  </button>
                </a>
              </h4>
              <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                  <li class="breadcrumb-item">
                    <span class="badge badge-purple mb-3">
                      SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?>
                    </span>
                  </li>
                </ol>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>

        <!-- Card -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">

                <div class="clearfix mb-2">
                  <div class="float-left">
                    <h5 class="text-uppercase mb-0"><strong>Class Program</strong></h5>
                    <small class="text-muted">
                      Active: SY <?= $this->session->userdata('sy'); ?> <?= $this->session->userdata('semester'); ?>
                    </small>
                  </div>
                </div>

                <!-- Filter form -->
                <form method="post" action="<?= base_url('Settings/ClassProgram'); ?>">
                  <div class="row">
                    <!-- Year Level (dynamic) -->
                    <div class="col-md-6" id="yearLevelContainer">
                      <div class="form-group">
                        <label for="YearLevel">Year Level</label>
                        <select name="YearLevel" id="YearLevel" class="form-control select2" onchange="handleYearLevelChange()">
                          <option value="">All Year Levels</option>
                          <!-- populated via loadYearLevels() -->
                        </select>
                      </div>
                    </div>

                    <!-- Section (dynamic) -->
                    <div class="col-md-6" id="sectionContainer">
                      <div class="form-group">
                        <label for="Section">Section</label>
                        <select name="Section" id="Section" class="form-control select2">
                          <option value="">All Sections</option>
                          <!-- populated via loadSections() -->
                        </select>
                      </div>
                    </div>

                    <!-- SHS-only: Strand (dynamic) -->
                    <div class="col-md-6" id="strandContainer" style="display:none;">
                      <div class="form-group">
                        <label for="Strand">Strand</label>
                        <select name="Strand" id="Strand" class="form-control select2">
                          <option value="">Select Strand</option>
                          <!-- populated via loadStrands() for G11/G12 -->
                        </select>
                      </div>
                    </div>

                    <!-- SHS-only: Semester -->
                    <div class="col-md-6" id="semesterContainer" style="display:none;">
                      <div class="form-group">
                        <label for="Semester">Semester</label>
                        <select name="Semester" id="Semester" class="form-control select2">
                          <option value="">Select Semester</option>
                          <option value="First Semester"  <?= isset($selectedSemester) && $selectedSemester === 'First Semester' ? 'selected' : '' ?>>First Semester</option>
                          <option value="Second Semester" <?= isset($selectedSemester) && $selectedSemester === 'Second Semester' ? 'selected' : '' ?>>Second Semester</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <!-- OnlyAssigned + Actions -->
                  <div class="row align-items-center">
                    <div class="col-md-6">
                      <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="1" id="onlyAssigned" name="onlyAssigned"
                          <?= !empty($this->input->post('onlyAssigned')) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="onlyAssigned">
                          Only show subjects with assigned teacher
                        </label>
                      </div>
                    </div>
                    <div class="col-md-6 text-right mb-3">
                      <button type="submit" class="btn btn-primary">Apply Filters</button>

                      <?php
                        $yl = isset($selectedYearLevel) ? $selectedYearLevel : '';
                        $st = isset($selectedStrand) ? $selectedStrand : '';
                        $sm = isset($selectedSemester) ? $selectedSemester : '';
                        $sc = isset($selectedSection) ? $selectedSection : '';
                      ?>
                      <a
                        href="<?= base_url('Settings/printClassProgram?YearLevel=' . urlencode($yl)
                          . '&Strand=' . urlencode($st)
                          . '&Semester=' . urlencode($sm)
                          . '&Section=' . urlencode($sc)
                          . '&withTeacher=1') ?>"
                        target="_blank"
                        class="btn btn-outline-secondary ml-2">🖨️ Print Class Program</a>
                    </div>
                  </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                  <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width:100%;">
                    <thead>
                      <tr>
                        <th>Year Level</th>
                        <th>Sub. Code</th>
                        <th>Description</th>
                        <th>Teacher</th>
                        <th>Section</th>
                        <th>Sched. Time</th>
                        <th>Strand</th>
                        <th>Semester</th>
                        <th style="text-align:center">Manage</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($data)): foreach ($data as $row): ?>
                        <tr>
                          <td><?= ($row->YearLevel && $row->YearLevel !== '0') ? htmlspecialchars($row->YearLevel) : '-' ?></td>
                          <td><?= ($row->SubjectCode && $row->SubjectCode !== '0') ? htmlspecialchars($row->SubjectCode) : '-' ?></td>
                          <td><?= ($row->Description && $row->Description !== '0') ? htmlspecialchars($row->Description) : '-' ?></td>
                          <td><?= ($row->Fullname && trim($row->Fullname) !== '') ? htmlspecialchars($row->Fullname) : '-' ?></td>
                          <td><?= ($row->Section && $row->Section !== '0') ? htmlspecialchars($row->Section) : '-' ?></td>
                          <td><?= ($row->SchedTime && $row->SchedTime !== '0') ? htmlspecialchars($row->SchedTime) : '-' ?></td>
                          <td><?= (!empty($row->Strand)   && $row->Strand   !== '0') ? htmlspecialchars($row->Strand)   : '-' ?></td>
                          <td><?= (!empty($row->Semester) && $row->Semester !== '0') ? htmlspecialchars($row->Semester) : '-' ?></td>
                          <td class="text-center">
                            <a href="<?= base_url('Settings/updateClassProgram?subjectid=' . urlencode($row->subjectid)); ?>"
                               class="btn btn-primary waves-effect waves-light btn-sm">
                              <i class="mdi mdi-pencil"></i> Edit
                            </a>
                            <a href="#"
                               onclick="setDeleteUrl('<?= base_url('Settings/DeleteClass?subjectid=' . urlencode($row->subjectid)); ?>')"
                               data-toggle="modal" data-target="#confirmationModal"
                               class="btn btn-danger waves-effect waves-light btn-sm">
                              <i class="ion ion-ios-alert"></i> Delete
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; endif; ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div class="text-center">
                  <div class="circle-with-stroke d-inline-flex justify-content-center align-items-center">
                    <span class="h1 text-danger">!</span>
                  </div>
                  <p class="mt-3">Are you sure you want to delete this data?</p>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="deleteButton" class="btn btn-danger" onclick="deleteData()">Delete</a>
              </div>
            </div>
          </div>
        </div>

        <style>
          .circle-with-stroke{width:100px;height:100px;border:4px solid #dc3545;border-radius:50%}
        </style>

      </div> <!-- /container-fluid -->
    </div> <!-- /content -->

    <?php include('includes/footer.php'); ?>
  </div> <!-- /content-page -->
</div> <!-- /wrapper -->

<?php include('includes/themecustomizer.php'); ?>

<!-- Vendor & libs -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<!-- DataTables (no page-level datatables.init.js to avoid double init) -->
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

<script>
  // ===== Helpers =====
  function setDeleteUrl(url){ document.getElementById('deleteButton').href = url; }
  function deleteData(){ /* anchor performs delete */ }

  $(document).ready(function(){
    $('.select2').select2();
    ensureDataTable(); // guarded init to prevent reinitialise error
  });

  // Guarded DataTable init (prevents "Cannot reinitialise DataTable" warning)
  let dtInstance = null;
  function ensureDataTable() {
    if ($.fn.DataTable.isDataTable('#datatable')) {
      dtInstance = $('#datatable').DataTable();
      return;
    }
    dtInstance = $('#datatable').DataTable({
      pageLength: 25,
      order: [[0, 'asc']],
      responsive: true
    });
  }

  // ===== Dynamic Filters =====
  function isSHSLevel(y) {
    if (!y) return false;
    const s = (''+y).toLowerCase();
    return s.includes('grade 11') || s.includes('grade 12') || s === '11' || s === '12';
  }

  function handleYearLevelChange() {
    const yearLevel = document.getElementById("YearLevel").value;
    const strandContainer = document.getElementById("strandContainer");
    const semesterContainer = document.getElementById("semesterContainer");

    if (isSHSLevel(yearLevel)) {
      strandContainer.style.display = "block";
      semesterContainer.style.display = "block";
      loadStrands(yearLevel);
    } else {
      strandContainer.style.display = "none";
      semesterContainer.style.display = "none";
      document.getElementById("Strand").innerHTML = "<option value=''>Select Strand</option>";
      $('#Semester').val('').trigger('change');
    }
    loadSections(yearLevel);
  }

  function loadYearLevels() {
    fetch("<?= base_url('Settings/getYearLevels') ?>")
      .then(r => r.json())
      .then(rows => {
        const sel = document.getElementById("YearLevel");
        const selected = "<?= $selectedYearLevel ?? '' ?>";
        sel.innerHTML = "<option value=''>All Year Levels</option>";
        (rows || []).forEach(r => {
          const yl = (r.YearLevel || '').trim();
          if (yl && yl !== '0') {
            const opt = document.createElement('option');
            opt.value = yl;
            opt.textContent = yl;
            if (selected === yl) opt.selected = true;
            sel.appendChild(opt);
          }
        });
        // After load, cascade
        handleYearLevelChange();
      })
      .catch(err => console.error('YearLevels load error:', err));
  }

  function loadSections(yearLevel) {
    const params = new URLSearchParams();
    params.set('YearLevel', yearLevel || '');
    fetch("<?= base_url('Settings/getSections') ?>", {
      method: "POST",
      headers: {"Content-Type": "application/x-www-form-urlencoded"},
      body: params.toString()
    })
    .then(r => r.json())
    .then(rows => {
      const sectionSelect = document.getElementById("Section");
      const selectedSection = "<?= $selectedSection ?? '' ?>";
      sectionSelect.innerHTML = "<option value=''>All Sections</option>";
      (rows || []).forEach(s => {
        const sec = (s.Section || '').trim();
        if (sec && sec !== '0') {
          const opt = document.createElement('option');
          opt.value = sec;
          opt.textContent = sec;
          if (selectedSection === sec) opt.selected = true;
          sectionSelect.appendChild(opt);
        }
      });
      $('#Section').trigger('change.select2');
    })
    .catch(err => console.error("Section load error:", err));
  }

  function loadStrands(yearLevel) {
    const params = new URLSearchParams();
    params.set('YearLevel', yearLevel || '');
    fetch("<?= base_url('Settings/getStrands') ?>", {
      method: "POST",
      headers: {"Content-Type": "application/x-www-form-urlencoded"},
      body: params.toString()
    })
    .then(r => r.json())
    .then(rows => {
      const strandSelect = document.getElementById("Strand");
      const selectedStrand = "<?= $selectedStrand ?? '' ?>";
      strandSelect.innerHTML = "<option value=''>Select Strand</option>";
      (rows || []).forEach(s => {
        const st = (s.Strand || '').trim();
        if (st && st !== '0') {
          const opt = document.createElement('option');
          opt.value = st;
          opt.textContent = st;
          if (selectedStrand === st) opt.selected = true;
          strandSelect.appendChild(opt);
        }
      });
      $('#Strand').trigger('change.select2');
    })
    .catch(err => console.error("Strand load error:", err));
  }

  // On load: get YearLevels (cascades to sections/strands)
  document.addEventListener('DOMContentLoaded', function () {
    loadYearLevels();
  });
</script>
</body>
</html>
