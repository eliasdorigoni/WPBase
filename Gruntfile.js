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
                    'assets/css/app.min.css': 'sass/global.scss',
                    'assets/css/login.min.css': 'sass/login.scss',
                    'assets/css/widget-galeria.min.css': 'sass/modulos/widget-galeria.scss'
                }
            },
            foundation: {
                options: {
                    includePaths: ['node_modules/foundation-sites/scss'],
                    outputStyle: "expanded"
                },
                files: {
                    'sass/_framework.scss': 'sass/custom-foundation.scss'
                }
            }
        },
        clean: {
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
            build: {
                files: [
                    {
                        expand : false,
                        src : [
                            '*.php',
                            'style.css',
                            'screenshot.png',
                            '!*.map',

                            '**/*',
                            '!.git',
                            '!node_modules/**',
                            '!sass/**',
                            ],
                        dest : 'build/'
                    }
                ]
            }
        },
        watch: {
            sass: {
                files: ['sass/**/*.scss', '!sass/foundation.scss'],
                tasks: ['sass:dist'],
                options: {livereload: true }
            },
            plugin: {
                files: ['plugins/**/*'],
                tasks: ['copy'],
                options: {livereload: false }
            },
            template: {
                files: ['*.php'],
                options: {livereload: true }
            }
        }
    });
    grunt.registerTask('default', ['clean:prebuild', 'sass:dist', 'watch']);
    grunt.registerTask('framework', ['clean:prebuild', 'sass:foundation']);
    grunt.registerTask('build', ['clean:prebuild', 'sass:foundation', 'sass:dist', 'copy:build']);
};
