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
				<?php foreach ($instance['datasources'] as $datasource) { ?>
				<option value="<?php echo $datasource['value']; ?>" <?php if ( $datasource['value'] == $instance['datasource'] ) echo 'selected="selected"'; ?>>
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
				</div>
				<div class="testimonials-by-woothemes datasource_block">
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