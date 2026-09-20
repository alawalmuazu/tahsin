<link rel="stylesheet" href="<?php echo base_url('assets/css/pwa-install.css?v=' . (is_file(FCPATH . 'assets/css/pwa-install.css') ? filemtime(FCPATH . 'assets/css/pwa-install.css') : version_combine())); ?>">
<div id="tahsin-pwa-banner" role="dialog" aria-live="polite" aria-label="Install app">
	<div class="pwa-banner-body">
		<p class="pwa-banner-title">Add to Home Screen</p>
		<p class="pwa-banner-msg" data-pwa-msg>Install Tahsin on your phone for quick access.</p>
	</div>
	<div class="pwa-banner-actions">
		<button type="button" class="pwa-btn pwa-btn-install" data-pwa-action>Install</button>
		<button type="button" class="pwa-btn pwa-btn-dismiss" data-pwa-dismiss>Not now</button>
	</div>
</div>
<script src="<?php echo base_url('assets/js/pwa-install.js?v=' . (is_file(FCPATH . 'assets/js/pwa-install.js') ? filemtime(FCPATH . 'assets/js/pwa-install.js') : version_combine())); ?>"></script>
