<?php
$install = isset($install) ? $install : array('name' => 'Quran', 'short_name' => 'Quran', 'photo' => '', 'student_name' => 'Student');
$clips = isset($clips) ? $clips : array();
$manifest = isset($manifest) ? $manifest : '';
$token = isset($token) ? $token : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo html_escape($install['name']); ?></title>
<link rel="manifest" href="<?php echo html_escape($manifest); ?>">
<meta name="theme-color" content="#10241e">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="<?php echo html_escape($install['short_name']); ?>">
<link rel="apple-touch-icon" href="<?php echo html_escape($install['photo']); ?>">
<style>
body{margin:0;background:#f4f7f5;color:#10241e;font-family:system-ui,sans-serif}
.wrap{max-width:520px;margin:0 auto;padding:1.25rem 1rem 3rem}
.head{display:flex;gap:.9rem;align-items:center}
.head img{width:72px;height:72px;border-radius:18px;object-fit:cover;background:#d7e3dc}
h1{font-size:1.35rem;margin:0}
.sub{color:#3d5c50;margin:.2rem 0 0;font-size:.92rem}
.install{margin:1rem 0;padding:1rem;background:#fff;border-radius:14px;border:1px solid #d7e3dc}
.install button{background:#0f766e;color:#fff;border:0;border-radius:999px;padding:.7rem 1.1rem;font-weight:700;font-size:1rem}
.install p{margin:.6rem 0 0;font-size:.82rem;color:#3d5c50}
.clip{background:#fff;border-radius:14px;padding:.9rem 1rem;margin:0 0 .75rem;border:1px solid #d7e3dc}
.clip strong{display:block}
.meta{color:#3d5c50;font-size:.82rem;margin:.25rem 0 .55rem}
audio{width:100%}
</style>
</head>
<body>
<div class="wrap">
	<div class="head">
		<img src="<?php echo html_escape($install['photo']); ?>" alt="">
		<div>
			<h1><?php echo html_escape($install['student_name']); ?></h1>
			<p class="sub">Sealed recitations</p>
		</div>
	</div>
	<div class="install">
		<button type="button" id="install_quran">Install <?php echo html_escape($install['name']); ?></button>
		<p id="install_note">On iPhone, tap Share, then Add to Home Screen. The icon is this student's photo.</p>
		<p>One child installs as <strong>Quran</strong>. Each other child in the same family installs as <strong>Quran</strong> plus that child's first name<?php if ($install['name'] !== 'Quran'): ?>, so this one is <strong><?php echo html_escape($install['name']); ?></strong><?php endif; ?>.</p>
	</div>
	<?php if (empty($clips)): ?>
		<p>No sealed recitation is on this playlist yet.</p>
	<?php else: ?>
		<?php foreach ($clips as $clip): ?>
		<article class="clip">
			<strong><?php echo html_escape($clip['portion']); ?></strong>
			<div class="meta"><?php echo html_escape($clip['date']); ?> · <?php echo html_escape($clip['time']); ?> · <?php echo html_escape($clip['teacher']); ?></div>
			<audio controls preload="none" src="<?php echo html_escape($clip['audio']); ?>"></audio>
		</article>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<script>
if ('serviceWorker' in navigator) {
	navigator.serviceWorker.register('<?php echo base_url('quran/sw.js'); ?>', { scope: '<?php echo base_url('quran/'); ?>' });
}
var deferredPrompt = null;
window.addEventListener('beforeinstallprompt', function (event) {
	event.preventDefault();
	deferredPrompt = event;
});
document.getElementById('install_quran').addEventListener('click', function () {
	if (!deferredPrompt) {
		document.getElementById('install_note').textContent = 'If the button does not install, use the browser menu: Add to Home Screen. On iPhone that is Share, then Add to Home Screen.';
		return;
	}
	deferredPrompt.prompt();
	deferredPrompt.userChoice.then(function () { deferredPrompt = null; });
});
</script>
</body>
</html>
