<?php
/**
 * Admin initialization.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API/Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Admin initialization class.
 *
 * @since 1.0.0
 */
class TOCHATBE_WA_API_Admin_Init {

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 120 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Admin menus.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_menu_page(
			esc_html__( 'WhatsApp API', 'woo-whatsapp-api' ),
			esc_html__( 'WhatsApp API', 'woo-whatsapp-api' ),
			'manage_options',
			'whats-api-notifications',
			array( $this, 'admin_page' ),
		);

		add_submenu_page(
			'whats-api-notifications',
			esc_html__( 'Logs', 'woo-whatsapp-api' ),
			esc_html__( 'Logs', 'woo-whatsapp-api' ),
			'manage_options',
			'whats-api-notifications_logs',
			array( $this, 'admin_page_logs' )
		);
	}

	/**
	 * Admin default page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_page() {
		require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/admin/views/html-admin-page.php';
	}

	/**
	 * Admin logs page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_page_logs() {
		require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/admin/views/html-admin-page-logs.php';
	}

	/**
	 * Admin enqueue scrips and styles.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook Admin current screen ID.
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook ) {
		if ( 'toplevel_page_whats-api-notifications' === $hook
		|| 'whats-api_page_whats-api-notifications_logs' === $hook ) {
			wp_enqueue_style( 'tochatbe-admin-style', TOCHATBE_WA_API_PLUGIN_URL . 'assets/css/wa-api-admin.css', array(), TOCHATBE_WA_API_PLUGIN_VER );
			wp_enqueue_script( 'tochatbe-admin-script', TOCHATBE_WA_API_PLUGIN_URL . 'assets/js/wa-api-admin.js', array( 'jquery' ), TOCHATBE_WA_API_PLUGIN_VER, true );
			wp_localize_script( 'tochatbe-admin-script', 'tochatbeAdmin', array(
				'get_template_list' => TOCHATBE_WA_API::get_template_list(),
			) );
		}
	}

}

return new TOCHATBE_WA_API_Admin_Init();
