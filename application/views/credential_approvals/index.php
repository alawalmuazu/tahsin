<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info" style="border-left: 4px solid #1a6b3c;">
            <div class="panel-body" style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h4 style="margin: 0 0 5px; font-weight: 600; color: #1a6b3c;">
                            <i class="fas fa-user-check me-1"></i> Staff Registration Approvals
                        </h4>
                        <p class="text-muted" style="margin: 0;">
                            Candidates who register via staff links (Facilitator, Accountant, Librarian, Receptionist) must be reviewed and approved here before their login accounts become active.
                        </p>
                    </div>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <button type="button" class="btn btn-default btn-sm" onclick="if(typeof playTahsinNotification==='function') playTahsinNotification(3);" title="Play notification sound 3 times">
                            <i class="fas fa-volume-up" style="color: #e07a5f;"></i> Test Sound (3x)
                        </button>
                        <a href="<?=base_url('credential_approvals/invite')?>" class="btn btn-default btn-sm" style="background: #1a6b3c; color: #fff; border-color: #1a6b3c;">
                            <i class="fas fa-paper-plane"></i> Send Registration Links
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-cog"></i> Registration Settings</h4>
            </header>
            <div class="panel-body">
                <?php echo form_open('credential_approvals/save_settings', array('class' => 'form-horizontal form-bordered')); ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Enable Staff Registration</label>
                        <div class="col-md-6">
                            <div class="material-switch mt-xs">
                                <input id="staff_registration_enabled" name="staff_registration_enabled" type="checkbox" <?php echo ($reg_settings->staff_registration_enabled == 1) ? 'checked' : ''; ?> />
                                <label for="staff_registration_enabled" class="label-primary"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Registration Deadline</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="staff_registration_deadline" value="<?php echo $reg_settings->staff_registration_deadline; ?>">
                            <span class="help-block">Leave blank for no deadline. If a deadline is set, registration will automatically close after this date.</span>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-2">
                                <button type="submit" class="btn btn-default btn-block" style="background: #1a6b3c; color: #fff;">
                                    <i class="fas fa-save"></i> Save Settings
                                </button>
                            </div>
                        </div>
                    </footer>
                <?php echo form_close(); ?>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-list"></i> Pending Applications</h4>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed mb-none table-export">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Applicant Name</th>
                                <th>Requested Role</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $count = 1;
                            foreach ($pending_approvals as $row): 
                                $role_badge = 'badge-primary';
                                $role_style = 'background: #0284c7; color: #fff;';
                                if ($row->role == 4) { // Accountant
                                    $role_style = 'background: #d97706; color: #fff;';
                                } elseif ($row->role == 5) { // Librarian
                                    $role_style = 'background: #16a34a; color: #fff;';
                                } elseif ($row->role == 8) { // Receptionist
                                    $role_style = 'background: #9333ea; color: #fff;';
                                } elseif ($row->role == 3) { // Facilitator
                                    $role_style = 'background: #0284c7; color: #fff;';
                                }
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><strong><?php echo html_escape($row->user_name); ?></strong></td>
                                <td>
                                    <span class="badge" style="<?=$role_style?> font-weight: 600; padding: 4px 10px; border-radius: 12px;">
                                        <?php echo html_escape($row->role_name); ?>
                                    </span>
                                </td>
                                <td><code><?php echo html_escape($row->username); ?></code></td>
                                <td>
                                    <?php if (!empty($row->user_email)): ?>
                                        <a href="mailto:<?php echo html_escape($row->user_email); ?>"><?php echo html_escape($row->user_email); ?></a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row->user_mobile)): ?>
                                        <a href="tel:<?php echo html_escape($row->user_mobile); ?>"><?php echo html_escape($row->user_mobile); ?></a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    if (!empty($row->reg_date)) {
                                        echo date('M d, Y · h:i A', strtotime($row->reg_date));
                                    } else {
                                        echo '—';
                                    }
                                    ?>
                                </td>
                                <td><span class="label label-warning" style="background: #e07a5f; color: #fff; padding: 4px 8px; border-radius: 4px;">Pending Review</span></td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <button type="button"
                                        class="btn btn-default btn-xs btn-preview-applicant"
                                        data-toggle="tooltip"
                                        data-original-title="Preview application"
                                        style="margin-right: 4px;"
                                        data-id="<?php echo (int) $row->id; ?>"
                                        data-name="<?php echo html_escape($row->user_name); ?>"
                                        data-role="<?php echo html_escape($row->role_name); ?>"
                                        data-username="<?php echo html_escape($row->username); ?>"
                                        data-email="<?php echo html_escape($row->user_email); ?>"
                                        data-mobile="<?php echo html_escape($row->user_mobile); ?>"
                                        data-staff-id="<?php echo html_escape(isset($row->staff_id_no) ? $row->staff_id_no : ''); ?>"
                                        data-qualification="<?php echo html_escape(isset($row->qualification) ? $row->qualification : ''); ?>"
                                        data-designation="<?php echo html_escape(isset($row->designation_name) ? $row->designation_name : ''); ?>"
                                        data-department="<?php echo html_escape(isset($row->department_name) ? $row->department_name : ''); ?>"
                                        data-joining="<?php echo html_escape(!empty($row->joining_date) ? date('M d, Y', strtotime($row->joining_date)) : ''); ?>"
                                        data-sex="<?php echo html_escape(isset($row->sex) ? ucfirst($row->sex) : ''); ?>"
                                        data-address="<?php echo html_escape(isset($row->present_address) ? $row->present_address : ''); ?>"
                                        data-submitted="<?php echo html_escape(!empty($row->reg_date) ? date('M d, Y · h:i A', strtotime($row->reg_date)) : '—'); ?>"
                                        data-photo="<?php echo html_escape(get_image_url('staff', isset($row->photo) ? $row->photo : '')); ?>"
                                        data-approve-url="<?php echo base_url('credential_approvals/approve/' . $row->id); ?>"
                                        data-reject-url="<?php echo base_url('credential_approvals/reject/' . $row->id); ?>">
                                        <i class="fas fa-eye"></i> Preview
                                    </button>
                                    <a href="<?php echo base_url('credential_approvals/approve/' . $row->id); ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-original-title="Approve and Activate Account" onclick="return confirm('Approve and activate account for <?php echo html_escape($row->user_name); ?>?');" style="margin-right: 4px;">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                    <a href="<?php echo base_url('credential_approvals/reject/' . $row->id); ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" data-original-title="Reject and Remove Application" onclick="return confirm('Are you sure you want to reject this application? This will permanently remove the pending record.');">
                                        <i class="fas fa-times"></i> Reject
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($pending_approvals)): ?>
                            <tr>
                                <td colspan="9" class="text-center" style="padding: 30px;">
                                    <i class="fas fa-check-circle" style="font-size: 32px; color: #1a6b3c; margin-bottom: 10px; display: block;"></i>
                                    <p style="font-weight: 600; margin-bottom: 4px;">No Pending Applications</p>
                                    <span class="text-muted">All registered staff members have been reviewed. Share registration links to invite more staff.</span>
                                    <div style="margin-top: 12px;">
                                        <a href="<?=base_url('credential_approvals/invite')?>" class="btn btn-default btn-sm">
                                            <i class="fas fa-paper-plane"></i> Send Staff Registration Links
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Applicant Preview Modal -->
<div class="modal fade" id="applicantPreviewModal" tabindex="-1" role="dialog" aria-labelledby="applicantPreviewLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header" style="background: #10241e; color: #fff; border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.85;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="applicantPreviewLabel" style="font-weight: 600;">
                    <i class="fas fa-user-circle"></i> Application Preview
                </h4>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div class="row">
                    <div class="col-md-3 text-center" style="margin-bottom: 18px;">
                        <img id="preview_photo" src="" alt="Applicant photo" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #1a6b3c; background: #eef2f5;">
                        <div style="margin-top: 10px;">
                            <span id="preview_status" class="label label-warning" style="background: #e07a5f; color: #fff; padding: 4px 10px; border-radius: 4px;">Pending Review</span>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h3 id="preview_name" style="margin-top: 0; font-weight: 700; color: #0b1a16;"></h3>
                        <p style="margin-bottom: 16px;">
                            <span id="preview_role" class="badge" style="background: #0284c7; color: #fff; font-weight: 600; padding: 5px 12px; border-radius: 12px;"></span>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed mb-none" style="margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <th style="width: 38%; background: #f8fafc;">Staff ID</th>
                                        <td id="preview_staff_id">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Username</th>
                                        <td><code id="preview_username"></code></td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Email</th>
                                        <td id="preview_email">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Phone</th>
                                        <td id="preview_mobile">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Qualification</th>
                                        <td id="preview_qualification">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Designation</th>
                                        <td id="preview_designation">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Department</th>
                                        <td id="preview_department">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Gender</th>
                                        <td id="preview_sex">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Joining Date</th>
                                        <td id="preview_joining">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Address</th>
                                        <td id="preview_address">—</td>
                                    </tr>
                                    <tr>
                                        <th style="background: #f8fafc;">Date Submitted</th>
                                        <td id="preview_submitted">—</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #fbf7ee; border-top: 1px solid #e7dcc4;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="#" id="preview_reject_btn" class="btn btn-danger" onclick="return confirm('Reject this application? This will permanently remove the pending record.');">
                    <i class="fas fa-times"></i> Reject
                </a>
                <a href="#" id="preview_approve_btn" class="btn btn-success" style="background: #1a6b3c; border-color: #1a6b3c;" onclick="return confirm('Approve and activate this account?');">
                    <i class="fas fa-check"></i> Approve
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    <?php if (!empty($pending_approvals)): ?>
    setTimeout(function() {
        if (typeof window.playTahsinNotification === 'function') {
            window.playTahsinNotification(3);
        }
    }, 700);
    <?php endif; ?>

    function dash(val) {
        return (val && String(val).trim() !== '') ? val : '—';
    }

    $(document).on('click', '.btn-preview-applicant', function() {
        var $btn = $(this);
        var name = $btn.data('name') || 'Applicant';

        $('#preview_photo').attr('src', $btn.data('photo') || '');
        $('#preview_name').text(name);
        $('#preview_role').text($btn.data('role') || '—');
        $('#preview_staff_id').text(dash($btn.data('staff-id')));
        $('#preview_username').text($btn.data('username') || '—');
        $('#preview_email').html($btn.data('email') ? '<a href="mailto:' + $btn.data('email') + '">' + $btn.data('email') + '</a>' : '—');
        $('#preview_mobile').html($btn.data('mobile') ? '<a href="tel:' + $btn.data('mobile') + '">' + $btn.data('mobile') + '</a>' : '—');
        $('#preview_qualification').text(dash($btn.data('qualification')));
        $('#preview_designation').text(dash($btn.data('designation')));
        $('#preview_department').text(dash($btn.data('department')));
        $('#preview_sex').text(dash($btn.data('sex')));
        $('#preview_joining').text(dash($btn.data('joining')));
        $('#preview_address').text(dash($btn.data('address')));
        $('#preview_submitted').text(dash($btn.data('submitted')));

        $('#preview_approve_btn')
            .attr('href', $btn.data('approve-url'))
            .attr('onclick', "return confirm('Approve and activate account for " + name.replace(/'/g, "\\'") + "?');");
        $('#preview_reject_btn')
            .attr('href', $btn.data('reject-url'));

        $('#applicantPreviewModal').modal('show');
    });
});
</script>
