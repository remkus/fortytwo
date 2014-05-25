<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

/**
 * Localization
 */
load_child_theme_textdomain( 'fortytwo', get_stylesheet_directory() . '/lib/languages' );

/**
 * Add theme support for HTML5 with Semantic Markup
 */
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

/** Adds responsive viewport */
add_theme_support( 'genesis-responsive-viewport' );

/**
 * Include the rest of the theme files
 */
require_once 'lib/init.php';