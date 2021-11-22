const runtimeCaching = [
  {
    urlPattern: /\.(?:json)/,
    handler: 'NetworkOnly',
    options: {
      matchOptions: {
        ignoreSearch: false,
      },
    },
  },
  {
    urlPattern: /\/wp-json\/wp_theme_pure\/v1\/manifest.json$/,
    handler: 'NetworkOnly',
    options: {
      matchOptions: {
        ignoreSearch: false,
      },
    },
  },
  {
    urlPattern: /\.(?:png|jpg|jpeg|svg|webp)/,
    handler: 'CacheFirst',
    options: {
      matchOptions: {
        ignoreSearch: false,
      },
      cacheName: 'pure-theme-cache-image',
      expiration: {
        maxAgeSeconds: 60 * 60 * 24 * 30,
      },
    },
  },
  {
    urlPattern: /\.(?:js|css)(?:(|\?(?:[^\/]*)))$/,
    handler: 'CacheFirst',
    options: {
      matchOptions: {
        ignoreSearch: false,
      },
      cacheName: 'pure-theme-cache-js-css',
      expiration: {
        maxAgeSeconds: 60 * 60 * 24 * 7,
      },
    },
  },
  {
    urlPattern: /\.(?:html)$/,
    handler: 'StaleWhileRevalidate',
    options: {
      cacheableResponse: {
        statuses: [0, 200]
      }
    },
  },
  {
    urlPattern: /\.php/,
    handler: 'NetworkOnly',
    options: {
    },
  },
  {
    urlPattern: /wp-admin/,
    handler: 'NetworkOnly',
    options: {
    },
  },
  // 缓存首页
  {
    urlPattern: /(|\/)$/,
    handler: 'StaleWhileRevalidate',
    options: {
      cacheableResponse: {
        statuses: [0, 200]
      }
    },
  },
  // 分类
  {
    urlPattern: /\/category\//,
    handler: 'StaleWhileRevalidate',
    options: {
      cacheableResponse: {
        statuses: [0, 200]
      }
    },
  },
  // tag
  {
    urlPattern: /\/tag\//,
    handler: 'StaleWhileRevalidate',
    options: {
      cacheableResponse: {
        statuses: [0, 200]
      }
    },
  },
  // 分页
  {
    urlPattern: /\/page\/\d+/,
    handler: 'StaleWhileRevalidate',
    options: {
      cacheableResponse: {
        statuses: [0, 200],
      },
    },
  },
  // CDN 图片
  {
    urlPattern: /^(?:http|https):\/\/static.bluest.xyz\/(?:(?:[^?#]*)).(?:(?:jpg|jpeg|png|gif|webp|mp3|svg)(?:|\?(?:[^\/]*)))/g,
    handler: 'CacheFirst',
    options: {
      fetchOptions: {
        mode: 'no-cors',
      },
      cacheableResponse: {
        statuses: [0, 200]
      },
      expiration: {
        maxAgeSeconds: 60 * 60 * 24 * 30,
      },
      cacheName: 'pure-theme-cache-cdn-static',
    }
  },
  {
    urlPattern: /^(?:http|https):\/\/static.bluest.xyz\/(?:(?:[^?#]*)).(?:(?:js|css)(?:|\?(?:[^\/]*)))$/g,
    handler: 'CacheFirst',
    options: {
      fetchOptions: {
        mode: 'no-cors',
      },
      cacheableResponse: {
        statuses: [0, 200]
      },
    }
  },
  {
    urlPattern: /^(?:http|https):\/\/asset.bluest.xyz\/(?:(?:[^?#]*)).(?:(?:jpg|jpeg|png|gif|webp|mp3|svg)(?:|\?(?:[^\/]*)))$/g,
    handler: 'CacheFirst',
    options: {
      fetchOptions: {
        mode: 'no-cors',
      },
      cacheableResponse: {
        statuses: [0, 200]
      },
      expiration: {
        maxAgeSeconds: 60 * 60 * 24 * 30,
      },
      cacheName: 'pure-theme-cache-cdn-static',
    }
  },
  {
    urlPattern: /^(?:http|https):\/\/asset.bluest.xyz\/(?:(?:[^?#]*)).(?:(?:js|css)(?:|\?(?:[^\/]*)))$/g,
    handler: 'CacheFirst',
    options: {
      fetchOptions: {
        mode: 'no-cors',
      },
      cacheableResponse: {
        statuses: [0, 200]
      },
    }
  },
  {
    urlPattern: /\/wp-json\/wp_theme_pure\/v1\/manifest.json\$/,
    handler: 'CacheFirst',
    options: {
      expiration: {
        maxAgeSeconds: 60 * 60 * 24 * 30,
      },
      cacheName: 'pure-theme-cache-manifest',
    },
  },
  // 缓存 Gavatar
  // {
  //   urlPattern: /^(?:http|https):\/\/([0-9]|secure).gravatar.com\/avatar\//,
  //   handler: 'CacheFirst',
  //   options: {
  //     expiration: {
  //       maxAgeSeconds: 60 * 60 * 24 * 30,
  //     },
  //     cacheName: 'pure-theme-cache-gavatar',
  //   },
  // },
  // {
  //   urlPattern: /^(?:http|https):\/\/cdn.v2ex.com\/gravatar\//,
  //   handler: 'CacheFirst',
  //   options: {
  //     expiration: {
  //       maxAgeSeconds: 60 * 60 * 24 * 30,
  //     },
  //     cacheName: 'pure-theme-cache-gavatar',
  //   },
  // },
  // {
  //   urlPattern: /^(?:http|https):\/\/gravatar.loli.net\/avatar\//,
  //   handler: 'CacheFirst',
  //   options: {
  //     expiration: {
  //       maxAgeSeconds: 60 * 60 * 24 * 30,
  //     },
  //     cacheName: 'pure-theme-cache-gavatar',
  //   },
  // },
  // {
  //   urlPattern: /^(?:http|https):\/\/dn-qiniu-avatar.qbox.me\/avatar\//,
  //   handler: 'CacheFirst',
  //   options: {
  //     expiration: {
  //       maxAgeSeconds: 60 * 60 * 24 * 30,
  //     },
  //     cacheName: 'pure-theme-cache-gavatar',
  //   },
  // },
  {
    urlPattern: /^(?:http|https):\/\/gravatar.bluest.xyz\/avatar\//,
    handler: 'CacheFirst',
    options: {
      expiration: {
        maxAgeSeconds: 60 * 60 * 24 * 30,
      },
      cacheName: 'pure-theme-cache-gavatar',
    },
  }
];

module.exports = {
  runtimeCaching,
};
