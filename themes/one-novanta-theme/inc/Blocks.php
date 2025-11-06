<?php
/**
 * Registers all custom gutenberg blocks.
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme;

use OneNovanta\Traits\Singleton;

/**
 * Class Blocks
 */
class Blocks {

	use Singleton;

	/**
	 * Array of registered blocks, used to register block translations.
	 *
	 * @var array<string, array{name: string, path: string}>
	 */
	private array $registered_blocks = [];

	/**
	 * Construct method.
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
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'acf/include_fields', array( $this, 'register_acf_blocks_fields' ) );
		add_action( 'init', array( $this, 'register_block_pattern_category' ) );

		// Register block category.
		add_filter( 'block_categories_all', [ $this, 'register_block_category' ] );

		// Filter allowed block.
		add_filter( 'allowed_block_types_all', array( $this, 'filter_allowed_blocks' ), 25 );

		// Remove post date on search for pages     .
		add_filter( 'render_block', [ $this, 'remove_post_date_for_pages' ], 10, 2 );

		// Translation.
		add_action( 'init', array( $this, 'register_translations' ), 100 );
	}

	/**
	 * Filters the default array of categories for block types.
	 *
	 * @param array{slug: string, title: string, icon: mixed|null}[] $block_categories Array of categories for block types.
	 *
	 * @return array<mixed> Array of categories for block types.
	 */
	public function register_block_category( $block_categories ) {
			return array_merge(
				array(
					array(
						'slug'  => 'one-novanta',
						'title' => __( 'One Novanta', 'one-novanta-theme' ),
					),
				),
				$block_categories
			);
	}

	/**
	 * Filters allowed blocks.
	 *
	 * @param bool|string[] $allowed_block_types Array of block type slugs, or boolean to enable/disable all.
	 *                                           Default true (all registered block types supported).
	 *
	 * @return string[] Array of allowed blocks.
	 */
	public function filter_allowed_blocks( array|bool $allowed_block_types ): array {

		// List of disallowed blocks.
		$disallowed_blocks = array(
			'one-novanta/simple-content',
		);

		// Get all registered blocks if $allowed_block_types is not already set.
		if ( ! is_array( $allowed_block_types ) || empty( $allowed_block_types ) ) {
			$registered_blocks   = \WP_Block_Type_Registry::get_instance()->get_all_registered();
			$allowed_block_types = array_keys( $registered_blocks );
		}

		// Create a new array for the allowed blocks.
		$filtered_blocks = array();

		// Loop through each block in the allowed blocks list.
		foreach ( $allowed_block_types as $block ) {

			// Check if the block is not in the disallowed blocks list.
			if ( ! in_array( $block, $disallowed_blocks, true ) ) {

				// If it's not disallowed, add it to the filtered list.
				$filtered_blocks[] = $block;
			}
		}

		// Return the filtered list of allowed blocks.
		return $filtered_blocks;
	}

	/**
	 * Register all custom gutenberg blocks.
	 *
	 * @return void
	 */
	public function register_blocks(): void {
		// Get all directories from '/blocks' directory.
		$blocks = array();

		/**
		 * Register Theme blocks.
		 */
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(
				ONE_NOVANTA_THEME_BUILD_DIR . '/blocks',
				\RecursiveDirectoryIterator::SKIP_DOTS
			),
			\RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ( $iterator as $item ) {
			if ( $item->isDir() && file_exists( $item->getPathname() . '/block.json' ) ) {
				$blocks[] = $item->getPathname();
			}
		}

		/**
		 * Register ACF Blocks.
		 */
		$acf_blocks = $this->get_acf_block_paths();
		$blocks     = array_merge( $blocks, $acf_blocks );

		/**
		 * Filter the blocks array.
		 *
		 * @param array $blocks Array of blocks.
		 */
		$blocks = apply_filters( 'onenovanta_theme_blocks', $blocks );

		// Register all blocks.
		foreach ( $blocks as $block ) {
			// Register block.
			$block_metadata = register_block_type_from_metadata(
				$block,
			);

			// If block registration fails, skip to the next block.
			if ( ! $block_metadata ) {
				continue;
			}

			// Get block name.
			$block_name = $block_metadata->name;

			// Add block to registered blocks array, to be used for registering block translations.
			$this->registered_blocks[ $block_name ] = array(
				'name' => $block_name,
				'path' => $block,
			);
		}
	}

