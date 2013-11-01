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
 * @todo  This code needs better documentation
 */
function fortytwo_insert_footer_widget() {

	//* Check to see if footer-columns has widgets.
	if ( ! is_active_sidebar( 'footer-columns' ) )
		return;

	$data_widget_count = fortytwo_add_data_widget_attr( 'footer-columns' );

	genesis_markup( array(
		'html5'   => '<div %s>',
		'xhtml'   => '<div id="footer-widgets">',
		'context' => 'footer-widgets'
	) );

	genesis_structural_wrap( 'footer-widgets', 'open' );

	echo '<div class="inner-wrap">';

	echo '<div class="widget-container" data-widget-count="' .$data_widget_count. '">';

	dynamic_sidebar( 'footer-columns' );

	echo '</div>';

	echo '</div>';

	genesis_structural_wrap( 'footer-widgets', 'close' );

	echo '</div>';

}


/** Customize the default footer */
remove_action( 'genesis_footer', 'genesis_do_footer' );

add_action( 'genesis_footer', 'fortytwo_custom_footer' );

function fortytwo_custom_footer() {

	$footer_output = <<<EOD
		<div class="copyright-area">
			<span>&copy; Copyright 2012 <a href="http://mydomain.com/">My Domain</a> &middot; All Rights Reserved &middot; Powered by <a href="http://wordpress.org/">WordPress</a> &middot; <a href="http://mydomain.com/wp-admin">Admin</a></span>
		</div>
EOD;

	echo $footer_output;

}
