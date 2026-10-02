<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-globe"></i> Online students</h4>
	</header>
	<div class="panel-body">
		<?php $this->load->view('online/_nav'); ?>
		<?php if (empty($ready)): ?>
		<div class="alert alert-warning">Run <code>application/migrations/online_students.sql</code> before online students can be listed.</div>
		<?php elseif (empty($students)): ?>
		<p>No online student in this session yet. Admit one with <strong>How they attend</strong> set to <strong>Online</strong>.</p>
		<?php if (get_permission('student', 'is_add') || is_superadmin_loggedin() || is_admin_loggedin()): ?>
		<p><a class="btn btn-primary" href="<?php echo base_url('student/add'); ?>">Admit a student</a></p>
		<?php endif; ?>
		<?php else: ?>
		<p class="text-muted"><?php echo count($students); ?> online <?php echo count($students) === 1 ? 'student' : 'students'; ?> this session. The naira amount is the figure locked at admission.</p>
		<div class="table-responsive">
			<table class="table table-bordered table-condensed table-hover">
				<thead>
					<tr>
						<th>Student</th>
						<th>Parent</th>
						<th>Country</th>
						<th>Timezone</th>
						<th>Currency</th>
						<th>Locked in naira</th>
						<th>Paid</th>
						<th>Still to pay</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($students as $row): ?>
					<tr>
						<td>
							<?php if (get_permission('student', 'is_edit') || is_superadmin_loggedin()): ?>
							<a href="<?php echo base_url('student/profile/' . (int) $row['enroll_id']); ?>"><?php echo html_escape($row['name']); ?></a>
							<?php else: ?>
							<?php echo html_escape($row['name']); ?>
							<?php endif; ?>
							<?php if ($row['register_no'] !== ''): ?>
							<div class="text-muted"><?php echo html_escape($row['register_no']); ?></div>
							<?php endif; ?>
						</td>
						<td><?php echo $row['parent'] !== '' ? html_escape($row['parent']) : '—'; ?></td>
						<td><?php echo $row['country'] !== '' ? html_escape($row['country']) : '—'; ?></td>
						<td><?php echo $row['timezone_label'] !== '' ? html_escape($row['timezone_label']) : '—'; ?></td>
						<td>
							<?php if ($row['currency'] !== '' && $row['foreign'] > 0): ?>
							<?php echo html_escape($row['currency'] . ' ' . number_format($row['foreign'], 2, '.', ',')); ?>
							<?php if ($row['quote'] !== ''): ?>
							<div class="text-muted"><?php echo html_escape($row['quote']); ?></div>
							<?php endif; ?>
							<?php else: ?>
							—
							<?php endif; ?>
						</td>
						<td><?php echo $row['fee'] > 0 ? html_escape(currencyFormat($row['fee'])) : '—'; ?></td>
						<td><?php echo html_escape(currencyFormat($row['paid'])); ?></td>
						<td><?php echo $row['balance'] > 0 ? html_escape(currencyFormat($row['balance'])) : html_escape(currencyFormat(0)); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php endif; ?>
	</div>
</section>
