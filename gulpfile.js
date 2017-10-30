'use strict';

var gulp        = require('gulp'),
    babel       = require('gulp-babel'),
    sass        = require('gulp-sass'),
    cssmin      = require('gulp-cssmin'),
    rename      = require('gulp-rename'),
    concat      = require('gulp-concat'),
    imagemin    = require('gulp-imagemin'),
    uglify      = require('gulp-uglify'),
    prefix      = require('gulp-autoprefixer'),
    browserSync = require('browser-sync').create(),
    reload      = browserSync.reload,
    config      = require('./awesomeplate.config.json');

console.log(config.css);

// Configure CSS task.
gulp.task('css', function () {
  return gulp.src(config.css)
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(prefix('last 2 versions'))
    .pipe(cssmin())
    .pipe(concat('style.css', {newLine: ''}))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('dist/css'));
});

// Configure JS task.
gulp.task('js', function() {
  return gulp.src(config.js)
    .pipe(babel({presets: ['es2015']}))
    .pipe(uglify({mangle: false}))
    .pipe(concat('script.js', {newLine: ''}))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('dist/js'));
});

// Configure image task.
gulp.task('img', function () {
  return gulp.src('src/img/**/*.+(png|jpg|gif|svg)')
    .pipe(imagemin())
    .pipe(gulp.dest('dist/img'));
});

gulp.task('serve', ['css', 'js'], function(){
  browserSync.init(['dist/css/*.css', 'dist/js/*.js', '*.html'],{
    server: {
      baseDir: './'
    }
  })
});

gulp.task('watch', ['serve'], function () {
  gulp.watch('src/sass/**/*.scss', ['css']);
  gulp.watch('src/js/**/*.js', ['js']);
  gulp.watch('src/img/**/*.+(png|jpg|gif|svg)', ['img']);
  gulp.watch('./awesomeplate.config.json', [ 'css', 'js' ]);
});

gulp.task('default', ['css', 'js', 'img']);