<?php
/**
 * Product CPT Custom Functionalities.
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme\PostType;

use OneNovanta\Traits\Singleton;

/**
 * Product class.
 */
class Product {

	/**
	 * Use the Singleton trait.
	 */
	use Singleton;

	/**
	 * Define the post type.
	 *
	 * @var string
	 */
	public const POST_TYPE = 'product';

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
			'is_product_deprecated',
			[
				'type'          => 'boolean',
				'single'        => true,
				'show_in_rest'  => true,
				'default'       => false,
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			]
		);

		register_post_meta(
			self::POST_TYPE,
			'new_product_name',
			[
				'type'          => 'string',
				'single'        => true,
				'show_in_rest'  => true,
				'default'       => '',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			]
		);

		register_post_meta(
			self::POST_TYPE,
			'new_product_url',
			[
				'type'          => 'string',
				'single'        => true,
				'show_in_rest'  => true,
				'default'       => '',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			]
		);
	}
}
