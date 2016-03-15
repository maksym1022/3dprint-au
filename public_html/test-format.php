<?php
require_once( "wp-load.php" );

$type=(isset($_POST['quote_type']) && $_POST['quote_type']=="checkout" ? "checkout" : "cart" );
		$type="checkout";
echo get_html_message_content($type);

?>