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

/**
 * Function calculates the number of widgets in a sidebar and then calculates
 * the number of columns each widget requires based on no. of widgets.
 *
 * We then alter the specific sidebar's before_widget value
 *
 */
function fortytwo_add_widget_count_class( $id ) {

	//TODO: Want to add data attribute for widget order in sidebar data-widget-order='first'... 'second' etc
	global $wp_registered_sidebars;
	global $sidebars_widgets;

	$widget_count_class = ' col-' . ( 12 / ( count ( $sidebars_widgets[$id] ) ) );

	$wp_registered_sidebars[$id]['before_widget'] = '<section id="%1$s" class="widget %2$s' . $widget_count_class . '"><div class="widget-wrap">';

}