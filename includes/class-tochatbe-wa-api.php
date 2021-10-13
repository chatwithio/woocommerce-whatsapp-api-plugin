<?php
/**
 * Main API.
 *
 * @since 1.0.0
 *
 * @package WooCommerce_WhatsApp_API
 */

defined( 'ABSPATH' ) || exit;

/**
 * API class.
 *
 * @since 1.0.0
 */
class TOCHATBE_WA_API {

	/**
	 * Get WhatsApp number ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $whatsapp_number WhatsApp Number ID
	 *
	 * @return bool|string false. If not a WhatsApp registered number else, WhatsApp number ID.
	 */
	public static function get_whatsapp_number_id( $whatsapp_number ) {
		$response = self::get_response( 'contacts', 'post', array(
			'body' => array(
				'blocking' => 'wait',
				'contacts' => [
					$whatsapp_number
				],
				'force_check' => true,
			)
		) );

		if ( ! isset( $response['contacts'][0] ) ) {
			return false;
		}

		$contact_data = $response['contacts'][0];

		if ( 'valid' !== $contact_data['status'] ) {
			return false;
		}

		return $contact_data['wa_id'];
	}

	/**
	 * Get template list.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|array False, if invalid API key else, Template list.
	 */
	public static function get_template_list() {
		if ( ! self::get_api_key() ) {
			delete_transient( 'tochatbe_wa_api_get_templates_list' );

			return array();
		}

		$templates = get_transient( 'tochatbe_wa_api_get_templates_list' );

		if ( ! $templates ) {
			$templates = self::get_response( 'configs/templates' );
			$templates = isset( $templates['waba_templates'] ) ? $templates['waba_templates'] : array();

			foreach ( (array) $templates as $template_key => $template ) {
				$templates[ $template['name'] . '_' . $template['language'] ] = $template;

				unset( $templates[ $template_key ] );
			}

			set_transient( 'tochatbe_wa_api_get_templates_list', $templates, HOUR_IN_SECONDS );
		}

		return $templates;
	}

	/**
	 * Send template message.
	 *
	 * @since 1.0.0
	 *
	 * @param string $to   WhatsApp number without + sign.
	 * @param array  $args Send template arguments.
	 *
	 * @return void
	 */
	public static function send_template_message( $to, $args = array() ) {
		if ( ! $to ) {
			return;
		}

		$placeholders       = array();
		$template_name      = isset( $args['template']['name'] ) ? $args['template']['name'] : '';
		$template_namespace = isset( $args['template']['namespace'] ) ? $args['template']['namespace'] : '';
		$language_code      = isset( $args['template']['language'] ) ? $args['template']['language'] : '';

		if ( isset( $args['placeholders'] ) && ! empty( $args['placeholders'] ) ) {
			foreach ( $args['placeholders'] as $placeholder ) {
				$placeholders[] = array(
					'type' => 'text',
					'text' => sanitize_text_field( $placeholder  ),
				);
			}
		}

		$response = self::get_response( 'messages', 'post', array(
			'body' => array(
				"to" => $to,
				"type" => "template",
				"template" => array(
					"namespace" => $template_namespace,
					"language" => array(
						"policy" =>"deterministic",
						"code" => $language_code
					),
					"name" => $template_name,
					"components" => array(
						array(
							"type"       => "body",
							"parameters" => $placeholders
						)
					)
				)
			)
		) );
	}

	/**
	 * Get API key.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function get_api_key() {
		return get_option( 'tochatbe_wa_api_key' );
	}

	/**
	 * Get API responses.
	 *
	 * @since 1.0.0
	 *
	 * @param string $end_point   API end points.
	 * @param string $method_type API request type. post | get.
	 * @param array  $args        API arguments.
	 *
	 * @return bool|array
	 */
	protected static function get_response( $end_point, $method_type = 'get', $args = array() ) {
		if ( ! $end_point ) {
			return false;
		}

		$args['api_key'] = isset( $args['api_key'] ) ? $args['api_key'] : self::get_api_key();
		$args['body']    = isset( $args['body'] ) ? $args['body'] : array();

		$url         = "https://waba.360dialog.io/v1/{$end_point}";
		$remote_args = array(
			'timeout'     => 5,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(
				'Content-Type' => 'application/json',
				'D360-API-KEY' => sanitize_text_field( $args['api_key'] ),
			),
		);

		if ( is_array( $args['body'] ) && ! empty( $args['body'] ) ) {
			$remote_args['body'] = json_encode( (array) $args['body'] );
		}

		if ( 'post' === $method_type ) {
			$response = wp_remote_post( $url, $remote_args );
		} else {
			$response = wp_remote_get( $url, $remote_args );
		}

		// Host invalid error.
		if ( is_wp_error( $response ) ) {
			if ( isset( $response->errors['http_request_failed'][0] ) ) {
				tochatbe_wa_api_add_log( $response->errors['http_request_failed'][0] );
			}
			return false;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		// Invalid API key.
		if ( isset( $data['meta']['success'] ) && ! $data['meta']['success'] && 401 === $data['meta']['http_code'] ) {
			tochatbe_wa_api_add_log( 'Invalid api key' );

			return false;
		}

		// Invalid end point.
		if ( isset( $data['errors'][0] ) && ! empty( $data['errors'][0] && 1006 === $data['errors']['0']['code'] ) ) {
			$error_code    = $data['errors']['0']['code'];
			$error_details = $data['errors']['0']['details'];

			tochatbe_wa_api_add_log( "Error Code: {$error_code} | Error Details: {$error_details}" );

			return false;
		}

		return $data;
	}

	/**
	 * Check whether API key is valid or not.
	 *
	 * @since 1.0.0
	 *
	 * @param string $api_key API Key.
	 *
	 * @return boolean
	 */
	public static function is_valid_api_key( $api_key ) {
		$response = self::get_response( 'settings/profile/about', 'get', array(
			'api_key' => $api_key,
		) );

		return isset( $response['meta']['version'] ) ? true : false;
	}
}
