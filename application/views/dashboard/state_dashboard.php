<?php
$this->load->helper('general');
?>
<div class="dashboard-page">
    <!-- Header Title -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-primary mt-none mb-md">Kaduna State Education Board Analytics</h2>
        </div>
    </div>
    
	<div class="row widget-1">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="panel">
				<div class="row widget-row-in">
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="widget-col-in row">
								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-school"></i>
									<h5>Schools</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h3 class="counter text-right mt-md text-primary"><?= $total_schools ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-uppercase">Active Branches</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="panel-body">
							<div class="widget-col-in row">
								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-user-graduate"></i>
									<h5>Students</h5> </div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h3 class="counter text-right mt-md text-primary"><?= $total_students ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
											<span class="text-uppercase">Total Enrolled</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="widget-col-in row">
								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-chalkboard-teacher" ></i>
									<h5>Teachers</h5></div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h3 class="counter text-right mt-md text-primary"><?= $total_teachers ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-uppercase">Deployed Statewide</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="widget-col-in row">
								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-users" ></i>
									<h5>Parents</h5></div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h3 class="counter text-right mt-md text-primary"><?= $total_parents ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-uppercase">Registered Parents</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Analytics Charts -->
	<div class="row">
		<div class="col-md-6">
			<section class="panel pg-fw">
				<div class="panel-body">
					<h4 class="chart-title mb-xs">Statewide Enrollment Expected Demographic</h4>
					<div id="gender_demographic" style="height: 350px; width: 100%;"></div>
					<div class="round-overlap"><i class="fas fa-mars-double"></i></div>
				</div>
			</section>
		</div>

		<div class="col-md-6">
			<section class="panel pg-fw">
				<div class="panel-body">
					<h4 class="chart-title mb-xs">Active Schools Distribution by Board</h4>
					<div id="board_distribution" style="height: 350px; width: 100%;"></div>
					<div class="round-overlap"><i class="fas fa-landmark"></i></div>
				</div>
			</section>
		</div>
	</div>

	<!-- Staff Gaps Widget -->
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<h4 class="panel-title"><i class="fas fa-users-cog"></i> Staff Gaps by School</h4>
				</header>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover mt-sm">
							<thead>
								<tr>
									<th>School Name</th>
									<th>LGA</th>
									<th>Enrolled Students</th>
									<th>Current Staff</th>
									<th>Student/Teacher Ratio</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($staff_gaps as $gap): 
									$ratio = $gap->total_staff > 0 ? round($gap->enrolled_students / $gap->total_staff) : $gap->enrolled_students;
									$ratio_text = $ratio . ' : 1';
									
									$status_class = 'success';
									$status_text = 'Optimal';
									
									if ($gap->total_staff < 3) {
										$status_class = 'danger';
										$status_text = 'Critical Shortage';
									} elseif ($ratio > 35) {
										$status_class = 'warning';
										$status_text = 'Over capacity';
									}
								?>
								<tr>
									<td><?=$gap->school_name?></td>
									<td><?=$gap->lga?></td>
									<td><?=$gap->enrolled_students?></td>
									<td>
										<?php if($gap->total_staff < 3): ?>
											<span class="text-danger"><strong><?=$gap->total_staff?></strong></span>
										<?php else: ?>
											<?=$gap->total_staff?>
										<?php endif; ?>
									</td>
									<td><?=$ratio_text?></td>
									<td><span class="label label-<?=$status_class?>-custom"><?=$status_text?></span></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<script type="application/javascript">
window.addEventListener('load', function() {
(function($) {
    <?php
    $gender_colors = "['#009efb', '#d81b60']";
    $genders_data = array();
    foreach($gender_stats as $g) {
        $genders_data[] = ['name' => ucfirst($g->gender), 'value' => $g->count];
    }
    
    $board_colors = "['#546570', '#c23531', '#91c7ae']";
    $boards_data = array();
    foreach($board_stats as $b) {
        $name = empty($b->board_name) ? 'Unassigned / Local' : $b->board_name;
        $boards_data[] = ['name' => $name, 'value' => $b->branch_count];
    }
    ?>

	var gender_chart = echarts.init(document.getElementById("gender_demographic"));
	gender_chart.setOption({
		tooltip: {
			trigger: 'item',
			formatter: "{b} : {c} ({d}%)"
		}, 
		legend: {
			show: true,
			position: 'bottom'
		},
		color: <?= $gender_colors ?>,
		series: [{
			name: 'Gender',
			type: 'pie',
			radius: ['50%', '80%'],
			label: {
				show: true,
				formatter: '{b}: {c} ({d}%)'
			},
			labelLine: {
				show: true
			},
			data: <?= json_encode($genders_data) ?>
		}]
	});

	var board_chart = echarts.init(document.getElementById("board_distribution"));
	board_chart.setOption({
		tooltip: {
			trigger: 'item',
			formatter: "{b} : {c} Schools"
		}, 
		legend: {
			show: true,
			position: 'bottom'
		},
		color: <?= $board_colors ?>,
		series: [{
			name: 'Board',
			type: 'pie',
			radius: '70%',
			label: {
				show: true,
				formatter: '{b}: {c} Schools'
			},
			labelLine: {
				show: true
			},
			data: <?= json_encode($boards_data) ?>
		}]
	});

	$(window).on("resize", function() {
		setTimeout(function () {
			gender_chart.resize();
			board_chart.resize();
		}, 350);
	});
})(jQuery);
});
</script>
