<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li>
				<a href="<?=base_url('education_board')?>"><i class="fas fa-list-ul"></i> Board List</a>
			</li>
			<li class="active">
				<a href="#edit" data-toggle="tab"><i class="far fa-edit"></i> Edit Board</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="edit">
				<?php echo form_open(uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
					<input type="hidden" name="board_id" value="<?=$board->id?>">
					<div class="form-group mt-md">
						<label class="col-md-3 control-label">Board Name <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="name" value="<?=set_value('name', $board->name)?>" />
							<span class="error"><?=form_error('name')?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6 mb-md">
							<textarea rows="3" class="form-control" name="description"><?=set_value('description', $board->description)?></textarea>
						</div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" class="btn btn-default btn-block" name="submit" value="save">
									<i class="fas fa-plus-circle"></i> <?=translate('update')?>
								</button>
							</div>
						</div>
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
