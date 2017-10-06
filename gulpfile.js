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
    CONFIG.esBuild(true)
    runSequence('clean', 'default')
})
