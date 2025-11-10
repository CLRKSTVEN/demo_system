<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admission Form</title>
  <style>
    @page {
      size: A4;
      margin: 0;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 13px;
      margin: 0;
      padding: 0;
    }

    .page {
      width: 210mm;
      height: 297mm;
      padding: 15mm 20mm;
      margin: auto;
      box-sizing: border-box;
      page-break-after: always;
      overflow: hidden;
      position: relative;
      border: 1px solid black;
    }

    .header-container {
      margin-bottom: 10px;
    }

    .header-img {
      width: 100%;
      max-height: 120px;
      object-fit: contain;
    }

    .title-wrap {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      position: relative;
      margin-bottom: 20px;
      text-align: center;
    }

    .title-wrap h3 {
      margin: 0 auto;
      font-size: 16px;
      line-height: 1.5;
      width: 100%;
    }

    .photo-box {
      position: absolute;
      right: 0;
      top: 0;
      width: 130px;
      height: 120px;
      border: 1px solid #000;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      padding: 5px;
      box-sizing: border-box;
    }

    .photo-content {
      text-align: center;
    }

    .photo-label {
      margin-bottom: 5px;
      font-weight: bold;
    }

    .photo-subtext {
      font-size: 11px;
    }

    .section {
      margin-top: 10px;
    }

    .section p,
    .section label {
      margin: 5px 0;
    }

    .field-line {
      display: block;
      border-bottom: 1px solid black;
      height: 20px;
      margin-bottom: 5px;
    }

    .form-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }

    .form-table td {
      padding: 5px;
      vertical-align: top;
    }

    .agreement {
      font-size: 12px;
      margin-top: 10px;
    }

    .signature {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      font-size: 13px;
    }

    .signature div {
      width: 30%;
      text-align: center;
    }

    .signature-line {
      border-bottom: 1px solid black;
      height: 18px;
      margin-bottom: 5px;
    }

    .footer {
      text-align: left;
      font-style: italic;
      font-size: 11px;
      margin-top: 25px;
    }

    .bold {
      font-weight: bold;
    }

    .italic {
      font-style: italic;
    }

    .signature-section {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-top: 20px;
    }

    .signature-section div {
      border-top: 1px solid #000;
      padding-top: 5px;
      margin-bottom: 5px;
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

    <div class="title-wrap">
      <h3>Basic Education Department<br>REGISTRATION FORM (RE-ADMISSION)</h3>
      <div class="photo-box">
        <div class="photo-content">
          <div class="photo-label">1 / 1 Photo</div>
          <div class="photo-subtext">White background</div>
        </div>
      </div>
    </div>
    <br>

    <div class="section" style="font-size: 10px;">
      Academic Year <strong><?= $data->SY ?? '__________' ?></strong> &nbsp;&nbsp;&nbsp;
      Level/ Grade/ Year <strong><?= $data->YearLevel ?? '___________' ?></strong> &nbsp;&nbsp;&nbsp;
      Pupil/Student ID# <strong><?= $data->StudentNumber ?? '___________' ?></strong>
    </div>

    <div class="section">
      <label>NAME OF PUPIL / STUDENT:</label>
      <div class="field-line"></div>
      <table class="form-table">
        <tr>
          <td><strong><?= $data->LastName ?? '' ?></strong></td>
          <td><strong><?= $data->FirstName ?? '' ?></strong></td>
          <td><strong><?= $data->MiddleName ?? '' ?></strong></td>
          <td><strong><?= $data->NickName ?? '' ?></strong></td>
        </tr>
        <tr>
          <td>LAST NAME</td>
          <td>FIRST NAME</td>
          <td>MIDDLE NAME</td>
          <td>NICKNAME</td>
        </tr>
      </table>

      <?php
      $birthdate = isset($data->BirthDate) ? explode('-', $data->BirthDate) : ['', '', ''];
      $month = $birthdate[1] ?? '';
      $day = $birthdate[2] ?? '';
      $year = $birthdate[0] ?? '';
      ?>
      <p>
        DATE OF BIRTH: <?= $month ?> / <?= $day ?> / <?= $year ?> &nbsp;&nbsp;
        AGE: <?= $data->Age ?? '___' ?> &nbsp;&nbsp;
        GENDER: <?= $data->Sex ?? '___' ?>
      </p>

      <p>HOME ADDRESS:</p>
      <div class="field-line"><?= $data->Sitio ?? '' ?>, <?= $data->Brgy ?? '' ?>, <?= $data->City ?? '' ?>, <?= $data->Province ?? '' ?></div>

      <?php
      $fatherBday = isset($data->fatherBirthDate) ? date('m / d / Y', strtotime($data->fatherBirthDate)) : '____ / ____ / ______';
      $motherBday = isset($data->motherBirthDate) ? date('m / d / Y', strtotime($data->motherBirthDate)) : '____ / ____ / ______';
      ?>
      <p>
        FATHER’S NAME: <strong><?= $data->Father ?? '____________________' ?></strong> &nbsp;&nbsp;
        DATE OF BIRTH: <?= $fatherBday ?>
      </p>
      <p>
        MOTHER’S NAME: <strong><?= $data->Mother ?? '____________________' ?></strong> &nbsp;&nbsp;
        DATE OF BIRTH: <?= $motherBday ?>
      </p>
      <p>
        TELEPHONE NO.: <strong><?= $data->TelNumber ?? '____________' ?></strong> &nbsp;&nbsp;
        MOBILE PHONE NO.: <strong><?= $data->MobileNumber ?? '____________' ?></strong>
      </p>
    </div>

    <div class="section agreement">
      <p class="bold">FETCHING AGREEMENT <span class="italic">(Please check (✓) the appropriate answer and provide necessary information)</span></p>
      <p>I would like to confirm that, every day after the end of the class –</p>
      <p>( ) I shall personally fetch my child.</p>
      <p>( ) I am authorizing ____________________________________________ to fetch my child.</p>
      <p>( ) I am authorizing the school to allow my child to go home without any fetcher.</p>

      <p class="bold">LUNCH AGREEMENT <span class="italic">(Please check (✓) the appropriate answer and provide necessary information)</span></p>
      <p>I would like to confirm that, every day during lunch break –</p>
      <p>( ) My child shall eat lunch at the school canteen.</p>
      <p>( ) I authorize the school to allow my child to go home each day at lunch break and eat at home. I will ensure that my child comes to school 10 minutes before the end of the lunch break.</p>

      <p class="bold">HEALTH INFORMATION:</p>
      <p>Any health concern/ needs special attention _____________________________________________</p>

      <p class="bold">ENROLLMENT CONFIRMATION / AGREEMENT:</p>
      <ol>
        <li>I agree to comply with the <span class="bold">Enrollment/ Payment Agreement</span> I will sign separately.</li>
        <li>I commit that I shall purchase, for my child, the following on or before ____________:
          <ol type="1">
            <li>complete set of textbook</li>
            <li>complete set of school uniform</li>
          </ol>
        </li>
      </ol>

      <p class="bold">OTHER INFORMATION:</p>
      <div class="field-line"></div>
      <div class="field-line"></div>
    </div>
    <br><br><br><br>

    <footer class="signature-section">
      <div>Parent’s/ Guardian’s Signature over Printed Name </div>
      <div>Relationship </div>
      <div> Date </div>
    </footer>

    <div class="footer">
      <!-- Admission Form &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Page 1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <i>revised on <?= isset($data->EnrolledDate) ? date('F d, Y', strtotime($data->EnrolledDate)) : '' ?></i> -->
    </div>
  </div>
</body>

</html>