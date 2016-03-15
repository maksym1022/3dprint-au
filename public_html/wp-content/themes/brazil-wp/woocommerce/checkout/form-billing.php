<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $is_checkout_page;

session_start();

$address_info = $_SESSION['address_info'];

if ( !empty( $_POST ) && !isset( $_POST['same_billing_address'] ) ) {
	$same_billing_address = 'hidden';
}else {
	$same_billing_address = $_SESSION['same_billing_address'];
}

//echo "<pre>"; var_dump( $address_info ); echo "</pre>";
?>
<style>
	.chosen-container{ width:100% !important; }
</style>
<h3 id="ship-to-different-address" style="display: inline-block;">
	<input id="same_billing_address_checkbox" class="input-checkbox" <?php checked( $same_billing_address, '' ); ?> type="checkbox" name="same_billing_address" value="" />
	<?php if($is_checkout_page){?>
	<input id="ship_to_different_address" class="input-checkbox" <?php checked( $same_billing_address, 'hidden' ); ?> type="checkbox" name="ship_to_different_address" value="hidden" />
	<?php } ?>
	<label for="same_billing_address_checkbox" class="checkbox"><?php _e( 'My billing address is the same', 'woocommerce' ); ?></label>
</h3>

<div class="woocommerce-billing-fields" <?php if( is_page_template ( 'shipping-address.php' ) && $same_billing_address=="" ) echo "style='display:none;'" ?>>
	<?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Billing Details', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<?php foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : ?>
		
		<?php $field_value=$checkout->get_value( $key ); ?>
		
		<?php if ( $is_checkout_page ){ $field_value=$address_info[$key]; } ?>

		<?php woocommerce_form_field( $key, $field, ( !empty($field_value) ? $field_value : $address_info[$key] ) ); ?>

	<?php endforeach; ?>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

	
</div>

<!--div class="priority" style="display: inline-block; border: 1px solid #bab9b9; padding: 10px;width: 50%; float: right;">
	<input type="checkbox" name="priority_shipping" id="priority_shipping" <?php checked( (!empty($_POST) ? $_POST['priority_shipping'] : $_SESSION['priority_shipping']), '1' ); ?> value="1" />
	<style>.amount{font-weight:bold;}</style>
<label for="priority_shipping"><strong>Upgrade to <img style="width: 15px; margin-top: -1px;" src="<?php echo get_stylesheet_directory_uri()."/images/exclamation-mark-red-md.png" ?>"><span style="font-weight:bold;color:#1a6db5;"> Priority Print & Shipping</span> service for additional <?php echo wc_price( get_extra_cost() ) ?> </strong></label><br>Priority Service 4-7 days & Standard Economy 7-12 days.
</div-->

<script>
	/*
	jQuery(document).ready( function(){
		var same_billing = jQuery('input[name=same_billing_address]:checked').length;
		if( !same_billing )
			jQuery( 'div.woocommerce-billing-fields' ).hide();
			
	}); */
	jQuery(document).ready( function(){		
		jQuery('input[name=same_billing_address]').live( 'change', function(){
			var same_billing = jQuery('input[name=same_billing_address]:checked').length;
			if( same_billing )
				jQuery( 'div.woocommerce-billing-fields' ).fadeOut('slow');
			else
				jQuery( 'div.woocommerce-billing-fields' ).fadeIn('slow');
		});		
	});
</script>