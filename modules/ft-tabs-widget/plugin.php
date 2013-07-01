<?php
/**
 * A tabs widget
 *
 * @package Genesis
 */

/**
 * ForSite Themes Tabs widget class.
 *
 *
 * @package Genesis
 * @subpackage Widgets
 * @since 0.1
 */

class FT_Tabs_Widget extends WP_Widget {

    /* Variable Declarations */
    var $fst_widget_cssclass;
    var $fst_widget_description;
    var $fst_widget_idbase;
    var $fst_widget_title;

    var $assets_url;
    var $available_tabs;

    /**
     * __construct function.
     *
     * @access public
     * @uses FTPack
     * @return void
     */
    function __construct() {
        global $fstpack;

        /* Widget variable settings. */
        $this->fst_widget_cssclass = 'widget-ft-tabs';
        $this->fst_widget_description = __( 'This is a Forsite Themes Extension Pack bundled tabs widget.', 'fstpack' );
        $this->fst_widget_idbase = 'fstpack_tabs';
        $this->fst_widget_title = __( 'FT - Tabs', 'fstpack' );

        /* Setup the assets URL in relation to FTPack. */
        $this->assets_url = modules_url("ft-tabs-widget/");

        $this->available_tabs = array( 'latest', 'popular', "comments", "tags" );
        // Allow child themes/plugins to filter here.
        $this->available_tabs = apply_filters( 'fstpack_available_tabs', $this->available_tabs );

        /* Widget settings. */
        $widget_ops = array( 'classname' => $this->fst_widget_cssclass, 'description' => $this->fst_widget_description );

        /* Widget control settings. */
        $control_ops = array( 'width' => 505, 'height' => 350, 'id_base' => $this->fst_widget_idbase );

        /* Create the widget. */
        $this->WP_Widget( $this->fst_widget_idbase, $this->fst_widget_title, $widget_ops, $control_ops );

        /* Load in assets for the widget */
        add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
    } // End Constructor

    /**
     * widget function.
     *
     * @access public
     * @param array   $args
     * @param array   $instance
     * @return void
     */
    function widget( $args, $instance ) {
        $html = '';

        extract( $args, EXTR_SKIP );

        /* Our variables from the widget settings. */
        $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $tabs = $instance['tabs'];
        $tabs_style = $instance['tabs_style'];

        /* Before widget (defined by themes). */
        echo $before_widget;

        include( dirname( __FILE__ ) . '/views/widget.php' );

        /* After widget (defined by themes). */
        echo $after_widget;

    } // End widget()

    /**
     * update function.
     *
     * @access public
     * @param array   $new_instance
     * @param array   $old_instance
     * @return array $instance
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );

        /* The select box is returning a text value, so we escape it. */
        $instance['tabs_style'] = esc_attr( $new_instance['tabs_style'] );
        $instance['image_alignment'] = esc_attr( $new_instance['image_alignment'] );

        /* Escape the text string and convert to an integer. */
        $instance['limit'] = intval( strip_tags( $new_instance['limit'] ) );
        $instance['image_dimension'] = intval( strip_tags( $new_instance['image_dimension'] ) );

        /* Convert multiple tab_$position fields into tabs array */
        $instance['tabs'] = array();
        for ( $i = 0; $i < count( $this->available_tabs ); $i++ ) {
            $tab_value = $new_instance["tab_$i"];
            if ( $tab_value != 'none' ) {
                $instance['tabs'][] = $tab_value;
            }
        }

        // Allow child themes/plugins to act here.
        $instance = apply_filters( $this->fst_widget_idbase . '_widget_save', $instance, $new_instance, $this );

