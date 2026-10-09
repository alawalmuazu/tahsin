<?php
$currency_symbol = $global_config['currency_symbol'];
$extINTL = extension_loaded('intl');
if ($extINTL == true) {
	$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
}
?>
<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#invoice" data-toggle="tab"><i class="far fa-credit-card"></i> <?=translate('invoice')?></a>
			</li>
<?php if ($invoice['status'] != 'unpaid'): ?>
			<li>
				<a href="#history" data-toggle="tab"><i class="fas fa-dollar-sign"></i> <?=translate('payment_history')?></a>
			</li>
<?php endif; ?>
<?php if (get_permission('collect_fees', 'is_add') && $invoice['status'] != 'total'): ?>
			<li>
				<a href="#collect_fees" data-toggle="tab"><i class="fas fa-hand-holding-usd"></i> <?=translate('collect_fees')?></a>
			</li>
<?php endif; ?>
<?php if (get_permission('collect_fees', 'is_add') && $invoice['status'] != 'total'): ?>
			<li>
				<a href="#fully_paid" data-toggle="tab"><i class="far fa-credit-card"></i> Fully Paid</a>
			</li>
<?php endif; ?>
		</ul>
		<div class="tab-content">
			<div id="invoice" class="tab-pane <?=empty($this->session->flashdata('pay_tab')) ? 'active' : ''; ?>">
				<div id="invoice_print" class="fee-sheet-page">
<?php
$fee_sheet_interactive = true;
include APPPATH . 'views/fees/_invoice_sheet.php';
?>
						<div class="text-right hidden-print" style="max-width:190mm;margin:12px auto 0;">
							<?php if ($invoice['status'] != 'unpaid'): ?>
							<button type="button" id="feeShareOpen" class="btn btn-default btn-slip ml-sm"><i class="fab fa-whatsapp" style="color:#25D366;"></i> WhatsApp parent<?php if (!empty($parent_phones[0])): ?> (<?php echo html_escape($parent_phones[0]); ?>)<?php endif; ?></button>
							<?php endif; ?>
							<button id="invoicePrint" class="btn btn-default btn-slip ml-sm" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing"><i class="fas fa-print"></i> <?=translate('print')?></button>
						</div>
					</div>
				</div>
			<?php if ($invoice['status'] != 'unpaid'): ?>
			<div id="history" class="tab-pane">
				<div id="payment_print" class="fee-sheet">
<?php
$fee_sheet_css_only = true;
include APPPATH . 'views/fees/_invoice_sheet.php';
$fee_sheet_css_only = false;
?>
					<div>
					<table class="hdr">
						<tr>
							<td style="width:80px"><img class="logo" src="<?=base_url('uploads/app_image/printing-logo.png')?>" alt="Logo"></td>
							<td>
								<p class="school-name"><?=html_escape(!empty($basic['school_name']) ? $basic['school_name'] : SCHOOL_NAME)?></p>
								<?php if (defined('SCHOOL_MOTTO') && SCHOOL_MOTTO !== ''): ?><p class="motto"><?=html_escape(SCHOOL_MOTTO)?></p><?php endif; ?>
								<div class="contact">
									<?php if (!empty($basic['school_address'])) echo html_escape($basic['school_address']) . ' · '; ?>
									<?php if (!empty($basic['school_mobileno'])) echo html_escape($basic['school_mobileno']) . ' · '; ?>
									<?=html_escape($basic['school_email'])?>
								</div>
							</td>
						</tr>
					</table>
					<div class="doc-title">
						<h1>Payment History</h1>
						<p>Invoice No #<?=html_escape($invoice['invoice_no'])?> · Issued <?=_d(date('Y-m-d'))?></p>
					</div>
					<div class="section-h">Payments</div>
