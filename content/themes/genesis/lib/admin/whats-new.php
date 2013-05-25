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
 * Registers a new admin page, providing content and corresponding menu item for the "What's new" page.
 *
 * @package Genesis\Admin
 *
 * @since 1.9.0
 */
class Genesis_Admin_Upgraded extends Genesis_Admin_Basic {

	/**
	 * Create the page.
	 *
	 * @uses PARENT_THEME_BRANCH      Genesis Framework branch.
	 * @uses \Genesis_Admin::create() Register the admin page.
	 *
	 * @since 1.9.0
	 */
	function __construct() {

		$page_id = 'genesis-upgraded';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'admin.php',
				'menu_title'  => '',
				'page_title'  => sprintf( __( 'Welcome to Genesis %s', 'genesis' ), PARENT_THEME_BRANCH ),
			)
		);

		$this->create( $page_id, $menu_ops );

		add_action( 'admin_enqueue_scripts', 'add_thickbox' );

	}

	/**
	 * Callback for displaying the What's New admin page.
	 *
	 * @since 1.9.0
	 */
	public function admin() {

		?>
		<div class="wrap about-wrap">

		<img src="<?php echo get_template_directory_uri() . '/lib/admin/images/whats-new.png'; ?>" class="alignright whats-new" />

		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<div class="about-text"><?php printf( __( 'Congratulations! You\'re now running Genesis %s.', 'genesis' ), PARENT_THEME_BRANCH ); ?></div>

		<div class="changelog">
			<h3><?php _e( 'What&#8217;s New', 'genesis' ); ?></h3>
			<div class="feature-section">

				<h4><?php _e( 'HTML5 Markup', 'genesis' ); ?></h4>
				<p><?php _e( 'Genesis has always been on the cutting edge of web technology, and Genesis 2.0 continues in that excellent tradition. With a single line of code in a child theme, Genesis will now output HTML5 markup in place of the old XHTML tags, and all of our themes moving forward will be developed on HTML5.', 'genesis' ); ?></p>

				<h4><?php _e( 'Microdata', 'genesis' ); ?></h4>
				<p><?php printf( __( 'If you are using a theme with HTML5 enabled, Genesis will also output your markup using Microdata. Not sure what that is? We don\'t blame you. Take a look at <a href="%s" target="_blank">this explanation</a>. Still confused? Don\'t worry. That\'s why you\'re using a framework. We did all the research and modified the markup to serve search engines the Microdata they\'re looking for, so you don\'t have to. It\'s good to be a Genesis user.', 'genesis' ), 'http://html5doctor.com/microdata/' ); ?></p>

				<h4><?php _e( 'A Brand New Design', 'genesis' ); ?></h4>
				<p><?php _e( 'Genesis is sporting a fresh new look. And we\'ve taken advantage of the new HTML5 markup, as well as some snazzy CSS3. We think you\'re gonna love this.', 'genesis' ); ?></p>

				<h4><?php _e( 'Removing Features', 'genesis' ); ?></h4>
				<p><?php _e( 'We like to keep Genesis as lightweight as possible for you. After all, nobody wants to use software with dead weight. So we\'ve removed the Latest Tweets widget, eNews widget, the "post templates" feature, and the "fancy dropdowns" setting. But fear not! If you want those features back, click below to install the handy plugins we created for you.', 'genesis' ); ?></p>

				<p>
					<ul>
						<li><?php echo genesis_plugin_install_link( 'genesis-latest-tweets', __( 'Genesis Latest Tweets Widget', 'genesis' ) ); ?></li>
						<li><?php echo genesis_plugin_install_link( 'genesis-enews-extended', __( 'Genesis eNews Extended', 'genesis' ) ); ?></li>
						<li><?php echo genesis_plugin_install_link( 'single-post-template', __( 'Single Post Template', 'genesis' ) ); ?></li>
						<li><?php echo genesis_plugin_install_link( 'genesis-fancy-dropdowns', __( 'Fancy Dropdowns', 'genesis' ) ); ?></li>
					</ul>
				</p>

				<h4><?php _e( 'Boring, but important', 'genesis' ); ?></h4>
				<p><?php _e( 'We\'re always improving things. Call it a sickness, but we like to make things work really, really well. Here\'s a list of the technical changes in this latest release.', 'genesis' ); ?></p>

				<p>
					<ul>
						<li><?php _e( 'Better named loop hooks for HTML5.', 'genesis' ); ?></li>
						<li><?php _e( 'Network Upgrade now upgrades the Genesis database for all sites in a network when running WordPress in multisite mode.', 'genesis' ); ?></li>
						<li><?php _e( 'Widget classes are now coded in PHP5 format.', 'genesis' ); ?></li>
						<li><?php _e( 'Admin CSS and Javascript are now minified.', 'genesis' ); ?></li>
						<li><?php _e( 'Inline HTML comments have been removed to reduce page size.', 'genesis' ); ?></li>
						<li><?php _e( 'The Scripts option now has its own metabox when editing an entry.', 'genesis' ); ?></li>
						<li><?php _e( 'Custom Post Type archive pages now have a settings page so you can control the output.', 'genesis' ); ?></li>
						<li><?php _e( 'Genesis tracks displayed entry IDs so you can exclude entries from showing twice on a page.', 'genesis' ); ?></li>
						<li><?php _e( 'Entries without titles now display a permalink after the post content.', 'genesis' ); ?></li>
					</ul>
				<p>

				</div>
		</div>

		<div class="project-leads">

			<h3><?php _e( 'Project Leads', 'genesis' ); ?></h3>

			<ul class="wp-people-group " id="wp-people-group-project-leaders">
			<li class="wp-person">
				<a href="http://twitter.com/nathanrice"><img src="http://0.gravatar.com/avatar/fdbd4b13e3bcccb8b48cc18f846efb7f?s=60" class="gravatar" alt="Nathan Rice" /></a>
				<a class="web" href="http://twitter.com/nathanrice">Nathan Rice</a>
				<span class="title"><?php _e( 'Lead Developer', 'genesis' ); ?></span>
			</li>
			<li class="wp-person">
				<a href="http://twitter.com/sillygrampy"><img src="http://0.gravatar.com/avatar/7b8ff059b9a4504dfbaebd4dd190466e?s=60" class="gravatar" alt="Ron Rennick" /></a>
				<a class="web" href="http://twitter.com/sillygrampy">Ron Rennick</a>
				<span class="title"><?php _e( 'Lead Developer', 'genesis' ); ?></span>
			</li>
			<li class="wp-person">
				<a href="http://twitter.com/bgardner"><img src="http://0.gravatar.com/avatar/c845c86ebe395cea0d21c03bc4a93957?s=60" class="gravatar" alt="Brian Gardner" /></a>
				<a class="web" href="http://twitter.com/bgardner">Brian Gardner</a>
				<span class="title"><?php _e( 'Lead Developer', 'genesis' ); ?></span>
			</li>
			</ul>

		</div>

		<div class="contributors">

			<h3><?php _e( 'Contributors', 'genesis' ); ?></h3>

			<ul class="wp-people-group" id="wp-people-group-contributing-developers">
			<?php
			$contributors = genesis_contributors();

			shuffle( $contributors );

			foreach ( $contributors as $contributor ) {
				echo '<li class="wp-person">';
				printf( '<a href="%s"><img src="%s" alt="%s" class="gravatar" /></a><a class="web" href="%s">%s</a>', esc_url( $contributor['url'] ), esc_url( $contributor['gravatar'] ), esc_attr( $contributor['name'] ), esc_url( $contributor['url'] ), esc_html( $contributor['name'] ) );
				printf( '<span class="title">%s</span>', __( 'Contributor', 'genesis' ) );
				echo '</li>' . "\n";
			}
			?>
			</ul>

		</div>

		<div class="return-to-dashboard">
			<p><a href="<?php echo esc_url( menu_page_url( 'genesis', 0 ) ); ?>"><?php _e( 'Go to Theme Settings &rarr;', 'genesis' ); ?></a></p>
			<p><a href="<?php echo esc_url( menu_page_url( 'seo-settings', 0 ) ); ?>"><?php _e( 'Go to SEO Settings &rarr;', 'genesis' ); ?></a></p>
		</div>

		</div>
		<?php

	}

}
