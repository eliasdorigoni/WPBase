var gulp         = require('gulp'),
    livereload   = require('gulp-livereload'),
    phplint      = require('gulp-phplint'),
    CONFIG       = require('../config.js')

gulp.task('phplint', function() {
    return gulp.src(['./**/*.php'])
        .pipe(phplint('', {
            skipPassedFiles: true
        }))
        .pipe(phplint.reporter('fail'));
});
