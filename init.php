<?php
/**
* WooCommerce WhatsApp API
*
* @package           WooCommerce_WhatsApp_API
* @author            tochat.be
* @copyright         2021 tochat.be
* @license           GPL-2.0-or-later
*
* @wordpress-plugin
* Plugin Name:       WooCommerce WhatsApp API
* Plugin URI:        https://tochat.be/
* Description:       WooCommerce WhatsApp API for your customers base on order status. More information <a href="https://tochat.be">tochat.be</a>
* Version:           1.0.0
* Requires at least: 5.2
* Requires PHP:      5.6
* Author:            tochat.be
* Author URI:        https://tochat.be/
* Text Domain:       woo-whatsapp-api
* License:           GPL v2 or later
* Domain Path:       /languages/
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

defined( 'ABSPATH' ) || exit;

/**
 * Plugin file constant.
 *
 * @since 1.0.0
 */
define( 'TOCHATBE_WA_API_PLUGIN_FILE', __FILE__ );

/**
 * Plugin path constant.
 *
 * Get plugin root directory path with trailing slash.
 *
 * @since 1.0.0
 */
define( 'TOCHATBE_WA_API_PLUGIN_PATH', plugin_dir_path( TOCHATBE_WA_API_PLUGIN_FILE ) );

/**
 * Plugin URL constant.
 *
 * Get plugin URL with trailing slash.
 *
 * @since 1.0.0
 */
define( 'TOCHATBE_WA_API_PLUGIN_URL', plugin_dir_url( TOCHATBE_WA_API_PLUGIN_FILE ) );

/**
 * Plugin version.
 *
 * @since 1.0.0
 */
define( 'TOCHATBE_WA_API_PLUGIN_VER', '1.0.0' );

/**
 * Plugin activation hook.
 *
 * Runs with plugin activation hook.
 *
 * @since 1.0.0
 *
 * @return void
 */
function tochatbe_wa_api_plugin_activation() {
	require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/class-tochatbe-wa-api-install.php';
}

register_activation_hook( TOCHATBE_WA_API_PLUGIN_FILE, 'tochatbe_wa_api_plugin_activation' );

/**
 * Plugin deactivation hook.
 *
 * Runs with plugin deactivation hook.
 *
 * @since 1.0.0
 *
 * @return void
 */
function tochatbe_wa_api_plugin_deactivation() {

}

register_deactivation_hook( TOCHATBE_WA_API_PLUGIN_FILE, 'tochatbe_wa_api_plugin_deactivation' );

/**
 * Plugin initialization.
 *
 * Initialization plugin.
 *
 * @since 1.0.0
 *
 * @return void
 */
function tochatbe_wa_api_initialization() {
	require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/class-tochatbe-wa-api-init.php';
}

add_action( 'plugins_loaded', 'tochatbe_wa_api_initialization', 50 );
