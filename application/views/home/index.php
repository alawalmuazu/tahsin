<?php
// Core landing variables — ensure always defined regardless of sliders presence
$url_alias_raw = trim((string) ($cms_setting['url_alias'] ?? ''), '/');
if (strtolower($url_alias_raw) === 'example') {
    $url_alias_raw = '';
}
$app_title = !empty($cms_setting['application_title']) ? $cms_setting['application_title'] : 'Tahsin Academy';
$public_alias = $url_alias_raw;
$admission_url = $public_alias ? base_url($public_alias . '/admission') : base_url('admission');
$results_url = $public_alias ? base_url($public_alias . '/exam_results') : base_url('exam_results');
$admit_card_url = $public_alias ? base_url($public_alias . '/admit_card') : base_url('admit_card');
$authentication_url = $public_alias ? base_url($public_alias . '/authentication') : base_url('authentication');

// Dynamic formatting for headings
$words = explode(' ', $app_title);
$last_word = array_pop($words);
$first_part = implode(' ', $words);
?>
<!-- Main Slider / Hero Section -->
<?php if (!empty($sliders)) { ?>
<section class="main-slider">
    <div class="container-fluid">
        <ul class="main-slider-carousel owl-carousel owl-theme slide-nav">
            <?php
			foreach ($sliders as $key => $value) {
				$elements = json_decode($value['elements'], true);
				$slider_title = $value['title'];
				$slider_title = str_ireplace(array('Wellcome', 'SmartSchool', 'Smart School'), array('Welcome', 'Tahsin Academy', 'Tahsin Academy'), $slider_title);
				$slider_desc = trim((string)$value['description']);
				if (empty($slider_desc) || stripos($slider_desc, 'Lorem Ipsum') !== false || stripos($slider_desc, 'scrambled it') !== false) {
					$slider_desc = 'Excellence In Deen &amp; Duniya — Nurturing future leaders through authentic Islamic values, Quranic memorization, and rigorous academic excellence.';
				}
				$btn1_url = (!empty($elements['button_url1']) && $elements['button_url1'] !== '#' && stripos($elements['button_url1'], 'youtube.com') === false && stripos($elements['button_url1'], 'localhost') === false) ? $elements['button_url1'] : $admission_url;
				$btn1_text = (!empty($elements['button_text1']) && stripos($elements['button_text1'], 'View') === false && stripos($elements['button_text1'], 'Read') === false) ? $elements['button_text1'] : 'Apply for Admission';
				$btn2_url = (!empty($elements['button_url2']) && $elements['button_url2'] !== '#' && stripos($elements['button_url2'], 'localhost') === false) ? $elements['button_url2'] : $results_url;
				$btn2_text = (!empty($elements['button_text2']) && $elements['button_text2'] !== '#') ? $elements['button_text2'] : 'Check Results';
				?>
            <li class="slider-wrapper">
                <div class="image" style="background-image: url(<?php echo base_url('uploads/frontend/slider/' . $elements['image']) ?>)" ></div>
                <div class="slider-caption <?php echo $elements['position'];  ?>">
                    <div class="container">
                        <div class="wrap-caption">
                            <h1><?php echo $slider_title; ?></h1>
                            <div class="text center"><?php echo $slider_desc; ?></div>
                            <div class="link-btn">
                                <a href="<?php echo $btn1_url; ?>" class="btn">
                                    <i class="fas fa-user-plus me-1"></i> <?php echo $btn1_text; ?>
                                </a>
                                <a href="<?php echo $btn2_url; ?>" class="btn btn1">
                                    <i class="fas fa-chart-bar me-1"></i> <?php echo $btn2_text; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide-overlay"></div>
            </li>
            <?php } ?>
        </ul>
    </div>
</section>
<?php } else { ?>
<!-- Fallback Hero when no sliders configured -->
<style>
.ss-branch-hero .ss-hero-bg {
    background: linear-gradient(135deg, #0a1628 0%, #0d2b1a 42%, #0a1628 100%);
}
.ss-branch-hero .ss-branch-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.45) 100%);
    z-index: 1;
}
.ss-branch-hero .ss-hero-content {
    position: relative;
    z-index: 2;
}
.ss-branch-stats .ss-stat-num i {
    font-size: 24px;
    color: var(--thm-primary);
    filter: drop-shadow(0 0 8px rgba(var(--thm-primary-rgb), 0.5));
}
.ss-branch-hero .ss-hero-heading {
    font-size: 2.75rem;
    line-height: 1.15;
    text-shadow: 0 4px 20px rgba(0,0,0,0.5);
    max-width: 16em;
    margin-left: auto;
    margin-right: auto;
}
@media (max-width: 768px) {
    .ss-branch-hero .ss-hero-heading {
        font-size: 1.85rem;
    }
}
</style>
<section class="ss-hero-fallback ss-branch-hero">
    <div class="ss-hero-bg">
        <div class="ss-hero-particles"></div>
        <div class="ss-hero-gradient"></div>
        <div class="ss-branch-overlay"></div>
    </div>
    <div class="container">
        <div class="ss-hero-content">
            <div class="ss-live-badge"><span class="ss-pulse-dot"></span> Admissions Open &bull; 2026/2027 Session</div>
            <div class="ss-hero-badge"><i class="fas fa-mosque"></i> A school of Deen &amp; Duniya</div>
            
            <h1 class="ss-hero-heading">
                Raise a child who <span>knows the Qur&rsquo;an</span> and can stand in the world
            </h1>
            
            <p class="ss-hero-text">Tahsin Academy is a Nigerian Islamic school from Creche to Secondary. We combine Tahfiz, character, and strong academics — with Boarding, Day, and Weekend pathways, with or without technical skills.</p>
            
            <div class="ss-hero-typewriter" id="ss-typewriter"></div>
            
            <div class="ss-hero-actions">
                <a href="<?php echo $admission_url; ?>" class="ss-hero-btn ss-hero-btn-primary">
                    <i class="fas fa-user-plus"></i> Apply for Admission
                </a>
                <a href="#ss-admission-tracks" class="ss-hero-btn ss-hero-btn-outline">
                    <i class="fas fa-route"></i> See Pathways
                </a>
                <a href="<?php echo $results_url; ?>" class="ss-hero-btn ss-hero-btn-outline">
                    <i class="fas fa-chart-bar"></i> Check Results
                </a>
            </div>
            
            <div class="ss-hero-stats">
                <div class="ss-stat"><span class="ss-stat-num">Deen</span><span class="ss-stat-label">&amp; Akhlaaq</span></div>
                <div class="ss-stat-divider"></div>
                <div class="ss-stat"><span class="ss-stat-num">Tahfiz</span><span class="ss-stat-label">&amp; Tajweed</span></div>
                <div class="ss-stat-divider"></div>
                <div class="ss-stat"><span class="ss-stat-num">STEM</span><span class="ss-stat-label">&amp; ICT</span></div>
                <div class="ss-stat-divider"></div>
                <div class="ss-stat"><span class="ss-stat-num">Creche</span><span class="ss-stat-label">To Secondary</span></div>
            </div>
        </div>
    </div>
    <a href="#ss-quick-services" class="ss-scroll-chevron"><i class="fas fa-chevron-down"></i></a>
