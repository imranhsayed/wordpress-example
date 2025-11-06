<?php
/**
 * Gallery block extension.
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme\BlockExtensions;

use OneNovanta\Traits\Singleton;

/**
 * Class Gallery
 *
 * @package OneNovanta\Theme\BlockExtensions
 */
class Gallery {
	use Singleton;

	/**
	 * Constructor.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {
		// Add custom image sizes on after setup theme.
		add_action( 'after_setup_theme', [ $this, 'add_custom_image_sizes' ] );
	}

	/**
	 * Add custom image sizes.
	 *
	 * @return void
	 */
	public function add_custom_image_sizes() {
		// Define custom image sizes in an array for re-usability.
		$image_sizes = [
			'novanta-logo-plate' => [
				'width'  => 260,
				'height' => 130,
				'crop'   => false,
				'label'  => 'Logo Plate (260x130)',
			],
		];

		// Register image sizes.
		foreach ( $image_sizes as $name => $size ) {
			add_image_size( $name, $size['width'], $size['height'], $size['crop'] );
		}

		// Add image sizes to the selection dropdown.
		add_filter(
			'image_size_names_choose',
			function ( $sizes ) use ( $image_sizes ) {
				foreach ( $image_sizes as $name => $size ) {
					$sizes[ $name ] = $size['label'];
				}
				return $sizes;
			}
		);
	}
}
