<div class="row">
    <div class="col-md-12">
        <!-- Banner -->
        <div class="panel panel-info" style="border-left: 4px solid #1a6b3c;">
            <div class="panel-body" style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h4 style="margin: 0 0 5px; font-weight: 600; color: #1a6b3c;">
                            <i class="fas fa-paper-plane me-1"></i> Staff Registration Links &amp; Invitations
                        </h4>
                        <p class="text-muted" style="margin: 0;">
                            Share these direct registration links with candidates applying for <strong>Facilitator</strong>, <strong>Accountant</strong>, <strong>Librarian</strong>, or <strong>Receptionist</strong> positions. Submissions will await your review in <a href="<?=base_url('credential_approvals')?>" style="font-weight: 600; color: #1a6b3c; text-decoration: underline;">Registration Approvals</a>.
                        </p>
                    </div>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <button type="button" class="btn btn-default btn-sm" onclick="if(typeof playTahsinNotification==='function') playTahsinNotification(3);" title="Play notification sound 3 times">
                            <i class="fas fa-volume-up" style="color: #e07a5f;"></i> Test Sound (3x)
                        </button>
                        <a href="<?=base_url('credential_approvals')?>" class="btn btn-default btn-sm">
                            <i class="fas fa-user-check"></i> View Pending Approvals
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($this->session->flashdata('generated_invite_link')): ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5 style="font-weight: 600; margin-top: 0;"><i class="fas fa-check-circle"></i> Invitation Link Generated!</h5>
            <p style="margin-bottom: 8px;">
                Registration link for <strong><?=html_escape($this->session->flashdata('generated_invite_name'))?></strong> (<?=html_escape($this->session->flashdata('generated_invite_role'))?>):
            </p>
            <div class="input-group" style="max-width: 650px;">
                <input type="text" class="form-control" id="fresh_invite_input" value="<?=html_escape($this->session->flashdata('generated_invite_link'))?>" readonly>
                <span class="input-group-btn">
                    <button class="btn btn-success" type="button" onclick="copyFreshLink(this)">
                        <i class="fas fa-copy"></i> Copy Link
                    </button>
                    <a href="https://api.whatsapp.com/send?text=<?=urlencode("Assalamu Alaikum, you have been invited to register at Tahsin Academy: " . $this->session->flashdata('generated_invite_link'))?>" target="_blank" class="btn btn-default" style="background: #25D366; color: #fff; border-color: #25D366;">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Quick Role Links Section -->
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-link"></i> Instant Role Registration Links</h4>
            </header>
            <div class="panel-body">
                <p class="text-muted mb-lg">
                    Copy and send any of the links below directly to candidate applicants via WhatsApp, SMS, or Email:
                </p>

                <?php
                // Generate secure tokens for instant links
                $hash_facilitator = urlencode(base64_encode(openssl_encrypt('facilitator', 'AES-128-ECB', 'TAHSIN_SECRET')));
                $hash_accountant = urlencode(base64_encode(openssl_encrypt('accountant', 'AES-128-ECB', 'TAHSIN_SECRET')));
                $hash_librarian = urlencode(base64_encode(openssl_encrypt('librarian', 'AES-128-ECB', 'TAHSIN_SECRET')));
                $hash_receptionist = urlencode(base64_encode(openssl_encrypt('receptionist', 'AES-128-ECB', 'TAHSIN_SECRET')));
                ?>

                <div class="row">
                    <!-- 1. Facilitator -->
                    <div class="col-md-6 col-lg-3 mb-md">
                        <div class="panel panel-bordered" style="border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            <div class="panel-body" style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <div>
                                        <h5 style="margin: 0; font-weight: 700; font-size: 15px;">Facilitator</h5>
                                        <small class="text-muted">Academic &amp; Quran Instructor</small>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <input type="text" class="form-control input-sm" id="link_facilitator" value="<?=base_url('registration?token='.$hash_facilitator)?>" readonly style="background: #f8fafc; font-size: 12px;">
                                </div>
                                <div style="display: flex; gap: 6px;">
                                    <button class="btn btn-default btn-sm btn-block" onclick="copyRoleLink('link_facilitator', this)" style="font-size: 12px;">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                    <a href="https://api.whatsapp.com/send?text=<?=urlencode("Assalamu Alaikum. Registration link for Facilitator position at Tahsin Academy: " . base_url('registration?token='.$hash_facilitator))?>" target="_blank" class="btn btn-default btn-sm" title="Share on WhatsApp" style="color: #25D366;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="<?=base_url('registration?token='.$hash_facilitator)?>" target="_blank" class="btn btn-default btn-sm" title="Preview Form">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Accountant -->
                    <div class="col-md-6 col-lg-3 mb-md">
                        <div class="panel panel-bordered" style="border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            <div class="panel-body" style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: 8px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                        <i class="fas fa-calculator"></i>
                                    </div>
                                    <div>
                                        <h5 style="margin: 0; font-weight: 700; font-size: 15px;">Accountant</h5>
                                        <small class="text-muted">Finance &amp; Bursary Officer</small>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <input type="text" class="form-control input-sm" id="link_accountant" value="<?=base_url('registration?token='.$hash_accountant)?>" readonly style="background: #f8fafc; font-size: 12px;">
                                </div>
                                <div style="display: flex; gap: 6px;">
                                    <button class="btn btn-default btn-sm btn-block" onclick="copyRoleLink('link_accountant', this)" style="font-size: 12px;">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                    <a href="https://api.whatsapp.com/send?text=<?=urlencode("Assalamu Alaikum. Registration link for Accountant position at Tahsin Academy: " . base_url('registration?token='.$hash_accountant))?>" target="_blank" class="btn btn-default btn-sm" title="Share on WhatsApp" style="color: #25D366;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="<?=base_url('registration?token='.$hash_accountant)?>" target="_blank" class="btn btn-default btn-sm" title="Preview Form">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Librarian -->
                    <div class="col-md-6 col-lg-3 mb-md">
                        <div class="panel panel-bordered" style="border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            <div class="panel-body" style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: 8px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                        <i class="fas fa-book-reader"></i>
                                    </div>
                                    <div>
                                        <h5 style="margin: 0; font-weight: 700; font-size: 15px;">Librarian</h5>
                                        <small class="text-muted">Library &amp; Resource Center</small>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <input type="text" class="form-control input-sm" id="link_librarian" value="<?=base_url('registration?token='.$hash_librarian)?>" readonly style="background: #f8fafc; font-size: 12px;">
                                </div>
                                <div style="display: flex; gap: 6px;">
                                    <button class="btn btn-default btn-sm btn-block" onclick="copyRoleLink('link_librarian', this)" style="font-size: 12px;">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                    <a href="https://api.whatsapp.com/send?text=<?=urlencode("Assalamu Alaikum. Registration link for Librarian position at Tahsin Academy: " . base_url('registration?token='.$hash_librarian))?>" target="_blank" class="btn btn-default btn-sm" title="Share on WhatsApp" style="color: #25D366;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="<?=base_url('registration?token='.$hash_librarian)?>" target="_blank" class="btn btn-default btn-sm" title="Preview Form">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Receptionist -->
                    <div class="col-md-6 col-lg-3 mb-md">
                        <div class="panel panel-bordered" style="border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            <div class="panel-body" style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: 8px; background: #f3e8ff; color: #9333ea; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                        <i class="fas fa-concierge-bell"></i>
                                    </div>
                                    <div>
                                        <h5 style="margin: 0; font-weight: 700; font-size: 15px;">Receptionist</h5>
                                        <small class="text-muted">Front Desk &amp; Communications</small>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <input type="text" class="form-control input-sm" id="link_receptionist" value="<?=base_url('registration?token='.$hash_receptionist)?>" readonly style="background: #f8fafc; font-size: 12px;">
                                </div>
                                <div style="display: flex; gap: 6px;">
                                    <button class="btn btn-default btn-sm btn-block" onclick="copyRoleLink('link_receptionist', this)" style="font-size: 12px;">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                    <a href="https://api.whatsapp.com/send?text=<?=urlencode("Assalamu Alaikum. Registration link for Receptionist position at Tahsin Academy: " . base_url('registration?token='.$hash_receptionist))?>" target="_blank" class="btn btn-default btn-sm" title="Share on WhatsApp" style="color: #25D366;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="<?=base_url('registration?token='.$hash_receptionist)?>" target="_blank" class="btn btn-default btn-sm" title="Preview Form">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Direct Email Invitation Form -->
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-envelope-open-text"></i> Send Direct Email Invitation</h4>
            </header>
            <div class="panel-body">
                <form method="post" action="<?=base_url('credential_approvals/invite')?>" class="form-horizontal">
                    <?php echo $this->app_lib->generateCSRF(); ?>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Target Role <span class="required">*</span></label>
                        <div class="col-md-6">
                            <select name="candidate_role" class="form-control" data-plugin-selectTwo data-width="100%" data-minimum-results-for-search="Infinity" required>
                                <option value="">-- Select Role --</option>
                                <?php
                                if (!empty($available_roles)) {
                                    foreach ($available_roles as $role) {
                                        echo '<option value="' . strtolower($role['name']) . '">' . html_escape($role['name']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Candidate Full Name <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="candidate_name" class="form-control" placeholder="e.g. Mallam Ibrahim Musa" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Candidate Email Address <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="email" name="candidate_email" class="form-control" placeholder="candidate@example.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Personal Note from Director</label>
                        <div class="col-md-6">
                            <textarea name="personal_note" rows="3" class="form-control" placeholder="Optional personalized message or instructions from the Director..."></textarea>
                        </div>
                    </div>

                    <footer class="panel-footer" style="background: none; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" name="send_invite" value="1" class="btn btn-default" style="background: #1a6b3c; color: #fff; border-color: #1a6b3c;">
                                    <i class="fas fa-paper-plane"></i> Send Official Registration Link
                                </button>
                            </div>
                        </div>
                    </footer>
                </form>
            </div>
        </section>
    </div>
</div>

<script>
function copyRoleLink(elementId, btn) {
    var copyText = document.getElementById(elementId);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    
    var originalHtml = $(btn).html();
    $(btn).html('<i class="fas fa-check"></i> Copied!').addClass('btn-success').removeClass('btn-default');
    setTimeout(function() {
        $(btn).html(originalHtml).removeClass('btn-success').addClass('btn-default');
    }, 2000);
}

function copyFreshLink(btn) {
    var copyText = document.getElementById('fresh_invite_input');
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    
    var originalHtml = $(btn).html();
    $(btn).html('<i class="fas fa-check"></i> Copied!');
    setTimeout(function() {
        $(btn).html(originalHtml);
    }, 2000);
}
</script>
