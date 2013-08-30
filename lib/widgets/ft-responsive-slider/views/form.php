<div id="<?php echo $this->get_field_id( 'container' )?>" class="ft-responsive-slider-container">
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'fortytwo' ); ?> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</label>
	</p>
	<div class="dialog">

		<div class="tabs">
				<a class="media-modal-close" style="float:right" href="#" title="Close"><span class="media-modal-icon">X</span></a>
				<ul>
					<li><a href="#tabs-content-type">Content</a></li>
					<li><a href="#tabs-transition">Transition settings</a></li>
					<li><a href="#tabs-display">Display settings</a></li>
					<li><a href="#tabs-content">Content settings</a></li>
				</ul>
			<div id="tabs-content-type">
				  <p>
				  	<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_type]">
				  		<?php _e( 'Posts or pages', 'fortytwo' ); ?>?
				  	</label>
						<select id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_type]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_type]">
						<?php foreach ( $post_types as $post_type ) { ?>
							<option style="padding-right:10px;" value="<?php echo esc_attr( $post_type ); ?>" <?php selected( esc_attr( $post_type ), ft_get_responsive_slider_option( 'post_type' ) ); ?>><?php echo esc_attr( $post_type ); ?></option><?php } ?>
						</select>
					</p>
					<div id="ft-responsive-slider-content-filter">
						<div id="ft-responsive-slider-taxonomy">
								<h4><?php _e( 'By Taxonomy and Terms', 'fortytwo' ); ?></h4>
									<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_term]">
										<?php _e( 'Filter:', 'fortytwo' ); ?>.
								 </label>
								 <select id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_term]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_term]" style="margin-top: 5px;">
											<option style="padding-right:10px;" value="" <?php selected( '', ft_get_responsive_slider_option( 'posts_term' ) ); ?>><?php _e( 'All Taxonomies and Terms', 'fortytwo' ); ?></option>
								<?php
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
										</optgroup> 
								<?php } ?>
								</select>
							</p>

							<h4><?php _e( 'Include or Exclude by Taxonomy ID', 'fortytwo' ); ?>?</h4>

							<p>
								<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[exclude_terms]"><?php printf( __( 'List which category, tag or other taxonomy IDs to exclude. (1,2,3,4 for example)', 'fortytwo' ), '<br />' ); ?></label>
							</p>

							<p>
								<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[exclude_terms]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[exclude_terms]" value="<?php echo esc_attr( ft_get_responsive_slider_option( 'exclude_terms' ) ); ?>" style="width:60%;" />
							</p>

						</div>
					</div>

						<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[include_exclude]">
							<h4><?php printf( __( 'Include or Exclude by %s ID', 'fortytwo' ), ft_get_responsive_slider_option( 'post_type' ) ); ?></h4>
						</label>

						<p>
							<select style="margin-top: 5px;" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[include_exclude]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[include_exclude]">
								<option style="padding-right:10px;" value="include" <?php selected( 'include', ft_get_responsive_slider_option( 'include_exclude' ) ); ?>><?php _e( 'Include', 'fortytwo' ); ?></option>
								<option style="padding-right:10px;" value="exclude" <?php selected( 'exclude', ft_get_responsive_slider_option( 'include_exclude' ) ); ?>><?php _e( 'Exclude', 'fortytwo' ); ?></option>
							</select> <?php _e( 'slides using their post / page ID in a comma-separated list.', 'fortytwo' ); ?>
						</p>

						<p>
							<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_id]"><strong><?php echo ft_get_responsive_slider_option( 'post_type' ) . ' ' . __( 'ID', 'fortytwo' ); ?>s</strong> <?php _e( 'to include / exclude.', 'fortytwo' ); ?></label>
							<input placeholder="1,2,3,4" type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_id]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[post_id]" value="<?php echo esc_attr( ft_get_responsive_slider_option( 'post_id' ) ); ?>" />
						</p>
						<p>
							
						</p>

						<p>
							<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_num]"><?php _e( 'Number of Slides to Show', 'fortytwo' ); ?>:</label>
							<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_num]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_num]" value="<?php echo esc_attr( ft_get_responsive_slider_option( 'posts_num' ) ); ?>" size="2" />
						</p>

						<p>
							<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_offset]"><?php _e( 'Number of Posts to Offset', 'fortytwo' ); ?>:</label>
							<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_offset]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[posts_offset]" value="<?php echo esc_attr( ft_get_responsive_slider_option( 'posts_offset' ) ); ?>" size="2" />
						</p>

						<p>
							<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[orderby]"><?php _e( 'Order By', 'fortytwo' ); ?>:</label>
							<select id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[orderby]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[orderby]">
								<option style="padding-right:10px;" value="date" <?php selected( 'date', ft_get_responsive_slider_option( 'orderby' ) ); ?>><?php _e( 'Date', 'fortytwo' ); ?></option>
								<option style="padding-right:10px;" value="title" <?php selected( 'title', ft_get_responsive_slider_option( 'orderby' ) ); ?>><?php _e( 'Title', 'fortytwo' ); ?></option>
								<option style="padding-right:10px;" value="ID" <?php selected( 'ID', ft_get_responsive_slider_option( 'orderby' ) ); ?>><?php _e( 'ID', 'fortytwo' ); ?></option>
								<option style="padding-right:10px;" value="rand" <?php selected( 'rand', ft_get_responsive_slider_option( 'orderby' ) ); ?>><?php _e( 'Random', 'fortytwo' ); ?></option>
							</select>
						</p>
		  </div>

		  <div id="tabs-transition">
		  	<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_timer]"><?php _e( 'Time Between Slides (in milliseconds)', 'fortytwo' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_timer]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_timer]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_timer' ); ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_delay]"><?php _e( 'Slide Transition Speed (in milliseconds)', 'fortytwo' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_delay]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_delay]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_delay' ); ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_effect]"><?php _e( 'Slider Effect', 'fortytwo' ); ?>:
					<?php _e( 'Select one of the following:', 'fortytwo' ); ?>
					<select name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_effect]" id="<?php echo FT_SETTINGS_FIELD; ?>[slideshow_effect]">
						<option value="slide" <?php selected( 'slide', genesis_get_option( 'slideshow_effect', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>><?php _e( 'Slide', 'fortytwo' ); ?></option>
						<option value="fade" <?php selected( 'fade', genesis_get_option( 'slideshow_effect', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>><?php _e( 'Fade', 'fortytwo' ); ?></option>
					</select>
				</p>
		  </div>

		  <div id="tabs-display">
		    <p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_width]"><?php _e( 'Maximum Slider Width (in pixels)', 'fortytwo' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_width]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_width]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_width' ); ?>" size="5" /></label>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_height]"><?php _e( 'Maximum Slider Height (in pixels)', 'fortytwo' ); ?>:
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_height]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_height]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_height' ); ?>" size="5" /></label>
				</p>

				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_arrows]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_arrows]" value="1" <?php checked( 1, ft_get_responsive_slider_option( 'slideshow_arrows' ) ); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_arrows]"><?php _e( 'Display Next / Previous Arrows in Slider?', 'fortytwo' ); ?></label>
				</p>

				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_pager]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_pager]" value="1" <?php checked( 1, ft_get_responsive_slider_option( 'slideshow_pager' ) ); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_pager]"><?php _e( 'Display Pagination in Slider?', 'fortytwo' ); ?></label>
				</p>
		  </div>

		  <div id="tabs-content">
		  	<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_no_link]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_no_link]" value="1" <?php checked( 1, ft_get_responsive_slider_option( 'slideshow_no_link' ) ); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_no_link]"><?php _e( 'Do not link Slider image to Post/Page.', 'fortytwo' ); ?></label>
				</p>

				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_title_show]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_title_show]" value="1" <?php checked( 1, ft_get_responsive_slider_option( 'slideshow_title_show' ) ); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_title_show]"><?php _e( 'Display Post/Page Title in Slider?', 'fortytwo' ); ?></label>
				</p>
				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_show]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_show]" value="1" <?php checked( 1, ft_get_responsive_slider_option( 'slideshow_excerpt_show' ) ); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_show]"><?php _e( 'Display Content in Slider?', 'fortytwo' ); ?></label>
				</p>

				<p>
					<input type="checkbox" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_hide_mobile]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_hide_mobile]" value="1" <?php checked( 1, ft_get_responsive_slider_option( 'slideshow_hide_mobile' ) ); ?> /> <label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_hide_mobile]"><?php _e( 'Hide Title & Content on Mobile Devices', 'fortytwo' ); ?></label>
				</p>

				<p>
					<?php _e( 'Select one of the following:', 'fortytwo' ); ?>
					<select name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content]" id="<?php echo FT_SETTINGS_FIELD; ?>[slideshow_excerpt_content]">
						<option value="full" <?php selected( 'full', genesis_get_option( 'slideshow_excerpt_content', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>><?php _e( 'Display post content', 'fortytwo' ); ?></option>
						<option value="excerpts" <?php selected( 'excerpts', genesis_get_option( 'slideshow_excerpt_content', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>><?php _e( 'Display post excerpts', 'fortytwo' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_more_text]"><?php _e( 'More Text (if applicable)', 'fortytwo' ); ?>:</label>
					<input type="text" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_more_text]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_more_text]" value="<?php echo esc_attr( genesis_get_option( 'slideshow_more_text', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>" />
				</p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content_limit]"><?php _e( 'Limit content to', 'fortytwo' ); ?></label>
					<input type="text" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content_limit]" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content_limit]" value="<?php echo esc_attr( genesis_option( 'slideshow_excerpt_content_limit', FT_RESPONSIVE_SLIDER_SETTINGS_FIELD ) ); ?>" size="3" />
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_content_limit]"><?php _e( 'characters', 'fortytwo' ); ?></label>
				</p>

				<p><span class="description"><?php _e( 'Using this option will limit the text and strip all formatting from the text displayed. To use this option, choose "Display post content" in the select box above.', 'fortytwo' ); ?></span></p>

				<p>
					<label for="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_width]"><?php _e( 'Slider Excerpt Width in Columns (1-12)', 'fortytwo' ); ?>:
					<input type="text" class="slider" id="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_width]" name="<?php echo FT_RESPONSIVE_SLIDER_SETTINGS_FIELD; ?>[slideshow_excerpt_width]" value="<?php echo ft_get_responsive_slider_option( 'slideshow_excerpt_width' ); ?>" size="5" /></label>
					<div class="slider"></div>
				</p>  
		  </div>
		</div>
	</div>
	<a href="#" class="openDialogButton"><?php _e('Advanced settings', 'fortytwo' )?></a>
</div>
<script>
(function ($) {
	"use strict";
	$(document).ready(function () {

		var dialogContainer = $('#<?php echo $this->get_field_id( 'container' )?>'),
				theDialog = dialogContainer.find('.dialog'),
				theTabs = dialogContainer.find( ".tabs" ),
				theSlider = dialogContainer.find( "div.slider" ),
				theSliderValue = dialogContainer.find( "input.slider" );

		theDialog.dialog({
			modal: true,
  		autoOpen: false,
  		dialogClass: "ft-responsive-slider-container-dialog",
  		title: "",
  		height: 600,
  		width: 750,
  		show: { effect: "slide", direction: "right" }
		});

		theDialog.find( ".media-modal-close" ).on('click',function() { 
			theDialog.dialog("close");
		});

		theSlider.slider({
      value: theSliderValue.val()||7,
      min: 1,
      max: 12,
      step: 1,
      slide: function( event, ui ) {
        theSliderValue.val( ui.value );
      }
    });

    theTabs.tabs();

		dialogContainer.find('.openDialogButton').click(function(){
		  theDialog.dialog('open');
		});
 
	});
}(jQuery));
</script>


