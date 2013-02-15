<?php
/*
Plugin Name: Forsite Extension Pack
Plugin URI: http://github.com/...
Description: Forsite extension pack for WordPress
Author: Forsite Themes
Version: 0.6
Author URI: http://forsitethemes.com/

License: GPLv2 ->

  Copyright 2012 Forsite Themes (team@forsitethemes.com)

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
 * All modules requires Bootstrap >=2.0.4 to be available the page.
 * 
 * If you want to override the version of bootstrap this widget loads, simply 
 * wp_enqueue_styles( 'bootstrap' ... ) and wp_enqueue_scripts( 'bootstrap' ... ) 
 * your alternate versions in your theme / plugin
 *
 * @category   Forsite Extension Pack
 * @package    Plugin
 * @author     StudioPress
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://forsitethemes.com
 */

define( 'FST_PACK_DIR', dirname( __FILE__ ) );
define( 'FST_PACK_URL', plugin_dir_url( __FILE__ ));
define( 'FST_PACK_VERSION', "0.7");

require_once FST_PACK_DIR . '/modules/contact-widget.php';
require_once FST_PACK_DIR . '/modules/slideshow-widget.php';
require_once FST_PACK_DIR . '/modules/audio-slideshow-widget.php';
require_once FST_PACK_DIR . '/modules/fst-tabs-widget.php';
require_once FST_PACK_DIR . '/modules/fst-menu-extensions.php';

class ForsiteExtensionPackPlugin {

        var $data = array();
	var $version = FST_PACK_VERSION;
        
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
            load_plugin_textdomain( 'fstpack', false, FST_PACK_DIR . '/assets/languages' );
            
            // Register admin styles and scripts
            add_action( 'admin_print_styles',    array( &$this, 'register_admin_styles' ) );
            add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );
            
            // Enqueue bootstrap (if it isn't registered already)
            add_action( 'wp_enqueue_scripts', array( &$this, 'register_bootstrap' ), 999 );

            add_action( 'widgets_init', array( &$this, 'action_init_modules' ) );
            add_action( "admin_init"  , array( &$this, 'action_init_options' ) );    
	    add_action( "admin_menu"  , array( &$this, 'action_register_custom_menu_page' ) );
	}
        
	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
            wp_enqueue_style( 'bootstrap-wpadmin', FST_PACK_URL . 'vendor/bootstrap/css/bootstrap-wpadmin.min.css' );
	} 

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
        wp_enqueue_script( 'bootstrap', FST_PACK_URL .  'vendor/bootstrap/js/bootstrap.min.js'  );
        wp_enqueue_script( 'jquery-quicksand', FST_PACK_URL .  'vendor/jquery.quicksand.js'  );
	} 
        
    /**
     * Registers bootstrap js & css
     */
    public function register_bootstrap() {
        if ( wp_get_theme() != "FortyTwo") {
            wp_enqueue_style(  "bootstrap", FST_PACK_URL . "vendor/bootstrap/css/bootstrap.min.css", array(), '2.0.4' );
            wp_enqueue_script( "bootstrap", FST_PACK_URL . "vendor/bootstrap/js/bootstrap.min.js", array( 'jquery' ), '2.0.4' );
        }
	} 
        
        /**
	 * Initialises active modules 
	 */
        function action_init_modules() {
            $this->data = get_option('fst_modules_enabled', $this->data);
            if (isset($this->data['widgets'])) {
                if ($this->data['widgets']['FST_Contact_Widget']['enabled'] ) {
                    register_widget( 'FST_Contact_Widget' );
                }
                if ($this->data['widgets']['FST_Slideshow_Widget']['enabled'] ) {
                    register_widget( 'FST_Slideshow_Widget' );
                }
                if ($this->data['widgets']['FST_Tabs_Widget']['enabled'] ) {
                    register_widget( 'FST_Tabs_Widget' );
                }
                if ($this->data['plugins']['FST_Menu_Extensions']['enabled'] ) {
                    $this->FST_Menu_Extensions = new FST_Menu_Extensions();
                }
            }
        }

        /**
         * Create / load saved plugin options 
         */
        function action_init_options() {
            register_setting( 'fst', 'fst_modules_enabled' );
            $defaults['widgets'] = array();
            $defaults['widgets']['FST_Slideshow_Widget'] = array('enabled'=>false);
            $defaults['widgets']['FST_Contact_Widget'] = array('enabled'=>false);
            $defaults['widgets']['FST_Tabs_Widget'] = array('enabled'=>false);

            $defaults['plugins']['FST_Menu_Extensions'] = array('enabled'=>false);
	    
	    $this->data = $defaults;

            $current_options = get_option('fst_modules_enabled');
	    if (is_array($current_options)) { $this->data = array_merge($defaults, get_option('fst_modules_enabled')); }
            
	    update_option('fst_modules_enabled,', $this->data);
        }

        /**
         * Register a top level menu item named "Forsite"
         */
	function action_register_custom_menu_page() {
            add_menu_page( 'Forsite', 'Forsite', 'administrator', 'display_forsite_admin_page',
                    array( &$this, 'display_forsite_admin_page' ), FST_PACK_URL . 'assets/images/icon.png', 3 );

	}

        /**
         * Render the main admin page - linked to top level menu item above 
         */
	function display_forsite_admin_page() {
            include( FST_PACK_DIR . '/views/forsite_admin_page.php' );
	}
}

//fire her up, baby!
new ForsiteExtensionPackPlugin();
