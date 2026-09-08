<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $global_config['institute_name'] ?>">
    <meta name="author" content="Tahsin Academy">
    <title><?php echo translate('login'); ?> — <?php echo $global_config['institute_name']; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('uploads/app_image/logo.png'); ?>">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
    <script src="<?php echo base_url('assets/vendor/jquery/jquery.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert-custom.css'); ?>">
    <script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/auth.css?v=' . APP_VERSION); ?>">

    <script>
        var base_url = '<?php echo base_url() ?>';
    </script>
</head>
<body>

    <!-- ── Left Brand Panel ──────────────────────────────────────── -->
    <div class="brand-panel" id="brandPanel">
        <div class="ring"></div>
        <div class="ring2"></div>

        <div class="brand-logo-wrap" id="brandLogoWrap">
            <img id="brandLogo" src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" alt="Tahsin Academy">
        </div>

        <div class="brand-divider"></div>

        <h2 class="brand-title" id="brandTitle">Tahsin Academy</h2>
        <p class="brand-subtitle" id="brandSubtitle">Excellence In Deen &amp; Duniya</p>

        <p class="brand-tagline" id="brandTagline">
            School management for Tahsin Academy — students, staff,
            parents, and academic records in one place.
        </p>

        <div class="brand-badges" id="brandBadges">
            <span class="brand-badge">NEMIS</span>
            <span class="brand-badge">WAEC / NECO</span>
            <span class="brand-badge">Academy</span>
        </div>
    </div>

    <!-- ── Right Form Panel ───────────────────────────────────────── -->
    <main class="form-panel">
        <div class="form-header">
            <img src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" class="system-logo" alt="">
            <h1>Welcome back</h1>
            <p>Sign in to <?php echo $global_config['institute_name']; ?></p>
        </div>

        <?php echo form_open($this->uri->uri_string()); ?>

            <!-- Username -->
            <div class="field-group <?php if (form_error('email')) echo 'has-error'; ?>">
                <label for="login_email">Username / Email</label>
                <div class="input-wrap">
                    <i class="far fa-user field-icon"></i>
                    <input
                        type="text"
                        id="login_email"
                        name="email"
                        value="<?php echo set_value('email'); ?>"
                        placeholder="Enter your username"
                        autocomplete="username"
                        autofocus
                    >
                </div>
                <?php if (form_error('email')): ?>
                <span class="field-error"><?php echo form_error('email'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="field-group <?php if (form_error('password')) echo 'has-error'; ?>">
                <label for="login_password">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input
                        type="password"
                        id="login_password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-pass" aria-label="Toggle password visibility" onclick="togglePass(this)" tabindex="-1">
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
                <?php if (form_error('password')): ?>
                <span class="field-error"><?php echo form_error('password'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Remember + Forgot -->
            <div class="login-options">
                <label class="remember-wrap">
                    <input type="checkbox" name="remember" id="remember">
                    <span><?php echo translate('remember'); ?></span>
                </label>
                <a href="<?php echo base_url("{$this->authentication_model->getSegment(1)}forgot"); ?>" class="forgot-link">
                    <?php echo translate('lose_your_password'); ?>
                </a>
            </div>

            <!-- Submit -->
            <button type="submit" id="btn_submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> <?php echo translate('login'); ?>
            </button>

        <?php echo form_close(); ?>

        <!-- Footer -->
        <div class="form-footer">
            <p><?php echo $global_config['footer_text']; ?></p>
            <p style="margin-top:6px; font-size:10px; letter-spacing:0.5px; text-transform:uppercase; color:#666;">
                Tahsin Academy &middot; Excellence In Deen &amp; Duniya
            </p>
        </div>
    </main>

    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>"></script>

    <script>
    // Password toggle
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

    // Button loading state on submit
    $('form').on('submit', function() {
        var $btn = $('#btn_submit');
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Signing in...').prop('disabled', true);
    });

    // ── Branch Identity Cascade ──────────────────────────────────
    (function() {
        var _timer     = null;
        var _lastQuery = '';
        var _default   = {
            title:    'Tahsin Academy',
            subtitle: 'Excellence In Deen & Duniya',
            tagline:  'School management for Tahsin Academy — students, staff, parents, and academic records in one place.',
            logoSrc:  $('#brandLogo').attr('src')
        };

        function updateBrand(data) {
            var $logo     = $('#brandLogoWrap');
            var $title    = $('#brandTitle');
            var $subtitle = $('#brandSubtitle');
            var $tagline  = $('#brandTagline');
            var $badges   = $('#brandBadges');

            // Fade out
            $logo.css('opacity', '0.3');
            $title.css('opacity', '0');

            setTimeout(function() {
                if (data.found) {
                    // School-specific branding
                    $('#brandLogo').attr('src', data.logo_url);
                    $title.html(data.branch_name);
                    $subtitle.text('School Management System');
                    $tagline.text('Welcome to your school portal. Sign in to access your dashboard, records, and resources.');
                    $badges.fadeOut(200);
                } else {
                    // Reset to default academy branding
                    $('#brandLogo').attr('src', _default.logoSrc);
                    $title.html(_default.title);
                    $subtitle.text(_default.subtitle);
                    $tagline.text(_default.tagline);
                    $badges.fadeIn(200);
                }
                // Fade in
                $logo.css('opacity', '1');
                $title.css('opacity', '1');
            }, 350);
        }

        $('#login_email').on('blur', function() {
            var val = $.trim($(this).val());
            if (val === _lastQuery || val.length < 2) return;
            _lastQuery = val;

            // Build CSRF data from the cookie
            var csrfCookie = (document.cookie.match(/school_cookie_name=([^;]+)/) || [])[1] || '';
            var postData  = { username: val, school_csrf_name: csrfCookie };

            clearTimeout(_timer);
            _timer = setTimeout(function() {
                $.ajax({
                    url: '<?= base_url("authentication/branch_context") ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: postData,
                    success: function(res) {
                        updateBrand(res);
                    }
                });
            }, 200);
        });

        // If the field is cleared, reset
        $('#login_email').on('input', function() {
            if ($.trim($(this).val()).length === 0 && _lastQuery !== '') {
                _lastQuery = '';
                updateBrand({ found: false });
            }
        });
    })();
    </script>

    <?php
    $alertclass = "";
    if ($this->session->flashdata('alert-message-success')) {
        $alertclass = "success";
    } elseif ($this->session->flashdata('alert-message-error')) {
        $alertclass = "error";
    } elseif ($this->session->flashdata('alert-message-info')) {
        $alertclass = "info";
    }
    if ($alertclass != ''): $alert_message = $this->session->flashdata('alert-message-' . $alertclass);
    ?>
    <script>
        swal({
            toast: true,
            position: 'top-end',
            type: '<?php echo $alertclass; ?>',
            title: '<?php echo addslashes($alert_message); ?>',
            confirmButtonClass: 'btn btn-default',
            buttonsStyling: false,
            timer: 8000
        });
    </script>
    <?php endif; ?>

</body>
</html>