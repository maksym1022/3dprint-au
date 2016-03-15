<?php
/*
Plugin Name: Instant Quote
Description: Upload STL file and get instant quote
Version: 1.0
*/
/*
session_start();
require_once 'Mailchimp.php';

add_action( 'wp_ajax_submit_user_email_to_mailchimp', 'submit_user_email_to_mailchimp' );
add_action( 'wp_ajax_nopriv_submit_user_email_to_mailchimp', 'submit_user_email_to_mailchimp' );
function submit_user_email_to_mailchimp(){
	if(!is_user_logged_in()){
		$email = $_POST['email'];
		$api_key = '3868b4a606bd63efcaff90e43ddb8a94-us2';
		$mailchimp = new Mailchimp($api_key);
		$list_id = 'd37abd9e50';
		$rs = $mailchimp->lists->subscribe($list_id,array('email' => $email));
		$html = "<h1 style='color:#42A3CA;'>Welcome to 3DPrint-NZ.com</h1>
			<p>Thanks for signing up to get a quote for your 3D model.</p>
			<h3>Pricing </h3>
			<p>Our pricing couldn’t be any easier to work out. We charge by the bounding box of the shape, not by how much material is used. Or send us any quote and we’ll beat it with our Economy pricing. “It’s like buying an esky and getting the beers for free.”</p>
			<h3>Benefits of SLS Nylon</h3>
			<p>Our industrial Elite Selective Laser Sintering machine makes functional parts that are durable, heat and chemical resistant with an excellent surface quality. Not only that, they are tough like a $2 steak!</p>
			<h3>Production Runs</h3>
			<p>The benefit of printing with SLS offers the ability to rapidly manufacture a volume of products without changing tools for every design interaction. 3D Printing one or a thousand parts will cost you the same for each part. That’s transparent pricing.</p>
			<h3>Secret Squirrel</h3>
			<p>When you upload your models to us, you enter into an NDA (Non Disclosure Agreement) with 3DPrint-NZ. We take your IP (Intellectual Property) very seriously and will not share your designs with any third parties. “Just don’t ask us to 3d print guns”</p>
			<p>Cheers!</p>
			<p>Happy Printing ~ The 3DPrint-NZ.com Team</p>";
		$from 		= get_option('admin_email');
		$blogname 	= get_option('blogname');
		$subject 	= 'Welcome to 3DPrint-NZ.com';
		$headers  	= 'MIME-Version: 1.0' . "\r\n";
		$headers 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers 	.= 'From: '.$blogname.' <'.$from.'>'. "\r\n";
		wp_mail( $email, $subject, $html, $headers);

		echo 'success';
		exit;
	}
	echo 'failed';
	exit;
}
*/
error_reporting(0);
ini_set('display_errors', 0);
session_start();

define( 'MM_PRODUCT_ID', '4867' );
define( 'INCH_PRODUCT_ID', '4866' );
define( 'EXPERT_CHECK_ID', '4868' );
define( 'PRIORITY_SHIPPING_PRODUCT_ID', '4928' );
define( 'UPLOAD_PAGE', '4861' );
define( 'QUOTE_PAGE', '1024' );
define( 'ADDRESS_PAGE', '4870' );
define( 'PAYMENT_PAGE', '1025' );

