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
<?php 
// Determine if we are on a specific branch or the statewide landing page
$is_statewide = empty($cms_setting['url_alias']);
$app_title = !empty($cms_setting['application_title']) ? $cms_setting['application_title'] : 'SmartSchool';

// Dynamic formatting for the hero heading
$words = explode(' ', $app_title);
$last_word = array_pop($words);
$first_part = implode(' ', $words);
?>
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
            <?php if ($is_statewide): ?>
                <div class="ss-live-badge"><span class="ss-pulse-dot"></span> LIVE — 2,000+ Schools Online</div>
                <div class="ss-hero-badge"><i class="fas fa-graduation-cap"></i> Kaduna State Education Platform</div>
            <?php else: ?>
                <div class="ss-live-badge"><span class="ss-pulse-dot"></span> Official School Portal</div>
                <div class="ss-hero-badge"><i class="fas fa-award"></i> Welcome to Excellence</div>
            <?php endif; ?>
            
            <h1 class="ss-hero-heading">
                <?php echo !empty($first_part) ? $first_part . ' ' : ''; ?><span><?php echo $last_word; ?></span>
            </h1>
            
            <?php if ($is_statewide): ?>
                <p class="ss-hero-text">Empowering 2,000+ schools across Kaduna State with seamless digital education management — admissions, results, attendance & more.</p>
            <?php else: ?>
                <p class="ss-hero-text">Welcome to the official portal for <strong><?php echo $app_title; ?></strong>. Access admissions, student records, e-learning resources, and essential services all in one place.</p>
            <?php endif; ?>
            
            <div class="ss-hero-typewriter"></div>
            
            <div class="ss-hero-actions">
                <a href="<?php echo base_url($cms_setting['url_alias'] . '/admission'); ?>" class="ss-hero-btn ss-hero-btn-primary">
                    <i class="fas fa-user-plus"></i> Apply for Admission
                </a>
                <a href="<?php echo base_url($cms_setting['url_alias'] . '/exam_results'); ?>" class="ss-hero-btn ss-hero-btn-outline">
                    <i class="fas fa-chart-bar"></i> Check Results
                </a>
            </div>
            
            <?php if ($is_statewide): ?>
            <div class="ss-hero-stats">
                <div class="ss-stat"><span class="ss-stat-num">2,000+</span><span class="ss-stat-label">Schools</span></div>
                <div class="ss-stat-divider"></div>
                <div class="ss-stat"><span class="ss-stat-num">500K+</span><span class="ss-stat-label">Students</span></div>
                <div class="ss-stat-divider"></div>
                <div class="ss-stat"><span class="ss-stat-num">23</span><span class="ss-stat-label">LGAs</span></div>
            </div>
            <?php else: ?>
            <div class="ss-hero-stats ss-branch-stats">
                <div class="ss-stat"><span class="ss-stat-num"><i class="fas fa-desktop"></i></span><span class="ss-stat-label">Digital</span></div>
                <div class="ss-stat-divider"></div>
                <div class="ss-stat"><span class="ss-stat-num"><i class="fas fa-shield-alt"></i></span><span class="ss-stat-label">Secure</span></div>
                <div class="ss-stat-divider"></div>
                <div class="ss-stat"><span class="ss-stat-num"><i class="fas fa-bolt"></i></span><span class="ss-stat-label">Fast</span></div>
            </div>
            <?php endif; ?>
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
                <div class="ss-impact-num"><span class="counter" data-count="2000">0</span>+</div>
                <div class="ss-impact-label">Schools Connected</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="ss-impact-num"><span class="counter" data-count="500000">0</span>+</div>
                <div class="ss-impact-label">Students Managed</div>
            </div>
            <div class="ss-impact-item">
                <div class="ss-impact-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="ss-impact-num"><span class="counter" data-count="23">0</span></div>
                <div class="ss-impact-label">LGAs Covered</div>
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
    <div class="notification-boxes row">
        <?php
		foreach ($features as $key => $value) {
			$elements = json_decode($value['elements'], true);
			?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="box hover-border-outer hover-border">
                <div class="icon"><i class="<?php echo $elements['icon']; ?>"></i></div>
                <h4><?php echo $value['title']; ?></h4>
                <p><?php echo $value['description']; ?></p>
                <a href="<?php echo $elements['button_url']; ?>" class="btn btn-transparent">
                    <?php echo $elements['button_text']; ?>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>

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
                <a href="<?php echo base_url($cms_setting['url_alias'] . '/admission'); ?>" class="ss-service-card ss-card-admission">
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
                <a href="<?php echo base_url($cms_setting['url_alias'] . '/admit_card'); ?>" class="ss-service-card ss-card-admitcard">
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
                <a href="<?php echo base_url($cms_setting['url_alias'] . '/exam_results'); ?>" class="ss-service-card ss-card-results">
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
            <p class="ss-subtitle">30+ modules designed specifically for state-wide education management</p>
        </div>
        <div class="ss-cap-grid">
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-laptop-code"></i></div>
                <h4>Computer-Based Testing</h4>
                <p>State-owned CBT engine — no third-party dependency</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-chart-bar"></i></div>
                <h4>NEMIS Reporting</h4>
                <p>Government-ready data exports at one click</p>
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
                <p>Reach every parent across the state instantly</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-globe"></i></div>
                <h4>School Websites</h4>
                <p>Every school gets its own public website</p>
            </div>
            <div class="ss-cap-card ss-reveal">
                <div class="ss-cap-icon"><i class="fas fa-shield-alt"></i></div>
                <h4>7-Tier Security</h4>
                <p>Role-based access from Governor to Teacher</p>
            </div>
        </div>
    </section>

    <?php
        if (!empty($wellcome)) {
        $elements = json_decode($wellcome[ 'elements' ], true);
        ?>
    <!-- Welcome Section Starts -->
    <section class="welcome-area">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h2 class="main-heading1 lite" style="color: <?php echo $wellcome['color1'] == "" ? '#000' : $wellcome['color1']; ?>"><?php echo $wellcome['title']; ?></h2>
                <div class="sec-title style-two mb-tt">
                    <h2 class="main-heading2"><?php echo $wellcome['subtitle']; ?></h2>
                    <span class="decor"><span class="inner"></span></span>
                </div>
                <?php echo nl2br($wellcome['description']); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="wel-img">
                    <img src="<?php echo base_url('uploads/frontend/home_page/' . $elements['image'] . img_reload()); ?>" alt="image" class="img-fluid">
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
    ?>
<section class="featured-doctors" style="background-image: url(<?php echo base_url('uploads/frontend/home_page/' . $elements['image']); ?>);">
    <div class="container px-md-0">
        <div class="sec-title text-center">
            <h2 style="color: <?php echo $teachers['color1'] == "" ? '#fff' : $teachers['color1'] ?>"><?php echo $teachers['title'] ?></h2>
            <p style="color: <?php echo $teachers['color2'] == "" ? '#fff' : $teachers['color2'] ?>"><?php echo nl2br($teachers['description']); ?></p>
            <span class="decor"><span class="inner"></span></span>
        </div>
        <div class="row">
            <?php
			$doctor_list = $this->home_model->get_teacher_list($elements['teacher_start'], $branchID);
			foreach ($doctor_list as $row) {
                ?>
            <div class="col-lg-3 col-sm-6">
                <div class="bio-box">
                    <div class="profile-img">
                        <div class="dlab-border-left"></div>
                        <div class="dlab-border-right"></div>
                        <div class="dlab-media">
                            <img src="<?php echo get_image_url('staff', $row['photo']); ?>" alt="Doctor" class="img-fluid img-center-sm img-center-xs">
                        </div>
                        <div class="overlay">
                            <div class="overlay-txt">
                                <ul class="list-unstyled list-inline sm-links">
                                    <li class="list-inline-item">
                                        <a href="<?php echo $row['facebook_url']; ?>"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="<?php echo $row['linkedin_url']; ?>"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="<?php echo $row['twitter_url']; ?>"><i class="fab fa-twitter"></i></a>
                                    </li>
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
<?php }
    if (!empty($testimonial)) {
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
        $this->db->where('branch_id', $branchID);
        $testimonials = $this->db->get('front_cms_testimonial')->result_array();
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
                            <img src="<?php echo $this->testimonial_model->get_image_url($value['image']); ?>" alt="Awesome Image">
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
<?php } 
    if (!empty($statistics)) {
    $statisticsElem = json_decode($statistics['elements'], true);
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
<?php }
?>

<!-- ═══════════════════════════════════════════════════════════════════ -->
<!-- ★ HOW IT WORKS — NEW LANDING SECTION                              -->
<!-- ═══════════════════════════════════════════════════════════════════ -->
<section class="ss-how-it-works">
    <div class="container px-md-0">
        <div class="ss-section-header text-center">
            <span class="ss-kicker"><i class="fas fa-route"></i> Getting Started</span>
            <h2 class="ss-title">How It Works</h2>
            <p class="ss-subtitle">Three simple steps to get started with SmartSchool</p>
        </div>
        <div class="ss-steps-container">
            <div class="ss-steps-line"></div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="ss-step" data-step="1">
                        <div class="ss-step-number">1</div>
                        <div class="ss-step-icon"><i class="fas fa-search-location"></i></div>
                        <h4>Find Your School</h4>
                        <p>Search for schools near you by location, ward, or LGA. Browse schools across Kaduna State.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="ss-step" data-step="2">
                        <div class="ss-step-number">2</div>
                        <div class="ss-step-icon"><i class="fas fa-file-signature"></i></div>
                        <h4>Register & Enroll</h4>
                        <p>Complete the online admission form, upload required documents, and submit your application.</p>
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
                <h2 class="ss-title">Real-Time Command. State-Wide.</h2>
                <ul class="ss-dash-list">
                    <li><i class="fas fa-check-circle"></i> Live student & staff headcount across all 2,000+ schools</li>
                    <li><i class="fas fa-check-circle"></i> Fee collection health, attendance rates & exam performance</li>
                    <li><i class="fas fa-check-circle"></i> NEMIS-ready reports generated at the click of a button</li>
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
            <span class="ss-kicker ss-kicker-light"><i class="fas fa-shield-alt"></i> Official Platform</span>
            <h2 class="ss-title ss-title-light">Trusted by Kaduna State Government</h2>
            <p class="ss-subtitle ss-subtitle-light">Proudly endorsed and regulated by the State's education authorities</p>
        </div>
        <div class="ss-gov-cards">
            <div class="row g-4 justify-content-center">
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-landmark"></i></div>
                        <h5>Ministry of Education</h5>
                        <p>Kaduna State Ministry of Education — Policy direction & oversight</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-university"></i></div>
                        <h5>SUBEB</h5>
                        <p>State Universal Basic Education Board — Quality basic education for all</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-school"></i></div>
                        <h5>SEB</h5>
                        <p>Secondary Education Board — Oversight of secondary schools statewide</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-clipboard-check"></i></div>
                        <h5>Quality Assurance</h5>
                        <p>Kaduna State Quality Assurance Authority — Standards & school inspection</p>
                    </div>
                </div>
                <div class="col-lg col-md-6 col-sm-6">
                    <div class="ss-gov-card">
                        <div class="ss-gov-icon"><i class="fas fa-database"></i></div>
                        <h5>NEMIS Compliant</h5>
                        <p>National Education Management Information System — Full data reporting</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-compliance-badges">
            <div class="ss-badge"><i class="fas fa-check-circle"></i> Data Encrypted</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> 7-Tier Access Control</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> NEMIS Ready</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> State-Scale Tested</div>
            <div class="ss-badge"><i class="fas fa-check-circle"></i> 2,000+ Schools</div>
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
                <p class="ss-quote-text">SmartSchool gives us real-time visibility across every school in Kaduna State — this is the future of education governance.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Commissioner, Kaduna State Ministry of Education</p>
            </div>
            <div class="ss-quote-card ss-reveal">
                <div class="ss-quote-mark">"</div>
                <p class="ss-quote-text">For the first time, we can generate NEMIS reports and track enrolment across all 23 LGAs from a single platform.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Director, State Education Board</p>
            </div>
            <div class="ss-quote-card ss-reveal">
                <div class="ss-quote-mark">"</div>
                <p class="ss-quote-text">The CBT engine alone saves us months of exam logistics every year. This is exactly what Kaduna State needed.</p>
                <div class="ss-quote-divider"></div>
                <p class="ss-quote-author">Principal, Government Secondary School</p>
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
            <h2 class="ss-title">Find Schools Near You</h2>
            <p class="ss-subtitle">Enter your ward or LGA to discover nearby schools and apply for admission online</p>
        </div>
        <div class="ss-finder-box">
            <div class="ss-finder-inner">
                <div class="ss-finder-glow"></div>
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-5">
                        <label class="ss-finder-label">Search School by Name</label>
                        <div class="ss-finder-input-wrap">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control ss-finder-input" id="ssSchoolSearch" placeholder="Type school name..." autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="ss-finder-label">Filter by Ward / LGA</label>
                        <div class="ss-finder-input-wrap">
                            <i class="fas fa-map-pin"></i>
                            <input type="text" class="form-control ss-finder-input" id="ssWardFilter" placeholder="Enter ward or LGA..." autocomplete="off" />
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
                        <span id="ssResultCount">0</span> schools found
                    </div>
                    <div class="ss-finder-results-list" id="ssResultsList"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    if (!empty($services) || !empty($cta_box)) {
        ?>
<!-- Services Section Starts -->      
<div class="" style="background-image: url(<?php echo base_url('assets/frontend/images/14.png') ?>); padding: 60px 0; background-color: <?php echo $services['color2'] == "" ? '#fff' : $services['color2']; ?>;">
    <div class="container px-md-0">
    <?php if (!empty($services)) { ?>
        <section class="medical-services">
            <div class="sec-title text-center">
                <h2 style="color: <?php echo $services['color1'] == "" ? '#000' : $services['color1']; ?>"><?php echo $services['title']; ?></h2>
                <p><?php echo nl2br($services['description']); ?></p>
                <span class="decor"><span class="inner"></span></span>
            </div>
            <ul class="list-unstyled row text-center">
                <?php
                $this->db->where('branch_id', $branchID);
				$services_list = $this->db->get('front_cms_services_list')->result_array();
			    foreach ($services_list as $key => $value) {
			    	?>
                <li class="col-lg-2 col-sm-4">
                    <div class="icon">
                        <div class="i-hover"><i class="<?php echo $value['icon']; ?>"></i></div>
                    </div>
                    <h5><?php echo $value['title']; ?></h5>
                    <p><?php $string = $value['description']; echo (strlen($string) > 30) ? substr($string, 0, 30) . '...' : $string; ?></p>
                </li>
                <?php } ?>
            </ul>
        </section>
    <?php } 
		if (!empty($cta_box)) {
        $elements = json_decode($cta_box[ 'elements' ], true);
		?>
        <div class="book-appointment-box" style="background-color: <?php echo $cta_box['color1'] == "" ? '#464646' : $cta_box['color1']; ?>;">
            <div class="row">
                <div class="col-lg-8 col-md-12 text-center text-lg-left">
                    <h4 style="color: <?php echo $cta_box['color2'] == "" ? '#fff' : $cta_box['color2']; ?>;"><?php echo $cta_box['title']; ?></h4>
                    <h3 style="color: <?php echo $cta_box['color2'] == "" ? '#fff' : $cta_box['color2']; ?>;"><div class="inner-box"><i class="fa fa-phone"></i></div> <?php echo $elements['mobile_no']; ?></h3>
                </div>
                <div class="col-lg-4 col-md-12 text-center text-lg-left">
                    <a href="<?php echo $elements['button_url']; ?>" class="btn btn-main btn-1 text-uppercase"><?php echo $elements['button_text']; ?></a>
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
                    var url = alias ? (base_url + alias + '/admission') : '#';
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
                        var url = alias ? (base_url + alias + '/admission') : '#';
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
