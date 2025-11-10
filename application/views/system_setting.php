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

        <!-- Title -->
        <div class="row">
          <div class="col-md-12">
            <div class="page-title-box">
              <h4 class="page-title"><b>System Settings</b></h4>
              <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                  <li class="breadcrumb-item">Home</li>
                  <li class="breadcrumb-item active">System Settings</li>
                </ol>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>

        <!-- Flash -->
        <div class="row">
          <div class="col-md-12">
            <?php if ($this->session->flashdata('success')): ?>
              <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
              <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Card -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="header-title mb-4"><b>Update System Settings</b></h4>

                <style>
                  .settings-section + .settings-section { margin-top: 1.25rem; }
                  .btn-toggle-group .btn { min-width: 110px; }
                  .btn-toggle-group .btn.is-active {
                    color: #fff;
                  }
                  .btn-toggle-group[data-field="schoolType"] .btn.is-active {
                    background-color: #007bff; /* blue */
                  }
                  .btn-toggle-group[data-field="gradeDisplay"] .btn.is-active,
                  .btn-toggle-group[data-field="preschoolGrade"] .btn.is-active {
                    background-color: #28a745; /* green */
                  }
                </style>

                <!-- School Type -->
                <div class="settings-section">
                  <h5><b>School Type</b></h5>
                  <div class="btn-group btn-toggle-group" role="group" aria-label="School Type" data-field="schoolType">
                    <button type="button"
                            class="btn btn-outline-primary school-type-btn <?= ($settings['schoolType'] ?? '') === 'Public' ? 'is-active' : '' ?>"
                            data-type="Public">Public</button>
                    <button type="button"
                            class="btn btn-outline-primary school-type-btn <?= ($settings['schoolType'] ?? '') === 'Private' ? 'is-active' : '' ?>"
                            data-type="Private">Private</button>
                  </div>
                </div>

                <hr>

                <!-- Grade Display -->
                <div class="settings-section">
                  <h5><b>Grade Display</b></h5>
                  <div class="btn-group btn-toggle-group" role="group" aria-label="Grade Display" data-field="gradeDisplay">
                    <button type="button"
                            class="btn btn-outline-success grade-display-btn <?= ($settings['gradeDisplay'] ?? '') === 'Numeric' ? 'is-active' : '' ?>"
                            data-type="Numeric">Numeric</button>
                    <button type="button"
                            class="btn btn-outline-success grade-display-btn <?= ($settings['gradeDisplay'] ?? '') === 'Letter' ? 'is-active' : '' ?>"
                            data-type="Letter">Letter</button>
                  </div>
                </div>

                <hr>

                <!-- Preschool Grade -->
                <div class="settings-section">
                  <h5><b>Preschool Grade</b></h5>
                  <div class="btn-group btn-toggle-group" role="group" aria-label="Preschool Grade" data-field="preschoolGrade">
                    <button type="button"
                            class="btn btn-outline-success preschool-grade-btn <?= ($settings['preschoolGrade'] ?? '') === 'Numeric' ? 'is-active' : '' ?>"
                            data-type="Numeric">Numeric</button>
                    <button type="button"
                            class="btn btn-outline-success preschool-grade-btn <?= ($settings['preschoolGrade'] ?? '') === 'Letter' ? 'is-active' : '' ?>"
                            data-type="Letter">Letter</button>
                  </div>
                </div>

              </div><!--/card-body-->
            </div><!--/card-->
          </div>
        </div>

        <?php include('includes/footer.php'); ?>
      </div>

      <?php include('includes/themecustomizer.php'); ?>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {
  function sendUpdate(field, value, $btn){
    $.ajax({
      url: "<?= base_url('Page/system_setting_update') ?>",
      method: "POST",
      dataType: "json",
      data: { field: field, value: value },
      success: function(resp){
        if (resp && resp.ok) {
          // Toggle 'is-active' only inside this group
          var $group = $btn.closest('.btn-toggle-group');
          $group.find('.btn').removeClass('is-active');
          $btn.addClass('is-active');
        } else {
          alert("Update failed. Please try again.");
        }
      },
      error: function(){
        alert("Network error. Please try again.");
      }
    });
  }

  // One handler for all groups
  $('.btn-toggle-group .btn').on('click', function(){
    var $btn   = $(this);
    var value  = $btn.data('type');
    var field  = $btn.closest('.btn-toggle-group').data('field');
    sendUpdate(field, value, $btn);
  });
});
</script>
</body>
</html>
