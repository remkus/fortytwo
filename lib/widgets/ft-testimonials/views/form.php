<div class="ft-testimonials-admin">
<table style="width:100%">
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'fortytwo' ); ?></label>
			<input class="widefat" type="text" <?php $this->echo_field_id( "title" ) ?> value="<?php echo esc_attr( $instance['title'] ); ?>">
		</td>
  </tr>
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'fortytwo' ); ?></label>
			<input class="widefat" type="text" <?php $this->echo_field_id( "limit" ) ?> value="<?php echo esc_attr( $instance['limit'] ); ?>">
		</td>
  </tr>
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'datasource' ); ?>"><?php _e( 'Datasource:', 'fortytwo' ); ?></label>
			<select class="widefat" <?php $this->echo_field_id( 'datasource' ) ?> >
				<option class="widefat" <?php if ( '' == $instance['datasource'] ) echo 'selected="selected"'; ?>>==&gt;&nbsp;<?php _e( 'Select', 'fortytwo' ); ?>&nbsp;&lt;==</option>
				<?php foreach ($instance['datasources'] as $datasource) { ?>
				<option class="widefat" value="<?php echo $datasource['value']; ?>" <?php if ( $datasource['value'] == $instance['datasource'] ) echo 'selected="selected"'; ?>>
					<?php _e( $datasource['name'], 'fortytwo' ); ?>
				</option>
				<?php } ?>
			</select>
			<div class="<?php echo $this->get_field_id( 'datasource' ) ?>">
				<div class="category datasource_block">
					<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'fortytwo' ); ?></label>
					<?php wp_dropdown_categories(array(
						'id'=>$this->get_field_id( 'category' ),
						'name'=>$this->get_field_name( 'category' ),
						'selected'=>$instance['category'],
						'show_count'=>1,
						'hierarchical'=>1)
						); ?>
					</select>
					<table>
						<tr><th>Display</th><th>Source</th></tr>
						<tr><td>Content</td><td>Post excerpt</td></tr>
						<tr><td>Cite &amp; Title</td><td>Post title</td></tr>
						<tr><td>LInk</td><td>Post permalink</td></tr>
					</table>
				</div>
				<div class="testimonials-by-woothemes datasource_block">
					<table>
						<tr><th>Display</th><th>Source</th></tr>
						<tr><td>Content</td><td>Post excerpt</td></tr>
						<tr><td>Source</td><td>Post title &amp; Testimonial Details: Byline</td></tr>
						<tr><td>Link</td><td>Testimonial Details: Url</td></tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
</table>
</div>
<script>
(function ($) {
	"use strict";
	$(document).ready(function () {
		var display_active_datasource = function(active_datasource) {
			$('.<?php echo $this->get_field_id( "datasource" ); ?> .datasource_block').each( function() {
					if (this.className.indexOf(active_datasource)>=0) {
						$(this).addClass('make_visible');
					} else {
						$(this).removeClass('make_visible');
					}
			});
		}
		$('#<?php echo $this->get_field_id( "datasource" )?>').change(function()
		{
			var active_datasource = $(this).attr('value');
			display_active_datasource(active_datasource);
		});
		display_active_datasource('<?php echo $instance['datasource']; ?>');
	});
}(jQuery));
</script>