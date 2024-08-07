const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin')
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const TerserPlugin = require("terser-webpack-plugin");
const WebpackBundleAnalyzer = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const WorkboxPlugin = require('workbox-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const { runtimeCaching } = require('./runtimeCaching.js');
const StylelintPlugin = require('stylelint-webpack-plugin');

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
  console.log(`当前的开发模式为：${isDevMode ? 'dev' : 'production'}`);

  const webpackPlugins =  [
    new CleanWebpackPlugin({
      cleanOnceBeforeBuildPatterns: [
        // '!prism-lan/*',
        path.resolve(__dirname, '../dist')
      ],
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
      offlineGoogleAnalytics: true,
      // clientsClaim: true,
      // skipWaiting: true,
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
	new StylelintPlugin({
		fix: true,
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
        }
      ]
    }),
  ];

  if (isDevMode) {
    webpackPlugins.concat([
      new webpack.HotModuleReplacementPlugin([]),
    ]);
  }

  return {
    name: 'wp-theme-pure',
    devtool: isDevMode ? 'source-map' : false,
    entry:  './assets/scripts/index.js',
    resolve: {
      modules: ['node_modules'],
      alias: {
        '@': path.resolve(__dirname, '../node_modules/'),
      },
    },
    output: {
      filename: '[name].[contenthash:8].min.js',
      chunkFilename: '[name].[contenthash:8].min.js',
      path: path.resolve(__dirname, '../dist'),
      publicPath: '/wp-content/themes/pure/dist/',
	  clean: true
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
            // options: {
            //   presets: ['@babel/preset-env']
            // }
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
    plugins: webpackPlugins,
    performance: {
      hints: 'error',
      assetFilter: function(assetFilename) {
        return !assetFilename.endsWith('.map');
      }
    },
	devServer: {
		static: './dist',
		hot: true,
	},
    // stats: 'verbose',
    stats: {
      errors: true,
      warnings: true,
      timings: true,
      version: true,
      moduleTrace: true,
      errorDetails: true,
      children: !isDevMode,
    },
    optimization: {
      splitChunks: {
        chunks: 'async',
        minSize: 30000,
        minChunks: 1,
        maxAsyncRequests: 5,
        maxInitialRequests: 3,
        name: false,
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
      minimize: true,
      minimizer: [
        new TerserPlugin(),
        new CssMinimizerPlugin({
          test: /\.css\.*(?!.*map)/g,
          parallel: true,
        }),
      ],
    },
  };
};
