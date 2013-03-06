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

class FST_Tabs_Widget extends WP_Widget {

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
     * @uses FSTPack
     * @return void
     */
    function __construct () {
        global $fstpack;

        /* Widget variable settings. */
        $this->fst_widget_cssclass = 'widget_fstpack_tabs';
        $this->fst_widget_description = __( 'This is a Forsite Themes Extension Pack bundled tabs widget.', 'fstpack' );
        $this->fst_widget_idbase = 'fstpack_tabs';
        $this->fst_widget_title = __('FST - Tabs', 'fstpack' );

        /* Setup the assets URL in relation to FSTPack. */
        $this->assets_url = FST_PACK_URL . "/modules/fst-tabs-widget/";

        $this->available_tabs = array('latest', 'popular', "comments", "tags" );
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
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget( $args, $instance ) {
        $html = '';

        extract( $args, EXTR_SKIP );

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base );
        $tabs = $instance['tabs'];

        /* Before widget (defined by themes). */
        echo $before_widget;

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
            $tab_links .= '<ul class="nav nav-tabs nav-justified">' . "\n";
            $count = 0;
            foreach ( $tabs as $tab) {
                $count++;
                $class = '';

                if ( $count == 1 ) { $class = ' first active'; }
                if ( $count == count( $tabs ) ) { $class = ' last'; }

                $tab_links .= '<li class="tab-heading-' . esc_attr( $tab ) . $class . '"><a href="#tab-pane-' .
                    esc_attr( $tab ) . '" data-toggle="tab">' . __($tab, 'fstpack') . '</a></li>' . "\n";

                $tab_content .= '<div id="tab-pane-' . esc_attr( $tab ) . '" class="tab-pane tab-pane-' . esc_attr( $tab ) . $class . '">' . "\n";

                // Tab functions check for functions of the convention "fstpack_tabs_x" or, if non exists,
                // a method in this class called "tab_content_x". If none, a default method is used to prevent errors.
                // Parameters: array or arguments: 1: number of posts, 2: dimensions of image

                $tab_args = array( 'limit' => intval( $instance['limit'] ), 'image_dimension' => intval( $instance['image_dimension'] ) );

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

        /* After widget (defined by themes). */
        echo $after_widget;

    } // End widget()

    /**
     * update function.
     *
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array $instance
     */
    function update ( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );

        /* The select box is returning a text value, so we escape it. */
        $instance['image_alignment'] = esc_attr( $new_instance['image_alignment'] );

        /* Escape the text string and convert to an integer. */
        $instance['limit'] = intval( strip_tags( $new_instance['limit'] ) );
        $instance['image_dimension'] = intval( strip_tags( $new_instance['image_dimension'] ) );

        /* Convert multiple tab_$position fields into tabs array */
        $instance['tabs'] = array();
        for ($i = 0; $i < count($this->available_tabs); $i++) {
            $tab_value = $new_instance["tab_$i"];
            if ($tab_value != 'none') {
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
     * @param array $instance
     * @return void
     */
    function form ( $instance ) {

        /* Set up some default widget settings. */
        /* Make sure all keys are added here, even with empty string values. */
        $defaults = array(
            'title' => __( 'Tabs', 'fstpack' ),
            'tabs' => array_slice($this->available_tabs,0,3), /* default to selecting the first 3, to suggest that it is possible to omit having a tab */
            'limit' => 5,
            'image_dimension' => 45,
            'image_alignment' => 'left'
        );

        // Allow child themes/plugins to filter here.
        $defaults = apply_filters( $this->fst_widget_idbase . '_widget_defaults', $defaults, $this );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
    <!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (optional):', 'fstpack' ); ?></label>
      <input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo $instance['title']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
    </p>
    <div class="genesis-widget-column">
      <div class="genesis-widget-column-box genesis-widget-column-box-top">
        <p><span class="description">Choose up to 4 tabs to display</span></p>
        <p><?php $this->render_tabs_dropdown($this->available_tabs, $instance['tabs'], 0) ?></p>
        <p><?php $this->render_tabs_dropdown($this->available_tabs, $instance['tabs'], 1) ?></p>
        <p><?php $this->render_tabs_dropdown($this->available_tabs, $instance['tabs'], 2) ?></p>
        <p><?php $this->render_tabs_dropdown($this->available_tabs, $instance['tabs'], 3) ?></p>
      </div>
    </div>

    <div class="genesis-widget-column genesis-widget-column-right">

      <div class="genesis-widget-column-box genesis-widget-column-box-top">
        <!-- Widget Limit: Text Input -->
        <p>
          <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'fstpack' ); ?></label>
          <input type="text" name="<?php echo $this->get_field_name( 'limit' ); ?>"  value="<?php echo $instance['limit']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" />
        </p>
        <!-- Widget Image Dimension: Text Input -->
        <p>
          <label for="<?php echo $this->get_field_id( 'image_dimension' ); ?>"><?php _e( 'Image Dimension:', 'fstpack' ); ?></label>
          <input type="text" name="<?php echo $this->get_field_name( 'image_dimension' ); ?>"  value="<?php echo $instance['image_dimension']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'image_dimension' ); ?>" />
        </p>
        <!-- Widget Image Alignment: Select Input -->
        <p>
          <label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Image Alignment:', 'fstpack' ); ?></label>
          <select name="<?php echo $this->get_field_name( 'image_alignment' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'image_alignment' ); ?>">
            <option value="left"<?php selected( $instance['image_alignment'], 'left' ); ?>><?php _e( 'Left', 'fstpack' ); ?></option>
            <option value="right"<?php selected( $instance['image_alignment'], 'right' ); ?>><?php _e( 'Right', 'fstpack' ); ?></option>
          </select>
        </p>
        <p><small><?php
            if ( function_exists( 'fst_image' ) ) {
                _e( 'fst_image() will be used to display thumbnails.', 'fstpack' );
            } else {
                if ( current_theme_supports( 'post-thumbnails' ) ) {
                    _e( 'The "featured image" will be used as thumbnails.', 'fstpack' );
                } else {
                    _e( 'Post thumbnails are not supported by your theme. Thumbnails will not be displayed.', 'fstpack' );
                }
            }
            ?></small></p>
      </div>

    </div>
    <?php

        // Allow child themes/plugins to act here.
        do_action( $this->fst_widget_idbase . '_widget_settings', $instance, $this );

    } // End form()

    /**
     * Renders a tabs selection dropdown box
     */
    private function render_tabs_dropdown($available_tabs, $selected_tabs, $position) {
        echo "<p><select name='{$this->get_field_name( "tab_$position" )}' class='widefat' id='{$this->get_field_id( "tab_$position" )}'>";
        echo '<option value="none">' . __( ' - None selected - ', 'fstpack' ) . '</option>';
        foreach($available_tabs as $available_tab) {
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
    function enqueue_styles () {
        wp_register_style( $this->fst_widget_idbase, $this->assets_url . 'css/style.css', array( 'bootstrap' ), FST_PACK_VERSION );
        wp_enqueue_style( $this->fst_widget_idbase );
    } // End enqueue_styles()

    /**
     * enqueue_scripts after bootstrap
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    function enqueue_scripts () {
        wp_register_script( $this->fst_widget_idbase, $this->assets_url . 'js/functions.js', array( 'bootstrap' ), FST_PACK_VERSION );
        wp_enqueue_script( $this->fst_widget_idbase );
    } // End enqueue_styles()

    /**
     * tab_content_latest function.
     *
     * @access public
     * @since 1.0.0
     * @param int $limit
     * @param int $image_dimension
     * @return void
     */
    function tab_content_latest ( $limit, $image_dimension ) {
        global $post;
        $html = '';

        $html .= '<ul class="latest">' . "\n";
        $latest = get_posts( 'ignore_sticky_posts=1&numberposts=' . $limit . '&orderby=post_date&order=desc' );
        foreach( $latest as $post ) {
            setup_postdata($post);
            $html .= '<li>' . "\n";
            if ( $image_dimension > 0 ) {
                $html .= $this->get_image( $image_dimension, $post );
            }
            $html .= '<a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">' . get_the_title() . '</a>' . "\n";
            $html .= '<span class="meta">' . get_the_time( get_option( 'date_format' ) ) . '</span>' . "\n";
            $html .= '</li>' . "\n";
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
     * @param int $limit
     * @param int $image_dimension
     * @return void
     */
    function tab_content_popular ( $limit, $image_dimension ) {
        global $post;
        $html = '';

        $html .= '<ul class="popular">' . "\n";
        $popular = get_posts( 'ignore_sticky_posts=1&numberposts=' . $limit . '&orderby=comment_count&order=desc' );
        foreach( $popular as $post ) {
            setup_postdata($post);
            $html .= '<li>' . "\n";
            if ( $image_dimension > 0 ) {
                $html .= $this->get_image( $image_dimension, $post );
            }
            $html .= '<a title="' . the_title_attribute( array( 'echo' => false ) ) . '" href="' . esc_url( get_permalink( $post ) ) . '">' . get_the_title() . '</a>' . "\n";
            $html .= '<span class="meta">' . get_the_time( get_option( 'date_format' ) ) . '</span>' . "\n";
            $html .= '</li>' . "\n";
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
     * @param int $limit
     * @param int $image_dimension
     * @return void
     */
    function tab_content_comments ( $limit, $image_dimension ) {
        global $wpdb;
        $html = '';

        $comments = get_comments( array( 'number' => $limit, 'status' => 'approve' ) );
        if ( $comments ) {
            $html .= '<ul class="comments">' . "\n";
            foreach( $comments as $c ) {
                $html .= '<li>' . "\n";
                if ( $image_dimension > 0 ) {
                    $html .= get_avatar( $c, $image_dimension );
                }
                $html .= '<a title="' . esc_attr( $c->comment_author . ' ' . __( 'on', 'fstpack' ) . ' ' . get_the_title( $c->comment_post_ID ) ) . '" href="' . esc_url( get_comment_link( $c->comment_ID ) ) . '">' . esc_html( $c->comment_author ) . '</a>' . "\n";
                $html .= '<span class="comment-content">' . stripslashes( substr( esc_html( $c->comment_content ), 0, 50 ) ) . '</span>' . "\n";
                $html .= '</li>' . "\n";
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
     * @param int $limit
     * @param int $image_dimension
     * @return void
     */
    function tab_content_tags ( $limit, $image_dimension ) {
        return wp_tag_cloud( array( 'echo' => false, 'smallest' => 12, 'largest' => 20 ) );
    } // End tab_content_tags()

    /**
     * tab_content_default function.
     *
     * @access public
     * @since 1.0.0
     * @param string $token (default: '')
     * @return void
     */
    function tab_content_default ( $token = '' ) {
        // Silence is golden.
    } // End tab_content_default()

    /**
     * get_image function.
     *
     * @access public
     * @param int $dimension
     * @param object $post
     * @return string $html
     */
    function get_image ( $dimension, $post ) {
        $html = '';

        if ( function_exists( 'fst_image' ) ) {
            $html = fst_image( 'return=true&width=' . $dimension . '&height=' . $dimension . '&class=thumbnail&single=true' );
        } else {
            if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( $post->ID ) ) {
                $html = get_the_post_thumbnail( $post->ID, array( $dimension, $dimension ), array( 'class' => 'thumbnail' ) );
            }
        }

        return $html;
    } // End get_image()

} // End Class
?>