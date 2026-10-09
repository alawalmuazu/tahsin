<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><?php echo $own_only ? 'Interns you mentor' : 'Interns'; ?></h4>
	</header>
	<div class="panel-body">
		<?php $CI = get_instance(); if (!$CI->db->field_exists('mentor_id', 'staff')): ?>
			<div class="alert alert-warning">Run <code>application/migrations/intern_employee.sql</code> first.</div>
		<?php elseif (empty($interns)): ?>
			<p class="text-muted"><?php echo $own_only ? 'No intern is assigned to you yet.' : 'No intern has been added yet.'; ?></p>
		<?php else: ?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th><?php echo translate('name'); ?></th>
							<th><?php echo translate('designation'); ?></th>
							<?php if (!$own_only): ?><th><?php echo translate('mentor'); ?></th><?php endif; ?>
							<th><?php echo translate('mobile_no'); ?></th>
							<th><?php echo translate('email'); ?></th>
							<th><?php echo translate('joining_date'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($interns as $row): ?>
						<tr>
							<td><?php echo html_escape($row->name); ?></td>
							<td><?php echo html_escape($row->designation_name); ?></td>
							<?php if (!$own_only): ?><td><?php echo $row->mentor_name !== '' && $row->mentor_name !== null ? html_escape($row->mentor_name) : 'Not assigned'; ?></td><?php endif; ?>
							<td><?php echo html_escape($row->mobileno); ?></td>
							<td><?php echo html_escape($row->email); ?></td>
							<td><?php echo _d($row->joining_date); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
</section>
