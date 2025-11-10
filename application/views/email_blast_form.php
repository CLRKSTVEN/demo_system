<!DOCTYPE html>
<html>

<head>
    <title>Email Blast Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h3>Email Blast to Enrolled Students</h3>

        <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-success mt-3"><?= $this->session->flashdata('message') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('EmailBlast/sendToAll') ?>" class="bg-white p-4 rounded shadow-sm mt-4">
            <div class="mb-3">
                <label class="form-label">Year Level</label>
                <select name="yearlevel" class="form-select" required>
                    <option value="">Select Year Level</option>
                    <option value="Kinder 1">Kinder 1</option>
                    <option value="Kinder 2">Kinder 2</option>
                    <?php for ($i = 1; $i <= 12; $i++):
                        $grade = 'Grade ' . str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                        <option value="<?= $grade ?>"><?= $grade ?></option>
                    <?php endfor; ?>
                </select>


            </div>
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" rows="6" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Email</button>
        </form>

    </div>
</body>

</html>