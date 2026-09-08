<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-btn">
                    <a href="<?=base_url('school_inspection/add')?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Log Inspection">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <h4 class="panel-title"><i class="fas fa-search"></i> School Inspection Reports</h4>
            </header>
            <div class="panel-body">
                <div class="mb-md">
                    <table class="table table-bordered table-hover table-condensed mb-none table-export">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>School</th>
                                <th>Inspection Date</th>
                                <th>Inspector</th>
                                <th>Status</th>
                                <th>Overall Grade</th>
                                <th>Total Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $count = 1;
                            foreach ($reports as $row): 
                                $label_class = 'label-info';
                                if($row['overall_grade'] == 'Excellent') $label_class = 'label-success-custom';
                                if($row['overall_grade'] == 'Good') $label_class = 'label-primary';
                                if($row['overall_grade'] == 'Fair') $label_class = 'label-warning-custom';
                                if($row['overall_grade'] == 'Poor') $label_class = 'label-danger-custom';
                                
                                $status = $row['status'] ?? 'Completed';
                                $status_class = 'label-success-custom';
                                if ($status == 'Pending') $status_class = 'label-warning-custom';
                                if ($status == 'In Progress') $status_class = 'label-info';
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['branch_name']; ?></td>
                                <td><?php echo _d($row['inspection_date']); ?></td>
                                <td><?php echo $row['inspector_name']; ?></td>
                                <td><span class="label <?=$status_class?>"><?php echo $status; ?></span></td>
                                <td><span class="label <?=$label_class?>"><?php echo $row['overall_grade']; ?></span></td>
                                <td><?php echo $row['total_score']; ?>%</td>
                                <td>
                                    <?php if (get_permission('school_inspection', 'is_edit')): ?>
                                        <a href="<?=base_url('school_inspection/edit/'.$row['id'])?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="Edit Report"><i class="fas fa-pen-nib"></i></a>
                                    <?php endif; ?>
                                    <a href="<?=base_url('school_inspection/view/'.$row['id'])?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" title="View Report"><i class="fas fa-eye"></i></a>
                                    <?php if (get_permission('school_inspection', 'is_delete')): ?>
                                        <?php echo btn_delete('school_inspection/delete/' . $row['id']); ?>
                                    <?php endif; ?>
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
