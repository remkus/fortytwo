'use strict';

module.exports = function(grunt) {

	require('load-grunt-tasks')(grunt, {
		pattern: ['grunt-*', 'assemble-less']
	});

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		copy: {
			fonticons: {
				files: [{
					expand: true,
					flatten: true,
					src: ['vendor/bootstrap/dist/fonts/*'],
					dest: 'assets/fonts/',
					filter: 'isFile'
				}, {
					expand: true,
					flatten: true,
					src: ['vendor/font-awesome/fonts/*'],
					dest: 'assets/fonts/',
					filter: 'isFile'
				}, {
					expand: true,
					flatten: true,
					src: ['vendor/font-awesome/fonts/*'],
					dest: 'lib/admin/assets/fonts/',
					filter: 'isFile'
				}]
			}
		},
		clean: {
			tmp: {
				src: ['tmp']
			}
		},
		replace: {
			fonticons: {
				options: {
					patterns: [{
						match: /variables/g,
						replacement: 'ft-variables'
					}]
				},
				files: [{
					expand: true,
					flatten: true,
					src: ['vendor/font-awesome/less/font-awesome.less'],
					dest: 'tmp/assets/less/'
				}]
			}
		},


		// CSS

		// Build .less files into .css files
		less: {
			font_awesome: {
				options: {
					paths: ['assets/less', 'vendor/font-awesome/less'],
					imports: {
						reference: ['ft-variables.less']
					}
				},
				files: {
					'tmp/assets/css/font-awesome.css': 'tmp/assets/less/font-awesome.less'
				}
			},
			components: {
				options: {
					paths: ['assets/less', 'vendor/bootstrap/less', 'tmp/assets/css'],
					imports: {
						reference: ['ft-variables.less', 'ft-mixins.less', 'mixins.less', 'utilities.less']
					}
				},
				files: [{
					expand: true,
					flatten: true,
					cwd: 'assets/less',
					src: ['*.less', '!{ft-variables,ft-mixins}.less'],
					dest: 'tmp/assets/css/',
					ext: '.css'
				}, {
					expand: true,
					flatten: true,
					cwd: 'assets/less/admin',
					src: ['*.less'],
					dest: 'tmp/assets/css/admin/',
					ext: '.css'
				}]
			}
		},

		// Add vendor prefixes needed for specified browsers
		autoprefixer: {
			options: {
				browsers: [
					'last 1 versions',
					'Explorer >= 8'
				]
			},
			all: {
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
					'tmp/assets/css/ft-print.css',
					'tmp/assets/css/ft-custom.css',
					'tmp/assets/css/admin/ft-admin-core.css'
				],
				options: {
					// diff: 'tmp/autoprefixer.patch'
				}
			}
		},

		// Minify some parts of the CSS
		cssmin: {
			compress: {
				options: {
					keepSpecialComments: 1
				},
				files: {
					'tmp/assets/css/ft-reset.css': ['tmp/assets/css/ft-reset.css'],
					'tmp/assets/css/ft-print.css': ['tmp/assets/css/ft-print.css'],
					'tmp/assets/css/ft-font-icons.css': ['tmp/assets/css/ft-font-icons.css'],
					'tmp/assets/css/admin/ft-admin-core.css': ['tmp/assets/css/admin/ft-admin-core.css']
				}
			}
		},

		// Merge files into final .css files and add a banner to style.css
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
					'  Tags: <%= pkg.theme.tags %>\n' +
					'  Text Domain: <%= pkg.theme.textdomain %>\n\n' +
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
					'tmp/assets/css/ft-print.css',
					'tmp/assets/css/ft-custom.css'
				],
				dest: 'style.css'
			},
			fortytwo_admin_style: {
				options: {
					stripBanners: true,
					banner: ''
				},
				src: [
					'tmp/assets/css/admin/ft-admin-core.css'
				],
				dest: 'lib/admin/admin-style.css'
			}
		},

		// Make the CSS look good
		cssbeautifier: {
			files: ['tmp/assets/css/{ft-core,ft-header,ft-navigation,ft-intro,ft-widgets,ft-content,ft-footer,ft-custom}.css'],
			options: {
				indent: '\t',
				openbrace: 'end-of-line',
				autosemicolon: true
			}
		},

		// Order properties consistently
		csscomb: {
			// less: {
			// 	expand: true,
			// 	cwd: 'assets/less/',
			// 	src: ['**/*.less'],
			// 	dest: 'assets/less/'
			// },
			css: {
				files: {
					'tmp/assets/css/ft-core.css': ['tmp/assets/css/ft-core.css'],
					'tmp/assets/css/ft-header.css': ['tmp/assets/css/ft-header.css'],
					'tmp/assets/css/ft-navigation.css': ['tmp/assets/css/ft-navigation.css'],
					'tmp/assets/css/ft-intro.css': ['tmp/assets/css/ft-intro.css'],
					'tmp/assets/css/ft-widgets.css': ['tmp/assets/css/ft-widgets.css'],
					'tmp/assets/css/ft-content.css': ['tmp/assets/css/ft-content.css'],
					'tmp/assets/css/ft-footer.css': ['tmp/assets/css/ft-footer.css'],
					'tmp/assets/css/ft-custom.css': ['tmp/assets/css/ft-custom.css']
				}
			}
		},


		// JavaScript
		
		// Lint JS code standards
		jshint: {
			grunt: {
				options: {
					jshintrc: '.gruntjshintrc'
				},
				src: ['Gruntfile.js']
			},
			theme: {
				options: {
					jshintrc: true
				},
				expand: true,
				src: [
					'**/*.js',
					'!Gruntfile.js',
					'!node_modules/**',
					'!vendor/**',
					'!lib/widgets/ft-responsive-slider/js/jquery.flexslider-min.js'
				]
			}
		},


		// PHP

		// Lint .php files for syntax errors
		phplint: {
			all: [ '*.php', 'lib/**/*.php', 'templates/**/*.php' ]
		},

		// Lint .php files for code standards
		phpcs: {
			all: {
				dir: [ '**/*.php' ]
			},
			options: {
				standard: 'ruleset.xml',
				reportFile: 'phpcs.txt'
			}
		},

		// PHP Unit and Integration Tests
		phpunit: {
			all: {
				dir: 'tests/',
				cmd: 'phpunit',
				args: ['-c', 'phpunit.xml']
			}
		},


		// I18n
		
		addtextdomain: {
			options: {
				// textdomain: 'fortytwo'
			},
			php: {
				files: {
					src: [
						'*.php',
						'lib/**/*.php',
						'templates/**/*.php'
					]
				}
			}
		},

		checktextdomain: {
			options: {
				// text_domain: '<%= pkg.theme.textdomain %>',
				text_domain: 'fortytwo',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d', 
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d',
					'esc_attr__:1,2d', 
					'esc_html__:1,2d',
					'esc_attr_e:1,2d', 
					'esc_html_e:1,2d',
					'esc_attr_x:1,2c,3d', 
					'esc_html_x:1,2c,3d'
				]
			},
			files: {
				src: [
				'*.php',
				'lib/**/*.php',
				'templates/**/*.php'
				],
				expand: true
			}
		},


		// Build language .pot file
		makepot: {
			theme: {
				options: {
					domainPath: '/lib/languages',
					processPot: function( pot ) {
						pot.headers['report-msgid-bugs-to']   = 'http://forsitethemes.com';
						pot.headers['plural-forms']           = 'nplurals=2; plural=n != 1;';
						pot.headers['last-translator']        = 'Remkus de Vries <translations@forsitethemes.com>';
						pot.headers['language-team']          = 'Forsite Translations <translations@forsitethemes.com>';
						pot.headers['x-generator']            = 'grunt-wp-i18n 0.4.3';
						pot.headers['x-poedit-basepath']      = '.';
						pot.headers['x-poedit-language']      = 'English';
						pot.headers['x-poedit-country']       = 'UNITED STATES';
						pot.headers['x-poedit-sourcecharset'] = 'utf-8';
						pot.headers['x-poedit-keywordslist']  = '__;_e;_x:1,2c;_ex:1,2c;_n:1,2; _nx:1,2,4c;_n_noop:1,2;_nx_noop:1,2,3c;esc_attr__; esc_html__;esc_attr_e; esc_html_e;esc_attr_x:1,2c; esc_html_x:1,2c;';
						pot.headers['x-poedit-bookmarks']     = '';
						pot.headers['x-poedit-searchpath-0']  = '.';
						pot.headers['x-textdomain-support']   = 'yes';
						return pot;
					},
					type: 'wp-theme'
				}
			}
		},


		// Prepare for release
		
		compress: {
			dist: {
				options: {
					archive: 'publish/<%= pkg.name %>.zip'
				},
				files: [{
					src: ['dist/**']
				}]
			}
		}


	});


	// Register tasks
	
	grunt.registerTask( 'check', [
		'phplint',
		'checktextdomain',
		'jshint'
	] );
	
	grunt.registerTask( 'build:css', [
		'clean',
		'copy:fonticons',
		'replace',
		'less',
		'cssmin',
		'cssbeautifier',
		'csscomb',
		'concat',
		'clean'
	] );

	grunt.registerTask( 'build:i18n', [
		'addtextdomain',
		'makepot'
	] );

	grunt.registerTask( 'build', [
		'build:css',
		'build:i18n'
	] );

	grunt.registerTask( 'default', [
		'build'
	] );


};
