/* Quran playlist service worker. Android installs only if this page is served without Cache-Control: no-store. */
var CACHE = 'quran-playlist-v6';

function storeable(response) {
	var headers = new Headers(response.headers);
	['cache-control', 'expires', 'pragma', 'set-cookie', 'content-encoding', 'content-length'].forEach(function (name) {
		headers.delete(name);
	});
	headers.set('cache-control', 'public, max-age=300');
	return response.blob().then(function (body) {
		return new Response(body, {
			status: response.status,
			statusText: response.statusText,
			headers: headers
		});
	});
}

self.addEventListener('install', function (event) {
	event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', function (event) {
	event.waitUntil(
		caches.keys().then(function (keys) {
			return Promise.all(keys.filter(function (key) {
				return key.indexOf('quran-playlist-') === 0 && key !== CACHE;
			}).map(function (key) {
				return caches.delete(key);
			}));
		}).then(function () {
			return self.clients.claim();
		})
	);
});

self.addEventListener('message', function (event) {
	var data = event.data || {};
	if (data.type === 'claim') {
		event.waitUntil(self.clients.claim());
		return;
	}
	if (data.type !== 'cache' || !data.url) {
		return;
	}
	var port = event.ports && event.ports[0];
	event.waitUntil(
		caches.open(CACHE).then(function (cache) {
			return fetch(data.url, { credentials: 'same-origin' }).then(function (response) {
				if (!response || !response.ok) {
					return;
				}
				return storeable(response).then(function (copy) {
					return cache.put(data.url, copy);
				});
			});
		}).then(function () {
			if (port) port.postMessage({ ok: true });
		}).catch(function () {
			if (port) port.postMessage({ ok: false });
		})
	);
});

self.addEventListener('push', function (event) {
	var data = {};
	try {
		data = event.data ? event.data.json() : {};
	} catch (e) {}
	var title = data.title || 'Tahsin Academy';
	var options = {
		body: data.body || 'A session was acknowledged.',
		data: { url: data.url || self.registration.scope },
		tag: data.tag || 'tahsin-ack',
		renotify: true
	};
	if (data.icon) options.icon = data.icon;
	event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function (event) {
	event.notification.close();
	var url = (event.notification.data && event.notification.data.url) || self.registration.scope;
	event.waitUntil(self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (list) {
		var i;
		for (i = 0; i < list.length; i++) {
			if (list[i].url === url && 'focus' in list[i]) {
				return list[i].focus();
			}
		}
		if (self.clients.openWindow) {
			return self.clients.openWindow(url);
		}
	}));
});

self.addEventListener('fetch', function (event) {
	if (event.request.method !== 'GET' || event.request.mode !== 'navigate') {
		return;
	}
	var url = new URL(event.request.url);
	if (url.origin !== self.location.origin || !/\/quran(\/|$)/.test(url.pathname)) {
		return;
	}
	event.respondWith(
		caches.open(CACHE).then(function (cache) {
			return fetch(event.request).then(function (response) {
				if (!response || !response.ok) {
					return response;
				}
				return storeable(response.clone()).then(function (copy) {
					return cache.put(event.request, copy.clone()).then(function () {
						return copy;
					});
				}).catch(function () {
					return response;
				});
			}).catch(function () {
				return cache.match(event.request).then(function (cached) {
					return cached || new Response('Open this page once while online, then it can be installed.', {
						status: 503,
						headers: { 'Content-Type': 'text/plain; charset=utf-8' }
					});
				});
			});
		})
	);
});
