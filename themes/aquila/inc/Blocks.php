<?php
/**
 * Registers all custom gutenberg blocks.
 *
 * @package AquilaTheme
 */

namespace Aquila\Theme;

use Aquila\Traits\Singleton;

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

		// Register block category.
		add_filter( 'block_categories_all', [ $this, 'register_block_category' ] );

		// Translation.
		add_action( 'init', array( $this, 'register_translations' ), 100 );

		// Debug: Add admin notice to show registered blocks
		if ( is_admin() ) {
			add_action( 'admin_notices', [ $this, 'debug_registered_blocks' ] );
		}
	}

	/**
	 * Filters the default array of categories for block types.
	 *
	 * @param array{slug: string, title: string, icon: mixed|null}[] $block_categories Array of categories for block types.
	 *
	 * @return array<mixed> Array of categories for block types.
	 */
	public function register_block_category( $block_categories ) {
		$new_category = array(
			array(
				'slug'  => 'aquila',
				'title' => __( 'One Novanta', 'aquila' ),
			),
		);

		$merged_categories = array_merge( $new_category, $block_categories );

		// Debug: Log category registration
		error_log('Aquila Block Category Registration: ' . print_r($new_category, true));
		error_log('Total categories after merge: ' . count($merged_categories));

		return $merged_categories;
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
		$build_dir = AQUILA_THEME_BUILD_DIR . '/blocks';

		// Debug: Check if directory exists
		if ( ! is_dir( $build_dir ) ) {
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(
				$build_dir,
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
		$blocks     = array_merge( $blocks, [] );

		/**
		 * Filter the blocks array.
		 *
		 * @param array $blocks Array of blocks.
		 */
		$blocks = apply_filters( 'oneaquila_theme_blocks', $blocks );

		// Register all blocks.
		foreach ( $blocks as $block ) {
//            echo '<pre/>';
//            print_r($block);
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

		// Test block registration
		$this->test_block_registration();
	}

	/**
	 * Test if blocks are registered correctly.
	 *
	 * @return void
	 */
	public function test_block_registration(): void {
		$registry = \WP_Block_Type_Registry::get_instance();

		if ($registry->is_registered('aquila/notice')) {
			error_log('SUCCESS: Notice block is registered!');
			$notice_block = $registry->get_registered('aquila/notice');
			error_log('Block name: ' . $notice_block->name);
			error_log('Block title: ' . $notice_block->title);
		} else {
			error_log('ERROR: Notice block is NOT registered');
			// Get all registered blocks using a different approach
			$all_blocks = $registry->get_all_registered();
			error_log('Total registered blocks: ' . count($all_blocks));
			error_log('Available blocks: ' . implode(', ', array_keys($all_blocks)));
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
			'aquila_translation_block_attributes',
			function ( array $blocks_and_attributes = [] ) use ( $block_translations ) {
				// Add the blocks and their attributes to translate.
				$blocks_and_attributes = array_merge( $blocks_and_attributes, $block_translations );
				// Return the blocks and their attributes to translate.
				return $blocks_and_attributes;
			}
		);
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
				'category' => 'aquila',
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

	/**
	 * Debug method to show registered blocks in admin.
	 *
	 * @return void
	 */
	public function debug_registered_blocks(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$registered_blocks = $this->registered_blocks;
		$block_names = array_keys( $registered_blocks );

		echo '<div class="notice notice-info"><p>';
		echo '<strong>Aquila Theme Debug:</strong> Registered blocks: ';
		echo empty( $block_names ) ? 'None' : implode( ', ', $block_names );
		echo '</p></div>';
	}
}
