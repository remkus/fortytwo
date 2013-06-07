<?php
/**
 * Creates settings and outputs admin menu and settings page
 */

/**
 * Return the defaults array
 *
 * @since 0.9
 */
function ft_responsive_slider_defaults() {

	$defaults = array(
		'post_type' => 'post',
		'posts_term' => '',
		'exclude_terms' => '',
		'include_exclude' => '',
		'post_id' => '',
		'posts_num' => 5,
		'posts_offset' => 0,
		'orderby' => 'date',
		'slideshow_timer' => 4000,
		'slideshow_delay' => 800,
		'slideshow_arrows' => 1,
		'slideshow_pager' => 1,
		'slideshow_loop' => 1,
		'slideshow_no_link' => 0,
		'slideshow_height' => 400,
		'slideshow_width' => 920,
		'slideshow_effect' => 'slide',
		'slideshow_excerpt_content' => 'excerpts',
		'slideshow_excerpt_content_limit' => 150,
		'slideshow_more_text' => '[Continue Reading]',
		'slideshow_excerpt_show' => 1,
		'slideshow_excerpt_width' => 50,
		'location_vertical' => 'bottom',
		'location_horizontal' => 'right',
		'slideshow_hide_mobile' => 1
	);

	return apply_filters( 'ft_responsive_slider_settings_defaults', $defaults );

}

add_action( 'admin_init', 'register_ft_responsive_slider_settings' );
/**
 * This registers the settings field
 */
function register_ft_responsive_slider_settings() {

	register_setting( FT_RESPONSIVE_SLIDER_SETTINGS_FIELD, FT_RESPONSIVE_SLIDER_SETTINGS_FIELD );
	add_option( FT_RESPONSIVE_SLIDER_SETTINGS_FIELD, ft_responsive_slider_defaults(), '', 'yes' );

	if ( ! isset($_REQUEST['page']) || $_REQUEST['page'] != 'ft_responsive_slider' )
		return;

	if ( ft_get_responsive_slider_option( 'reset' ) ) {
		update_option( FT_RESPONSIVE_SLIDER_SETTINGS_FIELD, ft_responsive_slider_defaults() );

		ft_admin_redirect( 'ft_responsive_slider', array( 'reset' => 'true' ) );
		exit;
	}

}

add_action('admin_notices', 'ft_responsive_slider_notice');
/**
 * This is the notice that displays when you successfully save or reset
 * the slider settings.
 */
function ft_responsive_slider_notice() {

	if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] != 'ft_responsive_slider' )
		return;

	if ( isset( $_REQUEST['reset'] ) && 'true' == $_REQUEST['reset'] )
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings reset.', 'ft-responsive-slider' ) . '</strong></p></div>';
	elseif ( isset( $_REQUEST['settings-updated'] ) && $_REQUEST['settings-updated'] == 'true' )
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings saved.', 'ft-responsive-slider' ) . '</strong></p></div>';

}

add_action( 'admin_menu', 'ft_responsive_slider_settings_init', 15 );
/**
 * This is a necessary go-between to get our scripts and boxes loaded
 * on the theme settings page only, and not the rest of the admin
 */
function ft_responsive_slider_settings_init() {
	global $_ft_responsive_slider_settings_pagehook;

	// Add "Design Settings" submenu
	$_ft_responsive_slider_settings_pagehook = add_submenu_page( 'genesis', __( 'Slider Settings', 'ft-responsive-slider' ), __( 'Slider Settings', 'ft-responsive-slider' ), 'manage_options', 'ft_responsive_slider', 'ft_responsive_slider_settings_admin' );

	add_action( 'load-' . $_ft_responsive_slider_settings_pagehook, 'ft_responsive_slider_settings_scripts' );
	add_action( 'load-' . $_ft_responsive_slider_settings_pagehook, 'ft_responsive_slider_settings_boxes' );
}

/**
 * Loads the scripts required for the settings page
 */
function ft_responsive_slider_settings_scripts() {
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'wp-lists' );
	wp_enqueue_script( 'postbox' );
	wp_enqueue_script( 'ft_responsive_slider_admin_scripts', modules_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), FT_RESPONSIVE_SLIDER_VERSION, TRUE );
}

