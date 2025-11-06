<?php
/**
 * One Novanta Theme.
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme;

use OneNovanta\Theme\Classes\Search_Post_Type_Filter;
use OneNovanta\Theme\PostType\Attachment;
use OneNovanta\Theme\PostType\Post;
use OneNovanta\Theme\PostType\Product;
use OneNovanta\Traits\Singleton;

/**
 * Class OneNovantaTheme
 */
class OneNovantaTheme {

	use Singleton;

	/**
	 * Constructor.
	 */
	protected function __construct() {
		$this->load_theme();
		$this->setup_theme();
		$this->setup_rest_api();

		// Load Post Types.
		$this->post_types();
	}

	/**
	 * Setup theme.
	 *
	 * @return void
	 */
	public function setup_theme() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'init_gravity_forms_customizations' ) );

		// Disable JS concatenation.
		// Temporarily disabled to avoid issues with interactive blocks.
		add_filter( 'js_do_concat', '__return_false' );
	}

	/**
	 * Load theme.
	 *
	 * @return void
	 */
	public function load_theme() {
		// @TODO: We are mixing singleton and non-singleton classes, will revisit this later.
		$assets = new Assets( ONE_NOVANTA_THEME_BUILD_DIR, ONE_NOVANTA_THEME_BUILD_URI );
		$assets->bootstrap();

		Blocks::get_instance();
		BlockExtensions::get_instance();
		OEmbeds::get_instance();
		Search_Post_Type_Filter::get_instance();

		// Gravity Forms customizations.
		Customizations\GravityForms::get_instance();

		if ( is_admin() ) {
			// Load admin specific code.
			BlockEditor::get_instance();
			BlockExtensions::get_instance();
		}
	}

	/**
	 * Theme supports.
	 *
	 * @return void
	 */
	public function theme_supports() {
		self::custom_image_sizes();

		// Localization.
		load_theme_textdomain( 'one-novanta-theme', get_template_directory() . '/languages' );
	}

	/**
	 * Add custom image sizes for the theme.
	 *
	 * @return void
	 */
	public function custom_image_sizes() {
		// Component: Image-Text-Card; Image needs to be of 800x520 (Cropping to be exact).
		add_image_size( 'text-card', 800, 520 );

		// Component: Tile Caarousel; Image needs to be of 533x533 (Cropping to be exact).
		add_image_size( 'tile-carousel', 533, 533 );

		// Component: Featured Media Slider, Media Text Cover; Image needs to be of 1680x600.
		add_image_size( 'image-large', 1680, 600 );
	}

	/**
	 * Initialize Gravity Forms customizations.
	 *
	 * @return void
	 */
	public function init_gravity_forms_customizations() {
		// Check if the Gravity Forms plugin is active.
		if ( class_exists( 'GFForms' ) ) {
			// Initialize the dynamic country-state fields.
			Customizations\GravityForms\DynamicCountryState::get_instance();
			Customizations\GravityForms\WooCommerceCartFieldMapper::get_instance();
		}
	}

	/**
	 * Setup REST API.
	 *
	 * @return void
	 */
	public function setup_rest_api() {
		API\LatestArticles::get_instance();
		API\ProductSearchFilter::get_instance();
		API\RelatedModules::get_instance();
		API\DocumentsAndDownloads::get_instance();
	}

	/**
	 * Load Post Types.
	 *
	 * @return void
	 */
	public function post_types(): void {
		Post::get_instance();
		Product::get_instance();
		Attachment::get_instance();
	}
}
