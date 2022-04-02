importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js');
const staticCacheName = 'atualizacao-2020-04-07 08:34';
self.addEventListener('install', function (event) {
    self.skipWaiting();
    event.waitUntil(
    caches.open(staticCacheName).then(function (cache) {
      return cache.addAll([
        'https://zmsys.com.br/sergiuspasteis/pediucerto/manifest.json',
        'index.php',
        './admin',
        './api',
        './config',
        './controller',
        './resources',
      ]);
    })
  )
});
self.addEventListener('activate', function (event) {

});

self.addEventListener('fetch', function (event) {

});
