<?php
/**
 * Adds a Schema.org compliant contact widget.
 *
 * @package Genesis
 */

/**
 * ForSite Themes Contact widget class.
 *
 * @package Genesis
 * @subpackage Widgets
 * @since 0.1
 */
class FST_Contact_Widget extends WP_Widget {

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function FST_Contact_Widget() {
		$widget_ops = array( 
			'classname' 	=> 'fst-contact-widget', 
			'description' 	=> __( 'A Schema.org compliant Contact widget', 'fst_contact' )
                );
			
		$this->WP_Widget( 'fstcontact-widget', __('FST - Contact', 'fst_contact'), $widget_ops );
	}

	/**
	 * Echo the widget content.
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$instance = wp_parse_args( (array) $instance, array(
			'name' 		=> '',
			'phone' 	=> '',
			'fax' 		=> '',
			'email' 	=> '',
			'address'	=> '',
			'pc' 		=> '',
			'city' 		=> ''
			
		) );

		echo $before_widget.'<div class="contact-us" itemscope itemtype="http://schema.org/Organization">';


			echo $before_title . "Contact us" . $after_title;
			if( $instance['name']!='' ) {
				echo '<span class="company-name" itemprop="name">' . $instance['name'] . '</span>';
			}
			
			echo '<div class="full-address" itemprop="" itemscope itemtype="http://schema.org/PostalAddress">';
			
				if( $instance['address']!='' ) {
					echo '<span class="address" itemprop="streetAddress">' . $instance['address'] . '</span>';
				}
			
				if( $instance['pc']!='' ) {
					echo '<span class="postalcode" itemprop="postalCode">' . $instance['pc'] . '</span>';
				}
			
				if( $instance['city']!='' ) {
					echo '<span class="city" itemprop="addressLocality">' . $instance['city'] . '</span>';
				}
				
			echo '</div><!-- end .full-address-->';
			
			if( $instance['phone']!='' ) {
				echo '<span class="phone" itemprop="telephone">' . $instance['phone'] . '</span>';
			}
			
			if( $instance['fax']!='' ) {
				echo '<span class="fax" itemprop="faxNumber">' . $instance['fax'] . '</span>';
			}
			
			if( $instance['email']!='' ) {
				echo '<span class="email" itemprop="email"><a href="mailto:' . $instance['email'] . '">' . $instance['email'] . '</a></span>';
			}
			echo '</div><!-- end .contact-us-->';
			
			

		echo '</div>'.$after_widget;
	}

	/** Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {
		
		$new_instance['name'] 		= strip_tags( $new_instance['name'] );
		$new_instance['phone'] 		= strip_tags( $new_instance['phone'] );
		$new_instance['email'] 		= strip_tags( $new_instance['email'] );
		$new_instance['address'] 	= strip_tags( $new_instance['address'] );
		$new_instance['pc'] 		= strip_tags( $new_instance['pc'] );
		$new_instance['cityl'] 		= strip_tags( $new_instance['city'] );
		$new_instance['fax'] 		= strip_tags( $new_instance['fax'] );
		
		return $new_instance;
	}

	/** Echo the settings update form.
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
			'name' 		=> '',
			'phone' 	=> '',
			'email' 	=> '',
			'fax' 		=> '',
			'address' 	=> '',
			'pc' 		=> '',
			'city' 		=> '',
		) );

	?>
		<p>
		<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Company Name', 'fst_contact' ); ?>:</label><br />
		<input type="text" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address', 'fst_contact' ); ?>:</label><br />
		<input type="text" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo esc_attr( $instance['address'] ); ?>" class="widefat" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'pc' ); ?>"><?php _e( 'Postal Code', 'fst_contact' ); ?>:</label><br />
		<input type="text" id="<?php echo $this->get_field_id( 'pc' ); ?>" name="<?php echo $this->get_field_name( 'pc' ); ?>" value="<?php echo esc_attr( $instance['pc'] ); ?>" class="widefat" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e( 'City, Country', 'fst_contact' ); ?>:</label><br />
		<input type="text" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" value="<?php echo esc_attr( $instance['city'] ); ?>" class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone', 'fst_contact' ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>" class="widefat" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email', 'fst_contact' ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo esc_attr( $instance['email'] ); ?>" class="widefat" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e( 'Fax', 'fst_contact' ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" value="<?php echo esc_attr( $instance['fax'] ); ?>" class="widefat" />
		</p>

	<?php
	}
}

