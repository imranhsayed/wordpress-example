<?php
/**
 * One Novanta Theme Assets.
 *
 * @package OneNovantaTheme
 */

namespace OneNovanta\Theme;

use OneNovanta\Abstracts\Assets as AbstractAssets;

/**
 * Class Assets
 */
class Assets extends AbstractAssets {
	/**
	 * Script handle.
	 *
	 * @var string
	 */
	public static string $handle = 'one-novanta';

	/**
	 * The slugs of the components that are used on the product page.
	 *
	 * @var string[] $product_page_comopnents_slug
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private $product_page_comopnents_slug = [
		'add-to-cart-button',
		'button',
		'buttons',
		'cards',
		'compare-model-table',
		'filter-dropdown',
		'grid',
		'image',
		'load-more',
		'media-lightbox',
		'media-text-cover',
		'product-details',
		'product-search',
		'product-variation-content',
		'product-variation-related-modules',
		'section',
		'svg',
		'table',
		'tabs',
		'two-columns',
	];

	/**
	 * Constructor.
	 *
	 * @param string $build_dir     Build directory.
	 * @param string $build_dir_uri Build directory URI.
	 *
	 * @return void
	 */
	public function __construct( string $build_dir, string $build_dir_uri ) {

		$this->build_dir     = $build_dir;
		$this->build_dir_uri = $build_dir_uri;
	}

	/**
	 * Bootstrap.
	 */
	public function bootstrap(): void {
		$this->setup_hooks();

		// Register block specific styles.
		// This is done here to properly register the block styles.
		$this->register_block_styles();
	}

	/**
	 * Setup hooks.
	 */
	public function setup_hooks(): void {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_external_assets' ] );
		add_action( 'enqueue_block_assets', [ $this, 'register_assets' ] );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_assets' ] );

		// Enqueue assets for the dashboard.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
		add_action( 'enqueue_block_assets', [ $this, 'register_block_assets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_product_page_component_assets' ] );

		// Enqueue assets for wp-activate.
		add_action( 'wp_enqueue_scripts', [ $this, 'register_wp_activate_styles' ] );

		// Enqueue assets for the components.
		add_action( 'onenovanta_after_get_component', [ $this, 'enqueue_component_assets' ] );

		// Disable WooCommerce styles.
		add_filter( 'woocommerce_enqueue_styles', [ $this, 'disable_woocommerce_styles' ] );
	}

	/**
	 * Enqueue wp-activate.php page styles.
	 *
	 * @return void
	 */
	public function register_wp_activate_styles(): void {
		if ( empty( $_SERVER['REQUEST_URI'] ) || ! is_string( $_SERVER['REQUEST_URI'] ) ) {
			return;
		}

		// Parse path.
		$path = wp_parse_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );

		if ( empty( $path ) ) {
			return;
		}

		// Check if we're on wp-activate.php.
		if ( 'wp-activate.php' !== basename( $path ) ) {
			return;
		}

