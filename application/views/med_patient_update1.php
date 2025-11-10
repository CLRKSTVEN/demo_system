<?php include('templates/head.php'); ?>
<link href="<?= base_url(); ?>assets/libs/custombox/custombox.min.css" rel="stylesheet" type="text/css">
<?php include('templates/header.php'); ?>

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

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
                            <h4 class="header-title mb-4">UPDATE CONSULATION<br /></h4><br />


                            <form method="post" enctype="multipart/form-data">
                         


<div class="form-row">

<div class="form-group col-md-12">
        <label class="col-form-label font-weight-bold">ATTACHMENT</label>
        <input type="file" class="form-control" name="attachment">
    </div>


<div class="form-group col-md-12">
<label class="col-form-label">SELECT PATIENT</label>
<select id="patientSelect" class="form-control select2" style="width: 100%;" disabled>
        <option value=""><?php echo $data[0]->FirstName; ?> <?php echo $data[0]->MiddleName; ?> <?php echo $data[0]->LastName; ?></option>
    </select>
</div>
</div>





<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/select2/jquery.min.js"></script>
<link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />




                                <div class="form-row">
                                <div class="form-group col-md-2">
                                <label class="col-form-label">CONTACT NUMBER</label>
                                <input type="text" class="form-control" name="contact" value="<?php echo $data[0]->contact; ?>" >
                                    </div>

                                    <div class="form-group col-md-2">
                                    <label class="col-form-label">SEX</label>

                                <select name="sex" class="form-control" >
                                    <option value="Male" <?php echo ($data[0]->sex == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($data[0]->sex == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                            <input type="hidden" name="sex" value="<?php echo $data[0]->sex; ?>">

                                    <div class="form-group col-md-2">
                                    <label class="col-form-label">BIRTH DATE</label>
                                    <input type="date" id="bday" name="birthdate" class="form-control" value="<?php echo $data[0]->birthdate; ?>" >
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label class="col-form-label">ADDRESS</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo $data[0]->address; ?>" >
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">BP</label>
                                        <input type="text" class="form-control" name="bp" value="<?php echo $data[0]->bp; ?>" >
                                    </div>
                                    <div class="form-group col-md-2">
                                    <label class="col-form-label">CARDIAC RATE</label>
                                    <input type="text" class="form-control" name="cardiac" value="<?php echo $data[0]->cardiac; ?>" >
                                    </div>
                                    <div class="form-group col-md-2">
                                    <label class="col-form-label">RESPIRATORY RATE</label>
                                    <input type="text" name="respiratory" class="form-control" value="<?php echo $data[0]->respiratory; ?>" >
                                    </div>

                                    <div class="form-group col-md-2">
                                    <label class="col-form-label">TEMPERATURE</label>
                                    <input type="text" class="form-control" name="temp" value="<?php echo $data[0]->temp; ?>" >
                                    </div>
                                    <div class="form-group col-md-2">
                                    <label class="col-form-label">HEIGHT</label>
                                    <input type="text" class="form-control" name="height" value="<?php echo $data[0]->height; ?>" >
                                    </div>
                                    <div class="form-group col-md-2">
                                    <label class="col-form-label">WEIGHT</label>
                                    <input type="text" name="weight" class="form-control" value="<?php echo $data[0]->weight; ?>" >
                                    </div>
                                </div>


                                <div class="form-row">

                                <div class="form-group col-md-2">
                                <label class="col-form-label">CIVIL STATUS</label>
                                <select name="cstat" class="form-control">
        <option value="">Select Status</option>
        <option value="Single" <?= ($data[0]->cstat == 'Single') ? 'selected' : ''; ?>>Single</option>
        <option value="Married" <?= ($data[0]->cstat == 'Married') ? 'selected' : ''; ?>>Married</option>
        <option value="Widow" <?= ($data[0]->cstat == 'Widow') ? 'selected' : ''; ?>>Widow</option>
    </select>
</div>

                                   
                                    <div class="form-group col-md-1">
                                        <label class="col-form-label">02 SAT</label>
                                        <input type="text" class="form-control" name="sat" value="<?php echo $data[0]->sat; ?>" >
                                    </div>
                                    <div class="form-group col-md-3">
                                    <label class="col-form-label">CHIEF COMPLAINT</label>
                                    <input type="text"  class="form-control" name="complaint" value="<?php echo $data[0]->complaint; ?>" >
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="col-form-label">OTHER SYMPTOMS</label>
                                        <input type="text" required class="form-control" name="others_symp" value="<?php echo $data[0]->others_symp; ?>" >
                                    </div>

                                    <div class="form-group col-md-3">
                                    <label class="col-form-label">ALLERGIES</label>
                                    <input type="text" name="allergies" class="form-control" value="<?php echo $data[0]->allergies; ?>" >
                                    </div>
                                </div>


                                <div class="form-row">
    <div class="form-group col-md-6">
    <label class="col-form-label">DISTRICT</label>
    <select name="district" id="districts" class="form-control" required>
            <option value="<?php echo $data[0]->school; ?>"><?php echo $data[0]->district; ?></option>
            <?php foreach ($district as $d): ?>
                <option value="<?= $d->discription; ?>"><?= $d->discription; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group col-md-6">
    <label class="col-form-label">SCHOOL</label>
    <select name="school" id="school" class="form-control" required>
            <option value="<?php echo $data[0]->school; ?>"><?php echo $data[0]->school; ?></option>
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
                data: { district: district },
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

<?php $user_sp = $this->session->userdata('sp'); ?>
                                <?php if ($user_sp == 0): ?>  <!-- Only show if sp is 0 -->


                                <div class="form-row">
                                    <div class="form-group col-md-7">
                                    <label class="col-form-label">CURRENT MEDICATION</label>
                                    <input type="text" class="form-control" name="current_med" value="<?php echo $data[0]->current_med; ?>" >
                                    </div>
                                    <div class="form-group col-md-3">
                                    <label class="col-form-label">DISPOSITION</label>
                                    <select name="disposition" class="form-control" >
                                            <option value="Treatment and Send Home" <?php echo ($data[0]->disposition == 'Treatment and Send Home') ? 'selected' : ''; ?>>Treatment and Send Home</option>
                                            <option value="Transferred/Referred" <?php echo ($data[0]->disposition == 'Transferred/Referred') ? 'selected' : ''; ?>>Transferred/Referred</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="disposition" value="<?php echo $data[0]->disposition; ?>">

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label">REST REQUIRED(DAYS)</label>
                                        <input type="number" name="rest_no" class="form-control" value="<?php echo $data[0]->rest_no; ?>" >
                                    </div>
                                </div>

                                


<div class="form-row">
                                
                                <div class="form-group col-md-12">
                                        <label class="col-form-label">PURPOSE OF CONSULTATION</label>
                                        <input type="text" name="purpose" class="form-control" value="<?php echo $data[0]->purpose; ?>" >
                                    </div>
                                    </div>

                                    <div class="form-row">
                                <div class="form-group col-md-12">
                                        <label class="col-form-label">HISTORY OF PRESENT ILLNESS</label>
                                        <textarea name="illness_history" class="form-control" rows="12"><?php echo htmlspecialchars($data[0]->illness_history); ?></textarea>
                                    </div>
                                </div>

                                <div class="form-row">
                        <div class="form-group col-md-6">
                        <label class="col-form-label">PHYSICAL EXAM</label>
                        <textarea name="phy_exam" class="form-control" rows="4" ><?php echo htmlspecialchars($data[0]->phy_exam); ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                        <label class="col-form-label">DIAGNOSIS</label>
                        <textarea name="diagnosis" class="form-control" rows="4" ><?php echo htmlspecialchars($data[0]->diagnosis); ?></textarea>
                        </div>
                    </div>

                    <div class="form-row">

                    <div class="form-group col-md-6">
                                        <label class="col-form-label">TREATMENT/MANAGEMENT</label>
                                        <textarea name="treatment" class="form-control" rows="6"><?php echo htmlspecialchars($data[0]->treatment); ?></textarea>
                                    </div>

                        <div class="form-group col-md-6">
                        <label class="col-form-label">REMARKS</label>
                        <textarea name="remarks" class="form-control" rows="6" ><?php echo htmlspecialchars($data[0]->remarks); ?></textarea>
                        </div>
                    </div>
                    <?php endif; ?>

                  
                                <input type="text" name="disposition_time" id="disposition_time" hidden>
                                <input type="text" name="appdate" id="date" hidden>
                                <input type="hidden" name="position"  value="<?php echo $data[0]->position; ?>">

                                <script>
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
        </script>
                        </div>
                        <div class="modal-footer">
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary waves-effect waves-light">                        </div>
                    </div>
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