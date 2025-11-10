<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Registration Form</title>
  <style>
    @page { size: A4; margin: 0; }
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; font-size: 13px; line-height: 1.3; }
    .page { width: 210mm; height: 297mm; padding: 15mm 20mm; margin: auto; box-sizing: border-box; page-break-after: always; overflow: hidden; position: relative; border: 1px solid black; }
    .header-container { margin-bottom: 10px; }
    .header-img { width: 100%; max-height: 120px; object-fit: contain; }
    .title-wrap { display: flex; justify-content: center; align-items: flex-start; position: relative; margin-bottom: 20px; text-align: center; }
    .title-wrap h3 { margin: 0 auto; font-size: 16px; line-height: 1.5; width: 100%; }
    .photo-box { position: absolute; right: 0; top: 0; width: 130px; height: 120px; border: 1px solid #000; display: flex; align-items: center; justify-content: center; font-size: 12px; padding: 5px; box-sizing: border-box; }
    .photo-content { text-align: center; }
    .photo-label { margin-bottom: 5px; font-weight: bold; }
    .photo-subtext { font-size: 11px; }
    .form-section { margin-bottom: 14px; }
    .name-fields, .family-table, .siblings-table, .traits { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; margin: 4px 0; }
    .lrn-boxes { display: grid; grid-template-columns: repeat(12, 1fr); gap: 3px; margin: 6px 0; }
    .lrn-boxes span { border: 1px solid #000; height: 20px; text-align: center; }
    .family-table, .siblings-table { grid-template-columns: repeat(4, 1fr); }
    .family-table.repeat, .siblings-table.repeat { height: 20px; border-bottom: 1px solid #000; }
    .traits { grid-template-columns: repeat(2, 1fr); }
    .long-answer { height: 22px; border-bottom: 1px solid #000; margin: 4px 0; }
    .signature-section { display: flex; justify-content: space-between; flex-wrap: wrap; margin-top: 20px; }
    .page-info { font-size: 11px; text-align: right; margin-top: 5px; font-style: italic; }
    .break { page-break-before: always; }
    /* .name-fields div { border-top: 1px solid #000; padding-top: 5px; margin-bottom: 5px; } */
    .signature-section div { border-top: 1px solid #000; padding-top: 5px; margin-bottom: 5px; }
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
      <p>GLC ID Number: <?= $data->IDNumber ?> <span class="note">(to be assigned by GLC)</span></p>
      <p>Academic Year: <?= $data->SY ?> &nbsp; Grade/ Level: <?= $data->YearLevel ?></p>
      <p><i>For Gr. 11 & 12: TRACK <?= $data->Track ?> STRAND <?= $data->strand ?></i></p>
      <p>LRN (12 digits)</p>
      <div class="lrn-boxes">
        <?php foreach (str_split($data->LRN) as $digit) echo "<span>$digit</span>"; ?>
      </div>
    </div>

    <div class="form-section">
      <h4>PERSONAL DATA</h4>
      <p>
  Telephone#: 
  <span class="form-underline">
    <span><?= $data->TelNumber ?></span>
  </span>

  Mobile phone#: 
  <span class="form-underline">
    <span><?= $data->MobileNumber ?></span>
  </span>
</p>

      <p>NAME of pupil/student:</p>
     <div class="name-fields">
  <div><strong style="border-bottom: 1px solid #000; padding-right: 10px;"><?= $data->LastName ?></strong><br><small>LAST NAME</small></div>
  <div><strong style="border-bottom: 1px solid #000; padding-right: 10px;"><?= $data->FirstName ?></strong><br><small>FIRST NAME</small></div>
  <div><strong style="border-bottom: 1px solid #000; padding-right: 10px;"><?= $data->MiddleName ?></strong><br><small>MIDDLE NAME</small></div>
  <div><strong style="border-bottom: 1px solid #000; padding-right: 10px;"><?= $data->NickName ?? '' ?></strong><br><small>NICKNAME</small></div>
</div>

      <p>HOME ADDRESS: <?= $data->Province ?>, <?= $data->City ?>, <?= $data->Brgy ?>, <?= $data->Sitio ?></p>
      <p>Barangay: <?= $data->Brgy ?> City: <?= $data->City ?></p>
      <p>BIRTH DATE: <?= date('m / d / Y', strtotime($data->BirthDate)) ?> &nbsp;&nbsp; AGE: <?= $data->Age ?> SEX: <?= $data->Sex ?> RELIGION: <?= $data->Religion ?></p>
    </div>

    <div class="form-section">
      <h4>HOME BACKGROUND</h4>
      <p>Father’s Name <?= $data->Father ?> Birth Date: ____________ Age ______</p>
      <p>Educational Attainment ____________ Occupation <?= $data->FOccupation ?></p>
      <p>Mother’s Name <?= $data->Mother ?> Birth Date: ____________ Age ______</p>
      <p>Educational Attainment ____________ Occupation <?= $data->MOccupation ?></p>
      <p>Guardian’s Name <?= $data->Guardian ?> Relationship: <?= $data->GuardianRelationship ?> Age ______</p>
      <p>Educational Attainment ____________ Occupation <?= $data->guardianOccupation ?></p>
    </div>

    <div class="form-section">
      <h4>BROTHER AND SISTER (IN RANK)</h4>
      <div class="siblings-table">
        <div><strong>NAME</strong></div>
        <div><strong>AGE</strong></div>
        <div><strong>GRADE/YEAR</strong></div>
        <div><strong>SCHOOL</strong></div>
      </div>
      <?php for ($i = 0; $i < 4; $i++) echo '<div class="siblings-table repeat"></div>'; ?>
    </div>

    <footer>
      <p class="page-info">Page 1 of 2 Registration form - new-admission - preschool to gr 12 - revised on June 14, 2024</p>
    </footer>
  </div>

  <div class="page break">
    <div class="form-section">
      <h4>OTHER PEOPLE LIVING WITH THE FAMILY:</h4>
      <div class="family-table">
        <div>NAME</div><div>RELATIONSHIP</div><div>OCCUPATION</div><div>SCHOOL</div>
      </div>
      <div class="family-table repeat"></div>
    </div>

    <div class="form-section">
      <h4>WITH RELATION TO SCHOOL:</h4>
      <p>Name of previous school <?= $data->HighSchool ?> AY ___________ Level / Grade ________</p>
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
      <p>( ) I authorize the school to allow my child to go home each day at lunch break and eat at home. I will ensure that my child comes to school before the end of lunch break time.</p>
    </div>

    <div class="form-section">
      <h4>HEALTH:</h4>
      <p>Eyesight _________ Hearing __________ Any health problem/s? <?= $data->health_issues ?? '__________________________' ?></p>
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
      <h4>HOW DID YOU KNOW ABOUT GLC? <i>(Please check the appropriate box)</i></h4>
      <p>☐ Friend ☐ Leaflet ☐ Parent of GLC ☐ other (please specify) _______________________________________</p>
    </div>

    <div class="form-section">
      <h4>WHY DO YOU LIKE TO ENROLL YOUR CHILD HERE?</h4>
      <div class="long-answer"><?= $data->Notes ?? '' ?></div>
      <div class="long-answer"></div>
    </div>

    <footer class="signature-section">
      <div>Date Filled: <?= date('F d, Y') ?></div>
      <div>Parent’s/ Guardian’s Signature over Printed Name: <?= $data->Mother ?></div>
      <div>Relationship: Mother</div>
      <p class="page-info">Page 2 of 2 Registration form - new-admission - preschool to gr 12 - revised on June 14, 2024</p>
    </footer>
  </div>
</body>
</html>
