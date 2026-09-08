<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li>
				<a href="<?php echo base_url('role'); ?>"><i class="fas fa-list-ul"></i> <?php echo translate('role') . " " . translate('list'); ?></a>
			</li>
			<li class="active">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> <?php echo translate('create') . " " . translate('role'); ?></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="create">
	            <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
	            <input type="hidden" name="id" value="<?php echo $roles['id']; ?>">
				<div class="form-group <?php if (form_error('role')) echo 'has-error'; ?>">
					<label class="col-md-3 control-label"><?php echo translate('role') . " " . translate('name'); ?> <span class="required">*</span></label>
					<div class="col-md-6 mb-sm">
						<input type="text" class="form-control" name="role" value="<?php echo set_value('role', $roles['name']); ?>">
						<span class="error"><?php echo form_error('role'); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">
						<i class="fas fa-globe"></i> Statewide Role
					</label>
					<div class="col-md-6 mb-sm">
						<div class="checkbox-replace">
							<label class="i-checks">
								<input type="hidden" name="is_statewide" value="0">
								<input type="checkbox" name="is_statewide" id="is_statewide_edit" value="1"
									<?php echo ($roles['is_statewide'] == 1 ? 'checked' : ''); ?>>
								<i></i> Mark this role as <strong>Statewide</strong> (no school branch required)
							</label>
						</div>
						<small class="text-muted"><i class="fas fa-info-circle"></i> Statewide roles (e.g. Commissioner, Permanent Secretary) operate across all branches and do not require a branch assignment.</small>
					</div>
				</div>
				
				<footer class="panel-footer mt-lg">
					<div class="row">
						<div class="col-md-2 col-md-offset-3">
							<button type="submit" name="save" value="1" class="btn btn-default btn-block"><i class="fas fa-edit"></i> <?php echo translate('update'); ?></button>
						</div>
					</div>	
				</footer>
			<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>