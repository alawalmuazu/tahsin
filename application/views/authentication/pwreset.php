<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $global_config['institute_name'] ?>">
    <title><?php echo translate('reset_password'); ?> — <?php echo $global_config['institute_name']; ?></title>
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
            <img src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" alt="Kaduna State Ministry of Education">
        </div>
        <div class="brand-divider"></div>
        <h2 class="brand-title">Kaduna State<br>Ministry of Education</h2>
        <p class="brand-subtitle">School Management System</p>
        <p class="brand-tagline">Unified platform for managing schools, students, staff, and educational data across Kaduna State.</p>
        <div class="brand-badges">
            <span class="brand-badge">NEMIS</span>
            <span class="brand-badge">WAEC / NECO</span>
            <span class="brand-badge">State-wide</span>
        </div>
    </div>

    <!-- ── Right Form Panel ───────────────────────────────────────── -->
    <main class="form-panel">

        <div class="form-header">
            <img src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" class="system-logo" alt="">
            <div class="page-badge">
                <i class="fas fa-shield-alt"></i> Secure Reset
            </div>
            <h1>Set New Password</h1>
            <p>Choose a strong password to protect your account. Make sure both fields match before confirming.</p>
        </div>

        <div class="strength-hint">
            <i class="fas fa-lightbulb"></i>
            Use at least 8 characters — mix uppercase, lowercase, numbers and symbols for a stronger password.
        </div>

        <form class="form-horizontal" method="post" accept-charset="utf-8">
            <?php echo $this->app_lib->generateCSRF(); ?>

            <!-- New Password -->
            <div class="field-group <?php if (form_error('password')) echo 'has-error'; ?>">
                <label for="new_password">New Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input
                        type="password"
                        id="new_password"
                        name="password"
                        placeholder="Enter new password"
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-pass" onclick="togglePass(this)" tabindex="-1">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <?php if (form_error('password')): ?>
                <span class="field-error"><?php echo form_error('password'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="field-group <?php if (form_error('c_password')) echo 'has-error'; ?>">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-wrap">
                    <i class="fas fa-key field-icon"></i>
                    <input
                        type="password"
                        id="confirm_password"
                        name="c_password"
                        placeholder="Re-enter new password"
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-pass" onclick="togglePass(this)" tabindex="-1">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <?php if (form_error('c_password')): ?>
                <span class="field-error"><?php echo form_error('c_password'); ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" id="btn_submit" class="btn-auth" style="margin-top:8px;">
                <i class="far fa-check-circle"></i> Confirm New Password
            </button>

        </form>

        <div class="form-footer">
            <p><?php echo $global_config['footer_text']; ?></p>
            <p style="margin-top:6px;font-size:10px;letter-spacing:0.5px;text-transform:uppercase;color:#aaa;">
                Kaduna State Government &middot; Ministry of Education
            </p>
        </div>
    </main>

    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>"></script>

    <script>
    function togglePass(btn) {
        var input = btn.closest('.input-wrap').querySelector('input');
        var icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'far fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'far fa-eye';
        }
    }

    $('form').on('submit', function() {
        var $btn = $('#btn_submit');
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Confirming...').prop('disabled', true);
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