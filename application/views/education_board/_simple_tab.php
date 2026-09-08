<?php
// Reusable partial for simple name-only board items
// Variables: $board, $table, $label, $placeholder, $items
?>
<div class="row">
	<div class="col-md-5">
		<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab='.$table), array('class' => 'form-horizontal validate')); ?>
			<input type="hidden" name="item_table" value="<?=$table?>">
			<div class="form-group">
				<div class="col-md-8">
					<input type="text" class="form-control" name="name" placeholder="<?=$placeholder?>" required />
				</div>
				<div class="col-md-4">
					<button type="submit" class="btn btn-default btn-block" name="submit" value="add_item">
						<i class="fas fa-plus"></i> Add
					</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
	<div class="col-md-7">
		<table class="table table-bordered table-condensed">
			<thead><tr><th width="50">#</th><th><?=$label?></th><th width="60">Action</th></tr></thead>
			<tbody>
				<?php $i=1; foreach($items as $item): ?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$item->name?></td>
					<td>
						<?php echo form_open(base_url('education_board/manage/'.$board->id.'?tab='.$table)); ?>
							<input type="hidden" name="item_table" value="<?=$table?>">
							<input type="hidden" name="item_id" value="<?=$item->id?>">
							<button type="submit" name="submit" value="delete_item" class="btn btn-danger btn-circle btn-xs" onclick="return confirm('Delete this item?')"><i class="fas fa-trash-alt"></i></button>
						<?php echo form_close(); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
