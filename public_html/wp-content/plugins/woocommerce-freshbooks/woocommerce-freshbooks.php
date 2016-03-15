<?php
/**
 * Plugin Name: WooCommerce FreshBooks
 * Plugin URI: http://www.woothemes.com/products/woocommerce-freshbooks/
 * Description: A full-featured FreshBooks integration for WooCommerce, automatically sync your orders with invoices and more!
 * Author: SkyVerge
 * Author URI: http://www.skyverge.com
 * Version: 3.3.3
 * Text Domain: woocommerce-freshbooks
 * Domain Path: /i18n/languages/
 *
 * Copyright: (c) 2012-2015 SkyVerge, Inc. (info@skyverge.com)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   WC-FreshBooks
 * @author    SkyVerge
 * @category  Integration
 * @copyright Copyright (c) 2012-2015, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Required functions
if ( ! function_exists( 'woothemes_queue_update' ) ) {
	require_once( 'woo-includes/woo-functions.php' );
}

// Plugin updates
woothemes_queue_update( plugin_basename( __FILE__ ), '157b35835ab64abe650e5fb17af4c631', '18660' );

// WC active check
if ( ! is_woocommerce_active() ) {
	return;
}

// Required library class
if ( ! class_exists( 'SV_WC_Framework_Bootstrap' ) ) {
	require_once( 'lib/skyverge/woocommerce/class-sv-wc-framework-bootstrap.php' );
}

SV_WC_Framework_Bootstrap::instance()->register_plugin( '3.1.0', __( 'WooCommerce FreshBooks', 'woocommerce-freshbooks' ), __FILE__, 'init_woocommerce_freshbooks', array( 'minimum_wc_version' => '2.1', 'backwards_compatible' => '3.1.0' ) );

function init_woocommerce_freshbooks() {

/**
 * # WooCommerce FreshBooks Main Plugin Class
 *
 * ## Plugin Overview
 *
 * This plugin integrates FreshBooks with WooCommerce by exporting customers/orders
 * to FreshBooks as clients/invoices
 *
 * ## Features
 *
 * + Create invoices & clients for orders (either automatically or manually)
 * + Apply invoice payments after an order is paid (automatically or manually)
 * + Link products to FreshBooks items
 * + Keep invoices & payments synced between FreshBooks and WooCommerce
 *
 * ## Admin Considerations
 *
 * + 'FreshBooks' setting tab added to WooCommerce > Settings
 * + 'FreshBooks Item' select on Simple/Variable product data tab
 * + 'Invoice Status' column on Orders screen
 * + 'Create & Send Invoice' order action on Orders screen
 * + Custom bulk order actions for creating invoices on Orders screen
 * + Custom bulk filter for invoice status on Order screen
 * + Order actions for creating invoices on Order Edit screen
 * + Custom metabox for invoice info on Order Edit screen
 *
 * ## Frontend Considerations
 *
 * + None
 *
 * ## Database
 *
 * ### Global Options
 *
 * + `wc_freshbooks_api_url` - URL for the FreshBooks API
 * + `wc_freshbooks_authentication_token` - auth token for the API
 * + `wc_freshbooks_debug_mode` - yes to enable debug mode
 * + `wc_freshbooks_default_client` - `none` to create a new client for each customer, or the client ID of a client to create all invoices under
 * + `wc_freshbooks_invoice_language` - the language for created invoices
 * + `wc_freshbooks_invoice_sending_method` - the method to send invoices by, either `email` or `snail_mail`
 * + `wc_freshbooks_use_order_number` - yes to to use WC order number as invoice number, false to let FreshBooks generate it
 * + `wc_freshbooks_invoice_number_prefix` - a prefix for the invoice order number
 * + `wc_freshbooks_auto_create_invoices` - yes to automatically create invoices for all new orders
 * + `wc_freshbooks_auto_send_invoices` - yes to automatically send invoices upon creation
 * + `wc_freshbooks_auto_apply_payments` - yes to automatically apply order payment to the invoice
 *
 * ### Options table
 *
 * + `wc_freshbooks_version` - the current plugin version, set on install/upgrade
 * + `wc_freshbooks_upgraded_from_v2` - bool, set to true when upgraded from a version prior to v3.0
 *
 * ### Order Meta
 *
 * + `_wc_freshbooks_invoice_id` - FreshBooks ID for invoice
 * + `_wc_freshbooks_client_id` - FreshBooks client ID for associated invoice
 * + `_wc_freshbooks_payment_id` - FreshBooks payment ID for the invoice, if one exists
 * + `_wc_freshbooks_invoice_status` - invoice status
 * + `_wc_freshbooks_invoice` - invoice data as serialized array, see WC_FreshBooks_API_Request::parse_get_invoice() for format
 *
 * ### Product Meta
 *
 * + `_wc_freshbooks_item_name` - FreshBooks item name associated with the product
 *
 * ### Customer Meta
 *
 * + `_wc_freshbooks_client_id` - FreshBooks client ID for customer/user
 *
 * @since 3.0
 */
