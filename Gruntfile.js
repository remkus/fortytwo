/* global require */
module.exports = function(grunt) {
	'use strict';

	require( 'load-grunt-tasks' )(grunt, {
		pattern: ['grunt-*', 'assemble-less']
	});

	require('time-grunt')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON( 'package.json' ),

		// Clean
		clean: {
			dist: {
				src: ['dist']
			},
			tmp: {
				src: ['tmp']
			}
		},

		// Retrieve dependencies (set in bower.json)
		bower: {
			install: {
				options: {
					targetDir: 'assets/bower',
					cleanup: true
				}
			}
		},

		// Copy dependencies out of assets/ and into theme/
		// CSS (Less) and images are transferred during other tasks
		copy: {
			fonts: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['assets/bower/fonts/**/*', '!assets/bower/fonts/**/*.otf'],
						dest: 'theme/fonts/',
						filter: 'isFile'
					}
				]
			},
			js: {
				files: [
					{
						expand: true,
						flatten: true,
						// holder.js is not yet in use
						src: ['assets/**/js/**/*', '!assets/bower/js/holderjs/holder.js'],
						dest: 'theme/js/',
						filter: 'isFile'
					}
				]
			},
			php: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['assets/composer/wpthumb/wpthumb.*'],
						dest: 'theme/lib/wpthumb/',
						filter: 'isFile'
					}
				]
			}
		},

		replace: {
			fonticons: {
				options: {
					patterns: [{
						match: /\"variables\"/g,
						replacement: '"ft-variables"'
					}]
				},
				files: [{
					expand: true,
					flatten: true,
					cwd: 'assets/bower/less/font-awesome/',
					src: ['font-awesome.less'],
					dest: 'assets/bower/less/font-awesome/'
				}]
			},
			// style is run after style.css is generated to fix comments
			style: {
				options: {
					patterns: [
						{ // Remove ! in comments as they interfer with styledocco appearance
							match: /\/\*!/g,
							replacement: '/*'
						},
						{ // Avoid minified code following immediately after closing comment delimiter
							match: /\*\/(?=\S)/g,
							replacement: '*/\n\n'
						},
						{ // Add some code standards white space
							match: /^\}/gm,
							replacement: '}\n'
						}
					]
				},
				files: {
					'theme/style.css': ['theme/style.css']
				}
			},
			release: {
				options: {
					patterns: [
						{
							match: 'release',
							replacement: '<%= pkg.version %>'
						}
					]
				},
				files: [
					{
						expand: true,
						src: ['**/*']
					}
				]
			}
		},

		// CSS

		// Build .less files into .css files
		less: {
			fontAwesome: {
				options: {
					paths: ['assets/forsitethemes/less', 'assets/bower/less/font-awesome'],
					imports: {
						reference: ['ft-variables.less']
					}
				},
				files: {
					'tmp/assets/css/font-awesome.css': 'assets/bower/less/font-awesome/font-awesome.less'
				}
			},
			components: {
				options: {
					paths: ['tmp/assets/css', 'assets/forsitethemes/less', 'assets/bower/less/bootstrap'],
					imports: {
						reference: ['ft-variables.less', 'ft-mixins.less', 'mixins.less', 'utilities.less']
					}
				},
				files: [{
					expand: true,
					flatten: true,
					cwd: 'assets/forsitethemes/less',
					src: ['*.less', '!{ft-variables,ft-mixins}.less'],
					dest: 'tmp/assets/css/',
					ext: '.css'
				}, {
					expand: true,
					flatten: true,
					cwd: 'assets/forsitethemes/less/admin',
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
					'tmp/assets/css/**/*.css'
				],
				options: {
					// diff: 'tmp/autoprefixer.patch'
				}
			}
		},

		// Tidy the CSS
		csscomb: {
			css: {
				expand: true,
				src: ['tmp/assets/css/**/*.css']
			}
		},

		// Minify some parts of the CSS
		cssmin: {
			compress: {
				options: {
					keepSpecialComments: 1,
					report: 'gzip'
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
				separator: '\n\n'
			},
			style: {
				options: {
					banner: '/* # FortyTwo\n' +
						' * Theme Name: <%= pkg.theme.name %>\n' +
						' * Theme URI: <%= pkg.theme.uri %>\n' +
						' * Description: <%= pkg.theme.description %>\n' +
						' * Author: <%= pkg.theme.author %>\n' +
						' * Author URI: <%= pkg.theme.authoruri %>\n' +
						' * Version: <%= pkg.version %>\n' +
						' * Tags: <%= pkg.theme.tags %>\n' +
						' * Text Domain: <%= pkg.theme.textdomain %>\n' +
						' * License: <%= pkg.theme.license %>\n' +
						' * License URI: <%= pkg.theme.licenseuri %>\n' +
						' * Template: <%= pkg.theme.template %>\n' +
						'*/\n\n'
				},
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
				dest: 'theme/style.css'
			},
			adminStyle: {
				options: {
					footer: '\n\n\n/* Would it save you a lot of time if I just gave up and went mad now? ― Douglas Adams */'
				},
				src: [
					'tmp/assets/css/admin/ft-admin-core.css'
				],
				dest: 'theme/admin-style.css'
			}
		},

		// Images

		// Optimize images to save bytes
		imagemin: {
			images: {
				files: [
					{
						expand: true,
						cwd: 'assets/forsitethemes/images/',
						src: ['*.*'],
						dest: 'theme/images'
					}
				]
			},
			layouts: {
				files: [
					{
						expand: true,
						cwd: 'assets/forsitethemes/images/layouts/',
						src: ['*.*'],
						dest: 'theme/lib/admin/images/layouts'
					}
				]
			}
		},

		// JavaScript

		// Lint JS code practices
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
					'assets/forsitethemes/*.js',
					'theme/lib/widgets/**/*.js',
					'!theme/lib/widgets/ft-responsive-slider/js/jquery.flexslider-min.js'
				]
			}
		},

		// Lint JS for code standards
		jscs: {
			options: {
				config: '.jscsrc'
			},
			all: {
				files: {
					src: [
						'.bowerrc',
						'.csscomb.json',
						'.gruntjshintrc',
						'.jshintrc',
						'.lessrc',
						'bower.json',
						'Gruntfile.js',
						'package.json',
						'assets/forsitethemes/*.js',
						'theme/lib/widgets/**/*.js',
						'!theme/lib/widgets/ft-responsive-slider/js/jquery.flexslider-min.js'
					]
				}
			}
		},

		// Lint JSON files for syntax errors
		jsonlint: {
			all: {
				src: [
					'.bowerrc',
					'.csscomb.json',
					'.gruntjshintrc',
					'.jshintrc',
					'.lessrc',
					'bower.json',
					'package.json'
				]
			}
		},

		// Lint .js files for syntax errors
		jsvalidate: {
			all: {
				options: {
					verbose: true
				},
				files: {
					src: [
						'Gruntfile.js',
						'theme/**/*.js'
					]
				}
			}
		},

		// PHP

		// Lint .php files for syntax errors
		phplint: {
			all: ['theme/**/*.php']
		},

		// Lint .php files for code standards
		phpcs: {
			all: {
				dir: ['theme/**/*.php', '!theme/lib/wpthumb/**/*']
			},
			options: {
				standard: 'ruleset.xml',
				reportFile: 'phpcs.txt'
			}
		},

		// PHP Unit and Integration Tests
		// phpunit: {
		// 	all: {
		// 		dir: 'tests/',
		// 		cmd: 'phpunit',
		// 		args: ['-c', 'phpunit.xml']
		// 	}
		// },

		// I18n

		addtextdomain: {
			options: {
				textdomain: 'fortytwo'
			},
			php: {
				files: {
					src: [
						'theme/**/*.php',
						'!theme/lib/wpthumb/*.php'
					]
				}
			}
		},

		checktextdomain: {
			options: {
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
				expand: true,
				src: [
					'theme/**/*.php',
					'!theme/lib/wpthumb/*.php'
				]
			}
		},

		// Build language .pot file
		makepot: {
			theme: {
				options: {
					cwd: 'theme',
					exclude: ['lib/wpthumb/.*'],
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
					archive: 'dist/<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				files: [
					{
						expand: true,
						cwd: 'theme',
						src: ['**/*'], // Take this...
						dest: '<%= pkg.name %>' // ...put it into this, then zip that up as ^^^
					}
				]
			}
		},

		styledocco: {
			dist: {
				options: {
					name: '<%= pkg.theme.name %> <%= pkg.version %>'
				},
				files: {
					'docs/css/style': 'theme/style.css',
					'docs/css/admin-style': 'theme/admin-style.css'
				}
			}
		}

	});

	// Register tasks

	grunt.registerTask( 'check', [
		'jshint',
		'jsonlint',
		'jsvalidate',
		'jscs',
		'phplint',
		'checktextdomain',
		'phpcs'
	] );

	grunt.registerTask( 'dependencies', [
		'bower',
		'copy',
		'replace'
	] );

	grunt.registerTask( 'build', [
		'build:css'
	] );

	grunt.registerTask( 'build:css', [
		'clean:tmp',
		'less',
		'csscomb',
		'cssmin',
		'concat',
		'clean:tmp',
		'replace:style',
		'styledocco'
	] );

	grunt.registerTask( 'build:i18n', [
		'addtextdomain',
		'makepot'
	] );

	grunt.registerTask( 'package', [
		'clean:dist',
		'compress'
	] );

	// Top level function to build a new release
	grunt.registerTask( 'release', function( releaseType ) {
		if ( 'major' !== releaseType && 'minor' !== releaseType && 'patch' !== releaseType ) {
			grunt.fail.fatal( 'Please specify the release type (major, minor, or patch), e.g., "grunt release:patch"' );
		} else {
			// Check to make sure the log exists
			grunt.task.run( 'log:' + releaseType );

			// Replace release version placeholders
			grunt.task.run( 'replace:release' );

			// Build everything
			grunt.task.run( 'build' );

			// Create the .pot file
			grunt.task.run( 'build:i18n' );

			// Optimize images
			grunt.task.run( 'imagemin' );

			// Zip it up
			grunt.task.run( 'package' );
		}
	} );

	// Prompt for the changelog
	grunt.registerTask( 'log', function( releaseType ) {
		var semver = require( 'semver' ),
			pkg,
			changelog,
			newVersion = semver.inc( grunt.config.get( 'pkg' ).version, releaseType ),
			regex = new RegExp( '^## ' + newVersion, 'gm' ); // Match the version number (e.g., "## 1.2.3")

		if ( 'major' !== releaseType && 'minor' !== releaseType && 'patch' !== releaseType ) {
			grunt.fail.fatal( 'Please specify the release type (major, minor, or patch), e.g., "grunt release:patch"' );
		} else {
			pkg = grunt.file.readJSON('package.json');
			// Get the new version
			changelog = grunt.file.read( pkg.changelog );

			if ( changelog.match( regex ) ) {
				grunt.log.ok( 'v' + newVersion + ' changlelog entry found' );
			} else {
				grunt.fail.fatal( 'Please enter a changelog entry for v' + newVersion );
			}
		}
	} );

	grunt.registerTask( 'default', [
		'build'
	] );
};
