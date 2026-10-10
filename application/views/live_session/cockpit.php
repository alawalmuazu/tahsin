<?php
/**
 * Tahsin Academy - Real-Time Facilitator Radar Cockpit
 * Location: application/views/live_session/cockpit.php
 */
$summary = $radar['summary'];
$students = $radar['students'];
$hand_raises = $radar['hand_raises'];
?>
<style>
/* Cockpit Architecture Styles */
.cockpit-header-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 22px 26px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.cockpit-title-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 16px;
    margin-bottom: 16px;
}
.cockpit-title h3 {
    margin: 0 0 4px 0;
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 10px;
}
.cockpit-title p {
    margin: 0;
    font-size: 13.5px;
    color: #64748b;
}

.cockpit-toolbar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-cockpit-action {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #334155;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}
.btn-cockpit-action:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
}

.btn-lock-active {
    background: #fee2e2 !important;
    border-color: #ef4444 !important;
    color: #b91c1c !important;
}

.btn-lock-inactive {
    background: #f0fdf4 !important;
    border-color: #86efac !important;
    color: #15803d !important;
}

/* Radar Metric Cards */
.radar-metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}
.radar-metric-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px 20px;
    transition: all 0.2s ease;
}
.radar-metric-num {
    font-size: 28px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 5px;
}
.radar-metric-label {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
}

/* Hand Raise Banner */
.hand-raise-alert-banner {
    background: #fffbeb;
    border: 1px solid #fcd34d;
    border-radius: 8px;
    padding: 14px 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.12);
}
.hand-raise-text {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #92400e;
    font-size: 13.5px;
}

/* Student Cards Grid */
.student-telemetry-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 16px;
    margin-bottom: 30px;
}
.student-card-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
    position: relative;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.student-card-box:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
}

.student-card-box.card-active {
    border-left: 4px solid #10b981;
}
.student-card-box.card-blurred {
    border-left: 4px solid #f59e0b;
    background: #fffdfa;
}
.student-card-box.card-offline {
    border-left: 4px solid #94a3b8;
    opacity: 0.85;
}

.stu-top-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}
.stu-info-group {
    display: flex;
    align-items: center;
    gap: 10px;
}
.stu-avatar-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #0284c7;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    overflow: hidden;
}
.stu-avatar-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.stu-name-label {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.2;
}
.stu-roll-label {
    font-size: 11px;
    color: #64748b;
}

