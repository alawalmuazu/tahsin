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

<?php $this->load->view('student/_quick_view'); ?>

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
