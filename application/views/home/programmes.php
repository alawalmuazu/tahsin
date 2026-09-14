<?php
$admission = base_url('admission');
?>
<section class="ta-page">
    <div class="ta-wrap">
        <div class="ta-kicker">How a child enters Tahsin</div>
        <h1 class="ta-display">Six tracks. Three ways of life.</h1>
        <p class="ta-page-lead">Choose the house of study first — boarding, day, or weekend — then choose whether the path includes technical skills. Every track keeps the Quran close.</p>
    </div>
</section>

<section class="ta-programmes" id="programmes">
    <div class="ta-wrap">
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
        <div class="ta-actions">
            <a class="ta-btn ta-btn-gold" href="<?php echo $admission; ?>"><?php echo !empty($online_open) ? 'Begin admission' : 'How to apply'; ?></a>
        </div>
    </div>
</section>

<section class="ta-path">
    <div class="ta-wrap">
        <div class="ta-kicker">Then name the track</div>
        <h2 class="ta-display">With skills, or without.</h2>
        <div class="ta-steps">
            <article class="ta-step">
                <b>01</b>
                <h3>Boarding without skills</h3>
                <p>Full residence. Quran, adab and a structured day. No technical-skills stream.</p>
            </article>
            <article class="ta-step">
                <b>02</b>
                <h3>Boarding with skills</h3>
                <p>The same house, with a technical path standing beside hifz.</p>
            </article>
            <article class="ta-step">
                <b>03</b>
                <h3>Day tracks</h3>
                <p>Weekdays at Tahsin, evenings at home — with or without skills.</p>
            </article>
            <article class="ta-step">
                <b>04</b>
                <h3>Weekend tahfeez</h3>
                <p>Serious weekend memorization, with an optional skills stream.</p>
            </article>
        </div>
    </div>
</section>
