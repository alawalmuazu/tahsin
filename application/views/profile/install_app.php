<section class="panel">
	<div class="panel-body text-center" style="padding: 48px 24px;">
		<i class="fas fa-mobile-alt" style="font-size: 42px; color: #1a3c2a;"></i>
		<h3 style="margin-top: 16px;">Install Tahsin Academy</h3>
		<p class="text-muted" style="max-width: 460px; margin: 12px auto 24px;">
			Install the app on this device before you open the parent portal. Use the install button, or the browser menu, then open Tahsin from the home screen or the installed app.
		</p>
		<button type="button" id="tahsin-install-btn" class="btn btn-primary btn-lg" style="display:none;">Install app</button>
		<p id="tahsin-install-help" class="text-muted" style="margin-top: 16px;">
			On Chrome or Edge, open the address-bar install icon or the browser menu and choose Install app. On iPhone, tap Share, then Add to Home Screen, then open Tahsin from the home screen.
		</p>
	</div>
</section>
<script>
(function () {
	var doneUrl = <?php echo json_encode(base_url('profile/pwa_done')); ?>;
	function standalone() {
		return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
	}
	if (standalone()) {
		window.location.href = doneUrl;
		return;
	}
	var deferred;
	window.addEventListener('beforeinstallprompt', function (e) {
		e.preventDefault();
		deferred = e;
		var btn = document.getElementById('tahsin-install-btn');
		btn.style.display = 'inline-block';
		btn.addEventListener('click', function () {
			deferred.prompt();
		});
	});
	window.addEventListener('appinstalled', function () {
		window.location.href = doneUrl;
	});
})();
</script>
