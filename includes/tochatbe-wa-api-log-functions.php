<?php
/**
 * Log Functions.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add logs.
 *
 * @since 1.0.0
 *
 * @param string $log_message Log message.
 *
 * @return void.
 */
function tochatbe_wa_api_add_log( $log_message ) {
	$unix_timestamp = current_time( 'U' );
	$logs           = get_option( 'tochatbe_wa_api_logs', array() );

	$logs[ $unix_timestamp ] = $log_message;

	update_option( 'tochatbe_wa_api_logs', $logs );
}

/**
 * Get logs.
 *
 * @since 1.0.0
 *
 * @return array.
 */
function tochatbe_wa_api_get_log() {
	$logs = get_option( 'tochatbe_wa_api_logs', array() );

	return $logs;
}

/**
 * Delete logs.
 *
 * @since 1.0.0
 *
 * @return void.
 */
function tochatbe_wa_api_delete_logs() {
	delete_option( 'tochatbe_wa_api_logs' );
}
