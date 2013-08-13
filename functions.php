<?php
/** Start the engine */
require_once( TEMPLATEPATH . '/lib/init.php' );

/** Add FortyTwo Turbos */
require_once( CHILD_DIR . '/config/initializers/init.php' );

/**
 * Activates FortyTwo theme features.
 */
add_theme_support( 'html5' );
add_theme_support( 'genesis-responsive-viewport' );

// Add support for post format images
//add_theme_support( 'genesis-post-format-images' );

// Add support for post formats
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) ); //TODO add post format support using font icons


add_filter( 'stylesheet_uri', 'fortywo_replace_default_style_sheet', 10, 2 );
/**
 * Replace default style sheet
 * @return constant Base FortyTwo CSS
 */
function fortywo_replace_default_style_sheet() {
    return CHILD_URL . '/assets/css/fortytwo.css';
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

// Add support for footer widgets
add_theme_support( 'genesis-footer-widgets' );


// Register widget areas
genesis_register_sidebar(
	array(
		'id'          => 'home-row-1-col-1',
		'name'        => __( 'Home Row 1 Column 1', 'fortytwo' ),
		'description' => __( 'This is Column 1 of Row 1 on the homepage.', 'fortytwo' ),
	)
);

genesis_register_sidebar(
	array(
		'id'          => 'home-row-1-col-2',
		'name'        => __( 'Home Row 1 Column 2', 'fortytwo' ),
		'description' => __( 'This is Column 2 of Row 1 on the homepage.', 'fortytwo' ),
	)
);

genesis_register_sidebar(
	array(
		'id'          => 'home-row-1-col-3',
		'name'        => __( 'Home Row 1 Column 3', 'fortytwo' ),
		'description' => __( 'This is Column 3 of Row 1 on the homepage.', 'fortytwo' ),
	)
);

genesis_register_sidebar(
	array(
		'id'          => 'home-row-1-col-4',
		'name'        => __( 'Home Row 1 Column 4', 'fortytwo' ),
		'description' => __( 'This is Column 4 of Row 1 on the homepage.', 'fortytwo' ),
	)
);

genesis_register_sidebar(
	array(
		'id'          => 'home-row-2-col-1',
		'name'        => __( 'Home Row 2 Column 1', 'fortytwo' ),
		'description' => __( 'This is Column 1 of Row 1 on the homepage.', 'fortytwo' ),
	)
);

genesis_register_sidebar(
	array(
		'id'          => 'home-row-2-col-2',
		'name'        => __( 'Home Row 2 Column 2', 'fortytwo' ),
		'description' => __( 'This is Column 2 of Row 2 on the homepage.', 'fortytwo' ),
	)
);

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
		<aside class="widget-area footer-widget-area">
			<span>Links to come here...</span>
		</aside>
EOD;

    echo($footer_output);

}