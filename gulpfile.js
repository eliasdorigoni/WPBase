// @TODO: crear una tarea para eliminar carpetas de ../../plugins/ que coincidan con ./plugins/
// @TODO: permitir minificar SVGs de la raiz de source/svg/, y los que esten en carpetas convertirlos en sprites agrupados.

var gulp         = require('gulp'),
    argv         = require('yargs').argv,
    runSequence  = require('run-sequence'),
    requireDir   = require('require-dir'),
    CONFIG       = require('./gulp/config.js')

requireDir('./gulp/tasks');

gulp.task('default', function() {
    var secuencia = [
        'phplint',
        'js',
        'sass',
        'comprimir-imagenes',
        'svg',
        'includes-js',
        'favicon',
        'extraer-source',
        'copiar-plugins',
    ]
    if (argv.watch) {
        runSequence(secuencia, 'watch')
    } else {
        runSequence(secuencia)
    }
})

gulp.task('init', function() {
    runSequence('clean-assets', 'default');
})

gulp.task('build', function() {
    CONFIG.esBuild(true)
    runSequence('clean-build', ['default', 'comprimir-screenshot', 'completar-build'])
})
