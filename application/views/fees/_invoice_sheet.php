<?php
if (!isset($fee_sheet_interactive)) {
    $fee_sheet_interactive = false;
}
if (!isset($for_pdf)) {
    $for_pdf = false;
}
if (!isset($fee_sheet_break)) {
    $fee_sheet_break = '';
}
if (!isset($fee_sheet_css_only)) {
    $fee_sheet_css_only = false;
}
if (!isset($transport_fees)) {
    $transport_fees = array();
    if (moduleIsEnabled('transport')) {
        $transport_fees = $this->fees_model->getStudentTransportFees($basic['enroll_id'], $basic['stoppage_point_id']);
    }
}
if (!isset($extINTL)) {
    $extINTL = extension_loaded('intl');
    if ($extINTL) {
        $spellout = new NumberFormatter('en', NumberFormatter::SPELLOUT);
    }
}

$school = !empty($basic['school_name']) ? $basic['school_name'] : (defined('SCHOOL_NAME') ? SCHOOL_NAME : '');
$motto = defined('SCHOOL_MOTTO') ? SCHOOL_MOTTO : '';
$logoFile = FCPATH . 'uploads/app_image/printing-logo.png';
$logoSrc = ($for_pdf && is_file($logoFile)) ? $logoFile : base_url('uploads/app_image/printing-logo.png');
$photoName = isset($basic['photo']) ? $basic['photo'] : '';
$photoSrc = $for_pdf ? local_image_path('student', $photoName) : get_image_url('student', $photoName);
if ($for_pdf) {
    $logoSrc = str_replace('\\', '/', $logoSrc);
    $photoSrc = str_replace('\\', '/', $photoSrc);
}
$nameBits = array(isset($basic['first_name']) ? $basic['first_name'] : '');
if (!empty($basic['other_name'])) {
    $nameBits[] = $basic['other_name'];
}
$nameBits[] = isset($basic['last_name']) ? $basic['last_name'] : '';
$studentName = trim(preg_replace('/\s+/', ' ', implode(' ', $nameBits)));
if (!empty($basic['class_name']) && !empty($basic['section_name'])) {
    $classLine = $basic['class_name'] . ' (' . $basic['section_name'] . ')';
} elseif (!empty($basic['class_name'])) {
    $classLine = $basic['class_name'];
} else {
    $classLine = isset($basic['section_name']) ? $basic['section_name'] : '';
}
$guardianLine = isset($basic['guardian_name']) ? $basic['guardian_name'] : '';
if (!empty($basic['guardian_mobile'])) {
    $guardianLine = trim($guardianLine . ($guardianLine !== '' ? ' · ' : '') . $basic['guardian_mobile']);
}
$yearRow = $this->db->select('school_year')->where('id', get_session_id())->get('schoolyear')->row();
$schoolYear = $yearRow ? $yearRow->school_year : '';
$blank = function ($value) {
    return ($value === '' || $value === null) ? '—' : html_escape($value);
};
if ($invoice['status'] == 'unpaid') {
    $sheetStatus = translate('unpaid');
    $sheetStatusClass = 'slip-due';
} elseif ($invoice['status'] == 'partly') {
    $sheetStatus = translate('partly_paid');
    $sheetStatusClass = 'slip-part';
} else {
    $sheetStatus = translate('total_paid');
    $sheetStatusClass = 'slip-ok';
}
$cols = $fee_sheet_interactive ? 10 : 9;

