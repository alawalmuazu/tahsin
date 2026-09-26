<?php 
$frontendEnableChat = '';
$backendEnableChat = '';
if (!empty($whatsapp['frontend_enable_chat']) && $whatsapp['frontend_enable_chat'] == 1) {
	$frontendEnableChat = "checked";
}
if (!empty($whatsapp['backend_enable_chat']) && $whatsapp['backend_enable_chat'] == 1) {
	$backendEnableChat = "checked";
}
?>
<div class="row">
    <div class="col-md-3">
        <?php include 'sidebar.php'; ?>
    </div>
    <div class="col-md-9">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fab fa-whatsapp"></i> <?=translate('whatsapp_settings') ?></h4>
            </header>
            <?php echo form_open_multipart('school_settings/saveWhatsappConfig' . $url, array('class' => 'frm-submit-data')); ?>
                <div class="panel-body">
					<div class="form-group mt-md">
						<label class="col-md-3 control-label"><?=translate('header_title')?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="header_title" value="<?=$whatsapp['header_title'] ?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('subtitle')?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="subtitle" value="<?=$whatsapp['subtitle']?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('footer_text')?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="footer_text" value="<?=$whatsapp['footer_text'] ?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('frontend_enable_chat')?></label>
						<div class="col-md-6 mb-md">
	                        <div class="material-switch mt-xs">
	                            <input class="switch_menu" id="frontend_enable_chat" name="frontend_enable_chat" type="checkbox" <?php echo $frontendEnableChat ?> />
	                            <label for="frontend_enable_chat" class="label-primary"></label>
	                        </div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('backend_enable_chat')?></label>
						<div class="col-md-6 mb-md">
	                        <div class="material-switch mt-xs">
	                            <input class="switch_menu" id="backend_enable_chat" name="backend_enable_chat" type="checkbox" <?php echo $backendEnableChat ?> />
	                            <label for="backend_enable_chat" class="label-primary"></label>
	                        </div>
						</div>
					</div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-2 col-sm-offset-3">
                            <button type="submit" class="btn btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                                <i class="fas fa-plus-circle"></i> <?=translate('save');?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <?php
        $cloud = isset($whatsapp_cloud) && is_array($whatsapp_cloud) ? $whatsapp_cloud : array();
        $cloudEnabled = !empty($cloud['enabled']) ? 'checked' : '';
        $cloudMedia = !isset($cloud['send_media_after_template']) || !empty($cloud['send_media_after_template']) ? 'checked' : '';
        $urlCloud = '';
        if ($this->input->get('branch_id')) {
            $urlCloud = '?branch_id=' . $this->input->get('branch_id', true);
        }
        ?>
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fab fa-whatsapp"></i> WhatsApp Business Cloud API</h4>
            </header>
            <?php if (!$this->db->table_exists('whatsapp_cloud_config')): ?>
            <div class="panel-body">
                <div class="alert alert-warning mb-none">
                    Run <code>application/migrations/whatsapp_cloud_config.sql</code> in phpMyAdmin, then reload this page.
                </div>
            </div>
            <?php else: ?>
            <?php echo form_open('school_settings/saveWhatsappCloudConfig' . $urlCloud, array('class' => 'frm-submit-msg form-horizontal form-bordered')); ?>
                <div class="panel-body">
                    <p class="text-muted" style="margin:0 0 1rem">
                        Used by <strong>Academy → Broadcast</strong> to push parent digests (and optional audio/video).
                        Create an approved Meta template whose body variables are: student name, date, summary, media URL.
                    </p>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Enable Cloud API</label>
                        <div class="col-md-6">
                            <div class="material-switch mt-xs">
                                <input class="switch_menu" id="cloud_enabled" name="cloud_enabled" type="checkbox" <?php echo $cloudEnabled; ?> />
                                <label for="cloud_enabled" class="label-primary"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Access token</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="access_token" value="" autocomplete="new-password"
                                placeholder="<?php echo !empty($cloud['has_token']) ? 'Token saved — leave blank to keep' : 'Paste Meta permanent / system user token'; ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Phone number ID <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="phone_number_id" value="<?php echo html_escape(isset($cloud['phone_number_id']) ? $cloud['phone_number_id'] : ''); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">WABA ID</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="waba_id" value="<?php echo html_escape(isset($cloud['waba_id']) ? $cloud['waba_id'] : ''); ?>" placeholder="Optional" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">API version</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="api_version" value="<?php echo html_escape(isset($cloud['api_version']) ? $cloud['api_version'] : 'v21.0'); ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Template name <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="template_name" value="<?php echo html_escape(isset($cloud['template_name']) ? $cloud['template_name'] : 'tahsin_sealed_digest'); ?>" />
                            <span class="help-block mb-none">Prefer <code>tahsin_daily_digest</code> / <code>en</code> when you want a tap-able listen URL in {{4}}. <code>tahsin_sealed_digest</code> says “audio in the next message,” but Meta only delivers free-form audio inside a 24h window after the parent messages you — so that follow-up never arrives on cold sends. Put the public HTTPS clip URL in {{4}}, and keep files under <code>uploads/academy_tahfiz/</code> on Hostinger.</span>
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Template language <span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="template_lang" value="<?php echo html_escape(isset($cloud['template_lang']) ? $cloud['template_lang'] : 'en'); ?>" />
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Attach media after digest</label>
                        <div class="col-md-6">
                            <div class="material-switch mt-xs">
                                <input class="switch_menu" id="send_media_after_template" name="send_media_after_template" type="checkbox" <?php echo $cloudMedia; ?> />
                                <label for="send_media_after_template" class="label-primary"></label>
                            </div>
                            <p class="help-block mb-none">Puts a public HTTPS listen URL into template {{4}}. Free-form audio after a utility template is accepted by Meta then dropped unless the parent already messaged you (24h window).</p>
                        </div>
                    </div>
                    <div class="form-group mb-md">
                        <label class="col-md-3 control-label">Max media per student</label>
                        <div class="col-md-6">
                            <input type="number" min="1" max="10" class="form-control" name="media_max_per_student"
                                value="<?php echo (int) (isset($cloud['media_max_per_student']) ? $cloud['media_max_per_student'] : 3); ?>" />
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-2 col-sm-offset-3">
                            <button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
                                <i class="fas fa-plus-circle"></i> <?=translate('save');?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
            <?php endif; ?>
        </section>

        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-users"></i> <?=translate('whatsapp_agent') ?></h4>
            <?php if (get_permission('whatsapp_config', 'is_add')) { ?>
				<div class="panel-btn">
					<button class="btn btn-default btn-circle" onclick="mfp_modal('#modal')"><i class="far fa-edit"></i> <?=translate('add') . " " . translate('agent')?></button>
				</div>
			<?php } ?>
            </header>
            <div class="panel-body">
				<div class="table-responsive">
				    <table class="table table-bordered nowrap table-hover table-condensed mb-none">
				        <thead>
				            <tr>
				                <th width="50"><?=translate('sl')?></th>
				                <th><?=translate('photo')?></th>
				                <th><?=translate('name')?></th>
				                <th><?=translate('designation')?></th>
				                <th><?=translate('whataspp_number')?></th>
				                <th><?=translate('start_time')?></th>
				                <th><?=translate('end_time')?></th>
				                <th><?=translate('weekend')?></th>
				                <th><?=translate('action')?></th>
				            </tr>
				        </thead>
				        <tbody>
				            <?php 
				                $count = 1;
				                $this->db->where('branch_id', $branch_id);
				                $branchs = $this->db->get('whatsapp_agent')->result();
				                if (!empty($branchs)) {
				               		foreach($branchs as $row) {
				            ?>
				            <tr>
				                <td><?php echo $count++; ?></td>
				                <td><img src="<?php echo get_image_url('whatsapp_agent', $row->agent_image); ?>" height="50"></td>
				                <td><?php echo $row->agent_name;?></td>
				                <td><?php echo $row->agent_designation;?></td>
				                <td><?php echo $row->whataspp_number;?></td>
				                <td><?php echo date("h:i A", strtotime($row->start_time));?></td>
				                <td><?php echo date("h:i A", strtotime($row->end_time));?></td>
				                <td><?php echo $row->weekend == 0 ? translate('all_days') : ucfirst($row->weekend);?></td>
								<td>
								<?php if (get_permission('whatsapp_config', 'is_edit')): ?>
									<!-- update link -->
									<a class="btn btn-default btn-circle icon" href="javascript:void(0);" onclick="ajaxModal('<?php echo base_url('school_settings/getWhatsappDetails/' . $row->id) ?>')">
										<i class="fas fa-pen-nib"></i>
									</a>
								<?php endif; if (get_permission('whatsapp_config', 'is_delete')): ?>
									<!-- delete link -->
									<?php echo btn_delete('school_settings/whatsappAgent_delete/' . $row->id); ?>
								<?php endif; ?>
								</td>
				            </tr>
				            <?php } } else {
				            	echo '<tr><td colspan="9"><h5 class="text-danger text-center">' . translate('no_information_available') . '</td></tr>';
				            } ?>
				        </tbody>
				    </table>
				</div>
            </div>
        </section> 
    </div>
