<?php
$photo_required = !empty($photo_required);
$photo_current = isset($photo_current) ? (string) $photo_current : '';
$photo_preview = get_image_url('student', $photo_current !== '' ? $photo_current : '');
?>
<div class="js-photo-desk form-group">
	<label><?=translate('profile_picture')?><?php echo $photo_required ? ' <span class="required">*</span>' : ''; ?></label>
	<div class="photo-desk">
		<img class="photo-desk-preview" src="<?=html_escape($photo_preview)?>" alt="">
		<div class="photo-desk-actions">
			<button type="button" class="btn btn-default js-photo-file"><i class="fas fa-upload"></i> Upload</button>
			<button type="button" class="btn btn-default js-photo-camera"><i class="fas fa-camera"></i> Take photo</button>
		</div>
	</div>
	<input type="file" name="user_photo" class="js-photo-input" accept="image/jpeg,image/png,image/webp" hidden>
	<input type="file" class="js-photo-camera-input" accept="image/*" capture="user" hidden>
	<?php if ($photo_current !== ''): ?>
	<input type="hidden" name="old_user_photo" value="<?=html_escape($photo_current)?>">
	<?php endif; ?>
	<p class="photo-compress-hint text-muted">Upload a picture or take one with the camera. It is resized, kept sharp, and saved without the camera’s location.</p>
	<span class="error"><?=form_error('user_photo')?></span>
</div>
<style>
.photo-desk{display:flex;gap:16px;align-items:center;flex-wrap:wrap}
.photo-desk-preview{width:112px;height:112px;object-fit:cover;border-radius:12px;background:#e7eee9;border:1px solid #d5ddd8}
.photo-desk-actions{display:flex;gap:8px;flex-wrap:wrap}
.photo-desk-actions .btn{min-height:40px}
.photo-compress-hint{margin:.55rem 0 0;font-size:.85rem}
@media (max-width:767px){
	.photo-desk{align-items:flex-start}
	.photo-desk-actions{width:100%}
	.photo-desk-actions .btn{flex:1 1 140px}
	.student-profile-save .col-md-offset-9,
	.student-profile-save .col-md-3{width:100%;margin-left:0;float:none}
	.student-profile-actions{text-align:left}
	.student-profile-actions .btn{display:block;width:100%;margin:0 0 8px}
}
</style>
