'use strict';

module.exports = function (grunt) {

    require('time-grunt')(grunt);
    require('load-grunt-tasks')(grunt);
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
            dist: {
                src: [ 'dist' ]
            },
            publish: {
                src: [ 'publish' ]
            }
        },
        less: {
            dist: {
                options: {
                    paths: [ 'app/bower_components/bootstrap/less', 'app/bower_components/font-awesome/less' ]
                },
                files: {
                    'app/styles/app.css': 'app/styles/less/app.less'
                }
            }
        },
        cssmin: {
            minify: {
                expand: true,
                cwd: 'app/styles',
                src: ['*.css', '!*.min.css'],
                dest: 'dist/styles/',
                ext: '.min.css'
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
};
