<!DOCTYPE html>
<html lang="en">

<style>
    /* Base Styling */
    body,
    .card,
    .table {
        font-family: Arial, sans-serif;
        line-height: 1.5;
        color: black;
    }

    img {
        display: none;
    }

    .print-statement-heading {
        display: none;
    }

    .statement-heading {
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Print Styling */
    @media print {

        body,
        .card,
        .table {
            background-color: white !important;
            width: 100%;
        }

        .table th,
        .table td {
            font-size: 12px;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .card-header {
            background-color: white;
            border-bottom: 2px solid #000;
            padding: 10px;
        }

        @page {
            size: A4;
            margin: 0.5in;
        }

        .align {
            text-align: center;
            font-size: 22px;
            margin-top: 20px;
        }

        .print-only {
            display: block !important;
            text-align: center;
        }

        .no-print,
        .btn,
        .card-footer,
        .clearfix {
            display: none !important;
        }

        .breadcrumb,
        .page-title-right {
            background-color: white;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        img {
            display: none;
        }

        .print-statement-heading {
            display: block !important;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
        }

        .print-column {
            display: inline-block;
            vertical-align: top;
            width: 48%;
        }

        .print-column table {
            width: 100%;
        }


        #tyrone {
            display: inline-block;
            vertical-align: top;
            width: 48%;
        }

        #tyrone table {
            width: 100%;
        }



        #edong {
            display: inline-block;
            vertical-align: top;
            width: 48%;
        }

        #edong table {
            width: 100%;
        }
    }

    /* Hide Print Button on Print View */
    .print {
        display: none;
    }
</style>

<?php include('includes/head.php'); ?>

<body>
    <div id="wrapper">
        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <img class="print-only" src="<?= base_url(); ?>upload/banners/<?php echo $letterhead[0]->letterhead_web; ?>"
                    alt="mySRMS Portal" width="100%">
                <strong class="print-statement-heading">STATEMENT OF ACCOUNT</strong>



                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-box">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <h4><?php echo $data1[0]->SchoolName; ?>
                                                <br><small><?php echo $data1[0]->SchoolAddress; ?></small>
                                            </h4>

                                            <?php if ($this->session->flashdata('msg')): ?>
                                                <div class="alert alert-<?= $this->session->flashdata('msg_type') ?: 'info' ?> alert-dismissible fade show" role="alert">
                                                    <?= $this->session->flashdata('msg') ?>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                        <div class="float-right">
                                            <h5 class="statement-heading">STATEMENT OF ACCOUNT
                                                <br><small><?php echo $this->session->userdata('semester'); ?>
                                                    SY <?php echo $this->session->userdata('sy'); ?></small>
                                            </h5>
                                        </div>
                                    </div>

                                    <?php if ($data) { ?>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <address class="float-left">
                                                    <p>Name: <strong><?php echo $data[0]->FirstName . ' ' . $data[0]->MiddleName . ' ' . $data[0]->LastName; ?></strong></p>
                                                    <p>Student Number: <?php echo $data[0]->StudentNumber; ?></p>
                                                    <p>Year Level: <?php echo $data[0]->YearLevel; ?></p>
                                                </address>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <!-- <div class="print-column"> -->
                                            <div class="col-md-6" id="tyrone">
                                                <h4><b>Miscellaneous and Other Fees</b></h4>
                                                <table class="table mt-2">
                                                    <?php foreach ($data as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $row->FeesDesc; ?></td>
                                                            <td style="text-align: right;"><?php echo number_format($row->FeesAmount, 2); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>


                                            <!-- <div class="print-column"> -->
                                            <div class="col-md-6" id="edong">
                                                <h4><b>SUMMARY</b></h4>
                                                <table class="table mt-2">
                                                    <tr>
                                                        <td>Misc. and Other Fees Total</td>
                                                        <td style="text-align: right;"><b><?php echo number_format($data[0]->TotalFees, 2); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Additional Fees</td>

                                                        <td style="text-align: right;"><b><a href="<?= base_url(); ?>page/studeAdditional?studentno=<?php echo $data[0]->StudentNumber; ?>&sem=<?php echo $this->session->userdata('semester'); ?>&sy=<?php echo $this->session->userdata('sy'); ?>" target="_blank"><?php echo number_format($data[0]->addFees, 2); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Account</td>
                                                        <td style="text-align: right;"><b><?php echo number_format($data[0]->AcctTotal, 2); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Discount</td>
                                                        <td style="text-align: right;"><a href="<?= base_url(); ?>page/studeDiscounts?studentno=<?php echo $data[0]->StudentNumber; ?>&sem=<?php echo $this->session->userdata('semester'); ?>&sy=<?php echo $this->session->userdata('sy'); ?>" target="_blank">
                                                                <b><?php echo number_format($data[0]->Discount, 2); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Payments</td>
                                                        <!-- <td style="text-align: right;"><b><?php echo number_format($data[0]->TotalPayments, 2); ?></b></td> -->
                                                        <td style="text-align: right;"><a href="<?= base_url(); ?>page/studepayments?studentno=<?php echo $data[0]->StudentNumber; ?>&sem=<?php echo $this->session->userdata('semester'); ?>&sy=<?php echo $this->session->userdata('sy'); ?>" target="_blank">
                                                                <?php echo number_format($data[0]->TotalPayments, 2); ?>
                                                            </a></td>
                                                    </tr>
                                                </table>
                                                <h4 class="text-right">Current Balance: <?php echo number_format($data[0]->CurrentBalance, 2); ?></h4>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="d-print-none">
                                        <div class="float-right">
                                            <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light mr-1">
                                                <i class="fa fa-print"></i> Print
                                            </a>

                                            <a href="<?= base_url('Accounting/sendStatementEmail?id=' . $data[0]->StudentNumber); ?>" class="btn btn-info mr-2">
                                                <i class="fa fa-envelope"></i> Email Statement
                                            </a>

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
    </div>

    <?php include('includes/themecustomizer.php'); ?>

    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/moment/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/jquery.chat.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/jquery.todo.js"></script>
    <script src="<?= base_url(); ?>assets/libs/morris-js/morris.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/raphael/raphael.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>
</body>

</html>