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
			Online students are not charged from these campus tables. Set their fee in the currency of their country. Admission converts it to naira at the current rate.
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

		<?php if ($this->school_fee_model->pricesReady()): ?>
		<div class="form-group">
			<label class="col-md-3 control-label">Online fees by place</label>
			<div class="col-md-9">
				<?php if (empty($online_rate_ok)): ?>
				<div class="alert alert-warning">The current rate to naira could not be loaded. Amounts stay in their own currency until the rate is available.</div>
				<?php endif; ?>
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>Place</th>
							<th>Currency</th>
							<th>Fee in that currency</th>
							<th>Rate to naira</th>
							<th>In naira now</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($online_currencies as $code => $place):
							$val = isset($online_prices[$code]) ? $online_prices[$code] : 0;
							$rate = isset($online_rates[$code]) ? (float) $online_rates[$code] : 0;
							$nairaNow = ($val > 0 && $rate > 0) ? round($val * $rate, 2) : 0;
						?>
						<tr>
							<td><?php echo html_escape($place); ?></td>
							<td><?php echo html_escape($code); ?></td>
							<td>
								<input type="text" inputmode="decimal" class="form-control money-input js-online-price" name="online_price[<?php echo html_escape($code); ?>]" value="<?php echo $val > 0 ? html_escape(amount_format($val)) : ''; ?>" placeholder="0.00">
							</td>
							<td>
								<?php if ($code === 'NGN'): ?>
									Already naira
								<?php elseif ($rate > 0): ?>
									1 <?php echo html_escape($code); ?> = <?php echo html_escape(number_format($rate, 2, '.', ',')); ?>
								<?php else: ?>
									Rate unavailable
								<?php endif; ?>
							</td>
							<td class="js-online-naira" data-rate="<?php echo $rate > 0 ? html_escape($rate) : '0'; ?>">
								<?php echo $nairaNow > 0 ? html_escape(currencyFormat($nairaNow)) : '—'; ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<span class="help-block">
					Country picks the currency. Timezone is used when the country is not recognised.
					<?php if (!empty($online_rate_at)): ?>
						Rates loaded <?php echo html_escape(date('j M Y, g:i A', $online_rate_at)); ?>.
					<?php endif; ?>
					The naira figure is locked on the student at admission.
				</span>
			</div>
		</div>
		<?php else: ?>
		<div class="alert alert-warning">
			Run <code>application/migrations/online_fee_currency.sql</code> before online fees can be saved.
		</div>
		<?php endif; ?>

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
	function paintOnlineNaira(input) {
		var cell = $(input).closest('tr').find('.js-online-naira');
		if (!cell.length) {
			return;
		}
		var rate = parseFloat(cell.attr('data-rate')) || 0;
		var raw = String($(input).val() || '').replace(/,/g, '');
		var n = parseFloat(raw);
		if (!(rate > 0)) {
			cell.text('Rate unavailable');
			return;
		}
		if (!(n > 0)) {
			cell.text('—');
			return;
		}
		cell.text('\u20A6' + (n * rate).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
	}
	$(document).on('blur', '.money-input', function () {
		formatMoneyInput(this);
		paintOnlineNaira(this);
	});
	$(document).on('input', '.js-online-price', function () {
		paintOnlineNaira(this);
	});
	$(document).on('focus', '.money-input', function () {
		var raw = String($(this).val() || '').replace(/,/g, '');
		$(this).val(raw);
	});
})(jQuery);
</script>
