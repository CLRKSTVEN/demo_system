<!DOCTYPE html>
<html>

<head>
    <title>Email Blast</title>
</head>

<body>
    <?php if ($this->session->flashdata('message')): ?>
        <div style="color: green; margin-bottom: 20px;">
            <?= $this->session->flashdata('message') ?>
        </div>
    <?php endif; ?>

    <h2>Email Blast to All Enrolled Students</h2>
    <form method="post" action="<?= base_url('EmailBlast/sendToAll') ?>">
        <button type="submit" onclick="return confirm('Send HTML email to all enrolled students?')">
            Send Email Now
        </button>
    </form>
</body>

</html>