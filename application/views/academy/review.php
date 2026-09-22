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
					<p class="text-muted">The director listens, then approves or rejects. Approval waits for the admin to release the day. One release publishes every session the director already sealed today. Reject still sends a single day back.</p>
					<?php if (!empty($can_admin) && !empty($pending_admin_today)): ?>
						<?php echo form_open('academy_review', array('style' => 'margin-bottom:1rem')); ?>
							<button class="btn btn-primary" name="release_today" value="1" type="submit">Release today’s sealed sessions (<?php echo (int) $pending_admin_today; ?>)</button>
						<?php echo form_close(); ?>
					<?php endif; ?>
					<?php
					$featured = null;
					foreach ($sessions as $row) {
						if ($row->status === 'pending_director' && !empty($row->weak_clip) && !empty($can_director)) {
							$featured = $row;
							break;
						}
					}
					?>
					<?php if ($featured): $clip = $featured->weak_clip; ?>
						<div class="well" style="margin-bottom:1rem">
							<strong>Listen first</strong>
							<div style="margin:.4rem 0">
								<?php echo html_escape($clip['student']); ?>
								· <?php echo html_escape($featured->teacher_name); ?>
								<?php if (!empty($clip['category'])): ?> · <?php echo html_escape($clip['category']); ?><?php endif; ?>
								<?php if (!empty($clip['portion'])): ?> · <?php echo html_escape($clip['portion']); ?><?php endif; ?>
								<?php if ($clip['accuracy'] !== null && $clip['accuracy'] !== ''): ?> · <?php echo html_escape($clip['accuracy']); ?>%<?php endif; ?>
								<?php if ($clip['mistakes'] !== null && $clip['mistakes'] !== ''): ?> · <?php echo (int) $clip['mistakes']; ?> mistakes<?php endif; ?>
							</div>
							<?php if (!empty($clip['audio_url'])): ?>
								<audio controls preload="none" src="<?php echo html_escape($clip['audio_url']); ?>" style="width:100%;max-width:480px"></audio>
							<?php else: ?>
								<p class="text-muted" style="margin:.4rem 0">No audio on this row. The portion above is the weakest score for <?php echo html_escape($featured->session_date); ?>.</p>
							<?php endif; ?>
							<?php echo form_open('academy_review', array('style' => 'margin-top:.6rem')); ?>
								<input type="hidden" name="decide" value="1">
								<input type="hidden" name="session_id" value="<?php echo (int) $featured->id; ?>">
								<input type="hidden" name="step" value="director">
								<input type="text" name="note" class="form-control input-sm mb-xs" placeholder="Optional note" style="max-width:360px">
								<button class="btn btn-success btn-sm" name="decision" value="approve" type="submit">Approve</button>
								<button class="btn btn-danger btn-sm" name="decision" value="reject" type="submit">Reject</button>
							<?php echo form_close(); ?>
						</div>
					<?php endif; ?>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Date</th>
								<th>Teacher</th>
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
									<?php if ($step): ?>
										<?php echo form_open('academy_review'); ?>
											<input type="hidden" name="decide" value="1">
											<input type="hidden" name="session_id" value="<?php echo (int) $row->id; ?>">
											<input type="hidden" name="step" value="<?php echo html_escape($step); ?>">
											<input type="text" name="note" class="form-control input-sm mb-xs" placeholder="Optional note">
											<button class="btn btn-success btn-xs" name="decision" value="approve" type="submit"><?php echo $step === 'admin' ? 'Acknowledge' : 'Approve'; ?></button>
											<button class="btn btn-danger btn-xs" name="decision" value="reject" type="submit">Reject</button>
										<?php echo form_close(); ?>
									<?php else: ?>
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
