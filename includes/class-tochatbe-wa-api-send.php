<?php
/**
 * Send messages.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API
 */

defined( 'ABSPATH' ) || exit;


/**
 * Send messages class.
 *
 * @since 1.0.0
 */
class TOCHATBE_WA_API_Send {

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'woocommerce_order_status_changed', array( $this, 'send_message_with_change_order_status' ), 20, 4 );
	}

	public function send_message_with_change_order_status( $order_id, $old_status, $new_status, $order ) {
		// Get an instance of the WC_Order object
		$order = wc_get_order( $order_id );

		$order_phone = $order->get_billing_phone();

		$whatsapp_number = TOCHATBE_WA_API::get_whatsapp_number_id( $order_phone );

		if ( ! $whatsapp_number ) {
			tochatbe_wa_api_add_log( "Order ID: #{$order->ID} | Order Status: {$order->get_status()} | Message not sent! Invalid WhatsApp number {$order_phone}" );

			return;
		}

		$saved_templates = get_option( 'tochatbe_wa_api_templates', array() );

		foreach( $saved_templates as $order_status => $template ) {
			if ( $order_status !== $new_status ) {
				continue;
			}
			if ( ! isset( $template['template'] ) || empty( $template['template'] ) ) {
				continue;
			}

			TOCHATBE_WA_API::send_template_message( $whatsapp_number, [
				'template' => array(
					'name'      => $template['template_name'],
					'namespace' => $template['template_namespace'],
					'language'  => $template['language_code']
				),
				'placeholders' => tochatbe_wa_api_placeholders( $template['placeholder'], array(
					'{{order_id}}'                 => $order_id,
					'{{order_subtotal}}'           => $order->get_subtotal(),
					'{{order_total}}'              => $order->get_total(),
					'{{order_billing_first_name}}' => $order->get_billing_first_name(),
				) )
			] );
		}
	}

}

return new TOCHATBE_WA_API_Send();
