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
<div class="contact-us" itemscope itemtype="http://schema.org/Organization">
<?php
if ( $instance['title'] ) {
	echo $args['before_title'] . ' ' . esc_html( $instance['title'] ) . ' ' . $args['after_title'];
}

if ( $instance['name'] ) {
	echo '<span class="company-name" itemprop="name">' . $instance['name'] . '</span>';
}
?>
<div class="full-address" itemprop="" itemscope itemtype="http://schema.org/PostalAddress">
<?php
if ( $instance['address'] ) {
	echo '<span class="address" itemprop="streetAddress">' . $instance['address'] . '</span>';
}

if ( $instance['pc'] ) {
	echo '<span class="postalcode" itemprop="postalCode">' . $instance['pc'] . '</span>';
}

if ( $instance['city'] ) {
	echo '<span class="city" itemprop="addressLocality">' . $instance['city'] . '</span>';
}
?>
</div>
<?php
if ( $instance['phone'] ) {
	echo '<span class="phone" itemprop="telephone">' . $instance['phone'] . '</span>';
}

if ( $instance['fax'] ) {
	echo '<span class="fax" itemprop="faxNumber">' . $instance['fax'] . '</span>';
}

if ( $instance['email'] ) {
	echo '<span class="email" itemprop="email"><a href="' . esc_url( 'mailto:' . $instance['email'] ) . '">' . $instance['email'] . '</a></span>';
}
?>
</div>
