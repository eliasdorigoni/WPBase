var gulp         = require('gulp'),
    gulpif       = require('gulp-if'),
    favicons     = require('gulp-favicons'),
    gulpIgnore   = require('gulp-ignore'),
    gutil        = require('gulp-util'),
    imagemin     = require('gulp-imagemin'),
    livereload   = require('gulp-livereload'),
    newer        = require('gulp-newer'),
    CONFIG       = require('../config.js')

gulp.task('images', function(cb) {
    gulp.src('./source/img/**/*')
        .pipe(newer(CONFIG.dir.assets + 'img/'))
        .pipe(imagemin())
        .pipe(gulp.dest(CONFIG.dir.assets + 'img/'))
        .pipe(gulpif(!CONFIG.esBuild(), livereload()))
        .on('end', cb).on('error', cb);
})

gulp.task('favicon', function() {
    return gulp.src('./source/favicon.png')
        .pipe(newer({dest: CONFIG.dir.root, ext: '.ico'}))
        .pipe(favicons({
            logging: false,
            online: false,
            html: false,
            replace: true,
            icons: {
                android: false,
                appleIcon: false,
                appleStartup: false,
                coast: false,
                favicons: true,
                firefox: false,
                windows: false,
                yandex: false
            },
        }))
        .on("error", gutil.log)
        .pipe(gulpIgnore.include('*.ico'))
        .pipe(gulp.dest(CONFIG.dir.root))
})
