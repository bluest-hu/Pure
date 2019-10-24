const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CleanWebpackPlugin = require('clean-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const WebpackBundleAnalyzer = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const WorkboxPlugin = require('workbox-webpack-plugin');

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

const isDevMode = process.env.NODE_ENV !== 'production';

// console.log(process.env);

module.exports = {
  devtool: isDevMode ? 'source-map' : '',
  entry: {
    main: './assets/scripts/index.js',
    // 'service-worker': './assets/scripts/service-worker.js',
  },
  resolve: {
    modules: [path.resolve(__dirname, '../node_modules')],
    alias: {}
  },
  output: {
    filename: '[name].min.js',
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
        loader: 'babel-loader'
      },
      {
        test: /\.[s]?css$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader', // 将 CSS 转化成 CommonJS 模块
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'sass-loader', // 将 Sass 编译成 CSS，默认使用 Node Sass
            options: {
              sourceMap: true,
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
      importWorkboxFrom: 'local',
      // excludeChunks: ['main'],
      offlineGoogleAnalytics: true,
      cleanupOutdatedCaches: true,
      include: [
        // /\.(?:png|jpg|jpeg|svg)$/,
        // /\.js$/,
        // /\.css$/,
      ],
      exclude: [
        /^\/wp-content\/themes\/Pure\/dist\/main.js$/
      ],
      ignoreURLParametersMatching: [
        /^\/wp-admin/
      ],
      cacheId: 'pure-theme-cache',
      runtimeCaching: [
        {
          urlPattern: /\.(?:png|jpg|jpeg|svg|webp)$/,
          handler: 'CacheFirst',
          options: {
            matchOptions: {
              ignoreSearch: true,
            },
          },
        },
        {
          urlPattern: /\.(?:js|css)$/,
          handler: 'CacheFirst',
          options: {
            matchOptions: {
              ignoreSearch: true,
            },
          },
        },
        {
          urlPattern: /\.(?:html)$/,
          handler: 'NetworkFirst',
          options: {},
        },
        // 缓存首页
        {
          urlPattern: /\/$/,
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

        {
          urlPattern: /\/page\/\d+/,
          handler: 'StaleWhileRevalidate',
          options: {
            cacheableResponse: {
              statuses: [0, 200],
            },
          },
        },
        {
          urlPattern: /https:\/\/static\.bluest\.xyz\/.*.(?:jpg|jpeg|gif|png|webp)'/,
          handler: 'StaleWhileRevalidate',
          options: {
            fetchOptions: {
              mode: 'no-cors',
            },
            cacheableResponse: {
              statuses: [0, 200]
            }
          }
        },
        // 缓存 Gavatr
        {
          urlPattern: /^https:\/\/([0-9]|secure).gravatar.com\/avatar\/*/,
          handler: 'CacheFirst',
          options: {
          },
        }
      ],
    }),
  ],
  performance: {
    hints: 'error',
  },
  optimization: {
    splitChunks: {
      chunks: 'all',
      minSize: 30000,
      minChunks: 1,
      maxAsyncRequests: 5,
      maxInitialRequests: 3,
      name: true,
      cacheGroups: {
        styles: {
          name: 'main',
          test: /\.css$/,
          chunks: 'all',
          enforce: true
        }
      }
    },
    minimizer: [
      new UglifyJSPlugin({
        cache: true,
        parallel: true,
        sourceMap: false // set to true if you want JS source maps
      }),
      new OptimizeCSSAssetsPlugin({
        assetNameRegExp: /\.css\.*(?!.*map)/g,
        cssProcessor: require('cssnano'),
        // cssProcessorOptions: cssnanoOptions,
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

// replaceVersionCode();s
