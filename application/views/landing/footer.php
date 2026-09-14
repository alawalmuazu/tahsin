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
$email = trim((string) ($cms_setting['email'] ?? ''));
if ($email === '') {
    $email = 'info@tahsinacademy.edu.ng';
}
?>
<footer class="ta-footer">
    <div class="ta-footer-inner">
        <div>
            <strong>TĀHSIN ACADEMY</strong>
            <small><?php echo html_escape(SCHOOL_MOTTO); ?> · <?php echo date('Y'); ?></small>
        </div>
        <div class="ta-footer-links">
            <a href="<?php echo $ta_url('about'); ?>">About</a>
            <a href="<?php echo $ta_url('programmes'); ?>">Programmes</a>
            <a href="<?php echo $ta_url('admission'); ?>">Admission</a>
            <a href="mailto:<?php echo html_escape($email); ?>"><?php echo html_escape($email); ?></a>
        </div>
    </div>
</footer>
