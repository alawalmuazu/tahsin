<?php
/**
 * Tahsin Academy - Scheme of Work Print View
 * Location: application/views/scheme/print_view.php
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($single_title) ? $single_title : 'Scheme of Work - Print Document'; ?> | Tahsin Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fff;
            color: #0f172a;
            padding: 30px;
            font-size: 13px;
            line-height: 1.5;
        }

        .print-header {
            border-bottom: 3px double #1e1b4b;
            padding-bottom: 20px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .school-info h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px;
            color: #1e1b4b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .school-info p {
            color: #475569;
            font-size: 12px;
        }

        .doc-meta {
            text-align: right;
            font-size: 12px;
            color: #64748b;
        }

        .doc-meta strong {
            color: #0f172a;
            display: block;
            font-size: 14px;
        }

        table.scheme-print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        table.scheme-print-table th, 
        table.scheme-print-table td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            text-align: left;
            vertical-align: top;
        }

        table.scheme-print-table th {
            background-color: #f1f5f9;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            font-size: 11.5px;
            letter-spacing: 0.5px;
        }

        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            padding-top: 20px;
        }

        .sig-block {
            width: 200px;
            border-top: 1px dashed #64748b;
            text-align: center;
            font-size: 11px;
            color: #475569;
            padding-top: 6px;
        }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            @page { margin: 1.5cm; }
        }

        .print-btn-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
        }

        .btn-print {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="no-print print-btn-bar">
    <button class="btn-print" onclick="window.print()">Print Syllabus / Scheme of Work</button>
    <button class="btn-print" style="background:#64748b;" onclick="window.close()">Close Window</button>
</div>

<div class="print-header">
    <div class="school-info">
        <h1>Tahsin Academy</h1>
        <p>Excellence in Islamic & Western Education | Early Childhood Curriculum Department</p>
        <p>Website: tahsinacademy.ng</p>
    </div>
    <div class="doc-meta">
        <strong>OFFICIAL SCHEME OF WORK</strong>
        <span>Printed On: <?php echo date('d M Y, h:i A'); ?></span>
    </div>
</div>

<table class="scheme-print-table">
    <thead>
        <tr>
            <th style="width: 80px;">Week</th>
            <th style="width: 140px;">Class & Subject</th>
            <th>Topic & Learning Objectives</th>
            <th>Teaching & Learning Activities</th>
            <th>Classwork & Homework</th>
            <th style="width: 140px;">Aids & Reference</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($schemes as $s): ?>
            <tr>
                <td>
                    <strong><?php echo html_escape($s['week_number']); ?></strong>
                    <div style="font-size: 10.5px; color:#64748b;"><?php echo html_escape($s['academic_term']); ?></div>
                </td>
                <td>
                    <strong><?php echo html_escape($s['grade_level']); ?></strong>
                    <div style="font-size: 11px; color:#4338ca;"><?php echo html_escape($s['subject']); ?></div>
                </td>
                <td>
                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">
                        <?php echo html_escape($s['topic']); ?>
                    </div>
                    <?php if (!empty($s['sub_topic'])): ?>
                        <div style="font-size: 11px; color: #475569; margin-bottom: 6px; font-style: italic;">
                            Sub: <?php echo html_escape($s['sub_topic']); ?>
                        </div>
                    <?php endif; ?>
                    <div style="white-space: pre-line; font-size: 12px;">
                        <strong>Objectives:</strong><br><?php echo html_escape($s['objectives']); ?>
                    </div>
                </td>
                <td>
                    <?php if (!empty($s['teacher_activities'])): ?>
                        <div style="margin-bottom: 4px;">
                            <strong>Teacher:</strong> <?php echo html_escape($s['teacher_activities']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($s['pupil_activities'])): ?>
                        <div>
                            <strong>Pupil:</strong> <?php echo html_escape($s['pupil_activities']); ?>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="margin-bottom: 6px;">
                        <strong>CW:</strong> <?php echo html_escape($s['class_work']); ?>
                    </div>
                    <?php if (!empty($s['home_work'])): ?>
                        <div style="color: #92400e;">
                            <strong>HW:</strong> <?php echo html_escape($s['home_work']); ?>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <div><strong>Aids:</strong> <?php echo html_escape($s['teaching_aids']); ?></div>
                    <div style="margin-top: 4px; font-size: 11px; color: #475569;">
                        <strong>Ref:</strong> <?php echo html_escape($s['reference_book']); ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="signatures">
    <div class="sig-block">Subject Teacher's Signature / Date</div>
    <div class="sig-block">Head of Early Childhood (EYFS)</div>
    <div class="sig-block">Head of School / Director Approval</div>
</div>

</body>
</html>
