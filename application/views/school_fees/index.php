<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-money-bill-wave"></i> School Fees Settings</h4>
	</header>
	<?php echo form_open(base_url('school_fees'), array('class' => 'form-horizontal')); ?>
	<div class="panel-body">
		<p class="text-muted">
			Set the default school fee and optional amounts by <strong>Section</strong> (Boarding / Day / Weekend)
			and <strong>Category</strong> (With / Without Technical Skills), for <strong>Physically Fit</strong>
			and each <strong>PWD</strong> type. Admission tuition uses the matching amount automatically.
		</p>

		<?php if (!$this->school_fee_model->tableReady()): ?>
		<div class="alert alert-warning">
			Run <code>application/migrations/school_fees_settings.sql</code> on the database first.
		</div>
		<?php elseif (!$this->school_fee_model->hasPwdDimension()): ?>
		<div class="alert alert-warning">
			Run <code>application/migrations/school_fees_section_programme_pwd.sql</code> on the database first.
		</div>
		<?php endif; ?>

		<div class="form-group">
			<label class="col-md-3 control-label">Default School Fees <span class="required">*</span></label>
			<div class="col-md-4">
				<input type="text" inputmode="decimal" name="default_amount" class="form-control money-input" value="<?php echo html_escape(amount_format($default_amount)); ?>" required>
				<span class="help-block">Used when no Section × Category amount is set.</span>
			</div>
		</div>

		<?php
		$canMatrix = !empty($sections) && !empty($programme_categories) && (!empty($pwd_fit) || !empty($pwd_list));
		$matrices = array();
		if (!empty($pwd_fit)) {
			$matrices[] = array('row' => $pwd_fit, 'title' => 'Physically Fit', 'badge' => '');
		}
		if (!empty($pwd_list)) {
			foreach ($pwd_list as $pwdRow) {
				$matrices[] = array('row' => $pwdRow, 'title' => $pwdRow->name, 'badge' => 'PWD');
			}
		}
		if ($canMatrix && !empty($matrices)):
			$pwdHeadingShown = false;
			foreach ($matrices as $block):
				$pwdRow = $block['row'];
				$pwdId = (int) $pwdRow->id;
				if ($block['badge'] === 'PWD' && !$pwdHeadingShown):
					$pwdHeadingShown = true;
		?>
		<hr>
		<h4 class="mt-md mb-md"><span class="label label-primary">PWD</span> fee matrices</h4>
		<?php endif; ?>
		<div class="mt-lg">
			<h4 class="mb-sm">
				<?php echo html_escape($block['title']); ?>
				<?php if ($block['badge'] !== ''): ?><span class="label label-primary"><?php echo html_escape($block['badge']); ?></span><?php endif; ?>
			</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>Section \ Category</th>
							<?php foreach ($programme_categories as $cat): ?>
							<th><?php echo html_escape($cat->name); ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($sections as $sec): ?>
						<tr>
							<th style="background:#f8fafc;"><?php echo html_escape($sec->name); ?></th>
							<?php foreach ($programme_categories as $cat):
								$val = isset($fee_map[$pwdId][$sec->id][$cat->id]) ? $fee_map[$pwdId][$sec->id][$cat->id] : '';
							?>
							<td>
								<input type="text" inputmode="decimal" class="form-control money-input"
									name="fee[<?php echo $pwdId; ?>][<?php echo (int) $sec->id; ?>][<?php echo (int) $cat->id; ?>]"
									value="<?php echo $val !== '' ? html_escape(amount_format($val)) : ''; ?>"
									placeholder="<?php echo html_escape(amount_format($default_amount)); ?>">
							</td>
							<?php endforeach; ?>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php endforeach; ?>
		<p class="text-muted"><small>Leave a cell empty or 0 to fall back to the default amount.</small></p>
		<?php else: ?>
		<div class="alert alert-info">Add Sections, Programme Categories, and Student Categories (PWD) first, then return here.</div>
		<?php endif; ?>
	</div>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-md-offset-9 col-md-3">
				<button type="submit" name="save" value="1" class="btn btn-default btn-block" <?php echo (!$this->school_fee_model->tableReady() || !$this->school_fee_model->hasPwdDimension()) ? 'disabled' : ''; ?>>
					<i class="fas fa-save"></i> <?php echo translate('save'); ?>
				</button>
			</div>
		</div>
	</footer>
	<?php echo form_close(); ?>
</section>
<script type="text/javascript">
(function ($) {
	function formatMoneyInput(el) {
		var raw = String($(el).val() || '').replace(/,/g, '');
		if (raw === '' || isNaN(raw)) {
			return;
		}
		var n = parseFloat(raw);
		$(el).val(n.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
	}
	$(document).on('blur', '.money-input', function () {
		formatMoneyInput(this);
	});
	$(document).on('focus', '.money-input', function () {
		var raw = String($(this).val() || '').replace(/,/g, '');
		$(this).val(raw);
	});
})(jQuery);
</script>
