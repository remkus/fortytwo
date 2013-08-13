<?php
/**
 * Template Name: Business
 * The file handles the default business layout of FortyTwo.
 *
 * @category FortyTwo
 * @package  Templates
 * @author   Forsite Themes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.forsitethemes.com/
 */


remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'fortytwo_home_loop_helper' );

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

add_action( 'genesis_after_header', 'fortytwo_add_page_business_sections' );
/**
 * This adds the .page-home-section-1 section to the business page template if the widget area has widgets
 *
 * @since 1.0
 */

function fortytwo_add_page_business_sections() {

	if ( is_active_sidebar( 'page-business-section' ) ) {
		echo '<div class="site-section">';

			genesis_structural_wrap( 'site-section', 'open' );
				dynamic_sidebar( 'page-business-section' );
			genesis_structural_wrap( 'site-section', 'close' );

		echo '</div>';
	}

	if ( is_active_sidebar( 'page-business-section-2' ) ) {
		echo '<div class="site-section-2">';

			genesis_structural_wrap( 'site-section', 'open' );
				dynamic_sidebar( 'page-business-section-2' );
			genesis_structural_wrap( 'site-section', 'close' );

		echo '</div>';
	}

}

function fortytwo_home_loop_helper() {

    echo '<div class="container">';

    if ( is_active_sidebar( 'home-row-1-col-1' ) || is_active_sidebar( 'home-row-1-col-2' ) || is_active_sidebar( 'home-row-1-col-3' ) || is_active_sidebar( 'home-row-1-col-4' ) ) {

        echo '<div class="row">';

            echo '<div class="col col-lg-3">';
            dynamic_sidebar( 'home-row-1-col-1' );
            echo '</div><!-- end .home-row-1-col-1 -->';

            echo '<div class="col col-lg-3">';
            dynamic_sidebar( 'home-row-1-col-2' );
            echo '</div><!-- end .home-row-1-col-2 -->';

            echo '<div class="col col-lg-3">';
            dynamic_sidebar( 'home-row-1-col-3' );
            echo '</div><!-- end .home-row-1-col-3 -->';

            echo '<div class="col col-lg-3">';
            dynamic_sidebar( 'home-row-1-col-4' );
            echo '</div><!-- end .home-row-1-col-4 -->';

        echo '</div>';

    }

    if ( is_active_sidebar( 'home-row-2-col-1' ) || is_active_sidebar( 'home-row-2-col-2' ) ) {

        echo '<div class="row">';

            echo '<div class="col col-lg-7">';
            dynamic_sidebar( 'home-row-2-col-1' );
            echo '</div><!-- end .home-row-2-col-1 -->';

            echo '<div class="col col-lg-5">';
            dynamic_sidebar( 'home-row-2-col-2' );
            echo '</div><!-- end .home-row-2-col-2 -->';

        echo '</div>';

    }

    echo '</div>';

}

genesis();