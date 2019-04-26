const path  =require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

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
    entry: './assets/scripts/index.js',
    resolve: {
        modules: [path.resolve(__dirname, '../node_modules')],
        alias: {
            // '~/': [path.resolve(__dirname, '../node_modules')],
        }
    },
    output: {
        path: path.resolve(__dirname, '../dist'),
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                exclude: /node_modules/,
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
                            // parser: 'sugarss',
                            exec: true,
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
        new MiniCssExtractPlugin({
            // Options similar to the same options in webpackOptions.output
            // both options are optional
            filename: "[name].css",
            chunkFilename: "[id].css"
        })
    ]
};