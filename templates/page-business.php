<?php
/**
 * Template Name: Business
 * The file handles the default business layout of FortyTwo.
 *
 * @category FortyTwo
 * @package  Templates
 * @author   Forsite Themes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.forsitethemes.com/
 */


remove_action( 'genesis_loop', 'genesis_do_loop' );
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', 'fortytwo_add_body_classes' );
/**
 * Add body classes to identify that this is fortytwo and it is the business page template
 *
 * @since 1.0
 *
 * @param string $classes Existing body classes.
 *
 * @return string Body classes.
 */
function fortytwo_add_body_classes( $classes ) {

	$classes[] = 'fortytwo fortytwo-page-business';

	return $classes;
}

add_action( 'genesis_after_header', 'fortytwo_add_section_after_header' );
/**
 * This adds the page-business-section to the business page template if the widget area has widgets
 *
 * @since 1.0
 */
function fortytwo_add_section_after_header() {

	if ( is_active_sidebar( 'page-business-section' ) ) {
		echo '<div class="site-section">';

		genesis_structural_wrap( 'site-section', 'open' );
		dynamic_sidebar( 'page-business-section' );
		genesis_structural_wrap( 'site-section', 'close' );

		echo '</div>';
	}

}

add_action( 'genesis_loop', 'fortytwo_add_section_in_loop' );
/**
 * This adds the page-business-section 2-4 to the business page template if the widget areas have widgets
 *
 * @since 1.0
 */
function fortytwo_add_section_in_loop() {

//	global $wp_registered_sidebars;
//	global $sidebars_widgets;

	if ( is_active_sidebar( 'page-business-section-2' ) ) {

		fortytwo_add_widget_count_class( 'page-business-section-2' );

		echo '<div class="site-section-2">';
			dynamic_sidebar( 'page-business-section-2' );
		echo '</div>';

	}

	if ( is_active_sidebar( 'page-business-section-3' ) ) {

		fortytwo_add_widget_count_class( 'page-business-section-3' );

		echo '<div class="site-section-3">';
			dynamic_sidebar( 'page-business-section-3' );
		echo '</div>';

	}

	if ( is_active_sidebar( 'page-business-section-4' ) ) {

		fortytwo_add_widget_count_class( 'page-business-section-4' );

		echo '<div class="site-section-4">';
			dynamic_sidebar( 'page-business-section-4' );
		echo '</div>';

	}
}

genesis();