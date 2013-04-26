<?php
/**
 * Adds a set of addition custom menu types for use in Bootstrap / Genesis / Forsite Themes menus
 *
 * @category   Forsite Extension Pack
 * @package    Module
 * @subpackage Menu Extensions
 * @author     ForsiteThemes
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://forsitethemes.com
 */

define( 'SZZL_MENU_EXTENSIONS_DIR', SZZL_PACK_DIR . '/modules/menu-extensions' );
require_once SZZL_MENU_EXTENSIONS_DIR . '/hookable-walker-nav-menu-edit.php';

/**
 * ForSite Themes Menu Extensions class.
 *
 * @kudos (twitter: @soulseekah) - http://codeseekah.com/2012/03/01/custom-post-type-archives-in-wordpress-menus-2/
 */
class SZZL_Menu_Extensions {

    /**
     * Constructs the class
     */
    function SZZL_Menu_Extensions() {

        $this->register_menu_widget_areas();

        // Add new metabox to menu edit screen
        add_action( 'admin_head-nav-menus.php', array( &$this, 'inject_menu_extensions_meta_box' ) );

        // Customise the menu item element in the edit screen
        add_filter( 'wp_edit_nav_menu_walker',  array( &$this, 'filter_switch_to_hookable_nav_menu_walker_edit' ), 10, 2 );
        add_action( 'nav_menu_edit_display_element_bottom', array( &$this, 'action_display_element_bottom' ), 10, 1 );
        add_filter( 'nav_menu_edit_massage_menu_item_data', array( &$this, 'filter_massage_menu_item_data' ), 10, 1 );
        add_filter( 'nav_menu_edit_massage_original_title', array( &$this, 'filter_menu_massage_original_title' ), 10, 2 );

        // Modify the display of the front-end menu
        add_filter( 'nav_menu_css_class',       array( &$this, 'filter_add_menu_extension_class' ), 10, 3 );
        add_filter( 'walker_nav_menu_start_el', array( &$this, 'menu_extension_renderer' ), 10 , 4 );
    }

    /**
     * Finds all the menu-extension-widget-areas, and ensures they are registered
     */
    function register_menu_widget_areas() {
        delete_option( 'SZZL_Menu_Extensions' ); //clear out unused options

        $all_menus = wp_get_nav_menus();


        // Register all the widget areas that have been defined with
        // a menu-extension of type widget
        $all_menus = wp_get_nav_menus();
        foreach ( $all_menus as $menu ) {
            $menu_items = wp_get_nav_menu_items( $menu->term_id );
            foreach ( $menu_items as $menu_item ) {
                if ( $menu_item->object == "widget" ) {
                    register_sidebar( array(
                            'name'          => $menu_item->title,
                            'id'            => "fst-menu-extension-widget-{$menu_item->ID}",
                            'description'   => __( 'SZZL Menu Extension widget area' ),
                            'before_widget' => '<div id="%1$s" class="widget %2$s">',
                            'after_widget'  => "</div>\n",
                        ) );
                }
            }
        }
    }

    /**
     * Adds a new metabox containing the available menu-exteneions at the top of the
     * left side panel in the menu editor
     */
    function inject_menu_extensions_meta_box() {
        add_meta_box( 'fst-menu-extensions', __( 'SZZL Menu Extensions', 'default' ),
            array( &$this, 'wp_nav_menu_extensions_meta_box' ), 'nav-menus', 'side', 'high' );
    }

