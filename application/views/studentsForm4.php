<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ID Request Form</title>
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
      border: 1px solid #000;
      position: relative;
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
      justify-content: space-between;
      align-items: flex-start;
      position: relative;
      text-align: left;
      margin-bottom: 15px;
    }

    .title-wrap h3 {
      margin: 0;
      font-size: 16px;
      line-height: 1.4;
    }

    .photo-box {
      width: 110px;
      height: 100px;
      border: 1px solid #000;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      text-align: center;
      padding: 5px;
      box-sizing: border-box;
    }

    .photo-label {
      font-weight: bold;
      margin-bottom: 3px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    td {
      border: 1px solid #000;
      padding: 5px;
      vertical-align: top;
    }

    .note {
      font-style: italic;
      font-size: 12px;
    }

    .signature-note {
      font-style: italic;
      font-size: 11px;
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
      <h3>
        ID Request Form<br>
        School Year <strong><?= $data->SY ?? '____________________' ?></strong>
      </h3>
      <div class="photo-box">
        <div>
          <div class="photo-label">1x1 ID Photo</div>
          white plain<br>background
        </div>
      </div>
    </div>

    <p><strong>To be Accomplished by:</strong></p>

    <table>
      <tr>
        <td rowspan="2">Complete name of Pupil/ Student</td>
        <td colspan="2"><strong><?= $data->LastName . ', ' . $data->FirstName . ' ' . $data->MiddleName ?? '' ?></strong></td>
      </tr>
      <tr>
        <td colspan="2" style="height: 25px;"></td>
      </tr>
      <tr>
        <td>ID No.:</td>
        <td colspan="2"><?= $data->StudentNumber ?? '' ?></td>
      </tr>
      <tr>
        <td>Grade/ Level:</td>
        <td colspan="2"><?= $data->YearLevel ?? '' ?></td>
      </tr>
      <tr>
        <?php
        $birthdate = isset($data->BirthDate) ? explode('-', $data->BirthDate) : ['', '', ''];
        ?>
        <td>Birthdate (MM/DD/YY):</td>
        <td> <?= $birthdate[1] ?? '___' ?>/ <?= $birthdate[2] ?? '___' ?>/&nbsp;&nbsp; <?= $birthdate[0] ?? '____' ?> </td>
      </tr>
      <tr>
        <td rowspan="2">Address (complete):</td>
        <td colspan="2"><?= $data->Sitio . ', ' . $data->Brgy . ', ' . $data->City . ', ' . $data->Province ?? '' ?></td>
      </tr>
      <tr>
        <td colspan="2"><span class="note">including Barangay</span></td>
      </tr>
      <tr>
        <td>Contact person in case of emergency:</td>
        <td colspan="2"><?= $data->Guardian ?? '' ?></td>
      </tr>
      <tr>
        <td>Relationship:</td>
        <td colspan="2"><span class="note"><?= $data->GuardianRelationship ?? '' ?> (last name, first name, middle initial)</span></td>
      </tr>
      <tr>
        <td>Contact numbers:</td>
        <td colspan="2"><?= $data->GuardianContact ?? '' ?></td>
      </tr>
      <tr>
        <td rowspan="2">Specimen Signature of Student</td>
        <td colspan="2" style="height: 40px;"></td>
      </tr>
      <tr>
        <td colspan="2" class="signature-note">(please sign inside the box)</td>
      </tr>
      <tr>
        <td>Date Issued:</td>
        <td colspan="2"><?= $data->IssuedDate ?? '' ?></td>
      </tr>
      <tr>
        <td>Valid Until:</td>
        <td colspan="2"><?= $data->ValidUntil ?? '' ?></td>
      </tr>
    </table>
  </div>
</body>

</html>
