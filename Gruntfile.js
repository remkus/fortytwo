'use strict';

module.exports = function (grunt) {

    require('time-grunt')(grunt);
    require('load-grunt-tasks')(grunt, {pattern: ['grunt-*', 'assemble-less']});

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        copy: {
            dist: {
                files: [
                    // includes files within path
                    {expand: true, cwd: 'app', src: ['_locales/**'], dest: 'dist/', filter: 'isFile'}

                    // includes files within path and its sub-directories
                    //{expand: true, src: ['path/**'], dest: 'dest/'},

                    // makes all src relative to cwd
                    //{expand: true, cwd: 'path/', src: ['**'], dest: 'dest/'},

                    // flattens results to a single level
                    //{expand: true, flatten: true, src: ['path/**'], dest: 'dest/', filter: 'isFile'}
                ]
            }
        },
        clean: {
            tmp: {
                src: [ 'tmp' ]
            }
        },
        less: {
            options: {
                lessrc: '.lessrc'
            },
            reset: {
                options: {
                    compress: true
                },
                files: {
                    'tmp/assets/css/ft-reset.css': ['assets/less/ft-reset.less']
                }
            },
            fonticons: {
                options: {
                    compress: true
                },
                files: {
                    'tmp/assets/css/ft-font-icons.css': ['assets/less/ft-font-icons.less']
                }
            },
            components: {
                files: [
                    {expand: true, flatten: true, cwd: 'assets/less', src: ['*.less', '!{ft-variables,ft-mixins,ft-reset,ft-font-icons}.less'], dest: 'tmp/assets/css/', ext: '.css'}
                ]
            }
        },
        cssmin: {
            ftreset: {
              options: {
                keepSpecialComments: 1
              },
              files: {
                'tmp/assets/css/ft-reset.css': ['tmp/assets/css/ft-reset.css']
              }
            }
        },
        concat: {
            options: {
                separator: '\n\n',
                banner:
                    '/*!\n' +
                    '  Theme Name: <%= pkg.theme.name %>\n' +
                    '  Theme URI: <%= pkg.theme.uri %>\n' +
                    '  Description: <%= pkg.theme.description %>\n' +
                    '  Author: <%= pkg.theme.author %>\n' +
                    '  Author URI: <%= pkg.theme.authoruri %>\n' +
                    '  Version: <%= pkg.theme.version %>\n' +
                    '  Tags: <%= pkg.theme.tags %>\n\n' +
                    '  License: <%= pkg.theme.license %>\n' +
                    '  License URI: <%= pkg.theme.licenseuri %>\n\n' +
                    '  Template: <%= pkg.theme.template %>\n' +
                    '*/\n\n',
                footer: '\n/* Would it save you a lot of time if I just gave up and went mad now? ― Douglas Adams */'
            },
          fortytwo: {
              src: [
                  'tmp/assets/css/ft-index.css',
                  'tmp/assets/css/ft-reset.css',
                  'tmp/assets/css/ft-core.css',
                  'tmp/assets/css/ft-font-icon.css',
                  'tmp/assets/css/ft-header.css',
                  'tmp/assets/css/ft-navigation.css',
                  'tmp/assets/css/ft-intro.css',
                  'tmp/assets/css/ft-widgets.css',
                  'tmp/assets/css/ft-content.css'

              ],
              dest: 'style.css'
          }
        },
        compress: {
            dist: {
                options: {
                    archive: 'publish/<%= pkg.name %>.zip'
                },
                files: [
                    { src: ['dist/**'] }
                ]
            }
        }
    });

    grunt.registerTask('build', [
        'clean',
        'less',
        'cssmin',
        'copy',
        'compress'

    ]);

    grunt.registerTask('stylesheet', [
        'clean',
        'less',
//        'cssmin',
        'concat'
    ]);
};