class WC_FreshBooks extends SV_WC_Plugin {


	/** string version number */
	const VERSION = '3.3.3';

	/** @var WC_FreshBooks single instance of this plugin */
	protected static $instance;

	/** string the plugin id */
	const PLUGIN_ID = 'freshbooks';

	/** string plugin text domain */
	const TEXT_DOMAIN = 'woocommerce-freshbooks';

	/** @var \WC_FreshBooks_Admin instance */
	public $admin;

	/** @var \WC_FreshBooks_Settings instance */
	public $settings;

	/** @var \WC_FreshBooks_Orders_Admin instance */
	public $orders_admin;

	/** @var \WC_FreshBooks_Products_Admin instance */
	public $products_admin;

	/** @var \WC_FreshBooks_Webhooks instance */
	public $webhooks;

	/** @var \WC_FreshBooks_Handler instance */
	public $handler;

	/** @var \WC_FreshBooks_API instance */
	private $api;


	/**
	 * Setup main plugin class
	 *
	 * @since 3.0
	 * @see SV_WC_Plugin::__construct()
	 */
	public function __construct() {

		parent::__construct(
			self::PLUGIN_ID,
			self::VERSION,
			self::TEXT_DOMAIN
		);

		// load includes after WC is loaded
		add_action( 'sv_wc_framework_plugins_loaded', array( $this, 'includes' ), 11 );

		// remove the invoice data from new renewal orders for subscription renewals so a new invoice is created for each renewal order
		add_filter( 'woocommerce_subscriptions_renewal_order_meta_query', array( $this, 'remove_subscriptions_renewal_order_meta' ) );

		// maybe disable API logging
		if ( 'on' !== get_option( 'wc_freshbooks_debug_mode' ) ) {
			remove_action( 'wc_' . $this->get_id() . '_api_request_performed', array( $this, 'log_api_request' ), 10, 2 );
		}
	}


	/**
	 * Load plugin text domain.
	 *
	 * @since 3.0
	 * @see SV_WC_Payment_Gateway_Plugin::load_translation()
	 */
	public function load_translation() {

		load_plugin_textdomain( 'woocommerce-freshbooks', false, dirname( plugin_basename( $this->get_file() ) ) . '/i18n/languages' );
	}


