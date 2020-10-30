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

gulp.task('copy-build-to-local-dev', function() {
  return gulp.src(['./build/**/*','!./.git']).pipe(gulp.dest('/Users/robclark/Dev/server1/spitfire.test/public_html/wp-content/themes/spitfire'));
});

gulp.task('_local-rebuild', gulp.series('rebuild-method', 'copy-build-to-local-dev'));