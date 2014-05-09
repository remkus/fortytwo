<?php
/**
 * FortyTwo Theme: Footer Widget Areas
 *
 * This file modifies the WordPress default widgets to allow for our Bootstrap type
 * styling
 *
 * @package FortyTwo\Structural
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'genesis_before_footer', 'fortytwo_insert_footer_widget' );
/**
 * Echo the markup necessary to facilitate the footer widget area.
 *
 * We are creating one widget area and columns are determined by no. widgets
 *
 * @todo  This code needs better documentation
 */
function fortytwo_insert_footer_widget() {

	//* Check to see if footer-columns has widgets.
	if ( ! is_active_sidebar( 'footer-columns' ) ) {
		return;
	}

	$data_widget_count = fortytwo_add_data_widget_attr( 'footer-columns' );

	genesis_markup( array(
			'html5'   => '<div %s>',
			'xhtml'   => '<div id="footer-widgets">',
			'context' => 'footer-widgets',
		) );

	genesis_structural_wrap( 'footer-widgets', 'open' );

	echo '<div class="inner-wrap">';
		echo '<div class="sidebar sidebar-footer-columns widget-area custom-widget-area" data-widget-count="' . $data_widget_count . '">';
				dynamic_sidebar( 'footer-columns' );
		echo '</div>';
	echo '</div>';
	genesis_structural_wrap( 'footer-widgets', 'close' );
	echo '</div>';

}

add_filter( 'genesis_footer_creds_text', 'fortytwo_footer_creds_text' );
/**
 * Custom FortyTwo Footer Text
 *
 * @since 1.0.0
 *
 */
function fortytwo_footer_creds_text() {
	echo '<div class="copyright-area">';
	echo do_shortcode( '[footer_copyright before="Copyright "] ' );
	echo do_shortcode( '[footer_childtheme_link before=" &middot; "]' );
	echo ' &middot; ';
	echo ' Built on the ';
	echo do_shortcode( '[footer_genesis_link]' );
	echo '</span></div>';
}
