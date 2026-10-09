<section class="panel">
	<div class="panel-body" style="padding: 28px 24px;">
		<h3 style="margin-top: 0;">Your mentor</h3>
		<?php if (empty($mentor)): ?>
			<p class="text-muted">A facilitator has not been assigned yet. Ask the office to put you under a mentor.</p>
		<?php else: ?>
			<p>You are assigned under <strong><?php echo html_escape($mentor->name); ?></strong>.</p>
			<ul class="list-unstyled">
				<?php if ($mentor->mobileno !== ''): ?>
					<li><i class="fas fa-phone"></i> <?php echo html_escape($mentor->mobileno); ?></li>
				<?php endif; ?>
				<?php if ($mentor->email !== ''): ?>
					<li><i class="far fa-envelope"></i> <?php echo html_escape($mentor->email); ?></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
