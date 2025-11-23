<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/favicon.ico">
    <link href="<?= base_url(); ?>/assets/css/ren.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    // ---- SY + Level/Section resolution (view-safe) ----
    $selected_sy = $selected_sy
        ?? $this->input->get('sy', true)
        ?? ($sem_stud->SY ?? null)
        ?? ($currentSY ?? null)
        ?? (string) ($this->session->userdata('sy') ?? '');

    // Year Level / Section based on the SY-bound record ($sem_stud provided by controller)
    $yl  = $sem_stud->YearLevel ?? ($stud->YearLevel ?? '—');
    $sec = $sem_stud->Section   ?? ($stud->Section   ?? '—');

    // Department/Course (prefer cur_stud if set for this SY, fallback to sem_stud)
    $dept = $cur_stud->Course ?? ($sem_stud->Course ?? '—');

    // Adviser / School Head (safe)
    $adviser    = $cur_stud->Adviser ?? ($sem_stud->Adviser ?? '');
    $schoolHead = $prin->SchoolHead ?? '';

    // ---- Get deported subjects for this Year Level (subject_deportment) ----
    // Prefer a list provided by the controller; otherwise fetch here.
    $deported_codes = isset($deported_codes) && is_array($deported_codes) ? $deported_codes : null;
    if ($deported_codes === null) {
        $CI = &get_instance();
        // Try model helper first
        if (!isset($CI->SubjectDeportmentModel)) {
            $CI->load->model('SubjectDeportmentModel');
        }
        if (method_exists($CI->SubjectDeportmentModel, 'get_codes_by_yearlevel')) {
            $deported_codes = $CI->SubjectDeportmentModel->get_codes_by_yearlevel($yl);
        } else {
            // Fallback direct query if helper doesn't exist
            $rows = $CI->db->select('subjectCode')
                ->from('subject_deportment')
                ->where('yearLevel', $yl)
                ->get()->result();
            $deported_codes = array_values(array_unique(array_map(function ($r) {
                return (string) $r->subjectCode;
            }, $rows)));
        }
    }
    if (!is_array($deported_codes)) $deported_codes = [];

    // ---- Helpers for remarks ----
    if (!function_exists('numeric_remark')) {
        function numeric_remark($g)
        {
            if (!is_numeric($g) || $g <= 0) return '';
            if ($g >= 90) return 'Outstanding';
            if ($g >= 85) return 'Very Satisfactory';
            if ($g >= 80) return 'Satisfactory';
            if ($g >= 75) return 'Fairly Satisfactory';
            return 'Did Not Meet Expectations';
        }
    }
    if (!function_exists('letter_to_point')) {
        function letter_to_point($grade)
        {
            switch (strtoupper((string)$grade)) {
                case 'A':
                    return 5;
                case 'B':
                    return 4;
                case 'C':
                    return 3;
                case 'D':
                    return 2;
                case 'F':
                    return 1;
                default:
                    return 0;
            }
        }
    }
    if (!function_exists('point_to_letter')) {
        function point_to_letter($point)
        {
            if ($point >= 4.5) return 'A';
            if ($point >= 3.5) return 'B';
            if ($point >= 2.5) return 'C';
            if ($point >= 1.5) return 'D';
            return 'F';
        }
    }
    if (!function_exists('letter_remark')) {
        function letter_remark($letter)
        {
            switch ($letter) {
                case 'A':
                    return 'Outstanding';
                case 'B':
                    return 'Very Satisfactory';
                case 'C':
                    return 'Satisfactory';
                case 'D':
                    return 'Fairly Satisfactory';
                case 'F':
                    return 'Did Not Meet Expectations';
                default:
                    return '';
            }
        }
    }

    // ---- Compute GENERAL AVERAGE (numeric tracks only), EXCLUDING deported subjects ----
    $__ga = null;
    $__ga_remark = '';
    $excluded_present = []; // for footer note of which codes were excluded (and actually shown)
    if (!empty($data) && (empty($is_preschool) || !$is_preschool || (isset($preschoolGradeType) && $preschoolGradeType !== 'letter'))) {
        $sum = 0;
        $cnt = 0;
        foreach ($data as $__r) {
            $subjCode = $__r->SubjectCode ?? $__r->subjectCode ?? null;
            $avg = isset($__r->Average) ? (float)$__r->Average : 0;

            // Skip subjects explicitly deported for this year level
            if ($subjCode && in_array($subjCode, $deported_codes, true)) {
                $excluded_present[$subjCode] = true;
                continue;
            }

            if ($avg > 0) {
                $sum += $avg;
                $cnt++;
            }
        }
        if ($cnt > 0) {
            $__ga = $sum / $cnt;
            $__ga_remark = numeric_remark($__ga);
        }
    }
    ?>
    <div class="wrap">
        <!-- Letterhead (print-only) -->
        <?php if (!empty($letterhead) && !empty($letterhead[0]->letterhead_web)) : ?>
            <img class="print-only" src="<?= base_url(); ?>upload/banners/<?= htmlspecialchars($letterhead[0]->letterhead_web, ENT_QUOTES, 'UTF-8'); ?>" alt="mySRMS Portal" width="100%">
        <?php endif; ?>

        <div class="topwrap">
            <p class="pleft">
                <b>FORM 138 - REPORT CARD</b><br />
                LRN: <b><?= htmlspecialchars($stud->LRN ?? '—', ENT_QUOTES, 'UTF-8'); ?></b>
            </p>
            <p class="pright">
                Curriculum: <b>K to 12 Basic Education</b><br />
                Department: <b><?= htmlspecialchars($dept, ENT_QUOTES, 'UTF-8'); ?></b>
            </p>
            <div class="blocker"></div>
        </div>

        <div class="topwrap2">
            <p class="pleft">
                Student Name
                <span><?= htmlspecialchars(trim(($stud->LastName ?? '') . ', ' . ($stud->FirstName ?? '') . ' ' . ($stud->MiddleName ?? '')), ENT_QUOTES, 'UTF-8'); ?></span><br />
                Level/Section <span><?= htmlspecialchars($yl, ENT_QUOTES, 'UTF-8'); ?> / <?= htmlspecialchars($sec, ENT_QUOTES, 'UTF-8'); ?></span>
            </p>

            <p class="pright">
                Student No.: <span><?= htmlspecialchars($stud->StudentNumber ?? '—', ENT_QUOTES, 'UTF-8'); ?></span><br />
                Sex: <span><?= htmlspecialchars($stud->Sex ?? '—', ENT_QUOTES, 'UTF-8'); ?></span>
                School Year <span><?= htmlspecialchars($selected_sy ?: '—', ENT_QUOTES, 'UTF-8'); ?></span>
            </p>
            <div class="blocker"></div>
        </div>

        <table class='tb1'>
            <tr>
                <th rowspan="2">LEARNING AREAS</th>
                <?php if (!empty($is_preschool) && !empty($preschoolGradeType) && $is_preschool && $preschoolGradeType === 'letter'): ?>
                    <th colspan="4">LETTER GRADES</th>
                <?php else: ?>
                    <th colspan="5">QUARTERLY RATINGS</th>
                <?php endif; ?>
                <th rowspan="2">REMARK</th>
            </tr>
            <tr>
                <?php if (!empty($is_preschool) && !empty($preschoolGradeType) && $is_preschool && $preschoolGradeType === 'letter'): ?>
                    <th>1st</th>
                    <th>2nd</th>
                    <th>3rd</th>
                    <th>4th</th>
                <?php else: ?>
                    <th>1st</th>
                    <th>2nd</th>
                    <th>3rd</th>
                    <th>4th</th>
                    <th>Final</th>
                <?php endif; ?>
            </tr>

            <?php if (!empty($data)) : foreach ($data as $row): ?>
                    <?php
                    $subjCode = $row->SubjectCode ?? $row->subjectCode ?? null;
                    $isDeported = $subjCode && in_array($subjCode, $deported_codes, true);
                    if ($isDeported) $excluded_present[$subjCode] = true; // ensure it's noted for footer
                    ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($row->Description ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            <?php if ($isDeported): ?>
                                <small class="text-danger" style="font-style:italic;">(Excluded)</small>
                            <?php endif; ?>
                        </td>

                        <?php if (!empty($is_preschool) && !empty($preschoolGradeType) && $is_preschool && $preschoolGradeType === 'letter'): ?>
                            <td class="text-center"><?= htmlspecialchars($row->l_p  ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"><?= htmlspecialchars($row->l_m  ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"><?= htmlspecialchars($row->l_pf ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"><?= htmlspecialchars($row->l_f  ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php else: ?>
                            <td class="text-center"><?= !empty($row->PGrade)      && (float)$row->PGrade      != 0.0 ? number_format((float)$row->PGrade, 2)      : ''; ?></td>
                            <td class="text-center"><?= !empty($row->MGrade)      && (float)$row->MGrade      != 0.0 ? number_format((float)$row->MGrade, 2)      : ''; ?></td>
                            <td class="text-center"><?= !empty($row->PFinalGrade) && (float)$row->PFinalGrade != 0.0 ? number_format((float)$row->PFinalGrade, 2) : ''; ?></td>
                            <td class="text-center"><?= !empty($row->FGrade)      && (float)$row->FGrade      != 0.0 ? number_format((float)$row->FGrade, 2)      : ''; ?></td>
                            <td class="text-center"><?= !empty($row->Average)     && (float)$row->Average     != 0.0 ? number_format((float)$row->Average, 2)     : ''; ?></td>
                        <?php endif; ?>

                        <td class="text-center">
                            <?php if (!empty($is_preschool) && !empty($preschoolGradeType) && $is_preschool && $preschoolGradeType === 'letter'): ?>
                                <?php
                                $points = [
                                    letter_to_point($row->l_p  ?? ''),
                                    letter_to_point($row->l_m  ?? ''),
                                    letter_to_point($row->l_pf ?? ''),
                                    letter_to_point($row->l_f  ?? '')
                                ];
                                $validPoints = array_filter($points, static fn($p) => $p > 0);
                                if (count($validPoints) > 0) {
                                    $avgPoint    = array_sum($validPoints) / count($validPoints);
                                    $finalLetter = point_to_letter($avgPoint);
                                    echo htmlspecialchars(letter_remark($finalLetter), ENT_QUOTES, 'UTF-8');
                                }
                                ?>
                            <?php else: ?>
                                <?php
                                // Numeric tracks: use FINAL grade/AVERAGE for remark (still shown even if excluded)
                                $final = isset($row->Average) ? (float)$row->Average : 0;
                                echo htmlspecialchars(numeric_remark($final), ENT_QUOTES, 'UTF-8');
                                ?>
                            <?php endif; ?>
                        </td>
                    </tr>
            <?php endforeach;
            endif; ?>

            <?php if (empty($is_preschool) || !$is_preschool || (isset($preschoolGradeType) && $preschoolGradeType !== 'letter')): ?>
                <tr>
                    <td colspan="5" style="text-align:right; font-weight:bold">GENERAL AVERAGE</td>
                    <td class="text-center"><?= ($__ga !== null && $__ga > 0) ? number_format($__ga, 2) : ''; ?></td>
                    <td class="text-center"><?= htmlspecialchars($__ga_remark, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <?php if (!empty($excluded_present)): ?>
                    <tr>
                        <td colspan="7" class="text-muted" style="font-size:12px;">
                            <em>Excluded from General Average:</em>
                            <?= htmlspecialchars(implode(', ', array_keys($excluded_present)), ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
        </table>

        <div class="bwrap">
            <table class="tb2" style="text-align: center;">
                <tr>
                    <th></th>
                    <?php if (!empty($months)) : foreach ($months as $month): ?>
                            <?php
                            $abbr = '';
                            if (!empty($month)) $abbr = date('M', strtotime($month)); // "August" -> "Aug"
                            ?>
                            <th><?= htmlspecialchars($abbr ?: $month, ENT_QUOTES, 'UTF-8'); ?></th>
                    <?php endforeach;
                    endif; ?>
                    <th style="text-align: center;">Total</th>
                </tr>

                <?php
                $categories = [
                    'Days of School' => $days_of_school ?? [],
                    'Days Present'   => $days_present   ?? [],
                    'Times Tardy'    => $times_tardy    ?? []
                ];

                foreach ($categories as $label => $dataRow): ?>
                    <tr>
                        <td style="text-align: left;"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php
                        $total = 0;
                        if (!empty($months)) :
                            foreach ($months as $month):
                                $val = isset($dataRow[$month]) ? (float)$dataRow[$month] : 0.0;
                                $total += $val;
                        ?>
                                <td style="text-align: center;">
                                    <?= ($val == 0.0) ? '' : ($val == 1.0 ? '1' : rtrim(rtrim(number_format($val, 2), '0'), '.')); ?>
                                </td>
                        <?php
                            endforeach;
                        endif; ?>
                        <td style="text-align: center;">
                            <?= ($total == 0.0) ? '' : (($total == 1.0) ? '1' : rtrim(rtrim(number_format($total, 2), '0'), '.')); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="bwrap">
            <table class="tb3">
                <?php
                $arg = ['Eligible for transfer & admission', 'Has advanced credit in', 'Lack credits in', 'Date:'];
                foreach ($arg as $lbl) { ?>
                    <tr>
                        <td style="width:40%;"><?= htmlspecialchars($lbl, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td style="border-bottom:1px solid #000"></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="blocker"></div>

        <table class="tb4">
            <tr>
                <td style="width:20%; border-spacing:0 !important">Cancellation of Transfer Eligibily</td>
                <td class="thborder"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Had been admitted to</td>
                <td class="thborder"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Date:</td>
                <td class="thborder"></td>
                <td style="text-align:center;">
                    <b><span style="text-transform: uppercase"><?= htmlspecialchars($adviser, ENT_QUOTES, 'UTF-8'); ?></span></b>
                </td>
                <td style="text-align:center">
                    <b><span style="text-transform: uppercase"><?= htmlspecialchars($schoolHead, ENT_QUOTES, 'UTF-8'); ?></span></b>
                </td>
            </tr>
            <tr>
                <td>School Principal</td>
                <td class=" thborder"></td>
                <td class="text-center"><span class="ad_sign">Class Adviser</span></td>
                <td class="text-center"><span class="ad_sign">Principal</span></td>
            </tr>

            <?php if (!empty($narrative)) : ?>
                <tr>
                    <td colspan="4" style="padding-top: 20px;">
                        <table style="width:100%; border-collapse: collapse; font-size: 12px;">
                            <tr>
                                <th style="width:20%; border:1px solid #000; text-align:left; padding:5px;">First Quarter</th>
                                <td style="width:80%; border:1px solid #000; padding:5px;"><?= nl2br(htmlspecialchars($narrative->FirstQuarter ?? '', ENT_QUOTES, 'UTF-8')); ?></td>
                            </tr>
                            <tr>
                                <th style="width:20%; border:1px solid #000; text-align:left; padding:5px;">Second Quarter</th>
                                <td style="width:80%; border:1px solid #000; padding:5px;"><?= nl2br(htmlspecialchars($narrative->SecondQuarter ?? '', ENT_QUOTES, 'UTF-8')); ?></td>
                            </tr>
                            <tr>
                                <th style="width:20%; border:1px solid #000; text-align:left; padding:5px;">Third Quarter</th>
                                <td style="width:80%; border:1px solid #000; padding:5px;"><?= nl2br(htmlspecialchars($narrative->ThirdQuarter ?? '', ENT_QUOTES, 'UTF-8')); ?></td>
                            </tr>
                            <tr>
                                <th style="width:20%; border:1px solid #000; text-align:left; padding:5px;">Fourth Quarter</th>
                                <td style="width:80%; border:1px solid #000; padding:5px;"><?= nl2br(htmlspecialchars($narrative->FourthQuarter ?? '', ENT_QUOTES, 'UTF-8')); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>

</html>
