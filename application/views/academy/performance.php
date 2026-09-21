<style>
.perf-kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:.85rem;margin-bottom:1.25rem}
.perf-kpi{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;text-align:center}
.perf-kpi .v{font-size:1.45rem;font-weight:800;line-height:1.1}
.perf-kpi .l{font-size:.68rem;text-transform:uppercase;color:#64748b;letter-spacing:.04em;margin-top:.35rem}
.perf-hub-header{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1rem}
.perf-hub-header h4{margin:0 0 .25rem;font-weight:700}
.perf-hub-header p{margin:0;color:#64748b;font-size:.9rem}
</style>

<div class="perf-hub-header">
	<div>
		<h4><i class="fas fa-stopwatch"></i> Academy Performance</h4>
		<p>TurboTimer drills across Maths, English, Arabic, Quran, Skills &amp; Core.</p>
	</div>
	<div>
		<a href="<?php echo base_url('academy_students'); ?>" class="btn btn-default btn-sm"><i class="fas fa-user-graduate"></i> Students</a>
		<a href="<?php echo base_url('academy_genome'); ?>" class="btn btn-default btn-sm"><i class="fas fa-dna"></i> Genome</a>
		<a href="<?php echo base_url('academy_broadcast'); ?>" class="btn btn-default btn-sm"><i class="fas fa-broadcast-tower"></i> Broadcast</a>
	</div>
</div>

<?php $pk = isset($perf_kpis) ? $perf_kpis : array(); ?>
<div class="perf-kpis">
	<div class="perf-kpi"><div class="v" style="color:#0284c7"><?php echo (int) (isset($pk['today_drills']) ? $pk['today_drills'] : 0); ?></div><div class="l">Today's Drills</div></div>
	<div class="perf-kpi"><div class="v" style="color:#059669"><?php echo (int) (isset($pk['unique_students']) ? $pk['unique_students'] : 0); ?></div><div class="l">Students Drilled</div></div>
	<div class="perf-kpi"><div class="v" style="color:#d97706"><?php echo isset($pk['avg_spp']) && $pk['avg_spp'] !== null ? html_escape($pk['avg_spp']) . 's' : '—'; ?></div><div class="l">Avg SPP</div></div>
	<div class="perf-kpi"><div class="v" style="color:#6366f1"><?php echo isset($pk['avg_pct']) && $pk['avg_pct'] !== null ? (int) $pk['avg_pct'] . '%' : '—'; ?></div><div class="l">Avg Score %</div></div>
	<div class="perf-kpi"><div class="v" style="color:#0f766e;font-size:1.1rem"><?php echo html_escape(isset($pk['best_pillar']) ? $pk['best_pillar'] : '—'); ?></div><div class="l">Top Pillar Today</div></div>
</div>

<div class="row">
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-stopwatch"></i> TurboTimer — Log Drill</h4>
			</header>
			<?php echo form_open(base_url('academy_performance')); ?>
			<div class="panel-body">
				<?php if (!$ready): ?>
				<div class="alert alert-warning">Run <code>application/migrations/academy_engine.sql</code> first.</div>
				<?php endif; ?>
				<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

				<div class="form-group">
					<label class="control-label">Student <span class="required">*</span></label>
					<select name="student_id" class="form-control" required <?php echo !$ready ? 'disabled' : ''; ?>>
						<option value="">Select student</option>
						<?php foreach ($students as $st): ?>
						<option value="<?php echo (int) $st->id; ?>" <?php echo set_select('student_id', $st->id); ?>>
							<?php echo html_escape($st->fullname . ' — ' . $st->register_no); ?>
							<?php if (!empty($st->section_name)): ?> (<?php echo html_escape($st->section_name); ?>)<?php endif; ?>
						</option>
						<?php endforeach; ?>
					</select>
					<?php if (empty($students)): ?>
					<p class="help-block text-muted">No enrolled students in this session yet.</p>
					<?php endif; ?>
				</div>

				<div class="form-group">
					<label class="control-label">Subject pillar <span class="required">*</span></label>
					<select name="pillar" id="drill_pillar" class="form-control" required <?php echo !$ready ? 'disabled' : ''; ?>>
						<?php foreach ($pillars as $key => $label): ?>
						<option value="<?php echo html_escape($key); ?>" <?php echo set_select('pillar', $key, $key === 'MATH'); ?>><?php echo html_escape($label); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label class="control-label">Sub-category</label>
					<select name="sub_category" id="drill_sub" class="form-control" <?php echo !$ready ? 'disabled' : ''; ?>></select>
				</div>

				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Score <span class="required">*</span></label>
							<input type="number" name="score" id="drill_score" class="form-control" min="0" value="<?php echo set_value('score', 0); ?>" required <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Out of <span class="required">*</span></label>
							<input type="number" name="total_possible" class="form-control" min="1" value="<?php echo set_value('total_possible', 20); ?>" required <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Time (sec) <span class="required">*</span></label>
							<input type="number" name="time_seconds" id="drill_time" class="form-control" min="0" value="<?php echo set_value('time_seconds', 0); ?>" required <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Live timer</label>
					<div class="well well-sm mb-sm" style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
						<strong id="timer_display" style="font-size:1.6rem;font-variant-numeric:tabular-nums;">00:00</strong>
						<span>
							<button type="button" class="btn btn-success btn-xs" id="timer_start"><i class="fas fa-play"></i></button>
							<button type="button" class="btn btn-warning btn-xs" id="timer_pause"><i class="fas fa-pause"></i></button>
							<button type="button" class="btn btn-default btn-xs" id="timer_reset"><i class="fas fa-undo"></i></button>
						</span>
					</div>
					<p class="help-block">SPP = time ÷ score (lower is better cognitive friction).</p>
				</div>

				<div class="form-group">
					<label class="control-label">Notes</label>
					<textarea name="notes" class="form-control" rows="2" <?php echo !$ready ? 'disabled' : ''; ?>><?php echo set_value('notes'); ?></textarea>
				</div>
			</div>
			<footer class="panel-footer">
				<button type="submit" name="save_drill" value="1" class="btn btn-default pull-right" <?php echo !$ready ? 'disabled' : ''; ?>>
					<i class="fas fa-save"></i> Save drill
				</button>
			</footer>
			<?php echo form_close(); ?>
		</section>
	</div>

	<div class="col-md-7">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-bolt"></i> Today's drills</h4>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed mb-none table-hover">
						<thead>
							<tr>
								<th>Student</th>
								<th>Pillar</th>
								<th>Score</th>
								<th>Time</th>
								<th>SPP</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($todays)): ?>
							<tr><td colspan="6" class="text-center text-muted">No drills logged today.</td></tr>
							<?php else: foreach ($todays as $row): ?>
							<tr>
								<td>
									<?php echo html_escape($row->student_name); ?>
									<br><small class="text-muted"><?php echo html_escape($row->register_no); ?></small>
								</td>
								<td>
									<span class="label label-primary"><?php echo html_escape($row->pillar); ?></span>
									<?php if ($row->sub_category): ?><br><small><?php echo html_escape($row->sub_category); ?></small><?php endif; ?>
								</td>
								<td><?php echo (int) $row->score; ?>/<?php echo (int) $row->total_possible; ?></td>
								<td><?php echo (int) $row->time_seconds; ?>s</td>
								<td><strong><?php echo number_format((float) $row->spp_metric, 2); ?></strong></td>
								<td>
									<?php if (get_permission('academy_performance', 'is_delete') || is_superadmin_loggedin()): ?>
									<a href="<?php echo base_url('academy_performance/delete/' . (int) $row->id); ?>" class="btn btn-danger btn-circle btn-xs academy-confirm-delete" data-confirm="Delete this drill?"><i class="fas fa-trash-alt"></i></a>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>

		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-history"></i> Recent drills</h4>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed mb-none">
						<thead>
							<tr>
								<th>When</th>
								<th>Student</th>
								<th>Pillar</th>
								<th>SPP</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($recent)): ?>
							<tr><td colspan="4" class="text-center text-muted">No history yet.</td></tr>
							<?php else: foreach ($recent as $row): ?>
							<tr>
								<td><small><?php echo html_escape(date('M j, Y · g:i A', strtotime($row->created_at))); ?></small></td>
								<td><?php echo html_escape($row->student_name); ?></td>
								<td><?php echo html_escape($row->pillar); ?><?php if ($row->sub_category): ?> / <?php echo html_escape($row->sub_category); ?><?php endif; ?></td>
								<td><?php echo number_format((float) $row->spp_metric, 2); ?></td>
							</tr>
							<?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>

