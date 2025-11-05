<?php
/**
 * Component scanner
 *
 * @package WPComponentViewer\Scanner
 */

namespace WPComponentViewer\Scanner;

use WPComponentViewer\DocBlock\DocBlockParser;

/**
 * ComponentScanner class
 */
class ComponentScanner {
	/**
	 * Default scan paths
	 *
	 * @var array
	 */
	private static $default_paths = array(
		'components'     => '/components',
		'blocks'         => '/blocks',
		'templates'      => '/templates',
		'partials'       => '/partials',
		'css_build_path' => '/build/css/{{component_name}}.css',
		'js_build_path'  => '/build/js/{{component_name}}.js',
	);

	/**
	 * Initialize the scanner
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_ajax_scan_components', array( __CLASS__, 'ajax_scan_components' ) );
	}

	/**
	 * AJAX handler for scanning components
	 *
	 * @return void
	 */
	public static function ajax_scan_components() {
		check_ajax_referer( 'wp_component_viewer_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Insufficient permissions' );
		}

		$components = self::scan_components();
		wp_send_json_success( $components );
	}

	/**
	 * Scan theme for components
	 *
	 * @return array
	 */
	public static function scan_components() {

		// Check if we need to refresh the cache.
		if ( isset( $_GET['wp-component-viewer-refresh'] ) && check_admin_referer( 'wp_component_viewer_refresh' ) ) {
			delete_transient( 'wp_component_viewer_components' );
		}

		// Try to get from cache first.
		$components = get_transient( 'wp_component_viewer_components' );

		if ( false !== $components ) {
			return $components;
		}

		$components = array();
		$theme_dir  = get_template_directory();
		$scan_paths = self::get_scan_paths();

		foreach ( $scan_paths as $type => $path ) {
			$full_path = $theme_dir . $path;

			if ( ! is_dir( $full_path ) ) {
				continue;
			}

			$files = self::recursive_scan_dir( $full_path, array( 'php' ) );

			foreach ( $files as $file ) {
				$file_path = $full_path . '/' . $file;
				$doc_block = DocBlockParser::parse_file( $file_path );

				if ( ! empty( $doc_block ) && isset( $doc_block['component'] ) ) {
					$component_name = sanitize_title( $doc_block['component'] );
					$css_file_path  = self::find_component_css( $component_name );
					$js_file_path   = self::find_component_js( $component_name );

					$components[ $component_name ] = array(
						'name'               => $doc_block['component'],
						'slug'               => $component_name,
						'file_path'          => $file_path,
						'css_file_path'      => $css_file_path,
						'js_file_path'       => $js_file_path,
						'file'               => $file,
						'type'               => $type,
						'description'        => isset( $doc_block['description'] ) ? $doc_block['description'] : '',
						'group'              => isset( $doc_block['group'] ) ? $doc_block['group'] : 'Uncategorized',
						'props'              => isset( $doc_block['props'] ) ? json_decode( $doc_block['props'], true ) : array(),
						'variations'         => isset( $doc_block['variations'] ) ? json_decode( $doc_block['variations'], true ) : array(),
						'example'            => isset( $doc_block['example'] ) ? $doc_block['example'] : '',
						'additional_css'     => isset( $doc_block['additional_css'] ) ? json_decode( $doc_block['additional_css'], true ) : array(),
						'additional_js'      => isset( $doc_block['additional_js'] ) ? json_decode( $doc_block['additional_js'], true ) : array(),
						'extra_allowed_tags' => isset( $doc_block['extra_allowed_tags'] ) ? json_decode( $doc_block['extra_allowed_tags'], true ) : array(),
					);
				}
			}
		}

		// Cache the results for 1 hour.
		set_transient( 'wp_component_viewer_components', $components, HOUR_IN_SECONDS );

		return $components;
	}

	/**
	 * Find component CSS file in build directory
	 *
	 * @param string $component_name The component name/slug.
	 * @return string|null CSS file path if found, null otherwise.
	 */
	private static function find_component_css( $component_name ) {
		$default_paths = self::get_scan_paths();
		// Replace the placeholder with the actual component name.
		$component_css_path = str_replace( '{{component_name}}', $component_name, $default_paths['css_build_path'] );
		$css_file_path      = get_template_directory() . $component_css_path;

		if ( file_exists( $css_file_path ) ) {
			return $component_css_path;
		}

		return null;
	}

	/**
	 * Find component JS file in build directory
	 *
	 * @param string $component_name The component name/slug.
	 * @return string|null JS file path if found, null otherwise.
	 */
	private static function find_component_js( $component_name ) {
		$default_paths = self::get_scan_paths();
		// Replace the placeholder with the actual component name.
		$component_js_path = str_replace( '{{component_name}}', $component_name, $default_paths['js_build_path'] );
		$js_file_path      = get_template_directory() . $component_js_path;

		if ( file_exists( $js_file_path ) ) {
			return $component_js_path;
		}

		return null;
	}

	/**
	 * Get paths to scan for components
	 *
	 * @return array
	 */
	private static function get_scan_paths() {
		/**
		 * Filter the scan paths for components
		 *
		 * @param array $paths Array of paths to scan.
		 */
		return apply_filters( 'wp_component_viewer_scan_paths', self::$default_paths );
	}

	/**
	 * Recursively scan directory for files
	 *
	 * @param string $dir       Directory to scan.
	 * @param array  $extensions File extensions to include.
	 * @param string $relative   Relative path.
	 * @return array
	 */
	private static function recursive_scan_dir( $dir, $extensions = array(), $relative = '' ) {
		$result = array();
		$dir    = rtrim( $dir, '/' );

		if ( ! is_dir( $dir ) ) {
			return $result;
		}

		$files = scandir( $dir );

		foreach ( $files as $file ) {
			if ( '.' === $file || '..' === $file ) {
				continue;
			}

			$file_path = $dir . '/' . $file;

			if ( is_dir( $file_path ) ) {
				$rel_path = $relative . ( $relative ? '/' : '' ) . $file;
				$result   = array_merge( $result, self::recursive_scan_dir( $file_path, $extensions, $rel_path ) );
			} elseif ( empty( $extensions ) || in_array( pathinfo( $file, PATHINFO_EXTENSION ), $extensions, true ) ) {
				$result[] = $relative . ( $relative ? '/' : '' ) . $file;
			}
		}

		return $result;
	}

	/**
	 * Clear component cache
	 *
	 * @return void
	 */
	public static function clear_cache() {
		delete_transient( 'wp_component_viewer_components' );
	}
}
