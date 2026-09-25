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
					<p class="text-muted">Each recitation category is its own session. The director listens, then approves or rejects. Approval waits for the admin to release that category. Another category with the same student opens a new review.</p>
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
