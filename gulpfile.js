/**
 * Created by hubery on 2016/10/23.
 */

var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('scss', function () {
    gulp.src('scss/index.scss')
        .pipe(sass().on('error', sass.logError))
        . pipe(gulp.dest('./styles'));
});

var scssWtcher = gulp.watch('scss/**/*.scss', ['scss']);

scssWtcher.on("change", function (event) {
	console.log("scss changeed");
});

