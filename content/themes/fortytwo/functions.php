<?php
/**
 * Functions file
 */

add_theme_support( 'genesis-html5' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'custom_viewport_meta_tag' );
function custom_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

// Replace default style sheet
add_filter( 'stylesheet_uri', 'custom_replace_default_style_sheet', 10, 2 );
function custom_replace_default_style_sheet() {
    return CHILD_URL . '/vendor/frameworks/bootstrap-forty-two/css/bootstrap.css';
}

// Load custom style sheet
add_action( 'wp_enqueue_scripts', 'custom_load_custom_style_sheet' );
function custom_load_custom_style_sheet() {
    wp_enqueue_style( 'custom-stylesheet', CHILD_URL . '/style.css', array(), PARENT_THEME_VERSION );
}