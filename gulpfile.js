// Usar "gulp" para iniciar la tarea watch.
// Agregar la bandera "--prod" para guardar el build.

// @todo: crear una tarea para eliminar carpetas de ../../plugins/ que coincidan con ./plugins/


// "grunt-favicons": "0.8.0"

var gulp = require('gulp'),
    argv = require('yargs').argv,
    concat = require('gulp-concat'),
    del = require('del'),
    favicons = require('gulp-favicons'),
    gulpif = require('gulp-if'),
    gulpIgnore = require('gulp-ignore'),
    gutil = require('gulp-util'),
    imagemin = require('gulp-imagemin'),
    livereload = require('gulp-livereload'),
    rename = require("gulp-rename"),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    svgSprite = require('gulp-svg-sprite'),
    runSequence = require('run-sequence'),
    uglify = require('gulp-uglify')

var opciones = {
    dist: './assets/',
    build: './build/' + __dirname.split('\\').pop() + '/'
}

gulp.task('clean', function() {
    return del(['assets/', 'build/'])
})

gulp.task('images', function(cb) {
    gulp.src('./source/img/**/*')
    .pipe(imagemin())
    .pipe(gulp.dest(argv.prod ? opciones.build + 'img/' : opciones.dist + 'img/'))
    .pipe(gulpif(!argv.prod, livereload()))
    .on('end', cb).on('error', cb);
})

gulp.task('favicon', function() {
    return gulp.src('./source/favicon.png')
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
        .pipe(gulp.dest(argv.prod ? opciones.build : './'))
})

gulp.task('js', function() {
    return gulp.src(['./source/js/includes/*', './source/js/app.js'])
        .pipe(gulpif(!argv.prod, sourcemaps.init()))
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .pipe(gulpif(!argv.prod, sourcemaps.write()))
        .pipe(gulp.dest(argv.prod ? opciones.build + 'js/' : opciones.dist + 'js/'))
        .pipe(gulpif(!argv.prod, livereload()))
})

gulp.task('sass', function(cb) {
    return gulp.src('./source/sass/*.scss')
        .pipe(gulpif(!argv.prod, sourcemaps.init()))
        .pipe(sass({
            includePaths: ['./node_modules/foundation-sites/scss'],
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulpif(!argv.prod, sourcemaps.write()))
        .pipe(gulp.dest(argv.prod ? opciones.build + 'css/' : opciones.dist + 'css/'))
        .pipe(gulpif(!argv.prod, livereload()))
})

gulp.task('svg', function(cb) {
    gulp.src('./source/svg/*.svg')
    .pipe(imagemin())
    .pipe(gulp.dest(argv.prod ? opciones.build + 'svg/' : opciones.dist + 'svg/'))
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
        .pipe(svgSprite(options))
        .pipe(gulp.dest(argv.prod ? opciones.build + 'svg/' : opciones.dist + 'svg/'))
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
        // sass se compila
        '!./source/sass',
        '!./source/sass/**/',
        // svg se optimizan o arman en un sprite
        '!./source/svg',
        '!./source/svg/**/',
        ])
        .pipe(gulp.dest(argv.prod ? opciones.build : opciones.dist))
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
        '!./source/sass',
        '!./source/sass/**/',
        '!./source/svg/',
        '!./source/svg/**/',
        ], ['copiar-assets'])
})

gulp.task('default', function() {
    runSequence(
        'clean',
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
