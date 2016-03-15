<?php
/**
Plugin Name: WPP Premium Functionality
Plugin URI: http://muneeb.me/wp-popup-plugin/
Description: Add the premium popup themes and premium functionality to the WordPress Popup Plugin
Author: Muneeb
Author URI: http://muneeb.me/wp-popup-plugin/
Version: 0.5
Copyright: 2012 Muneeb ur Rehman http://muneeb.me
**/

define( 'WPP_PREMIUM_FUNCTIONALITY_PATH', plugin_dir_path( __FILE__ ) );

define( 'WPP_PREMIUM_FUNCTIONALITY', true );

function wpp_load_premium_functionality(){

	if ( ! defined( 'POPUP_PLUGIN_VERSION' ) )
		return FALSE; //Premium Version not installed

	$path = plugin_dir_path( __FILE__ );

	//Load Themes
	
	include $path . 'D1/theme_class.php';

	include $path . 'html-theme/class-wpp-html-popup-theme.php';

	include $path . 'D2/class-wpp-d2-popup-theme.php';

	include $path . 'D6/class-wpp-d6-popup-theme.php';
	
	include $path . 'D8/class-wpp-d8-popup-theme.php';

	new Wpp_D1_Popup_Theme();
	new Wpp_D2_Popup_Theme();
	new Wpp_D8_Popup_Theme();
	new Wpp_D6_Popup_Theme();

	new Wpp_Html_Popup_Theme();

	//Load Addons

	include $path . 'rules/rules.php';

	include $path . 'campaignmonitor/integrate.php';

	include $path . 'aweber/integrate.php';

	include $path . 'icontact/integrate.php';

	include $path . 'constantcontact/integrate.php';

}

add_action( 'plugins_loaded', 'wpp_load_premium_functionality' );