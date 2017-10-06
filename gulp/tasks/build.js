var gulp         = require('gulp'),
    newer        = require('gulp-newer'),
    CONFIG       = require('../config.js')

gulp.task('extraer-source', function() {
    return gulp.src([
        './source/fonts/**',
        './source/js/vendor/**',
        ], {base: './source/'})
        .pipe(newer(CONFIG.dir.assets))
        .pipe(gulp.dest(CONFIG.dir.assets))
})

gulp.task('copiar-plugins', function() {
    return gulp.src('./plugins/**', {base: '.'})
        .pipe(gulp.dest('../../plugins/'))
})

gulp.task('completar-build', function() {
    if (CONFIG.esBuild()) {
        return gulp.src([
            '!*.map',
            '!*.md',
            '!package.json',
            '!LICENSE',
            './includes/**',
            './page-templates/**',
            './plugins/**',
            './templates/**',
            './woocommerce/**',
            './vendor/**',
            '.htaccess',
            '*.php',
            './config.ini',
            './favicon.ico',
            './style.css',
            ], {base: '.'})
            .pipe(gulp.dest(CONFIG.dir.root))
    }
})
