<?php
/**
 * Tahsin Academy - Scheme of Work View
 * Location: application/views/scheme/index.php
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Schemes of Work | Tahsin Academy'; ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --secondary: #059669;
            --accent: #d97706;
            --bg-page: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            padding: 24px;
            line-height: 1.5;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Bar */
        .header-bar {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            border-radius: var(--radius-lg);
            padding: 28px 32px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px -5px rgba(49, 46, 129, 0.25);
        }

        .header-title h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 26px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title p {
            color: #c7d2fe;
            font-size: 14px;
            margin-top: 4px;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #10b981;
            color: white;
        }
        .btn-primary:hover { background: #059669; }

        .btn-light {
            background: rgba(255,255,255,0.15);
            color: white;
            backdrop-filter: blur(5px);
        }
        .btn-light:hover { background: rgba(255,255,255,0.25); }

        .btn-outline {
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-main);
        }
        .btn-outline:hover { background: #f1f5f9; }

        /* Notification Banners */
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* Metric Counters */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .metric-card {
            background: white;
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .metric-content h3 { font-size: 24px; font-weight: 700; }
        .metric-content p { font-size: 12.5px; color: var(--text-muted); font-weight: 500; }

        /* Filter Panel */
        .filter-panel {
            background: white;
            border-radius: var(--radius-md);
            padding: 18px 24px;
            border: 1px solid var(--border-color);
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: flex-end;
        }

        .form-group {
            flex: 1;
            min-width: 170px;
        }

        .form-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            background: #fff;
            color: var(--text-main);
            outline: none;
            transition: border 0.2s;
        }
        .form-control:focus { border-color: var(--primary); }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-header {
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .table-responsive {
            overflow-x: auto;
            max-width: 100%;
        }

        table.scheme-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
            text-align: left;
        }

        table.scheme-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            padding: 14px 16px;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        table.scheme-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }

        table.scheme-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .badge-pn { background: #e0e7ff; color: #3730a3; }
        .badge-n1 { background: #ecfdf5; color: #065f46; }
        .badge-n2 { background: #fef3c7; color: #92400e; }
        .badge-week { background: #f1f5f9; color: #334155; }

        .actions-cell {
            white-space: nowrap;
            display: flex;
            gap: 6px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }
        .btn-icon:hover { color: var(--primary); border-color: var(--primary); background: #eef2ff; }
        .btn-icon.delete:hover { color: #dc2626; border-color: #dc2626; background: #fef2f2; }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal.active { display: flex; }

        .modal-content {
            background: white;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 780px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: #f8fafc;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 14px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 14px;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <!-- Top Navigation & Action Header -->
    <div class="header-bar">
        <div class="header-title">
            <h1><i class="fa fa-graduation-cap"></i> Tahsin Academy Schemes of Work</h1>
            <p>Early Childhood & Primary Academic Syllabus Manager (Pre-Nursery, Nursery 1, Nursery 2)</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fa fa-plus-circle"></i> Add Scheme Entry
            </button>
            <a href="<?php echo site_url('scheme/export_csv'); ?>" class="btn btn-light">
                <i class="fa fa-file-csv"></i> Export CSV
            </a>
            <a href="<?php echo site_url('scheme/export_json'); ?>" class="btn btn-light">
                <i class="fa fa-file-code"></i> Export JSON
            </a>
            <a href="<?php echo site_url('scheme/print_view?' . http_build_query($filters)); ?>" target="_blank" class="btn btn-light">
                <i class="fa fa-print"></i> Print Termly View
            </a>
        </div>
    </div>

    <!-- Quick Stats Metrics -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon" style="background:#e0e7ff; color:#4338ca;">
                <i class="fa fa-layer-group"></i>
            </div>
            <div class="metric-content">
                <h3><?php echo count($schemes); ?></h3>
                <p>Visible Scheme Entries</p>
            </div>
        </div>
        <div class="metric-card">
            <div class="metric-icon" style="background:#ecfdf5; color:#059669;">
                <i class="fa fa-book-open"></i>
            </div>
            <div class="metric-content">
                <h3>Pre-Nursery to N2</h3>
                <p>Covered Tiers</p>
            </div>
        </div>
        <div class="metric-card">
            <div class="metric-icon" style="background:#fef3c7; color:#d97706;">
                <i class="fa fa-calendar-alt"></i>
            </div>
            <div class="metric-content">
                <h3>12 Weeks</h3>
                <p>Term Duration</p>
            </div>
        </div>
        <div class="metric-card">
            <div class="metric-icon" style="background:#f1f5f9; color:#475569;">
                <i class="fa fa-spell-check"></i>
            </div>
            <div class="metric-content">
                <h3>Rising Star</h3>
                <p>Standard Curriculum</p>
            </div>
        </div>
    </div>

    <!-- Filtering Bar -->
    <div class="filter-panel">
        <form method="GET" action="<?php echo site_url('scheme'); ?>" class="filter-form">
            <div class="form-group">
                <label><i class="fa fa-school"></i> Class Level</label>
                <select name="grade_level" class="form-control" onchange="this.form.submit()">
                    <option value="ALL" <?php echo $filters['grade_level'] == 'ALL' ? 'selected' : ''; ?>>All Classes</option>
                    <option value="Pre-Nursery" <?php echo $filters['grade_level'] == 'Pre-Nursery' ? 'selected' : ''; ?>>Pre-Nursery</option>
                    <option value="Nursery 1" <?php echo $filters['grade_level'] == 'Nursery 1' ? 'selected' : ''; ?>>Nursery 1</option>
                    <option value="Nursery 2" <?php echo $filters['grade_level'] == 'Nursery 2' ? 'selected' : ''; ?>>Nursery 2</option>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fa fa-clock"></i> Academic Term</label>
                <select name="academic_term" class="form-control" onchange="this.form.submit()">
                    <option value="ALL" <?php echo $filters['academic_term'] == 'ALL' ? 'selected' : ''; ?>>All Terms</option>
                    <option value="First Term" <?php echo $filters['academic_term'] == 'First Term' ? 'selected' : ''; ?>>First Term</option>
                    <option value="Second Term" <?php echo $filters['academic_term'] == 'Second Term' ? 'selected' : ''; ?>>Second Term</option>
                    <option value="Third Term" <?php echo $filters['academic_term'] == 'Third Term' ? 'selected' : ''; ?>>Third Term</option>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fa fa-book"></i> Subject</label>
                <select name="subject" class="form-control" onchange="this.form.submit()">
                    <option value="ALL" <?php echo $filters['subject'] == 'ALL' ? 'selected' : ''; ?>>All Subjects</option>
                    <option value="English Language / Literacy" <?php echo $filters['subject'] == 'English Language / Literacy' ? 'selected' : ''; ?>>English Literacy</option>
                    <option value="Numerical Mathematics" <?php echo $filters['subject'] == 'Numerical Mathematics' ? 'selected' : ''; ?>>Numerical Mathematics</option>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fa fa-hashtag"></i> Week</label>
                <select name="week_number" class="form-control" onchange="this.form.submit()">
                    <option value="ALL" <?php echo $filters['week_number'] == 'ALL' ? 'selected' : ''; ?>>All Weeks</option>
                    <?php for($i=1; $i<=12; $i++): ?>
                        <option value="Week <?php echo $i; ?>" <?php echo $filters['week_number'] == 'Week '.$i ? 'selected' : ''; ?>>Week <?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <a href="<?php echo site_url('scheme'); ?>" class="btn btn-outline" style="height: 42px;">
                    <i class="fa fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table Container -->
    <div class="table-card">
        <div class="table-header">
            <h2 style="font-size: 17px; font-weight: 700;">Curriculum Weekly Syllabus Breakdown</h2>
            <span style="font-size: 13px; color: var(--text-muted); font-weight: 600;">
                Showing <?php echo count($schemes); ?> records
            </span>
        </div>
        <div class="table-responsive">
            <table class="scheme-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Class & Term</th>
                        <th>Week</th>
                        <th>Topic & Sub-Topic</th>
                        <th>Learning Objectives</th>
                        <th>Class Work & Homework</th>
                        <th>Teaching Aids</th>
                        <th style="text-align: right; width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($schemes)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 48px; color: var(--text-muted);">
                                <i class="fa fa-folder-open" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
                                No scheme records found matching this filter criteria.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($schemes as $s): ?>
                            <tr>
                                <td><span style="font-weight: 700; color: #64748b;">#<?php echo $s['id']; ?></span></td>
                                <td>
                                    <?php 
                                        $badgeClass = 'badge-pn';
                                        if ($s['grade_level'] == 'Nursery 1') $badgeClass = 'badge-n1';
                                        if ($s['grade_level'] == 'Nursery 2') $badgeClass = 'badge-n2';
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?>"><?php echo html_escape($s['grade_level']); ?></span>
                                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                                        <?php echo html_escape($s['academic_term']); ?>
                                    </div>
                                    <div style="font-size: 11px; color: #4338ca; font-weight: 600; margin-top: 2px;">
                                        <?php echo html_escape($s['subject']); ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-week"><?php echo html_escape($s['week_number']); ?></span>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 2px;">
                                        <?php echo html_escape($s['topic']); ?>
                                    </div>
                                    <?php if (!empty($s['sub_topic'])): ?>
                                        <div style="font-size: 12px; color: var(--text-muted);">
                                            <?php echo html_escape($s['sub_topic']); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="max-width: 320px; font-size: 12.5px; line-height: 1.45; white-space: pre-line;">
                                        <?php echo character_limiter(html_escape($s['objectives']), 160); ?>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 12px; font-weight: 600; color: #059669;">
                                        <i class="fa fa-pen"></i> <?php echo character_limiter(html_escape($s['class_work']), 70); ?>
                                    </div>
                                    <?php if (!empty($s['home_work'])): ?>
                                        <div style="font-size: 11.5px; color: #d97706; margin-top: 4px;">
                                            <i class="fa fa-home"></i> <?php echo character_limiter(html_escape($s['home_work']), 70); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="font-size: 12px; color: #475569;">
                                        <?php echo html_escape($s['teaching_aids']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="actions-cell" style="justify-content: flex-end;">
                                        <a href="<?php echo site_url('scheme/print_view/'.$s['id']); ?>" target="_blank" class="btn-icon" title="Print Scheme Card">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        <button type="button" class="btn-icon" title="Edit Scheme" onclick="openEditModal(<?php echo $s['id']; ?>)">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <a href="<?php echo site_url('scheme/duplicate/'.$s['id']); ?>" class="btn-icon" title="Duplicate Scheme">
                                            <i class="fa fa-clone"></i>
                                        </a>
                                        <a href="<?php echo site_url('scheme/delete/'.$s['id']); ?>" class="btn-icon delete" title="Archive / Delete" onclick="return confirm('Are you sure you want to archive scheme #<?php echo $s['id']; ?>?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Create / Edit Scheme Modal -->
<div id="schemeModal" class="modal">
    <div class="modal-content">
        <form method="POST" action="<?php echo site_url('scheme/save'); ?>" id="schemeForm">
            <input type="hidden" name="id" id="scheme_id" value="">
            <div class="modal-header">
                <h3 id="modalTitle" style="font-size: 18px; font-weight: 700;">Add Scheme of Work Entry</h3>
                <button type="button" onclick="closeModal()" style="background:none; border:none; font-size: 20px; cursor:pointer;">&times;</button>
            </div>
            <div class="modal-body">
                <div class="grid-3">
                    <div class="form-group">
                        <label>Class Level *</label>
                        <select name="grade_level" id="form_grade_level" class="form-control" required>
                            <option value="Pre-Nursery">Pre-Nursery</option>
                            <option value="Nursery 1">Nursery 1</option>
                            <option value="Nursery 2">Nursery 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Academic Term *</label>
                        <select name="academic_term" id="form_academic_term" class="form-control" required>
                            <option value="First Term">First Term</option>
                            <option value="Second Term">Second Term</option>
                            <option value="Third Term">Third Term</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Week Number *</label>
                        <select name="week_number" id="form_week_number" class="form-control" required>
                            <?php for($i=1; $i<=12; $i++): ?>
                                <option value="Week <?php echo $i; ?>">Week <?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Subject *</label>
                        <input type="text" name="subject" id="form_subject" class="form-control" value="English Language / Literacy" required>
                    </div>
                    <div class="form-group">
                        <label>Reference Book</label>
                        <input type="text" name="reference_book" id="form_reference_book" class="form-control" value="Rising Star Series">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Main Topic *</label>
                        <input type="text" name="topic" id="form_topic" class="form-control" placeholder="e.g. Letter Sound /p/ & Vocabulary" required>
                    </div>
                    <div class="form-group">
                        <label>Sub-Topic</label>
                        <input type="text" name="sub_topic" id="form_sub_topic" class="form-control" placeholder="e.g. Tracing, Pen, Pot, Pig recognition">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 14px;">
                    <label>Learning Objectives (Behavioral Outcomes) *</label>
                    <textarea name="objectives" id="form_objectives" class="form-control" rows="3" placeholder="1. Identify letter sound...&#10;2. Trace stroke patterns...&#10;3. Name 3 associated objects..." required></textarea>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Teacher Activities</label>
                        <textarea name="teacher_activities" id="form_teacher_activities" class="form-control" rows="2" placeholder="Demonstrates pencil grasp on chalkboard..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Pupil Activities</label>
                        <textarea name="pupil_activities" id="form_pupil_activities" class="form-control" rows="2" placeholder="Pupils echo chorus and air-trace..."></textarea>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Classroom Work *</label>
                        <textarea name="class_work" id="form_class_work" class="form-control" rows="2" placeholder="Trace page 14 upper box; color item..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Homework Assignment</label>
                        <textarea name="home_work" id="form_home_work" class="form-control" rows="2" placeholder="Complete workbook page 14 lower practice..."></textarea>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Teaching Aids / Instructional Resources</label>
                        <input type="text" name="teaching_aids" id="form_teaching_aids" class="form-control" placeholder="Wall charts, flashcards, plastic letters, realia">
                    </div>
                    <div class="form-group">
                        <label>Evaluation / Assessment Method</label>
                        <input type="text" name="evaluation_strategy" id="form_evaluation_strategy" class="form-control" placeholder="Oral phonics drill, stroke check, worksheet grading">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Scheme Record</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('schemeForm').reset();
    document.getElementById('scheme_id').value = '';
    document.getElementById('modalTitle').innerText = 'Add Scheme of Work Entry';
    document.getElementById('schemeModal').classList.add('active');
}

function openEditModal(id) {
    fetch('<?php echo site_url('scheme/get_json/'); ?>' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('scheme_id').value = data.id;
            document.getElementById('form_grade_level').value = data.grade_level;
            document.getElementById('form_academic_term').value = data.academic_term;
            document.getElementById('form_week_number').value = data.week_number;
            document.getElementById('form_subject').value = data.subject;
            document.getElementById('form_reference_book').value = data.reference_book;
            document.getElementById('form_topic').value = data.topic;
            document.getElementById('form_sub_topic').value = data.sub_topic || '';
            document.getElementById('form_objectives').value = data.objectives;
            document.getElementById('form_teacher_activities').value = data.teacher_activities || '';
            document.getElementById('form_pupil_activities').value = data.pupil_activities || '';
            document.getElementById('form_class_work').value = data.class_work;
            document.getElementById('form_home_work').value = data.home_work || '';
            document.getElementById('form_teaching_aids').value = data.teaching_aids || '';
            document.getElementById('form_evaluation_strategy').value = data.evaluation_strategy || '';

            document.getElementById('modalTitle').innerText = 'Edit Scheme of Work #' + data.id;
            document.getElementById('schemeModal').classList.add('active');
        })
        .catch(err => {
            alert('Failed to load scheme details for editing.');
            console.error(err);
        });
}

function closeModal() {
    document.getElementById('schemeModal').classList.remove('active');
}

window.onclick = function(event) {
    const modal = document.getElementById('schemeModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>

</body>
</html>
