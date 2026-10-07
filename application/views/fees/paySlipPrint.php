<style type="text/css">
.slip-copy { border:1px solid #d5ddd9; padding:8px; color:#1a1a1a; background:#fff; }
.slip-copy h4 { margin:0 0 6px; text-align:center; font-size:12px; letter-spacing:1px; text-transform:uppercase; color:#0f5c4c; }
.slip-copy .school { text-align:center; color:#0f5c4c; font-weight:bold; font-size:13px; margin:0; }
.slip-copy .meta { font-size:10px; color:#555; text-align:center; margin:2px 0 8px; }
.slip-copy table { width:100%; border-collapse:collapse; font-size:11px; margin:0 0 6px; }
.slip-copy table th, .slip-copy table td { border:1px solid #d5ddd9; padding:4px 6px; }
.slip-copy table.who th { width:38%; text-align:left; background:#f4f7f6; color:#0f5c4c; }
.slip-copy table.lines thead th { background:#f8f1d8; color:#5a4708; }
.slip-copy .total { background:#0f5c4c; color:#fff; font-weight:bold; }
.slip-copy .when { font-size:9px; color:#666; text-align:center; margin:6px 0 0; }
</style>
<?php
$record_array = json_decode($record);
$basic = $this->fees_model->getInvoiceBasic($studentID);
if (!empty($basic['class_name']) && !empty($basic['section_name'])) {
	$classLine = $basic['class_name'] . ' (' . $basic['section_name'] . ')';
} elseif (!empty($basic['class_name'])) {
	$classLine = $basic['class_name'];
} else {
	$classLine = $basic['section_name'];
}
$this->db->where_in('id', array_column($record_array, 'payment_id'));
$paymentHistory = $this->db->get('fee_payment_history')->result();
$copies = array('Student Copy', 'Bank Copy', 'Office Copy');
?>
<div class="row">
<?php foreach ($copies as $copyName) { ?>
	<div class="col-xs-4">
		<div class="slip-copy">
			<h4><?php echo $copyName; ?></h4>
			<p class="school"><?php echo html_escape($basic['school_name']); ?></p>
			<p class="meta">
				<?php echo html_escape($basic['school_address']); ?><br>
				<?php echo html_escape($basic['school_mobileno']); ?> · <?php echo html_escape($basic['school_email']); ?>
			</p>
			<table class="who">
				<tr><th><?php echo translate('date'); ?></th><td><?php echo html_escape(_d(date('Y-m-d'))); ?></td></tr>
				<tr><th><?php echo translate('student_name'); ?></th><td><?php echo html_escape(trim($basic['first_name'] . ' ' . $basic['last_name'])); ?></td></tr>
				<tr><th><?php echo translate('register_no'); ?></th><td><?php echo html_escape($basic['register_no']); ?></td></tr>
				<tr><th><?php echo translate('class'); ?></th><td><?php echo html_escape($classLine); ?></td></tr>
				<tr><th><?php echo translate('father_name'); ?></th><td><?php echo html_escape($basic['father_name']); ?></td></tr>
			</table>
			<table class="lines">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo translate('fees_type'); ?></th>
						<th><?php echo translate('amount'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$count = 1;
				$total_fine = 0;
				$total_discount = 0;
				$total_paid = 0;
				foreach ($paymentHistory as $row) {
					$paid = $row->amount;
					$discount = $row->discount;
					$fine = $row->fine;
					$total_paid += $paid;
					$total_discount += $discount;
					$total_fine += $fine;
					if (empty($row->transport_fee_details_id)) {
						$feeName = get_type_name_by_id('fees_type', $row->type_id);
					} else {
						$month = get_type_name_by_id('transport_fee_details', $row->transport_fee_details_id, 'month');
						$month = $this->app_lib->getMonthslist($month);
						$feeName = translate('transport_fees') . ' - ' . $month;
					}
				?>
					<tr>
						<td><?php echo $count++; ?></td>
						<td><?php echo html_escape($feeName); ?></td>
						<td><?php echo currencyFormat($paid); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<table class="lines">
				<tr><th><?php echo translate('sub_total'); ?></th><td><?php echo currencyFormat($total_paid + $total_discount); ?></td></tr>
				<tr><th><?php echo translate('discount'); ?></th><td><?php echo currencyFormat($total_discount); ?></td></tr>
				<tr><th><?php echo translate('paid'); ?></th><td><?php echo currencyFormat($total_paid); ?></td></tr>
				<tr><th><?php echo translate('fine'); ?></th><td><?php echo currencyFormat($total_fine); ?></td></tr>
				<tr class="total"><th><?php echo translate('total_paid'); ?> (<?php echo translate('with_fine'); ?>)</th><td><?php echo currencyFormat($total_paid + $total_fine); ?></td></tr>
			</table>
			<p class="when">Generated at <?php echo html_escape(_d(date('Y-m-d')) . ', ' . date('h:i A')); ?></p>
		</div>
	</div>
<?php } ?>
</div>
