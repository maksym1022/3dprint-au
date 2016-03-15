<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $is_checkout_page;

session_start();

$address_info = $_SESSION['address_info'];
?>
<div class="woocommerce-shipping-fields">

	<?php if ( WC()->cart->needs_shipping_address() === true ) : ?>

		<?php
			if ( empty( $_POST ) ) {

				$ship_to_different_address = get_option( 'woocommerce_ship_to_destination' ) === 'shipping' ? 1 : 0;
				$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

			} else {

				$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

			}
		?>
		<?php /*
		<h3 id="ship-to-different-address">
			<label for="ship-to-different-address-checkbox" class="checkbox"><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></label>
			<input id="ship-to-different-address-checkbox" class="input-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
		</h3>
		*/ ?>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<?php foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) : ?>
				
				<?php $field_value=$checkout->get_value( $key ); ?>
				
				<?php if ( $is_checkout_page ){ $field_value=$address_info[$key]; } ?>
				<?php 
					if($key == 'billing_email'){
						$field_value = isset($_SESSION['stlemail']) ? $_SESSION['stlemail'] : '';
						woocommerce_form_field( $key, $field, ( !empty($field_value) ? $field_value : $address_info[$key] ) );
					}else{
						woocommerce_form_field( $key, $field, ( !empty($field_value) ? $field_value : $address_info[$key] ) );
					}
				?>
				
			<?php endforeach; ?>
			
			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) : ?>

			<h3><?php _e( 'Additional Information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>
			<?php $field_value=$checkout->get_value( $key ); ?>
			
			<?php if ( $is_checkout_page ){ $field_value=$address_info[$key]; } ?>
			
			<?php woocommerce_form_field( $key, $field, ( !empty($field_value) ? $field_value : $address_info[$key] ) ); ?>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>

	<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

		<?php if ( $checkout->enable_guest_checkout ) : ?>

			<p class="form-row form-row-wide create-account">
				<input class="input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>

			<div class="create-account">

				<p>If you are a returning customer <a href="<?php echo get_site_url(); ?>/my-account">login</a> otherwise enter your password below.</p>

				<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>
				
					<?php $field_value=$checkout->get_value( $key ); ?>
					
					<?php if ( $is_checkout_page ){ $field_value=$address_info[$key]; } ?>
					
					<?php woocommerce_form_field( $key, $field, ( !empty($field_value) ? $field_value : $address_info[$key] ) ); ?>

				<?php endforeach; ?>

				<div class="clear"></div>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	<?php endif; ?>
</div>
