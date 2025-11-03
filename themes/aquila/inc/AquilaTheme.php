<?php
/**
 * Aquila Theme.
 *
 * @package AquilaTheme
 */

namespace Aquila\Theme;

use Aquila\Traits\Singleton;

/**
 * Class AquilaTheme
 */
class AquilaTheme {

	use Singleton;

	/**
	 * Constructor.
	 */
	protected function __construct() {
		$this->load_theme();
		$this->setup_theme();
	}

	/**
	 * Setup theme.
	 *
	 * @return void
	 */
	public function setup_theme() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );

		// Disable JS concatenation.
		// Temporarily disabled to avoid issues with interactive blocks.
		add_filter( 'js_do_concat', '__return_false' );

		// Add in your theme's functions.php
		add_filter('wp_component_viewer_scan_paths', array( $this, 'configure_component_scan_paths' ) );
	}

	/**
	 * Configure component scan path.
	 *
	 * @param $paths
	 *
	 * @return mixed
	 */
	public function configure_component_scan_paths( $paths ) {
		$paths['components']     = '/src/components';
		$paths['css_build_path'] = '/build/components/{{component_name}}/index.css';
		$paths['js_build_path']  = '/build/components/{{component_name}}/index.js';

		return $paths;
	}

	/**
	 * Load theme.
	 *
	 * @return void
	 */
	public function load_theme() {
		// @TODO: We are mixing singleton and non-singleton classes, will revisit this later.
		Assets::get_instance();
//		$assets = new Assets( AQUILA_THEME_BUILD_DIR, AQUILA_THEME_BUILD_URI );
//		$assets->bootstrap();
//
		Blocks::get_instance();
//
//		if ( is_admin() ) {
//			// Load admin specific code.
//			BlockEditor::get_instance();
//		}
	}

	/**
	 * Theme supports.
	 *
	 * @return void
	 */
	public function theme_supports() {
		self::custom_image_sizes();
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
}
