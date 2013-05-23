<?php
/*
 * FortyTwo Initializer File
 */

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'FortyTwo Theme' );
define( 'CHILD_THEME_URL', 'http://forsitethemes.com/themes/fortytwo' );
define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

/** Load Initializer Components */
require_once( 'ft-cleanup.php' );

require_once( 'ft-scripts.php' );

require_once( 'ft-nav.php' );

require_once( 'ft-page-title.php' );

require_once( 'ft-slider.php' );