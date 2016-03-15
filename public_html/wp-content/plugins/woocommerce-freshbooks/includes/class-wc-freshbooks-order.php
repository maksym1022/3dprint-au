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
 * @package   WC-FreshBooks/Order
 * @author    SkyVerge
 * @copyright Copyright (c) 2012-2015, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * FreshBooks Order Class
 *
 * Extends the WooCommerce Order class to add additional information and
 * functionality specific to FreshBooks
 *
 * @since 3.0
 * @extends \WC_Order
 */
class WC_FreshBooks_Order extends WC_Order {

	/** @var \stdClass invoice data */
	public $invoice;


	/**
	 * Setup the order normally and add invoice-specific class members
	 *
	 * @since 3.0
	 * @param string|int $order_id
	 * @return \WC_FreshBooks_Order
	 */
	public function __construct( $order_id ) {

		parent::__construct( $order_id );

		// easy access to invoice data
		$this->invoice = new stdClass();
		foreach ( (array) $this->wc_freshbooks_invoice as $key => $value ) {

			$this->invoice->$key = $value;
		}
	}


	/**
	 * Get the invoice status
	 *
	 * Note this retrieves the status using the post meta stored instead of the
	 * invoice object, as it's guaranteed to be the most up-to-date status
	 *
	 * @since 3.0
	 * @return string invoice status, or null if the invoice hasn't been created yet
	 */
	public function get_invoice_status() {

		return $this->invoice_was_created() ? get_post_meta( $this->id, '_wc_freshbooks_invoice_status', true ) : null;
	}


	/**
	 * Get the invoice status formatted for display
	 *
	 * @since 3.0
	 * @return string pretty invoice status
	 */
	public function get_invoice_status_for_display() {

		$status = $this->get_invoice_status();

		return $status ? ucwords( $status ) : '-';
	}


	/**
	 * Send the invoice
	 *
	 * @since 3.0
	 * @return string pretty invoice status
	 */
	public function send_invoice() {

		// bail if the invoice was already sent
		if ( $this->invoice_was_sent() ) {
			return;
		}

		$sending_method = get_option( 'wc_freshbooks_invoice_sending_method', 'email' );

		$this->api()->send_invoice( $this->wc_freshbooks_invoice_id, $sending_method );

		$this->add_order_note( sprintf( __( 'FreshBooks invoice sent via %s.', WC_FreshBooks::TEXT_DOMAIN ), str_replace( '_', ' ', $sending_method ) ) );
	}


	/**
	 * Create an invoice for the order. This process involves:
	 *
	 * + Finding or creating a client for the invoice
	 * + Sending the invoice (if enabled)
	 * + Saving the invoice data to order meta
	 *
	 * @since 3.0
	 * @param bool $auto_send automatically send the invoice upon completion, or false to create a draft invoice
	 * @return string created invoice ID or null if invoice creation failed
	 */
	public function create_invoice( $auto_send = true ) {

		if ( $this->invoice_was_created() ) {

			return $this->wc_freshbooks_invoice_id;
		}

		try {

			$this->invoice_client_id = $this->get_client();

			// save immediately in case invoice creation fails
			update_post_meta( $this->id, '_wc_freshbooks_client_id', $this->invoice_client_id );

			// create the invoice
			$invoice_id = $this->api()->create_invoice( $this );

			// save invoice/client ID
			update_post_meta( $this->id, '_wc_freshbooks_invoice_id', $invoice_id );

			// auto-send invoice?
			if ( $auto_send && ( 'yes' == get_option( 'wc_freshbooks_auto_send_invoices' ) ) ) {

				$this->send_invoice();

				$this->add_order_note( __( 'FreshBooks invoice created.', WC_FreshBooks::TEXT_DOMAIN ) );

			} else {

				$this->add_order_note( __( 'FreshBooks draft invoice created.', WC_FreshBooks::TEXT_DOMAIN ) );
			}

			// important to do this immediately as the webhook that also updates this could be slow or unreachable
			$this->refresh_invoice();

			return $invoice_id;

		} catch ( SV_WC_API_Exception $e ) {

			wc_freshbooks()->log( sprintf( '%s - %s', $e->getCode(), $e->getMessage() ) );

			$this->add_order_note( sprintf( __( 'Unable to create FreshBooks invoice (%s).', WC_FreshBooks::TEXT_DOMAIN ), $e->getMessage() ) );
		}
	}


	/**
	 * Update the invoice in FreshBooks from the current order. Useful if line
	 * items are added or removed.
	 *
	 * @since 3.2.0
	 */
	public function update_invoice_from_order() {

		if ( ! $this->invoice_was_created() ) {
			return;
		}

		try {

			// required info when updating
			$this->invoice_id        = $this->wc_freshbooks_invoice_id;
			$this->invoice_client_id = $this->wc_freshbooks_client_id;
			$this->invoice_status    = $this->get_invoice_status();

			$this->api()->update_invoice( $this );

			$this->refresh_invoice();

			$this->add_order_note( __( 'FreshBooks invoice updated.', WC_FreshBooks::TEXT_DOMAIN ) );

		} catch ( SV_WC_API_Exception $e ) {

			wc_freshbooks()->log( sprintf( '%s - %s', $e->getCode(), $e->getMessage() ) );

			$this->add_order_note( sprintf( __( 'Unable to update FreshBooks invoice (%s).', WC_FreshBooks::TEXT_DOMAIN ), $e->getMessage() ) );
		}
	}


