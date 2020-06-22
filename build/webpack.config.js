const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const WebpackBundleAnalyzer = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const WorkboxPlugin = require('workbox-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
// const webpack = require('webpack');
// const copy = require('copy');
// const fs = require('fs');
const CopyPlugin = require('copy-webpack-plugin');
const { runtimeCaching } = require('./runtimeCaching.js');

// copy(
//   path.resolve(__dirname, '../node_modules/prismjs/components/*.min.js'),
//   path.resolve(__dirname, '../dist/prism-lan'),
//   function(err, files) {
//     if (!err) {
//       console.log('copy success!');
//     }
//   },
// );


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
  const isDevMode = (env.NODE_ENV !== 'production');
  // console.log('NODE_ENV: ', env, argv);
  console.log(`当前的开发模式为：${isDevMode ? 'dev' : 'production'}`);

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
      publicPath: isDevMode ? '/wp-content/themes/pure/dist/' : 'https://static.bluest.xyz/wp-content/themes/pure/dist/',
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
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: ['prism-lan/*'],
      }),
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
        runtimeCaching: runtimeCaching,
        include: [
        ],
        exclude: [
          /wp-admin/
        ],
        ignoreURLParametersMatching: [],
        cacheId: 'pure-theme-cache',
        
      }),
      new HtmlWebpackPlugin({
        filename: 'footer_script.php',
        template: './template/footer_script.ejs',
        inject: false,
        minify: true,
      }),
      new CopyPlugin({
        patterns: [
          {
            from: path.resolve(__dirname, '../node_modules/prismjs/components/*.min.js'),
            to: path.resolve(__dirname, '../dist/prism-lan/[name].[ext]'),
            toType: 'template',
            // transform(content, path) {
            //   return optimize(content);
            // },
            // cacheTransform: {
            //   directory: path.resolve(__dirname, '../dist/prism-lan'),
            //   key: process.version,
            // },
          }
        ]
      }),
    ],
    performance: {
      hints: 'error',
    },
    // stats: 'verbose',
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
