<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

// Load translation files
load_child_theme_textdomain( 'fortytwo', get_stylesheet_directory() . '/lib/languages' );


// Add theme support for HTML5
add_theme_support(
	'html5',
	array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	)
);

// Add responsive viewport markup
add_theme_support( 'genesis-responsive-viewport' );

// Add support for specified theme widgets
add_theme_support(
	'fortytwo-widgets',
	array(
		'ft-contact',
		'ft-featured-content',
		'ft-jumbotron',
		'ft-responsive-slider',
		'ft-tabs-widget',
		'ft-testimonials',
	)
);

// Include the rest of the theme files
require_once 'lib/init.php';