<?php if (get_permission('fees_revert', 'is_delete')): ?>
						<button type="button" class="btn btn-default btn-sm mb-sm hidden-print" id="selected_revert" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-trash-restore-alt"></i> <?php echo translate('selected_revert'); ?>
						</button>
					<?php endif; ?>
						<div class="table-responsive">
							<table class="table invoice-items" id="paymentHistory">
								<thead>
									<tr class="h5 text-dark">
										<th id="cell-count" class="text-weight-semibold hidden-print">
											<div class="checkbox-replace" >
												<label class="i-checks" data-toggle="tooltip" data-original-title="Print Show / Hidden">
													<input type="checkbox" class="fee-selectAll" checked> <i></i>
												</label>
											</div>
										</th>
										<th id="cell-item" class="text-weight-semibold"><?=translate('fees_type')?></th>
										<th id="cell-item" class="text-weight-semibold"><?=translate('fees_code')?></th>
										<th id="cell-item" class="text-weight-semibold"><?=translate('date')?></th>
										<th id="cell-item" class="text-weight-semibold">Payment Id</th>
										<th id="cell-item" class="text-weight-semibold hidden-print"><?=translate('collect_by')?></th>
										<th id="cell-desc" class="text-weight-semibold"><?=translate('remarks')?></th>
										<th id="cell-qty" class="text-weight-semibold"><?=translate('method')?></th>
										<th id="cell-price" class="text-weight-semibold"><?=translate('amount')?></th>
										<th id="cell-price" class="text-weight-semibold"><?=translate('discount')?></th>
										<th id="cell-price" class="text-weight-semibold"><?=translate('fine')?></th>
										<th id="cell-price" class="text-weight-semibold"><?=translate('paid')?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$allocations = $this->db->where(array('student_id' => $basic['enroll_id'], 'session_id' => get_session_id()))->get('fee_allocation')->result_array();
									foreach ($allocations as $allRow) {
										$historys = $this->fees_model->getPaymentHistory($allRow['id'], $allRow['group_id']);
										foreach ($historys as $row) {
									?>
									<tr>
										<td class="hidden-print checked-area">
											<div class="checkbox-replace">
												<label class="i-checks"><input type="checkbox" name="cb_feePay" value="<?php echo $row['id']; ?>" checked><i></i></label>
											</div>
										</td>
										<td class="text-weight-semibold text-dark"><?php echo $row['name']; ?></td>
										<td><?php echo $row['fee_code']; ?></td>
										<td><?php echo _d($row['date']); ?></td>
										<td><?php echo $row['id']; ?></td>
										<td class="hidden-print">
											<?php
												if ($row['collect_by'] == 'online') {
													echo translate('online');
												}else{
													echo get_type_name_by_id('staff', $row['collect_by']);
												}
											?>
										</td>
										<td><?php echo $row['remarks']; ?></td>
										<td><?php echo $row['payvia']; ?></td>
										<td><?php echo currencyFormat($row['amount'] + $row['discount']); ?></td>
										<td><?php echo currencyFormat($row['discount']); ?></td>
										<td><?php echo currencyFormat($row['fine']); ?></td>
										<td><?php echo currencyFormat($row['amount']); ?></td>
									</tr>
									 <?php } } 
