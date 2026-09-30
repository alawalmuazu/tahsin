<?php
$labels = array(
	'recording' => 'Recording',
	'pending_director' => 'With director',
	'director_rejected' => 'Director rejected',
	'pending_admin' => 'With admin',
	'admin_rejected' => 'Admin rejected',
	'acknowledged' => 'Acknowledged',
);
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-clipboard-check"></i> Session review</h4>
			</header>
			<div class="panel-body">
				<?php if (empty($ready)): ?>
					<div class="alert alert-warning">Run <code>application/migrations/academy_session_review.sql</code> first.</div>
				<?php elseif (empty($sessions)): ?>
					<p class="text-muted">No class sessions yet. A session appears when a teacher records an assigned student. It is sent to the director only after every assigned student has a drill or tahfiz entry that day.</p>
				<?php else: ?>
					<p class="text-muted">Each recitation category is its own session. If the facilitator uses groups, each group submits separately when all of its students are recorded. The director listens, then approves or rejects. Approval waits for the admin to release that category.</p>
					<?php if (!empty($can_admin) && !empty($pending_admin_today)): ?>
						<?php echo form_open('academy_review', array('style' => 'margin-bottom:1rem')); ?>
							<button class="btn btn-primary" name="release_today" value="1" type="submit">Release today’s sealed sessions (<?php echo (int) $pending_admin_today; ?>)</button>
						<?php echo form_close(); ?>
					<?php endif; ?>
					<p class="text-muted">Listen to the clip and read the Tajweed mistakes before you approve or acknowledge.</p>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Date</th>
								<th>Teacher</th>
								<th>Group</th>
								<th>Category</th>
								<th>Recorded</th>
								<th>Status</th>
								<th>Notes</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($sessions as $row): ?>
							<tr>
								<td><?php echo html_escape($row->session_date); ?></td>
								<td><?php echo html_escape($row->teacher_name); ?></td>
								<td><?php echo !empty($row->group_name) ? html_escape($row->group_name) : '<span class="text-muted">All assigned</span>'; ?></td>
								<td><?php
									$cats = $this->academy_model->recitationCategories();
									$ck = isset($row->recitation_category) ? strtoupper((string) $row->recitation_category) : '';
									echo html_escape(isset($cats[$ck]) ? $cats[$ck] : ($ck !== '' ? $ck : '—'));
								?></td>
								<td><?php echo (int) $row->recorded_count; ?> / <?php echo (int) $row->student_total; ?></td>
								<td><?php echo html_escape(isset($labels[$row->status]) ? $labels[$row->status] : $row->status); ?></td>
								<td>
									<?php if ($row->director_note): ?><div><strong>Director:</strong> <?php echo html_escape($row->director_note); ?></div><?php endif; ?>
									<?php if ($row->admin_note): ?><div><strong>Admin:</strong> <?php echo html_escape($row->admin_note); ?></div><?php endif; ?>
								</td>
								<td style="min-width:220px">
									<?php
									$step = null;
									if ($row->status === 'pending_director' && !empty($can_director)) {
										$step = 'director';
									} elseif ($row->status === 'pending_admin' && !empty($can_admin)) {
										$step = 'admin';
									}
									?>
									<?php $clip = !empty($row->weak_clip) ? $row->weak_clip : null; ?>
									<?php if ($clip && (!empty($can_director) || !empty($can_admin))): ?>
										<?php if ($clip): ?>
											<div style="margin-bottom:.6rem;min-width:280px">
												<div style="margin-bottom:.25rem">
													<?php echo html_escape($clip['student']); ?>
													<?php if (!empty($clip['portion'])): ?> · <?php echo html_escape($clip['portion']); ?><?php endif; ?>
													<?php if ($clip['accuracy'] !== null && $clip['accuracy'] !== ''): ?> · <?php echo html_escape($clip['accuracy']); ?>%<?php endif; ?>
													<?php if ($clip['mistakes'] !== null && $clip['mistakes'] !== ''): ?> · <?php echo (int) $clip['mistakes']; ?> mistakes<?php endif; ?>
													<?php if ($clip['seconds'] !== null && $clip['seconds'] !== ''): ?> · <?php echo (int) $clip['seconds']; ?>s<?php endif; ?>
													<?php if (!empty($clip['tarteel']['engine'])): ?> · <?php echo html_escape($clip['tarteel']['engine']); ?><?php endif; ?>
												</div>
												<?php $this->load->view('academy/_tarteel_player', array(
													'tp_surah' => isset($clip['surah_number']) ? (int) $clip['surah_number'] : 0,
													'tp_from' => isset($clip['ayah_from']) ? (int) $clip['ayah_from'] : 0,
													'tp_to' => !empty($clip['ayah_to']) ? (int) $clip['ayah_to'] : (isset($clip['ayah_from']) ? (int) $clip['ayah_from'] : 0),
													'tp_audio' => isset($clip['audio_url']) ? (string) $clip['audio_url'] : '',
													'tp_states' => !empty($clip['tarteel']['states']) ? $clip['tarteel']['states'] : array(),
													'tp_seconds' => isset($clip['seconds']) ? (int) $clip['seconds'] : 0,
												)); ?>
												<?php $report = !empty($clip['tarteel']) ? $clip['tarteel'] : array('correct' => array(), 'mistakes' => array(), 'transcript' => ''); ?>
												<?php if (!empty($report['transcript'])): ?>
													<div style="margin-top:.35rem"><strong>Heard</strong> <?php echo html_escape($report['transcript']); ?></div>
												<?php endif; ?>
												<?php if (!empty($report['correct'])): ?>
													<div style="margin-top:.35rem"><strong>Correct (<?php echo count($report['correct']); ?>)</strong></div>
													<ul style="margin:.2rem 0 0;padding-left:1.1rem">
														<?php foreach ($report['correct'] as $word): ?>
															<li>
																<?php if ($word['text'] !== ''): ?><?php echo html_escape($word['text']); ?> <?php endif; ?>
																ayah <?php echo (int) $word['ayah']; ?> · word <?php echo (int) $word['word']; ?>
															</li>
														<?php endforeach; ?>
													</ul>
												<?php endif; ?>
												<?php if (!empty($report['mistakes'])): ?>
													<div style="margin-top:.35rem"><strong>Tajweed mistakes (<?php echo count($report['mistakes']); ?>)</strong></div>
													<ul style="margin:.2rem 0 0;padding-left:1.1rem">
														<?php foreach ($report['mistakes'] as $mistake): ?>
															<li>
																<?php echo html_escape($mistake['label']); ?>
																<?php if ($mistake['text'] !== ''): ?> · <?php echo html_escape($mistake['text']); ?><?php endif; ?>
																<?php if (!empty($mistake['ayah'])): ?> · ayah <?php echo (int) $mistake['ayah']; ?><?php endif; ?>
																<?php if (!empty($mistake['word'])): ?> · word <?php echo (int) $mistake['word']; ?><?php endif; ?>
																<?php if ($mistake['expected'] !== ''): ?> · expected <?php echo html_escape($mistake['expected']); ?><?php endif; ?>
																<?php if ($mistake['received'] !== ''): ?> · heard <?php echo html_escape($mistake['received']); ?><?php endif; ?>
															</li>
														<?php endforeach; ?>
													</ul>
												<?php elseif ($clip['mistakes'] !== null && $clip['mistakes'] !== '' && (int) $clip['mistakes'] > 0): ?>
													<div class="text-muted">This recording was saved before the full Tarteel report. Only the mistake count was kept.</div>
												<?php else: ?>
													<div class="text-muted">No Tajweed mistakes marked.</div>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									<?php endif; ?>
									<?php if ($step): ?>
										<?php echo form_open('academy_review'); ?>
											<input type="hidden" name="decide" value="1">
											<input type="hidden" name="session_id" value="<?php echo (int) $row->id; ?>">
											<input type="hidden" name="step" value="<?php echo html_escape($step); ?>">
											<input type="text" name="note" class="form-control input-sm mb-xs" placeholder="Optional note">
											<button class="btn btn-success btn-xs" name="decision" value="approve" type="submit"><?php echo $step === 'admin' ? 'Acknowledge' : 'Approve'; ?></button>
											<button class="btn btn-danger btn-xs" name="decision" value="reject" type="submit">Reject</button>
										<?php echo form_close(); ?>
									<?php elseif (!$clip): ?>
										<span class="text-muted">—</span>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		</section>
	</div>
