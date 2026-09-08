<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-btn">
                    <a href="<?=base_url('teacher_transfer/create')?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Initiate Transfer">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <h4 class="panel-title"><i class="fas fa-exchange-alt"></i> Teacher Transfers</h4>
            </header>
            <div class="panel-body">
                <div class="mb-md">
                    <table class="table table-bordered table-hover table-condensed mb-none table-export">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Teacher</th>
                                <th>From School</th>
                                <th>Target School</th>
                                <th>Effective Date</th>
                                <th>Status</th>
                                <th>Attachment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $count = 1;
                            foreach ($all_transfers as $row): 
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo current(explode(' ', $row['staff_name'])) . ' (' . $row['designation_name'] . ')'; ?></td>
                                <td><?php echo $row['from_branch'] ? $row['from_branch'] : 'N/A'; ?></td>
                                <td><?php echo $row['to_branch']; ?></td>
                                <td><?php echo _d($row['effective_date']); ?></td>
                                <td>
                                    <?php if ($row['status'] == 'pending') {
                                        echo '<span class="label label-warning-custom">Pending</span>';
                                    } elseif ($row['status'] == 'approved') {
                                        echo '<span class="label label-success-custom">Approved</span>';
                                    } else {
                                        echo '<span class="label label-danger-custom">Rejected</span>';
                                    } ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['attachment'])): ?>
                                        <a href="<?=base_url('uploads/transfer_attachments/'.$row['attachment'])?>" target="_blank" class="btn btn-xs btn-info" title="View Attachment"><i class="fas fa-paperclip"></i></a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'pending' && get_permission('teacher_transfer', 'is_edit')): ?>
                                        <!-- Approve Modal Trigger -->
                                        <button class="btn btn-success btn-circle icon" data-toggle="modal" data-target="#approveModal<?=$row['id']?>" title="Approve"><i class="fas fa-check"></i></button>
                                        <!-- Reject Modal Trigger -->
                                        <button class="btn btn-danger btn-circle icon" data-toggle="modal" data-target="#rejectModal<?=$row['id']?>" title="Reject"><i class="fas fa-times"></i></button>

                                        <!-- Approve Modal -->
                                        <div id="approveModal<?=$row['id']?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <?php echo form_open('teacher_transfer/approve/'.$row['id']); ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Approve Transfer — <?=current(explode(' ', $row['staff_name']))?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-muted">Requested school: <strong><?=$row['to_branch']?></strong>. You may override the posting school below.</p>
                                                            <div class="form-group">
                                                                <label>Post To School <span class="required">*</span></label>
                                                                <select name="override_branch_id" class="form-control" data-plugin-selectTwo>
                                                                    <option value="">Use Teacher's Preferred School (<?=$row['to_branch']?>)</option>
                                                                    <?php foreach ($branch_list as $b): ?>
                                                                        <option value="<?=$b['id']?>"><?=$b['name']?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Confirm Approval</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Reject Modal -->
                                        <div id="rejectModal<?=$row['id']?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <?php echo form_open('teacher_transfer/reject/'.$row['id']); ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Reject Transfer Request</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Reason for Rejection <span class="required">*</span></label>
                                                                <textarea name="rejection_note" class="form-control" required rows="3" style="width: 100%;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <a href="<?=base_url('teacher_transfer/history/'.$row['staff_id'])?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" title="View History"><i class="fas fa-history"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // Wait briefly to ensure DataTables is initialized natively by the theme
    setTimeout(function() {
        var table = $('.table-export').DataTable();
        
        // Inject dropdown into Datatables header DOM
        var filterHtml = '<div style="display:inline-block; margin-left:15px; width:200px; vertical-align: middle;"><select id="transferStatusFilter" class="form-control" data-plugin-selectTwo data-minimum-results-for-search="Infinity"><option value="">Filter by Status (All)</option><option value="Pending">Pending</option><option value="Approved">Approved</option><option value="Rejected">Rejected</option></select></div>';
        
        if ($('.dt-buttons').length > 0) {
            $('.dt-buttons').after(filterHtml);
        } else {
            $('.dataTables_filter').before(filterHtml);
        }
        
        // Initialize select2
        if ($.isFunction($.fn.select2)) {
            $('#transferStatusFilter').select2({
                minimumResultsForSearch: Infinity,
                theme: "bootstrap"
            });
        }
        
        $('#transferStatusFilter').on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(5).search(val ? '^' + val + '$' : '', true, false).draw();
        });
    }, 500);
});
</script>
