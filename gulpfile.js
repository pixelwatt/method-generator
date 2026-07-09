var gulp = require('gulp'),
notify = require('gulp-notify'),
del = require('del'),
fs = require('fs'),
execSync = require('child_process').execSync,
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

gulp.task('render-custom', function() {
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

gulp.task('clean-custom', function() {
  return del(['./custom/.git', './custom/node_modules', './custom/package-lock.json']);
});

gulp.task('push-custom', function(done) {
  var globals = fs.readFileSync('./njk/templates/_globals.html', 'utf8');
  var pushMatch = globals.match(/{%\s*set\s+push_custom_build\s*=\s*(true|false)\s*%}/);
  var remoteMatch = globals.match(/{%\s*set\s+git_remote_url\s*=\s*"([^"]*)"\s*%}/);
  var branchMatch = globals.match(/{%\s*set\s+git_branch\s*=\s*"([^"]*)"\s*%}/);
  var pushCustomBuild = (pushMatch && 'true' === pushMatch[1]) ? true : false;
  var gitRemoteUrl = remoteMatch ? remoteMatch[1] : '';
  var gitBranch = (branchMatch && branchMatch[1]) ? branchMatch[1] : 'main';

  if (!pushCustomBuild || !gitRemoteUrl) {
    console.log('Skipping git push: push_custom_build must be true and git_remote_url must be set in njk/templates/_globals.html.');
    return done();
  }

  var execOpts = { cwd: './custom', stdio: 'inherit' };
  execSync('git init --initial-branch="' + gitBranch + '"', execOpts);
  execSync('git remote add origin "' + gitRemoteUrl + '"', execOpts);
  execSync('git add .', execOpts);
  execSync('git commit -m "Initial commit"', execOpts);
  execSync('git push --set-upstream origin "' + gitBranch + '"', execOpts);
  done();
});

gulp.task('rebuild-custom', gulp.series('render-custom', 'clean-custom', 'push-custom'));

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