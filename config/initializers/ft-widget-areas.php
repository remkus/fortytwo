<?php
/*
 * FotyTwo: Register widget areas for the theme
 *
 * @since 1.0.0
 *
 * TODO: Want the ability to read in from json settings files to determine what sidebars we need to register
 */

add_action( 'after_setup_theme', 'fortytwo_register_widget_areas' );
/**
 * Regsiter the widget areas for FortyTwo, uses a single row section approach
 *
 * @since 1.0
 */
function fortytwo_register_widget_areas() {
	$page_business_widget_areas = array(
		'name'          => __( 'Page > Business > Section %d', 'fortytwo' ),
		'id'            => "page-business-section",
		'description'   => __( 'Widgets  areas for sections of the Business Page Template' ),
		'class'         => 'sometestclass',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title widgettitle">',
		'after_title'   => '</h4>'
	);
	register_sidebars( 4, $page_business_widget_areas );
}