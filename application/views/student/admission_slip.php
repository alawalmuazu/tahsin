<?php
$is_pdf = !empty($is_pdf);
$school = !empty($slip['school_name']) ? $slip['school_name'] : SCHOOL_NAME;
$motto = SCHOOL_MOTTO;
$na = function ($v) {
    return ($v === '' || $v === null) ? '—' : html_escape($v);
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admission Slip — <?=html_escape($slip['fullname'])?></title>
    <?php if (!$is_pdf): ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="<?=base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
    <?php endif; ?>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #1a1a1a; background: #eef1f4; margin: 0; padding: 0; }
        .toolbar { background: #0f5c4c; color: #fff; padding: 12px 20px; text-align: center; }
        .toolbar a { display: inline-block; margin: 0 6px; padding: 8px 16px; background: #c9a227; color: #1a1a1a; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold; }
        .toolbar a.ghost { background: transparent; color: #fff; border: 1px solid #fff; }
        .sheet { width: 190mm; margin: 16px auto; background: #fff; padding: 12mm 12mm 10mm; box-sizing: border-box; }
        .hdr { width: 100%; border-bottom: 3px solid #0f5c4c; padding-bottom: 8px; margin-bottom: 10px; }
        .hdr td { vertical-align: middle; }
        .logo { width: 72px; height: auto; }
        .school-name { font-size: 22px; color: #0f5c4c; font-weight: bold; letter-spacing: 0.4px; margin: 0; }
        .motto { font-size: 11px; color: #c9a227; font-style: italic; margin: 2px 0 0; }
        .contact { font-size: 10px; color: #555; }
        .doc-title { text-align: center; margin: 10px 0 12px; }
        .doc-title h1 { margin: 0; font-size: 16px; letter-spacing: 2px; color: #0f5c4c; text-transform: uppercase; }
        .doc-title p { margin: 3px 0 0; font-size: 11px; color: #666; }
        .passport { width: 32mm; height: 38mm; object-fit: cover; border: 2px solid #0f5c4c; }
        table.meta { width: 100%; border-collapse: collapse; font-size: 12px; }
        table.meta th { text-align: left; width: 34%; padding: 5px 8px; background: #f4f7f6; color: #0f5c4c; border: 1px solid #d5ddd9; font-weight: bold; }
        table.meta td { padding: 5px 8px; border: 1px solid #d5ddd9; }
        .section-h { background: #0f5c4c; color: #fff; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; padding: 5px 8px; margin: 12px 0 0; }
        .pay-box { width: 100%; border-collapse: collapse; font-size: 12px; }
        .pay-box th, .pay-box td { border: 1px solid #d5ddd9; padding: 6px 8px; }
        .pay-box th { background: #f8f1d8; color: #5a4708; text-align: left; }
        .codes { width: 100%; margin-top: 14px; }
        .codes td { text-align: center; vertical-align: top; }
        .qr { width: 28mm; height: 28mm; }
        .code-label { font-size: 10px; color: #555; margin-top: 4px; }
        .code-value { font-size: 12px; font-weight: bold; letter-spacing: 1px; }
        .signs { width: 100%; margin-top: 22px; }
        .signs td { width: 50%; text-align: center; font-size: 11px; padding-top: 28px; }
        .sign-line { border-top: 1px solid #333; width: 70%; margin: 0 auto 4px; }
        .note { font-size: 9px; color: #666; margin-top: 14px; border-top: 1px dashed #ccc; padding-top: 6px; }
        .unpaid { color: #a94442; font-weight: bold; }
        @media print {
            body { background: #fff; }
            .toolbar { display: none !important; }
            .sheet { margin: 0; width: auto; box-shadow: none; }
        }
    </style>
</head>
<body>
<?php if (!$is_pdf): ?>
<div class="toolbar">
    <a href="javascript:window.print()"><i class="fas fa-print"></i> Print</a>
    <a href="<?=base_url('student/admission_slip/' . $slip['enrollid'] . '?pdf=1')?>"><i class="fas fa-file-pdf"></i> Download PDF</a>
    <a href="javascript:void(0)" id="slipShareBtn" style="background:#25D366;color:#fff;"><i class="fab fa-whatsapp"></i> WhatsApp Slip / Receipt</a>
    <a class="ghost" href="<?=base_url('student/profile/' . $slip['enrollid'])?>">Student Profile</a>
    <a class="ghost" href="<?=base_url('student/add')?>">Admit Another Student</a>
</div>
<?php endif; ?>

<div class="sheet">
    <table class="hdr">
        <tr>
            <td style="width:80px"><img class="logo" src="<?=html_escape($logo_src)?>" alt="Logo"></td>
            <td>
                <p class="school-name"><?=html_escape($school)?></p>
                <p class="motto"><?=html_escape($motto)?></p>
                <div class="contact">
                    <?php if (!empty($slip['school_address'])) echo html_escape($slip['school_address']) . ' · '; ?>
                    <?php if (!empty($slip['school_mobile'])) echo html_escape($slip['school_mobile']) . ' · '; ?>
                    <?=html_escape($slip['school_email'])?>
                </div>
            </td>
            <td style="width:110px;text-align:right">
                <img class="passport" src="<?=html_escape($photo_src)?>" alt="Passport">
            </td>
        </tr>
    </table>

    <div class="doc-title">
        <h1>Admission Slip</h1>
        <p>Session <?=html_escape($slip['school_year'])?> · Issued <?=html_escape(_d(date('Y-m-d')))?></p>
    </div>

    <div class="section-h">Student Particulars</div>
    <table class="meta">
        <tr>
            <th>Full Name</th>
            <td><?=$na($slip['fullname'])?></td>
            <th>Gender</th>
            <td><?=$na($slip['gender'])?></td>
        </tr>
        <tr>
            <th>Academy ID</th>
            <td><?=$na($slip['state_student_id'])?></td>
            <th>Register No</th>
            <td><?=$na($slip['register_no'])?></td>
        </tr>
        <tr>
            <th>Class / Section</th>
            <td><?=$na($slip['class_name'])?> (<?=$na($slip['section_name'])?>)</td>
            <th>Roll</th>
            <td><?=$na($slip['roll'])?></td>
        </tr>
        <tr>
            <th>Admission Date</th>
            <td><?=$na(_d($slip['admission_date']))?></td>
            <th>Date of Birth</th>
            <td><?=$na(_d($slip['birthday']))?></td>
        </tr>
        <tr>
            <th>Category</th>
            <td><?=$na($slip['category_name'])?></td>
            <th>Blood Group</th>
            <td><?=$na($slip['blood_group'])?></td>
        </tr>
        <tr>
            <th>Mobile</th>
            <td><?=$na($slip['mobileno'])?></td>
            <th>Email</th>
            <td><?=$na($slip['email'])?></td>
        </tr>
        <tr>
            <th>Present Address</th>
            <td colspan="3"><?=$na($slip['current_address'])?></td>
        </tr>
    </table>

    <div class="section-h">Guardian</div>
    <table class="meta">
        <tr>
            <th>Guardian Name</th>
            <td><?=$na($slip['guardian_name'])?></td>
            <th>Relation</th>
            <td><?=$na($slip['guardian_relation'])?></td>
        </tr>
        <tr>
            <th>Father's Name</th>
            <td><?=$na($slip['father_name'])?></td>
            <th>Guardian Mobile</th>
            <td><?=$na($slip['guardian_mobile'])?></td>
        </tr>
    </table>

    <div class="section-h">Tuition Payment</div>
    <?php if (!empty($tuition) && $tuition['paid'] > 0): ?>
    <table class="pay-box">
        <tr>
            <th>School Fees</th>
            <td><?=currencyFormat($tuition['fee'])?></td>
            <th>Payment Type</th>
            <td><?=html_escape($tuition['plan_label'] ?: '—')?></td>
        </tr>
        <tr>
            <th>Amount Paid</th>
            <td><?=currencyFormat($tuition['paid'])?></td>
            <th>Balance</th>
            <td><?=currencyFormat($tuition['balance'])?></td>
        </tr>
        <tr>
            <th>Mode of Payment</th>
            <td><?=html_escape($tuition['last']['pay_via_name'] ?: '—')?></td>
            <th>Payment Date</th>
            <td><?=html_escape(_d($tuition['last']['date']))?></td>
        </tr>
        <?php $received_into = $this->app_lib->collectionAccountLabel(); if ($received_into !== ''): ?>
        <tr>
            <th>Received Into</th>
            <td colspan="3"><?=html_escape($received_into)?></td>
        </tr>
        <?php endif; ?>
        <?php if (!empty($tuition['last']['remarks'])): ?>
        <tr>
            <th>Remarks</th>
            <td colspan="3"><?=html_escape($tuition['last']['remarks'])?></td>
        </tr>
        <?php endif; ?>
    </table>
    <?php if (count($tuition['payments']) > 1): ?>
    <table class="pay-box" style="margin-top:8px">
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Mode</th>
        </tr>
        <?php foreach ($tuition['payments'] as $i => $pay): ?>
        <tr>
            <td><?=($i + 1)?></td>
            <td><?=html_escape(_d($pay['date']))?></td>
            <td><?=currencyFormat($pay['amount'])?></td>
            <td><?=html_escape($pay['pay_via_name'] ?: '—')?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <?php else: ?>
    <table class="pay-box">
        <tr><td class="unpaid">Tuition payment has not been recorded for this student. School fees: <?=currencyFormat(isset($tuition['fee']) ? $tuition['fee'] : get_school_fee_amount())?></td></tr>
    </table>
    <?php endif; ?>

    <table class="codes">
        <tr>
            <td style="width:30%">
                <img class="qr" src="<?=html_escape($qr_src)?>" alt="QR">
                <div class="code-label">Scan to verify</div>
            </td>
            <td>
                <?php if ($is_pdf): ?>
                    <barcode code="<?=html_escape($barcode_value)?>" type="C128B" size="0.9" height="0.7" />
                <?php else: ?>
                    <?=$barcode_html?>
                <?php endif; ?>
                <div class="code-value"><?=html_escape($barcode_value)?></div>
                <div class="code-label">Student barcode</div>
            </td>
        </tr>
    </table>

    <table class="signs">
        <tr>
            <td>
                <div class="sign-line"></div>
                Parent / Guardian
            </td>
            <td>
                <div class="sign-line"></div>
                Admissions Officer
            </td>
        </tr>
    </table>
    <div class="note">This slip is issued by <?=html_escape($school)?>. Keep it for your records. Present it when collecting the student ID card or on request by the academy.</div>
</div>

<?php if (!$is_pdf): ?>
<div id="slipShareModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,20,.45);z-index:10050;align-items:center;justify-content:center;padding:16px;">
	<div style="background:#fff;max-width:500px;width:100%;border-top:4px solid #0f5c4c;border-radius:6px;box-shadow:0 12px 40px rgba(0,0,0,.2);padding:20px 24px;text-align:left;">
		<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
			<h4 style="margin:0;color:#0f5c4c;font-weight:700;font-size:17px;"><i class="fab fa-whatsapp" style="color:#25D366;margin-right:6px;"></i> Send Slip / Receipt to Parent</h4>
			<button type="button" id="slipShareCloseTop" style="border:none;background:transparent;font-size:24px;line-height:1;color:#888;cursor:pointer;">&times;</button>
		</div>
		<p style="margin:0 0 12px;color:#555;font-size:13px;">Send admission slip details directly to the parent's WhatsApp number. You can also download or send the official PDF or Image slip directly into WhatsApp chat.</p>

		<div style="background:#f4f7f5;border:1px solid #d2ded7;border-radius:4px;padding:10px 12px;margin-bottom:14px;font-size:13px;">
			<div style="font-weight:600;color:#0f5c4c;margin-bottom:5px;">Parent / Guardian WhatsApp Number:</div>
			<div id="slipSharePhoneWrap" style="display:flex;flex-wrap:wrap;gap:6px;align-items:center;">
				<span id="slipSharePhoneDisplay" style="font-family:monospace;font-size:14px;font-weight:700;color:#1a1a1a;">Loading…</span>
			</div>
		</div>

		<div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:10px;">
			<a id="slipShareDirectWa" href="#" target="_blank" rel="noopener" style="background:#25D366;color:#fff;border-radius:4px;font-weight:700;padding:8px 14px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;font-size:13px;">
				<i class="fab fa-whatsapp" style="font-size:16px;"></i> Send on WhatsApp
			</a>
			<button type="button" id="slipSharePdf" style="background:#c9a227;color:#1a1a1a;border:none;border-radius:4px;font-weight:700;padding:8px 14px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;font-size:13px;"><i class="fas fa-file-pdf"></i> PDF Slip</button>
			<button type="button" id="slipShareImage" style="background:#c9a227;color:#1a1a1a;border:none;border-radius:4px;font-weight:700;padding:8px 14px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;font-size:13px;"><i class="fas fa-image"></i> Image Slip</button>
			<button type="button" id="slipShareClose" style="background:#e5e7eb;color:#374151;border:none;border-radius:4px;font-weight:600;padding:8px 14px;cursor:pointer;font-size:13px;">Close</button>
		</div>

		<p id="slipShareStatus" style="margin:8px 0 0;color:#0f5c4c;font-size:12.5px;font-weight:500;min-height:18px;"></p>

		<div id="slipShareMessageWrap" style="display:none;margin-top:12px;">
			<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
				<span style="font-size:12px;color:#666;font-weight:600;">Message Caption:</span>
				<button type="button" id="slipShareCopyMsg" style="background:#f3f4f6;border:1px solid #d1d5db;border-radius:3px;font-size:11px;padding:3px 8px;cursor:pointer;"><i class="far fa-copy"></i> Copy text</button>
			</div>
			<pre id="slipShareMessage" style="white-space:pre-wrap;background:#fdfcf6;border:1px solid #e4d7a4;padding:10px;margin:0;font-size:12px;color:#1a1a1a;max-height:160px;overflow-y:auto;font-family:inherit;"></pre>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function () {
	var base_url = "<?=base_url()?>";
	var enrollID = "<?=$slip['enrollid']?>";
	var slipShareCurrentData = null;
	var slipShareSelectedPhone = "";

	function slipShareBytes(b64) {
		var bin = atob(b64);
		var len = bin.length;
		var bytes = new Uint8Array(len);
		for (var i = 0; i < len; i++) {
			bytes[i] = bin.charCodeAt(i);
		}
		return bytes;
	}

	function slipShareDownload(data) {
		if (!data || !data.file || !data.filename) return;
		var blob = new Blob([slipShareBytes(data.file)], { type: data.mime || 'application/octet-stream' });
		var a = document.createElement('a');
		a.href = URL.createObjectURL(blob);
		a.download = data.filename;
		document.body.appendChild(a);
		a.click();
		setTimeout(function () {
			URL.revokeObjectURL(a.href);
			$(a).remove();
		}, 500);
	}

	function slipShareBuildWaLink(phone, message) {
		return 'https://api.whatsapp.com/send?phone=' + encodeURIComponent(phone) + '&text=' + encodeURIComponent(message || '');
	}

	function slipShareSelectPhone(phone) {
		slipShareSelectedPhone = phone;
		$('#slipSharePhoneWrap .fee-phone-btn').each(function () {
			var $b = $(this);
			if (String($b.data('phone')) === String(phone)) {
				$b.css({ background: '#0f5c4c', color: '#fff' });
			} else {
				$b.css({ background: '#fff', color: '#0f5c4c' });
			}
		});
		if (slipShareCurrentData) {
			var wa = slipShareBuildWaLink(phone, slipShareCurrentData.message);
			$('#slipShareDirectWa').attr('href', wa).attr('target', '_blank');
			if (phone) {
				$('#slipShareDirectWa').css('opacity', '1').css('pointer-events', 'auto').html('<i class="fab fa-whatsapp" style="font-size:16px;"></i> Send on WhatsApp (+' + phone + ')');
			} else {
				$('#slipShareDirectWa').css('opacity', '0.6').css('pointer-events', 'none').html('<i class="fab fa-whatsapp" style="font-size:16px;"></i> Send on WhatsApp');
			}
		}
	}

	function slipShareAsk() {
		slipShareCurrentData = null;
		slipShareSelectedPhone = '';
		$('#slipShareStatus').text('Loading parent WhatsApp details…');
		$('#slipShareMessageWrap').hide();
		$('#slipShareMessage').text('');
		$('#slipSharePhoneWrap').html('<span id="slipSharePhoneDisplay" style="font-family:monospace;font-size:14px;font-weight:700;color:#1a1a1a;">Loading…</span>');
		$('#slipShareDirectWa').attr('href', '#').css('opacity', '0.6').css('pointer-events', 'none').html('<i class="fab fa-whatsapp" style="font-size:16px;"></i> Send on WhatsApp');
		$('#slipSharePdf, #slipShareImage').prop('disabled', true);
		$('#slipShareModal').css('display', 'flex');

		var payload = { enroll_id: enrollID, format: 'summary' };
		if (typeof csrfData !== 'undefined') { payload[csrfData.token_name] = csrfData.hash; }

		$.ajax({
			url: base_url + 'student/admission_share',
			type: 'POST',
			dataType: 'json',
			data: payload,
			success: function (data) {
				if (data && data.status === 'access_denied') {
					window.location.href = base_url + 'dashboard';
					return;
				}
				if (!data || !data.ok) {
					$('#slipShareStatus').text((data && data.error) ? data.error : 'Could not prepare admission details.');
					return;
				}
				slipShareCurrentData = data;
				$('#slipShareStatus').text('');
				$('#slipSharePdf, #slipShareImage').prop('disabled', false);

				var $wrap = $('#slipSharePhoneWrap').empty();
				var phones = data.phones && data.phones.length ? data.phones : (data.phone ? [data.phone] : []);
				if (phones.length) {
					slipShareSelectedPhone = phones[0];
					for (var i = 0; i < phones.length; i++) {
						var ph = phones[i];
						var label = '+' + ph;
						if (data.guardian) label += ' (' + data.guardian + ')';
						var $btn = $('<button type="button" class="fee-phone-btn" style="border:1px solid #0f5c4c;background:#fff;color:#0f5c4c;padding:4px 9px;border-radius:4px;font-size:12px;font-family:monospace;cursor:pointer;margin-right:6px;margin-bottom:4px;">')
							.text(label)
							.data('phone', ph);
						if (i === 0) {
							$btn.css({ background: '#0f5c4c', color: '#fff' });
						}
						$btn.on('click', function () {
							slipShareSelectPhone($(this).data('phone'));
						});
						$wrap.append($btn);
					}
					slipShareSelectPhone(phones[0]);
				} else {
					$wrap.html('<span style="color:#a94442;font-size:12.5px;">No parent phone number recorded for this student.</span>');
					$('#slipShareDirectWa').css('opacity', '0.6').css('pointer-events', 'none');
				}

				if (data.message) {
					$('#slipShareMessage').text(data.message);
					$('#slipShareMessageWrap').show();
				}
			},
			error: function () {
				$('#slipShareStatus').text('Could not connect to fetch admission details.');
			}
		});
	}

	function slipShareSend(format) {
		var $status = $('#slipShareStatus');
		$status.text('Generating ' + format.toUpperCase() + ' slip…');
		$('#slipSharePdf, #slipShareImage').prop('disabled', true);

		var payload = {
			enroll_id: enrollID,
			format: format,
			phone: slipShareSelectedPhone,
			deliver: 'whatsapp'
		};
		if (typeof csrfData !== 'undefined') { payload[csrfData.token_name] = csrfData.hash; }

		$.ajax({
			url: base_url + 'student/admission_share',
			type: 'POST',
			dataType: 'json',
			data: payload,
			success: function (data) {
				if (data && data.status === 'access_denied') {
					window.location.href = base_url + 'dashboard';
					return;
				}
				if (!data || !data.ok) {
					$status.text((data && data.error) ? data.error : 'The slip could not be prepared.');
					return;
				}
				slipShareDownload(data);
				var target = slipShareSelectedPhone || data.phone;
				if (data.sent) {
					$status.html('<span style="color:green;"><i class="fas fa-check-circle"></i> Admission slip & receipt successfully attached and sent to WhatsApp for <strong>+' + target + '</strong>!</span>');
				} else if (data.whatsapp) {
					window.open(data.whatsapp, '_blank');
					$status.html('Slip downloaded! WhatsApp chat opened' + (target ? ' for <strong>+' + target + '</strong>' : '') + '. You can now attach the downloaded file in the WhatsApp chat.' + (data.error ? '<br><span style="color:#c9302c;">(Auto-send failed: ' + data.error + ')</span>' : ''));
				} else {
					$status.text('Slip downloaded successfully.');
				}
			},
			error: function () {
				$status.text('The admission slip could not be prepared.');
			},
			complete: function () {
				$('#slipSharePdf, #slipShareImage').prop('disabled', false);
			}
		});
	}

	$('#slipShareBtn').on('click', function () {
		slipShareAsk();
	});
	$('#slipSharePdf').on('click', function () { slipShareSend('pdf'); });
	$('#slipShareImage').on('click', function () { slipShareSend('image'); });
	$('#slipShareClose, #slipShareCloseTop').on('click', function () { $('#slipShareModal').hide(); });

	$('#slipShareCopyMsg').on('click', function () {
		var text = $('#slipShareMessage').text();
		if (navigator.clipboard && navigator.clipboard.writeText) {
			navigator.clipboard.writeText(text).then(function () {
				alert('Slip message copied to clipboard!');
			});
		} else {
			var $temp = $('<textarea>');
			$('body').append($temp);
			$temp.val(text).select();
			document.execCommand('copy');
			$temp.remove();
			alert('Slip message copied to clipboard!');
		}
	});
});
</script>
<?php endif; ?>
</body>
</html>
