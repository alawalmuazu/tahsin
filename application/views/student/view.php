<?php  $widget = (is_multi_school() ? 4 : 6); ?>
<style>
@media (max-width: 767px) {
	.student-list-panel > .panel-heading { padding-bottom: 12px; }
	.student-list-panel .panel-btn {
		position: static;
		float: none !important;
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
		margin: 10px 0 0;
		right: auto;
		top: auto;
	}
	.student-list-panel .panel-btn .btn {
		flex: 1 1 140px;
		min-height: 42px;
		float: none;
	}
	#studentTable .checked-area,
	#studentTable .checkbox-replace,
	#studentTable .i-checks {
		min-width: 32px;
		min-height: 32px;
	}
	#bulkEditModal .modal-dialog { width: auto; margin: 12px; }
	#bulkEditModal .modal-body { padding: 15px; }
	#bulkEditModal .form-control { min-height: 42px; font-size: 16px; }
	#bulkEditModal .modal-footer { display: flex; flex-direction: column; gap: 8px; }
	#bulkEditModal .modal-footer .btn,
	#dobEditModal .modal-footer .btn { width: 100%; min-height: 44px; margin: 0; }
	#dobEditModal .modal-dialog { width: auto; margin: 12px; }
	#dobEditModal .form-control { min-height: 42px; font-size: 16px; }
	#dobEditModal .modal-footer { display: flex; flex-direction: column; gap: 8px; }
}
.js-quick-open { display: inline-block; padding: 0; border: 0; background: transparent; color: inherit; font: inherit; cursor: pointer; vertical-align: middle; }
.js-quick-name { font-weight: 600; text-align: left; }
.js-quick-name:hover, .js-quick-name:focus { color: #1b7a3a; text-decoration: underline; }
.js-quick-photo img { display: block; border-radius: 4px; }
.js-quick-photo:hover img, .js-quick-photo:focus img { outline: 2px solid #1b7a3a; outline-offset: 2px; }
.js-dob-edit { display: inline-block; padding: 0; white-space: normal; text-align: left; line-height: 1.25; }
.js-dob-edit .js-dob-label { display: block; font-size: 11px; }
.quick-dob-edit { margin-top: 6px; }
.quick-dob-edit .form-control { min-height: 42px; font-size: 16px; }
.quick-dob-edit .btn { margin-top: 6px; min-height: 40px; }
#quickView .form-control { font-size: 16px; min-height: 42px; }
#quickView .qv-locked { margin: 4px 0 12px; color: #607068; }
#quickView .qv-actions { display: flex; gap: 8px; justify-content: flex-end; }
@media (max-width: 767px) {
	#quickView .qv-actions { flex-direction: column; }
	#quickView .qv-actions .btn { width: 100%; min-height: 44px; margin: 0; }
}
.student-hscroll-hint { display: none; margin: 0 0 8px; font-size: 13px; }
@media (max-width: 1600px) {
	.student-hscroll-hint { display: block; }
}
.student-list-panel .dataTables_wrapper .table-responsive {
	overflow-x: auto !important;
	overflow-y: hidden;
	-webkit-overflow-scrolling: touch;
	max-width: 100%;
	scrollbar-color: #1b7a3a #e6eee8;
}
.student-list-panel .dataTables_wrapper .table-responsive::-webkit-scrollbar { height: 14px; }
.student-list-panel .dataTables_wrapper .table-responsive::-webkit-scrollbar-track { background: #e6eee8; }
.student-list-panel .dataTables_wrapper .table-responsive::-webkit-scrollbar-thumb { background: #1b7a3a; border-radius: 8px; }
.student-list-panel #studentTable {
	width: max-content !important;
	min-width: 1180px;
}
.student-list-panel #studentTable th,
.student-list-panel #studentTable td { white-space: nowrap; }
body.academy-phone .student-list-panel #studentTable { display: table !important; width: max-content !important; border: 1px solid #ddd !important; }
body.academy-phone .student-list-panel #studentTable thead {
	display: table-header-group !important;
	position: static !important;
	width: auto !important;
	height: auto !important;
	overflow: visible !important;
	clip: auto !important;
}
body.academy-phone .student-list-panel #studentTable tbody { display: table-row-group !important; }
body.academy-phone .student-list-panel #studentTable tr {
	display: table-row !important;
	margin: 0 !important;
	padding: 0 !important;
	border-radius: 0 !important;
}
body.academy-phone .student-list-panel #studentTable th,
body.academy-phone .student-list-panel #studentTable td {
	display: table-cell !important;
	float: none !important;
	width: auto !important;
	padding: 5px 8px !important;
	white-space: nowrap !important;
	border: 1px solid #ddd !important;
}
body.academy-phone .student-list-panel #studentTable td::before { content: none !important; }
body.academy-phone .student-list-panel #studentTable td .btn,
body.academy-phone .student-list-panel #studentTable td button {
	width: auto !important;
	min-height: 0;
	margin: 0 2px 0 0;
	display: inline-block;
}
</style>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><?=translate('select_ground')?></h4>
			</header>
			<?php echo form_open("student/filter_validation", array('class' => ' sfrm'));?>
			<div class="panel-body">
				<div class="row mb-sm">
				<?php if (is_multi_school() ): ?>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>
							<?php
								$arrayBranch = $this->app_lib->getSelectList('branch');
								echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' id='branch_id'
								data-plugin-selectTwo data-width='100%'");
							?>
							<span class="error"></span>
						</div>
					</div>
				<?php endif; ?>
					<div class="col-md-<?php echo $widget; ?> mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('section')?></label>
							<?php
								$arraySection = $this->app_lib->getBranchSections($branch_id);
								echo form_dropdown("section_id", $arraySection, set_value('section_id'), "class='form-control' id='section_id'
								data-plugin-selectTwo data-width='100%'");
							?>
							<span class="error"></span>
						</div>
					</div>
					<div class="col-md-<?php echo $widget; ?> mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('category')?></label>
							<?php
								$arrayCategory = $this->app_lib->getStudentCategory($branch_id);
								echo form_dropdown("category_id", $arrayCategory, set_value('category_id'), "class='form-control' id='category_id'
								data-plugin-selectTwo data-width='100%'");
							?>
							<span class="error"></span>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-xs-12 col-md-offset-10 col-md-2">
						<button type="submit" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing" name="search" value="1" class="btn btn-default btn-block"> <i class="fas fa-filter"></i> <?=translate('filter')?></button>
					</div>
				</div>
			</footer>
			<?php echo form_close();?>
		</section>

		<section class="panel appear-animation hidden-div student-list-panel" data-appear-animation="<?=$global_config['animations'] ?>" data-appear-animation-delay="100">
			<header class="panel-heading">
			<?php if (get_permission('student', 'is_edit') || get_permission('student', 'is_delete')): ?>
				<div class="panel-btn">
					<?php if (get_permission('student', 'is_edit')): ?>
					<button type="button" class="btn btn-default btn-circle" id="student_bulk_edit">
						<i class="fas fa-pen"></i> Bulk edit
					</button>
					<?php endif; ?>
					<?php if (get_permission('student', 'is_delete')): ?>
					<button class="btn btn-default btn-circle" id="student_bulk_delete" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
						<i class="fas fa-trash-alt"></i> <?=translate('bulk_delete')?>
					</button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
				<h4 class="panel-title"><i class="fas fa-user-graduate"></i> <?php echo translate('student_list');?></h4>
			</header>
			<div class="panel-body mb-md" id="table">
				<div class="export_title"><?php echo translate('student_list');?></div>
				<p class="student-hscroll-hint text-muted">Swipe the list sideways to see class, phone, fees, and actions.</p>
				<table class="table table-bordered table-condensed table-hover table-export" id="studentTable">
					<thead>
						<tr>
							<th width="10" class="no-sort no-export">
								<div class="checkbox-replace">
									<label class="i-checks"><input type="checkbox" id="selectAllchkbox"><i></i></label>
								</div>
							</th>
							<th class="no-sort"><?=translate('photo')?></th>
							<th><?=translate('name')?></th>
							<th><?=translate('class')?></th>
							<th><?=translate('section')?></th>
							<th><?=translate('gender')?></th>
							<th><?=translate('category')?></th>
							<th><?=translate('register_no')?></th>
							<th width="80"><?=translate('roll')?></th>
							<th><?=translate('age')?></th>
							<th><?=translate('guardian_name')?></th>
						<?php
						$show_custom_fields = custom_form_table('student', $branch_id);
						if (count($show_custom_fields)) {
							foreach ($show_custom_fields as $fields) {
						?>
							<th><?=$fields['field_label']?></th>
						<?php } } ?>
							<th class="no-sort no-export"><?=translate('fees_progress')?></th>
							<th><?=translate('action')?></th>
						</tr>	
					</thead>
				</table>
			</div>
		</section>
		
	</div>
</div>

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="quickView">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title">
				<i class="far fa-user-circle"></i> <?=translate('quick_view')?>
			</h4>
		</header>
		<?php if (get_permission('student', 'is_edit')):
			$qvProgrammes = isset($bulk_programmes) ? $bulk_programmes : array();
		?>
		<form id="quickEditForm">
		<div class="panel-body">
			<input type="hidden" name="student_id" id="qv_student_id" value="">
			<input type="hidden" name="old_user_photo" id="quick_old_photo" value="">
			<?php $this->load->view('student/_photo_field', array('photo_current' => '', 'photo_required' => false)); ?>
			<div class="text-center qv-locked">
				<div><?=translate('register_no')?> <strong id="quick_register_no"></strong></div>
				<div><?=translate('roll')?> <strong id="quick_roll"></strong></div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('first_name')?> <span class="required">*</span></label>
						<input type="text" class="form-control" name="first_name" id="qv_first_name" required>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('surname')?> <span class="required">*</span></label>
						<input type="text" class="form-control" name="last_name" id="qv_last_name" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label><?=translate('other_name')?></label>
				<input type="text" class="form-control" name="other_name" id="qv_other_name">
			</div>
			<div class="form-group">
				<label>Programme Category <span class="required">*</span></label>
				<?php echo form_dropdown('category_id', $qvProgrammes, '', "class='form-control' id='qv_category'"); ?>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('admission_date')?></label>
						<input type="date" class="form-control" name="admission_date" id="qv_admission">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('date_of_birth')?></label>
						<input type="date" class="form-control" name="birthday" id="qv_birthday" max="<?php echo date('Y-m-d'); ?>" min="1990-01-01">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('gender')?> <span class="required">*</span></label>
						<select class="form-control" name="gender" id="qv_gender">
							<option value="male"><?=translate('male')?></option>
							<option value="female"><?=translate('female')?></option>
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('blood_group')?></label>
						<?php echo form_dropdown('blood_group', $this->app_lib->getBloodgroup(), '', "class='form-control' id='qv_blood'"); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('religion')?></label>
						<?php echo form_dropdown('religion', nigeria_religions(), '', "class='form-control' id='qv_religion'"); ?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('state')?></label>
						<?php echo form_dropdown('state', nigeria_states(), '', "class='form-control' id='qv_state'"); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('email')?></label>
						<input type="email" class="form-control" name="email" id="qv_email">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('mobile_no')?></label>
						<input type="text" class="form-control" name="mobileno" id="qv_mobile">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label><?=translate('address')?></label>
				<textarea class="form-control" name="current_address" id="qv_address" rows="2"></textarea>
			</div>
			<input type="hidden" name="parent_id" id="qv_parent_id" value="">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('guardian_name')?></label>
						<input type="text" class="form-control" name="guardian_name" id="qv_guardian_name">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label><?=translate('guardian')?> <?=translate('mobile_no')?></label>
						<input type="text" class="form-control" name="guardian_mobileno" id="qv_guardian_phone">
						<small class="text-muted" id="qv_guardian_note"></small>
					</div>
				</div>
			</div>
			<p class="text-danger" id="quick_edit_error" style="margin-bottom:0"></p>
		</div>
		<footer class="panel-footer">
			<div class="qv-actions">
				<button type="submit" class="btn btn-primary" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">Save</button>
				<button type="button" class="btn btn-default modal-dismiss"><?=translate('close')?></button>
			</div>
		</footer>
		</form>
		<?php else: ?>
		<div class="panel-body">
			<div class="quick_image">
				<img alt="" class="user-img-circle" id="quick_image" src="<?=base_url('uploads/app_image/defualt.png')?>" width="120" height="120">
			</div>
			<div class="text-center">
				<h4 class="text-weight-semibold mb-xs" id="quick_full_name"></h4>
				<p><?=translate('student')?> / <span id="quick_category"></span></p>
			</div>
			<div class="table-responsive mt-md mb-md">
				<table class="table table-striped table-bordered table-condensed mb-none">
					<tbody>
						<tr>
							<th><?=translate('register_no')?></th>
							<td><span id="quick_register_no"></span></td>
							<th><?=translate('roll')?></th>
							<td><span id="quick_roll"></span></td>
						</tr>
						<tr>
							<th><?=translate('admission_date')?></th>
							<td><span id="quick_admission_date"></span></td>
							<th><?=translate('date_of_birth')?></th>
							<td><span id="quick_date_of_birth"></span></td>
						</tr>
						<tr>
							<th><?=translate('blood_group')?></th>
							<td><span id="quick_blood_group"></span></td>
							<th><?=translate('religion')?></th>
							<td><span id="quick_religion"></span></td>
						</tr>
						<tr>
							<th><?=translate('gender')?></th>
							<td><span id="quick_gender"></span></td>
							<th><?=translate('email')?></th>
							<td colspan="3"><span id="quick_email"></span></td>
						</tr>
						<tr>
							<th><?=translate('mobile_no')?></th>
							<td><span id="quick_mobile_no"></span></td>
							<th><?=translate('state')?></th>
							<td><span id="quick_state"></span></td>
						</tr>
						<tr>
							<th><?=translate('guardian_name')?></th>
							<td><span id="quick_guardian_name"></span></td>
							<th><?=translate('guardian')?> <?=translate('mobile_no')?></th>
							<td><span id="quick_guardian_phone"></span></td>
						</tr>
						<tr class="quick-address">
							<th><?=translate('address')?></th>
							<td colspan="3" height="80px;"><span id="quick_address"></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-default modal-dismiss"><?=translate('close')?></button>
				</div>
			</div>
		</footer>
		<?php endif; ?>
	</section>
</div>

<?php if (get_permission('student', 'is_edit')):
	$bulkProgrammes = isset($bulk_programmes) ? $bulk_programmes : array();
	unset($bulkProgrammes['']);
	$bulkPwd = isset($bulk_pwd) ? $bulk_pwd : array();
	unset($bulkPwd['']);
?>
<div class="modal fade" id="bulkEditModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="bulkEditForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Bulk edit</h4>
				</div>
				<div class="modal-body">
					<p class="text-muted" id="bulkEditCount"></p>
					<div class="form-group">
						<label>Change one field</label>
						<select class="form-control" id="bulk_field" name="field">
							<option value="">Select</option>
							<option value="pwd_category">Student Category</option>
							<option value="section">Section</option>
							<option value="programme">Programme Category</option>
						</select>
					</div>
					<div class="form-group bulk-value" data-field="pwd_category" style="display:none">
						<label>Student Category <span class="required">*</span></label>
						<?php echo form_dropdown('pwd_category_id', $bulkPwd, '', "class='form-control' id='bulk_pwd'"); ?>
					</div>
					<div class="form-group bulk-value" data-field="section" style="display:none">
						<label>Section <span class="required">*</span></label>
						<?php echo form_dropdown('section_id', isset($bulk_sections) ? $bulk_sections : array(), '', "class='form-control' id='bulk_section'"); ?>
					</div>
					<div class="form-group bulk-value" data-field="programme" style="display:none">
						<label>Programme Category <span class="required">*</span></label>
						<?php echo form_dropdown('category_id', $bulkProgrammes, '', "class='form-control' id='bulk_programme'"); ?>
						<span class="help-block">With / Without Technical Skills</span>
					</div>
					<p class="text-muted">Only the field you choose is changed. A fee already paid stays as it is.</p>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">Update selected</button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?=translate('cancel')?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>
<?php if (get_permission('student', 'is_edit')): ?>
<div class="modal fade" id="dobEditModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="dobEditForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Date of birth</h4>
				</div>
				<div class="modal-body">
					<p id="dobEditName" style="margin-top:0"></p>
					<input type="hidden" id="dob_student_id" value="">
					<div class="form-group" style="margin-bottom:0">
						<label for="dob_value">Date of birth <span class="required">*</span></label>
						<input type="date" class="form-control" id="dob_value" name="birthday" required max="<?php echo date('Y-m-d'); ?>" min="1990-01-01">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?=translate('cancel')?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>

<script type="text/javascript">
	var cusDataTable = '';
	$(document).ready(function () {
        $("form.sfrm").on('submit', function(e){
        	var $this = $(this);
            e.preventDefault();
            var btn = $this.find('[type="submit"]');
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                	$(".panel.hidden-div").hide();
                    btn.button('loading');
                },
                success: function (data) {
					$('.error').html("");
					if (data.status == "fail") {
						$.each(data.error, function (index, value) {
							$this.find("[name='" + index + "']").parents('.form-group').find('.error').html(value);
						});
					} else {
						// if exist datatable it will destrory first
						if ($.fn.DataTable.isDataTable('#studentTable')) { 
							$('#studentTable').DataTable().destroy();
						}
						$(".export_title").html(data.export_title);
						$("#studentTable").html(data.thead);
						cusDataTable = initDatatable("#studentTable", "student/getStudentListDT", data.filter, 25, true, false, [{"orderable": false, "targets": 'no-sort'},{"class": 'center', "targets": 1},{"orderable": false, "targets": [-1],'class':'action'}]);
						$('#studentTable_filter input').attr('placeholder', 'Name or guardian phone');
						$(".panel.hidden-div").show();
					}
                },
                complete: function (data) {
                    btn.button('reset');
                },
                error: function () {
                    btn.button('reset');
                }
            });
        });
<?php if (get_permission('student', 'is_edit')): ?>
		function selectedStudentIds() {
			var arrayID = [];
			$("input[type='checkbox'].cb_bulkdelete").each(function () {
				if (this.checked) {
					arrayID.push($(this).attr('id'));
				}
			});
			return arrayID;
		}
		$('#bulk_field').on('change', function () {
			var field = $(this).val();
			$('.bulk-value').hide();
			if (field) {
				$('.bulk-value[data-field="' + field + '"]').show();
			}
		});
		$('#student_bulk_edit').on('click', function () {
			var arrayID = selectedStudentIds();
			if (!arrayID.length) {
				swal({
					title: "Select students",
					text: "Tick the students you want to update.",
					type: "warning",
					buttonsStyling: false,
					confirmButtonClass: "btn btn-default swal2-btn-default"
				});
				return;
			}
			$('#bulkEditCount').text(arrayID.length + (arrayID.length === 1 ? ' student selected.' : ' students selected.'));
			$('#bulkEditModal').modal('show');
		});
		$('#bulkEditForm').on('submit', function (e) {
			e.preventDefault();
			var field = $('#bulk_field').val();
			var value = field ? $('.bulk-value[data-field="' + field + '"] select').val() : '';
			var arrayID = selectedStudentIds();
			if (!field || !value) {
				swal({
					title: "Choose one field",
					text: "Pick Student Category, Section, or Programme Category, then the new value.",
					type: "warning",
					buttonsStyling: false,
					confirmButtonClass: "btn btn-default swal2-btn-default"
				});
				return;
			}
			var btn = $(this).find('[type="submit"]');
			btn.button('loading');
			$.ajax({
				url: base_url + "student/bulk_edit",
				type: "POST",
				dataType: "json",
				data: { array_id: arrayID, field: field, value: value },
				success: function (data) {
					btn.button('reset');
					$('#bulkEditModal').modal('hide');
					if (data.status === 'success' && cusDataTable) {
						cusDataTable.ajax.reload(null, false);
					}
					swal({
						title: data.status === 'success' ? "Updated" : "Not updated",
						text: data.message,
						buttonsStyling: false,
						showCloseButton: true,
						focusConfirm: false,
						confirmButtonClass: "btn btn-default swal2-btn-default",
						type: data.status
					});
				},
				error: function () {
					btn.button('reset');
				}
			});
		});
		window.fillQuickEdit = function (res) {
			if (!$('#quickEditForm').length || !res) return;
			$('#qv_student_id').val(res.student_id || '');
			$('#quick_old_photo').val(res.photo_file || '');
			$('#quickEditForm .photo-desk-preview').attr('src', res.photo || '');
			$('#qv_first_name').val(res.first_name || '');
			$('#qv_other_name').val(res.other_name || '');
			$('#qv_last_name').val(res.last_name || '');
			$('#qv_category').val(res.category_id || '');
			$('#qv_admission').val(res.admission_iso || '');
			$('#qv_birthday').val(res.birthday_iso || '');
			$('#qv_gender').val(res.gender_value || 'male');
			$('#qv_blood').val(res.blood_value || '');
			$('#qv_religion').val(res.religion_value || '');
			$('#qv_state').val(res.state_value || '');
			$('#qv_email').val(res.email_value || '');
			$('#qv_mobile').val(res.mobile_value || '');
			$('#qv_address').val(res.address_value || '');
			var hasGuardian = parseInt(res.parent_id, 10) > 0;
			$('#qv_parent_id').val(hasGuardian ? res.parent_id : '');
			$('#qv_guardian_name').val(res.guardian_name_value || '').prop('disabled', !hasGuardian);
			$('#qv_guardian_phone').val(res.guardian_phone_value || '').prop('disabled', !hasGuardian);
			$('#qv_guardian_note').text(hasGuardian ? 'This number is shared by every student with this guardian.' : 'No guardian is linked to this student.');
			$('#quick_edit_error').removeClass('text-success').addClass('text-danger').text('');
		};
		$('#quickEditForm').on('submit', function (e) {
			e.preventDefault();
			var form = this;
			var btn = $(form).find('[type="submit"]');
			$('#quick_edit_error').removeClass('text-success').addClass('text-danger').text('');
			btn.button('loading');
			$.ajax({
				url: base_url + 'student/quick_save',
				type: 'POST',
				dataType: 'json',
				data: new FormData(form),
				processData: false,
				contentType: false,
				success: function (data) {
					btn.button('reset');
					if (!data || data.status !== 'success') {
						$('#quick_edit_error').text((data && data.message) ? data.message : 'Not saved');
						return;
					}
					var studentId = $('#qv_student_id').val();
					var $cell = $('.js-dob-edit[data-student="' + studentId + '"]');
					if ($cell.length) {
						$cell.attr('data-dob', data.iso || '');
						$cell.attr('data-name', data.full_name || '');
						$cell.find('.js-dob-age').text(data.age || 'N/A');
						$cell.find('.js-dob-label').text(data.label || '');
					}
					if (data.photo) {
						$('#quickEditForm .photo-desk-preview').attr('src', data.photo);
					}
					if (data.photo_file) {
						$('#quick_old_photo').val(data.photo_file);
					}
					$('#quickEditForm .js-photo-input').val('');
					if (cusDataTable) {
						cusDataTable.ajax.reload(null, false);
					}
					$('#quick_edit_error').removeClass('text-danger').addClass('text-success').text(data.message);
				},
				error: function () {
					btn.button('reset');
					$('#quick_edit_error').addClass('text-danger').text('Not saved');
				}
			});
		});
		$(document).on('click', '.js-dob-edit', function () {
			var $btn = $(this);
			$('#dobEditName').text($btn.attr('data-name') || '');
			$('#dob_student_id').val($btn.attr('data-student') || '');
			$('#dob_value').val($btn.attr('data-dob') || '');
			$('#dobEditModal').data('button', $btn).modal('show');
		});
		$('#dobEditForm').on('submit', function (e) {
			e.preventDefault();
			var btn = $(this).find('[type="submit"]');
			var $cell = $('#dobEditModal').data('button');
			btn.button('loading');
			$.ajax({
				url: base_url + 'student/quick_dob',
				type: 'POST',
				dataType: 'json',
				data: { student_id: $('#dob_student_id').val(), birthday: $('#dob_value').val() },
				success: function (data) {
					btn.button('reset');
					if (data.status !== 'success') {
						swal({
							title: 'Not saved',
							text: data.message,
							type: 'error',
							buttonsStyling: false,
							confirmButtonClass: 'btn btn-default swal2-btn-default'
						});
						return;
					}
					if ($cell && $cell.length) {
						$cell.attr('data-dob', data.iso);
						$cell.find('.js-dob-age').text(data.age);
						$cell.find('.js-dob-label').text(data.label);
					}
					$('#dobEditModal').modal('hide');
				},
				error: function () {
					btn.button('reset');
				}
			});
		});
<?php endif; ?>
<?php if (get_permission('student', 'is_delete')): ?>
		$('#student_bulk_delete').on('click', function() {

			var btn = $(this);
			var arrayID = [];
			$("input[type='checkbox'].cb_bulkdelete").each(function (index) {
				if(this.checked) {
					arrayID.push($(this).attr('id'));
				}
			});
			if (arrayID.length != 0) {
				swal({
					title: "<?php echo translate('are_you_sure')?>",
					text: "<?php echo translate('delete_this_information')?>",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn btn-default swal2-btn-default",
					cancelButtonClass: "btn btn-default swal2-btn-default",
					confirmButtonText: "<?php echo translate('yes_continue')?>",
					cancelButtonText: "<?php echo translate('cancel')?>",
					buttonsStyling: false,
					footer: "<?php echo translate('deleted_note')?>"
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: base_url + "student/bulk_delete",
							type: "POST",
							dataType: "json",
							data: { array_id : arrayID },
							success:function(data) {
								swal({
								title: "<?php echo translate('deleted')?>",
								text: data.message,
								buttonsStyling: false,
								showCloseButton: true,
								focusConfirm: false,
								confirmButtonClass: "btn btn-default swal2-btn-default",
								type: data.status
								}).then((result) => {
									if (result.value) {
										cusDataTable.ajax.reload( null, false);
									}
								});
							}
						});
					}
				});
			}
		});
<?php endif; ?>
	});
</script>
