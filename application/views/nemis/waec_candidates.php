<?php
// Build filter query string for CSV exports
$csvQuery = '?exam_type=' . $exam_type;
if (!empty($class_filter))  $csvQuery .= '&class_id='  . $class_filter;
if (!empty($branch_filter)) $csvQuery .= '&branch_id=' . $branch_filter;

$missingNin = count(array_filter($candidates, function($r){ return empty($r['nin']); }));
$missingId  = count(array_filter($candidates, function($r){ return empty($r['state_student_id']); }));
?>

<div class="row">
  <div class="col-md-12">

    <!-- ── Exam Type Tabs ──────────────────────────────────────────────────── -->
    <div class="panel" style="margin-bottom:10px">
      <div class="panel-body" style="padding:12px 16px">
        <div class="row" style="margin:0">
          <div class="col-md-8">
            <strong>Exam Type:</strong>&nbsp;
            <a href="<?=base_url('nemis/waec_candidates')?>?exam_type=ssce"
               class="btn btn-sm <?=$exam_type=='ssce' ? 'btn-primary' : 'btn-default'?>">
              <i class="fas fa-graduation-cap"></i> WAEC / NECO SSCE &nbsp;
              <small>(SS3 — Senior Secondary Final Year)</small>
            </a>&nbsp;
            <a href="<?=base_url('nemis/waec_candidates')?>?exam_type=bece"
               class="btn btn-sm <?=$exam_type=='bece' ? 'btn-warning' : 'btn-default'?>">
              <i class="fas fa-school"></i> NECO BECE &nbsp;
              <small>(JSS3 — Junior Secondary Final Year)</small>
            </a>
          </div>
          <div class="col-md-4 text-right text-muted" style="font-size:12px;padding-top:6px">
            <?php if ($exam_type === 'ssce'): ?>
              <i class="fas fa-info-circle text-primary"></i>
              Filtered to: <strong>SS3 / SSS3 / SS 3</strong> classes only
            <?php else: ?>
              <i class="fas fa-info-circle text-warning"></i>
              Filtered to: <strong>Basic 9 / JSS 3 / JSS3</strong> classes only
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Cascading School → Class Filter ─────────────────────────────────── -->
    <div class="panel" style="margin-bottom:10px">
      <div class="panel-body" style="padding:12px 16px;background:#fafafa">
        <form method="get" action="<?=base_url('nemis/waec_candidates')?>" class="form-inline" id="waec_filter_form">
          <input type="hidden" name="exam_type" value="<?=html_escape($exam_type)?>">

          <?php if (is_superadmin_loggedin()): ?>
          <!-- Step 1: Select School (pre-filtered by exam type) -->
          <strong style="margin-right:6px">School:</strong>
          <select id="filter_branch" name="branch_id" class="form-control input-sm" style="min-width:220px;margin-right:10px">
            <option value="">— All Schools (<?=count($branch_list)?>) —</option>
            <?php foreach ($branch_list as $br): ?>
            <option value="<?=$br['id']?>" <?=($branch_filter == $br['id'] ? 'selected' : '')?>>
              <?=html_escape($br['name'])?>
            </option>
            <?php endforeach; ?>
          </select>
          <?php endif; ?>

          <!-- Step 2: Override Class — always enabled; shows school's classes when a school is selected -->
          <strong style="margin-right:6px">Override Class:</strong>
          <select id="filter_class" name="class_id" class="form-control input-sm" style="min-width:200px;margin-right:10px">
            <option value="">— Auto (by exam type) —</option>
            <?php foreach ($class_list as $cl): ?>
            <option value="<?=$cl['id']?>" <?=($class_filter == $cl['id'] ? 'selected' : '')?>>
              <?=html_escape($cl['name'])?>
            </option>
            <?php endforeach; ?>
          </select>

          <button type="submit" class="btn btn-sm btn-primary" style="margin-right:5px">
            <i class="fas fa-filter"></i> Apply
          </button>
          <?php if (!empty($class_filter) || !empty($branch_filter)): ?>
          <a href="<?=base_url('nemis/waec_candidates')?>?exam_type=<?=$exam_type?>"
             class="btn btn-sm btn-default text-danger">
            <i class="fas fa-times"></i> Clear
          </a>
          <?php endif; ?>
        </form>
      </div>
    </div>

    <script>
    (function(){
        var branchSel = document.getElementById('filter_branch');
        var classSel  = document.getElementById('filter_class');
        var examType  = '<?=html_escape($exam_type)?>';
        if (!branchSel) return; // non-superadmin: no cascade needed

        function loadClasses(bid) {
            var url = '<?=base_url('nemis/get_classes_by_branch')?>?exam_type=' + encodeURIComponent(examType)
                    + '&branch_id=' + encodeURIComponent(bid);
            classSel.innerHTML = '<option value="">Loading\u2026</option>';

            fetch(url)
                .then(function(r){ return r.json(); })
                .then(function(rows){
                    var html = '<option value="">— Auto (by exam type) —</option>';
                    rows.forEach(function(c){
                        html += '<option value="' + c.id + '">' + c.name + '</option>';
                    });
                    classSel.innerHTML = html;
                    classSel.disabled = false;
                })
                .catch(function(){
                    classSel.innerHTML = '<option value="">Error loading classes</option>';
                });
        }

        // When school changes, reload classes
        branchSel.addEventListener('change', function(){
            loadClasses(this.value);
        });
    })();
    </script>


    <!-- ── Eligibility Note ────────────────────────────────────────────────── -->
    <?php if (!empty($class_filter)): ?>
    <div class="alert alert-warning" style="margin-bottom:10px;padding:8px 14px;font-size:12px">
      <i class="fas fa-exclamation-triangle"></i>
      <strong>Manual class override active.</strong>
      This list may include students from classes not eligible for the selected exam.
      <a href="<?=base_url('nemis/waec_candidates')?>?exam_type=<?=$exam_type?>">Reset to auto-filter</a>.
    </div>
    <?php endif; ?>

    <!-- ── Summary Badges ─────────────────────────────────────────────────── -->
    <div class="row" style="margin-bottom:8px">
      <div class="col-md-12">
        <span class="label label-primary" style="font-size:13px;padding:5px 10px">
          <?=count($candidates)?> Candidates
        </span>&nbsp;
        <?php if ($missingNin > 0): ?>
        <span class="label label-warning" style="font-size:13px;padding:5px 10px">
          <i class="fas fa-exclamation-triangle"></i> <?=$missingNin?> Missing NIN
        </span>&nbsp;
        <?php endif; ?>
        <?php if ($missingId > 0): ?>
        <span class="label label-danger" style="font-size:13px;padding:5px 10px">
          <i class="fas fa-exclamation-triangle"></i> <?=$missingId?> Missing State Student ID
        </span>
        <?php endif; ?>
      </div>
    </div>

    <!-- ── Main Table ─────────────────────────────────────────────────────── -->
    <section class="panel">
      <header class="panel-heading" style="display:flex;justify-content:space-between;align-items:center">
        <h4 class="panel-title">
          <i class="fas fa-id-card"></i>
          <?=$exam_type === 'bece' ? 'NECO BECE' : 'WAEC / NECO SSCE'?> Candidate List
          <small class="text-muted">
            — <?=$exam_type === 'bece' ? 'JSS3 students' : 'SS3 students'?> / Current Session
          </small>
        </h4>
        <div class="btn-group">
          <a href="<?=base_url('nemis/export_waec_csv') . $csvQuery?>" class="btn btn-sm btn-default" title="Export CSV">
            <i class="fas fa-file-csv"></i> CSV
          </a>
          <button type="button" class="btn btn-sm btn-default" onclick="nemisprint('waec_printable')" title="Print / Save as PDF">
            <i class="fas fa-print"></i> Print / PDF
          </button>
        </div>
      </header>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-condensed" id="waec_table">
            <thead>
              <tr style="background:#f5f5f5">
                <th>#</th>
                <th>State Student ID</th>
                <th>NIN</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Reg No</th>
                <th>School</th>
                <th>LGA</th>
                <th>Class</th>
              </tr>
            </thead>
            <tbody>
            <?php if (empty($candidates)): ?>
              <tr><td colspan="10" class="text-center text-muted" style="padding:30px">
                No <?=$exam_type === 'bece' ? 'JSS3 (BECE)' : 'SS3 (SSCE)'?> candidates found
                for the current session.
                <?php if (empty($class_filter)): ?>
                  <br><small>Ensure your final-year junior class is named <strong>
                  <?=$exam_type === 'bece' ? 'Basic 9, JSS 3 or JSS3' : 'SS3 or SS 3'?>
                  </strong> in the system, or use the Override Class filter above.</small>
                <?php endif; ?>
              </td></tr>
            <?php else: $i=1; foreach ($candidates as $row): ?>
              <tr>
                <td><?=$i++?></td>
                <td>
                  <?php if (!empty($row['state_student_id'])): ?>
                    <span class="label label-primary"><?=html_escape($row['state_student_id'])?></span>
                  <?php else: ?>
                    <span class="label label-danger-custom">Missing</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($row['nin'])): ?>
                    <code><?=html_escape($row['nin'])?></code>
                  <?php else: ?>
                    <span class="label label-warning-custom">Missing</span>
                  <?php endif; ?>
                </td>
                <td><?=html_escape($row['fullname'])?></td>
                <td><?=html_escape($row['gender'])?></td>
                <td><?=!empty($row['birthday']) ? _d($row['birthday']) : '—'?></td>
                <td><?=html_escape($row['register_no'])?></td>
                <td><?=html_escape($row['school_name'])?></td>
                <td><?=html_escape($row['lga'])?></td>
                <td>
                  <span class="label label-info-custom text-xs"><?=html_escape($row['class_name'])?></span>
                </td>
              </tr>
            <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <footer class="panel-footer">
        <a href="<?=base_url('nemis')?>" class="btn btn-sm btn-default">
          <i class="fas fa-arrow-left"></i> Back
        </a>
        <div class="pull-right">
          <a href="<?=base_url('nemis/export_waec_csv') . $csvQuery?>" class="btn btn-sm btn-success">
            <i class="fas fa-file-csv"></i> Download CSV
          </a>
          <button type="button" class="btn btn-sm btn-primary" onclick="nemisprint('waec_printable')">
            <i class="fas fa-file-pdf"></i> Print / PDF
          </button>
        </div>
      </footer>
    </section>

  </div>
