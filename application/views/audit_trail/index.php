<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title">
			<i class="fas fa-clipboard-list"></i> Audit Trail
			<?php if (get_permission('audit_trail', 'is_delete')): ?>
			<button type="button" class="btn btn-danger btn-xs pull-right" onclick="confirm_modal('<?php echo base_url('audit_trail/clear'); ?>')">
				<i class="fas fa-trash-alt"></i> Clear Log
			</button>
			<?php endif; ?>
		</h4>
	</header>
	<div class="panel-body">
		<p class="text-muted" style="margin-top:0;">
			Complete activity log of database changes (create / update / delete) and security events (login, approvals).
		</p>

		<form method="get" action="<?php echo base_url('audit_trail'); ?>" class="form-horizontal mb-md">
			<div class="row">
				<div class="col-md-2 mb-sm">
					<label>Action</label>
					<select name="action" class="form-control">
						<option value="">All</option>
						<?php foreach ($actions as $action): ?>
							<option value="<?php echo html_escape($action); ?>" <?php echo ($filters['action'] === $action) ? 'selected' : ''; ?>><?php echo html_escape($action); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-2 mb-sm">
					<label>Module / Table</label>
					<select name="module" class="form-control">
						<option value="">All</option>
						<?php foreach ($modules as $module): ?>
							<option value="<?php echo html_escape($module); ?>" <?php echo ($filters['module'] === $module) ? 'selected' : ''; ?>><?php echo html_escape($module); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-2 mb-sm">
					<label>User</label>
					<input type="text" name="user" class="form-control" value="<?php echo html_escape($filters['user']); ?>" placeholder="Name or ID">
				</div>
				<div class="col-md-2 mb-sm">
					<label>From</label>
					<input type="date" name="from" class="form-control" value="<?php echo html_escape($filters['from']); ?>">
				</div>
				<div class="col-md-2 mb-sm">
					<label>To</label>
					<input type="date" name="to" class="form-control" value="<?php echo html_escape($filters['to']); ?>">
				</div>
				<div class="col-md-2 mb-sm">
					<label>Search</label>
					<div class="input-group">
						<input type="text" name="q" class="form-control" value="<?php echo html_escape($filters['q']); ?>" placeholder="IP, URL, text">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
						</span>
					</div>
				</div>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered table-hover table-condensed table-export mb-none">
				<thead>
					<tr>
						<th>#</th>
						<th>When</th>
						<th>User</th>
						<th>Action</th>
						<th>Module</th>
						<th>Record</th>
						<th>Description</th>
						<th>IP</th>
						<th class="text-center">Detail</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($logs)): ?>
					<tr>
						<td colspan="9" class="text-center text-muted" style="padding:28px;">No audit records yet. Activity will appear here as users change data.</td>
					</tr>
					<?php else: ?>
						<?php $i = 1; foreach ($logs as $row): ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td style="white-space:nowrap;"><?php echo html_escape(date('M d, Y · h:i A', strtotime($row->created_at))); ?></td>
							<td>
								<?php echo html_escape($row->username ?: ('User #' . $row->user_id)); ?>
								<?php if ($row->role_id): ?>
									<br><small class="text-muted"><?php echo html_escape(get_type_name_by_id('roles', $row->role_id)); ?></small>
								<?php endif; ?>
							</td>
							<td><span class="badge" style="background:#10241e;"><?php echo html_escape($row->action); ?></span></td>
							<td><?php echo html_escape($row->module ?: $row->table_name); ?></td>
							<td><?php echo html_escape($row->record_id ?: '—'); ?></td>
							<td><?php echo html_escape($row->description ?: '—'); ?></td>
							<td><?php echo html_escape($row->ip_address ?: '—'); ?></td>
							<td class="text-center">
								<a href="<?php echo base_url('audit_trail/view/' . $row->id); ?>" class="btn btn-default btn-xs">
									<i class="fas fa-eye"></i> View
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
