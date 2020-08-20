var gulp = require('gulp'),
sass = require('gulp-dart-sass'),
autoprefixer = require('gulp-autoprefixer'),
jshint = require('gulp-jshint'),
uglify = require('gulp-uglify'),
imagemin = require('gulp-imagemin'),
rename = require('gulp-rename'),
concat = require('gulp-concat'),
notify = require('gulp-notify'),
cache = require('gulp-cache'),
browserSync = require('browser-sync').create(),
del = require('del'),
watchSass = require("gulp-watch-sass"),
cleanCSS = require('gulp-clean-css'),
nunjucksRender = require('gulp-nunjucks-render');

gulp.task('rebuild-sunrise', function() {
  return gulp.src('./njk/assets/**/*.*')
    .pipe(nunjucksRender({
      path: ['./njk/templates'],
      inheritExtension: true,
    }))
    .pipe(gulp.dest('./build'))
});

gulp.task('copy-build', function() {
  return gulp.src(['./build/**/*','!./.git']).pipe(gulp.dest('./custom'));
});

gulp.task('rebuild-custom', function() {
  return gulp.src('./njk/assets/**/*.*')
    .pipe(nunjucksRender({
      path: ['./njk/templates'],
      inheritExtension: true,
    }))
    .pipe(gulp.dest('./custom'))
});

gulp.task('build-custom', gulp.series('copy-build', 'rebuild-custom'));