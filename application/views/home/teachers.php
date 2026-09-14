<section class="ta-page">
    <div class="ta-wrap">
        <div class="ta-kicker">People of the school</div>
        <h1 class="ta-display">Teachers</h1>
        <p class="ta-page-lead">The work is done by people who can be named. If a teacher is listed here, they are on staff and teaching.</p>
    </div>
</section>

<section class="ta-page" style="padding-top:0">
    <div class="ta-wrap">
        <?php if (empty($teacher_list)) { ?>
        <div class="ta-empty">No teachers are published on the site yet. Ask at the office, or write through Contact.</div>
        <?php } else { ?>
        <div class="ta-teacher-grid">
            <?php foreach ($teacher_list as $row) { ?>
            <article class="ta-teacher-card">
                <img src="<?php echo get_image_url('staff', $row['photo']); ?>" alt="<?php echo html_escape($row['name']); ?>">
                <h3><?php echo html_escape($row['name']); ?></h3>
                <p><?php echo html_escape($row['designation_name'] ?: $row['department_name']); ?></p>
            </article>
            <?php } ?>
        </div>
        <?php } ?>
        <div class="ta-actions">
            <a class="ta-btn ta-btn-gold" href="<?php echo base_url('contact'); ?>">Write to the academy</a>
        </div>
    </div>
</section>
