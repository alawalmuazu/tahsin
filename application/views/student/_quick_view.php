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
<script>
$(function () {
	if (!$('#quickEditForm').length || window.__quickEditBound) {
		return;
	}
	window.__quickEditBound = true;
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
				if (window.cusDataTable) {
					window.cusDataTable.ajax.reload(null, false);
				}
				$('.js-quick-name').filter(function () {
					return $(this).attr('data-student') === String(studentId);
				}).text(data.full_name || '');
				$('#quick_edit_error').removeClass('text-danger').addClass('text-success').text(data.message);
			},
			error: function () {
				btn.button('reset');
				$('#quick_edit_error').addClass('text-danger').text('Not saved');
			}
		});
	});
});
</script>
