<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li>
				<a href="<?=base_url('education_board')?>"><i class="fas fa-arrow-left"></i> Back to Boards</a>
			</li>
			<li class="active">
				<a href="#manage" data-toggle="tab"><i class="fas fa-cogs"></i> <?=$board->name?></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="manage">
				<div class="row">
					<div class="col-md-12">
						<p class="text-muted mb-md">Manage shared items for <strong><?=$board->name?></strong>. All schools assigned to this board will inherit these items.</p>
					</div>
				</div>

				<!-- Sub tabs for each item type -->
				<ul class="nav nav-pills mb-md" role="tablist">
					<li class="<?=$active_tab=='class'?'active':''?>"><a href="#tab_class" data-toggle="tab">Classes</a></li>
					<li class="<?=$active_tab=='section'?'active':''?>"><a href="#tab_section" data-toggle="tab">Sections</a></li>
					<li class="<?=$active_tab=='subject'?'active':''?>"><a href="#tab_subject" data-toggle="tab">Subjects</a></li>
					<li class="<?=$active_tab=='grade'?'active':''?>"><a href="#tab_grade" data-toggle="tab">Grades</a></li>
					<li class="<?=$active_tab=='exam_term'?'active':''?>"><a href="#tab_exam_term" data-toggle="tab">Exam Terms</a></li>
					<li class="<?=$active_tab=='fees_type'?'active':''?>"><a href="#tab_fees_type" data-toggle="tab">Fee Types</a></li>
					<li class="<?=$active_tab=='student_category'?'active':''?>"><a href="#tab_student_category" data-toggle="tab">Student Categories</a></li>
					<li class="<?=$active_tab=='staff_department'?'active':''?>"><a href="#tab_staff_department" data-toggle="tab">Departments</a></li>
					<li class="<?=$active_tab=='staff_designation'?'active':''?>"><a href="#tab_staff_designation" data-toggle="tab">Designations</a></li>
				</ul>

				<div class="tab-content">
					<!-- CLASSES TAB -->
					<div class="tab-pane <?=$active_tab=='class'?'active':''?>" id="tab_class">
						<div class="row">
							<div class="col-md-5">
								<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=class'), array('class' => 'form-horizontal validate')); ?>
									<input type="hidden" name="item_table" value="class">
									<div class="form-group">
										<div class="col-md-12">
											<input type="text" class="form-control" name="name" placeholder="Class Name (e.g. JSS 1)" required />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-8">
											<input type="text" class="form-control" name="name_numeric" placeholder="Numeric Value (e.g. 7)" />
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-default btn-block" name="submit" value="add_item">
												<i class="fas fa-plus"></i> Add
											</button>
										</div>
									</div>
								<?php echo form_close(); ?>
							</div>
							<div class="col-md-7">
								<table class="table table-bordered table-condensed">
									<thead><tr><th width="50">#</th><th>Class Name</th><th>Numeric</th><th width="60">Action</th></tr></thead>
									<tbody>
										<?php $i=1; foreach($classes as $item): ?>
										<tr>
											<td><?=$i++?></td>
											<td><?=$item->name?></td>
											<td><?=$item->name_numeric?></td>
											<td>
												<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=class')); ?>
													<input type="hidden" name="item_table" value="class">
													<input type="hidden" name="item_id" value="<?=$item->id?>">
													<button type="submit" name="submit" value="delete_item" class="btn btn-danger btn-circle btn-xs" onclick="return confirm('Delete this class?')"><i class="fas fa-trash-alt"></i></button>
												<?php echo form_close(); ?>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!-- SECTIONS TAB -->
					<div class="tab-pane <?=$active_tab=='section'?'active':''?>" id="tab_section">
						<div class="row">
							<div class="col-md-5">
								<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=section'), array('class' => 'form-horizontal validate')); ?>
									<input type="hidden" name="item_table" value="section">
									<div class="form-group">
										<div class="col-md-12">
											<input type="text" class="form-control" name="name" placeholder="Section Name (e.g. A)" required />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-8">
											<input type="text" class="form-control" name="capacity" placeholder="Capacity (e.g. 40)" />
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-default btn-block" name="submit" value="add_item">
												<i class="fas fa-plus"></i> Add
											</button>
										</div>
									</div>
								<?php echo form_close(); ?>
							</div>
							<div class="col-md-7">
								<table class="table table-bordered table-condensed">
									<thead><tr><th width="50">#</th><th>Section</th><th>Capacity</th><th width="60">Action</th></tr></thead>
									<tbody>
										<?php $i=1; foreach($sections as $item): ?>
										<tr>
											<td><?=$i++?></td>
											<td><?=$item->name?></td>
											<td><?=$item->capacity?></td>
											<td>
												<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=section')); ?>
													<input type="hidden" name="item_table" value="section">
													<input type="hidden" name="item_id" value="<?=$item->id?>">
													<button type="submit" name="submit" value="delete_item" class="btn btn-danger btn-circle btn-xs" onclick="return confirm('Delete?')"><i class="fas fa-trash-alt"></i></button>
												<?php echo form_close(); ?>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!-- SUBJECTS TAB -->
					<div class="tab-pane <?=$active_tab=='subject'?'active':''?>" id="tab_subject">
						<div class="row">
							<div class="col-md-5">
								<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=subject'), array('class' => 'form-horizontal validate')); ?>
									<input type="hidden" name="item_table" value="subject">
									<div class="form-group">
										<div class="col-md-12">
											<input type="text" class="form-control" name="name" placeholder="Subject Name" required />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6">
											<input type="text" class="form-control" name="subject_code" placeholder="Code" />
										</div>
										<div class="col-md-6">
											<select class="form-control" name="subject_type">
												<option value="Theory">Theory</option>
												<option value="Practical">Practical</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-8">
											<input type="text" class="form-control" name="subject_author" placeholder="Author (optional)" />
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-default btn-block" name="submit" value="add_item">
												<i class="fas fa-plus"></i> Add
											</button>
										</div>
									</div>
								<?php echo form_close(); ?>
							</div>
							<div class="col-md-7">
								<table class="table table-bordered table-condensed">
									<thead><tr><th width="30">#</th><th>Subject</th><th>Code</th><th>Type</th><th width="60">Action</th></tr></thead>
									<tbody>
										<?php $i=1; foreach($subjects as $item): ?>
										<tr>
											<td><?=$i++?></td>
											<td><?=$item->name?></td>
											<td><?=$item->subject_code?></td>
											<td><?=$item->subject_type?></td>
											<td>
												<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=subject')); ?>
													<input type="hidden" name="item_table" value="subject">
													<input type="hidden" name="item_id" value="<?=$item->id?>">
													<button type="submit" name="submit" value="delete_item" class="btn btn-danger btn-circle btn-xs" onclick="return confirm('Delete?')"><i class="fas fa-trash-alt"></i></button>
												<?php echo form_close(); ?>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!-- GRADES TAB -->
					<div class="tab-pane <?=$active_tab=='grade'?'active':''?>" id="tab_grade">
						<div class="row">
							<div class="col-md-5">
								<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=grade'), array('class' => 'form-horizontal validate')); ?>
									<input type="hidden" name="item_table" value="grade">
									<div class="form-group">
										<div class="col-md-6">
											<input type="text" class="form-control" name="name" placeholder="Grade (e.g. A)" required />
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control" name="grade_point" placeholder="Point (e.g. 5)" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4">
											<input type="text" class="form-control" name="lower_mark" placeholder="Lower %" />
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" name="upper_mark" placeholder="Upper %" />
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" name="remark" placeholder="Remark" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<button type="submit" class="btn btn-default" name="submit" value="add_item">
												<i class="fas fa-plus"></i> Add Grade
											</button>
										</div>
									</div>
								<?php echo form_close(); ?>
							</div>
							<div class="col-md-7">
								<table class="table table-bordered table-condensed">
									<thead><tr><th width="30">#</th><th>Grade</th><th>Point</th><th>Lower</th><th>Upper</th><th>Remark</th><th width="50">Action</th></tr></thead>
									<tbody>
										<?php $i=1; foreach($grades as $item): ?>
										<tr>
											<td><?=$i++?></td>
											<td><?=$item->name?></td>
											<td><?=$item->grade_point?></td>
											<td><?=$item->lower_mark?></td>
											<td><?=$item->upper_mark?></td>
											<td><?=$item->remark?></td>
											<td>
												<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=grade')); ?>
													<input type="hidden" name="item_table" value="grade">
													<input type="hidden" name="item_id" value="<?=$item->id?>">
													<button type="submit" name="submit" value="delete_item" class="btn btn-danger btn-circle btn-xs" onclick="return confirm('Delete?')"><i class="fas fa-trash-alt"></i></button>
												<?php echo form_close(); ?>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!-- EXAM TERMS TAB -->
					<div class="tab-pane <?=$active_tab=='exam_term'?'active':''?>" id="tab_exam_term">
						<?php echo $this->load->view('education_board/_simple_tab', array('board' => $board, 'table' => 'exam_term', 'label' => 'Term Name', 'placeholder' => 'e.g. First Term', 'items' => $exam_terms), true); ?>
					</div>

					<!-- FEE TYPES TAB -->
					<div class="tab-pane <?=$active_tab=='fees_type'?'active':''?>" id="tab_fees_type">
						<div class="row">
							<div class="col-md-5">
								<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=fees_type'), array('class' => 'form-horizontal validate')); ?>
									<input type="hidden" name="item_table" value="fees_type">
									<div class="form-group">
										<div class="col-md-12">
											<input type="text" class="form-control" name="name" placeholder="Fee Type Name" required />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-8">
											<input type="text" class="form-control" name="fee_code" placeholder="Fee Code" />
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-default btn-block" name="submit" value="add_item">
												<i class="fas fa-plus"></i> Add
											</button>
										</div>
									</div>
								<?php echo form_close(); ?>
							</div>
							<div class="col-md-7">
								<table class="table table-bordered table-condensed">
									<thead><tr><th width="30">#</th><th>Fee Type</th><th>Code</th><th width="60">Action</th></tr></thead>
									<tbody>
										<?php $i=1; foreach($fees_types as $item): ?>
										<tr>
											<td><?=$i++?></td>
											<td><?=$item->name?></td>
											<td><?=$item->fee_code?></td>
											<td>
												<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab=fees_type')); ?>
													<input type="hidden" name="item_table" value="fees_type">
													<input type="hidden" name="item_id" value="<?=$item->id?>">
													<button type="submit" name="submit" value="delete_item" class="btn btn-danger btn-circle btn-xs" onclick="return confirm('Delete?')"><i class="fas fa-trash-alt"></i></button>
												<?php echo form_close(); ?>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!-- STUDENT CATEGORIES TAB -->
					<div class="tab-pane <?=$active_tab=='student_category'?'active':''?>" id="tab_student_category">
						<?php echo $this->load->view('education_board/_simple_tab', array('board' => $board, 'table' => 'student_category', 'label' => 'Category', 'placeholder' => 'e.g. Regular, Scholarship', 'items' => $student_categories), true); ?>
					</div>

					<!-- DEPARTMENTS TAB -->
					<div class="tab-pane <?=$active_tab=='staff_department'?'active':''?>" id="tab_staff_department">
						<?php echo $this->load->view('education_board/_simple_tab', array('board' => $board, 'table' => 'staff_department', 'label' => 'Department', 'placeholder' => 'e.g. Teaching, Admin', 'items' => $staff_departments), true); ?>
					</div>

					<!-- DESIGNATIONS TAB -->
					<div class="tab-pane <?=$active_tab=='staff_designation'?'active':''?>" id="tab_staff_designation">
						<?php echo $this->load->view('education_board/_simple_tab', array('board' => $board, 'table' => 'staff_designation', 'label' => 'Designation', 'placeholder' => 'e.g. Teacher, Principal', 'items' => $staff_designations), true); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
