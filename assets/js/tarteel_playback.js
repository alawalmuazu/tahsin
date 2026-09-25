(function () {
  var surahCache = {};

  function loadSurah(n) {
    if (surahCache[n]) return surahCache[n];
    surahCache[n] = fetch('https://api.alquran.cloud/v1/surah/' + n + '/quran-uthmani')
      .then(function (r) { return r.json(); })
      .then(function (body) {
        var data = body && body.data ? body.data : {};
        return {
          ayahs: data.ayahs || [],
          name: data.name || '',
          english: data.englishName || ''
        };
      })
      .catch(function () { return { ayahs: [], name: '', english: '' }; });
    return surahCache[n];
  }

  var MARK = /[\u0610-\u061A\u064B-\u065F\u0670\u06D6-\u06ED\u08D4-\u08FF]/;

  function pieces(word) {
    var chars = Array.from(word);
    var out = [];
    var i = 0;
    while (i < chars.length) {
      if (MARK.test(chars[i])) { i++; continue; }
      var base = chars[i++];
      var marks = '';
      while (i < chars.length && MARK.test(chars[i])) marks += chars[i++];
      out.push({ base: base, marks: marks });
    }
    return out;
  }

  function fillWord(span, word, format) {
    if (format === 'medium' || format === 'advanced') {
      span.textContent = word + ' ';
      return;
    }
    var parts = pieces(word);
    if (format === 'muraja') {
      span.textContent = parts.map(function (p) { return p.base; }).join('') + ' ';
      span.style.letterSpacing = '0.04em';
      return;
    }
    parts.forEach(function (p) {
      var bit = document.createElement('span');
      bit.style.display = 'inline-block';
      bit.style.margin = format === 'novice' ? '0 .28em' : '0 .08em';
      bit.appendChild(document.createTextNode(p.base));
      if (p.marks) {
        var mk = document.createElement('span');
        mk.textContent = p.marks;
        mk.style.color = '#c2410c';
        bit.appendChild(mk);
      }
      span.appendChild(bit);
    });
    span.appendChild(document.createTextNode(' '));
  }

  function paint(box, pack) {
    var ayahs = pack.ayahs || pack;
    var from = Number(box.getAttribute('data-from')) || 1;
    var to = Number(box.getAttribute('data-to')) || from;
    var format = box.getAttribute('data-format') || 'medium';
    var text = box.querySelector('.ta-text');
    if (!text) return;
    text.innerHTML = '';
    text.style.fontSize = format === 'novice' ? '2rem' : (format === 'beginner' ? '1.85rem' : (format === 'advanced' ? '1.45rem' : '1.7rem'));
    text.style.lineHeight = format === 'novice' || format === 'beginner' ? '2.8' : '2.4';
    if (!ayahs.length) {
      text.textContent = 'Ayah text could not be loaded.';
      return;
    }
    ayahs.forEach(function (a) {
      if (a.numberInSurah < from || a.numberInSurah > to) return;
      var line = document.createElement('div');
      String(a.text || '').trim().split(/\s+/).filter(Boolean).forEach(function (w, i) {
        var span = document.createElement('span');
        span.className = 'ta-word';
        span.setAttribute('data-a', a.numberInSurah);
        span.setAttribute('data-w', i + 1);
        fillWord(span, w, format);
        line.appendChild(span);
      });
      var num = document.createElement('span');
      num.textContent = ' ' + a.numberInSurah;
      num.style.fontSize = '.7rem';
      line.appendChild(num);
      text.appendChild(line);
    });
  }

  function statesOf(box) {
    var node = box.querySelector('.ta-states');
    if (!node) return [];
    try { return JSON.parse(node.textContent || '[]'); } catch (e) { return []; }
  }

  function seconds(n) {
    if (n == null || n === '') return null;
    n = Number(n);
    if (!isFinite(n)) return null;
    return n > 200 ? n / 1000 : n;
  }

  function mark(el) {
    if (!el) return;
    el.style.background = '#f6e27a';
    el.style.borderRadius = '4px';
    if (el.scrollIntoView) el.scrollIntoView({ block: 'nearest', inline: 'nearest' });
  }

  function highlight(box, t, duration) {
    var words = box.querySelectorAll('.ta-word');
    words.forEach(function (w) { w.style.background = ''; });
    if (!words.length || t < 0) return;
    var states = statesOf(box);
    var hit = null;
    for (var i = 0; i < states.length; i++) {
      var start = seconds(states[i].start);
      var end = seconds(states[i].end);
      if (start == null) continue;
      if (t >= start && (end == null || t < end)) hit = states[i];
    }
    if (hit && (hit.ayah || hit.word)) {
      mark(box.querySelector('.ta-word[data-a="' + hit.ayah + '"][data-w="' + hit.word + '"]'));
      return;
    }
    var total = duration;
    if (!total || !isFinite(total)) total = Number(box.getAttribute('data-seconds')) || 0;
    if (total <= 0) total = words.length;
    var index = Math.min(words.length - 1, Math.floor((t / total) * words.length));
    mark(words[index]);
  }

  function ensureModal() {
    var pop = document.getElementById('ta-pop');
    if (pop) return pop;
    pop = document.createElement('div');
    pop.id = 'ta-pop';
    pop.style.cssText = 'display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:10050;align-items:center;justify-content:center;padding:1rem';
    pop.innerHTML = ''
      + '<div style="background:#fff;width:min(760px,96vw);max-height:92vh;overflow:auto;border-radius:18px;padding:1rem 1.15rem 1.25rem;box-shadow:0 20px 50px rgba(0,0,0,.18)">'
      + '<div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;margin-bottom:.6rem">'
      + '<strong id="ta-pop-title"></strong>'
      + '<button type="button" id="ta-pop-close" class="btn btn-default btn-sm">Close</button>'
      + '</div>'
      + '<div id="ta-pop-meta" style="color:#64748b;font-size:.85rem;margin-bottom:.45rem"></div>'
      + '<div style="display:flex;flex-wrap:wrap;gap:.5rem;align-items:center;margin-bottom:.55rem">'
      + '<label for="ta-pop-format" style="font-size:.8rem;color:#475569;margin:0">Text</label>'
      + '<select id="ta-pop-format" class="form-control input-sm" style="width:auto">'
      + '<option value="novice">Novice — letter and vowel</option>'
      + '<option value="beginner">Beginner — vowels marked</option>'
      + '<option value="medium" selected>Medium — Uthmani</option>'
      + '<option value="advanced">Advanced — mushaf line</option>'
      + '<option value="muraja">Muraja\'a — letters only</option>'
      + '</select>'
      + '<span id="ta-pop-format-note" style="font-size:.75rem;color:#64748b"></span>'
      + '</div>'
      + '<div class="ta-play" id="ta-pop-play" data-surah="0" data-from="1" data-to="1" data-seconds="0">'
      + '<div class="ta-text" dir="rtl" style="font-size:1.7rem;line-height:2.4;text-align:center;padding:1.2rem 1rem;background:#f7f4ea;border:2px solid #1e293b;border-radius:16px;min-height:8rem"></div>'
      + '<audio class="ta-audio" controls style="width:100%;margin-top:.7rem"></audio>'
      + '<div class="ta-states" hidden>[]</div>'
      + '</div></div>';
    document.body.appendChild(pop);
    var formatNote = {
      novice: 'Each letter stands apart. Orange marks are the vowels to pronounce.',
      beginner: 'Full Uthmani. Orange marks are the vowels.',
      medium: 'The usual Uthmani line.',
      advanced: 'A tighter mushaf line, still with vowels.',
      muraja: 'Vowels are hidden. Read the letters from memory.'
    };
    function applyFormat() {
      var sel = pop.querySelector('#ta-pop-format');
      var innerBox = pop.querySelector('.ta-play');
      var mode = sel ? sel.value : 'medium';
      innerBox.setAttribute('data-format', mode);
      pop.querySelector('#ta-pop-format-note').textContent = formatNote[mode] || '';
      if (innerBox._pack) paint(innerBox, innerBox._pack);
    }
    pop.querySelector('#ta-pop-format').addEventListener('change', applyFormat);
    pop.querySelector('#ta-pop-close').addEventListener('click', function () {
      var audio = pop.querySelector('.ta-audio');
      if (audio) audio.pause();
      pop.style.display = 'none';
    });
    pop.addEventListener('click', function (e) {
      if (e.target === pop) pop.querySelector('#ta-pop-close').click();
    });
    var modalAudio = pop.querySelector('.ta-audio');
    var inner = pop.querySelector('.ta-play');
    function tick() { highlight(inner, modalAudio.currentTime, modalAudio.duration); }
    modalAudio.addEventListener('timeupdate', tick);
    modalAudio.addEventListener('seeked', tick);
    return pop;
  }

  function openPopup(box) {
    var pop = ensureModal();
    var inner = pop.querySelector('.ta-play');
    var srcAudio = box.querySelector('.ta-audio');
    if (srcAudio) srcAudio.pause();
    inner.setAttribute('data-surah', box.getAttribute('data-surah') || '0');
    inner.setAttribute('data-from', box.getAttribute('data-from') || '1');
    inner.setAttribute('data-to', box.getAttribute('data-to') || box.getAttribute('data-from') || '1');
    inner.setAttribute('data-seconds', box.getAttribute('data-seconds') || '0');
    var states = box.querySelector('.ta-states');
    inner.querySelector('.ta-states').textContent = states ? states.textContent : '[]';
    var surah = Number(inner.getAttribute('data-surah')) || 0;
    var chosen = pop.querySelector('#ta-pop-format');
    var mode = chosen ? chosen.value : 'medium';
    inner.setAttribute('data-format', mode);
    var notes = {
      novice: 'Each letter stands apart. Orange marks are the vowels to pronounce.',
      beginner: 'Full Uthmani. Orange marks are the vowels.',
      medium: 'The usual Uthmani line.',
      advanced: 'A tighter mushaf line, still with vowels.',
      muraja: 'Vowels are hidden. Read the letters from memory.'
    };
    var note = pop.querySelector('#ta-pop-format-note');
    if (note) note.textContent = notes[mode] || '';
    loadSurah(surah).then(function (pack) {
      inner._pack = pack;
      paint(inner, pack);
      var from = inner.getAttribute('data-from');
      var to = inner.getAttribute('data-to');
      var ayahLabel = from === to ? 'Ayah ' + from : 'Ayahs ' + from + '–' + to;
      pop.querySelector('#ta-pop-title').textContent = (pack.english || 'Surah') + ' · ' + ayahLabel;
      var first = (pack.ayahs || []).filter(function (a) { return String(a.numberInSurah) === String(from); })[0];
      pop.querySelector('#ta-pop-meta').textContent = first
        ? ('Page ' + (first.page || '—') + ' · Juz ' + (first.juz || '—'))
        : '';
      var audio = pop.querySelector('.ta-audio');
      audio.src = srcAudio ? (srcAudio.currentSrc || srcAudio.getAttribute('src') || '') : '';
      pop.style.display = 'flex';
      if (audio.src) audio.play();
    });
  }

  document.querySelectorAll('.ta-play').forEach(function (box) {
    var surah = Number(box.getAttribute('data-surah')) || 0;
    if (surah < 1) return;
    loadSurah(surah).then(function (pack) { paint(box, pack); });
    var audio = box.querySelector('.ta-audio');
    if (!audio) return;
    audio.addEventListener('play', function () {
      audio.pause();
      openPopup(box);
    });
  });
})();
