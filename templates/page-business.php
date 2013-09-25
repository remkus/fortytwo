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
 * @todo  This code needs better documentation
 *
 */


//remove_action( 'genesis_loop', 'genesis_do_loop' );
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', 'fortytwo_add_body_classes' );
/**
 * Add body classes to identify that this is fortytwo and it is the business page template
 *
 * @since 1.0
 * @param string $classes Existing body classes.
 * @return string Body classes.
 * @todo  This code needs better documentation
 *
 */
function fortytwo_add_body_classes( $classes ) {

	$classes[] = 'fortytwo ft-page-business';

	return $classes;
}

add_action( 'genesis_after_header', 'fortytwo_add_section_after_header' );
/**
 * This adds the page-business-section to the business page template if the widget area has widgets
 *
 * @since 1.0
 * @todo  This code needs better documentation
 *
 */
function fortytwo_add_section_after_header() {

	if ( is_active_sidebar( 'page-business-section' ) ) {
		echo '<div class="site-intro">';

			fortytwo_add_widget_count_class( 'page-business-section' );

			genesis_structural_wrap( 'site-intro', 'open' );

				echo '<div class="inner-wrap">';
					dynamic_sidebar( 'page-business-section' );
				echo '</div>';

			genesis_structural_wrap( 'site-intro', 'close' );

		echo '</div>';
	}

}

add_action( 'fortytwo_page_business_content', 'fortytwo_add_section_in_loop' );
/**
 * This adds the page-business-section 2-4 to the business page template if the widget areas have widgets
 *
 * @since 1.0
 * @todo  This code needs better documentation
 *
 */
function fortytwo_add_section_in_loop() {

//	global $wp_registered_sidebars;
//	global $sidebars_widgets;

	if ( is_active_sidebar( 'page-business-section-2' ) ) {

		fortytwo_add_widget_count_class( 'page-business-section-2' );

		echo '<div class="section-container section-2">';
			dynamic_sidebar( 'page-business-section-2' );
		echo '</div>';

	}

	if ( is_active_sidebar( 'page-business-section-3' ) ) {

		fortytwo_add_widget_count_class( 'page-business-section-3' );

		echo '<div class="section-container section-3">';
			dynamic_sidebar( 'page-business-section-3' );
		echo '</div>';

	}

	if ( is_active_sidebar( 'page-business-section-4' ) ) {

		fortytwo_add_widget_count_class( 'page-business-section-4' );

		echo '<div class="section-container section-4">';
			dynamic_sidebar( 'page-business-section-4' );
		echo '</div>';

	}
}

get_header();

do_action( 'fortytwo_page_business_content' );

get_footer();