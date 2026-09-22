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
					<p class="text-muted">Director approves or rejects. Either way the teacher is notified. An approval goes to the admin to acknowledge or reject. Either way the director is notified. Acknowledgement unlocks WhatsApp broadcast and parent/student progress for that day.</p>
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
