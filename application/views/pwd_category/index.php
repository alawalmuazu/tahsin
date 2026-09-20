<div class="row">
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-edit"></i> Add / Edit Student Category</h4>
			</header>
			<?php echo form_open(base_url('pwd_category')); ?>
			<input type="hidden" name="id" id="pwd_id" value="">
			<div class="panel-body">
				<p class="text-muted">
					These are <strong>ability / PWD</strong> categories (separate from programme Category: With/Without Technical Skills).
					Default for new admissions is <strong>Physically Fit</strong>.
				</p>
				<?php if (!$this->pwd_category_model->tableReady()): ?>
				<div class="alert alert-warning">Run <code>application/migrations/pwd_student_categories.sql</code> first.</div>
				<?php endif; ?>
				<div class="form-group">
					<label class="control-label">Name <span class="required">*</span></label>
					<input type="text" class="form-control" name="name" id="pwd_name" required placeholder="e.g. Visually Impaired (Blind)">
				</div>
				<div class="form-group">
					<label class="control-label">Sort order</label>
					<input type="number" class="form-control" name="sort_order" id="pwd_sort" value="10">
				</div>
				<div class="checkbox-replace mt-md">
					<label class="i-checks">
						<input type="checkbox" name="active" id="pwd_active" value="1" checked><i></i> Active
					</label>
				</div>
				<div class="checkbox-replace mt-sm">
					<label class="i-checks">
						<input type="checkbox" name="is_default" id="pwd_default" value="1"><i></i> Default for new admissions
					</label>
				</div>
			</div>
			<footer class="panel-footer">
				<button type="submit" name="save" value="1" class="btn btn-default pull-right" <?php echo !$this->pwd_category_model->tableReady() ? 'disabled' : ''; ?>>
					<i class="fas fa-plus-circle"></i> <?php echo translate('save'); ?>
				</button>
				<button type="button" class="btn btn-default" id="pwd_reset">Clear</button>
			</footer>
			<?php echo form_close(); ?>
		</section>
	</div>
	<div class="col-md-7">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-list"></i> Student Categories (PWD)</h4>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed mb-none">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Default</th>
								<th>Active</th>
								<th>Order</th>
								<th><?php echo translate('action'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($list)): ?>
							<tr><td colspan="6" class="text-center text-muted">No categories yet.</td></tr>
							<?php else: $i = 1; foreach ($list as $row): ?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo html_escape($row->name); ?></td>
								<td><?php echo (int) $row->is_default ? '<span class="label label-success">Yes</span>' : '—'; ?></td>
								<td><?php echo (int) $row->active ? 'Yes' : 'No'; ?></td>
								<td><?php echo (int) $row->sort_order; ?></td>
								<td>
									<button type="button" class="btn btn-default btn-circle btn-xs pwd-edit"
										data-id="<?php echo (int) $row->id; ?>"
										data-name="<?php echo html_escape($row->name); ?>"
										data-sort="<?php echo (int) $row->sort_order; ?>"
										data-active="<?php echo (int) $row->active; ?>"
										data-default="<?php echo (int) $row->is_default; ?>">
										<i class="fas fa-pen"></i>
									</button>
									<?php if (!(int) $row->is_default && (get_permission('pwd_category', 'is_delete') || is_superadmin_loggedin())): ?>
									<?php echo btn_delete('pwd_category/delete/' . (int) $row->id); ?>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
$(function () {
	$('.pwd-edit').on('click', function () {
		var $b = $(this);
		$('#pwd_id').val($b.data('id'));
		$('#pwd_name').val($b.data('name'));
		$('#pwd_sort').val($b.data('sort'));
		$('#pwd_active').prop('checked', String($b.data('active')) === '1');
		$('#pwd_default').prop('checked', String($b.data('default')) === '1');
	});
	$('#pwd_reset').on('click', function () {
		$('#pwd_id').val('');
		$('#pwd_name').val('');
		$('#pwd_sort').val(10);
		$('#pwd_active').prop('checked', true);
		$('#pwd_default').prop('checked', false);
	});
});
</script>
