<?php
// Core landing variables — ensure always defined regardless of sliders presence
$url_alias_raw = trim((string) ($cms_setting['url_alias'] ?? ''), '/');
if (strtolower($url_alias_raw) === 'example') {
    $url_alias_raw = '';
}
$is_statewide = empty($url_alias_raw);
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
				?>
            <li class="slider-wrapper">
                <div class="image" style="background-image: url(<?php echo base_url('uploads/frontend/slider/' . $elements['image']) ?>)" ></div>
                <div class="slider-caption <?php echo $elements['position'];  ?>">
                    <div class="container">
                        <div class="wrap-caption">
                            <h1><?php echo $value['title']; ?></h1>
                            <div class="text center"><?php echo $value['description']; ?></div>
                            <div class="link-btn">
                                <a href="<?php echo $elements['button_url1']; ?>" class="btn">
                                    <?php echo $elements['button_text1']; ?>
                                </a>
                                <a href="<?php echo $elements['button_url2']; ?>" class="btn btn1">
                                    <?php echo $elements['button_text2']; ?>
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
    background: linear-gradient(135deg, var(--thm-primary) 0%, #111 100%);
}
.ss-branch-hero .ss-branch-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.4) 100%);
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
    font-size: 4rem; /* Adjusted for potentially longer school names */
    line-height: 1.1;
    text-shadow: 0 4px 20px rgba(0,0,0,0.5);
}
@media (max-width: 768px) {
    .ss-branch-hero .ss-hero-heading {
        font-size: 2.5rem;
    }
}
</style>
<section class="ss-hero-fallback <?php echo !$is_statewide ? 'ss-branch-hero' : ''; ?>">
    <div class="ss-hero-bg">
        <div class="ss-hero-particles"></div>
        <div class="ss-hero-gradient"></div>
        <?php if (!$is_statewide): ?>
        <div class="ss-branch-overlay"></div>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="ss-hero-content">
            <div class="ss-live-badge"><span class="ss-pulse-dot"></span> Admissions Open &bull; 2026/2027 Session</div>
            <div class="ss-hero-badge"><i class="fas fa-graduation-cap"></i> Tahsin Academy</div>
            
            <h1 class="ss-hero-heading">
                <?php echo !empty($first_part) ? $first_part . ' ' : 'Tahsin '; ?><span><?php echo !empty($last_word) ? $last_word : 'Academy'; ?></span>
            </h1>
            
            <p class="ss-hero-text">Excellence In Deen &amp; Duniya — Nurturing future leaders through authentic Islamic values, Quranic memorization, and rigorous academic excellence.</p>
            
            <div class="ss-hero-typewriter"></div>
            
            <div class="ss-hero-actions">
                <a href="<?php echo $admission_url; ?>" class="ss-hero-btn ss-hero-btn-primary">
                    <i class="fas fa-user-plus"></i> Apply for Admission
                </a>
                <a href="<?php echo $results_url; ?>" class="ss-hero-btn ss-hero-btn-outline">
                    <i class="fas fa-chart-bar"></i> Check Results
                </a>
                <a href="<?php echo $admission_url; ?>" class="ss-hero-btn ss-hero-btn-outline">
                    <i class="fas fa-search"></i> Admission Status
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
                <div class="ss-impact-icon"><i class="fas fa-school"></i></div>
                <div class="ss-impact-num"><span class="counter" data-count="1">0</span></div>
                <div class="ss-impact-label">Academy</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="ss-impact-num"><span class="counter" data-count="30">0</span>+</div>
                <div class="ss-impact-label">Academic Modules</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="ss-impact-num"><span class="counter" data-count="7">0</span></div>
                <div class="ss-impact-label">User Roles</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-cubes"></i></div>
                <div class="ss-impact-num"><span class="counter" data-count="30">0</span>+</div>
                <div class="ss-impact-label">Core Modules</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-layer-group"></i></div>
                <div class="ss-impact-num"><span class="counter" data-count="7">0</span></div>
                <div class="ss-impact-label">User Role Tiers</div>
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

            // Sanitize placeholder latin text with authentic Islamic academy copy
            if (stripos($feature_desc, 'Nulla metus') !== false || stripos($feature_desc, 'Lorem Ipsum') !== false) {
                if (stripos($feature_title, 'Online') !== false) {
                    $feature_title = 'Online Learning & CBT';
                    $feature_desc = 'Interactive virtual classrooms and computer-based testing accessible from anywhere.';
                    $feature_icon = 'fas fa-laptop-code';
                } elseif (stripos($feature_title, 'Scholarship') !== false) {
                    $feature_title = 'Scholarship & Merit';
                    $feature_desc = 'Rewarding academic diligence and Quranic memorization excellence.';
                    $feature_icon = 'fas fa-graduation-cap';
                } elseif (stripos($feature_title, 'Book') !== false || stripos($feature_title, 'Liberary') !== false || stripos($feature_title, 'Library') !== false) {
                    $feature_title = 'Books & Library';
                    $feature_desc = 'Rich physical and digital repository of Islamic reference texts and academic literature.';
                    $feature_icon = 'fas fa-book-reader';
                } elseif (stripos($feature_title, 'Course') !== false) {
                    $feature_title = 'Tajweed & STEM';
                    $feature_desc = 'Specialized instruction in Quranic recitation, sciences, languages, and ICT.';
                    $feature_icon = 'fas fa-quran';
                } else {
                    $feature_desc = 'Committed to nurturing excellence in Deen and Duniya through structured learning.';
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
            <span class="ss-kicker"><i class="fas fa-bolt"></i> Quick Access</span>
            <h2 class="ss-title">Student & Parent Services</h2>
            <p class="ss-subtitle">Access essential school services instantly — no login required</p>
        </div>
        <div class="row g-4">
            <!-- Card 1: Online Admission -->
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
                    <p>Apply for enrollment from anywhere. Upload documents, track your application status, and receive instant confirmation.</p>
                    <div class="ss-card-action">
                        <span>Apply Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="ss-card-badge">Popular</div>
                </a>
            </div>
            <!-- Card 2: Admit Card -->
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
                    <p>Download and print your exam admit card instantly. Just enter your exam and registration number to get started.</p>
                    <div class="ss-card-action">
                        <span>Get Card</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
            <!-- Card 3: Exam Results -->
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
                    <p>Check your examination results and download your report card. View detailed scores across all subjects instantly.</p>
                    <div class="ss-card-action">
                        <span>Check Results</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- ★ PLATFORM CAPABILITIES — NEW LANDING SECTION                       -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="ss-capabilities">
        <div class="ss-section-header text-center">
            <span class="ss-kicker"><i class="fas fa-layer-group"></i> Comprehensive Platform</span>
            <h2 class="ss-title">Platform Capabilities</h2>
            <p class="ss-subtitle">Modules built for Tahsin Academy — academics, fees, exams, and parent access</p>
        </div>
        <div class="ss-cap-grid">
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-laptop-code"></i></div>
                <h4>Computer-Based Testing</h4>
                <p>Built-in exam engine — no third-party dependency</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-chart-bar"></i></div>
                <h4>NEMIS Reporting</h4>
                <p>School data exports at one click</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-money-bill-wave"></i></div>
                <h4>Fee & Payroll</h4>
                <p>End-to-end finance with full audit trails</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-bus"></i></div>
                <h4>Transport & Hostel</h4>
                <p>Routes, beds, and billing — fully automated</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-calendar-check"></i></div>
                <h4>Smart Timetabling</h4>
                <p>Clash-free schedules generated automatically</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-sms"></i></div>
                <h4>Bulk SMS & Comms</h4>
                <p>Reach every Tahsin parent instantly</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-globe"></i></div>
                <h4>Academy Website</h4>
                <p>News, galleries, and admissions on tahsinacademy.ng</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-shield-alt"></i></div>
                <h4>Secure Access</h4>
                <p>Role-based access for staff, parents, and students</p>
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
                if (stripos($t['description'], 'Lorem Ipsum') === false && stripos($t['description'], 'Fusce sem') === false) {
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
            <h2 style="color: <?php echo $statistics['color1'] == "" ? '#fff' : $statistics['color1']; ?>"><?php echo $statistics['title'] ?></h2>
            <p style="color: <?php echo $statistics['color2'] == "" ? '#fff' : $statistics['color2']; ?>"><?php echo nl2br($statistics['description']); ?></p>
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
            <span class="ss-kicker"><i class="fas fa-route"></i> Getting Started</span>
            <h2 class="ss-title">How It Works</h2>
            <p class="ss-subtitle">Three simple steps to get started with Tahsin Academy</p>
        </div>
        <div class="ss-steps-container">
            <div class="ss-steps-line"></div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="ss-step" data-step="1">
                        <div class="ss-step-number">1</div>
                        <div class="ss-step-icon"><i class="fas fa-search-location"></i></div>
                        <h4>Visit the Portal</h4>
                        <p>Open Tahsin Academy online to apply, check results, and stay connected with your school.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="ss-step" data-step="2">
                        <div class="ss-step-number">2</div>
                        <div class="ss-step-icon"><i class="fas fa-file-signature"></i></div>
                        <h4>Register & Enroll</h4>
                        <p>Complete the online admission form, upload required documents, and submit your application.</p>
                        <div class="mt-3"><a href="<?php echo $admission_url; ?>" class="btn btn-sm btn-1" style="border-radius:20px; padding: 6px 18px; font-weight:600;"><i class="fas fa-user-plus me-1"></i> Apply Now</a></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="ss-step" data-step="3">
                        <div class="ss-step-number">3</div>
                        <div class="ss-step-icon"><i class="fas fa-chart-bar"></i></div>
                        <h4>Track Progress</h4>
                        <p>Access exam results, download admit cards, monitor attendance, and stay connected with your school.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ EXECUTIVE DASHBOARD PREVIEW — NEW LANDING SECTION                 -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="ss-dashboard-preview">
    <div class="container px-md-0">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-5 mb-lg-0">
                <span class="ss-kicker"><i class="fas fa-chart-pie"></i> Executive Intelligence</span>
                <h2 class="ss-title">Real-Time Academy Dashboard</h2>
                <ul class="ss-dash-list">
                    <li><i class="fas fa-check-circle"></i> Live student and staff records for Tahsin Academy</li>
                    <li><i class="fas fa-check-circle"></i> Fee collection, attendance, and exam performance</li>
                    <li><i class="fas fa-check-circle"></i> Reports and results generated in one place</li>
                </ul>
                <a href="<?php echo isset($authenticationURL) ? $authenticationURL : base_url('authentication'); ?>" class="btn btn-1 ss-dash-btn">See the Dashboard <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="ss-dash-mock ss-reveal">
                    <div class="ss-dash-topbar">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                    </div>
                    <div class="ss-dash-content">
                        <div class="ss-dash-stats-row">
                            <div class="ss-dash-stat-box box-1"></div>
                            <div class="ss-dash-stat-box box-2"></div>
                            <div class="ss-dash-stat-box box-3"></div>
                        </div>
                        <div class="ss-dash-chart-row">
                            <div class="ss-dash-chart">
                                <div class="ss-dash-bar" style="height: 40%"></div>
                                <div class="ss-dash-bar" style="height: 70%"></div>
                                <div class="ss-dash-bar" style="height: 55%"></div>
                                <div class="ss-dash-bar" style="height: 90%"></div>
                                <div class="ss-dash-bar" style="height: 65%"></div>
                            </div>
                            <div class="ss-dash-table">
                                <div class="ss-table-line"></div>
                                <div class="ss-table-line dark"></div>
                                <div class="ss-table-line"></div>
                                <div class="ss-table-line dark"></div>
                            </div>
                        </div>
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
            <span class="ss-kicker ss-kicker-light"><i class="fas fa-shield-alt"></i> Our Foundation</span>
            <h2 class="ss-title ss-title-light">Why Tahsin Academy</h2>
            <p class="ss-subtitle ss-subtitle-light">Excellence In Deen &amp; Duniya — faith, character, and strong academics</p>
        </div>
        <div class="ss-gov-cards">
            <div class="row g-4 justify-content-center">
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-mosque"></i></div>
                        <h5>Deen</h5>
                        <p>Islamic knowledge and character at the heart of every student&rsquo;s journey</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-globe"></i></div>
                        <h5>Duniya</h5>
                        <p>Modern academics, skills, and digital learning for life beyond school</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-user-graduate"></i></div>
                        <h5>Academics</h5>
                        <p>Classes, exams, results, and progress tracking in one portal</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-users"></i></div>
                        <h5>Parents</h5>
                        <p>Admission, fees, attendance, and communication from home</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-shield-alt"></i></div>
                        <h5>Secure Portal</h5>
                        <p>Role-based access for staff, students, and parents</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-compliance-badges">
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Data Encrypted</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Role-Based Access</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Online Admissions</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Instant Results</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Tahsin Academy</div>
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
                <p class="ss-quote-text">Tahsin Academy keeps our children&rsquo;s results, attendance, and fees in one place — we finally see everything clearly.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Parent, Tahsin Academy</p>
            </div>
            <div class="ss-quote-card ss-reveal">
                <div class="ss-quote-mark">"</div>
                <p class="ss-quote-text">Admissions, marksheets, and class records are simple to manage. The portal matches how we actually run the school.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Administrator, Tahsin Academy</p>
            </div>
            <div class="ss-quote-card ss-reveal">
                <div class="ss-quote-mark">"</div>
                <p class="ss-quote-text">Online exams and instant results save us weeks of marking and paper work every term.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Teacher, Tahsin Academy</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ NEARBY SCHOOLS FINDER — NEW LANDING SECTION                     -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="ss-school-finder">
    <div class="container px-md-0">
        <div class="ss-section-header text-center">
            <span class="ss-kicker"><i class="fas fa-map-marker-alt"></i> Discover</span>
            <h2 class="ss-title">Join Tahsin Academy</h2>
            <p class="ss-subtitle">Search our portal and apply for admission online</p>
        </div>
        <div class="ss-finder-box">
            <div class="ss-finder-inner">
                <div class="ss-finder-glow"></div>
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-5">
                        <label class="ss-finder-label">Search Tahsin Academy</label>
                        <div class="ss-finder-input-wrap">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control ss-finder-input" id="ssSchoolSearch" placeholder="Type a programme or campus..." autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="ss-finder-label">Filter by Class</label>
                        <div class="ss-finder-input-wrap">
                            <i class="fas fa-map-pin"></i>
                            <input type="text" class="form-control ss-finder-input" id="ssWardFilter" placeholder="Enter class or section..." autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <button class="btn btn-1 ss-finder-btn" id="ssFinderBtn" onclick="ssUseMyLocation()">
                            <i class="fas fa-location-arrow"></i> Use My Location
                        </button>
                    </div>
                </div>
                <div class="ss-finder-results" id="ssFinderResults" style="display:none;">
                    <div class="ss-finder-results-header">
                        <span id="ssResultCount">0</span> results found
                    </div>
                    <div class="ss-finder-results-list" id="ssResultsList"></div>
                </div>
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
                    'Online Course Facilities' => array('Online Learning & CBT', 'Modern digital testing and learning management tools.', 'fas fa-laptop-code'),
                    'Modern Book Library' => array('Modern Library', 'Rich selection of Quranic, Islamic, and academic books.', 'fas fa-book-reader'),
                    'Be Industrial Leader' => array('Character & Leadership', 'Mentorship programs nurturing upright future leaders.', 'fas fa-user-shield'),
                    'Programming Courses' => array('Digital & STEM Skills', 'Computer science, practical coding, and digital literacy.', 'fas fa-code'),
                    'Foreign Languages' => array('Quranic Arabic & English', 'Fluency in Quranic Arabic alongside standard English.', 'fas fa-language'),
                    'Alumni Directory' => array('Community & Mentorship', 'Engaged parent-teacher partnerships and supportive network.', 'fas fa-users'),
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
        '.ss-finder-box', '.ss-section-header', '.ss-compliance-badges',
        '.ss-impact-item', '.ss-cap-card', '.ss-dash-mock', '.ss-quote-card'
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
        // Add reveal class to targets
        $(revealTargets.join(',')).addClass('ss-reveal');
        // Initial check
        setTimeout(ssReveal, 200);
    });

    // ── School Finder Search ──────────────────────────────────────────
    var ssSearchTimer = null;
    var ssSchoolData = [];
    var ssDataLoaded = false;

    function ssLoadSchools(callback) {
        if (ssDataLoaded) { if (callback) callback(); return; }
        $.ajax({
            url: base_url + 'home/getSchoolList',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                if (Array.isArray(data)) {
                    ssSchoolData = data;
                }
                ssDataLoaded = true;
                if (callback) callback();
            },
            error: function() {
                // Fallback: try branch list from footer dropdown
                var opts = $('#activateSchool option');
                ssSchoolData = [];
                opts.each(function() {
                    var v = $(this).val(), t = $(this).text();
                    if (v && v !== '') {
                        ssSchoolData.push({ id: v, name: t, lga: '' });
                    }
                });
                ssDataLoaded = true;
                if (callback) callback();
            }
        });
    }

    function ssFilterSchools() {
        var q = ($('#ssSchoolSearch').val() || '').toLowerCase().trim();
        var w = ($('#ssWardFilter').val() || '').toLowerCase().trim();
        if (!q && !w) {
            $('#ssFinderResults').slideUp(200);
            return;
        }
        ssLoadSchools(function() {
            var results = ssSchoolData.filter(function(s) {
                var nameMatch = !q || (s.name && s.name.toLowerCase().indexOf(q) !== -1);
                var lgaMatch = !w || (s.lga && s.lga.toLowerCase().indexOf(w) !== -1) ||
                               (s.city && s.city.toLowerCase().indexOf(w) !== -1) ||
                               (s.name && s.name.toLowerCase().indexOf(w) !== -1);
                return nameMatch && lgaMatch;
            }).slice(0, 15);

            $('#ssResultCount').text(results.length);
            var html = '';
            if (results.length === 0) {
                html = '<div style="text-align:center;padding:20px;color:var(--thm-secondary-text);">No schools found matching your search.</div>';
            } else {
                results.forEach(function(s) {
                    var alias = (s.url_alias || s.alias || '');
                    var url = alias ? (base_url + alias + '/admission') : (base_url + 'admission');
                    html += '<a class="ss-finder-result-item" href="' + url + '">' +
                        '<div class="school-info">' +
                            '<div class="school-icon"><i class="fas fa-school"></i></div>' +
                            '<div><div class="school-name">' + (s.name || s.school_name || 'School') + '</div>' +
                            '<div class="school-lga">' + (s.lga || s.city || s.address || '') + '</div></div>' +
                        '</div>' +
                        '<div class="school-action">Apply <i class="fas fa-arrow-right"></i></div>' +
                    '</a>';
                });
            }
            $('#ssResultsList').html(html);
            $('#ssFinderResults').slideDown(300);
        });
    }

    $(document).on('input', '#ssSchoolSearch, #ssWardFilter', function() {
        clearTimeout(ssSearchTimer);
        ssSearchTimer = setTimeout(ssFilterSchools, 350);
    });

    // ── Geolocation ───────────────────────────────────────────────────
    window.ssUseMyLocation = function() {
        var btn = $('#ssFinderBtn');
        if (!navigator.geolocation) {
            btn.html('<i class="fas fa-exclamation-triangle"></i> Not Supported');
            return;
        }
        btn.html('<i class="fas fa-spinner fa-spin"></i> Locating...');
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                btn.html('<i class="fas fa-check-circle"></i> Located!');
                // Show all schools (location-aware filtering would need lat/lng in branch table)
                ssLoadSchools(function() {
                    $('#ssSchoolSearch').val('');
                    $('#ssWardFilter').val('');
                    var results = ssSchoolData.slice(0, 10);
                    $('#ssResultCount').text(results.length + '+');
                    var html = '<div style="padding:10px 0 6px;color:var(--thm-primary);font-weight:700;font-size:13px;"><i class="fas fa-info-circle"></i> Showing nearby schools. Refine by typing school name or ward.</div>';
                    results.forEach(function(s) {
                        var alias = (s.url_alias || s.alias || '');
                        var url = alias ? (base_url + alias + '/admission') : (base_url + 'admission');
                        html += '<a class="ss-finder-result-item" href="' + url + '">' +
                            '<div class="school-info">' +
                                '<div class="school-icon"><i class="fas fa-school"></i></div>' +
                                '<div><div class="school-name">' + (s.name || s.school_name || 'School') + '</div>' +
                                '<div class="school-lga">' + (s.lga || s.city || '') + '</div></div>' +
                            '</div>' +
                            '<div class="school-action">Apply <i class="fas fa-arrow-right"></i></div>' +
                        '</a>';
                    });
                    $('#ssResultsList').html(html);
                    $('#ssFinderResults').slideDown(300);
                });
                setTimeout(function() {
                    btn.html('<i class="fas fa-location-arrow"></i> Use My Location');
                }, 3000);
            },
            function() {
                btn.html('<i class="fas fa-location-arrow"></i> Use My Location');
                swal({
                    toast: true, position: 'top-end', type: 'info',
                    title: 'Location access denied. Please type your ward or school name instead.',
                    confirmButtonClass: 'btn btn-default', buttonsStyling: false, timer: 5000
                });
            }
        );
    };

})(jQuery);
</script>
