<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
	<?php
		$STL_data="";
		foreach ( $item_data as $data ) :
			if(strpos($data["key"],"Length")!== false)
				$STL_data.=$data['value']." x ";
			elseif(strpos($data["key"],"Width")!== false)
				$STL_data.=$data['value']." x ";
			elseif(strpos($data["key"],"Height")!== false)
				$STL_data.=$data['value']."";			
			else {
	?>
		<dt class="variation-<?php echo sanitize_html_class( $key ); ?>"><?php echo wp_kses_post( $data['key'] ); ?>: <span><?php echo $data['value']; ?></span></dt>
	<?php } ?>
	<?php endforeach; 
	echo $STL_data;
	?>
