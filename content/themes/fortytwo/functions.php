<?php
/** Start the engine */
require_once( TEMPLATEPATH . '/lib/init.php' );

/** Add FortyTwo Turbos */
require_once( CHILD_DIR . '/config/initializers/init.php' );

/**
 * Activates FortyTwo theme features.
 */
add_theme_support( 'genesis-html5' );
add_theme_support( 'genesis-responsive-viewport' );


add_filter( 'stylesheet_uri', 'fortywo_replace_default_style_sheet', 10, 2 );
/**
 * Replace default style sheet
 * @return constant Base FortyTwo CSS
 */
function fortywo_replace_default_style_sheet() {
    return CHILD_URL . '/assets/stylesheets/fortytwo.css';
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

// Add support for 4-column footer widgets TODO we could do the same add support for fortytwo-content-widgets
add_theme_support( 'genesis-footer-widgets', 4 );


// Register widget areas
genesis_register_sidebar(array(
    'id' => 'home-slider',
    'name' => __('Home Slider', 'fortytwo'),
    'description' => __('This is the slider section of the homepage.', 'fortytwo'),
));
genesis_register_sidebar(array(
    'id' => 'home-notice',
    'name' => __('Home Notice', 'fortytwo'),
    'description' => __('This is the notice section of the homepage.', 'fortytwo'),
));
genesis_register_sidebar(array(
    'id' => 'home-row-1-col-1',
    'name' => __('Home Row 1 Column 1', 'fortytwo'),
    'description' => __('This is Column 1 of Row 1 on the homepage.', 'fortytwo'),
));
genesis_register_sidebar(array(
    'id' => 'home-row-1-col-2',
    'name' => __('Home Row 1 Column 2', 'fortytwo'),
    'description' => __('This is Column 2 of Row 1 on the homepage.', 'fortytwo'),
));
genesis_register_sidebar(array(
    'id' => 'home-row-1-col-3',
    'name' => __('Home Row 1 Column 3', 'fortytwo'),
    'description' => __('This is Column 3 of Row 1 on the homepage.', 'fortytwo'),
));
genesis_register_sidebar(array(
    'id' => 'home-row-1-col-4',
    'name' => __('Home Row 1 Column 4', 'fortytwo'),
    'description' => __('This is Column 4 of Row 1 on the homepage.', 'fortytwo'),
));
genesis_register_sidebar(array(
    'id' => 'home-row-2-col-1',
    'name' => __('Home Row 2 Column 1', 'fortytwo'),
    'description' => __('This is Column 1 of Row 1 on the homepage.', 'fortytwo'),
));
genesis_register_sidebar(array(
    'id' => 'home-row-2-col-2',
    'name' => __('Home Row 2 Column 2', 'fortytwo'),
    'description' => __('This is Column 2 of Row 2 on the homepage.', 'fortytwo'),
));


// FortyTwo footer widget areas
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

add_action( 'genesis_before_footer', 'fortytwo_footer_widgets_layout', 5 );

function fortytwo_footer_widgets_layout() {

    $footer_widgets = get_theme_support( 'genesis-footer-widgets' );

    if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
        return;

    $footer_widgets = (int) $footer_widgets[0];

    /**
     * Check to see if first widget area has widgets. If not,
     * do nothing. No need to check all footer widget areas.
     */
    if ( ! is_active_sidebar( 'footer-1' ) )
        return;

    $output  = '';
    $counter = 1;

    while ( $counter <= $footer_widgets ) {
        /** Darn you, WordPress! Gotta output buffer. */
        ob_start();
        dynamic_sidebar( 'footer-' . $counter );
        $widgets = ob_get_clean();

        $output .= sprintf( '<div class="footer-widgets-%d col col-lg-3">%s</div>', $counter, $widgets );

        $counter++;
    }

    echo sprintf( '<div id="footer-widgets"><div class="container"><div class="row">%1$s</div></div></div>', $output );

}

/** Customize the default footer */
remove_action( 'genesis_footer', 'genesis_do_footer' );

add_action( 'genesis_footer', 'fortytwo_custom_footer' );

function fortytwo_custom_footer() {

    $footer_output = <<<EOD
        <div class="row">
            <div class="col col-lg-12">
                <span>&copy; Copyright 2012 <a href="http://mydomain.com/">My Domain</a> &middot; All Rights Reserved &middot; Powered by <a href="http://wordpress.org/">WordPress</a> &middot; <a href="http://mydomain.com/wp-admin">Admin</a></span>
            </div>
        </div>
EOD;

    echo($footer_output);

}


/**
 * TODO below snippets to be moved out of functions.php at a later stage
 */
remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );