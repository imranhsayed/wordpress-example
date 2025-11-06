<?php
/**
 * Dynamic Country-State Fields for GravityForms.
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme\Customizations\GravityForms;

use OneNovanta\Traits\Singleton;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for Dynamic Country-State Fields functionality.
 */
class DynamicCountryState {

	/**
	 * Use the Singleton trait.
	 */
	use Singleton;

	/**
	 * Parsed country-state data.
	 *
	 * @var array<string, array{name: string, states: array<string, string>}>
	 */
	private $country_state_data = array();

	/**
	 * Constructor.
	 */
	private function __construct() {
		// Initialize hooks.
		$this->init();
	}

	/**
	 * Initialize hooks.
	 *
	 * @return void
	 */
	public function init(): void {
		// Check if GravityForms is active.
		if ( ! class_exists( 'GFForms' ) ) {
			return;
		}

		// Collect country-state data.
		$this->country_state_data = $this->get_country_state_data();

		// Enqueue scripts and styles.
		add_action( 'gform_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Add filter to modify GravityForms address field.
		add_filter( 'gform_field_content', array( $this, 'modify_address_field' ), 10, 5 );

		// Create AJAX endpoints for retrieving states.
		add_action( 'wp_ajax_get_states_by_country', array( $this, 'ajax_get_states_by_country' ) );
		add_action( 'wp_ajax_nopriv_get_states_by_country', array( $this, 'ajax_get_states_by_country' ) );

		// Filter to modify available countries in address fields.
		add_filter( 'gform_countries', array( $this, 'filter_countries' ) );
	}

	/**
	 * Capture the countries from GravityForms.
	 *
	 * @param array<string, string> $countries List of countries.
	 * @return array<string, string> List of countries.
	 *
	 * @see https://docs.gravityforms.com/gform_countries/
	 */
	public function filter_countries( $countries ): array {
		// Add countries to the country-state data.
		foreach ( $countries as $country ) {
			$this->country_state_data[ \GFCommon::get_country_code( $country ) ] = array(
				'name'   => $country,
				'states' => array(),
			);
		}

		return $countries;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		// Only enqueue on pages with GravityForms.
		if ( ! is_admin() && class_exists( 'GFForms' ) ) {

			// Enqueue the script for dynamic country-state functionality.
			$assets = new \OneNovanta\Theme\Assets( ONE_NOVANTA_THEME_BUILD_DIR, ONE_NOVANTA_THEME_BUILD_URI );
			$assets->register_script( 'gf-dynamic-country-state', 'forms/gf-dynamic-country-state.js' );

			// Localize the script with data and variables.
			wp_localize_script(
				'gf-dynamic-country-state',
				'GFDynamicCountryState',
				array(
					'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
					'nonce'     => wp_create_nonce( 'gf-dynamic-country-state-nonce' ),
					'countries' => $this->country_state_data,
				)
			);
		}
	}

	/**
	 * Modify the GravityForms address field to add our custom attributes
	 * and handle state field for custom country-state population.
	 *
	 * @param string $field_content Field content.
	 * @param object $field Field object.
	 * @param string $value Field value.
	 * @param int    $lead_id Lead ID.
	 * @param int    $form_id Form ID.
	 * @return string Modified field content.
	 */
	public function modify_address_field( $field_content, $field, $value, $lead_id, $form_id ): string { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		// Only modify the address field.
		if ( property_exists( $field, 'type' ) && 'address' !== $field->type ) {
			return $field_content;
		}

		// Make sure field has an ID property.
		if ( ! property_exists( $field, 'id' ) ) {
			return $field_content;
		}

		// Add data attributes to the country dropdown for JavaScript identification.
		$field_content = str_replace(
			'name=\'input_' . $field->id . '.6\'',
			'name=\'input_' . $field->id . '.6\' class=\'gf-dynamic-country\' data-target=\'gf-dynamic-state-' . $form_id . '\'', // Form ID added to class for uniqueness.
			$field_content
		);

		// Check if the field contains a state input or select.
		$has_select = strpos( $field_content, '<select name=\'input_' . $field->id . '.4\'' ) !== false;

		if ( $has_select ) {
			// If it's already a select, just add our class.
			$field_content = str_replace(
				'name=\'input_' . $field->id . '.4\'',
				'name=\'input_' . $field->id . '.4\' class=\'gf-dynamic-state-' . $form_id . '\'',
				$field_content
			);
		} else {
			// It's a text input, convert to select.
			// First, create a regular expression to find the state input.
			$state_regex = '/<input[^>]*?name=\'input_' . preg_quote( $field->id, '/' ) . '\.4\'[^>]*?>/s';

			// Search for the input to get its attributes.
			preg_match( $state_regex, $field_content, $input_matches );

			if ( ! empty( $input_matches ) ) {
				$input_tag = $input_matches[0];

				// Extract class if any.
				$class_attr = '';
				if ( preg_match( '/class=\'([^\']*?)\'/', $input_tag, $class_matches ) ) {
					$class_attr = $class_matches[1] . ' ';
				}

				// Extract value if any.
				$value_attr = '';
				if ( preg_match( '/value=\'([^\']*?)\'/', $input_tag, $value_matches ) ) {
					$value_attr = $value_matches[1];
				}

				// Create a dropdown to replace the input.
				if ( strpos( $class_attr, 'gform_hidden' ) !== false ) {
					return $field_content;
				}

				$state_dropdown  = '<select name=\'input_' . $field->id . '.4\' id=\'input_' . $field->id . '.4\' class=\'' . $class_attr . 'gf-dynamic-state-' . $form_id . '\'>';
				$state_dropdown .= '<option value=\'\'>Select a state</option>';
				if ( ! empty( $value_attr ) ) {
					$state_dropdown .= '<option value=\'' . esc_attr( $value_attr ) . '\' selected>' . esc_html( $value_attr ) . '</option>';
				}
				$state_dropdown .= '</select>';

				// Replace the input with our dropdown.
				$new_content   = preg_replace( $state_regex, $state_dropdown, $field_content );
				$field_content = null !== $new_content ? $new_content : $field_content;
			}

			// If regex replacement failed or no match was found, mark the input for JavaScript conversion.
			if ( empty( $input_matches ) ) {
				$field_content = str_replace(
					'name=\'input_' . $field->id . '.4\'',
					'name=\'input_' . $field->id . '.4\' class=\'gf-dynamic-state-convert\'',
					$field_content
				);
			}
		}

		return $field_content;
	}

	/**
	 * AJAX handler to get states by country.
	 *
	 * @return void
	 */
	public function ajax_get_states_by_country(): void {
		// Verify nonce.
		check_ajax_referer( 'gf-dynamic-country-state-nonce', 'nonce' );

		// Get country code from request.
		$country_code = isset( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : '';

		// Get states for the country.
		$states = isset( $this->country_state_data[ $country_code ]['states'] )
			? $this->country_state_data[ $country_code ]['states']
			: array();

		// Return the states as JSON.
		wp_send_json_success( $states );
	}

	/**
	 * Pre-defined country and state data.
	 *
	 * @return array<string, array{name: string, states: array<string, string>}> Country and state data.
	 */
	private function get_country_state_data(): array {
		// Pre-defined country and state data.
		$country_states = array();

		// Add all states of the US.
		$country_states['US'] = array(
			'name'   => 'United States',
			'states' => \GFCommon::get_us_states(),
		);

		// Add all states of Canada.
		$country_states['CA'] = array(
			'name'   => 'Canada',
			'states' => \GFCommon::get_canadian_provinces(),
		);

		return $country_states;
	}
}
