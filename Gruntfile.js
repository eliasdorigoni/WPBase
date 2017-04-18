module.exports = function(grunt) {
    "use strict";
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        globalConfig: {
            theme: 'wpbase'
        },
        sass: {
            dist: {
                options: {
                    sourceMap: true,
                    outputStyle: "compressed",
                },
                files: {
                    'assets/css/app.min.css': 'source/sass/global.scss',
                    'assets/css/login.min.css': 'source/sass/login.scss',
                    'assets/css/backend.min.css': 'source/sass/backend.scss'
                }
            },
            dist: {
                options: {
                    sourceMap: false,
                    outputStyle: "compressed",
                },
                files: {
                    'assets/css/app.min.css': 'source/sass/global.scss',
                    'assets/css/login.min.css': 'source/sass/login.scss',
                    'assets/css/backend.min.css': 'source/sass/backend.scss'
                }
            },
            foundation: {
                options: {
                    includePaths: ['node_modules/foundation-sites/scss'],
                    outputStyle: "compressed"
                },
                files: {
                    'source/sass/foundation/_compilado.scss': 'source/sass/foundation/custom-foundation.scss'
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
            estaticos: {
                files: [
                    {
                        expand : true,
                        cwd    : 'source',
                        src    : ['js/**/*', 'fonts/**/*'],
                        dest   : 'assets/'
                    }
                ]
            },
            build: {
                files: [
                    {
                        expand : true,
                        src : [
                            '{assets,includes,templates,woocommerce}/**/*',
                            '*.*',
                            '.htaccess',
                            '!*.{map,md}',
                            '!package.json',
                            ],
                        dest : 'build/<%= globalConfig.theme  %>',
                    },
                ]
            }
        },
        svg_sprite: {
            target: {
                cwd: 'source/svg/',
                src: ['*.svg'],
                dest: 'assets/svg/',
                options: {
                    shape: {
                        dimension: {
                            maxWidth: 100,
                            maxHeight: 100
                        },
                        id: {
                            whitespace: '_',
                        },
                    },
                    mode: {
                        symbol: {
                            dest: '',
                            prefix: '',
                            sprite: "sprite.svg"
                        }
                    }
                }
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
                files: [    
                    'source/sass/**/*.scss',
                    '!source/sass/custom-foundation.scss'
                ],
                tasks: ['sass:dist'],
                options: {livereload: true}
            },
            js: {
                files: ['source/js/**/*'],
                tasks: ['copy:estaticos'],
                options: {livereload: true}
            },
            plugin: {
                files: ['plugins/**/*'],
                tasks: ['copy:plugins'],
                options: {livereload: false}
            },
            template: {
                files: ['*.php'],
                options: {livereload: true}
            },
            iconos: {
                files: ['source/svg/*'],
                tasks: ['iconos'],
                options: {livereload: true}
            },
        }
    });
    grunt.registerTask('foundation', ['sass:foundation']);
    grunt.registerTask('iconos', ['svg_sprite']);
    grunt.registerTask('dist', ['sass:dist', 'copy:estaticos', 'newer:imagemin', 'iconos']);

    grunt.registerTask('build', ['clean', 'dist', 'copy:build']);
    grunt.registerTask('rebuild', ['clean:prebuild', 'copy:build']);

    grunt.registerTask('default', ['dist', 'watch']);
};
