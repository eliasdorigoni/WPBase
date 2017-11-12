var gulp         = require('gulp'),
    gulpif       = require('gulp-if'),
    imagemin     = require('gulp-imagemin'),
    livereload   = require('gulp-livereload'),
    newer        = require('gulp-newer'),
    CONFIG       = require('../config.js')

gulp.task('comprimir-imagenes', function(cb) {
    gulp.src('./source/img/**/*')
        .pipe(newer(CONFIG.dir.assets + 'img/'))
        .pipe(imagemin())
        .pipe(gulp.dest(CONFIG.dir.assets + 'img/'))
        .pipe(gulpif(CONFIG.noEsBuild, livereload()))
        .on('end', cb).on('error', cb);
})

gulp.task('comprimir-screenshot', function() {
    if (CONFIG.esBuild) {
        return gulp.src('./screenshot.png')
            .pipe(imagemin())
            .pipe(gulp.dest(CONFIG.dir.root))
    }
})
