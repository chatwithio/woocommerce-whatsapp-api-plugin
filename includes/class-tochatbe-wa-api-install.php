<?php
/**
 * Plugin install.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API
 */

defined( 'ABSPATH' ) || exit;


/**
 * Plugin install class.
 *
 * @since 1.0.0
 */
class TOCHATBE_WA_API_Install {

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {


	}

	public function add_options() {
		add_option( 'tochatbe_wa_api_key', '' );
		add_option( 'tochatbe_wa_api_templates', array() );
	}

}

return new TOCHATBE_WA_API_Install();