</div>

<!-- ── Hidden print-only version ─────────────────────────────────────────── -->
<div id="waec_printable" style="display:none">
    <div style="text-align:center; margin-bottom:16px;">
        <h3 style="margin:0"><?=$exam_type === 'bece' ? 'NECO BECE' : 'WAEC / NECO SSCE'?> Candidate List</h3>
        <p style="margin:4px 0; color:#555">Total: <strong><?=count($candidates)?></strong> candidates &nbsp;|&nbsp; Generated: <?=date('d M Y H:i')?></p>
    </div>
    <table style="width:100%;border-collapse:collapse;font-size:10px">
        <thead>
            <tr style="background:#1a6b3c;color:#fff">
                <th style="border:1px solid #ccc;padding:4px 6px">#</th>
                <th style="border:1px solid #ccc;padding:4px 6px">State ID</th>
                <th style="border:1px solid #ccc;padding:4px 6px">NIN</th>
                <th style="border:1px solid #ccc;padding:4px 6px">Full Name</th>
                <th style="border:1px solid #ccc;padding:4px 6px">Gender</th>
                <th style="border:1px solid #ccc;padding:4px 6px">DOB</th>
                <th style="border:1px solid #ccc;padding:4px 6px">Reg No</th>
                <th style="border:1px solid #ccc;padding:4px 6px">School</th>
                <th style="border:1px solid #ccc;padding:4px 6px">LGA</th>
                <th style="border:1px solid #ccc;padding:4px 6px">Class</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($candidates as $row): ?>
            <tr style="<?=$i%2==0?'background:#f9f9f9':''?>">
                <td style="border:1px solid #ccc;padding:3px 6px"><?=$i++?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=html_escape($row['state_student_id'] ?: 'Missing')?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=html_escape($row['nin'] ?: 'Missing')?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=html_escape($row['fullname'])?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=html_escape($row['gender'])?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=!empty($row['birthday']) ? _d($row['birthday']) : '—'?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=html_escape($row['register_no'])?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=html_escape($row['school_name'])?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=html_escape($row['lga'])?></td>
                <td style="border:1px solid #ccc;padding:3px 6px"><?=html_escape($row['class_name'])?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function(){
    $('#waec_table').DataTable({
        pageLength: 25,
        order: [[7, 'asc'], [3, 'asc']],
        language: { search: 'Filter:', paginate: { previous: '‹', next: '›' } }
    });
});

