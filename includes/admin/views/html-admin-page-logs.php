<div class="wrap">
	<h1><?php esc_html_e( 'WooCommerce WhatsApp API - Logs', 'woo-whatsapp-api' ); ?></h1>

	<?php settings_errors(); ?>

	<?php if ( tochatbe_wa_api_get_log() ) : ?>

		<div class="tochatbe-wa-api-log-list">

			<?php foreach ( tochatbe_wa_api_get_log() as $log_timestamp => $log ) : ?>

				<div class="tochatbe-wa-api-log-item">
					<p class="tochatbe-wa-api-log-timestamp"><?php echo date( 'Y-m-d H:i:s', $log_timestamp ); ?></p>
					<?php echo '<pre>' . print_r( $log, true ) . '</pre>'; ?>

				</div>

			<?php endforeach; ?>

		</div>

	<?php else : ?>

		<p><?php esc_html_e( 'No log found!', 'woo-whatsapp-api' ); ?></p>

	<?php endif; ?>

	<p>
		<a
			href="<?php echo wp_nonce_url( '?tochatbe_wa_api_delete_logs=true' ) ?>"
			class="button button-primary"
			onclick="return confirm( '<?php esc_html_e( 'Are you sure you want to delete all logs?', 'woo-whatsapp-api' ) ?>' );">
			<?php esc_html_e( 'Delete All Logs', 'woo-whatsapp-api' ); ?>
		</a>
	</p>

	<!-- Footer -->
	<div>
		<hr>

		<p class="alignright">Developed by <a href="https://tochat.be/" target="_blank"><?php esc_html_e( 'tochat.be', 'woo-whatsapp-api' ); ?></a></p>
	</div><!-- .Footer -->

</div>
