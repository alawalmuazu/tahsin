const CACHE_NAME = 'smartschool-cache-v1';
const urlsToCache = [
  '/',
  '/assets/js/offline-queue.js',
  '/assets/vendor/sweetalert/sweetalert.min.js'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', event => {
  // We use a Network First, fallback to cache approach.
  if (event.request.method === 'GET') {
      event.respondWith(
        fetch(event.request).catch(() => {
          return caches.match(event.request);
        })
      );
  }
});
