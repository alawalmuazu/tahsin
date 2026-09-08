<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-btn">
                    <a href="<?=base_url('teacher_transfer')?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Go Back">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <h4 class="panel-title"><i class="fas fa-history"></i> Posting History: <?=$staff['name']?></h4>
            </header>
            <div class="panel-body">
                <div class="timeline">
                    <?php if (empty($history)): ?>
                        <div class="alert alert-info">No posting history available for this staff.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date Posted</th>
                                        <th>School</th>
                                        <th>Date Left</th>
                                        <th>Reason/Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history as $h): ?>
                                    <tr>
                                        <td><?=_d($h['date_posted'])?></td>
                                        <td><?=$h['branch_name']?></td>
                                        <td><?=$h['date_left'] ? _d($h['date_left']) : '<span class="label label-success-custom">Current</span>'?></td>
                                        <td><?=$h['reason']?> (Logged by: <?=$h['posted_by_name']?>)</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</div>
