<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-plus-circle"></i> Log New Inspection Report</h4>
            </header>
            <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Action <span class="required">*</span></label>
                    <div class="col-md-6 mb-md">
                        <div class="radio-custom radio-primary radio-inline">
                            <input type="radio" value="completed" name="workflow_state" id="ws_completed" checked>
                            <label for="ws_completed">Log Retrospectively (Completed)</label>
                        </div>
                        <div class="radio-custom radio-primary radio-inline">
                            <input type="radio" value="pending" name="workflow_state" id="ws_pending">
                            <label for="ws_pending">Assign Task (Pending)</label>
                        </div>
                    </div>
                </div>

                <!-- Section A: Overview -->
                <h4 class="mb-xlg">Section A: Overview</h4>
                <div class="form-group">
                    <label class="col-md-3 control-label">School <span class="required">*</span></label>
                    <div class="col-md-6">
                        <select name="branch_id" class="form-control" data-plugin-selectTwo required>
                            <option value="">Please Select</option>
                            <?php foreach ($branch_list as $b): ?>
                                <option value="<?=$b['id']?>"><?=$b['name']?></option>
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
                                <option value="<?=$i['id']?>" <?=get_loggedin_user_id() == $i['id'] ? 'selected' : ''?>><?=$i['name']?> (<?=$i['role_name']?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Inspection Date <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" data-plugin-datepicker name="inspection_date" required placeholder="YYYY-MM-DD" autocomplete="off" />
                    </div>
                </div>

                <div id="execution_sections">
                <!-- Section B: Scoring -->
                <h4 class="mb-xlg mt-xlg">Section B: Scoring (0-100)</h4>
                <div class="form-group">
                    <label class="col-md-3 control-label">Infrastructure Score <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="infrastructure_score" required min="0" max="100" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Teaching Quality Score <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="teaching_quality_score" required min="0" max="100" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Compliance Score <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="compliance_score" required min="0" max="100" />
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
                                <tr id="row_0">
                                    <td>
                                        <select name="def_category[]" class="form-control">
                                            <option value="Infrastructure">Infrastructure</option>
                                            <option value="Staffing">Staffing</option>
                                            <option value="Resources">Resources</option>
                                            <option value="Compliance">Compliance</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="def_description[]" placeholder="Brief description"></td>
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
                        <textarea name="recommendations" class="form-control" required rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group mb-md">
                    <label class="col-md-3 control-label">Next Inspection Due</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" data-plugin-datepicker name="next_inspection_date" placeholder="YYYY-MM-DD" autocomplete="off" />
                    </div>
                </div> <!-- Execution sections closed -->
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-offset-3 col-md-2">
                        <button type="submit" class="btn btn-default btn-block"><i class="fas fa-save"></i> Save</button>
                    </div>
                </div>
            </footer>
            <?php echo form_close(); ?>
        </section>
    </div>
</div>

<script>
var rowIdx = 1;
function addRow() {
    var html = '<tr id="row_' + rowIdx + '">';
    html += '<td><select name="def_category[]" class="form-control"><option value="Infrastructure">Infrastructure</option><option value="Staffing">Staffing</option><option value="Resources">Resources</option><option value="Compliance">Compliance</option></select></td>';
    html += '<td><input type="text" class="form-control" name="def_description[]" placeholder="Brief description"></td>';
    html += '<td><select name="def_severity[]" class="form-control"><option value="Critical">Critical</option><option value="Moderate" selected>Moderate</option><option value="Minor">Minor</option></select></td>';
    html += '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(' + rowIdx + ')"><i class="fas fa-trash"></i></button></td>';
    html += '</tr>';
    $('#def_table tbody').append(html);
    rowIdx++;
}
function removeRow(id) {
    $('#row_' + id).remove();
}

$(document).ready(function() {
    $('input[type=radio][name=workflow_state]').change(function() {
        if (this.value == 'pending') {
            $('#execution_sections').hide();
            $('#execution_sections input[type=number], #execution_sections textarea').removeAttr('required');
        } else {
            $('#execution_sections').show();
            $('#execution_sections input[type=number], #execution_sections textarea').attr('required', 'required');
        }
    });
});
</script>
