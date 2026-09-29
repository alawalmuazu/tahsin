<?php
$install = isset($install) ? $install : array('name' => 'Quran', 'short_name' => 'Quran', 'photo' => '', 'student_name' => 'Student');
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
window.addEventListener('beforeinstallprompt', function (event) {
	event.preventDefault();
	window.__quranInstall = event;
	var waiters = window.__quranInstallWait.splice(0);
	waiters.forEach(function (fn) { fn(event); });
});
(function () {
	var saved = '';
	try { saved = localStorage.getItem('quran-theme') || ''; } catch (e) {}
	var theme = saved === 'dark' || saved === 'light'
		? saved
		: (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
	document.documentElement.setAttribute('data-theme', theme);
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
.queue{margin-top:.25rem}
.clip{display:block;width:100%;text-align:left;background:var(--card);border-radius:14px;padding:.85rem 1rem;margin:0 0 .55rem;border:1px solid var(--line);font:inherit;color:inherit;cursor:pointer}
.clip.on{border-color:#0f766e;background:var(--soft)}
html[data-theme="dark"] .clip.on{border-color:var(--accent)}
.clip strong{display:block}
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
		<button type="button" id="theme_toggle" class="theme">Dark</button>
	</div>
	<div class="install">
		<button type="button" id="install_quran">Install <?php echo html_escape($install['name']); ?></button>
		<p id="install_note">Adds Quran to your home screen. The icon is this student's photo.</p>
		<p>One child installs as <strong>Quran</strong>. Each other child in the same family installs as <strong>Quran</strong> plus that child's first name<?php if ($install['name'] !== 'Quran'): ?>, so this one is <strong><?php echo html_escape($install['name']); ?></strong><?php endif; ?>.</p>
	</div>
	<?php if (empty($clips)): ?>
		<p>No sealed recitation is on this playlist yet.</p>
	<?php else: ?>
	<div id="mushaf" class="mushaf empty">Choose a recording. Its ayahs appear here and light up as it plays.</div>
	<div class="player">
		<div class="now-title" id="now_title"><?php echo html_escape($clips[0]['portion']); ?></div>
		<div class="meta" id="now_meta"><?php echo html_escape($clips[0]['date'] . ' · ' . $clips[0]['time'] . ' · ' . $clips[0]['teacher']); ?></div>
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
	</div>
	<div class="queue" id="queue"></div>
	<audio id="qpl_audio" preload="metadata"></audio>
	<script type="application/json" id="qpl_data"><?php echo $clipsJson; ?></script>
	<?php endif; ?>
</div>
<script>
if ('serviceWorker' in navigator) {
	navigator.serviceWorker.register('<?php echo base_url('quran/sw.js'); ?>?v=4', { scope: '<?php echo base_url('quran/'); ?>' }).then(function (reg) {
		return navigator.serviceWorker.ready.then(function () {
			var worker = (reg.active || navigator.serviceWorker.controller);
			if (worker) {
				worker.postMessage({ type: 'cache', url: window.location.href });
			}
			var controlled = navigator.serviceWorker.controller
				&& navigator.serviceWorker.controller.scriptURL.indexOf('quran/sw.js') !== -1;
			var warmed = false;
			try { warmed = sessionStorage.getItem('quran-sw-ready') === '1'; } catch (e) {}
			if (!controlled && !warmed) {
				try { sessionStorage.setItem('quran-sw-ready', '1'); } catch (e2) {}
				navigator.serviceWorker.addEventListener('controllerchange', function () {
					window.location.reload();
				});
			}
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
	if (ios) {
		return 'On iPhone, tap Share, then Add to Home Screen.';
	}
	return 'Tap the three dots at the top of Chrome, then Install app or Add to Home screen.';
}
function quranRunInstall(event) {
	event.prompt();
	event.userChoice.then(function () { window.__quranInstall = null; });
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
		quranRunInstall(window.__quranInstall);
		return;
	}
	note.textContent = 'Preparing install…';
	var done = false;
	var timer = setTimeout(function () {
		if (done) return;
		done = true;
		note.textContent = quranInstallHelp();
	}, 4000);
	window.__quranInstallWait.push(function (event) {
		if (done) return;
		done = true;
		clearTimeout(timer);
		quranRunInstall(event);
	});
});
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
			btn.querySelector('.meta').textContent = clip.date + ' · ' + clip.time + ' · ' + clip.teacher;
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

	function showMeta(clip) {
		document.getElementById('now_title').textContent = clip.portion;
		document.getElementById('now_meta').textContent = (pos + 1) + ' of ' + order.length + ' · ' + clip.date + ' · ' + clip.time + ' · ' + clip.teacher;
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

	function timeAt(cum, abs, target) {
		var lo = 0;
		var hi = cum.length - 1;
		while (lo < hi) {
			var mid = (lo + hi) >> 1;
			if (cum[mid] < target) lo = mid + 1;
			else hi = mid;
		}
		return abs[Math.min(lo, abs.length - 1)];
	}

	function buildTimings(buffer, wordCount) {
		var channel = buffer.getChannelData(0);
		var hop = Math.max(1, Math.floor(buffer.sampleRate * 0.02));
		var energies = [];
		var times = [];
		var i;
		for (i = 0; i + hop < channel.length; i += hop) {
			var sum = 0;
			var j;
			for (j = 0; j < hop; j++) {
				var sample = channel[i + j];
				sum += sample * sample;
			}
			energies.push(sum / hop);
			times.push(i / buffer.sampleRate);
		}
		if (!energies.length || wordCount < 1) return null;
		var sorted = energies.slice().sort(function (a, b) { return a - b; });
		var noise = sorted[Math.floor(sorted.length * 0.35)] || 0;
		var thresh = Math.max(noise * 3, (sorted[Math.floor(sorted.length * 0.6)] || 0) * 0.35);
		var cum = [0];
		var abs = [times[0]];
		for (i = 0; i < energies.length; i++) {
			var voice = energies[i] > thresh ? energies[i] - thresh : 0;
			cum.push(cum[cum.length - 1] + voice);
			abs.push(times[i] + (hop / buffer.sampleRate));
		}
		if (cum[cum.length - 1] <= 0) return null;
		var total = cum[cum.length - 1];
		var built = [];
		for (i = 0; i < wordCount; i++) {
			built.push({
				start: timeAt(cum, abs, total * (i / wordCount)),
				end: timeAt(cum, abs, total * ((i + 1) / wordCount))
			});
		}
		return built;
	}

	function decodeTimings(url, wordCount) {
		var key = url + '|' + wordCount;
		if (timingCache[key]) return timingCache[key];
		if (!audioCtx) {
			var Ctx = window.AudioContext || window.webkitAudioContext;
			if (!Ctx) {
				timingCache[key] = Promise.resolve(null);
				return timingCache[key];
			}
			audioCtx = new Ctx();
		}
		timingCache[key] = fetch(url)
			.then(function (res) { return res.arrayBuffer(); })
			.then(function (buf) { return audioCtx.decodeAudioData(buf); })
			.then(function (decoded) { return buildTimings(decoded, wordCount); })
			.catch(function () { return null; });
		return timingCache[key];
	}

	function armTimings(clip) {
		var token = ++timingToken;
		var count = words.length;
		timings = null;
		if (!count) return;
		decodeTimings(clip.audio, count).then(function (built) {
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
		paintButtons();
		cancelAnimationFrame(frame);
		frame = requestAnimationFrame(follow);
	});
	audio.addEventListener('pause', paintButtons);
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

	showMeta(clips[0]);
	renderText(clips[0]);
	renderQueue();
	paintButtons();
	audio.src = clips[0].audio;
})();
</script>
<?php endif; ?>
</body>
</html>
