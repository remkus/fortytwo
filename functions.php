<?php
/**
 * Start the engine
 */
require_once TEMPLATEPATH . '/lib/init.php';

/**
 * Localization
 */
load_child_theme_textdomain( 'fortytwo', CHILD_DIR . '/lib/languages' );

/**
/** Add theme support for HTML5 with Semantic Markup */
 */
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

/** Adds responsive viewport */
add_theme_support( 'genesis-responsive-viewport' );

add_action( 'wp_enqueue_scripts', 'fortytwo_load_google_fonts' );
/**
 * Loading Google Fonts
 * @return [type] [description]
 * @todo  This code needs better documentation
 *
 */
function fortytwo_load_google_fonts() {
    wp_enqueue_style( 'google-font-open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,600,300', array(), PARENT_THEME_VERSION );
    wp_enqueue_style( 'google-font-droid-serif', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic', array(), PARENT_THEME_VERSION );
    wp_enqueue_style( 'google-font-source-sans-pro', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), PARENT_THEME_VERSION );
}

/**
 * Add support for footer widgets
 */
require_once 'config/initializers/init.php';
