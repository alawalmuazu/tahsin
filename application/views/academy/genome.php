<style>
.genome-hub-header{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem}
.genome-hub-header h4{margin:0 0 .25rem;font-weight:700}
.genome-hub-header p{margin:0;color:#64748b;font-size:.9rem}
.genome-kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:.85rem;margin-bottom:1.25rem}
.genome-kpi{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;text-align:center}
.genome-kpi .v{font-size:1.55rem;font-weight:800;line-height:1.1}
.genome-kpi .l{font-size:.68rem;text-transform:uppercase;letter-spacing:.04em;color:#64748b;margin-top:.35rem}
.alert-row{display:flex;gap:.75rem;align-items:center;padding:.65rem 0;border-bottom:1px solid #f1f5f9;flex-wrap:wrap}
.genome-chip{display:inline-block;padding:2px 8px;border-radius:6px;font-size:.7rem;font-weight:600;margin:1px 2px 1px 0;background:#f1f5f9;color:#475569}
.genome-chip-crit{background:rgba(220,38,38,.1);color:#dc2626}
.genome-chip-warn{background:rgba(245,158,11,.12);color:#d97706}
</style>

<div class="genome-hub-header">
	<div>
		<h4><i class="fas fa-dna"></i> Tahsin Genome Intelligence</h4>
		<p>Longitudinal drill trends, predictive alerts, graduation readiness.</p>
	</div>
	<div>
		<a href="<?php echo base_url('academy_students'); ?>" class="btn btn-default btn-sm"><i class="fas fa-user-graduate"></i> Students</a>
		<a href="<?php echo base_url('academy_performance'); ?>" class="btn btn-default btn-sm"><i class="fas fa-stopwatch"></i> Performance</a>
		<a href="<?php echo base_url('academy_broadcast'); ?>" class="btn btn-default btn-sm"><i class="fas fa-broadcast-tower"></i> Broadcast</a>
	</div>
</div>

<div class="genome-kpis">
	<div class="genome-kpi">
		<div class="v" style="color:#0284c7"><?php echo (int) $genome['avg_barakah']; ?></div>
		<div class="l">Cohort Avg Barakah</div>
	</div>
	<div class="genome-kpi">
		<div class="v" style="color:#059669"><?php echo (int) $genome['graduation_candidates']; ?></div>
		<div class="l">Graduation Ready</div>
	</div>
	<div class="genome-kpi">
		<div class="v" style="color:<?php echo count($genome['critical_alerts']) ? '#dc2626' : '#059669'; ?>">
			<?php echo count($genome['critical_alerts']); ?>
		</div>
		<div class="l">Critical Alerts</div>
	</div>
	<div class="genome-kpi">
		<div class="v" style="color:#6366f1"><?php echo count($genome['students']); ?></div>
		<div class="l">Students Tracked</div>
	</div>
</div>

<?php if (!empty($genome['critical_alerts'])): ?>
<section class="panel">
	<header class="panel-heading"><h4 class="panel-title">Predictive Alerts</h4></header>
	<div class="panel-body">
		<?php foreach ($genome['critical_alerts'] as $a): ?>
		<div class="alert-row">
			<span class="label label-<?php echo $a['severity'] === 'critical' ? 'danger' : 'warning'; ?>"><?php echo html_escape($a['type']); ?></span>
			<strong><?php echo html_escape($a['student']); ?></strong>
			<span class="text-muted"><?php echo html_escape($a['message']); ?></span>
			<?php if (!empty($a['student_id'])): ?>
			<a class="btn btn-default btn-xs" href="<?php echo base_url('academy_students'); ?>?log=<?php echo (int) $a['student_id']; ?>">Open Students</a>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<section class="panel">
	<header class="panel-heading"><h4 class="panel-title">Student Genome</h4></header>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-bordered table-condensed table-hover mb-none">
				<thead>
					<tr>
						<th>Student</th>
						<th>Rolling Avg</th>
						<th>Best</th>
						<th>Weakest</th>
						<th>Streak</th>
						<th>Drills</th>
						<th>Barakah</th>
						<th>Alerts</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if (empty($genome['students'])): ?>
					<tr><td colspan="9" class="text-center text-muted">No cohort data yet — log drills first.</td></tr>
					<?php else: foreach ($genome['students'] as $s): ?>
					<tr>
						<td>
							<strong><?php echo html_escape($s['student_name']); ?></strong>
							<?php if (!empty($s['today_goal'])): ?>
							<br><small style="color:#1d4ed8;font-weight:600">🎯 <?php echo html_escape($s['today_goal']); ?></small>
							<?php endif; ?>
						</td>
						<td style="font-weight:700;color:<?php echo $s['rolling_avg'] >= 80 ? '#059669' : ($s['rolling_avg'] >= 50 ? '#d97706' : '#dc2626'); ?>">
							<?php echo (int) $s['rolling_avg']; ?>%
						</td>
						<td><span class="label label-success"><?php echo html_escape($s['best_subject']); ?></span></td>
						<td><span class="label label-warning"><?php echo html_escape($s['weakest_subject']); ?></span></td>
						<td><?php echo $s['streak'] > 0 ? '🔥 ' . (int) $s['streak'] . 'd' : '—'; ?></td>
						<td><?php echo (int) $s['total_drills']; ?></td>
						<td><?php echo (int) $s['barakah']; ?></td>
						<td>
							<?php if (empty($s['alerts'])): ?>
							<span class="text-muted">—</span>
							<?php else: foreach ($s['alerts'] as $al): ?>
							<span class="genome-chip <?php echo (isset($al['severity']) && $al['severity'] === 'critical') ? 'genome-chip-crit' : 'genome-chip-warn'; ?>">
								<?php echo html_escape(isset($al['type']) ? $al['type'] : 'alert'); ?>
							</span>
							<?php endforeach; endif; ?>
						</td>
						<td><?php echo $s['graduation_ready'] ? '<span class="label label-primary">Ready</span>' : '<span class="label label-default">Active</span>'; ?></td>
					</tr>
					<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
