<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-book-open"></i> Voice mushaf<?php if (!empty($student_name)): ?> · <?php echo html_escape($student_name); ?><?php endif; ?></h4>
			</header>
			<div class="panel-body">
				<p class="text-muted">Only recitations a director sealed and an admin released appear here, in ayah order.</p>
				<?php if (!empty($students)): ?>
					<form method="get" action="<?php echo base_url($mushaf_base); ?>" class="form-inline" style="margin-bottom:1rem">
						<select name="student_id" class="form-control" onchange="this.form.submit()">
							<option value="">Select a student</option>
							<?php foreach ($students as $s): ?>
								<option value="<?php echo (int) $s->id; ?>" <?php echo ((int) $student_id === (int) $s->id) ? 'selected' : ''; ?>><?php echo html_escape($s->fullname); ?></option>
							<?php endforeach; ?>
						</select>
					</form>
				<?php endif; ?>

				<?php if (empty($student_id)): ?>
					<p class="text-muted">Choose a student to see sealed surahs.</p>
				<?php elseif (!empty($surah)): ?>
					<p><a href="<?php echo base_url($mushaf_base . '?student_id=' . (int) $student_id); ?>">&larr; All surahs</a></p>
					<h4><?php echo html_escape($surah); ?></h4>
					<?php if (empty($pins)): ?>
						<p class="text-muted">No sealed clips in this surah.</p>
					<?php else: ?>
						<?php foreach ($pins as $pin): ?>
							<div style="margin:0 0 1rem;padding-bottom:.75rem;border-bottom:1px solid #e2e8f0">
								<strong><?php echo html_escape($pin->portion_label ? $pin->portion_label : $surah); ?></strong>
								<div class="text-muted">
									<?php echo html_escape($pin->session_date); ?>
									<?php if (!empty($pin->teacher_name)): ?> · <?php echo html_escape($pin->teacher_name); ?><?php endif; ?>
									<?php if (!empty($pin->category_label)): ?> · <?php echo html_escape($pin->category_label); ?><?php endif; ?>
								</div>
								<?php if (!empty($pin->play_url)): ?>
									<audio controls preload="none" src="<?php echo html_escape($pin->play_url); ?>" style="display:block;margin-top:.4rem;width:100%;max-width:420px"></audio>
								<?php else: ?>
									<p class="text-muted" style="margin:.35rem 0 0">Sealed, with no audio file.</p>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php elseif (empty($surahs)): ?>
					<p class="text-muted">No sealed recitations yet.</p>
				<?php else: ?>
					<ul class="list-unstyled">
						<?php foreach ($surahs as $s): ?>
							<li style="margin-bottom:.4rem">
								<a href="<?php echo base_url($mushaf_base . '?student_id=' . (int) $student_id . '&surah=' . rawurlencode($s['name'])); ?>"><?php echo html_escape($s['name']); ?></a>
								<span class="text-muted"> · <?php echo (int) $s['count']; ?> sealed</span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</section>
	</div>
</div>
