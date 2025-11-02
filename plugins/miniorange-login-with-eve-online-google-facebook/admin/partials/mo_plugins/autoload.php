<?php
/**
 * This file is part of miniOrange WP plugin.
 *
 * @package miniOrange
 * @author  miniOrange Security Software Pvt. Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if the autoloader is already registered to prevent duplicates.
if ( ! function_exists( 'mo_plugins_adv_classes_autoloader' ) ) {

	/**
	 * Autoload the files required for the advertisement framework.
	 *
	 * @param string $class The fully qualified class name.
	 *
	 * @return void
	 */
	function mo_plugins_adv_classes_autoloader( $class ) {
		$namespace = 'MO_Plugins';

		// Ensure the class belongs to the specified namespace.
		if ( strpos( $class, $namespace ) !== 0 ) {
			return;
		}

		$base_dir = __DIR__ . DIRECTORY_SEPARATOR . 'src';

		// Remove namespace, replace namespace separators with directory separators, and convert to lowercase.
		$relative_class = strtolower( str_replace( '\\', DIRECTORY_SEPARATOR, substr( $class, strlen( $namespace ) ) ) );

		// Extract the namespace class (last part of the class name).
		$namespace_class = strrchr( $relative_class, DIRECTORY_SEPARATOR );

		// Replace underscores with dashes and prepend 'class-' to create the filename.
		$final_class_name = 'class-' . str_replace( '_', '-', str_replace( DIRECTORY_SEPARATOR, '', $namespace_class ) ) . '.php';

		// Replace the namespace class with the final class name in the relative path.
		$relative_file_path = str_replace( $namespace_class, DIRECTORY_SEPARATOR . $final_class_name, $relative_class );

		// Construct the full file path.
		$file_path = $base_dir . $relative_file_path;

		// Include the file if it exists and the class isn't already defined.
		if ( file_exists( $file_path ) && ! class_exists( $class, false ) ) {
			include_once $file_path;
		}
	}

	// Register the autoloader function.
	spl_autoload_register( 'mo_plugins_adv_classes_autoloader' );
}
