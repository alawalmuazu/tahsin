<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-user-check"></i> Pending Credential Approvals</h4>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-none table-export">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?=translate('name')?></th>
                        <th><?=translate('username')?></th>
                        <th><?=translate('role')?></th>
                        <th><?=translate('status')?></th>
                        <th><?=translate('action')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $count = 1;
                    foreach ($pending_approvals as $row): 
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row->user_name; ?></td>
                        <td><?php echo $row->username; ?></td>
                        <td><?php echo $row->role_name; ?></td>
                        <td><span class="label label-warning-custom">Pending</span></td>
                        <td>
                            <a href="<?php echo base_url('credential_approvals/approve/' . $row->id); ?>" class="btn btn-success btn-circle icon" data-toggle="tooltip" data-original-title="Approve">
                                <i class="fas fa-check"></i>
                            </a>
                            <a href="<?php echo base_url('credential_approvals/reject/' . $row->id); ?>" class="btn btn-danger btn-circle icon" data-toggle="tooltip" data-original-title="Reject" onclick="return confirm('Are you sure you want to reject this application?');">
                                <i class="fas fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($pending_approvals)): ?>
                    <tr>
                        <td colspan="6" class="text-center">No pending approvals at this time.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
