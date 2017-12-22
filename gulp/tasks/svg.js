var gulp         = require('gulp'),
    gulpif       = require('gulp-if'),
    imagemin     = require('gulp-imagemin'),
    livereload   = require('gulp-livereload'),
    newer        = require('gulp-newer'),
    svgSprite    = require('gulp-svg-sprite'),
    CONFIG       = require('../config.js')

gulp.task('svg-individual', function(cb) {
    return gulp.src('./source/svg/*.svg')
        .pipe(newer(CONFIG.dir.assets + 'svg'))
        .pipe(imagemin())
        .pipe(gulp.dest(CONFIG.dir.assets + 'svg/'))
        .pipe(gulpif(CONFIG.noEsBuild, livereload()))
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
        .pipe(newer(CONFIG.dir.assets + 'svg/sprite.svg'))
        .pipe(svgSprite(options))
        .pipe(gulp.dest(CONFIG.dir.assets + 'svg/'))
        .pipe(gulpif(CONFIG.noEsBuild, livereload()))
})

gulp.task('svg', ['svg-individual', 'svg-sprite'])
