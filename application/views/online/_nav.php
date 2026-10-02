<?php
$here = isset($sub_page) ? $sub_page : '';
$money = is_superadmin_loggedin() || is_admin_loggedin() || is_director_loggedin()
    || is_accountant_loggedin() || is_receptionist_loggedin()
    || get_permission('school_fees', 'is_view');
$links = array(
    'online/students' => array('Online students', base_url('online')),
    'online/classes' => array('Classes', base_url('online/classes')),
);
if ($money) {
    $links = array(
        'online/students' => array('Online students', base_url('online')),
        'online/fees' => array('Fees', base_url('online/fees')),
        'online/classes' => array('Classes', base_url('online/classes')),
        'online/income' => array('Income', base_url('online/income')),
    );
}
?>
<ul class="nav nav-tabs mb-md">
    <?php foreach ($links as $page => $link): ?>
    <li class="<?php echo $here === $page ? 'active' : ''; ?>">
        <a href="<?php echo $link[1]; ?>"><?php echo html_escape($link[0]); ?></a>
    </li>
    <?php endforeach; ?>
</ul>
