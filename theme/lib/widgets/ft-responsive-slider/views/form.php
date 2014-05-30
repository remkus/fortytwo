<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */
?>
<div id="<?php echo $this->get_field_id( 'container' )?>" class="ft-responsive-slider-container">
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'fortytwo' ); ?>
			<input class="widefat"<?php $this->id_name( 'title' ); ?> type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</label>
	</p>
	<div class="dialog">
		<div class="tabs">
			<ul class="nav-tab-wrapper">
				<li><a href="#tabs-content-type">Content</a></li>
				<li><a href="#tabs-transition">Transition settings</a></li>
				<li><a href="#tabs-display">Display settings</a></li>
				<li><a href="#tabs-content">Content settings</a></li>
			</ul>
			<div id="tabs-content-type">
				  <p>
				  	<label for="<?php echo $this->get_field_id( 'post_type' ); ?>">
				  		<?php _e( 'Posts or pages', 'fortytwo' ); ?>?
				  	</label>
						<select<?php $this->id_name( 'post_type' ); ?>>
						<?php foreach ( $instance['post_types'] as $post_type ) { ?>
							<option value="<?php echo esc_attr( $post_type ); ?>"<?php selected( esc_attr( $post_type ), $instance['post_type'] ); ?>><?php echo esc_attr( $post_type ); ?></option>
						<?php } ?>
						</select>
					</p>
					<div id="ft-responsive-slider-content-filter">
						<div id="ft-responsive-slider-taxonomy">
							<h4><?php _e( 'By Taxonomy and Terms', 'fortytwo' ); ?></h4>
								<label for="<?php echo $this->get_field_id( 'posts_term' ); ?>">
										<?php _e( 'Filter:', 'fortytwo' ); ?>.
								</label>
								<select<?php $this->id_name( 'posts_term' ); ?> style="margin-top: 5px;">
									<option value=""<?php selected( '', $instance['posts_term'] ); ?>><?php _e( 'All Taxonomies and Terms', 'fortytwo' ); ?></option>
