<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-edit"></i> Edit Inspection Report</h4>
            </header>
            <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
            <div class="panel-body">
                <!-- Section A: Overview -->
                <h4 class="mb-xlg">Section A: Overview</h4>
                <div class="form-group">
                    <label class="col-md-3 control-label">School <span class="required">*</span></label>
                    <div class="col-md-6">
                        <select name="branch_id" class="form-control" data-plugin-selectTwo required>
                            <option value="">Please Select</option>
                            <?php foreach ($branch_list as $b): ?>
                                <option value="<?=$b['id']?>" <?=$report['branch_id'] == $b['id'] ? 'selected' : ''?>><?=$b['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Assigned Inspector <span class="required">*</span></label>
                    <div class="col-md-6">
                        <select name="inspector_id" class="form-control" data-plugin-selectTwo required>
                            <option value="">Please Select</option>
                            <?php foreach ($inspectors as $i): ?>
                                <option value="<?=$i['id']?>" <?=$report['inspector_id'] == $i['id'] ? 'selected' : ''?>><?=$i['name']?> (<?=$i['role_name']?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Inspection Date <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" data-plugin-datepicker name="inspection_date" required value="<?=$report['inspection_date']?>" placeholder="YYYY-MM-DD" autocomplete="off" />
                    </div>
                </div>

                <!-- Section B: Scoring -->
                <h4 class="mb-xlg mt-xlg">Section B: Scoring (0-100)</h4>
                <div class="form-group">
                    <label class="col-md-3 control-label">Infrastructure Score <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="infrastructure_score" required value="<?=$report['infrastructure_score'] == 0 ? '' : $report['infrastructure_score']?>" min="0" max="100" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Teaching Quality Score <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="teaching_quality_score" required value="<?=$report['teaching_quality_score'] == 0 ? '' : $report['teaching_quality_score']?>" min="0" max="100" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Compliance Score <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="compliance_score" required value="<?=$report['compliance_score'] == 0 ? '' : $report['compliance_score']?>" min="0" max="100" />
                    </div>
                </div>

                <!-- Section C: Deficiencies -->
                <h4 class="mb-xlg mt-xlg">Section C: Identified Deficiencies</h4>
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-10">
                        <table class="table table-bordered" id="def_table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Severity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $rowIdx = 0;
                                if(empty($deficiencies)): 
                                ?>
                                <tr id="row_0">
                                    <td>
                                        <input type="hidden" name="def_id[]" value="">
                                        <select name="def_category[]" class="form-control">
                                            <option value="Infrastructure">Infrastructure</option>
                                            <option value="Staffing">Staffing</option>
                                            <option value="Resources">Resources</option>
                                            <option value="Compliance">Compliance</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="def_description[]" placeholder="Brief description" required></td>
                                    <td>
                                        <select name="def_severity[]" class="form-control">
                                            <option value="Critical">Critical</option>
                                            <option value="Moderate" selected>Moderate</option>
                                            <option value="Minor">Minor</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(0)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php $rowIdx = 1; else: ?>
                                    <?php foreach($deficiencies as $key => $def): ?>
                                    <tr id="row_<?=$key?>">
                                        <td>
                                            <input type="hidden" name="def_id[]" value="<?=$def['id']?>">
                                            <select name="def_category[]" class="form-control">
                                                <option value="Infrastructure" <?=$def['category']=='Infrastructure'?'selected':''?>>Infrastructure</option>
                                                <option value="Staffing" <?=$def['category']=='Staffing'?'selected':''?>>Staffing</option>
                                                <option value="Resources" <?=$def['category']=='Resources'?'selected':''?>>Resources</option>
                                                <option value="Compliance" <?=$def['category']=='Compliance'?'selected':''?>>Compliance</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="def_description[]" value="<?=htmlspecialchars($def['description'])?>" placeholder="Brief description" required></td>
                                        <td>
                                            <select name="def_severity[]" class="form-control">
                                                <option value="Critical" <?=$def['severity']=='Critical'?'selected':''?>>Critical</option>
                                                <option value="Moderate" <?=$def['severity']=='Moderate'?'selected':''?>>Moderate</option>
                                                <option value="Minor" <?=$def['severity']=='Minor'?'selected':''?>>Minor</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(<?=$key?>)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; 
                                    $rowIdx = count($deficiencies);
                                    endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"><button type="button" class="btn btn-default btn-sm" onclick="addRow()"><i class="fas fa-plus"></i> Add Row</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Section D: Wrap Up -->
                <h4 class="mb-xlg mt-xlg">Section D: Wrap Up</h4>
                <div class="form-group">
                    <label class="col-md-3 control-label">Recommendations <span class="required">*</span></label>
                    <div class="col-md-6">
                        <textarea name="recommendations" class="form-control" required rows="3"><?=$report['recommendations']?></textarea>
                    </div>
                </div>
                <div class="form-group mb-md">
                    <label class="col-md-3 control-label">Next Inspection Due</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" data-plugin-datepicker name="next_inspection_date" value="<?=empty($report['next_inspection_date']) || $report['next_inspection_date'] == '0000-00-00' ? '' : $report['next_inspection_date']?>" placeholder="YYYY-MM-DD" autocomplete="off" />
                    </div>
                </div>
                <input type="hidden" name="workflow_state" id="workflow_state" value="in_progress">
            </div>
            <footer class="panel-footer">
                <p class="text-danger text-center mt-sm"><i class="fas fa-info-circle"></i> <em>Note: Once 'Final Submit' is clicked, this report becomes read-only and no further modifications can occur.</em></p>
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-default mr-sm cancel" formnovalidate onclick="document.getElementById('workflow_state').value='in_progress';"><i class="fas fa-save"></i> Save Progress</button>
                        <button type="submit" class="btn btn-primary" onclick="document.getElementById('workflow_state').value='completed';"><i class="fas fa-check-circle"></i> Final Submit</button>
                    </div>
                </div>
            </footer>
            <?php echo form_close(); ?>
        </section>
    </div></div>

<script>
var rowIdx = <?=$rowIdx ?? 1?>;
function addRow() {
    var html = '<tr id="row_' + rowIdx + '">';
    html += '<td><input type="hidden" name="def_id[]" value=""><select name="def_category[]" class="form-control"><option value="Infrastructure">Infrastructure</option><option value="Staffing">Staffing</option><option value="Resources">Resources</option><option value="Compliance">Compliance</option></select></td>';
    html += '<td><input type="text" class="form-control" name="def_description[]" placeholder="Brief description" required></td>';
    html += '<td><select name="def_severity[]" class="form-control"><option value="Critical">Critical</option><option value="Moderate" selected>Moderate</option><option value="Minor">Minor</option></select></td>';
    html += '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(' + rowIdx + ')"><i class="fas fa-trash"></i></button></td>';
    html += '</tr>';
    $('#def_table tbody').append(html);
    rowIdx++;
}
function removeRow(id) {
    $('#row_' + id).remove();
}
</script>
