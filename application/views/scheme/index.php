<?php
/**
 * Scheme of Work View
 * Tahsin Academy School Management System (tahsinacademy.ng)
 * Native UI/UX integrated with Tahsin Theme and Portus Admin components
 * Features: Pacing Status Radar, Dual View (Grid / Timeline), Instant Live Search,
 * Expandable Lesson Plan Drawer, WhatsApp Broadcast Digest, and Lesson Note Sheet.
 */
?>
<style>
/* Scheme Hub & Header */
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

/* Stat & Velocity Cards */
.scheme-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
    height: 100%;
}
.scheme-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}
.scheme-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.scheme-stat-info {
    flex: 1;
    min-width: 0;
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
.velocity-progress {
    height: 6px;
    border-radius: 3px;
    background: #e2e8f0;
    margin-top: 6px;
    overflow: hidden;
}
.velocity-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #059669);
    border-radius: 3px;
    transition: width 0.4s ease;
}

/* Badges & Pacing Status Pills */
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

/* Interactive Pacing Dropdown */
.pacing-dropdown {
    position: relative;
    display: inline-block;
}
.pacing-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 11.5px;
    font-weight: 700;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 0.15s ease;
}
.pacing-pill:hover {
    filter: brightness(0.95);
}
.pacing-not_started { background: #f1f5f9; color: #475569; border-color: #cbd5e1; }
.pacing-in_progress { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
.pacing-completed { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
.pacing-delayed { background: #fef3c7; color: #b45309; border-color: #fde68a; }

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
    cursor: pointer;
}
.scheme-topic-title:hover {
    color: #0284c7;
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

/* Inline Lesson Drawer Accordion */
.drawer-row td {
    background: #f8fafc !important;
    padding: 0 !important;
    border-top: none !important;
}
.drawer-content {
    padding: 20px 24px;
    border-bottom: 2px solid #e2e8f0;
    background: #ffffff;
}
.drawer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
    margin-bottom: 16px;
}
.drawer-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 12px 16px;
}
.drawer-box h5 {
    margin: 0 0 8px 0;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 6px;
}
.drawer-box p, .drawer-box div {
    font-size: 12.5px;
    line-height: 1.55;
    color: #1e293b;
    white-space: pre-line;
}
.drawer-footer-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    flex-wrap: wrap;
    border-top: 1px dashed #e2e8f0;
    padding-top: 12px;
}

/* Timeline Cards Stream View */
.timeline-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 20px;
}
.timeline-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.timeline-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.07);
}
.timeline-card-header {
    padding: 14px 18px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
    border-radius: 8px 8px 0 0;
}
.timeline-card-body {
    padding: 18px;
    flex: 1;
}
.timeline-card-body h4 {
    margin: 0 0 6px 0;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.timeline-card-footer {
    padding: 12px 18px;
    border-top: 1px solid #f1f5f9;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 0 0 8px 8px;
}

/* Live Instant Search Bar */
.live-search-wrap {
    position: relative;
    margin-top: 14px;
}
.live-search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}
.live-search-input {
    padding-left: 38px !important;
    border-radius: 20px !important;
    background: #f8fafc;
    border: 1px solid #cbd5e1 !important;
    transition: all 0.2s ease;
}
.live-search-input:focus {
    background: #fff;
    border-color: #0284c7 !important;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
}

/* WhatsApp Broadcast Modal */
#whatsappModal pre {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
    font-family: inherit;
    font-size: 13px;
    line-height: 1.6;
    white-space: pre-wrap;
    max-height: 380px;
    overflow-y: auto;
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
            <button type="button" class="btn btn-default" onclick="openGlobalWhatsAppModal()">
                <i class="fab fa-whatsapp text-success"></i> WhatsApp Digest
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

<!-- 4 Key Syllabus Metric & Velocity Counters -->
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
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <div class="scheme-stat-info">
                <h4>
                    <span id="pacingPercentText"><?php echo isset($pacing_stats['percentage']) ? $pacing_stats['percentage'] : 0; ?>%</span>
                    <span style="font-size:12px; color:#64748b; font-weight:600;">Delivered</span>
                </h4>
                <p>Pacing Velocity</p>
                <div class="velocity-progress">
                    <div id="pacingProgressBar" class="velocity-progress-bar" style="width: <?php echo isset($pacing_stats['percentage']) ? $pacing_stats['percentage'] : 0; ?>%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-sm">
        <div class="scheme-stat-card">
            <div class="scheme-stat-icon" style="background:#fef3c7; color:#d97706;">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="scheme-stat-info">
                <h4>Pre-N to N2</h4>
                <p>Covered Tiers</p>
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

            <!-- Client-Side Instant Live Search Bar -->
            <div class="live-search-wrap">
                <i class="fas fa-search live-search-icon"></i>
                <input type="text" id="schemeLiveSearch" class="form-control live-search-input" placeholder="⚡ Instant search: type phonics sound, topic, objective, classwork, or week (instant keystroke filter)...">
            </div>
        </form>
    </div>
