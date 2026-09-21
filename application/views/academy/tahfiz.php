<div class="row">
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-quran"></i> Log Tahfiz portion</h4>
			</header>
			<?php echo form_open(base_url('tahfiz')); ?>
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
						</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label class="control-label">Surah <span class="required">*</span></label>
					<select name="surah_number" class="form-control" required <?php echo !$ready ? 'disabled' : ''; ?>>
						<?php foreach ($surahs as $num => $name): ?>
						<option value="<?php echo (int) $num; ?>" <?php echo set_select('surah_number', $num); ?>>
							<?php echo (int) $num; ?>. <?php echo html_escape($name); ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label class="control-label">Portion mode <span class="required">*</span></label>
					<select name="portion_mode" id="portion_mode" class="form-control" required <?php echo !$ready ? 'disabled' : ''; ?>>
						<?php foreach ($portion_modes as $key => $label): ?>
						<option value="<?php echo html_escape($key); ?>" <?php echo set_select('portion_mode', $key, $key === 'FULL_SURAH'); ?>><?php echo html_escape($label); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label class="control-label">Recitation category <span class="required">*</span></label>
					<select name="recitation_category" class="form-control" required <?php echo !$ready ? 'disabled' : ''; ?>>
						<option value="">Select category…</option>
						<?php
						$rcats = isset($recitation_categories) ? $recitation_categories : array();
						foreach ($rcats as $ck => $clabel):
						?>
						<option value="<?php echo html_escape($ck); ?>" <?php echo set_select('recitation_category', $ck); ?>><?php echo html_escape($clabel); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="row portion-ayah">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Ayah from</label>
							<input type="number" name="ayah_from" class="form-control" min="1" value="<?php echo set_value('ayah_from'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Ayah to</label>
							<input type="number" name="ayah_to" class="form-control" min="1" value="<?php echo set_value('ayah_to'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
				</div>

				<div class="row portion-page" style="display:none;">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Page from</label>
							<input type="number" name="page_from" class="form-control" min="1" max="604" value="<?php echo set_value('page_from'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Page to</label>
							<input type="number" name="page_to" class="form-control" min="1" max="604" value="<?php echo set_value('page_to'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Completed at</label>
					<input type="datetime-local" name="completed_at" class="form-control" value="<?php echo set_value('completed_at', date('Y-m-d\TH:i')); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
				</div>

				<div class="form-group">
					<label class="control-label">Akhlaq note</label>
					<textarea name="akhlaq_note" class="form-control" rows="2" <?php echo !$ready ? 'disabled' : ''; ?>><?php echo set_value('akhlaq_note'); ?></textarea>
				</div>

				<hr>
				<p class="text-muted"><strong>Tarteel / ASR verification</strong></p>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Accuracy %</label>
							<input type="number" step="0.1" min="0" max="100" name="accuracy_score" class="form-control" value="<?php echo set_value('accuracy_score'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Mistake words</label>
							<input type="number" min="0" name="mistake_word_count" class="form-control" value="<?php echo set_value('mistake_word_count'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label">Audio / video URL</label>
					<input type="text" name="audio_url" class="form-control" placeholder="Audio URL" value="<?php echo set_value('audio_url'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
					<input type="text" name="video_url" class="form-control mt-sm" placeholder="Video URL" value="<?php echo set_value('video_url'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
				</div>
				<div class="form-group">
					<label class="control-label">Duration (sec)</label>
					<input type="number" min="0" name="recitation_seconds" class="form-control" value="<?php echo set_value('recitation_seconds'); ?>" <?php echo !$ready ? 'disabled' : ''; ?>>
				</div>

				<div class="checkbox-replace">
					<label class="i-checks">
						<input type="checkbox" name="verified" value="1" checked <?php echo !$ready ? 'disabled' : ''; ?>><i></i> Verified by instructor
					</label>
				</div>
			</div>
			<footer class="panel-footer">
				<button type="submit" name="save_tahfiz" value="1" class="btn btn-default pull-right" <?php echo !$ready ? 'disabled' : ''; ?>>
					<i class="fas fa-save"></i> Save portion
				</button>
			</footer>
			<?php echo form_close(); ?>
		</section>
	</div>

	<div class="col-md-7">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-list"></i> Recent Tahfiz records</h4>
			</header>
			<div class="panel-body">
				<style>
				.tahfiz-chip{display:inline-block;padding:2px 8px;border-radius:6px;font-size:.7rem;font-weight:600;margin:2px 2px 0 0}
				.tahfiz-chip-ok{background:rgba(16,185,129,.12);color:#059669}
				.tahfiz-chip-warn{background:rgba(245,158,11,.12);color:#d97706}
				.tahfiz-chip-audio{background:rgba(2,132,199,.1);color:#0369a1}
				.tahfiz-note{display:block;margin-top:.25rem;font-style:italic;color:#94a3b8;font-size:.75rem}
				</style>
				<div class="table-responsive">
					<table class="table table-bordered table-condensed mb-none table-hover">
						<thead>
							<tr>
								<th>When</th>
								<th>Student</th>
								<th>Surah / Portion</th>
								<th>Verified</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($recent)): ?>
							<tr><td colspan="5" class="text-center text-muted">No Tahfiz records yet.</td></tr>
							<?php else: foreach ($recent as $row):
								$rawNote = isset($row->akhlaq_note) ? (string) $row->akhlaq_note : '';
								$cleanNote = trim(preg_replace('/\s*\[[^\]]*Audio Attached[^\]]*\]/u', '', $rawNote));
								$cleanNote = trim(preg_replace('/\s*\[[^\]]*(Tarteel AI|Live ASR)[^\]]*\]/u', '', $cleanNote));
								$cleanNote = trim(preg_replace('/\s{2,}/', ' ', $cleanNote));
								$dur = isset($row->recitation_seconds) && $row->recitation_seconds !== null
									? (int) $row->recitation_seconds : null;
								$mistakes = isset($row->mistake_word_count) && $row->mistake_word_count !== null
									? (int) $row->mistake_word_count : null;
							?>
							<tr>
								<td><small><?php echo html_escape(date('M j, Y · g:i A', strtotime($row->completed_at))); ?></small></td>
								<td>
									<?php echo html_escape($row->student_name); ?>
									<br><small class="text-muted"><?php echo html_escape($row->register_no); ?></small>
								</td>
								<td>
									<strong><?php echo (int) $row->surah_number; ?>. <?php echo html_escape($row->surah_name); ?></strong>
									<br><small><?php echo html_escape(isset($portion_modes[$row->portion_mode]) ? $portion_modes[$row->portion_mode] : $row->portion_mode); ?></small>
									<?php
									$rcats = isset($recitation_categories) ? $recitation_categories : array();
									if (!empty($row->recitation_category)):
										$ck = strtoupper($row->recitation_category);
									?>
									<br><small style="color:#0f766e;font-weight:700"><?php echo html_escape(isset($rcats[$ck]) ? $rcats[$ck] : $ck); ?></small>
									<?php endif; ?>
									<?php if ($row->ayah_from || $row->ayah_to): ?>
									<br><small>Ayah <?php echo (int) $row->ayah_from; ?>–<?php echo (int) $row->ayah_to; ?></small>
									<?php endif; ?>
									<?php if ($row->page_from || $row->page_to): ?>
									<br><small>Page <?php echo (int) $row->page_from; ?>–<?php echo (int) $row->page_to; ?></small>
									<?php endif; ?>
									<div style="margin-top:.35rem">
										<?php if (isset($row->accuracy_score) && $row->accuracy_score !== null): ?>
										<span class="tahfiz-chip tahfiz-chip-ok">🤖 <?php echo html_escape($row->accuracy_score); ?>% Acc<?php if ($mistakes !== null): ?> · <?php echo $mistakes; ?> mistake<?php echo $mistakes === 1 ? '' : 's'; ?><?php endif; ?></span>
										<?php endif; ?>
										<?php if (!empty($row->tarteel_status)): ?>
										<span class="tahfiz-chip"><?php echo html_escape($row->tarteel_status); ?></span>
										<?php endif; ?>
										<?php if ($dur !== null): ?>
										<span class="tahfiz-chip"><?php echo $dur < 60 ? ($dur . 's') : (floor($dur / 60) . 'm ' . ($dur % 60) . 's'); ?></span>
										<?php endif; ?>
										<?php if (!empty($row->audio_url)): ?>
										<span class="tahfiz-chip tahfiz-chip-audio">🎙️ Audio</span>
										<a class="tahfiz-chip tahfiz-chip-audio" href="<?php echo html_escape($row->audio_url); ?>" target="_blank" download>💾 Download</a>
										<?php endif; ?>
									</div>
									<?php if ($cleanNote !== ''): ?>
									<span class="tahfiz-note">💭 <?php echo html_escape($cleanNote); ?></span>
									<?php endif; ?>
								</td>
								<td><?php echo (int) $row->verified ? '<span class="label label-success">Yes</span>' : '<span class="label label-default">No</span>'; ?></td>
								<td>
									<?php if (get_permission('tahfiz', 'is_delete') || is_superadmin_loggedin()): ?>
									<a href="<?php echo base_url('tahfiz/delete/' . (int) $row->id); ?>" class="btn btn-danger btn-circle btn-xs academy-confirm-delete" data-confirm="Delete this Tahfiz record?"><i class="fas fa-trash-alt"></i></a>
									<?php endif; ?>
								</td>
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
	var mode = document.getElementById('portion_mode');
	var ayah = document.querySelector('.portion-ayah');
	var page = document.querySelector('.portion-page');
	function sync() {
		var v = mode.value;
		ayah.style.display = (v === 'AYAH' || v === 'FROM_TO_AYAH' || v === 'SUMMUI' || v === 'RUBBUI') ? '' : 'none';
		page.style.display = (v === 'SAFHA') ? '' : 'none';
	}
	mode.addEventListener('change', sync);
	sync();
})();
</script>
