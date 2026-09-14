<?php
$online_open = !empty($online_open);
$email = trim((string) ($cms_setting['email'] ?? ''));
if ($email === '' || stripos($email, 'lorem') !== false || stripos($email, 'smartschool') !== false) {
    $email = 'info@tahsinacademy.edu.ng';
}
$phone = trim((string) ($cms_setting['mobile_no'] ?? ''));
if (strpos($phone, '123456') !== false || $phone === '08022332233') {
    $phone = '';
}
$address = trim((string) ($cms_setting['address'] ?? ''));
if (stripos($address, 'lorem') !== false || strtolower($address) === 'your address') {
    $address = '';
}
$hours = trim(strip_tags((string) ($cms_setting['working_hours'] ?? '')));
if ($hours === '') {
    $hours = 'Mon – Fri: 8:00 AM – 3:00 PM';
}
$selected_section = set_value('section_id');
$arraySection = $this->app_lib->getBranchSections($branchID);
$arrayClass = $this->app_lib->getClassesBySection($selected_section);
$arrayCategory = $this->app_lib->getStudentCategory($branchID);
$arrayGender = array(
    '' => translate('select'),
    'male' => translate('male'),
    'female' => translate('female'),
);
$contactURL = base_url('contact');
?>
<section class="ta-page ta-page-compact">
    <div class="ta-wrap">
        <div class="ta-kicker"><?php echo $online_open ? 'Public application' : 'Admission at the academy'; ?></div>
        <h1 class="ta-display"><?php echo $online_open ? 'Apply for a place' : 'Come to Tahsin.'; ?></h1>
        <p class="ta-page-lead">
            <?php if ($online_open): ?>
                Choose boarding, day or weekend, then the programme. This is an application — not enrolment. Fees and register numbers are completed at the academy after approval.
            <?php else: ?>
                Admission is done at the academy. Visit with the child and a guardian. The office will complete the rest.
            <?php endif; ?>
        </p>
        <?php $this->load->view('landing/payment_notice'); ?>
    </div>
</section>

<?php if (!$online_open): ?>
<section class="ta-path ta-admit-closed">
    <div class="ta-wrap">
        <div class="ta-kicker">How a child enters</div>
        <h2 class="ta-display">Three steps. No website form.</h2>
        <div class="ta-steps">
            <article class="ta-step">
                <b>01</b>
                <h3>Visit the academy</h3>
                <p>Come during school hours with the child and a parent or guardian. Bring a recent passport photograph if you have one.</p>
            </article>
            <article class="ta-step">
                <b>02</b>
                <h3>Choose the track</h3>
                <p>Boarding, Day or Weekend — then With or Without Technical Skills. The Quran stays at the centre of every path.</p>
            </article>
            <article class="ta-step">
                <b>03</b>
                <h3>Office completes admission</h3>
                <p>The office records the child and you leave with a register number — not a pending web form.</p>
            </article>
        </div>
    </div>
</section>

