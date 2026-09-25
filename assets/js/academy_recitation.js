/**
 * Academy Log Surah — rich recitation modal (history, search, recorder, Arabic text).
 * Quran text: api.alquran.cloud.
 * Audio roles: Record Voice (proof) · green mic live AI (Tarteel) · Listen along (Alafasy) · Play saved.
 */
(function (window, document) {
  'use strict';

  var SURAHS = [
    [1,"Al-Fatihah",7],[2,"Al-Baqarah",286],[3,"Ali 'Imran",200],[4,"An-Nisa'",176],[5,"Al-Ma'idah",120],
    [6,"Al-An'am",165],[7,"Al-A'raf",206],[8,"Al-Anfal",75],[9,"At-Tawbah",129],[10,"Yunus",109],
    [11,"Hud",123],[12,"Yusuf",111],[13,"Ar-Ra'd",43],[14,"Ibrahim",52],[15,"Al-Hijr",99],
    [16,"An-Nahl",128],[17,"Al-Isra'",111],[18,"Al-Kahf",110],[19,"Maryam",98],[20,"Ta-Ha",135],
    [21,"Al-Anbiya'",112],[22,"Al-Hajj",78],[23,"Al-Mu'minun",118],[24,"An-Nur",64],[25,"Al-Furqan",77],
    [26,"Ash-Shu'ara'",227],[27,"An-Naml",93],[28,"Al-Qasas",88],[29,"Al-Ankabut",69],[30,"Ar-Rum",60],
    [31,"Luqman",34],[32,"As-Sajdah",30],[33,"Al-Ahzab",73],[34,"Saba'",54],[35,"Fatir",45],
    [36,"Ya-Sin",83],[37,"As-Saffat",182],[38,"Sad",88],[39,"Az-Zumar",75],[40,"Ghafir",85],
    [41,"Fussilat",54],[42,"Ash-Shura",53],[43,"Az-Zukhruf",89],[44,"Ad-Dukhan",59],[45,"Al-Jathiyah",37],
    [46,"Al-Ahqaf",35],[47,"Muhammad",38],[48,"Al-Fath",29],[49,"Al-Hujurat",18],[50,"Qaf",45],
    [51,"Adh-Dhariyat",60],[52,"At-Tur",49],[53,"An-Najm",62],[54,"Al-Qamar",55],[55,"Ar-Rahman",78],
    [56,"Al-Waqi'ah",96],[57,"Al-Hadid",29],[58,"Al-Mujadila",22],[59,"Al-Hashr",24],[60,"Al-Mumtahanah",13],
    [61,"As-Saff",14],[62,"Al-Jumu'ah",11],[63,"Al-Munafiqun",11],[64,"At-Taghabun",18],[65,"At-Talaq",12],
    [66,"At-Tahrim",12],[67,"Al-Mulk",30],[68,"Al-Qalam",52],[69,"Al-Haqqah",52],[70,"Al-Ma'arij",44],
    [71,"Nuh",28],[72,"Al-Jinn",28],[73,"Al-Muzzammil",20],[74,"Al-Muddaththir",56],[75,"Al-Qiyamah",40],
    [76,"Al-Insan",31],[77,"Al-Mursalat",50],[78,"An-Naba'",40],[79,"An-Nazi'at",46],[80,"'Abasa",42],
    [81,"At-Takwir",29],[82,"Al-Infitar",19],[83,"Al-Mutaffifin",36],[84,"Al-Inshiqaq",25],[85,"Al-Buruj",22],
    [86,"At-Tariq",17],[87,"Al-A'la",19],[88,"Al-Ghashiyah",26],[89,"Al-Fajr",30],[90,"Al-Balad",20],
    [91,"Ash-Shams",15],[92,"Al-Layl",21],[93,"Ad-Duha",11],[94,"Ash-Sharh",8],[95,"At-Tin",8],
    [96,"Al-'Alaq",19],[97,"Al-Qadr",5],[98,"Al-Bayyinah",8],[99,"Az-Zalzalah",8],[100,"Al-'Adiyat",11],
    [101,"Al-Qari'ah",11],[102,"At-Takathur",8],[103,"Al-'Asr",3],[104,"Al-Humazah",9],[105,"Al-Fil",5],
    [106,"Quraysh",4],[107,"Al-Ma'un",7],[108,"Al-Kawthar",3],[109,"Al-Kafirun",6],[110,"An-Nasr",3],
    [111,"Al-Masad",5],[112,"Al-Ikhlas",4],[113,"Al-Falaq",5],[114,"An-Nas",6]
  ].map(function (r) { return { number: r[0], name: r[1], ayahs: r[2] }; });

  var state = {
    students: [],
    studentId: null,
    surah: 1,
    fromAyah: 1,
    toAyah: 7,
    portion: 'FULL_SURAH',
    ayahsText: [],
    recording: false,
    mediaRecorder: null,
    chunks: [],
    stream: null,
    timer: null,
    elapsed: 0,
    audioBlob: null,
    playbackUrl: null,
    speechRec: null,
    matched: 0,
    mistakes: 0,
    liveMode: null,
    tarteelClient: null,
    tarteelEngine: null,
    engineProbe: null,
    matchedKeys: {},
    mistakesByWord: {},
    activeCoord: null,
    mushafMeta: null,
    mushafTheme: 'paper',
    textFormat: 'medium',
    surahArabicName: '',
    recitationCategory: null,
    textHidden: false,
    sessionSound: true,
    listenPlaying: false,
    listenAyah: null,
    listenWordTimer: null
  };

  var RECITATION_CATEGORIES = {
    HIFZ_FAUQ: 'Hifz Fauq',
    HIFZ_TAHT: 'Hifz Taht',
    TALQEEN: 'Talqeen',
    MURAJAA_QAREEBAH: 'Murajaa Qareebah',
    MURAJAA_BAEEDAH: 'Murajaa Baeedah',
    MUSAFFA: 'Musaffa',
    QIYAAMULLAIL: 'Qiyaamullail'
  };

  /** Tarteel-style stroke icons (24×24). */
  var ICO = {
    mic: '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="11" rx="3"/><path d="M5 11a7 7 0 0 0 14 0"/><path d="M12 18v3"/><path d="M8 21h8"/></svg>',
    stop: '<svg class="ls-ico" viewBox="0 0 24 24" fill="currentColor" stroke="none"><rect x="6" y="6" width="12" height="12" rx="1.5"/></svg>',
    speaker: '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>',
    speakerOff: '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>',
    eyeOff: '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>',
    eye: '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
    play: '<svg class="ls-ico" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="6 3 20 12 6 21 6 3"/></svg>',
    flame: '<svg class="ls-ico" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>',
    book: '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
    audio: '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>',
    arrow: '<svg class="ls-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>'
  };

  function setBtnIcon(el, name) {
    if (!el || !ICO[name]) return;
    el.innerHTML = ICO[name];
  }

  function categoryLabel(key) {
    if (!key) return '';
    var k = String(key).toUpperCase();
    return RECITATION_CATEGORIES[k] || k;
  }

  function getSelectedCategory() {
    var el = byId('ls_recitation_category');
    return el && el.value ? String(el.value).toUpperCase() : '';
  }

  function syncCategoryGate() {
    var ok = !!getSelectedCategory();
    var mid = byId('ls_milestone_id');
    var isAttach = mid && mid.value;
    var nextBtn = byId('ls_continue_next');
    var saveBtn = byId('ls_btn_save_milestone') || document.querySelector('#academyLogModal button[name="quick_tahfiz"]');
    var box = byId('ls_cat_box');
    var hint = byId('ls_cat_hint');

    if (nextBtn) {
      nextBtn.disabled = !ok;
      nextBtn.title = ok ? '' : 'Select a Recitation Category first';
    }
    if (saveBtn) {
      // Attach-audio mode may proceed without re-picking category
      saveBtn.disabled = isAttach ? false : !ok;
      saveBtn.title = saveBtn.disabled ? 'Select a Recitation Category first' : '';
    }
    if (box) box.classList.toggle('ok', ok);
    if (hint) {
      if (ok) {
        hint.textContent = 'Category: ' + categoryLabel(getSelectedCategory());
        hint.classList.add('ok');
      } else {
        hint.textContent = 'Compulsory — select a category to unlock Continue Next Ayah and Save.';
        hint.classList.remove('ok');
      }
    }
  }

  function setRecitationCategory(key, silent) {
    var k = key ? String(key).toUpperCase() : '';
    if (k && !RECITATION_CATEGORIES[k]) k = '';
    state.recitationCategory = k || null;
    var hidden = byId('ls_recitation_category');
    if (hidden) hidden.value = k;
    document.querySelectorAll('#ls_cat_grid .ls-cat-chip').forEach(function (chip) {
      chip.classList.toggle('active', chip.getAttribute('data-cat') === k);
    });
    syncCategoryGate();
  }

  function requireRecitationCategory(actionLabel) {
    var k = getSelectedCategory();
    if (k && RECITATION_CATEGORIES[k]) return true;
    syncCategoryGate();
    var hint = byId('ls_cat_hint');
    if (hint) {
      hint.textContent = 'Compulsory — select a category before ' + (actionLabel || 'continuing') + '.';
      hint.classList.remove('ok');
      if (hint.scrollIntoView) hint.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    var box = byId('ls_cat_box');
    if (box && box.scrollIntoView) box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    lsNotify('Recitation Category is compulsory.\n\nSelect one of:\nHifz Fauq, Hifz Taht, Talqeen, Murajaa Qareebah, Murajaa Baeedah, Musaffa, Qiyaamullail');
    return false;
  }

  function byId(id) { return document.getElementById(id); }

  function setBtnVisible(id, show) {
    var el = byId(id);
    if (!el) return;
    /* Hidden stub controls stay hidden forever */
    if (el.getAttribute('aria-hidden') === 'true') {
      el.style.display = 'none';
      return;
    }
    el.style.display = show ? '' : 'none';
  }

  /** Match codebase SweetAlert UI (alertMsg / popupMsg / swal). */
  function lsNotify(msg, kind) {
    kind = kind || 'warning';
    var title = kind === 'error' ? 'Couldn’t connect' : (kind === 'success' ? 'Done' : 'Notice');
    if (kind === 'error' && /Microphone/i.test(String(msg || ''))) title = 'Microphone';
    if (kind === 'warning' && /Category/i.test(String(msg || ''))) title = 'Category required';
    if (kind === 'warning' && /listen-along|Listen/i.test(String(msg || ''))) title = 'Listen along';
    if (kind === 'warning' && /Surah/i.test(String(msg || ''))) title = 'Surah required';
    if (kind === 'warning' && /student/i.test(String(msg || ''))) title = 'Student required';
    var text = String(msg || '').replace(/\n+/g, ' ').replace(/\s+/g, ' ').trim();
    try {
      if (typeof window.alertMsg === 'function') {
        window.alertMsg(text, kind === 'success' ? 'success' : (kind === 'error' ? 'error' : 'warning'), title, ' ');
        return;
      }
      if (typeof window.swal === 'function') {
        window.swal({
          type: kind === 'success' ? 'success' : (kind === 'error' ? 'error' : 'warning'),
          title: title,
          text: text,
          showCloseButton: true,
          focusConfirm: false,
          buttonsStyling: false,
          confirmButtonClass: 'btn btn-default swal2-btn-default'
        });
        return;
      }
    } catch (e) {}
    if (typeof window.popupMsg === 'function') {
      try { window.popupMsg(text, kind === 'success' ? 'success' : 'error'); return; } catch (e2) {}
    }
    console.warn('[Academy]', text);
  }

  function showLogModal() {
    var modalEl = byId('academyLogModal');
    if (!modalEl) {
      console.error('academyLogModal not found in DOM');
      return;
    }
    if (window.jQuery) {
      window.jQuery(modalEl).modal('show');
    } else {
      modalEl.style.display = 'block';
      modalEl.classList.add('in');
    }
  }

  function initials(name) {
    return (name || '?').split(/\s+/).slice(0, 2).map(function (p) { return p.charAt(0).toUpperCase(); }).join('');
  }

  function fmtDate(d) {
    if (!d) return '';
    var x = new Date(d);
    // MySQL "YYYY-MM-DD HH:mm:ss" is parsed as local in most browsers; force if needed
    if (isNaN(x.getTime()) && typeof d === 'string' && d.indexOf(' ') !== -1) {
      x = new Date(d.replace(' ', 'T'));
    }
    if (isNaN(x.getTime())) return String(d);
    return x.toLocaleString('en-US', {
      month: 'short',
      day: 'numeric',
      year: 'numeric',
      hour: 'numeric',
      minute: '2-digit',
      hour12: true
    });
  }

  function fmtTime(sec) {
    var m = Math.floor(sec / 60), s = sec % 60;
    return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
  }

  function findStudent(id) {
    id = String(id);
    for (var i = 0; i < state.students.length; i++) {
      if (String(state.students[i].id) === id) return state.students[i];
    }
    return null;
  }

  function surahByNum(n) {
    for (var i = 0; i < SURAHS.length; i++) if (SURAHS[i].number === n) return SURAHS[i];
    return SURAHS[0];
  }

  function portionLabel(rec) {
    var mode = rec.portion_mode || 'FULL_SURAH';
    if (mode === 'FULL_SURAH') return 'Full Surah';
    if (mode === 'AYAH') {
      return rec.ayah_from ? ('Ayah ' + rec.ayah_from) : 'Single Ayah';
    }
    if (mode === 'FROM_TO_AYAH' || mode === 'SUMMUI' || mode === 'RUBBUI') {
      if (rec.ayah_from && rec.ayah_to && String(rec.ayah_from) !== String(rec.ayah_to)) {
        return 'Ayah ' + rec.ayah_from + '–' + rec.ayah_to;
      }
      if (rec.ayah_from) return 'Ayah ' + rec.ayah_from;
      return 'Ayah range';
    }
    if (mode === 'SAFHA') {
      return 'Page ' + (rec.page_from || '') + (rec.page_to ? '–' + rec.page_to : '');
    }
    return 'Portion';
  }

  function nextAyahSuggestion(rec) {
    if (!rec) return null;
    var s = null;
    for (var i = 0; i < SURAHS.length; i++) {
      if (SURAHS[i].name.toLowerCase() === String(rec.surah_name || '').toLowerCase() || SURAHS[i].number === Number(rec.surah_number)) {
        s = SURAHS[i];
        break;
      }
    }
    if (!s) s = surahByNum(Number(rec.surah_number) || 1);

    var mode = rec.portion_mode || 'FULL_SURAH';
    var last = Number(rec.ayah_to || rec.ayah_from || 0);

    // Completed full surah (or last ayah) → first ayah of next surah
    if (mode === 'FULL_SURAH' || last >= s.ayahs) {
      if (s.number >= 114) return null;
      var ns = surahByNum(s.number + 1);
      return { surah: ns.number, from: 1, to: 1, label: ns.name + ' (Ayah 1)', portion: 'AYAH' };
    }

    // No ayah numbers stored — assume start at ayah 1 of same surah
    if (!last) {
      return { surah: s.number, from: 1, to: 1, label: s.name + ' (Ayah 1)', portion: 'AYAH' };
    }

    return { surah: s.number, from: last + 1, to: last + 1, label: s.name + ' (Ayah ' + (last + 1) + ')', portion: 'AYAH' };
  }

  function setSurah(num, from, to, portion) {
    var s = surahByNum(Number(num) || 1);
    state.surah = s.number;
    state.portion = portion || state.portion || 'FULL_SURAH';
    if (state.portion === 'FULL_SURAH') {
      state.fromAyah = 1;
      state.toAyah = s.ayahs;
    } else {
      state.fromAyah = Number(from) || 1;
      state.toAyah = Number(to) || state.fromAyah;
    }
    state.matchedKeys = {};
    state.mistakesByWord = {};
    state.activeCoord = null;
    var sn = byId('ls_surah_number');
    var pf = byId('ls_ayah_from');
    var pt = byId('ls_ayah_to');
    var pm = byId('ls_portion_mode');
    var label = byId('ls_surah_selected_label');
    if (sn) sn.value = s.number;
    if (pf) pf.value = state.fromAyah;
    if (pt) pt.value = state.toAyah;
    if (pm) pm.value = state.portion;
    if (label) label.textContent = s.number + '. ' + s.name + ' (Ayahs ' + state.fromAyah + ' – ' + state.toAyah + ')';
    var label2 = byId('ls_surah_selected_label2');
    if (label2) label2.textContent = 'Surah ' + s.number + '. ' + s.name + ' (Ayahs ' + state.fromAyah + ' - ' + state.toAyah + ')';
    updateMushafChrome(null);
    loadArabicText();
  }

  function hizbFromQuarter(q) {
    q = Number(q) || 1;
    return Math.max(1, Math.ceil(q / 4));
  }

  function updateMushafChrome(meta) {
    var el = byId('ls_mushaf_chrome');
    if (!el) return;
    if (!meta || (!meta.page && !meta.juz)) {
      el.style.display = 'none';
      el.innerHTML = '';
      return;
    }
    var page = meta.pageFrom && meta.pageTo && meta.pageFrom !== meta.pageTo
      ? (meta.pageFrom + '–' + meta.pageTo)
      : String(meta.pageFrom || meta.page || '—');
    var juz = meta.juz || '—';
    var hizb = meta.hizb || (meta.hizbQuarter ? hizbFromQuarter(meta.hizbQuarter) : '—');
    el.style.display = 'inline-flex';
    el.innerHTML = '<span class="ls-pill ls-pill-join">Page ' + escapeHtml(String(page)) +
      ' | Juz ' + escapeHtml(String(juz)) +
      ' | Hizb ' + escapeHtml(String(hizb)) + '</span>';
    var pf = byId('ls_page_from');
    var pt = byId('ls_page_to');
    if (pf) pf.value = meta.pageFrom || meta.page || '';
    if (pt) pt.value = meta.pageTo || meta.pageFrom || meta.page || '';
  }

  function applyMushafTheme(theme) {
    var el = byId('ls_arabic_text');
    var paperBtn = byId('ls_theme_paper');
    var nightBtn = byId('ls_theme_night');
    var isNight = theme === 'night';
    state.mushafTheme = isNight ? 'night' : 'paper';
    try { localStorage.setItem('ls_mushaf_theme', state.mushafTheme); } catch (e) {}
    if (el) el.classList.toggle('ls-arabic--night', isNight);
    if (paperBtn) paperBtn.classList.toggle('active', !isNight);
    if (nightBtn) nightBtn.classList.toggle('active', isNight);
  }

  function updateProgressStrip() {
    var el = byId('ls_progress_strip');
    var matched = Object.keys(state.matchedKeys || {}).length;
    var mistakes = Object.keys(state.mistakesByWord || {}).length;
    var liveAcc = byId('ls_accuracy_live');
    var accText = '100%';
    if (liveAcc && /%/.test(liveAcc.textContent || '')) {
      var m = (liveAcc.textContent || '').match(/(\d+)\s*%/);
      if (m) accText = m[1] + '%';
    } else if (matched + mistakes > 0) {
      accText = Math.max(0, Math.round((matched / Math.max(1, matched + mistakes)) * 100)) + '%';
    }
    if (el) el.textContent = matched + ' matched' + (mistakes ? (' · ' + mistakes + ' mistakes') : '') + ' · ' + accText;
    var pillP = byId('ls_pill_progress');
    if (pillP) pillP.textContent = matched + ' /pg | ' + accText;
    var pillM = byId('ls_pill_mistakes_n');
    if (pillM) pillM.textContent = String(mistakes);
  }

  function playSessionTone(kind) {
    if (!state.sessionSound) return;
    try {
      var Ctx = window.AudioContext || window.webkitAudioContext;
      if (!Ctx) return;
      if (!state._audioCtx) state._audioCtx = new Ctx();
      var ctx = state._audioCtx;
      if (ctx.state === 'suspended') ctx.resume();
      var o = ctx.createOscillator();
      var g = ctx.createGain();
      o.type = 'sine';
      o.frequency.value = kind === 'stop' ? 440 : 660;
      g.gain.value = 0.0001;
      o.connect(g);
      g.connect(ctx.destination);
      var t0 = ctx.currentTime;
      g.gain.exponentialRampToValueAtTime(0.12, t0 + 0.02);
      g.gain.exponentialRampToValueAtTime(0.0001, t0 + (kind === 'stop' ? 0.18 : 0.12));
      o.start(t0);
      o.stop(t0 + 0.22);
    } catch (e) {}
  }

  function setTip(el, label) {
    if (!el || !label) return;
    el.setAttribute('data-tip', label);
    el.setAttribute('aria-label', label);
    el.removeAttribute('title');
  }

  function setTextHidden(on) {
    state.textHidden = !!on;
    var el = byId('ls_arabic_text');
    var btn = byId('ls_btn_hide_text');
    if (el) el.classList.toggle('ls-arabic--hidden', state.textHidden);
    if (btn) {
      btn.classList.toggle('active', state.textHidden);
      setBtnIcon(btn, state.textHidden ? 'eye' : 'eyeOff');
      setTip(btn, state.textHidden ? 'Show text' : 'Hide text');
    }
  }

  function setSessionSound(on) {
    state.sessionSound = !!on;
    try { localStorage.setItem('ls_session_sound', state.sessionSound ? '1' : '0'); } catch (e) {}
    var btn = byId('ls_btn_session_sound');
    if (btn) {
      btn.classList.toggle('active', state.sessionSound);
      setBtnIcon(btn, state.sessionSound ? 'speaker' : 'speakerOff');
      setTip(btn, state.sessionSound ? 'Session beep On' : 'Session beep Off');
    }
  }

  function pad3(n) {
    n = String(n);
    while (n.length < 3) n = '0' + n;
    return n;
  }

  function reciterAyahUrl(surah, ayah) {
    return 'https://everyayah.com/data/Alafasy_128kbps/' + pad3(surah) + pad3(ayah) + '.mp3';
  }

  function clearListenWordTimer() {
    if (state.listenWordTimer) {
      clearInterval(state.listenWordTimer);
      state.listenWordTimer = null;
    }
  }

  function stopListenAlong() {
    clearListenWordTimer();
    state.listenPlaying = false;
    state.listenAyah = null;
    var audio = byId('ls_reciter_audio');
    if (audio) {
      try { audio.pause(); audio.removeAttribute('src'); audio.load(); } catch (e) {}
    }
    var btn = byId('ls_btn_listen');
    if (btn) {
      btn.classList.remove('active');
      setBtnIcon(btn, 'speaker');
      setTip(btn, 'Listen along');
    }
  }

  function highlightListenWord(surah, ayah, wordCount, elapsedMs, durationMs) {
    if (!wordCount || !durationMs) return;
    var idx = Math.min(wordCount, Math.max(1, Math.ceil((elapsedMs / durationMs) * wordCount)));
    state.activeCoord = { surah: Number(surah), ayah: Number(ayah), word: idx };
    refreshWordHighlights();
  }

  function playListenAyah(ayahNum) {
    var audio = byId('ls_reciter_audio');
    var btn = byId('ls_btn_listen');
    if (!audio) return;
    clearListenWordTimer();
    state.listenAyah = ayahNum;
    state.listenPlaying = true;
    if (btn) {
      btn.classList.add('active');
      setBtnIcon(btn, 'stop');
      setTip(btn, 'Stop listen');
    }
    var wrap = document.querySelector('#ls_arabic_text .ls-ayah[data-ayah="' + ayahNum + '"]');
    var wordCount = wrap ? wrap.querySelectorAll('.ls-word').length : 0;
    audio.onended = function () {
      var next = ayahNum + 1;
      if (next <= Number(state.toAyah)) {
        playListenAyah(next);
      } else {
        stopListenAlong();
        state.activeCoord = null;
        refreshWordHighlights();
      }
    };
    audio.onerror = function () {
      byId('ls_rec_status').textContent = 'Reciter audio unavailable (network). Try again.';
      stopListenAlong();
    };
    audio.src = reciterAyahUrl(state.surah, ayahNum);
    audio.play().then(function () {
      state.activeCoord = { surah: Number(state.surah), ayah: Number(ayahNum), word: 1 };
      refreshWordHighlights();
      state.listenWordTimer = setInterval(function () {
        if (!audio.duration || !isFinite(audio.duration)) return;
        highlightListenWord(state.surah, ayahNum, wordCount, audio.currentTime * 1000, audio.duration * 1000);
      }, 120);
    }).catch(function () {
      byId('ls_rec_status').textContent = 'Could not play reciter audio (autoplay blocked?). Click Listen again.';
      stopListenAlong();
    });
  }

  function toggleListenAlong() {
    if (state.listenPlaying) {
      stopListenAlong();
      return;
    }
    if (state.recording || state.liveMode === 'tarteel') {
      lsNotify('Stop live recitation before listen-along.');
      return;
    }
    if (!state.surah || !state.fromAyah) {
      lsNotify('Select a Surah / ayah range first.');
      return;
    }
    byId('ls_rec_status').textContent = 'Listen-along · Alafasy model reciter (ayah audio)';
    playListenAyah(Number(state.fromAyah));
  }

  function syncLiveFab() {
    var fab = byId('ls_btn_live_fab');
    if (!fab) return;
    var live = !!(state.recording || state.liveMode);
    fab.classList.toggle('is-live', live);
    setBtnIcon(fab, live ? 'stop' : 'mic');
    setTip(fab, live ? 'Stop live recitation' : 'Start/stop live recitation');
  }

  function pageLabel(rec) {
    if (rec.page_from && rec.page_to && String(rec.page_from) !== String(rec.page_to)) {
      return (Math.abs(Number(rec.page_to) - Number(rec.page_from)) + 1) + ' pages (PG. ' + rec.page_from + ' - ' + rec.page_to + ')';
    }
    if (rec.page_from) return '1 page (PG. ' + rec.page_from + ')';
    if (rec.portion_mode === 'FULL_SURAH') return 'Full Surah';
    if (rec.ayah_from && rec.ayah_to && String(rec.ayah_from) !== String(rec.ayah_to)) {
      return 'Ayahs ' + rec.ayah_from + '–' + rec.ayah_to;
    }
    if (rec.ayah_from) return 'Ayah ' + rec.ayah_from;
    return 'Portion';
  }

  function ayahRangeTitle(rec) {
    var name = rec.surah_name || ('Surah ' + rec.surah_number);
    if (rec.portion_mode === 'FULL_SURAH') return name + ' (Full Surah)';
    if (rec.ayah_from && rec.ayah_to && String(rec.ayah_from) !== String(rec.ayah_to)) {
      return name + ' ' + rec.ayah_from + ' - ' + rec.ayah_to;
    }
    if (rec.ayah_from) return name + ' ' + rec.ayah_from;
    return name;
  }

  function renderHistory() {
    var st = findStudent(state.studentId);
    var box = byId('ls_history_list');
    var countEl = byId('ls_history_count');
    var prevEl = byId('ls_prev_milestone');
    var nextBtn = byId('ls_continue_next');
    if (!box) return;
    var records = (st && st.tahfiz_records) ? st.tahfiz_records : [];
    if (countEl) countEl.textContent = records.length + ' Recorded';
    box.innerHTML = '';
    if (!records.length) {
      box.innerHTML = '<div class="ls-muted">No milestones yet for this student.</div>';
      if (prevEl) prevEl.innerHTML = '';
      if (nextBtn) nextBtn.style.display = 'none';
      return;
    }
    var latest = records[0];
    if (prevEl) {
      var note = latest.akhlaq_note ? stripAkhlaqTelemetry(latest.akhlaq_note) : '';
      var hasAudio = !!(latest.audio_url);
      var metaBits = [];
      if (latest.accuracy_score != null && latest.accuracy_score !== '') {
        metaBits.push(Math.round(Number(latest.accuracy_score)) + '% Acc');
      }
      if (latest.mistake_word_count != null && latest.mistake_word_count !== '') {
        metaBits.push(Number(latest.mistake_word_count) + ' mistakes');
      }
      if (hasAudio && latest.recitation_seconds) {
        metaBits.push(fmtTime(Number(latest.recitation_seconds)));
      } else if (hasAudio) {
        metaBits.push('Audio');
      }
      prevEl.innerHTML = '<div class="ls-prev-title">Previous Milestone:</div>' +
        '<div class="ls-prev-body"><strong>' + escapeHtml(ayahRangeTitle(latest)) +
        '</strong><div class="ls-muted">' + escapeHtml(fmtDate(latest.completed_at)) +
        ' · ' + escapeHtml(pageLabel(latest)) + '</div>' +
        (metaBits.length ? '<div class="ls-muted" style="margin-top:.25rem">' + escapeHtml(metaBits.join(' · ')) + '</div>' : '') +
        (latest.recitation_category
          ? '<div class="ls-muted" style="margin-top:.2rem;color:#0f766e;font-weight:700">' + escapeHtml(categoryLabel(latest.recitation_category)) + '</div>'
          : '') +
        (note ? '<div class="ls-note">"' + escapeHtml(note) + '"</div>' : '') +
        (hasAudio
          ? '<button type="button" class="ls-icon-btn" id="ls_play_prev_audio" style="margin-top:.45rem" title="Play saved audio">' + ICO.play + '</button> <span class="ls-muted" style="vertical-align:middle">Play saved audio</span>'
          : '<div class="ls-muted" style="margin-top:.35rem;color:#b45309">No audio file yet — click the timeline card, record, then <strong>Attach Audio to This Log</strong></div>') +
        '</div>';
      var playPrev = byId('ls_play_prev_audio');
      if (playPrev) {
        playPrev.onclick = function () { loadMilestone(latest); };
      }
    }
    var next = nextAyahSuggestion(latest);
    if (nextBtn) {
      if (next) {
        nextBtn.style.display = '';
        nextBtn.innerHTML = ICO.arrow + ' Continue Next Ayah: ' + escapeHtml(next.label);
        nextBtn.classList.add('ls-btn-with-ico');
        nextBtn.onclick = function () {
          if (!requireRecitationCategory('Continue Next Ayah')) return;
          clearMilestoneEdit();
          setSurah(next.surah, next.from, next.to, next.portion);
          byId('ls_portion_mode').value = next.portion;
          state.portion = next.portion;
          loadMilestoneAudio('', '');
          var note = byId('ls_akhlaq');
          if (note) note.value = '';
          var b64 = byId('ls_audio_b64');
          if (b64) b64.value = '';
          var status = byId('ls_rec_status');
          if (status) {
            status.textContent = 'Ready for next ayah (' + categoryLabel(getSelectedCategory()) + ') — record, then Save Surah Milestone';
            status.style.color = '';
          }
        };
      } else {
        nextBtn.style.display = 'none';
      }
      syncCategoryGate();
    }

    var rail = document.createElement('div');
    rail.className = 'ls-timeline';
    records.slice(0, 20).forEach(function (rec) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'ls-tl-item' + (rec.audio_url ? ' has-audio' : '');
      var acc = rec.accuracy_score != null ? Math.round(Number(rec.accuracy_score)) + '% Acc' : null;
      btn.innerHTML =
        '<span class="ls-tl-dot"></span>' +
        '<div class="ls-tl-top">' +
          '<span class="ls-tl-title">' + escapeHtml(ayahRangeTitle(rec)) + '</span>' +
          '<span class="ls-tl-date">' + escapeHtml(fmtDate(rec.completed_at)) + '</span>' +
        '</div>' +
        '<div class="ls-tl-meta">' + escapeHtml(pageLabel(rec)) +
          (rec.recitation_category
            ? '<div class="ls-tl-cat">' + escapeHtml(categoryLabel(rec.recitation_category)) + '</div>'
            : '') +
        '</div>' +
        '<div class="ls-tl-badges">' +
          (rec.audio_url
            ? '<span class="ls-tl-badge ok">' + ICO.audio + ' Audio</span>'
            : '<span class="ls-tl-badge warn">No audio</span>') +
          (acc ? '<span class="ls-tl-badge">' + escapeHtml(acc) + '</span>' : '') +
          (rec.mistake_word_count != null && Number(rec.mistake_word_count) > 0
            ? '<span class="ls-tl-badge warn">' + Number(rec.mistake_word_count) + ' mistakes</span>'
            : '') +
        '</div>';
      btn.title = rec.audio_url ? 'Load portion + play saved audio' : 'Load portion (no audio file stored)';
      btn.onclick = function (ev) {
        if (ev && ev.preventDefault) ev.preventDefault();
        if (ev && ev.stopPropagation) ev.stopPropagation();
        rail.querySelectorAll('.ls-tl-item').forEach(function (c) { c.classList.remove('active'); });
        btn.classList.add('active');
        try {
          loadMilestone(rec);
        } catch (err) {
          console.error('[AcademyLog] loadMilestone failed', err);
          lsNotify('Could not load milestone: ' + ((err && err.message) || err), 'error');
        }
      };
      rail.appendChild(btn);
    });
    box.appendChild(rail);
  }

  function escapeHtml(s) {
    return String(s == null ? '' : s)
      .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  function renderStudentPicker(filter) {
    var list = byId('ls_student_list');
    if (!list) return;
    var q = (filter || '').toLowerCase();
    list.innerHTML = '';
    state.students.forEach(function (st) {
      var blob = (st.fullname + ' ' + (st.class_level || '') + ' ' + (st.register_no || '')).toLowerCase();
      if (q && blob.indexOf(q) === -1) return;
      var row = document.createElement('button');
      row.type = 'button';
      row.className = 'ls-student-row' + (String(st.id) === String(state.studentId) ? ' active' : '');
      row.innerHTML = '<span class="ls-avatar">' + escapeHtml(initials(st.fullname)) + '</span>' +
        '<span><strong>' + escapeHtml(st.fullname) + '</strong><br><span class="ls-muted">' +
        escapeHtml(st.class_level || 'Unassigned') + '</span></span>';
      row.onclick = function () { selectStudent(st.id); };
      list.appendChild(row);
    });
  }

  function selectStudent(id) {
    state.studentId = id;
    var st = findStudent(id);
    var sid = byId('ls_student_id');
    var picker = byId('ls_student_picker');
    var selected = byId('ls_student_selected');
    if (sid) sid.value = id;
    if (picker) picker.style.display = 'none';
    if (selected) selected.style.display = '';
    if (st) {
      var av = byId('ls_sel_avatar');
      var nm = byId('ls_sel_name');
      var mt = byId('ls_sel_meta');
      if (av) av.textContent = initials(st.fullname);
      if (nm) {
        nm.innerHTML = escapeHtml(st.fullname);
        if (st.streak > 0) {
          nm.innerHTML += ' <span class="ls-streak-badge" title="Drill streak">' + ICO.flame + ' ' + Number(st.streak) + '</span>';
        }
      }
      if (mt) mt.textContent = (st.class_level || 'Unassigned') + (st.register_no ? ' · ' + st.register_no : '');
      var streakPill = byId('ls_pill_streak');
      var streakN = byId('ls_pill_streak_n');
      if (streakPill && streakN) {
        if (st.streak > 0) {
          streakPill.style.display = '';
          streakN.textContent = String(st.streak);
        } else {
          streakPill.style.display = 'none';
        }
      }
    }
    renderHistory();
  }

  function showPicker() {
    var selected = byId('ls_student_selected');
    var picker = byId('ls_student_picker');
    if (selected) selected.style.display = 'none';
    if (picker) picker.style.display = '';
    var search = byId('ls_student_search');
    renderStudentPicker(search ? search.value : '');
  }

  function renderSurahResults(q) {
    var box = byId('ls_surah_results');
    if (!box) return;
    q = (q || '').toLowerCase().trim();
    box.innerHTML = '';
    var hits = SURAHS.filter(function (s) {
      if (!q) return s.number <= 20 || s.number >= 100;
      return String(s.number) === q || s.name.toLowerCase().indexOf(q) !== -1;
    }).slice(0, 20);
    hits.forEach(function (s) {
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 'ls-chip';
      b.textContent = s.number + '. ' + s.name + ' (' + s.ayahs + ')';
      b.onclick = function () {
        var portion = byId('ls_portion_mode').value || 'FULL_SURAH';
        setSurah(s.number, 1, portion === 'FULL_SURAH' ? s.ayahs : 1, portion);
        byId('ls_surah_search').value = s.name;
        box.innerHTML = '';
      };
      box.appendChild(b);
    });
  }

  var LS_MARK = /[\u0610-\u061A\u064B-\u065F\u0670\u06D6-\u06ED\u08D4-\u08FF]/;

  function mushafPieces(word) {
    var chars = Array.from(word);
    var out = [];
    var i = 0;
    while (i < chars.length) {
      if (LS_MARK.test(chars[i])) { i++; continue; }
      var base = chars[i++];
      var marks = '';
      while (i < chars.length && LS_MARK.test(chars[i])) marks += chars[i++];
      out.push({ base: base, marks: marks });
    }
    return out;
  }

  function isWaslPiece(p, index) {
    if (!p) return false;
    if (p.base === '\u0671') return true;
    return index === 0 && p.base === '\u0644' && p.marks.indexOf('\u0651') !== -1;
  }

  function fillMushafWord(span, word, format) {
    span.style.letterSpacing = '';
    var parts = mushafPieces(word);
    if (format === 'advanced') {
      span.style.letterSpacing = '0';
      span.textContent = '';
      parts.forEach(function (p, n) {
        if (isWaslPiece(p, n)) {
          var wasl = document.createElement('span');
          wasl.className = 'ls-wasl';
          wasl.title = 'Wasl — skip this when you join the word';
          wasl.textContent = p.base;
          span.appendChild(wasl);
        } else {
          span.appendChild(document.createTextNode(p.base));
        }
        Array.from(p.marks).forEach(function (m) {
          var mk = document.createElement('span');
          var kind = 'ls-vowel';
          if (m === '\u064E' || m === '\u064B') kind = 'ls-fatha';
          else if (m === '\u0650' || m === '\u064D') kind = 'ls-kasra';
          else if (m === '\u064F' || m === '\u064C') kind = 'ls-damma';
          else if (m === '\u0651') kind = 'ls-shadda';
          else if (m === '\u0652') kind = 'ls-sukun';
          mk.className = kind;
          mk.textContent = m;
          span.appendChild(mk);
        });
      });
      return;
    }
    if (format === 'muraja') {
      span.style.letterSpacing = '0.06em';
      span.textContent = '';
      parts.forEach(function (p, n) {
        if (isWaslPiece(p, n)) {
          var wasl = document.createElement('span');
          wasl.className = 'ls-wasl';
          wasl.title = 'Wasl — skip this when you join the word';
          wasl.textContent = p.base;
          span.appendChild(wasl);
        } else {
          span.appendChild(document.createTextNode(p.base));
        }
      });
      return;
    }
    span.textContent = '';
    parts.forEach(function (p, n) {
      var bit = document.createElement('span');
      bit.className = 'ls-letter' + (format === 'novice' ? ' ls-letter-' + (n % 4) : '');
      if (isWaslPiece(p, n)) bit.className += ' ls-wasl';
      bit.style.margin = format === 'novice' ? '0 .18em' : '0 .02em';
      bit.title = isWaslPiece(p, n) ? 'Wasl — skip this when you join the word' : '';
      bit.appendChild(document.createTextNode(p.base));
      if (p.marks) {
        var mk = document.createElement('span');
        mk.className = 'ls-vowel';
        mk.textContent = p.marks;
        bit.appendChild(mk);
      }
      span.appendChild(bit);
    });
  }

  function loadArabicText() {
    var el = byId('ls_arabic_text');
    if (!el) return;
    el.innerHTML = '<div class="ls-muted">Loading Arabic text…</div>';
    var banner = byId('ls_highlight_banner');
    if (banner) banner.textContent = 'Highlight Mistakes: loading Mushaf text…';
    updateProgressStrip();
    state.matched = 0;
    state.mistakes = 0;
    state.matchedKeys = {};
    state.mistakesByWord = {};
    state.activeCoord = null;
    fetch('https://api.alquran.cloud/v1/surah/' + state.surah + '/quran-uthmani')
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data || !data.data || !data.data.ayahs) throw new Error('bad');
        var ayahs = data.data.ayahs.filter(function (a) {
          var n = Number(a.numberInSurah);
          return n >= state.fromAyah && n <= state.toAyah;
        });
        state.ayahsText = ayahs;
        state.surahArabicName = (data.data.name || '') + '';
        el.innerHTML = '';

        var pageFrom = null, pageTo = null, juz = null, hizbQ = null;
        ayahs.forEach(function (a) {
          if (a.page != null) {
            if (pageFrom == null || a.page < pageFrom) pageFrom = a.page;
            if (pageTo == null || a.page > pageTo) pageTo = a.page;
          }
          if (juz == null && a.juz != null) juz = a.juz;
          if (hizbQ == null && a.hizbQuarter != null) hizbQ = a.hizbQuarter;
        });
        state.mushafMeta = {
          pageFrom: pageFrom,
          pageTo: pageTo,
          page: pageFrom,
          juz: juz,
          hizbQuarter: hizbQ,
          hizb: hizbQ ? hizbFromQuarter(hizbQ) : null
        };
        updateMushafChrome(state.mushafMeta);

        var eng = null;
        for (var si = 0; si < SURAHS.length; si++) {
          if (SURAHS[si].number === Number(state.surah)) { eng = SURAHS[si]; break; }
        }
        var bannerEl = document.createElement('div');
        bannerEl.className = 'ls-surah-banner';
        bannerEl.textContent = state.surahArabicName
          ? ('سُورَةُ ' + state.surahArabicName.replace(/^سُورَةُ\s*/u, ''))
          : (eng ? eng.name : ('Surah ' + state.surah));
        el.appendChild(bannerEl);

        if (Number(state.surah) !== 1 && Number(state.surah) !== 9 && Number(state.fromAyah) === 1) {
          var bis = document.createElement('div');
          bis.className = 'ls-bismillah';
          bis.textContent = 'بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ';
          el.appendChild(bis);
        }

        ayahs.forEach(function (a) {
          var text = a.text || '';
          if (Number(state.surah) !== 1 && Number(state.surah) !== 9 && Number(a.numberInSurah) === 1) {
            text = text.replace(/^بِسْمِ[\s\S]*?ٱلرَّحِيمِ\s*/u, '');
            text = text.replace(/^بِسْمِ[^ا-ي]*اللّ?ه[^ا-ي]*الرّ?حمن[^ا-ي]*الرّ?حيم\s*/i, '');
          }
          if (state.surah !== 1 && state.fromAyah === state.toAyah && Number(state.fromAyah) === 1) {
            if (text.indexOf('الٓمٓ') !== -1 || text.indexOf('الم') !== -1) {
              var m = text.match(/(الٓمٓ|الم)[\s\S]*$/);
              if (m) text = m[0];
            }
          }
          var wrap = document.createElement('span');
          wrap.className = 'ls-ayah';
          wrap.setAttribute('data-ayah', a.numberInSurah);
          wrap.setAttribute('data-page', a.page != null ? a.page : '');
          wrap.setAttribute('data-juz', a.juz != null ? a.juz : '');

          var words = text.trim().split(/\s+/).filter(Boolean);
          var format = state.textFormat || 'medium';
          words.forEach(function (w, idx) {
            var wordEl = document.createElement('span');
            wordEl.className = 'ls-word';
            wordEl.setAttribute('data-s', state.surah);
            wordEl.setAttribute('data-a', a.numberInSurah);
            wordEl.setAttribute('data-w', idx + 1);
            fillMushafWord(wordEl, w, format);
            wordEl.title = 'Ayah ' + a.numberInSurah + ', Word ' + (idx + 1);
            wrap.appendChild(wordEl);
          });
          var num = document.createElement('span');
          num.className = 'ls-ayah-num';
          num.setAttribute('aria-label', 'Ayah ' + a.numberInSurah);
          num.textContent = a.numberInSurah;
          wrap.appendChild(num);
          wrap.appendChild(document.createTextNode(' '));
          el.appendChild(wrap);
        });
        if (banner) banner.textContent = 'Highlight Mistakes: Enabled · word aligner idle';
        setHiddenMetrics();
        updateProgressStrip();
        applyMushafTheme(state.mushafTheme || 'paper');
      })
      .catch(function () {
        el.innerHTML = '<div class="ls-muted">Could not load Surah text (offline / blocked). You can still save the milestone.</div>';
        if (banner) banner.textContent = 'Highlight Mistakes: text unavailable';
        updateProgressStrip();
      });
  }

  function wordKey(s, a, w) {
    return s + '_' + a + '_' + w;
  }

  function refreshWordHighlights() {
    var nodes = document.querySelectorAll('#ls_arabic_text .ls-word');
    var active = state.activeCoord;
    var hlOn = state.highlightEnabled !== false;
    nodes.forEach(function (n) {
      var s = Number(n.getAttribute('data-s'));
      var a = Number(n.getAttribute('data-a'));
      var w = Number(n.getAttribute('data-w'));
      var key = wordKey(s, a, w);
      var isMatched = hlOn && !!state.matchedKeys[key];
      var mistake = hlOn ? state.mistakesByWord[key] : null;
      var isActive = hlOn && active && active.surah === s && active.ayah === a && active.word === w;
      n.classList.toggle('ls-word-matched', isMatched && !mistake && !isActive);
      n.classList.toggle('ls-word-active', !!isActive);
      n.classList.toggle('ls-word-mistake', !!mistake);
      if (mistake) {
        n.title = 'Mistake: ' + (mistake.mistakeType || 'tajweed') +
          (mistake.expectedTranscript ? ' (expected: ' + mistake.expectedTranscript + ')' : '');
      } else {
        n.title = 'Ayah ' + a + ', Word ' + w;
      }
    });
    var ayahNodes = document.querySelectorAll('#ls_arabic_text .ls-ayah');
    var activeAyah = active ? active.ayah : null;
    ayahNodes.forEach(function (n) {
      var a = Number(n.getAttribute('data-ayah') || 0);
      var wordsInAyah = n.querySelectorAll('.ls-word');
      var allMatched = wordsInAyah.length > 0;
      wordsInAyah.forEach(function (w) {
        var key = wordKey(Number(w.getAttribute('data-s')), Number(w.getAttribute('data-a')), Number(w.getAttribute('data-w')));
        if (!state.matchedKeys[key]) allMatched = false;
      });
      n.classList.toggle('ls-ayah-done', allMatched && a !== activeAyah);
      n.classList.toggle('ls-ayah-active', a === activeAyah);
    });
    if (active) {
      var activeEl = document.querySelector(
        '#ls_arabic_text .ls-word[data-s="' + active.surah + '"][data-a="' + active.ayah + '"][data-w="' + active.word + '"]'
      );
      if (activeEl && activeEl.scrollIntoView) {
        activeEl.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
      }
    }
    var banner = byId('ls_highlight_banner');
    if (banner) {
      var mCount = Object.keys(state.mistakesByWord).length;
      var matchedN = Object.keys(state.matchedKeys).length;
      if (state.recording || state.liveMode) {
        banner.textContent = 'Highlight Mistakes: Enabled · Live · ' + matchedN + ' matched · ' + mCount + ' mistakes';
      } else if (matchedN || mCount) {
        banner.textContent = 'Highlight Mistakes: Enabled · ' + matchedN + ' matched · ' + mCount + ' mistakes';
      } else {
        banner.textContent = 'Highlight Mistakes: Enabled · word aligner idle';
      }
    }
    updateProgressStrip();
  }

  function highlightAyah(ayahNumber) {
    if (ayahNumber && !state.activeCoord) {
      state.activeCoord = { surah: state.surah, ayah: Number(ayahNumber), word: 1 };
    }
    refreshWordHighlights();
  }

  function wordTextForKey(key) {
    var parts = String(key).split('_');
    var n = document.querySelector(
      '#ls_arabic_text .ls-word[data-s="' + parts[0] + '"][data-a="' + parts[1] + '"][data-w="' + parts[2] + '"]'
    );
    return n ? n.textContent : '';
  }

  function plainMistake(m, key) {
    var parts = String(key || '').split('_');
    var pos = (m && m.positions && m.positions[0]) || null;
    return {
      type: (m && (m.mistakeType || m.type)) || 'TAJWEED',
      id: (m && m.id) || '',
      surah: pos ? pos.surahNumber : (Number(parts[0]) || null),
      ayah: pos ? pos.ayahNumber : (Number(parts[1]) || (m && m.ayah) || null),
      word: pos ? pos.wordNumber : (Number(parts[2]) || null),
      text: key ? wordTextForKey(key) : '',
      expected: (m && (m.expectedTranscript || m.expected)) || '',
      received: (m && (m.receivedTranscript || m.received)) || '',
      positions: (m && m.positions) || [],
      startTimeMs: m && m.startTimeMs != null ? m.startTimeMs : null,
      endTimeMs: m && m.endTimeMs != null ? m.endTimeMs : null
    };
  }

  function tarteelReport() {
    var correct = Object.keys(state.matchedKeys).map(function (key) {
      var parts = key.split('_');
      return {
        surah: Number(parts[0]) || null,
        ayah: Number(parts[1]) || null,
        word: Number(parts[2]) || null,
        text: wordTextForKey(key)
      };
    });
    var mistakes = [];
    var seen = {};
    Object.keys(state.mistakesByWord).forEach(function (key) {
      var row = plainMistake(state.mistakesByWord[key], key);
      var id = (row.id || row.type) + '|' + key;
      if (seen[id]) return;
      seen[id] = true;
      mistakes.push(row);
    });
    var summary = state.tarteelSummary || {};
    if (summary.allMistakes && summary.allMistakes.length) {
      summary.allMistakes.forEach(function (m) {
        var row = plainMistake(m, '');
        var id = (row.id || row.type) + '|' + row.surah + ':' + row.ayah + ':' + row.word + '|' + row.expected;
        if (seen[id]) return;
        seen[id] = true;
        mistakes.push(row);
      });
    }
    var states = [];
    (summary.allStates || []).forEach(function (st) {
      states.push({
        type: st.type || '',
        word: st.word || '',
        position: st.position || null,
        startTime: st.startTime != null ? st.startTime : null,
        endTime: st.endTime != null ? st.endTime : null
      });
    });
    return {
      engine: state.tarteelEngine || 'auto',
      transcript: summary.transcript || '',
      correct: correct,
      mistakes: mistakes,
      states: states
    };
  }

  function setHiddenMetrics() {
    var acc;
    if (Object.keys(state.matchedKeys).length) {
      acc = tarteelAccuracy();
    } else if (state.matched) {
      acc = Math.max(0, Math.min(100, Math.round((state.matched / Math.max(1, state.matched + state.mistakes)) * 100)));
    } else {
      acc = null;
    }
    if (byId('ls_accuracy_score')) byId('ls_accuracy_score').value = acc != null ? acc : '';
    if (byId('ls_mistake_word_count')) byId('ls_mistake_word_count').value = state.mistakes || 0;
    if (byId('ls_mistake_breakdown')) {
      byId('ls_mistake_breakdown').value = JSON.stringify(tarteelReport());
    }
    if (byId('ls_recitation_seconds')) byId('ls_recitation_seconds').value = state.elapsed || 0;
    var live = byId('ls_accuracy_live');
    if (live) {
      live.textContent = (acc != null ? acc : 100) + '% Accuracy · ' + fmtTime(state.elapsed);
    }
    updateProgressStrip();
  }

  function startTimer() {
    stopTimer();
    state.elapsed = 0;
    state.timer = setInterval(function () {
      state.elapsed++;
      setHiddenMetrics();
      var t = byId('ls_timer');
      if (t) t.textContent = fmtTime(state.elapsed);
    }, 1000);
  }

  function stopTimer() {
    if (state.timer) clearInterval(state.timer);
    state.timer = null;
  }

  function tarteelAccuracy() {
    var matchedN = Object.keys(state.matchedKeys).length;
    if (!matchedN) return 100;
    var mistakeN = Object.keys(state.mistakesByWord).length;
    var correct = Math.max(0, matchedN - mistakeN);
    return Math.max(0, Math.min(100, Math.round((correct / matchedN) * 100)));
  }

  function setEngineLabel(text, stateClass) {
    var el = byId('ls_engine_label');
    var pill = byId('ls_engine_pill');
    if (el) el.textContent = text || 'Cloud preferred · local fallback';
    if (pill) {
      pill.classList.remove('live', 'connecting', 'down');
      if (stateClass) pill.classList.add(stateClass);
    }
  }

  function setTokenPreview(probe) {
    var el = byId('ls_token_preview');
    if (!el) return;
    if (!probe) {
      el.textContent = '';
      return;
    }
    var parts = [];
    parts.push('Token ' + (probe.tokenPreview || '—'));
    parts.push(probe.cloud ? '☁ cloud up' : '☁ cloud down');
    parts.push(probe.local ? '🖥 local up' : '🖥 local down');
    if (probe.localMeta && probe.localMeta.asr) {
      parts.push('ASR ' + probe.localMeta.asr);
    }
    el.textContent = parts.join(' · ');
  }

  async function refreshEngineProbe() {
    if (!window.TarteelEngine || !window.TarteelEngine.probeEngines) {
      setEngineLabel('Tarteel client not loaded', 'down');
      return null;
    }
    setEngineLabel('Probing cloud / local…', 'connecting');
    try {
      var probe = await window.TarteelEngine.probeEngines();
      state.engineProbe = probe;
      setTokenPreview(probe);
      var modeSel = byId('ls_engine_mode');
      var pref = (modeSel && modeSel.value) || (window.TARTEEL_CONFIG && window.TARTEEL_CONFIG.engine) || 'auto';
      if (pref === 'cloud') {
        setEngineLabel(probe.cloud ? 'Tarteel Cloud Ready' : 'Cloud unreachable (token/WS)', probe.cloud ? '' : 'down');
      } else if (pref === 'local') {
        setEngineLabel(probe.local ? 'Local Engine Ready' : 'Local :8001 unreachable', probe.local ? '' : 'down');
      } else if (probe.cloud) {
        setEngineLabel('Cloud preferred · local fallback', '');
      } else if (probe.local) {
        setEngineLabel('Local fallback ready (cloud down)', '');
      } else {
        setEngineLabel('Cloud & local unreachable', 'down');
      }
      return probe;
    } catch (e) {
      setEngineLabel('Engine probe failed', 'down');
      return null;
    }
  }

  function showAudioPlayer(url, label) {
    var player = byId('ls_audio_player');
    var bar = byId('ls_playback_bar');
    var title = byId('ls_playback_title');
    var status = byId('ls_rec_status');
    if (!url) {
      state.playbackUrl = null;
      if (player) {
        try { player.pause(); } catch (e) {}
        player.removeAttribute('src');
      }
      if (bar) bar.style.display = 'none';
      return;
    }
    state.playbackUrl = url;
    if (player) {
      player.src = url;
      try { player.load(); } catch (e) {}
      var p = player.play();
      if (p && typeof p.catch === 'function') {
        p.catch(function () { /* autoplay blocked — controls still visible */ });
      }
    }
    if (bar) bar.style.display = '';
    if (title) title.textContent = 'Playing: ' + (label || 'audio');
    if (status) {
      status.textContent = 'Playing' + (label ? ': ' + label : '') + ' — press ▶ if browser blocked autoplay.';
      status.style.color = '#059669';
    }
    setTimeout(function () {
      if (bar && bar.scrollIntoView) bar.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }, 50);
  }

  function safeFilenamePart(s) {
    return String(s || 'Recitation').replace(/[^a-zA-Z0-9]+/g, '_').replace(/^_|_$/g, '') || 'Recitation';
  }

  function downloadCurrentAudio() {
    var url = state.playbackUrl;
    if (!url) {
      lsNotify('No audio to download yet. Play a saved milestone or record first.');
      return;
    }
    var st = findStudent(state.studentId);
    var surah = surahByNum(state.surah);
    var base = safeFilenamePart(st && st.name) + '_' + safeFilenamePart(surah && surah.name) + '_Recitation';
    var ext = 'webm';
    if (state.audioBlob && state.audioBlob.type) {
      if (state.audioBlob.type.indexOf('mp4') !== -1 || state.audioBlob.type.indexOf('m4a') !== -1) ext = 'm4a';
      else if (state.audioBlob.type.indexOf('mpeg') !== -1 || state.audioBlob.type.indexOf('mp3') !== -1) ext = 'mp3';
      else if (state.audioBlob.type.indexOf('wav') !== -1) ext = 'wav';
      else if (state.audioBlob.type.indexOf('ogg') !== -1) ext = 'ogg';
    } else if (/\.mp3(\?|$)/i.test(url)) ext = 'mp3';
    else if (/\.m4a(\?|$)/i.test(url)) ext = 'm4a';
    else if (/\.wav(\?|$)/i.test(url)) ext = 'wav';
    else if (/\.ogg(\?|$)/i.test(url)) ext = 'ogg';
    else if (/\.webm(\?|$)/i.test(url)) ext = 'webm';

    function triggerDownload(href) {
      var a = document.createElement('a');
      a.href = href;
      a.download = base + '.' + ext;
      a.rel = 'noopener';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    }

    if (url.indexOf('blob:') === 0 || state.audioBlob) {
      if (state.audioBlob) {
        var objUrl = URL.createObjectURL(state.audioBlob);
        triggerDownload(objUrl);
        setTimeout(function () { URL.revokeObjectURL(objUrl); }, 2000);
      } else {
        triggerDownload(url);
      }
      return;
    }

    // Same-origin saved file — fetch as blob so download attribute always works
    fetch(url, { credentials: 'same-origin' })
      .then(function (res) {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.blob();
      })
      .then(function (blob) {
        var objUrl = URL.createObjectURL(blob);
        triggerDownload(objUrl);
        setTimeout(function () { URL.revokeObjectURL(objUrl); }, 2000);
      })
      .catch(function () {
        // Fallback: open in new tab
        window.open(url, '_blank');
      });
  }

  function rerecordAudio() {
    var urlInput = document.querySelector('#academyLogModal input[name="audio_url"]');
    if (urlInput) urlInput.value = '';
    var b64 = byId('ls_audio_b64');
    if (b64) b64.value = '';
    var fileInput = byId('ls_audio_file');
    if (fileInput) fileInput.value = '';
    state.audioBlob = null;
    showAudioPlayer('', '');
    var status = byId('ls_rec_status');
    if (status) {
      status.textContent = 'Re-record ready — starting microphone…';
      status.style.color = '#0369a1';
    }
    startRecording(false);
  }

  function loadMilestoneAudio(url, label) {
    var urlInput = document.querySelector('#academyLogModal input[name="audio_url"]');
    if (urlInput) urlInput.value = url || '';
    var status = byId('ls_rec_status');

    if (url) {
      showAudioPlayer(url, label || 'saved milestone audio');
    } else {
      showAudioPlayer('', '');
      if (status) {
        status.innerHTML = '<strong style="color:#b45309">No audio file on this log.</strong> ' +
          'Record again, then <u>Attach Audio to This Log</u>.';
        status.style.color = '';
      }
    }
  }

  function clearMilestoneEdit() {
    var mid = byId('ls_milestone_id');
    if (mid) mid.value = '';
    var saveBtn = byId('ls_btn_save_milestone') || document.querySelector('#academyLogModal button[name="quick_tahfiz"]');
    if (saveBtn) saveBtn.innerHTML = '<i class="fas fa-save"></i> Save Surah Milestone';
    syncCategoryGate();
  }

  function loadMilestone(rec) {
    if (!rec) return;
    var portion = rec.portion_mode === 'FULL_SURAH'
      ? 'FULL_SURAH'
      : (rec.ayah_to && String(rec.ayah_to) !== String(rec.ayah_from) ? 'FROM_TO_AYAH' : 'AYAH');
    setSurah(rec.surah_number, rec.ayah_from || 1, rec.ayah_to || rec.ayah_from || 1, portion);
    if (byId('ls_portion_mode')) byId('ls_portion_mode').value = portion;
    state.portion = portion;
    var note = byId('ls_akhlaq');
    if (note) note.value = rec.akhlaq_note || '';
    state.matchedKeys = {};
    state.mistakesByWord = {};
    state.mistakes = Number(rec.mistake_word_count) || 0;
    state.matched = rec.accuracy_score != null ? 1 : 0;
    state.elapsed = Number(rec.recitation_seconds) || 0;
    if (byId('ls_accuracy_score')) {
      byId('ls_accuracy_score').value = rec.accuracy_score != null ? rec.accuracy_score : '';
    }
    if (byId('ls_mistake_word_count')) byId('ls_mistake_word_count').value = state.mistakes;
    if (byId('ls_recitation_seconds')) byId('ls_recitation_seconds').value = state.elapsed;
    var live = byId('ls_accuracy_live');
    if (live) {
      var acc = rec.accuracy_score != null ? Math.round(Number(rec.accuracy_score)) : '—';
      live.textContent = acc + '% Accuracy · ' + fmtTime(state.elapsed);
    }

    var mid = byId('ls_milestone_id');
    var saveBtn = document.querySelector('#academyLogModal button[name="quick_tahfiz"]');
    if (rec.audio_url) {
      // Playback only — next Save creates a new milestone
      if (mid) mid.value = '';
      if (saveBtn) saveBtn.innerHTML = '<i class="fas fa-save"></i> Save Surah Milestone';
    } else {
      // Re-attach mode: record then Save updates this row
      if (mid) mid.value = rec.id ? String(rec.id) : '';
      if (saveBtn) saveBtn.innerHTML = '<i class="fas fa-microphone"></i> Attach Audio to This Log';
    }

    document.querySelectorAll('#ls_history_list .ls-tl-item').forEach(function (c) {
      c.classList.remove('active');
    });
    var label = (rec.surah_name || '') + ' (' + portionLabel(rec) + ')';
    loadMilestoneAudio(rec.audio_url || '', label);
    setRecitationCategory(rec.recitation_category || '', true);
    var b64 = byId('ls_audio_b64');
    if (b64) b64.value = '';
    var fileInput = byId('ls_audio_file');
    if (fileInput) fileInput.value = '';
    state.audioBlob = null;
  }

  function attachAudioBlob(blob, filename) {
    state.audioBlob = blob;
    var url = URL.createObjectURL(blob);
    showAudioPlayer(url, 'new recording (not saved yet)');
    var fileInput = byId('ls_audio_file');
    if (fileInput && window.DataTransfer) {
      try {
        var dt = new DataTransfer();
        var defaultExt = (blob.type && blob.type.indexOf('ogg') !== -1) ? 'recitation.ogg' : ((blob.type && blob.type.indexOf('webm') !== -1) ? 'recitation.webm' : 'recitation.mp3');
        dt.items.add(new File([blob], filename || defaultExt, { type: blob.type || 'audio/mpeg' }));
        fileInput.files = dt.files;
      } catch (e) {
        console.warn('DataTransfer file attach failed', e);
      }
    }
    // Always keep base64 fallback for reliable upload
    var b64 = byId('ls_audio_b64');
    if (b64 && blob && typeof FileReader !== 'undefined') {
      var reader = new FileReader();
      reader.onload = function () { b64.value = reader.result || ''; };
      reader.readAsDataURL(blob);
    }
  }

  function stripAkhlaqTelemetry(text) {
    return String(text || '')
      .replace(/\s*\[(?:🎙️|🤖)[^\]]*\]/g, '')
      .replace(/\s*\[(?:Audio Attached|Tarteel AI|Live ASR)[^\]]*\]/gi, '')
      .replace(/\s{2,}/g, ' ')
      .trim();
  }

  function appendAkhlaqTag(acc, mistakeCount) {
    // Telemetry lives in accuracy_score / audio_url / recitation_seconds —
    // do not pollute akhlaq_note. Kept as no-op for call-site compatibility.
    return;
  }

  async function startLiveRecitation() {
    if (!window.TarteelEngine || !window.TarteelEngine.createTarteelClientAsync) {
      lsNotify('Tarteel cloud client failed to load. Hard-refresh the page (Ctrl+F5).');
      return;
    }
    if (state.recording || state.liveMode === 'tarteel') {
      return;
    }
    try {
      if (!window.isSecureContext && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
        throw new Error('Microphone needs HTTPS (or localhost).');
      }
      stopRecording(true);
      state.matchedKeys = {};
      state.mistakesByWord = {};
      state.matched = 0;
      state.mistakes = 0;
      state.elapsed = 0;
      state.liveMode = 'tarteel';
      setHiddenMetrics();
      stopListenAlong();
      playSessionTone('start');
      syncLiveFab();

      var modeSel = byId('ls_engine_mode');
      var preferred = (modeSel && modeSel.value) || 'auto';
      if (!window.TARTEEL_CONFIG) window.TARTEEL_CONFIG = {};
      window.TARTEEL_CONFIG.engine = preferred;

      setEngineLabel(
        preferred === 'local' ? 'Connecting local engine…' : 'Connecting cloud (auto→local)…',
        'connecting'
      );
      byId('ls_rec_status').textContent = preferred === 'local'
        ? 'Connecting local FastConformer…'
        : 'Connecting Tarteel cloud (token auth)…';
      setBtnVisible('ls_btn_live', false);
      setBtnVisible('ls_btn_start_audio', false);
      setBtnVisible('ls_btn_start_video', false);
      setBtnVisible('ls_btn_stop', true);

      var callbacks = {
        onStatusChange: function (st) {
          if (st === 'recording') {
            setEngineLabel(
              state.tarteelEngine === 'local' ? 'Local FastConformer Live' : 'Tarteel Cloud Live',
              'live'
            );
            byId('ls_rec_status').textContent = state.tarteelEngine === 'local'
              ? 'Local Muno459 live — dual-model tajweed on sidecar'
              : 'Tarteel cloud live — NeMo/Riva ASR + dual-model tajweed · LINEAR16 @ 16kHz';
          } else if (st === 'connecting') {
            setEngineLabel('Connecting…', 'connecting');
          }
        },
        onPartialTranscript: function () {},
        onError: function (err) {
          var msg = typeof err === 'string' ? err : (err && err.message) || String(err);
          console.error('[Tarteel]', msg);
          setEngineLabel('Engine error: ' + msg.slice(0, 60), 'down');
        },
        onStatesUpdate: function (event) {
          if (event.newStates && event.newStates.length) {
            for (var i = 0; i < event.newStates.length; i++) {
              var st = event.newStates[i];
              if (st.position) {
                var key = st.position.surahNumber + '_' + st.position.ayahNumber + '_' + st.position.wordNumber;
                state.matchedKeys[key] = true;
              }
            }
            var last = event.newStates[event.newStates.length - 1];
            if (last.position) {
              state.activeCoord = {
                surah: last.position.surahNumber,
                ayah: last.position.ayahNumber,
                word: last.position.wordNumber
              };
            }
          }
          if (event.mistakeUpdates) {
            var ids = Object.keys(event.mistakeUpdates);
            for (var j = 0; j < ids.length; j++) {
              var m = event.mistakeUpdates[ids[j]];
              if (m.positions && m.positions.length) {
                for (var p = 0; p < m.positions.length; p++) {
                  var pos = m.positions[p];
                  state.mistakesByWord[pos.surahNumber + '_' + pos.ayahNumber + '_' + pos.wordNumber] = m;
                }
              } else if (m.ayah) {
                var s = Math.floor(m.ayah / 1000);
                var a = m.ayah % 1000;
                state.mistakesByWord[s + '_' + a + '_1'] = m;
              }
            }
          }
          state.matched = Object.keys(state.matchedKeys).length;
          state.mistakes = Object.keys(state.mistakesByWord).length;
          refreshWordHighlights();
          setHiddenMetrics();
        }
      };

      var startOpts = {
        surahNumber: state.surah,
        fromAyah: state.fromAyah,
        toAyah: state.toAyah,
        recitationMode: 'follow'
      };

      var pair = await window.TarteelEngine.createTarteelClientAsync(startOpts, callbacks);
      state.tarteelClient = pair.client;
      state.tarteelEngine = pair.engine;
      setEngineLabel(
        pair.engine === 'local' ? 'Connecting local engine…' : 'Connecting cloud…',
        'connecting'
      );

      try {
        await pair.client.start(startOpts);
      } catch (startErr) {
        // Cloud probe/start failed (expired token etc.) → local if allowed
        if (pair.engine === 'cloud' && preferred !== 'cloud' && window.TarteelEngine.buildClient) {
          console.warn('[Tarteel] cloud start failed → local fallback', startErr);
          try { pair.client.abort(); } catch (e) {}
          var localClient = window.TarteelEngine.buildClient('local', startOpts, callbacks);
          state.tarteelClient = localClient;
          state.tarteelEngine = 'local';
          setEngineLabel('Connecting local engine…', 'connecting');
          byId('ls_rec_status').textContent = 'Cloud failed — falling back to local FastConformer…';
          await localClient.start(startOpts);
        } else if (pair.engine === 'cloud' && preferred === 'auto' && window.TarteelCloudClient) {
          console.warn('[Tarteel] cloud start failed → local fallback', startErr);
          try { pair.client.abort(); } catch (e) {}
          var localClient2 = window.TarteelEngine.buildClient
            ? window.TarteelEngine.buildClient('local', startOpts, callbacks)
            : new window.TarteelCloudClient({
                surahNumber: state.surah,
                fromAyah: state.fromAyah,
                toAyah: state.toAyah,
                endpoint: (window.TARTEEL_CONFIG && window.TARTEEL_CONFIG.localWs) || 'ws://127.0.0.1:8001/v1/recite/stream',
                authToken: 'local-dev',
                userId: 'local-user',
                debug: true
              }, callbacks);
          state.tarteelClient = localClient2;
          state.tarteelEngine = 'local';
          setEngineLabel('Connecting local engine…', 'connecting');
          await localClient2.start(startOpts);
        } else {
          throw startErr;
        }
      }

      state.recording = true;
      startTimer();
    } catch (err) {
      state.liveMode = null;
      state.recording = false;
      if (state.tarteelClient) {
        try { state.tarteelClient.abort(); } catch (e) {}
        state.tarteelClient = null;
      }
      setBtnVisible('ls_btn_stop', false);
      setBtnVisible('ls_btn_start_audio', true);
      setBtnVisible('ls_btn_start_video', false);
      setBtnVisible('ls_btn_live', false);
      setEngineLabel('Engine offline', 'down');
      var msg = (err && err.message) ? err.message : String(err);
      var friendly = msg;
      if (/Permission|NotAllowed|denied/i.test(msg)) {
        friendly = 'Microphone is blocked. Allow Microphone in the address bar, then hard-refresh (Ctrl+F5).';
      } else if (/WebSocket|timed out|token|auth|engine failed|connect/i.test(msg)) {
        friendly = 'Live engine is offline (cloud and local). Start local Tarteel with scripts/start-local-tarteel.ps1, or switch engine to Local only after it is running.';
      } else if (/HTTPS|secure context/i.test(msg)) {
        friendly = 'Microphone needs HTTPS or localhost.';
      }
      byId('ls_rec_status').textContent = friendly;
      lsNotify(friendly, 'error');
      refreshEngineProbe();
      syncLiveFab();
    }
  }

  async function refineWithLocalFinal(blob) {
    if (!blob) return null;
    try {
      var url = (window.TARTEEL_CONFIG && window.TARTEEL_CONFIG.localFinal)
        || 'http://127.0.0.1:8001/v1/recite/final';
      var res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'audio/wav' },
        body: blob,
        credentials: 'same-origin'
      });
      if (!res.ok) return null;
      return await res.json();
    } catch (e) {
      return null;
    }
  }

  async function stopLiveRecitation(silent) {
    stopTimer();
    var client = state.tarteelClient;
    state.tarteelClient = null;
    state.recording = false;
    state.liveMode = null;
    playSessionTone('stop');
    syncLiveFab();
    if (client) {
      try {
        var result = await client.stop();
        if (result) {
          state.tarteelSummary = {
            transcript: result.transcript || '',
            allStates: result.allStates || [],
            allMistakes: result.allMistakes || [],
            durationSec: result.durationSec || 0
          };
          if (result.audioBlob) {
            attachAudioBlob(result.audioBlob, 'tarteel-recitation.wav');
            if (result.durationSec) state.elapsed = result.durationSec;
          }
        }
        var liveEngine = state.tarteelEngine === 'local' ? 'local' : 'cloud';
        var finalPass = await refineWithLocalFinal(result && result.audioBlob);
        if (finalPass && finalPass.transcript && state.tarteelSummary) {
          state.tarteelSummary.transcript = finalPass.transcript;
          state.tarteelEngine = liveEngine + '+local-final';
        }
        var acc = tarteelAccuracy();
        state.matched = Object.keys(state.matchedKeys).length;
        state.mistakes = Object.keys(state.mistakesByWord).length;
        setHiddenMetrics();
        if (!silent) appendAkhlaqTag(acc, state.mistakes);
      } catch (e) {
        console.error('[Tarteel] stop failed', e);
        try { client.abort(); } catch (e2) {}
      }
    }
    if (!silent) {
      byId('ls_rec_status').textContent = 'Live AI check finished — review metrics then Save.';
      setBtnVisible('ls_btn_stop', false);
      setBtnVisible('ls_btn_start_audio', true);
      setBtnVisible('ls_btn_start_video', false);
      setBtnVisible('ls_btn_live', false);
      setEngineLabel(
        state.tarteelEngine && state.tarteelEngine.indexOf('local-final') !== -1
          ? 'Live ' + (state.tarteelEngine.indexOf('cloud') === 0 ? 'cloud' : 'local') + ' · final local transcript'
          : (state.tarteelEngine === 'local' ? 'Local Engine Ready' : 'Cloud preferred · local fallback'),
        ''
      );
    }
  }

  async function startRecording(withVideo) {
    try {
      stopRecording(true);
      var constraints = withVideo
        ? { audio: true, video: { facingMode: 'user' } }
        : { audio: true };
      if (!window.isSecureContext && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
        throw new Error('Microphone needs HTTPS (or localhost).');
      }
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        throw new Error('This browser does not support microphone capture.');
      }
      state.stream = await navigator.mediaDevices.getUserMedia(constraints);
      var preview = byId('ls_video_preview');
      if (withVideo && preview) {
        preview.style.display = '';
        preview.srcObject = state.stream;
        preview.muted = true;
        preview.play();
      }
      state.chunks = [];
      var audioMimes = ['audio/ogg;codecs=opus', 'audio/webm;codecs=opus', 'audio/webm', 'audio/mp4'];
      var chosenMime = '';
      if (withVideo) {
        chosenMime = MediaRecorder.isTypeSupported('video/webm') ? 'video/webm' : '';
      } else {
        for (var i = 0; i < audioMimes.length; i++) {
          if (MediaRecorder.isTypeSupported(audioMimes[i])) {
            chosenMime = audioMimes[i];
            break;
          }
        }
      }
      state.mediaRecorder = new MediaRecorder(state.stream, chosenMime ? { mimeType: chosenMime } : undefined);
      state.mediaRecorder.ondataavailable = function (e) { if (e.data.size) state.chunks.push(e.data); };
      state.mediaRecorder.onstop = function () {
        var recMime = state.mediaRecorder.mimeType || chosenMime || 'audio/webm';
        state.audioBlob = new Blob(state.chunks, { type: recMime });
        var ext = recMime.indexOf('ogg') !== -1 ? 'recitation.ogg' : (recMime.indexOf('webm') !== -1 ? 'recitation.webm' : 'recitation.mp3');
        attachAudioBlob(state.audioBlob, ext);
        var acc = state.matched ? Math.round((state.matched / Math.max(1, state.matched + state.mistakes)) * 100) : null;
        appendAkhlaqTag(acc, state.mistakes);
        setHiddenMetrics();
      };
      state.mediaRecorder.start(250);
      state.recording = true;
      state.liveMode = 'media';
      startTimer();
      playSessionTone('start');
      syncLiveFab();
      byId('ls_rec_status').textContent = withVideo ? 'Recording audio + video…' : 'Recording proof voice…';
      setBtnVisible('ls_btn_stop', true);
      setBtnVisible('ls_btn_start_audio', false);
      setBtnVisible('ls_btn_start_video', false);
      setBtnVisible('ls_btn_live', false);
    } catch (err) {
      var msg = (err && err.message) ? err.message : String(err);
      if (/Permission|NotAllowed|denied/i.test(msg)) {
        msg = 'Microphone/camera blocked. Click the lock icon in the address bar → allow Microphone (and Camera). Then hard-refresh (Ctrl+F5).';
      }
      lsNotify(msg, 'error');
      syncLiveFab();
    }
  }

  function stopRecording(silent) {
    if (state.liveMode === 'tarteel' || state.tarteelClient) {
      if (silent && state.tarteelClient) {
        try { state.tarteelClient.abort(); } catch (e) {}
        state.tarteelClient = null;
        state.recording = false;
        state.liveMode = null;
        stopTimer();
        syncLiveFab();
        return;
      }
      stopLiveRecitation(silent);
      return;
    }
    stopTimer();
    playSessionTone('stop');
    stopSpeechAssessor();
    if (state.mediaRecorder && state.recording) {
      try { state.mediaRecorder.stop(); } catch (e) {}
    }
    state.recording = false;
    state.liveMode = null;
    syncLiveFab();
    if (state.stream) {
      state.stream.getTracks().forEach(function (t) { t.stop(); });
      state.stream = null;
    }
    var preview = byId('ls_video_preview');
    if (preview) { preview.srcObject = null; preview.style.display = 'none'; }
    if (!silent) {
      byId('ls_rec_status').textContent = 'Proof recording saved — review then Save milestone.';
      setBtnVisible('ls_btn_stop', false);
      setBtnVisible('ls_btn_start_audio', true);
      setBtnVisible('ls_btn_start_video', false);
      setBtnVisible('ls_btn_live', false);
    }
  }

  function startSpeechAssessor() {
    /* unused fallback; live AI uses green mic → Tarteel */
  }

  function stopSpeechAssessor() {
    if (state.speechRec) {
      try { state.speechRec.stop(); } catch (e) {}
      state.speechRec = null;
    }
  }

  function openModal(studentId) {
    state.students = window.ACADEMY_ROSTER || [];
    showLogModal();
    var countEl = byId('ls_enrolled_count');
    if (countEl) countEl.textContent = state.students.length + ' Enrolled';
    if (studentId) {
      selectStudent(studentId);
    } else {
      showPicker();
    }
    // Prefer continue-from-latest instead of always resetting to full Al-Fatihah
    var st = findStudent(state.studentId);
    var latest = st && st.tahfiz_records && st.tahfiz_records[0];
    var next = latest ? nextAyahSuggestion(latest) : null;
    if (next) {
      setSurah(next.surah, next.from, next.to, next.portion);
      if (byId('ls_portion_mode')) byId('ls_portion_mode').value = next.portion;
      state.portion = next.portion;
    } else {
      setSurah(1, 1, 7, 'FULL_SURAH');
    }
    renderSurahResults('');
    stopRecording(true);
    clearMilestoneEdit();
    setRecitationCategory('', true);
    syncCategoryGate();
    var akhlaq = byId('ls_akhlaq');
    if (akhlaq) akhlaq.value = '';
    showAudioPlayer('', '');
    var b64 = byId('ls_audio_b64');
    if (b64) b64.value = '';
    var status = byId('ls_rec_status');
    if (status) {
      status.textContent = 'Proof recorder ready · green mic = live AI · speaker = Alafasy listen-along';
      status.style.color = '';
    }
    setEngineLabel('Cloud preferred · local fallback', '');
    setHiddenMetrics();
    var modeSel = byId('ls_engine_mode');
    if (modeSel && window.TARTEEL_CONFIG && window.TARTEEL_CONFIG.engine) {
      modeSel.value = window.TARTEEL_CONFIG.engine;
    }
    refreshEngineProbe();
  }

  function wire() {
    if (byId('ls_change_student')) byId('ls_change_student').onclick = showPicker;
    if (byId('ls_student_search')) byId('ls_student_search').addEventListener('input', function () {
      renderStudentPicker(this.value);
    });
    if (byId('ls_surah_search')) byId('ls_surah_search').addEventListener('input', function () {
      renderSurahResults(this.value);
    });
    if (byId('ls_engine_mode')) byId('ls_engine_mode').addEventListener('change', function () {
      if (!window.TARTEEL_CONFIG) window.TARTEEL_CONFIG = {};
      window.TARTEEL_CONFIG.engine = this.value;
      refreshEngineProbe();
    });
    if (byId('ls_portion_mode')) byId('ls_portion_mode').addEventListener('change', function () {
      state.portion = this.value;
      var s = surahByNum(state.surah);
      if (this.value === 'FULL_SURAH') setSurah(s.number, 1, s.ayahs, 'FULL_SURAH');
      else setSurah(s.number, state.fromAyah || 1, state.toAyah || state.fromAyah || 1, this.value);
    });
    if (byId('ls_ayah_from')) byId('ls_ayah_from').addEventListener('change', function () {
      setSurah(state.surah, this.value, byId('ls_ayah_to').value || this.value, state.portion);
    });
    if (byId('ls_ayah_to')) byId('ls_ayah_to').addEventListener('change', function () {
      setSurah(state.surah, byId('ls_ayah_from').value || 1, this.value, state.portion);
    });
    if (byId('ls_btn_start_audio')) byId('ls_btn_start_audio').onclick = function () { startRecording(false); };
    if (byId('ls_btn_start_video')) byId('ls_btn_start_video').onclick = function () { startRecording(true); };
    if (byId('ls_btn_live')) byId('ls_btn_live').onclick = function () { startLiveRecitation(); };
    if (byId('ls_btn_live_fab')) byId('ls_btn_live_fab').onclick = function () {
      if (state.recording || state.liveMode) {
        if (state.liveMode === 'tarteel' || state.tarteelClient) stopLiveRecitation(false);
        else stopRecording(false);
      } else {
        startLiveRecitation();
      }
    };
    if (byId('ls_btn_listen')) byId('ls_btn_listen').onclick = function () { toggleListenAlong(); };
    if (byId('ls_btn_hide_text')) byId('ls_btn_hide_text').onclick = function () {
      setTextHidden(!state.textHidden);
    };
    if (byId('ls_btn_session_sound')) byId('ls_btn_session_sound').onclick = function () {
      setSessionSound(!state.sessionSound);
    };
    if (byId('ls_btn_highlight')) byId('ls_btn_highlight').onclick = function () {
      var btn = byId('ls_btn_highlight');
      var banner = byId('ls_highlight_banner');
      var on = !(btn && btn.classList.contains('active'));
      if (btn) btn.classList.toggle('active', on);
      if (banner) banner.style.display = on ? '' : 'none';
      state.highlightEnabled = on;
      if (btn) setTip(btn, on ? 'Highlights On' : 'Highlights Off');
      if (!on) {
        document.querySelectorAll('#ls_arabic_text .ls-word-matched, #ls_arabic_text .ls-word-active, #ls_arabic_text .ls-word-mistake').forEach(function (n) {
          n.classList.remove('ls-word-matched', 'ls-word-active', 'ls-word-mistake');
        });
      } else {
        refreshWordHighlights();
      }
    };
    var hlBtn = byId('ls_btn_highlight');
    if (hlBtn) {
      hlBtn.classList.add('active');
      state.highlightEnabled = true;
    }
    if (byId('ls_pill_mistakes')) byId('ls_pill_mistakes').onclick = function () {
      var first = document.querySelector('#ls_arabic_text .ls-word-mistake');
      if (first && first.scrollIntoView) {
        first.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
      } else {
        lsNotify('No mistakes highlighted yet. Use the green mic for a live AI check.');
      }
    };
    if (byId('ls_pill_progress')) byId('ls_pill_progress').onclick = function () {
      var active = document.querySelector('#ls_arabic_text .ls-word-active') ||
        document.querySelector('#ls_arabic_text .ls-ayah-active');
      if (active && active.scrollIntoView) {
        active.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    };
    try {
      var snd = localStorage.getItem('ls_session_sound');
      setSessionSound(snd !== '0');
    } catch (e) {
      setSessionSound(true);
    }
    syncLiveFab();
    updateProgressStrip();
    var formatSel = byId('ls_text_format');
    if (formatSel) {
      try {
        var savedFormat = localStorage.getItem('ls_text_format');
        if (savedFormat) {
          formatSel.value = savedFormat;
          state.textFormat = savedFormat;
        }
      } catch (e) {}
      formatSel.onchange = function () {
        state.textFormat = formatSel.value || 'medium';
        try { localStorage.setItem('ls_text_format', state.textFormat); } catch (e) {}
        if (state.surah) loadArabicText();
      };
    }
    if (byId('ls_theme_paper')) byId('ls_theme_paper').onclick = function () { applyMushafTheme('paper'); };
    if (byId('ls_theme_night')) byId('ls_theme_night').onclick = function () { applyMushafTheme('night'); };
    try {
      var savedTheme = localStorage.getItem('ls_mushaf_theme');
      if (savedTheme === 'night' || savedTheme === 'paper') applyMushafTheme(savedTheme);
      else applyMushafTheme('paper');
    } catch (e) {
      applyMushafTheme('paper');
    }
    if (byId('ls_btn_stop')) byId('ls_btn_stop').onclick = function () { stopRecording(false); };
    if (byId('ls_btn_download_audio')) byId('ls_btn_download_audio').onclick = function (ev) {
      if (ev && ev.preventDefault) ev.preventDefault();
      downloadCurrentAudio();
    };
    if (byId('ls_btn_rerecord')) byId('ls_btn_rerecord').onclick = function (ev) {
      if (ev && ev.preventDefault) ev.preventDefault();
      rerecordAudio();
    };
    document.querySelectorAll('#ls_cat_grid .ls-cat-chip').forEach(function (chip) {
      chip.addEventListener('click', function () {
        setRecitationCategory(chip.getAttribute('data-cat'), false);
      });
    });
    syncCategoryGate();
    var logForm = byId('academyLogModal') && byId('academyLogModal').querySelector('form');
    if (logForm) {
      logForm.addEventListener('submit', function (e) {
        var sid = byId('ls_student_id');
        var sn = byId('ls_surah_number');
        if (!sid || !sid.value) {
          e.preventDefault();
          lsNotify('Select an enrolled student before saving the milestone.');
          showPicker();
          return false;
        }
        if (!sn || !sn.value) {
          e.preventDefault();
          lsNotify('Select a Surah before saving.');
          return false;
        }
        var midEl = byId('ls_milestone_id');
        var isAttach = midEl && midEl.value;
        if (!isAttach && !requireRecitationCategory('Save Surah Milestone')) {
          e.preventDefault();
          return false;
        }
        if (byId('ls_ayah_from')) byId('ls_ayah_from').value = state.fromAyah || byId('ls_ayah_from').value;
        if (byId('ls_ayah_to')) byId('ls_ayah_to').value = state.toAyah || byId('ls_ayah_to').value;
        if (byId('ls_portion_mode')) byId('ls_portion_mode').value = state.portion || byId('ls_portion_mode').value;
        if (byId('ls_surah_number')) byId('ls_surah_number').value = state.surah || byId('ls_surah_number').value;
        setHiddenMetrics();

        var b64El = byId('ls_audio_b64');
        var mid = byId('ls_milestone_id');
        var needsAudio = mid && mid.value;
        // Ensure base64 is ready before POST (FileReader is async)
        if (state.audioBlob && b64El && !b64El.value) {
          e.preventDefault();
          var reader = new FileReader();
          reader.onload = function () {
            b64El.value = reader.result || '';
            if (needsAudio && !b64El.value) {
              lsNotify('Could not prepare audio for upload. Try recording again.', 'error');
              return;
            }
            HTMLFormElement.prototype.submit.call(logForm);
          };
          reader.onerror = function () {
            lsNotify('Could not read recorded audio. Try recording again.', 'error');
          };
          reader.readAsDataURL(state.audioBlob);
          return false;
        }
        if (needsAudio && !(b64El && b64El.value) && !(byId('ls_audio_file') && byId('ls_audio_file').files && byId('ls_audio_file').files.length)) {
          e.preventDefault();
          lsNotify('Record audio first, then click Attach Audio to This Log.');
          return false;
        }
      });
    }
    document.querySelectorAll('[data-quick-surah]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var n = Number(btn.getAttribute('data-quick-surah'));
        var s = surahByNum(n);
        setSurah(n, 1, s.ayahs, 'FULL_SURAH');
        byId('ls_portion_mode').value = 'FULL_SURAH';
      });
    });
    window.academyOpenLog = function (el) {
      var id = el.getAttribute('data-student-id');
      openModal(id);
    };
    window.academyOpenLogBlank = function () { openModal(null); };
  }

  document.addEventListener('DOMContentLoaded', wire);
  if (document.readyState !== 'loading') {
    wire();
  }
  window.AcademyLogSurah = { open: openModal, SURAHS: SURAHS };
})(window, document);