		$this->register_style(
			self::$handle . '-wp-activate',
			'css/wp-activate.css'
		);
	}

	/**
	 * Register product page's components assets.
	 *
	 * @return void
	 */
	public function register_product_page_component_assets(): void {
		if ( ! is_singular( 'product' ) ) {
			return;
		}

		foreach ( $this->product_page_comopnents_slug as $slug ) {
			$this->enqueue_component_assets( $slug );
		}
	}

	/**
	 * Register external assets.
	 */
	public function register_external_assets(): void {
		// Register Wistia Player script.
		wp_register_script(
			'wistia-player',
			'https://fast.wistia.com/player.js',
			[],
			null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			true
		);
	}

	/**
	 * Register block styles.
	 *
	 * Automatically registers all core block style overrides present in the 'css/core-blocks/' directory.
	 * If 'should_load_separate_core_block_assets' is set to true, then the core block style overrides will be loaded separately.
	 *
	 * @return void
	 */
	public function register_block_styles(): void {

		// Find all block css files in the build directory in 'css/blocks/' directory. ignore files ending with 'rlt.css'.
		$block_files = glob( $this->build_dir . '/css/core-blocks/*.css' );

		if ( empty( $block_files ) ) {
			return;
		}

		// Register block styles.
		foreach ( $block_files as $block_file ) {
			if ( false !== strpos( $block_file, 'rtl.css' ) ) {
				continue;
			}

			$block_name = 'core/' . basename( $block_file, '.css' );
			$handle     = self::$handle . '-' . str_replace( '/', '-', $block_name );

			wp_enqueue_block_style(
				$block_name,
				array(
					'handle'  => $handle,
					'src'     => $this->build_dir_uri . '/css/core-blocks/' . basename( $block_file ),
					'path'    => $block_file,
					'version' => filemtime( $block_file ),
				),
			);
		}
	}

	/**
	 * Register Block assets.
	 * Script and style for the block that only needs to be registered.
	 *
	 * @return void
	 */
	public function register_assets(): void {

		$this->register_script(
			self::$handle . '-web-component-slider',
			'slider-web-component.js',
			[],
			false,
			true,
			false,
		);
	}

	/**
	 * Enqueue Block assets.
	 */
	public function enqueue_assets(): void {

		if ( ! is_admin() ) {
			$this->register_script(
				self::$handle . '-script',
				'main.js',
			);

			$this->register_style(
				self::$handle . '-style',
				'css/main.css',
			);
		}

		/**
		 * Localize script for WooCommerce add to cart.
		 */
		wp_localize_script(
			self::$handle . '-script',
			'atiWooCommerce',
			[
				'addToCart' => [
					'restEndpoint' => esc_url( rest_url( '/wc/store/cart/add-item' ) ),
					'method'       => 'POST',
					'nonce'        => wp_create_nonce( 'wc_store_api' ),
				],
			]
		);

		// Register script modules.
		$this->register_modules();

		// Enqueue search css only for search page.
		if ( is_search() ) {

			// Added search page CSS.
			$search_handle = 'one-novanta-theme-search';

			$this->register_style(
				$search_handle,
				'css/search.css',
			);
		}

		// Enqueue editor only assets.
		if ( is_admin() ) {
			$this->enqueue_block_editor_assets();
		}
	}

	/**
	 * Register modules.
	 */
	public function register_modules(): void {

		$this->register_script_module(
			self::$handle . '-module',
			'module.js',
		);
	}

	/**
	 * Enqueue gutenberg block editor assets.
	 *
	 * @return void
	 */
	public function enqueue_block_editor_assets(): void {
		$handle = self::$handle . '-editor';

		// Register block editor script.
		$this->register_script(
			$handle . '-script',
			'editor.js',
		);

		// Register block editor script.
		$this->register_script(
			$handle . '-modification-script',
			'editor-modification.js',
			[],
			false,
			true
		);

		// Load the filtered array.
		$filter_blocks = one_novanta_get_filtered_blocks();

		wp_add_inline_script(
			$handle . '-modification-script',
			'const oneNovantaEMVars = ' . wp_json_encode(
				array(
					'postType'     => get_post_type() ?? '',
					'filterBlocks' => $filter_blocks,
				)
			),
			'before'
		);

		// Register editor style.
		$this->register_style(
			$handle . '-style',
			'css/editor.css',
		);
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @return void
	 */
	public function admin_enqueue(): void {
		// Register admin style.
		$this->register_style( self::$handle . '-admin-styles', 'css/admin.css' );
	}

	/**
	 * Enqueue script and style for the components when needed.
	 *
	 * @param string $slug The slug name for the generic template.
	 *
	 * @return void
	 */
	public function enqueue_component_assets( string $slug ): void {
		$handle = self::$handle . '-component';

		$component_script_path = 'components/' . $slug . '/index.js';
		$component_style_path  = 'css/components/' . $slug . '/index.css';
		$component_asset_meta  = $this->get_asset_meta( $component_script_path );

		$this->register_script(
			$handle . '-' . $slug,
			$component_script_path,
			$component_asset_meta['dependencies'] ?? [],
			$component_asset_meta['version'] ?? false,
			array(
				'strategy' => 'defer',
			),
		);

		$this->register_style(
			$handle . '-' . $slug,
			$component_style_path,
		);
	}

	/**
	 * Register script only for the admin.
	 *
	 * @return void
	 */
	public function register_block_assets() {
		global $current_screen;

		if ( empty( $current_screen ) ) {
			return;
		}

		// Allow search.css to enqueue only on One-Novanta Search template.
		if ( 'site-editor' === $current_screen->id ) {
			// Get the current post ID from the URL.
			$post_id = isset( $_GET['p'] ) ? sanitize_text_field( wp_unslash( $_GET['p'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			// Check for search template.
			if ( '/wp_template/ati-ia-theme//search' === $post_id || '/wp_template/ati-ia-theme//product-search-results' === $post_id ) {
				$handle = 'one-novanta-theme-admin-script';

				// Enqueued search css for admin.
				$this->register_style(
					$handle,
					'css/search.css',
				);
			}
		}
	}

	/**
	 * Disable WooCommerce styles globally, except on single product pages.
	 * https://woocommerce.com/document/disable-the-default-stylesheet/
	 *
	 * @param array<string, array<string, mixed>> $enqueue_styles The styles to enqueue.
	 *
	 * @return array<string, array<string, mixed>> The modified or unmodified styles depending on the page type.
	 */
	public function disable_woocommerce_styles( array $enqueue_styles ): array {
		// On single product pages, return styles unmodified.
		if ( is_singular( 'product' ) ) {
			return $enqueue_styles;
		}

		// Unset the default WooCommerce styles.
		unset( $enqueue_styles['woocommerce-general'] );
		unset( $enqueue_styles['woocommerce-layout'] );
		unset( $enqueue_styles['woocommerce-smallscreen'] );
		unset( $enqueue_styles['woocommerce-blocktheme'] );

		return $enqueue_styles;
	}
}
