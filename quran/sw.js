/* Quran playlist service worker. Caches this child's page so Android can install it. */
var CACHE = 'quran-playlist-v4';

self.addEventListener('install', function (event) {
	event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', function (event) {
	event.waitUntil(self.clients.claim());
});

self.addEventListener('message', function (event) {
	var data = event.data || {};
	if (data.type !== 'cache' || !data.url) {
		return;
	}
	event.waitUntil(
		caches.open(CACHE).then(function (cache) {
			return fetch(data.url, { credentials: 'same-origin' }).then(function (response) {
				if (response && response.ok) {
					return cache.put(data.url, response);
				}
			});
		})
	);
});

self.addEventListener('fetch', function (event) {
	if (event.request.method !== 'GET') {
		return;
	}
	event.respondWith(
		fetch(event.request).then(function (response) {
			if (response && response.ok && event.request.mode === 'navigate') {
				var copy = response.clone();
				caches.open(CACHE).then(function (cache) {
					cache.put(event.request, copy);
				});
			}
			return response;
		}).catch(function () {
			return caches.match(event.request).then(function (cached) {
				return cached || new Response('Open this page once while online, then it can be installed.', {
					status: 503,
					headers: { 'Content-Type': 'text/plain; charset=utf-8' }
				});
			});
		})
	);
});