</section>

<!-- Curriculum Syllabus Breakdown Section (Dual-Mode: Table vs Timeline) -->
<section class="panel">
    <header class="panel-heading" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <h4 class="panel-title mb-none"><i class="fas fa-clipboard-list"></i> Curriculum Weekly Syllabus Breakdown</h4>
        
        <div style="display:flex; align-items:center; gap:10px;">
            <!-- View Mode Switcher -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default btn-sm active" id="btnViewTable" onclick="switchView('table')">
                    <i class="fas fa-table"></i> Table Grid
                </button>
                <button type="button" class="btn btn-default btn-sm" id="btnViewCards" onclick="switchView('cards')">
                    <i class="fas fa-th-large"></i> Timeline Cards
                </button>
            </div>

            <span id="recordsCounterBadge" class="label label-primary" style="font-size:12px; padding:5px 10px; border-radius:10px;">
                Showing <?php echo count($schemes); ?> records
            </span>
        </div>
    </header>

    <div class="panel-body">
        <!-- MODE 1: Table Grid View -->
        <div id="viewTableContainer" class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-none table-scheme" id="mainSchemeTable">
                <thead>
                    <tr>
                        <th style="width: 45px;" class="text-center">#</th>
                        <th style="width: 130px;" class="text-center">Pacing Status</th>
                        <th style="width: 160px;">Class & Term</th>
                        <th style="width: 80px;" class="text-center">Week</th>
                        <th style="width: 230px;">Topic & Focus</th>
                        <th>Learning Objectives</th>
                        <th style="width: 200px;">Class Work & Homework</th>
                        <th style="width: 140px;">Teaching Aids</th>
                        <th style="width: 175px;" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($schemes)): ?>
                        <tr id="emptyRowState">
                            <td colspan="9" class="text-center text-muted" style="padding: 48px 20px;">
                                <i class="far fa-folder-open fa-3x mb-sm" style="display:block; opacity:0.6;"></i>
                                <strong>No scheme records found matching your filter criteria.</strong>
                                <p class="text-muted mt-xs" style="margin-bottom:0;">Try adjusting your class level, academic term, or subject filter.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($schemes as $s): ?>
                            <?php 
                                $status = !empty($s['delivery_status']) ? $s['delivery_status'] : 'not_started';
                                $statusLabel = ucwords(str_replace('_', ' ', $status));
                                $statusClass = 'pacing-' . $status;
                            ?>
                            <tr class="scheme-data-row" data-id="<?php echo $s['id']; ?>" data-search-corpus="<?php echo strtolower(html_escape($s['grade_level'] . ' ' . $s['academic_term'] . ' ' . $s['week_number'] . ' ' . $s['subject'] . ' ' . $s['topic'] . ' ' . $s['sub_topic'] . ' ' . $s['objectives'] . ' ' . $s['class_work'] . ' ' . $s['home_work'] . ' ' . $s['teaching_aids'])); ?>">
                                <td class="text-center">
                                    <span class="text-muted font-weight-bold">#<?php echo $s['id']; ?></span>
                                </td>

                                <!-- Interactive Pacing Dropdown Pill -->
                                <td class="text-center">
                                    <div class="dropdown pacing-dropdown">
                                        <button class="pacing-pill <?php echo $statusClass; ?> dropdown-toggle" type="button" id="pacingBtn_<?php echo $s['id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="pacing-icon">
                                                <?php if ($status == 'completed'): ?>
                                                    <i class="fas fa-check-circle"></i>
                                                <?php elseif ($status == 'in_progress'): ?>
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                <?php elseif ($status == 'delayed'): ?>
                                                    <i class="fas fa-exclamation-circle"></i>
                                                <?php else: ?>
                                                    <i class="far fa-circle"></i>
                                                <?php endif; ?>
                                            </span>
                                            <span class="pacing-label"><?php echo $statusLabel; ?></span>
                                            <i class="fas fa-chevron-down" style="font-size:9px; opacity:0.7;"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="pacingBtn_<?php echo $s['id']; ?>" style="font-size:12px;">
                                            <li><a href="javascript:void(0);" onclick="setPacingStatus(<?php echo $s['id']; ?>, 'not_started')"><i class="far fa-circle text-muted"></i> Not Started</a></li>
                                            <li><a href="javascript:void(0);" onclick="setPacingStatus(<?php echo $s['id']; ?>, 'in_progress')"><i class="fas fa-spinner text-info"></i> In Progress</a></li>
                                            <li><a href="javascript:void(0);" onclick="setPacingStatus(<?php echo $s['id']; ?>, 'completed')"><i class="fas fa-check-circle text-success"></i> Completed</a></li>
                                            <li><a href="javascript:void(0);" onclick="setPacingStatus(<?php echo $s['id']; ?>, 'delayed')"><i class="fas fa-exclamation-circle text-warning"></i> Delayed / Pending</a></li>
                                        </ul>
                                    </div>
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
                                    <div class="scheme-topic-title" onclick="toggleDrawer(<?php echo $s['id']; ?>)" title="Click to view detailed lesson breakdown">
                                        <?php echo html_escape($s['topic']); ?>
                                        <i class="fas fa-chevron-down text-muted" id="drawerChevron_<?php echo $s['id']; ?>" style="font-size:10px; margin-left:4px;"></i>
                                    </div>
                                    <?php if (!empty($s['sub_topic'])): ?>
                                        <div class="scheme-subtopic-text">
                                            <?php echo html_escape($s['sub_topic']); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div style="font-size: 12.5px; line-height: 1.45; white-space: pre-line;">
                                        <?php echo character_limiter(html_escape($s['objectives']), 140); ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="scheme-work-preview">
                                        <i class="fas fa-pen-alt"></i> <?php echo character_limiter(html_escape($s['class_work']), 60); ?>
                                    </div>
                                    <?php if (!empty($s['home_work'])): ?>
                                        <div class="scheme-home-preview">
                                            <i class="fas fa-home"></i> <?php echo character_limiter(html_escape($s['home_work']), 60); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="text-muted" style="font-size: 12px;">
                                        <?php echo html_escape($s['teaching_aids']); ?>
                                    </div>
                                </td>

                                <td class="scheme-actions-cell">
                                    <!-- Lesson Plan Sheet -->
                                    <a href="<?php echo site_url('scheme/lesson_plan/' . $s['id']); ?>" target="_blank" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Generate Lesson Plan Sheet">
                                        <i class="fas fa-file-alt text-primary"></i>
                                    </a>
                                    <!-- WhatsApp Digest -->
                                    <button type="button" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Generate WhatsApp Broadcast" onclick="openWhatsAppModal(<?php echo $s['id']; ?>)">
                                        <i class="fab fa-whatsapp text-success"></i>
                                    </button>
                                    <!-- Print Syllabus Card -->
                                    <a href="<?php echo site_url('scheme/print_view/' . $s['id']); ?>" target="_blank" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Print Syllabus Card">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <!-- Edit Scheme -->
                                    <button type="button" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Edit Scheme" onclick="openEditModal(<?php echo $s['id']; ?>)">
                                        <i class="fas fa-pen-nib"></i>
                                    </button>
                                    <!-- Duplicate -->
                                    <a href="<?php echo site_url('scheme/duplicate/' . $s['id']); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Duplicate Scheme Entry">
                                        <i class="far fa-copy"></i>
                                    </a>
                                    <!-- Delete / Archive -->
                                    <?php echo btn_delete('scheme/delete/' . $s['id']); ?>
                                </td>
                            </tr>

                            <!-- Expandable Inline Lesson Plan Drawer -->
                            <tr class="drawer-row" id="drawer_<?php echo $s['id']; ?>" style="display:none;">
                                <td colspan="9">
                                    <div class="drawer-content">
                                        <div class="drawer-grid">
                                            <div class="drawer-box">
                                                <h5><i class="fas fa-bullseye text-primary"></i> Behavioral Objectives</h5>
                                                <div><?php echo html_escape($s['objectives']); ?></div>
                                            </div>
                                            <div class="drawer-box">
                                                <h5><i class="fas fa-chalkboard-teacher text-info"></i> Teacher's Instructional Steps</h5>
                                                <div><?php echo !empty($s['teacher_activities']) ? html_escape($s['teacher_activities']) : 'Model pencil grip, letter sounds, choral chanting, and step-by-step guidance.'; ?></div>
                                            </div>
                                            <div class="drawer-box">
                                                <h5><i class="fas fa-users text-warning"></i> Pupil Learning Prompts</h5>
                                                <div><?php echo !empty($s['pupil_activities']) ? html_escape($s['pupil_activities']) : 'Pupils echo choral phonics, air-trace letters, and complete workbook practice.'; ?></div>
                                            </div>
                                        </div>

                                        <div class="drawer-grid">
                                            <div class="drawer-box">
                                                <h5><i class="fas fa-pen text-success"></i> Classroom Practice</h5>
                                                <div><?php echo html_escape($s['class_work']); ?></div>
                                            </div>
                                            <div class="drawer-box">
                                                <h5><i class="fas fa-home text-danger"></i> Homework Reinforcement</h5>
                                                <div><?php echo !empty($s['home_work']) ? html_escape($s['home_work']) : 'Review lesson at home with parents.'; ?></div>
                                            </div>
                                            <div class="drawer-box">
                                                <h5><i class="fas fa-check-double text-purple"></i> Evaluation & Aids</h5>
                                                <div>
                                                    <strong>Aids:</strong> <?php echo html_escape($s['teaching_aids']); ?><br>
                                                    <strong>Evaluation:</strong> <?php echo !empty($s['evaluation_strategy']) ? html_escape($s['evaluation_strategy']) : 'Oral questioning and workbook grading'; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="drawer-footer-actions">
                                            <a href="<?php echo site_url('scheme/lesson_plan/' . $s['id']); ?>" target="_blank" class="btn btn-primary btn-sm">
                                                <i class="fas fa-file-alt"></i> Print Lesson Plan Sheet
                                            </a>
                                            <button type="button" class="btn btn-success btn-sm" onclick="openWhatsAppModal(<?php echo $s['id']; ?>)">
                                                <i class="fab fa-whatsapp"></i> Broadcast on WhatsApp
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm" onclick="openEditModal(<?php echo $s['id']; ?>)">
                                                <i class="fas fa-pen-nib"></i> Edit Lesson Record
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- MODE 2: Timeline Cards Stream View -->
        <div id="viewCardsContainer" style="display:none;">
            <div class="timeline-grid" id="mainTimelineCards">
                <?php if (!empty($schemes)): foreach ($schemes as $s): ?>
                    <?php 
                        $status = !empty($s['delivery_status']) ? $s['delivery_status'] : 'not_started';
                        $statusLabel = ucwords(str_replace('_', ' ', $status));
                        $statusClass = 'pacing-' . $status;
                    ?>
                    <div class="timeline-card scheme-data-card" data-id="<?php echo $s['id']; ?>" data-search-corpus="<?php echo strtolower(html_escape($s['grade_level'] . ' ' . $s['academic_term'] . ' ' . $s['week_number'] . ' ' . $s['subject'] . ' ' . $s['topic'] . ' ' . $s['sub_topic'] . ' ' . $s['objectives'] . ' ' . $s['class_work'] . ' ' . $s['home_work'] . ' ' . $s['teaching_aids'])); ?>">
                        <div class="timeline-card-header">
                            <div>
                                <span class="scheme-badge scheme-badge-week"><?php echo html_escape($s['week_number']); ?></span>
                                <span class="scheme-badge scheme-badge-pn ml-xs"><?php echo html_escape($s['grade_level']); ?></span>
                            </div>
                            <div>
                                <span class="pacing-pill <?php echo $statusClass; ?>">
                                    <?php echo $statusLabel; ?>
                                </span>
                            </div>
                        </div>

                        <div class="timeline-card-body">
                            <h4><?php echo html_escape($s['topic']); ?></h4>
                            <?php if (!empty($s['sub_topic'])): ?>
                                <div class="text-muted" style="font-size:12px; margin-bottom:10px;">
                                    <?php echo html_escape($s['sub_topic']); ?>
                                </div>
                            <?php endif; ?>

                            <div style="font-size:12px; color:#334155; margin-bottom:12px; line-height:1.5;">
                                <strong>Objectives:</strong><br>
                                <?php echo character_limiter(html_escape($s['objectives']), 120); ?>
                            </div>

                            <div style="font-size:11.5px; color:#059669; margin-bottom:4px;">
                                <i class="fas fa-pen-alt"></i> <?php echo character_limiter(html_escape($s['class_work']), 50); ?>
                            </div>
                            <?php if (!empty($s['home_work'])): ?>
                                <div style="font-size:11.5px; color:#d97706;">
                                    <i class="fas fa-home"></i> <?php echo character_limiter(html_escape($s['home_work']), 50); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="timeline-card-footer">
                            <span class="text-muted" style="font-size:11px; font-weight:600;">
                                <?php echo html_escape($s['subject']); ?>
                            </span>
                            <div>
                                <a href="<?php echo site_url('scheme/lesson_plan/' . $s['id']); ?>" target="_blank" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Lesson Plan">
                                    <i class="fas fa-file-alt text-primary"></i>
                                </a>
                                <button type="button" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="WhatsApp Digest" onclick="openWhatsAppModal(<?php echo $s['id']; ?>)">
                                    <i class="fab fa-whatsapp text-success"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Edit" onclick="openEditModal(<?php echo $s['id']; ?>)">
                                    <i class="fas fa-pen-nib"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
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
                        <div class="col-md-3 col-sm-6 mb-sm">
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

                        <div class="col-md-3 col-sm-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Academic Term <span class="text-danger">*</span></label>
                                <select name="academic_term" id="form_academic_term" class="form-control" required>
                                    <option value="First Term">First Term</option>
                                    <option value="Second Term">Second Term</option>
                                    <option value="Third Term">Third Term</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Week Number <span class="text-danger">*</span></label>
                                <select name="week_number" id="form_week_number" class="form-control" required>
                                    <?php for($i = 1; $i <= 12; $i++): ?>
                                        <option value="Week <?php echo $i; ?>">Week <?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-sm">
                            <div class="form-group mb-none">
                                <label class="control-label">Pacing Status</label>
                                <select name="delivery_status" id="form_delivery_status" class="form-control">
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="delayed">Delayed</option>
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