	/**
	 * Refresh the invoice data saved to the order by getting the invoice data
	 * from FreshBooks
	 *
	 * Used primarily after creating an invoice or when an invoice is updated in
	 * Freshbooks and should be reflected in WC
	 *
	 * @since 3.0
	 */
	public function refresh_invoice() {

		if ( ! $this->invoice_was_created() ) {
			return;
		}

		$invoice = $this->api()->get_invoice( $this->wc_freshbooks_invoice_id );

		update_post_meta( $this->id, '_wc_freshbooks_invoice', $invoice );
		update_post_meta( $this->id, '_wc_freshbooks_invoice_status', $invoice['status'] );
	}


	/**
	 * Get the client ID for the order using this logic:
	 *
	 * 1) Use the default client option if set
	 * 2) For registered customers, check if a client ID is stored in user meta
	 * 3) Check if a client was previously created for this order and stored in order meta
	 * 4) Try to lookup the customer in FreshBooks using their billing email
	 * 5) Otherwise, create a new client
	 *
	 * Created client IDs are saved to user meta if the customer is logged in
	 *
	 * @since 3.0
	 * @return string the FreshBooks client ID to create invoice under
	 */
	private function get_client() {

		// return default client if set
		if ( 'none' != ( $client_id = get_option( 'wc_freshbooks_default_client' ) ) ) {

			return $client_id;
		}

		// for registered customer, check user meta
		if ( ! empty( $this->customer_user ) && metadata_exists( 'user', $this->customer_user, '_wc_freshbooks_client_id' ) ) {

			return get_user_meta( $this->customer_user, '_wc_freshbooks_client_id', true );
		}

		// when invoice creation fails after the client has been created, the order
		// meta contains the created client ID
		if ( metadata_exists( 'post', $this->id, '_wc_freshbooks_client_id' ) ) {

			return get_post_meta( $this->id, '_wc_freshbooks_client_id', true );
		}

		if ( $this->billing_email ) {

			// lookup in freshbooks by billing email
			$clients = $this->api()->get_clients_by_email( $this->billing_email );

			// note that FreshBooks allows multiple clients with the same email, but
			// the first one is chosen here for simplicity
			if ( ! empty( $clients[0] ) ) {
				return $clients[0]['client_id'];
			}
		}

		// no client found, create one and return the ID
		$client_id = $this->api()->create_client( $this );

		// save to user meta if registered customer
		if ( ! empty( $this->customer_user ) ) {

			update_user_meta( $this->customer_user, '_wc_freshbooks_client_id', $client_id );
		}

		$this->add_order_note( __( 'New FreshBooks client created.', WC_FreshBooks::TEXT_DOMAIN ) );

		return $client_id;
	}


	/**
	 * Applies the order total as a payment to the invoice
	 *
	 * @since 3.0
	 * @return bool true if the payment was successful, false otherwise
	 */
	public function apply_invoice_payment() {

		if ( ! $this->invoice_needs_payment() ) {

			return true;
		}

		try {

			$payment_id = $this->api()->create_payment( $this );

			update_post_meta( $this->id, '_wc_freshbooks_payment_id', $payment_id );

			// update status immediately as the payment webhook could be delayed
			update_post_meta( $this->id, '_wc_freshbooks_invoice_status', 'paid' );

			$this->add_order_note( __( 'FreshBooks payment applied.', WC_FreshBooks::TEXT_DOMAIN ) );

			return true;

		} catch ( SV_WC_API_Exception $e ) {

			wc_freshbooks()->log( sprintf( '%s - %s', $e->getCode(), $e->getMessage() ) );

			$this->add_order_note( sprintf( __( 'FreshBooks payment could not be applied (%s).', WC_FreshBooks::TEXT_DOMAIN ), $e->getMessage() ) );

			return false;
		}
	}


	/**
	 * Returns true if an invoice was created for this order
	 *
	 * @since 3.0
	 * @return bool true if invoice was created, false otherwise
	 */
	public function invoice_was_created() {

		return isset( $this->wc_freshbooks_invoice_id );
	}


	/**
	 * Returns true if an invoice was sent for this order
	 *
	 * @since 3.0
	 * @return bool true if invoice was sent, false otherwise
	 */
	public function invoice_was_sent() {

		if ( ! $this->invoice_was_created() ) {
			return false;
		}

		return ( $this->get_invoice_status() && 'draft' != $this->get_invoice_status() );
	}


	/**
	 * Returns true if an invoice needs payment
	 *
	 * @since 3.0
	 * @return bool true if invoice is not marked as paid, false otherwise
	 */
	public function invoice_needs_payment() {

		// orders without invoices cannot need payment
		if ( ! $this->invoice_was_created() ) {

			return false;
		}

		return ! in_array( $this->get_invoice_status(), array( 'paid', 'auto-paid', 'deleted' ) );
	}


	/**
	 * Helper method to improve the readibility of methods calling the API
	 *
	 * @since 3.0
	 * @return \WC_FreshBooks_API instance
	 */
	private function api() {

		return wc_freshbooks()->get_api();
	}


	/**
	 * Helper method to return valid FreshBooks invoice statuses
	 *
	 * @since 3.0
	 * @return array invoice statuses
	 */
	public static function get_invoice_statuses() {

		// note that 'deleted' is a custom status added by the plugin
		return array(
			'disputed',
			'draft',
			'sent',
			'viewed',
			'paid',
			'auto-paid',
			'retry',
			'deleted',
		);
	}


} // end \WC_FreshBooks_Order class