if ($fee_sheet_css_only || empty($GLOBALS['tahsin_fee_sheet_css'])) {
    $GLOBALS['tahsin_fee_sheet_css'] = true;
?>
<style>
.fee-sheet { background:#fff; color:#1a1a1a; padding:16px 18px 20px; margin:0 auto; max-width:190mm; box-sizing:border-box; }
.fee-sheet-page { background:#eef1f4; padding:16px 8px 8px; }
.fee-sheet .hdr { width:100%; border-bottom:3px solid #0f5c4c; padding-bottom:8px; margin-bottom:10px; border-collapse:collapse; }
.fee-sheet .hdr td { vertical-align:middle; border:0 !important; background:transparent !important; }
.fee-sheet .logo { width:72px; height:auto; }
.fee-sheet .school-name { font-size:22px; color:#0f5c4c; font-weight:bold; letter-spacing:0.4px; margin:0; }
.fee-sheet .motto { font-size:11px; color:#c9a227; font-style:italic; margin:2px 0 0; }
.fee-sheet .contact { font-size:10px; color:#555; }
.fee-sheet .passport { width:32mm; height:38mm; object-fit:cover; border:2px solid #0f5c4c; }
.fee-sheet .doc-title { text-align:center; margin:10px 0 12px; }
.fee-sheet .doc-title h1 { margin:0; font-size:16px; letter-spacing:2px; color:#0f5c4c; text-transform:uppercase; }
.fee-sheet .doc-title p { margin:3px 0 0; font-size:11px; color:#666; }
.fee-sheet table.meta { width:100%; border-collapse:collapse; font-size:12px; margin:0; }
.fee-sheet table.meta th { text-align:left; width:22%; padding:5px 8px; background:#f4f7f6; color:#0f5c4c; border:1px solid #d5ddd9; font-weight:bold; }
.fee-sheet table.meta td { padding:5px 8px; border:1px solid #d5ddd9; background:#fff; }
.fee-sheet .section-h { background:#0f5c4c; color:#fff; font-size:11px; letter-spacing:1px; text-transform:uppercase; padding:5px 8px; margin:12px 0 0; }
.fee-sheet table.pay-box { width:100%; border-collapse:collapse; font-size:12px; margin:0 0 8px; }
.fee-sheet table.pay-box th,
.fee-sheet table.pay-box td { border:1px solid #d5ddd9 !important; padding:6px 8px !important; background:#fff; vertical-align:middle; }
.fee-sheet table.pay-box thead th { background:#f8f1d8 !important; color:#5a4708 !important; font-weight:bold; }
.fee-sheet tr.slip-group td { background:#0f5c4c !important; color:#fff !important; font-size:11px; letter-spacing:1px; text-transform:uppercase; font-weight:bold; border-color:#0f5c4c !important; }
.fee-sheet .slip-due { color:#a94442; font-weight:bold; }
.fee-sheet .slip-part { color:#8a6d3b; font-weight:bold; }
.fee-sheet .slip-ok { color:#0f5c4c; font-weight:bold; }
.fee-sheet .signs { width:100%; margin-top:22px; border-collapse:collapse; }
.fee-sheet .signs td { width:50%; text-align:center; font-size:11px; padding-top:28px; border:0 !important; background:transparent !important; }
.fee-sheet .sign-line { border-top:1px solid #333; width:70%; margin:0 auto 4px; }
.fee-sheet .note { font-size:9px; color:#666; margin-top:14px; border-top:1px dashed #ccc; padding-top:6px; }
.fee-sheet .sheet-actions { margin:10px 0; }
.fee-sheet .sheet-actions .btn, .fee-sheet-page .btn-slip, #feeShareHistory.btn-slip, #feeSharePdf.btn-slip, #feeShareImage.btn-slip { background:#c9a227; color:#1a1a1a; font-weight:bold; border-color:#c9a227; }
#payment_print.fee-sheet table.invoice-items { width:100%; border-collapse:collapse; font-size:12px; }
#payment_print.fee-sheet table.invoice-items th,
#payment_print.fee-sheet table.invoice-items td { border:1px solid #d5ddd9 !important; padding:6px 8px !important; }
#payment_print.fee-sheet table.invoice-items thead th { background:#f8f1d8 !important; color:#5a4708 !important; }
@media print {
    .fee-sheet-page { background:#fff; padding:0; }
    .fee-sheet { max-width:none; box-shadow:none; }
    .fee-sheet .sheet-actions { display:none !important; }
}
</style>
<?php
    if ($fee_sheet_css_only) {
        return;
    }
} ?>
<div class="fee-sheet"<?php echo $fee_sheet_break !== '' ? ' style="' . html_escape($fee_sheet_break) . '"' : ''; ?>>
    <table class="hdr">
        <tr>
            <td style="width:80px"><img class="logo" src="<?php echo html_escape($logoSrc); ?>" alt="Logo"></td>
            <td>
                <p class="school-name"><?php echo html_escape($school); ?></p>
                <?php if ($motto !== ''): ?><p class="motto"><?php echo html_escape($motto); ?></p><?php endif; ?>
                <div class="contact">
                    <?php if (!empty($basic['school_address'])) echo html_escape($basic['school_address']) . ' · '; ?>
                    <?php if (!empty($basic['school_mobileno'])) echo html_escape($basic['school_mobileno']) . ' · '; ?>
                    <?php echo html_escape($basic['school_email']); ?>
                </div>
            </td>
            <td style="width:110px;text-align:right">
                <img class="passport" src="<?php echo html_escape($photoSrc); ?>" alt="Passport">
            </td>
        </tr>
    </table>
    <div class="doc-title">
        <h1>Fee Invoice</h1>
        <p>
            Invoice No #<?php echo html_escape($invoice['invoice_no']); ?>
            <?php if ($schoolYear !== ''): ?> · Session <?php echo html_escape($schoolYear); ?><?php endif; ?>
            · Issued <?php echo html_escape(_d(date('Y-m-d'))); ?>
            · <span class="<?php echo $sheetStatusClass; ?>"><?php echo html_escape($sheetStatus); ?></span>
        </p>
    </div>

    <div class="section-h">Student Particulars</div>
    <table class="meta">
        <tr>
            <th>Full Name</th>
            <td><?php echo $blank($studentName); ?></td>
            <th>Gender</th>
            <td><?php echo $blank(isset($basic['gender']) ? ucfirst($basic['gender']) : ''); ?></td>
        </tr>
        <tr>
            <th>Register No</th>
            <td><?php echo $blank($basic['register_no']); ?></td>
            <th>Class / Section</th>
            <td><?php echo $blank($classLine); ?></td>
        </tr>
        <tr>
            <th>Mobile</th>
            <td><?php echo $blank(isset($basic['mobileno']) ? $basic['mobileno'] : ''); ?></td>
            <th>Email</th>
            <td><?php echo $blank($basic['student_email']); ?></td>
        </tr>
        <tr>
            <th>Guardian</th>
            <td><?php echo $blank($guardianLine); ?></td>
            <th>Father's Name</th>
            <td><?php echo $blank($basic['father_name']); ?></td>
        </tr>
        <tr>
            <th>Present Address</th>
            <td colspan="3"><?php echo $blank($basic['student_address']); ?></td>
        </tr>
    </table>

    <div class="section-h">Fee Lines</div>
    <?php if ($fee_sheet_interactive && get_permission('collect_fees', 'is_add')): ?>
    <div class="sheet-actions hidden-print">
        <button type="button" class="btn btn-default btn-sm" id="collectFees" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
            <i class="fas fa-coins fa-fw"></i> Selected Fees Collect
        </button>
    </div>
    <?php endif; ?>
    <div class="table-responsive br-none">
        <table class="table pay-box invoice-items mb-none" <?php echo $fee_sheet_interactive ? 'id="invoiceSummary"' : ''; ?>>
            <thead>
                <tr>
                    <?php if ($fee_sheet_interactive): ?>
                    <th class="hidden-print" style="width:36px">
                        <div class="checkbox-replace">
                            <label class="i-checks" data-toggle="tooltip" data-original-title="Print Show / Hidden">
                                <input type="checkbox" class="fee-selectAll" checked><i></i>
                            </label>
                        </div>
                    </th>
                    <th class="hidden-print">#</th>
                    <?php else: ?>
                    <th>#</th>
                    <?php endif; ?>
                    <th><?php echo translate('fees_type'); ?></th>
                    <th><?php echo translate('due_date'); ?></th>
                    <th><?php echo translate('status'); ?></th>
                    <th><?php echo translate('amount'); ?></th>
                    <th><?php echo translate('discount'); ?></th>
                    <th><?php echo translate('fine'); ?></th>
                    <th><?php echo translate('paid'); ?></th>
                    <th class="text-center"><?php echo translate('balance'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $group = array();
            $count = 1;
            $total_fine = 0;
            $fully_total_fine = 0;
            $total_discount = 0;
            $total_paid = 0;
            $total_balance = 0;
            $total_amount = 0;
            $typeData = array('' => translate('select'));
            $allocations = $this->fees_model->getInvoiceDetails($basic['enroll_id']);
            $feeStatus = function ($paid, $balance) {
                if ((float) $paid == 0) {
                    return array(translate('unpaid'), 'slip-due');
                }
                if ((float) $balance == 0) {
                    return array(translate('total_paid'), 'slip-ok');
                }
                return array(translate('partly_paid'), 'slip-part');
            };
            foreach ($allocations as $row) {
                $deposit = $this->fees_model->getStudentFeeDeposit($row['allocation_id'], $row['fee_type_id']);
                $type_discount = $deposit['total_discount'];
                $type_fine = $deposit['total_fine'];
                $type_amount = $deposit['total_amount'];
                $balance = $row['amount'] - ($type_amount + $type_discount);
                $total_discount += $type_discount;
                $total_fine += $type_fine;
                $total_paid += $type_amount;
                $total_balance += $balance;
                $total_amount += $row['amount'];
                if ($balance != 0) {
                    $typeData[$row['allocation_id'] . '|' . $row['fee_type_id']] = $row['name'];
                    $fine = $this->fees_model->feeFineCalculation($row['allocation_id'], $row['fee_type_id']);
                    $b = $this->fees_model->getBalance($row['allocation_id'], $row['fee_type_id']);
                    $fine = abs($fine - $b['fine']);
                    $fully_total_fine += $fine;
                }
                if (!in_array($row['group_id'], $group)) {
                    $group[] = $row['group_id'];
                    $groupLabel = '<strong>' . html_escape(get_type_name_by_id('fee_groups', $row['group_id'])) . '</strong>';
                    if ($fee_sheet_interactive) {
                        echo '<tr class="slip-group"><td class="hidden-print" colspan="2"></td><td colspan="8">' . $groupLabel . '</td></tr>';
                    } else {
                        echo '<tr class="slip-group"><td colspan="' . (int) $cols . '">' . $groupLabel . '</td></tr>';
                    }
                }
                list($statusText, $statusClass) = $feeStatus($type_amount, $balance);
            ?>
                <tr>
                    <?php if ($fee_sheet_interactive): ?>
                    <td class="hidden-print checked-area">
                        <div class="checkbox-replace">
                            <label class="i-checks"><input type="checkbox" name="cb_invoice" value="<?php echo $row['amount']; ?>" data-allocation-id="<?php echo $row['allocation_id']; ?>" data-fee-type-id="<?php echo $row['fee_type_id']; ?>" data-fee-type="general" data-transport-fd-id="0" checked><i></i></label>
                        </div>
                    </td>
                    <td class="hidden-print"><?php echo $count++; ?></td>
                    <?php else: ?>
                    <td><?php echo $count++; ?></td>
                    <?php endif; ?>
                    <td class="text-dark"><?php echo html_escape($row['name']); ?></td>
                    <td><?php echo html_escape(_d($row['due_date'])); ?></td>
                    <td><span class="<?php echo $statusClass; ?>"><?php echo html_escape($statusText); ?></span></td>
                    <td><?php echo currencyFormat($row['amount']); ?></td>
                    <td><?php echo currencyFormat($type_discount); ?></td>
                    <td><?php echo currencyFormat($type_fine); ?></td>
                    <td><?php echo currencyFormat($type_amount); ?></td>
                    <td class="text-center"><?php echo currencyFormat($balance); ?></td>
                </tr>
            <?php }
            if (!empty($transport_fees)) {
                $groupLabel = '<strong>' . html_escape(translate('transport_fees')) . '</strong>';
                if ($fee_sheet_interactive) {
                    echo '<tr class="slip-group"><td class="hidden-print" colspan="2"></td><td colspan="8">' . $groupLabel . '</td></tr>';
                } else {
                    echo '<tr class="slip-group"><td colspan="' . (int) $cols . '">' . $groupLabel . '</td></tr>';
                }
                foreach ($transport_fees as $value) {
                    $deposit = $this->fees_model->getStudentTransportFeeDeposit($value->id);
                    $type_discount = $deposit['total_discount'];
                    $type_fine = $deposit['total_fine'];
                    $type_amount = $deposit['total_amount'];
                    $balance = $value->route_fare - ($type_amount + $type_discount);
                    $month = $this->app_lib->getMonthslist($value->month);
                    if ($balance != 0) {
                        $fine = $this->fees_model->transportFeeFineCalculation($value->id);
                        $fully_total_fine += $fine;
                        $typeData['transport|' . $value->id . '|' . $value->month] = translate('transport_fees') . ' - ' . $month;
                    }
                    $total_discount += $type_discount;
                    $total_fine += $type_fine;
                    $total_paid += $type_amount;
                    $total_balance += $balance;
                    $total_amount += $value->route_fare;
                    list($statusText, $statusClass) = $feeStatus($type_amount, $balance);
            ?>
                <tr>
                    <?php if ($fee_sheet_interactive): ?>
                    <td class="hidden-print checked-area">
                        <div class="checkbox-replace">
                            <label class="i-checks"><input type="checkbox" name="cb_invoice" value="<?php echo $value->route_fare; ?>" data-allocation-id="0" data-fee-type-id="0" data-fee-type="transport" data-transport-fd-id="<?php echo $value->id; ?>" checked><i></i></label>
                        </div>
                    </td>
                    <td class="hidden-print"><?php echo $count++; ?></td>
                    <?php else: ?>
                    <td><?php echo $count++; ?></td>
                    <?php endif; ?>
                    <td class="text-dark"><?php echo html_escape($month); ?></td>
                    <td><?php echo html_escape(_d($value->due_date)); ?></td>
                    <td><span class="<?php echo $statusClass; ?>"><?php echo html_escape($statusText); ?></span></td>
                    <td><?php echo currencyFormat($value->route_fare); ?></td>
                    <td><?php echo currencyFormat($type_discount); ?></td>
                    <td><?php echo currencyFormat($type_fine); ?></td>
                    <td><?php echo currencyFormat($type_amount); ?></td>
                    <td class="text-center"><?php echo currencyFormat($balance); ?></td>
                </tr>
            <?php }
            } ?>
            </tbody>
        </table>
    </div>

    <div class="section-h">Summary</div>
    <table class="pay-box<?php echo $fee_sheet_interactive ? ' hidden-print' : ''; ?>">
        <tr>
            <th><?php echo translate('grand_total'); ?></th>
            <td><?php echo currencyFormat($total_amount); ?></td>
            <th><?php echo translate('discount'); ?></th>
            <td><?php echo currencyFormat($total_discount); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('paid'); ?></th>
            <td><?php echo currencyFormat($total_paid); ?></td>
            <th><?php echo translate('fine'); ?></th>
            <td><?php echo currencyFormat($total_fine); ?></td>
        </tr>
        <tr>
            <?php if ($total_balance != 0): ?>
            <th><?php echo translate('balance'); ?></th>
            <td colspan="3" class="slip-due">
                <?php
                echo currencyFormat($total_balance);
                if ($extINTL && isset($spellout)) {
                    echo ' (' . html_escape(ucwords($spellout->format(number_format($total_balance, 2, '.', '')))) . ')';
                }
                ?>
            </td>
            <?php else: ?>
            <th><?php echo translate('total_paid'); ?> (<?php echo translate('with_fine'); ?>)</th>
            <td colspan="3" class="slip-ok">
                <?php
                $paidWithFine = $total_paid + $total_fine;
                echo currencyFormat($paidWithFine);
                if ($extINTL && isset($spellout)) {
                    echo ' (' . html_escape(ucwords($spellout->format(number_format($paidWithFine, 2, '.', '')))) . ')';
                }
                ?>
            </td>
            <?php endif; ?>
        </tr>
    </table>
    <?php if ($fee_sheet_interactive): ?>
    <div class="invoice-summary text-right mt-lg visible-print-block" id="invDetailsPrint"></div>
    <?php endif; ?>

    <table class="signs">
        <tr>
            <td><div class="sign-line"></div>Parent / Guardian</td>
            <td><div class="sign-line"></div>Bursar</td>
        </tr>
    </table>
    <div class="note">This invoice is issued by <?php echo html_escape($school); ?>. Keep it for your records.</div>
</div>
