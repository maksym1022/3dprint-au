<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<div class="process-tabs">
	<ul>
		<a style="color:white" href="<?php echo get_permalink( 4861 ) //upload page ?>"><li>1. Upload</li></a>
		<li class="active">2. Quote</li>
		<li>3. Address</li>
		<li>4. Payment</li>
		<li>5. All Done!</li>
	</ul>
</div>

<form action="<?php esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-material"><?php _e( 'Material', 'woocommerce' ); ?></th>
			<th class="product-finish"><?php _e( 'Finish', 'woocommerce' ); ?></th>
			<!--th class="product-dimensions"><?php _e( 'Dimensions', 'woocommerce' ); ?></th-->
			<!-- <th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th> -->
			<th class="product-quantity"><?php _e( 'Qty', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>
		
		<?php
		
		$loop=1;
		$email=$_SESSION['stlemail'];				
		$stl_dir = $_SERVER["DOCUMENT_ROOT"] . "/STL/". $email ."/";
		$stl_url = get_site_url() . "/STL/". $email ."/";
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			/*echo '<pre>';
			print_r($cart_item);
			echo '</pre>';*/
			
			if( $loop == 1 )
				$filename=( isset($_GET['filename']) ? $_GET['filename'] : $cart_item['filename'] );
			
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td id="<?php echo "img_" . $cart_item_key ?>" class="product-thumbnail">
						<?php							
							if( isset( $filename ) && $filename == $cart_item['filename'] )
								$thumbnail = "<img src='". get_stylesheet_directory_uri() . "/images/blue-eye.png" ."' />";
							else
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
	
							if ( ! $_product->is_visible() || $product_id == 4868 || $product_id == 4928)
								echo $thumbnail;
							else{
								$separator=( substr( WC()->cart->get_cart_url(), -1)=="/" ? "?" : "&" );
								if( file_exists( $stl_dir . get_stl_image_name( $cart_item['filename'] ) ) )
									printf( '<a href="%s">%s</a>', WC()->cart->get_cart_url().$separator."filename=$cart_item[filename]", "<img src='". $stl_url. get_stl_image_name( $cart_item['filename'] ) ."'>" );
								else
									printf( '<a href="%s">%s</a>', WC()->cart->get_cart_url().$separator."filename=$cart_item[filename]", $thumbnail );
							
							}
						?>
						<!--click thumbnail - popup lightbox of larger image preview -->
						<div class="wrap-popup">
							<div class="popup">
								<a href="#" class="icon-close"></a>
								<div class="content-popup">
									<img id="image-lightbox" src="">
								</div>
							</div>
						</div>
						<!--end popup-->
					</td>
					
					<td class="product-name">
						<div><?php							
							if ( ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
							else
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );
								//echo sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $cart_item['filename'] );

							// Meta data
							//echo WC()->cart->get_item_data( $cart_item );
							?>
							<!--click thumbnail - popup lightbox of larger image preview -->
							<div class="wrap-popup">
								<div class="popup">
									<a href="#" class="icon-close"></a>
									<div class="content-popup">
										<img id="image-lightbox" src="">
									</div>
								</div>
							</div>
							<!--end popup-->
						<?php
               				// Backorder notification
               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
						?>
						</div>
						<?php		
							
							if( WC()->cart->cart_contents[$cart_item_key]['product_id'] == 4737 )
								$size = "mm";
							else if( WC()->cart->cart_contents[$cart_item_key]['product_id'] == 4745)
								$size = "inch";
							else
								$size = "";
							
						// Meta data
							echo WC()->cart->get_item_data( $cart_item ). " $size";
							echo 'mm';
						?>
						<!--display product not service (id:4868,4928 )-->
						<?php $product_ID = $cart_item['product_id'];
						
						if ($product_ID != 4868 && $product_ID != 4928){ ?>
							<a class="button-scale button" href="#" >Scale</a>
							<div class="wrap-popup">
								<div class="popup">
									<a href="#" class="icon-close"></a>
									<div class="content-popup scale">
										<h4>Scale your 3D model</h4>
										<p style="text-align: justify; ">Scale your part to the required size in mm.</p>
										<?php 
											$unit 		= $cart_item['pricing_item_meta_data'];
											$length_x 	= $unit['length'];
											$width_y 	= $unit['width'];
											$height_z 	= $unit['height'];
										?>
										<form id="form_change_dimension" class="form_change_dimension">
											<div id="dimension">
												<div class="item">
													<input type="text" name="scale" value="1" placeholder="2.0" style="background:yellow; color:black;"/>
													<p>Scale examples<br>0.1 = 1/10th<br>0.03937 > Inches<br>25.4 > mm</p>
												</div>
												<div class="item">
													<input type="text" name="value_x" class="dimensions" value="<?php echo $length_x;?>" placeholder="X" readonly/>mm
													<input type="hidden" name="hidden_value_x" value="<?php echo $length_x;?>" />
													<!--input type="hidden" name="hidden_submit_value_x" value="" /-->
													<p>X</p>
												</div>
												<div class="item">
													<input type="text" name="value_y" class="dimensions" value="<?php echo $width_y;?>" placeholder="Y" readonly/>mm
													<input type="hidden" name="hidden_value_y" value="<?php echo $width_y;?>" />
													<!--input type="hidden" name="hidden_submit_value_y" value="" /-->
													<p>Y</p>
												</div>
												<div class="item">
													<input type="text" name="value_z" class="dimensions" value="<?php echo $height_z;?>" placeholder="Z" readonly/>mm
													<input type="hidden" name="hidden_value_z" value="<?php echo $height_z;?>" />
													<!--input type="hidden" name="hidden_submit_value_z" value="" /-->
													<p>Z</p>
												</div>
											</div>
											<div class="item" style="display:none;">
												<select class="unit" id="unit">
													<option value="mm" <?php if($size == 'mm'){echo 'selected';} ?>>mm</option>
													<option value="inch" <?php if($size == 'inch'){echo 'selected';} ?>>inch</option>
													<input type="hidden" name="hidden_value_unit" value="<?php echo $size;?>" />
												</select>
											</div>
											<div class="clear"></div>
											<input type="button" id="button-cancel" value="Cancel" class="button" />
											<input type="submit" id="button-submit" value="Save" class="button alt" key-cart="<?php echo $cart_item_key; ?>" />
										</form>
									</div>
								</div>
							</div>
						<?php } ?>
					</td>
					
					<td class="product-material">
						<!--display product service not (id:4868,4928 )-->
						<?php if ($product_ID != 4868 && $product_ID != 4928){ ?>
							<?php if( $cart_item['material'] != '' ){
								$material_name = $cart_item['material'];
								$material_obj = get_term_by('name', $material_name, 'product_cat');
								$material_id = $material_obj->term_id;
								} ?>
							<select name="cart[<?php echo $cart_item_key; ?>][material]" id="<?php echo $cart_item_key; ?>-material" class="material">
							<?php 
								$cat_array = get_terms( 'product_cat', array('orderby' => 'id', 'order'=> 'ASC', 'hide_empty' => 0) );
								foreach( $cat_array as $cat ){
									if($cat->term_id == $material_id ){?>
										<option value="<?= $cat->term_id; ?>" selected ><?= $cat->name; ?></option>
									<?php }else{?>
										<option value="<?= $cat->term_id; ?>" ><?= $cat->name; ?></option>
							<?php } } ?>
							</select>
							<div>
								<?php 
								$args = array(
										'post_type'		=> 'product',
										'post_status'	=> 'publish',
										'tax_query'		=> array(
															array(
																'taxonomy'      => 'product_cat',
																'field' => 'term_id',
																'terms'         => $material_id
															)
														)
										);
								$products = query_posts($args);
								foreach( $products as $product ){
									echo '<small>' . $product->post_title . '</small>';
								}
								?>
							</div>
						<?php } ?>
					</td>
					
					<!--
					<td class="product-price">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>
					-->
					<td class="product-finish">
						<!--display product service not (id:4868,4928 )-->
						
						<?php if ($product_ID != 4868 && $product_ID != 4928){ ?>
							<?php 	
								$global_addon = get_page_by_title( 'Finish', '', 'global_product_addon' );
								$raw_addons = get_post_meta( $global_addon->ID, '_product_addons', true );
								foreach( $raw_addons as $raw_addon ){
									if( $raw_addon['name'] == "Finish" ){
										$options = $raw_addon['options'];
									}
								}
							?>
							<select name="cart[<?php echo $cart_item_key; ?>][finish]" id="<?php echo $cart_item_key; ?>-color">
								<?php foreach( $options as $option ){
									if( $option['label'] == $cart_item['finish'] ){
										echo '<option value="' . $option['label'] . '" selected>'. $option['label'] .'</option>';
									}else{
										echo '<option value="' . $option['label'] . '">'. $option['label'] .'</option>';
									}
								}
								?>
							</select>
						<?php } ?>
					</td>
					<td class="product-quantity">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
					</td>

					<td class="product-subtotal">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s&n='.time().'" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
			
			$loop++;
		}
		
		do_action( 'woocommerce_cart_contents' );
		?>	

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<div id="cart-action-wrapper">

	<div id="left" style="width: 48%; float: left;">
		<?php putRevSlider( "adverts_section" ); ?>
	</div> <!-- end left div -->
	
	<div id="right" style="float: right; width: 48%; text-align: right;">
		<div class="wrap_prior_check">
			<img src="<?php echo get_stylesheet_directory_uri()."/images/priority_service.jpg" ?>">
			<?php if(wordimpress_is_conditional_product_in_cart(PRIORITY_SHIPPING_PRODUCT_ID)){?>
				<input type="checkbox" name="prior_check" class="prior_check" value="yes_prior" checked />
			<?php } else { ?>
				<input type="checkbox" name="prior_check" class="prior_check" value="yes_prior" />
			<?php } ?>
			<label for="prior_check"><span class="color-word">Jump the queue </span>and upgrade to<span class="color-word" > Priority </span>for additional <?php // echo get_woocommerce_currency_symbol().wc_get_product( PRIORITY_SHIPPING_PRODUCT_ID )->get_price(); ?><?php echo wc_price(get_extra_cost());//wc_cart_totals_subtotal_html(); ?><br><span style="font-weight: normal;">Economy ships 7-14 days / <span class="color-word" > Priority </span> ships 4-7 days</span></label>
		</div>
		<div class="expertcheck" style="display: inline-block; border: 1px solid #bab9b9; padding: 10px;">
			<img src="<?php echo get_stylesheet_directory_uri()."/images/expert-ico.png" ?>">
			<?php if(wordimpress_is_conditional_product_in_cart(4868)){?>
			<input type="checkbox" name="expert_check" id="expert_check" value="yes" checked />
			<?php } else { ?>
			<input type="checkbox" name="expert_check" id="expert_check" value="yes" />
			<?php } ?>
			<label for="expert_check"><strong>Get an <span style="font-weight:bold;color:#1a6db5;">Expert Printability Check,</span> </strong>for $25 before we print your files</label>
			
			<script>
				jQuery(document).ready( function($){
					jQuery('#expert_check').live('change', function(){
						if(jQuery(this).is(":checked")){
							// ajax add to cart			 
							//window.location="?page_id=1024&add-to-cart=4868&n="+ new Date().getTime();
							window.location="?add-to-cart=4868&n="+ new Date().getTime();
						}
						else{
							//ajax remove add to cart
							<?php
							foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) { //get expert check cart item key
								if($cart_item['product_id'] == 4868 ){
									break;
								}
							} 
							?>
							var remove_url = "<?php echo WC_Cart::get_remove_url( $cart_item_key ) ?>";
							var remove_url = remove_url.replace(/&amp;/g, '&');
							window.location=remove_url;
						}
					});
					/*Jquery when click checkbox priority and popup priority will add product service to cart*/
					jQuery('.prior_check').live('change', function(){
						if(jQuery(this).is(":checked")){
							// ajax add to cart			 
							//window.location="?page_id=1024&add-to-cart=4928&n="+ new Date().getTime();
							window.location="?add-to-cart=4928&n="+ new Date().getTime();
						}
						else{
							//ajax remove add to cart
							<?php
							foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) { //get expert check cart item key
								if($cart_item['product_id'] == PRIORITY_SHIPPING_PRODUCT_ID ){
									break;
								}
							} 
							?>
							var remove_url = "<?php echo WC_Cart::get_remove_url( $cart_item_key ) ?>";
							var remove_url = remove_url.replace(/&amp;/g, '&');
							window.location=remove_url;
						}
					});

				});
			</script>
		</div>
	
		<div class="price" style="text-transform: uppercase; display: inline-block; font-size: 16px;">
			<!--Subtotal-->
			<div class="item-price bold">
				<p><?php _e( 'Subtotal', 'woocommerce' ); ?>:</p>
				<span><?php wc_cart_totals_subtotal_html(); ?></span>
			</div>
			<!--Freight-->
			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<div class="item-price">
				<p>Freight:</p>
				<span><?php echo WC()->cart->get_cart_shipping_total() ?></span>
			</div> 
			<?php endif; ?>
			<!--GST-->
			<div class="item-price">
				<p>GST:</p>
				<span><?php wc_cart_totals_taxes_total_html(); ?></span>
			</div>
			<!--Total-->
			<div class="item-price bold">
				<p><?php _e( 'Total', 'woocommerce' ); ?>:</p>
				<span><?php wc_cart_totals_order_total_html(); ?></span>
			</div>
		</div>
		<div class="actions">

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code" style="float: left;"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> 
						<div class="clear"></div>
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" style="float: left;width: 50%;" /> 
						<input type="submit" class="button" name="apply_coupon" value="<?php _e( 'APPLY COUPON', 'woocommerce' ); ?>" style="line-height: 15px;"/>

						<?php do_action('woocommerce_cart_coupon'); ?>
						<div class="clear"></div>
					</div>
				<?php } ?>
				<?php $email_user = isset($_SESSION['stlemail']) ? $_SESSION['stlemail'] : '';
				      $total =  WC()->cart->total;
				?>
				<input type="submit" class="button" id="send_email_total" name="send_email" style="background: white; color: #0ab1f0; border: 1px solid #c0c0c2;" value="<?php _e( 'Email me quote', 'woocommerce' ); ?>" />
				<input type="submit" class="button alt" name="update_cart" value="<?php _e( 'Update Quote', 'woocommerce' ); ?>" />
				<input type="submit" class="button alt" name="next_process" value="<?php _e( 'Next Step', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
		</div>
		
	</div> <!-- end right div -->
	
</div> <!-- end action wrap -->

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	<?php woocommerce_shipping_calculator(); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

<?php if(!isset($_COOKIE['popup'])){ ?>
<!--popup bottom-->
<div class="prior_popup slideUp show">
	<a class="icon-close" href="#"></a>
	<div class="prior_popup_content">
		<?php
			$page = get_page_by_path( 'priority','','page');
			$content = $page->post_content;
			if($page){
				$content = $page->post_content;
				if(!wordimpress_is_conditional_product_in_cart(4928)){
					$content = str_replace('checked="checked"', ' ', $content );
				}
				echo $content;
			}
			?>
			
		
	</div>
</div>
<!--end popup bottom-->
<?php } ?>
<?php
function wordimpress_is_conditional_product_in_cart( $product_id ) {
		//Check to see if user has product in cart
		global $woocommerce;

		foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];	
		if( $product_id == $_product->id ) {
			return true;
		}
		}
		return false;
}
?>