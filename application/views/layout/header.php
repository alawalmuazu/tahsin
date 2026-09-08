<head>
	<meta charset="UTF-8">
	<meta name="description" content="<?php echo isset($meta_description) ? html_escape($meta_description) : html_escape($global_config['institute_name']); ?>">
	<meta name="author" content="<?php echo html_escape($global_config['institute_name']); ?>">
	<title><?php echo isset($title) ? html_escape($title) . ' — ' . html_escape($global_config['institute_name']) : html_escape($global_config['institute_name']); ?></title>
	<link rel="icon" type="image/png" href="<?php echo base_url('uploads/app_image/logo.png');?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- include stylesheet -->
	<?php include 'stylesheet.php';?>

	<?php
	if(isset($headerelements)) {
		foreach ($headerelements as $type => $element) {
			if($type == 'css') {
				if(count($element)) {
					foreach ($element as $keycss => $css) {
						echo '<link rel="stylesheet" href="'. base_url('assets/' . $css) . '">' . "\n";
					}
				}
			} elseif($type == 'js') {
				if(count($element)) {
					foreach ($element as $keyjs => $js) {
						echo '<script defer src="' . base_url('assets/' . $js). '"></script>' . "\n";
					}
				}
			}
		}
	}
	?>
	<!-- ramom css -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/ramom.css?v=' . version_combine());?>">
	<?php if ($theme_config["border_mode"] == 'false'): ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/skins/square-borders.css?v=' . version_combine());?>">
	<?php endif; ?>

	<script>
		var base_url = '<?php echo base_url(); ?>';
		var isRTLenabled = '<?php echo $this->app_lib->isRTLenabled(); ?>';
		var csrfData = <?php echo json_encode(csrf_jquery_token()); ?>;
		$(function($) {
			$.ajaxSetup({
				cache: false,
				data: csrfData
			});
		});
	</script>
</head>