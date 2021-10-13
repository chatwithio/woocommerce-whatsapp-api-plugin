<?php
/**
 * Plugin uninstall.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API
 */

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

delete_option( 'tochatbe_wa_api_key' );
delete_option( 'tochatbe_wa_api_logs' );