function instant_quote_scripts() {
	wp_enqueue_style( 'quote-style', plugins_url( 'quote.css' , __FILE__ ) );
	wp_localize_script( 'jquery', 'brazil_wp', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'wp_enqueue_scripts', 'instant_quote_scripts' );

//upload stl file
function upload_stl(){

	if(isset($_GET['task']) && $_GET['task']=='stlupload'){
		$email = $_GET['email'];
		$unit = $_GET['unit'];
		$stl_dir = ABSPATH ."/STL/". $email ."/";
		if (!file_exists($stl_dir)) { 
		    mkdir($stl_dir);
		}
		foreach ($_FILES as $fieldName => $file) {
			if( !empty($email) && (strtolower(substr($file['name'], -3))=="stl" || strtolower(substr($file['name'], -3))=="zip")){
				move_uploaded_file($file['tmp_name'], $stl_dir . clear_character_special($file['name'])); //move uploaded files to email directory
				
				if( file_exists( $stl_dir . clear_character_special($file['name']) ) && strtolower(substr($file['name'], -3))=="stl" ){
					add_stl_to_cart( clear_character_special($file['name']),$unit, $email ); //add file to cart 
				}
			}
		}
		
		die();		
	}
}

add_action( 'init', 'upload_stl');

//clear characte special
function clear_character_special($string){
	return preg_replace('/[^A-Za-z0-9\.]/', '', $string);
}

//add_files_to_cart();
function add_files_to_cart(){
	global $woocommerce;
	
	if(isset($_REQUEST['action']) && $_REQUEST['action']=='add_to_cart'){
	
		//session_start();
		$_SESSION['stlemail']=$_REQUEST['email'];
		
		wp_safe_redirect( esc_url( WC()->cart->get_cart_url() ) ); //redirect to cart page after add items
		die();
		/* skip process below */

		$unit=$_REQUEST['unit'];
		
		if ($handle = opendir('STL/'.$_SESSION['stlemail'])) {
			$result=array();
		    while (false !== ($entry = readdir($handle))) {
				//echo substr($entry, -4)."<br>";
		        add_stl_to_cart( $entry,$unit, $_SESSION['stlemail'] );
		    }
		    closedir($handle);
		    //exit();
			wp_safe_redirect( esc_url( WC()->cart->get_cart_url() ) ); //redirect to cart page after add items
		}
		die();
	}	
	
}
add_action( 'init', 'add_files_to_cart');

function add_stl_to_cart( $filename, $unit, $email ){
	
	include_once("STLBox.php");
	
	if($unit=="sq mm")
	{
		$unit="cu mm";
		$productid=MM_PRODUCT_ID;
		$unit_box="mm";
	}
	else
	{
		$unit="cu. in.";
		$productid=INCH_PRODUCT_ID;
		$unit_box="inch";
	}
	
	if ($filename != "." && $filename != ".." && strtolower(substr($filename, -4))=='.stl') {	            
		$stlpath = ABSPATH. '/STL/'.$email."/". $filename;
		$obj = new STLStats($stlpath);
		
		$bbox = $obj->getBBox($unit_box);
		$length = round( $bbox["length"], 1 );
		$width  = round( $bbox["width"], 1 );
		$height = round( $bbox["height"], 1 );
		$measurement= $length * $width * $height;
		$cart_item_data['pricing_item_meta_data']['length']=$length;
		$cart_item_data['pricing_item_meta_data']['width']=$width;
		$cart_item_data['pricing_item_meta_data']['height']=$height;
		$cart_item_data['pricing_item_meta_data']['filename']=$filename;	
		$material = '';
		$material_array = get_terms( 'product_cat', array('orderby' => 'id', 'order'=> 'ASC', 'hide_empty' => 0) );
		if( !empty($material_array) ){
			$material = $material_array[0]->name;
		}
		$color	  = '';
		$global_addon = get_page_by_title( 'Finish', '', 'global_product_addon' );
		$raw_addons = get_post_meta( $global_addon->ID, '_product_addons', true );
		foreach( $raw_addons as $raw_addon ){
			if( $raw_addon['name'] == "Finish" ){
				$options = $raw_addon['options'];
				$color = $options[0]['label'];
			}
		}
		$cart_item_data['pricing_item_meta_data']['material'] = $material;
		$cart_item_data['pricing_item_meta_data']['finish'] = $color;
		
		/*end*/
		
		$measurement_needed = new WC_Price_Calculator_Measurement( $unit, $measurement );

		$tmp = WC_Price_Calculator_Cart::add_to_cart( $productid, $measurement_needed, array(), 1, '', '', $cart_item_data ); 
	}
}

function remove_cart_item(){
	if(isset($_GET['remove-cart']) && $_GET['remove-cart']>0){
	
		$cart = WC()->instance()->cart;
		$cart_id = $cart->generate_cart_id($_GET['remove-cart']);
		$cart_item_id = $cart->find_product_in_cart($cart_id);
		if($cart_item_id){
		   $cart->set_quantity($cart_item_id,0);
		}
	}
}
add_action( 'init', 'remove_cart_item');

add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_custom_data_save', 10, 2 );
function add_cart_item_custom_data_save( $cart_item_meta, $product_id ) {
	global $woocommerce;
	$cart_item_meta['filename'] = $_POST['filename'];
	$material = '';
	$material_array = get_terms( 'product_cat', array('orderby' => 'id', 'order'=> 'ASC', 'hide_empty' => 0) );
	if( !empty($material_array) ){
		$material = $material_array[0]->name;
	}
	$color	  = '';
	$global_addon = get_page_by_title( 'Finish', '', 'global_product_addon' );
	$raw_addons = get_post_meta( $global_addon->ID, '_product_addons', true );
	foreach( $raw_addons as $raw_addon ){
		if( $raw_addon['name'] == "Finish" ){
			$options = $raw_addon['options'];
			$color = $options[0]['label'];
		}
	}
	$cart_item_meta['material'] = $material;
	$cart_item_meta['finish'] = $color;
	return $cart_item_meta; 
}

//Get it from the session and add it to the cart variable
function get_cart_items_from_session( $item, $values, $key ) {
    if ( array_key_exists( 'filename', $values ) ){
        $item[ 'filename' ] = $values['pricing_item_meta_data']['filename'];
    }
    if ( array_key_exists( 'material', $values ) ){
        $item[ 'material' ] = $values['pricing_item_meta_data']['material'];
    }
    if ( array_key_exists( 'finish', $values ) ){
        $item[ 'finish' ] = $values['pricing_item_meta_data']['finish'];
    }
    return $item;
}
add_filter( 'woocommerce_get_cart_item_from_session', 'get_cart_items_from_session', 1, 3 );

//delete directory and it contents
function deleteDirectory($dir) { 
	if (!file_exists($dir)) { return true; }
	if (!is_dir($dir) || is_link($dir)) {
		return unlink($dir);
	}
	foreach (scandir($dir) as $item) { 
		if ($item == '.' || $item == '..') { continue; }
		if (!deleteDirectory($dir . "/" . $item, false)) { 
			chmod($dir . "/" . $item, 0777); 
			if (!deleteDirectory($dir . "/" . $item, false)) return false; 
		}; 
	}

	if( file_exists($dir) )
		return rmdir($dir);
	else
		return true;
}

/* Remove file when remove cart */
add_action( 'woocommerce_before_cart_item_quantity_zero', 'remove_stl_file' );

function remove_stl_file($cart_item_key){
	//session_start();
	
	$cart_item = WC()->cart->cart_contents[ $cart_item_key ];
	$email    = $_SESSION['stlemail'];
	$stl_dir  = ABSPATH ."/STL/". $email ."/";
	$filename = $stl_dir . $cart_item['filename'];
	
	if( file_exists( $filename ) && !is_dir( $filename ) )
		unlink( $filename );
}

/*
 * AJAX REMOVE DIRECTORY BEFORE UPLOAD STL FILES TO AVOID ADD OLD ITEMS TO CART
 */
 
add_action( 'wp_ajax_clear_directory_before_upload' , 'clear_directory_before_upload' );
add_action( 'wp_ajax_nopriv_clear_directory_before_upload' , 'clear_directory_before_upload' );

function clear_directory_before_upload(){
	if ( isset($_REQUEST) ) {
		
        $email = $_REQUEST['email'];
		$stl_dir =  ABSPATH ."/STL/". $email ."/";
		
		if ( file_exists($stl_dir) && !empty( $email ) ) { //clear all old files
		}
		$response['response'] = 'success';
			
		
		echo json_encode($response);
    }
     
   die();
}

/*
 * AJAX ADD ALL FILES TO CART
 */
 
add_action( 'wp_ajax_add_all_stl_files_to_cart' , 'add_all_stl_files_to_cart' );
add_action( 'wp_ajax_nopriv_add_all_stl_files_to_cart' , 'add_all_stl_files_to_cart' );

function add_all_stl_files_to_cart(){
	if ( isset($_REQUEST) ) {
		$email = $_REQUEST['email'];
		$unit = $_REQUEST['unit'];
		$filenames = $_REQUEST['filename'];
		$stl_dir = ABSPATH ."/STL/". $email ."/";
		echo $email.$unit.$filenames.$stl_dir;
		foreach ($filenames as $filename) {
			if( !empty($email) && strtolower(substr($filename, -3))=="stl" ){
				if( file_exists( $stl_dir . $filename ) )
				$response['type'] = 'stl';
			}elseif( !empty($email) && strtolower(substr($filename, -3))=="zip" ){
				$response['contain'] = false;
				if( file_exists( $stl_dir . $filename ) ){
					$tmp_dir = $stl_dir.'tmp';
					if( file_exists( $tmp_dir ) ){
						foreach(glob("{$tmp_dir}/*") as $file)
						{
							unlink($file);
						}
						WP_Filesystem();
						$results = unzip_file( $stl_dir.$filename, $tmp_dir ); 
						if(!$results){
							echo "failed to unzip $tmpfile...\n";
						}else{
							foreach(glob("{$tmp_dir}/*") as $tmpfile)
							{
								$tmpfile = basename($tmpfile);
								if( !empty($email) && strtolower(substr($tmpfile, -3))=="stl" ){
									$response['contain'] = true;
									if( file_exists( $tmp_dir . '/' . $tmpfile ) ){
										$old_path = $tmp_dir . '/' . $tmpfile;
										$new_path = $stl_dir . $tmpfile;
										
										if (!rename($old_path, $new_path)) {
											echo "failed to move $tmpfile...\n";
										}else{
											add_stl_to_cart( $tmpfile,$unit, $email ); //add file to cart
										}
									}
								}
							}
							unlink($stl_dir.$filename);
							foreach(glob("{$tmp_dir}/*") as $file)
							{
								unlink($file);
							}
						}
					}else{
						if (!mkdir($tmp_dir, 0777, true)) {
							die('Failed to create folders...');
						}else{
							WP_Filesystem();
							$results = unzip_file( $stl_dir.$filename, $tmp_dir ); 
							if(!$results){
								echo "failed to unzip $tmpfile...\n";
							}else{
								foreach(glob("{$tmp_dir}/*") as $tmpfile)
								{
									$tmpfile = basename($tmpfile);
									if( !empty($email) && strtolower(substr($tmpfile, -3))=="stl" ){
										$response['contain'] = true;
										if( file_exists( $tmp_dir . '/' . $tmpfile ) ){
											$old_path = $tmp_dir . '/' . $tmpfile;
											$new_path = $stl_dir . $tmpfile;
											if (!rename($old_path, $new_path)) {
												echo "failed to move $tmpfile...\n";
											}else{
												add_stl_to_cart( $tmpfile,$unit, $email ); //add file to cart
											}
										}
									}
								}
								unlink($stl_dir.$filename);
								foreach(glob("{$tmp_dir}/*") as $file)
								{
									unlink($file);
								}
							}
						}
					}
				}
				$response['type'] = 'zip';
			}
		}
		
		$response['response'] = 'success';
				
		echo json_encode($response);
    }
     
   die();
}

//rename cart item name to filename
add_filter( 'woocommerce_cart_item_name', 'rename_cart_itemname', 10, 3 );

function rename_cart_itemname( $product_title, $cart_item, $cart_item_key ){
	global $woocommerce;
	
	$separator=( substr($woocommerce->cart->get_cart_url(), -1)=="/" ? "?" : "&" );
	if( !empty( $cart_item['filename'] ) )
		$product_title= sprintf( '<a href="%s">%s</a>', $woocommerce->cart->get_cart_url().$separator."filename=$cart_item[filename]", $cart_item['filename'] );
	else if( strpos($product_title,'Expert File Check') !== false )
		$product_title = "Expert File Check";
	else if( $cart_item['product_id'] == PRIORITY_SHIPPING_PRODUCT_ID )
		$product_title = '<strong style="color: #0ab1f0;">Priority Service</strong> (4-7 days)';
		
	return $product_title;
}

//rename order item name to filename
add_filter( 'woocommerce_order_item_name', 'rename_order_itemname', 10, 2 );

function rename_order_itemname( $product_title, $item ){
	global $woocommerce;
	
	if( !empty( $item['filename'] ) )
		$product_title= $item['filename'];
	else if( strpos($product_title,'Expert Check') !== false )
		$product_title = "Expert Check";
		
	return $product_title;
}

//redirect to address page when user click "next step" button
add_filter( 'init', 'redirect_to_address_page' );

function redirect_to_address_page(){
	if( isset( $_REQUEST['next_process'] ) ){
		
		$_POST['update_cart']=1;
		custom_update_cart_process();//update cart before go to next step
		
		$redirect_url= esc_url(get_permalink(ADDRESS_PAGE)); 
		wp_safe_redirect( $redirect_url );
		exit();
	}
}

function custom_update_cart_process(){
	// Add Discount
	if ( ! empty( $_POST['apply_coupon'] ) && ! empty( $_POST['coupon_code'] ) ) {
		WC()->cart->add_discount( sanitize_text_field( $_POST['coupon_code'] ) );
	}
	
	// Remove Coupon Codes
	elseif ( isset( $_GET['remove_coupon'] ) ) {

		WC()->cart->remove_coupon( wc_clean( $_GET['remove_coupon'] ) );

	}

	// Remove from cart
	elseif ( ! empty( $_GET['remove_item'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'woocommerce-cart' ) ) {

		WC()->cart->set_quantity( $_GET['remove_item'], 0 );

		wc_add_notice( __( 'Cart updated.', 'woocommerce' ) );
	}

	// Update Cart - checks apply_coupon too because they are in the same form
	if ( ( ( ! empty( $_POST['apply_coupon'] ) || ! empty( $_POST['update_cart'] ) || ! empty( $_POST['proceed'] ) ) && isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-cart' ) )
		OR ( ( ! empty( $_POST['update_cart'] ) ) && isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'customwoocommerce-set_address' ) )
		OR ( ! empty( $_POST['update_cart'] ) && isset( $_POST['fix1dollarbug'] ) && $_POST['fix1dollarbug']==1 ) ) {
		
		$cart_updated = false;
		$cart_totals  = isset( $_POST['cart'] ) ? $_POST['cart'] : '';

		if ( sizeof( WC()->cart->get_cart() ) > 0 && is_array( $cart_totals ) ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {

				$_product = $values['data'];
				
				// Skip product if no updated quantity was posted
				if ( ! isset( $cart_totals[ $cart_item_key ] ) || ! isset( $cart_totals[ $cart_item_key ]['qty'] ) ) {
					continue;
				}

				// Sanitize
				$quantity = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( "/[^0-9\.]/", '', $cart_totals[ $cart_item_key ]['qty'] ) ), $cart_item_key );

				if ( '' === $quantity || $quantity == $values['quantity'] )
					continue;

				// Update cart validation
				$passed_validation 	= apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $values, $quantity );

				// is_sold_individually
				if ( $_product->is_sold_individually() && $quantity > 1 ) {
					wc_add_notice( sprintf( __( 'You can only have 1 %s in your cart.', 'woocommerce' ), $_product->get_title() ), 'error' );
					$passed_validation = false;
				}

				if ( $passed_validation ) {
					WC()->cart->set_quantity( $cart_item_key, $quantity, false );
					$cart_updated = true;
				}

			}
		}

		// Trigger action - let 3rd parties update the cart if they need to and update the $cart_updated variable
		$cart_updated = apply_filters( 'woocommerce_update_cart_action_cart_updated', $cart_updated );

		if ( $cart_updated ) {
			// Recalc our totals
			WC()->cart->calculate_totals();
		}

		if ( ! empty( $_POST['proceed'] ) ) {
		} elseif ( $cart_updated ) {
			wc_add_notice( __( 'Cart updated.', 'woocommerce' ) );
		}
	}
}

