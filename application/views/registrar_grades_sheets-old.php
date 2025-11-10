<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>

    <!-- Begin page -->
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
                    // Check if all students are Senior High
                    $allSeniorHigh = true;
                    foreach ($data as $row) {
                        if ($row->YearLevel !== 'Grade 11' && $row->YearLevel !== 'Grade 12') {
                            $allSeniorHigh = false;
                            break;
                        }
                    }

                    // Grade conversion function
                    function getLetterGrade($grade)
                    {
                        if ($grade === null || $grade === '') return '';
                        if ($grade >= 90) return 'A';
                        if ($grade >= 85) return 'B+';
                        if ($grade >= 80) return 'B';
                        if ($grade >= 75) return 'C';
                        return 'F';
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">

                                    <div class="float-left">
                                        <h4 class="m-t-0 header-title mb-1">
                                            <strong>REPORT OF GRADES</strong><br />
                                            <span class="badge badge-purple mb-1">SY <?= $this->session->userdata('sy'); ?></span>
                                        </h4>
                                        <table>
                                            <tr>
                                                <td>Subject Code</td>
                                                <td>: <b><?= $data[0]->SubjectCode; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td>: <b><?= $data[0]->Description; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Section</td>
                                                <td>: <b><?= $data[0]->Section; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Teacher</td>
                                                <td>: <b><?= $data[0]->Instructor; ?></b></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="float-right">
                                        <div class="d-print-none">
                                            <div class="float-right">
                                                <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <?= $this->session->flashdata('msg'); ?>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>STUDENT NAME</th>
                                                <th style="text-align: center;">1st Grading</th>
                                                <th style="text-align: center;">2nd Grading</th>
                                                <?php if (!$allSeniorHigh): ?>
                                                    <th style="text-align: center;">3rd Grading</th>
                                                    <th style="text-align: center;">4th Grading</th>
                                                <?php endif; ?>
                                                <th style="text-align: center;">Average</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $row):
                                                echo "<tr>";
                                                echo "<td>" . $i++ . "</td>";
                                                echo "<td>" . $row->LastName . ', ' . $row->FirstName . ' ' . $row->MiddleName . "</td>";

                                                if ($gradeDisplay === 'Letter') {
                                                    echo "<td style='text-align:center;'>" . getLetterGrade($row->PGrade) . "</td>";
                                                    echo "<td style='text-align:center;'>" . getLetterGrade($row->MGrade) . "</td>";
                                                    if (!$allSeniorHigh) {
                                                        echo "<td style='text-align:center;'>" . getLetterGrade($row->PFinalGrade) . "</td>";
                                                        echo "<td style='text-align:center;'>" . getLetterGrade($row->FGrade) . "</td>";
                                                    }
                                                    echo "<td style='text-align:center;'>" . getLetterGrade($row->Average) . "</td>";
                                                } else {
                                                    echo "<td style='text-align:center;'>" . number_format($row->PGrade, 2) . "</td>";
                                                    echo "<td style='text-align:center;'>" . number_format($row->MGrade, 2) . "</td>";
                                                    if (!$allSeniorHigh) {
                                                        echo "<td style='text-align:center;'>" . number_format($row->PFinalGrade, 2) . "</td>";
                                                        echo "<td style='text-align:center;'>" . number_format($row->FGrade, 2) . "</td>";
                                                    }
                                                    echo "<td style='text-align:center;'>" . number_format($row->Average, 2) . "</td>";
                                                }

                                                echo "</tr>";
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->

                </div> <!-- end container-fluid -->
            </div> <!-- end content -->

            <?php include('includes/footer.php'); ?>
        </div> <!-- end content-page -->

    </div> <!-- END wrapper -->

    <?php include('includes/themecustomizer.php'); ?>

    <!-- Vendor and App scripts -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
</body>

</html>