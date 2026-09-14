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
    <a href="javascript:window.print()"><i></i> Print</a>
    <a href="<?=base_url('student/admission_slip/' . $slip['enrollid'] . '?pdf=1')?>">Download PDF</a>
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
    <?php if (!empty($tuition)): ?>
    <table class="pay-box">
        <tr>
            <th>Fee</th>
            <td><?=html_escape($tuition['fee_name'] ?: 'Tuition')?></td>
            <th>Amount Paid</th>
            <td><?=currencyFormat($tuition['amount'])?></td>
        </tr>
        <tr>
            <th>Mode of Payment</th>
            <td><?=html_escape($tuition['pay_via_name'] ?: '—')?></td>
            <th>Payment Date</th>
            <td><?=html_escape(_d($tuition['date']))?></td>
        </tr>
        <?php if (!empty($tuition['remarks'])): ?>
        <tr>
            <th>Remarks</th>
            <td colspan="3"><?=html_escape($tuition['remarks'])?></td>
        </tr>
        <?php endif; ?>
    </table>
    <?php else: ?>
    <table class="pay-box">
        <tr><td class="unpaid">Tuition payment has not been recorded for this student.</td></tr>
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
</body>
</html>
