<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-globe"></i> Online</h4>
	</header>
	<div class="panel-body">
		<p style="margin:0 0 .4rem">
			<?php
			$place = array();
			if (!empty($onlineHome['country'])) {
				$place[] = $onlineHome['country'];
			}
			if (!empty($onlineHome['timezone_label'])) {
				$place[] = $onlineHome['timezone_label'];
			}
			echo !empty($place) ? html_escape(implode(' · ', $place)) : 'Online class';
			?>
		</p>
		<?php if (!empty($onlineHome['quote'])): ?>
		<div class="text-muted"><?php echo html_escape($onlineHome['quote']); ?></div>
		<?php endif; ?>
		<div style="margin:.45rem 0 .2rem">
			<strong>School fee <?php echo $onlineHome['fee'] > 0 ? html_escape(currencyFormat($onlineHome['fee'])) : '—'; ?></strong>
			<span class="text-muted"> · Paid <?php echo html_escape(currencyFormat($onlineHome['paid'])); ?> · Still to pay <?php echo html_escape(currencyFormat($onlineHome['balance'])); ?></span>
		</div>
		<?php if (empty($onlineHome['meetings'])): ?>
		<p style="margin:.8rem 0 0">No class slot yet. It appears here once a teacher adds this child to a group with a meeting link.</p>
		<?php else: ?>
		<?php foreach ($onlineHome['meetings'] as $meet): ?>
		<div style="margin:.85rem 0 .2rem">
			<strong><?php echo html_escape($meet['name']); ?></strong>
			<?php if (!empty($meet['teacher'])): ?> · <?php echo html_escape($meet['teacher']); ?><?php endif; ?>
			<div class="text-muted"><?php echo html_escape($meet['local']); ?><?php if (!empty($meet['lagos'])): ?> · <?php echo html_escape($meet['lagos']); ?><?php endif; ?></div>
			<?php if (!empty($meet['open'])): ?>
			<a class="btn btn-primary" style="margin-top:.45rem" href="<?php echo base_url('userrole/join_class/' . (int) $meet['group_id']); ?>" target="_blank" rel="noopener">Join class</a>
			<?php else: ?>
			<div class="text-muted" style="margin-top:.35rem">Join opens during this slot.</div>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