<section class="ta-programmes" id="programmes">
    <div class="ta-wrap">
        <div class="ta-cards">
            <article class="ta-card">
                <div class="ta-card-mode">Boarding</div>
                <h3>Quran House</h3>
                <p>Live in. Rise with the Quran. Immersion for families who want memorization, routine, and a school that does not end at the last bell.</p>
                <div class="ta-pills">
                    <span class="ta-pill">Without technical skills</span>
                    <span class="ta-pill">With technical skills</span>
                </div>
            </article>
            <article class="ta-card">
                <div class="ta-card-mode">Day</div>
                <h3>Day School</h3>
                <p>Weekdays at Tahsin, evenings at home. Deen and classroom without leaving the family house.</p>
                <div class="ta-pills">
                    <span class="ta-pill">Without technical skills</span>
                    <span class="ta-pill">With technical skills</span>
                </div>
            </article>
            <article class="ta-card">
                <div class="ta-card-mode">Weekend</div>
                <h3>Weekend Tahfeez</h3>
                <p>For students whose week is already spoken for. Saturdays and Sundays given to the Quran.</p>
                <div class="ta-pills">
                    <span class="ta-pill">Tahfeez without skills</span>
                    <span class="ta-pill">Tahfeez with skills</span>
                </div>
            </article>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="ta-page" style="padding-top:0">
    <div class="ta-wrap ta-admit-layout<?php echo $online_open ? '' : ' is-closed'; ?>">
        <?php if ($online_open): ?>
        <div class="ta-form-card ta-admit-card">
            <?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-horizontal frm-submit-data', 'id' => 'ta-admission-form')); ?>

            <div class="ta-admit-block">
                <div class="ta-admit-head">
                    <span>01</span>
                    <div>
                        <h2>Programme</h2>
                        <p>Choose boarding, day or weekend, then the programme.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Section <span class="required">*</span></label>
                            <?php echo form_dropdown('section_id', $arraySection, $selected_section, "class='form-control' id='section_id' data-class-target='#class_id' data-plugin-selectTwo data-width='100%'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Class <span class="required">*</span></label>
                            <?php echo form_dropdown('class_id', $arrayClass, set_value('class_id'), "class='form-control' id='class_id' data-plugin-selectTwo data-width='100%'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category <span class="required">*</span></label>
                            <?php echo form_dropdown('category_id', $arrayCategory, set_value('category_id'), "class='form-control' id='category_id' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ta-admit-block">
                <div class="ta-admit-head">
                    <span>02</span>
                    <div>
                        <h2>Student</h2>
                        <p>Names, identity and where the child lives.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>First name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo set_value('first_name'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Surname <span class="required">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo set_value('last_name'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Other name(s)</label>
                            <input type="text" class="form-control" name="other_name" value="<?php echo set_value('other_name'); ?>" placeholder="Optional" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gender <span class="required">*</span></label>
                            <?php echo form_dropdown('gender', $arrayGender, set_value('gender'), "class='form-control' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Birthday <span class="required">*</span></label>
                            <input type="text" class="form-control" name="birthday" value="<?php echo set_value('birthday'); ?>" data-plugin-datepicker data-plugin-options='{ "startView": 2 }' autocomplete="off" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Religion <span class="required">*</span></label>
                            <?php echo form_dropdown('religion', nigeria_religions(), set_value('religion', 'Islam'), "class='form-control' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>NIN <small>(optional)</small></label>
                            <input type="text" class="form-control" name="nin" maxlength="11" inputmode="numeric" placeholder="11-digit NIN" value="<?php echo set_value('nin'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Student mobile</label>
                            <input type="text" class="form-control" name="mobileno" value="<?php echo set_value('mobileno'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Student email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>State <span class="required">*</span></label>
                            <?php echo form_dropdown('state', nigeria_states(), set_value('state'), "class='form-control' id='state' data-lga-target='#lga' data-plugin-selectTwo data-width='100%'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>LGA <span class="required">*</span></label>
                            <?php echo form_dropdown('lga', nigeria_lgas_for_state(set_value('state')), set_value('lga'), "class='form-control' id='lga' data-plugin-selectTwo data-width='100%'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address <span class="required">*</span></label>
                            <textarea name="current_address" rows="2" class="form-control"><?php echo set_value('current_address'); ?></textarea>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Passport photograph <small>(optional)</small></label>
                            <input type="file" name="student_photo" class="form-control" accept="image/jpeg,image/png,image/jpg" />
                            <span class="error"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ta-admit-block">
                <div class="ta-admit-head">
                    <span>03</span>
                    <div>
                        <h2>Guardian</h2>
                        <p>The adult we will call. Portal logins are created later at the academy, not here.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Guardian name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="grd_name" value="<?php echo set_value('grd_name'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Relation <span class="required">*</span></label>
                            <input type="text" class="form-control" name="grd_relation" value="<?php echo set_value('grd_relation'); ?>" placeholder="Father, Mother, Uncle…" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Father's name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="father_name" value="<?php echo set_value('father_name'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mother's name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="mother_name" value="<?php echo set_value('mother_name'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Occupation <span class="required">*</span></label>
                            <input type="text" class="form-control" name="grd_occupation" value="<?php echo set_value('grd_occupation'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mobile <span class="required">*</span></label>
                            <input type="text" class="form-control" name="grd_mobileno" value="<?php echo set_value('grd_mobileno'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" class="form-control" name="grd_email" value="<?php echo set_value('grd_email'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>State <span class="required">*</span></label>
                            <?php echo form_dropdown('grd_state', nigeria_states(), set_value('grd_state'), "class='form-control' id='grd_state' data-lga-target='#grd_lga' data-plugin-selectTwo data-width='100%'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>LGA <span class="required">*</span></label>
                            <?php echo form_dropdown('grd_lga', nigeria_lgas_for_state(set_value('grd_state')), set_value('grd_lga'), "class='form-control' id='grd_lga' data-plugin-selectTwo data-width='100%'"); ?>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address <span class="required">*</span></label>
                            <textarea name="grd_address" rows="2" class="form-control"><?php echo set_value('grd_address'); ?></textarea>
                            <span class="error"></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (($cms_setting['captcha_status'] ?? '') == 'enable' && !empty($recaptcha)): ?>
            <div class="form-group">
                <?php echo $recaptcha['widget']; echo $recaptcha['script']; ?>
                <span class="error"></span>
            </div>
            <?php endif; ?>

            <button type="submit" class="ta-btn ta-btn-gold" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Sending">Submit application</button>
            <p class="ta-admit-note">This form is an application, not enrolment. The academy reviews it, then fees and register numbers are completed in the office.</p>
            <?php echo form_close(); ?>
        </div>
        <?php endif; ?>

        <aside class="ta-admit-side">
            <div class="ta-form-card">
                <h3 class="ta-display" style="font-size:28px;margin:0 0 8px">Academy</h3>
                <p class="ta-muted"><?php echo $online_open ? 'Questions before you apply — write or visit.' : 'Come during these hours. Staff will take the admission from there.'; ?></p>
                <ul class="ta-facts" style="margin:16px 0 0">
                    <?php if ($address !== ''): ?>
                    <li><i class="fas fa-map-marker-alt"></i><span><?php echo nl2br(html_escape($address)); ?></span></li>
                    <?php endif; ?>
                    <?php if ($phone !== ''): ?>
                    <li><i class="fas fa-phone"></i><span><?php echo html_escape($phone); ?></span></li>
                    <?php endif; ?>
                    <li><i class="far fa-envelope"></i><span><a href="mailto:<?php echo html_escape($email); ?>"><?php echo html_escape($email); ?></a></span></li>
                    <li><i class="far fa-clock"></i><span><?php echo html_escape($hours); ?></span></li>
                </ul>
                <a class="ta-btn ta-btn-line" href="<?php echo $contactURL; ?>">Write to us</a>
            </div>

            <div class="ta-form-card">
                <h3 class="ta-display" style="font-size:24px;margin:0 0 8px">Already applied?</h3>
                <p class="ta-muted">Check an existing application with the reference number you were given.</p>
                <?php echo form_open('home/checkAdmissionStatus', array('class' => 'form-horizontal frm-submit-data')); ?>
                    <div class="form-group">
                        <label>Reference number</label>
                        <input type="text" class="form-control" name="refno" placeholder="e.g. 48291033" />
                        <span class="error"></span>
                    </div>
                    <button type="submit" class="ta-btn ta-btn-gold" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Checking">Check status</button>
                <?php echo form_close(); ?>
            </div>
        </aside>
    </div>
</section>

<?php if ($online_open): ?>
<script>
(function ($) {
    function refreshSelect2($el) {
        if ($el && $el.length && $el.data('select2')) {
            $el.trigger('change.select2');
        }
    }
    $(document).on('change', '[data-class-target]', function () {
        var sectionId = $(this).val();
        var $class = $($(this).attr('data-class-target'));
        if (!$class.length) {
            return;
        }
        if (!sectionId) {
            $class.html('<option value="">Select Section First</option>');
            refreshSelect2($class);
            return;
        }
        $.ajax({
            url: base_url + 'ajax/getClassBySection',
            type: 'POST',
            data: { section_id: sectionId },
            success: function (html) {
                $class.html(html);
                refreshSelect2($class);
            }
        });
    });
    $(document).on('change', '[data-lga-target]', function () {
        var $target = $($(this).attr('data-lga-target'));
        if (!$target.length) {
            return;
        }
        $.ajax({
            url: base_url + 'ajax/getLgaByState',
            type: 'POST',
            data: { state: $(this).val() || '', selected: '' },
            success: function (html) {
                $target.html(html);
                $target.val('');
                refreshSelect2($target);
            }
        });
    });
})(jQuery);
</script>
<?php endif; ?>
