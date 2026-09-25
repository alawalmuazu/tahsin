<?php
$phones = array();
if (isset($extra_phones) && is_array($extra_phones)) {
    $phones = $extra_phones;
} elseif (!empty($_POST['extra_phones']) && is_array($_POST['extra_phones'])) {
    $phones = $_POST['extra_phones'];
}
?>
<div id="parent-extra-phones">
<?php foreach ($phones as $phone):
    $phone = trim((string) $phone);
    if ($phone === '') {
        continue;
    }
?>
    <div class="input-group mt-xs">
        <span class="input-group-addon"><i class="fas fa-phone"></i></span>
        <input type="text" class="form-control" name="extra_phones[]" value="<?=html_escape($phone)?>" autocomplete="off" placeholder="Another phone number" />
        <span class="input-group-btn">
            <button type="button" class="btn btn-default parent-remove-phone" title="Remove"><i class="fas fa-times"></i></button>
        </span>
    </div>
<?php endforeach; ?>
</div>
<script>
(function () {
    var add = document.getElementById('add-parent-phone');
    var wrap = document.getElementById('parent-extra-phones');
    if (!add || !wrap) {
        return;
    }
    add.addEventListener('click', function () {
        var row = document.createElement('div');
        row.className = 'input-group mt-xs';
        row.innerHTML = '<span class="input-group-addon"><i class="fas fa-phone"></i></span>'
            + '<input type="text" class="form-control" name="extra_phones[]" autocomplete="off" placeholder="Another phone number" />'
            + '<span class="input-group-btn"><button type="button" class="btn btn-default parent-remove-phone" title="Remove"><i class="fas fa-times"></i></button></span>';
        wrap.appendChild(row);
        row.querySelector('input').focus();
    });
    wrap.addEventListener('click', function (event) {
        var button = event.target.closest('.parent-remove-phone');
        if (!button) {
            return;
        }
        var row = button.closest('.input-group');
        if (row) {
            row.parentNode.removeChild(row);
        }
    });
})();
</script>