<?php
foreach ( $instance['taxonomies'] as $taxonomy ) {
	$query_label = '';
	if ( ! empty( $taxonomy->query_var ) ) {
		$query_label = $taxonomy->query_var;
	} else {
		$query_label = $taxonomy->name;
	}
	?>
	<optgroup label="<?php echo esc_attr( $taxonomy->labels->name ); ?>">
		<option style="margin-left: 5px;" value="<?php echo esc_attr( $query_label ); ?>"<?php selected( esc_attr( $query_label ), $instance['posts_term'] ); ?>><?php echo $taxonomy->labels->all_items; ?></option>
		<?php
	$terms = get_terms( $taxonomy->name, 'orderby=name&hide_empty=1' );
	foreach ( $terms as $term ) {
		?>
		<option style="margin-left: 8px;" value="<?php echo esc_attr( $query_label ) . ',' . $term->slug; ?>"<?php selected( esc_attr( $query_label ) . ',' . $term->slug, $instance['posts_term'] ); ?>><?php echo '-' . esc_attr( $term->name ); ?></option>
		<?php
	} ?>
	</optgroup>
	<?php
}
?>
								</select>

							<h4><?php _e( 'Include or Exclude by Taxonomy ID', 'fortytwo' ); ?>?</h4>

							<p>
								<label for="<?php echo $this->get_field_id( 'exclude_terms' ); ?>"><?php printf( __( 'List which category, tag or other taxonomy IDs to exclude. (1,2,3,4 for example)', 'fortytwo' ), '<br />' ); ?></label>
							</p>

							<p>
								<input placeholder="1,2,3,4" type="text"<?php $this->id_name( 'exclude_terms' ); ?> value="<?php echo esc_attr( $instance['exclude_terms'] ); ?>" style="width:60%;" />
							</p>

						</div>
					</div>

						<label for="<?php echo $this->get_field_id( 'include_exclude' ); ?>">
							<h4><?php printf( __( 'Include or Exclude by %s ID', 'fortytwo' ), $instance['post_type'] ); ?></h4>
						</label>

						<p>
							<select<?php $this->id_name( 'include_exclude' ); ?>>
								<option value="include"<?php selected( 'include', $instance['include_exclude'] ); ?>><?php _e( 'Include', 'fortytwo' ); ?></option>
								<option value="exclude"<?php selected( 'exclude', $instance['include_exclude'] ); ?>><?php _e( 'Exclude', 'fortytwo' ); ?></option>
							</select> <?php _e( 'slides using their post / page ID in a comma-separated list.', 'fortytwo' ); ?>
						</p>

						<p>
							<label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><strong><?php echo $instance['post_type'] . ' ' . __( 'ID', 'fortytwo' ); ?>s</strong> <?php _e( 'to include / exclude.', 'fortytwo' ); ?></label>
							<input placeholder="1,2,3,4" type="text"<?php $this->id_name( 'post_id' ); ?> value="<?php echo esc_attr( $instance['post_id'] ); ?>" />
						</p>

						<p>
							<label for="<?php echo $this->get_field_id( 'posts_num' ); ?>"><?php _e( 'Number of Slides to Show', 'fortytwo' ); ?>:</label>
							<input type="text"<?php $this->id_name( 'posts_num' ); ?> value="<?php echo esc_attr( $instance['posts_num'] ); ?>" size="2" />
						</p>

						<p>
							<label for="<?php echo $this->get_field_id( 'posts_offset' ); ?>"><?php _e( 'Number of Posts to Offset', 'fortytwo' ); ?>:</label>
							<input type="text"<?php $this->id_name( 'posts_offset' ); ?> value="<?php echo esc_attr( $instance['posts_offset'] ); ?>" size="2" />
						</p>

						<p>
							<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'fortytwo' ); ?>:</label>
							<select<?php $this->id_name( 'orderby' ); ?>>
								<option value="date"<?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'fortytwo' ); ?></option>
								<option value="title"<?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'fortytwo' ); ?></option>
								<option value="ID"<?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'fortytwo' ); ?></option>
								<option value="rand"<?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'fortytwo' ); ?></option>
							</select>
						</p>
		  </div>

		  <div id="tabs-transition">
		  	<p>
					<label for="<?php echo $this->get_field_id( 'slideshow_timer' ); ?>"><?php _e( 'Time Between Slides (in milliseconds)', 'fortytwo' ); ?>:
					<input type="text"<?php $this->id_name( 'slideshow_timer' ); ?> value="<?php echo $instance['slideshow_timer']; ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'slideshow_delay' ); ?>"><?php _e( 'Slide Transition Speed (in milliseconds)', 'fortytwo' ); ?>:
					<input type="text"<?php $this->id_name( 'slideshow_delay' ); ?> value="<?php echo $instance['slideshow_delay']; ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'slideshow_effect' ); ?>"><?php _e( 'Slider Effect', 'fortytwo' ); ?>:
					<?php _e( 'Select one of the following:', 'fortytwo' ); ?>
					<select<?php $this->id_name( 'slideshow_effect' ); ?>>
						<option value="slide"<?php selected( 'slide', $instance['slideshow_effect'] ); ?>><?php _e( 'Slide', 'fortytwo' ); ?></option>
						<option value="fade"<?php selected( 'fade', $instance['slideshow_effect'] ); ?>><?php _e( 'Fade', 'fortytwo' ); ?></option>
					</select>
				</p>
		  </div>

		  <div id="tabs-display">
		    <p>
					<label for="<?php echo $this->get_field_id( 'slideshow_width' ); ?>"><?php _e( 'Maximum Image Width (in pixels)', 'fortytwo' ); ?>:
					<input type="text"<?php $this->id_name( 'slideshow_width' ); ?> value="<?php echo $instance['slideshow_width']; ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'slideshow_height' ); ?>"><?php _e( 'Maximum Image Height (in pixels)', 'fortytwo' ); ?>:
					<input type="text"<?php $this->id_name( 'slideshow_height' ); ?> value="<?php echo $instance['slideshow_height']; ?>" size="5" /></label>
				</p>

				<p>
					<input type="checkbox"<?php $this->id_name( 'slideshow_arrows' ); ?> value="1" <?php checked( 1, $instance['slideshow_arrows'] ); ?> /> <label for="<?php echo $this->get_field_id( 'slideshow_arrows' ); ?>"><?php _e( 'Display Next / Previous Arrows in Slider?', 'fortytwo' ); ?></label>
				</p>

				<p>
					<input type="checkbox"<?php $this->id_name( 'slideshow_pager' ); ?> value="1" <?php checked( 1, $instance['slideshow_pager'] ); ?> /> <label for="<?php echo $this->get_field_id( 'slideshow_pager' ); ?>"><?php _e( 'Display Pagination in Slider?', 'fortytwo' ); ?></label>
				</p>
		  </div>

		  <div id="tabs-content">
		  	<p>
					<input type="checkbox"<?php $this->id_name( 'slideshow_no_link' ); ?> value="1" <?php checked( 1, $instance['slideshow_no_link'] ); ?> /> <label for="<?php echo $this->get_field_id( 'slideshow_no_link' ); ?>"><?php _e( 'Do not link Slider image to Post/Page.', 'fortytwo' ); ?></label>
				</p>

				<p>
					<input type="checkbox"<?php $this->id_name( 'slideshow_title_show' ); ?> value="1" <?php checked( 1, $instance['slideshow_title_show'] ); ?> /> <label for="<?php echo $this->get_field_id( 'slideshow_title_show' ); ?>"><?php _e( 'Display Post/Page Title in Slider?', 'fortytwo' ); ?></label>
				</p>

				<p>
					<input type="checkbox"<?php $this->id_name( 'slideshow_excerpt_show' ); ?> value="1" <?php checked( 1, $instance['slideshow_excerpt_show'] ); ?> /> <label for="<?php echo $this->get_field_id( 'slideshow_excerpt_show' ); ?>"><?php _e( 'Display Content in Slider?', 'fortytwo' ); ?></label>
				</p>

				<p>
					<input type="checkbox"<?php $this->id_name( 'slideshow_hide_mobile' ); ?> value="1" <?php checked( 1, $instance['slideshow_hide_mobile'] ); ?> /> <label for="<?php echo $this->get_field_id( 'slideshow_hide_mobile' ); ?>"><?php _e( 'Hide Title &amp; Content on Mobile Devices', 'fortytwo' ); ?></label>
				</p>

				<p>
					<?php _e( 'Select one of the following:', 'fortytwo' ); ?>
					<select<?php $this->id_name( 'slideshow_excerpt_content' ); ?>>
						<option value="full"<?php selected( 'full', $instance['slideshow_excerpt_content'] ); ?>><?php _e( 'Display post content', 'fortytwo' ); ?></option>
						<option value="excerpts"<?php selected( 'excerpts', $instance['slideshow_excerpt_content'] ); ?>><?php _e( 'Display post excerpts', 'fortytwo' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'slideshow_more_text' ); ?>"><?php _e( 'More Text (if applicable)', 'fortytwo' ); ?>:</label>
					<input type="text"<?php $this->id_name( 'slideshow_more_text' ); ?> value="<?php echo esc_attr( $instance['slideshow_more_text'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'slideshow_excerpt_content_limit' ); ?>"><?php _e( 'Limit content to', 'fortytwo' ); ?></label>
					<input type="text"<?php $this->id_name( 'slideshow_excerpt_content_limit' ); ?> value="<?php echo esc_attr( $instance['slideshow_excerpt_content_limit'] ); ?>" size="3" />
					<label for="<?php echo $this->get_field_id( 'slideshow_excerpt_content_limit' ); ?>"><?php _e( 'characters', 'fortytwo' ); ?></label>
				</p>

				<p><span class="description"><?php _e( 'Using this option will limit the text and strip all formatting from the text displayed. To use this option, choose "Display post content" in the select box above.', 'fortytwo' ); ?></span></p>

		  </div>
		</div> <!-- tabs -->
	</div> <!-- dialog -->
	<a href="#" class="openDialogButton"><?php _e( 'Advanced settings', 'fortytwo' )?></a>
