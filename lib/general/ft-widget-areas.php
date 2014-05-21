<?php
/**
 * FortyTwo Theme: Register widget areas for the theme
 *
 * This file modifies the WordPress default widgets to allow for our Bootstrap type
 * styling
 *
 * @package FortyTwo\General
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'after_setup_theme', 'fortytwo_register_widget_areas' );
/**
 * Regsiter the widget areas for FortyTwo, uses a single row section approach
 *
 * @since 1.0
 * @todo  This code needs better documentation
 * @todo  Want the ability to read in from json settings files to determine what sidebars we need to register
 *
 */
function fortytwo_register_widget_areas() {
	$page_business_widget_areas = array(
		'name'          => __( 'Business > Section %d', 'fortytwo' ),
		'id'            => 'ft_page-business-section',
		'description'   => __( 'Widgets  areas for sections of the Business Page Template', 'fortytwo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h4 class="widget-title widgettitle">',
		'after_title'   => '</h4>',
	);
	register_sidebars( 4, $page_business_widget_areas );
}


// Registering the sidebar for our footer columns
genesis_register_sidebar(
	array(
		'id'               => 'ft_footer-columns',
		'name'             => __( 'Footer Columns', 'fortytwo' ),
		'description'      => __( 'This is the section inserted prior to the final footer', 'fortytwo' ),
	)
);
