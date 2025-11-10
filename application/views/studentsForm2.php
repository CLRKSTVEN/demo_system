<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Enrollment / Payment Agreement</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      font-size: 12px;
      line-height: 1.4;
    }

    .page {
      width: 216mm;
      height: 330mm;
      padding-top: 0mm;
      padding-left: 20mm;
      padding-right: 20mm;
      padding-bottom: 0mm;
      margin: auto;
      box-sizing: border-box;
      position: relative;
    }

    .header-container {
      text-align: center;
      margin-bottom: 10px;
    }

    .header-img {
      width: 100%;
      max-height: 120px;
      object-fit: contain;
    }

    h2 {
      font-size: 16px;
      margin-bottom: 0;
    }

    h4 {
      margin: 5px 0;
      font-size: 14px;
      font-style: italic;
    }

    p,
    li {
      margin: 4px 0;
      text-align: justify;
    }

    .form-section {
      margin-bottom: 10px;
    }

    .indent {
      text-indent: 20px;
    }

    .signature-section {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .signature-section div {
      width: 30%;
      border-top: 1px solid #000;
      text-align: center;
      padding-top: 4px;
      font-size: 13px;
    }

    .footer {
      font-size: 11px;
      font-style: italic;
      text-align: left;
      margin-top: 25px;
    }

    ul,
    ol {
      margin: 4px 0 4px 25px;
      padding-left: 0;
    }

    .note {
      font-size: 12px;
      margin-left: 10px;
      font-style: italic;
    }
  </style>
</head>

<body>
  <div class="page">
    <header class="header-container">
      <?php if (!empty($letterhead) && !empty($letterhead[0]->letterhead_web)) : ?>
        <img class="header-img" src="<?= base_url('upload/banners/' . $letterhead[0]->letterhead_web); ?>" alt="Letterhead" />
      <?php endif; ?>
    </header>

    <div class="form-section">
      <h4 style="text-align:center;">ENROLLMENT / PAYMENT AGREEMENT<br>Basic Education Department <span style="font-style:normal;">Preschool to Grade 12</span></h4>
    </div>

    <div class="form-section">
      <p>
        <?php
        $name = !empty($data->Mother) ? $data->Mother
          : (!empty($data->Father) ? $data->Father
            : (!empty($data->Guardian) ? $data->Guardian
              : '____________________________'));
        ?>
        I, <strong><?= $name ?></strong>,

        parent/guardian of (Name of pupil/student)
        <strong><?= $data->LastName . ', ' . $data->FirstName . ' ' . $data->MiddleName ?? '____________________________' ?></strong>,
        Grade/level <strong><?= $data->YearLevel ?? '__________' ?></strong>,
        School Year <strong><?= $data->SY ?? '___________________' ?></strong>,
        hereby understand and commit to observe the following:
      </p>

      <ol>
        <li>I will purchase the complete set of textbooks for my child on or before <strong><?= $data->BookDeadline ?? '___________' ?></strong>.</li>
        <li>I will submit the <i>lacking (if ever there will be any)</i> required documents & ID picture listed in the ‘Enrolment Information’ within <strong>two (2) months of enrolment</strong>.</li>
        <li>I commit that I will attend all online/physically scheduled meetings.</li>
        <li>
          I understand that the progress card of my child will be released only on the scheduled date/s. If I fail to get the same on the scheduled date/s, I will request another appointment due to the observance of the limited number of visitors coming in to maintain physical distancing.
        </li>
        <li>
          I commit that I will guide and ensure that my child will observe proper school rules and regulations, and to see to it that my child will not be absent or late unless for medical or urgent reasons. I will inform directly to the offices of the Administrator and/or Principal should I have any concerns or suggestions about the schooling of my child.
        </li>
        <li>
          I will pay the school fees of my child, according to the following schedule:
          <ul>
            <li>Fees payable (Peso): Tuition <strong><?= $data->Tuition ?? '_________' ?></strong> + Misc. <strong><?= $data->Misc ?? '_________' ?></strong> = Total <strong><?= $data->Total ?? '_________' ?></strong></li>
            <li>LESS scholarship or discount amount:
              <ul>
                <li>○ ESC-FAPE: <strong><?= $data->ESC ?? '_________' ?></strong> &nbsp;&nbsp;&nbsp; * DepEd Voucher: <strong><?= $data->Voucher ?? '_________' ?></strong></li>
                <li>○ Other Scholarship: <strong><?= $data->OtherScholarship ?? '_________' ?></strong> &nbsp;&nbsp;&nbsp; * Sibling Discount: <strong><?= $data->SiblingDiscount ?? '_________' ?></strong></li>
              </ul>
            </li>
            <li>● Down Payment: <strong><?= $data->DownPayment ?? '_________' ?></strong> &nbsp;&nbsp;&nbsp; OR No.: <strong><?= $data->ORNumber ?? '_________' ?></strong> &nbsp;&nbsp;&nbsp; Date: <strong><?= $data->DownPaymentDate ?? '_________' ?></strong></li>
            <li>● Net Amount Payable: Total <strong><?= $data->NetPayable ?? '_________' ?></strong></li>
            <li>● Payment schedule: (amount) <strong><?= $data->MonthlyPay ?? '_________' ?></strong> every (date) <strong><?= $data->PayDate ?? '__' ?></strong> of the month, effective <strong><?= $data->StartMonth ?? '_________' ?></strong></li>
          </ul>
        </li>
        <li><strong>Note:</strong> I understand that this amount of school fees does not include the cost of textbooks, which have to be purchased and paid separately.</li>
        <li>I also understand that my child would not avail of Sibling Discount once my child avails of any scholarship grant.</li>
        <li>
          I understand that while Golden Link College is a non-profit institution, it must meet its budget to pay for its salaries and bills and hence I commit to adhere to the above payment schedule. To meet these requirements, I agree that:
          <ul type="a">
            <li>Readmission for subsequent school year and release of Progress card, Form 137, certificates, school clearance, and all documents related to my child’s enrollment will be done only upon settling the financial obligations with the school.</li>
            <li>
              Due to the fact of difficulty in regular collection of past years, a <strong>5% surcharge</strong> of the unpaid amount will be computed, for failure to pay on the scheduled date, mentioned above (or written on the registration form).<br>
              <strong>the school will provide a maximum of five (5) working days grace period</strong> to settle the amount due before applying the 5% surcharge.
            </li>
          </ul>
        </li>
        <li>
          A <strong>late enrollment fee of ₱500.00</strong> will be charged to those who will enroll after the announced last day of enrolment.
        </li>
      </ol>
    </div>

    <div class="signature-section">
      <div>Confirmed by the parent/guardian:</div>
      <div>Relationship:</div>
      <div>Date:</div>
    </div>

    <div class="signature-section" style="margin-top: 40px;">
      <div>Signature over the Printed name</div>
      <div></div>
      <div></div>
    </div>

    <div class="signature-section" style="margin-top: 40px;">
      <div>Approved by:</div>
      <div>Date Approved:</div>
      <div></div>
    </div>

    <div class="form-section" style="margin-top: 10px;">
      <p>School Administrator Here</p>
    </div>

    <div class="footer">
      <!-- Parent/ Guardian copy &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; School copy<br>
      Payment – enrollment agreement &nbsp;&nbsp; revised <?= isset($data->EnrolledDate) ? date('F d, Y', strtotime($data->EnrolledDate)) : '' ?> &nbsp;&nbsp; revision no. 06 &nbsp;&nbsp; from Admin office &nbsp;&nbsp; Page 1 of 1 -->
    </div>
  </div>
</body>

</html>