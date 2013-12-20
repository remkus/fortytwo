<?php
/**
 * FortyTwo: Register widget areas for the theme
 *
 * @since 1.0.0
 * @todo  Want the ability to read in from json settings files to determine what sidebars we need to register
 */

add_action( 'after_setup_theme', 'fortytwo_register_widget_areas' );
/**
 * Regsiter the widget areas for FortyTwo, uses a single row section approach
 *
 * @since 1.0
 * @todo  This code needs better documentation
 *
 */
function fortytwo_register_widget_areas() {
	$page_business_widget_areas = array(
		'name'          => __( 'Business > Section %d', 'fortytwo' ),
		'id'            => 'page-business-section',
		'description'   => __( 'Widgets  areas for sections of the Business Page Template', 'fortytwo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h4 class="widget-title widgettitle">',
		'after_title'   => '</h4>'
	);
	register_sidebars( 4, $page_business_widget_areas );
}


// Registering the sidebar for our footer columns
genesis_register_sidebar(
	array(
		'id'               => 'footer-columns',
		'name'             => __( 'Footer Columns', 'fortytwo' ),
		'description'      => __( 'This is the section inserted prior to the final footer', 'fortytwo' ),
	)
);
