<?php
$memberMap = array(); // student_id => list of group names
foreach ((isset($groups) ? $groups : array()) as $g) {
	foreach ((isset($g->members) ? $g->members : array()) as $m) {
		$sid = (int) $m['student_id'];
		if (!isset($memberMap[$sid])) {
			$memberMap[$sid] = array();
		}
		$memberMap[$sid][] = $g->name;
	}
}
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-users"></i> Facilitator groups</h4>
			</header>
			<div class="panel-body">
				<?php if (empty($ready)): ?>
					<div class="alert alert-warning">Run <code>application/migrations/academy_teacher_groups.sql</code> in phpMyAdmin first.</div>
				<?php else: ?>
					<p class="text-muted">Create groups such as <strong>Morning</strong>, <strong>Afternoon</strong>, and <strong>Night</strong>. <strong>The same student can be in one, two, or all of them.</strong> Tick or untick, then Update. When every student in a group has today’s category recorded, that group goes to the director on its own.</p>

					<?php if (!empty($teachers)): ?>
						<?php echo form_open('academy_groups', array('method' => 'get', 'class' => 'form-inline', 'style' => 'margin-bottom:1rem')); ?>
							<label>Facilitator&nbsp;</label>
							<select name="teacher_id" class="form-control" onchange="this.form.submit()">
								<?php foreach ($teachers as $t): ?>
									<option value="<?php echo (int) $t->id; ?>" <?php echo ((int) $teacher_id === (int) $t->id) ? 'selected' : ''; ?>><?php echo html_escape($t->name); ?></option>
								<?php endforeach; ?>
							</select>
						<?php echo form_close(); ?>
					<?php endif; ?>

					<?php if ((int) $teacher_id < 1): ?>
						<p class="text-muted">Select a facilitator.</p>
					<?php elseif (empty($assigned)): ?>
						<div class="alert alert-info">No students assigned yet. Admin must assign students under <a href="<?php echo base_url('academy_review/assign'); ?>">Assign Students</a>.</div>
					<?php else: ?>
						<?php echo form_open('academy_groups'); ?>
							<input type="hidden" name="teacher_id" value="<?php echo (int) $teacher_id; ?>">
							<div class="form-inline" style="margin-bottom:1.25rem;display:flex;gap:.5rem;flex-wrap:wrap;align-items:center">
								<input type="text" name="group_name" class="form-control" placeholder="New group name (e.g. Morning)" required style="min-width:220px">
								<button type="submit" name="create_group" value="1" class="btn btn-primary"><i class="fas fa-plus"></i> Create group</button>
							</div>
						<?php echo form_close(); ?>

						<?php if (empty($groups)): ?>
							<p class="text-muted">No groups yet. Create one, then tick students and Update.</p>
						<?php endif; ?>

						<?php foreach ((isset($groups) ? $groups : array()) as $g): ?>
							<?php
							$inGroup = array();
							foreach ((isset($g->members) ? $g->members : array()) as $m) {
								$inGroup[(int) $m['student_id']] = true;
							}
							?>
							<div class="panel panel-default" style="border:1px solid #e2e8f0;border-radius:10px;margin-bottom:1rem">
								<div class="panel-heading" style="display:flex;justify-content:space-between;align-items:center;gap:.75rem;flex-wrap:wrap">
									<strong><?php echo html_escape($g->name); ?></strong>
									<span class="text-muted"><?php echo count($inGroup); ?> student<?php echo count($inGroup) === 1 ? '' : 's'; ?></span>
								</div>
								<div class="panel-body">
									<?php echo form_open('academy_groups'); ?>
										<input type="hidden" name="teacher_id" value="<?php echo (int) $teacher_id; ?>">
										<input type="hidden" name="group_id" value="<?php echo (int) $g->id; ?>">
										<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:.35rem .75rem;margin-bottom:1rem">
											<?php foreach ($assigned as $st): ?>
												<?php
												$sid = (int) $st->student_id;
												$alsoIn = array();
												if (!empty($memberMap[$sid])) {
													foreach ($memberMap[$sid] as $gn) {
														if ($gn !== $g->name) {
															$alsoIn[] = $gn;
														}
													}
												}
												?>
												<label style="font-weight:500">
													<input type="checkbox" name="student_ids[]" value="<?php echo $sid; ?>" <?php echo !empty($inGroup[$sid]) ? 'checked' : ''; ?>>
													<?php echo html_escape($st->student_name); ?>
													<?php if (!empty($alsoIn)): ?>
														<small class="text-muted">(also in <?php echo html_escape(implode(', ', $alsoIn)); ?>)</small>
													<?php endif; ?>
												</label>
											<?php endforeach; ?>
										</div>
										<p class="help-block" style="margin-top:0">Tick to <strong>add</strong>, untick to <strong>remove</strong> from this group only. The same student can stay ticked in other groups.</p>
										<button type="submit" name="save_members" value="1" class="btn btn-success btn-sm"><i class="fas fa-user-edit"></i> Update group (add / remove)</button>
										<button type="submit" name="delete_group" value="1" class="btn btn-danger btn-sm" onclick="return confirm('Delete this group? Students stay in any other groups they belong to.');">Delete group</button>
									<?php echo form_close(); ?>
								</div>
							</div>
						<?php endforeach; ?>

						<?php
						$ungrouped = 0;
						foreach ($assigned as $st) {
							if (empty($memberMap[(int) $st->student_id])) {
								$ungrouped++;
							}
						}
						?>
						<?php if ($ungrouped > 0 && !empty($groups)): ?>
							<p class="text-warning"><i class="fas fa-exclamation-triangle"></i> <?php echo (int) $ungrouped; ?> assigned student<?php echo $ungrouped === 1 ? '' : 's'; ?> not in any group — recording them will ask you to add them to a group first.</p>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</section>
	</div>
</div>