    /**
     * The metabox that contains the custom menu-extensions
     */
    function wp_nav_menu_extensions_meta_box() {
        global $_nav_menu_placeholder, $nav_menu_selected_id;
        $_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;
?>
        <div id="menu-extension">
            <span class="tabs-panel-active">
            <ul class="categorychecklist">
                <li>
                    <input type="hidden" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" value="menu-extension" />
                    <input type="hidden" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object]" value="header">
                    <label class="menu-item-title">
                        <input type="checkbox" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object-id]" value="1">
                        <span><?php _e( 'Header' ); ?></span>
                        <input name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" type="text" class="hidden menu-item-textbox input-with-default-title" title="<?php esc_attr_e( 'Header name' ); ?>" />
                    </label>
                </li>
                <?php $_nav_menu_placeholder-- ?>
                <li>
                    <input type="hidden" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" value="menu-extension" />
                    <input type="hidden" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object]" value="divider">
                    <input type="hidden" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" value="Divider" />
                    <label class="menu-item-title">
                        <input type="checkbox" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object-id]" value="1">
                        <span><?php _e( 'Divider' ); ?></span>
                    </label>
                </li>
                <?php $_nav_menu_placeholder-- ?>
                <li>
                    <input type="hidden" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" value="menu-extension" />
                    <input type="hidden" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object]" value="widget">
                    <label class="menu-item-title">
                        <input type="checkbox" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object-id]" value="1">
                        <span><?php _e( 'Widget area' ); ?></span>
                        <input name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" type="text" class="hidden menu-item-textbox input-with-default-title" title="<?php esc_attr_e( 'Widget area name' ); ?>" />
                    </label>
                </li>
                <li>
                <p class="button-controls">
                    <span class="add-to-menu">
                        <img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="waiting" />
                        <input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-menu-extension-item" id="submit-menu-extension" />
                    </span>
                </p>
                </li>
            </ul>
            </span>
            <script>
            jQuery(document).ready(function($) {
                //Something is dynamically inserting a pesky button named #genesis-category-checklist-toggle.
                //Trap that insertion event, and hide the button
                $('#menu-extension').live('DOMNodeInserted',function(event){
                        if ($(event.target).find('#genesis-category-checklist-toggle')) {
                            $(event.target).hide();
                        }
                });
                //Trigger add button click when hitting Enter in label box
                $('#menu-extension input[type="text"]').keypress(function(e){
                    if ( e.keyCode === 13 ) {
                        e.preventDefault();
                        $("#submit-menu-extension").click();
                    }
                });
            });
            </script>
        </div>
        <?php
    }

    /**
     * Replace the Nav_Menu_Walker class used to generate the edit menu with a custom
     * one that embeds a few more actions & filters
     *
     * @param type    $current_walker_class
     * @param type    $menu_id
     * @return string
     */
    function filter_switch_to_hookable_nav_menu_walker_edit( $current_walker_class, $menu_id ) {
        return "Hookable_Walker_Nav_Menu_Edit";
    }

    /**
     * Change the type label for the box for menu-extension types
     *
     * @param type    $menu_item
     * @return $menu_item
     */
    function filter_massage_menu_item_data( $item ) {
        if ( $item->type == 'menu-extension' ) {
            switch ( $item->object ) {
            case 'header':
                $item->type_label  = "Header";
                break;
            case 'divider':
                $item->type_label = "Divider";
                break;
            case 'widget':
                $item->type_label = "Widget area";
                break;
            }
        }
        return $item;
    }

    /**
     * Prevent original title box from rendering for menu-extension menu items
     *
     * @param menu_item $item           The menu item
     * @param string  $original_title The menu item
     * @return  string                        Return false if should not be displayed
     */
    function filter_menu_massage_original_title( $item, $original_title ) {
        if ( $item->type == 'menu-extension' ) {
            return false;
        }
        return $original_title;
    }


    /**
     * Allows injecting some extra HTML inside the menu item edit box, n
     * just below the label & attribute
     *
     * @global  array       $wp_registered_sidebars
     * @global  array       $wp_registered_widgets
     * @param menu_item $item The menu item being rendered
     */
    function action_display_element_bottom( $item ) {
        global $wp_registered_sidebars, $wp_registered_widgets;

        if ( $item->type == 'menu-extension' ) {
            // Render the addition UI for this menu type
            echo "<div class='description-wide'>";
            switch ( $item->object ) {
            case 'header':
                require SZZL_MENU_EXTENSIONS_DIR . '/views/menu_item_editbox_header.php';
                break;
            case 'divider':
                require SZZL_MENU_EXTENSIONS_DIR . '/views/menu_item_editbox_divider.php';
                break;
            case 'widget':
                $sidebars_widgets = wp_get_sidebars_widgets();
                $widgets = $sidebars_widgets["fst-menu-extension-widget-{$item->ID}"];
                if ( $widgets ) {
                    $widget_descriptions = array();
                    foreach ( $widgets as $widget ) {
                        $w = $wp_registered_widgets[$widget];
                        $widget_descriptions[] = array( 'name' => $w['name'] );
                    }
                    require SZZL_MENU_EXTENSIONS_DIR . '/views/menu_item_editbox_widget_area.php';
                }
                break;
            }
            echo "</div>";
        }

    }

    /**
     * When displaying the front end menu, decorate the menu_extension items
     * with custom css classes for the menu walker to render
     *
     * @param array   $items The items in the menu
     * @param array   $menu  The menu these items belong to
     * @param array   $args  The args originally passed to wp_get_nav_menu_items()
     * @return type
     */
    function filter_add_menu_extension_class( $classes, $item, $args ) {
        // Do nothing if it isn't a menu extension
        if ( $item->type != 'menu-extension' ) return $classes;

        // Attach a custom css class per type
        switch ( $item->object ) {
        case 'header':
            $classes = $this->add_if_missing( 'nav-header', $classes );
            break;
        case 'divider':
            $divider_class = $item->menu_item_parent == 0 ? "divider-vertical" : "divider"; //Use vertical dividers if at top level
            $classes = $this->add_if_missing( $divider_class, $classes );
            break;
        case 'widget':
            $classes = $this->add_if_missing( 'nav-widget-area', $classes );
            break;
        }
        return $classes;
    }

    /**
     * Adds a value to an array iff
     * the array doesn't already contain the value
     *
     * @param object  $value The item to add to the array
     * @param array   $array The array
     * @return array            The array with the item added
     */
    function add_if_missing( $value, $array ) {
        if ( ! in_array( $value, $array ) ) {
            $array[] = $value;
        }
        return $array;
    }

    /**
     * When displaying the front end menu,
     * override the menu item content for menu-extension types
     *
     * @param string  $item_output The HTML that will be rendered for the menu item
     * @param object  $item        The menu item being rendered
     * @param int     $depth       The menu item depth
     * @param array   $args        ?
     * @return type
     */
    function menu_extension_renderer( $item_output, $item, $depth, $args ) {
        // Do nothing if it isn't a menu extension
        if ( $item->type != 'menu-extension' ) return $item_output;

        switch ( $item->object ) {
        case 'header':
            $item_output = $item->post_name;
            break;
        case 'divider':
            $item_output = "&nbsp;";
            break;
        case 'widget':
            ob_start();  //Trap the output of the widgets
            dynamic_sidebar( "fst-menu-extension-widget-{$item->db_id}" );
            $item_output = ob_get_clean();
            break;
        }

        return $item_output;
    }




} // end of class
// end of the world?
