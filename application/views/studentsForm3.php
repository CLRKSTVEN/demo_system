<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Scholarship Agreement</title>
  <style>
    @page {
      size: A4;
      margin: 0;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 11px;
      margin: 0;
      padding: 0;
      line-height: 1.4;
    }

    .page {
      width: 210mm;
      height: 297mm;
      padding: 20mm;
      margin: auto;
      box-sizing: border-box;
      border: 1px solid black;
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

    h2,
    h3 {
      margin: 5px 0;
      text-align: center;
    }

    h3 {
      font-size: 15px;
    }

    h4 {
      text-align: center;
      font-style: italic;
      font-size: 13px;
      margin: 10px 0;
    }

    p {
      margin: 5px 0;
      text-align: justify;
    }

    ol {
      margin-left: 20px;
    }

    .signature-section {
      margin-top: 30px;
      display: flex;
      justify-content: space-between;
    }

    .signature-box {
      width: 48%;
      text-align: center;
    }

    .signature-line {
      border-top: 1px solid #000;
      margin-top: 10px;
      padding-top: 3px;
      font-size: 13px;
    }

    .approval-section {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
    }

    .approval-box {
      width: 48%;
      text-align: center;
    }

    .footer {
      font-size: 11px;
      font-style: italic;
      margin-top: 30px;
      display: flex;
      justify-content: space-between;
    }

    .underline {
      text-decoration: underline;
    }

    .note {
      font-style: italic;
    }

    .highlight {
      font-weight: bold;
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

    <h3>SCHOLARSHIP AGREEMENT</h3>
    <h4>Basic Education Department</h4>

    <div class="form-section">
      <p>
        <?php
        $name = !empty($data->Mother) ? $data->Mother
          : (!empty($data->Father) ? $data->Father
            : (!empty($data->Guardian) ? $data->Guardian
              : '____________________________'));
        ?>
        I, <strong><?= $name ?></strong>,
        parent / guardian of (Name of pupil / student)
        <strong><?= $data->LastName . ', ' . $data->FirstName . ' ' . $data->MiddleName ?? '_____________________________' ?></strong>,
        Grade/level <strong><?= $data->YearLevel ?? '______' ?></strong>,
        hereby accept the <?= (isset($data->ScholarshipType) && $data->ScholarshipType == 'Full')
                            ? '(✓) full scholarship / ( ) partial scholarship'
                            : '( ) full scholarship / (✓) partial scholarship' ?>

        for SY <strong><?= $data->SY ?? '___________' ?></strong> and commit
        to respect and follow the policy of the Scholarship Assistance Program of Golden Link College.
      </p>

      <p>In this connection, I understand that the scholarship grant is offered under the following conditions:</p>

      <ol>
        <li>
          Coverage of this scholarship program is <strong><?= $data->ScholarshipCoverage ?? '____________________' ?></strong>
          <br><span class="note">(Examples: free tuition fees; or free part of tuition fee; or free tuition + misc. fees)</span>
        </li>
        <li>If partial scholarship – I will have to pay the balance school fees as per the agreed schedule (<i>Ref to payment agreement</i>)</li>
        <li>This scholarship grant is for one (1) school year only. The next school year scholarship grant is subject to renewal.</li>
        <li>
          Grade on any subject should not be lower than <span class="underline">“Approaching Proficiency (AP)”</span>
          for the renewal of scholarship in the coming school year.
        </li>
        <li>
          The renewal application must be submitted with complete requirements
          <span class="underline">on or before March 31 of each year</span>.
        </li>
        <li>My child is required to take part in all school programs and activities.</li>
        <li>I will purchase the complete set of textbooks and school uniforms for my child.</li>
        <li>
          The scholarship grant will be discontinued if my child will be found,
          <span class="underline">for the 3rd time, violating</span> any rules and regulations of this school.
        </li>
        <li>
          I must attend all meetings called for scholars or related to the schooling of my child.
          Failure to <span class="underline">attend two (2) consecutive meetings</span> can be ground for the discontinuation of the scholarship grant.
        </li>
      </ol>
    </div>

    <div class="signature-section">
      <div class="signature-box">
        <div>Confirmed by:</div>
        <?php
        $name = !empty($data->Mother) ? $data->Mother
          : (!empty($data->Father) ? $data->Father
            : (!empty($data->Guardian) ? $data->Guardian
              : ''));
        ?>
        <strong><?= $name ?></strong>,
        <div class="signature-line">Signature over Print name (Parent)</div>
        <p>Date: ____________________</p>
      </div>

      <div class="signature-box">
        <div>&nbsp;</div>
        <strong><?= $data->LastName . ', ' . $data->FirstName . ' ' . $data->MiddleName ?? '' ?></strong>,
        <div class="signature-line">Signature over Print name (Student)</div>
        <p>Date: ____________________</p>
      </div>
    </div>

    <div class="approval-section">
      <div class="approval-box">
        <div>Approved by:</div>
        <br>
        <strong><?= $letterhead[0]->SchoolHead ?? '' ?></strong>,
        <div class="signature-line">School Administrator</div>
      </div>

      <div class="approval-box">
        <div>Date Approved:</div>
        <br>
        <br>
        <div class="signature-line">&nbsp;</div>
      </div>
    </div>

    <div class="footer">
      <div>Parent/ Guardian copy</div>
      <div>School copy</div>
    </div>
  </div>
</body>

</html>