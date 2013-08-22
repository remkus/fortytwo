<p>
<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Company Name', 'fortytwo' ); ?>:</label><br />
<input type="text" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address', 'fortytwo' ); ?>:</label><br />
<input type="text" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo esc_attr( $instance['address'] ); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'pc' ); ?>"><?php _e( 'Postal Code', 'fortytwo' ); ?>:</label><br />
<input type="text" id="<?php echo $this->get_field_id( 'pc' ); ?>" name="<?php echo $this->get_field_name( 'pc' ); ?>" value="<?php echo esc_attr( $instance['pc'] ); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e( 'City, Country', 'fortytwo' ); ?>:</label><br />
<input type="text" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" value="<?php echo esc_attr( $instance['city'] ); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone', 'fortytwo' ); ?>:</label>
<input type="text" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email', 'fortytwo' ); ?>:</label>
<input type="text" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo esc_attr( $instance['email'] ); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e( 'Fax', 'fortytwo' ); ?>:</label>
<input type="text" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" value="<?php echo esc_attr( $instance['fax'] ); ?>" class="widefat" />
</p>