function nemisprint(id) {
    var content = document.getElementById(id).innerHTML;
    var w = window.open('', '_blank', 'width=1000,height=700');
    w.document.write('<html><head><title>NEMIS Report</title>');
    w.document.write('<style>body{font-family:Arial,sans-serif;padding:20px;color:#222;font-size:11px} table{width:100%;border-collapse:collapse} @media print{@page{size:A4 landscape;margin:10mm}}</style>');
    w.document.write('</head><body>');
    w.document.write(content);
    w.document.write('<script>window.onload=function(){window.print();}<\/script>');
    w.document.write('</body></html>');
    w.document.close();
}
</script>

<!-- Eligibility info box -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default" style="border-left:4px solid #1e88e5">
      <div class="panel-body" style="font-size:12px;padding:10px 16px">
        <strong><i class="fas fa-info-circle text-primary"></i> Nigerian Exam Eligibility Reference</strong>
        <table class="table table-condensed" style="margin:8px 0 0 0;font-size:11px">
          <tr>
            <td><span class="label label-primary">WAEC SSCE</span></td>
            <td><strong>SS3</strong> / SS 3 / SSS3 / Senior Secondary 3 &nbsp;(Final year, Senior Secondary)</td>
            <td class="text-muted">West African Senior School Certificate Examination</td>
          </tr>
          <tr>
            <td><span class="label label-primary">NECO SSCE</span></td>
            <td><strong>SS3</strong> / SS 3 / SSS3 &nbsp;(same as WAEC)</td>
            <td class="text-muted">National Examinations Council — Senior Certificate</td>
          </tr>
          <tr>
            <td><span class="label label-warning">NECO BECE</span></td>
            <td><strong>Basic 9</strong> / JSS 3 / JSS3 &nbsp;(Final year, Junior Secondary)</td>
            <td class="text-muted">Basic Education Certificate Examination (Junior)</td>
          </tr>
          <tr class="danger">
            <td><span class="label label-danger">Not Eligible</span></td>
            <td>Basic 1–8 (Primary 1–6, Basic 7, Basic 8), SS1, SS2 etc.</td>
            <td class="text-muted">Not final-year classes — excluded from exam registration</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
