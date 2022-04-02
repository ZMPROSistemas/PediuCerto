
importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js');
const staticCacheName = 'atualizacao-2020-12-12 08:34';
self.addEventListener('install', function (event) {
    self.skipWaiting();

    event.waitUntil(
    caches.open(staticCacheName).then(function (cache) {
      return cache.addAll([
        //'http://localhost/pediucerto/manifest.json',
        'https://zmsys.com.br/pediucerto/pediucerto/manifest.json',
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
    // it can be empty if you just want to get rid of that error
});

/*

const cacheName = "firstVersion";

self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(cacheName).then(cache => cache.addAll(["login.php"]))
  );
});

self.addEventListener("fetch", function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      if (response) {
        return response;
      }
      return fetch(event.request);
    })
  );
});





// This is the "Offline page" service worker

importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js');

const CACHE = "pwabuilder-page";

// TODO: replace the following with the correct offline fallback page i.e.: const offlineFallbackPage = "offline.html";
const offlineFallbackPage = "login.php";

self.addEventListener("message", (event) => {
  if (event.data && event.data.type === "SKIP_WAITING") {
    self.skipWaiting();
  }
});

self.addEventListener('install', async (event) => {
  event.waitUntil(
    caches.open(CACHE)
      .then((cache) => cache.add(offlineFallbackPage))
  );
});

if (workbox.navigationPreload.isSupported()) {
  workbox.navigationPreload.enable();
}

self.addEventListener('fetch', (event) => {
  if (event.request.mode === 'navigate') {
    event.respondWith((async () => {
      try {
        const preloadResp = await event.preloadResponse;

        if (preloadResp) {
          return preloadResp;
        }

        const networkResp = await fetch(event.request);
        return networkResp;
      } catch (error) {

        const cache = await caches.open(CACHE);
        const cachedResp = await cache.match(offlineFallbackPage);
        return cachedResp;
      }
    })());
  }
});


*/

/*
importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js');
var CACHE_NAME = 'atualizacao-2020-04-07 08:34';

self.addEventListener('install', function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function (cache) {
      return cache.addAll([
        'login.php',
        'manifest.js',
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'dist/css/AdminLTE.min.css',
        '/plugins/iCheck/square/blue.css',
        'imagens/logo_mega.png',
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'plugins/iCheck/icheck.min.js'
        
      ]);
    })
  )
});

self.addEventListener('activate', function activator(event) {
  event.waitUntil(
    caches.keys().then(function (keys) {
      return Promise.all(keys
        .filter(function (key) {
          return key.indexOf(CACHE_NAME) !== 0;
        })
        .map(function (key) {
          return caches.delete(key);
        })
      );
    })
  );
});

self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request).then(function (cachedResponse) {
      return cachedResponse || fetch(event.request);
    })
  );
});

*/