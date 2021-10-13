<div class="wrap">
	<h1><?php esc_html_e( 'WooCommerce WhatsApp API', 'woo-whatsapp-api' ); ?></h1>

	<?php settings_errors(); ?>

	<?php
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';
	?>

	<hr>

	<!-- <nav class="nav-tab-wrapper wa-mt-4">
		<a href="?page=my-plugin" class="nav-tab nav-tab-active"></a>
		<a href="?page=my-plugin&tab=settings" class="nav-tab"></a>
	</nav> -->

	<div class="tab-content">

		<h3><?php esc_html_e( 'Settings', 'woo-whatsapp-api' ); ?></h3>

		<form id="tochatbe-wa-api-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
			<input type="hidden" name="action" value="tochatbe_wa_api_verify_api_key">
			<input type="hidden" name="redirect_to" value="<?php echo admin_url( 'admin.php?page=whats-api-notifications' ); ?>">

			<table class="form-table">
				<tbody>

					<tr>
						<th>
							<label><?php esc_html_e( 'API Key', 'woo-whatsapp-api' ); ?></label>
						</th>
						<td>
							<div style="display: flex;">
								<div>
									<input type="password" class="regular-text" name="tochatbe_wa_api_key" value="<?php echo esc_attr( get_option( 'tochatbe_wa_api_key' ) ); ?>">
									<p class="description"><?php esc_html_e( 'Enter your 360dialog.com API key.', 'woo-whatsapp-api' ); ?></p>
									<p id="tochatbe-wa-api-form-response"></p>
								</div>
								<div>
									<input type="submit" class="button button-primary" value="<?php echo esc_attr( 'Verify API Key', 'woo-whatsapp-api' ); ?>">
								</div>
							</div>
						</td>
					</tr>

				</tbody>
			</table>

		</form>

		<hr>

		<?php require_once TOCHATBE_WA_API_PLUGIN_PATH . 'includes/admin/views/html-template-settings.php'; ?>


	</div>

	<!-- Footer -->
	<div>
		<hr>

		<p class="alignright">Developed by <a href="https://tochat.be/" target="_blank"><?php esc_html_e( 'tochat.be', 'woo-whatsapp-api' ); ?></a></p>
	</div><!-- .Footer -->

</div>
