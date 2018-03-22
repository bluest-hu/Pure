/**
 * Created by hubery on 2016/10/23.
 */

// import gulp
var gulp = require('gulp');
// gulp-sass
var sass = require('gulp-sass');
// gulp-concat
var concat = require('gulp-concat');
// gulp-uglify
// var uglify = require('gulp-uglify');

// scss
gulp.task('scss', function () {
    gulp.src('scss/index.scss')
        .pipe(sass().on('error', sass.logError))
        . pipe(gulp.dest('./styles/'));
});


// default
gulp.task('default', ['scss']);

var scssWtcher = gulp.watch('scss/**/*.scss', ['scss']);

scssWtcher.on("change", function (event) {
    console.log("scss changeed");
});