//Save address when checkout
add_action( 'wp_loaded', 'save_address' );

function save_address(){
	global $woocommerce;
	
	$same_billing_address = ( isset($_POST['same_billing_address']) ? true : false ); //process shipping to different address
	
	if( isset( $_POST ) && isset( $_POST['set_address'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'customwoocommerce-set_address' ) ):
		// Get posted checkout_fields and do validation
		foreach ( WC()->checkout()->checkout_fields as $fieldset_key => $fieldset ) {

			// Skip shipping if not needed
			if ( $fieldset_key == 'billing' && ( $same_billing_address == true || ! WC()->cart->needs_shipping() ) ) {
				$skipped_shipping = true;
				continue;
			}

			// Ship account if not needed
			if ( $fieldset_key == 'account' && ( is_user_logged_in() || ( WC()->checkout()->must_create_account == false && empty( WC()->checkout()->posted['createaccount'] ) ) ) ) {
				continue;
			}

			foreach ( $fieldset as $key => $field ) {

				if ( ! isset( $field['type'] ) ) {
					$field['type'] = 'text';
				}

				// Get Value
				switch ( $field['type'] ) {
					case "checkbox" :
						WC()->checkout()->posted[ $key ] = isset( $_POST[ $key ] ) ? 1 : 0;
					break;
					case "multiselect" :
						WC()->checkout()->posted[ $key ] = isset( $_POST[ $key ] ) ? implode( ', ', array_map( 'wc_clean', $_POST[ $key ] ) ) : '';
					break;
					case "textarea" :
						WC()->checkout()->posted[ $key ] = isset( $_POST[ $key ] ) ? wp_strip_all_tags( wp_check_invalid_utf8( stripslashes( $_POST[ $key ] ) ) ) : '';
					break;
					default :
						WC()->checkout()->posted[ $key ] = isset( $_POST[ $key ] ) ? ( is_array( $_POST[ $key ] ) ? array_map( 'wc_clean', $_POST[ $key ] ) : wc_clean( $_POST[ $key ] ) ) : '';
					break;
				}

				// Hooks to allow modification of value
				WC()->checkout()->posted[ $key ] = apply_filters( 'woocommerce_process_checkout_' . sanitize_title( $field['type'] ) . '_field', WC()->checkout()->posted[ $key ] );
				WC()->checkout()->posted[ $key ] = apply_filters( 'woocommerce_process_checkout_field_' . $key, WC()->checkout()->posted[ $key ] );

				// Validation: Required fields
				if ( isset( $field['required'] ) && $field['required'] && empty( WC()->checkout()->posted[ $key ] ) ) {
					wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is a required field.', 'woocommerce' ), 'error' );
				}

				if ( ! empty( WC()->checkout()->posted[ $key ] ) ) {

					// Validation rules
					if ( ! empty( $field['validate'] ) && is_array( $field['validate'] ) ) {
						foreach ( $field['validate'] as $rule ) {
							switch ( $rule ) {
								case 'postcode' :
									WC()->checkout()->posted[ $key ] = strtoupper( str_replace( ' ', '', WC()->checkout()->posted[ $key ] ) );

									if ( ! WC_Validation::is_postcode( WC()->checkout()->posted[ $key ], $_POST[ $fieldset_key . '_country' ] ) ) :
										wc_add_notice( __( 'Please enter a valid postcode/ZIP.', 'woocommerce' ), 'error' );
									else :
										WC()->checkout()->posted[ $key ] = wc_format_postcode( WC()->checkout()->posted[ $key ], $_POST[ $fieldset_key . '_country' ] );
									endif;
								break;
								case 'phone' :
									WC()->checkout()->posted[ $key ] = wc_format_phone_number( WC()->checkout()->posted[ $key ] );

									if ( ! WC_Validation::is_phone( WC()->checkout()->posted[ $key ] ) )
										wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is not a valid phone number.', 'woocommerce' ), 'error' );
								break;
								case 'email' :
									WC()->checkout()->posted[ $key ] = strtolower( WC()->checkout()->posted[ $key ] );

									if ( ! is_email( WC()->checkout()->posted[ $key ] ) )
										wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is not a valid email address.', 'woocommerce' ), 'error' );
								break;
								case 'state' :
									// Get valid states
									$valid_states = WC()->countries->get_states( isset( $_POST[ $fieldset_key . '_country' ] ) ? $_POST[ $fieldset_key . '_country' ] : ( 'billing' === $fieldset_key ? WC()->customer->get_country() : WC()->customer->get_shipping_country() ) );

									if ( ! empty( $valid_states ) && is_array( $valid_states ) ) {
										$valid_state_values = array_flip( array_map( 'strtolower', $valid_states ) );

										// Convert value to key if set
										if ( isset( $valid_state_values[ strtolower( WC()->checkout()->posted[ $key ] ) ] ) ) {
											 WC()->checkout()->posted[ $key ] = $valid_state_values[ strtolower( WC()->checkout()->posted[ $key ] ) ];
										}
									}

									// Only validate if the country has specific state options
									if ( ! empty( $valid_states ) && is_array( $valid_states ) && sizeof( $valid_states ) > 0 ) {
										if ( ! in_array( WC()->checkout()->posted[ $key ], array_keys( $valid_states ) ) ) {
											wc_add_notice( '<strong>' . $field['label'] . '</strong> ' . __( 'is not valid. Please enter one of the following:', 'woocommerce' ) . ' ' . implode( ', ', $valid_states ), 'error' );
										}
									}
								break;
							}
						}
					}
				}
			}
		}
		
		$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() );
		if( wc_notice_count( 'error' ) == 0 ){ //if no errors found redirect to checkout/payment page
			//session_start();
			$temp = array();

			if( $same_billing_address == true )
			{
				foreach( WC()->checkout()->posted as $key=>$val ){
					$key=substr($key, 8);
					$new_key="billing".$key;
					$temp[$new_key]=$val;
				}
			}

			$_SESSION['same_billing_address'] = ( isset($_POST['same_billing_address']) ? '' : 'hidden' );
			$_SESSION['priority_shipping'] = $_POST['priority_shipping'];
			if(isset($_POST['shipping_password'])){
			}

			if( count($temp) )
				$_SESSION['address_info'] = array_merge( WC()->checkout()->posted, $temp ); //copy address to session
			else
				$_SESSION['address_info'] = WC()->checkout()->posted;
			/* update cart to avoid wrong price */
			fix_1dollar_bug();
			
			/* redirect */
			if( substr( $get_checkout_url, -1 ) == "/" ){
				wp_safe_redirect( $get_checkout_url."?set_shipping=1" ); 
				die();
			}
			else
			{
				wp_safe_redirect( $get_checkout_url."&set_shipping=1" ); 
				die();
			}
		}
			
	endif;
}

add_action( 'woocommerce_before_checkout_form' , 'set_shipping_method', 10 );

function set_shipping_method(){
	//session_start();
	
	/* set shipping method */			
	if( $_SESSION['priority_shipping'] && isset($_GET['set_shipping']) ){
		$packages = WC()->shipping->get_packages();
		$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );

		foreach ( $packages as $i => $package ) {
			//$chosen_shipping_methods[ $i ] = 'local_delivery';
			$chosen_shipping_methods[ $i ] = 'flat_rate';
		}
		//print_r( $chosen_shipping_methods );
		WC()->session->set( 'chosen_shipping_methods', $chosen_shipping_methods );
		
		$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() );
		
		WC()->cart->add_to_cart( PRIORITY_SHIPPING_PRODUCT_ID ); //add extra shipping cost
		WC()->cart->calculate_totals();
		
		wp_safe_redirect( $get_checkout_url ); //redirect page to refresh total price
	}else if( isset($_GET['set_shipping']) ){
		$packages = WC()->shipping->get_packages();
		$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );

		foreach ( $packages as $i => $package ) {
			//$chosen_shipping_methods[ $i ] = 'free_shipping';
			$chosen_shipping_methods[ $i ] = 'flat_rate';
		}
		
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) { //get expert check cart item key
			if($cart_item['product_id'] == EXPERT_CHECK_ID ){
					$selected_key=$cart_item_key;
				break;
			}
		} 

		if($selected_key){
		   WC()->cart->set_quantity($selected_key,1); //remove extra shipping cost
		}
	
		
		WC()->session->set( 'chosen_shipping_methods', $chosen_shipping_methods );
		
		//exit();
		
		$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() );
		wp_safe_redirect( $get_checkout_url ); //redirect page to refresh total price
	}
	
}

/*Custom Shipping Fields*/
add_filter( 'woocommerce_shipping_fields', 'custom_shipping_fields', 999999, 2 );

