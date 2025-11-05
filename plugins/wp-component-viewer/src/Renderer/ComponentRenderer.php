<?php
/**
 * Component renderer
 *
 * @package WPComponentViewer\Renderer
 */

namespace WPComponentViewer\Renderer;

use WPComponentViewer\Scanner\ComponentScanner;

/**
 * ComponentRenderer class
 */
class ComponentRenderer {
	/**
	 * Render a component with props
	 *
	 * @param string $name  Component name.
	 * @param array  $props Component props.
	 * @return string
	 */
	public static function render( $name, $props = array() ) {
		$component_path = self::locate( $name );

		if ( ! $component_path ) {
			return sprintf( '<!-- Component "%s" not found -->', esc_html( $name ) );
		}

		// Extract props to make them available in the component file.
		$args = $props;

		ob_start();
		include $component_path;
		return ob_get_clean();
	}

	/**
	 * Find component file path
	 *
	 * @param string $name Component name.
	 * @return string|false
	 */
	public static function locate( $name ) {
		$components = ComponentScanner::scan_components();

		if ( isset( $components[ $name ] ) ) {
			return $components[ $name ]['file_path'];
		}

		// Fallback to searching in theme's components directory.
		$theme_dir = get_template_directory();
		$paths     = array(
			$theme_dir . '/components/' . $name . '.php',
			$theme_dir . '/components/' . $name . '/index.php',
			$theme_dir . '/partials/' . $name . '.php',
			$theme_dir . '/blocks/' . $name . '/block.php',
			$theme_dir . '/templates/' . $name . '.php',
		);

		foreach ( $paths as $path ) {
			if ( file_exists( $path ) ) {
				return $path;
			}
		}

		return false;
	}

	/**
	 * Render component example
	 *
	 * @param string $example Example code.
	 * @return string
	 */
	public static function render_example( $example ) {
		ob_start();
		eval( '?>' . $example );
		return ob_get_clean();
	}

	/**
	 * Render variations of a component
	 *
	 * @param string $name       Component name.
	 * @param array  $variations Variations data.
	 * @return array
	 */
	public static function render_variations( $name, $variations ) {
		$rendered = array();

		foreach ( $variations as $variation_name => $props ) {
			// Resolve dynamic props.
			$props = self::resolve_dynamic_props( $props );

			$rendered[ $variation_name ] = array(
				'name'   => $variation_name,
				'props'  => $props,
				'output' => self::render( $name, $props ),
			);
		}

		return $rendered;
	}

	/**
	 * Render component preview
	 *
	 * @param string $name       Component name.
	 * @param string $variation  Variation name.
	 * @return string
	 */
	public static function render_variation_preview( $name, $variation ) {
		$components = ComponentScanner::scan_components();

		if ( ! isset( $components[ $name ] ) ) {
			return sprintf( '<!-- Component "%s" not found -->', esc_html( $name ) );
		}

		if ( ! isset( $components[ $name ]['variations'] ) || ! is_array( $components[ $name ]['variations'] ) ) {
			return sprintf( '<!-- Component "%s" has no variations -->', esc_html( $name ) );
		}

		$component = $components[ $name ];
		$props     = isset( $components[ $name ]['variations'][ $variation ] ) ? $components[ $name ]['variations'][ $variation ] : array();

		if ( ! empty( $variation ) && isset( $component['variations'][ $variation ] ) ) {
			$props = array_merge( $props, $component['variations'][ $variation ] );
		}
		// Resolve dynamic props.
		$props = self::resolve_dynamic_props( $props );
		$html  = self::render( $name, $props );

		$extra_allowed_tags = $component['extra_allowed_tags'] ?? array();
		$allowed_tags       = wp_kses_allowed_html( 'post' );
		$allowed_tags       = array_replace_recursive( $allowed_tags, $extra_allowed_tags );

		echo wp_kses( $html, $allowed_tags );
	}

	/**
	 * Resolve dynamic placeholders in props, like @filter:filter_name
	 *
	 * @param mixed $input Props or value.
	 * @return mixed
	 */
	private static function resolve_dynamic_props( $input ) {
		if ( is_array( $input ) ) {
			foreach ( $input as $key => $value ) {
				$input[ $key ] = self::resolve_dynamic_props( $value );
			}
		} elseif ( is_string( $input ) ) {
			if ( str_starts_with( $input, 'filter:' ) ) {
				$filter_name = substr( $input, 7 );
				$input       = apply_filters( $filter_name, '' );
			}
		}

		return $input;
	}

	/**
	 * Get component source code
	 *
	 * @param string $name Component name.
	 * @return string
	 */
	public static function get_source_code( $name ) {
		$component_path = self::locate( $name );

		if ( ! $component_path ) {
			return '';
		}

		global $wp_filesystem;
		WP_Filesystem();

		if ( ! $wp_filesystem->exists( $component_path ) ) {
			return null;
		}

		$code = $wp_filesystem->get_contents( $component_path );
		return $code;
	}
}
