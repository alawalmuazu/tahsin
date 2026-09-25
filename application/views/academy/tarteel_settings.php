<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-sliders-h"></i> Tarteel settings</h4>
			</header>
			<div class="panel-body">
				<p class="text-muted">These levels are for the director and the admin. A parent only receives the sealed audio after approval and acknowledgement. Strength means the clip is at or above the accuracy line and within the mistake limit. Needs improving means the clip is below the accuracy line, or the mistake count reaches the limit.</p>
				<?php echo form_open('academy_review/tarteel_settings'); ?>
					<input type="hidden" name="save_tarteel_bands" value="1">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Level</th>
								<th>Strength from %</th>
								<th>Strength max mistakes</th>
								<th>Improve below %</th>
								<th>Improve at mistakes</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($bands as $i => $band): ?>
							<tr>
								<td>
									<input type="hidden" name="bands[<?php echo (int) $i; ?>][id]" value="<?php echo (int) $band->id; ?>">
									<input class="form-control" name="bands[<?php echo (int) $i; ?>][name]" value="<?php echo html_escape($band->name); ?>">
								</td>
								<td><input class="form-control" type="number" min="0" max="100" step="1" name="bands[<?php echo (int) $i; ?>][strength_min_accuracy]" value="<?php echo html_escape($band->strength_min_accuracy); ?>"></td>
								<td><input class="form-control" type="number" min="0" step="1" name="bands[<?php echo (int) $i; ?>][strength_max_mistakes]" value="<?php echo (int) $band->strength_max_mistakes; ?>"></td>
								<td><input class="form-control" type="number" min="0" max="100" step="1" name="bands[<?php echo (int) $i; ?>][weak_max_accuracy]" value="<?php echo html_escape($band->weak_max_accuracy); ?>"></td>
								<td><input class="form-control" type="number" min="1" step="1" name="bands[<?php echo (int) $i; ?>][weak_min_mistakes]" value="<?php echo (int) $band->weak_min_mistakes; ?>"></td>
							</tr>
						<?php endforeach; ?>
							<tr>
								<td><input class="form-control" name="new_band_name" placeholder="Add a level, for example Hifz"></td>
								<td><input class="form-control" type="number" min="0" max="100" name="new_strength_min_accuracy" value="80"></td>
								<td><input class="form-control" type="number" min="0" name="new_strength_max_mistakes" value="1"></td>
								<td><input class="form-control" type="number" min="0" max="100" name="new_weak_max_accuracy" value="55"></td>
								<td><input class="form-control" type="number" min="1" name="new_weak_min_mistakes" value="4"></td>
							</tr>
						</tbody>
					</table>
					<p class="text-muted">Clear a level name and save to remove that level. Students on a removed level fall back to Medium.</p>
					<h5>Student level</h5>
					<table class="table table-bordered table-condensed">
						<thead><tr><th>Student</th><th>Level</th></tr></thead>
						<tbody>
						<?php
						$mediumId = 0;
						foreach ($bands as $band) {
							if (strcasecmp($band->name, 'Medium') === 0) {
								$mediumId = (int) $band->id;
							}
						}
						if ($mediumId === 0 && !empty($bands)) {
							$mediumId = (int) $bands[0]->id;
						}
						?>
						<?php foreach ($students as $stu): ?>
							<?php $current = isset($assigned[(int) $stu->id]) ? (int) $assigned[(int) $stu->id] : $mediumId; ?>
							<tr>
								<td><?php echo html_escape($stu->fullname); ?></td>
								<td>
									<select class="form-control" name="student_band[<?php echo (int) $stu->id; ?>]">
										<?php foreach ($bands as $band): ?>
											<option value="<?php echo (int) $band->id; ?>" <?php echo $current === (int) $band->id ? 'selected' : ''; ?>><?php echo html_escape($band->name); ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					<button class="btn btn-primary" type="submit">Save levels</button>
				<?php echo form_close(); ?>
			</div>
		</section>
	</div>
</div>