function custom_shipping_fields($address_fields, $country ){
	$address_fields['shipping_first_name']['class'] = array( 'form-row-first', 'address-field' );
	$address_fields['shipping_last_name']['class'] = array( 'form-row-last', 'address-field' );
	$address_fields['shipping_postcode']['label'] = 'Postal Code';
	$address_fields['shipping_postcode']['class'] = array( 'form-row-last', 'address-field' );
	$address_fields['shipping_city']['label'] = 'City';
	$address_fields['shipping_city']['class'] = array( 'form-row-first', 'address-field' );
	$address_fields['shipping_country']['class'] = array( 'form-row-first', 'address-field' );
	$address_fields['shipping_state']['label'] = 'State';
	$address_fields['shipping_state']['class'] = array( 'form-row-last', 'address-field' );

	moveElement($address_fields, 0, 7);
	moveElement($address_fields, 6, 8);
	$address_fields['shipping_country'] = $address_fields[0];
	unset($address_fields[0]);
	$address_fields['shipping_state'] = $address_fields[1];
	unset($address_fields[1]);
	$address_fields['billing_phone'] = array(
				'label' 		=> __( 'Phone', 'woocommerce' ),
				'required' 		=> true,
				'class' 		=> array( 'form-row-wide' ),
				'clear'			=> true,
				'placeholder'   => 'e.g. 03 9099 0225',
				'validate'		=> array( 'phone' ),
			);
	$address_fields['billing_email'] = array(
												'label' => 'Email',
												'placeholder' => '',
												'required' => 1,
												'class' => Array( 'form-row-wide', 'address-field'),
												'validate' => Array('email')
											);

	return $address_fields;
}

function moveElement(&$array, $a, $b) {
    $out = array_splice($array, $a, 1);
    array_splice($array, $b, 0, $out);
}

/*Custom Billing Fields*/
add_filter( 'woocommerce_billing_fields', 'custom_billing_fields', 999999, 2 );

function custom_billing_fields($address_fields, $country ){
	
	$address_fields['billing_first_name']['class'] = array( 'form-row-first', 'address-field' );
	$address_fields['billing_last_name']['class'] = array( 'form-row-last', 'address-field' );
	$address_fields['billing_postcode']['label'] = 'Postal Code';
	$address_fields['billing_postcode']['class'] = array( 'form-row-last', 'address-field' );
	$address_fields['billing_city']['label'] = 'City';
	$address_fields['billing_city']['class'] = array( 'form-row-first', 'address-field' );
	$address_fields['billing_country']['class'] = array( 'form-row-first', 'address-field' );
	$address_fields['billing_state']['label'] = 'State';
	$address_fields['billing_state']['class'] = array( 'form-row-last', 'address-field' );
	$address_fields['billing_phone']['class'] = array( 'form-row-last', 'address-field', 'phone-field' );
	moveElement($address_fields, 0, 7);
	moveElement($address_fields, 6, 8);
	$address_fields['billing_country'] = $address_fields[0];
	unset($address_fields[0]);
	$address_fields['billing_state'] = $address_fields[1];
	unset($address_fields[1]);
	unset($address_fields['billing_email']);
	return $address_fields;
}

//remove shipping order notes
add_filter( 'woocommerce_checkout_fields' , 'alter_woocommerce_checkout_fields' );
function alter_woocommerce_checkout_fields( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}


//custom recipient email
add_filter( 'woocommerce_email_recipient_customer_processing_order', 'custom_recipient_email', 10, 2 );
add_filter( 'woocommerce_email_recipient_customer_completed_order', 'custom_recipient_email', 10, 2 );
add_filter( 'woocommerce_email_recipient_customer_invoice', 'custom_recipient_email', 10, 2 );
add_filter( 'woocommerce_email_recipient_customer_note', 'custom_recipient_email', 10, 2 );
add_filter( 'woocommerce_email_recipient_customer_invoice_paid', 'custom_recipient_email', 10, 2 );
	
function custom_recipient_email( $recipient, $obj ){
	//wp_mail( 'deczen@odihost.com', 'object', serialize( $obj ) );	
	$cust_email=get_post_meta( $obj->post->ID, 'stlemail', true );
	
	if( $cust_email )
		$recipient=$cust_email;
		
	return $recipient;
}

/* set email to send */
add_action( 'woocommerce_checkout_update_order_meta', 'set_order_customer_email', 10, 2 );

function set_order_customer_email( $order_id, $posted ){
	//session_start();
	
	$email = $_SESSION['stlemail'];
	
	/*update meta*/
	update_post_meta( $order_id, 'stlemail', $email );	
}

add_action( 'woocommerce_checkout_order_processed', 'clear_session_after_checkout' ,10,2);

function clear_session_after_checkout( $order_id, $posted  ){
	//session_start();
		
	$email = $_SESSION['stlemail'];
	$order = new WC_Order( $order_id );
	$items = $order->get_items();
	
	$stl_dir =  ABSPATH ."/STL/". $email ."/";
	$order_dir = $stl_dir. date("d-m-Y")."/";
	if(!is_dir($order_dir)){ mkdir($order_dir,0777); @chmod($order_dir,0777); }
	$order_dir .= $order->id."/";
	if(!is_dir($order_dir)){ mkdir($order_dir,0777); @chmod($order_dir,0777); }	
	
	foreach ( $items as $item ) {
		$product_name = $item['name'];
		$product_id = $item['product_id'];
		$product_variation_id = $item['variation_id'];
			
		if( file_exists($stl_dir.$item['filename'])){
			copy( $stl_dir.$item['filename'], $order_dir.$item['filename']); //copy file
			
			if( file_exists( $order_dir.$item['filename'] ) )
				unlink( $stl_dir.$item['filename'] );
		}
		foreach(glob("{$stl_dir}*") as $tmpfile){
			$tmpfile = basename($tmpfile);
			if( strtolower(substr($tmpfile, -3))=="png" ){
				copy( $stl_dir.$item['filename'].'.png', $order_dir.$item['filename'].'.png');
				unlink( $stl_dir.$item['filename'].'.png' );
			}
		}
			
	}
	
}

/* save STL filename to order item meta */
add_action( 'woocommerce_add_order_item_meta', 'save_filename_to_order_item_meta', 10, 3 );

function save_filename_to_order_item_meta($item_id, $values, $cart_item_key){
	//session_start();
	
	if( $values['filename'] )
		wc_add_order_item_meta( $item_id, 'filename', $values['filename'] ); //add filename to order item meta
		wc_add_order_item_meta( $item_id, 'material', $values['material'] ); //add filename to order item meta
		wc_add_order_item_meta( $item_id, 'finish', $values['finish'] ); //add filename to order item meta
	
	return $item_id;
}

/* adjust checkout page */
add_action( 'plugins_loaded' , 'test' );

function test(){
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review' );
add_action( 'woocommerce_checkout_order_review', 'cart_view_in_checkout_page' );
}

