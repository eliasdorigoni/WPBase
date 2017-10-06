var gulp         = require('gulp'),
    del          = require('del'),
    livereload   = require('gulp-livereload'),

gulp.task('clean', function() {
    return del([
        './assets/',
        './build/',
    ])
})

gulp.task('forzar-livereload', function() {
    return livereload.reload()
})
