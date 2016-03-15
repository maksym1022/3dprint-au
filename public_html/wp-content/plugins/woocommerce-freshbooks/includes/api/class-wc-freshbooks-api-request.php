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
 * @package   WC-FreshBooks/API/Request
 * @author    SkyVerge
 * @copyright Copyright (c) 2012-2015, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * FreshBooks API Request Class
 *
 * Generates XML to perform an API request
 *
 * @link http://developers.freshbooks.com/
 *
 * @since 3.0
 * @extends XMLWriter
 */
class WC_FreshBooks_API_Request extends XMLWriter implements SV_WC_API_Request {


	/** @var array request data prior to conversion to XML */
	private $request_data;

	/** @var string request xml */
	private $request_xml;

	/** @var \WC_FreshBooks_Order optional order object if this request was associated with an order */
	private $order;


	/**
	 * Construct request object
	 *
	 * @since 3.0
	 */
	public function __construct() {

		// Create XML document in memory
		$this->openMemory();

		// Set XML version & encoding
		$this->startDocument( '1.0', 'UTF-8' );
	}


	/** Invoice methods ******************************************************/


	/**
	 * Create an invoice for the given order
	 *
	 * @link http://developers.freshbooks.com/docs/invoices/#invoice.create
	 *
	 * @param \WC_FreshBooks_Order $order order instance
	 * @since 3.0
	 */
	public function create_invoice( WC_FreshBooks_Order $order ) {

		// store the order object for later use
		$this->order = $order;

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'invoice.create' ),
				'invoice'     => $this->get_invoice_data( $order ),
			),
		);

		// set invoice number to order number if enabled
		if ( 'yes' == get_option( 'wc_freshbooks_use_order_number' ) ) {

			$invoice_number = ltrim( $order->get_order_number(), _x( '#', 'hash before the order number', WC_FreshBooks::TEXT_DOMAIN ) );

			// add optional prefix
			$invoice_number =  get_option( 'wc_freshbooks_invoice_number_prefix' ) . $invoice_number;

			$this->request_data['request']['invoice']['number'] = $invoice_number;
		}
	}


	/**
	 * Update an invoice for the given order
	 *
	 * @link http://developers.freshbooks.com/docs/invoices/#invoice.update
	 *
	 * @param \WC_FreshBooks_Order $order order instance
	 * @since 3.2.0
	 */
	public function update_invoice( WC_FreshBooks_Order $order ) {

		// store the order object for later use
		$this->order = $order;

		// set base data
		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'invoice.update' ),
				'invoice'     => $this->get_invoice_data( $order ),
			),
		);

		// set required data
		$this->request_data['request']['invoice']['invoice_id'] = $order->invoice_id;
		$this->request_data['request']['invoice']['status'] = $order->get_invoice_status();
	}


	/**
	 * Get the invoice data for an order
	 *
	 * @param \WC_FreshBooks_Order $order order instance
	 * @return array invoice data
	 * @since 3.2.0
	 */
	private function get_invoice_data( WC_FreshBooks_Order $order ) {

		$invoice_data = array(
			'client_id'     => $order->invoice_client_id,
			'status'        => 'draft',
			'date'          => date( 'Y-m-d', strtotime( $order->order_date ) ),
			'currency_code' => $order->get_order_currency(),
			'language'      => get_option( 'wc_freshbooks_invoice_language', 'en' ),
			'first_name'    => $order->billing_first_name,
			'last_name'     => $order->billing_last_name,
			'organization'  => $order->billing_company,
			'p_street1'     => $order->billing_address_1,
			'p_street2'     => $order->billing_address_2,
			'p_city'        => $order->billing_city,
			'p_state'       => $order->billing_state,
			'p_country'     => $order->billing_country,
			'p_code'        => $order->billing_postcode,
			'lines'         => array( 'line' => $this->get_invoice_lines( $order ) ),
		);

		// set return URL to view order URL if registered customer
		$user_id = SV_WC_Plugin_Compatibility::get_order_user_id( $order );
		if ( ! empty( $user_id ) ) {

			$this->request_data['request']['invoice']['return_uri'] = $order->get_view_order_url();
		}

		// set VAT number if set for the order
		if ( metadata_exists( 'post', $order->id, 'VAT Number' ) ) {

			$this->request_data['request']['client']['vat_name']   = 'VAT Number';
			$this->request_data['request']['client']['vat_number'] = get_post_meta( $order->id, 'VAT Number', true );
		}

		return $invoice_data;
	}


	/**
	 * Get the invoice line items for a given order. This includes:
	 *
	 * + Products, mapped as FreshBooks items when the admin has linked them
	 * + Fees, mapped as a `Fee` item
	 * + Shipping, mapped as a `Shipping` item
	 * + Taxes, mapped using the tax code as the item
	 *
	 * Note that taxes cannot be added per-product as WooCommerce doesn't provide
	 * any way to get individual tax information per product and FreshBooks requires
	 * a tax name/percentage to be set on a per-product basis. Further, FreshBooks
	 * only allows 2 taxes per product where realistically most stores will have
	 * more
	 *
	 * @param \WC_FreshBooks_Order $order order instance
	 * @return array line items
	 * @since 3.0
	 */
	private function get_invoice_lines( WC_FreshBooks_Order $order ) {

		$line_items = array();

		// add products
		foreach ( $order->get_items() as $item_key => $item ) {

			$product = $order->get_product_from_item( $item );

			// must be a valid product
			if ( is_object( $product ) ) {

				$product_id = $product->is_type( 'variation' ) ? $product->variation_id : $product->id;

				$item_name = metadata_exists( 'post', $product_id, '_wc_freshbooks_item_name' ) ? get_post_meta( $product_id, '_wc_freshbooks_item_name', true ) : $product->get_sku();

				$item_meta = new WC_Order_Item_Meta( $item['item_meta'] );

				// variation data, item meta, etc
				$meta = $item_meta->display( true, true );

				// grouped products include a &arr; in the name which must be converted back to an arrow
				$item_description = html_entity_decode( $product->get_title(), ENT_QUOTES, 'UTF-8' ) . ( $meta ? sprintf( ' (%s)', $meta ) : '' );

			} else {

				$item_name = __( 'Product', WC_FreshBooks::TEXT_DOMAIN );

				$item_description = $item['name'];
			}

			$line_items[] = array(
				'name'        => $item_name,
				'description' => apply_filters( 'wc_freshbooks_line_item_description', $item_description, $item, $order, $item_key ), // legacy (pre 3.0) filter
				'unit_cost'   => $order->get_item_subtotal( $item ),
				'quantity'    => $item['qty'],
			);
		}

		$coupons = $order->get_items( 'coupon' );

		// add coupons
		foreach ( $coupons as $coupon_item ) {

			$coupon = new WC_Coupon( $coupon_item['name'] );

			$coupon_post = get_post( $coupon->id );

			$coupon_type = ( false !== strpos( $coupon->type, '_cart' ) ) ? __( 'Cart Discount', WC_FreshBooks::TEXT_DOMAIN ) : __( 'Product Discount', WC_FreshBooks::TEXT_DOMAIN );

			$line_items[] = array(
				'name'        => $coupon_item['name'],
				'description' => $coupon_post->post_excerpt ? sprintf( __( '%s - %s', WC_FreshBooks::TEXT_DOMAIN ), $coupon_type, $coupon_post->post_excerpt ) : $coupon_type,
				'unit_cost'   => wc_format_decimal( $coupon_item['discount_amount'] * - 1, 2 ),
				'quantity'    => 1,
			);
		}

		// manually created orders can't have coupon items, but may have an order discount set
		// which must be added as a line item
		if ( 0 == count( $coupons ) && $order->get_total_discount() > 0 ) {

			$line_items[] = array(
				'name'        => __( 'Order Discount', WC_FreshBooks::TEXT_DOMAIN ),
				'description' => __( 'Order Discount', WC_FreshBooks::TEXT_DOMAIN ),
				'unit_cost'   => wc_format_decimal( $order->get_total_discount() * -1, 2 ),
				'quantity'    => 1,
			);
		}

		// add fees
		foreach ( $order->get_fees() as $fee_key => $fee ) {

			$line_items[] = array(
				'name'        => __( 'Fee', WC_FreshBooks::TEXT_DOMAIN ),
				'description' => $fee['name'],
				'unit_cost'   => $order->get_line_total( $fee ),
				'quantity'    => 1,
			);
		}

		// add shipping
		foreach ( $order->get_shipping_methods() as $shipping_method_key => $shipping_method ) {

			$line_items[] = array(
				'name'        => __( 'Shipping', WC_FreshBooks::TEXT_DOMAIN ),
				'description' => ucwords( str_replace( '_', ' ', $shipping_method['method_id'] ) ),
				'unit_cost'   => $shipping_method['cost'],
				'quantity'    => 1,
			);
			$taxes_bonus = unserialize($shipping_method['taxes']);
			$tax_bonus = array_pop($taxes_bonus);
		}
		
		// add taxes
		foreach ( $order->get_tax_totals() as $tax_code => $tax ) {
			$taxes = array_pop($order->get_items( 'tax' ));
			if($taxes['shipping_tax_amount'] == 0){
				if(isset($tax_bonus) && is_numeric($tax_bonus)){
					$tax->amount += $tax_bonus;
				}
			}
			$line_items[] = array(
				'name'        => $tax_code,
				'description' => $tax->label,
				'unit_cost'   => number_Format( $tax->amount, 2, '.','' ),
				'quantity'    => 1,
			);
		}

		return $line_items;
	}


	/**
	 * Get the invoice for the given invoice ID
	 *
	 * @link http://developers.freshbooks.com/docs/invoices/#invoice.get
	 *
	 * @param string $invoice_id FreshBooks invoice ID (not the invoice number)
	 * @since 3.0
	 */
	public function get_invoice( $invoice_id ) {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'invoice.get' ),
				'invoice_id'  => $invoice_id,
			),
		);
	}


	/**
	 * Send the invoice for the given id and method
	 *
	 * @link http://developers.freshbooks.com/docs/invoices/#invoice.sendByEmail
	 * @link http://developers.freshbooks.com/docs/invoices/#invoice.sendBySnailMail
	 *
	 * @param string $invoice_id FreshBooks invoice ID (not the invoice number)
	 * @param string $method either `email` or `snail_mail`
	 * @since 3.0
	 */
	public function send_invoice( $invoice_id, $method ) {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'invoice.' . ( 'snail_mail' == $method ? 'sendBySnailMail' : 'sendByEmail' ) ),
				'invoice_id' => $invoice_id,
			),
		);
	}


	/** Client methods ******************************************************/


	/**
	 * Create an invoice for the given order
	 *
	 * @link http://developers.freshbooks.com/docs/clients/#client.create
	 *
	 * @param \WC_FreshBooks_Order $order order instance
	 * @since 3.0
	 */
	public function create_client( WC_FreshBooks_Order $order ) {

		// store the order object for later use
		$this->order = $order;

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'client.create' ),
				'client'      => array(
					'first_name'    => $order->billing_first_name,
					'last_name'     => $order->billing_last_name,
					'organization'  => $order->billing_company,
					'email'         => $order->billing_email,
					'work_phone'    => $order->billing_phone,
					'language'      => get_option( 'wc_freshbooks_invoice_language', 'en' ),
					'currency_code' => $order->get_order_currency(),
					'p_street1'     => $order->billing_address_1,
					'p_street2'     => $order->billing_address_2,
					'p_city'        => $order->billing_city,
					'p_state'       => $order->billing_state,
					'p_country'     => $order->billing_country,
					'p_code'        => $order->billing_postcode,
					's_street1'     => $order->shipping_address_1,
					's_street2'     => $order->shipping_address_2,
					's_city'        => $order->shipping_city,
					's_state'       => $order->shipping_state,
					's_country'     => $order->shipping_country,
					's_code'        => $order->shipping_postcode,
				),
			),
		);

		// set client username to WP username if registered customer
		$user_id = SV_WC_Plugin_Compatibility::get_order_user_id( $order );
		if ( ! empty( $user_id ) ) {

			$user = SV_WC_Plugin_Compatibility::get_order_user( $order );

			$this->request_data['request']['client']['username'] = $user->user_login;
		}

		// set VAT number if set for the order
		if ( metadata_exists( 'post', $order->id, 'VAT Number' ) ) {

			$this->request_data['request']['client']['vat_name']   = 'VAT Number';
			$this->request_data['request']['client']['vat_number'] = get_post_meta( $order->id, 'VAT Number', true );
		}
	}


	/**
	 * Get clients in DESC order by client_id
	 *
	 * Note that while FreshBooks supports pagination, it's not supported in
	 * this release so clients are limited to a maximum number of 100
	 *
	 * @link http://developers.freshbooks.com/docs/clients/#client.list
	 *
	 * @param string $status client status, either `active`, `archived` or `deleted`
	 * @param string $email optionally filter clients by email
	 * @since 3.0
	 */
	public function get_clients( $status, $email = null ) {

		// base request
		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'client.list' ),
				'per_page'    => 100,
				'folder'      => $status,
			),
		);

		// filter by email
		if ( $email ) {
			$this->request_data['request']['email'] = $email;
		}
	}


	/** Payment methods ******************************************************/


	/**
	 * Create a payment for the invoice
	 *
	 * @link http://developers.freshbooks.com/docs/payments/#payment.create
	 *
	 * @param \WC_FreshBooks_Order $order order instance
	 * @since 3.0
	 */
	public function create_payment( WC_FreshBooks_Order $order ) {

		// store the order object for later use
		$this->order = $order;

		// guess payment type
		switch ( $order->payment_method ) {

			case 'bacs':
				$type = 'Bank Transfer';
				break;
			case 'cheque':
				$type = 'Check';
				break;
			case 'cod':
				$type = 'Cash';
				break;
			case 'paypal':
				$type = 'PayPal';
				break;
			default:

				/**
				 * Filter the payment type
				 *
				 * @param string $type The Freshbooks payment type
				 * @param string $payment_method The WooCommerce payment method
				 * @since 3.3.3
				 */
				$type = apply_filters( 'wc_freshbooks_payment_type', '', $order->payment_method );
		}

		// base request
		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'payment.create' ),
				'payment'     => array(
					'invoice_id' => $order->wc_freshbooks_invoice_id,
					'date'       => date( 'Y-m-d', strtotime( isset( $order->paid_date ) ? $order->paid_date : $order->order_date ) ),
					'amount'     => number_format( $order->get_total(), 2, '.', '' ),
				),
			),
		);

		if ( ! empty( $type ) ) {

			$this->request_data['request']['payment']['type'] = $type;
		}
	}


	/**
	 * Get a single payment
	 *
	 * @link http://developers.freshbooks.com/docs/payments/#payment.get
	 *
	 * @param string $payment_id
	 * @since 3.0
	 */
	public function get_payment( $payment_id ) {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'payment.get' ),
				'payment_id'  => $payment_id,
			),
		);
	}


	/** Item methods ******************************************************/

	/**
	 * Get invoice items for the given status
	 *
	 * @link http://developers.freshbooks.com/docs/items/#item.list
	 *
	 * @param string $status either `active`, `archived`, or `deleted`
	 * @param int $page the page to request
	 * @since 3.0
	 */
	public function get_items( $status, $page = 1 ) {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'item.list' ),
				'per_page'    => 100,
				'page'        => $page,
				'folder'      => $status,
			),
		);
	}


	/** Webhook methods ******************************************************/


	/**
	 * Get webhooks, filtered to this site
	 *
	 * @link http://developers.freshbooks.com/docs/callbacks/#callback.list
	 *
	 * @since 3.1
	 */
	public function get_webhooks() {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'callback.list' ),
				'uri' => add_query_arg( array( 'wc-api' => 'WC_FreshBooks_Webhooks' ), home_url( '/' ) ),
			),
		);
	}


	/**
	 * Create a webhook
	 *
	 * @link http://developers.freshbooks.com/docs/callbacks/#callback.create
	 *
	 * @since 3.0
	 */
	public function create_webhook() {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'callback.create' ),
				'callback'    => array(
					'event' => 'all',
					'uri'   => add_query_arg( array( 'wc-api' => 'WC_FreshBooks_Webhooks' ), home_url( '/' ) ),
				),
			),
		);
	}


	/**
	 * Verify a created webhook
	 *
	 * @link http://developers.freshbooks.com/docs/callbacks/#callback.verify
	 *
	 * @param string $webhook_id created webhook ID
	 * @param string $verifier provided verifier received after webhook creation
	 * @since 3.0
	 */
	public function verify_webhook( $webhook_id, $verifier ) {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'callback.verify' ),
				'callback'    => array(
					'callback_id' => $webhook_id,
					'verifier'    => $verifier,
				),
			),
		);
	}


	/**
	 * Delete a webhook
	 *
	 * @link http://developers.freshbooks.com/docs/callbacks/#callback.delete
	 *
	 * @param string $webhook_id webhook ID
	 * @since 3.1
	 */
	public function delete_webhook( $webhook_id ) {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'callback.delete' ),
				'callback_id' => $webhook_id,
			),
		);
	}


	/** Misc methods ******************************************************/


	/**
	 * Get the languages for the FreshBooks account
	 *
	 * @link http://developers.freshbooks.com/docs/languages/#language.list
	 *
	 * @since 3.0
	 */
	public function get_languages() {

		$this->request_data = array(
			'request' => array(
				'@attributes' => array( 'method' => 'language.list' ),
				'per_page'   => 100,
			),
		);
	}



	/** XML Methods ******************************************************/


	/**
	 * Helper to return completed XML document
	 *
	 * @since 3.0
	 * @return string XML
	 */
	public function to_xml() {

		if ( ! empty( $this->request_xml ) ) {

			return $this->request_xml;
		}

		/**
		 * API Request Data
		 *
		 * Allow actors to modify the request data before it's sent to FreshBooks.
		 * Data like client/invoice contacts, notes, etc. can be added with this
		 * filter
		 *
		 * @since 3.0
		 * @param WC_FreshBooks_Order $order order instance
		 * @param \WC_FreshBooks_API_Request $this, API request class instance
		 */
		apply_filters( 'wc_freshbooks_api_request_data', $this->request_data, $this->order, $this );

		// generate XML from request data, recursively using the `request` root element
		$this->array_to_xml( 'request', $this->request_data['request'] );

		$this->endDocument();

		return $this->request_xml = $this->outputMemory();
	}


	/**
	 * Convert array into XML by recursively generating child elements
	 *
	 * @since 3.0
	 * @param string|array $element_key name for element, e.g. <per_page>
	 * @param string|array $element_value value for element, e.g. 100
	 * @return string generated XML
	 */
	private function array_to_xml( $element_key, $element_value = array() ) {

		if ( is_array( $element_value ) ) {

			// handle attributes
			if ( '@attributes' === $element_key ) {
				foreach ( $element_value as $attribute_key => $attribute_value ) {

					$this->startAttribute( $attribute_key );
					$this->text( $attribute_value );
					$this->endAttribute();
				}
				return;
			}

			// handle multi-elements (e.g. multiple <Order> elements)
			if ( is_numeric( key( $element_value ) ) ) {

				// recursively generate child elements
				foreach ( $element_value as $child_element_key => $child_element_value ) {

					$this->startElement( $element_key );

					foreach ( $child_element_value as $sibling_element_key => $sibling_element_value ) {
						$this->array_to_xml( $sibling_element_key, $sibling_element_value );
					}

					$this->endElement();
				}

			} else {

				// start root element
				$this->startElement( $element_key );

				// recursively generate child elements
				foreach ( $element_value as $child_element_key => $child_element_value ) {
					$this->array_to_xml( $child_element_key, $child_element_value );
				}

				// end root element
				$this->endElement();
			}

		} else {

			// handle single elements
			if ( '@value' == $element_key ) {

				$this->text( $element_value );

			} else {

				// wrap element in CDATA tags if it contains illegal characters
				if ( false !== strpos( $element_value, '<' ) || false !== strpos( $element_value, '>' ) ) {

					$this->startElement( $element_key );
					$this->writeCdata( $element_value );
					$this->endElement();

				} else {

					$this->writeElement( $element_key, $element_value );
				}

			}

			return;
		}
	}


	/** Helper Methods ******************************************************/


	/**
	 * Returns the string representation of this request
	 *
	 * @since 3.0
	 * @return string request XML
	 */
	public function to_string() {

		return $this->to_xml();
	}


	/**
	 * Returns the string representation of this request with any and all
	 * sensitive elements masked or removed
	 *
	 * @since 3.2.0
	 * @see SV_WC_API_Request::to_string_safe()
	 * @return string the request XML, safe for logging/displaying
	 */
	public function to_string_safe() {

		$request = $this->to_xml();

		$dom = new DOMDocument();

		// suppress errors for invalid XML syntax issues
		if ( @$dom->loadXML( $request ) ) {
			$dom->formatOutput = true;
			$request = $dom->saveXML();
		}

		return $request;
	}


	/**
	 * Returns the order associated with this request, if there was one
	 *
	 * @since 3.0
	 * @return \WC_FreshBooks_Order order object
	 */
	public function get_order() {

		return $this->order;
	}


}
