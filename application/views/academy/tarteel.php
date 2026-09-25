<?php $summary = isset($summary) ? $summary : array(); ?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-wave-square"></i> Tarteel analysis</h4>
			</header>
			<div class="panel-body">
				<p class="text-muted">Every saved recitation keeps the engine, the words heard, the words marked correct, and the Tajweed mistakes. Use this before you approve or acknowledge.</p>
				<?php echo form_open(base_url('academy_review/tarteel'), array('method' => 'get', 'class' => 'form-inline', 'style' => 'margin-bottom:1rem')); ?>
					<label for="student_id" class="mr-sm">Student</label>
					<select name="student_id" id="student_id" class="form-control" onchange="this.form.submit()">
						<option value="0">All students</option>
						<?php foreach ($students as $stu): ?>
							<option value="<?php echo (int) $stu->id; ?>" <?php echo ((int) $student_id === (int) $stu->id) ? 'selected' : ''; ?>>
								<?php echo html_escape($stu->fullname); ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php echo form_close(); ?>
				<div class="row" style="margin-bottom:1rem">
					<div class="col-sm-3"><strong><?php echo (int) $summary['recordings']; ?></strong><div class="text-muted">Recordings</div></div>
					<div class="col-sm-3"><strong><?php echo (int) $summary['with_report']; ?></strong><div class="text-muted">With a full report</div></div>
					<div class="col-sm-2"><strong><?php echo (int) $summary['correct']; ?></strong><div class="text-muted">Correct words</div></div>
					<div class="col-sm-2"><strong><?php echo (int) $summary['mistakes']; ?></strong><div class="text-muted">Tajweed mistakes</div></div>
					<div class="col-sm-2"><strong><?php echo $summary['avg_accuracy'] === null ? '—' : html_escape($summary['avg_accuracy']) . '%'; ?></strong><div class="text-muted">Average accuracy</div></div>
				</div>
				<?php $insight = isset($insight) ? $insight : array('students' => array(), 'categories' => array(), 'types' => array()); ?>
				<div class="row">
					<div class="col-md-4">
						<section class="panel">
							<header class="panel-heading"><strong>Each student</strong></header>
							<div class="panel-body">
								<?php if (empty($insight['students'])): ?>
									<p class="text-muted">No students in this list.</p>
								<?php else: ?>
									<?php foreach ($insight['students'] as $person): ?>
										<div style="margin-bottom:1rem">
											<strong><?php echo html_escape($person['name']); ?></strong>
											<span class="text-muted"> · <?php echo html_escape(isset($person['band']) ? $person['band'] : 'Medium'); ?></span>
											<div class="text-muted"><?php echo (int) $person['n']; ?> recordings<?php if ($person['avg'] !== null): ?> · <?php echo html_escape($person['avg']); ?>% average<?php endif; ?> · <?php echo (int) $person['mistakes']; ?> mistakes</div>
											<div><strong>Strength</strong> <?php echo empty($person['strengths']) ? 'None in this list for their level.' : html_escape(implode('; ', $person['strengths'])); ?></div>
											<div><strong>Needs improving</strong> <?php echo empty($person['weak']) ? 'No weak session in this list.' : html_escape(implode('; ', $person['weak'])); ?></div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</section>
					</div>
					<div class="col-md-4">
						<section class="panel">
							<header class="panel-heading"><strong>By category</strong></header>
							<div class="panel-body">
								<?php if (empty($insight['categories'])): ?>
									<p class="text-muted">No categories yet.</p>
								<?php else: ?>
									<ul style="padding-left:1.1rem">
										<?php foreach ($insight['categories'] as $cat): ?>
											<li>
												<?php echo html_escape($cat['name']); ?>
												· <?php echo (int) $cat['n']; ?> sessions
												· <?php echo $cat['avg'] === null ? 'no score' : html_escape($cat['avg']) . '%'; ?>
												· <?php echo (int) $cat['mistakes']; ?> mistakes
												· <strong><?php echo html_escape($cat['note']); ?></strong>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						</section>
					</div>
					<div class="col-md-4">
						<section class="panel">
							<header class="panel-heading"><strong>Tajweed to correct</strong></header>
							<div class="panel-body">
								<?php if (empty($insight['types'])): ?>
									<p class="text-muted">Mistake types appear after a recording saved with the full Tarteel report. Until then, use the mistake counts on each session.</p>
								<?php else: ?>
									<ul style="padding-left:1.1rem">
										<?php foreach ($insight['types'] as $label => $n): ?>
											<li><?php echo html_escape($label); ?> · <?php echo (int) $n; ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						</section>
					</div>
				</div>
				<h4 style="margin-top:0">Each session</h4>
				<?php if (empty($rows)): ?>
					<p class="text-muted">No recitations yet.</p>
				<?php else: ?>
					<?php foreach ($rows as $row): $report = $row->tarteel; ?>
						<section class="panel" style="border:1px solid #e6e6e6">
							<header class="panel-heading">
								<strong><?php echo html_escape($row->student_name); ?></strong>
								· <?php echo html_escape($row->teacher_name); ?>
								· <?php echo html_escape($row->portion_label); ?>
								<?php if ($row->category_label !== ''): ?> · <?php echo html_escape($row->category_label); ?><?php endif; ?>
								· <?php echo html_escape($row->completed_at); ?>
							</header>
							<div class="panel-body">
								<div style="margin-bottom:.35rem"><strong><?php echo html_escape($row->verdict); ?></strong> · <?php echo html_escape($row->verdict_note); ?></div>
								<div>
									<?php if ($row->accuracy_score !== null && $row->accuracy_score !== ''): ?><?php echo html_escape($row->accuracy_score); ?>% accuracy<?php endif; ?>
									<?php if ($row->mistake_word_count !== null && $row->mistake_word_count !== ''): ?> · <?php echo (int) $row->mistake_word_count; ?> mistakes<?php endif; ?>
									<?php if ($row->recitation_seconds): ?> · <?php echo (int) $row->recitation_seconds; ?>s<?php endif; ?>
									<?php if (!empty($report['engine'])): ?> · <?php echo html_escape($report['engine']); ?><?php endif; ?>
									<?php if (!empty($report['states'])): ?> · <?php echo count($report['states']); ?> aligned words<?php endif; ?>
								</div>
								<?php $this->load->view('academy/_tarteel_player', array(
									'tp_surah' => (int) $row->surah_number,
									'tp_from' => (int) $row->ayah_from,
									'tp_to' => (int) $row->ayah_to > 0 ? (int) $row->ayah_to : (int) $row->ayah_from,
									'tp_audio' => (string) $row->play_url,
									'tp_states' => $report['states'],
									'tp_seconds' => (int) $row->recitation_seconds,
								)); ?>
								<?php if (!empty($report['transcript'])): ?>
									<div style="margin-top:.5rem"><strong>Heard</strong> <?php echo html_escape($report['transcript']); ?></div>
								<?php endif; ?>
								<?php if (!empty($report['correct'])): ?>
									<div style="margin-top:.5rem"><strong>Correct (<?php echo count($report['correct']); ?>)</strong></div>
									<ul>
										<?php foreach ($report['correct'] as $word): ?>
											<li>
												<?php if ($word['text'] !== ''): ?><?php echo html_escape($word['text']); ?> <?php endif; ?>
												ayah <?php echo (int) $word['ayah']; ?> · word <?php echo (int) $word['word']; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<?php if (!empty($report['mistakes'])): ?>
									<div><strong>Tajweed mistakes (<?php echo count($report['mistakes']); ?>)</strong></div>
									<ul>
										<?php foreach ($report['mistakes'] as $mistake): ?>
											<li>
												<?php echo html_escape($mistake['label']); ?>
												<?php if ($mistake['text'] !== ''): ?> · <?php echo html_escape($mistake['text']); ?><?php endif; ?>
												<?php if (!empty($mistake['ayah'])): ?> · ayah <?php echo (int) $mistake['ayah']; ?><?php endif; ?>
												<?php if (!empty($mistake['word'])): ?> · word <?php echo (int) $mistake['word']; ?><?php endif; ?>
												<?php if ($mistake['expected'] !== ''): ?> · expected <?php echo html_escape($mistake['expected']); ?><?php endif; ?>
												<?php if ($mistake['received'] !== ''): ?> · heard <?php echo html_escape($mistake['received']); ?><?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php elseif ((int) $row->mistake_word_count > 0): ?>
									<p class="text-muted">This recording was saved before the full report. Only the mistake count was kept.</p>
								<?php else: ?>
									<p class="text-muted">No Tajweed mistakes marked.</p>
								<?php endif; ?>
							</div>
						</section>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</section>
	</div>
</div>
<script src="<?php echo base_url('assets/js/tarteel_playback.js?v=4'); ?>"></script>