.stu-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.stu-pill.pill-active { background: #dcfce7; color: #15803d; }
.stu-pill.pill-blurred { background: #fef3c7; color: #b45309; }
.stu-pill.pill-offline { background: #f1f5f9; color: #64748b; }

.stu-task-status {
    font-size: 12px;
    color: #475569;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.stu-merit-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}
.merit-counter {
    font-size: 12px;
    font-weight: 700;
    color: #0284c7;
}

.btn-merit-micro {
    padding: 3px 7px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 4px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-merit-micro:hover {
    background: #f0fdf4;
    border-color: #86efac;
    color: #15803d;
}

/* Formative Poll Results Card */
.poll-results-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 18px 22px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
</style>

<div class="row">
    <div class="col-md-12">
        
        <!-- Cockpit Header -->
        <div class="cockpit-header-box">
            <div class="cockpit-title-row">
                <div class="cockpit-title">
                    <h3>
                        <i class="fa fa-radar text-info"></i> <?php echo html_escape($session['session_title']); ?>
                        <?php if ($session['status'] == 'active'): ?>
                            <span class="badge-live-pulse" style="margin-left:8px;"><span class="pulse-dot"></span> RADAR STREAMING</span>
                        <?php else: ?>
                            <span class="label label-default">Ended</span>
                        <?php endif; ?>
                    </h3>
                    <p>
                        <strong>Class:</strong> <?php echo html_escape($session['class_name'] . ' (' . $session['section_name'] . ')'); ?> &nbsp;|&nbsp;
                        <strong>Facilitator:</strong> <?php echo html_escape($session['teacher_name']); ?>
                        <?php if (!empty($session['scheme_topic'])): ?>
                            &nbsp;|&nbsp; <strong>Curriculum Topic:</strong> <?php echo html_escape($session['scheme_topic'] . ' (' . $session['scheme_week'] . ')'); ?>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="cockpit-toolbar">
                    <!-- Eyes Up Lock Toggle -->
                    <button id="btn-toggle-lock" class="btn-cockpit-action <?php echo ($session['screen_lock'] == 1) ? 'btn-lock-active' : 'btn-lock-inactive'; ?>" onclick="toggleScreenLock()">
                        <i class="fa fa-eye"></i> 
                        <span id="lock-btn-text"><?php echo ($session['screen_lock'] == 1) ? 'Engaged: Eyes Up Active' : 'Engage "Eyes Up" Lock'; ?></span>
                    </button>

                    <!-- Launch Comprehension Poll -->
                    <button class="btn-cockpit-action" onclick="openPollModal()">
                        <i class="fa fa-chart-simple text-primary"></i> 60-Sec Check-in Poll
                    </button>

                    <!-- WhatsApp Parent Debrief -->
                    <button class="btn-cockpit-action" onclick="openWhatsAppModal()">
                        <i class="fa fa-whatsapp text-success"></i> WhatsApp Debrief
                    </button>

                    <!-- End Session -->
                    <button class="btn-cockpit-action text-danger" onclick="confirmEndSession()">
                        <i class="fa fa-stop-circle"></i> End Session
                    </button>
                </div>
            </div>

            <!-- Radar Metric Counters -->
            <div class="radar-metrics-grid">
                <div class="radar-metric-card" style="border-left: 4px solid #0284c7;">
                    <div class="radar-metric-num text-primary" id="radar-focus-rate"><?php echo $summary['focus_rate']; ?>%</div>
                    <div class="radar-metric-label">Class Focus Rate</div>
                </div>
                <div class="radar-metric-card" style="border-left: 4px solid #10b981;">
                    <div class="radar-metric-num text-success" id="radar-count-active"><?php echo $summary['active']; ?></div>
                    <div class="radar-metric-label">Active in Tab</div>
                </div>
                <div class="radar-metric-card" style="border-left: 4px solid #f59e0b;">
                    <div class="radar-metric-num text-warning" id="radar-count-blurred"><?php echo $summary['blurred']; ?></div>
                    <div class="radar-metric-label">Tab Switched / Blurred</div>
                </div>
                <div class="radar-metric-card" style="border-left: 4px solid #94a3b8;">
                    <div class="radar-metric-num text-muted" id="radar-count-offline"><?php echo $summary['offline']; ?></div>
                    <div class="radar-metric-label">Offline / Disconnected</div>
                </div>
            </div>

            <!-- Hand Raise Alert Banner -->
            <div id="hand-raise-banner" class="hand-raise-alert-banner" style="<?php echo empty($hand_raises) ? 'display:none;' : ''; ?>">
                <div class="hand-raise-text">
                    <i class="fa fa-hand" style="font-size:20px; color:#f59e0b;"></i>
                    <span id="hand-raise-message">
                        <?php if (!empty($hand_raises)): ?>
                            <strong>Priority Hand Raise:</strong> <?php echo html_escape($hand_raises[0]['name']); ?> needs assistance.
                        <?php endif; ?>
                    </span>
                </div>
                <div>
                    <button class="btn btn-warning btn-xs" onclick="dismissHandRaise()">
                        <i class="fa fa-check"></i> Mark Addressed
                    </button>
                </div>
            </div>

            <!-- Live Formative Poll Results (if open) -->
            <div id="cockpit-poll-results" class="poll-results-card" style="<?php echo empty($active_poll) ? 'display:none;' : ''; ?>">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                    <h4 style="margin:0; font-size:15px; font-weight:700;">
                        <i class="fa fa-poll text-info"></i> Active Formative Check: <span id="cockpit-poll-prompt"><?php echo !empty($active_poll) ? html_escape($active_poll['prompt_text']) : ''; ?></span>
                    </h4>
                    <span id="cockpit-poll-tally" class="label label-info">Poll Open</span>
                </div>
                <div id="cockpit-poll-bars"></div>
            </div>

        </div>

        <!-- Student Telemetry Radar Grid -->
        <h4 style="font-size:16px; font-weight:700; margin-bottom:15px; color:#1e293b;">
            <i class="fa fa-users text-primary"></i> Live Student Roster & Focus Telemetry (<?php echo count($students); ?> Enrolled)
        </h4>

        <div class="student-telemetry-grid" id="students-grid-container">
            <?php foreach ($students as $stu): ?>
                <div class="student-card-box card-<?php echo $stu['status']; ?>" id="card-stu-<?php echo $stu['student_id']; ?>">
                    <div class="stu-top-row">
                        <div class="stu-info-group">
                            <div class="stu-avatar-circle">
                                <?php if (!empty($stu['photo'])): ?>
                                    <img src="<?php echo base_url('uploads/images/student/' . $stu['photo']); ?>" alt="Photo">
                                <?php else: ?>
                                    <?php echo strtoupper(substr($stu['name'], 0, 2)); ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="stu-name-label"><?php echo html_escape($stu['name']); ?></div>
                                <div class="stu-roll-label">Roll #<?php echo $stu['roll']; ?> | <?php echo html_escape($stu['register_no']); ?></div>
                            </div>
                        </div>
                        <span class="stu-pill pill-<?php echo $stu['status']; ?>" id="pill-stu-<?php echo $stu['student_id']; ?>">
                            <?php if ($stu['status'] == 'active'): ?>
                                <i class="fa fa-circle"></i> Active
                            <?php elseif ($stu['status'] == 'blurred'): ?>
                                <i class="fa fa-triangle-exclamation"></i> Tab Switched
                            <?php else: ?>
                                <i class="fa fa-circle-o"></i> Offline
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="stu-task-status" id="task-stu-<?php echo $stu['student_id']; ?>">
                        <i class="fa fa-tasks text-muted"></i> <?php echo html_escape($stu['current_task']); ?>
                    </div>

                    <div class="stu-merit-bar">
                        <span class="merit-counter" id="pts-stu-<?php echo $stu['student_id']; ?>">
                            ⭐ <?php echo $stu['points']; ?> pts
                        </span>
                        <div style="display:flex; gap:4px;">
                            <button class="btn-merit-micro" title="Award +1 Focus" onclick="awardMerit(<?php echo $stu['student_id']; ?>, 'Fahm & Focus', 1)">+1 Focus</button>
                            <button class="btn-merit-micro" title="Award +2 Answer" onclick="awardMerit(<?php echo $stu['student_id']; ?>, 'Exemplary Answer', 2)">+2 Answer</button>
                            <button class="btn-merit-micro" title="Award +2 Akhlaq" onclick="awardMerit(<?php echo $stu['student_id']; ?>, 'Quran / Akhlaq', 2)">+2 Akhlaq</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<!-- Modal: Launch 60-Sec Check-in Poll -->
<div class="modal fade" id="pollModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-chart-simple text-primary"></i> Launch 60-Second Comprehension Check</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Prompt Question for Students</label>
                    <input type="text" id="poll-prompt-input" class="form-control" value="Do you understand today's key concept?">
                </div>
                <div class="form-group">
                    <label>Poll Preset Choices</label>
                    <select id="poll-preset-select" class="form-control" onchange="updatePollPreset(this.value)">
                        <option value="comprehension">Clear vs Need Explanation (👍 Clear / 🤔 Need Clarification)</option>
                        <option value="true_false">True / False</option>
                        <option value="mcq_abc">Multiple Choice (Option A / Option B / Option C)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="launchPoll()">Launch to Student Screens</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: WhatsApp Debrief Generator -->
<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-whatsapp text-success"></i> Parent WhatsApp Broadcast Digest</h4>
            </div>
            <div class="modal-body">
                <p style="font-size:13px; color:#64748b;">
                    Automatically aggregated lesson metrics, attendance count, and top commendation stars formatted for class parent groups:
                </p>
                <textarea id="whatsapp-digest-text" class="form-control" rows="10" style="font-family:monospace; font-size:12px; background:#f8fafc;" readonly>Loading broadcast...</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="copyWhatsAppDigest()">
                    <i class="fa fa-copy"></i> Copy Text
                </button>
                <a id="btn-open-wa" href="#" target="_blank" class="btn btn-success">
                    <i class="fa fa-external-link"></i> Open WhatsApp Web
                </a>
            </div>
        </div>
    </div>
</div>

<script>
var ACTIVE_SESSION_ID = <?php echo $session['id']; ?>;
var radarPollInterval = null;
var activePollId = <?php echo !empty($active_poll) ? $active_poll['id'] : 0; ?>;
var currentTopHandRaiseStudentId = <?php echo !empty($hand_raises) ? $hand_raises[0]['student_id'] : 0; ?>;

$(document).ready(function() {
    // Start live radar polling every 3.5 seconds
    radarPollInterval = setInterval(fetchRadarFeed, 3500);
});

function fetchRadarFeed() {
    $.ajax({
        url: "<?php echo base_url('live_session/radar_feed/'); ?>" + ACTIVE_SESSION_ID,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                updateRadarUI(res);
            }
        }
    });
}

function updateRadarUI(res) {
    // 1. Update Metrics
    $('#radar-focus-rate').text(res.summary.focus_rate + '%');
    $('#radar-count-active').text(res.summary.active);
    $('#radar-count-blurred').text(res.summary.blurred);
    $('#radar-count-offline').text(res.summary.offline);

    // 2. Update Hand Raise Banner
    if (res.hand_raises && res.hand_raises.length > 0) {
        currentTopHandRaiseStudentId = res.hand_raises[0].student_id;
        $('#hand-raise-message').html('<strong>Priority Hand Raise:</strong> ' + res.hand_raises[0].name + ' requested assistance.');
        $('#hand-raise-banner').slideDown(200);
    } else {
        currentTopHandRaiseStudentId = 0;
        $('#hand-raise-banner').slideUp(200);
    }

    // 3. Update Student Cards
    if (res.students) {
        res.students.forEach(function(stu) {
            var card = $('#card-stu-' + stu.student_id);
            var pill = $('#pill-stu-' + stu.student_id);
            var task = $('#task-stu-' + stu.student_id);
            var pts  = $('#pts-stu-' + stu.student_id);

            card.removeClass('card-active card-blurred card-offline').addClass('card-' + stu.status);
            pill.removeClass('pill-active pill-blurred pill-offline').addClass('pill-' + stu.status);

            if (stu.status === 'active') {
                pill.html('<i class="fa fa-circle"></i> Active');
            } else if (stu.status === 'blurred') {
                pill.html('<i class="fa fa-triangle-exclamation"></i> Tab Switched');
            } else {
                pill.html('<i class="fa fa-circle-o"></i> Offline');
            }

            task.html('<i class="fa fa-tasks text-muted"></i> ' + stu.current_task);
            pts.html('⭐ ' + stu.points + ' pts');
        });
    }

    // 4. Update Poll Bar if active
    if (res.active_poll && res.active_poll.id) {
        activePollId = res.active_poll.id;
        $('#cockpit-poll-prompt').text(res.active_poll.prompt_text);
        $('#cockpit-poll-results').show();
        fetchPollResults(res.active_poll.id);
    }
}

function toggleScreenLock() {
    $.ajax({
        url: "<?php echo base_url('live_session/toggle_screen_lock/'); ?>" + ACTIVE_SESSION_ID,
        type: "POST",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                var btn = $('#btn-toggle-lock');
                var text = $('#lock-btn-text');
                if (res.screen_locked == 1) {
                    btn.removeClass('btn-lock-inactive').addClass('btn-lock-active');
                    text.text('Engaged: Eyes Up Active');
                    alert('🚨 "Eyes Up" screen freeze activated for all students in this class.');
                } else {
                    btn.removeClass('btn-lock-active').addClass('btn-lock-inactive');
                    text.text('Engage "Eyes Up" Lock');
                    alert('🔓 Screen freeze released.');
                }
            }
        }
    });
}

function awardMerit(studentId, badgeName, points) {
    $.ajax({
        url: "<?php echo base_url('live_session/award_merit'); ?>",
        type: "POST",
        data: {
            session_id: ACTIVE_SESSION_ID,
            student_id: studentId,
            badge_name: badgeName,
            points: points
        },
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                // Pulse card animation
                var card = $('#card-stu-' + studentId);
                card.css('transform', 'scale(1.02)');
                setTimeout(function() { card.css('transform', 'none'); }, 200);
            }
        }
    });
}