</section>
<?php } ?>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ IMPACT NUMBERS BAR — NEW LANDING SECTION                          -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="ss-impact-bar">
    <div class="container px-md-0">
        <div class="ss-impact-row">
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-baby"></i></div>
                <div class="ss-impact-num">Creche&ndash;SS3</div>
                <div class="ss-impact-label">Full school years</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-route"></i></div>
                <div class="ss-impact-num">3</div>
                <div class="ss-impact-label">Pathways</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-quran"></i></div>
                <div class="ss-impact-num">Tahfiz</div>
                <div class="ss-impact-label">Quran &amp; Tajweed</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-cogs"></i></div>
                <div class="ss-impact-num">Skills</div>
                <div class="ss-impact-label">Optional technical</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-star-and-crescent"></i></div>
                <div class="ss-impact-num">Deen</div>
                <div class="ss-impact-label">&amp; Duniya</div>
            </div>
        </div>
    </div>
</section>
<div class="container px-md-0 main-container">
    <!-- Features Section Starts -->
    <?php if (!empty($features)) { ?>
    <div class="notification-boxes row">
        <?php
		foreach ($features as $key => $value) {
			$elements = json_decode($value['elements'], true);
            $feature_title = trim((string)$value['title']);
            $feature_desc = trim((string)$value['description']);
            $feature_icon = !empty($elements['icon']) ? $elements['icon'] : 'fas fa-book';
            $btn_url = !empty($elements['button_url']) && $elements['button_url'] !== '#' ? $elements['button_url'] : $admission_url;
            $btn_text = !empty($elements['button_text']) ? $elements['button_text'] : 'Learn More';

            if (stripos($feature_desc, 'Nulla metus') !== false || stripos($feature_desc, 'Lorem Ipsum') !== false) {
                if (stripos($feature_title, 'Online') !== false) {
                    $feature_title = 'Guided Learning';
                    $feature_desc = 'Structured classes, revision, and assessments that keep every child on track.';
                    $feature_icon = 'fas fa-chalkboard-teacher';
                } elseif (stripos($feature_title, 'Scholarship') !== false) {
                    $feature_title = 'Merit & Character';
                    $feature_desc = 'We honour diligence in Qur&rsquo;an, conduct, and academics.';
                    $feature_icon = 'fas fa-award';
                } elseif (stripos($feature_title, 'Book') !== false || stripos($feature_title, 'Liberary') !== false || stripos($feature_title, 'Library') !== false) {
                    $feature_title = 'Library & Resources';
                    $feature_desc = 'Qur&rsquo;an, Arabic, and academic texts that feed both Deen and Duniya.';
                    $feature_icon = 'fas fa-book-reader';
                } elseif (stripos($feature_title, 'Course') !== false) {
                    $feature_title = 'Quran &amp; STEM';
                    $feature_desc = 'Tahfiz and Tajweed alongside sciences, languages, and digital skills.';
                    $feature_icon = 'fas fa-quran';
                } else {
                    $feature_desc = 'A disciplined, caring school that raises children in faith and excellence.';
                }
            }
			?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="box hover-border-outer hover-border">
                <div class="icon"><i class="<?php echo $feature_icon; ?>"></i></div>
                <h4><?php echo $feature_title; ?></h4>
                <p><?php echo $feature_desc; ?></p>
                <a href="<?php echo $btn_url; ?>" class="btn btn-transparent">
                    <?php echo $btn_text; ?>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- ★ QUICK SERVICES PANEL — NEW LANDING SECTION                      -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="ss-quick-services" id="ss-quick-services">
        <div class="ss-section-header">
            <span class="ss-kicker"><i class="fas fa-heart"></i> For Families</span>
            <h2 class="ss-title">Start here, from home</h2>
            <p class="ss-subtitle">Apply, collect an admit card, or check results — without waiting in the office</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo $admission_url; ?>" class="ss-service-card ss-card-admission">
                    <div class="ss-card-glow"></div>
                    <div class="ss-card-icon">
                        <div class="ss-icon-ring">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="ss-icon-pulse"></div>
                    </div>
                    <h3>Online Admission</h3>
                    <p>Choose Boarding, Day, or Weekend Tahfeez. Submit the form and we will guide you through enrolment.</p>
                    <div class="ss-card-action">
                        <span>Apply Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="ss-card-badge">Open</div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo $admit_card_url; ?>" class="ss-service-card ss-card-admitcard">
                    <div class="ss-card-glow"></div>
                    <div class="ss-card-icon">
                        <div class="ss-icon-ring">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="ss-icon-pulse"></div>
                    </div>
                    <h3>Admit Card</h3>
                    <p>Print your child&rsquo;s exam card with their exam and registration number.</p>
                    <div class="ss-card-action">
                        <span>Get Card</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <a href="<?php echo $results_url; ?>" class="ss-service-card ss-card-results">
                    <div class="ss-card-glow"></div>
                    <div class="ss-card-icon">
                        <div class="ss-icon-ring">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="ss-icon-pulse"></div>
                    </div>
                    <h3>Exam Results</h3>
                    <p>See scores and download the report card when results are released.</p>
                    <div class="ss-card-action">
                        <span>Check Results</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- ★ TYPES OF ADMISSION TRACKS — NEW LANDING SECTION                  -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="ss-admission-tracks my-5" id="ss-admission-tracks">
        <div class="ss-section-header text-center mb-4">
            <span class="ss-kicker"><i class="fas fa-graduation-cap"></i> Choose a pathway</span>
            <h2 class="ss-title">How your child can join</h2>
            <p class="ss-subtitle">Every track includes Qur&rsquo;an. You decide boarding or day, weekday or weekend, and whether to add technical skills.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="ss-track-card ss-track-boarding">
                    <div class="ss-track-ribbon">Most immersive</div>
                    <div class="ss-track-head">
                        <div class="ss-track-icon"><i class="fas fa-bed"></i></div>
                        <div>
                            <span class="ss-track-tag">Boarding</span>
                            <h4>Live on campus</h4>
                        </div>
                    </div>
                    <p>A full-time home of Tahfeez, Tajweed, salah, and classwork — children grow in a disciplined, caring community.</p>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Boarding Qur&rsquo;an without technical skills</li>
                        <li><i class="fas fa-check-circle"></i> Boarding Qur&rsquo;an with technical skills</li>
                    </ul>
                    <a href="<?php echo $admission_url; ?>" class="btn btn-1 w-100"><i class="fas fa-user-plus me-1"></i> Apply for Boarding</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="ss-track-card ss-track-day">
                    <div class="ss-track-head">
                        <div class="ss-track-icon"><i class="fas fa-sun"></i></div>
                        <div>
                            <span class="ss-track-tag">Day scholar</span>
                            <h4>Weekdays at school</h4>
                        </div>
                    </div>
                    <p>A regular school day: core subjects, Qur&rsquo;an, Arabic, and optional skills — then home with the family each evening.</p>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Day without technical skills</li>
                        <li><i class="fas fa-check-circle"></i> Day with technical skills</li>
                    </ul>
                    <a href="<?php echo $admission_url; ?>" class="btn btn-outline-primary w-100"><i class="fas fa-user-plus me-1"></i> Apply for Day</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="ss-track-card ss-track-weekend">
                    <div class="ss-track-head">
                        <div class="ss-track-icon"><i class="fas fa-calendar-week"></i></div>
                        <div>
                            <span class="ss-track-tag">Weekend</span>
                            <h4>Saturday &amp; Sunday Tahfeez</h4>
                        </div>
                    </div>
                    <p>For families whose children attend another school on weekdays, or who want focused Qur&rsquo;an time at the weekend.</p>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Weekend Tahfeez with skills</li>
                        <li><i class="fas fa-check-circle"></i> Weekend Tahfeez without technical skills</li>
                    </ul>
                    <a href="<?php echo $admission_url; ?>" class="btn ss-track-weekend-btn w-100"><i class="fas fa-user-plus me-1"></i> Apply for Weekend</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- ★ PLATFORM CAPABILITIES — NEW LANDING SECTION                       -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="ss-capabilities">
        <div class="ss-section-header text-center">
            <span class="ss-kicker"><i class="fas fa-gift"></i> What we offer</span>
            <h2 class="ss-title">What your child receives</h2>
            <p class="ss-subtitle">A complete school life — from first steps in Creche to Secondary — rooted in Islam and ready for the world</p>
        </div>
        <div class="ss-cap-grid">
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-quran"></i></div>
                <h4>Qur&rsquo;an &amp; Tahfiz</h4>
                <p>Memorisation, Tajweed, and daily recitation with caring teachers</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-language"></i></div>
                <h4>Arabic &amp; English</h4>
                <p>Language that opens the Book — and the classroom</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-atom"></i></div>
                <h4>STEM &amp; ICT</h4>
                <p>Mathematics, sciences, and digital literacy for a modern Nigeria</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-hands-helping"></i></div>
                <h4>Akhlaaq &amp; Character</h4>
                <p>Adab, salah, and mentorship that shape who they become</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-child"></i></div>
                <h4>Creche to Secondary</h4>
                <p>One school family as they grow — no sudden change of values</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-tools"></i></div>
                <h4>Technical Skills</h4>
                <p>Optional hands-on training alongside the Qur&rsquo;an track</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-home"></i></div>
                <h4>Boarding Life</h4>
                <p>Safe residency, routine, and a community that feels like home</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-calendar-week"></i></div>
                <h4>Weekend Tahfeez</h4>
                <p>Saturday and Sunday for families who need a flexible path</p>
            </div>
        </div>
    </section>

    <?php
        if (!empty($wellcome)) {
        $elements = json_decode($wellcome[ 'elements' ], true);
        $wel_title = $wellcome['title'];
        $wel_subtitle = $wellcome['subtitle'];
        $wel_desc = $wellcome['description'];
        if (stripos($wel_desc, 'Lorem Ipsum') !== false || stripos($wel_desc, 'distracted by the readable content') !== false || stripos($wel_subtitle, 'We will give you future') !== false) {
            $wel_title = 'Welcome to Tahsin Academy';
            $wel_subtitle = 'Excellence In Deen &amp; Duniya';
            $wel_desc = "Tahsin Academy is committed to providing a transformative educational journey that harmonizes sound Islamic character (Deen) with rigorous modern academics (Duniya).\n\nFrom comprehensive Tahfiz and Tajweed instruction to mathematics, sciences, and digital literacy, our dedicated educators nurture every student's intellect, spirituality, and leadership potential in an inspiring and disciplined environment.";
        }
        ?>
    <!-- Welcome Section Starts -->
    <section class="welcome-area">
        <div class="row align-items-center">
            <div class="col-md-6 col-sm-12">
                <h2 class="main-heading1 lite" style="color: <?php echo $wellcome['color1'] == "" ? '#000' : $wellcome['color1']; ?>"><?php echo $wel_title; ?></h2>
                <div class="sec-title style-two mb-tt">
                    <h2 class="main-heading2"><?php echo $wel_subtitle; ?></h2>
                    <span class="decor"><span class="inner"></span></span>
                </div>
                <?php echo nl2br($wel_desc); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="wel-img">
                    <?php if (!empty($elements['image']) && file_exists(FCPATH . 'uploads/frontend/home_page/' . $elements['image'])) { ?>
                    <img src="<?php echo base_url('uploads/frontend/home_page/' . $elements['image'] . img_reload()); ?>" alt="Tahsin Academy" class="img-fluid">
                    <?php } else { ?>
                    <img src="<?php echo base_url('uploads/app_image/logo.png?v=' . APP_VERSION); ?>" alt="Tahsin Academy" class="img-fluid" style="max-height: 320px; object-fit: contain; margin: 0 auto; display: block;">
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
</div>

<!-- Teachers Section Starts -->
<?php
    if (!empty($teachers)) {
    $elements = json_decode($teachers[ 'elements' ], true);
    $teacher_start = !empty($elements['teacher_start']) ? $elements['teacher_start'] : '';
    $doctor_list = $this->home_model->get_teacher_list($teacher_start, $branchID);
    if (!empty($doctor_list)) {
        $teacher_title = $teachers['title'];
        $teacher_desc = $teachers['description'];
        if (stripos($teacher_desc, 'Lorem Ipsum') !== false || stripos($teacher_desc, 'readable English') !== false || stripos($teacher_title, 'Doctor') !== false) {
            $teacher_title = 'Our Dedicated Educators';
            $teacher_desc = 'Passionate teachers committed to academic rigor, spiritual guidance, and student excellence.';
        }
    ?>
<section class="featured-doctors" style="background-image: url(<?php echo base_url('uploads/frontend/home_page/' . $elements['image']); ?>);">
    <div class="container px-md-0">
        <div class="sec-title text-center">
            <h2 style="color: <?php echo $teachers['color1'] == "" ? '#fff' : $teachers['color1'] ?>"><?php echo $teacher_title ?></h2>
            <p style="color: <?php echo $teachers['color2'] == "" ? '#fff' : $teachers['color2'] ?>"><?php echo nl2br($teacher_desc); ?></p>
            <span class="decor"><span class="inner"></span></span>
        </div>
        <div class="row">
            <?php
			foreach ($doctor_list as $row) {
                ?>
            <div class="col-lg-3 col-sm-6">
                <div class="bio-box">
                    <div class="profile-img">
                        <div class="dlab-border-left"></div>
                        <div class="dlab-border-right"></div>
                        <div class="dlab-media">
                            <img src="<?php echo get_image_url('staff', $row['photo']); ?>" alt="<?php echo $row['name']; ?>" class="img-fluid img-center-sm img-center-xs">
                        </div>
                        <div class="overlay">
                            <div class="overlay-txt">
                                <ul class="list-unstyled list-inline sm-links">
                                    <?php if (!empty($row['facebook_url'])) { ?><li class="list-inline-item"><a href="<?php echo $row['facebook_url']; ?>"><i class="fab fa-facebook-f"></i></a></li><?php } ?>
                                    <?php if (!empty($row['linkedin_url'])) { ?><li class="list-inline-item"><a href="<?php echo $row['linkedin_url']; ?>"><i class="fab fa-linkedin-in"></i></a></li><?php } ?>
                                    <?php if (!empty($row['twitter_url'])) { ?><li class="list-inline-item"><a href="<?php echo $row['twitter_url']; ?>"><i class="fab fa-twitter"></i></a></li><?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="txt-holder txt-overflow">
                        <h5><?php echo $row['name']; ?></h5>
                        <p class="designation"><?php echo $row['department_name']; ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } }
    if (!empty($testimonial)) {
        $this->db->where('branch_id', $branchID);
        $testimonials = $this->db->get('front_cms_testimonial')->result_array();
        $has_real_testimonials = false;
        if (!empty($testimonials)) {
            foreach ($testimonials as $t) {
                $blob = $t['description'] . ' ' . $t['name'];
                $dummy = (stripos($blob, 'Lorem Ipsum') !== false
                    || stripos($blob, 'Fusce sem') !== false
                    || stripos($blob, 'Intexure') !== false
                    || stripos($blob, 'pleasures have to be repudiated') !== false
                    || stripos($blob, 'Clifton Hyde') !== false);
                if (!$dummy) {
                    $has_real_testimonials = true;
                    break;
                }
            }
        }
        if ($has_real_testimonials) {
    ?>
<!-- Testimonial Section Starts -->
<section class="testimonial-wrapper" >
    <div class="container px-md-0">
        <div class="sec-title text-center">
            <h2><?php echo $testimonial['title'] ?></h2>
            <p><?php echo nl2br($testimonial['description']); ?></p>
            <span class="decor"><span class="inner"></span></span>
        </div>
        <div class="testimonial-carousel owl-carousel owl-theme">
        <?php
        foreach ($testimonials as $value) {
            ?>
            <div class="single-testimonial-style">
                <div class="inner-content">
                    <div class="review-box">
                        <ul>
                        <?php 
                        for ($i=1; $i < 6; $i++) {
                            if ($i <= $value['rank']) {
                                echo '<li><i class="fas fa-star"></i></li>';
                            }else{
                                echo '<li><i class="far fa-star"></i></li>';
                            }
                        }
                        ?>
                        </ul>
                    </div>
                    <div class="text-box">
                        <p><?php echo nl2br($value['description']); ?></p>
                    </div>
                    <div class="client-info">
                        <div class="image">
                            <img src="<?php echo $this->testimonial_model->get_image_url($value['image']); ?>" alt="Testimonial">
                        </div>
                        <div class="title">
                            <h3><?php echo $value['name']; ?></h3>
                            <span><?php echo $value['surname']; ?></span>
                        </div>
                    </div>
                </div> 
            </div>
        <?php } ?>      
        </div>
    </div>
</section>
<?php } }
    if (!empty($statistics)) {
    $statisticsElem = json_decode($statistics['elements'], true);
    $stat_title = $statistics['title'];
    $stat_desc = $statistics['description'];
    if (stripos($stat_title, '20 years') !== false || stripos($stat_desc, 'Lorem Ipsum') !== false) {
        $stat_title = 'Tahsin Academy in numbers';
        $stat_desc = 'A growing school family — students, classes, and dedicated teachers.';
    }
    $total_stat_count = 0;
    for ($i=1; $i < 5; $i++) {
        $total_stat_count += (int) $this->home_model->getStatisticsCounter($statisticsElem['type_' . $i] ?? '', $branchID);
    }
    if ($total_stat_count > 5) {
    ?>
<!-- Statistics Section Starts -->
<section class="counters-wrapper" style="background-image: url(<?php echo base_url('uploads/frontend/home_page/' . $statisticsElem['image']); ?>);" >
    <div class="container px-md-0">
        <div class="sec-title text-center">
            <h2 style="color: <?php echo $statistics['color1'] == "" ? '#fff' : $statistics['color1']; ?>"><?php echo $stat_title ?></h2>
            <p style="color: <?php echo $statistics['color2'] == "" ? '#fff' : $statistics['color2']; ?>"><?php echo nl2br($stat_desc); ?></p>
            <span class="decor"><span class="inner"></span></span>
        </div>
        <div class="row">
            <!-- widget count item -->
            <?php for ($i=1; $i < 5; $i++) { ?>
            <div class="col-lg-3 col-sm-6 col-xs-6 text-center">
                <div class="counters-item">
                    <i class="<?php echo $statisticsElem['widget_icon_' . $i] ?>"></i>
                    <div style="color: <?php echo $statistics['color1'] == "" ? '#fff' : $statistics['color1']; ?>">
                        <span class="counter" data-count="<?php echo $this->home_model->getStatisticsCounter($statisticsElem['type_' . $i], $branchID); ?>">0</span>
                    </div>
                    <h3 style="color: <?php echo $statistics['color1'] == "" ? '#fff' : $statistics['color1']; ?>"><?php echo $statisticsElem['widget_title_' . $i]; ?></h3>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php } }
?>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ HOW IT WORKS — NEW LANDING SECTION                              -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="ss-how-it-works">
    <div class="container px-md-0">
        <div class="ss-section-header text-center">
            <span class="ss-kicker"><i class="fas fa-route"></i> Enrolment</span>
            <h2 class="ss-title">Three steps to join</h2>
            <p class="ss-subtitle">Simple for parents. Serious about your child&rsquo;s place here.</p>
        </div>
        <div class="ss-steps-container">
            <div class="ss-steps-line"></div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="ss-step" data-step="1">
                        <div class="ss-step-number">1</div>
                        <div class="ss-step-icon"><i class="fas fa-compass"></i></div>
                        <h4>Pick a pathway</h4>
                        <p>Boarding, Day, or Weekend Tahfeez — with or without technical skills.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="ss-step" data-step="2">
                        <div class="ss-step-number">2</div>
                        <div class="ss-step-icon"><i class="fas fa-file-signature"></i></div>
                        <h4>Apply online</h4>
                        <p>Complete the admission form and we will contact you about the next step.</p>
                        <div class="mt-3"><a href="<?php echo $admission_url; ?>" class="btn btn-sm btn-1" style="border-radius:20px; padding: 6px 18px; font-weight:600;"><i class="fas fa-user-plus me-1"></i> Apply Now</a></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="ss-step" data-step="3">
                        <div class="ss-step-number">3</div>
                        <div class="ss-step-icon"><i class="fas fa-school"></i></div>
                        <h4>Begin at Tahsin</h4>
                        <p>Your child starts class — Qur&rsquo;an, character, and academics under one roof.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ EXECUTIVE DASHBOARD PREVIEW — NEW LANDING SECTION                 -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="ss-dashboard-preview ss-why-tahsin">
    <div class="container px-md-0">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-5 mb-lg-0">
                <span class="ss-kicker"><i class="fas fa-heart"></i> Why families choose us</span>
                <h2 class="ss-title">One school. Two worlds, done well.</h2>
                <ul class="ss-dash-list">
                    <li><i class="fas fa-check-circle"></i> Faith is not an extra period — it is the air of the school</li>
                    <li><i class="fas fa-check-circle"></i> Academics are serious: literacy, numeracy, science, and ICT</li>
                    <li><i class="fas fa-check-circle"></i> Pathways that fit real Nigerian families — boarding, day, or weekend</li>
                    <li><i class="fas fa-check-circle"></i> Teachers who know your child, not only the register</li>
                </ul>
                <a href="<?php echo $admission_url; ?>" class="btn btn-1 ss-dash-btn">Reserve a place <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="ss-deen-duniya ss-reveal">
                    <div class="ss-dd-pane ss-dd-deen">
                        <i class="fas fa-mosque"></i>
                        <h3>Deen</h3>
                        <p>Qur&rsquo;an, salah, adab, and a heart that knows Allah.</p>
                    </div>
                    <div class="ss-dd-amp">&amp;</div>
                    <div class="ss-dd-pane ss-dd-duniya">
                        <i class="fas fa-globe-africa"></i>
                        <h3>Duniya</h3>
                        <p>Schooling, skills, and confidence for life in Nigeria and beyond.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ GOVERNMENT TRUST & COMPLIANCE — NEW LANDING SECTION             -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="ss-gov-trust">
    <div class="container px-md-0">
        <div class="ss-section-header text-center">
            <span class="ss-kicker ss-kicker-light"><i class="fas fa-star-and-crescent"></i> Our foundation</span>
            <h2 class="ss-title ss-title-light">Excellence In Deen &amp; Duniya</h2>
            <p class="ss-subtitle ss-subtitle-light">What we stand for — so you know who is raising your child with us</p>
        </div>
        <div class="ss-gov-cards">
            <div class="row g-4 justify-content-center">
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-mosque"></i></div>
                        <h5>Deen</h5>
                        <p>Islamic knowledge and character at the heart of every day</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-globe-africa"></i></div>
                        <h5>Duniya</h5>
                        <p>Academics and skills that prepare them for life after school</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-quran"></i></div>
                        <h5>Tahfiz</h5>
                        <p>A clear path to memorise and recite the Qur&rsquo;an well</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-users"></i></div>
                        <h5>Family</h5>
                        <p>Parents stay close — admission, results, and conversation</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-shield-alt"></i></div>
                        <h5>Care</h5>
                        <p>Boarding and day children are known, guided, and kept safe</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-compliance-badges">
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Boarding</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Day</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Weekend Tahfeez</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Technical Skills</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Creche to Secondary</div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ TESTIMONIALS / ENDORSEMENTS — NEW LANDING SECTION                 -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="ss-endorsements">
    <div class="container px-md-0">
        <div class="ss-endorsement-grid">
            <div class="ss-quote-card ss-reveal">
                <div class="ss-quote-mark">"</div>
                <p class="ss-quote-text">I wanted a school that would not trade the Qur&rsquo;an for grades, or grades for the Qur&rsquo;an. Tahsin holds both.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Parent, Tahsin Academy</p>
            </div>
            <div class="ss-quote-card ss-reveal">
                <div class="ss-quote-mark">"</div>
                <p class="ss-quote-text">The boarding house feels like a home with purpose. Our son came back more settled, and his recitation improved.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Boarding parent</p>
            </div>
            <div class="ss-quote-card ss-reveal">
                <div class="ss-quote-mark">"</div>
                <p class="ss-quote-text">Weekend Tahfeez let us keep our weekday school and still give our daughter a serious Qur&rsquo;an path.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Weekend family</p>
            </div>
        </div>
    </div>
</section>

<?php
    if (!empty($services) || !empty($cta_box)) {
        $serv_title = !empty($services['title']) ? $services['title'] : 'Why Choose Tahsin Academy';
        $serv_desc = !empty($services['description']) ? $services['description'] : '';
        $is_dummy_service = (stripos($serv_desc, 'Lorem Ipsum') !== false || stripos($serv_title, 'WHY CHOOSE US') !== false);
        if ($is_dummy_service) {
            $serv_title = 'Why Choose Tahsin Academy';
            $serv_desc = 'A balanced, world-class educational foundation integrating classical Islamic scholarship with 21st-century academic and digital competencies.';
        }
        ?>
<!-- Services Section Starts -->      
<div class="" style="background-image: url(<?php echo base_url('assets/frontend/images/14.png') ?>); padding: 60px 0; background-color: <?php echo !empty($services['color2']) ? $services['color2'] : '#fff'; ?>;">
    <div class="container px-md-0">
    <?php if (!empty($services)) { ?>
        <section class="medical-services">
            <div class="sec-title text-center">
                <h2 style="color: <?php echo $services['color1'] == "" ? '#000' : $services['color1']; ?>"><?php echo $serv_title; ?></h2>
                <p><?php echo nl2br($serv_desc); ?></p>
                <span class="decor"><span class="inner"></span></span>
            </div>
            <ul class="list-unstyled row text-center">
                <?php
                $this->db->where('branch_id', $branchID);
				$services_list = $this->db->get('front_cms_services_list')->result_array();
                $clean_services = array(
                    'Online Course Facilities' => array('Guided Classes', 'Clear lessons, revision, and care for every learner.', 'fas fa-chalkboard-teacher'),
                    'Modern Book Library' => array('Library', 'Qur&rsquo;an, Islamic, and academic books in one room.', 'fas fa-book-reader'),
                    'Be Industrial Leader' => array('Character & Leadership', 'Mentorship that grows upright, confident young people.', 'fas fa-user-shield'),
                    'Programming Courses' => array('STEM & Skills', 'Science, ICT, and optional technical training.', 'fas fa-atom'),
                    'Foreign Languages' => array('Arabic & English', 'Language for the Qur&rsquo;an and for the world.', 'fas fa-language'),
                    'Alumni Directory' => array('School Family', 'Parents, teachers, and children walking the same path.', 'fas fa-users'),
                );
			    foreach ($services_list as $key => $value) {
                    $item_title = $value['title'];
                    $item_desc = $value['description'];
                    $item_icon = $value['icon'];
                    if ($is_dummy_service && isset($clean_services[$item_title])) {
                        $clean = $clean_services[$item_title];
                        $item_title = $clean[0];
                        $item_desc  = $clean[1];
                        $item_icon  = $clean[2];
                    } elseif (stripos($item_desc, 'readable') !== false || stripos($item_desc, 'publishing') !== false) {
                        $item_desc = 'Excellence and dedicated instruction for every learner.';
                    }
			    	?>
                <li class="col-lg-2 col-sm-4">
                    <div class="icon">
                        <div class="i-hover"><i class="<?php echo $item_icon; ?>"></i></div>
                    </div>
                    <h5><?php echo $item_title; ?></h5>
                    <p><?php echo (strlen($item_desc) > 60) ? substr($item_desc, 0, 60) . '...' : $item_desc; ?></p>
                </li>
                <?php } ?>
            </ul>
        </section>
    <?php } 
    if (!empty($cta_box)) {
        $elements = json_decode($cta_box[ 'elements' ], true);
        $cta_phone = !empty($cms_setting['mobile_no']) ? $cms_setting['mobile_no'] : (!empty($elements['mobile_no']) && strpos($elements['mobile_no'], '123456') === false && $elements['mobile_no'] !== '08022332233' && $elements['mobile_no'] !== '+12345678' ? $elements['mobile_no'] : '');
        $raw_btn_url = !empty($elements['button_url']) ? trim($elements['button_url']) : '';
        if ($raw_btn_url === '' || $raw_btn_url === '#' || stripos($raw_btn_url, 'localhost') !== false || stripos($raw_btn_url, 'smartschool') !== false) {
            $cta_btn_url = $admission_url;
        } else {
            $cta_btn_url = $raw_btn_url;
        }
        $raw_btn_text = !empty($elements['button_text']) ? trim($elements['button_text']) : '';
        if ($raw_btn_text === '' || $raw_btn_text === '#' || stripos($raw_btn_text, 'Request') !== false) {
            $cta_btn_text = 'Apply for Admission';
        } else {
            $cta_btn_text = $raw_btn_text;
        }
        $cta_title = !empty($cta_box['title']) && stripos($cta_box['title'], 'Appointment') === false ? $cta_box['title'] : 'Begin Your Child\'s Journey at Tahsin Academy';
		?>
        <div class="book-appointment-box" style="background-color: <?php echo $cta_box['color1'] == "" ? '#0f1923' : $cta_box['color1']; ?>;">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-12 text-center text-lg-left">
                    <h4 style="color: <?php echo $cta_box['color2'] == "" ? '#fff' : $cta_box['color2']; ?>;"><?php echo $cta_title; ?></h4>
                    <?php if (!empty($cta_phone)) { ?>
                    <h3 style="color: <?php echo $cta_box['color2'] == "" ? '#fff' : $cta_box['color2']; ?>;"><div class="inner-box"><i class="fa fa-phone"></i></div> <?php echo $cta_phone; ?></h3>
                    <?php } else { ?>
                    <p style="color: rgba(255,255,255,0.85); margin: 0.5rem 0 0; font-size: 1.05rem;">Online admissions are currently open. Apply now to secure enrollment.</p>
                    <?php } ?>
                </div>
                <div class="col-lg-4 col-md-12 text-center text-lg-right mt-3 mt-lg-0">
                    <a href="<?php echo $cta_btn_url; ?>" class="btn btn-main btn-1 text-uppercase"><?php echo $cta_btn_text; ?></a>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?php } ?>


<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ LANDING PAGE SCRIPTS                                           -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<script>
(function($) {
    'use strict';

    // ── Scroll Reveal ─────────────────────────────────────────────────
    var revealTargets = [
        '.ss-service-card', '.ss-step', '.ss-gov-card',
        '.ss-section-header', '.ss-compliance-badges',
        '.ss-impact-item', '.ss-cap-card', '.ss-deen-duniya', '.ss-quote-card', '.ss-track-card'
    ];
    function ssReveal() {
        $(revealTargets.join(',')).each(function() {
            var el = $(this);
            if (el.hasClass('ss-visible')) return;
            var top = el.offset().top;
            var winBot = $(window).scrollTop() + $(window).height();
            if (top < winBot - 60) {
                el.addClass('ss-reveal ss-visible');
            }
        });
    }
    $(window).on('scroll', ssReveal);
    $(document).ready(function() {
        $(revealTargets.join(',')).addClass('ss-reveal');
        setTimeout(ssReveal, 200);

        var phrases = [
            'Boarding. Day. Weekend Tahfeez.',
            'Qur\u2019an first. Academics that last.',
            'Creche to Secondary \u2014 one school family.'
        ];
        var tw = document.getElementById('ss-typewriter');
        if (tw) {
            var i = 0, j = 0, deleting = false;
            function tick() {
                var full = phrases[i];
                tw.textContent = full.slice(0, j);
                if (!deleting && j < full.length) {
                    j++;
                    setTimeout(tick, 55);
                } else if (!deleting && j === full.length) {
                    deleting = true;
                    setTimeout(tick, 1600);
                } else if (deleting && j > 0) {
                    j--;
                    setTimeout(tick, 28);
                } else {
                    deleting = false;
                    i = (i + 1) % phrases.length;
                    setTimeout(tick, 280);
                }
            }
            tick();
        }
    });

})(jQuery);
</script>
