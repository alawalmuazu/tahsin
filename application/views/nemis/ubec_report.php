<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading" style="display:flex; justify-content:space-between; align-items:center;">
                <h4 class="panel-title"><i class="fas fa-chalkboard-teacher"></i> UBEC Compliance — Teacher-to-Student Ratio</h4>
                <div class="btn-group">
                    <a href="<?=base_url('nemis/export_ubec_csv')?>" class="btn btn-sm btn-default" title="Export CSV">
                        <i class="fas fa-file-csv"></i> CSV
                    </a>
                    <button type="button" class="btn btn-sm btn-default" onclick="nemisprint('ubec_printable')" title="Print / Save as PDF">
                        <i class="fas fa-print"></i> Print / PDF
                    </button>
                </div>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed" id="ubec_table">
                        <thead>
                            <tr style="background:#f5f5f5">
                                <th>#</th>
                                <th>School Name</th>
                                <th>LGA</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Teachers</th>
                                <th class="text-center">Ratio (S:T)</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; foreach ($ubec_data as $row): ?>
                            <?php
                                $ratio = floatval($row['ratio']);
                                if ($ratio <= 35) {
                                    $badge = 'label-success'; $status = 'Adequate';
                                } elseif ($ratio <= 45) {
                                    $badge = 'label-warning-custom'; $status = 'Moderate';
                                } else {
                                    $badge = 'label-danger-custom'; $status = 'Critical';
                                }
                            ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><?=html_escape($row['school_name'])?></td>
                                <td><?=html_escape($row['lga'])?></td>
                                <td class="text-center"><?=number_format($row['total_students'])?></td>
                                <td class="text-center"><?=number_format($row['total_teachers'])?></td>
                                <td class="text-center font-bold"><?=$ratio > 0 ? $ratio . ':1' : 'N/A'?></td>
                                <td class="text-center"><span class="label <?=$badge?>"><?=$status?></span></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="text-muted small mt-sm"><strong>Note:</strong> UBEC standard is 1 teacher per 35 students (primary) and 1:40 (secondary). Red indicates understaffing.</p>
            </div>
            <footer class="panel-footer">
                <a href="<?=base_url('nemis')?>" class="btn btn-sm btn-default"><i class="fas fa-arrow-left"></i> Back</a>
                <div class="pull-right">
                    <a href="<?=base_url('nemis/export_ubec_csv')?>" class="btn btn-sm btn-success"><i class="fas fa-file-csv"></i> Download CSV</a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="nemisprint('ubec_printable')"><i class="fas fa-file-pdf"></i> Print / PDF</button>
                </div>
            </footer>
        </section>
    </div>
</div>

<!-- ── Hidden print-only version ─────────────────────────────────────────── -->
<div id="ubec_printable" style="display:none">
    <div style="text-align:center; margin-bottom:16px;">
        <h3 style="margin:0">UBEC Compliance Report — Teacher-to-Student Ratio</h3>
        <p style="margin:4px 0; color:#555">Generated: <?=date('d M Y H:i')?></p>
        <p style="margin:0; color:#555; font-size:11px">UBEC Standard: ≤35 students per teacher (primary), ≤40 (secondary)</p>
    </div>
    <table style="width:100%;border-collapse:collapse;font-size:11px">
        <thead>
            <tr style="background:#1a6b3c;color:#fff">
                <th style="border:1px solid #ccc;padding:5px 8px">#</th>
                <th style="border:1px solid #ccc;padding:5px 8px">School Name</th>
                <th style="border:1px solid #ccc;padding:5px 8px">LGA</th>
                <th style="border:1px solid #ccc;padding:5px 8px;text-align:center">Students</th>
                <th style="border:1px solid #ccc;padding:5px 8px;text-align:center">Teachers</th>
                <th style="border:1px solid #ccc;padding:5px 8px;text-align:center">Ratio (S:T)</th>
                <th style="border:1px solid #ccc;padding:5px 8px;text-align:center">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($ubec_data as $row):
            $ratio = floatval($row['ratio']);
            $status = $ratio <= 35 ? 'Adequate' : ($ratio <= 45 ? 'Moderate' : 'Critical');
            $color  = $ratio <= 35 ? '#2e7d32' : ($ratio <= 45 ? '#e65100' : '#c62828');
        ?>
            <tr style="<?=$i%2==0?'background:#f9f9f9':''?>">
                <td style="border:1px solid #ccc;padding:4px 8px"><?=$i++?></td>
                <td style="border:1px solid #ccc;padding:4px 8px"><?=html_escape($row['school_name'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px"><?=html_escape($row['lga'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px;text-align:center"><?=number_format($row['total_students'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px;text-align:center"><?=number_format($row['total_teachers'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px;text-align:center;font-weight:bold"><?=$ratio > 0 ? $ratio . ':1' : 'N/A'?></td>
                <td style="border:1px solid #ccc;padding:4px 8px;text-align:center;color:<?=$color?>;font-weight:bold"><?=$status?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function(){
    $('#ubec_table').DataTable({
        pageLength: 25,
        order: [[5, 'desc']],
        language: { search: 'Filter:', paginate: { previous: '‹', next: '›' } }
    });
});

function nemisprint(id) {
    var content = document.getElementById(id).innerHTML;
    var w = window.open('', '_blank', 'width=900,height=700');
    w.document.write('<html><head><title>NEMIS Report</title>');
    w.document.write('<style>body{font-family:Arial,sans-serif;padding:20px;color:#222} table{width:100%;border-collapse:collapse} @media print{@page{margin:15mm}}</style>');
    w.document.write('</head><body>');
    w.document.write(content);
    w.document.write('<script>window.onload=function(){window.print();}<\/script>');
    w.document.write('</body></html>');
    w.document.close();
}
</script>