<script>
(function () {
	var map = <?php echo json_encode($sub_categories); ?>;
	var pillarEl = document.getElementById('drill_pillar');
	var subEl = document.getElementById('drill_sub');
	function fillSubs() {
		var key = pillarEl.value;
		var list = map[key] || [];
		subEl.innerHTML = '';
		list.forEach(function (name) {
			var opt = document.createElement('option');
			opt.value = name;
			opt.textContent = name;
			subEl.appendChild(opt);
		});
	}
	pillarEl.addEventListener('change', fillSubs);
	fillSubs();

	var seconds = 0, ticking = false, timer = null;
	var display = document.getElementById('timer_display');
	var timeInput = document.getElementById('drill_time');
	function fmt(s) {
		var m = Math.floor(s / 60), r = s % 60;
		return (m < 10 ? '0' : '') + m + ':' + (r < 10 ? '0' : '') + r;
	}
	function tick() {
		seconds++;
		display.textContent = fmt(seconds);
		timeInput.value = seconds;
	}
	document.getElementById('timer_start').addEventListener('click', function () {
		if (ticking) return;
		ticking = true;
		timer = setInterval(tick, 1000);
	});
	document.getElementById('timer_pause').addEventListener('click', function () {
		ticking = false;
		if (timer) clearInterval(timer);
	});
	document.getElementById('timer_reset').addEventListener('click', function () {
		ticking = false;
		if (timer) clearInterval(timer);
		seconds = 0;
		display.textContent = '00:00';
		timeInput.value = 0;
	});
})();
</script>
