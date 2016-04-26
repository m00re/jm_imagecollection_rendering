var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');

gulp.task('css', ['css:sass', 'css:minify']);

gulp.task('css:minify', ['css:sass'], function() {
    return gulp.src('./Resources/Public/CSS/*.css')
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename(function (path) {
            path.extname = ".min.css"
        }))
        .pipe(gulp.dest('./Resources/Public/CSS/'));
});

gulp.task('css:sass', function () {
    return gulp.src('./Resources/Public/CSS/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./Resources/Public/CSS/'));
});

gulp.task('css:sass:watch', function () {
    gulp.watch('./Resources/Public/CSS/*.scss', ['css::sass']);
});