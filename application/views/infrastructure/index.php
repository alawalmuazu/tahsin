<?php
function condBadge($c) {
    $map = ['Good'=>'success','Fair'=>'warning','Poor'=>'danger','Condemned'=>'default'];
    $cls = isset($map[$c]) ? $map[$c] : 'default';
    return '<span class="label label-' . $cls . '">' . $c . '</span>';
}

$types = [
    'Classroom','Laboratory','Library','Staff Room','Principal Office',
    'Admin Block','Toilet (Male)','Toilet (Female)','Sports Ground','Assembly Hall',
    'Workshop','Computer Room','Generator House','Store Room','Fence/Gate','Other',
];
$conditions = ['Good','Fair','Poor','Condemned'];

$total = count($records);
$good = $fair = $poor = 0;
foreach ($records as $_r) {
    if ($_r['condition'] === 'Good') $good++;
    elseif ($_r['condition'] === 'Fair') $fair++;
    elseif (in_array($_r['condition'], ['Poor','Condemned'])) $poor++;
}
?>

<!-- ── Summary Cards ────────────────────────────────────────────────────────── -->
<div class="row" style="margin-bottom:16px">
    <div class="col-md-3 col-sm-6">
        <div class="panel panel-default" style="border-top:4px solid #1e88e5;text-align:center;padding:14px 0">
            <h3 style="margin:0;color:#1e88e5"><?=$total?></h3>
            <small class="text-muted">Total Assets</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="panel panel-default" style="border-top:4px solid #43a047;text-align:center;padding:14px 0">
            <h3 style="margin:0;color:#43a047"><?=$good?></h3>
            <small class="text-muted">Good Condition</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="panel panel-default" style="border-top:4px solid #fb8c00;text-align:center;padding:14px 0">
            <h3 style="margin:0;color:#fb8c00"><?=$fair?></h3>
            <small class="text-muted">Fair Condition</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="panel panel-default" style="border-top:4px solid #e53935;text-align:center;padding:14px 0">
            <h3 style="margin:0;color:#e53935"><?=$poor?></h3>
            <small class="text-muted">Poor / Condemned</small>
        </div>
    </div>
</div>

<!-- ── Main Panel (tab-based, matching system standard) ─────────────────────── -->
<section class="panel">
    <div class="tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#infra-list" data-toggle="tab">
                    <i class="fas fa-list-ul"></i> Asset List
                </a>
            </li>
            <?php if (get_permission('infrastructure', 'is_add')): ?>
            <li>
                <a href="#infra-add" data-toggle="tab" id="addTabBtn">
                    <i class="far fa-edit"></i> Add Asset
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <div class="tab-content">

            <!-- ── LIST TAB ─────────────────────────────────────────────── -->
            <div id="infra-list" class="tab-pane box active mb-md">

                <!-- Action bar -->
                <div class="row" style="margin-bottom:10px">
                    <div class="col-xs-12 text-right">
                        <a href="<?=base_url('infrastructure/export_csv')?>" class="btn btn-default btn-sm">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <div class="export_title">Infrastructure Register</div>
                    <table class="table table-bordered table-hover table-condensed table-export" id="infra-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <?php if (is_superadmin_loggedin() || is_state_executive_loggedin()): ?>
                                <th>School</th>
                                <th>LGA</th>
                                <?php endif; ?>
                                <th>Type</th>
                                <th>Name / Description</th>
                                <th>Qty</th>
                                <th>Capacity</th>
                                <th>Condition</th>
                                <th>Year Built</th>
                                <th>Notes</th>
                                <?php if (get_permission('infrastructure','is_edit') || get_permission('infrastructure','is_delete')): ?>
                                <th class="no-sort"><?=translate('action')?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($records)): ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted" style="padding:40px">
                                    No infrastructure records found.
                                    <?php if (get_permission('infrastructure','is_add')): ?>
                                    Click <strong>Add Asset</strong> tab above to begin.
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php else: $i=1; foreach ($records as $row): ?>
                            <tr>
                                <td><?=$i++?></td>
                                <?php if (is_superadmin_loggedin() || is_state_executive_loggedin()): ?>
                                <td><?=html_escape($row['school_name'])?></td>
                                <td><?=html_escape($row['lga'])?></td>
                                <?php endif; ?>
                                <td>
                                    <span class="label label-info"><?=html_escape($row['type'])?></span>
                                </td>
                                <td><?=html_escape($row['name'])?></td>
                                <td class="text-center"><?=intval($row['quantity'])?></td>
                                <td class="text-center"><?=$row['capacity'] ? intval($row['capacity']) : '—'?></td>
                                <td><?=condBadge($row['condition'])?></td>
                                <td><?=$row['year_built'] ? $row['year_built'] : '—'?></td>
                                <td style="max-width:200px;font-size:11px"><?=html_escape($row['notes'])?></td>
                                <?php if (get_permission('infrastructure','is_edit') || get_permission('infrastructure','is_delete')): ?>
                                <td class="text-center min-w-c">
                                    <?php if (get_permission('infrastructure','is_edit')): ?>
                                    <a href="javascript:void(0)" class="btn btn-default btn-circle icon edit-btn"
                                       data-id="<?=$row['id']?>" title="<?=translate('edit')?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (get_permission('infrastructure','is_delete')): ?>
                                    <?=btn_delete('infrastructure/delete/' . $row['id'])?>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end #infra-list -->

            <!-- ── ADD TAB ──────────────────────────────────────────────── -->
            <?php if (get_permission('infrastructure','is_add')): ?>
            <div id="infra-add" class="tab-pane box mb-md">
                <?=form_open('javascript:void(0)', ['id'=>'addForm'])?>

                <!-- Row 1: Branch (superadmin) + Asset Type -->
                <div class="row">
                    <?php if (is_superadmin_loggedin()): ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>
                            <?php echo form_dropdown('branch_id', $this->app_lib->getSelectList('branch'), '',
                                "class='form-control' data-plugin-selectTwo data-width='100%'"); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Asset Type <span class="required">*</span></label>
                            <select name="type" class="form-control" required>
                                <option value="">-- Select Type --</option>
                                <?php foreach ($types as $t): ?>
                                <option value="<?=$t?>"><?=$t?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Name + Quantity (col-3) + Capacity (col-3) -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Name / Description <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="e.g. Science Lab Block A" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Capacity (persons)</label>
                            <input type="number" name="capacity" class="form-control" placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Row 3: Year Built (col-3) + Condition (col-3) + Notes (col-6) -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Year Built</label>
                            <input type="number" name="year_built" class="form-control"
                                   placeholder="e.g. 2005" min="1900" max="<?=date('Y')?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Condition <span class="required">*</span></label>
                            <select name="condition" class="form-control" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($conditions as $c): ?>
                                <option value="<?=$c?>"><?=$c?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Notes / Remarks</label>
                            <textarea name="notes" class="form-control" rows="2"
                                      placeholder="e.g. Needs roof repair"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Buttons — with top margin for breathing room -->
                <div class="row mt-md">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" id="addBtn">
                            <i class="fas fa-save"></i> Save Asset
                        </button>
                        <button type="reset" class="btn btn-default">Reset</button>
                    </div>
                </div>

                <?=form_close()?>
            </div><!-- end #infra-add -->
            <?php endif; ?>

        </div><!-- end .tab-content -->
    </div><!-- end .tabs-custom -->
