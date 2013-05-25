<?php
/**
 * Genesis Framework.
 *
 * @package Genesis\Admin
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/**
 * Registers a new admin page, providing content and corresponding menu item for the Theme Settings page.
 *
 * Although this class was added in 1.8.0, some of the methods were originally* standalone functions added in previous
 * versions of Genesis.
 *
 * @package Genesis\Admin
 *
 * @since 1.8.0
 */
class Genesis_Admin_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.8.0
	 *
	 * @uses GENESIS_ADMIN_IMAGES_URL     URL for admin images.
	 * @uses GENESIS_SETTINGS_FIELD       Settings field key.
	 * @uses PARENT_DB_VERSION            Genesis database version.
	 * @uses PARENT_THEME_VERSION         Genesis framework version.
	 * @uses genesis_get_default_layout() Get default layout.
	 * @uses \Genesis_Admin::create()     Create an admin menu item and settings page.
	 */
	function __construct() {

		$page_id = 'genesis';

		$menu_ops = apply_filters(
			'genesis_theme_settings_menu_ops',
			array(
				'main_menu' => array(
					'sep' => array(
						'sep_position'   => '58.995',
						'sep_capability' => 'edit_theme_options',
					),
					'page_title' => 'Theme Settings',
					'menu_title' => 'Genesis',
					'capability' => 'edit_theme_options',
					'icon_url'   => GENESIS_ADMIN_IMAGES_URL . '/genesis-menu.png',
					'position'   => '58.996',
				),
				'first_submenu' => array( //* Do not use without 'main_menu'
					'page_title' => __( 'Theme Settings', 'genesis' ),
					'menu_title' => __( 'Theme Settings', 'genesis' ),
					'capability' => 'edit_theme_options',
				),
			)
		);

		$page_ops = apply_filters(
			'genesis_theme_settings_page_ops',
			array(
				'screen_icon'       => 'options-general',
				'save_button_text'  => __( 'Save Settings', 'genesis' ),
				'reset_button_text' => __( 'Reset Settings', 'genesis' ),
				'saved_notice_text' => __( 'Settings saved.', 'genesis' ),
				'reset_notice_text' => __( 'Settings reset.', 'genesis' ),
				'error_notice_text' => __( 'Error saving settings.', 'genesis' ),
			)
		);

		$settings_field = GENESIS_SETTINGS_FIELD;

		$default_settings = apply_filters(
			'genesis_theme_settings_defaults',
			array(
				'update'                    => 1,
				'blog_title'                => 'text',
				'header_right'              => 0,
				'site_layout'               => genesis_get_default_layout(),
				'nav_extras'                => '',
				'nav_extras_twitter_id'     => '',
				'nav_extras_twitter_text'   => __( 'Follow me on Twitter', 'genesis' ),
				'feed_uri'                  => '',
				'comments_feed_uri'         => '',
				'redirect_feeds'            => 0,
				'comments_pages'            => 0,
				'comments_posts'            => 1,
				'trackbacks_pages'          => 0,
				'trackbacks_posts'          => 1,
				'breadcrumb_home'           => 0,
				'breadcrumb_front_page'     => 0,
				'breadcrumb_posts_page'     => 0,
				'breadcrumb_single'         => 0,
				'breadcrumb_page'           => 0,
				'breadcrumb_archive'        => 0,
				'breadcrumb_404'            => 0,
				'breadcrumb_attachment'		=> 0,
				'content_archive'           => 'full',
				'content_archive_thumbnail' => 0,
				'posts_nav'                 => 'older-newer',
				'blog_cat'                  => '',
				'blog_cat_exclude'          => '',
				'blog_cat_num'              => 10,
				'header_scripts'            => '',
				'footer_scripts'            => '',
				'theme_version'             => PARENT_THEME_VERSION,
				'db_version'                => PARENT_DB_VERSION,
			)
		);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

	}

	/**
	 * Register each of the settings with a sanitization filter type.
	 *
	 * @since 1.7.0
	 *
	 * @uses genesis_add_option_filter() Assign filter to array of settings.
	 *
	 * @see \Genesis_Settings_Sanitizer::add_filter() Add sanitization filters to options.
	 */
	public function sanitizer_filters() {

		genesis_add_option_filter(
			'one_zero',
			$this->settings_field,
			array(
				'breadcrumb_front_page',
				'breadcrumb_home',
				'breadcrumb_single',
				'breadcrumb_posts_page',
				'breadcrumb_archive',
				'breadcrumb_404',
				'breadcrumb_attachment',
				'comments_posts',
				'comments_pages',
				'content_archive_thumbnail',
				'nav',
				'nav_superfish',
				'nav_extras_enable',
				'redirect_feed',
				'redirect_comments_feed',
				'show_info',
				'subnav',
				'subnav_superfish',
				'trackbacks_posts',
				'trackbacks_pages',
				'update',
				'update_email',
			)
		);

		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'blog_cat_exclude',
				'blog_title',
				'content_archive',
				'nav_extras',
				'nav_extras_twitter_id',
				'posts_nav',
				'site_layout',
				'style_selection',
				'theme_version',
			)
		);

		genesis_add_option_filter(
			'absint',
			$this->settings_field,
			array(
				'blog_cat',
				'blog_cat_num',
				'db_version',
			)
		);

		genesis_add_option_filter(
			'safe_html',
			$this->settings_field,
			array(
				'nav_extras_twitter_text',
			)
		);

		genesis_add_option_filter(
			'requires_unfiltered_html',
			$this->settings_field,
			array(
				'header_scripts',
				'footer_scripts',
			)
		);

		genesis_add_option_filter(
			'url',
			$this->settings_field,
			array(
				'feed_uri',
				'comments_feed_uri',
			)
		);

	}

	function help() {

		$screen = get_current_screen();
		
		$theme_settings_help =
			'<h3>' . __( 'Theme Settings' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'Your Theme Settings provides control over how the theme works. You will be able to control a lot of common and even advanced features from this menu. Some child themes may add additional menu items to this list, including the ability to select different color schemes or set theme specific features such as a slider. Each of the boxes can be collapsed by clicking the box header and expanded by doing the same. They can also be dragged into any order you desire or even hidden by clicking on "Screen Options" in the top right of the screen and "unchecking" the boxes you do not want to see. Below you\'ll find the items common to every child theme...' , 'genesis' ) . '</p>';
		
		$information_help =
			'<h3>' . __( 'Information' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'The information box allows you to see the current Genesis theme information and display if desired.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'Normally, this should be unchecked. You can also set to enable automatic updates.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'This does not mean the updates happen automatically without your permission; it will just notify you that an update is available. You must select it to perform the update.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'If you provide an email address and select to notify that email address when the update is available, your site will email you when the update can be performed.No, updates only affect files being updated.' , 'genesis' ) . '</p>';
		
		$feeds_help =
			'<h3>' . __( 'Custom Feeds' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'If you use Feedburner to handle your rss feed(s) you can use this function to set your site\'s native feed to redirect to your Feedburner feed.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'By filling in the feed links calling for the main site feed, it will display as a link to Feedburner.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'By checking the "Redirect Feed" box, all traffic to default feed links will be redirected to the Feedburner link instead.' , 'genesis' ) . '</p>';
		
		$layout_help =
			'<h3>' . __( 'Default Layout' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'This lets you select the default layout for your entire site. On most of the child themes you\'ll see these options:' , 'genesis' ) . '</p>' .
			'<ul>' . 
				'<li>' . __( 'Content Sidebar' , 'genesis' ) . '</li>' .
				'<li>' . __( 'Sidebar Content' , 'genesis' ) . '</li>' .
				'<li>' . __( 'Sidebar Content Sidebar' , 'genesis' ) . '</li>' .
				'<li>' . __( 'Content Sidebar Sidebar' , 'genesis' ) . '</li>' .
				'<li>' . __( 'Sidebar Sidebar Content' , 'genesis' ) . '</li>' .
				'<li>' . __( 'Full Width Content' , 'genesis' ) . '</li>' .
			'</ul>' . 
			'<p>'  . __( 'These options can be extended or limited by the child theme.
			Additionally, many of the child themes do not allow different layouts on the home page as they have been designed for a specific home page layout.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'This layout can also be overridden in the post/page/term layout options on each post/page/term.' , 'genesis' ) . '</p>';
		
		$navigation_help =
			'<h3>' . __( 'Navigation Settings' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'The navigation settings let you select which navigation menus to enable (these are the menus that guide a user through the site).' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'In a default install the Primary Navigation appears directly after the header and the Secondary Navigation appears below the Primary Navigation. In some child themes this is changed.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'The most common change is to move the Primary Navigation to above the header. ' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'Each theme also has a navigation built into the Header Right, which can be activated by putting a Custom Nav Menu Widget into the Header Right Sidebar.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'The "Fancy Dropdowns" option enables a small JavaScript (enhanced code) to run that animates the dropdowns and also displays arrows when sub menus are present.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'In addition to selecting to include the menu, you must also create a custom menu (Click "Menus" under the "Appearance" tab) and assign it to the Primary or Secondary menu position. If you are using the Header Right you do not need to assign a position, instead you will select the menu to use in the widget.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'To create a drop down menu with the custom menu, you need to add all of the menu items. The drop down menu items can be dragged under and slightly right of the parent menu item. This will "nest" the menu item.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'To add a home link to your menu, create a custom link with the URL as your site URL and Label it "Home" or whatever you wish the menu to say. ' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'You can also click the arrow beside each menu item and change the Label. This allows you to have good, SEO friendly page titles, and also simple menu friendly labels for that page.' , 'genesis' ) . '</p>';
		
		$breadcrumbs_help =
			'<h3>' . __( 'Breadcrumbs' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'This box lets you define where the "Breadcrumbs" display. The Breadcrumb is the navigation tool that displays where a visitor is on the site at any given moment.' , 'genesis' ) . '</p>';
		
		$comments_help =
			'<h3>' . __( 'Comments and Trackbacks' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'This allows a site wide decision on whether comments and trackbacks (notifications when someone links to your page) are enabled for posts and pages.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'If you enable comments or trackbacks here, it can be disabled on an individual post or page. If you disable here, they cannot be enabled on an individual post or page.' , 'genesis' ) . '</p>';
		
		$archives_help =
			'<h3>' . __( 'Content Archives' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'In the Genesis Theme Settings you may change the site wide Content Archives options to control what displays in the site\'s Archives.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'Archives include any pages using the blog template, category pages, tag pages, date archive, author archives, and the latest posts if there is no custom home page.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'The first option allows you to display the post content or the post excerpt. The Display post content setting will display the entire post including HTML code up to the <!--more--> tag if used (this is HTML for the comment tag that is not displayed in the browser).' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'It may also be coupled with the second field "Limit content to [___] characters" to limit the content to a specific number of letters or spaces. This will strip any HTML, but allows for more precise and easily changed lengths than the excerpt.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'The Display post excerpt setting will display the first 55 words of the post after also stripping any included HTML or the manual/custom excerpt added in the post edit screen.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'The \'Include post image?\' setting allows you to show a thumbnail of the first attached image or currently set featured image.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'This option should not be used with the post content unless the content is limited to avoid duplicate images.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'The \'Image Size\' list is populated by the available image sizes defined in the theme.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'Post Navigation Technique allows you to select one of three navigation methods.' , 'genesis' ) . '</p>';
		
		$blog_help =
			'<h3>' . __( 'Blog Page' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'This works with the Blog Template, which is a page template that shows your latest posts. It\'s what people see when they land on your homepage.
			In the General Settings you can select a specific category to display from the drop down menu, and exclude categories by ID, or even select how many posts you\'d like to display on this page.
			There are some special features of the Blog Template that allow you to specify which category to show on each page using the template, which is helpful if you have a "News" category (or something else) that you want to display separately.
			You can find more on this feature in the ' , 'genesis' ) . '<a href="http://www.studiopress.com/tutorials/genesis/add-post-category-page" target="_blank">' . __( 'How to Add a Post Category Page tutorial.' , 'genesis' ) . '</a></p>';
		
		$scripts_help =
			'<h3>' . __( 'Header and Footer Scripts' , 'genesis' ) . '</h3>' .		
			'<p>'  . __( 'This provides you with two fields that will output to the <head></head> of your site and just before the </body>. These will appear on every page of the site and are a great way to add analytic code and other scripts. You cannot use PHP in these fields. If you need to use PHP then you should look into the Genesis Simple Hooks plugin.' , 'genesis' ) . '</p>';
		
		$home_help =
			'<h3>' . __( 'How Home Pages Work' , 'genesis' ) . '</h3>' .
			'<p>'  . __( 'Most Genesis child themes include a custom home page.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'To use this type of home page, make sure your latest posts are set to show on the front page. You can setup a page with the Blog page template to show a blog style list of your latest posts on another page.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'This home page is typically setup via widgets in the sidebars for the home page. This can be accessed via the Widgets menu item under Appearance.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'Child themes that include this type of home page typically include additional theme-specific tutorials which can be accessed via a sticky post at the top of that child theme support forum.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'If your theme uses a custom home page and you want to show the latest posts in a blog format, do not use the blog template. Instead, you need to rename the home.php file to home-old.php instead.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'Another common home page is the "blog" type home page, which is common to most of the free child themes. This shows your latest posts and requires no additional setup.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'The third type of home page is the new dynamic home page. This is common on the newest child themes. It will show your latest posts in a blog type listing unless you put widgets into the home page sidebars.' , 'genesis' ) . '</p>' .
			'<p>'  . __( 'This setup is preferred because it makes it easier to show a blog on the front page (no need to rename the home.php file) and does not have the confusion of no content on the home page when the theme is initially installed.' , 'genesis' ) . '</p>';
		
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-theme-settings',
			'title'   => __( 'Theme Settings' , 'genesis' ),
			'content' => $theme_settings_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-information',
			'title'   => __( 'Information' , 'genesis' ),
			'content' => $information_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-feeds',
			'title'   => __( 'Custom Feeds' , 'genesis' ),
			'content' => $feeds_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-layout',
			'title'   => __( 'Default Layout' , 'genesis' ),
			'content' => $layout_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-navigation',
			'title'   => __( 'Navigation Settings' , 'genesis' ),
			'content' => $navigation_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-breadcrumbs',
			'title'   => __( 'Breadcrumbs' , 'genesis' ),
			'content' => $breadcrumbs_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-comments',
			'title'   => __( 'Comments and Trackbacks' , 'genesis' ),
			'content' => $comments_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-archives',
			'title'   => __( 'Content Archives' , 'genesis' ),
			'content' => $archives_help,
		) );
	$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-blog',
			'title'   => __( 'Blog Page' , 'genesis' ),
			'content' => $blog_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-scripts',
			'title'   => __( 'Header and Footer Scripts' , 'genesis' ),
			'content' => $scripts_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-home',
			'title'   => __( 'Home Pages' , 'genesis' ),
			'content' => $home_help,
		) );

		//* Add help sidebar
		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'genesis' ) . '</strong></p>' .
			'<p><a href="http://my.studiopress.com/help/" target="_blank" title="' . __( 'Get Support', 'genesis' ) . '">' . __( 'Get Support', 'genesis' ) . '</a></p>' .
			'<p><a href="http://my.studiopress.com/snippets/" target="_blank" title="' . __( 'Genesis Snippets', 'genesis' ) . '">' . __( 'Genesis Snippets', 'genesis' ) . '</a></p>' .
			'<p><a href="http://my.studiopress.com/tutorials/" target="_blank" title="' . __( 'Genesis Tutorials', 'genesis' ) . '">' . __( 'Genesis Tutorials', 'genesis' ) . '</a></p>'
		);

	}

	/**
 	 * Register meta boxes on the Theme Settings page.
 	 *
 	 * Some of the meta box additions are dependent on certain theme support or user capabilities.
 	 *
 	 * The 'genesis_theme_settings_metaboxes' action hook is called at the end of this function.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @see \Genesis_Admin_Settings::info_box()          Callback for Information box.
 	 * @see \Genesis_Admin_Settings::style_box()         Callback for Color Style box (if supported).
 	 * @see \Genesis_Admin_Settings::feeds_box()         Callback for Custom Feeds box.
 	 * @see \Genesis_Admin_Settings::layout_box()        Callback for Default Layout box.
 	 * @see \Genesis_Admin_Settings::header_box()        Callback for Header box (if no custom header support).
	 * @see \Genesis_Admin_Settings::nav_box()           Callback for Navigation box.
 	 * @see \Genesis_Admin_Settings::breadcrumb_box()    Callback for Breadcrumbs box.
 	 * @see \Genesis_Admin_Settings::comments_box()      Callback for Comments and Trackbacks box.
 	 * @see \Genesis_Admin_Settings::post_archives_box() Callback for Content Archives box.
 	 * @see \Genesis_Admin_Settings::blogpage_box()      Callback for Blog Page box.
 	 * @see \Genesis_Admin_Settings::scripts_box()       Callback for Header and Footer Scripts box (if user has
 	 *                                                   unfiltered_html capability).
 	 */
	function metaboxes() {

		add_action( 'genesis_admin_before_metaboxes', array( $this, 'hidden_fields' ) );

		add_meta_box( 'genesis-theme-settings-version', __( 'Information', 'genesis' ), array( $this, 'info_box' ), $this->pagehook, 'main', 'high' );

		if ( current_theme_supports( 'genesis-style-selector' ) )
			add_meta_box( 'genesis-theme-settings-style-selector', __( 'Color Style', 'genesis' ), array( $this, 'style_box' ), $this->pagehook, 'main' );

		add_meta_box( 'genesis-theme-settings-feeds', __( 'Custom Feeds', 'genesis' ), array( $this, 'feeds_box' ), $this->pagehook, 'main' );
		add_meta_box( 'genesis-theme-settings-layout', __( 'Default Layout', 'genesis' ), array( $this, 'layout_box' ), $this->pagehook, 'main' );

		if ( ! current_theme_supports( 'genesis-custom-header' ) && ! current_theme_supports( 'custom-header' ) )
			add_meta_box( 'genesis-theme-settings-header', __( 'Header', 'genesis' ), array( $this, 'header_box' ), $this->pagehook, 'main' );

		if ( current_theme_supports( 'genesis-menus' ) )
			add_meta_box( 'genesis-theme-settings-nav', __( 'Navigation', 'genesis' ), array( $this, 'nav_box' ), $this->pagehook, 'main' );

		if ( current_theme_supports( 'genesis-breadcrumbs' ) )
			add_meta_box( 'genesis-theme-settings-breadcrumb', __( 'Breadcrumbs', 'genesis' ), array( $this, 'breadcrumb_box' ), $this->pagehook, 'main' );

		add_meta_box( 'genesis-theme-settings-comments', __( 'Comments and Trackbacks', 'genesis' ), array( $this, 'comments_box' ), $this->pagehook, 'main' );
		add_meta_box( 'genesis-theme-settings-posts', __( 'Content Archives', 'genesis' ), array( $this, 'post_archives_box' ), $this->pagehook, 'main' );
		add_meta_box( 'genesis-theme-settings-blogpage', __( 'Blog Page Template', 'genesis' ), array( $this, 'blogpage_box' ), $this->pagehook, 'main' );

		if ( current_user_can( 'unfiltered_html' ) )
			add_meta_box( 'genesis-theme-settings-scripts', __( 'Header and Footer Scripts', 'genesis' ), array( $this, 'scripts_box' ), $this->pagehook, 'main' );

		do_action( 'genesis_theme_settings_metaboxes', $this->pagehook );

	}

	/**
	 * Echo hidden form fields before the metaboxes.
	 *
	 * @since 1.8.0
	 *
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @param string $pagehook Page hook.
	 *
	 * @return null Returns early if not on the right page.
	 */
	function hidden_fields( $pagehook ) {

		if ( $pagehook != $this->pagehook )
			return;

		printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'theme_version' ), esc_attr( $this->get_field_value( 'theme_version' ) ) );
		printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'db_version' ), esc_attr( $this->get_field_value( 'db_version' ) ) );

	}

	/**
	 * Callback for Theme Settings Information meta box.
	 *
	 * If genesis-auto-updates is not supported, some of the fields will not display.
	 *
	 * @since 1.0.0
	 *
	 * @uses PARENT_THEME_RELEASE_DATE         Date of current release of Genesis Framework.
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function info_box() {

		?>
		<p><strong><?php _e( 'Version:', 'genesis' ); ?></strong> <?php echo $this->get_field_value( 'theme_version' ); ?> &#x000B7; <strong><?php _e( 'Released:', 'genesis' ); ?></strong> <?php echo PARENT_THEME_RELEASE_DATE; ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_info' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'show_info' ); ?>" id="<?php echo $this->get_field_id( 'show_info' ); ?>" value="1"<?php checked( $this->get_field_value( 'show_info' ) ); ?> />
			<?php _e( 'Display Theme Information in your document source', 'genesis' ); ?></label>
		</p>

		<?php if ( current_theme_supports( 'genesis-auto-updates' ) ) : ?>
		<p><span class="description"><?php sprintf( __( 'This can be helpful for diagnosing problems with your theme when seeking assistance in the <a href="%s" target="_blank">support forums</a>.', 'genesis' ), 'http://www.studiopress.com/support/' ); ?></span></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'update' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'update' ); ?>" id="<?php echo $this->get_field_id( 'update' ); ?>" value="1"<?php checked( $this->get_field_value( 'update' ) ) . disabled( is_super_admin(), 0 ); ?> />
			<?php _e( 'Enable Automatic Updates', 'genesis' ); ?></label>
		</p>

		<div id="genesis_update_notification_setting">
			<p>
				<label for="<?php echo $this->get_field_id( 'update_email' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'update_email' ); ?>" id="<?php echo $this->get_field_id( 'update_email' ); ?>" value="1"<?php checked( $this->get_field_value( 'update_email' ) ) . disabled( is_super_admin(), 0 ); ?> />
				<?php _e( 'Notify', 'genesis' ); ?></label>
				<input type="text" name="<?php echo $this->get_field_name( 'update_email_address' ); ?>" id="<?php echo $this->get_field_id( 'update_email_address' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'update_email_address' ) ); ?>" size="30"<?php disabled( 0, is_super_admin() ); ?> />
				<label for="<?php echo $this->get_field_id( 'update_email_address' ); ?>"><?php _e( 'when updates are available', 'genesis' ); ?></label>
			</p>

			<p><span class="description"><?php _e( 'If you provide an email address above, your blog can email you when a new version of Genesis is available.', 'genesis' ); ?></span></p>
		</div>
		<?php
		endif;

	}

	/**
	 * Callback for Theme Settings Color Style meta box.
	 *
	 * The style selector can be enabled and populated by adding an associated array of style => title when initiating
	 * support for genesis-style-selector in the child theme functions.php file.
	 *
	 * <code>
	 * $color_styles = array(
	 *     'childtheme-red'   => __( 'Red', 'childthemedomain' ),
	 *     'childtheme-green' => __( 'Green', 'childthemedomain' ),
	 *     'childtheme-blue'  => __( 'Blue', 'childthemedomain' ),
	 * );
	 * add_theme_support( 'genesis-style-selector', $color_styles );
	 * </code>
	 *
	 * When selected, the style will be added as a body class which can be used within style.css to target elements
	 * when using a specific style.
	 *
	 * <code>
	 * h1 { background: #000; }
	 * .childtheme-red h1 { background: #0ff; }
	 * </code>
	 *
	 * @since 1.8.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function style_box() {

		$current = $this->get_field_value( 'style_selection' );
		$styles  = get_theme_support( 'genesis-style-selector' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'style_selection' ); ?>"><?php _e( 'Color Style:', 'genesis' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'style_selection' ); ?>" id="<?php echo $this->get_field_id( 'style_selection' ); ?>">
				<option value=""><?php _e( 'Default', 'genesis' ); ?></option>
				<?php
				if ( ! empty( $styles ) ) {
					$styles = array_shift( $styles );
					foreach ( (array) $styles as $style => $title ) {
						?><option value="<?php echo esc_attr( $style ); ?>"<?php selected( $current, $style ); ?>><?php echo esc_html( $title ); ?></option><?php
					}
				}
				?>
			</select>
		</p>

		<p><span class="description"><?php _e( 'Please select the color style from the drop down list and save your settings.', 'genesis' ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Default Layout meta box.
	 *
	 * A version of a site layout setting has been in Genesis since at least 0.2.0, but it was moved to its own meta box
	 * in 1.7.0.
	 *
	 * @since 1.7.0
	 *
	 * @uses genesis_layout_selector()         Outputs form elements for layout selector.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function layout_box() {

		?>
		<p class="genesis-layout-selector">
		<?php
		genesis_layout_selector( array( 'name' => $this->get_field_name( 'site_layout' ), 'selected' => $this->get_field_value( 'site_layout' ), 'type' => 'site' ) );
		?>
		</p>

		<br class="clear" />
		<?php

	}

	/**
	 * Callback for Theme Settings Header meta box.
	 *
	 * @since 1.7.0
	 *
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function header_box() {
		?>

		<p><?php _e( 'Use for site title/logo:', 'genesis' ); ?>
			<select name="<?php echo $this->get_field_name( 'blog_title' ); ?>">
				<option value="text"<?php selected( $this->get_field_value( 'blog_title' ), 'text' ); ?>><?php _e( 'Dynamic text', 'genesis' ); ?></option>
				<option value="image"<?php selected( $this->get_field_value( 'blog_title' ), 'image' ); ?>><?php _e( 'Image logo', 'genesis' ); ?></option>
			</select>
		</p>

		<?php

	}

	/**
	 * Callback for Theme Settings Navigation Settings meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses genesis_nav_menu_supported()      Determine if a child theme supports a particular Genesis nav menu.
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function nav_box() {

		if ( genesis_nav_menu_supported( 'primary' ) ) : ?>

		<h4><?php _e( 'Primary Navigation Extras', 'genesis' ); ?></h4>

		<?php if ( ! has_nav_menu( 'primary' ) ) : ?>

		<p><span class="description"><?php printf( __( 'In order to view the %1$s navigation menu settings, you must build a <a href="%2$s">custom menu</a>, then assign it to the %1$s Menu Location.', 'genesis' ), 'Primary', admin_url( 'nav-menus.php' ) ); ?></span></p>

		<?php else : ?>

		<div id="genesis_nav_extras_settings">
			<p>
				<label for="<?php echo $this->get_field_id( 'nav_extras' ); ?>"><?php _e( 'Display the following:', 'genesis' ); ?></label>
				<select name="<?php echo $this->get_field_name( 'nav_extras' ); ?>" id="<?php echo $this->get_field_id( 'nav_extras' ); ?>">
					<option value=""><?php _e( 'None', 'genesis' ) ?></option>
					<option value="date"<?php selected( $this->get_field_value( 'nav_extras' ), 'date' ); ?>><?php _e( 'Today\'s date', 'genesis' ); ?></option>
					<option value="rss"<?php selected( $this->get_field_value( 'nav_extras' ), 'rss' ); ?>><?php _e( 'RSS feed links', 'genesis' ); ?></option>
					<option value="search"<?php selected( $this->get_field_value( 'nav_extras' ), 'search' ); ?>><?php _e( 'Search form', 'genesis' ); ?></option>
					<option value="twitter"<?php selected( $this->get_field_value( 'nav_extras' ), 'twitter' ); ?>><?php _e( 'Twitter link', 'genesis' ); ?></option>
				</select>
			</p>
			<div id="genesis_nav_extras_twitter">
				<p>
					<label for="<?php echo $this->get_field_id( 'nav_extras_twitter_id' ); ?>"><?php _e( 'Enter Twitter ID:', 'genesis' ); ?></label>
					<input type="text" name="<?php echo $this->get_field_name( 'nav_extras_twitter_id' ); ?>" id="<?php echo $this->get_field_id( 'nav_extras_twitter_id' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'nav_extras_twitter_id' ) ); ?>" size="27" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id( 'nav_extras_twitter_text' ); ?>"><?php _e( 'Twitter Link Text:', 'genesis' ); ?></label>
					<input type="text" name="<?php echo $this->get_field_name( 'nav_extras_twitter_text' ); ?>" id="<?php echo $this->get_field_id( 'nav_extras_twitter_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'nav_extras_twitter_text' ) ); ?>" size="27" />
				</p>
			</div>
		</div>
		<?php
		endif;
		endif;
	}

	/**
	 * Callback for Theme Settings Custom Feeds meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function feeds_box() {

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'feed_uri' ); ?>"><?php _e( 'Enter your custom feed URI:', 'genesis' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'feed_uri' ); ?>" id="<?php echo $this->get_field_id( 'feed_uri' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'feed_uri' ) ); ?>" size="50" />

			<label for="<?php echo $this->get_field_id( 'redirect_feed' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'redirect_feed' ); ?>" id="<?php echo $this->get_field_id( 'redirect_feed' ); ?>" value="1"<?php checked( $this->get_field_value( 'redirect_feed' ) ); ?> />
			<?php _e( 'Redirect Feed?', 'genesis' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comments_feed_uri' ); ?>"><?php _e( 'Enter your custom comments feed URI:', 'genesis' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'comments_feed_uri' ); ?>" id="<?php echo $this->get_field_id( 'comments_feed_uri' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'comments_feed_uri' ) ); ?>" size="50" />

			<label for="<?php echo $this->get_field_id( 'redirect_comments_feed' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'redirect_comments_feed' ); ?>" id="<?php echo $this->get_field_id( 'redirect_comments_feed' ); ?>" value="1"<?php checked( $this->get_field_value( 'redirect_comments__feed' ) ); ?> />
			<?php _e( 'Redirect Feed?', 'genesis' ); ?></label>
		</p>

		<p><span class="description"><?php printf( __( 'If your custom feed(s) are not handled by Feedburner, we do not recommend that you use the redirect options.', 'genesis' ) ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Comments meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function comments_box() {

		?>
		<p>
			<?php _e( 'Enable Comments', 'genesis' ); ?>
			<label for="<?php echo $this->get_field_id( 'comments_posts' ); ?>" title="Enable comments on posts"><input type="checkbox" name="<?php echo $this->get_field_name( 'comments_posts' ); ?>" id="<?php echo $this->get_field_id( 'comments_posts' ); ?>" value="1"<?php checked( $this->get_field_value( 'comments_posts' ) ); ?> />
			<?php _e( 'on posts?', 'genesis' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'comments_pages' ); ?>" title="Enable comments on pages"><input type="checkbox" name="<?php echo $this->get_field_name( 'comments_pages' ); ?>" id="<?php echo $this->get_field_id( 'comments_pages' ); ?>" value="1"<?php checked( $this->get_field_value( 'comments_pages' ) ); ?> />
			<?php _e( 'on pages?', 'genesis' ); ?></label>
		</p>

		<p>
			<?php _e( 'Enable Trackbacks', 'genesis' ); ?>
			<label for="<?php echo $this->get_field_id( 'trackbacks_posts' ); ?>" title="Enable trackbacks on posts"><input type="checkbox" name="<?php echo $this->get_field_name( 'trackbacks_posts' ); ?>" id="<?php echo $this->get_field_id( 'trackbacks_posts' ); ?>" value="1"<?php checked( $this->get_field_value( 'trackbacks_posts' ) ); ?> />
			<?php _e( 'on posts?', 'genesis' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'trackbacks_pages' ); ?>" title="Enable trackbacks on pages"><input type="checkbox" name="<?php echo $this->get_field_name( 'trackbacks_pages' ); ?>" id="<?php echo $this->get_field_id( 'trackbacks_pages' ); ?>" value="1"<?php checked( $this->get_field_value( 'trackbacks_pages' ) ); ?> />
			<?php _e( 'on pages?', 'genesis' ); ?></label>
		</p>

		<p><span class="description"><?php _e( 'Comments and Trackbacks can also be disabled on a per post/page basis when creating/editing posts/pages.', 'genesis' ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Custom Feeds meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function breadcrumb_box() {

		?>
		<h4><?php _e( 'Enable on:', 'genesis' ); ?></h4>
		<p>
			<?php if ( 'page' == get_option( 'show_on_front' ) ) : ?>
				<label for="<?php echo $this->get_field_id( 'breadcrumb_front_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_front_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_front_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_front_page' ) ); ?> />
				<?php _e( 'Front Page', 'genesis' ); ?></label>

				<label for="<?php echo $this->get_field_id( 'breadcrumb_posts_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_posts_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_posts_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_posts_page' ) ); ?> />
				<?php _e( 'Posts Page', 'genesis' ); ?></label>
			<?php else : ?>
				<label for="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_home' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_home' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_home' ) ); ?> />
				<?php _e( 'Homepage', 'genesis' ); ?></label>
			<?php endif; ?>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_single' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_single' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_single' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_single' ) ); ?> />
			<?php _e( 'Posts', 'genesis' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_page' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_page' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_page' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_page' ) ); ?> />
			<?php _e( 'Pages', 'genesis' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_archive' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_archive' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_archive' ) ); ?> />
			<?php _e( 'Archives', 'genesis' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_404' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_404' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_404' ) ); ?> />
			<?php _e( '404 Page', 'genesis' ); ?></label>

			<label for="<?php echo $this->get_field_id( 'breadcrumb_attachment' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'breadcrumb_attachment' ); ?>" id="<?php echo $this->get_field_id( 'breadcrumb_attachment' ); ?>" value="1"<?php checked( $this->get_field_value( 'breadcrumb_attachment' ) ); ?> />
			<?php _e( 'Attachment Page', 'genesis' ); ?></label>
		</p>

		<p><span class="description"><?php _e( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on certain areas of your site.', 'genesis' ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Post Archives meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses genesis_get_images_sizes()        Retrieve list of registered image sizes.
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function post_archives_box() {

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'content_archive' ); ?>"><?php _e( 'Select one of the following:', 'genesis' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'content_archive' ); ?>" id="<?php echo $this->get_field_id( 'content_archive' ); ?>">
			<?php
			$archive_display = apply_filters(
				'genesis_archive_display_options',
				array(
					'full'     => __( 'Display post content', 'genesis' ),
					'excerpts' => __( 'Display post excerpts', 'genesis' ),
				)
			);
			foreach ( (array) $archive_display as $value => $name )
				echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->get_field_value( 'content_archive' ), esc_attr( $value ), false ) . '>' . esc_html( $name ) . '</option>' . "\n";
			?>
			</select>
		</p>

		<div id="genesis_content_limit_setting">
			<p>
				<label for="<?php echo $this->get_field_id( 'content_archive_limit' ); ?>"><?php _e( 'Limit content to', 'genesis' ); ?>
				<input type="text" name="<?php echo $this->get_field_name( 'content_archive_limit' ); ?>" id="<?php echo $this->get_field_id( 'content_archive_limit' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'content_archive_limit' ) ); ?>" size="3" />
				<?php _e( 'characters', 'genesis' ); ?></label>
			</p>

			<p><span class="description"><?php _e( 'Using this option will limit the text and strip all formatting from the text displayed. To use this option, choose "Display post content" in the select box above.', 'genesis' ); ?></span></p>
		</div>

		<p>
			<label for="<?php echo $this->get_field_id( 'content_archive_thumbnail' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'content_archive_thumbnail' ); ?>" id="<?php echo $this->get_field_id( 'content_archive_thumbnail' ); ?>" value="1"<?php checked( $this->get_field_value( 'content_archive_thumbnail' ) ); ?> />
			<?php _e( 'Include the Featured Image?', 'genesis' ); ?></label>
		</p>

		<p id="genesis_image_size">
			<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size:', 'genesis' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'image_size' ); ?>" id="<?php echo $this->get_field_id( 'image_size' ); ?>">
			<?php
			$sizes = genesis_get_image_sizes();
			foreach ( (array) $sizes as $name => $size )
				echo '<option value="' . esc_attr( $name ) . '"' . selected( $this->get_field_value( 'image_size' ), $name, FALSE ) . '>' . esc_html( $name ) . ' (' . absint( $size['width'] ) . ' &#x000D7; ' . absint( $size['height'] ) . ')</option>' . "\n";
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_nav' ); ?>"><?php _e( 'Select Post Navigation Technique:', 'genesis' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'posts_nav' ); ?>" id="<?php echo $this->get_field_id( 'posts_nav' ); ?>">
				<option value="older-newer"<?php selected( 'older-newer', $this->get_field_value( 'posts_nav' ) ); ?>><?php _e( 'Older / Newer', 'genesis' ); ?></option>
				<option value="prev-next"<?php selected( 'prev-next', $this->get_field_value( 'posts_nav' ) ); ?>><?php _e( 'Previous / Next', 'genesis' ); ?></option>
				<option value="numeric"<?php selected( 'numeric', $this->get_field_value( 'posts_nav' ) ); ?>><?php _e( 'Numeric', 'genesis' ); ?></option>
			</select>
		</p>

		<p><span class="description"><?php _e( 'These options will affect any blog listings page, including archive, author, blog, category, search, and tag pages.', 'genesis' ); ?></span></p>
		<?php

	}

	/**
	 * Callback for Theme Settings Blog page template meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function blogpage_box() {

		?>
		<p><span class="description"><?php _e( 'These settings apply to any page given the "Blog" page template, not the homepage or post archive pages.', 'genesis' ); ?></span></p>

		<hr class="div" />

		<p>
			<label for="<?php echo $this->get_field_id( 'blog_cat' ); ?>"><?php _e( 'Display which category:', 'genesis' ); ?></label>
			<?php wp_dropdown_categories( array( 'selected' => $this->get_field_value( 'blog_cat' ), 'name' => $this->get_field_name( 'blog_cat' ), 'orderby' => 'Name', 'hierarchical' => 1, 'show_option_all' => __( 'All Categories', 'genesis' ), 'hide_empty' => '0' ) ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'blog_cat_exclude' ); ?>"><?php _e( 'Exclude the following Category IDs:', 'genesis' ); ?><br />
				<input type="text" name="<?php echo $this->get_field_name( 'blog_cat_exclude' ); ?>" id="<?php echo $this->get_field_id( 'blog_cat_exclude' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'blog_cat_exclude' ) ); ?>" size="40" />
				<br /><small><strong><?php _e( 'Comma separated - 1,2,3 for example', 'genesis' ); ?></strong></small>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'blog_cat_num' ); ?>"><?php _e( 'Number of Posts to Show:', 'genesis' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'blog_cat_num' ); ?>" id="<?php echo $this->get_field_id( 'blog_cat_num' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'blog_cat_num' ) ); ?>" size="2" />
		</p>
		<?php

	}

	/**
	 * Callback for Theme Settings Header / Footer Scripts meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_Settings::metaboxes() Register meta boxes on the Theme Settings page.
	 */
	function scripts_box() {

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'header_scripts' ); ?>"><?php printf( __( 'Enter scripts or code you would like output to %s:', 'genesis' ), '<code>wp_head()</code>' ); ?></label>
		</p>

		<textarea name="<?php echo $this->get_field_name( 'header_scripts' ); ?>" id="<?php echo $this->get_field_id( 'header_scripts' ); ?>" cols="78" rows="8"><?php echo esc_textarea( $this->get_field_value( 'header_scripts' ) ); ?></textarea>

		<p><span class="description"><?php printf( __( 'The %1$s hook executes immediately before the closing %2$s tag in the document source.', 'genesis' ), '<code>wp_head()</code>', '<code>&lt;/head&gt;</code>' ); ?></span></p>

		<hr class="div" />

		<p>
			<label for="<?php echo $this->get_field_id( 'footer_scripts' ); ?>"><?php printf( __( 'Enter scripts or code you would like output to %s:', 'genesis' ), '<code>wp_footer()</code>' ); ?></label>
		</p>

		<textarea name="<?php echo $this->get_field_name( 'footer_scripts' ); ?>" id="<?php echo $this->get_field_id( 'footer_scripts' ); ?>" cols="78" rows="8"><?php echo esc_textarea( $this->get_field_value( 'footer_scripts' ) ); ?></textarea>

		<p><span class="description"><?php printf( __( 'The %1$s hook executes immediately before the closing %2$s tag in the document source.', 'genesis' ), '<code>wp_footer()</code>', '<code>&lt;/body&gt;</code>' ); ?></span></p>
		<?php

	}

}
