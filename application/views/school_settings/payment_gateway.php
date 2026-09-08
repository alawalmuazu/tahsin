<div class="row">
	<div class="col-md-3">
        <?php include 'sidebar.php'; ?>
    </div>
	<div class="col-md-7">
		<section class="panel">
			<div class="tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#paystack" data-toggle="tab">Paystack</a>
					</li>
					<li>
						<a href="#flutterwave" data-toggle="tab">Flutter Wave</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane box active" id="paystack">
						<?php echo form_open('settings/paystack_save', array('class' => 'form-horizontal frm-submit-msg'));?>
							<input type="hidden" name="branch_id" value="<?=$branch_id?>">
							<div class="form-group">
								<label  class="col-sm-3 control-label">Paystack Secret Key</label>
								<div class="col-md-6 mb-md">
									<input type="text" class="form-control" name="paystack_secret_key" value="<?=$config['paystack_secret_key']?>">
									<span class="error"></span>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-3 col-sm-offset-3">
										<button type="submit" class="btn btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
											<i class="fas fa-plus-circle"></i> <?=translate('save');?>
										</button>
									</div>
								</div>
							</footer>
						<?php echo form_close();?>
					</div>

					<div class="tab-pane box" id="flutterwave">
						<?php echo form_open('settings/flutterwave_save', array('class' => 'form-horizontal frm-submit-msg'));?>
							<input type="hidden" name="branch_id" value="<?=$branch_id?>">
							<div class="form-group">
							  <label  class="col-sm-3 control-label">Public Key</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="flutterwave_public_key" value="<?=$config['flutterwave_public_key']?>">
									<span class="error"></span>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-3 control-label">Secret Key</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="flutterwave_secret_key" value="<?=$config['flutterwave_secret_key']?>">
									<span class="error"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-6 mb-md">
									<div class="checkbox-replace">
										<label class="i-checks">
											<input type="checkbox" name="flutterwave_sandbox" id="flutterwave_sandbox" <?=($config['flutterwave_sandbox'] == 1 ? 'checked' : ''); ?>>
											<i></i> Flutterwave Sandbox
										</label>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-3 col-sm-offset-3">
										<button type="submit" class="btn btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
											<i class="fas fa-plus-circle"></i> <?=translate('save');?>
										</button>
									</div>
								</div>
							</footer>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="col-md-2">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-credit-card"></i> Active Gateway</h4>
			</header>
			<?php echo form_open('settings/payment_active', array('class' => 'form-horizontal frm-submit-msg')); ?>
			<input type="hidden" name="branch_id" value="<?=$branch_id?>">
			<div class="panel-body mt-sm">
				<div class="form-group">
					<div class="col-md-12">
						<div class="checkbox-replace">
							<label class="i-checks">
								<input type="checkbox" name="paystack_status" id="paystack_status" <?=($config['paystack_status'] == 1 ? 'checked' : ''); ?>>
								<i></i> Paystack
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<div class="checkbox-replace">
							<label class="i-checks">
								<input type="checkbox" name="flutterwave" id="flutterwave_active" <?=($config['flutterwave_status'] == 1 ? 'checked' : ''); ?>>
								<i></i> Flutter Wave
							</label>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer mt-sm">
				<button type="submit" class="btn btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
					<?=translate('save')?>
				</button>
			</footer>
			<?php echo form_close();?>
		</section>
	</div>
</div>