        return $instance;
    } // End update()

    /**
     * form function.
     *
     * @access public
     * @param array   $instance
     * @return void
     */
    function form( $instance ) {

        /* Set up some default widget settings. */
        /* Make sure all keys are added here, even with empty string values. */
        $defaults = array(
            'title'             => __( 'Tabs', 'fstpack' ),
            'tabs'              => array_slice( $this->available_tabs, 0, 3 ), /* default to selecting the first 3, to suggest that it is possible to omit having a tab */
            'limit'             => 5,
            'image_dimension'   => 45,
            'tabs_style'        => 'tabs',
            'image_alignment'   => 'left'
        );

        // Allow child themes/plugins to filter here.
        $defaults = apply_filters( $this->fst_widget_idbase . '_widget_defaults', $defaults, $this );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $available_tabs = $this->available_tabs;

        include( dirname( __FILE__ ) . '/views/admin.php' );

    } // End form()

    /**
     * Renders a tabs selection dropdown box
     */
    private function render_tabs_dropdown( $available_tabs, $selected_tabs, $position ) {
        echo "<p><select name='{$this->get_field_name( "tab_$position" )}' class='widefat' id='{$this->get_field_id( "tab_$position" )}'>";
        echo '<option value="none">' . __( ' - None selected - ', 'fstpack' ) . '</option>';
        foreach ( $available_tabs as $available_tab ) {
            echo '<option value="' . $available_tab . '"' . selected( $available_tab, $selected_tabs[$position], false ) . '>' . __( $available_tab, 'fstpack' ) . "</option>";
        }
        echo "</select></p>";
    }
    /**
     * enqueue_styles after bootstrap
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    function enqueue_styles() {
        wp_register_style( $this->fst_widget_idbase, $this->assets_url . 'css/style.css', array( 'bootstrap' ));
        wp_enqueue_style( $this->fst_widget_idbase );
    } // End enqueue_styles()

    /**
     * enqueue_scripts after bootstrap
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    function enqueue_scripts() {
        wp_register_script( $this->fst_widget_idbase, $this->assets_url . 'js/functions.js', array( 'bootstrap' ) );
        wp_enqueue_script( $this->fst_widget_idbase );
    } // End enqueue_styles()

    /**
     * tab_content_latest function.
     *
     * @access public
     * @since 1.0.0
     * @param int     $limit
     * @param int     $image_dimension
     * @return void
     */
    function tab_content_latest( $limit, $image_dimension, $image_alignment ) {
        global $post;
        $html = '';

        $html .= '<ul class="latest">' . "\n";
        $latest = get_posts( 'ignore_sticky_posts=1&numberposts=' . $limit . '&orderby=post_date&order=desc' );
        $last_post = end( $latest );
        foreach( $latest as $post ) {
            setup_postdata($post);
            $html .= '<li class="media">' . "\n";
            if ( $image_dimension > 0 ) {
                $html .= '<a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '" class="pull-' . $image_alignment . '">' . $this->get_image( $image_dimension, $post ) . '</a>' . "\n";
            }
            $html .= '<div class="media-body">' . "\n";
            $html .= '<h4 class="media-heading"><a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">' . get_the_title() . '</a></h4>' . "\n";
            $html .= 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis... <a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">Read more</a>' . "\n";
            $html .= '</div>' . "\n";
            $html .= '</li>' . "\n";
            if ( $post != $last_post ) {
                $html .= '<hr />' . "\n";
            }
        }
        $html .= '</ul>' . "\n";
        wp_reset_query();

        return $html;
    } // End tab_content_latest()

    /**
     * tab_content_popular function.
     *
     * @access public
     * @since 1.0.0
     * @param int     $limit
     * @param int     $image_dimension
     * @return void
     */
    function tab_content_popular( $limit, $image_dimension, $image_alignment ) {
        global $post;
        $html = '';

        $html .= '<ul class="popular">' . "\n";
        $popular = get_posts( 'ignore_sticky_posts=1&numberposts=' . $limit . '&orderby=comment_count&order=desc' );
        $last_popular = end( $popular );
        foreach( $popular as $post ) {
            setup_postdata($post);
            $html .= '<li class="media">' . "\n";
            if ( $image_dimension > 0 ) {
                $html .= '<a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '" class="pull-' . $image_alignment . '">' . $this->get_image( $image_dimension, $post ) . '</a>' . "\n";
            }
            $html .= '<div class="media-body">' . "\n";
            $html .= '<h4 class="media-heading"><a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">' . get_the_title() . '</a></h4>' . "\n";
            $html .= 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis... <a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">Read more</a>' . "\n";
            $html .= '</div>' . "\n";
            $html .= '</li>' . "\n";            if ( $post != $last_popular ) {
                $html .= '<hr />' . "\n";
            }
        }
        $html .= '</ul>' . "\n";
        wp_reset_query();

        return $html;
    } // End tab_content_popular()

    /**
     * tab_content_comments function.
     *
     * @access public
     * @since 1.0.0
     * @param int     $limit
     * @param int     $image_dimension
     * @return void
     */
    function tab_content_comments( $limit, $image_dimension ) {
        global $wpdb;
        $html = '';

        $comments = get_comments( array( 'number' => $limit, 'status' => 'approve' ) );
        $last_comments = end( $comments );
        if ( $comments ) {
            $html .= '<ul class="comments">' . "\n";
            foreach ( $comments as $c ) {
                $html .= '<li>' . "\n";
                $html .= get_avatar( $c, 45 );
                $html .= '<a title="' . esc_attr( $c->comment_author . ' ' . __( 'on', 'fstpack' ) . ' ' . get_the_title( $c->comment_post_ID ) ) . '" href="' . esc_url( get_comment_link( $c->comment_ID ) ) . '">' . esc_html( $c->comment_author ) . '</a>' . "\n";
                $html .= '<span class="comment-content">' . stripslashes( substr( esc_html( $c->comment_content ), 0, 50 ) ) . '</span>' . "\n";
                $html .= '</li>' . "\n";
                if ( $c != $last_comments ) {
                    $html .= '<hr />' . "\n";
                }
            }
            $html .= '</ul>' . "\n";
        }

        return $html;
    } // End tab_content_comments()

    /**
     * tab_content_tags function.
     *
     * @access public
     * @since 1.0.0
     * @param int     $limit
     * @param int     $image_dimension
     * @return void
     */
    function tab_content_tags( $limit, $image_dimension ) {
        return wp_tag_cloud( array( 'echo' => false, 'smallest' => 12, 'largest' => 20, 'format' => 'list' ) );
    } // End tab_content_tags()

    /**
     * tab_content_default function.
     *
     * @access public
     * @since 1.0.0
     * @param string  $token (default: '')
     * @return void
     */
    function tab_content_default( $token = '' ) {
        // Silence is golden.
    } // End tab_content_default()

    /**
     * get_image function.
     *
     * @access public
     * @param int     $dimension
     * @param object  $post
     * @return string $html
     */
    function get_image( $dimension, $post ) {

        $html = '<img data-src="holder.js/94x94" class="media-object">';

        if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( $post->ID ) ) {
            $html = get_the_post_thumbnail( $post->ID, array( $dimension, $dimension ), array( 'class' => 'media-object' ) );
        }

        return $html;
    } // End get_image()

} // End Class

add_action( 'widgets_init', create_function( '', 'register_widget("FT_Tabs_Widget");' ) );
?>
