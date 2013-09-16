<?php
/**
 *  @todo  This code needs better documentation
 *
 */

$html = '';

if ( count( $tabs ) > 0 ) {
	$tab_content = '';
	$tab_links = '';

	// Setup the various tabs.
	$tab_links .= '<ul class="btn-group">' . "\n";
	$count = 0;
	foreach ( $tabs as $tab ) {
		$count++;
		$class = '';

		if ( $count == 1 ) {
			$class = ' first active';
		}
		if ( $count == count( $tabs ) ) {
			$class = ' last';
		}

		$tab_links .= '<li class="btn btn-default tab-heading-' . esc_attr( $tab ) . $class . '"><a href="#tab-pane-' . esc_attr( $tab ) . '" data-toggle="tab">' . __( $tab, 'fortytwo' ) . '</a></li>' . "\n";
//		$tab_links .= '<button type="button" class="btn btn-default tab-heading-' . esc_attr( $tab ) . $class . '" data-target="#tab-pane-' .
//			esc_attr( $tab ) . '" data-toggle="tab">' . __( $tab, 'fortytwo' ) . '</button>' . "\n";

		$tab_content .= '<div id="tab-pane-' . esc_attr( $tab ) . '" class="tab-pane tab-pane-' . esc_attr( $tab ) . $class . '">' . "\n";

		$tab_args = array( 'limit' => intval( $instance['limit'] ), 'image_dimension' => intval( $instance['image_dimension'] ), 'image_alignment' => strval( $instance['image_alignment'] ) );

		if ( method_exists( $this, 'tab_content_' . esc_attr( $tab ) ) ) {
			$tab_content .= call_user_func_array( array( $this, 'tab_content_' . esc_attr( $tab ) ), $tab_args );
		} else {
			$tab_content .= $this->tab_content_default( $tab );
		}

		$tab_content .= '</div>' . "\n";
	}
	$tab_links .= '</ul>' . "\n";

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title ) {
		$html .= $before_title . $title . $tab_links . $after_title;
	} else {
		$html .= $tab_links;
	}

	$html .= '<div class="tab-content image-align-' . $instance['image_alignment'] . '">' . "\n" . $tab_content . '</div>' . "\n";

}

echo $html;