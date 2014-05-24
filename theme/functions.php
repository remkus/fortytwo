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
 * Add theme support for HTML5 with Semantic Markup
 */
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

/** Adds responsive viewport */
add_theme_support( 'genesis-responsive-viewport' );

/**
 * Add support for footer widgets
 */
require_once 'lib/init.php';