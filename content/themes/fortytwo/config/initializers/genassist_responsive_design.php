<?php
/*
 * FortyTwo Responsive Design Support
 */

add_action( 'genesis_meta', 'fortytwo_viewport_meta' );
/**
 * Add Viewport meta tag for mobile browsers
 *
 * @access public
 * @return void
 */
function fortytwo_viewport_meta() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
	echo '<meta name="HandheldFriendly" content="True">';
	echo '<meta name="MobileOptimized" content="320">';
}