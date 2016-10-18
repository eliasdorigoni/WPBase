module.exports = function(grunt) {
    "use strict";
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        sass: {
            debug: {
                options: {
                    sourceMap: false,
                    outputStyle: "expanded",
                },
                files: {
                    'css/app.css': 'sass/global.scss'
                }
            },
            produccion: {
                options: {
                    sourceMap: false,
                    outputStyle: "compressed",
                },
                files: {
                    'css/app.min.css': 'sass/global.scss'
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
                tasks: ['sass:debug'],
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
    grunt.registerTask('default', ['sass:debug']);
    grunt.registerTask('build', ['sass:produccion']);
    grunt.registerTask('plugin', ['copy']);
};
