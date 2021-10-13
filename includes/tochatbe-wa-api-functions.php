<?php
/**
 * Functions file.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API
 */

defined( 'ABSPATH' ) || exit;

/**
 * Template name format.
 *
 * @since 1.0.0
 *
 * @param string $name
 * @return void
 */
function tochatebe_wa_api_template_name_format( $name ) {
	if ( ! $name ) {
		return;
	}

	return ucwords( str_replace( '_', ' ', $name ) );
}


function tochatbe_wa_api_template_dropdown( $args = array(), $echo = true ) {
	$html       = '';
	$templates  = TOCHATBE_WA_API::get_template_list();
	$name       = isset( $args['name'] ) ? $args['name'] : '';
	$value      = isset( $args['value'] ) ? $args['value'] : '';
	$attributes = array();

	// Custom attributes
	if ( isset( $args['attributes'] ) && ! empty( $args['attributes'] ) && is_array( $args['attributes'] ) ) {
		foreach ( $args['attributes'] as $attribute => $attribute_value ) {
			$attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
		}
	}

	$html .= '<select name="' . esc_attr( $name ) . '" ' . implode( ' ', $attributes ) . ' >';
	$html .= '<option value="none">None</option>';

	foreach ( $templates as $template_key => $template ) {
		$option = tochatebe_wa_api_template_name_format( $template['name'] ) . ' - ' . $template['language'];
		$html .= '<option value="' . $template_key . '" ' . selected( $template_key, $value, false ) . ' >' . esc_html( $option ) . '</option>';
	}

	$html .= '</select>';

	if ( $echo ) {
		return $html;
	}

	echo $html;
}

/**
 * Get WooCommerce  order statuses.
 *
 * @since 1.0.0
 *
 * @return array
 */
function tochatbe_wa_api_get_order_statuses() {
	$order_statuses = wc_get_order_statuses();

	foreach ( $order_statuses as $order_status_key => $order_status ) {
		if ( false !== strpos( $order_status_key, 'wc-' ) ) {
			$order_status_wihout_prefix                    = str_replace( 'wc-', '', $order_status_key );
			$order_statuses[ $order_status_wihout_prefix ] = $order_status;

			unset( $order_statuses[ $order_status_key ] );
		}
	}

	return $order_statuses;
}


function tochatbe_wa_api_placeholders( $placeholder_array, $args = array() ) {
	if ( ! $placeholder_array ) {
		return false;
	}

	$placeholder_mod_array = array();

	foreach ( $placeholder_array as $placeholder_id => $placeholder ) {
		if ( false !== strpos( $placeholder, '{{site_url}}' ) ) { // Site URL
			$placeholder_mod_array[ $placeholder_id ] = str_replace( '{{site_url}}', home_url(), $placeholder );
		} elseif ( false !== strpos( $placeholder, '{{order_id}}' ) && isset( $args['{{order_id}}'] ) ) { // Order ID
			$placeholder_mod_array[ $placeholder_id ] = str_replace( '{{order_id}}', $args['{{order_id}}'], $placeholder );
		} elseif ( false !== strpos( $placeholder, '{{order_billing_first_name}}' ) && isset( $args['{{order_billing_first_name}}'] ) ) { // Order Billing First Name
			$placeholder_mod_array[ $placeholder_id ] = str_replace( '{{order_billing_first_name}}', $args['{{order_billing_first_name}}'], $placeholder );
		} elseif ( false !== strpos( $placeholder, '{{order_subtotal}}' ) && isset( $args['{{order_subtotal}}'] ) ) { // Order ID
			$placeholder_mod_array[ $placeholder_id ] = str_replace( '{{order_subtotal}}', $args['{{order_subtotal}}'], $placeholder );
		} elseif ( false !== strpos( $placeholder, '{{order_total}}' ) && isset( $args['{{order_total}}'] ) ) { // Order ID
			$placeholder_mod_array[ $placeholder_id ] = str_replace( '{{order_total}}', $args['{{order_total}}'], $placeholder );
		} else {
			$placeholder_mod_array[ $placeholder_id ] = $placeholder;
		}
	}

	return $placeholder_mod_array;
}