<!-- WhatsApp Broadcast Generator Modal -->
<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#ecfdf5; border-bottom:1px solid #a7f3d0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:#065f46;"><i class="fab fa-whatsapp"></i> Weekly WhatsApp Syllabus Broadcast</h4>
            </div>
            <div class="modal-body">
                <p class="text-muted" style="font-size:12.5px; margin-bottom:12px;">
                    This message is formatted for class parent groups and weekly teacher notes. Click copy or send directly via WhatsApp:
                </p>
                <pre id="whatsappMessageContent">Loading syllabus broadcast message...</pre>
            </div>
            <div class="modal-footer" style="display:flex; justify-content:space-between; align-items:center;">
                <span id="copyToast" class="text-success font-weight-bold" style="display:none; font-size:12.5px;">
                    <i class="fas fa-check"></i> Copied to clipboard!
                </span>
                <div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" id="btnCopyWhatsApp" onclick="copyWhatsAppMessage()">
                        <i class="far fa-copy"></i> Copy Text
                    </button>
                    <a href="#" target="_blank" class="btn btn-success" id="btnSendWhatsApp">
                        <i class="fab fa-whatsapp"></i> Open in WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Open Add Scheme Modal
function openAddModal() {
    $('#schemeForm')[0].reset();
    $('#scheme_id').val('');
    $('#modalTitleText').text('Add Scheme of Work Entry');
    $('#form_delivery_status').val('not_started');
    $('#schemeModal').modal('show');
}

