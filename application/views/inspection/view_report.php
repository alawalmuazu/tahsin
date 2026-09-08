<div class="row">
    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-file-alt"></i> Report Details</h4>
            </header>
            <div class="panel-body">
                <table class="table table-striped table-condensed">
                    <tr><th>School Name</th><td><?=$report['branch_name']?></td></tr>
                    <tr><th>Inspector</th><td><?=$report['inspector_name']?></td></tr>
                    <tr><th>Inspection Date</th><td><?=_d($report['inspection_date'])?></td></tr>
                    <tr><th>Next Review</th><td><?=$report['next_inspection_date'] ? _d($report['next_inspection_date']) : 'N/A'?></td></tr>
                    <tr><th>Overall Grade</th><td>
                        <?php 
                        $label_class = 'label-info';
                        if($report['overall_grade'] == 'Excellent') $label_class = 'label-success-custom';
                        if($report['overall_grade'] == 'Good') $label_class = 'label-primary';
                        if($report['overall_grade'] == 'Fair') $label_class = 'label-warning-custom';
                        if($report['overall_grade'] == 'Poor') $label_class = 'label-danger-custom';
                        ?>
                        <span class="label <?=$label_class?>"><?=$report['overall_grade']?> (<?=$report['total_score']?>%)</span>
                    </td></tr>
                </table>
                <hr>
                <h5><strong>Scores Breakdown</strong></h5>
                <ul class="list-group">
                    <li class="list-group-item">Infrastructure <span class="badge"><?=$report['infrastructure_score']?>/100</span></li>
                    <li class="list-group-item">Teaching Quality <span class="badge"><?=$report['teaching_quality_score']?>/100</span></li>
                    <li class="list-group-item">Compliance <span class="badge"><?=$report['compliance_score']?>/100</span></li>
                </ul>
                <hr>
                <h5><strong>Recommendations</strong></h5>
                <p><?=nl2br(htmlspecialchars($report['recommendations']))?></p>
            </div>
        </section>
    </div>

    <div class="col-md-8">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-list-ul"></i> Identified Deficiencies</h4>
            </header>
            <div class="panel-body">
                <?php if(empty($deficiencies)): ?>
                    <div class="alert alert-success">No deficiencies recorded in this inspection. Excellent!</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($deficiencies as $def): ?>
                                <tr>
                                    <td><?=$def['category']?></td>
                                    <td><?=$def['description']?></td>
                                    <td>
                                        <?php if($def['severity'] == 'Critical') echo '<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Critical</span>';
                                              elseif($def['severity'] == 'Moderate') echo '<span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Moderate</span>';
                                              else echo '<span class="text-info"><i class="fas fa-info-circle"></i> Minor</span>'; ?>
                                    </td>
                                    <td id="status_wrap_<?=$def['id']?>">
                                        <?php if($def['remediation_status'] == 'Resolved') echo '<span class="label label-success-custom">Resolved</span>';
                                              elseif($def['remediation_status'] == 'In Progress') echo '<span class="label label-warning-custom">In Progress</span>';
                                              else echo '<span class="label label-danger-custom">Open</span>'; ?>
                                    </td>
                                    <td>
                                        <?php if (get_permission('school_inspection', 'is_edit')): ?>
                                        <select class="form-control input-sm def-status-update" data-id="<?=$def['id']?>">
                                            <option value="Open" <?=$def['remediation_status']=='Open'?'selected':''?>>Open</option>
                                            <option value="In Progress" <?=$def['remediation_status']=='In Progress'?'selected':''?>>In Progress</option>
                                            <option value="Resolved" <?=$def['remediation_status']=='Resolved'?'selected':''?>>Resolved</option>
                                        </select>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.def-status-update').on('change', function() {
        var id = $(this).data('id');
        var status = $(this).val();
        
        $.ajax({
            url: base_url + 'school_inspection/update_deficiency/' + id,
            type: 'POST',
            data: {status: status},
            dataType: 'json',
            success: function(res) {
                if(res.status == 'success') {
                    // Update label locally
                    var labelHtml = '';
                    if(status == 'Resolved') labelHtml = '<span class="label label-success-custom">Resolved</span>';
                    else if(status == 'In Progress') labelHtml = '<span class="label label-warning-custom">In Progress</span>';
                    else labelHtml = '<span class="label label-danger-custom">Open</span>';
                    
                    $('#status_wrap_' + id).html(labelHtml);
                }
            }
        });
    });
});
</script>
