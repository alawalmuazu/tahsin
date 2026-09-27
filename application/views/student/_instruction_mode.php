<?php
$mode = set_value('instruction_mode', isset($student['instruction_mode']) ? $student['instruction_mode'] : 'campus');
if ($mode !== 'online') {
	$mode = 'campus';
}
$tz = set_value('timezone', isset($student['timezone']) && $student['timezone'] !== '' ? $student['timezone'] : 'Africa/Lagos');
$country = set_value('country', isset($student['country']) ? $student['country'] : '');
$zones = array(
	'Africa/Lagos' => 'Nigeria (Lagos / Abuja)',
	'Europe/London' => 'United Kingdom',
	'Europe/Paris' => 'Central Europe',
	'Europe/Berlin' => 'Germany',
	'America/New_York' => 'US Eastern',
	'America/Chicago' => 'US Central',
	'America/Denver' => 'US Mountain',
	'America/Los_Angeles' => 'US Pacific',
	'Asia/Dubai' => 'Gulf',
);
?>
<div class="col-md-3 mb-sm">
	<div class="form-group">
		<label class="control-label">How they attend</label>
		<select name="instruction_mode" id="instruction_mode" class="form-control">
			<option value="campus" <?php echo $mode === 'campus' ? 'selected' : ''; ?>>Campus (comes to school)</option>
			<option value="online" <?php echo $mode === 'online' ? 'selected' : ''; ?>>Online (video session)</option>
		</select>
		<small class="help-block">Online students join from Abuja, the US, Europe, and elsewhere. Classes stay on the Kano clock.</small>
	</div>
</div>
<div class="col-md-3 mb-sm js-online-field">
	<div class="form-group">
		<label class="control-label">Country</label>
		<input type="text" class="form-control" name="country" value="<?php echo html_escape($country); ?>" placeholder="Nigeria, USA, United Kingdom">
	</div>
</div>
<div class="col-md-3 mb-sm js-online-field">
	<div class="form-group">
		<label class="control-label">Their timezone</label>
		<select name="timezone" class="form-control">
			<?php foreach ($zones as $id => $label): ?>
				<option value="<?php echo html_escape($id); ?>" <?php echo $tz === $id ? 'selected' : ''; ?>><?php echo html_escape($label); ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<script>
(function () {
	var sel = document.getElementById('instruction_mode');
	if (!sel) return;
	function sync() {
		var show = sel.value === 'online';
		var nodes = document.querySelectorAll('.js-online-field');
		for (var i = 0; i < nodes.length; i++) {
			nodes[i].style.display = show ? '' : 'none';
		}
	}
	sel.addEventListener('change', sync);
	sync();
})();
</script>
