<?php
/** Start the engine */
require_once TEMPLATEPATH . '/lib/init.php';

/** Localization */
load_child_theme_textdomain( 'fortytwo', get_stylesheet_directory() . '/lib/languages' );

/** Activates html5 support */
add_theme_support( 'html5' );

/** Adds responsive viewport */
add_theme_support( 'genesis-responsive-viewport' );

/** Add FortyTwo Turbos */
require_once 'config/initializers/init.php';
