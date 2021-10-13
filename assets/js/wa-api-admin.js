( function( $ ) {
	'use strict';

	$( document ).ready( function() {

		/**
		 * Templates data.
		 *
		 * @since 1.0.0
		 */
		const TEMPLATES = tochatbeAdmin.get_template_list;

		/**
		 * Get placeholder count from message.
		 *
		 * @since 1.0.0
		 */
		function get_placeholders_count( message, status ) {
			var wrapperPlaceholder = $( '[data-placeholder-inputs="' + status + '"]' );
			var placeholderHtml    = '';

			function get_placholder_count_html( placeholder, status, key ) {
				var html  = '';

				html += '<tr>';
				html += '<th>{{' + placeholder + '}}</th>';
				html += '<td>';
				html += '<input type="text" name="tochatbe_wa_api_templates[' + status + '][placeholder][' + key + ']" required>';
				html += '</td>';
				html += '</tr>';

				return html;
			}

			if ( message.includes( '{{1}}' ) ) {
				placeholderHtml += get_placholder_count_html( '1', status, '1' );
			}
			if ( message.includes( '{{2}}' ) ) {
				placeholderHtml += get_placholder_count_html( '2', status, '2' );
			}
			if ( message.includes( '{{3}}' ) ) {
				placeholderHtml += get_placholder_count_html( '3', status, '3' );
			}
			if ( message.includes( '{{4}}' ) ) {
				placeholderHtml += get_placholder_count_html( '4', status, '4' );
			}
			if ( message.includes( '{{5}}' ) ) {
				placeholderHtml += get_placholder_count_html( '5', status, '5' );
			}
			if ( message.includes( '{{6}}' ) ) {
				placeholderHtml += get_placholder_count_html( '6', status, '6' );
			}
			if ( message.includes( '{{7}}' ) ) {
				placeholderHtml += get_placholder_count_html( '7', status, '7' );
			}
			if ( message.includes( '{{8}}' ) ) {
				placeholderHtml += get_placholder_count_html( '8', status, '8' );
			}
			if ( message.includes( '{{9}}' ) ) {
				placeholderHtml += get_placholder_count_html( '9', status, '9' );
			}
			if ( message.includes( '{{10}}' ) ) {
				placeholderHtml += get_placholder_count_html( '10', status, '10' );
			}
			if ( message.includes( '{{11}}' ) ) {
				placeholderHtml += get_placholder_count_html( '11', status, '11' );
			}
			if ( message.includes( '{{12}}' ) ) {
				placeholderHtml += get_placholder_count_html( '12', status, '12' );
			}
			if ( message.includes( '{{13}}' ) ) {
				placeholderHtml += get_placholder_count_html( '13', status, '13' );
			}
			if ( message.includes( '{{14}}' ) ) {
				placeholderHtml += get_placholder_count_html( '14', status, '14' );
			}
			if ( message.includes( '{{15}}' ) ) {
				placeholderHtml += get_placholder_count_html( '15', status, '15' );
			}

			wrapperPlaceholder.find( 'tr' ).remove();
			wrapperPlaceholder.append( placeholderHtml );
		}

		/**
		 * Template selector.
		 */
		$( '[data-template-selector]' ).on( 'change', function() {
			var templateID     = $( this ).val();
			var templateStatus = $( this ).attr( 'data-template-status' );

			if ( 'none' !== templateID ) {
				var tempalteData      = TEMPLATES[ templateID ];
				var tempalteName      = tempalteData.name;
				var tempalteNamespace = tempalteData.namespace;
				var tempalteLanguage  = tempalteData.language;

				$( tempalteData.components ).each( function( i, e ) {
					if ( 'BODY' === e.type ) {
						var templateMessage = tempalteData.components[i].text;

						get_placeholders_count( templateMessage, templateStatus );
					}
				} );

				$( '[name="tochatbe_wa_api_templates[' + templateStatus + '][template_name]"]' ).val( tempalteName );
				$( '[name="tochatbe_wa_api_templates[' + templateStatus + '][template_namespace]"]' ).val( tempalteNamespace );
				$( '[name="tochatbe_wa_api_templates[' + templateStatus + '][language_code]"]' ).val( tempalteLanguage );
			} else {
				$( '[name="tochatbe_wa_api_templates[' + templateStatus + '][template_name]"]' ).val( '' );
				$( '[name="tochatbe_wa_api_templates[' + templateStatus + '][template_namespace]"]' ).val( '' );
				$( '[name="tochatbe_wa_api_templates[' + templateStatus + '][language_code]"]' ).val( '' );

				get_placeholders_count( '', templateStatus );
			}
		} );

		/**
		 * Placeholder popup open.
		 */
		 $( '.tochatbe-wa-api-placeholder-popup-open' ).on( 'click', function( e ) {
			e.preventDefault();

			$( '.tochatbe-wa-api-placeholder-popup-overlay' ).show();
			$( '.tochatbe-wa-api-placeholder-popup' ).show();
		} );

		/**
		 * Placeholder popup close.
		 */
		$( '.tochatbe-wa-api-placeholder-popup-close, .tochatbe-wa-api-placeholder-popup-overlay' ).on( 'click', function() {
			$( '.tochatbe-wa-api-placeholder-popup-overlay' ).hide();
			$( '.tochatbe-wa-api-placeholder-popup' ).hide();
		} );

		/**
		 * Verify API key.
		 *
		 * @since 1.0.0
		 */
		$( '#tochatbe-wa-api-form' ).on( 'submit', function( e ) {
			e.preventDefault();

			if ( ! confirm( 'Changing the API key will remove your saved settings. Would you like to continue?' ) ) {
				return;
			};

			var $form = $( this );

			$form.find( '[type="submit"]' ).val( 'Verifying...' );
			$( '#tochatbe-wa-api-form-response p' ).remove();

			$( '[data-template-selector] option:not( [value="none"] )' ).remove();
			$( '[data-template-selector]' ).val( 'none' ).change();

			$.ajax( {
				url: $form.attr( 'action' ),
				type: $form.attr( 'method' ),
				dataType: 'json',
				data: $form.serialize(),
				success: function( r ) {
					if ( ! r.success ) {
						$( '#tochatbe-wa-api-form-response' ).append( '<p>' + r.message + '</p>' );
						$form.find( '[name="tochatbe_wa_api_key"]' ).val( '' );

						return;
					}

					$( '#tochatbe-wa-api-form-response' ).append( '<p>' + r.message + '</p>' );

					setTimeout( function() {
						window.location.href = r.redirect_to;
					}, 5000 );
				},
				complete: function() {
					$form.find( '[type="submit"]' ).val( 'Verify API Key' );
				}
			} );
		} );

	} ); // Doc.ready end.

} )( jQuery );
