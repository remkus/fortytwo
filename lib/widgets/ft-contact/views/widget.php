<?php
/**
 * FortyTwo Theme: Contact Widget
 *
 * This file provides the output of the Widget
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */
?>
<div class="contact-us" itemscope itemtype="http://schema.org/Organization">
<?php echo $before_title . ' ' . esc_html( $instance['title'] ) . ' ' . $after_title; ?>
<?php
		if ( $instance['name']!='' ) {
			echo '<span class="company-name" itemprop="name">' . $instance['name'] . '</span>';
		}
?>
<div class="full-address" itemprop="" itemscope itemtype="http://schema.org/PostalAddress">
<?php
		if ( $instance['address']!='' ) {
			echo '<span class="address" itemprop="streetAddress">' . $instance['address'] . '</span>';
		}
 ?>
 <?php
		if ( $instance['pc']!='' ) {
			echo '<span class="postalcode" itemprop="postalCode">' . $instance['pc'] . '</span>';
		}
 ?>
 <?php
		if ( $instance['city']!='' ) {
			echo '<span class="city" itemprop="addressLocality">' . $instance['city'] . '</span>';
		}
	?>
	</div><!-- end .full-address-->
	<?php
		if ( $instance['phone']!='' ) {
			echo '<span class="phone" itemprop="telephone">' . $instance['phone'] . '</span>';
		}
	?>
	<?php
		if ( $instance['fax']!='' ) {
			echo '<span class="fax" itemprop="faxNumber">' . $instance['fax'] . '</span>';
		}
	?>
	<?php
		if ( $instance['email']!='' ) {
			echo '<span class="email" itemprop="email"><a href="mailto:' . $instance['email'] . '">' . $instance['email'] . '</a></span>';
		}
	?>
	</div><!-- end .contact-us-->
</div>