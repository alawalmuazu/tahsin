<?php
$install = isset($install) ? $install : array('name' => 'Quran', 'short_name' => 'Quran', 'photo' => '', 'student_name' => 'Student', 'school_name' => 'Tahsin Academy', 'school_logo' => base_url('uploads/app_image/logo.png'));
$openPhoto = isset($install['photo']) ? $install['photo'] : '';
$showOpenPhoto = $openPhoto !== '' && strpos($openPhoto, 'defualt.png') === false;
$clips = isset($clips) ? $clips : array();
$manifest = isset($manifest) ? $manifest : '';
$token = isset($token) ? $token : '';
$clipsJson = json_encode($clips, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
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
<link rel="apple-touch-icon" href="<?php echo site_url('quran/' . $token . '/icon-192.png'); ?>">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Scheherazade+New:wght@400;700&display=swap">
<script>
window.__quranInstall = null;
window.__quranInstallWait = [];
window.__quranToken = <?php echo json_encode($token); ?>;
window.__quranStudent = <?php echo json_encode($install['student_name']); ?>;
window.__quranSchool = <?php echo json_encode($install['school_name']); ?>;
window.__quranLogo = <?php echo json_encode($install['school_logo']); ?>;
window.__quranPhoto = <?php echo json_encode($install['photo']); ?>;
window.__quranStart = <?php echo json_encode(site_url('quran/' . $token)); ?>;
window.__quranManifest = <?php echo json_encode($manifest); ?>;
function quranIsStandalone() {
	return (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches) || window.navigator.standalone === true;
}
function quranInstallKey() {
	return 'quran-app-' + window.__quranToken;
}
function quranMarkInstalled() {
	try { localStorage.setItem(quranInstallKey(), '1'); } catch (e) {}
	document.documentElement.classList.add('quran-installed');
}
function quranClearInstalled() {
	try { localStorage.removeItem(quranInstallKey()); } catch (e) {}
	if (!quranIsStandalone()) document.documentElement.classList.remove('quran-installed');
}
(function () {
	try {
		if (localStorage.getItem('quran-notify-' + window.__quranToken) === '1') {
			document.documentElement.classList.add('quran-notify-on');
		}
	} catch (e) {}
})();
(function () {
	if (quranIsStandalone()) {
		quranMarkInstalled();
		return;
	}
	try {
		if (localStorage.getItem(quranInstallKey()) === '1') document.documentElement.classList.add('quran-installed');
	} catch (e) {}
})();
window.addEventListener('beforeinstallprompt', function (event) {
	event.preventDefault();
	if (!quranIsStandalone()) quranClearInstalled();
	window.__quranInstall = event;
	var waiters = window.__quranInstallWait.splice(0);
	waiters.forEach(function (fn) { fn(event); });
	if (typeof window.__quranInstallReady === 'function') window.__quranInstallReady();
});
window.addEventListener('appinstalled', function () {
	quranMarkInstalled();
});
(function () {
	var saved = '';
	try { saved = localStorage.getItem('quran-theme') || ''; } catch (e) {}
	var theme = saved === 'dark' || saved === 'light'
		? saved
		: (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
	document.documentElement.setAttribute('data-theme', theme);
})();
(function () {
	var hear = /\/hear\/?$/.test(location.pathname) || /(?:\?|&)play=1(?:&|$)/.test(location.search) || location.hash === '#play';
	if (hear) document.documentElement.classList.add('hear');
	var installed = (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches) || window.navigator.standalone;
	if (!installed || hear) document.documentElement.classList.add('no-open');
})();
</script>
<style>
html[data-theme="light"]{color-scheme:light;--bg:#f4f7f5;--text:#10241e;--muted:#3d5c50;--card:#fff;--line:#d7e3dc;--mushaf:#fffdf8;--mushaf-line:#eadfc4;--mark:#b7ebc6;--num:#7a5b22;--num-line:#c4a15a;--soft:#f0fdfa;--photo:#d7e3dc;--accent:#0f766e;--bar:#f4f7f5}
html[data-theme="dark"]{color-scheme:dark;--bg:#101816;--text:#e8f3ee;--muted:#9bb5a8;--card:#1a2622;--line:#2d433b;--mushaf:#1c1812;--mushaf-line:#3a3224;--mark:#1f6b45;--num:#e6c98a;--num-line:#a6843d;--soft:#14332c;--photo:#24332d;--accent:#2dd4bf;--bar:#101816}
body{margin:0;background:var(--bg);color:var(--text);font-family:system-ui,sans-serif}
.wrap{max-width:520px;margin:0 auto;padding:1.25rem 1rem 3rem}
.head{display:flex;gap:.9rem;align-items:center}
.head img{width:72px;height:72px;border-radius:18px;object-fit:cover;background:var(--photo)}
h1{font-size:1.35rem;margin:0}
.sub{color:var(--muted);margin:.2rem 0 0;font-size:.92rem}
.theme{margin-left:auto;background:var(--card);color:var(--text);border:1px solid var(--line);border-radius:999px;padding:.45rem .8rem;font-weight:700;font-size:.82rem}
.install{margin:1rem 0;padding:1rem;background:var(--card);border-radius:14px;border:1px solid var(--line)}
.install button,.playall{background:#0f766e;color:#fff;border:0;border-radius:999px;padding:.7rem 1.1rem;font-weight:700;font-size:1rem}
.install p{margin:.6rem 0 0;font-size:.82rem;color:var(--muted)}
.mushaf{background:var(--mushaf);color:var(--text);border:1px solid var(--mushaf-line);border-radius:16px;padding:1.15rem 1rem 1.3rem;min-height:7.5rem;direction:rtl;text-align:center;font-family:"Scheherazade New","Traditional Arabic",serif;font-size:2.05rem;line-height:2.7}
.mushaf.empty{direction:ltr;text-align:left;font-family:system-ui,sans-serif;font-size:.92rem;line-height:1.45;color:var(--muted)}
.w{border-radius:.35em;padding:0 .04em}
.w.on{background:var(--mark)}
.num{display:inline-flex;align-items:center;justify-content:center;min-width:1.35em;height:1.35em;margin:0 .15em;border:1px solid var(--num-line);border-radius:999px;font-family:system-ui,sans-serif;font-size:.72rem;line-height:1;color:var(--num);vertical-align:middle}
.player{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:.9rem 1rem;margin:.75rem 0}
.now-title{font-weight:700}
.meta{color:var(--muted);font-size:.82rem;margin:.2rem 0 .55rem}
.seek{width:100%;accent-color:#0f766e}
.times{display:flex;justify-content:space-between;font-size:.75rem;color:var(--muted);margin:.15rem 0 .55rem}
.transport{display:flex;gap:.35rem;flex-wrap:wrap;align-items:center}
.transport button{background:var(--card);color:var(--text);border:1px solid var(--line);border-radius:999px;padding:.5rem .7rem;font-weight:700;font-size:.82rem}
.transport button.on{background:var(--soft);border-color:#0f766e;color:#0f766e}
html[data-theme="dark"] .transport button.on{color:var(--accent);border-color:var(--accent)}
.transport .go{background:#0f766e;color:#fff;border-color:#0f766e;min-width:4.2rem}
.playall{display:block;width:100%;margin-top:.55rem}
.share-rec{display:block;width:100%;margin-top:.45rem;background:transparent;color:var(--text);border:1px solid #0f766e;border-radius:999px;padding:.7rem 1.1rem;font-weight:700;font-size:1rem}
.share-full{display:block;width:100%;margin-top:.4rem;background:transparent;color:var(--muted);border:1px solid var(--line);border-radius:999px;padding:.65rem 1.1rem;font-weight:700;font-size:.95rem}
.share-rec:disabled,.share-full:disabled{opacity:.72}
.share-canvas{position:fixed;right:0;bottom:0;width:180px;height:320px;opacity:0;pointer-events:none;z-index:-1}
.share-note{margin:.4rem 0 0;font-size:.78rem;color:var(--muted);text-align:center}
.share-film{position:fixed;inset:0;z-index:60;display:none;align-items:center;justify-content:center;padding:1.25rem;background:rgba(16,24,22,.94);color:#f6f1e6;text-align:center}
.share-film.on{display:flex}
.share-film canvas{width:min(260px,70vw);height:auto;border-radius:18px;margin-bottom:.85rem;box-shadow:0 16px 40px rgba(0,0,0,.35)}
.share-film strong{display:block;font-size:1.05rem}
.share-film .pct{margin:.2rem 0 0;font-size:2.15rem;font-weight:800;letter-spacing:-.03em;color:#f6f1e6}
.share-meter{height:8px;width:min(220px,62vw);margin:.55rem auto 0;border-radius:999px;background:#1c332b;overflow:hidden}
.share-meter span{display:block;height:100%;width:0;background:#1f6b4a}
.share-film p{margin:.35rem 0 0;color:#b7c4bb;font-size:.85rem}
.share-go{margin-top:.85rem;background:#1f6b4a;color:#f6f1e6;border:0;border-radius:999px;padding:.75rem 1.4rem;font-weight:700;font-size:1rem}
.queue{margin-top:.25rem}
.clip{display:block;width:100%;text-align:left;background:var(--card);border-radius:14px;padding:.85rem 1rem;margin:0 0 .55rem;border:1px solid var(--line);font:inherit;color:inherit;cursor:pointer}
.clip.on{border-color:#0f766e;background:var(--soft)}
html[data-theme="dark"] .clip.on{border-color:var(--accent)}
.clip strong{display:block}
.open{position:fixed;inset:0;z-index:40;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2.5rem 1.75rem calc(4.5rem + env(safe-area-inset-bottom));overflow:hidden;background:#10241e;color:#f6f1e6;text-align:center}
.open.off{opacity:0;pointer-events:none;transition:opacity .5s ease}
.open-glow{position:absolute;top:30%;left:50%;width:min(340px,86vw);height:min(340px,86vw);border-radius:50%;background:radial-gradient(circle, rgba(228,201,138,.28), transparent 68%);pointer-events:none;animation:open-breathe 4.2s ease-in-out infinite}
.open-crest{position:relative;display:flex;align-items:center;justify-content:center;animation:open-float 4.4s ease-in-out 1.05s infinite}
.open-ring{position:absolute;width:78%;aspect-ratio:1;border-radius:50%;border:1px solid rgba(228,201,138,.75);animation:open-ring 1.25s ease .2s both}
.open-logo{position:relative;width:min(188px,44vw);height:auto;object-fit:contain;filter:drop-shadow(0 16px 26px rgba(0,0,0,.38));animation:open-logo .9s cubic-bezier(.2,.75,.2,1) both}
.open-school{max-width:16rem;margin:1.05rem 0 0;font-size:.74rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:#e4c98a;line-height:1.5;animation:open-track .85s ease .4s both}
.open-rule{width:72px;height:1px;margin:1.05rem 0 1.15rem;transform-origin:center;background:linear-gradient(90deg, transparent, #e4c98a, transparent);animation:open-draw .7s ease .62s both}
.open-photo{width:86px;height:86px;margin:0 0 .9rem;border-radius:50%;object-fit:cover;border:2px solid #e4c98a;box-shadow:0 12px 26px rgba(0,0,0,.32);animation:open-pop .7s cubic-bezier(.2,.8,.2,1) .72s both}
.open-student{max-width:18rem;margin:0;font-size:1.85rem;font-weight:700;letter-spacing:.01em;line-height:1.15;animation:open-name .75s ease .82s both}
.open-sub{margin:.6rem 0 0;font-size:.84rem;color:#b7c4bb;letter-spacing:.04em;animation:open-rise .6s ease .98s both}
.open-hint{margin:1.35rem 0 0;font-size:.68rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:rgba(228,201,138,.8);animation:open-rise .6s ease 1.2s both}
.open-bar{position:absolute;left:22%;right:22%;bottom:calc(1.35rem + env(safe-area-inset-bottom));height:2px;border-radius:99px;background:rgba(228,201,138,.18);overflow:hidden}
.open-bar span{display:block;height:100%;width:0;background:#e4c98a;animation:open-bar 3.6s linear both}
@keyframes open-breathe{0%,100%{opacity:.45;transform:translate(-50%,-42%) scale(.9)}50%{opacity:1;transform:translate(-50%,-42%) scale(1.08)}}
@keyframes open-float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
@keyframes open-ring{0%{opacity:0;transform:scale(.45)}35%{opacity:1}100%{opacity:0;transform:scale(1.45)}}
@keyframes open-logo{from{opacity:0;transform:scale(.72) translateY(18px)}to{opacity:1;transform:none}}
@keyframes open-track{from{opacity:0;letter-spacing:.48em}to{opacity:1;letter-spacing:.22em}}
@keyframes open-draw{from{opacity:0;transform:scaleX(0)}to{opacity:1;transform:scaleX(1)}}
@keyframes open-pop{from{opacity:0;transform:scale(.72)}to{opacity:1;transform:none}}
@keyframes open-name{from{opacity:0;transform:translateY(16px);filter:blur(6px)}to{opacity:1;transform:none;filter:none}}
@keyframes open-rise{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
@keyframes open-bar{to{width:100%}}
@media (prefers-reduced-motion:reduce){
.open-glow,.open-crest,.open-ring,.open-logo,.open-school,.open-rule,.open-photo,.open-student,.open-sub,.open-hint,.open-bar span{animation:none}
.open-bar span{width:100%}
}
html.no-open .open{display:none}
html.quran-installed .install:not(.notify),html.hear .install:not(.notify){display:none}
html.quran-notify-on .notify{display:none}
.notify-off{display:none;margin:0 0 .85rem;background:transparent;color:var(--muted);border:0;padding:0;font-size:.82rem;font-weight:700;text-decoration:underline}
html.quran-notify-on .notify-off{display:inline-block}
.ayah-row{display:flex;flex-wrap:wrap;gap:.4rem;justify-content:center;margin:.15rem 0 .85rem}
.ayah-row button{min-width:2.15rem;height:2.15rem;padding:0 .45rem;border-radius:999px;border:1px solid var(--num-line);background:transparent;color:var(--num);font-weight:700}
.ayah-row button.lit{background:#0f766e;color:#fff;border-color:#0f766e}
.hear-go{display:none}
html.hear .hear-go{display:block;width:100%;margin:.35rem 0 .85rem;background:#0f766e;color:#fff;border:0;border-radius:999px;padding:.9rem 1rem;font-weight:700;font-size:1.05rem}
html.hear .hear-go.gone{display:none}
</style>
</head>
<body>
<div id="open_screen" class="open">
	<div class="open-glow"></div>
	<div class="open-crest">
		<span class="open-ring"></span>
		<img class="open-logo" src="<?php echo html_escape($install['school_logo']); ?>" alt="">
	</div>
	<p class="open-school"><?php echo html_escape($install['school_name']); ?></p>
	<div class="open-rule"></div>
	<?php if ($showOpenPhoto): ?>
	<img class="open-photo" src="<?php echo html_escape($openPhoto); ?>" alt="">
	<?php endif; ?>
	<h1 class="open-student"><?php echo html_escape($install['student_name']); ?></h1>
	<p class="open-sub">Sealed recitations</p>
	<p class="open-hint">Tap to continue</p>
	<div class="open-bar" aria-hidden="true"><span></span></div>
</div>
<script>
(function () {
	var el = document.getElementById('open_screen');
	if (!el || document.documentElement.classList.contains('no-open')) return;
	function close() {
		if (!el || el.classList.contains('off')) return;
		el.classList.add('off');
		setTimeout(function () { if (el.parentNode) el.parentNode.removeChild(el); }, 400);
	}
	el.addEventListener('click', close);
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	setTimeout(close, reduce ? 1400 : 3600);
})();
</script>
<div class="wrap">
	<div class="head">
		<img src="<?php echo html_escape($install['photo']); ?>" alt="">
		<div>
			<h1><?php echo html_escape($install['student_name']); ?></h1>
			<p class="sub">Sealed recitations</p>
		</div>
		<button type="button" id="theme_toggle" class="theme">Dark</button>
	</div>
	<?php if (!empty($vapid_public)): ?>
	<div class="install notify" id="notify_box">
		<button type="button" id="notify_on">Turn On Notification</button>
		<p id="notify_note">When an admin acknowledges a session that includes this child, this phone shows a notification. Tap the notification to hear the recording.</p>
	</div>
	<button type="button" id="notify_off" class="notify-off">Turn off notification</button>
	<?php endif; ?>
	<div class="install">
		<button type="button" id="install_quran">Install <?php echo html_escape($install['name']); ?></button>
		<p id="install_note">Tap Install Quran, then confirm the question Chrome shows. The icon is this student's photo.</p>
		<p>One child installs as <strong>Quran</strong>. Each other child in the same family installs as <strong>Quran</strong> plus that child's first name<?php if ($install['name'] !== 'Quran'): ?>, so this one is <strong><?php echo html_escape($install['name']); ?></strong><?php endif; ?>.</p>
	</div>
	<?php if (empty($clips)): ?>
		<p>No sealed recitation is on this playlist yet.</p>
	<?php else: ?>
	<div id="ayah_row" class="ayah-row" hidden></div>
	<button type="button" id="hear_go" class="hear-go">Hear this recitation</button>
	<div id="mushaf" class="mushaf empty">Choose a recording. Its ayahs appear here and light up as it plays.</div>
	<div class="player">
		<div class="now-title" id="now_title"><?php echo html_escape($clips[0]['portion']); ?></div>
		<div class="meta" id="now_meta"><?php echo html_escape($clips[0]['date'] . ' · ' . $clips[0]['time'] . ' · Contact us 08021211053'); ?></div>
		<input id="seek" class="seek" type="range" min="0" max="1000" value="0" aria-label="Position in this recording">
		<div class="times"><span id="time_now">0:00</span><span id="time_end">0:00</span></div>
		<div class="transport">
			<button type="button" id="btn_shuffle">Shuffle</button>
			<button type="button" id="btn_prev">Previous</button>
			<button type="button" id="btn_play" class="go">Play</button>
			<button type="button" id="btn_next">Next</button>
			<button type="button" id="btn_repeat">Repeat</button>
			<button type="button" id="btn_speed">Speed 1×</button>
		</div>
		<button type="button" id="btn_all" class="playall">Play all</button>
		<button type="button" id="btn_share" class="share-rec">Status 0%</button>
		<button type="button" id="btn_full" class="share-full">Full video</button>
		<p id="share_note" class="share-note">Share for Status is a short video. Share full keeps the whole recitation.</p>
	</div>
	<div class="queue" id="queue"></div>
	<audio id="qpl_audio" preload="metadata"></audio>
	<canvas id="share_canvas" class="share-canvas" width="720" height="1280" aria-hidden="true"></canvas>
	<div id="share_film" class="share-film" aria-live="polite">
		<div>
			<strong id="share_film_title">Making the video</strong>
			<p id="share_film_pct" class="pct">0%</p>
			<div class="share-meter"><span id="share_film_bar"></span></div>
			<p id="share_film_note">Please wait. Your apps open at 100%.</p>
			<button type="button" id="share_film_go" class="share-go" hidden>Share video</button>
		</div>
	</div>
	<script type="application/json" id="qpl_data"><?php echo $clipsJson; ?></script>
	<?php endif; ?>
</div>
<script>
if ('serviceWorker' in navigator) {
	var quranSwScope = '<?php echo base_url('quran/'); ?>';
	navigator.serviceWorker.register('<?php echo base_url('quran/sw.js'); ?>?v=6', { scope: quranSwScope, updateViaCache: 'none' }).then(function (reg) {
		return navigator.serviceWorker.ready.then(function () {
			var worker = reg.active || navigator.serviceWorker.controller;
			if (!worker) return;
			var ctrl = navigator.serviceWorker.controller;
			if (!ctrl || ctrl.scriptURL.indexOf('quran/sw.js') === -1) {
				worker.postMessage({ type: 'claim' });
			}
			var warmed = false;
			try { warmed = sessionStorage.getItem('quran-sw-v6') === '1'; } catch (e) {}
			if (warmed) return;
			var channel = new MessageChannel();
			var settled = false;
			function finish(reload) {
				if (settled) return;
				settled = true;
				var marked = false;
				try {
					sessionStorage.setItem('quran-sw-v6', '1');
					marked = sessionStorage.getItem('quran-sw-v6') === '1';
				} catch (e2) {}
				if (reload && marked) window.location.reload();
			}
			channel.port1.onmessage = function () { finish(true); };
			worker.postMessage({ type: 'cache', url: window.location.href }, [channel.port2]);
			setTimeout(function () { finish(false); }, 5000);
		});
	}).catch(function () {});
}
function applyTheme(theme) {
	document.documentElement.setAttribute('data-theme', theme);
	var meta = document.querySelector('meta[name="theme-color"]');
	if (meta) meta.setAttribute('content', theme === 'dark' ? '#101816' : '#f4f7f5');
	var toggle = document.getElementById('theme_toggle');
	if (toggle) toggle.textContent = theme === 'dark' ? 'Light' : 'Dark';
	try { localStorage.setItem('quran-theme', theme); } catch (e) {}
}
applyTheme(document.documentElement.getAttribute('data-theme') || 'light');
document.getElementById('theme_toggle').addEventListener('click', function () {
	applyTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
});
function quranInstallHelp() {
	var ios = /iphone|ipad|ipod/i.test(navigator.userAgent || '');
	if (ios) return 'On iPhone, tap Share, then Add to Home Screen. Quran appears on the home screen after you confirm.';
	return 'Nothing was added yet. Tap the three dots at the top right, then Install app or Add to Home screen, and confirm. Look for Quran on the home screen. Turn VPN off if the icon does not appear.';
}
function quranRunInstall(event) {
	var note = document.getElementById('install_note');
	note.textContent = 'Confirm the question Chrome shows. Quran is added only after you confirm.';
	var pending;
	try { pending = event.prompt(); } catch (e) { pending = Promise.reject(e); }
	Promise.resolve(pending).then(function () {
		return event.userChoice;
	}).then(function (result) {
		window.__quranInstall = null;
		if (result && result.outcome === 'accepted') {
			quranMarkInstalled();
			return;
		}
		note.textContent = 'Install was cancelled. Tap Install Quran to try again.';
	}).catch(function () {
		window.__quranInstall = event;
		note.textContent = 'Tap Install Quran again, then confirm the question Chrome shows.';
	});
}
window.__quranInstallReady = function () {
	var note = document.getElementById('install_note');
	if (!note || window.__quranInstallPrompted) return;
	note.textContent = 'Chrome is ready. Tap Install Quran, then confirm.';
};
if (navigator.getInstalledRelatedApps) {
	navigator.getInstalledRelatedApps().then(function (apps) {
		if (quranIsStandalone()) return;
		var found = false;
		for (var i = 0; i < apps.length; i++) {
			if (apps[i].platform === 'webapp' && (apps[i].id === window.__quranStart || apps[i].url === window.__quranManifest)) found = true;
		}
		if (found) quranMarkInstalled();
	}).catch(function () {});
}
document.getElementById('install_quran').addEventListener('click', function () {
	var note = document.getElementById('install_note');
	if (window.top !== window.self) {
		window.open(window.location.href, '_blank', 'noopener');
		note.textContent = 'Install opens in the new tab. Press Install Quran there.';
		return;
	}
	if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) {
		note.textContent = 'Quran is already on this home screen.';
		return;
	}
	if (window.__quranInstall) {
		window.__quranInstallPrompted = true;
		quranRunInstall(window.__quranInstall);
		return;
	}
	note.textContent = quranInstallHelp();
	window.__quranInstallWait.push(function () {
		note.textContent = 'Chrome is ready. Tap Install Quran again, then confirm.';
	});
});
(function () {
	var btn = document.getElementById('notify_on');
	var note = document.getElementById('notify_note');
	if (!btn || !note) return;
	var key = <?php echo json_encode(isset($vapid_public) ? $vapid_public : ''); ?>;
	var url = <?php echo json_encode(site_url('quran/' . $token . '/notify')); ?>;
	var store = 'quran-notify-' + window.__quranToken;
	function ios() {
		return /iphone|ipad|ipod/i.test(navigator.userAgent || '');
	}
	var offBtn = document.getElementById('notify_off');
	function remember() {
		try { localStorage.setItem(store, '1'); } catch (e) {}
	}
	function saved() {
		try { return localStorage.getItem(store) === '1'; } catch (e) { return false; }
	}
	function markOn() {
		remember();
		document.documentElement.classList.add('quran-notify-on');
	}
	function showPrompt() {
		try { localStorage.removeItem(store); } catch (e) {}
		document.documentElement.classList.remove('quran-notify-on');
		btn.disabled = false;
		btn.textContent = 'Turn On Notification';
		if (offBtn) offBtn.disabled = false;
	}
	function dropThisChild() {
		if (!('serviceWorker' in navigator) || !navigator.serviceWorker.getRegistration) {
			return Promise.resolve();
		}
		return navigator.serviceWorker.getRegistration().then(function (reg) {
			if (!reg || !reg.pushManager) return;
			return reg.pushManager.getSubscription();
		}).then(function (sub) {
			if (!sub) return;
			return fetch(url, {
				method: 'DELETE',
				headers: { 'Content-Type': 'application/json' },
				credentials: 'same-origin',
				body: JSON.stringify({ endpoint: sub.endpoint })
			});
		}).catch(function () {});
	}
	function keyBytes(b64) {
		var padding = '='.repeat((4 - b64.length % 4) % 4);
		var base64 = (b64 + padding).replace(/-/g, '+').replace(/_/g, '/');
		var raw = atob(base64);
		var out = new Uint8Array(raw.length);
		var i;
		for (i = 0; i < raw.length; i++) out[i] = raw.charCodeAt(i);
		return out;
	}
	function subscribe() {
		if (!key || !('serviceWorker' in navigator) || !('PushManager' in window)) {
			note.textContent = (ios() && !quranIsStandalone())
				? 'On iPhone, install the app first, open it from the home screen, then tap Turn On Notification.'
				: 'This phone cannot show these alerts.';
			btn.disabled = false;
			return Promise.resolve();
		}
		return navigator.serviceWorker.ready.then(function (reg) {
			return reg.pushManager.getSubscription().then(function (existing) {
				if (existing) return existing;
				return reg.pushManager.subscribe({ userVisibleOnly: true, applicationServerKey: keyBytes(key) });
			});
		}).then(function (sub) {
			return fetch(url, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				credentials: 'same-origin',
				body: JSON.stringify(sub)
			});
		}).then(function (res) {
			return res.json().then(function (data) {
				if (!res.ok || !data || !data.ok) throw new Error('save');
				markOn();
			});
		});
	}
	btn.addEventListener('click', function () {
		if (ios() && !quranIsStandalone()) {
			note.textContent = 'On iPhone, install the app first, open it from the home screen, then tap Turn On Notification.';
			return;
		}
		if (!window.Notification || !key) {
			note.textContent = 'This phone cannot show these alerts.';
			return;
		}
		btn.disabled = true;
		note.textContent = 'Allow notifications when the phone asks.';
		Promise.resolve(Notification.requestPermission()).then(function (result) {
			if (result !== 'granted') {
				btn.disabled = false;
				note.textContent = 'Notifications are blocked. Allow them for this app in the phone settings, then tap the button again.';
				return;
			}
			return subscribe();
		}).catch(function () {
			btn.disabled = false;
			note.textContent = 'The alert could not be turned on. Open the installed app and try again.';
		});
	});
	if (offBtn) {
		offBtn.addEventListener('click', function () {
			offBtn.disabled = true;
			dropThisChild().then(function () { showPrompt(); });
		});
	}
	if (navigator.permissions && navigator.permissions.query) {
		navigator.permissions.query({ name: 'notifications' }).then(function (status) {
			status.onchange = function () {
				if (status.state !== 'granted') showPrompt();
			};
		}).catch(function () {});
	}
	if (!saved()) return;
	if (!window.Notification || Notification.permission !== 'granted' || !('serviceWorker' in navigator) || !('PushManager' in window)) {
		showPrompt();
		return;
	}
	navigator.serviceWorker.getRegistration().then(function (reg) {
		if (!reg || !reg.pushManager) {
			showPrompt();
			return;
		}
		return reg.pushManager.getSubscription().then(function (sub) {
			if (!sub) {
				showPrompt();
				return;
			}
			markOn();
			fetch(url, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				credentials: 'same-origin',
				body: JSON.stringify(sub)
			}).catch(function () {});
		});
	}).catch(function () { showPrompt(); });
})();
</script>
<?php if (!empty($clips)): ?>
<script>
(function () {
	var clips = JSON.parse(document.getElementById('qpl_data').textContent);
	var audio = document.getElementById('qpl_audio');
	var mushaf = document.getElementById('mushaf');
	var order = clips.map(function (_, i) { return i; });
	var pos = 0;
	var shuffled = false;
	var repeat = 'off';
	var speeds = [0.75, 1, 1.25, 1.5];
	var speedAt = 1;
	var words = [];
	var active = -1;
	var timings = null;
	var timingToken = 0;
	var timingCache = {};
	var audioBufCache = {};
	var audioCtx = null;
	var seeking = false;
	var frame = 0;
	var surahCache = {};
	var skips = 0;

	function clock(sec) {
		sec = Math.max(0, Math.floor(sec || 0));
		var m = Math.floor(sec / 60);
		var s = sec % 60;
		return m + ':' + (s < 10 ? '0' : '') + s;
	}

	function currentIndex() {
		return order[pos];
	}

	function renderQueue() {
		var box = document.getElementById('queue');
		box.innerHTML = '';
		order.forEach(function (clipIndex, place) {
			var clip = clips[clipIndex];
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'clip' + (place === pos ? ' on' : '');
			btn.innerHTML = '<strong></strong><div class="meta"></div>';
			btn.querySelector('strong').textContent = clip.portion;
			btn.querySelector('.meta').textContent = clip.date + ' · ' + clip.time + ' · Contact us 08021211053';
			btn.addEventListener('click', function () {
				pos = place;
				playClip(true);
			});
			box.appendChild(btn);
		});
	}

	function paintButtons() {
		document.getElementById('btn_shuffle').classList.toggle('on', shuffled);
		document.getElementById('btn_shuffle').textContent = shuffled ? 'Shuffling' : 'Shuffle';
		var repeatBtn = document.getElementById('btn_repeat');
		repeatBtn.classList.toggle('on', repeat !== 'off');
		repeatBtn.textContent = repeat === 'one' ? 'Repeat 1' : (repeat === 'all' ? 'Repeat all' : 'Repeat');
		document.getElementById('btn_speed').textContent = 'Speed ' + speeds[speedAt] + '×';
		document.getElementById('btn_play').textContent = audio.paused ? 'Play' : 'Pause';
	}

	var pendingShareFile = null;
	var shareKey = '';
	function showMeta(clip) {
		document.getElementById('now_title').textContent = clip.portion;
		document.getElementById('now_meta').textContent = (pos + 1) + ' of ' + order.length + ' · ' + clip.date + ' · ' + clip.time + ' · Contact us 08021211053';
		paintAyahRow(clip);
		if (shareKey !== clip.audio) startShareJobs(clip);
	}

	function paintAyahRow(clip) {
		var row = document.getElementById('ayah_row');
		if (!row || !clip) return;
		var from = Number(clip.from) || 0;
		var to = Number(clip.to) || from;
		row.innerHTML = '';
		if (!from || to < from) {
			row.hidden = true;
			return;
		}
		if (to - from > 40) to = from + 40;
		row.hidden = false;
		var n;
		for (n = from; n <= to; n++) {
			var cell = document.createElement('button');
			cell.type = 'button';
			cell.textContent = String(n);
			cell.addEventListener('click', function () { playClip(true); });
			row.appendChild(cell);
		}
		lightAyah(!audio.paused);
	}

	function lightAyah(on) {
		var row = document.getElementById('ayah_row');
		if (!row) return;
		var cells = row.querySelectorAll('button');
		var i;
		for (i = 0; i < cells.length; i++) cells[i].classList.toggle('lit', !!on);
	}

	function fetchSurah(num) {
		if (surahCache[num]) return surahCache[num];
		surahCache[num] = fetch('https://api.alquran.cloud/v1/surah/' + num + '/quran-uthmani')
			.then(function (res) { return res.json(); })
			.then(function (data) {
				if (!data || !data.data || !data.data.ayahs) throw new Error('text');
				return data.data.ayahs;
			});
		return surahCache[num];
	}

	function renderText(clip) {
		words = [];
		active = -1;
		mushaf.className = 'mushaf empty';
		if (!clip.surah) {
			mushaf.textContent = 'This recording has no ayah range to show.';
			return;
		}
		mushaf.textContent = 'Loading the ayah…';
		fetchSurah(clip.surah).then(function (ayahs) {
			if (clips[currentIndex()] !== clip) return;
			var from = clip.from || 1;
			var to = clip.to || from;
			var slice = ayahs.filter(function (a) {
				var n = Number(a.numberInSurah);
				return n >= from && n <= to;
			});
			mushaf.innerHTML = '';
			mushaf.className = 'mushaf';
			slice.forEach(function (a) {
				var line = document.createElement('span');
				line.className = 'ayah';
				String(a.text || '').trim().split(/\s+/).filter(Boolean).forEach(function (word) {
					var span = document.createElement('span');
					span.className = 'w';
					span.textContent = word + ' ';
					line.appendChild(span);
					words.push(span);
				});
				var num = document.createElement('span');
				num.className = 'num';
				num.textContent = a.numberInSurah;
				line.appendChild(num);
				mushaf.appendChild(line);
			});
			if (!words.length) {
				mushaf.className = 'mushaf empty';
				mushaf.textContent = 'This portion has no Arabic text to show.';
				return;
			}
			armTimings(clip);
		}).catch(function () {
			if (clips[currentIndex()] !== clip) return;
			mushaf.className = 'mushaf empty';
			mushaf.textContent = 'The Arabic text could not load. The recording still plays.';
		});
	}

	function arabicWeight(word) {
		var bare = String(word || '').replace(/[\u064B-\u0652\u0670\u0640\u06D6-\u06ED]/g, '');
		var letters = bare.replace(/[^\u0621-\u064A]/g, '');
		return Math.max(1, letters.length || String(word || '').trim().length || 1);
	}

	function buildTimings(buffer, wordsOrCount) {
		var texts = Array.isArray(wordsOrCount) ? wordsOrCount : [];
		var wordCount = texts.length || (typeof wordsOrCount === 'number' ? wordsOrCount : 0);
		if (!buffer || wordCount < 1) return null;
		var weights = [];
		var i;
		for (i = 0; i < wordCount; i++) weights.push(texts.length ? arabicWeight(texts[i]) : 1);
		var total = 0;
		for (i = 0; i < weights.length; i++) total += weights[i];
		if (!total) total = wordCount;
		var channel = buffer.getChannelData(0);
		var rate = buffer.sampleRate || 44100;
		var hop = Math.max(1, Math.floor(rate * 0.01));
		var energies = [];
		var times = [];
		for (i = 0; i + hop <= channel.length; i += hop) {
			var sum = 0;
			var j;
			var end = Math.min(channel.length, i + hop);
			for (j = i; j < end; j++) {
				var sample = channel[j];
				sum += sample * sample;
			}
			var n = Math.max(1, end - i);
			energies.push(Math.sqrt(sum / n));
			times.push(i / rate);
		}
		if (energies.length < 4) return null;
		var smooth = [];
		for (i = 0; i < energies.length; i++) {
			var acc = 0;
			var count = 0;
			var k;
			for (k = i - 2; k <= i + 2; k++) {
				if (k < 0 || k >= energies.length) continue;
				acc += energies[k];
				count++;
			}
			smooth.push(acc / count);
		}
		var sorted = smooth.slice().sort(function (a, b) { return a - b; });
		function atPct(p) {
			return sorted[Math.min(sorted.length - 1, Math.max(0, Math.floor((sorted.length - 1) * p)))] || 0;
		}
		var duration = channel.length / rate;
		var noise = atPct(0.08);
		var loud = atPct(0.9);
		function speechEdges(level) {
			var from = -1;
			var to = -1;
			var n;
			for (n = 0; n < smooth.length; n++) {
				if (smooth[n] >= level) {
					if (from < 0) from = n;
					to = n;
				}
			}
			return { from: from, to: to };
		}
		var thresh = Math.max(0.0025, noise + Math.max(0, loud - noise) * 0.1);
		var edges = speechEdges(thresh);
		if (edges.from < 0 || edges.to <= edges.from) {
			thresh = Math.max(0.002, loud * 0.08);
			edges = speechEdges(thresh);
		}
		var speechStart = edges.from < 0 ? 0 : times[edges.from];
		var speechEnd = edges.to < 0 ? duration : (times[edges.to] + (hop / rate));
		if (speechEnd - speechStart < Math.max(0.4, duration * 0.55)) {
			thresh = Math.max(0.0018, Math.min(thresh, loud * 0.05));
			edges = speechEdges(thresh);
			if (edges.from >= 0 && edges.to > edges.from) {
				speechStart = times[edges.from];
				speechEnd = times[edges.to] + (hop / rate);
			}
		}
		if (speechEnd - speechStart < 0.2) {
			speechStart = 0;
			speechEnd = duration;
		}
		var runs = [];
		var runStart = -1;
		for (i = 0; i < smooth.length; i++) {
			var at = times[i];
			if (at < speechStart - 0.02 || at > speechEnd + 0.02) continue;
			if (smooth[i] >= thresh) {
				if (runStart < 0) runStart = i;
			} else if (runStart >= 0) {
				runs.push({ a: runStart, b: i });
				runStart = -1;
			}
		}
		if (runStart >= 0) runs.push({ a: runStart, b: smooth.length - 1 });
		var pieces = [];
		for (i = 0; i < runs.length; i++) {
			var runDur = times[Math.min(runs[i].b, times.length - 1)] - times[runs[i].a];
			if (runDur < 0.06) continue;
			var piece = {
				start: times[runs[i].a],
				end: times[Math.min(runs[i].b, times.length - 1)] + (hop / rate)
			};
			if (pieces.length && piece.start - pieces[pieces.length - 1].end < 0.14) {
				pieces[pieces.length - 1].end = piece.end;
				continue;
			}
			pieces.push(piece);
		}
		if (!pieces.length) pieces.push({ start: speechStart, end: speechEnd });
		while (pieces.length > wordCount) {
			var joinAt = 0;
			var joinGap = Infinity;
			for (i = 0; i < pieces.length - 1; i++) {
				var gap = pieces[i + 1].start - pieces[i].end;
				if (gap < joinGap) {
					joinGap = gap;
					joinAt = i;
				}
			}
			pieces[joinAt].end = pieces[joinAt + 1].end;
			pieces.splice(joinAt, 1);
		}
		function quietCut(from, to, guess) {
			var lo = Math.max(from + 0.05, guess - 0.35);
			var hi = Math.min(to - 0.05, guess + 0.35);
			if (hi <= lo) return Math.min(to - 0.05, Math.max(from + 0.05, guess));
			var bestT = guess;
			var bestE = Infinity;
			var f;
			for (f = 0; f < times.length; f++) {
				if (times[f] < lo || times[f] > hi) continue;
				if (smooth[f] < bestE) {
					bestE = smooth[f];
					bestT = times[f];
				}
			}
			var cut = bestT;
			for (f = 0; f < times.length; f++) {
				if (times[f] < bestT || times[f] > hi) continue;
				if (smooth[f] >= thresh && times[f] > bestT + 0.04) {
					cut = times[f];
					break;
				}
			}
			if (cut <= from + 0.04) cut = from + 0.05;
			if (cut >= to - 0.04) cut = to - 0.05;
			return cut;
		}
		var counts = [];
		var remainWords = wordCount;
		var remainTime = 0;
		for (i = 0; i < pieces.length; i++) remainTime += Math.max(0.05, pieces[i].end - pieces[i].start);
		for (i = 0; i < pieces.length; i++) {
			var pieceDur = Math.max(0.05, pieces[i].end - pieces[i].start);
			var share = 0;
			if (remainWords > 0) {
				share = (i === pieces.length - 1) ? remainWords : Math.max(1, Math.round((pieceDur / remainTime) * remainWords));
				if (share > remainWords) share = remainWords;
				if (share < 1) share = 1;
			}
			counts.push(share);
			remainWords -= share;
			remainTime -= pieceDur;
		}
		if (remainWords > 0) counts[counts.length - 1] += remainWords;
		var built = [];
		var wordAt = 0;
		for (i = 0; i < pieces.length; i++) {
			var take = counts[i] || 0;
			if (take < 1) continue;
			var sliceWeights = weights.slice(wordAt, wordAt + take);
			var weightSum = 0;
			var s;
			for (s = 0; s < sliceWeights.length; s++) weightSum += sliceWeights[s];
			if (!weightSum) weightSum = take;
			var cursorT = pieces[i].start;
			var grown = 0;
			for (s = 0; s < take; s++) {
				grown += sliceWeights[s] || 1;
				var edge = (s === take - 1)
					? pieces[i].end
					: pieces[i].start + (grown / weightSum) * (pieces[i].end - pieces[i].start);
				if (s < take - 1) edge = quietCut(cursorT, pieces[i].end, edge);
				built.push({ start: cursorT, end: edge });
				cursorT = edge;
			}
			wordAt += take;
		}
		while (built.length < wordCount) built.push({ start: speechEnd, end: speechEnd + 0.05 });
		if (built.length > wordCount) built = built.slice(0, wordCount);
		for (i = 0; i < built.length - 1; i++) built[i].end = built[i + 1].start;
		var covered = built[built.length - 1].end - built[0].start;
		if (duration > 1 && covered < duration * 0.62) {
			var origin = built[0].start;
			var scale = (Math.max(speechEnd, duration * 0.92) - origin) / Math.max(0.2, covered);
			for (i = 0; i < built.length; i++) {
				built[i].start = origin + (built[i].start - origin) * scale;
				built[i].end = origin + (built[i].end - origin) * scale;
			}
		}
		return built;
	}

	function loadAudioBuffer(url) {
		if (audioBufCache[url]) return audioBufCache[url];
		if (!audioCtx) {
			var Ctx = window.AudioContext || window.webkitAudioContext;
			if (!Ctx) {
				audioBufCache[url] = Promise.resolve(null);
				return audioBufCache[url];
			}
			audioCtx = new Ctx();
		}
		audioBufCache[url] = fetch(url)
			.then(function (res) { return res.arrayBuffer(); })
			.then(function (buf) { return audioCtx.decodeAudioData(buf); })
			.catch(function () { return null; });
		return audioBufCache[url];
	}

	function decodeTimings(url, wordsOrCount) {
		var texts = Array.isArray(wordsOrCount) ? wordsOrCount : [];
		var wordCount = texts.length || (typeof wordsOrCount === 'number' ? wordsOrCount : 0);
		var key = url + '|v4|' + (texts.length ? texts.join('\u0001') : String(wordCount));
		if (timingCache[key]) return timingCache[key];
		timingCache[key] = loadAudioBuffer(url).then(function (decoded) {
			if (!decoded) return null;
			return buildTimings(decoded, texts.length ? texts : wordCount);
		});
		return timingCache[key];
	}

	function armTimings(clip) {
		var token = ++timingToken;
		var count = words.length;
		timings = null;
		if (!count) return;
		var texts = [];
		var wi;
		for (wi = 0; wi < words.length; wi++) texts.push((words[wi].textContent || '').trim());
		decodeTimings(clip.audio, texts).then(function (built) {
			if (token !== timingToken || clips[currentIndex()] !== clip) return;
			timings = built;
			highlight(audio.currentTime || 0);
		});
	}

	function wordAt(t) {
		if (!timings || !timings.length) return -1;
		if (t < timings[0].start) return -1;
		var last = timings.length - 1;
		if (t >= timings[last].end) return -1;
		var i;
		for (i = 0; i < timings.length; i++) {
			if (t >= timings[i].start && t < timings[i].end) return i;
			if (t < timings[i].start) return i - 1;
		}
		return last;
	}

	function highlight(t) {
		if (!words.length) return;
		var index = (!audio.paused || t > 0.05) ? wordAt(t) : -1;
		if (index === active) return;
		if (active >= 0 && words[active]) words[active].classList.remove('on');
		active = index;
		if (index < 0 || !words[index]) return;
		words[index].classList.add('on');
		if (words[index].scrollIntoView) words[index].scrollIntoView({ block: 'nearest', inline: 'nearest' });
	}

	function follow() {
		highlight(audio.currentTime || 0);
		if (!audio.paused && !audio.ended) frame = requestAnimationFrame(follow);
	}

	function playClip(auto) {
		var clip = clips[currentIndex()];
		if (!clip) return;
		showMeta(clip);
		renderQueue();
		renderText(clip);
		audio.playbackRate = speeds[speedAt];
		if (audio.getAttribute('src') !== clip.audio) {
			audio.src = clip.audio;
		} else {
			audio.currentTime = 0;
		}
		document.getElementById('seek').value = '0';
		document.getElementById('time_now').textContent = '0:00';
		if (!auto) {
			paintButtons();
			return;
		}
		var started = audio.play();
		if (started && started.catch) started.catch(function () { paintButtons(); });
		paintButtons();
	}

	function step(dir) {
		if (dir < 0 && audio.currentTime > 3) {
			audio.currentTime = 0;
			return;
		}
		var next = pos + dir;
		if (next < 0 || next >= order.length) {
			if (repeat === 'all' && order.length) {
				next = dir > 0 ? 0 : order.length - 1;
			} else {
				return;
			}
		}
		pos = next;
		playClip(true);
	}

	document.getElementById('btn_play').addEventListener('click', function () {
		if (!audio.getAttribute('src')) {
			playClip(true);
			return;
		}
		if (audio.paused) {
			var started = audio.play();
			if (started && started.catch) started.catch(function () {});
		} else {
			audio.pause();
		}
		paintButtons();
	});
	document.getElementById('btn_all').addEventListener('click', function () {
		pos = 0;
		playClip(true);
	});
	function shareMime() {
		var list = [
			'video/mp4;codecs=avc1.42E01E,mp4a.40.2',
			'video/mp4;codecs=avc1.4D401E,mp4a.40.2',
			'video/mp4;codecs=avc1,mp4a.40.2',
			'video/mp4'
		];
		if (!window.MediaRecorder || !MediaRecorder.isTypeSupported) return '';
		var i;
		for (i = 0; i < list.length; i++) {
			if (MediaRecorder.isTypeSupported(list[i])) return list[i];
		}
		return '';
	}
	function loadShareImage(url) {
		return new Promise(function (resolve) {
			if (!url) { resolve(null); return; }
			var img = new Image();
			img.onload = function () { resolve(img); };
			img.onerror = function () { resolve(null); };
			img.src = url;
		});
	}
	function wrapShareText(ctx, text, maxWidth) {
		var parts = String(text || '').split(/\s+/);
		var lines = [];
		var line = '';
		var i;
		for (i = 0; i < parts.length; i++) {
			var test = line ? line + ' ' + parts[i] : parts[i];
			if (ctx.measureText(test).width > maxWidth && line) {
				lines.push(line);
				line = parts[i];
			} else {
				line = test;
			}
		}
		if (line) lines.push(line);
		return lines;
	}
	function layoutShareWords(list, maxWidth, gap) {
		var lines = [];
		var line = [];
		var width = 0;
		var i;
		var space = gap || 0;
		for (i = 0; i < list.length; i++) {
			var word = list[i];
			var add = word.width + (line.length ? space : 0);
			if (width + add > maxWidth && line.length) {
				lines.push(line);
				line = [];
				width = 0;
				add = word.width;
			}
			line.push(word);
			width += add;
		}
		if (line.length) lines.push(line);
		return lines;
	}
	function shareWordIndex(t, duration, count, marks) {
		if (marks && marks.length) {
			if (t < marks[0].start) return -1;
			var last = marks.length - 1;
			if (t >= marks[last].end) return last;
			var i;
			for (i = 0; i < marks.length; i++) {
				if (t >= marks[i].start && t < marks[i].end) return i;
				if (t < marks[i].start) return i - 1;
			}
			return last;
		}
		if (!count || !duration) return -1;
		return Math.min(count - 1, Math.floor((t / duration) * count));
	}
	function drawCover(ctx, img, dx, dy, dw, dh) {
		var scale = Math.max(dw / img.width, dh / img.height);
		var sw = dw / scale;
		var sh = dh / scale;
		var sx = (img.width - sw) / 2;
		var sy = (img.height - sh) / 2;
		ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh);
	}
	function phrasePieces(buffer) {
		if (!buffer) return [];
		var channel = buffer.getChannelData(0);
		var rate = buffer.sampleRate || 44100;
		var hop = Math.max(1, Math.floor(rate * 0.02));
		var energies = [];
		var times = [];
		var i;
		var j;
		for (i = 0; i + hop < channel.length; i += hop) {
			var sum = 0;
			for (j = 0; j < hop; j++) {
				var sample = channel[i + j];
				sum += sample * sample;
			}
			energies.push(Math.sqrt(sum / hop));
			times.push(i / rate);
		}
		if (!energies.length) return [];
		var sorted = energies.slice().sort(function (a, b) { return a - b; });
		var floor = sorted[Math.floor(sorted.length * 0.2)] || 0;
		var loud = sorted[Math.min(sorted.length - 1, Math.floor(sorted.length * 0.98))] || 0;
		var thresh = Math.max(0.015, Math.min(loud * 0.18, Math.max(floor * 1.35, 0.015)));
		var runs = [];
		var start = -1;
		for (i = 0; i < energies.length; i++) {
			if (energies[i] >= thresh) {
				if (start < 0) start = i;
			} else if (start >= 0) {
				runs.push({ a: start, b: i });
				start = -1;
			}
		}
		if (start >= 0) runs.push({ a: start, b: energies.length - 1 });
		var merged = [];
		for (i = 0; i < runs.length; i++) {
			var dur = times[Math.min(runs[i].b, times.length - 1)] - times[runs[i].a];
			if (dur < 0.12) continue;
			var endAt = times[Math.min(runs[i].b, times.length - 1)];
			if (merged.length && times[runs[i].a] - merged[merged.length - 1].end < 0.35) {
				merged[merged.length - 1].end = endAt;
				continue;
			}
			merged.push({ start: times[runs[i].a], end: endAt });
		}
		return merged;
	}

	function statusSpan(buffer) {
		var duration = buffer && isFinite(buffer.duration) ? buffer.duration : 0;
		if (!duration || duration <= 14) return { start: 0, end: duration || 0 };
		var pieces = phrasePieces(buffer);
		if (!pieces.length) return { start: 0, end: Math.min(12, duration) };
		var best = null;
		var i;
		var j;
		for (i = 0; i < pieces.length; i++) {
			var startAt = pieces[i].start;
			var voice = 0;
			var endAt = startAt;
			for (j = i; j < pieces.length; j++) {
				if (pieces[j].end - startAt > 13.5) break;
				endAt = pieces[j].end;
				voice += Math.max(0, pieces[j].end - pieces[j].start);
				var span = endAt - startAt;
				if (span < 6) continue;
				var score = voice - Math.abs(span - 12) * 0.2;
				if (!best || score > best.score) best = { start: startAt, end: endAt, score: score };
			}
		}
		if (!best) best = { start: pieces[0].start, end: Math.min(duration, pieces[0].start + 12) };
		if (best.end - best.start < 8) best.end = Math.min(duration, best.start + 12);
		if (best.end - best.start > 14) best.end = best.start + 12;
		return { start: Math.max(0, best.start), end: Math.min(duration, best.end) };
	}

	function recordShareVideo(clip, mode, onProgress, alive) {
		var mime = shareMime();
		if (!mime || !HTMLCanvasElement.prototype.captureStream) {
			return Promise.reject(new Error('mp4'));
		}
		var who = (window.__quranStudent || 'Student').trim();
		var school = (window.__quranSchool || 'Tahsin Academy').trim();
		var ayahs = [];
		var a;
		for (a = Number(clip.from) || 0; a <= (Number(clip.to) || 0); a++) ayahs.push(a);
		if (!ayahs.length || ayahs.length > 40) ayahs = [];
		var textPromise = clip.surah ? fetchSurah(clip.surah).catch(function () { return []; }) : Promise.resolve([]);
		return Promise.all([
			document.fonts && document.fonts.load ? document.fonts.load('700 64px "Scheherazade New"') : Promise.resolve(),
			loadShareImage(window.__quranLogo),
			loadShareImage(window.__quranPhoto),
			textPromise
		]).then(function (loaded) {
			var logo = loaded[1];
			var photo = loaded[2];
			var ayah = loaded[3] || [];
			var arabic = [];
			var ayahOf = [];
			var wanted = {};
			var n;
			for (n = 0; n < ayahs.length; n++) wanted[ayahs[n]] = true;
			ayah.forEach(function (row) {
				var num = Number(row.numberInSurah);
				if (!wanted[num] || !row.text) return;
				row.text.trim().split(/\s+/).forEach(function (bit) {
					if (!bit) return;
					arabic.push(bit);
					ayahOf.push(num);
				});
			});
			var timingPromise = arabic.length ? decodeTimings(clip.audio, arabic) : Promise.resolve(null);
			return timingPromise.then(function (marks) {
				return loadAudioBuffer(clip.audio).then(function (buffer) {
					var duration = buffer && isFinite(buffer.duration) ? buffer.duration : 0;
					var span = (mode === 'full' || !duration || duration <= 14) ? { start: 0, end: duration } : statusSpan(buffer);
					if (!span.end || span.end - span.start < 1) span = { start: 0, end: duration || 12 };
					return { logo: logo, photo: photo, arabic: arabic, ayahOf: ayahOf, marks: marks, who: who, school: school, span: span };
				});
			});
		}).then(function (pack) {
			return new Promise(function (resolve, reject) {
				var canvas = document.getElementById('share_canvas');
				var ctx = canvas.getContext('2d');
				var ctxAudio = audioCtx || new (window.AudioContext || window.webkitAudioContext)();
				audioCtx = ctxAudio;
				var span = pack.span || { start: 0, end: 0 };
				var recAudio = new Audio();
				recAudio.preload = 'auto';
				recAudio.volume = 1;
				var source = ctxAudio.createMediaElementSource(recAudio);
				var dest = ctxAudio.createMediaStreamDestination();
				source.connect(dest);
				var mixed = new MediaStream();
				canvas.captureStream(30).getVideoTracks().forEach(function (track) { mixed.addTrack(track); });
				dest.stream.getAudioTracks().forEach(function (track) { mixed.addTrack(track); });
				var recorder;
				try {
					recorder = new MediaRecorder(mixed, { mimeType: mime, videoBitsPerSecond: 2200000, audioBitsPerSecond: 128000 });
				} catch (err) {
					try { source.disconnect(); } catch (e) {}
					try { recAudio.pause(); } catch (e2) {}
					reject(err);
					return;
				}
				var chunks = [];
				var settled = false;
				var waitUnlock = null;
				function finish(err, blob) {
					if (settled) return;
					settled = true;
					if (waitUnlock) document.removeEventListener('pointerdown', waitUnlock);
					try { source.disconnect(); } catch (e) {}
					try { recAudio.pause(); } catch (e2) {}
					if (err) reject(err);
					else resolve(blob);
				}
				recorder.ondataavailable = function (ev) { if (ev.data && ev.data.size) chunks.push(ev.data); };
				recorder.onerror = function () { finish(new Error('record')); };
				recorder.onstop = function () {
					var blob = new Blob(chunks, { type: 'video/mp4' });
					if (blob.size < 1000) finish(new Error('empty'));
					else finish(null, blob);
				};
				function paint(t) {
					var w = canvas.width;
					var h = canvas.height;
					var slice = Math.max(0.01, (span.end || 0) - (span.start || 0));
					var stampLeft = (span.end || 0) - t;
					var stampP = stampLeft <= 1.2 ? Math.max(0, Math.min(1, 1 - (stampLeft / 1.2))) : 0;
					var stampWhere = null;
					ctx.fillStyle = '#10241e';
					ctx.fillRect(0, 0, w, h);
					var y = 56;
					if (pack.logo) {
						var lw = 84;
						var lh = Math.max(36, (pack.logo.height / pack.logo.width) * lw);
						ctx.drawImage(pack.logo, (w - lw) / 2, y, lw, lh);
						y += lh + 22;
					}
					ctx.fillStyle = '#f6f1e6';
					ctx.textAlign = 'center';
					ctx.font = '600 34px Outfit, sans-serif';
					ctx.fillText(pack.school, w / 2, y + 28);
					y += 58;
					var radius = 72;
					var photoY = y + radius;
					ctx.save();
					ctx.beginPath();
					ctx.arc(w / 2, photoY, radius, 0, Math.PI * 2);
					ctx.fillStyle = '#1c332b';
					ctx.fill();
					ctx.clip();
					if (pack.photo) drawCover(ctx, pack.photo, w / 2 - radius, photoY - radius, radius * 2, radius * 2);
					ctx.restore();
					ctx.beginPath();
					ctx.arc(w / 2, photoY, radius, 0, Math.PI * 2);
					ctx.strokeStyle = '#e4c98a';
					ctx.lineWidth = 5;
					ctx.stroke();
					y = photoY + radius + 48;
					ctx.fillStyle = '#f6f1e6';
					ctx.font = '700 40px Outfit, sans-serif';
					ctx.fillText(pack.who, w / 2, y);
					y += 42;
					ctx.fillStyle = '#e4c98a';
					ctx.font = '600 28px Outfit, sans-serif';
					var portionLines = wrapShareText(ctx, clip.portion || '', w - 96);
					var p;
					for (p = 0; p < portionLines.length && p < 3; p++) {
						ctx.fillText(portionLines[p], w / 2, y);
						y += 36;
					}
					y += 28;
					var size = pack.arabic.length > 40 ? 30 : (pack.arabic.length > 16 ? 40 : 54);
					ctx.save();
					ctx.direction = 'ltr';
					ctx.font = '700 ' + size + 'px "Scheherazade New", serif';
					ctx.textAlign = 'left';
					ctx.textBaseline = 'alphabetic';
					var probe = ctx.measureText(pack.arabic[0] || 'بِسْمِ');
					var ascent = probe.actualBoundingBoxAscent || size * 0.86;
					var descent = probe.actualBoundingBoxDescent || size * 0.34;
					if (ascent < size * 0.62) ascent = size * 0.86;
					if (descent < size * 0.2) descent = size * 0.34;
					var gap = Math.max(12, Math.round(size * 0.34));
					var shareWords = [];
					var sw;
					for (sw = 0; sw < pack.arabic.length; sw++) {
						shareWords.push({ text: pack.arabic[sw], index: sw, width: ctx.measureText(pack.arabic[sw]).width });
					}
					var lines = layoutShareWords(shareWords, w - 210, gap);
					var lineH = ascent + descent + 28;
					var lit = shareWordIndex(t, span.end || slice, pack.arabic.length, pack.marks);
					y += ascent;
					var li;
					var wi;
					var viewTop = y;
					var maxY = h - 220;
					var anchor = 0;
					var seen = 0;
					for (li = 0; li < lines.length; li++) {
						var onLine = false;
						for (wi = 0; wi < lines[li].length; wi++) {
							if (lines[li][wi].index === lit) onLine = true;
						}
						if (onLine) { anchor = seen; break; }
						seen += lineH;
					}
					var room = Math.max(lineH, maxY - viewTop);
					var shift = anchor + lineH > room ? anchor - room * 0.35 : 0;
					if (shift < 0) shift = 0;
					var drawY = viewTop - shift;
					for (li = 0; li < lines.length; li++) {
						if (drawY > maxY) break;
						if (drawY >= viewTop - 4) {
							var line = lines[li];
							var lineWidth = 0;
							for (wi = 0; wi < line.length; wi++) lineWidth += line[wi].width;
							if (line.length > 1) lineWidth += gap * (line.length - 1);
							var cursor = (w + lineWidth) / 2;
							var lineLeft = cursor - lineWidth;
							var lineLit = false;
							for (wi = 0; wi < line.length; wi++) {
								var word = line[wi];
								var wordLeft = cursor - word.width;
								if (word.index === lit) {
									lineLit = true;
									var padX = Math.max(5, Math.round(size * 0.1));
									var padY = Math.max(4, Math.round(size * 0.08));
									var boxX = wordLeft - padX;
									var boxY = drawY - ascent - padY;
									var boxW = word.width + padX * 2;
									var boxH = ascent + descent + padY * 2;
									var radius = Math.min(12, boxH / 2, boxW / 2);
									ctx.beginPath();
									ctx.moveTo(boxX + radius, boxY);
									ctx.arcTo(boxX + boxW, boxY, boxX + boxW, boxY + boxH, radius);
									ctx.arcTo(boxX + boxW, boxY + boxH, boxX, boxY + boxH, radius);
									ctx.arcTo(boxX, boxY + boxH, boxX, boxY, radius);
									ctx.arcTo(boxX, boxY, boxX + boxW, boxY, radius);
									ctx.closePath();
									ctx.fillStyle = '#1f6b4a';
									ctx.fill();
								}
								ctx.fillStyle = word.index === lit ? '#f6f1e6' : '#d7e3db';
								ctx.direction = 'ltr';
								ctx.textAlign = 'left';
								ctx.textBaseline = 'alphabetic';
								ctx.font = '700 ' + size + 'px "Scheherazade New", serif';
								ctx.fillText(word.text, wordLeft, drawY);
								cursor = wordLeft - gap;
							}
							var endWord = line[line.length - 1];
							var ayahNum = pack.ayahOf[endWord.index] || 0;
							var nextAyah = pack.ayahOf[endWord.index + 1];
							var ayahEnds = ayahNum && nextAyah !== ayahNum;
							if (ayahEnds) {
								var badgeR = 16;
								var badgeX = lineLeft - 26 - badgeR;
								var badgeY = drawY - (ascent - descent) / 2;
								ctx.beginPath();
								ctx.arc(badgeX, badgeY, badgeR, 0, Math.PI * 2);
								ctx.strokeStyle = '#e4c98a';
								ctx.lineWidth = 2;
								ctx.stroke();
								ctx.fillStyle = '#f6f1e6';
								ctx.font = '600 16px Outfit, sans-serif';
								ctx.textAlign = 'center';
								ctx.textBaseline = 'middle';
								ctx.direction = 'ltr';
								ctx.fillText(String(ayahNum), badgeX, badgeY + 1);
								if (lineLit || !stampWhere) stampWhere = { x: badgeX, y: badgeY };
							}
						}
						drawY += lineH;
					}
					ctx.restore();
					ctx.textAlign = 'center';
					ctx.textBaseline = 'alphabetic';
					ctx.direction = 'ltr';
					if (stampP > 0 && stampWhere) {
						ctx.beginPath();
						ctx.arc(stampWhere.x, stampWhere.y, 24, -Math.PI / 2, -Math.PI / 2 + stampP * Math.PI * 2);
						ctx.strokeStyle = '#e4c98a';
						ctx.lineWidth = 4;
						ctx.stroke();
						if (stampP > 0.45) {
							ctx.globalAlpha = Math.min(1, (stampP - 0.45) / 0.35);
							ctx.fillStyle = '#e4c98a';
							ctx.font = '700 34px Outfit, sans-serif';
							ctx.fillText('Sealed', w / 2, Math.min(h - 188, stampWhere.y + 78));
							ctx.globalAlpha = 1;
						}
					}
					var barY = h - 176;
					ctx.fillStyle = '#1c332b';
					ctx.fillRect(120, barY, w - 240, 8);
					var ratio = Math.max(0, Math.min(1, ((t || 0) - (span.start || 0)) / slice));
					ctx.fillStyle = '#1f6b4a';
					ctx.fillRect(120, barY, (w - 240) * ratio, 8);
					var when = clip.date || '';
					if (clip.time) when = when ? (when + ' · ' + clip.time) : clip.time;
					var sealLine = 'Sealed · ' + when;
					var mistakeCount = Number(clip.mistakes);
					if (isFinite(mistakeCount) && mistakeCount > 0) {
						sealLine += ' · ' + mistakeCount + (mistakeCount === 1 ? ' mistake' : ' mistakes');
					}
					ctx.fillStyle = '#b7c4bb';
					ctx.font = '500 24px Outfit, sans-serif';
					if (ctx.measureText(sealLine).width > w - 160) ctx.font = '500 20px Outfit, sans-serif';
					ctx.fillText(sealLine, w / 2, h - 140);
					ctx.fillStyle = '#e4c98a';
					ctx.font = '600 26px Outfit, sans-serif';
					ctx.fillText('Contact us 08021211053', w / 2, h - 104);
					var frame = 26;
					ctx.strokeStyle = '#e4c98a';
					ctx.lineWidth = 6;
					ctx.strokeRect(frame, frame, w - frame * 2, h - frame * 2);
				}
				function beginTake() {
					if (alive && !alive()) {
						finish(new Error('cancel'));
						return;
					}
					var resume = ctxAudio.resume ? ctxAudio.resume() : null;
					var startRec = function () {
						if (alive && !alive()) {
							finish(new Error('cancel'));
							return;
						}
						try {
							paint(span.start || 0);
							recorder.start(500);
						} catch (err) {
							finish(err);
							return;
						}
						if (onProgress) onProgress(0.01);
						var started = recAudio.play();
						var cap = setTimeout(function () {
							if (recorder.state === 'recording') recorder.stop();
						}, (Math.max(1, (span.end || 12) - (span.start || 0)) + 4) * 1000);
						function tick() {
							if (alive && !alive()) {
								clearTimeout(cap);
								try { recAudio.pause(); } catch (e) {}
								if (recorder.state === 'recording') recorder.stop();
								return;
							}
							var now = recAudio.currentTime || span.start || 0;
							if (span.end && now >= span.end - 0.04) {
								clearTimeout(cap);
								paint(span.end);
								if (onProgress) onProgress(1);
								try { recAudio.pause(); } catch (e2) {}
								setTimeout(function () {
									if (recorder.state !== 'inactive') recorder.stop();
								}, 220);
								return;
							}
							paint(now);
							if (onProgress) onProgress(((now - (span.start || 0)) / Math.max(0.01, (span.end || now) - (span.start || 0))));
							requestAnimationFrame(tick);
						}
						if (started && started.then) {
							started.then(tick).catch(function (err) {
								clearTimeout(cap);
								try { if (recorder.state === 'recording') recorder.stop(); } catch (e) {}
								finish(err);
							});
						} else {
							tick();
						}
					};
					var startedTake = false;
					var go = function () {
						if (startedTake) return;
						startedTake = true;
						if (span.start > 0.05) {
							var onSeek = function () {
								recAudio.removeEventListener('seeked', onSeek);
								startRec();
							};
							recAudio.addEventListener('seeked', onSeek);
							try { recAudio.currentTime = span.start; } catch (e) { startRec(); }
						} else {
							startRec();
						}
					};
					if (ctxAudio.state === 'running') go();
					else {
						var unlock = function () {
							var pending = ctxAudio.resume ? ctxAudio.resume() : Promise.resolve();
							Promise.resolve(pending).then(function () {
								if (ctxAudio.state !== 'running') return;
								document.removeEventListener('pointerdown', unlock);
								waitUnlock = null;
								go();
							}).catch(function () {});
						};
						waitUnlock = unlock;
						document.addEventListener('pointerdown', unlock);
						if (resume && resume.then) resume.then(function () { unlock(); });
					}
				}
				recAudio.onloadedmetadata = function () {
					if (!span.end || !isFinite(span.end)) {
						var full = recAudio.duration || 12;
						span.start = 0;
						span.end = mode === 'full' || full <= 14 ? full : Math.min(12, full);
					}
					beginTake();
				};
				recAudio.src = clip.audio;
			});
		});
	}
	var shareToken = 0;
	var shareReady = { status: null, full: null };
	function shareBaseName(clip, mode) {
		var who = (window.__quranStudent || 'Student').trim();
		var base = (who + ' - ' + (clip.portion || 'Recitation')).replace(/[\\/:*?"<>|]+/g, ' ').replace(/\s+/g, ' ').trim();
		if (base.length > 70) base = base.slice(0, 70);
		return (base || 'Recitation') + (mode === 'full' ? ' full' : '') + '.mp4';
	}
	function setShareButton(id, label) {
		var el = document.getElementById(id);
		if (!el) return;
		el.disabled = false;
		el.textContent = label;
	}
	function openShareFile(file, clip) {
		var note = document.getElementById('share_note');
		var who = (window.__quranStudent || 'Student').trim();
		var school = (window.__quranSchool || 'Tahsin Academy').trim();
		var text = who + ' recited ' + clip.portion + ' at ' + school + '. ' + clip.date + '.';
		var title = who + ' — ' + clip.portion;
		if (!navigator.share) {
			if (note) note.textContent = 'This phone cannot open the share list.';
			return;
		}
		var payload = { files: [file], title: title, text: text };
		if (navigator.canShare && !navigator.canShare(payload)) payload = { files: [file] };
		if (navigator.canShare && !navigator.canShare(payload)) {
			if (note) note.textContent = 'This phone cannot share the video file.';
			return;
		}
		navigator.share(payload).then(function () {
			if (note) note.textContent = 'Choose WhatsApp Status, WhatsApp, or another app.';
		}).catch(function (err) {
			if (err && err.name === 'AbortError') return;
			if (note) note.textContent = 'Tap the button again and choose an app.';
		});
	}
	function runShareJob(clip, mode, token) {
		var btnId = mode === 'full' ? 'btn_full' : 'btn_share';
		var label = mode === 'full' ? 'Full' : 'Status';
		setShareButton(btnId, label + ' 0%');
		return recordShareVideo(clip, mode, function (frac) {
			if (token !== shareToken) return;
			var pct = Math.max(1, Math.min(99, Math.round((frac || 0) * 100)));
			setShareButton(btnId, label + ' ' + pct + '%');
		}, function () { return token === shareToken; }).then(function (blob) {
			if (token !== shareToken) return;
			shareReady[mode] = new File([blob], shareBaseName(clip, mode), { type: 'video/mp4' });
			setShareButton(btnId, mode === 'full' ? 'Share full' : 'Share for Status');
		}).catch(function (err) {
			if (token !== shareToken) return;
			if (err && err.message === 'cancel') return;
			shareReady[mode] = false;
			setShareButton(btnId, mode === 'full' ? 'Share full' : 'Share for Status');
			var note = document.getElementById('share_note');
			if (note) note.textContent = 'The video could not be made. Open this recitation again.';
		});
	}
	function startShareJobs(clip) {
		if (!clip || !clip.audio) return;
		shareToken++;
		var token = shareToken;
		shareKey = clip.audio;
		shareReady.status = null;
		shareReady.full = null;
		var note = document.getElementById('share_note');
		if (!shareMime()) {
			setShareButton('btn_share', 'Share for Status');
			setShareButton('btn_full', 'Share full');
			if (note) note.textContent = 'This phone cannot make an MP4 video.';
			return;
		}
		if (note) note.textContent = 'Share for Status is a short video. Share full keeps the whole recitation.';
		runShareJob(clip, 'status', token).then(function () {
			if (token !== shareToken) return;
			return runShareJob(clip, 'full', token);
		});
	}
	function shareReadyFile(mode) {
		var clip = clips[currentIndex()];
		if (audioCtx && audioCtx.resume) audioCtx.resume();
		var file = shareReady[mode];
		var note = document.getElementById('share_note');
		if (file && typeof file !== 'boolean') {
			openShareFile(file, clip);
			return;
		}
		if (note) note.textContent = mode === 'full'
			? 'The full video is still being made. It starts after the Status video.'
			: 'The Status video is being made. This button opens your apps when it reaches Share for Status.';
	}
	document.getElementById('btn_share').addEventListener('click', function () { shareReadyFile('status'); });
	document.getElementById('btn_full').addEventListener('click', function () { shareReadyFile('full'); });
	document.getElementById('btn_next').addEventListener('click', function () { step(1); });
	document.getElementById('btn_prev').addEventListener('click', function () { step(-1); });
	document.getElementById('btn_shuffle').addEventListener('click', function () {
		var keep = currentIndex();
		shuffled = !shuffled;
		if (!shuffled) {
			order = clips.map(function (_, i) { return i; });
		} else {
			var rest = order.filter(function (i) { return i !== keep; });
			for (var i = rest.length - 1; i > 0; i--) {
				var j = Math.floor(Math.random() * (i + 1));
				var tmp = rest[i];
				rest[i] = rest[j];
				rest[j] = tmp;
			}
			order = [keep].concat(rest);
		}
		pos = order.indexOf(keep);
		if (pos < 0) pos = 0;
		showMeta(clips[currentIndex()]);
		renderQueue();
		paintButtons();
	});
	document.getElementById('btn_repeat').addEventListener('click', function () {
		repeat = repeat === 'off' ? 'all' : (repeat === 'all' ? 'one' : 'off');
		paintButtons();
	});
	document.getElementById('btn_speed').addEventListener('click', function () {
		speedAt = (speedAt + 1) % speeds.length;
		audio.playbackRate = speeds[speedAt];
		paintButtons();
	});

	var seek = document.getElementById('seek');
	seek.addEventListener('pointerdown', function () { seeking = true; });
	seek.addEventListener('pointerup', function () { seeking = false; });
	seek.addEventListener('input', function () {
		var duration = audio.duration;
		if (!duration || !isFinite(duration)) return;
		audio.currentTime = (Number(seek.value) / 1000) * duration;
	});

	audio.addEventListener('loadedmetadata', function () {
		if (audio.duration && isFinite(audio.duration)) {
			document.getElementById('time_end').textContent = clock(audio.duration);
		}
	});
	audio.addEventListener('timeupdate', function () {
		var duration = audio.duration;
		if (duration && isFinite(duration) && !seeking) {
			seek.value = String(Math.round((audio.currentTime / duration) * 1000));
		}
		document.getElementById('time_now').textContent = clock(audio.currentTime);
		if (duration && isFinite(duration)) {
			document.getElementById('time_end').textContent = clock(duration);
		}
		highlight(audio.currentTime);
	});
	audio.addEventListener('playing', function () { skips = 0; });
	audio.addEventListener('play', function () {
		if (audioCtx && audioCtx.state === 'suspended' && audioCtx.resume) audioCtx.resume();
		lightAyah(true);
		var hearGo = document.getElementById('hear_go');
		if (hearGo) hearGo.classList.add('gone');
		paintButtons();
		cancelAnimationFrame(frame);
		frame = requestAnimationFrame(follow);
	});
	audio.addEventListener('pause', function () {
		lightAyah(false);
		paintButtons();
	});
	audio.addEventListener('ended', function () {
		if (repeat === 'one') {
			audio.currentTime = 0;
			audio.play();
			return;
		}
		if (pos + 1 < order.length) {
			pos += 1;
			playClip(true);
			return;
		}
		if (repeat === 'all' && order.length) {
			pos = 0;
			playClip(true);
			return;
		}
		paintButtons();
	});
	audio.addEventListener('error', function () {
		skips += 1;
		if (skips > order.length) return;
		if (pos + 1 < order.length) {
			pos += 1;
			playClip(true);
		}
	});

	var hear = document.documentElement.classList.contains('hear');
	if (hear) audio.preload = 'auto';
	showMeta(clips[0]);
	renderText(clips[0]);
	renderQueue();
	paintButtons();
	if (hear) {
		var hearGo = document.getElementById('hear_go');
		if (hearGo) hearGo.addEventListener('click', function () { playClip(true); });
		playClip(true);
	} else {
		audio.src = clips[0].audio;
	}
})();
</script>
<?php endif; ?>
</body>
</html>
