////// LAUNCH!
////
//



var gulp = require('gulp'),
  sass = require('gulp-sass'),
  sourcemaps = require('gulp-sourcemaps'),
  // scsslint = require('gulp-scss-lint'),
  watch = require('gulp-watch'),
  gulpLoadPlugins = require("gulp-load-plugins"),
  tasks = gulpLoadPlugins({scope: ["devDependencies"]}),
  gutil = require('gulp-util'),
  livereload = require('gulp-livereload'),
  cssGlobbing = require('gulp-css-globbing'),
  babel = require('gulp-babel'),
  eslint = require('gulp-eslint'),
  replace = require('gulp-replace'),
  del = require('del'),
  notify = tasks.notify,
  request = require('request'),
  path = require('path'),
  // criticalcss = require('criticalcss'),
  fs = require('fs'),
  tmpDir = require('os').tmpdir();

gulp.task('dist-sass', function () {
    gulp.src('./assets/src/scss/*.scss');
    gulp.src('./assets/src/scss/application.scss')
    // .pipe(tasks.sourcemaps.init())
      .pipe(tasks.sass())
      .pipe(tasks.autoprefixer('last 2 versions', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
      .pipe(gulp.dest('./assets/dist/css'))
      .pipe(tasks.rename({suffix: '.min'}))
      .pipe(tasks.cssmin())
    // .pipe(tasks.sourcemaps.write())
    .pipe(gulp.dest('./assets/dist/css'));
});

gulp.task('critical-css', function() {
  var cssUrl = 'http://edr.dev/wp-content/themes/launchframe/assets/dist/css/application.css';
  var cssPath = path.join( tmpDir, 'style.css' );
  request(cssUrl).pipe(fs.createWriteStream(cssPath)).on('close', function() {
    criticalcss.getRules(cssPath, function(err, output) {
      if (err) {
        throw new Error(err);
      } else {
        criticalcss.findCritical("http://edr.dev/", { rules: JSON.parse(output) }, function(err, output) {
          if (err) {
            throw new Error(err);
          } else {
            fs.writeFileSync('./assets/dist/css/critical.css', output);
          }
        });
      }
    });
  });
});

gulp.task('dist-js', function () {
  gulp.src(['./assets/src/js/plugins.js', './assets/src/js/script.js'])
      // .pipe(sourcemaps.init())
      .pipe(tasks.concat('./assets/dist/js/script.js'))
      .pipe(babel())
      .pipe(gulp.dest('./'))
      .pipe(tasks.rename({suffix: '.min'}))
      .pipe(tasks.uglify())
      .pipe(gulp.dest('./'))
      // .pipe(sourcemaps.write('.'))
      .pipe(livereload())
      .on('error', function(message){
        console.log(message);
      });
  gulp.src(['./assets/vendor/slick.js/slick/slick.min.js', './assets/vendor/handlebars/handlebars.min.js', './assets/vendor/selectize/selectize.min.js', './assets/vendor/modernizr/modernizr.min.js'])
    .pipe(tasks.concat('./assets/dist/js/plugins.js'))
    .pipe(gulp.dest('./'))
});

gulp.task('dist-img', function(){
  return gulp.src(['assets/src/img/*.jpg', 'assets/src/img/*.png', 'assets/src/img/*.svg'])
    .pipe(tasks.newer('assets/dist/img'))
    .pipe(tasks.imagemin())
    .pipe(gulp.dest('assets/dist/img'));
});

gulp.task('watch', function () {
  livereload.listen();
  watch('assets/src/**/*.js', function () {
    gulp.start('dist-js');
      livereload.changed();
  });
  watch('assets/src/**/*.scss', function () {
    gulp.start('dist-sass');
    livereload.changed();
  });
});
