// Version 1


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
    CONFIG = require('./gulp/config.js')

requireDir('./gulp/tasks');

gulp.task('clean', function() {
    return del([
        './assets/',
        './build/',
        './temp/',
    ])
})

/*
gulp.task('favicon', function() {
    return gulp.src('./source/favicon.png')
        .pipe(newer({dest: dir.root, ext: '.ico'}))
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
        .pipe(gulp.dest(dir.root))
})

gulp.task('otro-js', function() {
    return gulp.src('./source/js/*.js')
        .pipe(gulpif(!esBuild, sourcemaps.init()))
        .pipe(uglify())
        .on('error', function(err) {
            console.error(err.toString())
        })
        .pipe(gulpif(!esBuild, sourcemaps.write()))
        .pipe(gulp.dest(dir.assets + 'js/'))
        .pipe(gulpif(!esBuild, livereload()))
})

gulp.task('js', ['foundation-js', 'otro-js'], function() {
    return gulp.src([
            './temp/js/foundation.js',
            './source/js/includes/*',
            './source/js/app.js'
        ])
        .pipe(gulpif(!esBuild, sourcemaps.init()))
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .on('error', function(err) {
            console.error(err.toString())
        })
        .pipe(gulpif(!esBuild, sourcemaps.write()))
        .pipe(gulp.dest(dir.assets + 'js/'))
        .pipe(gulpif(!esBuild, livereload()))
})

gulp.task('foundation-js', function(cb) {
    gulp.src([
            'foundation.core.js',
            'foundation.util.mediaQuery.js',

            'foundation.util.box.js',      // reveal
            'foundation.util.keyboard.js', // reveal
            'foundation.util.motion.js',   // offcanvas, toggler
            // 'foundation.util.nest.js',
            'foundation.util.timerAndImageLoader.js', // equalizer
            // 'foundation.util.touch.js',
            'foundation.util.triggers.js',  // offcanvas, reveal, toggler

            // 'foundation.abide.js',
            // 'foundation.accordion.js',
            // 'foundation.accordionMenu.js',
            // 'foundation.drilldown.js',
            // 'foundation.dropdown.js',
            // 'foundation.dropdownMenu.js',
            'foundation.equalizer.js',
            // 'foundation.interchange.js',
            // 'foundation.magellan.js',
            'foundation.offcanvas.js',
            // 'foundation.orbit.js',
            // 'foundation.responsiveMenu.js',
            // 'foundation.responsiveToggle.js',
            'foundation.reveal.js',
            // 'foundation.slider.js',
            // 'foundation.sticky.js',
            // 'foundation.tabs.js',
            'foundation.toggler.js',
            // 'foundation.tooltip.js',
        ], {cwd: './node_modules/foundation-sites/dist/js/plugins/'})
        .pipe(newer('./temp/js/foundation.js'))
        .pipe(concat('foundation.js'))
        .pipe(gulp.dest('./temp/js/'))
        .on('end', cb).on('error', cb);
})

gulp.task('svg', function(cb) {
    gulp.src('./source/svg/*.svg')
        .pipe(newer(dir.assets + 'svg'))
        .pipe(imagemin())
        .pipe(gulp.dest(dir.assets + 'svg/'))
        .pipe(gulpif(!esBuild, livereload()))
        .on('end', cb).on('error', cb);
})

gulp.task('svg-sprite', function(cb) {
    var options = {
        shape: {
            dimension: {
                maxWidth: 100,
                maxHeight: 100
            },
            id: {
                whitespace: '_',
            },
        },
        svg: {
            namespaceClassnames: false,
        },
        mode: {
            symbol: {
                dest: '',
                prefix: '',
                bust: false,
                sprite: 'sprite.svg'
            }
        }
    }

    return gulp.src('./source/svg/sprite/*.svg')
        .pipe(newer(dir.assets + 'svg/sprite.svg'))
        .pipe(svgSprite(options))
        .pipe(gulp.dest(dir.assets + 'svg/'))
        .pipe(gulpif(!esBuild, livereload()))
})

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

gulp.task('comprimir-screenshot', function() {
    if (esBuild) {
        return gulp.src('./screenshot.png')
            .pipe(imagemin())
            .pipe(gulp.dest(dir.root))
    }
})

gulp.task('livereload-php', function() {
    return livereload.reload()
})

gulp.task('watch', function() {
    livereload.listen()
    gulp.watch('./source/img/**', ['images'])
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
            'images',
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
