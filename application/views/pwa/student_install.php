<?php
$student_name = isset($student_name) && $student_name !== '' ? $student_name : 'this child';
$first = $student_name;
if (strpos($student_name, ' ') !== false) {
	$first = trim(substr($student_name, 0, strpos($student_name, ' ')));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Install <?php echo html_escape($first); ?></title>
<link rel="manifest" href="<?php echo html_escape($manifest); ?>">
<meta name="theme-color" content="#10241e">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="<?php echo html_escape($first); ?>">
<link rel="apple-touch-icon" href="<?php echo html_escape($icon); ?>">
<style>
body{margin:0;background:#eef1f4;color:#1a1a1a;font-family:system-ui,sans-serif}
.card{max-width:420px;margin:24px auto;background:#fff;padding:28px 22px;border-top:4px solid #0f5c4c}
h1{margin:0 0 8px;color:#0f5c4c;font-size:1.4rem}
p{line-height:1.45}
button,a.btn{display:inline-block;background:#c9a227;color:#1a1a1a;font-weight:700;border:0;border-radius:999px;padding:.75rem 1.1rem;text-decoration:none}
.note{color:#555;font-size:.92rem}
</style>
</head>
<body>
<div class="card">
	<h1>Install <?php echo html_escape($first); ?></h1>
	<p>This icon is only for <?php echo html_escape($student_name); ?>. A brother or sister gets a different icon, so each child stays signed in on this phone.</p>
	<p><button type="button" id="install_btn">Install <?php echo html_escape($first); ?></button></p>
	<p class="note" id="install_note">On iPhone, tap Share, then Add to Home Screen. The name under the icon is <?php echo html_escape($first); ?>.</p>
	<p class="note">If Android says Tahsin is already installed, delete the icon that is not a child's name, then tap Install here again.</p>
	<p><a class="btn" href="<?php echo html_escape($login_url); ?>">Open sign in</a></p>
</div>
<script>
(function () {
	var scope = <?php echo json_encode($scope); ?>;
	var swUrl = <?php echo json_encode($sw_url); ?>;
	var note = document.getElementById('install_note');
	var btn = document.getElementById('install_btn');
	var promptEvent = null;
	if ('serviceWorker' in navigator) {
		navigator.serviceWorker.register(swUrl, { scope: scope }).catch(function () {});
	}
	window.addEventListener('beforeinstallprompt', function (event) {
		event.preventDefault();
		promptEvent = event;
		note.textContent = 'Tap Install, then confirm. ' + <?php echo json_encode($first); ?> + ' is added beside any other child.';
	});
	btn.addEventListener('click', function () {
		if (!promptEvent) {
			note.textContent = /iphone|ipad|ipod/i.test(navigator.userAgent || '')
				? 'On iPhone, tap Share, then Add to Home Screen.'
				: 'Use the browser menu, choose Install app or Add to Home screen, and confirm. If it says already installed, delete the Tahsin icon that has no child name.';
			return;
		}
		var pending = promptEvent.prompt();
		promptEvent = null;
		Promise.resolve(pending).then(function () {}).catch(function () {});
	});
})();
</script>
</body>
</html>
