var gulp         = require('gulp'),
    debug        = require('gulp-debug'),
    addSrc       = require('gulp-add-src'),
    zip          = require('gulp-zip')

gulp.task('zip', function () {
    return gulp.src([
            './../../**/*',
            '!./../../themes/**/*',
            '!wp-content.zip',
        ], {base: './../../'})
        .pipe(addSrc([
            './build/**/*',
        ]))
        .pipe(debug({
            'title': '>>> ',
        }))
        .pipe(zip('wp-content.zip'))
        .pipe(gulp.dest('./../../'))
});
