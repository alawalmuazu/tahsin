<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="<?=(empty($validation_error) ? 'active' : '') ?>">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> Board List</a>
			</li>
			<li class="<?=(!empty($validation_error) ? 'active' : '') ?>">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Create Board</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane <?=(empty($validation_error) ? 'active' : '')?>">
				<div class="mb-md">
					<table class="table table-bordered table-hover table-condensed mb-none table-export">
						<thead>
							<tr>
								<th width="50"><?=translate('sl')?></th>
								<th>Board Name</th>
								<th>Description</th>
								<th>Schools Assigned</th>
								<th class="no-sort"><?=translate('action')?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$count = 1;
								foreach($boards as $row):
									$school_count = $this->db->where('board_id', $row->id)->count_all_results('branch');
							?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo $row->name; ?></td>
								<td><?php echo $row->description; ?></td>
								<td><span class="badge badge-primary"><?php echo $school_count; ?></span></td>
								<td class="min-w-c">
									<a href="<?=base_url('education_board/manage/'.$row->id)?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="Manage Items">
										<i class="fas fa-cogs"></i>
									</a>
									<a href="<?=base_url('education_board/edit/'.$row->id)?>" class="btn btn-default btn-circle icon">
										<i class="fas fa-pen-nib"></i>
									</a>
									<?php echo btn_delete('education_board/delete_data/' . $row->id); ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane <?=(!empty($validation_error) ? 'active' : '')?>" id="create">
				<?php echo form_open(uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
					<div class="form-group mt-md">
						<label class="col-md-3 control-label">Board Name <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="name" value="<?=set_value('name')?>" placeholder="e.g. SUBEB, SMB" />
							<span class="error"><?=form_error('name')?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6 mb-md">
							<textarea rows="3" class="form-control" name="description" placeholder="e.g. State Universal Basic Education Board"><?=set_value('description')?></textarea>
						</div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" class="btn btn-default btn-block" name="submit" value="save">
									<i class="fas fa-plus-circle"></i> <?=translate('save')?>
								</button>
							</div>
						</div>
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
