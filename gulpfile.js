var gulp = require('gulp'),
notify = require('gulp-notify'),
del = require('del'),
nunjucksRender = require('gulp-nunjucks-render');

gulp.task('rebuild-method', function() {
  return gulp.src('./njk/assets/**/*.*')
    .pipe(nunjucksRender({
      path: ['./njk/templates'],
      inheritExtension: true,
      envOptions: {
        autoescape: false,
        trimBlocks: false,
        lstripBlocks: false,
        noCache: true,
      },
    }))
    .pipe(gulp.dest('./method-child'))
});

gulp.task('copy-build', function() {
  return gulp.src(['./method-child/**/*','!./method-child/.git','!./method-child/node_modules','!./method-child/package-lock.json'],{ dot: true }).pipe(gulp.dest('./custom'));
});

gulp.task('rebuild-custom', function() {
  return gulp.src('./njk/assets/**/*.*')
    .pipe(nunjucksRender({
      path: ['./njk/templates'],
      inheritExtension: true,
      envOptions: {
        autoescape: false,
        trimBlocks: false,
        lstripBlocks: false,
        noCache: true,
      },
    }))
    .pipe(gulp.dest('./custom'))
});

gulp.task('build-notify', function(done) {
  console.log(`
    __  _________________  ______  ____          ___ 
   /  |/  / ____/_  __/ / / / __ \\/ __ \\   _   _|__ \\
  / /|_/ / __/   / / / /_/ / / / / / / /  | | / /_/ /
 / /  / / /___  / / / __  / /_/ / /_/ /   | |/ / __/ 
/_/  /_/_____/ /_/ /_/ /_/\\____/_____/    |___/____/  
                                                                        

Method Child copied and rebuilt to ./custom
Visit https://method.wiki for documentation.
Thank you for building with Method!
`);
  done();
});

gulp.task('build-custom', gulp.series('copy-build', 'rebuild-custom', 'build-notify'));