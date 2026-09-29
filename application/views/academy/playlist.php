<style>
.qpl{display:flex;gap:1rem;align-items:stretch;min-height:640px}
.qpl-side{width:280px;flex:0 0 280px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;display:flex;flex-direction:column;max-height:calc(100vh - 180px)}
.qpl-side input{margin:.75rem;border:1px solid #d7e3dc;border-radius:8px;padding:.55rem .7rem;font-size:.9rem}
.qpl-list{overflow:auto;padding:0 .5rem .75rem}
.qpl-student{display:flex;gap:.65rem;align-items:center;width:100%;text-align:left;background:#fff;border:1px solid transparent;border-radius:10px;padding:.45rem .5rem;margin:0 0 .25rem;cursor:pointer}
.qpl-student:hover{background:#f4f7f5}
.qpl-student.is-on{background:#ecfdf5;border-color:#99f6e4}
.qpl-student img{width:36px;height:36px;border-radius:10px;object-fit:cover;background:#d7e3dc}
.qpl-student strong{display:block;font-size:.88rem;color:#10241e}
.qpl-student span{display:block;font-size:.75rem;color:#64748b}
.qpl-stage{flex:1;min-width:0;background:#10241e;border-radius:16px;padding:.75rem;display:flex;flex-direction:column}
.qpl-stage p{color:#d7e3dc;margin:0 0 .5rem;font-size:.82rem;padding:0 .35rem}
.qpl-stage iframe{flex:1;width:100%;min-height:620px;border:0;border-radius:12px;background:#f4f7f5}
.qpl-empty{padding:1rem;color:#64748b}
@media (max-width: 860px){
	.qpl{flex-direction:column}
	.qpl-side{width:100%;flex-basis:auto;max-height:280px}
}
</style>

<?php if (empty($students)): ?>
	<p class="qpl-empty">No academy student is enrolled for this session.</p>
<?php else: ?>
<div class="qpl">
	<aside class="qpl-side">
		<input type="search" id="qpl_search" placeholder="Search student" autocomplete="off">
		<div class="qpl-list" id="qpl_list">
			<?php foreach ($students as $st): ?>
			<button type="button" class="qpl-student<?php echo ($current && (int) $current['id'] === (int) $st['id']) ? ' is-on' : ''; ?>" data-id="<?php echo (int) $st['id']; ?>" data-url="<?php echo html_escape($st['url']); ?>" data-name="<?php echo html_escape(strtolower($st['name'])); ?>">
				<img src="<?php echo html_escape($st['photo']); ?>" alt="">
				<span>
					<strong><?php echo html_escape($st['name']); ?></strong>
					<span><?php echo html_escape($st['class_name']); ?></span>
				</span>
			</button>
			<?php endforeach; ?>
		</div>
	</aside>
	<div class="qpl-stage">
		<p>This is the page the parent opens from WhatsApp. Press play on a sealed recitation.</p>
		<iframe id="qpl_frame" title="Parent Quran playlist" src="<?php echo html_escape($current['url']); ?>"></iframe>
	</div>
</div>
<script>
(function () {
	var frame = document.getElementById('qpl_frame');
	var search = document.getElementById('qpl_search');
	var buttons = document.querySelectorAll('.qpl-student');
	function select(btn) {
		for (var i = 0; i < buttons.length; i++) {
			buttons[i].classList.remove('is-on');
		}
		btn.classList.add('is-on');
		frame.src = btn.getAttribute('data-url');
		if (window.history && window.history.replaceState) {
			window.history.replaceState(null, '', '?student=' + btn.getAttribute('data-id'));
		}
	}
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].addEventListener('click', function () { select(this); });
	}
	search.addEventListener('input', function () {
		var q = search.value.toLowerCase().trim();
		for (var i = 0; i < buttons.length; i++) {
			var name = buttons[i].getAttribute('data-name') || '';
			buttons[i].style.display = (q === '' || name.indexOf(q) !== -1) ? '' : 'none';
		}
	});
})();
</script>
<?php endif; ?>
