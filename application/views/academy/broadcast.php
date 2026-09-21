<style>
.bcast-hub-header{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem}
.bcast-hub-header h4{margin:0 0 .25rem;font-weight:700}
.bcast-hub-header p{margin:0;color:#64748b;font-size:.9rem}
.bcast-kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:.85rem;margin-bottom:1.25rem}
.bcast-kpi{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;text-align:center}
.bcast-kpi .v{font-size:1.55rem;font-weight:800;line-height:1.1}
.bcast-kpi .l{font-size:.68rem;text-transform:uppercase;color:#64748b;letter-spacing:.04em;margin-top:.35rem}
.bcast-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.25rem;margin-bottom:1rem}
.bcast-card.no-phone{border-color:#fcd34d;background:#fffbeb}
.bcast-msg{background:#0f172a;color:#e2e8f0;border-radius:10px;padding:1rem;font-size:.85rem;white-space:pre-wrap;line-height:1.55;margin:0;font-family:inherit}
.bcast-actions{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1rem;align-items:center}
.bcast-note{background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.82rem;color:#1e40af;line-height:1.45}
.bcast-media{display:flex;flex-wrap:wrap;gap:.4rem;margin:.65rem 0 .35rem}
.bcast-media a,.bcast-media button{margin:0;font-size:.72rem;font-weight:600}
.bcast-cohort{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.25rem;margin-bottom:1.25rem}
.bcast-cohort h5{margin:0 0 .65rem;font-weight:700}
</style>

<div class="bcast-hub-header">
	<div>
		<h4><i class="fas fa-broadcast-tower"></i> Tahsin Broadcast Preview</h4>
		<p>Daily parent digests with milestone text + audio/video links. Open WhatsApp to parents or share to a group.</p>
	</div>
	<div>
		<?php if (!empty($wa_ready)): ?>
		<?php echo form_open(base_url('academy_broadcast'), array('style' => 'display:inline', 'onsubmit' => "return confirm('Send today\\'s digests to all parents with a phone number via WhatsApp Cloud API?');")); ?>
		<button type="submit" name="send_cloud_api" value="1" class="btn btn-success"><i class="fab fa-whatsapp"></i> Send digests via WhatsApp API</button>
		<?php echo form_close(); ?>
		<?php endif; ?>
		<?php echo form_open(base_url('academy_broadcast'), array('style' => 'display:inline')); ?>
		<button type="submit" name="save_preview" value="1" class="btn btn-default"><i class="fas fa-save"></i> Save preview log</button>
		<?php echo form_close(); ?>
		<?php echo form_open(base_url('academy_broadcast'), array('style' => 'display:inline')); ?>
		<button type="submit" name="clean_akhlaq" value="1" class="btn btn-default" title="Strip old Audio/Tarteel tags from notes">
			<i class="fas fa-broom"></i> Clean note tags
		</button>
		<?php echo form_close(); ?>
		<a href="<?php echo base_url('academy_students'); ?>" class="btn btn-default"><i class="fas fa-user-graduate"></i> Students</a>
	</div>
</div>

<div class="bcast-note">
	<?php
	$waReady = !empty($wa_ready);
	$waStatus = isset($wa_status) ? $wa_status : 'Disabled';
	$waMedia = !empty($wa_send_media);
	?>
	<strong>WhatsApp Cloud API:</strong>
	<span class="label label-<?php echo $waReady ? 'success' : 'default'; ?>"><?php echo html_escape($waStatus); ?></span>
	<?php if ($waReady): ?>
		Template digests can be pushed to parents. <?php echo $waMedia ? 'Native audio/video attach is attempted after each digest (needs a Meta chat window or public HTTPS files).' : 'Media is included as links in the template.'; ?>
	<?php else: ?>
		Configure <code>application/config/whatsapp.php</code> (enable + token + phone number ID + approved template). Until then, use click-to-chat below.
	<?php endif; ?>
	<br style="margin-top:.35rem">
	<strong>Links always work</strong> on the public site — <code>localhost</code> audio URLs will not open for parents.
</div>

<div class="bcast-kpis">
	<div class="bcast-kpi"><div class="v" style="color:#0284c7"><?php echo (int) $broadcast['total_students']; ?></div><div class="l">Total Students</div></div>
	<div class="bcast-kpi"><div class="v" style="color:#059669"><?php echo (int) $broadcast['reports_generated']; ?></div><div class="l">Reports Ready</div></div>
	<div class="bcast-kpi"><div class="v" style="color:#6366f1"><?php echo (int) $broadcast['with_parent_contact']; ?></div><div class="l">With Parent Phone</div></div>
	<div class="bcast-kpi"><div class="v" style="color:#dc2626"><?php echo (int) (isset($broadcast['without_parent_contact']) ? $broadcast['without_parent_contact'] : 0); ?></div><div class="l">Missing Phone</div></div>
	<div class="bcast-kpi"><div class="v" style="color:#d97706"><?php echo (int) $broadcast['with_drills']; ?></div><div class="l">Had Drills Today</div></div>
	<div class="bcast-kpi"><div class="v" style="color:#0f766e"><?php echo (int) (isset($broadcast['with_tahfiz']) ? $broadcast['with_tahfiz'] : 0); ?></div><div class="l">Had Tahfiz Today</div></div>
	<div class="bcast-kpi"><div class="v" style="color:#7c3aed"><?php echo (int) (isset($broadcast['with_media']) ? $broadcast['with_media'] : 0); ?></div><div class="l">With Audio/Video</div></div>
</div>

<?php
$cohortMsg = isset($broadcast['cohort_message']) ? $broadcast['cohort_message'] : '';
$cohortWa = $cohortMsg !== '' ? ('https://api.whatsapp.com/send?text=' . rawurlencode($cohortMsg)) : '';
?>
<?php if ($cohortMsg !== ''): ?>
<div class="bcast-cohort">
	<h5>📣 Cohort / Group digest</h5>
	<p class="text-muted" style="margin:0 0 .65rem;font-size:.82rem">Opens WhatsApp without a phone number — pick a <strong>group</strong> or contact, then send.</p>
	<pre class="bcast-msg" style="margin-bottom:.75rem"><?php echo html_escape($cohortMsg); ?></pre>
	<a href="<?php echo $cohortWa; ?>" target="_blank" class="btn btn-success btn-sm"><i class="fab fa-whatsapp"></i> Share cohort to WhatsApp group</a>
	<button type="button" class="btn btn-default btn-sm" id="bcast_copy_cohort"><i class="fas fa-copy"></i> Copy cohort message</button>
</div>
<?php endif; ?>

<div class="bcast-actions">
	<button type="button" class="btn btn-success btn-sm" id="bcast_open_all"><i class="fab fa-whatsapp"></i> Open all parent chats</button>
	<button type="button" class="btn btn-default btn-sm" id="bcast_copy_all"><i class="fas fa-copy"></i> Copy all messages</button>
	<span class="text-muted" id="bcast_action_status" style="font-size:.8rem"></span>
</div>

<?php if (empty($broadcast['reports'])): ?>
<section class="panel"><div class="panel-body text-center text-muted">No enrolled students to broadcast.</div></section>
<?php else:
	$waLinks = array();
	$allMsgs = array();
	foreach ($broadcast['reports'] as $r):
		$phone = '';
		$wa = '';
		$waShare = 'https://api.whatsapp.com/send?text=' . rawurlencode($r['message']);
		if (!empty($r['parent_contact'])) {
			$phone = preg_replace('/\D+/', '', $r['parent_contact']);
			if (strlen($phone) === 11 && $phone[0] === '0') {
				$phone = '234' . substr($phone, 1);
			}
			$wa = 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . rawurlencode($r['message']);
			$waLinks[] = $wa;
		}
		$allMsgs[] = $r['message'];
		$media = isset($r['media']) ? $r['media'] : array();
?>
<div class="bcast-card <?php echo empty($r['parent_contact']) ? 'no-phone' : ''; ?>">
	<div style="display:flex;justify-content:space-between;align-items:center;gap:.75rem;flex-wrap:wrap;margin-bottom:.5rem">
		<div>
			<strong><?php echo html_escape($r['student_name']); ?></strong>
			<span class="text-muted" style="margin-left:.5rem"><?php echo html_escape($r['parent_contact'] ? $r['parent_contact'] : 'No contact'); ?></span>
		</div>
		<div>
			<span class="label label-<?php echo $r['drill_count'] > 0 ? 'success' : 'default'; ?>">
				<?php echo (int) $r['drill_count']; ?> drills
			</span>
			<span class="label label-<?php echo !empty($r['tahfiz_count']) ? 'info' : 'default'; ?>" style="margin-left:4px">
				<?php echo (int) $r['tahfiz_count']; ?> tahfiz
			</span>
			<?php if (!empty($media)): ?>
			<span class="label label-primary" style="margin-left:4px"><?php echo count($media); ?> media</span>
			<?php endif; ?>
			<?php if ($wa): ?>
			<a href="<?php echo $wa; ?>" target="_blank" class="btn btn-success btn-xs bcast-wa-link" style="margin-left:6px">
				<i class="fab fa-whatsapp"></i> Parent
			</a>
			<?php endif; ?>
			<?php if (!empty($wa_ready) && !empty($r['parent_contact'])): ?>
			<?php echo form_open(base_url('academy_broadcast'), array('style' => 'display:inline', 'onsubmit' => "return confirm('Send this parent\\'s digest via WhatsApp API?');")); ?>
			<input type="hidden" name="student_id" value="<?php echo (int) $r['student_id']; ?>">
			<button type="submit" name="send_cloud_one" value="1" class="btn btn-primary btn-xs" style="margin-left:4px" title="Cloud API">
				<i class="fab fa-whatsapp"></i> Send API
			</button>
			<?php echo form_close(); ?>
			<?php endif; ?>
			<a href="<?php echo $waShare; ?>" target="_blank" class="btn btn-default btn-xs" style="margin-left:4px" title="Pick any chat or group">
				<i class="fab fa-whatsapp"></i> Group / pick chat
			</a>
		</div>
	</div>

	<?php if (!empty($media)): ?>
	<div class="bcast-media">
		<?php foreach ($media as $m): ?>
			<?php if (!empty($m['audio_url'])): ?>
			<a class="btn btn-default btn-xs" href="<?php echo html_escape($m['audio_url']); ?>" target="_blank">🎙️ Play audio — <?php echo html_escape($m['label']); ?></a>
			<a class="btn btn-default btn-xs" href="<?php echo html_escape($m['audio_url']); ?>" download>💾 Download</a>
			<button type="button" class="btn btn-default btn-xs bcast-copy-url" data-url="<?php echo html_escape($m['audio_url']); ?>">Copy audio link</button>
			<?php endif; ?>
			<?php if (!empty($m['video_url'])): ?>
			<a class="btn btn-default btn-xs" href="<?php echo html_escape($m['video_url']); ?>" target="_blank">🎥 Open video — <?php echo html_escape($m['label']); ?></a>
			<button type="button" class="btn btn-default btn-xs bcast-copy-url" data-url="<?php echo html_escape($m['video_url']); ?>">Copy video link</button>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<pre class="bcast-msg"><?php echo html_escape($r['message']); ?></pre>
</div>
<?php endforeach; endif; ?>

<script>
window.BCAST_WA_LINKS = <?php echo json_encode(isset($waLinks) ? $waLinks : array()); ?>;
window.BCAST_MESSAGES = <?php echo json_encode(isset($allMsgs) ? $allMsgs : array()); ?>;
window.BCAST_COHORT = <?php echo json_encode($cohortMsg); ?>;
(function () {
	var status = document.getElementById('bcast_action_status');
	function setStatus(t) { if (status) status.textContent = t; }

	var openBtn = document.getElementById('bcast_open_all');
	if (openBtn) {
		openBtn.addEventListener('click', function () {
			var links = window.BCAST_WA_LINKS || [];
			if (!links.length) { setStatus('No parent phones to open.'); return; }
			links.forEach(function (url, i) {
				setTimeout(function () { window.open(url, '_blank'); }, i * 400);
			});
			setStatus('Opening ' + links.length + ' parent chat' + (links.length === 1 ? '' : 's') + '…');
		});
	}

	var copyBtn = document.getElementById('bcast_copy_all');
	if (copyBtn) {
		copyBtn.addEventListener('click', function () {
			var msgs = (window.BCAST_MESSAGES || []).join('\n\n———\n\n');
			if (!msgs) { setStatus('Nothing to copy.'); return; }
			if (navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(msgs).then(function () {
					setStatus('Copied ' + (window.BCAST_MESSAGES || []).length + ' message(s).');
				}).catch(function () { setStatus('Clipboard blocked.'); });
			} else { setStatus('Clipboard not available.'); }
		});
	}

	var copyCohort = document.getElementById('bcast_copy_cohort');
	if (copyCohort) {
		copyCohort.addEventListener('click', function () {
			var t = window.BCAST_COHORT || '';
			if (!t) return;
			if (navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(t).then(function () { setStatus('Cohort message copied.'); });
			}
		});
	}

	document.querySelectorAll('.bcast-copy-url').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var url = btn.getAttribute('data-url') || '';
			if (!url) return;
			if (navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(url).then(function () {
					btn.textContent = 'Copied!';
					setTimeout(function () { btn.textContent = 'Copy audio link'; }, 1200);
				});
			}
		});
	});
})();
</script>
