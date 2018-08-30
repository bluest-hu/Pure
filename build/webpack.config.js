var path  =require('path');

function replaceVersionCode() {
    let fs = require("fs");
    let gitHEAD = fs.readFileSync('.git/HEAD', 'utf-8').trim();
    let ref = gitHEAD.split(': ')[1];
    let gitCommitHashCode = fs.readFileSync('.git/' + ref, 'utf-8').trim();
    let sourcePath = path.resolve(__dirname, '../assets/scripts/sw.js');
    let content = fs.readFileSync(sourcePath, 'utf-8');
    let targetPath = path.resolve(__dirname, '../sw.php');

    gitCommitHashCode = gitCommitHashCode.substring(0, 6);
    content = content.replace(/{{GIT_COMMIT_HASH}}/, gitCommitHashCode);
    fs.writeFileSync(targetPath, content);
    console.log(`git hash code is ${gitCommitHashCode}`);
}

replaceVersionCode();

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