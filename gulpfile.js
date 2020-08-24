var gulp = require('gulp'),
notify = require('gulp-notify'),
del = require('del'),
nunjucksRender = require('gulp-nunjucks-render');

gulp.task('rebuild-method', function() {
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