</div>
<script>
(function ($) {
	'use strict';
	$(function () {

		var dialogContainer = $( '#<?php echo $this->get_field_id( 'container' )?>' ),
			theForm         = $( dialogContainer ).closest( 'form' ),
			theDialogEl     = dialogContainer.find('.dialog'),
			theTabs         = dialogContainer.find( '.tabs' ),
			theSlider       = dialogContainer.find( 'div.slider' ),
			theSliderValue  = dialogContainer.find( 'input.slider' );

		var theDialog = theDialogEl.dialog({
			dialogClass: 'wp-dialog',
			modal: true,
			autoOpen: false,
			closeOnEscape: true,
			appendTo: theForm,
			height: 600,
			width: 750,
			show: { effect: 'slide', direction: 'right' },
			buttons: {
				'Save': function() {
					dialogContainer.parent().parent().parent().find( '.widget-control-save' ).trigger( 'click' );
					$(this).dialog( 'close' );
				}
			},
			focus: function() {
				theDialogEl.find( '.ui-button-text' ).css( 'button-primary' );
			}
		});

		//Ensure the dialog's save button has WP Admin styling
		theDialogEl.on( 'dialogfocus', function( event, ui ) {
			theDialogEl.find( '.ui-button-text' ).css( 'button-primary' );
		} );

		// theDialogEl.find( '.media-modal-close' ).on( 'click',function() {
		// 	theDialogEl.dialog( 'close' );
		// });

		theTabs.tabs();

		dialogContainer.find( '.openDialogButton' ).click( function() {
			theDialog.dialog( 'open' );
		});

	});
}( jQuery ) );
</script>
