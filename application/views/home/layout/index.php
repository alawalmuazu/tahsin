<?php
$page_data = (isset($page_data) && is_array($page_data)) ? $page_data : array();
$metaKw = $page_data['meta_keyword'] ?? 'Tahsin Academy';
$metaDesc = $page_data['meta_description'] ?? 'Tahsin Academy — Excellence in Deen and Duniya.';
$pageTitle = $page_data['page_title'] ?? 'Tahsin Academy';
$appTitle = $cms_setting['application_title'] ?? SCHOOL_NAME;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="keyword" content="<?php echo html_escape($metaKw); ?>">
		<meta name="description" content="<?php echo html_escape($metaDesc); ?>">
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo base_url('uploads/app_image/logo.png'); ?>">
		<title><?php echo html_escape($pageTitle . ' - ' . $appTitle); ?></title>
		<?php
		if (!isset($global_config) || !is_array($global_config)) {
			$global_config = array('institute_name' => $appTitle);
		} elseif (empty($global_config['institute_name'])) {
			$global_config['institute_name'] = $appTitle;
		}
		$this->load->view('layout/pwa_head', array('global_config' => $global_config));
		?>
		<!-- Bootstrap -->
		<link href="<?php echo base_url() ?>assets/frontend/css/bootstrap.min.css" rel="stylesheet">
		<!-- Template CSS Files  -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/plugins/animate.min.css?v=' . version_combine()); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/responsive.css?v=' . version_combine()); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/owl.carousel.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/select2/css/select2.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert-custom.css?v=' . version_combine());?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/plugins/magnific-popup/magnific-popup.css?v=' . version_combine()); ?>">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/style.css?v=' . version_combine()); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/landing/css/tahsin.css?v=' . (is_file(FCPATH . 'assets/landing/css/tahsin.css') ? filemtime(FCPATH . 'assets/landing/css/tahsin.css') : APP_VERSION)); ?>">
		<script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
		<!-- If user have enabled CSRF proctection this function will take care of the ajax requests and append custom header for CSRF -->
		<script type="text/javascript">
			var base_url = "<?php echo base_url(); ?>";
			var csrfData = <?php echo json_encode(csrf_jquery_token()); ?>;
			$(function($) {
				$.ajaxSetup({
					data: csrfData
				});
			});
		</script>
		<!-- Google Analytics --> 
		<?php echo $cms_setting['google_analytics']; ?>
		
		<!-- Theme Color Options -->
		<script type="text/javascript">
			document.documentElement.style.setProperty('--thm-primary', '<?php echo $cms_setting["primary_color"] ?>');
			document.documentElement.style.setProperty('--thm-hover', '<?php echo $cms_setting["hover_color"] ?>');
			document.documentElement.style.setProperty('--thm-text', '<?php echo $cms_setting["text_color"] ?>');
			document.documentElement.style.setProperty('--thm-secondary-text', '<?php echo $cms_setting["text_secondary_color"] ?>');
			document.documentElement.style.setProperty('--thm-footer-text', '<?php echo $cms_setting["footer_text_color"] ?>');
			document.documentElement.style.setProperty('--thm-radius', '<?php echo $cms_setting["border_radius"] ?>');
		</script>
	</head>
	<body class="ta-body ta-inner">
		<?php $this->load->view('home/layout/header'); ?>
		<main id="main-content" class="ta-inner-offset">
		    <?php echo $main_contents; ?>
		</main>
		<?php $this->load->view('home/layout/footer'); ?>
		<?php $this->load->view('layout/pwa_install'); ?>
	</body>
</html>