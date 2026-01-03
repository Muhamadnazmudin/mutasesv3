const CACHE_NAME = "mutases";

const urlsToCache = [
	"/mutases/index.php",
	"/mutases/assets/css/bootstrap.min.css",
	"/mutases/assets/js/bootstrap.bundle.min.js",
];

self.addEventListener("install", (event) => {
	event.waitUntil(
		caches.open(CACHE_NAME).then(async (cache) => {
			for (const url of urlsToCache) {
				try {
					await cache.add(url);
				} catch (err) {
					console.warn("Gagal cache:", url, err);
				}
			}
		})
	);
	self.skipWaiting();
});

self.addEventListener("activate", (event) => {
	event.waitUntil(self.clients.claim());
});

self.addEventListener("fetch", (event) => {
	event.respondWith(
		caches.match(event.request).then((response) => {
			return response || fetch(event.request);
		})
	);
});
