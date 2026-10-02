<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-globe"></i> Online classes</h4>
	</header>
	<div class="panel-body">
		<?php $this->load->view('online/_nav'); ?>
		<?php if (empty($ready)): ?>
		<div class="alert alert-warning">Run <code>application/migrations/online_students.sql</code> first.</div>
		<?php elseif (empty($board['ready'])): ?>
		<div class="alert alert-warning">Teacher groups are not ready yet.</div>
		<?php else: ?>
		<p class="text-muted">Slots stay on the Kano clock. A student is present today after they join the class or a recitation is saved. Teachers set the time and the meeting link under Academy, My Groups.</p>
		<?php if (empty($board['groups'])): ?>
		<p>No online class slot yet.</p>
		<?php else: ?>
		<?php foreach ($board['groups'] as $group): ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<strong><?php echo html_escape($group['name']); ?></strong>
				<?php if ($group['teacher'] !== ''): ?> · <?php echo html_escape($group['teacher']); ?><?php endif; ?>
				<div class="text-muted"><?php echo html_escape($group['lagos']); ?></div>
				<?php if ($group['url'] !== ''): ?>
				<div><a href="<?php echo html_escape($group['url']); ?>" target="_blank" rel="noopener"><?php echo html_escape($group['url']); ?></a></div>
				<?php else: ?>
				<div class="text-muted">No meeting link yet.</div>
				<?php endif; ?>
				<?php if (empty($group['members'])): ?>
				<p style="margin:.6rem 0 0">No online student in this group yet.</p>
				<?php else: ?>
				<table class="table table-condensed" style="margin:.6rem 0 0">
					<thead>
						<tr>
							<th>Student</th>
							<th>Today</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($group['members'] as $member): ?>
						<tr>
							<td><?php echo html_escape($member['name']); ?></td>
							<td><?php echo html_escape($member['presence']); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>
		<?php if (!empty($board['unassigned'])): ?>
		<h4>Not in a class yet</h4>
		<ul>
			<?php foreach ($board['unassigned'] as $student): ?>
			<li><?php echo html_escape($student['name']); ?><?php if ($student['country'] !== ''): ?> · <?php echo html_escape($student['country']); ?><?php endif; ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
