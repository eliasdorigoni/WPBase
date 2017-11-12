var gulp         = require('gulp'),
    gulpif       = require('gulp-if'),
    sass         = require('gulp-sass'),
    sassLint     = require('gulp-sass-lint'),
    autoprefixer = require('gulp-autoprefixer'),
    rename       = require("gulp-rename"),
    livereload   = require('gulp-livereload'),
    sourcemaps   = require('gulp-sourcemaps'),
    CONFIG       = require('../config.js')

gulp.task('sasslint', function() {
    return gulp.src('./source/sass/**/*.scss')
        .pipe(sassLint({
            files: {
                ignore: [
                    'source/sass/foundation/*.scss',
                    'source/sass/modulos/*.scss'
                ],
            },
        }))
        .pipe(sassLint.format())
        .pipe(sassLint.failOnError())
})


gulp.task('sass', ['sasslint'], function(cb) {
    return gulp.src('./source/sass/*.scss')
        .pipe(gulpif(CONFIG.noEsBuild, sourcemaps.init()))
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
        .pipe(gulpif(CONFIG.noEsBuild, sourcemaps.write()))
        .pipe(gulp.dest(CONFIG.dir.assets + 'css/'))
        .pipe(gulpif(CONFIG.noEsBuild, livereload()))
})

