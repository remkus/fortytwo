<div class="ft-testimonials-admin">
<table>
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'fortytwo' ); ?></label>
			<input class="span2" type="text" <?php $this->echo_field_id( "title" ) ?> value="<?php echo esc_attr( $instance['title'] ); ?>">
		</td>
  </tr>
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit', 'fortytwo' ); ?></label>
			<input class="span2" type="text" <?php $this->echo_field_id( "limit" ) ?> value="<?php echo esc_attr( $instance['limit'] ); ?>">
		</td>
  </tr>
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'datasource' ); ?>"><?php _e( 'Datasource', 'fortytwo' ); ?></label> 
			<select <?php $this->echo_field_id( 'datasource' ) ?> class="widefat">
				<option <?php if ( '' == $instance['datasource'] ) echo 'selected="selected"'; ?>>==&gt;&nbsp;<?php _e( 'Select', 'fortytwo' ); ?>&nbsp;&lt;==</option>
				<option value="category" <?php if ( 'category' == $instance['datasource'] ) echo 'selected="selected"'; ?>><?php _e( 'Category', 'fortytwo' ); ?></option>
				<option value="testimonials_by_woothemes"  <?php if ( 'testimonials_by_woothemes' == $instance['datasource'] ) echo 'selected="selected"'; ?>><?php _e( 'Testimonials by Woothemes', 'fortytwo' ); ?></option>
			</select>
			<div class="<?php echo $this->get_field_id( 'datasource' ) ?>">
				<div class="category datasource_block">
					<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'fortytwo' ); ?></label> 
				  <select <?php $this->echo_field_id( "category" ) ?> class="widefat">
				  	<?php foreach ($instance['categories'] as $category) { ?>
						<option value="<?php echo esc_attr($category); ?>" <?php if ( $category == $instance['category'] ) echo 'selected="selected"'; ?>>
							<?php echo esc_html( __( $category, 'fortytwo' )); ?>
						</option>
						<?php } ?>
					</select>
				</div>
				<div class="testimonials_by_woothemes datasource_block">
					TODO
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
		$('#<?php echo $this->get_field_id( "datasource" )?>').change(function() 
		{
			var active_datasource = $(this).attr('value');
			$('.<?php echo $this->get_field_id( "datasource" ); ?> .datasource_block').each( function() {	
					if (this.className.indexOf(active_datasource)>=0) {
						$(this).addClass('make_visible');
					} else {
						$(this).removeClass('make_visible');
					}
			})
		});
	});
}(jQuery));
</script>