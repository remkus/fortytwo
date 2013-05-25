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
 * Registers a new admin page, providing content and corresponding menu item for the SEO Settings page.
 *
 * Although this class was added in 1.8.0, some of the methods were originally standalone functions added in previous
 * versions of Genesis.
 *
 * @package Genesis\Admin
 *
 * @since 1.8.0
 */
class Genesis_Admin_SEO_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.8.0
	 *
	 * @uses GENESIS_SEO_SETTINGS_FIELD Settings field key.
	 * @uses \Genesis_Admin::create()   Create an admin menu item and settings page.
	 */
	function __construct() {

		$page_id = 'seo-settings';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Genesis - SEO Settings', 'genesis' ),
				'menu_title'  => __( 'SEO Settings', 'genesis' )
			)
		);

		$page_ops = array(
			'screen_icon'       => 'options-general',
			'save_button_text'  => __( 'Save Settings', 'genesis' ),
			'reset_button_text' => __( 'Reset Settings', 'genesis' ),
			'saved_notice_text' => __( 'Settings saved.', 'genesis' ),
			'reset_notice_text' => __( 'Settings reset.', 'genesis' ),
			'error_notice_text' => __( 'Error saving settings.', 'genesis' ),
		);

		$settings_field = GENESIS_SEO_SETTINGS_FIELD;

		$default_settings = apply_filters(
			'genesis_seo_settings_defaults',
			array(
				'append_description_home'      => 1,
				'append_site_title'            => 0,
				'doctitle_sep'                 => '–',
				'doctitle_seplocation'         => 'right',

				'semantic_headings'            => 1,
				'home_h1_on'                   => 'title',
				'home_doctitle'                => '',
				'home_description'             => '',
				'home_keywords'                => '',
				'home_noindex'                 => 0,
				'home_nofollow'                => 0,
				'home_noarchive'               => 0,
				'home_author'                  => 0,

				'canonical_archives'           => 1,

				'head_adjacent_posts_rel_link' => 0,
				'head_wlwmanifest_link'        => 0,
				'head_shortlink'               => 0,

				'noindex_cat_archive'          => 1,
				'noindex_tag_archive'          => 1,
				'noindex_author_archive'       => 1,
				'noindex_date_archive'         => 1,
				'noindex_search_archive'       => 1,
				'noarchive_cat_archive'        => 0,
				'noarchive_tag_archive'        => 0,
				'noarchive_author_archive'     => 0,
				'noarchive_date_archive'       => 0,
				'noarchive_search_archive'     => 0,
				'noarchive'                    => 0,
				'noodp'                        => 1,
				'noydir'                       => 1,
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
				'append_description_home',
				'append_site_title',
				'home_noindex',
				'home_nofollow',
				'home_noarchive',
				'head_index_rel_link',
				'head_parent_post_rel_link',
				'head_start_post_rel_link',
				'head_adjacent_posts_rel_link',
				'head_wlwmanifest_link',
				'head_shortlink',
				'noindex_cat_archive',
				'noindex_tag_archive',
				'noindex_author_archive',
				'noindex_date_archive',
				'noindex_search_archive',
				'noarchive',
				'noarchive_cat_archive',
				'noarchive_tag_archive',
				'noarchive_author_archive',
				'noarchive_date_archive',
				'noarchive_search_archive',
				'noodp',
				'noydir',
				'canonical_archives',
			)
		);

		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'home_doctitle',
				'home_description',
				'home_keywords',
				'doctitle_sep',
			)
		);

	}

	function help() {

		$screen = get_current_screen();
		
		if ( $screen->id != $this->pagehook )
			return;
		
		$seo_settings_help =
			'<h3>' . __( 'SEO Settings' , 'genesis' ) . '</h3>' .		
			'<p>' .  __( 'Genesis SEO (search engine optimization) is polite, and will disable itself when most popular SEO plugins (e.g., All-in-One SEO, WordPress SEO, etc.) are active.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'If you don’t see an SEO Settings sub menu, then you probably have another SEO plugin active.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'If you see the menu, then opening that menu item will let you set the General SEO settings for your site.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'Each page, post, and term will have its own SEO settings as well. The default settings are recommended for most users. If you wish to adjust your SEO settings, the boxes include internal descriptions.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'Below you\'ll find a few succinct notes on the options for each box:' , 'genesis' ) . '</p>';
		
		$doctitle_help =
			'<h3>' . __( 'Doctitle Settings' , 'genesis' ) . '</h3>' .		
			'<p>' .  __( '<strong>Append Site Description</strong> will insert the site description from your General Settings after the title on your home page.' , 'genesis' ) . '</p>' .
			'<p>' .  __( '<strong>Append Site Name</strong> will put the site name from the General Settings after the title on inner page.' , 'genesis' ) . '</p>' .
			'<p>' .  __( '<strong>Doctitle Append Location</strong> determines which side of the title to add the previously mentioned items.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'The <strong>Doctitle Separator</strong> is the character that will go between the title and appended text.' , 'genesis' ) . '</p>';
		
		$homepage_help =
			'<h3>' . __( 'Homepage Settings' , 'genesis' ) . '</h3>' .		
			'<p>' .  __( 'These are the homepage specific SEO settings. Note: these settings will not apply if a static page is set as the front page. If you\'re using a static WordPress page as your hompage, you\'ll need to set the SEO settings on that particular page.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'You can also specify if the Site Title, Description, or your own custom text should be wrapped in an &lt;h1&gt; tag (the primary heading in HTML).' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'To add custom text you\'ll have to either edit a php file, or use a text widget on a widget enabled homepage.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'The home doctitle sets what will appear within the <title></title> tags (unseen in the browser) for the home page.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'The home META description and keywords fill in the meta tags for the home page. The META description is the short text blurb that appear in search engine results.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'Most search engines do not use Keywords at this time or give them very little consideration; however, it\'s worth using in case keywords are given greater consideration in the future and also to help guide your content. If the content doesn’t match with your targeted key words, then you may need to consider your content more carefully.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'The Homepage Robots Meta Tags tell search engines how to handle the homepage. Noindex means not to index the page at all, and it will not appear in search results. Nofollow means do not follow any links from this page and noarchive tells them not to make an archive copy of the page.' , 'genesis' ) . '</p>';
		
		$dochead_help =
			'<h3>' . __( 'Document Head Settings' , 'genesis' ) . '</h3>' .		
			'<p>' .  __( 'The Relationship Link Tags are tags added by WordPress that currently have no SEO value but slow your site load down. They\'re disabled by default, but if you have a specific need&#8212;for a plugin or other non typical use&#8212;then you can enable as needed here.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'You can also add support for Windows Live Writer if you use software that supports this and include a shortlink tag if this is required by any third party service.' , 'genesis' ) . '</p>';
		
		$robots_help =
			'<h3>' . __( 'Robots Meta Settings' , 'genesis' ) . '</h3>' .		
			'<p>' .  __( 'Noarchive and noindex are explained in the home settings. Here you can select what other parts of the site to apply these options to.' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'At least one archive should be indexed, but indexing multiple archives will typically result in a duplicate content penalization (multiple pages with identical content look manipulative to search engines).' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'For most sites either the home page or blog page (using the blog template) will serve as this index which is why the default is not to index categories, tags, authors, dates, or searches.' , 'genesis' ) . '</p>';
		
		$seoarchives_help =
			'<h3>' . __( 'Archives Settings' , 'genesis' ) . '</h3>' .		
			'<p>' .  __( 'Canonical links will point search engines to the front page of paginated content (search engines have to choose the “preferred link” when there is duplicate content on pages).' , 'genesis' ) . '</p>' .
			'<p>' .  __( 'This tells them “this is paged content and the first page starts here” and helps to avoid spreading keywords across multiple pages.' , 'genesis' ) . '</p>';
		
		$screen->add_help_tab( array(
			'id'	=> $this->pagehook . '-seo-settings',
			'title'	=> __( 'SEO Settings' , 'genesis' ),
			'content'	=> $seo_settings_help,
		) );
		$screen->add_help_tab( array(
			'id'	=> $this->pagehook . '-doctitle',
			'title'	=> __( 'Doctitle Settings' , 'genesis' ),
			'content'	=> $doctitle_help,
		) );
		$screen->add_help_tab( array(
			'id'	=> $this->pagehook . '-homepage',
			'title'	=> __( 'Homepage Settings' , 'genesis' ),
			'content'	=> $homepage_help,
		) );
		$screen->add_help_tab( array(
			'id'	=> $this->pagehook . '-dochead',
			'title'	=> __( 'Document Head Settings' , 'genesis' ),
			'content'	=> $dochead_help,
		) );
		$screen->add_help_tab( array(
			'id'	=> $this->pagehook . '-robots',
			'title'	=> __( 'Robots Meta Settings' , 'genesis' ),
			'content'	=> $robots_help,
		) );
		$screen->add_help_tab( array(
			'id'	=> $this->pagehook . '-seo-archives',
			'title'	=> __( 'SEO Archives' , 'genesis' ),
			'content'	=> $seoarchives_help,
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
 	 * Register meta boxes on the SEO Settings page.
 	 *
 	 * @since 1.0.0
 	 *
 	 * @see \Genesis_Admin_SEO_Settings::doctitle_box()      Callback for document title box.
 	 * @see \Genesis_Admin_SEO_Settings::homepage_box()      Callback for home page box.
 	 * @see \Genesis_Admin_SEO_Settings::document_head_box() Callback for document head box.
 	 * @see \Genesis_Admin_SEO_Settings::robots_meta_box()   Callback for robots meta box.
 	 * @see \Genesis_Admin_SEO_Settings::archives_box()      Callback for archives box.
 	 */
	function metaboxes() {

		add_meta_box( 'genesis-seo-settings-doctitle', __( 'Document Title Settings', 'genesis' ), array( $this, 'doctitle_box' ), $this->pagehook, 'main' );
		add_meta_box( 'genesis-seo-settings-homepage', __( 'Homepage Settings', 'genesis' ), array( $this, 'homepage_box' ), $this->pagehook, 'main' );
		add_meta_box( 'genesis-seo-settings-dochead', __( 'Document Head Settings', 'genesis' ), array( $this, 'document_head_box' ), $this->pagehook, 'main' );
		add_meta_box( 'genesis-seo-settings-robots', __( 'Robots Meta Settings', 'genesis' ), array( $this, 'robots_meta_box' ), $this->pagehook, 'main' );
		add_meta_box( 'genesis-seo-settings-archives', __( 'Archives Settings', 'genesis' ), array( $this, 'archives_box' ), $this->pagehook, 'main' );

	}

	/**
	 * Callback for SEO Settings Document Title meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_SEO_Settings::metaboxes() Register meta boxes on the SEO Settings page.
	 */
	function doctitle_box() {

		?>
		<p><span class="description"><?php printf( __( 'The document title (%s) is the single most important element in your document source for <abbr title="Search engine optimization">SEO</abbr>. It succinctly informs search engines of what information is contained in the document. The title can, and should, be different on each page, but these options will help you control what it will look like by default.', 'genesis' ), '<code>&lt;title&gt;</code>' ); ?></span></p>

		<p><span class="description"><?php _e( '<strong>By default</strong>, the home page document title will contain the site title, the single post and page document titles will contain the post or page title, the archive pages will contain the archive type, etc.', 'genesis' ); ?></span></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'append_description_home' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'append_description_home' ); ?>" id="<?php echo $this->get_field_id( 'append_description_home' ); ?>" value="1" <?php checked( $this->get_field_value( 'append_description_home' ) ); ?> />
			<?php printf( __( 'Add site description (tagline) to %s on home page?', 'genesis' ), '<code>&lt;title&gt;</code>' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'append_site_title' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'append_site_title' ); ?>" id="<?php echo $this->get_field_id( 'append_site_title' ); ?>" value="1" <?php checked( $this->get_field_value( 'append_site_title' ) ); ?> />
			<?php printf( __( 'Add site name to %s on inner pages?', 'genesis' ), '<code>&lt;title&gt;</code>' ); ?> </label>
		</p>

		<fieldset>
			<legend><?php _e( 'Document Title Additions Location:', 'genesis' ); ?></legend>
			<span class="description"><?php _e( 'Determines which side the added title text will go on.', 'genesis' ); ?></span>

			<p>
				<input type="radio" name="<?php echo $this->get_field_name( 'doctitle_seplocation' ); ?>" id="<?php echo $this->get_field_id( 'doctitle_seplocation_left' ); ?>" value="left" <?php checked( $this->get_field_value( 'doctitle_seplocation' ), 'left' ); ?> />
				<label for="<?php echo $this->get_field_id( 'doctitle_seplocation_left' ); ?>"><?php _e( 'Left', 'genesis' ); ?></label>
				<br />
				<input type="radio" name="<?php echo $this->get_field_name( 'doctitle_seplocation' ); ?>" id="<?php echo $this->get_field_id( 'doctitle_seplocation_right' ); ?>" value="right" <?php checked( $this->get_field_value( 'doctitle_seplocation' ), 'right' ); ?> />
				<label for="<?php echo $this->get_field_id( 'doctitle_seplocation_right' ); ?>"><?php _e( 'Right', 'genesis' ); ?></label>
			</p>
		</fieldset>

		<p>
			<label for="<?php echo $this->get_field_id( 'doctitle_sep' ); ?>"><?php _e( 'Document Title Separator:', 'genesis' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'doctitle_sep' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'doctitle_sep' ) ); ?>" size="15" /><br />
			<span class="description"><?php _e( 'If the title consists of two parts (original title and optional addition), then the separator will go in between them.', 'genesis' ); ?></span>
		</p>

		<?php

	}

	/**
	 * Callback for SEO Settings Home Page meta box.
	 *
	 * @since 1.0.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_SEO_Settings::metaboxes() Register meta boxes on the SEO Settings page.
	 */
	function homepage_box() {

		if ( current_theme_supports( 'genesis-html5' ) ) : ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'semantic_headings' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'semantic_headings' ); ?>" id="<?php echo $this->get_field_id( 'semantic_headings' ); ?>" value="1" <?php checked( $this->get_field_value( 'semantic_headings' ) ); ?> />
			<?php _e( 'Use semantic HTML5 page and section headings?', 'genesis' ); ?></label>
		</p>
		
		<p><span class="description"><?php printf( __( 'HTML5 allows for multiple %s tags throughout the document source, provided they are the primary title for the section in which they appear. However, following this standard may have a marginal negative impact on SEO.', 'genesis' ), '<code>&lt;h1&gt;</code>' ); ?></span></p>

		<?php endif; ?>

		<fieldset <?php echo current_theme_supports( 'genesis-html5' ) ? 'id="genesis_seo_h1_wrap"' : '';?>>
			<legend><?php printf( __( 'Which text would you like to be wrapped in %s tags?', 'genesis' ), '<code>&lt;h1&gt;</code>' ); ?></legend>

			<p>
				<input type="radio" name="<?php echo $this->get_field_name( 'home_h1_on' ); ?>" id="<?php echo $this->get_field_id( 'home_h1_on_title' ); ?>" value="title" <?php checked( $this->get_field_value( 'home_h1_on' ), 'title' ); ?> />
				<label for="<?php echo $this->get_field_id( 'home_h1_on_title' ); ?>"><?php _e( 'Site Title', 'genesis' ); ?></label>
				<br />
				<input type="radio" name="<?php echo $this->get_field_name( 'home_h1_on' ); ?>" id="<?php echo $this->get_field_id( 'home_h1_on_description' ); ?>" value="description" <?php checked( $this->get_field_value( 'home_h1_on' ), 'description' ); ?> />
				<label for="<?php echo $this->get_field_id( 'home_h1_on_description' ); ?>"><?php _e( 'Site Description (Tagline)', 'genesis' ); ?></label>
				<br />
				<input type="radio" name="<?php echo $this->get_field_name( 'home_h1_on' ); ?>" id="<?php echo $this->get_field_id( 'home_h1_on_neither' ); ?>" value="neither" <?php checked( $this->get_field_value( 'home_h1_on' ), 'neither' ); ?> />
				<label for="<?php echo $this->get_field_id( 'home_h1_on_neither' ); ?>"><?php _e( 'Neither. I\'ll manually wrap my own text on the homepage', 'genesis' ); ?></label>
			</p>
		</fieldset>

		<p>
			<label for="<?php echo $this->get_field_id( 'home_doctitle' ); ?>"><?php _e( 'Homepage Document Title:', 'genesis' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'home_doctitle' ); ?>" id="<?php echo $this->get_field_id( 'home_doctitle' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'home_doctitle' ) ); ?>" size="80" /><br />
			<span class="description"><?php _e( 'If you leave the document title field blank, your site&#8217;s title will be used instead.', 'genesis' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'home_description' ); ?>"><?php _e( 'Home Meta Description:', 'genesis' ); ?></label><br />
			<textarea name="<?php echo $this->get_field_name( 'home_description' ); ?>" id="<?php echo $this->get_field_id( 'home_description' ); ?>" rows="3" cols="70"><?php echo esc_textarea( $this->get_field_value( 'home_description' ) ); ?></textarea><br />
			<span class="description"><?php _e( 'The meta description can be used to determine the text used under the title on search engine results pages.', 'genesis' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'home_keywords' ); ?>"><?php _e( 'Home Meta Keywords (comma separated):', 'genesis' ); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name( 'home_keywords' ); ?>" id="<?php echo $this->get_field_id( 'home_keywords' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'home_keywords' ) ); ?>" size="80" /><br />
			<span class="description"><?php _e( 'Keywords are generally ignored by Search Engines.', 'genesis' ); ?></span>
		</p>

		<h4><?php _e( 'Homepage Robots Meta Tags:', 'genesis' ); ?></h4>

		<p>
			<label for="<?php echo $this->get_field_id( 'home_noindex' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'home_noindex' ); ?>" id="<?php echo $this->get_field_id( 'home_noindex' ); ?>" value="1" <?php checked( $this->get_field_value( 'home_noindex' ) ); ?> />
			<?php printf( __( 'Apply %s to the homepage?', 'genesis' ), '<code>noindex</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'home_nofollow' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'home_nofollow' ); ?>" id="<?php echo $this->get_field_id( 'home_nofollow' ); ?>" value="1" <?php checked( $this->get_field_value( 'home_nofollow' ) ); ?> />
			<?php printf( __( 'Apply %s to the homepage?', 'genesis' ), '<code>nofollow</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'home_noarchive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'home_noarchive' ); ?>" id="<?php echo $this->get_field_id( 'home_noarchive' ); ?>" value="1" <?php checked( $this->get_field_value( 'home_noarchive' ) ); ?> />
			<?php printf( __( 'Apply %s to the homepage?', 'genesis' ), '<code>noarchive</code>' ); ?></label>
		</p>

		<h4><?php _e( 'Homepage Author', 'genesis' ); ?></h4>

		<p>
			<span class="description"><?php printf( __( 'Select the user that you would like to be used as the %s for the homepage. Be sure the user you select has entered their Google+ profile address on the profile edit screen.', 'genesis' ), '<code>rel="author"</code>' ); ?></span>
		</p>
		<p>
			<?php
			wp_dropdown_users( array(
				'show_option_none' => __( 'Select User', 'genesis' ),
				'selected' => $this->get_field_value( 'home_author' ),
				'name' => $this->get_field_name( 'home_author' ),
			) );
			?>
		</p>
		<?php

	}

	/**
	 * Callback for SEO Settings Document Head meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_SEO_Settings::metaboxes() Register meta boxes on the SEO Settings page.
	 */
	function document_head_box() {

		?>
		<p><span class="description"><?php printf( __( 'By default, WordPress places several tags in your document %1$s. Most of these tags are completely unnecessary, and provide no <abbr title="Search engine optimization">SEO</abbr> value whatsoever; they just make your site slower to load. Choose which tags you would like included in your document %1$s. If you do not know what something is, leave it unchecked.', 'genesis' ), '<code>&lt;head&gt;</code>' ); ?></span></p>

		<h4><?php _e( 'Relationship Link Tags:', 'genesis' ); ?></h4>

		<p>
			<label for="<?php echo $this->get_field_id( 'head_adjacent_posts_rel_link' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'head_adjacent_posts_rel_link' ); ?>" id="<?php echo $this->get_field_id( 'head_adjacent_posts_rel_link' ); ?>" value="1" <?php checked( $this->get_field_value( 'head_adjacent_posts_rel_link' ) ); ?> />
			<?php printf( __( 'Adjacent Posts %s link tags', 'genesis' ), '<code>rel</code>' ); ?></label>
		</p>

		<h4><?php _e( 'Windows Live Writer Support:', 'genesis' ); ?></h4>

		<p>
			<label for="<?php echo $this->get_field_id( 'head_wlmanifest_link' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'head_wlwmanifest_link' ); ?>" id="<?php echo $this->get_field_id( 'head_wlmanifest_link' ); ?>" value="1" <?php checked( $this->get_field_value( 'head_wlwmanifest_link' ) ); ?> />
			<?php printf( __( 'Include Windows Live Writer Support Tag?', 'genesis' ) ); ?></label>
		</p>

		<h4><?php _e( 'Shortlink Tag:', 'genesis' ); ?></h4>

		<p>
			<label for="<?php echo $this->get_field_id( 'head_shortlink' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'head_shortlink' ); ?>" id="<?php echo $this->get_field_id( 'head_shortlink' ); ?>" value="1" <?php checked( $this->get_field_value( 'head_shortlink' ) ); ?> />
			<?php printf( __( 'Include Shortlink tag?', 'genesis' ) ); ?></label>
		</p>
		<p>
			<span class="description"><?php _e( '<span class="genesis-admin-note">Note:</span> The shortlink tag might have some use for 3rd party service discoverability, but it has no <abbr title="Search engine optimization">SEO</abbr> value whatsoever.', 'genesis' ); ?></span>
		</p>
		<?php

	}

	/**
	 * Callback for SEO Settings Robots meta box.
	 *
	 * Variations of some of the settings contained in this meta box were first added to a 'Search Engine Indexing' meta
	 * box, added in 1.0.0.
	 *
	 * @since 1.3.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_SEO_Settings::metaboxes() Register meta boxes on the SEO Settings page.
	 */
	function robots_meta_box() {

		?>
		<p><span class="description"><?php _e( 'Depending on your situation, you may or may not want the following archive pages to be indexed by search engines. Only you can make that determination.', 'genesis' ); ?></span></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'noindex_cat_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_cat_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_cat_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_cat_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Category Archives?', 'genesis' ), '<code>noindex</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noindex_tag_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_tag_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_tag_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_tag_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Tag Archives?', 'genesis' ), '<code>noindex</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noindex_author_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_author_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_author_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_author_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Author Archives?', 'genesis' ), '<code>noindex</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noindex_date_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_date_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_date_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_date_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Date Archives?', 'genesis' ), '<code>noindex</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noindex_search_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noindex_search_archive' ); ?>" id="<?php echo $this->get_field_id( 'noindex_search_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noindex_search_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Search Archives?', 'genesis' ), '<code>noindex</code>' ); ?></label>
		</p>

		<p><span class="description"><?php printf( __( 'Some search engines will cache pages in your site (e.g. Google Cache). The %1$s tag will prevent them from doing so. Choose which archives you want %1$s applied to.', 'genesis' ), '<code>noarchive</code>' ); ?></span></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'noarchive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive' ) ); ?> />
			<?php printf( __( 'Apply %s to Entire Site?', 'genesis' ), '<code>noarchive</code>' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'noarchive_cat_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_cat_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_cat_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_cat_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Category Archives?', 'genesis' ), '<code>noarchive</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noarchive_tag_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_tag_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_tag_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_tag_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Tag Archives?', 'genesis' ), '<code>noarchive</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noarchive_author_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_author_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_author_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_author_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Author Archives?', 'genesis' ), '<code>noarchive</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noarchive_date_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_date_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_date_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_date_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Date Archives?', 'genesis' ), '<code>noarchive</code>' ); ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noarchive_search_archive' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noarchive_search_archive' ); ?>" id="<?php echo $this->get_field_id( 'noarchive_search_archive' ); ?>" value="1" <?php checked( $this->get_field_value( 'noarchive_search_archive' ) ); ?> />
			<?php printf( __( 'Apply %s to Search Archives?', 'genesis' ), '<code>noarchive</code>' ); ?></label>
		</p>

		<p><span class="description"><?php printf( __( 'Occasionally, search engines use resources like the Open Directory Project and the Yahoo! Directory to find titles and descriptions for your content. Generally, you will not want them to do this. The %s and %s tags prevent them from doing so.', 'genesis' ), '<code>noodp</code>', '<code>noydir</code>' ); ?></span></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'noodp' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noodp' ); ?>" id="<?php echo $this->get_field_id( 'noodp' ); ?>" value="1" <?php checked( $this->get_field_value( 'noodp' ) ); ?> />
			<?php printf( __( 'Apply %s to your site?', 'genesis' ), '<code>noodp</code>' ) ?></label>
			<br />
			<label for="<?php echo $this->get_field_id( 'noydir' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'noydir' ); ?>" id="<?php echo $this->get_field_id( 'noydir' ); ?>" value="1" <?php checked( $this->get_field_value( 'noydir' ) ); ?> />
			<?php printf( __( 'Apply %s to your site?', 'genesis' ), '<code>noydir</code>' ) ?></label>
		</p>
		<?php

	}

	/**
	 * Callback for SEO Settings Canonical Archives meta box.
	 *
	 * @since 1.3.0
	 *
	 * @uses \Genesis_Admin::get_field_id()    Construct field ID.
	 * @uses \Genesis_Admin::get_field_name()  Construct field name.
	 * @uses \Genesis_Admin::get_field_value() Retrieve value of key under $this->settings_field.
	 *
	 * @see \Genesis_Admin_SEO_Settings::metaboxes() Register meta boxes on the SEO Settings page.
	 */
	function archives_box() {

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'canonical_archives' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'canonical_archives' ); ?>" id="<?php echo $this->get_field_id( 'canonical_archives' ); ?>" value="1" <?php checked( $this->get_field_value( 'canonical_archives' ) ); ?> />
			<?php printf( __( 'Canonical Paginated Archives', 'genesis' ) ); ?></label>
		</p>
		<p>
			<span class="description"><?php _e( 'This option points search engines to the first page of an archive, if viewing a paginated page. If you do not know what this means, leave it on.', 'genesis' ); ?></span>
		</p>

		<?php

	}

}