function dismissHandRaise() {
    if (!currentTopHandRaiseStudentId) return;
    $.ajax({
        url: "<?php echo base_url('live_session/clear_hand'); ?>",
        type: "POST",
        data: {
            session_id: ACTIVE_SESSION_ID,
            student_id: currentTopHandRaiseStudentId
        },
        dataType: "json",
        success: function(res) {
            $('#hand-raise-banner').slideUp(200);
        }
    });
}

function openPollModal() {
    $('#pollModal').modal('show');
}

function launchPoll() {
    var prompt = $('#poll-prompt-input').val();
    var preset = $('#poll-preset-select').val();
    var options = [];

    if (preset === 'comprehension') {
        options = ['A: Clear 👍', 'B: Need Explanation 🤔'];
    } else if (preset === 'true_false') {
        options = ['True', 'False'];
    } else {
        options = ['Option A', 'Option B', 'Option C'];
    }

    $.ajax({
        url: "<?php echo base_url('live_session/create_poll'); ?>",
        type: "POST",
        data: {
            session_id: ACTIVE_SESSION_ID,
            prompt_text: prompt,
            options: options
        },
        dataType: "json",
        success: function(res) {
            $('#pollModal').modal('hide');
            $('#cockpit-poll-prompt').text(prompt);
            $('#cockpit-poll-results').slideDown();
        }
    });
}

