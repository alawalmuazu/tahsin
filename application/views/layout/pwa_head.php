<?php
$pwaName = isset($global_config['institute_name']) && $global_config['institute_name'] !== ''
	? $global_config['institute_name']
	: (defined('SCHOOL_NAME') ? SCHOOL_NAME : 'Tahsin Academy');
$pwaIcon192 = base_url('assets/images/pwa/icon-192.png');
$pwaIcon180 = base_url('assets/images/pwa/apple-touch-icon.png');
$pwaManifest = base_url('manifest.webmanifest');
?>
<link rel="manifest" href="<?php echo $pwaManifest; ?>">
<meta name="theme-color" content="#10241e">
<meta name="mobile-web-app-capable" content="yes">
<meta name="application-name" content="<?php echo html_escape($pwaName); ?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="<?php echo html_escape($pwaName); ?>">
<link rel="apple-touch-icon" href="<?php echo $pwaIcon180; ?>">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo $pwaIcon192; ?>">
