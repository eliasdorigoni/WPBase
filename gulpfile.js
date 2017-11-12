// @TODO: crear una tarea para eliminar carpetas de ../../plugins/ que coincidan con ./plugins/
// @TODO: permitir minificar SVGs de la raiz de source/svg/, y los que esten en carpetas convertirlos en sprites agrupados.

var gulp         = require('gulp'),
    argv         = require('yargs').argv,
    livereload   = require('gulp-livereload'),
    requireDir   = require('require-dir'),
    runSequence  = require('run-sequence'),
    CONFIG       = require('./gulp/config.js')

requireDir('./gulp/tasks');

gulp.task('watch', function() {
    livereload.listen()
    gulp.watch('./source/img/**/*', ['comprimir-imagenes'])
    gulp.watch('./source/js/*.js', ['js'])
    gulp.watch(['./source/js/includes/**/*', './source/js/backend/**/*', './source/js/admin/**/*', ], ['includes-js'])
    gulp.watch('./source/sass/**/*.scss', ['sass'])
    gulp.watch('./source/svg/*.svg', ['svg'])
    gulp.watch('./source/svg/sprite/*.svg', ['svg-sprite'])
    gulp.watch('./plugins/**', ['copiar-plugins'])
    gulp.watch(['./source/fonts/**', './source/js/vendor/**'], ['extraer-source'])
})

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
        // 'copiar-plugins',
    ]

    if (argv.build) {
        secuencia.push('comprimir-screenshot', 'completar-build')
    }

    if (argv.watch) {
        runSequence(secuencia, 'watch')
    } else {
        runSequence(secuencia)
    }
})

gulp.task('init', function() {
    var tareaLimpieza = (argv.build) ? 'clean-build' : 'clean-assets';
    runSequence(tareaLimpieza, 'default');
})
