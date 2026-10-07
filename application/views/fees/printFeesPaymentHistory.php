<?php
$extINTL = extension_loaded('intl');
$spellout = null;
if ($extINTL == true) {
	$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
}
$grand_paid = $total_paid + $total_fine;
?>
<div class="section-h">Selected Payments</div>
<table class="pay-box">
	<tr>
		<th><?=translate('sub_total')?></th>
		<td><?=currencyFormat($total_paid + $total_discount)?></td>
		<th><?=translate('discount')?></th>
		<td><?=currencyFormat($total_discount)?></td>
	</tr>
	<tr>
		<th><?=translate('paid')?></th>
		<td><?=currencyFormat($total_paid)?></td>
		<th><?=translate('fine')?></th>
		<td><?=currencyFormat($total_fine)?></td>
	</tr>
	<tr>
		<th><?=translate('total_paid')?> (<?=translate('with_fine')?>)</th>
		<td colspan="3" class="slip-ok">
			<?=currencyFormat($grand_paid)?>
			<?php if ($extINTL == true): ?>
				(<?=html_escape(ucwords($spellout->format(number_format($grand_paid, 2, '.', ''))))?>)
			<?php endif; ?>
		</td>
	</tr>
</table>
