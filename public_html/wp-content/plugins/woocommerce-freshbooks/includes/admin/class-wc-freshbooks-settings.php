<?php
/**
 * WooCommerce FreshBooks
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce FreshBooks to newer
 * versions in the future. If you wish to customize WooCommerce FreshBooks for your
 * needs please refer to http://docs.woothemes.com/document/woocommerce-freshbooks/
 *
 * @package   WC-FreshBooks/Admin/Settings
 * @author    SkyVerge
 * @copyright Copyright (c) 2012-2015, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * FreshBooks Settings Admin class
 *
 * Loads / saves the admin settings page
 *
 * @since 3.0
 */
class WC_FreshBooks_Settings extends WC_Settings_Page {


	/**
	 * Add various admin hooks/filters
	 *
	 * @since 3.0
	 */
	public function __construct() {

		$this->id    = 'freshbooks';
		$this->label = __( 'FreshBooks', WC_FreshBooks::TEXT_DOMAIN );

		// add tab
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );

		// show settings
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );

		// save settings
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
	}


	/**
	 * Save settings, overridden to maybe create the webhook on save
	 *
	 * @since 3.2.0
	 * @see WC_Settings_Page::save()
	 */
	public function save() {

		parent::save();

		$this->maybe_create_webhook();
	}


	/**
	 * Create a webhook for invoice/client/item events
	 *
	 * @since 3.0
	 */
	private function maybe_create_webhook() {

		try {

			// valid API credentials are required
			if ( is_object( wc_freshbooks()->get_api() ) && ! get_option( 'wc_freshbooks_webhook_id' ) ) {

				$webhook_id = wc_freshbooks()->get_api()->create_webhook();

				update_option( 'wc_freshbooks_webhook_id', $webhook_id );
			}

		} catch ( SV_WC_API_Exception $e ) {

			wc_freshbooks()->log( sprintf( '%s - %s', $e->getCode(), $e->getMessage() ) );
		}
	}


	/**
	 * Get settings array
	 *
	 * @since 3.0
	 * @return array
	 */
	public function get_settings() {

		list( $default_site_language ) = explode( '_', get_locale() );

		return apply_filters( 'wc_freshbooks_settings', array(

			array( 'name' => __( 'API Settings', WC_FreshBooks::TEXT_DOMAIN), 'type' => 'title' ),

			// API URL
			array(
				'id'       => 'wc_freshbooks_api_url',
				'name'     => __( 'API URL', WC_FreshBooks::TEXT_DOMAIN),
				'desc_tip' => __( 'Enter the API URL shown on the FreshBooks API page.', WC_FreshBooks::TEXT_DOMAIN),
				'type'     => 'text'
			),

			// authentication token
			array(
				'id'       => 'wc_freshbooks_authentication_token',
				'name'     => __( 'Authentication Token', WC_FreshBooks::TEXT_DOMAIN),
				'desc_tip' => __( 'Enter the Authentication token shown on the FreshBooks API page.', WC_FreshBooks::TEXT_DOMAIN ),
				'type'     => 'password',
			),

			// debug mode
			array(
				'id'       => 'wc_freshbooks_debug_mode',
				'name'     => __( 'Debug Mode', WC_FreshBooks::TEXT_DOMAIN ),
				'desc_tip' => __( 'This logs API requests/responses to the WooCommerce log. Please only enable this if you are having issues.', WC_FreshBooks::TEXT_DOMAIN ),
				'default'  => 'off',
				'type'     => 'select',
				'options'  => array(
					'off' => __( 'Off', WC_FreshBooks::TEXT_DOMAIN ),
					'on'  => __( 'Save to Log', WC_FreshBooks::TEXT_DOMAIN ),
				),
			),

			array( 'type' => 'sectionend' ),

			array( 'name' => __( 'Invoice Settings', WC_FreshBooks::TEXT_DOMAIN), 'type' => 'title' ),

			// default client
			array(
				'id'       => 'wc_freshbooks_default_client',
				'name'     => __( 'Default Client', WC_FreshBooks::TEXT_DOMAIN ),
				'desc_tip' => __( 'Select a client to create all invoices under, or select "none" to create a new client for each customer.' ),
				'type'     => 'select',
				'options'  => $this->get_active_clients(),
				'default'  => 'none',
				'css'      => 'max-width: 400px;',
				'class'    => 'wc-enhanced-select chosen_select',
			),

			// default language
			array(
				'id'       => 'wc_freshbooks_invoice_language',
				'name'     => __( 'Default Language', WC_FreshBooks::TEXT_DOMAIN ),
				'desc_tip' => __( 'Chose the default language used for invoices. This defaults to your site language.' ),
				'type'     => 'select',
				'options'  => $this->get_available_languages(),
				'default'  => $default_site_language,
				'class'    => 'wc-enhanced-select chosen_select',
			),

			// invoice sending method
			array(
				'id'       => 'wc_freshbooks_invoice_sending_method',
				'name'     => __( 'Send Invoices By', WC_FreshBooks::TEXT_DOMAIN ),
				'desc_tip' => __( 'Select how to send invoices. If you select Snail Mail, you must have enough stamps in your FreshBooks account.', WC_FreshBooks::TEXT_DOMAIN ),
				'type'     => 'select',
				'options'  => array(
					'email'      => __( 'Email', WC_FreshBooks::TEXT_DOMAIN ),
					'snail_mail' => __( 'Snail Mail', WC_FreshBooks::TEXT_DOMAIN ),
				),
				'default'  => 'email',
			),

			// use order number as invoice number
			array(
				'id'      => 'wc_freshbooks_use_order_number',
				'name'    => __( 'Use Order Number as Invoice Number', WC_FreshBooks::TEXT_DOMAIN ),
				'desc'    => __( 'Enable this to use the order number as the invoice number. Disable to allow FreshBooks to auto-generate the invoice number.', WC_FreshBooks::TEXT_DOMAIN ),
				'type'    => 'checkbox',
				'default' => 'yes',
			),

			// invoice number prefix
			array(
				'id'       => 'wc_freshbooks_invoice_number_prefix',
				'name'     => __( 'Invoice Number Prefix', WC_FreshBooks::TEXT_DOMAIN ),
				'desc_tip' => __( 'Enter a prefix for the invoice number or leave blank to not use a prefix.', WC_FreshBooks::TEXT_DOMAIN ),
				'type'     => 'text',
			),

			array( 'type' => 'sectionend' ),

			array( 'name' => __( 'Invoice Workflow', WC_FreshBooks::TEXT_DOMAIN), 'type' => 'title' ),

			// automatically create invoices
			array(
				'id'      => 'wc_freshbooks_auto_create_invoices',
				'name'    => __( 'Automatically Create Invoices', WC_FreshBooks::TEXT_DOMAIN ),
				'desc'    => __( 'Enable this to automatically create invoices for new orders, otherwise invoices must be created manually.', WC_FreshBooks::TEXT_DOMAIN ),
				'default' => 'yes',
				'type'    => 'checkbox',
			),

			// automatically send invoices
			array(
				'id'      => 'wc_freshbooks_auto_send_invoices',
				'name'    => __( 'Automatically Send Invoices', WC_FreshBooks::TEXT_DOMAIN ),
				'desc'    => __( 'Enable this to automatically send invoices after creation. Disable to leave created invoices as drafts.', WC_FreshBooks::TEXT_DOMAIN ),
				'default' => 'yes',
				'type'    => 'checkbox',
			),

			// apply payments to invoice
			array(
				'id'      => 'wc_freshbooks_auto_apply_payments',
				'name'    => __( 'Automatically Apply Payments', WC_FreshBooks::TEXT_DOMAIN ),
				'desc'    => __( 'Enable this to automatically apply invoice payments for orders that have received payment.', WC_FreshBooks::TEXT_DOMAIN ),
				'type'    => 'checkbox',
				'default' => 'yes',
			),

			array( 'type' => 'sectionend' ),

		) );
	}


	/**
	 * Get active clients for the FreshBooks account
	 *
	 * Note the API call does not paginate so this is limited to 100 active
	 * clients which should be sufficient
	 *
	 * Active clients are cached for 5 minutes
	 *
	 * @since 3.0
	 * @return array
	 */
	private function get_active_clients() {

		$active_clients = array( 'none' => __( 'None', WC_FreshBooks::TEXT_DOMAIN ) );

		// during the initial install, this is sometimes not a proper object
		// which throws fatal errors when trying to call get_api()
		if ( ! is_object( wc_freshbooks() ) ) {
			return $active_clients;
		}

		try {

			foreach ( wc_freshbooks()->get_api()->get_active_clients() as $client ) {

				$active_clients[ $client['client_id'] ] = sprintf( '%s (%s)', $client['name'], $client['email'] );
			}

		} catch ( SV_WC_API_Exception $e ) {

			wc_freshbooks()->log( $e->getMessage() );
		}

		return $active_clients;
	}


	/**
	 * Get available invoice languages via FreshBooks API
	 *
	 * Languages are cached for 5 minutes
	 *
	 * @since 3.0
	 * @return array
	 */
	private function get_available_languages() {

		$invoice_languages = array();

		// during the initial install, this is sometimes not a proper object
		// which throws fatal errors when trying to call get_api()
		if ( ! is_object( wc_freshbooks() ) ) {
			return $invoice_languages;
		}

		try {

			$invoice_languages = wc_freshbooks()->get_api()->get_languages();

		} catch ( SV_WC_API_Exception $e ) {

			wc_freshbooks()->log( $e->getMessage() );
		}

		return $invoice_languages;
	}


}


// setup settings
return wc_freshbooks()->settings = new WC_FreshBooks_Settings();
