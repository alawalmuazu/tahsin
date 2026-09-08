<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-chart-bar"></i> NEMIS — National Education Management Information System</h4>
                <p class="text-muted mb-none" style="margin-top:4px">Government reporting portal for Kaduna State Schools. Select a report type below.</p>
            </header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default" style="border-top: 4px solid #1e88e5;">
                            <div class="panel-body text-center" style="padding: 30px 20px;">
                                <i class="fas fa-school fa-3x text-primary mb-sm" style="margin-bottom:12px; display:block;"></i>
                                <h5 class="font-bold">Annual School Census</h5>
                                <p class="text-muted small mb-sm">Total enrollment by school, LGA, gender &amp; education board — UBEC ASC format.</p>
                                <a href="<?=base_url('nemis/asc_report')?>" class="btn btn-primary btn-sm btn-block">
                                    <i class="fas fa-table"></i> View ASC Report
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default" style="border-top: 4px solid #43a047;">
                            <div class="panel-body text-center" style="padding: 30px 20px;">
                                <i class="fas fa-chalkboard-teacher fa-3x text-success mb-sm" style="margin-bottom:12px; display:block;"></i>
                                <h5 class="font-bold">UBEC Compliance</h5>
                                <p class="text-muted small mb-sm">Teacher-to-student ratio per school — Universal Basic Education Commission format.</p>
                                <a href="<?=base_url('nemis/ubec_report')?>" class="btn btn-success btn-sm btn-block">
                                    <i class="fas fa-table"></i> View UBEC Report
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default" style="border-top: 4px solid #e53935;">
                            <div class="panel-body text-center" style="padding: 30px 20px;">
                                <i class="fas fa-id-card fa-3x text-danger mb-sm" style="margin-bottom:12px; display:block;"></i>
                                <h5 class="font-bold">WAEC / NECO Candidates</h5>
                                <p class="text-muted small mb-sm">Candidate list with NIN, State Student ID &amp; DOB — ready for exam registration export.</p>
                                <a href="<?=base_url('nemis/waec_candidates')?>" class="btn btn-danger btn-sm btn-block">
                                    <i class="fas fa-table"></i> View Candidate List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
