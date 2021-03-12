// modules
var gulp = require('gulp'),
    gutil = require('gulp-util'),
    uglify = require('gulp-uglify'),
    uglifycss = require('gulp-uglifycss'),
    watch = require('gulp-watch'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    clean = require('gulp-dest-clean'),
    imagemin = require('gulp-imagemin');

gulp.task('deploy', function() {
    var cssTask = gulp
        .src('./src/css/app.css')
        .pipe(gulp.dest('./build/css/'))
        .pipe(rename('app.min.css'))
        .pipe(uglifycss({ "maxLineLen": 80, "uglyComments": true }))
        .pipe(gulp.dest('./build/css/'));
    
    var imgTask = gulp
        .src('./src/img/*')
        .pipe(clean('./build/img/'))
        .pipe(imagemin())
        .pipe(gulp.dest('./build/img/'));
    
    var jsTask = gulp
        .src('./src/js/*.js')
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./build/js/'))
        .pipe(rename('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./build/js/'));
    
    return [cssTask, imgTask, jsTask];
});

gulp.task('watch', function() {
    gulp.watch('src/js/*.js', function(event) {
        gutil.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
        gulp.run('deploy');
    });
});

gulp.task('default', ['deploy'], function(){});