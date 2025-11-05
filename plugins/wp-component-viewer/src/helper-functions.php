<?php
/**
 * Helper functions for WP Component Viewer
 *
 * @package WPComponentViewer
 */

use WPComponentViewer\Renderer\ComponentRenderer;

if ( ! function_exists( 'get_component' ) ) {
	/**
	 * Render a component with props
	 *
	 * @param string $name  Component name.
	 * @param array  $props Component props.
	 * @return string
	 */
	function get_component( $name, $props = array() ) {
		return ComponentRenderer::render( $name, $props );
	}
}

if ( ! function_exists( 'locate_component' ) ) {
	/**
	 * Find component file path
	 *
	 * @param string $name Component name.
	 * @return string|false
	 */
	function locate_component( $name ) {
		return ComponentRenderer::locate( $name );
	}
}
