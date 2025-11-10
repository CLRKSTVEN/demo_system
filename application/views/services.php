<!DOCTYPE html>
<html lang="en">
    <head>
	<link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />


    </head>
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
                                
                                <h4 class="page-title">
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Add New</button>

                                </h4>
                                
                                <div class="page-title-right">
                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="#"></a></li>
                                    </ol>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>

                        <?php if ($this->session->flashdata('success')) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <?= $this->session->flashdata('success'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('danger')) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <?= $this->session->flashdata('danger'); ?>
                                    </div>
                                <?php endif; ?>

                    <div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Card Header -->
            <div class="card-header bg-info py-3 text-white">
                <strong>PAYMENTS - SERVICES</strong>
                
                <!-- Hidden Fields for Date Filters -->
                <form method="get" action="<?= base_url('Accounting/printServices'); ?>" target="_blank" class="btn btn-secondary waves-effect waves-light btn-sm" style="float: right;">
                    <input type="hidden" name="fromDate" value="<?= isset($_GET['fromDate']) ? $_GET['fromDate'] : ''; ?>">
                    <input type="hidden" name="toDate" value="<?= isset($_GET['toDate']) ? $_GET['toDate'] : ''; ?>">
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="fa fa-print"></i> Print
                    </button>
                </form>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="clearfix">

                    <!-- Filter Form -->
                    <div class="row">
                        <div class="col-md-12">
                            <form method="get" action="<?= base_url('Accounting/services'); ?>">
                                <div class="form-row">
                                    <!-- From Date Field -->
                                    <div class="col-md-3">
                                        <label for="fromDate">From Date</label>
                                        <input type="date" class="form-control" id="fromDate" name="fromDate" value="<?= isset($_GET['fromDate']) ? $_GET['fromDate'] : '' ?>" required>
                                    </div>

                                    <!-- To Date Field -->
                                    <div class="col-md-3">
                                        <label for="toDate">To Date</label>
                                        <input type="date" class="form-control" id="toDate" name="toDate" value="<?= isset($_GET['toDate']) ? $_GET['toDate'] : '' ?>" required>
                                    </div>

                                    <!-- Filter Button -->
                                    <div class="col-md-3 align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>

                   <!-- Payment Table -->
            <div class="col-md-12">
            <div class="card">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                    <thead>
                                <tr>
                                    <th>Payor</th>
                                    <th>Description</th>
                                    <th style="text-align: right;">Amount</th>
                                    <th style="text-align: center;">O.R. No.</th>
                                    <th style="text-align: center;">Date</th>
                                </tr>
                            </thead>
    

                                                <tbody>
                                                    <?php foreach ($data as $row) { ?>
                                                    <tr>
                                                        <td>
    <?php
        if (!empty($row->FirstName)) {
            echo $row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName;
        } else {
            echo $row->manualPayor; // fallback if not a student
        }
    ?>
</td>

                                                        <td><?= $row->description; ?></td>
                                                        <td style="text-align: right;"><?= number_format($row->Amount,2) ; ?></td>
                                                        <td style="text-align: center;"><?= $row->ORNumber; ?></td>
                                                        <td style="text-align: center;"><?= $row->PDate; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>

                                        </div>
                                        
                                        <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success py-3 text-white">
                                <STRong>SUMMARY</STRong>
                                  <!-- Add Print Button -->
                <form method="get" action="<?= base_url('Accounting/printSummary'); ?>" target="_blank" class="btn btn-secondary waves-effect waves-light btn-sm" style="float: right;">
                    <input type="hidden" name="fromDate" value="<?= isset($_GET['fromDate']) ? $_GET['fromDate'] : ''; ?>">
                    <input type="hidden" name="toDate" value="<?= isset($_GET['toDate']) ? $_GET['toDate'] : ''; ?>">
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="fa fa-print"></i> Print
                    </button>
                </form>

                                </div>
                                
                                <div class="card-body">
                                    <div class="clearfix">
                
             

                <!-- Summary Table -->
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="sumbody">
                        <?php if (!empty($summary) && is_array($summary)): ?>
                            <?php foreach ($summary as $row): ?>
                                <tr>
                                    <td><?= $row['description']; ?></td>
                                    <td>
                                        <a href="<?= base_url('Accounting/paymentList?description=' . $row['description'] . '&CollectionSource=Services'); ?>" class="btn btn-primary">
                                            <?= number_format($row['total_amount'], 2); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" style="text-align: center;">No summary data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Summary Section -->


                    
                    <!-- End Summary Section -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="<?= base_url('Accounting/services'); ?>">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="myLargeModalLabel">Add New Service Payment</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
        </div>

        <div class="modal-body">

          <!-- SECTION: Payor Information -->
          <h6 class="text-muted mb-3">Payor Information</h6>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="PayorType">Payor Type <span class="text-danger">*</span></label>
              <select class="form-control" id="PayorType" name="PayorType" onchange="togglePayorType()" required>
                <option disabled selected>Select Type</option>
                <option value="student">Student</option>
                <option value="others">Others</option>
              </select>
            </div>
          </div>

          <div class="form-row" id="studentDropdown" style="display:none;">
            <div class="col-md-12 mb-3">
              <label for="StudentNumber">Select Student</label>
              <select class="form-control select2" id="StudentNumber" name="StudentNumber">
                <option disabled selected></option>
                <?php foreach ($prof as $row): ?>
                  <option value="<?= $row->StudentNumber; ?>">
                    <?= $row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-row" id="otherPayor" style="display:none;">
            <div class="col-md-12 mb-3">
              <label for="ManualPayor">Manual Payor Name</label>
              <input type="text" class="form-control" id="ManualPayor" name="ManualPayor">
            </div>
          </div>

          <input type="hidden" id="Course" name="Course" class="form-control" readonly>

          <!-- SECTION: Payment Details -->
          <hr>
          <h6 class="text-muted mb-3">Payment Details</h6>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="PaymentType">Payment Type</label>
              <select class="form-control" id="PaymentType" name="PaymentType">
                <option value="Cash">Cash</option>
                <option value="Check">Check</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ORNumber">O.R. Number</label>
              <input type="text" class="form-control" id="ORNumber" name="ORNumber" value="<?= $newORSuggestion; ?>" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="PDate">Payment Date</label>
              <input type="date" class="form-control" id="PDate" name="PDate" value="<?= date('Y-m-d'); ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="CheckNumber">Check Number</label>
              <input type="text" class="form-control" id="CheckNumber" name="CheckNumber">
            </div>
            <div class="col-md-6 mb-3">
              <label for="Bank">Bank</label>
              <input type="text" class="form-control" id="Bank" name="Bank">
            </div>
          </div>

          <!-- SECTION: Descriptions -->
          <hr>
          <h6 class="text-muted mb-3">Payment Descriptions</h6>
          <hr>
          <div class="form-row align-items-center">
            <div class="col-md-6 mb-3">
              <label for="descType">Description Mode</label>
              <select class="form-control" id="descType">
                <!-- <option disabled selected>Select Mode</option> -->
                <option value="select">Select from List</option>
                <option value="manual">Manual Entry</option>
              </select>
            </div>
            <div class="col-md-6 mb-3 d-flex justify-content-end align-items-end">
              <button type="button" class="btn btn-success" onclick="addDescriptionRow()">+ Add Description</button>
            </div>
          </div>

          <!-- Dynamic Description Rows -->
          <div id="descriptionRowsContainer"></div>

          <!-- Hidden Meta -->
          <input type="hidden" name="SY" value="<?= $this->session->userdata('sy'); ?>">
          <input type="hidden" name="Cashier" value="<?= $this->session->userdata('username'); ?>">
          <input type="hidden" name="CollectionSource" value="Services">
          <input type="hidden" name="ORStatus" value="Valid">
        </div>

        <div class="modal-footer">
          <input type="submit" name="save" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>







                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
        <?php include('includes/themecustomizer.php'); ?>
    </div>
        <!-- Vendor js -->
        <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

        <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

        <!-- Chat app -->
        <script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>

        <!-- Todo app -->
        <script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>

        <!--Morris Chart-->
        <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>

        <!-- Sparkline charts -->
        <script src="<?= base_url(); ?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Dashboard init JS -->
        <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

        <!-- Required datatable js -->
        <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/pdfmake/pdfmake.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/pdfmake/vfs_fonts.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/buttons.html5.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/buttons.print.min.js"></script>
		<script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!-- Responsive examples -->
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>

        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.select.min.js"></script>

        <!-- Datatables init -->
        <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>

         <!-- Select2 JS -->
    <script src="<?= base_url(); ?>assets/libs/select2/select2.min.js"></script>

<!-- App js -->
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<!-- Initialize Select2 -->
<script>
let rowIndex = 0;

function togglePayorType() {
  const type = document.getElementById("PayorType").value;
  document.getElementById("studentDropdown").style.display = (type === 'student') ? 'block' : 'none';
  document.getElementById("otherPayor").style.display = (type === 'others') ? 'block' : 'none';
}

function addDescriptionRow() {
  const mode = document.getElementById("descType").value;
  if (!mode) {
    alert("Please select a Description Mode first.");
    return;
  }

  const container = document.getElementById("descriptionRowsContainer");

  const row = document.createElement("div");
  row.classList.add("form-row", "align-items-center", "mb-2");
  row.setAttribute("id", `descRow-${rowIndex}`);

  row.innerHTML = `
    <div class="col-md-6 mb-1">
      ${mode === 'select'
        ? `<select name="description[]" class="form-control select2" required>
              <option disabled selected>Select Description</option>
              <?php foreach ($description as $row) { ?>
                <option value="<?= $row->description; ?>"><?= $row->description; ?></option>
              <?php } ?>
          </select>`
        : `<input type="text" name="description[]" class="form-control" placeholder="Enter Description" required>`}
    </div>
    <div class="col-md-4 mb-1">
      <input type="number" name="amount[]" class="form-control" placeholder="Amount" required>
    </div>
    <div class="col-md-2 mb-1 text-right">
      <button type="button" class="btn btn-danger btn-sm" onclick="removeDescriptionRow(${rowIndex})"><i class="fa fa-trash"></i></button>
    </div>
  `;

  container.appendChild(row);
  rowIndex++;

  $('.select2').select2();
}

function removeDescriptionRow(index) {
  const row = document.getElementById(`descRow-${index}`);
  if (row) row.remove();
}
</script>


		
		
    </body>
</html>