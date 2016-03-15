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
 * @package   WC-FreshBooks/Admin/Products
 * @author    SkyVerge
 * @copyright Copyright (c) 2012-2015, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * FreshBooks Product Admin class
 *
 * Handles customizations to the Product edit screen
 *
 * @since 3.0
 */
class WC_FreshBooks_Products_Admin {


	/**
	 * Add various admin hooks/filters
	 *
	 * @since 3.0
	 */
	public function __construct() {

		// add FreshBooks item mapping for simple products
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_simple_product_item_mapping' ) );

		// save FreshBooks item mapping for simple products
		add_action( 'woocommerce_process_product_meta', array( $this, 'process_simple_product_item_mapping' ) );

		// TODO: grouped product support?

		// add FreshBooks item mapping for individual variations
		add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'add_variable_product_item_mapping' ), 1, 3 );

		// add FreshBooks item mapping for individual variations
		add_action( 'woocommerce_save_product_variation', array( $this, 'process_variable_product_item_mapping' ) );

		// Add JS to bulk change variation item mapping
		add_action( 'woocommerce_product_write_panels', array( $this, 'add_variable_product_item_mapping_js' ) );
	}


	/**
	 * Add 'FreshBooks Item' select on 'General' tab of simple product write-panel
	 *
	 * @since 3.0
	 */
	public function add_simple_product_item_mapping() {
		global $post;

		$saved_item_id = get_post_meta( $post->ID, '_wc_freshbooks_item_name', true );

		?>
			<div class="options_group wc_freshbooks show_if_simple show_if_external">
				<p class="form-field wc_freshbooks_item_name_field">
					<label for="wc_freshbooks_item_name"><?php _e( 'FreshBooks Item', WC_FreshBooks::TEXT_DOMAIN ); ?></label>
					<select id="wc_freshbooks_item_name" name="wc_freshbooks_item_name">
						<option value="none"><?php esc_html_e( 'None', WC_FreshBooks::TEXT_DOMAIN ); ?></option>
						<?php
							foreach ( $this->get_active_items() as $item_id => $item_name ) :
								printf( '<option value="%s" %s>%s</option>', esc_attr( $item_id ), selected( $item_id, $saved_item_id, false ), esc_html( $item_name ) );
							endforeach;
						?>
					</select>
					<img class="help_tip" data-tip="<?php _e( 'Choose which FreshBooks item to link to this product.', WC_FreshBooks::TEXT_DOMAIN ); ?>" width="16" height="16" src="<?php echo WC()->plugin_url() . '/assets/images/help.png'; ?>" />
				</p>
			</div>
		<?php
	}


	/**
	 * Save 'FreshBooks Item' select box on 'General' tab of simple product write-panel
	 *
	 * @since 3.0
	 * @param int $post_id post ID of product being saved
	 */
	public function process_simple_product_item_mapping( $post_id ) {

		if ( isset( $_POST[ 'wc_freshbooks_item_name' ] ) ) {

			if ( 'none' == $_POST[ 'wc_freshbooks_item_name' ] ) {
				delete_post_meta( $post_id, '_wc_freshbooks_item_name' );
			} else {
				update_post_meta( $post_id, '_wc_freshbooks_item_name', $_POST[ 'wc_freshbooks_item_name' ] );
			}
		}
	}


	/**
	 * Add 'FreshBooks Item' select box on 'Variations' tab of variable product write-panel
	 *
	 * @since 3.0
	 * @param int $loop_count current variation count
	 * @param array $variation_data individual variation data
	 */
	public function add_variable_product_item_mapping( $loop_count, $variation_data, $variation ) {

		// WooCommerce 2.3 removed meta data from the $variation_data array, let's add it back
		if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_2_3() ) {
			$variation_data = array_merge( get_post_meta( $variation->ID ), $variation_data );
		}

		$saved_item_id = ( isset( $variation_data[ '_wc_freshbooks_item_name' ][0] ) ? $variation_data[ '_wc_freshbooks_item_name' ][0] : '' );

		if ( SV_WC_Plugin_Compatibility::is_wc_version_gte_2_3() ): ?>
			<div class="clearfix">
				<p class="form-row form-row-first">
					<label for="<?php echo esc_attr( 'wc_freshbooks_item_name_' . $loop_count ); ?>"><?php esc_html_e( 'FreshBooks Item', WC_FreshBooks::TEXT_DOMAIN ); ?>
						<a class="tips" data-tip="<?php esc_attr_e( 'Choose which FreshBooks item to link to this product.', WC_FreshBooks::TEXT_DOMAIN ); ?>" href="#">[?]</a>
					</label>
					<select id="<?php echo esc_attr( 'wc_freshbooks_item_name_' . $loop_count ); ?>" name="<?php printf( '%s[%s]', 'variable_wc_freshbooks_item_name', $loop_count ); ?>" class="js-wc-freshbooks-item-select" style="min-width: 250px;">
						<option value="none"><?php esc_html_e( 'None', WC_FreshBooks::TEXT_DOMAIN ); ?></option>
						<?php
						foreach ( $this->get_active_items() as $item_id => $item_name ) :
							printf( '<option value="%s" %s>%s</option>', esc_attr( $item_id ), selected( $item_id, $saved_item_id, false ), esc_html( $item_name ) );
						endforeach;
						?>
					</select>
				</p>
				<p class="form-row form-row-last" style="margin-top: 2.8em;"><a id="<?php echo 'wc_freshbooks_item_name_' . $loop_count; ?>" class="js-wc-freshbooks-bulk-set-items" href="#"><?php esc_html_e( 'Set all other variations to this item', WC_FreshBooks::TEXT_DOMAIN ); ?></a></p>
			</div>
		<?php else : ?>
			<tr>
				<td>
					<label for="<?php echo esc_attr( 'wc_freshbooks_item_name_' . $loop_count ); ?>"><?php esc_html_e( 'FreshBooks Item', WC_FreshBooks::TEXT_DOMAIN ); ?>
						<a class="tips" data-tip="<?php esc_attr_e( 'Choose which FreshBooks item to link to this product.', WC_FreshBooks::TEXT_DOMAIN ); ?>" href="#">[?]</a>
					</label>
					<select id="<?php echo esc_attr( 'wc_freshbooks_item_name_' . $loop_count ); ?>" name="<?php printf( '%s[%s]', 'variable_wc_freshbooks_item_name', $loop_count ); ?>" class="js-wc-freshbooks-item-select" style="min-width: 250px;">
						<option value="none"><?php esc_html_e( 'None', WC_FreshBooks::TEXT_DOMAIN ); ?></option>
						<?php
						foreach ( $this->get_active_items() as $item_id => $item_name ) :
							printf( '<option value="%s" %s>%s</option>', esc_attr( $item_id ), selected( $item_id, $saved_item_id, false ), esc_html( $item_name ) );
						endforeach;
						?>
					</select>
				</td>
				<td style="vertical-align: bottom; padding-bottom: 1em;"><a id="<?php echo 'wc_freshbooks_item_name_' . $loop_count; ?>" class="js-wc-freshbooks-bulk-set-items" href="#"><?php esc_html_e( 'Set all other variations to this item', WC_FreshBooks::TEXT_DOMAIN ); ?></a></td>
			</tr>
		<?php endif;
	}


	/**
	 * Add 'Set all other variations to this item' javascript
	 *
	 * @since 3.0
	 */
	public function add_variable_product_item_mapping_js() {

		wc_enqueue_js( '
			$( ".js-wc-freshbooks-bulk-set-items" ).click( function() {
				var selector = $( this ).attr( "id" );
				$( ".js-wc-freshbooks-item-select" ).val( $( "#" + selector ).val() );
				return false;
			} );
		' );
	}


	/**
	 * Save items mapped to product variations
	 *
	 * @since 3.0
	 */
	public function process_variable_product_item_mapping( $variation_id ) {

		// find the index for the given variation ID and save the associated item ID
		if ( false !== ( $i = array_search( $variation_id, $_POST['variable_post_id'] ) ) ) {

			if ( isset( $_POST['variable_wc_freshbooks_item_name'] ) && 'none' !== $_POST['variable_wc_freshbooks_item_name'][ $i ] ) {
				update_post_meta( $variation_id, '_wc_freshbooks_item_name', $_POST['variable_wc_freshbooks_item_name'][ $i ] );
			}
		}
	}


	/**
	 * Return an array of active invoice items
	 *
	 * @since 3.0
	 * @return array
	 */
	private function get_active_items() {

		$active_items = array();

		try {

			foreach ( wc_freshbooks()->get_api()->get_active_items() as $item ) {

				$active_items[ $item['name'] ] = $item['name'];
			}

		} catch ( SV_WC_API_Exception $e ) {

			wc_freshbooks()->log( $e->getMessage() );
		}

		return $active_items;
	}


} // end \WC_FreshBooks_Products_Admin class
