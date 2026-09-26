<style>
.lm-wrap{max-width:920px}
.lm-seal{display:inline-flex;align-items:center;gap:.4rem;padding:.28rem .7rem;border-radius:999px;background:linear-gradient(135deg,#0f766e,#134e4a);color:#ecfdf5;font-size:.78rem;font-weight:600;letter-spacing:.02em}
.lm-seal i{opacity:.9}
.lm-lead{color:#64748b;margin:.65rem 0 1.1rem;line-height:1.45}
.lm-continue{display:flex;flex-wrap:wrap;align-items:center;gap:.65rem;margin:0 0 1.25rem;padding:.85rem 1rem;border:1px solid #cce7e2;border-radius:12px;background:linear-gradient(180deg,#f0fdfa,#fff)}
.lm-continue strong{color:#0f766e}
.lm-surah-list{list-style:none;padding:0;margin:0;display:grid;gap:.55rem}
.lm-surah-list a{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:.75rem 1rem;border:1px solid #e2e8f0;border-radius:12px;text-decoration:none;color:#0f172a;background:#fff;transition:border-color .15s,box-shadow .15s}
.lm-surah-list a:hover{border-color:#99f6e4;box-shadow:0 4px 14px rgba(15,118,110,.08)}
.lm-bar{flex:0 0 88px;height:6px;border-radius:99px;background:#e2e8f0;overflow:hidden}
.lm-bar > span{display:block;height:100%;background:linear-gradient(90deg,#14b8a6,#0f766e)}
.lm-meta{color:#64748b;font-size:.82rem;white-space:nowrap}
.lm-back{display:inline-block;margin:0 0 .85rem;color:#0f766e}
.lm-head{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:.75rem;margin:0 0 1rem}
.lm-head h3{margin:0;font-size:1.35rem;color:#0f172a}
.lm-fill{color:#64748b;font-size:.9rem}
.lm-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(42px,1fr));gap:.4rem;margin:0 0 1.25rem}
.lm-ayah{appearance:none;border:1px solid #e2e8f0;background:#f8fafc;color:#94a3b8;border-radius:10px;height:42px;font-weight:600;font-size:.85rem;cursor:default;transition:transform .12s,box-shadow .12s,border-color .12s}
.lm-ayah.is-sealed{background:linear-gradient(160deg,#ccfbf1,#99f6e4);border-color:#5eead4;color:#115e59;cursor:pointer}
.lm-ayah.is-sealed:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(15,118,110,.18)}
.lm-ayah.is-active{outline:2px solid #0f766e;outline-offset:1px}
.lm-ayah.is-empty{opacity:.55}
.lm-player{position:sticky;bottom:12px;padding:1rem;border-radius:14px;border:1px solid #99f6e4;background:rgba(255,255,255,.96);box-shadow:0 10px 30px rgba(15,23,42,.1);backdrop-filter:blur(8px)}
.lm-player-title{font-weight:600;color:#0f172a;margin:0 0 .15rem}
.lm-player-meta{color:#64748b;font-size:.82rem;margin:0 0 .55rem}
.lm-player audio{width:100%;max-width:100%}
.lm-empty-hint{color:#64748b;font-size:.88rem;margin:.25rem 0 0}
</style>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title">
					<i class="fas fa-book-open"></i> Living Mushaf
					<?php if (!empty($student_name)): ?> · <?php echo html_escape($student_name); ?><?php endif; ?>
				</h4>
			</header>
			<div class="panel-body lm-wrap">
				<span class="lm-seal"><i class="fas fa-certificate"></i> Sealed by Tahsin</span>
				<p class="lm-lead">Only ayahs a director sealed and an admin released appear here — in this child’s own voice. Empty cells are still waiting to be filled.</p>

				<?php if (!empty($students)): ?>
					<form method="get" action="<?php echo base_url($mushaf_base); ?>" class="form-inline" style="margin-bottom:1.1rem">
						<select name="student_id" class="form-control" onchange="this.form.submit()">
							<option value="">Select a student</option>
							<?php foreach ($students as $s): ?>
								<option value="<?php echo (int) $s->id; ?>" <?php echo ((int) $student_id === (int) $s->id) ? 'selected' : ''; ?>><?php echo html_escape($s->fullname); ?></option>
							<?php endforeach; ?>
						</select>
					</form>
				<?php endif; ?>

				<?php if (empty($student_id)): ?>
					<p class="text-muted">Choose a student to open their Living Mushaf.</p>
				<?php else: ?>
					<?php
					$cg = !empty($continue_goal) ? $continue_goal : null;
					$canContinue = !empty($is_staff_mushaf) && !empty($log_surah_base) && $cg && !empty($cg['surah_number']);
					?>
					<?php if ($cg && !empty($cg['label'])): ?>
						<div class="lm-continue">
							<div>
								<div class="text-muted" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.04em">Continue from last seal</div>
								<strong><?php echo html_escape($cg['label']); ?></strong>
							</div>
							<?php if ($canContinue): ?>
								<a class="btn btn-primary btn-sm" href="<?php echo base_url($log_surah_base . '?open_log=1&student_id=' . (int) $student_id . '&surah=' . (int) $cg['surah_number'] . '&from=' . (int) $cg['ayah_from'] . '&to=' . (int) $cg['ayah_to']); ?>">
									<i class="fas fa-microphone"></i> Log next ayah
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($living)): ?>
						<a class="lm-back" href="<?php echo base_url($mushaf_base . '?student_id=' . (int) $student_id); ?>">&larr; All surahs</a>
						<div class="lm-head">
							<div>
								<h3><?php echo html_escape($living['surah_name']); ?></h3>
								<div class="lm-fill"><?php echo (int) $living['filled']; ?> of <?php echo (int) $living['ayah_count']; ?> ayahs sealed · <?php echo (int) $living['percent']; ?>%</div>
							</div>
							<div class="lm-bar" style="flex-basis:140px" title="<?php echo (int) $living['percent']; ?>%">
								<span style="width:<?php echo (int) $living['percent']; ?>%"></span>
							</div>
						</div>

						<div class="lm-grid" id="lm_grid" role="list">
							<?php foreach ($living['ayahs'] as $ayah): ?>
								<button type="button"
									class="lm-ayah <?php echo !empty($ayah['sealed']) ? 'is-sealed' : 'is-empty'; ?>"
									data-n="<?php echo (int) $ayah['n']; ?>"
									data-url="<?php echo html_escape($ayah['play_url']); ?>"
									data-label="<?php echo html_escape($ayah['label'] !== '' ? $ayah['label'] : ($living['surah_name'] . ' · Ayah ' . $ayah['n'])); ?>"
									data-meta="<?php echo html_escape(trim(implode(' · ', array_filter(array($ayah['date'], $ayah['teacher'], $ayah['category']))))); ?>"
									<?php echo empty($ayah['sealed']) || $ayah['play_url'] === '' ? 'disabled' : ''; ?>
									title="<?php echo !empty($ayah['sealed']) ? 'Play sealed ayah ' . (int) $ayah['n'] : 'Not sealed yet'; ?>"
									role="listitem">
									<?php echo (int) $ayah['n']; ?>
								</button>
							<?php endforeach; ?>
						</div>
						<p class="lm-empty-hint">Tap a teal ayah to hear this child’s sealed recitation. Grey cells have no sealed clip yet.</p>

						<div class="lm-player" id="lm_player" style="display:none">
							<div class="lm-player-title" id="lm_player_title"></div>
							<div class="lm-player-meta" id="lm_player_meta"></div>
							<audio id="lm_audio" controls preload="none"></audio>
						</div>
						<script>
						(function () {
							var grid = document.getElementById('lm_grid');
							var player = document.getElementById('lm_player');
							var audio = document.getElementById('lm_audio');
							var title = document.getElementById('lm_player_title');
							var meta = document.getElementById('lm_player_meta');
							if (!grid || !audio) return;
							grid.addEventListener('click', function (e) {
								var btn = e.target.closest ? e.target.closest('.lm-ayah') : null;
								if (!btn || btn.disabled) return;
								var url = btn.getAttribute('data-url') || '';
								if (!url) return;
								var actives = grid.querySelectorAll('.lm-ayah.is-active');
								for (var i = 0; i < actives.length; i++) {
									actives[i].classList.remove('is-active');
								}
								btn.classList.add('is-active');
								title.textContent = btn.getAttribute('data-label') || ('Ayah ' + btn.getAttribute('data-n'));
								meta.textContent = btn.getAttribute('data-meta') || 'Sealed by Tahsin';
								player.style.display = 'block';
								audio.src = url;
								audio.play().catch(function () {});
							});
						})();
						</script>
					<?php elseif (empty($surahs)): ?>
						<p class="text-muted">No sealed recitations yet. After the director and admin release a session, ayahs will light up here.</p>
					<?php else: ?>
						<ul class="lm-surah-list">
							<?php foreach ($surahs as $s): ?>
								<li>
									<a href="<?php echo base_url($mushaf_base . '?student_id=' . (int) $student_id . '&surah=' . rawurlencode($s['name'])); ?>">
										<span>
											<strong><?php echo html_escape($s['name']); ?></strong>
											<span class="lm-meta"> · <?php echo (int) $s['filled']; ?>/<?php echo (int) $s['ayah_count']; ?> ayahs</span>
										</span>
										<span style="display:flex;align-items:center;gap:.55rem">
											<span class="lm-bar"><span style="width:<?php echo (int) $s['percent']; ?>%"></span></span>
											<span class="lm-meta"><?php echo (int) $s['percent']; ?>%</span>
										</span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</section>
	</div>
</div>
