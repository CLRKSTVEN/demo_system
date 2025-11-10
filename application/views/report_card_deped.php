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
<a class="nextpage" href="<?= base_url(); ?>Ren/report_card_depedp2/<?= $this->uri->segment(3); ?>">page 2</a>



<div class="card_deped card_deped1">
<img class="banner" src="<?= base_url(); ?>/assets/images/s.jpg" alt="">
<table>
    <tr>
        <td>Name: </td>
        <td colspan="3" class="wbborder"><?= $stud->LastName; ?>, <?= $stud->FirstName; ?> <?= $stud->MiddleName; ?></td>
    </tr>
    <tr>
        <td>LRN: </td>
        <td class="wbborder"><?= $stud->LRN; ?></td>
        <td>sex: </td>
        <td class="wbborder"><?= $stud->Sex; ?></td>
    </tr>
    <tr>
        <td>Birth Date: </td>
        <td class="wbborder">July 24, 1988</td>
        <td>Age: </td>
        <td class="wbborder"><?= $stud->Age; ?></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>School Year: </td>
        <td class="wbborder"><?= $sem_stud->SY; ?></td>
        <td>Department: </td>
        <td class="wbborder"><?= $cur_stud->Course; ?></td>
    </tr>
    <tr>
        <td>Grade Level: </td>
        <td class="wbborder"><?= $cur_stud->YearLevel; ?></td>
        <td>Section: </td>
        <td class="wbborder"><?= $sem_stud->Section; ?></td>
    </tr>
    <tr>
        <td>Track: </td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td>Strand: </td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="4">
            <p>Dear Parent:</p>
            <p>This report card shows the ability and progress your child has made in the different learning areas as well as his/her core values.</p>
            <p>The school welcomes you should you desire to know more about your child's progress.</p>
        </td>
    </tr>
    <tr>
        <td colspan="4" >&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td style="display:block; text-align:center"><strong>ALMERA AGUJETAS MACAUYAG</strong><br /><span>Adviser</span></td>
    </tr>
    <tr>
        <td colspan="4" >&nbsp;</td>
    </tr>

    <tr>
        <td style="text-align:center" colspan="4">
            <strong>CONSTANTINO R. BAGUMBA</strong> <br />School Principal - II
        </td>
    </tr>
</table>

</div>

</div>



</body>
</html>