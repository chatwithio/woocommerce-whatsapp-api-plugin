<?php
/**
 * Admin settings.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API/Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin setting class.
 *
 * @since 1.0.0
 */
class TOCHATBE_WA_API_Admin_Settings {

	/**
	* Class constructor.
	*
	* @since 1.0.0
	*/
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_init', array( $this, 'save_templates' ) );
		add_action( 'admin_init', array( $this, 'delete_all_logs' ) );

		add_action( 'wp_ajax_tochatbe_wa_api_verify_api_key', array( $this, 'verify_api_key' ) );
		add_action( 'wp_ajax_nopriv_tochatbe_wa_api_verify_api_key', array( $this, 'verify_api_key' ) );
	}

	/**
	 * Register plugin settings.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_settings() {
		register_setting( 'tochabe_wa_api_settings_group', 'tochatbe_wa_api_key', 'sanitize_text_field' );
	}

	/**
	 * Save templates.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function save_templates() {
		if ( ! isset( $_POST['tochatbe_wa_api_templates'] ) ) {
			return;
		}

		update_option( 'tochatbe_wa_api_templates', $_POST['tochatbe_wa_api_templates'] );

		wp_redirect( admin_url( '/admin.php?page=whats-api-notifications' ) );
		exit;
	}

	/**
	 * Delete all logs,
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function delete_all_logs() {
		if ( ! isset( $_GET['tochatbe_wa_api_delete_logs'] ) || ! wp_verify_nonce( $_GET['_wpnonce'] ) ) {
			return;
		}

		delete_option( 'tochatbe_wa_api_logs' );

		wp_safe_redirect( wp_get_referer() );
		exit;
	}

	/**
	 * Verify API key.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function verify_api_key() {
		$api_key      = isset( $_POST['tochatbe_wa_api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['tochatbe_wa_api_key'] ) ) : '';
		$redirect_to  = isset( $_POST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ) : '';
		$response     = TOCHATBE_WA_API::is_valid_api_key( $api_key );

		if ( ! $response ) {
			update_option( 'tochatbe_wa_api_key', '' );

			wp_die( wp_json_encode( array(
				'success' => false,
				'message' => 'Invalid API Key.',
			) ) );
		}

		update_option( 'tochatbe_wa_api_key', $api_key );
		update_option( 'tochatbe_wa_api_templates', '' );

		wp_die( wp_json_encode( array(
			'success'     => true,
			'message'     => 'API key has been saved successfully. This page will automatically refresh in 5 seconds.',
			'redirect_to' => $redirect_to,
		) ) );
	}

}

return new TOCHATBE_WA_API_Admin_Settings();
