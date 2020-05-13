const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const WebpackBundleAnalyzer = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const WorkboxPlugin = require('workbox-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const webpack = require('webpack');

/**
 * @deprecated 不需要再依赖 git hash 作为更新的 key 值
 */
function replaceVersionCode() {
  let fs = require("fs");
  let gitHEAD = fs.readFileSync('.git/HEAD', 'utf-8').trim();
  let ref = gitHEAD.split(': ')[1];
  let gitCommitHashCode = fs.readFileSync('.git/' + ref, 'utf-8').trim();
  let sourcePath = path.resolve(__dirname, '../assets/scripts/sw.js');
  let content = fs.readFileSync(sourcePath, 'utf-8');
  let targetPath = path.resolve(__dirname, '../inc/sw.php');

  gitCommitHashCode = gitCommitHashCode.substring(0, 6);
  content = content.replace(/{{GIT_COMMIT_HASH}}/, gitCommitHashCode);
  fs.writeFileSync(targetPath, content);
  console.log(`git hash code is ${gitCommitHashCode}`);
}

module.exports = (env, argv) => {
  const isDevMode = (argv.mode !== 'production');
  console.log(`当前的开发模式为：${process ? 'dev' : 'production'}`);
  return {
    name: 'wp-theme-pure',
    devtool: isDevMode ? 'source-map' : '',
    entry: {
      main: './assets/scripts/index.js',
    },
    resolve: {
      modules: ['node_modules'],
      alias: {
        '@': path.resolve(__dirname, '../node_modules/'),
      },
    },
    output: {
      filename: '[name].[contenthash:8].min.js',
      chunkFilename: '[name].[contenthash:8].js',
      path: path.resolve(__dirname, '../dist'),
      publicPath: '/wp-content/themes/pure/dist/',
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          include: [
            path.resolve(__dirname, '../assets'),
          ],
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
          },
        },
        {
          test: /\.[s]?css$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader', // 将 CSS 转化成 CommonJS 模块
              options: {
                sourceMap: isDevMode,
              },
            },
            {
              loader: 'postcss-loader',
              options: {
                sourceMap: isDevMode,
              },
            },
            {
              loader: 'sass-loader', // 将 Sass 编译成 CSS，默认使用 Node Sass
              options: {
                sourceMap: isDevMode,
              },
            },
          ]
        },
      ]
    },
    plugins: [
      new CleanWebpackPlugin(),
      new MiniCssExtractPlugin({
        filename: "[name].min.css",
        chunkFilename: "[id].css"
      }),
      // new WebpackBundleAnalyzer(),
      new WorkboxPlugin.GenerateSW({
        // importWorkboxFrom: 'local',
        // chunks: ['main'],
        inlineWorkboxRuntime: true,
        directoryIndex: './dist/',
        swDest: 'service-worker.js',
        // swDest: 'service-worker',
        offlineGoogleAnalytics: true,
        // clientsClaim: true,
        // skipWaiting: false,
        sourcemap: isDevMode,
        cleanupOutdatedCaches: true,
        include: [
        ],
        exclude: [
          /wp-admin/
        ],
        ignoreURLParametersMatching: [],
        cacheId: 'pure-theme-cache',
        runtimeCaching: [
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
            urlPattern:/\.php/,
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
            urlPattern: /^(?:http|https):\/\/static.bluest.xyz\/(?:(?:[^?#]*)).(?:(?:jpg|jpeg|png|gif|webp|mp3|svg)(?:|\?(?:[^\/]*)))$/g,
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
          // 缓存 Gavatar
          {
            urlPattern: /^(?:http|https):\/\/([0-9]|secure).gravatar.com\/avatar\//,
            handler: 'CacheFirst',
            options: {
              expiration: {
                maxAgeSeconds: 60 * 60 * 24 * 30,
              },
              cacheName: 'pure-theme-cache-gavatar',
            },
          },
          {
            urlPattern: /^(?:http|https):\/\/cdn.v2ex.com\/gravatar\//,
            handler: 'CacheFirst',
            options: {
              expiration: {
                maxAgeSeconds: 60 * 60 * 24 * 30,
              },
              cacheName: 'pure-theme-cache-gavatar',
            },
          },
          {
            urlPattern: /^(?:http|https):\/\/gravatar.loli.net\/avatar\//,
            handler: 'CacheFirst',
            options: {
              expiration: {
                maxAgeSeconds: 60 * 60 * 24 * 30,
              },
              cacheName: 'pure-theme-cache-gavatar',
            },
          },
          {
            urlPattern: /^(?:http|https):\/\/dn-qiniu-avatar.qbox.me\/avatar\//,
            handler: 'CacheFirst',
            options: {
              expiration: {
                maxAgeSeconds: 60 * 60 * 24 * 30,
              },
              cacheName: 'pure-theme-cache-gavatar',
            },
          }
        ],
      }),
        new HtmlWebpackPlugin({
        filename: 'footer_script.php',
        template: './template/footer_script.ejs',
        inject: false,
        minify: true,
      }),
    ],
    performance: {
      hints: 'error',
    },
    stats: 'verbose',
    // stats: {
    //   errors: true,
    //   warnings: true,
    //   timings: true,
    //   version: true,
    //   moduleTrace: true,
    //   errorDetails: true
    // },
    optimization: {
      splitChunks: {
        chunks: 'async',
        minSize: 30000,
        minChunks: 1,
        maxAsyncRequests: 5,
        maxInitialRequests: 3,
        name: true,
        cacheGroups: {
          vendors: {
            test: /[\\/]node_modules[\\/]/,
            priority: -10,
            reuseExistingChunk: true,
            filename: '[name].[contenthash:8].js'
          },
          styles: {
            name: 'main',
            test: /\.css$/,
            chunks: 'all',
            enforce: true
          },
          default: {
            minChunks: 2,
            priority: -20,
            reuseExistingChunk: true
          }
        }
      },
      minimizer: [
        new UglifyJSPlugin({
          cache: true,
          parallel: true,
          sourceMap: isDevMode // set to true if you want JS source maps
        }),
        new OptimizeCSSAssetsPlugin({
          assetNameRegExp: /\.css\.*(?!.*map)/g,
          cssProcessor: require('cssnano'),
          cssProcessorPluginOptions: {
            preset: [
              'default',
              {
                discardComments: {
                  removeAll: true,
                },
                normalizeUnicode: false,
                autoprefixer: {
                  disable: true
                },
                safe: true,
              },
            ],
          },
          canPrint: true
        }),
      ],
    },
  };
};