</div>
<script src="<?php echo base_url('assets/js/tarteel_playback.js?v=4'); ?>"></script>
<?php
$waGroupShare = $this->session->flashdata('wa_group_share');
$waGroupLink  = '';
if ($waGroupShare) {
	$_bid = isset($branch_id) ? $branch_id : $this->session->userdata('defaultBranch');
	if (!$_bid) { $_bid = 1; }
	if ($this->db->table_exists('whatsapp_cloud_config') && $this->db->field_exists('parent_group_link', 'whatsapp_cloud_config')) {
		$_cfgRow = $this->db->select('parent_group_link')->get_where('whatsapp_cloud_config', array('branch_id' => (int) $_bid))->row();
		if ($_cfgRow && !empty($_cfgRow->parent_group_link)) {
			$waGroupLink = trim($_cfgRow->parent_group_link);
		}
	}
}
if ($waGroupShare && is_string($waGroupShare) && trim($waGroupShare) !== ''):
?>
<style>
.wa-queue-bar{position:fixed;bottom:0;left:0;right:0;z-index:9999;background:#1b2e1b;color:#e2e8f0;padding:1rem 1.5rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;box-shadow:0 -4px 24px rgba(0,0,0,.35);font-size:.88rem;border-top:3px solid #25d366}
.wa-queue-bar .wa-q-progress{font-weight:700;font-size:1.1rem;color:#25d366;white-space:nowrap}
.wa-queue-bar .wa-q-status{flex:1;min-width:200px}
.wa-queue-bar .wa-q-preview{background:rgba(255,255,255,.08);border-radius:8px;padding:.5rem .75rem;font-size:.78rem;max-height:80px;overflow:auto;white-space:pre-wrap;line-height:1.4;margin-top:.25rem;color:#cbd5e1}
.wa-queue-bar button{border:none;border-radius:8px;padding:.5rem 1rem;font-weight:700;cursor:pointer;font-size:.82rem}
.wa-queue-bar .wa-q-copy{background:#25d366;color:#fff}
.wa-queue-bar .wa-q-copy:hover{background:#1da851}
.wa-queue-bar .wa-q-skip{background:rgba(255,255,255,.12);color:#e2e8f0}
.wa-queue-bar .wa-q-done{background:#059669;color:#fff}
.wa-queue-bar .wa-q-close{background:transparent;color:#94a3b8;font-size:1.2rem;padding:.25rem .5rem}
</style>
<div class="wa-queue-bar" id="waQueueBar">
	<div class="wa-q-progress" id="waQueueProgress"></div>
	<div class="wa-q-status">
		<div id="waQueueLabel"></div>
		<div class="wa-q-preview" id="waQueuePreview"></div>
	</div>
	<button class="wa-q-copy" id="waQueueCopy"><i class="fab fa-whatsapp"></i> Copy &amp; Open WhatsApp</button>
	<button class="wa-q-copy" id="waQueueCopyOnly" style="display:none"><i class="fas fa-clipboard"></i> Copy Next</button>
	<button class="wa-q-skip" id="waQueueSkip">Skip <i class="fas fa-forward"></i></button>
	<button class="wa-q-done" id="waQueueDone" style="display:none"><i class="fas fa-check"></i> All Done</button>
	<button class="wa-q-close" id="waQueueClose" title="Close">&times;</button>
</div>
<script>
(function () {
	var messages = [];
	try { messages = JSON.parse(<?php echo json_encode($waGroupShare); ?>); } catch (e) {}
	if (!messages || !messages.length) {
		document.getElementById('waQueueBar').style.display = 'none';
		return;
	}

	var groupLink = <?php echo json_encode($waGroupLink); ?> || '';
	var i = 0;
	var total = messages.length;
	var waOpened = false;
	var justAdvanced = false;

	var elProgress = document.getElementById('waQueueProgress');
	var elLabel    = document.getElementById('waQueueLabel');
	var elPreview  = document.getElementById('waQueuePreview');
	var elCopy     = document.getElementById('waQueueCopy');
	var elCopyOnly = document.getElementById('waQueueCopyOnly');
	var elSkip     = document.getElementById('waQueueSkip');
	var elDone     = document.getElementById('waQueueDone');
	var elClose    = document.getElementById('waQueueClose');
	var elBar      = document.getElementById('waQueueBar');

	function updateUI() {
		if (i >= total) {
			elProgress.textContent = '\u2705 ' + total + '/' + total;
			elLabel.innerHTML = '<strong>All ' + total + ' messages shared!</strong>';
			elPreview.textContent = '';
			elCopy.style.display = 'none';
			elCopyOnly.style.display = 'none';
			elSkip.style.display = 'none';
			elDone.style.display = '';
			return;
		}
		elProgress.textContent = '\ud83d\udce8 ' + (i + 1) + ' / ' + total;
		var snippet = messages[i].length > 160 ? messages[i].substring(0, 160) + '\u2026' : messages[i];
		elPreview.textContent = snippet;

		if (!waOpened) {
			elLabel.innerHTML = '<strong>Ready to share ' + total + ' message' + (total === 1 ? '' : 's') + '</strong> \u2014 click the green button to start';
			elCopy.style.display = '';
			elCopyOnly.style.display = 'none';
		} else {
			elLabel.innerHTML = '<strong>\u2705 Message ' + (i + 1) + ' of ' + total + ' copied!</strong> \u2014 switch to WhatsApp, paste (Ctrl+V), press Enter, then come back here';
			elCopy.style.display = 'none';
			elCopyOnly.style.display = '';
		}
		elSkip.style.display = '';
		elDone.style.display = 'none';
	}

	function copyMessage(idx) {
		if (idx >= total) return;
		var text = messages[idx];
		if (navigator.clipboard && navigator.clipboard.writeText) {
			navigator.clipboard.writeText(text).catch(function () { fallbackCopy(text); });
		} else {
			fallbackCopy(text);
		}
	}

	function fallbackCopy(text) {
		var ta = document.createElement('textarea');
		ta.value = text;
		ta.style.cssText = 'position:fixed;left:-9999px';
		document.body.appendChild(ta);
		ta.select();
		try { document.execCommand('copy'); } catch (e) {}
		document.body.removeChild(ta);
	}

	function openWhatsApp() {
		var url = groupLink || 'https://web.whatsapp.com/';
		window.open(url, 'wa_group_share');
		waOpened = true;
	}

	function advanceToNext() {
		i++;
		justAdvanced = true;
		setTimeout(function () { justAdvanced = false; }, 600);
		if (i < total) {
			copyMessage(i);
		}
		updateUI();
	}

	// First click: copy message 1 + open WhatsApp
	elCopy.addEventListener('click', function () {
		copyMessage(i);
		openWhatsApp();
		updateUI();
	});

	// Subsequent: copy next message
	elCopyOnly.addEventListener('click', function () {
		advanceToNext();
	});

	elSkip.addEventListener('click', function () {
		advanceToNext();
	});

	elDone.addEventListener('click', function () { elBar.style.display = 'none'; });
	elClose.addEventListener('click', function () { elBar.style.display = 'none'; });

	// Auto-advance when admin Alt-Tabs back from WhatsApp
	window.addEventListener('focus', function () {
		if (!waOpened || justAdvanced || i >= total) return;
		setTimeout(function () {
			if (justAdvanced || i >= total) return;
			advanceToNext();
		}, 400);
	});

	updateUI();
})();
</script>
<?php endif; ?>
