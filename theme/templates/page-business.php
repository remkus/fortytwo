<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

// Template Name: Business

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

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
/** Removing the div.content-sidebar-wrap on our Business Page Template */
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

/** Removing the main.content on our Business Page Template */
add_filter( 'genesis_markup_content', '__return_null' );

add_action( 'genesis_after_header', 'fortytwo_add_site_intro' );
/**
 * This adds the page-business-section to the business page template if the widget area has widgets
 *
 * @since 1.0
 * @todo  This code needs better documentation
 *
 */
function fortytwo_add_site_intro() {

	if ( is_active_sidebar( 'ft_page-business-section' ) ) {

		$data_widget_count = fortytwo_count_widgets( 'ft_page-business-section' );

		echo '	<div class="site-intro">
					<div class="wrap">
						<div class="inner-wrap">
							<div class="widget-area custom-widget-area" data-widget-count="' . esc_attr( $data_widget_count ) . '">';

								dynamic_sidebar( 'ft_page-business-section' );

		echo '				</div>
						</div>
					</div>
				</div>';
	}

}

add_action( 'genesis_loop', 'fortytwo_page_business_sections_in_loop' );
/**
 * We are hooking in to the Genesis loop in order to output the additional business sections for our template
 *
 * @since 1.0
 * @todo  This code needs better documentation
 *
 */
function fortytwo_page_business_sections_in_loop() {

	echo '<div class="inner-wrap">';

	if ( is_active_sidebar( 'ft_page-business-section-2' ) ) {

		$data_widget_count = fortytwo_count_widgets( 'ft_page-business-section-2' );

		echo '<div class="widget-area custom-widget-area" data-widget-count="' . esc_attr( $data_widget_count ) . '">';
				dynamic_sidebar( 'ft_page-business-section-2' );
		echo '</div>';

	}

	if ( is_active_sidebar( 'ft_page-business-section-3' ) ) {

		$data_widget_count = fortytwo_count_widgets( 'ft_page-business-section-3' );

		echo '<div class="widget-area custom-widget-area" data-widget-count="' . esc_attr( $data_widget_count ) . '">';
				dynamic_sidebar( 'ft_page-business-section-3' );
		echo '</div>';

	}

	if ( is_active_sidebar( 'ft_page-business-section-4' ) ) {

		$data_widget_count = fortytwo_count_widgets( 'ft_page-business-section-4' );

		echo '<div class="widget-area custom-widget-area" data-widget-count="' . esc_attr( $data_widget_count ) . '">';
				dynamic_sidebar( 'ft_page-business-section-4' );
		echo '</div>';

	}

	echo '</div>';
}

genesis();