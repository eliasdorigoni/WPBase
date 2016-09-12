module.exports = function(grunt) {
    "use strict";
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        sass: {
            expanded: {
                options: {
                    sourceMap: false,
                    outputStyle: "expanded", // nested, > expanded, compact, compressed
                },
                files: {
                    'css/app.css': 'sass/principal.scss'
                }
            },
            compressed: {
                options: {
                    sourceMap: false,
                    outputStyle: "compressed",
                },
                files: {
                    'css/app.min.css': 'sass/principal.scss'
                }
            }
        },
        copy: {
            main: {
                files: [
                    {
                        expand : true,
                        cwd    : 'plugins',
                        src    : ['**'],
                        dest   : '../../plugins/'
                    }
                ]
            }
        },
        watch: {
            sass: {
                files: ['sass/**/*.scss'],
                tasks: ['sass:expanded'],
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
    grunt.registerTask('default', ['sass:expanded']);
    grunt.registerTask('build', ['sass:compressed']);
    grunt.registerTask('plugin', ['copy']);
};
