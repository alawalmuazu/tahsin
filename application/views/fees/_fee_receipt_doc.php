<?php
$school = $pack['school'];
$logo = FCPATH . 'uploads/app_image/printing-logo.png';
$logo = str_replace('\\', '/', $logo);
?>
<style>
body { font-family: DejaVu Sans, sans-serif; color: #1a1a1a; font-size: 12px; }
.hdr { width: 100%; border-bottom: 3px solid #0f5c4c; margin-bottom: 8px; }
.school { font-size: 20px; color: #0f5c4c; font-weight: bold; margin: 0; }
.motto { font-size: 11px; color: #c9a227; font-style: italic; margin: 2px 0 0; }
.contact { font-size: 10px; color: #555; }
h1 { text-align: center; color: #0f5c4c; font-size: 16px; letter-spacing: 2px; margin: 10px 0 4px; }
.sub { text-align: center; color: #666; font-size: 11px; margin: 0 0 10px; }
.bar { background: #0f5c4c; color: #fff; font-size: 11px; letter-spacing: 1px; padding: 5px 8px; }
table.meta, table.lines { width: 100%; border-collapse: collapse; margin: 0 0 8px; }
table.meta th { width: 28%; text-align: left; background: #f4f7f6; color: #0f5c4c; border: 1px solid #d5ddd9; padding: 5px 8px; }
table.meta td { border: 1px solid #d5ddd9; padding: 5px 8px; }
table.lines th { background: #f8f1d8; color: #5a4708; border: 1px solid #d5ddd9; padding: 6px 8px; text-align: left; }
table.lines td { border: 1px solid #d5ddd9; padding: 6px 8px; }
.paid { color: #0f5c4c; font-weight: bold; }
.due { color: #a94442; font-weight: bold; }
.note { font-size: 9px; color: #666; border-top: 1px dashed #ccc; margin-top: 12px; padding-top: 6px; }
</style>
<table class="hdr">
	<tr>
		<td style="width:80px"><?php if (is_file(FCPATH . 'uploads/app_image/printing-logo.png')): ?><img src="<?php echo $logo; ?>" width="64" alt="Logo"><?php endif; ?></td>
		<td>
			<p class="school"><?php echo htmlspecialchars($school, ENT_QUOTES, 'UTF-8'); ?></p>
			<?php if ($pack['motto'] !== ''): ?><p class="motto"><?php echo htmlspecialchars($pack['motto'], ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
			<div class="contact"><?php echo htmlspecialchars($pack['contact'], ENT_QUOTES, 'UTF-8'); ?></div>
		</td>
	</tr>
</table>
<h1>FEE RECEIPT</h1>
<p class="sub">Invoice No #<?php echo htmlspecialchars($pack['invoice_no'], ENT_QUOTES, 'UTF-8'); ?> · Issued <?php echo htmlspecialchars($pack['issued'], ENT_QUOTES, 'UTF-8'); ?></p>
<div class="bar">STUDENT PARTICULARS</div>
<table class="meta">
	<tr><th>Full Name</th><td><?php echo htmlspecialchars($pack['student'], ENT_QUOTES, 'UTF-8'); ?></td></tr>
	<tr><th>Register No</th><td><?php echo htmlspecialchars($pack['register'], ENT_QUOTES, 'UTF-8'); ?></td></tr>
	<tr><th>Class / Section</th><td><?php echo htmlspecialchars($pack['class_line'], ENT_QUOTES, 'UTF-8'); ?></td></tr>
	<tr><th>Guardian</th><td><?php echo htmlspecialchars($pack['guardian'], ENT_QUOTES, 'UTF-8'); ?></td></tr>
</table>
<div class="bar">PAYMENT</div>
<table class="lines">
	<tr><th>Fee</th><th>Date</th><th>Method</th><th>Paid</th></tr>
	<?php foreach ($pack['rows'] as $row): ?>
	<tr>
		<td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
		<td><?php echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); ?></td>
		<td><?php echo htmlspecialchars($row['method'], ENT_QUOTES, 'UTF-8'); ?></td>
		<td><?php echo htmlspecialchars($row['paid_text'], ENT_QUOTES, 'UTF-8'); ?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<th colspan="3">School fees</th>
		<td><?php echo htmlspecialchars($pack['fee_text'], ENT_QUOTES, 'UTF-8'); ?></td>
	</tr>
	<tr>
		<th colspan="3">Paid on this receipt</th>
		<td class="paid"><?php echo htmlspecialchars($pack['paid_text'], ENT_QUOTES, 'UTF-8'); ?></td>
	</tr>
	<tr>
		<th colspan="3">Remaining</th>
		<td class="<?php echo $pack['balance'] > 0 ? 'due' : 'paid'; ?>"><?php echo htmlspecialchars($pack['balance_text'], ENT_QUOTES, 'UTF-8'); ?></td>
	</tr>
</table>
<p class="note">This receipt is issued by <?php echo htmlspecialchars($school, ENT_QUOTES, 'UTF-8'); ?>. Keep it for your records.</p>
