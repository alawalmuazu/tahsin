<?php
/**
 * Live Classroom Session Hub & Launcher
 * Location: application/views/live_session/index.php
 * Tahsin Academy School Management System
 */
?>
<style>
.live-hub-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 22px 26px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}
.live-hub-header .header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.live-title h3 {
    margin: 0 0 5px 0;
    font-size: 22px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}
.live-title p {
    margin: 0;
    color: #64748b;
    font-size: 13.5px;
}
.badge-live-pulse {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.3);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.pulse-dot {
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    box-shadow: 0 0 8px #10b981;
    animation: pulseLive 1.8s infinite;
}
@keyframes pulseLive {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.card-launcher {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 25px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}
.card-launcher h4 {
    margin: 0 0 18px 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}
.session-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 18px 20px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    transition: all 0.2s ease;
}
.session-card:hover {
    border-color: #38bdf8;
    box-shadow: 0 4px 15px rgba(56, 189, 248, 0.1);
}
.session-card.is-active {
    border-left: 4px solid #10b981;
}
.session-info h4 {
    margin: 0 0 6px 0;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
}
.session-meta {
    font-size: 12.5px;
    color: #64748b;
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}
.session-meta span {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.btn-enter-cockpit {
    background: linear-gradient(135deg, #0284c7, #38bdf8);
    color: #fff !important;
    border: none;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(2, 132, 199, 0.3);
}
.btn-enter-cockpit:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(2, 132, 199, 0.45);
}
</style>

<div class="row">
    <div class="col-md-12">
        <!-- Live Hub Header -->
        <div class="live-hub-header">
            <div class="header-flex">
                <div class="live-title">
                    <h3>
                        <i class="fa fa-radar text-info"></i> Live Classroom Telemetry & Facilitator Cockpit
                        <span class="badge-live-pulse"><span class="pulse-dot"></span> Live Telemetry Engine</span>
                    </h3>
                    <p>Observe student screen focus, detect tab distractions in real time, award Islamic merits, launch formative check-ins, and command classrooms seamlessly.</p>
                </div>
                <div>
                    <a href="<?php echo base_url('live_classroom_monitoring_research.html'); ?>" target="_blank" class="btn btn-default btn-sm" style="font-weight:600;">
                        <i class="fa fa-book-open text-primary"></i> View Research Whitepaper
                    </a>
                </div>
            </div>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <!-- Quick Classroom Launcher Panel -->
        <div class="card-launcher">
            <h4><i class="fa fa-rocket text-primary"></i> Launch a New Live Classroom Session</h4>
            
            <?php echo form_open('live_session/start', ['class' => 'validate']); ?>
                <div class="form-grid">
                    
                    <div class="form-group">
                        <label>Session Title <span class="text-danger">*</span></label>
                        <input type="text" name="session_title" class="form-control" placeholder="e.g. English Grammar Live Lecture" required value="<?php echo date('D, d M') . ' — Live Interactive Class'; ?>">
                    </div>

                    <div class="form-group">
                        <label>Target Class <span class="text-danger">*</span></label>
                        <select name="class_id" id="class_id" class="form-control" required onchange="getSectionByClass(this.value, 0)">
                            <option value="">Select Class</option>
                            <?php foreach ($classes as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo html_escape($c['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Class Section <span class="text-danger">*</span></label>
                        <select name="section_id" id="section_id" class="form-control" required>
                            <option value="">Select Section</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Scheme of Work Alignment (Optional)</label>
                        <select name="scheme_id" class="form-control">
                            <option value="">None / Custom Topic</option>
                            <?php if (!empty($schemes)): ?>
                                <?php foreach ($schemes as $s): ?>
                                    <option value="<?php echo $s['id']; ?>">
                                        <?php echo html_escape($s['grade_level'] . ' | ' . $s['week_number'] . ': ' . $s['topic']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                </div>

                <div style="margin-top: 15px; text-align: right;">
                    <button type="submit" class="btn btn-primary" style="font-weight:700; padding:9px 24px;">
                        <i class="fa fa-play-circle"></i> Initialize & Open Cockpit Radar
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>

        <!-- Sessions List -->
        <div class="panel panel-default">
            <div class="panel-heading" style="background:#fff; border-bottom:1px solid #e2e8f0; font-weight:700;">
                <h4 class="panel-title"><i class="fa fa-list-alt text-info"></i> Active & Recent Live Classrooms</h4>
            </div>
            <div class="panel-body">
                <?php if (empty($sessions)): ?>
                    <div style="text-align:center; padding:40px; color:#94a3b8;">
                        <i class="fa fa-radar" style="font-size:42px; margin-bottom:12px; color:#cbd5e1;"></i>
                        <p style="font-size:15px; font-weight:600;">No live classroom sessions recorded yet.</p>
                        <p style="font-size:13px;">Use the launcher above to start your first live telemetry session!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($sessions as $ses): ?>
                        <div class="session-card <?php echo ($ses['status'] == 'active') ? 'is-active' : ''; ?>">
                            <div class="session-info">
                                <h4>
                                    <?php echo html_escape($ses['session_title']); ?>
                                    <?php if ($ses['status'] == 'active'): ?>
                                        <span class="badge-live-pulse" style="margin-left:8px;"><span class="pulse-dot"></span> LIVE NOW</span>
                                    <?php else: ?>
                                        <span class="label label-default" style="margin-left:8px; font-size:11px;">Ended</span>
                                    <?php endif; ?>
                                </h4>
                                <div class="session-meta">
                                    <span><i class="fa fa-graduation-cap text-muted"></i> <strong>Class:</strong> <?php echo html_escape($ses['class_name'] . ' (' . $ses['section_name'] . ')'); ?></span>
                                    <span><i class="fa fa-user text-muted"></i> <strong>Teacher:</strong> <?php echo html_escape($ses['teacher_name']); ?></span>
                                    <?php if (!empty($ses['scheme_topic'])): ?>
                                        <span><i class="fa fa-book text-muted"></i> <strong>Topic:</strong> <?php echo html_escape($ses['scheme_topic']); ?></span>
                                    <?php endif; ?>
                                    <span><i class="fa fa-clock-o text-muted"></i> <?php echo date('d M Y, h:i A', strtotime($ses['created_at'])); ?></span>
                                </div>
                            </div>
                            <div>
                                <a href="<?php echo base_url('live_session/cockpit/' . $ses['id']); ?>" class="btn-enter-cockpit">
                                    <i class="fa fa-radar"></i> Enter Cockpit Radar
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
function getSectionByClass(class_id, section_id) {
    if (class_id !== "") {
        $('#section_id').html('<option value="">Loading sections...</option>');
        $.ajax({
            url: "<?php echo base_url('live_session/get_sections_by_class'); ?>",
            type: "POST",
            data: { class_id: class_id },
            dataType: 'html',
            success: function(response) {
                $('#section_id').html(response);
                if (section_id && section_id !== 0) {
                    $('#section_id').val(section_id);
                } else {
                    // If only one actual section option exists besides placeholder, auto-select it!
                    var opts = $('#section_id option');
                    if (opts.length === 2 && opts.eq(1).val() !== '') {
                        opts.eq(1).prop('selected', true);
                    }
                }
            },
            error: function() {
                $.ajax({
                    url: "<?php echo base_url('ajax/getSectionByClass'); ?>",
                    type: "POST",
                    data: { class_id: class_id },
                    dataType: 'html',
                    success: function(response) {
                        $('#section_id').html(response);
                    }
                });
            }
        });
    } else {
        $('#section_id').html('<option value="">Select Section</option>');
    }
}

$(document).ready(function() {
    var preselectedClass = $('#class_id').val();
    if (preselectedClass) {
        getSectionByClass(preselectedClass, 0);
    }
});
</script>
