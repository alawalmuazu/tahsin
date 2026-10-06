<?php
$ci = get_instance();
$branchID = $ci->application_model->get_branch_id();
$ci->load->model('student_model');
$remindOn = $ci->student_model->getPartialReminderDate($branchID);
$today = date('Y-m-d');
if ($remindOn === '' || $remindOn !== $today) {
    return;
}
?>
<style>
#feeRemindOverlay { display:none; position:fixed; inset:0; z-index:10050; background:rgba(11,26,22,.55); align-items:flex-start; justify-content:center; padding:24px 12px; overflow:auto; }
#feeRemindBox { width:100%; max-width:640px; background:#faf7f2; border-radius:16px; box-shadow:0 16px 40px rgba(11,26,22,.25); padding:16px; margin:auto; }
#feeRemindBox h3 { margin:0 0 4px; color:#14532d; font-size:20px; }
#feeRemindMeta { color:#57534e; margin:0 0 12px; }
#feeRemindClose { float:right; border:0; background:#fff; border-radius:999px; width:40px; height:40px; font-size:22px; line-height:1; color:#44403c; }
#feeRemindReopen { display:none; position:fixed; left:16px; bottom:16px; z-index:10040; background:#14532d; color:#fff; border:0; border-radius:999px; padding:12px 16px; font-weight:700; box-shadow:0 8px 20px rgba(11,26,22,.25); }
.fee-remind-card { background:#fff; border:1px solid #e7dcc4; border-radius:12px; padding:14px 14px 12px; margin:0 0 12px; }
.fee-remind-head { display:flex; flex-wrap:wrap; gap:6px 12px; align-items:baseline; margin-bottom:8px; }
.fee-remind-head strong { color:#14532d; font-size:16px; }
.fee-remind-head span { color:#3f6212; font-size:13px; }
.fee-remind-siblings { background:#ecfccb; color:#3f6212; border-radius:999px; padding:2px 8px; }
.fee-remind-kids { list-style:none; margin:0; padding:0; }
.fee-remind-kids li { border-top:1px solid #f3ead8; padding:8px 0; }
.fee-remind-kid-name { font-weight:600; color:#1c1917; }
.fee-remind-kid-name span, .fee-remind-class { color:#78716c; font-size:12px; font-weight:500; }
.fee-remind-amounts { display:flex; flex-wrap:wrap; gap:8px 14px; margin-top:4px; font-size:13px; }
.fee-remind-left { color:#9a3412; font-weight:700; }
.fee-remind-subtotal { display:flex; flex-wrap:wrap; gap:8px 14px; align-items:baseline; margin-top:4px; padding-top:8px; border-top:1px solid #e7dcc4; font-size:13px; }
.fee-remind-subtotal strong { color:#14532d; }
.fee-remind-wa { display:inline-flex; align-items:center; gap:8px; margin-top:8px; background:#25D366; color:#fff !important; border-radius:999px; padding:10px 16px; font-weight:700; text-decoration:none !important; min-height:44px; }
.fee-remind-wa:hover { background:#1ebe5d; color:#fff !important; }
.fee-remind-nophone { color:#9a3412; margin:8px 0 0; font-size:13px; }
</style>
<div id="feeRemindOverlay">
    <div id="feeRemindBox" role="dialog" aria-modal="true" aria-labelledby="feeRemindTitle">
        <button type="button" id="feeRemindClose" aria-label="Close">&times;</button>
        <h3 id="feeRemindTitle">Partial payment reminder</h3>
        <p id="feeRemindMeta"><?php echo html_escape(_d($today)); ?></p>
        <div id="feeRemindBody"></div>
    </div>
</div>
<button type="button" id="feeRemindReopen">Partial fees</button>
<script>
(function ($) {
    var today = <?php echo json_encode($today); ?>;
    var key = 'tahsinPartialFeeClosed:' + today;
    var overlay = $('#feeRemindOverlay');
    var reopen = $('#feeRemindReopen');
    function closeBox() {
        overlay.hide();
        try { sessionStorage.setItem(key, '1'); } catch (e) {}
        reopen.show();
    }
    $('#feeRemindClose').on('click', closeBox);
    overlay.on('click', function (e) {
        if (e.target === overlay[0]) {
            closeBox();
        }
    });
    $(document).on('keydown.feeRemind', function (e) {
        if (e.key === 'Escape' && overlay.is(':visible')) {
            closeBox();
        }
    });
    reopen.on('click', function () {
        load(true);
    });
    function load(force) {
        var closed = '';
        try { closed = sessionStorage.getItem(key) || ''; } catch (e) {}
        if (!force && closed === '1') {
            reopen.show();
            return;
        }
        $.ajax({
            url: base_url + 'fees/partial_reminder_due',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (!data || !data.show || !data.html) {
                    return;
                }
                var meta = <?php echo json_encode(_d($today)); ?>;
                if (data.students) {
                    meta += ' · ' + data.students + (data.students === 1 ? ' student' : ' students');
                }
                if (data.families && data.families !== data.students) {
                    meta += ' · ' + data.families + (data.families === 1 ? ' parent' : ' parents');
                }
                $('#feeRemindMeta').text(meta);
                $('#feeRemindBody').html(data.html);
                reopen.hide();
                overlay.css('display', 'flex');
            }
        });
    }
    load(false);
})(jQuery);
</script>
