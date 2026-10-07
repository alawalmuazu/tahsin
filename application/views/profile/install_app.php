<section class="panel">
	<div class="panel-body" style="padding: 32px 24px;">
		<div class="text-center">
			<i class="fas fa-mobile-alt" style="font-size: 42px; color: #0f5c4c;"></i>
			<h3 style="margin-top: 16px;">Install one app for each child</h3>
			<p class="text-muted" style="max-width: 520px; margin: 12px auto 24px;">
				A phone can keep a separate Tahsin icon for every child. Each icon has its own sign-in, so one child does not replace another.
			</p>
		</div>
		<?php
		$children = array();
		if (is_parent_loggedin()) {
			$this->db->select('s.id, s.first_name, s.last_name, s.register_no');
			$this->db->from('student s');
			$this->db->join('enroll e', 'e.student_id = s.id', 'inner');
			$this->db->where('s.parent_id', get_loggedin_user_id());
			$this->db->where('e.session_id', get_session_id());
			$this->db->group_by('s.id');
			$children = $this->db->get()->result();
		}
		?>
		<?php if (!empty($children)): ?>
			<div class="row">
				<?php foreach ($children as $child): ?>
					<?php $who = trim($child->first_name . ' ' . $child->last_name); ?>
					<div class="col-md-6" style="margin-bottom: 12px;">
						<div style="border: 1px solid #d5ddd9; padding: 14px 16px;">
							<strong><?php echo html_escape($who); ?></strong>
							<?php if ($child->register_no !== ''): ?>
								<div class="text-muted"><?php echo html_escape($child->register_no); ?></div>
							<?php endif; ?>
							<a class="btn btn-primary" style="margin-top: 10px;" href="<?php echo html_escape(student_app_url($child->id, 'install')); ?>">Install <?php echo html_escape($child->first_name); ?></a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="text-muted">If the phone says Tahsin is already installed, delete the icon that is not a child's name, then install each child again.</p>
		<?php else: ?>
			<p class="text-muted text-center">No child is enrolled for this session yet.</p>
		<?php endif; ?>
		<p class="text-center" style="margin-top: 18px;"><a href="<?php echo base_url('profile/pwa_done'); ?>">Continue to the portal</a></p>
	</div>
</section>
