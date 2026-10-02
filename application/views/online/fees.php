<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-globe"></i> Online fees</h4>
	</header>
	<?php echo form_open(base_url('online/fees'), array('class' => 'form-horizontal')); ?>
	<div class="panel-body">
		<?php $this->load->view('online/_nav'); ?>
		<p class="text-muted">Set the fee in the currency of the student’s country. Admission converts it to naira at the current rate and locks that figure on the student. Campus boarding fees stay under Settings, School Fees.</p>
		<?php if (empty($prices_ready)): ?>
		<div class="alert alert-warning">Run <code>application/migrations/online_fee_currency.sql</code> before these prices can be saved.</div>
		<?php else: ?>
		<?php if (empty($online_rate_ok)): ?>
		<div class="alert alert-warning">The current rate to naira could not be loaded. Amounts stay in their own currency until the rate is available.</div>
		<?php endif; ?>
		<div class="table-responsive">
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
							<?php if (!empty($can_edit)): ?>
							<input type="text" inputmode="decimal" class="form-control money-input js-online-price" name="online_price[<?php echo html_escape($code); ?>]" value="<?php echo $val > 0 ? html_escape(amount_format($val)) : ''; ?>" placeholder="0.00">
							<?php else: ?>
							<?php echo $val > 0 ? html_escape(amount_format($val)) : '—'; ?>
							<?php endif; ?>
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
		</div>
		<span class="help-block">
			Country picks the currency. Timezone is used when the country is not recognised.
			<?php if (!empty($online_rate_at)): ?>
			Rates loaded <?php echo html_escape(date('j M Y, g:i A', $online_rate_at)); ?>.
			<?php endif; ?>
			The naira figure is locked on the student at admission.
		</span>
		<?php endif; ?>
	</div>
	<?php if (!empty($prices_ready) && !empty($can_edit)): ?>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-md-offset-9 col-md-3">
				<button type="submit" name="save" value="1" class="btn btn-default btn-block">
					<i class="fas fa-save"></i> <?php echo translate('save'); ?>
				</button>
			</div>
		</div>
	</footer>
	<?php endif; ?>
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
