<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<body>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-calculator"></i> Generate Pre-Assessment</h5>
        </div>
        <div class="card-body">
            <form method="get" action="<?= base_url('Page/pre_assessment') ?>">
                <div class="form-group">
                    <label for="name">Student Name (optional)</label>
                    <input type="text" name="name" class="form-control" placeholder="Juan Dela Cruz">
                </div>
                <div class="form-group">
                    <label for="course">Select Course</label>
                    <select name="course" class="form-control" required>
                        <option value="">-- Select Course --</option>
                        <?php foreach ($courses as $c): ?>
                            <option value="<?= $c->CourseDescription ?>"><?= $c->CourseDescription ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="yearLevel">Select Year Level</label>
                    <select name="yearLevel" class="form-control" required>
                        <option value="">-- Select Year Level --</option>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">
                    <i class="bi bi-search"></i> Generate Breakdown
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
