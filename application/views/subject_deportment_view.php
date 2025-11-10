<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<head>
  <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
  <style>
    /* Custom Select2 Styling */
    .select2-container--default .select2-selection--single {
      height: 40px; 
      padding: 5px 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      font-size: 14px;
      background-color: #f8f9fa;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 30px;
      color: #495057;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 32px;
      right: 10px;
    }

    .select2-results__option {
      font-size: 14px;
      padding: 10px;
    }

    .select2-results__option--highlighted {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>
<!-- Begin page -->
<div id="wrapper">
  <!-- Topbar Start -->
  <?php include('includes/top-nav-bar.php'); ?>
  <!-- Left Sidebar Start -->
  <?php include('includes/sidebar.php'); ?>
  <!-- Left Sidebar End -->





            <!-- Start Page Content here -->
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
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

                <!-- start page title -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title-box">
                            <h4 class="page-title">
 <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addDeportmentModal">
          Add Deportment
        </button>                            </h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb p-0 m-0">
                                    <li class="breadcrumb-item">
                                        <a href="#"></a>
                                    </li>
                                </ol>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- start row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-left">
                                        <h5 style="text-transform:uppercase">
                                            <strong>DEPORTMENT</strong>
                                            <br /><span class="badge badge-purple mb-3">SY <?php echo $this->session->userdata('sy');?> <?php echo $this->session->userdata('semester');?></span>
                                        </h5>
                                    </div>
        <!-- Deportments Table -->
        <div class="table-responsive">
          <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
              <tr>
                <th>Subject Code</th>
                <th>Description</th>
                <th>Year Level</th>
                <th style="text-align:center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($deportments as $deportment): ?>
                <tr>
                  <td><?= html_escape($deportment->subjectCode); ?></td>
                  <td><?= html_escape($deportment->description); ?></td>
                  <td><?= html_escape($deportment->yearLevel); ?></td>
                  <td style="text-align:center">
                    <a href="<?= base_url('SubjectDeportment/delete/'.$deportment->id); ?>" 
                       class="btn btn-danger btn-xs" 
                       onclick="return confirm('Are you sure you want to delete this deportment?');">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
                         </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Add Deportment Modal -->
<div id="addDeportmentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addDeportmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form method="post" action="<?= base_url('SubjectDeportment/add'); ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="addDeportmentModalLabel">Add Subject Deportment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <!-- SUBJECT ONLY (value = subjects.id) -->
          <div class="form-group">
            <label for="subject_id">Subject</label>
            <select id="subject_id" name="subject_id" class="form-control select2" required>
              <option value="">Select Subject</option>
              <?php foreach ($subjects as $subject): ?>
                <option value="<?= (int)$subject->id; ?>">
                  <?= html_escape($subject->subjectCode) . ' — ' . html_escape($subject->description) . ' (' . html_escape($subject->yearLevel) . ')'; ?>
                </option>
              <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">
              Pick the exact subject entry (code + year level).
            </small>
          </div>

          <!-- No Year Level select; it will be derived from the chosen subject -->

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Deportment</button>
        </div>
      </form>
    </div>
  </div>
</div>



      </div>
    </div>
  </div>

  <!-- Footer Start -->
  <?php include('includes/footer.php'); ?>
</div>

<?php include('includes/themecustomizer.php'); ?>

<!-- Vendor JS -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<!-- Select2 JS -->
<script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

<!-- Datatables init -->
<script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

<!-- Initialize Select2 -->
<script>
$(document).ready(function() {
  $('.select2').select2();
});
</script>

</body>
</html>
