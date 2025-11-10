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
                        <a href="<?= base_url(); ?>Page/add_medPatient1" class="btn btn-primary waves-effect waves-light">Add New</a>
                        <div class="clearfix"></div>
                        <br>
                        <div class="row">
                            <div class="col-12">

                            </div>
                        </div>
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
                            <h4 class="header-title mb-4">CONSULTATIONS
                                <span>
                                </span>
                            </h4><br />

                            <!-- Check if data exists -->
                            <div class="table-responsive">
    <table id="datatable" class="table table-bordered dt-responsive nowrap" 
           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Patient's Name</th>
                <th>Patient's Address</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Civil Status</th>
                <th>Height</th>
                <th>Weight</th>
                <th>Contact</th>
                <th>attachment</th>
                <th>BP</th>
                <th>Cardiac Rate</th>
                <th>Respiratory Rate</th>
                <th>Temperature</th>
                <th>O2 SAT</th>
                <th>Complaint</th>
                <th>Allergies</th>
                <th>Current Medication</th>
                <th>Physical Examination</th>
                <th>Diagnosis</th>
                <th>Treatment/Management</th>
                <th>Remarks</th>
                <th>Manage</th>
            </tr>
        </thead>
        <tbody>
    <?php 
    $user_sp = $this->session->userdata('sp'); 
    $logged_in_user = $this->session->userdata('username'); // Retrieve logged-in username

    foreach ($data as $row): 
        // If the user has an SP value greater than 0, check if their username exists in the med_patient table
        if ($user_sp > 0) {
            $this->db->where('username', $logged_in_user);
            $query = $this->db->get('med_patient');

            // If there's no match, skip this record
            if ($query->num_rows() == 0) {
                continue;
            }
        }

        // Display only Employee records
        if ($row->patientType == 'Student'): ?>
            <tr>
                <td><?= $row->FirstName . ' ' . $row->LastName ?></td>
                <td><?= $row->address ?></td>
                <td><?= $row->age ?></td>
                <td><?= $row->sex ?></td>
                <td><?= $row->cstat ?></td>
                <td><?= $row->height ?></td>
                <td><?= $row->weight ?></td>
                <td><?= $row->contact ?></td>
                <td style="text-align: center;">
                    <?php if (!empty($row->attachment)) : ?>
                        <a href="<?= base_url('uploads/med/' . $row->attachment) ?>" target="_blank">
                            <i class="fas fa-file-alt" style="font-size: 20px;"></i>
                        </a>
                    <?php endif; ?>
                </td>
                <td><?= $row->bp ?></td>
                <td><?= $row->cardiac ?></td>
                <td><?= $row->respiratory ?></td>
                <td><?= $row->temp ?></td>
                <td><?= $row->sat ?></td>
                <td><?= $row->complaint ?></td>
                <td><?= $row->allergies ?></td>
                <td><?= $row->current_med ?></td>
                <td><?= $row->phy_exam ?></td>
                <td><?= $row->diagnosis ?></td>
                <td><?= $row->treatment ?></td>
                <td><?= $row->remarks ?></td>
                <td>
                    <?php if ($user_sp == 0): ?>
                        <?php if ($row->consultationStat == 'Processed'): ?>
                            <a href="<?= base_url(); ?>Page/med_patient_report?medID=<?= $row->medID; ?>" class="text-success" target="_blank">
                                <i class="mdi mdi-certificate" data-toggle="tooltip" title="View Certificate"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/med_patient_reportv2?medID=<?= $row->medID; ?>" class="text-primary" target="_blank">
                                <i class="mdi mdi-file-document-outline" data-toggle="tooltip" title="View Certificate V2"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/med_patient_reportRX?medID=<?= $row->medID; ?>" class="text-danger" target="_blank">
                                <i class="mdi mdi-pill" data-toggle="tooltip" title="View RX"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/med_patient_abstract?medID=<?= $row->medID; ?>" class="text-primary" target="_blank">
                                <i class="mdi mdi-file-document" data-toggle="tooltip" title="View Medical Abstract"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/med_patient_update_student?medID=<?= $row->medID; ?>" class="text-primary" target="_blank">
                                <i class="mdi mdi-pencil-outline" data-toggle="tooltip" title="Update Consultation"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/delete_medpatient1?id=<?= $row->medID; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="text-danger">
                                <i class="mdi mdi-delete" data-toggle="tooltip" title="Delete Record"></i>
                            </a>
                        <?php else: ?>
                            <?php if ($row->consultationStat == 'Pending'): ?>
                                <a href="<?= base_url(); ?>Page/med_patient_update?medID=<?= $row->medID; ?>" class="text-warning font-weight-bold" target="_blank">
                                    <i class="mdi mdi-alert-circle-outline" data-toggle="tooltip" title="Pending Consultation"></i>
                                </a>
                            <?php endif; ?>
                            <a href="<?= base_url(); ?>Page/med_patient_update_student?medID=<?= $row->medID; ?>" class="text-primary" target="_blank">
                                <i class="mdi mdi-pencil-outline" data-toggle="tooltip" title="Update Consultation"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/delete_medpatient?id=<?= $row->medID; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="text-danger">
                                <i class="mdi mdi-delete" data-toggle="tooltip" title="Delete Record"></i>
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($row->consultationStat == 'Processed' && ($row->print_Perm == 'Yes' || empty($row->print_Perm))): ?>
                            <a href="<?= base_url(); ?>Page/med_patient_report?medID=<?= $row->medID; ?>" class="text-success" target="_blank">
                                <i class="mdi mdi-certificate" data-toggle="tooltip" title="View Certificate"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/med_patient_reportv2?medID=<?= $row->medID; ?>" class="text-primary" target="_blank">
                                <i class="mdi mdi-file-document-outline" data-toggle="tooltip" title="View Certificate V2"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/med_patient_reportRX?medID=<?= $row->medID; ?>" class="text-danger" target="_blank">
                                <i class="mdi mdi-pill" data-toggle="tooltip" title="View RX"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($row->consultationStat == 'Pending'): ?>
                            <?php if ($user_sp != 0): ?>
                                <span class="text-warning font-weight-bold">
                                    <i class="mdi mdi-alert-circle-outline" data-toggle="tooltip" title="Pending Consultation"></i>
                                </span>
                            <?php else: ?>
                                <a href="<?= base_url(); ?>Page/med_patient_update?medID=<?= $row->medID; ?>" class="text-warning font-weight-bold" target="_blank">
                                    <i class="mdi mdi-alert-circle-outline" data-toggle="tooltip" title="Pending Consultation"></i>
                                </a>
                            <?php endif; ?>
                         
                            <a href="<?= base_url(); ?>Page/med_patient_update_student?medID=<?= $row->medID; ?>" class="text-primary" target="_blank">
                                <i class="mdi mdi-pencil-outline" data-toggle="tooltip" title="Update Consultation"></i>
                            </a>
                            <a href="<?= base_url(); ?>Page/delete_medpatient?id=<?= $row->medID; ?>" onclick="return confirm('Are you sure you want to delete this record?')" class="text-danger">
                                <i class="mdi mdi-delete" data-toggle="tooltip" title="Delete Record"></i>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; // End Employee filter ?>
    <?php endforeach; ?>
</tbody>


    </table>
</div>

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
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!-- jQuery and Bootstrap JS -->

