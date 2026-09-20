<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<div class="tabs-custom">
				<ul class="nav nav-tabs">
					<li class="<?php echo $scope == 'all' ? 'active' : ''; ?>">
						<a href="<?php echo base_url('audit_trail/index/all'); ?>">
							<i class="fas fa-list-ul"></i> All
						</a>
					</li>
					<li class="<?php echo $scope == 'security' ? 'active' : ''; ?>">
						<a href="<?php echo base_url('audit_trail/index/security'); ?>">
							<i class="fas fa-shield-alt"></i> Security
						</a>
					</li>
					<li class="<?php echo $scope == 'changes' ? 'active' : ''; ?>">
						<a href="<?php echo base_url('audit_trail/index/changes'); ?>">
							<i class="fas fa-database"></i> Data Changes
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane box active mb-md">
						<span class="export_title hidden">Audit Trail</span>
						<?php if (get_permission('audit_trail', 'is_delete')) { ?>
							<button class="btn btn-danger btn-circle mb-md" onclick="confirm_modal('<?php echo base_url('audit_trail/clear'); ?>')">
								<i class="fas fa-trash-alt"></i> Clear Audit Log
							</button>
						<?php } ?>
						<table class="table table-bordered table-hover table-condensed table-audit" cellpadding="0" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th class="no-sort"><?php echo translate('sl'); ?></th>
									<?php if (is_multi_school()): ?>
									<th><?php echo translate('branch'); ?></th>
									<?php endif; ?>
									<th><?php echo translate('user'); ?></th>
									<th><?php echo translate('role'); ?></th>
									<th>Action</th>
									<th>Module</th>
									<th>Description</th>
									<th>IP <?php echo translate('address'); ?></th>
									<th>Date / Time</th>
									<th class="no-sort"><?php echo translate('action'); ?></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		initDatatable('.table-audit', "audit_trail/getLogListDT/<?php echo html_escape($scope); ?>");
	});
</script>