/*
 * Loads the Meta Boxes
 */
function ft_responsive_slider_settings_boxes() {
	global $_ft_responsive_slider_settings_pagehook;

	add_meta_box( 'ft-responsive-slider-options', __( 'FT Responsive Slider Settings', 'ft-responsive-slider' ), 'ft_responsive_slider_options_box', $_ft_responsive_slider_settings_pagehook, 'column1' );
}


add_filter( 'screen_layout_columns', 'ft_responsive_slider_settings_layout_columns', 10, 2 );
/**
 * Tell WordPress that we want only 1 column available for our meta-boxes
 */
function ft_responsive_slider_settings_layout_columns( $columns, $screen ) {
	global $_ft_responsive_slider_settings_pagehook;

	if ( $screen == $_ft_responsive_slider_settings_pagehook ) {
		// This page should have 1 column settings
		$columns[$_ft_responsive_slider_settings_pagehook] = 1;
	}

	return $columns;
}

/**
 * This function is what actually gets output to the page. It handles the markup,
 * builds the form, outputs necessary JS stuff, and fires <code>do_meta_boxes()</code>
 */
function ft_responsive_slider_settings_admin() {
		global $_ft_responsive_slider_settings_pagehook, $screen_layout_columns;

		$width = "width: 99%;";
		$hide2 = $hide3 = " display: none;";
?>
		<div id="gs" class="wrap ft-metaboxes">
		<form method="post" action="options.php">

			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
			<?php settings_fields( FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ); // important!  ?>

			<?php screen_icon( 'plugins' ); ?>
			<h2>
				<?php _e( 'FT - Responsive Slider', 'ft-responsive-slider' ); ?>
				<input type="submit" class="button-primary ft-h2-button" value="<?php _e( 'Save Settings', 'ft-responsive-slider' ) ?>" />
				<input type="submit" class="button-highlighted ft-h2-button" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[reset]" value="<?php _e( 'Reset Settings', 'ft-responsive-slider' ); ?>" onclick="return ft_confirm('<?php echo esc_js( __( 'Are you sure you want to reset?', 'ft-responsive-slider' ) ); ?>');" />
			</h2>

			<div class="metabox-holder">
				<div class="postbox-container" style="<?php echo $width; ?>">
					<?php do_meta_boxes( $_ft_responsive_slider_settings_pagehook, 'column1', null ); ?>
				</div>
			</div>

			<div class="bottom-buttons">
				<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'ft-responsive-slider') ?>" />
				<input type="submit" class="button-highlighted" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[reset]" value="<?php _e( 'Reset Settings', 'ft-responsive-slider' ); ?>" />
			</div>

		</form>
		</div>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $_ft_responsive_slider_settings_pagehook; ?>');
			});
			//]]>
		</script>

<?php
}

/**
 * This function generates the form code to be used in the metaboxes
 *
 * @since 0.9
 */
function ft_responsive_slider_options_box() {
?>

			<div id="ft-responsive-slider-content-type">

				<h4><?php _e( 'Type of Content', 'ft-responsive-slider' ); ?></h4>

				<p><label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_type]"><?php _e( 'Would you like to use posts or pages', 'ft-responsive-slider' ); ?>?</label>
					<select id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_type]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_type]">
