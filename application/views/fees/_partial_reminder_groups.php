<?php if (empty($groups)): ?>
<p class="text-muted" style="margin:0;">No student has a partial school-fee payment right now. A partial payment means some of the fees are paid and a balance is still left.</p>
<?php else: ?>
<?php foreach ($groups as $group):
    $guardian = trim((string) $group['guardian']);
    $childCount = count($group['children']);
?>
<article class="fee-remind-card">
    <div class="fee-remind-head">
        <strong><?php echo $guardian !== '' ? html_escape($guardian) : 'No parent linked'; ?></strong>
        <?php if ($group['phone_display'] !== ''): ?>
        <span><?php echo html_escape($group['phone_display']); ?><?php if (!empty($group['phone_from_student'])): ?> <em>student phone</em><?php endif; ?></span>
        <?php endif; ?>
        <?php if ($childCount > 1): ?>
        <span class="fee-remind-siblings"><?php echo (int) $childCount; ?> children, one WhatsApp message</span>
        <?php endif; ?>
    </div>
    <ul class="fee-remind-kids">
        <?php foreach ($group['children'] as $child): ?>
        <li>
            <div class="fee-remind-kid-name">
                <?php echo html_escape($child['name']); ?>
                <?php if ($child['register_no'] !== ''): ?><span><?php echo html_escape($child['register_no']); ?></span><?php endif; ?>
            </div>
            <?php if ($child['class_name'] !== ''): ?>
            <div class="fee-remind-class"><?php echo html_escape($child['class_name']); ?><?php if ($child['plan_label'] !== ''): ?> · <?php echo html_escape($child['plan_label']); ?><?php endif; ?></div>
            <?php endif; ?>
            <div class="fee-remind-amounts">
                <span>Fees <?php echo html_escape($child['fee_text']); ?></span>
                <span>Paid <?php echo html_escape($child['paid_text']); ?></span>
                <span class="fee-remind-left">Left <?php echo html_escape($child['balance_text']); ?></span>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php if ($group['whatsapp'] !== ''): ?>
    <a class="fee-remind-wa" href="<?php echo html_escape($group['whatsapp']); ?>" target="_blank" rel="noopener">
        <i class="fab fa-whatsapp"></i> WhatsApp parent
    </a>
    <?php else: ?>
    <p class="fee-remind-nophone">No phone is saved for this parent, so WhatsApp cannot open on their profile.</p>
    <?php endif; ?>
</article>
<?php endforeach; ?>
<?php endif; ?>
