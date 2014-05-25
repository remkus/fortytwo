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
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (optional):', 'fortytwo', 'fortytwo-dev' ); ?></label>
  <input type="text"<?php $this->id_name( 'title' ); ?> value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
</p>
<div class="genesis-widget-column">
  <div class="genesis-widget-column-box genesis-widget-column-box-top">
	<p><span class="description"><?php _e( 'Choose up to 4 tabs to display', 'fortytwo', 'fortytwo-dev' ); ?></span></p>
	<p><?php $this->render_tabs_dropdown( $this->available_tabs, $instance['tabs'], 0 ); ?></p>
	<p><?php $this->render_tabs_dropdown( $this->available_tabs, $instance['tabs'], 1 ); ?></p>
	<p><?php $this->render_tabs_dropdown( $this->available_tabs, $instance['tabs'], 2 ); ?></p>
	<p><?php $this->render_tabs_dropdown( $this->available_tabs, $instance['tabs'], 3 ); ?></p>
  </div>
</div>

<div class="genesis-widget-column genesis-widget-column-right">

  <div class="genesis-widget-column-box genesis-widget-column-box-top">
	<p>
	  <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'fortytwo', 'fortytwo-dev' ); ?></label>
	  <input type="text"<?php $this->id_name( 'limit' ); ?> value="<?php echo $instance['limit']; ?>" class="widefat" />
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size (px):', 'fortytwo', 'fortytwo-dev' ); ?></label>
	  <input type="text"<?php $this->id_name( 'image_size' ); ?> value="<?php echo $instance['image_size']; ?>" class="widefat" />
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Image Alignment:', 'fortytwo', 'fortytwo-dev' ); ?></label>
	  <select<?php $this->id_name( 'image_alignment' ); ?> class="widefat">
		<option value="left"<?php selected( $instance['image_alignment'], 'left' ); ?>><?php _e( 'Left', 'fortytwo', 'fortytwo-dev' ); ?></option>
		<option value="right"<?php selected( $instance['image_alignment'], 'right' ); ?>><?php _e( 'Right', 'fortytwo', 'fortytwo-dev' ); ?></option>
	  </select>
	</p>

	<p>
	  <small>
		<?php
if ( current_theme_supports( 'post-thumbnails' ) ) {
	_e( 'The "featured image" will be used as thumbnails.', 'fortytwo', 'fortytwo-dev' );
} else {
	_e( 'Post thumbnails are not supported by your theme. Thumbnails will not be displayed.', 'fortytwo', 'fortytwo-dev' );
}
?>
	  </small>
	</p>
  </div>

</div>
<?php

// Allow child themes/plugins to act here.
do_action( "{$this->slug}_widget_settings", $instance, $this );
