<?php
/**
 * Plugin initialization.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API
 */

defined( 'ABSPATH' ) || exit;

/**
 * Initialization class.
 *
 * @since 1.0.0
 */
final class TOCHATBE_WA_API_Init {

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->load_files();
	}

	/**
	 * Load files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_files() {
		require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/tochatbe-wa-api-log-functions.php';
		require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/tochatbe-wa-api-functions.php';
		require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/class-tochatbe-wa-api.php';

		if ( is_admin() ) {
			require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/admin/class-tochatbe-wa-api-admin-init.php';
			require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/admin/class-tochatbe-wa-api-admin-settings.php';
		}

		if ( TOCHATBE_WA_API::get_api_key() ) {
			require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/class-tochatbe-wa-api-send.php';
		}
	}
}

return new TOCHATBE_WA_API_Init();
