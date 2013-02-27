<?php
/** Start the engine */
require_once( TEMPLATEPATH . '/lib/init.php' );

/** Add FortyTwo Turbos */
require_once( CHILD_DIR . '/config/initializers/init.php' );

add_theme_support( 'genesis-html5' ); //TODO Decide if we need to style for when the HTML5 support is switched off


//add_filter( 'body_class', 'fortytwo_add_bootstrap_class' );
/**
 * Add custom body class to the head
 * @param  variable $classes css body tags
 * @return variable ammended $classes
 */
function fortytwo_add_bootstrap_class( $classes ) {
	$classes[] = 'bootstrap';
	return $classes;
}

add_action( 'genesis_meta', 'fortytwo_viewport_meta_tag' );
/**
 * Add Viewport meta tag for mobile browsers
 * @return echo meta viewport tag
 */
function fortytwo_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

add_filter( 'stylesheet_uri', 'fortywo_replace_default_style_sheet', 10, 2 );
/**
 * Replace default style sheet
 * @return constant Base FortyTwo CSS
 */
function fortywo_replace_default_style_sheet() {
    return CHILD_URL . '/theme/assets/stylesheets/fortytwo.css';
}

add_action( 'wp_enqueue_scripts', 'fortytwo_load_custom_style_sheet' );
/**
 * Load custom style sheet for...
 * @todo  Better explanation as to why this function is needed
 * @return [type] [description]
 */
function fortytwo_load_custom_style_sheet() {
    wp_enqueue_style( 'custom-stylesheet', CHILD_URL . '/style.css', array(), PARENT_THEME_VERSION );
}

add_action( 'wp_enqueue_scripts', 'fortytwo_load_google_fonts' );
/**
 * Loading Google Fonts
 * @return [type] [description]
 */
function fortytwo_load_google_fonts() {
    wp_enqueue_style( 'google-font-open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,600,300', array(), PARENT_THEME_VERSION );
    wp_enqueue_style( 'google-font-droid-serif', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic', array(), PARENT_THEME_VERSION );
    wp_enqueue_style( 'google-font-source-sans-pro', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), PARENT_THEME_VERSION );
}

// Add support for structural wraps
//add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

// Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

// Register widget areas
genesis_register_sidebar( array(
	'id'			=> 'home-slider',
	'name'			=> __( 'Home Slider', 'fortytwo' ),
	'description'	=> __( 'This is the slider section of the homepage.', 'fortytwo' ),
) );
genesis_register_sidebar( array(
    'id'			=> 'home-notice',
    'name'			=> __( 'Home Notice', 'fortytwo' ),
    'description'	=> __( 'This is the notice section of the homepage.', 'fortytwo' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-row-1-col-1',
	'name'			=> __( 'Home Row 1 Column 1', 'fortytwo' ),
	'description'	=> __( 'This is Column 1 of Row 1 on the homepage.', 'fortytwo' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-row-1-col-2',
	'name'			=> __( 'Home Row 1 Column 2', 'fortytwo' ),
	'description'	=> __( 'This is Column 2 of Row 1 on the homepage.', 'fortytwo' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-row-1-col-3',
	'name'			=> __( 'Home Row 1 Column 3', 'fortytwo' ),
	'description'	=> __( 'This is Column 3 of Row 1 on the homepage.', 'fortytwo' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-row-1-col-4',
	'name'			=> __( 'Home Row 1 Column 4', 'fortytwo' ),
	'description'	=> __( 'This is Column 4 of Row 1 on the homepage.', 'fortytwo' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-row-2-col-1',
	'name'			=> __( 'Home Row 2 Column 1', 'fortytwo' ),
	'description'	=> __( 'This is Column 1 of Row 1 on the homepage.', 'fortytwo' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-row-2-col-2',
	'name'			=> __( 'Home Row 2 Column 2', 'fortytwo' ),
    'description'	=> __( 'This is Column 2 of Row 2 on the homepage.', 'fortytwo' ),
) );