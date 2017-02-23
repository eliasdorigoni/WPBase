module.exports = function(grunt) {
    "use strict";
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        sass: {
            dist: {
                options: {
                    sourceMap: true,
                    outputStyle: "compressed",
                },
                files: {
                    'assets/css/app.min.css': 'source/sass/global.scss',
                    'assets/css/login.min.css': 'source/sass/login.scss',
                    'assets/css/backend-widget-galeria.min.css': 'source/sass/widgets/backend-galeria.scss'
                }
            },
            foundation: {
                options: {
                    includePaths: ['node_modules/foundation-sites/scss'],
                    outputStyle: "expanded"
                },
                files: {
                    'sass/_framework.scss': 'source/sass/custom-foundation.scss'
                }
            },
        },
        clean: {
            predist: [
                'assets/'
            ],
            prebuild: [
                'build/'
            ],
        },
        copy: {
            plugins: {
                files: [
                    {
                        expand : true,
                        cwd    : 'plugins',
                        src    : ['**'],
                        dest   : '../../plugins/'
                    }
                ]
            },
            js: {
                files: [
                    {
                        expand : true,
                        cwd    : 'source',
                        src    : ['js/**/*'],
                        dest   : 'assets/'
                    }
                ]
            },
            build: {
                files: [
                    {
                        expand : true,
                        src : [
                            '{assets,includes,templates}/**/*',
                            '*.*',
                            '.htaccess',
                            '!*.{map,md}',
                            '!package.json',
                            ],
                        dest : 'build/'
                    },
                ]
            }
        },
        svgmin: {
            options: {
                plugins: [
                    {removeViewBox: false },
                    {removeUselessStrokeAndFill: false },
                    {removeAttrs: {attrs: ['xmlns'] } }
                ]
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: 'source/',
                    src: 'svg/*.svg',
                    dest: 'assets/'
                }]
            }
        },
        imagemin: {
            dynamic: {
                files: [{
                    expand: true,
                    cwd: 'source/',
                    src: ['img/**/*.{png,jpg,gif}'],
                    dest: 'assets/',
                }]
            }
        },
        watch: {
            sass: {
                files: ['sass/**/*.scss', '!sass/foundation.scss'],
                tasks: ['sass:dist'],
                options: {livereload: true}
            },
            plugin: {
                files: ['plugins/**/*'],
                tasks: ['copy'],
                options: {livereload: false}
            },
            template: {
                files: ['*.php'],
                options: {livereload: true}
            }
        }
    });
    grunt.registerTask('dist', ['sass:dist', 'copy:js', 'newer:imagemin', 'newer:svgmin']);
    grunt.registerTask('framework', ['sass:foundation']);
    grunt.registerTask('build', ['clean', 'dist', 'copy:build']);
    grunt.registerTask('rebuild', ['clean:prebuild', 'copy:build']);

    grunt.registerTask('default', ['dist', 'watch']);
};
