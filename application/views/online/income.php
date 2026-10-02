<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-globe"></i> Online income</h4>
	</header>
	<div class="panel-body">
		<?php $this->load->view('online/_nav'); ?>
		<?php if (empty($ready)): ?>
		<div class="alert alert-warning">Run <code>application/migrations/online_students.sql</code> first.</div>
		<?php elseif (empty($income['students'])): ?>
		<p>No online income in this session yet. This page counts only students who attend online.</p>
		<?php else: ?>
		<p class="text-muted">Collected and still to pay, for online students only. Figures are in naira. The foreign column is the price in the student’s currency.</p>
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-muted">Billed</div>
						<strong><?php echo html_escape(currencyFormat($income['billed'])); ?></strong>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-muted">Collected</div>
						<strong><?php echo html_escape(currencyFormat($income['collected'])); ?></strong>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-muted">Still to pay</div>
						<strong><?php echo html_escape(currencyFormat($income['outstanding'])); ?></strong>
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Currency</th>
						<th>Students</th>
						<th>Foreign amount</th>
						<th>Billed in naira</th>
						<th>Collected</th>
						<th>Still to pay</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($income['by_currency'] as $row): ?>
					<tr>
						<td><?php echo html_escape($row['currency']); ?></td>
						<td><?php echo (int) $row['students']; ?></td>
						<td><?php echo html_escape(number_format($row['foreign'], 2, '.', ',')); ?></td>
						<td><?php echo html_escape(currencyFormat($row['billed'])); ?></td>
						<td><?php echo html_escape(currencyFormat($row['collected'])); ?></td>
						<td><?php echo html_escape(currencyFormat($row['outstanding'])); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php endif; ?>
	</div>
</section>
