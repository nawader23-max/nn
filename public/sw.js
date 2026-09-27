/*
 * Nawader PWA Service Worker — Sovereign Oasis v1
 * Strategy: network-first for navigations (fresh HTML), cache-first for
 * static assets (scenes, icons, built CSS/JS, fonts). Offline fallback to
 * the last cached page.
 */
const CACHE_VERSION = 'nawader-oasis-v1';
const SHELL_ASSETS = [
    '/manifest.webmanifest',
    '/images/app-icons/pwa-192x192.png',
    '/images/app-icons/pwa-512x512.png',
    '/images/app-icons/apple-touch-icon.png',
    '/images/scenes/home-city.webp',
    '/images/cinematic/nawader-moon-emblem-v1.webp',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_VERSION)
            .then((cache) => Promise.allSettled(SHELL_ASSETS.map((url) => cache.add(url))))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(keys.filter((k) => k !== CACHE_VERSION).map((k) => caches.delete(k))))
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const { request } = event;
    if (request.method !== 'GET') return;

    const url = new URL(request.url);
    if (url.origin !== self.location.origin && !url.hostname.endsWith('gstatic.com') && !url.hostname.endsWith('googleapis.com')) {
        return;
    }

    // Navigations: network-first, cache fallback (offline page reuse)
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then((response) => {
                    const copy = response.clone();
                    caches.open(CACHE_VERSION).then((cache) => cache.put('/offline-shell' + url.pathname, copy)).catch(() => {});
                    return response;
                })
                .catch(async () => {
                    const cached = await caches.match('/offline-shell' + url.pathname);
                    return cached || caches.match('/') || Response.error();
                })
        );
        return;
    }

    // Static assets & fonts: cache-first
    if (url.pathname.startsWith('/build/') || /\.(webp|png|jpg|jpeg|svg|css|js|woff2?)(\?.*)?$/.test(url.pathname) || url.hostname.endsWith('gstatic.com') || url.hostname.endsWith('googleapis.com')) {
        event.respondWith(
            caches.match(request).then((cached) => {
                if (cached) return cached;
                return fetch(request).then((response) => {
                    if (response.ok || response.type === 'opaque') {
                        const copy = response.clone();
                        caches.open(CACHE_VERSION).then((cache) => cache.put(request, copy)).catch(() => {});
                    }
                    return response;
                });
            })
        );
    }
});
