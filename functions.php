<?php
/** Start the engine */
require_once TEMPLATEPATH . '/lib/init.php';

/** Localization */
load_child_theme_textdomain( 'fortytwo', get_stylesheet_directory() . '/lib/languages' );

/** Add FortyTwo Turbos */
require_once 'config/initializers/init.php';

/**
 * Activates FortyTwo theme features.
 */
add_theme_support( 'html5' );
add_theme_support( 'genesis-responsive-viewport' );

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

// Add support for footer widgets
add_theme_support( 'genesis-footer-widgets' );

// Registering the sidebar for our footer columns
genesis_register_sidebar(
	array(
		'id'               => 'footer-columns',
		'name'             => __( 'Footer Columns', 'fortytwo' ),
		'description'      => __( 'This is the section inserted prior to the final footer', 'fortytwo' ),
	)
);

/** Customize the default footer */
remove_action( 'genesis_footer', 'genesis_do_footer' );

add_action( 'genesis_footer', 'fortytwo_custom_footer' );

function fortytwo_custom_footer() {

	$footer_output = <<<EOD
		<div class="copyright-area">
			<span>&copy; Copyright 2012 <a href="http://mydomain.com/">My Domain</a> &middot; All Rights Reserved &middot; Powered by <a href="http://wordpress.org/">WordPress</a> &middot; <a href="http://mydomain.com/wp-admin">Admin</a></span>
		</div>
EOD;

	echo $footer_output;

}
