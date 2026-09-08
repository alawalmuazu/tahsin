<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo isset($global_config['institute_name']) ? $global_config['institute_name'] : 'SmartSchool'; ?>">
    <title>Public Registration — <?php echo isset($global_config['institute_name']) ? $global_config['institute_name'] : 'SmartSchool'; ?></title>
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
            <img src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" alt="Logo">
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
    <main class="form-panel" style="overflow-y: auto; padding: 40px;">

        <div class="form-header">
            <img src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" class="system-logo" alt="">
            <div class="page-badge">
                <i class="fas fa-clipboard-list"></i> Apply for Account
            </div>
            <h1>Public Registration</h1>
            <p>Welcome! Please fill out the form below to apply for a staff or parent account.</p>
        </div>

        <?php if(isset($registration_closed) && $registration_closed): ?>
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle fa-2x mb-sm"></i><br>
                <strong>Registration Closed!</strong><br>
                Public registration is currently disabled by the Administrator. Please contact the school directly to open an account.
            </div>
        <?php else: ?>

        <form class="form-horizontal" method="post" accept-charset="utf-8">
            <?php echo $this->app_lib->generateCSRF(); ?>

            <div class="field-group <?php if (form_error('register_as')) echo 'has-error'; ?>">
                <label for="register_as">Register As</label>
                <div class="input-wrap">
                    <i class="fas fa-user-tag field-icon"></i>
                    <select class="form-control" name="register_as" id="register_as" style="padding-left: 45px; height: 50px; border-radius: 8px;">
                        <option value="">-- Select Role --</option>
                        <option value="teacher" <?php echo set_select('register_as', 'teacher'); ?>>Teacher</option>
                        <option value="employee" <?php echo set_select('register_as', 'employee'); ?>>Other Employee / Staff</option>
                        <option value="parent" <?php echo set_select('register_as', 'parent'); ?>>Parent / Guardian</option>
                    </select>
                </div>
                <?php if (form_error('register_as')): ?>
                <span class="field-error"><?php echo form_error('register_as'); ?></span>
                <?php endif; ?>
            </div>

            <div class="field-group <?php if (form_error('name')) echo 'has-error'; ?>">
                <label for="name">Full Name</label>
                <div class="input-wrap">
                    <i class="far fa-user field-icon"></i>
                    <input type="text" id="name" name="name" placeholder="John Doe" autocomplete="off" value="<?php echo set_value('name'); ?>">
                </div>
                <?php if (form_error('name')): ?>
                <span class="field-error"><?php echo form_error('name'); ?></span>
                <?php endif; ?>
            </div>

            <div class="field-group <?php if (form_error('email')) echo 'has-error'; ?>">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <i class="far fa-envelope field-icon"></i>
                    <input type="email" id="email" name="email" placeholder="john@example.com" autocomplete="off" value="<?php echo set_value('email'); ?>">
                </div>
                <?php if (form_error('email')): ?>
                <span class="field-error"><?php echo form_error('email'); ?></span>
                <?php endif; ?>
            </div>

            <div class="field-group <?php if (form_error('mobile_no')) echo 'has-error'; ?>">
                <label for="mobile_no">Mobile Number</label>
                <div class="input-wrap">
                    <i class="fas fa-phone field-icon"></i>
                    <input type="text" id="mobile_no" name="mobile_no" placeholder="08012345678" autocomplete="off" value="<?php echo set_value('mobile_no'); ?>">
                </div>
                <?php if (form_error('mobile_no')): ?>
                <span class="field-error"><?php echo form_error('mobile_no'); ?></span>
                <?php endif; ?>
            </div>

            <hr style="border-top: 1px dashed #e1e4e8; margin: 25px 0;">

            <div class="field-group <?php if (form_error('username')) echo 'has-error'; ?>">
                <label for="username">Desired Username</label>
                <div class="input-wrap">
                    <i class="far fa-id-badge field-icon"></i>
                    <input type="text" id="username" name="username" placeholder="Choose a unique username" autocomplete="off" value="<?php echo set_value('username'); ?>">
                </div>
                <?php if (form_error('username')): ?>
                <span class="field-error"><?php echo form_error('username'); ?></span>
                <?php endif; ?>
            </div>

            <div class="field-group <?php if (form_error('password')) echo 'has-error'; ?>">
                <label for="new_password">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input type="password" id="new_password" name="password" placeholder="Create a strong password" autocomplete="new-password">
                    <button type="button" class="toggle-pass" onclick="togglePass(this)" tabindex="-1">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <?php if (form_error('password')): ?>
                <span class="field-error"><?php echo form_error('password'); ?></span>
                <?php endif; ?>
            </div>

            <div class="field-group <?php if (form_error('c_password')) echo 'has-error'; ?>">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-wrap">
                    <i class="fas fa-key field-icon"></i>
                    <input type="password" id="confirm_password" name="c_password" placeholder="Re-enter password" autocomplete="new-password">
                    <button type="button" class="toggle-pass" onclick="togglePass(this)" tabindex="-1">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                <?php if (form_error('c_password')): ?>
                <span class="field-error"><?php echo form_error('c_password'); ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" id="btn_submit" class="btn-auth" style="margin-top:8px;">
                <i class="far fa-check-circle"></i> Submit Application
            </button>
        </form>
        
        <?php endif; ?>

        <div class="form-footer" style="margin-top: 30px;">
            <p><?php echo isset($global_config['footer_text']) ? $global_config['footer_text'] : ''; ?></p>
            <p style="margin-top:6px;font-size:10px;letter-spacing:0.5px;text-transform:uppercase;color:#aaa;">
                Kaduna State Government &middot; Ministry of Education
            </p>
            <p style="margin-top:10px;"><a href="<?php echo base_url('authentication'); ?>" style="color: #0366d6; text-decoration: none;">Back to Login</a></p>
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
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
    });
    </script>
</body>
</html>
