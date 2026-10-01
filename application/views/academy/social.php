<style>
.soc-note{color:#64748b;margin:0 0 1rem}
.soc-actions{display:flex;flex-wrap:wrap;gap:.5rem;margin:0 0 1rem}
.soc-actions button,.soc-row button{border-radius:999px;font-weight:700}
.soc-row{display:flex;gap:.75rem;align-items:center;padding:.75rem 0;border-top:1px solid #e2e8f0}
.soc-row img{width:46px;height:46px;border-radius:12px;object-fit:cover;background:#d7e3dc}
.soc-row .who{flex:1;min-width:0}
.soc-row strong{display:block;color:#10241e}
.soc-row span{display:block;color:#64748b;font-size:.82rem}
.soc-btns{display:flex;flex-wrap:wrap;gap:.4rem}
.soc-btns button{min-width:9.5rem}
.soc-wait{background:#0f766e;color:#fff;border:0;padding:.45rem .8rem}
.soc-ready{background:#fff;color:#10241e;border:1px solid #0f766e;padding:.45rem .8rem}
.soc-hold{background:#f8fafc;color:#94a3b8;border:1px solid #e2e8f0;padding:.45rem .8rem}
.share-canvas{position:fixed;right:0;bottom:0;width:180px;height:320px;opacity:0;pointer-events:none;z-index:-1}
</style>

<div class="panel">
	<div class="panel-body">
		<p class="soc-note">Make a short Status video or the full recitation, then choose the school’s WhatsApp, Facebook, Instagram, or another app.</p>
		<?php if (empty($students)): ?>
			<p class="soc-note">No sealed recitation is ready to share yet.</p>
		<?php else: ?>
		<div class="soc-actions">
			<button type="button" class="btn btn-primary" id="soc_all_status">Share all for Status</button>
			<button type="button" class="btn btn-default" id="soc_all_full">Share all full videos</button>
		</div>
		<p class="soc-note" id="soc_note">Tap a student’s button. When it says Share for Status or Share full, tap again and pick the school account.</p>
		<div id="soc_list">
			<?php foreach ($students as $st): ?>
			<div class="soc-row" data-id="<?php echo (int) $st['id']; ?>">
				<img src="<?php echo html_escape($st['photo']); ?>" alt="">
				<div class="who">
					<strong><?php echo html_escape($st['name']); ?></strong>
					<span><?php echo html_escape(trim($st['class_name'] . ' · ' . $st['clip']['portion'] . ' · ' . $st['clip']['date'] . ' · ' . $st['clip']['time'])); ?></span>
				</div>
				<div class="soc-btns">
					<button type="button" class="soc-ready" data-share="status" data-id="<?php echo (int) $st['id']; ?>">Share for Status</button>
					<button type="button" class="soc-ready" data-share="full" data-id="<?php echo (int) $st['id']; ?>">Share full</button>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<canvas id="share_canvas" class="share-canvas" width="720" height="1280" aria-hidden="true"></canvas>

<?php if (!empty($students)): ?>
<script type="application/json" id="soc_data"><?php echo $students_json; ?></script>
<script>
(function () {
	var students = JSON.parse(document.getElementById('soc_data').textContent);
	var byId = {};
	var i;
	for (i = 0; i < students.length; i++) byId[students[i].id] = students[i];
	var timingCache = {};
	var audioBufCache = {};
	var audioCtx = null;
	var surahCache = {};
	<?php $this->load->view('quran/share_fns'); ?>
	var files = {};
	var busyKey = '';
	var queue = null;
	var note = document.getElementById('soc_note');

	function buttonFor(id, mode) {
		return document.querySelector('[data-share="' + mode + '"][data-id="' + id + '"]');
	}
	function setLabel(id, mode, text, ready) {
		var el = buttonFor(id, mode);
		if (!el) return;
		el.textContent = text;
		el.className = ready ? 'soc-ready' : 'soc-wait';
	}
	function fileName(row, mode) {
		var base = (row.name + ' - ' + (row.clip.portion || 'Recitation')).replace(/[\\/:*?"<>|]+/g, ' ').replace(/\s+/g, ' ').trim();
		if (base.length > 70) base = base.slice(0, 70);
		return (base || 'Recitation') + (mode === 'full' ? ' full' : '') + '.mp4';
	}
	function openFile(row, mode) {
		var file = files[row.id + ':' + mode];
		if (!file || !navigator.share) {
			if (note && !navigator.share) note.textContent = 'This phone cannot open the share list.';
			return;
		}
		var text = row.name + ' recited ' + row.clip.portion + ' at ' + row.school + '. ' + row.clip.date + ' · ' + row.clip.time + '.';
		var payload = { files: [file], title: row.name + ' — ' + row.clip.portion, text: text };
		if (navigator.canShare && !navigator.canShare(payload)) payload = { files: [file] };
		navigator.share(payload).then(function () {
			if (note) note.textContent = 'Choose the school’s WhatsApp, Facebook, Instagram, or another app.';
			if (queue && queue.mode === mode && queue.ids[queue.index] === row.id) advanceQueue();
		}).catch(function (err) {
			if (err && err.name === 'AbortError') {
				if (queue && queue.mode === mode && queue.ids[queue.index] === row.id) advanceQueue();
				return;
			}
			if (note) note.textContent = 'Tap the button again and choose an app.';
		});
	}
	function recordOne(row, mode) {
		var key = row.id + ':' + mode;
		if (files[key] || busyKey) return Promise.resolve(files[key] || null);
		busyKey = key;
		window.__quranStudent = row.name;
		window.__quranSchool = row.school;
		window.__quranLogo = row.logo;
		window.__quranPhoto = row.photo;
		if (audioCtx && audioCtx.resume) audioCtx.resume();
		setLabel(row.id, mode, (mode === 'full' ? 'Full' : 'Status') + ' 0%', false);
		return recordShareVideo(row.clip, mode, function (frac) {
			if (busyKey !== key) return;
			var pct = Math.max(1, Math.min(99, Math.round((frac || 0) * 100)));
			setLabel(row.id, mode, (mode === 'full' ? 'Full' : 'Status') + ' ' + pct + '%', false);
		}, function () { return busyKey === key; }).then(function (blob) {
			files[key] = new File([blob], fileName(row, mode), { type: 'video/mp4' });
			busyKey = '';
			setLabel(row.id, mode, mode === 'full' ? 'Share full' : 'Share for Status', true);
			return files[key];
		}).catch(function () {
			if (busyKey === key) busyKey = '';
			setLabel(row.id, mode, mode === 'full' ? 'Share full' : 'Share for Status', true);
			if (note) note.textContent = 'The video for ' + row.name + ' could not be made. Tap that student again.';
			return null;
		});
	}
	function advanceQueue() {
		if (!queue) return;
		queue.index += 1;
		if (queue.index >= queue.ids.length) {
			queue = null;
			if (note) note.textContent = 'Every student in this list has been offered to the share sheet.';
			return;
		}
		runQueue();
	}
	function runQueue() {
		if (!queue) return;
		var row = byId[queue.ids[queue.index]];
		if (!row) { advanceQueue(); return; }
		var key = row.id + ':' + queue.mode;
		if (note) note.textContent = 'Making the ' + (queue.mode === 'full' ? 'full video' : 'Status video') + ' for ' + row.name + '.';
		recordOne(row, queue.mode).then(function (file) {
			if (!queue || queue.ids[queue.index] !== row.id) return;
			if (!file) { advanceQueue(); return; }
			if (note) note.textContent = row.name + ' is ready. Tap ' + (queue.mode === 'full' ? 'Share full' : 'Share for Status') + ' and choose the school account.';
		});
	}
	function startQueue(mode) {
		if (busyKey) {
			if (note) note.textContent = 'A video is already being made. Tap its button when it is ready.';
			return;
		}
		if (audioCtx && audioCtx.resume) audioCtx.resume();
		var ids = [];
		for (i = 0; i < students.length; i++) ids.push(students[i].id);
		if (!ids.length) {
			if (note) note.textContent = 'No sealed recitation is ready to share yet.';
			return;
		}
		queue = { mode: mode, ids: ids, index: 0 };
		runQueue();
	}
	document.getElementById('soc_list').addEventListener('click', function (ev) {
		var btn = ev.target.closest ? ev.target.closest('[data-share]') : null;
		if (!btn) return;
		var row = byId[btn.getAttribute('data-id')];
		var mode = btn.getAttribute('data-share');
		if (!row) return;
		if (audioCtx && audioCtx.resume) audioCtx.resume();
		var key = row.id + ':' + mode;
		if (files[key]) {
			openFile(row, mode);
			return;
		}
		if (busyKey === key) return;
		recordOne(row, mode);
	});
	document.getElementById('soc_all_status').addEventListener('click', function () { startQueue('status'); });
	document.getElementById('soc_all_full').addEventListener('click', function () { startQueue('full'); });
})();
</script>
<?php endif; ?>
