<?php
/**
 * Tahsin Academy - Official Lesson Plan Sheet
 * Location: application/views/scheme/lesson_plan.php
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($single_title) ? $single_title : 'Lesson Plan Sheet'; ?> | Tahsin Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            padding: 30px;
            font-size: 13px;
            line-height: 1.5;
        }

        .paper-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }

        .btn-toolbar {
            max-width: 900px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #1e293b;
        }
        .btn-primary {
            background: #0284c7;
            color: #fff;
            border-color: #0284c7;
        }

        /* School Header */
        .plan-header {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 16px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .school-brand h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 22px;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .school-brand p {
            color: #64748b;
            font-size: 12px;
            margin-top: 2px;
        }
        .doc-badge {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 8px 14px;
            border-radius: 6px;
            text-align: right;
        }
        .doc-badge h3 {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            color: #0284c7;
        }
        .doc-badge span {
            font-size: 11px;
            color: #64748b;
        }

        /* Meta Grid */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .meta-table th, .meta-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            font-size: 12.5px;
        }
        .meta-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            width: 18%;
        }
        .meta-table td {
            font-weight: 600;
            color: #0f172a;
        }

        /* Section Boxes */
        .plan-section {
            margin-bottom: 18px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            overflow: hidden;
        }
        .section-header {
            background: #f8fafc;
            padding: 8px 14px;
            border-bottom: 1px solid #cbd5e1;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-body {
            padding: 14px 16px;
            font-size: 13px;
            line-height: 1.6;
            white-space: pre-line;
            color: #1e293b;
        }

        /* Split Columns */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 18px;
        }

        /* Signatures */
        .approvals {
            margin-top: 36px;
            padding-top: 20px;
            border-top: 2px dashed #cbd5e1;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }
        .sig-block {
            border-top: 1px solid #0f172a;
            padding-top: 8px;
            font-size: 11px;
            color: #475569;
            text-align: center;
        }
        .sig-block strong {
            display: block;
            color: #0f172a;
            font-size: 12px;
            margin-bottom: 2px;
        }

        @media print {
            body { padding: 0; background: #fff; }
            .btn-toolbar { display: none; }
            .paper-container {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body>

<div class="btn-toolbar">
    <a href="<?php echo site_url('scheme'); ?>" class="btn-action">
        <i class="fa fa-arrow-left"></i> Back to Scheme Hub
    </a>
    <button onclick="window.print()" class="btn-action btn-primary">
        <i class="fa fa-print"></i> Print Lesson Plan Sheet
    </button>
</div>

<div class="paper-container">
    <div class="plan-header">
        <div class="school-brand">
            <h1>Tahsin Academy</h1>
            <p>Early Childhood & Primary Academic Excellence System</p>
        </div>
        <div class="doc-badge">
            <h3>Lesson Plan Sheet</h3>
            <span>Syllabus Tracking ID #<?php echo $scheme['id']; ?></span>
        </div>
    </div>

    <table class="meta-table">
        <tr>
            <th>Class Level:</th>
            <td><?php echo html_escape($scheme['grade_level']); ?></td>
            <th>Academic Term:</th>
            <td><?php echo html_escape($scheme['academic_term']); ?></td>
        </tr>
        <tr>
            <th>Week / Duration:</th>
            <td><?php echo html_escape($scheme['week_number']); ?> (<?php echo html_escape($scheme['period_day']); ?>)</td>
            <th>Subject:</th>
            <td><?php echo html_escape($scheme['subject']); ?></td>
        </tr>
        <tr>
            <th>Core Textbook:</th>
            <td><?php echo html_escape($scheme['reference_book']); ?></td>
            <th>Pacing Status:</th>
            <td>
                <?php
                    $pacing = isset($scheme['delivery_status']) ? $scheme['delivery_status'] : 'not_started';
                    echo ucwords(str_replace('_', ' ', $pacing));
                ?>
            </td>
        </tr>
    </table>

    <div class="plan-section">
        <div class="section-header">
            <i class="fa fa-bullseye"></i> Topic & Sub-Topic
        </div>
        <div class="section-body">
            <strong><?php echo html_escape($scheme['topic']); ?></strong>
            <?php if (!empty($scheme['sub_topic'])): ?>
                <div style="color:#64748b; font-size:12.5px; margin-top:2px;">
                    Focus: <?php echo html_escape($scheme['sub_topic']); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="plan-section">
        <div class="section-header">
            <i class="fa fa-graduation-cap"></i> Behavioral Learning Objectives (Outcomes)
        </div>
        <div class="section-body">
            <?php echo html_escape($scheme['objectives']); ?>
        </div>
    </div>

    <div class="grid-2">
        <div class="plan-section" style="margin-bottom:0;">
            <div class="section-header">
                <i class="fa fa-chalkboard-teacher"></i> Teacher's Instructional Activities
            </div>
            <div class="section-body">
                <?php echo !empty($scheme['teacher_activities']) ? html_escape($scheme['teacher_activities']) : 'Facilitate interactive instruction, stroke modeling, phonetic blending, and guided repetition.'; ?>
            </div>
        </div>

        <div class="plan-section" style="margin-bottom:0;">
            <div class="section-header">
                <i class="fa fa-users"></i> Pupil's Learning Activities
            </div>
            <div class="section-body">
                <?php echo !empty($scheme['pupil_activities']) ? html_escape($scheme['pupil_activities']) : 'Pupils participate in choral chant, identify flashcards, trace strokes, and complete guided exercises.'; ?>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="plan-section" style="margin-bottom:0;">
            <div class="section-header">
                <i class="fa fa-pen"></i> Classroom Seatwork
            </div>
            <div class="section-body">
                <?php echo html_escape($scheme['class_work']); ?>
            </div>
        </div>

        <div class="plan-section" style="margin-bottom:0;">
            <div class="section-header">
                <i class="fa fa-home"></i> Homework Assignment
            </div>
            <div class="section-body">
                <?php echo !empty($scheme['home_work']) ? html_escape($scheme['home_work']) : 'Review day\'s lesson with parents and practice designated workbook page.'; ?>
            </div>
        </div>
    </div>

    <div class="grid-2" style="margin-top: 18px;">
        <div class="plan-section" style="margin-bottom:0;">
            <div class="section-header">
                <i class="fa fa-cubes"></i> Teaching Aids & Resources
            </div>
            <div class="section-body">
                <?php echo !empty($scheme['teaching_aids']) ? html_escape($scheme['teaching_aids']) : 'Chalkboard, flashcards, charts, pupil workbooks.'; ?>
            </div>
        </div>

        <div class="plan-section" style="margin-bottom:0;">
            <div class="section-header">
                <i class="fa fa-check-double"></i> Evaluation & Assessment Method
            </div>
            <div class="section-body">
                <?php echo !empty($scheme['evaluation_strategy']) ? html_escape($scheme['evaluation_strategy']) : 'Oral questioning, individual workbook grading, stroke observation.'; ?>
            </div>
        </div>
    </div>

    <div class="approvals">
        <div class="sig-block">
            <strong>Subject Facilitator</strong>
            Signature & Date
        </div>
        <div class="sig-block">
            <strong>Academic Coordinator</strong>
            Checked & Approved
        </div>
        <div class="sig-block">
            <strong>Head of School / Director</strong>
            Final Stamp & Remark
        </div>
    </div>
</div>

</body>
</html>
