<?php
$extINTL = extension_loaded('intl');
if ($extINTL == true) {
	$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
}
$fee_sheet_interactive = false;
$for_pdf = true;
$len = count($student_array);
$i = 1;
if ($len) {
	foreach ($student_array as $value) {
		$invoice = $this->fees_model->getInvoiceStatus($value);
		$basic = $this->fees_model->getInvoiceBasic($value);
		if (empty($basic) || empty($invoice)) {
			$i++;
			continue;
		}
		unset($transport_fees);
		$fee_sheet_break = ($i < $len) ? 'page-break-after:always' : '';
		include APPPATH . 'views/fees/_invoice_sheet.php';
		$i++;
	}
}
