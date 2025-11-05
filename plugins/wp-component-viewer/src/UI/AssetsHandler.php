<?php
/**
 * Assets handler for frontend and admin
 *
 * @package WPComponentViewer\UI
 */

namespace WPComponentViewer\UI;

/**
 * AssetsHandler class
 */
class AssetsHandler {
	/**
	 * Initialize the assets handler
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_assets' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_component_assets' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_component_assets' ) );
	}

	/**
	 * Enqueue admin assets
	 *
	 * @param string $hook Current admin page hook.
	 * @return void
	 */
	public static function enqueue_admin_assets( $hook ) {
		if ( 'toplevel_page_wp-component-viewer' !== $hook ) {
			return;
		}

		// Enqueue global styles.
		wp_enqueue_global_styles();

		wp_enqueue_style(
			'wp-component-viewer-admin',
			WP_COMPONENT_VIEWER_PLUGIN_URL . 'assets/css/admin.css',
			array(),
			WP_COMPONENT_VIEWER_VERSION
		);

		// Add HTMX library.
		wp_enqueue_script(
			'htmx',
			'https://unpkg.com/htmx.org@1.9.4',
			array(),
			'1.9.4',
			true
		);

		wp_enqueue_script(
			'wp-component-viewer-admin',
			WP_COMPONENT_VIEWER_PLUGIN_URL . 'assets/js/admin.js',
			array( 'jquery', 'htmx' ),
			WP_COMPONENT_VIEWER_VERSION,
			true
		);

		wp_localize_script(
			'wp-component-viewer-admin',
			'wpComponentViewer',
			array(
				'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
				'nonce'          => wp_create_nonce( 'wp_component_viewer_nonce' ),
				'refreshingText' => __( 'Refreshing...', 'wp-component-viewer' ),
			)
		);

		// Add HTMX library.
		wp_enqueue_script(
			'htmx',
			'https://unpkg.com/htmx.org@1.9.4',
			array(),
			'1.9.4',
			true
		);

		wp_enqueue_style(
			'highlighjs-css',
			'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/default.min.css',
			array(),
			'11.11.1'
		);

		wp_enqueue_script(
			'highlighjs-core',
			'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js',
			array(),
			'11.11.1',
			true
		);

		wp_enqueue_script(
			'highlighjs-php',
			'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/languages/php.min.js',
			array( 'highlighjs-core' ),
			'11.11.1',
			true
		);

		// style.css from the theme root.
		wp_enqueue_style(
			'wp-component-viewer-theme-style',
			get_stylesheet_uri(),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}

	/**
	 * Enqueue component assets
	 *
	 * @return void
	 */
	public static function enqueue_component_assets() {
		// Get all the components.
		$components = \WPComponentViewer\Scanner\ComponentScanner::scan_components();

		if ( get_query_var( 'component_name' ) ) {
			$component = $components[ get_query_var( 'component_name' ) ];

			// check if additional_css exists if yes then enqueue it.
			if ( ! empty( $component['additional_css'] ) ) {
				foreach ( $component['additional_css'] as $css_file_path ) {
					// If external URL, enqueue directly.
					if ( strpos( $css_file_path, 'https://' ) === 0 || strpos( $css_file_path, 'http://' ) === 0 ) {
						wp_enqueue_style(
							'wp-component-viewer-' . sanitize_title( $component['slug'] ) . '-' . sanitize_title( basename( $css_file_path ) ),
							$css_file_path,
							array(),
							null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
						);
						continue;
					}

					$file_url  = get_theme_file_uri( $css_file_path );
					$file_path = get_theme_file_path( $css_file_path );
					wp_enqueue_style(
						'wp-component-viewer-' . sanitize_title( $component['slug'] ) . '-' . sanitize_title( basename( $css_file_path ) ),
						$file_url,
						array(),
						filemtime( $file_path )
					);
				}
			}

			// check if additional_js exists if yes then enqueue it.
			if ( ! empty( $component['additional_js'] ) ) {
				foreach ( $component['additional_js'] as $js_file_path ) {
					// If external URL, enqueue directly.
					if ( strpos( $js_file_path, 'https://' ) === 0 || strpos( $js_file_path, 'http://' ) === 0 ) {
						wp_enqueue_script(
							'wp-component-viewer-' . sanitize_title( $component['slug'] ) . '-' . sanitize_title( basename( $js_file_path ) ),
							$js_file_path,
							array(),
							null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
							true
						);
						continue;
					}

					$file_url  = get_theme_file_uri( $js_file_path );
					$file_path = get_theme_file_path( $js_file_path );
					wp_enqueue_script(
						'wp-component-viewer-' . sanitize_title( $component['slug'] ) . '-' . sanitize_title( basename( $js_file_path ) ),
						$file_url,
						array(),
						filemtime( $file_path ),
						true
					);
				}
			}

			// Enqueue component styles.
			if ( ! empty( $component['css_file_path'] ) ) {
				$file_url  = get_theme_file_uri( $component['css_file_path'] );
				$file_path = get_theme_file_path( $component['css_file_path'] );
				wp_enqueue_style(
					'wp-component-viewer-' . sanitize_title( $component['slug'] ),
					$file_url,
					array(),
					filemtime( $file_path )
				);
			}
			// Enqueue component scripts.
			if ( ! empty( $component['js_file_path'] ) ) {
				$file_url  = get_theme_file_uri( $component['js_file_path'] );
				$file_path = get_theme_file_path( $component['js_file_path'] );
				wp_enqueue_script(
					'wp-component-viewer-' . sanitize_title( $component['slug'] ),
					$file_url,
					array(),
					filemtime( $file_path ),
					true
				);
			}
		}
	}
}
