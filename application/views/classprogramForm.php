<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar -->
        <?php include('includes/top-nav-bar.php'); ?>

        <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>

        <!-- Page Content -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <h4 class="page-title">CLASS PROGRAM <br />
                                    <span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy'); ?> <?php echo $this->session->userdata('semester'); ?></span>
                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item">
                                            <a href="#"></a>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="<?= base_url('Settings/classprogramform'); ?>">
                                        <input type="hidden" name="SY" value="<?= $this->session->userdata('sy'); ?>" required readonly />
                                        <div class="form-row align-items-center">
    <!-- Grade Level -->
    <div class="col-md-6 mb-3 grade-section">
        <label for="YearLevel">Grade Level</label>
        <select name="YearLevel" id="YearLevel" class="form-control select2" required>
            <option value="">Year Level</option>
            <?php foreach ($sub3 as $level): ?>
                <option value="<?= $level->yearLevel; ?>">
                    <?= $level->yearLevel; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Strand (Hidden by Default) -->
    <div class="col-md-3 mb-3 strand-container" style="display: none;">
        <label for="strand">Strand</label>
        <select name="strand" id="strand" class="form-control select2">
            <option selected disabled>Select Strand</option>
             <?php foreach ($strandSub as $strand): ?>
                <option value="<?= $strand->strand; ?>">
                    <?= $strand->strand; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Semester (Hidden by Default) -->
    <div class="col-md-3 mb-3 sem-container" style="display: none;">
        <label for="sem">Semester</label>
        <select class="form-control" name="sem">
            <option value="">Select Semester</option>
            <option value="First Semester">First Semester</option>
            <option value="Second Semester">Second Semester</option>
            <option value="Summer">Summer</option>
        </select>
    </div>

    <!-- Section -->
    <div class="col-md-6 mb-3 section-container">
        <label for="Section">Section</label>
        <select class="form-control select2" name="Section" id="Section" style="width: 100%;" required>
            <option value="">Select Section</option>
            <!-- Options will be populated dynamically -->
        </select>
    </div>
