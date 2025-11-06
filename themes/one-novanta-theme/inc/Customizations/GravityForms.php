<?php
/**
 * Form customizations for One Novanta Theme
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme\Customizations;

use OneNovanta\Traits\Singleton;

/**
 * Form customizations class
 */
class GravityForms {

	/**
	 * Use the Singleton trait.
	 */
	use Singleton;

	/**
	 * Assets version.
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Common assets registered flag.
	 *
	 * @var bool
	 */
	protected $common_assets_registered = false;

	/**
	 * Form specific assets that have been registered.
	 *
	 * @var array<int, bool>
	 */
	protected $registered_form_assets = array();

	/**
	 * Form IDs on the current page.
	 *
	 * @var array<int, int>
	 */
	protected $current_page_forms = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->version = defined( 'ONE_NOVANTA_THEME_VERSION' ) ? ONE_NOVANTA_THEME_VERSION : '1.0.0';

		// Add form settings for privacy note.
		add_filter( 'gform_form_settings_fields', array( $this, 'add_custom_setting' ), 10, 2 );

		// Add privacy note to Gravity Forms submit button.
		add_filter( 'gform_submit_button', array( $this, 'add_privacy_text_to_form' ), 10, 2 );

		// Remove validation errors markup.
		add_filter( 'gform_form_validation_errors_markup', array( $this, 'remove_validation_errors_markup' ) );

		// Bypass state validation for non-US/Canada countries.
		add_filter( 'gform_field_validation', array( $this, 'maybe_bypass_state_validation' ), 10, 4 );

		// Add filter to include static field mappings in Salesforce data.
		add_filter( 'gform_salesforce_object_data', array( $this, 'add_static_mappings_to_salesforce' ), 10, 4 );