function cart_view_in_checkout_page(){

//session_start();

?>
<?php if ( ! $is_ajax ) : ?><div id="order_review"><?php endif; ?>
	<table class="shop_table cart" cellspacing="0">
		<thead>
			<tr>
				<th class="product-thumbnal"><?php _e( '', 'woocommerce' ); ?></th>
				<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-dimensions"><?php _e( 'Dimensions', 'woocommerce' ); ?></th>
				<th class="product-material"><?php _e( 'Material', 'woocommerce' ); ?></th>
				<th class="product-finish"><?php _e( 'Finish', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php _e( 'QTY', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php _e( 'Price', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$email=$_SESSION['stlemail'];				
			$stl_dir = $_SERVER["DOCUMENT_ROOT"] . "/STL/". $email ."/";
			$stl_url = get_site_url() . "/STL/". $email ."/";
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				
			
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						
						<td id="<?php echo "img_" . $cart_item_key ?>" class="product-thumbnail">
							<?php							
								if( file_exists( $stl_dir . get_stl_image_name( $cart_item['filename'] ) )){
									$thumbnail = "<img src='" . $stl_url. get_stl_image_name( $cart_item['filename'] ) ."'>";
								}else{
									$thumbnail = "<img src='". get_stylesheet_directory_uri() . "/images/blue-eye.png" ."' />";
								}
								echo $thumbnail;
							?>
							
						</td>
						
						<td class="product-name">
							<?php
							
								echo strip_tags( apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ), "<strong>" );
								
								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
									echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
							?>
						</td>
						
						<td class="product-dimensions">
							<?php
							if( WC()->cart->cart_contents[$cart_item_key]['product_id'] == MM_PRODUCT_ID )
									$size = "mm";
							else if( WC()->cart->cart_contents[$cart_item_key]['product_id'] == INCH_PRODUCT_ID)
								$size = "inch";
							else
								$size = "";	
							
							// Meta data
								echo WC()->cart->get_item_data( $cart_item ). " $size";
							?>
						</td>
						
						<td class="product-material">
							<?php echo $cart_item['material']; ?>
						</td>
						
						<td class="product-finish">
							<?php echo $cart_item['finish']; ?>
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
								echo $cart_item['quantity'];
							?>
						</td>

						<td class="product-subtotal">
							<?php
									
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}
			
			//WC()->cart->calculate_totals();
			
			if( $_SESSION['priority_shipping'] && false ){  //not using since freight enabled
				$packages = WC()->shipping->get_packages();
				$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
				$method=null;
				foreach ( $packages as $i => $package ){
					$method=$package['rates']['local_delivery'];
				}
				
				WC()->cart->calculate_shipping(); 
			?>
				<tr>
					<td class="product-name"><strong>Priority Service</strong> (4-7 days)</td>
					<td class="product-dimensions"></td>
					<td class="product-quantity"></td>
					<td class="product-subtotal"><?php echo WC()->cart->get_cart_shipping_total() ?></td>					
				</tr>
			
			<?php }			
			?>
		</tbody>
	</table>
	
	<div id="chekout_total" style="text-align:right; float:right;">
		<style>
			.info{
				font-weight: bold;
				text-transform: uppercase;
				border-bottom: 1px solid black;
				margin-bottom: 20px;
				font-size: 16px;
				display:block;
				width:280px;
			}
		</style>

		<?php foreach ( WC()->cart->get_coupons( 'cart' ) as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( $code ); ?> info">
				<span style="float: left;width:60%;"><?php wc_cart_totals_coupon_label( $coupon ); ?>:</span>
				<span style="font-weight:bold;color:#0ab1f0;"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>
		
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<div class="shipping info">
				<span style="float: left;width:60%;"><?php echo "Freight" ?>:</span>
				<span style="font-weight:bold;color:#0ab1f0;"><?php echo WC()->cart->get_cart_shipping_total() ?></span>
			</div> 
		<?php endif; ?>
		
		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="fee info">
				<span style="float: left;width:60%;"><?php echo esc_html( $fee->name ); ?>:</span>
				<span style="font-weight:bold;color:#0ab1f0;"><?php wc_cart_totals_fee_html( $fee ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
			<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?> info">
						<span style="float: left;width:60%;"><?php echo esc_html( $tax->label ); ?>:</span>
						<span style="font-weight:bold;color:#0ab1f0;"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="tax-total info">
					<span style="float: left;width:60%;">GST:</span>
					<span style="font-weight:bold;color:#0ab1f0;"><?php wc_cart_totals_taxes_total_html(); ?></span>
					<!--span style="float: left;width:60%;"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?>:</span>
					<span style="font-weight:bold;color:#0ab1f0;"><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></span-->
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php foreach ( WC()->cart->get_coupons( 'order' ) as $code => $coupon ) : ?>
			<div class="order-discount coupon-<?php echo esc_attr( $code ); ?> info">
				<span style="float: left;width:60%;"><?php wc_cart_totals_coupon_label( $coupon ); ?>:</span>
				<span style="font-weight:bold;color:#0ab1f0;"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="order-total info">
			<span style="float: left;width:60%;"><?php _e( 'Order Total', 'woocommerce' ); ?>:</span>
			<span style="font-weight:bold;color:#0ab1f0;"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>
		
		<div class="shipping">
			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
				<input type="hidden" name="shipping_method" value="local_delivery">
			<?php endif; ?>
		</div>
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
	</div>
	<div style="clear:both"></div>
	
<?php if ( ! $is_ajax ) : ?></div><?php endif;
}

/* send email copy */

add_action( 'init', 'send_email_copy' );

function send_email_copy(){
	
	if( !empty( $_POST ) && isset( $_POST['send_email'] ) ){
		//session_start();
		
		$to=$_SESSION['stlemail'];
		$header= 'From: '. get_bloginfo('name') .' <'. get_bloginfo('name') .'>';
		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		
		$type=(isset($_POST['quote_type']) && $_POST['quote_type']=="checkout" ? "checkout" : "cart" );
		
		$html_message=get_html_message_content($type);
		
		wp_mail( $to, 'Quote from ' . get_bloginfo('name'), $html_message, $header );

		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		
		wc_add_notice( __( 'Email has been sent successfully.', 'woocommerce' ), 'notice' );
	}	
}
function set_html_content_type() { return 'text/html'; }

function get_html_message_content( $type="cart" ){
//session_start();
ob_start();
?>
	<table class="shop_table cart" cellspacing="0" style="font-family: sans-serif; font-size: 10px; width:100%;margin: 0px -1px 24px 0px;text-align: left; border-collapse:collapse;">
		<thead>
			<tr>
				<th style="text-align:left; width:20%; text-transform: uppercase; color: #3b454d;border:1px solid #878787; padding:10px;" class="product-thumbnail">&nbsp;</th>
				<th style="text-align:left; width:20%; text-transform: uppercase; color: #3b454d;border:1px solid #878787; padding:10px;" class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th style="text-align:center; width:20%; text-transform: uppercase; color: #3b454d;border:1px solid #878787; padding:10px;" class="product-dimensions"><?php _e( 'Dimensions', 'woocommerce' ); ?></th>
				<th style="text-align:center; width:20%; text-transform: uppercase; color: #3b454d;border:1px solid #878787; padding:10px;" class="product-quantity"><?php _e( 'QTY', 'woocommerce' ); ?></th>
				<th colspan="2" style="text-align:right; width:20%; text-transform: uppercase; color: #3b454d;border:1px solid #878787; padding:10px;" class="product-subtotal"><?php _e( 'Price', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$email=$_SESSION['stlemail'];				
			$stl_dir = ABSPATH . "/STL/". $email ."/";
			$stl_url = get_site_url() . "/STL/". $email ."/";
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr>

						<td style="text-align:left; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-thumbnail">
						<?php
	
							if( file_exists( $stl_dir . get_stl_image_name( $cart_item['filename'] ) ) )
								printf( '%s', "<img style='width:40px; height:auto;' src='". $stl_url.get_stl_image_name( $cart_item['filename'] ). "'>" );
						?>
						</td>
						
						<td style="text-align:left; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-name">
							<?php
								if ( ! $_product->is_visible() )
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								else{
									$title_with_url = apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );
									$title = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $title_with_url );
									echo $title;
								}	
								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
									echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
							?>
						</td>
						
						<td style="text-align:center; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-dimensions">
							<?php
								if( WC()->cart->cart_contents[$cart_item_key]['product_id'] == MM_PRODUCT_ID )
									$size = "mm";
								else if( WC()->cart->cart_contents[$cart_item_key]['product_id'] == INCH_PRODUCT_ID)
									$size = "inch";
								else
									$size = "";
									
								// Meta data
								$dimension=explode( "</dt>", WC()->cart->get_item_data( $cart_item ) );
								echo $dimension[1]. " $size";
							?>
						</td>

						<td style="text-align:center; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-quantity">
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
								echo $cart_item['quantity'];
							?>
						</td>

						<td colspan="2" style="text-align:right; font-weight:bold; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}						
			?>
			<?php if( $type=="checkout" ): ?>
			
			<?php /* DISPLAY SHIPPING */
				if( $_SESSION['priority_shipping'] && false ): //disabled since freight enabled 
					$packages = WC()->shipping->get_packages();
					//echo "<pre>"; var_dump( $packages ); echo "</pre>";
					$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
					$method=null;
					foreach ( $packages as $i => $package ){
						$method=$package['rates']['local_delivery'];
					}
					
					WC()->cart->calculate_shipping();
					?>
					<tr>
						<td style="text-align:left; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-thumbnail">&nbsp;</td>
						<td style="text-align:left; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-name"><strong>Priority Service</strong> (4-7 days)</td>
						<td style="text-align:center; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-dimensions"></td>
						<td style="text-align:center; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-quantity"></td>
						<td colspan="2" style="text-align:right; font-weight:bold; color:#0ab1f0; border-bottom:1px solid #878787; padding:10px;" class="product-subtotal"><?php echo WC()->cart->get_cart_shipping_total() ?></td>					
					</tr>
				<?php endif; ?>
				
			<?php endif; ?>
			
			<?php if( $type=="checkout" ): ?>
				
				<?php /* DISPLAY ORDER TOTAL */ ?>
				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
				<tr>
					<td></td><td></td><td></td><td></td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;font-weight:bold;">FREIGHT:</td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;color:#0ab1f0;font-weight:bold;"><?php echo WC()->cart->get_cart_shipping_total(); ?></td>
					
				</tr>
				<?php endif; ?>
				
				<?php /* DISPLAY TAX */ ?>
				<?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
					<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
						<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
							<tr>
								<td></td><td></td><td></td><td></td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;font-weight:bold;"><?php echo esc_html( $tax->label ); ?>:</td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;color:#0ab1f0;font-weight:bold;"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
							</tr>							
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td></td><td></td><td></td><td></td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;font-weight:bold;"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?>:</td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;color:#0ab1f0;font-weight:bold;"><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
						</tr>						
					<?php endif; ?>
					
			<?php endif; ?>
			
			<?php /* DISPLAY ORDER TOTAL */ ?>
			<tr>
				<td></td><td></td><td></td><td></td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;font-weight:bold;">ORDER TOTAL:</td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;color:#0ab1f0;font-weight:bold;"><?php wc_cart_totals_order_total_html(); ?></td>
				
			</tr>
			<?php else: ?>
			<tr>
				<td></td><td></td><td></td><td></td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;font-weight:bold;">SUBTOTAL:</td><td style="font-size: 11px; border-bottom: 1px solid black; text-align:right;padding-top:15px;color:#0ab1f0;font-weight:bold;"><?php wc_cart_totals_subtotal_html() ?></td>
				
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
<?php
$html_message = ob_get_clean();

return $html_message;
}

/* Product QTY validation - set maximum qty of expert check is 1 */
add_filter( 'woocommerce_add_to_cart_validation', 'set_maximum_number_of_expert_check_qty', 10, 3 );
add_filter( 'woocommerce_update_cart_validation', 'set_maximum_number_of_update_cart_qty',10, 4 );
add_action( 'woocommerce_add_to_cart', 'set_maximum_number_of_extra_cost_qty', 10, 6 );

function set_maximum_number_of_extra_cost_qty( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ){	
	if( $product_id == PRIORITY_SHIPPING_PRODUCT_ID ){
		WC()->cart->set_quantity( $cart_item_key, 1, false ); //set qty is always 1
	}
}

function set_maximum_number_of_expert_check_qty(  $passed, $product_id, $quantity ){
	
	foreach( WC()->cart->cart_contents as $key=>$val ){
		if( $val['product_id']== EXPERT_CHECK_ID && $product_id == EXPERT_CHECK_ID && $val['quantity'] > 0 ) //if in cart content expert check product quantity is more than 1 then return false
			$passed=false;
		if( $val['product_id']== PRIORITY_SHIPPING_PRODUCT_ID && $product_id == PRIORITY_SHIPPING_PRODUCT_ID && $val['quantity'] > 0 ) //if in cart content extra cost product product quantity is more than 1 then return false
			$passed=false;
	}
	
	if ($product_id == EXPERT_CHECK_ID && $quantity > 1 ) //expert check product maximum qty is 1
	{
		$passed=false;
	}
	
	if ($product_id == PRIORITY_SHIPPING_PRODUCT_ID && $quantity > 1 ) //extra cost product maximum qty is 1
	{
		$passed=false;
	}
	
	return $passed;
}

function set_maximum_number_of_update_cart_qty( $passed, $cart_item_key, $values, $quantity ){
	
	if( $values['product_id']==EXPERT_CHECK_ID && $quantity > 1 )//expert check product maximum qty is 1
		$passed=false;
	
	if( $values['product_id']==PRIORITY_SHIPPING_PRODUCT_ID && $quantity > 1 )//extra cost product maximum qty is 1
		$passed=false;
	
	return $passed;
}


/* shipping cost adjustment - add $20 to total shipping */

function custom_shipping_package2( $package ){
	
	
	return $package;
}

/* Adjust cart total */

function add_shipping_fee_to_total( $total ){
	//session_start();
	
	if( $_SESSION['priority_shipping'] ){
		$total=$total - WC()->shipping->shipping_total;
		$total+=get_extra_cost();
	}
	
	return $total;
}

/* added $20 shipping fee to checkout cart total */

//add_action( 'woocommerce_resume_order' , 'checkout_total_adjust' );
//add_action( 'woocommerce_new_order', 'checkout_total_adjust' );

function checkout_total_adjust( $order_id ){
	//session_start();
	if( $_SESSION['priority_shipping'] )
		WC()->cart->shipping_total = get_extra_cost();
		//WC()->cart->shipping_total += 20;
}


/* Fix 1 dollar price bug */
//add_action( 'init', 'fix_1dollar_bug' );

function fix_1dollar_bug(){

	if( !is_object( WC()->cart ) ) //avoid error wp-admin
		return;
		
	$cart=WC()->cart->get_cart();
	
	$first_item=reset($cart);
	
	if( true || $first_item['quantity'] == 1 && in_array( $first_item['product_id'] , array( MM_PRODUCT_ID,INCH_PRODUCT_ID) ) ){
		//echo "<pre>"; print_r( WC()->cart->cart_contents ); echo "<pre>";
		if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				
				if( ! in_array( $values['product_id'], array( MM_PRODUCT_ID,INCH_PRODUCT_ID) ) ) //just for specific products
					continue;
				
				$passed_validation = false;
				$_product = $values['data'];
				// Sanitize
				$quantity = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( "/[^0-9\.]/", '', $values['pricing_item_meta_data']['_quantity'] ) ), $cart_item_key );

				// Update cart validation
				$passed_validation 	= apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $values, $quantity );

				// is_sold_individually
				if ( $_product->is_sold_individually() && $quantity > 1 ) {
					$quantity=1;
				}

				if ( $passed_validation ) {
					WC()->cart->set_quantity( $cart_item_key, $quantity, false ); //reset quantity to fix wrong price
				}

			}
		}
	}	
}

