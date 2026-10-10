<?php
/**
 * Student Live Classroom Portal View
 * Location: application/views/live_session/student_room.php
 */
?>
<style>
.student-live-container {
    max-width: 960px;
    margin: 0 auto;
}
.student-live-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.header-top-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 15px;
}
.session-headline h3 {
    margin: 0 0 5px 0;
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
}
.session-headline p {
    margin: 0;
    font-size: 13.5px;
    color: #64748b;
}

.btn-hand-raise {
    background: #ffffff;
    border: 2px solid #f59e0b;
    color: #d97706;
    padding: 8px 18px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-hand-raise:hover {
    background: #fffbeb;
}
.btn-hand-raise.active {
    background: #f59e0b;
    color: #ffffff;
    box-shadow: 0 0 12px rgba(245, 158, 11, 0.4);
}

/* Syllabus & Scheme Overview */
.lesson-content-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.lesson-content-card h4 {
    margin: 0 0 14px 0;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.objectives-box {
    background: #f8fafc;
    border-left: 3px solid #0284c7;
    padding: 14px 18px;
    border-radius: 0 6px 6px 0;
    margin-bottom: 18px;
    font-size: 13.5px;
    line-height: 1.6;
}

/* Poll Prompt Card */
.poll-prompt-box {
    background: #f0fdf4;
    border: 1px solid #86efac;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    display: none;
    animation: slideDown 0.3s ease;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.btn-poll-option {
    display: block;
    width: 100%;
    text-align: left;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    padding: 10px 16px;
    border-radius: 6px;
    margin-top: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-poll-option:hover {
    border-color: #10b981;
    background: #f0fdf4;
    color: #15803d;
}

/* Screen Lock Overlay */
#tahsin-screen-lock-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(16px);
    z-index: 99999;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
    padding: 24px;
    color: #ffffff;
}
.lock-inner-card {
    max-width: 520px;
    background: #1e293b;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 12px;
    padding: 36px 30px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

/* Merit Toast */
.merit-toast-pop {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #0f172a;
    border: 2px solid #10b981;
    color: #ffffff;
    padding: 16px 22px;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 14px;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
}
.merit-toast-pop.show {
    opacity: 1;
    transform: translateY(0);
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="student-live-container">

            <?php if (empty($session)): ?>
                <div class="student-live-header" style="text-align:center; padding:50px;">
                    <i class="fa fa-television text-muted" style="font-size:46px; margin-bottom:15px;"></i>
                    <h3 style="font-weight:700; color:#334155;">No Active Classroom Session Right Now</h3>
                    <p style="color:#64748b; font-size:14px; margin-top:8px;">
                        When your facilitator starts today's live class, this screen will connect automatically. Please stay logged in!
                    </p>
                </div>
            <?php else: ?>

                <!-- Student Live Header -->
                <div class="student-live-header">
                    <div class="header-top-flex">
                        <div class="session-headline">
                            <h3><?php echo html_escape($session['session_title']); ?></h3>
                            <p>
                                <strong>Class:</strong> <?php echo html_escape($session['class_name'] . ' (' . $session['section_name'] . ')'); ?> &nbsp;|&nbsp;
                                <strong>Facilitator:</strong> <?php echo html_escape($session['teacher_name']); ?>
                            </p>
                        </div>
                        <div>
                            <button id="btn-raise-hand" class="btn-hand-raise" onclick="TahsinPulse.toggleHandRaise()">
                                <i class="fa fa-hand-paper"></i> Raise Hand for Help
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active 60-Sec Formative Poll Prompt (Dynamic) -->
                <div id="tahsin-live-poll-card" class="poll-prompt-box">
                    <h4 style="margin:0 0 8px 0; color:#15803d; font-weight:700;">
                        <i class="fa fa-question-circle"></i> Quick Facilitator Check-In:
                    </h4>
                    <p id="poll-prompt-text" style="font-size:15px; font-weight:600; color:#1e293b; margin-bottom:12px;"></p>
                    <div id="poll-options-container"></div>
                </div>

                <!-- Lesson Content & Scheme Alignment -->
                <div class="lesson-content-card">
                    <h4><i class="fa fa-book-open text-primary"></i> Today's Lesson Topic & Syllabus Focus</h4>
                    
                    <?php if (!empty($session['scheme_topic'])): ?>
                        <div style="font-size:16px; font-weight:700; color:#0f172a; margin-bottom:6px;">
                            <?php echo html_escape($session['scheme_topic']); ?>
                        </div>
                        <?php if (!empty($session['scheme_sub_topic'])): ?>
                            <div style="font-size:13.5px; color:#475569; margin-bottom:14px;">
                                <strong>Sub-Topic:</strong> <?php echo html_escape($session['scheme_sub_topic']); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (!empty($session['scheme_objectives'])): ?>
                        <div class="objectives-box">
                            <strong>🎯 What We Are Learning Today (Objectives):</strong><br>
                            <?php echo nl2br(html_escape($session['scheme_objectives'])); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($session['scheme_class_work'])): ?>
                        <div style="margin-top:16px;">
                            <strong>✏️ Classroom Work & Tasks:</strong>
                            <p style="margin-top:6px; color:#334155; font-size:13.5px;">
                                <?php echo nl2br(html_escape($session['scheme_class_work'])); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Screen Lock Modal (Eyes Up Demonstration) -->
<div id="tahsin-screen-lock-modal">
    <div class="lock-inner-card">
        <i class="fa fa-eye" style="font-size:52px; color:#38bdf8; margin-bottom:16px;"></i>
        <h3 style="font-size:24px; font-weight:800; margin-bottom:10px;">Eyes Up on the Facilitator!</h3>
        <p style="font-size:14.5px; color:#94a3b8; line-height:1.6; margin:0;">
            Your screen has been paused by your facilitator. Please direct your full attention to the front classroom presentation or facilitator instruction.
        </p>
    </div>
</div>

<!-- Merit Badge Celebration Toast -->
<div id="tahsin-merit-toast" class="merit-toast-pop">
    <i class="fa fa-award" style="font-size:28px; color:#10b981;"></i>
    <div>
        <div id="merit-toast-title" style="font-weight:800; font-size:14px; color:#10b981;"></div>
        <div id="merit-toast-desc" style="font-size:12.5px; color:#cbd5e1;"></div>
    </div>
</div>

<?php if (!empty($session)): ?>
<script src="<?php echo base_url('assets/js/tahsin-pulse.js'); ?>"></script>
<script>
$(document).ready(function() {
    TahsinPulse.init({
        sessionId: <?php echo (int)$session['id']; ?>,
        studentId: <?php echo (int)$student_id; ?>,
        baseUrl: "<?php echo base_url(); ?>"
    });
});
</script>
<?php endif; ?>
