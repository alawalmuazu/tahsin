<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title">
			<i class="fas fa-clipboard-list"></i> Audit Detail #<?php echo (int) $row->id; ?>
			<a href="<?php echo base_url('audit_trail'); ?>" class="btn btn-default btn-xs pull-right">
				<i class="fas fa-arrow-left"></i> Back
			</a>
		</h4>
	</header>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-bordered table-condensed">
				<tr><th style="width:220px;background:#f8fafc;">When</th><td><?php echo html_escape(date('M d, Y · h:i:s A', strtotime($row->created_at))); ?></td></tr>
				<tr><th style="background:#f8fafc;">User</th><td><?php echo html_escape($row->username ?: ('#' . $row->user_id)); ?></td></tr>
				<tr><th style="background:#f8fafc;">Role</th><td><?php echo $row->role_id ? html_escape(get_type_name_by_id('roles', $row->role_id)) : '—'; ?></td></tr>
				<tr><th style="background:#f8fafc;">Action</th><td><strong><?php echo html_escape($row->action); ?></strong></td></tr>
				<tr><th style="background:#f8fafc;">Module</th><td><?php echo html_escape($row->module); ?></td></tr>
				<tr><th style="background:#f8fafc;">Table</th><td><?php echo html_escape($row->table_name ?: '—'); ?></td></tr>
				<tr><th style="background:#f8fafc;">Record ID</th><td><?php echo html_escape($row->record_id ?: '—'); ?></td></tr>
				<tr><th style="background:#f8fafc;">Description</th><td><?php echo html_escape($row->description ?: '—'); ?></td></tr>
				<tr><th style="background:#f8fafc;">IP Address</th><td><?php echo html_escape($row->ip_address ?: '—'); ?></td></tr>
				<tr><th style="background:#f8fafc;">URL</th><td style="word-break:break-all;"><?php echo html_escape($row->url ?: '—'); ?></td></tr>
				<tr><th style="background:#f8fafc;">User Agent</th><td style="word-break:break-all;"><?php echo html_escape($row->user_agent ?: '—'); ?></td></tr>
			</table>
		</div>

		<div class="row">
			<div class="col-md-6">
				<h5 style="font-weight:700;">Old Values</h5>
				<pre style="background:#111;color:#e8d39a;padding:14px;border-radius:8px;max-height:420px;overflow:auto;"><?php
					if ($row->old_values) {
						$decoded = json_decode($row->old_values, true);
						echo html_escape($decoded ? json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $row->old_values);
					} else {
						echo '—';
					}
				?></pre>
			</div>
			<div class="col-md-6">
				<h5 style="font-weight:700;">New Values</h5>
				<pre style="background:#111;color:#9ae8c0;padding:14px;border-radius:8px;max-height:420px;overflow:auto;"><?php
					if ($row->new_values) {
						$decoded = json_decode($row->new_values, true);
						echo html_escape($decoded ? json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $row->new_values);
					} else {
						echo '—';
					}
				?></pre>
			</div>
		</div>
	</div>
</section>
