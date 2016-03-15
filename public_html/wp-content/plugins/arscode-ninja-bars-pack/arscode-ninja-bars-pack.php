<?php
/*
  Plugin Name: Ninja Popups - Bars Pack
  Plugin URI: http://codecanyon.net/item/ninja-popups-for-wordpress/3476479?ref=arscode
  Description: 
  Version: 1.1
  Author: ArsCode
  Author URI: http://www.arscode.pro/
  License:
 */


add_filter('snp_themes_dir', 'snp_themes_dir_bars', 10, 3);
define('SNP_BAR_URL', plugins_url('/', __FILE__));
function snp_themes_dir_bars($val)
{
    $val[] = plugin_dir_path(__FILE__) . '/themes/';
    return $val;
}

function snp_bars_pack_1()
{
    if (file_exists(plugin_dir_path(__FILE__) . '/../arscode-ninja-popups/arscode-ninja-popups.php'))
    {
	$np_data = get_plugin_data(plugin_dir_path(__FILE__) . '/../arscode-ninja-popups/arscode-ninja-popups.php');
	if (version_compare($np_data['Version'], '3.3', '>='))
	{
	    return;
	}
    }
    echo "<div style=\"padding: 20px; background-color: #ef9999; margin: 40px; border: 1px solid #cc0000; \"><b>Requirement: you need to have version 3.3 or later of Ninja Popup for Wordpress to run Bars Pack.</b></div>";
}

add_action('admin_notices', 'snp_bars_pack_1');
?>