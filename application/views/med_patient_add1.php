<?php include('templates/head.php'); ?>
<link href="<?= base_url(); ?>assets/libs/custombox/custombox.min.css" rel="stylesheet" type="text/css">


<?php include('templates/header.php'); ?>

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <style>
            .select2-container .select2-selection--single {
                height: calc(2.25rem + 2px) !important;
                /* Matches Bootstrap input height */
                border: 1px solid #ced4da !important;
                border-radius: .25rem !important;
                padding: .375rem .75rem !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 1.5 !important;
                color: #495057 !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: calc(2.25rem + 2px) !important;
            }
        </style>


        <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/select2/jquery.min.js"></script>
        <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />

        <script>
            $(document).ready(function() {
                $('.select2').select2(); // Initialize Select2

                // Fetch Employee details on selection
                $('#patientSelect').change(function() {
                    let selected = $(this).find(':selected');

                    // Retrieve selected employee data
                    let idNumber = selected.data('idnumber') || '';
                    let firstName = selected.data('firstname') || '';
                    let middleName = selected.data('middlename') || '';
                    let lastName = selected.data('lastname') || '';

                    // Populate input fields with selected employee details
                    $('#FirstName').val(firstName);
                    $('#MiddleName').val(middleName);
                    $('#LastName').val(lastName);
                    $('#IDNumber').val(idNumber);

                    if (idNumber) {
                        $.ajax({
                            url: '<?= base_url("Page/get_patient_history") ?>',
                            type: 'POST',
                            data: {
                                IDNumber: idNumber
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.history_count > 0) {
                                    $('#patientHistory').html(`Patient has <strong>${response.history_count}</strong> record(s) in history.`);
                                } else {
                                    $('#patientHistory').html('No history found.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching history:", error);
                                $('#patientHistory').html('Error retrieving history.');
                            }
                        });
                    }
                });
            });


            function formatDateTimeInManila() {
                const now = new Date();

                // Convert to Manila Time (UTC+8)
                const options = {
                    timeZone: "Asia/Manila",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                    hour: "numeric",
                    minute: "2-digit",
                    hour12: true
                };

                // Format datetime with "at"
                return new Intl.DateTimeFormat("en-US", options).format(now).replace(" at", ", at");
            }

            function formatDateInManila() {
                const now = new Date();

                // Convert to Manila Time (UTC+8)
                const options = {
                    timeZone: "Asia/Manila",
                    year: "numeric",
                    month: "long",
                    day: "numeric"
                };

                // Format date only
                return new Intl.DateTimeFormat("en-US", options).format(now);
            }

            document.getElementById("disposition_time").value = formatDateTimeInManila();
            document.getElementById("date").value = formatDateInManila();
        </script>



        <script type="text/javascript">
            function submitBday() {

                var Bdate = document.getElementById('bday').value;
                var Bday = +new Date(Bdate);
                Q4A = ~~((Date.now() - Bday) / (31557600000));
                var theBday = document.getElementById('resultBday');
                theBday.value = Q4A;
            }

            function submitForm(printPermission) {
                document.getElementById("printPermInput").value = printPermission;

                // Enable all form fields to ensure data is submitted
                $('input[name="FirstName"], input[name="MiddleName"], input[name="LastName"], input[name="IDNumber"], input[name="LRN"]').prop('disabled', false);

                console.log("Submitting form with print permission:", printPermission);
                console.log("First Name:", document.querySelector('input[name="FirstName"]').value);

                setTimeout(function() {
                    document.getElementById("medPatientForm").submit();
                }, 500);
            }
        </script>


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target=".bs-example-modal-lg">Add New</button> -->

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <?php if ($this->session->flashdata('success')) : ?>

                <?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>'
                    . $this->session->flashdata('success') .
                    '</div>';
                ?>
            <?php endif; ?>

            <?php if ($this->session->flashdata('danger')) : ?>
                <?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>'
                    . $this->session->flashdata('danger') .
                    '</div>';
                ?>
            <?php endif;  ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <h4 class="header-title mb-4">ADD CONSULATION<br /></h4><br />
                            <form method="post" action="<?= base_url('Page/add_medPatient1'); ?>" class="parsley-examples" enctype="multipart/form-data" id="medPatientForm">

                                <!-- <form method="post" action="<?php echo base_url('Page/add_medPatient'); ?>" class="parsley-examples" enctype="multipart/form-data"> -->


                                <!-- <form id="medPatientForm" method="post" action="<?php echo base_url('Page/add_medPatient'); ?>" class="parsley-examples" enctype="multipart/form-data"> -->


                                <div class="form-row">

                                    <input type="text" name="patientType" value="Student" hidden>
                                    <div class="form-group col-md-7">
                                        <label class="col-form-label font-weight-bold">ATTACHMENT</label>
                                        <input type="file" class="form-control" name="attachment">
                                    </div>


                                    <div class="col-md-5">
                                        <div class="card border-secondary shadow-sm">
                                            <div class="card-body">
                                                <h6 class="card-title text-secondary font-weight-bold">Patient History</h6>
                                                <p id="patientHistory" class="text-muted medium">No history found.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>





                                <!-- <div class="form-row" id="patientSelectContainer">
    <div class="form-group col-md-12">
        <label class="col-form-label">SELECT PATIENT</label>
        <select id="patientSelect" class="form-control select2" style="width: 100%;">
            <option value="">Select Patient</option>
            <?php foreach ($staff as $staff): ?>
                <option value="<?= $staff->IDNumber; ?>" 
                        data-idnumber="<?= $staff->IDNumber; ?>"
                        data-firstname="<?= $staff->FirstName; ?>"
                        data-middlename="<?= $staff->MiddleName; ?>"
                        data-lastname="<?= $staff->LastName; ?>">
                    <?= $staff->IDNumber; ?> - <?= $staff->FirstName; ?> <?= $staff->MiddleName; ?> <?= $staff->LastName; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div> -->

                                <input type="text" class="form-control" name="FirstName" id="FirstName" hidden>
                                <input type="text" class="form-control" name="MiddleName" id="MiddleName" hidden>
                                <input type="text" name="LastName" class="form-control" id="LastName" hidden>
                                <input type="text" name="IDNumber" id="IDNumber" hidden>
                                <input type="hidden" name="LRN" id="LRN" value="">


                                <div class="form-row">

                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">LRN</label>
                                        <input type="text" class="form-control" name="LRN" required>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">FIRST NAME</label>
                                        <input type="text" class="form-control" name="FirstName" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">MIDDLE NAME</label>
                                        <input type="text" class="form-control" name="MiddleName">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">LAST NAME</label>
                                        <input type="text" class="form-control" name="LastName" required>
                                    </div>

                                </div>



                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">DISTRICT</label>
                                        <select name="district" id="districts" class="form-control" required>
                                            <option value="">Select District</option>
                                            <?php foreach ($district as $d): ?>
                                                <option value="<?= $d->discription; ?>"><?= $d->discription; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">SCHOOL</label>
                                        <select name="school" id="school" class="form-control" required>
                                            <option value="">Select School</option>
                                        </select>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#districts').change(function() {
                                            let district = $(this).val();

                                            $('#school').empty().append('<option value="">Select School</option>'); // Reset schools

                                            if (district) {
                                                $.ajax({
                                                    url: '<?= base_url("Page/get_schools_by_district") ?>',
                                                    type: 'POST',
                                                    data: {
                                                        district: district
                                                    },
                                                    dataType: 'json',
                                                    success: function(response) {
                                                        $.each(response, function(index, item) {
                                                            $('#school').append(`<option value="${item.schoolName}">${item.schoolName}</option>`);
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>



                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">CONTACT NUMBER</label>
                                        <input type="text" class="form-control" name="contact">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">SEX</label>
                                        <select name="sex" class="form-control" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">BIRTH DATE</label>
                                        <input type="date" required id="bday" name="birthdate" class="form-control" onchange="submitBday()">
                                        <input type="text" readonly id="resultBday" name="age" class="form-control" hidden>
                                    </div>

                                    <script type="text/javascript">
                                        function submitBday() {
                                            var bdayInput = document.getElementById('bday').value;
                                            if (!bdayInput) return; // Prevent calculation if no date is selected

                                            var birthDate = new Date(bdayInput);
                                            var today = new Date();

                                            var age = today.getFullYear() - birthDate.getFullYear();
                                            var monthDiff = today.getMonth() - birthDate.getMonth();
                                            var dayDiff = today.getDate() - birthDate.getDate();

                                            // Adjust if birthday hasn't occurred yet this year
                                            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                                                age--;
                                            }

                                            document.getElementById('resultBday').value = age; // Display the calculated age
                                        }

                                        function submitForm(printPermission) {
                                            document.getElementById("printPermInput").value = printPermission;

                                            // Enable all form fields to ensure data is submitted
                                            $('input[name="FirstName"], input[name="MiddleName"], input[name="LastName"], input[name="IDNumber"], input[name="LRN"]').prop('disabled', false);

                                            console.log("Submitting form with print permission:", printPermission);
                                            console.log("First Name:", document.querySelector('input[name="FirstName"]').value);

                                            setTimeout(function() {
                                                document.getElementById("medPatientForm").submit();
                                            }, 500);
                                        }
                                    </script>



                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">ADDRESS</label>
                                        <input type="text" required name="address" class="form-control">
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">BP</label>
                                        <input type="text" class="form-control" required name="bp">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">CARDIAC RATE</label>
                                        <input type="text" class="form-control" name="cardiac">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">RESPIRATORY RATE</label>
                                        <input type="text" name="respiratory" class="form-control">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">TEMPERATURE</label>
                                        <input type="text" class="form-control" required name="temp">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">HEIGHT</label>
                                        <input type="text" class="form-control" name="height">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">WEIGHT</label>
                                        <input type="text" name="weight" class="form-control">
                                    </div>
                                </div>


                                <div class="form-row">

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">CIVIL STATUS</label>
                                        <select name="cstat" id="" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widow">Widow</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label class="col-form-label">02 SAT</label>
                                        <input type="text" class="form-control" name="sat">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">CHIEF COMPLAINT</label>
                                        <input type="text" required class="form-control" name="complaint">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">OTHER SYMPTOMS</label>
                                        <input type="text" class="form-control" name="others_symp">
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">ALLERGIES</label>
                                        <input type="text" name="allergies" class="form-control">
                                    </div>
                                </div>


                                <?php $user_sp = $this->session->userdata('sp'); ?>
                                <?php if ($user_sp == 0): ?>  <!-- Only show if sp is 0 -->

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="col-form-label">CATEGORY</label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select Category</option>
                                            <?php foreach ($category as $d): ?>
                                                <option value="<?= $d->category; ?>"><?= $d->category; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label class="col-form-label">DISEASE</label>
                                        <select name="disease" id="disease" class="form-control">
                                            <option value="">Select Disease</option>
                                          
                                        </select>
                                    </div>
                                    </div>




                                    <script>
$(document).ready(function() {
    $("#category").change(function() {
        var category = $(this).val();
        $.ajax({
            url: "<?= base_url('Page/getDiseasesByCategory'); ?>",
            type: "POST",
            data: { category: category },
            dataType: "json",
            success: function(data) {
                var diseaseSelect = $("#disease");
                diseaseSelect.empty().append('<option value="">Select Disease</option>');
                
                $.each(data, function(index, item) {
                    diseaseSelect.append('<option value="' + item.disease + '">' + item.disease + '</option>');
                });
            }
        });
    });
});
</script>




                                <div class="form-row">
                                    <div class="form-group col-md-7">
                                        <label class="col-form-label">CURRENT MEDICATION</label>
                                        <input type="text" class="form-control" name="current_med">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">DISPOSITION</label>
                                        <select name="disposition" class="form-control" required>
                                        <?php foreach ($disposition as $d): ?>
                                                <option value="<?= $d->disposition; ?>"><?= $d->disposition; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">REST REQUIRED(DAYS)</label>
                                        <input type="number" name="rest_no" class="form-control">
                                    </div>


                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">PURPOSE OF CONSULTATION</label>
                                        <input type="text" name="purpose" class="form-control">
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">HISTORY OF PRESENT ILLNESS</label>
                                        <textarea name="illness_history" class="form-control" rows="12"></textarea>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">PHYSICAL EXAM</label>
                                        <textarea name="phy_exam" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">DIAGNOSIS</label>
                                        <textarea name="diagnosis" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">TREATMENT/MANAGEMENT</label>
                                        <textarea name="treatment" class="form-control" rows="6"></textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="col-form-label">REMARKS</label>
                                        <textarea name="remarks" class="form-control" rows="6"></textarea>
                                    </div>
                                </div>
                                <?php endif; ?>


                                <input type="text" name="disposition_time" id="disposition_time" hidden>
                                <input type="text" name="appdate" id="date" hidden>
                                <input type="text" name="position" id="position" value="<?= $this->session->userdata('position'); ?>" hidden>
                                <input type="text" name="username" id="username" value="<?= $this->session->userdata('username'); ?>" hidden>


                        </div>

                        <?php $user_sp = $this->session->userdata('sp'); ?>

                        <!-- Form Start -->
                        <form method="post" enctype="multipart/form-data">

                            <!-- Hidden input to store the print permission value -->
                            <input type="hidden" id="printPermInput" name="print_Perm" value="">

                            <div class="modal-footer">
                                <?php if ($user_sp != 0): ?>
                                    <!-- If user_sp is not zero, show a direct submit button -->
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary waves-effect waves-light">
                                <?php else: ?>
                                    <!-- If user_sp is zero, show the modal-triggering button -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#printModal">
                                        Submit
                                    </button>
                                <?php endif; ?>
                            </div>

                            <?php if ($user_sp == 0): ?>
                                <!-- Print Permission Confirmation Modal (Only for users with sp = 0) -->
                                <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content shadow-md rounded-md">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title font-weight-bold" id="printModalLabel">
                                                    <i class="fas fa-print"></i> Confirm Printing Permission
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <i class="fas fa-question-circle fa-4x text-warning mb-3"></i>
                                                <p class="lead font-weight-bold">Do you allow the nurse to print this patient's record?</p>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-danger px-4 py-2" data-dismiss="modal">
                                                    <i class="fas fa-times"></i> Cancel
                                                </button>

                                                <!-- Yes Button -->
                                                <button type="button" class="btn btn-success px-4 py-2" onclick="submitForm('Yes')">
                                                    <i class="fas fa-check-circle"></i> Yes, Allow
                                                </button>

                                                <!-- No Button -->
                                                <button type="button" class="btn btn-secondary px-4 py-2" onclick="submitForm('No')">
                                                    <i class="fas fa-ban"></i> No, Deny
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </form>




                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div>
    <!-- end container-fluid -->

</div>
<!-- end content -->

<?php include('templates/footer.php'); ?>


<script>
    $(document).ready(function() {
        $('.select2').select2(); // Initialize Select2



        // Ensure Student Manual Input Fields Are Saved
        $('input[name="FirstName"], input[name="MiddleName"], input[name="LastName"], input[name="LRN"]').on('input', function() {
            $('#FirstName').val($('input[name="FirstName"]').val());
            $('#MiddleName').val($('input[name="MiddleName"]').val()); // Ensure MiddleName is updated
            $('#LastName').val($('input[name="LastName"]').val()); // Ensure LastName is updated
            $('#LRN').val($('input[name="LRN"]').val());
        });

        // Fetch Employee details on selection
        $('#patientSelect, input[name="LRN"]').on('change keyup', function() {
            let selected = $('#patientSelect').find(':selected');
            let idNumber = selected.data('idnumber') || '';
            let lrn = $('input[name="LRN"]').val().trim(); // Capture manual LRN

            $('input[name="FirstName"]').val(selected.data('firstname') || '');
            $('input[name="MiddleName"]').val(selected.data('middlename') || '');
            $('input[name="LastName"]').val(selected.data('lastname') || '');
            $('input[name="IDNumber"]').val(idNumber);

            $('#FirstName').val(selected.data('firstname') || '');
            $('#MiddleName').val(selected.data('middlename') || '');
            $('#LastName').val(selected.data('lastname') || '');
            $('#IDNumber').val(idNumber);

            if (idNumber || lrn) {
                $.ajax({
                    url: '<?= base_url("Page/get_patient_history") ?>',
                    type: 'POST',
                    data: {
                        IDNumber: idNumber,
                        LRN: lrn
                    }, // Ensure LRN is sent
                    dataType: 'json',
                    success: function(response) {
                        if (response.history_count > 0) {
                            let link = response.is_lrn ? 'count_consultation1' : 'count_consultation';
                            $('#patientHistory').html(`Patient has <a href='${link}?IDNumber=${idNumber}&LRN=${lrn}'><strong>${response.history_count}</strong> record(s) in history.</a>`);
                        } else {
                            $('#patientHistory').html('No history found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching history:", error);
                        $('#patientHistory').html('Error retrieving history.');
                    }
                });
            }
        });

        // Initialize Patient Type
        $('input[name="patientType"]:checked').trigger('change');
    });



    function formatDateTimeInManila() {
        const now = new Date();

        // Convert to Manila Time (UTC+8)
        const options = {
            timeZone: "Asia/Manila",
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "numeric",
            minute: "2-digit",
            hour12: true
        };

        // Format datetime with "at"
        return new Intl.DateTimeFormat("en-US", options).format(now).replace(" at", ", at");
    }

    function formatDateInManila() {
        const now = new Date();

        // Convert to Manila Time (UTC+8)
        const options = {
            timeZone: "Asia/Manila",
            year: "numeric",
            month: "long",
            day: "numeric"
        };

        // Format date only
        return new Intl.DateTimeFormat("en-US", options).format(now);
    }

    document.getElementById("disposition_time").value = formatDateTimeInManila();
    document.getElementById("date").value = formatDateInManila();
</script>