	/**
	 * Register all custom gutenberg blocks translations.
	 *
	 * @return void
	 */
	public function register_translations(): void {
		// Create an array to store the block translations.
		$block_translations = array();

		// Loop through each registered block.
		foreach ( $this->registered_blocks as $block ) {
			$block_name = $block['name'];
			$block_path = $block['path'];

			// Skip if block name or path is empty.
			if ( empty( $block_name ) || empty( $block_path ) ) {
				continue;
			}

			// Block source path, we can get this by replacing the 'build' directory with the 'src' directory.
			$block_source_path = str_replace( 'build', 'src', $block_path );

			// Check if a translations.php file exists for the block.
			if ( file_exists( $block_source_path . '/translations.php' ) ) {
				// Include the translations file and store its contents in the $translations variable.
				$translations = include $block_source_path . '/translations.php';

				// If the translations are an array, add them to the $block_translations array.
				if ( is_array( $translations ) ) {
					$block_translations[ $block_name ] = $translations;
				}
			}
		}

		add_filter(
			'novanta_translation_block_attributes',
			function ( array $blocks_and_attributes = [] ) use ( $block_translations ) {
				// Add the blocks and their attributes to translate.
				$blocks_and_attributes = array_merge( $blocks_and_attributes, $block_translations );
				// Return the blocks and their attributes to translate.
				return $blocks_and_attributes;
			}
		);
	}

	/**
	 * Get all directories from '/acf-blocks' directory.
	 *
	 * @return string[] List of directories.
	 */
	private function get_acf_block_paths(): array {
		$blocks = [];

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(
				ONE_NOVANTA_THEME_DIR . '/src/acf-blocks',
				\RecursiveDirectoryIterator::SKIP_DOTS
			),
			\RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ( $iterator as $item ) {
			if ( $item->isDir() && file_exists( $item->getPathname() . '/block.json' ) ) {
				$blocks[] = $item->getPathname();
			}
		}

		// Array of block paths.
		return $blocks;
	}

	/**
	 * Register all custom ACF gutenberg block's fields.
	 *
	 * @return void
	 */
	public function register_acf_blocks_fields(): void {
		// Check if ACF is active.
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		// Get all directories from '/acf-blocks' directory.
		$blocks = $this->get_acf_block_paths();

		// Register all blocks.
		foreach ( $blocks as $block ) {
			// Get field file.
			$fields = $block . '/fields.php';

			// Check if file exists.
			if ( file_exists( $fields ) ) {
				// Require the fields file.
				require_once $fields;
			}
		}
	}

	/**
	 * Registers multiple block pattern categories for the theme.
	 *
	 * This function defines and registers custom block pattern categories
	 * that can be used to group related block patterns in the WordPress editor.
	 */
	public function register_block_pattern_category(): void {
		$category_registration = array(
			array(
				'category' => 'one-novanta',
				'label'    => 'One Novanta',
			),
			array(
				'category' => 'homepage',
				'label'    => 'Homepage',
			),
			array(
				'category' => 'page',
				'label'    => 'Page',
			),
		);

		foreach ( $category_registration as $category ) {
			// Register block pattern category.
			register_block_pattern_category(
				$category['category'],
				array(
					'label' => $category['label'],
				)
			);
		}
	}

	/**
	 * Remove postdate for page on search page
	 *
	 * @param string                $block_content Content of the block.
	 * @param array<string, string> $block          Array properties of a block.
	 *
	 * @return mixed|string
	 */
	public function remove_post_date_for_pages( $block_content, $block ) {
		global $post;

		// Ensure $post is available and valid.
		if ( isset( $post ) && is_a( $post, 'WP_Post' ) ) {
			$post_id = $post->ID;
			if ( 'core/post-date' === $block['blockName'] && is_search() && 'page' === get_post_type( $post_id ) ) {
				return ''; // Remove post-date block on pages.
			}
		}

		return $block_content;
	}
}
