<?php
/**
 * FortyTwo Footer Widget Areas
 *
 * @package FortyTwo
 */

add_action( 'genesis_before_footer', 'fortytwo_insert_footer_widget' );
/**
 * Echo the markup necessary to facilitate the footer widget area.
 *
 * We are creating one widget area and columns are determined by no. widgets
 *
 */
function fortytwo_insert_footer_widget() {

	$footer_widgets = get_theme_support( 'genesis-footer-widgets' );

	if ( ! $footer_widgets )
		return;

	//* Check to see if footer-columns has widgets.
	if ( ! is_active_sidebar( 'footer-columns' ) )
		return;

	fortytwo_add_widget_count_class( 'footer-columns' );

	genesis_markup( array(
		'html5'   => '<div %s>',
		'xhtml'   => '<div id="footer-widgets" class="footer-widgets">',
		'context' => 'footer-widgets'
	) );

	genesis_structural_wrap( 'footer-widgets', 'open' );

	dynamic_sidebar( 'footer-columns' );

	genesis_structural_wrap( 'footer-widgets', 'close' );

	echo '</div>';

}