<?php
/**
 * Autoloader file for plugin.
 *
 * @package WPComponentViewer
 */

namespace WPComponentViewer\Helpers;

/**
 * Autoloader for plugin classes.
 *
 * @param string $resource_namespace Fully-qualified class name.
 * @return void
 */
function autoloader( $resource_namespace = '' ) {
	$namespace_root = 'WPComponentViewer\\';

	// Bail if the namespace does not match the plugin root namespace.
	if ( ! is_string( $resource_namespace ) || strpos( $resource_namespace, $namespace_root ) !== 0 ) {
		return;
	}

	// Remove root namespace and normalize.
	$relative_class = substr( $resource_namespace, strlen( $namespace_root ) );
	$relative_class = str_replace( '_', '-', $relative_class ); // WordPress convention.

	$parts = explode( '\\', $relative_class );

	// Determine path.
	if ( count( $parts ) === 1 ) {
		$resource_path = 'src/' . $parts[0] . '.php';
	} else {
		$resource_path = 'src/' . implode( '/', $parts ) . '.php';
	}

	$full_path = WP_COMPONENT_VIEWER_PLUGIN_DIR . $resource_path;

	if ( file_exists( $full_path ) ) {
		require_once $full_path; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
	}
}

spl_autoload_register( '\WPComponentViewer\Helpers\autoloader' );
