<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-user-check"></i> Assign students to a teacher</h4>
			</header>
			<div class="panel-body">
				<?php if (empty($ready)): ?>
					<div class="alert alert-warning">Run <code>application/migrations/academy_session_review.sql</code> on this database first.</div>
				<?php else: ?>
					<p class="text-muted">Pick a teacher, filter by Student Category, Section, Class, or Programme Category, tick the students, then save once. A student can stay on other teachers.</p>
					<?php echo form_open('academy_review/assign'); ?>
						<input type="hidden" name="save_assign" value="1">
						<div class="form-group">
							<label>Teacher</label>
							<select name="teacher_id" class="form-control" required onchange="if(this.value){window.location='<?php echo base_url('academy_review/assign?teacher_id='); ?>'+this.value;}">
								<option value="">Select teacher</option>
								<?php foreach ($teachers as $t): ?>
									<option value="<?php echo (int) $t->id; ?>" <?php echo ((int) $teacher_id === (int) $t->id) ? 'selected' : ''; ?>><?php echo html_escape($t->name); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php if (!empty($teacher_id)): ?>
						<?php
							$classes = array();
							$sections = array();
							$studentCats = array();
							$programmes = array();
							foreach ($students as $s) {
								$cn = $s->class_name ? $s->class_name : '';
								$sn = $s->section_name ? $s->section_name : '';
								$scat = $s->student_category ? $s->student_category : '';
								$prog = $s->programme_category ? $s->programme_category : '';
								if ($cn !== '') $classes[$cn] = $cn;
								if ($sn !== '') $sections[$sn] = $sn;
								if ($scat !== '') $studentCats[$scat] = $scat;
								if ($prog !== '') $programmes[$prog] = $prog;
							}
							ksort($classes);
							ksort($sections);
							ksort($studentCats);
							ksort($programmes);
						?>
						<div class="form-group">
							<label>Students</label>
							<p class="text-muted" style="margin-bottom:.5rem">Tick everyone for this teacher, then save once. Unticked students are removed from this teacher only.</p>
							<div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;margin-bottom:.5rem">
								<input type="search" id="assign_filter" class="form-control" style="max-width:240px" placeholder="Search name or register no">
								<select id="assign_student_cat" class="form-control" style="max-width:200px">
									<option value="">Student Category</option>
									<?php foreach ($studentCats as $name): ?>
										<option value="<?php echo html_escape($name); ?>"><?php echo html_escape($name); ?></option>
									<?php endforeach; ?>
								</select>
								<select id="assign_section" class="form-control" style="max-width:180px">
									<option value="">Section</option>
									<?php foreach ($sections as $name): ?>
										<option value="<?php echo html_escape($name); ?>"><?php echo html_escape($name); ?></option>
									<?php endforeach; ?>
								</select>
								<select id="assign_class" class="form-control" style="max-width:180px">
									<option value="">Class</option>
									<?php foreach ($classes as $cn): ?>
										<option value="<?php echo html_escape($cn); ?>"><?php echo html_escape($cn); ?></option>
									<?php endforeach; ?>
								</select>
								<select id="assign_programme" class="form-control" style="max-width:220px">
									<option value="">Programme Category</option>
									<?php foreach ($programmes as $name): ?>
										<option value="<?php echo html_escape($name); ?>"><?php echo html_escape($name); ?></option>
									<?php endforeach; ?>
								</select>
								<button type="button" class="btn btn-default btn-sm" id="assign_all">Select visible</button>
								<button type="button" class="btn btn-default btn-sm" id="assign_none">Clear visible</button>
								<span class="text-muted" id="assign_count"></span>
							</div>
							<div style="max-height:420px;overflow:auto;border:1px solid #e2e8f0;border-radius:8px">
								<table class="table table-condensed" style="margin:0">
									<thead>
										<tr>
											<th style="width:36px"></th>
											<th>Student</th>
											<th>Register no</th>
											<th>Student Category</th>
											<th>Section</th>
											<th>Class</th>
											<th>Programme Category</th>
										</tr>
									</thead>
									<tbody id="assign_rows">
									<?php foreach ($students as $s):
										$cn = $s->class_name ? $s->class_name : '';
										$sn = $s->section_name ? $s->section_name : '';
										$scat = $s->student_category ? $s->student_category : '';
										$prog = $s->programme_category ? $s->programme_category : '';
									?>
										<tr data-class="<?php echo html_escape($cn); ?>" data-section="<?php echo html_escape($sn); ?>" data-student-cat="<?php echo html_escape($scat); ?>" data-programme="<?php echo html_escape($prog); ?>" data-search="<?php echo html_escape(strtolower($s->fullname . ' ' . $s->register_no)); ?>">
											<td><input type="checkbox" class="assign-student" name="student_ids[]" value="<?php echo (int) $s->id; ?>" <?php echo !empty($picked[(int) $s->id]) ? 'checked' : ''; ?>></td>
											<td><?php echo html_escape($s->fullname); ?></td>
											<td><?php echo html_escape($s->register_no); ?></td>
											<td><?php echo $scat !== '' ? html_escape($scat) : '—'; ?></td>
											<td><?php echo $sn !== '' ? html_escape($sn) : '—'; ?></td>
											<td><?php echo $cn !== '' ? html_escape($cn) : '—'; ?></td>
											<td><?php echo $prog !== '' ? html_escape($prog) : '—'; ?></td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save all ticked students</button>
						<script>
						(function () {
							var rows = document.querySelectorAll('#assign_rows tr');
							var filter = document.getElementById('assign_filter');
							var klass = document.getElementById('assign_class');
							var section = document.getElementById('assign_section');
							var studentCat = document.getElementById('assign_student_cat');
							var programme = document.getElementById('assign_programme');
							var countEl = document.getElementById('assign_count');
							function match(row, attr, value) {
								return !value || row.getAttribute(attr) === value;
							}
							function visible(row) {
								var q = (filter.value || '').toLowerCase();
								var okQ = !q || (row.getAttribute('data-search') || '').indexOf(q) !== -1;
								return okQ
									&& match(row, 'data-class', klass.value)
									&& match(row, 'data-section', section.value)
									&& match(row, 'data-student-cat', studentCat.value)
									&& match(row, 'data-programme', programme.value);
							}
							function paint() {
								var n = 0, shown = 0;
								rows.forEach(function (row) {
									var show = visible(row);
									row.style.display = show ? '' : 'none';
									var box = row.querySelector('.assign-student');
									if (box && box.checked) n++;
									if (show) shown++;
								});
								countEl.textContent = n + ' ticked · ' + shown + ' shown';
							}
							function setVisible(on) {
								rows.forEach(function (row) {
									if (!visible(row)) return;
									var box = row.querySelector('.assign-student');
									if (box) box.checked = on;
								});
								paint();
							}
							filter.addEventListener('input', paint);
							klass.addEventListener('change', paint);
							section.addEventListener('change', paint);
							studentCat.addEventListener('change', paint);
							programme.addEventListener('change', paint);
							document.getElementById('assign_all').addEventListener('click', function () { setVisible(true); });
							document.getElementById('assign_none').addEventListener('click', function () { setVisible(false); });
							document.getElementById('assign_rows').addEventListener('change', paint);
							paint();
						})();
						</script>
						<?php endif; ?>
					<?php echo form_close(); ?>
				<?php endif; ?>
			</div>
		</section>
	</div>
</div>

<?php if (!empty($roster)): ?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading"><h4 class="panel-title">Current assignments</h4></header>
			<div class="panel-body">
				<table class="table table-bordered table-condensed">
					<thead><tr><th>Teacher</th><th>Student</th><th>Register no</th></tr></thead>
					<tbody>
					<?php foreach ($roster as $row): ?>
						<tr>
							<td><?php echo html_escape($row->teacher_name); ?></td>
							<td><?php echo html_escape($row->student_name); ?></td>
							<td><?php echo html_escape($row->register_no); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>
<?php endif; ?>