</div>


                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                                                <thead>
                                                                    <tr>
                                                                        <!-- <th>Year Level</th> -->
                                                                        <th>Subject Code</th>
                                                                        <th>Description</th>
                                                                        <!-- <th>Course</th> -->
                                                                        <th>Teacher</th>
                                                                        <!-- <th>Section</th> -->
                                                                        <!-- <th>Time In</th>
                <th>Time Out</th> -->
                                                                        <th>Class Schedule</th>
                                                                        <!-- <th>Subject Status</th> -->


                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php if (!empty($data)): ?>
                                                                        <?php foreach ($data as $subject): ?>
                                                                            <!-- <tr data-id="<?= $subject->id; ?>"> -->
                                                                            <!-- <td><?= $subject->YearLevel; ?></td> -->
                                                                            <td><?= $subject->SubjectCode; ?></td>
                                                                            <td><?= $subject->Description; ?></td>
                                                                            <td>
                                                                                <select class="form-control select2 adviser-select" name="IDNumber" style="width:100%;">
                                                                                    <option value="">Select Adviser</option>
                                                                                    <?php foreach ($staff as $level): ?>
                                                                                        <option value="<?= $level->IDNumber; ?>"
                                                                                            <?= $subject->Adviser == $level->IDNumber ? 'selected' : ''; ?>>
                                                                                            <?= $level->FirstName . ' ' . $level->MiddleName . ' ' . $level->LastName; ?>
                                                                                        </option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </td>



                                                                            <!-- <td> <input type="time" class="form-control" id="Time1" name="Time1"></td>
                        <td> <input type="time" class="form-control" id="Time2" name="Time2"></td> -->
                                                                            <td>
                                                                                <input type="text" class="form-control" id="Days1" name="SchedTime" style="width:100%;">
                                                                            </td>
                                                                            <!-- <td>
                        <select name="SubjectStatus" id="SubjectStatus" class="form-control">
                                <option value="Open">Open</option>
                                <option value="Close">Close</option>
                            </select>   
                        </td> -->

                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <tr>
                                                                            <td colspan="5" class="text-center">No subjects found for the selected year level.</td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                            <button id="save-button" class="btn btn-primary waves-effect waves-light" style="margin-top: 20px; float: right;">Save</button>
                                                        </div>

                                                        <!-- end .table-responsive-->
                                                    </div>
                                                    <!-- end card-body -->
                                                </div>
                                                <!-- end card -->
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div> <!-- content -->
        </div> <!-- content-page -->

        <!-- Footer -->
        <?php include('includes/footer.php'); ?>

        <!-- Right Sidebar -->
        <?php include('includes/themecustomizer.php'); ?>

    </div> <!-- wrapper -->

    <!-- Vendor Scripts -->
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
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

    <!-- Table Editable plugin-->
    <script src="<?= base_url(); ?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

    <!-- Table editable init-->
    <script src="<?= base_url(); ?>assets/js/pages/tabledit.init.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

    <!-- Initialize Select2 -->
    <script>
    $(document).ready(function () {
  $('.select2').select2();

  const yearLevelDropdown = $('#YearLevel');
  const strandContainer   = $('.strand-container');
  const semContainer      = $('.sem-container');
  const strandDropdown    = $('#strand');     // preloaded from PHP: $strandSub
  const sectionDropdown   = $('#Section');
  const semDropdown       = $('select[name="sem"]');
  const tbody             = $('#inline-editable tbody');

  function isSHS(yearLevel) {
    // true for Grade 11 or Grade 12 (accepts 11/12 or "Grade 11/12")
    return /(Grade\s*)?(11|12)$|^11$|^12$/i.test(yearLevel || '');
  }

  function resetDropdowns(except = []) {
    // Keep strand options; just reset selection when needed
    if (!except.includes('strand')) {
      strandDropdown.val('').trigger('change'); // keep options preloaded
    }
    if (!except.includes('section')) {
      sectionDropdown.empty().append('<option value="">Select Section</option>');
    }
    tbody.html('<tr><td colspan="4" class="text-center">Please select options above.</td></tr>');
  }

  // Year Level change: only show/hide Strand+Sem and load sections
  yearLevelDropdown.on('change', function () {
    const yearLevel = $(this).val();
    const shs = isSHS(yearLevel);

    strandContainer.toggle(shs);
    semContainer.toggle(shs);

    // layout swap
    $('.grade-section, .section-container')
      .removeClass('col-md-3 col-md-6')
      .addClass(shs ? 'col-md-3' : 'col-md-6');

    resetDropdowns(shs ? ['strand'] : []); // keep current strand options, just clear selection

    if (!yearLevel) return;

    // Always reload sections for the selected year level
    fetchSections(yearLevel);

    if (shs) {
      // Wait for both Strand and Sem before fetching subjects
      tbody.html('<tr><td colspan="4" class="text-center">Select Strand and Semester.</td></tr>');
    } else {
      // Non-SHS: fetch subjects immediately
      fetchSubjects({ yearLevel });
    }
  });

  // For SHS: fetch subjects only when BOTH Strand and Sem are selected
  $('#strand, select[name="sem"]').on('change', function () {
    const yearLevel = yearLevelDropdown.val();
    const strand    = strandDropdown.val();
    const sem       = semDropdown.val();

    if (isSHS(yearLevel)) {
      if (!strand || !sem) return;
      fetchSubjects({ yearLevel, strand, sem });
    } else {
      // Non-SHS safety (usually handled in year level change)
      fetchSubjects({ yearLevel });
    }
  });

        // Fetch sections by YearLevel
        function fetchSections(yearLevel) {
            $.ajax({
                url: '<?= base_url("Settings/getSectionsByYearLevel"); ?>',
                type: 'POST',
                data: { yearLevel },
                dataType: 'json',
                success: function (data) {
                    sectionDropdown.empty().append('<option value="">Select Section</option>');
                    if (data.length > 0) {
                        $.each(data, function (index, section) {
                            sectionDropdown.append(`<option value="${section.Section}">${section.Section}</option>`);
                        });
                    } else {
                        sectionDropdown.append('<option disabled>No sections available</option>');
                    }
                },
                error: function () {
                    alert('Error loading sections.');
                }
            });
        }

        // Fetch semesters by YearLevel
       

        // Fetch subjects by YearLevel, Strand, and Semester
        function fetchSubjects(filters) {
            $.ajax({
                url: '<?= base_url("Settings/getSubjects"); ?>',
                type: 'POST',
                data: filters,
                dataType: 'json',
                success: function (data) {
                    renderSubjectsTable(data);
                },
                error: function () {
                    alert('Error retrieving subjects.');
                }
            });
        }

        // Render subjects table
        function renderSubjectsTable(data) {
            tbody.empty();
            if (data.length > 0) {
                $.each(data, function (index, subject) {
                    tbody.append(`
                        <tr data-id="${subject.id}">
                            <td class="editable subject-code">${subject.subjectCode}</td>
                            <td class="editable description">${subject.description}</td>
                            <td class="editable">
                                <select class="form-control select2 adviser-select" name="adviser" style="width:100%;">
                                    ${generateAdviserOptions(subject.Adviser)}
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="SchedTime[${subject.id}]">
                            </td>
                        </tr>
                    `);
                });
                $('.select2').select2(); // Reinitialize Select2 for new rows
            } else {
                tbody.append('<tr><td colspan="4" class="text-center">No subjects found.</td></tr>');
            }
        }

        function generateAdviserOptions(selectedAdviser) {
    let options = `<option value="TBA" ${!selectedAdviser || selectedAdviser === 'TBA' ? 'selected' : ''}>Select Teacher</option>`;
    
    <?php foreach ($staff as $level): ?>
        options += `<option value="<?= $level->IDNumber; ?>" ` +
            (selectedAdviser == '<?= $level->IDNumber; ?>' ? 'selected' : '') +
            `><?= $level->FirstName . ' ' . $level->MiddleName . ' ' . $level->LastName; ?></option>`;
    <?php endforeach; ?>
    
    return options;
}

     $('#save-button').on('click', function () {
        event.preventDefault(); // Prevent form submission
    var subjectsData = [];
    var schoolYear = $('input[name="SY"]').val();
    var yearLevel = $('#YearLevel').val();
    var strand = $('#strand').val(); // Correct selector
    var Semester = $('select[name="sem"]').val(); // Correct selector for Semester

    $('#inline-editable tbody tr').each(function () {
        var id = $(this).data('id');
        var subjectCode = $(this).find('.subject-code').text();
        var description = $(this).find('.description').text();
        var adviser = $(this).find('select[name="adviser"]').val();
        var section = $('#Section').val();
        var daysOfClass = $(this).find(`input[name="SchedTime[${id}]"]`).val();

        subjectsData.push({
            yearLevel: yearLevel,
            subjectCode: subjectCode,
            description: description,
            adviser: adviser,
            section: section,
            daysOfClass: daysOfClass,
            strand: strand,
            Semester: Semester
        });
    });

    // Send data to the server
    $.ajax({
        url: '<?= base_url("Settings/insertclass"); ?>',
        type: 'POST',
        data: { subjects: subjectsData, SY: schoolYear },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                alert('Class program saved successfully! Redirecting...');
                // Redirect using the URL provided in the response
                window.location.href = response.redirect_url;
            } else {
                alert('Error:\n' + response.messages.join('\n'));
                window.location.href = response.redirect_url;
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            alert('Error saving class program: ' + error);
            window.location.href = response.redirect_url;
        }
    });
});

    });
</script>








</body>

</html>