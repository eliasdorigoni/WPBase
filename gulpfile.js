// @TODO: crear una tarea para eliminar carpetas de ../../plugins/ que coincidan con ./plugins/
// @TODO: permitir minificar SVGs de la raiz de source/svg/, y los que esten en carpetas convertirlos en sprites agrupados.

var gulp         = require('gulp'),
    argv         = require('yargs').argv,
    autoprefixer = require('gulp-autoprefixer'),
    concat       = require('gulp-concat'),
    del          = require('del'),
    favicons     = require('gulp-favicons'),
    gulpIgnore   = require('gulp-ignore'),
    gulpif       = require('gulp-if'),
    gutil        = require('gulp-util'),
    imagemin     = require('gulp-imagemin'),
    livereload   = require('gulp-livereload'),
    newer        = require('gulp-newer'),
    phplint      = require('gulp-phplint'),
    rename       = require("gulp-rename"),
    runSequence  = require('run-sequence'),
    sourcemaps   = require('gulp-sourcemaps'),
    svgSprite    = require('gulp-svg-sprite'),
    uglify       = require('gulp-uglify'),
    requireDir   = require('require-dir'),
    CONFIG       = require('./gulp/config.js')

requireDir('./gulp/tasks');

gulp.task('clean', function() {
    return del([
        './assets/',
        './build/',
        './temp/',
    ])
})

/*
gulp.task('copiar-plugins', function() {
    return gulp.src('./plugins/**', {base: '.'})
        .pipe(gulp.dest('../../plugins/'))
})

gulp.task('extraer-source', function() {
    return gulp.src([
        './source/fonts/**',
        './source/js/vendor/**',
        './source/js/backend/**',
        './source/js/admin/**',
        ], {base: './source/'})
        .pipe(newer(dir.assets))
        .pipe(gulp.dest(dir.assets))
})

gulp.task('completar-build', function() {
    if (esBuild) {
        return gulp.src([
                './includes/**',
                './page-templates/**',
                './plugins/**',
                './templates/**',
                './woocommerce/**',
                './vendor/**',
                '!*.map',
                '!*.md',
                '!package.json',
                '!LICENSE',
                '.htaccess',
                '*.php',
                './config.ini',
                './favicon.ico',
                './style.css',
            ], {base: '.'})
            .pipe(gulp.dest(dir.root))
    }
})

gulp.task('livereload-php', function() {
    return livereload.reload()
})

gulp.task('watch', function() {
    livereload.listen()
    gulp.watch('./source/img/**', ['comprimir-imagenes'])
    gulp.watch('./source/favicon.png', ['favicon'])
    gulp.watch(['./source/js/app.js', './source/js/includes/**'], ['js'])
    gulp.watch('./source/sass/** /*.scss', ['sass'])
    gulp.watch('./source/svg/*.svg', ['svg'])
    gulp.watch('./source/svg/sprite/*.svg', ['svg-sprite'])
    gulp.watch('./plugins/**', ['copiar-plugins'])
    gulp.watch(['./source/fonts/**', './source/js/vendor/**'], ['extraer-source'])
})

gulp.task('default', function() {
    runSequence(['foundation-js', 'favicon', 'phplint'], [
            'extraer-source',
            // 'copiar-plugins',
            'completar-build',
            'comprimir-screenshot',
            'sass',
            'js',
            'comprimir-imagenes',
            'svg',
            'svg-sprite',
        ]
    );
})

gulp.task('init', function() {
    runSequence('default', 'watch')
})

gulp.task('build', function() {
    esBuild = true
    definirDirectorios(true)
    runSequence('clean', 'default')
})

gulp.task('phplint', function() {
    return gulp.src(['./*.php'])
        .pipe(phplint('', {
            skipPassedFiles: true
        }))
        .pipe(phplint.reporter('fail'));
});

*/
