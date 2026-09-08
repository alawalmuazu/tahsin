<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading" style="display:flex; justify-content:space-between; align-items:center;">
                <h4 class="panel-title"><i class="fas fa-school"></i> Annual School Census (ASC) — <?=html_escape($session_name)?></h4>
                <div class="btn-group">
                    <a href="<?=base_url('nemis/export_asc_csv')?>" class="btn btn-sm btn-default" title="Export CSV">
                        <i class="fas fa-file-csv"></i> CSV
                    </a>
                    <button type="button" class="btn btn-sm btn-default" onclick="nemisprint('asc_printable')" title="Print / Save as PDF">
                        <i class="fas fa-print"></i> Print / PDF
                    </button>
                </div>
            </header>
            <div class="panel-body">
                <!-- Summary Widgets -->
                <div class="row mb-md">
                    <div class="col-md-4">
                        <div class="panel panel-primary panel-sm text-center" style="padding:15px; margin-bottom:0">
                            <strong style="font-size:24px"><?=number_format($total_students)?></strong><br>
                            <small class="text-muted">Total Enrolled Students</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-info panel-sm text-center" style="padding:15px; margin-bottom:0">
                            <strong style="font-size:24px"><?=number_format($total_male)?></strong><br>
                            <small class="text-muted">Male</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-warning panel-sm text-center" style="padding:15px; margin-bottom:0">
                            <strong style="font-size:24px"><?=number_format($total_female)?></strong><br>
                            <small class="text-muted">Female</small>
                        </div>
                    </div>
                </div>

                <!-- ASC Table with DataTables -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed" id="asc_table">
                        <thead>
                            <tr style="background:#f5f5f5">
                                <th>#</th>
                                <th>School Name</th>
                                <th>LGA</th>
                                <th>Education Board</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Male</th>
                                <th class="text-center">Female</th>
                                <th class="text-center">Gender Ratio</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; foreach ($asc_data as $row): ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><?=html_escape($row['school_name'])?></td>
                                <td><span class="label label-default"><?=html_escape($row['lga'])?></span></td>
                                <td><?=html_escape($row['board_name'])?></td>
                                <td class="text-center font-bold"><?=number_format($row['total_students'])?></td>
                                <td class="text-center text-primary"><?=number_format($row['male_count'])?></td>
                                <td class="text-center text-danger"><?=number_format($row['female_count'])?></td>
                                <td class="text-center">
                                    <?php
                                        $total = $row['total_students'];
                                        $male_pct  = $total > 0 ? round(($row['male_count']/$total)*100) : 0;
                                        $female_pct = 100 - $male_pct;
                                    ?>
                                    <div class="progress progress-xs m-none" style="min-width:80px">
                                        <div class="progress-bar progress-bar-info" style="width:<?=$male_pct?>%"></div>
                                        <div class="progress-bar progress-bar-danger" style="width:<?=$female_pct?>%"></div>
                                    </div>
                                    <small class="text-muted"><?=$male_pct?>% / <?=$female_pct?>%</small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight:bold; background:#f9f9f9">
                                <td colspan="4">TOTAL</td>
                                <td class="text-center"><?=number_format($total_students)?></td>
                                <td class="text-center text-primary"><?=number_format($total_male)?></td>
                                <td class="text-center text-danger"><?=number_format($total_female)?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <footer class="panel-footer">
                <a href="<?=base_url('nemis')?>" class="btn btn-sm btn-default"><i class="fas fa-arrow-left"></i> Back</a>
                <div class="pull-right">
                    <a href="<?=base_url('nemis/export_asc_csv')?>" class="btn btn-sm btn-success"><i class="fas fa-file-csv"></i> Download CSV</a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="nemisprint('asc_printable')"><i class="fas fa-file-pdf"></i> Print / PDF</button>
                </div>
            </footer>
        </section>
    </div>
</div>

<!-- ── Hidden print-only version (no DataTables, no progress bars) ────────── -->
<div id="asc_printable" style="display:none">
    <div style="text-align:center; margin-bottom:16px;">
        <h3 style="margin:0">Annual School Census (ASC)</h3>
        <p style="margin:4px 0; color:#555">Session: <?=html_escape($session_name)?> &nbsp;|&nbsp; Generated: <?=date('d M Y H:i')?></p>
        <p style="margin:0; color:#555">Total Students: <strong><?=number_format($total_students)?></strong> &nbsp;|&nbsp;
           Male: <strong><?=number_format($total_male)?></strong> &nbsp;|&nbsp;
           Female: <strong><?=number_format($total_female)?></strong></p>
    </div>
    <table style="width:100%;border-collapse:collapse;font-size:11px">
        <thead>
            <tr style="background:#1a6b3c;color:#fff">
                <th style="border:1px solid #ccc;padding:5px 8px">#</th>
                <th style="border:1px solid #ccc;padding:5px 8px">School Name</th>
                <th style="border:1px solid #ccc;padding:5px 8px">LGA</th>
                <th style="border:1px solid #ccc;padding:5px 8px">Education Board</th>
                <th style="border:1px solid #ccc;padding:5px 8px;text-align:center">Total</th>
                <th style="border:1px solid #ccc;padding:5px 8px;text-align:center">Male</th>
                <th style="border:1px solid #ccc;padding:5px 8px;text-align:center">Female</th>
                <th style="border:1px solid #ccc;padding:5px 8px;text-align:center">M%/F%</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($asc_data as $row):
            $t = $row['total_students'];
            $mp = $t > 0 ? round(($row['male_count']/$t)*100) : 0;
            $fp = 100 - $mp;
        ?>
            <tr style="<?=$i%2==0?'background:#f9f9f9':''?>">
                <td style="border:1px solid #ccc;padding:4px 8px"><?=$i++?></td>
                <td style="border:1px solid #ccc;padding:4px 8px"><?=html_escape($row['school_name'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px"><?=html_escape($row['lga'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px"><?=html_escape($row['board_name'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px;text-align:center;font-weight:bold"><?=number_format($row['total_students'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px;text-align:center"><?=number_format($row['male_count'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px;text-align:center"><?=number_format($row['female_count'])?></td>
                <td style="border:1px solid #ccc;padding:4px 8px;text-align:center"><?=$mp?>% / <?=$fp?>%</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background:#e8f5ee;font-weight:bold">
                <td colspan="4" style="border:1px solid #ccc;padding:5px 8px">TOTAL</td>
                <td style="border:1px solid #ccc;padding:5px 8px;text-align:center"><?=number_format($total_students)?></td>
                <td style="border:1px solid #ccc;padding:5px 8px;text-align:center"><?=number_format($total_male)?></td>
                <td style="border:1px solid #ccc;padding:5px 8px;text-align:center"><?=number_format($total_female)?></td>
                <td style="border:1px solid #ccc;padding:5px 8px"></td>
            </tr>
        </tfoot>
    </table>
</div>

<script>
$(document).ready(function(){
    $('#asc_table').DataTable({
        pageLength: 25,
        order: [[2, 'asc'], [1, 'asc']],
        columnDefs: [{ orderable: false, targets: 7 }],
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
