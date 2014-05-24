<?php
/**
 * FortyTwo Theme: Jumbotron Widget View
 *
 * Represents the view for the Jumbotron widget form in the backend.
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */
?>
<div class="ft-jumbotron-admin">
	<table style="width:100%">
		<tr>
			<td>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'fortytwo', 'fortytwo-dev' ); ?></label>
				<input class="widefat" type="text"<?php $this->id_name( 'title' ); ?> value="<?php echo esc_attr( $instance['title'] ); ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e( 'Content:', 'fortytwo', 'fortytwo-dev' ); ?></label>
				<textarea class="widefat"<?php $this->id_name( 'content' ); ?>><?php echo esc_textarea( $instance['content'] ); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link Text:', 'fortytwo', 'fortytwo-dev' ); ?></label>
				<input class="widefat" type="text"<?php $this->id_name( 'link_text' ); ?> value="<?php echo esc_attr( $instance['link_text'] ); ?>"><br/>
				<label for="<?php echo $this->get_field_id( 'link_url' ); ?>"><?php _e( 'Link URL:', 'fortytwo', 'fortytwo-dev' ); ?></label>
				<input class="widefat" type="text"<?php $this->id_name( 'link_url' ); ?> value="<?php echo esc_attr( $instance['link_url'] ); ?>"><br/>
			</td>
		</tr>
	</table>
</div>
