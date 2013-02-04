<?php
// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

load_child_theme_textdomain( 'metro', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'metro' ) );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Metro Theme', 'metro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/metro/' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'metro_viewport_meta_tag' );
function metro_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

// Load Oswald Google font
add_action( 'wp_enqueue_scripts', 'metro_load_google_font' );
function metro_load_google_font() {
	wp_enqueue_style( 'google-font', 'http://fonts.googleapis.com/css?family=Oswald:400', array(), PARENT_THEME_VERSION );
}

// Add new image sizes
add_image_size( 'home-bottom', 150, 150, TRUE );
add_image_size( 'home-middle', 336, 190, TRUE );
add_image_size( 'home-top', 708, 400, TRUE );

// Add support for custom background
add_theme_support( 'custom-background', array( 'wp-head-callback' => '__return_false' ) );

// Add support for custom header
add_theme_support( 'genesis-custom-header', array(
	'flex-height'	=> true,
	'height'		=> 87,
	'width'			=> 1080
) );

// Create additional color style options
add_theme_support( 'genesis-style-selector', array(
	'metro-blue'	=>	__( 'Blue', 'metro' ),
	'metro-green'	=>	__( 'Green', 'metro' ),
	'metro-orange'	=>	__( 'Orange', 'metro' ),
	'metro-pink'	=>	__( 'Pink', 'metro' ),
	'metro-red'		=>	__( 'Red', 'metro' ),
) );

// Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Reposition the secondary navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav' );

// Adds widget area before the .menu on #subnav
add_filter( 'genesis_do_subnav', 'child_do_subnav_widget', 10, 2 );
function child_do_subnav_widget( $subnav_output, $subnav ){
	ob_start();
	genesis_widget_area( 'subnav-left', array(
		'before' => '<div class="subnav-left widget-area">',
	) );
	$widget_area = ob_get_clean();

	return str_replace( $subnav, $widget_area . $subnav, $subnav_output );
}

// Hooks after-post widget area to single posts
add_action( 'genesis_after_post_content', 'metro_after_post'  ); 
function metro_after_post() {
	if ( is_single() && is_active_sidebar( 'after-post' ) ) {
		echo '<div class="after-post"><div class="wrap">';
		dynamic_sidebar( 'after-post' );
		echo '</div></div>';
	}
}

// Modify comments header text in comments
add_filter( 'genesis_title_comments', 'metro_title_comments' );
function metro_title_comments() {
	$title = '<h3><span class="comments-title">' . __( 'Comments', 'metro' ) . '</span></h3>';
	return $title;
}

// Modify the speak your mind text
add_filter( 'genesis_comment_form_args', 'metro_comment_form_args' );
function metro_comment_form_args($args) {
	$args['title_reply'] = '<span class="comments-title">' . __( 'Speak Your Mind', 'metro' ) . '</span>';
	return $args;
}

// Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Reposition the footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_after', 'genesis_footer_widget_areas' );

// Reposition the footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
add_action( 'genesis_after', 'genesis_do_footer', 12 );
add_action( 'genesis_after', 'genesis_footer_markup_close', 13 );

// Add span class to widget headlines
add_filter( 'widget_title', 'metro_widget_title' );
function metro_widget_title( $title ){
	if( $title )
		return sprintf('<span class="widget-headline">%s</span>', $title );
}

// Load Backstretch script and prepare images for loading
add_action( 'wp_enqueue_scripts', 'metro_enqueue_scripts' );
function metro_enqueue_scripts() {

	// Load scripts only if custom background is being used
	if ( ! get_background_image() )
		return;

	wp_enqueue_script( 'metro-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'metro-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'metro-backstretch' ), '1.0.0' );

	wp_localize_script( 'metro-backstretch-set', 'BackStretchImg', array( 'src' => get_background_image() ) );

}

// Register widget areas
genesis_register_sidebar( array(
	'id'				=> 'subnav-left',
	'name'			=> __( 'Subnav - Left', 'metro' ),
	'description'	=> __( 'This is the left side of the subnav section.', 'metro' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-top',
	'name'			=> __( 'Home - Top', 'metro' ),
	'description'	=> __( 'This is the top section of the homepage.', 'metro' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-middle-left',
	'name'			=> __( 'Home - Middle Left', 'metro' ),
	'description'	=> __( 'This is the middle left section of the homepage.', 'metro' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-middle-right',
	'name'			=> __( 'Home - Middle Right', 'metro' ),
	'description'	=> __( 'This is the middle right section of the homepage.', 'metro' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'home-bottom',
	'name'			=> __( 'Home - Bottom', 'metro' ),
	'description'	=> __( 'This is the bottom section of the homepage.', 'metro' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'after-post',
	'name'			=> __( 'After Post', 'metro' ),
	'description'	=> __( 'This is the after post section.', 'metro' ),
) );