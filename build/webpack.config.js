var path  =require('path');

function replaceVesrionCode() {
    var fs = require("fs");
    var gitHEAD = fs.readFileSync('.git/HEAD', 'utf-8').trim();
    var ref = gitHEAD.split(': ')[1];
    var gitVersion = fs.readFileSync('.git/' + ref, 'utf-8').trim()
    var sourcePath = path.resolve(__dirname, '../assets/scripts/sw.js');
    var content = fs.readFileSync(sourcePath, 'utf-8');
    var targetPath = path.resolve(__dirname, '../sw.php');

    content = content.replace(/{{GIT_COMMIT_HASH}}/, gitVersion);
    fs.writeFileSync(targetPath, content);
}

replaceVesrionCode();


// console.log('githash', gitVersion);

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