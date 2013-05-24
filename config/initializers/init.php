<?php
/*
 * FortyTwo Initializer File
 */

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'FortyTwo Theme' );
define( 'CHILD_THEME_URL', 'http://forsitethemes.com/themes/fortytwo' );
define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

/** Load Initializer Components */
//require_once( 'ft-doctype.php' );
require_once( 'ft-cleanup.php' );

require_once( 'ft-scripts.php' );

require_once( 'ft-nav.php' );
require_once( 'ft-slider.php' );

//require_once( 'genassist_enqueue_scripts.php' );
//require_once( 'genassist_preferences.php' );
//require_once( 'html5.php' );


/** Activate modules **/

//TODO:  Move this somewhere sensible
function modules_url($file) {
	return CHILD_URL . '/modules/' . $file;
}

require_once( CHILD_DIR . '/modules/genesis-responsive-slider/genesis-responsive-slider.php' );
require_once( CHILD_DIR . '/modules/ft-featured-page/plugin.php' );
require_once( CHILD_DIR . '/modules/ft-jumbotron/plugin.php' );
require_once( CHILD_DIR . '/modules/ft-responsive-slider/plugin.php' );
require_once( CHILD_DIR . '/modules/ft-testimonials/plugin.php' );
