<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/wcm.ico">
    
    <link href="<?= base_url(); ?>/assets/css/ivy.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="wrap">
<a class="nextpage" href="<?= base_url(); ?>Ren/report_card_deped/<?= $this->uri->segment(3); ?>">page 1</a>


<div class="card_deped card_deped1">

<table class="grade">
    <tr>
        <th colspan="7">REPORT ON LEARNING PROGRESS AND ACHIEVEMENT</th>
    </tr>
    <tr>
        <td rowspan="2">Learning Areas</td>
        <td colspan="4">Quarter</td>
        <td rowspan="2" style="text-align:center">Final<br /> Grade</td>
        <td rowspan="2">Remarks</td>
    </tr>
    <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
    </tr>
    <?php foreach($data as $row){ ?>
    <tr>
        <td><?= $row->Description; ?></td>
        <td style='text-align:center'><?php if($row->PGrade != 0){echo $row->PGrade;} ?></td>
        <td style='text-align:center'><?php if($row->MGrade != 0){echo $row->MGrade;} ?></td>
        <td style='text-align:center'><?php if($row->PFinalGrade != 0){echo $row->PFinalGrade;} ?></td>
        <td style='text-align:center'><?php if($row->FGrade != 0){echo $row->FGrade;} ?></td>
        <td style='text-align:center'><?php if($row->Average != 0){if($row->Average >= 60){echo number_format($row->Average);}} ?></td>
        <td></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="5" style="border:0; text-align:right">Gen. Average:</td>
        <td style="border:0">92</td>
        <td style="border:0; text-align:right"></td>
    </tr>
</table>
<table class="scale">
    <tr>
        <th>Descriptions</th>
        <th>Grading Scale</th>
        <th>Remarks</th>
    </tr>
    <tr>
        <td>Outstanding</td>
        <td>90 - 100</td>
        <td>Passed</td>
    </tr>
    <tr>
        <td>Very Satisfactory</td>
        <td>85 - 89</td>
        <td>Passed</td>
    </tr>
    <tr>
        <td>Satisfactory</td>
        <td>80 - 84</td>
        <td>Passed</td>
    </tr>
    <tr>
        <td>Fairly Satisfactory</td>
        <td>75 - 79</td>
        <td>Passed</td>
    </tr>
    <tr>
        <td>Did not meet Expectation</td>
        <td>below 75</td>
        <td>failed</td>
    </tr>
</table>


</div>


</body>
</html>