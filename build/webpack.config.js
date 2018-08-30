var path  =require('path');

var fs = require("fs");

var gitHEAD = fs.readFileSync('.git/HEAD', 'utf-8').trim();
var ref = gitHEAD.split(': ')[1];
var gitVersion = fs.readFileSync('.git/' + ref, 'utf-8').trim()
var swFilePath = path.resolve(__dirname, '../assets/scripts/sw.js');
var swFile = fs.readFileSync(swFilePath, 'utf-8');
var targetPath = path.resolve(__dirname, '../sw.php');
console.log(targetPath);
swFile = swFile.replace(/{{GIT_HASH}}/, gitVersion);
fs.writeFileSync(targetPath, swFile);

// console.log('githash', gitVersion);


console.log(swFile);

module.exports = {
    entry: './assets/scripts/index.js',
    output: {
        path: path.resolve(__dirname, '../dist'),
    },
    module: {
        rules: [
            {
                test: /.scss$/,
            }
        ]
    }
};