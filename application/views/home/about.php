<?php
$alias = trim((string) ($cms_setting['url_alias'] ?? ''));
if (strtolower($alias) === 'example') {
    $alias = '';
}
$home = $alias ? base_url($alias) : base_url();
$admission = $alias ? base_url($alias . '/admission') : base_url('admission');
?>
<section class="ta-page">
    <div class="ta-wrap">
        <div class="ta-kicker">The academy</div>
        <h1 class="ta-display">Built for deen. Ready for duniya.</h1>
        <p class="ta-page-lead"><?php echo html_escape(SCHOOL_NAME); ?> exists so a child does not have to leave the Quran in order to become useful in the world — or leave the world unprepared in order to memorise the Book. Both trusts are held here.</p>
    </div>
</section>

<section class="ta-creed" style="padding-top:0">
    <div class="ta-wrap ta-split">
        <article class="ta-panel">
            <h3>What we refuse</h3>
            <p>A school that treats Islam as decoration. A school that treats academics as the only exam that matters. Tahsin is neither a weekend club nor a factory of certificates.</p>
        </article>
        <div class="ta-star-col">
            <svg class="ta-star" viewBox="0 0 100 100" aria-hidden="true">
                <path fill="none" stroke="currentColor" stroke-width="2" d="M50 6 L60 40 L94 50 L60 60 L50 94 L40 60 L6 50 L40 40 Z"/>
            </svg>
        </div>
        <article class="ta-panel">
            <h3>What we keep</h3>
            <p>Named tracks. Boarding, day and weekend. With technical skills, or without. Teachers who can be pointed to. A portal that tells the truth about progress.</p>
        </article>
    </div>
</section>

<section class="ta-programmes" id="programmes">
    <div class="ta-wrap">
        <div class="ta-kicker">How we are organised</div>
        <h2 class="ta-display">Three houses of study.</h2>
        <div class="ta-cards">
            <article class="ta-card">
                <div class="ta-card-mode">Boarding</div>
                <h3>Quran House</h3>
                <p>Immersion. The day is shaped around recitation, class, meals and rest — a boarding life for families who want the child raised inside the academy.</p>
            </article>
            <article class="ta-card">
                <div class="ta-card-mode">Day</div>
                <h3>Day School</h3>
                <p>The same academic and Quranic spine, returning home each evening. For families who want Tahsin without leaving the house empty.</p>
            </article>
            <article class="ta-card">
                <div class="ta-card-mode">Weekend</div>
                <h3>Weekend Tahfeez</h3>
                <p>The Quran given a serious weekend — not an afterthought — with the option to stand skills beside hifz.</p>
            </article>
        </div>
        <p style="margin-top:36px">
            <a class="ta-btn ta-btn-gold" href="<?php echo $admission; ?>">Apply for a place</a>
            <a class="ta-btn ta-btn-ghost" href="<?php echo $home; ?>">Back to the front</a>
        </p>
    </div>
</section>