// Open Edit Scheme Modal
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
        $('#form_delivery_status').val(data.delivery_status || 'not_started');

        $('#modalTitleText').text('Edit Scheme of Work #' + data.id);
        $('#schemeModal').modal('show');
    }).fail(function(err) {
        alert('Failed to load scheme details for editing.');
        console.error(err);
    });
}

// Toggle Inline Lesson Plan Drawer
function toggleDrawer(id) {
    var $drawer = $('#drawer_' + id);
    var $icon = $('#drawerChevron_' + id);
    if ($drawer.is(':visible')) {
        $drawer.slideUp(180);
        $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
    } else {
        $drawer.slideDown(180);
        $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
    }
}

// Switch between Table Grid and Timeline Cards
function switchView(mode) {
    if (mode === 'cards') {
        $('#viewTableContainer').hide();
        $('#viewCardsContainer').fadeIn(200);
        $('#btnViewTable').removeClass('active');
        $('#btnViewCards').addClass('active');
    } else {
        $('#viewCardsContainer').hide();
        $('#viewTableContainer').fadeIn(200);
        $('#btnViewCards').removeClass('active');
        $('#btnViewTable').addClass('active');
    }
}

// Update Pacing Status via AJAX
function setPacingStatus(id, newStatus) {
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var postData = { id: id, delivery_status: newStatus };
    postData[csrfName] = csrfHash;

    $.post('<?php echo site_url('scheme/update_pacing_status'); ?>', postData, function(resp) {
        if (resp && resp.status === 'success') {
            // Update table pill
            var $btn = $('#pacingBtn_' + id);
            $btn.removeClass('pacing-not_started pacing-in_progress pacing-completed pacing-delayed')
                .addClass('pacing-' + newStatus);

            var iconHtml = '<i class="far fa-circle"></i>';
            if (newStatus === 'completed') iconHtml = '<i class="fas fa-check-circle"></i>';
            else if (newStatus === 'in_progress') iconHtml = '<i class="fas fa-spinner fa-spin"></i>';
            else if (newStatus === 'delayed') iconHtml = '<i class="fas fa-exclamation-circle"></i>';

            var labelText = newStatus.replace('_', ' ').replace(/\b\w/g, function(l){ return l.toUpperCase(); });
            $btn.find('.pacing-icon').html(iconHtml);
            $btn.find('.pacing-label').text(labelText);

            // Update card pill if present
            var $card = $('.scheme-data-card[data-id="' + id + '"]');
            if ($card.length) {
                $card.find('.pacing-pill')
                    .removeClass('pacing-not_started pacing-in_progress pacing-completed pacing-delayed')
                    .addClass('pacing-' + newStatus)
                    .text(labelText);
            }

            // Recalculate top velocity dynamically
            recalculatePacingVelocity();
        } else {
            alert('Could not update status. Please try again.');
        }
    }).fail(function() {
        alert('Server communication error.');
    });
}