		// Add custom GravityForms styles only when the form is on the page.
		$this->register_conditional_hooks();
	}

	/**
	 * Add static field mappings to Salesforce data.
	 *
	 * @param array<string, mixed> $body Array of mapped fields and values.
	 * @param array<string, mixed> $form The form object.
	 * @param array<string, mixed> $entry The entry object.
	 * @param array<string, mixed> $feed The feed object.
	 * @return array<string, mixed> The modified object data with static mappings.
	 */
	public function add_static_mappings_to_salesforce( $body, $form, $entry, $feed ): array {
		// Get feed-specific mappings.
		$feed_id     = $feed['id'];
		$mapping_key = 'salesforce_static_mappings_' . $feed_id;

		// Check if feed-specific mappings exist in form settings.
		if ( ! empty( $form[ $mapping_key ] ) && is_array( $form[ $mapping_key ] ) ) {
			foreach ( $form[ $mapping_key ] as $mapping ) {
				// Skip if field name or value is empty.
				if ( empty( $mapping['key'] ) || empty( $mapping['custom_value'] ) ) {
					continue;
				}

				// Add the static value to the object data.
				$body[ $mapping['key'] ] = $mapping['custom_value'];
			}
		}

		return $body;
	}

	/**
	 * Bypass state field validation for non-US/Canada countries.
	 *
	 * @param array<string, mixed> $result Validation result.
	 * @param mixed                $value Field value.
	 * @param array<string, mixed> $form Form object.
	 * @param array<string, mixed> $field Field object.
	 * @return array<string, mixed> Modified validation result.
	 */
	public function maybe_bypass_state_validation( $result, $value, $form, $field ) {
		// Only apply to address fields.
		if ( 'address' !== $field['type'] ) {
			return $result;
		}

		// Get the field ID for this address field.
		$field_id         = (int) $field['id'];
		$address_field_id = floor( $field_id );

		// Get country value from the same address field (subfield 6).
		$country_input_name = sprintf( 'input_%d_6', $address_field_id );

		// Check if the country input name exists in the POST data.
		$country = rgpost( $country_input_name );

		// If country is not US or Canada, bypass validation.
		if ( $country && ! in_array( $country, array( 'US', 'CA', 'United States', 'Canada' ), true ) ) {
			// Force validation to pass.
			$result['is_valid'] = true;
			$result['message']  = '';
		}

		return $result;
	}

	/**
	 * Remove validation errors markup.
	 *
	 * @return string Empty string to remove the default markup.
	 *
	 * @see https://docs.gravityforms.com/gform_form_validation_errors_markup/
	 */
	public function remove_validation_errors_markup(): string {
		return '';
	}

	/**
	 * Get all feeds associated with a form
	 *
	 * @param int $form_id Form ID.
	 * @return array<string, array<int, array<string, mixed>>> All feeds for the form.
	 */
	public function get_all_form_feeds( $form_id ): array {
		if ( ! class_exists( 'GFAPI' ) ) {
			return array();
		}

		// Get all feeds for the form (null as first param gets feeds from all add-ons).
		$feeds = \GFAPI::get_feeds( null, $form_id );

		// Organize feeds by add-on.
		$organized_feeds = array();
		if ( is_array( $feeds ) ) {
			foreach ( $feeds as $feed ) {
				$addon = isset( $feed['addon_slug'] ) ? $feed['addon_slug'] : 'unknown';

				if ( ! isset( $organized_feeds[ $addon ] ) ) {
					$organized_feeds[ $addon ] = array();
				}
				$organized_feeds[ $addon ][] = $feed;
			}
		}

		return $organized_feeds;
	}

	/**
	 * Add privacy note setting to form settings.
	 *
	 * @param array<string, mixed> $fields The form settings fields.
	 * @param array<string, mixed> $form The form object.
	 * @return array<string, mixed> Updated form settings fields.
	 */
	public function add_custom_setting( $fields, $form ): array {
		$fields['privacy_settings'] = array(
			'title'  => 'Privacy Settings',
			'fields' => array(
				array(
					'name'          => 'privacy_note',
					'label'         => 'Privacy Note',
					'type'          => 'textarea',
					'class'         => 'medium merge-tag-support mt-position-right',
					'tooltip'       => 'Custom privacy note to display below the form. HTML is allowed.',
					'default_value' => '',
					'allow_html'    => true,
					'placeholder'   => 'Enter privacy note text with HTML formatting',
				),
			),
		);

		// Get all Salesforce feeds.
		$salesforce_feeds = $this->get_salesforce_feeds( $form );

		// If there are Salesforce feeds, add mapping sections for each feed.
		if ( ! empty( $salesforce_feeds ) && $this->is_salesforce_connected( $form ) ) {
			foreach ( $salesforce_feeds as $feed ) {
				$feed_id   = $feed['id'];
				$feed_name = $feed['name'];
				$field_key = 'salesforce_mapping_' . $feed_id;

				$fields[ $field_key ] = array(
					'title'  => sprintf(
						/* translators: %s: Name of the Salesforce feed */
						'Salesforce Static Field Mapping: %s',
						esc_html( $feed_name )
					),
					'fields' => array(
						array(
							'name'              => 'salesforce_static_mappings_' . $feed_id,
							'label'             => 'Static Field Mappings',
							'type'              => 'generic_map',
							'key_field'         => array(
								'title'       => 'Salesforce Field',
								'placeholder' => 'Enter Salesforce field name',
								'tooltip'     => 'Enter the API name of the Salesforce field',
								'choices'     => $this->get_salesforce_field_choices( $feed ),
							),
							'value_field'       => array(
								'title'       => 'Static Value',
								'placeholder' => 'Enter static value',
								'tooltip'     => 'Enter the value to send to Salesforce',
							),
							'tooltip'           => 'Map static values to specific Salesforce fields',
							'limit'             => 0, // No limit on number of mappings.
							'key_field_title'   => 'Salesforce Field',
							'value_field_title' => 'Static Value',
						),
						array(
							'name' => 'salesforce_mapping_info_' . $feed_id,
							'type' => 'html',
							'html' => '<p class="description">' .
									sprintf(
										/* translators: %s: Name of the Salesforce feed */
										'These static values will be sent to Salesforce for feed "%s" in addition to form field mappings.',
										esc_html( $feed_name )
									) .
									'</p>',
						),
					),
				);
			}
		}

		return $fields;
	}

	/**
	 * Get Salesforce feeds connected to the form.
	 *
	 * @param array<string, mixed> $form The form object.
	 * @return array<int, array<string, mixed>> Array of Salesforce feeds.
	 */
	private function get_salesforce_feeds( $form ): array {
		$salesforce_feeds = array();

		$all_feeds = \GFAPI::get_feeds( null, $form['id'] );
		if ( ! empty( $all_feeds ) && is_array( $all_feeds ) ) {
			foreach ( $all_feeds as $feed ) {
				if ( isset( $feed['addon_slug'] ) &&
					strpos( $feed['addon_slug'], 'salesforce' ) !== false &&
					! in_array( $feed['id'], array_column( $salesforce_feeds, 'id' ), true ) ) {

					$salesforce_feeds[] = array(
						'id'         => $feed['id'],
						'name'       => ! empty( $feed['meta']['feedName'] ) ? $feed['meta']['feedName'] : 'Salesforce Feed',
						'addon'      => $feed['addon_slug'],
						'objectType' => ! empty( $feed['meta']['objectType'] ) ? $feed['meta']['objectType'] : '',
						'is_active'  => ! empty( $feed['is_active'] ),
					);
				}
			}
		}

		return $salesforce_feeds;
	}

	/**
	 * Get Salesforce field choices for the given feed.
	 *
	 * @param array<string, mixed> $feed The feed object.
	 * @return array<int, array<string, string>> Array of field choices.
	 */
	public function get_salesforce_field_choices( $feed ): array {
		$options = array();

		// If feed exists and has valid addon details, use that info.
		if ( ! empty( $feed ) && isset( $feed['addon'] ) && 'gravityformssalesforce' === $feed['addon'] ) {
			$salesforce = \gf_salesforce();
			if ( false !== $salesforce && is_object( $salesforce ) ) {
				$api         = $salesforce->get_api_instance();
				$fields      = [];
				$object_type = $feed['objectType'] ?? '';

				if ( null !== $api ) {
					$fields = $api->get_fields_for_object( $object_type );
				}

				if ( ! empty( $fields ) ) {
					foreach ( $fields as $field ) {
							$options[] = array(
								'value' => $field['name'],
								'label' => $field['label'],
							);
					}
				}
			}
		}

		return $options;
	}


	/**
	 * Check if the form is connected to Salesforce.
	 *
	 * @param array<string, mixed> $form The form object.
	 * @return bool Whether the form is connected to Salesforce.
	 */
	private function is_salesforce_connected( $form ): bool {
		$feeds = \GFAPI::get_feeds( null, $form['id'] );
		if ( ! empty( $feeds ) && is_array( $feeds ) ) {
			foreach ( $feeds as $feed ) {
				if ( isset( $feed['addon_slug'] ) && strpos( $feed['addon_slug'], 'salesforce' ) !== false ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Add privacy notification text below Gravity Forms submit button.
	 *
	 * @param string               $button Button HTML.
	 * @param array<string, mixed> $form   Form data and settings.
	 * @return string Modified button HTML with privacy text.
	 */
	public function add_privacy_text_to_form( $button, $form ): string {
		// Get custom privacy note from form settings or use default.
		$privacy_content = '';

		if ( ! empty( $form['privacy_note'] ) ) {
			$privacy_content = wp_kses_post( $form['privacy_note'] );
			$privacy_text    = '<div class="privacy-notice"><span class="required-text">' . __( '*Required', 'one-novanta-theme' ) . '</span><br>' . $privacy_content . '</div>';
		} else {
			// Add the hardcoded *Required text before the privacy note.
			$privacy_text = '<div class="privacy-notice"><span class="required-text">' . __( '*Required', 'one-novanta-theme' ) . '</span></div>';
		}

		return $button . $privacy_text;
	}

	/**
	 * Register conditional hooks based on environment.
	 *
	 * @return void
	 */
	protected function register_conditional_hooks(): void {

		// Detect Gravity Forms on the page and enqueue assets accordingly.
		add_action( 'gform_enqueue_scripts', array( $this, 'store_form_id' ), 10, 2 );

		// Late priority to ensure we enqueue after all forms are detected.
		add_action( 'enqueue_block_assets', array( $this, 'maybe_enqueue_assets' ), 20 );

		// Enqueue form block styles.
		add_action( 'after_setup_theme', array( $this, 'enqueue_form_block_styles' ), 20 );
	}

	/**
	 * Register common assets for all ATI forms.
	 *
	 * @return void
	 */
	protected function register_common_assets(): void {
		if ( $this->common_assets_registered ) {
			return;
		}

		wp_register_script(
			'one-novanta-gf-common',
			sprintf( '%s/forms/common.js', untrailingslashit( ONE_NOVANTA_THEME_BUILD_URI ) ),
			array( 'jquery' ),
			$this->version,
			true
		);

		$this->common_assets_registered = true;
	}

	/**
	 * Store form ID when a form is being displayed.
	 *
	 * @param array<string, mixed> $form    Form data.
	 * @param bool                 $is_ajax Whether the form is submitted via AJAX.
	 *
	 * @return void
	 */
	public function store_form_id( $form, $is_ajax = false ): void { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( empty( $form['id'] ) ) {
			return;
		}

		$form_id = absint( $form['id'] );

		if ( ! in_array( $form_id, $this->current_page_forms, true ) ) {
			$this->current_page_forms[] = $form_id;
		}
	}

	/**
	 * Enqueue assets if forms are detected on the page.
	 *
	 * @return void
	 */
	public function maybe_enqueue_assets(): void {
		if ( empty( $this->current_page_forms ) ) {
			return;
		}

		$this->register_common_assets();

		wp_enqueue_script( 'one-novanta-gf-common' );
	}

	/**
	 * Enqueue form block styles.
	 *
	 * @return void
	 */
	public function enqueue_form_block_styles(): void {
		wp_enqueue_block_style(
			'gravityforms/form',
			array(
				'handle' => 'one-novanta-gf-common',
				'src'    => sprintf( '%s/css/forms/gform.css', untrailingslashit( ONE_NOVANTA_THEME_BUILD_URI ) ),
				'deps'   => array(),
				'ver'    => (string) filemtime( ONE_NOVANTA_THEME_BUILD_DIR . '/css/forms/gform.css' ),
			)
		);
	}
}
