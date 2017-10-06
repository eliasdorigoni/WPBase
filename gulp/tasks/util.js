var gulp         = require('gulp'),
    del          = require('del'),
    livereload   = require('gulp-livereload')

gulp.task('clean', ['clean-assets', 'clean-build'])

gulp.task('clean-assets', function() {
    return del(['./assets/'])
})

gulp.task('clean-build', function() {
    return del(['./build/'])
})

gulp.task('forzar-livereload', function() {
    return livereload.reload()
})