</section>

<!-- ── Edit Modal (popup) ────────────────────────────────────────────────────── -->
<div id="editModal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <header class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-pencil-alt"></i> Edit Infrastructure Asset</h4>
        </header>
        <?=form_open('javascript:void(0)', ['id'=>'editForm'])?>
        <input type="hidden" name="id" id="edit_id">
        <div class="panel-body">
            <?php if (is_superadmin_loggedin()): ?>
            <div class="form-group">
                <label class="control-label"><?=translate('branch')?></label>
                <?php echo form_dropdown('branch_id', $this->app_lib->getSelectList('branch'), '',
                    "id='edit_branch_id' class='form-control' data-plugin-selectTwo data-width='100%'"); ?>
            </div>
            <?php endif; ?>
            <!-- Row 1: Asset Type + Name -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Asset Type <span class="required">*</span></label>
                        <select name="type" id="edit_type" class="form-control" required>
                            <option value="">-- Select Type --</option>
                            <?php foreach ($types as $t): ?>
                            <option value="<?=$t?>"><?=$t?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Name / Description <span class="required">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                </div>
            </div>
            <!-- Row 2: Quantity (col-3) + Capacity (col-3) + Year Built (col-3) + Condition (col-3) -->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Quantity</label>
                        <input type="number" name="quantity" id="edit_quantity" class="form-control" min="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Capacity (persons)</label>
                        <input type="number" name="capacity" id="edit_capacity" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Year Built</label>
                        <input type="number" name="year_built" id="edit_year_built" class="form-control"
                               min="1900" max="<?=date('Y')?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Condition <span class="required">*</span></label>
                        <select name="condition" id="edit_condition" class="form-control" required>
                            <?php foreach ($conditions as $c): ?>
                            <option value="<?=$c?>"><?=$c?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Row 3: Notes full width -->
            <div class="form-group">
                <label class="control-label">Notes / Remarks</label>
                <textarea name="notes" id="edit_notes" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-default modal-dismiss">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </div>
        </footer>
        <?=form_close()?>
    </section>
</div>

<script>
// ── Add form submit ────────────────────────────────────────────────────────
$('#addForm').on('submit', function(e){
    e.preventDefault();
    var $btn = $('#addBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    $.post(base_url + 'infrastructure/save', $(this).serialize(), function(res){
        $btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Asset');
        if (res.status === 'success') {
            set_alert('success', res.message);
            location.reload();
        } else {
            var errs = res.error ? Object.values(res.error).join('<br>') : 'An error occurred.';
            set_alert('error', errs);
        }
    }, 'json').fail(function(){
        $btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Asset');
        set_alert('error', 'Server error. Please try again.');
    });
});

// ── Edit trigger ───────────────────────────────────────────────────────────
$(document).on('click', '.edit-btn', function(){
    var id = $(this).data('id');
    $.post(base_url + 'infrastructure/details', {id: id}, function(r){
        $('#edit_id').val(r.id);
        $('#edit_name').val(r.name);
        $('#edit_type').val(r.type);
        $('#edit_quantity').val(r.quantity);
        $('#edit_capacity').val(r.capacity);
        $('#edit_condition').val(r.condition);
        $('#edit_year_built').val(r.year_built);
        $('#edit_notes').val(r.notes);
        if ($('#edit_branch_id').length) {
            $('#edit_branch_id').val(r.branch_id).trigger('change');
        }
        $.magnificPopup.open({items:{src:'#editModal'}, type:'inline'});
    }, 'json');
});

// ── Edit form submit ───────────────────────────────────────────────────────
$('#editForm').on('submit', function(e){
    e.preventDefault();
    $.post(base_url + 'infrastructure/save', $(this).serialize(), function(res){
        if (res.status === 'success') {
            set_alert('success', res.message);
            $.magnificPopup.close();
            location.reload();
        } else {
            var errs = res.error ? Object.values(res.error).join('<br>') : 'An error occurred.';
            set_alert('error', errs);
        }
    }, 'json');
});
</script>
