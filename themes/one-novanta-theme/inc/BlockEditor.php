<?php
/**
 * Configure BlockEditor defaults.
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme;

use OneNovanta\Traits\Singleton;

/**
 * Class BlockEditor
 */
class BlockEditor {

	use Singleton;

	/**
	 * Construct method.
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {

		/**
		 * Whitelist block types.
		 */
		add_filter( 'allowed_block_types_all', [ $this, 'filter_allowed_block_types_all' ], 10, 2 );

		/**
		 * Globally disable the Pattern Directory.
		 */
		add_filter( 'should_load_remote_block_patterns', '__return_false' );

		/**
		 * Globally disable the Block Directory.
		 */
		remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );

		/**
		 * Gblobal editor settings.
		 */
		add_filter( 'block_editor_settings_all', array( $this, 'block_editor_settings' ) );
	}

	/**
	 * Filters the allowed block types for all editor types.
	 *
	 * @param bool|string[]            $allowed_block_types  Array of block type slugs, or boolean to enable/disable all. Default true (all registered block types supported).
	 * @param \WP_Block_Editor_Context $block_editor_context The current block editor context.
	 * @return bool|string[] Array of block type slugs, or boolean to enable/disable all. Default true (all registered block types supported).
	 */
	public function filter_allowed_block_types_all( $allowed_block_types, \WP_Block_Editor_Context $block_editor_context ) {

		// Get all block types starting with 'one-novanta/'.
		$novanta_block_types = array_filter(
			\WP_Block_Type_Registry::get_instance()->get_all_registered(),
			function ( $block_type ) {
				return strpos( $block_type->name, 'one-novanta/' ) === 0;
			}
		);

		$filter_blocks = function_exists( 'one_novanta_get_filtered_blocks' ) ? one_novanta_get_filtered_blocks() : [];

		// Fallback arrays if keys missing.
		$novanta_post_block_type         = $filter_blocks['post'] ?? [];
		$novanta_product_block_types     = $filter_blocks['product'] ?? [];
		$allowed_block_types             = $filter_blocks['commonBlocks'] ?? [];
		$novanta_application_block_types = $filter_blocks['novanta_application'] ?? [];

		$novanta_block_types = array_keys( $novanta_block_types );

		if (
			! empty( $block_editor_context->post ) &&
			$block_editor_context->post instanceof \WP_Post
		) {

			switch ( $block_editor_context->post->post_type ) {
				case 'page':
					$allowed_block_types = array_merge( $allowed_block_types, $novanta_block_types );
					break;
				case 'post':
					$allowed_block_types = array_merge( $allowed_block_types, $novanta_post_block_type );
					break;
				case 'product':
				case 'product_variation':
					$allowed_block_types = array_merge( $allowed_block_types, $novanta_product_block_types );
					break;
				case 'novanta_application':
					$allowed_block_types = array_merge( $allowed_block_types, $novanta_application_block_types );
					break;
				default:
					break;
			}
		} else {
			$allowed_block_types = array_merge( $allowed_block_types, $novanta_block_types );
		}

		return $allowed_block_types;
	}

	/**
	 * Block editor settings.
	 *
	 * @param array<string, mixed> $settings Block editor settings.
	 *
	 * @return array<string, mixed>
	 */
	public function block_editor_settings( $settings ): array {
		$settings['generateAnchors']              = true;
		$settings['fontLibraryEnabled']           = false;
		$settings['enableOpenverseMediaCategory'] = false;

		$settings = $this->restrict_block_locking_and_code_editor_to_administrators( $settings );

		return $settings;
	}

	/**
	 * Restrict access to the block locking UI and the Code editor to Administrators.
	 *
	 * @param array<string, mixed> $settings Block editor settings.
	 *
	 * @return array<string, mixed>          The modified block editor settings.
	 */
	public function restrict_block_locking_and_code_editor_to_administrators( $settings ) {
		$is_administrator = current_user_can( 'edit_theme_options' );

		if ( ! $is_administrator ) {
			$settings['canLockBlocks']      = false;
			$settings['codeEditingEnabled'] = false;
		}

		return $settings;
	}
}
