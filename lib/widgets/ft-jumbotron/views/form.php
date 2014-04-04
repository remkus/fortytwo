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
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'fortytwo'); ?></label>
				<input class="widefat" type="text" <?php $this->echo_field_id("title") ?>
					   value="<?php echo esc_attr($instance['title']); ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content:', 'fortytwo'); ?></label>
				<textarea class="widefat" <?php $this->echo_field_id("content") ?>
					><?php echo esc_textarea($instance['content']); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label
					for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('Button Text:', 'fortytwo'); ?></label>
				<input class="widefat" type="text" <?php $this->echo_field_id("button_text") ?>
					   value="<?php echo esc_attr($instance['button_text']); ?>"><br/>
				<label
					for="<?php echo $this->get_field_id('button_link'); ?>"><?php _e('Button Link:', 'fortytwo'); ?></label>
				<input class="widefat" type="text" <?php $this->echo_field_id("button_link") ?>
					   value="<?php echo esc_attr($instance['button_link']); ?>"><br/>
			</td>
		</tr>
	</table>
</div>