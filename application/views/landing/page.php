<?php
$alias = trim((string) ($cms_setting['url_alias'] ?? ''));
if (strtolower($alias) === 'example') {
    $alias = '';
}
$ta_url = function ($path = '') use ($alias) {
    $path = ltrim((string) $path, '/');
    if ($path === '') {
        return $alias ? base_url($alias) : base_url();
    }
    return $alias ? base_url($alias . '/' . $path) : base_url($path);
};
$title = !empty($page_data['page_title']) ? $page_data['page_title'] : 'Home';
$metaKw = !empty($page_data['meta_keyword']) ? $page_data['meta_keyword'] : 'Tahsin Academy, Islamic school, Tahfeez, Quran';
$metaDesc = !empty($page_data['meta_description']) ? $page_data['meta_description'] : 'Tahsin Academy — Excellence in Deen and Duniya.';
$appTitle = !empty($cms_setting['application_title']) ? $cms_setting['application_title'] : SCHOOL_NAME;
$email = trim((string) ($cms_setting['email'] ?? ''));
if ($email === '') {
    $email = 'info@tahsinacademy.edu.ng';
}
$phone = trim((string) ($cms_setting['mobile_no'] ?? ''));
$address = trim((string) ($cms_setting['address'] ?? ''));
$hours = trim(strip_tags((string) ($cms_setting['working_hours'] ?? '')));
if ($hours === '') {
    $hours = 'Mon – Fri: 8:00 AM – 3:00 PM';
}
$logo = base_url('uploads/app_image/logo-nav.png?v=' . APP_VERSION);
$cssV = is_file(FCPATH . 'assets/landing/css/tahsin.css') ? filemtime(FCPATH . 'assets/landing/css/tahsin.css') : APP_VERSION;
$jsV = is_file(FCPATH . 'assets/landing/js/tahsin.js') ? filemtime(FCPATH . 'assets/landing/js/tahsin.js') : APP_VERSION;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="keyword" content="<?php echo html_escape($metaKw); ?>">
    <meta name="description" content="<?php echo html_escape($metaDesc); ?>">
    <title><?php echo html_escape($title . ' — ' . $appTitle); ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('uploads/app_image/logo.png'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/landing/css/tahsin.css?v=' . $cssV); ?>">
    <?php echo $cms_setting['google_analytics']; ?>
</head>
<body class="ta-body">
<?php $this->load->view('landing/nav'); ?>

<section class="ta-hero">
    <div class="ta-hero-pattern"></div>
    <div class="ta-hero-glow"></div>
    <div class="ta-hero-grid">
        <div>
            <div class="ta-kicker ta-reveal">Excellence in two worlds</div>
            <p class="ta-arabic ta-reveal ta-delay-1">تحسين</p>
            <h1 class="ta-display ta-reveal ta-delay-1">Tahsin Academy</h1>
            <p class="ta-motto ta-reveal ta-delay-2"><?php echo html_escape(SCHOOL_MOTTO); ?></p>
            <p class="ta-lead ta-reveal ta-delay-2">A school built for families who want the Quran at the centre of a child’s life, and a mind prepared for the world beyond it. Boarding, day and weekend paths — with or without technical skills.</p>
            <div class="ta-hero-actions ta-reveal ta-delay-3">
                <a class="ta-btn ta-btn-gold" href="<?php echo $ta_url('admission'); ?>"><?php echo !empty($online_open) ? 'Begin admission' : 'How to apply'; ?></a>
                <a class="ta-btn ta-btn-ghost" href="<?php echo $ta_url('programmes'); ?>">Explore programmes</a>
            </div>
            <div class="ta-hero-meta ta-reveal ta-delay-3">
                <div><b>3</b><span>Study modes</span></div>
                <div><b>6</b><span>Full tracks</span></div>
                <div><b>2</b><span>Worlds, one student</span></div>
            </div>
        </div>
        <div class="ta-crest-stage ta-reveal ta-delay-2">
            <div class="ta-crest-ring"></div>
            <img class="ta-crest" src="<?php echo $logo; ?>" alt="Tahsin Academy crest">
        </div>
    </div>
</section>

<div class="ta-ribbon" aria-hidden="true">
    <div class="ta-ribbon-track">
        <span>Boarding · Day · Weekend · Quran · Character · Skills · Deen · Duniya · Boarding · Day · Weekend · Quran · Character · Skills · Deen · Duniya ·</span>
        <span>Boarding · Day · Weekend · Quran · Character · Skills · Deen · Duniya · Boarding · Day · Weekend · Quran · Character · Skills · Deen · Duniya ·</span>
    </div>
</div>

<section class="ta-creed" id="about">
    <div class="ta-wrap">
        <div class="ta-creed-head">
            <div class="ta-kicker">The Tahsin idea</div>
            <h2 class="ta-display">One student. Two trusts.</h2>
            <p>We do not ask families to choose between a sound heart and a sharp mind. Tahsin holds both — the book of Allah, and the tools a young person needs to stand honourably in society.</p>
        </div>
        <div class="ta-split">
            <article class="ta-panel">
                <h3>Deen</h3>
                <p>Quranic memorization, tajweed, and a daily rhythm of worship that forms character before it forms a transcript.</p>
                <ul>
                    <li>Tahfeez with living recitation, not recitation as performance</li>
                    <li>Adab, discipline, and a boarding house that feels like a home of knowledge</li>
                    <li>Teachers who model the deen as much as they teach it</li>
                </ul>
            </article>
            <div class="ta-star-col">
                <svg class="ta-star" viewBox="0 0 100 100" aria-hidden="true">
                    <path fill="none" stroke="currentColor" stroke-width="2" d="M50 6 L60 40 L94 50 L60 60 L50 94 L40 60 L6 50 L40 40 Z"/>
                    <circle cx="50" cy="50" r="8" fill="currentColor"/>
                </svg>
            </div>
            <article class="ta-panel">
                <h3>Duniya</h3>
                <p>A structured academic path, and — where families choose it — technical skills that make a graduate useful, not only examined.</p>
                <ul>
                    <li>Day and weekend tracks for students who live at home</li>
                    <li>With or without technical skills, named clearly at admission</li>
                    <li>Results, reports and a parent portal that keeps the home in the conversation</li>
                </ul>
            </article>
        </div>
    </div>
</section>

<section class="ta-programmes" id="programmes">
    <div class="ta-wrap">
        <div class="ta-kicker">How a child enters Tahsin</div>
        <h2 class="ta-display">Six tracks. Three ways of life.</h2>
        <p>Choose the house of study first — boarding, day, or weekend — then choose whether the path includes technical skills. Every track keeps the Quran close.</p>
        <div class="ta-cards">
            <article class="ta-card">
                <div class="ta-card-mode">Boarding</div>
                <h3>Quran House</h3>
                <p>Live in. Rise with the Quran. A full boarding life for students whose families want immersion — memorization, routine, and a school that does not end at the last bell.</p>
                <div class="ta-pills">
                    <span class="ta-pill">Without technical skills</span>
                    <span class="ta-pill">With technical skills</span>
                </div>
            </article>
            <article class="ta-card">
                <div class="ta-card-mode">Day</div>
                <h3>Day School</h3>
                <p>Come home each evening. A weekday academy for students who want Tahsin’s deen and classroom without leaving the family house.</p>
                <div class="ta-pills">
                    <span class="ta-pill">Without technical skills</span>
                    <span class="ta-pill">With technical skills</span>
                </div>
            </article>
            <article class="ta-card">
                <div class="ta-card-mode">Weekend</div>
                <h3>Weekend Tahfeez</h3>
                <p>For students whose week is already spoken for. Saturdays and Sundays given to the Quran — with an option to add skills beside the hifz path.</p>
                <div class="ta-pills">
                    <span class="ta-pill">Tahfeez without skills</span>
                    <span class="ta-pill">Tahfeez with skills</span>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="ta-life">
    <div class="ta-wrap">
        <div class="ta-kicker">Life on campus</div>
        <h2 class="ta-display">A quiet intensity.</h2>
        <div class="ta-life-grid">
            <article class="ta-life-feature">
                <p class="ta-quote">“The student who beautifies the Quran is being asked, at the same time, to beautify how they walk through the world.”</p>
                <p>That is the work. Not a slogan on a wall — a timetable, a boarding house, a teacher who notices, and a parent who can see progress without waiting for visiting day.</p>
                <a class="ta-btn ta-btn-dark" href="<?php echo $ta_url('about'); ?>">Read the academy story</a>
            </article>
            <aside class="ta-life-side">
                <h3>What you will find</h3>
                <p>Clear programmes. Named tracks. A portal for students and, when the school enables it, for guardians. Results and admit cards without a scavenger hunt.</p>
                <p>Admission is staff-led. You apply; the academy places the child on the track that matches the life you actually live.</p>
            </aside>
        </div>
    </div>
</section>

<section class="ta-path" id="admission">
    <div class="ta-wrap">
        <div class="ta-kicker">Admission</div>
        <h2 class="ta-display">Four steps. No theatre.</h2>
        <div class="ta-steps">
            <article class="ta-step">
                <b>01</b>
                <h3>Choose a mode</h3>
                <p>Boarding, day or weekend — the first decision is how the child will live the week.</p>
            </article>
            <article class="ta-step">
                <b>02</b>
                <h3>Name the track</h3>
                <p>With technical skills, or without. Quran remains the spine of both.</p>
            </article>
            <article class="ta-step">
                <b>03</b>
                <h3>Submit the form</h3>
                <p>Staff complete admission in the academy office. Families can begin from the public form.</p>
            </article>
            <article class="ta-step">
                <b>04</b>
                <h3>Enter the house</h3>
                <p>A student ID, a class, a rhythm. Portal access follows school settings — not a pile of passwords on day one.</p>
            </article>
        </div>
        <p style="margin-top:36px">
            <a class="ta-btn ta-btn-gold" href="<?php echo $ta_url('admission'); ?>"><?php echo !empty($online_open) ? 'Begin admission' : 'How to apply'; ?></a>
        </p>
        <?php $this->load->view('landing/payment_notice'); ?>
    </div>
</section>

<section class="ta-visit" id="visit">
    <div class="ta-wrap ta-visit-grid">
        <div>
            <div class="ta-kicker">Visit &amp; write</div>
            <h2 class="ta-display">The door is open.</h2>
            <p>Come and walk the grounds. Or write first. Either way, you will speak to people who know the programmes by name — not a call centre reading a script.</p>
            <ul class="ta-facts">
                <?php if ($address !== ''): ?>
                <li><i class="fas fa-map-marker-alt"></i><span><?php echo html_escape($address); ?></span></li>
                <?php endif; ?>
                <?php if ($phone !== ''): ?>
                <li><i class="fas fa-phone"></i><span><?php echo html_escape($phone); ?></span></li>
                <?php endif; ?>
                <li><i class="far fa-envelope"></i><span><a href="mailto:<?php echo html_escape($email); ?>"><?php echo html_escape($email); ?></a></span></li>
                <li><i class="far fa-clock"></i><span><?php echo html_escape($hours); ?></span></li>
            </ul>
        </div>
        <aside class="ta-visit-card">
            <h3>Already with us?</h3>
            <p>Parents, students and staff enter through the portal. Results and admit cards are on this site, without logging in.</p>
            <div class="ta-hero-actions">
                <a class="ta-btn ta-btn-gold" href="<?php echo base_url('authentication'); ?>">Open the portal</a>
                <a class="ta-btn ta-btn-ghost" href="<?php echo $ta_url('exam_results'); ?>">Check results</a>
            </div>
        </aside>
    </div>
</section>

<?php $this->load->view('landing/footer'); ?>
<script src="<?php echo base_url('assets/landing/js/tahsin.js?v=' . $jsV); ?>"></script>
</body>
</html>
