// Usar "gulp" para iniciar la tarea watch.
// Agregar la bandera "--prod" para guardar el build.

// @todo: crear una tarea para eliminar carpetas de ../../plugins/ que coincidan con ./plugins/

var gulp = require('gulp'),
    argv = require('yargs').argv,
    autoprefixer = require('gulp-autoprefixer'),
    concat = require('gulp-concat'),
    del = require('del'),
    favicons = require('gulp-favicons'),
    gulpif = require('gulp-if'),
    gulpIgnore = require('gulp-ignore'),
    gutil = require('gulp-util'),
    imagemin = require('gulp-imagemin'),
    livereload = require('gulp-livereload'),
    newer = require('gulp-newer'),
    rename = require("gulp-rename"),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    svgSprite = require('gulp-svg-sprite'),
    runSequence = require('run-sequence'),
    uglify = require('gulp-uglify')

var dir = {
    root: './',
    assets: './assets/',
}

if (argv.prod) {
    var rootDir = __dirname.split('\\').pop() + '/'
    dir.root = './build/' + rootDir
    dir.assets = './build/' + rootDir + 'assets/'
}

gulp.task('clean', function() {
    return del(['assets/', 'build/'])
})

gulp.task('images', function(cb) {
    gulp.src('./source/img/**/*')
    .pipe(newer(dir.assets + 'img/'))
    .pipe(imagemin())
    .pipe(gulp.dest(dir.assets + 'img/'))
    .pipe(gulpif(!argv.prod, livereload()))
    .on('end', cb).on('error', cb);
})

gulp.task('favicon', function() {
    return gulp.src('./source/favicon.png')
        .pipe(newer(dir.root + ''))
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
        .pipe(gulp.dest(dir.root + ''))
})

gulp.task('js', function() {
    return gulp.src(['./source/js/includes/*', './source/js/app.js'])
        .pipe(newer(dir.assets + 'js/'))
        .pipe(gulpif(!argv.prod, sourcemaps.init()))
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .pipe(gulpif(!argv.prod, sourcemaps.write()))
        .pipe(gulp.dest(dir.assets + 'js/'))
        .pipe(gulpif(!argv.prod, livereload()))
})

gulp.task('foundation-js', function() {
    return gulp.src([
            'foundation.core.js',
            'foundation.util.mediaQuery.js',

            'foundation.util.box.js', // reveal
            'foundation.util.keyboard.js', // reveal
            'foundation.util.motion.js', // offcanvas, toggler
            // 'foundation.util.nest.js',
            'foundation.util.timerAndImageLoader.js', // equalizer
            // 'foundation.util.touch.js',
            'foundation.util.triggers.js', // offcanvas, reveal, toggler

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
        ], {cwd: './node_modules/foundation-sites/dist/plugins/'})
        .pipe(newer('./source/js/vendor/foundation.min.js'))
        .pipe(concat('foundation.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./source/js/vendor'))
})

gulp.task('sass', function(cb) {
    return gulp.src('./source/sass/*.scss')
        .pipe(newer({dest: dir.assets + 'css/', ext: '.min.css'}))
        .pipe(gulpif(!argv.prod, sourcemaps.init()))
        .pipe(sass({
            includePaths: [
                './node_modules/foundation-sites/scss',
                './node_modules/motion-ui/src',
            ],
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 5 versions'],
            cascade: false
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulpif(!argv.prod, sourcemaps.write()))
        .pipe(gulp.dest(dir.assets + 'css/'))
        .pipe(gulpif(!argv.prod, livereload()))
})

gulp.task('svg', function(cb) {
    gulp.src('./source/svg/*.svg')
        .pipe(newer(dir.assets + 'svg/'))
        .pipe(imagemin())
        .pipe(gulp.dest(dir.assets + 'svg/'))
        .pipe(gulpif(!argv.prod, livereload()))
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
        .pipe(gulpif(!argv.prod, livereload()))
})

gulp.task('copiar-plugins', function() {
    return gulp.src('./plugins/**/*.*')
        .pipe(gulp.dest('../../plugins/'))
})

gulp.task('copiar-assets', function() {
    return gulp.src([
        './source/**/*',
        // favicon se genera
        '!./source/favicon.png',
        // img se optimiza
        '!./source/img',
        '!./source/img/**/',
        // js se uglifica
        '!./source/js/app.js',
        '!./source/js/includes',
        '!./source/js/includes/**/',
        '!./source/js/snippets',
        '!./source/js/snippets/**/',
        // sass se compila
        '!./source/sass',
        '!./source/sass/**/',
        // svg se optimizan o arman en un sprite
        '!./source/svg',
        '!./source/svg/**/',
        ])
        .pipe(newer(dir.assets))
        .pipe(gulp.dest(dir.assets))
})

gulp.task('watch', function() {
    livereload.listen()
    gulp.watch('./source/img/**/*', ['images'])
    gulp.watch('./source/favicon.png', ['favicon'])
    gulp.watch(['./source/js/app.js', './source/js/includes/*'], ['js'])
    gulp.watch('./source/sass/**/*.scss', ['sass'])
    gulp.watch('./source/svg/*.svg', ['svg'])
    gulp.watch('./source/svg/sprite/*.svg', ['svg-sprite'])
    gulp.watch('./plugins/**/*', ['copiar-plugins'])
    gulp.watch([
        './source/**/*',
        '!./source/favicon.png',
        '!./source/img',
        '!./source/img/**/',
        '!./source/js/app.js',
        '!./source/js/includes',
        '!./source/js/includes/**/',
        '!./source/js/snippets',
        '!./source/js/snippets/**/',
        '!./source/sass',
        '!./source/sass/**/',
        '!./source/svg/',
        '!./source/svg/**/',
        ], ['copiar-assets'])
})

gulp.task('default', function() {
    runSequence(
        'foundation-js',
        [
            'copiar-assets',
            // 'copiar-plugins', -> rara vez se usa
            'sass',
            'js',
            'images',
            'svg',
            'svg-sprite',
            'favicon'
        ], 
        'watch'
    );
})

gulp.task('build', function() {
    runSequence('clean', 'default', function() {
        gulp.src([
            './includes/',
            './page-templates/',
            './plugins/',
            './templates/',
            './woocommerce/',
            '!*.{map,md}',
            '!package.json',
            '!LICENSE',
            '!gulpfile.js',
            '.htaccess',
            '*.php',
            'config.ini',
            'favicon.ico',
            'screenshot.png',
            'style.css',
        ]).pipe(gulp.dest(dir.root))
    })
})
