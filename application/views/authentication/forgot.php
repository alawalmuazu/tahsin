<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $global_config['institute_name'] ?>">
    <title><?php echo translate('forgot'); ?> — <?php echo $global_config['institute_name']; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('uploads/app_image/logo.png'); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
    <script src="<?php echo base_url('assets/vendor/jquery/jquery.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert-custom.css'); ?>">
    <script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/auth.css?v=' . APP_VERSION); ?>">

    <script>var base_url = '<?php echo base_url() ?>';</script>
</head>
<body>

    <!-- ── Left Brand Panel ──────────────────────────────────────── -->
    <div class="brand-panel">
        <div class="ring"></div>
        <div class="ring2"></div>
        <div class="brand-logo-wrap">
            <img src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" alt="Tahsin Academy">
        </div>
        <div class="brand-divider"></div>
        <h2 class="brand-title">Tahsin Academy</h2>
        <p class="brand-subtitle">Excellence In Deen &amp; Duniya</p>
        <p class="brand-tagline">School management for Tahsin Academy — students, staff, parents, and academic records in one place.</p>
        <div class="brand-badges">
            <span class="brand-badge">NEMIS</span>
            <span class="brand-badge">WAEC / NECO</span>
            <span class="brand-badge">Academy</span>
        </div>
    </div>

    <!-- ── Right Form Panel ───────────────────────────────────────── -->
    <main class="form-panel">

        <div class="form-header">
            <img src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" class="system-logo" alt="">
            <div class="page-badge">
                <i class="fas fa-key"></i> Account Recovery
            </div>
            <h1>Forgot Password?</h1>
            <p>Enter your username below. If an account is found, you will receive instructions to reset your password.</p>
        </div>

        <?php if ($this->session->flashdata('reset_res') !== null): ?>
        <div class="alert-box alert-success-box">
            <i class="fas fa-check-circle"></i>
            <strong>Instructions Sent!</strong> If that username exists, a password reset link has been sent to the registered email address. Check your inbox.
            <span class="tech-ref">Ref: <?php
                // Tech team: OK = account found + email sent, ERR = no account matched
                $pfx = ($this->session->flashdata('reset_res') == 'true') ? 'OK' : 'ERR';
                echo $pfx . '-' . strtoupper(substr(md5($pfx . date('YmdH') . 'KDNSMS'), 0, 7));
            ?></span>
        </div>
        <?php else: ?>
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            Contact your school administrator if you do not receive a reset link.
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('dev_reset_url')): ?>
        <div class="alert-box alert-success-box" style="margin-top: 15px; border-color: #0d6efd; background-color: #cce5ff; color: #004085;">
            <i class="fas fa-code"></i>
            <strong>Local Dev Mode:</strong> Email sending bypassed. <br>
            <a href="<?php echo $this->session->flashdata('dev_reset_url'); ?>" style="color: #004085; text-decoration: underline; word-break: break-all;">Click here to reset your password</a>
        </div>
        <?php endif; ?>

        <?php echo form_open($this->uri->uri_string()); ?>

            <div class="field-group <?php if (form_error('username')) echo 'has-error'; ?>">
                <label for="forgot_username">Username / Email</label>
                <div class="input-wrap">
                    <i class="far fa-user field-icon"></i>
                    <input
                        type="text"
                        id="forgot_username"
                        name="username"
                        value="<?php echo set_value('username'); ?>"
                        placeholder="Enter your username"
                        autocomplete="username"
                    >
                </div>
                <?php if (form_error('username')): ?>
                <span class="field-error"><?php echo form_error('username'); ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" id="btn_submit" class="btn-auth">
                <i class="far fa-paper-plane"></i> <?php echo translate('forgot'); ?>
            </button>

            <a href="<?php echo base_url("{$this->authentication_model->getSegment(1)}authentication"); ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> <?php echo translate('back_to_login'); ?>
            </a>

        <?php echo form_close(); ?>

        <div class="form-footer">
            <p><?php echo $global_config['footer_text']; ?></p>
            <p style="margin-top:6px;font-size:10px;letter-spacing:0.5px;text-transform:uppercase;color:#aaa;">
                Tahsin Academy &middot; Excellence In Deen &amp; Duniya
            </p>
        </div>
    </main>

    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>"></script>

    <script>
    $('form').on('submit', function() {
        var $btn = $('#btn_submit');
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);
    });
    </script>

    <?php
    $alertclass = "";
    if ($this->session->flashdata('alert-message-success'))       { $alertclass = "success"; }
    elseif ($this->session->flashdata('alert-message-error'))     { $alertclass = "error"; }
    elseif ($this->session->flashdata('alert-message-info'))      { $alertclass = "info"; }
    if ($alertclass != ''): $alert_message = $this->session->flashdata('alert-message-' . $alertclass);
    ?>
    <script>
        swal({
            toast: true, position: 'top-end',
            type: '<?php echo $alertclass; ?>',
            title: '<?php echo addslashes($alert_message); ?>',
            confirmButtonClass: 'btn btn-default',
            buttonsStyling: false, timer: 8000
        });
    </script>
    <?php endif; ?>

</body>
</html>