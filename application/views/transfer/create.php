<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-plus-circle"></i> Initiate Transfer Request</h4>
            </header>
            <?php if (!empty($has_pending)): ?>
            <div class="panel-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Active Request Exists.</strong> You already have a <strong>Pending</strong> transfer request that is awaiting review. You cannot submit a new request until it has been resolved.
                    <br/><a href="<?=base_url('teacher_transfer')?>" class="btn btn-sm btn-default mt-sm"><i class="fas fa-arrow-left"></i> View My Requests</a>
                </div>
            </div>
            <?php else: ?>
            <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered validate', 'enctype' => 'multipart/form-data')); ?>
            <div class="panel-body">
                <?php if (get_permission('teacher_transfer', 'is_add')): ?>
                <div class="form-group">
                    <label class="col-md-3 control-label">Select Teacher <span class="required">*</span></label>
                    <div class="col-md-6">
                        <select name="staff_id" class="form-control" data-plugin-selectTwo required>
                            <option value="">Please Select</option>
                            <?php foreach ($staff_list as $s): ?>
                                <option value="<?=$s['id']?>"><?=$s['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php else: ?>
                <input type="hidden" name="staff_id" value="<?=get_loggedin_user_id()?>">
                <div class="form-group">
                    <label class="col-md-3 control-label">Teacher <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" value="<?=get_type_name_by_id('staff', get_loggedin_user_id(), 'name')?>" disabled>
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="col-md-3 control-label">Preferred Target School <span class="required">*</span></label>
                    <div class="col-md-6">
                        <select name="to_branch_id" class="form-control" data-plugin-selectTwo required>
                            <option value="">Please Select</option>
                            <?php foreach ($branch_list as $b): ?>
                                <option value="<?=$b['id']?>"><?=$b['name']?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block"><i class="fas fa-info-circle"></i> <em>Note: The reviewer may post you to a different school based on availability and need.</em></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Effective Date <span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" data-plugin-datepicker name="effective_date" required placeholder="YYYY-MM-DD" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Reason / Justification <span class="required">*</span></label>
                    <div class="col-md-6 mb-md">
                        <textarea name="reason" class="form-control" required rows="4"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Supporting Attachment <small>(Optional)</small></label>
                    <div class="col-md-6">
                        <input type="file" name="attachment_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        <p class="help-block"><i class="fas fa-paperclip"></i> Accepted formats: PDF, JPG, PNG &mdash; Max 5MB.</p>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-offset-3 col-md-3">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-paper-plane"></i> Submit Request</button>
                    </div>
                </div>
            </footer>
            <?php echo form_close(); ?>
            <?php endif; ?>
        </section>
    </div>
</div>
