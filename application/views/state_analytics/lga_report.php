<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <h4 class="panel-title"><i class="fas fa-map-marker-alt"></i> LGA School Summary Report</h4>
                <div>
                    <a href="<?=base_url('state_analytics')?>" class="btn btn-default btn-sm"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                    <button onclick="window.print()" class="btn btn-default btn-sm"><i class="fas fa-print"></i> Print</button>
                </div>
            </header>
            <div class="panel-body">
                <?php if (empty($lga_stats)): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> No LGA data available. Please assign an LGA to each school under <strong>Branch Management</strong>.
                    </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="lgaTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>LGA</th>
                                <th>Total Schools</th>
                                <th>Total Students</th>
                                <th>Total Teachers</th>
                                <th>Student-Teacher Ratio</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($lga_stats as $row): ?>
                            <?php
                                $ratio = $row->total_teachers > 0
                                    ? round($row->total_students / $row->total_teachers, 1)
                                    : '–';
                                $ratio_label = 'ok';
                                if (is_numeric($ratio)) {
                                    if ($ratio > 45) $ratio_label = 'critical';
                                    elseif ($ratio > 35) $ratio_label = 'warn';
                                }
                            ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><strong><?=htmlspecialchars($row->lga)?></strong></td>
                                <td><?=number_format($row->total_schools)?></td>
                                <td><?=number_format($row->total_students)?></td>
                                <td><?=number_format($row->total_teachers)?></td>
                                <td>
                                    <?php if ($ratio === '–'): ?>
                                        <span class="text-muted">–</span>
                                    <?php else: ?>
                                        <span class="label label-<?=$ratio_label === 'ok' ? 'success-custom' : ($ratio_label === 'warn' ? 'warning-custom' : 'danger-custom')?>">
                                            <?=$ratio?> : 1
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row->total_teachers == 0): ?>
                                        <span class="label label-danger-custom">No Teachers</span>
                                    <?php elseif ($ratio_label === 'critical'): ?>
                                        <span class="label label-danger-custom">Understaffed</span>
                                    <?php elseif ($ratio_label === 'warn'): ?>
                                        <span class="label label-warning-custom">Needs Attention</span>
                                    <?php else: ?>
                                        <span class="label label-success-custom">Adequate</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="active">
                                <td colspan="2"><strong>Total</strong></td>
                                <td><strong><?=number_format(array_sum(array_column((array)$lga_stats, 'total_schools')))?></strong></td>
                                <td><strong><?=number_format(array_sum(array_column((array)$lga_stats, 'total_students')))?></strong></td>
                                <td><strong><?=number_format(array_sum(array_column((array)$lga_stats, 'total_teachers')))?></strong></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <p class="help-block mt-sm">
                    <i class="fas fa-info-circle"></i>
                    Ratio threshold: <span class="label label-success-custom">≤ 35:1 Adequate</span>
                    <span class="label label-warning-custom">36–45:1 Needs Attention</span>
                    <span class="label label-danger-custom">&gt; 45:1 Understaffed</span>
                </p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
