<?php
$email = trim((string) ($cms_setting['email'] ?? ''));
if ($email === '' || stripos($email, 'lorem') !== false || stripos($email, 'smartschool') !== false) {
    $email = 'info@tahsinacademy.edu.ng';
}
$phone = trim((string) ($cms_setting['mobile_no'] ?? ''));
if (strpos($phone, '123456') !== false || $phone === '08022332233' || strpos($phone, '954-648') !== false) {
    $phone = '';
}
$address = trim((string) ($cms_setting['address'] ?? ''));
if (stripos($address, 'lorem') !== false || strtolower($address) === 'your address' || stripos($address, 'romrog') !== false || stripos($address, 'los angeles') !== false) {
    $address = '';
}
$hours = trim(strip_tags((string) ($cms_setting['working_hours'] ?? '')));
if ($hours === '') {
    $hours = 'Mon – Fri: 8:00 AM – 3:00 PM';
}
$submit = 'Send message';
$map = trim((string) ($page_data['map_iframe'] ?? ''));
$showMap = (bool) preg_match('#^https://(www\.)?google\.com/maps/embed#i', $map);
?>
<section class="ta-page">
    <div class="ta-wrap">
        <div class="ta-kicker">Visit &amp; write</div>
        <h1 class="ta-display">The door is open.</h1>
        <p class="ta-page-lead">Questions about programmes, boarding or admission — send them here. You will reach the academy, not a script.</p>
    </div>
</section>

<section class="ta-page" style="padding-top:0">
    <div class="ta-wrap ta-visit-grid" style="color:inherit">
        <div class="ta-form-card">
            <?php if ($this->session->flashdata('msg_success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('msg_success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('msg_error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('msg_error'); ?></div>
            <?php endif; ?>
            <?php echo form_open($this->uri->uri_string(), array('class' => 'contact-form')); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name'); ?>" />
                            <span class="text-danger"><?php echo form_error('name'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" />
                            <span class="text-danger"><?php echo form_error('email'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phoneno">Phone <span class="required">*</span></label>
                            <input type="text" class="form-control" name="phoneno" id="phoneno" value="<?php echo set_value('phoneno'); ?>" />
                            <span class="text-danger"><?php echo form_error('phoneno'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subject">Subject <span class="required">*</span></label>
                            <input type="text" class="form-control" name="subject" id="subject" value="<?php echo set_value('subject'); ?>" />
                            <span class="text-danger"><?php echo form_error('subject'); ?></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="message">Message <span class="required">*</span></label>
                            <textarea class="form-control" rows="6" name="message" id="message"><?php echo set_value('message'); ?></textarea>
                            <span class="text-danger"><?php echo form_error('message'); ?></span>
                        </div>
                    </div>
                    <?php if (($cms_setting['captcha_status'] ?? '') == 'enable' && !empty($recaptcha)): ?>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <?php echo $recaptcha['widget']; echo $recaptcha['script']; ?>
                            <span class="text-danger"><?php echo form_error('g-recaptcha-response'); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-sm-12">
                        <button type="submit" name="new_patient" value="1" class="ta-btn ta-btn-gold"><?php echo html_escape($submit); ?></button>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
        <aside class="ta-form-card">
            <h3 class="ta-display" style="font-size:28px;margin-bottom:16px">Academy</h3>
            <ul class="ta-facts" style="margin:0">
                <?php if ($address !== ''): ?>
                <li><i class="fas fa-map-marker-alt"></i><span><?php echo nl2br(html_escape($address)); ?></span></li>
                <?php endif; ?>
                <?php if ($phone !== ''): ?>
                <li><i class="fas fa-phone"></i><span><?php echo html_escape($phone); ?></span></li>
                <?php endif; ?>
                <li><i class="far fa-envelope"></i><span><a href="mailto:<?php echo html_escape($email); ?>"><?php echo html_escape($email); ?></a></span></li>
                <li><i class="far fa-clock"></i><span><?php echo html_escape($hours); ?></span></li>
            </ul>
        </aside>
    </div>
</section>
<?php if ($showMap): ?>
<div class="map">
    <iframe width="100%" height="350" src="<?php echo $map; ?>" title="Map" style="border:0" loading="lazy"></iframe>
</div>
<?php endif; ?>
