<?php
	$saved_templates = get_option( 'tochatbe_wa_api_templates' );
?>

<form action="#" method="post">

	<div class="tochatbe-wa-api-templates">

		<?php foreach ( tochatbe_wa_api_get_order_statuses() as $order_status => $order_status_name ) : ?>
			<?php
				$template_name      = isset( $saved_templates[ $order_status ]['template_name'] ) ? $saved_templates[ $order_status ]['template_name'] : '';
				$template_namespace = isset( $saved_templates[ $order_status ]['template_namespace'] ) ? $saved_templates[ $order_status ]['template_namespace'] : '';
				$language_code      = isset( $saved_templates[ $order_status ]['language_code'] ) ? $saved_templates[ $order_status ]['language_code'] : '';
				$placeholders       = isset( $saved_templates[ $order_status ]['placeholder'] ) ? $saved_templates[ $order_status ]['placeholder'] : array();
				$value              = $template_name . '_' . $language_code;
			?>
			<div class="tochatbe-wa-api-template">
				<h3 class="tochatbe-wa-api-template__status">Order Status: <span class=""><?php echo esc_html( $order_status_name ); ?></span></h3>

				<div>
					<span>Select Template:</span>
					<?php
						$args = array(
							'attributes' => array(
								'data-template-selector' => '0',
								'data-template-status'   => $order_status,
							),
							'name'      => 'tochatbe_wa_api_templates[' . esc_attr( $order_status ) . '][template]',
							'value'     => $value
						);

						echo tochatbe_wa_api_template_dropdown( $args );
					?>
				</div>

				<table class="tochatbe-wa-api-template-placeholders" data-placeholder-inputs="<?php echo esc_attr( $order_status ); ?>">
					<tbody>

						<?php foreach ( $placeholders as $placeholder_key => $placeholder ) : ?>
							<?php if ( empty( $placeholder ) ) continue; ?>
						<tr>
							<th>{{<?php echo $placeholder_key; ?>}}</th>
							<td>
								<input
									type="text"
									name="tochatbe_wa_api_templates[<?php echo esc_attr( $order_status ); ?>][placeholder][<?php echo $placeholder_key; ?>]"
									value="<?php echo $placeholder; ?>">
							</td>
						</tr>

						<?php endforeach; ?>

					</tbody>
					<tfoot>
						<tr>
							<td colspan="2">
								<a href="#" class="tochatbe-wa-api-placeholder-popup-open">Click here</a> to know about the placeholders.
							</td>
						</tr>
					</tfoot>
				</table>

				<div class="tochatbe-wa-api-template__inputs">
					<div class="tochatbe-wa-api-template__inputs-col1">
						<p>Template Name:</p>
						<input
							type="text"
							name="tochatbe_wa_api_templates[<?php echo esc_attr( $order_status ); ?>][template_name]"
							value="<?php echo esc_attr( $template_name ); ?>"
							readonly>
					</div>
					<div class="tochatbe-wa-api-template__inputs-col2">
						<p>Template Namespace:</p>
						<input
							type="text"
							name="tochatbe_wa_api_templates[<?php echo esc_attr( $order_status ); ?>][template_namespace]"
							value="<?php echo esc_attr( $template_namespace ); ?>"
							readonly>
					</div>
					<div class="tochatbe-wa-api-template__inputs-col2">
						<p>Language Code:</p>
						<input
							type="text"
							name="tochatbe_wa_api_templates[<?php echo esc_attr( $order_status ); ?>][language_code]"
							value="<?php echo esc_attr( $language_code ); ?>"
							readonly>
					</div>
				</div>
			</div>

		<?php endforeach; ?>

		<input type="submit" name="tochatbe_wa_api_submit" class="button button-primary" value="Save Changes">

	</div>

</form>

<div class="tochatbe-wa-api-placeholder-popup-overlay"></div>
<div class="tochatbe-wa-api-placeholder-popup">
	<svg xmlns="http://www.w3.org/2000/svg" class="tochatbe-wa-api-placeholder-popup-close" fill="none" viewBox="0 0 24 24" stroke="currentColor">
		<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
	</svg>

	<h3>Placeholders</h3>

	<table class="tochatbe-wa-api-placeholder-table">
		<tr>
			<th>Site URL</th>
			<td>Get site URL.</td>
			<td><code>{{site_url}}</code></td>
		</tr>
		<tr>
			<th>Order ID</th>
			<td>Get order ID.</td>
			<td><code>{{order_id}}</code></td>
		</tr>
		<tr>
			<th>Order Total</th>
			<td>Get order total.</td>
			<td><code>{{order_total}}</code></td>
		</tr>
		<tr>
			<th>Order Subtotal</th>
			<td>Get order subtotal.</td>
			<td><code>{{order_subtotal}}</code></td>
		</tr>
		<tr>
			<th>Order Billing First Name</th>
			<td>Get order billing first name.</td>
			<td><code>{{order_billing_first_name}}</code></td>
		</tr>
	</table>
</div>
