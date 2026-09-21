/**
 * Student profile photo: client-side compress + Dropify preview refresh.
 * Targets input.js-photo-compress[name="user_photo"].
 */
(function (window, document, $) {
  'use strict';

  if (!$ || !window.File || !window.DataTransfer) {
    return;
  }

  var MAX_EDGE = 1280;
  var QUALITY = 0.82;
  var FORCE_BYTES = 500 * 1024;

  function formatBytes(n) {
    n = Number(n) || 0;
    if (n < 1024) return Math.round(n) + ' B';
    if (n < 1024 * 1024) return (n / 1024).toFixed(1) + ' KB';
    return (n / (1024 * 1024)).toFixed(2) + ' MB';
  }

  function setHint($input, text, isError) {
    var $hint = $input.closest('.form-group').find('.photo-compress-hint');
    if (!$hint.length) return;
    $hint.text(text || '');
    $hint.toggleClass('text-danger', !!isError);
    $hint.toggleClass('text-muted', !isError);
  }

  function loadImage(file) {
    return new Promise(function (resolve, reject) {
      var url = URL.createObjectURL(file);
      var img = new Image();
      img.onload = function () {
        URL.revokeObjectURL(url);
        resolve(img);
      };
      img.onerror = function () {
        URL.revokeObjectURL(url);
        reject(new Error('Could not read image'));
      };
      img.src = url;
    });
  }

  function canvasToBlob(canvas, quality) {
    return new Promise(function (resolve, reject) {
      if (canvas.toBlob) {
        canvas.toBlob(function (blob) {
          if (blob) resolve(blob);
          else reject(new Error('Compress failed'));
        }, 'image/jpeg', quality);
        return;
      }
      try {
        var dataUrl = canvas.toDataURL('image/jpeg', quality);
        var parts = dataUrl.split(',');
        var bin = atob(parts[1]);
        var arr = new Uint8Array(bin.length);
        for (var i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
        resolve(new Blob([arr], { type: 'image/jpeg' }));
      } catch (e) {
        reject(e);
      }
    });
  }

  function compressFile(file) {
    return loadImage(file).then(function (img) {
      var w = img.naturalWidth || img.width;
      var h = img.naturalHeight || img.height;
      var longEdge = Math.max(w, h);
      var scale = longEdge > MAX_EDGE ? MAX_EDGE / longEdge : 1;
      var nw = Math.max(1, Math.round(w * scale));
      var nh = Math.max(1, Math.round(h * scale));
      var canvas = document.createElement('canvas');
      canvas.width = nw;
      canvas.height = nh;
      var ctx = canvas.getContext('2d');
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, nw, nh);
      ctx.drawImage(img, 0, 0, nw, nh);
      return canvasToBlob(canvas, QUALITY).then(function (blob) {
        var base = (file.name || 'photo').replace(/\.[^.]+$/, '') + '.jpg';
        return new File([blob], base, { type: 'image/jpeg', lastModified: Date.now() });
      });
    });
  }

  function needsCompress(file, img, maxBytes) {
    var w = img.naturalWidth || img.width;
    var h = img.naturalHeight || img.height;
    if (Math.max(w, h) > MAX_EDGE) return true;
    if (file.size > FORCE_BYTES) return true;
    if (maxBytes > 0 && file.size > maxBytes) return true;
    return false;
  }

  function reinitDropify($input) {
    var inst = $input.data('dropify');
    if (inst && typeof inst.destroy === 'function') {
      try {
        inst.destroy();
      } catch (e) {}
      $input.removeData('dropify');
    }
    if (typeof $.fn.dropify === 'function') {
      $input.dropify();
    }
  }

  function assignFile(input, file) {
    var dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
  }

  function bind($input) {
    if ($input.data('photo-compress-bound')) return;
    $input.data('photo-compress-bound', true);

    $input.on('dropify.afterClear', function () {
      setHint($input, '');
    });

    $input.on('change.photoCompress', function () {
      var input = this;
      if ($input.data('compress-skip')) return;

      var file = input.files && input.files[0];
      if (!file) {
        setHint($input, '');
        return;
      }

      var isImage =
        /^image\//i.test(file.type) ||
        /\.(jpe?g|png|gif|bmp|webp)$/i.test(file.name || '');
      if (!isImage) return;

      var maxKb = parseFloat($input.attr('data-max-kb') || '0') || 0;
      var maxBytes = maxKb > 0 ? maxKb * 1024 : 0;
      var before = file.size;

      setHint($input, 'Compressing…');

      loadImage(file)
        .then(function (img) {
          if (!needsCompress(file, img, maxBytes)) {
            setHint($input, 'Ready: ' + formatBytes(before));
            return null;
          }
          return compressFile(file);
        })
        .then(function (compressed) {
          if (!compressed) return;

          $input.data('compress-skip', true);
          assignFile(input, compressed);
          reinitDropify($input);
          $input.trigger('change');
          $input.data('compress-skip', false);

          var after = compressed.size;
          var msg = 'Compressed: ' + formatBytes(before) + ' → ' + formatBytes(after);
          if (maxBytes > 0 && after > maxBytes) {
            msg += ' (still over ' + formatBytes(maxBytes) + ' limit)';
            setHint($input, msg, true);
          } else {
            setHint($input, msg, false);
          }
        })
        .catch(function (err) {
          var detail = err && err.message ? err.message : '';
          setHint(
            $input,
            'Could not compress — original will upload.' + (detail ? ' ' + detail : ''),
            true
          );
        });
    });
  }

  function init() {
    $('input.js-photo-compress[name="user_photo"]').each(function () {
      bind($(this));
    });
  }

  $(init);
})(window, document, window.jQuery);