/* count and get priority service cost */
function get_extra_cost(){
	
	$extra_cost = 0;
	
	foreach( WC()->cart->get_cart() as $cart_item_key=>$cart_item ){
		if( in_array( $cart_item['product_id'] , array( MM_PRODUCT_ID,INCH_PRODUCT_ID ) ) )
			$extra_cost+=(float)( ($cart_item['pricing_item_meta_data']['_price']) * $cart_item['quantity']  );
	}
	
	//$extra_cost = get_post_meta( PRIORITY_SHIPPING_PRODUCT_ID, '_regular_price', true);
	return $extra_cost;
}

/* Convert STL to Image file */

add_action( 'woocommerce_before_cart_table' , 'convert_stl2image' );

function convert_stl2image(){
	//session_start();
?>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/js/jsc3d_mod.js"></script>
	<script type="text/javascript" >
	// END POST handler code
	<?php
	$email=$_SESSION['stlemail'];				
	$stl_dir = ABSPATH . "/STL/". $email ."/";
	$stl_url = get_site_url() . "/STL/". $email ."/";
	foreach( WC()->cart->get_cart() as $cart_item_key=>$cart_item ){
		
		if( !file_exists( $stl_dir . $cart_item['filename'].".png" ) ) //if stl image file doesn't exists, then create one
			echo "convertSTL2Image( '". $stl_url.$cart_item['filename'] ."', '" . $cart_item['filename'] ."', '" . $cart_item_key ."' );\r\n";
	}
	?>
	function convertSTL2Image( STLFileUrl, filename, cart_key ){
		//Initialise the canvas, viewer, etc
		var canvas = document.createElement('canvas');
		canvas.width = 400;
		canvas.height = 400;
		var viewer = new JSC3D.Viewer(canvas);
		viewer.setParameter('InitRotationX', 20);
		viewer.setParameter('InitRotationY', 20);
		viewer.setParameter('InitRotationZ', 0);
		viewer.setParameter('ModelColor', '#1587cf');
		viewer.setParameter('BackgroundColor1', '#FFFFFF');
		viewer.setParameter('BackgroundColor2', '#FFFFFF');
		viewer.setParameter('RenderMode', 'flat');
		viewer.init();
		viewer.replaceSceneFromUrl(STLFileUrl);
		
		var ctx = canvas.getContext('2d');
		ctx.font = '12px Courier New';
		ctx.fillStyle = '#FF0000';
		//

		var imgdata = null;

		viewer.setRenderMode('flat');
		viewer.update();		
		
		viewer.afterupdate = function() {
			var scene = viewer.getScene();
			if(scene != null && scene.getChildren().length > 0) {
				imgdata = canvas.toDataURL();
				
				jQuery.ajax({
					type:"POST", url: brazil_wp.ajaxurl, dataType: 'JSON',
					data: {
						'action'   : 'convert_stl2image',
						'filename' : filename,
						'img_data' : imgdata
					},
					success: function(data) {
						jQuery("#img_" +cart_key+ " img" ).attr("src",data.url); //update image
					},
					error: function(errorThrown){ console.log(errorThrown); }
				});
			}
		};		
	}
	</script>
<?php
}

/* AJAX convert STL to IMAGE */
add_action( 'wp_ajax_convert_stl2image' , 'convert_stl2image_process' );
add_action( 'wp_ajax_nopriv_convert_stl2image' , 'convert_stl2image_process' );

