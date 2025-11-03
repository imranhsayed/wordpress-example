<?php
/**
 * Aquila Theme Assets.
 *
 * @package Aquila
 */

namespace Aquila\Theme;

use Aquila\Traits\Singleton;

/**
 * Class Assets
 */
class Assets {
	use Singleton;

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	public static string $handle = 'aquila';
	public string $build_dir_uri = AQUILA_THEME_BUILD_URI;
	public string $build_dir = AQUILA_THEME_BUILD_DIR;

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 */
	public function setup_hooks(): void {
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_assets' ] );

		// Enqueue assets for the dashboard.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
		add_action( 'enqueue_block_assets', [ $this, 'register_block_assets' ] );

		// Enqueue frontend assets.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
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
	 * Register block assets.
	 *
	 * @return void
	 */
	public function register_block_assets(): void {
		// Register block styles for core blocks.
		$this->register_block_styles();
	}

	/**
	 * Enqueue assets.
	 *
	 * @return void
	 */
	public function enqueue_assets(): void {
		// Enqueue block editor assets.
		$this->enqueue_block_editor_assets();
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

		// Register editor style.
		$this->register_style(
			$handle . '-style',
			'css/editor.css',
		);
	}

	/**
	 * Enqueue frontend assets.
	 *
	 * @return void
	 */
	public function enqueue_frontend_assets(): void {
		$handle = self::$handle . '-frontend';

		// Enqueue main frontend script.
		$this->register_script(
			$handle . '-script',
			'index.js',
			[],
			false,
			true
		);

		// Enqueue main frontend style.
		$this->register_style(
			$handle . '-style',
			'style.css',
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
	 * Get asset dependencies and version info from {handle}.asset.php if exists.
	 *
	 * @param string        $file File name.
	 * @param array<string> $deps Script dependencies to merge with.
	 * @param false|string  $ver  Asset version string.
	 *
	 * @return array<string, mixed> Asset meta data.
	 */
	public function get_asset_meta( $file, $deps = array(), $ver = false ) {
		$asset_meta_file = sprintf( '%s/%s.asset.php', untrailingslashit( $this->build_dir ), basename( $file, '.' . pathinfo( $file )['extension'] ) ); // @phpstan-ignore offsetAccess.notFound
		$asset_meta      = is_readable( $asset_meta_file )
			? require $asset_meta_file
			: array(
				'dependencies' => array(),
				'version'      => $this->get_file_version( $file, $ver ),
			);

		$asset_meta['dependencies'] = array_merge( $deps, $asset_meta['dependencies'] );

		return $asset_meta;
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
	 * Register a CSS stylesheet.
	 *
	 * @param string           $handle Name of the stylesheet. Should be unique.
	 * @param string           $file    style file, path of the script relative to the assets/build/ directory.
	 * @param array<string>    $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
	 * @param string|bool|null $ver    Optional. String specifying script version number, if not set, filetime will be used as version number.
	 * @param string           $media  Optional. The media for which this stylesheet has been defined.
	 *                                 Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
	 *                                 '(orientation: portrait)' and '(max-width: 640px)'.
	 * @param bool             $enqueue Optional. Whether to enqueue the stylesheet. Default true.
	 *
	 * @return bool Whether the style has been registered. True on success, false on failure.
	 */
	public function register_style( $handle, $file, $deps = array(), $ver = false, $media = 'all', $enqueue = true ) {

		$file_path = sprintf( '%s/%s', $this->build_dir, $file );

		if ( ! \file_exists( $file_path ) ) {
			return false;
		}

		$src        = sprintf( $this->build_dir_uri . '/%s', $file );
		$asset_meta = $this->get_asset_meta( $file, $deps );

		if ( $enqueue ) {
			return wp_enqueue_style( $handle, $src, $deps, $asset_meta['version'], $media );
		} else {
			return wp_register_style( $handle, $src, $deps, $asset_meta['version'], $media );
		}
	}

	/**
	 * Register a new script.
	 *
	 * @param string            $handle    Name of the script. Should be unique.
	 * @param string            $file       script file, path of the script relative to the assets/build/ directory.
	 * @param array<string>     $deps      Optional. An array of registered script handles this script depends on. Default empty array.
	 * @param string|bool|null  $ver       Optional. String specifying script version number, if not set, filetime will be used as version number.
	 * @param array<mixed>|bool $args     {
	 *     Optional. An array of additional script loading strategies. Default empty array.
	 *     Otherwise, it may be a boolean in which case it determines whether the script is printed in the footer. Default false.
	 *
	 *     @type string    $strategy     Optional. If provided, may be either 'defer' or 'async'.
	 *     @type bool      $in_footer    Optional. Whether to print the script in the footer. Default 'false'.
	 * }
	 * @param bool              $enqueue   Optional. Whether to enqueue the script. Default true.
	 *
	 * @return mixed|bool  Whether the script has been registered. True on success, false on failure.
	 */
	public function register_script( $handle, $file, $deps = array(), $ver = false, $args = false, $enqueue = true ) {

		$file_path = sprintf( '%s/%s', $this->build_dir, $file );

		if ( ! \file_exists( $file_path ) ) {
			return false;
		}

		$src        = sprintf( $this->build_dir_uri . '/%s', $file );
		$asset_meta = $this->get_asset_meta( $file, $deps );

		if ( $enqueue ) {
			return wp_enqueue_script( $handle, $src, $asset_meta['dependencies'], $asset_meta['version'], $args );
		} else {
			return wp_register_script( $handle, $src, $asset_meta['dependencies'], $asset_meta['version'], $args );
		}
	}

	/**
	 * Get file version.
	 *
	 * @param string             $file File path.
	 * @param int|string|boolean $ver  File version.
	 *
	 * @return bool|int|string File version.
	 */
	public function get_file_version( $file, $ver = false ) {
		if ( ! empty( $ver ) ) {
			return $ver;
		}

		$file_path = sprintf( '%s/%s', $this->build_dir, $file );

		return file_exists( $file_path ) ? filemtime( $file_path ) : false;
	}
}
