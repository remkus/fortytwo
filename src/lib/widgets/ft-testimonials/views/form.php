<?php
/**
 * FortyTwo Theme: Testimonials Widget View
 *
 * Represents the view for the Testimonials Widget in the backend.
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */
?>
<div class="ft-testimonials-admin">
<table style="width:100%">
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'fortytwo', 'fortytwo-dev' ); ?></label>
			<input class="widefat" type="text"<?php $this->id_name( 'title' ); ?> value="<?php echo esc_attr( $instance['title'] ); ?>">
		</td>
  </tr>
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'fortytwo', 'fortytwo-dev' ); ?></label>
			<input class="widefat" type="text"<?php $this->id_name( 'limit' ); ?> value="<?php echo esc_attr( $instance['limit'] ); ?>">
		</td>
  </tr>
	<tr>
		<td>
			<label for="<?php echo $this->get_field_id( 'datasource' ); ?>"><?php _e( 'Datasource:', 'fortytwo', 'fortytwo-dev' ); ?></label>
			<select class="widefat"<?php $this->id_name( 'datasource' ); ?> >
				<option class="widefat"<?php selected( $instance['datasource'], '' ); ?>><?php _e( ' - Select - ', 'fortytwo', 'fortytwo-dev' ); ?></option>
				<?php foreach ( $this->get_datasources() as $datasource ) { ?>
				<option class="widefat" value="<?php echo esc_attr( $datasource['value'] ); ?>"<?php selected( $instance['datasource'], $datasource['value'] ); ?>>
					<?php echo $datasource['name']; ?>
				</option>
				<?php } ?>
			</select>
			<div class="<?php echo sanitize_html_class( $this->get_field_id( 'datasource' ) ); ?>">
				<div class="category datasource_block">
					<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'fortytwo', 'fortytwo-dev' ); ?></label>
					<?php wp_dropdown_categories(array(
						'id'           => $this->get_field_id( 'category' ),
						'name'         => $this->get_field_name( 'category' ),
						'selected'     => $instance['category'],
						'show_count'   => 1,
						'hierarchical' => 1,)
						); ?>
					</select>
					<table>
						<tr><th>Display</th><th>Source</th></tr>
						<tr><td>Content</td><td>Post excerpt</td></tr>
						<tr><td>Cite &amp; Title</td><td>Post title</td></tr>
						<tr><td>Link</td><td>Post permalink</td></tr>
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
	'use strict';
	$(document).ready(function () {
		var display_active_datasource = function( active_datasource ) {
			$( '.<?php echo $this->get_field_id( 'datasource' ); ?> .datasource_block' ).each( function() {
					if (this.className.indexOf(active_datasource)>=0) {
						$(this).addClass( 'make_visible' );
					} else {
						$(this).removeClass( 'make_visible' );
					}
			});
		};

		$( '#<?php echo $this->get_field_id( 'datasource' ); ?>' ).change( function() {
			var active_datasource = $(this).attr( 'value' );
			display_active_datasource( active_datasource );
		});
		display_active_datasource( '<?php echo $instance['datasource']; ?>' );
	});
}( jQuery ) );
</script>
