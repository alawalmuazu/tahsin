/* Tahsin Academy PWA service worker */
const CACHE_NAME = 'tahsin-pwa-v2';
const PRECACHE = [
  './assets/images/pwa/icon-192.png',
  './assets/images/pwa/icon-512.png',
  './assets/js/offline-queue.js'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(PRECACHE)).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(keys.filter((k) => k.indexOf('tahsin-pwa-') === 0 && k !== CACHE_NAME).map((k) => caches.delete(k)))
    ).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') {
    return;
  }

  const url = new URL(event.request.url);
  if (url.origin !== self.location.origin) {
    return;
  }
  if (/\/quran(\/|$)/.test(url.pathname)) {
    return;
  }

  // Only cache static files. App pages stay with the browser.
  // A failed fetch here used to answer 503 and look like the WhatsApp send had failed.
  const isStatic = /\.(?:css|js|png|jpe?g|gif|webp|svg|woff2?|ttf|ico)$/i.test(url.pathname);
  if (!isStatic) {
    return;
  }

  event.respondWith(
    caches.match(event.request).then((cached) => {
      const fetched = fetch(event.request)
        .then((response) => {
          if (response && response.ok) {
            const clone = response.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(event.request, clone));
          }
          return response;
        })
        .catch(() => cached);
      return cached || fetched;
    })
  );
});
