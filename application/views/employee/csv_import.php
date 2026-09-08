<div class="row">
	<div class="col-md-12">
		<section class="panel">
		<?php echo form_open_multipart($this->uri->uri_string(), array( 'class' => 'form-horizontal form-bordered validate'));?>	
			<header class="panel-heading">
				<h4 class="panel-title">
					<i class="fas fa-file-archive"></i> <?=translate('multiple_import')?> - <?=translate('employee')?>
				</h4>
			</header>
			<div class="panel-body">
			<?php if ($this->session->flashdata('csvimport')): ?>
				<div class="alert-danger p-sm"><?php echo $this->session->flashdata('csvimport'); ?></div>
			<?php endif; ?>
				<div class="form-group mt-md">
					<div class="col-md-12 mb-md">
						<a class="btn btn-default pull-right" href="<?=base_url('employee/csv_Sampledownloader')?>">
							<i class='fas fa-file-download'></i> Download Sample Import File
						</a>
						<a class="btn btn-default pull-right mr-sm" href="<?=base_url('employee/csv_export')?>">
							<i class='fas fa-file-export'></i> <?=translate('export')?> CSV
						</a>
					</div>
					<div class="col-md-12">
						<div class="alert alert-subl">
							<strong>Instructions :</strong><br/>
							1. Download the first sample file.<br/>
							2. Open the downloaded "CSV" file and carefully fill in the employee details.<br/>
							3. The date you are trying to enter the "DateOfBirth" and "JoiningDate" column make sure the date format is Y-m-d (<?=date('Y-m-d')?>).<br/>
							4. For employee "Gender" use Male, Female value.<br/>
							5. The "Email" column will be used as the login username.<br/>
						</div>
					</div>
				</div>
			<?php if (is_superadmin_loggedin()): ?>
				<div class="form-group">
					<label class="control-label col-md-3"><?php echo translate('branch');?> <span class="required">*</span></label>
					<div class="col-md-6">
						<?php
							$arrayBranch = $this->app_lib->getSelectList('branch');
							echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' id='branch_id' onchange='getDesignationByBranch(this.value); getDepartmentByBranch(this.value);'
							data-plugin-selectTwo data-width='100%'");
						?>
						<span class="error"><?=form_error('branch_id')?></span>
					</div>
				</div>
			<?php endif; ?>
				<div class="form-group">
					<label class="control-label col-md-3"><?=translate('role')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<?php
							$role_list = $this->app_lib->getRoles();
							echo form_dropdown("user_role", $role_list, set_value('user_role'), "class='form-control'
							data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
						<span class="error"><?=form_error('user_role')?></span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3"><?=translate('designation')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<?php
							$designation_list = $this->app_lib->getDesignation($branch_id);
							echo form_dropdown("designation_id", $designation_list, set_value('designation_id'), "class='form-control' id='designation_id'
							data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
						?>
						<span class="error"><?=form_error('designation_id')?></span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3"><?=translate('department')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<?php
							$department_list = $this->app_lib->getDepartment($branch_id);
							echo form_dropdown("department_id", $department_list, set_value('department_id'), "class='form-control' id='department_id'
							data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
						?>
						<span class="error"><?=form_error('department_id')?></span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Select CSV File <span class="required">*</span></label>
					<div class="col-md-6 mb-lg">
						<input type="file" name="userfile" class="dropify" data-height="140" data-allowed-file-extensions="csv" />
						<?php echo form_error('userfile', '<label class="error">', '</label>'); ?>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-offset-3 col-md-2">
						<button type="submit" name="save" value="1" class="btn btn btn-default btn-block">
							<i class="fas fa-plus-circle"></i> <?=translate('import')?>
						</button>
					</div>
				</div>
			</footer>
			<?php echo form_close();?>
		</section>
	</div>
</div>

<script>
function getDesignationByBranch(branchID) {
    if (branchID) {
        $.ajax({
            url: base_url + 'ajax/getDesignationByBranch',
            type: 'POST',
            data: { branch_id: branchID },
            success: function(data) {
                $('#designation_id').html(data).trigger('change');
            }
        });
    }
}
function getDepartmentByBranch(branchID) {
    if (branchID) {
        $.ajax({
            url: base_url + 'ajax/getDepartmentByBranch',
            type: 'POST',
            data: { branch_id: branchID },
            success: function(data) {
                $('#department_id').html(data).trigger('change');
            }
        });
    }
}
</script>