</div>

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="modal">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title">
				<i class="far fa-edit"></i> <?php echo translate('add') . " " . translate('agent'); ?>
			</h4>
		</header>
		<?php echo form_open_multipart('school_settings/saveWhatsappAgent' . $url, array('class' => 'frm-submit-data')); ?>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label"><?php echo translate('name'); ?> <span class="required">*</span></label>
					<input type="text" name="name" class="form-control" value="" autocomplete="off" />
					<span class="error"></span>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo translate('designation'); ?> <span class="required">*</span></label>
					<input type="text" class="form-control" value="" autocomplete="off" name="designation"/>
					<span class="error"></span>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo translate('whataspp_number'); ?> <span class="required">*</span></label>
					<input type="text" class="form-control" value="" placeholder="Enter your WhatsApp number with country code." autocomplete="off" name="whataspp_number"/>
					<span class="error"></span>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo translate('time_slot'); ?> <span class="required">*</span></label>
					<div class="row">
						<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-clock"></i></span>
								<input type="text" name="start_time" data-plugin-timepicker class="form-control" value="" />
							</div>
						</div>
						<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-clock"></i></span>
								<input type="text" name="end_time" data-plugin-timepicker class="form-control" value="" />
							</div>
						</div>
					</div>
					<span class="error"></span>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo translate('weekend'); ?> <span class="required">*</span></label>
					<?php
						$arrayDay = array(
							"0" => translate('no'),
							"sunday" => "Sunday",
							"monday" => "Monday",
							"tuesday" => "Tuesday",
							"wednesday" => "Wednesday",
							"thursday" => "Thursday",
							"friday" => "Friday",
							"saturday" => "Saturday"
						);
						echo form_dropdown("weekend", $arrayDay, "", "class='form-control' required
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
					?>
					<span class="error"></span>
				</div>
				<div class="form-group">
					<label for="input-file-now"><?=translate('photo')?></label>
					<input type="file" name="user_photo" class="dropify" />
					<span class="error"><?=form_error('user_photo')?></span>
				</div>
				<div class="form-group ml-xs mb-lg">
					<label class="control-label"><?=translate('active')?></label>
                    <div class="material-switch mt-xs">
                        <input class="switch_menu" id="agent_active" name="agent_active" type="checkbox" checked />
                        <label for="agent_active" class="label-primary"></label>
                    </div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="submit" class="btn btn-default mr-xs" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-plus-circle"></i> <?php echo translate('save'); ?>
						</button>
						<button class="btn btn-default modal-dismiss"><?php echo translate('cancel'); ?></button>
					</div>
				</div>
			</footer>
		<?php echo form_close(); ?>
	</section>
</div>

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="editModal">
	<section class="panel" id='quick_view'></section>
</div>