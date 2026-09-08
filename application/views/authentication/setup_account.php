<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo isset($global_config['institute_name']) ? $global_config['institute_name'] : 'School Management System'; ?>">
    <title>Setup Account — <?php echo isset($global_config['institute_name']) ? $global_config['institute_name'] : ''; ?></title>
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
            <img src="<?php echo base_url('uploads/app_image/logo.png'); ?>" alt="Logo">
        </div>
        <div class="brand-divider"></div>
        <h2 class="brand-title">School<br>Management System</h2>
        <p class="brand-subtitle">Account Setup</p>
        <p class="brand-tagline">Please set your username and password to secure your new account.</p>
    </div>

    <!-- ── Right Form Panel ───────────────────────────────────────── -->
    <main class="form-panel">

        <div class="form-header">
            <img src="<?php echo base_url('uploads/app_image/logo.png'); ?>" class="system-logo" alt="">
            <div class="page-badge">
                <i class="fas fa-user-check"></i> Account Setup
            </div>
            <h1>Secure Your Account</h1>
            <p>Welcome! Please create a unique username and a strong password to activate your account.</p>
        </div>

        <?php echo form_open($this->uri->uri_string()); ?>

            <div class="field-group <?php if (form_error('username')) echo 'has-error'; ?>">
                <label for="setup_username">Choose Username</label>
                <div class="input-wrap">
                    <i class="far fa-user field-icon"></i>
                    <input
                        type="text"
                        id="setup_username"
                        name="username"
                        value="<?php echo set_value('username'); ?>"
                        placeholder="Enter your desired username"
                        autocomplete="off"
                    >
                </div>
                <?php if (form_error('username')): ?>
                <span class="field-error"><?php echo form_error('username'); ?></span>
                <?php endif; ?>
            </div>

            <div class="field-group <?php if (form_error('password')) echo 'has-error'; ?>">
                <label for="setup_password">Create Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input
                        type="password"
                        id="setup_password"
                        name="password"
                        value=""
                        placeholder="Create a strong password"
                        autocomplete="new-password"
                    >
                </div>
                <?php if (form_error('password')): ?>
                <span class="field-error"><?php echo form_error('password'); ?></span>
                <?php endif; ?>
            </div>

            <div class="field-group <?php if (form_error('c_password')) echo 'has-error'; ?>">
                <label for="setup_c_password">Confirm Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input
                        type="password"
                        id="setup_c_password"
                        name="c_password"
                        value=""
                        placeholder="Confirm your password"
                        autocomplete="new-password"
                    >
                </div>
                <?php if (form_error('c_password')): ?>
                <span class="field-error"><?php echo form_error('c_password'); ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" id="btn_submit" class="btn-auth">
                <i class="fas fa-check-circle"></i> Activate Account
            </button>

            <a href="<?php echo base_url("authentication"); ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> <?php echo translate('back_to_login'); ?>
            </a>

        <?php echo form_close(); ?>

        <div class="form-footer">
            <p><?php echo isset($global_config['footer_text']) ? $global_config['footer_text'] : ''; ?></p>
        </div>
    </main>

    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>"></script>

    <script>
    $('form').on('submit', function() {
        var $btn = $('#btn_submit');
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Activating...').prop('disabled', true);
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
