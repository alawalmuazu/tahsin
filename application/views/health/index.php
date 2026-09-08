<style>
.health-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 16px; padding: 8px 0; }
.health-card { border-radius: 8px; padding: 16px 20px; display: flex; align-items: flex-start; gap: 14px; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.08); border-left: 5px solid #ccc; }
.health-card.ok   { border-left-color: #27ae60; }
.health-card.warn { border-left-color: #f39c12; }
.health-card.error{ border-left-color: #e74c3c; }
.health-icon { font-size: 22px; margin-top: 2px; min-width: 28px; text-align: center; }
.health-card.ok   .health-icon { color: #27ae60; }
.health-card.warn .health-icon { color: #f39c12; }
.health-card.error .health-icon { color: #e74c3c; }
.health-label { font-weight: 700; font-size: 14px; color: #2c3e50; }
.health-value { font-size: 13px; color: #555; margin-top: 3px; }
.health-desc  { font-size: 11px; color: #999; margin-top: 2px; }
.health-summary { display: flex; gap: 24px; margin-bottom: 24px; flex-wrap: wrap; }
.health-stat { background:#fff; border-radius:8px; padding:24px 32px; box-shadow:0 1px 4px rgba(0,0,0,.08); text-align:center; min-width:150px; flex: 1; }
.health-stat .num { font-size: 40px; font-weight: 800; }
.health-stat .lbl { font-size: 14px; color: #888; margin-top: 5px; font-weight: 600; text-transform: uppercase; }
.stat-ok    .num { color: #27ae60; }
.stat-warn  .num { color: #f39c12; }
.stat-error .num { color: #e74c3c; }
</style>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading" style="display:flex; align-items:center; justify-content:space-between;">
                <h4 class="panel-title"><i class="fas fa-heartbeat"></i> System Health Status</h4>
                <small class="text-muted">Checked at <?=date('d M Y, H:i:s')?></small>
            </header>
            <div class="panel-body">

                <?php
                $total = count($checks);
                $ok_count    = count(array_filter($checks, fn($c) => $c['status'] === 'ok'));
                $warn_count  = count(array_filter($checks, fn($c) => $c['status'] === 'warn'));
                $error_count = count(array_filter($checks, fn($c) => $c['status'] === 'error'));
                ?>

                <!-- Summary bar -->
                <div class="health-summary">
                    <div class="health-stat stat-ok">
                        <div class="num"><?=$ok_count?></div>
                        <div class="lbl">Passed</div>
                    </div>
                    <div class="health-stat stat-warn">
                        <div class="num"><?=$warn_count?></div>
                        <div class="lbl">Warnings</div>
                    </div>
                    <div class="health-stat stat-error">
                        <div class="num"><?=$error_count?></div>
                        <div class="lbl">Errors</div>
                    </div>
                    <div class="health-stat">
                        <div class="num" style="color:#3498db"><?=$total?></div>
                        <div class="lbl">Total Checks</div>
                    </div>
                </div>

                <!-- Check cards -->
                <div class="health-grid">
                    <?php foreach ($checks as $check): ?>
                    <?php
                        $icon = $check['status'] === 'ok'    ? 'fa-check-circle'
                              : ($check['status'] === 'warn' ? 'fa-exclamation-triangle'
                                                             : 'fa-times-circle');
                    ?>
                    <div class="health-card <?=$check['status']?>">
                        <div class="health-icon"><i class="fas <?=$icon?>"></i></div>
                        <div>
                            <div class="health-label"><?=htmlspecialchars($check['label'])?></div>
                            <div class="health-value"><?=htmlspecialchars($check['value'])?></div>
                            <div class="health-desc"><?=htmlspecialchars($check['desc'])?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($error_count > 0): ?>
                <div class="alert alert-danger mt-lg">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong><?=$error_count?> critical issue(s) detected.</strong> Please resolve errors before going live.
                </div>
                <?php elseif ($warn_count > 0): ?>
                <div class="alert alert-warning mt-lg">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong><?=$warn_count?> warning(s).</strong> These are non-critical but should be reviewed for production deployment.
                </div>
                <?php else: ?>
                <div class="alert alert-success mt-lg">
                    <i class="fas fa-check-circle"></i>
                    <strong>All systems operational.</strong> No issues detected.
                </div>
                <?php endif; ?>

            </div>
        </section>
    </div>
</div>
