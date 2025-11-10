<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Registration Form</title>
  <style>
    @page {
      size: A4;
      margin: 0;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      font-size: 13px;
      line-height: 1.3;
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

    .form-section {
      margin-bottom: 14px;
    }

    .name-fields,
    .family-table,
    .siblings-table,
    .traits {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 4px;
      margin: 4px 0;
    }

    .lrn-boxes {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 3px;
      margin: 6px 0;
    }

    .lrn-boxes span {
      border: 1px solid #000;
      height: 20px;
    }

    .family-table,
    .siblings-table {
      grid-template-columns: repeat(4, 1fr);
    }

    .family-table.repeat,
    .siblings-table.repeat {
      height: 20px;
      border-bottom: 1px solid #000;
    }

    .traits {
      grid-template-columns: repeat(2, 1fr);
    }

    .long-answer {
      height: 22px;
      border-bottom: 1px solid #000;
      margin: 4px 0;
    }

    .signature-section {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-top: 20px;
    }

    .signature-section1 {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    .page-info {
      font-size: 11px;
      text-align: right;
      margin-top: 5px;
      font-style: italic;
    }

    .break {
      page-break-before: always;
    }

    .name-fields div {
      border-top: 1px solid #000;
      padding-top: 5px;
      margin-bottom: 5px;
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
      <h3>Basic Education Department<br>REGISTRATION FORM</h3>
      <div class="photo-box">
        <div class="photo-content">
          <div class="photo-label">1 / 1 Photo</div>
          <div class="photo-subtext">White background</div>
        </div>
      </div>
    </div>
    <br>

    <div class="form-section">
      <p>ID Number: __________________________ <span class="note">(to be assigned by the school)</span></p>
      <p>
        Academic Year:
        <span style="display:inline-block; border-bottom:1px solid #000; width:150px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->SY ?>
          </span>
        </span>

        &nbsp; Grade/ Level:
        <span style="display:inline-block; border-bottom:1px solid #000; width:200px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->YearLevel ?>
          </span>
        </span>
      </p>

      <p><i>
          For Gr. 11 & 12: TRACK
          <span style="display:inline-block; border-bottom:1px solid #000; width:120px; text-align:center; position:relative;">
            <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
              <?= $data->Track ?>
            </span>
          </span>

          STRAND
          <span style="display:inline-block; border-bottom:1px solid #000; width:180px; text-align:center; position:relative;">
            <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
              <?= $data->strand ?? '' ?>
            </span>
          </span>
        </i></p>

      <p>LRN (12 digits)</p>
      <div class="lrn-boxes">
        <?php foreach (str_split($data->LRN) as $digit) echo "<span style='padding:5px; text-align:center; margin-right:5px;'>$digit</span>"; ?>
      </div>

    </div>

    <div class="form-section">
      <h4>PERSONAL DATA</h4>
      <p>
        Telephone#:
        <span style="display:inline-block; border-bottom:1px solid #000; width:150px; text-align:center; position:relative; margin-right:20px;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->TelNumber ?>
          </span>
        </span>

        Mobile phone#:
        <span style="display:inline-block; border-bottom:1px solid #000; width:150px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->MobileNumber ?>
          </span>
        </span>
      </p>

      <p>NAME of pupil/student:</p>
      <div style="display:flex; width:100%; max-width:700px; border-bottom:1px solid #000;">
        <div style="flex:1; position: relative; padding:5px 10px; text-align:center;">
          <div style="font-weight:bold; font-size:14px; padding-bottom:20px;">
            <?= $data->LastName ?: '&nbsp;'; ?>
          </div>
          <div style="position:absolute; bottom:5px; left:10px; right:10px; font-size:12px; color:#555;">
            LAST NAME
          </div>
        </div>
        <div style="flex:1; position: relative; padding:5px 10px; text-align:center; border-left:1px solid #000;">
          <div style="font-weight:bold; font-size:14px; padding-bottom:20px;">
            <?= $data->FirstName ?: '&nbsp;'; ?>
          </div>
          <div style="position:absolute; bottom:5px; left:10px; right:10px; font-size:12px; color:#555;">
            FIRST NAME
          </div>
        </div>
        <div style="flex:1; position: relative; padding:5px 10px; text-align:center; border-left:1px solid #000;">
          <div style="font-weight:bold; font-size:14px; padding-bottom:20px;">
            <?= $data->MiddleName ?: '&nbsp;'; ?>
          </div>
          <div style="position:absolute; bottom:5px; left:10px; right:10px; font-size:12px; color:#555;">
            MIDDLE NAME
          </div>
        </div>
      </div>

      <p style="margin-bottom:1.5em;">
        HOME ADDRESS:
        <span style="display:inline-block; border-bottom:1px solid #000; width:70%; vertical-align:bottom;">
          <?= $data->Sitio ?>&nbsp;
        </span>
      </p>

      <p style="margin-bottom:1.5em;">
        Barangay:
        <span style="display:inline-block; border-bottom:1px solid #000; width:40%; vertical-align:bottom;">
          <?= $data->Brgy ?> &nbsp;
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp; City:
        <span style="display:inline-block; border-bottom:1px solid #000; width:40%; vertical-align:bottom;">
          <?= $data->City ?>, <?= $data->Province ?>&nbsp;
        </span>
      </p>

      <p style="margin-bottom:1.5em;">

        <?php
        $year = date('Y', strtotime($data->BirthDate));
        $month = date('m', strtotime($data->BirthDate));
        $day = date('d', strtotime($data->BirthDate));
        ?>

        BIRTH DATE:
        <span style="display:inline-block; border-bottom:1px solid #000; width:15%; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;"><?= $year ?></span>
        </span> /
        <span style="display:inline-block; border-bottom:1px solid #000; width:10%; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;"><?= $month ?></span>
        </span> /
        <span style="display:inline-block; border-bottom:1px solid #000; width:10%; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;"><?= $day ?></span>
        </span>
        &nbsp;&nbsp;&nbsp; AGE:
        <span style="display:inline-block; border-bottom:1px solid #000; width:10%; text-align:center; vertical-align:bottom;">
          &nbsp;&nbsp;<?= $data->Age ?>
        </span>
        &nbsp;&nbsp;&nbsp; SEX:
        <span style="display:inline-block; border-bottom:1px solid #000; width:10%; text-align:center; vertical-align:bottom;">
          &nbsp;&nbsp;<?= $data->Sex ?>
        </span>
        &nbsp;&nbsp;&nbsp; RELIGION:
        <span style="display:inline-block; border-bottom:1px solid #000; width:85%; vertical-align:bottom;">
          &nbsp;<?= $data->Religion ?>
        </span>
      </p>

    </div>

    <div class="form-section">
      <h4>HOME BACKGROUND</h4>
      <p>Father’s Name
        <span style="display:inline-block; border-bottom:1px solid #000; width:250px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->Father ?>
          </span>
        </span>
        Birth Date:
        <span style="display:inline-block; border-bottom:1px solid #000; width:150px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= isset($data->fatherBirthDate) ? date('F d, Y', strtotime($data->fatherBirthDate)) : '--' ?>
          </span>
        </span>
        Age
        <span style="display:inline-block; border-bottom:1px solid #000; width:50px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= isset($data->fatherAge) ? $data->fatherAge : '--' ?>
          </span>
        </span>
      </p>
      <p>Educational Attainment
        <span style="display:inline-block; border-bottom:1px solid #000; width:180px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->fatherEducation ?? '' ?>
          </span>
        </span>
        Occupation
        <span style="display:inline-block; border-bottom:1px solid #000; width:180px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->FOccupation ?>
          </span>
        </span>
      </p>
      <p>Mother’s Name
        <span style="display:inline-block; border-bottom:1px solid #000; width:250px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->Mother ?>
          </span>
        </span>
        Birth Date:
        <span style="display:inline-block; border-bottom:1px solid #000; width:150px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= isset($data->motherBirthDate) ? date('F d, Y', strtotime($data->motherBirthDate)) : '--' ?>
          </span>
        </span>
        Age
        <span style="display:inline-block; border-bottom:1px solid #000; width:50px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= isset($data->motherAge) ? $data->motherAge : '--' ?>
          </span>
        </span>
      </p>
      <p>Educational Attainment
        <span style="display:inline-block; border-bottom:1px solid #000; width:180px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->motherEducation ?? '' ?>
          </span>
        </span>
        Occupation
        <span style="display:inline-block; border-bottom:1px solid #000; width:180px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->MOccupation ?>
          </span>
        </span>
      </p>
      <p>Guardian’s Name
        <span style="display:inline-block; border-bottom:1px solid #000; width:200px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->Guardian ?>
          </span>
        </span>
        Relationship:
        <span style="display:inline-block; border-bottom:1px solid #000; width:150px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->GuardianRelationship ?>
          </span>
        </span>
        Age
        <span style="display:inline-block; border-bottom:1px solid #000; width:50px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= isset($data->guardianAge) ? $data->guardianAge : '--' ?>
          </span>
        </span>
      </p>
      <p>Educational Attainment
        <span style="display:inline-block; border-bottom:1px solid #000; width:180px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->guardianEducation ?? '' ?>
          </span>
        </span>
        Occupation
        <span style="display:inline-block; border-bottom:1px solid #000; width:180px; text-align:center; position:relative;">
          <span style="position:absolute; top:-1.2em; left:0; right:0; font-size:12px;">
            <?= $data->guardianOccupation ?>
          </span>
        </span>
      </p>
    </div>

    <div class="form-section">
      <h4>BROTHER AND SISTER (IN RANK)</h4>
      <div class="siblings-table">
        <div><strong>NAME</strong></div>
        <div><strong>AGE</strong></div>
        <div><strong>GRADE/YEAR</strong></div>
        <div><strong>SCHOOL</strong></div>
      </div>
      <?php for ($i = 0; $i < 3; $i++) echo '<div class="siblings-table repeat"></div>'; ?>
    </div>

    <footer class="signature-section1">
      <!-- <p class="page-info">Page 1 of 2 Registration form - new-admission - preschool to gr 12 - revised on <?= isset($data->EnrolledDate) ? date('F d, Y', strtotime($data->EnrolledDate)) : '' ?> -->
    </footer>
  </div>

  <div class="page break">
    <div class="form-section">
      <h4>OTHER PEOPLE LIVING WITH THE FAMILY:</h4>
      <div class="family-table">
        <div>NAME</div>
        <div>RELATIONSHIP</div>
        <div>OCCUPATION</div>
        <div>SCHOOL</div>
      </div>
      <div class="family-table repeat"></div>
    </div>

    <div class="form-section">
      <h4>WITH RELATION TO SCHOOL:</h4>
      <p>Name of previous school __________________________________ AY ___________ Level / Grade ________</p>
    </div>

    <div class="form-section">
      <h4>FETCHING AGREEMENT:</h4>
      <p>I would like to confirm that, every day after the end of the class –</p>
      <p><i>(Please check ✓ the appropriate answer and provide the necessary information)</i></p>
      <p>( ) I shall personally fetch my child.</p>
      <p>( ) I am authorizing __________________________________________ to fetch my child.</p>
      <p>( ) I am authorizing the school to allow my child to go home without any fetcher.</p>
    </div>

    <div class="form-section">
      <h4>LUNCH AGREEMENT: <i>(for Elementary and High School only)</i></h4>
      <p>I would like to confirm that, every day during lunch break –</p>
      <p><i>(Please check ✓ the appropriate answer and provide the necessary information)</i></p>
      <p>( ) My child shall eat lunch at the school canteen.</p>
      <p>( ) I authorize the school to allow my child to go home each day at lunch break and eat at
        home. I will ensure that my child comes to school before the end of lunch break time.
      </p>
    </div>

    <div class="form-section">
      <h4>HEALTH:</h4>
      <p>Eyesight _________ Hearing __________ Any health problem/s? ________________________________</p>
    </div>

    <div class="form-section">
      <h4>CHECK WHICH CHARACTERISTICS DESCRIBE YOUR CHILD:</h4>
      <div class="traits">
        <?php
        $traits = ["Active", "Passive", "Calm", "Stubborn", "Friendly with other children", "Nervous", "Easily excited", "Easily discouraged", "Jolly", "Serious", "Leader", "Retiring", "Good-Natured", "Quick-tempered", "Reliable", "Absent-minded", "Imaginative", "Responsible"];
        foreach (array_chunk($traits, 2) as $row) {
          foreach ($row as $trait) echo "<div>_____________ {$trait}</div>";
        }
        ?>
      </div>
    </div>

    <div class="form-section">
      <h4>HOW DID YOU KNOW ABOUT ABOUT OUR SCHOOL? <i>(Please check the appropriate box)</i></h4>
      <p>☐ Friend ☐ Leaflet ☐ Parent ☐ other (please specify) _______________________________________</p>
    </div>

    <div class="form-section">
      <h4>WHY DO YOU LIKE TO ENROLL YOUR CHILD HERE?</h4>
      <div class="long-answer"></div>
      <div class="long-answer"></div>
    </div>

    <footer class="signature-section">
      <div>Date Filled </div>
      <div>Parent’s/ Guardian’s Signature over Printed Name </div>
      <div>Relationship </div>
      <!-- <p class="page-info">Page 2 of 2 Registration form - new-admission - preschool to gr 12 - revised on <?= isset($data->EnrolledDate) ? date('F d, Y', strtotime($data->EnrolledDate)) : '' ?> -->
    </footer>
  </div>
</body>

</html>