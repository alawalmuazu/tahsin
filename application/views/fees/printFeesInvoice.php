<?php
$extINTL = extension_loaded('intl');
$spellout = null;
if ($extINTL == true) {
	$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
}
$words = function ($amount) use ($extINTL, $spellout) {
	$plain = number_format($amount, 2, '.', '');
	if ($extINTL == true) {
		return ' (' . html_escape(ucwords($spellout->format($plain))) . ')';
	}
	return '';
};
?>
<div class="section-h">Selected Fees</div>
<table class="pay-box">
	<tr>
		<th><?=translate('grand_total')?></th>
		<td><?=currencyFormat($total_amount)?></td>
		<th><?=translate('discount')?></th>
		<td><?=currencyFormat($total_discount)?></td>
	</tr>
	<tr>
		<th><?=translate('paid')?></th>
		<td><?=currencyFormat($total_paid)?></td>
		<th><?=translate('fine')?></th>
		<td><?=currencyFormat($total_fine)?></td>
	</tr>
	<?php if ($total_balance != 0): ?>
	<tr>
		<th><?=translate('total_paid')?> (<?=translate('with_fine')?>)</th>
		<td><?=currencyFormat($total_paid + $total_fine)?></td>
		<th><?=translate('balance')?></th>
		<td class="slip-due"><?=currencyFormat($total_balance) . $words($total_balance)?></td>
	</tr>
	<?php else: ?>
	<tr>
		<th><?=translate('total_paid')?> (<?=translate('with_fine')?>)</th>
		<td colspan="3" class="slip-ok"><?=currencyFormat($total_paid + $total_fine) . $words($total_paid + $total_fine)?></td>
	</tr>
	<?php endif; ?>
</table>
