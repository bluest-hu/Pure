const CACHE_NAME = 'cb08a2' + '_v_<?php echo get_option("pure_theme_pwa_cache_version"); ?>';

console.log(CACHE_NAME);
let initCacheResourceList = [
];

self.addEventListener('install', (event) => {
  caches.open(initCacheResourceList).then(cache => {
    console.log(cache);
  });
  event.waitUntil(
    // self.skipWaiting()
    Promise.all([
      caches.open(CACHE_NAME)
        .then(cache => cache.addAll(initCacheResourceList)),
      caches.keys()
        .then(cacheList => {
          cacheList.map(cacheName => {
            if (cacheName !== CACHE_NAME) {
              caches.delete(cacheName);
            }
          });
        })
    ])
  );
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        console.log('match', response);

        if (response) {
          return response;
        }
        let fetchRequest = event.request.clone();

        return fetch(fetchRequest)
          .then(response => {
            if (!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            let responseCache = response.clone();

            caches.open(CACHE_NAME)
              .then(cache => {
                cache.put(event.request, responseCache);
              });

            return response;
          });
      })
  );
});

self.addEventListener('active', (event) => {
  console.log('i am ', event);
});
