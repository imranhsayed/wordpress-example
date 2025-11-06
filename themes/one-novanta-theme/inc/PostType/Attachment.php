<?php
/**
 * Attachment Custom Functionalities.
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme\PostType;

use OneNovanta\Traits\Singleton;

/**
 * Attachment class.
 */
class Attachment {

	/**
	 * Use the Singleton trait.
	 */
	use Singleton;

	/**
	 * Define the post type.
	 *
	 * @var string
	 */
	public const POST_TYPE = 'attachment';

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	protected function __construct() {
		// Register custom meta.
		add_action( 'init', [ $this, 'register_meta' ] );
	}

	/**
	 * Get the post type slug.
	 *
	 * @return string
	 */
	public function get_slug(): string {
		// Return post type.
		return self::POST_TYPE;
	}

	/**
	 * Registers custom meta fields.
	 *
	 * @return void
	 */
	public function register_meta(): void {

		register_post_meta(
			self::POST_TYPE,
			'focal_point',
			array(
				'type'         => 'object',
				'description'  => 'Focal point coordinates for the image.',
				'single'       => true,
				'show_in_rest' => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'x' => array(
								'type' => 'number',
							),
							'y' => array(
								'type' => 'number',
							),
						),
					),
				),
			)
		);
	}
}