function convert_stl2image_process(){
	if ( isset($_REQUEST) ) {
		//session_start();
		
		$filename=$_REQUEST['filename'];		
		$email=$_SESSION['stlemail'];				
		$stl_dir = ABSPATH ."/STL/". $email ."/";
		$stl_url = get_site_url() ."/STL/". $email ."/";
		
		if( file_exists( $stl_dir.$filename ) ){
			$img = $_REQUEST['img_data'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$file = $stl_dir. get_stl_image_name( $filename );
			file_put_contents($file, $data);
			$response['response']='success';
			$response['url']=$stl_url . get_stl_image_name( $filename );
		}else{
			$response['response']='failed';
			$response['url']='#';
		}	
		echo json_encode($response);
    }
     
   die();
}

add_filter( 'woocommerce_cart_get_taxes', 'adjust_shipping_tax', 10, 2 );
function adjust_shipping_tax( $taxes, $cart ){

	$taxes = array();
	/*
	// Merge
	$array_keys=array_keys( $cart->taxes + $cart->shipping_taxes );
	
	if( sizeof($array_keys)>1){
		foreach ( $array_keys as $key ) {
			$taxes[ $key ] = ( isset( $cart->shipping_taxes[ $key ] ) ? $cart->shipping_taxes[ $key ] : 0 ) + ( isset( $cart->taxes[ $key ] ) ? $cart->taxes[ $key ] : 0 );
		}
	}else{
		foreach( $cart->cart_contents as $cart_item ){ if( in_array( $cart_item['product_id'], array(MM_PRODUCT_ID,INCH_PRODUCT_ID) ) ){ $line_tax = $cart_item['line_tax']; break; } } //get line tax
		//echo "line tax: $line_tax";
		$custom_shipping_tax = ( get_extra_cost() * $line_tax ) / 100;
		foreach ( $array_keys as $key ) {
			$taxes[ $key ] = ( isset( $custom_shipping_tax ) ? $custom_shipping_tax : 0 ) + ( isset( $cart->taxes[ $key ] ) ? $cart->taxes[ $key ] : 0 );
		}
	}
	//echo "<pre>";print_r( $cart ); echo "</pre>";
	*/
	return $taxes;
}

//add_filter( 'woocommerce_cart_tax_totals', 'adjust_cart_total', 10, 2 );
function adjust_cart_total( $tax_totals, $cart ){
	//echo "<pre>";print_r( $tax_totals ); echo "</pre>";
	return $tax_totals;
}

/* Custom shipping tax */
//add_filter( 'woocommerce_package_rates', 'custom_shipping_package',10, 2 ); 

function custom_shipping_package( $rates, $package ){
	$rates = WC_Tax::get_rates();
	$first_rate = reset($rates);
	$rate = $first_rate['rate'];
	
	$custom_shipping_tax = (float)(( get_extra_cost() * $rate ) / 100);
	$package['rates']['local_delivery']->cost = get_extra_cost();
	
	if( sizeof( $package['rates']['local_delivery']->taxes ) ){
		foreach( $package['rates']['local_delivery']->taxes as &$v){
			$v=$custom_shipping_tax;
		}
	}
	
	//echo "<pre>"; print_r( $package['rates'] ); echo "</pre>";		
	//echo "<pre>"; print_r( WC_Tax::get_rates() ); echo "</pre>";		
	
	return $package['rates'];
}

/* Get STL image name by STL file */
function get_stl_image_name( $stlfile ){
	return str_replace( ' ', '-', $stlfile ). ".png";
}

/* Custom image on customer email */
add_filter( 'woocommerce_order_item_thumbnail', 'custom_order_item_thumbnail', 10, 2 );

function custom_order_item_thumbnail( $thumbnail, $item ){
	//session_start();
	
	//$email=$item['metastlemail'];				
	$email=$_SESSION['stlemail'];				
	$stl_dir = ABSPATH . "/STL/". $email ."/";
	$stl_url = get_site_url() . "/STL/". $email ."/";
	if( file_exists( $stl_dir . get_stl_image_name( $item['filename'] ) ) && !empty( $item['filename'] ) ){
		
		$stl_image_url = $stl_url.get_stl_image_name( $item['filename'] );
		return '<img src="' . $stl_image_url .'" alt="' . __( 'Product Image', 'woocommerce' ) . '" height="32" width="32" style="vertical-align:middle; margin-right: 10px;" />';
	}else
		return $thumbnail;	
}

/* Save order ID to session after create Order */
add_action( 'woocommerce_new_order', 'save_order_id_to_session' );

function save_order_id_to_session( $order_id ){
	//session_start();
	
	$_SESSION['order_id'] = $order_id;
}

/* Add link to order itemname */
add_filter( 'woocommerce_order_item_name', 'custon_order_item_name', 10, 2 );

function custon_order_item_name( $item_name, $item ){
	//session_start();
	$order_id = $_SESSION['order_id'];
	$order = new WC_Order( $order_id );
	
	//$email=$item['metastlemail'];				
	$email=$_SESSION['stlemail'];				
	$stl_dir = ABSPATH . "/STL/". $email ."/";
	$stl_url = get_site_url() . "/STL/". $email ."/";
	$order_dir = $stl_dir. date("d-m-Y")."/".$order->id."/";
	$order_url = $stl_url. date("d-m-Y")."/".$order->id."/";
	
	if( file_exists( $stl_dir . $item['filename'] ) && !empty( $item['filename'] ) ){
		$url=$stl_url.$item['filename'];
		return "<a href='$url'>$item_name</a>";
	}else if( file_exists( $order_dir . $item['filename'] ) && !empty( $item['filename'] ) ){
		$url=$order_url.$item['filename'];
		return "<a href='$url'>$item_name</a>";
	}else
		return $item_name;
}

remove_filter( 'woocommerce_product_settings', 'wc_measurement_price_calculator_woocommerce_catalog_settings', 11 );
add_filter( 'woocommerce_product_settings', 'new_wc_measurement_price_calculator_woocommerce_catalog_settings', 11 );


function new_wc_measurement_price_calculator_woocommerce_catalog_settings( $settings ) {
	$new_settings = array();
	foreach ( $settings as &$setting ) {

		// safely add metric ton and english ton units to the weight units, in the correct order
		if ( 'woocommerce_weight_unit' == $setting['id'] ) {
			$options = array();
			if ( ! isset( $setting['options']['t'] ) ) $options['t'] = _x( 't', 'metric ton', WC_Measurement_Price_Calculator::TEXT_DOMAIN );  // metric ton
			foreach ( $setting['options'] as $key => $value ) {
				if ( 'lbs' == $key ) {
					if ( ! isset( $setting['options']['tn'] ) ) $options['tn'] = _x( 'tn', 'english ton', WC_Measurement_Price_Calculator::TEXT_DOMAIN );  // english ton
					$options[ $key ] = $value;
				} else {
					if ( ! isset( $options[ $key ] ) ) $options[ $key ] = $value;
				}
			}
			$setting['options'] = $options;
		}

		// safely add kilometer, foot, mile to the dimensions units, in the correct order
		if ( 'woocommerce_dimension_unit' == $setting['id'] ) {
			$options = array();
			if ( ! isset( $setting['options']['km'] ) ) $options['km'] = _x( 'km', 'kilometer', WC_Measurement_Price_Calculator::TEXT_DOMAIN );  // kilometer
			foreach ( $setting['options'] as $key => $value ) {
				if ( 'in' == $key ) {
					$options[ $key ] = $value;
					if ( ! isset( $setting['options']['ft'] ) ) $options['ft'] = _x( 'ft', 'foot', WC_Measurement_Price_Calculator::TEXT_DOMAIN );  // foot
					if ( ! isset( $options['yd'] ) ) $options['yd'] = _x( 'yd', 'yard', WC_Measurement_Price_Calculator::TEXT_DOMAIN );  // yard (correct order)
					if ( ! isset( $setting['options']['mi'] ) ) $options['mi'] = _x( 'mi', 'mile', WC_Measurement_Price_Calculator::TEXT_DOMAIN );  // mile
				} else {
					if ( ! isset( $options[ $key ] ) ) $options[ $key ] = $value;
				}
			}
			$setting['options'] = $options;
		}

		// add the setting into our new set of settings
		$new_settings[] = $setting;

		// add our area and volume units
		if ( 'woocommerce_dimension_unit' == $setting['id'] ) {

			$new_settings[] = array(
				'name'    => __( 'Area Unit', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
				'desc'    => __( 'This controls what unit you can define areas in for the Measurements Price Calculator.', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
				'id'      => 'woocommerce_area_unit',
				'css'     => 'min-width:300px;',
				'std'     => 'sq cm',
				'type'    => 'select',
				'class'   => 'chosen_select',
				'options' => array(
					'ha'      => _x( 'ha',      'hectare',           WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'sq km'   => _x( 'sq km',   'square kilometer',  WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'sq m'    => _x( 'sq m',    'square meter',      WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'sq cm'   => _x( 'sq cm',   'square centimeter', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'sq mm'   => _x( 'sq mm',   'square millimeter', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'acs'     => _x( 'acs',     'acre',              WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'sq. mi.' => _x( 'sq. mi.', 'square mile',       WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'sq. yd.' => _x( 'sq. yd.', 'square yard',       WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'sq. ft.' => _x( 'sq. ft.', 'square foot',       WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'sq. in.' => _x( 'sq. in.', 'square inch',       WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
				),
				'desc_tip'	=>  true,
			);

			// Note: 'cu mm' and 'cu km' are left out because they aren't really all that useful
			$new_settings[] = array(
				'name'    => __( 'Volume Unit', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
				'desc'    => __( 'This controls what unit you can define volumes in for the Measurements Price Calculator.', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
				'id'      => 'woocommerce_volume_unit',
				'css'     => 'min-width:300px;',
				'std'     => 'ml',
				'type'    => 'select',
				'class'   => 'chosen_select',
				'options' => array(
					'cu mm'    => _x( 'cu mm',    'cubic millimeter', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'cu m'    => _x( 'cu m',    'cubic meter', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'l'       => _x( 'l',       'liter',       WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'ml'      => _x( 'ml',      'milliliter',  WC_Measurement_Price_Calculator::TEXT_DOMAIN ),  // aka 'cu cm'
					'gal'     => _x( 'gal',     'gallon',      WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'qt'      => _x( 'qt',      'quart',       WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'pt'      => _x( 'pt',      'pint',        WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'cup'     => __( 'cup',     WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'fl. oz.' => _x( 'fl. oz.', 'fluid ounce', WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'cu. yd.' => _x( 'cu. yd.', 'cubic yard',  WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'cu. ft.' => _x( 'cu. ft.', 'cubic foot',  WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
					'cu. in.' => _x( 'cu. in.', 'cubic inch',  WC_Measurement_Price_Calculator::TEXT_DOMAIN ),
				),
				'desc_tip' => true,
			);
		}
	}
	return $new_settings;
}

/* set price prioity service */
add_filter( 'woocommerce_add_cart_item', 'c_other_options_add_cart_item', 20, 2 );
function c_other_options_add_cart_item( $cart_item ) {
    if ( $cart_item['product_id'] == PRIORITY_SHIPPING_PRODUCT_ID ) :
      
		$extra_cost = get_extra_cost();
		//var_dump( $extra_cost );
        $cart_item['data']->set_price( 100 );
        // here the real adjustment is going on...
	
	
	
    endif;
    return $cart_item;

}

add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );

function add_custom_price( $cart_object ) {
    $extra_cost = get_extra_cost(); // This will be your custome price  
    $global_addon = get_page_by_title( 'Finish', '', 'global_product_addon' );
	$raw_addons = get_post_meta( $global_addon->ID, '_product_addons', true );
	foreach( $raw_addons as $raw_addon ){
		if( $raw_addon['name'] == "Finish" ){
			$options = $raw_addon['options'];
		}
	}
    foreach ( $cart_object->cart_contents as $item_meta_key => $item_meta ) {
		if( $item_meta['product_id']==PRIORITY_SHIPPING_PRODUCT_ID )
			$item_meta['data']->price = $extra_cost;
		if( $item_meta['product_id'] != PRIORITY_SHIPPING_PRODUCT_ID &&  $item_meta['product_id'] != EXPERT_CHECK_ID){
			foreach( $options as $option ){
				if($item_meta['finish'] == $option['label']){
					if($item_meta['data']->comment_count == 0){
						$item_meta['data']->comment_count++;
						$item_meta['data']->price += $option['price'];
					}
				}
			}
		}
    }
    //exit;
}

add_filter( 'woocommerce_cart_item_subtotal', 'adjust_extra_cost_product_item_subtotal', 10, 3 );

function adjust_extra_cost_product_item_subtotal( $subtotal, $cart_item, $cart_item_key ){
	
	if( $cart_item['product_id'] == PRIORITY_SHIPPING_PRODUCT_ID) 
		$subtotal= wc_price( get_extra_cost() );
	
	return $subtotal;
}
add_action( 'woocommerce_checkout_process', 'custom_checkout_posted' );
function custom_checkout_posted(){
	global $woocommerce;
	$woocommerce->checkout->posted['billing_email'] = $_POST['billing_email'];
	$woocommerce->checkout->posted['billing_phone'] = $_POST['billing_phone'];
}
add_filter( 'woocommerce_checkout_fields', 'custom_checkout_fields' );
function custom_checkout_fields($checkout_fields){
	return $checkout_fields;
}

add_filter('woocommerce_update_cart_action_cart_updated','custom_update_cart',10,1);	
function custom_update_cart($cart_updated){
	global $woocommerce;

	$cart_updated = false;
	$cart_totals  = isset( $_POST['cart'] ) ? $_POST['cart'] : '';

	if ( sizeof( WC()->cart->get_cart() ) > 0 && is_array( $cart_totals ) ) {
		foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {

			// Sanitize
			$color = $cart_totals[ $cart_item_key ]['finish'];
			$material_id = $cart_totals[ $cart_item_key ]['material'];
			$material_obj = get_term_by('id', $material_id, 'product_cat');
			$material = $material_obj->name;
			WC()->cart->cart_contents[ $cart_item_key ]['finish'] = $color;
			WC()->cart->cart_contents[ $cart_item_key ]['pricing_item_meta_data']['finish'] = $color;
			WC()->cart->cart_contents[ $cart_item_key ]['material'] = $material;
			WC()->cart->cart_contents[ $cart_item_key ]['pricing_item_meta_data']['material'] = $material;
			$cart_updated = false;

		}
	}

	return $cart_updated;
}
/*============================================================================================*/


//AJAX change dimension 
add_action( 'wp_ajax_update_to_cart_dimension', 'update_to_cart_dimension' );
add_action( 'wp_ajax_nopriv_update_to_cart_dimension', 'update_to_cart_dimension' );
function update_to_cart_dimension(){
	$val_x 		= $_POST['x'];
	$val_y 		= $_POST['y'];
	$val_z 		= $_POST['z'];
	$unit 		= $_POST['unit'];
	$item_key 	= $_POST['item_key'];
	$scale 		= $_POST['scale'];
	$tmp_unit = '';
	if($unit == 'mm'){
		$tmp_unit = 'sq mm';
	}elseif($unit == 'inch'){
		$tmp_unit = 'cu. in.';
	}

	$cart = WC()->session->get('cart');

	$filename = $cart[$item_key]['filename'];
	$email = $_SESSION['stlemail'];

	include_once("STLIO.php");

	$mystlpath = ABSPATH. 'STL/'.$email."/". $filename;

	if(file_exists($mystlpath)){
		$obj = new STLIO($mystlpath);
		$obj->save_scaled_stl($mystlpath, $scale);
		$filename .= '.scaled'.$scale.'x.stl';
		add_stl_to_cart($filename,$tmp_unit,$email);
		if(isset($cart[$item_key])){
			/*
			$cart[$item_key]['pricing_item_meta_data']['length'] = round($val_x,1);
			$cart[$item_key]['pricing_item_meta_data']['width'] = round($val_y,1);
			$cart[$item_key]['pricing_item_meta_data']['height'] = round($val_z,1);
			$cart[$item_key]['pricing_item_meta_data']['filename'] = $filename . '.scaled'.$scale.'x.stl';
			$cart[$item_key]['filename'] = $filename . '.scaled'.$scale.'x.stl';
			*/
			$cart = WC()->session->get('cart');
			unset($cart[$item_key]);
			WC()->session->set('cart',$cart);

		}		
	}

	die();
}

/*AJAX send total email*/
add_action( 'wp_ajax_send_total_quote', 'custom_ajax_send_total_quote' );
add_action( 'wp_ajax_nopriv_send_total_quote', 'custom_ajax_send_total_quote' );
function custom_ajax_send_total_quote(){
	global $woocommerce;
	$total 		= $woocommerce->cart->total;
	$email_user = $_SESSION['stlemail'];
	$from 		= get_option('admin_email');
	$blogname = get_option('blogname');
	$success	= '';
	$error		= '';
	$subject = 'Welcome to 3dprint! Check Your Order Details Inside';
	$html_message  = get_message_content_quote();
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$blogname.' <'.$from.'>'. "\r\n";
	$mail = wp_mail( $email_user, $subject, $html_message, $headers);
	if( $mail ){
		$success = 'Send email successfull';
	}else{
		$error = 'Error! Send email.';
	}
	if( ! empty( $error ) ){
		$result = json_encode(array('status'=>false, 'message'=>__($error)));
	}else{
		$result = json_encode(array('status'=>true, 'message'=>__($success)));
	}
	echo $result;
	exit;
}

function get_message_content_quote(){
//session_start();
ob_start();
?>
	<div>
		<p style="font-size:20px;">Hello, please see below quote for your parts.</p>
	</div>
	<table cellspacing="0" style="width:100%;">
		<thead>
			<tr>
				<th style="padding: 10px 0;background: #8D8DFD;color: #fff;">Product</th>
				<th style="padding: 10px 0;background: #8D8DFD;color: #fff;">Quantity</th>
				<th style="padding: 10px 0;background: #8D8DFD;color: #fff;">Finish price</th>
				<th style="padding: 10px 0;background: #8D8DFD;color: #fff;">Price</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$currency = get_woocommerce_currency_symbol();
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$global_addon = get_page_by_title( 'Finish', '', 'global_product_addon' );
				$raw_addons = get_post_meta( $global_addon->ID, '_product_addons', true );
				foreach( $raw_addons as $raw_addon ){
					if( $raw_addon['name'] == "Finish" ){
						$options = $raw_addon['options'];
					}
				}
				foreach($options as $option){
					if($option['label'] == $cart_item['finish'] ){
						$price_finish = $option['price'] * $cart_item['quantity'];
					}
				}
			?>
			<tr>
				<td style="border-bottom:1px solid #ccc;">
					<p><strong><?php echo $cart_item['filename']; ?></strong></p>
					<dl>
						<dt style="margin-bottom:10px;float:left;margin-right:5px;">Material:</dt>
						<dd style="margin-bottom:10px;"><?php echo $cart_item['material']; ?></dd>
						<dt style="margin-bottom:10px;float:left;margin-right:5px;">Finish:</dt>
						<dd style="margin-bottom:10px;"><?php echo $cart_item['finish']; ?></dd>
					</dl>
				</td>
				<th style="border-bottom:1px solid #ccc;"><?php echo $cart_item['quantity'] ?></th>
				<th style="border-bottom:1px solid #ccc;"><?php echo $currency.$price_finish ?></th>
				<th style="border-bottom:1px solid #ccc;"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></th>
			</tr>
		<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td style="padding:5px 0;">&nbsp;</td>
				<td style="padding:5px 0;">&nbsp;</td>
				<td style="padding:5px 0; border-bottom:1px solid #ccc;text-align: right;padding-right: 5px;">Subtotal:</td>
				<td style="padding:5px 0; border-bottom:1px solid #ccc;"><?php wc_cart_totals_subtotal_html(); ?></td>
			</tr>
			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ){ ?>
			<tr>
				<td style="padding:5px 0;">&nbsp;</td>
				<td style="padding:5px 0;">&nbsp;</td>
				<td style="padding:5px 0; border-bottom:1px solid #ccc;text-align: right;padding-right: 5px;">Freight:</td>
				<td style="padding:5px 0; border-bottom:1px solid #ccc;"><?php echo WC()->cart->get_cart_shipping_total() ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td style="padding:5px 0;">&nbsp;</td>
				<td style="padding:5px 0;">&nbsp;</td>
				<td style="padding:5px 0; border-bottom:1px solid #ccc;text-align: right;padding-right: 5px;">GST:</td>
				<td style="padding:5px 0; border-bottom:1px solid #ccc;"><?php wc_cart_totals_taxes_total_html(); ?></td>
			</tr>
			<tr>
				<td style="padding:5px 0;">&nbsp;</td>
				<td style="padding:5px 0;">&nbsp;</td>
				<td style="padding:5px 0; border-bottom:1px solid #ccc;text-align: right;padding-right: 5px;"><strong>Total:</strong></td>
				<td style="padding:5px 0; border-bottom:1px solid #ccc;"><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>
		</tfoot>
	</table>
<?php
$html_message = ob_get_clean();

return $html_message;
}
add_filter('woocommerce_cart_taxes_total','custom_woocommerce_cart_taxes_total');
function custom_woocommerce_cart_taxes_total($tax_total){
	
	$_tax = new WC_Tax();
	$rate = array_pop($_tax->get_rates());
	$freight_tax = wc_round_tax_total( WC()->cart->shipping_total * $rate['rate'] / 100 );

	return $tax_total + $freight_tax;
}
add_filter('woocommerce_calculated_total','custom_woocommerce_calculated_total');
function custom_woocommerce_calculated_total($total, $cart){
	$_tax = new WC_Tax();
	$rate = array_pop($_tax->get_rates());
	$freight_tax = wc_round_tax_total( WC()->cart->shipping_total * $rate['rate'] / 100 );
	return $total + $freight_tax;
}
add_filter('woocommerce_order_tax_totals','custom_woocommerce_order_tax_totals',10,2);
function custom_woocommerce_order_tax_totals($tax_totals,$wc_order){
	$order = wc_get_order( $wc_order->id );
	$total_shipping = $order->get_total_shipping();
	$_tax = new WC_Tax();
	$rate = array_pop($_tax->get_rates());
	$freight_tax = wc_round_tax_total( $total_shipping * $rate['rate'] / 100 );
	$keys = array_keys($tax_totals);
	$key = array_pop($keys);
	$tax = array_pop($wc_order->get_items( 'tax' ));

	if($tax['shipping_tax_amount'] == 0){
		$tax_totals[$key]->formatted_amount = wc_price( wc_round_tax_total( $tax_totals[$key]->amount + $freight_tax ) );
	}
	return $tax_totals;
}
add_filter('woocommerce_order_amount_total_tax','custom_woocommerce_order_amount_total_tax');
function custom_woocommerce_order_amount_total_tax($tax, $cart){
	$_tax = new WC_Tax();
	$rate = array_pop($_tax->get_rates());
	$freight_tax = wc_round_tax_total( WC()->cart->shipping_total * $rate['rate'] / 100 );
	return $tax + $freight_tax;
}
?>