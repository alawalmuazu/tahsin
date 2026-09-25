<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri+Quran&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
<style>
.ls-modal .modal-dialog{width:96%;max-width:1100px}
.ls-grid{display:grid;grid-template-columns:1fr 1.15fr;gap:1.25rem}
@media(max-width:900px){.ls-grid{grid-template-columns:1fr}}
.ls-card{background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;margin-bottom:.85rem}
.ls-title{font-weight:700;font-size:.95rem;margin:0 0 .65rem}
.ls-muted{color:#64748b;font-size:.78rem}
.ls-avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#0284c7,#0369a1);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;flex-shrink:0;overflow:hidden}
.ls-avatar img{width:100%;height:100%;object-fit:cover;display:block}
.ls-student-selected,.ls-student-row{display:flex;gap:.75rem;align-items:center}
.ls-student-row{width:100%;text-align:left;border:1px solid #e2e8f0;background:#fff;border-radius:10px;padding:.55rem .7rem;margin-bottom:.4rem}
.ls-student-row.active,.ls-student-row:hover{border-color:#0284c7;background:#eff6ff}
.ls-chip{display:inline-block;border:1px solid #e2e8f0;background:#fff;border-radius:8px;padding:.35rem .65rem;margin:0 .35rem .35rem 0;font-size:.78rem;cursor:pointer}
.ls-chip:hover{border-color:#0284c7;color:#0284c7}
.ls-chip.active{border-color:#0284c7;background:#e0f2fe;color:#0369a1}
.ls-chip-audio{border-color:#86efac;background:#f0fdf4}
.ls-history-list{max-height:220px;overflow:auto;padding:.15rem .15rem .15rem .35rem}
.ls-timeline{position:relative;padding-left:1.35rem}
.ls-timeline:before{content:"";position:absolute;left:7px;top:4px;bottom:4px;width:2px;background:#e2e8f0}
.ls-tl-item{position:relative;margin:0 0 .55rem;border:0;background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.55rem .7rem;width:100%;text-align:left;cursor:pointer;display:block}
.ls-tl-item:hover,.ls-tl-item.active{border-color:#0284c7;background:#eff6ff}
.ls-tl-item.has-audio{border-color:#86efac}
.ls-tl-dot{position:absolute;left:-1.2rem;top:.7rem;width:12px;height:12px;border-radius:3px;background:#cbd5e1;border:2px solid #fff;box-sizing:border-box}
.ls-tl-item.active .ls-tl-dot,.ls-tl-item.has-audio .ls-tl-dot{background:#10b981}
.ls-tl-top{display:flex;justify-content:space-between;gap:.5rem;align-items:baseline}
.ls-tl-title{font-weight:700;font-size:.85rem;color:#0f172a}
.ls-tl-date{font-weight:700;font-size:.78rem;color:#334155;white-space:nowrap}
.ls-tl-meta{font-size:.72rem;color:#64748b;margin-top:.2rem}
.ls-tl-badges{margin-top:.3rem;display:flex;flex-wrap:wrap;gap:.25rem}
.ls-tl-badge{font-size:.65rem;padding:1px 6px;border-radius:6px;background:#f1f5f9;color:#475569}
.ls-tl-badge.ok{background:rgba(16,185,129,.12);color:#059669}
.ls-tl-badge.warn{background:rgba(245,158,11,.14);color:#b45309}
.ls-note{font-size:.78rem;color:#475569;margin-top:.35rem;font-style:italic}
.ls-mushaf-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.45rem;margin:.25rem 0 .35rem}
.ls-mushaf-chrome{display:inline-flex;flex-wrap:wrap;gap:.35rem;align-items:center}
.ls-mushaf-chrome .ls-pill{display:inline-block;padding:3px 10px;border-radius:9999px;background:#fff;color:#334155;font-size:.72rem;font-weight:600;border:1px solid #e2e8f0;letter-spacing:.01em}
.ls-mushaf-chrome .ls-pill-join{color:#475569}
.ls-theme-toggle{display:inline-flex;gap:0;border:1px solid #e2e8f0;border-radius:9999px;overflow:hidden;background:#fff}
.ls-theme-toggle button{border:0;background:transparent;padding:3px 10px;font-size:.68rem;font-weight:700;color:#64748b;cursor:pointer}
.ls-theme-toggle button.active{background:#0f172a;color:#fff}
.ls-arabic{direction:rtl;text-align:justify;font-size:1.72rem;line-height:2.85;font-family:"Amiri Quran","Amiri","Scheherazade New","Traditional Arabic",serif;background:#fffef8;color:#111827;border:1px solid #e7e5e4;border-radius:12px;padding:1rem 1.15rem 1.25rem;min-height:160px;max-height:360px;overflow:auto;box-shadow:inset 0 0 0 1px rgba(255,255,255,.6),0 1px 2px rgba(15,23,42,.04)}
.ls-arabic.ls-arabic--night{background:#0b1220;color:#f1f5f9;border-color:#1e293b;box-shadow:none}
.ls-surah-banner{display:block;text-align:center;margin:0 auto .85rem;padding:.45rem .75rem;border:2px solid #1f2937;border-radius:4px;background:linear-gradient(180deg,#fafaf9,#f5f5f4);font-family:"Amiri","Amiri Quran",serif;font-size:1.15rem;font-weight:700;color:#111827;letter-spacing:.02em}
.ls-arabic--night .ls-surah-banner{border-color:#94a3b8;background:linear-gradient(180deg,#1e293b,#0f172a);color:#f8fafc}
.ls-bismillah{display:block;text-align:center;margin:0 0 .75rem;font-size:1.35rem;color:#1f2937;font-family:"Amiri Quran","Amiri",serif}
.ls-arabic--night .ls-bismillah{color:#e2e8f0}
.ls-ayah{display:inline;padding:.08rem 0;border-radius:4px}
.ls-ayah-active{background:rgba(254,243,199,.55)}
.ls-arabic--night .ls-ayah-active{background:rgba(56,189,248,.12)}
.ls-ayah-num{display:inline-flex;align-items:center;justify-content:center;width:1.4em;height:1.4em;margin:0 .15rem 0 .3rem;border-radius:50%;border:1.5px solid #78716c;color:#44403c;font-size:.7rem;font-weight:700;font-family:system-ui,sans-serif;line-height:1;vertical-align:middle;background:#fff;box-shadow:inset 0 0 0 1px #e7e5e4}
.ls-arabic--night .ls-ayah-num{background:#1e293b;border-color:#64748b;color:#cbd5e1;box-shadow:none}
.ls-word{display:inline;padding:0 1px;margin:0 1px;border-radius:3px;border:none;background:transparent;transition:background .15s,color .15s,box-shadow .15s}
.ls-letter{display:inline-block;border-radius:4px}
.ls-letter-0{color:#1d4ed8 !important;background:#dbeafe}
.ls-letter-1{color:#0f766e !important;background:#ccfbf1}
.ls-letter-2{color:#c2410c !important;background:#ffedd5}
.ls-letter-3{color:#7e22ce !important;background:#f3e8ff}
.ls-vowel{color:#ea580c !important;font-weight:700}
.ls-fatha{color:#ea580c !important}
.ls-kasra{color:#1d4ed8 !important}
.ls-damma{color:#be123c !important}
.ls-shadda{color:#7c3aed !important}
.ls-sukun{color:#0f766e !important}
.ls-word-muraja{color:#1d4ed8 !important}
.ls-wasl{color:#1d4ed8 !important;background:#dbeafe;border-radius:3px;font-weight:700}
.ls-word-matched{color:#047857;background:transparent}
.ls-word-active{color:#064e3b;background:#cfffea;box-shadow:inset 0 -2px 0 #34d399;font-weight:700}
.ls-word-mistake{color:#be123c;background:rgba(244,63,94,.14);box-shadow:inset 0 -2px 0 #f43f5e}
.ls-arabic--night .ls-word-matched{color:#34d399}
.ls-arabic--night .ls-word-active{color:#ecfdf5;background:rgba(16,185,129,.28);box-shadow:inset 0 -2px 0 #34d399}
.ls-arabic--night .ls-word-mistake{color:#fb7185;background:rgba(244,63,94,.22)}
.ls-ayah-done .ls-word:not(.ls-word-mistake):not(.ls-word-active){color:#047857}
.ls-arabic--night .ls-ayah-done .ls-word:not(.ls-word-mistake):not(.ls-word-active){color:#34d399}
.ls-highlight-banner{display:inline-flex;align-items:center;gap:.35rem;font-size:.72rem;font-weight:600;color:#f8fafc;margin:.2rem 0 .35rem;padding:5px 12px;border-radius:9999px;background:#111827;border:0;box-shadow:0 2px 8px rgba(15,23,42,.18)}
.ls-progress-strip{font-size:.75rem;font-weight:700;color:#0f766e;margin:0 0 .35rem}
.ls-ico{width:1.1em;height:1.1em;display:inline-block;vertical-align:-.15em;flex-shrink:0}
.ls-tool-btn .ls-ico{width:18px;height:18px}
.ls-tool-btn.ls-tool-mic .ls-ico{width:22px;height:22px;stroke:#fff}
.ls-tool-btn.ls-tool-mic.is-live .ls-ico{stroke:#fff}
.ls-tool-btn.active .ls-ico{stroke:#fff}
.ls-btn-with-ico{display:inline-flex!important;align-items:center;gap:.4rem}
.ls-footer-pill .ls-ico{width:14px;height:14px;stroke:#475569}
.ls-footer-pill-flame .ls-ico{stroke:#ea580c;fill:#fb923c}
.ls-title .ls-ico{margin-right:.3rem;stroke:#0f766e}
.ls-icon-btn{width:36px;height:36px;border-radius:50%;border:1px solid #bfdbfe;background:#eff6ff;color:#0369a1;display:inline-flex;align-items:center;justify-content:center;padding:0;cursor:pointer;box-shadow:0 1px 2px rgba(15,23,42,.06)}
.ls-icon-btn:hover{background:#dbeafe;border-color:#93c5fd}
.ls-icon-btn .ls-ico{width:16px;height:16px;stroke:currentColor}
.ls-tl-badge.ok{display:inline-flex;align-items:center;gap:3px}
.ls-tl-badge .ls-ico{width:11px;height:11px;stroke:currentColor}
.ls-btn-live .ls-ico{width:16px;height:16px;stroke:#fff;margin-right:.15rem}
.ls-actions .btn .ls-ico{width:14px;height:14px;stroke:currentColor;margin-right:.25rem}
.ls-tool-btn{width:40px;height:40px;border-radius:50%;border:1px solid #e5e7eb;background:#fff;color:#111827;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 1px 4px rgba(15,23,42,.08);font-size:1rem;line-height:1;padding:0;position:relative}
.ls-tool-btn:hover,.ls-tool-btn:focus{border-color:#9ca3af;background:#f9fafb;z-index:3}
.ls-tool-btn.active{background:#111827;border-color:#111827;color:#fff}
.ls-tool-btn.ls-tool-mic{width:56px;height:56px;background:linear-gradient(145deg,#4ade80,#16a34a 55%,#eab308);border:0;color:#fff;box-shadow:0 8px 22px rgba(22,163,74,.45),0 0 0 4px rgba(74,222,128,.2)}
.ls-tool-btn.ls-tool-mic:hover,.ls-tool-btn.ls-tool-mic:focus{filter:brightness(1.05);color:#fff}
.ls-tool-btn.ls-tool-mic.is-live{background:linear-gradient(145deg,#f87171,#dc2626);box-shadow:0 8px 22px rgba(220,38,38,.4),0 0 0 4px rgba(248,113,113,.2)}
.ls-tip[data-tip]{position:relative}
.ls-tip[data-tip]::after{content:attr(data-tip);position:absolute;left:50%;bottom:calc(100% + 8px);transform:translateX(-50%) translateY(4px);background:#111827;color:#fff;font-size:.68rem;font-weight:700;line-height:1.2;padding:5px 9px;border-radius:8px;white-space:nowrap;opacity:0;pointer-events:none;transition:opacity .12s ease,transform .12s ease;box-shadow:0 4px 14px rgba(15,23,42,.25);z-index:20}
.ls-tip[data-tip]::before{content:"";position:absolute;left:50%;bottom:calc(100% + 2px);transform:translateX(-50%) translateY(4px);border:5px solid transparent;border-top-color:#111827;opacity:0;pointer-events:none;transition:opacity .12s ease,transform .12s ease;z-index:20}
.ls-tip[data-tip]:hover::after,.ls-tip[data-tip]:focus::after,.ls-tip[data-tip]:hover::before,.ls-tip[data-tip]:focus::before{opacity:1;transform:translateX(-50%) translateY(0)}
.ls-footer-pill.ls-tip[data-tip]::after{bottom:auto;top:calc(100% + 8px)}
.ls-footer-pill.ls-tip[data-tip]::before{bottom:auto;top:calc(100% + 0px);border-top-color:transparent;border-bottom-color:#111827}
.ls-mushaf-footer{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.55rem;margin:.65rem 0 .15rem;padding:.55rem .15rem 0;border-top:1px solid #e2e8f0;overflow:visible}
.ls-footer-pills{display:inline-flex;flex-wrap:wrap;align-items:center;gap:.4rem}
.ls-footer-pill{display:inline-flex;align-items:center;gap:.35rem;padding:6px 12px;border-radius:9999px;background:#fff;border:1px solid #e5e7eb;box-shadow:0 1px 3px rgba(15,23,42,.06);font-size:.72rem;font-weight:700;color:#334155;cursor:pointer}
.ls-footer-pill:hover{border-color:#94a3b8;background:#f8fafc}
.ls-footer-tools{display:inline-flex;flex-wrap:wrap;align-items:center;gap:.45rem;overflow:visible;padding-top:.55rem}
.ls-arabic.ls-arabic--hidden .ls-word,.ls-arabic.ls-arabic--hidden .ls-ayah-num,.ls-arabic.ls-arabic--hidden .ls-bismillah{filter:blur(7px);user-select:none;opacity:.55}
.ls-arabic.ls-arabic--hidden .ls-surah-banner{opacity:.9;filter:none}
.ls-streak-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:9999px;background:#fff7ed;border:1px solid #fdba74;color:#c2410c;font-size:.7rem;font-weight:800;margin-left:.35rem}
.ls-streak-badge .ls-ico{width:12px;height:12px;stroke:#ea580c;fill:#fb923c}
.ls-live-row{display:flex;flex-wrap:wrap;align-items:center;gap:.55rem;margin:.55rem 0 .25rem}
.ls-btn-live{background:linear-gradient(180deg,#22c55e,#16a34a)!important;border-color:#15803d!important;color:#fff!important;font-weight:800!important;padding:.55rem 1.1rem!important;border-radius:9999px!important;box-shadow:0 4px 14px rgba(22,163,74,.35);min-width:200px}
.ls-btn-live:hover,.ls-btn-live:focus{filter:brightness(1.05);color:#fff!important}
.ls-engine-select{border-radius:9999px!important;border-color:#cbd5e1!important;background:#fff!important;color:#64748b!important;font-size:.75rem!important;max-width:150px}
.ls-playback-bar{background:#ecfdf5;border:1px solid #86efac;border-radius:10px;padding:.55rem .7rem;margin-top:.5rem}
.ls-playback-bar strong{color:#059669;font-size:.85rem;display:block}
.ls-playback-actions{display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.45rem}
.ls-playback-actions .btn{margin:0;font-size:.75rem;font-weight:600}
.ls-btn-download{background:#e0f2fe;border-color:#7dd3fc;color:#0369a1}
.ls-btn-download:hover,.ls-btn-download:focus{background:#bae6fd;border-color:#38bdf8;color:#0c4a6e}
.ls-btn-rerecord{background:#f8fafc;border-color:#cbd5e1;color:#475569}
.ls-btn-rerecord:hover,.ls-btn-rerecord:focus{background:#f1f5f9;border-color:#94a3b8;color:#334155}
.ls-cat-grid{display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.35rem}
.ls-cat-chip{border:1px solid #cbd5e1;background:#fff;color:#334155;border-radius:8px;padding:6px 10px;font-size:.72rem;font-weight:700;cursor:pointer;line-height:1.2}
.ls-cat-chip.active{background:#0f766e;border-color:#0f766e;color:#fff}
.ls-cat-box{margin:.55rem 0;padding:.65rem;border:2px solid #f59e0b;background:#fffbeb;border-radius:10px}
.ls-cat-box.ok{border-color:#10b981;background:#ecfdf5}
.ls-cat-hint{font-size:.72rem;color:#b45309;margin-top:.35rem;font-weight:600}
.ls-cat-hint.ok{color:#059669}
.ls-tl-cat{display:inline-block;margin-top:2px;font-size:.65rem;font-weight:700;color:#0f766e}
#ls_continue_next:disabled,#ls_btn_save_milestone:disabled{opacity:.55;cursor:not-allowed}
.ls-actions{display:flex;flex-wrap:wrap;gap:.4rem;margin:.5rem 0}
.ls-actions .btn{margin:0}
#ls_video_preview{width:100%;max-height:180px;border-radius:10px;background:#000;margin-top:.5rem}
#ls_audio_player{width:100%;margin-top:.35rem;display:block}
.ls-kpi{display:flex;justify-content:space-between;align-items:center;gap:.5rem;margin-bottom:.5rem}
.ls-kpi strong{color:#0284c7;font-size:1.05rem}
.ls-engine-pill{display:inline-flex;align-items:center;gap:6px;padding:3px 10px;border-radius:9999px;background:#f1f5f9;border:1px solid #e2e8f0;font-size:.75rem;font-weight:600;color:#64748b;margin-top:.35rem}
.ls-engine-pill.live{background:rgba(16,185,129,.12);border-color:rgba(16,185,129,.35);color:#059669}
.ls-engine-pill.connecting{background:rgba(245,158,11,.12);border-color:rgba(245,158,11,.35);color:#d97706}
.ls-engine-pill.down{background:rgba(244,63,94,.08);border-color:rgba(244,63,94,.25);color:#e11d48}
.ls-engine-dot{width:8px;height:8px;border-radius:50%;background:#94a3b8;flex-shrink:0}
.ls-engine-pill.live .ls-engine-dot{background:#10b981;box-shadow:0 0 8px #10b981}
.ls-engine-pill.connecting .ls-engine-dot{background:#f59e0b;box-shadow:0 0 8px #f59e0b}
.ls-engine-pill.down .ls-engine-dot{background:#f43f5e}
</style>

<div class="modal fade ls-modal" id="academyLogModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?php echo form_open_multipart(base_url('academy_students')); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title">Log Completed Quranic Recitation</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="student_id" id="ls_student_id" value="">
				<input type="hidden" name="surah_number" id="ls_surah_number" value="1">
				<input type="hidden" name="milestone_id" id="ls_milestone_id" value="">
				<input type="hidden" name="accuracy_score" id="ls_accuracy_score" value="">
				<input type="hidden" name="mistake_word_count" id="ls_mistake_word_count" value="0">
				<input type="hidden" name="recitation_seconds" id="ls_recitation_seconds" value="0">
				<input type="hidden" name="mistake_breakdown" id="ls_mistake_breakdown" value="">
				<input type="hidden" name="page_from" id="ls_page_from" value="">
				<input type="hidden" name="page_to" id="ls_page_to" value="">
				<input type="file" name="audio_file" id="ls_audio_file" accept="audio/*,video/*" style="display:none">
				<input type="hidden" name="audio_file_b64" id="ls_audio_b64" value="">

				<div class="ls-grid">
					<!-- LEFT -->
					<div>
						<div class="ls-card">
							<div class="ls-title">Select Enrolled Student <span class="required">*</span>
								<span class="ls-muted" id="ls_enrolled_count" style="float:right;font-weight:500"></span>
							</div>
							<div id="ls_student_selected" class="ls-student-selected" style="display:none">
								<span class="ls-avatar" id="ls_sel_avatar">?</span>
								<div style="flex:1;min-width:0">
									<div id="ls_sel_name" style="font-weight:700"></div>
									<div class="ls-muted" id="ls_sel_meta"></div>
								</div>
								<button type="button" class="btn btn-default btn-xs" id="ls_change_student">Change</button>
							</div>
							<div id="ls_student_picker">
								<input type="text" id="ls_student_search" class="form-control input-sm" placeholder="Search enrolled students…">
								<div id="ls_student_list" style="margin-top:.5rem;max-height:180px;overflow:auto"></div>
								<p class="ls-muted" style="margin:.5rem 0 0">To onboard a new student, visit the Students roster and click Enroll Student.</p>
							</div>
						</div>

						<div class="ls-card">
							<div class="ls-title"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg> Recitation Milestone History
								<span class="ls-muted" id="ls_history_count" style="float:right;font-weight:500">0 Recorded</span>
							</div>
							<div id="ls_prev_milestone"></div>
							<div class="ls-cat-box" id="ls_cat_box">
								<div class="ls-title" style="font-size:.82rem;margin:0 0 .25rem">Recitation Category <span style="color:#dc2626">*</span> <span class="ls-muted" style="font-weight:500">compulsory</span></div>
								<input type="hidden" name="recitation_category" id="ls_recitation_category" value="" required>
								<div class="ls-cat-grid" id="ls_cat_grid">
									<?php
									$cats = isset($recitation_categories) ? $recitation_categories : array();
									foreach ($cats as $ck => $clabel):
									?>
									<button type="button" class="ls-cat-chip" data-cat="<?php echo html_escape($ck); ?>"><?php echo html_escape($clabel); ?></button>
									<?php endforeach; ?>
								</div>
								<div class="ls-cat-hint" id="ls_cat_hint">Select a category to unlock Continue Next Ayah and Save.</div>
							</div>
							<button type="button" class="btn btn-primary btn-sm" id="ls_continue_next" style="display:none;margin:.5rem 0" disabled></button>
							<div class="ls-muted" style="margin:.35rem 0">Milestone timeline — click a card to load or play:</div>
							<div class="ls-history-list" id="ls_history_list"></div>
						</div>

						<div class="ls-card">
							<div class="ls-title">Surah Name * <span class="ls-muted" style="font-weight:500">114 Surahs Available</span></div>
							<input type="text" id="ls_surah_search" class="form-control" placeholder="Search 114 Surahs (e.g. Hud, Yunus, 11, Al-Kahf)…">
							<div id="ls_surah_results" style="margin-top:.5rem"></div>
							<div class="row" style="margin-top:.65rem">
								<div class="col-xs-6">
									<label class="control-label">Portion mode</label>
									<select name="portion_mode" id="ls_portion_mode" class="form-control input-sm">
										<?php foreach ($portion_modes as $key => $label): ?>
										<option value="<?php echo html_escape($key); ?>"><?php echo html_escape($label); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-xs-3">
									<label class="control-label">Ayah from</label>
									<input type="number" name="ayah_from" id="ls_ayah_from" class="form-control input-sm" min="1" value="1">
								</div>
								<div class="col-xs-3">
									<label class="control-label">Ayah to</label>
									<input type="number" name="ayah_to" id="ls_ayah_to" class="form-control input-sm" min="1" value="7">
								</div>
							</div>
							<div class="ls-muted" id="ls_surah_selected_label" style="margin-top:.4rem">1. Al-Fatihah (Ayahs 1 – 7)</div>
						</div>

						<div class="ls-card">
							<div class="ls-title">Akhlaq &amp; Adab Note (Optional)</div>
							<textarea name="akhlaq_note" id="ls_akhlaq" class="form-control" rows="3" placeholder="e.g. Flawless tajweed, exceptional adab and reverence during recitation…"></textarea>
						</div>
					</div>

					<!-- RIGHT -->
					<div>
						<div class="ls-card">
							<div class="ls-title"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="11" rx="3"/><path d="M5 11a7 7 0 0 0 14 0"/><path d="M12 18v3"/><path d="M8 21h8"/></svg> Proof recording</div>
							<p class="ls-muted">Record Voice stores proof of recitation with the milestone (no AI). Live check = green mic below.</p>
							<div class="ls-actions">
								<button type="button" class="btn btn-default btn-sm ls-btn-with-ico" id="ls_btn_start_audio"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="11" rx="3"/><path d="M5 11a7 7 0 0 0 14 0"/><path d="M12 18v3"/><path d="M8 21h8"/></svg> Record Voice</button>
								<button type="button" class="btn btn-danger btn-sm ls-btn-with-ico" id="ls_btn_stop" style="display:none"><svg class="ls-ico" viewBox="0 0 24 24" fill="currentColor" stroke="none"><rect x="6" y="6" width="12" height="12" rx="1"/></svg> Stop</button>
							</div>
							<video id="ls_video_preview" playsinline style="display:none"></video>
							<button type="button" id="ls_btn_start_video" style="display:none" aria-hidden="true" tabindex="-1"></button>
							<button type="button" id="ls_btn_live" style="display:none" aria-hidden="true" tabindex="-1"></button>
							<button type="button" id="ls_btn_session_sound" style="display:none" aria-hidden="true" tabindex="-1"></button>
							<div id="ls_playback_bar" class="ls-playback-bar" style="display:none">
								<strong id="ls_playback_title">Playing audio</strong>
								<audio id="ls_audio_player" controls></audio>
								<div class="ls-playback-actions">
									<button type="button" class="btn btn-default btn-sm ls-btn-download ls-btn-with-ico" id="ls_btn_download_audio"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Download</button>
									<button type="button" class="btn btn-default btn-sm ls-btn-rerecord ls-btn-with-ico" id="ls_btn_rerecord"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg> Re-record</button>
								</div>
							</div>
							<div class="ls-muted" id="ls_rec_status">Proof recorder ready · green mic = live AI check · speaker = Alafasy listen-along</div>
						</div>

						<div class="ls-card">
							<div class="ls-title"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg> Live AI &amp; Mushaf</div>
							<p class="ls-muted">Green mic = start/stop live AI while they recite. Listen along = Alafasy (model), not the student. Play saved audio = hear a clip already on a milestone.</p>
							<div class="ls-kpi">
								<div>
									<div class="ls-muted">Engine</div>
									<div id="ls_engine_pill" class="ls-engine-pill">
										<span class="ls-engine-dot" id="ls_engine_dot"></span>
										<span id="ls_engine_label">Cloud preferred · local fallback</span>
									</div>
									<div id="ls_surah_selected_label2" class="ls-muted" style="margin-top:.25rem"></div>
									<div class="ls-muted" id="ls_token_preview" style="font-size:.7rem"></div>
								</div>
								<strong id="ls_accuracy_live">100% Accuracy · 00:00</strong>
							</div>
							<div class="ls-mushaf-toolbar">
								<div id="ls_mushaf_chrome" class="ls-mushaf-chrome" style="display:none"></div>
								<select id="ls_text_format" class="form-control input-sm" style="width:auto;max-width:220px" aria-label="Uthmani text format">
									<option value="novice">Novice — letter and vowel</option>
									<option value="beginner">Beginner — vowels marked</option>
									<option value="medium" selected>Medium — Uthmani</option>
									<option value="advanced">Advanced — mushaf line</option>
									<option value="muraja">Muraja'a — letters only</option>
								</select>
								<div class="ls-theme-toggle" role="group" aria-label="Mushaf theme">
									<button type="button" id="ls_theme_paper" class="active" data-theme="paper">Paper</button>
									<button type="button" id="ls_theme_night" data-theme="night">Night</button>
								</div>
							</div>
							<div class="ls-highlight-banner" id="ls_highlight_banner">Highlight Mistakes: Enabled · word aligner idle</div>
							<div class="ls-progress-strip" id="ls_progress_strip" style="display:none">0 matched · 100%</div>
							<div class="ls-muted" id="ls_timer" style="display:none"></div>
							<div class="ls-arabic" id="ls_arabic_text" lang="ar" dir="rtl"></div>
							<audio id="ls_reciter_audio" preload="none" style="display:none"></audio>
							<div class="ls-mushaf-footer">
								<div class="ls-footer-pills">
									<span class="ls-footer-pill ls-tip" id="ls_pill_mistakes" data-tip="Mistakes" aria-label="Mistakes"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> <span id="ls_pill_mistakes_n">0</span></span>
									<span class="ls-footer-pill ls-tip" id="ls_pill_progress" data-tip="Progress" aria-label="Progress">0 /pg | 100%</span>
									<span class="ls-footer-pill ls-footer-pill-flame ls-tip" id="ls_pill_streak" style="display:none" data-tip="Day streak" aria-label="Day streak"><svg class="ls-ico" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg> <span id="ls_pill_streak_n">0</span></span>
								</div>
								<div class="ls-footer-tools">
									<button type="button" class="ls-tool-btn ls-tip" id="ls_btn_listen" data-tip="Listen along (Alafasy)" aria-label="Listen along"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg></button>
									<button type="button" class="ls-tool-btn ls-tip" id="ls_btn_hide_text" data-tip="Hide text" aria-label="Hide text"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg></button>
									<button type="button" class="ls-tool-btn ls-tip" id="ls_btn_highlight" data-tip="Highlight mistakes" aria-label="Highlight mistakes"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg></button>
									<select id="ls_engine_mode" class="form-control input-sm ls-engine-select" title="Engine" aria-label="Engine">
										<option value="auto">Auto</option>
										<option value="cloud">Cloud</option>
										<option value="local">Local</option>
									</select>
									<button type="button" class="ls-tool-btn ls-tip ls-tool-mic" id="ls_btn_live_fab" data-tip="Start/stop live recitation" aria-label="Start/stop live recitation"><svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="11" rx="3"/><path d="M5 11a7 7 0 0 0 14 0"/><path d="M12 18v3"/><path d="M8 21h8"/></svg></button>
								</div>
							</div>
							<div class="ls-actions" style="margin-top:.55rem">
								<button type="button" class="btn btn-default btn-xs" data-quick-surah="114">An-Nas (114)</button>
								<button type="button" class="btn btn-default btn-xs" data-quick-surah="113">Al-Falaq (113)</button>
								<button type="button" class="btn btn-default btn-xs" data-quick-surah="112">Al-Ikhlas (112)</button>
								<button type="button" class="btn btn-default btn-xs" data-quick-surah="1">Al-Fatihah (1)</button>
							</div>
							<div class="form-group" style="margin: .65rem 0 0">
								<label class="control-label">Optional media URL</label>
								<input type="text" name="audio_url" class="form-control input-sm" placeholder="Audio URL (optional)">
								<input type="text" name="video_url" class="form-control input-sm mt-sm" placeholder="Video URL (optional)">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" name="quick_tahfiz" id="ls_btn_save_milestone" value="1" class="btn btn-primary ls-btn-with-ico" <?php echo empty($ready) ? 'disabled' : 'disabled'; ?> title="Select a Recitation Category first">
					<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="stroke:#fff"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Save Surah Milestone
				</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<script type="application/json" id="academy-roster-json"><?php echo isset($roster_json) && $roster_json !== '' && $roster_json !== false ? $roster_json : '[]'; ?></script>
<?php
$this->config->load('tarteel', true);
$tarteelCfg = $this->config->item('tarteel', 'tarteel');
if (!is_array($tarteelCfg)) {
	$tarteelCfg = array();
}
$tarteelPublic = array(
	'engine' => isset($tarteelCfg['engine']) ? $tarteelCfg['engine'] : 'auto',
	'wsUrl' => isset($tarteelCfg['ws_url']) ? $tarteelCfg['ws_url'] : 'wss://voice-v2.tarteel.io',
	'authToken' => isset($tarteelCfg['auth_token']) ? $tarteelCfg['auth_token'] : '',
	'userId' => isset($tarteelCfg['user_id']) ? $tarteelCfg['user_id'] : '',
	'localWs' => isset($tarteelCfg['local_ws']) ? $tarteelCfg['local_ws'] : 'ws://127.0.0.1:8001/v1/recite/stream',
	'localHealth' => isset($tarteelCfg['local_health']) ? $tarteelCfg['local_health'] : 'http://127.0.0.1:8001/health',
	// Same-origin proxy → VPS (or local :8001) — avoids HTTPS mixed-content blocks
	'localFinal' => base_url('academy_students/tarteel_final'),
	'isDualModel' => !isset($tarteelCfg['is_dual_model']) || !empty($tarteelCfg['is_dual_model']),
	'isDiacritized' => !isset($tarteelCfg['is_diacritized']) || !empty($tarteelCfg['is_diacritized']),
	'debug' => !empty($tarteelCfg['debug']),
	'appVersion' => isset($tarteelCfg['app_version']) ? $tarteelCfg['app_version'] : '5.32.0',
);
?>
<script>
window.TARTEEL_CONFIG = <?php echo json_encode($tarteelPublic, JSON_UNESCAPED_SLASHES); ?>;
(function () {
	try {
		var el = document.getElementById('academy-roster-json');
		window.ACADEMY_ROSTER = el ? JSON.parse(el.textContent || '[]') : [];
	} catch (e) {
		window.ACADEMY_ROSTER = [];
		console.error('ACADEMY_ROSTER parse failed', e);
	}
})();
</script>
<?php
$tarteelPath = FCPATH . 'assets/js/tarteel_cloud_client.js';
$tarteelVer = is_file($tarteelPath) ? filemtime($tarteelPath) : time();
$jsPath = FCPATH . 'assets/js/academy_recitation.js';
$jsVer = is_file($jsPath) ? filemtime($jsPath) : time();
?>
<script src="<?php echo base_url('assets/js/tarteel_cloud_client.js?v=' . $tarteelVer); ?>"></script>
<script src="<?php echo base_url('assets/js/academy_recitation.js?v=' . $jsVer); ?>"></script>
