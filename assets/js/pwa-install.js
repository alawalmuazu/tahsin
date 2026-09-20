/**
 * PWA install helper — Android/Chrome prompt + iOS Add to Home Screen tip.
 */
(function () {
  'use strict';

  var DISMISS_KEY = 'tahsin_pwa_install_dismissed';
  var deferredPrompt = null;

  function isStandalone() {
    return window.matchMedia('(display-mode: standalone)').matches
      || window.navigator.standalone === true;
  }

  function isIos() {
    return /iphone|ipad|ipod/i.test(window.navigator.userAgent)
      || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
  }

  function wasDismissed() {
    try {
      return localStorage.getItem(DISMISS_KEY) === '1';
    } catch (e) {
      return false;
    }
  }

  function dismiss() {
    try {
      localStorage.setItem(DISMISS_KEY, '1');
    } catch (e) { /* ignore */ }
    var el = document.getElementById('tahsin-pwa-banner');
    if (el) {
      el.classList.remove('is-visible');
    }
  }

  function showBanner(mode) {
    var el = document.getElementById('tahsin-pwa-banner');
    if (!el) {
      return;
    }
    var msg = el.querySelector('[data-pwa-msg]');
    var action = el.querySelector('[data-pwa-action]');
    if (mode === 'ios') {
      if (msg) {
        msg.textContent = 'Add Tahsin to your Home Screen: tap Share, then “Add to Home Screen”.';
      }
      if (action) {
        action.hidden = true;
      }
    } else {
      if (msg) {
        msg.textContent = 'Install Tahsin on your phone for quick access.';
      }
      if (action) {
        action.hidden = false;
      }
    }
    el.classList.add('is-visible');
  }

  if ('serviceWorker' in navigator) {
    var swUrl = (typeof base_url === 'string' ? base_url : '/') + 'sw.js';
    navigator.serviceWorker.register(swUrl).catch(function () { /* silent */ });
  }

  if (isStandalone() || wasDismissed()) {
    return;
  }

  window.addEventListener('beforeinstallprompt', function (e) {
    e.preventDefault();
    deferredPrompt = e;
    showBanner('android');
  });

  document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('tahsin-pwa-banner');
    if (!el) {
      return;
    }

    var action = el.querySelector('[data-pwa-action]');
    var closeBtn = el.querySelector('[data-pwa-dismiss]');

    if (action) {
      action.addEventListener('click', function () {
        if (!deferredPrompt) {
          return;
        }
        deferredPrompt.prompt();
        deferredPrompt.userChoice.finally(function () {
          deferredPrompt = null;
          dismiss();
        });
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', dismiss);
    }

    // iOS never fires beforeinstallprompt — show tip on small screens
    if (isIos() && !isStandalone() && window.matchMedia('(max-width: 900px)').matches) {
      showBanner('ios');
    }
  });
})();
