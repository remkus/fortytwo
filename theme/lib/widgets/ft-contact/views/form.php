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
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'fortytwo' ); ?>:</label><br />
<input type="text"<?php $this->id_name( 'title' ); ?> value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Company Name', 'fortytwo' ); ?>:</label><br />
<input type="text"<?php $this->id_name( 'name' ); ?> value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" autocomplete="name" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Street Address', 'fortytwo' ); ?>:</label><br />
<input type="text"<?php $this->id_name( 'address' ); ?> value="<?php echo esc_attr( $instance['address'] ); ?>" class="widefat" autocomplete="street-address" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'zip' ); ?>"><?php _e( 'Postal Code', 'fortytwo' ); ?>:</label><br />
<input type="text"<?php $this->id_name( 'zip' ); ?> value="<?php echo esc_attr( $instance['zip'] ); ?>" class="widefat" autocomplete="postal-code" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e( 'City, Country', 'fortytwo' ); ?>:</label><br />
<input type="text"<?php $this->id_name( 'city' ); ?> value="<?php echo esc_attr( $instance['city'] ); ?>" class="widefat" autocomplete="locality" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone', 'fortytwo' ); ?>:</label>
<input type="text"<?php $this->id_name( 'phone' ); ?> value="<?php echo esc_attr( $instance['phone'] ); ?>" class="widefat" autocomplete="tel" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email', 'fortytwo' ); ?>:</label>
<input type="text"<?php $this->id_name( 'email' ); ?> value="<?php echo esc_attr( $instance['email'] ); ?>" class="widefat"  autocomplete="email" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e( 'Fax', 'fortytwo' ); ?>:</label>
<input type="text"<?php $this->id_name( 'fax' ); ?> value="<?php echo esc_attr( $instance['fax'] ); ?>" class="widefat" />
</p>
