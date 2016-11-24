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
                    'css/app.min.css': 'sass/global.scss'
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
            }
        },
        watch: {
            sass: {
                files: ['sass/**/*.scss', '!sass/foundation.scss'],
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
    grunt.registerTask('default', ['sass:dist', 'copy']);
    grunt.registerTask('build', ['sass:dist', 'sass:foundation', 'copy']);
};
