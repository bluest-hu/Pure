const path  =require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CleanWebpackPlugin = require('clean-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

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

replaceVersionCode();

const isDevMode = process.env.NODE_ENV !== 'production';

module.exports = {
    devtool: isDevMode ? 'source-map' : '',
    entry: './assets/scripts/index.js',
    resolve: {
        // modules: [path.resolve(__dirname, '../node_modules')],
        alias: {
        }
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, '../dist'),
    },
    module: {
        rules: [
            {},
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
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: "[name].min.css",
            chunkFilename: "[id].css"
        })
    ],
    performance: {
        hints: 'error',
    },
    optimization:{
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
            new OptimizeCSSAssetsPlugin({
                assetNameRegExp:  /\.css\.*(?!.*map)/g,
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
                            autoprefixer:  { 
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