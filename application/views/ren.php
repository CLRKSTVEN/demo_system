<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
    <link href="<?= base_url(); ?>assets/css/renren.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
        <link href="<?= base_url(); ?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
        <style>
            .cons th {
            cursor: pointer;
            }
        </style>
    
    <title>Grading Sheets</title>
</head>
<body style="background-color:#fff">
    
<?= form_open('Ren/update_batch'); ?>

<?php foreach ($records as $record): ?>
    <div>
        <label for="comment_<?php echo $record->gradeID; ?>">Comment (ID: <?php echo $record->gradeID; ?>):</label>
        <input type="hidden" name="ids[]" value="<?php echo $record->gradeID; ?>">
        <input type="text" name="PGrade[<?php echo $record->gradeID; ?>]" value="<?php echo $record->PGrade; ?>">
        <input type="text" name="MGrade[<?php echo $record->gradeID; ?>]" value="<?php echo $record->MGrade; ?>">
        <input type="text" name="PFinalGrade[<?php echo $record->gradeID; ?>]" value="<?php echo $record->PFinalGrade; ?>">
        <input type="text" name="FGrade[<?php echo $record->gradeID; ?>]" value="<?php echo $record->FGrade; ?>">
    </div>
<?php endforeach; ?>

<input type="submit" value="Update Comments">
<?= form_close(); ?>



    
</body>
</html>