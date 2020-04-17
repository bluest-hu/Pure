importScripts(
  "https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js"
);

const CACHE_PREFIX = "pure-theme-cache";

workbox.setConfig({
  debug: true,
  modulePathPrefix: "https://storage.googleapis.com/workbox-cdn/releases/4.3.1/"
});

workbox.googleAnalytics.initialize();

workbox.core.setCacheNameDetails({
  prefix: CACHE_PREFIX,
  suffix: "v1",
  precache: "precache",
  runtime: "runtime"
});

workbox.routing.registerRoute(
  new RegExp("/wp-admin/"),
  new workbox.strategies.NetworkOnly()
);

workbox.routing.registerRoute(
  /\.(?:png|jpg|jpeg|svg|gif)$/,
  new workbox.strategies.CacheFirst({
    cacheName: `${CACHE_PREFIX}-image`,
    plugins: [
      new workbox.expiration.Plugin({
        maxAgeSeconds: 30 * 24 * 60 * 60,
        purgeOnQuotaError: true
      })
    ]
  })
);

workbox.routing.registerRoute(
  /\.(?:js)$/,
  new workbox.strategies.CacheFirst({
    cacheName: `${CACHE_PREFIX}-js`
  })
);

workbox.routing.registerRoute(
  /\.(?:html)$/,
  new workbox.strategies.NetworkFirst({
    cacheName: `${CACHE_PREFIX}-post`
  })
);

workbox.routing.registerRoute(
  /\.(?:manifest.json)$/,
  new workbox.strategies.NetworkFirst({
    cacheName: `${CACHE_PREFIX}-manifest`
  })
);

// workbox.routing.registerRoute(
//   /^https:\/\/fonts\.gstatic\.com/,
//   new workbox.strategies.CacheFirst({
//     cacheName: 'google-fonts-webfonts',
//     plugins: [
//       new workbox.cacheableResponse.Plugin({
//         statuses: [0, 200],
//       }),
//       new workbox.expiration.Plugin({
//         maxAgeSeconds: 60 * 60 * 24 * 365,
//         maxEntries: 30,
//       }),
//     ],
//   })
// );
