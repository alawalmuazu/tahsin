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
