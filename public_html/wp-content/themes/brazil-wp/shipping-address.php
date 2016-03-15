<?php

/*

Template Name: Shipping Address

*/

/* Check cart content */
if ( sizeof( WC()->cart->get_cart() ) == 0 ){
	$cart_url=esc_url( WC()->cart->get_cart_url() );
	wp_safe_redirect( $cart_url ); // If cart is empty then redirect to cart page
	exit();
}
get_header();

GLOBAL $webnus_options, $woocommerce, $webnus_page_options_meta;

$checkout = WC()->checkout();

$show_titlebar = null;
$titlebar_bg = null;
$titlebar_fg = null;
$have_sidebar = false;
$sidebar_pos = null;

$meta = $webnus_page_options_meta->the_meta();

if(!empty($meta)){
$show_titlebar =  isset($meta['webnus_page_options'][0]['show_page_title_bar'])?$meta['webnus_page_options'][0]['show_page_title_bar']:null;
$titlebar_bg =  isset($meta['webnus_page_options'][0]['title_background_color'])?$meta['webnus_page_options'][0]['title_background_color']:null;
$titlebar_fg =  isset($meta['webnus_page_options'][0]['title_text_color'])?$meta['webnus_page_options'][0]['title_text_color']:null;
$titlebar_fs =  isset($meta['webnus_page_options'][0]['title_font_size'])?$meta['webnus_page_options'][0]['title_font_size']:null;
$sidebar_pos =  isset($meta['webnus_page_options'][0]['sidebar_position'])?$meta['webnus_page_options'][0]['sidebar_position']:'right';
$have_sidebar = !( 'none' == $sidebar_pos )? true : false;

}
if($show_titlebar && ( 'show' == $show_titlebar)):
?>
<section id="headline" style="<?php

/// To change the title bar background color
if(!empty($titlebar_bg)) echo ' background-color:'.$titlebar_bg.';'; 

/// To change the title bar text color 


 ?>">
    <div class="container">
      <h3 style="<?php /* TEXT COLOR OF TITLE */ if(!empty($titlebar_fg)) echo ' color:'.$titlebar_fg.';'; if(!empty($titlebar_fs)) echo ' font-size:'.$titlebar_fs.';';  ?>"><?php the_title(); ?></h3>
      
    </div>
</section>
<?php
endif;
?>

<?php
$step = $_GET['step'];
if($step == '')
	$step = 1;
?>

<section id="main-content" class="container">
<div class="woocommerce">
	<div class="process-tabs">
		<ul>
			<a style="color:white" href="<?php echo get_permalink( 4861 ) //upload page ?>"><li>1. Upload</li></a>
			<a style="color:white" href="<?php echo get_permalink( 1024 ) //quote/cart page ?>"><li>2. Quote</li></a>
			<li class="active">3. Address</li>
			<li>4. Payment</li>
			<li>5. All Done!</li>
		</ul>
	</div>
	
	<?php
	
	// Show non-cart errors
		wc_print_notices();
	
	// If checkout registration is disabled and not logged in, the user cannot checkout
	if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
		echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
		return;
	}

	// filter hook for include new pages inside the payment method
	$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

	<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" enctype="multipart/form-data">

		<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

			<div class="col2-set" id="customer_details">
				<div class="col-full">

					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					
					<?php do_action( 'woocommerce_checkout_billing' ); ?>

				</div>
			</div>			

		<?php endif; ?>
		<div class="form-row next-step" style="text-align:right;">
			<?php wp_nonce_field( 'customwoocommerce-set_address' ); ?>
			<input type="submit" class="button alt" name="set_address" id="next_step" value="<?php  _e( 'Next Step', 'woocommerce' ) ?>" />
			<input type="hidden" value="set_address" name="action">		
		</div>
	</form>

</div>

</section>

<?php get_footer(); ?>