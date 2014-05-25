<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'after_setup_theme', 'fortytwo_register_genesis_layouts' );
/**
 * Add additional layouts for Genesis.
 *
 * @since @@release
 */
function fortytwo_register_genesis_layouts() {
	genesis_register_layout(
		'primary-content-secondary',
		array(
			'label' => __( 'Primary-Content-Secondary', 'fortytwo', 'fortytwo-dev' ),
			'img'   => FORTYTWO_URL . '/lib/admin/images/layouts/pcs.png',
		)
	);

	genesis_register_layout(
		'primary-secondary-content',
		array(
			'label' => __( 'Primary-Secondary-Content', 'fortytwo', 'fortytwo-dev' ),
			'img'   => FORTYTWO_URL . '/lib/admin/images/layouts/psc.png',
		)
	);

	genesis_register_layout(
		'content-secondary-primary',
		array(
			'label' => __( 'Content-Secondary-Primary', 'fortytwo', 'fortytwo-dev' ),
			'img'   => FORTYTWO_URL . '/lib/admin/images/layouts/csp.png',
		)
	);
}
