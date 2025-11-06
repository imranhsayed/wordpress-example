<?php
/**
 * WooCommerce cart integration for Gravity Forms
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme\Customizations\GravityForms;

use OneNovanta\Traits\Singleton;

/**
 * WooCommerce Cart integration for Gravity Forms
 */
class WooCommerceCartFieldMapper {

	/**
	 * Use the Singleton trait.
	 */
	use Singleton;

	/**
	 * Constructor
	 */
	public function __construct() {
		// Register hooks.
		$this->register_hooks();
	}

	/**
	 * Register necessary hooks.
	 *
	 * @return void
	 */
	protected function register_hooks(): void {
		// Add form settings for cart management.
		add_filter( 'gform_form_settings_fields', array( $this, 'add_cart_management_settings' ), 10, 2 );

		// Add AJAX handler for getting cart contents.
		add_action( 'wp_ajax_get_wc_cart_contents', array( $this, 'ajax_get_cart_contents' ) );
		add_action( 'wp_ajax_nopriv_get_wc_cart_contents', array( $this, 'ajax_get_cart_contents' ) );

		// Register scripts for forms with cart management enabled.
		add_action( 'gform_enqueue_scripts', array( $this, 'maybe_enqueue_scripts' ), 10, 1 );

		// Pre-populate fields with cart contents.
		add_filter( 'gform_pre_render', array( $this, 'populate_cart_fields' ), 10, 1 );
	}

	/**
	 * Add cart management settings to form settings.
	 *
	 * @param array<string, mixed> $fields The form settings fields.
	 * @param array<string, mixed> $form The form object.
	 * @return array<string, mixed> Modified form settings fields.
	 */
	public function add_cart_management_settings( array $fields, array $form ): array {
		$fields['cart_management'] = array(
			'title'  => 'WooCommerce Cart Integration',
			'fields' => array(
				array(
					'name'    => 'enable_cart_management',
					'label'   => 'Enable Cart Management',
					'type'    => 'checkbox',
					'choices' => array(
						array(
							'label' => 'Enable WooCommerce Cart integration for this form',
							'name'  => 'enable_cart_management',
						),
					),
					'tooltip' => 'When enabled, selected fields will be populated with WooCommerce cart data.',
				),
				array(
					'name'        => 'woocommerce_cart_mappings',
					'label'       => 'Cart Field Mappings',
					'type'        => 'generic_map',
					'dependency'  => array(
						'live'   => true,
						'fields' => array(
							array(
								'field'  => 'enable_cart_management',
								'values' => array( '1' ),
							),
						),
					),
					'key_field'   => array(
						'title'       => 'Form Field',
						'choices'     => $this->get_form_fields_as_choices( $form ),
						'placeholder' => 'Select a field',
					),
					'value_field' => array(
						'title'       => 'Format Template',
                        // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment -- Not needed for this field.
						'placeholder' => 'Example: %get_sku% (%quantity%)',
						/* translators: %1$s: get_name property, %2$s: get_sku property, %3$s: get_price property, %4$s: get_meta property. */
						'tooltip'     => 'Use %property% format to include WC_Product properties. Common properties: %1$s, %2$s, %3$s, %quantity%, %4$s',
					),
					'tooltip'     => 'Map form fields to WooCommerce cart data using format templates',
					'limit'       => 0,
				),
				array(
					'name'       => 'woocommerce_cart_help',
					'type'       => 'html',
					'html'       => '<p class="description">' .
							'Format template supports WooCommerce product properties using %property% syntax. Examples:' .
							'</p>' .
							'<ul class="description">' .
							'<li><code>%get_name% (%quantity%)</code> - Product name with quantity</li>' .
							'<li><code>%get_sku% (%quantity%)</code> - Product SKU with quantity</li>' .
							'<li><code>%get_meta(product_number)%</code> - Custom meta field value</li>' .
							'</ul>' .
							'<p class="description">' .
							'For multiple cart items, values will be joined with commas.' .
							'</p>',
					'dependency' => array(
						'live'   => true,
						'fields' => array(
							array(
								'field'  => 'enable_cart_management',
								'values' => array( '1' ),
							),
						),
					),
				),
			),
		);

		return $fields;
	}

	/**
	 * Get form fields as choices for the mapping.
	 *
	 * @param array<string, mixed> $form The form object.
	 * @return array<int, array<string, mixed>> Array of field choices.
	 */
	protected function get_form_fields_as_choices( array $form ): array {
		$choices = array();

		if ( ! empty( $form['fields'] ) ) {
			foreach ( $form['fields'] as $field ) {
				// Only include hidden and text fields.
				if ( in_array( $field->type, array( 'hidden', 'text' ), true ) ) {
					$choices[] = array(
						'value' => $field->id,
						'label' => $field->label ? $field->label : 'Field #' . $field->id . ' (' . $field->type . ')',
					);
				}
			}
		}

		return $choices;
	}

