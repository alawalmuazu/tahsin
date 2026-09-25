<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-user-check"></i> Parent Approvals</h4>
			</header>
			<div class="panel-body">
				<div class="alert alert-info">
					A director or an admin reviews a parent here before the portal login becomes active. Approve sends them to a password change on first sign-in. Reject removes only the pending login. The parent profile and children stay.
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed mb-none">
						<thead>
							<tr>
								<th>#</th>
								<th>Guardian Name</th>
								<th>Requested Role</th>
								<th>Username</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Children</th>
								<th>Date Submitted</th>
								<th>Status</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $count = 1; foreach ($pending_parents as $row):
								$username = !empty($row->login_username) ? $row->login_username : (!empty($row->email) ? $row->email : ('parent' . $row->id));
								$phones = trim((string) $row->mobileno);
								if (!empty($row->extra_phones)) {
									$more = json_decode($row->extra_phones, true);
									if (is_array($more)) {
										foreach ($more as $phone) {
											$phone = trim((string) $phone);
											if ($phone !== '') {
												$phones .= ($phones !== '' ? ', ' : '') . $phone;
											}
										}
									}
								}
								$submitted = !empty($row->login_created) ? date('M d, Y · h:i A', strtotime($row->login_created)) : '—';
							?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo html_escape($row->name); ?></td>
								<td><span class="badge" style="background:#1a6b3c;color:#fff;font-weight:600;padding:4px 10px;border-radius:12px;">Parent</span></td>
								<td><code><?php echo html_escape($username); ?></code></td>
								<td><?php echo $row->email !== '' ? html_escape($row->email) : '<span class="text-muted">—</span>'; ?></td>
								<td><?php echo $phones !== '' ? html_escape($phones) : '<span class="text-muted">—</span>'; ?></td>
								<td><?php echo !empty($row->children_names) ? html_escape($row->children_names) : '<span class="text-muted">Unlinked</span>'; ?></td>
								<td><?php echo html_escape($submitted); ?></td>
								<td><span class="label label-warning" style="background:#e07a5f;color:#fff;padding:4px 8px;border-radius:4px;">Pending Review</span></td>
								<td class="text-center" style="white-space:nowrap;">
									<button type="button" class="btn btn-default btn-xs btn-preview-parent" style="margin-right:4px;"
										data-name="<?php echo html_escape($row->name); ?>"
										data-relation="<?php echo html_escape($row->relation); ?>"
										data-username="<?php echo html_escape($username); ?>"
										data-email="<?php echo html_escape($row->email); ?>"
										data-mobile="<?php echo html_escape($phones); ?>"
										data-children="<?php echo html_escape($row->children_names); ?>"
										data-occupation="<?php echo html_escape($row->occupation); ?>"
										data-address="<?php echo html_escape($row->address); ?>"
										data-submitted="<?php echo html_escape($submitted); ?>"
										data-approve-url="<?php echo base_url('parents/approve/' . $row->id); ?>"
										data-reject-url="<?php echo base_url('parents/reject/' . $row->id); ?>">
										<i class="fas fa-eye"></i> Preview
									</button>
									<a href="<?php echo base_url('parents/approve/' . $row->id); ?>" class="btn btn-success btn-xs parent-confirm" style="margin-right:4px;" data-confirm="Approve and activate the portal for <?php echo html_escape($row->name); ?>?" data-confirm-title="Approve parent" data-confirm-button="Approve" data-confirm-class="btn btn-success">
										<i class="fas fa-check"></i> Approve
									</a>
									<a href="<?php echo base_url('parents/reject/' . $row->id); ?>" class="btn btn-danger btn-xs parent-confirm" data-confirm="Reject this parent login? The parent profile and children will stay." data-confirm-title="Reject parent" data-confirm-button="Reject" data-confirm-class="btn btn-danger">
										<i class="fas fa-times"></i> Reject
									</a>
								</td>
							</tr>
							<?php endforeach; ?>
							<?php if (empty($pending_parents)): ?>
							<tr>
								<td colspan="10" class="text-center" style="padding:30px;">
									<i class="fas fa-check-circle" style="font-size:32px;color:#1a6b3c;display:block;margin-bottom:10px;"></i>
									<p style="font-weight:600;margin-bottom:4px;">No Pending Parents</p>
									<span class="text-muted">Every parent login has been reviewed.</span>
								</td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>