<?php

						$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
						$post_types = array_filter( $post_types, 'ft_responsive_slider_exclude_post_types' );

						foreach ( $post_types as $post_type ) { ?>

							<option style="padding-right:10px;" value="<?php echo esc_attr( $post_type ); ?>" <?php selected( esc_attr( $post_type ), ft_get_responsive_slider_option( 'post_type' ) ); ?>><?php echo esc_attr( $post_type ); ?></option><?php } ?>

					</select></p>

			</div>

			<div id="ft-responsive-slider-content-filter">

				<div id="ft-responsive-slider-taxonomy">

					<p><strong style="display: block; font-size: 11px; margin-top: 10px;"><?php _e( 'By Taxonomy and Terms', 'ft-responsive-slider' ); ?></strong><label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_term]"><?php _e( 'Choose a term to determine what slides to include', 'ft-responsive-slider' ); ?>.</label>

						<select id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_term]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_term]" style="margin-top: 5px;">

							<option style="padding-right:10px;" value="" <?php selected( '', ft_get_responsive_slider_option( 'posts_term' ) ); ?>><?php _e( 'All Taxonomies and Terms', 'ft-responsive-slider' ); ?></option>
			<?php
						$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

						$taxonomies = array_filter( $taxonomies, 'ft_responsive_slider_exclude_taxonomies' );
						$test = get_taxonomies( array( 'public' => true ), 'objects' );

						foreach ( $taxonomies as $taxonomy ) {
							$query_label = '';
							if ( !empty( $taxonomy->query_var ) )
								$query_label = $taxonomy->query_var;
							else
								$query_label = $taxonomy->name;
			?>
								<optgroup label="<?php echo esc_attr( $taxonomy->labels->name ); ?>">

									<option style="margin-left: 5px; padding-right:10px;" value="<?php echo esc_attr( $query_label ); ?>" <?php selected( esc_attr( $query_label ), ft_get_responsive_slider_option( 'posts_term' ) ); ?>><?php echo $taxonomy->labels->all_items; ?></option><?php
								$terms = get_terms( $taxonomy->name, 'orderby=name&hide_empty=1' );
								foreach ( $terms as $term ) {
				?>
									<option style="margin-left: 8px; padding-right:10px;" value="<?php echo esc_attr( $query_label ) . ',' . $term->slug; ?>" <?php selected( esc_attr( $query_label ) . ',' . $term->slug, ft_get_responsive_slider_option( 'posts_term' ) ); ?>><?php echo '-' . esc_attr( $term->name ); ?></option><?php } ?>

								</optgroup> <?php } ?>

						</select>
					</p>

					<p><strong style="display: block; font-size: 11px; margin-top: 10px;"><?php _e( 'Include or Exclude by Taxonomy ID', 'ft-responsive-slider' ); ?></strong></p>

					<p>
						<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[exclude_terms]"><?php printf( __( 'List which category, tag or other taxonomy IDs to exclude. (1,2,3,4 for example)', 'ft-responsive-slider' ), '<br />' ); ?></label>
					</p>

					<p>
						<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[exclude_terms]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[exclude_terms]" value="<?php echo esc_attr( ft_get_responsive_slider_option( 'exclude_terms' ) ); ?>" style="width:60%;" />
					</p>

				</div>

				<p>
					<strong style="font-size:11px;margin-top:10px;"><label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[include_exclude]"><?php printf( __( 'Include or Exclude by %s ID', 'ft-responsive-slider' ), ft_get_responsive_slider_option( 'post_type' ) ); ?></label></strong>
				</p>

				<p><?php _e( 'Choose the include / exclude slides using their post / page ID in a comma-separated list. (1,2,3,4 for example)', 'ft-responsive-slider' ); ?></p>

				<p>
					<select style="margin-top: 5px;" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[include_exclude]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[include_exclude]">
						<option style="padding-right:10px;" value="" <?php selected( '', ft_get_responsive_slider_option( 'include_exclude' ) ); ?>><?php _e( 'Select', 'ft-responsive-slider' ); ?></option>
						<option style="padding-right:10px;" value="include" <?php selected( 'include', ft_get_responsive_slider_option( 'include_exclude' ) ); ?>><?php _e( 'Include', 'ft-responsive-slider' ); ?></option>
						<option style="padding-right:10px;" value="exclude" <?php selected( 'exclude', ft_get_responsive_slider_option( 'include_exclude' ) ); ?>><?php _e( 'Exclude', 'ft-responsive-slider' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_id]"><?php _e( 'List which', 'ft-responsive-slider' ); ?> <strong><?php echo ft_get_responsive_slider_option( 'post_type' ) . ' ' . __( 'ID', 'ft-responsive-slider' ); ?>s</strong> <?php _e( 'to include / exclude. (1,2,3,4 for example)', 'ft-responsive-slider' ); ?></label></p>
				<p>
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_id]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_id]" value="<?php echo esc_attr( ft_get_responsive_slider_option( 'post_id' ) ); ?>" style="width:60%;" />
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_num]"><?php _e( 'Number of Slides to Show', 'ft-responsive-slider' ); ?>:</label>
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_num]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_num]" value="<?php echo esc_attr( ft_get_responsive_slider_option( 'posts_num' ) ); ?>" size="2" />
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_offset]"><?php _e( 'Number of Posts to Offset', 'ft-responsive-slider' ); ?>:</label>
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_offset]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_offset]" value="<?php echo esc_attr( ft_get_responsive_slider_option( 'posts_offset' ) ); ?>" size="2" />
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[orderby]"><?php _e( 'Order By', 'ft-responsive-slider' ); ?>:</label>
					<select id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[orderby]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[orderby]">
						<option style="padding-right:10px;" value="date" <?php selected( 'date', ft_get_responsive_slider_option( 'orderby' ) ); ?>><?php _e( 'Date', 'ft-responsive-slider' ); ?></option>
						<option style="padding-right:10px;" value="title" <?php selected( 'title', ft_get_responsive_slider_option( 'orderby' ) ); ?>><?php _e( 'Title', 'ft-responsive-slider' ); ?></option>
						<option style="padding-right:10px;" value="ID" <?php selected( 'ID', ft_get_responsive_slider_option( 'orderby' ) ); ?>><?php _e( 'ID', 'ft-responsive-slider' ); ?></option>
						<option style="padding-right:10px;" value="rand" <?php selected( 'rand', ft_get_responsive_slider_option( 'orderby' ) ); ?>><?php _e( 'Random', 'ft-responsive-slider' ); ?></option>
					</select>
				</p>

			</div>

			<hr class="div" />

			<h4><?php _e( 'Transition Settings', 'ft-responsive-slider' ); ?></h4>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_timer]"><?php _e( 'Time Between Slides (in milliseconds)', 'ft-responsive-slider' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_timer]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_timer]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_timer' ); ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_delay]"><?php _e( 'Slide Transition Speed (in milliseconds)', 'ft-responsive-slider' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_delay]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_delay]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_delay' ); ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_effect]"><?php _e( 'Slider Effect', 'ft-responsive-slider' ); ?>:
					<?php _e( 'Select one of the following:', 'ft-responsive-slider' ); ?>
					<select name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_effect]" id="<?php echo FT_SETTINGS_FIELD; ?>[slideshow_effect]">
						<option value="slide" <?php selected( 'slide', genesis_get_option( 'slideshow_effect', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>><?php _e( 'Slide', 'ft-responsive-slider' ); ?></option>
						<option value="fade" <?php selected( 'fade', genesis_get_option( 'slideshow_effect', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>><?php _e( 'Fade', 'ft-responsive-slider' ); ?></option>
					</select>
				</p>

			<hr class="div" />

			<h4><?php _e( 'Display Settings', 'ft-responsive-slider' ); ?></h4>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_width]"><?php _e( 'Maximum Slider Width (in pixels)', 'ft-responsive-slider' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_width]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_width]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_width' ); ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_height]"><?php _e( 'Maximum Slider Height (in pixels)', 'ft-responsive-slider' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_height]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_height]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_height' ); ?>" size="5" /></label>
				</p>

				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_arrows]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_arrows]" value="1" <?php checked(1, ft_get_responsive_slider_option('slideshow_arrows')); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_arrows]"><?php _e( 'Display Next / Previous Arrows in Slider?', 'ft-responsive-slider' ); ?></label>
				</p>
				
				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_pager]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_pager]" value="1" <?php checked(1, ft_get_responsive_slider_option('slideshow_pager')); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_pager]"><?php _e( 'Display Pagination in Slider?', 'ft-responsive-slider' ); ?></label>
				</p>

			<hr class="div" />

			<h4><?php _e( 'Content Settings', 'ft-responsive-slider' ); ?></h4>

				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_no_link]" id="<?php echo FT_SLIDER_SETTINGS_FIELD; ?>[slideshow_title_show]" value="1" <?php checked(1, ft_get_responsive_slider_option('slideshow_no_link')); ?> /> <label for="<?php echo FT_SLIDER_SETTINGS_FIELD; ?>[slideshow_no_link]"><?php _e( 'Do not link Slider image to Post/Page.', 'ft-slider' ); ?></label>
				</p>

				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_title_show]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_title_show]" value="1" <?php checked(1, ft_get_responsive_slider_option('slideshow_title_show')); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_title_show]"><?php _e( 'Display Post/Page Title in Slider?', 'ft-responsive-slider' ); ?></label>
				</p>
				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_show]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_show]" value="1" <?php checked(1, ft_get_responsive_slider_option('slideshow_excerpt_show')); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_show]"><?php _e( 'Display Content in Slider?', 'ft-responsive-slider' ); ?></label>
				</p>
				
				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_hide_mobile]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_hide_mobile]" value="1" <?php checked(1, ft_get_responsive_slider_option('slideshow_hide_mobile')); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_hide_mobile]"><?php _e( 'Hide Title & Content on Mobile Devices', 'ft-responsive-slider' ); ?></label>
				</p>
				
				<p>
					<?php _e( 'Select one of the following:', 'ft-responsive-slider' ); ?>
					<select name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content]" id="<?php echo FT_SETTINGS_FIELD; ?>[slideshow_excerpt_content]">
						<option value="full" <?php selected( 'full', genesis_get_option( 'slideshow_excerpt_content', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>><?php _e( 'Display post content', 'ft-responsive-slider' ); ?></option>
						<option value="excerpts" <?php selected( 'excerpts', genesis_get_option( 'slideshow_excerpt_content', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>><?php _e( 'Display post excerpts', 'ft-responsive-slider' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_more_text]"><?php _e( 'More Text (if applicable)', 'ft-responsive-slider' ); ?>:</label>
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_more_text]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_more_text]" value="<?php echo esc_attr( genesis_get_option( 'slideshow_more_text', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>" />
				</p>
			
				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content_limit]"><?php _e( 'Limit content to', 'ft-responsive-slider' ); ?></label>
					<input type="text" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content_limit]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content_limit]" value="<?php echo esc_attr( genesis_option( 'slideshow_excerpt_content_limit', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>" size="3" />
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content_limit]"><?php _e( 'characters', 'ft-responsive-slider' ); ?></label>
				</p>
		
				<p><span class="description"><?php _e( 'Using this option will limit the text and strip all formatting from the text displayed. To use this option, choose "Display post content" in the select box above.', 'ft-responsive-slider' ); ?></span></p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_width]"><?php _e( 'Slider Excerpt Width (in percentage)', 'ft-responsive-slider' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_width]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_width]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_excerpt_width' ); ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[location_vertical]"><?php _e( 'Excerpt Location (vertical)', 'ft-responsive-slider' ); ?>:</label>
					<select id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[location_vertical]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[location_vertical]">
						<option style="padding-right:10px;" value="top" <?php selected( 'top', ft_get_responsive_slider_option( 'location_vertical' ) ); ?>><?php _e( 'Top', 'ft-responsive-slider' ); ?></option>
						<option style="padding-right:10px;" value="bottom" <?php selected( 'bottom', ft_get_responsive_slider_option( 'location_vertical' ) ); ?>><?php _e( 'Bottom', 'ft-responsive-slider' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[location_horizontal]"><?php _e( 'Excerpt Location (horizontal)', 'ft-responsive-slider' ); ?>:</label>
					<select id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[location_horizontal]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[location_horizontal]">
						<option style="padding-right:10px;" value="left" <?php selected( 'left', ft_get_responsive_slider_option( 'location_horizontal' ) ); ?>><?php _e( 'Left', 'ft-responsive-slider' ); ?></option>
						<option style="padding-right:10px;" value="right" <?php selected( 'right', ft_get_responsive_slider_option( 'location_horizontal' ) ); ?>><?php _e( 'Right', 'ft-responsive-slider' ); ?></option>
					</select>
				</p>
<?php
}

/*
 * Echos form submit button for settings page.
 */
function ft_responsive_slider_form_submit( $args = array( ) ) {
	echo '<p><input type="submit" class="button-primary" value="' . __( 'Save Changes', 'ft-responsive-slider' ) . '" /></p>';
}