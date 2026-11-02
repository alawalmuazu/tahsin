<?php
$tpSurah = isset($tp_surah) ? (int) $tp_surah : 0;
$tpFrom = isset($tp_from) ? (int) $tp_from : 0;
$tpTo = isset($tp_to) ? (int) $tp_to : $tpFrom;
$tpAudio = isset($tp_audio) ? (string) $tp_audio : '';
$tpStates = isset($tp_states) && is_array($tp_states) ? $tp_states : array();
$tpSeconds = isset($tp_seconds) ? (int) $tp_seconds : 0;
$tpLimit = isset($tp_limit) ? (int) $tp_limit : 0;
$tpTextOnly = !empty($tp_text_only);
?>
<div class="ta-play" data-surah="<?php echo $tpSurah; ?>" data-from="<?php echo $tpFrom; ?>" data-to="<?php echo $tpTo; ?>" data-seconds="<?php echo $tpSeconds; ?>"<?php echo $tpLimit > 0 ? ' data-limit="' . $tpLimit . '"' : ''; ?>>
	<?php if (!$tpTextOnly && $tpAudio !== ''): ?>
		<audio class="ta-audio" controls preload="metadata" src="<?php echo html_escape($tpAudio); ?>" style="width:100%;max-width:420px;margin:.15rem 0 .45rem"></audio>
	<?php elseif (!$tpTextOnly): ?>
		<div class="ta-missing text-muted">No audio was attached to this recording.</div>
	<?php endif; ?>
	<div class="ta-text" dir="rtl" style="font-size:1.35rem;line-height:2.2;text-align:right;padding:.6rem .8rem;background:#f7f4ea;border-radius:8px;min-height:3rem"></div>
	<script type="application/json" class="ta-states"><?php echo json_encode($tpStates); ?></script>
</div>
