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
<style>@font-face{font-family:"DigitalKhatt New Madina";src:url("<?php echo base_url('assets/fonts/madina.woff2'); ?>") format("woff2");font-weight:400;font-style:normal;font-display:swap}</style>
<script>
window.__quranInstall = null;
window.__quranInstallWait = [];
window.__quranToken = <?php echo json_encode($token); ?>;
window.__quranStudent = <?php echo json_encode($install['student_name']); ?>;
window.__quranSchool = <?php echo json_encode($install['school_name']); ?>;
window.__quranLogo = <?php echo json_encode($install['school_logo']); ?>;
window.__quranPhoto = <?php echo json_encode($install['photo']); ?>;
window.__quranStart = <?php echo json_encode(site_url('quran/' . $token . '/')); ?>;
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
		document.documentElement.classList.add('quran-installed');
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
.mushaf{background:var(--mushaf);color:var(--text);border:1px solid var(--mushaf-line);border-radius:16px;padding:1rem .9rem 1.35rem;min-height:7.5rem;overflow:visible;direction:rtl;text-align:center;font-family:"DigitalKhatt New Madina","Traditional Arabic",serif;font-size:1.85rem;line-height:1.85}
.mushaf.empty{direction:ltr;text-align:left;font-family:system-ui,sans-serif;font-size:.92rem;line-height:1.45;color:var(--muted)}
.basmala{display:block;text-align:center;text-align-last:center;margin:.15rem 0 .25rem;font-size:1.12em;line-height:1.65}
.surah-banner{display:block;text-align:center;margin:0 0 .45rem;padding:.4rem .8rem .32rem;border:2px solid var(--mushaf-line);border-radius:12px;box-shadow:inset 0 0 0 4px var(--mushaf),inset 0 0 0 5px var(--mushaf-line);line-height:1.45}
.surah-banner .surah-name{display:block;font-size:.9em}
.surah-banner .surah-place{display:block;direction:ltr;font-family:system-ui,sans-serif;font-size:.72rem;color:var(--muted);margin-top:.12rem}
.line{display:flex;flex-wrap:nowrap;justify-content:center;align-items:baseline;gap:.28em;margin:0;line-height:2.05;white-space:nowrap;font-size:var(--line-size,1.35rem)}
.line.just{justify-content:space-between;gap:0}
.line.center{justify-content:center;gap:.35em}
.line .w,.line .ayah-end{flex:0 0 auto;margin-inline:0}
.ayah{display:block;text-align:justify;text-align-last:center;margin:.2rem 0 .55rem;line-height:2.05}
.ayah-end{display:inline-block;white-space:nowrap}
.w{display:inline-block;border-radius:.4em;padding:.02em .08em;margin-inline:.06em;line-height:1.35;vertical-align:baseline}
.w.on{background:var(--mark)}
.mushaf.tajweed .tj-madd{color:#1d4ed8}
.mushaf.tajweed .tj-ghunnah{color:#dc2626}
.mushaf.tajweed .tj-qalqalah{color:#15803d}
.mushaf.tajweed .tj-silent{color:#9ca3af}
html[data-theme="dark"] .mushaf.tajweed .tj-madd{color:#93c5fd}
html[data-theme="dark"] .mushaf.tajweed .tj-ghunnah{color:#fca5a5}
html[data-theme="dark"] .mushaf.tajweed .tj-qalqalah{color:#86efac}
html[data-theme="dark"] .mushaf.tajweed .tj-silent{color:#9ca3af}
.tajweed-key{display:flex;flex-wrap:wrap;gap:.35rem .85rem;margin:.15rem 0 .35rem;color:var(--muted);font-size:.78rem}
.tajweed-key[hidden]{display:none}
.tajweed-key i{display:inline-block;width:.65rem;height:.65rem;border-radius:99px;margin-right:.28rem;vertical-align:-.05rem}
.sw-madd{background:#1d4ed8}
.sw-ghunnah{background:#dc2626}
.sw-qalqalah{background:#15803d}
.sw-silent{background:#9ca3af}
.mushaf.hide-words .w{opacity:0}
.mushaf.hide-words .w.on{opacity:1}
.meaning{margin:.35rem 0 .85rem;color:var(--muted);font-size:.92rem;line-height:1.45;direction:ltr;text-align:left}
.num{display:inline;margin:0 .08em;border:0;font-family:"DigitalKhatt New Madina","Traditional Arabic",serif;font-size:1em;line-height:1;color:inherit;vertical-align:baseline}
.player{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:.9rem 1rem;margin:1rem 0 .75rem}
.transport.solo #btn_shuffle,.transport.solo #btn_prev,.transport.solo #btn_next{display:none}
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
.playall[hidden]{display:none}
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
	<?php if (empty($clips)): ?>
		<p>No sealed recitation is on this playlist yet.</p>
	<?php else: ?>
	<div id="ayah_row" class="ayah-row" hidden></div>
	<button type="button" id="hear_go" class="hear-go">Hear this recitation</button>
	<div class="player">
		<div class="now-title" id="now_title"><?php echo html_escape($clips[0]['portion']); ?></div>
		<div class="meta" id="now_ayah"></div>
		<div class="meta" id="now_meta"><?php echo html_escape($clips[0]['date'] . ' · ' . $clips[0]['time']); ?></div>
		<input id="seek" class="seek" type="range" min="0" max="1000" value="0" aria-label="Position in this recording">
		<div class="times"><span id="time_now">0:00</span><span id="time_end">0:00</span></div>
		<div class="transport">
			<button type="button" id="btn_shuffle">Shuffle</button>
			<button type="button" id="btn_prev">Previous</button>
			<button type="button" id="btn_play" class="go">Play</button>
			<button type="button" id="btn_next">Next</button>
			<button type="button" id="btn_repeat">Repeat</button>
			<button type="button" id="btn_speed">Speed 1×</button>
			<button type="button" id="btn_tajweed">Tajweed</button>
			<button type="button" id="btn_hide">Hide words</button>
		</div>
		<p id="tajweed_key" class="tajweed-key" hidden><span><i class="sw-madd"></i>Madd</span><span><i class="sw-ghunnah"></i>Ghunnah</span><span><i class="sw-qalqalah"></i>Qalqalah</span><span><i class="sw-silent"></i>Silent</span></p>
		<button type="button" id="btn_all" class="playall">Play all</button>
		<button type="button" id="btn_share" class="share-rec">Share a short video</button>
		<button type="button" id="btn_full" class="share-full">Share the full recitation</button>
		<p id="share_note" class="share-note">Share a short video for WhatsApp Status, or share the whole recitation.</p>
	</div>
	<div id="mushaf" class="mushaf empty" translate="no">The ayahs appear here and light up as the recitation plays.</div>
	<p id="ayah_meaning" class="meaning" dir="ltr"></p>
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
</div>
<script>
if ('serviceWorker' in navigator) {
	var quranSwScope = '<?php echo site_url('quran/' . $token . '/'); ?>';
	navigator.serviceWorker.getRegistrations().then(function (regs) {
		regs.forEach(function (reg) {
			if (reg.scope && /\/quran\/$/.test(reg.scope)) reg.unregister();
		});
	}).catch(function () {});
	navigator.serviceWorker.register('<?php echo base_url('quran/sw.js'); ?>?v=21', { scope: quranSwScope, updateViaCache: 'none' }).then(function (reg) {
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
			btn.querySelector('.meta').textContent = clip.date + ' · ' + clip.time;
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
		repeatBtn.textContent = repeat === 'ayah' ? 'Repeat ayah' : (repeat === 'all' ? 'Repeat all' : 'Repeat');
		document.getElementById('btn_speed').textContent = 'Speed ' + speeds[speedAt] + '×';
		document.getElementById('btn_play').textContent = (!audio.paused || audio.dataset.want === '1') ? 'Pause' : 'Play';
		var transport = document.querySelector('.transport');
		if (transport) transport.classList.toggle('solo', order.length < 2 && !(heard && heard.length));
		var all = document.getElementById('btn_all');
		if (all) all.hidden = order.length < 2;
		var queue = document.getElementById('queue');
		if (queue) queue.hidden = order.length < 2;
	}

	var pendingShareFile = null;
	var shareKey = '';
	function showMeta(clip) {
		document.getElementById('now_title').textContent = clip.portion;
		var place = order.length > 1 ? ((pos + 1) + ' of ' + order.length + ' · ') : '';
		document.getElementById('now_meta').textContent = place + clip.date + ' · ' + clip.time;
		paintAyahRow(clip);
		if (shareKey !== clip.audio) {
			shareToken++;
			shareKey = clip.audio;
			shareReady.status = null;
			shareReady.full = null;
			shareBusy.status = false;
			shareBusy.full = false;
			setShareButton('btn_share', 'Share a short video');
			setShareButton('btn_full', 'Share the full recitation');
			var note = document.getElementById('share_note');
			if (note) note.textContent = 'Share a short video for WhatsApp Status, or share the whole recitation.';
		}
	}

	function paintAyahRow() {
		var row = document.getElementById('ayah_row');
		if (!row) return;
		row.hidden = true;
		row.innerHTML = '';
	}

	function lightAyah(on) {
		var row = document.getElementById('ayah_row');
		if (!row) return;
		var cells = row.querySelectorAll('button');
		var i;
		for (i = 0; i < cells.length; i++) cells[i].classList.toggle('lit', !!on);
	}

	<?php $this->load->view('quran/share_fns'); ?>
	var shareToken = 0;
	var shareReady = { status: null, full: null };
	var shareBusy = { status: false, full: false };
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
		var doneLabel = mode === 'full' ? 'Share the full recitation' : 'Share a short video';
		setShareButton(btnId, 'Making 0%');
		return recordShareVideo(clip, mode, function (frac) {
			if (token !== shareToken) return;
			var pct = Math.max(1, Math.min(99, Math.round((frac || 0) * 100)));
			setShareButton(btnId, 'Making ' + pct + '%');
		}, function () { return token === shareToken; }).then(function (blob) {
			if (token !== shareToken) return;
			shareReady[mode] = new File([blob], shareBaseName(clip, mode), { type: 'video/mp4' });
			setShareButton(btnId, doneLabel);
		}).catch(function (err) {
			if (token !== shareToken) return;
			if (err && err.message === 'cancel') return;
			shareReady[mode] = false;
			setShareButton(btnId, doneLabel);
			var note = document.getElementById('share_note');
			if (note) note.textContent = 'The video could not be made. Open this recitation again.';
		});
	}
	function shareReadyFile(mode) {
		var clip = clips[currentIndex()];
		if (!clip) return;
		if (audioCtx && audioCtx.resume) audioCtx.resume();
		var file = shareReady[mode];
		var note = document.getElementById('share_note');
		if (file && typeof file !== 'boolean') {
			openShareFile(file, clip);
			return;
		}
		if (shareBusy[mode]) {
			if (note) note.textContent = 'The video is still being made.';
			return;
		}
		if (!shareMime()) {
			if (note) note.textContent = 'This phone cannot make an MP4 video.';
			return;
		}
		shareBusy[mode] = true;
		shareToken++;
		var token = shareToken;
		if (note) note.textContent = 'Making the video. Your apps open when it is ready.';
		runShareJob(clip, mode, token).then(function () {
			shareBusy[mode] = false;
			if (token !== shareToken) return;
			var ready = shareReady[mode];
			if (ready && typeof ready !== 'boolean') openShareFile(ready, clip);
		});
	}
	document.getElementById('btn_share').addEventListener('click', function () { shareReadyFile('status'); });
	document.getElementById('btn_full').addEventListener('click', function () { shareReadyFile('full'); });
	function visitAt(t) {
		if (!heard.length) return null;
		var i;
		var hit = -1;
		for (i = 0; i < heard.length; i++) {
			if (Number(heard[i].s) <= t + 0.04) hit = i;
			else break;
		}
		if (hit < 0) return null;
		var ayah = Number(heard[hit].a);
		var start = hit;
		var end = hit;
		while (start > 0 && Number(heard[start - 1].a) === ayah) start--;
		while (end + 1 < heard.length && Number(heard[end + 1].a) === ayah) end++;
		var endTime = end + 1 < heard.length ? Number(heard[end + 1].s) : (audio.duration || Number(heard[end].s) + 1);
		return { ayah: ayah, start: Number(heard[start].s), end: endTime };
	}
	function jumpAyah(dir) {
		if (!heard.length) return false;
		var visit = visitAt(audio.currentTime || 0) || visitAt(Number(heard[0].s));
		if (!visit) return false;
		var target = dir > 0 ? visit.end + 0.05 : (audio.currentTime - visit.start > 1.2 ? visit.start : visit.start - 0.3);
		var next = visitAt(Math.max(0, target));
		if (!next) return false;
		if (dir > 0 && next.ayah === visit.ayah && next.start <= visit.start) return false;
		audio.currentTime = next.start;
		if (audio.paused) {
			var started = audio.play();
			if (started && started.catch) started.catch(function () {});
		}
		return true;
	}
	document.getElementById('btn_next').addEventListener('click', function () {
		if (order.length < 2 && jumpAyah(1)) return;
		step(1);
	});
	document.getElementById('btn_prev').addEventListener('click', function () {
		if (order.length < 2 && jumpAyah(-1)) return;
		step(-1);
	});
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
		repeat = repeat === 'off' ? 'ayah' : (repeat === 'ayah' ? 'all' : 'off');
		paintButtons();
	});
	document.getElementById('btn_tajweed').addEventListener('click', function () {
		var box = document.getElementById('mushaf');
		if (!box) return;
		box.classList.toggle('tajweed');
		var showing = box.classList.contains('tajweed');
		this.classList.toggle('on', showing);
		var key = document.getElementById('tajweed_key');
		if (key) key.hidden = !showing;
		box.querySelectorAll('.w').forEach(function (span) { paintWord(span); });
		if (typeof fitLines === 'function') fitLines();
	});
	document.getElementById('btn_hide').addEventListener('click', function () {
		var box = document.getElementById('mushaf');
		if (!box) return;
		box.classList.toggle('hide-words');
		var on = box.classList.contains('hide-words');
		this.classList.toggle('on', on);
		this.textContent = on ? 'Show words' : 'Hide words';
	});
	document.getElementById('btn_speed').addEventListener('click', function () {
		speedAt = (speedAt + 1) % speeds.length;
		audio.playbackRate = speeds[speedAt];
		paintButtons();
	});

	var seek = document.getElementById('seek');
	seek.addEventListener('pointerdown', function () { seeking = true; });
	seek.addEventListener('pointerup', function () { seeking = false; });
	function knownLength() {
		var marks = 0;
		if (typeof heard !== 'undefined' && heard.length) {
			var last = Number(heard[heard.length - 1].s) || 0;
			if (last > 1) marks = last + 6;
		}
		var d = audio.duration;
		if (d && isFinite(d) && d > 0 && d < 36000) {
			if (marks > d + 1) return marks;
			return d;
		}
		return marks;
	}
	function showClock() {
		var duration = knownLength();
		var now = audio.currentTime;
		if (!isFinite(now) || now < 0 || now > 36000) now = 0;
		document.getElementById('time_now').textContent = clock(now);
		if (duration) document.getElementById('time_end').textContent = clock(duration);
		if (duration && !seeking) {
			seek.value = String(Math.round((Math.min(now, duration) / duration) * 1000));
		}
	}
	seek.addEventListener('input', function () {
		var duration = knownLength();
		if (!duration) return;
		audio.currentTime = (Number(seek.value) / 1000) * duration;
	});
	audio.addEventListener('loadedmetadata', showClock);
	audio.addEventListener('durationchange', showClock);
	audio.addEventListener('timeupdate', function () {
		showClock();
		if (repeat === 'ayah') {
			var visit = visitAt(audio.currentTime);
			var duration = knownLength();
			if (visit && duration && visit.end < duration - 0.25 && audio.currentTime >= visit.end - 0.08) {
				audio.currentTime = visit.start;
			}
		}
		highlight(isFinite(audio.currentTime) ? audio.currentTime : 0);
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
		if (stoppedEarly()) {
			var tries = Number(audio.dataset.retries) || 0;
			if (tries < 1 && audio.dataset.feed) {
				audio.dataset.retries = String(tries + 1);
				audio.dataset.want = '1';
				openStream(audio.dataset.feed, true, audio.currentTime || 0);
				return;
			}
		}
		audio.dataset.want = '0';
		if (repeat === 'ayah') {
			var back = visitAt((audio.duration || 1) - 0.05);
			audio.currentTime = back ? back.start : 0;
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
		openStream(clips[0].audio, false, 0);
	}
})();
</script>
<?php endif; ?>
</body>
</html>
