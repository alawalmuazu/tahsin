<?php
/**
 * Scheme of Work View
 * Tahsin Academy School Management System (tahsinacademy.ng)
 * Native UI/UX integrated with Tahsin Theme and Portus Admin components
 */
?>
<style>
/* Scheme of Work - Tahsin Native UI Enhancements */
.scheme-hub-panel {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}
.scheme-hub-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.scheme-hub-title h3 {
    margin: 0 0 4px 0;
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}
.scheme-hub-title p {
    margin: 0;
    color: #64748b;
    font-size: 13.5px;
}
.scheme-hub-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}

/* KPI / Stat Cards */
.scheme-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.scheme-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}
.scheme-stat-icon {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.scheme-stat-info h4 {
    margin: 0 0 2px 0;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.2;
}
.scheme-stat-info p {
    margin: 0;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

/* Badges */
.scheme-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.2px;
}
.scheme-badge-pn { background: #e0e7ff; color: #3730a3; }
.scheme-badge-n1 { background: #ecfdf5; color: #065f46; }
.scheme-badge-n2 { background: #fef3c7; color: #92400e; }
.scheme-badge-pri { background: #fee2e2; color: #991b1b; }
.scheme-badge-week { background: #f1f5f9; color: #334155; font-weight: 600; }

/* Table Specifics */
.table-scheme th {
    background-color: #f8fafc !important;
    color: #475569 !important;
    font-weight: 700 !important;
    font-size: 12.5px !important;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    vertical-align: middle !important;
}
.table-scheme td {
    font-size: 13px;
    vertical-align: top !important;
    line-height: 1.5;
}
.table-scheme tr:hover td {
    background-color: #fcfdfe !important;
}
.scheme-topic-title {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2px;
}
.scheme-subtopic-text {
    font-size: 12px;
    color: #64748b;
}
.scheme-work-preview {
    font-size: 12px;
    font-weight: 600;
    color: #059669;
    margin-bottom: 3px;
}
.scheme-home-preview {
    font-size: 11.5px;
    color: #d97706;
}
.scheme-actions-cell {
    white-space: nowrap;
    text-align: right;
}
.scheme-actions-cell .btn {
    margin-left: 2px;
}

/* Modal Enhancements */
#schemeModal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 16px 22px;
    border-radius: 6px 6px 0 0;
}
#schemeModal .modal-title {
    font-weight: 700;
    font-size: 16px;
    color: #1e293b;
}
#schemeModal .modal-body {
    padding: 22px;
}
#schemeModal .modal-footer {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 14px 22px;
    border-radius: 0 0 6px 6px;
}
#schemeModal .control-label {
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 4px;
}
</style>

<!-- Top Overview Hub & Quick Actions Bar -->
<div class="scheme-hub-panel">
    <div class="scheme-hub-header">
        <div class="scheme-hub-title">
            <h3><i class="fas fa-graduation-cap text-primary"></i> Curriculum Schemes of Work</h3>
            <p>Early Childhood & Primary Academic Syllabus Manager (Pre-Nursery, Nursery 1, Nursery 2)</p>
        </div>
        <div class="scheme-hub-actions">
            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus-circle"></i> Add Scheme Entry
            </button>
            <a href="<?php echo site_url('scheme/export_csv'); ?>" class="btn btn-default" data-toggle="tooltip" title="Export current database to CSV spreadsheet">
                <i class="fas fa-file-csv text-success"></i> Export CSV
            </a>
            <a href="<?php echo site_url('scheme/export_json'); ?>" class="btn btn-default" data-toggle="tooltip" title="Export syllabus database as JSON API backup">
                <i class="fas fa-file-code text-info"></i> Export JSON
            </a>
            <a href="<?php echo site_url('scheme/print_view?' . http_build_query($filters)); ?>" target="_blank" class="btn btn-default" data-toggle="tooltip" title="Open print-ready termly syllabus document">
                <i class="fas fa-print text-primary"></i> Print Termly View
            </a>
        </div>
    </div>
</div>

<!-- 4 Key Syllabus Metric Counters -->
<div class="row mb-md">
    <div class="col-md-3 col-sm-6 mb-sm">
        <div class="scheme-stat-card">
            <div class="scheme-stat-icon" style="background:#e0e7ff; color:#4338ca;">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="scheme-stat-info">
                <h4><?php echo count($schemes); ?></h4>
                <p>Visible Entries</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-sm">
        <div class="scheme-stat-card">
            <div class="scheme-stat-icon" style="background:#ecfdf5; color:#059669;">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="scheme-stat-info">
                <h4>Pre-N to N2</h4>
                <p>Covered Tiers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-sm">
        <div class="scheme-stat-card">
            <div class="scheme-stat-icon" style="background:#fef3c7; color:#d97706;">
                <i class="far fa-calendar-alt"></i>
            </div>
            <div class="scheme-stat-info">
                <h4>12 Weeks</h4>
                <p>Term Duration</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-sm">
        <div class="scheme-stat-card">
            <div class="scheme-stat-icon" style="background:#f1f5f9; color:#475569;">
                <i class="fas fa-award"></i>
            </div>
            <div class="scheme-stat-info">
                <h4>Rising Star</h4>
                <p>Core Curriculum</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section Panel -->
<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-filter"></i> Filter Scheme of Work</h4>
    </header>
    <div class="panel-body">
        <form method="GET" action="<?php echo site_url('scheme'); ?>" class="form-horizontal">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-sm">
                    <div class="form-group mb-none" style="margin-left:0; margin-right:0;">
                        <label class="control-label"><i class="fas fa-school text-muted"></i> Class Level</label>
                        <select name="grade_level" class="form-control" onchange="this.form.submit()">
                            <option value="ALL" <?php echo $filters['grade_level'] == 'ALL' ? 'selected' : ''; ?>>All Classes</option>
                            <?php if (!empty($distinct_levels)): foreach ($distinct_levels as $lvl): ?>
                                <option value="<?php echo html_escape($lvl); ?>" <?php echo $filters['grade_level'] == $lvl ? 'selected' : ''; ?>><?php echo html_escape($lvl); ?></option>
                            <?php endforeach; else: ?>
                                <option value="Pre-Nursery" <?php echo $filters['grade_level'] == 'Pre-Nursery' ? 'selected' : ''; ?>>Pre-Nursery</option>
                                <option value="Nursery 1" <?php echo $filters['grade_level'] == 'Nursery 1' ? 'selected' : ''; ?>>Nursery 1</option>
                                <option value="Nursery 2" <?php echo $filters['grade_level'] == 'Nursery 2' ? 'selected' : ''; ?>>Nursery 2</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-sm">
                    <div class="form-group mb-none" style="margin-left:0; margin-right:0;">
                        <label class="control-label"><i class="far fa-clock text-muted"></i> Academic Term</label>
                        <select name="academic_term" class="form-control" onchange="this.form.submit()">
                            <option value="ALL" <?php echo $filters['academic_term'] == 'ALL' ? 'selected' : ''; ?>>All Terms</option>
                            <option value="First Term" <?php echo $filters['academic_term'] == 'First Term' ? 'selected' : ''; ?>>First Term</option>
                            <option value="Second Term" <?php echo $filters['academic_term'] == 'Second Term' ? 'selected' : ''; ?>>Second Term</option>
                            <option value="Third Term" <?php echo $filters['academic_term'] == 'Third Term' ? 'selected' : ''; ?>>Third Term</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-sm">
                    <div class="form-group mb-none" style="margin-left:0; margin-right:0;">
                        <label class="control-label"><i class="fas fa-book text-muted"></i> Subject</label>
                        <select name="subject" class="form-control" onchange="this.form.submit()">
                            <option value="ALL" <?php echo $filters['subject'] == 'ALL' ? 'selected' : ''; ?>>All Subjects</option>
                            <?php if (!empty($distinct_subjects)): foreach ($distinct_subjects as $subj): ?>
                                <option value="<?php echo html_escape($subj); ?>" <?php echo $filters['subject'] == $subj ? 'selected' : ''; ?>><?php echo html_escape($subj); ?></option>
                            <?php endforeach; else: ?>
                                <option value="English Language / Literacy" <?php echo $filters['subject'] == 'English Language / Literacy' ? 'selected' : ''; ?>>English Language / Literacy</option>
                                <option value="Mathematics / Numeracy" <?php echo $filters['subject'] == 'Mathematics / Numeracy' ? 'selected' : ''; ?>>Mathematics / Numeracy</option>
                                <option value="Social & Civic Habits" <?php echo $filters['subject'] == 'Social & Civic Habits' ? 'selected' : ''; ?>>Social & Civic Habits</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-sm-6 mb-sm">
                    <div class="form-group mb-none" style="margin-left:0; margin-right:0;">
                        <label class="control-label"><i class="fas fa-hashtag text-muted"></i> Week</label>
                        <select name="week_number" class="form-control" onchange="this.form.submit()">
                            <option value="ALL" <?php echo $filters['week_number'] == 'ALL' ? 'selected' : ''; ?>>All Weeks</option>
                            <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="Week <?php echo $i; ?>" <?php echo $filters['week_number'] == 'Week ' . $i ? 'selected' : ''; ?>>Week <?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-1 col-sm-6 mb-sm">
                    <div class="form-group mb-none" style="margin-left:0; margin-right:0; padding-top: 24px;">
                        <a href="<?php echo site_url('scheme'); ?>" class="btn btn-default btn-block" data-toggle="tooltip" title="Reset all filters">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Curriculum Syllabus Table Section -->
<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-clipboard-list"></i> Curriculum Weekly Syllabus Breakdown</h4>
        <div class="panel-btn">
            <span class="label label-primary" style="font-size:12px; padding:5px 10px; border-radius:10px;">
                Showing <?php echo count($schemes); ?> records
            </span>
        </div>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-none table-scheme">
                <thead>
                    <tr>
                        <th style="width: 55px;" class="text-center">#</th>
                        <th style="width: 170px;">Class & Term</th>
                        <th style="width: 90px;" class="text-center">Week</th>
                        <th style="width: 220px;">Topic & Sub-Topic</th>
                        <th>Learning Objectives</th>
                        <th style="width: 220px;">Class Work & Homework</th>
                        <th style="width: 160px;">Teaching Aids</th>
                        <th style="width: 140px;" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($schemes)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted" style="padding: 48px 20px;">
                                <i class="far fa-folder-open fa-3x mb-sm" style="display:block; opacity:0.6;"></i>
                                <strong>No scheme records found matching your filter criteria.</strong>
                                <p class="text-muted mt-xs" style="margin-bottom:0;">Try adjusting your class level, academic term, or subject filter.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($schemes as $s): ?>
                            <tr>
                                <td class="text-center">
                                    <span class="text-muted font-weight-bold">#<?php echo $s['id']; ?></span>
                                </td>
                                <td>
                                    <?php 
                                        $badgeClass = 'scheme-badge-pn';
                                        if ($s['grade_level'] == 'Nursery 1') $badgeClass = 'scheme-badge-n1';
                                        elseif ($s['grade_level'] == 'Nursery 2') $badgeClass = 'scheme-badge-n2';
                                        elseif (stripos($s['grade_level'], 'Primary') !== false) $badgeClass = 'scheme-badge-pri';
                                    ?>
                                    <span class="scheme-badge <?php echo $badgeClass; ?>"><?php echo html_escape($s['grade_level']); ?></span>
                                    <div class="text-muted" style="font-size: 11.5px; margin-top: 4px;">
                                        <i class="far fa-calendar-check"></i> <?php echo html_escape($s['academic_term']); ?>
                                    </div>
                                    <div style="font-size: 11px; color: #4338ca; font-weight: 700; margin-top: 2px;">
                                        <?php echo html_escape($s['subject']); ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="scheme-badge scheme-badge-week"><?php echo html_escape($s['week_number']); ?></span>
                                </td>
                                <td>
                                    <div class="scheme-topic-title">
                                        <?php echo html_escape($s['topic']); ?>
                                    </div>
                                    <?php if (!empty($s['sub_topic'])): ?>
                                        <div class="scheme-subtopic-text">
                                            <?php echo html_escape($s['sub_topic']); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="font-size: 12.5px; line-height: 1.45; white-space: pre-line;">
                                        <?php echo character_limiter(html_escape($s['objectives']), 160); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="scheme-work-preview">
                                        <i class="fas fa-pen-alt"></i> <?php echo character_limiter(html_escape($s['class_work']), 70); ?>
                                    </div>
                                    <?php if (!empty($s['home_work'])): ?>
                                        <div class="scheme-home-preview">
                                            <i class="fas fa-home"></i> <?php echo character_limiter(html_escape($s['home_work']), 70); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="text-muted" style="font-size: 12px;">
                                        <?php echo html_escape($s['teaching_aids']); ?>
                                    </div>
                                </td>
                                <td class="scheme-actions-cell">
                                    <a href="<?php echo site_url('scheme/print_view/' . $s['id']); ?>" target="_blank" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Print Syllabus Card">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <button type="button" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Edit Scheme" onclick="openEditModal(<?php echo $s['id']; ?>)">
                                        <i class="fas fa-pen-nib"></i>
                                    </button>
                                    <a href="<?php echo site_url('scheme/duplicate/' . $s['id']); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Duplicate Scheme Entry">
                                        <i class="far fa-copy"></i>
                                    </a>
                                    <?php echo btn_delete('scheme/delete/' . $s['id']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Native Bootstrap Modal for Add / Edit Scheme -->
<div class="modal fade" id="schemeModal" tabindex="-1" role="dialog" aria-labelledby="schemeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="<?php echo site_url('scheme/save'); ?>" id="schemeForm">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="id" id="scheme_id" value="">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="schemeModalLabel"><i class="far fa-edit"></i> <span id="modalTitleText">Add Scheme of Work Entry</span></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Class Level <span class="text-danger">*</span></label>
                                <select name="grade_level" id="form_grade_level" class="form-control" required>
                                    <?php if (!empty($distinct_levels)): foreach ($distinct_levels as $lvl): ?>
                                        <option value="<?php echo html_escape($lvl); ?>"><?php echo html_escape($lvl); ?></option>
                                    <?php endforeach; else: ?>
                                        <option value="Pre-Nursery">Pre-Nursery</option>
                                        <option value="Nursery 1">Nursery 1</option>
                                        <option value="Nursery 2">Nursery 2</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Academic Term <span class="text-danger">*</span></label>
                                <select name="academic_term" id="form_academic_term" class="form-control" required>
                                    <option value="First Term">First Term</option>
                                    <option value="Second Term">Second Term</option>
                                    <option value="Third Term">Third Term</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Week Number <span class="text-danger">*</span></label>
                                <select name="week_number" id="form_week_number" class="form-control" required>
                                    <?php for($i = 1; $i <= 12; $i++): ?>
                                        <option value="Week <?php echo $i; ?>">Week <?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-sm">
                        <div class="col-md-6 col-sm-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" id="form_subject" list="form_subject_list" class="form-control" value="English Language / Literacy" required>
                                <datalist id="form_subject_list">
                                    <?php if (!empty($distinct_subjects)): foreach ($distinct_subjects as $subj): ?>
                                        <option value="<?php echo html_escape($subj); ?>"></option>
                                    <?php endforeach; endif; ?>
                                </datalist>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Reference Book / Series</label>
                                <input type="text" name="reference_book" id="form_reference_book" class="form-control" value="Rising Star Series">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-sm">
                        <div class="col-md-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Main Topic <span class="text-danger">*</span></label>
                                <input type="text" name="topic" id="form_topic" class="form-control" placeholder="e.g. Letter Sound /p/ & Vocabulary" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Sub-Topic</label>
                                <input type="text" name="sub_topic" id="form_sub_topic" class="form-control" placeholder="e.g. Tracing, Pen, Pot, Pig recognition">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-sm">
                        <div class="col-md-12 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Learning Objectives (Behavioral Outcomes) <span class="text-danger">*</span></label>
                                <textarea name="objectives" id="form_objectives" class="form-control" rows="3" placeholder="1. Identify letter sound...&#10;2. Trace stroke patterns...&#10;3. Name 3 associated objects..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-sm">
                        <div class="col-md-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Teacher Activities</label>
                                <textarea name="teacher_activities" id="form_teacher_activities" class="form-control" rows="2" placeholder="Demonstrates pencil grasp on chalkboard..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Pupil Activities</label>
                                <textarea name="pupil_activities" id="form_pupil_activities" class="form-control" rows="2" placeholder="Pupils echo chorus and air-trace..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-sm">
                        <div class="col-md-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Classroom Work <span class="text-danger">*</span></label>
                                <textarea name="class_work" id="form_class_work" class="form-control" rows="2" placeholder="Trace page 14 upper box; color item..." required></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Homework Assignment</label>
                                <textarea name="home_work" id="form_home_work" class="form-control" rows="2" placeholder="Complete workbook page 14 lower practice..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-sm">
                        <div class="col-md-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Teaching Aids / Instructional Resources</label>
                                <input type="text" name="teaching_aids" id="form_teaching_aids" class="form-control" placeholder="Wall charts, flashcards, plastic letters, realia">
                            </div>
                        </div>

                        <div class="col-md-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Evaluation / Assessment Strategy</label>
                                <input type="text" name="evaluation_strategy" id="form_evaluation_strategy" class="form-control" placeholder="Oral phonics drill, stroke check, worksheet grading">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Scheme Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddModal() {
    $('#schemeForm')[0].reset();
    $('#scheme_id').val('');
    $('#modalTitleText').text('Add Scheme of Work Entry');
    $('#schemeModal').modal('show');
}

function openEditModal(id) {
    $.getJSON('<?php echo site_url('scheme/get_json/'); ?>' + id, function(data) {
        if (!data || !data.id) {
            alert('Failed to load scheme details.');
            return;
        }
        $('#scheme_id').val(data.id);
        $('#form_grade_level').val(data.grade_level);
        $('#form_academic_term').val(data.academic_term);
        $('#form_week_number').val(data.week_number);
        $('#form_subject').val(data.subject);
        $('#form_reference_book').val(data.reference_book);
        $('#form_topic').val(data.topic);
        $('#form_sub_topic').val(data.sub_topic || '');
        $('#form_objectives').val(data.objectives);
        $('#form_teacher_activities').val(data.teacher_activities || '');
        $('#form_pupil_activities').val(data.pupil_activities || '');
        $('#form_class_work').val(data.class_work);
        $('#form_home_work').val(data.home_work || '');
        $('#form_teaching_aids').val(data.teaching_aids || '');
        $('#form_evaluation_strategy').val(data.evaluation_strategy || '');

        $('#modalTitleText').text('Edit Scheme of Work #' + data.id);
        $('#schemeModal').modal('show');
    }).fail(function(err) {
        alert('Failed to load scheme details for editing.');
        console.error(err);
    });
}
</script>
