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
            dist: {
                src: [ 'dist' ]
            },
            publish: {
                src: [ 'publish' ]
            }
        },
        less: {
            options: {
                paths: ['vendor/bootstrap/less', 'vendor/font-awesome/less']
            },
//            normalize: {
//                options: {
//                    banner:
//                        '/**!\n' +
//                        '* 1.0 Reset\n' +
//                        '*\n' +
//                        '* FortyTwo reset that attempts to make browsers render all elements more\n' +
//                        '* consistently.\n' +
//                        '*\n' +
//                        '* @uses: bootstrap [normalize]\n' +
//                        '*/\n',
//                    compress: true
//                },
//                files: {
//                    'assets/less/ft-reset.css': 'vendor/bootstrap/less/normalize.less'
//                }
//            },
//            bootstrap: {
//                src: 'vendor/bootstrap/less/bootstrap.less',
//                dest: 'bootstrap.css'
//            },
//            fontawesome: {
//
//            },
            fortytwo: {
                files: {
                    'style.css': ['assets/less/fortytwo.less']
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