function fetchPollResults(pollId) {
    $.ajax({
        url: "<?php echo base_url('live_session/poll_results/'); ?>" + pollId,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success' && res.results) {
                var total = res.results.total;
                var html = '';
                for (var opt in res.results.counts) {
                    var count = res.results.counts[opt];
                    var pct = (total > 0) ? Math.round((count / total) * 100) : 0;
                    html += '<div style="margin-bottom:8px;">' +
                        '<div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:2px;">' +
                        '<span><strong>' + opt + '</strong></span><span>' + count + ' votes (' + pct + '%)</span>' +
                        '</div>' +
                        '<div class="progress" style="height:8px; margin-bottom:0;">' +
                        '<div class="progress-bar progress-bar-info" style="width:' + pct + '%;"></div>' +
                        '</div></div>';
                }
                $('#cockpit-poll-bars').html(html);
                $('#cockpit-poll-tally').text(total + ' Responses');
            }
        }
    });
}

function openWhatsAppModal() {
    $('#whatsappModal').modal('show');
    $.ajax({
        url: "<?php echo base_url('live_session/whatsapp_debrief/'); ?>" + ACTIVE_SESSION_ID,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                $('#whatsapp-digest-text').val(res.message);
                $('#btn-open-wa').attr('href', 'https://api.whatsapp.com/send?text=' + res.encoded);
            }
        }
    });
}

function copyWhatsAppDigest() {
    var copyText = document.getElementById("whatsapp-digest-text");
    copyText.select();
    document.execCommand("copy");
    alert("WhatsApp broadcast copied to clipboard!");
}

function confirmEndSession() {
    if (confirm('Are you sure you want to end this live classroom session?')) {
        $.ajax({
            url: "<?php echo base_url('live_session/end_session/'); ?>" + ACTIVE_SESSION_ID,
            type: "POST",
            dataType: "json",
            success: function(res) {
                window.location.href = "<?php echo base_url('live_session'); ?>";
            }
        });
    }
}
</script>
