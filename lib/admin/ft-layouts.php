<?php

add_action( 'after_setup_theme', 'fortytwo_register_additional_layouts' );
/**
 * Add additional layouts for use with FortyTwo
 *
 * @since 1.0
 *
 */
function fortytwo_register_additional_layouts() {

	genesis_register_layout( 'primary-content-secondary', array(
		'label' => __('Primary-Content-Secondary', 'fortytwo'),
		'img' => CHILD_URL . '/assets/images/layouts/pcs.png',
	) );

	genesis_register_layout( 'primary-secondary-content', array(
		'label' => __('Primary-Secondary-Content', 'fortytwo'),
		'img' => CHILD_URL . '/assets/images/layouts/psc.png',
	) );

	genesis_register_layout( 'content-secondary-primary', array(
		'label' => __('Content-Secondary-Primary', 'fortytwo'),
		'img' => CHILD_URL . '/assets/images/layouts/csp.png',
	) );

}