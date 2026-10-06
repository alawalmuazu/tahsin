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

(function (window, document, $) {
  'use strict';
  if (!$ || !window.File || !window.DataTransfer) return;

  var MAX_EDGE = 1600;
  var START_QUALITY = 0.86;
  var TARGET_BYTES = 900 * 1024;

  function formatBytes(n) {
    n = Number(n) || 0;
    if (n < 1024 * 1024) return Math.max(1, Math.round(n / 1024)) + ' KB';
    return (n / (1024 * 1024)).toFixed(2) + ' MB';
  }

  function hint($desk, text, isError) {
    var $el = $desk.find('.photo-compress-hint');
    $el.text(text || '');
    $el.toggleClass('text-danger', !!isError);
    $el.toggleClass('text-muted', !isError);
  }

  function loadSource(file) {
    if (window.createImageBitmap) {
      try {
        return createImageBitmap(file, { imageOrientation: 'from-image' }).then(function (bitmap) {
          return { source: bitmap, width: bitmap.width, height: bitmap.height, close: function () { if (bitmap.close) bitmap.close(); } };
        }).catch(function () { return loadElement(file); });
      } catch (e) {
        return loadElement(file);
      }
    }
    return loadElement(file);
  }

  function loadElement(file) {
    return new Promise(function (resolve, reject) {
      var url = URL.createObjectURL(file);
      var img = new Image();
      img.onload = function () {
        URL.revokeObjectURL(url);
        resolve({ source: img, width: img.naturalWidth || img.width, height: img.naturalHeight || img.height, close: function () {} });
      };
      img.onerror = function () {
        URL.revokeObjectURL(url);
        reject(new Error('Could not read that picture'));
      };
      img.src = url;
    });
  }

  function canvasToBlob(canvas, quality) {
    return new Promise(function (resolve, reject) {
      canvas.toBlob(function (blob) {
        if (blob) resolve(blob);
        else reject(new Error('Could not prepare the photo'));
      }, 'image/jpeg', quality);
    });
  }

  function compress(file) {
    return loadSource(file).then(function (img) {
      var scale = Math.min(1, MAX_EDGE / Math.max(img.width, img.height));
      var canvas = document.createElement('canvas');
      canvas.width = Math.max(1, Math.round(img.width * scale));
      canvas.height = Math.max(1, Math.round(img.height * scale));
      var ctx = canvas.getContext('2d');
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      if (ctx.imageSmoothingQuality) ctx.imageSmoothingQuality = 'high';
      ctx.drawImage(img.source, 0, 0, canvas.width, canvas.height);
      img.close();
      function attempt(quality) {
        return canvasToBlob(canvas, quality).then(function (blob) {
          if (blob.size > TARGET_BYTES && quality > 0.64) return attempt(Math.round((quality - 0.08) * 100) / 100);
          return new File([blob], 'student.jpg', { type: 'image/jpeg', lastModified: Date.now() });
        });
      }
      return attempt(START_QUALITY);
    });
  }

  function assignFile(input, file) {
    var dt = new DataTransfer();
    dt.items.add(file);
    input.dataset.photoReady = '1';
    input.files = dt.files;
  }

  function useFile($desk, file) {
    var input = $desk.find('.js-photo-input')[0];
    if (!file || !input) return;
    var isImage = /^image\//i.test(file.type) || /\.(jpe?g|png|webp|heic|heif)$/i.test(file.name || '');
    if (!isImage) {
      hint($desk, 'Use a JPG or PNG, or take the photo with the camera.', true);
      return;
    }
    hint($desk, 'Preparing the photo…', false);
    compress(file).then(function (ready) {
      assignFile(input, ready);
      var preview = $desk.find('.photo-desk-preview')[0];
      if (preview) {
        if (preview.dataset.blobUrl) URL.revokeObjectURL(preview.dataset.blobUrl);
        var url = URL.createObjectURL(ready);
        preview.dataset.blobUrl = url;
        preview.src = url;
      }
      hint($desk, 'Ready · ' + formatBytes(ready.size) + '. It will be saved as a sharp JPEG without location data.', false);
    }).catch(function () {
      hint($desk, 'That picture could not be prepared. Try another photo.', true);
    });
  }

  function phoneCamera() {
    return window.matchMedia('(pointer: coarse)').matches || /Android|iPhone|iPad|Mobile/i.test(navigator.userAgent || '');
  }

  function ensureModal() {
    var modal = document.getElementById('photo-cam-modal');
    if (modal) return modal;
    modal = document.createElement('div');
    modal.id = 'photo-cam-modal';
    modal.innerHTML = '<div class="photo-cam-card"><video autoplay playsinline muted></video><div class="photo-cam-actions"><button type="button" class="btn btn-primary js-photo-snap">Use this photo</button><button type="button" class="btn btn-default js-photo-cam-close">Cancel</button></div></div>';
    document.body.appendChild(modal);
    var style = document.createElement('style');
    style.textContent = '#photo-cam-modal{display:none;position:fixed;inset:0;background:rgba(8,16,12,.72);z-index:10050;align-items:center;justify-content:center;padding:16px}#photo-cam-modal.is-open{display:flex}.photo-cam-card{background:#fff;padding:12px;width:min(440px,100%);border-radius:12px}.photo-cam-card video{width:100%;max-height:62vh;background:#111;border-radius:8px}.photo-cam-actions{display:flex;gap:8px;margin-top:10px}.photo-cam-actions .btn{flex:1;min-height:42px}';
    document.head.appendChild(style);
    return modal;
  }

  function stopCam(modal) {
    var video = modal.querySelector('video');
    var stream = video && video.srcObject;
    if (stream && stream.getTracks) stream.getTracks().forEach(function (track) { track.stop(); });
    if (video) video.srcObject = null;
    modal.classList.remove('is-open');
  }

  function openDesktopCamera($desk) {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
      $desk.find('.js-photo-camera-input').trigger('click');
      return;
    }
    var modal = ensureModal();
    stopCam(modal);
    var video = modal.querySelector('video');
    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false }).then(function (stream) {
      video.srcObject = stream;
      modal.classList.add('is-open');
      modal._desk = $desk;
    }).catch(function () {
      $desk.find('.js-photo-camera-input').trigger('click');
    });
    $(modal).off('click.photoCam').on('click.photoCam', '.js-photo-cam-close', function () {
      stopCam(modal);
    }).on('click.photoCam', '.js-photo-snap', function () {
      if (!video.videoWidth) return;
      var canvas = document.createElement('canvas');
      var scale = Math.min(1, MAX_EDGE / Math.max(video.videoWidth, video.videoHeight));
      canvas.width = Math.max(1, Math.round(video.videoWidth * scale));
      canvas.height = Math.max(1, Math.round(video.videoHeight * scale));
      canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
      canvas.toBlob(function (blob) {
        stopCam(modal);
        if (blob && modal._desk) useFile(modal._desk, new File([blob], 'camera.jpg', { type: 'image/jpeg' }));
      }, 'image/jpeg', 0.92);
    });
  }

  $(function () {
    $(document).on('click', '.js-photo-file', function () {
      var input = $(this).closest('.js-photo-desk').find('.js-photo-input')[0];
      if (!input) return;
      input.dataset.photoReady = '';
      input.click();
    });
    $(document).on('click', '.js-photo-camera', function () {
      var $desk = $(this).closest('.js-photo-desk');
      if (phoneCamera()) $desk.find('.js-photo-camera-input').trigger('click');
      else openDesktopCamera($desk);
    });
    $(document).on('change', '.js-photo-desk .js-photo-input, .js-photo-desk .js-photo-camera-input', function () {
      if (this.dataset.photoReady === '1') {
        this.dataset.photoReady = '';
        return;
      }
      var file = this.files && this.files[0];
      var $desk = $(this).closest('.js-photo-desk');
      if (this.classList.contains('js-photo-camera-input')) this.value = '';
      if (file) useFile($desk, file);
    });
  });
})(window, document, window.jQuery);