	/**
	 * Populate form fields with cart contents based on mappings.
	 *
	 * @param array<string, mixed> $form The form object.
	 * @return array<string, mixed> Modified form object.
	 */
	public function populate_cart_fields( array $form ): array {
		// Check if cart management is enabled for this form.
		if ( empty( $form['enable_cart_management'] ) ) {
			return $form;
		}

		// Check if we have mappings.
		if ( empty( $form['woocommerce_cart_mappings'] ) || ! is_array( $form['woocommerce_cart_mappings'] ) ) {
			return $form;
		}

		// Get cart data.
		$cart_data = $this->get_cart_data();
		if ( empty( $cart_data ) ) {
			return $form;
		}

		// Loop through each mapping and populate field values.
		foreach ( $form['woocommerce_cart_mappings'] as $mapping ) {
			if ( empty( $mapping['key'] ) || empty( $mapping['custom_value'] ) ) {
				continue;
			}

			$field_id        = $mapping['key'];
			$format_template = $mapping['custom_value'];

			// Find the field and set its default value.
			foreach ( $form['fields'] as &$field ) {
				if ( $field->id === (int) $field_id ) {
                    // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- defaultValue is a valid property for input fields.
					$field->defaultValue = $this->format_cart_items( $cart_data, $format_template );
					break;
				}
			}
		}

		return $form;
	}

	/**
	 * Format cart items according to the provided template.
	 *
	 * @param array<string, array<string, mixed>> $cart_data WooCommerce cart data.
	 * @param string                              $template Format template with %property% placeholders.
	 * @return string Formatted cart items string.
	 */
	protected function format_cart_items( array $cart_data, string $template ): string {
		$formatted_items = array();

		foreach ( $cart_data as $item ) {
			$product  = $item['data'];
			$quantity = $item['quantity'];

			if ( ! $product ) {
				continue;
			}

			$formatted_item = $template;

			// Replace product property placeholders.
			preg_match_all( '/%([^%]+)%/', $formatted_item, $matches );

			foreach ( $matches[1] as $property ) {
				// Handle get_meta() function calls.
				if ( 0 === strpos( $property, 'get_meta(' ) ) {
					$meta_key    = trim( str_replace( array( 'get_meta(', ')' ), '', $property ) );
					$replacement = $product->get_meta( $meta_key );
				} elseif ( 'quantity' === $property ) {
					// Handle quantity special case.
					$replacement = $quantity;
				} elseif ( method_exists( $product, $property ) ) {
					// Handle other product methods.
					$method_name = $property;
					$replacement = $product->$method_name();
				} else {
					$replacement = '';
				}

				// Convert array or object to string if needed.
				if ( is_array( $replacement ) || is_object( $replacement ) ) {
					$replacement = wp_json_encode( $replacement );
				}

				$formatted_item = str_replace( '%' . $property . '%', $replacement, $formatted_item );
			}

			$formatted_items[] = $formatted_item;
		}

		return implode( ', ', $formatted_items );
	}

	/**
	 * Get WooCommerce cart data
	 *
	 * @return array<string, array<string, mixed>> Cart data.
	 */
	protected function get_cart_data(): array {
		// Make sure WooCommerce is active.
		if ( ! function_exists( 'WC' ) ) {
			return array();
		}

		$wc = WC();
		if ( ! $wc || ! property_exists( $wc, 'cart' ) || ! $wc->cart ) {
			return array();
		}

		return $wc->cart->get_cart();
	}

	/**
	 * AJAX handler for getting formatted cart contents.
	 *
	 * @return void
	 */
	public function ajax_get_cart_contents(): void {
		// Verify nonce if provided.
		if ( ! empty( $_REQUEST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_key( $_REQUEST['_wpnonce'] ), 'wc_cart_form' ) ) {
			wp_send_json_error( 'Invalid security token' );
		}

		$form_id        = isset( $_POST['form_id'] ) ? intval( $_POST['form_id'] ) : 0;
		$field_mappings = array();

		if ( $form_id ) {
			// Get form.
			$form = \GFAPI::get_form( $form_id );
			if ( ! empty( $form['woocommerce_cart_mappings'] ) && is_array( $form['woocommerce_cart_mappings'] ) ) {
				$field_mappings = $form['woocommerce_cart_mappings'];
			}
		}

		$cart_data      = $this->get_cart_data();
		$formatted_data = array();

		foreach ( $field_mappings as $mapping ) {
			if ( empty( $mapping['key'] ) || empty( $mapping['custom_value'] ) ) {
				continue;
			}

			$field_id        = $mapping['key'];
			$format_template = $mapping['custom_value'];

			$formatted_data[ $field_id ] = $this->format_cart_items( $cart_data, $format_template );
		}

		wp_send_json_success( $formatted_data );
	}

	/**
	 * Enqueue scripts for forms with cart management enabled.
	 *
	 * @param array<string, mixed> $form Form object.
	 * @return void
	 */
	public function maybe_enqueue_scripts( array $form ): void {
		// Check if cart management is enabled for this form.
		if ( empty( $form['enable_cart_management'] ) ) {
			return;
		}

		// Enqueue the script for dynamic country-state functionality.
		$assets = new \OneNovanta\Theme\Assets( ONE_NOVANTA_THEME_BUILD_DIR, ONE_NOVANTA_THEME_BUILD_URI );
		$assets->register_script( 'one-novanta-gf-wc-cart-form', 'forms/gf-wc-cart-form.js', array( 'wp-hooks', 'woocommerce' ) );

		// Localize script with form ID and nonce.
		wp_localize_script(
			'one-novanta-gf-wc-cart-form',
			'oneNovantaWcCart',
			array(
				'formId'  => $form['id'],
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'wc_cart_form' ),
			)
		);
	}
}
