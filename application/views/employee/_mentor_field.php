<?php
$internRoleId = role_id_by_prefix('intern');
$selectedRole = set_value('user_role', isset($staff['role_id']) ? $staff['role_id'] : '');
$selectedMentor = set_value('mentor_id', isset($staff['mentor_id']) ? $staff['mentor_id'] : '');
$branchId = '';
if (!empty($staff['branch_id'])) {
	$branchId = $staff['branch_id'];
} elseif (!empty($branch_id)) {
	$branchId = $branch_id;
} elseif (defined('SCHOOL_ID')) {
	$branchId = SCHOOL_ID;
}
$CI = get_instance();
$mentorOptions = $CI->employee_model->facilitatorOptions($branchId);
$showMentor = $internRoleId > 0 && (string) $selectedRole === (string) $internRoleId;
?>
<div class="row" id="mentor_field" style="<?php echo $showMentor ? '' : 'display:none'; ?>">
	<div class="col-md-6 mb-sm">
		<div class="form-group">
			<label class="control-label"><?php echo translate('mentor'); ?> <span class="required">*</span></label>
			<?php
				echo form_dropdown(
					'mentor_id',
					$mentorOptions,
					$selectedMentor,
					"class='form-control' id='mentor_id' data-plugin-selectTwo data-width='100%'"
				);
			?>
			<span class="error"><?php echo form_error('mentor_id'); ?></span>
			<span class="help-block">The facilitator who will mentor this intern.</span>
		</div>
	</div>
</div>
<script>
(function () {
	var internRole = <?php echo json_encode((string) $internRoleId); ?>;
	function toggleMentor() {
		var role = document.getElementById('user_role');
		var box = document.getElementById('mentor_field');
		if (!role || !box) {
			return;
		}
		box.style.display = String(role.value) === internRole ? '' : 'none';
	}
	if (window.jQuery) {
		window.jQuery(document).on('change', '#user_role', toggleMentor);
	}
	toggleMentor();
})();
</script>
