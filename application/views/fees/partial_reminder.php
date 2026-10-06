<?php
$studentCount = 0;
foreach ($groups as $group) {
    $studentCount += count($group['children']);
}
?>
<style>
.fee-remind-card { background:#fff; border:1px solid #e7dcc4; border-radius:12px; padding:14px 14px 12px; margin:0 0 12px; }
.fee-remind-head { display:flex; flex-wrap:wrap; gap:6px 12px; align-items:baseline; margin-bottom:8px; }
.fee-remind-head strong { color:#14532d; font-size:16px; }
.fee-remind-head span { color:#3f6212; font-size:13px; }
.fee-remind-siblings { background:#ecfccb; color:#3f6212; border-radius:999px; padding:2px 8px; }
.fee-remind-kids { list-style:none; margin:0; padding:0; }
.fee-remind-kids li { border-top:1px solid #f3ead8; padding:8px 0; }
.fee-remind-kid-name { font-weight:600; color:#1c1917; }
.fee-remind-kid-name span, .fee-remind-class { color:#78716c; font-size:12px; font-weight:500; }
.fee-remind-amounts { display:flex; flex-wrap:wrap; gap:8px 14px; margin-top:4px; font-size:13px; }
.fee-remind-left { color:#9a3412; font-weight:700; }
.fee-remind-wa { display:inline-flex; align-items:center; gap:8px; margin-top:8px; background:#25D366; color:#fff !important; border-radius:999px; padding:10px 16px; font-weight:700; text-decoration:none !important; min-height:44px; }
.fee-remind-wa:hover { background:#1ebe5d; color:#fff !important; }
.fee-remind-nophone { color:#9a3412; margin:8px 0 0; font-size:13px; }
</style>
<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-bell"></i> Partial payment reminder</h4>
	</header>
	<?php echo form_open(base_url('fees/partial_reminder'), array('class' => 'form-horizontal')); ?>
	<div class="panel-body">
		<?php if (empty($table_ready)): ?>
		<div class="alert alert-warning">Run <code>application/migrations/partial_fee_reminder.sql</code> on the database first.</div>
		<?php endif; ?>
		<p class="text-muted">
			Choose the day the receptionist should remind parents who have paid part of the school fees and still have a balance.
			On that day a popup opens on any page the receptionist is using. It lists every student and the amount left.
			Siblings who share a parent are sent in one WhatsApp message, and the message names each child with their own fees, amount paid, and amount remaining.
		</p>
		<div class="form-group">
			<label class="col-md-3 control-label">Reminder date</label>
			<div class="col-md-4">
				<input type="date" name="remind_on" class="form-control" value="<?php echo html_escape($remind_on); ?>">
				<span class="help-block">
					<?php if ($remind_on !== ''): ?>
					Set for <?php echo html_escape(_d($remind_on)); ?>. Change this date when the next reminder day comes.
					<?php else: ?>
					No date is set, so the receptionist will not see the popup.
					<?php endif; ?>
				</span>
			</div>
		</div>
	</div>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-md-offset-3 col-md-4">
				<button type="submit" name="save_reminder" value="1" class="btn btn-primary">Save date</button>
				<?php if ($remind_on !== ''): ?>
				<button type="submit" name="clear_reminder" value="1" class="btn btn-default">Clear date</button>
				<?php endif; ?>
			</div>
		</div>
	</footer>
	<?php echo form_close(); ?>
</section>

<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title">
			<i class="fab fa-whatsapp"></i>
			Students with a balance
			<?php if ($studentCount > 0): ?>
			<span class="badge"><?php echo (int) $studentCount; ?></span>
			<?php endif; ?>
		</h4>
	</header>
	<div class="panel-body">
		<p class="text-muted">This list is always available here. The popup appears for the receptionist only on the reminder date.</p>
		<?php $this->load->view('fees/_partial_reminder_groups', array('groups' => $groups)); ?>
	</div>
</section>
