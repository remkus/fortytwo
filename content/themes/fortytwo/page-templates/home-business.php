<?php
/**
 * Template Name: Home Business
 * The default business layout of FortyTwo.
 *
 * @category FortyTwo
 * @package  Templates
 * @author   Forsite Themes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.forsitethemes.com/
 */

add_action( 'genesis_meta', 'ft_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function ft_home_genesis_meta() {

	if ( is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-notice' ) || is_active_sidebar( 'home-row-1-col-1' ) || is_active_sidebar( 'home-row-1-col-2' ) || is_active_sidebar( 'home-row-1-col-3' ) || is_active_sidebar( 'home-row-1-col-4' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_after_header', 'fortytwo_home_slider_notice' );
		add_action( 'genesis_loop', 'fortytwo_home_loop_helper' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		add_filter( 'body_class', 'add_body_class' );

		function add_body_class( $classes ) {
   			$classes[] = 'fortytwo';
  			return $classes;
		}

	}
}

function fortytwo_home_slider_notice() {


    if ( is_active_sidebar( 'home-slider' ) ) {
        echo '<div id="home-slider">';
        dynamic_sidebar( 'home-slider' );
        echo '</div><!-- end #home-slider -->';
    }

    if ( is_active_sidebar( 'home-notice' ) ) {
        echo '<div id="home-notice">';
        dynamic_sidebar( 'home-notice' );
        echo '</div><!-- end #home-notice -->';
    }

}

function fortytwo_home_loop_helper() {

	if ( is_active_sidebar( 'home-row-1-col-1' ) || is_active_sidebar( 'home-row-1-col-2' ) || is_active_sidebar( 'home-row-1-col-3' ) || is_active_sidebar( 'home-row-1-col-4' ) ) {

		echo '<div class="container"><div class="row">';

			echo '<div class="span3">';
			dynamic_sidebar( 'home-row-1-col-1' );
			echo '</div><!-- end .home-row-1-col-1 -->';

			echo '<div class="span3">';
			dynamic_sidebar( 'home-row-1-col-2' );
			echo '</div><!-- end .home-row-1-col-2 -->';

			echo '<div class="span3">';
			dynamic_sidebar( 'home-row-1-col-3' );
			echo '</div><!-- end .home-row-1-col-3 -->';

            echo '<div class="span3">';
            dynamic_sidebar( 'home-row-1-col-4' );
            echo '</div><!-- end .home-row-1-col-4 -->';

		echo '</div></div>';

	}

}

genesis();