// Dynamically recalculate pacing percentage on client-side
function recalculatePacingVelocity() {
    var total = $('.scheme-data-row').length;
    var completed = $('.pacing-completed').length;
    if (total > 0) {
        var pct = Math.round((completed / total) * 100);
        $('#pacingPercentText').text(pct + '%');
        $('#pacingProgressBar').css('width', pct + '%');
    }
}

// Real-Time Keystroke Instant Search
$('#schemeLiveSearch').on('keyup', function() {
    var query = $(this).val().toLowerCase().trim();
    var matchCount = 0;

    $('.scheme-data-row').each(function() {
        var corpus = $(this).data('search-corpus') || '';
        var rowId = $(this).data('id');
        if (query === '' || corpus.indexOf(query) !== -1) {
            $(this).show();
            matchCount++;
        } else {
            $(this).hide();
            $('#drawer_' + rowId).hide();
        }
    });

    $('.scheme-data-card').each(function() {
        var corpus = $(this).data('search-corpus') || '';
        if (query === '' || corpus.indexOf(query) !== -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

    $('#recordsCounterBadge').text('Showing ' + matchCount + ' records');
});

// Shortcut: press '/' to focus search bar
$(document).on('keydown', function(e) {
    if (e.key === '/' && !$(e.target).is('input, textarea, select')) {
        e.preventDefault();
        $('#schemeLiveSearch').focus();
    }
});

// Open WhatsApp Broadcast Modal for a Specific Row
function openWhatsAppModal(id) {
    $('#whatsappMessageContent').text('Generating weekly syllabus message...');
    $('#copyToast').hide();
    $('#whatsappModal').modal('show');

    $.getJSON('<?php echo site_url('scheme/whatsapp_digest/'); ?>' + id, function(res) {
        if (res && res.status === 'success') {
            $('#whatsappMessageContent').text(res.message);
            $('#btnSendWhatsApp').attr('href', 'https://api.whatsapp.com/send?text=' + res.encoded);
        } else {
            $('#whatsappMessageContent').text('Failed to load message.');
        }
    });
}

// Global WhatsApp digest for first active scheme
function openGlobalWhatsAppModal() {
    var firstId = $('.scheme-data-row:first').data('id');
    if (firstId) {
        openWhatsAppModal(firstId);
    } else {
        alert('No scheme records currently displayed to generate a digest.');
    }
}

// Copy WhatsApp Message to Clipboard
function copyWhatsAppMessage() {
    var text = $('#whatsappMessageContent').text();
    navigator.clipboard.writeText(text).then(function() {
        $('#copyToast').fadeIn().delay(2500).fadeOut();
    }).catch(function() {
        alert('Please select and copy manually.');
    });
}
</script>
