'use strict';

module.exports = function (grunt) {

	require('time-grunt')(grunt);
	require('load-grunt-tasks')(grunt, {pattern: ['grunt-*', 'assemble-less']});

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		copy: {
			fonticons: {
				files: [
					{expand: true, flatten: true, src: ['vendor/bootstrap/dist/fonts/*'], dest: 'assets/fonts/', filter: 'isFile'},
					{expand: true, flatten: true, src: ['vendor/font-awesome/fonts/*'], dest: 'assets/fonts/', filter: 'isFile'}
				]
			}
		},
		replace: {
			fonticons: {
				options: {
					patterns: [
						{
							match: /variables/g,
							replacement: 'ft-variables'
						}
					]
				},
				files: [
					{expand: true, flatten: true, src: ['vendor/font-awesome/less/font-awesome.less'], dest: 'tmp/assets/less/'}
				]
			}
		},
		clean: {
			tmp: {
				src: [ 'tmp' ]
			}
		},
		less: {
			fonticons: {
				options: {
					paths: ['assets/less', 'vendor/font-awesome/less'],
					imports: {reference: ['ft-variables.less']}
				},
				files: {
					'tmp/assets/less/ft-font-awesome.less': ['tmp/assets/less/font-awesome.less'],
					'tmp/assets/css/admin/ft-admin-font-awesome.css': ['tmp/assets/less/font-awesome.less']
				}
			},
			components: {
				options: {
					paths: ['assets/less', 'vendor/bootstrap/less', 'tmp/assets/less'],
					imports: {
						reference: ['ft-variables.less', 'ft-mixins.less', 'mixins.less', 'utilities.less']
					}
				},
				files: [
					{expand: true, flatten: true, cwd: 'assets/less', src: ['*.less', '!{ft-variables,ft-mixins}.less'], dest: 'tmp/assets/css/', ext: '.css'}
				]
			},
			fortytwo_admin_style: {
				options: {
					paths: ['assets/less', 'assets/less/admin'],
					imports: {
						reference: ['ft-variables.less', 'ft-mixins.less']
					}
				},
				files: {
					'tmp/assets/css/admin/ft-admin-core.css': ['assets/less/admin/ft-admin-core.less']
				}
			}
		},
		cssmin: {
			compress: {
				options: {
					keepSpecialComments: 1
				},
				files: {
					'tmp/assets/css/ft-reset.css': ['tmp/assets/css/ft-reset.css'],
					'tmp/assets/css/ft-print.css': ['tmp/assets/css/ft-print.css']
				}
			}
		},
		concat: {
			options: {
				separator: '\n\n',
				banner: '/*!\n' +
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
			fortytwo_style: {
				src: [
					'tmp/assets/css/ft-index.css',
					'tmp/assets/css/ft-reset.css',
					'tmp/assets/css/ft-core.css',
					'tmp/assets/css/ft-font-icons.css',
					'tmp/assets/css/ft-header.css',
					'tmp/assets/css/ft-navigation.css',
					'tmp/assets/css/ft-intro.css',
					'tmp/assets/css/ft-widgets.css',
					'tmp/assets/css/ft-content.css',
					'tmp/assets/css/ft-footer.css',
					'tmp/assets/css/ft-print.css'
				],
				dest: 'style.css'
			},
			fortytwo_admin_style: {
				options: {
					stripBanners: true,
					banner: ''
				},
				src: [
					'tmp/assets/css/admin/ft-admin-core.css',
					'tmp/assets/css/admin/ft-admin-font-awesome.css'
				],
				dest: 'lib/admin/css/admin-style.css'
			}
		},
		cssbeautifier: {
			files: ["tmp/assets/css/{ft-core,ft-font-icons,ft-header,ft-navigation,ft-intro,ft-widgets,ft-content,ft-footer}.css"],
			options: {
				indent: '\t',
				openbrace: 'end-of-line',
				autosemicolon: true
			}
		},
		csscomb: {
			sort: {
				options: {
					sortOrder: '.csscomb.json'
				},
				files: {
					'tmp/assets/css/ft-core.css': ['tmp/assets/css/ft-core.css'],
					'tmp/assets/css/ft-font-icons.css': ['tmp/assets/css/ft-font-icons.css'],
					'tmp/assets/css/ft-header.css': ['tmp/assets/css/ft-header.css'],
					'tmp/assets/css/ft-navigation.css': ['tmp/assets/css/ft-navigation.css'],
					'tmp/assets/css/ft-intro.css': ['tmp/assets/css/ft-intro.css'],
					'tmp/assets/css/ft-widgets.css': ['tmp/assets/css/ft-widgets.css'],
					'tmp/assets/css/ft-content.css': ['tmp/assets/css/ft-content.css'],
					'tmp/assets/css/ft-footer.css': ['tmp/assets/css/ft-footer.css']
				}
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
		'copy:fonticons',
		'replace',
		'less',
		'cssmin',
		'cssbeautifier',
		'csscomb',
		'concat',
		'clean'
	]);

	grunt.registerTask('stylesheet', [
		'clean',
		'copy:fonticons',
		'replace',
		'less',
		'cssmin',
		'cssbeautifier',
		'csscomb',
		'concat',
		'clean'
	]);
};
