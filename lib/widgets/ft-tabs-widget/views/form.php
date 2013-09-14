<!-- Widget Title: Text Input -->
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (optional):', 'fortytwo' ); ?></label>
  <input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo $instance['title']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
</p>
<div class="genesis-widget-column">
  <div class="genesis-widget-column-box genesis-widget-column-box-top">
    <p><span class="description">Choose up to 4 tabs to display</span></p>
    <p><?php $this->render_tabs_dropdown( $this->available_tabs, $instance['tabs'], 0 ) ?></p>
    <p><?php $this->render_tabs_dropdown( $this->available_tabs, $instance['tabs'], 1 ) ?></p>
    <p><?php $this->render_tabs_dropdown( $this->available_tabs, $instance['tabs'], 2 ) ?></p>
    <p><?php $this->render_tabs_dropdown( $this->available_tabs, $instance['tabs'], 3 ) ?></p>
  </div>
</div>

<div class="genesis-widget-column genesis-widget-column-right">

  <div class="genesis-widget-column-box genesis-widget-column-box-top">
    <!-- Widget Limit: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'fortytwo' ); ?></label>
      <input type="text" name="<?php echo $this->get_field_name( 'limit' ); ?>"  value="<?php echo $instance['limit']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" />
    </p>
    <!-- Widget Image Dimension: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id( 'image_dimension' ); ?>"><?php _e( 'Image Dimension:', 'fortytwo' ); ?></label>
      <input type="text" name="<?php echo $this->get_field_name( 'image_dimension' ); ?>"  value="<?php echo $instance['image_dimension']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'image_dimension' ); ?>" />
    </p>
    <!-- Widget Image Alignment: Select Input -->
    <p>
      <label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Image Alignment:', 'fortytwo' ); ?></label>
      <select name="<?php echo $this->get_field_name( 'image_alignment' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'image_alignment' ); ?>">
        <option value="left"<?php selected( $instance['image_alignment'], 'left' ); ?>><?php _e( 'Left', 'fortytwo' ); ?></option>
        <option value="right"<?php selected( $instance['image_alignment'], 'right' ); ?>><?php _e( 'Right', 'fortytwo' ); ?></option>
      </select>
    </p>

    <p>
      <small>
        <?php
if ( current_theme_supports( 'post-thumbnails' ) ) {
  _e( 'The "featured image" will be used as thumbnails.', 'fortytwo' );
} else {
  _e( 'Post thumbnails are not supported by your theme. Thumbnails will not be displayed.', 'fortytwo' );
}
?>
      </small>
    </p>
  </div>

</div>
<?php

// Allow child themes/plugins to act here.
do_action( $this->fst_widget_idbase . '_widget_settings', $instance, $this );
