<?php

add_action( 'genesis_meta', 'metro_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function metro_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle-left' ) || is_active_sidebar( 'home-middle-right' ) || is_active_sidebar( 'home-bottom' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

		// Add metro-home body class
		add_filter( 'body_class', 'metro_body_class' );
		function metro_body_class( $classes ) {
   			$classes[] = 'metro-home';
  			return $classes;
		}

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets
		add_action( 'genesis_loop', 'metro_homepage_widgets' );

	}
}

function metro_homepage_widgets() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
	) );
	
	if ( is_active_sidebar( 'home-middle-left' ) || is_active_sidebar( 'home-middle-right' ) ) {

		echo '<div class="home-middle">';

		genesis_widget_area( 'home-middle-left', array(
			'before' => '<div class="home-middle-left widget-area">',
		) );

		genesis_widget_area( 'home-middle-right', array(
			'before' => '<div class="home-middle-right widget-area">',
		) );

		echo '</div>';
	
	}

	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area">',
	) );

}

genesis();