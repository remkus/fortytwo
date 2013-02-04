<?php

add_action( 'genesis_meta', 'agency_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function agency_home_genesis_meta() {

	if ( is_active_sidebar( 'home-welcome' ) || is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-left' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-right' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_after_header', 'agency_home_welcome_helper' );
		add_action( 'genesis_loop', 'agency_home_loop_helper' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		add_filter( 'body_class', 'add_body_class' );

		function add_body_class( $classes ) {
   			$classes[] = 'agency';
  			return $classes;
		}

	}
}

function agency_home_welcome_helper() {

	if ( is_active_sidebar( 'home-welcome' ) ) {
		echo '<div id="home-welcome">';
		dynamic_sidebar( 'home-welcome' );
		echo '</div><!-- end #home-welcome -->';
	}

	if ( is_active_sidebar( 'home-slider' ) ) {
		echo '<div id="home-slider">';
		dynamic_sidebar( 'home-slider' );
		echo '</div><!-- end #home-slider -->';
	}

}

function agency_home_loop_helper() {

	if ( is_active_sidebar( 'home-left' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-right' ) ) {

		echo '<div id="home">';

			echo '<div class="home-left">';
			dynamic_sidebar( 'home-left' );
			echo '</div><!-- end .home-left -->';

			echo '<div class="home-middle">';
			dynamic_sidebar( 'home-middle' );
			echo '</div><!-- end .home-middle -->';

			echo '<div class="home-right">';
			dynamic_sidebar( 'home-right' );
			echo '</div><!-- end .home-right -->';

		echo '</div><!-- end #home -->';

	}

}

genesis();