<style>
.academy-hub-header{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem}
.academy-hub-header h4{margin:0 0 .25rem;font-weight:700}
.academy-hub-header p{margin:0;color:#64748b;font-size:.9rem}
.academy-section-label{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#64748b;margin:1.25rem 0 .75rem;display:flex;justify-content:space-between;align-items:center;gap:.5rem;flex-wrap:wrap}
.academy-tip{color:#0284c7;font-weight:600;font-size:.75rem}
.academy-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem;margin-bottom:1.5rem}
.academy-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;cursor:pointer;transition:box-shadow .2s,transform .2s;position:relative}
.academy-card:hover{box-shadow:0 8px 24px rgba(15,23,42,.08);transform:translateY(-2px);border-color:#94a3b8}
.academy-card-top{display:flex;gap:.75rem;align-items:center;margin-bottom:.75rem}
.academy-avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#0284c7,#0369a1);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;flex-shrink:0;overflow:hidden}
.academy-avatar img{width:100%;height:100%;object-fit:cover;display:block}
.academy-card-name{font-weight:700;font-size:.95rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.academy-card-meta{font-size:.75rem;color:#64748b}
.academy-card-surah{font-size:.72rem;color:#0284c7;font-weight:600;margin-top:2px}
.academy-ring-wrap{display:flex;justify-content:center;margin:.5rem 0 .75rem;position:relative}
.academy-ring-value{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none}
.academy-ring-num{font-size:1.15rem;font-weight:800;line-height:1}
.academy-ring-lbl{font-size:.65rem;color:#64748b;text-transform:uppercase;letter-spacing:.03em}
.academy-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:.25rem;text-align:center;border-top:1px solid #f1f5f9;padding-top:.65rem}
.academy-stat-v{font-weight:700;font-size:.9rem}
.academy-stat-l{font-size:.65rem;color:#94a3b8;text-transform:uppercase}
.academy-stat-streak .academy-stat-v{color:#ea580c}
.academy-stat-streak .academy-stat-l{color:#c2410c;font-weight:600}
.academy-filters{display:flex;gap:.75rem;flex-wrap:wrap;align-items:center;margin-bottom:1rem}
.academy-filters input,.academy-filters select{max-width:280px}
.academy-badge{display:inline-block;padding:2px 8px;border-radius:6px;font-size:.72rem;font-weight:600;background:#f1f5f9;color:#334155}
.academy-badge-ok{background:rgba(16,185,129,.12);color:#059669}
.academy-badge-surah{background:rgba(245,158,11,.12);color:#d97706;margin-left:4px}
.academy-kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:.85rem;margin:0 0 1.25rem}
.academy-kpi{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;text-align:center}
.academy-kpi .v{font-size:1.55rem;font-weight:800;line-height:1.1}
.academy-kpi .l{font-size:.68rem;text-transform:uppercase;color:#64748b;letter-spacing:.04em;margin-top:.35rem}
.academy-period-tabs{display:inline-flex;gap:.35rem;flex-wrap:wrap}
.academy-period-tabs button{border:1px solid #e2e8f0;background:#fff;color:#64748b;border-radius:9999px;padding:4px 12px;font-size:.72rem;font-weight:700;cursor:pointer}
.academy-period-tabs button.active{background:#0284c7;border-color:#0284c7;color:#fff}
.academy-p1-row{display:grid;grid-template-columns:1.4fr 1fr;gap:1rem;margin-bottom:1.5rem}
@media (max-width:900px){.academy-p1-row{grid-template-columns:1fr}}
.academy-lb-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem}
.academy-lb-head{display:flex;justify-content:space-between;align-items:center;gap:.5rem;flex-wrap:wrap;margin-bottom:.75rem}
.academy-lb-head h5{margin:0;font-weight:700;font-size:.95rem}
.academy-lb-tabs{display:inline-flex;gap:.3rem}
.academy-lb-tabs button{border:1px solid #e2e8f0;background:#f8fafc;color:#64748b;border-radius:8px;padding:4px 10px;font-size:.7rem;font-weight:700;cursor:pointer}
.academy-lb-tabs button.active{background:#0f172a;border-color:#0f172a;color:#fff}
.academy-lb-list{list-style:none;margin:0;padding:0}
.academy-lb-list li{display:flex;align-items:center;gap:.65rem;padding:.55rem 0;border-top:1px solid #f1f5f9}
.academy-lb-list li:first-child{border-top:0;padding-top:0}
.academy-lb-rank{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;background:#f1f5f9;color:#475569;flex-shrink:0}
.academy-lb-rank.gold{background:#fef3c7;color:#b45309}
.academy-lb-rank.silver{background:#e2e8f0;color:#475569}
.academy-lb-rank.bronze{background:#ffedd5;color:#c2410c}
.academy-lb-meta{min-width:0;flex:1}
.academy-lb-name{font-weight:700;font-size:.88rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.academy-lb-sub{font-size:.7rem;color:#94a3b8}
.academy-lb-score{font-weight:800;font-size:.85rem;color:#0284c7;white-space:nowrap}
.academy-card-goal{margin-top:.65rem;padding:.45rem .55rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;font-size:.72rem;font-weight:700;line-height:1.3}
.academy-card-goal span{font-weight:600;color:#64748b}
.academy-hub-header .btn{display:inline-flex;align-items:center;gap:.4rem}
.academy-hub-ico{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:1.75;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
</style>

<div class="academy-hub-header">
	<div>
		<h4 style="display:flex;align-items:center;gap:.45rem"><svg class="academy-hub-ico" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg> TAHSIN Academy Students</h4>
		<p>Enrolled cohort roster, Quranic Barakah metrics, and halaqah participation.</p>
	</div>
	<div>
		<?php if (get_permission('student', 'is_add') || is_superadmin_loggedin()): ?>
		<a href="<?php echo base_url('student/add'); ?>" class="btn btn-default">
			<svg class="academy-hub-ico" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg> Enroll Student
		</a>
		<?php endif; ?>
		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#academyVoiceModal">
			<svg class="academy-hub-ico" viewBox="0 0 24 24"><rect x="9" y="2" width="6" height="11" rx="3"/><path d="M5 11a7 7 0 0 0 14 0"/><path d="M12 18v3"/><path d="M8 21h8"/></svg> Voice Logger
		</button>
		<a href="<?php echo base_url('academy_performance'); ?>" class="btn btn-default">
			<svg class="academy-hub-ico" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Performance
		</a>
		<a href="<?php echo base_url('tahfiz'); ?>" class="btn btn-default">
			<svg class="academy-hub-ico" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg> Tahfiz
		</a>
		<a href="<?php echo base_url('academy_genome'); ?>" class="btn btn-default">
			<svg class="academy-hub-ico" viewBox="0 0 24 24"><circle cx="6" cy="6" r="2"/><circle cx="18" cy="6" r="2"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/><path d="M8 6h8M6 8v8M18 8v8M8 18h8"/></svg> Genome
		</a>
		<a href="<?php echo base_url('academy_broadcast'); ?>" class="btn btn-default">
			<svg class="academy-hub-ico" viewBox="0 0 24 24"><circle cx="12" cy="12" r="2"/><path d="M16.24 7.76a6 6 0 0 1 0 8.49M7.76 16.24a6 6 0 0 1 0-8.49M19.07 4.93a10 10 0 0 1 0 14.14M4.93 19.07a10 10 0 0 1 0-14.14"/></svg> Broadcast
		</a>
	</div>
</div>

<?php if (!$ready): ?>
<div class="alert alert-warning">Run <code>application/migrations/academy_engine.sql</code> to enable Tahfiz / Performance metrics.</div>
<?php endif; ?>

<?php if (!empty($roster)):
	$kpiDay = isset($activity_kpis['day']) ? $activity_kpis['day'] : array();
?>
<div class="academy-section-label">
	<span>Cohort Activity</span>
	<div class="academy-period-tabs" id="academy_period_tabs" role="tablist">
		<button type="button" class="active" data-period="day">Day</button>
		<button type="button" data-period="week">Week</button>
		<button type="button" data-period="month">Month</button>
		<button type="button" data-period="all">Lifetime</button>
	</div>
</div>
<div class="academy-p1-row">
	<div>
		<div class="academy-kpis" id="academy_activity_kpis">
			<div class="academy-kpi">
				<div class="v" style="color:#0284c7" data-kpi="engagement"><?php echo html_escape(isset($kpiDay['engagement_label']) ? $kpiDay['engagement_label'] : '0s'); ?></div>
				<div class="l">Engagement Time</div>
			</div>
			<div class="academy-kpi">
				<div class="v" style="color:#059669" data-kpi="verses"><?php echo (int) (isset($kpiDay['verses']) ? $kpiDay['verses'] : 0); ?></div>
				<div class="l">Verses Logged</div>
			</div>
			<div class="academy-kpi">
				<div class="v" style="color:#d97706" data-kpi="sessions"><?php echo (int) (isset($kpiDay['sessions']) ? $kpiDay['sessions'] : 0); ?></div>
				<div class="l">Sessions</div>
			</div>
			<div class="academy-kpi">
				<div class="v" style="color:#6366f1" data-kpi="accuracy"><?php echo isset($kpiDay['avg_accuracy']) && $kpiDay['avg_accuracy'] !== null ? html_escape($kpiDay['avg_accuracy']) . '%' : '—'; ?></div>
				<div class="l">Avg Accuracy</div>
			</div>
			<div class="academy-kpi">
				<div class="v" style="color:#0f172a" data-kpi="completion"><?php echo (int) (isset($kpiDay['completion_pct']) ? $kpiDay['completion_pct'] : 0); ?>%</div>
				<div class="l">Cohort Active</div>
			</div>
		</div>
	</div>
	<div class="academy-lb-card">
		<div class="academy-lb-head">
			<h5>🏆 Leaderboard</h5>
			<div class="academy-lb-tabs" id="academy_lb_tabs">
				<button type="button" class="active" data-lb="engagement">Engagement</button>
				<button type="button" data-lb="completions">Completions</button>
			</div>
		</div>
		<ul class="academy-lb-list" id="academy_lb_list">
			<?php
			$lbRows = isset($leaderboard['engagement']) ? $leaderboard['engagement'] : array();
			if (empty($lbRows)): ?>
			<li class="text-muted" style="justify-content:center;padding:.75rem 0">No rankings yet — log a recitation.</li>
			<?php else:
				foreach ($lbRows as $row):
					$rankClass = $row['rank'] === 1 ? 'gold' : ($row['rank'] === 2 ? 'silver' : ($row['rank'] === 3 ? 'bronze' : ''));
			?>
			<li>
				<div class="academy-lb-rank <?php echo $rankClass; ?>"><?php echo (int) $row['rank']; ?></div>
				<div class="academy-lb-meta">
					<div class="academy-lb-name"><?php echo html_escape($row['name']); ?></div>
					<div class="academy-lb-sub"><?php echo html_escape($row['class_level']); ?><?php if (!empty($row['today_goal'])): ?> · 🎯 <?php echo html_escape($row['today_goal']); ?><?php endif; ?></div>
				</div>
				<div class="academy-lb-score"><?php echo html_escape($row['score_label']); ?></div>
			</li>
			<?php endforeach; endif; ?>
		</ul>
	</div>
</div>
<?php endif; ?>

<?php if (!empty($featured)): ?>
<div class="academy-section-label">
	<span>Most Recently Active Cohort Profiles (<?php echo count($featured); ?> of <?php echo count($roster); ?>)</span>
	<span class="academy-tip">Click any student card to log completed recitation</span>
</div>
<div class="academy-cards">
	<?php foreach ($featured as $st):
		$initials = '';
		$parts = preg_split('/\s+/', trim($st['fullname']));
		foreach (array_slice($parts, 0, 2) as $p) {
			$initials .= strtoupper(substr($p, 0, 1));
		}
		$b = (int) $st['barakah'];
		$ringColor = $b >= 80 ? '#10b981' : ($b >= 50 ? '#f59e0b' : '#38bdf8');
		$r = 36;
		$c = 2 * M_PI * $r;
		$offset = $c - ($b / 100) * $c;
	?>
	<div class="academy-card" role="button" tabindex="0"
		data-student-id="<?php echo (int) $st['id']; ?>"
		data-student-name="<?php echo html_escape($st['fullname']); ?>"
		onclick="academyOpenLog(this)">
		<div class="academy-card-top">
			<div class="academy-avatar"><?php if (!empty($st['has_photo'])): ?><img src="<?php echo html_escape($st['photo_url']); ?>" alt=""><?php else: echo html_escape($initials ?: '?'); endif; ?></div>
			<div style="min-width:0;flex:1">
				<div class="academy-card-name"><?php echo html_escape($st['fullname']); ?>
					<?php if (!empty($st['media_consent'])): ?>
					<span title="Media consent granted" style="font-size:.8rem">📷</span>
					<?php endif; ?>
				</div>
				<div class="academy-card-meta">
					<?php echo html_escape($st['class_level']); ?>
					<?php if ($st['age_group']): ?> · <?php echo html_escape($st['age_group']); ?><?php endif; ?>
				</div>
				<?php if (!empty($st['latest_milestone'])): ?>
				<div class="academy-card-surah">📖 <?php echo html_escape($st['latest_milestone']); ?></div>
				<?php elseif ($st['latest_surah']): ?>
				<div class="academy-card-surah">📖 <?php echo html_escape($st['latest_surah']); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="academy-ring-wrap">
			<svg width="88" height="88" viewBox="0 0 88 88" aria-hidden="true">
				<circle cx="44" cy="44" r="<?php echo $r; ?>" fill="none" stroke="#e2e8f0" stroke-width="6"/>
				<circle cx="44" cy="44" r="<?php echo $r; ?>" fill="none"
					stroke="<?php echo $ringColor; ?>" stroke-width="6" stroke-linecap="round"
					stroke-dasharray="<?php echo $c; ?>" stroke-dashoffset="<?php echo $offset; ?>"
					transform="rotate(-90 44 44)"/>
			</svg>
			<div class="academy-ring-value">
				<span class="academy-ring-num" style="color:<?php echo $ringColor; ?>"><?php echo $b; ?></span>
				<span class="academy-ring-lbl">Barakah</span>
			</div>
		</div>
		<div class="academy-stats">
			<div>
				<div class="academy-stat-v"><?php echo (int) $st['tahfiz_count']; ?></div>
				<div class="academy-stat-l">Logs</div>
			</div>
			<div>
				<div class="academy-stat-v"><?php echo (int) $st['surahs_count']; ?></div>
				<div class="academy-stat-l">Surahs</div>
			</div>
			<div>
				<div class="academy-stat-v"><?php echo (int) $st['drills_count']; ?></div>
				<div class="academy-stat-l">Drills</div>
			</div>
			<div class="academy-stat-streak">
				<div class="academy-stat-v"><?php echo $st['streak'] > 0 ? '🔥 ' . (int) $st['streak'] : '—'; ?></div>
				<div class="academy-stat-l"><?php echo $st['streak'] === 1 ? 'Day streak' : 'Day streak'; ?></div>
			</div>
		</div>
		<?php if (!empty($st['today_goal'])): ?>
		<div class="academy-card-goal">🎯 Today: <?php echo html_escape($st['today_goal']); ?></div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
</div>
<?php elseif (empty($roster)): ?>
<section class="panel">
	<div class="panel-body text-center text-muted">
		<p>No enrolled students in this session yet.</p>
		<?php if (get_permission('student', 'is_add') || is_superadmin_loggedin()): ?>
		<a href="<?php echo base_url('student/add'); ?>" class="btn btn-default"><i class="fas fa-user-plus"></i> Enroll first student</a>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if (!empty($roster)): ?>
<div class="academy-section-label">
	<span>Full Enrolled Student Ledger (<?php echo count($roster); ?> Total Enrolled)</span>
</div>
<section class="panel">
	<div class="panel-body">
		<div class="academy-filters">
			<input type="text" id="academy_search" class="form-control" placeholder="Search by name, class, surah, parent…">
			<select id="academy_class_filter" class="form-control">
				<option value="ALL">All Classes</option>
				<?php
				$classes = array();
				foreach ($roster as $r) {
					if (!empty($r['class_name'])) {
						$classes[$r['class_name']] = true;
					}
				}
				ksort($classes);
				foreach (array_keys($classes) as $cn): ?>
				<option value="<?php echo html_escape($cn); ?>"><?php echo html_escape($cn); ?></option>
				<?php endforeach; ?>
			</select>
			<select id="academy_sort" class="form-control">
				<option value="activity">Sort: Most Recently Active</option>
				<option value="surahs">Sort: Most Surahs</option>
				<option value="name">Sort: Name (A–Z)</option>
				<option value="enrolled">Sort: Enrollment Date</option>
			</select>
			<span class="text-muted" id="academy_count_label">Showing <?php echo count($roster); ?> of <?php echo count($roster); ?></span>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-condensed table-hover mb-none" id="academy_ledger">
				<thead>
					<tr>
						<th>Student</th>
						<th>Class</th>
						<th>Parent Contact</th>
						<th>Last Active / Enrolled</th>
						<th>Barakah</th>
						<th>Tahfiz Progress</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($roster as $st):
						$initials = '';
						$parts = preg_split('/\s+/', trim($st['fullname']));
						foreach (array_slice($parts, 0, 2) as $p) {
							$initials .= strtoupper(substr($p, 0, 1));
						}
						$searchBlob = strtolower($st['fullname'] . ' ' . $st['class_level'] . ' ' . $st['parent_contact'] . ' ' . $st['latest_surah'] . ' ' . $st['register_no']);
					?>
					<tr data-search="<?php echo html_escape($searchBlob); ?>"
						data-class="<?php echo html_escape($st['class_name'] ? $st['class_name'] : ''); ?>"
						data-activity="<?php echo (int) $st['last_active_at']; ?>"
						data-surahs="<?php echo (int) $st['surahs_count']; ?>"
						data-name="<?php echo html_escape(strtolower($st['fullname'])); ?>"
						data-enrolled="<?php echo !empty($st['admission_date']) ? strtotime($st['admission_date']) : 0; ?>">
						<td>
							<div style="display:flex;align-items:center;gap:.65rem">
								<div class="academy-avatar" style="width:32px;height:32px;font-size:.7rem"><?php if (!empty($st['has_photo'])): ?><img src="<?php echo html_escape($st['photo_url']); ?>" alt=""><?php else: echo html_escape($initials ?: '?'); endif; ?></div>
								<div>
									<strong><?php echo html_escape($st['fullname']); ?></strong>
									<?php if (!empty($st['media_consent'])): ?>
									<span class="academy-badge academy-badge-ok" title="Media consent">📷 Media</span>
									<?php endif; ?>
									<br><small class="text-muted"><?php echo html_escape($st['register_no']); ?><?php if ($st['age_group']): ?> · Age <?php echo html_escape($st['age_group']); ?><?php endif; ?></small>
								</div>
							</div>
						</td>
						<td><span class="academy-badge"><?php echo html_escape($st['class_level']); ?></span></td>
						<td>
							<?php echo html_escape($st['parent_contact'] ? $st['parent_contact'] : 'N/A'); ?>
							<?php if ($st['parent_name']): ?><br><small class="text-muted"><?php echo html_escape($st['parent_name']); ?></small><?php endif; ?>
						</td>
						<td>
							<small><?php echo $st['last_active'] ? html_escape(date('M j, Y · g:i A', strtotime($st['last_active']))) : '—'; ?></small>
							<?php if ($st['admission_date']): ?>
							<br><small class="text-muted">Enrolled <?php echo html_escape(date('d M Y', strtotime($st['admission_date']))); ?></small>
							<?php endif; ?>
						</td>
						<td>
							<strong style="color:<?php echo $st['barakah'] >= 80 ? '#059669' : ($st['barakah'] >= 50 ? '#d97706' : '#0284c7'); ?>">
								<?php echo (int) $st['barakah']; ?>
							</strong>
							<small class="text-muted">/100</small>
						</td>
						<td>
							<span class="academy-badge <?php echo $st['tahfiz_count'] > 0 ? 'academy-badge-ok' : ''; ?>">
								<?php echo (int) $st['tahfiz_count']; ?> log<?php echo $st['tahfiz_count'] == 1 ? '' : 's'; ?>
							</span>
							<span class="academy-badge">
								<?php echo (int) $st['surahs_count']; ?> Surah<?php echo $st['surahs_count'] == 1 ? '' : 's'; ?>
							</span>
							<?php if (!empty($st['latest_milestone'])): ?>
							<span class="academy-badge academy-badge-surah">📖 <?php echo html_escape($st['latest_milestone']); ?></span>
							<?php elseif ($st['latest_surah']): ?>
							<span class="academy-badge academy-badge-surah">📖 <?php echo html_escape($st['latest_surah']); ?></span>
							<?php endif; ?>
							<?php if (!empty($st['today_goal'])): ?>
							<br><small style="color:#1d4ed8;font-weight:600">🎯 Today: <?php echo html_escape($st['today_goal']); ?></small>
							<?php endif; ?>
							<?php if (isset($st['avg_accuracy']) && $st['avg_accuracy'] !== null): ?>
							<br><small class="text-muted">Avg accuracy <?php echo html_escape($st['avg_accuracy']); ?>%</small>
							<?php endif; ?>
						</td>
						<td class="text-right">
							<?php if (!empty($has_media_consent)): ?>
							<?php echo form_open(base_url('academy_students'), array('style' => 'display:inline')); ?>
							<input type="hidden" name="student_id" value="<?php echo (int) $st['id']; ?>">
							<input type="hidden" name="media_consent" value="<?php echo $st['media_consent'] ? 0 : 1; ?>">
							<button type="submit" name="toggle_media_consent" value="1" class="btn btn-default btn-xs" title="Toggle media consent">
								<?php echo $st['media_consent'] ? '📷' : '🚫'; ?>
							</button>
							<?php echo form_close(); ?>
							<?php endif; ?>
							<button type="button" class="btn btn-default btn-xs"
								data-student-id="<?php echo (int) $st['id']; ?>"
								data-student-name="<?php echo html_escape($st['fullname']); ?>"
								onclick="academyOpenLog(this)">
								<i class="fas fa-book-open"></i> Log
							</button>
							<a href="<?php echo base_url('student/profile/' . (int) $st['enroll_id']); ?>" class="btn btn-default btn-xs" title="Profile">
								<i class="fas fa-user"></i>
							</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
$this->load->view('academy/_log_surah_modal', array(
	'roster' => isset($roster) ? $roster : array(),
	'roster_json' => isset($roster_json) ? $roster_json : '[]',
	'portion_modes' => isset($portion_modes) ? $portion_modes : array(),
	'recitation_categories' => isset($recitation_categories) ? $recitation_categories : array(),
	'ready' => !empty($ready),
));
?>

<!-- Voice Logger / NLP Modal -->
<div class="modal fade" id="academyVoiceModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?php echo form_open(base_url('academy_students')); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title"><i class="fas fa-microphone"></i> Voice Logger / NLP</h4>
			</div>
			<div class="modal-body">
				<p class="text-muted">Say e.g. <em>“Ali scored 18 out of 20 in maths in 45 seconds”</em> or <em>“Logged Al-Fatihah for Ali”</em>.</p>
				<div class="form-group">
					<label class="control-label">Transcript</label>
					<textarea name="transcript" id="voice_transcript" class="form-control" rows="3" required placeholder="Speak or type command…"></textarea>
				</div>
				<div id="voice_parse_preview" class="alert alert-info" style="display:none"></div>
				<button type="button" class="btn btn-default" id="voice_listen_btn"><i class="fas fa-microphone"></i> Listen</button>
				<button type="button" class="btn btn-default" id="voice_parse_btn"><i class="fas fa-magic"></i> Preview parse</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" name="voice_drill" value="1" class="btn btn-primary"><i class="fas fa-save"></i> Commit to ledger</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script>
window.ACADEMY_ACTIVITY_KPIS = <?php echo isset($activity_kpis_json) ? $activity_kpis_json : '{}'; ?>;
window.ACADEMY_LEADERBOARD = <?php echo isset($leaderboard_json) ? $leaderboard_json : '{}'; ?>;

(function () {
	var kpis = window.ACADEMY_ACTIVITY_KPIS || {};
	var tabs = document.getElementById('academy_period_tabs');
	if (!tabs) return;

	function paint(period) {
		var d = kpis[period] || kpis.day || {};
		var set = function (key, val) {
			var el = document.querySelector('#academy_activity_kpis [data-kpi="' + key + '"]');
			if (el) el.textContent = val;
		};
		set('engagement', d.engagement_label || '0s');
		set('verses', d.verses != null ? String(d.verses) : '0');
		set('sessions', d.sessions != null ? String(d.sessions) : '0');
		set('accuracy', d.avg_accuracy != null ? (d.avg_accuracy + '%') : '—');
		set('completion', (d.completion_pct != null ? d.completion_pct : 0) + '%');
	}

	tabs.querySelectorAll('button').forEach(function (btn) {
		btn.addEventListener('click', function () {
			tabs.querySelectorAll('button').forEach(function (b) { b.classList.remove('active'); });
			btn.classList.add('active');
			paint(btn.getAttribute('data-period') || 'day');
		});
	});
})();

(function () {
	var lb = window.ACADEMY_LEADERBOARD || {};
	var tabs = document.getElementById('academy_lb_tabs');
	var list = document.getElementById('academy_lb_list');
	if (!tabs || !list) return;

	function esc(s) {
		return String(s == null ? '' : s)
			.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;');
	}

	function paint(mode) {
		var rows = lb[mode] || [];
		if (!rows.length) {
			list.innerHTML = '<li class="text-muted" style="justify-content:center;padding:.75rem 0">No rankings yet — log a recitation.</li>';
			return;
		}
		list.innerHTML = rows.map(function (row) {
			var rankClass = row.rank === 1 ? 'gold' : (row.rank === 2 ? 'silver' : (row.rank === 3 ? 'bronze' : ''));
			var sub = esc(row.class_level || '');
			if (row.today_goal) sub += ' · 🎯 ' + esc(row.today_goal);
			return '<li>' +
				'<div class="academy-lb-rank ' + rankClass + '">' + row.rank + '</div>' +
				'<div class="academy-lb-meta">' +
					'<div class="academy-lb-name">' + esc(row.name) + '</div>' +
					'<div class="academy-lb-sub">' + sub + '</div>' +
				'</div>' +
				'<div class="academy-lb-score">' + esc(row.score_label) + '</div>' +
			'</li>';
		}).join('');
	}

	tabs.querySelectorAll('button').forEach(function (btn) {
		btn.addEventListener('click', function () {
			tabs.querySelectorAll('button').forEach(function (b) { b.classList.remove('active'); });
			btn.classList.add('active');
			paint(btn.getAttribute('data-lb') || 'engagement');
		});
	});
})();

(function () {
	var search = document.getElementById('academy_search');
	var classFilter = document.getElementById('academy_class_filter');
	var sortEl = document.getElementById('academy_sort');
	var table = document.getElementById('academy_ledger');
	if (!table) return;
	var tbody = table.querySelector('tbody');
	var label = document.getElementById('academy_count_label');
	var total = tbody.querySelectorAll('tr').length;

	function apply() {
		var q = (search.value || '').toLowerCase().trim();
		var cls = classFilter.value;
		var rows = Array.prototype.slice.call(tbody.querySelectorAll('tr'));
		rows.sort(function (a, b) {
			var mode = sortEl.value;
			if (mode === 'activity') return (+b.dataset.activity) - (+a.dataset.activity);
			if (mode === 'surahs') return (+b.dataset.surahs) - (+a.dataset.surahs);
			if (mode === 'name') return (a.dataset.name || '').localeCompare(b.dataset.name || '');
			if (mode === 'enrolled') return (+b.dataset.enrolled) - (+a.dataset.enrolled);
			return 0;
		});
		rows.forEach(function (r) { tbody.appendChild(r); });
		var shown = 0;
		rows.forEach(function (r) {
			var okSearch = !q || (r.dataset.search || '').indexOf(q) !== -1;
			var okClass = cls === 'ALL' || r.dataset.class === cls;
			var show = okSearch && okClass;
			r.style.display = show ? '' : 'none';
			if (show) shown++;
		});
		if (label) label.textContent = 'Showing ' + shown + ' of ' + total;
	}
	search.addEventListener('input', apply);
	classFilter.addEventListener('change', apply);
	sortEl.addEventListener('change', apply);
})();

(function () {
	var SR = window.SpeechRecognition || window.webkitSpeechRecognition;
	var btn = document.getElementById('voice_listen_btn');
	var ta = document.getElementById('voice_transcript');
	var parseBtn = document.getElementById('voice_parse_btn');
	var preview = document.getElementById('voice_parse_preview');
	if (btn && SR) {
		var rec = new SR();
		rec.lang = 'en-NG';
		rec.interimResults = true;
		rec.onresult = function (e) {
			var t = '';
			for (var i = 0; i < e.results.length; i++) t += e.results[i][0].transcript;
			ta.value = t;
		};
		btn.addEventListener('click', function () {
			try { rec.start(); btn.textContent = 'Listening…'; } catch (err) {}
		});
		rec.onend = function () { btn.innerHTML = '<i class="fas fa-microphone"></i> Listen'; };
	} else if (btn) {
		btn.disabled = true;
		btn.title = 'Web Speech API not supported in this browser';
	}
	if (parseBtn) {
		parseBtn.addEventListener('click', function () {
			$.post('<?php echo base_url('academy_students/parse_voice'); ?>', { transcript: ta.value }, function (res) {
				preview.style.display = '';
				if (res.success) {
					preview.className = 'alert alert-success';
					preview.textContent = res.message + ' (score ' + res.score + '/' + res.total_possible + ', ' + res.time_seconds + 's)';
				} else {
					preview.className = 'alert alert-danger';
					preview.textContent = res.message;
				}
			}, 'json');
		});
	}
})();
</script>