<div class="modal fade" id="parentPreviewModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius:10px;overflow:hidden;">
			<div class="modal-header" style="background:#10241e;color:#fff;border:0;">
				<button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:0.85;"><span>&times;</span></button>
				<h4 class="modal-title" style="font-weight:600;"><i class="fas fa-user-circle"></i> Application Preview</h4>
			</div>
			<div class="modal-body">
				<h3 id="parent_preview_name" style="margin-top:0;"></h3>
				<p><span class="badge" style="background:#1a6b3c;color:#fff;">Parent</span> <span class="label label-warning" style="background:#e07a5f;color:#fff;">Pending Review</span></p>
				<table class="table table-bordered table-condensed mb-none">
					<tbody>
						<tr><th style="width:30%;background:#f8fafc;">Relation</th><td id="parent_preview_relation"></td></tr>
						<tr><th style="background:#f8fafc;">Username</th><td><code id="parent_preview_username"></code></td></tr>
						<tr><th style="background:#f8fafc;">Email</th><td id="parent_preview_email"></td></tr>
						<tr><th style="background:#f8fafc;">Phone</th><td id="parent_preview_mobile"></td></tr>
						<tr><th style="background:#f8fafc;">Occupation</th><td id="parent_preview_occupation"></td></tr>
						<tr><th style="background:#f8fafc;">Children</th><td id="parent_preview_children"></td></tr>
						<tr><th style="background:#f8fafc;">Address</th><td id="parent_preview_address"></td></tr>
						<tr><th style="background:#f8fafc;">Date Submitted</th><td id="parent_preview_submitted"></td></tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<a href="#" id="parent_preview_reject" class="btn btn-danger parent-confirm" data-confirm="Reject this parent login? The parent profile and children will stay." data-confirm-title="Reject parent" data-confirm-button="Reject" data-confirm-class="btn btn-danger"><i class="fas fa-times"></i> Reject</a>
				<a href="#" id="parent_preview_approve" class="btn btn-success parent-confirm" data-confirm="Approve and activate the portal for this parent?" data-confirm-title="Approve parent" data-confirm-button="Approve" data-confirm-class="btn btn-success"><i class="fas fa-check"></i> Approve</a>
			</div>
		</div>
	</div>
</div>
<script>
$(document).on('click', '.btn-preview-parent', function () {
	var $btn = $(this);
	function dash(value) { return value ? value : '—'; }
	$('#parent_preview_name').text($btn.data('name') || 'Parent');
	$('#parent_preview_relation').text(dash($btn.data('relation')));
	$('#parent_preview_username').text(dash($btn.data('username')));
	$('#parent_preview_email').text(dash($btn.data('email')));
	$('#parent_preview_mobile').text(dash($btn.data('mobile')));
	$('#parent_preview_occupation').text(dash($btn.data('occupation')));
	$('#parent_preview_children').text(dash($btn.data('children')));
	$('#parent_preview_address').text(dash($btn.data('address')));
	$('#parent_preview_submitted').text(dash($btn.data('submitted')));
	$('#parent_preview_approve').attr('href', $btn.data('approve-url'));
	$('#parent_preview_reject').attr('href', $btn.data('reject-url'));
	$('#parentPreviewModal').modal('show');
});
$(document).on('click', 'a.parent-confirm', function (e) {
	e.preventDefault();
	var href = $(this).attr('href');
	var text = $(this).attr('data-confirm') || 'Continue?';
	swal({
		title: $(this).attr('data-confirm-title') || 'Are you sure?',
		text: text,
		type: 'warning',
		showCancelButton: true,
		confirmButtonClass: $(this).attr('data-confirm-class') || 'btn btn-default swal2-btn-default',
		cancelButtonClass: 'btn btn-default swal2-btn-default',
		confirmButtonText: $(this).attr('data-confirm-button') || 'Yes, continue',
		cancelButtonText: 'Cancel',
		buttonsStyling: false,
		showCloseButton: true,
		focusConfirm: false
	}).then(function (result) {
		if (result && result.value) {
			window.location.href = href;
		}
	});
	return false;
});
</script>
