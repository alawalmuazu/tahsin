(function () {
  'use strict';

  var nav = document.querySelector('.ta-nav');
  var toggle = document.querySelector('.ta-menu-btn');

  function onScroll() {
    if (!nav) return;
    nav.classList.toggle('is-scrolled', window.scrollY > 12);
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  document.querySelectorAll('.ta-links a').forEach(function (link) {
    link.addEventListener('click', function () {
      if (nav) nav.classList.remove('is-open');
    });
  });
})();
