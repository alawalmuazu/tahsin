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
$homeURL = $ta_url('');
$admissionURL = $ta_url('admission');
$aboutURL = $ta_url('about');
$contactURL = $ta_url('contact');
$resultsURL = $ta_url('exam_results');
$programmesURL = $ta_url('programmes');
$current = trim(uri_string(), '/');
$isHome = ($current === '' || $current === 'home' || $current === $alias);
$loginURL = is_loggedin() ? base_url('dashboard') : base_url('authentication');
$loginLabel = is_loggedin() ? 'Dashboard' : 'Portal';
$logo = base_url('uploads/app_image/logo-nav.png?v=' . APP_VERSION);
?>
<header class="ta-nav">
    <div class="ta-nav-inner">
        <a class="ta-brand" href="<?php echo $homeURL; ?>">
            <img src="<?php echo $logo; ?>" alt="Tahsin Academy crest">
            <span class="ta-brand-text">
                <strong>TĀHSIN</strong>
                <span>Academy</span>
            </span>
        </a>
        <button class="ta-menu-btn" type="button" aria-label="Open menu" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>
        <div class="ta-nav-panel">
            <ul class="ta-links">
                <li><a class="<?php echo $isHome ? 'is-active' : ''; ?>" href="<?php echo $homeURL; ?>">Home</a></li>
                <li><a class="<?php echo strpos($current, 'about') !== false ? 'is-active' : ''; ?>" href="<?php echo $aboutURL; ?>">About</a></li>
                <li><a class="<?php echo strpos($current, 'programmes') !== false ? 'is-active' : ''; ?>" href="<?php echo $programmesURL; ?>">Programmes</a></li>
                <li><a class="<?php echo strpos($current, 'exam_results') !== false ? 'is-active' : ''; ?>" href="<?php echo $resultsURL; ?>">Results</a></li>
                <li><a class="<?php echo strpos($current, 'contact') !== false ? 'is-active' : ''; ?>" href="<?php echo $contactURL; ?>">Contact</a></li>
            </ul>
            <div class="ta-nav-actions">
                <a class="ta-btn ta-btn-gold ta-nav-cta" href="<?php echo $admissionURL; ?>">Apply</a>
                <a class="ta-btn ta-btn-ghost ta-nav-cta" href="<?php echo $loginURL; ?>"><?php echo $loginLabel; ?></a>
            </div>
        </div>
    </div>
</header>
