<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo isset($global_config['institute_name']) ? $global_config['institute_name'] : 'Tahsin Academy'; ?>">
    <title>Public Registration — <?php echo isset($global_config['institute_name']) ? $global_config['institute_name'] : 'Tahsin Academy'; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('uploads/app_image/logo.png'); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
    <script src="<?php echo base_url('assets/vendor/jquery/jquery.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert-custom.css'); ?>">
    <script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert.min.js'); ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
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
        <h2 class="brand-title">Tahsin Academy</h2>
        <p class="brand-subtitle">Excellence In Deen &amp; Duniya</p>
        <p class="brand-tagline">School management for Tahsin Academy — students, staff, parents, and academic records in one place.</p>
        <div class="brand-badges">
            <span class="brand-badge">Islamic Environment</span>
            <span class="brand-badge">Modern Curriculum</span>
        </div>
    </div>

    <!-- ── Right Form Panel ───────────────────────────────────────── -->
    <main class="form-panel" style="overflow-y: auto; padding: 40px; justify-content: flex-start;">

        <div class="form-header">
            <img src="<?php echo $this->application_model->getBranchImage($branch_id, 'logo'); ?>" class="system-logo" alt="">
            <div class="page-badge">
                <i class="fas fa-user-plus"></i> Staff Onboarding
            </div>
            <h1>Staff Registration</h1>
            <p>Welcome to Tahsin Academy. Please complete your registration details below. Your submission will be reviewed and approved by the Director before portal activation.</p>
        </div>

        <?php if(isset($registration_closed) && $registration_closed): ?>
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle fa-2x mb-sm"></i><br>
                <strong>Registration Closed!</strong><br>
                Public registration is currently disabled by the Administrator. Please contact the school directly to open an account.
            </div>
        <?php else: ?>

        <?php if(isset($registration_deadline)): ?>
            <div class="alert alert-info" style="font-size: 13px; margin-bottom: 20px; border-radius: 8px;">
                <i class="fas fa-info-circle me-1"></i> <strong>Note:</strong> Registration closes on <strong><?php echo date('l, M d, Y', strtotime($registration_deadline)); ?></strong>.
            </div>
        <?php endif; ?>

        <form class="form-horizontal" method="post" accept-charset="utf-8">
            <?php echo $this->app_lib->generateCSRF(); ?>

            <div class="field-group <?php if (form_error('register_as')) echo 'has-error'; ?>">
                <label for="register_as">Position / Role Applying For <span class="text-danger">*</span></label>
                <div class="input-wrap">
                    <i class="fas fa-user-tag field-icon"></i>
                    <select class="form-control" name="register_as" id="register_as" style="<?php echo !empty($selected_role) ? 'pointer-events: none; background: #eef2f5;' : ''; ?>">
                        <option value="">-- Select Position / Role --</option>
                        <option value="facilitator" <?php echo ($selected_role == 'facilitator' || set_value('register_as') == 'facilitator') ? 'selected' : ''; ?>>Facilitator</option>
                        <option value="accountant" <?php echo ($selected_role == 'accountant' || set_value('register_as') == 'accountant') ? 'selected' : ''; ?>>Accountant</option>
                        <option value="librarian" <?php echo ($selected_role == 'librarian' || set_value('register_as') == 'librarian') ? 'selected' : ''; ?>>Librarian</option>
                        <option value="receptionist" <?php echo ($selected_role == 'receptionist' || set_value('register_as') == 'receptionist') ? 'selected' : ''; ?>>Receptionist</option>
                    </select>
                </div>
                <?php if (form_error('register_as')): ?>
                <span class="field-error"><?php echo form_error('register_as'); ?></span>
                <?php endif; ?>
            </div>

            <!-- Profile Photo Upload -->
            <div style="text-align: center; margin-bottom: 25px;" class="field-group <?php if (form_error('cropped_photo')) echo 'has-error'; ?>">
                <label for="photo_upload" style="cursor: pointer; display: inline-block; position: relative;" title="Click to take or upload a photo">
                    <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; background: #eef2f5; border: 3px solid <?php echo form_error('cropped_photo') ? '#e53935' : '#1a6b3c'; ?>; display: flex; align-items: center; justify-content: center;" id="photo_preview_container">
                        <i class="fas fa-camera fa-2x <?php echo form_error('cropped_photo') ? 'text-danger' : 'text-muted'; ?>" id="photo_placeholder_icon"></i>
                        <img id="photo_preview_img" src="<?php echo set_value('cropped_photo'); ?>" style="width: 100%; height: 100%; object-fit: cover; <?php echo set_value('cropped_photo') ? '' : 'display: none;'; ?>">
                    </div>
                    <div style="position: absolute; bottom: 0; right: 0; background: <?php echo form_error('cropped_photo') ? '#e53935' : '#1a6b3c'; ?>; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        <i class="fas fa-plus"></i>
                    </div>
                </label>
                <input type="file" id="photo_upload" accept="image/*" capture="user" style="display: none;">
                <input type="hidden" name="cropped_photo" id="cropped_photo" value="<?php echo set_value('cropped_photo'); ?>">
                <div style="font-size: 13px; color: <?php echo form_error('cropped_photo') ? '#e53935' : '#6b7280'; ?>; margin-top: 8px; font-weight: 600;">Upload or snap a headshot (Required) <span class="text-danger">*</span></div>
                <?php if (form_error('cropped_photo')): ?>
                <span class="field-error" style="display:block; margin-top:5px; font-weight:600;"><?php echo form_error('cropped_photo'); ?></span>
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
                Tahsin Academy &middot; Excellence In Deen &amp; Duniya
            </p>
            <p style="margin-top:10px;"><a href="<?php echo base_url('authentication'); ?>" style="color: #0366d6; text-decoration: none;">Back to Login</a></p>
        </div>
    </main>

    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>"></script>

    <!-- Cropper Modal -->
    <div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel" style="font-weight: 600; display: inline-block;">Crop Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 2px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 10px;">
                    <div class="img-container" style="max-height: 60vh; overflow: hidden; display: flex; justify-content: center; background: #000;">
                        <img id="cropper_image" src="" style="max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btn_crop" style="background: #1a6b3c; border-color: #1a6b3c;">Crop &amp; Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    var cropper;
    var image = document.getElementById('cropper_image');

    $('#photo_upload').on('change', function(e) {
        var files = e.target.files;
        if (files && files.length > 0) {
            var file = files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                $('#cropperModal').modal('show');
            };
            reader.readAsDataURL(file);
        }
    });

    $('#cropperModal').on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 0.9,
        });
    }).on('hidden.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        $('#photo_upload').val(''); // Reset input so same file can be chosen again
    });

    $('#btn_crop').on('click', function() {
        if (!cropper) return;
        var canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400
        });
        var base64url = canvas.toDataURL('image/jpeg');
        
        $('#photo_preview_img').attr('src', base64url).show();
        $('#photo_placeholder_icon').hide();
        $('#cropped_photo').val(base64url);
        
        $('#cropperModal').modal('hide');
    });

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