	/**
	 * Loads any required files
	 *
	 * @since 3.0
	 */
	public function includes() {

		require_once( 'includes/class-wc-freshbooks-order.php' );

		require_once( 'includes/class-wc-freshbooks-handler.php' );
		$this->handler = new WC_FreshBooks_Handler();

		require_once( 'includes/class-wc-freshbooks-webhooks.php' );
		$this->webhooks = new WC_FreshBooks_Webhooks();

		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			$this->admin_includes();
		}
	}


	/**
	 * Loads required admin files
	 *
	 * @since 3.0
	 */
	private function admin_includes() {

		// add settings page
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_settings_page' ) );

		require_once( 'includes/admin/class-wc-freshbooks-admin.php' );
		$this->admin = new WC_FreshBooks_Admin();

		require_once( 'includes/admin/class-wc-freshbooks-orders-admin.php' );
		$this->orders_admin = new WC_FreshBooks_Orders_Admin();

		require_once( 'includes/admin/class-wc-freshbooks-products-admin.php' );
		$this->products_admin = new WC_FreshBooks_Products_Admin();
	}


	/** Admin methods ******************************************************/


	/**
	 * Add settings page
	 *
	 * @since 3.2.0
	 * @param array $settings
	 * @return array
	 */
	public function add_settings_page( $settings ) {

		$settings[] = require_once( 'includes/admin/class-wc-freshbooks-settings.php' );
		return $settings;
	}


	/**
	 * Don't copy over the invoice ID meta when creating a renewal order
	 *
	 * @since 3.0
	 * @param array $order_meta_query MySQL query for pulling the metadata
	 * @return string
	 */
	public function remove_subscriptions_renewal_order_meta( $order_meta_query ) {

		$order_meta_query .= " AND `meta_key` NOT IN ("
			. "'_wc_freshbooks_invoice_id', "
			. "'_wc_freshbooks_client_id', "
			. "'_wc_freshbooks_payment_id', "
			. "'_wc_freshbooks_invoice_status', "
			. "'_wc_freshbooks_invoice' )";

		return $order_meta_query;
	}


	/**
	 * Renders any admin notices
	 *
	 * @since 3.2.0
	 * @see SV_WC_Plugin::add_admin_notices()
	 */
	public function add_delayed_admin_notices() {

		parent::add_delayed_admin_notices();

		// onboarding!
		if ( ! get_option( 'wc_freshbooks_api_url' ) ) {

			if ( get_option( 'wc_freshbooks_upgraded_from_v2' ) ) {

				$message = __( 'Thanks for upgrading to the latest WooCommerce FreshBooks plugin! Please double-check your %sinvoice settings%s.', self::TEXT_DOMAIN );

			} else {

				$message = __( 'Thanks for installing the WooCommerce FreshBooks plugin! To get started, please %sadd your FreshBooks API credentials%s. ', self::TEXT_DOMAIN );
			}

			$this->get_admin_notice_handler()->add_admin_notice( sprintf( $message, '<a href="' . $this->get_settings_url() . '">', '</a>' ), 'welcome-notice' );
		}
	}


	/** Helper methods ******************************************************/


	/**
	 * Main FreshBooks Instance, ensures only one instance is/can be loaded
	 *
	 * @since 3.3.0
	 * @see wc_freshbooks()
	 * @return WC_FreshBooks
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * Lazy load the FreshBooks API wrapper
	 *
	 * @since 3.0
	 * @return \WC_FreshBooks_API instance
	 * @throws Exception missing API URL or authentication token settings
	 */
	public function get_api() {

		if ( is_object( $this->api ) ) {
			return $this->api;
		}

		$api_url              = get_option( 'wc_freshbooks_api_url' );
		$authentication_token = get_option( 'wc_freshbooks_authentication_token' );

		// bail if required info is not available
		if ( ! $api_url || ! $authentication_token ) {
			throw new SV_WC_API_Exception( __( 'Missing API URL or Authentication Token', self::TEXT_DOMAIN ) );
		}

		// bail if API URL does not appear to be valid
		if ( false === strpos( $api_url, 'freshbooks.com/api/2.1/xml-in' ) ) {
			throw new SV_WC_API_Exception( __( 'Incorrect API URL', self::TEXT_DOMAIN ) );
		}

		// load API files
		require_once( 'includes/api/class-wc-freshbooks-api-request.php' );
		require_once( 'includes/api/class-wc-freshbooks-api-response.php' );
		require_once( 'includes/api/class-wc-freshbooks-api.php' );

		return $this->api = new WC_FreshBooks_API( $api_url, $authentication_token );
	}


	/** Getter methods ******************************************************/


	/**
	 * Returns the plugin name, localized
	 *
	 * @since 3.0
	 * @see SV_WC_Plugin::get_plugin_name()
	 * @return string the plugin name
	 */
	public function get_plugin_name() {
		return __( 'WooCommerce FreshBooks', self::TEXT_DOMAIN );
	}


	/**
	 * Returns __FILE__
	 *
	 * @since 3.0
	 * @see SV_WC_Plugin::get_file()
	 * @return string the full path and filename of the plugin file
	 */
	protected function get_file() {
		return __FILE__;
	}


	/**
	 * Gets the plugin configuration URL
	 *
	 * @since 3.0
	 * @see SV_WC_Plugin::get_settings_url()
	 * @param string $_ unused
	 * @return string plugin settings URL
	 */
	public function get_settings_url( $_ = null ) {
		return admin_url( 'admin.php?page=wc-settings&tab=freshbooks' );
	}


	/**
	 * Returns conditional dependencies based on the FTP security selected
	 *
	 * @since 1.1
	 * @see SV_WC_Plugin::get_dependencies()
	 * @return array of dependencies
	 */
	protected function get_dependencies() {

		return array( 'xmlwriter' );
	}


	/** Lifecycle methods ******************************************************/


	/**
	 * Run install
	 *
	 * @since 3.0
	 * @see SV_WC_Plugin::install()
	 */
	protected function install() {

		// include settings so we can install defaults
		require_once( WC()->plugin_path() . '/includes/admin/settings/class-wc-settings-page.php' );
		require_once( 'includes/admin/class-wc-freshbooks-settings.php' );

		foreach ( $this->settings->get_settings() as $setting ) {

			if ( isset( $setting['default'] ) ) {

				update_option( $setting['id'], $setting['default'] );
			}
		}

		// versions prior to 3.0 did not set a version option, so the upgrade
		// method needs to be called manually
		if ( get_option( 'wc_fb_api_url' ) ) {

			$this->upgrade( '2.1.3' );
		}
	}


	/**
	 * Perform any version-related changes.
	 *
	 * @since 3.0
	 * @see SV_WC_Plugin::upgrade()
	 * @param int $installed_version the currently installed version of the plugin
	 */
	protected function upgrade( $installed_version ) {

		// upgrade to 3.0
		if ( version_compare( $installed_version, '3.0', '<' ) ) {

			// API URL / token
			update_option( 'wc_freshbooks_api_url',              get_option( 'wc_fb_api_url' ) );
			update_option( 'wc_freshbooks_authentication_token', get_option( 'wc_fb_api_token' ) );

			// invoice send method
			update_option( 'wc_freshbooks_invoice_sending_method', ( 'SnailMail' == get_option( 'wc_fb_send_method' ) ? 'snail_mail' : 'email' ) );

			// use order number as invoice number
			update_option( 'wc_freshbooks_use_order_number', ( get_option( 'wc_fb_use_order_number' ) ? 'yes' : 'no' ) );

			// invoice number prefix
			update_option( 'wc_freshbooks_invoice_number_prefix', get_option( 'wc_fb_inv_num_prefix' ) );

			// auto-send invoice
			update_option( 'wc_freshbooks_auto_send_invoices', ( get_option( 'wc_fb_send_invoice' ) ? 'yes' : 'no' ) );

			// auto-apply payments
			update_option( 'wc_freshbooks_auto_apply_payments', ( get_option( 'wc_fb_add_payments' ) ? 'yes' : 'no' ) );

			// mark as migrated
			update_option( 'wc_freshbooks_upgraded_from_v2', 1 );

			// remove old options
			$old_options = array(
				'wc_fb_api_url',
				'wc_fb_api_token',
				'wc_fb_create_client',
				'wc_fb_generic_client',
				'wc_fb_add_payments',
				'wc_fb_send_invoice',
				'wc_fb_send_method',
				'wc_fb_use_order_number',
				'wc_fb_inv_num_prefix'
			);

			foreach ( $old_options as $option ) {

				delete_option( $option );
			}
		}
	}


} // end \WC_FreshBooks class


/**
 * Returns the One True Instance of FreshBooks
 *
 * @since 3.3.0
 * @return WC_FreshBooks
 */
function wc_freshbooks() {
	return WC_FreshBooks::instance();
}


/**
 * The WC_FreshBooks global object
 *
 * @deprecated 3.3.0
 * @name $wc_freshbooks
 * @global WC_FreshBooks $GLOBALS['wc_freshbooks']
 */
$GLOBALS['wc_freshbooks'] = wc_freshbooks();

} // init_woocommerce_freshbooks
