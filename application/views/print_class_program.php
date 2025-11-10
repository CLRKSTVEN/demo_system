<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Printable Class Program</title>
    <style>
        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .container {
            width: 100%;
            padding: 10px 15px;
        }

        h3 {
            text-align: center;
            font-size: 18px;
            margin: 5px 0;
        }

        p {
            text-align: center;
            font-size: 12px;
            margin: 3px 0;
        }

        .info-header {
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
        }

        .letterhead img {
            width: 100%;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #999;
            padding: 4px 5px;
            text-align: center;
        }

        th {
            background-color: #002147;
            color: white;
            -webkit-print-color-adjust: exact;
        }

        tbody tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        /* Print optimization */
        @media print {
            body {
                margin: 0;
            }

            .noprint {
                display: none !important;
            }

            .letterhead img {
                margin-top: -10px;
                margin-bottom: 5px;
            }

            .container {
                padding: 0;
            }

            th {
                background-color: #ccc !important;
                color: #000 !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Letterhead -->
        <?php if (!empty($letterhead[0]->letterhead_web)) : ?>
            <div class="letterhead">
                <img src="<?= base_url('upload/banners/' . $letterhead[0]->letterhead_web); ?>" alt="Letterhead">
            </div>
        <?php endif; ?>

        <!-- Title and Info -->
        <h3>CLASS PROGRAM</h3>
        <p>School Year: <?= $sy; ?> &nbsp;|&nbsp; Semester: <?= $semester; ?></p>

        <?php if (!empty($subjects)) : ?>
            <?php 
                $first = $subjects[0];
                $yearLevel = $first->YearLevel ?? '';
                $section = $first->Section ?? '';
            ?>
            <div class="info-header">
                <strong>Year Level:</strong> <?= $yearLevel; ?> &nbsp;&nbsp;
                <strong>Section:</strong> <?= $section; ?>
            </div>
        <?php endif; ?>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Description</th>
                    <th>Teacher</th>
                    <th>Schedule</th>
                    <th>Strand</th>
                    <th>Semester</th>
                </tr>
            </thead>
   <tbody>
    <?php foreach ($subjects as $row): ?>
        <?php if (empty($row->Fullname) || trim($row->Fullname) === '') continue; ?>
        <tr>
            <td><?= $row->SubjectCode; ?></td>
            <td style="text-align: left;"><?= $row->Description; ?></td>
            <td><?= $row->Fullname; ?></td>
            <td><?= $row->SchedTime; ?></td>
            <td><?= $row->strand; ?></td>
            <td><?= $row->Semester; ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>



        </table>

    </div>
</body>
</html>
