self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('weather-app-cache')
            .then(cache => cache.addAll([
                '/',
                'index.html',
                'style.css',
                'chat.js'
                // Add other assets here
            ]))
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});