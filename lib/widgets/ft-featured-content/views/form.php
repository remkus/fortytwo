<?php
/**
 * Represents the view for the featured content widget form in the backend.
 */
?>

<div class="ft-featured-content-admin">
<input type="hidden" <?php $this->echo_field_id( "icon" ) ?> value="<?php echo esc_attr( $instance['icon'] ); ?>">
<table style="width: 100%">
	<tr>
		<td class="<?php echo $this->get_field_id( "the-icon-selector" )?>">
				<div >
					<i class="ft-ico ft-ico-arrow-circle-right ft-ico-2x"></i>
				</div>
		</td>
		<td>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Title:', 'fortytwo' ); ?></label>
			<input class="widefat" type="text" <?php $this->echo_field_id( "title" ) ?>  value="<?php echo esc_attr( $instance['title'] ); ?>">
		</td>
  </tr>
	<tr><td colspan="2">
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Content:', 'fortytwo' ); ?></label>
		  <textarea class="widefat" <?php $this->echo_field_id( "content" ) ?>
		  	><?php echo esc_textarea( $instance['content'] ); ?></textarea>
  </td></tr>
	<tr><td colspan="2">
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text:', 'fortytwo' ); ?></label>
			<input class="widefat" type="text" <?php $this->echo_field_id( "button_text" ) ?> value="<?php echo esc_attr( $instance['button_text'] ); ?>"><br />
		  <label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Link:', 'fortytwo' ); ?></label>
		  <input class="widefat" type="text" <?php $this->echo_field_id( "button_link" ) ?> value="<?php echo esc_attr( $instance['button_link'] ); ?>">
		</td>
	</tr>
</table>
</div>
<script>
(function ($) {
	"use strict";
	$(document).ready(function () {
		var iconSaveInputElement = '#<?php echo $this->get_field_id( "icon" )?>',
			  selectedIcon = '<?php echo $instance["icon"]; ?>',
			  iconSelectorElement = '.<?php echo $this->get_field_id( "the-icon-selector" )?>';
		window.FontAwesomeIconSelectorApp.attachApp(selectedIcon, iconSelectorElement, iconSaveInputElement);
	});
}(jQuery));
</script>
