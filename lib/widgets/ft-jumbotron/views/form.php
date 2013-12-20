<div class="ft-jumbotron-admin">
<table style="width:100%">
	<tr><td>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'fortytwo' ); ?></label>
			<input class="widefat" type="text" <?php $this->echo_field_id( "title" ) ?> value="<?php echo esc_attr( $instance['title'] ); ?>">
		</td>
  </tr>
	<tr><td>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e( 'Content:', 'fortytwo' ); ?></label>
		  <textarea class="widefat" <?php $this->echo_field_id( "content" ) ?>
		  	><?php echo esc_textarea( $instance['content'] ); ?></textarea>
  </td></tr>
	<tr><td>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text:', 'fortytwo' ); ?></label>
			<input class="widefat" type="text" <?php $this->echo_field_id( "button_text" ) ?> value="<?php echo esc_attr( $instance['button_text'] ); ?>"><br />
		  <label for="<?php echo $this->get_field_id( 'button_link' ); ?>"><?php _e( 'Button Link:', 'fortytwo' ); ?></label>
		  <input class="widefat" type="text" <?php $this->echo_field_id( "button_link" ) ?> value="<?php echo esc_attr( $instance['button_link'] ); ?>"><br />
		  <label for="<?php echo $this->get_field_id( 'button_alignment' ); ?>"><?php _e( 'Button Alignment:', 'fortytwo' ); ?></label>
		  <select <?php $this->echo_field_id( "button_alignment" ) ?> class="widefat">
				<option <?php if ( 'left' == $instance['button_alignment'] ) echo 'selected="selected"'; ?>>left</option>
				<option <?php if ( 'right' == $instance['button_alignment'] ) echo 'selected="selected"'; ?>>right</option>
			</select>
		</td>
	</tr>
</table>
</div>