if (moduleIsEnabled('transport')) {
									$this->db->select('transport_fee_details.id,transport_fee_fine.month');
									$this->db->from('transport_fee_details');
									$this->db->join('transport_fee_fine', 'transport_fee_fine.id = transport_fee_details.transport_fee_fine_id', 'inner');
									$this->db->where('transport_fee_details.enroll_id', $basic['enroll_id']);
									$this->db->order_by('transport_fee_details.id', 'asc');
									$transport_fee_details =  $this->db->get()->result();
									foreach ($transport_fee_details as $trans) {
										$month = $this->app_lib->getMonthslist($trans->month);
										$historys = $this->fees_model->getTransportPaymentHistory($trans->id);
										foreach ($historys as $row) {
									?>
									<tr>
										<td class="hidden-print checked-area">
											<div class="checkbox-replace">
												<label class="i-checks"><input type="checkbox" name="cb_feePay" value="<?php echo $row['id']; ?>" checked><i></i></label>
											</div>
										</td>
										<td class="text-weight-semibold text-dark"><?php echo translate('transport_fees') ?></td>
										<td><?php echo strtolower($month); ?></td>
										<td><?php echo _d($row['date']); ?></td>
										<td><?php echo $row['id']; ?></td>
										<td class="hidden-print">
											<?php
												if ($row['collect_by'] == 'online') {
													echo translate('online');
												}else{
													echo get_type_name_by_id('staff', $row['collect_by']);
												}
											?>
										</td>
										<td><?php echo $row['remarks']; ?></td>
										<td><?php echo $row['payvia']; ?></td>
										<td><?php echo currencyFormat($row['amount'] + $row['discount']); ?></td>
										<td><?php echo currencyFormat($row['discount']); ?></td>
										<td><?php echo currencyFormat($row['fine']); ?></td>
										<td><?php echo currencyFormat($row['amount']); ?></td>
									</tr>
									 <?php } } ?>
<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="section-h hidden-print">Summary</div>
						<table class="pay-box hidden-print">
							<tr>
								<th><?=translate('sub_total')?></th>
								<td><?=currencyFormat($total_paid + $total_discount); ?></td>
								<th><?=translate('discount')?></th>
								<td><?=currencyFormat($total_discount); ?></td>
							</tr>
							<tr>
								<th><?=translate('paid')?></th>
								<td><?=currencyFormat($total_paid); ?></td>
								<th><?=translate('fine')?></th>
								<td><?=currencyFormat($total_fine); ?></td>
							</tr>
							<tr>
								<th><?=translate('total_paid')?> (<?=translate('with_fine')?>)</th>
								<td colspan="3" class="slip-ok">
									<?php
									$grand_paid = number_format($total_paid + $total_fine, 2, '.', '');
									echo currencyFormat($total_paid + $total_fine);
									if ($extINTL == true) {
										echo ' (' . html_escape(ucwords($spellout->format($grand_paid))) . ')';
									}
									?>
								</td>
							</tr>
						</table>
						<div class="invoice-summary text-right mt-lg visible-print-block" id="invPaymentHistory"></div>
					</div>
					<div class="text-right mr-lg hidden-print">
						<button type="button" id="feeShareHistory" class="btn btn-default btn-slip mr-xs"><i class="fab fa-whatsapp"></i> WhatsApp selected</button>
						<button id="payReceiptPrint" class="btn btn-default mr-xs" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing"><i class="fas fa-print"></i> Selected Pay Receipt</button>
						<button id="paymentPrint" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing"><i class="fas fa-print"></i> <?=translate('print')?></button>
					</div>
				</div>
			</div>
			<?php endif; ?>
			
			<!-- add fees form -->
			<?php if($invoice['status'] != 'total'): ?>
				<div id="collect_fees" class="tab-pane">
					<?php echo form_open('fees/fee_add', array('class' => 'form-horizontal frm-submit' )); ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('fees_type')?> <span class="required">*</span></label>
							<div class="col-md-6">
							<?php
								echo form_dropdown("fees_type", $typeData, set_value('fees_type'), "class='form-control' id='fees_type'
								data-plugin-selectTwo data-width='100%' ");
							?>
							<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('date')?> <span class="required">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" data-plugin-datepicker
								data-plugin-options='{"todayHighlight" : true, "endDate": "today"}' name="date" value="<?=date('Y-m-d')?>" autocomplete="off" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('amount')?> <span class="required">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="amount" id="feeAmount" value="" autocomplete="off" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('discount')?></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="discount_amount" value="0" autocomplete="off" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('fine')?></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="fine_amount" id="fineAmount" value="0" autocomplete="off" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('payment_method')?> <span class="required">*</span></label>
							<div class="col-md-6">
	    						<?php
	    							echo payment_method_dropdown("pay_via", set_value('pay_via', DEFAULT_PAY_VIA), "class='form-control' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
	    						?>
								<span class="error"></span>
								<small class="help-block"><?=collection_account_hint()?></small>
							</div>
						</div>
                        <?php
                        $links = $this->fees_model->get('transactions_links', array('branch_id' => $basic['branch_id']), true);
                        if ($links['status'] == 1) {
                        ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo translate('account'); ?> <span class="required">*</span></label>
                               	<div class="col-md-6">
                                <?php
                                    $accounts_list = $this->app_lib->getSelectByBranch('accounts', $basic['branch_id']);
                                    echo form_dropdown("account_id", $accounts_list, $links['deposit'], "class='form-control' id='account_id' required data-plugin-selectTwo data-width='100%'");
                                ?>
                            	<span class="help-block">Office Accounting ledger this payment is posted to. Payment method above is how the parent paid.</span>
                            	</div>
                            </div>
                        <?php } ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('remarks')?></label>
							<div class="col-md-6 mb-md">
								<textarea name="remarks" rows="2" class="form-control" placeholder="<?=translate('write_your_remarks')?>"></textarea>
								<div class="checkbox-replace mt-lg">
									<label class="i-checks">
										<input type="checkbox" name="guardian_sms" checked> <i></i> Guardian Confirmation Sms
									</label>
								</div>
							</div>
						</div>
						<input type="hidden" name="enroll_id" value="<?php echo $basic['enroll_id']; ?>">
						<input type="hidden" name="branch_id" value="<?=$basic['branch_id']?>">
						<input type="hidden" name="student_id" value="<?=$basic['id']?>">
						<footer class="panel-footer">
							<div class="row">
								<div class="col-md-offset-3 col-md-3">
									<button type="submit" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
										<?=translate('fee_payment')?>
									</button>
								</div>
							</div>
						</footer>
					<?php echo form_close();?>
				</div>
			<?php endif; ?>
			<!--fully paid form-->
			<?php if($invoice['status'] != 'total'): ?>
				<div id="fully_paid" class="tab-pane">
					<?php echo form_open('fees/fee_fully_paid', array('class' => 'form-horizontal frm-submit' )); ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('date')?> <span class="required">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" data-plugin-datepicker
								data-plugin-options='{"todayHighlight" : true, "endDate":"today"}' name="date" value="<?=date('Y-m-d')?>" autocomplete="off" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('amount')?> <span class="required">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="amount" id="feeAmount" value="<?=number_format($total_balance, 2, '.', '')?>" autocomplete="off" disabled />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('fine')?></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="fine_amount" id="fineAmount" value="<?=number_format($fully_total_fine, 2, '.', '')?>" autocomplete="off" disabled />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('payment_method')?> <span class="required">*</span></label>
							<div class="col-md-6">
	    						<?php
	    							echo payment_method_dropdown("pay_via", set_value('pay_via', DEFAULT_PAY_VIA), "class='form-control' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
	    						?>
								<span class="error"></span>
								<small class="help-block"><?=collection_account_hint()?></small>
							</div>
						</div>
                        <?php
                        $links = $this->fees_model->get('transactions_links', array('branch_id' => $basic['branch_id']), true);
                        if ($links['status'] == 1) {
                        ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo translate('account'); ?> <span class="required">*</span></label>
                               	<div class="col-md-6">
                                <?php
                                    $accounts_list = $this->app_lib->getSelectByBranch('accounts', $basic['branch_id']);
                                    echo form_dropdown("account_id", $accounts_list, $links['deposit'], "class='form-control' id='account_id' required data-plugin-selectTwo data-width='100%'");
                                ?>
                            	<span class="help-block">Office Accounting ledger this payment is posted to. Payment method above is how the parent paid.</span>
                            	</div>
                            </div>
                        <?php } ?>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=translate('remarks')?></label>
							<div class="col-md-6 mb-md">
								<textarea name="remarks" rows="2" class="form-control" placeholder="<?=translate('write_your_remarks')?>"></textarea>
								<div class="checkbox-replace mt-lg">
									<label class="i-checks">
										<input type="checkbox" name="guardian_sms" checked> <i></i> Guardian Confirmation Sms
									</label>
								</div>
							</div>
						</div>
						<input type="hidden" name="invoice_id" value="<?php echo $basic['enroll_id']; ?>">
						<input type="hidden" name="branch_id" value="<?=$basic['branch_id']?>">
						<input type="hidden" name="student_id" value="<?=$basic['id']?>">
						<footer class="panel-footer">
							<div class="row">
								<div class="col-md-offset-3 col-md-3">
									<button type="submit" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
										<?=translate('fee_payment')?>
									</button>
								</div>
							</div>
						</footer>
					<?php echo form_close();?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<div class="zoom-anim-dialog modal-block mfp-hide modal-block-full" id="modal">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title"><i class="fas fa-coins fa-fw"></i> <?=translate('collect_fees')?>
				<button type="button" class="close modal-dismiss" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</h4>
		</header>
		<?php echo form_open('fees/selectedFeesPay', array('class' => 'frm-submit' )); ?>
		<div class="panel-body">
			<div id="printResult" class="pt-sm pb-sm">
				<div class="table-responsive">						
					<table class="table table-bordered table-condensed text-dark" id="feeCollect">

					</table>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button type="submit" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">Fee Payment</button>
				</div>
			</div>
		</footer>
		<?php echo form_close();?>
	</section>
</div>

<div id="feeShareModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,20,.45);z-index:10050;align-items:center;justify-content:center;padding:16px;">
	<div style="background:#fff;max-width:490px;width:100%;border-top:4px solid #0f5c4c;border-radius:4px;box-shadow:0 12px 40px rgba(0,0,0,.2);padding:20px 22px 18px;">
		<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
			<h4 style="margin:0;color:#0f5c4c;font-weight:700;"><i class="fab fa-whatsapp" style="color:#25D366;margin-right:6px;"></i> Send receipt to parent</h4>
			<button type="button" id="feeShareCloseTop" style="border:none;background:transparent;font-size:22px;line-height:1;color:#888;cursor:pointer;">&times;</button>
		</div>
		<p style="margin:0 0 12px;color:#444;font-size:13px;">Choose PDF or image. WhatsApp gets the receipt attached, with the receipt message as the caption. The number below opens that parent's chat.</p>

		<div id="feeShareRecipient" style="background:#f4f7f5;border:1px solid #d2ded7;border-radius:4px;padding:10px 12px;margin-bottom:14px;font-size:13px;">
			<div style="font-weight:600;color:#0f5c4c;margin-bottom:5px;">Parent / Guardian WhatsApp Number:</div>
			<div id="feeSharePhoneWrap" style="display:flex;flex-wrap:wrap;gap:6px;align-items:center;">
				<span id="feeSharePhoneDisplay" style="font-family:monospace;font-size:14px;font-weight:700;color:#1a1a1a;">Loading…</span>
			</div>
		</div>

		<div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:10px;">
			<a id="feeShareDirectWa" href="#" target="_blank" rel="noopener" class="btn btn-default btn-slip" style="background:#25D366;color:#fff;border-color:#25D366;font-weight:700;padding:7px 14px;display:inline-flex;align-items:center;gap:6px;">
				<i class="fab fa-whatsapp" style="font-size:16px;"></i> Send on WhatsApp
			</a>
			<button type="button" id="feeSharePdf" class="btn btn-default btn-slip"><i class="fas fa-file-pdf"></i> PDF Receipt</button>
			<button type="button" id="feeShareImage" class="btn btn-default btn-slip"><i class="fas fa-image"></i> Image Receipt</button>
			<button type="button" id="feeShareClose" class="btn btn-default">Close</button>
		</div>

		<p id="feeShareStatus" style="margin:8px 0 0;color:#0f5c4c;font-size:12.5px;font-weight:500;"></p>

		<div id="feeShareMessageWrap" style="display:none;margin-top:12px;">
			<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
				<span style="font-size:12px;color:#666;font-weight:600;">Receipt Message:</span>
				<button type="button" id="feeShareCopyMsg" class="btn btn-xs btn-default" style="font-size:11px;"><i class="far fa-copy"></i> Copy text</button>
			</div>
			<pre id="feeShareMessage" style="white-space:pre-wrap;background:#fdfcf6;border:1px solid #e4d7a4;padding:10px;margin:0;font-size:12px;color:#1a1a1a;max-height:180px;overflow-y:auto;"></pre>
		</div>
	</div>
</div>

<script type="text/javascript">
	var branchID = "<?php echo $basic['branch_id']; ?>";
	var studentID = "<?php echo $basic['enroll_id']; ?>";
	$(".fee-selectAll").on("change", function(ev)
	{
		var $chcks = $(this).parents("table").find("tbody input[type='checkbox']");
		if($(this).is(':checked'))
		{
			$chcks.prop('checked', true).trigger('change');
		} else {
			$chcks.prop('checked', false).trigger('change');
		}
	});

	$('#collectFees').on('click', function(e) {
		var $btn = $(this);
		$btn.button('loading');
		var arrayData = [];
		$("#invoiceSummary tbody input[name='cb_invoice']:checked").each(function() {
			var allocationID = $(this).data("allocation-id");
			var feeTypeID = $(this).data("fee-type-id");
			var feeAmount = $(this).val();
			var trans_fd_id = $(this).data("transport-fd-id");
			var feeType = $(this).data("fee-type");
            array = {};
            array ["feeAmount"] = feeAmount;
            array ["allocationID"] = allocationID;
            array ["feeTypeID"] = feeTypeID;
            array ["trans_fd_id"] = trans_fd_id;
            array ["feeType"] = feeType;
            arrayData.push(array);
		});
        if (arrayData.length === 0) {
            alert("No Rows Selected.");
            $btn.button('reset');
        } else {
            $.ajax({
                url: base_url + "fees/selectedFeesCollect",
                type: 'POST',
                data: {
                	'data': JSON.stringify(arrayData),
                	'branch_id': branchID,
                	'student_id' : studentID,
                },
                dataType: "html",
                cache: false,
                success: function (response) {
                    $("#feeCollect").html(response);
                },
                complete: function () {
					$(".selectTwo").each(function() {
						var $this = $(this);
						$this.themePluginSelect2({});
					});
					$(".datepicker").each(function() {
						var $this = $(this);
						$this.themePluginDatePicker({
							"todayHighlight" : true,
							"endDate" : "today"
						});
					});
                	mfp_modal('#modal');
                	$btn.button('reset');
                }
            });
        }
	});

	$('#invoicePrint').on('click', function(e) {
		var $btn = $(this);
		$btn.button('loading');
		var arrayData = [];
		$("#invoiceSummary tbody input[name='cb_invoice']").each(function() {
			if($(this).is(':checked')) {
				var allocationID = $(this).data("allocation-id");
				var feeTypeID = $(this).data("fee-type-id");
				var feeAmount = $(this).val();
				var trans_fd_id = $(this).data("transport-fd-id");
				var feeType = $(this).data("fee-type");
	            array = {};
	            array ["feeAmount"] = feeAmount;
	            array ["allocationID"] = allocationID;
	            array ["feeTypeID"] = feeTypeID;
	            array ["trans_fd_id"] = trans_fd_id;
	            array ["feeType"] = feeType;
	            arrayData.push(array);
	            $(this).parents('tr').removeClass("hidden-print");
        	} else {
        		$(this).parents('tr').addClass("hidden-print");
        	}
		});
        if (arrayData.length === 0) {
            popupMsg("<?php echo translate('no_row_are_selected') ?>", "error");
            $btn.button('reset');
        } else {
        	$("#invDetailsPrint").html("");
            $.ajax({
                url: base_url + "fees/printFeesInvoice",
                type: 'POST',
                data: {'data': JSON.stringify(arrayData)},
                dataType: "html",
                cache: false,
                success: function (response) {
                    $("#invDetailsPrint").html(response);
                },
                complete: function () {
                	fn_printElem('invoice_print');
                	$btn.button('reset');
                }
            });
        }
	});

	$('#paymentPrint').on('click', function(e) {
		var $btn = $(this);
		$btn.button('loading');
		var arrayData = [];
		$("#paymentHistory tbody input[name='cb_feePay']").each(function() {
			if($(this).is(':checked')) {
				var paymentID = $(this).val();
	            array = {};
	            array ["payment_id"] = paymentID;
	            arrayData.push(array);
	            $(this).parents('tr').removeClass("hidden-print");
        	} else {
        		$(this).parents('tr').addClass("hidden-print");
        	}
		});
        if (arrayData.length === 0) {
            popupMsg("<?php echo translate('no_row_are_selected') ?>", "error");
            $btn.button('reset');
        } else {
        	$("#invPaymentHistory").html("");
            $.ajax({
                url: base_url + "fees/printFeesPaymentHistory",
                type: 'POST',
                data: {'data': JSON.stringify(arrayData)},
                dataType: "html",
                cache: false,
                success: function (response) {
                    $("#invPaymentHistory").html(response);
                },
                complete: function () {
                	fn_printElem('payment_print');
                	$btn.button('reset');
                }
            });
        }
	});

	$('#payReceiptPrint').on('click', function(e) {
		var $btn = $(this);
		$btn.button('loading');
		var arrayData = [];
		$("#paymentHistory tbody input[name='cb_feePay']").each(function() {
			if($(this).is(':checked')) {
				var allocationID = $(this).data("allocation-id");
				var feeTypeID = $(this).data("fee-type-id");
				var paymentID = $(this).val();
	            array = {};
	            array ["payment_id"] = paymentID;
	            array ["allocationID"] = allocationID;
	            array ["feeTypeID"] = feeTypeID;
	            arrayData.push(array);
        	}
		});
        if (arrayData.length === 0) {
            alert("No Rows Selected.");
            $btn.button('reset');
        } else {
        	$("#invDetailsPrint").html("");
            $.ajax({
                url: base_url + "fees/payReceiptPrint",
                type: 'POST',
                data: {
					'student_id' : studentID,
					'data': JSON.stringify(arrayData)
            	},
                dataType: "html",
                cache: false,
                success: function (response) {
                    fn_printElem(response, true);
                },
                complete: function () {
                	$btn.button('reset');
                }
            });
        }
	});

    $('#selected_revert').on('click', function(e){
    	var $this = $(this);
		var paymentID = [];
		$("#paymentHistory tbody input[name='cb_feePay']:checked").each(function() {
			paymentID.push($(this).val());
		});
		swal({
			title: "<?php echo translate('are_you_sure')?>",
			text: "<?php echo translate('delete_this_information')?>",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn btn-default swal2-btn-default",
			cancelButtonClass: "btn btn-default swal2-btn-default",
			confirmButtonText: "<?php echo translate('yes_continue')?>",
			cancelButtonText: "<?php echo translate('cancel')?>",
			buttonsStyling: false,
			footer: "<?php echo translate('deleted_note')?>"
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: base_url + 'fees/paymentRevert',
					type: "POST",
					data: {'id': paymentID},
					dataType: "JSON",
	                beforeSend: function () {
	                    $this.button('loading');
	                },
					success:function(data) {
						swal({
						title: "<?php echo translate('deleted')?>",
						text: data.message,
						buttonsStyling: false,
						showCloseButton: true,
						focusConfirm: false,
						confirmButtonClass: "btn btn-default swal2-btn-default",
						type: data.status
						}).then((result) => {
							if (result.value) {
								location.reload();
							}
						});
					},
	                complete: function () {
	                    $this.button('reset');
	                }
				});
			}
		});
    });


	var feeWaOpen = <?php $feeWaIds = $this->session->flashdata('fee_wa_ids'); echo json_encode($feeWaIds ? $feeWaIds : ''); ?>;
	var feeShareIds = '';
	var feeShareCurrentData = null;
	var feeShareSelectedPhone = '';

	function feeShareBytes(b64) {
		var binary = atob(b64);
		var bytes = new Uint8Array(binary.length);
		for (var i = 0; i < binary.length; i++) {
			bytes[i] = binary.charCodeAt(i);
		}
		return bytes;
	}

	function feeShareDownload(data) {
		var blob = new Blob([feeShareBytes(data.file)], { type: data.mime });
		var link = document.createElement('a');
		link.href = URL.createObjectURL(blob);
		link.download = data.filename;
		document.body.appendChild(link);
		link.click();
		link.remove();
	}

	function feeShareBuildWaLink(phone, message) {
		if (!message) return '#';
		if (phone) {
			return 'https://api.whatsapp.com/send?phone=' + encodeURIComponent(phone) + '&text=' + encodeURIComponent(message);
		}
		return 'https://api.whatsapp.com/send?text=' + encodeURIComponent(message);
	}

	function feeShareSelectPhone(phone) {
		feeShareSelectedPhone = phone;
		$('#feeSharePhoneWrap .fee-phone-btn').each(function () {
			var $btn = $(this);
			if ($btn.data('phone') == phone) {
				$btn.addClass('btn-primary').removeClass('btn-default');
			} else {
				$btn.addClass('btn-default').removeClass('btn-primary');
			}
		});
		if (feeShareCurrentData) {
			var wa = feeShareBuildWaLink(phone, feeShareCurrentData.message);
			$('#feeShareDirectWa').attr('href', wa).attr('target', '_blank');
			if (phone) {
				$('#feeShareDirectWa').html('<i class="fab fa-whatsapp" style="font-size:16px;"></i> Send on WhatsApp (+' + phone + ')');
			} else {
				$('#feeShareDirectWa').html('<i class="fab fa-whatsapp" style="font-size:16px;"></i> Send on WhatsApp');
			}
		}
	}

	function feeShareAsk(ids) {
		feeShareIds = ids || '';
		feeShareCurrentData = null;
		feeShareSelectedPhone = '';
		$('#feeShareStatus').text('Loading parent WhatsApp details…');
		$('#feeShareMessageWrap').hide();
		$('#feeShareMessage').text('');
		$('#feeSharePhoneWrap').html('<span id="feeSharePhoneDisplay" style="font-family:monospace;font-size:14px;font-weight:700;color:#1a1a1a;">Loading…</span>');
		$('#feeShareDirectWa').attr('href', '#').css('opacity', '0.6').css('pointer-events', 'none').html('<i class="fab fa-whatsapp" style="font-size:16px;"></i> Send on WhatsApp');
		$('#feeSharePdf, #feeShareImage').prop('disabled', true);
		$('#feeShareModal').css('display', 'flex');

		$.ajax({
			url: base_url + 'fees/receipt_share',
			type: 'POST',
			dataType: 'json',
			data: {
				enroll_id: studentID,
				format: 'summary',
				payment_ids: feeShareIds
			},
			success: function (data) {
				if (data && data.status === 'access_denied') {
					window.location.href = base_url + 'dashboard';
					return;
				}
				if (!data || !data.ok) {
					$('#feeShareStatus').text((data && data.error) ? data.error : 'Could not prepare receipt details.');
					return;
				}
				feeShareCurrentData = data;
				$('#feeShareStatus').text('');
				$('#feeSharePdf, #feeShareImage').prop('disabled', false);

				var phones = data.phones || (data.phone ? [data.phone] : []);
				var $wrap = $('#feeSharePhoneWrap').empty();
				if (phones && phones.length > 0) {
					feeShareSelectedPhone = phones[0];
					if (phones.length === 1) {
						$wrap.append($('<span>', {
							style: 'font-family:monospace;font-size:14px;font-weight:700;color:#0f5c4c;',
							text: '+' + phones[0] + (data.guardian ? ' (' + data.guardian + ')' : '')
						}));
					} else {
						phones.forEach(function (ph, idx) {
							var $btn = $('<button>', {
								type: 'button',
								class: 'btn btn-xs fee-phone-btn ' + (idx === 0 ? 'btn-primary' : 'btn-default'),
								style: 'font-family:monospace;font-weight:600;margin-right:6px;',
								text: '+' + ph,
								'data-phone': ph
							}).on('click', function () {
								feeShareSelectPhone($(this).data('phone'));
							});
							$wrap.append($btn);
						});
					}
					feeShareSelectPhone(feeShareSelectedPhone);
					$('#feeShareDirectWa').css('opacity', '1').css('pointer-events', 'auto');
				} else {
					$wrap.html('<span style="color:#c9302c;font-size:13px;"><i class="fas fa-exclamation-triangle"></i> No parent phone registered for this student.</span>');
					if (data.message) {
						var fallbackWa = feeShareBuildWaLink('', data.message);
						$('#feeShareDirectWa').attr('href', fallbackWa).css('opacity', '1').css('pointer-events', 'auto');
					}
				}

				if (data.message) {
					$('#feeShareMessage').text(data.message);
					$('#feeShareMessageWrap').show();
				}
			},
			error: function () {
				$('#feeShareStatus').text('Could not connect to fetch receipt details.');
			}
		});
	}

	function feeShareFallback(data, format) {
		var $status = $('#feeShareStatus');
		var phone = feeShareSelectedPhone || (data && data.phone) || '';
		if (!phone) {
			feeShareDownload(data);
			if (data.whatsapp) {
				window.open(data.whatsapp, '_blank');
			}
			$status.text('The receipt downloaded. Attach that file in the WhatsApp chat and keep the message below.');
			return;
		}
		$status.text('Sending the receipt to +' + phone + '…');
		$.ajax({
			url: base_url + 'fees/receipt_share',
			type: 'POST',
			dataType: 'json',
			data: {
				enroll_id: studentID,
				format: format,
				payment_ids: feeShareIds,
				phone: phone,
				deliver: 'whatsapp'
			},
			success: function (sent) {
				var pack = (sent && sent.file) ? sent : data;
				if (sent && sent.sent) {
					$status.html('<span style="color:green;"><i class="fas fa-check-circle"></i> Receipt attached and sent to WhatsApp for <strong>+' + phone + '</strong>.</span>');
					return;
				}
				feeShareDownload(pack);
				var link = (sent && sent.whatsapp) ? sent.whatsapp : data.whatsapp;
				if (link) {
					window.open(link, '_blank');
				}
				var why = (sent && sent.error) ? sent.error + ' ' : '';
				$status.html(why + 'The receipt downloaded. WhatsApp is open' + (phone ? ' for <strong>+' + phone + '</strong>' : '') + '. Attach that file and keep the message below.');
			},
			error: function () {
				feeShareDownload(data);
				if (data.whatsapp) {
					window.open(data.whatsapp, '_blank');
				}
				$status.text('The receipt downloaded. Attach that file in the WhatsApp chat and keep the message below.');
			}
		});
	}

	function feeShareSend(format) {
		var $status = $('#feeShareStatus');
		$status.text('Preparing the ' + format.toUpperCase() + ' receipt…');
		$('#feeSharePdf, #feeShareImage').prop('disabled', true);
		$.ajax({
			url: base_url + 'fees/receipt_share',
			type: 'POST',
			dataType: 'json',
			data: {
				enroll_id: studentID,
				format: format,
				payment_ids: feeShareIds,
				phone: feeShareSelectedPhone
			},
			success: function (data) {
				if (data && data.status === 'access_denied') {
					window.location.href = base_url + 'dashboard';
					return;
				}
				if (!data || !data.ok || !data.file) {
					$status.text((data && data.error) ? data.error : 'The receipt could not be prepared.');
					return;
				}
				if (data.message) {
					$('#feeShareMessage').text(data.message);
					$('#feeShareMessageWrap').show();
				}
				var file = new File([feeShareBytes(data.file)], data.filename, { type: data.mime });
				if (navigator.canShare && navigator.canShare({ files: [file] })) {
					$status.text('Opening share. Choose WhatsApp so the receipt stays attached with the message.');
					navigator.share({ files: [file], text: data.message || '', title: 'Fee receipt' }).then(function () {
						$status.text('If the caption is empty in WhatsApp, paste the message below.');
					}).catch(function (err) {
						if (err && err.name === 'AbortError') {
							$status.text('Share cancelled. The message is below if you still want to send it.');
							return;
						}
						feeShareFallback(data, format);
					});
					return;
				}
				feeShareFallback(data, format);
			},
			error: function () {
				$status.text('The receipt could not be prepared.');
			},
			complete: function () {
				$('#feeSharePdf, #feeShareImage').prop('disabled', false);
			}
		});
	}

	$('#feeShareOpen').on('click', function () {
		feeShareAsk('');
	});
	$('#feeShareHistory').on('click', function () {
		var ids = [];
		$("#paymentHistory tbody input[name='cb_feePay']:checked").each(function () {
			ids.push($(this).val());
		});
		if (!ids.length) {
			alert('No rows selected.');
			return;
		}
		feeShareAsk(ids.join(','));
	});
	$('#feeSharePdf').on('click', function () { feeShareSend('pdf'); });
	$('#feeShareImage').on('click', function () { feeShareSend('image'); });
	$('#feeShareClose, #feeShareCloseTop').on('click', function () { $('#feeShareModal').hide(); });
	$('#feeShareCopyMsg').on('click', function () {
		var text = $('#feeShareMessage').text();
		if (navigator.clipboard && navigator.clipboard.writeText) {
			navigator.clipboard.writeText(text).then(function () {
				alert('Receipt message copied to clipboard!');
			});
		} else {
			var $temp = $('<textarea>');
			$('body').append($temp);
			$temp.val(text).select();
			document.execCommand('copy');
			$temp.remove();
			alert('Receipt message copied to clipboard!');
		}
	});

	if (feeWaOpen) {
		feeShareAsk(feeWaOpen);
	}

    $('#fees_type').on("change", function(){
        var typeID = $(this).val();
	    $.ajax({
	        url: base_url + 'fees/getBalanceByType',
	        type: 'POST',
	        data: {
	        	'typeID': typeID
	        },
	        dataType: "json",
	        success: function (data) {
	            $('#feeAmount').val(data.balance.toFixed(2));
	            $('#fineAmount').val(data.fine.toFixed(2));
	        }
	    });
    });
</script>