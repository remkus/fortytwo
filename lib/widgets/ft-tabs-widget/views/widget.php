<?php

/* Display the widget title if one was input (before and after defined by themes). */
if ( $title ) {

    echo $before_title . $title . $after_title;

} // End IF Statement

/* Widget content. */

// Add actions for plugins/themes to hook onto.
do_action( $this->fst_widget_cssclass . '_top' );

// Load widget content here.
$html = '';

if ( count( $tabs ) > 0 ) {
    $tab_content = '';
    $tab_links = '';

    // Setup the various tabs.
    $tab_links .= '<ul class="nav nav-' . esc_attr( $tabs_style ) . '">' . "\n";
    $count = 0;
    foreach ( $tabs as $tab ) {
        $count++;
        $class = '';

        if ( $count == 1 ) { $class = ' first active'; }
        if ( $count == count( $tabs ) ) { $class = ' last'; }

        $tab_links .= '<li class="tab-heading-' . esc_attr( $tab ) . $class . '"><a href="#tab-pane-' .
            esc_attr( $tab ) . '" data-toggle="tab">' . __( $tab, 'fstpack' ) . '</a></li>' . "\n";

        $tab_content .= '<div id="tab-pane-' . esc_attr( $tab ) . '" class="tab-pane tab-pane-' . esc_attr( $tab ) . $class . '">' . "\n";

        // Tab functions check for functions of the convention "fstpack_tabs_x" or, if non exists,
        // a method in this class called "tab_content_x". If none, a default method is used to prevent errors.
        // Parameters: array or arguments: 1: number of posts, 2: dimensions of image

        $tab_args = array( 'limit' => intval( $instance['limit'] ), 'image_dimension' => intval( $instance['image_dimension'] ), 'image_alignment' => strval( $instance['image_alignment'] ) );

        if ( function_exists( 'fstpack_tabs_' . esc_attr( $tab ) ) ) {
            $tab_content .= call_user_func_array( 'fstpack_tabs_' . esc_attr( $tab ), $tab_args );
        } else {
            if ( method_exists( $this, 'tab_content_' . esc_attr( $tab ) ) ) {
                $tab_content .= call_user_func_array( array( $this, 'tab_content_' . esc_attr( $tab ) ), $tab_args );
            } else {
                $tab_content .= $this->tab_content_default( $tab );
            }
        }

        $tab_content .= '</div><!--/.tab-pane-->' . "\n";
    }
    $tab_links .= '</ul>' . "\n";


    $html .= $tab_links;
    $html .= '<div class="tab-content image-align-' . $instance['image_alignment'] . '">' . "\n" . $tab_content . '</div><!--/.tab-content-->' . "\n";

}

echo $html; // If using the $html variable to store the output, you need this. ;)

// Add actions for plugins/themes to hook onto.
do_action( $this->fst_widget_cssclass . '_bottom' );