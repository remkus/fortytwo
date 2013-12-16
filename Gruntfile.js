'use strict';

module.exports = function (grunt) {

    require('time-grunt')(grunt);
    require('load-grunt-tasks')(grunt, {pattern: ['grunt-*', 'assemble-less']});

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: {
            tmp: {
                src: [ 'tmp' ]
            }
        },
        less: {
            options: {
                lessrc: '.lessrc'
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
                    {expand: true, flatten: true, cwd: 'assets/less', src: ['*.less', '!{ft-variables,ft-mixins,ft-font-icons}.less'], dest: 'tmp/assets/css/', ext: '.css'}
                ]
            }
        },
        cssmin: {
            compress: {
                options: {
                    banner: '/* custom banner */',
                    keepSpecialComments: 0
                },
                files: {
                    'tmp/assets/css/ft-print.css': ['tmp/assets/css/ft-print.css']
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
                footer: '\n\n\n/* Would it save you a lot of time if I just gave up and went mad now? ― Douglas Adams */'
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
                    'tmp/assets/css/ft-content.css',
                    'tmp/assets/css/ft-footer.css',
                    'tmp/assets/css/ft-print.css'
                ],
                dest: 'style.css'
            }
        }
    });

    grunt.registerTask('stylesheet', [
        'clean',
        'less',
        'concat'
    ]);
};
