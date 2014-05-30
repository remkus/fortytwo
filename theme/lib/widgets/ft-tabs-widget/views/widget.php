<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

$html = '';

if ( count( $instance['tabs'] ) > 0 ) {
	$tab_content = '';
	$tab_links = '';

	// Setup the various tabs.
	$tab_links .= '<div class="tab-buttons"><ul>' . "\n";
	$count = 0;
	foreach ( $instance['tabs'] as $tab ) {
		$count++;
		$class = '';

		if ( $count == 1 ) {
			$class = ' first active';
		}
		if ( $count == count( $instance['tabs'] ) ) {
			$class = ' last';
		}

		$tab_id = uniqid( $tab . '-' );

		$tab_links .= '<li class="' . sanitize_html_class( $class ) . '"><button type="button" class="btn tab-heading-' . sanitize_html_class( $tab ) . '" data-target="#tab-pane-' . esc_attr( $tab_id ) . '" data-toggle="tab">' . $tab . '</button></li>' . "\n";

		$tab_content .= '<div id="tab-pane-' . esc_attr( $tab_id ) . '" class="tab-pane tab-pane-' . esc_attr( $tab ) . $class . '">' . "\n";

		$tab_args = array( 'limit' => intval( $instance['limit'] ), 'image_size' => intval( $instance['image_size'] ), 'image_alignment' => strval( $instance['image_alignment'] ) );

		if ( method_exists( $this, 'tab_content_' . esc_attr( $tab ) ) ) {
			$tab_content .= call_user_func_array( array( $this, 'tab_content_' . esc_attr( $tab ) ), $tab_args );
		} else {
			$tab_content .= $this->tab_content_default( $tab );
		}

		$tab_content .= '</ul></div>' . "\n";
	}
	$tab_links .= '</div>' . "\n";

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $instance['title'] ) {
		$html .= '<div class="tab-select">' . $args['before_title'] . $instance['title'] . $args['after_title'] . $tab_links . '</div>';
	} else {
		$html .= '<div class="tab-select">' . $tab_links . '</div>';
	}

	$html .= '<div class="tab-content image-align-' . $instance['image_alignment'] . '">' . "\n" . $tab_content . '</div>' . "\n";

}

echo $html;
