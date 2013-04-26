<?php
/*
Plugin Name: Sizzle Pack
Plugin URI: https://github.com/forsitethemes/sizzle-pack
Description: WordPress Extensions to add sizzle to your themes
Author: Forsite Themes
Version: 0.6-soalphathatithurts
Author URI: http://forsitethemes.com/

License: GPLv2 ->

  Copyright 2012-2013 Forsite Themes (team@forsitethemes.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/**
 * All modules require Bootstrap >=2.0.4 to be available the page.
 *
 * If you want to override the version of bootstrap this widget loads, simply
 * wp_enqueue_styles( 'bootstrap' ... ) and wp_enqueue_scripts( 'bootstrap' ... )
 * your alternate versions in your theme / plugin
 *
 * @category   Forsite Themes Sizzle Pack
 * @package    Plugin
 * @author     StudioPress
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://forsitethemes.com
 */

define( 'SZZL_PACK_DIR', dirname( __FILE__ ) );
define( 'SZZL_PACK_URL', plugin_dir_url( __FILE__ ) );
define( 'SZZL_PACK_VERSION', "0.8" );
define( 'SZZL_MODULE_OPTION', "szzl_modules" );

require_once SZZL_PACK_DIR . '/modules/contact-widget.php';
require_once SZZL_PACK_DIR . '/modules/slideshow-widget.php';
require_once SZZL_PACK_DIR . '/modules/audio-slideshow-widget.php';
require_once SZZL_PACK_DIR . '/modules/tabs-widget.php';
require_once SZZL_PACK_DIR . '/modules/menu-extensions.php';

class SizzlePackPlugin {

    var $version = SZZL_PACK_VERSION;
    /**
     * Details of modules that are available.
     * The values below are considered the defaults, and are overridden by what is stored
     * in the szzl_modules setting
     */
    var $modules = array(
        "SZZL_Slideshow_Widget" => array(
            "id"            => "SZZL_Slideshow_Widget",
            "type"          => "widget",
            "name"          => "Slideshow Widget",
            "thumbnail"     => 'modules/slideshow-widget/images/thumbnail.gif',
            "description"   => "A slideshow widget based on ImpressJs, and your widget backend of choice",
            "tags"          => array( "popular", "widget" ),
            "enabled"       => false
        ),
        "SZZL_Tabs_Widget" => array(
            "id"            => "SZZL_Tabs_Widget",
            "type"          => "widget",
            "name"          => "Tabs Widget",
            "thumbnail"     =>  'modules/tabs-widget/images/thumbnail.gif',
            "description"   => "Allows grouping of other widgets into tabs",
            "tags"          => array( "popular", "widget" ),
            "enabled"       => false
        ),
        "SZZL_Contact_Widget" => array(
            "id"            => "SZZL_Contact_Widget",
            "type"          => "widget",
            "name"          => "Contact Widget",
            "thumbnail"     => 'modules/contact-widget/images/thumbnail.gif',
            "description"   => "a Schema.org compliant contact widget",
            "tags"          => array( "widget" ),
            "enabled"       => false
        ),
        "SZZL_Menu_Extensions" => array(
            "id"            => "SZZL_Menu_Extensions",
            "type"          => "plugin",
            "name"          => "Menu Extensions",
            "thumbnail"     => 'modules/contact-widget/images/thumbnail.gif',
            "description"   => "Add custom menu types including Nav header, Nav Divider and Nav Widget Area",
            "tags"          => array( "popular", "plugin" ),
            "enabled"       => false
        )
    );

    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    function __construct() {
        load_plugin_textdomain( 'szzl', false, SZZL_PACK_DIR . '/assets/languages' );

        // Register admin styles and scripts
        add_action( 'admin_print_styles',    array( &$this, 'register_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );

        // Enqueue bootstrap (if it isn't registered already)
        add_action( 'wp_enqueue_scripts', array( &$this, 'register_bootstrap' ), 999 );

        add_action( 'widgets_init', array( &$this, 'action_init_modules' ) );
        add_action( "admin_menu"  , array( &$this, 'action_register_custom_menu_page' ) );
        add_action( 'wp_ajax_save_module', array( $this, 'action_save_module' ) );
    }

    /**
     * Registers and enqueues admin-specific styles.
     */
    public function register_admin_styles() {
        wp_enqueue_style( 'bootstrap-wpadmin', SZZL_PACK_URL . 'vendor/bootstrap/css/bootstrap-wpadmin.min.css' );
    }

    /**
     * Registers and enqueues admin-specific JavaScript.
     */
    public function register_admin_scripts() {
        wp_enqueue_script( 'backbone' );
        wp_enqueue_script( 'bootstrap', SZZL_PACK_URL .  'vendor/bootstrap/js/bootstrap.min.js'  );
    }

    /**
     * Registers bootstrap js & css (if it isn't registered already)
     */
    public function register_bootstrap() {
        if ( wp_get_theme() != "FortyTwo" ) {
            wp_enqueue_style(  "bootstrap", SZZL_PACK_URL . "vendor/bootstrap/css/bootstrap.min.css", array(), '2.0.4' );
            wp_enqueue_script( "bootstrap", SZZL_PACK_URL . "vendor/bootstrap/js/bootstrap.min.js", array( 'jquery' ), '2.0.4' );
        }
    }

    /**
     * Initialises active modules
     */
    function action_init_modules() {
        //Override the module defaults with whatever is saved in options
        $saved_modules = get_option( SZZL_MODULE_OPTION );
        if ( is_array( $saved_modules ) ) {
            $this->modules = array_merge( $this->modules, $saved_modules );
        }

        foreach ( $this->modules as $module ) {
            if ( $module['enabled'] ) {
                switch ( $module['type'] ) {
                case 'widget' :
                    register_widget( $module['id'] );
                    break;
                case 'plugin' :
                    $this->$module['id'] = new $module['id'](); //i.e., if $module['id'] == "myPluginClass", then $this->myPluginClass = new myPluginClass()
                    break;
                }
            }
        }
    }

    function action_save_module() {
        $updated_module = json_decode( file_get_contents( "php://input" ) );

        // Ensure that this user has the correct permissions
        //TODO

        foreach ( $this->modules as &$module ) { //Assign $module by reference so we can modify it inside the loop - http://php.net/manual/en/control-structures.foreach.php
            if ( $module['id'] === $updated_module->id ) {
                $module['enabled'] = $updated_module->enabled;
                $saved_module = $module;
            }
        }

        $update = update_option( SZZL_MODULE_OPTION, $this->modules );

        // If update was successful, return the model in JSON format
        if ( $update ) {
            echo json_encode( $saved_module );
        } else {
            echo 0;
        }
        die();

    }

    /**
     * Register a top level menu item named "Forsite"
     */
    function action_register_custom_menu_page() {
        add_menu_page( 'Sizzle Pack', 'Sizzle Pack', 'administrator', 'display_sizzle_pack_admin_page',
            array( &$this, 'display_admin_page' ), SZZL_PACK_URL . 'assets/images/icon.png', 3 );

    }

    /**
     * Render the main admin page - linked to top level menu item above
     */
    function display_admin_page() {
        include SZZL_PACK_DIR . '/views/admin_page.php';
    }
}

//fire her up, baby!
new SizzlePackPlugin();
