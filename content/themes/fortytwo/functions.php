<?php
/**
 * Functions file
 */

add_theme_support( 'genesis-html5' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'ft_viewport_meta_tag' );
function ft_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

// Replace default style sheet
add_filter( 'stylesheet_uri', 'custom_replace_default_style_sheet', 10, 2 );
function custom_replace_default_style_sheet() {
    return CHILD_URL . '/theme/assets/stylesheets/fortytwo.css';
}

// Load custom style sheet
add_action( 'wp_enqueue_scripts', 'custom_load_custom_style_sheet' );
function custom_load_custom_style_sheet() {
    wp_enqueue_style( 'custom-stylesheet', CHILD_URL . '/style.css', array(), PARENT_THEME_VERSION );
}

// Load Open Sans
add_action( 'wp_enqueue_scripts', 'ft_load_google_fonts' );
function ft_load_google_fonts() {
	wp_enqueue_style( 'google-font-open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,600,300', array(), PARENT_THEME_VERSION );
    wp_enqueue_style( 'google-font-droid-serif', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic', array(), PARENT_THEME_VERSION );
}